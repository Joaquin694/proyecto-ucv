<?php
// Verifica si el usuario está logueado (del login que ya hiciste)
if (!isset($_SESSION["id_autor"])) {
    // Si no está logueado, lo rediriges al login o donde prefieras
    header("Location: ../login.php");
    exit;
}

// Incluye la conexión a la base de datos
include "../modelo/conexion.php";

// ID del autor logueado (obtenido del login)
$idAutor = $_SESSION["id_autor"];

/*
  Consulta de ejemplo usando tus tablas (ajusta nombres de columnas):
  - producto_investigacion (alias pi)
  - tipo_producto_investigacion (alias t) para obtener el nombre del tipo
  - estado_investigacion (alias e) para obtener el nombre del estado
  - autor_producto (alias ap) para relacionar producto <-> autores
  - autores (alias a) para obtener los coautores
  Se usa GROUP_CONCAT para mostrar en una sola columna todos los coautores.
*/
$sql = "
    SELECT 
        pi.titulo_producto AS titulo,
        t.nombre_tipo_producto AS tipo,
        e.nombre_estado AS estado,
        pi.fecha_publicacion AS fecha,
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

// Nota: $res contendrá el resultado que usaremos en la vista.
