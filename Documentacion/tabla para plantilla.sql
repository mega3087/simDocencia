CREATE TABLE `sim`.`noplantilla`(     
`PClave` INT NOT NULL AUTO_INCREMENT ,     
`PPeriodo` VARCHAR(255) ,  
`PPlantel` INT ,  
`PPlantilla` VARCHAR(255) ,     
`PUsuario_registro` INT,
`PFecha_registro` DATETIME DEFAULT CURRENT_TIMESTAMP,
`PUsuario_modificacion` INT,
`PFecha_modificacion` DATETIME,
`PActivo` INT(1) DEFAULT 1,
PRIMARY KEY (`PClave`) 
);