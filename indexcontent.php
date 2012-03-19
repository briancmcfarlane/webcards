<?php
require 'classes/ValidateSession.php';
$checkSession = new ValidateSession();

$this->title = <<<_pageTitle_
        WebCards: Home
_pageTitle_;

$this->content = <<<_pageContent_
        <p>Have you ever wanted to send someone a card but can't find a stamp? Don't have an envelope sitting around?</p>
        <p>Neither do we. That's why we started this e-Online business for sending WebCards over the interWeb. Sign up for one of our great e-Plans to send hundreds, thousands or millions of WebCards to all your customers, family, friends or e-Friends.</p>
        <div id="home-cta"><a href="/webcards/signup/registration">Sign Up For WebCards Today!</a></div>
_pageContent_;

$this->localNav = <<<_localNav_
        
_localNav_;
?>
