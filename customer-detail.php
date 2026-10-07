<?php

require_once __DIR__ . '/config/auth.php';
requireLogin();

$pageTitle = 'Perfil 360°';
include 'includes/header.php';
$id = (int)($_GET['id'] ?? 0);
?>

<div id="profile-container">
    <div class="text-center py-5">
        <div class="spinner-border text-primary" role="status"></div>
        <p class="mt-2">Cargando perfil...</p>
    </div>
</div>

<script>
const CUSTOMER_ID = <?= $id ?>;
</script>
<script src="/customer360/assets/js/customer-detail.js"></script>
<?php include 'includes/footer.php'; ?>