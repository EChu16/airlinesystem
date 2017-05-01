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
        <div id="addplane-interface" class="interface-position vertical-center">
          <div class="main-wrapper">
            <div class="main-title">
              Add new airplane
            </div>
            <form id="addplaneform">
              <input type="hidden" name="identifier" value=<?php echo '"'.$user->username.'"'?>>
              <input type="hidden" name="add_type" value="airplane">
              <div class="main-field field-padding">
                <span class="main-label">Airline name:</span>
                <select type="" name="airline_name">
                  <?php $result = $dbhelper->queryAllAirlines(); 
                  while($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="'.$row['airline_name'].'">'.$row['airline_name'].'</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="main-field field-padding">
                <span class="main-label"># of Seats: </span>
                <input type="text" name="num_seats">
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
      $(document).ready(function () {
        $('#submit-btn').click(function () {
          var can_add = true;
          if($('input[name=num_seats]').val().length > 4 || !isNumber($('input[name=num_seats]').val())) {
            can_add = false;
            $('#error-msg').html("Seats must be positive integer under 4 digits")
          }
          if(can_add) {
            var url = "addtodb.php";
            $.ajax({
              type: "POST",
              url: url,
              data: $("#addplaneform").serialize(),
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