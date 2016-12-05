-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2016 at 04:06 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sama`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_financial_year_master`
--

CREATE TABLE IF NOT EXISTS `account_financial_year_master` (
`account_closing_id` int(11) NOT NULL,
  `soc_id` int(11) NOT NULL,
  `fy_start_date` date NOT NULL,
  `fy_end_date` date NOT NULL,
  `closed` int(11) DEFAULT '0',
  `confirmed` int(11) DEFAULT '0',
  `closed_on` datetime DEFAULT NULL,
  `confirmed_on` datetime DEFAULT NULL,
  `closed_by` int(11) DEFAULT NULL,
  `confirmed_by` int(11) DEFAULT NULL,
  `closed_signature` varchar(100) DEFAULT NULL,
  `confirmed_signature` varchar(100) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `account_financial_year_master`
--

INSERT INTO `account_financial_year_master` (`account_closing_id`, `soc_id`, `fy_start_date`, `fy_end_date`, `closed`, `confirmed`, `closed_on`, `confirmed_on`, `closed_by`, `confirmed_by`, `closed_signature`, `confirmed_signature`) VALUES
(5, 627, '2016-04-01', '2017-03-31', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 627, '2017-04-01', '2018-03-31', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 627, '2015-04-01', '2016-03-31', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `account_master`
--

CREATE TABLE IF NOT EXISTS `account_master` (
`account_id` int(11) NOT NULL,
  `account_type` varchar(15) NOT NULL,
  `account_name` varchar(35) NOT NULL,
  `account_no` varchar(45) NOT NULL,
  `amount` double NOT NULL,
  `comment` text NOT NULL,
  `ledger_id` int(10) NOT NULL,
  `group_id` int(5) NOT NULL,
  `status` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `added_on` date NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` date NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `account_master`
--

INSERT INTO `account_master` (`account_id`, `account_type`, `account_name`, `account_no`, `amount`, `comment`, `ledger_id`, `group_id`, `status`, `added_by`, `added_on`, `updated_by`, `updated_on`) VALUES
(5, 'cash', 'Pattycash', '123654', 0, 'initial entry in patty cash', 37, 6, 1, 1, '2016-09-24', 0, '0000-00-00'),
(6, 'bank', 'ICICI', '600023145', 100000, 'initial entry', 38, 5, 1, 1, '2016-09-24', 0, '0000-00-00'),
(7, 'cash', 'inhand', '145632', 50000, 'initial entry', 39, 6, 1, 1, '2016-09-24', 0, '0000-00-00'),
(8, 'bank', 'HDFC', '123654', 15000, 'initial entry', 40, 5, 1, 1, '2016-09-24', 0, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `account_start_master`
--

CREATE TABLE IF NOT EXISTS `account_start_master` (
`account_start_master_id` int(11) NOT NULL,
  `fy_start_from` varchar(45) NOT NULL,
  `starting_fy` varchar(45) DEFAULT NULL,
  `soc_id` int(11) NOT NULL,
  `accounting_start_date` date DEFAULT NULL,
  `add_on` datetime NOT NULL,
  `added_by` int(11) NOT NULL,
  `modified_on` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `account_start_master`
--

INSERT INTO `account_start_master` (`account_start_master_id`, `fy_start_from`, `starting_fy`, `soc_id`, `accounting_start_date`, `add_on`, `added_by`, `modified_on`, `modified_by`) VALUES
(2, '04-01', '2015-2016', 627, '2016-04-01', '2016-02-12 12:19:34', 589, '2016-02-12 12:19:34', 589);

-- --------------------------------------------------------

--
-- Table structure for table `advance_salary`
--

CREATE TABLE IF NOT EXISTS `advance_salary` (
`id` int(11) NOT NULL,
  `transaction_date` datetime NOT NULL,
  `ledger_account_id` int(11) NOT NULL,
  `ledger_account_name` varchar(40) NOT NULL,
  `transaction_amount` float NOT NULL,
  `memo_desc` text NOT NULL,
  `salary_month` varchar(20) NOT NULL,
  `salary_year` varchar(40) NOT NULL,
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `alert_notification`
--

CREATE TABLE IF NOT EXISTS `alert_notification` (
`notify_id` int(11) NOT NULL,
  `notify_purpose` enum('driver','user','customer','vehicle','booking') DEFAULT 'user',
  `notify_name` varchar(20) DEFAULT NULL,
  `notify_value` text,
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `booking_master`
--

CREATE TABLE IF NOT EXISTS `booking_master` (
`booking_id` int(11) NOT NULL,
  `booking_date` datetime NOT NULL,
  `new_booking_date` datetime DEFAULT NULL,
  `cust_id` int(11) NOT NULL,
  `booked_by` int(11) DEFAULT NULL,
  `booked_on` datetime NOT NULL,
  `pickup_location` text NOT NULL,
  `drop_location` text,
  `no_of_persons` int(5) DEFAULT NULL,
  `vehicle_type` int(5) NOT NULL,
  `travel_type` enum('Local','Outstation','','') NOT NULL COMMENT 'local,outstation',
  `package_id` int(11) NOT NULL,
  `admin_status` varchar(20) DEFAULT NULL,
  `booking_status` int(11) DEFAULT NULL,
  `cancel_by` int(5) DEFAULT NULL,
  `cancel_comment` text,
  `duty_slip_id` int(11) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `booking_master`
--

INSERT INTO `booking_master` (`booking_id`, `booking_date`, `new_booking_date`, `cust_id`, `booked_by`, `booked_on`, `pickup_location`, `drop_location`, `no_of_persons`, `vehicle_type`, `travel_type`, `package_id`, `admin_status`, `booking_status`, `cancel_by`, `cancel_comment`, `duty_slip_id`, `added_by`, `added_on`, `updated_by`, `updated_on`) VALUES
(3, '2016-09-30 04:00:00', '2016-09-30 04:00:00', 4, NULL, '2016-09-24 03:30:20', 'Panvel', 'karad', 2, 12, 'Outstation', 6, NULL, 1, NULL, '', 6, 1, '2016-09-24 03:23:02', 1, '2016-09-24 03:30:20');

-- --------------------------------------------------------

--
-- Table structure for table `company_holidays`
--

CREATE TABLE IF NOT EXISTS `company_holidays` (
`holiday_id` int(11) NOT NULL,
  `holiday_date` date NOT NULL,
  `holiday_desc` text NOT NULL,
  `month` varchar(20) NOT NULL,
  `year` varchar(20) NOT NULL,
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `company_holidays`
--

INSERT INTO `company_holidays` (`holiday_id`, `holiday_date`, `holiday_desc`, `month`, `year`, `added_by`, `added_on`, `updated_by`, `updated_on`) VALUES
(1, '2016-09-18', 'sunday', '', '', 1, '2016-09-17 03:26:07', 0, '0000-00-00 00:00:00'),
(2, '2016-09-25', 'Holiday- Sunday', '', '', 1, '2016-09-24 12:38:52', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `contractors_master`
--

CREATE TABLE IF NOT EXISTS `contractors_master` (
`contractor_id` int(11) NOT NULL,
  `contractor_name` varchar(145) NOT NULL,
  `contractor_number` varchar(45) DEFAULT NULL,
  `contractor_contact_number` varchar(45) NOT NULL,
  `contractor_phone_number` varchar(45) DEFAULT NULL,
  `contractor_email` varchar(100) DEFAULT NULL,
  `contractor_notes` varchar(145) DEFAULT NULL,
  `contractor_expense_group_id` int(11) DEFAULT NULL,
  `site_id` int(11) DEFAULT '0',
  `contractor_is_company` tinyint(4) DEFAULT '0',
  `contractor_credit_period` mediumint(9) DEFAULT '30',
  `contractor_service_regn` varchar(45) DEFAULT NULL,
  `contractor_pan_num` varchar(45) DEFAULT NULL,
  `contractor_section_code` varchar(45) DEFAULT NULL,
  `contractor_payee_name` varchar(45) DEFAULT NULL,
  `contractor_address` text,
  `contractor_vat` tinyint(4) DEFAULT '0',
  `contractor_cst` tinyint(4) DEFAULT '0',
  `contractor_gst` tinyint(4) DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `contractor_ledger_id` int(11) DEFAULT NULL,
  `status` enum('0','1') DEFAULT '0',
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `ledgercreated` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `contractors_master`
--

INSERT INTO `contractors_master` (`contractor_id`, `contractor_name`, `contractor_number`, `contractor_contact_number`, `contractor_phone_number`, `contractor_email`, `contractor_notes`, `contractor_expense_group_id`, `site_id`, `contractor_is_company`, `contractor_credit_period`, `contractor_service_regn`, `contractor_pan_num`, `contractor_section_code`, `contractor_payee_name`, `contractor_address`, `contractor_vat`, `contractor_cst`, `contractor_gst`, `start_date`, `end_date`, `contractor_ledger_id`, `status`, `added_by`, `added_on`, `updated_by`, `updated_on`, `ledgercreated`) VALUES
(5, 'nilesh', NULL, '9768711664', '9768711665', 'nilesh@gmail.com', 'Test vendir note', NULL, 0, 0, 30, '000123', 'CARPS4010G', '000232', 'mayur', 'test addres belapur1', 5, 5, 5, NULL, NULL, 34, '1', 1, '2016-09-24 12:51:54', 1, '2016-09-24 12:52:22', NULL),
(6, 'pingu', NULL, '9768711665', '1236447', 'ABvd@gmail.com', 'test note', NULL, 0, 0, 30, '00321', 'CARPS1045J', '000321', 'mayur', 'test address', 5, 5, 5, NULL, NULL, 35, '1', 1, '2016-09-24 12:54:18', NULL, NULL, NULL),
(7, 'mayur', NULL, '9767857957', '985779', 'abc@gmail.com', 'self declared', NULL, 1, 0, 30, '7879979795', 'BRFPP0092L', '3', 'mayurnew', 'Pancel', 127, 127, 127, NULL, NULL, 44, '1', 1, '2016-10-11 11:26:08', NULL, NULL, NULL),
(8, 'mayur1', NULL, '9767857957', '985779', 'abc@gmail.com', 'self declared', NULL, 3, 0, 30, '7879979795', 'BRFPP0092L', '3', 'mayurnew', 'ggagag', 127, 127, 127, NULL, NULL, 45, '1', 1, '2016-10-13 07:23:49', NULL, NULL, NULL),
(9, 'amar', NULL, '9767857957', '9767857957', 'abc@gmail.com', 'self declared1', NULL, 1, 0, 30, '7879979795', 'BRFPP0092L', '3', 'mayurnew', 'abcdxyz', 127, 127, 127, NULL, NULL, 46, '1', 1, '2016-10-15 07:00:48', 1, '2016-10-26 07:39:58', NULL),
(10, 'amar1', NULL, '9767857957', '985779', 'abc@gmail.com', 'self declared', NULL, 1, 0, 30, '7879979795', 'BRFPP0092L', '3', 'mayurnew', 'abcdefgh', 127, 127, 127, NULL, NULL, 47, '1', 1, '2016-10-15 07:02:36', NULL, NULL, NULL),
(11, 'amar11', NULL, '9767857957', '985779', 'abc@gmail.com', 'self declared', NULL, 3, 0, 30, '7879979795', 'BRFPP0092L', '3', 'mayurnew', 'abcdefe', 127, 127, 127, NULL, NULL, 48, '1', 1, '2016-10-15 07:04:59', NULL, NULL, NULL),
(12, 'nilesh', NULL, '9975234242', '9975234242', 'nilesh@gmail.com', 'temporary', NULL, 10, 0, 30, '12354566', 'BRFPP0092L', '333333', 'nilu', 'satara', 127, 127, 127, NULL, NULL, 52, '1', 1, '2016-10-27 08:55:14', 1, '2016-10-27 08:57:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_master`
--

CREATE TABLE IF NOT EXISTS `customer_master` (
`cust_id` int(11) NOT NULL,
  `cust_type_id` int(11) NOT NULL COMMENT '1-indivisual,2-coorporat',
  `cust_firstname` varchar(40) DEFAULT NULL,
  `cust_middlename` varchar(40) DEFAULT NULL,
  `cust_lastname` varchar(40) DEFAULT NULL,
  `cust_compname` varchar(40) DEFAULT NULL,
  `contact_per_name` varchar(40) DEFAULT NULL,
  `contact_per_desg` varchar(15) DEFAULT NULL,
  `cust_address` varchar(50) DEFAULT NULL,
  `cust_state` varchar(20) DEFAULT NULL,
  `cust_city` varchar(20) DEFAULT NULL,
  `cust_pin` int(11) DEFAULT NULL,
  `cust_telno` varchar(40) DEFAULT NULL,
  `cust_mob1` varchar(40) DEFAULT NULL,
  `cust_mob2` varchar(40) DEFAULT NULL,
  `cust_email1` varchar(30) DEFAULT NULL,
  `cust_email2` varchar(30) DEFAULT NULL,
  `cust_username` varchar(15) NOT NULL,
  `cust_password` varchar(30) NOT NULL,
  `is_service_tax` enum('0','1') NOT NULL DEFAULT '0',
  `package_id` int(11) NOT NULL,
  `isactive` tinyint(4) NOT NULL,
  `ledger_id` int(10) NOT NULL,
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `customer_master`
--

INSERT INTO `customer_master` (`cust_id`, `cust_type_id`, `cust_firstname`, `cust_middlename`, `cust_lastname`, `cust_compname`, `contact_per_name`, `contact_per_desg`, `cust_address`, `cust_state`, `cust_city`, `cust_pin`, `cust_telno`, `cust_mob1`, `cust_mob2`, `cust_email1`, `cust_email2`, `cust_username`, `cust_password`, `is_service_tax`, `package_id`, `isactive`, `ledger_id`, `added_by`, `added_on`, `updated_by`, `updated_on`) VALUES
(4, 1, 'suraj', 'bhosle', 'bhosle', 'bhoslecmp', 'suraj', 'sw', 'test address belpaur', 'maharshtra', 'mumbai', 410206, '9874563', '9768711662', '9845632145', 'suraj@gmail.com', '', 'suraj', '4dd49f4f84e4d6945e3bc6d1481200', '0', 7, 1, 0, 1, '2016-09-24 01:16:21', 1, '2016-09-24 01:16:21');

-- --------------------------------------------------------

--
-- Table structure for table `customer_type_master`
--

CREATE TABLE IF NOT EXISTS `customer_type_master` (
`customer_type_id` int(11) NOT NULL,
  `customer_type_name` varchar(45) NOT NULL,
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `driver_salary_paid`
--

CREATE TABLE IF NOT EXISTS `driver_salary_paid` (
`id` int(11) NOT NULL,
  `transaction_date` datetime NOT NULL,
  `ledger_account_id` int(11) NOT NULL,
  `transaction_amount` float NOT NULL,
  `memo_desc` text NOT NULL,
  `salary_month` varchar(20) NOT NULL,
  `salary_year` varchar(40) NOT NULL,
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `duty_sleep_master`
--

CREATE TABLE IF NOT EXISTS `duty_sleep_master` (
`duty_sleep_id` int(11) NOT NULL,
  `vehicle_id` int(5) NOT NULL,
  `driver_id` int(5) NOT NULL,
  `total_kms` float(10,2) DEFAULT NULL,
  `extra_kms` float(10,2) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `extra_hrs` float(10,2) DEFAULT NULL,
  `total_hrs` float(10,2) DEFAULT NULL,
  `toll_fess` float(10,2) DEFAULT NULL,
  `parking_fees` float(10,2) DEFAULT NULL,
  `advance_paid` float(10,2) DEFAULT NULL,
  `total_amt` float(10,2) DEFAULT NULL,
  `booking_id` int(5) NOT NULL,
  `comments` text,
  `payment_status` int(5) DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `duty_sleep_master`
--

INSERT INTO `duty_sleep_master` (`duty_sleep_id`, `vehicle_id`, `driver_id`, `total_kms`, `extra_kms`, `start_date`, `end_date`, `extra_hrs`, `total_hrs`, `toll_fess`, `parking_fees`, `advance_paid`, `total_amt`, `booking_id`, `comments`, `payment_status`, `status`, `added_by`, `added_on`, `updated_by`, `updated_on`) VALUES
(6, 24, 6, 1000.10, 700.10, '2016-09-24 00:00:00', '2016-09-25 00:00:00', 5.15, 15.15, 1500.10, 200.50, NULL, 10706.75, 3, 'test booking', 1, 1, 1, '2016-09-24 03:35:08', 1, '2016-09-24 03:55:40');

-- --------------------------------------------------------

--
-- Table structure for table `extra_allowance`
--

CREATE TABLE IF NOT EXISTS `extra_allowance` (
`allowance_id` int(11) NOT NULL,
  `allowance_type` varchar(20) NOT NULL,
  `allowance_value` double DEFAULT NULL,
  `allowance_context` varchar(20) DEFAULT NULL,
  `allowance_comment` text,
  `isactive` enum('0','1') NOT NULL DEFAULT '0',
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE IF NOT EXISTS `inventory` (
`inventory_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` float NOT NULL,
  `total_amt` float NOT NULL,
  `inventory_status` int(11) NOT NULL COMMENT '1-inward, 0-outward',
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_map`
--

CREATE TABLE IF NOT EXISTS `inventory_map` (
`inventory_map_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL COMMENT 'product_id',
  `s_id` int(11) NOT NULL COMMENT 'site_id',
  `v_id` int(11) NOT NULL,
  `qty` float NOT NULL,
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_master`
--

CREATE TABLE IF NOT EXISTS `invoice_master` (
`invoice_id` int(11) NOT NULL,
  `invoice_no` varchar(20) NOT NULL,
  `booking_id` int(10) NOT NULL,
  `duty_sleep_id` int(10) DEFAULT NULL,
  `invoice_start_date` datetime DEFAULT NULL,
  `invoice_date` datetime DEFAULT NULL,
  `payment_mode` enum('cash','cheque','card','online') DEFAULT NULL,
  `payment_status` varchar(40) NOT NULL,
  `total_amount` int(20) DEFAULT NULL,
  `cheque_no` varchar(20) DEFAULT NULL,
  `cheque_date` datetime DEFAULT NULL,
  `transaction_id` varchar(20) DEFAULT NULL,
  `bank_name` varchar(20) DEFAULT NULL,
  `status` int(5) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `invoice_master`
--

INSERT INTO `invoice_master` (`invoice_id`, `invoice_no`, `booking_id`, `duty_sleep_id`, `invoice_start_date`, `invoice_date`, `payment_mode`, `payment_status`, `total_amount`, `cheque_no`, `cheque_date`, `transaction_id`, `bank_name`, `status`, `added_by`, `added_on`, `updated_by`, `updated_on`) VALUES
(3, 'ABCD06', 3, 6, '2016-09-24 00:00:00', '2016-09-24 03:53:26', 'cash', 'paid', 10707, NULL, NULL, '0', '', 1, 1, '2016-09-24 03:53:26', 1, '2016-09-24 03:55:40');

-- --------------------------------------------------------

--
-- Table structure for table `labour_attendance`
--

CREATE TABLE IF NOT EXISTS `labour_attendance` (
`labour_attn_id` int(11) NOT NULL,
  `labour_id` int(11) NOT NULL,
  `user_check_in` datetime NOT NULL,
  `month` varchar(20) NOT NULL,
  `year` varchar(20) NOT NULL,
  `day_type` tinyint(4) NOT NULL COMMENT '1-halfday,2-full day',
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `labour_attendance`
--

INSERT INTO `labour_attendance` (`labour_attn_id`, `labour_id`, `user_check_in`, `month`, `year`, `day_type`, `added_by`, `added_on`, `updated_by`, `updated_on`) VALUES
(1, 6, '2016-10-11 06:16:16', '10', '2016', 1, 1, '2016-10-11 11:08:55', 0, '0000-00-00 00:00:00'),
(2, 7, '2016-10-11 11:09:00', '10', '2016', 2, 1, '2016-10-11 11:09:04', 0, '0000-00-00 00:00:00'),
(3, 8, '2016-10-11 11:12:27', '10', '2016', 2, 1, '2016-10-11 11:12:34', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `labour_master`
--

CREATE TABLE IF NOT EXISTS `labour_master` (
`labour_id` int(11) NOT NULL,
  `labour_fname` varchar(20) NOT NULL,
  `labour_mname` varchar(30) NOT NULL,
  `labour_lname` varchar(20) NOT NULL,
  `labour_add` varchar(40) NOT NULL,
  `labour_photo` varchar(50) NOT NULL,
  `labour_mobno` varchar(40) NOT NULL,
  `labour_mobno1` varchar(40) NOT NULL,
  `labour_licno` varchar(20) NOT NULL,
  `labour_licexpdate` date NOT NULL,
  `labour_panno` varchar(20) NOT NULL,
  `labour_bdate` date NOT NULL,
  `labour_fix_pay` double NOT NULL,
  `labour_da` double NOT NULL,
  `labour_na` double NOT NULL,
  `is_da` enum('0','1') NOT NULL DEFAULT '0',
  `is_night_allowance` enum('0','1') NOT NULL DEFAULT '0',
  `isactive` enum('0','1') NOT NULL DEFAULT '0',
  `ledger_id` int(10) NOT NULL,
  `site_id` tinyint(1) NOT NULL,
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `labour_master`
--

INSERT INTO `labour_master` (`labour_id`, `labour_fname`, `labour_mname`, `labour_lname`, `labour_add`, `labour_photo`, `labour_mobno`, `labour_mobno1`, `labour_licno`, `labour_licexpdate`, `labour_panno`, `labour_bdate`, `labour_fix_pay`, `labour_da`, `labour_na`, `is_da`, `is_night_allowance`, `isactive`, `ledger_id`, `site_id`, `added_by`, `added_on`, `updated_by`, `updated_on`) VALUES
(6, 'Abhijeet', 'dada', 'Mote', 'Test address sewri, parel 410206', '', '9768711665', '9768711669', '', '0000-00-00', '', '1989-06-06', 0, 0, 0, '0', '0', '1', 32, 1, 1, '2016-09-24 12:25:07', 1, '2016-11-22 06:34:16'),
(7, 'Aditya', '', 'Mulik', 'test address , sion', '', '9874563210', '9874563210', 'ABC105020', '2016-12-30', 'CARSP1020G', '1989-01-03', 18000, 6500, 1200, '1', '1', '1', 33, 0, 1, '2016-09-24 12:31:05', NULL, NULL),
(8, 'mayur', 'd', 'patil', 'cbd belapur', '', '9767857957', '9922045658', '', '0000-00-00', '', '1970-01-01', 0, 0, 0, '0', '0', '1', 43, 2, 1, '2016-10-09 06:48:05', 1, '2016-10-09 10:08:06'),
(10, 'mahesh', 'B', 'bhosale', 'test', '', '9767857957', '9767857957', '', '0000-00-00', '', '2016-11-01', 0, 0, 0, '0', '0', '1', 54, 2, 1, '2016-10-27 09:36:55', NULL, NULL),
(11, 'mahesh', 'B', 'bhosale', 'test', '', '9767857957', '9767857957', '', '0000-00-00', '', '2016-10-01', 0, 0, 0, '0', '0', '1', 55, 2, 1, '2016-10-27 09:45:25', NULL, NULL),
(12, 'mahesh', 'B', 'bhosale', 'test', '', '9767857957', '9767857957', '', '0000-00-00', '', '2016-10-01', 0, 0, 0, '0', '0', '1', 56, 2, 1, '2016-10-27 09:45:36', NULL, NULL),
(13, 'mahesh', 'B', 'bhosale', 'test', '', '9767857957', '9767857957', '', '0000-00-00', '', '2016-10-01', 0, 0, 0, '0', '0', '1', 57, 2, 1, '2016-10-27 09:47:12', NULL, NULL),
(14, 'mahesh', 'B', 'bhosale', 'dd', '', '9767857957', '9767857957', '', '0000-00-00', '', '2016-11-01', 0, 0, 0, '0', '0', '1', 58, 3, 1, '2016-10-27 09:51:18', NULL, NULL),
(15, 'mahesh', 'B', 'bhosale', 'dd', '', '9767857957', '9767857957', '', '0000-00-00', '', '2016-11-01', 0, 0, 0, '0', '0', '1', 0, 3, 1, '2016-10-27 09:52:38', NULL, NULL),
(16, 'mahesh', 'B', 'bhosale', 'test', '', '9767857957', '9767857957', '', '0000-00-00', '', '2016-11-01', 0, 0, 0, '0', '0', '1', 0, 2, 1, '2016-10-27 09:53:08', NULL, NULL),
(17, 'mahesh', 'B', 'bhosale', 'test', '', '9767857957', '9767857957', '', '0000-00-00', '', '2016-11-01', 0, 0, 0, '0', '0', '1', 0, 2, 1, '2016-10-27 09:54:52', NULL, NULL),
(18, 'mahesh', 'B', 'bhosale', 'test', '', '9767857957', '9767857957', '', '0000-00-00', '', '2016-11-01', 0, 0, 0, '0', '0', '1', 59, 2, 1, '2016-10-27 09:55:30', NULL, NULL),
(19, 'mahesh1', '', 'bhosale', 'testing', '', '9767857957', '9767857957', '', '0000-00-00', '', '2016-09-26', 0, 0, 0, '0', '0', '1', 60, 2, 1, '2016-10-27 09:57:48', NULL, NULL),
(21, 'test', 'xyz', 'abcd', 'test', '', '9767857957', '9767857957', '', '0000-00-00', '', '1970-01-01', 0, 0, 0, '0', '0', '1', 62, 2, 1, '2016-11-22 07:11:01', 1, '2016-11-22 07:12:07'),
(22, 'nilesh', 'shivaji', 'ghadge', 'satara', '', '9975234242', '', '', '0000-00-00', '', '1990-02-02', 0, 0, 0, '0', '0', '1', 63, 10, 1, '2016-11-22 07:44:58', 1, '2016-11-22 07:45:43');

-- --------------------------------------------------------

--
-- Table structure for table `ledger_master`
--

CREATE TABLE IF NOT EXISTS `ledger_master` (
`ledger_account_id` int(11) NOT NULL,
  `ledger_account_name` varchar(100) NOT NULL,
  `nature_of_account` varchar(20) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `report_head` varchar(256) DEFAULT NULL,
  `operating_type` varchar(40) NOT NULL,
  `context_ref_id` int(11) DEFAULT NULL,
  `context` varchar(40) DEFAULT NULL,
  `ledger_start_date` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `entity_type` enum('main','group','ledger') NOT NULL DEFAULT 'ledger',
  `behaviour` varchar(20) DEFAULT NULL,
  `defined_by` enum('system','user') DEFAULT 'user',
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=64 ;

--
-- Dumping data for table `ledger_master`
--

INSERT INTO `ledger_master` (`ledger_account_id`, `ledger_account_name`, `nature_of_account`, `parent_id`, `report_head`, `operating_type`, `context_ref_id`, `context`, `ledger_start_date`, `status`, `entity_type`, `behaviour`, `defined_by`, `added_by`, `added_on`, `updated_by`, `updated_on`) VALUES
(1, 'asset', 'dr', 0, 'balance sheet', 'direct', 0, 'assets', '2016-07-24', 1, 'main', 'assets', 'system', 1, '2016-07-24 00:00:00', NULL, NULL),
(2, 'income', 'cr', 0, 'profit and loss', 'direct', 0, 'income', '2016-07-24', 1, 'main', 'income', 'system', 1, '2016-07-24 00:00:00', NULL, NULL),
(3, 'expense', 'dr', 0, 'profit and loss', 'direct', 0, 'expense', '2016-07-24', 1, 'main', 'expense', 'system', 1, '2016-07-24 00:00:00', NULL, NULL),
(4, 'Current Assets', 'dr', 1, 'balance sheet', 'direct', 0, 'current assets', '2016-02-11', 1, 'group', 'asset', 'system', 0, '0000-00-00 00:00:00', NULL, NULL),
(5, 'bank', 'dr', 4, 'balance sheet', '', 0, 'bank', '2016-07-24', 1, 'group', 'asset', 'system', 0, '0000-00-00 00:00:00', NULL, NULL),
(6, 'cash', 'dr', 4, 'balance sheet', '', 0, 'cash', '2016-07-24', 1, 'group', 'asset', 'system', 0, '0000-00-00 00:00:00', NULL, NULL),
(7, 'vendor', 'dr', 3, 'profit and loss', 'direct', 0, 'vendor', '2016-07-24', 1, 'group', 'expense', 'system', 0, '0000-00-00 00:00:00', NULL, NULL),
(8, 'customer', 'cr', 2, 'profit and loss', 'direct', 0, 'customer', '2016-07-24', 1, 'group', 'income', 'system', 0, '0000-00-00 00:00:00', NULL, NULL),
(9, 'driver', 'dr', 3, 'profit and loss', 'direct', 0, 'labour', '2016-07-24', 1, 'group', 'expense', 'system', 1, '2016-07-24 00:00:00', NULL, NULL),
(32, 'Abhijeet_6', 'dr', 9, 'expense', 'direct', 6, 'labour', '2016-09-24', 1, 'ledger', 'expense', 'system', 1, '2016-09-24 12:25:07', 1, '2016-11-22 06:34:16'),
(33, 'Aditya_7', 'dr', 9, 'expense', 'direct', 7, 'labour', '2016-09-24', 1, 'ledger', 'expense', 'system', 1, '2016-09-24 12:31:05', NULL, NULL),
(34, 'nilesh_5', 'dr', 7, 'expense', 'direct', 5, 'vendor', '2016-09-24', 1, 'ledger', 'expense', 'system', 1, '2016-09-24 12:51:54', 1, '2016-09-24 12:52:22'),
(35, 'pingu_6', 'dr', 7, 'expense', 'direct', 6, 'vendor', '2016-09-24', 1, 'ledger', 'expense', 'system', 1, '2016-09-24 12:54:18', NULL, NULL),
(36, 'suraj_4', 'DR', 8, 'income', '', 4, 'customer', '2016-09-24', 1, 'ledger', 'income', 'system', 1, '2016-09-24 01:13:57', NULL, NULL),
(37, 'Pattycash', 'dr', 6, 'expense', '', 5, 'cash', '2016-09-24', 1, 'ledger', 'balance sheet', 'user', 1, '2016-09-24 01:18:53', 1, '2016-09-24 01:19:01'),
(38, 'ICICI', 'dr', 5, 'balance sheet', '', 6, 'bank', '2016-09-24', 1, 'ledger', 'balance sheet', 'user', 1, '2016-09-24 01:19:41', NULL, NULL),
(39, 'inhand', 'dr', 6, 'balance sheet', '', 7, 'cash', '2016-09-24', 1, 'ledger', 'balance sheet', 'user', 1, '2016-09-24 01:20:24', NULL, NULL),
(40, 'HDFC', 'dr', 5, 'balance sheet', '', 8, 'bank', '2016-09-24', 1, 'ledger', 'balance sheet', 'user', 1, '2016-09-24 01:20:47', NULL, NULL),
(42, 'Staff', 'dr', 3, 'profit and loss', 'direct', 0, 'Staff', '2016-10-08', 1, 'group', 'expense', 'system', 1, '2016-10-08 07:14:53', NULL, NULL),
(43, 'omkar_7', 'dr', 9, 'expense', 'direct', 8, 'labour', '2016-10-09', 1, 'ledger', 'expense', 'system', 1, '2016-10-09 06:48:05', 1, '2016-10-15 10:17:29'),
(44, 'mayur_7', 'dr', 7, 'expense', 'direct', 7, 'vendor', '2016-10-11', 1, 'ledger', 'expense', 'system', 1, '2016-10-11 11:26:08', 1, '2016-10-26 07:50:03'),
(45, 'mayur1_8', 'dr', 7, 'expense', 'direct', 8, 'vendor', '2016-10-13', 1, 'ledger', 'expense', 'system', 1, '2016-10-13 07:23:49', NULL, NULL),
(46, 'amar_9', 'dr', 7, 'expense', 'direct', 9, 'vendor', '2016-10-15', 1, 'ledger', 'expense', 'system', 1, '2016-10-15 07:00:48', 1, '2016-10-26 07:39:58'),
(47, 'amar1_10', 'dr', 7, 'expense', 'direct', 10, 'vendor', '2016-10-15', 1, 'ledger', 'expense', 'system', 1, '2016-10-15 07:02:36', NULL, NULL),
(48, 'amar11_11', 'dr', 7, 'expense', 'direct', 11, 'vendor', '2016-10-15', 1, 'ledger', 'expense', 'system', 1, '2016-10-15 07:04:59', NULL, NULL),
(49, 'mayur_8', 'dr', NULL, 'expense', '', 8, 'STAFF_CONTEXT', '2016-10-15', 1, 'group', 'expense', 'system', 1, '2016-10-15 09:57:22', NULL, NULL),
(50, 'mayur_9', 'dr', 49, 'expense', '', 9, 'STAFF_CONTEXT', '2016-10-15', 1, 'group', 'expense', 'system', 1, '2016-10-15 09:57:36', NULL, NULL),
(51, 'mayurd_10', 'dr', 42, 'expense', '', 10, 'staff', '2016-10-15', 1, 'group', 'expense', 'system', 1, '2016-10-15 09:59:58', 1, '2016-10-15 10:08:29'),
(52, 'nilesh_12', 'dr', 7, 'expense', 'direct', 12, 'vendor', '2016-10-27', 1, 'ledger', 'expense', 'system', 1, '2016-10-27 08:55:14', 1, '2016-10-27 08:57:38'),
(53, 'mahesh_9', 'dr', NULL, 'expense', 'direct', 9, 'labour', '2016-10-27', 1, 'ledger', 'expense', 'system', 1, '2016-10-27 09:33:59', NULL, NULL),
(54, 'mahesh_10', 'dr', NULL, 'expense', 'direct', 10, 'labour', '2016-10-27', 1, 'ledger', 'expense', 'system', 1, '2016-10-27 09:36:55', NULL, NULL),
(55, 'mahesh_11', 'dr', NULL, 'expense', 'direct', 11, 'labour', '2016-10-27', 1, 'ledger', 'expense', 'system', 1, '2016-10-27 09:45:25', NULL, NULL),
(56, 'mahesh_12', 'dr', NULL, 'expense', 'direct', 12, 'labour', '2016-10-27', 1, 'ledger', 'expense', 'system', 1, '2016-10-27 09:45:36', NULL, NULL),
(57, 'mahesh_13', 'dr', NULL, 'expense', 'direct', 13, 'labour', '2016-10-27', 1, 'ledger', 'expense', 'system', 1, '2016-10-27 09:47:12', NULL, NULL),
(58, 'mahesh_14', 'dr', NULL, 'expense', 'direct', 14, 'labour', '2016-10-27', 1, 'ledger', 'expense', 'system', 1, '2016-10-27 09:51:18', NULL, NULL),
(59, 'mahesh_18', 'dr', 9, 'expense', 'direct', 18, 'driver', '2016-10-27', 1, 'ledger', 'expense', 'system', 1, '2016-10-27 09:55:30', NULL, NULL),
(60, 'mahesh1_19', 'dr', 9, 'expense', 'direct', 19, 'labour', '2016-10-27', 1, 'ledger', 'expense', 'system', 1, '2016-10-27 09:57:48', NULL, NULL),
(61, 'test_20', 'dr', 9, 'expense', 'direct', 20, 'labour', '2016-11-22', 1, 'ledger', 'expense', 'system', 1, '2016-11-22 06:14:25', 1, '2016-11-22 07:13:32'),
(62, 'test_21', 'dr', 9, 'expense', 'direct', 21, 'labour', '2016-11-22', 1, 'ledger', 'expense', 'system', 1, '2016-11-22 07:11:01', 1, '2016-11-22 07:12:07'),
(63, 'nilesh_22', 'dr', 9, 'expense', 'direct', 22, 'labour', '2016-11-22', 1, 'ledger', 'expense', 'system', 1, '2016-11-22 07:44:58', 1, '2016-11-22 07:45:43');

-- --------------------------------------------------------

--
-- Table structure for table `ledger_transactions`
--

CREATE TABLE IF NOT EXISTS `ledger_transactions` (
`txn_id` bigint(11) NOT NULL,
  `transaction_date` date DEFAULT NULL,
  `ledger_account_id` int(11) DEFAULT NULL,
  `site_id` int(2) NOT NULL,
  `ledger_account_name` varchar(50) DEFAULT NULL,
  `transaction_type` enum('dr','cr') DEFAULT NULL COMMENT 'debit/credit',
  `payment_mode` varchar(20) DEFAULT NULL,
  `payment_reference` varchar(256) DEFAULT NULL,
  `transaction_amount` double(14,3) DEFAULT '0.000',
  `other_reference_id` varchar(256) DEFAULT NULL,
  `txn_from_id` bigint(11) DEFAULT NULL,
  `memo_desc` varchar(256) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `ledger_transactions`
--

INSERT INTO `ledger_transactions` (`txn_id`, `transaction_date`, `ledger_account_id`, `site_id`, `ledger_account_name`, `transaction_type`, `payment_mode`, `payment_reference`, `transaction_amount`, `other_reference_id`, `txn_from_id`, `memo_desc`, `added_by`, `added_on`, `updated_by`, `updated_on`) VALUES
(1, '2016-09-24', 5, 1, 'Pattycash', 'dr', NULL, '123654', 500.000, NULL, 0, 'Initial entry for account creation', 1, '2016-09-24 01:18:53', 1, '2016-09-24 01:19:01'),
(2, '2016-09-24', 38, 1, 'ICICI', 'dr', NULL, '600023145', 100000.000, NULL, 0, 'Initial entry for account creation', 1, '2016-09-24 01:19:41', NULL, NULL),
(3, '2016-09-24', 39, 1, 'inhand', 'dr', NULL, '145632', 50000.000, NULL, 0, 'Initial entry for account creation', 1, '2016-09-24 01:20:24', NULL, NULL),
(4, '2016-09-24', 40, 0, 'HDFC', 'dr', NULL, '123654', 15000.000, NULL, 0, 'Initial entry for account creation', 1, '2016-09-24 01:20:47', NULL, NULL),
(5, '2016-09-24', 32, 0, 'Abhijeet_6', 'dr', NULL, '0001', 100.000, NULL, 0, 'to expense', 1, '2016-09-24 02:01:57', NULL, NULL),
(6, '2016-09-24', 40, 0, 'HDFC', 'cr', NULL, '0001', 100.000, NULL, 5, 'to expense', 1, '2016-09-24 02:01:57', NULL, NULL),
(7, '2016-09-24', 35, 0, 'pingu_6', 'dr', NULL, '00032', 500.000, NULL, 0, 'to expense', 1, '2016-09-24 02:02:14', NULL, NULL),
(8, '2016-09-24', 37, 0, 'Pattycash', 'cr', NULL, '00032', 500.000, NULL, 7, 'to expense', 1, '2016-09-24 02:02:14', NULL, NULL),
(9, '2016-09-24', 36, 0, 'suraj_4', 'dr', NULL, '00065', 100.000, NULL, 0, 'refund to customer', 1, '2016-09-24 02:04:28', NULL, NULL),
(10, '2016-09-24', 40, 0, 'HDFC', 'cr', NULL, '00065', 100.000, NULL, 9, 'refund to customer', 1, '2016-09-24 02:04:28', NULL, NULL),
(11, '2016-09-24', 0, 0, NULL, 'cr', NULL, 'ABCD06', 10707.000, NULL, 0, 'booking payment', 1, '2016-09-24 04:10:55', NULL, NULL),
(12, '2016-09-24', 40, 0, 'HDFC', 'dr', NULL, 'ABCD06', 10707.000, NULL, 11, 'booking payment', 1, '2016-09-24 04:10:55', NULL, NULL),
(13, '2016-10-08', 41, 0, 'Staff', 'dr', NULL, NULL, 0.000, NULL, 0, 'Initial entry for account creation', 1, '2016-10-08 07:12:22', NULL, NULL),
(14, '2016-10-15', 32, 1, 'Abhijeet_6', 'dr', NULL, '10222', 10000.000, NULL, 0, 'test', 1, '2016-10-15 07:28:51', NULL, NULL),
(15, '2016-10-15', 40, 0, 'HDFC', 'cr', NULL, '10222', 10000.000, NULL, 14, 'test', 1, '2016-10-15 07:28:51', NULL, NULL),
(16, '2016-10-15', 33, 1, 'Aditya_7', 'dr', NULL, '25511', 10000.000, NULL, 0, 'abcd', 1, '2016-10-15 07:31:14', NULL, NULL),
(17, '2016-10-15', 38, 0, 'ICICI', 'cr', NULL, '25511', 10000.000, NULL, 16, 'abcd', 1, '2016-10-15 07:31:14', NULL, NULL),
(18, '2016-10-15', 43, 4, 'mayur_8', 'dr', NULL, '', 10000.000, NULL, 0, 'test', 1, '2016-10-15 07:39:54', NULL, NULL),
(19, '2016-10-15', 39, 4, 'inhand', 'cr', NULL, '', 10000.000, NULL, 18, 'test', 1, '2016-10-15 07:39:54', NULL, NULL),
(20, '2016-10-15', 37, 10, 'Pattycash', 'dr', NULL, '', 10000.000, NULL, 0, 'petty', 1, '2016-10-15 08:21:45', NULL, NULL),
(21, '2016-11-26', 39, 12, 'inhand', 'dr', NULL, '1234', 100000.000, NULL, 0, 'test', 1, '2016-11-26 11:20:16', NULL, NULL),
(22, '2016-11-26', 39, 12, 'inhand', 'dr', NULL, '1212', 100000.000, NULL, 0, 'test', 1, '2016-11-26 11:37:30', NULL, NULL),
(23, '2016-11-26', 39, 12, 'inhand', 'dr', NULL, '1212', 100000.000, NULL, 0, 'test', 1, '2016-11-26 11:37:31', NULL, NULL),
(24, '2016-11-26', 39, 12, 'inhand', 'dr', NULL, '1212', 100000.000, NULL, 0, 'test', 1, '2016-11-26 11:37:34', NULL, NULL),
(25, '2016-11-26', 39, 12, 'inhand', 'dr', NULL, '1212', 100000.000, NULL, 0, 'test', 1, '2016-11-26 11:37:54', NULL, NULL),
(26, '2016-11-26', 39, 12, 'inhand', 'dr', NULL, '1212', 100000.000, NULL, 0, 'test', 1, '2016-11-26 11:38:43', NULL, NULL),
(27, '2016-11-26', 39, 11, 'inhand', 'dr', NULL, '', 100000.000, NULL, 0, 'test', 1, '2016-11-26 11:39:38', NULL, NULL),
(28, '2016-11-26', 39, 1, 'inhand', 'dr', NULL, '12123', 100000.000, NULL, 0, 'test', 1, '2016-11-26 11:39:58', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `package_master`
--

CREATE TABLE IF NOT EXISTS `package_master` (
`package_id` int(11) NOT NULL,
  `vehicle_cat_id` int(11) NOT NULL,
  `package_name` varchar(30) NOT NULL,
  `package_amt` int(11) DEFAULT NULL,
  `hours` double NOT NULL,
  `distance` double NOT NULL,
  `charge_distance` double NOT NULL,
  `charge_hour` double NOT NULL,
  `travel_type` varchar(100) NOT NULL COMMENT 'local,outstation',
  `isactive` tinyint(4) NOT NULL,
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `package_master`
--

INSERT INTO `package_master` (`package_id`, `vehicle_cat_id`, `package_name`, `package_amt`, `hours`, `distance`, `charge_distance`, `charge_hour`, `travel_type`, `isactive`, `added_by`, `added_on`, `updated_by`, `updated_on`) VALUES
(6, 12, 'Package', 2000, 10, 300, 10, 1, 'Outstation', 1, 1, '2016-09-24 01:10:55', NULL, NULL),
(7, 13, 'package second', 10000, 20, 1000, 10, 20, 'Local', 1, 1, '2016-09-24 01:12:32', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `passenger_details`
--

CREATE TABLE IF NOT EXISTS `passenger_details` (
`id` int(11) NOT NULL,
  `passenger_name` varchar(25) NOT NULL,
  `passenger_number` int(11) DEFAULT NULL,
  `pickup_address` text,
  `drop_address` text,
  `pickup_time` datetime DEFAULT NULL,
  `booking_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `passenger_details`
--

INSERT INTO `passenger_details` (`id`, `passenger_name`, `passenger_number`, `pickup_address`, `drop_address`, `pickup_time`, `booking_id`, `added_by`, `added_on`, `updated_by`, `updated_on`) VALUES
(3, 'mayurpatil', 2147483647, 'panvel', 'karad', NULL, 3, 1, '2016-09-24 03:23:02', 1, '2016-09-24 03:30:21'),
(4, 'omkar', 2147483647, 'panvel', 'karad', NULL, 3, 1, '2016-09-24 03:23:02', 1, '2016-09-24 03:30:21'),
(5, 'abhijeet', 2147483647, 'panvel', 'karad', NULL, 3, 1, '2016-09-24 03:23:34', 1, '2016-09-24 03:30:21');

-- --------------------------------------------------------

--
-- Table structure for table `payment_master`
--

CREATE TABLE IF NOT EXISTS `payment_master` (
`payment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `payment_type` enum('dr','cr') NOT NULL,
  `to_ledger_id` int(11) DEFAULT '0',
  `from_ledger_id` int(11) DEFAULT '0',
  `payment_amount` double(14,3) DEFAULT '0.000',
  `payment_date` date NOT NULL,
  `payment_mode` enum('cheque','card','cash') NOT NULL,
  `payment_comments` varchar(45) DEFAULT NULL,
  `payment_bank_name` varchar(75) DEFAULT NULL,
  `payment_cheque_number` varchar(15) DEFAULT NULL,
  `payment_card_num` varchar(25) DEFAULT NULL,
  `transaction_id` varchar(30) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pay_in_data`
--

CREATE TABLE IF NOT EXISTS `pay_in_data` (
`pay_in_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `pay_from` int(11) NOT NULL,
  `pay_to` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pay_out_data`
--

CREATE TABLE IF NOT EXISTS `pay_out_data` (
`pay_out_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `pay_from` int(11) NOT NULL,
  `pay_to` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_master`
--

CREATE TABLE IF NOT EXISTS `product_master` (
`p_id` int(11) NOT NULL,
  `p_name` varchar(100) NOT NULL,
  `p_desc` text NOT NULL,
  `p_unit` int(11) NOT NULL,
  `p_unit_price` float NOT NULL,
  `isactive` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `site_master`
--

CREATE TABLE IF NOT EXISTS `site_master` (
`site_id` int(11) NOT NULL,
  `site_name` varchar(200) NOT NULL,
  `address` text NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `total_amount` double NOT NULL,
  `spend_amount` double NOT NULL,
  `pay_slabs` int(11) NOT NULL,
  `comment` varchar(50) NOT NULL,
  `created_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  `isactive` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `site_master`
--

INSERT INTO `site_master` (`site_id`, `site_name`, `address`, `start_date`, `end_date`, `total_amount`, `spend_amount`, `pay_slabs`, `comment`, `created_by`, `added_on`, `updated_by`, `updated_on`, `isactive`) VALUES
(1, 'abce', 'das', '2016-07-18 00:00:00', '2016-07-06 00:00:00', 122, 1233, 0, '0000-00-00', 1, '2016-07-30 00:00:00', 1, '2016-08-05 05:49:55', 1),
(2, 'asa', 'das', '2016-07-18 00:00:00', '2016-07-06 00:00:00', 122, 1233, 0, '0000-00-00', 1, '2016-07-30 00:00:00', 0, '0000-00-00 00:00:00', 1),
(3, 'asa', 'das', '2016-07-18 00:00:00', '2016-07-06 00:00:00', 122, 1233, 0, '0000-00-00', 1, '2016-07-30 00:00:00', 0, '0000-00-00 00:00:00', 1),
(4, 'asa', 'das', '2016-07-18 00:00:00', '2016-07-06 00:00:00', 122, 1233, 0, '0000-00-00', 1, '2016-07-30 00:00:00', 0, '0000-00-00 00:00:00', 1),
(5, 'asa', 'das', '2016-07-18 00:00:00', '2016-07-06 00:00:00', 122, 1233, 0, '0000-00-00', 1, '2016-07-30 00:00:00', 0, '0000-00-00 00:00:00', 1),
(6, 'asa', 'das', '2016-07-18 00:00:00', '2016-07-06 00:00:00', 122, 1233, 0, '0000-00-00', 1, '2016-07-30 00:00:00', 0, '0000-00-00 00:00:00', 1),
(7, 'asa', 'das', '2016-09-07 00:00:00', '2016-09-08 00:00:00', 10000, 1566, 0, '0000-00-00', 1, '2016-08-01 00:00:00', 0, '0000-00-00 00:00:00', 1),
(8, 'asa', 'das', '2016-08-25 00:00:00', '2016-08-11 00:00:00', 122, 1233, 0, '0000-00-00', 1, '2016-08-01 00:00:00', 0, '0000-00-00 00:00:00', 1),
(9, 'asa', 'das', '2016-08-08 00:00:00', '0000-00-00 00:00:00', 122, 1233, 0, '0000-00-00', 1, '2016-08-08 00:00:00', 0, '0000-00-00 00:00:00', 1),
(10, 'vinayak corner', 'panvel karanjade', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1000000, 0, 0, '0000-00-00', 1, '2016-10-11 00:00:00', 0, '0000-00-00 00:00:00', 1),
(11, 'ganesh apartment', '11,sec-4,cbd belapur', '1970-01-01 00:00:00', '1970-01-01 00:00:00', 2000000, 0, 0, 'completed', 1, '2016-11-22 00:00:00', 1, '2016-11-22 00:00:00', 1),
(12, 'ganesh apartment1', 'panvel', '2016-11-15 00:00:00', '1970-01-01 00:00:00', 100000, 0, 20, 'no comment', 1, '2016-11-22 00:00:00', 1, '2016-11-22 00:00:00', 1),
(13, 'aasa', 'aasas', '2016-11-16 00:00:00', '0000-00-00 00:00:00', 2121212, 0, 22, '', 1, '2016-11-22 00:00:00', 0, '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `slab_wise_payment`
--

CREATE TABLE IF NOT EXISTS `slab_wise_payment` (
`slab_wise_pay_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `slab_no` int(11) NOT NULL,
  `pay_amt` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `added_by` tinyint(4) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `slab_wise_payment`
--

INSERT INTO `slab_wise_payment` (`slab_wise_pay_id`, `site_id`, `slab_no`, `pay_amt`, `added_on`, `added_by`) VALUES
(1, 12, 2, 100000, '2016-11-26 11:37:30', 1),
(2, 12, 2, 100000, '2016-11-26 11:37:31', 1),
(3, 12, 2, 100000, '2016-11-26 11:37:34', 1),
(4, 12, 2, 100000, '2016-11-26 11:37:54', 1),
(5, 12, 1, 100000, '2016-11-26 11:38:43', 1),
(6, 1, 1, 100000, '2016-11-26 11:39:58', 1);

-- --------------------------------------------------------

--
-- Table structure for table `staff_master`
--

CREATE TABLE IF NOT EXISTS `staff_master` (
`staff_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT '0',
  `staff_first_name` varchar(100) NOT NULL,
  `staff_last_name` varchar(100) DEFAULT NULL,
  `staff_badge_number` varchar(45) DEFAULT NULL,
  `staff_contact_number` varchar(20) NOT NULL,
  `staff_email_id` varchar(100) DEFAULT NULL,
  `staff_basic_pay` int(11) NOT NULL,
  `staff_address_1` varchar(100) NOT NULL,
  `staff_address_2` varchar(100) DEFAULT NULL,
  `staff_gender` varchar(1) NOT NULL,
  `staff_dob` date NOT NULL,
  `staff_qualification` varchar(100) DEFAULT NULL,
  `staff_skill` text,
  `access_id` varchar(45) DEFAULT NULL,
  `added_on` datetime DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `status` enum('0','1') NOT NULL,
  `users_master_user_id` int(11) DEFAULT '0',
  `staff_type_id` int(11) NOT NULL DEFAULT '0',
  `staff_proof` varchar(225) DEFAULT NULL,
  `staff_image` varchar(145) DEFAULT NULL,
  `staff_rfid` varchar(145) DEFAULT NULL,
  `staff_note` varchar(225) DEFAULT NULL,
  `ledger_account_id` int(11) DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `staff_master`
--

INSERT INTO `staff_master` (`staff_id`, `user_id`, `staff_first_name`, `staff_last_name`, `staff_badge_number`, `staff_contact_number`, `staff_email_id`, `staff_basic_pay`, `staff_address_1`, `staff_address_2`, `staff_gender`, `staff_dob`, `staff_qualification`, `staff_skill`, `access_id`, `added_on`, `modified_on`, `status`, `users_master_user_id`, `staff_type_id`, `staff_proof`, `staff_image`, `staff_rfid`, `staff_note`, `ledger_account_id`) VALUES
(1, 0, 'Vikra', 'More', '222', '9762117405', 'abc@gmail.com', 0, 'kharghar', 'kharghar', 'M', '2016-08-09', 'MCA', NULL, NULL, '2016-08-09 09:06:14', NULL, '1', 0, 0, NULL, NULL, NULL, NULL, 36),
(2, 0, 'omkar', 'Shetye', '1234', '9762117405', 'abc@gmail.com', 40000, 'Panvel', 'Panvel', 'M', '2016-08-11', 'MCA', NULL, NULL, '2016-08-11 08:08:23', NULL, '1', 0, 0, NULL, NULL, NULL, NULL, 38),
(3, 0, 'omkar', 'Shetye', '1234', '9762117405', 'abc@gmail.com', 40000, 'Panvel', 'Panvel', 'M', '2016-08-11', 'MCA', NULL, NULL, '2016-08-11 08:08:25', NULL, '1', 0, 0, NULL, NULL, NULL, NULL, 39),
(4, 0, 'omkar', 'Shetye', '1234', '9762117405', 'abc@gmail.com', 40000, 'Panvel', 'Panvel', 'M', '2016-08-11', 'MCA', NULL, NULL, '2016-08-11 08:08:57', NULL, '1', 0, 0, NULL, NULL, NULL, NULL, 40),
(5, 0, 'omkar', 'Shetye', '1234', '9762117405', 'abc@gmail.com', 0, 'Panvel', 'Panvel', 'M', '2016-08-11', 'MCA', NULL, NULL, '2016-08-11 08:11:54', NULL, '1', 0, 0, NULL, NULL, NULL, NULL, 41),
(6, 0, 'omkar', 'Shetye', '1234', '9762117405', 'abc@gmail.com', 0, 'Panvel', 'Panvel', 'M', '2016-08-11', 'MCA', NULL, NULL, '2016-08-11 08:15:30', NULL, '1', 0, 0, NULL, NULL, NULL, NULL, 42),
(7, 0, 'omkar', 'Shetye', '1234', '9762117405', 'abc@gmail.com', 40000, 'abcd', 'abcd', 'M', '2016-08-11', 'MCA', NULL, NULL, '2016-10-15 10:17:29', NULL, '1', 0, 0, NULL, NULL, NULL, NULL, 43),
(8, 0, 'mayur', 'patil', '444445', '9767857957', 'abcd@gmail.com', 10000, 'cbd belapur', 'rabale', 'M', '2016-10-15', 'bca', NULL, NULL, '2016-10-15 09:57:22', NULL, '1', 0, 0, NULL, NULL, NULL, NULL, 49),
(9, 0, 'mayur', 'patil', '444445', '9767857957', 'abcd@gmail.com', 10000, 'cbd belapur', 'rabale', 'M', '2016-10-15', 'bca', NULL, NULL, '2016-10-15 09:57:36', NULL, '1', 0, 0, NULL, NULL, NULL, NULL, 50),
(10, 0, 'mayurd', 'patil', '444445', '9767857957', 'abcd@gmail.com', 11000, 'cbd belapur', 'rabale', 'M', '2016-10-15', 'bca', NULL, NULL, '2016-10-15 10:08:29', NULL, '1', 0, 0, NULL, NULL, NULL, NULL, 51);

-- --------------------------------------------------------

--
-- Table structure for table `users_master`
--

CREATE TABLE IF NOT EXISTS `users_master` (
`user_id` int(11) NOT NULL,
  `role` varchar(45) DEFAULT NULL,
  `user_name` varchar(45) DEFAULT NULL,
  `password` varchar(75) DEFAULT NULL,
  `user_first_name` varchar(100) DEFAULT NULL,
  `user_last_name` varchar(100) DEFAULT NULL,
  `user_email_id` varchar(100) DEFAULT NULL,
  `user_mobile_number` varchar(20) DEFAULT NULL,
  `user_profile_photo` varchar(45) DEFAULT NULL,
  `user_type` varchar(15) DEFAULT NULL,
  `user_dob` date DEFAULT NULL,
  `user_source` varchar(115) DEFAULT 'Admin',
  `user_referer` text,
  `user_gmt_time_zone` varchar(45) DEFAULT NULL,
  `ledger_id` int(10) NOT NULL,
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `logged_in` enum('0','1') DEFAULT '0',
  `is_superadmin` enum('0','1') DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users_master`
--

INSERT INTO `users_master` (`user_id`, `role`, `user_name`, `password`, `user_first_name`, `user_last_name`, `user_email_id`, `user_mobile_number`, `user_profile_photo`, `user_type`, `user_dob`, `user_source`, `user_referer`, `user_gmt_time_zone`, `ledger_id`, `added_by`, `added_on`, `updated_by`, `updated_on`, `status`, `logged_in`, `is_superadmin`) VALUES
(1, NULL, 'admin', '0192023a7bbd73250516f069df18b500', 'nilesh', 'hhhh', 'nlshsuryavanshi@gmail.com', '7896541230', 'images/user_profile/nilesh_', '', '1990-02-06', 'Admin', NULL, NULL, 0, 0, '2016-09-22 00:00:00', NULL, '2016-09-23 07:12:00', 1, '0', '0'),
(2, NULL, 'omkar', 'c3284d0f94606de1fd2af172aba15bf3', 'omkar', 'saheb', 'omkar@abc.com', '9874563210', 'images/user_profile/omkar_Koala.jpg', '', '1989-01-04', 'Admin', NULL, NULL, 0, 0, '2016-09-24 00:00:00', NULL, '2016-09-24 12:33:26', NULL, '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `user_access_logs`
--

CREATE TABLE IF NOT EXISTS `user_access_logs` (
`user_access_logs_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_ip_address` varchar(20) NOT NULL,
  `user_activity` varchar(245) NOT NULL,
  `user_name` varchar(45) NOT NULL,
  `access_url` varchar(245) NOT NULL,
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_type_master`
--

CREATE TABLE IF NOT EXISTS `user_type_master` (
`user_type_id` int(11) NOT NULL,
  `user_type_name` varchar(45) NOT NULL,
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_category`
--

CREATE TABLE IF NOT EXISTS `vehicle_category` (
`cat_id` int(11) NOT NULL,
  `cat_name` varchar(40) NOT NULL,
  `isactive` int(5) NOT NULL,
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `vehicle_category`
--

INSERT INTO `vehicle_category` (`cat_id`, `cat_name`, `isactive`, `added_by`, `added_on`, `updated_by`, `updated_on`) VALUES
(12, 'SUV', 1, 1, '2016-09-24 12:05:27', NULL, NULL),
(13, 'MINI', 1, 1, '2016-09-24 12:05:39', NULL, NULL),
(14, 'MICRO', 1, 1, '2016-09-24 12:05:49', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_details`
--

CREATE TABLE IF NOT EXISTS `vehicle_details` (
`vldetail_id` int(11) NOT NULL,
  `vehicle_id` int(10) NOT NULL,
  `cat_id` int(10) NOT NULL,
  `vehicle_name` varchar(30) DEFAULT NULL,
  `vehicle_exp_name` varchar(200) DEFAULT NULL,
  `vehicle_exp_value` varchar(200) DEFAULT NULL,
  `vehicle_Tpermitexpdate` datetime DEFAULT NULL,
  `vehicle_oilchangedate` datetime DEFAULT NULL,
  `vehicle_oilchangekm` double DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=103 ;

--
-- Dumping data for table `vehicle_details`
--

INSERT INTO `vehicle_details` (`vldetail_id`, `vehicle_id`, `cat_id`, `vehicle_name`, `vehicle_exp_name`, `vehicle_exp_value`, `vehicle_Tpermitexpdate`, `vehicle_oilchangedate`, `vehicle_oilchangekm`, `added_by`, `added_on`, `updated_by`, `updated_on`) VALUES
(93, 24, 13, 'AC', 'insurance', '2025-06-17', NULL, NULL, NULL, 1, '2016-09-24 12:07:55', 1, '2016-09-24 12:21:39'),
(94, 24, 13, 'AC', 'puc', '2017-07-19', NULL, NULL, NULL, 1, '2016-09-24 12:07:55', 1, '2016-09-24 12:08:24'),
(95, 24, 13, 'AC', 'tpermit', '2018-07-11', NULL, NULL, NULL, 1, '2016-09-24 12:07:55', 1, '2016-09-24 12:21:40'),
(96, 24, 13, 'AC', 'oilchange', '2017-02-07', NULL, NULL, NULL, 1, '2016-09-24 12:07:55', 1, '2016-09-24 12:08:24'),
(97, 24, 13, 'AC', 'oilchangekm', '200', NULL, NULL, NULL, 1, '2016-09-24 12:07:55', 1, '2016-09-24 12:21:40'),
(98, 25, 13, 'NONAC', 'insurance', '2017-07-19', NULL, NULL, NULL, 1, '2016-09-24 12:11:28', NULL, NULL),
(99, 25, 13, 'NONAC', 'puc', '2017-12-21', NULL, NULL, NULL, 1, '2016-09-24 12:11:28', 1, '2016-09-24 12:21:40'),
(100, 25, 13, 'NONAC', 'tpermit', '2017-11-22', NULL, NULL, NULL, 1, '2016-09-24 12:11:28', NULL, NULL),
(101, 25, 13, 'NONAC', 'oilchange', '2017-12-14', NULL, NULL, NULL, 1, '2016-09-24 12:11:28', 1, '2016-09-24 12:21:40'),
(102, 25, 13, 'NONAC', 'oilchangekm', '100', NULL, NULL, NULL, 1, '2016-09-24 12:11:28', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_images`
--

CREATE TABLE IF NOT EXISTS `vehicle_images` (
`image_id` int(11) NOT NULL,
  `vehicle_id` int(10) DEFAULT NULL,
  `image_size` int(10) DEFAULT NULL,
  `image_data` blob,
  `image_name` varchar(30) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `vehicle_images`
--

INSERT INTO `vehicle_images` (`image_id`, `vehicle_id`, `image_size`, `image_data`, `image_name`, `status`, `added_by`, `added_on`, `updated_by`, `updated_on`) VALUES
(6, 24, 879394, NULL, '196855333Chrysanthemum.jpg', '1', 1, '2016-09-24 12:07:55', NULL, NULL),
(7, 24, 845941, NULL, '251600477Desert.jpg', '1', 1, '2016-09-24 12:07:55', NULL, NULL),
(8, 24, 775702, NULL, '480973985Jellyfish.jpg', '1', 1, '2016-09-24 12:07:55', NULL, NULL),
(9, 25, 775702, NULL, '23668077Jellyfish.jpg', '1', 1, '2016-09-24 12:11:28', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_master`
--

CREATE TABLE IF NOT EXISTS `vehicle_master` (
`vehicle_id` int(11) NOT NULL,
  `vehicle_no` varchar(15) DEFAULT NULL,
  `vehicle_type` varchar(10) NOT NULL,
  `vehicle_model` varchar(20) DEFAULT NULL,
  `fuel_type` varchar(15) DEFAULT NULL,
  `passanger_capacity` int(11) DEFAULT NULL,
  `vehicle_category` varchar(20) DEFAULT NULL COMMENT 'SUV,SEDAN,HATCHBACK',
  `vehicle_features` varchar(50) DEFAULT NULL,
  `vehicle_insuexpdate` date DEFAULT NULL,
  `vehicle_pucexpdate` date DEFAULT NULL,
  `vehicle_Tpermitexpdate` date DEFAULT NULL,
  `vehicle_oilchangedate` date DEFAULT NULL,
  `vehicle_photos` varchar(50) DEFAULT NULL,
  `vehicle_status` int(11) DEFAULT NULL COMMENT '1-active,0-inactive',
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `vehicle_master`
--

INSERT INTO `vehicle_master` (`vehicle_id`, `vehicle_no`, `vehicle_type`, `vehicle_model`, `fuel_type`, `passanger_capacity`, `vehicle_category`, `vehicle_features`, `vehicle_insuexpdate`, `vehicle_pucexpdate`, `vehicle_Tpermitexpdate`, `vehicle_oilchangedate`, `vehicle_photos`, `vehicle_status`, `added_by`, `added_on`, `updated_by`, `updated_on`) VALUES
(24, 'MH46BCD', 'AC', 'HONDA CITY', 'Diesel', 5, '12', 'FULL AC', NULL, NULL, NULL, NULL, NULL, 1, 1, '2016-09-24 12:07:55', 1, '2016-09-24 12:21:39'),
(25, 'MHABC5645', 'NONAC', 'I20', 'Petrol', 3, '13', 'ABC,AGD', NULL, NULL, NULL, NULL, NULL, 1, 1, '2016-09-24 12:11:28', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vendors_master`
--

CREATE TABLE IF NOT EXISTS `vendors_master` (
`vendor_id` int(11) NOT NULL,
  `vendor_name` varchar(145) NOT NULL,
  `vendor_number` varchar(45) DEFAULT NULL,
  `vendor_contact_number` varchar(45) NOT NULL,
  `vendor_phone_number` varchar(45) DEFAULT NULL,
  `vendor_email` varchar(100) DEFAULT NULL,
  `vendor_notes` varchar(145) DEFAULT NULL,
  `vendor_expense_group_id` int(11) DEFAULT NULL,
  `site_id` int(11) DEFAULT '0',
  `vendor_is_company` tinyint(4) DEFAULT '0',
  `vendor_credit_period` mediumint(9) DEFAULT '30',
  `vendor_service_regn` varchar(45) DEFAULT NULL,
  `vendor_pan_num` varchar(45) DEFAULT NULL,
  `vendor_section_code` varchar(45) DEFAULT NULL,
  `vendor_payee_name` varchar(45) DEFAULT NULL,
  `vendor_address` text,
  `vendor_vat` tinyint(4) DEFAULT '0',
  `vendor_cst` tinyint(4) DEFAULT '0',
  `vendor_gst` tinyint(4) DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `vendor_ledger_id` int(11) DEFAULT NULL,
  `status` enum('0','1') DEFAULT '0',
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `ledgercreated` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `vendors_master`
--

INSERT INTO `vendors_master` (`vendor_id`, `vendor_name`, `vendor_number`, `vendor_contact_number`, `vendor_phone_number`, `vendor_email`, `vendor_notes`, `vendor_expense_group_id`, `site_id`, `vendor_is_company`, `vendor_credit_period`, `vendor_service_regn`, `vendor_pan_num`, `vendor_section_code`, `vendor_payee_name`, `vendor_address`, `vendor_vat`, `vendor_cst`, `vendor_gst`, `start_date`, `end_date`, `vendor_ledger_id`, `status`, `added_by`, `added_on`, `updated_by`, `updated_on`, `ledgercreated`) VALUES
(5, 'nilesh', NULL, '9768711664', '9768711665', 'nilesh@gmail.com', 'Test vendir note', NULL, 0, 0, 30, '000123', 'CARPS4010G', '000232', 'mayur', 'test addres belapur1', 5, 5, 5, NULL, NULL, 34, '1', 1, '2016-09-24 12:51:54', 1, '2016-09-24 12:52:22', NULL),
(6, 'pingu', NULL, '9768711665', '1236447', 'ABvd@gmail.com', 'test note', NULL, 0, 0, 30, '00321', 'CARPS1045J', '000321', 'mayur', 'test address', 5, 5, 5, NULL, NULL, 35, '1', 1, '2016-09-24 12:54:18', NULL, NULL, NULL),
(7, 'mayur', NULL, '9767857957', '9767857957', 'abc@gmail.com', 'self declared', NULL, 2, 0, 30, '7879979795', 'BRFPP0092L', '3', 'mayurnew', 'Pancel', 127, 127, 127, NULL, NULL, 44, '1', 1, '2016-10-11 11:26:08', 1, '2016-10-26 07:50:03', NULL),
(8, 'mayur1', NULL, '9767857957', '985779', 'abc@gmail.com', 'self declared', NULL, 3, 0, 30, '7879979795', 'BRFPP0092L', '3', 'mayurnew', 'ggagag', 127, 127, 127, NULL, NULL, 45, '1', 1, '2016-10-13 07:23:49', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vendor_bill_payment_details`
--

CREATE TABLE IF NOT EXISTS `vendor_bill_payment_details` (
`vendor_bill_payment_id` int(11) NOT NULL,
  `vendor_bill_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL DEFAULT '0',
  `to_ledger_id` int(11) DEFAULT '0',
  `from_ledger_id` int(11) DEFAULT '0',
  `vendor_bill_payment_amount` double(14,3) DEFAULT '0.000',
  `vendor_bill_payment_date` date NOT NULL,
  `vendor_bill_payment_mode` enum('cheque','card','cash') NOT NULL,
  `vendor_bill_payment_comments` varchar(45) DEFAULT NULL,
  `vendor_bill_payment_bank_name` varchar(75) DEFAULT NULL,
  `vendor_bill_payment_cheque_number` varchar(15) DEFAULT NULL,
  `vendor_bill_payment_card_num` varchar(4) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `status` enum('0','1','2') NOT NULL DEFAULT '0',
  `payment_status` enum('paid','unpaid') NOT NULL DEFAULT 'unpaid'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_financial_year_master`
--
ALTER TABLE `account_financial_year_master`
 ADD PRIMARY KEY (`account_closing_id`);

--
-- Indexes for table `account_master`
--
ALTER TABLE `account_master`
 ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `account_start_master`
--
ALTER TABLE `account_start_master`
 ADD PRIMARY KEY (`account_start_master_id`);

--
-- Indexes for table `advance_salary`
--
ALTER TABLE `advance_salary`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `alert_notification`
--
ALTER TABLE `alert_notification`
 ADD PRIMARY KEY (`notify_id`);

--
-- Indexes for table `booking_master`
--
ALTER TABLE `booking_master`
 ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `company_holidays`
--
ALTER TABLE `company_holidays`
 ADD PRIMARY KEY (`holiday_id`);

--
-- Indexes for table `contractors_master`
--
ALTER TABLE `contractors_master`
 ADD PRIMARY KEY (`contractor_id`);

--
-- Indexes for table `customer_master`
--
ALTER TABLE `customer_master`
 ADD PRIMARY KEY (`cust_id`);

--
-- Indexes for table `customer_type_master`
--
ALTER TABLE `customer_type_master`
 ADD PRIMARY KEY (`customer_type_id`);

--
-- Indexes for table `driver_salary_paid`
--
ALTER TABLE `driver_salary_paid`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `duty_sleep_master`
--
ALTER TABLE `duty_sleep_master`
 ADD PRIMARY KEY (`duty_sleep_id`);

--
-- Indexes for table `extra_allowance`
--
ALTER TABLE `extra_allowance`
 ADD PRIMARY KEY (`allowance_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
 ADD PRIMARY KEY (`inventory_id`);

--
-- Indexes for table `inventory_map`
--
ALTER TABLE `inventory_map`
 ADD PRIMARY KEY (`inventory_map_id`);

--
-- Indexes for table `invoice_master`
--
ALTER TABLE `invoice_master`
 ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `labour_attendance`
--
ALTER TABLE `labour_attendance`
 ADD PRIMARY KEY (`labour_attn_id`);

--
-- Indexes for table `labour_master`
--
ALTER TABLE `labour_master`
 ADD PRIMARY KEY (`labour_id`);

--
-- Indexes for table `ledger_master`
--
ALTER TABLE `ledger_master`
 ADD PRIMARY KEY (`ledger_account_id`);

--
-- Indexes for table `ledger_transactions`
--
ALTER TABLE `ledger_transactions`
 ADD PRIMARY KEY (`txn_id`);

--
-- Indexes for table `package_master`
--
ALTER TABLE `package_master`
 ADD PRIMARY KEY (`package_id`);

--
-- Indexes for table `passenger_details`
--
ALTER TABLE `passenger_details`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_master`
--
ALTER TABLE `payment_master`
 ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `pay_in_data`
--
ALTER TABLE `pay_in_data`
 ADD PRIMARY KEY (`pay_in_id`);

--
-- Indexes for table `pay_out_data`
--
ALTER TABLE `pay_out_data`
 ADD PRIMARY KEY (`pay_out_id`);

--
-- Indexes for table `product_master`
--
ALTER TABLE `product_master`
 ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `site_master`
--
ALTER TABLE `site_master`
 ADD PRIMARY KEY (`site_id`);

--
-- Indexes for table `slab_wise_payment`
--
ALTER TABLE `slab_wise_payment`
 ADD PRIMARY KEY (`slab_wise_pay_id`);

--
-- Indexes for table `staff_master`
--
ALTER TABLE `staff_master`
 ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `users_master`
--
ALTER TABLE `users_master`
 ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_access_logs`
--
ALTER TABLE `user_access_logs`
 ADD PRIMARY KEY (`user_access_logs_id`);

--
-- Indexes for table `user_type_master`
--
ALTER TABLE `user_type_master`
 ADD PRIMARY KEY (`user_type_id`);

--
-- Indexes for table `vehicle_category`
--
ALTER TABLE `vehicle_category`
 ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `vehicle_details`
--
ALTER TABLE `vehicle_details`
 ADD PRIMARY KEY (`vldetail_id`);

--
-- Indexes for table `vehicle_images`
--
ALTER TABLE `vehicle_images`
 ADD PRIMARY KEY (`image_id`);

--
-- Indexes for table `vehicle_master`
--
ALTER TABLE `vehicle_master`
 ADD PRIMARY KEY (`vehicle_id`);

--
-- Indexes for table `vendors_master`
--
ALTER TABLE `vendors_master`
 ADD PRIMARY KEY (`vendor_id`);

--
-- Indexes for table `vendor_bill_payment_details`
--
ALTER TABLE `vendor_bill_payment_details`
 ADD PRIMARY KEY (`vendor_bill_payment_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_financial_year_master`
--
ALTER TABLE `account_financial_year_master`
MODIFY `account_closing_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `account_master`
--
ALTER TABLE `account_master`
MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `account_start_master`
--
ALTER TABLE `account_start_master`
MODIFY `account_start_master_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `advance_salary`
--
ALTER TABLE `advance_salary`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `alert_notification`
--
ALTER TABLE `alert_notification`
MODIFY `notify_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `booking_master`
--
ALTER TABLE `booking_master`
MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `company_holidays`
--
ALTER TABLE `company_holidays`
MODIFY `holiday_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `contractors_master`
--
ALTER TABLE `contractors_master`
MODIFY `contractor_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `customer_master`
--
ALTER TABLE `customer_master`
MODIFY `cust_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `customer_type_master`
--
ALTER TABLE `customer_type_master`
MODIFY `customer_type_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `driver_salary_paid`
--
ALTER TABLE `driver_salary_paid`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `duty_sleep_master`
--
ALTER TABLE `duty_sleep_master`
MODIFY `duty_sleep_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `extra_allowance`
--
ALTER TABLE `extra_allowance`
MODIFY `allowance_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
MODIFY `inventory_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `inventory_map`
--
ALTER TABLE `inventory_map`
MODIFY `inventory_map_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `invoice_master`
--
ALTER TABLE `invoice_master`
MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `labour_attendance`
--
ALTER TABLE `labour_attendance`
MODIFY `labour_attn_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `labour_master`
--
ALTER TABLE `labour_master`
MODIFY `labour_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `ledger_master`
--
ALTER TABLE `ledger_master`
MODIFY `ledger_account_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT for table `ledger_transactions`
--
ALTER TABLE `ledger_transactions`
MODIFY `txn_id` bigint(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `package_master`
--
ALTER TABLE `package_master`
MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `passenger_details`
--
ALTER TABLE `passenger_details`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `payment_master`
--
ALTER TABLE `payment_master`
MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pay_in_data`
--
ALTER TABLE `pay_in_data`
MODIFY `pay_in_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pay_out_data`
--
ALTER TABLE `pay_out_data`
MODIFY `pay_out_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_master`
--
ALTER TABLE `product_master`
MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `site_master`
--
ALTER TABLE `site_master`
MODIFY `site_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `slab_wise_payment`
--
ALTER TABLE `slab_wise_payment`
MODIFY `slab_wise_pay_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `staff_master`
--
ALTER TABLE `staff_master`
MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `users_master`
--
ALTER TABLE `users_master`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_access_logs`
--
ALTER TABLE `user_access_logs`
MODIFY `user_access_logs_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_type_master`
--
ALTER TABLE `user_type_master`
MODIFY `user_type_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vehicle_category`
--
ALTER TABLE `vehicle_category`
MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `vehicle_details`
--
ALTER TABLE `vehicle_details`
MODIFY `vldetail_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=103;
--
-- AUTO_INCREMENT for table `vehicle_images`
--
ALTER TABLE `vehicle_images`
MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `vehicle_master`
--
ALTER TABLE `vehicle_master`
MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `vendors_master`
--
ALTER TABLE `vendors_master`
MODIFY `vendor_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `vendor_bill_payment_details`
--
ALTER TABLE `vendor_bill_payment_details`
MODIFY `vendor_bill_payment_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
