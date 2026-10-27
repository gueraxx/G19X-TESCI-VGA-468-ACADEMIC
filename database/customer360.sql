-- =====================================================
-- Base de datos: Customer 360 (Versión BIEN CHIDA)
-- Proyecto: Plataforma Inteligente Customer 360
-- Autor: Valentina — PluriOne
-- =====================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS customer360 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE customer360;

-- =====================================================
-- TABLAS
-- =====================================================

CREATE TABLE `ai_cache` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cache_key` varchar(64) NOT NULL,
  `prompt_hash` varchar(64) NOT NULL,
  `response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`response`)),
  `model` varchar(100) DEFAULT NULL,
  `hits` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expires_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cache_key` (`cache_key`),
  KEY `idx_key` (`cache_key`),
  KEY `idx_expires` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `external_id` (`external_id`),
  KEY `idx_email` (`email`),
  KEY `idx_segment` (`segment`),
  KEY `idx_churn` (`churn_risk`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `interactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `type` enum('call','email','chat','ticket','meeting','campaign') NOT NULL,
  `source` enum('crm','erp','sales','marketing','support') NOT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `sentiment` enum('positive','neutral','negative') DEFAULT 'neutral',
  `occurred_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_customer` (`customer_id`),
  KEY `idx_type` (`type`),
  KEY `idx_occurred` (`occurred_at`),
  CONSTRAINT `interactions_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `external_id` varchar(50) DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `currency` varchar(3) DEFAULT 'USD',
  `channel` enum('web','mobile','store','phone','partner') DEFAULT 'web',
  `status` enum('pending','completed','refunded','cancelled') DEFAULT 'completed',
  `transaction_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `external_id` (`external_id`),
  KEY `idx_customer` (`customer_id`),
  KEY `idx_date` (`transaction_date`),
  KEY `idx_status` (`status`),
  CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `role` enum('admin','analyst','sales','viewer') DEFAULT 'viewer',
  `is_active` tinyint(1) DEFAULT 1,
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `avatar_color` varchar(20) DEFAULT '#4361ee',
  `avatar_icon` varchar(50) DEFAULT 'bi-person-fill',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_email` (`email`),
  KEY `idx_role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- DATOS DE PRUEBA
-- =====================================================

-- Usuarios
INSERT INTO `users` (`id`, `email`, `password_hash`, `full_name`, `role`, `is_active`, `avatar_color`, `avatar_icon`) VALUES
(1, 'admin@customer360.com', '$2y$10$D5OYQPkcssuETJmBxLP1dOF.b0gWPYcb/jb68ZNqPaQQ4bCRzJJnu', 'Valentina Admin', 'admin', 1, '#10b981', 'bi-heart-fill'),
(2, 'analyst@customer360.com', '$2y$10$0bFenFImMlrcqOmw/htQGu4NMgfMRME8gCDuNJwGLAlVKEX0iZ./e', 'Ana Analyst', 'analyst', 1, '#4361ee', 'bi-person-fill'),
(3, 'sales@customer360.com', '$2y$10$430z/nYB3EZAQ/A6yOHQyuXXSO1XWcq27vJ0yJncM2CmWUUqkd2Ke', 'Sofía Sales', 'sales', 1, '#4361ee', 'bi-person-fill'),
(4, 'viewer@customer360.com', '$2y$10$X949Ya7Aw9KT0R5Nyj25VOcg/eGgQ.Zsha9yIzeV9ycUG6PkJeALa', 'Víctor Viewer', 'viewer', 1, '#4361ee', 'bi-person-fill');

-- Clientes (25 en total)
INSERT INTO `customers` (`id`, `external_id`, `first_name`, `last_name`, `email`, `company`, `industry`, `country`, `city`, `segment`, `lifetime_value`, `churn_risk`, `status`, `created_at`) VALUES
(1, 'CRM-001', 'Bruce', 'Wayne', 'bruce.wayne@acme.com', 'ACME Corp', 'Tecnología', 'México', 'CDMX', 'gold', 8500.00, 0.15, 'active', DATE_SUB(NOW(), INTERVAL 300 DAY)),
(2, 'CRM-002', 'María', 'García', 'maria.garcia@globex.com', 'Globex', 'Manufactura', 'México', 'Monterrey', 'platinum', 37000.00, 0.10, 'active', DATE_SUB(NOW(), INTERVAL 250 DAY)),
(3, 'CRM-003', 'Carlos', 'López', 'carlos.lopez@initech.com', 'Initech', 'Finanzas', 'México', 'Guadalajara', 'silver', 4200.00, 0.35, 'active', DATE_SUB(NOW(), INTERVAL 200 DAY)),
(4, 'CRM-004', 'Ana', 'Martínez', 'ana.martinez@umbrella.com', 'Umbrella', 'Salud', 'México', 'CDMX', 'bronze', 800.00, 0.75, 'active', DATE_SUB(NOW(), INTERVAL 180 DAY)),
(5, 'CRM-005', 'Luis', 'Rodríguez', 'luis.rodriguez@stark.com', 'Stark Industries', 'Tecnología', 'México', 'Querétaro', 'silver', 9800.00, 0.20, 'active', DATE_SUB(NOW(), INTERVAL 150 DAY)),
(6, 'CRM-006', 'Pedro', 'Sánchez', 'pedro.sanchez@techcorp.com', 'TechCorp', 'Tecnología', 'México', 'CDMX', 'silver', 8500.00, 0.35, 'active', DATE_SUB(NOW(), INTERVAL 100 DAY)),
(7, 'CRM-007', 'Laura', 'Ramírez', 'laura.ramirez@innovatech.com', 'InnovaTech', 'Tecnología', 'México', 'Guadalajara', 'gold', 24500.00, 0.10, 'active', DATE_SUB(NOW(), INTERVAL 90 DAY)),
(8, 'CRM-008', 'Diego', 'Torres', 'diego.torres@construye.com', 'Construye MX', 'Construcción', 'México', 'Monterrey', 'bronze', 1800.00, 0.75, 'active', DATE_SUB(NOW(), INTERVAL 80 DAY)),
(9, 'CRM-009', 'Sofía', 'Mendoza', 'sofia.mendoza@saludplus.com', 'Salud Plus', 'Salud', 'México', 'CDMX', 'platinum', 75000.00, 0.10, 'active', DATE_SUB(NOW(), INTERVAL 75 DAY)),
(10, 'CRM-010', 'Javier', 'Ríos', 'javier.rios@financiera.com', 'Financiera MX', 'Finanzas', 'México', 'Puebla', 'gold', 28000.00, 0.10, 'active', DATE_SUB(NOW(), INTERVAL 70 DAY)),
(11, 'CRM-011', 'Carla', 'Vega', 'carla.vega@retailmax.com', 'RetailMax', 'Retail', 'México', 'Tijuana', 'silver', 11000.00, 0.45, 'active', DATE_SUB(NOW(), INTERVAL 60 DAY)),
(12, 'CRM-012', 'Ricardo', 'Fuentes', 'ricardo.fuentes@logistica.com', 'Logística Ágil', 'Transporte', 'México', 'Querétaro', 'gold', 31500.00, 0.10, 'active', DATE_SUB(NOW(), INTERVAL 55 DAY)),
(13, 'CRM-013', 'Patricia', 'Navarro', 'patricia.navarro@educa.com', 'Educa MX', 'Educación', 'México', 'Mérida', 'bronze', 2200.00, 0.55, 'active', DATE_SUB(NOW(), INTERVAL 50 DAY)),
(14, 'CRM-014', 'Andrés', 'Cruz', 'andres.cruz@alimentos.com', 'Alimentos del Norte', 'Alimentos', 'México', 'Chihuahua', 'silver', 9800.00, 0.45, 'active', DATE_SUB(NOW(), INTERVAL 45 DAY)),
(15, 'CRM-015', 'Beatriz', 'Ortiz', 'beatriz.ortiz@moda.com', 'Moda Bella', 'Retail', 'México', 'León', 'bronze', 3500.00, 0.75, 'active', DATE_SUB(NOW(), INTERVAL 40 DAY)),
(16, 'CRM-016', 'Fernando', 'Salinas', 'fernando.salinas@autopartes.com', 'Autopartes MX', 'Automotriz', 'México', 'Toluca', 'gold', 26500.00, 0.20, 'active', DATE_SUB(NOW(), INTERVAL 35 DAY)),
(17, 'CRM-017', 'Gabriela', 'Campos', 'gabriela.campos@hoteles.com', 'Hoteles Sol', 'Turismo', 'México', 'Cancún', 'platinum', 58000.00, 0.10, 'active', DATE_SUB(NOW(), INTERVAL 30 DAY)),
(18, 'CRM-018', 'Hugo', 'Delgado', 'hugo.delgado@seguros.com', 'Seguros Ya', 'Seguros', 'México', 'CDMX', 'silver', 13500.00, 0.45, 'active', DATE_SUB(NOW(), INTERVAL 25 DAY)),
(19, 'CRM-019', 'Isabel', 'Ruiz', 'isabel.ruiz@agro.com', 'AgroCampo', 'Agricultura', 'México', 'Culiacán', 'bronze', 2800.00, 0.75, 'active', DATE_SUB(NOW(), INTERVAL 20 DAY)),
(20, 'CRM-020', 'Jorge', 'Aguilar', 'jorge.aguilar@energia.com', 'Energía Total', 'Energía', 'México', 'Monterrey', 'gold', 34000.00, 0.15, 'active', DATE_SUB(NOW(), INTERVAL 18 DAY)),
(21, 'CRM-021', 'Karen', 'Flores', 'karen.flores@belleza.com', 'Belleza Spa', 'Belleza', 'México', 'Guadalajara', 'bronze', 4200.00, 0.40, 'active', DATE_SUB(NOW(), INTERVAL 15 DAY)),
(22, 'CRM-022', 'Leonardo', 'Espinoza', 'leonardo.espinoza@muebles.com', 'Muebles Fino', 'Muebles', 'México', 'Aguascalientes', 'silver', 7500.00, 0.55, 'active', DATE_SUB(NOW(), INTERVAL 12 DAY)),
(23, 'CRM-023', 'Mónica', 'Chávez', 'monica.chavez@pharma.com', 'PharmaLife', 'Salud', 'México', 'CDMX', 'platinum', 82000.00, 0.10, 'active', DATE_SUB(NOW(), INTERVAL 10 DAY)),
(24, 'CRM-024', 'Néstor', 'Vargas', 'nestor.vargas@tienda.com', 'Tienda Don Néstor', 'Retail', 'México', 'Oaxaca', 'bronze', 1500.00, 0.75, 'active', DATE_SUB(NOW(), INTERVAL 8 DAY)),
(25, 'CRM-025', 'Olga', 'Paredes', 'olga.paredes@consultora.com', 'Consultora P&P', 'Consultoría', 'México', 'CDMX', 'gold', 22000.00, 0.20, 'active', DATE_SUB(NOW(), INTERVAL 5 DAY));

-- =====================================================
-- TRANSACCIONES (Calculadas para que cuadren con LTV)
-- =====================================================
INSERT INTO `transactions` (`customer_id`, `external_id`, `amount`, `channel`, `transaction_date`) VALUES
-- Bruce (LTV 8500)
(1, 'INV-001', 5000.00, 'web', DATE_SUB(NOW(), INTERVAL 10 DAY)),
(1, 'INV-002', 3500.00, 'web', DATE_SUB(NOW(), INTERVAL 45 DAY)),
-- María (LTV 37000)
(2, 'INV-003', 15000.00, 'store', DATE_SUB(NOW(), INTERVAL 15 DAY)),
(2, 'INV-004', 22000.00, 'web', DATE_SUB(NOW(), INTERVAL 40 DAY)),
-- Carlos (LTV 4200)
(3, 'INV-005', 4200.00, 'mobile', DATE_SUB(NOW(), INTERVAL 60 DAY)),
-- Ana (LTV 800)
(4, 'INV-006', 800.00, 'web', DATE_SUB(NOW(), INTERVAL 120 DAY)),
-- Luis (LTV 9800)
(5, 'INV-007', 9800.00, 'web', DATE_SUB(NOW(), INTERVAL 30 DAY)),
-- Pedro (LTV 8500, 60 días, 2 compras)
(6, 'INV-008', 4500.00, 'web', DATE_SUB(NOW(), INTERVAL 60 DAY)),
(6, 'INV-009', 4000.00, 'store', DATE_SUB(NOW(), INTERVAL 100 DAY)),
-- Laura (LTV 24500, 3 compras)
(7, 'INV-010', 10000.00, 'web', DATE_SUB(NOW(), INTERVAL 5 DAY)),
(7, 'INV-011', 8500.00, 'store', DATE_SUB(NOW(), INTERVAL 20 DAY)),
(7, 'INV-012', 6000.00, 'web', DATE_SUB(NOW(), INTERVAL 40 DAY)),
-- Diego (LTV 1800, 1 compra hace 120 días)
(8, 'INV-013', 1800.00, 'web', DATE_SUB(NOW(), INTERVAL 120 DAY)),
-- Sofía (LTV 75000, 3 compras)
(9, 'INV-014', 25000.00, 'web', DATE_SUB(NOW(), INTERVAL 5 DAY)),
(9, 'INV-015', 30000.00, 'store', DATE_SUB(NOW(), INTERVAL 40 DAY)),
(9, 'INV-016', 20000.00, 'mobile', DATE_SUB(NOW(), INTERVAL 75 DAY)),
-- Javier (LTV 28000, 4 compras)
(10, 'INV-017', 8000.00, 'web', DATE_SUB(NOW(), INTERVAL 10 DAY)),
(10, 'INV-018', 10000.00, 'store', DATE_SUB(NOW(), INTERVAL 30 DAY)),
(10, 'INV-019', 5000.00, 'web', DATE_SUB(NOW(), INTERVAL 60 DAY)),
(10, 'INV-020', 5000.00, 'mobile', DATE_SUB(NOW(), INTERVAL 90 DAY)),
-- Carla (LTV 11000, 2 compras hace 45 días)
(11, 'INV-021', 6000.00, 'web', DATE_SUB(NOW(), INTERVAL 45 DAY)),
(11, 'INV-022', 5000.00, 'store', DATE_SUB(NOW(), INTERVAL 80 DAY)),
-- Ricardo (LTV 31500, 4 compras)
(12, 'INV-023', 15000.00, 'web', DATE_SUB(NOW(), INTERVAL 15 DAY)),
(12, 'INV-024', 10000.00, 'web', DATE_SUB(NOW(), INTERVAL 45 DAY)),
(12, 'INV-025', 4000.00, 'store', DATE_SUB(NOW(), INTERVAL 70 DAY)),
(12, 'INV-026', 2500.00, 'web', DATE_SUB(NOW(), INTERVAL 100 DAY)),
-- Patricia (LTV 2200, 2 compras hace 65 días)
(13, 'INV-027', 1200.00, 'web', DATE_SUB(NOW(), INTERVAL 65 DAY)),
(13, 'INV-028', 1000.00, 'store', DATE_SUB(NOW(), INTERVAL 100 DAY)),
-- Andrés (LTV 9800, 2 compras hace 50 días)
(14, 'INV-029', 5000.00, 'web', DATE_SUB(NOW(), INTERVAL 50 DAY)),
(14, 'INV-030', 4800.00, 'store', DATE_SUB(NOW(), INTERVAL 80 DAY)),
-- Beatriz (LTV 3500, 1 compra hace 95 días)
(15, 'INV-031', 3500.00, 'web', DATE_SUB(NOW(), INTERVAL 95 DAY)),
-- Fernando (LTV 26500, 3 compras)
(16, 'INV-032', 12000.00, 'web', DATE_SUB(NOW(), INTERVAL 35 DAY)),
(16, 'INV-033', 8000.00, 'store', DATE_SUB(NOW(), INTERVAL 60 DAY)),
(16, 'INV-034', 6500.00, 'web', DATE_SUB(NOW(), INTERVAL 90 DAY)),
-- Gabriela (LTV 58000, 4 compras)
(17, 'INV-035', 20000.00, 'web', DATE_SUB(NOW(), INTERVAL 10 DAY)),
(17, 'INV-036', 15000.00, 'store', DATE_SUB(NOW(), INTERVAL 30 DAY)),
(17, 'INV-037', 13000.00, 'web', DATE_SUB(NOW(), INTERVAL 60 DAY)),
(17, 'INV-038', 10000.00, 'mobile', DATE_SUB(NOW(), INTERVAL 100 DAY)),
-- Hugo (LTV 13500, 2 compras hace 55 días)
(18, 'INV-039', 7000.00, 'web', DATE_SUB(NOW(), INTERVAL 55 DAY)),
(18, 'INV-040', 6500.00, 'store', DATE_SUB(NOW(), INTERVAL 90 DAY)),
-- Isabel (LTV 2800, 1 compra hace 110 días)
(19, 'INV-041', 2800.00, 'web', DATE_SUB(NOW(), INTERVAL 110 DAY)),
-- Jorge (LTV 34000, 3 compras)
(20, 'INV-042', 15000.00, 'web', DATE_SUB(NOW(), INTERVAL 15 DAY)),
(20, 'INV-043', 10000.00, 'store', DATE_SUB(NOW(), INTERVAL 45 DAY)),
(20, 'INV-044', 9000.00, 'web', DATE_SUB(NOW(), INTERVAL 80 DAY)),
-- Karen (LTV 4200, 2 compras hace 40 días)
(21, 'INV-045', 2200.00, 'web', DATE_SUB(NOW(), INTERVAL 40 DAY)),
(21, 'INV-046', 2000.00, 'mobile', DATE_SUB(NOW(), INTERVAL 75 DAY)),
-- Leonardo (LTV 7500, 2 compras hace 65 días)
(22, 'INV-047', 4000.00, 'web', DATE_SUB(NOW(), INTERVAL 65 DAY)),
(22, 'INV-048', 3500.00, 'store', DATE_SUB(NOW(), INTERVAL 95 DAY)),
-- Mónica (LTV 82000, 5 compras)
(23, 'INV-049', 25000.00, 'web', DATE_SUB(NOW(), INTERVAL 5 DAY)),
(23, 'INV-050', 20000.00, 'store', DATE_SUB(NOW(), INTERVAL 25 DAY)),
(23, 'INV-051', 15000.00, 'web', DATE_SUB(NOW(), INTERVAL 50 DAY)),
(23, 'INV-052', 12000.00, 'mobile', DATE_SUB(NOW(), INTERVAL 80 DAY)),
(23, 'INV-053', 10000.00, 'web', DATE_SUB(NOW(), INTERVAL 110 DAY)),
-- Néstor (LTV 1500, 1 compra hace 130 días)
(24, 'INV-054', 1500.00, 'web', DATE_SUB(NOW(), INTERVAL 130 DAY)),
-- Olga (LTV 22000, 3 compras)
(25, 'INV-055', 10000.00, 'web', DATE_SUB(NOW(), INTERVAL 20 DAY)),
(25, 'INV-056', 8000.00, 'store', DATE_SUB(NOW(), INTERVAL 50 DAY)),
(25, 'INV-057', 4000.00, 'web', DATE_SUB(NOW(), INTERVAL 85 DAY));

-- =====================================================
-- INTERACCIONES (Con fechas y sentimientos variados)
-- =====================================================
INSERT INTO `interactions` (`customer_id`, `type`, `source`, `subject`, `description`, `sentiment`, `occurred_at`) VALUES
(1, 'email', 'crm', 'Consulta de precios', 'Solicita cotización para más usuarios', 'positive', DATE_SUB(NOW(), INTERVAL 12 DAY)),
(2, 'call', 'support', 'Soporte técnico', 'Problema resuelto en 30 min', 'positive', DATE_SUB(NOW(), INTERVAL 8 DAY)),
(3, 'ticket', 'support', 'Error en facturación', 'Se le cobró dos veces', 'negative', DATE_SUB(NOW(), INTERVAL 55 DAY)),
(4, 'email', 'marketing', 'Campaña Q3', 'No abrió el correo', 'neutral', DATE_SUB(NOW(), INTERVAL 100 DAY)),
(5, 'meeting', 'sales', 'Reunión de renovación', 'Interesado en ampliar contrato', 'positive', DATE_SUB(NOW(), INTERVAL 25 DAY)),
(6, 'email', 'crm', 'Seguimiento de propuesta', 'Envío de cotización actualizada', 'neutral', DATE_SUB(NOW(), INTERVAL 10 DAY)),
(7, 'call', 'sales', 'Llamada de upsell', 'Cliente interesado en el plan Enterprise', 'positive', DATE_SUB(NOW(), INTERVAL 2 DAY)),
(8, 'ticket', 'support', 'Pedido incompleto', 'Reclama piezas faltantes en su último pedido', 'negative', DATE_SUB(NOW(), INTERVAL 2 DAY)),
(9, 'meeting', 'sales', 'Renovación anual', 'Firma de contrato por otro año', 'positive', DATE_SUB(NOW(), INTERVAL 1 DAY)),
(10, 'email', 'marketing', 'Campaña de temporada', 'Apertura del correo', 'positive', DATE_SUB(NOW(), INTERVAL 5 DAY)),
(11, 'ticket', 'support', 'Error en facturación', 'Se le cobró dos veces, se dio reembolso', 'negative', DATE_SUB(NOW(), INTERVAL 15 DAY)),
(12, 'chat', 'support', 'Duda técnica', 'Resuelta en 5 minutos', 'positive', DATE_SUB(NOW(), INTERVAL 4 DAY)),
(13, 'call', 'sales', 'Llamada de seguimiento', 'No contestó', 'neutral', DATE_SUB(NOW(), INTERVAL 20 DAY)),
(14, 'ticket', 'support', 'Demora en envío', 'Se disculpó al cliente con un cupón', 'negative', DATE_SUB(NOW(), INTERVAL 8 DAY)),
(15, 'email', 'marketing', 'Newsletter mensual', 'Correo enviado', 'neutral', DATE_SUB(NOW(), INTERVAL 30 DAY)),
(16, 'meeting', 'crm', 'Revisión trimestral', 'Todo en orden', 'positive', DATE_SUB(NOW(), INTERVAL 12 DAY)),
(17, 'call', 'support', 'Atención VIP', 'Llamada de cortesía', 'positive', DATE_SUB(NOW(), INTERVAL 3 DAY)),
(18, 'ticket', 'support', 'Problema con acceso', 'Contraseña restablecida', 'neutral', DATE_SUB(NOW(), INTERVAL 18 DAY)),
(19, 'email', 'sales', 'Propuesta enviada', 'Cliente pidió más tiempo para evaluar', 'neutral', DATE_SUB(NOW(), INTERVAL 25 DAY)),
(20, 'meeting', 'sales', 'Firma de contrato', 'Cliente muy satisfecho', 'positive', DATE_SUB(NOW(), INTERVAL 6 DAY)),
(21, 'call', 'crm', 'Llamada en frío', 'Interesado, pero sin presupuesto', 'neutral', DATE_SUB(NOW(), INTERVAL 22 DAY)),
(22, 'ticket', 'support', 'Solicitud de reembolso', 'Aplicado, cliente molesto', 'negative', DATE_SUB(NOW(), INTERVAL 7 DAY)),
(23, 'email', 'marketing', 'Invitación a evento', 'Cliente confirmó asistencia', 'positive', DATE_SUB(NOW(), INTERVAL 14 DAY)),
(24, 'ticket', 'support', 'Cancelación de cuenta', 'Cliente quiere darse de baja', 'negative', DATE_SUB(NOW(), INTERVAL 3 DAY)),
(25, 'meeting', 'sales', 'Revisión de cuenta', 'Revisión de métricas, todo bien', 'positive', DATE_SUB(NOW(), INTERVAL 9 DAY));

COMMIT;