SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema bd_proteccion_civil
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `bd_proteccion_civil` ;
CREATE SCHEMA IF NOT EXISTS `bd_proteccion_civil` DEFAULT CHARACTER SET utf8 ;
USE `bd_proteccion_civil` ;

-- -----------------------------------------------------
-- Table `bd_proteccion_civil`.`patrullas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bd_proteccion_civil`.`patrullas` ;

CREATE TABLE IF NOT EXISTS `bd_proteccion_civil`.`patrullas` (
  `id_patrullas` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `clave` INT(11) NOT NULL,
  PRIMARY KEY (`id_patrullas`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_proteccion_civil`.`datos_personales`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bd_proteccion_civil`.`datos_personales` ;

CREATE TABLE IF NOT EXISTS `bd_proteccion_civil`.`datos_personales` (
  `id_num_reg` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `apellido_p` VARCHAR(45) NOT NULL,
  `apellido_m` VARCHAR(45) NULL DEFAULT NULL,
  `fecha_nac` VARCHAR(10) NULL DEFAULT NULL,
  `dom_calle` VARCHAR(45) NULL DEFAULT NULL,
  `dom_num_ext` VARCHAR(15) NULL DEFAULT NULL,
  `dom_num_int` VARCHAR(15) NULL DEFAULT NULL,
  `dom_col` VARCHAR(45) NULL DEFAULT NULL,
  `dom_del_mun` VARCHAR(45) NULL DEFAULT NULL,
  `dom_estado` VARCHAR(45) NULL DEFAULT NULL,
  `dom_cp` INT(5) NULL DEFAULT NULL,
  `telefono_casa` VARCHAR(13) NULL DEFAULT NULL,
  `telefono_celular` VARCHAR(13) NULL DEFAULT NULL,
  `telefono_trabajo` VARCHAR(20) NULL DEFAULT NULL,
  `telefono_extension` VARCHAR(10) NULL DEFAULT NULL,
  `email` VARCHAR(50) NULL DEFAULT NULL,
  `email_red_social` VARCHAR(50) NULL DEFAULT NULL,
  `contrasenia` VARCHAR(16) NULL DEFAULT NULL,
  `tipo_cuenta` ENUM('USUARIO','JEFE','ADMIN') NULL DEFAULT NULL,
  `contacto1` VARCHAR(80) NULL DEFAULT NULL,
  `contacto2` VARCHAR(80) NULL DEFAULT NULL,
  `telefono_c1` VARCHAR(13) NULL DEFAULT NULL,
  `telefono_c2` VARCHAR(13) NULL DEFAULT NULL,
  `calidad_miembro` ENUM('ACTIVO','INACTIVO','BAJA','SUSPENDIDO') NULL DEFAULT NULL,
  `fecha_registro` TEXT NULL,
  `fotografia` TEXT NULL,
  `patrullas_id_patrullas` INT(11) NOT NULL,
  PRIMARY KEY (`id_num_reg`, `patrullas_id_patrullas`),
  INDEX `fk_datos_personales_patrullas1_idx` (`patrullas_id_patrullas` ASC),
  CONSTRAINT `fk_datos_personales_patrullas1`
    FOREIGN KEY (`patrullas_id_patrullas`)
    REFERENCES `bd_proteccion_civil`.`patrullas` (`id_patrullas`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 11
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_proteccion_civil`.`documentos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bd_proteccion_civil`.`documentos` ;

CREATE TABLE IF NOT EXISTS `bd_proteccion_civil`.`documentos` (
  `acta_nacimiento` TEXT NULL DEFAULT NULL,
  `curp` TEXT NULL DEFAULT NULL,
  `ife` TEXT NULL DEFAULT NULL,
  `comprobante_dom` TEXT NULL DEFAULT NULL,
  `curriculum` TEXT NULL DEFAULT NULL,
  `licencia_manejo` TEXT NULL DEFAULT NULL,
  `cedula_profesional` TEXT NULL DEFAULT NULL,
  `cartilla_servicio_militar` TEXT NULL DEFAULT NULL,
  `carnet_afiliacion` TEXT NULL DEFAULT NULL,
  `pasaporte` TEXT NULL DEFAULT NULL,
  `datos_personales_id_num_reg` INT(11) NOT NULL,
  PRIMARY KEY (`datos_personales_id_num_reg`),
  CONSTRAINT `fk_documentos_datos_personales`
    FOREIGN KEY (`datos_personales_id_num_reg`)
    REFERENCES `bd_proteccion_civil`.`datos_personales` (`id_num_reg`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_proteccion_civil`.`antecedentes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bd_proteccion_civil`.`antecedentes` ;

CREATE TABLE IF NOT EXISTS `bd_proteccion_civil`.`antecedentes` (
  `cargos_anteriores` VARCHAR(50) NULL DEFAULT NULL,
  `patrullero` ENUM('SI','NO') NULL DEFAULT NULL,
  `fecha_graduacion` VARCHAR(50) NULL DEFAULT NULL,
  `fecha_ingreso` VARCHAR(50) NULL DEFAULT NULL,
  `dir_ccpp` TEXT NULL DEFAULT NULL,
  `datos_personales_id_num_reg` INT(11) NOT NULL,
  PRIMARY KEY (`datos_personales_id_num_reg`),
  CONSTRAINT `fk_experiencia_datos_personales1`
    FOREIGN KEY (`datos_personales_id_num_reg`)
    REFERENCES `bd_proteccion_civil`.`datos_personales` (`id_num_reg`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_proteccion_civil`.`datos_complementarios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bd_proteccion_civil`.`datos_complementarios` ;

CREATE TABLE IF NOT EXISTS `bd_proteccion_civil`.`datos_complementarios` (
  `estado_civil` ENUM('SOLTERO','CASADO','DIVORCIADO','VIUDO') NULL DEFAULT NULL,
  `ocupacion` VARCHAR(45) NULL DEFAULT NULL,
  `escolaridad` VARCHAR(45) NULL DEFAULT NULL,
  `edad` INT(2) NULL DEFAULT NULL,
  `trabajo_escuela` VARCHAR(45) NULL DEFAULT NULL,
  `nacionalidad` VARCHAR(45) NULL DEFAULT NULL,
  `cartilla_num` VARCHAR(10) NULL DEFAULT NULL,
  `licencia_tipo` ENUM('AUTOMOVILISTA','CHOFER DE SERVICIO PARTICULAR','MOTOCICLISTA','PERMISO PROVICIONAL A','PERMISO PROVICIONAL B','DUPLICADO','SERVICIO PÚBLICO') NULL DEFAULT NULL,
  `licencia_num` VARCHAR(20) NULL DEFAULT NULL,
  `pasaporte` VARCHAR(15) NULL DEFAULT NULL,
  `datos_personales_id_num_reg` INT(11) NOT NULL,
  PRIMARY KEY (`datos_personales_id_num_reg`),
  CONSTRAINT `fk_datos_complementarios_datos_personales`
    FOREIGN KEY (`datos_personales_id_num_reg`)
    REFERENCES `bd_proteccion_civil`.`datos_personales` (`id_num_reg`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_proteccion_civil`.`estados`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bd_proteccion_civil`.`estados` ;

CREATE TABLE IF NOT EXISTS `bd_proteccion_civil`.`estados` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `clave` VARCHAR(2) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `abrev` VARCHAR(16) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = MyISAM
AUTO_INCREMENT = 33
DEFAULT CHARACTER SET = utf8
COMMENT = 'Tabla de Estados de la República Mexicana';

LOCK TABLES `estados` WRITE;
/*!40000 ALTER TABLE `estados` DISABLE KEYS */;
INSERT INTO `estados` VALUES (1,'01','AGUASCALIENTES','Ags.'),(2,'02','BAJA CALIFORNIA','BC'),(3,'03','BAJA CALIFORNIA SUR','BCS'),
(4,'04','CAMPECHE','Camp.'),(5,'05','COAHUILA','Coah.'),(6,'06','COLIMA','Col.'),(7,'07','CHIAPAS','Chis.'),(8,'08','CHIHUAHUA','Chih.'),
(9,'09','DISTRITO FEDERAL','DF'),(10,'10','DURANGO','Dgo.'),(11,'11','ESTADO DE MÉXICO','Mex.'),(12,'12','GUANAJUATO','Gto.'),
(13,'13','GUERRERO','Gro.'),(14,'14','HIDALGO','Hgo.'),(15,'15','JALISCO','Jal.'),(16,'16','MICHOACÁN','Mich.'),
(17,'17','MORELOS','Mor.'),(18,'18','NAYARIT','Nay.'),(19,'19','NUEVO LEÓN','NL'),(20,'20','OAXACA','Oax.'),
(21,'21','PUEBLA','Pue.'),(22,'22','QUERETARO','Qro.'),(23,'23','QUINTANA ROO','Q. Roo'),(24,'24','SAN LUIS POTOSÍ','SLP'),
(25,'25','SINALOA','Sin.'),(26,'26','SONORA','Son.'),(27,'27','TABASCO','Tab.'),(28,'28','TAMAULIPAS','Tamps.'),
(29,'29','TLAXCALA','Tlax.'),(30,'30','VERACRUZ','Ver.'),(31,'31','YUCATÁN','Yuc.'),(32,'32','ZACATECAS','Zac.');
/*!40000 ALTER TABLE `estados` ENABLE KEYS */;
UNLOCK TABLES;


-- -----------------------------------------------------
-- Table `bd_proteccion_civil`.`info_fisica`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bd_proteccion_civil`.`info_fisica` ;

CREATE TABLE IF NOT EXISTS `bd_proteccion_civil`.`info_fisica` (
  `genero` ENUM('HOMBRE','MUJER','OTRO') NULL DEFAULT NULL,
  `estatura` FLOAT NULL DEFAULT NULL,
  `peso` FLOAT NULL DEFAULT NULL,
  `complexion` TEXT NULL DEFAULT NULL,
  `cabello` VARCHAR(20) NULL DEFAULT NULL,
  `ojos` VARCHAR(20) NULL DEFAULT NULL,
  `cara` VARCHAR(30) NULL DEFAULT NULL,
  `nariz` VARCHAR(20) NULL DEFAULT NULL,
  `senias_particulares` TEXT NULL DEFAULT NULL,
  `datos_personales_id_num_reg` INT(11) NOT NULL,
  PRIMARY KEY (`datos_personales_id_num_reg`),
  CONSTRAINT `fk_info_fisica_datos_personales1`
    FOREIGN KEY (`datos_personales_id_num_reg`)
    REFERENCES `bd_proteccion_civil`.`datos_personales` (`id_num_reg`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_proteccion_civil`.`info_medica`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bd_proteccion_civil`.`info_medica` ;

CREATE TABLE IF NOT EXISTS `bd_proteccion_civil`.`info_medica` (
  `tipo_sangre` ENUM('A+','A-','B+','B-','AB+','AB-','O+','O-') NULL DEFAULT NULL,
  `padecimientos_limitfisicas` TEXT NULL DEFAULT NULL,
  `alergias` TEXT NULL DEFAULT NULL,
  `servicio_medico` ENUM('IMSS','ISSSTE','PEMEX','SEGURO POPULAR','PARTICULAR') NULL DEFAULT NULL,
  `datos_personales_id_num_reg` INT(11) NOT NULL,
  PRIMARY KEY (`datos_personales_id_num_reg`),
  CONSTRAINT `fk_info_medica_datos_personales1`
    FOREIGN KEY (`datos_personales_id_num_reg`)
    REFERENCES `bd_proteccion_civil`.`datos_personales` (`id_num_reg`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_proteccion_civil`.`super_usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bd_proteccion_civil`.`super_usuario` ;

CREATE TABLE IF NOT EXISTS `bd_proteccion_civil`.`super_usuario` (
  `admin` VARCHAR(10) NOT NULL,
  `contrasenia` VARCHAR(45) NULL,
  PRIMARY KEY (`admin`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bd_proteccion_civil`.`experiencia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bd_proteccion_civil`.`experiencia` ;

CREATE TABLE IF NOT EXISTS `bd_proteccion_civil`.`experiencia` (
  `experiencia` TEXT NULL,
  `datos_personales_id_num_reg` INT(11) NOT NULL,
  INDEX `fk_experiencia_datos_personales2_idx` (`datos_personales_id_num_reg` ASC),
  CONSTRAINT `fk_experiencia_datos_personales2`
    FOREIGN KEY (`datos_personales_id_num_reg`)
    REFERENCES `bd_proteccion_civil`.`datos_personales` (`id_num_reg`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bd_proteccion_civil`.`vacunas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bd_proteccion_civil`.`vacunas` ;

CREATE TABLE IF NOT EXISTS `bd_proteccion_civil`.`vacunas` (
  `vacunas` TEXT NULL,
  `datos_personales_id_num_reg` INT(11) NOT NULL,
  CONSTRAINT `fk_vacunas_datos_personales1`
    FOREIGN KEY (`datos_personales_id_num_reg`)
    REFERENCES `bd_proteccion_civil`.`datos_personales` (`id_num_reg`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
