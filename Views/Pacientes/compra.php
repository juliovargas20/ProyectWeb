<?php include "Views/templates/header.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="fw-bold py-3 mb-3"><span class="text-muted fw-light">Gestión de Pacientes / </span> Compras de Productos </h4>

    <button class="btn btn-primary">Listado Recibos</button>

    <hr class="mb-4">

        <form action="" class="row g-2">
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <h6>1. Datos Personales</h6>
                                <hr class="mt-0" />
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="CompraNombres" class="form-control" placeholder="Nombres Completos" name="CompraNombres" required/>
                                    <label for="CompraNombres">Nombres Completos</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="text" id="CompraDNI" name="CompraDNI" placeholder="DNI - C.E." required/>
                                    <label for="CompraDNI">DNI - C.E.</label>
                                </div>
                            </div>

                            <div class="col-6">
                                <h6>2. Método de Pagos</h6>
                                <hr class="mt-0" />
                            </div>

                            <div class="col-6">
                                <h6>3. Observaciones</h6>
                                <hr class="mt-0" />
                            </div>

                            <div class="col-md-3">
                                <select name="CompraTipPago" id="CompraTipPago" class="form-select" onchange=" OnchageCompras();" required>
                                    <option value="" disabled selected>Seleccione</option>
                                    <option value="Transferencia">Transferencia</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Pago con Tarjeta">Pago con Tarjeta</option>
                                    <option value="Billetera Digital">Billetera Digital</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <select name="CompraPago" id="CompraPago" class="form-select" required>

                                </select>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <textarea class="form-control h-px-100" id="CompraObs" name="CompraObs" placeholder="Observaciones"></textarea>
                                    <label for="CompraObs">Observaciones</label>
                                </div>
                            </div>
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
                                    <input type="text" class="form-control" id="ComprasDescripcion" name="ComprasDescripcion" placeholder="Descripción">
                                    <label for="ComprasDescripcion">Descripción</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" class="form-control" id="CompraCantidad" placeholder="Cantidad" min="0">
                                    <label for="CompraCantidad">Cant.</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" class="form-control" id="CompraPrecioU" placeholder="Precio U." min="0">
                                    <label for="CompraPrecioU">Precio U.</label>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-2 text-center mt-3">
                                <button type="button" id="btnCompraAgregar" class="btn btn-danger">Agregar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-9 col-md-8 col-12 mb-md-0 mb-4">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="table-responsive text-nowrap">
                        <table class="table" id="TblCompras">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">Cantidad</th>
                                    <th>Descripción</th>
                                    <th class="text-center">Precio U.</th>
                                    <th class="text-center">Sub-Total</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0" id="TblbodyCompra">

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
                                <input type="text" class="form-control" id="CompraTotal" name="CompraTotal" readonly placeholder="Total" required />
                                <label for="Total">Total</label>
                            </div>
                        </div>
                        <br>
                        <button id="btnGenerarCompra" type="submit" class="btn btn-primary d-grid w-100 mb-3">
                            <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="mdi mdi-send-outline scaleX-n1-rtl me-1"></i>Generar</span>
                        </button>
                    </div>
                </div>
            </div>


        </form>

</div>

<?php include "Views/templates/footer.php"; ?>