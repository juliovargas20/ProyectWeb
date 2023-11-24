<?php include "Views/templates/header.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Ordenes Internas/ </span> Orden de Trabajo </h4>
    <button id="btnModal" class="btn btn-outline-warning">Lista de Ordenes</button>
    <hr>

    <div class="row">

        <div class="col-2"></div>

        <div class="col-8">
            <div class="card">
                <h5 class="card-header">Formulario Orden de Trabajo</h5>
                <div class="card-body">
                    <form id="FrmOT" class="needs-validation" autocomplete="off" novalidate>
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select" name="Necesidad" required>
                                <option value="" disabled selected>Seleccione---></option>
                                <option value="URGENTE">URGENTE</option>
                                <option value="IMPORTANTE">IMPORTANTE</option>
                                <option value="PENDIENTE">PENDIENTE</option>
                            </select>
                            <label class="form-label" for="">Nivel de Necesidad</label>
                            <div class="valid-feedback"> Correcto! </div>
                            <div class="invalid-feedback"> Por Favor seleccione el nivel de necesidad </div>
                        </div>
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select" name="Req_P" required>
                                <option value="" disabled selected>Seleccione---></option>
                                <option value="Biomecánica">Biomecánica</option>
                                <option value="Ingeniería M.S.">Ingeniería M.S.</option>
                                <option value="Producción">Producción</option>
                                <option value="Sistemas">Sistemas</option>
                                <option value="Administración">Administración</option>
                                <option value="Recursos Humanos">Recursos Humanos</option>
                                <option value="Logística">Logística</option>
                                <option value="Ingeniería M.I.">Ingeniería M.I.</option>
                                <option value="Anaplastología">Anaplastología</option>
                                <option value="Diseño">Diseño</option>
                                <option value="Limpieza">Limpieza</option>
                                <option value="Textil">Textil</option>
                                <option value="Desarrollo Tecnológico">Desarrollo Tecnológico</option>
                            </select>
                            <label class="form-label" for="">Requerido Por</label>
                            <div class="valid-feedback"> Correcto! </div>
                            <div class="invalid-feedback"> Por Favor seleccione area requerida </div>
                        </div>
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="text" class="form-control" placeholder="Aprovado Por" name="Aprobado" required />
                            <label for="">Aprobado Por</label>
                            <div class="valid-feedback"> Correcto! </div>
                            <div class="invalid-feedback"> Por favor ingrese el nombre Aprobado </div>
                        </div>
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="text" class="form-control" placeholder="Actividad a Realizar" name="Actividad" required />
                            <label for="">Actividad a Realizar</label>
                            <div class="valid-feedback"> Correcto! </div>
                            <div class="invalid-feedback"> Por favor ingrese la actividad </div>
                        </div>
                        <div class="form-floating form-floating-outline mb-4">
                            <textarea class="form-control h-px-75" name="Descripcion"  placeholder="Descripción del Problema" required></textarea>
                            <label for="">Descripción del Problema</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select" name="Req_A" required>
                                <option value="" disabled selected>Seleccione---></option>
                                <option value="Biomecánica">Biomecánica</option>
                                <option value="Ingeniería M.S.">Ingeniería M.S.</option>
                                <option value="Producción">Producción</option>
                                <option value="Sistemas">Sistemas</option>
                                <option value="Administración">Administración</option>
                                <option value="Recursos Humanos">Recursos Humanos</option>
                                <option value="Logística">Logística</option>
                                <option value="Ingeniería M.I.">Ingeniería M.I.</option>
                                <option value="Anaplastología">Anaplastología</option>
                                <option value="Diseño">Diseño</option>
                                <option value="Limpieza">Limpieza</option>
                                <option value="Textil">Textil</option>
                                <option value="Desarrollo Tecnológico">Desarrollo Tecnológico</option>
                            </select>
                            <label class="form-label" for="">Requerido A</label>
                            <div class="valid-feedback"> Correcto! </div>
                            <div class="invalid-feedback"> Por Favor seleccione area requerida </div>
                        </div>
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="text" class="form-control" placeholder="Responsable de la Ejecución" name="Responsable" required />
                            <label for="">Responsable de la Ejecución</label>
                            <div class="valid-feedback"> Correcto! </div>
                            <div class="invalid-feedback"> Por favor ingrese el nombre Responsable </div>
                        </div>
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="date" class="form-control" placeholder="Fecha o Tiempo de Ejecución" name="Tiempo" required />
                            <label for="">Fecha o Tiempo de Ejecución</label>
                            <div class="valid-feedback"> Correcto! </div>
                            <div class="invalid-feedback"> Por favor ingrese la fecha </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button id="btnOT" type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal modal-top fade show" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" id="BuscarOT">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="mb-4">Buscar Ordenes</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3 py-md-0">
                <div class="card-datatable table-responsive">
                    <table class="invoice-list-table table" id="TblResumenOT">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">FECHA</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



<?php include "Views/templates/footer.php"; ?>