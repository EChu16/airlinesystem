<?php include('lib/session_mgr.php'); include('lib/Customer.php'); include('lib/BookingAgent.php'); include('lib/AirlineStaff.php'); include('lib/Flight.php');?>
<!DOCTYPE html>
<html lang="en">
  <?php include('header.php'); ?>
  <body id="page-top" onload="loadUserParam()">
    <?php if(isset($_SESSION)) {
      include('user-navbar.php'); ?>
      <div class="full-height body-center">
      <div class="full-height">
        <?php if($_REQUEST['type'] == "customer") {
          $user = new Customer($_REQUEST['identifier'], $_SESSION['PASSWORD']);
        } else if ($_REQUEST['type'] == "booking_agent") {
          $user = new BookingAgent($_REQUEST['identifier'], $_SESSION['PASSWORD']);
        }
        if ($user && $user->is_valid_user) {
          $flight = new Flight($_REQUEST['flight_num'], $_REQUEST['airline_name']);
          if($flight->is_valid_flight) {
        ?>
          <div class="flight-info">
            <div style="margin-top: 60px; font-size: 24px;"> Flight Info </div>
            <table id="flight-info-display" width="600" height="500px;" border="0" cellpadding="0" cellspacing="0" align="center">
              <tr>
                <td align="center">
                  <div class="bordered-info">
                    <span class="label-display">Flight Number</span><br><br>
                    <span class="flight-num value-padding">
                      <?php echo $flight->flight_num; ?>
                    </span>
                  </div>
                </td>
                <td align="center">
                  <div class="bordered-info">
                    <span class="label-display">Airline Name</span><br><br>
                    <span class="airline-name value-padding">
                      <?php echo $flight->airline_name; ?>
                    </span>
                  </div>
                </td>
                <td align="center">
                  <div class="bordered-info">
                    <span class="label-display">Airline ID</span><br><br>
                    <span class="airline-id value-padding">
                      <?php echo $flight->airplane_id; ?>
                    </span>
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="bordered-info">
                    <span class="label-display">Departure Airport</span><br><br>
                    <span class="departure-airport value-padding">
                      <?php echo $flight->departure_airport; ?>
                    </span>
                  </div>
                </td>
                <td>
                  <div class="bordered-info">
                    <span class="label-display">Departure Date</span><br><br>
                    <span class="departure-date value-padding">
                      <?php echo $flight->departure_date; ?>
                    </span>
                  </div>
                </td>
                <td>
                  <div class="bordered-info">
                    <span class="label-display">Departure Time</span><br><br>
                    <span class="departure-time value-padding">
                      <?php echo $flight->departure_time; ?>
                    </span>
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="bordered-info">
                    <span class="label-display">Arrival Airport</span><br><br>
                    <span class="arrival-airport value-padding">
                      <?php echo $flight->arrival_airport; ?>
                    </span>
                  </div>
                </td>
                <td>
                  <div class="bordered-info">
                    <span class="label-display">Arrival Date</span><br><br>
                    <span class="arrival-date value-padding">
                      <?php echo $flight->arrival_date; ?>
                    </span>
                  </div>
                </td>
                <td>
                  <div class="bordered-info">
                    <span class="label-display">Arrival Time</span><br><br>
                    <span class="arrival-time value-padding">
                      <?php echo $flight->arrival_time; ?>
                    </span>
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="bordered-info">
                    <span class="label-display">Price</span><br><br>
                    <span class="flight-price value-padding">
                      $<?php echo $flight->price; ?>
                    </span>
                  </div>
                </td>
                <td>
                  <div class="bordered-info">
                    <span class="label-display">Status</span><br><br>
                    <span class="flight-status value-padding">
                      <?php echo $flight->status; ?>
                    </span>
                  </div>
                </td>
                <td>
                  <div class="bordered-info">
                    <span class="label-display"># of Tickets Remaining</span><br><br>
                    <span class="num-tickets value-padding">
                      <?php echo $flight->num_tickets; ?>
                    </span>
                  </div>
                </td>
              </tr>
            </table>
            <div id="num-tickets-wrapper">
              <span> Number of tickets to purchase: </span>
              <select id="num-ticket-dropdown">
                <?php for ($i = 1; $i <= 10; $i++) {
                  echo '<option value="'.$i.'">'.$i.'</option>';
                }?>
              </select>

              <?php if($_REQUEST['type'] == "booking_agent") {
                echo '<span> | Customer email: </span><input type="text" name="customer_email"/>';
              }?>
            </div>
            <div id="error-msg"></div>
            <div id="submit-btn" class="btn btn-primary" style="padding: 10px 20px">
              Purchase ticket
            </div>
          </div>
        <?php } else { ?>
        <div class="vertical-center full-height">Invalid flight number.</div>
        <?php }
          } else { ?>
          <div class="vertical-center full-height">Unauthorized 404.</div>
        <?php } ?>
      </div>
    <?php } else { ?>
    <?php include('public-navbar.php'); ?>
      <div class="full-height vertical-center">
        You must be a registered user to view this information. Please login.
      </div>
    <?php } ?>
    <?php include('footer.php'); ?>
    <script type="text/javascript">
      function validateEmail(email) {
        var pattern = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return $.trim(email).match(pattern) ? true : false;
      }

      $(document).ready(function () {
        $('#submit-btn').click(function () {
          if($.trim($('.num-tickets').html()) == "0") {
            $('#error-msg').html("Flight is currently unavailable - no tickets");
          }
          var valid_email = true;
          var c_email = "";
          if($('input[name=customer_email]').is(":visible")) {
            valid_email = validateEmail($('input[name=customer_email]').val());
            if(valid_email) {
              c_email = $('input[name=customer_email]').val();
            } else {
              $('#error-msg').html("Please enter valid email");
            }
          }
          if(valid_email) {
            var url = "purchases.php";
            $.ajax({
              type: "POST",
              url: url,
              data: {flightnum: <?php echo '"'.$_REQUEST['flight_num'].'"'; ?>, airline_name: <?php echo '"'.$_REQUEST['airline_name'].'"'; ?>, numtickets: $('#num-ticket-dropdown').val(), customer_email: c_email, identifier: <?php echo '"'.$_REQUEST['identifier'].'"'; ?>, account_type: <?php echo '"'.$_REQUEST['type'].'"'; ?>},
            }).done(function(data, textStatus, xhr) {
              window.location.replace("home.php?identifier=" + <?php echo '"'.$_REQUEST['identifier'].'"'; ?> + "&type=" + <?php echo '"'.$_REQUEST['type'].'"'; ?>);
            }).fail(function(xhr, status, error) {
              $('#error-msg').html(xhr.responseText);
            });
          }
        });
      });
    </script>
  </body>
</html>