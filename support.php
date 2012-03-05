<?php

error_reporting(E_ALL ^ E_NOTICE);
require 'classes/form-class.php';
$form = new Form('contact');

$this->title = <<<_pageTitle_
        WebCards: Support
_pageTitle_;

$this->content = <<<_pageContent_
    <h3>Comments, Questions, Concerns</h3>
	<p>Please send us your contact information and message. You will hear back from us soon.</p>

	<form method="post" action="?p=support"><div>
		{$form->generateFields('support')}
		<input type="submit" class="sub" value="Send" />
	</div></form>

_pageContent_;

$this->localNav = <<<_localNav_
        
_localNav_;
?>


