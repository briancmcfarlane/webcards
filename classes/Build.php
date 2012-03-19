<?php

error_reporting(E_ALL ^ E_NOTICE);

class Build {

 // property: path to confirmation page
 public $redir = '';
 

public function __construct($dataFile) {
	 // bring in the global function for pretty-printing XML
	 include 'includes/xml-formatter.php';
	 
	 if (isset($_COOKIE["signup"])) {
 		 // merge the post data into the session data
		 // if there are identical keys the old value is replaced	 
		 session_start();
		 $_SESSION = array_merge($_SESSION,$_COOKIE);
		 
		 if (isset($_SESSION["email"])) {
			$this->redir = '/webcards/account/myaccount';	
				 
		 	// property: SimpleXML object
		 	$this->data = simplexml_load_file($dataFile);
		 
		 	// property: path to XML file
		 	$this->dataFilePath = $dataFile;
		 
		 	$this->saveData();
		 }
		 else {
			 $this->redir = '/webcards/signup/registration';	
		 }
		
		 // and redirect the user to the confirmation page
	 	 header("Location: $this->redir");

   }
}

// method: save data to disk
public function saveData() { 
    
          if (isset($_SESSION['index'])){
             
          $allCards = count($this->data->webcard);
             
          for ($x=0; $x<$allCards; $x++){
             
            if ($_SESSION['index'] == $x){
                unset($this->data->webcard[$x]);
            }
            
          }
        
         $xmlData = xmlPrettyPrint($this->data->asXML());
         file_put_contents($this->dataFilePath, $xmlData);
            
         }
	 // add SimpleXML nodes for the new account
	 $newAcct = $this->data->addChild('webcard');
 	 $newAcct->addChild('user', $_SESSION['email']);
	 $newAcct->addChild('txtstyle', $_SESSION['font']);
	 $newAcct->addChild('bordr', $_SESSION['border']);
	 $newAcct->addChild('recipient', $_SESSION['recipient']);
	 $newAcct->addChild('message', $_SESSION['message']);
	 $newAcct->addChild('sender', $_SESSION['sender']);
	 
	 // format the data for easy reading
	 $xmlData = xmlPrettyPrint($this->data->asXML());
	 
	 // save the account data back to the XML file
	 file_put_contents($this->dataFilePath, $xmlData);
         
         unset($_SESSION['index']);
         unset($_SESSION['font']);
         unset($_SESSION['border']);
         unset($_SESSION['recipient']);
         unset($_SESSION['message']);
         unset($_SESSION['sender']);
	 
	 setcookie("signup", "", time()-3600);
}

    public function markFont($fontValue){
    
        if ($fontValue === $_SESSION['font']){
            return 'checked';
        }
        
        else {return "";}
    
    }
}

?>
