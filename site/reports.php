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
            $total_tickets = $user->getTotalTickets();
        ?>
        <div id="alltickets-interface" class="interface-position vertical-center">
          <div class="main-wrapper">
            <div class="main-title">
              Total Amount of Tickets
            </div>
            <div id="main-header">
              Past 30 Days
            </div>
            <div class="main-field">
              <span class="main-label">Total Tickets: </span>
              <span id="total-tickets"><?php echo $total_tickets['total_tickets']; ?></span>
            </div>

            <form id="ticket-recalculate">
              <input type="hidden" name="identifier" value=<?php echo '"'.$user->username.'"';?>>
              <div class="form-label" style="margin-top: 30px;display:inline-block;">
                From Date: <input type="text" name="from-date">
              </div>
              <div class="form-label" style="padding-left: 30px;display:inline-block;">
                To Date: <input type="text" name="to-date">
              </div>
            </form>
            <div id="error-msg"></div>
            <div>
              <div id="submit-btn" class="btn btn-primary">
              Recalculate total tickets
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
      function validateDate(date) {
        var dateRegEx = /^(0[1-9]|1[012]|[1-9])[- /.](0[1-9]|[12][0-9]|3[01]|[1-9])[- /.](19|20)\d\d$/
        return (date.match(dateRegEx) !== null);
      }

      $(document).ready(function () {
        $('#submit-btn').click(function () {
          var can_recalculate = true;
          if(!validateDate($('input[name=from-date]').val())) {
            $('#error-msg').html('Invalid from date format. *mm/dd/yyyy*');
            can_recalculate = false;
          }
          if(!validateDate($('input[name=to-date]').val())) {
            $('#error-msg').html('Invalid to date format. *mm/dd/yyyy*');
            can_recalculate = false;
          }
          if(can_recalculate) {
            var url = "recalculate_tickets.php";
            $.ajax({
              type: "POST",
              url: url,
              data: $("#ticket-recalculate").serialize(),
              dataType: "json"
            }).done(function(data) {
              var fromdate = $('input[name=from-date]');
              var todate = $('input[name=to-date]');
              $('#main-header').html($(fromdate).val() + " - " + $(todate).val());
              $(fromdate).val("");
              $(todate).val("");
              $('#error-msg').html("");
              $('#total-tickets').html(data.total_tickets);
            }).fail(function(xhr, status, error) {
              $('#error-msg').html(xhr.responseText);
            });
          }
        });
      });
    </script>
  </body>
</html>