<?php
/**
 * Configuración de conexión a la base de datos
 * Customer 360 — PluriOne
 *
 * Lee primero de .env (si existe), si no, usa valores por defecto.
 */

// ============================================================
// Mini-lector de .env (sin dependencias)
// ============================================================
function loadEnv($path) {
    if (!file_exists($path)) return;
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) continue;
        if (!str_contains($line, '=')) continue;

        [$key, $value] = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value, " \t\n\r\0\x0B\"'");

        if (!isset($_ENV[$key])) {
            $_ENV[$key] = $value;
            putenv("$key=$value");
        }
    }
}

loadEnv(__DIR__ . '/../.env');

// Helper para leer variables con default
function env($key, $default = null) {
    $value = $_ENV[$key] ?? getenv($key);
    return ($value === false || $value === '') ? $default : $value;
}

// ============================================================
// Configuración
// ============================================================
$config = [
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => (int) env('DB_PORT', 3306),
    'name' => env('DB_NAME', 'customer360'),
    'user' => env('DB_USER', 'root'),
    'pass' => env('DB_PASSWORD', '')
];

// Override con database.local.php si existe (compatibilidad)
if (file_exists(__DIR__ . '/database.local.php')) {
    $local = require __DIR__ . '/database.local.php';
    $config = array_merge($config, $local);
}

define('DB_HOST', $config['host']);
define('DB_PORT', $config['port']);
define('DB_NAME', $config['name']);
define('DB_USER', $config['user']);
define('DB_PASS', $config['pass']);

function getDB() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        return new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);
    } catch (PDOException $e) {
        die(json_encode(['error' => 'Error de conexión: ' . $e->getMessage()]));
    }
}

function jsonResponse($data, $code = 200) {
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}