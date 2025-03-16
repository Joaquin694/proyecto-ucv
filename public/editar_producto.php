<?php
session_start();
if (empty($_SESSION["id_autor"])) {
    header("location: ../login.php");
    exit;
}

include "../modelo/conexion.php";

// Si se envía el formulario (método POST), procesar la actualización
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recuperar y sanitizar los datos
    $idProducto         = intval($_POST["id_producto"]);
    $titulo             = $conexion->real_escape_string(trim($_POST["titulo"]));
    $tipoProducto       = intval($_POST["tipo_producto"]);
    $estado             = intval($_POST["estado"]);
    $fechaPublicacion   = !empty($_POST["fechaPublicacion"]) ? $_POST["fechaPublicacion"] : null;
    $cuartil            = !empty($_POST["cuartil"]) ? intval($_POST["cuartil"]) : null;
    $doiUrl             = $conexion->real_escape_string(trim($_POST["doiUrl"]));
    $principalResultado = $conexion->real_escape_string(trim($_POST["principalResultado"]));

    // Inicializar la parte de actualización del PDF
    $updatePdf = false;
    if (isset($_FILES["pdf_file"]) && $_FILES["pdf_file"]["error"] === UPLOAD_ERR_OK) {
        // Definir ruta de almacenamiento
        $storage_dir = "../storage/pdfs/";
        if (!is_dir($storage_dir)) {
            mkdir($storage_dir, 0777, true);
        }
        $pdf_nombre = uniqid('pdf_') . '.pdf';
        $pdf_ruta = $storage_dir . $pdf_nombre;
        if (move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $pdf_ruta)) {
            $updatePdf = true;
        }
    }

    // Construir la consulta UPDATE
    $sql = "UPDATE producto_investigacion SET 
                titulo_producto = '$titulo',
                id_tipo_producto = $tipoProducto,
                id_estado = $estado,
                fecha_publicacion = " . ($fechaPublicacion ? "'$fechaPublicacion'" : "NULL") . ",
                id_cuartil = " . ($cuartil ? $cuartil : "NULL") . ",
                doi_url = '$doiUrl',
                principal_resultado = '$principalResultado'";
    if ($updatePdf) {
        $sql .= ", pdf_nombre = '$pdf_nombre'";
    }
    $sql .= " WHERE id_producto = $idProducto";

    if ($conexion->query($sql)) {
        echo "<div class='alert alert-success'>Producto actualizado correctamente.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error al actualizar el producto: " . $conexion->error . "</div>";
    }
    exit;
}

// Si es GET, mostrar el formulario de edición precargado
$idProducto = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($idProducto <= 0) {
    echo "<div class='alert alert-danger'>ID de producto inválido.</div>";
    exit;
}

// Consultar los datos del producto
$sql = "SELECT * FROM producto_investigacion WHERE id_producto = $idProducto LIMIT 1";
$res = $conexion->query($sql);
if (!$res || $res->num_rows == 0) {
    echo "<div class='alert alert-danger'>Producto no encontrado.</div>";
    exit;
}
$product = $res->fetch_assoc();
?>
<div class="modal-header">
    <h5 class="modal-title">Editar Producto</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
</div>
<div class="modal-body">
    <!-- El formulario envía los datos a este mismo archivo -->
    <form id="editProductForm" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_producto" value="<?php echo $product['id_producto']; ?>">
        
        <div class="mb-3">
            <label for="titulo" class="form-label">Título del Producto</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($product['titulo_producto']); ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="tipoProducto" class="form-label">Tipo de Producto</label>
            <select class="form-select" id="tipoProducto" name="tipo_producto" required>
                <option value="">Seleccionar...</option>
                <option value="1" <?php if($product['id_tipo_producto']==1) echo 'selected'; ?>>Artículo</option>
                <option value="2" <?php if($product['id_tipo_producto']==2) echo 'selected'; ?>>Libro</option>
                <option value="3" <?php if($product['id_tipo_producto']==3) echo 'selected'; ?>>Software</option>
                <option value="4" <?php if($product['id_tipo_producto']==4) echo 'selected'; ?>>Patente</option>
                <option value="5" <?php if($product['id_tipo_producto']==5) echo 'selected'; ?>>Estudio</option>
            </select>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="estado" class="form-label">Estado</label>
                <select class="form-select" id="estado" name="estado" required>
                    <option value="">Seleccionar...</option>
                    <option value="1" <?php if($product['id_estado']==1) echo 'selected'; ?>>Borrador</option>
                    <option value="2" <?php if($product['id_estado']==2) echo 'selected'; ?>>En Revisión</option>
                    <option value="3" <?php if($product['id_estado']==3) echo 'selected'; ?>>Publicado</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="fechaPublicacion" class="form-label">Fecha de Publicación</label>
                <input type="date" class="form-control" id="fechaPublicacion" name="fechaPublicacion" value="<?php echo $product['fecha_publicacion']; ?>">
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="cuartil" class="form-label">Cuartil</label>
                <select class="form-select" id="cuartil" name="cuartil">
                    <option value="">No aplica</option>
                    <option value="1" <?php if($product['id_cuartil']==1) echo 'selected'; ?>>Q1</option>
                    <option value="2" <?php if($product['id_cuartil']==2) echo 'selected'; ?>>Q2</option>
                    <option value="3" <?php if($product['id_cuartil']==3) echo 'selected'; ?>>Q3</option>
                    <option value="4" <?php if($product['id_cuartil']==4) echo 'selected'; ?>>Q4</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="doiUrl" class="form-label">DOI/URL</label>
                <input type="text" class="form-control" id="doiUrl" name="doiUrl" value="<?php echo htmlspecialchars($product['doi_url']); ?>">
            </div>
        </div>
        
        <div class="mb-3">
            <label for="principalResultado" class="form-label">Resultado Principal</label>
            <textarea class="form-control" id="principalResultado" name="principalResultado" rows="3"><?php echo htmlspecialchars($product['principal_resultado']); ?></textarea>
        </div>
        
        <!-- Campo para actualizar el PDF (opcional) -->
        <div class="mb-3">
            <label for="pdf_file" class="form-label">Actualizar PDF (opcional)</label>
            <input type="file" class="form-control" id="pdf_file" name="pdf_file" accept="application/pdf">
        </div>
        
        <div class="text-end">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
    </form>
</div>
<!-- Bootstrap JS (Bundle incluye Popper) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
