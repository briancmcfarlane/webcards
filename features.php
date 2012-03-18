<?php
require 'classes/ValidateSession.php';
$checkSession = new ValidateSession();


$this->title = <<<_pageTitle_
        WebCards: Features
_pageTitle_;

$this->content = <<<_pageContent_
  <h2>Features</h2>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <div id="features-themes">
                <p>Choose between several different occassions for your WebCards.</p>
                <h3>Theme 1</h3>
                <p>Description of theme 1</p>
                <h3>Theme 2</h3>
                <p>Description of theme 2</p>
                <h3>Theme 3</h3>
                <p>Description of theme 3</p>
                <h3>Theme 4</h3>
                <p>Description of theme 4</p>
                <h3>Theme 5</h3>
                <p>Description of theme 5</p>
                <h3>Theme 6</h3>
                <p>Description of theme 6</p>
        </div>
_pageContent_;

$this->localNav = <<<_localNav_
        
_localNav_;
?>


