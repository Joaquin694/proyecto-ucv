<?php
include "../modelo/conexion.php";

$idProducto = $_GET["id"] ?? 0;

// Buscar el PDF en la base de datos
$sqlPdf = "SELECT pdf_file FROM producto_investigacion WHERE id_producto = $idProducto LIMIT 1";
$resPdf = $conexion->query($sqlPdf);

if ($resPdf && $resPdf->num_rows > 0) {
    $rowPdf = $resPdf->fetch_assoc();
    $pdfData = $rowPdf["pdf_file"];

    // Enviar encabezados para que el navegador muestre el PDF
    header("Content-Type: application/pdf");
    echo $pdfData;
} else {
    echo "No se encontró el PDF para este producto.";
}
