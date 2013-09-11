-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 27-08-2013 a las 15:11:44
-- Versión del servidor: 5.5.31
-- Versión de PHP: 5.3.10-1ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `instituto_access`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn_cliente`
--

CREATE TABLE IF NOT EXISTS `trn_cliente` (
  `oid` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefonoFijo` varchar(50) DEFAULT NULL,
  `telefonoMovil` varchar(50) DEFAULT NULL,
  `domicilio` varchar(255) DEFAULT NULL,
  `nroDocumento` varchar(10) DEFAULT NULL,
  `tipoDocumento` int(11) DEFAULT NULL,
  `sexo` int(11) DEFAULT NULL,
  `obraSocial_oid` bigint(20) DEFAULT NULL,
  `fechaNacimiento` date DEFAULT NULL,
  `localidad_oid` bigint(20) DEFAULT NULL,
  `localidad_nombre` varchar(200) DEFAULT NULL,
  `nroObraSocial` varchar(100) DEFAULT NULL,
  `fechaAlta` date DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `nroHistoriaClinica` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`oid`),
  KEY `nombre` (`nombre`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=278112 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn_horario`
--

CREATE TABLE IF NOT EXISTS `trn_horario` (
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  `dia` int(11) NOT NULL,
  `horaDesde` time NOT NULL,
  `horaHasta` time NOT NULL,
  `profesional_oid` int(11) NOT NULL,
  `duracionTurno` int(11) NOT NULL,
  PRIMARY KEY (`oid`),
  KEY `profesional_oid` (`profesional_oid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn_localidad`
--

CREATE TABLE IF NOT EXISTS `trn_localidad` (
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  PRIMARY KEY (`oid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=179 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn_nomenclador`
--

CREATE TABLE IF NOT EXISTS `trn_nomenclador` (
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `cuit` varchar(50) DEFAULT NULL,
  `domicilio` varchar(255) DEFAULT NULL,
  `circulo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`oid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=660611 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn_obra_social`
--

CREATE TABLE IF NOT EXISTS `trn_obra_social` (
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `cuit` varchar(50) DEFAULT NULL,
  `domicilio` varchar(255) DEFAULT NULL,
  `circulo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`oid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=308 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn_practica`
--

CREATE TABLE IF NOT EXISTS `trn_practica` (
  `oid` bigint(20) NOT NULL AUTO_INCREMENT,
  `cliente_oid` bigint(20) NOT NULL,
  `profesional_oid` bigint(20) NOT NULL,
  `nomenclador_oid` bigint(20) NOT NULL,
  `fecha` date NOT NULL,
  `obraSocial_oid` bigint(20) NOT NULL,
  `observaciones` text NOT NULL,
  PRIMARY KEY (`oid`),
  KEY `cliente_oid` (`cliente_oid`),
  KEY `profesional_oid` (`profesional_oid`),
  KEY `nomenclador_oid` (`nomenclador_oid`),
  KEY `obraSocial_oid` (`obraSocial_oid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=66000 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn_profesional`
--

CREATE TABLE IF NOT EXISTS `trn_profesional` (
  `oid` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefonoFijo` varchar(50) DEFAULT NULL,
  `telefonoMovil` varchar(50) DEFAULT NULL,
  `domicilio` varchar(255) DEFAULT NULL,
  `nroDocumento` varchar(10) DEFAULT NULL,
  `tipoDocumento` int(11) DEFAULT NULL,
  `cuit` varchar(30) DEFAULT NULL,
  `condicionIVA` int(11) DEFAULT NULL,
  `categoria` int(11) DEFAULT NULL,
  `matricula` varchar(50) NOT NULL,
  `user_oid` int(11) DEFAULT NULL,
  PRIMARY KEY (`oid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn_resumen_historia_clinica`
--

CREATE TABLE IF NOT EXISTS `trn_resumen_historia_clinica` (
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_oid` int(11) DEFAULT NULL,
  `profesional_oid` int(11) DEFAULT NULL,
  `fecha` varchar(255) NOT NULL,
  `texto` varchar(255) NOT NULL,
  PRIMARY KEY (`oid`),
  KEY `cliente_oid` (`cliente_oid`),
  KEY `profesional_oid` (`profesional_oid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn_turno`
--

CREATE TABLE IF NOT EXISTS `trn_turno` (
  `oid` bigint(20) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `hora` time NOT NULL,
  `cliente_oid` bigint(20) NOT NULL,
  `profesional_oid` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `importe` float NOT NULL,
  `obraSocial_oid` bigint(20) DEFAULT NULL,
  `nroObraSocial` varchar(100) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`oid`),
  KEY `profesional_oid` (`profesional_oid`),
  KEY `fecha` (`fecha`),
  KEY `cliente_oid` (`cliente_oid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=172126 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
