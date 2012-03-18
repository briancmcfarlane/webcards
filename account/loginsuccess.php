<?php

error_reporting(E_ALL ^ E_NOTICE);

require 'classes/ValidateSession.php';
$checkSession = new ValidateSession();
 
$this->title = <<<_pageTitle_
        WebCards: Login Success
_pageTitle_;

$this->content = <<<_pageContent_
<h2>Login Successful</h2>
<p>Congratulations!  You have logged in successfully.</p>

<p><a href="/webcards/account/logout">Logout</a></p>

_pageContent_;

$this->localNav = <<<_localNav_
        
_localNav_;
?>


