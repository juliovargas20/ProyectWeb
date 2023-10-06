<?php include "Views/templates/header.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gestión de Usuarios / Roles y Permisos / </span> Modificar </h4>
    <!-- DataTable with Buttons -->
    <div class="col-12">
        <div class="card">
            <h5 class="card-header">Registro de Roles y Pacientes</h5>
            <div class="card-body">

                <form id="FrmUpdateRol" class="row g-2 mb-3 needs-validation" novalidate autocomplete="off">
                    <div class="col-12">
                        <h6 class="fw-semibold">1. Roles</h6>
                        <hr class="mt-0" />
                    </div>

                    <div class="col-md-12">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-account-key-outline me-sm-1"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="hidden" class="form-control" name="idROl" id="idROl"  value="<?php echo $data['id']?>"/>
                                <input type="text" class="form-control" name="Nombre" id="Nombre" placeholder="Nombre del nuevo Rol" value="<?php echo $data['caja']['CAJA'] ?>" required />
                                <label for="Nombre">Nombre del nuevo Rol</label>
                            </div>
                        </div>
                    </div>
                </form>

                <form id="FrmUpdatePermiso" class="row g-3 needs-validation" novalidate autocomplete="off">
                    <div class="col-12">
                        <h6 class="fw-semibold">2. Permisos</h6>
                        <hr class="mt-0" />
                    </div>

                    <?php foreach ($data['permisos'] as $row) { ?>
                        <div class="col-sm-3">
                            <label class="switch">
                                <input type="checkbox" name="permisos[]" id="permisos" class="switch-input" value="<?php echo $row['ID'] ?>" <?php echo isset($data['asignados'][$row['ID']]) ? 'checked' : '' ;?> >
                                <span class="switch-toggle-slider">
                                    <span class="switch-on"></span>
                                    <span class="switch-off"></span>
                                </span>
                                <span class="switch-label"><?php echo $row['PERMISO'] ?></span>
                            </label>
                        </div>
                    <?php } ?>

                    <div class="col-12 mt-4">
                        <button id="BtnUpdateRolPer" class="btn btn-success">Guardar</button>
                        <button id="BtnCancelRolPer" class="btn btn-outline-danger" data-bs-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


<?php include "Views/templates/footer.php"; ?>