-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Apr 15, 2016 at 11:29 AM
-- Server version: 5.6.29
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `handyman_tools`
--

-- --------------------------------------------------------

--
-- Table structure for table `clerk`
--

CREATE TABLE `clerk` (
  `ClerkId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clerk`
--

INSERT INTO `clerk` (`ClerkId`) VALUES
(5),
(6),
(7),
(8);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CustomerId` int(11) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `HomePhone` varchar(10) DEFAULT NULL,
  `WorkPhone` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustomerId`, `Address`, `HomePhone`, `WorkPhone`) VALUES
(1, '123 Mickey Ln.', '123456789', NULL),
(2, '234 Minnie Ave.', NULL, '234567891'),
(3, '345 Donald St.', '345678912', NULL),
(4, '567 Test Dr.', '456789123', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dropoff`
--

CREATE TABLE `dropoff` (
  `ReservationId` int(11) NOT NULL,
  `ClerkId` int(11) NOT NULL,
  `Total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pickup`
--

CREATE TABLE `pickup` (
  `ReservationId` int(11) NOT NULL,
  `ClerkId` int(11) NOT NULL,
  `CreditCard` varchar(16) NOT NULL,
  `ExpirationDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `ReservationId` int(11) NOT NULL,
  `CustomerId` int(11) NOT NULL,
  `StartDate` datetime NOT NULL,
  `EndDate` datetime NOT NULL,
  `DepositHeld` decimal(10,2) NOT NULL,
  `RentalPrice` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`ReservationId`, `CustomerId`, `StartDate`, `EndDate`, `DepositHeld`, `RentalPrice`) VALUES
(1, 1, '2016-04-18 00:00:00', '2016-04-21 00:00:00', '100.00', '200.00'),
(2, 2, '2016-04-19 00:00:00', '2016-04-22 00:00:00', '150.00', '300.00'),
(3, 3, '2016-04-20 00:00:00', '2016-04-24 00:00:00', '150.00', '500.00'),
(4, 4, '2016-04-19 00:00:00', '2016-04-22 00:00:00', '200.00', '600.00');

-- --------------------------------------------------------

--
-- Stand-in structure for view `reservationoverview`
--
CREATE TABLE `reservationoverview` (
`ResId` int(11)
,`Cust` int(11)
,`Start` datetime
,`End` datetime
,`Price` decimal(10,2)
,`Deposit` decimal(10,2)
,`Pclerk` int(11)
,`Dclerk` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `reservedtool`
--

CREATE TABLE `reservedtool` (
  `ToolId` int(11) NOT NULL,
  `ReservationId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservedtool`
--

INSERT INTO `reservedtool` (`ToolId`, `ReservationId`) VALUES
(1, 1),
(2, 1),
(13, 1),
(3, 2),
(8, 2),
(12, 2),
(4, 3),
(5, 3),
(11, 3),
(6, 4),
(7, 4),
(9, 4),
(10, 4);

-- --------------------------------------------------------

--
-- Table structure for table `serviceorder`
--

CREATE TABLE `serviceorder` (
  `ServiceOrderId` int(11) NOT NULL,
  `ToolId` int(11) NOT NULL,
  `StartDate` datetime NOT NULL,
  `EndDate` datetime NOT NULL,
  `EstCost` decimal(10,2) NOT NULL,
  `ClerkId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tool`
--

CREATE TABLE `tool` (
  `ToolId` int(11) NOT NULL,
  `AbbrDesc` varchar(25) NOT NULL,
  `FullDesc` varchar(255) NOT NULL,
  `Rental` decimal(10,2) NOT NULL,
  `Deposit` decimal(10,2) NOT NULL,
  `Purchase` decimal(10,2) NOT NULL,
  `SellDate` datetime DEFAULT NULL,
  `Type` enum('Hand','Construction','Power') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tool`
--

INSERT INTO `tool` (`ToolId`, `AbbrDesc`, `FullDesc`, `Rental`, `Deposit`, `Purchase`, `SellDate`, `Type`) VALUES
(1, 'hammer', ' wooden hammer', '15.00', '8.00', '30.00', NULL, 'Hand'),
(2, 'screwdriver', ' flat head screwdriver', '8.00', '5.00', '15.00', NULL, 'Hand'),
(3, 'screwdriver', ' phillips screwdriver', '9.00', '6.00', '17.00', NULL, 'Hand'),
(4, 'wrench', ' wrench', '5.00', '3.00', '10.00', NULL, 'Hand'),
(5, 'jack hammer', ' jack hammer', '400.00', '250.00', '800.00', NULL, 'Construction'),
(6, 'crane', ' 15 ft crane', '600.00', '450.00', '1000.00', NULL, 'Construction'),
(7, 'backhoe', ' backhoe', '1000.00', '700.00', '2000.00', NULL, 'Construction'),
(8, 'drill', ' small power drill', '30.00', '20.00', '55.00', NULL, 'Power'),
(9, 'heavy duty drill', 'heavy duty drill for DIY projects around the home', '45.00', '30.00', '100.00', NULL, 'Power'),
(10, '4x drill', ' Commercial capacity drill', '100.00', '75.00', '200.00', NULL, 'Power'),
(11, '4x drill', ' Commercial capacity drill', '100.00', '75.00', '200.00', NULL, 'Power'),
(12, '4x drill', ' Commercial capacity drill', '100.00', '75.00', '200.00', NULL, 'Power'),
(13, '4x drill', ' Commercial capacity drill', '100.00', '75.00', '200.00', NULL, 'Power');

-- --------------------------------------------------------

--
-- Table structure for table `toolaccessory`
--

CREATE TABLE `toolaccessory` (
  `ToolId` int(11) NOT NULL,
  `Accessory` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `toolaccessory`
--

INSERT INTO `toolaccessory` (`ToolId`, `Accessory`) VALUES
(8, ' '),
(8, ' battery'),
(8, ' bolt bit'),
(8, ' charger'),
(8, ' flathead bit'),
(8, ' hex bit'),
(8, ' phillips bit'),
(9, '  charger'),
(9, ' and more '),
(9, ' and more bits'),
(9, ' battery'),
(9, ' bolt bit'),
(9, ' flathead bit'),
(9, ' hex bit'),
(9, ' more bits'),
(9, ' phillips bit'),
(10, ' and more bits'),
(10, ' battery'),
(10, ' bigger bits '),
(10, ' bolt bit'),
(10, ' flathead bit'),
(10, ' hex bit'),
(10, ' more big bits'),
(10, ' phillips bit'),
(10, 'charger'),
(10, 'saw'),
(11, ' and more bits'),
(11, ' battery'),
(11, ' bigger bits '),
(11, ' bolt bit'),
(11, ' flathead bit'),
(11, ' hex bit'),
(11, ' more big bits'),
(11, ' phillips bit'),
(11, 'charger'),
(11, 'saw'),
(12, ' and more bits'),
(12, ' battery'),
(12, ' bigger bits '),
(12, ' bolt bit'),
(12, ' flathead bit'),
(12, ' hex bit'),
(12, ' more big bits'),
(12, ' phillips bit'),
(12, 'charger'),
(12, 'saw'),
(13, ' and more bits'),
(13, ' battery'),
(13, ' bigger bits '),
(13, ' bolt bit'),
(13, ' flathead bit'),
(13, ' hex bit'),
(13, ' more big bits'),
(13, ' phillips bit'),
(13, 'charger'),
(13, 'saw');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserId` int(11) NOT NULL,
  `Login` varchar(255) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `FirstName` varchar(25) NOT NULL,
  `LastName` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserId`, `Login`, `Password`, `FirstName`, `LastName`) VALUES
(1, 'mickey@test.com', 'test', 'Mickey', 'Mouse'),
(2, 'minnie@test.com', 'test', 'Minnie', 'Mouse'),
(3, 'donald@test.com', 'test', 'Donald', 'Duck'),
(4, 'test@test.com', 'test', 'test', 'test'),
(5, 'clerk1', 'test', 'Clerk', 'One'),
(6, 'clerk2', 'test', 'Clerk', 'Two'),
(7, 'clerk3', 'test', 'Clerk', 'Three'),
(8, 'clerk4', 'test', 'Clerk', 'Four');

-- --------------------------------------------------------

--
-- Structure for view `reservationoverview`
--
DROP TABLE IF EXISTS `reservationoverview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `reservationoverview`  AS  select `r`.`ReservationId` AS `ResId`,`r`.`CustomerId` AS `Cust`,`r`.`StartDate` AS `Start`,`r`.`EndDate` AS `End`,`r`.`RentalPrice` AS `Price`,`r`.`DepositHeld` AS `Deposit`,`p`.`ClerkId` AS `Pclerk`,`d`.`ClerkId` AS `Dclerk` from ((`reservation` `r` left join `pickup` `p` on((`r`.`ReservationId` = `p`.`ReservationId`))) left join `dropoff` `d` on((`r`.`ReservationId` = `d`.`ReservationId`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clerk`
--
ALTER TABLE `clerk`
  ADD PRIMARY KEY (`ClerkId`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustomerId`);

--
-- Indexes for table `dropoff`
--
ALTER TABLE `dropoff`
  ADD PRIMARY KEY (`ReservationId`,`ClerkId`),
  ADD KEY `ClerkId` (`ClerkId`);

--
-- Indexes for table `pickup`
--
ALTER TABLE `pickup`
  ADD PRIMARY KEY (`ReservationId`,`ClerkId`),
  ADD KEY `ClerkId` (`ClerkId`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`ReservationId`),
  ADD KEY `CustomerId` (`CustomerId`);

--
-- Indexes for table `reservedtool`
--
ALTER TABLE `reservedtool`
  ADD PRIMARY KEY (`ToolId`,`ReservationId`),
  ADD KEY `ReservationId` (`ReservationId`);

--
-- Indexes for table `serviceorder`
--
ALTER TABLE `serviceorder`
  ADD PRIMARY KEY (`ServiceOrderId`,`ToolId`),
  ADD KEY `ToolId` (`ToolId`),
  ADD KEY `ClerkId` (`ClerkId`);

--
-- Indexes for table `tool`
--
ALTER TABLE `tool`
  ADD PRIMARY KEY (`ToolId`);

--
-- Indexes for table `toolaccessory`
--
ALTER TABLE `toolaccessory`
  ADD PRIMARY KEY (`ToolId`,`Accessory`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserId`),
  ADD UNIQUE KEY `Login` (`Login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `ReservationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `serviceorder`
--
ALTER TABLE `serviceorder`
  MODIFY `ServiceOrderId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tool`
--
ALTER TABLE `tool`
  MODIFY `ToolId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `clerk`
--
ALTER TABLE `clerk`
  ADD CONSTRAINT `clerk_ibfk_1` FOREIGN KEY (`ClerkId`) REFERENCES `users` (`UserId`);

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`CustomerId`) REFERENCES `users` (`UserId`);

--
-- Constraints for table `dropoff`
--
ALTER TABLE `dropoff`
  ADD CONSTRAINT `dropoff_ibfk_1` FOREIGN KEY (`ReservationId`) REFERENCES `reservation` (`ReservationId`),
  ADD CONSTRAINT `dropoff_ibfk_2` FOREIGN KEY (`ClerkId`) REFERENCES `clerk` (`ClerkId`);

--
-- Constraints for table `pickup`
--
ALTER TABLE `pickup`
  ADD CONSTRAINT `pickup_ibfk_1` FOREIGN KEY (`ReservationId`) REFERENCES `reservation` (`ReservationId`),
  ADD CONSTRAINT `pickup_ibfk_2` FOREIGN KEY (`ClerkId`) REFERENCES `clerk` (`ClerkId`);

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`CustomerId`) REFERENCES `customer` (`CustomerId`);

--
-- Constraints for table `reservedtool`
--
ALTER TABLE `reservedtool`
  ADD CONSTRAINT `reservedtool_ibfk_1` FOREIGN KEY (`ToolId`) REFERENCES `tool` (`ToolId`),
  ADD CONSTRAINT `reservedtool_ibfk_2` FOREIGN KEY (`ReservationId`) REFERENCES `reservation` (`ReservationId`);

--
-- Constraints for table `serviceorder`
--
ALTER TABLE `serviceorder`
  ADD CONSTRAINT `serviceorder_ibfk_1` FOREIGN KEY (`ToolId`) REFERENCES `tool` (`ToolId`),
  ADD CONSTRAINT `serviceorder_ibfk_2` FOREIGN KEY (`ClerkId`) REFERENCES `clerk` (`ClerkId`);

--
-- Constraints for table `toolaccessory`
--
ALTER TABLE `toolaccessory`
  ADD CONSTRAINT `toolaccessory_ibfk_1` FOREIGN KEY (`ToolId`) REFERENCES `tool` (`ToolId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
