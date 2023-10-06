<?php include "Views/templates/header.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Visitas Médicas /</span> Citas</h4>

    <div class="col-xl-12">
        <div class="nav-align-top mb-4">
            <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#CentroSalud" aria-controls="CentroSalud" aria-selected="true"><i class="tf-icons mdi mdi-hospital-building me-1"></i> Centro de Salud </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#Ortopedia" aria-controls="Ortopedia" aria-selected="false"><i class="tf-icons mdi mdi-human-wheelchair me-1"></i> Ortopedias </button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="CentroSalud" role="tabpanel">
                    <div class="card-datatable table-responsive">
                        <table class="invoice-list-table table" id="TblCentroS">
                            <thead class="table-light">
                                <tr>
                                    <th>Centro de Salud</th>
                                    <th class="text-center">Horas</th>
                                    <th class="text-center">Doctor</th>
                                    <th class="text-center">Visitador(a)</th>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="Ortopedia" role="tabpanel">
                    <div class="card-datatable table-responsive">
                        <table class="invoice-list-table table" id="TblOr">
                            <thead class="table-light">
                                <tr>
                                    <th>Tienda</th>
                                    <th class="text-center">Horas</th>
                                    <th class="text-center">Encargado</th>
                                    <th class="text-center">Visitador(a)</th>
                                    <th class="text-center">Fecha</th>
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

<!-- CENTRO DE SALUD -->
<div class="modal fade" id="Centro" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-simple">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body py-3 py-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                <div class="text-center mb-4">
                    <h3 class="mb-2">Centro de Salud</h3>
                </div>

                <form class="row g-2 needs-validation" novalidate autocomplete="off" id="FrmCenSa">
                    <h6>1. Horario de Entrada y Salida</h6>
                    <hr class="mt-0" />

                    <div class="col-md-4 col-12">
                        <div class="form-floating form-floating-outline">
                            <input type="time" class="form-control" placeholder="HH:MM" id="Etime" name="Etime" required />
                            <label for="Etime">Entrada</label>
                        </div>
                    </div>

                    <div class="col-md-4 col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="time" class="form-control" placeholder="HH:MM" id="Stime" name="Stime" required />
                            <label for="Stime">Salida</label>
                        </div>
                    </div>

                    <h6>2. Datos </h6>
                    <hr class="mt-0" />

                    <div class="col-md-6 col-12">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-hospital-building"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" placeholder="Centro de Salud" id="CenSalud" name="CenSalud" required />
                                <label for="CenSalud">Centro de Salud</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-doctor"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" placeholder="Nombre del Doctor" id="NomDoc" name="NomDoc" required />
                                <label for="NomDoc">Nombre del Doctor</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-12 mb-4">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-clock-time-nine-outline"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" placeholder="Tiempo de Visita" id="TimeVis" name="TimeVis" required />
                                <label for="TimeVis">Tiempo de Visita</label>
                            </div>
                        </div>
                    </div>

                    <h6>3. Dessarrollo y Conclusiones </h6>
                    <hr class="mt-0" />

                    <div class="col-md-6 col-12">
                        <div class="form-floating form-floating-outline mb-4">
                            <textarea name="Desarrollo" id="Desarrollo" class="form-control h-px-100" placeholder="Desarrollo" required></textarea>
                            <label for="Desarrollo">Desarrollo</label>
                        </div>
                    </div>

                    <div class="col-md-6 col-12 mb-4">
                        <div class="form-floating form-floating-outline mb-4">
                            <textarea name="Conclusion" id="Conclusion" class="form-control h-px-100" placeholder="Conclusiones" required></textarea>
                            <label for="Conclusion">Conclusiones</label>
                        </div>
                    </div>

                    <h6>4. Datos Referencias </h6>
                    <hr class="mt-0" />

                    <div class="col-md-6 col-12">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-email-check"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" placeholder="Correo Electrónico" id="Correo" name="Correo" />
                                <label for="Correo">Correo Electrónico</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-phone"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" placeholder="Celular" id="Celular" name="Celular" />
                                <label for="Celular">Celular</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="FechaNac" name="FechaNac" placeholder="YYYY-MM-DD">
                            <label for="FechaNac">Fecha de Nacimiento</label>
                        </div>
                    </div>

                    <div class="col-md-6"></div>

                    <div class="col-md-4" id="DivVisme">
                        <button type="submit" id="btnVisme" class="btn btn-primary">Registrar</button>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>
<!-- /CENTRO DE SALUD -->


<!-- ORTOPEDIA -->
<div class="modal fade" id="OrtopediaModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-simple">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body py-3 py-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                <div class="text-center mb-4">
                    <h3 class="mb-2">Ortopedia</h3>
                </div>

                <form class="row g-2 needs-validation" novalidate autocomplete="off" id="FrmOR">
                    <h6>1. Horario de Entrada y Salida</h6>
                    <hr class="mt-0" />

                    <div class="col-md-4 col-12">
                        <div class="form-floating form-floating-outline">
                            <input type="time" class="form-control" placeholder="HH:MM" id="EtimeOr" name="EtimeOr" required />
                            <label for="EtimeOr">Entrada</label>
                        </div>
                    </div>

                    <div class="col-md-4 col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="time" class="form-control" placeholder="HH:MM" id="StimeOr" name="StimeOr" required />
                            <label for="StimeOr">Salida</label>
                        </div>
                    </div>

                    <h6>2. Datos </h6>
                    <hr class="mt-0" />

                    <div class="col-md-6 col-12">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-hospital-building"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" placeholder="Tienda de Ortopedia" id="Tienda" name="Tienda" required />
                                <label for="Tienda">Tienda de Ortopedia</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-doctor"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" placeholder="Nombre del Encargado" id="NomEnc" name="NomEnc" required />
                                <label for="NomEnc">Nombre del Encargador</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-12 mb-4">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-clock-time-nine-outline"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" placeholder="Tiempo de Visita" id="TimeOr" name="TimeOr" required />
                                <label for="TimeOr">Tiempo de Visita</label>
                            </div>
                        </div>
                    </div>

                    <h6>3. Dessarrollo y Conclusiones </h6>
                    <hr class="mt-0" />

                    <div class="col-md-6 col-12">
                        <div class="form-floating form-floating-outline mb-4">
                            <textarea name="DesarrolloOr" id="DesarrolloOr" class="form-control h-px-100" placeholder="Desarrollo" required></textarea>
                            <label for="DesarrolloOr">Desarrollo</label>
                        </div>
                    </div>

                    <div class="col-md-6 col-12 mb-4">
                        <div class="form-floating form-floating-outline mb-4">
                            <textarea name="ConclusionOr" id="ConclusionOr" class="form-control h-px-100" placeholder="Conclusiones" required></textarea>
                            <label for="ConclusionOr">Conclusiones</label>
                        </div>
                    </div>

                    <h6>4. Datos Referencias </h6>
                    <hr class="mt-0" />

                    <div class="col-md-6 col-12">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-email-check"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" placeholder="Correo Electrónico" id="CorreoOr" name="CorreoOr" />
                                <label for="CorreoOr">Correo Electrónico</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-phone"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" placeholder="Celular" id="CelularOr" name="CelularOr" />
                                <label for="CelularOr">Celular</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="Ruc" name="Ruc" placeholder="RUC">
                            <label for="Ruc">RUC</label>
                        </div>
                    </div>

                    <div class="col-md-6"></div>

                    <div class="col-md-4" id="divOr">
                        <button type="submit" id="btnOr" class="btn btn-primary">Registrar</button>
                    </div>


                </form>

            </div>
        </div>
    </div>
</div>
<!-- /ORTOPEDIA -->

<?php include "Views/templates/footer.php"; ?>