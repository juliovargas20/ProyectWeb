<?php include "Views/templates/header.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gestión de Pacientes / Listado de Pacientes / </span> Modificar </h4>

    <!-- Form Paciente -->
    <div class="col-12">
        <div class="card">
            <h5 class="card-header">Modificar de Paciente</h5>
            <div class="card-body">

                <form id="FrmModificarPaciente" class="row g-3 needs-validation" novalidate autocomplete="off">
                    <!-- Datos Personales -->
                    <div class="col-12">
                        <h6 class="fw-semibold">1. Datos Personales</h6>
                        <hr class="mt-0" />
                    </div>
                    <input type="hidden" class="form-control" name="IDPaciente" id="IDPaciente" value="<?php echo $data['id']; ?>" readonly/>
                    <div class="col-md-4">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-account-plus me-sm-1"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="Nombres" id="Nombres" placeholder="Nombres y Apellidos" required/>
                                <label for="Nombres">Nombres y Apellidos</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-card-account-details me-sm-1"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="DNI" id="DNI" placeholder="DNI - C.E." required/>
                                <label for="DNI">DNI - C.E.</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select" name="Genero" id="Genero" required>
                                <option value="" disabled selected>Seleccionar</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                            </select>
                            <label for="Genero">Género</label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-account-check me-sm-1"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="number" class="form-control" name="Edad" id="Edad" placeholder="18" required/>
                                <label for="Edad">Edad</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-phone me-sm-1"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="number" class="form-control" name="Celular" id="Celular" placeholder="Número Telefónico" required/>
                                <label for="Celular">Celular</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating form-floating-outline mb-4">
                            <input class="form-control" type="date" id="naci" name="naci" required/>
                            <label for="html5-date-input">Fecha Nacimiento</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-city me-sm-1"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="Direccion" id="Direccion" placeholder="Dirección" required/>
                                <label for="Direccion">Dirección</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select" name="Sede" id="Sede" required>
                                <option value="" disabled selected>Seleccionar</option>
                                <option value="Lima">Lima</option>
                                <option value="Arequipa">Arequipa</option>
                                <option value="Chiclayo">Chiclayo</option>
                            </select>
                            <label for="Sede">Sede</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-map-marker me-sm-1"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="Locacion" id="Locacion" placeholder="Locación" required/>
                                <label for="Locacion">Locación</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-email me-sm-1"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Correo Electrónico" />
                                <label for="email">Correo Electrónico</label>
                            </div>
                        </div>
                    </div>

                    <!-- Datos Técnicos -->
                    <div class="col-12">
                        <h6 class="mt-2 fw-semibold">2. Datos Técnicos</h6>
                        <hr class="mt-0" />
                    </div>
                    <div class="col-md-2">
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select" name="Estado" id="Estado"required>
                                <option value="" disabled selected>Seleccionar</option>
                                <option value="Contrato">Contrato</option>
                                <option value="Cotización">Cotización</option>
                                <option value="Donación">Donación</option>
                                <option value="Accesorios">Accesorios</option>
                            </select>
                            <label for="Estado">Estado</label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select" name="Canal" id="Canal" required>
                                <option value="" disabled selected>Seleccionar</option>
                                <option value="Facebook">Facebook</option>
                                <option value="Youtube">Youtube</option>
                                <option value="TikTok">TikTok</option>
                                <option value="Recomendación">Recomendación</option>
                                <option value="Página Web">Página Web</option>
                                <option value="Instagram">Instagram</option>
                            </select>
                            <label for="Canal">Canal</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-clock-time-eight-outline me-sm-1"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="TiemA" id="TiemA" placeholder="Tiempo de Amputación" required/>
                                <label for="TiemA">Tiempo de Amputación</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-sync-alert me-sm-1"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="Motivo" id="Motivo" placeholder="Motivo de Amputación" required/>
                                <label for="Motivo">Motivo de Amputación</label>
                            </div>
                        </div>
                    </div>

                    <!-- Datos Médicos -->

                    <div class="col-12">
                        <h6 class="mt-2 fw-semibold">3. Datos Médicos</h6>
                        <hr class="mt-0" />
                    </div>

                    <div class="col-md-5">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-doctor me-sm-1"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="Afecc" id="Afecc" placeholder="Afecciones Médicas" />
                                <label for="Afecc">Afecciones Médicas</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-doctor me-sm-1"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="Alergia" id="Alergia" placeholder="Alergias" />
                                <label for="Alergia">Alergias</label>
                            </div>
                        </div>
                    </div>

                    <!-- Observaciones -->

                    <div class="col-12">
                        <h6 class="mt-2 fw-semibold">4. Observaciones</h6>
                        <hr class="mt-0" />
                    </div>

                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-4">
                            <textarea class="form-control h-px-100" id="Obs" name="Obs" placeholder="Observaciones"></textarea>
                            <label for="Obs">Observaciones</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" id="BtnModificarPaciente" class="btn btn-success">Guardar</button>
                        <button type="reset" class="btn btn-outline-danger" data-bs-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- /Form Paciente -->
</div>


<?php include "Views/templates/footer.php"; ?>