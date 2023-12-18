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
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" data-bs-backdrop="false" tabindex="-1" id="offcanvasAddProduct" aria-labelledby="offcanvasAddProductLabel" role="dialog">
        <!-- Offcanvas Header -->
        <div class="offcanvas-header py-4">
            <h5 id="offcanvasAddProductLabel" class="offcanvas-title">Agregar Producto</h5>
        </div>
        <!-- Offcanvas Body -->
        <div class="offcanvas-body border-top">
            <form class="needs-validation" id="FrmAddProducts" novalidate autocomplete="off">

                <div class="form-floating form-floating-outline mb-4">
                    <input type="text" class="form-control" placeholder="Código Producto" name="CodProduct" id="CodProduct" required>
                    <label for="CodProduct">Código Producto</label>
                </div>

                <div class="form-floating form-floating-outline mb-4">
                    <input type="text" class="form-control" placeholder="Nombre del Producto" name="NameProduct" id="NameProduct" required>
                    <label for="NameProduct">Nombre del Producto</label>
                </div>

                <div class="form-floating form-floating-outline mb-4">
                    <textarea type="text" class="form-control" placeholder="Descripción del Producto" name="DesProduct" id="DesProduct" style="height: 100px;" required></textarea>
                    <label for="DesProduct">Descripción del Producto</label>
                </div>

                <div class="form-floating form-floating-outline mb-4">
                    <input type="text" class="form-control" placeholder="Unidades" name="UnidProduct" id="UnidProduct" required>
                    <label for="UnidProduct">Unidades (bolsa, talla, peso, etc.)</label>
                </div>

                <div class="form-floating form-floating-outline mb-4">
                    <select class="form-select" name="AreaProduct" id="AreaProduct" required>
                        <option value="" disabled selected>Seleccionar</option>
                        <option value="Biomecánica">Biomecánica</option>
                        <option value="Ingeniería M.S.">Ingeniería M.S.</option>
                        <option value="Producción">Producción</option>
                        <option value="Sistemas">Sistemas</option>
                        <option value="Administración">Administración</option>
                        <option value="Recursos Humanos">Recursos Humanos</option>
                        <option value="Logística">Logística</option>
                        <option value="Ingeniería M.I.">Ingeniería M.I.</option>
                        <option value="Anaplastología">Anaplastología</option>
                        <option value="Diseño">Diseño</option>
                        <option value="Limpieza">Limpieza</option>
                        <option value="Textil">Textil</option>
                        <option value="Desarrollo Tecnológico">Desarrollo Tecnológico</option>
                    </select>
                    <label for="AreaProduct">Area del Producto</label>
                </div>

                <div class="form-floating form-floating-outline mb-4">
                    <input type="number" class="form-control" placeholder="Stock Mínimo" name="StockProduct" id="StockProduct" min="0" required>
                    <label for="StockProduct">Stock Mínimo</label>
                </div>

                <div class="mb-3">
                    <button id="btnAddProduct" type="submit" class="btn btn-primary">Agregar Producto</button>
                    <button type="reset" class="btn btn-outline-danger" data-bs-dismiss="offcanvas">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

</div>

<?php include "Views/templates/footer.php"; ?>