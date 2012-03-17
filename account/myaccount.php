<?php

//error_reporting(E_ALL ^ E_NOTICE);

require 'classes/ValidateSession-class.php';
require 'classes/WebcardImporter.php';
$checkSession = new ValidateSession();
$webcardImporter = new WebcardImporter('webcards.xml');


$this->title = <<<_pageTitle_
        WebCards: Support
_pageTitle_;

$this->content = <<<_pageContent_
    <h2>Your Account</h2>
        <p>Account Details</p>
        <form method="post" action=""><div>
            <label for="emailAddr">Email Address: </label><input type="text" size="20" name="email" id="emailAddr" value="{$_SESSION['email']}"/><br/>
            <label for="password">Password: </label><input type="password" size="20" name="password" id="password" /><br/>
            <label for="confirmpassword">Confirm Password: </label><input type="password" size="20" name="confirmpassword" id="confirmpassword" /><br/>
            <label for="name">Name: </label><input type="text" size="20" name="name" id="name" value="{$_SESSION['name']}" /><br/>
            <label for="ccnumber">Credit Card Number: </label><input type="text" size="20" name="ccnumber" id="ccnumber" value="{$_SESSION['ccnumber']}" />
            <p>Choose your plan: <br/>
                <label for="bronze">Bronze Plan </label><input type="radio" name="plan" id="bronze" value="bronze" /> <br/>
                <label for="silver">Silver Plan </label><input type="radio" name="plan" value="silver" /> <br/>
                <label for="gold">Gold Plan </label><input type="radio" name="plan" value="gold" /> <br/>
            </p>
            <input type="hidden" name="submitted" value="y" />
                                 
            <input type="submit" value="Save Changes"/>
        </div></form>
            <div class="clr"></div>
	{$webcardImporter->webcardTable}
            <p><a href="demo">Create Webcards</a></p>

_pageContent_;

$this->localNav = <<<_localNav_
        
_localNav_;
?>


