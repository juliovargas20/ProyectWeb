<?php include "Views/templates/header.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- DataTable with Buttons -->
    <div class="card mb-5" id="CardTablaUsuario">
        <div class="card-datatable table-responsive pt-0">
            <table id="TblUsuarios" class="table table-striped nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombres y Apellidos</th>
                        <th class="text-center">Correo</th>
                        <th class="text-center">Rol</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody id="BodyUsuarios">

                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="modal fade" id="ModalUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body py-3 py-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">Información del Usuario</h3>
                </div>
                <form id="FrmUsuario" class="row g-4">
                    <input type="hidden" class="form-control" name="IdUsuario" id="IdUsuario">
                    <div class="col-md-6">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-account-outline me-1"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="Nombres" id="Nombres" placeholder="Nombres y Apellidos" aria-label="Nombres y Apellidos" aria-describedby="Nombres" required />
                                <label for="Nombres">Nombres y Apellidos</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-email-outline me-1"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Correo Electrónico" aria-label="email" aria-describedby="email" required />
                                <label for="email">Correo Electrónico</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-password-toggle">
                            <div class="input-group input-group-merge">
                                <div class="form-floating form-floating-outline">
                                    <input type="password" class="form-control" name="clave" id="clave" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="clave" required />
                                    <label for="clave">Contraseña</label>
                                </div>
                                <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                            <select id="Rol" name="Rol" class="form-select" data-allow-clear="true">
                                <option selected disabled>Seleccione el tipo de Rol</option>
                                <?php foreach ($data['caja'] as $row) { ?>
                                    <option value="<?php echo $row['ID'] ?>"><?php echo $row['CAJA'] ?></option>
                                <?php } ?>
                            </select>
                            <label for="Rol">Tipo de Rol</label>
                        </div>
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1" id="BtnGuardatUsuario">Guardar</button>
                        <button type="reset" class="btn btn-outline-danger" data-bs-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "Views/templates/footer.php"; ?>