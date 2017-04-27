<?php
  session_start();

  $_SESSION['username'];
  //Retrieve IP Address
  if($_SERVER['REMOTE_ADDR'])
    $_SESSION['IP'] = $_SERVER['REMOTE_ADDR'];
  else
    $_SESSION['IP'] = "Unknown";
?>