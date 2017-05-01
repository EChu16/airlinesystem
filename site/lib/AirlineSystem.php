<?php
  class AirlineSystem {
    // Initialize db_name connection and check for successful connection
    private $servername = 'localhost';
    private $db_username = 'root';
    private $db_password = 'root';
    private $db_name = 'airline_system';

    // set connection for object
    public $link = false;
    public $is_valid_system = false;
    public $flights = false;
    
    public function get($var) {
      return $this->$var;
    }
    
    // Declare a public constructor
    public function __construct($type = "", $identifier = "") { 
      $this->link = mysqli_connect($this->servername, $this->db_username, $this->db_password, $this->db_name);
      // Check connection
      if (mysqli_connect_errno()) {
        error_log("Failed to connect to MySQL: " . mysqli_connect_error());
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }

      $query = "CREATE OR REPLACE VIEW full_flights AS 
                (SELECT f.*, 
                  (select airport_city from airport where f.departure_airport = airport.airport_name) AS departure_city, 
                  (select airport_city from airport where f.arrival_airport = airport.airport_name) AS arrival_city FROM flight f);";

      $result = mysqli_query($this->link, $query);
      if (!$result) {
        error_log('"' . $query. '"' . " failed to instantiate view");
        return false;
      }

      $this->is_valid_system = true;
    } // end __construct
        
    function __destruct() {
      // Close DB connection
      mysqli_close($this->link);
    }

    function getAllExistingFlights() {
      $query = "SELECT * FROM full_flights ORDER BY departure_time";
      $result = mysqli_query($this->link, $query);

      if (!$result || mysqli_num_rows($result) === 0) {
        error_log('"' . $query. '"' . " returned 0 rows/failed");
        return false;
      }

      return $this->reconstructResults($result);
    }

    function changeFlightStatus($flight_num, $airline_name, $new_status) {
      $query = sprintf("UPDATE flight SET status = '%s' WHERE flight_num = '%s' AND airline_name = '%s'",
        mysqli_real_escape_string($this->link, $new_status),
        mysqli_real_escape_string($this->link, $flight_num),
        mysqli_real_escape_string($this->link, $airline_name));

      $result = mysqli_query($this->link, $query);
      if (!$result || mysqli_num_rows($result) === 0) {
        error_log('"' . $query. '"' . " failed to execute or affected 0 rows");
        return false;
      }
      return true;
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

        // Update Flight status "realtime"
        $no_error = true;
        $curr_datetime = new DateTime();

        if($curr_datetime > $arr_datetime && strtoupper($row['status']) != "COMPLETED") {
          $no_error = $this->changeFlightStatus($row['flight_num'], $row['airline_name'], "COMPLETED");
          $allFlightInfo[$counter]['status'] = "COMPLETED";
        } else if ($curr_datetime < $dept_datetime && strtoupper($row['status']) != "UPCOMING") {
          $no_error = $this->changeFlightStatus($row['flight_num'], $row['airline_name'], "UPCOMING");
          $allFlightInfo[$counter]['status'] = "UPCOMING";
        } else if(strtoupper($row['status']) != "DELAYED" || strtoupper($row['status']) != "IN-PROGRESS") {
          $no_error = $this->changeFlightStatus($row['flight_num'], $row['airline_name'], "IN-PROGRESS");
          $allFlightInfo[$counter]['status'] = "IN-PROGRESS";
        }

        if(!$no_error) {
          return false;
        }
        $counter += 1;
      }
      return $allFlightInfo;
    }

    function filteredSearch($flightnum, $deptdate, $arrivaldate, $deptcity, $arrivalcity, $deptairport, $arrivalairport) {
      if(empty($flightnum) && empty($deptdate) && empty($arrivaldate) && empty($deptcity) && empty($arrivalcity) && empty($deptairport) && empty($arrivalairport)) {
        return $this->getAllExistingFlights();
      }
      $base_query = "SELECT * FROM full_flights WHERE ";
      $append_and = false;
      if (!empty($flightnum)) {
        $base_query .= "flight_num LIKE '".$flightnum."%'";
        $append_and = true;
      }
      if (!empty($deptdate)) {
        if ($append_and) {
          $base_query .= "AND ";
        }
        $deptdate_obj = date('Y-m-d',strtotime($deptdate));
        $base_query .= 'CAST(departure_time AS DATE) = CAST("'.$deptdate_obj.'" AS DATE)';
        $append_and = true;
      }
      if (!empty($arrivaldate)) {
        if ($append_and) {
          $base_query .= "AND ";
        }
        $arrivaldate_obj = date('Y-m-d',strtotime($arrivaldate));
        $base_query .= 'CAST(arrival_time AS DATE) = CAST("'.$arrivaldate_obj.'" AS DATE)';
        $append_and = true;
      }
      if (!empty($deptcity)) {
        if ($append_and) {
          $base_query .= "AND ";
        }
        $base_query .= 'departure_city LIKE "'.$deptcity.'%"';
        $append_and = true;
      }
      if (!empty($arrivalcity)) {
        if ($append_and) {
          $base_query .= "AND ";
        }
        $base_query .= 'arrival_city LIKE "'.$arrivalcity.'%"';
        $append_and = true;
      }
      if (!empty($deptairport)) {
        if ($append_and) {
          $base_query .= "AND ";
        }
        $base_query .= 'departure_airport LIKE "'.$deptairport.'%"';
        $append_and = true;
      }
      if (!empty($arrivalairport)) {
        if ($append_and) {
          $base_query .= "AND ";
        }
        $base_query .= 'arrival_airport LIKE "'.$arrivalairport.'%"';
        $append_and = true;
      }

      $base_query .= ' ORDER BY departure_time';

      $result = mysqli_query($this->link, $base_query);

      if (!$result) {
        error_log('"' . $base_query. '"' . " failed");
        return false;
      }

      return $this->reconstructResults($result);
    }

    function filteredSearchByUser($flightnum, $deptdate, $arrivaldate, $deptcity, $arrivalcity, $deptairport, $arrivalairport, $type_identifier, $identifier, $type) {
      if(empty($flightnum) && empty($deptdate) && empty($arrivaldate) && empty($deptcity) && empty($arrivalcity) && empty($deptairport) && empty($arrivalairport)) {
        return $this->getUserFlights($identifier, $type);
      }

      if($type == "customer") {
        $base_query = "SELECT *, COUNT(flight_num) AS num_tickets_purchased FROM full_flights NATURAL JOIN ticket NATURAL JOIN purchases WHERE purchases.customer_email = '".$type_identifier."'";
      } else if($type == "booking_agent") {
        $base_query = "SELECT *, COUNT(flight_num) AS num_tickets_purchased FROM full_flights NATURAL JOIN ticket NATURAL JOIN purchases WHERE purchases.booking_agent_id = '".$type_identifier."'";
      } else {
        $base_query = "SELECT * FROM full_flights WHERE airline_name = '".$type_identifier."'";
      }

      if (!empty($flightnum)) {
        $base_query .= " AND flight_num LIKE '".$flightnum."%'";
      }
      if (!empty($deptdate)) {
        $deptdate_obj = date('Y-m-d',strtotime($deptdate));
        $base_query .= ' AND CAST(departure_time AS DATE) = CAST("'.$deptdate_obj.'" AS DATE)';
      }
      if (!empty($arrivaldate)) {
        $arrivaldate_obj = date('Y-m-d',strtotime($arrivaldate));
        $base_query .= ' AND CAST(arrival_time AS DATE) = CAST("'.$arrivaldate_obj.'" AS DATE)';
      }
      if (!empty($deptcity)) {
        $base_query .= ' AND departure_city LIKE "'.$deptcity.'%"';
      }
      if (!empty($arrivalcity)) {
        $base_query .= ' AND arrival_city LIKE "'.$arrivalcity.'%"';
      }
      if (!empty($deptairport)) {
        $base_query .= ' AND departure_airport LIKE "'.$deptairport.'%"';
      }
      if (!empty($arrivalairport)) {
        $base_query .= ' AND arrival_airport LIKE "'.$arrivalairport.'%"';
      }

      if($type == "customer" || $type == "booking_agent") {
        $base_query .= ' GROUP BY flight_num ORDER BY purchase_date DESC';
      } else {
        $base_query .= ' ORDER BY departure_time';
      }

      error_log($base_query);

      $result = mysqli_query($this->link, $base_query);

      if (!$result) {
        error_log('"' . $base_query. '"' . " failed");
        return false;
      }

      return $this->reconstructResults($result);
    }

    function getDefaultCustomerFlights($identifier) {
      $query = sprintf("SELECT *, COUNT(flight_num) AS num_tickets_purchased FROM full_flights NATURAL JOIN ticket NATURAL JOIN purchases WHERE purchases.customer_email = '%s' GROUP BY flight_num ORDER BY purchase_date DESC",
        mysqli_real_escape_string($this->link, $identifier));

      $result = mysqli_query($this->link, $query);

      if (!$result || mysqli_num_rows($result) === 0) {
        error_log('"' . $query. '"' . " returned 0 rows/failed");
      }
      return $this->reconstructResults($result);
    }

    function getDefaultBookingAgentFlights($identifier) {
      $query = sprintf("SELECT *, COUNT(flight_num) AS num_tickets_purchased FROM full_flights NATURAL JOIN ticket NATURAL JOIN purchases WHERE purchases.booking_agent_id = '%s' AND departure_time > NOW() GROUP BY flight_num ORDER BY purchase_date DESC",
        mysqli_real_escape_string($this->link, $identifier));

      $result = mysqli_query($this->link, $query);

      if (!$result || mysqli_num_rows($result) === 0) {
        error_log('"' . $query. '"' . " returned 0 rows/failed");
      }
      return $this->reconstructResults($result);
    }

    function getDefaultAirlineStaffFlights($identifier) {
      $query = sprintf("SELECT * FROM full_flights WHERE airline_name = '%s' AND departure_time < NOW() + INTERVAL 30 DAY ORDER BY departure_time",
        mysqli_real_escape_string($this->link, $identifier));

      $result = mysqli_query($this->link, $query);

      if (!$result || mysqli_num_rows($result) === 0) {
        error_log('"' . $query. '"' . " returned 0 rows/failed");
      }
      return $this->reconstructResults($result);
    }

    function getUserFlights($identifier, $type) {
      if($type == "customer") {
        if(!class_exists('Customer')) {
          include('lib/Customer.php');
        }
        $user = new Customer($identifier, $_SESSION['PASSWORD']);
      } else if($type == "booking_agent") {
        if(!class_exists('BookingAgent')) {
          include('lib/BookingAgent.php');
        }
        $user = new BookingAgent($identifier, $_SESSION['PASSWORD']);
      } else if($type == "airline_staff") {
        if(!class_exists('AirlineStaff')) {
          include('lib/AirlineStaff.php');
        }
        $user = new AirlineStaff($identifier, $_SESSION['PASSWORD']);
      } else {
        http_response_code(500);
        error_log("Invalid user");
        echo("Invalid user. Try relogging");
      }

      if(!$user->is_valid_user) {
        http_response_code(500);
        error_log("Invalid user");
        echo("Invalid user. Try relogging");
      } else {
        if($type == "customer") {
          return $this->getDefaultCustomerFlights($user->email);
        } else if($type == "booking_agent") {
          return $this->getDefaultBookingAgentFlights($user->booking_agent_id);
        } else {
          return $this->getDefaultAirlineStaffFlights($user->airline_name);
        }
      }
    }
  }
?>