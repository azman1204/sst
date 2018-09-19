/*
SQLyog Community v12.4.3 (64 bit)
MySQL - 5.7.21 : Database - sst
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`sst` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `sst`;

/*Table structure for table `pendaftaran` */

DROP TABLE IF EXISTS `pendaftaran`;

CREATE TABLE `pendaftaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `nokp` varchar(12) NOT NULL,
  `kebenaran` char(1) DEFAULT NULL COMMENT 'Y/T',
  `alamat` varchar(300) DEFAULT NULL,
  `tel` varchar(15) DEFAULT NULL,
  `jantina` char(1) DEFAULT NULL,
  `tkh_lahir` date DEFAULT NULL,
  `umur` int(11) DEFAULT NULL COMMENT 'auto gen',
  `id_sekolah` int(11) DEFAULT NULL COMMENT 'see table sekolah',
  `id_klinik` int(11) DEFAULT NULL COMMENT 'see table klinik',
  `kump_etnik` int(11) DEFAULT NULL,
  `pecahan_etnik` int(11) DEFAULT NULL,
  `created_dt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL COMMENT 'see user.id',
  `updated_dt` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unik` (`nokp`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `pendaftaran` */

insert  into `pendaftaran`(`id`,`nama`,`nokp`,`kebenaran`,`alamat`,`tel`,`jantina`,`tkh_lahir`,`umur`,`id_sekolah`,`id_klinik`,`kump_etnik`,`pecahan_etnik`,`created_dt`,`created_by`,`updated_dt`,`updated_by`) values 
(1,'azman','1234',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2018-09-05 15:18:05',NULL,NULL,NULL),
(5,'azman','123456',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2018-09-06 09:54:26',NULL,NULL,NULL),
(4,'azman bin zakaria','123467',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2018-09-06 09:53:39',NULL,NULL,NULL);

/*Table structure for table `ujian_saringan` */

DROP TABLE IF EXISTS `ujian_saringan`;

CREATE TABLE `ujian_saringan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pendaftaran` int(11) NOT NULL,
  `tkh_ujian` date DEFAULT NULL,
  `hb` decimal(4,2) DEFAULT NULL,
  `mch` decimal(4,2) DEFAULT NULL,
  `mcv` decimal(4,2) DEFAULT NULL,
  `mchc` decimal(4,2) DEFAULT NULL,
  `rdw` decimal(4,2) DEFAULT NULL,
  `rbc` decimal(4,2) DEFAULT NULL,
  `id_diag_sementara` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_dt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `updated_dt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `ujian_saringan` */

insert  into `ujian_saringan`(`id`,`id_pendaftaran`,`tkh_ujian`,`hb`,`mch`,`mcv`,`mchc`,`rdw`,`rbc`,`id_diag_sementara`,`created_by`,`created_dt`,`updated_by`,`updated_dt`) values 
(1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2018-09-06 15:20:40',NULL,NULL),
(5,4,NULL,33.00,44.00,NULL,NULL,NULL,NULL,NULL,NULL,'2018-09-06 17:03:57',NULL,NULL),
(4,5,NULL,99.00,99.00,NULL,NULL,NULL,NULL,NULL,NULL,'2018-09-06 17:03:37',NULL,NULL);

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) DEFAULT NULL,
  `pwd` varchar(100) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `user` */

insert  into `user`(`id`,`user_id`,`pwd`,`name`) values 
(1,'azman','1234','Azman bin Zakaria'),
(2,'abu','1234','Abu Hassan');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
