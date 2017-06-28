-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-06-2017 a las 13:56:41
-- Versión del servidor: 10.1.9-MariaDB
-- Versión de PHP: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `laligastats`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id_admin`, `email`, `password`) VALUES
(1, 'aritzreyna@gmail.com', 'aritz1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `id_equipo` int(11) NOT NULL,
  `nombre_equipo` varchar(100) NOT NULL,
  `nombre_equipo_largo` varchar(300) NOT NULL,
  `acronimo_equipo` varchar(3) NOT NULL,
  `localidad` varchar(100) NOT NULL,
  `fundacion` int(4) NOT NULL,
  `campo` varchar(100) NOT NULL,
  `instalaciones_entrenamiento` varchar(100) NOT NULL,
  `foto_equipo` varchar(500) NOT NULL,
  `en_forma` varchar(1) NOT NULL DEFAULT 'n'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id_equipo`, `nombre_equipo`, `nombre_equipo_largo`, `acronimo_equipo`, `localidad`, `fundacion`, `campo`, `instalaciones_entrenamiento`, `foto_equipo`, `en_forma`) VALUES
(1, 'Athletic Club', 'Athletic Club', 'ATH', 'Bilbao', 1898, 'San Mames', 'Lezama', 'athletic_logo.svg', 'y'),
(2, 'Real Sociedad', 'Real Sociedad de Futbol, SAD', 'RSO', 'Donostia', 1909, 'Anoeta', 'Zubieta', 'real_sociedad_logo.svg', 'n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jornada_jugador`
--

CREATE TABLE `jornada_jugador` (
  `id_jornada` int(11) NOT NULL,
  `id_jugador` int(11) NOT NULL,
  `id_equipo_casa` int(11) NOT NULL,
  `id_equipo_fuera` int(11) NOT NULL,
  `marcador_casa` int(11) NOT NULL,
  `marcador_fuera` int(11) NOT NULL,
  `tiros` int(11) NOT NULL,
  `tiros_puerta` int(11) NOT NULL,
  `goles` int(11) NOT NULL,
  `asistencias` int(11) NOT NULL,
  `pases` int(11) NOT NULL,
  `faltas_cometidas` int(11) NOT NULL,
  `faltas_recibidas` int(11) NOT NULL,
  `regates_intentados` int(11) NOT NULL,
  `regates_completados` int(11) NOT NULL,
  `centros_completados` int(11) NOT NULL,
  `tarjetas_amarillas` int(11) NOT NULL,
  `tarjetas_rojas` int(11) NOT NULL,
  `entradas_realizadas` int(11) NOT NULL,
  `entradas_exitosas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jornada_jugador`
--

INSERT INTO `jornada_jugador` (`id_jornada`, `id_jugador`, `id_equipo_casa`, `id_equipo_fuera`, `marcador_casa`, `marcador_fuera`, `tiros`, `tiros_puerta`, `goles`, `asistencias`, `pases`, `faltas_cometidas`, `faltas_recibidas`, `regates_intentados`, `regates_completados`, `centros_completados`, `tarjetas_amarillas`, `tarjetas_rojas`, `entradas_realizadas`, `entradas_exitosas`) VALUES
(8, 1, 1, 2, 3, 2, 1, 1, 1, 1, 18, 1, 3, 0, 0, 3, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugadores`
--

CREATE TABLE `jugadores` (
  `id_jugador` int(11) NOT NULL,
  `nombre_jugador` varchar(100) NOT NULL,
  `nombre_completo_jugador` varchar(200) NOT NULL,
  `edad` int(2) NOT NULL,
  `posicion` varchar(50) NOT NULL,
  `id_equipo` int(11) NOT NULL,
  `numero` int(2) NOT NULL,
  `foto_jugador` varchar(200) NOT NULL,
  `en_forma_jugador` varchar(1) NOT NULL DEFAULT 'n'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jugadores`
--

INSERT INTO `jugadores` (`id_jugador`, `nombre_jugador`, `nombre_completo_jugador`, `edad`, `posicion`, `id_equipo`, `numero`, `foto_jugador`, `en_forma_jugador`) VALUES
(1, 'Aduriz', 'Aritz Aduriz', 36, 'Delantero', 1, 20, 'aduriz.jpg', 'y'),
(2, 'Xabi Prieto', 'Xabier Prieto Argarate', 33, 'Centrocampista', 2, 10, 'xabi-prieto-10.jpg', 'n'),
(3, 'Williams', 'IÃ±aki Williams', 22, 'Delantero', 1, 17, 'willy.jpg', 'n');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id_equipo`),
  ADD UNIQUE KEY `nombre-equipo` (`nombre_equipo`),
  ADD UNIQUE KEY `nombre_equipo_largo` (`nombre_equipo_largo`);

--
-- Indices de la tabla `jornada_jugador`
--
ALTER TABLE `jornada_jugador`
  ADD PRIMARY KEY (`id_jornada`),
  ADD UNIQUE KEY `id_equipo_casa` (`id_equipo_casa`),
  ADD UNIQUE KEY `id_equipo_fuera` (`id_equipo_fuera`),
  ADD UNIQUE KEY `id_jugador` (`id_jugador`);

--
-- Indices de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  ADD PRIMARY KEY (`id_jugador`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id_equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `jornada_jugador`
--
ALTER TABLE `jornada_jugador`
  MODIFY `id_jornada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  MODIFY `id_jugador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
