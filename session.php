<?php
  /* if not logged in then back to login page */
  session_start();
	// set timeout 
  if ($_SESSION['timeout'] + 240 * 60 < time()) {
     // session timed out
     header ('location: logout.php'); exit;
  }

  if(!isset($_SESSION['is_successful_login']) || $_SESSION['is_successful_login'] == false){
    header ('location: login.php'); exit;
  }
  error_reporting(E_ALL);
  ini_set('display_errors', '1');

require_once 'config.php';
require_once 'library/classes.php';
?>
