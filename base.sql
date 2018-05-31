-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 31-05-2018 a las 01:51:27
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `participacion`
--

INSERT INTO `participacion` (`idParticipacion`, `idUsuario`, `idViaje`, `fecha_solicitud`, `estado`) VALUES
(1, 1, 1, '2018-05-10', 1),
(3, 1, 3, '2018-05-10', 2),
(4, 1, 4, '2018-05-10', 3),
(5, 1, 5, '2018-05-10', 5),
(6, 1, 4, '2018-05-10', 4),
(7, 2, 1, '2018-05-10', 1);

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
(1, 'koumsky@gmail.com', '12345', 'Juancho', 'Rumero', 1),
(2, '1234@gmail.com', '12345', 'Frederico', 'Garquez', 1),
(3, 'kaksk@gmail.com', 'fdgfdgf', 'dsafds', 'sdfds', 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `vehiculo`
--

INSERT INTO `vehiculo` (`idVehiculo`, `idPropietario`, `cant_asientos`, `modelo`, `marca`, `color`, `patente`, `tipo`, `eliminado`) VALUES
(1, 1, 3, '2018', 'renault 12', 'marron con verde', 'ac 789 op', 1, 0),
(2, 1, 5, 'Ka 2006', 'Ford', 'verde', 'jey001', 2, 0),
(3, 1, 2, '206 2008', 'Peugeot', 'azul', 'hjh212', 1, 0),
(5, 1, 1, 'fz 2018', 'yamaha', 'gris', 'jey002', 3, 0);

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
  `tipo` varchar(30) NOT NULL,
  `origen` varchar(60) NOT NULL,
  `destino` varchar(60) NOT NULL,
  `asientos_disponibles` int(2) NOT NULL,
  `costo` int(7) NOT NULL,
  `estado` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idViaje`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `viaje`
--

INSERT INTO `viaje` (`idViaje`, `idPiloto`, `idVehiculo`, `fecha_publicacion`, `fecha_partida`, `tipo`, `origen`, `destino`, `asientos_disponibles`, `costo`, `estado`) VALUES
(1, 1, 1, '2018-05-01 10:18:12', '2018-06-01 07:09:08', 'unico', 'La Plata', 'Chapadmalal', 2, 4000, 1),
(2, 1, 2, '2018-05-10 04:26:19', '2018-10-13 09:10:17', 'recurrente', 'La Quiaca', 'Buenos Aires', 2, 500, 1),
(3, 1, 1, '2018-05-03 07:10:33', '2018-06-01 10:17:38', 'unico', 'Mendoza', 'La quiaca', 6, 3600, 1),
(4, 1, 5, '2018-05-03 21:19:10', '2018-07-20 10:35:19', 'unico', 'Mendoza', 'Ushuaihia, tierra del fuego', 1, 3600, 1),
(5, 1, 1, '2018-05-03 07:10:33', '2018-06-01 10:17:38', 'unico', 'Mendoza', 'Misiones', 6, 3600, 1),
(6, 2, 2, '2018-05-18 07:10:33', '2018-08-16 10:17:38', 'unico', 'Cordoba Capital', 'San Juan', 3, 1500, 1),
(7, 1, 2, '2018-05-01 04:26:19', '2018-10-26 09:10:17', 'recurrente', 'El Bolson', 'Buenos Aires', 2, 2500, 1),
(8, 1, 1, '2018-05-01 10:18:12', '2019-03-16 16:13:33', 'unico', 'Santa Fe', 'Buenos Aires Capital', 4, 2000, 3),
(9, 1, 1, '2018-05-03 07:10:33', '2018-06-07 10:17:38', 'unico', 'Rosario, Santa Fe', 'Rawson, Chubut', 6, 3600, 1),
(10, 1, 2, '2018-05-10 04:26:19', '2018-06-22 09:10:17', 'recurrente', 'Carlos Paz', 'Buenos Aires', 4, 4900, 1),
(11, 1, 1, '2018-05-01 10:18:12', '2019-03-16 16:13:33', 'unico', 'Santa Fe', 'Buenos Aires Capital', 4, 2000, 3),
(12, 1, 1, '2018-05-01 10:18:12', '2019-03-16 16:13:33', 'unico', 'Santa Fe', 'Buenos Aires Capital', 4, 2000, 3),
(13, 1, 1, '2018-05-01 10:18:12', '2019-03-16 16:13:33', 'unico', 'Santa Fe', 'Buenos Aires Capital', 4, 2000, 3),
(14, 1, 1, '2018-05-01 10:18:12', '2019-03-16 16:13:33', 'unico', 'Santa Fe', 'Buenos Aires Capital', 4, 2000, 3),
(15, 1, 1, '2018-05-01 10:18:12', '2019-03-16 16:13:33', 'unico', 'Santa Fe', 'Buenos Aires Capital', 4, 2000, 3),
(16, 1, 1, '2018-05-01 10:18:12', '2018-10-06 16:13:33', 'unico', 'Santa Fe', 'Buenos Aires Capital', 4, 2000, 3),
(17, 1, 2, '2018-07-13 04:26:19', '2018-10-26 09:10:17', 'recurrente', 'Moron', 'Chivilcoy', 2, 2000, 1),
(18, 1, 1, '2018-05-01 10:18:12', '2019-02-07 16:13:33', 'unico', 'Arenasa', 'Araneda', 10, 500, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
