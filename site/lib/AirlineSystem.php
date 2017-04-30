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
      $query = "SELECT * FROM full_flights";
      $result = mysqli_query($this->link, $query);

      if (!$result || mysqli_num_rows($result) === 0) {
        error_log('"' . $query. '"' . " returned 0 rows/failed");
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
        $datetime = new DateTime($row['departure_time']);
        $allFlightInfo[$counter]['departure_date'] = $datetime->format('m/d/Y');
        $allFlightInfo[$counter]['departure_time'] = $datetime->format('h:s A');
        $datetime = new DateTime($row['arrival_time']);
        $allFlightInfo[$counter]['arrival_date'] = $datetime->format('m/d/Y');
        $allFlightInfo[$counter]['arrival_time'] = $datetime->format('h:i A');
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
        $base_query .= "flight_num = ".$flightnum;
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
        $base_query .= 'departure_city="'.$deptcity.'"';
        $append_and = true;
      }
      if (!empty($arrivalcity)) {
        if ($append_and) {
          $base_query .= "AND ";
        }
        $base_query .= 'arrival_city="'.$arrivalcity.'"';
        $append_and = true;
      }
      if (!empty($deptairport)) {
        if ($append_and) {
          $base_query .= "AND ";
        }
        $base_query .= 'departure_airport="'.$deptairport.'"';
        $append_and = true;
      }
      if (!empty($arrivalairport)) {
        if ($append_and) {
          $base_query .= "AND ";
        }
        $base_query .= 'arrival_airport="'.$arrivalairport.'"';
        $append_and = true;
      }

      $result = mysqli_query($this->link, $base_query);
      error_log($base_query);

      if (!$result) {
        error_log('"' . $base_query. '"' . " failed");
        return false;
      }

      return $this->reconstructResults($result);
    }
  }
?>