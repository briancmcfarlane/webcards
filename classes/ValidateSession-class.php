<?php

error_reporting(E_ALL ^ E_NOTICE);

class ValidateSession {

 // property: path to login page
 public $redir = '?p=home';


 // most of the time we are not logging out
 // so set that flag to false by default
 public function __construct($logout = false) {

   // determine the current time in seconds since the Epoch
   $this->now = time();

   // load the session variables
   session_start();

   // if there is no authentication variable in the session
   // then load the login screen with no messages
   if (empty($_SESSION['auth'])) {

//     $this->doRedirect();

   }

   // determine if timeout has occurred
   // or logout has occurred
   elseif ($this->now > $_SESSION['time'] + $_SESSION['timeout']) {

     $this->removeSession();

     // redirect to the login page with a flag for the timeout
     $this->doRedirect('?timeout=y');

   }

   // check to see if logout has occurred
   elseif ($logout) {

     $this->removeSession();

     // redirect to the login page with a flag for the logout
     $this->doRedirect();

   }

   // otherwise just reset the clock
   else {

     // all is well; reset the timer
     $_SESSION['time'] = $this->now;

   }

 }

 public function doRedirect() {

   header("Location: {$this->redir}");
   exit;

 }

 public function removeSession() {

   // empty the session super global array
   $_SESSION = array();

   // wipe the session cookie
   if (!empty($_COOKIE[session_name()])) {
       setcookie(session_name(), '', time() - 60*60*24, '/');
   }

   // end the session
   session_destroy();

 }

}

?>