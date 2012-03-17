<?php
error_reporting(E_ALL ^ E_NOTICE);

require 'classes/ValidateSession-class.php';
$checkSession = new ValidateSession();

require 'classes/ContactSupport-class.php';
$req = new ContactSupport('contactsupport.xml');

$this->title = <<<_pageTitle_
        WebCards: Support
_pageTitle_;

$this->content = <<<_pageContent_
    <h2>Comments, Questions, Concerns</h2>
	<p>Please send us your contact information and message. You will hear back from us soon.</p>

	{$req->error_msg}
	<form method="post" action="/webcards/support"><div id="support-form">
			<label for="first_name">First Name: </label><input type="text" size="20" name="first_name" id="first_name" value="{$_POST['first_name']}" /><br />
			<label for="last_name">Last Name: </label><input type="text" size="20" name="last_name" id="last_name" value="{$_POST['last_name']}" /><br />
            <label for="email">Email Address: </label><input type="text" size="20" name="email" id="email" value="{$_POST['email']}"/><br/>
			<label for="subject">Subject: </label><input type="text" size="20" name="subject" id="subject" value="{$_POST['subject']}" /><br />
			<label for="message">Message: </label><textarea name="message" id="message">{$_POST['message']}</textarea><br /><br />
		<input type="hidden" name="submitted" value="y" />
		<label for="sub">&nbsp;</label><input type="submit" id="sub" value="Send" /><input type="reset" value="Reset Fields"/>
	</div></form>

_pageContent_;

$this->localNav = <<<_localNav_
        
_localNav_;
?>