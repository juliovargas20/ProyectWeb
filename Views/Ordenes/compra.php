<?php include "Views/templates/header.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Ordenes Internas /</span> Orden de Compra</h4>

    <button id="BtnOCModal" type="button" class="btn btn-outline-warning waves-effect">Lista de Ordenes</button>

    <hr>

    <div class="card mb-4">
        <h5 class="card-header">Agregar Compras</h5>
        <form class="card-body" id="FrmOC">
            <div class="row g-3">
                <div class="col-md-2">
                    <div class="form-floating">
                        <input type="text" class="form-control" placeholder="Cantidad" id="CantidadOC" name="CantidadOC" pattern="[0-9]+([\.,][0-9]+)?" title="Ingrese un número válido">
                        <label for="">Cantidad</label>
                        <span class="form-floating-focused"></span>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-floating">
                        <input type="text" class="form-control" placeholder="Descripcion" id="DesOC" name="DesOC">
                        <label for="">Descripcion</label>
                        <span class="form-floating-focused"></span>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating">
                        <select name="UniOC" id="UniOC" class="form-select">
                            <option value="" selected disabled>----</option>
                            <option value="kg.">kg.</option>
                            <option value="unid.">unid.</option>
                        </select>
                        <label for="">Unidades</label>
                        <span class="form-floating-focused"></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group input-group-floating">
                        <span class="input-group-text">S/.</span>
                        <div class="form-floating">
                            <input type="text" class="form-control" placeholder="Precio U." id="PrecioOC" name="PrecioOC" pattern="[0-9]+([\.,][0-9]+)?" title="Ingrese un número válido">
                            <label for="">Precio U.</label>
                        </div>
                        <span class="form-floating-focused"></span>
                    </div>
                </div>
            </div>
            <div class="pt-4">
                <button type="submit" class="btn btn-primary me-sm-3 me-1">Agregar</button>
            </div>
        </form>
    </div>

    <div class="row">
        <div class="col-xl-9 col-md-8 col-12 mb-md-0 mb-4">
            <div class="card">
                <div class="table-responsive rounded-3 text-nowrap">
                    <table class="table" id="TblOC">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">Cantidad</th>
                                <th style="width: 300px;">Descripción</th>
                                <th class="text-center">Unidades</th>
                                <th class="text-center">Precio U.</th>
                                <th class="text-center">Sub-Total</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0" id="TblbodyOC">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-4 col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text">S/.</span>
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="OCTotal" name="OCTotal" readonly placeholder="Total" required />
                            <label for="Total">Total</label>
                        </div>
                    </div>
                    <br>
                    <div class="form-floating form-floating-outline">
                        <select class="form-select" name="Area" id="Area">
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
                        <label for="Area">Area</label>
                    </div>
                    <br>
                    <div class="form-floating form-floating-outline">
                        <select class="form-select" name="Necesidad" id="Necesidad">
                            <option value="Urgente">Urgente</option>
                            <option value="Importante">Importante</option>
                            <option value="Pendiente">Pendiente</option>
                        </select>
                        <label for="Necesidad">Necesidad</label>
                    </div>
                    <br>
                    <div class="form-floating form-floating-outline mb-4">
                        <textarea class="form-control h-px-100" id="Concepto" name="Concepto"  placeholder="Concepto"></textarea>
                        <label for="Concepto">Concepto</label>
                    </div>

                    <button id="btnGenerarOC" type="button" class="btn btn-primary d-grid w-100 mb-3">
                        <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="mdi mdi-send-outline scaleX-n1-rtl me-1"></i>Generar</span>
                    </button>
                </div>
            </div>
        </div>

    </div>

</div>

<div class="modal modal-top fade show" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" id="BuscarOC">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="mb-4">Buscar Recibos</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-3 py-md-0">
        <div class="card-datatable table-responsive">
          <table class="invoice-list-table table" id="TblResumenOC">
            <thead class="table-light">
              <tr>
                <th class="text-center">ID</th>
                <th class="text-center">FECHA</th>
                <th class="text-center">AREA</th>
                <th>CONCEPTO</th>
                <th class="text-center">MONTO</th>
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