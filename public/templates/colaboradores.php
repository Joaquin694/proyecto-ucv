<?php

include "../controlador/ControladorColaboradores.php";

if (empty($_SESSION["id_autor"])) {
    header("location: ../login.php");
}

?>

<!-- colaboradores.php -->

<div class="container my-4">
    <h2 class="mb-4">Colaboradores</h2>

    <!-- Barra de búsqueda y botón para agregar nuevo colaborador -->
    <div class="row mb-3">
        <div class="col-md-8">
            <form method="get" class="d-flex">
                <input type="text" name="q" class="form-control me-2" placeholder="Buscar colaborador...">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>
        </div>
        <div class="col-md-4 text-end">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalNuevoColaborador">
                <i class="fas fa-plus"></i> Nuevo Colaborador
            </button>
        </div>
    </div>

    <!-- Tabla de colaboradores -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Nombre de Producto</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($colaboradores) && is_array($colaboradores)): ?>
                <?php foreach ($colaboradores as $col): ?>
                    <tr>
                        <!-- Ajusta los índices de $col según tu base de datos -->
                         
                        <td><?php echo htmlspecialchars($col['nombre_autor']); ?></td>
                        <td><?php echo htmlspecialchars($col['email']); ?></td>
                        <td><?php echo htmlspecialchars($col['rol_autor']); ?></td>
                        <td><?php echo htmlspecialchars($col['titulo_producto']); ?></td> <!-- Se puede obtener el nombre del producto sabiendo el ID del en el cual es parte cada colaborador -->
                        
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">No se encontraron colaboradores.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal para agregar nuevo colaborador -->
<div class="modal fade" id="modalNuevoColaborador" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Nuevo Colaborador</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <!-- Formulario para crear colaborador (ajusta la acción y los campos según tu lógica) -->
                <form method="post" action="procesar_colaborador.php">
                    <div class="mb-3">
                        <label for="nombre_autor" class="form-label">Nombre</label>
                        <input type="text" name="nombre_autor" id="nombre_autor" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email_autor" class="form-label">Email</label>
                        <input type="email" name="email_autor" id="email_autor" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="rol_autor" class="form-label">Rol</label>
                        <select name="rol_autor" id="rol_autor" class="form-select" required>
                            <option value="">Seleccione...</option>
                            <option value="Docente">Docente</option>
                            <option value="Investigador">Investigador</option>
                            <option value="Coautor">Coautor</option>
                        </select>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
