<?php

// suppress notices, since some variables will not be set
error_reporting(E_ALL ^ E_NOTICE);

require 'ErrorCheck.php';
   
class ContactSupport {
 
// property: path to confirmation page
public $redir = '/webcards/contact/thankyou';

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

	$this->error_msg = $this->checkForErrors();

	// if errors were found output them
	// otherwise establish an account
    if (!$this->error_msg) {
		$this->createMsg();
		 
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
	$_POST['subj_error'] = $check->containsData($_POST['subject'], 'the subject');       
	$_POST['msg_error'] = $check->containsData($_POST['message'], 'a message');   
	
	return $check->outputErrors(); 
}

public function createMsg() {

	// encrypt a combination of the password and the email address
   	// so that a hacker would have even more difficulty decrypting it
   	$formattedEmail = strtolower($_POST['email']);

   	// add SimpleXML nodes for the new support request
   	$newAcct = $this->data->addChild('msg');
   	$newAcct->addChild('email', $formattedEmail);
   	$newAcct->addChild('name', $_POST['name']);
   	$newAcct->addChild('subject', $_POST['subject']);
   	$newAcct->addChild('message', $_POST['message']);

   	// format the data for easy reading
   	$xmlData = xmlPrettyPrint($this->data->asXML());

   	// save the account data back to the XML file
   	file_put_contents($this->dataFilePath, $xmlData);
}

}

?>
