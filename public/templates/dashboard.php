<?php
include "../controlador/ControladorProductos.php";

if (empty($_SESSION["id_autor"])) {
    header("location: ../login.php");
}

?>
<div class="container-fluid">
            <!-- Header with Search and Add Button -->
            <div class="row mb-4 align-items-center">
                <div class="col-md-6">
                    <h2>Dashboard de Investigaciones</h2>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Buscar producto...">
                    </div>
                </div>
                <div class="col-md-2 text-end">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#productModal">
                        <i class="fas fa-plus"></i> Nuevo Producto
                    </button>
                </div>
            </div>

            <!-- Info Cards -->
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="card info-card bg-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-3 info-card-icon bg-primary bg-opacity-10 text-primary">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted">Total Investigaciones</h6>
                                    <h3 class="mb-0">12</h3>
                                </div>
                            </div>
                            <div class="mt-3 text-success">
                                <small><i class="fas fa-arrow-up"></i> 8% más que el mes pasado</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card info-card bg-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-3 info-card-icon bg-success bg-opacity-10 text-success">
                                    <i class="fas fa-book"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted">Publicaciones</h6>
                                    <h3 class="mb-0">8</h3>
                                </div>
                            </div>
                            <div class="mt-3 text-success">
                                <small><i class="fas fa-arrow-up"></i> 12% más que el mes pasado</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card info-card bg-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-3 info-card-icon bg-warning bg-opacity-10 text-warning">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted">Colaboradores</h6>
                                    <h3 class="mb-0">6</h3>
                                </div>
                            </div>
                            <div class="mt-3 text-success">
                                <small><i class="fas fa-arrow-up"></i> 2 nuevos este mes</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Table -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Mis Productos de Investigación</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Título</th>
                                    <th>Tipo</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                    <th>Coautores</th>
                                </tr>
                            </thead>
                            <tbody>
            <?php if($res && $res->num_rows > 0): ?>
                <?php while($row = $res->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["titulo"]); ?></td>
                        <td><?php echo htmlspecialchars($row["tipo"]); ?></td>
                        <td><?php echo htmlspecialchars($row["estado"]); ?></td>
                        <td><?php echo htmlspecialchars($row["fecha"]); ?></td>
                        <td><?php echo htmlspecialchars($row["coautores"]); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5">No se encontraron productos</td></tr>
            <?php endif; ?>
        </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                    <i class="fas fa-angle-left"></i>
                                </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">
                                    <i class="fas fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>