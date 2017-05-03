<?php
  class AirlineStaff {
    // Initialize db_name connection and check for successful connection
    private $servername = 'localhost';
    private $db_username = 'root';
    private $db_password = 'root';
    private $db_name = 'airline_system';

    // set connection for object
    public $link = false;
    public $is_valid_user = false;

    public $username = false;
    public $password = false;
    public $first_name = false;
    public $last_name = false;
    public $date_of_birth = false;
    public $date_of_birth_formatted = false;
    public $airline_name = false;
    
    public function get($var) {
      return $this->$var;
    }
    
    // Declare a public constructor
    public function __construct($username, $password) {
      $this->username = $username;
      $this->password = $password;

      $this->link = mysqli_connect($this->servername, $this->db_username, $this->db_password, $this->db_name);
      // Check connection
      if (mysqli_connect_errno()) {
        error_log("Failed to connect to MySQL: " . mysqli_connect_error());
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        return false;
      }

      $query = sprintf("SELECT * FROM airline_staff WHERE username = '%s' AND password = '%s'",
        mysqli_real_escape_string($this->link, $this->username),
        mysqli_real_escape_string($this->link, $this->password));
      $result = mysqli_query($this->link, $query);
      if (!$result || mysqli_num_rows($result) === 0) {
        error_log('"' . $query. '"' . " returned 0 rows/failed");
        return false;
      }

      $row = mysqli_fetch_assoc($result);

      $this->is_valid_user = true;
      $this->first_name = $row['first_name'];
      $this->last_name = $row['last_name'];
      $this->date_of_birth = $row['date_of_birth'];
      $datetime = new DateTime($this->date_of_birth);
      $this->date_of_birth_formatted = $datetime->format('m/d/Y');
      $this->airline_name = $row['airline_name'];
    }

    function addAirplane($airline_name, $num_seats) {
      $digits = 8;
      $airplane_id = rand(pow(10, $digits-1), pow(10, $digits)-1);
      $query = sprintf("INSERT INTO airplane VALUES('%s', '%d', '%d')",
        mysqli_real_escape_string($this->link, $airline_name),
        mysqli_real_escape_string($this->link, $airplane_id),
        mysqli_real_escape_string($this->link, $num_seats));
      $result = mysqli_query($this->link, $query);
      if (mysqli_affected_rows($this->link) == 0) {
        error_log('"' . $query. '"' . " failed to insert new airplane with airplane id: ".$airplane_id);
        echo 'Unable to insert airplane, try again.';
        return false;
      }
      error_log('Created new airplane with id: '.$airplane_id.' with seats: '.$num_seats);
      echo 'Successfully created new airplane ['.$airplane_id.'] for '.$airline_name;
    }

    function addAirport($airport_name, $airport_city) {
      $query = sprintf("INSERT INTO airport VALUES('%s', '%s')",
        mysqli_real_escape_string($this->link, $airport_name),
        mysqli_real_escape_string($this->link, $airport_city));
      $result = mysqli_query($this->link, $query);
      if (mysqli_affected_rows($this->link) == 0) {
        http_response_code(500);
        error_log('"' . $query. '"' . " failed to insert new airport with airport name: ".$airport_name);
        echo 'Existing airport exists.';
        return false;
      }
      http_response_code(200);
      error_log('Created new airport with name: '.$airport_name.' for city: '.$airport_city);
      echo 'Successfully created new airport ['.$airport_name.'] for '.$airport_city;
    }

    function addFlight($airline_name, $deptairport_name, $dept_date, $dept_time, $arrairport_name, $arr_date, $arr_time, $price, $status, $airplane_id, $num_tickets) {
      $digits = 8;
      $flight_num = rand(pow(10, $digits-1), pow(10, $digits)-1);
      $dept_datetime = DateTime::createFromFormat('m/d/Y h:i:s', $dept_date.' '.$dept_time);
      $dept_datetime_formatted = $dept_datetime->format('Y-m-d h:i:s');
      $arr_datetime = DateTime::createFromFormat('m/d/Y h:i:s', $arr_date.' '.$arr_time);
      $arr_datetime_formatted = $dept_datetime->format('Y-m-d h:i:s');

      $query = sprintf("INSERT INTO flight VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
        mysqli_real_escape_string($this->link, $airline_name),
        mysqli_real_escape_string($this->link, $flight_num),
        mysqli_real_escape_string($this->link, $deptairport_name),
        mysqli_real_escape_string($this->link, $dept_datetime_formatted),
        mysqli_real_escape_string($this->link, $arrairport_name),
        mysqli_real_escape_string($this->link, $arr_datetime_formatted),
        mysqli_real_escape_string($this->link, $price),
        mysqli_real_escape_string($this->link, $status),
        mysqli_real_escape_string($this->link, $airplane_id));
      $result = mysqli_query($this->link, $query);
      if (mysqli_affected_rows($this->link) == 0) {
        error_log('"' . $query. '"' . " failed to insert new flight with flight num: ".$flight_num);
        echo 'Unable to insert flight, try again.';
        return false;
      }
      error_log('Created new flight with #: '.$flight_num.' for airline: '.$airline_name);
      echo 'Successfully created new flight ['.$flight_num.'] for '.$airline_name;
    }

    function updateFlightStatus($flight_num, $status, $airline_name) {
      $query = sprintf("UPDATE flight SET status = '%s' WHERE flight_num = '%s' AND airline_name = '%s'",
        mysqli_real_escape_string($this->link, $status),
        mysqli_real_escape_string($this->link, $flight_num),
        mysqli_real_escape_string($this->link, $airline_name));

      $result = mysqli_query($this->link, $query);
      if (!$result || mysqli_num_rows($result) === 0) {
        error_log('"' . $query. '"' . " failed to execute or affected 0 rows");
        return false;
      }
      http_response_code(200);
      error_log('Successfully updated flight ['.$flight_num.'] to '.$status);
      echo 'Successfully updated flight ['.$flight_num.'] to '.$status;
    }

    function getTotalTickets() {
      $query = sprintf("SELECT count(*) AS 'total_num_tickets' FROM purchases NATURAL JOIN ticket NATURAL JOIN flight WHERE airline_name = '%s' AND purchase_date > NOW() - INTERVAL 30 DAY",
        mysqli_real_escape_string($this->link, $this->airline_name));
      $result = mysqli_query($this->link, $query);
      if (!$result || mysqli_num_rows($result) === 0) {
        error_log('"' . $query. '"' . " returned 0 rows/failed");
        echo 'Internal Error: 500 Server failure';
        return false;
      }
      $row = mysqli_fetch_assoc($result);
      $total_tickets = array();
      $total_tickets['total_tickets'] = $row['total_num_tickets'];
      return $total_tickets;
    }

    function recalculateTotalTickets($fromdate, $todate) {
      $fromdate_obj = date('Y-m-d',strtotime($fromdate));
      $todate_obj = date('Y-m-d',strtotime($todate));
      $query = sprintf('SELECT count(*) AS total_num_tickets FROM purchases NATURAL JOIN ticket NATURAL JOIN flight WHERE airline_name = "%s" AND CAST("'.$fromdate_obj.'" AS DATE) <= CAST(purchase_date AS DATE) AND CAST(purchase_date AS DATE) <= CAST("'.$todate_obj.'" AS DATE)',
        mysqli_real_escape_string($this->link, $this->airline_name));
      $result = mysqli_query($this->link, $query);
      if (!$result || mysqli_num_rows($result) === 0) {
        error_log('"' . $query. '"' . " returned 0 rows/failed");
        echo 'Internal Error: 500 Server failure';
        return false;
      }
      $row = mysqli_fetch_assoc($result);
      error_log($query);
      $total_tickets = array();
      $total_tickets['total_tickets'] = $row['total_num_tickets'];
      return $total_tickets;
    }

    function __destruct() {
      // Close DB connection
      mysqli_close($this->link);
    }    
  }
?>