<?php
error_reporting(E_ALL ^ E_NOTICE);

require 'classes/ValidateSession.php';
$checkSession = new ValidateSession();

$this->title = <<<_pageTitle_
        WebCards: Support
_pageTitle_;

$this->content = <<<_pageContent_
    <h2>Thank You for Your Note.</h2>
	<p>Someone will contact you soon.</p>

_pageContent_;

$this->localNav = <<<_localNav_
        
_localNav_;
?>


