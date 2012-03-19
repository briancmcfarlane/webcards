<?php

error_reporting(E_ALL ^ E_NOTICE);

require 'classes/ValidateSession.php';
require 'classes/AdminAccounts.php';
$checkSession = new ValidateSession();
$userAccounts = new AdminAccounts('access.xml', 'contactsupport.xml');
$checkSession->checkIfAdmin();

$this->title = <<<_pageTitle_
        WebCards: Admin Contact Information Page
_pageTitle_;

$this->content = <<<_pageContent_
    <h3>{$userAccounts->currentAdmin->name}'s Admin Account</h3>
	
	<p>Support Information Account Details</p>
		
	<form method="post" action=""><div>
		{$userAccounts->supportTableData}
	</div></form>
	<div class="clr"></div>

_pageContent_;

$this->localNav = <<<_localNav_
        
_localNav_;
?>

