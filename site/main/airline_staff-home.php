<?php 
  include('lib/session_mgr.php'); include('lib/AirlineStaff.php');
  $user = new AirlineStaff($_REQUEST['identifier'], $_SESSION['PASSWORD']);
  if ($user->is_valid_user) {
?>  
<div class="full-height interface-position">
  <div style="padding-top: 80px; padding-bottom: 40px; font-weight: bold; font-size: 24px;color:white"> <?php echo 'Hello '.$user->first_name; ?></div>
  <table class="airlineAgentInterface" border="0" cellpadding="0" cellspacing="0" width="700px" align="center">
    <tr>
      <td align="center">
        <a href="my_flights.php"><div class="interface-btn-staff btn btn-primary"> View My Flights </div></a>
      </td>
      <td align="center">
        <a href="new_flight.php"><div class="interface-btn-staff btn btn-primary"> Create New Flight </div></a>
      </td>
    </tr>
    <tr>
      <td align="center">
        <a href="new_airplane.php"><div class="interface-btn-staff btn btn-primary"> Add New Airplane </div></a>
      </td>
      <td align="center">
        <a href="new_airport.php"><div class="interface-btn-staff btn btn-primary"> Add New Airport </div></a>
      </td>
    </tr>
    <tr>
      <td align="center">
        <a href="view_booking_agents.php"><div class="interface-btn-staff btn btn-primary"> View All Booking Agents </div></a>
      </td>
      <td align="center">
        <a href="view_freq_customer.php"><div  class="interface-btn-staff btn btn-primary"> View Frequent Customers </div></a>
      </td>
    </tr>
    <tr>
      <td align="center">
        <a href="reports.php"><div class="interface-btn-staff btn btn-primary"> View Reports </div></a>
      </td>
      <td align="center">
        <a href="login.php"><div class="interface-btn-staff btn btn-primary"> Logout </div></a>
      </td>
    </tr>
  </table>
</div>
<?php
  } else {
?>
<div id="error_msg" class="interface-position vertical-center">
Invalid user session. Try relogging.
</div>
<?php } ?>