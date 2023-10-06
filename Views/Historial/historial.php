<?php include "Views/templates/header.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gestión de Pacientes / Historial / </span>Registro</h4>

    <div class="row g-2">
        <div class="col-sm-9">
            <h3><?php echo $data['datos']['NOMBRES'] ?> - <span id="esd"></span></h3>
            <form id="FrmFG">
                <input type="hidden" readonly name="id_base" id="id_base" value="<?php echo $data['datos']['ID']; ?>">
                <input type="hidden" readonly name="IDFG" id="IDFG" value="<?php echo $data['datos']['ID_PACIENTE']; ?>">
                <input type="hidden" readonly name="PrFG" id="PrFG" value="<?php echo $data['datos']['PROCESO']; ?>">
                <input type="hidden" readonly name="TM" id="TM" value="<?php echo $data['datos']['TIP_TRAB']; ?>">
            </form>
        </div>
        <div class="col-sm-3 d-grid gap-2">
            <button class="btn btn-primary" type="button" onclick="AbrirModal();">Historial</button>
        </div>
        <div id="ProcesoFin">
            <button class="btn btn-dark" type="button" onclick="Proceso(<?php echo $data['datos']['ID']; ?>, <?php echo $data['datos']['PROCESO']; ?>)">Finalizar</button>
        </div>
    </div>


    <div class="row">
        <div class="col-md mb-4 mb-md-0">
            <div class="accordion accordion-popout mt-3" id="ProcesosResumen">
                <div class="accordion-item" id="pros1" style="display: none;">
                    <h2 class="accordion-header" id="headingPopoutOne">
                        <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionPopoutOne" aria-expanded="false" aria-controls="accordionPopoutOne">
                            <h5 class="mt-1" id="P1"></h5>
                        </button>
                    </h2>

                    <div id="accordionPopoutOne" class="accordion-collapse collapse" aria-labelledby="headingPopoutOne" data-bs-parent="#ProcesosResumen">
                        <div class="accordion-body row" id="ResumenAnt1">

                        </div>
                    </div>
                </div>
                <div class="accordion-item" id="pros2" style="display: none;">
                    <h2 class="accordion-header" id="headingPopoutTwo">
                        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionPopoutTwo" aria-expanded="false" aria-controls="accordionPopoutTwo">
                            <h5 class="mt-1" id="P2"></h5>
                        </button>
                    </h2>
                    <div id="accordionPopoutTwo" class="accordion-collapse collapse" aria-labelledby="headingPopoutTwo" data-bs-parent="#ProcesosResumen">
                        <div class="accordion-body row" id="ResumenAnt2">

                        </div>
                    </div>
                </div>
                <div class="accordion-item" id="pros3" style="display: none;">
                    <h2 class="accordion-header" id="headingPopoutThree">
                        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionPopoutThree" aria-expanded="false" aria-controls="accordionPopoutThree">
                            <h5 class="mt-1" id="P3"></h5>
                        </button>
                    </h2>
                    <div id="accordionPopoutThree" class="accordion-collapse collapse" aria-labelledby="headingPopoutThree" data-bs-parent="#ProcesosResumen">
                        <div class="accordion-body row" id="ResumenAnt3">

                        </div>
                    </div>
                </div>
                <div class="accordion-item" id="pros4" style="display: none;">
                    <h2 class="accordion-header" id="headingPopoutFour">
                        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionPopoutFour" aria-expanded="false" aria-controls="accordionPopoutFour">
                            <h5 class="mt-1" id="P4"></h5>
                        </button>
                    </h2>
                    <div id="accordionPopoutFour" class="accordion-collapse collapse" aria-labelledby="headingPopoutFour" data-bs-parent="#ProcesosResumen">
                        <div class="accordion-body row" id="ResumenAnt4">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr class="p-0" />

    <div class="row">
        <div class="col-md mb-4 mb-md-0">
            <div class="accordion accordion-popout mt-3" id="accordionPopout">
                <div class="accordion-item active">
                    <h2 class="accordion-header" id="headingPopoutOne">
                        <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#Main" aria-expanded="true" aria-controls="Main">
                            <h5 class="mt-1" id="btnMain"></h5>
                        </button>
                    </h2>

                    <div id="Main" class="accordion-collapse collapse show" aria-labelledby="Main" data-bs-parent="#Main">
                        <div class="accordion-body">
                            <div class="row" id="ResHis">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="ModalHistorial" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-simple">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body py-3 py-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                <div class="text-center mb-5">
                    <h3 class="mb-2">Registro de Historial</h3>
                </div>

                <h4 class="mb-2 text-center"><?php echo $data['datos']['NOMBRES'] ?> - <span><?php echo $data['datos']['SUB_TRAB']; ?></span></h4>

                <form class="row g-2 mb-2" id="FrmHistorial">

                    <div class="col-md-12">
                        <input type="hidden" class="form-control" name="idpacientehisto" id="idpacientehisto" value="<?php echo $data['datos']['ID_PACIENTE']; ?>" readonly>
                        <input type="hidden" class="form-control" readonly name="proceso" id="proceso" value="<?php echo $data['datos']['PROCESO']; ?>">
                        <input type="hidden" class="form-control" readonly name="idbase" id="proceso" value="<?php echo $data['datos']['ID']; ?>">
                    </div>

                    <div class="col-ms-12">
                        <div class="form-floating form-floating-outline mb-4">
                            <textarea class="form-control h-px-150 " placeholder="Descripción" name="Descripcion" id="Descripcion"></textarea>
                            <label>Descripcion</label>
                        </div>
                    </div>
                </form>

                <form action="<?php echo BASE_URL . 'Historial/RegistrarHis'; ?>" method="post" class="dropzone needsclick text-center" id="dropzone-basic">
                    <input type="hidden" readonly class="form-control" name="proceso" id="proceso" value="<?php echo $data['datos']['PROCESO']; ?>">
                    <input type="hidden" readonly class="form-control" name="ID_PACIENTE" id="ID_PACIENTE" value="<?php echo $data['datos']['ID_PACIENTE']; ?>">
                    <div class="dz-message needsclick">
                        Sube las fotos de la evaluación
                        <span class="note needsclick"><strong>Tiene como maximo 6 archivos (256MB) </strong></span>
                    </div>
                    <div class="fallback">
                        <input name="file" type="file" />

                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btnhisto">Agregar</button>
            </div>
        </div>
    </div>
</div>

<?php include "Views/templates/footer.php"; ?>