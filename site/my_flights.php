<?php include('lib/AirlineSystem.php'); include('lib/session_mgr.php'); ?>
<!DOCTYPE html>
<html lang="en">
  <?php
    $system = new AirlineSystem();
    if (!$system->is_valid_system) {
      echo('Flight system down.');
      exit;
    }
  ?>
  <?php include('header.php'); ?>
  <body id="page-top" <?php if(!empty($_REQUEST['identifier'])) { ?> onload="loadUserParam()" <?php } ?>>
    <?php if(empty($_REQUEST['identifier'])) {
      include('public-navbar.php'); 
    } else {
      include('user-navbar.php'); 
    }
    ?>
      <div class="full-height">
        <div class="search-left-col full-height">
          <div class="search-box-wrapper">
            <div class="search-box vertical-center">
              <form id="flight-search">
                <div style="margin-top: 30px; margin-bottom: 20px;">
                  Search for a flight
                </div>
                <table border="0" cellpadding="0" cellspacing="0" align="center">
                  <tr>
                    <td>
                      <input type="hidden" name="identifier" value=<?php echo '"'.$_REQUEST['identifier'].'"'; ?>>
                    </td>
                    <td>
                      <input type="hidden" name="type" value=<?php echo '"'.$_REQUEST['type'].'"';?>>
                    </td>
                  </tr>
                  <tr>
                    <td align="center">
                      Flight number: 
                    </td>
                    <td align="center">
                      <input type="text" name="flightnum">
                    </td>
                  </tr>
                  <tr>
                    <td align="center">
                      Departure date: 
                    </td>
                    <td align="center">
                      <input type="text" name="deptdate">
                    </td>
                  </tr>
                  <tr>
                    <td align="center">
                      Arrival date: 
                    </td>
                    <td align="center">
                      <input type="text" name="arrivaldate">
                    </td>
                  </tr>
                  <tr>
                    <td align="center">
                      Departure city:
                    </td>
                    <td align="center"  >
                      <input type="text" name="deptcity">
                    </td>
                  </tr>
                  <tr>
                    <td align="center">
                      Arrival city: 
                    </td>
                    <td align="center"  >
                      <input type="text" name="arrivalcity">
                    </td>
                  </tr>
                  <tr>
                    <td align="center">
                      Departure airport:
                    </td>
                    <td align="center"  >
                      <input type="text" name="deptairport">
                    </td>
                  </tr>
                  <tr>
                    <td align="center">
                      Arrival airport: 
                    </td>
                    <td align="center"  >
                      <input type="text" name="arrivalairport">
                    </td>
                  </tr>
                </table>
                <div id="error-msg" style="margin-top:10px"></div>
                <div id="submit-btn" class="btn btn-primary" style="padding: 10px 20px">
                Submit
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="interface-right-col full-height">
          <div class="flight-interface">
            <table id="flight-system" width="1500" border="0" cellpadding="0" cellspacing="0" align="center" class="table-striped table-hover">
              <thead>
                <tr>
                  <?php if(isset($_SESSION['PASSWORD']) && $_REQUEST['type'] != "airline_staff") {
                    echo '<th class="body-center">View/Purchase Ticket</th><th class="body-center"># Tickets Bought</th>';
                  } else {
                    echo '<th class="body-center">View/Update Flight</th>';
                  }?>
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
                </tr>
              </thead>
              <tbody>
                <?php $allFlights = $system->getUserFlights($_REQUEST['identifier'], $_REQUEST['type']);
                foreach($allFlights as $row) {
                  $view_link = "";
                  if(isset($_SESSION['PASSWORD']) && $_REQUEST['type'] != "airline_staff") {
                    $view_link = "<td align='center'><a href='view_flight.php?flight_num=".$row['flight_num']."&airline_name=".$row['airline_name']."'>Flight Link</a></td><td align='center'>".$row['num_tickets_purchased']."</td>";
                  } else {
                    $view_link = "<td align='center'><a href='view_flight.php?flight_num=".$row['flight_num']."&airline_name=".$row['airline_name']."'>Flight Link</a></td>";
                  }
                  echo '<tr>'.
                          $view_link.
                          '<td align="center">'.$row['airline_name'].'</td>'.
                          '<td align="center">'.$row['flight_num'].'</td>'.
                          '<td align="center">'.$row['departure_airport'].'</td>'.
                          '<td align="center">'.$row['departure_city'].'</td>'.
                          '<td align="center">'.$row['departure_date'].'</td>'.
                          '<td align="center">'.$row['departure_time'].'</td>'.
                          '<td align="center">'.$row['arrival_airport'].'</td>'.
                          '<td align="center">'.$row['arrival_city'].'</td>'.
                          '<td align="center">'.$row['arrival_date'].'</td>'.
                          '<td align="center">'.$row['arrival_time'].'</td>'.
                          '<td align="center">$'.$row['price'].'</td>'.
                          '<td align="center">'.$row['status'].'</td>'.
                       '<tr>';
                } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php include('footer.php'); ?>
    <script type="text/javascript">
      function validateDate(date) {
        var dateRegEx = /^(0[1-9]|1[012]|[1-9])[- /.](0[1-9]|[12][0-9]|3[01]|[1-9])[- /.](19|20)\d\d$/
        return (date.match(dateRegEx) !== null);
      }

      function validateForm(flightnum, arrivaldate, deptdate) {
        var error = $('#error-msg');
        if(flightnum != "") {
          if(/^\d+$/.test(flightnum) == false) {
            $(error).html('Flight #s are digits only');
            return false;
          }
        }
        if(arrivaldate != "") {
          if(!validateDate(arrivaldate)) {
            $(error).html('Invalid date format. Required: mm/dd/yyyy');
            return false;
          }
        }
        if(deptdate != "") {
          if(!validateDate(deptdate)) {
            $(error).html('Invalid date format. Required: mm/dd/yyyy');
            return false;
          }
        }
        return true;
      }

      $('#submit-btn').click(function () {
        var flightnum = $.trim($('input[name=flightnum]').val());
        var arrivaldate = $.trim($('input[name=arrivaldate]').val());
        var deptdate = $.trim($('input[name=deptdate]').val());
        var arrivalcity = $.trim($('input[name=arrivalcity]').val());
        var deptcity = $.trim($('input[name=deptcity]').val());
        var arrivalairport = $.trim($('input[name=arrivalairport]').val());
        var deptairport = $.trim($('input[name=deptairport]').val());

        if(validateForm(flightnum, arrivaldate, deptdate)) {
          var url = "flightSearch.php";
          $.ajax({
            type: "POST",
            url: url,
            data: $("#flight-search").serialize(),
          }).done(function(data, textStatus, xhr) {
            $('#flight-system tbody').empty();
            $('#flight-system tbody').append(data);
            loadUserParam();
          }).fail(function(xhr, status, error) {
            $('#error-msg').html(xhr.responseText);
          });
        }
      });
    </script>
  </body>
</html>