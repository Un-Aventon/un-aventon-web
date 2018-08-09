-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-08-2018 a las 18:17:37
-- Versión del servidor: 10.1.31-MariaDB
-- Versión de PHP: 7.2.3

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

CREATE TABLE `calificacion` (
  `idCalificacion` int(6) NOT NULL,
  `idCalificador` int(6) NOT NULL,
  `idCalificado` int(6) NOT NULL,
  `tipo` varchar(10) NOT NULL,
  `idViaje` int(6) NOT NULL,
  `fecha` datetime NOT NULL,
  `calificacion` varchar(6) DEFAULT NULL,
  `comentario` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `calificacion`
--

INSERT INTO `calificacion` (`idCalificacion`, `idCalificador`, `idCalificado`, `tipo`, `idViaje`, `fecha`, `calificacion`, `comentario`) VALUES
(1, 7, 6, '1', 1, '2018-08-03 00:00:00', NULL, '1'),
(2, 7, 4, '1', 1, '2018-08-03 00:00:00', NULL, '1'),
(3, 7, 5, '1', 7, '2018-08-02 00:00:00', NULL, '1'),
(4, 5, 7, '1', 7, '2018-08-02 00:00:00', NULL, '1'),
(5, 7, 4, '1', 6, '2018-07-01 10:10:00', NULL, ''),
(6, 7, 6, '1', 6, '2018-07-01 10:10:00', NULL, ''),
(7, 6, 7, '1', 1, '2018-08-02 00:00:00', NULL, '1'),
(8, 6, 7, '1', 6, '2018-07-01 10:10:00', NULL, ''),
(9, 4, 7, '1', 1, '2018-08-03 00:00:00', NULL, '1'),
(10, 4, 7, '1', 6, '2018-08-03 00:00:00', NULL, '1'),
(11, 0, 7, '3', 0, '2018-08-03 13:11:52', '-1', 'penalizacion por rechazo de postulacion');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_participacion`
--

CREATE TABLE `estado_participacion` (
  `idEstado` int(1) NOT NULL,
  `color` varchar(14) NOT NULL,
  `estado` varchar(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

CREATE TABLE `estado_viaje` (
  `idEstado` int(1) NOT NULL,
  `color` varchar(14) NOT NULL,
  `estado` varchar(14) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

CREATE TABLE `pago` (
  `idPago` int(6) NOT NULL,
  `idViaje` int(6) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estado` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pago`
--

INSERT INTO `pago` (`idPago`, `idViaje`, `fecha`, `hora`, `estado`) VALUES
(1, 1, '2018-01-01', '14:00:00', NULL),
(2, 6, '2018-01-03', '14:00:00', NULL),
(3, 7, '2018-02-16', '17:00:00', NULL),
(5, 8, '2018-03-02', '09:00:00', 1),
(6, 9, '2018-03-20', '09:00:00', 1),
(7, 10, '2018-04-09', '09:00:00', 1),
(8, 11, '2018-04-15', '09:00:00', 1),
(9, 12, '2018-05-04', '09:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participacion`
--

CREATE TABLE `participacion` (
  `idParticipacion` int(6) NOT NULL,
  `idUsuario` int(6) NOT NULL,
  `idViaje` int(6) NOT NULL,
  `fecha_solicitud` datetime NOT NULL,
  `estado` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `participacion`
--

INSERT INTO `participacion` (`idParticipacion`, `idUsuario`, `idViaje`, `fecha_solicitud`, `estado`) VALUES
(1, 4, 1, '2018-08-02 16:36:37', 5),
(2, 6, 1, '2018-08-02 16:38:33', 5),
(3, 7, 7, '2018-08-02 20:15:14', 5),
(4, 4, 6, '2018-08-02 20:32:00', 5),
(5, 6, 6, '2018-08-02 20:32:11', 5),
(6, 4, 5, '2018-08-03 13:11:11', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE `pregunta` (
  `idPregunta` int(6) NOT NULL,
  `idPreguntante` int(6) NOT NULL,
  `idViaje` int(6) NOT NULL,
  `pregunta` varchar(255) NOT NULL,
  `respuesta` varchar(255) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pregunta`
--

INSERT INTO `pregunta` (`idPregunta`, `idPreguntante`, `idViaje`, `pregunta`, `respuesta`, `fecha`) VALUES
(1, 4, 3, ' Alguno lleva mate?', 'nop', '2018-08-02 20:56:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_vehiculo`
--

CREATE TABLE `tipo_vehiculo` (
  `idTipo` int(1) NOT NULL,
  `icono` varchar(140) DEFAULT NULL,
  `tipo` varchar(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

CREATE TABLE `usuario` (
  `idUser` int(6) NOT NULL,
  `email` varchar(50) NOT NULL,
  `clave` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `admin` int(1) NOT NULL DEFAULT '0',
  `estadoUsuario` int(11) NOT NULL DEFAULT '1',
  `recuperarPassword` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUser`, `email`, `clave`, `nombre`, `apellido`, `admin`, `estadoUsuario`, `recuperarPassword`) VALUES
(4, 'valentin@mail.com', '12345', 'Valentin', 'Damia', 0, 1, 0),
(5, 'jose@mail.com', '12345', 'jose', 'perez', 0, 1, 0),
(6, 'juana@mail.com', '12345', 'Juana', 'Valle', 0, 1, 0),
(7, 'martinelli@gmail.com', '12345', 'Mariano', 'Martinelli', 0, 1, 0),
(8, 'root@mail.com', '12345', 'UnAventon', 'SuperAdmin', 1, 1, 0),
(9, 'matias@mail.com', '12345', 'Matias', 'Gonzalez', 0, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo`
--

CREATE TABLE `vehiculo` (
  `idVehiculo` int(6) NOT NULL,
  `idPropietario` int(6) NOT NULL,
  `cant_asientos` int(2) NOT NULL,
  `modelo` varchar(30) NOT NULL,
  `marca` varchar(30) NOT NULL,
  `color` varchar(20) NOT NULL,
  `patente` varchar(10) NOT NULL COMMENT 'puede ser patente extrangera',
  `tipo` int(1) DEFAULT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `vehiculo`
--

INSERT INTO `vehiculo` (`idVehiculo`, `idPropietario`, `cant_asientos`, `modelo`, `marca`, `color`, `patente`, `tipo`, `eliminado`) VALUES
(13, 5, 4, '2010', 'ford', 'azul', 'jey001', 1, 0),
(14, 6, 5, '2008', 'Chevrolet', 'negro', 'jio003', 1, 0),
(15, 7, 4, '2018', 'Peugeot', 'negro', 'hjh212', 1, 0),
(16, 4, 3, 'kangoo', 'renault', 'rojo', 'aaa222', 1, 0),
(17, 9, 4, '2020', 'ford', 'rojo', 'aaa888', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `viaje`
--

CREATE TABLE `viaje` (
  `idViaje` int(6) NOT NULL,
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
  `tipo` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT 'unico'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `viaje`
--

INSERT INTO `viaje` (`idViaje`, `idPiloto`, `idVehiculo`, `fecha_publicacion`, `fecha_partida`, `tiempo_estimado`, `origen`, `destino`, `asientos_disponibles`, `costo`, `estado`, `tipo`) VALUES
(1, 7, 15, '2018-07-02 16:14:04', '2018-07-08 10:00:00', 1, 'rawson,Buenos Aires', 'palermo,Buenos Aires', 2, 1000, 3, 'unico'),
(2, 7, 15, '2018-08-02 16:14:04', '2018-08-15 10:00:00', 1, 'rawson,Buenos Aires', 'lujan,Buenos Aires', 2, 1500, 1, 'unico'),
(3, 7, 15, '2018-08-02 16:14:04', '2018-08-22 10:00:00', 1, 'rawson,Buenos Aires', 'ferre,Buenos Aires', 2, 2000, 1, 'unico'),
(4, 7, 15, '2018-08-02 16:14:04', '2018-08-29 10:00:00', 1, 'rawson,Buenos Aires', 'lujan,Buenos Aires', 2, 3500, 1, 'unico'),
(5, 7, 15, '2018-08-02 16:18:04', '2018-09-05 08:00:00', 1, 'iruya,Salta', 'la plata,Buenos Aires', 2, 1000, 1, 'unico'),
(6, 7, 15, '2018-05-20 16:24:57', '2018-05-30 14:00:00', 6, 'achiras,CÃ³rdoba', 'chilecito,Mendoza', 2, 1000, 3, 'unico'),
(7, 5, 13, '2018-06-19 17:16:26', '2018-06-20 10:10:00', 5, 'la plata,Buenos Aires', 'necochea,Buenos Aires', 2, 1000, 3, 'unico'),
(8, 9, 17, '2017-09-06 10:00:00', '2017-10-10 10:00:00', 23, 'BelÃ©n,Catamarca', 'la plata,Buenos Aires', 3, 1500, 3, 'unico'),
(9, 9, 17, '2017-09-06 10:00:00', '2017-11-11 10:00:00', 24, 'BelÃ©n,Catamarca', 'la plata,Buenos Aires', 3, 4000, 3, 'unico'),
(10, 9, 17, '2017-09-06 10:00:00', '2017-11-25 10:00:00', 24, 'BelÃ©n,Catamarca', 'la plata,Buenos Aires', 3, 3750, 3, 'unico'),
(11, 9, 17, '2017-09-06 10:00:00', '2017-12-09 10:00:00', 24, 'BelÃ©n,Catamarca', 'la plata,Buenos Aires', 3, 500, 3, 'unico'),
(12, 9, 17, '2017-09-06 10:00:00', '2017-12-23 10:00:00', 24, 'BelÃ©n,Catamarca', 'la plata,Buenos Aires', 3, 980, 3, 'unico'),
(13, 9, 17, '2017-09-06 10:00:00', '2019-01-06 10:00:00', 24, 'BelÃ©n,Catamarca', 'la plata,Buenos Aires', 3, 3500, 1, 'unico');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `calificacion`
--
ALTER TABLE `calificacion`
  ADD PRIMARY KEY (`idCalificacion`);

--
-- Indices de la tabla `estado_participacion`
--
ALTER TABLE `estado_participacion`
  ADD PRIMARY KEY (`idEstado`);

--
-- Indices de la tabla `estado_viaje`
--
ALTER TABLE `estado_viaje`
  ADD PRIMARY KEY (`idEstado`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`idPago`);

--
-- Indices de la tabla `participacion`
--
ALTER TABLE `participacion`
  ADD PRIMARY KEY (`idParticipacion`);

--
-- Indices de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD PRIMARY KEY (`idPregunta`);

--
-- Indices de la tabla `tipo_vehiculo`
--
ALTER TABLE `tipo_vehiculo`
  ADD PRIMARY KEY (`idTipo`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUser`);

--
-- Indices de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD PRIMARY KEY (`idVehiculo`);

--
-- Indices de la tabla `viaje`
--
ALTER TABLE `viaje`
  ADD PRIMARY KEY (`idViaje`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `calificacion`
--
ALTER TABLE `calificacion`
  MODIFY `idCalificacion` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `estado_participacion`
--
ALTER TABLE `estado_participacion`
  MODIFY `idEstado` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `estado_viaje`
--
ALTER TABLE `estado_viaje`
  MODIFY `idEstado` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `idPago` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `participacion`
--
ALTER TABLE `participacion`
  MODIFY `idParticipacion` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `idPregunta` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tipo_vehiculo`
--
ALTER TABLE `tipo_vehiculo`
  MODIFY `idTipo` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUser` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  MODIFY `idVehiculo` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `viaje`
--
ALTER TABLE `viaje`
  MODIFY `idViaje` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
