<?php
  include('lib/AirlineSystem.php'); include('lib/session_mgr.php');
  $servername = 'localhost';
  $db_username = 'root';
  $db_password = 'root';
  $db_name = 'airline_system';

  $system = new AirlineSystem();
  if(!$system->is_valid_system) {
    http_response_code(500);
    echo 'Couldn\'t connect to server';
    return false;
  }

  $flightnum = (isset($_POST['flightnum'])) ? (int)$_POST['flightnum'] : "";
  $deptdate = (isset($_POST['deptdate'])) ? $_POST['deptdate'] : "";
  $arrivaldate = (isset($_POST['arrivaldate'])) ? $_POST['arrivaldate'] : "";
  $deptcity = (isset($_POST['deptcity'])) ? $_POST['deptcity'] : "";
  $arrivalcity = (isset($_POST['arrivalcity'])) ? $_POST['arrivalcity'] : "";
  $deptairport = (isset($_POST['deptairport'])) ? $_POST['deptairport'] : "";
  $arrivalairport = (isset($_POST['arrivalairport'])) ? $_POST['arrivalairport'] : "";

  $result = $system->filteredSearch($flightnum, $deptdate, $arrivaldate, $deptcity, $arrivalcity, $deptairport, $arrivalairport);

  if (!$result) {
    error_log("Filtered search failed or no results found");
  } else {
    $parsed_result = "";
    foreach($result as $row) {
      $view_link = "";
      if(isset($_SESSION['PASSWORD'])) {
        $view_link = "<td align='center'><a href='view_flight.php?flight_num=".$row['flight_num']."&airline_name=".$row['airline_name']."'>Flight Link</a></td>";
      }
      error_log($view_link);
      $parsed_result .= '<tr>'.
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
                          '<td align="center">'.$row['price'].'</td>'.
                          '<td align="center">'.$row['status'].'</td>'.
                       '<tr>';
    }

    http_response_code(200);
    echo $parsed_result;
  }
?>