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
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `booking_agent_id` int(11) NOT NULL,
  PRIMARY KEY(`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `email` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
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
  `num_tickets` int(5) NOT NULL,
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

INSERT INTO airline 
VALUES ("Penguin");

INSERT INTO airline
VALUES ("Tiger");

INSERT INTO airline
VALUES ("Viper");

INSERT INTO airline
VALUES ("Jaguar");

INSERT INTO airline
VALUES ("Rhino");

INSERT INTO airline 
VALUES ("Pisces");

INSERT INTO airline
VALUES ("Gemini");

INSERT INTO airline
VALUES ("Teddy");

INSERT INTO airline
VALUES ("Beaver");

INSERT INTO airline
VALUES ("Oxford");

INSERT INTO airline 
VALUES ("Beach");

INSERT INTO airline
VALUES ("Sunshine");

INSERT INTO airline
VALUES ("Waters");

INSERT INTO airline
VALUES ("Slam");

INSERT INTO airline
VALUES ("Westwood");

INSERT INTO airplane
VALUES ("Flame", 540987, 200);

INSERT INTO airplane
VALUES ("Tandon", 092827, 400);

INSERT INTO airplane
VALUES ("Sky", 102847, 252);

INSERT INTO airplane
VALUES ("Chimney", 102948, 304);

INSERT INTO airplane
VALUES ("Fruit", 492823, 301);

INSERT INTO airplane
VALUES ("Beach", 837432, 202);

INSERT INTO airplane
VALUES ("Beaver", 004834, 420);

INSERT INTO airplane
VALUES ("Gemini", 104932, 98);

INSERT INTO airplane
VALUES ("Jaguar", 142738, 100);

INSERT INTO airplane
VALUES ("Oxford", 120384, 333);

INSERT INTO airplane
VALUES ("Penguin", 943837, 202);

INSERT INTO airplane
VALUES ("Pisces", 102374, 427);

INSERT INTO airplane
VALUES ("Rhino", 304832, 200);

INSERT INTO airplane
VALUES ("Sky", 495473, 255);

INSERT INTO airplane
VALUES ("Slam", 555032, 302);

INSERT INTO airplane
VALUES ("Sunshine", 938432, 212);

INSERT INTO airplane
VALUES ("Tandon", 012832, 373);

INSERT INTO airplane
VALUES ("Teddy", 194833, 252);

INSERT INTO airplane
VALUES ("Tiger", 344822, 512);

INSERT INTO airplane
VALUES ("Viper", 449273, 137);

INSERT INTO airplane
VALUES ("Waters", 028343, 317);

INSERT INTO airplane
VALUES ("Westwood", 847327, 429);

INSERT INTO airplane
VALUES ("Westwood", 843829, 294);

INSERT INTO airplane
VALUES ("Waters", 923838, 263);

INSERT INTO airplane
VALUES ("Fruit", 093828, 313);

INSERT INTO airplane
VALUES ("Flame", 439483, 202);

INSERT INTO airplane
VALUES ("Tandon", 728493, 385);

INSERT INTO airplane
VALUES ("Sky", 938400, 105);

INSERT INTO airplane
VALUES ("Penguin", 823738, 115);

INSERT INTO airplane
VALUES ("Rhino", 238439, 130);

INSERT INTO airplane
VALUES ("Chimney", 767776, 230);

INSERT INTO airplane
VALUES ("Beach", 666844, 430);

INSERT INTO airplane
VALUES ("Sunshine", 632183, 350);

INSERT INTO airplane
VALUES ("Viper", 575758, 340);

INSERT INTO airplane
VALUES ("Jaguar", 566639, 50);

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

INSERT INTO airport
VALUES ("NAJ", "Jersey City");

INSERT INTO airport
VALUES ("OQJ", "San Francisco");

INSERT INTO airport
VALUES ("JFD", "San Diego");

INSERT INTO airport
VALUES ("LDS", "San Jose");

INSERT INTO airport
VALUES ("OWQ", "Oklahoma");

INSERT INTO airport
VALUES ("OOO", "Irvine");

INSERT INTO airport
VALUES ("LAC", "Westminster");

INSERT INTO airport
VALUES ("DET", "Detroit");

INSERT INTO airport
VALUES ("FRS", "Albany");

INSERT INTO airport
VALUES ("CAM", "Houston");

INSERT INTO airport
VALUES ("MAC", "Honolulu");

INSERT INTO airport
VALUES ("KLS", "Boston");

INSERT INTO airport
VALUES ("CIH", "Milwaukee");

INSERT INTO airport
VALUES ("BAR", "Portland");

INSERT INTO airport
VALUES ("ZAN", "Cleveland");

INSERT INTO airport
VALUES ("MLY", "Philadelphia");

INSERT INTO airport
VALUES ("OLY", "Buffalo");

INSERT INTO airport
VALUES ("BBB", "Long Island");

INSERT INTO airport
VALUES ("EOR", "Edison");

INSERT INTO airport
VALUES ("EUR", "Newark");

INSERT INTO airport
VALUES ("APW", "Metropolis");

INSERT INTO airport
VALUES ("PAE", "Seattle");

INSERT INTO airport
VALUES ("BOE", "Starling");

INSERT INTO airport
VALUES ("URB", "Central");

INSERT INTO airport
VALUES ("SHD", "Shield");

INSERT INTO flight
VALUES ("Beach", 4504, "JFK", "2017-04-30 12:00:00", "BRZ", "2017-05-01 01:30:00", 300, "IN-PROGRESS", 666844, 400);

INSERT INTO flight
VALUES ("Beach", 4203, "JFK", "2017-05-02 08:30:20", "LAX", "2017-05-08 09:20:00", 450, "UPCOMING", 837432, 172);

INSERT INTO flight
VALUES ("Beaver", 4182, "LAX", "2017-05-01 05:15:00", "CHI", "2017-05-06 10:15:00", 350,"UPCOMING", 004834, 390);

INSERT INTO flight
VALUES ("Chimney", 4392, "DIA", "2017-05-04 15:15:15", "CHI", "2017-05-10 03:30:00", 300, "UPCOMING", 102948, 220);

INSERT INTO flight
VALUES ("Chimney", 4382, "BRZ", "2017-05-05 03:30:00", "DIA", '2017-05-10 17:10:00', 810, "UPCOMING", 767776, 200);

-- next 45 inserts
INSERT INTO flight
VALUES ("Flame", 1203, "APW", "2017-04-30 12:00:00", "MAC", "2017-05-01 12:30:00", 350, "DELAYED", 439483, 172);

INSERT INTO flight
VALUES ("Flame", 1382, "MAC", "2017-04-30 08:30:20", "OLY", "2017-05-15 01:55:00", 420, "IN-PROGRESS", 540987, 170);

INSERT INTO flight
VALUES ("Fruit", 1293, "OOO", "2017-05-01 05:15:00", "OWQ", "2017-05-09 06:50:00", 820,"UPCOMING", 093828, 283);

INSERT INTO flight
VALUES ("Fruit", 4849, "FRS", "2017-05-02 15:15:15", "LAX", "2017-05-10 04:40:00", 1000, "IN-PROGRESS", 492823, 303);

INSERT INTO flight
VALUES ("Gemini", 9383, "ZAN", "2017-05-02 03:30:00", "URB", '2017-05-06 08:17:00', 120, "IN-PROGRESS", 104932, 68);

INSERT INTO flight
VALUES ("Jaguar", 4938, "LDS", "2017-05-04 12:00:00", "MLY", "2019-05-10 11:45:00", 310, "UPCOMING", 142738, 70);

INSERT INTO flight
VALUES ("Jaguar", 3743, "CAM", "2017-05-06 08:30:20", "BOE", "2017-05-13 02:20:00", 475, "DELAYED", 566639, 40);

INSERT INTO flight
VALUES ("Oxford", 3092, "BBB", "2017-05-02 05:15:00", "BAR", "2017-05-07 13:13:00", 355,"UPCOMING", 120384, 303);

INSERT INTO flight
VALUES ("Penguin", 2393, "NAJ", "2017-05-01 15:15:15", "KLS", "2017-05-03 01:32:00", 325, "IN-PROGRESS", 823738, 95);

INSERT INTO flight
VALUES ("Penguin", 5493, "EOR", "2017-05-03 03:30:00", "DET", '2017-05-10 16:13:00', 815, "IN-PROGRESS", 943837, 172);

INSERT INTO flight
VALUES ("Pisces", 7483, "SHD", "2017-05-02 12:00:00", "PAE", "2017-05-05 21:22:00", 200, "UPCOMING", 102374, 407);

INSERT INTO flight
VALUES ("Rhino", 1948, "OWQ", "2017-05-01 08:30:20", "ZAN", "2017-05-03 22:35:00", 400, "DELAYED", 238439, 110);

INSERT INTO flight
VALUES ("Rhino", 4943, "BRZ", "2017-05-03 05:15:00", "JFD", "2017-05-05 14:16:00", 380,"UPCOMING", 304832, 170);

INSERT INTO flight
VALUES ("Sky", 2838, "OLY", "2017-05-04 15:15:15", "MLY", "2017-05-10 18:36:00", 370, "IN-PROGRESS", 102847, 230);

INSERT INTO flight
VALUES ("Sky", 2222, "PAE", "2017-05-03 03:30:00", "ZAN", '2017-05-06 16:23:00', 410, "IN-PROGRESS", 495473, 230);

INSERT INTO flight
VALUES ("Sky", 3333, "ZAN", "2017-05-02 12:00:00", "PAE", "2017-05-03 23:50:00", 330, "UPCOMING", 938400, 95);

INSERT INTO flight
VALUES ("Slam", 4444, "EUR", "2017-04-30 08:30:20", "KLS", "2017-05-01 11:21:00", 440, "DELAYED", 555032, 275);

INSERT INTO flight
VALUES ("Sunshine", 5555, "LAX", "2017-04-30 05:15:00", "CIH", "2017-05-09 15:15:00", 600,"UPCOMING", 632183, 320);

INSERT INTO flight
VALUES ("Sunshine", 6666, "CIH", "2017-05-01 15:15:15", "MAC", "2017-05-03 19:43:00", 580, "IN-PROGRESS", 938432, 200);

INSERT INTO flight
VALUES ("Tandon", 7777, "MAC", "2017-05-02 03:30:00", "APW", '2017-05-06 16:00:00', 270, "IN-PROGRESS", 012832, 350);

INSERT INTO flight
VALUES ("Tandon", 8888, "ZAN", "2017-05-01 12:00:00", "APW", "2017-05-02 21:22:00", 330, "UPCOMING", 092827, 405);

INSERT INTO flight
VALUES ("Tandon", 9999, "KLS", "2017-05-02 08:30:20", "OOO", "2017-05-11 11:39:00", 460, "DELAYED", 728493, 370);

INSERT INTO flight
VALUES ("Teddy", 9898, "OWQ", "2017-05-04 05:15:00", "FRS", "2017-05-08 17:38:00", 315,"UPCOMING", 194833, 240);

INSERT INTO flight
VALUES ("Tiger", 9191, "JFD", "2017-05-03 15:15:15", "JFK", "2017-05-15 07:22:00", 230, "IN-PROGRESS", 344822, 485);

INSERT INTO flight
VALUES ("Viper", 8882, "DIA", "2017-04-30 03:30:00", "LAC", '2017-05-03 12:16:00', 265, "IN-PROGRESS", 449273, 130);

INSERT INTO flight
VALUES ("Rhino", 8192, "MLY", "2017-04-30 12:00:00", "LDS", "2017-05-05 12:15:00", 280, "UPCOMING", 238439, 100);

INSERT INTO flight
VALUES ("Sky", 2423, "URB", "2017-05-06 08:30:20", "DET", "2017-05-10 8:10:00", 480, "DELAYED", 938400, 80);

INSERT INTO flight
VALUES ("Tandon", 3433, "CIH", "2017-05-03 05:15:00", "LDS", "2017-05-08 04:20:00", 380,"UPCOMING", 012832, 340);

INSERT INTO flight
VALUES ("Fruit", 1211, "NAJ", "2017-05-04 15:15:15", "DET", "2017-05-11 15:32:00", 500, "IN-PROGRESS", 492823, 300);

INSERT INTO flight
VALUES ("Sky", 1234, "BBB", "2017-05-05 03:30:00", "BAR", '2017-05-06 10:25:00', 120, "IN-PROGRESS", 495473, 250);

INSERT INTO flight
VALUES ("Gemini", 2345, "BAR", "2017-05-06 12:00:00", "ZAN", "2017-05-11 12:20:00", 150, "UPCOMING", 104932, 90);

INSERT INTO flight
VALUES ("Fruit", 3456, "ZAN", "2017-05-01 08:30:20", "BAR", "2017-05-03 18:18:00", 190, "DELAYED", 492823, 300);

INSERT INTO flight
VALUES ("Flame", 4567, "FRS", "2017-05-03 05:15:00", "JFD", "2017-05-08 16:42:00", 300,"UPCOMING", 540987, 190);

INSERT INTO flight
VALUES ("Chimney", 5678, "DET", "2017-05-01 15:15:15", "MLY", "2017-05-04 17:13:00", 500, "IN-PROGRESS", 767776, 200);

INSERT INTO flight
VALUES ("Rhino", 6789, "OWQ", "2017-05-01 03:30:00", "OOO", '2017-05-06 13:56:00', 625, "IN-PROGRESS", 304832, 180);

INSERT INTO flight
VALUES ("Sunshine", 7890, "OOO", "2017-05-03 12:00:00", "BBB", "2017-05-15 15:51:00", 730, "UPCOMING", 632183, 340);

INSERT INTO flight
VALUES ("Tandon", 9876, "BBB", "2017-05-05 08:30:20", "OOO", "2017-05-08 18:27:00", 430, "DELAYED", 728493, 330);

INSERT INTO flight
VALUES ("Viper", 8765, "LAC", "2017-05-04 05:15:00", "OQJ", "2017-05-10 10:10:10", 305,"UPCOMING", 449273, 130);

INSERT INTO flight
VALUES ("Jaguar", 7654, "OQJ", "2017-05-06 15:15:15", "OWQ", "2017-05-07 07:17:00", 415, "IN-PROGRESS", 566639, 30);

INSERT INTO flight
VALUES ("Teddy", 6543, "EUR", "2017-05-06 03:30:00", "CAM", '2017-05-08 04:35:00', 700, "IN-PROGRESS", 194833, 240);

INSERT INTO flight
VALUES ("Rhino", 5432, "CAM", "2017-05-06 12:00:00", "BOE", "2017-05-12 15:12:00", 310, "UPCOMING", 238439, 115);

INSERT INTO flight
VALUES ("Gemini", 4321, "OLY", "2017-05-02 08:30:20", "BOE", "2017-05-05 18:14:00", 450, "DELAYED", 104932, 90);

INSERT INTO flight
VALUES ("Rhino", 3210, "SHD", "2017-04-30 05:15:00", "EOR", "2017-05-02 13:31:00", 600,"UPCOMING", 304832, 190);

INSERT INTO flight
VALUES ("Slam", 5888, "DIA", "2017-04-30 15:15:15", "KLS", "2017-05-03 17:33:00", 620, "IN-PROGRESS", 555032, 290);

INSERT INTO flight
VALUES ("Jaguar", 5858, "KLS", "2017-05-01 03:30:00", "LAX", '2017-05-06 21:30:00', 160, "IN-PROGRESS", 142738, 85);



