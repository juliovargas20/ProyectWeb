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
                            <a class="dropdown-item">
                                <i class="mdi mdi-plus me-1"></i>
                                Nueva Venta
                            </a>
                        </li>
                        <li><a class="dropdown-item">Ingreso Caja</a></li>
                    </ul>
                </div>
                <button type="button" class="btn btn-label-danger waves-effect">
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
                                <h4 class="mb-0">28.6k</h4>
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
                                <h4 class="mb-0">28.6k</h4>
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
                                <h4 class="mb-0">28.6k</h4>
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


</div>

<?php include "Views/templates/footer.php"; ?>