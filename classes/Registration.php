<?php

// suppress notices, since some variables will not be set
error_reporting(E_ALL ^ E_NOTICE);
require 'Login.php';

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
     $this->theErrors = $this->checkForErrors();

     // if errors were found output them
     // otherwise establish an account
     if ($this->theErrors) {
		 $this->outputErrors();
	 }
	 else {
		 $this->createAcct();
		 
		 // and redirect the user to the confirmation page
		 header("Location: $this->redir");
	 }

   }

 }

 // method: construct an array of error messages and return that array
 public function checkForErrors() {

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

      for ($x=0, $allAccts=count($this->data->acct); $x<$allAccts; $x++) {

        if ((string)$this->data->acct[$x]->email === $_POST['email']) {
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
    
    if (empty($_POST['ccnumber'])){
        $errors[] = 'Please enter your credit card number.';
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
   $newAcct->addChild('ccnumber', $_POST['ccnumber']);
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
