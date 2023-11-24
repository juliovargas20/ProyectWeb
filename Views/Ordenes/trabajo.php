<?php include "Views/templates/header.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Ordenes Internas/ </span> Orden de Trabajo </h4>
    <hr>

    <div class="row">

        <div class="col-2"></div>

        <div class="col-8">
            <div class="card">
                <h5 class="card-header">Formulario Orden de Trabajo</h5>
                <div class="card-body">
                    <form id="FrmOT" class="needs-validation" autocomplete="off" novalidate>
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select" id="" required>
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
                            <select class="form-select" id="" required>
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
                            </select>
                            <label class="form-label" for="">Requerido Por</label>
                            <div class="valid-feedback"> Correcto! </div>
                            <div class="invalid-feedback"> Por Favor seleccione area requerida </div>
                        </div>
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="text" class="form-control" placeholder="Aprovado Por" id="" required />
                            <label for="">Aprovado Por</label>
                            <div class="valid-feedback"> Correcto! </div>
                            <div class="invalid-feedback"> Por favor ingrese el nombre Aprobado </div>
                        </div>
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="text" class="form-control" placeholder="Actividad a Realizar" id="" required />
                            <label for="">Actividad a Realizar</label>
                            <div class="valid-feedback"> Correcto! </div>
                            <div class="invalid-feedback"> Por favor ingrese la actividad </div>
                        </div>
                        <div class="form-floating form-floating-outline mb-4">
                            <textarea class="form-control h-px-75" id="" name=""  placeholder="Descripción del Problema" required></textarea>
                            <label for="">Descripción del Problema</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select" id="" required>
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
                            </select>
                            <label class="form-label" for="">Requerido A</label>
                            <div class="valid-feedback"> Correcto! </div>
                            <div class="invalid-feedback"> Por Favor seleccione area requerida </div>
                        </div>
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="text" class="form-control" placeholder="Responsable de la Ejecución" id="" required />
                            <label for="">Responsable de la Ejecución</label>
                            <div class="valid-feedback"> Correcto! </div>
                            <div class="invalid-feedback"> Por favor ingrese el nombre Responsable </div>
                        </div>
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="date" class="form-control" placeholder="Fecha o Tiempo de Ejecución" id="" required />
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


<?php include "Views/templates/footer.php"; ?>