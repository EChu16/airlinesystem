<?php 
  include('lib/session_mgr.php'); include('lib/BookingAgent.php');
  $servername = 'localhost';
  $db_username = 'root';
  $db_password = 'root';
  $db_name = 'airline_system';

  $identifier = (isset($_POST['identifier'])) ? $_POST['identifier'] : "";
  $fromdate = (isset($_POST['from-date'])) ? $_POST['from-date'] : "";
  $todate = (isset($_POST['to-date'])) ? $_POST['to-date'] : "";

  $user = new BookingAgent($identifier, $_SESSION['PASSWORD']);
  if(!$user->is_valid_user) {
    http_response_code(500);
    error_log("Unable to recalculate commission due to session expiration or invalid credentials");
    echo("500 Unable to authenticate valid user credentials");
    return false;
  } else if(empty($fromdate) || empty($todate)) {
    http_response_code(500);
    error_log("Empty from or to date during recalculating commision stats");
    echo("Both from and to date must be entered to recalculate");
  } else {
    http_response_code(200);
    echo json_encode($user->recalculateCommissionStats($fromdate, $todate));
  }
?>