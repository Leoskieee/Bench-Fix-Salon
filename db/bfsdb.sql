-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 15, 2024 at 04:33 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bfsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `ID` int(10) NOT NULL,
  `AdminName` char(50) DEFAULT NULL,
  `UserName` char(50) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Password` varchar(200) DEFAULT NULL,
  `AdminRegdate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`ID`, `AdminName`, `UserName`, `MobileNumber`, `Email`, `Password`, `AdminRegdate`) VALUES
(1, 'Admin', 'admin', 7898799798, 'tester1@gmail.com', '202cb962ac59075b964b07152d234b70', '2024-05-25 06:21:50');

-- --------------------------------------------------------

--
-- Table structure for table `tblbook`
--

CREATE TABLE `tblbook` (
  `ID` int(10) NOT NULL,
  `UserID` int(10) DEFAULT NULL,
  `AptNumber` int(10) DEFAULT NULL,
  `AptDate` date DEFAULT NULL,
  `AptTime` time DEFAULT NULL,
  `Service` varchar(50) NOT NULL,
  `Message` mediumtext DEFAULT NULL,
  `BookingDate` timestamp NULL DEFAULT current_timestamp(),
  `Remark` varchar(250) DEFAULT NULL,
  `Status` varchar(250) DEFAULT NULL,
  `RemarkDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblbook`
--

INSERT INTO `tblbook` (`ID`, `UserID`, `AptNumber`, `AptDate`, `AptTime`, `Service`, `Message`, `BookingDate`, `Remark`, `Status`, `RemarkDate`) VALUES
(2, 7, 767068476, '2024-05-14', '09:00:00', '', 'fghfshdgfahgrfgh', '2024-05-12 18:30:00', 'Sorry your appointment has been cancelled', 'Rejected', '2024-05-13 06:14:39'),
(4, 10, 931783426, '2024-05-18', '15:40:00', '', 'NA', '2024-05-15 05:04:13', NULL, NULL, NULL),
(5, 10, 284544154, '2024-05-18', '15:40:00', '', 'NA', '2024-05-15 05:04:13', NULL, NULL, NULL),
(6, 10, 494039785, '2024-05-31', '14:47:00', '', 'NA', '2024-05-15 05:13:24', NULL, NULL, NULL),
(8, 10, 891247645, '2024-05-28', '20:14:00', '', 'nA', '2024-05-28 08:43:55', 'Your booking is confirmed.', 'Selected', '2024-05-28 08:51:22'),
(9, 11, 985654240, '2024-05-29', '13:10:00', '', 'NA', '2024-05-29 07:34:47', 'Your appointment is confirmed', 'Selected', '2024-05-29 07:35:36'),
(10, 13, 877052607, '2024-05-18', '15:05:00', '', 'Hello?', '2024-05-17 06:05:46', 'Okay see you !!!\r\n\r\nThank you for trust in salon.', 'Selected', '2024-05-17 06:08:06'),
(11, 14, 876388443, '2024-05-22', '18:00:00', '', 'Check!', '2024-05-21 10:54:56', '...', 'Selected', '2024-05-21 10:57:59'),
(12, 16, 923291897, '2024-10-10', '03:20:00', '', 'wdawd', '2024-10-03 07:20:48', NULL, NULL, NULL),
(13, 13, 495981114, '2024-10-11', '16:13:00', '', 'wew', '2024-10-10 08:12:06', NULL, NULL, NULL),
(34, 18, 921108949, '2024-10-11', '14:32:00', 'Hair Treatment', 'asdfasdfasdf', '2024-10-11 04:32:24', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblcontact`
--

CREATE TABLE `tblcontact` (
  `ID` int(10) NOT NULL,
  `FirstName` varchar(200) DEFAULT NULL,
  `LastName` varchar(200) DEFAULT NULL,
  `Phone` bigint(10) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Message` mediumtext DEFAULT NULL,
  `EnquiryDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `IsRead` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcontact`
--

INSERT INTO `tblcontact` (`ID`, `FirstName`, `LastName`, `Phone`, `Email`, `Message`, `EnquiryDate`, `IsRead`) VALUES
(5, 'Kajal', 'Sharma', 9879878798, 'kajal@gmail.com', 'guhgjhg', '2024-05-10 08:43:18', 1),
(6, 'Anuj', 'Kumar', 1234567890, 'ak@gmail.com', 'Need booking for marriage', '2024-06-01 01:05:47', 1),
(7, 'asd', 'asdasd', 523734, 'das@gmail.com', 'this is a message', '2024-05-14 08:30:19', 1),
(8, 'Leonard', 'Rosales', 9081685149, 'leonardrosales360@gmail.com', 'How to appointment?', '2024-05-17 06:05:10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblinvoice`
--

CREATE TABLE `tblinvoice` (
  `id` int(11) NOT NULL,
  `Userid` int(11) DEFAULT NULL,
  `ServiceId` int(11) DEFAULT NULL,
  `BillingId` int(11) DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblinvoice`
--

INSERT INTO `tblinvoice` (`id`, `Userid`, `ServiceId`, `BillingId`, `PostingDate`) VALUES
(4, 7, 4, 138889283, '2024-05-13 11:42:21'),
(5, 7, 9, 138889283, '2024-05-13 11:42:21'),
(6, 7, 16, 138889283, '2024-05-13 11:42:21'),
(7, 8, 3, 555850701, '2024-05-13 11:42:51'),
(8, 8, 6, 555850701, '2024-05-13 11:42:51'),
(9, 8, 9, 555850701, '2024-05-13 11:42:51'),
(10, 8, 11, 555850701, '2024-05-13 11:42:51'),
(13, 10, 1, 330026346, '2024-05-28 08:51:42'),
(14, 10, 2, 330026346, '2024-05-28 08:51:42'),
(15, 11, 2, 379060040, '2024-05-29 07:36:17'),
(16, 11, 5, 379060040, '2024-05-29 07:36:18'),
(17, 11, 6, 379060040, '2024-05-29 07:36:18'),
(18, 11, 12, 379060040, '2024-05-29 07:36:18'),
(19, 11, 3, 460087279, '2024-06-01 01:03:58'),
(20, 13, 1, 873748277, '2024-05-17 06:11:08'),
(21, 13, 2, 873748277, '2024-05-17 06:11:08');

-- --------------------------------------------------------

--
-- Table structure for table `tblpage`
--

CREATE TABLE `tblpage` (
  `ID` int(10) NOT NULL,
  `PageType` varchar(200) DEFAULT NULL,
  `PageTitle` mediumtext DEFAULT NULL,
  `PageDescription` mediumtext DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `UpdationDate` date DEFAULT NULL,
  `Timing` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblpage`
--

INSERT INTO `tblpage` (`ID`, `PageType`, `PageTitle`, `PageDescription`, `Email`, `MobileNumber`, `UpdationDate`, `Timing`) VALUES
(1, 'aboutus', 'About Us', 'Welcome to Win Salon, your destination for affordable, premium hair and beauty services. We offer a wide range of treatments, from Hair Botox, Rebonding, and Haircuts to indulgent options like Hair Spa, Foot Spa, and Manicures. Our expert stylists provide professional care, whether you\'re looking for vibrant Hair Color, sleek Blow-Dry styles, or nourishing Scalp Treatments. We also carry quality hair products like Hair Wax, Heat Protectants, and more to keep your hair healthy and styled. Visit us to feel rejuvenated, confident, and beautiful.', NULL, NULL, NULL, ''),
(2, 'contactus', 'Contact Us', 'Blk 3 Lot 1 Franco Sr, P1-A New Lower Bicutan Taguig City', 'edwinpmagdangan@yahoo.com', 9503643741, NULL, '10:30 am to 7:30 pm');

-- --------------------------------------------------------

--
-- Table structure for table `tblproducts`
--

CREATE TABLE `tblproducts` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_desc` varchar(1000) NOT NULL,
  `product_price` bigint(11) NOT NULL,
  `product_image` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblproducts`
--

INSERT INTO `tblproducts` (`id`, `product_name`, `product_desc`, `product_price`, `product_image`) VALUES
(1, 'Hair Wax', 'Hair wax is a styling product used to create and hold a wide range of hairstyles.', 50, NULL),
(2, 'Rebond Comb', 'A rebond comb is a wide-toothed comb often used during hair rebonding treatments.', 50, NULL),
(3, 'Styling Gel', 'Hair gel is a clear or colored product that provides a strong hold and shiny finish for hair. It’s often used for slick, sleek styles or spiked looks.', 35, NULL),
(4, 'Hair Color', 'Hair color is used to dye hair, either permanently or semi-permanently, in a variety of shades.', 80, NULL),
(5, 'Conditioner', 'Hydrates and smooths hair after shampooing. Available in various formulas for different hair needs.', 30, NULL),
(6, 'Hairspray', 'Spray used to set and hold hairstyles in place for longer durations.', 35, NULL),
(7, 'Dry Shampoo', 'Powder or spray used to clean hair without water by absorbing excess oil.', 30, NULL),
(8, 'Heat Protectant', 'Spray or serum applied before heat styling to protect hair from damage.', 35, NULL),
(9, 'Hair Mask', 'Intensive conditioning treatment applied to repair and nourish hair.', 80, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblservices`
--

CREATE TABLE `tblservices` (
  `ID` int(10) NOT NULL,
  `ServiceName` varchar(200) DEFAULT NULL,
  `ServiceDescription` mediumtext DEFAULT NULL,
  `Cost` int(10) DEFAULT NULL,
  `Image` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblservices`
--

INSERT INTO `tblservices` (`ID`, `ServiceName`, `ServiceDescription`, `Cost`, `Image`) VALUES
(1, 'Hair Botox', 'A deep conditioning treatment that helps repair damaged hair, making it smoother, shinier, and healthier. It reduces frizz and adds softness to your hair.', 1500, NULL),
(2, 'Haircut', 'A professional trim or style for your hair, tailored to your preference.', 80, NULL),
(3, 'Cellophane', 'A hair treatment that adds shine and enhances the color of your hair, leaving it looking vibrant and glossy.', 300, NULL),
(4, 'Hair Spa', 'A nourishing treatment that deeply moisturizes your hair and scalp, promoting healthier and shinier hair.', 300, NULL),
(5, 'Rebond', 'A chemical treatment that straightens curly or wavy hair, leaving it smooth and sleek.', 1000, NULL),
(6, 'Foot Spa', 'A relaxing treatment for your feet that includes soaking, exfoliation, and moisturizing to soften and refresh your skin.', 300, NULL),
(7, 'Manicure', 'A beauty treatment for your hands and nails that includes nail shaping, cuticle care, and optional polish application.', 70, NULL),
(8, 'Blow-Dry', 'Shampoo, blow-dry, and styling. Often leaves hair smooth and voluminous.', 120, NULL),
(9, 'Hair Extensions', 'Adding length or volume with synthetic or natural hair extensions. Can be applied through different methods (clip-in, tape-in, sew-in).', 600, NULL),
(10, 'Scalp Treatment', 'Treatments to improve scalp health, reduce dandruff, or stimulate hair growth. Often involves massaging and specialized products.', 150, NULL),
(11, 'Straightening', 'Temporary or permanent straightening using a flat iron or chemical treatments like Japanese straightening or relaxers.', 300, NULL),
(12, 'Perm', 'Chemical treatment to create curls or waves that last for months.', 250, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `ID` int(10) NOT NULL,
  `FirstName` varchar(120) DEFAULT NULL,
  `LastName` varchar(250) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Email` varchar(120) DEFAULT NULL,
  `Password` varchar(120) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`ID`, `FirstName`, `LastName`, `MobileNumber`, `Email`, `Password`, `RegDate`) VALUES
(2, 'Rishi Singh', NULL, 5689234578, 'rishi@gmail.com', '202cb962ac59075b964b07152d234b70', '2021-10-16 14:37:49'),
(3, 'Abir Singh', NULL, 2147483649, 'abir@gmail.com', '202cb962ac59075b964b07152d234b70', '2021-10-16 14:40:20'),
(4, 'Test Sample', NULL, 8797977779, 'sample@gmail.com', '202cb962ac59075b964b07152d234b70', '2020-04-08 05:51:06'),
(5, 'Anuj  kumar', NULL, 1236547890, 'test@test.com', 'f925916e2754e5e03f75dd58a5733251', '2020-05-07 08:52:34'),
(6, 'ghhg', NULL, 8888888888, 'c@gmail.com', '202cb962ac59075b964b07152d234b70', '2021-12-14 05:27:32'),
(7, 'Tina', 'Khan', 9789797987, 'tina@gmail.com', '202cb962ac59075b964b07152d234b70', '2024-05-11 09:21:46'),
(8, 'Hima', 'Sharma', 8979798789, 'hima@gmail.com', '202cb962ac59075b964b07152d234b70', '2024-05-11 09:23:16'),
(10, 'Anuj', 'Kumar', 1425362514, 'ak@gmail.com', 'f925916e2754e5e03f75dd58a5733251', '2024-05-15 05:03:32'),
(11, 'John', 'Doe', 1452632541, 'johndoe@gmail.com', 'f925916e2754e5e03f75dd58a5733251', '2024-05-29 07:33:58'),
(12, 'juan', 'pablo', 964534231, 'jp@gmail.com', '32250170a0dca92d53ec9624f336ca24', '2024-05-14 07:34:12'),
(13, 'Leo', 'Nard', 9081685149, 'leonardrosales360@gmail.com', '9697ad4e728e0cb2758df02341aff2c6', '2024-05-14 10:15:28'),
(14, 'jeff', 'masagca', 9949237820, 'jepoymasagca21@gmail.com', '908df52be49d76717b84e45d4a5d7fe7', '2024-05-21 10:49:54'),
(15, 'jericho', 'delamente', 9161694900, 'j.delamente12360@gmail.com', '9684149e2c74583d7a1343000c1504ce', '2024-06-01 05:52:42'),
(16, 'Lhine', 'Amando', 9456475951, 'lhineamando45@gmail.com', '0373930ec3a52b66e0d06c8981ba5770', '2024-09-26 06:06:26'),
(17, 'Lance Vincent', 'Buhat', 9168825525, 'lancebuhat01@gmail.com', 'bd7012bd534bf4dd2a300530d3cf92bd', '2024-09-26 06:20:45'),
(18, 'Juan', 'Dela Cruz', 926536973, 'fahatmahmabang9@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '2024-10-10 16:33:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblbook`
--
ALTER TABLE `tblbook`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblcontact`
--
ALTER TABLE `tblcontact`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblinvoice`
--
ALTER TABLE `tblinvoice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `tblpage`
--
ALTER TABLE `tblpage`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblproducts`
--
ALTER TABLE `tblproducts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblservices`
--
ALTER TABLE `tblservices`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID` (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblbook`
--
ALTER TABLE `tblbook`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tblcontact`
--
ALTER TABLE `tblcontact`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblinvoice`
--
ALTER TABLE `tblinvoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tblpage`
--
ALTER TABLE `tblpage`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblproducts`
--
ALTER TABLE `tblproducts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tblservices`
--
ALTER TABLE `tblservices`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
