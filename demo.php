<?php

$this->title = <<<_pageTitle_
        WebCards: Demo a WebCard
_pageTitle_;

$this->content = <<<_pageContent_
        <h2>Demo a WebCard</h2>
<p>This demo shows a little of what is possible with WebCards.  Consult our <a href="?p=features">features list</a> for the complete picture!</p>
<p><strong>Note:</strong> All fields are required.</p>
<form method="post" action="" id="demoForm">
<ul>
	<li><label for="txt">Choose a Text Style:</label>
	    <div><input type="radio" name="txtstyle" id="txt" value="sans" tabindex="10" /> Sans-Serif (e.g., Verdana)<br />
	    <input type="radio" name="txtstyle" value="serif" tabindex="20" /> Serif (e.g., <span class="serif">Georgia</span>)<br />
        <input type="radio" name="txtstyle" value="fun" tabindex="30" /> Fun (e.g., <span class="fun">Comic Sans</span>)</div>
	</li>
	<li><label for="bdr">Choose a Top Border:</label>
		<div>
		<a href="#" id="bdr" tabindex="40"><img src="images/flower1.jpg" width="80" height="60" alt="Flower 1 Border Image" /></a>
		<a href="#" tabindex="50"><img src="images/flower2.jpg" width="80" height="60" alt="Flower 2 Border Image" /></a><br />
		<a href="#" tabindex="60"><img src="images/cake1.jpg" width="77" height="60" alt="Birthday Cake 1 Border Image" /></a>
		<a href="#" tabindex="70"><img src="images/cake2.jpg" width="89" height="60" alt="Birthday Cake 2 Border Image" /></a><br />
		<a href="#" tabindex="80"><img src="images/text1.jpg" width="200" height="44" alt="Happy Birthday Text 1 Border Image" /></a><br />
		<a href="#" tabindex="90"><img src="images/text2.jpg" width="200" height="39" alt="Happy Birthday Text 2 Border Image" /></a></div>
	</li>
	<li><label for="recip">WebCard Recipient:</label> <input type="text" name="recipient" id="recip" tabindex="100" /></li>
    <li><label for="msg">WebCard Message:<br />
    <span id="available"><input type="text" name="totalcharacters" id="counter" size="4" value="300" readonly="readonly" /> characters left</span></label>
    	<textarea name="message" id="msg" cols="30" rows="4" tabindex="110"></textarea></li>
	<li><label for="sender">Your Name:</label> <input type="text" name="sender" id="sender" tabindex="120" /></li>
    <li><label>&nbsp;</label> <input type="button" id="demo" value="Demo WebCard" tabindex="130" /></li>
</ul>
</form>
<p class="hide"><strong>Printed from:</strong> http://www.webcards.com/?p=demo.php</p>
_pageContent_;

$this->localNav = <<<_localNav_
        
_localNav_;

?>
