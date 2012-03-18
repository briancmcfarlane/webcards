<?php

//error_reporting(E_ALL ^ E_NOTICE);

require 'classes/ValidateSession.php';
require 'classes/AccountImporter.php';
$checkSession = new ValidateSession();
$checkSession->checkAuthorization();
$accountImporter = new AccountImporter('access.xml','webcards.xml');


$this->title = <<<_pageTitle_
        WebCards: {$accountImporter->accountDetails->name}'s Account
_pageTitle_;

$this->content = <<<_pageContent_
    <h2>{$accountImporter->accountDetails->name}'s Account</h2>
        <p>Account Details</p>
        <p>If you want to alter your account details, please make sure all fields are completed. Any password that meets the requirements will replace your current password. Requirements for a password: 7 characters long, and contains an uppercase letter, a lowercase letter and a number.</p>
        {$accountImporter->error_msg}
        <form method="post" action=""><div>
            <label for="emailAddr">Email Address: </label><input type="text" size="20" name="email" id="emailAddr" value="{$accountImporter->accountDetails->email}"/><br/>
            <label for="password">Password: </label><input type="password" size="20" name="password" id="password" /><br/>
            <label for="confirmpassword">Confirm Password: </label><input type="password" size="20" name="confirmpassword" id="confirmpassword" /><br/>
            <label for="name">Name: </label><input type="text" size="20" name="name" id="name" value="{$accountImporter->accountDetails->name}" /><br/>
            <label for="ccnumber">Credit Card Number: </label><input type="text" size="20" name="ccnumber" id="ccnumber" value="{$accountImporter->accountDetails->ccnumber}" />
            <p>Your current plan : {$accountImporter->accountDetails->plan}</p>
            <p>Update your plan: <br/>
                <label for="bronze">Bronze Plan </label><input type="radio" name="plan" id="bronze" value="Bronze" /> <br/>
                <label for="silver">Silver Plan </label><input type="radio" name="plan" id="silver" value="Silver" /> <br/>
                <label for="gold">Gold Plan </label><input type="radio" name="plan" id="gold" value="Gold" /> <br/>
            </p>
            <input type="hidden" name="alterAccount" value="y" />
                                 
            <input type="submit" value="Save Changes"/>
        </div></form>
            <div class="clr"></div>
            <h2>Your Webcards</h2>
            
            {$accountImporter->webcardForm}
                
            <p><a href="build">Create Webcards</a></p>

_pageContent_;

$this->localNav = <<<_localNav_
        
_localNav_;

?>
