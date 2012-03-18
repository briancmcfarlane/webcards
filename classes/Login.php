<?php

// suppress notices, since some variables will not be set
error_reporting(E_ALL ^ E_NOTICE);

class Login {

 // property: path to confirmation page
 public $redir = '/webcards/account/myaccount';
 
 // property: user name
 public $name = '';

 // method called when object instantiated
 // pass it the path to the XML file
 public function __construct($dataFile) {

   // determine if timeout occurred and display a notification message
   if ($_GET['timeout'] === 'y') {
    $this->logout_msg = '<p><strong>You were logged out due to inactivity.
                             Please login again.</strong></p>';
   }

   // determine if logout occurred and display a notification message
   if ($_GET['logout'] === 'y') {

    $this->logout_msg = '<p><strong>You have been logged out.</strong></p>';

   }

   // check to see if the hidden variable is set
   if ($_POST['submitted'] === 'y') {

     // property: SimpleXML object
     $this->data = simplexml_load_file($dataFile);

     // call the method to determine errors
     $this->theErrors = $this->checkForErrors();

     // if errors were found output them
     // otherwise redirect to the confirmation page
     if ($this->theErrors) {
		 $this->outputErrors();
	 }
	 else {
	 	$this->allowIn();
	   	
		// redirect the user to the confirmation page
	   	header("Location: $this->redir");
   		exit;
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
  // and test for a match
  else {

    $_POST['email'] = trim($_POST['email']);

    $allAccts = count($this->data->acct);

    for ($x=0; $x<$allAccts; $x++) {

      if ((string)$this->data->acct[$x]->email === $_POST['email']) {
         // store the numerical index of the matching account
         $recordToUse = $x;
      }

    }

    // display an error message if the account cannot be found
    if (empty($recordToUse)) {

      $errors[] = "No account exists for the <em>{$_POST['email']}</em> address.";

    }
	else {
		$this->name = (string)$this->data->acct[$recordToUse]->name;
	}
	

  }

  // this block of code deals with the password
  // if the user neglected to enter the password then trigger an error
  if (empty($_POST['pwd'])) {
     $errors[] = 'Please enter your password.';
  }

  // clean up empty spaces and check for a match
  else {

     $_POST['pwd'] = trim($_POST['pwd']);
     $encodedPwd = sha1($_POST['pwd'] . $_POST['email']);

     if ($encodedPwd === (string)$this->data->acct[$recordToUse]->password) {
        // set a flag so we know the password matched
        $matchFound = true;
     }

     else {
        $errors[] = 'Password is not correct.  Please try to enter the password again.';
     }

  }

  return $errors;

 }

 public function outputErrors() {

   $this->error_msg = '<p><strong>Please correct the following issues
                       and re-submit the form.</strong></p>';
   $this->error_msg .= '<ul><li>' . implode('</li><li>',$this->theErrors) . '</li></ul>';

 }

 public function allowIn() {

   // start the session and set session variables for email (used in later file name),
   // authentication, start time, and timeout (30 minutes)
   session_start();
   $_SESSION['email'] = $_POST['email'];
   $_SESSION['auth'] = 'y';
   $_SESSION['time'] = time();
   $_SESSION['timeout'] = 1800;
   $_SESSION['name'] = $this->name;

	// allowIn function is also used by the registration page to automatically log
	// the user in once they create an account.     
   if (isset($_SESSION["signup"])) {
	   $this->redir  = '/webcards/build';
	   header("Location: $this->redir");
	   exit;
	}
	
 }

}

?>