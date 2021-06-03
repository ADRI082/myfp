-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.23 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para mydb
CREATE DATABASE IF NOT EXISTS `mydb` /*!40100 DEFAULT CHARACTER SET utf8 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `mydb`;

-- Volcando estructura para tabla mydb.archivos
CREATE TABLE IF NOT EXISTS `archivos` (
  `idArchivos` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `bloques_idBloques` int NOT NULL,
  `fechaSubida` date NOT NULL,
  `usuario_idUsuario` int NOT NULL,
  `archivo` longblob NOT NULL,
  `idAsignatura` int DEFAULT NULL,
  PRIMARY KEY (`idArchivos`),
  KEY `fk_archivos_bloques1_idx` (`bloques_idBloques`),
  KEY `fk_archivos_usuario1_idx` (`usuario_idUsuario`),
  KEY `idAsignatura` (`idAsignatura`),
  CONSTRAINT `fk_archivos_asignatura1` FOREIGN KEY (`idAsignatura`) REFERENCES `asignatura` (`idAsignatura`),
  CONSTRAINT `fk_archivos_bloques1` FOREIGN KEY (`bloques_idBloques`) REFERENCES `bloques` (`idBloques`),
  CONSTRAINT `fk_archivos_usuario1` FOREIGN KEY (`usuario_idUsuario`) REFERENCES `usuario` (`idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla mydb.archivos: ~9 rows (aproximadamente)
/*!40000 ALTER TABLE `archivos` DISABLE KEYS */;
INSERT INTO `archivos` (`idArchivos`, `nombre`, `bloques_idBloques`, `fechaSubida`, `usuario_idUsuario`, `archivo`, `idAsignatura`) VALUES
	(1, 'MODULO 2curso celadorCampus Virtual.pdf', 1, '2021-05-06', 1, _binary 0x6170706C69636174696F6E2F706466, 1);
INSERT INTO `archivos` (`idArchivos`, `nombre`, `bloques_idBloques`, `fechaSubida`, `usuario_idUsuario`, `archivo`, `idAsignatura`) VALUES
	(2, 'modulo 1 CURSO CELADORCampus Virtual.pdf', 1, '2021-05-06', 1, _binary 0x6170706C69636174696F6E2F706466, 1);
INSERT INTO `archivos` (`idArchivos`, `nombre`, `bloques_idBloques`, `fechaSubida`, `usuario_idUsuario`, `archivo`, `idAsignatura`) VALUES
	(3, 'Currículum.pdf', 1, '2021-05-06', 1, _binary 0x6170706C69636174696F6E2F706466, 1);
INSERT INTO `archivos` (`idArchivos`, `nombre`, `bloques_idBloques`, `fechaSubida`, `usuario_idUsuario`, `archivo`, `idAsignatura`) VALUES
	(4, 'slim.pdf', 2, '2021-05-06', 1, _binary 0x6170706C69636174696F6E2F706466, 1);
INSERT INTO `archivos` (`idArchivos`, `nombre`, `bloques_idBloques`, `fechaSubida`, `usuario_idUsuario`, `archivo`, `idAsignatura`) VALUES
	(5, 'heidiSQLAerodynamics.txt', 3, '2021-05-06', 1, _binary 0x746578742F706C61696E, 1);
INSERT INTO `archivos` (`idArchivos`, `nombre`, `bloques_idBloques`, `fechaSubida`, `usuario_idUsuario`, `archivo`, `idAsignatura`) VALUES
	(6, 'HORARIOS DATA LEAN POR PROYECTO.ods', 1, '2021-05-06', 1, _binary 0x6170706C69636174696F6E2F766E642E6F617369732E6F70656E646F63756D656E742E7370726561647368656574, 1);
INSERT INTO `archivos` (`idArchivos`, `nombre`, `bloques_idBloques`, `fechaSubida`, `usuario_idUsuario`, `archivo`, `idAsignatura`) VALUES
	(7, '1_HORARIOS DATA LEAN POR PROYECTO.ods', 2, '2021-05-13', 1, _binary 0x6170706C69636174696F6E2F766E642E6F617369732E6F70656E646F63756D656E742E7370726561647368656574, 1);
INSERT INTO `archivos` (`idArchivos`, `nombre`, `bloques_idBloques`, `fechaSubida`, `usuario_idUsuario`, `archivo`, `idAsignatura`) VALUES
	(8, 'tabla facturacion consultores.ods', 1, '2021-05-16', 1, _binary 0x6170706C69636174696F6E2F766E642E6F617369732E6F70656E646F63756D656E742E7370726561647368656574, 1);
INSERT INTO `archivos` (`idArchivos`, `nombre`, `bloques_idBloques`, `fechaSubida`, `usuario_idUsuario`, `archivo`, `idAsignatura`) VALUES
	(9, 'Screenshot_1.png', 2, '2021-05-16', 1, _binary 0x696D6167652F706E67, 1);
INSERT INTO `archivos` (`idArchivos`, `nombre`, `bloques_idBloques`, `fechaSubida`, `usuario_idUsuario`, `archivo`, `idAsignatura`) VALUES
	(10, 'Manual Técnico (1).pdf', 1, '2021-05-26', 1, _binary 0x6170706C69636174696F6E2F706466, 1);
INSERT INTO `archivos` (`idArchivos`, `nombre`, `bloques_idBloques`, `fechaSubida`, `usuario_idUsuario`, `archivo`, `idAsignatura`) VALUES
	(11, 'Reportes.xlsx', 1, '2021-06-03', 1, _binary 0x6170706C69636174696F6E2F766E642E6F70656E786D6C666F726D6174732D6F6666696365646F63756D656E742E73707265616473686565746D6C2E7368656574, 1);
/*!40000 ALTER TABLE `archivos` ENABLE KEYS */;

-- Volcando estructura para tabla mydb.asignatura
CREATE TABLE IF NOT EXISTS `asignatura` (
  `idAsignatura` int NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `Grado_idGrado` int NOT NULL,
  `abreviatura` varchar(45) NOT NULL,
  PRIMARY KEY (`idAsignatura`),
  KEY `fk_Asignatura_Grado_idx` (`Grado_idGrado`),
  CONSTRAINT `fk_Asignatura_Grado` FOREIGN KEY (`Grado_idGrado`) REFERENCES `grado` (`idGrado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla mydb.asignatura: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `asignatura` DISABLE KEYS */;
INSERT INTO `asignatura` (`idAsignatura`, `nombre`, `Grado_idGrado`, `abreviatura`) VALUES
	(1, 'Sistemas informáticos', 1, 'SINF');
INSERT INTO `asignatura` (`idAsignatura`, `nombre`, `Grado_idGrado`, `abreviatura`) VALUES
	(2, 'Bases de Datos', 1, 'BBDD');
INSERT INTO `asignatura` (`idAsignatura`, `nombre`, `Grado_idGrado`, `abreviatura`) VALUES
	(3, 'Programación', 1, 'POO');
INSERT INTO `asignatura` (`idAsignatura`, `nombre`, `Grado_idGrado`, `abreviatura`) VALUES
	(4, 'Entornos de desarrollo', 1, 'ENDS');
/*!40000 ALTER TABLE `asignatura` ENABLE KEYS */;

-- Volcando estructura para tabla mydb.bloques
CREATE TABLE IF NOT EXISTS `bloques` (
  `idBloques` int NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `Asignatura_idAsignatura` int NOT NULL,
  PRIMARY KEY (`idBloques`),
  KEY `fk_bloques_Asignatura1_idx` (`Asignatura_idAsignatura`),
  CONSTRAINT `fk_bloques_Asignatura1` FOREIGN KEY (`Asignatura_idAsignatura`) REFERENCES `asignatura` (`idAsignatura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla mydb.bloques: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `bloques` DISABLE KEYS */;
INSERT INTO `bloques` (`idBloques`, `nombre`, `Asignatura_idAsignatura`) VALUES
	(1, 'Explotación de Sistemas microinformáticos', 1);
INSERT INTO `bloques` (`idBloques`, `nombre`, `Asignatura_idAsignatura`) VALUES
	(2, 'Sistemas Operativos', 1);
INSERT INTO `bloques` (`idBloques`, `nombre`, `Asignatura_idAsignatura`) VALUES
	(3, 'Gestión de la información', 1);
/*!40000 ALTER TABLE `bloques` ENABLE KEYS */;

-- Volcando estructura para tabla mydb.descargas
CREATE TABLE IF NOT EXISTS `descargas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idUsuario` int DEFAULT NULL,
  `idArchivo` int DEFAULT NULL,
  `fechaDescarga` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla mydb.descargas: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `descargas` DISABLE KEYS */;
INSERT INTO `descargas` (`id`, `idUsuario`, `idArchivo`, `fechaDescarga`) VALUES
	(1, 1, 10, '2021-05-26');
/*!40000 ALTER TABLE `descargas` ENABLE KEYS */;

-- Volcando estructura para tabla mydb.favoritos
CREATE TABLE IF NOT EXISTS `favoritos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idUsuario` int NOT NULL,
  `idAsignatura` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla mydb.favoritos: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `favoritos` DISABLE KEYS */;
INSERT INTO `favoritos` (`id`, `idUsuario`, `idAsignatura`) VALUES
	(2, 1, 2);
INSERT INTO `favoritos` (`id`, `idUsuario`, `idAsignatura`) VALUES
	(3, 1, 3);
INSERT INTO `favoritos` (`id`, `idUsuario`, `idAsignatura`) VALUES
	(6, 1, 4);
INSERT INTO `favoritos` (`id`, `idUsuario`, `idAsignatura`) VALUES
	(11, 16, 1);
INSERT INTO `favoritos` (`id`, `idUsuario`, `idAsignatura`) VALUES
	(15, 1, 1);
/*!40000 ALTER TABLE `favoritos` ENABLE KEYS */;

-- Volcando estructura para tabla mydb.grado
CREATE TABLE IF NOT EXISTS `grado` (
  `idGrado` int NOT NULL,
  `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `abreviatura` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idGrado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla mydb.grado: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `grado` DISABLE KEYS */;
INSERT INTO `grado` (`idGrado`, `nombre`, `abreviatura`) VALUES
	(1, 'Desarrollo Aplicaciones Multiplataforma', 'DAM');
INSERT INTO `grado` (`idGrado`, `nombre`, `abreviatura`) VALUES
	(2, 'Desarrollo Aplicaciones Web', 'DAW');
/*!40000 ALTER TABLE `grado` ENABLE KEYS */;

-- Volcando estructura para tabla mydb.subidas
CREATE TABLE IF NOT EXISTS `subidas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idUsuario` int DEFAULT NULL,
  `idArchivo` int DEFAULT NULL,
  `fechaSubida` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla mydb.subidas: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `subidas` DISABLE KEYS */;
INSERT INTO `subidas` (`id`, `idUsuario`, `idArchivo`, `fechaSubida`) VALUES
	(1, 1, 10, '2021-05-26');
INSERT INTO `subidas` (`id`, `idUsuario`, `idArchivo`, `fechaSubida`) VALUES
	(2, NULL, 11, '2021-06-03');
/*!40000 ALTER TABLE `subidas` ENABLE KEYS */;

-- Volcando estructura para tabla mydb.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `idUsuario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `nickname` varchar(45) NOT NULL,
  PRIMARY KEY (`idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla mydb.usuario: ~15 rows (aproximadamente)
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` (`idUsuario`, `nombre`, `apellido`, `password`, `email`, `nickname`) VALUES
	(1, 'adrian', 'beigveder', 'd41YuDCSB', 'beigvederjimenezadrian@gmail.com', 'ADRI082');
INSERT INTO `usuario` (`idUsuario`, `nombre`, `apellido`, `password`, `email`, `nickname`) VALUES
	(2, 'Kike', 'Orellana', '1234', 'test2@gmail.com', 'Ryzz');
INSERT INTO `usuario` (`idUsuario`, `nombre`, `apellido`, `password`, `email`, `nickname`) VALUES
	(3, 'Micky', 'human', '1234', 'test3@gmail.com', 'mickyhuman');
INSERT INTO `usuario` (`idUsuario`, `nombre`, `apellido`, `password`, `email`, `nickname`) VALUES
	(4, 'Ying', 'Lin', '1234', 'test4@gmail.com', 'yingcar');
INSERT INTO `usuario` (`idUsuario`, `nombre`, `apellido`, `password`, `email`, `nickname`) VALUES
	(5, 'Sergio', 'Campos', '1234', 'test7@gmail.com', 'Grind');
INSERT INTO `usuario` (`idUsuario`, `nombre`, `apellido`, `password`, `email`, `nickname`) VALUES
	(6, 'Dani', 'Delgado', '1234', 'test8@gmail.com', 'eviruu');
INSERT INTO `usuario` (`idUsuario`, `nombre`, `apellido`, `password`, `email`, `nickname`) VALUES
	(7, 'rqwr', 'qwerqwe', '1234', 'ewrqwerq', 'rqwerqw');
INSERT INTO `usuario` (`idUsuario`, `nombre`, `apellido`, `password`, `email`, `nickname`) VALUES
	(8, 'dfasdf', 'fasdfasd', '1234', 'dfgdfasdf', 'sadfasdgfdsgsd');
INSERT INTO `usuario` (`idUsuario`, `nombre`, `apellido`, `password`, `email`, `nickname`) VALUES
	(9, 'sdafetrretwertgsfd', 'rweqrqwer', '1234', 'asdfadsgfhggjhd', 'trtwert2465');
INSERT INTO `usuario` (`idUsuario`, `nombre`, `apellido`, `password`, `email`, `nickname`) VALUES
	(10, 'twertwert', 'tweryrteyerty', '1234', '4tert456t4', 'fdgsdfgsfdhfgdhdfgh');
INSERT INTO `usuario` (`idUsuario`, `nombre`, `apellido`, `password`, `email`, `nickname`) VALUES
	(11, 'asdfasdgfdgsdf', 'rqwe345435', '1234', 'gfdsgdfsgsdf', 'gfgsyhrtyh65y6y3');
INSERT INTO `usuario` (`idUsuario`, `nombre`, `apellido`, `password`, `email`, `nickname`) VALUES
	(12, 'fasdgregrtwyrtyertrteu', 'ytuyturtyu', '1234', 'tfdgsdfg', 'ttwerterwtwer');
INSERT INTO `usuario` (`idUsuario`, `nombre`, `apellido`, `password`, `email`, `nickname`) VALUES
	(13, 'Ruben', 'Espinosa', '1234', 'berracus@gmail.com', 'berracus');
INSERT INTO `usuario` (`idUsuario`, `nombre`, `apellido`, `password`, `email`, `nickname`) VALUES
	(14, 'Jesus', 'canas', '1234', 'potisto@gmail.com', 'potisto');
INSERT INTO `usuario` (`idUsuario`, `nombre`, `apellido`, `password`, `email`, `nickname`) VALUES
	(15, 'Natalia', 'Barranquero', '1234', 'nat@gmail.com', 'natroo');
INSERT INTO `usuario` (`idUsuario`, `nombre`, `apellido`, `password`, `email`, `nickname`) VALUES
	(16, 'Prueba', 'video', '1234', 'prueba@gmail.es', 'PruebaVideo');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
