<?php include "Views/templates/header.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Logística /</span> Aprobación</h4>

    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="nav-align-left">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#Tab-Import" aria-controls="Tab-Import" aria-selected="true">Importaciones</button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#Tab-Compra" aria-controls="Tab-Compra" aria-selected="false">Orden de Compra</button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="Tab-Import">
                                <div class="card-datatable text-nowrap">
                                    <table class="dt-complex-header table" id="TblResumenOI">
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
                            <div class="tab-pane fade" id="Tab-Compra">
                                <div class="card-datatable text-nowrap">
                                    <table class="dt-complex-header table" id="TblResumenOC">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center">ID</th>
                                                <th class="text-center">FECHA</th>
                                                <th class="text-center">AREA</th>
                                                <th class="text-center">MONTO</th>
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
            </div>
        </div>
    </div>

</div>

<?php include "Views/templates/footer.php"; ?>