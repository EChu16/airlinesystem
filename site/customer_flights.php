<?php include('lib/session_mgr.php'); include('lib/AirlineStaff.php'); include('lib/DBHelper.php'); ?>
<!DOCTYPE html>
<html lang="en">
  <?php include('header.php'); ?>
  <body id="page-top" onload="loadUserParam()">
    <?php if(isset($_SESSION)) { ?>
    <?php include('user-navbar.php'); ?>
      <div class="full-height body-center beach-bg">
        <?php if($_REQUEST['type'] == "airline_staff") { 
          $user = new AirlineStaff($_REQUEST['identifier'], $_SESSION['PASSWORD']);
          $dbhelper = new DBHelper();
          if($user->is_valid_user && $dbhelper->is_valid_conn) {
        ?>
        <div id="addplane-interface" class="interface-position vertical-center">
          <div class="main-wrapper" style="width: 900px;height: 450px;">
            <div class="main-title">
              <?php echo '"'.$_REQUEST['customer_identifier'].'" flights for airline "'.$user->airline_name.'"'; ?>
            </div>
            <div class="main-field field-padding">
              <div style="overflow-x: scroll;overflow-y: scroll;">
                <table style="width: 1500px;max-height: 430px;" border="0" cellpadding="0" cellspacing="0" align="center">
                  <thead>
                    <th class="body-center">Airline</th>
                    <th class="body-center">Flight #</th>
                    <th class="body-center">Departure airport</th>
                    <th class="body-center">Departure city</th>
                    <th class="body-center">Departure date</th>
                    <th class="body-center">Departure time</th>
                    <th class="body-center">Arrival airport</th>
                    <th class="body-center">Arrival city</th>
                    <th class="body-center">Arrival date</th>
                    <th class="body-center">Arrival time</th>
                    <th class="body-center">Price</th>
                    <th class="body-center">Status</th>
                  </thead>
                  <tbody>
                    <?php $allFlights = $dbhelper->queryUserFlightsForAirline($user->airline_name, $_REQUEST['customer_identifier']); 
                    foreach($allFlights as $row) {
                      echo '<tr>'.
                              '<td align="center" class="common-border">'.$row['airline_name'].'</td>'.
                              '<td align="center" class="common-border">'.$row['flight_num'].'</td>'.
                              '<td align="center" class="common-border">'.$row['departure_airport'].'</td>'.
                              '<td align="center" class="common-border">'.$row['departure_city'].'</td>'.
                              '<td align="center" class="common-border">'.$row['departure_date'].'</td>'.
                              '<td align="center" class="common-border">'.$row['departure_time'].'</td>'.
                              '<td align="center" class="common-border">'.$row['arrival_airport'].'</td>'.
                              '<td align="center" class="common-border">'.$row['arrival_city'].'</td>'.
                              '<td align="center" class="common-border">'.$row['arrival_date'].'</td>'.
                              '<td align="center" class="common-border">'.$row['arrival_time'].'</td>'.
                              '<td align="center" class="common-border">$'.$row['price'].'</td>'.
                              '<td align="center" class="common-border">'.$row['status'].'</td>'.
                            '</tr>';
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