<?php
  class Flight {
    // Initialize db_name connection and check for successful connection
    private $servername = 'localhost';
    private $db_username = 'root';
    private $db_password = 'root';
    private $db_name = 'airline_system';

    // set connection for object
    public $link = false;
    public $is_valid_flight = false;

    public $flight_num = false;
    public $airline_name = false;
    public $departure_airport = false;
    public $departure_date = false;
    public $departure_time = false;
    public $arrival_airport = false;
    public $arrival_date = false;
    public $arrival_time = false;
    public $price = false;
    public $status = false;
    public $airplane_id = false;
    public $num_tickets = false;
    public $POSSIBLE_STATUSES = [];

    
    public function get($var) {
      return $this->$var;
    }
    
    // Declare a public constructor
    public function __construct($flight_num, $airline_name) {
      $this->flight_num = $flight_num;
      $this->airline_name = $airline_name;

      $this->link = mysqli_connect($this->servername, $this->db_username, $this->db_password, $this->db_name);
      // Check connection
      if (mysqli_connect_errno()) {
        error_log("Failed to connect to MySQL: " . mysqli_connect_error());
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        return false;
      }

      $query = sprintf("SELECT * FROM flight WHERE flight_num = '%s' AND airline_name = '%s'",
        mysqli_real_escape_string($this->link, $this->flight_num),
        mysqli_real_escape_string($this->link, $this->airline_name));
      $result = mysqli_query($this->link, $query);
      if (!$result || mysqli_num_rows($result) === 0) {
        error_log('"' . $query. '"' . " returned 0 rows/failed");
        return false;
      }

      $row = mysqli_fetch_assoc($result);

      $this->is_valid_flight = true;
      $this->departure_airport = $row['departure_airport'];
      $datetime = new DateTime($row['departure_time']);
      $this->departure_date = $datetime->format('m/d/Y');
      $this->departure_time = $datetime->format('h:s A');
      $this->arrival_airport = $row['arrival_airport'];
      $datetime = new DateTime($row['arrival_time']);
      $this->arrival_date = $datetime->format('m/d/Y');;
      $this->arrival_time = $datetime->format('h:s A');;
      $this->price = $row['price'];
      $this->status = $row['status'];
      $this->airplane_id = $row['airplane_id'];
      $this->num_tickets = $row['num_tickets'];
      array_push($this->POSSIBLE_STATUSES, "DELAYED", "IN-PROGRESS", "UPCOMING", "COMPLETED");
    }
        
    function __destruct() {
      // Close DB connection
      mysqli_close($this->link);
    }    
  }
?>