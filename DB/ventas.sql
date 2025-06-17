-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 03-03-2025 a las 22:16:42
-- Versión del servidor: 8.0.30
-- Versión de PHP: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ventas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autor`
--

CREATE TABLE `autor` (
  `idAutor` int NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `biografia` text,
  `paisorigen` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `autor`
--

INSERT INTO `autor` (`idAutor`, `codigo`, `nombre`, `biografia`, `paisorigen`) VALUES
(7, '22332', 'gabriel garcia marquez', 'Nació Aracataca en Magdalena', 'Colombia'),
(8, '22332', 'Gabriel García Márquez', 'Nació en Aracataca, Magdalena', 'Colombia'),
(9, '33443', 'Isabel Allende', 'Nació en Lima, escritora chilena de renombre internacional', 'Chile'),
(10, '44554', 'Mario Vargas Llosa', 'Novelista y ensayista peruano, ganador del Premio Nobel', 'Perú'),
(11, '55665', 'Jorge Luis Borges', 'Nació en Buenos Aires, pionero de la literatura moderna', 'Argentina'),
(12, '66776', 'Laura Esquivel', 'Escritora mexicana, famosa por \"Como agua para chocolate\"', 'México'),
(13, '77887', 'Pablo Neruda', 'Poeta chileno, ganador del Premio Nobel de Literatura', 'Chile'),
(14, '88998', 'Octavio Paz', 'Ensayista y poeta mexicano, Premio Nobel de Literatura', 'México'),
(15, '99009', 'Juan Rulfo', 'Autor mexicano conocido por \"Pedro Páramo\"', 'México'),
(16, '10101', 'Carlos Fuentes', 'Nació en Panamá, destacado novelista mexicano', 'México'),
(17, '11112', 'Alejo Carpentier', 'Escritor cubano, maestro del realismo mágico', 'Cuba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `caja_id` int NOT NULL,
  `caja_numero` int NOT NULL,
  `caja_nombre` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `caja_efectivo` decimal(30,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`caja_id`, `caja_numero`, `caja_nombre`, `caja_efectivo`) VALUES
(1, 1, 'Caja #1', 1180000.00),
(2, 2, 'Caja #2', 580000.00),
(3, 3, 'Caja #1', 1180000.00),
(4, 4, 'Caja #2', 580000.00),
(5, 5, 'Caja #3', 725000.00),
(6, 6, 'Caja #4', 950000.00),
(7, 7, 'Caja #5', 430000.00),
(8, 8, 'Caja #6', 870000.00),
(9, 9, 'Caja #7', 1235000.00),
(10, 10, 'Caja #8', 645000.00),
(11, 11, 'Caja #9', 980000.00),
(12, 13, 'Caja #10', 1120000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `categoria_id` int NOT NULL,
  `categoria_nombre` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `categoria_ubicacion` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`categoria_id`, `categoria_nombre`, `categoria_ubicacion`) VALUES
(5, 'Realismo Mágico', 'Pasillo 3'),
(6, 'gaseosa', 'Seccion 2'),
(7, 'Gaseosa Colombiana', 'Seccion 2'),
(8, 'PANADERO', 'Biblioteca pasillo 4'),
(9, 'POESIA', 'Bodega pasillo 2'),
(10, 'ARROZ', 'Bodega pasillo 2'),
(11, 'sdfsfds', 'Biblioteca pasillo 8'),
(12, 'gdfg', 'Biblioteca pasillo 8'),
(13, 'dfdfffff', 'Biblioteca pasillo 4'),
(14, 'klooiiu', 'Bodega pasillo 2'),
(15, 'POLLO', 'Piso 3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `cliente_id` int NOT NULL,
  `cliente_tipo_documento` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `cliente_numero_documento` varchar(35) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `cliente_nombre` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `cliente_apellido` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `cliente_provincia` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `cliente_ciudad` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `cliente_direccion` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `cliente_telefono` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `cliente_email` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`cliente_id`, `cliente_tipo_documento`, `cliente_numero_documento`, `cliente_nombre`, `cliente_apellido`, `cliente_provincia`, `cliente_ciudad`, `cliente_direccion`, `cliente_telefono`, `cliente_email`) VALUES
(1, 'Otro', 'N/A', 'Publico', 'General', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A'),
(4, 'Licencia', '2114535456', 'Juliana', 'Macias', 'Huila', 'Guadalupe', 'barrio Santa Lucía', '3118041644', 'JulianaMacias@gmail.com'),
(5, 'DNI', '12345678', 'María', 'Pérez', 'Madrid', 'Madrid', 'Calle de la Luna 25', '612345678', 'maria.perez@gmail.com'),
(6, 'DNI', '23456789', 'Ana', 'García', 'Barcelona', 'Barcelona', 'Carrer del Sol 15', '622345678', 'ana.garcia@gmail.com'),
(7, 'DNI', '34567890', 'Lucía', 'Rodríguez', 'Sevilla', 'Sevilla', 'Avenida de Andalucía 8', '632345678', 'lucia.rodriguez@gmail.com'),
(8, 'DNI', '45678901', 'Carmen', 'Fernández', 'Valencia', 'Valencia', 'Calle del Mar 12', '642345678', 'carmen.fernandez@gmail.com'),
(9, 'DNI', '56789012', 'Laura', 'Gómez', 'Bilbao', 'Bilbao', 'Plaza Mayor 9', '652345678', 'laura.gomez@gmail.com'),
(10, 'DNI', '67890123', 'Sara', 'Martínez', 'Zaragoza', 'Zaragoza', 'Paseo de la Independencia 14', '662345678', 'sara.martinez@gmail.com'),
(11, 'DNI', '78901234', 'Paula', 'López', 'Málaga', 'Málaga', 'Calle Larios 20', '672345678', 'paula.lopez@gmail.com'),
(12, 'DNI', '89012345', 'Claudia', 'Hernández', 'Granada', 'Granada', 'Camino de Ronda 18', '682345678', 'claudia.hernandez@gmail.com'),
(13, 'DNI', '90123456', 'Elena', 'Ruiz', 'Córdoba', 'Córdoba', 'Calle Cruz Conde 22', '692345678', 'elena.ruiz@gmail.com'),
(14, 'DNI', '12345679', 'Patricia', 'Díaz', 'Santander', 'Santander', 'Calle del Río 11', '602345678', 'patricia.diaz@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `editorial`
--

CREATE TABLE `editorial` (
  `idEditorial` int NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `informacioncontacto` text,
  `pais` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `editorial`
--

INSERT INTO `editorial` (`idEditorial`, `codigo`, `nombre`, `informacioncontacto`, `pais`) VALUES
(6, '223232', 'planeta', 'Bogota 21123123121', 'colombia'),
(7, '223232', 'Planeta', 'Bogotá 21123123121', 'Colombia'),
(8, '334343', 'Penguin Random House', 'Madrid 912345678', 'España'),
(9, '445454', 'HarperCollins', 'Nueva York 1234567890', 'Estados Unidos'),
(10, '556565', 'Anagrama', 'Barcelona 933456789', 'España'),
(11, '667676', 'Alfaguara', 'Lima 987654321', 'Perú'),
(12, '778787', 'Fondo de Cultura Económica', 'Ciudad de México 5543219876', 'México'),
(13, '889898', 'Santillana', 'Buenos Aires 114567890', 'Argentina'),
(14, '990909', 'Tusquets Editores', 'Barcelona 934567891', 'España'),
(15, '1010101', 'Editorial Norma', 'Bogotá 3159876543', 'Colombia'),
(16, '1111112', 'Ediciones Era', 'Ciudad de México 5541237890', 'México');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `empresa_id` int NOT NULL,
  `empresa_nombre` varchar(90) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `empresa_telefono` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `empresa_email` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `empresa_direccion` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `empresa_foto` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`empresa_id`, `empresa_nombre`, `empresa_telefono`, `empresa_email`, `empresa_direccion`, `empresa_foto`) VALUES
(1, 'Allbooks', '3217696864', 'allboooks12@gmail.com', 'carrera 6 # 32-12', 'R7M1B9Q7Q9-83.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `producto_id` int NOT NULL,
  `producto_codigo` varchar(77) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `producto_nombre` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `producto_stock_total` int NOT NULL,
  `producto_tipo_unidad` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `producto_precio_compra` decimal(30,2) NOT NULL,
  `producto_precio_venta` decimal(30,2) NOT NULL,
  `producto_marca` varchar(35) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `producto_modelo` varchar(35) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `producto_estado` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `producto_foto` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `categoria_id` int NOT NULL,
  `id_subcategoria` int DEFAULT NULL,
  `idAutor` int DEFAULT NULL,
  `idEditorial` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`producto_id`, `producto_codigo`, `producto_nombre`, `producto_stock_total`, `producto_tipo_unidad`, `producto_precio_compra`, `producto_precio_venta`, `producto_marca`, `producto_modelo`, `producto_estado`, `producto_foto`, `categoria_id`, `id_subcategoria`, `idAutor`, `idEditorial`) VALUES
(15, '82923', 'Cien años de seriedad', 26, 'Caja', 32000.00, 40000.00, 'planeta', '21321351', 'Habilitado', '82923_83.jpg', 5, 9, 7, 6),
(16, '37271', 'el coronel', 80, 'Unidad', 32000.00, 40000.00, 'PLANETA', '3828712', 'Habilitado', '', 5, 9, 7, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategoria`
--

CREATE TABLE `subcategoria` (
  `id_subcategoria` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `categoria_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `subcategoria`
--

INSERT INTO `subcategoria` (`id_subcategoria`, `nombre`, `categoria_id`) VALUES
(9, 'Realismo Ficcion', 5),
(10, 'pan2', 6),
(11, 'subcategoria1', 8),
(12, 'Autobiografía', 9),
(13, 'pan2655', 9),
(14, 'pan2655', 9),
(15, 'Artículos científicos', 15),
(16, 'Artículos científicos', 7),
(17, 'subcategoria1', 15),
(18, 'Artículos científicos 2', 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int NOT NULL,
  `usuario_nombre` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `usuario_apellido` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `usuario_email` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `usuario_usuario` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `usuario_clave` varchar(535) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `usuario_cargo` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `usuario_foto` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `caja_id` int NOT NULL,
  `usuario_creado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_actualizado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `usuario_nombre`, `usuario_apellido`, `usuario_email`, `usuario_usuario`, `usuario_clave`, `usuario_cargo`, `usuario_foto`, `caja_id`, `usuario_creado`, `usuario_actualizado`) VALUES
(1, 'Administrador', 'Principal', 'admin@admin.com', 'Administrador', '$2y$10$od1ZIIaCTLIYjxcTY6zHYugid/SDtxxf5Ev2goOkhxQ1HBQhUzYnW', 'Administrador', '', 1, '2025-02-26 00:23:06', '2025-02-26 00:23:06'),
(5, 'Usuario administrador', 'usuarioadministrador', 'user12@gmail.com', 'user12', '$2y$10$CIlB0xBsoHzoGrWpE0Ub1OGX6.4MOEPYpDSf3yAAVYhZoaMAX4.Lu', 'Administrador', 'Usuario_administrador_16.png', 1, '2025-02-26 23:59:26', '2025-02-26 23:59:26'),
(10, 'admin', 'admin', '', 'admin', '$2y$10$IEpiimRceGUT8dz5pUVdIuIYY27tBQcDOJv6gu4dyvZIzxPjfmp2a', 'Administrador', '', 1, '2025-03-03 22:14:20', '2025-03-03 22:14:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `venta_id` int NOT NULL,
  `venta_codigo` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `venta_fecha` date NOT NULL,
  `venta_hora` varchar(17) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `venta_total` decimal(30,2) NOT NULL,
  `venta_pagado` decimal(30,2) NOT NULL,
  `venta_cambio` decimal(30,2) NOT NULL,
  `usuario_id` int NOT NULL,
  `cliente_id` int NOT NULL,
  `caja_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_detalle`
--

CREATE TABLE `venta_detalle` (
  `venta_detalle_id` int NOT NULL,
  `venta_detalle_cantidad` int NOT NULL,
  `venta_detalle_precio_compra` decimal(30,2) NOT NULL,
  `venta_detalle_precio_venta` decimal(30,2) NOT NULL,
  `venta_detalle_total` decimal(30,2) NOT NULL,
  `venta_detalle_descripcion` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `venta_codigo` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `producto_id` int NOT NULL,
  `autor` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `autor`
--
ALTER TABLE `autor`
  ADD PRIMARY KEY (`idAutor`);

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`caja_id`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`categoria_id`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cliente_id`);

--
-- Indices de la tabla `editorial`
--
ALTER TABLE `editorial`
  ADD PRIMARY KEY (`idEditorial`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`empresa_id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`producto_id`),
  ADD KEY `categoria_id` (`categoria_id`),
  ADD KEY `producto_ibfk_3` (`id_subcategoria`),
  ADD KEY `fk_producto_autor` (`idAutor`),
  ADD KEY `fk_producto_editorial` (`idEditorial`);

--
-- Indices de la tabla `subcategoria`
--
ALTER TABLE `subcategoria`
  ADD PRIMARY KEY (`id_subcategoria`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`),
  ADD KEY `caja_id` (`caja_id`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`venta_id`),
  ADD UNIQUE KEY `venta_codigo` (`venta_codigo`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `caja_id` (`caja_id`);

--
-- Indices de la tabla `venta_detalle`
--
ALTER TABLE `venta_detalle`
  ADD PRIMARY KEY (`venta_detalle_id`),
  ADD KEY `venta_id` (`venta_codigo`),
  ADD KEY `producto_id` (`producto_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `autor`
--
ALTER TABLE `autor`
  MODIFY `idAutor` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `caja_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `categoria_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `cliente_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `editorial`
--
ALTER TABLE `editorial`
  MODIFY `idEditorial` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `empresa_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `producto_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `subcategoria`
--
ALTER TABLE `subcategoria`
  MODIFY `id_subcategoria` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `venta_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `venta_detalle`
--
ALTER TABLE `venta_detalle`
  MODIFY `venta_detalle_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_autor` FOREIGN KEY (`idAutor`) REFERENCES `autor` (`idAutor`),
  ADD CONSTRAINT `fk_producto_editorial` FOREIGN KEY (`idEditorial`) REFERENCES `editorial` (`idEditorial`),
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`categoria_id`),
  ADD CONSTRAINT `producto_ibfk_3` FOREIGN KEY (`id_subcategoria`) REFERENCES `subcategoria` (`id_subcategoria`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Filtros para la tabla `subcategoria`
--
ALTER TABLE `subcategoria`
  ADD CONSTRAINT `subcategoria_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`categoria_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
