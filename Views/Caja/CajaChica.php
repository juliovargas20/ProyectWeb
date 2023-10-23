<?php include "Views/templates/header.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row mb-3">
        <div class="col-md-4">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Caja Empresarial /</span> Caja Chica</h4>
        </div>
        <div class="col-md-8 d-flex justify-content-end">
            <div class="demo-inline-spacing ">
                <div class="btn-group" id="hover-dropdown-demo">
                    <button type="button" class="btn btn-label-success dropdown-toggle waves-effect" data-bs-toggle="dropdown" data-trigger="hover">
                        <i class="mdi mdi-arrow-right-thin me-1"></i>
                        Ingreso
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" id="btnNI">
                                <i class="mdi mdi-plus me-1"></i>
                                Nuevo Ingreso
                            </a>
                        </li>
                        <li><a class="dropdown-item">Recibo</a></li>
                    </ul>
                </div>
                <button type="button" class="btn btn-label-danger waves-effect" id="btnNE">
                    <i class="mdi mdi-arrow-left-thin me-1"></i>
                    Egresos
                </button>
                <button type="button" class="btn btn-label-warning waves-effect">
                    <i class="mdi mdi-close-box-multiple-outline me-1"></i>
                    Cerrar Caja
                </button>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-5">
        <div class="col-lg-4 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="avatar me-3">
                            <div class="avatar-initial bg-label-success rounded">
                                <i class="mdi mdi-trending-up mdi-24px">
                                </i>
                            </div>
                        </div>
                        <div class="card-info">
                            <div class="d-flex align-items-center">
                                <h4 class="mb-0" id="TI"></h4>
                            </div>
                            <small>Total Ingresos</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="avatar me-3">
                            <div class="avatar-initial bg-label-danger rounded">
                                <i class="mdi mdi-trending-down mdi-24px">
                                </i>
                            </div>
                        </div>
                        <div class="card-info">
                            <div class="d-flex align-items-center">
                                <h4 class="mb-0" id="TE"></h4>
                            </div>
                            <small>Total Egresos</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="avatar me-3">
                            <div class="avatar-initial bg-label-info rounded">
                                <i class="mdi mdi-currency-usd mdi-24px">
                                </i>
                            </div>
                        </div>
                        <div class="card-info">
                            <div class="d-flex align-items-center">
                                <h4 class="mb-0" id="TOTALIE"></h4>
                            </div>
                            <small>Total Caja diaria</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-12">
        <div class="nav-align-top mb-4">
            <ul class="nav nav-pills mb-3" role="tablist">
                <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-home" aria-controls="navs-pills-top-home" aria-selected="true">
                        Ingreso
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile" aria-selected="false">
                        Egresos
                    </button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel">
                    <div class="card-datatable table-responsive">
                        <table class="invoice-list-table table" id="TblListadoIngresos">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Transacción</th>
                                    <th>Responsable</th>
                                    <th style="width: 100px;">Pago</th>
                                    <th>Descripción</th>
                                    <th class="text-center">Área</th>
                                    <th class="text-center">Monto</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
                    <div class="card-datatable table-responsive">
                        <table class="invoice-list-table table" id="TblListadoEgrasos">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">Fecha</th>
                                    <th>Descripción</th>
                                    <th>Comprobante</th>
                                    <th class="text-center">N° Comprobante</th>
                                    <th class="text-center">Responsable</th>
                                    <th class="text-center">Área</th>
                                    <th class="text-center">Monto</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- NUEVO INGRESO -->
<div class="modal modal-top fade show" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" id="NuevoIngreso">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="mb-4">Nuevo Ingreso</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <hr>
            <form id="FrmNI" class="needs-validation" novalidate autocomplete="off" >
                <div class="modal-body py-3 py-md-0">
                    <div class="row mb-3 g-3">
                        <input type="hidden" name="ID" id="ID">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline">
                                <select name="Tranx" id="Tranx" class="form-select" required>
                                    <option value="" disabled selected>Seleccione...</option>
                                    <option value="Ventas">Ventas</option>
                                    <option value="Ingreso Caja Chica">Ingreso Caja Chica</option>
                                </select>
                                <label for="">Transacción</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="Responsable" id="Responsable" placeholder="Responsable" required>
                                <label for="">Responsable</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline">
                                <select name="Comprobante" id="Comprobante" class="form-select" required>
                                    <option value="" disabled selected>Seleccione...</option>
                                    <option value="Factura">Factura</option>
                                    <option value="Boleta">Boleta</option>
                                </select>
                                <label for="">Comprobante</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="NCom" id="NCom" placeholder="N° Comprobante" required>
                                <label for="">N° Comprobante</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline">
                                <select name="TipPago" id="TipPago" class="form-select" required>
                                    <option value="" disabled selected>Seleccione...</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Transferencia">Transferencia</option>
                                    <option value="Pago con Tarjeta">Pago con Tarjeta</option>
                                </select>
                                <label for="">Tipo de Pago</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline">
                                <select name="Area" id="Area" class="form-select" required>
                                    <option value="" disabled selected>Seleccione...</option>
                                    <option value="Fronk Desk">Fronk Desk</option>
                                    <option value="Biomecánica">Biomecánica</option>
                                    <option value="Sistemas">Sistemas</option>
                                    <option value="Diseño y Marketing">Diseño y Marketing</option>
                                    <option value="Ingeniería M.S.">Ingeniería M.S.</option>
                                    <option value="Ingeniería M.I.">Ingeniería M.I.</option>
                                    <option value="Limpieza">Limpieza</option>
                                    <option value="Servicio Generales">Servicio Generales</option>
                                    <option value="Textil">Textil</option>
                                    <option value="RR.HH">RR.HH</option>
                                    <option value="Administración">Administración</option>
                                </select>
                                <label for="">Área</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="Dsc" id="Dsc" placeholder="Descripción" required>
                                <label for="">Descripción</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">S/.</span>
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" name="Monto" id="Monto" placeholder="Monto" required>
                                    <label for="">Monto</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="modal-footer">
                    <button type="submit" id="btnResgistarNI" class="btn btn-primary">Registrar</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- NUEVO EGRESO -->
<div class="modal modal-top fade show" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" id="NuevoEgreso">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="mb-4">Nuevo Egreso</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <hr>
            <form id="FrmNE" class="needs-validation" novalidate autocomplete="off" >
                <div class="modal-body py-3 py-md-0">
                    <div class="row mb-3 g-3">
                    <input type="hidden" name="ID" id="ID">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline">
                                <select name="Tranx" id="Tranx" class="form-select" required>
                                    <option value="" disabled selected>Seleccione...</option>
                                    <option value="Compras">Compras</option>
                                    <option value="Retiro Caja Chica">Retiro Caja Chica</option>
                                </select>
                                <label for="">Transacción</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="Responsable" id="Responsable" placeholder="Responsable" required>
                                <label for="">Responsable</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline">
                                <select name="Comprobante" id="Comprobante" class="form-select" required>
                                    <option value="" disabled selected>Seleccione...</option>
                                    <option value="Factura">Factura</option>
                                    <option value="Boleta">Boleta</option>
                                </select>
                                <label for="">Comprobante</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="NCom" id="NCom" placeholder="N° Comprobante" required>
                                <label for="">N° Comprobante</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline">
                                <select name="TipPago" id="TipPago" class="form-select" required>
                                    <option value="" disabled selected>Seleccione...</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Transferencia">Transferencia</option>
                                    <option value="Pago con Tarjeta">Pago con Tarjeta</option>
                                </select>
                                <label for="">Tipo de Pago</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline">
                                <select name="Area" id="Area" class="form-select" required>
                                    <option value="" disabled selected>Seleccione...</option>
                                    <option value="Fronk Desk">Fronk Desk</option>
                                    <option value="Biomecánica">Biomecánica</option>
                                    <option value="Sistemas">Sistemas</option>
                                    <option value="Diseño y Marketing">Diseño y Marketing</option>
                                    <option value="Ingeniería M.S.">Ingeniería M.S.</option>
                                    <option value="Ingeniería M.I.">Ingeniería M.I.</option>
                                    <option value="Limpieza">Limpieza</option>
                                    <option value="Servicio Generales">Servicio Generales</option>
                                    <option value="Textil">Textil</option>
                                    <option value="RR.HH">RR.HH</option>
                                    <option value="Administración">Administración</option>
                                </select>
                                <label for="">Área</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="Dsc" id="Dsc" placeholder="Descripción" required>
                                <label for="">Descripción</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">S/.</span>
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" name="Monto" id="Monto" placeholder="Monto" required>
                                    <label for="">Monto</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="modal-footer">
                    <button type="submit" id="btnResgistarNE" class="btn btn-primary">Registrar</button>
                </div>
            </form>

        </div>
    </div>
</div>

<?php include "Views/templates/footer.php"; ?>