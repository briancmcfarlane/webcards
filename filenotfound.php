<?php
require 'classes/ValidateSession.php';
$checkSession = new ValidateSession();

$this->title = <<<_pageTitle_
        WebCards: 404 file not found
_pageTitle_;

$this->content = <<<_pageContent_
        <p>We're sorry, we can't locate the page you've requested.</p>
_pageContent_;

$this->localNav = <<<_localNav_
        
_localNav_;
?>
