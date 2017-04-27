<?php
  class AirlineStaff {
    // Initialize db_name connection and check for successful connection
    private $servername = 'localhost';
    private $db_username = 'root';
    private $db_password = 'root';
    private $db_name = 'airline_system';

    // set connection for object
    private $conn = null;
    public $is_valid_user = false;
    public $link = false;
    
    public function get($var) {
      return $this->$var;
    }
    
    // Declare a public constructor
    public function __construct() { 
      $link = mysqli_connect($this->servername, $this->db_username, $this->db_password, $this->db_name);
      // Check connection
      if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
      } else {
        $this->is_valid_system = true;
      }
    } // end __construct
        
    function __destruct() {
      // Close DB connection
      mysqli_close($this->link);
    }    
  }
?>