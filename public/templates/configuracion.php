<?php

if (empty($_SESSION["id_autor"])) {
    header("location: ../login.php");
}

?>

<!-- configuracion.php -->

<div class="container my-4">
    <h2 class="mb-4">Configuración de la Cuenta</h2>

    <!-- Mensajes de éxito o error -->
    <?php if (!empty($mensaje)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($mensaje); ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <div class="row">
        <!-- Columna para mostrar datos del usuario (nombre, email) -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Información de Usuario</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($usuarioData)): ?>
                        <p><strong>Nombre de Usuario:</strong> <?php echo htmlspecialchars($usuarioData["nombre_autor"]); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($usuarioData["email"]); ?></p>
                    <?php else: ?>
                        <p>No se pudo obtener la información del usuario.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Columna para cambiar contraseña -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Cambiar Contraseña</h5>
                </div>
                <div class="card-body">
                    <!-- action="" para procesar en el mismo archivo. 
                         Si prefieres un archivo separado (p.e. cambiar_password.php), ajusta el action. -->
                    <form method="post" action="">
                        <div class="mb-3">
                            <label for="password_actual" class="form-label">Contraseña Actual</label>
                            <input type="password" name="password_actual" id="password_actual" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_nuevo" class="form-label">Nueva Contraseña</label>
                            <input type="password" name="password_nuevo" id="password_nuevo" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirm" class="form-label">Confirmar Nueva Contraseña</label>
                            <input type="password" name="password_confirm" id="password_confirm" class="form-control" required>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-key"></i> Actualizar Contraseña
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>