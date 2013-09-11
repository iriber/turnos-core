-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 23-08-2013 a las 12:55:40
-- Versión del servidor: 5.5.31
-- Versión de PHP: 5.3.10-1ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de datos: `instituto_access`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `security_user`
--

CREATE TABLE IF NOT EXISTS `security_user` (
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`oid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `security_user`
--

INSERT INTO `security_user` (`oid`, `username`, `password`) VALUES
(5, 'fucci', '4'),
(6, 'baldini', '4');

