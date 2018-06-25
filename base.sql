-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 25-06-2018 a las 01:30:08
-- Versión del servidor: 5.7.21
-- Versión de PHP: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `base`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificacion`
--

DROP TABLE IF EXISTS `calificacion`;
CREATE TABLE IF NOT EXISTS `calificacion` (
  `idCalificacion` int(6) NOT NULL AUTO_INCREMENT,
  `idCalificador` int(6) NOT NULL,
  `idCalificado` int(6) NOT NULL,
  `tipo` varchar(10) NOT NULL,
  `fecha` datetime NOT NULL,
  `calificacion` varchar(6) DEFAULT NULL,
  `comentario` varchar(255) NOT NULL,
  PRIMARY KEY (`idCalificacion`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `calificacion`
--

INSERT INTO `calificacion` (`idCalificacion`, `idCalificador`, `idCalificado`, `tipo`, `fecha`, `calificacion`, `comentario`) VALUES
(1, 2, 1, '3', '2017-04-05 16:24:06', '0', 'penalizacion por cancelacion de participacion'),
(2, 0, 2, '3', '2018-06-20 16:25:07', '-1', 'penalizacion por rechazo de postulacion'),
(3, 0, 2, '3', '2018-06-24 18:40:11', '-2', 'penalizacion por baja de viaje'),
(4, 0, 2, '3', '2018-06-24 18:40:59', '-2', 'penalizacion por baja de viaje'),
(5, 0, 1, '3', '2018-06-24 18:42:36', '-1', 'penalizacion por cancelacion de participacion'),
(6, 0, 1, '3', '2018-06-24 18:55:40', '-1', 'penalizacion por cancelacion de participacion'),
(7, 0, 2, '3', '2018-06-24 18:56:25', '-2', 'penalizacion por baja de viaje'),
(8, 0, 2, '3', '2018-06-24 18:58:34', '-2', 'penalizacion por baja de viaje'),
(9, 0, 2, '3', '2018-06-24 19:00:54', '-2', 'penalizacion por baja de viaje'),
(10, 0, 2, '3', '2018-06-24 19:03:24', '-2', 'penalizacion por baja de viaje'),
(11, 0, 2, '3', '2018-06-24 19:07:41', '-2', 'penalizacion por baja de viaje'),
(12, 0, 2, '3', '2018-06-24 19:10:31', '-2', 'penalizacion por baja de viaje'),
(13, 0, 1, '3', '2018-06-24 21:05:58', '-1', 'penalizacion por cancelacion de participacion'),
(14, 0, 1, '3', '2018-06-24 21:13:34', '-1', 'penalizacion por cancelacion de participacion'),
(15, 0, 1, '3', '2018-06-24 21:23:45', '-1', 'penalizacion por rechazo de postulacion'),
(16, 0, 1, '3', '2018-06-24 22:24:41', '-2', 'penalizacion por baja de viaje');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_participacion`
--

DROP TABLE IF EXISTS `estado_participacion`;
CREATE TABLE IF NOT EXISTS `estado_participacion` (
  `idEstado` int(1) NOT NULL AUTO_INCREMENT,
  `color` varchar(14) NOT NULL,
  `estado` varchar(40) NOT NULL,
  PRIMARY KEY (`idEstado`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estado_participacion`
--

INSERT INTO `estado_participacion` (`idEstado`, `color`, `estado`) VALUES
(1, 'primary', 'pendiente'),
(2, 'success', 'aprobada'),
(3, 'warning', 'cancelada por mi'),
(4, 'danger', 'cancelada por el piloto'),
(5, 'secondary', 'terminada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_viaje`
--

DROP TABLE IF EXISTS `estado_viaje`;
CREATE TABLE IF NOT EXISTS `estado_viaje` (
  `idEstado` int(1) NOT NULL AUTO_INCREMENT,
  `color` varchar(14) NOT NULL,
  `estado` varchar(14) NOT NULL,
  PRIMARY KEY (`idEstado`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estado_viaje`
--

INSERT INTO `estado_viaje` (`idEstado`, `color`, `estado`) VALUES
(1, 'success', 'activo'),
(2, 'danger', 'cancelado'),
(3, 'primary', 'terminado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

DROP TABLE IF EXISTS `pago`;
CREATE TABLE IF NOT EXISTS `pago` (
  `idPago` int(6) NOT NULL AUTO_INCREMENT,
  `idViaje` int(6) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  PRIMARY KEY (`idPago`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pago`
--

INSERT INTO `pago` (`idPago`, `idViaje`, `fecha`, `hora`) VALUES
(1, 1, '2018-06-20', '00:20:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participacion`
--

DROP TABLE IF EXISTS `participacion`;
CREATE TABLE IF NOT EXISTS `participacion` (
  `idParticipacion` int(6) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(6) NOT NULL,
  `idViaje` int(6) NOT NULL,
  `fecha_solicitud` datetime NOT NULL,
  `estado` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idParticipacion`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `participacion`
--

INSERT INTO `participacion` (`idParticipacion`, `idUsuario`, `idViaje`, `fecha_solicitud`, `estado`) VALUES
(26, 1, 20, '2018-06-24 19:09:59', 4),
(31, 1, 21, '2018-06-24 21:13:41', 4),
(32, 2, 24, '2018-06-24 21:14:02', 4),
(37, 2, 45, '2018-06-24 22:23:53', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

DROP TABLE IF EXISTS `pregunta`;
CREATE TABLE IF NOT EXISTS `pregunta` (
  `idPregunta` int(6) NOT NULL AUTO_INCREMENT,
  `idPreguntante` int(6) NOT NULL,
  `idViaje` int(6) NOT NULL,
  `pregunta` varchar(255) NOT NULL,
  `respuesta` varchar(255) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  PRIMARY KEY (`idPregunta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_vehiculo`
--

DROP TABLE IF EXISTS `tipo_vehiculo`;
CREATE TABLE IF NOT EXISTS `tipo_vehiculo` (
  `idTipo` int(1) NOT NULL AUTO_INCREMENT,
  `icono` varchar(140) DEFAULT NULL,
  `tipo` varchar(11) NOT NULL,
  PRIMARY KEY (`idTipo`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_vehiculo`
--

INSERT INTO `tipo_vehiculo` (`idTipo`, `icono`, `tipo`) VALUES
(1, '/img/vehiculos/coche.png', 'auto'),
(2, '/img/vehiculos/camioneta.png', 'camioneta'),
(3, '/img/vehiculos/moto.png', 'moto'),
(4, '/img/vehiculos/camion.png', 'camion');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `idUser` int(6) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `clave` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `admin` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUser`, `email`, `clave`, `nombre`, `apellido`, `admin`) VALUES
(1, 'koumsky@gmail.com', '12345', 'Juan', 'cho', 1),
(2, 'fede@mail.com', '12345', 'Frederico', 'Gasquez', 1),
(3, 'mariano@mail.com', '12345', 'Mariano', 'Martina', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo`
--

DROP TABLE IF EXISTS `vehiculo`;
CREATE TABLE IF NOT EXISTS `vehiculo` (
  `idVehiculo` int(6) NOT NULL AUTO_INCREMENT,
  `idPropietario` int(6) NOT NULL,
  `cant_asientos` int(2) NOT NULL,
  `modelo` varchar(30) NOT NULL,
  `marca` varchar(30) NOT NULL,
  `color` varchar(20) NOT NULL,
  `patente` varchar(10) NOT NULL COMMENT 'puede ser patente extrangera',
  `tipo` int(1) DEFAULT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idVehiculo`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `vehiculo`
--

INSERT INTO `vehiculo` (`idVehiculo`, `idPropietario`, `cant_asientos`, `modelo`, `marca`, `color`, `patente`, `tipo`, `eliminado`) VALUES
(1, 1, 3, '2018', 'renault 12', 'marron con verde', 'ac 789 op', 1, 0),
(2, 1, 5, 'Ka 2006', 'Ford', 'verde', 'jey001', 2, 0),
(3, 1, 4, '206 2008', 'Peugeot', 'azul', 'hjh212', 2, 1),
(12, 2, 4, 'Stylo', 'Fiat', 'Gris', 'ASD321', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `viaje`
--

DROP TABLE IF EXISTS `viaje`;
CREATE TABLE IF NOT EXISTS `viaje` (
  `idViaje` int(6) NOT NULL AUTO_INCREMENT,
  `idPiloto` int(6) NOT NULL,
  `idVehiculo` int(6) NOT NULL,
  `fecha_publicacion` datetime NOT NULL,
  `fecha_partida` datetime NOT NULL,
  `tiempo_estimado` int(11) NOT NULL DEFAULT '30',
  `origen` varchar(60) CHARACTER SET utf8 NOT NULL,
  `destino` varchar(60) CHARACTER SET utf8 NOT NULL,
  `asientos_disponibles` int(2) NOT NULL,
  `costo` int(7) NOT NULL,
  `estado` int(1) NOT NULL DEFAULT '1',
  `tipo` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT 'unico',
  PRIMARY KEY (`idViaje`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `viaje`
--

INSERT INTO `viaje` (`idViaje`, `idPiloto`, `idVehiculo`, `fecha_publicacion`, `fecha_partida`, `tiempo_estimado`, `origen`, `destino`, `asientos_disponibles`, `costo`, `estado`, `tipo`) VALUES
(45, 1, 1, '2018-06-24 22:22:41', '2020-03-01 00:00:00', 6, 'la plata,Buenos Aires', 'necochea,Buenos Aires', 2, 2, 2, 'unico'),
(46, 1, 1, '2018-06-24 22:25:49', '2019-04-02 01:01:00', 7, 'la plata,Buenos Aires', 'buenos aires,Buenos Aires', 3, 4, 2, 'unico');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
