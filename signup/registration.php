<?php
require 'classes/Registration.php';
$reg = new Registration('access.xml');
 
$this->title = <<<_pageTitle_
        WebCards: Register for Webcards
_pageTitle_;

$this->content = <<<_pageContent_
        <h2>Registration</h2>
                <p>Passwords must be at least 7 characters long, and must include an uppercase letter, a lowercase letter and a number.</p>
		<p><a href="/webcards/account/login">Already a member?</a></p>

        {$reg->error_msg}
        <form method="post" action="/webcards/signup/registration"><div>
            <label for="emailAddr">Email Address: </label><input type="text" size="20" name="email" id="emailAddr" value="{$_POST['email']}"/><br/>
            <label for="password">Password: </label><input type="password" size="20" name="password" id="password" /><br/>
            <label for="confirmpassword">Confirm Password: </label><input type="password" size="20" name="confirmpassword" id="confirmpassword" /><br/>
            <label for="name">Name: </label><input type="text" size="20" name="name" id="name" value="{$_POST['name']}" />
            <h3>Choose Your Plan:</h3>
                <label for="copper">Copper Plan</label><input type="radio" name="plan" value="Copper" id="copper"/><br />
                <label for="silver">Silver Plan</label><input type="radio" name="plan" value="Silver" id="silver"/><br />
                <label for="gold">Gold Plan</label><input type="radio" name="plan" value="Gold" id="gold"/><br />
                <label for="platinum">Platinum Plan</label><input type="radio" name="plan" value="Platinum" id="platinum"/><br />
            <input type="hidden" name="submitted" value="y" />
            <br />                     
            <label>&nbsp;</label><input type="submit" value="Create Account"/><input type="reset" value="Reset Fields"/>
        </div></form>
_pageContent_;

$this->localNav = <<<_localNav_
        
_localNav_;
?>
