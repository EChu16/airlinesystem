<?php 
  include('lib/session_mgr.php'); include('lib/Customer.php');
  $user = new Customer($_REQUEST['identifier'], $_SESSION['PASSWORD']);
  if ($user->is_valid_user) {
?>
<div class="interface-position vertical-center">
  <table class="customerInterface" border="0" cellpadding="0" cellspacing="0" width="700px" align="center">
    <tr>
      <td align="center">
        View My Flights
      </td>
      <td align="center">
        Purchase Tickets
      </td>
    </tr>
    <tr>
      <td align="center">
        Search For Flights
      </td>
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