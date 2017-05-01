<?php 
  include('lib/session_mgr.php'); include('lib/BookingAgent.php');
  error_log($_SESSION['PASSWORD']);
  $user = new BookingAgent($_REQUEST['identifier'], $_SESSION['PASSWORD']);
  if ($user->is_valid_user) {
?>
<div class="user-greet">
  <?php 
  echo 'Hello,';
  echo '<div>'.$user->first_name.'</div>';
  ?>
<div class="interface-position vertical-center">
  <table class="bookingAgentInterface" border="0" cellpadding="0" cellspacing="0" width="700px" align="center">
    <tr>
      <td align="center">
        <a href="my_flights.php"><div class="interface-btn btn btn-primary"> View My Flights </div></a>
      </td>
      <td align="center">
        <a href="flights.php"><div class="interface-btn btn btn-primary"> Search/Purchase Tickets </div></a>
      </td>
    </tr>
    <tr>
      <td align="center">
        <a href="view_commission.php"><div class="interface-btn btn btn-primary"> View My Commission </div></a>
      </td>
      <td align="center">
        <a href="login.php"><div class="interface-btn btn btn-primary"> Logout </div></a>
      </td>
    </tr>
  </table>
</div>
<?php
  } else {
?>
<div id="error-msg" class="interface-position vertical-center">
Invalid user session. Try relogging.
</div>
<?php } ?>