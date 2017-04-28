<?php
  class BookingAgent {
    // Initialize db_name connection and check for successful connection
    private $servername = 'localhost';
    private $db_username = 'root';
    private $db_password = 'root';
    private $db_name = 'airline_system';

    // set connection for object
    public $link = false;
    public $is_valid_user = false;

    public $email = false;
    public $password = false;
    public $first_name = false;
    public $last_name = false;
    public $id = false;

    public function get($var) {
      return $this->$var;
    }
    
    // Declare a public constructor
    public function __construct($email, $password) {
      $this->email = $email;
      $this->password = md5($password);

      $this->link = mysqli_connect($this->servername, $this->db_username, $this->db_password, $this->db_name);
      // Check connection
      if (mysqli_connect_errno()) {
        error_log("Failed to connect to MySQL: " . mysqli_connect_error());
        return false;
      }

      $query = sprintf("SELECT * FROM booking_agent WHERE email = '%s' AND password = '%s'",
        mysqli_real_escape_string($this->link, $this->email),
        mysqli_real_escape_string($this->link, $this->password));
      $result = mysqli_query($this->link, $query);
      if (!$result || mysqli_num_rows($result) === 0) {
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