CREATE TABLE `airline` (
  `airline_name` varchar(50) NOT NULL,
  PRIMARY KEY(`airline_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
--
-- Table structure for table `airline_staff`
--

CREATE TABLE `airline_staff` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `airline_name` varchar(50) NOT NULL,
  PRIMARY KEY(`username`),
  FOREIGN KEY(`airline_name`) REFERENCES `airline`(`airline_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `airplane`
--

CREATE TABLE `airplane` (
  `airline_name` varchar(50) NOT NULL,
  `airplane_id` int(11) NOT NULL,
  `seats` int(11) NOT NULL,
  PRIMARY KEY(`airline_name`, `airplane_id`),
  FOREIGN KEY(`airline_name`) REFERENCES `airline`(`airline_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `airport`
--

CREATE TABLE `airport` (
  `airport_name` varchar(50) NOT NULL,
  `airport_city` varchar(50) NOT NULL,
  PRIMARY KEY(`airport_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `booking_agent`
--

CREATE TABLE `booking_agent` (
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `booking_agent_id` int(11) NOT NULL,
  PRIMARY KEY(`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `email` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `building_number` varchar(30) NOT NULL,
  `street` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `state` varchar(30) NOT NULL,
  `phone_number` int(11) NOT NULL,
  `passport_number` varchar(30) NOT NULL,
  `passport_expiration` date NOT NULL,
  `passport_country` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  PRIMARY KEY(`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `flight`
--

CREATE TABLE `flight` (
  `airline_name` varchar(50) NOT NULL,
  `flight_num` int(11) NOT NULL,
  `departure_airport` varchar(50) NOT NULL,
  `departure_time` datetime NOT NULL,
  `arrival_airport` varchar(50) NOT NULL,
  `arrival_time` datetime NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `status` varchar(50) NOT NULL,
  `airplane_id` int(11) NOT NULL,
  PRIMARY KEY(`airline_name`, `flight_num`),
  FOREIGN KEY(`airline_name`, `airplane_id`) REFERENCES `airplane`(`airline_name`, `airplane_id`),
  FOREIGN KEY(`departure_airport`) REFERENCES `airport`(`airport_name`),
  FOREIGN KEY(`arrival_airport`) REFERENCES `airport`(`airport_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `ticket_id` int(11) NOT NULL,
  `airline_name` varchar(50) NOT NULL,
  `flight_num` int(11) NOT NULL,
  PRIMARY KEY(`ticket_id`),
  FOREIGN KEY(`airline_name`, `flight_num`) REFERENCES `flight`(`airline_name`, `flight_num`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `ticket_id` int(11) NOT NULL,
  `customer_email` varchar(50) NOT NULL,
  `booking_agent_id` int(11),
  `purchase_date` date NOT NULL,
  PRIMARY KEY(`ticket_id`, `customer_email`),
  FOREIGN KEY(`ticket_id`) REFERENCES `ticket`(`ticket_id`),
  FOREIGN KEY(`customer_email`) REFERENCES `customer`(`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Inserts

INSERT INTO airline 
VALUES ("Chimney");

INSERT INTO airline
VALUES ("Fruit");

INSERT INTO airline
VALUES ("Sky");

INSERT INTO airline
VALUES ("Flame");

INSERT INTO airline
VALUES ("Tandon");

INSERT INTO airline_staff
VALUES ("airstaff1", "aqswdefr0", "Donna", "Smith", STR_TO_DATE("04/20/1993", "%m/%d/%y"), "Chimney");

INSERT INTO airline_staff
VALUES ("airstaff2", "aqswdefr1", "Sam", "Jackson", STR_TO_DATE("12/25/1992", "%m/%d/%y"), "Flame");

INSERT INTO airline_staff
VALUES ("airstaff3", "aqswdefr2", "Michael", "Jones", STR_TO_DATE("08/06/1997", "%m/%d/%y"), "Sky");

INSERT INTO airline_staff
VALUES ("airstaff4", "aqswdefr3", "Kenneth", "Chen", STR_TO_DATE("12/16/1996", "%m/%d/%y"), "Fruit");

INSERT INTO airline_staff
VALUES ("airstaff5", "aqswdefr4", "Erich", "Chu", STR_TO_DATE("01/23/1996", "%m/%d/%y"), "Tandon");

INSERT INTO airplane
VALUES ("Flame", 540987, 200);

INSERT INTO airplane
VALUES ("Tandon", 092827, 424);

INSERT INTO airplane
VALUES ("Sky", 102847, 250);

INSERT INTO airplane
VALUES ("Chimney", 102948, 250);

INSERT INTO airplane
VALUES ("Fruit", 492823, 333);

INSERT INTO airport
VALUES ("JFK", "New York City");

INSERT INTO airport
VALUES ("LAX", "Los Angeles");

INSERT INTO airport
VALUES ("CHI", "Chicago");

INSERT INTO airport
VALUES ("BRZ", "Sacramento");

INSERT INTO airport
VALUES ("DIA", "Dallas");

INSERT INTO booking_agent
VALUES ("jman45@gmail.com", "frdeswaq0", 1029);

INSERT INTO booking_agent
VALUES ("atown30@gmail.com", "frdeswaq1", 4320);

INSERT INTO booking_agent
VALUES ("bmod82@gmail.com", "frdeswaq2", 9484);

INSERT INTO booking_agent
VALUES ("rdms84@gmail.com", "frdeswaq3", 1239);

INSERT INTO booking_agent
VALUES ("must74@gmail.com", "frdeswaq4", 3048);

-- to do : customer and after

