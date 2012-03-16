<?php

error_reporting(E_ALL ^ E_NOTICE);

require 'classes/ValidateSession-class.php';
$checkSession = new ValidateSession();


$this->title = <<<_pageTitle_
        WebCards: Support
_pageTitle_;

$this->content = <<<_pageContent_
    <h3>Your Account</h3>
	<p>One day this will be your account page.</p>
	
	<p><a href="/webcards/account/logout">Logout</a></p>


_pageContent_;

$this->localNav = <<<_localNav_
        
_localNav_;
?>


