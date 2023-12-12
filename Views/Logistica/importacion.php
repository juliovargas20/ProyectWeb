<?php include "Views/templates/header.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Logística /</span> Orden de Importaciones</h4>

    <button id="btnModalImpor" class="btn btn-danger">Lista de importaciones</button>

    <div class="col-12 mb-3 mt-3">
        <div class="card">
            <div class="card-body">
                <form class="row g-3" id="FrmProve">
                    <input type="hidden" id="ID_Provee" name="ID_Provee">
                    <div class="col-4">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-account-hard-hat me-sm-1"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="NombreProve" id="NombreProve" placeholder="Nombre del Proveedor" />
                                <label for="NombreProve">Nombre del Proveedor</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-book-marker me-sm-1"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="PaisProve" id="PaisProve" placeholder="País de Origen" />
                                <label for="PaisProve">País de Origen</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-phone me-sm-1"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="TelProve" id="TelProve" placeholder="Telefono" />
                                <label for="TelProve">Telefono</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-web me-sm-1"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="PaginaPro" id="PaginaPro" placeholder="Pagina Web" />
                                <label for="PaginaPro">Pagina Web</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-account-tie me-sm-1"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="Vendedor" id="Vendedor" placeholder="Vendedor" />
                                <label for="Vendedor">Vendedor</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-phone me-sm-1"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="VenTel" id="VenTel" placeholder="Telefono del Vendedor" />
                                <label for="VenTel">Telefono del Vendedor</label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="col-2">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-minus-circle me-sm-1"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="Cantidad" id="Cantidad" placeholder="Cantidad" />
                                <label for="Cantidad">Cantidad</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-train-car-container me-sm-1"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="Producto" id="Producto" placeholder="Producto" />
                                <label for="Producto">Producto</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-form-textbox me-sm-1"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="Descripcion" id="Descripcion" placeholder="Descripción" />
                                <label for="Descripcion">Descripción</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-link-variant me-sm-1"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="Link" id="Link" placeholder="Link del Producto" />
                                <label for="Link">Link del Producto</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-5">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-form-textarea me-sm-1"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="Obs" id="Obs" placeholder="Observaciones" />
                                <label for="Obs">Observaciones</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="input-group input-group-merge">
                            <select name="Moneda" id="Moneda" class="form-select">
                                <option value="" disabled selected>---------</option>
                                <option value="S/.">S/.</option>
                                <option value="$">$</option>
                            </select>
                            <div class="form-floating form-floating-outline">
                                <input name="Precio" id="Precio" type="text" class="form-control" placeholder="Precio" aria-label="Amount (to the nearest dollar)" />
                                <label for="Precio">Precio</label>
                            </div>
                        </div>
                    </div>

                    <div class="demo-inline-spacing">
                        <button type="submit" class="btn btn-primary">Agregar</button>
                        <button id="btnLimpiar" type="button" class="btn btn-primary">Limpiar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-xl-12 col-md-8 col-12 mb-md-0 mb-4">
            <div class="card">
                <div class="table-responsive rounded-3 text-nowrap">
                    <table class="table" id="TblDetallesImport">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">Cantidad</th>
                                <th>Producto</th>
                                <th class="text-center">Proveedor</th>
                                <th class="text-center">País</th>
                                <th class="text-center">Vendedor</th>
                                <th class="text-center">Precio</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0" id="BodyProo">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <button id="btnImportacion" class="btn btn-success">Generar Importacion</button>
        </div>

        <div class="col-md-3">
            <div class="form-floating form-floating-outline">
                <select class="form-select" name="AreaImport" id="AreaImport">
                    <option value="" disabled selected>Seleccione----</option>
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
                <label for="">Area Solicitante</label>
            </div>
        </div>

    </div>

</div>

<div class="modal modal-top fade show" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" id="BuscarOI">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="mb-4">Buscar Importaciones</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3 py-md-0">
                <div class="card-datatable table-responsive">
                    <table class="invoice-list-table table" id="TblResumenOI">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">FECHA</th>
                                <th class="text-center">AREA</th>
                                <th class="text-center">STATUS</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include "Views/templates/footer.php"; ?>