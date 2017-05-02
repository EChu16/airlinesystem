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

    function queryBookingAgentStats() {
      $query = "SELECT *, COUNT(ticket_id) AS total_tickets, SUM(price) * .1 AS commission_earnings FROM booking_agent NATURAL JOIN purchases NATURAL JOIN ticket NATURAL JOIN flight WHERE purchase_date > DATE_SUB(CURRENT_DATE(), INTERVAL 1 YEAR) GROUP BY booking_agent_id ORDER BY total_tickets  DESC LIMIT 5";
      $result = mysqli_query($this->link, $query);
      if(!$result) {
        error_log($query." failed");
        return false;
      }
      return $result;      
    }

    function queryBookingAgentStatsMonth() {
      $query = "SELECT *, COUNT(ticket_id) AS total_tickets, SUM(price) * .1 AS commission_earnings FROM booking_agent NATURAL JOIN purchases NATURAL JOIN ticket NATURAL JOIN flight WHERE purchase_date > DATE_SUB(CURRENT_DATE(), INTERVAL 30 DAY) GROUP BY booking_agent_id ORDER BY total_tickets  DESC LIMIT 5";
      $result = mysqli_query($this->link, $query);
      if(!$result) {
        error_log($query." failed");
        return false;
      }
      return $result;      
    }

    function queryFreqCustomersForAirline($airline_name) {
      $query = sprintf("SELECT * FROM customer JOIN (
                          SELECT DISTINCT customer_email,COUNT(*) as total_tickets FROM ticket NATURAL JOIN purchases NATURAL JOIN customer WHERE airline_name = '%s' AND purchase_date > DATE_SUB(CURRENT_DATE(), INTERVAL 1 YEAR) GROUP BY customer_email,email ORDER BY total_tickets
                            ) AS ct GROUP BY customer_email ORDER BY total_tickets DESC",
        mysqli_real_escape_string($this->link, $airline_name));

      $result = mysqli_query($this->link, $query);
      error_log($query);
      if(!$result) {
        error_log($query." failed");
        return false;
      }
      return $result;      
    }

    function queryUserFlightsForAirline($airline_name, $customer_email) {
      $query = sprintf("SELECT * FROM full_flights NATURAL JOIN ticket NATURAL JOIN purchases NATURAL JOIN customer WHERE email='%s' AND airline_name = '%s' GROUP BY flight_num ORDER BY departure_time",
        mysqli_real_escape_string($this->link, $customer_email),
        mysqli_real_escape_string($this->link, $airline_name));

      $result = mysqli_query($this->link, $query);
      if(!$result) {
        error_log($query." failed");
        return false;
      }
      return $this->reconstructResults($result);
    }

    function reconstructResults($result) {
      $allFlightInfo = array();
      $counter = 0;
      // Break datetime into date and time
      while($row = mysqli_fetch_assoc($result)) {
        $allFlightInfo[$counter] = $row;
        $dept_datetime = new DateTime($row['departure_time']);
        $allFlightInfo[$counter]['departure_date'] = $dept_datetime->format('m/d/Y');
        $allFlightInfo[$counter]['departure_time'] = $dept_datetime->format('h:s A');
        $arr_datetime = new DateTime($row['arrival_time']);
        $allFlightInfo[$counter]['arrival_date'] = $arr_datetime->format('m/d/Y');
        $allFlightInfo[$counter]['arrival_time'] = $arr_datetime->format('h:i A');

        $counter += 1;
      }
      return $allFlightInfo;
    }

    function __destruct() {
      // Close DB connection
      mysqli_close($this->link);
    }    
  }
?>