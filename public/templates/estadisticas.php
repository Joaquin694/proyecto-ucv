<?php

include "../controlador/ControladorEstadisticas.php";

// Si deseas, verifica de nuevo la sesión
if (empty($_SESSION["id_autor"])) {
    header("location: ../login.php");
    exit;
}
?>

<div class="container my-4">
    <h2 class="mb-4">Estadísticas</h2>

    <!-- Sección de tarjetas con métricas principales -->
    <div class="row">
        <div class="col-md-3">
            <div class="card text-center mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Investigaciones</h5>
                    <p class="card-text display-6">
                        <?php echo isset($totalInvestigaciones) ? $totalInvestigaciones : 0; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Autores</h5>
                    <p class="card-text display-6">
                        <?php echo isset($totalAutores) ? $totalAutores : 0; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center mb-3">
                <div class="card-body">
                    <h5 class="card-title">Publicados</h5>
                    <p class="card-text display-6">
                        <?php echo isset($publicados) ? $publicados : 0; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center mb-3">
                <div class="card-body">
                    <h5 class="card-title">En Revisión</h5>
                    <p class="card-text display-6">
                        <?php echo isset($enRevision) ? $enRevision : 0; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla: Investigaciones por Línea de Investigación -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Investigaciones por Línea de Investigación</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($estadisticasPorLinea) && is_array($estadisticasPorLinea)): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Línea General</th>
                                <th>Línea Específica</th>
                                <th class="text-end">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($estadisticasPorLinea as $item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['linea_general']); ?></td>
                                    <td><?php echo htmlspecialchars($item['linea_especifica']); ?></td>
                                    <td class="text-end"><?php echo htmlspecialchars($item['cantidad']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>No hay datos de estadísticas por línea de investigación.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Tabla: Investigaciones por Tipo de Producto -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Investigaciones por Tipo de Producto</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($estadisticasPorTipo) && is_array($estadisticasPorTipo)): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Tipo de Producto</th>
                                <th class="text-end">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($estadisticasPorTipo as $tipo): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($tipo['nombre_tipo_producto']); ?></td>
                                    <td class="text-end"><?php echo htmlspecialchars($tipo['cantidad']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>No hay datos de estadísticas por tipo de producto.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
