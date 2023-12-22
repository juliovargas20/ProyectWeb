<?php include "Views/templates/header.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Logística</li>
            <li class="breadcrumb-item">
                <a href="<?php echo BASE_URL . 'Logistica/almacen' ?>">Almacenes</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?php echo BASE_URL . 'Logistica/productos_lima' ?>">Productos Lima</a>
            </li>
            <li class="breadcrumb-item active">Entradas de Productos Lima</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Entradas de Productos - LIMA</h5>
        </div>
        <div class="card-datatable table-responsive">
            <table class="dt-complex-header datatables-EntriesProducts table">
                <thead class="table-light">
                    <tr>
                        <th></th>
                        <th>N° de Boleta</th>
                        <th>Fecha</th>
                        <th>Codigo</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Unidades</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal modal-top fade show" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" id="ModalEntriesProduct">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Entradas de Productos</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <hr>
                <form class="modal-body" id="FrmEntriesProduct">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="form-floating form-floating-outline">
                                <select id="SearchProduct" name="SearchProduct" class="select2 form-select form-select-lg" data-allow-clear="true" onchange="onChangUnid();" required>
                                    <option value=""></option>
                                    <?php foreach ($data['get'] as $row) { ?>
                                        <option value="<?php echo $row['ID_PRODUCTO'] ?>"><?php echo $row['CODIGO_PRODUCTO'] ?> - <?php echo $row['NOMBRE'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-5">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" class="form-control" placeholder="Cantidad" name="QuantProduct" id="QuantProduct" min="0" required>
                                <label for="QuantProduct">Cantidad</label>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" class="form-control" placeholder="Unidades" name="UnidProduct" id="UnidProduct" required readonly>
                                <label for="UnidProduct">Unidades</label>
                            </div>
                        </div>
                        <div class="col-md-12 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input id="NSerieProducts" class="form-control h-auto" name="NSerieProducts" />
                                <label for="NSerieProducts">N° de Serie (TIENE QUE SER IGUAL A LA CANTIDAD)</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" class="form-control" placeholder="N° de Boleta (Orden de Compra o Importacion)" name="NBoleProduct" id="NBoleProduct" required>
                                <label for="NBoleProduct">N° de Boleta (Orden de Compra o Importacion)</label>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="click" class="btn btn-primary" id="btnEntriesProducts">Agregar Entradas</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-top fade show" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" id="ModalSerieProduct">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Series de Productos</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <hr>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <small class="text-light fw-medium">Producto: </small>
                            <div class="demo-inline-spacing mt-3">
                                <ul class="list-group" id="listSerieProducts">
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



<?php include "Views/templates/footer.php"; ?>