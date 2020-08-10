-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2020 at 02:16 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sport_equip`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(4) NOT NULL COMMENT 'מזהה משתמש',
  `cust_personalID` int(9) NOT NULL COMMENT 'תעודת זהות לקוח',
  `first_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'שם פרטי',
  `last_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'שם משפחה',
  `email` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'דואר אלקטרוני',
  `street` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'משלוח - רחוב',
  `house_num` int(3) DEFAULT NULL COMMENT 'משלוח - מס'' בית',
  `city` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'משלוח - עיר',
  `phone` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'טלפון נייד'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `cust_personalID`, `first_name`, `last_name`, `email`, `street`, `house_num`, `city`, `phone`) VALUES
(31, 566676545, 'שרון', 'לוי', 'sharon_b5@gmail.com', 'זבוטינסקי', 2, 'גבעתיים', '0526678901'),
(32, 204467122, 'גאיה', 'דרור', 'gaya27@gamail.com', 'יהודה הלוי', 5, 'רחובות', '0501145623'),
(33, 244589700, 'דניאל', 'רפאלי', 'daniel90@gmail.con', 'הירדן', 47, 'ירושלים', '0548070991'),
(34, 307881668, 'עמית', 'שרעבי', 'amitt89SH@gmail.com', 'הירדן', 86, 'רמת גן', '0546672133'),
(35, 453388987, 'אלון', 'יחזקאל', 'alonY@gmail.com', 'ההסתדרות', 56, 'קריית ביאליק', '0548896110'),
(36, 536543337, 'יונתן', 'גל', 'jonathan34@gmail.com', 'רוטשילד', 48, 'אשדוד', '0503900122'),
(37, 366477865, 'גיל', 'כהן', 'gil@gmail.com', 'הירדן', 36, 'קריית ביאליק', '0506678773');

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `item_code` int(4) NOT NULL COMMENT 'מזהה ציוד',
  `item_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'שם הציוד',
  `price` decimal(6,2) NOT NULL COMMENT 'מחיר',
  `stock_amount` int(3) NOT NULL COMMENT 'כמות במלאי',
  `item_image` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'כותרת התמונה של המוצר'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`item_code`, `item_name`, `price`, `stock_amount`, `item_image`) VALUES
(1, 'משקולת 2 ק\"ג', '25.00', 89, 'Dumbbell2kg.jpeg'),
(2, 'משקולת 15 ק\"ג', '59.99', 92, 'Dumbbell15kg.jpg'),
(3, 'מזרן יוגה', '119.80', 91, 'YogaMat.jpeg'),
(4, 'כדור פילאטיס - קוטר 45', '42.00', 94, 'YogaBall.jpg'),
(5, 'רצועת TRX', '85.00', 89, 'TrxBand.jpg'),
(6, 'גומיית התנגדות ', '79.50', 93, 'ResistanceBand.jpg'),
(7, 'חבל קפיצה', '32.50', 91, 'JumpRope.jpg'),
(11, 'גלגל בטן', '56.90', 94, 'AbRoller.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `ordered_items`
--

CREATE TABLE `ordered_items` (
  `e_o_id` int(4) NOT NULL COMMENT 'מזהה עבור פריט מוזמן',
  `equip` int(4) NOT NULL COMMENT 'הפריט שהוזמן',
  `amount` int(3) NOT NULL COMMENT 'כמות שהוזמנה',
  `order_num` int(6) NOT NULL COMMENT 'מספר הזמנה אליה הוא שייך'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ordered_items`
--

INSERT INTO `ordered_items` (`e_o_id`, `equip`, `amount`, `order_num`) VALUES
(64, 2, 2, 12),
(66, 5, 1, 16),
(67, 6, 1, 16),
(68, 3, 2, 17),
(69, 4, 1, 18),
(70, 11, 1, 18),
(71, 6, 1, 19),
(72, 2, 3, 20),
(73, 3, 1, 20),
(74, 1, 2, 21),
(75, 7, 1, 21),
(76, 5, 1, 22),
(77, 7, 1, 22),
(78, 11, 1, 22),
(79, 4, 3, 23),
(80, 7, 1, 23),
(81, 6, 2, 24),
(82, 1, 2, 25),
(83, 3, 1, 25),
(84, 5, 1, 25),
(85, 6, 1, 26),
(86, 1, 3, 27),
(87, 2, 1, 27),
(88, 2, 2, 28),
(89, 3, 1, 28),
(90, 5, 1, 28),
(91, 7, 1, 28),
(92, 5, 2, 29),
(93, 7, 1, 29),
(94, 2, 2, 30),
(95, 3, 1, 30),
(96, 4, 2, 30),
(97, 7, 1, 30),
(98, 5, 4, 31),
(99, 6, 2, 31),
(100, 7, 1, 31),
(101, 1, 2, 32),
(102, 3, 1, 32),
(103, 5, 1, 32),
(104, 11, 2, 32),
(105, 1, 2, 33),
(106, 3, 2, 33),
(107, 7, 2, 33);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(7) NOT NULL COMMENT 'מזהה הזמנה',
  `ordered_by` int(4) NOT NULL COMMENT 'הלקוח שביצע את ההזמנה',
  `total_pay` decimal(6,2) NOT NULL COMMENT 'תשלום כולל להזמנה (ללא משלוח)',
  `date_ordered` date NOT NULL COMMENT 'תאריך ביצוע הזמנה'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `ordered_by`, `total_pay`, `date_ordered`) VALUES
(12, 31, '119.98', '2020-07-29'),
(16, 31, '164.50', '2020-07-29'),
(17, 31, '239.60', '2020-07-29'),
(18, 31, '98.90', '2020-07-29'),
(19, 31, '79.50', '2020-08-04'),
(20, 32, '299.77', '2020-08-04'),
(21, 33, '82.50', '2020-08-04'),
(22, 32, '174.40', '2020-08-04'),
(23, 33, '158.50', '2020-08-04'),
(24, 32, '159.00', '2020-08-04'),
(25, 34, '254.80', '2020-08-04'),
(26, 32, '79.50', '2020-08-04'),
(27, 34, '134.99', '2020-08-07'),
(28, 35, '357.28', '2020-08-09'),
(29, 33, '202.50', '2020-08-09'),
(30, 36, '356.28', '2020-08-09'),
(31, 32, '531.50', '2020-08-09'),
(32, 37, '368.60', '2020-08-09'),
(33, 37, '354.60', '2020-08-09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `cust_personalID` (`cust_personalID`),
  ADD UNIQUE KEY `cust_personalID_2` (`cust_personalID`),
  ADD UNIQUE KEY `cust_personalID_3` (`cust_personalID`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`item_code`);

--
-- Indexes for table `ordered_items`
--
ALTER TABLE `ordered_items`
  ADD PRIMARY KEY (`e_o_id`),
  ADD KEY `fk_equip` (`equip`) USING BTREE,
  ADD KEY `fk_order_num` (`order_num`) USING BTREE;

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_customerId` (`ordered_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(4) NOT NULL AUTO_INCREMENT COMMENT 'מזהה משתמש', AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `item_code` int(4) NOT NULL AUTO_INCREMENT COMMENT 'מזהה ציוד', AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `ordered_items`
--
ALTER TABLE `ordered_items`
  MODIFY `e_o_id` int(4) NOT NULL AUTO_INCREMENT COMMENT 'מזהה עבור פריט מוזמן', AUTO_INCREMENT=108;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(7) NOT NULL AUTO_INCREMENT COMMENT 'מזהה הזמנה', AUTO_INCREMENT=34;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `ordered_items`
--
ALTER TABLE `ordered_items`
  ADD CONSTRAINT `ordered_items_ibfk_2` FOREIGN KEY (`equip`) REFERENCES `equipment` (`item_code`),
  ADD CONSTRAINT `ordered_items_ibfk_3` FOREIGN KEY (`order_num`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`ordered_by`) REFERENCES `customers` (`customer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
