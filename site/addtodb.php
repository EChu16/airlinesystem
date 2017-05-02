<?php 
  include('lib/session_mgr.php'); include('lib/AirlineStaff.php');
  $servername = 'localhost';
  $db_username = 'root';
  $db_password = 'root';
  $db_name = 'airline_system';

  $identifier = (isset($_POST['identifier'])) ? $_POST['identifier'] : "";
  
  $airline_airplane_id = (isset($_POST['airline_airplane_id'])) ? $_POST['airline_airplane_id'] : "";
  $airline_name = (isset($_POST['airline_name'])) ? $_POST['airline_name'] : "";
  $airport_name = (isset($_POST['airport_name'])) ? $_POST['airport_name'] : "";
  $airport_city = (isset($_POST['airport_city'])) ? $_POST['airport_city'] : "";
  $num_seats = (isset($_POST['num_seats'])) ? (int)$_POST['num_seats'] : "";
  $deptairport_name = (isset($_POST['deptairport_name'])) ? $_POST['deptairport_name'] : "";
  $arrairport_name = (isset($_POST['arrairport_name'])) ? $_POST['arrairport_name'] : "";
  $dept_date = (isset($_POST['dept_date'])) ? $_POST['dept_date'] : "";
  $arr_date = (isset($_POST['arr_date'])) ? $_POST['arr_date'] : "";
  $dept_time = (isset($_POST['dept_time'])) ? $_POST['dept_time'] : "";
  $arr_time = (isset($_POST['arr_time'])) ? $_POST['arr_time'] : "";
  $status = (isset($_POST['status'])) ? $_POST['status'] : "";
  $price = (isset($_POST['price'])) ? (float)$_POST['price'] : "";
  $num_tickets = (isset($_POST['num_tickets'])) ? (int)$_POST['num_tickets'] : "";
  $airplane_id = (isset($_POST['airplane_id'])) ? $_POST['airplane_id'] : "";
  $flight_num = (isset($_POST['flightnum'])) ? (int)$_POST['flightnum'] : "";
  $add_type = (isset($_POST['add_type'])) ? $_POST['add_type'] : "";

  $user = new AirlineStaff($identifier, $_SESSION['PASSWORD']);
  if(!$user->is_valid_user) {
    http_response_code(500);
    error_log("Unable to perform action due to session expiration or invalid credentials");
    echo("500 Unable to authenticate valid user credentials");
    return false;
  } else {
    if($add_type == "airplane") {
      $user->addAirplane($airline_name, $num_seats);
    } else if($add_type == "airport") {
      $user->addAirport($airport_name, $airport_city);
    } else if($add_type == "flight") {
      $airline_name = explode("/", $airline_airplane_id)[0];
      $airplane_id = explode("/", $airline_airplane_id)[1];
      $user->addFlight($airline_name, $deptairport_name, $dept_date, $dept_time, $arrairport_name, $arr_date, $arr_time, $price, $status, $airplane_id, $num_tickets);
    } else if($add_type == "update_flight") {
      $user->updateFlightStatus($flight_num, $status, $airline_name);
    }
  }
?>