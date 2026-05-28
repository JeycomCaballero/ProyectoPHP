<?php
require_once 'config.php';

$desde = $_GET['desde'] ?? null;
$hasta = $_GET['hasta'] ?? null;
$tipo  = $_GET['tipo'] ?? 'TODOS';

$endpoint = '/registros?estado=FINALIZADO';
if ($desde && $hasta) {
    $endpoint .= "&desde=$desde&hasta=$hasta&tipo=$tipo";
}

$historial = apiRequest($endpoint);
$error     = isset($historial['error']) ? $historial['error'] : null;

$totalRecaudado = 0;
if (!$error && is_array($historial)) {
    foreach ($historial as $reg) {
        $totalRecaudado += $reg['tarifa'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial - Parqueadero Boyacá</title>
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
            <a href="historial.php" class="nav-link active">📋 Historial</a>
            <a href="vehiculos.php" class="nav-link">🚗 Vehículos</a>
            <a href="reporte.php" class="nav-link">📊 Reporte del Día</a>
        </nav>
    </div>
</header>

<main class="container">
    <h1 class="titulo-pagina">📋 Historial de Registros</h1>

    <?php if ($error): ?>
    <div class="alerta alerta-error">❌ <?= htmlspecialchars($error) ?></div>
    <?php else: ?>

    <div class="tarjetas-grid">
        <div class="tarjeta tarjeta-verde">
            <div class="tarjeta-icono">💰</div>
            <div class="tarjeta-numero">$<?= number_format($totalRecaudado, 0, ',', '.') ?></div>
            <div class="tarjeta-label">Total recaudado (COP)</div>
        </div>
        <div class="tarjeta tarjeta-azul">
            <div class="tarjeta-icono">🚗</div>
            <div class="tarjeta-numero"><?= count($historial) ?></div>
            <div class="tarjeta-label">Servicios prestados</div>
        </div>
    </div>

    <section class="seccion seccion-card">
        <h2>🔍 Búsqueda Avanzada</h2>
        <form method="GET" class="form-inline">
            <div class="campo">
                <label>Desde:</label>
                <input type="date" name="desde" value="<?= htmlspecialchars($desde ?? '') ?>" class="input-texto" required>
            </div>
            <div class="campo">
                <label>Hasta:</label>
                <input type="date" name="hasta" value="<?= htmlspecialchars($hasta ?? '') ?>" class="input-texto" required>
            </div>
            <div class="campo">
                <label>Tipo:</label>
                <select name="tipo" class="input-texto">
                    <option value="TODOS" <?= $tipo == 'TODOS' ? 'selected' : '' ?>>Todos</option>
                    <option value="CARRO" <?= $tipo == 'CARRO' ? 'selected' : '' ?>>🚗 Carro</option>
                    <option value="MOTO" <?= $tipo == 'MOTO' ? 'selected' : '' ?>>🏍️ Moto</option>
                    <option value="CAMION" <?= $tipo == 'CAMION' ? 'selected' : '' ?>>🚛 Camión</option>
                </select>
            </div>
            <button type="submit" class="btn btn-azul" style="margin-top: 15px;">Filtrar Historial</button>
            <a href="historial.php" class="btn btn-rojo" style="margin-top: 15px; margin-left: 10px;">Limpiar</a>
        </form>
    </section>

    <section class="seccion">
        <?php if (count($historial) > 0): ?>
        <div class="tabla-container">
        <table class="tabla">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Placa</th>
                    <th>Tipo</th>
                    <th>Entrada</th>
                    <th>Salida</th>
                    <th>Tarifa (COP)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($historial as $reg): ?>
                <tr>
                    <td><?= htmlspecialchars($reg['id']) ?></td>
                    <td><strong class="placa"><?= htmlspecialchars($reg['placa']) ?></strong></td>
                    <td><span class="badge badge-<?= strtolower($reg['tipo']) ?>"><?= $reg['tipo'] ?></span></td>
                    <td><?= htmlspecialchars($reg['entrada']) ?></td>
                    <td><?= htmlspecialchars($reg['salida'] ?? '—') ?></td>
                    <td class="text-right"><strong>$<?= number_format($reg['tarifa'], 0, ',', '.') ?></strong></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        <?php else: ?>
        <div class="mensaje-vacio">📭 No hay registros finalizados aún.</div>
        <?php endif; ?>
    </section>

    <?php endif; ?>
</main>

<footer class="footer">
    <p>SENA CIMM · ADSO 228118 · Regional Boyacá · <?= date('Y') ?></p>
</footer>

<script src="js/app.js"></script>
</body>
</html>
