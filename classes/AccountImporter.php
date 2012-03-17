<?php

class AccountImporter{
    
    public function __construct($acctFile,$webcardFile) {
        
        include_once 'includes/xml-formatter.php';
        
        $this->accountDataFilePath = $acctFile;
        
        $this->webcardDataFilePath = $webcardFile;
        
        $this->accountData = simplexml_load_file($acctFile);
        
        $this->webcardData = simplexml_load_file($webcardFile);
 
        $this->accountDetails = $this->loadUserAccount();
        
        $this->webcardTable = $this->loadUsersCards();
        
        if ($_POST['submitted'] === 'y'){
            $this->alterAccountDetails();
        }
        
    }
    
    public function loadUserAccount(){
        
        $allAccounts = count($this->accountData->acct);
        
        for ($x=1; $x<$allAccounts; $x++){
            if ((string)$this->accountData->acct[$x]->email === $_SESSION['email']){
                $acctToLoad = $this->accountData->acct[$x];
            }
        }
        return $acctToLoad;
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
        unset($acctToAlter->ccnumber);
        unset($acctToAlter->plan);
        
        $acctToAlter->addChild('email', $formattedEmail);
        $acctToAlter->addChild('password', $encodedPwd);
        $acctToAlter->addChild('name', $_POST['name']);
        $acctToAlter->addChild('ccnumber', $_POST['ccnumber']);
        $acctToAlter->addChild('plan',$_POST['plan']);
        
        $xmlData = xmlPrettyPrint($this->accountData->asXML());

        file_put_contents($this->accountDataFilePath, $xmlData);
        
        $this->convertWebCardsToNewUser($formattedEmail);
    }
    
    public function loadUsersCards(){
        
        $allCards = count($this->webcardData->webcard);
        
        $table = '<table border="1"><thead><tr><th>Sender</th><th>Recipient</th><th>Text Style</th><th>Border</th><th>Message</th></tr></thead><tbody>';

        for ($x=1; $x<$allCards; $x++) {

        if ((string)$this->webcardData->webcard[$x]->user === $_SESSION['email']) {
            $table .= '<tr>';
            $table .= '<td>' . $this->webcardData->webcard[$x]->sender . '</td>';
            $table .= '<td>' . $this->webcardData->webcard[$x]->recipient . '</td>';
            $table .= '<td>' . $this->webcardData->webcard[$x]->txtstyle . '</td>';
            $table .= '<td>' . $this->webcardData->webcard[$x]->bordr . '</td>';
            $table .= '<td>' . $this->webcardData->webcard[$x]->message . '</td>';
            $table .= '</tr>';
        }

        }
        
        $table .= '</tbody></table>';
        
        return $table;
    
    }
    
    private function convertWebCardsToNewUser(){
        
        $formattedEmail = strtolower($_POST['email']);
        $allCards = count($this->webcardData->webcard);
        
         for ($x=1; $x<$allCards; $x++){
             
            if ((string)$this->webcardData->webcard[$x]->user === $_SESSION['email']){
                unset($this->webcardData->webcard[$x]->user);
                $this->webcardData->webcard[$x]->addChild('user', $formattedEmail);
            }
            
        $xmlData = xmlPrettyPrint($this->webcardData->asXML());

        file_put_contents($this->webcardDataFilePath, $xmlData);
            
        }
     
        
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


}

?>
