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
    public $booking_agent_id = false;

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

      $query = sprintf("SELECT * FROM booking_agent WHERE email = '%s' AND password = '%s'",
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
      $this->booking_agent_id = $row['booking_agent_id'];
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

      $digits = 8;
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

      $query = sprintf("INSERT INTO purchases VALUES ('%d', '%s', '%s', '%s')",
        mysqli_real_escape_string($this->link, $ticket_id),
        mysqli_real_escape_string($this->link, $customer_email),
        mysqli_real_escape_string($this->link, $this->booking_agent_id),
        mysqli_real_escape_string($this->link, $curr_datetime->format('Y-m-d H:i:s')));

      $result = mysqli_query($this->link, $query);
      if (mysqli_affected_rows($this->link) == 0 || !$result) {
        error_log('"' . $query. '"' . " failed to insert into purchases with ticket_id: ".$ticket_id." - ".$this->email);
        $this->increaseAvailableTickets($flight_num, $airline_name);
        $this->deleteTicketIfInvalid($ticket_id);
        return false;
      }
      return true;
    }

    function getCommissionResults() {
      $query = sprintf("SELECT sum(price) as total_price, count(*) AS 'total_num_tickets' FROM purchases NATURAL JOIN ticket NATURAL JOIN flight WHERE booking_agent_id = '%s' AND purchase_date > NOW() - INTERVAL 30 DAY",
        mysqli_real_escape_string($this->link, $this->booking_agent_id));
      $result = mysqli_query($this->link, $query);
      if (!$result || mysqli_num_rows($result) === 0) {
        error_log('"' . $query. '"' . " returned 0 rows/failed");
        echo 'Internal Error: 500 Server failure';
        return false;
      }
      $row = mysqli_fetch_assoc($result);
      $commission_stats = array();

      if($row['total_price'] === NULL) {
        $commission_stats['earnings'] = 0;
        $commission_stats['total_tickets'] = 0;
        $commission_stats['avg_earning_per_ticket'] = 0;
        return $commission_stats;
      }

      $earnings = (float)$row['total_price'] * 0.1;
      $commission_stats['earnings'] = round($earnings, 2);
      $commission_stats['total_tickets'] = $row['total_num_tickets'];
      $commission_stats['avg_earning_per_ticket'] = round($earnings / (float)$row['total_num_tickets'], 2);

      return $commission_stats;
    }

    function recalculateCommissionStats($fromdate, $todate) {
      $fromdate_obj = date('Y-m-d',strtotime($fromdate));
      $todate_obj = date('Y-m-d',strtotime($todate));
      $query = sprintf('SELECT sum(price) as total_price, count(*) AS total_num_tickets FROM purchases NATURAL JOIN ticket NATURAL JOIN flight WHERE booking_agent_id = "%s" AND CAST("'.$fromdate_obj.'" AS DATE) < CAST(purchase_date AS DATE) AND CAST(purchase_date AS DATE) < CAST("'.$todate_obj.'" AS DATE)',
        mysqli_real_escape_string($this->link, $this->booking_agent_id));
      $result = mysqli_query($this->link, $query);
      if (!$result || mysqli_num_rows($result) === 0) {
        error_log('"' . $query. '"' . " returned 0 rows/failed");
        echo 'Internal Error: 500 Server failure';
        return false;
      }
      $row = mysqli_fetch_assoc($result);
      error_log($query);
      $commission_stats = array();

      if($row['total_price'] === NULL) {
        $commission_stats['earnings'] = 0;
        $commission_stats['total_tickets'] = 0;
        $commission_stats['avg_earning_per_ticket'] = 0;
        return $commission_stats;
      }
      $earnings = (float)$row['total_price'] * 0.1;
      $commission_stats['earnings'] = round($earnings, 2);
      $commission_stats['total_tickets'] = $row['total_num_tickets'];
      $commission_stats['avg_earning_per_ticket'] = round($earnings / (float)$row['total_num_tickets'], 2);
      return $commission_stats;
    }

    function __destruct() {
      // Close DB connection
      mysqli_close($this->link);
    }    
  }
?>