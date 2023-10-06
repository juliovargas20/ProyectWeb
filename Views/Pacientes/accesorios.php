<?php include "Views/templates/header.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gestión de Pacientes / Listado de Pacientes / </span> Accesorios </h4>

    <div class="row mb-4">
        <div class="col-md-9">
            <h3><?php echo $data['get']['NOMBRES']; ?></h3>
        </div>
    </div>

    <hr>

    <form id="FrmAcc" class="row g-2">
        <div class="col-6 mb-3">
            <div class="card">
                <div class="card-header">
                    <h5>Metodos de Pago</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                    <input type="hidden" readonly id="id_pa" name="id_pa" value="<?php echo $data['get']['ID_PACIENTE']; ?>">
                        <div class="col-md-6">
                            <select name="TipPago" id="TipPago" class="form-select" onchange="OnchageAcc();" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Transferencia">Transferencia</option>
                                <option value="Efectivo">Efectivo</option>
                                <option value="Pago con Tarjeta">Pago con Tarjeta</option>
                                <option value="Billetera Digital">Billetera Digital</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select name="Pago" id="Pago" class="form-select" required>

                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="form-floating form-floating-outline">
                        <textarea name="Obs" id="Obs" class="form-control" placeholder="Observaciones" style="height: 91px;"></textarea>
                        <label for="Obs">Observaciones</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-md-5">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="Descripcion" name="Descripcion" placeholder="Descripción">
                                <label for="Descripcion">Descripción</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating form-floating-outline">
                                <input type="number" class="form-control" id="Cantidad" placeholder="Cantidad" min="0">
                                <label for="Cantidad">Cant.</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating form-floating-outline">
                                <input type="number" class="form-control" id="PrecioU" placeholder="Precio U." min="0">
                                <label for="PrecioU">Precio U.</label>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-2 text-center mt-3">
                            <button type="button" id="btnAgregar" class="btn btn-danger">Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-9 col-md-8 col-12 mb-md-0 mb-4">
            <div class="card">
                <div class="card-header"></div>
                <div class="table-responsive text-nowrap">
                    <table class="table" id="TblAcc">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">Cantidad</th>
                                <th>Descripción</th>
                                <th class="text-center">Precio U.</th>
                                <th class="text-center">Sub-Total</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0" id="TblbodyAcc">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-4 col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text">S/.</span>
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="Total" name="Total" readonly placeholder="Total" required/>
                            <label for="Total">Total</label>
                        </div>
                    </div>
                    <br>
                    <button id="btnGenerar" type="submit" class="btn btn-primary d-grid w-100 mb-3">
                        <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="mdi mdi-send-outline scaleX-n1-rtl me-1"></i>Generar</span>
                    </button>
                </div>
            </div>
        </div>



    </form>
</div>


<?php include "Views/templates/footer.php"; ?>