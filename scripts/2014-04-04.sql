
CREATE TABLE IF NOT EXISTS `trn_especialidad` (
  `oid` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`oid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `trn_especialidad`
--

INSERT INTO `trn_especialidad` (`oid`, `nombre`, `descripcion`) VALUES
(1, 'TRAUMATOLOGÍA', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trn_profesional_especialidad`
--

CREATE TABLE IF NOT EXISTS `trn_profesional_especialidad` (
  `profesional_oid` int(11) NOT NULL,
  `especialidad_oid` int(11) NOT NULL,
  PRIMARY KEY (`profesional_oid`,`especialidad_oid`),
  KEY `IDX_2C3C3D7E9B727E64` (`profesional_oid`),
  KEY `IDX_2C3C3D7E805442F0` (`especialidad_oid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `trn_profesional_especialidad`
--

INSERT INTO `trn_profesional_especialidad` (`profesional_oid`, `especialidad_oid`) VALUES
(19, 1),
(20, 1),
(22, 1),
(23, 1),
(24, 1);

