<?php
// Verifica si el usuario está logueado (opcional, si deseas restringir la vista)
if (!isset($_SESSION["id_autor"])) {
    header("Location: ../login.php");
    exit;
}

// 1) Incluir la conexión a la BD
include "../modelo/conexion.php";

// 2) Calcular total de investigaciones
$sqlTotalInv = "SELECT COUNT(*) AS total FROM producto_investigacion";
$resTotalInv = $conexion->query($sqlTotalInv);
$rowTotalInv = $resTotalInv->fetch_assoc();
$totalInvestigaciones = $rowTotalInv['total'];

// 3) Calcular total de autores
$sqlTotalAut = "SELECT COUNT(*) AS total FROM autores";
$resTotalAut = $conexion->query($sqlTotalAut);
$rowTotalAut = $resTotalAut->fetch_assoc();
$totalAutores = $rowTotalAut['total'];

// 4) Calcular cuántos están 'Publicados'
$sqlPublicados = "
    SELECT COUNT(*) AS total
    FROM producto_investigacion pi
    JOIN estado_investigacion e ON pi.id_estado = e.id_estado
    WHERE e.nombre_estado = 'Publicado'
";
$resPublicados = $conexion->query($sqlPublicados);
$rowPublicados = $resPublicados->fetch_assoc();
$publicados = $rowPublicados['total'];

// 5) Calcular cuántos están 'En Revisión'
$sqlEnRevision = "
    SELECT COUNT(*) AS total
    FROM producto_investigacion pi
    JOIN estado_investigacion e ON pi.id_estado = e.id_estado
    WHERE e.nombre_estado = 'En Revisión'
";
$resEnRevision = $conexion->query($sqlEnRevision);
$rowEnRevision = $resEnRevision->fetch_assoc();
$enRevision = $rowEnRevision['total'];

// 6) Estadísticas por línea de investigación
//    Agrupamos por línea general y específica para contar cuántos productos hay en cada categoría
$sqlLinea = "
    SELECT 
        COALESCE(lg.nombre_linea_general, 'Sin Línea') AS linea_general,
        COALESCE(le.nombre_linea_especifica, 'Sin Línea') AS linea_especifica,
        COUNT(*) AS cantidad
    FROM producto_investigacion pi
    LEFT JOIN linea_investigacion_general lg ON pi.id_linea_general = lg.id_linea_general
    LEFT JOIN linea_investigacion_especifica le ON pi.id_linea_especifica = le.id_linea_especifica
    GROUP BY lg.nombre_linea_general, le.nombre_linea_especifica
    ORDER BY cantidad DESC
";
$resLinea = $conexion->query($sqlLinea);

$estadisticasPorLinea = [];
if ($resLinea && $resLinea->num_rows > 0) {
    while ($row = $resLinea->fetch_assoc()) {
        $estadisticasPorLinea[] = $row;
    }
}

// 7) Estadísticas por tipo de producto
$sqlTipo = "
    SELECT 
        t.nombre_tipo_producto,
        COUNT(*) AS cantidad
    FROM producto_investigacion pi
    JOIN tipo_producto_investigacion t ON pi.id_tipo_producto = t.id_tipo_producto
    GROUP BY t.nombre_tipo_producto
    ORDER BY cantidad DESC
";
$resTipo = $conexion->query($sqlTipo);

$estadisticasPorTipo = [];
if ($resTipo && $resTipo->num_rows > 0) {
    while ($row = $resTipo->fetch_assoc()) {
        $estadisticasPorTipo[] = $row;
    }
}

