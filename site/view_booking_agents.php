<?php include('lib/session_mgr.php'); include('lib/AirlineStaff.php'); include('lib/DBHelper.php'); ?>
<!DOCTYPE html>
<html lang="en">
  <?php include('header.php'); ?>
  <body id="page-top" onload="loadUserParam()">
    <?php if(isset($_SESSION)) { ?>
    <?php include('user-navbar.php'); ?>
      <div class="full-height body-center beach-bg">
      <div>
        <?php if($_REQUEST['type'] == "airline_staff") { 
          $user = new AirlineStaff($_REQUEST['identifier'], $_SESSION['PASSWORD']);
          $dbhelper = new DBHelper();
          if($user->is_valid_user && $dbhelper->is_valid_conn) {
        ?>
        <div id="addplane-interface" class="interface-position vertical-center">
          <div class="main-wrapper" style="width: 900px;height: 600px;margin-top: 30px !important">
            <div class="main-title">
              Top 5 Booking Agents Ticket Sales Past Year
            </div>
            <div class="main-field field-padding">
              <div style="width:850px;margin-left: 25px;">
                <table style="width: 800px;max-height: 580px;" border="0" cellpadding="0" cellspacing="0" align="center">
                  <thead>
                    <th class="body-center">Tickets Sold</th>
                    <th class="body-center">Email</th>
                    <th class="body-center">Booking Agent ID</th>
                  </thead>
                  <tbody>
                    <?php $result = $dbhelper->queryBookingAgentStats($_REQUEST['flight_num'], $_REQUEST['airline_name']); 
                    while($row = mysqli_fetch_assoc($result)) {
                      echo '<tr>
                              <td align="center" class="common-border">'.$row['total_tickets'].'</td>
                              <td align="center" class="common-border">'.$row['email'].'</td>
                              <td align="center" class="common-border">'.$row['booking_agent_id'].'</td>
                            </tr>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="main-title">
              Top 5 Booking Agents Ticket Sales Past Month
            </div>
            <div class="main-field field-padding">
              <div style="width:850px;margin-left: 25px;">
                <table style="width: 800px;max-height: 580px;" border="0" cellpadding="0" cellspacing="0" align="center">
                  <thead>
                    <th class="body-center">Tickets Sold</th>
                    <th class="body-center">Email</th>
                    <th class="body-center">Booking Agent ID</th>
                  </thead>
                  <tbody>
                    <?php $result = $dbhelper->queryBookingAgentStatsMonth($_REQUEST['flight_num'], $_REQUEST['airline_name']); 
                    while($row = mysqli_fetch_assoc($result)) {
                      echo '<tr>
                              <td align="center" class="common-border">'.$row['total_tickets'].'</td>
                              <td align="center" class="common-border">'.$row['email'].'</td>
                              <td align="center" class="common-border">'.$row['booking_agent_id'].'</td>
                            </tr>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="main-title">
              Top 5 Booking Agent Commissions
            </div>
            <div class="main-field field-padding">
              <div style="width:850px;  margin-left: 25px;">
                <table style="width: 800px;max-height: 580px;" border="0" cellpadding="0" cellspacing="0" align="center">
                  <thead>
                    <th class="body-center">Commission Earned</th>
                    <th class="body-center">Email</th>
                    <th class="body-center">Booking Agent ID</th>
                  </thead>
                  <tbody>
                    <?php $result = $dbhelper->queryBookingAgentStats($_REQUEST['flight_num'], $_REQUEST['airline_name']); 
                    while($row = mysqli_fetch_assoc($result)) {
                      echo '<tr>
                              <td align="center" class="common-border">'.$row['commission_earnings'].'</td>
                              <td align="center" class="common-border">'.$row['email'].'</td>
                              <td align="center" class="common-border">'.$row['booking_agent_id'].'</td>
                            </tr>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <?php } else { ?>
        <div id="error-msg" class="interface-position vertical-center">
        Invalid/unauthorized user. Try relogging.
        </div>
        <?php } } else { ?>
        <div id="error-msg" class="interface-position vertical-center">
        404 Unauthorized User.
        </div>
        <?php } ?>
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