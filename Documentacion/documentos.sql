CREATE TABLE `nodocper` (
  `DPClave` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clave de Documentos de usuario',
  `DPPersonal` int(11) DEFAULT NULL,
  `DPRFC` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `DPCURP` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `DPCredencial_elector` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `DPCertificado_estudios` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `DPMov_ISSEMYM` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `DPCuenta` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Cuenta Bancaria',
  PRIMARY KEY (`DPClave`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;