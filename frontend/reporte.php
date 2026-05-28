<?php
require_once 'config.php';

$reporte = apiRequest('/registros/reporte');
$error   = isset($reporte['error']) ? $reporte['error'] : null;

$totalRecaudado = isset($reporte['total']) ? $reporte['total'] : 0;
$cantidadSalidas = isset($reporte['cantidad']) ? $reporte['cantidad'] : 0;
$fechaActual = isset($reporte['fecha']) ? $reporte['fecha'] : '--';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ingresos - Parqueadero Boyacá</title>
    <link rel="icon" type="image/svg+xml" href="favicon.svg">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<header class="header">
    <div class="header-content">
        <div class="logo">🅿️ Parqueadero Boyacá</div>
        <nav>
            <a href="index.php" class="nav-link">🏠 Inicio</a>
            <a href="entrada.php" class="nav-link">⬇️ Registrar Entrada</a>
            <a href="historial.php" class="nav-link">📋 Historial</a>
            <a href="vehiculos.php" class="nav-link">🚗 Vehículos</a>
            <a href="reporte.php" class="nav-link active">📊 Reporte del Día</a>
        </nav>
    </div>
</header>

<main class="container">
    <h1 class="titulo-pagina">📊 Reporte de Ingresos del Día</h1>
    <p style="text-align: center; color: #666; margin-bottom: 20px;">Fecha: <strong><?= htmlspecialchars($fechaActual) ?></strong></p>

    <?php if ($error): ?>
        <div class="alerta alerta-error">❌ <?= htmlspecialchars($error) ?></div>
    <?php else: ?>

    <div class="tarjetas-grid">
        <div class="tarjeta tarjeta-verde">
            <div class="tarjeta-icono">💰</div>
            <div class="tarjeta-numero">$<?= number_format($totalRecaudado, 0, ',', '.') ?></div>
            <div class="tarjeta-label">Total recaudado hoy (COP)</div>
        </div>
        <div class="tarjeta tarjeta-azul">
            <div class="tarjeta-icono">🚗</div>
            <div class="tarjeta-numero"><?= htmlspecialchars($cantidadSalidas) ?></div>
            <div class="tarjeta-label">Vehículos despachados hoy</div>
        </div>
    </div>

    <?php endif; ?>
</main>

<footer class="footer">
    <p>SENA CIMM · ADSO 228118 · Regional Boyacá · <?= date('Y') ?></p>
</footer>

<script src="js/app.js"></script>
</body>
</html>