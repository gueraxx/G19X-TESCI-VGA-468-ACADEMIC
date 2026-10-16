<?php
require_once __DIR__ . '/config/database.php';

header('Content-Type: text/plain; charset=utf-8');

try {
    $db = getDB();

    $users = [
        'admin@customer360.com'    => 'admin123',
        'analyst@customer360.com'  => 'analyst123',
        'sales@customer360.com'    => 'sales123',
        'viewer@customer360.com'   => 'viewer123',
    ];

    echo "-- Ejecuta esto en phpMyAdmin:\n\n";

    foreach ($users as $email => $password) {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        echo "UPDATE users SET password_hash = '$hash' WHERE email = '$email';\n";
    }

    echo "\n-- Verificación:\n";
    foreach ($users as $email => $password) {
        $stmt = $db->prepare("SELECT password_hash FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch();
        $ok = $row && password_verify($password, $row['password_hash']);
        echo "-- $email: " . ($ok ? '✅' : '❌') . "\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}