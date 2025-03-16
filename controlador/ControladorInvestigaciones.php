<?php
// 1) Verificar si el usuario está logueado
if (!isset($_SESSION["id_autor"])) {
    header("Location: ../login.php");
    exit;
}

// 2) Incluir la conexión
include "../modelo/conexion.php";

// 3) Tomar el id_autor de la sesión
$idAutor = $_SESSION["id_autor"];

// 4) Capturar el término de búsqueda (si existe)
$q = isset($_GET['q']) ? trim($_GET['q']) : '';

// 5) Construir la cláusula WHERE inicial
$where = " WHERE ap.id_autor = $idAutor ";

// Si se ingresó un término de búsqueda, agregar condiciones adicionales
if (!empty($q)) {
    $qEscaped = $conexion->real_escape_string($q);
    $where .= " AND (
                    pi.titulo_producto LIKE '%$qEscaped%' OR 
                    t.nombre_tipo_producto LIKE '%$qEscaped%' OR 
                    e.nombre_estado LIKE '%$qEscaped%' OR 
                    c.nombre_cuartil LIKE '%$qEscaped%' OR 
                    lg.nombre_linea_general LIKE '%$qEscaped%' OR 
                    le.nombre_linea_especifica LIKE '%$qEscaped%' OR 
                    pi.doi_url LIKE '%$qEscaped%' OR 
                    pi.principal_resultado LIKE '%$qEscaped%'
                ) ";
}

// 6) Construir la consulta SQL completa (incluye id_producto y pdf_nombre)
$sql = "
    SELECT 
        pi.id_producto AS id_producto,
        pi.titulo_producto AS titulo,
        t.nombre_tipo_producto AS nombre_tipo_producto,
        e.nombre_estado AS estado,
        pi.fecha_publicacion,
        c.nombre_cuartil AS cuartil,
        lg.nombre_linea_general AS linea_general,
        le.nombre_linea_especifica AS linea_especifica,
        pi.doi_url,
        pi.principal_resultado,
        pi.pdf_nombre
    FROM producto_investigacion pi
    JOIN tipo_producto_investigacion t 
        ON pi.id_tipo_producto = t.id_tipo_producto
    JOIN estado_investigacion e 
        ON pi.id_estado = e.id_estado
    LEFT JOIN cuartil_investigacion c 
        ON pi.id_cuartil = c.id_cuartil
    LEFT JOIN linea_investigacion_general lg
        ON pi.id_linea_general = lg.id_linea_general
    LEFT JOIN linea_investigacion_especifica le
        ON pi.id_linea_especifica = le.id_linea_especifica
    JOIN autor_producto ap 
        ON pi.id_producto = ap.id_producto
" . $where . "
    ORDER BY pi.fecha_publicacion DESC
";

// 7) Ejecutar la consulta
$res = $conexion->query($sql);

// 8) Guardar resultados en un array para pasarlos a la vista
$investigaciones = [];
if ($res && $res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $investigaciones[] = $row;
    }
}
?>
