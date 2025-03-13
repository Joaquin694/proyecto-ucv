<?php
// Archivo controlador/ver_pdf.php
// Incluir conexión a la base de datos para obtener el nombre del archivo
include "../modelo/conexion.php";

// Recuperar el ID del producto
$idProducto = $_GET["id"] ?? 0;

// Ruta base para los archivos PDF
$storage_dir = "../storage/pdfs/";

// Buscar el nombre del archivo PDF en la base de datos
$sqlPdf = "SELECT pdf_nombre FROM producto_investigacion WHERE id_producto = $idProducto LIMIT 1";
$resPdf = $conexion->query($sqlPdf);

if ($resPdf && $resPdf->num_rows > 0) {
    $rowPdf = $resPdf->fetch_assoc();
    $pdf_nombre = $rowPdf["pdf_nombre"];
    
    // Verificar que el archivo exista
    $pdf_ruta = $storage_dir . $pdf_nombre;
    
    if (file_exists($pdf_ruta)) {
        // Leer el archivo como datos binarios
        $pdf_data = file_get_contents($pdf_ruta);
        
        // Convertir a base64
        $pdf_base64 = base64_encode($pdf_data);
        
        // Devolver el PDF como JSON con el contenido base64
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'filename' => $pdf_nombre, 'data' => $pdf_base64]);
        exit;
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'El archivo PDF no se encuentra en el servidor.']);
        exit;
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'No se encontró información del PDF para este producto.']);
    exit;
}
?>