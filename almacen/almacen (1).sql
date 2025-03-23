-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-03-2025 a las 22:52:31
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
(2, 1, 'dasd', 'askklsajd', 44.00, '2025-03-22 16:52:48', 33.00, 0, '2025-03-23 10:35:58'),
(3, 1, 'anillo', 'anillo de metal,', 500.00, '2025-03-22 18:05:07', 20.00, 0, '2025-03-23 10:42:58'),
(4, 1, 'Aretes', 'par de arete de acero.', 200.00, '2025-03-22 23:13:14', 20.00, 0, NULL),
(6, 1, 'Bloque', 'Para contrucción', 15.00, '2025-03-23 09:48:45', 200.00, 0, '2025-03-23 10:36:26'),
(7, 1, 'Polla', 'Pene gigante de acero', 50.00, '2025-03-23 10:48:10', 200.00, 0, '2025-03-23 10:48:56'),
(8, 1, 'aniño', 'esto es una prueba', 30.00, '2025-03-23 15:39:46', 80.00, 0, '2025-03-23 16:21:34'),
(9, 1, 'anillo', 'prueba 2', 100.00, '2025-03-23 15:47:28', 100.00, 0, '2025-03-23 15:49:06'),
(10, 1, 'anillo', 'con un cristal', 300.00, '2025-03-23 16:32:34', 20.00, 0, '2025-03-23 16:33:23'),
(11, 1, 'anillo', 'aasd', 11.00, '2025-03-23 16:39:49', 11.00, 0, '2025-03-23 16:39:58'),
(12, 1, 'Aretes', 'asdas', 111.00, '2025-03-23 16:41:09', 111.00, 0, '2025-03-23 16:41:17');

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
(3, 'Waitita', '$2y$10$RhMsBptiT1IwI3doet4Kre5p5OS1fuQr3QyaTaAKAiikI/lp9YBme', 'blancaiselaandradechacon123@gmail.com', '2025-03-23 04:07:20', 1),
(4, 'Chappy', '$2y$10$xOQzWkKgL2qCL.pSpG3BTeQezn8rbfImHEEDrHDxSsIKC.1et2asm', 'chappyestrella@gmail.com', '2025-03-23 14:46:25', 1),
(5, 'prueba', '$2y$10$LKjGrqWkvkv1JRbtaSqXh.KLaxazaQQQx8lO6aR84LgIE.XkGaC6e', 'moisess@gmail.com', '2025-03-23 15:24:27', 1),
(6, 'Benjamín Benítez', '$2y$10$BnTBeQX47HJ4LBpdYWckTe51Bc1zCc8UERfUoVX8LHNrctKn.j.xy', 'josebcruz15@gmail.com', '2025-03-23 15:47:39', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `id_articulo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_venta` datetime DEFAULT current_timestamp(),
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `total` decimal(10,2) GENERATED ALWAYS AS (`cantidad` * `precio_unitario`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `id_articulo`, `id_usuario`, `fecha_venta`, `cantidad`, `precio_unitario`) VALUES
(1, 6, 5, '2025-03-23 10:29:17', 1, 16.50),
(2, 6, 5, '2025-03-23 10:29:35', 1, 16.50),
(3, 6, 5, '2025-03-23 10:30:46', 14, 16.50),
(4, 2, 5, '2025-03-23 10:35:58', 1, 48.40),
(5, 6, 5, '2025-03-23 10:36:26', 1, 16.50),
(6, 3, 5, '2025-03-23 10:42:58', 2, 550.00),
(7, 7, 6, '2025-03-23 10:48:56', 2, 55.00),
(8, 9, 5, '2025-03-23 15:49:06', 1, 110.00),
(9, 8, 5, '2025-03-23 16:21:34', 1, 33.00),
(10, 10, 5, '2025-03-23 16:33:23', 1, 330.00),
(11, 11, 5, '2025-03-23 16:39:58', 1, 12.10),
(12, 12, 5, '2025-03-23 16:41:17', 1, 122.10);

--
-- Disparadores `ventas`
--
DELIMITER $$
CREATE TRIGGER `actualizar_stock_venta` AFTER INSERT ON `ventas` FOR EACH ROW BEGIN
    UPDATE Articulos 
    SET activo = 0,
        fecha_salida = NOW()
    WHERE id = NEW.id_articulo;
END
$$
DELIMITER ;

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
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_articulo` (`id_articulo`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulos`
--
ALTER TABLE `articulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `materiales`
--
ALTER TABLE `materiales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD CONSTRAINT `articulos_ibfk_1` FOREIGN KEY (`id_material`) REFERENCES `materiales` (`id`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`id_articulo`) REFERENCES `articulos` (`id`),
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
