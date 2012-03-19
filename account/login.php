<?php
error_reporting(E_ALL ^ E_NOTICE);

require 'classes/ValidateSession.php';
$checkSession = new ValidateSession();

require 'classes/Login.php';
$reg = new Login('access.xml');
 
$this->title = <<<_pageTitle_
        WebCards: Login
_pageTitle_;

$this->content = <<<_pageContent_
<h2>Login</h2>

<p>Not a member? <a href="/webcards/signup/registration">Sign up</a> now</p>

{$reg->logout_msg}
{$reg->error_msg}

<form method="post" action="/webcards/account/login">
	<div>
		<label for="emailadr">Email Address:</label><input type="text" size="20" name="email" id="emailadr" value="{$_POST['email']}" />
			<input type="text" size="20" name="email_error" id="email_error" class="err_msg" readonly="readonly" value="{$_POST['email_error']}" /><br />
		<label for="passwd">Password:</label><input type="password" size="20" name="pwd" id="passwd" /><br /><br />
			<input type="text" size="20" name="psswd_error" id="psswd_error" class="err_msg" readonly="readonly" value="{$_POST['psswd_error']}" /><br />
		<label>&nbsp;</label><input type="hidden" name="submitted" value="y" /><input type="submit" value="Login" /><br />
	</div>
</form>

_pageContent_;

$this->localNav = <<<_localNav_
        
_localNav_;
?>


