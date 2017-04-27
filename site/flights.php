<?php include('lib/AirlineSystem.php'); ?>
<!DOCTYPE html>
<html lang="en">
  <?php
    // Initialize AirlineSystem Object for flight display
    $system = new AirlineSystem();
    if (!$system->is_valid_system) {
      echo('Flight system down.');
      exit;
    }
  ?>
  <?php include('header.php'); ?>
  <body id="page-top">
    <?php include('navbar.php'); ?>
      <div class="full-height">

      </div>
    <?php include('footer.php'); ?>
  </body>
</html>