<?php
header('Content-Type: text/plain; charset=utf-8');

echo "============================================\n";
echo "HASHES BCRYPT REALES PARA customer360.sql\n";
echo "============================================\n\n";
echo "Copia estos hashes y pégalos en el SQL.\n\n";

$users = [
    'admin@customer360.com'    => 'admin123',
    'analyst@customer360.com'  => 'analyst123',
    'sales@customer360.com'    => 'sales123',
    'viewer@customer360.com'   => 'viewer123',
];

foreach ($users as $email => $password) {
    $hash = password_hash($password, PASSWORD_BCRYPT);

    echo "-------------------------------------------\n";
    echo "Email:    $email\n";
    echo "Password: $password\n";
    echo "Hash:     $hash\n";
    echo "Verify:   " . (password_verify($password, $hash) ? '✅ OK' : '❌ FALLO') . "\n";
    echo "-------------------------------------------\n\n";
}