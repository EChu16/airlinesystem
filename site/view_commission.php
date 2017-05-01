<?php include('lib/session_mgr.php'); include('lib/BookingAgent.php'); ?>
<!DOCTYPE html>
<html lang="en">
  <?php include('header.php'); ?>
  <body id="page-top" onload="loadUserParam()">
    <?php if(isset($_SESSION)) { ?>
    <?php include('user-navbar.php'); ?>
      <div class="full-height body-center beach-bg">
      <div class="full-height">
        <?php if($_REQUEST['type'] == "booking_agent") { 
          $user = new BookingAgent($_REQUEST['identifier'], $_SESSION['PASSWORD']);
          if($user->is_valid_user) {
            $commission_stats = $user->getCommissionResults();
        ?>
        <div id="commission-interface" class="interface-position vertical-center">
          <div class="commission-wrapper">
            <div class="commission-title">
              Commission Statistics
            </div>
            <div id="commission-header">
              Past 30 Days
            </div>
            <div class="commission-field">
              <span class="commission-label">Earnings: $</span>
              <span id="commission-earnings"><?php echo $commission_stats['earnings']; ?></span>
            </div>
            <div class="commission-field">
              <span class="commission-label"># Tickets Sold: </span>
              <span id="commission-tickets"><?php echo $commission_stats['total_tickets']; ?></span>
            </div>
            <div class="commission-field">
              <span class="commission-label">Avg $/Ticket: $</span>
              <span id="commission-avg"><?php echo $commission_stats['avg_earning_per_ticket']; ?></span>
            </div>

            <form id="commission-recalculate">
              <input type="hidden" name="identifier" value=<?php echo '"'.$user->email.'"';?>>
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
              Recalculate commission
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
            var url = "recalculate_commission.php";
            $.ajax({
              type: "POST",
              url: url,
              data: $("#commission-recalculate").serialize(),
              dataType: "json"
            }).done(function(data) {
              var fromdate = $('input[name=from-date]');
              var todate = $('input[name=to-date]');
              $('#commission-header').html($(fromdate).val() + " - " + $(todate).val());
              $(fromdate).val("");
              $(todate).val("");
              $('#error-msg').html("");
              $('#commission-earnings').html(data.earnings);
              $('#commission-tickets').html(data.total_tickets);
              $('#commission-avg').html(data.avg_earning_per_ticket);
            }).fail(function(xhr, status, error) {
              $('#error-msg').html(xhr.responseText);
            });
          }
        });
      });
    </script>
  </body>
</html>