<?php
  class DBHelper {
    // Initialize db_name connection and check for successful connection
    private $servername = 'localhost';
    private $db_username = 'root';
    private $db_password = 'root';
    private $db_name = 'airline_system';

    // set connection for object
    public $link = false;
    public $is_valid_conn = false;
    
    // Declare a public constructor
    public function __construct() {
      $this->link = mysqli_connect($this->servername, $this->db_username, $this->db_password, $this->db_name);
      // Check connection
      if (mysqli_connect_errno()) {
        error_log("Failed to connect to MySQL: " . mysqli_connect_error());
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        return false;
      }

      $this->is_valid_conn = true;
    }

    function queryAllAirlines() {
      $query = "SELECT * FROM airline";
      $result = mysqli_query($this->link, $query);
      if(!$result) {
        error_log($query." failed");
        return false;
      }
      return $result;
    }

    function queryAllAirports() {
      $query = "SELECT * FROM airport";
      $result = mysqli_query($this->link, $query);
      if(!$result) {
        error_log($query." failed");
        return false;
      }
      return $result;
    }

    function getFlightStatuses() {
      return array("UPCOMING", "DELAYED", "IN-PROGRESS", "COMPLETED");
    }

    function queryAllAirplanes() {
      $query = "SELECT * FROM airplane";
      $result = mysqli_query($this->link, $query);
      if(!$result) {
        error_log($query." failed");
        return false;
      }
      return $result;
    }

    function queryAllCustomersForFlight($flight_num, $airline_name) {
      $query = sprintf("SELECT * FROM customer NATURAL JOIN purchases NATURAL JOIN ticket NATURAL JOIN flight WHERE flight_num = '%s' AND airline_name = '%s' GROUP BY flight_num ORDER BY purchase_date",
        mysqli_real_escape_string($this->link, $flight_num),
        mysqli_real_escape_string($this->link, $airline_name));

      $result = mysqli_query($this->link, $query);
      if(!$result) {
        error_log($query." failed");
        return false;
      }
      return $result;      
    }

    function queryBookingAgentsTickets() {
      $query = "SELECT * FROM booking_agent";
    }

    function __destruct() {
      // Close DB connection
      mysqli_close($this->link);
    }    
  }
?>