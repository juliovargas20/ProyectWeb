<?php include "Views/templates/header.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gestión de Pacientes / </span> Historial de Pagos</h4>

    <div class="row mb-4">
        <div class="col-md-9">
            <input type="hidden" readonly id="id_pro" value="<?php echo $data['datos']['ID'] ?>">
            <h4><?php echo $data['datos']['NOMBRES'] ?> - <?php echo $data['datos']['SUB_TRAB'] ?></h4>
        </div>
        <div class="col-md-3">
            <div class="d-grid gap-2">
                <button type="button" class="btn btn-primary" onclick="AbriModal();">Agregar Pago</button>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <h5 class="card-header">Resumen</h5>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="demo-inline-spacing mt-3">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Monto Total
                                <span class="badge bg-label-success">S/. <?php echo $data['datos']['MONTO'] ?></span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Monto Abonado
                                <span class="badge bg-label-info">S/. <?php echo $data['saldo']['ABONO'] ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Deuda Restante
                                <span class="badge bg-label-danger">S/. <?php echo $data['saldo']['TOTAL'] ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card">
        <h5 class="card-header">Historial de Pagos</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">Fecha</th>
                        <th class="text-center">N° Pago</th>
                        <th class="text-center">Tipo de Pago</th>
                        <th>Metodo</th>
                        <th class="text-center">Monto</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="bodyPagos">

                </tbody>
            </table>
        </div>
    </div>

</div>

<div class="modal modal-top fade show" data-bs-backdrop="static" data-bs-keyboard="false" id="ModalPagos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="modal-content needs-validation" novalidate autocomplete="off" id="FrmPagos">
            <div class="modal-header">
                <h3 class="mb-2">Registrar Pago</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" readonly name="id_paciente" required value="<?php echo $data['datos']['ID_PACIENTE'] ?>">
                    <input type="hidden" readonly name="id_contrato" required value="<?php echo $data['datos']['ID'] ?>">
                    <div class="col-md-6 mt-2">
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select" name="NPago" id="NPago" required>
                                <option value="" disabled selected>Seleccione el N° de Pago</option>
                                <option value="Pago 1">Pago N° 1</option>
                                <option value="Pago 2">Pago N° 2</option>
                                <option value="Pago 3">Pago N° 3</option>
                                <option value="Pago 4">Pago N° 4</option>
                                <option value="Pago 4">Pago N° 5</option>
                            </select>
                            <label for="NPago">N° de Pago</label>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text">S/.</span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" required id="MontoA" name="MontoA" placeholder="Monto Abonado">
                                <label for="MontoA">Monto Abonado</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select" required name="TipPago" id="TipPago" onchange="OnchageTP();">
                                <option value="" disabled selected>Seleccione el Tipo de Pago</option>
                                <option value="Transferencia">Transferencia</option>
                                <option value="Efectivo">Efectivo</option>
                                <option value="Pago con Tarjeta">Pago con Tarjeta</option>
                                <option value="Billetera Digital">Billetera Digital</option>
                            </select>
                            <label for="TipPago">Tipo de Pago</label>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select" required name="Metodo" id="Metodo">

                            </select>
                            <label for="Metodo">Metodo</label>
                        </div>
                    </div>
                    <div class="col-md-12 mt-2">
                        <label for="file" class="form-label">Comprobante (Max. 256Mb)</label>
                        <input type="file" accept="image/*" class="form-control" name="file" id="file" size="268435456">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-dark" id="btnHistoPagos">Realizar Pago</button>
            </div>
        </form>
    </div>
</div>

<?php include "Views/templates/footer.php"; ?>