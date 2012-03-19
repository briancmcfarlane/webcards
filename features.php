<?php
require 'classes/ValidateSession.php';
$checkSession = new ValidateSession();


$this->title = <<<_pageTitle_
        WebCards: Features
_pageTitle_;

$this->content = <<<_pageContent_
  <h2>Features</h2>
  <p>Send webcards to all your friends with this amazing service!</p>

  <p>Choose between several different occassions for your WebCards:</p>
    <ul>
      <li>Dentist Appointment</li>
      <li>Open House</li>
      <li>Vet Appointment</li>
      <li>Valentine's Day</li>
    </ul>

_pageContent_;

$this->localNav = <<<_localNav_
        
_localNav_;
?>


