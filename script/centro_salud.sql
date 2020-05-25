-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-05-2020 a las 21:33:09
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `centro_salud`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctor`
--

CREATE TABLE `doctor` (
  `id` int(11) NOT NULL,
  `hospital_ID` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `direccion` varchar(25) NOT NULL,
  `telefono` int(10) NOT NULL,
  `tipo_sangre` varchar(3) NOT NULL,
  `experiencia` int(11) NOT NULL,
  `nacimiento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `doctor`
--

INSERT INTO `doctor` (`id`, `hospital_ID`, `nombre`, `direccion`, `telefono`, `tipo_sangre`, `experiencia`, `nacimiento`) VALUES
(7, 1, 'Jaime Charris', 'Cra 54 #56-33', 3057993, 'A+', 5, '1991-03-31'),
(8, 1, 'Marina Zuleta', 'Cra 44 #72-29', 4321873, 'O-', 6, '1992-06-13'),
(9, 7, 'Gustavo Perez', 'cra 29 99 24', 214748364, 'A+', 10, '1992-07-22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hospital`
--

CREATE TABLE `hospital` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `telefono` int(10) NOT NULL,
  `direccion` varchar(25) NOT NULL,
  `nit` int(10) NOT NULL,
  `representante` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `hospital`
--

INSERT INTO `hospital` (`id`, `nombre`, `telefono`, `direccion`, `nit`, `representante`) VALUES
(1, 'Hospital CAP', 3069811, 'cra 29 99 24', 1051418846, 'Carlos Perez'),
(2, 'Perez Hospital', 3000026, 'cra 25 12-43', 802000989, 'Alfredo Cassiani'),
(7, 'Gustavo Perez', 3000256, 'Cra 56 #87-45', 4886524, 'Gustavo Perez');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mascotas`
--

CREATE TABLE `mascotas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `raza` varchar(50) NOT NULL,
  `edad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE `paciente` (
  `identificacion` varchar(10) NOT NULL,
  `hospital_ID` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `eps` varchar(25) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `nombre_a` varchar(50) NOT NULL,
  `telefono_a` varchar(10) NOT NULL,
  `antecedentes` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`identificacion`, `hospital_ID`, `nombre`, `eps`, `direccion`, `nombre_a`, `telefono_a`, `antecedentes`) VALUES
('1051418846', 7, 'Carlos Perez', 'sura', 'Cra45-8739av2', 'Andrea Jimenez', '3002193470', 'N');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `triage`
--

CREATE TABLE `triage` (
  `id` int(11) NOT NULL,
  `hospital_ID` int(11) NOT NULL,
  `doctorID` int(10) NOT NULL,
  `pacienteID` int(10) NOT NULL,
  `motivos_consulta` varchar(250) NOT NULL,
  `diagnostico` varchar(250) NOT NULL,
  `req_medicamento` varchar(1) NOT NULL,
  `medicamento` varchar(250) NOT NULL,
  `sintomas` varchar(100) NOT NULL,
  `pos_COVID19` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `triage`
--

INSERT INTO `triage` (`id`, `hospital_ID`, `doctorID`, `pacienteID`, `motivos_consulta`, `diagnostico`, `req_medicamento`, `medicamento`, `sintomas`, `pos_COVID19`) VALUES
(10, 1, 7, 105427837, 'Dolor de muela', 'Inflamacion en las muelas cordales', 'Y', 'DIclofenaco, Acetaminofen', 'Fiebre,', 'N'),
(11, 7, 9, 1051418846, 'Dolor en la muel', 'Inflamacion severa', 'Y', 'Diclofenaco, Acetaminofen', 'Dolor de Garganta,Fiebre,Tos,', 'Y');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `hospital`
--
ALTER TABLE `hospital`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mascotas`
--
ALTER TABLE `mascotas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`identificacion`);

--
-- Indices de la tabla `triage`
--
ALTER TABLE `triage`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `hospital`
--
ALTER TABLE `hospital`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `mascotas`
--
ALTER TABLE `mascotas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `triage`
--
ALTER TABLE `triage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
