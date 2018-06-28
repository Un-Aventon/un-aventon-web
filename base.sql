-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 28-06-2018 a las 03:19:17
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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `calificacion`
--

INSERT INTO `calificacion` (`idCalificacion`, `idCalificador`, `idCalificado`, `tipo`, `fecha`, `calificacion`, `comentario`) VALUES
(18, 0, 2, '3', '2018-06-27 17:11:45', '-1', 'penalizacion por rechazo de postulacion'),
(19, 0, 2, '3', '2018-06-27 17:16:39', '-1', 'penalizacion por rechazo de postulacion'),
(20, 5, 1, '1', '2018-06-27 00:00:00', NULL, ''),
(21, 0, 7, '3', '2018-06-27 22:34:39', '-1', 'penalizacion por rechazo de postulacion'),
(22, 0, 7, '3', '2018-06-27 22:42:37', '-1', 'penalizacion por rechazo de postulacion');

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
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `participacion`
--

INSERT INTO `participacion` (`idParticipacion`, `idUsuario`, `idViaje`, `fecha_solicitud`, `estado`) VALUES
(43, 1, 46, '2018-06-27 17:11:29', 4),
(44, 1, 45, '2018-06-27 17:15:31', 4),
(45, 6, 50, '2018-06-27 22:24:52', 4),
(46, 4, 50, '2018-06-27 22:25:22', 1);

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
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`idPregunta`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pregunta`
--

INSERT INTO `pregunta` (`idPregunta`, `idPreguntante`, `idViaje`, `pregunta`, `respuesta`, `fecha`) VALUES
(1, 5, 50, 'podremos parar a comprar facturas por el camino?', 'no.', '2018-06-27 10:10:04'),
(2, 6, 50, 'Bart, podemos levantar a ese vago?', 'No veo por que no', '2018-06-27 17:07:00'),
(3, 5, 50, 'Podriamos salir 2 horas antes?, es de urgencia', '', '2018-06-27 07:18:06');

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUser`, `email`, `clave`, `nombre`, `apellido`, `admin`) VALUES
(4, 'user1@mail.com', '12345', 'jose', 'perez', 0),
(5, 'user2@mail.com', '12345', 'jose', 'perez', 0),
(6, 'user3@mail.com', '12345', 'Juana', 'Valle', 0),
(7, 'koumsky@gmail.com', '12345', 'Martin', 'Salem', 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `vehiculo`
--

INSERT INTO `vehiculo` (`idVehiculo`, `idPropietario`, `cant_asientos`, `modelo`, `marca`, `color`, `patente`, `tipo`, `eliminado`) VALUES
(13, 5, 4, '2010', 'ford', 'azul', 'jey001', 1, 0),
(14, 6, 5, '2008', 'Chevrolet', 'negro', 'jio003', 1, 0),
(15, 7, 4, '2018', 'Peugeot', 'negro', 'hjh212', 1, 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `viaje`
--

INSERT INTO `viaje` (`idViaje`, `idPiloto`, `idVehiculo`, `fecha_publicacion`, `fecha_partida`, `tiempo_estimado`, `origen`, `destino`, `asientos_disponibles`, `costo`, `estado`, `tipo`) VALUES
(47, 5, 13, '2018-06-27 17:29:18', '2018-06-27 17:31:00', 1, 'la plata,Buenos Aires', 'buenos aires,Buenos Aires', 3, 100, 3, 'unico'),
(48, 5, 13, '2018-06-27 17:33:49', '2018-12-31 23:59:00', 1, 'la plata,Buenos Aires', 'buenos aires,Buenos Aires', 1, 100, 2, 'unico'),
(49, 7, 15, '2018-06-27 21:27:40', '2018-06-27 23:30:00', 1, 'la plata,Buenos Aires', 'buenos aires,Buenos Aires', 3, 200, 2, 'unico'),
(50, 7, 15, '2018-06-27 22:05:04', '2018-06-30 13:00:00', 2, 'chascomus,Buenos Aires', 'la plata,Buenos Aires', 1, 500, 1, 'unico'),
(51, 7, 15, '2018-06-27 22:05:04', '2018-07-07 13:00:00', 2, 'chascomus,Buenos Aires', 'la plata,Buenos Aires', 3, 500, 1, 'recurrente');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
