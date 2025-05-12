-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-04-2025 a las 23:13:55
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `super_cyt`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbo_alertas`
--

CREATE TABLE `dbo_alertas` (
  `idAlerta` int(10) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `mensaje` text NOT NULL,
  `fechaHoraEnvio` datetime DEFAULT current_timestamp(),
  `idUsuarioEnvio` int(10) NOT NULL,
  `idMesaVotacion` int(10) DEFAULT NULL,
  `idCoordinador` int(10) DEFAULT NULL,
  `idPersona` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tabla para gestionar el envío de alertas a personas (testigos o coordinadores)';

--
-- Volcado de datos para la tabla `dbo_alertas`
--

INSERT INTO `dbo_alertas` (`idAlerta`, `titulo`, `mensaje`, `fechaHoraEnvio`, `idUsuarioEnvio`, `idMesaVotacion`, `idCoordinador`, `idPersona`) VALUES
(1, 'Recordatorio Inicio Jornada', 'No olviden presentarse puntualmente a sus mesas a las 8:00 AM.', '2025-04-16 01:02:48', 1, NULL, NULL, NULL),
(2, 'Urgente: Falta un vocal', 'Se necesita un vocal suplente en la Mesa 1. Coordinador, favor de verificar.', '2025-04-16 01:02:48', 1, 1, 1, NULL),
(3, 'Información importante', 'Reunión informativa al finalizar la jornada en el centro de acopio.', '2025-04-16 01:02:48', 2, NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbo_asistencia_personas`
--

CREATE TABLE `dbo_asistencia_personas` (
  `idAsistencia` int(10) NOT NULL,
  `idPersona` int(10) NOT NULL,
  `idMesaVotacion` int(10) NOT NULL,
  `fechaHoraRegistro` datetime DEFAULT current_timestamp(),
  `estatusAsistencia` enum('Votó','Sin votar') NOT NULL DEFAULT 'Sin votar',
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tabla para registrar la asistencia de personas en las mesas de votación';

--
-- Volcado de datos para la tabla `dbo_asistencia_personas`
--

INSERT INTO `dbo_asistencia_personas` (`idAsistencia`, `idPersona`, `idMesaVotacion`, `fechaHoraRegistro`, `estatusAsistencia`, `observaciones`) VALUES
(1, 2, 1, '2025-04-16 01:02:48', 'Votó', NULL),
(2, 3, 1, '2025-04-16 01:02:48', 'Sin votar', NULL),
(3, 4, 2, '2025-04-16 01:02:48', 'Sin votar', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbo_coordinadores`
--

CREATE TABLE `dbo_coordinadores` (
  `idCoordinador` int(10) NOT NULL,
  `idPersona` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dbo_coordinadores`
--

INSERT INTO `dbo_coordinadores` (`idCoordinador`, `idPersona`) VALUES
(3, 1),
(2, 2),
(1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbo_login_perfiles`
--

CREATE TABLE `dbo_login_perfiles` (
  `idPerfil` int(11) NOT NULL,
  `perfil` varchar(200) NOT NULL,
  `alias` char(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dbo_login_perfiles`
--

INSERT INTO `dbo_login_perfiles` (`idPerfil`, `perfil`, `alias`) VALUES
(1, 'Super administrador', 'SU'),
(2, 'Administrador', 'ADM'),
(3, 'Coordinador', 'COR'),
(4, 'Testigo', 'TES'),
(5, 'Invitado', 'IVT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbo_mesasvotacion`
--

CREATE TABLE `dbo_mesasvotacion` (
  `idMesaVotacion` int(10) NOT NULL,
  `nombreMesa` varchar(80) NOT NULL,
  `idLugarVotacion` int(10) NOT NULL,
  `idCoordinador` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dbo_mesasvotacion`
--

INSERT INTO `dbo_mesasvotacion` (`idMesaVotacion`, `nombreMesa`, `idLugarVotacion`, `idCoordinador`) VALUES
(1, 'Mesa 1 - Sección 001', 1, 1),
(2, 'Mesa 2 - Sección 002', 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbo_personas`
--

CREATE TABLE `dbo_personas` (
  `idPersona` int(10) NOT NULL,
  `nombre` varchar(70) NOT NULL,
  `primApellido` varchar(70) NOT NULL,
  `segApellido` varchar(70) NOT NULL,
  `curp` char(18) NOT NULL,
  `claveElector` char(18) NOT NULL,
  `telefonoCelular` char(10) NOT NULL,
  `telefonoCasa` char(10) DEFAULT NULL,
  `correo` varchar(100) NOT NULL,
  `fecNacimiento` date NOT NULL,
  `calle` varchar(70) NOT NULL,
  `noExterior` varchar(10) DEFAULT NULL,
  `noInterior` varchar(10) DEFAULT NULL,
  `codigoPostal` char(5) NOT NULL,
  `idEstado` int(10) NOT NULL,
  `idMunicipio` int(10) NOT NULL,
  `idColonia` int(10) NOT NULL,
  `idPersonaTipoSangre` int(10) NOT NULL,
  `idPersonaOcupacion` int(10) NOT NULL,
  `idPersonaGradoAcademico` int(10) NOT NULL,
  `idPersonaPoblacion` int(10) NOT NULL,
  `idPersonaEstadoApoyo` int(10) NOT NULL,
  `idLugarVotacion` int(10) NOT NULL,
  `idMesaVotacion` int(10) DEFAULT NULL,
  `disponibilidad` int(10) NOT NULL,
  `observaciones` varchar(150) DEFAULT NULL,
  `id_distrito_federal` int(11) DEFAULT NULL,
  `id_distrito_local` int(11) DEFAULT NULL,
  `idPersonaGenero` int(10) DEFAULT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1 COMMENT '1: ACTIVO | 0: INACTIVO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dbo_personas`
--

INSERT INTO `dbo_personas` (`idPersona`, `nombre`, `primApellido`, `segApellido`, `curp`, `claveElector`, `telefonoCelular`, `telefonoCasa`, `correo`, `fecNacimiento`, `calle`, `noExterior`, `noInterior`, `codigoPostal`, `idEstado`, `idMunicipio`, `idColonia`, `idPersonaTipoSangre`, `idPersonaOcupacion`, `idPersonaGradoAcademico`, `idPersonaPoblacion`, `idPersonaEstadoApoyo`, `idLugarVotacion`, `idMesaVotacion`, `disponibilidad`, `observaciones`, `id_distrito_federal`, `id_distrito_local`, `idPersonaGenero`, `estatus`) VALUES
(1, 'Ana', 'López', 'García', 'LOGA850301HDFL00', 'ASDFGHJKL12345678', '2711234567', '2717654321', 'ana.lopez@email.com', '1985-03-01', 'Calle Principal', '123', 'A', '94500', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 'Ninguna', 1, 1, 1, 1),
(2, 'Carlos', 'Pérez', 'Ruiz', 'PERC901115MSNB01', 'ZXCVBNMAS98765432', '2719876543', NULL, 'carlos.perez@email.com', '1990-11-15', 'Avenida Central', '456', NULL, '94505', 1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 1, 'Conocido', 2, 2, 2, 1),
(3, 'Elena', 'Sánchez', 'Vargas', 'SAVG780520MJCL05', 'QWERTYUIOP98765432', '2713334455', NULL, 'elena.s@email.com', '1978-05-20', 'Callejón del Toro', 'S/N', NULL, '94510', 1, 3, 3, 3, 3, 3, 3, 3, 1, 1, 1, 'Voluntaria', 1, 3, 3, 1),
(4, 'Javier', 'Ríos', 'Mendoza', 'RIMN951201HGNZ02', 'LKJHGFDSA12398745', '2715556677', '2718889900', 'javier.rios@email.com', '1995-12-01', 'Privada Los Pinos', '10', 'B', '94515', 2, 1, 4, 4, 4, 4, 4, 4, 2, 2, 1, 'Observador', 2, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbo_testigos`
--

CREATE TABLE `dbo_testigos` (
  `idTestigo` int(10) NOT NULL,
  `idPersona` int(10) NOT NULL,
  `idMesaVotacion` int(10) NOT NULL,
  `idCoordinador` int(10) NOT NULL COMMENT 'Se colocó el campo de coordinador para casos en donde el testigo requiera un coordinador que no sea el mismo de la casilla electoral'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dbo_testigos`
--

INSERT INTO `dbo_testigos` (`idTestigo`, `idPersona`, `idMesaVotacion`, `idCoordinador`) VALUES
(1, 3, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbo_usuarios`
--

CREATE TABLE `dbo_usuarios` (
  `idUsuario` int(10) NOT NULL,
  `nombre` varchar(70) NOT NULL,
  `primApellido` varchar(70) NOT NULL,
  `segApellido` varchar(70) NOT NULL,
  `usuario` varchar(10) NOT NULL,
  `password` varchar(50) NOT NULL,
  `idPerfil` int(10) NOT NULL,
  `idPartido` int(10) DEFAULT NULL,
  `idPersona` int(10) DEFAULT NULL,
  `idCoordinador` int(11) DEFAULT NULL,
  `idTestigo` int(11) DEFAULT NULL,
  `estatus` int(10) NOT NULL DEFAULT 1 COMMENT '1: Activo | 0: Inactivo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dbo_usuarios`
--

INSERT INTO `dbo_usuarios` (`idUsuario`, `nombre`, `primApellido`, `segApellido`, `usuario`, `password`, `idPerfil`, `idPartido`, `idPersona`, `idCoordinador`, `idTestigo`, `estatus`) VALUES
(1, 'Ana', 'López', 'García', '1', '1', 1, 1, 1, 1, NULL, 1),
(2, 'Carlos', 'Pérez', 'Ruiz', 'carlos.p', '1', 3, 2, 2, 2, 1, 1),
(3, 'Elena', 'Sánchez', 'Vargas', 'elena.s', 'pass789', 4, 1, 3, NULL, NULL, 1),
(4, 'Javier', 'Ríos', 'Mendoza', 'javier.r', 'secure123', 2, 2, 4, NULL, NULL, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `dbo_alertas`
--
ALTER TABLE `dbo_alertas`
  ADD PRIMARY KEY (`idAlerta`),
  ADD KEY `idx_fechaHoraEnvio` (`fechaHoraEnvio`) USING BTREE,
  ADD KEY `idx_idUsuarioEnvio` (`idUsuarioEnvio`) USING BTREE,
  ADD KEY `idx_idMesaVotacionAlerta` (`idMesaVotacion`) USING BTREE,
  ADD KEY `idx_idCoordinadorAlerta` (`idCoordinador`) USING BTREE,
  ADD KEY `idx_idPersonaAlerta` (`idPersona`) USING BTREE;

--
-- Indices de la tabla `dbo_asistencia_personas`
--
ALTER TABLE `dbo_asistencia_personas`
  ADD PRIMARY KEY (`idAsistencia`),
  ADD KEY `idx_idPersonaAsistencia` (`idPersona`) USING BTREE,
  ADD KEY `idx_idMesaVotacionAsistencia` (`idMesaVotacion`) USING BTREE,
  ADD KEY `idx_fechaHoraRegistroAsistencia` (`fechaHoraRegistro`) USING BTREE,
  ADD KEY `idx_estatusAsistenciaPersona` (`estatusAsistencia`) USING BTREE;

--
-- Indices de la tabla `dbo_coordinadores`
--
ALTER TABLE `dbo_coordinadores`
  ADD PRIMARY KEY (`idCoordinador`),
  ADD KEY `idx_idPersona` (`idPersona`) USING BTREE;

--
-- Indices de la tabla `dbo_login_perfiles`
--
ALTER TABLE `dbo_login_perfiles`
  ADD PRIMARY KEY (`idPerfil`);

--
-- Indices de la tabla `dbo_mesasvotacion`
--
ALTER TABLE `dbo_mesasvotacion`
  ADD PRIMARY KEY (`idMesaVotacion`),
  ADD KEY `idx_idCoordinador_mesas` (`idCoordinador`) USING BTREE,
  ADD KEY `idx_idLugarVotacion_mesas` (`idLugarVotacion`) USING BTREE;

--
-- Indices de la tabla `dbo_personas`
--
ALTER TABLE `dbo_personas`
  ADD PRIMARY KEY (`idPersona`),
  ADD KEY `idx_id_distrito_federal` (`id_distrito_federal`) USING BTREE,
  ADD KEY `idx_id_distrito_local` (`id_distrito_local`) USING BTREE,
  ADD KEY `idx_idPersonaGenero` (`idPersonaGenero`) USING BTREE,
  ADD KEY `idx_idColonia` (`idColonia`) USING BTREE,
  ADD KEY `idx_idEstado` (`idEstado`) USING BTREE,
  ADD KEY `idx_idLugarVotacion` (`idLugarVotacion`) USING BTREE,
  ADD KEY `idx_idMesaVotacion` (`idMesaVotacion`) USING BTREE,
  ADD KEY `idx_idMunicipio` (`idMunicipio`) USING BTREE,
  ADD KEY `idx_idPersonaEstadoApoyo` (`idPersonaEstadoApoyo`) USING BTREE,
  ADD KEY `idx_idPersonaGradoAcademico` (`idPersonaGradoAcademico`) USING BTREE,
  ADD KEY `idx_idPersonaOcupacion` (`idPersonaOcupacion`) USING BTREE,
  ADD KEY `idx_idPersonaPoblacion` (`idPersonaPoblacion`) USING BTREE,
  ADD KEY `idx_idPersonaTipoSangre` (`idPersonaTipoSangre`) USING BTREE;

--
-- Indices de la tabla `dbo_testigos`
--
ALTER TABLE `dbo_testigos`
  ADD PRIMARY KEY (`idTestigo`),
  ADD KEY `idx_idCoordinador` (`idCoordinador`) USING BTREE,
  ADD KEY `idx_idMesaVotacion` (`idMesaVotacion`) USING BTREE,
  ADD KEY `idx_idPersona` (`idPersona`) USING BTREE;

--
-- Indices de la tabla `dbo_usuarios`
--
ALTER TABLE `dbo_usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `idx_idCoordinador` (`idCoordinador`) USING BTREE,
  ADD KEY `idx_idPartido` (`idPartido`) USING BTREE,
  ADD KEY `idx_idPerfil` (`idPerfil`) USING BTREE,
  ADD KEY `idx_idPersona` (`idPersona`) USING BTREE,
  ADD KEY `idx_idTestigo` (`idTestigo`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `dbo_alertas`
--
ALTER TABLE `dbo_alertas`
  MODIFY `idAlerta` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `dbo_asistencia_personas`
--
ALTER TABLE `dbo_asistencia_personas`
  MODIFY `idAsistencia` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `dbo_coordinadores`
--
ALTER TABLE `dbo_coordinadores`
  MODIFY `idCoordinador` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `dbo_login_perfiles`
--
ALTER TABLE `dbo_login_perfiles`
  MODIFY `idPerfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `dbo_mesasvotacion`
--
ALTER TABLE `dbo_mesasvotacion`
  MODIFY `idMesaVotacion` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `dbo_personas`
--
ALTER TABLE `dbo_personas`
  MODIFY `idPersona` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `dbo_testigos`
--
ALTER TABLE `dbo_testigos`
  MODIFY `idTestigo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `dbo_usuarios`
--
ALTER TABLE `dbo_usuarios`
  MODIFY `idUsuario` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `dbo_alertas`
--
ALTER TABLE `dbo_alertas`
  ADD CONSTRAINT `dbo_alertas_dbo_mesasvotacion_FK` FOREIGN KEY (`idMesaVotacion`) REFERENCES `dbo_mesasvotacion` (`idMesaVotacion`),
  ADD CONSTRAINT `dbo_alertas_ibfk_1` FOREIGN KEY (`idUsuarioEnvio`) REFERENCES `dbo_usuarios` (`idUsuario`),
  ADD CONSTRAINT `dbo_alertas_ibfk_2` FOREIGN KEY (`idMesaVotacion`) REFERENCES `dbo_mesas_votacion` (`idMesaVotacion`),
  ADD CONSTRAINT `dbo_alertas_ibfk_3` FOREIGN KEY (`idCoordinador`) REFERENCES `dbo_coordinadores` (`idCoordinador`),
  ADD CONSTRAINT `dbo_alertas_ibfk_4` FOREIGN KEY (`idPersona`) REFERENCES `dbo_personas` (`idPersona`);

--
-- Filtros para la tabla `dbo_asistencia_personas`
--
ALTER TABLE `dbo_asistencia_personas`
  ADD CONSTRAINT `dbo_asistencia_personas_dbo_mesasvotacion_FK` FOREIGN KEY (`idMesaVotacion`) REFERENCES `dbo_mesasvotacion` (`idMesaVotacion`),
  ADD CONSTRAINT `dbo_asistencia_personas_ibfk_1` FOREIGN KEY (`idPersona`) REFERENCES `dbo_personas` (`idPersona`),
  ADD CONSTRAINT `dbo_asistencia_personas_ibfk_2` FOREIGN KEY (`idMesaVotacion`) REFERENCES `dbo_mesas_votacion` (`idMesaVotacion`);

--
-- Filtros para la tabla `dbo_coordinadores`
--
ALTER TABLE `dbo_coordinadores`
  ADD CONSTRAINT `dbo_coordinadores_dbo_personas_FK` FOREIGN KEY (`idPersona`) REFERENCES `dbo_personas` (`idPersona`);

--
-- Filtros para la tabla `dbo_mesasvotacion`
--
ALTER TABLE `dbo_mesasvotacion`
  ADD CONSTRAINT `dbo_mesasvotacion_dbo_coordinadores_FK` FOREIGN KEY (`idCoordinador`) REFERENCES `dbo_coordinadores` (`idCoordinador`);

--
-- Filtros para la tabla `dbo_testigos`
--
ALTER TABLE `dbo_testigos`
  ADD CONSTRAINT `dbo_testigos_dbo_coordinadores_FK` FOREIGN KEY (`idCoordinador`) REFERENCES `dbo_coordinadores` (`idCoordinador`),
  ADD CONSTRAINT `dbo_testigos_dbo_mesasvotacion_FK` FOREIGN KEY (`idMesaVotacion`) REFERENCES `dbo_mesasvotacion` (`idMesaVotacion`),
  ADD CONSTRAINT `dbo_testigos_dbo_personas_FK` FOREIGN KEY (`idPersona`) REFERENCES `dbo_personas` (`idPersona`);

--
-- Filtros para la tabla `dbo_usuarios`
--
ALTER TABLE `dbo_usuarios`
  ADD CONSTRAINT `dbo_usuarios_dbo_coordinadores_FK` FOREIGN KEY (`idCoordinador`) REFERENCES `dbo_coordinadores` (`idCoordinador`),
  ADD CONSTRAINT `dbo_usuarios_dbo_login_perfiles_FK` FOREIGN KEY (`idPerfil`) REFERENCES `dbo_login_perfiles` (`idPerfil`),
  ADD CONSTRAINT `dbo_usuarios_dbo_personas_FK` FOREIGN KEY (`idPersona`) REFERENCES `dbo_personas` (`idPersona`),
  ADD CONSTRAINT `dbo_usuarios_dbo_testigos_FK` FOREIGN KEY (`idTestigo`) REFERENCES `dbo_testigos` (`idTestigo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
