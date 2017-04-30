<?php include('lib/session_mgr.php'); ?>
<!DOCTYPE html>
<html lang="en">
  <?php include('header.php'); ?>
  <body id="page-top" onload="loadUserParam()">
    <?php if(isset($_SESSION)) { ?>
    <?php include('user-navbar.php'); ?>
      <div class="full-height body-center beach-bg">
      <div class="full-height">
        <?php if($_REQUEST['type'] == "customer") {
          include('main/customer-home.php');
        } else if ($_REQUEST['type'] == "booking_agent") {
          include('main/booking_agent-home.php');
        } else if ($_REQUEST['type'] == "airline_staff") {
          include('main/airline_staff-home.php');
        }
        ?>
      </div>
    <?php } else { ?>
    <?php include('public-navbar.php'); ?>
      <div id="error-msg" class="full-height vertical-center">
        Please relogin.
      </div>
    <?php } ?>
    <?php include('footer.php'); ?>
  </body>
</html>