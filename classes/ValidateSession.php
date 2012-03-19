<?php

error_reporting(E_ALL ^ E_NOTICE);


class ValidateSession {
// property: path to login page
public $redir = '/webcards/account/login';

// most of the time we are not logging out
// so set that flag to false by default
public function __construct($logout = false) {
	
	// determine the current time in seconds since the Epoch
	$this->now = time();

	// load the session
	session_start();

	//Validate Session is called on everypage for the header
	//Login is not required to view the whole site so we must 
	//check to see if the user has even tried to login yet
	if (isset ($_SESSION['email'])) {

		// determine if timeout has occurred
		// or logout has occurred
		if ($this->now > $_SESSION['time'] + $_SESSION['timeout']) {

			$this->removeSession();
	
			// redirect to the login page with a flag for the timeout
			$this->doRedirect('?timeout=y');
		}
		
		// check to see if logout has occurred
		elseif ($logout) {
				
			$this->removeSession();
		
			// redirect to the login page with a flag for the logout
			$this->doRedirect();
		}
	
		// otherwise just reset the clock
		else {
	
			// all is well; reset the timer
			$_SESSION['time'] = $this->now;
		}
	}
}

public function checkAuthorization() {
	if(empty($_SESSION['auth'])) {
		$this->doRedirect();
	}   
}

public function doRedirect() {
	header("Location: {$this->redir}");
   	exit;
}

public function removeSession() {

	// empty the session super global array
   	$_SESSION = array();

   	// wipe the session cookie
   	if (!empty($_COOKIE[session_name()])) {
   		setcookie(session_name(), '', time() - 60*60*24, '/');
   	}

	// end the session
   	session_destroy();
}

public function checkIfAdmin() {
	if(empty($_SESSION['isAdmin'])) {
		$this->doRedirect();
	}

    }
}
?>
