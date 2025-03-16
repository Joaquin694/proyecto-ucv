<?php
if (empty($_SESSION["id_autor"])) {
    header("location: ../login.php");
    exit;
}

// Incluir el controlador que carga las investigaciones
include "../controlador/ControladorInvestigaciones.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Investigaciones</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery (para AJAX) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container my-4">
    <h2 class="mb-4">Mis Investigaciones</h2>

    <!-- Barra de búsqueda -->
    <form method="get" class="d-flex mb-3">
        <input type="text" name="q" class="form-control me-2" placeholder="Buscar..." value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
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
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($investigaciones) && is_array($investigaciones)): ?>
                    <?php foreach ($investigaciones as $inv): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($inv['titulo']); ?></td>
                            <td><?php echo htmlspecialchars($inv['nombre_tipo_producto']); ?></td>
                            <td><?php echo htmlspecialchars($inv['estado']); ?></td>
                            <td><?php echo htmlspecialchars($inv['fecha_publicacion'] ?? ""); ?></td>
                            <td><?php echo htmlspecialchars($inv['cuartil'] ?? ""); ?></td>
                            <td><?php echo htmlspecialchars($inv['linea_general'] ?? ""); ?></td>
                            <td><?php echo htmlspecialchars($inv['linea_especifica'] ?? ""); ?></td>
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
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" onclick="editarProducto(<?php echo $inv['id_producto']; ?>)">Editar</button>
                                <button type="button" class="btn btn-sm btn-secondary" onclick="verDocumento(<?php echo $inv['id_producto']; ?>)">Ver</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" class="text-center">No se encontraron investigaciones.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal para Editar Producto -->
<div class="modal fade" id="modalEditarProducto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- El contenido del formulario de edición se cargará vía AJAX -->
        </div>
    </div>
</div>

<!-- Modal para Ver Documento -->
<div class="modal fade" id="modalVerDocumento" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- El visor del documento (ej. un iframe) se cargará vía AJAX -->
        </div>
    </div>
</div>

<script>
// Función para cargar el formulario de edición en el modal (se mantiene igual)
function editarProducto(idProducto) {
    $.ajax({
        url: 'editar_producto.php',
        type: 'GET',
        data: { id: idProducto },
        success: function(response) {
            $('#modalEditarProducto .modal-content').html(response);
            var modal = new bootstrap.Modal(document.getElementById('modalEditarProducto'));
            modal.show();
        },
        error: function() {
            alert('Error al cargar el formulario de edición.');
        }
    });
}

// Función para ver el documento (PDF) en el modal usando ver_pdf.php
function verDocumento(idProducto) {
    $.ajax({
        url: 'ver_pdf.php',
        type: 'GET',
        data: { id: idProducto },
        dataType: 'json',
        success: function(data) {
            if (data.success) {
                // Crear una URL de datos (Data URI) usando el PDF en base64
                var pdfUrl = "data:application/pdf;base64," + data.data;
                var content = '<iframe src="' + pdfUrl + '" style="width:100%; height:600px;" frameborder="0"></iframe>';
                $('#modalVerDocumento .modal-content').html(content);
                var modal = new bootstrap.Modal(document.getElementById('modalVerDocumento'));
                modal.show();
            } else {
                alert(data.message || 'No se pudo cargar el documento.');
            }
        },
        error: function() {
            alert('Error al cargar el documento.');
        }
    });
}
</script>


<!-- Bootstrap JS (Bundle incluye Popper) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
