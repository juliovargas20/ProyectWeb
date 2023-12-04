<?php include "Views/templates/header.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><?php echo $data['get']['ID_PACIENTE'] ?> - <?php echo $data['get']['NOMBRES'] ?> /</span> <?php echo $data['get']['SUB_TRAB'] ?></h4>

    <input type="hidden" id="id_paciente" value="<?php echo $data['get']['ID_PACIENTE'] ?>">
    <input type="hidden" id="tip_trab" value="<?php echo $data['get']['TIP_TRAB'] ?>">
    <input type="hidden" id="sub_trab" value="<?php echo $data['get']['SUB_TRAB'] ?>">

    <div class="row">
        <div class="col-xl-9 col-md-8 col-12 mb-md-0 mb-4">
            <div class="card">
                <div class="card-header">
                    
                </div>
                <div class="card-body">
                    <form id="FrmLista" class="needs-validation" novalidate autocomplete="off">

                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-4 col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <button id="btnGenerar" class="btn btn-primary d-grid w-100 mb-3">
                        <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="mdi mdi-send-outline scaleX-n1-rtl me-1"></i>Generar</span>
                    </button>
                    <button id="btnItem" class="btn btn-success d-grid w-100">
                        <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="mdi mdi-plus me-1"></i>Agregar Item</span>
                    </button>
                </div>
            </div>
        </div>

    </div>

</div>

<div class="modal modal-top fade show" data-bs-backdrop="static" data-bs-keyboard="false" id="ModalCarta" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="mb-2">Cartas de Consentimientos</h4>
            </div>
            <div class="modal-body">
                <div class="demo-inline-spacing">
                    <button type="button" id="btnSP" class="btn btn-outline-primary waves-effect">Socket Provisional</button>
                    <button type="button" id="btnSF" class="btn btn-outline-warning waves-effect">Socket Final</button>
                    <button type="button" id="btnImage" class="btn btn-outline-success waves-effect">Uso de Imagen</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "Views/templates/footer.php"; ?>