<?php 
  include('lib/session_mgr.php'); include('lib/Customer.php');
  $user = new Customer($_REQUEST['identifier'], $_SESSION['PASSWORD']);
  if ($user->is_valid_user) {
?>
  <div class="interface-position">
  <div style="padding-top: 80px; padding-bottom: 40px; font-weight: bold; font-size: 24px;color:white"> <?php echo 'Hello '.$user->first_name; ?></div>
  <table class="customerInterface" border="0" cellpadding="0" cellspacing="0" width="700px" align="center">
    <tr>
      <td align="center">
        <a href="my_flights.php">
          <div class="interface-btn btn btn-primary">
          View My Flights
          </div>
        </a>
      </td>
      <td align="center">
        <a href="flights.php">
          <div class="interface-btn btn btn-primary">
          Purchase Tickets
          </div>
        </a>
      </td>
    </tr>
    <tr>
      <td align="center">
        <a href="flights.php">
          <div class="interface-btn btn btn-primary">
          Search For Flights
          </div>
        </a>
      </td>
      <td align="center">
        <a href="login.php">
          <div class="interface-btn btn btn-primary">
          Logout
          </div>
        </a>
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