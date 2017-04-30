<?php 
  include('lib/session_mgr.php');
  $servername = 'localhost';
  $db_username = 'root';
  $db_password = 'root';
  $db_name = 'airline_system';

  $action = (isset($_POST['action'])) ? $_POST['action'] : "";
  $username = (isset($_POST['username'])) ? $_POST['username'] : "";
  $email = (isset($_POST['email'])) ? $_POST['email'] : "";
  $booking_agent_id = (isset($_POST['ba_id'])) ? (int)$_POST['ba_id'] : "";
  $password = (isset($_POST['password'])) ? md5(($_POST['password'])) : "";
  $firstname = (isset($_POST['firstname'])) ? $_POST['firstname'] : "";
  $lastname = (isset($_POST['lastname'])) ? $_POST['lastname'] : "";
  $buildingnum = (isset($_POST['buildingnum'])) ? $_POST['buildingnum'] : "";
  $street = (isset($_POST['street'])) ? $_POST['street'] : "";
  $city = (isset($_POST['city'])) ? $_POST['city'] : "";
  $state = (isset($_POST['state'])) ? $_POST['state'] : "";
  $phonenum = (isset($_POST['phonenum'])) ? (int)$_POST['phonenum'] : "";
  $passportnum = (isset($_POST['passportnum'])) ? $_POST['passportnum'] : "";
  $passportexptime = (isset($_POST['passportexp'])) ? strtotime($_POST['passportexp']) : "";
  $passportexp = date('Y-m-d',$passportexptime);
  $passport_country = (isset($_POST['passport_country'])) ? $_POST['passport_country'] : "";
  $dobtime = (isset($_POST['dob'])) ? strtotime($_POST['dob']) : "";
  $dob = date('Y-m-d',$dobtime);
  $airlinename = (isset($_POST['airlinename'])) ? $_POST['airlinename'] : "";
  $type = (isset($_POST['account_type'])) ? $_POST['account_type'] : "";

  $error = "";

  if($action == "signup") {
    $link = mysqli_connect($servername, $db_username, $db_password, $db_name);

    // Check connection
    if (mysqli_connect_errno()) {
      error_log('Failed to connect to MySQL: ' . mysqli_connect_error());
      $data = array('status' => 500, 'message' => 'Failed to connect to MySQL: ' . mysqli_connect_error());
      echo json_encode($data);
      exit;
    }
    $query = "";

    if($type == "customer") {
      $query = sprintf("INSERT INTO customer VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', %d, '%s', '$passportexp', '%s', '$dob')",
        mysqli_real_escape_string($link, $email),
        mysqli_real_escape_string($link, $firstname),
        mysqli_real_escape_string($link, $lastname),
        mysqli_real_escape_string($link, $password),
        mysqli_real_escape_string($link, $buildingnum),
        mysqli_real_escape_string($link, $street),
        mysqli_real_escape_string($link, $city),
        mysqli_real_escape_string($link, $state),
        mysqli_real_escape_string($link, $phonenum),
        mysqli_real_escape_string($link, $passportnum),
        mysqli_real_escape_string($link, $passport_country));
    } else if($type == "booking_agent") {
      $query = sprintf("INSERT INTO booking_agent VALUES ('%s', '%s', '%s', '%s', '%d')",
        mysqli_real_escape_string($link, $email),
        mysqli_real_escape_string($link, $password),
        mysqli_real_escape_string($link, $firstname),
        mysqli_real_escape_string($link, $lastname),
        mysqli_real_escape_string($link, $booking_agent_id));
    } else if($type == "airline_staff") {
      $query = sprintf("INSERT INTO airline_staff VALUES ('%s', '%s', '%s', '%s','$dob', '%s')",
        mysqli_real_escape_string($link, $username),
        mysqli_real_escape_string($link, $password),
        mysqli_real_escape_string($link, $firstname),
        mysqli_real_escape_string($link, $lastname),
        mysqli_real_escape_string($link, $airlinename));
    }

    $result = mysqli_query($link, $query);
    if (!$result) {
      error_log('Could not run query: ' . mysqli_error($link));
      http_response_code(500);
      echo 'Invalid field data';
      return false;
    } else {
      http_response_code(200);
      $data = array('status' => 200, 'message' => 'Successfully registered');
      echo json_encode($data);
      $_SESSION['PASSWORD'] = $password;
    }

  } else if ($action == "login") {
    if($type == "customer") {
      include('lib/Customer.php');
      $customer = new Customer($email, $password);
      if(!$customer->is_valid_user) {
        $error = 'Invalid user credentials';
      }
    }
    else if($type == "booking_agent") {
      include('lib/BookingAgent.php');
      $booking_agent = new BookingAgent($email, $password);
      if(!$booking_agent->is_valid_user) {
        $error = 'Invalid user credentials';
      }
    }
    else if($type == "airline_staff") {
      include('lib/AirlineStaff.php');
      $airline_staff = new AirlineStaff($username, $password);
      if(!$airline_staff->is_valid_user) {
        $error = 'Invalid user credentials';
      }
    }

    if($error != "") {
      http_response_code(500);
      error_log($error);
      echo($error);
      return false;
    } else {
      http_response_code(200);
      echo 'Successfully logged in';
      $_SESSION['PASSWORD'] = $password;
    }
  }

?>