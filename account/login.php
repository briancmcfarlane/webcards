<?php

$this->title = <<<_pageTitle_
        WebCards: Log-In
_pageTitle_;

$this->content = <<<_pageContent_
   <form method="post" action="">
   <label for="loginEmail">Email: </label><input type="text" size="20" name="loginEmail" id="loginEmail" /><br />
   <label for="loginPassword">Password: </label><input type="text" size="20" name="loginPassword" id="loginPassword" /><br />
   <input type="submit" value="Log-in" id="login"/>
   </form>
   <p>Not a member? <a href="?p=signup-registration">Sign up</a> now</p>

_pageContent_;

$this->localNav = <<<_localNav_
        
_localNav_;
?>