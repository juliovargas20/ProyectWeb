<?php include "Views/templates/header.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gestión de usuarios / </span> Roles y Permisos </h4>
    <!-- DataTable with Buttons -->
    <div class="card mb-5" id="CardTablaUsuario">
        <div class="card-datatable table-responsive pt-0">
            <table id="TblRoles" class="table table-striped nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Nombres</th>
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

<?php include "Views/templates/footer.php"; ?>