<?php

session_start();
if (empty($_SESSION["id_autor"])) {
    header("location: login.php");
}





$section = "dashboard"; // Valor por defecto

if (isset($_POST['section'])) {
    $section = $_POST['section'];
}

// Al inicio del archivo, antes de cualquier HTML
include "../controlador/ControladorProductos.php";

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Investigación</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">

</head>

<body>
    <!-- Sidebar Toggle Button (Visible on Mobile) -->
    <button class="btn btn-primary sidebar-toggle" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>


    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h4>Portal de Investigación</h4>
            <p class="text-light">Dr. Juan Pérez | Investigador</p>
        </div>
        <!-- Formulario para navegación -->
        <form method="post" id="navForm">
            <ul class="nav flex-column sidebar-menu">
                <li class="nav-item">
                    <button type="submit" name="section" value="dashboard" class="nav-link <?php echo ($section == 'dashboard') ? 'active' : ''; ?>">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </button>
                </li>
                <li class="nav-item">
                    <button type="submit" name="section" value="mis_investigaciones" class="nav-link <?php echo ($section == 'mis_investigaciones') ? 'active' : ''; ?>">
                        <i class="fas fa-file-alt"></i> Mis Investigaciones
                    </button>
                </li>
                <li class="nav-item">
                    <button type="submit" name="section" value="colaboradores" class="nav-link <?php echo ($section == 'colaboradores') ? 'active' : ''; ?>">
                        <i class="fas fa-users"></i> Colaboradores
                    </button>
                </li>
                <li class="nav-item">
                    <button type="submit" name="section" value="estadisticas" class="nav-link <?php echo ($section == 'estadisticas') ? 'active' : ''; ?>">
                        <i class="fas fa-chart-line"></i> Estadísticas
                    </button>
                </li>
                <li class="nav-item">
                    <button type="submit" name="section" value="configuracion" class="nav-link <?php echo ($section == 'configuracion') ? 'active' : ''; ?>">
                        <i class="fas fa-cog"></i> Configuración
                    </button>
                </li>
                <li class="nav-item mt-5">
                    <a href="logout.php" class="nav-link text-danger">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </a>
                </li>
            </ul>
        </form>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="content">
        <?php
        // Incluye el archivo correspondiente según el valor de $section
        switch ($section) {
            case 'dashboard':
                include("templates/dashboard.php");
                break;
            case 'mis_investigaciones':
                include("templates/mis_investigaciones.php");
                break;
            case 'colaboradores':
                include("templates/colaboradores.php");
                break;
            case 'estadisticas':
                include("templates/estadisticas.php");
                break;
            case 'configuracion':
                include("templates/configuracion.php");
                break;
            default:
                echo "<p>Sección no encontrada.</p>";
        }
        ?>
    </div>

    <!-- Add/Edit Product Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Agregar Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario con enctype para subir archivos -->
                    <form id="productForm" method="post" enctype="multipart/form-data">
                        <!-- Campo oculto para indicar la acción en el controlador -->
                        <input type="hidden" name="action" value="create_product">

                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título del Producto</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tipoProducto" class="form-label">Tipo de Producto</label>
                                <select class="form-select" id="tipoProducto" name="tipo_producto" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="1">Artículo</option>
                                    <option value="2">Libro</option>
                                    <option value="3">Software</option>
                                    <option value="4">Patente</option>
                                    <option value="5">Estudio</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="1">Borrador</option>
                                    <option value="2">En Revisión</option>
                                    <option value="3">Publicado</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="cuartil" class="form-label">Cuartil</label>
                                <select class="form-select" id="cuartil" name="cuartil">
                                    <option value="">No aplica</option>
                                    <option value="1">Q1</option>
                                    <option value="2">Q2</option>
                                    <option value="3">Q3</option>
                                    <option value="4">Q4</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="fechaPublicacion" class="form-label">Fecha de Publicación</label>
                                <input type="date" class="form-control" id="fechaPublicacion" name="fechaPublicacion">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="lineaGeneral" class="form-label">Línea de Investigación General</label>
                                <select class="form-select" id="lineaGeneral" name="linea_general" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="1">Ingeniería de Software</option>
                                    <option value="2">Ciencias de la Salud</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="lineaEspecifica" class="form-label">Línea de Investigación Específica</label>
                                <select class="form-select" id="lineaEspecifica" name="linea_especifica" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="1">Machine Learning</option>
                                    <option value="2">Biotecnología Vegetal</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="doiUrl" class="form-label">DOI/URL</label>
                            <input type="text" class="form-control" id="doiUrl" name="doiUrl">
                        </div>

                        <div class="mb-3">
                            <label for="principalResultado" class="form-label">Resultado Principal</label>
                            <textarea class="form-control" id="principalResultado" name="principalResultado" rows="3"></textarea>
                        </div>

                        <!-- Campo obligatorio para el PDF -->
                        <div class="mb-3">
                            <label for="pdf_file" class="form-label">Archivo PDF (Obligatorio)</label>
                            <input type="file" class="form-control" id="pdf_file" name="pdf_file" accept="application/pdf" required>
                        </div>

                        <!-- Coauthors Section (visual) -->
                        <div class="mb-3">
                            <label class="form-label">Coautores</label>
                            <select class="form-select" id="coautores" name="list_coautores[]" multiple required>
                                <!-- Valor vacío para forzar la selección -->
                                <option value="">Seleccionar...</option>
                                <?php
                                // Suponiendo que ya se incluyó la conexión ($conexion) y se tiene $idAutor (usuario logueado)
                                $sqlCoautores = "SELECT id_autor, nombre_autor FROM autores WHERE id_autor <> $idAutor";
                                $resultCoautores = $conexion->query($sqlCoautores);
                                if ($resultCoautores && $resultCoautores->num_rows > 0) {
                                    while ($row = $resultCoautores->fetch_assoc()) {
                                        echo '<option value="' . $row['id_autor'] . '">' . htmlspecialchars($row['nombre_autor']) . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <!-- Botón que envía el formulario -->
                    <button type="submit" form="productForm" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- PDF Modal -->
    <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Ver PDF</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Contenedor para el PDF -->
                    <div id="pdfContainer" style="width:100%; height:600px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tus scripts de JavaScript -->
    <script>
        // Función para mostrar el PDF en el modal usando base64
        function viewProductPdf(productId) {
            // Mostrar el modal primero
            var pdfModal = new bootstrap.Modal(document.getElementById('pdfModal'));
            pdfModal.show();

            // Mostrar indicador de carga
            document.getElementById('pdfContainer').innerHTML = '<div class="text-center"><p>Cargando PDF...</p></div>';

            // Hacer la petición AJAX para obtener el PDF
            fetch('ver_pdf.php?id=' + productId)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Crear un objeto Blob con los datos del PDF
                        const byteCharacters = atob(data.data);
                        const byteArrays = [];

                        for (let offset = 0; offset < byteCharacters.length; offset += 512) {
                            const slice = byteCharacters.slice(offset, offset + 512);

                            const byteNumbers = new Array(slice.length);
                            for (let i = 0; i < slice.length; i++) {
                                byteNumbers[i] = slice.charCodeAt(i);
                            }

                            const byteArray = new Uint8Array(byteNumbers);
                            byteArrays.push(byteArray);
                        }

                        const blob = new Blob(byteArrays, {
                            type: 'application/pdf'
                        });
                        const blobUrl = URL.createObjectURL(blob);

                        // Crear el iframe dinámicamente
                        document.getElementById('pdfContainer').innerHTML = `
          <iframe src="${blobUrl}" style="width:100%; height:600px;" frameborder="0"></iframe>
        `;
                    } else {
                        // Mostrar mensaje de error
                        document.getElementById('pdfContainer').innerHTML = `
          <div class="alert alert-danger">
            ${data.message || 'Error al cargar el PDF'}
          </div>
        `;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('pdfContainer').innerHTML = `
        <div class="alert alert-danger">
          Error de conexión. No se pudo cargar el PDF.
        </div>
      `;
                });
        }

        // Añadir botón para agregar producto
        document.addEventListener('DOMContentLoaded', function() {
            // Botón para mostrar el modal de agregar producto
            document.getElementById('addProductBtn').addEventListener('click', function() {
                var productModal = new bootstrap.Modal(document.getElementById('productModal'));
                productModal.show();
            });
        });
    </script>


    <!-- JavaScript Dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>

</body>

</html>