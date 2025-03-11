<?php
// Verifica si el usuario está logueado (del login que ya hiciste)
if (!isset($_SESSION["id_autor"])) {
    // Si no está logueado, lo rediriges al login o donde prefieras
    header("Location: ../login.php");
    exit;
}
// 1) Incluir la conexión a la BD
include "../modelo/conexion.php";

// 2) Construir la consulta
//    - autor_producto (ap) relaciona autores con productos
//    - autores (a) para nombre_autor, email
//    - producto_investigacion (pi) para titulo_producto
$idAutor = $_SESSION["id_autor"];

$sql = "
    SELECT 
        a.nombre_autor, 
        a.email,
        ap.rol_autor,             -- 'Principal' o 'Coautor'
        pi.titulo_producto
    FROM autor_producto ap
    JOIN autores a 
        ON ap.id_autor = a.id_autor
    JOIN producto_investigacion pi
        ON ap.id_producto = pi.id_producto
    
    WHERE ap.id_producto IN (
        SELECT ap2.id_producto
        FROM autor_producto ap2
        WHERE ap2.id_autor = $idAutor
    )
    
    ORDER BY a.nombre_autor
";

// 3) Ejecutar la consulta
$res = $conexion->query($sql);

// 4) Almacenar los resultados en un array
$colaboradores = [];
if ($res && $res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $colaboradores[] = $row;
    }
}
