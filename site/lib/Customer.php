<?php
  class Customer {
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
    public $building_num = false;
    public $street = false;
    public $city = false;
    public $state = false;
    public $phone_number = false;
    public $passport_number = false;
    public $passport_expiration = false;
    public $passport_expiration_formatted = false;
    public $passport_country = false;
    public $date_of_birth = false;
    public $date_of_birth_formatted = false;
    
    public function get($var) {
      return $this->$var;
    }
    
    // Declare a public constructor
    public function __construct($email, $password) {
      $this->email = $email;
      $this->password = $password;
      $this->link = mysqli_connect($this->servername, $this->db_username, $this->db_password, $this->db_name);

      // Check connection
      if (mysqli_connect_errno()) {
        error_log("Failed to connect to MySQL: " . mysqli_connect_error());
        return false;
      }

      $query = sprintf("SELECT * FROM customer WHERE email = '%s' AND password = '%s'",
        mysqli_real_escape_string($this->link, $this->email),
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
      $this->building_num = $row['building_number'];
      $this->street = $row['street'];
      $this->city = $row['city'];
      $this->state = $row['state'];
      $this->phone_number = $row['phone_number'];
      $this->passport_number = $row['passport_number'];
      $this->passport_expiration = $row['passport_expiration'];
      $datetime = new DateTime($this->passport_expiration);
      $this->passport_expiration_formatted = $datetime->format('m/d/Y');
      $this->passport_country = $row['passport_country'];
      $this->date_of_birth = $row['date_of_birth'];
      $datetime = new DateTime($this->date_of_birth);
      $this->date_of_birth_formatted = $datetime->format('m/d/Y');
    }
    
    function decreaseAvailableTickets($flight_num, $airline_name) {
      $query = sprintf("UPDATE flight SET num_tickets = num_tickets - 1 WHERE flight_num = '%s' AND airline_name = '%s' AND num_tickets > 0",
        mysqli_real_escape_string($this->link, $flight_num),
        mysqli_real_escape_string($this->link, $airline_name));

      $result = mysqli_query($this->link, $query);
      if (!$result || mysqli_num_rows($result) === 0) {
        error_log('"' . $query. '"' . " failed to execute or affected 0 rows");
        return false;
      }
      return true;
    }

    function increaseAvailableTickets($flight_num, $airline_name) {
      $query = sprintf("UPDATE flight SET num_tickets = num_tickets + 1 WHERE flight_num = '%s' AND airline_name = '%s'",
        mysqli_real_escape_string($this->link, $flight_num),
        mysqli_real_escape_string($this->link, $airline_name));

      $result = mysqli_query($this->link, $query);
      if (!$result || mysqli_num_rows($result) === 0) {
        error_log('"' . $query. '"' . " failed to execute or affected 0 rows");
        return false;
      }
      return true;
    }

    function deleteTicketIfInvalid($ticket_id) {
      $query = sprintf("DELETE FROM ticket WHERE ticket_id = '%s'",
        mysqli_real_escape_string($this->link, $ticket_id));
      $result = mysqli_query($this->link, $query);
      if (mysqli_affected_rows($this->link) == 0) {
        error_log('"' . $query. '"' . " failed to delete invalid ticket with ticket id: ".$ticket_id);
        return false;
      }
      return true;
    }

    function purchaseTicketForFlight($flight_num, $airline_name, $customer_email) {
      $no_error = $this->decreaseAvailableTickets($flight_num, $airline_name);
      if(!$no_error) {
        error_log("Couldn't decrement tickets. Possibly no more");
        return false;
      }

      $digits = 9;
      $ticket_id = rand(pow(10, $digits-1), pow(10, $digits)-1);
      $query = sprintf("INSERT INTO ticket VALUES('%d', '%s', '%s')",
        mysqli_real_escape_string($this->link, $ticket_id),
        mysqli_real_escape_string($this->link, $airline_name),
        mysqli_real_escape_string($this->link, $flight_num));
      $result = mysqli_query($this->link, $query);
      if (mysqli_affected_rows($this->link) == 0) {
        error_log('"' . $query. '"' . " failed to insert new ticket with ticket id: ".$ticket_id);
        return false;
      }

      $curr_datetime = new DateTime();

      $query = sprintf("INSERT INTO purchases VALUES ('%d', '%s', '', '%s')",
        mysqli_real_escape_string($this->link, $ticket_id),
        mysqli_real_escape_string($this->link, $this->email),
        mysqli_real_escape_string($this->link, $curr_datetime->format('Y-m-d H:i:s')));

      $result = mysqli_query($this->link, $query);
      if (mysqli_affected_rows($this->link) == 0) {
        error_log('"' . $query. '"' . " failed to insert into purchases with ticket_id: ".$ticket_id." - ".$this->email);
        $this->increaseAvailableTickets($flight_num, $airline_name);
        $this->deleteTicketIfInvalid($ticket_id);
        return false;
      }
      return true;
    }

    function __destruct() {
      // Close DB connection
      mysqli_close($this->link);
    }    
  }
?>