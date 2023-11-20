<?php include "Views/templates/header.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-2"><span class="text-muted fw-light"><?php echo $data['get']['NOMBRES'] ?> -</span> <?php echo $data['get']['SUB_TRAB'] ?></h4>
    <input type="hidden" id="IDBAse" value="<?php echo $data['get']['ID'] ?>" readonly>
    <button class="btn btn-dark" id="btnModal">Agregar Documento</button>

    <hr>

    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="invoice-list-table table" id="TblListaDocumentos">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">Nombre del Documento</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

</div>

<div class="modal modal-top fade show" data-bs-backdrop="static" data-bs-keyboard="false" id="ModalDocumentos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="modal-content needs-validation" novalidate autocomplete="off" id="FrmDocumentos">
            <div class="modal-header">
                <h3 class="mb-2">Registrar Documento</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <hr>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="Id_BaseDoc" class="form-control" value="<?php echo $data['get']['ID'] ?>" readonly>
                    <div class="col-md-6">
                        <label for="NombreDoc" class="form-label">Nombre del Documento</label>
                        <input type="text" class="form-control" id="NombreDoc" name="NombreDoc" placeholder="Nombre del Documento" />

                    </div>
                    <div class="col-md-6">
                        <label for="file" class="form-label">Comprobante (Max. 256Mb)</label>
                        <input type="file" accept="image/*, .pdf" class="form-control" name="file" id="file" size="268435456">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-dark" id="btnDocumentoRegistro">Subir Archivo</button>
            </div>
        </form>
    </div>
</div>


<?php include "Views/templates/footer.php"; ?>