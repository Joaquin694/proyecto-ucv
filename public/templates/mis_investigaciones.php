<?php

include "../controlador/ControladorInvestigaciones.php";

if (empty($_SESSION["id_autor"])) {
    header("location: ../login.php");
}

?>

<!-- mis_investigaciones.php -->

<div class="container my-4">
    <h2 class="mb-4">Mis Investigaciones</h2>

    <!-- Barra de búsqueda -->
    <form method="get" class="d-flex mb-3">
        <input type="text" name="q" class="form-control me-2" placeholder="Buscar...">
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Título</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Fecha Publicación</th>
                    <th>Cuartil</th>
                    <th>Línea General</th>
                    <th>Línea Específica</th>
                    <th>DOI/URL</th>
                    <th>Resultado Principal</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($investigaciones) && is_array($investigaciones)): ?>
                    <?php foreach ($investigaciones as $inv): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($inv['titulo']); ?></td>
                            <td><?php echo htmlspecialchars($inv['nombre_tipo_producto']); ?></td>
                            <td><?php echo htmlspecialchars($inv['estado']); ?></td>
                            <td><?php echo htmlspecialchars($inv['fecha_publicacion']); ?></td>
                            <td><?php echo htmlspecialchars($inv['cuartil']); ?></td>
                            <td><?php echo htmlspecialchars($inv['linea_general']); ?></td>
                            <td><?php echo htmlspecialchars($inv['linea_especifica']); ?></td>
                            <td>
                                <?php if (!empty($inv['doi_url'])): ?>
                                    <a href="<?php echo htmlspecialchars($inv['doi_url']); ?>" target="_blank">
                                        <?php echo htmlspecialchars($inv['doi_url']); ?>
                                    </a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($inv['principal_resultado']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">No se encontraron investigaciones.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>