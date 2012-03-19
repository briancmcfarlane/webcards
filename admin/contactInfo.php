<?php

error_reporting(E_ALL ^ E_NOTICE);

require 'classes/ValidateSession.php';
require 'classes/AdminAccounts.php';
$checkSession = new ValidateSession();
$userAccounts = new AdminAccounts('access.xml', 'contactsupport.xml');


$this->title = <<<_pageTitle_
        WebCards: Admin Contact Information Page
_pageTitle_;

$this->content = <<<_pageContent_
    <h3>{$userAccounts->currentAdmin->name}'s Admin Account</h3>
	
	<p>Support Information Account Details</p>
		
	<form method="post" action=""><div>
		{$userAccounts->supportTableData}
		<input type='submit' name='delMsg' value='Remove Message' id='delMsg'/>
	</div></form>
	<div class="clr"></div>

_pageContent_;

$this->localNav = <<<_localNav_
        
_localNav_;
?>

