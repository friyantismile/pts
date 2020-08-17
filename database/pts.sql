-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2020 at 06:28 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pts`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `TOTAL_WEEKDAYS` (`date1` DATETIME, `date2` DATETIME) RETURNS DOUBLE RETURN ABS(DATEDIFF(date2, date1)) + 1

     - ABS(DATEDIFF(ADDDATE(date2, INTERVAL 1 - DAYOFWEEK(date2) DAY),

                    ADDDATE(date1, INTERVAL 1 - DAYOFWEEK(date1) DAY))) / 7 * 2

     - (DAYOFWEEK(IF(date1 < date2, date1, date2)) = 1)

     - (DAYOFWEEK(IF(date1 > date2, date1, date2)) = 7)$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_document_subject_matter`
--

CREATE TABLE `tbl_document_subject_matter` (
  `id` bigint(20) NOT NULL,
  `document_id` int(11) NOT NULL,
  `subject_matter_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_document_transaction`
--

CREATE TABLE `tbl_document_transaction` (
  `trans_id` char(30) NOT NULL,
  `barcode` char(20) DEFAULT NULL,
  `sequence` int(5) DEFAULT NULL,
  `transit_date_time` datetime DEFAULT NULL,
  `office_code` char(20) DEFAULT NULL,
  `person` char(50) DEFAULT NULL,
  `recieve_date_time` datetime DEFAULT NULL,
  `recieve_action` char(50) DEFAULT NULL,
  `route_office_code` char(20) DEFAULT NULL,
  `rel_person` char(50) DEFAULT NULL,
  `release_date_time` datetime DEFAULT NULL COMMENT 'this can be end date',
  `release_action` char(50) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `current_action` char(3) DEFAULT NULL COMMENT 'REL=Release, REC=Receive ',
  `office_time` double DEFAULT NULL,
  `transit_time` double DEFAULT NULL,
  `status` char(1) DEFAULT NULL COMMENT '1=Active 0=Inactive this is used for transactions'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_document_transaction`
--

INSERT INTO `tbl_document_transaction` (`trans_id`, `barcode`, `sequence`, `transit_date_time`, `office_code`, `person`, `recieve_date_time`, `recieve_action`, `route_office_code`, `rel_person`, `release_date_time`, `release_action`, `remarks`, `current_action`, `office_time`, `transit_time`, `status`) VALUES
('202002031514290097940', 'COI1900000001', 1, NULL, 'SMO', 'administrator', '2020-02-03 14:57:14', 'New Document Trail', 'BAC-1M-APIB', 'administrator', '2020-02-03 15:14:29', '-', '-', 'REL', 17.25, 0, '1'),
('202002031531428107130', 'COI1900000001', 1, NULL, 'SMO', 'administrator', '2020-02-03 14:57:14', 'New Document Trail', 'BAC-2MA-ARINA', 'administrator', '2020-02-03 15:31:42', '-', '-', 'REL', 34.47, 0, '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_document_type`
--

CREATE TABLE `tbl_document_type` (
  `document_code` char(5) NOT NULL,
  `document_type` char(50) DEFAULT NULL,
  `status` char(1) DEFAULT NULL COMMENT '1=Active 0=Inactive'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_document_type`
--

INSERT INTO `tbl_document_type` (`document_code`, `document_type`, `status`) VALUES
('1M', 'Public Bidding 1M', '1'),
('A2M', 'Above 2M public bidding', '1'),
('B2M', 'Below 2M public bidding', '1'),
('AMP', 'Alternative Mode of Procurement', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_email`
--

CREATE TABLE `tbl_email` (
  `host` char(100) DEFAULT NULL,
  `username` char(100) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `port` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_logs`
--

CREATE TABLE `tbl_logs` (
  `id_log` int(10) NOT NULL,
  `datetime_log` datetime DEFAULT NULL,
  `username` char(20) DEFAULT NULL,
  `action` char(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_months`
--

CREATE TABLE `tbl_months` (
  `id` int(2) UNSIGNED NOT NULL,
  `month` char(20) DEFAULT NULL,
  `value` char(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_office`
--

CREATE TABLE `tbl_office` (
  `office_code` char(50) NOT NULL,
  `office_name` char(100) DEFAULT NULL,
  `status` char(1) DEFAULT NULL COMMENT '1=Active 0=Inactive'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_office`
--

INSERT INTO `tbl_office` (`office_code`, `office_name`, `status`) VALUES
('SSC', '*City Mayor\'s Office - Security and Surveillance Coordinating Office', '1'),
('CMO', 'City Mayor\'s Office', '1'),
('ADM', 'City Administrator Office', '1'),
('HRM', 'City Human Resource Management Office', '1'),
('CLO', 'City Legal Office', '1'),
('PAA', '*City Mayor\'s Office - Bids and Awards Committee', '1'),
('CBO', 'City Budget Office', '1'),
('ZCA', 'City Assessor Office', '1'),
('CTO', 'City Treasurer Office', '1'),
('ACC', 'City Accountant Office', '1'),
('SSP', 'City Secretary / Sanguniang Panglungsod', '1'),
('CPO', 'City Planning and Development Office', '1'),
('REG', 'City Registrar Office', '1'),
('SWD', 'City Social Welfare and Development Office', '1'),
('OCV', 'City Veterinarian Office', '1'),
('OCA', 'City Agriculture Office', '1'),
('CHO', 'City Health Office', '1'),
('ENR', 'City Environment and Natural Resources Office', '1'),
('GSO', 'City General Services Office', '1'),
('DRR', 'City Disaster and Risk Reduction Management Office', '1'),
('CSD', '*City Mayor\'s Office - Computer Services Division', '1'),
('CCR', 'City Civil Registrar Office', '1'),
('BPL', '*City Mayor\'s Office - Business and Permit Licensing Office', '1'),
('IAU', '*City Mayor\'s Office - Internal Audit Unit', '1'),
('PS', '*City Mayor\'s Office - Personal Staff', '1'),
('PIO', '*City Mayor\'s Office - Public Information Office', '1'),
('CEO', 'City Engineer\'s Office', '1'),
('TOU', '*City Mayor\'s Office - Tourism Promotions Development Services Division', '1'),
('INV', '*City Mayor\'s Office - Investment', '1'),
('MUS', '*City Mayor\'s Office - Museum', '1'),
('SMO', '*City Mayor\'s Office - Secretary to the Mayor (Central Receiving Unit)', '1'),
('SDO', '*City Mayor\'s Office - Sports Development Office', '1'),
('PAM', '*City Mayor\'s Office - Protected Area Management Unit', '1'),
('HLM', '*City Mayor\'s Office - Housing and Land Management Division', '1'),
('BA', '*City Mayor\'s Office - Barangay Affairs', '1'),
('GAD', '*City Mayor\'s Office - GAD', '1'),
('BAC-1M-PRRPMP', 'BAC - PR received and prepare mode of procurement', '1'),
('BAC-1M-SMP', 'BAC - Signing of mode of procurement', '1'),
('BAC-1M-SPPC', 'BAC - Schedule for pre-procurement conference', '1'),
('BAC-1M-PPC', 'BAC - Pre-procurement conference', '1'),
('BAC-1M-PSIB', 'BAC - Preparation for schedule of invitation to bid', '1'),
('BAC-1M-APIB', 'BAC - Advertisement/Posting of Invitation to Bid', '1'),
('BAC-1M-PBC', 'BAC - Pre-bid conference', '1'),
('BAC-1M-DSRBO', 'BAC - Deadline of submission and receipt of Bid Opening', '1'),
('BAC-1M-BE', 'BAC - Bid evaluation', '1'),
('BAC-1M-PQ', 'BAC - Post qualifications', '1'),
('BAC-1M-ARINA', 'BAC - Approval of resolution/issuance of Notice of Award', '1'),
('BAC-2MB-PRRPMP', 'BAC - PR received and prepare mode of procurement', '1'),
('BAC-2MB-SMP', 'BAC - Signing of mode of procurement', '1'),
('BAC-2MB-SPPC', 'BAC â€“ Schedule for pre-procurement conference', '1'),
('BAC-2MB-PPC', 'BAC - Pre-procurement conference', '1'),
('BAC-2MB-PSIB', 'BAC - Preparation for schedule of invitation to bid', '1'),
('BAC-2MB-APIB', 'BAC â€“ Advertisement/Posting of Invitation to Bid', '1'),
('BAC-2MB-PBC', 'BAC - Pre-bid conference', '1'),
('BAC-2MB-DSRBO', 'BAC â€“ Deadline of submission and receipt of Bid Opening', '1'),
('BAC-2MB-BE', 'BAC â€“ Bid evaluation', '1'),
('BAC-2MB-PQ', 'BAC â€“ Post qualification', '1'),
('BAC-2MB-ARINA', 'BAC â€“ Approval of resolution/issuance of Notice of Award', '1'),
('BAC-2MB-INP', 'BAC - Issuance of Notice to Proceed', '1'),
('BAC-2MA-PRRPMP', 'BAC - PR received and prepare mode of procurement', '1'),
('BAC-2MA-SMP', 'BAC - Signing of mode of procurement', '1'),
('BAC-2MA-SPPC', 'BAC - Schedule for pre-procurement conference', '1'),
('BAC-2MA-PPC', 'BAC - Pre-procurement conference', '1'),
('BAC-2MA-PSIB', 'BAC - Preparation for schedule of invitation to bid', '1'),
('BAC-2MA-APIB', 'BAC â€“ Advertisement/Posting of Invitation to Bid', '1'),
('BAC-2MA-PBC', 'BAC - Pre-bid conference', '1'),
('BAC-2MA-DSRBO', 'BAC â€“ Deadline of submission and receipt of Bid Opening', '1'),
('BAC-2MA-BE', 'BAC - Bid evaluation', '1'),
('BAC-2MA-PQ', 'BAC - Post qualification', '1'),
('BAC-2MA-ARINA', 'BAC - Approval of resolution/issuance of Notice of Award', '1'),
('BAC-2MA-INP', 'BAC - Issuance of Notice to Proceed', '1'),
('GSO-AG', 'GSO - Acceptance of Goods', '1'),
('GSO-RI', 'GSO - Request for Inspection', '1'),
('GSO-PSRO', 'GSO - Preparation of SAI, RIS, OBR', '1'),
('GSO-PPAO', 'GSO - Preparation of PIS,ARE OBR', '1'),
('CBO-EAO', 'CBO-Evaluation and approval  of obligation', '1'),
('GSO-PVRB', 'GSO - Preparation of Voucher  and Release to Budget', '1'),
('CBO-VR', 'CBO - Voucher Release to Accounting', '1'),
('ACC-RVSD', 'ACC - Receiving of Voucher with Supporting Documents', '1'),
('ACC-AUDIT', 'ACC-Audit', '1'),
('ACC-RA', 'ACC - Releasing from Accounting', '1'),
('CTO-PC', 'CTO - Preparation for Check', '1'),
('CTO-AC', 'CTO - Approval of Checks', '1'),
('CTO-ACTO', 'CTO - Approval of City Treasurer\'s Office (CTO)', '1'),
('ACC-PAA', 'ACC-Preparation of Accountant Advise', '1'),
('CTO-RC', 'CTO - Releasing of Check', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_office_performance`
--

CREATE TABLE `tbl_office_performance` (
  `office_code` char(10) NOT NULL,
  `document_code` char(5) NOT NULL,
  `office_time` double DEFAULT NULL COMMENT 'in minutes'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_office_performance`
--

INSERT INTO `tbl_office_performance` (`office_code`, `document_code`, `office_time`) VALUES
('ACC', '1M', 540),
('ACC', 'A2M', 540),
('ACC', 'AMP', 540),
('ACC', 'B2M', 540),
('ACC-AUDIT', '1M', 540),
('ACC-AUDIT', 'A2M', 540),
('ACC-AUDIT', 'AMP', 540),
('ACC-AUDIT', 'B2M', 540),
('ACC-PAA', '1M', 540),
('ACC-PAA', 'A2M', 540),
('ACC-PAA', 'AMP', 540),
('ACC-PAA', 'B2M', 540),
('ACC-RA', '1M', 540),
('ACC-RA', 'A2M', 540),
('ACC-RA', 'AMP', 540),
('ACC-RA', 'B2M', 540),
('ACC-RVSD', '1M', 540),
('ACC-RVSD', 'A2M', 540),
('ACC-RVSD', 'AMP', 540),
('ACC-RVSD', 'B2M', 540),
('ADM', '1M', 540),
('ADM', 'A2M', 540),
('ADM', 'AMP', 540),
('ADM', 'B2M', 540),
('BA', '1M', 540),
('BA', 'A2M', 540),
('BA', 'AMP', 540),
('BA', 'B2M', 540),
('BAC-1M-API', '1M', 540),
('BAC-1M-API', 'A2M', 540),
('BAC-1M-API', 'AMP', 540),
('BAC-1M-API', 'B2M', 540),
('BAC-1M-ARI', '1M', 540),
('BAC-1M-ARI', 'A2M', 540),
('BAC-1M-ARI', 'AMP', 540),
('BAC-1M-ARI', 'B2M', 540),
('BAC-1M-BE', '1M', 540),
('BAC-1M-BE', 'A2M', 540),
('BAC-1M-BE', 'AMP', 540),
('BAC-1M-BE', 'B2M', 540),
('BAC-1M-DSR', '1M', 540),
('BAC-1M-DSR', 'A2M', 540),
('BAC-1M-DSR', 'AMP', 540),
('BAC-1M-DSR', 'B2M', 540),
('BAC-1M-PBC', '1M', 540),
('BAC-1M-PBC', 'A2M', 540),
('BAC-1M-PBC', 'AMP', 540),
('BAC-1M-PBC', 'B2M', 540),
('BAC-1M-PPC', '1M', 540),
('BAC-1M-PPC', 'A2M', 540),
('BAC-1M-PPC', 'AMP', 540),
('BAC-1M-PPC', 'B2M', 540),
('BAC-1M-PQ', '1M', 540),
('BAC-1M-PQ', 'A2M', 540),
('BAC-1M-PQ', 'AMP', 540),
('BAC-1M-PQ', 'B2M', 540),
('BAC-1M-PRR', '1M', 540),
('BAC-1M-PRR', 'A2M', 540),
('BAC-1M-PRR', 'AMP', 540),
('BAC-1M-PRR', 'B2M', 540),
('BAC-1M-PSI', '1M', 540),
('BAC-1M-PSI', 'A2M', 540),
('BAC-1M-PSI', 'AMP', 540),
('BAC-1M-PSI', 'B2M', 540),
('BAC-1M-SMP', '1M', 540),
('BAC-1M-SMP', 'A2M', 540),
('BAC-1M-SMP', 'AMP', 540),
('BAC-1M-SMP', 'B2M', 540),
('BAC-1M-SPP', '1M', 540),
('BAC-1M-SPP', 'A2M', 540),
('BAC-1M-SPP', 'AMP', 540),
('BAC-1M-SPP', 'B2M', 540),
('BAC-2MA-AP', '1M', 540),
('BAC-2MA-AP', 'A2M', 540),
('BAC-2MA-AP', 'AMP', 540),
('BAC-2MA-AP', 'B2M', 540),
('BAC-2MA-AR', '1M', 540),
('BAC-2MA-AR', 'A2M', 540),
('BAC-2MA-AR', 'AMP', 540),
('BAC-2MA-AR', 'B2M', 540),
('BAC-2MA-BE', '1M', 540),
('BAC-2MA-BE', 'A2M', 540),
('BAC-2MA-BE', 'AMP', 540),
('BAC-2MA-BE', 'B2M', 540),
('BAC-2MA-DS', '1M', 540),
('BAC-2MA-DS', 'A2M', 540),
('BAC-2MA-DS', 'AMP', 540),
('BAC-2MA-DS', 'B2M', 540),
('BAC-2MA-IN', '1M', 540),
('BAC-2MA-IN', 'A2M', 540),
('BAC-2MA-IN', 'AMP', 540),
('BAC-2MA-IN', 'B2M', 540),
('BAC-2MA-PB', '1M', 540),
('BAC-2MA-PB', 'A2M', 540),
('BAC-2MA-PB', 'AMP', 540),
('BAC-2MA-PB', 'B2M', 540),
('BAC-2MA-PP', '1M', 540),
('BAC-2MA-PP', 'A2M', 540),
('BAC-2MA-PP', 'AMP', 540),
('BAC-2MA-PP', 'B2M', 540),
('BAC-2MA-PQ', '1M', 540),
('BAC-2MA-PQ', 'A2M', 540),
('BAC-2MA-PQ', 'AMP', 540),
('BAC-2MA-PQ', 'B2M', 540),
('BAC-2MA-PR', '1M', 540),
('BAC-2MA-PR', 'A2M', 540),
('BAC-2MA-PR', 'AMP', 540),
('BAC-2MA-PR', 'B2M', 540),
('BAC-2MA-PS', '1M', 540),
('BAC-2MA-PS', 'A2M', 540),
('BAC-2MA-PS', 'AMP', 540),
('BAC-2MA-PS', 'B2M', 540),
('BAC-2MA-SM', '1M', 540),
('BAC-2MA-SM', 'A2M', 540),
('BAC-2MA-SM', 'AMP', 540),
('BAC-2MA-SM', 'B2M', 540),
('BAC-2MA-SP', '1M', 540),
('BAC-2MA-SP', 'A2M', 540),
('BAC-2MA-SP', 'AMP', 540),
('BAC-2MA-SP', 'B2M', 540),
('BAC-2MB-AP', '1M', 540),
('BAC-2MB-AP', 'A2M', 540),
('BAC-2MB-AP', 'AMP', 540),
('BAC-2MB-AP', 'B2M', 540),
('BAC-2MB-AR', '1M', 540),
('BAC-2MB-AR', 'A2M', 540),
('BAC-2MB-AR', 'AMP', 540),
('BAC-2MB-AR', 'B2M', 540),
('BAC-2MB-BE', '1M', 540),
('BAC-2MB-BE', 'A2M', 540),
('BAC-2MB-BE', 'AMP', 540),
('BAC-2MB-BE', 'B2M', 540),
('BAC-2MB-DS', '1M', 540),
('BAC-2MB-DS', 'A2M', 540),
('BAC-2MB-DS', 'AMP', 540),
('BAC-2MB-DS', 'B2M', 540),
('BAC-2MB-IN', '1M', 540),
('BAC-2MB-IN', 'A2M', 540),
('BAC-2MB-IN', 'AMP', 540),
('BAC-2MB-IN', 'B2M', 540),
('BAC-2MB-PB', '1M', 540),
('BAC-2MB-PB', 'A2M', 540),
('BAC-2MB-PB', 'AMP', 540),
('BAC-2MB-PB', 'B2M', 540),
('BAC-2MB-PP', '1M', 540),
('BAC-2MB-PP', 'A2M', 540),
('BAC-2MB-PP', 'AMP', 540),
('BAC-2MB-PP', 'B2M', 540),
('BAC-2MB-PQ', '1M', 540),
('BAC-2MB-PQ', 'A2M', 540),
('BAC-2MB-PQ', 'AMP', 540),
('BAC-2MB-PQ', 'B2M', 540),
('BAC-2MB-PR', '1M', 540),
('BAC-2MB-PR', 'A2M', 540),
('BAC-2MB-PR', 'AMP', 540),
('BAC-2MB-PR', 'B2M', 540),
('BAC-2MB-PS', '1M', 540),
('BAC-2MB-PS', 'A2M', 540),
('BAC-2MB-PS', 'AMP', 540),
('BAC-2MB-PS', 'B2M', 540),
('BAC-2MB-SM', '1M', 540),
('BAC-2MB-SM', 'A2M', 540),
('BAC-2MB-SM', 'AMP', 540),
('BAC-2MB-SM', 'B2M', 540),
('BAC-2MB-SP', '1M', 540),
('BAC-2MB-SP', 'A2M', 540),
('BAC-2MB-SP', 'AMP', 540),
('BAC-2MB-SP', 'B2M', 540),
('BPL', '1M', 540),
('BPL', 'A2M', 540),
('BPL', 'AMP', 540),
('BPL', 'B2M', 540),
('CBO', '1M', 540),
('CBO', 'A2M', 540),
('CBO', 'AMP', 540),
('CBO', 'B2M', 540),
('CBO-EAO', '1M', 540),
('CBO-EAO', 'A2M', 540),
('CBO-EAO', 'AMP', 540),
('CBO-EAO', 'B2M', 540),
('CBO-VR', '1M', 540),
('CBO-VR', 'A2M', 540),
('CBO-VR', 'AMP', 540),
('CBO-VR', 'B2M', 540),
('CCR', '1M', 540),
('CCR', 'A2M', 540),
('CCR', 'AMP', 540),
('CCR', 'B2M', 540),
('CEO', '1M', 540),
('CEO', 'A2M', 540),
('CEO', 'AMP', 540),
('CEO', 'B2M', 540),
('CHO', '1M', 540),
('CHO', 'A2M', 540),
('CHO', 'AMP', 540),
('CHO', 'B2M', 540),
('CLO', '1M', 540),
('CLO', 'A2M', 540),
('CLO', 'AMP', 540),
('CLO', 'B2M', 540),
('CMO', '1M', 540),
('CMO', 'A2M', 540),
('CMO', 'AMP', 540),
('CMO', 'B2M', 540),
('CPO', '1M', 540),
('CPO', 'A2M', 540),
('CPO', 'AMP', 540),
('CPO', 'B2M', 540),
('CSD', '1M', 540),
('CSD', 'A2M', 540),
('CSD', 'AMP', 540),
('CSD', 'B2M', 540),
('CTO', '1M', 540),
('CTO', 'A2M', 540),
('CTO', 'AMP', 540),
('CTO', 'B2M', 540),
('CTO-AC', '1M', 540),
('CTO-AC', 'A2M', 540),
('CTO-AC', 'AMP', 540),
('CTO-AC', 'B2M', 540),
('CTO-ACTO', '1M', 540),
('CTO-ACTO', 'A2M', 540),
('CTO-ACTO', 'AMP', 540),
('CTO-ACTO', 'B2M', 540),
('CTO-PC', '1M', 540),
('CTO-PC', 'A2M', 540),
('CTO-PC', 'AMP', 540),
('CTO-PC', 'B2M', 540),
('CTO-RC', '1M', 540),
('CTO-RC', 'A2M', 540),
('CTO-RC', 'AMP', 540),
('CTO-RC', 'B2M', 540),
('DRR', '1M', 540),
('DRR', 'A2M', 540),
('DRR', 'AMP', 540),
('DRR', 'B2M', 540),
('ENR', '1M', 540),
('ENR', 'A2M', 540),
('ENR', 'AMP', 540),
('ENR', 'B2M', 540),
('GAD', '1M', 540),
('GAD', 'A2M', 540),
('GAD', 'AMP', 540),
('GAD', 'B2M', 540),
('GSO', '1M', 540),
('GSO', 'A2M', 540),
('GSO', 'AMP', 540),
('GSO', 'B2M', 540),
('GSO-AG', '1M', 540),
('GSO-AG', 'A2M', 540),
('GSO-AG', 'AMP', 540),
('GSO-AG', 'B2M', 540),
('GSO-PPAO', '1M', 540),
('GSO-PPAO', 'A2M', 540),
('GSO-PPAO', 'AMP', 540),
('GSO-PPAO', 'B2M', 540),
('GSO-PSRO', '1M', 540),
('GSO-PSRO', 'A2M', 540),
('GSO-PSRO', 'AMP', 540),
('GSO-PSRO', 'B2M', 540),
('GSO-PVRB', '1M', 540),
('GSO-PVRB', 'A2M', 540),
('GSO-PVRB', 'AMP', 540),
('GSO-PVRB', 'B2M', 540),
('GSO-RI', '1M', 540),
('GSO-RI', 'A2M', 540),
('GSO-RI', 'AMP', 540),
('GSO-RI', 'B2M', 540),
('HLM', '1M', 540),
('HLM', 'A2M', 540),
('HLM', 'AMP', 540),
('HLM', 'B2M', 540),
('HRM', '1M', 540),
('HRM', 'A2M', 540),
('HRM', 'AMP', 540),
('HRM', 'B2M', 540),
('IAU', '1M', 540),
('IAU', 'A2M', 540),
('IAU', 'AMP', 540),
('IAU', 'B2M', 540),
('INV', '1M', 540),
('INV', 'A2M', 540),
('INV', 'AMP', 540),
('INV', 'B2M', 540),
('MUS', '1M', 540),
('MUS', 'A2M', 540),
('MUS', 'AMP', 540),
('MUS', 'B2M', 540),
('OCA', '1M', 540),
('OCA', 'A2M', 540),
('OCA', 'AMP', 540),
('OCA', 'B2M', 540),
('OCV', '1M', 540),
('OCV', 'A2M', 540),
('OCV', 'AMP', 540),
('OCV', 'B2M', 540),
('PAA', '1M', 540),
('PAA', 'A2M', 540),
('PAA', 'AMP', 540),
('PAA', 'B2M', 540),
('PAM', '1M', 540),
('PAM', 'A2M', 540),
('PAM', 'AMP', 540),
('PAM', 'B2M', 540),
('PIO', '1M', 540),
('PIO', 'A2M', 540),
('PIO', 'AMP', 540),
('PIO', 'B2M', 540),
('PS', '1M', 540),
('PS', 'A2M', 540),
('PS', 'AMP', 540),
('PS', 'B2M', 540),
('REG', '1M', 540),
('REG', 'A2M', 540),
('REG', 'AMP', 540),
('REG', 'B2M', 540),
('SDO', '1M', 540),
('SDO', 'A2M', 540),
('SDO', 'AMP', 540),
('SDO', 'B2M', 540),
('SMO', '1M', 540),
('SMO', 'A2M', 540),
('SMO', 'AMP', 540),
('SMO', 'B2M', 540),
('SSC', '1M', 540),
('SSC', 'A2M', 540),
('SSC', 'AMP', 540),
('SSC', 'B2M', 540),
('SSP', '1M', 540),
('SSP', 'A2M', 540),
('SSP', 'AMP', 540),
('SSP', 'B2M', 540),
('SWD', '1M', 540),
('SWD', 'A2M', 540),
('SWD', 'AMP', 540),
('SWD', 'B2M', 540),
('TOU', '1M', 540),
('TOU', 'A2M', 540),
('TOU', 'AMP', 540),
('TOU', 'B2M', 540),
('ZCA', '1M', 540),
('ZCA', 'A2M', 540),
('ZCA', 'AMP', 540),
('ZCA', 'B2M', 540);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_source`
--

CREATE TABLE `tbl_source` (
  `id` char(5) NOT NULL,
  `source` char(20) DEFAULT NULL,
  `status` char(1) DEFAULT NULL COMMENT '1=Active 0=Inactive'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_source`
--

INSERT INTO `tbl_source` (`id`, `source`, `status`) VALUES
('EXT', 'External', '1'),
('INT', 'Internal', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subject_matter`
--

CREATE TABLE `tbl_subject_matter` (
  `id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `subject_matter` text NOT NULL,
  `status` int(11) NOT NULL COMMENT '1-active, 0-inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_time`
--

CREATE TABLE `tbl_time` (
  `id` int(1) NOT NULL,
  `time_in` datetime DEFAULT NULL,
  `time_out` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaction_type`
--

CREATE TABLE `tbl_transaction_type` (
  `id` char(5) NOT NULL,
  `transaction` char(100) DEFAULT NULL,
  `days` int(11) DEFAULT NULL,
  `status` char(1) DEFAULT NULL COMMENT '1=Active 0=Inactive'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_transaction_type`
--

INSERT INTO `tbl_transaction_type` (`id`, `transaction`, `days`, `status`) VALUES
('1M', '1M public bidding', 111, '1'),
('A2M', 'Above 2M public bidding', 131, '1'),
('B2M', 'Below 2M public bidding', 121, '1'),
('AMP', 'Alternative Mode of Procurement', 100, '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `username` char(30) NOT NULL,
  `full_name` char(100) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `office_code` char(10) DEFAULT NULL,
  `access_level` char(1) DEFAULT NULL COMMENT 'A=Admin U=User',
  `status` char(1) DEFAULT NULL COMMENT '1=Active 0=Inactive'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`username`, `full_name`, `password`, `office_code`, `access_level`, `status`) VALUES
('admin', 'administrator', 'c4ca4238a0b923820dcc509a6f75849b', 'SMO', 'A', '1'),
('adelisa.villarin', 'Adelisa V. Villarin', '2ae7fca3e9d5b8ff656eae4b45e755a9', 'HRM', 'U', '1'),
('Thelma', 'Thelma Garcia', 'cd36ce2232efb79b7c60b18a8d3c1402', 'OCA', 'U', '1'),
('Tata', 'Maria S. Asenas', '197d0a62e78b8acf414d1e609265aeda', 'OCA', 'U', '1'),
('mila.cortez', 'Mila Cortez', '47361ee5ae847794ca197e505c5fab0f', 'SMO', 'R', '1'),
('francis.aguirre', 'Francis Aguirre', 'e10adc3949ba59abbe56e057f20f883e', 'BA', 'U', '1'),
('flordelyn.gacis', 'Flordelyn M. Gacis', 'e10adc3949ba59abbe56e057f20f883e', 'IAU', 'U', '1'),
('renor.alvarez', 'Renor Alvarez', 'e10adc3949ba59abbe56e057f20f883e', 'HRM', 'U', '1'),
('mirela.natividad', 'Mirela Natividad', 'e10adc3949ba59abbe56e057f20f883e', 'HRM', 'U', '1'),
('roberto.talaboc', 'Roberto D. Talaboc, Jr.', 'e10adc3949ba59abbe56e057f20f883e', 'HRM', 'U', '1'),
('kate.macapili.rm', 'Kate Macapili (RM)', 'b9e5f9ba5761817dea57c19f92b2ecf1', 'SMO', 'R', '1'),
('virginia.cuevas', 'Virginia Cuevas', '4025a17e2551b92d4a51bedf436bd861', 'CHO', 'U', '1'),
('jhoanna.funes', 'Jhoanna Marie Funes', 'e10adc3949ba59abbe56e057f20f883e', 'CBO', 'U', '1'),
('mariz.gonzales', 'Mariz Gonzales', '5f05b6f966568941be28dfc16b9fd062', 'CHO', 'U', '1'),
('eric.elias', 'Alexander Eric F. Elias', '25342d699e800b07268d010cf63236aa', 'CCR', 'U', '1'),
('analin.velez', 'Analin T. Velez', 'e10adc3949ba59abbe56e057f20f883e', 'CCR', 'U', '1'),
('kcabral', 'Katheleen D. Cabral', '60cea5bf6b1ef3832e8301d8382185a3', 'CCR', 'U', '1'),
('rodrigo.sicat', 'Rodrigro S. Sicat', 'd46e1fcf4c07ce4a69ee07e4134bcef1', 'CPO', 'U', '1'),
('mark.ojales', 'John Mark Ojales', 'e10adc3949ba59abbe56e057f20f883e', 'MUS', 'U', '1'),
('jio.salvador', 'Jio Salvador', 'e10adc3949ba59abbe56e057f20f883e', 'MUS', 'U', '1'),
('froilan.dancel', 'Froilan P. Dancel', 'e10adc3949ba59abbe56e057f20f883e', 'ENR', 'U', '1'),
('maribel.baes', 'Maribel M. Baes', 'e10adc3949ba59abbe56e057f20f883e', 'ENR', 'U', '1'),
('maricris.fernandez', 'Maricris C. Fernandez', 'e10adc3949ba59abbe56e057f20f883e', 'ENR', 'U', '1'),
('michael.catequista', 'Michael Catequista', 'e10adc3949ba59abbe56e057f20f883e', 'ADM', 'U', '1'),
('marlene.abrera', 'Marlene Abrera', 'a2a5b1f7acd2b4b3387186ee46424e52', 'ZCA', 'U', '1'),
('minda.bello', 'Minda Bello', 'e10adc3949ba59abbe56e057f20f883e', 'BPL', 'U', '1'),
('thess.barao', 'Thess Barao', '93b3ae3ab9244a86c879579b8e135eb6', 'IAU', 'U', '1'),
('genecis.alonzo', 'Genecis Alonzo', 'e10adc3949ba59abbe56e057f20f883e', 'CBO', 'U', '1'),
('princeralph.pidor', 'Prince Ralph S. Pidor', 'e10adc3949ba59abbe56e057f20f883e', 'CBO', 'U', '1'),
('jennifer.lacastesant', 'Jennifer T. Lacastesantos', 'e10adc3949ba59abbe56e057f20f883e', 'CBO', 'U', '1'),
('ginny.maylon', 'Ginny Maylon', 'e10adc3949ba59abbe56e057f20f883e', 'CSD', 'U', '1'),
('charisma.pelayo', 'Charisma Pelayo', 'e10adc3949ba59abbe56e057f20f883e', 'CSD', 'U', '1'),
('marites.pamintuan', 'Marites Pamintuan', 'e10adc3949ba59abbe56e057f20f883e', 'CTO', 'U', '1'),
('edramil.natividad', 'Ed ramil Natividad', 'e10adc3949ba59abbe56e057f20f883e', 'CTO', 'U', '1'),
('claire.pesebre', 'Claire Pesebre', 'e10adc3949ba59abbe56e057f20f883e', 'INV', 'U', '1'),
('rocelyn.dagohoy', 'Rocelyn Dagohoy', 'e10adc3949ba59abbe56e057f20f883e', 'CMO', 'U', '1'),
('rheaamor.falcasantos', 'Rhea Amor Falcasantos', 'e10adc3949ba59abbe56e057f20f883e', 'PIO', 'U', '1'),
('lorraine.pescadera', 'Lorraine O. Pescadera', 'e10adc3949ba59abbe56e057f20f883e', 'CPO', 'U', '1'),
('fernando.basiliojr', 'Fernando S. Basilio Jr.', 'e10adc3949ba59abbe56e057f20f883e', 'CEO', 'U', '1'),
('sheila.covarubias', 'Sheila Covarubias', 'e10adc3949ba59abbe56e057f20f883e', 'PIO', 'U', '1'),
('ermon.alegata', 'Ermon Alegata', 'e10adc3949ba59abbe56e057f20f883e', 'PIO', 'U', '1'),
('jayson.santos', 'Jayson A. Santos', 'e10adc3949ba59abbe56e057f20f883e', 'HRM', 'U', '1'),
('karen.roca', 'Karen Lissette J. Roca', 'e10adc3949ba59abbe56e057f20f883e', 'PAA', 'U', '1'),
('keiann.alabastro', 'Kei-Ann Alabastro', '57fc3da47392643a3c0260cc5f122e22', 'CHO', 'U', '1'),
('socorro.rojas', 'Ma. Socorro A. Rojas', '558482c507f24bd20f8d731728c67009', 'SWD', 'U', '1'),
('joy.dua', 'Leah May Joy B. Dua', '834a738d4556f0588300461f892fa5fb', 'SWD', 'U', '1'),
('rachel.fernandez', 'Rachel D. Fernandez', 'e10adc3949ba59abbe56e057f20f883e', 'SWD', 'U', '1'),
('abbee.mendoza', 'Abbee Kaith C. Mendoza', 'e10adc3949ba59abbe56e057f20f883e', 'TOU', 'U', '1'),
('joan.delossantos', 'Joan H. Delos Santos', 'e10adc3949ba59abbe56e057f20f883e', 'TOU', 'U', '1'),
('sigmund.mentoya', 'Sigmund T. Mentoya', '6c9cdce9f6d927cea4c621b33ca05013', 'ACC', 'U', '1'),
('ranzley.seballos', 'Ranzley Seballos', '403c0314f89857402b2863e97ed9e3d5', 'MUS', 'U', '1'),
('sharon.espina', 'Sharon Espina', 'e10adc3949ba59abbe56e057f20f883e', 'CPO', 'U', '1'),
('maritess.garcia', 'Maritess V. Garcia', '1b68f73d09c00b1729a24c3032c3bccf', 'CEO', 'U', '1'),
('martin.ignacio', 'Martin V. Ignacio', 'e10adc3949ba59abbe56e057f20f883e', 'CCR', 'U', '1'),
('alyssa.salian', 'Alyssa Mae Salian', 'e10adc3949ba59abbe56e057f20f883e', 'OCA', 'U', '1'),
('romalie.rojas', 'Romalie Rojas', 'd7222b39e76954f4e9ab31d2a347872f', 'GSO', 'U', '1'),
('rovelyn.agustin', 'Rovelyn Agustin', 'e10adc3949ba59abbe56e057f20f883e', 'GSO', 'U', '1'),
('leonard.fabian', 'Leonard Fabian', 'e10adc3949ba59abbe56e057f20f883e', 'GSO', 'U', '1'),
('cecilia.atilano', 'Cecilia Atilano', '0f7990998e988abbea7c1c0ab9c642f8', 'SDO', 'U', '1'),
('vicky.fernandez', 'Vicky Fenandez', 'e10adc3949ba59abbe56e057f20f883e', 'SDO', 'U', '1'),
('nico.campomanes', 'Nico Campomanes', 'e10adc3949ba59abbe56e057f20f883e', 'SDO', 'U', '1'),
('sheila.sapitula', 'Sheila B. Sapitula', '6ee213ee75a6a04acb70b4965d472cc9', 'CEO', 'U', '1'),
('dioscoro.sale', 'Dioscoro Sale', 'defabc7e236bfb3544b2efb2d9a7b6f7', 'SMO', 'R', '1'),
('grachelle.flora', 'Grachelle Flora', '7ce25494116df71f6c7bdad56e4d8474', 'SMO', 'R', '1'),
('leizel.luzon', 'Leizel Luzon', 'e10adc3949ba59abbe56e057f20f883e', 'IAU', 'U', '1'),
('sheena.ricarda', 'Sheena Ricarda', 'bffb8654e6adb4b704279d5e5bb0a372', 'SMO', 'R', '1'),
('marco.feliciano', 'Marco Feliciano', 'c4ca4238a0b923820dcc509a6f75849b', 'CMO', 'U', '1'),
('kate.macapili', 'Kate Macapili', 'b9e5f9ba5761817dea57c19f92b2ecf1', 'SMO', 'U', '1'),
('kate.agri', 'Kate Macapili Proxy of OCA', 'e10adc3949ba59abbe56e057f20f883e', 'OCA', 'U', '1'),
('christine.diamante', 'Christine Mae Diamante', 'cc1d60fc967b66b66229205d7bb288e8', 'ADM', 'U', '1'),
('chechy.yapaizon', 'Chechy Yap-Aizon', '0394ea68951e3299bcdfa75a097d7c11', 'SMO', 'R', '1'),
('rosemary.gregorio', 'Rose Mary R. Gregorio', 'e10adc3949ba59abbe56e057f20f883e', 'CLO', 'U', '1'),
('kate.macapili.gso', 'Kate Macapili Proxy of GSO', 'e10adc3949ba59abbe56e057f20f883e', 'GSO', 'U', '1'),
('kate.macapili.cdrrmo', 'Kate Macapili Proxy of CDRRMO', 'e10adc3949ba59abbe56e057f20f883e', 'DRR', 'U', '1'),
('kate.macapili.sdo', 'Kate Macapili Proxy of Sports', 'e10adc3949ba59abbe56e057f20f883e', 'SDO', 'U', '1'),
('chris.bularon', 'Christopher B. Bularon', 'e10adc3949ba59abbe56e057f20f883e', 'OCV', 'U', '1'),
('portia.quintas', 'Portia P. Quintas', 'e10adc3949ba59abbe56e057f20f883e', 'OCV', 'U', '1'),
('cares.pimentel', 'Cares Angelica J.Pimentel', 'e10adc3949ba59abbe56e057f20f883e', 'OCV', 'U', '1'),
('michelle.jose', 'Michelle A. Jose', 'e10adc3949ba59abbe56e057f20f883e', 'SSP', 'U', '1'),
('omer.remo', 'Omer Remo', 'e10adc3949ba59abbe56e057f20f883e', 'SSP', 'U', '1'),
('emefrida.nanquil', 'Emefrida Nanquil', 'e10adc3949ba59abbe56e057f20f883e', 'SSP', 'U', '1'),
('maricris.tejero', 'Maricris Tejero', 'e10adc3949ba59abbe56e057f20f883e', 'BA', 'U', '1'),
('alan.aizon', 'Alan Aizon', 'e10adc3949ba59abbe56e057f20f883e', 'CSD', 'U', '1'),
('jaures.lachica', 'Jaures Lachica', 'e10adc3949ba59abbe56e057f20f883e', 'ACC', 'U', '1'),
('dummy', 'dummy', 'e10adc3949ba59abbe56e057f20f883e', 'SMO', 'R', '1'),
('agnes.carbon', 'Jennifer Agnes M. Carbon', '05011fc72802a0682d39fbe330224b60', 'SMO', 'R', '1'),
('linger.lim', 'Linger Lim', 'e10adc3949ba59abbe56e057f20f883e', 'SMO', 'P', '1'),
('teodora.ramirez', 'Teodora Ramirez G.', 'e10adc3949ba59abbe56e057f20f883e', 'CBO', 'U', '1'),
('geraldine.delapaz', 'Geraldine Dela Paz', 'e10adc3949ba59abbe56e057f20f883e', 'CBO', 'U', '1'),
('cheryl.ganob', 'Cheryl Ganob', 'e10adc3949ba59abbe56e057f20f883e', 'PIO', 'U', '1'),
('yants.ismael', 'Friyanti Ismael', '1e56dcbd5511275053a14c13659450d7', 'CSD', 'R', '1'),
('jennifer.santos', 'Jennifer Santos', 'e10adc3949ba59abbe56e057f20f883e', 'DRR', 'U', '1'),
('cheermie.bejerano', 'Cheermielourdes Bejerano', 'e10adc3949ba59abbe56e057f20f883e', 'DRR', 'U', '1'),
('edison.alvarez', 'Edison Alvarez', 'e10adc3949ba59abbe56e057f20f883e', 'DRR', 'U', '1'),
('rieza.rodriguez', 'Rieza F. Rodriguez', 'e10adc3949ba59abbe56e057f20f883e', 'HLM', 'U', '1'),
('cathy.mentoya', 'Cathy C. Mentoya', 'e10adc3949ba59abbe56e057f20f883e', 'HLM', 'U', '1'),
('gladys.francisco', 'Gladys Francisco', 'e10adc3949ba59abbe56e057f20f883e', 'HRM', 'U', '1'),
('shaima.saybaddin', 'Shaima Saybaddin', 'e10adc3949ba59abbe56e057f20f883e', 'HRM', 'U', '1'),
(' adelisa.villarin', 'Adelisa Villarin', 'e10adc3949ba59abbe56e057f20f883e', 'HRM', 'U', '1'),
('marlo.delallana', 'Marlo Dela Llana', 'e10adc3949ba59abbe56e057f20f883e', 'HRM', 'U', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_working_hours`
--

CREATE TABLE `tbl_working_hours` (
  `time_start` time DEFAULT NULL,
  `time_end` time DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_working_hours`
--

INSERT INTO `tbl_working_hours` (`time_start`, `time_end`) VALUES
('08:00:00', '17:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_document_subject_matter`
--
ALTER TABLE `tbl_document_subject_matter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_document_transaction`
--
ALTER TABLE `tbl_document_transaction`
  ADD PRIMARY KEY (`trans_id`),
  ADD KEY `barcode_index` (`barcode`),
  ADD KEY `trans_id_index` (`trans_id`);

--
-- Indexes for table `tbl_document_type`
--
ALTER TABLE `tbl_document_type`
  ADD PRIMARY KEY (`document_code`);

--
-- Indexes for table `tbl_logs`
--
ALTER TABLE `tbl_logs`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `tbl_months`
--
ALTER TABLE `tbl_months`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_office`
--
ALTER TABLE `tbl_office`
  ADD PRIMARY KEY (`office_code`);

--
-- Indexes for table `tbl_office_performance`
--
ALTER TABLE `tbl_office_performance`
  ADD PRIMARY KEY (`office_code`,`document_code`);

--
-- Indexes for table `tbl_source`
--
ALTER TABLE `tbl_source`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_subject_matter`
--
ALTER TABLE `tbl_subject_matter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_time`
--
ALTER TABLE `tbl_time`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_transaction_type`
--
ALTER TABLE `tbl_transaction_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_document_subject_matter`
--
ALTER TABLE `tbl_document_subject_matter`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10772;

--
-- AUTO_INCREMENT for table `tbl_logs`
--
ALTER TABLE `tbl_logs`
  MODIFY `id_log` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=236309;

--
-- AUTO_INCREMENT for table `tbl_months`
--
ALTER TABLE `tbl_months`
  MODIFY `id` int(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_subject_matter`
--
ALTER TABLE `tbl_subject_matter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_time`
--
ALTER TABLE `tbl_time`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
