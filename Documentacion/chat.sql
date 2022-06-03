/*
SQLyog Ultimate v8.61 
MySQL - 5.5.5-10.1.19-MariaDB : Database - sim
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`sim` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci */;

USE `sim`;

/*Table structure for table `nochat` */

DROP TABLE IF EXISTS `nochat`;

CREATE TABLE `nochat` (
  `CHClave` int(11) NOT NULL AUTO_INCREMENT,
  `CHUsuario_envia` int(11) DEFAULT NULL,
  `CHUsuario_recibe` int(11) DEFAULT NULL,
  `CHNombre` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CHMensaje` longtext COLLATE utf8_spanish_ci,
  `CHLeido` int(1) DEFAULT '0',
  `CHFecha_registro` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`CHClave`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
