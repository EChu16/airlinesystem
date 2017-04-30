<?php
  if(!isset($_SESSION)) {
    session_start([
      'cookie_lifetime' => 86400,
      ]);
  }

  //Retrieve IP Address
  if($_SERVER['REMOTE_ADDR'])
    $_SESSION['IP'] = $_SERVER['REMOTE_ADDR'];
  else
    $_SESSION['IP'] = "Unknown";
?>