<?php
session_start();
if (!empty($_POST["btningresar"])) {
    if (!empty($_POST["gmail"]) && !empty($_POST["password"])) {
        $gmail = $_POST["gmail"];
        $password = $_POST["password"];
        $sql=$conexion->query(" select * from autores where email='$gmail' and password='$password'");
        if ($datos = $sql->fetch_object()) {
            $_SESSION["id_autor"]=$datos->id_autor;
            $_SESSION["username"]=$datos->nombre_autor;
            header("location: ../public/inicio.php");
            exit;
        } else {
            echo "Acceso Denegado";
            
        }
        
    } else{
        echo "Campos Vacios";
    }
}

?>