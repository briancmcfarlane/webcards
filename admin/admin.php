<?php

error_reporting(E_ALL ^ E_NOTICE);

require 'classes/ValidateSession.php';
require 'classes/AdminAccounts.php';
$checkSession = new ValidateSession();
$userAccounts = new AdminAccounts('access.xml', 'contactsupport.xml');
$checkSession->checkIfAdmin();


$this->title = <<<_pageTitle_
        WebCards: Admin Account Page
_pageTitle_;

$this->content = <<<_pageContent_
    <h3>{$userAccounts->currentAdmin->name}'s Admin Account</h3>
	
	<p>User Account Details</p>
	<p><a href='/webcards/admin/contactInfo'>Contact Support Information</a></p>
	{$userAccounts->error_msg}
	<form method="post" action="admin/adminAcctView"><div>
		{$userAccounts->userTableData}
	<input type='submit' value='Edit Account' id='editUser'/>
	</div></form>
	<div class="clr"></div>

_pageContent_;

$this->localNav = <<<_localNav_
        
_localNav_;
?>
