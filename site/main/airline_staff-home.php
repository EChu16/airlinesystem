<?php 
  include('lib/session_mgr.php'); include('lib/AirlineStaff.php');
  error_log($_SESSION['PASSWORD']);
  $user = new AirlineStaff($_REQUEST['identifier'], $_SESSION['PASSWORD']);
  if ($user->is_valid_user) {
?>
<div class="interface-position vertical-center">
  <table class="airlineAgentInterface" border="0" cellpadding="0" cellspacing="0" width="700px" align="center">
    <tr>
      <td align="center">
        View My Flights
      </td>
      <td align="center">
        Create New Flights
      </td>
    </tr>
    <tr>
      <td align="center">
        Change Status of Flights
      </td>
      <td align="center">
        Add Airplane in the System
      </td>
    </tr>
    <tr>
      <td align="center">
        Add New Airport in the System
      </td>
      <td align="center">
        View All the Booking Agents
      </td>
    </tr>
    <tr>
      <td align="center">
        View Frequent Customers
      </td>
      <td align="center">
        View Reports
      </td>
    </tr>
    <tr>
      <td align="center">
        Logout
      </td>
    </tr>
  </table>
</div>
<?php
  } else {
?>
<div class="interface-position vertical-center">
Invalid user session. Try relogging.
</div>
<?php } ?>