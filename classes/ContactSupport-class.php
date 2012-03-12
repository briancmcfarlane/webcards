<?php

// suppress notices, since some variables will not be set
error_reporting(E_ALL ^ E_NOTICE);

class ContactSupport {

 // property: path to confirmation page
 public $redir = '?p=support-thankyou';

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
		 $this->createMsg();
		 
		 // and redirect the user to the confirmation page
		 header("Location: $this->redir");
	 }

   }

 }

 // method: construct an array of error messages and return that array
 public function checkForErrors() {

  // this will hold our error messages
  $errors = array();
  
    if  (empty($_POST['first_name'])){
        $errors[] = 'Please enter your first name.';
    }
    
 	if  (empty($_POST['last_name'])){
        $errors[] = 'Please enter your last name.';
    }


  // this block of code deals with the email address
  // if it is not set, output the proper error
  if  (empty($_POST['email'])){
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
      
      $_POST['email'] = strtolower($_POST['email']);

    }
  }
       
    if  (empty($_POST['subject'])){
        $errors[] = 'Please enter the subject number.';
    }
    
    if  (empty($_POST['message'])){
        $errors[] = 'Please enter your message.';
    }

  return $errors;

 }

 public function outputErrors() {

   $this->error_msg = '<p><strong>Please correct the following issues
                       and re-submit the form.</strong></p>';
   $this->error_msg .= '<ul><li>' . implode('</li><li>',$this->theErrors) . '</li></ul>';

 }

 public function createMsg() {

   // encrypt a combination of the password and the email address
   // so that a hacker would have even more difficulty decrypting it
   $formattedEmail = strtolower($_POST['email']);
   $fullName =  $_POST['first_name'] . ' ' . $_POST['last_name'];


   // add SimpleXML nodes for the new support request
   $newAcct = $this->data->addChild('msg');
   $newAcct->addChild('email', $formattedEmail);
   $newAcct->addChild('name', $fullName);
   $newAcct->addChild('subject', $_POST['subject']);
   $newAcct->addChild('message', $_POST['message']);

   // format the data for easy reading
   $xmlData = xmlPrettyPrint($this->data->asXML());

   // save the account data back to the XML file
   file_put_contents($this->dataFilePath, $xmlData);
   

 }

}

?>
