/*
SQLyog Enterprise - MySQL GUI v6.56
MySQL - 5.5.5-10.1.8-MariaDB : Database - db_dts_lu
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_dts_lu` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `db_dts_lu`;

/*Table structure for table `tbl_delivery_method` */

DROP TABLE IF EXISTS `tbl_delivery_method`;

CREATE TABLE `tbl_delivery_method` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `method` char(30) DEFAULT NULL,
  `status` char(1) DEFAULT NULL COMMENT '1=Active 0=Inactive',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_delivery_method` */

insert  into `tbl_delivery_method`(`id`,`method`,`status`) values (1,'Email','1'),(2,'Fax','1'),(3,'Hand Carry','1'),(4,'Post Mail','1');

/*Table structure for table `tbl_document` */

DROP TABLE IF EXISTS `tbl_document`;

CREATE TABLE `tbl_document` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `recieve_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `barcode` char(20) NOT NULL,
  `transaction_type` char(5) DEFAULT NULL,
  `document_type` char(5) DEFAULT NULL,
  `source_type` char(5) DEFAULT NULL,
  `office_code` char(5) DEFAULT NULL,
  `delivery_method` char(30) DEFAULT NULL,
  `source_name` text,
  `gender` char(6) DEFAULT NULL,
  `contact_no` char(100) DEFAULT NULL,
  `email_address` char(100) DEFAULT NULL,
  `subject_matter` text,
  `prerequisite` char(200) DEFAULT NULL,
  `access_code` char(50) DEFAULT NULL,
  `total_office_time` double DEFAULT NULL,
  `total_transit_time` double DEFAULT NULL,
  `transaction_end_date` date DEFAULT NULL,
  `transaction_status` char(1) DEFAULT NULL COMMENT 'D=Delayed O=Ontime',
  `username` char(20) DEFAULT NULL,
  `to_ocm` char(1) DEFAULT NULL COMMENT '1=OCM, 0=ADM',
  `rec_office` char(10) DEFAULT NULL,
  `status` char(1) DEFAULT NULL COMMENT '1=Active 0=Inactive',
  PRIMARY KEY (`id`,`barcode`),
  UNIQUE KEY `id` (`id`),
  KEY `barcode_index` (`barcode`),
  KEY `document_id_index` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_document` */

insert  into `tbl_document`(`id`,`recieve_date`,`end_date`,`barcode`,`transaction_type`,`document_type`,`source_type`,`office_code`,`delivery_method`,`source_name`,`gender`,`contact_no`,`email_address`,`subject_matter`,`prerequisite`,`access_code`,`total_office_time`,`total_transit_time`,`transaction_end_date`,`transaction_status`,`username`,`to_ocm`,`rec_office`,`status`) values (1,'2018-01-23 13:41:44','2018-02-06 13:41:44','00001','COMP','COM','EXT','N/A','1','Name','Male','6078888','','Subject Matter','','KUHMKO',0,0,'0000-00-00','','admin','0','REC','1'),(2,'2018-02-06 12:11:51','2018-02-13 12:11:51','C00104565','SIMP','COM','INT','ENRD','3','valmar valdez','Male','','','re: inspection report of solid waste management problem complaint ','','OUHJPP',13891.14375,0,'0000-00-00','','rec','0','REC','1'),(3,'2018-02-15 08:37:02','2018-03-01 08:37:02','00002','COMP','COM','EXT','N/A','1','none','Male','','','none','none','HCIXER',0,0,'0000-00-00','','rec2','0','RECA','1'),(4,'2018-02-15 10:38:39','2018-02-22 10:38:39','00003','SIMP','COM','EXT','N/A','3','Test','Male','','jay.carlou@gmail.com','Test','','WKJPIF',0,0,'0000-00-00','','rec','0','REC','1'),(5,'2018-02-15 10:41:31','2018-03-01 10:41:31','00004','COMP','COM','EXT','N/A','3','Test','Male','','jay.carlou@gmail.com','none','','THNVTM',0,0,'0000-00-00','','rec','0','REC','1'),(6,'2018-02-15 10:47:59','2018-03-01 10:47:59','00005','COMP','COM','EXT','N/A','3','TEST','Male','test','jay.carlou@gmail.com','test','','GXTLEH',0,0,'0000-00-00','','rec','0','REC','1'),(7,'2018-02-15 10:57:50','2018-03-01 10:57:50','00006','COMP','COM','EXT','N/A','3','test','Male','','jay_carlou@yahoo.com','none','','SKIQXW',0,0,'0000-00-00','','rec','0','REC','1'),(8,'2018-02-15 11:03:07','2018-03-01 11:03:07','00007','COMP','COM','EXT','N/A','1','jay','Male','','jay.carlou@gmail.com','subject','','UTFMPY',0,0,'0000-00-00','','rec','0','REC','1'),(9,'2018-02-15 11:25:53','2018-03-01 11:25:53','00008','COMP','COM','EXT','N/A','1','Name','Male','','jay.carlou@gmail.com','SM','','GCBTVZ',0,0,'0000-00-00','','rec','0','REC','1'),(10,'2018-02-15 11:29:44','2018-03-01 11:29:44','00009','COMP','COM','EXT','N/A','3','Name','Male','','jay.carlou@gmail.com','SM','','WLHNBY',0,0,'0000-00-00','','rec','0','REC','1'),(11,'2018-02-15 11:58:16','2018-03-01 11:58:16','00010','COMP','COM','EXT','N/A','1','non','Male','191','jay.carlou@gmail.com','sdaf','','RDEMUT',0,0,'0000-00-00','','rec','0','REC','1'),(12,'2018-02-15 12:23:42','2018-03-01 12:23:42','00011','COMP','COM','EXT','N/A','1','name','Male','123','jay.carlou@yahoo.com','asdf','','HVESPK',0,0,'0000-00-00','','rec','0','REC','1'),(13,'2018-02-15 12:25:13','2018-03-01 12:25:13','000012','COMP','COM','EXT','N/A','3','asdf','Male','','jay.carlou@gmail.com','asdf','','ORYJDP',0,0,'0000-00-00','','rec','0','REC','1'),(14,'2018-02-15 12:51:42','2018-03-01 12:51:42','00013','COMP','COM','EXT','N/A','1','asdf','Male','','jay.carlou@yahoo.com','asdf','df','PTVHJE',0,0,'0000-00-00','','rec','0','REC','1'),(15,'2018-02-15 12:58:38','2018-02-22 12:58:38','00014','SIMP','COM','EXT','N/A','3','Name','Male','123123','jay.carlou@gmail.com','asdf','asdf','QUDFKL',0,0,'0000-00-00','','admin','0','MIS','1'),(16,'2018-02-15 13:08:47','2018-03-01 13:08:47','00015','COMP','COM','EXT','N/A','1','jay.carlou@gmail.com','Male','','jay.carlou@gmail.com','asdf','asdf','OUXRUD',0,0,'0000-00-00','','admin','0','MIS','1'),(17,'2018-02-15 13:09:58','2018-03-01 13:09:58','00016','COMP','VC','EXT','N/A','3','asdf','Male','asdf','jay.carlou@gmail.com','sdf','','SKSTJD',0,0,'0000-00-00','','admin','0','MIS','1'),(18,'2018-02-15 13:11:22','2018-02-22 13:11:22','00017','SIMP','PR','EXT','N/A','1','sadf','Female','asdf','jay.carlou@gmail.com','sdf','','KMIAMZ',0,0,'0000-00-00','','admin','0','MIS','1');

/*Table structure for table `tbl_document_attachments` */

DROP TABLE IF EXISTS `tbl_document_attachments`;

CREATE TABLE `tbl_document_attachments` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `barcode` char(10) DEFAULT NULL,
  `document_name` char(50) DEFAULT NULL,
  `attachement_location` text,
  `status` char(1) DEFAULT NULL COMMENT '1=Active 0=Inactive',
  PRIMARY KEY (`id`),
  KEY `barcode_index` (`barcode`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_document_attachments` */

insert  into `tbl_document_attachments`(`id`,`barcode`,`document_name`,`attachement_location`,`status`) values (1,'C00104565','C00108395.pdf','../documents/C00108395.pdf','1');

/*Table structure for table `tbl_document_transaction` */

DROP TABLE IF EXISTS `tbl_document_transaction`;

CREATE TABLE `tbl_document_transaction` (
  `trans_id` char(30) NOT NULL,
  `barcode` char(10) DEFAULT NULL,
  `sequence` int(5) DEFAULT NULL,
  `transit_date_time` datetime DEFAULT NULL,
  `office_code` char(10) DEFAULT NULL,
  `person` char(50) DEFAULT NULL,
  `recieve_date_time` datetime DEFAULT NULL,
  `recieve_action` char(50) DEFAULT NULL,
  `route_office_code` char(10) DEFAULT NULL,
  `release_date_time` datetime DEFAULT NULL COMMENT 'this can be end date',
  `release_action` char(50) DEFAULT NULL,
  `remarks` text,
  `current_action` char(3) DEFAULT NULL COMMENT 'REL=Release, REC=Receive ',
  `office_time` double DEFAULT NULL,
  `transit_time` double DEFAULT NULL,
  `status` char(1) DEFAULT NULL COMMENT '1=Active 0=Inactive this is used for transactions',
  PRIMARY KEY (`trans_id`),
  KEY `barcode_index` (`barcode`),
  KEY `trans_id_index` (`trans_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `tbl_document_transaction` */

insert  into `tbl_document_transaction`(`trans_id`,`barcode`,`sequence`,`transit_date_time`,`office_code`,`person`,`recieve_date_time`,`recieve_action`,`route_office_code`,`release_date_time`,`release_action`,`remarks`,`current_action`,`office_time`,`transit_time`,`status`) values ('201802131540434885790','C00104565',1,NULL,'REC','Administrator','2018-02-06 12:11:51','New Document Trail','ENRD','2018-02-13 15:40:43','-','-','REL',2778.325,0,'1'),('201802131540428479090','C00104565',1,NULL,'REC','Administrator','2018-02-06 12:11:51','New Document Trail','CDH','2018-02-13 15:40:42','-','-','REL',2778.31875,0,'1'),('201802131540422853360','C00104565',1,NULL,'REC','Administrator','2018-02-06 12:11:51','New Document Trail','BDH','2018-02-13 15:40:42','-','-','REL',2778.31875,0,'1'),('201802131540416446750','C00104565',1,NULL,'REC','Administrator','2018-02-06 12:11:51','New Document Trail','ASS','2018-02-13 15:40:41','-','-','REL',2778.3125,0,'1'),('201802131539307422750','C00104565',1,NULL,'REC','Administrator','2018-02-06 12:11:51','New Document Trail','ACC','2018-02-13 15:39:30','-','-','REL',2777.86875,0,'1');

/*Table structure for table `tbl_document_type` */

DROP TABLE IF EXISTS `tbl_document_type`;

CREATE TABLE `tbl_document_type` (
  `document_code` char(5) NOT NULL,
  `document_type` char(50) DEFAULT NULL,
  `status` char(1) DEFAULT NULL COMMENT '1=Active 0=Inactive',
  PRIMARY KEY (`document_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `tbl_document_type` */

insert  into `tbl_document_type`(`document_code`,`document_type`,`status`) values ('COM','Communications','1'),('PO','Purchase Order','1'),('PR','Purchase Request','1'),('PY','Payroll','1'),('VC','Disbursement Voucher/Petty Cash','1');

/*Table structure for table `tbl_email` */

DROP TABLE IF EXISTS `tbl_email`;

CREATE TABLE `tbl_email` (
  `host` char(100) DEFAULT NULL,
  `username` char(100) DEFAULT NULL,
  `password` text,
  `port` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_email` */

insert  into `tbl_email`(`host`,`username`,`password`,`port`) values ('smtp.gmail.com','keejhay12@gmail.com','sfc2017043',587);

/*Table structure for table `tbl_logs` */

DROP TABLE IF EXISTS `tbl_logs`;

CREATE TABLE `tbl_logs` (
  `id_log` int(10) NOT NULL AUTO_INCREMENT,
  `datetime_log` datetime DEFAULT NULL,
  `username` char(20) DEFAULT NULL,
  `action` char(100) DEFAULT NULL,
  PRIMARY KEY (`id_log`)
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_logs` */

insert  into `tbl_logs`(`id_log`,`datetime_log`,`username`,`action`) values (1,'2018-01-19 14:44:42','rec','ENTERED NEW DOCUMENT 00001.'),(2,'2018-01-19 14:44:53','rec','DOCUMENT 00001 ROUTE TO OPG.'),(3,'2018-01-19 14:45:23','test2','OPG RECEIVED DOCUMENT 00001.'),(4,'2018-01-19 14:45:40','test2','VIEW DOCUMENT 00001 DETAILS AND TRAIL.'),(5,'2018-02-19 14:46:24','test2','OPG RELEASED DOCUMENT 00001 TO ISO.'),(6,'2018-02-19 14:46:39','test2','VIEW DOCUMENT 00001 DETAILS AND TRAIL.'),(7,'2018-02-19 14:47:05','test2','VIEW DOCUMENT 00001 DETAILS AND TRAIL.'),(8,'2018-02-19 14:56:07','test2','VIEW DOCUMENT 00001 DETAILS AND TRAIL.'),(9,'2018-01-19 16:41:11','rec','ENTERED NEW DOCUMENT 00001.'),(10,'2018-01-19 16:41:21','rec','DOCUMENT 00001 ROUTE TO ISO.'),(11,'2018-01-19 16:41:41','test','ISO RECEIVED DOCUMENT 00001.'),(12,'2018-02-06 16:44:05','test','ISO RELEASED DOCUMENT 00001 TO OPG.'),(13,'2018-02-06 16:44:11','test','VIEW DOCUMENT 00001 DETAILS AND TRAIL.'),(14,'2018-02-06 16:44:59','test','VIEW DOCUMENT 00001 DETAILS AND TRAIL.'),(15,'2018-02-06 16:45:24','test','VIEW DOCUMENT 00001 DETAILS AND TRAIL.'),(16,'2018-01-23 09:10:20','admin','VIEW DOCUMENT 00001 DETAILS AND TRAIL.'),(17,'2018-01-23 09:10:39','admin','VIEW DOCUMENT 00001 DETAILS AND TRAIL.'),(18,'2018-01-23 13:41:44','admin','ENTERED NEW DOCUMENT 00001.'),(19,'2018-01-23 13:59:11','admin','VIEW DOCUMENT 00001 DETAILS AND TRAIL.'),(20,'2018-01-23 14:25:30','admin','VIEW DOCUMENT 00001 DETAILS AND TRAIL.'),(21,'2018-02-06 12:11:51','rec','ENTERED NEW DOCUMENT C00104565.'),(22,'2018-02-06 12:12:25','rec','UPLOAD ATTACHMENT TO DOCUMENT C00104565.'),(23,'2018-02-06 12:12:44','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(24,'2018-02-06 12:12:44','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(25,'2018-02-06 12:12:44','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(26,'2018-02-06 12:12:44','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(27,'2018-02-06 12:12:44','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(28,'2018-02-06 12:12:44','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(29,'2018-02-06 12:12:45','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(30,'2018-02-06 12:12:45','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(31,'2018-02-06 12:12:45','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(32,'2018-02-06 12:12:45','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(33,'2018-02-06 12:12:45','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(34,'2018-02-06 12:12:45','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(35,'2018-02-06 12:12:45','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(36,'2018-02-06 12:12:45','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(37,'2018-02-06 12:12:45','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(38,'2018-02-06 12:12:45','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(39,'2018-02-06 12:12:45','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(40,'2018-02-06 12:12:45','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(41,'2018-02-06 12:12:45','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(42,'2018-02-06 12:12:45','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(43,'2018-02-06 12:12:45','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(44,'2018-02-06 12:12:45','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(45,'2018-02-06 12:12:45','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(46,'2018-02-06 12:12:45','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(47,'2018-02-06 12:12:45','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(48,'2018-02-06 12:12:46','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(49,'2018-02-06 12:12:46','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(50,'2018-02-06 12:12:46','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(51,'2018-02-06 12:12:46','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(52,'2018-02-06 12:12:46','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(53,'2018-02-06 12:12:46','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(54,'2018-02-06 12:12:46','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(55,'2018-02-06 12:12:46','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(56,'2018-02-06 12:12:46','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(57,'2018-02-06 12:12:46','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(58,'2018-02-06 12:12:46','rec','DOCUMENT C00104565 ROUTE TO ALL OFFICES.'),(59,'2018-02-06 12:13:02','rec','EDIT DOCUMENT C00104565 DETAILS.'),(60,'2018-02-06 12:13:05','rec','EDIT DOCUMENT C00104565 DETAILS.'),(61,'2018-02-06 12:13:09','rec','EDIT DOCUMENT C00104565 DETAILS.'),(62,'2018-02-12 17:07:56','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(63,'2018-02-12 17:08:12','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(64,'2018-02-12 17:15:52','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(65,'2018-02-13 08:46:57','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(66,'2018-02-13 08:47:22','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(67,'2018-02-13 09:10:07','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(68,'2018-02-13 09:10:38','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(69,'2018-02-13 09:11:27','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(70,'2018-02-13 09:11:50','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(71,'2018-02-13 09:12:09','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(72,'2018-02-13 09:12:23','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(73,'2018-02-13 09:12:34','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(74,'2018-02-13 09:12:45','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(75,'2018-02-13 09:13:48','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(76,'2018-02-13 09:13:54','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(77,'2018-02-13 09:14:01','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(78,'2018-02-13 09:14:06','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(79,'2018-02-13 10:58:53','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(80,'2018-02-13 13:12:03','admin','DOCUMENT C00104565 DELETE ROUTE TO ALL OFFICES.'),(81,'2018-02-13 15:11:47','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(82,'2018-02-13 15:34:38','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(83,'2018-02-13 15:34:54','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(84,'2018-02-13 15:35:02','admin','VIEW DOCUMENT 00001 DETAILS AND TRAIL.'),(85,'2018-02-13 15:35:23','admin','VIEW DOCUMENT 00001 DETAILS AND TRAIL.'),(86,'2018-02-13 15:35:45','admin','VIEW DOCUMENT 00001 DETAILS AND TRAIL.'),(87,'2018-02-13 15:37:53','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(88,'2018-02-13 15:38:19','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(89,'2018-02-13 15:38:44','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(90,'2018-02-13 15:39:16','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(91,'2018-02-13 15:39:30','admin','DOCUMENT C00104565 ROUTE TO ACC.'),(92,'2018-02-13 15:39:36','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(93,'2018-02-13 15:40:01','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(94,'2018-02-13 15:40:12','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(95,'2018-02-13 15:40:24','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(96,'2018-02-13 15:40:41','admin','DOCUMENT C00104565 ROUTE TO ASS.'),(97,'2018-02-13 15:40:42','admin','DOCUMENT C00104565 ROUTE TO BDH.'),(98,'2018-02-13 15:40:42','admin','DOCUMENT C00104565 ROUTE TO CDH.'),(99,'2018-02-13 15:40:43','admin','DOCUMENT C00104565 ROUTE TO ENRD.'),(100,'2018-02-13 15:40:47','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(101,'2018-02-13 15:41:07','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(102,'2018-02-13 15:41:16','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(103,'2018-02-13 15:41:29','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(104,'2018-02-13 15:41:39','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(105,'2018-02-13 15:41:59','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(106,'2018-02-13 15:42:52','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(107,'2018-02-13 15:55:56','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(108,'2018-02-13 16:02:32','admin','VIEW DOCUMENT 00001 DETAILS AND TRAIL.'),(109,'2018-02-13 16:17:15','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(110,'2018-02-13 16:21:05','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(111,'2018-02-13 16:21:44','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(112,'2018-02-14 10:00:54','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(113,'2018-02-14 15:21:04','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(114,'2018-02-14 15:21:10','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(115,'2018-02-14 15:21:42','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(116,'2018-02-14 16:40:11','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(117,'2018-02-14 16:42:29','admin','VIEW DOCUMENT C00104565 DETAILS AND TRAIL.'),(118,'2018-02-14 16:44:55','admin','VIEW DOCUMENT 00001 DETAILS AND TRAIL.'),(119,'2018-02-15 08:37:02','rec2','ENTERED NEW DOCUMENT 00002.'),(120,'2018-02-15 10:38:39','rec','ENTERED NEW DOCUMENT 00003. ERROR IN SENDING EMAIL.'),(121,'2018-02-15 10:41:31','rec','ENTERED NEW DOCUMENT 00004. ERROR IN SENDING EMAIL.'),(122,'2018-02-15 10:47:59','rec','ENTERED NEW DOCUMENT 00005. ERROR IN SENDING EMAIL.'),(123,'2018-02-15 10:57:50','rec','ENTERED NEW DOCUMENT 00006. ERROR IN SENDING EMAIL.'),(124,'2018-02-15 11:03:08','rec','ENTERED NEW DOCUMENT 00007. ERROR IN SENDING EMAIL.'),(125,'2018-02-15 11:25:53','rec','ENTERED NEW DOCUMENT 00008. ERROR IN SENDING EMAIL.'),(126,'2018-02-15 11:29:45','rec','ENTERED NEW DOCUMENT 00009. ERROR IN SENDING EMAIL.'),(127,'2018-02-15 11:58:18','rec','ENTERED NEW DOCUMENT 00010. ERROR IN SENDING EMAIL.'),(128,'2018-02-15 12:23:42','rec','ENTERED NEW DOCUMENT 00011. ERROR IN SENDING EMAIL.'),(129,'2018-02-15 12:25:13','rec','ENTERED NEW DOCUMENT 000012. ERROR IN SENDING EMAIL.'),(130,'2018-02-15 12:51:42','rec','ENTERED NEW DOCUMENT 00013. ERROR IN SENDING EMAIL.'),(131,'2018-02-15 12:58:38','admin','ENTERED NEW DOCUMENT 00014. ERROR IN SENDING EMAIL.'),(132,'2018-02-15 13:08:48','admin','ENTERED NEW DOCUMENT 00015. ERROR IN SENDING EMAIL.'),(133,'2018-02-15 13:09:58','admin','ENTERED NEW DOCUMENT 00016. ERROR IN SENDING EMAIL.'),(134,'2018-02-15 13:11:22','admin','ENTERED NEW DOCUMENT 00017. ERROR IN SENDING EMAIL.');

/*Table structure for table `tbl_office` */

DROP TABLE IF EXISTS `tbl_office`;

CREATE TABLE `tbl_office` (
  `office_code` char(10) NOT NULL,
  `office_name` char(100) DEFAULT NULL,
  `status` char(1) DEFAULT NULL COMMENT '1=Active 0=Inactive',
  PRIMARY KEY (`office_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `tbl_office` */

insert  into `tbl_office`(`office_code`,`office_name`,`status`) values ('ISO','ISO Facilitator','1'),('DCC','Document Control Custodian','1'),('OPG','Office of the Provincial Governor','1'),('VG','Office of the Provincial Vice Governor','1'),('SP','Office of the Provincial Sangguniang Panlalawigan','1'),('OPS','Oversight to Provincial Strategy','1'),('ADM','Office of the Provincial Administrator','1'),('RRM','Office of the Provincial Disaster Risk Reduction Management Council','1'),('BAC','Bids and Awards Committee','1'),('SSD','Provincial Security Services Division','1'),('HRM','Human Resource Management Division','1'),('MIS','Management Information Systems Division','1'),('LUPJ','La Union Provincial Jail Division','1'),('ENRD','Environment and Natural Resources Division','1'),('ACC','Office of the Provincial Accountant','1'),('OPAG','Office of the Provincial Agriculturist','1'),('ASS','Office of the Provincial Assessor','1'),('PBO','Office of the Provincial Budget Officer','1'),('PEO','Office of the Provincial Engineer','1'),('PGSO','Office of the Provincial General Services Officer','1'),('PITO','Office of the Provincial Information and Tourism Officer','1'),('PLO','Office of the Provincial Legal Officer','1'),('PPDC','Office of the Provincial Planning and Development Officer','1'),('PPO','Office of the Provincial Population Officer','1'),('PSWD','Office of the Provincial Social Welfare and Development Officer','1'),('PESO','Provincial Employment Services Office','1'),('PTO','Office of the Provincial Treasurer','1'),('VET','Office of the Provincial Veterinarian','1'),('PHO','Office of the Provincial Health Officer','1'),('LUDH','La Union District Hospital','1'),('BDH','Bacnotan District Hospital','1'),('BLDH','Balaoan District Hospital','1'),('CDH','Caba District Hospital','1'),('NDH','Naguilian District Hospital','1'),('RDH','Rosario District Hospital','1'),('LUMC','La Union Medical Center','1'),('REC','Records Main','1'),('RECA','Records Station A','1'),('RECB','Records Station B','1');

/*Table structure for table `tbl_office_performance` */

DROP TABLE IF EXISTS `tbl_office_performance`;

CREATE TABLE `tbl_office_performance` (
  `office_code` char(10) NOT NULL,
  `document_code` char(5) NOT NULL,
  `office_time` double DEFAULT NULL COMMENT 'in minutes',
  PRIMARY KEY (`office_code`,`document_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_office_performance` */

insert  into `tbl_office_performance`(`office_code`,`document_code`,`office_time`) values ('ACC','COM',540),('ACC','PO',540),('ACC','PR',540),('ACC','PY',540),('ACC','VC',540),('ADM','COM',540),('ADM','PO',540),('ADM','PR',540),('ADM','PY',540),('ADM','VC',540),('ASS','COM',540),('ASS','PO',540),('ASS','PR',540),('ASS','PY',540),('ASS','VC',540),('BAC','COM',540),('BAC','PO',540),('BAC','PR',540),('BAC','PY',540),('BAC','VC',540),('BDH','COM',540),('BDH','PO',540),('BDH','PR',540),('BDH','PY',540),('BDH','VC',540),('BLDH','COM',540),('BLDH','PO',540),('BLDH','PR',540),('BLDH','PY',540),('BLDH','VC',540),('CDH','COM',540),('CDH','PO',540),('CDH','PR',540),('CDH','PY',540),('CDH','VC',540),('DCC','COM',540),('DCC','PO',540),('DCC','PR',540),('DCC','PY',540),('DCC','VC',540),('ENRD','COM',540),('ENRD','PO',540),('ENRD','PR',540),('ENRD','PY',540),('ENRD','VC',540),('HRM','COM',540),('HRM','PO',540),('HRM','PR',540),('HRM','PY',540),('HRM','VC',540),('ISO','COM',540),('ISO','PO',540),('ISO','PR',540),('ISO','PY',540),('ISO','VC',540),('LUDH','COM',540),('LUDH','PO',540),('LUDH','PR',540),('LUDH','PY',540),('LUDH','VC',540),('LUMC','COM',540),('LUMC','PO',540),('LUMC','PR',540),('LUMC','PY',540),('LUMC','VC',540),('LUPJ','COM',540),('LUPJ','PO',540),('LUPJ','PR',540),('LUPJ','PY',540),('LUPJ','VC',540),('MIS','COM',540),('MIS','PO',540),('MIS','PR',540),('MIS','PY',540),('MIS','VC',540),('NDH','COM',540),('NDH','PO',540),('NDH','PR',540),('NDH','PY',540),('NDH','VC',540),('OPAG','COM',540),('OPAG','PO',540),('OPAG','PR',540),('OPAG','PY',540),('OPAG','VC',540),('OPG','COM',540),('OPG','PO',540),('OPG','PR',540),('OPG','PY',540),('OPG','VC',540),('OPS','COM',540),('OPS','PO',540),('OPS','PR',540),('OPS','PY',540),('OPS','VC',540),('PBO','COM',540),('PBO','PO',540),('PBO','PR',540),('PBO','PY',540),('PBO','VC',540),('PEO','COM',540),('PEO','PO',540),('PEO','PR',540),('PEO','PY',540),('PEO','VC',540),('PESO','COM',540),('PESO','PO',540),('PESO','PR',540),('PESO','PY',540),('PESO','VC',540),('PGSO','COM',540),('PGSO','PO',540),('PGSO','PR',540),('PGSO','PY',540),('PGSO','VC',540),('PHO','COM',540),('PHO','PO',540),('PHO','PR',540),('PHO','PY',540),('PHO','VC',540),('PITO','COM',540),('PITO','PO',540),('PITO','PR',540),('PITO','PY',540),('PITO','VC',540),('PLO','COM',540),('PLO','PO',540),('PLO','PR',540),('PLO','PY',540),('PLO','VC',540),('PPDC','COM',540),('PPDC','PO',540),('PPDC','PR',540),('PPDC','PY',540),('PPDC','VC',540),('PPO','COM',540),('PPO','PO',540),('PPO','PR',540),('PPO','PY',540),('PPO','VC',540),('PSWD','COM',540),('PSWD','PO',540),('PSWD','PR',540),('PSWD','PY',540),('PSWD','VC',540),('PTO','COM',540),('PTO','PO',540),('PTO','PR',540),('PTO','PY',540),('PTO','VC',540),('RDH','COM',540),('RDH','PO',540),('RDH','PR',540),('RDH','PY',540),('RDH','VC',540),('REC','COM',540),('REC','PO',540),('REC','PR',540),('REC','PY',540),('REC','VC',540),('RECA','COM',540),('RECA','PO',540),('RECA','PR',540),('RECA','PY',540),('RECA','VC',540),('RECB','COM',540),('RECB','PO',540),('RECB','PR',540),('RECB','PY',540),('RECB','VC',540),('RRM','COM',540),('RRM','PO',540),('RRM','PR',540),('RRM','PY',540),('RRM','VC',540),('SP','COM',540),('SP','PO',540),('SP','PR',540),('SP','PY',540),('SP','VC',540),('SSD','COM',540),('SSD','PO',540),('SSD','PR',540),('SSD','PY',540),('SSD','VC',540),('VET','COM',540),('VET','PO',540),('VET','PR',540),('VET','PY',540),('VET','VC',540),('VG','COM',540),('VG','PO',540),('VG','PR',540),('VG','PY',540),('VG','VC',540);

/*Table structure for table `tbl_source` */

DROP TABLE IF EXISTS `tbl_source`;

CREATE TABLE `tbl_source` (
  `id` char(5) NOT NULL,
  `source` char(20) DEFAULT NULL,
  `status` char(1) DEFAULT NULL COMMENT '1=Active 0=Inactive',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `tbl_source` */

insert  into `tbl_source`(`id`,`source`,`status`) values ('EXT','External','1'),('INT','Internal','1');

/*Table structure for table `tbl_time` */

DROP TABLE IF EXISTS `tbl_time`;

CREATE TABLE `tbl_time` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `time_in` datetime DEFAULT NULL,
  `time_out` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_time` */

insert  into `tbl_time`(`id`,`time_in`,`time_out`) values (1,'2016-10-09 08:10:00','2016-10-09 16:30:00'),(2,'2016-10-10 08:00:00','2016-10-10 08:30:00');

/*Table structure for table `tbl_transaction_type` */

DROP TABLE IF EXISTS `tbl_transaction_type`;

CREATE TABLE `tbl_transaction_type` (
  `id` char(5) NOT NULL,
  `transaction` char(20) DEFAULT NULL,
  `days` int(11) DEFAULT NULL,
  `status` char(1) DEFAULT NULL COMMENT '1=Active 0=Inactive',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `tbl_transaction_type` */

insert  into `tbl_transaction_type`(`id`,`transaction`,`days`,`status`) values ('COMP','Complex',10,'1'),('SIMP','Simple',5,'1');

/*Table structure for table `tbl_users` */

DROP TABLE IF EXISTS `tbl_users`;

CREATE TABLE `tbl_users` (
  `username` char(20) NOT NULL,
  `full_name` char(100) DEFAULT NULL,
  `password` text,
  `office_code` char(10) DEFAULT NULL,
  `access_level` char(1) DEFAULT NULL COMMENT 'A=Admin U=User',
  `status` char(1) DEFAULT NULL COMMENT '1=Active 0=Inactive',
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `tbl_users` */

insert  into `tbl_users`(`username`,`full_name`,`password`,`office_code`,`access_level`,`status`) values ('admin','Administrator','cb2169ae43d39129ddd44aadfa1d4aca','MIS','A','1'),('rec3','rec3','b695feff4dd3d02a448e4781800a8f3e','RECB','R','1'),('rec2','rec2','6bcc9f75809b1c7c8a4fbc8e9accb5c0','RECA','R','1'),('rec','rec','0b2c082c00e002a2f571cbe340644239','REC','R','1'),('test2','test2','ad0234829205b9033196ba818f7a872b','OPG','U','1'),('test','test','098f6bcd4621d373cade4e832627b4f6','ISO','U','1');

/*Table structure for table `tbl_working_hours` */

DROP TABLE IF EXISTS `tbl_working_hours`;

CREATE TABLE `tbl_working_hours` (
  `time_start` time DEFAULT NULL,
  `time_end` time DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `tbl_working_hours` */

insert  into `tbl_working_hours`(`time_start`,`time_end`) values ('08:00:00','17:00:00');

/* Function  structure for function  `TOTAL_WEEKDAYS` */

/*!50003 DROP FUNCTION IF EXISTS `TOTAL_WEEKDAYS` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `TOTAL_WEEKDAYS`(date1 DATETIME, date2 DATETIME) RETURNS double
RETURN ABS(DATEDIFF(date2, date1)) + 1
     - ABS(DATEDIFF(ADDDATE(date2, INTERVAL 1 - DAYOFWEEK(date2) DAY),
                    ADDDATE(date1, INTERVAL 1 - DAYOFWEEK(date1) DAY))) / 7 * 2
     - (DAYOFWEEK(IF(date1 < date2, date1, date2)) = 1)
     - (DAYOFWEEK(IF(date1 > date2, date1, date2)) = 7) */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
