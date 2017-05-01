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
              View all customers for flight 
            </div>
            <div class="main-field field-padding">
              <div style="overflow-x: scroll;overflow-y: scroll;">
                <table style="width: 1500px;max-height: 580px;" border="0" cellpadding="0" cellspacing="0" align="center">
                  <thead>
                    <th class="body-center">Email</th>
                    <th class="body-center">First name</th>
                    <th class="body-center">Last name</th>
                    <th class="body-center">Building #</th>
                    <th class="body-center">Street</th>
                    <th class="body-center">City</th>
                    <th class="body-center">State</th>
                    <th class="body-center">Phone #</th>
                    <th class="body-center">Passport #</th>
                    <th class="body-center">Passport Expiration</th>
                    <th class="body-center">Passport Country</th>
                    <th class="body-center">Date of Birth</th>
                  </thead>
                  <tbody>
                    <?php $result = $dbhelper->queryAllCustomersForFlight($_REQUEST['flight_num'], $_REQUEST['airline_name']); 
                    while($row = mysqli_fetch_assoc($result)) {
                      echo '<tr>
                              <td align="center" class="common-border">'.$row['email'].'</td>
                              <td align="center" class="common-border">'.$row['first_name'].'</td>
                              <td align="center" class="common-border">'.$row['last_name'].'</td>
                              <td align="center" class="common-border">'.$row['building_number'].'</td>
                              <td align="center" class="common-border">'.$row['street'].'</td>
                              <td align="center" class="common-border">'.$row['city'].'</td>
                              <td align="center" class="common-border">'.$row['state'].'</td>
                              <td align="center" class="common-border">'.$row['phone_number'].'</td>
                              <td align="center" class="common-border">'.$row['passport_number'].'</td>
                              <td align="center" class="common-border">'.$row['passport_expiration'].'</td>
                              <td align="center" class="common-border">'.$row['passport_country'].'</td>
                              <td align="center" class="common-border">'.$row['date_of_birth'].'</td>
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