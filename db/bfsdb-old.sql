-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 16, 2024 at 03:18 PM
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
(1, 'Admin', 'admin', 7898799798, 'tester1@gmail.com', '202cb962ac59075b964b07152d234b70', '2022-05-25 06:21:50');

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
  `Service` varchar(255) NOT NULL,
  `Message` mediumtext DEFAULT NULL,
  `BookingDate` timestamp NULL DEFAULT current_timestamp(),
  `Remark` varchar(250) DEFAULT NULL,
  `Status` varchar(250) DEFAULT NULL,
  `RemarkDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `Service_Total_Price` decimal(10,2) DEFAULT 0.00,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblbook`
--

INSERT INTO `tblbook` (`ID`, `UserID`, `AptNumber`, `AptDate`, `AptTime`, `Service`, `Message`, `BookingDate`, `Remark`, `Status`, `RemarkDate`, `Service_Total_Price`, `deleted_at`) VALUES
(5, 17, 351575381, '2024-11-23', '16:00:00', 'Haircut - 80', 'Repeat client', '2024-12-12 02:30:15', 'Reminder sent', 'Confirmed', '2024-12-04 07:35:17', 80.00, '2024-12-04 15:35:17'),
(6, 18, 441675382, '2024-11-23', '18:00:00', 'Manicure - 70', 'Late booking', '2024-12-04 00:25:05', NULL, 'Pending', '2024-12-04 06:02:12', 70.00, NULL),
(9, 24, 711975385, '2024-11-24', '13:30:00', 'Facial - 150', 'First appointment', '2024-11-17 03:30:35', 'Looking forward to it', 'Confirmed', '2024-11-15 11:50:59', 150.00, NULL),
(11, 13, 941138977, '2024-11-21', '10:00:00', 'Hair Botox - 1500, Scalp Treatment - 150', 'dasfsadfsdf', '2024-11-19 03:12:44', 'were fully book in this date', 'Rejected', '2024-11-19 03:13:23', 1650.00, NULL),
(12, 13, 943320014, '2024-12-11', '11:00:00', 'Haircut - 80', 'asfdasdfasf', '2024-12-04 07:06:42', NULL, NULL, NULL, 80.00, NULL),
(13, 13, 526723002, '2024-12-05', '19:00:00', 'Manicure - 70', 'test', '2024-12-04 07:08:10', NULL, NULL, NULL, 70.00, NULL),
(14, 13, 313225691, '2024-12-04', '17:00:00', 'Foot Spa - 300', 'asdfasdfasfasfasfasfasf', '2024-12-04 07:30:41', NULL, NULL, NULL, 300.00, NULL),
(15, 13, 380400475, '2024-12-10', '09:00:00', 'Straightening - 300', 'testtesettesttest', '2024-12-04 07:35:06', NULL, NULL, NULL, 300.00, NULL),
(16, 13, 639404800, '2024-12-11', '15:00:00', 'Manicure - 70', '123dsfgsdfg', '2024-12-04 07:35:48', NULL, NULL, NULL, 70.00, NULL),
(17, 26, 501443747, '2024-12-12', '09:00:00', 'Haircut - 80', 'testtest', '2024-12-11 15:33:55', NULL, NULL, NULL, 80.00, NULL),
(18, 26, 179985852, '2024-12-12', '18:00:00', 'Hair Spa - 300', 'asdfasdfasdf', '2024-12-11 15:56:01', 'test remark', 'Confirmed', '2024-12-11 16:02:01', 300.00, NULL),
(19, 26, 321266653, '2024-12-16', '13:00:00', 'Foot Spa - 300', 'asdfasdfasdf', '2024-12-11 15:57:29', 'See you here!', 'Confirmed', '2024-12-11 15:58:07', 300.00, NULL),
(20, 26, 527827788, '2024-12-13', '09:00:00', 'Hair Botox - 1500', 'fasfasdfsdfasdfsfsdf', '2024-12-11 16:14:36', NULL, NULL, NULL, 1500.00, NULL),
(21, 26, 797295309, '2024-12-13', '10:00:00', 'Rebond - 1000', 'fsafffffffffffffffff', '2024-12-11 16:15:10', NULL, NULL, NULL, 1000.00, NULL),
(22, 26, 770145972, '2024-12-13', '11:00:00', 'Haircut - 80', 'i would like to get a hair cut', '2024-12-11 16:15:55', NULL, NULL, NULL, 80.00, NULL),
(23, 26, 798839964, '2024-12-13', '14:00:00', 'Scalp Treatment - 150', 'please treat my scalp its been giving me a headache of itchy it is because of dandruff', '2024-12-11 16:16:45', NULL, NULL, NULL, 150.00, NULL),
(24, 26, 691425232, '2024-12-13', '15:00:00', 'Hair Spa - 300', 'testtesttesttestteste', '2024-12-11 16:17:12', NULL, NULL, NULL, 300.00, NULL),
(25, 26, 327935934, '2024-12-14', '16:00:00', 'Straightening - 300', 'fffff', '2024-12-11 16:17:33', NULL, NULL, '2024-12-11 16:18:52', 300.00, NULL),
(26, 27, 646259459, '2024-12-16', '18:00:00', 'Foot Spa - 300', 'ssssssssss', '2024-12-12 02:16:28', 'test remark', 'Confirmed', '2024-12-12 02:16:53', 300.00, NULL),
(40, 25, 272973165, '2025-01-01', '19:00:00', 'Hair Botox - 1500', 'oreiur', '2024-12-15 13:50:37', 'test confirm', 'Confirmed', '2024-12-15 13:54:12', 1500.00, NULL),
(44, 26, 792463197, '2025-02-12', '16:00:00', 'Hair Botox - 1500', 'bokjwbet', '2024-12-16 10:46:34', 'test test', 'Confirmed', '2024-12-16 10:46:53', 1500.00, NULL);

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
(4, 'Fatima', 'Mabang', 9265369733, 'fahatmahmabang9+1@gmail.com', 'fasdfasfasdfasfd', '2024-12-16 06:58:08', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblfeedback`
--

CREATE TABLE `tblfeedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` tinyint(4) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblfeedback`
--

INSERT INTO `tblfeedback` (`id`, `user_id`, `rating`, `comment`, `created_at`) VALUES
(1, 25, 2, 'test', '2024-12-11 14:22:39'),
(2, 25, 2, 'test', '2024-12-11 14:33:55'),
(3, 25, 2, 'test', '2024-12-11 14:34:50'),
(4, 26, 1, 'testtest feedback', '2024-12-12 01:44:40'),
(5, 25, 5, 'test test', '2024-12-15 14:07:46');

-- --------------------------------------------------------

--
-- Table structure for table `tblinvoice`
--

CREATE TABLE `tblinvoice` (
  `id` int(11) NOT NULL,
  `Userid` int(11) DEFAULT NULL,
  `ServiceId` int(11) DEFAULT NULL,
  `BillingId` int(11) DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblinvoice`
--

INSERT INTO `tblinvoice` (`id`, `Userid`, `ServiceId`, `BillingId`, `PostingDate`, `deleted_at`) VALUES
(16, 25, 6, 928684782, '2024-12-15 14:02:57', '2024-12-16 18:41:55'),
(17, 26, 1, 129965839, '2024-12-16 10:47:18', NULL);

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
(1, 'Hair Wax', 'Hair wax is a styling product used to create and hold a wide range of hairstyles.', 50, 'hair-wax.jpg'),
(2, 'Rebond Comb', 'A rebond comb is a wide-toothed comb often used during hair rebonding treatments.', 50, 'rebond-comb.jpg'),
(3, 'Styling Gel', 'Hair gel is a clear or colored product that provides a strong hold and shiny finish for hair. It’s often used for slick, sleek styles or spiked looks.', 35, 'styling-gel.jpg'),
(4, 'Hair Color', 'Hair color is used to dye hair, either permanently or semi-permanently, in a variety of shades.', 80, 'hair-color.jpg'),
(5, 'Conditioner', 'Hydrates and smooths hair after shampooing. Available in various formulas for different hair needs.', 30, 'conditioner.jpg'),
(6, 'Hairspray', 'Spray used to set and hold hairstyles in place for longer durations.', 35, 'hairspray.jpg'),
(7, 'Dry Shampoo', 'Powder or spray used to clean hair without water by absorbing excess oil.', 30, 'dry-shampoo.jpg'),
(8, 'Heat Protectant', 'Spray or serum applied before heat styling to protect hair from damage.', 35, 'heat-protectant.jpg'),
(9, 'Hair Mask', 'Intensive conditioning treatment applied to repair and nourish hair.', 80, 'hair-mask.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tblservices`
--

CREATE TABLE `tblservices` (
  `ID` int(10) NOT NULL,
  `ServiceName` varchar(200) DEFAULT NULL,
  `ServiceDescription` mediumtext DEFAULT NULL,
  `Cost` int(10) DEFAULT NULL,
  `Image` varchar(200) DEFAULT NULL,
  `Time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblservices`
--

INSERT INTO `tblservices` (`ID`, `ServiceName`, `ServiceDescription`, `Cost`, `Image`, `Time`) VALUES
(1, 'Hair Botox', 'A deep conditioning treatment that helps repair damaged hair, making it smoother, shinier, and healthier. It reduces frizz and adds softness to your hair.', 1500, 'hair-botox.jpg', 90),
(2, 'Haircut', 'A professional trim or style for your hair, tailored to your preference.', 80, 'haircut.jpg', 45),
(3, 'Cellophane', 'A hair treatment that adds shine and enhances the color of your hair, leaving it looking vibrant and glossy.', 300, 'cellophane.jpg', 60),
(4, 'Hair Spa', 'A nourishing treatment that deeply moisturizes your hair and scalp, promoting healthier and shinier hair.', 300, 'hair-spa.jpg', 75),
(5, 'Rebond', 'A chemical treatment that straightens curly or wavy hair, leaving it smooth and sleek.', 1000, 'rebond.jpg', 180),
(6, 'Foot Spa', 'A relaxing treatment for your feet that includes soaking, exfoliation, and moisturizing to soften and refresh your skin.', 300, 'foot-spa.jpg', 60),
(7, 'Manicure', 'A beauty treatment for your hands and nails that includes nail shaping, cuticle care, and optional polish application.', 70, 'manicure.jpg', 45),
(8, 'Blow-Dry', 'Shampoo, blow-dry, and styling. Often leaves hair smooth and voluminous.', 120, 'blow-dry.jpg', 30),
(9, 'Hair Extensions', 'Adding length or volume with synthetic or natural hair extensions. Can be applied through different methods (clip-in, tape-in, sew-in).', 600, 'hair-extension.jpg', 120),
(10, 'Scalp Treatment', 'Treatments to improve scalp health, reduce dandruff, or stimulate hair growth. Often involves massaging and specialized products.', 150, 'scalp-treatment.jpg', 60),
(11, 'Straightening', 'Temporary or permanent straightening using a flat iron or chemical treatments like Japanese straightening or relaxers.', 300, 'straightening.jpg', 90),
(12, 'Perm', 'Chemical treatment to create curls or waves that last for months.', 250, 'perm.jpg', 120);

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
  `account_activation_hash` varchar(64) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `LastLogin` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`ID`, `FirstName`, `LastName`, `MobileNumber`, `Email`, `Password`, `account_activation_hash`, `RegDate`, `LastLogin`) VALUES
(13, 'Leo', 'Nard', 9081685149, 'leonardrosales360@gmail.com', '9697ad4e728e0cb2758df02341aff2c6', NULL, '2024-05-14 10:15:28', '2024-12-16 06:49:25'),
(14, 'jeff', 'masagca', 9949237820, 'jepoymasagca21@gmail.com', '908df52be49d76717b84e45d4a5d7fe7', NULL, '2024-05-21 10:49:54', '2024-12-16 06:49:25'),
(15, 'jericho', 'delamente', 9161694900, 'j.delamente12360@gmail.com', '9684149e2c74583d7a1343000c1504ce', NULL, '2024-06-01 05:52:42', '2024-12-16 06:49:25'),
(16, 'Lhine', 'Amando', 9456475951, 'lhineamando45@gmail.com', '0373930ec3a52b66e0d06c8981ba5770', NULL, '2024-09-26 06:06:26', '2024-12-16 06:49:25'),
(17, 'Lance Vincent', 'Buhat', 9168825525, 'lancebuhat01@gmail.com', 'bd7012bd534bf4dd2a300530d3cf92bd', NULL, '2024-09-26 06:20:45', '2024-12-16 06:49:25'),
(19, 'asd', 'asd', 911212121, 'asd@gmail.com', '1a1dc91c907325c69271ddf0c944bc72', NULL, '2024-10-26 10:06:27', '2024-12-16 06:49:25'),
(23, 'john paul', 'dela cruz', 907005014, 'jpvillaruel02@gmail.com', '32250170a0dca92d53ec9624f336ca24', NULL, '2024-11-01 02:38:37', '2024-12-16 06:49:25'),
(25, 'Fahatmah', 'Mabang', 926536973, 'fahatmahmabang9@gmail.com', '0cef1fb10f60529028a71f58e54ed07b', NULL, '2024-12-11 13:16:23', '2024-12-16 06:49:25'),
(26, 'Fatima', 'Mabang', 912121212, 'fahatmahmabang9+1@gmail.com', '0cef1fb10f60529028a71f58e54ed07b', NULL, '2024-12-11 15:24:55', '2024-12-16 06:49:25'),
(27, 'Fat', 'Fat', 942354238, 'fahatmahmabang9+2@gmail.com', '0cef1fb10f60529028a71f58e54ed07b', NULL, '2024-12-12 02:06:49', '2024-12-16 06:50:03');

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
-- Indexes for table `tblfeedback`
--
ALTER TABLE `tblfeedback`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `tblcontact`
--
ALTER TABLE `tblcontact`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblfeedback`
--
ALTER TABLE `tblfeedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblinvoice`
--
ALTER TABLE `tblinvoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tblpage`
--
ALTER TABLE `tblpage`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblproducts`
--
ALTER TABLE `tblproducts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tblservices`
--
ALTER TABLE `tblservices`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
