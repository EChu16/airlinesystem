<?php
  session_start([
    'cookie_lifetime' => 86400,
  ]);

  $_SESSION['IDENTIFIER'];
  $_SESSION['ACCOUNT_TYPE'];

  //Retrieve IP Address
  if($_SERVER['REMOTE_ADDR'])
    $_SESSION['IP'] = $_SERVER['REMOTE_ADDR'];
  else
    $_SESSION['IP'] = "Unknown";
?>