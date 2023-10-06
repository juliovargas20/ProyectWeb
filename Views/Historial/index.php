<?php include "Views/templates/header.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row g-2">
        <div class="col-sm-9">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gestión de Pacientes / Historial / </span>Listado de Procesos</h4>
        </div>
        <div class="col-sm-3">
            <button type="button" class="btn btn-info" onclick="AbrirProceso();">Procesos Finalizados</button>
        </div>
    </div>

    <div class="col-xl-12">
        <div class="card mb-4">
            <div class="card-header p-2">
                <div class="nav-align-top">
                    <ul class="nav nav-tabs nav-fill" role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-MS" aria-controls="navs-justified-MS" aria-selected="true"><i class="tf-icons mdi mdi-account-injury-outline mdi-24px me-1"></i> Miembros Superiores </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-MI" aria-controls="navs-justified-MI" aria-selected="false"><i class="tf-icons mdi mdi-wheelchair-accessibility mdi-24px me-1"></i> Miembros inferiores </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-E" aria-controls="navs-justified-E" aria-selected="false"><i class="tf-icons mdi mdi-allergy mdi-24px me-1"></i> Estética</button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content p-2">
                    <div class="tab-pane fade show active" id="navs-justified-MS" role="tabpanel">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-hover table-bordered" id="TblProcesosMS">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Procesos</th>
                                    </tr>
                                </thead>
                                <tbody style="cursor: pointer;">
                                    <tr>
                                        <td class="text-center">MS1</td>
                                        <td class="text-center">Escaneo y Toma de Medidas</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">MS2</td>
                                        <td class="text-center">Pruebas de Encaje</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">MS3</td>
                                        <td class="text-center">Prueba de Función y Alineación</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">MS4</td>
                                        <td class="text-center">Encaje Final</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-justified-MI" role="tabpanel">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-hover table-bordered" id="TblProcesosMI">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Procesos</th>
                                    </tr>
                                </thead>
                                <tbody style="cursor: pointer;">
                                    <tr>
                                        <td class="text-center">MI1</td>
                                        <td class="text-center">Toma de Molde</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">MI2</td>
                                        <td class="text-center">Prueba de Encaje</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">MI3</td>
                                        <td class="text-center">Prueba de Marcha</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">MI4</td>
                                        <td class="text-center">Encaje Final</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-justified-E" role="tabpanel">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-hover table-bordered" id="TblProcesosE">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Procesos</th>
                                    </tr>
                                </thead>
                                <tbody style="cursor: pointer;">
                                    <tr>
                                        <td class="text-center">E1</td>
                                        <td class="text-center">Toma de Molde</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">E2</td>
                                        <td class="text-center">Moldeado o Escultura</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">E3</td>
                                        <td class="text-center">Prueba de Succión</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">E4</td>
                                        <td class="text-center">Encaje Final</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-top fade show" data-bs-backdrop="static" data-bs-keyboard="false" id="ModalProcesoFin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="mb-2">Procesos Finalizados</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="invoice-list-table table table-hover" id="TblFinalizados">
                    <thead class="table-light">
                        <tr>
                        <th class="text-center">ID</th>
                            <th class="text-center">N° Paciente</th>
                            <th>NOMBRES</th>
                            <th class="text-center">Servicio</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include "Views/templates/footer.php"; ?>