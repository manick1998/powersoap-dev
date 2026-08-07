-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 08, 2022 at 09:53 AM
-- Server version: 5.7.39
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `powersoap_stage`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_controls`
--

CREATE TABLE `admin_controls` (
  `id` int(11) NOT NULL,
  `token` char(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `active_status` enum('1','2') NOT NULL COMMENT '1-active,2-blocked',
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_controls`
--

INSERT INTO `admin_controls` (`id`, `token`, `name`, `active_status`, `date_time`) VALUES
(1, '62969715', 'mfs', '1', '2022-06-16 15:19:03'),
(2, '97314425', 'aog', '2', '2022-06-16 15:19:09');

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

CREATE TABLE `admin_login` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `token` char(10) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `password` text,
  `phone_number` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_login`
--

INSERT INTO `admin_login` (`id`, `name`, `token`, `email`, `password`, `phone_number`) VALUES
(1, 'Admin', '12345679', 'powersoapsadmin@gmail.com', 'f1f96c1eaf065d768ac8ee4ddb113cf4fcac0f8bfc1206308f12b18752158f657bc235e54e71f2670d95efa2b87b6f6a3893aff3cd5853516ec9a78c92240066', '9443234489');

-- --------------------------------------------------------

--
-- Table structure for table `admin_notification`
--

CREATE TABLE `admin_notification` (
  `id` int(11) NOT NULL,
  `token` char(10) NOT NULL,
  `distributor_token` char(10) NOT NULL,
  `notification_title` varchar(100) NOT NULL,
  `notification_description` longtext NOT NULL,
  `date_time` datetime NOT NULL,
  `seen_status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0-unseen, 1-seen',
  `delete_status` enum('1','2') NOT NULL DEFAULT '1' COMMENT '1-active, 2-deleted'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admin_offers`
--

CREATE TABLE `admin_offers` (
  `id` int(11) NOT NULL,
  `token` varchar(20) NOT NULL,
  `offer_name` varchar(60) NOT NULL,
  `offer_percentage` float NOT NULL COMMENT 'in %',
  `division_token` varchar(20) NOT NULL COMMENT '`products__category`.`token`',
  `minimum_purchase_amount` float NOT NULL,
  `created_date` datetime NOT NULL,
  `status` enum('1','2') NOT NULL COMMENT '1-active, 2-deleted',
  `deleted_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_offers`
--

INSERT INTO `admin_offers` (`id`, `token`, `offer_name`, `offer_percentage`, `division_token`, `minimum_purchase_amount`, `created_date`, `status`, `deleted_datetime`) VALUES
(1, '52658375', 'New one', 15, '79043432', 1000000, '2022-05-10 16:35:53', '2', '2022-05-17 11:25:41'),
(2, '39772630', 'new offer', 8, '78021474', 10000, '2022-05-10 16:37:35', '2', '2022-05-10 16:53:46'),
(3, '74349997', 'Soap1', 4, '79043432', 30000, '2022-05-10 18:09:15', '2', '2022-05-17 10:29:52'),
(4, '47318259', 'Soap 2', 5, '79043432', 35000, '2022-05-10 18:09:31', '2', '2022-05-18 17:12:15'),
(5, '90623402', 'soap 3', 10, '79043432', 40000, '2022-05-10 18:09:55', '2', '2022-05-18 17:12:09'),
(6, '39621892', 'test liquid', 6, '47758351', 1000, '2022-05-10 18:28:36', '2', '2022-05-18 17:12:02'),
(7, '34282759', 'Get 1% offer on all Fabric conditioner product ', 1, '40879968', 200000, '2022-05-17 10:29:33', '1', '0000-00-00 00:00:00'),
(8, '40866432', 'Get 2% off on purchase above 50k', 2, '15246751', 50000, '2022-05-17 11:28:58', '2', '2022-05-18 17:11:57'),
(9, '69925477', 'THREE BEAUTY SOAP COMBO OFFERS', 13, '80587639', 13000, '2022-05-17 17:11:40', '2', '2022-05-18 17:11:35'),
(10, '16491526', 'Washing Offer', 5, '19727821', 50000, '2022-05-17 17:12:50', '2', '2022-05-18 17:11:29'),
(11, '70456723', 'Ultimate Offer', 3, '15246751', 25000, '2022-05-17 17:13:30', '2', '2022-05-18 17:11:24'),
(12, '54990506', 'WASHER OFFER', 10, '46668737', 15000, '2022-05-17 17:16:11', '2', '2022-05-18 17:11:18'),
(13, '88859857', 'Get Off 1% on Buying Products More than 5L', 1, '80587639', 500000, '2022-05-18 17:15:29', '1', '0000-00-00 00:00:00'),
(14, '53885087', 'Get Off 2% on Buying Products More than 7.5L', 2, '80587639', 750000, '2022-05-18 17:17:09', '1', '0000-00-00 00:00:00'),
(15, '74310246', 'Get Off 3% on Buying Products More than 12L', 3, '80587639', 1200000, '2022-05-18 17:18:26', '1', '0000-00-00 00:00:00'),
(16, '26844304', 'Get Off 1% on Buying Products More than 1L', 1, '19727821', 100000, '2022-05-18 17:19:47', '1', '0000-00-00 00:00:00'),
(17, '80692131', 'Get Off 2% on Buying Products More than 2L', 2, '19727821', 200000, '2022-05-18 17:20:18', '1', '0000-00-00 00:00:00'),
(18, '63877551', 'Get Off 3% on Buying Products More than 3L', 3, '19727821', 300000, '2022-05-18 17:20:47', '1', '0000-00-00 00:00:00'),
(19, '64855903', 'Get Off 1% on Buying Products More than 2L', 1, '70517400', 200000, '2022-05-18 17:22:06', '1', '0000-00-00 00:00:00'),
(20, '66571982', 'Get Off 2% on Buying Products More than 3L', 2, '70517400', 300000, '2022-05-18 17:22:41', '1', '0000-00-00 00:00:00'),
(21, '20810214', 'Get Off 3% on Buying Products More than 5L', 3, '70517400', 500000, '2022-05-18 17:23:05', '1', '0000-00-00 00:00:00'),
(22, '23155641', 'Get Off 1% on Buying Products More than 1L', 1, '47758351', 100000, '2022-05-18 17:24:32', '1', '0000-00-00 00:00:00'),
(23, '27654764', 'Get Off 2% on Buying Products More than 2L', 2, '47758351', 200000, '2022-05-18 17:24:59', '1', '0000-00-00 00:00:00'),
(24, '87356113', 'Get Off 3% on Buying Products More than 4L', 3, '47758351', 400000, '2022-05-18 17:25:22', '1', '0000-00-00 00:00:00'),
(25, '46639810', 'Get Off 1% on Buying Products More than 7.5L', 1, '79043432', 750000, '2022-05-18 17:26:34', '1', '0000-00-00 00:00:00'),
(26, '17399074', 'Get Off 2% on Buying Products More than 15L', 2, '79043432', 1500000, '2022-05-18 17:27:18', '1', '0000-00-00 00:00:00'),
(27, '47817411', 'Get Off 3% on Buying Products More than 20L', 3, '79043432', 2000000, '2022-05-18 17:27:53', '1', '0000-00-00 00:00:00'),
(28, '60685842', 'Get Off 1% on Buying Products More than 2L', 1, '15246751', 200000, '2022-05-23 16:21:55', '1', '0000-00-00 00:00:00'),
(29, '98949794', 'Get Off 2% on Buying Products More than 3L', 2, '15246751', 300000, '2022-05-23 16:23:02', '1', '0000-00-00 00:00:00'),
(30, '59402112', 'Get Off 3% on Buying Products More than 5L', 3, '15246751', 500000, '2022-05-23 16:23:31', '1', '0000-00-00 00:00:00'),
(31, '89110881', 'Get Off 1% on Buying Products More than 5L', 1, '46668737', 500000, '2022-05-23 16:24:23', '1', '0000-00-00 00:00:00'),
(32, '53611940', 'Get Off 2% on Buying Products More than 8L', 2, '46668737', 800000, '2022-05-23 16:24:52', '1', '0000-00-00 00:00:00'),
(33, '81533164', 'Get Off 3% on Buying Products More than 12L', 3, '46668737', 1200000, '2022-05-23 16:26:23', '1', '0000-00-00 00:00:00'),
(35, '43760858', 'Get Off 1% on Buying Products More than 4L', 1, '38017591', 400000, '2022-07-08 18:14:25', '1', '0000-00-00 00:00:00'),
(36, '15649795', 'Get Off 2% on Buying Products More than 6L', 2, '38017591', 600000, '2022-07-08 18:14:25', '1', '0000-00-00 00:00:00'),
(37, '76264100', 'Get Off 3% on Buying Products More than 9L', 3, '38017591', 900000, '2022-07-08 18:16:40', '1', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `daily_schedule`
--

CREATE TABLE `daily_schedule` (
  `id` int(11) NOT NULL,
  `unit_token` char(10) NOT NULL,
  `distributor_token` char(10) NOT NULL,
  `sales_emp_token` char(10) NOT NULL,
  `delivery_emp_token` char(10) NOT NULL,
  `schedule_date` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL COMMENT '''Monday'',''Tuesday'',''Wednesday'',''Thursday'',''Friday'',''Saturday'',''Sunday''',
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `daily_schedule`
--

INSERT INTO `daily_schedule` (`id`, `unit_token`, `distributor_token`, `sales_emp_token`, `delivery_emp_token`, `schedule_date`, `date_time`) VALUES
(1, '60390422', '30695824', '', '', 'Monday', '2022-07-25 12:52:56'),
(2, '60390422', '30695824', '', '', 'Tuesday', '2022-07-25 12:52:56'),
(3, '60390422', '30695824', '', '', 'Wednesday', '2022-07-25 12:52:56'),
(4, '60390422', '30695824', '', '', 'Thursday', '2022-07-25 12:52:56'),
(5, '60390422', '30695824', '', '', 'Friday', '2022-07-25 12:52:56'),
(6, '60390422', '30695824', '', '', 'Saturday', '2022-07-25 12:52:56'),
(7, '60390422', '30695824', '', '', 'Sunday', '2022-07-25 12:52:56');

-- --------------------------------------------------------

--
-- Table structure for table `deparment`
--

CREATE TABLE `deparment` (
  `id` int(11) NOT NULL,
  `token` char(10) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deparment`
--

INSERT INTO `deparment` (`id`, `token`, `name`, `date_time`) VALUES
(1, '18028120', 'Distributor', '2022-04-11 19:30:45'),
(4, '45916684', 'Sales', '2022-04-11 21:16:42'),
(5, '93402780', 'Delivery', '2022-04-11 21:18:07');

-- --------------------------------------------------------

--
-- Table structure for table `dist__stock_order`
--

CREATE TABLE `dist__stock_order` (
  `id` int(11) NOT NULL,
  `order_id` char(10) NOT NULL,
  `product_token` char(10) NOT NULL,
  `items` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `amount` double NOT NULL,
  `employee_token` char(10) NOT NULL,
  `order_status` varchar(25) NOT NULL,
  `order_date_time` datetime NOT NULL,
  `approved_date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `token` char(10) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  `employees_code` varchar(10) DEFAULT NULL,
  `email_id` varchar(60) NOT NULL,
  `password` varchar(150) NOT NULL,
  `deparment_token` char(10) DEFAULT NULL COMMENT '57061756 - Admin, 18028120- Distributor, 45916684 - Sales, 93402780 - Delivery',
  `admin_distributor_token` char(10) NOT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL COMMENT '(''Male'', ''Female'', ''Other'')',
  `mobile_number` double DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `resignation_date` date DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `blood_group` varchar(15) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `pincode` int(11) DEFAULT NULL,
  `street` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `address_proof` text,
  `license_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `region` varchar(100) DEFAULT NULL,
  `delete_status` enum('1','2') NOT NULL DEFAULT '1' COMMENT '1-active,2-deleted',
  `block_status` enum('1','2') NOT NULL COMMENT '1-active,2-blocked',
  `employee_image` text NOT NULL,
  `otp` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `token`, `name`, `date_time`, `employees_code`, `email_id`, `password`, `deparment_token`, `admin_distributor_token`, `gender`, `mobile_number`, `join_date`, `dob`, `blood_group`, `address`, `pincode`, `street`, `city`, `address_proof`, `license_number`, `region`, `delete_status`, `block_status`, `employee_image`, `otp`) VALUES
(1, '86414377', 'Kirupa Traders', '2022-06-22 11:56:57', 'POWDIST001', 'kirupatraders@gmail.com', '6da9c2826301ec1cfff7442916b079f2b07a6e490295841f64822684c3c6ad007e61945a5ee2bcc5892eab20f93dfc2d0845f122ab5d4939782e3a525932fb74', '18028120', '', NULL, 9444924827, '2022-06-22', '1970-01-01', NULL, 'No.13 ', 600053, 'Arisi kaara street, Menambedu, Ambattur.', 'Chennai', '', '33AAJFK1498B1ZI', '', '1', '1', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_24383119_1655892660.jpeg', ''),
(2, '23525647', 'S.J.Marketing', '2022-06-22 12:04:59', 'POWDIST002', 'jebastinpushpa@gmail.com', 'd49fd8eb5f574c38f60e67719bc4f18516243e87da9e833d2999110dfca5598e19476bf3dceb03009ce02929f50267404bb5cc0afbf2c02264284caf49dbe555', '18028120', '', NULL, 8144009070, '2022-06-22', '1970-01-01', NULL, '13', 600053, 'ARISIKARAR STREET, MENAMBEDU, AMBATTUR,TIRUVALLUR', 'Chennai', '', '33GYAPS7273F1Z6', '', '1', '1', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_57145326_1655892676.jpeg', ''),
(3, '30695824', 'PONMANI AGENCY', '2022-06-22 12:22:38', 'POWDIST003', 'ponmaniagency2022@gmail.com', '1196997ed3719b57acdec50c99bd9ea2e3efdfb18375d59efeba6ecf701b0ef927d6a9beade7e8a05bc4a5590ef41445729b19696bb848b819771980475be066', '18028120', '', NULL, 9382667090, '2022-06-22', '1970-01-01', NULL, '13A', 600053, 'ARISIKARAR STREET, MENAMBEDU, AMBATTUR,TIRUVALLUR, ', 'Chennai', '', '33AAKFP2105R1Z1', '', '1', '1', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_99616652_1655892587.jpeg', ''),
(4, '18302437', 'NAVEEN ', '2022-06-23 16:22:45', 'SAL7689611', '', 'de3dbaccf5fecc6e89628c92448bf7c57025f1a9b732d736415578cf16bce644c9e80436f179a8d11fa2dcac2129109a34dbc627ab2f59720fdeb0993b285c6b', '45916684', '30695824', 'Male', 9360105870, '1970-01-01', '1970-01-01', '', 'NO 13 A ', 600053, 'ARISI KARA STREET', 'MENAMBEDU  AMBATTUR  CHENNAI', '', '', '', '1', '1', '', ''),
(9, '58818320', 'PANCHAVARNA ASSOCIATES', '2022-06-27 12:47:15', 'POWDIST004', 'panchavarnaassociates@gmail.com', '9202853efcdfc919ffa82f34bd5500539685891e31320c607932508989968ae39a6aa38a0767d034f58439d77bcd97a5f9feb7d5fe49beb7c342bc8ad4cf9605', '18028120', '', NULL, 9381010440, '2022-06-27', '1970-01-01', NULL, 'No.15/2 , ', 600041, 'Dharamambal Street , Avvai Nagar,Thiruvanmiyur', 'Chennai', '', '33ALCPK1541K1ZE', '', '1', '1', '', ''),
(10, '51720765', 'Danish Enterprises', '2022-06-27 13:35:10', 'POWDIST005', 'danishenterprises1220@gmail.com', '50a28b4e53ff78dbb59e7a7538e4c50b16f259b903aaa15e212d3e54a808c00ec7cd24349571a406c681ff12c324f6f6afbf459ceb531ba18fe1dcd4241f7f22', '18028120', '', NULL, 8124375959, '2022-06-27', '1970-01-01', NULL, '89 Madras Telephone Nagar,', 600096, '9th Cross Street, Perungudi', 'Chennai', '', '33AWIPD1312Q2ZN', '', '1', '1', '', ''),
(14, '14145961', 'GAYATHRI TRADERS', '2022-07-08 11:37:18', 'POWDIST006', 'jbtraders.ram@gmail.com', 'c37fe02a5812da988385026684c8b84d46b0316c4ac1ff03ed45da2db3cf87aefcf8086643340b7a7f99f15cb2c271d8343d96150ff9eddbf58e828653224244', '18028120', '', NULL, 9176211252, '2022-07-08', '1970-01-01', NULL, '8-A,avvai 2nd street', 600100, 'Periyar Nagar', 'Pallikaranai,Chennai', '', '33BVPPK8165F1Z9', '', '1', '1', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `employees__attachments`
--

CREATE TABLE `employees__attachments` (
  `id` int(11) NOT NULL,
  `employee_token` char(10) DEFAULT NULL,
  `attachment_url` varchar(200) DEFAULT NULL,
  `attachment_type` enum('ADDRESS','OTHERS','','') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employees__daily_summary`
--

CREATE TABLE `employees__daily_summary` (
  `id` int(11) NOT NULL,
  `date_time` datetime DEFAULT NULL,
  `department_token` char(10) DEFAULT NULL,
  `employees_token` char(10) DEFAULT NULL,
  `location_token` char(10) DEFAULT NULL COMMENT '`units`.`token`',
  `order_value` double DEFAULT NULL,
  `collection` double DEFAULT NULL,
  `productivity` varchar(20) DEFAULT NULL,
  `outlets_covered` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employees__division_mapping`
--

CREATE TABLE `employees__division_mapping` (
  `id` int(11) NOT NULL,
  `employee_token` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '`employees`.`token`',
  `division_token` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '`products__category`.`token`',
  `delete_status` enum('1','2') NOT NULL COMMENT '1-active,2-deleted',
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees__division_mapping`
--

INSERT INTO `employees__division_mapping` (`id`, `employee_token`, `division_token`, `delete_status`, `datetime`) VALUES
(1, '86414377', '80587639', '1', '2022-06-22 11:56:57'),
(2, '86414377', '70517400', '1', '2022-06-22 11:56:57'),
(3, '86414377', '79043432', '1', '2022-06-22 11:56:57'),
(4, '23525647', '47758351', '1', '2022-06-22 12:04:59'),
(5, '30695824', '47758351', '1', '2022-06-22 12:22:38'),
(6, '30695824', '70517400', '1', '2022-06-22 12:22:38'),
(7, '30695824', '19727821', '1', '2022-06-22 12:22:38'),
(15, '58818320', '47758351', '1', '2022-06-27 12:47:15'),
(16, '58818320', '19727821', '1', '2022-06-27 12:47:15'),
(17, '58818320', '46668737', '1', '2022-06-27 12:47:15'),
(18, '51720765', '47758351', '1', '2022-06-27 13:35:10'),
(19, '14145961', '80587639', '1', '2022-07-08 11:37:18'),
(20, '14145961', '47758351', '1', '2022-07-08 11:37:18'),
(21, '14145961', '79043432', '1', '2022-07-08 11:37:18');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `token` char(10) DEFAULT NULL,
  `order_number` varchar(40) NOT NULL,
  `date_time` datetime DEFAULT NULL,
  `order_type` enum('Sales Order','Spot Order','Distributor Order') NOT NULL COMMENT '''Sales Order'',''Spot Order'',''Distributor Order''',
  `shop_token` char(10) DEFAULT NULL,
  `employee_token` char(10) DEFAULT NULL COMMENT 'distributor token for distributor order,sales token for others',
  `items` int(11) DEFAULT NULL,
  `order_amount` double NOT NULL,
  `gst` double NOT NULL DEFAULT '0',
  `billing_amount` double DEFAULT NULL,
  `delivery` enum('Placed','Pending','Completed','Cancelled','Approved') DEFAULT NULL COMMENT '''Placed'', ''Pending'', ''Completed'',''Cancelled'''',"Approved"',
  `delivery_emp_token` char(8) DEFAULT '0',
  `approved_on` datetime DEFAULT '0000-00-00 00:00:00',
  `delivered_on` datetime DEFAULT '0000-00-00 00:00:00',
  `payment_mode` varchar(20) DEFAULT ' ',
  `paid_amount` double DEFAULT '0',
  `outstanding_amount` double NOT NULL,
  `paid_on` datetime DEFAULT '0000-00-00 00:00:00',
  `bill_discount_amount` double NOT NULL,
  `bill_discount_percentage` double NOT NULL,
  `unit_shop_count` smallint(6) NOT NULL,
  `invoice_name` varchar(300) NOT NULL,
  `product_list` varchar(300) NOT NULL,
  `shop_list` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orders__amount_log`
--

CREATE TABLE `orders__amount_log` (
  `id` int(11) NOT NULL,
  `order_token` char(10) NOT NULL,
  `payment_mode` varchar(20) NOT NULL,
  `amount` double NOT NULL,
  `employee_token` char(10) NOT NULL,
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orders__items`
--

CREATE TABLE `orders__items` (
  `id` int(11) NOT NULL,
  `order_token` char(10) DEFAULT NULL,
  `product_token` char(10) DEFAULT NULL,
  `price_per_unit` double DEFAULT NULL,
  `piece_count` int(10) NOT NULL,
  `misc_price` double DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `offer_token` varchar(20) NOT NULL COMMENT '`admin_offers`.`token`',
  `offer_percentage` varchar(15) NOT NULL,
  `offer_amount` double NOT NULL,
  `free_product` varchar(40) NOT NULL,
  `units` enum('Box','Nos') NOT NULL,
  `delete_status` enum('1','2') NOT NULL COMMENT '1 - active, 2 - inactive',
  `date_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orders__pendingreson`
--

CREATE TABLE `orders__pendingreson` (
  `id` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  `order_token` char(8) NOT NULL,
  `reson` varchar(100) NOT NULL,
  `employee_token` char(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `date_time` datetime DEFAULT NULL,
  `category_token` char(10) NOT NULL COMMENT 'products__category.token',
  `token` char(10) DEFAULT NULL,
  `item_code` varchar(10) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `mrp` double DEFAULT NULL,
  `gst` double DEFAULT '0',
  `total_cost` double DEFAULT NULL,
  `retailer_price` double NOT NULL,
  `piece_count` int(11) NOT NULL,
  `batch_number` varchar(20) DEFAULT NULL,
  `net_weight` varchar(45) DEFAULT NULL,
  `additional_offer` varchar(100) NOT NULL,
  `location` varchar(45) DEFAULT NULL,
  `description` longtext,
  `manufacturer` varchar(25) NOT NULL,
  `origin` varchar(25) NOT NULL,
  `delete_status` enum('1','2') NOT NULL DEFAULT '1' COMMENT '1-active,2-deleted'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `date_time`, `category_token`, `token`, `item_code`, `name`, `image`, `mrp`, `gst`, `total_cost`, `retailer_price`, `piece_count`, `batch_number`, `net_weight`, `additional_offer`, `location`, `description`, `manufacturer`, `origin`, `delete_status`) VALUES
(1, '2022-05-30 16:44:24', '46668737', '60019479', '34011930', 'TRIPLE POWER SOAP (BLUE)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_29553622_1653975172.jpeg', 25, 0, 21.25, 22.53, 60, '101', '250 g', 'Buy 12 Box get 1 Box free', 'Chennai', 'Triple Power Soap (Blue)', 'Power Soap', 'India', '1'),
(2, '2022-05-30 16:44:24', '46668737', '58579862', '34011930', 'ACTIVE POWER SOAP - BIG BAR (BLUE)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_76200433_1655537785.jpeg', 30, 0, 25.5, 27.03, 60, '102', '250 g', '', 'Chennai', 'Active Power Soap - Big Bar (Blue)', 'Power Soap', 'India', '1'),
(3, '2022-05-30 16:44:24', '15246751', '34255484', '34011930', 'TRIPLE POWER SOAP - BIG BAR (BLUE)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_90604966_1655537812.jpeg', 1, 0, 1, 1.06, 60, '103', '300 g', '', 'Chennai', 'Triple Power Soap - Big Bar (Blue)', 'Power Soap', 'India', '1'),
(4, '2022-05-30 16:44:24', '46668737', '97953722', '34011930', 'ACTIVE POWER SOAP 150g (BLUE)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_95494974_1653975321.jpeg', 10, 0, 8.5, 9.01, 60, '104', '150 g', '', 'Chennai', 'Active Power Soap 150G (Blue)', 'Power Soap', 'India', '1'),
(5, '2022-05-30 16:44:24', '46668737', '21561949', '34011930', 'ACTIVE POWER SOAP 150g (YELLOW)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_74046968_1653975353.jpeg', 10, 0, 8.5, 9.01, 60, '105', '150 g', '', 'Chennai', 'Active Power Soap 150G (Yellow)', 'Power Soap', 'India', '1'),
(6, '2022-05-30 16:44:24', '46668737', '19215873', '34011930', 'ACTIVE POWER SOAP 100g (BLUE)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_18059538_1653974735.jpeg', 6, 0, 5.1, 5.41, 78, '106', '100 g', '', 'Chennai', 'Active Power Soap 100G (Blue)', 'Power Soap', 'India', '1'),
(7, '2022-05-30 16:44:24', '46668737', '30700157', '34011930', 'ACTIVE POWER SOAP 100g (YELLOW)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_41810142_1653974773.jpeg', 6, 0, 5.1, 5.41, 78, '107', '100 g', '', 'Chennai', 'Active Power Soap 100G (Yellow)', 'Power Soap', 'India', '1'),
(8, '2022-05-30 16:44:24', '38017591', '27805790', '34011930', 'POWER JUMBO DETERGENT CAKE (BLUE)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_38647097_1655536648.jpeg', 10, 0, 8.5, 9.01, 60, '108', '200 g', '', 'Chennai', 'Power Jumbo Detergent Cake (Blue)', 'Power Soap', 'India', '1'),
(9, '2022-05-30 16:44:24', '38017591', '18952930', '34011930', 'POWER JUMBO DETERGENT CAKE (YELLOW)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_94929271_1655536613.jpeg', 10, 0, 8.5, 9.01, 60, '109', '200 g', '', 'Chennai', 'Power Jumbo Detergent Cake (Yellow)', 'Power Soap', 'India', '1'),
(10, '2022-05-30 16:44:24', '38017591', '31862758', '34011930', 'POWER JUMBO DETERGENT CAKE (PINK)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_94833217_1655536580.jpeg', 10, 0, 8.5, 9.01, 60, '110', '200 g', '', 'Chennai', 'Power Jumbo Detergent Cake (Pink)', 'Power Soap', 'India', '1'),
(11, '2022-05-30 16:44:24', '46668737', '62386721', '34011930', 'POWER MAX DETERGENT CAKE -200g (BLUE)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_95546570_1655536508.jpeg', 20, 0, 17, 18.02, 60, '111', '200 g', '', 'Chennai', 'Power Max Detergent Cake -200G (Blue)', 'Power Soap', 'India', '1'),
(12, '2022-05-30 16:44:24', '46668737', '41950973', '34011930', 'POWER MAX DETERGENT CAKE -150g (BLUE)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_26066078_1655536439.jpeg', 15, 0, 12.75, 13.52, 60, '112', '150 g', '', 'Chennai', 'Power Max Detergent Cake -150G (Blue)', 'Power Soap', 'India', '1'),
(13, '2022-05-30 16:44:24', '15246751', '10788930', '34011930', 'ULTIMATE POWER DETERGENT CAKE', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_94339870_1655536379.jpeg', 10, 0, 8.5, 9.01, 120, '113', '125 g', '', 'Chennai', 'Ultimate Power Detergent Cake', 'Power Soap', 'India', '1'),
(14, '2022-05-30 16:44:24', '15246751', '52063448', '34011930', 'ULTIMATE POWER DETERGENT CAKE(150g)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_22953197_1655536312.jpeg', 1, 0, 1, 1.06, 60, '114', '150 g', '', 'Chennai', 'Ultimate Power Detergent Cake', 'Power Soap', 'India', '1'),
(15, '2022-05-30 16:44:24', '15246751', '39879341', '34011930', 'ULTIMATE POWER DETERGENT CAKE(200g)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_03291212_1655536279.jpeg', 20, 0, 18, 19.08, 60, '115', '200 g', '', 'Chennai', 'Ultimate Power Detergent Cake', 'Power Soap', 'India', '1'),
(16, '2022-05-30 16:44:24', '19727821', '77446634', '34054000', 'GIO DISH WASH BAR', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_77390129_1653974946.jpeg', 5, 0, 4.25, 4.51, 84, '116', '90 g', '', 'Chennai', 'Gio Dish Wash Bar', 'Power Soap', 'India', '1'),
(17, '2022-05-30 16:44:24', '19727821', '95071140', '34054000', 'GIO DISH WASH BAR(150g)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_96834682_1653974986.jpeg', 10, 0, 8.5, 9.01, 60, '117', '150 g', '', 'Chennai', 'Gio Dish Wash Bar', 'Power Soap', 'India', '1'),
(18, '2022-05-30 16:44:24', '19727821', '54145957', '34054000', 'GIO DISH WASH ROUND', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_88698164_1655536095.jpeg', 25, 0, 21.25, 22.53, 40, '118', '250 g', '', 'Chennai', 'Gio Dish Wash Round', 'Power Soap', 'India', '1'),
(19, '2022-05-30 16:44:24', '19727821', '65454633', '34054000', 'GIO DISH WASH BAR(500g)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_06013531_1655536024.jpeg', 40, 0, 34, 36.04, 40, '119', '500 g', '', 'Chennai', 'Gio Dish Wash Bar', 'Power Soap', 'India', '1'),
(20, '2022-05-30 16:44:24', '19727821', '34646300', '34022010', 'GIO POWER LIQUID 150ml', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_18758804_1653975103.jpeg', 20, 0, 18, 19.08, 48, '120', '150 ml', '', 'Chennai', 'Gio Power Liquid 150Ml', 'Power Soap', 'India', '1'),
(21, '2022-05-30 16:44:24', '19727821', '14266541', '34022010', 'GIO DISH WASH LIQUID 500ml', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_70317597_1653974877.jpeg', 90, 0, 76.5, 81.09, 12, '121', '500 ml', '', 'Chennai', 'Gio Dish Wash Liquid 750Ml', 'Power Soap', 'India', '1'),
(22, '2022-05-30 16:44:24', '19727821', '10810093', '34022010', 'GIO DISH WASH LIQUID 75ml', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_97501837_1653974911.jpeg', 10, 0, 8.5, 9.01, 72, '122', '75 ml', '', 'Chennai', 'Gio Dish Wash Liquid 75Ml', 'Power Soap', 'India', '1'),
(23, '2022-05-30 16:44:24', '19727821', '43191488', '73231000', 'GIO EZIE STEEL SCRUBBER', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_97406409_1655535779.jpeg', 20, 0, 8.85, 9.38, 300, '123', '18 g', '', 'Chennai', 'Gio Ezie Steel Scrubber', 'Power Soap', 'India', '1'),
(24, '2022-05-30 16:44:24', '70517400', '21294941', '34011920', 'T.POWER POWDER(13g)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_95969235_1655535690.jpeg', 2, 0, 1.7, 1.8, 960, '124', '13 g', '', 'Chennai', 'T.Power Powder', 'Power Soap', 'India', '1'),
(25, '2022-05-30 16:44:24', '70517400', '91473056', '34011920', 'T.POWER POWDER(75g)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_88611180_1655535604.jpeg', 5, 0, 4.25, 4.51, 144, '125', '75 g', 'Buy 1 box get 12 piece free', 'Chennai', 'T.Power Powder', 'Power Soap', 'India', '1'),
(26, '2022-05-30 16:44:24', '70517400', '52832061', '34011920', 'T.POWER POWDER(125g)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_78125644_1655535537.jpeg', 10, 0, 8.5, 9.01, 72, '126', '125 g', 'Buy 1 box get 6 piece free', 'Chennai', 'T.Power Powder', 'Power Soap', 'India', '1'),
(27, '2022-05-30 16:44:24', '70517400', '42378605', '34011920', 'T.POWER POWDER(500g)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_07537615_1653975227.jpeg', 52, 0, 44.2, 46.85, 30, '127', '500 g', 'Buy 30 piece get 2 free', 'Chennai', 'T.Power Powder', 'Power Soap', 'India', '1'),
(28, '2022-05-30 16:44:24', '70517400', '56722042', '34011920', 'T.POWER POWDER(1kg)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_43215079_1653975274.jpeg', 102, 0, 86.66, 91.86, 15, '128', '1 KG', 'Buy 15 Piece Get 1 free', 'Chennai', 'T.Power Powder', 'Power Soap', 'India', '1'),
(29, '2022-05-30 16:44:24', '70517400', '86482563', '34011920', 'HI POWER POWDER', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_24433252_1655535204.jpeg', 390, 0, 331.66, 351.56, 6, '129', '3 KG', '', 'Chennai', 'Hi Power Powder', 'Power Soap', 'India', '1'),
(30, '2022-05-30 16:44:24', '70517400', '30495683', '34011920', 'ACTIVE POWER POWDER(500g)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_34621651_1655535429.jpeg', 1, 0, 1, 1.06, 30, '130', '500 g', 'Buy 30 piece get 2 free', 'Chennai', 'Active Power Powder', 'Power Soap', 'India', '1'),
(31, '2022-05-30 16:44:24', '70517400', '80591243', '34011920', 'ACTIVE POWER POWDER (1kg)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_18502030_1655535273.jpeg', 1, 0, 1, 1.06, 15, '131', '1 KG', 'Buy 15 Piece Get 1 free', 'Chennai', 'Active Power Powder', 'Power Soap', 'India', '1'),
(32, '2022-05-30 16:44:24', '47758351', '81587809', '34022010', 'ULTIMATE POWER DETERGENT LIQUID 50ml', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_71152616_1653974644.jpeg', 10, 0, 8.5, 9.01, 96, '132', '50ml', '', 'Chennai', 'Ultimate Power Detergent Liquid 50Ml', 'Power Soap', 'India', '1'),
(33, '2022-05-30 16:44:24', '47758351', '54437555', '34022010', 'ULTIMATE POWER DETERGENT LIQUID 120 ml', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_48290193_1655534682.jpeg', 20, 0, 18, 19.08, 60, '133', '120 ml', '', 'Chennai', 'Ultimate Power Detergent Liquid 120 Ml', 'Power Soap', 'India', '1'),
(34, '2022-05-30 16:44:24', '47758351', '84677818', '34022010', 'ULTIMATE POWER DETERGENT LIQUID 25 ml', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_14999157_1655534878.jpeg', 5, 0, 4.25, 4.51, 192, '134', '25 ml', '', 'Chennai', 'Ultimate Power Detergent Liquid 25 Ml', 'Power Soap', 'India', '1'),
(35, '2022-05-30 16:44:24', '47758351', '10215085', '34022010', 'ULTIMATE POWER DETERGENT LIQUID 500 ml', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_74163486_1653974843.jpeg', 105, 0, 89.16, 94.51, 12, '135', '500 ml', '', 'Chennai', 'Ultimate Power Detergent Liquid 500 Ml', 'Power Soap', 'India', '1'),
(36, '2022-05-30 16:44:24', '47758351', '93259628', '34029059', 'NATURE POWER HAND WASH 500 ML', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_93721397_1655534977.jpeg', 120, 0, 95.83, 101.58, 12, '136', '500 ml', '', 'Chennai', 'Nature Power Hand Wash 500 Ml', 'Power Soap', 'India', '1'),
(37, '2022-05-30 16:44:24', '47758351', '13190074', '34029059', 'NATURE POWER HAND WASH 250 ML', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_49710322_1655534796.jpeg', 70, 0, 55.56, 58.89, 18, '137', '250 ml', '', 'Chennai', 'Nature Power Hand Wash 250 Ml', 'Power Soap', 'India', '1'),
(38, '2022-05-30 16:44:24', '51772467', '61948416', '34022020', 'ULTIMATE POWER FABRIC CONDITIONER - RAIN FRESH', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_73416418_1655534611.jpeg', 3, 0, 2.54, 2.69, 288, '138', '18 ml', '', 'Chennai', 'Ultimate Power Fabric Conditioner - Rain Fresh', 'Power Soap', 'India', '1'),
(39, '2022-05-30 16:44:24', '51772467', '30943430', '34022020', 'ULTIMATE POWER FABRIC CONDITIONER - LILLY', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_66163866_1655534572.jpeg', 3, 0, 2.54, 2.69, 288, '139', '18 ml', '', 'Chennai', 'Ultimate Power Fabric Conditioner - Lilly', 'Power Soap', 'India', '1'),
(40, '2022-05-30 16:44:24', '51772467', '42195500', '34022020', 'ULTIMATE POWER FABRIC CONDITIONER - BLACK', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_30962010_1655534538.jpeg', 3, 0, 2.54, 2.69, 288, '140', '18 ml', '', 'Chennai', 'Ultimate Power Fabric Conditioner - Black', 'Power Soap', 'India', '1'),
(41, '2022-05-30 16:44:24', '51772467', '85832080', '34022020', 'ULTIMATE POWER FABRIC CONDITIONER - RAIN FRESH', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_66383383_1655534382.jpeg', 110, 0, 93.5, 99.11, 12, '141', '430 ml', '', 'Chennai', 'Ultimate Power Fabric Conditioner - Rain Fresh', 'Power Soap', 'India', '1'),
(42, '2022-05-30 16:44:24', '51772467', '34370453', '34022020', 'ULTIMATE POWER FABRIC CONDITIONER - RAIN FRESH', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_25806679_1653975017.jpeg', 20, 0, 17, 18.02, 60, '142', '120 ml', '', 'Chennai', 'Ultimate Power Fabric Conditioner - Rain Fresh', 'Power Soap', 'India', '1'),
(43, '2022-05-30 16:44:24', '51772467', '30505754', '34022020', 'ULTIMATE POWER FABRIC CONDITIONER - LILLY (120 ml)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_91895035_1655534228.jpeg', 20, 0, 17, 18.02, 60, '143', '120 ml', '', 'Chennai', 'Ultimate Power Fabric Conditioner - Lilly', 'Power Soap', 'India', '1'),
(44, '2022-05-30 16:44:24', '79043432', '87032632', '34011190', 'N.POWER BEAUTY - LIME (125g)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_88689871_1655534079.jpeg', 40, 0, 34, 36.04, 60, '144', '125 g', '', 'Chennai', 'N.Power Beauty - Lime', 'Power Soap', 'India', '1'),
(45, '2022-05-30 16:44:24', '79043432', '30769789', '34011190', 'N.POWER BEAUTY - ROSE(125g)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_80681174_1653975388.jpeg', 40, 0, 34, 36.04, 60, '145', '125 g', '', 'Chennai', 'N.Power Beauty - Rose', 'Power Soap', 'India', '1'),
(46, '2022-05-30 16:44:24', '79043432', '89649336', '34011190', 'N.POWER BEAUTY - SANDAL(150g)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_19734663_1655533757.jpeg', 1, 0, 1, 1.06, 60, '146', '150 g', '', 'Chennai', 'N.Power Beauty - Sandal', 'Power Soap', 'India', '1'),
(47, '2022-05-30 16:44:24', '79043432', '89870559', '34011190', 'N.POWER BEAUTY - LAVENDER(125g)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_98028651_1653975418.jpeg', 40, 0, 34, 36.04, 60, '147', '125 g', '', 'Chennai', 'N.Power Beauty - Lavender', 'Power Soap', 'India', '1'),
(48, '2022-05-30 16:44:24', '80587639', '48712254', '34011190', 'N.POWER BEAUTY - HERBAL(125g)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_29694550_1653975480.jpeg', 40, 0, 34, 36.04, 60, '148', '125 g', '', 'Chennai', 'N.Power Beauty - Herbal', 'Power Soap', 'India', '1'),
(49, '2022-05-30 16:44:24', '79043432', '35499577', '34011190', 'NATURE POWER BEAUTY GLYCERINE - HONEY', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_41765338_1653975521.jpeg', 45, 0, 38.25, 40.55, 60, '149', '125 g', '', 'Chennai', 'Nature Power Beauty Glycerine - Honey', 'Power Soap', 'India', '1'),
(50, '2022-05-30 16:44:24', '79043432', '83243693', '34011190', 'NATURE POWER BEAUTY GLYCERINE - TULASI', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_32585791_1653975553.jpeg', 45, 0, 38.25, 40.55, 60, '150', '125 g', '', 'Chennai', 'Nature Power Beauty Glycerine - Tulasi', 'Power Soap', 'India', '1'),
(51, '2022-05-30 16:44:24', '80587639', '86482687', '34011190', 'NATURE POWER PAPAYA', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_54866741_1653975450.jpeg', 45, 0, 38.25, 40.55, 60, '151', '125 g', 'Buy 10 Box and Get 5% off On Next Order', 'Chennai', 'Nature Power Papaya', 'Power Soap', 'India', '1'),
(52, '2022-05-30 16:44:24', '80587639', '56874436', '34011190', 'NATURE POWER - LIME (100g)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_20588542_1653974538.jpeg', 36, 0, 30.6, 32.44, 60, '152', '100 g', '', 'Chennai', 'Nature Power - Lime', 'Power Soap', 'India', '1'),
(53, '2022-05-30 16:44:24', '80587639', '37729988', '34011190', 'NATURE POWER - ROSE(100g)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_20880693_1655533214.jpeg', 36, 0, 30.6, 32.44, 60, '153', '100 g', '', 'Chennai', 'Nature Power - Rose', 'Power Soap', 'India', '1'),
(54, '2022-05-30 16:44:24', '80587639', '94173935', '34011190', 'NATURE POWER - SANDAL(100g)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_17785962_1655533143.jpeg', 36, 0, 30.6, 32.44, 60, '154', '100 g', '', 'Chennai', 'Nature Power - Sandal', 'Power Soap', 'India', '1'),
(55, '2022-05-30 16:44:24', '80587639', '20973308', '34011190', 'NATURE POWER LEAF SOAP (30g)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_95475167_1655533428.jpeg', 5, 0, 4.25, 4.51, 144, '155', '30 g', '', 'Chennai', 'Nature Power Leaf Soap', 'Power Soap', 'India', '1'),
(56, '2022-05-30 16:44:24', '80587639', '70797820', '34011190', 'N.POWER BEAUTY - SANDAL(50g)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_22264471_1655533085.jpeg', 10, 0, 8.5, 9.01, 144, '156', '50 g', '', 'Chennai', 'N.Power Beauty - Sandal', 'Power Soap', 'India', '1'),
(57, '2022-05-30 16:44:24', '80587639', '59753035', '34011190', 'N.POWER BEAUTY - LAVENDER(50g)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_18089661_1655532989.jpeg', 10, 0, 8.5, 9.01, 144, '157', '50 g', 'Buy 10 Box and Get 2% off On Next Order', 'Chennai', 'N.Power Beauty - Lavender', 'Power Soap', 'India', '1'),
(58, '2022-05-30 16:44:24', '80587639', '63545308', '34011190', 'N.POWER BEAUTY - LIME (50g)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_02157105_1653919952.jpeg', 10, 0, 8.5, 9.01, 144, '158', '50 g', '', 'Chennai', 'N.Power Beauty - Lime', 'Power Soap', 'India', '1'),
(59, '2022-05-30 16:44:24', '79043432', '65342648', '34011190', 'N.POWER BEAUTY SOAP - SANDAL (125g)', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_72083011_1655532885.jpeg', 40, 0, 34, 36.04, 60, '159', '125 g', '', 'Chennai', 'N.Power Beauty Soap - Sandal', 'Power Soap', 'India', '1'),
(60, '2022-05-30 16:44:24', '80587639', '31354291', '34011190', 'N.POWER BEAUTY SOAP - TURMERIC', 'https://d8yt9z8a0r4xc.cloudfront.net/userImage/IMG_77630250_1653926339.jpeg', 25, 0, 16.25, 17.23, 60, '160', '150 g', 'Buy 1 sack get 1 free', 'Chennai', 'N.Power Beauty Soap - Turmeric', 'Power Soap', 'India', '1');

-- --------------------------------------------------------

--
-- Table structure for table `products__category`
--

CREATE TABLE `products__category` (
  `id` int(11) NOT NULL,
  `date_time` datetime DEFAULT NULL,
  `token` char(10) NOT NULL COMMENT 'division_token',
  `name` varchar(100) DEFAULT NULL COMMENT 'division',
  `delete_status` enum('1','2') NOT NULL DEFAULT '1' COMMENT '1-active,2-deleted'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products__category`
--

INSERT INTO `products__category` (`id`, `date_time`, `token`, `name`, `delete_status`) VALUES
(1, '2022-04-04 23:44:22', '79043432', 'Beauty soap (125g)', '1'),
(2, '2022-04-03 23:44:22', '46668737', ' Power Detergent cake(Washing Soaps)', '1'),
(3, '2022-04-04 23:46:00', '15246751', 'Power Ultimate Detergent Cake', '1'),
(5, '2022-04-05 23:59:38', '19727821', 'GIO Dish Wash Bar', '1'),
(6, '2022-04-03 00:02:03', '70517400', 'Power Detergent Powder', '1'),
(7, '2022-04-03 00:02:03', '47758351', 'Ultimate Power Detergent Liquid', '1'),
(8, '2022-03-07 00:03:34', '80587639', 'Beauty soap Papaya', '1'),
(9, '2022-07-08 12:57:52', '38017591', 'Power Jumbo Detergent Cake', '1'),
(10, '2022-07-08 13:32:57', '51772467', 'Ultimate Power Fabric Conditioner', '1');

-- --------------------------------------------------------

--
-- Table structure for table `sales__log`
--

CREATE TABLE `sales__log` (
  `id` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  `distributor_token` char(10) NOT NULL,
  `sales_token` char(10) NOT NULL,
  `department` enum('Sale','Delivery') NOT NULL,
  `shop_token` char(10) NOT NULL,
  `status` enum('Completed','Pending','Cancelled') NOT NULL COMMENT '''Completed'',''Pending'',''Cancelled''',
  `reason` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shop`
--

CREATE TABLE `shop` (
  `id` int(11) NOT NULL,
  `token` char(10) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `date_time` datetime NOT NULL,
  `unit_token` char(10) DEFAULT NULL,
  `retail_code` varchar(40) DEFAULT NULL,
  `shop_type_code` char(10) DEFAULT NULL,
  `slot` varchar(15) NOT NULL,
  `distributor_token` char(10) NOT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `contact_person` varchar(30) DEFAULT NULL,
  `join_date` datetime DEFAULT NULL,
  `license_number` varchar(20) DEFAULT NULL,
  `license_image` text NOT NULL,
  `delete_status` enum('1','2') NOT NULL COMMENT '1-active,2-deleted',
  `shop_show_status` enum('Active','Inactive') NOT NULL,
  `address` varchar(200) NOT NULL,
  `city` varchar(30) NOT NULL,
  `pincode` int(15) NOT NULL,
  `coordinates` varchar(55) NOT NULL,
  `created_by` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shop`
--

INSERT INTO `shop` (`id`, `token`, `name`, `date_time`, `unit_token`, `retail_code`, `shop_type_code`, `slot`, `distributor_token`, `mobile_number`, `contact_person`, `join_date`, `license_number`, `license_image`, `delete_status`, `shop_show_status`, `address`, `city`, `pincode`, `coordinates`, `created_by`) VALUES
(11, '85217983', 'Raja Store', '2022-06-24 18:33:25', '19453158', '23693289', '80189244', '0%', '30695824', '9445631359', '', '2022-06-24 18:33:25', '', '', '1', 'Active', 'No 142, First main Road,Thirumalai Priya nagar,Pudhur, Ambathur', 'Chennai', 600053, '', ''),
(12, '98446022', 'Vinayaga Store', '2022-06-24 18:39:05', '19453158', '79158038', '80189244', '0%', '30695824', '7550138133', '', '2022-06-24 18:39:05', '', '', '1', 'Active', 'No:46,Kamachee Flats,Thirumalai Priya Nagar Main Road, Pudhur, Ambattur', 'Chennai', 600053, '', ''),
(13, '53432024', 'Parvathy Store', '2022-06-24 18:40:29', '19453158', '26680265', '80189244', '0%', '30695824', '9962129117', '', '2022-06-24 18:40:29', '', '', '1', 'Active', 'No 23 Sowkar Street Elango Nagar, Ambattur Menambedu', 'Chennai', 600053, '', ''),
(14, '47623008', 'KUMARAN STORE', '2022-06-24 18:42:22', '19453158', '11667623', '80189244', '0%', '30695824', '9940302180', '', '2022-06-24 18:42:22', '', '', '1', 'Active', 'No 15, K.V.K. Swamy Street,Chithu, Oragadam, Menambedu, Ambattur', 'Chennai', 600053, '', ''),
(15, '17729211', 'Kanagaraj', '2022-06-24 18:44:16', '19453158', '91536034', '80189244', '0%', '30695824', '9176199064', 'Kanagaraj', '2022-06-24 18:44:16', '', '', '1', 'Active', 'No 3/1 ,Muthu Mariamman Koil Street, Menambedu, Ambattur', 'Chennai', 600053, '', ''),
(16, '64436597', 'Kavitha Store', '2022-06-24 18:44:51', '19453158', '97706459', '80189244', '0%', '30695824', '8939681155', '', '2022-06-24 18:44:51', '', '', '1', 'Active', 'No : 2/33 Red hils Road, Sanmugapuram, Surappattu. ', 'Chennai', 600053, '', ''),
(17, '24974338', 'Seenivasa Store', '2022-06-24 18:47:07', '19453158', '71361318', '80189244', '0%', '30695824', '9940050377', '', '2022-06-24 18:47:07', '', '', '1', 'Active', 'No: 19, Pillayar Koil Street, Menambedu, Ambattur', 'Chennai', 600053, '', ''),
(18, '74167040', 'Saravanaa Traders', '2022-06-24 18:48:08', '19453158', '76552006', '80189244', '0%', '30695824', '9940572781', '', '2022-06-24 18:48:08', '', '', '1', 'Active', 'No : 557 North street, Bharathidhasan Nagar, Shanmugapuram.', 'Chennai', 600053, '', ''),
(19, '85164288', 'SKY SUPER MARKET', '2022-06-24 18:50:52', '19453158', '48189844', '80189244', '0%', '30695824', '9941990055', '', '2022-06-24 18:50:52', '', '', '1', 'Active', 'No : 3/56  Mettur Main Road, Surapet, ', 'Chennai', 600066, '', ''),
(20, '65424371', 'S.P.K Store', '2022-06-24 18:53:23', '19453158', '25447619', '80189244', '0%', '30695824', '9042183071', '', '2022-06-24 18:53:23', '', '', '1', 'Active', 'No: 11 Indra Nagar, Main Road,  Menambedu, Ambattur', 'Chennai', 600053, '', ''),
(21, '11597976', 'Karthikeyan Store', '2022-06-24 18:54:27', '19453158', '82377106', '80189244', '0%', '30695824', '1234567890', '', '2022-06-24 18:54:27', '', '', '1', 'Active', 'Rettapilli Main Road, Surappattu', 'Chennai', 600053, '', ''),
(22, '32096322', 'Vasanthi Store', '2022-06-24 18:55:42', '19453158', '82338683', '80189244', '0%', '30695824', '9941197477', '', '2022-06-24 18:55:42', '', '', '1', 'Active', '86, 15A, Pillaiyar Koil St, Indira Nagar, Ambattur,', 'Chennai', 600053, '', ''),
(23, '13707358', 'Balaji Store', '2022-06-24 18:57:13', '19453158', '13868382', '80189244', '0%', '30695824', '1234567800', '', '2022-06-24 18:57:13', '', '', '1', 'Active', 'NO : 10 vinayagapuram Main Road, Vinayagapuram,  Ambathur', 'Chennai', 600053, '', ''),
(24, '66691055', 'Pathakanarayan', '2022-06-24 19:00:28', '19453158', '59011441', '80189244', '0%', '30695824', '9941457534', '', '2022-06-24 19:00:28', '', '', '1', 'Active', 'No:14 , Madurai Veeran, Kosar Street', 'Chennai', 600053, '', ''),
(25, '43414998', 'Srinivasa Store', '2022-06-24 19:00:32', '19453158', '91570557', '80189244', '0%', '30695824', '1234555678', '', '2022-06-24 19:00:32', '', '', '1', 'Active', 'No : 4/5 Rajaji Street, V.Nayagapuram, Ambathur', 'Chennai', 600053, '', ''),
(26, '20340574', 'Ayyanar Store', '2022-06-24 19:02:04', '19453158', '95831986', '80189244', '0%', '30695824', '9941774056', '', '2022-06-24 19:02:04', '', '', '1', 'Active', 'No : 38/1 EVR Street, Vinayagapuram, Ambathur.', 'Chennai', 600053, '', ''),
(27, '41875662', 'RADHA STORE', '2022-06-24 19:03:36', '19453158', '25581123', '80189244', '0%', '30695824', '9884739092', '', '2022-06-24 19:03:36', '', '', '1', 'Active', 'Ambattur', 'Chennai', 600053, '', ''),
(28, '83169132', 'Selvam Ammal', '2022-06-24 19:06:04', '19453158', '53758363', '80189244', '0%', '30695824', '9444788953', '', '2022-06-24 19:06:04', '', '', '1', 'Active', 'No:1 Madam Street, Gangai Nagar, Kallikuppam', 'Chennai', 600053, '', ''),
(29, '23487449', 'New Maharaja Store', '2022-06-24 19:07:10', '19453158', '84132749', '80189244', '0%', '30695824', '9445254757', '', '2022-06-24 19:07:10', '', '', '1', 'Active', 'No 22, Anna Road , Kallikuppam', 'Chennai', 600053, '', ''),
(30, '58485084', 'Mutha Ramman Store', '2022-06-24 19:17:59', '19453158', '66404133', '80189244', '0%', '30695824', '1234567891', '', '2022-06-24 19:17:59', '', '', '1', 'Active', 'No 25M , Rettapalli Main Road, Kallikuppam, Ambattur', 'Chennai', 600053, '', ''),
(31, '14313181', 'SanMana Store', '2022-06-24 19:26:32', '19453158', '42090522', '80189244', '0%', '30695824', '6381210377', '', '2022-06-24 19:26:32', '', '', '1', 'Active', 'No:57, Mannayar Kovil Road , Kallikuppam, Ambattur', 'Chennai', 600053, '', ''),
(32, '37608899', 'Arumugam Store', '2022-06-24 19:27:43', '19453158', '23742227', '80189244', '0%', '30695824', '9884711218', '', '2022-06-24 19:27:43', '', '', '1', 'Active', 'No:21/57 Pillayar Street , KalliKuppam', 'Chennai', 600053, '', ''),
(33, '50579976', 'RAJA STORES', '2022-06-24 19:28:45', '19453158', '65310809', '80189244', '0%', '30695824', '9710499210', '', '2022-06-24 19:28:45', '', '', '1', 'Active', '78, Pasumpon Nagar, Ambattur', 'Chennai', 600053, '', ''),
(34, '38934333', 'Abishek Store', '2022-06-24 19:32:14', '19453158', '72955342', '80189244', '0%', '30695824', '9840381782', '', '2022-06-24 19:32:14', '', '', '1', 'Active', 'No:34 , 6th Street, Pasumpon Nagar, Kallikuppam,', 'Chennai', 600053, '', ''),
(35, '38451984', 'Saraswathi Store', '2022-06-24 19:36:07', '19453158', '83146223', '80189244', '0%', '30695824', '1234567892', '', '2022-06-24 19:36:07', '', '', '1', 'Active', 'No:4, Muruga Mbedu, Kallikuppam,Tamil Nadu', 'Chennai', 600053, '', ''),
(36, '23598003', 'YESU RAJA STORES', '2022-06-24 19:38:18', '19453158', '36679569', '80189244', '0%', '30695824', '9841254383', '', '2022-06-24 19:38:18', '', '', '1', 'Active', '5th Cross St, West Balaji Nagar, Kallikuppam, Ambattur, Tamil Nadu', 'Chennai', 600053, '', ''),
(37, '27406424', 'Ramalakshmi Store', '2022-06-24 19:40:40', '19453158', '64562026', '80189244', '0%', '30695824', '9940504216', '', '2022-06-24 19:40:40', '', '', '1', 'Active', 'No 9c Merku Balaji Road, First main road, Ambattur', 'Chennai', 600053, '', ''),
(38, '17674700', 'G.R Store', '2022-06-24 19:42:54', '19453158', '70151808', '80189244', '0%', '30695824', '9789895805', '', '2022-06-24 19:42:54', '', '', '1', 'Active', 'No:26 Rettapalli Road, Kallikuppam, Ambattur', 'Chennai', 600053, '', ''),
(39, '15291008', 'Kumar Store', '2022-06-24 19:44:40', '19453158', '95747645', '80189244', '0%', '30695824', '9940556967', '', '2022-06-24 19:44:40', '', '', '1', 'Active', 'No: 272 Menambedu, Kilaku Balaji Nagar', 'Chennai', 600053, '', ''),
(40, '16104639', 'KALANJIYAM VMART', '2022-06-24 19:46:43', '19453158', '29851930', '80189244', '0%', '30695824', '7200376433', '', '2022-06-24 19:46:43', '', '', '1', 'Active', 'NO.23/1A, TEA KADAI, Padasalai St, Kallikuppam, ', 'Chennai, Tamil Nadu', 600053, '', ''),
(41, '57174205', 'Palani Store', '2022-06-24 19:51:09', '19453158', '60545761', '80189244', '0%', '30695824', '9551104001', '', '2022-06-24 19:51:09', '', '', '1', 'Active', 'no.13, Thiru Vi Ka St, Vinayagapuram, Ambattur, ', 'Chennai, Tamil Nadu', 600053, '', ''),
(42, '31256438', 'Sri Murugan Stores', '2022-06-24 19:56:59', '19453158', '54881485', '80189244', '0%', '30695824', '9941246568', '', '2022-06-24 19:56:59', '', '', '1', 'Active', 'No.16 B, Indira Gandhi Street, Venkatheshwara Nagar, Ambattur', 'Chennai', 600053, '', ''),
(43, '62386599', 'Roja Store', '2022-06-24 19:56:59', '19453158', '82294137', '80189244', '0%', '30695824', '9790645006', '', '2022-06-24 19:56:59', '', '', '1', 'Active', 'No.1, Thirumalai Amman Street, Venkatheshwara Nagar, Ambattur', 'Chennai', 600053, '', ''),
(44, '64696910', 'Vaigai Store', '2022-06-24 19:56:59', '19453158', '14310202', '80189244', '0%', '30695824', '9950606062', '', '2022-06-24 19:56:59', '', '', '1', 'Active', 'No.B-16, Vairam Street, Venkatheshwara Nagar, Ambattur', 'Chennai', 600053, '', ''),
(45, '48792619', 'Babu Store', '2022-06-24 19:56:59', '19453158', '92144984', '80189244', '0%', '30695824', '8610288475', '', '2022-06-24 19:56:59', '', '', '1', 'Active', 'No.25, Arasu Street, Ram Nagar, Ambattur', 'Chennai', 600053, '', ''),
(46, '30275502', 'Sri Ramajeyam Store', '2022-06-24 19:56:59', '19453158', '12956602', '80189244', '0%', '30695824', '9962292900', '', '2022-06-24 19:56:59', '', '', '1', 'Active', 'No.13, Iind Main Road, Lenin Nagar, Ambattur', 'Chennai', 600053, '', ''),
(47, '60270977', 'Suyambu Store', '2022-06-24 19:56:59', '19453158', '80448559', '80189244', '0%', '30695824', '9080703615', '', '2022-06-24 19:56:59', '', '', '1', 'Active', 'No.5, Gopal swamy Street, Ambattur', 'Chennai', 600053, '', ''),
(48, '17790254', 'New R.K Store', '2022-06-24 19:56:59', '19453158', '27405601', '80189244', '0%', '30695824', '9677149247', '', '2022-06-24 19:56:59', '', '', '1', 'Active', 'No.9, Anna Street, Ram Nagar, Ambattur', 'Chennai', 600053, '', ''),
(49, '74140185', 'Murugan Stores', '2022-06-24 19:56:59', '19453158', '22937964', '80189244', '0%', '30695824', '8220064230', '', '2022-06-24 19:56:59', '', '', '1', 'Active', 'No.4, Lal Bahadur Street, Ram Nagar, Ambattur', 'Chennai', 600053, '', ''),
(58, '65089764', 'Vel Murugan Store', '2022-06-24 20:11:09', '19453158', '62198938', '80189244', '0%', '30695824', '9944049492', '', '2022-06-24 20:11:09', '', '', '1', 'Active', 'No.1, Yerikarai road, Venkatheshwara Nagar, Ambattur', 'Chennai', 600053, '', ''),
(59, '55722437', 'Selvam Stores', '2022-06-24 20:11:09', '19453158', '51491341', '80189244', '0%', '30695824', '9000000000', '', '2022-06-24 20:11:09', '', '', '1', 'Active', 'No.6, Yerikarai road, Venkatheshwara Nagar, Ambattur', 'Chennai', 600053, '', ''),
(60, '17985626', 'Ayan Stores', '2022-06-24 20:11:09', '19453158', '84000582', '80189244', '0%', '30695824', '9962917717', '', '2022-06-24 20:11:09', '', '', '1', 'Active', 'No.35, Yerikarai road, Venkatheshwara Nagar, Ambattur', 'Chennai', 600053, '', ''),
(61, '29366637', 'AB Senthil Store', '2022-06-24 20:11:09', '19453158', '17322098', '80189244', '0%', '30695824', '9094802921', '', '2022-06-24 20:11:09', '', '', '1', 'Active', 'No.1, Church Street, Yerikarai road, Venkatheshwara Nagar, Ambattur', 'Chennai', 600053, '', ''),
(62, '16754514', 'Murugan Stores', '2022-06-27 16:44:01', '28342048', '45198079', '80189244', '0%', '30695824', '9841703730', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.26, IAF Road, Barathiyar Nagar, Pattabiram', 'Chennai', 600072, '', ''),
(63, '92864733', 'M. Saravanan Store', '2022-06-27 16:44:01', '28342048', '58389404', '80189244', '0%', '30695824', '9444329614', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.29, IAF Road, Barathiyar Nagar, Pattabiram', 'Chennai', 600072, '', ''),
(64, '63693225', 'M. Selvarajan Stores', '2022-06-27 16:44:01', '28342048', '74534457', '80189244', '0%', '30695824', '9444737293', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.1, Kalaingar Street, Kakanji Nagar, Pattabiram', 'Chennai', 600072, '', ''),
(65, '58233015', 'Sree Mahalakshmi Store', '2022-06-27 16:44:01', '28342048', '11170143', '80189244', '0%', '30695824', '6383367464', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.60, IAF Road, Kakanji Nagar, Pattabiram', 'Chennai', 600072, '', ''),
(66, '25349038', 'Sri Amma Bagavan Stores', '2022-06-27 16:44:01', '28342048', '14957172', '80189244', '0%', '30695824', '9171194263', 'Sasikumar', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.27, B.O.D Road, Chathiram, Pattabiram', 'Chennai', 600072, '', ''),
(67, '18618435', 'Sekar Stores', '2022-06-27 16:44:01', '28342048', '72922047', '80189244', '0%', '30695824', '9500177038', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.16/20, B.O.D Road, Chathiram, Pattabiram', 'Chennai', 600072, '', ''),
(68, '73487745', 'K.P Samy Store', '2022-06-27 16:44:01', '28342048', '61625646', '80189244', '0%', '30695824', '9444109555', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.5, B.O.D Road, Chathiram, Pattabiram', 'Chennai', 600072, '', ''),
(69, '97562908', 'Anbu Store', '2022-06-27 16:44:01', '28342048', '85728807', '80189244', '0%', '30695824', '9092963739', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.5/6, CTH Road, Pattabiram', 'Chennai', 600072, '', ''),
(70, '72106795', 'Sri Gomathy Stores', '2022-06-27 16:44:01', '28342048', '38630135', '80189244', '0%', '30695824', '9941265180', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.5, M.G Road, Pattabiram', 'Chennai', 600072, '', ''),
(71, '97503076', 'Siva Stores', '2022-06-27 16:44:01', '28342048', '44963285', '80189244', '0%', '30695824', '4426851354', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.2, M.G Road, North Bazaar, Pattabiram', 'Chennai', 600072, '', ''),
(72, '52821058', 'Pattabiram Provision Super Market', '2022-06-27 16:44:01', '28342048', '17141028', '80189244', '0%', '30695824', '9025050059', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.537, CTH Road, Pattabiram', 'Chennai', 600072, '', ''),
(73, '96925672', 'Natarajan Store', '2022-06-27 16:44:01', '28342048', '38579789', '80189244', '0%', '30695824', '9841683675', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.68, South Bazaar, Pattabiram', 'Chennai', 600072, '', ''),
(74, '39964260', 'Jeyaraj Store', '2022-06-27 16:44:01', '28342048', '64346847', '80189244', '0%', '30695824', '', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.74, South Bazaar, Pattabiram', 'Chennai', 600072, '', ''),
(75, '78867282', 'Sri Balaji Store', '2022-06-27 16:44:01', '28342048', '67179952', '80189244', '0%', '30695824', '9940069312', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'NO.72/3, South Bazaar, Pattabiram', 'Chennai', 600072, '', ''),
(76, '24500016', 'Anand Store', '2022-06-27 16:44:01', '28342048', '16530906', '80189244', '0%', '30695824', '9710485973', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'NO.55, South Bazaar, Pattabiram', 'Chennai', 600072, '', ''),
(77, '48130782', 'Taj Maligai Store', '2022-06-27 16:44:01', '28342048', '20956239', '80189244', '0%', '30695824', '', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'NO.54/3, South Bazaar, Pattabiram', 'Chennai', 600072, '', ''),
(78, '87533703', 'Aadhi Bagavathy Stores', '2022-06-27 16:44:01', '28342048', '73191123', '80189244', '0%', '30695824', '4426850252', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'South Bazaar, Pattabiram', 'Chennai', 600072, '', ''),
(79, '63445305', 'Rajan Store', '2022-06-27 16:44:01', '28342048', '97646579', '80189244', '0%', '30695824', '4426851245', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'NO.37, South Bazaar, Pattabiram', 'Chennai', 600072, '', ''),
(80, '99360069', 'Ganapathy Maruthi Store', '2022-06-27 16:44:01', '28342048', '18120607', '80189244', '0%', '30695824', '8155538434', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'NO.51, South Bazaar, Pattabiram', 'Chennai', 600072, '', ''),
(81, '65112456', 'Sanmuga Store', '2022-06-27 16:44:01', '28342048', '60789733', '80189244', '0%', '30695824', '9941058612', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'NO.53, South Bazaar, Pattabiram', 'Chennai', 600072, '', ''),
(82, '12878036', 'New Siva Store', '2022-06-27 16:44:01', '28342048', '95778873', '80189244', '0%', '30695824', '9962342327', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'NO.53/4, South Bazaar, Pattabiram', 'Chennai', 600072, '', ''),
(83, '54927280', 'J.K. Store', '2022-06-27 16:44:01', '28342048', '91793599', '80189244', '0%', '30695824', '', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.627, C.T.H Road, Charles Nagar, Pattabiram', 'Chennai', 600072, '', ''),
(84, '96152089', 'Sri Annamalai Stores', '2022-06-27 16:44:01', '28342048', '79132286', '80189244', '0%', '30695824', '9710792240', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.763, C.T.H Road, Gandhi Nagar, Pattabiram', 'Chennai', 600072, '', ''),
(85, '79740918', 'Om Velmurugan Stores', '2022-06-27 16:44:01', '28342048', '16740931', '80189244', '0%', '30695824', '9500176795', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.744, C.T.H Road, Gandhi Nagar, Pattabiram', 'Chennai', 600072, '', ''),
(86, '31481961', 'P. Raju Provision', '2022-06-27 16:44:01', '28342048', '10011119', '80189244', '0%', '30695824', '9094697585', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.2, Babu Nagar, C.T.H Road, Pattabiram', 'Chennai', 600072, '', ''),
(87, '49247606', 'Ravi Store', '2022-06-27 16:44:01', '28342048', '80144519', '80189244', '0%', '30695824', '7448898855', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.153, 6th Street, Uzhaipaalar Nagar, Pattabiram', 'Chennai', 600072, '', ''),
(88, '21584795', 'Srinivasa Store', '2022-06-27 16:44:01', '28342048', '13696733', '80189244', '0%', '30695824', '7708330780', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.2, 7th Street, Uzhaipaalar Nagar, Pattabiram', 'Chennai', 600072, '', ''),
(89, '56949569', 'Nathamuni Shopee', '2022-06-27 16:44:01', '28342048', '20776256', '80189244', '0%', '30695824', '9884742688', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.23, N.M. Nagar, Muthapudupet, Avadi', 'Chennai', 600055, '', ''),
(90, '50427642', 'Om Muruga Stores', '2022-06-27 16:44:01', '28342048', '73628771', '80189244', '0%', '30695824', '', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.6/3, Bazar Street, Muthapudupet, Avadi', 'Chennai', 600055, '', ''),
(91, '21186670', 'Yamuna Stores', '2022-06-27 16:44:01', '28342048', '36036308', '80189244', '0%', '30695824', '', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.13, MES Road, IAF Avadi, Muthapudupet', 'Chennai', 600055, '', ''),
(92, '28949917', 'New Pandi Stores', '2022-06-27 16:44:01', '28342048', '66912872', '80189244', '0%', '30695824', '', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.6, MES Road, IAF Avadi, Muthapudupet', 'Chennai', 600055, '', ''),
(93, '26331108', 'Mary Stores', '2022-06-27 16:44:01', '28342048', '13801875', '80189244', '0%', '30695824', '9094996243', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.88, Palavedu Road, Theepanchiamman Nagar,Mittanmalli', 'Chennai', 600055, '', ''),
(94, '14272272', 'Sri Balaji Sweets and Super Market', '2022-06-27 16:44:01', '28342048', '52996852', '80189244', '0%', '30695824', '', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.10, Palavedu Road, Mittanmalli, IAF Avadi', 'Chennai', 600055, '', ''),
(95, '16672279', 'Sekar Stores', '2022-06-27 16:44:01', '28342048', '30759617', '80189244', '0%', '30695824', '', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.5, Palavedu Main Road, Mittanmalli, Avadi', 'Chennai', 600055, '', ''),
(96, '22845757', 'P. Raj Stores', '2022-06-27 16:44:01', '28342048', '21231032', '80189244', '0%', '30695824', '', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.2, Palavedu Main Road, Mittanmalli, Avadi', 'Chennai', 600055, '', ''),
(97, '85854403', 'Anantha Stores', '2022-06-27 16:44:01', '28342048', '27847689', '80189244', '0%', '30695824', '8110066219', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.84, Sri Ram Samaj Nagar, Veerapuram Main Road, Vellaanoor', 'Chennai', 600062, '', ''),
(98, '26038469', 'Vetri Vinayagar Store', '2022-06-27 16:44:01', '28342048', '37971349', '80189244', '0%', '30695824', '', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.83 C, Sri Ram Samaj Nagar, Vellaanoor, Avadi', 'Chennai', 600062, '', ''),
(99, '20609931', 'Jafo\'s Family Mart', '2022-06-27 16:44:01', '28342048', '54110293', '80189244', '0%', '30695824', '9597264671', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.7, Ragavendra Nagar, Morai Anna Nagar, Avadi', 'Chennai', 600065, '', ''),
(100, '31169363', 'Thirupathi Store', '2022-06-27 16:44:01', '28342048', '44890369', '80189244', '0%', '30695824', '9500088851', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.83, Veerapuram Main Road, Vishnu Nagar', 'Chennai', 600062, '', ''),
(101, '88269255', 'SMP Namma Kadai', '2022-06-27 16:44:01', '28342048', '41478045', '80189244', '0%', '30695824', '9840238260', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.12, Perumal Kovil Street, Avadi-Redhills Main Road, Vellaanoor', 'Chennai', 600062, '', ''),
(102, '74937978', 'The Village Super Market', '2022-06-27 16:44:01', '28342048', '37019992', '80189244', '0%', '30695824', '', '', '2022-06-27 16:44:01', '33CWDP94008K2ZO', '', '1', 'Active', 'No.836, Perumal Kovil Street, Avadi-Redhills Main Road, Kollumedu', 'Chennai', 600062, '', ''),
(103, '26752024', 'Ayyanar Store', '2022-06-27 16:44:01', '28342048', '66574951', '80189244', '0%', '30695824', '', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.812, Perumal Kovil Street, Avadi-Redhills Main Road, Kollumedu', 'Chennai', 600062, '', ''),
(104, '94323609', 'Baby Annamalai', '2022-06-27 16:44:01', '28342048', '12529013', '80189244', '0%', '30695824', '9092801935', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.2, Main Road, Kannadapalayam, Avadi', 'Chennai', 600062, '', ''),
(105, '28856519', 'Sri Murugan Store', '2022-06-27 16:44:01', '28342048', '54640725', '80189244', '0%', '30695824', '9710150077', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.179, Kovilpathagai Main Road, Avadi', 'Chennai', 600062, '', ''),
(106, '46751761', 'Sri Velavan Store', '2022-06-27 16:44:01', '28342048', '35849088', '80189244', '0%', '30695824', '9444106793', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.12, Main Road, Kovilpathagai, Avadi', 'Chennai', 600062, '', ''),
(107, '55643273', 'Deepa Store', '2022-06-27 16:44:01', '28342048', '47216797', '80189244', '0%', '30695824', '9710499504', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.116, Kovilpathagai Main Road, Avadi', 'Chennai', 600062, '', ''),
(108, '81114642', 'Rehoboth Super Market', '2022-06-27 16:44:01', '28342048', '58803589', '80189244', '0%', '30695824', '', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.67, Kovilpathagai Main Road, Avadi', 'Chennai', 600062, '', ''),
(109, '92761844', 'Chennai Super Market', '2022-06-27 16:44:01', '28342048', '27345886', '80189244', '0%', '30695824', '9962568565', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.1, Kovilpathagai Main Road, Avadi', 'Chennai', 600062, '', ''),
(110, '63938726', 'St. Joseph Store', '2022-06-27 16:44:01', '28342048', '90510906', '80189244', '0%', '30695824', '9941234612', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'Kovilpathagai Main Road, Avadi', 'Chennai', 600062, '', ''),
(111, '66443944', 'Devi Store', '2022-06-27 16:44:01', '28342048', '44105851', '80189244', '0%', '30695824', '', '', '2022-06-27 16:44:01', '', '', '1', 'Active', 'No.8, Kalaignar Nagar Main Road, Kovilpathagai, Avadi', 'Chennai', 600062, '', ''),
(112, '94011537', 'DORAA SUPER STORES', '2022-06-30 12:42:34', '57495244', '37730574', '80189244', '0%', '30695824', '9841402430', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No. 18, 1st Main Road, Thiruvengada Nagar, Ambattur', 'Chennai', 600053, '', ''),
(113, '15057219', 'SEENIVASAN STORES', '2022-06-30 12:42:34', '57495244', '58957023', '80189244', '0%', '30695824', '8754556825', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'C-114 , West End Road, Thiruvengada Nagar, Ambattur', 'Chennai', 600053, '', ''),
(114, '25891801', 'SELVAM STORES', '2022-06-30 12:42:34', '57495244', '44069558', '80189244', '0%', '30695824', '6382336929', '', '2022-06-30 12:42:34', '', '', '1', 'Active', '', 'Chennai', 600053, '', ''),
(115, '94810320', 'EVEREST STORES', '2022-06-30 12:42:34', '57495244', '93551961', '80189244', '0%', '30695824', '9176543747', '', '2022-06-30 12:42:34', '', '', '1', 'Active', '10/46, Cholambedu Rd, Tiruvenkadam Nagar, Cholapuram, Ambattur,', 'Chennai', 600053, '', ''),
(116, '63575025', 'M.K.M STORES PROVISION & FANCY', '2022-06-30 12:42:34', '57495244', '60606204', '80189244', '0%', '30695824', '9080096434', 'S. MOHAMMED KASIM', '2022-06-30 12:42:34', '', '', '1', 'Active', '35, Vasuki Street, Cholapuram, Ambattur', 'Chennai', 600053, '', ''),
(117, '95209771', 'SERMAN STORES', '2022-06-30 12:42:34', '57495244', '55896039', '80189244', '0%', '30695824', '9962865971', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No.2C Nainiammal Street, Krishnapuram, Ambattur', 'Chennai', 600053, '', ''),
(118, '90236754', 'SIVASAKTHI STORES', '2022-06-30 12:42:34', '57495244', '30244273', '80189244', '0%', '30695824', '7338985871', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No. 1, Suryaprakasam Street, Krishnapuram, Ambattur', 'Chennai', 600053, '', ''),
(119, '98219770', 'Jothi Murugan', '2022-06-30 12:42:34', '57495244', '30718354', '80189244', '0%', '30695824', '7299801944', '', '2022-06-30 12:42:34', '', '', '1', 'Active', '70/B SaiKpa Rukmani Street, Krishnapuram', 'Chennai', 600053, '', ''),
(120, '36857067', 'Sri Ganapathi Store', '2022-06-30 12:42:34', '57495244', '67502720', '80189244', '0%', '30695824', '9677285293', '', '2022-06-30 12:42:34', '', '', '1', 'Active', '17, Frortune City Apartment, Hospital road, Cholapuram, Ambattur', 'Chennai', 600053, '', ''),
(121, '71696496', 'Sun Store', '2022-06-30 12:42:34', '57495244', '80583502', '80189244', '0%', '30695824', '9840081091', '', '2022-06-30 12:42:34', '', '', '1', 'Active', '23/18, Kovintharaj, Cholapuram,Ambattur', 'Chennai', 600053, '', ''),
(122, '46558363', 'VELAN STORE', '2022-06-30 12:42:34', '57495244', '90175040', '80189244', '0%', '30695824', '9025640170', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No:11, Hospital Road, Cholapuram, Ambattur', 'Chennai', 600053, '', ''),
(123, '19340183', 'Elumalai Stores', '2022-06-30 12:42:34', '57495244', '73023764', '80189244', '0%', '30695824', '9941268527', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'Cholapuram', 'Chennai', 600053, '', ''),
(124, '52785870', 'Muruganantham', '2022-06-30 12:42:34', '57495244', '80532174', '80189244', '0%', '30695824', '9952098890', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No 166 Cholapuram, Main Road', 'Chennai', 600053, '', ''),
(125, '50994074', 'Lakshmi Store', '2022-06-30 12:42:34', '57495244', '73516211', '80189244', '0%', '30695824', '9444678537', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No.189 Cholapuram', 'Chennai', 600053, '', ''),
(126, '22303143', 'Sri Raja Shakthi Departmental', '2022-06-30 12:42:34', '57495244', '37327044', '80189244', '0%', '30695824', '9962197623', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'Cholapuram', 'Chennai', 600053, '', ''),
(127, '55580745', 'New Saravana Stores', '2022-06-30 12:42:34', '57495244', '77380641', '80189244', '0%', '30695824', '9600172815', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No. 36, Cholabedu Road, kanapathi Nagar', 'Chennai', 600053, '', ''),
(128, '32020635', 'PANDIYAN STORES', '2022-06-30 12:42:34', '57495244', '73379989', '80189244', '0%', '30695824', '8939645350', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No. 167, Cozhzmbedu Maain Road, Thirumullaivoyal ', 'Chennai', 600062, '', ''),
(129, '13595180', 'Immanuvel Stores', '2022-06-30 12:42:34', '57495244', '10179227', '80189244', '0%', '30695824', '9940059763', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No.164, Cozhzmbedu Road, Thirumullaivoyal', 'Chennai', 600062, '', ''),
(130, '81557140', 'Vinayaga STORE', '2022-06-30 12:42:34', '57495244', '51779245', '80189244', '0%', '30695824', '8790722131', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'Sri Nagar Colony', 'Chennai', 600062, '', ''),
(131, '69030936', 'New SRI RAJASAKTHI Store', '2022-06-30 12:42:34', '57495244', '90835914', '80189244', '0%', '30695824', '8608350623', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No. 23, Murugan Koil Avenue , Sri Naga Colony', 'Chennai', 600062, '', ''),
(132, '87883866', 'Sri Saravana Stores', '2022-06-30 12:42:34', '57495244', '28043257', '80189244', '0%', '30695824', '9940636373', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No. 521/2A , Brindhavan Avalui, Thirumullaivayol', 'Chennai', 600062, '', ''),
(133, '70487617', 'OM SAKTHI STORE', '2022-06-30 12:42:34', '57495244', '17712667', '80189244', '0%', '30695824', '908796469', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No.22, Brinshavan Avanue, Sri Nagar Colony, Thirumullaivoyal, Railway Station Road', 'Chennai', 600062, '', ''),
(134, '43877496', 'Jaya Lakshmi', '2022-06-30 12:42:34', '57495244', '55877770', '80189244', '0%', '30695824', '9840163327', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No- 24, Main Road, Jayalakhsmi Nagar', 'Chennai', 600062, '', ''),
(135, '69135679', 'Siva\'s Store', '2022-06-30 12:42:34', '57495244', '34077758', '80189244', '0%', '30695824', '9751131389', '', '2022-06-30 12:42:34', '', '', '1', 'Active', '2 A, Jayalaksmi Nagar', 'Chennai', 600062, '', ''),
(136, '13330030', 'SLSS SUPER MARKET', '2022-06-30 12:42:34', '57495244', '91456666', '80189244', '0%', '30695824', '9840239470', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No. 3 Thiruvalluvar Street, Thirumullaivayil, Senthil Nagar,', 'Chennai', 600062, '', ''),
(137, '62369409', 'S. S Brothers Stores', '2022-06-30 12:42:34', '57495244', '80214124', '80189244', '0%', '30695824', '8695351145', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No. 94 Senthil Nagar, Thirumullaivayil', 'Chennai', 600062, '', ''),
(138, '73964223', 'Ayappa Store', '2022-06-30 12:42:34', '57495244', '19295578', '80189244', '0%', '30695824', '9566112302', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'Barathi Nagar, Cozhzmbedu Road, Thirumullaivayil', 'Chennai', 600062, '', ''),
(139, '51205186', 'Sri Kamatchi', '2022-06-30 12:42:34', '57495244', '59653972', '80189244', '0%', '30695824', '9940343440', '', '2022-06-30 12:42:34', '', '', '1', 'Active', '16/11 Naji Nagar, First main Road, Thirumullaivayil', 'Chennai', 600062, '', ''),
(140, '94539250', 'Jeni Stores', '2022-06-30 12:42:34', '57495244', '35470099', '80189244', '0%', '30695824', '9840676251', '', '2022-06-30 12:42:34', '', '', '1', 'Active', '48/62, Chozmbedu Road, Thirumullaivayil', 'Chennai', 600062, '', ''),
(141, '34855411', 'Annai Velankanni Maligai Store', '2022-06-30 12:42:34', '57495244', '27557416', '80189244', '0%', '30695824', '9080524862', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No: 25, Cholambedu Road, Thirumullaivoyal, ', 'Chennai', 600062, '', ''),
(142, '48723565', 'Sri Kamatchi Stores', '2022-06-30 12:42:34', '57495244', '64600513', '80189244', '0%', '30695824', '9600050050', '', '2022-06-30 12:42:34', '', '', '1', 'Active', '44, CTH Road, Ambedkar Nagar,Thirumullaivayil', 'Chennai', 600062, '', ''),
(143, '71301557', 'P.K JAMES STORE', '2022-06-30 12:42:34', '57495244', '66858989', '80189244', '0%', '30695824', '8754506883', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No.24, Thendral Nagar main Road, Dr. Ambedkar Nagar, Thirumullaivoyal, ', 'Chennai', 600062, '', ''),
(144, '42367987', 'Annai Stores', '2022-06-30 12:42:34', '57495244', '83710181', '80189244', '0%', '30695824', '7299803442', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'Thendral Nagar', 'Chennai', 600062, '', ''),
(145, '74696803', 'MONNI SUPER BAZAR', '2022-06-30 12:42:34', '57495244', '31119043', '80189244', '0%', '30695824', '9384654295', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'NO. 1, CTH ROAD, Manikandapuram, Thirumullaivoyal', 'Chennai', 600062, '', ''),
(146, '96949997', 'Thangam Store', '2022-06-30 12:42:34', '57495244', '73251701', '80189244', '0%', '30695824', '9444763213', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'NO. 49 M.T.H Road, K.K. Nagar, Thirumullaivoyil', 'Chennai', 600062, '', ''),
(147, '74521882', 'Vivasayi PazhamudhirNilayam', '2022-06-30 12:42:34', '57495244', '78667693', '80189244', '0%', '30695824', '9840043130', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No: 47 C.T.H Road , Thirumullaivoyil', 'Chennai', 600062, '', ''),
(148, '41727391', 'SP.Kani Stores', '2022-06-30 12:42:34', '57495244', '67865314', '80189244', '0%', '30695824', '9841363388', '', '2022-06-30 12:42:34', '', '', '1', 'Active', '6/17 Shikuishnu Appartment, Thirumullaivoyil', 'Chennai', 600062, '', ''),
(149, '67906954', 'Selvam Stores', '2022-06-30 12:42:34', '57495244', '34665128', '80189244', '0%', '30695824', '9551396899', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No. 33/144, Saraswati Nagar, Main road. Thirumullaivoyil', 'Chennai', 600062, '', ''),
(150, '10595362', 'Ayya Store', '2022-06-30 12:42:34', '57495244', '81185037', '80189244', '0%', '30695824', '9176302335', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No, 34/143, Saraswati Nagar, Main road. Thirumullaivoyil', 'Chennai', 600062, '', ''),
(151, '45746013', 'Sri Lingam Stores', '2022-06-30 12:42:34', '57495244', '82199825', '80189244', '0%', '30695824', '9940214403', '', '2022-06-30 12:42:34', '', '', '1', 'Active', '265, Saraswathi Nagar Main Road, Thirumullaivoyil', 'Chennai', 600062, '', ''),
(152, '47258997', 'SIVASAKTHI MINI MART', '2022-06-30 12:42:34', '57495244', '40762985', '80189244', '0%', '30695824', '1111122222', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No. 536, Saraswathi Nagar Main Road, Thirumullaivoyal,  ', 'Chennai', 600062, '', ''),
(153, '73296625', 'SRI AMMAN RICE TRADERS', '2022-06-30 12:42:34', '57495244', '33845465', '80189244', '0%', '30695824', '9840818498', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No. 442, Saraswathi Nagar Main Road, Thirumullaivoyal', 'Chennai', 600062, '', ''),
(154, '17807379', 'Dhas Store', '2022-06-30 12:42:34', '57495244', '95144395', '80189244', '0%', '30695824', '9941483539', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No. 44, Thendral Nagar Kilaku , Thirumullaivoyal', 'Chennai', 600062, '', ''),
(155, '57187043', 'SUN STAR', '2022-06-30 12:42:34', '57495244', '20236976', '80189244', '0%', '30695824', '9791012342', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No: 42, 1st Main Road, Thenral Nagar East, Thirumullaivoyal, Chennai', 'Chennai', 600062, '', ''),
(156, '44599831', 'Selvaraj Store', '2022-06-30 12:42:34', '57495244', '35015288', '80189244', '0%', '30695824', '9962361035', '', '2022-06-30 12:42:34', '', '', '1', 'Active', '', 'Chennai', 600062, '', ''),
(157, '53195001', 'Roja Stores', '2022-06-30 12:42:34', '57495244', '38470996', '80189244', '0%', '30695824', '1111122223', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No. 16, Thiruvallur Street, Thirumullaivoyal Colony, ', 'Chennai', 600062, '', ''),
(158, '20093195', 'Karthikeyan Stores', '2022-06-30 12:42:34', '57495244', '49781449', '80189244', '0%', '30695824', '9940968362', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No. 200, Masiamagaswarar Nagar, Thirumullauvoyal', 'Chennai', 600062, '', ''),
(159, '72860744', 'Kamatchi Amman Stores', '2022-06-30 12:42:34', '57495244', '83957676', '80189244', '0%', '30695824', '7358256781', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No.32, lalithambal Nagar, Thirumullaivoyal,', 'Chennai', 600062, '', ''),
(160, '43396226', 'Thumalai Amman Store', '2022-06-30 12:42:34', '57495244', '67987466', '80189244', '0%', '30695824', '9940346362', '', '2022-06-30 12:42:34', '', '', '1', 'Active', '', 'Chennai', 600062, '', ''),
(161, '82034814', 'Murugan Store', '2022-06-30 12:42:34', '57495244', '16008778', '80189244', '0%', '30695824', '8056225719', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'lalithambal Nagar', 'Chennai', 600062, '', ''),
(162, '19181805', 'Sri Anandh Store', '2022-06-30 12:42:34', '57495244', '73670205', '80189244', '0%', '30695824', '8903427830', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'Thirumullaivoyal', 'Chennai', 600062, '', ''),
(163, '68416455', 'PRAKASH PROVISION STORES', '2022-06-30 12:42:34', '57495244', '22889780', '80189244', '0%', '30695824', '9840609024', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No. 23,West Mada Street, Thirumullaivoyal ', 'Chennai', 600062, '', ''),
(164, '65273438', 'MANI STORE', '2022-06-30 12:42:34', '57495244', '25892692', '80189244', '0%', '30695824', '9940477271', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No. 12, West Mada Street, Thirumullaivoyal', 'Chennai', 600062, '', ''),
(165, '95913565', 'Guru Store', '2022-06-30 12:42:34', '57495244', '92941102', '80189244', '0%', '30695824', '9840368355', '', '2022-06-30 12:42:34', '', '', '1', 'Active', '', 'Chennai', 600062, '', ''),
(166, '63281979', 'Sri Kamatchi Store', '2022-06-30 12:42:34', '57495244', '31871552', '80189244', '0%', '30695824', '9865033412', 'A. Muthuraman', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No. 48, Kulakarai Street,', 'Chennai', 600062, '', ''),
(167, '69349713', 'NEW KAMALA STORE', '2022-06-30 12:42:34', '57495244', '30326367', '80189244', '0%', '30695824', '9283776653', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No. 2. Anna Main Road, Thiruvalluvar Nagar, Thirumullaivoyal, ', 'Chennai', 600062, '', ''),
(168, '59430951', 'KANNAN SUPERMARKET', '2022-06-30 12:42:34', '57495244', '72739419', '80189244', '0%', '30695824', '9176595403', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'NO:36, Anna Main Road, Thiruvalluvar Nagar, Thirumullaivoyal,', 'Chennai', 600062, '', ''),
(169, '21752409', 'SRI LINGAM STORES', '2022-06-30 12:42:34', '57495244', '68731519', '80189244', '0%', '30695824', '9841887899', '', '2022-06-30 12:42:34', '', '', '1', 'Active', 'No. 141-A,C.T.H. Road, Thirumullaivoyal ', 'Chennai', 600062, '', ''),
(170, '38682753', 'Selvam Store', '2022-06-30 16:13:04', '15781505', '37422833', '80189244', '0%', '30695824', '9994400548', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'No.24, HVF Road, Avadi', 'Chennai', 600054, '', ''),
(171, '20368890', 'R.K Store', '2022-06-30 16:13:04', '15781505', '78523752', '80189244', '0%', '30695824', '9789862637', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'No.160/1, NM Road, Avadi', 'Chennai', 600054, '', ''),
(172, '74956982', 'Thirumagal Store', '2022-06-30 16:13:04', '15781505', '10071785', '80189244', '0%', '30695824', '9841708884', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'No.1, Main Road, Kamaraj Nagar, Avadi', 'Chennai', 600071, '', ''),
(173, '12780879', 'S Thasthakeer Store', '2022-06-30 16:13:04', '15781505', '88540396', '80189244', '0%', '30695824', '9710011030', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'No.1/412, Kamaraj Nagar Main Road, Avadi', 'Chennai', 600071, '', ''),
(174, '13363044', 'REL Enterprises', '2022-06-30 16:13:04', '15781505', '22859156', '80189244', '0%', '30695824', '9444503012', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'No.25, Kamaraj Nagar Main Road, Avadi', 'Chennai', 600071, '', ''),
(175, '87834333', 'RLM Store', '2022-06-30 16:13:04', '15781505', '23199737', '80189244', '0%', '30695824', '6381065746', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'No.4/1, Kamaraj Nagar Main Road, Avadi', 'Chennai', 600071, '', ''),
(176, '66945661', 'Ponnu Super Bazaar', '2022-06-30 16:13:04', '15781505', '16698208', '80189244', '0%', '30695824', '', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'No.C3 & C4, NM Road, Avadi', 'Chennai', 600054, '', ''),
(177, '90801623', 'M.M Stores', '2022-06-30 16:13:04', '15781505', '12532984', '80189244', '0%', '30695824', '9840143530', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'No.93, NM Road, Avadi', 'Chennai', 600054, '', ''),
(178, '39585753', 'Ponman Store', '2022-06-30 16:13:04', '15781505', '82380394', '80189244', '0%', '30695824', '', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'No.18, Kamaraj Nagar, Avadi', 'Chennai', 600071, '', ''),
(179, '90022020', 'R. Dhanalakshmi Stores', '2022-06-30 16:13:04', '15781505', '58321869', '80189244', '0%', '30695824', '9940431338', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'No.6, Kamaraj Nagar Main Road, Avadi', 'Chennai', 600071, '', ''),
(180, '12000217', 'Palraj Store', '2022-06-30 16:13:04', '15781505', '36224233', '80189244', '0%', '30695824', '9962215397', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'No.52, 6th Street, Kamaraj Nagar, Avadi', 'Chennai', 600071, '', ''),
(181, '21879650', 'Soundarapandiyan Store', '2022-06-30 16:13:04', '15781505', '26259099', '80189244', '0%', '30695824', '928336888', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'No.133, Kamaraj Nagar Main Road, Avadi', 'Chennai', 600071, '', ''),
(182, '59045107', 'New Saaratha Store', '2022-06-30 16:13:04', '15781505', '49131899', '80189244', '0%', '30695824', '9566138888', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'No.176, Kamaraj Nagar Main Road, Avadi', 'Chennai', 600071, '', ''),
(183, '69545312', 'Jaya Provision', '2022-06-30 16:13:04', '15781505', '47636754', '80189244', '0%', '30695824', '', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'No.149, Kamaraj Nagar Main Road, Avadi', 'Chennai', 600071, '', ''),
(184, '52741464', 'R.A.S Store', '2022-06-30 16:13:04', '15781505', '48298634', '80189244', '0%', '30695824', '9840370531', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'No.45, 4th Street, Kamaraj Nagar, Avadi', 'Chennai', 600071, '', ''),
(185, '32699805', 'Om Muruga Store', '2022-06-30 16:13:04', '15781505', '70323070', '80189244', '0%', '30695824', '9840855183', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'No.52, Kamaraj Nagar, Avadi', 'Chennai', 600071, '', ''),
(186, '12271927', 'Ramalakshmi Mittai Shop', '2022-06-30 16:13:04', '15781505', '26140315', '80189244', '0%', '30695824', '6385118426', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'No.252, NM Road, Avadi', 'Chennai', 600054, '', ''),
(187, '37258009', 'Lakshmi Store', '2022-06-30 16:13:04', '15781505', '97303782', '80189244', '0%', '30695824', '', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'No.1079, NM Road, Avadi', 'Chennai', 600054, '', ''),
(188, '88347824', 'R.M.K Super Market', '2022-06-30 16:13:04', '15781505', '33054482', '80189244', '0%', '30695824', '', '', '2022-06-30 16:13:04', '', '', '1', 'Active', '', 'Chennai', 600054, '', ''),
(189, '24936937', 'Sakthi Vinayagar Store', '2022-06-30 16:13:04', '15781505', '61183659', '80189244', '0%', '30695824', '9629364870', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'No.258, NM Road, Avadi', 'Chennai', 600054, '', ''),
(190, '72532626', 'Naveen Traders', '2022-06-30 16:13:04', '15781505', '31141365', '80189244', '0%', '30695824', '9962218691', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'No.20, NM Road, Avadi', 'Chennai', 600054, '', ''),
(191, '59871140', 'Maharaja Store', '2022-06-30 16:13:04', '15781505', '78516905', '80189244', '0%', '30695824', '7418507071', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'No.25, NM Road, Avadi', 'Chennai', 600054, '', ''),
(192, '70802629', 'Basheer Stores', '2022-06-30 16:13:04', '15781505', '72173583', '80189244', '0%', '30695824', '', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'No.35, NM Road, Avadi', 'Chennai', 600054, '', ''),
(193, '97522691', 'Kayal Super Market', '2022-06-30 16:13:04', '15781505', '18021322', '80189244', '0%', '30695824', '9444459365', '', '2022-06-30 16:13:04', '33AHJPR4743H1Z6', '', '1', 'Active', 'No.222, NM Road, Avadi', 'Chennai', 600054, '', ''),
(194, '81160806', 'Sanjay Kumar Store', '2022-06-30 16:13:04', '15781505', '14773724', '80189244', '0%', '30695824', '9841019005', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'No.24, 24th Street, JB Estate, Avadi', 'Chennai', 600054, '', ''),
(195, '45012688', 'Ponmani Store', '2022-06-30 16:13:04', '15781505', '69124846', '80189244', '0%', '30695824', '9840311718', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'No.29, 1st Main Road, JB Estate, Avadi', 'Chennai', 600054, '', ''),
(196, '35379152', 'Lakshmi Stores', '2022-06-30 16:13:04', '15781505', '30517529', '80189244', '0%', '30695824', '9444823548', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'No.106/1, PH Road, Rajbai Nagar, Avadi', 'Chennai', 600054, '', ''),
(197, '51945031', 'Sri Pethanachi Amman Stores', '2022-06-30 16:13:04', '15781505', '39952877', '80189244', '0%', '30695824', '8754997793', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'No.95, PH Road, Govarthanagiri, Avadi', 'Chennai', 600071, '', ''),
(198, '56259961', 'Sri Selvaganapathi Store', '2022-06-30 16:13:04', '15781505', '72217695', '80189244', '0%', '30695824', '9884802575', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'No.96, Govarthanagiri, PH Road, Avadi', 'Chennai', 600071, '', ''),
(199, '72362249', 'Sri Balaji Store', '2022-06-30 16:13:04', '15781505', '27192453', '80189244', '0%', '30695824', '9445386028', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'No.211, Nehru Bazaar, Avadi', 'Chennai', 600054, '', ''),
(200, '95227455', 'Amman Stores', '2022-06-30 16:13:04', '15781505', '74285921', '80189244', '0%', '30695824', '', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'No.147/A, PH Road, Avadi', 'Chennai', 600054, '', ''),
(201, '31762743', 'Kalanjiyam Traders', '2022-06-30 16:13:04', '15781505', '92223488', '80189244', '0%', '30695824', '7358004786', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'No.9, NM Road Market, Avadi', 'Chennai', 600054, '', ''),
(202, '77076876', 'Kanmani Stores', '2022-06-30 16:13:04', '15781505', '70712817', '80189244', '0%', '30695824', '9840075688', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'No.414, CTH Road, Avadi', 'Chennai', 600054, '', ''),
(203, '30566302', 'Selvaraj Super Market', '2022-06-30 16:13:04', '15781505', '23207094', '80189244', '0%', '30695824', '', '', '2022-06-30 16:13:04', '', '', '1', 'Active', 'CTH Road, Avadi', 'Chennai', 600054, '', ''),
(204, '28166749', 'Annai Store', '2022-07-01 15:41:10', '28133448', '24820762', '80189244', '0%', '30695824', '8056157478', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'No.75, Vanagaram Main Road, Athipattu, Ambattur Kuppam', 'Chennai', 600058, '', ''),
(205, '13168430', 'Muthukumar Store', '2022-07-01 15:41:10', '28133448', '15411201', '80189244', '0%', '30695824', '9789973906', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'No.80, 2nd Mettu Street, Athipattu, Ambattur', 'Chennai', 600058, '', ''),
(206, '71926819', 'Parthiban Store', '2022-07-01 15:41:10', '28133448', '67202203', '80189244', '0%', '30695824', '9962940112', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'No.23/8, Kavarai Street, Athipattu, Ambattur', 'Chennai', 600058, '', ''),
(207, '91511401', 'Sandhiya Store', '2022-07-01 15:41:10', '28133448', '44306446', '80189244', '0%', '30695824', '', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'No.25/36, Mettu Street, Athipattu, Ambattur', 'Chennai', 600058, '', ''),
(208, '39274167', 'A Sanmugam Maligai Store', '2022-07-01 15:41:10', '28133448', '66760940', '80189244', '0%', '30695824', '9840841061', '', '2022-07-01 15:41:10', '', '', '1', 'Active', ' Athipattu, Ambattur', 'Chennai', 600058, '', ''),
(209, '75501563', 'Mani Madhavan Store', '2022-07-01 15:41:10', '28133448', '23869626', '80189244', '0%', '30695824', '', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'No.11/88, 10th Cross Street, Mettu Street, Athipattu, Ambattur', 'Chennai', 600058, '', ''),
(210, '19033303', 'Ponkathir Store', '2022-07-01 15:41:10', '28133448', '33691348', '80189244', '0%', '30695824', '9841103393', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'No.45/6, Athipatti Chinna Colony, Vanagaram Main Road', 'Chennai', 600058, '', ''),
(211, '32967435', 'Sri Lakshmi Store', '2022-07-01 15:41:10', '28133448', '63163027', '80189244', '0%', '30695824', '9710128712', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'No.62, Vanagaram Main Road, Athipatti Chinna Colony', 'Chennai', 600058, '', ''),
(212, '51373039', 'Jebamalai Annai Store', '2022-07-01 15:41:10', '28133448', '97231248', '80189244', '0%', '30695824', '9600127751', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'No.26-A, Jeshvanth Nagar, Mogappair West (Extension)', 'Chennai', 600037, '', ''),
(213, '59731389', 'Pandiyan Store', '2022-07-01 15:41:10', '28133448', '78547072', '80189244', '0%', '30695824', '9750662847', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'No.81, Reddipalayam Road, Mogappair West', 'Chennai', 600037, '', ''),
(214, '35990157', 'KP Stores', '2022-07-01 15:41:10', '28133448', '11878785', '80189244', '0%', '30695824', '9150161816', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'No.3/5B, Kambar Salai, Mugappair West', 'Chennai', 600037, '', ''),
(215, '43069784', 'New Krishna Store', '2022-07-01 15:41:10', '28133448', '88805899', '80189244', '0%', '30695824', '9841489909', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'No.3/104, Mugappair West', 'Chennai', 600037, '', ''),
(216, '54705971', 'N.S Stores', '2022-07-01 15:41:10', '28133448', '63414415', '80189244', '0%', '30695824', '7295934662', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'No.3/658, parimey Azhagar Street, JJ Nagar, Mugappair', 'Chennai', 600037, '', ''),
(217, '88004335', 'KR Thangam Stores', '2022-07-01 15:41:10', '28133448', '13304283', '80189244', '0%', '30695824', '9940561289', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'PC-8/2, Barathi Salai, Lakshmi Complex, Mugappair West', 'Chennai', 600037, '', ''),
(218, '89022528', 'Selvakumar Store', '2022-07-01 15:41:10', '28133448', '94208176', '80189244', '0%', '30695824', '9952994407', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'No.1/277, Kaalamegam Salai, Mugappair West', 'Chennai', 600037, '', '');
INSERT INTO `shop` (`id`, `token`, `name`, `date_time`, `unit_token`, `retail_code`, `shop_type_code`, `slot`, `distributor_token`, `mobile_number`, `contact_person`, `join_date`, `license_number`, `license_image`, `delete_status`, `shop_show_status`, `address`, `city`, `pincode`, `coordinates`, `created_by`) VALUES
(219, '25624573', 'Sankar Stores', '2022-07-01 15:41:10', '28133448', '33570919', '80189244', '0%', '30695824', '9941444180', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'No.2/473, Kaalamegam Salai, Mugappair West', 'Chennai', 600037, '', ''),
(220, '71897789', 'Muthaaramman Store', '2022-07-01 15:41:10', '28133448', '64144673', '80189244', '0%', '30695824', '9551365200', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'No.2/474, Pillayarkovil Street, Mugappair West', 'Chennai', 600037, '', ''),
(221, '88592943', 'BJ Store', '2022-07-01 15:41:10', '28133448', '41567257', '80189244', '0%', '30695824', '', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'Pillayarkovil Street, Mugappair West', 'Chennai', 600037, '', ''),
(222, '23185055', 'MM Stores', '2022-07-01 15:41:10', '28133448', '17152159', '80189244', '0%', '30695824', '7092519235', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'No.1/13, 2nd Block, Mugappair West', 'Chennai', 600037, '', ''),
(223, '25418179', 'GM Stores', '2022-07-01 15:41:10', '28133448', '18769804', '80189244', '0%', '30695824', '9585652376', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'No.960, Mugappair West', 'Chennai', 600037, '', ''),
(224, '40955257', 'Sri Vaasavi Store', '2022-07-01 15:41:10', '28133448', '12744686', '80189244', '0%', '30695824', '', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'No.2/946, Mugappair West', 'Chennai', 600037, '', ''),
(225, '93718508', 'Priyadharshini Store', '2022-07-01 15:41:10', '28133448', '79902926', '80189244', '0%', '30695824', '9677146841', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'No.2/155, Mugappair West', 'Chennai', 600037, '', ''),
(226, '15893244', 'Thirumalai Store', '2022-07-01 15:41:10', '28133448', '40005640', '80189244', '0%', '30695824', '9710220503', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'No.2/25, Kaalamegam Salai, Mugappair West', 'Chennai', 600037, '', ''),
(227, '56772379', 'MGM Store', '2022-07-01 15:41:10', '28133448', '68821532', '80189244', '0%', '30695824', '8939047444', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'No.370, 1st Block, Mugappair West', 'Chennai', 600037, '', ''),
(228, '87903054', 'Ayyanaar Store', '2022-07-01 15:41:10', '28133448', '81742017', '80189244', '0%', '30695824', '9042763869', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'PC 4, 1st Street, Main Road 1st Block, Mugappair', 'Chennai', 600037, '', ''),
(229, '50997149', 'Venkatheshwara Oil', '2022-07-01 15:41:10', '28133448', '88065166', '80189244', '0%', '30695824', '9840831200', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'No.2/PC6 Main Road, Mugappair West', 'Chennai', 600037, '', ''),
(230, '99555736', 'Bhuvanesh Store', '2022-07-01 15:41:10', '28133448', '46710917', '80189244', '0%', '30695824', '9940036456', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'No.44, Sithaath Nagar, Mugappair West', 'Chennai', 600037, '', ''),
(231, '15519643', 'Sandhiya Store', '2022-07-01 15:41:10', '28133448', '86389275', '80189244', '0%', '30695824', '8248599292', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'R-14, Nolambur Phase II, 3rd Main Road', 'Chennai', 600037, '', ''),
(232, '71297098', 'Jebamalai Annai Store 2', '2022-07-01 15:41:10', '28133448', '12111156', '80189244', '0%', '30695824', '9566207026', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'No.8/13, Barath Salai, Mugappair West', 'Chennai', 600037, '', ''),
(233, '50198659', 'Pandiyan Maligai', '2022-07-01 15:41:10', '28133448', '96376863', '80189244', '0%', '30695824', '9003473929', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'No.5/409, Sivan Kovil Street, Mugappair West', 'Chennai', 600037, '', ''),
(234, '27678604', 'MS Stores', '2022-07-01 15:41:10', '28133448', '19854802', '80189244', '0%', '30695824', '9710006451', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'No.4/1305, Mogappair West', 'Chennai', 600037, '', ''),
(235, '13955876', 'Om Sivasakthi General Store', '2022-07-01 15:41:10', '28133448', '72931137', '80189244', '0%', '30695824', '9788263720', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'No.4/1071, Mugappair West', 'Chennai', 600037, '', ''),
(236, '47561954', 'Sri Amman Store', '2022-07-01 15:41:10', '28133448', '66482829', '80189244', '0%', '30695824', '8105952672', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'No.1109, Mugappair West', 'Chennai', 600037, '', ''),
(237, '85259730', 'National Maligai Agencies', '2022-07-01 15:41:10', '28133448', '92874889', '80189244', '0%', '30695824', '9444851049', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'No.2/PC-6, Opp. Tank Bus Depo, Mugappair West', 'Chennai', 600037, '', ''),
(238, '87519956', 'Welcome Store', '2022-07-01 15:41:10', '28133448', '28305159', '80189244', '0%', '30695824', '7299213350', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'No.86/146, Vellalar Street, Mugappair West', 'Chennai', 600037, '', ''),
(239, '19056848', 'Santhaana Lakshmi Store', '2022-07-01 15:41:10', '28133448', '38014074', '80189244', '0%', '30695824', '7305667002', '', '2022-07-01 15:41:10', '', '', '1', 'Active', 'No.125, Vellalar Street, Mugappair West', 'Chennai', 600037, '', ''),
(240, '52683573', 'Kasirajan Stores', '2022-07-02 12:04:54', '72014401', '70127167', '80189244', '0%', '30695824', '9094545042', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.501, MTH Road, Ambattur', 'Chennai', 600053, '', ''),
(241, '83168516', 'JK Stores', '2022-07-02 12:04:54', '72014401', '70056191', '80189244', '0%', '30695824', '', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.512, MTH Road, Ambattur', 'Chennai', 600053, '', ''),
(242, '36791265', 'BSV Super Market', '2022-07-02 12:04:54', '72014401', '90834887', '80189244', '0%', '30695824', '+914426244375', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.335, MTH Road, Ambattur', 'Chennai', 600053, '', ''),
(243, '49675703', 'Ganesh & Co', '2022-07-02 12:04:54', '72014401', '90374281', '80189244', '0%', '30695824', '9841374646', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.336, MTH Road, Ambattur', 'Chennai', 600053, '', ''),
(244, '41946487', 'Dhamu Stores', '2022-07-02 12:04:54', '72014401', '99199458', '80189244', '0%', '30695824', '9841202028', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.2, Mariyamma Kovil Street, Ambattur Kuppam', 'Chennai', 600058, '', ''),
(245, '14141904', 'Nellai Gnanam Stores', '2022-07-02 12:04:54', '72014401', '91063724', '80189244', '0%', '30695824', '+914426259994', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.15, Vellalar Street, Old Ambattur', 'Chennai', 600058, '', ''),
(246, '25823128', 'Thillai Store', '2022-07-02 12:04:54', '72014401', '54026774', '80189244', '0%', '30695824', '9941866585', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.12, Mariyamma Kovil Street, Ambattur Kuppam', 'Chennai', 600058, '', ''),
(247, '92632321', 'Sai Priya Store', '2022-07-02 12:04:54', '72014401', '24146430', '80189244', '0%', '30695824', '9566231511', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.27, 3rd Main Road, Ambattur Industrial Estate', 'Chennai', 600058, '', ''),
(248, '84629972', 'Sri Vinayaka Stationary & Fancy Store', '2022-07-02 12:04:54', '72014401', '72327520', '80189244', '0%', '30695824', '', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.7/39A, Vellalar Street, Ambattur', 'Chennai', 600058, '', ''),
(249, '64613351', 'Suyambulingam Stores', '2022-07-02 12:04:54', '72014401', '65807317', '80189244', '0%', '30695824', '', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.7, Menambedu Road', 'Chennai', 600098, '', ''),
(250, '55033465', 'Varatharajan Store', '2022-07-02 12:04:54', '72014401', '36326446', '80189244', '0%', '30695824', '9176849142', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.18/28, Manickam Pillai Street, Mannurpet', 'Chennai', 600050, '', ''),
(251, '61015611', 'Thangam Stores', '2022-07-02 12:04:54', '72014401', '14380927', '80189244', '0%', '30695824', '8056225552', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.287, Pillaiyar Kovil Street, Mannurpet', 'Chennai', 600050, '', ''),
(252, '92377361', 'Kumaran Fancy Store', '2022-07-02 12:04:54', '72014401', '93632313', '80189244', '0%', '30695824', '+914426358956', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.84B/B, MTH Road, Padi', 'Chennai', 600050, '', ''),
(253, '73857216', 'P Krishna Store', '2022-07-02 12:04:54', '72014401', '82572094', '80189244', '0%', '30695824', '+914426241947', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.149, MTH Road, Padi', 'Chennai', 600050, '', ''),
(254, '50054120', 'Raja Traders', '2022-07-02 12:04:54', '72014401', '18994947', '80189244', '0%', '30695824', '9840253574', '', '2022-07-02 12:04:54', '', '', '1', 'Active', '101, Yadava St, Padi', 'Chennai', 600050, '', ''),
(255, '78875639', 'Raja Stores', '2022-07-02 12:04:54', '72014401', '69134976', '80189244', '0%', '30695824', '9884056415', '', '2022-07-02 12:04:54', '', '', '1', 'Active', '95, Yadava St, Padi', 'Chennai', 600050, '', ''),
(256, '12395705', 'Kumar Store', '2022-07-02 12:04:54', '72014401', '23633100', '80189244', '0%', '30695824', '9940410109', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.108, Raja Street, Padi', 'Chennai', 600050, '', ''),
(257, '50144497', 'P Varadharajan Traders', '2022-07-02 12:04:54', '72014401', '93705709', '80189244', '0%', '30695824', '9841711693', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.233, Raja Street, Padi', 'Chennai', 600050, '', ''),
(258, '39542515', 'Annai Stores', '2022-07-02 12:04:54', '72014401', '89204351', '80189244', '0%', '30695824', '', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.78, Yadava Street, Padi', 'Chennai', 600050, '', ''),
(259, '34153738', 'Vallikrishna Store', '2022-07-02 12:04:54', '72014401', '50266051', '80189244', '0%', '30695824', '7299393904', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.1B, South Mada Street, Padi', 'Chennai', 600050, '', ''),
(260, '74638937', 'Rajalakshmi Store', '2022-07-02 12:04:54', '72014401', '19303084', '80189244', '0%', '30695824', '', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.46, Vallalar Street, Jegathambigai Nagar, Padi', 'Chennai', 600050, '', ''),
(261, '17888401', 'Venkateshwara Store', '2022-07-02 12:04:54', '72014401', '20624178', '80189244', '0%', '30695824', '9283177705', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.73, Thiruvallur Street, Padi', 'Chennai', 600050, '', ''),
(262, '86887474', 'Thirumurugan Store', '2022-07-02 12:04:54', '72014401', '27503249', '80189244', '0%', '30695824', '9840368206', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.96, MG Road, Kumaran Nagar, Padi', 'Chennai', 600050, '', ''),
(263, '30902776', 'Lakshmi Stores', '2022-07-02 12:04:54', '72014401', '86418915', '80189244', '0%', '30695824', '8825873656', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.194, Kumaran Nagar, Raja Raja Chozhan Nagar, Padi', 'Chennai', 600050, '', ''),
(264, '60823491', 'Balamurugan Store', '2022-07-02 12:04:54', '72014401', '20133269', '80189244', '0%', '30695824', '9094497413', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.65, TVS Main road, Devar Nagar, Padi', 'Chennai', 600050, '', ''),
(265, '66254896', 'Thirumalai Store', '2022-07-02 12:04:54', '72014401', '68880891', '80189244', '0%', '30695824', '7418741155', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.187, TVS Main road, Devar Nagar, Padi', 'Chennai', 600050, '', ''),
(266, '52161977', 'Raja Store', '2022-07-02 12:04:54', '72014401', '79512306', '80189244', '0%', '30695824', '', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.150, TVS Main road, Devar Nagar, Padi', 'Chennai', 600050, '', ''),
(267, '46775747', 'Sri Kumaran Store', '2022-07-02 12:04:54', '72014401', '51830441', '80189244', '0%', '30695824', '', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.183, TVS Nagar, Anna Nagar West', 'Chennai', 600050, '', ''),
(268, '22468700', 'Ayyanaar Store', '2022-07-02 12:04:54', '72014401', '61109033', '80189244', '0%', '30695824', '9840197247', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.45/24, 7th Street, Padi Pudhu Nagar', 'Chennai', 600101, '', ''),
(269, '34265020', 'Amman Stores', '2022-07-02 12:04:54', '72014401', '98615815', '80189244', '0%', '30695824', '9444451524', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.11, 16th Street, Padi Pudhu Nagar', 'Chennai', 600101, '', ''),
(270, '33707754', 'Parameshwari Stores', '2022-07-02 12:04:54', '72014401', '51249335', '80189244', '0%', '30695824', '+914426562837', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.1, 9th Street, Padi Pudhu Nagar', 'Chennai', 600101, '', ''),
(271, '92909396', 'Balanagamma Store', '2022-07-02 12:04:54', '72014401', '15444595', '80189244', '0%', '30695824', '6383306303', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.4122, 10th Street, Padi Pudhu Nagar', 'Chennai', 600101, '', ''),
(272, '83539221', 'Balanagamma - II Store', '2022-07-02 12:04:54', '72014401', '65079836', '80189244', '0%', '30695824', '', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.5, Kovil Street, Padi Pudhu Nagar', 'Chennai', 600101, '', ''),
(273, '22272105', 'Soundarapandiyan Store', '2022-07-02 12:04:54', '72014401', '48990836', '80189244', '0%', '30695824', '9087340405', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.6, Kovil Street, Padi Pudhu Nagar', 'Chennai', 600101, '', ''),
(274, '92612940', 'Prasanth Stores', '2022-07-02 12:04:54', '72014401', '55730357', '80189244', '0%', '30695824', '', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.13, Padi Pudhu Nagar, Anna Nagar West', 'Chennai', 600101, '', ''),
(275, '35786003', 'Annai Mary Store', '2022-07-02 12:04:54', '72014401', '35576740', '80189244', '0%', '30695824', '9841173395', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.13B, Padi Pudhu Nagar Main Road, Anna Nagar West Extension', 'Chennai', 600101, '', ''),
(276, '98716874', 'Sri Madasamy Stores', '2022-07-02 12:04:54', '72014401', '86709596', '80189244', '0%', '30695824', '9080306584', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.10, Padi Pudhu Nagar Main Road, Anna Nagar West Extension', 'Chennai', 600037, '', ''),
(277, '36780473', 'KN Brothers', '2022-07-02 12:04:54', '72014401', '16714620', '80189244', '0%', '30695824', '+914426157799', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'Thirugnanasmabandar Street, Thiruvalleswaran Nagar', 'Chennai', 600040, '', ''),
(278, '89079873', 'ANS Pandiyan Departmental Store', '2022-07-02 12:04:54', '72014401', '24236916', '80189244', '0%', '30695824', '8148666556', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.1/10, Mugappair East, Bazaar Road', 'Chennai', 600037, '', ''),
(279, '89253946', 'Muthu Store', '2022-07-02 12:04:54', '72014401', '15320646', '80189244', '0%', '30695824', '9962895763', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.10/718, Elango Salai, J J Nagar, Mogappair East', 'Chennai', 600037, '', ''),
(280, '47607924', 'Arun Stores', '2022-07-02 12:04:54', '72014401', '13722103', '80189244', '0%', '30695824', '9444415667', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.10/6, Veeramamunivar Salai, Mugappair East', 'Chennai', 600037, '', ''),
(281, '14022572', 'Sri Mahalingam Stores', '2022-07-02 12:04:54', '72014401', '76434750', '80189244', '0%', '30695824', '', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.1257, Golden Colony, Mugappair', 'Chennai', 600037, '', ''),
(282, '26155478', 'Vijaya Store', '2022-07-02 12:04:54', '72014401', '74660415', '80189244', '0%', '30695824', '9655364053', '', '2022-07-02 12:04:54', '', '', '1', 'Active', '', 'Chennai', 0, '', ''),
(283, '95501954', 'Kalai Super Market', '2022-07-02 12:04:54', '72014401', '14904901', '80189244', '0%', '30695824', '9941504192', '', '2022-07-02 12:04:54', '33BDUPM4601H1Z1', '', '1', 'Active', 'No.7, Pakkiyathammal Nagar, Padi', 'Chennai', 600050, '', ''),
(284, '66555003', 'Ayyanar Store', '2022-07-02 12:04:54', '72014401', '47628273', '80189244', '0%', '30695824', '', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.18, Appar Street, TMP Nagar, Padi', 'Chennai', 600050, '', ''),
(285, '90827516', 'Kumar Stores', '2022-07-02 12:04:54', '72014401', '40322936', '80189244', '0%', '30695824', '9790784043', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.23, Appar Street, TMP Nagar, Padi', 'Chennai', 600050, '', ''),
(286, '58775249', 'Udhayam Stores', '2022-07-02 12:04:54', '72014401', '51778137', '80189244', '0%', '30695824', '9094973495', '', '2022-07-02 12:04:54', '', '', '1', 'Active', 'No.58, Appar Street, TMP Nagar, Padi', 'Chennai', 600050, '', ''),
(287, '65348422', 'Ponmani Store', '2022-07-04 10:06:36', '23786782', '43699770', '80189244', '0%', '30695824', '9940112919', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.7, Karukku Main Road, Menambedu, Ambattur', 'Chennai', 600053, '', ''),
(288, '76634151', 'ASP Malligai Stores', '2022-07-04 10:06:36', '23786782', '36584594', '80189244', '0%', '30695824', '9578572389', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.25, Karukku Main Road, Menambedu, Ambattur', 'Chennai', 600053, '', ''),
(289, '63960672', 'Vaigarai Andavar Store', '2022-07-04 10:06:36', '23786782', '38511636', '80189244', '0%', '30695824', '9791090673', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.1, Elango Nagar, Menambedu, Ambattur', 'Chennai', 600053, '', ''),
(290, '15149364', 'Parvathi Stores', '2022-07-04 10:06:36', '23786782', '92048540', '80189244', '0%', '30695824', '9840739957', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.23A, Savukaar Street, Menambedu, Ambattur', 'Chennai', 600053, '', ''),
(291, '71891102', 'KB Store - I', '2022-07-04 10:06:36', '23786782', '11223295', '80189244', '0%', '30695824', '9094055650', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.72, Karukku Main Road, Menambedu, Ambattur', 'Chennai', 600053, '', ''),
(292, '54067951', 'Raja Stores', '2022-07-04 10:06:36', '23786782', '40679370', '80189244', '0%', '30695824', '9514362419', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.47/82, Karukku Main Road, Menambedu, Ambattur', 'Chennai', 600053, '', ''),
(293, '93643676', 'Sivagami Store', '2022-07-04 10:06:36', '23786782', '25722059', '80189244', '0%', '30695824', '9710248073', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.61/103, Karukku Main Road, Menambedu, Ambattur', 'Chennai', 600053, '', ''),
(294, '32893601', 'Gowtham Store', '2022-07-04 10:06:36', '23786782', '54728383', '80189244', '0%', '30695824', '', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.62, Karukku Main Road, Menambedu, Ambattur', 'Chennai', 600053, '', ''),
(295, '68860010', 'Usha Mary Store', '2022-07-04 10:06:36', '23786782', '51805038', '80189244', '0%', '30695824', '9840132345', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.9, Barath Nagar, Karukku Main Road, Menambedu, Ambattur', 'Chennai', 600053, '', ''),
(296, '16282139', 'Siva Subramaniyam Store', '2022-07-04 10:06:36', '23786782', '22953095', '80189244', '0%', '30695824', '9940485273', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.100, EB Colony, 2nd Main Road, Menambedu, Ambattur', 'Chennai', 600053, '', ''),
(297, '84728098', 'Jayarani Store', '2022-07-04 10:06:36', '23786782', '71822891', '80189244', '0%', '30695824', '9941418122', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.107, Karukku Main Road, Menambedu, Ambattur', 'Chennai', 600053, '', ''),
(298, '76139526', 'Dhana\'s Super Market', '2022-07-04 10:06:36', '23786782', '31104663', '80189244', '0%', '30695824', '7305212596', '', '2022-07-04 10:06:36', '33BWOPM5949M1ZP', '', '1', 'Active', 'Plot No.B, Karukku Main Road, Karukku, Ambattur', 'Chennai', 600053, '', ''),
(299, '78305530', 'DJM Stores', '2022-07-04 10:06:36', '23786782', '21768443', '80189244', '0%', '30695824', '9940251140', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.113, New Street, Karukku, Ambattur', 'Chennai', 600053, '', ''),
(300, '56024098', 'Raj Ganesh Store', '2022-07-04 10:06:36', '23786782', '92270230', '80189244', '0%', '30695824', '', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.47, , Karukku, Ambattur', 'Chennai', 600053, '', ''),
(301, '66014225', 'Your Mart', '2022-07-04 10:06:36', '23786782', '32654060', '80189244', '0%', '30695824', '6369134646', '', '2022-07-04 10:06:36', '33AACFY3142R1ZT', '', '1', 'Active', 'No.1, Jayanthi Nagar, Karukku Main Road, Ambattur', 'Chennai', 600053, '', ''),
(302, '51125077', 'Sivani Stores', '2022-07-04 10:06:36', '23786782', '45905062', '80189244', '0%', '30695824', '7092010649', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.2, Karukku Main Road, Karukku, Ambattur', 'Chennai', 600053, '', ''),
(303, '79491307', 'Rabi Store', '2022-07-04 10:06:36', '23786782', '42064779', '80189244', '0%', '30695824', '', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.33/10, Periyar Salai, Gnanamurthi Nagar, Ambattur', 'Chennai', 600053, '', ''),
(304, '43778157', 'Om Shanthi Store', '2022-07-04 10:06:36', '23786782', '11611266', '80189244', '0%', '30695824', '', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No. , Periyar Salai, Gnanamurthi Nagar, Ambattur', 'Chennai', 600053, '', ''),
(305, '38510461', 'Vigneshwara Store', '2022-07-04 10:06:36', '23786782', '40101020', '80189244', '0%', '30695824', '8667510544', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.1/1, Station Road, Gnanamurthi Nagar, Ambattur', 'Chennai', 600053, '', ''),
(306, '26453834', 'Saravana Store', '2022-07-04 10:06:36', '23786782', '64919929', '80189244', '0%', '30695824', '9677097837', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.399/400, Station Road, Gnanamurthi Nagar, Ambattur', 'Chennai', 600053, '', ''),
(307, '54333895', 'Kannan Store', '2022-07-04 10:06:36', '23786782', '82593569', '80189244', '0%', '30695824', '', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.408 , Periyar Salai, Gnanamurthi Nagar, Ambattur', 'Chennai', 600053, '', ''),
(308, '24203209', 'Sreeram Stores', '2022-07-04 10:06:36', '23786782', '70642143', '80189244', '0%', '30695824', '', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.13 , Bharathi Street, Gnanamurthi Nagar, Ambattur', 'Chennai', 600053, '', ''),
(309, '45192209', 'ST Mart', '2022-07-04 10:06:36', '23786782', '64784648', '80189244', '0%', '30695824', '9952419371', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.3, Gopla Krishnan Street, Pattaravakkam Service Road, Gnanamurthi Nagar, Ambattur', 'Chennai', 600053, '', ''),
(310, '98565927', 'RK Store', '2022-07-04 10:06:36', '23786782', '34395915', '80189244', '0%', '30695824', '8939515149', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.25/11, Gnanamurthi Nagar Main Road, Ambattur', 'Chennai', 600053, '', ''),
(311, '56767817', 'Nalli Stores', '2022-07-04 10:06:36', '23786782', '49579771', '80189244', '0%', '30695824', '9840304392', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'Gnanamurthi Nagar Main Road, Ambattur', 'Chennai', 600053, '', ''),
(312, '92041134', 'Anthony Store', '2022-07-04 10:06:36', '23786782', '62514945', '80189244', '0%', '30695824', '9600132497', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.2, 2nd Street, Pari Nagar, Menambedu', 'Chennai', 600053, '', ''),
(313, '72794880', 'SS Brother Stores', '2022-07-04 10:06:36', '23786782', '11623260', '80189244', '0%', '30695824', '7010176700', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.5A, Prithivipakkam Main Road, Venkatapuram, Ambattur', 'Chennai', 600053, '', ''),
(314, '96430729', 'Micheal Stores', '2022-07-04 10:06:36', '23786782', '28969853', '80189244', '0%', '30695824', '', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.98/116, Kallikuppam Road, Venkatapuram, Ambattur', 'Chennai', 600053, '', ''),
(315, '26695258', 'Sri Thenmozhi Plastic & Metal', '2022-07-04 10:06:36', '23786782', '23596370', '80189244', '0%', '30695824', '9445709588', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.64/151, KK Road, Venkatapuram, Ambattur', 'Chennai', 600053, '', ''),
(316, '35908827', 'Surya Departmental Store', '2022-07-04 10:06:36', '23786782', '55982918', '80189244', '0%', '30695824', '8939842838', '', '2022-07-04 10:06:36', '33AEFFS2728N1ZQ', '', '1', 'Active', 'No.22, South Park Street, Venkatapuram, Ambattur', 'Chennai', 600053, '', ''),
(317, '96099051', 'Selvam Stores', '2022-07-04 10:06:36', '23786782', '38726704', '80189244', '0%', '30695824', '9841679952', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.97, KK Road, Ambattur', 'Chennai', 600053, '', ''),
(318, '19733175', 'GK Stores', '2022-07-04 10:06:36', '23786782', '49259722', '80189244', '0%', '30695824', '9.14427E+11', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.4A, South Park Street, Ambattur', 'Chennai', 600053, '', ''),
(319, '88005023', 'Amalraj Stores', '2022-07-04 10:06:36', '23786782', '46274173', '80189244', '0%', '30695824', '', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.23, Shop Street, Venkatapuram, Ambattur', 'Chennai', 600053, '', ''),
(320, '47398315', 'New Selva Stores', '2022-07-04 10:06:36', '23786782', '68469020', '80189244', '0%', '30695824', '7401330330', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.28, Shop Street, Venkatapuram, Ambattur', 'Chennai', 600053, '', ''),
(321, '67895150', 'New Demari Store', '2022-07-04 10:06:36', '23786782', '11605782', '80189244', '0%', '30695824', '', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.18/32, Shop Street, Venkatapuram, Ambattur', 'Chennai', 600053, '', ''),
(322, '21718916', 'Bai Store', '2022-07-04 10:06:36', '23786782', '66845098', '80189244', '0%', '30695824', '9940534831', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.2/2, Shop Street, Venkatapuram, Ambattur', 'Chennai', 600053, '', ''),
(323, '75962052', 'Rajam Traders', '2022-07-04 10:06:36', '23786782', '46098795', '80189244', '0%', '30695824', '9.14427E+11', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.307, MTH Road, Venkatapuram, Ambattur', 'Chennai', 600053, '', ''),
(324, '19391872', 'Madhi Stores', '2022-07-04 10:06:36', '23786782', '89386499', '80189244', '0%', '30695824', '9941033827', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.308, MTH Road, Ambattur', 'Chennai', 600053, '', ''),
(325, '23068493', 'Seethalakshmi Store', '2022-07-04 10:06:36', '23786782', '41386459', '80189244', '0%', '30695824', '9841266312', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.192, MTH Road, Ambattur', 'Chennai', 600053, '', ''),
(326, '23908868', 'Gani Stores', '2022-07-04 10:06:36', '23786782', '39244274', '52373582', '0%', '30695824', '', '', '2022-07-04 10:06:36', '', '', '1', 'Active', '', 'Chennai', 600053, '', ''),
(327, '45496888', 'Saravana Store Market', '2022-07-04 10:06:36', '23786782', '50935207', '80189244', '0%', '30695824', '6374715332', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.40/60, School Road, Ambattur', 'Chennai', 600053, '', ''),
(328, '68925223', 'Thirupathi Store', '2022-07-04 10:06:36', '23786782', '41680066', '80189244', '0%', '30695824', '9444804240', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.250, MTH Road, Ambattur', 'Chennai', 600053, '', ''),
(329, '19262857', 'Sri Krishna General Store', '2022-07-04 10:06:36', '23786782', '60723095', '80189244', '0%', '30695824', '9150347620', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.250, MTH Road, Ambattur', 'Chennai', 600053, '', ''),
(330, '74415701', 'SA Natural', '2022-07-04 10:06:36', '23786782', '37873778', '80189244', '0%', '30695824', '9566062145', '', '2022-07-04 10:06:36', '33AABPT5009K1ZQ', '', '1', 'Active', 'No.250, Old MTH Road, Venkatapuram, Ambattur', 'Chennai', 600053, '', ''),
(331, '51175168', 'Rajan Super Market', '2022-07-04 10:06:36', '23786782', '84331943', '80189244', '0%', '30695824', '9382712580', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.67a, North Park Street, Venkatapuram, Ambattur', 'Chennai', 600053, '', ''),
(332, '24071383', 'Peter Stores', '2022-07-04 10:06:36', '23786782', '26688872', '80189244', '0%', '30695824', '9092407667', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.115/93, KK Road, Venkatapuram, Ambattur', 'Chennai', 600053, '', ''),
(333, '71172727', 'MKS Super Market', '2022-07-04 10:06:36', '23786782', '78022972', '80189244', '0%', '30695824', '9840363553', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.67c, North Park Street, Ambattur', 'Chennai', 600053, '', ''),
(334, '20744816', 'Radha Krishna Store', '2022-07-04 10:06:36', '23786782', '60516828', '80189244', '0%', '30695824', '9840391759', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.14, North Park Street, Venkatapuram, Ambattur', 'Chennai', 600053, '', ''),
(335, '94886848', 'Raj Ganesh Store', '2022-07-04 10:06:36', '23786782', '82796730', '80189244', '0%', '30695824', '9941162713', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.477, MTH Road, Krishnapuram, Ambattur', 'Chennai', 600053, '', ''),
(336, '12112794', 'Jaya Store', '2022-07-04 10:06:36', '23786782', '87809142', '80189244', '0%', '30695824', '8610888075', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.38/D, MTH Road, Ambattur', 'Chennai', 600053, '', ''),
(337, '49179617', 'New Amalraj Stores', '2022-07-04 10:06:36', '23786782', '54496508', '52373582', '0%', '30695824', '9841163444', '', '2022-07-04 10:06:36', '', '', '1', 'Active', '', 'Chennai', 600053, '', ''),
(338, '42420903', 'Sri Venkateswara Store', '2022-07-04 10:06:36', '23786782', '34376989', '80189244', '0%', '30695824', '9.14427E+11', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.82/1, Anna Salai, Venkatapuram, Ambattur', 'Chennai', 600053, '', ''),
(339, '79728294', 'Sri Balaji Store', '2022-07-04 10:06:36', '23786782', '10059237', '80189244', '0%', '30695824', '9.14427E+11', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.27, Anna Salai, Vijayalakshmipuram, Ambattur', 'Chennai', 600053, '', ''),
(340, '60454779', 'New Venkateswara Store', '2022-07-04 10:06:36', '23786782', '14067543', '80189244', '0%', '30695824', '9840170063', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.6, Anna Salai, Vijayalakshmipuram, Ambattur', 'Chennai', 600053, '', ''),
(341, '48517593', 'R.K Arisi Malikai Viyaparam', '2022-07-04 10:06:36', '23786782', '49637285', '80189244', '0%', '30695824', '9600031501', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No. 1 Chaeran Street, Ambattur', 'Chennai', 600053, '', ''),
(342, '22632157', 'Nandha Store', '2022-07-04 10:06:36', '23786782', '43923647', '80189244', '0%', '30695824', '9710531927', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No:70/18 Anna Salai, Prakash Nagar', 'Chennai', 600053, '', ''),
(343, '93788145', 'K B Store', '2022-07-04 10:06:36', '23786782', '92091788', '80189244', '0%', '30695824', '7200995555', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No 32 , Redhills Main road, Vijayalakshmipuram, Ambattur', 'Chennai', 600053, '', ''),
(344, '70586282', 'Vaishali Store', '2022-07-04 10:06:36', '23786782', '51971597', '80189244', '0%', '30695824', '9025313307', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No 24  Puram Main Road, Ambattur , Chennai 600053', 'Chennai', 600053, '', ''),
(345, '37011470', 'Selvam Super Market', '2022-07-04 10:06:36', '23786782', '42466675', '80189244', '0%', '30695824', '9600763438', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No. 1, Gandhi Main Road, Oragadam, Ambattur', 'Chennai', 600053, '', ''),
(346, '31267056', 'Praveen Kumar', '2022-07-04 10:06:36', '23786782', '19546201', '80189244', '0%', '30695824', '7338893938', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No: 10 Gandhi Main Road, Oragadam,Ambattur', 'Chennai', 600053, '', ''),
(347, '19116658', 'Pon Nagavan Store', '2022-07-04 10:06:36', '23786782', '53710407', '80189244', '0%', '30695824', '9442264315', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'Gandhi Main Road, Oragadam', 'Chennai', 600053, '', ''),
(348, '54193512', 'Ayyanar Store', '2022-07-04 10:06:36', '23786782', '82318967', '80189244', '0%', '30695824', '', '', '2022-07-04 10:06:36', '', '', '1', 'Active', '29/32 Gandhi Main Road, Oragadam,Ambattur', 'Chennai', 600053, '', ''),
(349, '20923146', 'Selvam Stores', '2022-07-04 10:06:36', '23786782', '96678898', '80189244', '0%', '30695824', '8825612591', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No:111, Gandhi Main Road, Oragadam, Ambattur,', 'Chennai', 600053, '', ''),
(350, '29570832', 'Thamarai Store', '2022-07-04 10:06:36', '23786782', '51197197', '80189244', '0%', '30695824', '8680816083', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No:47/57 , Gandhi Main Road, Oragadam, Ambattur', 'Chennai', 600053, '', ''),
(351, '87829678', 'Sri Meenu Super Market', '2022-07-04 10:06:36', '23786782', '56167084', '80189244', '0%', '30695824', '', '', '2022-07-04 10:06:36', '', '', '1', 'Active', '60/90 Gandhi Main Road, Oragadam,Ambattur', 'Chennai', 600053, '', ''),
(352, '58736059', 'Pon Raja Stores', '2022-07-04 10:06:36', '23786782', '64003017', '52373582', '0%', '30695824', '9486608762', '', '2022-07-04 10:06:36', '', '', '1', 'Active', '', 'Chennai', 600053, '', ''),
(353, '54215241', 'R.P Stores', '2022-07-04 10:06:36', '23786782', '46409253', '80189244', '0%', '30695824', '9176451304', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No:99/6 Gandhi Main Road, Oragadam,Ambattur', 'Chennai', 600053, '', ''),
(354, '53117813', 'Vadivu Stores', '2022-07-04 10:06:36', '23786782', '36753242', '80189244', '0%', '30695824', '', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No:1/101 Ganapathi Nagar, Main Road, Oragadam', 'Chennai', 600053, '', ''),
(355, '61619491', 'Rajapandian Store', '2022-07-04 10:06:36', '23786782', '92895365', '80189244', '0%', '30695824', '8072298513', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No. 286/47, A.K.A Street, A.K.A Nagar, Oragadam, Ambattur', 'Chennai', 600053, '', ''),
(356, '96721420', 'Saranya Store', '2022-07-04 10:06:36', '23786782', '96869999', '80189244', '0%', '30695824', '9841218438', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No: 1/45 AKA Nagar , 1st Main Road, Paaru Nagar, Ambattur', 'Chennai', 600053, '', ''),
(357, '18737733', 'Shenbagam Store', '2022-07-04 10:06:36', '23786782', '77423590', '80189244', '0%', '30695824', '9444711016', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No:143, 4th Main Road, Banu Nagar,Pudur, Ambattur', 'Chennai', 600053, '', ''),
(358, '30373645', 'Narayana Saamy Store', '2022-07-04 10:06:36', '23786782', '80643941', '80189244', '0%', '30695824', '7258441637', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No: 167 A 4th Main Balu Nagar Pudur, Ambattur', 'Chennai', 600053, '', ''),
(359, '96592159', 'Amman Store', '2022-07-04 10:06:36', '23786782', '88299964', '80189244', '0%', '30695824', '9884302052', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No. 2 9th Balu Nagar, Ambattur', 'Chennai', 600053, '', ''),
(360, '22787108', 'Ayanar Stores', '2022-07-04 10:06:36', '23786782', '76791402', '80189244', '0%', '30695824', '9444186658', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No:7 ,7th Street, Baanu Nagar, Pudur, Ambattur', 'Chennai', 600053, '', ''),
(361, '71112698', 'VELAN STORES', '2022-07-04 10:06:36', '23786782', '14990981', '80189244', '0%', '30695824', '9092131391', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No:108,1st Main Road, Banu Nagar, Pudur,Ambattur,', 'Chennai', 600053, '', ''),
(362, '40424191', 'MURUGAN STORE', '2022-07-04 10:06:36', '23786782', '19675560', '80189244', '0%', '30695824', '9710234834', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No. 244, 1st Main Road, Banu Nagar,Pudur', 'Chennai', 600053, '', ''),
(363, '86357058', 'Sri bethanatchi Store', '2022-07-04 10:06:36', '23786782', '57276170', '80189244', '0%', '30695824', '', '', '2022-07-04 10:06:36', '', '', '1', 'Active', '# 1/1, Palaniaya Nagar,Pudur', 'Chennai', 600053, '', ''),
(364, '58017785', 'Sri Krishna Stores', '2022-07-04 10:06:36', '23786782', '88249530', '80189244', '0%', '30695824', '', '', '2022-07-04 10:06:36', '', '', '1', 'Active', '2A,2B , Thirumalai Priya Nagar, Redhills Road,Pudur,Ambattur', 'Chennai', 600053, '', ''),
(365, '83101503', 'SELVAM STORES', '2022-07-04 10:06:36', '23786782', '39666381', '80189244', '0%', '30695824', '9677095136', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No. 15, Ragul Street,Thiumalapriya Nagar,Pudur,Ambattur', 'Chennai', 600053, '', ''),
(366, '14945674', 'Sri Satya Stores', '2022-07-04 10:06:36', '23786782', '54034068', '80189244', '0%', '30695824', '9600059424', '', '2022-07-04 10:06:36', '', '', '1', 'Active', '148/1 , Redhills Road, Pudur', 'Chennai', 600053, '', ''),
(367, '33125295', 'M.M Store', '2022-07-04 10:06:36', '23786782', '94119402', '80189244', '0%', '30695824', '', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No.61, Redhills Main Road,Pudur,Ambattur', 'Chennai', 600053, '', ''),
(368, '14176585', 'Gokul Store', '2022-07-04 10:06:36', '23786782', '33451872', '80189244', '0%', '30695824', '7395930141', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No:2/85 ,Pudur Main Road, Ambatur,', 'Chennai', 600053, '', ''),
(369, '78045521', 'Lingam Stores', '2022-07-04 10:06:36', '23786782', '58418067', '80189244', '0%', '30695824', '', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No: 90 Pudur Main Road,Pudur, ', 'Chennai', 600053, '', ''),
(370, '48933447', 'Saranya Store', '2022-07-04 10:06:36', '23786782', '22901007', '80189244', '0%', '30695824', '9444517735', '', '2022-07-04 10:06:36', '', '', '1', 'Active', 'No:51/101 Pudur Main Road, Ambattur', 'Chennai', 600053, '', ''),
(371, '72666417', 'Karyani Store', '2022-07-04 10:06:36', '23786782', '48014114', '80189244', '0%', '30695824', '9444938057', '', '2022-07-04 10:06:36', '', '', '1', 'Active', '79/4 Pudur Main Road,Pudur', 'Chennai', 600053, '', ''),
(372, '27988612', 'Karpagampal Stores', '2022-07-04 16:30:24', '60390422', '14360861', '80189244', '0%', '30695824', '4420021200', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No.165 HIG ,PART -3, I.C.F colony,Main Road, Ambattur,', 'Chennai', 600058, '', ''),
(373, '63429229', 'Santhai Shop', '2022-07-04 16:30:24', '60390422', '30926514', '80189244', '0%', '30695824', '', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No. 22/2 Thirupathi kudai Street, HB. Part 3 Ambattur', 'Chennai', 600083, '', ''),
(374, '82287967', 'TIRUPATHI AGENCY', '2022-07-04 16:30:24', '60390422', '85557936', '80189244', '0%', '30695824', '9962551234', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No.MIG 169 Phases,Tirupathi Kodal Road,ICF Colony,Ambattur', 'Chennai', 600058, '', ''),
(375, '55452706', 'Ayyanar Store', '2022-07-04 16:30:24', '60390422', '88759996', '80189244', '0%', '30695824', '', '', '2022-07-04 16:30:24', '33AAJFA3324NIZI', '', '1', 'Active', 'No. 6, Ayanampakkam main Rd,ICF colony,Athipet', 'Chennai', 600058, '', ''),
(376, '98012755', 'SARAVANA STORES', '2022-07-04 16:30:24', '60390422', '44734869', '80189244', '0%', '30695824', '9094087002', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No. 6A,Bazzar Road,ICF Colony,Ambattur', 'Chennai', 600058, '', ''),
(377, '41894207', 'SELVAM STORE', '2022-07-04 16:30:24', '60390422', '17498778', '80189244', '0%', '30695824', '9710441151', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'ICF Colony,Ambattur', 'Chennai', 600058, '', ''),
(378, '12364970', 'Sri Ramesh Stores', '2022-07-04 16:30:24', '60390422', '39283918', '80189244', '0%', '30695824', '9952059053', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No.56A Main Road,ICF Colony, Ambattur', 'Chennai', 600058, '', ''),
(379, '95027184', 'Om Saranu Stores', '2022-07-04 16:30:24', '60390422', '85912521', '80189244', '0%', '30695824', '9791109947', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No- 61/69 ICF colony ,Ambattur', 'Chennai', 600058, '', ''),
(380, '13536432', 'Pothigai Rice ', '2022-07-04 16:30:24', '60390422', '88157743', '80189244', '0%', '30695824', '9585263366', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No.77,Krisha, Srinivasa Colony, Ambattur', 'Chennai', 600058, '', ''),
(381, '76239869', 'SRS Stores', '2022-07-04 16:30:24', '60390422', '69141598', '80189244', '0%', '30695824', '', 'P.  Sornamuthu', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No. 71 Mel Ayanabk Road, Chelliyamal Nagar', 'Chennai', 600058, '', ''),
(382, '82888402', 'Nithya Store', '2022-07-04 16:30:24', '60390422', '25078750', '80189244', '0%', '30695824', '8754142502', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No 11/15 padavettamman KovilStreet Melaynabklam,Opp to PKM Hall', 'Chennai', 600095, '', ''),
(383, '58958577', 'PUNITHA CAKES STORE', '2022-07-04 16:30:24', '60390422', '27007225', '80189244', '0%', '30695824', '9629689351', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No.10 ,Chetty Street, Mel Ayanambakkal,', 'Chennai', 600095, '', ''),
(384, '63582848', 'GANESAN STORES', '2022-07-04 16:30:24', '60390422', '31097828', '80189244', '0%', '30695824', '', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No. 55/2A, Ambattur Vanagaram  Main Road, Kil Ayanambakkam', 'Chennai', 600095, '', ''),
(385, '19978490', 'Xavier Stores', '2022-07-04 16:30:24', '60390422', '12367315', '80189244', '0%', '30695824', '', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No. 9, Vanagaram Road, Keel Ayyanbakkam', 'Chennai', 600095, '', ''),
(386, '66060768', 'Selvam Store', '2022-07-04 16:30:24', '60390422', '23769459', '80189244', '0%', '30695824', '9500010658', '', '2022-07-04 16:30:24', '', '', '1', 'Active', '9831 TNHB ,  Thiruvenka Main Road, Ayanabakkam', 'Chennai', 600077, '', ''),
(387, '92166641', 'AMALA Super Market', '2022-07-04 16:30:24', '60390422', '75650671', '80189244', '0%', '30695824', '', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No. Thiruvenka Road, Ayyanbakkam', 'Chennai', 600077, '', ''),
(388, '78751484', 'S. parvathy stores', '2022-07-04 16:30:24', '60390422', '64129514', '80189244', '0%', '30695824', '9841234355', '', '2022-07-04 16:30:24', '', '', '1', 'Active', '32/25 Sach Road , Bhavani Nagar', 'Chennai', 600077, '', ''),
(389, '42324661', 'Revathu Stores', '2022-07-04 16:30:24', '60390422', '98522456', '80189244', '0%', '30695824', '9994535497', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No. 5 , Bhavani Nagar, M.G.R Main Road', 'Chennai', 600077, '', ''),
(390, '70964796', 'Priya Stores', '2022-07-04 16:30:24', '60390422', '50429110', '80189244', '0%', '30695824', '8754530497', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No1 Bhavani Nagar, Ayyanmbakkam', 'Chennai', 600077, '', ''),
(391, '34144923', 'JOTHI STORES', '2022-07-04 16:30:24', '60390422', '17683503', '80189244', '0%', '30695824', '9841154018', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'NO. 28-A School Street, Ayapakkam', 'Chennai', 600077, '', ''),
(392, '64459116', 'Anitha Stores', '2022-07-04 16:30:24', '60390422', '80625321', '80189244', '0%', '30695824', '', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No. 31,School, Ayappakkam', 'Chennai', 600077, '', ''),
(393, '68252664', 'SELVAM STORES', '2022-07-04 16:30:24', '60390422', '83065591', '80189244', '0%', '30695824', '', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No: 24, Guru Bagavan Street, Aperna Nagar, Thiruverkadu Main Road, Ayyapakkam ', 'Chennai', 600077, '', ''),
(394, '74239785', 'VADIVU STORES', '2022-07-04 16:30:24', '60390422', '21346094', '80189244', '0%', '30695824', '8608544048', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No. 52, Aberna Nagar, Ayyapakkam', 'Chennai', 600077, '', ''),
(395, '20766085', 'DHANALAKSHMI STORES', '2022-07-04 16:30:24', '60390422', '39453496', '80189244', '0%', '30695824', '', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No: 13/3 , MGR Nagar, Thiruverkadu Main Road, Paruthipet , Avadi', 'Chennai', 600071, '', ''),
(396, '61625651', 'Thangam Store', '2022-07-04 16:30:24', '60390422', '92770343', '80189244', '0%', '30695824', '9094544276', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No:6269, T.N.H.B. Ayabakkam', 'Chennai', 600077, '', ''),
(397, '98158116', 'Sree Perumal Stores', '2022-07-04 16:30:24', '60390422', '95799266', '80189244', '0%', '30695824', '9444823093', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No .R 97/10 ,TNHB , Ayapakkam', 'Chennai', 600077, '', ''),
(398, '66448945', 'Sri Muruga Stores', '2022-07-04 16:30:24', '60390422', '92111384', '80189244', '0%', '30695824', '9962334055', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No. 123/1 9th Main Road, Ayapakkam', 'Chennai', 600077, '', ''),
(399, '49364833', 'Perumal Maligai Stores', '2022-07-04 16:30:24', '60390422', '78754488', '80189244', '0%', '30695824', '9790393407', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No: MIG - 9390,TNHB, Ayapakkam', 'Chennai', 600077, '', ''),
(400, '87531293', 'BALAJI TRADERS', '2022-07-04 16:30:24', '60390422', '91530640', '80189244', '0%', '30695824', '9444249775', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No: 3178,9th Main Road, Baba Koil Street, Ayyapakkam', 'Chennai', 600077, '', ''),
(401, '68102674', 'SRI RENGA STORE', '2022-07-04 16:30:24', '60390422', '72659935', '80189244', '0%', '30695824', '9841629776', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No.5603,TNHB , Ayapakkam', 'Chennai', 600077, '', ''),
(402, '40838313', 'Parikalai Stores', '2022-07-04 16:30:24', '60390422', '12526294', '80189244', '0%', '30695824', '8939302564', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No:5264, 62th Main Road, TNHB', 'Chennai', 600077, '', ''),
(403, '21718767', 'Madha Stores', '2022-07-04 16:30:24', '60390422', '56461595', '80189244', '0%', '30695824', '9087438835', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No: 4451 52nd main road, TNHB Ayabakkam', 'Chennai', 600077, '', ''),
(404, '30030726', 'Thangam Store', '2022-07-04 16:30:24', '60390422', '84556021', '80189244', '0%', '30695824', '9094224160', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'NO. 4328 TNHB Ayabakkam, ', 'Chennai', 600077, '', ''),
(405, '41988092', 'MALIGA STORE', '2022-07-04 16:30:24', '60390422', '53914305', '80189244', '0%', '30695824', '7299304810', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No 4142 ,Main Road,Ayapakkam', 'Chennai', 600077, '', ''),
(406, '46419447', 'Perumal Maligai Store', '2022-07-04 16:30:24', '60390422', '10955149', '80189244', '0%', '30695824', '9500033409', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No. 60/5, TNHB, Ayapakkam', 'Chennai', 600077, '', ''),
(407, '80338507', 'Vel Store', '2022-07-04 16:30:24', '60390422', '85517257', '80189244', '0%', '30695824', '9444258565', '', '2022-07-04 16:30:24', '', '', '1', 'Active', '1731 TNHB, Ayapakkam', 'Chennai', 600077, '', ''),
(408, '48495432', 'RAJA STORES', '2022-07-04 16:30:24', '60390422', '85964065', '80189244', '0%', '30695824', '8056251257', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No. 2181, TNHB, Ayapakkam,', 'Chennai', 600077, '', ''),
(409, '54317546', 'PANDIAN STORES', '2022-07-04 16:30:24', '60390422', '71850364', '80189244', '0%', '30695824', '8754401618', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No: 99 , Devar Street, TNHB, Ayapakkam', 'Chennai', 600077, '', ''),
(410, '34116755', 'Jothi Store ', '2022-07-04 16:30:24', '60390422', '73640250', '80189244', '0%', '30695824', '7540090058', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No. 42, Vivekenanda Nagar, Ayyapaswamy', 'Chennai', 600077, '', ''),
(411, '85259894', 'A.V. Traders', '2022-07-04 16:30:24', '60390422', '49844086', '80189244', '0%', '30695824', '', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'R60/9 TNHB Main Road, Ayapakkam', 'Chennai', 600077, '', ''),
(412, '82968121', 'Thangam Store', '2022-07-04 16:30:24', '60390422', '41862070', '80189244', '0%', '30695824', '9710837638', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No.309, Camp Road, Reddy Palayam', 'Chennai', 600077, '', ''),
(413, '10508926', 'AMBEYMA SUPER STORES', '2022-07-04 16:30:24', '60390422', '88583272', '80189244', '0%', '30695824', '9345809536', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'Old No. 16, New No. 37 , Tonakela Camp Road, Reddy Palayam,', 'Chennai', 600077, '', ''),
(414, '41734777', 'SRI VINAYAGA STORES', '2022-07-04 16:30:24', '60390422', '27875919', '80189244', '0%', '30695824', '9740484585', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No. 9/3 Tonakela Camp Road, Moogambigai Nagar, Reddy palayam', 'Chennai', 600077, '', ''),
(415, '28441785', 'Rajan Super Market', '2022-07-04 16:30:24', '60390422', '76010283', '80189244', '0%', '30695824', '', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No. 15, Ganesh nagar, Ezhil nagar, Main Road, Ayapakkam', 'Chennai', 600077, '', ''),
(416, '79744867', 'Selvam Store', '2022-07-04 16:30:24', '60390422', '62626943', '80189244', '0%', '30695824', '9551619171', '', '2022-07-04 16:30:24', '', '', '1', 'Active', 'No. 2346 ,9th Main Road,TNHB', 'Chennai', 600077, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `shop__order_transaction`
--

CREATE TABLE `shop__order_transaction` (
  `id` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  `order_token` char(10) NOT NULL,
  `shop_token` char(10) NOT NULL,
  `amount` double NOT NULL,
  `payment_mode` enum('Cash','Cheque') NOT NULL,
  `employee_id` char(10) NOT NULL,
  `status` enum('Completed','Pending') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shop__outstanding`
--

CREATE TABLE `shop__outstanding` (
  `id` int(11) NOT NULL,
  `date_time` datetime DEFAULT NULL,
  `shop_token` varchar(45) DEFAULT NULL,
  `bill_amount` double DEFAULT NULL,
  `paid_amt` double NOT NULL,
  `total_outstanding` double DEFAULT NULL,
  `receiver_token` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shop__outstanding`
--

INSERT INTO `shop__outstanding` (`id`, `date_time`, `shop_token`, `bill_amount`, `paid_amt`, `total_outstanding`, `receiver_token`) VALUES
(11, '2022-06-24 18:33:25', '85217983', 0, 0, 0, '0'),
(12, '2022-06-24 18:39:05', '98446022', 0, 0, 0, '0'),
(13, '2022-06-24 18:40:29', '53432024', 0, 0, 0, '0'),
(14, '2022-06-24 18:42:22', '47623008', 0, 0, 0, '0'),
(15, '2022-06-24 18:44:16', '17729211', 0, 0, 0, '0'),
(16, '2022-06-24 18:44:51', '64436597', 0, 0, 0, '0'),
(17, '2022-06-24 18:47:07', '24974338', 0, 0, 0, '0'),
(18, '2022-06-24 18:48:08', '74167040', 0, 0, 0, '0'),
(19, '2022-06-24 18:50:52', '85164288', 0, 0, 0, '0'),
(20, '2022-06-24 18:53:23', '65424371', 0, 0, 0, '0'),
(21, '2022-06-24 18:54:27', '11597976', 0, 0, 0, '0'),
(22, '2022-06-24 18:55:42', '32096322', 0, 0, 0, '0'),
(23, '2022-06-24 18:57:13', '13707358', 0, 0, 0, '0'),
(24, '2022-06-24 19:00:28', '66691055', 0, 0, 0, '0'),
(25, '2022-06-24 19:00:32', '43414998', 0, 0, 0, '0'),
(26, '2022-06-24 19:02:04', '20340574', 0, 0, 0, '0'),
(27, '2022-06-24 19:03:36', '41875662', 0, 0, 0, '0'),
(28, '2022-06-24 19:06:04', '83169132', 0, 0, 0, '0'),
(29, '2022-06-24 19:07:10', '23487449', 0, 0, 0, '0'),
(30, '2022-06-24 19:17:59', '58485084', 0, 0, 0, '0'),
(31, '2022-06-24 19:26:32', '14313181', 0, 0, 0, '0'),
(32, '2022-06-24 19:27:43', '37608899', 0, 0, 0, '0'),
(33, '2022-06-24 19:28:45', '50579976', 0, 0, 0, '0'),
(34, '2022-06-24 19:32:14', '38934333', 0, 0, 0, '0'),
(35, '2022-06-24 19:36:07', '38451984', 0, 0, 0, '0'),
(36, '2022-06-24 19:38:18', '23598003', 0, 0, 0, '0'),
(37, '2022-06-24 19:40:40', '27406424', 0, 0, 0, '0'),
(38, '2022-06-24 19:42:54', '17674700', 0, 0, 0, '0'),
(39, '2022-06-24 19:44:40', '15291008', 0, 0, 0, '0'),
(40, '2022-06-24 19:46:43', '16104639', 0, 0, 0, '0'),
(41, '2022-06-24 19:51:09', '57174205', 0, 0, 0, '0'),
(42, '2022-06-24 19:56:59', '31256438', 0, 0, 0, '0'),
(43, '2022-06-24 19:56:59', '62386599', 0, 0, 0, '0'),
(44, '2022-06-24 19:56:59', '64696910', 0, 0, 0, '0'),
(45, '2022-06-24 19:56:59', '48792619', 0, 0, 0, '0'),
(46, '2022-06-24 19:56:59', '30275502', 0, 0, 0, '0'),
(47, '2022-06-24 19:56:59', '60270977', 0, 0, 0, '0'),
(48, '2022-06-24 19:56:59', '17790254', 0, 0, 0, '0'),
(49, '2022-06-24 19:56:59', '74140185', 0, 0, 0, '0'),
(58, '2022-06-24 20:11:09', '65089764', 0, 0, 0, '0'),
(59, '2022-06-24 20:11:09', '55722437', 0, 0, 0, '0'),
(60, '2022-06-24 20:11:09', '17985626', 0, 0, 0, '0'),
(61, '2022-06-24 20:11:09', '29366637', 0, 0, 0, '0'),
(62, '2022-06-27 16:44:01', '16754514', 0, 0, 0, '0'),
(63, '2022-06-27 16:44:01', '92864733', 0, 0, 0, '0'),
(64, '2022-06-27 16:44:01', '63693225', 0, 0, 0, '0'),
(65, '2022-06-27 16:44:01', '58233015', 0, 0, 0, '0'),
(66, '2022-06-27 16:44:01', '25349038', 0, 0, 0, '0'),
(67, '2022-06-27 16:44:01', '18618435', 0, 0, 0, '0'),
(68, '2022-06-27 16:44:01', '73487745', 0, 0, 0, '0'),
(69, '2022-06-27 16:44:01', '97562908', 0, 0, 0, '0'),
(70, '2022-06-27 16:44:01', '72106795', 0, 0, 0, '0'),
(71, '2022-06-27 16:44:01', '97503076', 0, 0, 0, '0'),
(72, '2022-06-27 16:44:01', '52821058', 0, 0, 0, '0'),
(73, '2022-06-27 16:44:01', '96925672', 0, 0, 0, '0'),
(74, '2022-06-27 16:44:01', '39964260', 0, 0, 0, '0'),
(75, '2022-06-27 16:44:01', '78867282', 0, 0, 0, '0'),
(76, '2022-06-27 16:44:01', '24500016', 0, 0, 0, '0'),
(77, '2022-06-27 16:44:01', '48130782', 0, 0, 0, '0'),
(78, '2022-06-27 16:44:01', '87533703', 0, 0, 0, '0'),
(79, '2022-06-27 16:44:01', '63445305', 0, 0, 0, '0'),
(80, '2022-06-27 16:44:01', '99360069', 0, 0, 0, '0'),
(81, '2022-06-27 16:44:01', '65112456', 0, 0, 0, '0'),
(82, '2022-06-27 16:44:01', '12878036', 0, 0, 0, '0'),
(83, '2022-06-27 16:44:01', '54927280', 0, 0, 0, '0'),
(84, '2022-06-27 16:44:01', '96152089', 0, 0, 0, '0'),
(85, '2022-06-27 16:44:01', '79740918', 0, 0, 0, '0'),
(86, '2022-06-27 16:44:01', '31481961', 0, 0, 0, '0'),
(87, '2022-06-27 16:44:01', '49247606', 0, 0, 0, '0'),
(88, '2022-06-27 16:44:01', '21584795', 0, 0, 0, '0'),
(89, '2022-06-27 16:44:01', '56949569', 0, 0, 0, '0'),
(90, '2022-06-27 16:44:01', '50427642', 0, 0, 0, '0'),
(91, '2022-06-27 16:44:01', '21186670', 0, 0, 0, '0'),
(92, '2022-06-27 16:44:01', '28949917', 0, 0, 0, '0'),
(93, '2022-06-27 16:44:01', '26331108', 0, 0, 0, '0'),
(94, '2022-06-27 16:44:01', '14272272', 0, 0, 0, '0'),
(95, '2022-06-27 16:44:01', '16672279', 0, 0, 0, '0'),
(96, '2022-06-27 16:44:01', '22845757', 0, 0, 0, '0'),
(97, '2022-06-27 16:44:01', '85854403', 0, 0, 0, '0'),
(98, '2022-06-27 16:44:01', '26038469', 0, 0, 0, '0'),
(99, '2022-06-27 16:44:01', '20609931', 0, 0, 0, '0'),
(100, '2022-06-27 16:44:01', '31169363', 0, 0, 0, '0'),
(101, '2022-06-27 16:44:01', '88269255', 0, 0, 0, '0'),
(102, '2022-06-27 16:44:01', '74937978', 0, 0, 0, '0'),
(103, '2022-06-27 16:44:01', '26752024', 0, 0, 0, '0'),
(104, '2022-06-27 16:44:01', '94323609', 0, 0, 0, '0'),
(105, '2022-06-27 16:44:01', '28856519', 0, 0, 0, '0'),
(106, '2022-06-27 16:44:01', '46751761', 0, 0, 0, '0'),
(107, '2022-06-27 16:44:01', '55643273', 0, 0, 0, '0'),
(108, '2022-06-27 16:44:01', '81114642', 0, 0, 0, '0'),
(109, '2022-06-27 16:44:01', '92761844', 0, 0, 0, '0'),
(110, '2022-06-27 16:44:01', '63938726', 0, 0, 0, '0'),
(111, '2022-06-27 16:44:01', '66443944', 0, 0, 0, '0'),
(112, '2022-06-30 12:42:34', '94011537', 0, 0, 0, '0'),
(113, '2022-06-30 12:42:34', '15057219', 0, 0, 0, '0'),
(114, '2022-06-30 12:42:34', '25891801', 0, 0, 0, '0'),
(115, '2022-06-30 12:42:34', '94810320', 0, 0, 0, '0'),
(116, '2022-06-30 12:42:34', '63575025', 0, 0, 0, '0'),
(117, '2022-06-30 12:42:34', '95209771', 0, 0, 0, '0'),
(118, '2022-06-30 12:42:34', '90236754', 0, 0, 0, '0'),
(119, '2022-06-30 12:42:34', '98219770', 0, 0, 0, '0'),
(120, '2022-06-30 12:42:34', '36857067', 0, 0, 0, '0'),
(121, '2022-06-30 12:42:34', '71696496', 0, 0, 0, '0'),
(122, '2022-06-30 12:42:34', '46558363', 0, 0, 0, '0'),
(123, '2022-06-30 12:42:34', '19340183', 0, 0, 0, '0'),
(124, '2022-06-30 12:42:34', '52785870', 0, 0, 0, '0'),
(125, '2022-06-30 12:42:34', '50994074', 0, 0, 0, '0'),
(126, '2022-06-30 12:42:34', '22303143', 0, 0, 0, '0'),
(127, '2022-06-30 12:42:34', '55580745', 0, 0, 0, '0'),
(128, '2022-06-30 12:42:34', '32020635', 0, 0, 0, '0'),
(129, '2022-06-30 12:42:34', '13595180', 0, 0, 0, '0'),
(130, '2022-06-30 12:42:34', '81557140', 0, 0, 0, '0'),
(131, '2022-06-30 12:42:34', '69030936', 0, 0, 0, '0'),
(132, '2022-06-30 12:42:34', '87883866', 0, 0, 0, '0'),
(133, '2022-06-30 12:42:34', '70487617', 0, 0, 0, '0'),
(134, '2022-06-30 12:42:34', '43877496', 0, 0, 0, '0'),
(135, '2022-06-30 12:42:34', '69135679', 0, 0, 0, '0'),
(136, '2022-06-30 12:42:34', '13330030', 0, 0, 0, '0'),
(137, '2022-06-30 12:42:34', '62369409', 0, 0, 0, '0'),
(138, '2022-06-30 12:42:34', '73964223', 0, 0, 0, '0'),
(139, '2022-06-30 12:42:34', '51205186', 0, 0, 0, '0'),
(140, '2022-06-30 12:42:34', '94539250', 0, 0, 0, '0'),
(141, '2022-06-30 12:42:34', '34855411', 0, 0, 0, '0'),
(142, '2022-06-30 12:42:34', '48723565', 0, 0, 0, '0'),
(143, '2022-06-30 12:42:34', '71301557', 0, 0, 0, '0'),
(144, '2022-06-30 12:42:34', '42367987', 0, 0, 0, '0'),
(145, '2022-06-30 12:42:34', '74696803', 0, 0, 0, '0'),
(146, '2022-06-30 12:42:34', '96949997', 0, 0, 0, '0'),
(147, '2022-06-30 12:42:34', '74521882', 0, 0, 0, '0'),
(148, '2022-06-30 12:42:34', '41727391', 0, 0, 0, '0'),
(149, '2022-06-30 12:42:34', '67906954', 0, 0, 0, '0'),
(150, '2022-06-30 12:42:34', '10595362', 0, 0, 0, '0'),
(151, '2022-06-30 12:42:34', '45746013', 0, 0, 0, '0'),
(152, '2022-06-30 12:42:34', '47258997', 0, 0, 0, '0'),
(153, '2022-06-30 12:42:34', '73296625', 0, 0, 0, '0'),
(154, '2022-06-30 12:42:34', '17807379', 0, 0, 0, '0'),
(155, '2022-06-30 12:42:34', '57187043', 0, 0, 0, '0'),
(156, '2022-06-30 12:42:34', '44599831', 0, 0, 0, '0'),
(157, '2022-06-30 12:42:34', '53195001', 0, 0, 0, '0'),
(158, '2022-06-30 12:42:34', '20093195', 0, 0, 0, '0'),
(159, '2022-06-30 12:42:34', '72860744', 0, 0, 0, '0'),
(160, '2022-06-30 12:42:34', '43396226', 0, 0, 0, '0'),
(161, '2022-06-30 12:42:34', '82034814', 0, 0, 0, '0'),
(162, '2022-06-30 12:42:34', '19181805', 0, 0, 0, '0'),
(163, '2022-06-30 12:42:34', '68416455', 0, 0, 0, '0'),
(164, '2022-06-30 12:42:34', '65273438', 0, 0, 0, '0'),
(165, '2022-06-30 12:42:34', '95913565', 0, 0, 0, '0'),
(166, '2022-06-30 12:42:34', '63281979', 0, 0, 0, '0'),
(167, '2022-06-30 12:42:34', '69349713', 0, 0, 0, '0'),
(168, '2022-06-30 12:42:34', '59430951', 0, 0, 0, '0'),
(169, '2022-06-30 12:42:34', '21752409', 0, 0, 0, '0'),
(170, '2022-06-30 16:13:04', '38682753', 0, 0, 0, '0'),
(171, '2022-06-30 16:13:04', '20368890', 0, 0, 0, '0'),
(172, '2022-06-30 16:13:04', '74956982', 0, 0, 0, '0'),
(173, '2022-06-30 16:13:04', '12780879', 0, 0, 0, '0'),
(174, '2022-06-30 16:13:04', '13363044', 0, 0, 0, '0'),
(175, '2022-06-30 16:13:04', '87834333', 0, 0, 0, '0'),
(176, '2022-06-30 16:13:04', '66945661', 0, 0, 0, '0'),
(177, '2022-06-30 16:13:04', '90801623', 0, 0, 0, '0'),
(178, '2022-06-30 16:13:04', '39585753', 0, 0, 0, '0'),
(179, '2022-06-30 16:13:04', '90022020', 0, 0, 0, '0'),
(180, '2022-06-30 16:13:04', '12000217', 0, 0, 0, '0'),
(181, '2022-06-30 16:13:04', '21879650', 0, 0, 0, '0'),
(182, '2022-06-30 16:13:04', '59045107', 0, 0, 0, '0'),
(183, '2022-06-30 16:13:04', '69545312', 0, 0, 0, '0'),
(184, '2022-06-30 16:13:04', '52741464', 0, 0, 0, '0'),
(185, '2022-06-30 16:13:04', '32699805', 0, 0, 0, '0'),
(186, '2022-06-30 16:13:04', '12271927', 0, 0, 0, '0'),
(187, '2022-06-30 16:13:04', '37258009', 0, 0, 0, '0'),
(188, '2022-06-30 16:13:04', '88347824', 0, 0, 0, '0'),
(189, '2022-06-30 16:13:04', '24936937', 0, 0, 0, '0'),
(190, '2022-06-30 16:13:04', '72532626', 0, 0, 0, '0'),
(191, '2022-06-30 16:13:04', '59871140', 0, 0, 0, '0'),
(192, '2022-06-30 16:13:04', '70802629', 0, 0, 0, '0'),
(193, '2022-06-30 16:13:04', '97522691', 0, 0, 0, '0'),
(194, '2022-06-30 16:13:04', '81160806', 0, 0, 0, '0'),
(195, '2022-06-30 16:13:04', '45012688', 0, 0, 0, '0'),
(196, '2022-06-30 16:13:04', '35379152', 0, 0, 0, '0'),
(197, '2022-06-30 16:13:04', '51945031', 0, 0, 0, '0'),
(198, '2022-06-30 16:13:04', '56259961', 0, 0, 0, '0'),
(199, '2022-06-30 16:13:04', '72362249', 0, 0, 0, '0'),
(200, '2022-06-30 16:13:04', '95227455', 0, 0, 0, '0'),
(201, '2022-06-30 16:13:04', '31762743', 0, 0, 0, '0'),
(202, '2022-06-30 16:13:04', '77076876', 0, 0, 0, '0'),
(203, '2022-06-30 16:13:04', '30566302', 0, 0, 0, '0'),
(204, '2022-07-01 15:41:10', '28166749', 0, 0, 0, '0'),
(205, '2022-07-01 15:41:10', '13168430', 0, 0, 0, '0'),
(206, '2022-07-01 15:41:10', '71926819', 0, 0, 0, '0'),
(207, '2022-07-01 15:41:10', '91511401', 0, 0, 0, '0'),
(208, '2022-07-01 15:41:10', '39274167', 0, 0, 0, '0'),
(209, '2022-07-01 15:41:10', '75501563', 0, 0, 0, '0'),
(210, '2022-07-01 15:41:10', '19033303', 0, 0, 0, '0'),
(211, '2022-07-01 15:41:10', '32967435', 0, 0, 0, '0'),
(212, '2022-07-01 15:41:10', '51373039', 0, 0, 0, '0'),
(213, '2022-07-01 15:41:10', '59731389', 0, 0, 0, '0'),
(214, '2022-07-01 15:41:10', '35990157', 0, 0, 0, '0'),
(215, '2022-07-01 15:41:10', '43069784', 0, 0, 0, '0'),
(216, '2022-07-01 15:41:10', '54705971', 0, 0, 0, '0'),
(217, '2022-07-01 15:41:10', '88004335', 0, 0, 0, '0'),
(218, '2022-07-01 15:41:10', '89022528', 0, 0, 0, '0'),
(219, '2022-07-01 15:41:10', '25624573', 0, 0, 0, '0'),
(220, '2022-07-01 15:41:10', '71897789', 0, 0, 0, '0'),
(221, '2022-07-01 15:41:10', '88592943', 0, 0, 0, '0'),
(222, '2022-07-01 15:41:10', '23185055', 0, 0, 0, '0'),
(223, '2022-07-01 15:41:10', '25418179', 0, 0, 0, '0'),
(224, '2022-07-01 15:41:10', '40955257', 0, 0, 0, '0'),
(225, '2022-07-01 15:41:10', '93718508', 0, 0, 0, '0'),
(226, '2022-07-01 15:41:10', '15893244', 0, 0, 0, '0'),
(227, '2022-07-01 15:41:10', '56772379', 0, 0, 0, '0'),
(228, '2022-07-01 15:41:10', '87903054', 0, 0, 0, '0'),
(229, '2022-07-01 15:41:10', '50997149', 0, 0, 0, '0'),
(230, '2022-07-01 15:41:10', '99555736', 0, 0, 0, '0'),
(231, '2022-07-01 15:41:10', '15519643', 0, 0, 0, '0'),
(232, '2022-07-01 15:41:10', '71297098', 0, 0, 0, '0'),
(233, '2022-07-01 15:41:10', '50198659', 0, 0, 0, '0'),
(234, '2022-07-01 15:41:10', '27678604', 0, 0, 0, '0'),
(235, '2022-07-01 15:41:10', '13955876', 0, 0, 0, '0'),
(236, '2022-07-01 15:41:10', '47561954', 0, 0, 0, '0'),
(237, '2022-07-01 15:41:10', '85259730', 0, 0, 0, '0'),
(238, '2022-07-01 15:41:10', '87519956', 0, 0, 0, '0'),
(239, '2022-07-01 15:41:10', '19056848', 0, 0, 0, '0'),
(240, '2022-07-02 12:04:54', '52683573', 0, 0, 0, '0'),
(241, '2022-07-02 12:04:54', '83168516', 0, 0, 0, '0'),
(242, '2022-07-02 12:04:54', '36791265', 0, 0, 0, '0'),
(243, '2022-07-02 12:04:54', '49675703', 0, 0, 0, '0'),
(244, '2022-07-02 12:04:54', '41946487', 0, 0, 0, '0'),
(245, '2022-07-02 12:04:54', '14141904', 0, 0, 0, '0'),
(246, '2022-07-02 12:04:54', '25823128', 0, 0, 0, '0'),
(247, '2022-07-02 12:04:54', '92632321', 0, 0, 0, '0'),
(248, '2022-07-02 12:04:54', '84629972', 0, 0, 0, '0'),
(249, '2022-07-02 12:04:54', '64613351', 0, 0, 0, '0'),
(250, '2022-07-02 12:04:54', '55033465', 0, 0, 0, '0'),
(251, '2022-07-02 12:04:54', '61015611', 0, 0, 0, '0'),
(252, '2022-07-02 12:04:54', '92377361', 0, 0, 0, '0'),
(253, '2022-07-02 12:04:54', '73857216', 0, 0, 0, '0'),
(254, '2022-07-02 12:04:54', '50054120', 0, 0, 0, '0'),
(255, '2022-07-02 12:04:54', '78875639', 0, 0, 0, '0'),
(256, '2022-07-02 12:04:54', '12395705', 0, 0, 0, '0'),
(257, '2022-07-02 12:04:54', '50144497', 0, 0, 0, '0'),
(258, '2022-07-02 12:04:54', '39542515', 0, 0, 0, '0'),
(259, '2022-07-02 12:04:54', '34153738', 0, 0, 0, '0'),
(260, '2022-07-02 12:04:54', '74638937', 0, 0, 0, '0'),
(261, '2022-07-02 12:04:54', '17888401', 0, 0, 0, '0'),
(262, '2022-07-02 12:04:54', '86887474', 0, 0, 0, '0'),
(263, '2022-07-02 12:04:54', '30902776', 0, 0, 0, '0'),
(264, '2022-07-02 12:04:54', '60823491', 0, 0, 0, '0'),
(265, '2022-07-02 12:04:54', '66254896', 0, 0, 0, '0'),
(266, '2022-07-02 12:04:54', '52161977', 0, 0, 0, '0'),
(267, '2022-07-02 12:04:54', '46775747', 0, 0, 0, '0'),
(268, '2022-07-02 12:04:54', '22468700', 0, 0, 0, '0'),
(269, '2022-07-02 12:04:54', '34265020', 0, 0, 0, '0'),
(270, '2022-07-02 12:04:54', '33707754', 0, 0, 0, '0'),
(271, '2022-07-02 12:04:54', '92909396', 0, 0, 0, '0'),
(272, '2022-07-02 12:04:54', '83539221', 0, 0, 0, '0'),
(273, '2022-07-02 12:04:54', '22272105', 0, 0, 0, '0'),
(274, '2022-07-02 12:04:54', '92612940', 0, 0, 0, '0'),
(275, '2022-07-02 12:04:54', '35786003', 0, 0, 0, '0'),
(276, '2022-07-02 12:04:54', '98716874', 0, 0, 0, '0'),
(277, '2022-07-02 12:04:54', '36780473', 0, 0, 0, '0'),
(278, '2022-07-02 12:04:54', '89079873', 0, 0, 0, '0'),
(279, '2022-07-02 12:04:54', '89253946', 0, 0, 0, '0'),
(280, '2022-07-02 12:04:54', '47607924', 0, 0, 0, '0'),
(281, '2022-07-02 12:04:54', '14022572', 0, 0, 0, '0'),
(282, '2022-07-02 12:04:54', '26155478', 0, 0, 0, '0'),
(283, '2022-07-02 12:04:54', '95501954', 0, 0, 0, '0'),
(284, '2022-07-02 12:04:54', '66555003', 0, 0, 0, '0'),
(285, '2022-07-02 12:04:54', '90827516', 0, 0, 0, '0'),
(286, '2022-07-02 12:04:54', '58775249', 0, 0, 0, '0'),
(287, '2022-07-04 10:06:36', '65348422', 0, 0, 0, '0'),
(288, '2022-07-04 10:06:36', '76634151', 0, 0, 0, '0'),
(289, '2022-07-04 10:06:36', '63960672', 0, 0, 0, '0'),
(290, '2022-07-04 10:06:36', '15149364', 0, 0, 0, '0'),
(291, '2022-07-04 10:06:36', '71891102', 0, 0, 0, '0'),
(292, '2022-07-04 10:06:36', '54067951', 0, 0, 0, '0'),
(293, '2022-07-04 10:06:36', '93643676', 0, 0, 0, '0'),
(294, '2022-07-04 10:06:36', '32893601', 0, 0, 0, '0'),
(295, '2022-07-04 10:06:36', '68860010', 0, 0, 0, '0'),
(296, '2022-07-04 10:06:36', '16282139', 0, 0, 0, '0'),
(297, '2022-07-04 10:06:36', '84728098', 0, 0, 0, '0'),
(298, '2022-07-04 10:06:36', '76139526', 0, 0, 0, '0'),
(299, '2022-07-04 10:06:36', '78305530', 0, 0, 0, '0'),
(300, '2022-07-04 10:06:36', '56024098', 0, 0, 0, '0'),
(301, '2022-07-04 10:06:36', '66014225', 0, 0, 0, '0'),
(302, '2022-07-04 10:06:36', '51125077', 0, 0, 0, '0'),
(303, '2022-07-04 10:06:36', '79491307', 0, 0, 0, '0'),
(304, '2022-07-04 10:06:36', '43778157', 0, 0, 0, '0'),
(305, '2022-07-04 10:06:36', '38510461', 0, 0, 0, '0'),
(306, '2022-07-04 10:06:36', '26453834', 0, 0, 0, '0'),
(307, '2022-07-04 10:06:36', '54333895', 0, 0, 0, '0'),
(308, '2022-07-04 10:06:36', '24203209', 0, 0, 0, '0'),
(309, '2022-07-04 10:06:36', '45192209', 0, 0, 0, '0'),
(310, '2022-07-04 10:06:36', '98565927', 0, 0, 0, '0'),
(311, '2022-07-04 10:06:36', '56767817', 0, 0, 0, '0'),
(312, '2022-07-04 10:06:36', '92041134', 0, 0, 0, '0'),
(313, '2022-07-04 10:06:36', '72794880', 0, 0, 0, '0'),
(314, '2022-07-04 10:06:36', '96430729', 0, 0, 0, '0'),
(315, '2022-07-04 10:06:36', '26695258', 0, 0, 0, '0'),
(316, '2022-07-04 10:06:36', '35908827', 0, 0, 0, '0'),
(317, '2022-07-04 10:06:36', '96099051', 0, 0, 0, '0'),
(318, '2022-07-04 10:06:36', '19733175', 0, 0, 0, '0'),
(319, '2022-07-04 10:06:36', '88005023', 0, 0, 0, '0'),
(320, '2022-07-04 10:06:36', '47398315', 0, 0, 0, '0'),
(321, '2022-07-04 10:06:36', '67895150', 0, 0, 0, '0'),
(322, '2022-07-04 10:06:36', '21718916', 0, 0, 0, '0'),
(323, '2022-07-04 10:06:36', '75962052', 0, 0, 0, '0'),
(324, '2022-07-04 10:06:36', '19391872', 0, 0, 0, '0'),
(325, '2022-07-04 10:06:36', '23068493', 0, 0, 0, '0'),
(326, '2022-07-04 10:06:36', '23908868', 0, 0, 0, '0'),
(327, '2022-07-04 10:06:36', '45496888', 0, 0, 0, '0'),
(328, '2022-07-04 10:06:36', '68925223', 0, 0, 0, '0'),
(329, '2022-07-04 10:06:36', '19262857', 0, 0, 0, '0'),
(330, '2022-07-04 10:06:36', '74415701', 0, 0, 0, '0'),
(331, '2022-07-04 10:06:36', '51175168', 0, 0, 0, '0'),
(332, '2022-07-04 10:06:36', '24071383', 0, 0, 0, '0'),
(333, '2022-07-04 10:06:36', '71172727', 0, 0, 0, '0'),
(334, '2022-07-04 10:06:36', '20744816', 0, 0, 0, '0'),
(335, '2022-07-04 10:06:36', '94886848', 0, 0, 0, '0'),
(336, '2022-07-04 10:06:36', '12112794', 0, 0, 0, '0'),
(337, '2022-07-04 10:06:36', '49179617', 0, 0, 0, '0'),
(338, '2022-07-04 10:06:36', '42420903', 0, 0, 0, '0'),
(339, '2022-07-04 10:06:36', '79728294', 0, 0, 0, '0'),
(340, '2022-07-04 10:06:36', '60454779', 0, 0, 0, '0'),
(341, '2022-07-04 10:06:36', '48517593', 0, 0, 0, '0'),
(342, '2022-07-04 10:06:36', '22632157', 0, 0, 0, '0'),
(343, '2022-07-04 10:06:36', '93788145', 0, 0, 0, '0'),
(344, '2022-07-04 10:06:36', '70586282', 0, 0, 0, '0'),
(345, '2022-07-04 10:06:36', '37011470', 0, 0, 0, '0'),
(346, '2022-07-04 10:06:36', '31267056', 0, 0, 0, '0'),
(347, '2022-07-04 10:06:36', '19116658', 0, 0, 0, '0'),
(348, '2022-07-04 10:06:36', '54193512', 0, 0, 0, '0'),
(349, '2022-07-04 10:06:36', '20923146', 0, 0, 0, '0'),
(350, '2022-07-04 10:06:36', '29570832', 0, 0, 0, '0'),
(351, '2022-07-04 10:06:36', '87829678', 0, 0, 0, '0'),
(352, '2022-07-04 10:06:36', '58736059', 0, 0, 0, '0'),
(353, '2022-07-04 10:06:36', '54215241', 0, 0, 0, '0'),
(354, '2022-07-04 10:06:36', '53117813', 0, 0, 0, '0'),
(355, '2022-07-04 10:06:36', '61619491', 0, 0, 0, '0'),
(356, '2022-07-04 10:06:36', '96721420', 0, 0, 0, '0'),
(357, '2022-07-04 10:06:36', '18737733', 0, 0, 0, '0'),
(358, '2022-07-04 10:06:36', '30373645', 0, 0, 0, '0'),
(359, '2022-07-04 10:06:36', '96592159', 0, 0, 0, '0'),
(360, '2022-07-04 10:06:36', '22787108', 0, 0, 0, '0'),
(361, '2022-07-04 10:06:36', '71112698', 0, 0, 0, '0'),
(362, '2022-07-04 10:06:36', '40424191', 0, 0, 0, '0'),
(363, '2022-07-04 10:06:36', '86357058', 0, 0, 0, '0'),
(364, '2022-07-04 10:06:36', '58017785', 0, 0, 0, '0'),
(365, '2022-07-04 10:06:36', '83101503', 0, 0, 0, '0'),
(366, '2022-07-04 10:06:36', '14945674', 0, 0, 0, '0'),
(367, '2022-07-04 10:06:36', '33125295', 0, 0, 0, '0'),
(368, '2022-07-04 10:06:36', '14176585', 0, 0, 0, '0'),
(369, '2022-07-04 10:06:36', '78045521', 0, 0, 0, '0'),
(370, '2022-07-04 10:06:36', '48933447', 0, 0, 0, '0'),
(371, '2022-07-04 10:06:36', '72666417', 0, 0, 0, '0'),
(372, '2022-07-04 16:30:24', '27988612', 0, 0, 0, '0'),
(373, '2022-07-04 16:30:24', '63429229', 0, 0, 0, '0'),
(374, '2022-07-04 16:30:24', '82287967', 0, 0, 0, '0'),
(375, '2022-07-04 16:30:24', '55452706', 0, 0, 0, '0'),
(376, '2022-07-04 16:30:24', '98012755', 0, 0, 0, '0'),
(377, '2022-07-04 16:30:24', '41894207', 0, 0, 0, '0'),
(378, '2022-07-04 16:30:24', '12364970', 0, 0, 0, '0'),
(379, '2022-07-04 16:30:24', '95027184', 0, 0, 0, '0'),
(380, '2022-07-04 16:30:24', '13536432', 0, 0, 0, '0'),
(381, '2022-07-04 16:30:24', '76239869', 0, 0, 0, '0'),
(382, '2022-07-04 16:30:24', '82888402', 0, 0, 0, '0'),
(383, '2022-07-04 16:30:24', '58958577', 0, 0, 0, '0'),
(384, '2022-07-04 16:30:24', '63582848', 0, 0, 0, '0'),
(385, '2022-07-04 16:30:24', '19978490', 0, 0, 0, '0'),
(386, '2022-07-04 16:30:24', '66060768', 0, 0, 0, '0'),
(387, '2022-07-04 16:30:24', '92166641', 0, 0, 0, '0'),
(388, '2022-07-04 16:30:24', '78751484', 0, 0, 0, '0'),
(389, '2022-07-04 16:30:24', '42324661', 0, 0, 0, '0'),
(390, '2022-07-04 16:30:24', '70964796', 0, 0, 0, '0'),
(391, '2022-07-04 16:30:24', '34144923', 0, 0, 0, '0'),
(392, '2022-07-04 16:30:24', '64459116', 0, 0, 0, '0'),
(393, '2022-07-04 16:30:24', '68252664', 0, 0, 0, '0'),
(394, '2022-07-04 16:30:24', '74239785', 0, 0, 0, '0'),
(395, '2022-07-04 16:30:24', '20766085', 0, 0, 0, '0'),
(396, '2022-07-04 16:30:24', '61625651', 0, 0, 0, '0'),
(397, '2022-07-04 16:30:24', '98158116', 0, 0, 0, '0'),
(398, '2022-07-04 16:30:24', '66448945', 0, 0, 0, '0'),
(399, '2022-07-04 16:30:24', '49364833', 0, 0, 0, '0'),
(400, '2022-07-04 16:30:24', '87531293', 0, 0, 0, '0'),
(401, '2022-07-04 16:30:24', '68102674', 0, 0, 0, '0'),
(402, '2022-07-04 16:30:24', '40838313', 0, 0, 0, '0'),
(403, '2022-07-04 16:30:24', '21718767', 0, 0, 0, '0'),
(404, '2022-07-04 16:30:24', '30030726', 0, 0, 0, '0'),
(405, '2022-07-04 16:30:24', '41988092', 0, 0, 0, '0'),
(406, '2022-07-04 16:30:24', '46419447', 0, 0, 0, '0'),
(407, '2022-07-04 16:30:24', '80338507', 0, 0, 0, '0'),
(408, '2022-07-04 16:30:24', '48495432', 0, 0, 0, '0'),
(409, '2022-07-04 16:30:24', '54317546', 0, 0, 0, '0'),
(410, '2022-07-04 16:30:24', '34116755', 0, 0, 0, '0'),
(411, '2022-07-04 16:30:24', '85259894', 0, 0, 0, '0'),
(412, '2022-07-04 16:30:24', '82968121', 0, 0, 0, '0'),
(413, '2022-07-04 16:30:24', '10508926', 0, 0, 0, '0'),
(414, '2022-07-04 16:30:24', '41734777', 0, 0, 0, '0'),
(415, '2022-07-04 16:30:24', '28441785', 0, 0, 0, '0'),
(416, '2022-07-04 16:30:24', '79744867', 0, 0, 0, '0');

-- --------------------------------------------------------

--
-- Table structure for table `shop__stock_history`
--

CREATE TABLE `shop__stock_history` (
  `id` int(11) NOT NULL,
  `shop_token` char(10) DEFAULT NULL,
  `product_token` char(10) DEFAULT NULL,
  `stock_status` enum('IN','OUT') DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `date_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shop__stock_list`
--

CREATE TABLE `shop__stock_list` (
  `id` int(11) NOT NULL,
  `products_token` char(10) DEFAULT NULL,
  `shop_token` char(10) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `sales` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shop__type`
--

CREATE TABLE `shop__type` (
  `id` int(11) NOT NULL,
  `date_time` datetime DEFAULT NULL,
  `token` char(10) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shop__type`
--

INSERT INTO `shop__type` (`id`, `date_time`, `token`, `name`) VALUES
(1, '2022-05-05 17:11:34', '52373582', 'Wholesale'),
(2, '2022-05-04 10:41:54', '49856576', 'Semi Wholesale'),
(3, '2022-04-11 21:56:38', '80189244', 'Retailer'),
(4, '2022-04-28 20:13:27', '39323642', 'Bunk shop'),
(5, '2022-04-28 20:13:37', '12610825', 'Medical shop');

-- --------------------------------------------------------

--
-- Table structure for table `stock__admin`
--

CREATE TABLE `stock__admin` (
  `id` int(11) NOT NULL,
  `product_token` char(10) NOT NULL,
  `stock_in_hand` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock__distributor`
--

CREATE TABLE `stock__distributor` (
  `id` int(11) NOT NULL,
  `product_token` char(10) NOT NULL,
  `pro_cat_token` char(11) NOT NULL,
  `employee_token` char(10) NOT NULL,
  `stock_in_hand` int(11) NOT NULL,
  `monthly_avg` double NOT NULL,
  `mfs` int(11) NOT NULL COMMENT 'Minimum Floor Stock',
  `aog` int(11) NOT NULL COMMENT 'Automatic Order Generate',
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(11) NOT NULL,
  `date_time` datetime DEFAULT NULL,
  `token` char(10) DEFAULT NULL,
  `name` varchar(35) DEFAULT NULL,
  `distributor_token` char(10) NOT NULL,
  `unitWise_shopList` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `date_time`, `token`, `name`, `distributor_token`, `unitWise_shopList`) VALUES
(3, '2022-06-24 20:23:35', '19453158', 'Ambattur(Kallikuppam', '30695824', ''),
(4, '2022-06-27 16:44:58', '28342048', 'Pattabiram', '30695824', ''),
(5, '2022-06-30 12:43:34', '57495244', 'Thirumullaivoyal', '30695824', ''),
(6, '2022-06-30 16:15:02', '15781505', 'AVADI', '30695824', ''),
(7, '2022-07-01 15:43:40', '28133448', 'Mogappair', '30695824', ''),
(8, '2022-07-02 12:07:19', '72014401', 'Padi', '30695824', ''),
(9, '2022-07-04 10:07:33', '23786782', 'Ambattur', '30695824', ''),
(10, '2022-07-04 16:30:51', '60390422', 'TNHB', '30695824', '');

-- --------------------------------------------------------

--
-- Table structure for table `units__shop_mapping`
--

CREATE TABLE `units__shop_mapping` (
  `id` int(11) NOT NULL,
  `unit_group_token` char(10) DEFAULT NULL,
  `distributor_token` char(10) NOT NULL,
  `shop_token` char(10) DEFAULT NULL,
  `delete_status` enum('1','2') NOT NULL COMMENT '1-active,2-deleted'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `units__shop_mapping`
--

INSERT INTO `units__shop_mapping` (`id`, `unit_group_token`, `distributor_token`, `shop_token`, `delete_status`) VALUES
(23, '19453158', '30695824', '85217983', '1'),
(24, '19453158', '30695824', '98446022', '1'),
(25, '19453158', '30695824', '53432024', '1'),
(26, '19453158', '30695824', '47623008', '1'),
(27, '19453158', '30695824', '17729211', '1'),
(28, '19453158', '30695824', '64436597', '1'),
(29, '19453158', '30695824', '24974338', '1'),
(30, '19453158', '30695824', '74167040', '1'),
(31, '19453158', '30695824', '85164288', '1'),
(32, '19453158', '30695824', '65424371', '1'),
(33, '19453158', '30695824', '11597976', '1'),
(34, '19453158', '30695824', '32096322', '1'),
(35, '19453158', '30695824', '13707358', '1'),
(36, '19453158', '30695824', '66691055', '1'),
(37, '19453158', '30695824', '43414998', '1'),
(38, '19453158', '30695824', '20340574', '1'),
(39, '19453158', '30695824', '41875662', '1'),
(40, '19453158', '30695824', '83169132', '1'),
(41, '19453158', '30695824', '23487449', '1'),
(42, '19453158', '30695824', '58485084', '1'),
(43, '19453158', '30695824', '14313181', '1'),
(44, '19453158', '30695824', '37608899', '1'),
(45, '19453158', '30695824', '50579976', '1'),
(46, '19453158', '30695824', '38934333', '1'),
(47, '19453158', '30695824', '38451984', '1'),
(48, '19453158', '30695824', '23598003', '1'),
(49, '19453158', '30695824', '27406424', '1'),
(50, '19453158', '30695824', '17674700', '1'),
(51, '19453158', '30695824', '15291008', '1'),
(52, '19453158', '30695824', '16104639', '1'),
(53, '19453158', '30695824', '57174205', '1'),
(54, '19453158', '30695824', '31256438', '1'),
(55, '19453158', '30695824', '62386599', '1'),
(56, '19453158', '30695824', '64696910', '1'),
(57, '19453158', '30695824', '48792619', '1'),
(58, '19453158', '30695824', '30275502', '1'),
(59, '19453158', '30695824', '60270977', '1'),
(60, '19453158', '30695824', '17790254', '1'),
(61, '19453158', '30695824', '74140185', '1'),
(62, '19453158', '30695824', '65089764', '1'),
(63, '19453158', '30695824', '55722437', '1'),
(64, '19453158', '30695824', '17985626', '1'),
(65, '19453158', '30695824', '29366637', '1'),
(66, '28342048', '30695824', '16754514', '1'),
(67, '28342048', '30695824', '92864733', '1'),
(68, '28342048', '30695824', '63693225', '1'),
(69, '28342048', '30695824', '58233015', '1'),
(70, '28342048', '30695824', '25349038', '1'),
(71, '28342048', '30695824', '18618435', '1'),
(72, '28342048', '30695824', '73487745', '1'),
(73, '28342048', '30695824', '97562908', '1'),
(74, '28342048', '30695824', '72106795', '1'),
(75, '28342048', '30695824', '97503076', '1'),
(76, '28342048', '30695824', '52821058', '1'),
(77, '28342048', '30695824', '96925672', '1'),
(78, '28342048', '30695824', '39964260', '1'),
(79, '28342048', '30695824', '78867282', '1'),
(80, '28342048', '30695824', '24500016', '1'),
(81, '28342048', '30695824', '48130782', '1'),
(82, '28342048', '30695824', '87533703', '1'),
(83, '28342048', '30695824', '63445305', '1'),
(84, '28342048', '30695824', '99360069', '1'),
(85, '28342048', '30695824', '65112456', '1'),
(86, '28342048', '30695824', '12878036', '1'),
(87, '28342048', '30695824', '54927280', '1'),
(88, '28342048', '30695824', '96152089', '1'),
(89, '28342048', '30695824', '79740918', '1'),
(90, '28342048', '30695824', '31481961', '1'),
(91, '28342048', '30695824', '49247606', '1'),
(92, '28342048', '30695824', '21584795', '1'),
(93, '28342048', '30695824', '56949569', '1'),
(94, '28342048', '30695824', '50427642', '1'),
(95, '28342048', '30695824', '21186670', '1'),
(96, '28342048', '30695824', '28949917', '1'),
(97, '28342048', '30695824', '26331108', '1'),
(98, '28342048', '30695824', '14272272', '1'),
(99, '28342048', '30695824', '16672279', '1'),
(100, '28342048', '30695824', '22845757', '1'),
(101, '28342048', '30695824', '85854403', '1'),
(102, '28342048', '30695824', '26038469', '1'),
(103, '28342048', '30695824', '20609931', '1'),
(104, '28342048', '30695824', '31169363', '1'),
(105, '28342048', '30695824', '88269255', '1'),
(106, '28342048', '30695824', '74937978', '1'),
(107, '28342048', '30695824', '26752024', '1'),
(108, '28342048', '30695824', '94323609', '1'),
(109, '28342048', '30695824', '28856519', '1'),
(110, '28342048', '30695824', '46751761', '1'),
(111, '28342048', '30695824', '55643273', '1'),
(112, '28342048', '30695824', '81114642', '1'),
(113, '28342048', '30695824', '92761844', '1'),
(114, '28342048', '30695824', '63938726', '1'),
(115, '28342048', '30695824', '66443944', '1'),
(116, '57495244', '30695824', '94011537', '1'),
(117, '57495244', '30695824', '15057219', '1'),
(118, '57495244', '30695824', '25891801', '1'),
(119, '57495244', '30695824', '94810320', '1'),
(120, '57495244', '30695824', '63575025', '1'),
(121, '57495244', '30695824', '95209771', '1'),
(122, '57495244', '30695824', '90236754', '1'),
(123, '57495244', '30695824', '98219770', '1'),
(124, '57495244', '30695824', '36857067', '1'),
(125, '57495244', '30695824', '71696496', '1'),
(126, '57495244', '30695824', '46558363', '1'),
(127, '57495244', '30695824', '19340183', '1'),
(128, '57495244', '30695824', '52785870', '1'),
(129, '57495244', '30695824', '50994074', '1'),
(130, '57495244', '30695824', '22303143', '1'),
(131, '57495244', '30695824', '55580745', '1'),
(132, '57495244', '30695824', '32020635', '1'),
(133, '57495244', '30695824', '13595180', '1'),
(134, '57495244', '30695824', '81557140', '1'),
(135, '57495244', '30695824', '69030936', '1'),
(136, '57495244', '30695824', '87883866', '1'),
(137, '57495244', '30695824', '70487617', '1'),
(138, '57495244', '30695824', '43877496', '1'),
(139, '57495244', '30695824', '69135679', '1'),
(140, '57495244', '30695824', '13330030', '1'),
(141, '57495244', '30695824', '62369409', '1'),
(142, '57495244', '30695824', '73964223', '1'),
(143, '57495244', '30695824', '51205186', '1'),
(144, '57495244', '30695824', '94539250', '1'),
(145, '57495244', '30695824', '34855411', '1'),
(146, '57495244', '30695824', '48723565', '1'),
(147, '57495244', '30695824', '71301557', '1'),
(148, '57495244', '30695824', '42367987', '1'),
(149, '57495244', '30695824', '74696803', '1'),
(150, '57495244', '30695824', '96949997', '1'),
(151, '57495244', '30695824', '74521882', '1'),
(152, '57495244', '30695824', '41727391', '1'),
(153, '57495244', '30695824', '67906954', '1'),
(154, '57495244', '30695824', '10595362', '1'),
(155, '57495244', '30695824', '45746013', '1'),
(156, '57495244', '30695824', '47258997', '1'),
(157, '57495244', '30695824', '73296625', '1'),
(158, '57495244', '30695824', '17807379', '1'),
(159, '57495244', '30695824', '57187043', '1'),
(160, '57495244', '30695824', '44599831', '1'),
(161, '57495244', '30695824', '53195001', '1'),
(162, '57495244', '30695824', '20093195', '1'),
(163, '57495244', '30695824', '72860744', '1'),
(164, '57495244', '30695824', '43396226', '1'),
(165, '57495244', '30695824', '82034814', '1'),
(166, '57495244', '30695824', '19181805', '1'),
(167, '57495244', '30695824', '68416455', '1'),
(168, '57495244', '30695824', '65273438', '1'),
(169, '57495244', '30695824', '95913565', '1'),
(170, '57495244', '30695824', '63281979', '1'),
(171, '57495244', '30695824', '69349713', '1'),
(172, '57495244', '30695824', '59430951', '1'),
(173, '57495244', '30695824', '21752409', '1'),
(174, '15781505', '30695824', '38682753', '1'),
(175, '15781505', '30695824', '20368890', '1'),
(176, '15781505', '30695824', '74956982', '1'),
(177, '15781505', '30695824', '12780879', '1'),
(178, '15781505', '30695824', '13363044', '1'),
(179, '15781505', '30695824', '87834333', '1'),
(180, '15781505', '30695824', '66945661', '1'),
(181, '15781505', '30695824', '90801623', '1'),
(182, '15781505', '30695824', '39585753', '1'),
(183, '15781505', '30695824', '90022020', '1'),
(184, '15781505', '30695824', '12000217', '1'),
(185, '15781505', '30695824', '21879650', '1'),
(186, '15781505', '30695824', '59045107', '1'),
(187, '15781505', '30695824', '69545312', '1'),
(188, '15781505', '30695824', '52741464', '1'),
(189, '15781505', '30695824', '32699805', '1'),
(190, '15781505', '30695824', '12271927', '1'),
(191, '15781505', '30695824', '37258009', '1'),
(192, '15781505', '30695824', '88347824', '1'),
(193, '15781505', '30695824', '24936937', '1'),
(194, '15781505', '30695824', '72532626', '1'),
(195, '15781505', '30695824', '59871140', '1'),
(196, '15781505', '30695824', '70802629', '1'),
(197, '15781505', '30695824', '97522691', '1'),
(198, '15781505', '30695824', '81160806', '1'),
(199, '15781505', '30695824', '45012688', '1'),
(200, '15781505', '30695824', '35379152', '1'),
(201, '15781505', '30695824', '51945031', '1'),
(202, '15781505', '30695824', '56259961', '1'),
(203, '15781505', '30695824', '72362249', '1'),
(204, '15781505', '30695824', '95227455', '1'),
(205, '15781505', '30695824', '31762743', '1'),
(206, '15781505', '30695824', '77076876', '1'),
(207, '15781505', '30695824', '30566302', '1'),
(208, '28133448', '30695824', '28166749', '1'),
(209, '28133448', '30695824', '13168430', '1'),
(210, '28133448', '30695824', '71926819', '1'),
(211, '28133448', '30695824', '91511401', '1'),
(212, '28133448', '30695824', '39274167', '1'),
(213, '28133448', '30695824', '75501563', '1'),
(214, '28133448', '30695824', '19033303', '1'),
(215, '28133448', '30695824', '32967435', '1'),
(216, '28133448', '30695824', '51373039', '1'),
(217, '28133448', '30695824', '59731389', '1'),
(218, '28133448', '30695824', '35990157', '1'),
(219, '28133448', '30695824', '43069784', '1'),
(220, '28133448', '30695824', '54705971', '1'),
(221, '28133448', '30695824', '88004335', '1'),
(222, '28133448', '30695824', '89022528', '1'),
(223, '28133448', '30695824', '25624573', '1'),
(224, '28133448', '30695824', '71897789', '1'),
(225, '28133448', '30695824', '88592943', '1'),
(226, '28133448', '30695824', '23185055', '1'),
(227, '28133448', '30695824', '25418179', '1'),
(228, '28133448', '30695824', '40955257', '1'),
(229, '28133448', '30695824', '93718508', '1'),
(230, '28133448', '30695824', '15893244', '1'),
(231, '28133448', '30695824', '56772379', '1'),
(232, '28133448', '30695824', '87903054', '1'),
(233, '28133448', '30695824', '50997149', '1'),
(234, '28133448', '30695824', '99555736', '1'),
(235, '28133448', '30695824', '15519643', '1'),
(236, '28133448', '30695824', '71297098', '1'),
(237, '28133448', '30695824', '50198659', '1'),
(238, '28133448', '30695824', '27678604', '1'),
(239, '28133448', '30695824', '13955876', '1'),
(240, '28133448', '30695824', '47561954', '1'),
(241, '28133448', '30695824', '85259730', '1'),
(242, '28133448', '30695824', '87519956', '1'),
(243, '28133448', '30695824', '19056848', '1'),
(244, '72014401', '30695824', '52683573', '1'),
(245, '72014401', '30695824', '83168516', '1'),
(246, '72014401', '30695824', '36791265', '1'),
(247, '72014401', '30695824', '49675703', '1'),
(248, '72014401', '30695824', '41946487', '1'),
(249, '72014401', '30695824', '14141904', '1'),
(250, '72014401', '30695824', '25823128', '1'),
(251, '72014401', '30695824', '92632321', '1'),
(252, '72014401', '30695824', '84629972', '1'),
(253, '72014401', '30695824', '64613351', '1'),
(254, '72014401', '30695824', '55033465', '1'),
(255, '72014401', '30695824', '61015611', '1'),
(256, '72014401', '30695824', '92377361', '1'),
(257, '72014401', '30695824', '73857216', '1'),
(258, '72014401', '30695824', '50054120', '1'),
(259, '72014401', '30695824', '78875639', '1'),
(260, '72014401', '30695824', '12395705', '1'),
(261, '72014401', '30695824', '50144497', '1'),
(262, '72014401', '30695824', '39542515', '1'),
(263, '72014401', '30695824', '34153738', '1'),
(264, '72014401', '30695824', '74638937', '1'),
(265, '72014401', '30695824', '17888401', '1'),
(266, '72014401', '30695824', '86887474', '1'),
(267, '72014401', '30695824', '30902776', '1'),
(268, '72014401', '30695824', '60823491', '1'),
(269, '72014401', '30695824', '66254896', '1'),
(270, '72014401', '30695824', '52161977', '1'),
(271, '72014401', '30695824', '46775747', '1'),
(272, '72014401', '30695824', '22468700', '1'),
(273, '72014401', '30695824', '34265020', '1'),
(274, '72014401', '30695824', '33707754', '1'),
(275, '72014401', '30695824', '92909396', '1'),
(276, '72014401', '30695824', '83539221', '1'),
(277, '72014401', '30695824', '22272105', '1'),
(278, '72014401', '30695824', '92612940', '1'),
(279, '72014401', '30695824', '35786003', '1'),
(280, '72014401', '30695824', '98716874', '1'),
(281, '72014401', '30695824', '36780473', '1'),
(282, '72014401', '30695824', '89079873', '1'),
(283, '72014401', '30695824', '89253946', '1'),
(284, '72014401', '30695824', '47607924', '1'),
(285, '72014401', '30695824', '14022572', '1'),
(286, '72014401', '30695824', '26155478', '1'),
(287, '72014401', '30695824', '95501954', '1'),
(288, '72014401', '30695824', '66555003', '1'),
(289, '72014401', '30695824', '90827516', '1'),
(290, '72014401', '30695824', '58775249', '1'),
(291, '23786782', '30695824', '65348422', '1'),
(292, '23786782', '30695824', '76634151', '1'),
(293, '23786782', '30695824', '63960672', '1'),
(294, '23786782', '30695824', '15149364', '1'),
(295, '23786782', '30695824', '71891102', '1'),
(296, '23786782', '30695824', '54067951', '1'),
(297, '23786782', '30695824', '93643676', '1'),
(298, '23786782', '30695824', '32893601', '1'),
(299, '23786782', '30695824', '68860010', '1'),
(300, '23786782', '30695824', '16282139', '1'),
(301, '23786782', '30695824', '84728098', '1'),
(302, '23786782', '30695824', '76139526', '1'),
(303, '23786782', '30695824', '78305530', '1'),
(304, '23786782', '30695824', '56024098', '1'),
(305, '23786782', '30695824', '66014225', '1'),
(306, '23786782', '30695824', '51125077', '1'),
(307, '23786782', '30695824', '79491307', '1'),
(308, '23786782', '30695824', '43778157', '1'),
(309, '23786782', '30695824', '38510461', '1'),
(310, '23786782', '30695824', '26453834', '1'),
(311, '23786782', '30695824', '54333895', '1'),
(312, '23786782', '30695824', '24203209', '1'),
(313, '23786782', '30695824', '45192209', '1'),
(314, '23786782', '30695824', '98565927', '1'),
(315, '23786782', '30695824', '56767817', '1'),
(316, '23786782', '30695824', '92041134', '1'),
(317, '23786782', '30695824', '72794880', '1'),
(318, '23786782', '30695824', '96430729', '1'),
(319, '23786782', '30695824', '26695258', '1'),
(320, '23786782', '30695824', '35908827', '1'),
(321, '23786782', '30695824', '96099051', '1'),
(322, '23786782', '30695824', '19733175', '1'),
(323, '23786782', '30695824', '88005023', '1'),
(324, '23786782', '30695824', '47398315', '1'),
(325, '23786782', '30695824', '67895150', '1'),
(326, '23786782', '30695824', '21718916', '1'),
(327, '23786782', '30695824', '75962052', '1'),
(328, '23786782', '30695824', '19391872', '1'),
(329, '23786782', '30695824', '23068493', '1'),
(330, '23786782', '30695824', '23908868', '1'),
(331, '23786782', '30695824', '45496888', '1'),
(332, '23786782', '30695824', '68925223', '1'),
(333, '23786782', '30695824', '19262857', '1'),
(334, '23786782', '30695824', '74415701', '1'),
(335, '23786782', '30695824', '51175168', '1'),
(336, '23786782', '30695824', '24071383', '1'),
(337, '23786782', '30695824', '71172727', '1'),
(338, '23786782', '30695824', '20744816', '1'),
(339, '23786782', '30695824', '94886848', '1'),
(340, '23786782', '30695824', '12112794', '1'),
(341, '23786782', '30695824', '49179617', '1'),
(342, '23786782', '30695824', '42420903', '1'),
(343, '23786782', '30695824', '79728294', '1'),
(344, '23786782', '30695824', '60454779', '1'),
(345, '23786782', '30695824', '48517593', '1'),
(346, '23786782', '30695824', '22632157', '1'),
(347, '23786782', '30695824', '93788145', '1'),
(348, '23786782', '30695824', '70586282', '1'),
(349, '23786782', '30695824', '37011470', '1'),
(350, '23786782', '30695824', '31267056', '1'),
(351, '23786782', '30695824', '19116658', '1'),
(352, '23786782', '30695824', '54193512', '1'),
(353, '23786782', '30695824', '20923146', '1'),
(354, '23786782', '30695824', '29570832', '1'),
(355, '23786782', '30695824', '87829678', '1'),
(356, '23786782', '30695824', '58736059', '1'),
(357, '23786782', '30695824', '54215241', '1'),
(358, '23786782', '30695824', '53117813', '1'),
(359, '23786782', '30695824', '61619491', '1'),
(360, '23786782', '30695824', '96721420', '1'),
(361, '23786782', '30695824', '18737733', '1'),
(362, '23786782', '30695824', '30373645', '1'),
(363, '23786782', '30695824', '96592159', '1'),
(364, '23786782', '30695824', '22787108', '1'),
(365, '23786782', '30695824', '71112698', '1'),
(366, '23786782', '30695824', '40424191', '1'),
(367, '23786782', '30695824', '86357058', '1'),
(368, '23786782', '30695824', '58017785', '1'),
(369, '23786782', '30695824', '83101503', '1'),
(370, '23786782', '30695824', '14945674', '1'),
(371, '23786782', '30695824', '33125295', '1'),
(372, '23786782', '30695824', '14176585', '1'),
(373, '23786782', '30695824', '78045521', '1'),
(374, '23786782', '30695824', '48933447', '1'),
(375, '23786782', '30695824', '72666417', '1'),
(376, '60390422', '30695824', '27988612', '1'),
(377, '60390422', '30695824', '63429229', '1'),
(378, '60390422', '30695824', '82287967', '1'),
(379, '60390422', '30695824', '55452706', '1'),
(380, '60390422', '30695824', '98012755', '1'),
(381, '60390422', '30695824', '41894207', '1'),
(382, '60390422', '30695824', '12364970', '1'),
(383, '60390422', '30695824', '95027184', '1'),
(384, '60390422', '30695824', '13536432', '1'),
(385, '60390422', '30695824', '76239869', '1'),
(386, '60390422', '30695824', '82888402', '1'),
(387, '60390422', '30695824', '58958577', '1'),
(388, '60390422', '30695824', '63582848', '1'),
(389, '60390422', '30695824', '19978490', '1'),
(390, '60390422', '30695824', '66060768', '1'),
(391, '60390422', '30695824', '92166641', '1'),
(392, '60390422', '30695824', '78751484', '1'),
(393, '60390422', '30695824', '42324661', '1'),
(394, '60390422', '30695824', '70964796', '1'),
(395, '60390422', '30695824', '34144923', '1'),
(396, '60390422', '30695824', '64459116', '1'),
(397, '60390422', '30695824', '68252664', '1'),
(398, '60390422', '30695824', '74239785', '1'),
(399, '60390422', '30695824', '20766085', '1'),
(400, '60390422', '30695824', '61625651', '1'),
(401, '60390422', '30695824', '98158116', '1'),
(402, '60390422', '30695824', '66448945', '1'),
(403, '60390422', '30695824', '49364833', '1'),
(404, '60390422', '30695824', '87531293', '1'),
(405, '60390422', '30695824', '68102674', '1'),
(406, '60390422', '30695824', '40838313', '1'),
(407, '60390422', '30695824', '21718767', '1'),
(408, '60390422', '30695824', '30030726', '1'),
(409, '60390422', '30695824', '41988092', '1'),
(410, '60390422', '30695824', '46419447', '1'),
(411, '60390422', '30695824', '80338507', '1'),
(412, '60390422', '30695824', '48495432', '1'),
(413, '60390422', '30695824', '54317546', '1'),
(414, '60390422', '30695824', '34116755', '1'),
(415, '60390422', '30695824', '85259894', '1'),
(416, '60390422', '30695824', '82968121', '1'),
(417, '60390422', '30695824', '10508926', '1'),
(418, '60390422', '30695824', '41734777', '1'),
(419, '60390422', '30695824', '28441785', '1'),
(420, '60390422', '30695824', '79744867', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_controls`
--
ALTER TABLE `admin_controls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_login`
--
ALTER TABLE `admin_login`
  ADD PRIMARY KEY (`id`),
  ADD KEY `token` (`token`);

--
-- Indexes for table `admin_notification`
--
ALTER TABLE `admin_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_offers`
--
ALTER TABLE `admin_offers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token_2` (`token`),
  ADD KEY `token` (`token`),
  ADD KEY `division_token` (`division_token`);

--
-- Indexes for table `daily_schedule`
--
ALTER TABLE `daily_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_daily_schedule_1` (`unit_token`),
  ADD KEY `fk_daily_schedule_2` (`sales_emp_token`);

--
-- Indexes for table `deparment`
--
ALTER TABLE `deparment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `token` (`token`);

--
-- Indexes for table `dist__stock_order`
--
ALTER TABLE `dist__stock_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `token` (`token`);

--
-- Indexes for table `employees__attachments`
--
ALTER TABLE `employees__attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_employees__attachments_1` (`employee_token`);

--
-- Indexes for table `employees__daily_summary`
--
ALTER TABLE `employees__daily_summary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_employees__daily_summary_1` (`department_token`),
  ADD KEY `fk_employees__daily_summary_2` (`employees_token`),
  ADD KEY `fk_employees__daily_summary_3` (`location_token`);

--
-- Indexes for table `employees__division_mapping`
--
ALTER TABLE `employees__division_mapping`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_token` (`employee_token`),
  ADD KEY `division_token` (`division_token`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD UNIQUE KEY `token_2` (`token`),
  ADD KEY `token` (`token`),
  ADD KEY `fk_orders_1` (`shop_token`),
  ADD KEY `fk_orders_2` (`employee_token`);

--
-- Indexes for table `orders__amount_log`
--
ALTER TABLE `orders__amount_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ orders__amount_log_1` (`order_token`);

--
-- Indexes for table `orders__items`
--
ALTER TABLE `orders__items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orders__items_1` (`order_token`),
  ADD KEY `fk_orders__items_2` (`product_token`);

--
-- Indexes for table `orders__pendingreson`
--
ALTER TABLE `orders__pendingreson`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `token` (`token`),
  ADD KEY `category_token` (`category_token`);

--
-- Indexes for table `products__category`
--
ALTER TABLE `products__category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `token` (`token`);

--
-- Indexes for table `sales__log`
--
ALTER TABLE `sales__log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`id`),
  ADD KEY `token` (`token`);

--
-- Indexes for table `shop__order_transaction`
--
ALTER TABLE `shop__order_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop__outstanding`
--
ALTER TABLE `shop__outstanding`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_shop__outstanding_1` (`shop_token`);

--
-- Indexes for table `shop__stock_history`
--
ALTER TABLE `shop__stock_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_shop__stock_history_1` (`shop_token`),
  ADD KEY `fk_shop__stock_history_2` (`product_token`);

--
-- Indexes for table `shop__stock_list`
--
ALTER TABLE `shop__stock_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shop__stock_list_1` (`products_token`),
  ADD KEY `shop__stock_list_2` (`shop_token`);

--
-- Indexes for table `shop__type`
--
ALTER TABLE `shop__type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `token` (`token`);

--
-- Indexes for table `stock__admin`
--
ALTER TABLE `stock__admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_token` (`product_token`);

--
-- Indexes for table `stock__distributor`
--
ALTER TABLE `stock__distributor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `token` (`token`);

--
-- Indexes for table `units__shop_mapping`
--
ALTER TABLE `units__shop_mapping`
  ADD PRIMARY KEY (`id`),
  ADD KEY `units__shop_mapping_1` (`shop_token`),
  ADD KEY `units__shop_mapping_2` (`unit_group_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_controls`
--
ALTER TABLE `admin_controls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_login`
--
ALTER TABLE `admin_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_notification`
--
ALTER TABLE `admin_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_offers`
--
ALTER TABLE `admin_offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `daily_schedule`
--
ALTER TABLE `daily_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `deparment`
--
ALTER TABLE `deparment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dist__stock_order`
--
ALTER TABLE `dist__stock_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `employees__attachments`
--
ALTER TABLE `employees__attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees__daily_summary`
--
ALTER TABLE `employees__daily_summary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees__division_mapping`
--
ALTER TABLE `employees__division_mapping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders__amount_log`
--
ALTER TABLE `orders__amount_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders__items`
--
ALTER TABLE `orders__items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders__pendingreson`
--
ALTER TABLE `orders__pendingreson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `products__category`
--
ALTER TABLE `products__category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sales__log`
--
ALTER TABLE `sales__log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shop`
--
ALTER TABLE `shop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=417;

--
-- AUTO_INCREMENT for table `shop__order_transaction`
--
ALTER TABLE `shop__order_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shop__outstanding`
--
ALTER TABLE `shop__outstanding`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=417;

--
-- AUTO_INCREMENT for table `shop__stock_history`
--
ALTER TABLE `shop__stock_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shop__stock_list`
--
ALTER TABLE `shop__stock_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shop__type`
--
ALTER TABLE `shop__type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stock__admin`
--
ALTER TABLE `stock__admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock__distributor`
--
ALTER TABLE `stock__distributor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `units__shop_mapping`
--
ALTER TABLE `units__shop_mapping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=421;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `daily_schedule`
--
ALTER TABLE `daily_schedule`
  ADD CONSTRAINT `fk_daily_schedule_1` FOREIGN KEY (`unit_token`) REFERENCES `units__shop_mapping` (`unit_group_token`);

--
-- Constraints for table `employees__attachments`
--
ALTER TABLE `employees__attachments`
  ADD CONSTRAINT `fk_employees__attachments_1` FOREIGN KEY (`employee_token`) REFERENCES `employees` (`token`) ON DELETE CASCADE;

--
-- Constraints for table `employees__daily_summary`
--
ALTER TABLE `employees__daily_summary`
  ADD CONSTRAINT `fk_employees__daily_summary_1` FOREIGN KEY (`department_token`) REFERENCES `deparment` (`token`),
  ADD CONSTRAINT `fk_employees__daily_summary_2` FOREIGN KEY (`employees_token`) REFERENCES `employees` (`token`);

--
-- Constraints for table `orders__amount_log`
--
ALTER TABLE `orders__amount_log`
  ADD CONSTRAINT `fk_ orders__amount_log_1` FOREIGN KEY (`order_token`) REFERENCES `orders` (`token`);

--
-- Constraints for table `orders__items`
--
ALTER TABLE `orders__items`
  ADD CONSTRAINT `fk_orders__items_1` FOREIGN KEY (`order_token`) REFERENCES `orders` (`token`),
  ADD CONSTRAINT `fk_orders__items_2` FOREIGN KEY (`product_token`) REFERENCES `products` (`token`);

--
-- Constraints for table `shop__outstanding`
--
ALTER TABLE `shop__outstanding`
  ADD CONSTRAINT `fk_shop__outstanding_1` FOREIGN KEY (`shop_token`) REFERENCES `shop` (`token`);

--
-- Constraints for table `shop__stock_history`
--
ALTER TABLE `shop__stock_history`
  ADD CONSTRAINT `fk_shop__stock_history_1` FOREIGN KEY (`shop_token`) REFERENCES `shop` (`token`),
  ADD CONSTRAINT `fk_shop__stock_history_2` FOREIGN KEY (`product_token`) REFERENCES `products` (`token`);

--
-- Constraints for table `shop__stock_list`
--
ALTER TABLE `shop__stock_list`
  ADD CONSTRAINT `shop__stock_list_1` FOREIGN KEY (`products_token`) REFERENCES `products` (`token`),
  ADD CONSTRAINT `shop__stock_list_2` FOREIGN KEY (`shop_token`) REFERENCES `shop` (`token`);

--
-- Constraints for table `units__shop_mapping`
--
ALTER TABLE `units__shop_mapping`
  ADD CONSTRAINT `units__shop_mapping_1` FOREIGN KEY (`shop_token`) REFERENCES `shop` (`token`),
  ADD CONSTRAINT `units__shop_mapping_2` FOREIGN KEY (`unit_group_token`) REFERENCES `units` (`token`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
