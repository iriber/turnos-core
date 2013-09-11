-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 27-08-2013 a las 15:09:21
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
-- Estructura de tabla para la tabla `security_groups_permissions`
--

CREATE TABLE IF NOT EXISTS `security_groups_permissions` (
  `usergroup_oid` int(11) NOT NULL,
  `permission_oid` int(11) NOT NULL,
  PRIMARY KEY (`usergroup_oid`,`permission_oid`),
  KEY `IDX_D8DD1EC1FF569B9` (`usergroup_oid`),
  KEY `IDX_D8DD1EC152B1BA91` (`permission_oid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `security_permission`
--

CREATE TABLE IF NOT EXISTS `security_permission` (
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`oid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
(5, 'oscar', '4'),
(6, 'baldini', '4');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `security_usergroup`
--

CREATE TABLE IF NOT EXISTS `security_usergroup` (
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`oid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `security_usergroup`
--

INSERT INTO `security_usergroup` (`oid`, `name`, `level`) VALUES
(1, 'Administrador', 1),
(2, 'Mesa de entrada', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `security_users_groups`
--

CREATE TABLE IF NOT EXISTS `security_users_groups` (
  `user_oid` int(11) NOT NULL,
  `usergroup_oid` int(11) NOT NULL,
  PRIMARY KEY (`user_oid`,`usergroup_oid`),
  KEY `IDX_C51F4979A93C412B` (`user_oid`),
  KEY `IDX_C51F4979FF569B9` (`usergroup_oid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `security_users_groups`
--

INSERT INTO `security_users_groups` (`user_oid`, `usergroup_oid`) VALUES
(5, 1),
(6, 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `security_groups_permissions`
--
ALTER TABLE `security_groups_permissions`
  ADD CONSTRAINT `FK_D8DD1EC152B1BA91` FOREIGN KEY (`permission_oid`) REFERENCES `security_permission` (`oid`),
  ADD CONSTRAINT `FK_D8DD1EC1FF569B9` FOREIGN KEY (`usergroup_oid`) REFERENCES `security_usergroup` (`oid`);

--
-- Filtros para la tabla `security_users_groups`
--
ALTER TABLE `security_users_groups`
  ADD CONSTRAINT `FK_C51F4979FF569B9` FOREIGN KEY (`usergroup_oid`) REFERENCES `security_usergroup` (`oid`),
  ADD CONSTRAINT `FK_C51F4979A93C412B` FOREIGN KEY (`user_oid`) REFERENCES `security_user` (`oid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
