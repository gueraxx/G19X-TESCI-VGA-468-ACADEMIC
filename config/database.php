<?php
/**
 * Configuración de conexión a la base de datos
 * Customer 360 — PluriOne
 * Puerto MySQL: 3308
 */

$config = [
    'host' => '127.0.0.1',
    'port' => 3308,               // ✅ TU PUERTO REAL
    'name' => 'customer360',
    'user' => 'root',
    'pass' => ''
];

// Si existe configuración local, la sobreescribe
if (file_exists(__DIR__ . '/database.local.php')) {
    $local = require __DIR__ . '/database.local.php';
    $config = array_merge($config, $local);
}

define('DB_HOST', $config['host']);
define('DB_PORT', $config['port']);
define('DB_NAME', $config['name']);
define('DB_USER', $config['user']);
define('DB_PASS', $config['pass']);

/**
 * Devuelve una conexión PDO a la base de datos
 */
function getDB() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";

        return new PDO(
            $dsn,
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
    } catch (PDOException $e) {
        die(json_encode(['error' => 'Error de conexión: ' . $e->getMessage()]));
    }
}

/**
 * Devuelve una respuesta JSON y termina la ejecución
 */
function jsonResponse($data, $code = 200) {
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}