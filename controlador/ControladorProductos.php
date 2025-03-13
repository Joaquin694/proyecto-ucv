<?php

// Verifica si el usuario está logueado (del login que ya hiciste)
if (!isset($_SESSION["id_autor"])) {
    header("Location: ../login.php");
    exit;
}

// Incluye la conexión a la base de datos
include "../modelo/conexion.php";

// Definir la carpeta de almacenamiento para PDFs
$storage_dir = "../storage/pdfs/";

// Crear la carpeta si no existe
if (!is_dir($storage_dir)) {
    mkdir($storage_dir, 0777, true);
}

// ID del autor logueado (obtenido del login)
$idAutor = $_SESSION["id_autor"];

// BLOQUE: Procesar creación de producto con PDF en carpeta local
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "create_product") {
    // Recoger datos del formulario
    $titulo             = $_POST["titulo"]             ?? "";
    $tipoProducto       = $_POST["tipo_producto"]       ?? "";
    $estado             = $_POST["estado"]             ?? "";
    $cuartil            = $_POST["cuartil"]            ?? "";
    $fechaPublicacion   = $_POST["fechaPublicacion"]    ?? "";
    $lineaGeneral       = $_POST["linea_general"]       ?? "";
    $lineaEspecifica    = $_POST["linea_especifica"]    ?? "";
    $doiUrl             = $_POST["doiUrl"]             ?? "";
    $principalResultado = $_POST["principalResultado"]  ?? "";

    // Verificar que se haya subido un PDF (obligatorio)
    if (!isset($_FILES["pdf_file"]) || $_FILES["pdf_file"]["error"] !== UPLOAD_ERR_OK) {
        // Podrías manejarlo mostrando un error, redirigiendo, etc.
        $error_msg = "Debes subir un archivo PDF.";
    } else {
        // Generar un nombre único para el archivo
        $pdf_nombre = uniqid('pdf_') . '.pdf';
        $pdf_ruta = $storage_dir . $pdf_nombre;

        // Mover el archivo subido a la carpeta de almacenamiento
        if (move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $pdf_ruta)) {
            // Construir la sentencia INSERT con el nombre del archivo (no el contenido)
            $sqlInsert = "
                INSERT INTO producto_investigacion (
                    id_tipo_producto, titulo_producto, id_estado, id_cuartil,
                    doi_url, fecha_publicacion, id_linea_general, id_linea_especifica,
                    principal_resultado, pdf_nombre
                ) VALUES (
                    '$tipoProducto', '$titulo', '$estado', " . ($cuartil !== "" ? "'$cuartil'" : "NULL") . ",
                    '$doiUrl', " . ($fechaPublicacion !== "" ? "'$fechaPublicacion'" : "NULL") . ",
                    " . ($lineaGeneral !== "" ? "'$lineaGeneral'" : "NULL") . ", " . ($lineaEspecifica !== "" ? "'$lineaEspecifica'" : "NULL") . ",
                    '$principalResultado', '$pdf_nombre'
                )
            ";

            if ($conexion->query($sqlInsert)) {
                // Toma el ID del nuevo producto
                $idProducto = $conexion->insert_id;

                // Registrar la relación con el autor principal en la tabla autor_producto
                // (Asumiendo que el autor logueado es 'Principal')
                $sqlAutorProd = "
                    INSERT INTO autor_producto (id_autor, id_producto, rol_autor)
                    VALUES ($idAutor, $idProducto, 'Principal')
                ";
                $conexion->query($sqlAutorProd);

                // Establece un mensaje de éxito en lugar de redirigir
                $success_msg = "Producto creado correctamente.";
            } else {
                // Manejar el error
                $error_msg = "Error al crear el producto: " . $conexion->error;
            }
        } else {
            $error_msg = "Error al guardar el archivo PDF.";
        }
    }
}
// FIN DEL BLOQUE DE CREACIÓN

// BLOQUE: Listar los productos del autor
$sql = "
    SELECT 
        pi.id_producto AS id_producto,
        pi.titulo_producto AS titulo,
        t.nombre_tipo_producto AS tipo,
        e.nombre_estado AS estado,
        pi.fecha_publicacion AS fecha,
        pi.pdf_nombre AS pdf_nombre,
        GROUP_CONCAT(DISTINCT a.nombre_autor SEPARATOR ', ') AS coautores
    FROM producto_investigacion pi
    JOIN tipo_producto_investigacion t 
        ON pi.id_tipo_producto = t.id_tipo_producto
    JOIN estado_investigacion e 
        ON pi.id_estado = e.id_estado
    JOIN autor_producto ap 
        ON pi.id_producto = ap.id_producto
    JOIN autores a 
        ON ap.id_autor = a.id_autor
    WHERE ap.id_autor = $idAutor
    GROUP BY pi.id_producto
    ORDER BY pi.fecha_publicacion DESC
";

$res = $conexion->query($sql);

// $res contendrá el resultado para la vista
?>