/*
SQLyog Ultimate v8.61 
MySQL - 5.5.5-10.1.19-MariaDB : Database - simdocencia
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`simdocencia` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `simdocencia`;

/*Table structure for table `nogradoestudios` */

DROP TABLE IF EXISTS `nogradoestudios`;

CREATE TABLE `nogradoestudios` (
  `id_gradoestudios` int(11) NOT NULL AUTO_INCREMENT,
  `grado_estudios` varchar(250) DEFAULT NULL,
  `activo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_gradoestudios`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `nogradoestudios` */

insert  into `nogradoestudios`(`id_gradoestudios`,`grado_estudios`,`activo`) values (1,'Licenciatura',1),(2,'Ingeniería',1),(3,'Certificaciones',1),(4,'Posgrado',1),(5,'Perfil',1),(6,'Técnico',1),(7,'Maestría',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
