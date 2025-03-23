-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-03-2025 a las 06:08:58
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
-- Base de datos: `almacen`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `id` int(11) NOT NULL,
  `id_material` int(11) NOT NULL,
  `nombre_articulo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `costo_compra` decimal(10,2) NOT NULL,
  `fecha_ingreso` datetime DEFAULT current_timestamp(),
  `peso_articulo` decimal(10,2) NOT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `fecha_salida` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`id`, `id_material`, `nombre_articulo`, `descripcion`, `costo_compra`, `fecha_ingreso`, `peso_articulo`, `activo`, `fecha_salida`) VALUES
(1, 1, 'dasd', 'asd', 44.00, '2025-03-22 16:46:55', 41.00, 0, NULL),
(2, 1, 'dasd', 'askklsajd', 44.00, '2025-03-22 16:52:48', 33.00, 1, NULL),
(3, 1, 'anillo', 'anillo de metal,', 500.00, '2025-03-22 18:05:07', 20.00, 1, NULL),
(4, 1, 'Aretes', 'par de arete de acero.', 200.00, '2025-03-22 23:13:14', 20.00, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiales`
--

CREATE TABLE `materiales` (
  `id` int(11) NOT NULL,
  `nombre_material` varchar(255) NOT NULL,
  `peso_total` decimal(10,2) DEFAULT 0.00,
  `minimo_g` decimal(10,2) NOT NULL,
  `maximo_g` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materiales`
--

INSERT INTO `materiales` (`id`, `nombre_material`, `peso_total`, `minimo_g`, `maximo_g`) VALUES
(1, 'Acero inoxidable', 0.00, 400.00, 4000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre_usuario`, `contrasena`, `email`, `fecha_registro`, `activo`) VALUES
(1, 'moises', '$2y$10$p.BYoduAsW4r2QSswFnuaO9eefCyRM8IGzTo5F48hpUi1m0f.QKta', 'moisesdejesusgallegoslopez@gmail.com', '2025-03-22 22:30:16', 1),
(2, 'admin', '$2y$10$Q6Qzcv4pZbRpqLa5R.ClR.JQ1KJvBpF5n/H4uhKWNvDVIk68why56', 'moises@gmail.com', '2025-03-23 00:33:53', 1),
(3, 'Waitita', '$2y$10$RhMsBptiT1IwI3doet4Kre5p5OS1fuQr3QyaTaAKAiikI/lp9YBme', 'blancaiselaandradechacon123@gmail.com', '2025-03-23 04:07:20', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_material` (`id_material`);

--
-- Indices de la tabla `materiales`
--
ALTER TABLE `materiales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_material` (`nombre_material`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_nombre_usuario` (`nombre_usuario`),
  ADD KEY `idx_email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulos`
--
ALTER TABLE `articulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `materiales`
--
ALTER TABLE `materiales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD CONSTRAINT `articulos_ibfk_1` FOREIGN KEY (`id_material`) REFERENCES `materiales` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


