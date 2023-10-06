<?php include "Views/templates/header.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Proyectos de Innovación /</span> Enumeración</h4>

    <div class="col-xxl">
        <div class="card">
            <div class="card-header">
                <h4>Formulario para la Enumeración De Proyectos</h4>
            </div>
            <div class="card-body">
                <form action="">

                    <div class="row mb-2">
                        <label for="" class="col-sm-2 col-form-label">Título del Proyecto</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="" class="col-sm-2 col-form-label">Nivel de Necesidad</label>
                        <div class="col-sm-10">
                            <select name="" id="" class="form-select">
                                <option value="" disabled selected>Seleccione el Nivel de Urgencia</option>
                                <option value="Urgente">Urgente</option>
                                <option value="Importante">Importante</option>
                                <option value="Opcional">Opcional</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="" class="col-sm-2 col-form-label">Justificación del Proyecto</label>
                        <div class="col-sm-10">
                            <textarea class="form-control h-px-100"></textarea>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="" class="col-sm-2 col-form-label">Líderes del Proyecto</label>
                        <div class="col-sm-10">
                            <div class="form-floating form-floating-outline">
                                <select id="Lideres" name="Lideres" class="select2 form-select" multiple>
                                    <optgroup label="Lista de Usuarios Registrados">
                                        <?php foreach ($data['user'] as $row) { ?>
                                            <option value="<?php echo $row['ID']; ?>"><?php echo $row['NOMBRES']; ?></option>
                                        <?php } ?>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="" class="col-sm-2 col-form-label">Apoyo Técnico</label>
                        <div class="col-sm-10">
                            <div class="form-floating form-floating-outline">
                                <select id="Apoyo" name="Apoyo" class="select2 form-select" multiple>
                                    <optgroup label="Lista de Usuarios Registrados">
                                        <?php foreach ($data['user'] as $row) { ?>
                                            <option value="<?php echo $row['ID']; ?>"><?php echo $row['NOMBRES']; ?></option>
                                        <?php } ?>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="" class="col-sm-2 col-form-label">Presupuesto</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <span class="input-group-text">S/.</span>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="" class="col-sm-2 col-form-label">Tiempo</label>
                        <div class="col-sm-10">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" placeholder="YYYY-MM-DD / YYYY-MM-DD" id="flatpickr-range" />
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-end"">
                        <div class="col-sm-10">
                            <button type="button" onclick="Prueba();" class="btn btn-primary">Solicitar Enumeración</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

</div>


<?php include "Views/templates/footer.php"; ?>