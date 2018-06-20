-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 20-06-2018 a las 18:23:44
-- Versión del servidor: 5.7.19
-- Versión de PHP: 7.1.9

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
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `calificacion` varchar(6) NOT NULL,
  `comentario` varchar(255) NOT NULL,
  PRIMARY KEY (`idCalificacion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participacion`
--

DROP TABLE IF EXISTS `participacion`;
CREATE TABLE IF NOT EXISTS `participacion` (
  `idParticipacion` int(6) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(6) NOT NULL,
  `idViaje` int(6) NOT NULL,
  `fecha_solicitud` date NOT NULL,
  `estado` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idParticipacion`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `participacion`
--

INSERT INTO `participacion` (`idParticipacion`, `idUsuario`, `idViaje`, `fecha_solicitud`, `estado`) VALUES
(1, 2, 1, '2018-06-20', 1),
(2, 1, 3, '2018-06-20', 1),
(3, 1, 4, '2018-06-20', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `viaje`
--

INSERT INTO `viaje` (`idViaje`, `idPiloto`, `idVehiculo`, `fecha_publicacion`, `fecha_partida`, `tiempo_estimado`, `origen`, `destino`, `asientos_disponibles`, `costo`, `estado`, `tipo`) VALUES
(1, 1, 1, '2018-06-20 14:58:40', '2018-07-20 06:00:00', 72, 'usuahia,Tierra del Fuego', 'la quiaca,Jujuy', 3, 10000, 1, 'unico'),
(2, 2, 12, '2018-06-20 15:02:52', '2018-09-22 10:30:00', 24, 'La Plata,Buenos Aires', 'El Bolson,RÃ­o Negro', 4, 5450, 1, 'unico'),
(3, 2, 12, '2018-06-20 15:06:04', '2018-08-08 13:43:00', 16, 'Cordoba,CÃ³rdoba', 'salta,Salta', 3, 12000, 1, 'unico'),
(4, 2, 12, '2018-06-20 15:08:42', '2018-11-05 08:00:00', 1, 'la plata,Buenos Aires', 'buenos aires,Buenos Aires', 4, 500, 1, 'recurrente'),
(5, 2, 12, '2018-06-20 15:08:42', '2018-11-12 08:00:00', 1, 'la plata,Buenos Aires', 'buenos aires,Buenos Aires', 4, 500, 1, 'recurrente'),
(6, 2, 12, '2018-06-20 15:08:42', '2018-11-19 08:00:00', 1, 'la plata,Buenos Aires', 'buenos aires,Buenos Aires', 4, 500, 1, 'recurrente'),
(7, 2, 12, '2018-06-20 15:08:42', '2018-11-26 08:00:00', 1, 'la plata,Buenos Aires', 'buenos aires,Buenos Aires', 4, 500, 1, 'recurrente'),
(8, 1, 2, '2018-06-20 15:12:31', '2018-07-20 12:00:00', 16, 'la plata,Buenos Aires', 'Puerto Iguazu,Misiones', 5, 10000, 1, 'unico'),
(9, 1, 1, '2018-06-20 15:18:36', '2018-08-30 09:33:00', 8, 'rawson,Chubut', 'el bolson,RÃ­o Negro', 3, 9658, 1, 'unico');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
