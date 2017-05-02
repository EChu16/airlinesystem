<?php include('lib/session_mgr.php'); include('lib/AirlineStaff.php'); include('lib/DBHelper.php'); ?>
<!DOCTYPE html>
<html lang="en">
  <?php include('header.php'); ?>
  <body id="page-top" onload="loadUserParam()">
    <?php if(isset($_SESSION)) { ?>
    <?php include('user-navbar.php'); ?>
      <div class="full-height body-center beach-bg">
      <div class="full-height">
        <?php if($_REQUEST['type'] == "airline_staff") { 
          $user = new AirlineStaff($_REQUEST['identifier'], $_SESSION['PASSWORD']);
          $dbhelper = new DBHelper();
          if($user->is_valid_user && $dbhelper->is_valid_conn) {
        ?>
        <div id="addflight-interface" class="interface-position vertical-center" style="margin:0 !important">
          <div class="main-wrapper" style="height: 570px;margin-top:70px !important">
            <div class="main-title">
              Add new flight
            </div>
            <form id="addflightform">
              <input type="hidden" name="identifier" value=<?php echo '"'.$user->username.'"'?>>
              <input type="hidden" name="add_type" value="flight">
              <div class="main-field field-padding">
                <span class="main-label">Airline/Airplane ID: </span>
                <select name="airline_airplane_id">
                  <?php $result = $dbhelper->queryAllAirplanes(); 
                  while($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="'.$row['airline_name'].'/'.$row['airplane_id'].'">'.$row['airline_name'].'/'.$row['airplane_id'].'</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="main-field field-padding">
                <span class="main-label">Departure airport:</span>
                <select name="deptairport_name">
                  <?php $result = $dbhelper->queryAllAirports(); 
                  while($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="'.$row['airport_name'].'">'.$row['airport_name'].'</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="main-field field-padding">
                <span class="main-label">Departure Date: </span>
                <input type="text" name="dept_date">
              </div>
              <div class="main-field field-padding">
                <span class="main-label">Departure Time: </span>
                <input type="text" name="dept_time">
              </div>
              <div class="main-field field-padding">
                <span class="main-label">Arrival airport:</span>
                <select name="arrairport_name">
                  <?php $result = $dbhelper->queryAllAirports(); 
                  while($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="'.$row['airport_name'].'">'.$row['airport_name'].'</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="main-field field-padding">
                <span class="main-label">Arrival Date: </span>
                <input type="text" name="arr_date">
              </div>
              <div class="main-field field-padding">
                <span class="main-label">Arrival Time: </span>
                <input type="text" name="arr_time">
              </div>
              <div class="main-field field-padding">
                <span class="main-label">Price: </span>
                <input type="text" name="price">
              </div>
              <div class="main-field field-padding">
                <span class="main-label">Status: </span>
                <select name="status">
                  <?php $result = $dbhelper->getFlightStatuses(); 
                  foreach($result as $row) {
                    echo '<option value="'.$row.'">'.$row.'</option>';
                  }
                  ?>
                </select>
              </div>
            </form>
            <div id="error-msg"></div>
            <div id="success-msg"></div>
            <div>
              <div id="submit-btn" class="btn btn-primary">
                Add
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
    <script type="text/javascript">
      function isNumber(value) {
        return /^\d+$/.test(value);
      }
      function isCurrency(value) {
        return /^\d+(?:\.\d{0,2})$/.test(value);
      }
      function validateDate(date) {
        var dateRegEx = /^(0[1-9]|1[012]|[1-9])[- /.](0[1-9]|[12][0-9]|3[01]|[1-9])[- /.](19|20)\d\d$/
        return (date.match(dateRegEx) !== null);
      }
      function validateTime(value) {
        return /^([01]?[0-9]|2[0-3])(:[0-5][0-9]){2}$/.test(value);
      }
      $(document).ready(function () {
        $('#submit-btn').click(function () {
          var error = $('#error-msg');
          var can_add = true;
          if(!validateDate($('input[name=dept_date]').val())) {
            can_add = false;
            $(error).html("Departure date must match mm/dd/yyyy");
          }
          if(!validateDate($('input[name=arr_date]').val())) {
            can_add = false;
            $(error).html("Arrival date must match mm/dd/yyyy");
          }
          if(!validateTime($('input[name=dept_time]').val())) {
            can_add = false;
            $(error).html("Departure time must match hh:mm:ss");
          }
          if(!validateTime($('input[name=arr_time]').val())) {
            can_add = false;
            $(error).html("Arrival time must match hh:mm:ss");
          }
          if(!isCurrency($('input[name=price]').val())) {
            can_add = false;
            $(error).html("Price must be a valid currency");
          }
          if(can_add) {
            var url = "addtodb.php";
            $.ajax({
              type: "POST",
              url: url,
              data: $("#addflightform").serialize(),
            }).done(function(data) {
              $('#success-msg').html(data);
              $('#error-msg').html("");
            }).fail(function(xhr, status, error) {
              $('#error-msg').html(xhr.responseText);
            });
          }
        });
      });
    </script>
  </body>
</html>