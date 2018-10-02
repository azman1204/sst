/*
SQLyog Community v13.1.1 (64 bit)
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

/*Table structure for table `kaunseling` */

DROP TABLE IF EXISTS `kaunseling`;

CREATE TABLE `kaunseling` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pendaftaran` int(11) DEFAULT NULL,
  `telah_kaunseling` char(1) DEFAULT NULL,
  `tkh_kaunseling` date DEFAULT NULL,
  `sts_saringan` char(1) DEFAULT NULL,
  `catatan` text,
  `sebab_cicir` varchar(2) DEFAULT NULL,
  `diagnosis_akhir` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `kaunseling` */

/*Table structure for table `klinik` */

DROP TABLE IF EXISTS `klinik`;

CREATE TABLE `klinik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `id_pkd` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `klinik` */

insert  into `klinik`(`id`,`nama`,`id_pkd`) values 
(1,'KK 1',NULL),
(2,'KK 2',NULL);

/*Table structure for table `kod_ujian` */

DROP TABLE IF EXISTS `kod_ujian`;

CREATE TABLE `kod_ujian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kod_ujian` varchar(30) DEFAULT NULL,
  `kat_ujian` varchar(3) DEFAULT NULL COMMENT 'HB / DNA',
  `kat_keputusan` varchar(300) DEFAULT NULL,
  `tindakan_lanjut` varchar(500) DEFAULT NULL,
  `diag_akhir` varchar(500) DEFAULT NULL,
  `analisis` varchar(500) DEFAULT NULL,
  `perlu_diag` char(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `kod_ujian` */

insert  into `kod_ujian`(`id`,`kod_ujian`,`kat_ujian`,`kat_keputusan`,`tindakan_lanjut`,`diag_akhir`,`analisis`,`perlu_diag`) values 
(1,'R1','HB','Sampel ditolak','Ulang pengambilan sampel\r\n',NULL,NULL,'Y'),
(2,'N','HB','Normal',NULL,NULL,'No abnormality detected\r\n','T'),
(3,'R1','DNA','Sampel ditolak','Ulang pengambilan sampel\r\n',NULL,'Rejected sample (need to repeat eg clotted,leaking,insufficient)*\r\n',''),
(4,'NAD\r\n','DNA',NULL,'Kaunseling\r\n',NULL,'No abnormality detected\r\n','');

/*Table structure for table `kump_etnik` */

DROP TABLE IF EXISTS `kump_etnik`;

CREATE TABLE `kump_etnik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `kump_etnik` */

insert  into `kump_etnik`(`id`,`nama`) values 
(1,'Melayu'),
(2,'Cina'),
(3,'India'),
(4,'Orang Asli'),
(5,'Bumiputera Sabah'),
(6,'Bumiputera Sarawak'),
(7,'Siam'),
(8,'Pertugis');

/*Table structure for table `pecahan_etnik` */

DROP TABLE IF EXISTS `pecahan_etnik`;

CREATE TABLE `pecahan_etnik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_etnik` int(11) DEFAULT NULL,
  `nama_pecahan` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `pecahan_etnik` */

insert  into `pecahan_etnik`(`id`,`id_etnik`,`nama_pecahan`) values 
(1,3,'India'),
(2,3,'Punjabi'),
(3,3,'Sinhalese'),
(4,5,'Banjau'),
(5,5,'Banjar');

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
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Data for the table `pendaftaran` */

insert  into `pendaftaran`(`id`,`nama`,`nokp`,`kebenaran`,`alamat`,`tel`,`jantina`,`tkh_lahir`,`umur`,`id_sekolah`,`id_klinik`,`kump_etnik`,`pecahan_etnik`,`created_dt`,`created_by`,`updated_dt`,`updated_by`) values 
(12,'azman zakaria','123456789013',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2018-09-19 15:56:29',NULL,NULL,NULL),
(13,'Zakaria bin Wahab','123456789014','Y','No 123',NULL,'L','2018-09-19',NULL,2,1,3,2,'2018-09-19 16:11:54',NULL,NULL,NULL),
(14,'john doe','123456789018','T','test 123','0162809998','P','2015-09-14',3,2,1,3,3,'2018-09-19 16:23:48',NULL,NULL,NULL),
(15,'Mr ABC','123456789019','Y','abc','0162809998','L','2016-09-20',2,2,1,3,2,'2018-09-20 11:43:49',NULL,NULL,NULL);

/*Table structure for table `rujukan` */

DROP TABLE IF EXISTS `rujukan`;

CREATE TABLE `rujukan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kat` varchar(25) DEFAULT NULL,
  `kod` varchar(25) DEFAULT NULL,
  `keterangan` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `rujukan` */

insert  into `rujukan`(`id`,`kat`,`kod`,`keterangan`) values 
(1,'diag_temp','1','NORMAL'),
(2,'diag_temp','2','TRO IDA'),
(3,'diag_temp','3','TRO PEMBAWA TALASEMIA'),
(4,'diag_temp','4','LAIN-LAIN'),
(5,'diag_temp','5','CONFIRM IDA'),
(6,'yt','Y','Ya'),
(7,'yt','T','Tidak'),
(8,'sebab_cicir','1','Tidak Menjalani Ujian BC'),
(9,'sebab_cicir','2','Enggan'),
(10,'sebab_cicir','3','Pindah');

/*Table structure for table `sekolah` */

DROP TABLE IF EXISTS `sekolah`;

CREATE TABLE `sekolah` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `alamat` varchar(300) DEFAULT NULL,
  `id_klinik` int(11) DEFAULT NULL COMMENT 'see klinik_kesihatan.id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `sekolah` */

insert  into `sekolah`(`id`,`nama`,`alamat`,`id_klinik`) values 
(1,'SEK MEN A',NULL,1),
(2,'SEK MEN B',NULL,1),
(3,'SEK MEN C',NULL,2);

/*Table structure for table `ujian_pengesahan` */

DROP TABLE IF EXISTS `ujian_pengesahan`;

CREATE TABLE `ujian_pengesahan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pendaftaran` int(11) DEFAULT NULL,
  `tkh_hbhantar` date DEFAULT NULL,
  `tkh_hbkeputusan` date DEFAULT NULL,
  `kod_hbkeputusan` varchar(5) DEFAULT NULL,
  `diag_molekular` char(1) DEFAULT NULL,
  `tkh_dnahantar` date DEFAULT NULL,
  `tkh_dnakeputusan` date DEFAULT NULL,
  `kod_dnakeputusan` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `ujian_pengesahan` */

/*Table structure for table `ujian_saringan` */

DROP TABLE IF EXISTS `ujian_saringan`;

CREATE TABLE `ujian_saringan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pendaftaran` int(11) NOT NULL,
  `menjalani_ujian` char(1) DEFAULT 'Y' COMMENT 'Y = ya / T = Tidak',
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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `ujian_saringan` */

insert  into `ujian_saringan`(`id`,`id_pendaftaran`,`menjalani_ujian`,`tkh_ujian`,`hb`,`mch`,`mcv`,`mchc`,`rdw`,`rbc`,`id_diag_sementara`,`created_by`,`created_dt`,`updated_by`,`updated_dt`) values 
(6,14,'T',NULL,2.00,1.00,3.00,1.00,4.00,1.00,2,NULL,'2018-09-20 11:26:28',NULL,NULL),
(7,15,'Y','2018-09-27',4.00,4.00,4.00,4.00,4.00,4.00,2,NULL,'2018-09-20 12:04:45',NULL,NULL);

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

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
