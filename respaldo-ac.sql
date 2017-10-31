-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 10-10-2017 a las 11:01:24
-- Versión del servidor: 5.7.19-0ubuntu0.16.04.1
-- Versión de PHP: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mydb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `act_complementaria`
--

CREATE TABLE `act_complementaria` (
  `clave_act` int(11) NOT NULL,
  `nombre_act` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `act_complementaria`
--

INSERT INTO `act_complementaria` (`clave_act`, `nombre_act`) VALUES
(1, 'Tutorias'),
(2, 'Ajedrez'),
(3, 'Boleyball');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrera`
--

CREATE TABLE `carrera` (
  `clave_carrera` varchar(45) NOT NULL,
  `nombre_carrera` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `carrera`
--

INSERT INTO `carrera` (`clave_carrera`, `nombre_carrera`) VALUES
('1', 'carrera nueva'),
('COPU-2010-205', 'Contador Publico'),
('IAGR-2010-214', 'Ingeniería en Agronomía'),
('IAMD-2010-213', 'Ingeniería en Administración'),
('IINF-2010-220', 'Ingeniería en Informática'),
('LADM-2010-234', 'Licenciatura en Administración'),
('LBIO-2010-233', 'Licenciatura en Biologia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `ClaveDepa` varchar(45) NOT NULL,
  `nombre_depa` varchar(45) DEFAULT NULL,
  `trabajador_rfc_trabajador` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`ClaveDepa`, `nombre_depa`, `trabajador_rfc_trabajador`) VALUES
('1', 'Sistemas y computación', 'GOVL801204159'),
('2', 'depa', 'GOVL801204159');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `No_control` int(11) NOT NULL,
  `nombre_estudiante` varchar(45) DEFAULT NULL,
  `apellido_paterno_estudiante` varchar(45) DEFAULT NULL,
  `apellido_materno_estudiante` varchar(45) DEFAULT NULL,
  `semestre` varchar(45) DEFAULT NULL,
  `carrera_clave_carrera` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estudiante`
--

INSERT INTO `estudiante` (`No_control`, `nombre_estudiante`, `apellido_paterno_estudiante`, `apellido_materno_estudiante`, `semestre`, `carrera_clave_carrera`) VALUES
(15930159, 'Citlaly', 'Arroyo', 'Romero', 'V', 'IINF-2010-220'),
(15930185, 'Alondra', 'Jaimes', 'Gutierrez', 'V', 'IINF-2010-220'),
(15930208, 'Jorge', 'Roque', 'Pineda', 'V', 'IINF-2010-220');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instituto`
--

CREATE TABLE `instituto` (
  `clave_instituto` varchar(45) NOT NULL,
  `nombre_instituto` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `instituto`
--

INSERT INTO `instituto` (`clave_instituto`, `nombre_instituto`) VALUES
('12IT0005B', 'INSTITUTO TECNOLÓGICO DE CIUDAD ALTAMIRANO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instructor`
--

CREATE TABLE `instructor` (
  `rfc_instructor` varchar(45) NOT NULL,
  `nombre_instructor` varchar(45) DEFAULT NULL,
  `apellido_paterno_instructor` varchar(45) DEFAULT NULL,
  `apellido_materno_instructor` varchar(45) DEFAULT NULL,
  `act_complementaria_clave_act` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `instructor`
--

INSERT INTO `instructor` (`rfc_instructor`, `nombre_instructor`, `apellido_paterno_instructor`, `apellido_materno_instructor`, `act_complementaria_clave_act`) VALUES
('GOVL801204159', 'Leonel', 'González', 'Vidales', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud`
--

CREATE TABLE `solicitud` (
  `folio` int(11) NOT NULL,
  `asunto` varchar(45) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `lugar` varchar(45) DEFAULT NULL,
  `instituto_clave_instituto` varchar(45) NOT NULL,
  `instructor_rfc_instructor` varchar(45) NOT NULL,
  `estudiante_No_control_estudiante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `solicitud`
--

INSERT INTO `solicitud` (`folio`, `asunto`, `fecha`, `lugar`, `instituto_clave_instituto`, `instructor_rfc_instructor`, `estudiante_No_control_estudiante`) VALUES
(1, 'Inscripción', '2017-10-02', 'Ciudad Altamirano', '12IT0005B', 'GOVL801204159', 15930208);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajador`
--

CREATE TABLE `trabajador` (
  `rfc_trabajador` varchar(45) NOT NULL,
  `nombre_trabajador` varchar(45) DEFAULT NULL,
  `apellido_paterno_trabajador` varchar(45) DEFAULT NULL,
  `apellido_materno_trabajador` varchar(45) DEFAULT NULL,
  `clave_presupuestal` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `trabajador`
--

INSERT INTO `trabajador` (`rfc_trabajador`, `nombre_trabajador`, `apellido_paterno_trabajador`, `apellido_materno_trabajador`, `clave_presupuestal`) VALUES
('GOVL801204159', 'Leonel', 'González', 'Vidales', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `act_complementaria`
--
ALTER TABLE `act_complementaria`
  ADD PRIMARY KEY (`clave_act`);

--
-- Indices de la tabla `carrera`
--
ALTER TABLE `carrera`
  ADD PRIMARY KEY (`clave_carrera`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`ClaveDepa`),
  ADD KEY `fk_departamento_trabajador1_idx` (`trabajador_rfc_trabajador`);

--
-- Indices de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`No_control`,`carrera_clave_carrera`),
  ADD KEY `fk_estudiante_carrera1_idx` (`carrera_clave_carrera`);

--
-- Indices de la tabla `instituto`
--
ALTER TABLE `instituto`
  ADD PRIMARY KEY (`clave_instituto`);

--
-- Indices de la tabla `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`rfc_instructor`),
  ADD KEY `fk_instructor_act_complementaria_idx` (`act_complementaria_clave_act`);

--
-- Indices de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD PRIMARY KEY (`folio`),
  ADD KEY `fk_solicitud_instituto1_idx` (`instituto_clave_instituto`),
  ADD KEY `fk_solicitud_instructor1_idx` (`instructor_rfc_instructor`),
  ADD KEY `fk_solicitud_estudiante1_idx` (`estudiante_No_control_estudiante`);

--
-- Indices de la tabla `trabajador`
--
ALTER TABLE `trabajador`
  ADD PRIMARY KEY (`rfc_trabajador`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  MODIFY `folio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD CONSTRAINT `fk_departamento_trabajador1` FOREIGN KEY (`trabajador_rfc_trabajador`) REFERENCES `trabajador` (`rfc_trabajador`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD CONSTRAINT `fk_estudiante_carrera1` FOREIGN KEY (`carrera_clave_carrera`) REFERENCES `carrera` (`clave_carrera`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `instructor`
--
ALTER TABLE `instructor`
  ADD CONSTRAINT `fk_instructor_act_complementaria` FOREIGN KEY (`act_complementaria_clave_act`) REFERENCES `act_complementaria` (`clave_act`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD CONSTRAINT `fk_solicitud_estudiante1` FOREIGN KEY (`estudiante_No_control_estudiante`) REFERENCES `estudiante` (`No_control`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_solicitud_instituto1` FOREIGN KEY (`instituto_clave_instituto`) REFERENCES `instituto` (`clave_instituto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_solicitud_instructor1` FOREIGN KEY (`instructor_rfc_instructor`) REFERENCES `instructor` (`rfc_instructor`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
