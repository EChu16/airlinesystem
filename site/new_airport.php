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
        <div id="addairport-interface" class="interface-position vertical-center">
          <div class="main-wrapper">
            <div class="main-title">
              Add new airport
            </div>
            <form id="addairportform">
              <input type="hidden" name="identifier" value=<?php echo '"'.$user->username.'"'?>>
              <input type="hidden" name="add_type" value="airport">
              <div class="main-field field-padding">
                <span class="main-label">Airport name:</span>
                <input type="text" name="airport_name">
                </select>
              </div>
              <div class="main-field field-padding">
                <span class="main-label" style="padding-right: 14px;">Airport city: </span>
                <input type="text" name="airport_city">
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
      function lettersOnly(value) {
        return /^[A-Za-z ]+$/.test(value);
      }
      $(document).ready(function () {
        $('#submit-btn').click(function () {
          var can_add = true;
          if(!lettersOnly($('input[name=airport_name]').val()) || !lettersOnly($('input[name=airport_city]').val())) {
            can_add = false;
            $('#error-msg').html("Fields can contain letters only");
          }
          if(can_add) {
            var url = "addtodb.php";
            $.ajax({
              type: "POST",
              url: url,
              data: $("#addairportform").serialize(),
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