-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 28-09-2023 a las 01:47:56
-- Versión del servidor: 8.0.33
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `autozone`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `IDclientes` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) DEFAULT NULL,
  `Direccion` varchar(255) DEFAULT NULL,
  `Telefono` varchar(15) DEFAULT NULL,
  `CorreoElectronico` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`IDclientes`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`IDclientes`, `Nombre`, `Direccion`, `Telefono`, `CorreoElectronico`) VALUES
(1, 'Armando', 'Calle 123, Ciudad H', '2321241298', 'wefwejkfnw@wefmwkefnew'),
(2, 'María García', 'Avenida XYZ, Ciudad G', '2321107835', 'maria@example.com'),
(3, 'Carlos Rodríguez', 'Calle 456, Ciudad C', '5555678901', 'carlos@example.com'),
(4, 'Luisa Martínez', 'Calle 789, Ciudad A', '5553456789', 'luisa@example.com'),
(5, 'Armando', 'Lázaro Cárdenas No. 308, Col. Ejidal', '2321241298', 'adolfolopezmaster@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

DROP TABLE IF EXISTS `compras`;
CREATE TABLE IF NOT EXISTS `compras` (
  `IDcompras` int NOT NULL AUTO_INCREMENT,
  `IDProveedor` int DEFAULT NULL,
  `FechaCompra` date DEFAULT NULL,
  `TotalCompra` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`IDcompras`),
  KEY `compras_ibfk_1` (`IDProveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`IDcompras`, `IDProveedor`, `FechaCompra`, `TotalCompra`) VALUES
(1, 1, '2023-09-15', '136.97'),
(2, 2, '2023-09-13', '89.01'),
(3, 3, '2023-09-12', '62.45'),
(4, 4, '2023-09-11', '13.98'),
(5, 5, '2023-09-10', '13.98');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_compra`
--

DROP TABLE IF EXISTS `detalles_compra`;
CREATE TABLE IF NOT EXISTS `detalles_compra` (
  `IDdetalles_compra` int NOT NULL AUTO_INCREMENT,
  `IDCompra` int DEFAULT NULL,
  `IDProducto` int DEFAULT NULL,
  `CantidadComprada` int DEFAULT NULL,
  `PrecioUnitarioCompra` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`IDdetalles_compra`),
  KEY `detalles_compra_ibfk_1` (`IDCompra`),
  KEY `detalles_compra_ibfk_2` (`IDProducto`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `detalles_compra`
--

INSERT INTO `detalles_compra` (`IDdetalles_compra`, `IDCompra`, `IDProducto`, `CantidadComprada`, `PrecioUnitarioCompra`) VALUES
(1, 1, 1, 3, '45.99'),
(2, 1, 3, 1, '28.99'),
(3, 2, 2, 1, '89.99'),
(4, 3, 4, 4, '12.49'),
(5, 4, 5, 2, '6.99');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_pedido`
--

DROP TABLE IF EXISTS `detalles_pedido`;
CREATE TABLE IF NOT EXISTS `detalles_pedido` (
  `IDdetalles_pedido` int NOT NULL AUTO_INCREMENT,
  `IDPedido` int DEFAULT NULL,
  `IDProducto` int DEFAULT NULL,
  `Cantidad` int DEFAULT NULL,
  `PrecioUnitario` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`IDdetalles_pedido`),
  KEY `ID_Producto` (`IDProducto`) INVISIBLE,
  KEY `detalles_pedido_ibfk_1` (`IDPedido`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `detalles_pedido`
--

INSERT INTO `detalles_pedido` (`IDdetalles_pedido`, `IDPedido`, `IDProducto`, `Cantidad`, `PrecioUnitario`) VALUES
(3, 2, 2, 1, '89.99'),
(4, 3, 4, 4, '12.49'),
(5, 4, 5, 2, '6.99');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE IF NOT EXISTS `pedidos` (
  `IDpedidos` int NOT NULL AUTO_INCREMENT,
  `IDCliente` int DEFAULT NULL,
  `FechaPedido` date DEFAULT NULL,
  `EstadoPedido` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`IDpedidos`),
  KEY `pedidos_ibfk_1` (`IDCliente`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`IDpedidos`, `IDCliente`, `FechaPedido`, `EstadoPedido`) VALUES
(2, 2, '2023-09-14', 'Enviado'),
(3, 3, '2023-09-12', 'Entregado'),
(4, 4, '2023-09-11', 'Pendiente'),
(6, 1, '2023-05-01', 'Muerto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `IDproductos` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) DEFAULT NULL,
  `Descripcion` text,
  `Precio` decimal(10,2) DEFAULT NULL,
  `Categoria` varchar(50) DEFAULT NULL,
  `Fabricante` varchar(100) DEFAULT NULL,
  `CantidadStock` int DEFAULT NULL,
  `destacado` varchar(45) DEFAULT NULL,
  `fecha_agregado` date DEFAULT NULL,
  `CodigoBarras` longblob,
  PRIMARY KEY (`IDproductos`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`IDproductos`, `Nombre`, `Descripcion`, `Precio`, `Categoria`, `Fabricante`, `CantidadStock`, `destacado`, `fecha_agregado`, `CodigoBarras`) VALUES
(1, 'Pastillas de freno delanteras', 'Pastillas de freno premium para autos de alta gama.', '45.99', 'Frenos', 'Marca A', 50, NULL, NULL, NULL),
(2, 'Batería de 12V', 'Batería de arranque para automóviles', '89.99', 'Baterías', 'Marca B', 30, NULL, NULL, NULL),
(3, 'Aceite sintético 5W-30', 'Aceite de motor sintético de alto rendimiento', '28.99', 'Aceites', 'Marca C', 100, NULL, NULL, NULL),
(4, 'Filtro de aire de repuesto', 'Filtro de aire de repuesto de calidad OEM', '12.49', 'Filtros', 'Marca D', 75, NULL, NULL, NULL),
(5, 'Bombilla halógena H4', 'Bombilla de faro halógena de alto brillo', '6.99', 'Luces', 'Marca E', 120, NULL, NULL, NULL),
(19, 'Aceite wt500', 'aceite para moto de baja ', '75.00', NULL, NULL, NULL, NULL, NULL, 0x32333632363830303036),
(20, 'bandas para vocho', 'bandas de motor para vocho ', '400.00', NULL, NULL, NULL, NULL, NULL, 0x32343535343437363337),
(21, 'faros para camioneta hilux', 'faros delanteros para camioneta hilux 2003', '7000.00', NULL, NULL, NULL, NULL, NULL, 0x38363032383232393834);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

DROP TABLE IF EXISTS `proveedores`;
CREATE TABLE IF NOT EXISTS `proveedores` (
  `IDproveedor` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) DEFAULT NULL,
  `Direccion` varchar(255) DEFAULT NULL,
  `Telefono` varchar(15) DEFAULT NULL,
  `CorreoElectronico` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`IDproveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`IDproveedor`, `Nombre`, `Direccion`, `Telefono`, `CorreoElectronico`) VALUES
(1, 'Proveedor 1', 'Calle Proveedor 1, Ciudad X', '555-111-1111', 'proveedor1@example.com'),
(2, 'Proveedor 2', 'Calle Proveedor 2, Ciudad Y', '555-222-2222', 'proveedor2@example.com'),
(3, 'Proveedor 3', 'Calle Proveedor 3, Ciudad Z', '555-333-3333', 'proveedor3@example.com'),
(4, 'Proveedor 4', 'Calle Proveedor 4, Ciudad W', '555-444-4444', 'proveedor4@example.com'),
(5, 'Proveedor 5', 'Calle Proveedor 5, Ciudad V', '555-555-5555', 'proveedor5@example.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Usuarios Login';

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `password`) VALUES
(1, 'Erick', 'Winsome1$'),
(2, 'Winsome', 'Erick1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

DROP TABLE IF EXISTS `ventas`;
CREATE TABLE IF NOT EXISTS `ventas` (
  `idVentas` int NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `cliente` varchar(45) DEFAULT NULL,
  `producto` varchar(45) DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `monto` varchar(45) DEFAULT NULL,
  `CodigoBarras` varchar(45) DEFAULT NULL,
  `TotalSinIVA` varchar(45) DEFAULT NULL,
  `IVA` varchar(45) DEFAULT NULL,
  `TotalConIVA` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idVentas`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`idVentas`, `fecha`, `cliente`, `producto`, `cantidad`, `precio`, `estado`, `monto`, `CodigoBarras`, `TotalSinIVA`, `IVA`, `TotalConIVA`) VALUES
(1, '2023-09-27', NULL, NULL, 3, NULL, NULL, NULL, '2362680006', '225', '36', '261'),
(2, '2023-09-27', NULL, NULL, 2, NULL, NULL, NULL, '8602822984', '14000', '2240', '16240'),
(3, '2023-09-27', NULL, NULL, 1, NULL, NULL, NULL, '2362680006', '7000', '1120', '8120'),
(4, '2023-09-27', NULL, NULL, 2, NULL, NULL, NULL, '2362680006 ', '150', '24', '174'),
(5, '2023-09-27', NULL, NULL, 1, NULL, NULL, NULL, '2455447637 ', '400', '64', '464'),
(6, '2023-09-27', NULL, NULL, 2, NULL, NULL, NULL, '8602822984  ', '14000', '2240', '16240');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`IDProveedor`) REFERENCES `proveedores` (`IDproveedor`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalles_compra`
--
ALTER TABLE `detalles_compra`
  ADD CONSTRAINT `detalles_compra_ibfk_1` FOREIGN KEY (`IDCompra`) REFERENCES `compras` (`IDcompras`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalles_compra_ibfk_2` FOREIGN KEY (`IDProducto`) REFERENCES `productos` (`IDproductos`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalles_pedido`
--
ALTER TABLE `detalles_pedido`
  ADD CONSTRAINT `detalles_pedido_ibfk_1` FOREIGN KEY (`IDPedido`) REFERENCES `pedidos` (`IDpedidos`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalles_pedido_ibfk_2` FOREIGN KEY (`IDProducto`) REFERENCES `productos` (`IDproductos`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`IDCliente`) REFERENCES `clientes` (`IDclientes`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
