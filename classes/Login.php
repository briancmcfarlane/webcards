<?php

// suppress notices, since some variables will not be set
error_reporting(E_ALL ^ E_NOTICE);

require_once 'ErrorCheck.php';


class Login {

// property: path to confirmation page
public $redir = '/webcards/account/myaccount';
 
// property: user name
public $name = '';

public $storedRecord = '';

// method called when object instantiated
// pass it the path to the XML file
public function __construct($dataFile) {
	
	// starting session so that header retains user info if they somehow end on 
	//login page by mistake
	session_start();

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
     	$this->error_msg = $this->checkForErrors();

     	// if errors were found output them
     	// otherwise redirect to the confirmation page
     	if (!$this->error_msg) {
			$this->allowIn();
	   	
			// redirect the user to the confirmation page
	   		header("Location: $this->redir");
	 	}
	}
}

// method: construct an array of error messages and return that array
public function checkForErrors() {
	
	$check = new ErrorCheck();
   
	$_POST['email_error'] = $check->validEmail($_POST['email']);
	$_POST['psswd_error'] = $check->containsData($_POST['pwd'], 'a password');   
	
  	// this block of code deals with the email address
  	// if it is not set, output the proper error
  	if (empty($_POST['email_error'])) {
    	
    	$_POST['email'] = trim($_POST['email']);
        $_POST['email'] = strtolower($_POST['email']);
		$allAccts = count($this->data->acct);

    	for ($x=0; $x<$allAccts; $x++) {
			
			if ((string)$this->data->acct[$x]->email === $_POST['email']) {
				$this->storedRecord = $recordToUse = $x;
				// store the numerical index of the matching account
		 		//adding 1 because if it is the first entry in the array empty returns true
         		$recordToUse = $x+1;
			}
   	}

    	// display an error message if the account cannot be found
    	if (empty($recordToUse)) {

      		$_POST['email_error'] = "No account exists for the <em>{$_POST['email']}</em> address.";
			$_POST['psswd_error'] = "";
			$check->externalError();
    	}
		
		else {
			
			//subtracting 1 to find real entry number
			$recordToUse = $recordToUse - 1;
			$this->name = (string)$this->data->acct[$recordToUse]->name;
		
  			// this block of code deals with the password
  			// if the user neglected to enter the password then trigger an error
			if (empty($_POST['psswd_error'])) {
     			$_POST['pwd'] = trim($_POST['pwd']);
     			$encodedPwd = sha1($_POST['pwd'] . $_POST['email']);

		     	if ($encodedPwd !== (string)$this->data->acct[$recordToUse]->password) {
        			$_POST['psswd_error'] = 'Incorrect password';
					$check->externalError();
     			}
			}
		}
	}
	
	return $check->outputErrors(); 
}

public function allowIn() {

   	// set session variables for email (used in later file name),
   	// authentication, start time, and timeout (30 minutes)
   	$_SESSION['email'] = $_POST['email'];
   	$_SESSION['auth'] = 'y';
   	$_SESSION['time'] = time();
   	$_SESSION['timeout'] = 1800;
   	$_SESSION['name'] = $this->name;
    
    // admin session
    $_SESSION['isAdmin'] = (string)$this->data->acct[$this->storedRecord]->isAdmin;

	// allowIn function is also used by the registration page to automatically log
	// the user in once they create an account.     
   	if (isset($_SESSION["signup"])) {
	   $this->redir = '/webcards/build';
	   	header("Location: $this->redir");
	   	exit;
	}
        
        if ($_SESSION['isAdmin'] === 'True'){
            $this->redir = '/webcards/admin/admin';
            header("Location: $this->redir");
            exit;
        }
}

}

?>
