<?php
require 'classes/ValidateSession.php';
$checkSession = new ValidateSession();

$this->title = <<<_pageTitle_
        WebCards: Pricing
_pageTitle_;

$this->content = <<<_pageContent_
   <h2>Pricing</h2>
		<p id='priceTxt'>Our Pricing is set up to help find a plan that most suitable for your needs. We allow you to buy a single webcard or you can get large packages of webcards. Please take a look at what packages we have, set your account up and and start sending your webcards.</p>
		<div id='prHolder'>
			
			<div><h3 id='copPrice'>Copper</h3><p>The Copper plan is our least expense plan and lets you pay as you go. This pay as you go plan lets you by a single webcard or select 5 or 10. This way you can get just what you need when you need a few webcards.  Each webcard when bought on this plan is $1.</p></div>
			<div><h3 id='slvPrice'>Silver</h3><p>The Silver plan lets you buy a packet of 50 webcards for $40. Much more price effect if you have lots of webcards to send with a bit of a price break. This plan works great for people that have lots of friends that they love to send webcrads to your friends. </p></div>
			<div><h3 id='gldPrice'>Gold</h3><p>Our Gold package contains a packect of 300 webcards for $250. We love giving you price breaks the more you love our webcards. This package works out great for small business or people that have to many friends to count that love to send webcards.</p></div>
			<div><h3 id='pltPrice'>Platinum</h3><p>Saving the best for last, the top of the line, the crème de la crème in webcard packages; 5,000 webcards for only $4,200. Another great price break on our best package. This package is perfect for this large businesses or networking groups that send webcards to large groups of people on a regular time period.</p></div>
		</div>
_pageContent_;

$this->localNav = <<<_localNav_
        
_localNav_;
?>
