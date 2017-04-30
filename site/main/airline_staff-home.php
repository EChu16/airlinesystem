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
        <div id="submit-btn" class="btn btn-primary"> View My Flights </div>
      </td>
      <td align="center">
        <div id="submit-btn" class="btn btn-primary"> Create New Flights </div>
      </td>
    </tr>
    <tr>
      <td align="center">
        <div id="submit-btn" class="btn btn-primary"> Change Status of Flights </div>
      </td>
      <td align="center">
        <div id="submit-btn" class="btn btn-primary"> Add Airplane in the System </div>
      </td>
    </tr>
    <tr>
      <td align="center">
        <div id="submit-btn" class="btn btn-primary"> Add New Airport in the System </div>
      </td>
      <td align="center">
        <div id="submit-btn" class="btn btn-primary"> View All the Booking Agents </div>
      </td>
    </tr>
    <tr>
      <td align="center">
        <div id="submit-btn" class="btn btn-primary"> View Frequent Customers </div>
      </td>
      <td align="center">
        <div id="submit-btn" class="btn btn-primary"> View Reports </div>
      </td>
    </tr>
    <tr>
      <td align="center">
        <div id="submit-btn" class="btn btn-primary"> Logout </div>
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