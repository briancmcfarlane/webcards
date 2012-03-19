<?php

class AccountImporter{
    
    public function __construct($acctFile,$webcardFile) {
        
        include_once 'includes/xml-formatter.php';

        unset($_SESSION['index']);
        unset($_SESSION['font']);
        unset($_SESSION['border']);
        unset($_SESSION['recipient']);
        unset($_SESSION['message']);
        unset($_SESSION['sender']);
        
        $this->accountDataFilePath = $acctFile;
        $this->webcardDataFilePath = $webcardFile;
        $this->accountData = simplexml_load_file($acctFile);
        $this->webcardData = simplexml_load_file($webcardFile);
        $this->accountDetails = $this->loadUserAccount();
        $this->webcardForm = $this->loadUsersCards();
        
        if ($_POST['alterAccount'] === 'y'){
            
           $this->theErrors = $this->checkForErrors();
           
           if ($this->theErrors) {
				$this->outputErrors();
			}
           else {
				$this->alterAccountDetails();
			}

        }
        
        if ($_POST['manageCards'] === 'y' && isset($_POST['card'])){
            
            if ($_POST['btn'] === 'Delete Card'){
                $this->deleteCard();
            }
            
            if ($_POST['btn'] === 'Send Card'){
                $this->sendCard();
            }
            
            if ($_POST['btn'] === 'Edit Card'){
                $this->editCard();
            }
        }
        
    }
    
    public function loadUserAccount(){
        
        $allAccounts = count($this->accountData->acct);
        $emailLoc = $_POST['postVal'];
        
        for ($x=1; $x<$allAccounts; $x++){
			if(empty($_POST['postVal'])){
				if ((string)$this->accountData->acct[$x]->email === $_SESSION['email']){
				$acctToLoad = $this->accountData->acct[$x];
				}
			}
			else{
					$acctToLoad = $this->accountData->acct[$emailLoc-1];
				}
			
        }
        return $acctToLoad;
    }
    
    private function checkForErrors(){

    // this will hold our error messages
    $errors = array();

    // this block of code deals with the email address
    // if it is not set, output the proper error
    if (empty($_POST['email'])) {
        $errors[] = 'Please enter an email address.';
    }

    // if it is set, remove empty spaces on the ends
     // and test for proper format
     else {

        $_POST['email'] = trim($_POST['email']);
        if (!preg_match('/^[^@\s]+@([-a-z0-9]+\.)+[a-z]{2,}$/i', $_POST['email'])) {
            $errors[] = 'Please provide a valid e-mail address.';
        }

        // if the format checks out then see if the account already exists
        // if it already exists, output the proper error
     else {

        $acctExists = false;
      
        $_POST['email'] = strtolower($_POST['email']);

        for ($x=1, $allAccts=count($this->accountData->acct); $x<$allAccts; $x++) {

            if ((string)$this->accountData->acct[$x]->email === $_POST['email'] && (string)$this->accountData->acct[$x]->email != $this->accountDetails->email ) {
            $acctExists = true;
            }

        }

        if ($acctExists) {

        $errors[] = 'An account has already been established for that address.
Enter another email address.';

        }

    }

    // this block of code deals with the password
    // if the user neglected to enter either the password or confirmation
    // then trigger an error
    if (empty($_POST['password']) || empty($_POST['confirmpassword'])) {
      $errors[] = 'Please provide a password and then re-confirm the password.';
    }

    // if they were entered and do not match, output an error
    elseif ($_POST['password'] !== $_POST['confirmpassword']) {
      $errors[] = 'Passwords do not match.';
    }

    // clean up empty spaces and check for proper formatting, outputting error messages
    else {

      $_POST['password'] = trim($_POST['password']);
      $numCharacters = strlen($_POST['password']);
      if ($numCharacters < 7) {
         $errors[] = 'Password does not meet length requirements.';
      }
      if (!preg_match('/[a-z]/', $_POST['password']) ||
          !preg_match('/[A-Z]/', $_POST['password']) ||
          !preg_match('/[0-9]/', $_POST['password'])) {
            $errors[] = 'Password is not formatted properly.';
      }

    }
    
    if (empty($_POST['name'])){
        $errors[] = 'Please enter your name.';
    }
    
    if (empty($_POST['plan'])){
        $errors[] = 'Please select a subscription plan.';
    }
    
   }

  return $errors;

 }
 
    public function outputErrors() {

   $this->error_msg = '<p><strong>Please correct the following issues
and re-submit the form.</strong></p>';
   $this->error_msg .= '<ul><li>' . implode('</li><li>',$this->theErrors) . '</li></ul>';

 }
 
    private function alterAccountDetails(){
        
         $allAccounts = count($this->accountData->acct);
        
        for ($x=1; $x<$allAccounts; $x++){
            if ((string)$this->accountData->acct[$x]->email === $_SESSION['email']){
                $acctToAlter = $this->accountData->acct[$x];
            }
        }
        
        $formattedEmail = strtolower($_POST['email']);
        $encodedPwd = sha1($_POST['password'] . $formattedEmail);
        
        unset($acctToAlter->email);
        unset($acctToAlter->password);
        unset($acctToAlter->name);
        unset($acctToAlter->plan);
        
        $acctToAlter->addChild('email', $formattedEmail);
        $acctToAlter->addChild('password', $encodedPwd);
        $acctToAlter->addChild('name', $_POST['name']);
        $acctToAlter->addChild('plan',$_POST['plan']);
        
        $xmlData = xmlPrettyPrint($this->accountData->asXML());

        file_put_contents($this->accountDataFilePath, $xmlData);
        
        $this->convertWebCardsToNewUser($formattedEmail);
    }
    
    public function loadUsersCards(){
        
        $allCards = count($this->webcardData->webcard);

        $form = '<form method="post" action=""><table border="1"><thead><tr><th></th><th>Sender</th><th>Recipient</th><th>Text Style</th><th>Border</th><th>Message</th></tr></thead><tbody>';

        for ($x=0; $x<$allCards; $x++) {
		
		if(empty($_POST['postVal'])){
			if ((string)$this->webcardData->webcard[$x]->user === $_SESSION['email']) {
				$form .= '<tr>';
				$form .= '<td><input type="radio" name="card" value="'.$x.'"></td>';
				$form .= '<td>' . $this->webcardData->webcard[$x]->sender . '</td>';
				$form .= '<td>' . $this->webcardData->webcard[$x]->recipient . '</td>';
				$form .= '<td>' . $this->webcardData->webcard[$x]->txtstyle . '</td>';
				$form .= '<td>' . $this->loadBorderGraphic($this->webcardData->webcard[$x]->bordr) . '</td>';
				$form .= '<td>' . $this->webcardData->webcard[$x]->message . '</td>';
				$form .= '</tr>';
			}
		}
		
		elseif((string)$this->webcardData->webcard[$x]->user === (string)$this->accountDetails->email){
				$form .= '<tr>';
				$form .= '<td><input type="radio" name="card" value="'.$x.'"></td>';
				$form .= '<td>' . $this->webcardData->webcard[$x]->sender . '</td>';
				$form .= '<td>' . $this->webcardData->webcard[$x]->recipient . '</td>';
				$form .= '<td>' . $this->webcardData->webcard[$x]->txtstyle . '</td>';
				$form .= '<td>' . $this->loadBorderGraphic($this->webcardData->webcard[$x]->bordr) . '</td>';
				$form .= '<td>' . $this->webcardData->webcard[$x]->message . '</td>';
				$form .= '</tr>';
		}
		
        }
        
        $form .= '</tbody></table><br /><input type="hidden" name="manageCards" value="y" /><input type="submit" name="btn" value="Delete Card"/>&nbsp;<input type="submit" name="btn" value="Send Card"/>&nbsp;<input type="submit" name="btn" value="Edit Card"/></form>';
        
        return $form;
    
    }
    
    private function loadBorderGraphic($bordrAlt){
        
        switch ($bordrAlt){
            case "Dentist Appt. A Border Image":
                return "<img src=\"images/theme-dentist-a.png\" alt=\"Dentist Appt. A Border Image\"/>";
                break;
            case "Dentist Appt. B Border Image":
                return "<img src=\"images/theme-dentist-b.png\" alt=\"Dentist Appt. B Border Image\"/>";
                break;
            case "Open House A Border Image":
                return "<img src=\"images/theme-house-a.png\" alt=\"Open House A Border Image\"/>";
                break;
            case "Open House B Border Image":
                return "<img src=\"images/theme-house-b.png\" alt=\"Open House B Border Image\"/>";
                break;
            case "Vet Appt. A Border Image";
                return "<img src=\"images/theme-pet-a.png\" alt=\"Vet Appt. A Border Image\"/>";
                break;
            case "Vet Appt. B Border Image";
                return "<img src=\"images/theme-pet-b.png\" alt=\"Vet Appt. B Border Image\"/>";
                break;
            case "Valentine's Day A Border Image";
                return "<img src=\"images/theme-vd-a.png\" alt=\"Valentine's Day A Border Image\"/>";
                break;
            case "Valentine's Day B Border Image";
                return "<img src=\"images/theme-vd-b.png\" alt=\"Valentine's Day B Border Image\"/>";
                break;
        }
    }
    
    private function convertWebCardsToNewUser(){
        
        $formattedEmail = strtolower($_POST['email']);
        $allCards = count($this->webcardData->webcard);
        
         for ($x=0; $x<$allCards; $x++){
             
            if ((string)$this->webcardData->webcard[$x]->user === $_SESSION['email']){
                unset($this->webcardData->webcard[$x]->user);
                $this->webcardData->webcard[$x]->addChild('user', $formattedEmail);
            }
            
        }
        
        $xmlData = xmlPrettyPrint($this->webcardData->asXML());

        file_put_contents($this->webcardDataFilePath, $xmlData);
     
        
        $this->setNewSessionVars();
    }
    
    private function setNewSessionVars(){
        
        $formattedEmail = strToLower($_POST['email']);
        
        $_SESSION['email'] = $formattedEmail;
        $_SESSION['auth'] = 'y';
        $_SESSION['time'] = time();
        $_SESSION['timeout'] = 1800;
        $_SESSION['name'] = $_POST['name'];

    }

    private function deleteCard(){
        
        $allCards = count($this->webcardData->webcard);
        
         for ($x=0; $x<$allCards; $x++){
             
            if ($_POST['card'] == $x){
                unset($this->webcardData->webcard[$x]);
            }
            
         }
        
        $xmlData = xmlPrettyPrint($this->webcardData->asXML());
        file_put_contents($this->webcardDataFilePath, $xmlData);
        
        $this->webcardForm = $this->loadUsersCards();
    
    }
    private function sendCard(){}
    
    private function editCard(){
        
        $allCards = count($this->webcardData->webcard);
        
         for ($x=0; $x<$allCards; $x++){
             
            if ($_POST['card'] == $x){
                
                $index = $x;
                $txtstyle = $this->webcardData->webcard[$x]->txtstyle->asXML();
                $txtstyle = strip_tags($txtstyle);
                $recipient = $this->webcardData->webcard[$x]->recipient->asXML();
                $recipient = strip_tags($recipient);
                $message = $this->webcardData->webcard[$x]->message->asXML();
                $message = strip_tags($message);
                $sender = $this->webcardData->webcard[$x]->sender->asXML();
                $sender = strip_tags($sender);
            }
            
         }
         
         $_SESSION['index'] = $index;
         $_SESSION['recipient'] = $recipient;
         $_SESSION['message'] = $message;
         $_SESSION['sender'] = $sender;         
        
         $redir = '../build/';
         header("Location: $redir");
    }

}

?>
