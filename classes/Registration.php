<?php

// suppress notices, since some variables will not be set
error_reporting(E_ALL ^ E_NOTICE);

require 'Login.php';
require_once 'ErrorCheck.php';

class Registration {

 // property: path to confirmation page
 public $redir = '/webcards/signup/success';

 // method called when object instantiated
 // pass it the path to the XML file
 public function __construct($dataFile) {

   // bring in the global function for pretty-printing XML
   include 'includes/xml-formatter.php';

   // check to see if the hidden variable is set
   if ($_POST['submitted'] === 'y') {

     // property: SimpleXML object
     $this->data = simplexml_load_file($dataFile);

     // property: path to XML file
     $this->dataFilePath = $dataFile;

     // call the method to determine errors
     $this->error_msg = $this->checkForErrors();

     // if errors were found output them
     // otherwise establish an account
     if (!$this->error_msg) {
		 $this->createAcct();
		 
		 // and redirect the user to the confirmation page
		 header("Location: $this->redir");
	 }
   }
}

 // method: construct an array of error messages and return that array
 public function checkForErrors() {
	 
	$check = new ErrorCheck();
   
	$_POST['name_error'] = $check->containsData($_POST['name'], 'your name');
	$_POST['email_error'] = $check->validEmail($_POST['email']);
	$_POST['psswd_error'] = $check->containsData($_POST['password'], 'a password');
	$_POST['psswd_error'] = $check->containsData($_POST['confirmpassword'], 'a password');
	$check->containsData($_POST['plan'], '');   	

  // this block of code deals with the email address
  // if it is not set, output the proper error
  	if (empty($_POST['email_error'])) {
    	
		$_POST['email'] = trim($_POST['email']);
        $_POST['email'] = strtolower($_POST['email']);
		$allAccts = count($this->data->acct);

      	for ($x=0; $x<$allAccts; $x++) {

        	if ((string)$this->data->acct[$x]->email === $_POST['email']) {
           		$acctExists = true;
        	}
		}

      	if ($acctExists) {
	    	$_POST['email_error'] = 'Email already in use.';
			$check->externalError();
      	}
	}
	
	if (empty($_POST['psswd_error'])) {

	    // if they were entered and do not match, output an error
    	if ($_POST['password'] !== $_POST['confirmpassword']) {
    		$_POST['psswd_error']  = 'Passwords do not match.';
	  		$check->externalError();
    	}

	    // clean up empty spaces and check for proper formatting, outputting error messages
	    else {
	    	$_POST['password'] = trim($_POST['password']);
      		$numCharacters = strlen($_POST['password']);
      		
			if ($numCharacters < 7) {
        	$_POST['psswd_error'] = 'Password is too short.';
			$check->externalError();
      		}
			elseif (!preg_match('/[a-z]/', $_POST['password']) ||
          			!preg_match('/[A-Z]/', $_POST['password']) ||
          			!preg_match('/[0-9]/', $_POST['password'])) {
            $_POST['psswd_error'] = 'Enter a valid password.';
			$check->externalError();
      		}
    	}
	}    
	return $check->outputErrors(); 
}

public function createAcct() {

   // encrypt a combination of the password and the email address
   // so that a hacker would have even more difficulty decrypting it
   $formattedEmail = strtolower($_POST['email']);
   $encodedPwd = sha1($_POST['password'] . $formattedEmail);

   // add SimpleXML nodes for the new account
   $newAcct = $this->data->addChild('acct');
   $newAcct->addChild('email', $formattedEmail);
   $newAcct->addChild('password', $encodedPwd);
   $newAcct->addChild('name', $_POST['name']);
   $newAcct->addChild('plan', $_POST['plan']);
   $newAcct->addChild('isAdmin', 'false');

   // format the data for easy reading
   $xmlData = xmlPrettyPrint($this->data->asXML());

   // save the account data back to the XML file
   file_put_contents($this->dataFilePath, $xmlData);
   
   $reg = new Login('access.xml');
   $reg->allowIn();
}

}

?>
