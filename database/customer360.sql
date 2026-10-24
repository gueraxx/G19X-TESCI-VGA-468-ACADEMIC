-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3308
-- Tiempo de generación: 24-10-2026 a las 22:17:35
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
-- Base de datos: `customer360`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ai_cache`
--

CREATE TABLE `ai_cache` (
  `id` int(11) NOT NULL,
  `cache_key` varchar(64) NOT NULL,
  `prompt_hash` varchar(64) NOT NULL,
  `response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`response`)),
  `model` varchar(100) DEFAULT NULL,
  `hits` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `external_id` varchar(50) DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `company` varchar(150) DEFAULT NULL,
  `industry` varchar(100) DEFAULT NULL,
  `country` varchar(80) DEFAULT NULL,
  `city` varchar(80) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `segment` enum('bronze','silver','gold','platinum') DEFAULT 'bronze',
  `lifetime_value` decimal(12,2) DEFAULT 0.00,
  `churn_risk` float DEFAULT 0,
  `status` enum('active','inactive','blocked') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `customers`
--

INSERT INTO `customers` (`id`, `external_id`, `first_name`, `last_name`, `email`, `phone`, `company`, `industry`, `country`, `city`, `birth_date`, `segment`, `lifetime_value`, `churn_risk`, `status`, `created_at`) VALUES
(1, 'CRM-001', 'Bruce', 'Wayne', 'bruce.wayne@acme.com', '+52 555 111 2233', 'ACME Corp', 'Tecnología', 'México', 'CDMX', NULL, 'gold', 25000.00, 0.75, 'active', '2026-10-16 04:17:44'),
(2, 'CRM-002', 'María', 'García', 'maria.garcia@globex.com', '+52 555 444 5566', 'Globex', 'Manufactura', 'México', 'Monterrey', NULL, 'platinum', 62000.00, 0.75, 'active', '2026-10-16 04:17:44'),
(3, 'CRM-003', 'Carlos', 'López', 'carlos.lopez@initech.com', '+52 555 777 8899', 'Initech', 'Finanzas', 'México', 'Guadalajara', NULL, 'silver', 12000.00, 0.75, 'active', '2026-10-16 04:17:44'),
(4, 'CRM-004', 'Ana', 'Martínez', 'ana.martinez@umbrella.com', '+52 555 222 3344', 'Umbrella', 'Salud', 'México', 'CDMX', NULL, 'bronze', 3200.00, 0.75, 'active', '2026-10-16 04:17:44'),
(5, 'CRM-005', 'Luis', 'Rodríguez', 'luis.rodriguez@stark.com', '+52 555 888 9900', 'Stark Industries', 'Tecnología', 'México', 'Querétaro', NULL, 'gold', 31000.00, 0.75, 'active', '2026-10-16 04:17:44'),
(6, 'CRM-006', 'Pedro', 'Sánchez', 'pedro.sanchez@techcorp.com', '+52 555 100 2001', 'TechCorp', 'Tecnología', 'México', 'CDMX', NULL, 'silver', 8500.00, 0.9, 'active', '2026-10-24 17:59:55'),
(7, 'CRM-007', 'Laura', 'Ramírez', 'laura.ramirez@innovatech.com', '+52 555 100 2002', 'InnovaTech', 'Tecnología', 'México', 'Guadalajara', NULL, 'gold', 24500.00, 0.9, 'active', '2026-10-24 17:59:55'),
(8, 'CRM-008', 'Diego', 'Torres', 'diego.torres@construye.com', '+52 555 100 2003', 'Construye MX', 'Construcción', 'México', 'Monterrey', NULL, 'bronze', 1800.00, 0.9, 'active', '2026-10-24 17:59:55'),
(9, 'CRM-009', 'Sofía', 'Mendoza', 'sofia.mendoza@saludplus.com', '+52 555 100 2004', 'Salud Plus', 'Salud', 'México', 'CDMX', NULL, 'platinum', 75000.00, 0.9, 'active', '2026-10-24 17:59:55'),
(10, 'CRM-010', 'Javier', 'Ríos', 'javier.rios@financiera.com', '+52 555 100 2005', 'Financiera MX', 'Finanzas', 'México', 'Puebla', NULL, 'gold', 28000.00, 0.9, 'active', '2026-10-24 17:59:55'),
(11, 'CRM-011', 'Carla', 'Vega', 'carla.vega@retailmax.com', '+52 555 100 2006', 'RetailMax', 'Retail', 'México', 'Tijuana', NULL, 'silver', 11000.00, 0.9, 'active', '2026-10-24 17:59:55'),
(12, 'CRM-012', 'Ricardo', 'Fuentes', 'ricardo.fuentes@logistica.com', '+52 555 100 2007', 'Logística Ágil', 'Transporte', 'México', 'Querétaro', NULL, 'gold', 31500.00, 0.9, 'active', '2026-10-24 17:59:55'),
(13, 'CRM-013', 'Patricia', 'Navarro', 'patricia.navarro@educa.com', '+52 555 100 2008', 'Educa MX', 'Educación', 'México', 'Mérida', NULL, 'bronze', 2200.00, 0.9, 'active', '2026-10-24 17:59:55'),
(14, 'CRM-014', 'Andrés', 'Cruz', 'andres.cruz@alimentos.com', '+52 555 100 2009', 'Alimentos del Norte', 'Alimentos', 'México', 'Chihuahua', NULL, 'silver', 9800.00, 0.9, 'active', '2026-10-24 17:59:55'),
(15, 'CRM-015', 'Beatriz', 'Ortiz', 'beatriz.ortiz@moda.com', '+52 555 100 2010', 'Moda Bella', 'Retail', 'México', 'León', NULL, 'bronze', 3500.00, 0.9, 'active', '2026-10-24 17:59:55'),
(16, 'CRM-016', 'Fernando', 'Salinas', 'fernando.salinas@autopartes.com', '+52 555 100 2011', 'Autopartes MX', 'Automotriz', 'México', 'Toluca', NULL, 'gold', 26500.00, 0.9, 'active', '2026-10-24 17:59:55'),
(17, 'CRM-017', 'Gabriela', 'Campos', 'gabriela.campos@hoteles.com', '+52 555 100 2012', 'Hoteles Sol', 'Turismo', 'México', 'Cancún', NULL, 'platinum', 58000.00, 0.9, 'active', '2026-10-24 17:59:55'),
(18, 'CRM-018', 'Hugo', 'Delgado', 'hugo.delgado@seguros.com', '+52 555 100 2013', 'Seguros Ya', 'Seguros', 'México', 'CDMX', NULL, 'silver', 13500.00, 0.9, 'active', '2026-10-24 17:59:55'),
(19, 'CRM-019', 'Isabel', 'Ruiz', 'isabel.ruiz@agro.com', '+52 555 100 2014', 'AgroCampo', 'Agricultura', 'México', 'Culiacán', NULL, 'bronze', 2800.00, 0.9, 'active', '2026-10-24 17:59:55'),
(20, 'CRM-020', 'Jorge', 'Aguilar', 'jorge.aguilar@energia.com', '+52 555 100 2015', 'Energía Total', 'Energía', 'México', 'Monterrey', NULL, 'gold', 34000.00, 0.9, 'active', '2026-10-24 17:59:55'),
(21, 'CRM-021', 'Karen', 'Flores', 'karen.flores@belleza.com', '+52 555 100 2016', 'Belleza Spa', 'Belleza', 'México', 'Guadalajara', NULL, 'bronze', 4200.00, 0.9, 'active', '2026-10-24 17:59:55'),
(22, 'CRM-022', 'Leonardo', 'Espinoza', 'leonardo.espinoza@muebles.com', '+52 555 100 2017', 'Muebles Fino', 'Muebles', 'México', 'Aguascalientes', NULL, 'silver', 7500.00, 0.9, 'active', '2026-10-24 17:59:55'),
(23, 'CRM-023', 'Mónica', 'Chávez', 'monica.chavez@pharma.com', '+52 555 100 2018', 'PharmaLife', 'Salud', 'México', 'CDMX', NULL, 'platinum', 82000.00, 0.9, 'active', '2026-10-24 17:59:55'),
(24, 'CRM-024', 'Néstor', 'Vargas', 'nestor.vargas@tienda.com', '+52 555 100 2019', 'Tienda Don Néstor', 'Retail', 'México', 'Oaxaca', NULL, 'bronze', 1500.00, 0.9, 'active', '2026-10-24 17:59:55'),
(25, 'CRM-025', 'Olga', 'Paredes', 'olga.paredes@consultora.com', '+52 555 100 2020', 'Consultora P&P', 'Consultoría', 'México', 'CDMX', NULL, 'gold', 22000.00, 0.9, 'active', '2026-10-24 17:59:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `interactions`
--

CREATE TABLE `interactions` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `type` enum('call','email','chat','ticket','meeting','campaign') NOT NULL,
  `source` enum('crm','erp','sales','marketing','support') NOT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `sentiment` enum('positive','neutral','negative') DEFAULT 'neutral',
  `occurred_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `interactions`
--

INSERT INTO `interactions` (`id`, `customer_id`, `type`, `source`, `subject`, `description`, `sentiment`, `occurred_at`) VALUES
(1, 1, 'email', 'crm', 'Consulta sobre producto', 'Cliente pregunta por nuevas funcionalidades', 'positive', '2025-09-01 10:00:00'),
(2, 2, 'call', 'support', 'Soporte técnico', 'Problema resuelto en 30 min', 'positive', '2025-09-05 14:30:00'),
(3, 3, 'ticket', 'support', 'Error en facturación', 'Ticket escalado a nivel 2', 'negative', '2025-09-08 09:15:00'),
(4, 4, 'email', 'marketing', 'Campaña Q3', 'Cliente no abrió el email', 'neutral', '2025-08-20 08:00:00'),
(5, 5, 'meeting', 'sales', 'Reunión de renovación', 'Interesado en ampliar contrato', 'positive', '2025-09-12 11:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `external_id` varchar(50) DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `currency` varchar(3) DEFAULT 'USD',
  `channel` enum('web','mobile','store','phone','partner') DEFAULT 'web',
  `status` enum('pending','completed','refunded','cancelled') DEFAULT 'completed',
  `transaction_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `transactions`
--

INSERT INTO `transactions` (`id`, `customer_id`, `external_id`, `amount`, `currency`, `channel`, `status`, `transaction_date`) VALUES
(1, 1, 'INV-001', 5000.00, 'USD', 'web', 'completed', '2026-08-24 13:16:27'),
(2, 1, 'INV-002', 3500.00, 'USD', 'web', 'completed', '2026-10-04 13:16:27'),
(3, 2, 'INV-003', 15000.00, 'USD', 'store', 'completed', '2026-08-17 13:16:27'),
(4, 2, 'INV-004', 22000.00, 'USD', 'web', 'completed', '2026-06-15 13:16:27'),
(5, 3, 'INV-005', 4200.00, 'USD', 'mobile', 'completed', '2026-10-22 13:16:27'),
(6, 4, 'INV-006', 800.00, 'USD', 'web', 'completed', '2026-08-20 13:16:27'),
(7, 5, 'INV-007', 9800.00, 'USD', 'web', 'completed', '2026-10-04 13:16:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `role` enum('admin','analyst','sales','viewer') DEFAULT 'viewer',
  `is_active` tinyint(1) DEFAULT 1,
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `avatar_color` varchar(20) DEFAULT '#4361ee',
  `avatar_icon` varchar(50) DEFAULT 'bi-person-fill'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `email`, `password_hash`, `full_name`, `role`, `is_active`, `last_login`, `created_at`, `avatar_color`, `avatar_icon`) VALUES
(1, 'admin@customer360.com', '$2y$10$D5OYQPkcssuETJmBxLP1dOF.b0gWPYcb/jb68ZNqPaQQ4bCRzJJnu', 'Valentina Admin', 'admin', 1, '2026-10-24 10:55:31', '2026-10-16 04:17:44', '#10b981', 'bi-heart-fill'),
(2, 'analyst@customer360.com', '$2y$10$0bFenFImMlrcqOmw/htQGu4NMgfMRME8gCDuNJwGLAlVKEX0iZ./e', 'Ana Analyst', 'analyst', 1, NULL, '2026-10-16 04:17:44', '#4361ee', 'bi-person-fill'),
(3, 'sales@customer360.com', '$2y$10$430z/nYB3EZAQ/A6yOHQyuXXSO1XWcq27vJ0yJncM2CmWUUqkd2Ke', 'Sofía Sales', 'sales', 1, NULL, '2026-10-16 04:17:44', '#4361ee', 'bi-person-fill'),
(4, 'viewer@customer360.com', '$2y$10$X949Ya7Aw9KT0R5Nyj25VOcg/eGgQ.Zsha9yIzeV9ycUG6PkJeALa', 'Víctor Viewer', 'viewer', 1, NULL, '2026-10-16 04:17:44', '#4361ee', 'bi-person-fill');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ai_cache`
--
ALTER TABLE `ai_cache`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cache_key` (`cache_key`),
  ADD KEY `idx_key` (`cache_key`),
  ADD KEY `idx_expires` (`expires_at`);

--
-- Indices de la tabla `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `external_id` (`external_id`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_segment` (`segment`),
  ADD KEY `idx_churn` (`churn_risk`),
  ADD KEY `idx_status` (`status`);

--
-- Indices de la tabla `interactions`
--
ALTER TABLE `interactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_customer` (`customer_id`),
  ADD KEY `idx_type` (`type`),
  ADD KEY `idx_occurred` (`occurred_at`);

--
-- Indices de la tabla `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `external_id` (`external_id`),
  ADD KEY `idx_customer` (`customer_id`),
  ADD KEY `idx_date` (`transaction_date`),
  ADD KEY `idx_status` (`status`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_role` (`role`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ai_cache`
--
ALTER TABLE `ai_cache`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `interactions`
--
ALTER TABLE `interactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `interactions`
--
ALTER TABLE `interactions`
  ADD CONSTRAINT `interactions_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
