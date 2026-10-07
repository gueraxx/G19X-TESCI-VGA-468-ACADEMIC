-- =====================================================
-- Base de datos: Customer 360
-- Proyecto: Plataforma Inteligente Customer 360
-- =====================================================

CREATE DATABASE IF NOT EXISTS customer360
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE customer360;

-- -----------------------------------------------------
-- Tabla: customers
-- -----------------------------------------------------
DROP TABLE IF EXISTS interactions;
DROP TABLE IF EXISTS transactions;
DROP TABLE IF EXISTS customers;

CREATE TABLE customers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  external_id VARCHAR(50) UNIQUE,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  email VARCHAR(150) UNIQUE NOT NULL,
  phone VARCHAR(30),
  company VARCHAR(150),
  industry VARCHAR(100),
  country VARCHAR(80),
  city VARCHAR(80),
  segment ENUM('bronze','silver','gold','platinum') DEFAULT 'bronze',
  lifetime_value DECIMAL(12,2) DEFAULT 0,
  churn_risk FLOAT DEFAULT 0,
  status ENUM('active','inactive','blocked') DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_email (email),
  INDEX idx_segment (segment),
  INDEX idx_churn (churn_risk)
);

-- -----------------------------------------------------
-- Tabla: transactions
-- -----------------------------------------------------
CREATE TABLE transactions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  customer_id INT NOT NULL,
  external_id VARCHAR(50) UNIQUE,
  amount DECIMAL(12,2) NOT NULL,
  currency VARCHAR(3) DEFAULT 'USD',
  channel ENUM('web','mobile','store','phone','partner') DEFAULT 'web',
  status ENUM('pending','completed','refunded','cancelled') DEFAULT 'completed',
  transaction_date DATETIME NOT NULL,
  FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
  INDEX idx_customer (customer_id),
  INDEX idx_date (transaction_date)
);

-- -----------------------------------------------------
-- Tabla: interactions
-- -----------------------------------------------------
CREATE TABLE interactions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  customer_id INT NOT NULL,
  type ENUM('call','email','chat','ticket','meeting','campaign') NOT NULL,
  source ENUM('crm','erp','sales','marketing','support') NOT NULL,
  subject VARCHAR(200),
  description TEXT,
  sentiment ENUM('positive','neutral','negative') DEFAULT 'neutral',
  occurred_at DATETIME NOT NULL,
  FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
  INDEX idx_customer (customer_id),
  INDEX idx_type (type)
);

-- -----------------------------------------------------
-- Datos de prueba: customers
-- -----------------------------------------------------
INSERT INTO customers (external_id, first_name, last_name, email, phone, company, industry, country, city, segment, lifetime_value, churn_risk, status) VALUES
('CRM-001', 'Juan', 'Pérez', 'juan.perez@acme.com', '+52 555 111 2233', 'ACME Corp', 'Tecnología', 'México', 'CDMX', 'gold', 25000.00, 0.15, 'active'),
('CRM-002', 'María', 'García', 'maria.garcia@globex.com', '+52 555 444 5566', 'Globex', 'Manufactura', 'México', 'Monterrey', 'platinum', 62000.00, 0.05, 'active'),
('CRM-003', 'Carlos', 'López', 'carlos.lopez@initech.com', '+52 555 777 8899', 'Initech', 'Finanzas', 'México', 'Guadalajara', 'silver', 12000.00, 0.45, 'active'),
('CRM-004', 'Ana', 'Martínez', 'ana.martinez@umbrella.com', '+52 555 222 3344', 'Umbrella', 'Salud', 'México', 'CDMX', 'bronze', 3200.00, 0.75, 'active'),
('CRM-005', 'Luis', 'Rodríguez', 'luis.rodriguez@stark.com', '+52 555 888 9900', 'Stark Industries', 'Tecnología', 'México', 'Querétaro', 'gold', 31000.00, 0.20, 'active');

-- -----------------------------------------------------
-- Datos de prueba: transactions
-- -----------------------------------------------------
INSERT INTO transactions (customer_id, external_id, amount, currency, channel, status, transaction_date) VALUES
(1, 'INV-001', 5000.00, 'USD', 'web', 'completed', '2025-08-15 10:30:00'),
(1, 'INV-002', 3500.00, 'USD', 'web', 'completed', '2025-09-02 14:20:00'),
(2, 'INV-003', 15000.00, 'USD', 'store', 'completed', '2025-07-20 09:00:00'),
(2, 'INV-004', 22000.00, 'USD', 'web', 'completed', '2025-09-10 16:45:00'),
(3, 'INV-005', 4200.00, 'USD', 'mobile', 'completed', '2025-06-05 11:15:00'),
(4, 'INV-006', 800.00, 'USD', 'web', 'completed', '2025-03-10 13:30:00'),
(5, 'INV-007', 9800.00, 'USD', 'web', 'completed', '2025-08-28 15:00:00');

-- -----------------------------------------------------
-- Datos de prueba: interactions
-- -----------------------------------------------------
INSERT INTO interactions (customer_id, type, source, subject, description, sentiment, occurred_at) VALUES
(1, 'email', 'crm', 'Consulta sobre producto', 'Cliente pregunta por nuevas funcionalidades', 'positive', '2025-09-01 10:00:00'),
(2, 'call', 'support', 'Soporte técnico', 'Problema resuelto en 30 min', 'positive', '2025-09-05 14:30:00'),
(3, 'ticket', 'support', 'Error en facturación', 'Ticket escalado a nivel 2', 'negative', '2025-09-08 09:15:00'),
(4, 'email', 'marketing', 'Campaña Q3', 'Cliente no abrió el email', 'neutral', '2025-08-20 08:00:00'),
(5, 'meeting', 'sales', 'Reunión de renovación', 'Interesado en ampliar contrato', 'positive', '2025-09-12 11:00:00');