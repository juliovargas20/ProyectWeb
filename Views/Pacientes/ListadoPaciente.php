<?php include "Views/templates/header.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gestión de Pacientes /</span> Listado de Pacientes</h4>

  <!-- DataTable with Buttons -->
  <div class="card mb-5">
    <div class="card-datatable text-nowrap">
      <table class="dt-complex-header table" id="TblListadoPacientes">
        <thead class="table-light">
          <tr>
            <th></th>
            <th class="text-center">N°</th>
            <th>Nombres</th>
            <th>DNI</th>
            <th class="text-center">Contacto</th>
            <th class="text-center">Sede</th>
            <th>Estado</th>
            <th class="text-center">Estado</th>
            <th class="text-center">Fecha</th>
            <th class="text-center">Acciones</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>

</div>

<!-- Tipo de Servicio -->
<div class="modal fade" id="TipoServicio" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-simple">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body py-3 py-md-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-2">Selecciona el Tipo de Servicio</h3>
        </div>
        <div class="row pt-1">
          <input type="hidden" id="IDTipServicio" readonly>
          <div class="col-12 mb-3">
            <div class="form-check custom-option custom-option-basic custom-option-label">
              <label class="form-check-label custom-option-content ps-4 py-3" for="customRadioTemp1" data-bs-target="#MiembroSuperior" data-bs-toggle="modal" onclick="MS();">
                <input name="customRadioTemp" class="form-check-input d-none" type="radio" value="" id="customRadioTemp1" />
                <span class="d-flex align-items-center">
                  <i class="mdi mdi-account-injury-outline mdi-36px me-3"></i>
                  <span>
                    <span class="custom-option-header">
                      <span class="h5 mb-1">Miembro Superior</span>
                    </span>
                    <span class="custom-option-body">
                      <span class="mb-0">Prótesis Transradial, Transhumeral, Mano Parcial Mecánica, Mano Completa Mecánica, etc.</span>
                    </span>
                  </span>
                </span>
              </label>
            </div>
          </div>
          <div class="col-12 mb-3">
            <div class="form-check custom-option custom-option-basic custom-option-label">
              <label class="form-check-label custom-option-content ps-4 py-3" for="customRadioTemp2" data-bs-target="#MiembroInferior" data-bs-toggle="modal" onclick="MI();">
                <input name="customRadioTemp" class="form-check-input d-none" type="radio" value="" id="customRadioTemp2" />
                <span class="d-flex align-items-center">
                  <i class="mdi mdi-wheelchair-accessibility mdi-36px me-3"></i>
                  <span>
                    <span class="custom-option-header">
                      <span class="h5 mb-1">Miembro Inferior</span>
                    </span>
                    <span class="custom-option-body">
                      <span class="mb-0">Prótesis Transtibial, Transfemoral, Cadera, Linsfrac, Chopart, etc.</span>
                    </span>
                  </span>
                </span>
              </label>
            </div>
          </div>
          <div class="col-12">
            <div class="form-check custom-option custom-option-basic custom-option-label">
              <label class="form-check-label custom-option-content ps-4 py-3" for="customRadioTemp3" onclick="EvaluacionEstetica(event);">
                <input name="customRadioTemp" class="form-check-input d-none" type="radio" value="" id="customRadioTemp3" />
                <span class="d-flex align-items-center">
                  <i class="mdi mdi-allergy mdi-36px me-3"></i>
                  <span>
                    <span class="custom-option-header">
                      <span class="h5 mb-1">Estética</span>
                    </span>
                    <span class="custom-option-body">
                      <span class="mb-0">Prótesis de Microtia, Falange, Mamas, etc.</span>
                    </span>
                  </span>
                </span>
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /Tipo de Servicio -->

<!-- Tipo de Servicio - Miembro Superior -->
<div class="modal fade" id="MiembroSuperior" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-simple">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body py-3 py-md-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-0">Miembro Superior</h3>
        </div>
        <div class="row pt-1">
          <input type="hidden" id="IDTip" readonly>
          <div class="col-6 mb-3">
            <div class="form-check custom-option custom-option-basic custom-option-label">
              <label class="form-check-label custom-option-content ps-4 py-3" for="" onclick="EvaluacionManoParcial();">
                <input name="customRadioTemp" class="form-check-input d-none" type="radio" value="" id="customRadioTemp1" />
                <span class="d-flex align-items-center">
                  <i class="mdi mdi-account-injury-outline mdi-36px me-3"></i>
                  <span>
                    <span class="custom-option-header">
                      <span class="h5 mb-1">Mano Parcial</span>
                    </span>
                    <span class="custom-option-body">
                      <span class="mb-0">Mano Parcial Mecánica, Mano Parcial Biónica, Mano Parcial de articulación Manual</span>
                    </span>
                  </span>
                </span>
              </label>
            </div>
          </div>
          <div class="col-6 mb-3">
            <div class="form-check custom-option custom-option-basic custom-option-label">
              <label class="form-check-label custom-option-content ps-4 py-3" for="">
                <input name="customRadioTemp" class="form-check-input d-none" type="radio" value="" id="customRadioTemp1" />
                <span class="d-flex align-items-center">
                  <i class="mdi mdi-account-injury-outline mdi-36px me-3"></i>
                  <span>
                    <span class="custom-option-header">
                      <span class="h5 mb-1">Falange Mecánica</span>
                    </span>
                  </span>
                </span>
              </label>
            </div>
          </div>
          <div class="col-6 mb-3">
            <div class="form-check custom-option custom-option-basic custom-option-label">
              <label class="form-check-label custom-option-content ps-4 py-3" for="" onclick="EvaluacionTransradial();">
                <input name="customRadioTemp" class="form-check-input d-none" type="radio" value="" id="customRadioTemp1" />
                <span class="d-flex align-items-center">
                  <i class="mdi mdi-account-injury-outline mdi-36px me-3"></i>
                  <span>
                    <span class="custom-option-header">
                      <span class="h5 mb-1">Transradial</span>
                    </span>
                    <span class="custom-option-body">
                      <span class="mb-0">Protesis Transradial mecánica de TPU, Protesis transradial tipo gancho con guante cosmético, Mano Completo Biónica</span>
                    </span>
                  </span>
                </span>
              </label>
            </div>
          </div>
          <div class="col-6 mb-3">
            <div class="form-check custom-option custom-option-basic custom-option-label">
              <label class="form-check-label custom-option-content ps-4 py-3" for="">
                <input name="customRadioTemp" class="form-check-input d-none" type="radio" value="" id="customRadioTemp1" />
                <span class="d-flex align-items-center">
                  <i class="mdi mdi-account-injury-outline mdi-36px me-3"></i>
                  <span>
                    <span class="custom-option-header">
                      <span class="h5 mb-1">Transhumeral</span>
                    </span>
                    <span class="custom-option-body">
                      <span class="mb-0">Protesis transhumeral tipo gancho con guante cosmético</span>
                    </span>
                  </span>
                </span>
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /Tipo de Servicio - Miembro Superior -->


<!-- Tipo de Servicio - Miembro Inferior -->
<div class="modal fade" id="MiembroInferior" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-simple">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body py-3 py-md-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-0">Miembro Inferior</h3>
        </div>
        <div class="row pt-1">
          <input type="hidden" id="IDTipI" readonly>
          <div class="col-6 mb-3">
            <div class="form-check custom-option custom-option-basic custom-option-label">
              <label class="form-check-label custom-option-content ps-4 py-3" for="" onclick="EvaluacionTransfemoral();">
                <input name="customRadioTemp" class="form-check-input d-none" type="radio" value="" id="customRadioTemp1" />
                <span class="d-flex align-items-center">
                  <i class="mdi mdi-wheelchair-accessibility mdi-36px me-3"></i>
                  <span>
                    <span class="custom-option-header">
                      <span class="h5 mb-1">Protesis Transfemoral o Desarticulado de Rodilla</span>
                    </span>

                  </span>
                </span>
              </label>
            </div>
          </div>
          <div class="col-6 mb-3">
            <div class="form-check custom-option custom-option-basic custom-option-label">
              <label class="form-check-label custom-option-content ps-4 py-3" for="" onclick="EvaluacionTranstibial();">
                <input name="customRadioTemp" class="form-check-input d-none" type="radio" value="" id="customRadioTemp1" />
                <span class="d-flex align-items-center">
                  <i class="mdi mdi-wheelchair-accessibility mdi-36px me-3"></i>
                  <span>
                    <span class="custom-option-header">
                      <span class="h5 mb-1">Protesis Transtibial o Syme</span>
                    </span>

                  </span>
                </span>
              </label>
            </div>
          </div>
          <div class="col-6 mb-3">
            <div class="form-check custom-option custom-option-basic custom-option-label">
              <label class="form-check-label custom-option-content ps-4 py-3" for="" onclick="EvaluacionCadera();">
                <input name="customRadioTemp" class="form-check-input d-none" type="radio" value="" id="customRadioTemp1" />
                <span class="d-flex align-items-center">
                  <i class="mdi mdi-wheelchair-accessibility mdi-36px me-3"></i>
                  <span>
                    <span class="custom-option-header">
                      <span class="h5 mb-1">Desarticulado de Cadera</span>
                    </span>

                  </span>
                </span>
              </label>
            </div>
          </div>
          <div class="col-6 mb-3">
            <div class="form-check custom-option custom-option-basic custom-option-label">
              <label class="form-check-label custom-option-content ps-4 py-3" for="">
                <input name="customRadioTemp" class="form-check-input d-none" type="radio" value="" id="customRadioTemp1" />
                <span class="d-flex align-items-center">
                  <i class="mdi mdi-wheelchair-accessibility mdi-36px me-3"></i>
                  <span>
                    <span class="custom-option-header">
                      <span class="h5 mb-1">Amputación de Pie</span>
                    </span>
                    <span class="custom-option-body">
                      <span class="mb-0">Protesis Chopart, Protesis Linsfrack, Metatarsal</span>
                    </span>
                  </span>
                </span>
              </label>
            </div>
          </div>
          <div class="col-6 mb-3">
            <div class="form-check custom-option custom-option-basic custom-option-label">
              <label class="form-check-label custom-option-content ps-4 py-3" for="" onclick="EvaluacionBiTransfemoral();">
                <input name="customRadioTemp" class="form-check-input d-none" type="radio" value="" id="customRadioTemp1" />
                <span class="d-flex align-items-center">
                  <i class="mdi mdi-wheelchair-accessibility mdi-36px me-3"></i>
                  <span>
                    <span class="custom-option-header">
                      <span class="h5 mb-1">Bilateral Transfemoral</span>
                    </span>

                  </span>
                </span>
              </label>
            </div>
          </div>
          <div class="col-6 mb-3">
            <div class="form-check custom-option custom-option-basic custom-option-label">
              <label class="form-check-label custom-option-content ps-4 py-3" for="" onclick="EvaluacionBiTranstibial();">
                <input name="customRadioTemp" class="form-check-input d-none" type="radio" value="" id="customRadioTemp1" />
                <span class="d-flex align-items-center">
                  <i class="mdi mdi-wheelchair-accessibility mdi-36px me-3"></i>
                  <span>
                    <span class="custom-option-header">
                      <span class="h5 mb-1">Bilateral Transtibial</span>
                    </span>

                  </span>
                </span>
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /Tipo de Servicio - Miembro Inferior -->




<div class="modal modal-top fade show" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" id="BuscarRecibos">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="mb-4">Buscar Recibos</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-3 py-md-0">
        <div class="card-datatable table-responsive">
          <table class="invoice-list-table table" id="TblAccRecibo">
            <thead class="table-light">
              <tr>
                <th class="text-center">N° Paciente</th>
                <th>Nombres</th>
                <th class="text-center">Tipo de Pago</th>
                <th class="text-center">Pago</th>
                <th class="text-center">Monto</th>
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