/*
SQLyog Enterprise - MySQL GUI v6.56
MySQL - 5.5.5-10.1.8-MariaDB : Database - db_dts_zc
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_dts_zc` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `db_dts_zc`;

/*Data for the table `tbl_delivery_method` */

insert  into `tbl_delivery_method`(`id`,`method`,`status`) values (1,'Email','1'),(2,'Fax','1'),(3,'Hand Carry','1'),(4,'Post Mail','1');

/*Data for the table `tbl_document` */

/*Data for the table `tbl_document_attachments` */

/*Data for the table `tbl_document_transaction` */

/*Data for the table `tbl_document_type` */

insert  into `tbl_document_type`(`document_code`,`document_type`,`status`) values ('COM','Communications','1'),('PO','Purchase Order','1'),('PR','Purchase Request','1'),('PY','Payroll','1'),('VC','Disbursement Voucher/Petty Cash','1'),('AOC','Abstract of Canvass','1');

/*Data for the table `tbl_email` */

insert  into `tbl_email`(`host`,`username`,`password`,`port`) values ('smtp.gmail.com','dts.zamboanga@gmail.com','ZamboangaDTS2019',587);

/*Data for the table `tbl_logs` */

insert  into `tbl_logs`(`id_log`,`datetime_log`,`username`,`action`) values (51942,'2019-02-20 13:53:44','admin','PASSWORD CHANGED.'),(51943,'2019-02-20 14:19:22','admin','ENTERED NEW DOCUMENT C012345. ERROR IN SENDING EMAIL.');

/*Data for the table `tbl_months` */

insert  into `tbl_months`(`id`,`month`,`value`) values (1,'January','01'),(2,'February','02'),(3,'March','03'),(4,'April','04'),(5,'May','05'),(6,'June','06'),(7,'July','07'),(8,'August','08'),(9,'September','09'),(10,'October','10'),(11,'November','11'),(12,'December','12');

/*Data for the table `tbl_office` */

insert  into `tbl_office`(`office_code`,`office_name`,`status`) values ('REC','Records Office','1');

/*Data for the table `tbl_office_performance` */

insert  into `tbl_office_performance`(`office_code`,`document_code`,`office_time`) values ('REC','AOC',7200),('REC','COM',7200),('REC','PO',7200),('REC','PR',7200),('REC','PY',7200),('REC','VC',7200);

/*Data for the table `tbl_source` */

insert  into `tbl_source`(`id`,`source`,`status`) values ('EXT','External','1'),('INT','Internal','1');

/*Data for the table `tbl_time` */

insert  into `tbl_time`(`id`,`time_in`,`time_out`) values (1,'2016-10-09 08:10:00','2016-10-09 16:30:00'),(2,'2016-10-10 08:00:00','2016-10-10 08:30:00');

/*Data for the table `tbl_transaction_type` */

insert  into `tbl_transaction_type`(`id`,`transaction`,`days`,`status`) values ('COMP','Complex',10,'1'),('SIMP','Simple',5,'1'),('HIGH','Highly Technical',20,'1');

/*Data for the table `tbl_users` */

insert  into `tbl_users`(`username`,`full_name`,`password`,`office_code`,`access_level`,`status`) values ('admin','administrator','21232f297a57a5a743894a0e4a801fc3','ICT','A','1');

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
