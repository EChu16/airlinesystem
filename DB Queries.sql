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
VALUES ("airstaff1", "aqswdefr0", "Donna", "Smith", STR_TO_DATE("04/20/1993", "%m/%d/%Y"), "Chimney");

INSERT INTO airline_staff
VALUES ("airstaff2", "aqswdefr1", "Sam", "Jackson", STR_TO_DATE("12/25/1992", "%m/%d/%Y"), "Flame");

INSERT INTO airline_staff
VALUES ("airstaff3", "aqswdefr2", "Michael", "Jones", STR_TO_DATE("08/06/1997", "%m/%d/%Y"), "Sky");

INSERT INTO airline_staff
VALUES ("airstaff4", "aqswdefr3", "Kenneth", "Chen", STR_TO_DATE("12/16/1996", "%m/%d/%Y"), "Fruit");

INSERT INTO airline_staff
VALUES ("airstaff5", "aqswdefr4", "Erich", "Chu", STR_TO_DATE("01/23/1996", "%m/%d/%Y"), "Tandon");

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
INSERT INTO customer
VALUES ("customer1@gmail.com", "Kobe Bryant", "nba24", "54", "Ball Street", "Los Angeles", "California", 2129280394, "KB203", STR_TO_DATE("12/16/2020", "%m/%d/%Y"), "USA", STR_TO_DATE("12/16/1970", "%m/%d/%Y"));

INSERT INTO customer
VALUES ("customer2@gmail.com", "Michael Jordan", "nba23", "45", "Jordan Street", "Chicago", "Illinois", 6469342820, "MJ233", STR_TO_DATE("01/02/2021", "%m/%d/%Y"), "USA", STR_TO_DATE("01/02/1971", "%m/%d/%Y"));

INSERT INTO customer
VALUES ("customer3@gmail.com", "Dwight Howard", "nba12", "123", "Clown Street", "Orlando", "Florida", 2140290393, "DH003", STR_TO_DATE("12/12/2015", "%m/%d/%Y"), "China", STR_TO_DATE("12/12/1965", "%m/%d/%Y"));

INSERT INTO customer
VALUES ("customer4@gmail.com", "Ray Allen", "nba20", "2", "Sharp Street", "Boston", "Massachusetts", 1029382932, "RA283", STR_TO_DATE("05/05/2018", "%m/%d/%Y"), "Brazil", STR_TO_DATE("05/05/1968", "%m/%d/%Y"));

INSERT INTO customer
VALUES ("customer5@gmail.com", "Sharkeisha", "sharkYY", "666", "Shark Street", "Water", "River", 1293837764, "S2203", STR_TO_DATE("06/23/2019", "%m/%d/%Y"), "USA", STR_TO_DATE("06/23/1969", "%m/%d/%Y"));

INSERT INTO flight
VALUES ("Chimney", 4504, "JFK", NOW(), "BRZ", '12-01-2017 00:00:00', 300, "Updated", 102948);

INSERT INTO flight
VALUES ("Tandon", 4203, "JFK", NOW(), "LAX", '09-14-2017 08:05:00', 450, "Delayed", 092827);

INSERT INTO flight
VALUES ("Fruit", 4182, "LAX", NOW(), "CHI", '06-04-2017 10:10:00', 350,"Updated", 492823);

INSERT INTO flight
VALUES ("Sky", 4392, "DIA", NOW(), "CHI", '08-23-2017 21:08:00', 327, "In-Progress", 102847);

INSERT INTO flight
VALUES ("Flame", 4382, "BRZ", NOW(), "DIA", '11-30-2017 16:07:00', 810, "In-Progress", 540987);

INSERT INTO ticket
VALUES (193492884, "Chimney", 4504);

INSERT INTO ticket
VALUES (129384739, "Tandon", 4203);

INSERT INTO ticket
VALUES (128328437, "Sky", 4392);

INSERT INTO ticket
VALUES (147543885, "Flame", 4382);

INSERT INTO ticket
VALUES (198342774, "Fruit", 4182);

INSERT INTO purchases
VALUES (193492884, "customer1@gmail.com", "must74@gmail.com", STR_TO_DATE("04/26/2017", "%m/%d/%Y"));

INSERT INTO purchases
VALUES (129384739, "customer2@gmail.com", "rdms84@gmail.com", STR_TO_DATE("05/22/2017", "%m/%d/%Y"));

INSERT INTO purchases
VALUES (128328437, "customer3@gmail.com", "atown30@gmail.com", STR_TO_DATE("06/05/2016", "%m/%d/%Y"));

INSERT INTO purchases
VALUES (147543885, "customer4@gmail.com", "bmod82@gmail.com", STR_TO_DATE("11/10/2018", "%m/%d/%Y"));

INSERT INTO purchases
VALUES (198342774, "customer5@gmail.com", "jman45@gmail.com", STR_TO_DATE("04/30/2017", "%m/%d/%Y"));




