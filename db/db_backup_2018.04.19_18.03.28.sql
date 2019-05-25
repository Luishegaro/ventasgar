-- -------------------------------------------
SET AUTOCOMMIT=0;
START TRANSACTION;
SET SQL_QUOTE_SHOW_CREATE = 1;
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
-- -------------------------------------------
-- -------------------------------------------
-- START BACKUP
-- -------------------------------------------
-- -------------------------------------------
-- TABLE `activo`
-- -------------------------------------------
DROP TABLE IF EXISTS `activo`;
CREATE TABLE IF NOT EXISTS `activo` (
  `id_activo` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(15) NOT NULL,
  `detalle` varchar(500) NOT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `cuenta` enum('MAQUINARIA GENERAL','EQUIPO PESADO','HERRAMIENTAS','VEHICULO') NOT NULL DEFAULT 'MAQUINARIA GENERAL',
  `_registrado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `_usuario` varchar(64) NOT NULL,
  `_estado` varchar(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`id_activo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `auth_user`
-- -------------------------------------------
DROP TABLE IF EXISTS `auth_user`;
CREATE TABLE IF NOT EXISTS `auth_user` (
  `username` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `auth_key` varchar(64) DEFAULT NULL,
  `access_token` varchar(64) DEFAULT NULL,
  `last_login_ip` int(11) DEFAULT NULL,
  `last_login_at` int(11) DEFAULT NULL,
  `fullname` varchar(64) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `cliente`
-- -------------------------------------------
DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `placa` varchar(100) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `deuda` float DEFAULT '0',
  `_registrado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `_usuario` varchar(20) NOT NULL,
  `_estado` varchar(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `detalle`
-- -------------------------------------------
DROP TABLE IF EXISTS `detalle`;
CREATE TABLE IF NOT EXISTS `detalle` (
  `id_venta` bigint(20) NOT NULL,
  `id_material` int(11) NOT NULL,
  `cantidad` decimal(11,2) NOT NULL DEFAULT '0.00',
  `precio` decimal(11,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id_material`,`id_venta`),
  KEY `id_venta` (`id_venta`),
  KEY `id_material` (`id_material`),
  CONSTRAINT `detalle_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `venta` (`id_venta`),
  CONSTRAINT `detalle_ibfk_2` FOREIGN KEY (`id_material`) REFERENCES `material` (`id_material`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `gasto`
-- -------------------------------------------
DROP TABLE IF EXISTS `gasto`;
CREATE TABLE IF NOT EXISTS `gasto` (
  `id_gasto` bigint(20) NOT NULL AUTO_INCREMENT,
  `numero` int(11) NOT NULL DEFAULT '0',
  `nro_factura` varchar(100) DEFAULT NULL,
  `fecha` date NOT NULL,
  `pagado_a` varchar(100) NOT NULL,
  `concepto` text NOT NULL,
  `tipo` enum('FUNCIONAMIENTO','MANTENIMIENTO','REPARACION','OTROS') NOT NULL DEFAULT 'FUNCIONAMIENTO',
  `monto` decimal(11,2) NOT NULL DEFAULT '0.00',
  `observacion` text,
  `id_activo` int(11) DEFAULT NULL,
  `_estado` varchar(1) NOT NULL DEFAULT 'A',
  `_registrado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `_usuario` varchar(64) NOT NULL,
  PRIMARY KEY (`id_gasto`),
  KEY `id_activo` (`id_activo`),
  CONSTRAINT `gasto_ibfk_1` FOREIGN KEY (`id_activo`) REFERENCES `activo` (`id_activo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `material`
-- -------------------------------------------
DROP TABLE IF EXISTS `material`;
CREATE TABLE IF NOT EXISTS `material` (
  `id_material` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `precio` decimal(11,2) NOT NULL,
  `_registrado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `_usuario` varchar(20) NOT NULL,
  PRIMARY KEY (`id_material`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `pago`
-- -------------------------------------------
DROP TABLE IF EXISTS `pago`;
CREATE TABLE IF NOT EXISTS `pago` (
  `id_pago` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) NOT NULL DEFAULT '0',
  `pagado_a` varchar(200) DEFAULT NULL,
  `concepto` text,
  `fecha` date DEFAULT NULL,
  `tipo` varchar(1) NOT NULL DEFAULT '0',
  `monto` decimal(11,2) DEFAULT '0.00',
  `id_venta` bigint(20) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `_estado` varchar(1) NOT NULL DEFAULT 'A',
  `_registrado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `_usuario` varchar(20) NOT NULL,
  PRIMARY KEY (`id_pago`),
  KEY `id_venta` (`id_venta`),
  KEY `id_cliente` (`id_cliente`),
  CONSTRAINT `pago_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `venta` (`id_venta`),
  CONSTRAINT `pago_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `proveedor`
-- -------------------------------------------
DROP TABLE IF EXISTS `proveedor`;
CREATE TABLE IF NOT EXISTS `proveedor` (
  `id_proveedor` bigint(20) NOT NULL AUTO_INCREMENT,
  `ci_nit` varchar(18) NOT NULL DEFAULT '0',
  `nombre` varchar(64) NOT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `_estado` varchar(1) NOT NULL DEFAULT 'A',
  `_registrado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `_usuario` varchar(64) NOT NULL,
  PRIMARY KEY (`id_proveedor`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `venta`
-- -------------------------------------------
DROP TABLE IF EXISTS `venta`;
CREATE TABLE IF NOT EXISTS `venta` (
  `id_venta` bigint(20) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `numero` bigint(20) DEFAULT '0',
  `cancelado` decimal(11,2) NOT NULL DEFAULT '0.00',
  `tipo` int(11) NOT NULL DEFAULT '0',
  `total` decimal(11,2) NOT NULL DEFAULT '0.00',
  `saldo` decimal(11,2) NOT NULL DEFAULT '0.00',
  `observacion` text,
  `id_cliente` int(11) NOT NULL,
  `_registrado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `_usuario` varchar(20) NOT NULL,
  `_estado` varchar(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`id_venta`),
  KEY `id_cliente` (`id_cliente`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE DATA activo
-- -------------------------------------------
INSERT INTO `activo` (`id_activo`,`codigo`,`detalle`,`foto`,`cuenta`,`_registrado`,`_usuario`,`_estado`) VALUES
('2','V-VOL-1','CAMION VOLVO PLACA 854 AZUL','','VEHICULO','2018-02-09 16:26:44','admin','A');;;
INSERT INTO `activo` (`id_activo`,`codigo`,`detalle`,`foto`,`cuenta`,`_registrado`,`_usuario`,`_estado`) VALUES
('3','V-VOL-2','CAMION VOLVO PLACA 854 RCC MOD 1989','','VEHICULO','2018-02-09 16:30:01','admin','A');;;
INSERT INTO `activo` (`id_activo`,`codigo`,`detalle`,`foto`,`cuenta`,`_registrado`,`_usuario`,`_estado`) VALUES
('4','V-VOL-3','CAMION VOLVO PLACA 1319 RCC MOD 1996','','VEHICULO','2018-02-09 16:32:31','admin','A');;;
INSERT INTO `activo` (`id_activo`,`codigo`,`detalle`,`foto`,`cuenta`,`_registrado`,`_usuario`,`_estado`) VALUES
('5','V-NIS-1320ZUA','VAGONETA NISSAN TERRANO PLACA 1320ZUA','','VEHICULO','2018-02-15 14:32:14','admin','A');;;
INSERT INTO `activo` (`id_activo`,`codigo`,`detalle`,`foto`,`cuenta`,`_registrado`,`_usuario`,`_estado`) VALUES
('6','V-MIT-3765ZUK','CAMIONETA MITSUBISHI L-200 PLACA 3765ZUK','','VEHICULO','2018-02-15 14:34:00','admin','A');;;
INSERT INTO `activo` (`id_activo`,`codigo`,`detalle`,`foto`,`cuenta`,`_registrado`,`_usuario`,`_estado`) VALUES
('7','E-CAT-81J5641','CARGADOR FRONTAL MARCA CATERPILAR CHASIS  81J5641','','EQUIPO PESADO','2018-02-15 14:34:00','admin','A');;;
INSERT INTO `activo` (`id_activo`,`codigo`,`detalle`,`foto`,`cuenta`,`_registrado`,`_usuario`,`_estado`) VALUES
('8','E-SEM-RAN-9AD','SEMIRREMOLQUE RANDON CHASIS 9ADB075344M204979','','EQUIPO PESADO','2018-02-23 16:31:23','admin','A');;;
INSERT INTO `activo` (`id_activo`,`codigo`,`detalle`,`foto`,`cuenta`,`_registrado`,`_usuario`,`_estado`) VALUES
('9','E-SEM-RAN-SR','SEMIRREMOLQUE RANDON TIPO SR BA AB 03 20','','EQUIPO PESADO','2018-02-23 16:33:06','admin','A');;;
INSERT INTO `activo` (`id_activo`,`codigo`,`detalle`,`foto`,`cuenta`,`_registrado`,`_usuario`,`_estado`) VALUES
('10','E-PC-CAT-0962','PALA CARGADORA CATERPILAR CHASIS CAT0962GV3BS00912','','EQUIPO PESADO','2018-02-23 16:34:12','admin','A');;;
INSERT INTO `activo` (`id_activo`,`codigo`,`detalle`,`foto`,`cuenta`,`_registrado`,`_usuario`,`_estado`) VALUES
('11','ANG','AMOLADORA ANG W26180W','','MAQUINARIA GENERAL','2018-02-23 16:36:57','admin','A');;;
INSERT INTO `activo` (`id_activo`,`codigo`,`detalle`,`foto`,`cuenta`,`_registrado`,`_usuario`,`_estado`) VALUES
('12','BOMBA ELEC','BOMBA ELECTRICA CORREA TRANSPORTADORA SIN FIN DE 4PLY','','MAQUINARIA GENERAL','2018-02-23 16:46:36','admin','A');;;
INSERT INTO `activo` (`id_activo`,`codigo`,`detalle`,`foto`,`cuenta`,`_registrado`,`_usuario`,`_estado`) VALUES
('13','ANCHO 24',' ANCHO 24 ESP 3 PERMITRO 24 MTS  CORREA TRANSPORTADORA SIN FIN 3 PLY','','MAQUINARIA GENERAL','2018-02-23 16:49:35','admin','A');;;
INSERT INTO `activo` (`id_activo`,`codigo`,`detalle`,`foto`,`cuenta`,`_registrado`,`_usuario`,`_estado`) VALUES
('14','ANCHO 20','ANCHO 20 ESP 3 PERIMETRO 24 METROS MANTLE PARA TRITURADORA CONICA ALLIS','','MAQUINARIA GENERAL','2018-02-23 16:50:07','admin','A');;;
INSERT INTO `activo` (`id_activo`,`codigo`,`detalle`,`foto`,`cuenta`,`_registrado`,`_usuario`,`_estado`) VALUES
('15','CHALMERS','CHALMERS','','MAQUINARIA GENERAL','2018-02-23 16:50:53','admin','A');;;
INSERT INTO `activo` (`id_activo`,`codigo`,`detalle`,`foto`,`cuenta`,`_registrado`,`_usuario`,`_estado`) VALUES
('16','MUELA','MUELA FIJA PARA CHANCADORA MANDIBULAS','','MAQUINARIA GENERAL','2018-02-23 16:51:16','admin','A');;;
INSERT INTO `activo` (`id_activo`,`codigo`,`detalle`,`foto`,`cuenta`,`_registrado`,`_usuario`,`_estado`) VALUES
('17','MUELA-2','MUELA MOVIL PARA CANCADORA','','MAQUINARIA GENERAL','2018-02-23 16:52:00','admin','A');;;
INSERT INTO `activo` (`id_activo`,`codigo`,`detalle`,`foto`,`cuenta`,`_registrado`,`_usuario`,`_estado`) VALUES
('18','CHATA','CHATA TOLBA CORREA TRANSPORTADORA SIN FIN DE 3 PYL','','MAQUINARIA GENERAL','2018-02-23 16:53:12','admin','A');;;
INSERT INTO `activo` (`id_activo`,`codigo`,`detalle`,`foto`,`cuenta`,`_registrado`,`_usuario`,`_estado`) VALUES
('19','ANCHO 20 3/8','ANCHO 20 ESP3/8 PEROMETRO 24 METROS','','MAQUINARIA GENERAL','2018-02-23 16:53:35','admin','A');;;
INSERT INTO `activo` (`id_activo`,`codigo`,`detalle`,`foto`,`cuenta`,`_registrado`,`_usuario`,`_estado`) VALUES
('20','SOPORTE','SOPORTE BRONCE PARA CONO','','MAQUINARIA GENERAL','2018-02-23 16:54:12','admin','A');;;
INSERT INTO `activo` (`id_activo`,`codigo`,`detalle`,`foto`,`cuenta`,`_registrado`,`_usuario`,`_estado`) VALUES
('21','CHANCADORA','CHANCADORA','','MAQUINARIA GENERAL','2018-02-23 16:54:28','admin','A');;;
-- -------------------------------------------
-- TABLE DATA auth_user
-- -------------------------------------------
INSERT INTO `auth_user` (`username`,`password`,`auth_key`,`access_token`,`last_login_ip`,`last_login_at`,`fullname`,`email`) VALUES
('admin','521e1a9c811df7dd2223bab70231521007a9bd4c','test100key','100-token','0','0','Administrador del Sistema','admin@mail.com');;;
INSERT INTO `auth_user` (`username`,`password`,`auth_key`,`access_token`,`last_login_ip`,`last_login_at`,`fullname`,`email`) VALUES
('contador','6a833895279d7d9464c39aecc9f336c0bafe7a2f','','','0','0','Margarita','-');;;
INSERT INTO `auth_user` (`username`,`password`,`auth_key`,`access_token`,`last_login_ip`,`last_login_at`,`fullname`,`email`) VALUES
('hegaro','24444d828dc0f098ef9064a11212e8e0ec97b398','','','0','0','hegaro','-');;;
-- -------------------------------------------
-- TABLE DATA cliente
-- -------------------------------------------
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('1','128-GAG','WILMAR','','','0','2017-09-06 23:35:48','100','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('2','789-FSD','HORACIO','','','0','2017-09-07 23:47:22','100','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('3','456-ñPL','ALAN WALKER','','','0','2017-09-11 23:37:01','100','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('4','UUU-7878','LEONARDO DAVINCI','','','0','2017-09-22 18:55:50','100','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('5','','MOISES RAMIREZ','','','0','2017-09-29 18:42:33','100','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('6','','RENE ANASGO','','','0','2017-09-29 18:43:52','100','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('7','','ORLANDO GONZALES','','','0','2017-09-29 18:44:28','100','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('8','','CARMELO HEREDIA','','','0','2017-09-29 18:47:56','100','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('9','','FERMIN HUANCA','','','0','2017-09-29 18:48:33','100','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('10','','BENITO','','','0','2017-09-29 18:49:49','100','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('11','','FREDY ZEBALLOS','','','0','2017-09-29 18:51:56','100','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('12','','J. LUIS SALDANA','','','0','2017-09-29 18:53:31','100','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('13','','MOISES CHOQUE','','','0','2017-09-29 18:54:36','100','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('14','','PEQUENO','','','0','2017-09-29 19:15:38','100','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('15','','SEDECA','','','-2400','2017-09-29 19:19:15','100','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('16','','BERNARDINO','','','0','2017-09-29 19:26:03','100','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('17','','EDUARDO RIOS','','','0','2017-09-29 19:28:10','100','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('18','','EUSEBIO GREGORIO','','','0','2017-09-29 19:29:22','100','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('19','','FLORENTINO PORTAL','','','0','2017-09-29 19:30:34','100','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('20','','EDUARDO MENDEZ','','','0','2017-09-29 19:41:49','100','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('21','789-RIP','DORA CACERES','','','0','2017-11-06 18:09:14','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('22','456-EAZ','HILARIO','','','0','2017-11-06 18:17:14','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('23','GG','GREGORIO GALLARDO','','','0','2017-11-06 18:57:14','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('24','LI','LUCIO INIGUEZ','','','0','2017-11-06 18:58:12','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('25','JV','JUVENAL VILCA','','','0','2017-11-06 19:00:28','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('26','GA','GENARO ARCE','','','-280','2017-11-06 19:01:27','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('27','JL','JOSE LUIS','','','0','2017-11-06 19:02:33','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('28','JLR','JOSE LUIS ROMERO','','','0','2017-11-06 19:03:32','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('29','L','LUIS','','','0','2017-11-06 19:04:16','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('30','BA','BERNARDO ARENAS','','','0','2017-11-06 19:04:59','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('31','G','GROBER','','','0','2017-11-06 19:05:42','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('32','NZ','NELSON ZERON','','','0','2017-11-06 19:06:38','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('33','YG','YERI GARZON','','','0','2017-11-06 19:07:57','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('34','R','RUBEN','','','0','2017-11-06 19:10:26','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('35','EG','EDWIN GONZALES','','','0','2017-11-06 19:15:36','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('36','JM','JUAN MENDOZA','','','0','2017-11-06 19:16:51','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('37','J','JESUS','','','0','2017-11-06 19:18:11','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('38','IB','IRMA BARRIO','','','0','2017-11-06 19:21:20','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('39','JZ','JESUS ZENTENO','','','0','2017-11-06 19:21:56','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('40','NA','NAZARIO ARAMAYO','','','0','2017-11-06 19:22:37','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('41','EZ','EMAR ZENTENO','','','0','2017-11-06 19:23:27','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('42','BS','BERNARDINO SEGOVIA','','','0','2017-11-06 19:24:40','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('43','','ANDRES RAMIREZ','','','0','2017-11-07 11:30:16','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('44','','MILTON ESTRADA','','','0','2017-11-07 15:10:27','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('45','JA','JORGE ARAGON','','','0','2017-11-07 16:22:44','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('46','EG','EYBER GARECA','','','0','2017-11-07 16:26:53','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('47','A','ANDRES','','','0','2017-11-07 16:28:13','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('48','AA','ADIA ABAN','','','0','2017-11-07 16:29:34','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('49','WM','WALTER MIRANDA','','','0','2017-11-07 16:36:03','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('50','WG','WILFREDO GARECA','','','0','2017-11-07 16:57:59','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('51','1319INK','HERLAN GARZON','71861524','','0','2017-11-07 17:35:03','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('52','','EDMUNDO RIVERA','','','0','2017-11-07 17:56:30','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('53','','ARICIL BALDIVIEZO','','','0','2017-11-07 18:00:59','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('54','','MANUEL TARIFA','','','0','2017-11-07 18:02:09','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('55','','SIXTO QUISPE','','','0','2017-12-06 17:55:57','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('56','','PEDRO ARROYO','','','0','2017-12-06 17:57:55','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('57','','ANDRéS LLUCANO','','','0','2017-12-06 18:00:56','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('58','','ANDRES LLUCANO','','','0','2017-12-06 18:01:27','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('59','','JAIME CHOQUE','','','0','2017-12-06 18:04:48','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('60','','VICTOR VILLA','','','0','2017-12-06 18:05:37','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('61','','SERAFíN MAMPAZO','','','0','2017-12-06 18:06:35','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('62','','MIGUEL NARVAEZ','','','280','2017-12-06 18:14:15','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('63','','JOSé LUIS NOGUERA','','','0','2017-12-06 18:36:23','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('64','','ORLANDO CUBA','','','0','2017-12-07 14:47:13','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('65','','RAMIRO BENITEZ','','','0','2017-12-07 14:53:20','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('66','','SEDECA CARACHIMAYO','','','-1920','2017-12-07 17:58:07','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('67','','SEDECA TEMPORAL','','','-5040','2017-12-07 17:58:31','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('68','FA','FROILAN ABAN','','','0','2018-01-04 10:28:36','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('69','BA','BERNARDINO ARENAS','','','0','2018-01-04 10:29:42','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('70','JS','JUAN CARLOS SORUCO','','','0','2018-01-04 10:33:32','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('71','MP','MARIO PORTAL','','','280','2018-01-04 10:53:00','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('72','RS','ROSMERI SEGOVIA','','','0','2018-01-04 11:13:58','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('73','FE','FELICIANO ESTRADA','','','0','2018-01-04 11:47:39','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('74','AA','AGAPITO ABAN','','','0','2018-01-04 11:49:13','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('75','RR','ROGELIO RAMIREZ','','','0','2018-01-04 11:52:59','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('76','SQ','SANTIAGO QUISPE','','','0','2018-01-04 11:56:37','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('77','NB','NESTOR BLANCO','','','0','2018-01-04 12:03:01','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('78','JS','JUANITO SEGOVIA','','','0','2018-01-05 15:57:08','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('79','RF','ROSANDEL FERNANDEZ','','','-350','2018-01-05 15:58:33','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('80','DG','DETERLINO GAITE','','','-500','2018-01-05 16:00:06','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('81','BB','BENITO BALDIVIEZO','','','0','2018-01-05 16:06:15','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('82','JT','JUANITO TICONA','','','0','2018-01-05 16:08:18','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('83','FG','FRANCISCO GUTIERREZ','','','0','2018-01-05 16:11:22','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('84','NC','NELSON CARI','','','0','2018-01-05 16:13:37','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('85','RS','ROLANDO SALDAÑA','','','0','2018-01-05 16:14:34','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('86','JL','JOSE LUIS SANCHEZ','','','0','2018-01-05 16:18:51','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('87','MM','MAICOL MENDEZ','','','0','2018-01-05 16:19:38','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('88','NE','NINFO ESTRADA','','','0','2018-01-06 09:07:16','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('89','JS','JORGE SILVERA','','','0','2018-01-06 09:10:10','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('90','GG','GROVER GONZALES','','','0','2018-01-06 09:11:16','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('91','ED','EDWIN','','','0','2018-01-06 10:02:30','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('92','JS','JOSE LUIS SALDAÑA','','','0','2018-01-06 10:08:31','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('93','RA','RENAN ALVAREZ','','','0','2018-01-06 10:17:13','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('94','YB','YAMIL BENITES','','','0','2018-01-06 10:22:06','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('95','LC','LISANDRA CONSTRUCCIONES','','','0','2018-01-06 10:23:05','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('96','YP','YONI PORTAL','','','0','2018-01-06 10:25:15','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('97','MG','MILTON GUERRERO','','','0','2018-01-06 10:26:26','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('98','EE','EDUARDO ESTRADA','','','0','2018-01-06 10:28:24','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('99','IV','ILARION VEDIA','','','0','2018-01-06 10:30:59','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('100','A','ABRAHAM','','','200','2018-01-06 10:33:20','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('101','DZ','DAVID ZENTENO','','','-350','2018-01-06 10:35:02','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('102','RO','ROSANDEL ORTEGA','','','0','2018-01-06 10:39:18','admin','A');;;
INSERT INTO `cliente` (`id_cliente`,`placa`,`nombre`,`telefono`,`direccion`,`deuda`,`_registrado`,`_usuario`,`_estado`) VALUES
('103','MF','MARIO FLORES','','','-360','2018-01-06 10:40:23','admin','A');;;
-- -------------------------------------------
-- TABLE DATA detalle
-- -------------------------------------------
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('5','1','1.50','150.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('9','1','2.00','200.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('10','1','4.00','400.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('11','1','4.00','400.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('12','1','3.50','350.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('14','1','3.50','380.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('15','1','4.00','400.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('16','1','4.00','400.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('20','1','4.00','400.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('27','1','1.50','150.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('28','1','3.50','350.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('29','1','3.50','350.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('30','1','4.00','400.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('31','1','2.00','200.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('32','1','2.00','200.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('35','1','4.00','400.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('37','1','4.00','400.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('39','1','1.00','100.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('44','1','2.00','200.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('55','1','4.00','400.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('56','1','3.50','350.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('57','1','4.00','400.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('58','1','4.00','400.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('59','1','4.00','400.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('64','1','2.00','200.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('69','1','6.00','600.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('74','1','3.50','350.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('75','1','4.00','400.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('76','1','2.00','200.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('80','1','2.00','200.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('81','1','1.50','150.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('85','1','2.00','200.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('86','1','3.00','300.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('87','1','2.00','200.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('88','1','5.00','500.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('96','1','5.00','500.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('97','1','5.00','500.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('98','1','5.00','500.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('99','1','5.00','500.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('100','1','4.00','400.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('101','1','2.00','200.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('102','1','3.00','300.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('104','1','5.00','500.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('106','1','4.00','400.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('107','1','9.00','900.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('85','2','2.00','160.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('87','2','2.00','160.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('89','2','4.00','320.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('91','2','8.00','640.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('92','2','2.00','160.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('94','2','1.00','80.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('100','2','3.00','240.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('101','2','2.00','160.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('102','2','3.00','240.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('106','2','8.00','640.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('107','2','8.00','640.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('108','2','4.00','312.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('1','3','3.50','263.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('2','3','4.00','300.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('3','3','3.50','263.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('4','3','2.00','150.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('5','3','2.00','150.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('7','3','3.00','225.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('8','3','4.00','300.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('13','3','4.00','300.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('18','3','4.00','300.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('21','3','2.00','150.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('22','3','4.00','300.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('23','3','3.50','263.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('24','3','1.50','113.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('25','3','3.50','263.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('26','3','1.00','75.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('27','3','2.00','150.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('28','3','3.50','263.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('29','3','3.50','263.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('31','3','2.00','150.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('33','3','4.00','300.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('36','3','1.00','75.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('38','3','4.00','300.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('39','3','3.00','225.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('40','3','4.00','300.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('41','3','3.00','225.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('42','3','4.00','300.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('43','3','1.50','113.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('44','3','2.00','150.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('45','3','2.00','150.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('46','3','2.00','150.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('48','3','4.00','300.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('50','3','4.00','300.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('51','3','4.00','300.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('53','3','3.60','270.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('54','3','4.00','300.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('55','3','4.00','300.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('60','3','4.00','300.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('61','3','4.00','300.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('65','3','3.50','263.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('67','3','4.00','300.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('68','3','2.00','150.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('69','3','6.00','450.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('71','3','4.00','300.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('72','3','4.00','300.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('80','3','2.00','150.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('81','3','2.00','150.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('82','3','4.00','300.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('83','3','4.00','300.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('84','3','4.00','300.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('90','3','5.00','400.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('92','3','5.00','400.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('93','3','8.00','640.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('94','3','7.00','560.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('101','3','2.00','160.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('108','3','8.00','640.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('93','4','8.00','200.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('98','4','5.00','125.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('101','4','2.00','50.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('103','4','2.00','50.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('105','4','12.00','300.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('6','5','4.00','280.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('19','5','3.50','245.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('47','5','4.00','280.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('49','5','4.00','280.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('52','5','4.00','280.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('63','5','4.00','280.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('64','5','2.00','140.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('66','5','4.00','280.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('70','5','4.00','280.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('77','5','4.00','280.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('78','5','4.00','280.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('79','5','4.00','280.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('103','5','2.00','140.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('17','6','4.00','360.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('34','6','3.50','315.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('62','6','3.50','315.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('73','7','4.00','80.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('95','9','2.00','250.00');;;
INSERT INTO `detalle` (`id_venta`,`id_material`,`cantidad`,`precio`) VALUES
('95','10','2.00','200.00');;;
-- -------------------------------------------
-- TABLE DATA gasto
-- -------------------------------------------
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('1','0','','2018-01-02','FABIAN','ALQUILER GRUA P/PROBAR LOS REVESTIMIENTOS DEL CONO GRANDE, R-970','FUNCIONAMIENTO','400.00','','0','A','2018-01-04 18:55:41','admin');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('2','0','','2018-01-02','VARIOS','VENENO PARA LOS POSTES, S/R','FUNCIONAMIENTO','150.00','','0','A','2018-01-04 19:29:53','admin');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('3','0','','2018-01-02','AUDEL RODRIGUEZ','PAGO POR 10 DIAS DE TRABAJO COMO SERENO EN LA PLANTA, S/R','FUNCIONAMIENTO','800.00','','0','A','2018-01-04 19:31:22','admin');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('4','0','','2018-01-03','YERI GARZON','TRANSPORTE DE MATERIAL A LA CASA R-973','FUNCIONAMIENTO','150.00','','0','A','2018-01-04 20:08:28','admin');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('5','0','','2018-01-03','SAMUEL NINA','ANTICIPO DE SUELDO ENERO-18, R-971','FUNCIONAMIENTO','200.00','','0','A','2018-01-04 20:09:35','admin');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('6','0','','2018-01-03','JOSE LUIS NOGUERA','TRANSPORTE DE PIEDRA A LA CASA (2 VIAJES), R-972','FUNCIONAMIENTO','300.00','','0','A','2018-01-04 20:10:24','admin');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('7','0','','2018-01-04','MANUEL GARZON','COMPRA DE BRONCE PARA PIEZA PALA 950, S/R','FUNCIONAMIENTO','300.00','','0','A','2018-01-06 00:22:18','admin');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('8','0','','2018-01-04','MANUEL GARZON','VENENO PARA LA PODREDUMBRE DEL DURAZNO, S/R','FUNCIONAMIENTO','900.00','','0','A','2018-01-06 00:23:17','admin');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('9','0','','2018-01-04','MANUEL GARZON','PICOS PARA LA MANGUERA DE FUMIGAR, S/R','FUNCIONAMIENTO','100.00','','0','A','2018-01-06 00:24:23','admin');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('10','0','','2018-01-04','YERI GARZON','ANTICIPO DE SUELDO DIC-2017, R-974','FUNCIONAMIENTO','1000.00','','0','A','2018-01-06 00:26:47','admin');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('11','0','','2018-01-04','MARIA RODRIGUEZ','COMPRAS MERCADO P/SAN MATEO','FUNCIONAMIENTO','100.00','','0','A','2018-01-06 00:27:35','admin');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('12','0','','2018-01-05','YERI GARZON','ANTICIPO DE SUELDO MES DIC-17, R-975','FUNCIONAMIENTO','500.00','','0','A','2018-01-06 19:17:07','admin');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('13','0','','2018-01-05','FREDDY BARRIOS','ANTICIPO MANO DE OBRA SEGUN R-777, PROY. CONST. FLIA. GARZON','FUNCIONAMIENTO','2000.00','','0','A','2018-01-06 19:18:37','admin');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('14','0','','2018-01-06','MANUEL GARZON','COMPRA DE VENENO PARA EL GUSANO DE LOS ARBOLES, S/R','FUNCIONAMIENTO','600.00','','0','A','2018-01-08 19:14:14','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('15','0','','2018-01-06','MANUEL GARZON','ABONO ADERENTE Y VENENO, S/R','FUNCIONAMIENTO','750.00','','0','A','2018-01-08 19:15:25','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('16','0','','2018-01-06','SAMUEL NINA','ANTICIPO DE SUELDO, R-976','FUNCIONAMIENTO','500.00','','0','A','2018-01-08 19:16:11','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('17','0','','2018-01-06','MONICA ARMELLA','PAGO A LA COCINERA POR 20 DIAS TRABAJADOS, R-977','FUNCIONAMIENTO','415.00','','0','A','2018-01-08 19:17:38','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('18','0','','2018-01-06','IRENIO BALDIVIEZO','ANTICIPO DE SUELDO MES DICIEMBRE 2017, R-978','FUNCIONAMIENTO','1000.00','','0','A','2018-01-08 19:19:16','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('19','0','','2018-01-06','MARIA RODRIGUEZ','PARA COMPRAR VIVERES, S/R','FUNCIONAMIENTO','200.00','','0','A','2018-01-08 19:24:30','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('20','0','','2018-01-06','MANUEL GARZON','PARA GASTOS VARIOS, S/R','FUNCIONAMIENTO','300.00','','0','A','2018-01-08 19:25:18','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('21','0','','2018-01-08','3H INDUSTRIALES','1 CARGA DE OXIGENO, FACT-1193','FUNCIONAMIENTO','110.00','','0','A','2018-01-09 14:54:38','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('22','0','','2018-01-08','IRENIO BALDIVIEZO','PAGO SALDO SUELDO MES DE DICIEMBRE 2017, R-980','FUNCIONAMIENTO','1000.00','','0','A','2018-01-09 15:29:11','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('23','0','','2018-01-08','VARIOS','COMPRA DE 16 KG DE CARNE, S/R','FUNCIONAMIENTO','400.00','','0','A','2018-01-09 16:32:31','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('24','0','','2018-01-09','FABIAN','ALQUILER DE GRUA PARA COLOCAR EL CONO GRANDE, R-981','FUNCIONAMIENTO','150.00','','0','A','2018-01-10 19:05:44','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('25','0','','2018-01-09','MANUEL GARZON','PARA GASTOS VARIOS, S/R','FUNCIONAMIENTO','400.00','','0','A','2018-01-10 19:06:58','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('26','0','','2018-01-09','SAMUEL NINA','ANTICIPO DE SUELDO MES ENERO-18, R-982','FUNCIONAMIENTO','1000.00','','0','A','2018-01-10 19:07:28','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('27','0','','2018-01-09','LUCAS','POR TRANSPORTE DE MATERIAL A LA CASA, R-983 ( NO SE DETALLA QUE MATERIAL)','FUNCIONAMIENTO','150.00','','0','A','2018-01-10 19:08:32','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('28','0','','2018-01-10','VARIOS','COMPRA 1 GARRAFA DE GAS, S/R','FUNCIONAMIENTO','22.50','','0','A','2018-01-12 21:38:57','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('29','0','','2018-01-10','MANUEL GARZON','P/DIESEL EN BIDONES Y 5 KG DE ELECTRODOS','FUNCIONAMIENTO','400.00','','0','A','2018-01-12 21:39:48','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('30','0','','2018-01-10','VARIOS','MERCADO PARA SAN MATEO','FUNCIONAMIENTO','200.00','','0','A','2018-01-12 21:40:50','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('31','0','','2018-01-10','BERNARDO NIEVES','POR TRABAJOS DE SOLDADURA P/VALDE DE LA PALA 962G Y SOLDAR EL BUZON, R-984.','FUNCIONAMIENTO','800.00','','0','A','2018-01-12 21:41:41','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('32','0','','2018-01-11','MANUEL GARZON','P/ELECTRODO Y DIESEL EN BIDONES','FUNCIONAMIENTO','750.00','','0','A','2018-01-12 22:45:20','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('33','0','','2018-01-11','EST. SERV. EL PORTILLO S.R.L.','470,43 LTS DESEL P/CAMION AZUL, FACT-7691','FUNCIONAMIENTO','1750.00','','0','A','2018-01-12 22:48:44','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('34','0','','2018-01-11','MANUEL GARZON','P/COMPRAR PLANCHA','FUNCIONAMIENTO','100.00','','0','A','2018-01-12 22:49:48','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('35','0','','2018-01-11','MANUEL GARZON','GASOLINA PARA LA CAMIONETA','FUNCIONAMIENTO','100.00','','0','A','2018-01-12 22:50:32','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('36','0','','2018-01-11','WIDMAN INTERNATIONAL SRL','11 LTS ACEITE DE TRANSMISION P/ EL CAMION, FACT-1879','FUNCIONAMIENTO','506.00','','0','A','2018-01-12 22:51:18','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('37','0','','2018-01-11','YERI GARZON','ANTICIPO DE SUELDO AL SR. YERI GARZON, R-812 IMPORTE PAGADO A LA SRA. HAYDEE VELASQUEZ','FUNCIONAMIENTO','2000.00','','0','A','2018-01-12 23:12:32','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('38','0','','2018-01-12','MANUEL GARZON','REMEDIO PARA LA PODREDUMBRE DEL DURAZNO','FUNCIONAMIENTO','400.00','','0','A','2018-01-15 22:13:30','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('39','0','','2018-01-12','MARIA RODRIGUEZ','1 BAIGON Y UN AMBIENTADOR, S/R','FUNCIONAMIENTO','30.00','','0','A','2018-01-15 22:14:17','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('40','0','','2018-01-12','MARIA RODRIGUEZ','CHAMPU CREMA, S/R','FUNCIONAMIENTO','25.00','','0','A','2018-01-15 22:15:00','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('41','0','','2018-01-12','MARIA RODRIGUEZ','PAPEL HIGIENICO Y UNA GALLETA, S/R','FUNCIONAMIENTO','32.00','','0','A','2018-01-15 22:15:30','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('42','0','','2018-01-12','MANUEL GARZON','PARA GASTOS VARIOS','FUNCIONAMIENTO','500.00','','0','A','2018-01-15 22:16:04','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('43','0','','2018-01-13','FREDDY BARRIOS','ANTICIPO MANO DE OBRA, R-778','FUNCIONAMIENTO','2000.00','','0','A','2018-01-15 22:44:50','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('44','0','','2018-01-13','VICTORIA MEJIA SOLIZ','COMPRA DE 12 PERNOS COMPLETOS, FACT/6875','FUNCIONAMIENTO','23.00','','0','A','2018-01-15 22:46:20','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('45','0','','2018-01-13','COMERCIAL ALCRIS','2 GOMAS DE LLANTA P/CARRETILLA, PF/1250','FUNCIONAMIENTO','150.00','','0','A','2018-01-15 22:48:43','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('46','0','','2018-01-13','MANUEL GARZON','TUERCAS PARA EL BUZON, S/R','FUNCIONAMIENTO','22.00','','0','A','2018-01-15 22:49:43','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('47','0','','2018-01-13','MANUEL GARZON','SEGUROS PARA EL TECHO DEL IMAN, S/R','FUNCIONAMIENTO','12.00','','0','A','2018-01-15 22:50:22','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('48','0','','2018-01-13','MARIA RODRIGUEZ','MERCADO P/SAN MATEO','FUNCIONAMIENTO','200.00','','0','A','2018-01-15 22:51:05','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('49','0','','2018-01-13','MANUEL GARZON','PARA GASTOS VARIOS','FUNCIONAMIENTO','200.00','','0','A','2018-01-15 22:51:43','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('50','0','','2018-01-15','IRENIO BALDIVIEZO','ANTICIPO DE SUELDO ENERO-17, R-985','FUNCIONAMIENTO','250.00','','0','A','2018-01-16 14:01:14','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('51','0','','2018-01-15','MANUEL GARZON','3 KG DE ELECTRODO','FUNCIONAMIENTO','60.00','','0','A','2018-01-16 14:02:51','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('52','0','','2018-01-15','BANCO UNION S.A.','PAGO CUOTA CREDITO DE LA CAMIONETA PLOMA, SEGUN R-45740176','FUNCIONAMIENTO','4230.87','','0','A','2018-01-16 22:08:31','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('53','0','','2018-01-16','MARIA RODRIGUEZ','MERCADO PARA SAN MATEO','FUNCIONAMIENTO','100.00','','0','A','2018-01-17 14:39:15','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('54','0','','2018-01-16','SAMUEL NINA','ANTICIPO DE SUELDO MES ENERO-17, R-987','FUNCIONAMIENTO','300.00','','0','A','2018-01-17 14:43:40','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('55','0','','2018-01-16','BERNARDO NIEVES','PAGO POR SOLDAR PROTECTOR DEL MUELLE Y FABRICAR UN COCHE PARA EL OXIGENO, R-988','FUNCIONAMIENTO','800.00','','0','A','2018-01-17 14:45:12','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('56','0','','2018-01-17','YERI GARZON','ANTICIPO DE SUELDO, R-989','FUNCIONAMIENTO','200.00','','0','A','2018-01-18 15:42:17','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('57','0','','2018-01-17','MARIA RODRIGUEZ','MERCADO PARA SAN MATEO','FUNCIONAMIENTO','100.00','','0','A','2018-01-18 15:43:17','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('58','0','','2018-01-18','MANUEL GARZON','PARA GASTOS VARIOS','FUNCIONAMIENTO','400.00','','0','A','2018-01-19 14:28:51','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('59','0','','2018-01-19','MONICA MARTINEZ','ANTICIPO DE SUELDO (COCINERA), R-991','FUNCIONAMIENTO','200.00','','0','A','2018-01-20 17:34:21','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('60','0','','2018-01-19','MARIA RODRIGUEZ','MERCADO CASA','FUNCIONAMIENTO','100.00','','0','A','2018-01-20 17:35:56','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('61','0','','2018-01-19','FREDDY BARRIOS','ANTICIPO MANO DE OBRA CONST. FLIA GARZON, R-814','FUNCIONAMIENTO','2000.00','','0','A','2018-01-20 17:37:51','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('62','0','','2018-01-20','IRENIO BALDIVIEZO','PAGO DE 10 HRS EXTRAS 30/12/17, 13/01/18, 25/01/18, R-992','FUNCIONAMIENTO','200.00','','0','A','2018-01-23 15:51:35','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('63','0','','2018-01-20','SAMUEL NINA','ANTICIPO DE SUELDO ENERO-18, R-815','FUNCIONAMIENTO','600.00','','0','A','2018-01-23 15:53:27','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('64','0','','2018-01-20','MECANICO','PAGO AL MECANICO POR MANTENIMIENTO DEL CAMION 1319 INK, S/R','FUNCIONAMIENTO','1000.00','','0','A','2018-01-23 15:54:26','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('65','0','','2018-01-20','MANUEL GARZON','P/GASTOS VARIOS','FUNCIONAMIENTO','500.00','','0','A','2018-01-23 15:56:52','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('66','0','','2018-01-20','FREDDY BARRIOS','ANTICIPO MANO DE OBRA CONST. FLIA GARZON, S/R','FUNCIONAMIENTO','100.00','','0','A','2018-01-23 16:01:44','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('67','0','','2018-01-20','VARIOS','GASTOS CAMION 1319 INK, S/R','FUNCIONAMIENTO','200.00','','0','A','2018-01-23 16:02:48','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('68','0','','2018-01-20','MARIA RODRIGUEZ','MERCADO','FUNCIONAMIENTO','300.00','','0','A','2018-01-23 16:03:24','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('69','0','','2018-01-22','VARIOS','COMPRA 1/2 CAJA DE PESCADO, S/R','FUNCIONAMIENTO','130.00','','0','A','2018-01-23 19:39:06','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('70','0','','2018-01-22','YERI GARZON','ANTICIPO DE SUELDO, R-993','FUNCIONAMIENTO','100.00','','0','A','2018-01-23 19:39:51','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('71','0','','2018-01-22','MANUEL GARZON','DIESEL PARA LA VAGONETA, F/R','FUNCIONAMIENTO','200.00','','0','A','2018-01-23 19:43:11','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('72','0','','2018-01-22','MANUEL GARZON','PARA GASTOS VARIOS','FUNCIONAMIENTO','150.00','','0','A','2018-01-23 19:44:00','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('73','0','','2018-01-23','MANUEL GARZON','COMPRA DE PERNOS','FUNCIONAMIENTO','61.00','','0','A','2018-01-24 19:26:31','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('74','0','','2018-01-23','HERLAN GARZON','GASTOS VARIOS','FUNCIONAMIENTO','139.00','','0','A','2018-01-24 19:28:08','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('75','0','','2018-01-23','ROMULO ALEMAN','PAGO POR 15 DIAS DE TRBAJO MES DICIEMBRE 2017, R-816','FUNCIONAMIENTO','1155.00','','0','A','2018-01-24 19:28:53','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('76','0','','2018-01-24','MANUEL GARZON','PARA DIESEL','FUNCIONAMIENTO','1800.00','','0','A','2018-01-25 20:18:45','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('77','0','','2018-01-24','MANUEL GARZON','6 CORREAS PARA EL CONO','FUNCIONAMIENTO','1320.00','','0','A','2018-01-25 20:25:43','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('78','0','','2018-01-24','MANUEL GARZON','P/COMPRAR REPUESTOS PARA LA CAMIONETA DE DON AUDEL RODRIGUEZ','FUNCIONAMIENTO','1200.00','','0','A','2018-01-25 20:27:29','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('79','0','','2018-01-25','SAMUEL NINA','ANTICIPO DE SUELDO ENERO, R-994','FUNCIONAMIENTO','900.00','','0','A','2018-01-26 15:19:39','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('80','0','','2018-01-25','MARIA RODRIGUEZ','GASTOS PERSONALES SRA. MARIA','FUNCIONAMIENTO','200.00','','0','A','2018-01-26 15:20:22','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('81','0','','2018-01-25','MANUEL GARZON','COMPRA DE CORREA, FACT-709 (TOMAR EN CUENTA P/LA PLANILLA SOLO BS. 790)','FUNCIONAMIENTO','790.00','','0','A','2018-01-26 15:21:40','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('82','0','','2018-01-26','YERI GARZON','PAGO SALDO AGUINALDO GESTION 2017, R-995','FUNCIONAMIENTO','1020.00','','0','A','2018-01-27 13:46:15','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('83','0','','2018-01-27','YERI GARZON','ANTICIPO SUELDO ENERO, R-996','FUNCIONAMIENTO','500.00','','0','A','2018-01-29 13:21:58','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('84','0','','2018-01-27','IRENIO BALDIVIEZO','ANTICIPO SUELDO ENERO, R-998','FUNCIONAMIENTO','550.00','','0','A','2018-01-29 13:22:51','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('85','0','','2018-01-27','IRENIO BALDIVIEZO','PAGO POR 7 HRS EXTRAS Y 1 FERIADO 21/01/18, R-997','FUNCIONAMIENTO','252.00','','0','A','2018-01-29 13:23:45','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('86','0','','2018-01-27','BERNARDO NIEVES','PAGO POR 6 DIAS DE TRABAJO, R-999','FUNCIONAMIENTO','1200.00','','0','A','2018-01-29 13:25:11','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('87','0','','2018-01-27','FREDDY BARRIOS','ANITICIPO MANO DE OBRA - CONST. CASA FLIA GARZON, R-779','FUNCIONAMIENTO','1500.00','','0','A','2018-01-29 13:26:13','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('88','0','','2018-01-27','VARIOS','PAN PARA DESAYUNO EN SAN MATEO','FUNCIONAMIENTO','10.00','','0','A','2018-01-29 13:27:26','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('89','0','','2018-01-30','EST. DE SERV. MOTO MENDEZ S.R.L.','69.90 LTS DIESEL P/LA VAGONETA, FACT-65286','FUNCIONAMIENTO','260.00','','0','A','2018-01-31 13:23:52','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('90','0','','2018-01-30','VARIOS','PAN P/DESAYUNO EN SAN MATEO','FUNCIONAMIENTO','5.00','','0','A','2018-01-31 13:24:59','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('91','0','','2018-01-30','VARIOS','GASTOS PLANTA (AUTORIZADO ING. HERLAN G.)','FUNCIONAMIENTO','214.00','','0','A','2018-01-31 20:08:47','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('92','0','','2018-01-31','VARIOS','4 LITROS DE ACEITE, F/R','FUNCIONAMIENTO','100.00','','0','A','2018-02-01 13:08:27','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('93','0','','2018-02-01','EST. DE SERVICIO DON DANIEL','P/COMPRA DE 403,23 LTS DE DIESEL C/FACT-179690','FUNCIONAMIENTO','1500.00','','0','A','2018-02-03 16:33:03','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('94','0','','2018-02-02','MANUEL GARZON','PERNO PARA LA PALA 950 G','FUNCIONAMIENTO','20.00','','0','A','2018-02-05 20:59:11','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('95','0','','2018-02-02','VARIOS','CARNE, PAN Y HUEVO PARA SAN MATEO','FUNCIONAMIENTO','80.00','','0','A','2018-02-05 21:07:34','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('96','0','','2018-02-02','VARIOS','CARGAR VOLQUETA, F/R','FUNCIONAMIENTO','100.00','','0','A','2018-02-05 21:08:23','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('97','0','','2018-02-02','LUIS FERNANDO HUANCA CHURATA','COMPRA DE 1 MONITOR MARCA SAMSUNG DE 19\", R-825 DE F. 05-02-17 AUTORIZÓ EL ING. HERLAN','FUNCIONAMIENTO','660.00','','0','A','2018-02-05 21:09:29','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('98','0','','2018-02-03','VARIOS','LAVADO DE VAGONETA, F/R','FUNCIONAMIENTO','60.00','','0','A','2018-02-05 22:00:04','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('99','0','','2018-02-03','IRENIO BALDIVIEZO','PAGO POR 4.5 HRS EXTRAS  DEL 29-01-18 AL 03-02-18, R-1101','FUNCIONAMIENTO','90.00','','0','A','2018-02-05 22:05:34','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('100','0','','2018-02-03','BERNARDO NIEVES','PAGO POR 4 DIAS TRABAJADOS, R-1102','FUNCIONAMIENTO','800.00','','0','A','2018-02-05 22:07:00','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('101','0','','2018-02-03','FREDDY BARRIOS','ANTICIPO MANO DE OBRA - CONST. FLIA GARZON, R-780','FUNCIONAMIENTO','1500.00','','0','A','2018-02-05 22:08:36','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('102','0','','2018-02-03','SAMUEL NINA','SUELDO MES DE FEBRERO 2018, R-781','FUNCIONAMIENTO','2500.00','','0','A','2018-02-05 22:09:34','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('103','0','','2018-02-03','IRENIO BALDIVIEZO','ANTICIPO DE SUELDO ENERO-17, R-1000','FUNCIONAMIENTO','500.00','','0','A','2018-02-05 22:10:49','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('104','0','','2018-02-03','VARIOS','GASTOS PLANTA, REGISTRO AUTORIZADO POR EL ING HERLAN G','FUNCIONAMIENTO','500.00','','0','A','2018-02-05 22:12:20','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('105','0','','2018-02-06','AUDEL RODRIGUEZ','PAGO AL SERENO, R-1103','FUNCIONAMIENTO','240.00','','0','A','2018-02-07 19:04:04','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('106','0','','2018-02-06','AUDEL RODRIGUEZ','PRESTAMO, R-1104','FUNCIONAMIENTO','200.00','','0','A','2018-02-07 19:04:54','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('107','0','','2018-02-05','MARIA RODRIGUEZ','P/COMPRAR CARNE ( INFORMÓ VERBALMENTE EL ING HERLAN GARZON)','FUNCIONAMIENTO','200.00','','0','A','2018-02-07 19:12:20','contador');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('108','0','8887777','2018-02-19','VARIOS','REPUESTO RT22','MANTENIMIENTO','1000.00','','7','A','2018-02-19 16:49:46','admin');;;
INSERT INTO `gasto` (`id_gasto`,`numero`,`nro_factura`,`fecha`,`pagado_a`,`concepto`,`tipo`,`monto`,`observacion`,`id_activo`,`_estado`,`_registrado`,`_usuario`) VALUES
('109','0','1111111','2018-02-21','varios','gasolina 20 litros','OTROS','50.00','','0','A','2018-02-21 15:17:38','admin');;;
-- -------------------------------------------
-- TABLE DATA material
-- -------------------------------------------
INSERT INTO `material` (`id_material`,`nombre`,`precio`,`_registrado`,`_usuario`) VALUES
('1','ARENA','100.00','2017-09-06 23:18:42','100');;;
INSERT INTO `material` (`id_material`,`nombre`,`precio`,`_registrado`,`_usuario`) VALUES
('2','GRAVA 1\"','80.00','2017-09-07 23:48:22','100');;;
INSERT INTO `material` (`id_material`,`nombre`,`precio`,`_registrado`,`_usuario`) VALUES
('3','GRAVILLA 3/4\"','80.00','2017-09-07 23:49:25','100');;;
INSERT INTO `material` (`id_material`,`nombre`,`precio`,`_registrado`,`_usuario`) VALUES
('4','PIEDRA','25.00','2017-09-07 23:49:45','100');;;
INSERT INTO `material` (`id_material`,`nombre`,`precio`,`_registrado`,`_usuario`) VALUES
('5','GRAVA 1/4\"','70.00','2017-09-26 19:39:41','100');;;
INSERT INTO `material` (`id_material`,`nombre`,`precio`,`_registrado`,`_usuario`) VALUES
('6','GRAVILLA 3/8\"','110.00','2017-09-27 17:59:44','100');;;
INSERT INTO `material` (`id_material`,`nombre`,`precio`,`_registrado`,`_usuario`) VALUES
('7','LIMO','40.00','2017-09-27 18:00:41','100');;;
INSERT INTO `material` (`id_material`,`nombre`,`precio`,`_registrado`,`_usuario`) VALUES
('8','RIPIO','30.00','2017-09-27 18:04:41','100');;;
INSERT INTO `material` (`id_material`,`nombre`,`precio`,`_registrado`,`_usuario`) VALUES
('9','CAPA BASE','125.00','2017-09-27 18:07:57','100');;;
INSERT INTO `material` (`id_material`,`nombre`,`precio`,`_registrado`,`_usuario`) VALUES
('10','CAPA SUB BASE','100.00','2017-09-27 18:08:17','100');;;
-- -------------------------------------------
-- TABLE DATA pago
-- -------------------------------------------
INSERT INTO `pago` (`id_pago`,`numero`,`pagado_a`,`concepto`,`fecha`,`tipo`,`monto`,`id_venta`,`id_cliente`,`_estado`,`_registrado`,`_usuario`) VALUES
('1','0','FABIAN','ALQUILER GRUA P/PROBAR LOS REVESTIMIENTOS DEL CONO GRANDE, R-970','2018-01-02','1','400.00','0','0','A','2018-01-04 14:55:41','admin');;;
INSERT INTO `pago` (`id_pago`,`numero`,`pagado_a`,`concepto`,`fecha`,`tipo`,`monto`,`id_venta`,`id_cliente`,`_estado`,`_registrado`,`_usuario`) VALUES
('2','0','','VENTA AL CREDITO DE 4M3 DE GRAVA 1/4\" N/V # 2202 DE F. 28/12/17','2018-01-02','0','280.00','0','71','A','2018-01-04 22:37:50','admin');;;
INSERT INTO `pago` (`id_pago`,`numero`,`pagado_a`,`concepto`,`fecha`,`tipo`,`monto`,`id_venta`,`id_cliente`,`_estado`,`_registrado`,`_usuario`) VALUES
('3','0','VARIOS','VENENO PARA LOS POSTES, S/R','2018-01-02','1','150.00','0','0','A','2018-01-04 15:29:53','admin');;;
INSERT INTO `pago` (`id_pago`,`numero`,`pagado_a`,`concepto`,`fecha`,`tipo`,`monto`,`id_venta`,`id_cliente`,`_estado`,`_registrado`,`_usuario`) VALUES
('4','0','AUDEL RODRIGUEZ','PAGO POR 10 DIAS DE TRABAJO COMO SERENO EN LA PLANTA, S/R','2018-01-02','1','800.00','0','0','A','2018-01-04 15:31:22','admin');;;
INSERT INTO `pago` (`id_pago`,`numero`,`pagado_a`,`concepto`,`fecha`,`tipo`,`monto`,`id_venta`,`id_cliente`,`_estado`,`_registrado`,`_usuario`) VALUES
('5','0','','VENTA AL CREDITO DE 4M3 GRAVILLA 3/4 N/V # 1944 DE F. 02/12/17.','2018-01-03','0','280.00','0','62','A','2018-01-04 16:06:27','admin');;;
INSERT INTO `pago` (`id_pago`,`numero`,`pagado_a`,`concepto`,`fecha`,`tipo`,`monto`,`id_venta`,`id_cliente`,`_estado`,`_registrado`,`_usuario`) VALUES
('6','0','YERI GARZON','TRANSPORTE DE MATERIAL A LA CASA R-973','2018-01-03','1','150.00','0','0','A','2018-01-04 16:08:28','admin');;;
INSERT INTO `pago` (`id_pago`,`numero`,`pagado_a`,`concepto`,`fecha`,`tipo`,`monto`,`id_venta`,`id_cliente`,`_estado`,`_registrado`,`_usuario`) VALUES
('7','0','SAMUEL NINA','ANTICIPO DE SUELDO ENERO-18, R-971','2018-01-03','1','200.00','0','0','A','2018-01-04 16:09:35','admin');;;
INSERT INTO `pago` (`id_pago`,`numero`,`pagado_a`,`concepto`,`fecha`,`tipo`,`monto`,`id_venta`,`id_cliente`,`_estado`,`_registrado`,`_usuario`) VALUES
('8','0','JOSE LUIS NOGUERA','TRANSPORTE DE PIEDRA A LA CASA (2 VIAJES), R-972','2018-01-03','1','300.00','0','0','A','2018-01-04 16:10:24','admin');;;
INSERT INTO `pago` (`id_pago`,`numero`,`pagado_a`,`concepto`,`fecha`,`tipo`,`monto`,`id_venta`,`id_cliente`,`_estado`,`_registrado`,`_usuario`) VALUES
('9','0','','Por cobro de deuda de la Nota de venta Nro. 35','2018-01-04','0','200.00','35','14','A','2018-01-05 20:03:22','admin');;;
INSERT INTO `pago` (`id_pago`,`numero`,`pagado_a`,`concepto`,`fecha`,`tipo`,`monto`,`id_venta`,`id_cliente`,`_estado`,`_registrado`,`_usuario`) VALUES
('10','0','MANUEL GARZON','COMPRA DE BRONCE PARA PIEZA PALA 950, S/R','2018-01-04','1','300.00','0','0','A','2018-01-05 20:22:18','admin');;;
INSERT INTO `pago` (`id_pago`,`numero`,`pagado_a`,`concepto`,`fecha`,`tipo`,`monto`,`id_venta`,`id_cliente`,`_estado`,`_registrado`,`_usuario`) VALUES
('11','0','MANUEL GARZON','VENENO PARA LA PODREDUMBRE DEL DURAZNO, S/R','2018-01-04','1','900.00','0','0','A','2018-01-05 20:23:17','admin');;;
INSERT INTO `pago` (`id_pago`,`numero`,`pagado_a`,`concepto`,`fecha`,`tipo`,`monto`,`id_venta`,`id_cliente`,`_estado`,`_registrado`,`_usuario`) VALUES
('12','0','MANUEL GARZON','PICOS PARA LA MANGUERA DE FUMIGAR, S/R','2018-01-04','1','100.00','0','0','A','2018-01-05 20:24:23','admin');;;
INSERT INTO `pago` (`id_pago`,`numero`,`pagado_a`,`concepto`,`fecha`,`tipo`,`monto`,`id_venta`,`id_cliente`,`_estado`,`_registrado`,`_usuario`) VALUES
('13','0','YERI GARZON','ANTICIPO DE SUELDO DIC-2017, R-974','2018-01-04','1','1000.00','0','0','A','2018-01-05 20:26:47','admin');;;
INSERT INTO `pago` (`id_pago`,`numero`,`pagado_a`,`concepto`,`fecha`,`tipo`,`monto`,`id_venta`,`id_cliente`,`_estado`,`_registrado`,`_usuario`) VALUES
('14','0','MARIA RODRIGUEZ','COMPRAS MERCADO P/SAN MATEO','2018-01-04','1','100.00','0','0','A','2018-01-05 20:27:35','admin');;;
INSERT INTO `pago` (`id_pago`,`numero`,`pagado_a`,`concepto`,`fecha`,`tipo`,`monto`,`id_venta`,`id_cliente`,`_estado`,`_registrado`,`_usuario`) VALUES
('15','0','','COBRO DEUDA NO REGISTRADA EN PLANILLA DE F. 04/10/17','2018-01-05','0','200.00','0','14','A','2018-01-06 15:05:52','admin');;;
INSERT INTO `pago` (`id_pago`,`numero`,`pagado_a`,`concepto`,`fecha`,`tipo`,`monto`,`id_venta`,`id_cliente`,`_estado`,`_registrado`,`_usuario`) VALUES
('16','0','','COBRO DEUDA NO REGISTRADA EN PLANILLA DE F. 04/10/2017','2018-01-05','0','280.00','0','26','A','2018-01-06 15:07:00','admin');;;
INSERT INTO `pago` (`id_pago`,`numero`,`pagado_a`,`concepto`,`fecha`,`tipo`,`monto`,`id_venta`,`id_cliente`,`_estado`,`_registrado`,`_usuario`) VALUES
('17','0','','COBRO DEUDA DE F. 17/10/17 N-1105 BS. 560; F. 21/10/17 N-1208 BS 400; N-1209 BS 320; N-1210 BS 320.','2018-01-05','0','1600.00','0','92','A','2018-01-06 15:08:51','admin');;;
INSERT INTO `pago` (`id_pago`,`numero`,`pagado_a`,`concepto`,`fecha`,`tipo`,`monto`,`id_venta`,`id_cliente`,`_estado`,`_registrado`,`_usuario`) VALUES
('18','0','YERI GARZON','ANTICIPO DE SUELDO MES DIC-17, FALTA RECIBO','2018-01-05','1','500.00','0','0','A','2018-01-06 15:17:07','admin');;;
INSERT INTO `pago` (`id_pago`,`numero`,`pagado_a`,`concepto`,`fecha`,`tipo`,`monto`,`id_venta`,`id_cliente`,`_estado`,`_registrado`,`_usuario`) VALUES
('19','0','FREDDY BARRIOS','ANTICIPO MANO DE OBRA SEGUN R-777, PROY. CONST. FLIA. GARZON','2018-01-05','1','2000.00','0','0','A','2018-01-06 15:18:37','admin');;;
INSERT INTO `pago` (`id_pago`,`numero`,`pagado_a`,`concepto`,`fecha`,`tipo`,`monto`,`id_venta`,`id_cliente`,`_estado`,`_registrado`,`_usuario`) VALUES
('20','0','','Por cobro de deuda de la Nota de venta Nro. 85','2018-01-09','0','0.00','85','103','A','2018-01-09 22:19:36','admin');;;
INSERT INTO `pago` (`id_pago`,`numero`,`pagado_a`,`concepto`,`fecha`,`tipo`,`monto`,`id_venta`,`id_cliente`,`_estado`,`_registrado`,`_usuario`) VALUES
('21','0','','Por cobro de deuda de la Nota de venta Nro. 88','2018-01-23','0','250.00','88','100','A','2018-01-23 23:12:29','admin');;;
INSERT INTO `pago` (`id_pago`,`numero`,`pagado_a`,`concepto`,`fecha`,`tipo`,`monto`,`id_venta`,`id_cliente`,`_estado`,`_registrado`,`_usuario`) VALUES
('22','0','','Por cobro de deuda de la Nota de venta Nro.90','2018-01-23','0','200.00','90','102','A','2018-01-23 23:23:00','admin');;;
INSERT INTO `pago` (`id_pago`,`numero`,`pagado_a`,`concepto`,`fecha`,`tipo`,`monto`,`id_venta`,`id_cliente`,`_estado`,`_registrado`,`_usuario`) VALUES
('23','0','','Por cobro de deuda de la Nota de venta Nro. 91','2018-01-23','0','300.00','91','90','X','2018-01-23 23:24:07','admin');;;
INSERT INTO `pago` (`id_pago`,`numero`,`pagado_a`,`concepto`,`fecha`,`tipo`,`monto`,`id_venta`,`id_cliente`,`_estado`,`_registrado`,`_usuario`) VALUES
('24','0','','sueldos','2018-01-24','0','200.00','0','100','A','2018-01-24 21:26:19','admin');;;
INSERT INTO `pago` (`id_pago`,`numero`,`pagado_a`,`concepto`,`fecha`,`tipo`,`monto`,`id_venta`,`id_cliente`,`_estado`,`_registrado`,`_usuario`) VALUES
('25','0','','Por cobro de deuda de la Nota de venta Nro.95','2018-02-08','0','200.00','95','68','X','2018-02-08 13:57:04','admin');;;
INSERT INTO `pago` (`id_pago`,`numero`,`pagado_a`,`concepto`,`fecha`,`tipo`,`monto`,`id_venta`,`id_cliente`,`_estado`,`_registrado`,`_usuario`) VALUES
('26','0','','Por cobro de deuda de la venta Nro.100 <strong><u>( N.E.-250 )</u></strong>','2018-02-23','0','150.00','100','100','A','2018-02-23 15:06:52','admin');;;
INSERT INTO `pago` (`id_pago`,`numero`,`pagado_a`,`concepto`,`fecha`,`tipo`,`monto`,`id_venta`,`id_cliente`,`_estado`,`_registrado`,`_usuario`) VALUES
('27','0','','Por cobro de deuda de la venta Nro.94 <strong><u>( N.E.-0 )</u></strong>','2018-02-27','0','100.00','94','100','A','2018-02-27 16:00:21','admin');;;
INSERT INTO `pago` (`id_pago`,`numero`,`pagado_a`,`concepto`,`fecha`,`tipo`,`monto`,`id_venta`,`id_cliente`,`_estado`,`_registrado`,`_usuario`) VALUES
('28','0','','Por cobro de deuda de la venta Nro.100 <strong><u>( N.E.-250 )</u></strong>','2018-02-27','0','100.00','100','100','A','2018-02-27 16:36:34','admin');;;
-- -------------------------------------------
-- TABLE DATA proveedor
-- -------------------------------------------
INSERT INTO `proveedor` (`id_proveedor`,`ci_nit`,`nombre`,`celular`,`direccion`,`_estado`,`_registrado`,`_usuario`) VALUES
('1','159753456','FABOCE','65655985','C/ ESPAÑA','A','2018-02-05 16:25:08','admin');;;
INSERT INTO `proveedor` (`id_proveedor`,`ci_nit`,`nombre`,`celular`,`direccion`,`_estado`,`_registrado`,`_usuario`) VALUES
('2','357951458','EL PUENTE','45454566','','A','2018-02-05 16:26:18','admin');;;
INSERT INTO `proveedor` (`id_proveedor`,`ci_nit`,`nombre`,`celular`,`direccion`,`_estado`,`_registrado`,`_usuario`) VALUES
('3','852456789','PLASTICOS PEDRO','','','A','2018-02-05 16:42:17','admin');;;
INSERT INTO `proveedor` (`id_proveedor`,`ci_nit`,`nombre`,`celular`,`direccion`,`_estado`,`_registrado`,`_usuario`) VALUES
('4','357789951','GOMALON','','','A','2018-02-05 16:47:29','admin');;;
INSERT INTO `proveedor` (`id_proveedor`,`ci_nit`,`nombre`,`celular`,`direccion`,`_estado`,`_registrado`,`_usuario`) VALUES
('5','456963123','DURALEX PLASTICOS','','','A','2018-02-06 16:26:01','admin');;;
-- -------------------------------------------
-- TABLE DATA venta
-- -------------------------------------------
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('1','2018-01-02','0','263.00','0','263.00','0.00','','43','2018-01-04 14:23:18','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('2','2018-01-02','0','300.00','0','300.00','0.00','','41','2018-01-04 14:26:13','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('3','2018-01-02','0','263.00','0','263.00','0.00','','72','2018-01-04 14:28:49','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('4','2018-01-02','0','150.00','0','150.00','0.00','','68','2018-01-04 14:29:54','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('5','2018-01-02','0','300.00','0','300.00','0.00','','69','2018-01-04 14:31:44','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('6','2018-01-02','0','280.00','0','280.00','0.00','','24','2018-01-04 14:33:52','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('7','2018-01-02','0','225.00','0','225.00','0.00','','70','2018-01-04 14:34:22','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('8','2018-01-02','0','300.00','0','300.00','0.00','','59','2018-01-04 14:35:35','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('9','2018-01-02','0','200.00','0','200.00','0.00','','59','2018-01-04 15:14:14','admin','X');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('10','2018-01-03','0','400.00','0','400.00','0.00','','24','2018-01-04 15:45:35','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('11','2018-01-03','0','400.00','0','400.00','0.00','','73','2018-01-04 15:47:57','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('12','2018-01-03','0','350.00','0','350.00','0.00','','70','2018-01-04 15:48:26','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('13','2018-01-03','0','300.00','0','300.00','0.00','','74','2018-01-04 15:49:25','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('14','2018-01-03','0','380.00','0','380.00','0.00','','52','2018-01-04 15:50:03','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('15','2018-01-03','0','400.00','0','400.00','0.00','','62','2018-01-04 15:51:34','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('16','2018-01-03','0','400.00','0','400.00','0.00','','14','2018-01-04 15:52:11','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('17','2018-01-03','0','360.00','0','360.00','0.00','','75','2018-01-04 15:53:11','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('18','2018-01-03','0','300.00','0','300.00','0.00','','39','2018-01-04 15:54:25','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('19','2018-01-03','0','245.00','0','245.00','0.00','','52','2018-01-04 15:55:03','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('20','2018-01-03','0','400.00','0','400.00','0.00','','8','2018-01-04 15:55:50','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('21','2018-01-03','0','150.00','0','150.00','0.00','','76','2018-01-04 15:56:49','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('22','2018-01-03','0','300.00','0','300.00','0.00','','8','2018-01-04 15:57:37','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('23','2018-01-03','0','263.00','0','263.00','0.00','','48','2018-01-04 15:58:20','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('24','2018-01-03','0','113.00','0','113.00','0.00','','70','2018-01-04 15:59:49','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('25','2018-01-03','0','263.00','0','263.00','0.00','','43','2018-01-04 16:00:57','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('26','2018-01-03','0','75.00','0','75.00','0.00','','77','2018-01-04 16:03:22','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('27','2018-01-04','0','300.00','0','300.00','0.00','','43','2018-01-05 16:12:18','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('28','2018-01-04','0','613.00','0','613.00','0.00','','52','2018-01-05 19:54:22','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('29','2018-01-04','0','613.00','0','613.00','0.00','','52','2018-01-05 19:55:34','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('30','2018-01-04','0','400.00','0','400.00','0.00','','78','2018-01-05 19:57:19','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('31','2018-01-04','0','0.00','2','350.00','0.00','','79','2018-01-05 19:58:45','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('32','2018-01-04','0','200.00','0','200.00','0.00','','80','2018-01-05 20:00:19','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('33','2018-01-04','0','300.00','0','300.00','0.00','','14','2018-01-05 20:01:01','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('34','2018-01-04','0','315.00','0','315.00','0.00','','52','2018-01-05 20:01:49','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('35','2018-01-04','0','200.00','1','400.00','200.00','','14','2018-01-05 20:03:22','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('36','2018-01-04','0','75.00','0','75.00','0.00','','9','2018-01-05 20:04:14','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('37','2018-01-04','0','400.00','0','400.00','0.00','','8','2018-01-05 20:04:44','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('38','2018-01-04','0','300.00','0','300.00','0.00','','28','2018-01-05 20:05:26','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('39','2018-01-04','0','325.00','0','325.00','0.00','','81','2018-01-05 20:06:31','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('40','2018-01-04','0','300.00','0','300.00','0.00','','26','2018-01-05 20:07:20','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('41','2018-01-04','0','225.00','0','225.00','0.00','','82','2018-01-05 20:08:30','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('42','2018-01-04','0','300.00','0','300.00','0.00','','44','2018-01-05 20:08:59','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('43','2018-01-04','0','113.00','0','113.00','0.00','','41','2018-01-05 20:10:17','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('44','2018-01-04','0','350.00','0','350.00','0.00','','83','2018-01-05 20:11:35','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('45','2018-01-04','0','150.00','0','150.00','0.00','','48','2018-01-05 20:12:06','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('46','2018-01-04','0','150.00','0','150.00','0.00','','8','2018-01-05 20:12:38','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('47','2018-01-04','0','280.00','0','280.00','0.00','','84','2018-01-05 20:13:47','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('48','2018-01-04','0','300.00','0','300.00','0.00','','85','2018-01-05 20:14:46','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('49','2018-01-04','0','0.00','2','280.00','0.00','','26','2018-01-05 20:15:16','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('50','2018-01-04','0','300.00','0','300.00','0.00','','19','2018-01-05 20:16:12','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('51','2018-01-04','0','300.00','0','300.00','0.00','','8','2018-01-05 20:16:59','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('52','2018-01-04','0','280.00','0','280.00','0.00','','86','2018-01-05 20:19:49','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('53','2018-01-04','0','270.00','0','270.00','0.00','','87','2018-01-05 20:55:38','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('54','2018-01-05','0','300.00','0','300.00','0.00','','88','2018-01-06 13:07:26','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('55','2018-01-05','0','700.00','0','700.00','0.00','','89','2018-01-06 13:10:21','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('56','2018-01-05','0','350.00','0','350.00','0.00','','90','2018-01-06 13:11:26','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('57','2018-01-05','0','400.00','0','400.00','0.00','','26','2018-01-06 13:43:25','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('58','2018-01-05','0','400.00','0','400.00','0.00','','26','2018-01-06 13:44:17','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('59','2018-01-05','0','400.00','0','400.00','0.00','','44','2018-01-06 13:44:47','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('60','2018-01-05','0','300.00','0','300.00','0.00','','45','2018-01-06 13:45:28','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('61','2018-01-05','0','300.00','0','300.00','0.00','','83','2018-01-06 13:58:03','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('62','2018-01-05','0','315.00','0','315.00','0.00','','91','2018-01-06 14:02:39','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('63','2018-01-05','0','0.00','2','280.00','0.00','','62','2018-01-06 14:07:31','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('64','2018-01-05','0','340.00','0','340.00','0.00','','92','2018-01-06 14:09:45','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('65','2018-01-05','0','263.00','0','263.00','0.00','','90','2018-01-06 14:15:48','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('66','2018-01-05','0','280.00','0','280.00','0.00','','93','2018-01-06 14:17:24','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('67','2018-01-05','0','300.00','0','300.00','0.00','','14','2018-01-06 14:17:59','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('68','2018-01-05','0','150.00','0','150.00','0.00','','94','2018-01-06 14:22:20','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('69','2018-01-05','0','1050.00','0','1050.00','0.00','','95','2018-01-06 14:23:22','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('70','2018-01-05','0','280.00','0','280.00','0.00','','71','2018-01-06 14:23:59','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('71','2018-01-05','0','300.00','0','300.00','0.00','','96','2018-01-06 14:25:26','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('72','2018-01-05','0','300.00','0','300.00','0.00','','97','2018-01-06 14:26:47','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('73','2018-01-05','0','80.00','0','80.00','0.00','','98','2018-01-06 14:28:34','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('74','2018-01-05','0','350.00','0','350.00','0.00','','90','2018-01-06 14:29:15','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('75','2018-01-05','0','400.00','0','400.00','0.00','','92','2018-01-06 14:29:49','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('76','2018-01-05','0','0.00','2','200.00','0.00','','99','2018-01-06 14:31:11','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('77','2018-01-05','0','280.00','0','280.00','0.00','','96','2018-01-06 14:32:22','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('78','2018-01-05','0','280.00','0','280.00','0.00','','100','2018-01-06 14:33:33','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('79','2018-01-05','0','280.00','0','280.00','0.00','','24','2018-01-06 14:33:58','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('80','2018-01-05','0','0.00','2','350.00','0.00','','101','2018-01-06 14:35:14','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('81','2018-01-05','0','300.00','0','300.00','0.00','','90','2018-01-06 14:36:11','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('82','2018-01-05','0','0.00','1','300.00','300.00','','102','2018-01-06 14:39:31','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('83','2018-01-05','0','300.00','0','300.00','0.00','FALTA NOTA DE ENTREGA','103','2018-01-06 14:40:32','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('84','2018-01-05','0','300.00','0','300.00','0.00','','103','2018-01-06 14:45:48','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('85','2018-01-09','0','0.00','1','360.00','360.00','','103','2018-01-09 22:19:36','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('86','2018-01-10','0','0.00','1','300.00','300.00','','102','2018-01-10 21:18:33','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('87','2018-01-10','0','0.00','1','360.00','360.00','','98','2018-01-10 21:19:43','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('88','2018-01-23','0','250.00','1','500.00','250.00','','100','2018-01-23 23:12:29','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('89','2018-01-23','0','320.00','0','320.00','0.00','','101','2018-01-23 23:14:44','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('90','2018-01-23','0','200.00','1','400.00','0.00','','102','2018-01-23 23:22:20','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('91','2018-01-23','0','300.00','1','640.00','640.00','','90','2018-01-23 23:24:07','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('92','2018-01-24','0','560.00','0','560.00','0.00','','87','2018-01-24 21:08:33','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('93','2018-01-24','0','100.00','1','840.00','740.00','','88','2018-01-24 21:08:51','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('94','2018-01-24','0','200.00','1','640.00','340.00','','100','2018-01-24 21:09:21','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('95','2018-01-24','0','0.00','1','450.00','450.00','','68','2018-01-24 21:12:29','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('96','2018-01-24','0','0.00','2','500.00','0.00','','80','2018-01-24 21:14:00','admin','X');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('97','2018-02-08','0','500.00','0','500.00','0.00','','102','2018-02-08 16:03:42','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('98','2018-02-15','0','625.00','0','625.00','0.00','','101','2018-02-15 15:12:54','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('99','2018-02-22','788','500.00','0','500.00','0.00','','102','2018-02-21 15:40:11','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('100','2018-02-21','250','231.00','1','640.00','159.00','','100','2018-02-21 15:46:10','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('101','2018-03-15','0','570.00','0','570.00','0.00','','90','2018-03-15 16:22:44','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('102','2018-03-26','0','540.00','0','540.00','0.00','','102','2018-03-26 15:34:01','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('103','2018-03-26','0','190.00','0','190.00','0.00','','101','2018-03-26 15:34:12','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('104','2018-03-26','0','500.00','0','500.00','0.00','','98','2018-03-26 15:40:52','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('105','2018-03-26','0','300.00','0','300.00','0.00','','87','2018-03-26 15:42:09','admin','X');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('106','2018-04-10','0','1040.00','0','1040.00','0.00','con el nueva interfaz','103','2018-04-10 16:30:30','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('107','2018-04-10','0','900.00','1','1540.00','640.00','','102','2018-04-10 16:36:30','admin','A');;;
INSERT INTO `venta` (`id_venta`,`fecha`,`numero`,`cancelado`,`tipo`,`total`,`saldo`,`observacion`,`id_cliente`,`_registrado`,`_usuario`,`_estado`) VALUES
('108','2018-04-10','0','952.00','0','952.00','0.00','','102','2018-04-10 17:28:16','admin','A');;;
-- -------------------------------------------
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
COMMIT;
-- -------------------------------------------
-- -------------------------------------------
-- END BACKUP
-- -------------------------------------------
