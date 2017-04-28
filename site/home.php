<?php include('lib/session_mgr.php'); ?>
<!DOCTYPE html>
<html lang="en">
  <?php include('header.php'); ?>
  <body id="page-top">
    <?php if(isset($_SESSION)) { ?>
    <?php include('user-navbar.php'); ?>
      <div class="full-height">

      </div>
    <?php } else { ?>
    <?php include('public-navbar.php'); ?>
      <div class="full-height vertical-center">
        Please relogin.
      </div>
    <?php } ?>
    <?php include('footer.php'); ?>
  </body>
</html>