<?php

// suppress notices, since some variables will not be set
error_reporting(E_ALL ^ E_NOTICE);

class ErrorCheck {

public	$errs = '';

public function containsData($field, $errMsg) {
	if  (empty($field)){
    	$msg = 'Please enter ' . $errMsg . '.';
		$this->errs = 'y';
		return $msg;
	}
	else {
	    if (preg_match('*[\*\$\+\=\\\/]*', $field)) {
	    	$msg = 'Please remove any *, $, +, /, \\.';
			$this->errs = 'y';
			return $msg;
	    }
	}
}

public function validEmail($email) {
	if  (empty($email)){
    	$msg = 'Please enter your email.';
		$this->errs = 'y';
		return $msg;
	}
	else {
		$email = trim($email);
	    if (!preg_match('/^[^@\s]+@([-a-z0-9]+\.)+[a-z]{2,}$/i', $email)) {
	    	$msg = 'Please enter a valid email.';
			$this->errs = 'y';
			return $msg;
	    }
	}
}

public function externalError() {
	$this->errs = 'y';
}

public function outputErrors() {
	if ($this->errs)
	{
		$error_msg = '<div><p class="error"><strong>Please correct the following issues
    		                   and re-submit the form.</strong></p></div>';
		return $error_msg;
	}
}

}

?>
