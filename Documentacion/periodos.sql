CREATE TABLE `nocperiodos` (
  `CPEClave` int(11) DEFAULT NULL,
  `CPEPeriodo` varchar(18) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CPEDiaInicio` varchar(6) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CPEMesInicio` varchar(6) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CPEAnioInicio` varchar(12) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CPEDiaFin` varchar(6) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CPEMesFin` varchar(6) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CPEAnioFin` varchar(12) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CPEStatus` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

insert  into `nocperiodos`(`CPEClave`,`CPEPeriodo`,`CPEDiaInicio`,`CPEMesInicio`,`CPEAnioInicio`,`CPEDiaFin`,`CPEMesFin`,`CPEAnioFin`,`CPEStatus`) values (1,'19-1','05','02','2019','12','07','2019',1),(2,'19-2','12','08','2019','16','01','2020',1);
