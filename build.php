<?php
require 'classes/ValidateSession.php';
$checkSession = new ValidateSession();

require 'classes/Build.php';
$build = new Build('webcards.xml');


$this->title = <<<_pageTitle_
        WebCards: Build a WebCard
_pageTitle_;

$this->content = <<<_pageContent_
        <h2>Build a WebCard</h2>
<p>Consult our <a href="/webcards/features">features list</a> for the complete picture!</p>
<p><strong>Note:</strong> All fields are required.</p>
<form method="post" action="/webcards/build" id="buildForm">
<ul>
	<li><label for="txt">Choose a Text Style:</label>
	    <div><input type="radio" checked="{$build->markFont('sans')}" name="txtstyle" id="txt" value="sans" tabindex="10" /> Sans-Serif (e.g., Verdana)<br />
	    <input type="radio" checked="{$build->markFont('serif')}" name="txtstyle" value="serif" tabindex="20" /> Serif (e.g., <span class="serif">Georgia</span>)<br />
        <input type="radio" checked="{$build->markFont('fun')}" name="txtstyle" value="fun" tabindex="30" /> Fun (e.g., <span class="fun">Comic Sans</span>)</div>
	</li>
	<li><label for="bdr">Choose a Top Border:</label>
		<div>
		<a href="#" id="bdr" tabindex="40"><img src="images/theme-dentist-a.png" width="100" height="100" alt="Dentist Appt. A Border Image" /></a>
		<a href="#" tabindex="50"><img src="images/theme-dentist-b.png" width="100" height="100" alt="Dentist Appt. B Border Image" /></a><br />
		<a href="#" tabindex="60"><img src="images/theme-house-a.png" width="100" height="100" alt="Open House A Border Image" /></a>
		<a href="#" tabindex="70"><img src="images/theme-house-b.png" width="100" height="100" alt="Open House B Border Image" /></a><br />
		<a href="#" tabindex="80"><img src="images/theme-pet-a.png" width="100" height="100" alt="Vet Appt. A Border Image" /></a>
		<a href="#" tabindex="90"><img src="images/theme-pet-b.png" width="100" height="100" alt="Vet Appt. B Border Image" /></a><br />
		<a href="#" tabindex="100"><img src="images/theme-vd-a.png" width="100" height="100" alt="Valentine's Day A Border Image" /></a>
		<a href="#" tabindex="110"><img src="images/theme-vd-b.png" width="100" height="100" alt="Valentine's Day B Border Image" /></a></div>
		<input type="hidden" name="bordr" id="bordr" value="bordr" />
	</li>
	<li><label for="recip">WebCard Recipient:</label> <input type="text" value="{$_SESSION['recipient']}" name="recipient" id="recip" tabindex="120" />
    				<input type="text" size="20" name="recipient_error" id="recipient_error" class="err_msg" readonly="readonly" value="{$_POST['recipient_error']}" /><br /></li>
    <li><label for="msg">WebCard Message:<br />
    <span id="available"><input type="text" name="totalcharacters" id="counter" size="4" value="300" readonly="readonly" /> characters left</span></label>
    	<textarea name="message" id="msg" cols="30" rows="4" tabindex="130">{$_SESSION['message']}</textarea>
    				<input type="text" size="20" name="msg_error" id="msg_error" class="err_msg" readonly="readonly" value="{$_POST['msg_error']}" /><br /></li>
	<li><label for="sender">Your Name:</label> <input type="text" value="{$_SESSION['sender']}" name="sender" id="sender" tabindex="140" />
    				<input type="text" size="20" name="sender_error" id="sender_error" class="err_msg" readonly="readonly" value="{$_POST['sender_error']}" /><br /></li>
    <li>
		<label>&nbsp;</label> <input type="button" id="build" value="Preview" tabindex="150" />
		<input type="button" id="signup" name="signup" value="Save" tabindex="160"/>
	</li>
</ul>
</form>
<p class="hide"><strong>Printed from:</strong> http://www.webcards.com/build</p>
_pageContent_;

$this->localNav = <<<_localNav_
        
_localNav_;

?>
