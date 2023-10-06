<?php include "Views/templates/header.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gestión de Pacientes / Contrato /</span> <?php echo $data['get']['NOMBRES'] ?></h4>

    <input type="hidden" id="id_paciente" readonly value="<?php echo $data['get']['ID_PACIENTE'] ?>">

    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="invoice-list-table table" id="TblContrato">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">Fecha</th>
                        <th>Servicio</th>
                        <th class="text-center">Monto</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalContrato" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body py-3 py-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-5">
                    <h3 class="mb-2">Información del Contrato</h3>
                    <h4><?php echo $data['get']['NOMBRES'] ?></h4>
                    <input type="hidden" readonly id="IdCoti">
                </div>
                <div class="row g-3">
                    <div class="col-12">
                        <h6 class="fw-semibold">Lista de Componentes</h6>
                        <hr class="mt-0 mb-3" />

                        <div class="col-lg-12 mb-4 mb-xl-0">
                            <div class="demo-inline-spacing mt-3">
                                <ol id="listaCompo" class="list-group">

                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <h6 class="fw-semibold">Observaciones</h6>
                        <hr class="mt-0" />

                        <div class="col-lg-12 mb-4 mb-xl-0">
                            <textarea readonly class="form-control h-px-100" id="Obs" cols="30" rows="10">
                            </textarea>
                        </div>

                    </div>

                    <div class="col-6">
                        <h6 class="fw-semibold">Monto</h6>
                        <hr class="mt-0" />

                        <div class="col-lg-12 mb-4 mb-xl-0">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">S/.</span>
                                <input type="text" class="form-control" id="Monto" readonly>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnVis">Pre-Visualizar</button>
                <button type="button" id="btnContrato" class="btn btn-success">Generar</button>
            </div>
        </div>
    </div>
</div>

<?php include "Views/templates/footer.php"; ?>