<?php 
  $servername = 'localhost';
  $db_username = 'root';
  $db_password = 'root';
  $db_name = 'airline_system';

  $action = (isset($_POST['action'])) ? $_POST['action'] : "";
  error_log($_POST['action']);
  $username = (isset($_POST['username'])) ? $_POST['username'] : "";
  $email = (isset($_POST['email'])) ? $_POST['email'] : "";
  $password = (isset($_POST['password'])) ? $_POST['password'] : "";
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

  if($action == "signup") {
    $link = mysqli_connect($servername, $db_username, $db_password, $db_name);

    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      return false;
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
    } /*else if($type == "booking_agent") {
      $query = sprintf("INSERT INTO booking_agent (email, first_name, last_name, password) VALUES ('%s', '%s', '%s', '%s')",
        mysqli_real_escape_string($email, $firstname, $lastname, $password));

    } else if($type == "airline_staff") {
      $query = sprintf("INSERT INTO airline_staff (username, first_name, last_name, password) VALUES ('%s', '%s', '%s', '%s')",
        mysqli_real_escape_string($username, $firstname, $lastname, $password));
    }*/

    $result = mysqli_query($link, $query);
    if (!$result) {
      echo 'Could not run query: ' . mysqli_error($link);
      return false;
    } else {
      return true;
    }

  } else if ($action == "login") {
    if($type == "customer") {
      include('lib/Customer.php');
      $customer = new Customer($email, $password);
      if($customer->is_valid_user) {
        return true;
      }
    }
    else if($type == "booking_agent") {
      include('lib/BookingAgent.php');
      $booking_agent = new BookingAgent($email, $password);
      if($booking_agent->is_valid_user) {
        return true;
      }
    }
    else if($type == "airline_staff") {
      include('lib/AirlineStaff.php');
      $airline_staff = new AirlineStaff($email, $password);
      if($airline_staff->is_valid_user) {
        return true;
      }
    }
  }

?>)