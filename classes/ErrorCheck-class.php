<?php

class ErrorCheck {

public	$err = array();

public function containsData($field, $errMsg) {
	if  (empty($field)){
    	$this->err[] = 'Please enter ' . $errMsg . '.';
	}
}

public function validEmail($email) {
	if  (empty($email)){
    	$this->err[] = 'Please enter your email address.';
	}
	else {
		$email = trim($email);
	    if (!preg_match('/^[^@\s]+@([-a-z0-9]+\.)+[a-z]{2,}$/i', $email)) {
	    	$this->err[] = 'Please provide a valid e-mail address.';
	    }
		else {
			$email = strtolower($email);	
		}
	}
	return $email;
}

public function outputErrors() {
	if ($this->err)
	{
		$error_msg = '<p><strong>Please correct the following issues
    		                   and re-submit the form.</strong></p>';
		$error_msg .= '<ul><li>' . implode('</li><li>',$this->err) . '</li></ul>';
		return $error_msg;
	}
}

}

?>
