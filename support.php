<?php
error_reporting(E_ALL ^ E_NOTICE);

require 'classes/ValidateSession.php';
$checkSession = new ValidateSession();

require 'classes/ContactSupport.php';
$req = new ContactSupport('contactsupport.xml');

$this->title = <<<_pageTitle_
        WebCards: Support
_pageTitle_;

$this->content = <<<_pageContent_
    <h2>Comments, Questions, Concerns</h2>
	<p>Please send us your contact information and message. You will hear back from us soon.</p>

	{$req->error_msg}
	<form method="post" action="/webcards/support"><div id="support-form">
			<label for="name">Name: </label><input type="text" size="20" name="name" id="name" tabindex="100" value="{$_POST['name']}" />
				<input type="text" size="20" name="name_error" id="name_error" class="err_msg" readonly="readonly" value="{$_POST['name_error']}" /><br />
				
            <label for="email">Email Address: </label><input type="text" size="20" name="email" id="email" tabindex="110" value="{$_POST['email']}"/>
				<input type="text" size="20" name="email_error" id="email_error" class="err_msg" readonly="readonly" value="{$_POST['email_error']}" /><br />
				
			<label for="subject">Subject: </label><input type="text" size="20" name="subject" id="subject" tabindex="120" value="{$_POST['subject']}" />
				<input type="text" size="20" name="subj_error" id="subj_error" class="err_msg" readonly="readonly" value="{$_POST['subj_error']}" /><br />
				
			<label for="message">Message: </label><textarea name="message" id="message" tabindex="130">{$_POST['message']}</textarea>
				<input type="text" size="20" name="msg_error" id="msg_error" class="err_msg" readonly="readonly" value="{$_POST['msg_error']}" /><br />
				
		<input type="hidden" name="submitted" value="y" />
		<label for="sub">&nbsp;</label><input type="submit" id="sub" value="Send" />
	</div></form>

_pageContent_;

$this->localNav = <<<_localNav_
        
_localNav_;
?>
