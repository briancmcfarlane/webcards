<?php
require 'classes/registration-class.php';
$reg = new Registration('access.xml');
 
$this->title = <<<_pageTitle_
        WebCards: Home
_pageTitle_;

$this->content = <<<_pageContent_
        <h2>Registration</h2>
		<p><a href="?p=account-login">Already a member?</a></p>

        {$reg->error_msg}
        <form method="post" action="?p=signup-registration"><div>
            <label for="emailAddr">Email Address: </label><input type="text" size="20" name="email" id="emailAddr" value="{$_POST['email']}"/><br/>
            <label for="password">Password: </label><input type="password" size="20" name="password" id="password" /><br/>
            <label for="confirmpassword">Confirm Password: </label><input type="password" size="20" name="confirmpassword" id="confirmpassword" /><br/>
            <label for="Fname">First Name: </label><input type="text" size="20" name="Fname" id="Fname" value="{$_POST['Fname']}" /><br/>
            <label for="Lname">Last Name: </label><input type="text" size="20" name="Lname" id="Lname" value="{$_POST['Lname']}"/><br/>
            <label for="ccnumber">Credit Card Number: </label><input type="text" size="20" name="ccnumber" id="ccnumber" value="{$_POST['ccnumber']}" />
            <p>Choose your plan: <br/>
                <label for="bronze">Bronze Plan </label><input type="radio" name="plan" id="bronze" value="bronze" /> <br/>
                <label for="silver">Silver Plan </label><input type="radio" name="plan" value="silver" /> <br/>
                <label for="gold">Gold Plan </label><input type="radio" name="plan" value="gold" /> <br/>
            </p>
            <input type="hidden" name="submitted" value="y" />
                                 
            <input type="submit" value="Create Account"/><input type="reset" value="Reset Fields"/>
        </div></form>
_pageContent_;

$this->localNav = <<<_localNav_
        
_localNav_;
?>
