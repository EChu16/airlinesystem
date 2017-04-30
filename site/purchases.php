<?php 
  include('lib/session_mgr.php'); include('lib/Customer.php'); include('lib/BookingAgent.php');
  $servername = 'localhost';
  $db_username = 'root';
  $db_password = 'root';
  $db_name = 'airline_system';

  $flight_num = (isset($_POST['flightnum'])) ? (int)$_POST['flightnum'] : "";
  $airline_name = (isset($_POST['airline_name'])) ? $_POST['airline_name'] : "";
  $num_tickets = (isset($_POST['numtickets'])) ? (int)$_POST['numtickets'] : "";
  $customer_email = (isset($_POST['customer_email'])) ? $_POST['customer_email'] : "";
  $email = (isset($_POST['identifier'])) ? $_POST['identifier'] : "";
  $type = (isset($_POST['account_type'])) ? $_POST['account_type'] : "";

  if($type == "customer") {
    $user = new Customer($email, $_SESSION['PASSWORD']);
  } else if($type == "booking_agent"){
    $user = new BookingAgent($email, $_SESSION['PASSWORD']);
  } else {
    error_log('Unauthorized user attempting to purchase ticket: '.$_SESSION['REMOTE_ADDR']);
    http_response_code(500);
    echo 'Unauthorized user';
    return false;
  }

  if(!$user->is_valid_user) {
    error_log('Unauthorized user attempting to purchase ticket: '.$_SESSION['REMOTE_ADDR']);
    http_response_code(500);
    echo 'Unauthorized user';
    return false;
  } else {
    $successful_purchase = true;
    for($i = 0; $i < $num_tickets; $i++) {
      $no_error = $user->purchaseTicketForFlight($flight_num, $airline_name, $customer_email);
      if(!$no_error) {
        error_log($user->email.' failed to purchase ticket for flight number: '.$flight_num);
        $successful_purchase = false;
        break;
      }
    }
    if(!$successful_purchase) {
      http_response_code(500);
      echo 'Failed to purchase ticket';
      return false;
    } else {
      http_response_code(200);
      echo 'Successfully purchased ticket';
    }
  }

?>