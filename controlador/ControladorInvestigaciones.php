<?php

// 1) Verificar si el usuario está logueado
if (!isset($_SESSION["id_autor"])) {
    // Si no hay sesión, redirige al login
    header("Location: ../login.php");
    exit;
}

// 2) Incluir la conexión
include "../modelo/conexion.php";

// 3) Tomar el id_autor de la sesión
$idAutor = $_SESSION["id_autor"];

/*
    4) Realizar la consulta a producto_investigacion 
       y sus tablas relacionadas:

    - tipo_producto_investigacion (para el nombre del tipo)
    - estado_investigacion (para el nombre del estado)
    - cuartil (para el nombre_cuartil, si existe tu tabla de cuartiles)
    - linea_investigacion (para la línea general)
    - linea_investigacion_especifica (para la línea específica)
    - autor_producto (para filtrar los productos que pertenecen al autor logueado)
*/
$sql = "
    SELECT 
        pi.titulo_producto AS titulo,
        t.nombre_tipo_producto AS nombre_tipo_producto,
        e.nombre_estado AS estado,
        pi.fecha_publicacion,
        c.nombre_cuartil AS cuartil,                -- Ajusta si tu tabla de cuartiles se llama distinto
        lg.nombre_linea_general AS linea_general,   -- Ajusta si tu tabla se llama distinto
        le.nombre_linea_especifica AS linea_especifica,
        pi.doi_url,
        pi.principal_resultado
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
    WHERE ap.id_autor = $idAutor
    ORDER BY pi.fecha_publicacion DESC
";

// 5) Ejecutar la consulta
$res = $conexion->query($sql);

// 6) Guardar resultados en un array para pasarlos a la vista
$investigaciones = [];
if ($res && $res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $investigaciones[] = $row;
    }
}
