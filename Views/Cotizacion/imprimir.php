<!DOCTYPE html>

<html lang="es-pe" class="light-style" dir="ltr" data-theme="theme-default" data-assets-path="<?php echo BASE_URL . 'Assets/'; ?>" data-template="vertical-menu-template">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Cotización</title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="<?php echo BASE_URL . 'Assets/img/favicon/favicon.ico'; ?>" />

  <!-- Fonts -->
  <link href="<?php echo BASE_URL . 'Assets/vendor/fonts/fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap'; ?>" rel="stylesheet" />

  <!-- Icons -->
  <link rel="stylesheet" href="<?php echo BASE_URL . 'Assets/vendor/fonts/materialdesignicons.css'; ?>" />
  <link rel="stylesheet" href="<?php echo BASE_URL . 'Assets/vendor/fonts/fontawesome.css'; ?>" />
  <!-- Menu waves for no-customizer fix -->
  <link rel="stylesheet" href="<?php echo BASE_URL . 'Assets/vendor/libs/node-waves/node-waves.css'; ?>" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="<?php echo BASE_URL . 'Assets/vendor/css/rtl/core.css'; ?>" class="template-customizer-core-css" />
  <link rel="stylesheet" href="<?php echo BASE_URL . 'Assets/vendor/css/rtl/theme-default.css'; ?>" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="<?php echo BASE_URL . 'Assets/css/demo.css'; ?>" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="<?php echo BASE_URL . 'Assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css'; ?>" />
  <link rel="stylesheet" href="<?php echo BASE_URL . 'Assets/vendor/libs/typeahead-js/typeahead.css'; ?>" />


  <!-- Helpers -->
  <script src="<?php echo BASE_URL . 'Assets/vendor/js/helpers.js'; ?>"></script>

  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
  <script src="<?php echo BASE_URL . 'Assets/vendor/js/template-customizer.js'; ?>"></script>
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="<?php echo BASE_URL . 'Assets/js/config.js'; ?>"></script>
</head>

<body>
  <!-- Content -->

  <div class="invoice-print p-2">

    <div class="d-flex justify-content-between flex-row">
      <div class="mb-1 mt-2">
        <div class="d-flex align-items-center gap-2 mb-4">
          <img src="<?php echo BASE_URL . 'Assets/img/encabezado.png' ?>" alt="" width="200">
        </div>
      </div>

      <div>
        <h5><strong>KYP - BIOINGEN S.A.C</strong></h5>
        <ul class="list-unstyled mt-2">
          <li style="font-size: 12px;">RUC: 20600880081</li>
          <li style="font-size: 12px;">Cal. Max Palma Arrúe Nro. 1117</li>
          <li style="font-size: 12px;"><strong>Cel:</strong> +51 922 578 858</li>
          <li style="font-size: 12px;"><strong>Email:</strong> administración@kypbioingenieria.com</li>
          <li style="font-size: 12px;">www.kypbioingenieria.com</li>
        </ul>

      </div>

    </div>

    <div class="d-flex justify-content-between mb-2">
      <div class="my-2">
        <h5><strong>Paciente:</strong></h5>
        <p class="mb-1"><strong><?php echo $data['get']['NOMBRES'] ?></strong></p>
        <p class="mb-1" style="font-size: 12px;"><strong>Dirección:</strong> <?php echo $data['get']['DIRECCION'] ?></p>
        <p class="mb-1" style="font-size: 12px;"><strong>Telefono:</strong> <?php echo $data['get']['CELULAR'] ?></p>
      </div>
      <div class="my-2">
        <h4><strong>Cotización</strong></h4>
        <table>
          <tbody>
            <tr style="font-size: 12px;">
              <td class="pe-3">Fecha:</td>
              <td><strong><?php echo date('Y - m - d') ?></strong></td>
            </tr>
            <tr style="font-size: 12px;">
              <td class="pe-3">Boleta:</td>
              <td>#<?php echo $data['get']['ID_PACIENTE'] ?> - <?php echo $data['get']['ID'] ?></td>
            </tr>
            <tr style="font-size: 12px;">
              <td class="pe-3">Exp. Fecha:</td>
              <td>
                <strong>
                  <?php
                  $fecha_actual = date('Y-m-d');
                  $nueva_fecha = date('Y - m - d', strtotime($fecha_actual . ' +15 days'));
                  echo $nueva_fecha;
                  ?>
                </strong>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table m-0">
        <thead class="table border-top">
          <tr>
            <th>Descripción del Servicio</th>
            <th class="text-center">Días(Hábiles)</th>
            <th class="text-center">Cantidad</th>
            <th class="text-center">Precio U.</th>
            <th class="text-center">Precio T.</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><strong><?php echo $data['get']['SUB_TRAB'] ?></strong></td>

            <td class="text-center">
              <?php
              if ($data['get']['SUB_TRAB'] == 'Protesis Syme' || $data['get']['SUB_TRAB'] == 'Protesis de Desarticulado de Rodilla' || $data['get']['SUB_TRAB'] == 'Protesis Transfemoral') {
                echo "3 - 6";
              } else if ($data['get']['SUB_TRAB'] == 'Protesis de Desarticulado de Cadera') {
                echo "7 - 10";
              } else if ($data['get']['SUB_TRAB'] == 'Bilateral Transfemoral') {
                echo "5 - 10";
              } else if ($data['get']['SUB_TRAB'] == 'Bilateral Transtibial') {
                echo "5 - 7";
              } else if ($data['get']['SUB_TRAB'] == 'Protesis Transtibial') {
                echo "2 - 5";
              } else if ($data['get']['SUB_TRAB'] == 'Protesis Chopart' || $data['get']['SUB_TRAB'] == 'Protesis Linsfrack' || $data['get']['SUB_TRAB'] == 'Metatarsal') {
                echo "20";
              } else if ($data['get']['SUB_TRAB'] == 'Mano Parcial Mecánica' || $data['get']['SUB_TRAB'] == 'Mano Completa Biónica' ||  $data['get']['SUB_TRAB'] == 'Protesis transradial mecánica de TPU' ||  $data['get']['SUB_TRAB'] == 'Mano Parcial de articulación manual' || $data['get']['SUB_TRAB'] == 'Mano Parcial Biónica') {
                echo "30";
              } else if ($data['get']['SUB_TRAB'] == 'Falange Estética de Pie' || $data['get']['SUB_TRAB'] == 'Parte Corporal' || $data['get']['SUB_TRAB'] == 'Falange Parcial' || $data['get']['SUB_TRAB'] == 'Falange Total') {
                echo "30";
              } else if ($data['get']['SUB_TRAB'] == 'Mano Completa Estética' || $data['get']['SUB_TRAB'] == 'Mano Parcial Estética' || $data['get']['SUB_TRAB'] == 'Mitón de Pie Estético' || $data['get']['SUB_TRAB'] == 'Prótesis de Mamas') {
                echo "60";
              } else if ($data['get']['SUB_TRAB'] == 'Protesis Transhumeral tipo gancho con guante cosmético' || $data['get']['SUB_TRAB'] == 'Protesis transradial tipo gancho con guante cosmético') {
                echo "20";
              } else if ($data['get']['SUB_TRAB'] == 'Falange Mecánica') {
                echo "15";
              } else if ($data['get']['SUB_TRAB'] == 'Microtia Tipo 1 y 2' || $data['get']['SUB_TRAB'] == 'Microtia Tipo 3 y 4') {
                echo "45 - 55";
              }
              ?>
            </td>
            <td class="text-center"><?php echo $data['get']['CANTIDAD'] ?></td>
            <td class="text-center">S/.
              <?php

              if ($data['get']['IGV'] == 1) {
                $igvD = $data['get']['MONTO'] / 1.18;
                echo number_format($igvD / $data['get']['CANTIDAD'], 2, '.', '');
              } else {
                echo number_format($data['get']['MONTO'] / $data['get']['CANTIDAD'], 2, '.', '');
              }


              ?>
            </td>
            <td class="text-center">S/.
              <?php

              if ($data['get']['IGV'] == 1) {
                $valorIGV = ($data['get']['MONTO'] / 1.18);
                echo number_format($valorIGV, 2, '.', '');
              } else {
                $valor = $data['get']['MONTO'];
                echo number_format($valor, 2, '.', '');
              }


              ?>
            </td>
          </tr>
          <tr>
            <td colspan="5">
              <h6 class="mt-3"><strong>Componentes:</strong></h6>

              <ul class="list-unstyled mt-2">
                <ul>
                  <?php foreach ($data['lista'] as $row) { ?>
                    <li class=""><?php echo $row['LISTA'] ?></li>
                  <?php } ?>
                </ul>
              </ul>

              <h6 class="mt-3"><strong>Procesos:</strong></h6>

              <ul class="list-unstyled mt-2">
                <ul>
                  <?php if ($data['get']['TIP_TRAB'] == 'Miembro Inferior') { ?>

                    <li class="">Toma de medidas</li>
                    <li class="">Prueba de Encaje</li>
                    <li class="">Alineación y Marcha</li>
                    <li class="">Encaje Final</li>

                  <?php } else if ($data['get']['TIP_TRAB'] == 'Miembro Superior') { ?>
                    <li class="">Escaneo y tomas de Medida</li>
                    <li class="">Prueba de Encaje</li>
                    <li class="">Prueba de Función y Alineación</li>
                    <li class="">Encaje Final</li>
                  <?php } else if ($data['get']['TIP_TRAB'] == 'Estética') { ?>
                    <li class="">Toma de Medidas</li>
                    <li class="">Moldeado o Escultura</li>
                    <li class="">Prueba de Succión</li>
                    <li class="">Encaje Final</li>
                  <?php } ?>
                </ul>
              </ul>

              <h6 class="mt-3"><strong>Incluye:</strong></h6>

              <ul class="list-unstyled mt-2">
                <ul>

                  <li class="">Garantía 1 año</li>

                </ul>
              </ul>

            </td>
          </tr>
          <tr>
            <td colspan="3" class="align-top px-4 py-3">
              <p class="mb-2">
                <span class="me-1 fw-semibold">Métodos de Pago:</span>
              </p>
              <span>Transferencia: BCP, Interbank, Continental</span>
              <br>
              <span>POS: Tarjeta de Crédito o Débito ( +4% del Monto)</span>
              <br>
              <span>Efectivo, Billetera Digital:Yape y Plin</span>
            </td>
            <?php if ($data['get']['IGV'] == 1) { ?>
              <td class="text-end px-2 py-3">
                <p class="fw-bold mb-0">SubTotal: S/. </p>
                <p class="fw-bold mb-0">IGV (18%): S/. </p>
                <p class="fw-bold mb-0">Total: S/. </p>
              </td>
              <td class="text-end px-4 py-3">
                <p class="fw-bold mb-0">
                  <?php
                  $monto = $data['get']['MONTO'];
                  $resultado = number_format($monto / 1.18, 2, '.', '');
                  echo $resultado
                  ?>
                </p>
                <p class="fw-bold mb-0"><?php echo number_format(0.18 * $resultado, 2, '.', '') ?></p>
                <p class="fw-bold mb-0"><?php echo $data['get']['MONTO'] ?></p>
              </td>
            <?php } else { ?>
              <td class="text-end px-2 py-3">
                <p class="fw-bold mb-0">Total: S/. </p>
              </td>
              <td class="px-4 py-3">
                <p class="fw-bold mb-0"><?php echo $data['get']['MONTO'] ?></p>
              </td>

            <?php } ?>

          </tr>
        </tbody>
      </table>
    </div>

    <?php if (!empty($data['get']['OBSERVACION'])) { ?>
      <br>

      <h5 class="fw-bold">Observaciones:</h5>

      <p><?php echo $data['get']['OBSERVACION'] ?></p>

    <?php } ?>


    <br>
    <br>

    <h5 class="fw-bold">Términos y Condiciones:</h5>
    <ul class="list-unstyled mt-2">
      <li style="font-size: 11px;">Cada cotización realizada tiene que ser evaluado por un especialista para garantizar que sean los componentes adecuados para el paciente con previa evaluación. Los precios sí incluyen IGV.</li>
    </ul>

  </div>

  <!-- / Content -->

  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  <script src="<?php echo BASE_URL . 'Assets/vendor/libs/jquery/jquery.js'; ?>"></script>
  <script src="<?php echo BASE_URL . 'Assets/vendor/libs/popper/popper.js'; ?>"></script>
  <script src="<?php echo BASE_URL . 'Assets/vendor/js/bootstrap.js'; ?>"></script>
  <script src="<?php echo BASE_URL . 'Assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js'; ?>"></script>
  <script src="<?php echo BASE_URL . 'Assets/vendor/libs/node-waves/node-waves.js'; ?>"></script>

  <script src="<?php echo BASE_URL . 'Assets/vendor/libs/hammer/hammer.js'; ?>"></script>
  <script src="<?php echo BASE_URL . 'Assets/vendor/libs/i18n/i18n.js'; ?>"></script>
  <script src="<?php echo BASE_URL . 'Assets/vendor/libs/typeahead-js/typeahead.js'; ?>"></script>

  <script src="<?php echo BASE_URL . 'Assets/vendor/js/menu.js'; ?>"></script>
  <!-- endbuild -->

  <!-- Vendors JS -->

  <!-- Main JS -->
  <script src="<?php echo BASE_URL . 'Assets/js/main.js'; ?>"></script>
  <script>
    const base_url = '<?php echo BASE_URL; ?>'
  </script>
  <!-- Page JS -->
  <script src="<?php echo BASE_URL . 'Assets/func/Cotizacion/imprimir.js'; ?>"></script>
</body>

</html>