<?php include "Views/templates/header.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Logística</li>
            <li class="breadcrumb-item">
                <a href="<?php echo BASE_URL . 'Logistica/almacen' ?>">Almacenes</a>
            </li>
            <li class="breadcrumb-item active">Productos Lima</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Listado de Productos - LIMA</h5>
        </div>
        <div class="card-datatable table-responsive">
            <table class="dt-complex-header datatables-products table">
                <thead class="table-light">
                    <tr>
                        <th></th>
                        <th>Codigo</th>
                        <th>Producto</th>
                        <th>Unidades</th>
                        <th>Sede</th>
                        <th>Area</th>
                        <th>Stock Minimo</th>
                        <th>status</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

</div>

<?php include "Views/templates/footer.php"; ?>