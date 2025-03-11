<?php
session_start();

// 1) Verificar si el usuario está logueado
if (!isset($_SESSION["id_autor"])) {
    header("Location: ../login.php");
    exit;
}

// 2) Incluir la conexión
include "../modelo/conexion.php";

// 3) Tomar el id_autor de la sesión
$idAutor = $_SESSION["id_autor"];

// Variables para mostrar mensajes
$mensaje = "";
$error = "";

// 4) Consultar datos del usuario
$sqlUser = "SELECT nombre_autor, email, password FROM autores WHERE id_autor = $idAutor LIMIT 1";
$resUser = $conexion->query($sqlUser);

if ($resUser && $resUser->num_rows > 0) {
    $usuarioData = $resUser->fetch_assoc();
} else {
    // No se encontró el usuario (caso raro, o la sesión es inválida)
    $error = "No se encontró el usuario en la base de datos.";
    // Podrías redirigir o manejarlo como gustes
}

// 5) Verificar si se envió el formulario para cambiar contraseña
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["password_actual"], $_POST["password_nuevo"], $_POST["password_confirm"])) {
    $passwordActual  = $_POST["password_actual"];
    $passwordNuevo   = $_POST["password_nuevo"];
    $passwordConfirm = $_POST["password_confirm"];

    // (Ejemplo) Suponiendo que guardas la contraseña en texto plano (no recomendado)
    // Si la guardas hasheada, usarías password_verify($passwordActual, $usuarioData["password"]).
    if ($passwordActual === $usuarioData["password"]) {
        // Verificar si la nueva contraseña y la confirmación coinciden
        if ($passwordNuevo === $passwordConfirm) {
            // Actualizar la contraseña en la base de datos
            // Si deseas hashear, usarías: $nuevoHash = password_hash($passwordNuevo, PASSWORD_BCRYPT);
            $updateSql = "UPDATE autores SET password = '$passwordNuevo' WHERE id_autor = $idAutor";
            if ($conexion->query($updateSql)) {
                $mensaje = "Contraseña actualizada correctamente.";
                // Actualizar también en $usuarioData, para que en la recarga no siga el valor viejo
                $usuarioData["password"] = $passwordNuevo;
            } else {
                $error = "Error al actualizar la contraseña.";
            }
        } else {
            $error = "La nueva contraseña y la confirmación no coinciden.";
        }
    } else {
        $error = "La contraseña actual no es correcta.";
    }
}

