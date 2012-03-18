<?php

require 'classes/ValidateSession.php';
$checkSession = new ValidateSession();

 
$this->title = <<<_pageTitle_
        WebCards: Registration Successful!
_pageTitle_;

$this->content = <<<_pageContent_
        <p>Registration successful, welcome to WebCards!</p>
_pageContent_;

$this->localNav = <<<_localNav_
        
_localNav_;
?>
