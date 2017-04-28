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
    public $airline_name = false;
    
    public function get($var) {
      return $this->$var;
    }
    
    // Declare a public constructor
    public function __construct($username, $password) {
      $this->username = $username;
      $this->password = md5($password);

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
      if (!$result) {
        error_log("Invalid user credentials");
        return false;
      }

      $row = mysqli_fetch_assoc($result);

      $this->is_valid_user = true;
      $this->first_name = $row['first_name'];
      $this->last_name = $row['last_name'];
    }
        
    function __destruct() {
      // Close DB connection
      mysqli_close($this->link);
    }    
  }
?>