<?php include "Views/templates/header.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gestión de Pacientes / Historial / </span>Listado de Pacientes</h4>

    <div class="card">
        <div class="card-datatable table-responsive">
            <input type="hidden" class="form-control" name="url" id="url" readonly value="<?php echo $data['cod']; ?>">
            <table class="invoice-list-table table table-hover" id="TblPr">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th class="text-center">ID</th>
                        <th>NOMBRES</th>
                        <th class="text-center">Servicio</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<?php include "Views/templates/footer.php"; ?>