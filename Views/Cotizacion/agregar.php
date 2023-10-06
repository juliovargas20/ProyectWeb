<?php include "Views/templates/header.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Gestión de Pacientes / Cotización / </span>Registrar Cotización</h4>

    <button class="btn btn-dark d-grid mb-3" onclick="AbrirManual();">
        <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="mdi mdi-file-document-multiple-outline scaleX-n1-rtl me-2"></i>Manual</span>
    </button>

    <div class="col-12 mb-3">
        <div class="card">
            <div class="card-body">
                <form id="frmServicio" class="row g-2" class="needs-validation" novalidate autocomplete="off">
                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline">
                            <select id="IdPaciente" name="IdPaciente" class="select2 form-select form-select-lg" data-allow-clear="true" onchange="OnchageShow()" required>
                                <option value=""></option>
                                <?php foreach ($data['get'] as $row) { ?>
                                    <option value="<?php echo $row['ID_PACIENTE'] ?>"><?php echo $row['NOMBRES'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div id="Servicio" class="col-md-4" style="display: none;">
                        <div class="form-floating form-floating-outline">
                            <select id="Tip_trab" name="Tip_trab" class="form-select form-select-lg" data-allow-clear="true" onchange="OnchageTip()" required>
                                <option value="" disabled selected>Seleccionar tipo de Servicio</option>
                                <?php foreach ($data['tipSer'] as $row) { ?>
                                    <option value="<?php echo $row['TIPOMIEMBRO'] ?>"><?php echo $row['TIPOMIEMBRO'] ?></option>
                                <?php } ?>
                            </select>
                            <label for="Tip_trab">Tipo de Servicio</label>
                        </div>
                    </div>
                    <div id="Trabajo" class="col-md-4" style="display: none;">
                        <div class="form-floating form-floating-outline">
                            <select id="Sub_trab" name="Sub_trab" class="form-select form-select-lg" data-allow-clear="true" onchange="OnchaCoti();" required>

                            </select>
                            <label for="Sub_trab">Tipo de Servicio</label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row" id="Coti" style="display: none;">
        <div class="col-xl-9 col-md-8 col-12 mb-md-0 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="TitleTipTra">Tipo de Trabajo</h5>
                </div>
                <div class="card-body">
                    <form id="FrmLista" class="needs-validation" novalidate autocomplete="off">

                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-4 col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <button id="btnGenerar" class="btn btn-primary d-grid w-100 mb-3">
                        <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="mdi mdi-send-outline scaleX-n1-rtl me-1"></i>Generar</span>
                    </button>
                    <button id="btnItem" class="btn btn-success d-grid w-100">
                        <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="mdi mdi-plus me-1"></i>Agregar Item</span>
                    </button>
                </div>
            </div>

            <div class="card mb-2">
                <div class="card-body">

                    <div class="form-floating form-floating-outline mb-4">
                        <input type="number" class="form-control" id="Peso" placeholder="Peso (kg.)" min="1" required>
                        <label for="Peso">Peso (kg.)</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-4">
                        <textarea class="form-control h-px-100" id="Observacion" placeholder="Observaciones"></textarea>
                        <label for="Observacion">Observaciones</label>
                    </div>

                    <div class="input-group input-group-merge mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="number" class="form-control" id="cantidad" placeholder="Cantidad Protesis" min="1" value="1" required />
                            <label for="cantidad">Cantidad Protesis</label>
                        </div>
                    </div>

                    <div class="input-group input-group-merge">
                        <span class="input-group-text">S/.</span>
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="monto" placeholder="Precio Unitario" required />
                            <label for="monto">Precio Unitario</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mb-2">
                <label class="mb-0">Incluir IGV (18%)</label>
                <label class="form-check form-switch mb-2">
                    <input type="checkbox" name="IGV" id="IGV" class="form-check-input">
                </label>
            </div>
        </div>

    </div>
</div>

<div class="modal modal-top fade show" data-bs-backdrop="static" data-bs-keyboard="false" id="ModalManualCoti" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="mb-2">Cotización Manual</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form id="frmServicioManual" class="row g-2" class="needs-validation" novalidate autocomplete="off">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline">
                                <select id="IdPacienteManual" name="IdPacienteManual" class="form-select form-select-lg" data-allow-clear="true" onchange="OnchageShowManual();" required>
                                    <option value=""></option>
                                    <?php foreach ($data['get'] as $row) { ?>
                                        <option value="<?php echo $row['ID_PACIENTE'] ?>"><?php echo $row['NOMBRES'] ?></option>
                                    <?php } ?>
                                </select>
                                <label for="select2Basic">Nombre del Paciente</label>
                            </div>
                        </div>
                        <div id="ServicioManual" class="col-md-4" style="display: none;">
                            <div class="form-floating form-floating-outline">
                                <select id="Tip_trabManual" name="Tip_trabManual" class="form-select form-select-lg" data-allow-clear="true" onchange="OnchageTipManual();" required>
                                    <option value="" disabled selected>Seleccionar tipo de Servicio</option>
                                    <?php foreach ($data['tipSer'] as $row) { ?>
                                        <option value="<?php echo $row['TIPOMIEMBRO'] ?>"><?php echo $row['TIPOMIEMBRO'] ?></option>
                                    <?php } ?>
                                </select>
                                <label for="Tip_trab">Tipo de Servicio</label>
                            </div>
                        </div>
                        <div id="TrabajoManual" class="col-md-4" style="display: none;">
                            <div class="form-floating form-floating-outline">
                                <select id="Sub_trabManual" name="Sub_trabManual" class="form-select form-select-lg" data-allow-clear="true" onchange="" required>

                                </select>
                                <label for="Sub_trab">Tipo de Servicio</label>
                            </div>
                        </div>
                    </form>
                </div>
                <hr class="mt-3">
                <div class="row">
                    <div class="col-md-6">
                        <form id="FrmListaManual" class="row g-2 needs-validation" novalidate autocomplete="off">

                        </form>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="number" class="form-control" id="PesoManual" placeholder="Peso (kg.)" required>
                            <label for="PesoManual">Peso (kg.)</label>
                        </div>

                        <div class="form-floating form-floating-outline mb-4">
                            <textarea class="form-control h-px-100" id="ObservacionManual" placeholder="ObservacionManual"></textarea>
                            <label for="ObservacionManual">Observaciones</label>
                        </div>

                        <div class="input-group input-group-merge mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="number" class="form-control" id="cantidadManual" placeholder="Cantidad Protesis" min="1" value="1" required />
                            <label for="cantidadManual">Cantidad Protesis</label>
                        </div>
                    </div>

                        <div class="input-group input-group-merge">
                            <span class="input-group-text">S/.</span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="montoManual" name="montoManual" placeholder="Precio Unitario" required />
                                <label for="montoManual">Precio Unitario</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btnItemManual">Agregar Item</button>
                <button type="submit" class="btn btn-dark" id="btnManualCoti">Generar</button>
            </div>
        </div>
    </div>
</div>


<?php include "Views/templates/footer.php"; ?>