<?php
    include 'classes/Template.php';
    $page = new Template();
    $page -> loadData();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title><?php $page->printTitle(); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <base href="/webcards/" />
	<link rel="stylesheet" type="text/css" href="css/screenwebcards.css" media="screen,projection" />
	<link rel="stylesheet" type="text/css" href="css/printwebcards.css" media="print" />
        <?php $page->linkJS(); ?>
</head>
<body>
<p id="jump"><a href="#contentarea">Jump to main content</a></p>

<div id="container">
<h1>WebCards</h1>
<h2 id="tagline">An E-Card For Every Occasion</h2>
    <?php $page->generateLoginBox(); ?>
    <?php $page->generateGlobalNav(); ?>

<div class="clr">&nbsp;</div>

<div id="content"><a name="contentarea"></a>
    <?php $page->generateContent(); ?>
   <div class="clr" id="footer">All content &copy; <?php $page->getYear(); ?> WebCards, Inc. All Rights Reserved.</div>
</div>
    <?php $page->generateLocalNav(); ?>

</div>
</body>
</html>
