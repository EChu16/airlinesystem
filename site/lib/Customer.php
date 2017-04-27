<?php
  class Customer {
    // Initialize db_name connection and check for successful connection
    private $servername = 'localhost';
    private $db_username = 'root';
    private $db_password = 'root';
    private $db_name = 'airline_system';

    // set connection for object
    private $conn = null;
    public $link = false;

    public $is_valid_user = false;
    public $email = false;
    public $password = false;
    public $name = false;
    
    public function get($var) {
      return $this->$var;
    }
    
    // Declare a public constructor
    public function __construct($email, $password) {
      $this->email = $email;
      $this->password = md5($password);
      $link = mysqli_connect($this->servername, $this->db_username, $this->db_password, $this->db_name);

      // Check connection
      if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        return
      }

      $query = sprintf("SELECT * FROM customers WHERE email = '%s' AND password = '%s'",
        mysqli_real_escape_string($this->email, $this->password));
      $result = mysqli_query($query);
      if (!$result) {
          echo 'Could not run query: ' . mysqli_error();
          return false;
      }
      $row = mysql_fetch_assoc($result);

      $this->is_valid_user = true;
      $this->first_name = $row['name'];
    } // end __construct
        
    function __destruct() {
      // Close DB connection
      mysqli_close($this->link);
    }    
  }
?>