<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="<?php echo BASE_URL . 'Assets/'; ?>" data-template="vertical-menu-template">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title><?php echo $data['title'] ?></title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="<?php echo BASE_URL . 'Assets/img/favicon/kyp.ico'; ?>" />

  <!-- Fonts -->
  <link type="text/css" href="<?php echo BASE_URL . 'Assets/vendor/fonts/fonts.googleapis.com_css2_family=Inter_wght@300;400;500;600;700&display=swap.css'; ?>" rel="stylesheet" />

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
  <link rel="stylesheet" href="<?php echo BASE_URL . 'Assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css'; ?>" />
  <link rel="stylesheet" href="<?php echo BASE_URL . 'Assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css'; ?>" />
  <link rel="stylesheet" href="<?php echo BASE_URL . 'Assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css'; ?>">
  <link rel="stylesheet" href="<?php echo BASE_URL . 'Assets/vendor/libs/swiper/swiper.css'; ?>" />
  <link rel="stylesheet" href="<?php echo BASE_URL . 'Assets/vendor/libs/select2/select2.css'; ?>" />
  <link rel="stylesheet" href="<?php echo BASE_URL . 'Assets/vendor/libs/flatpickr/flatpickr.css'; ?>" />
  <link rel="stylesheet" href="<?php echo BASE_URL . 'Assets/vendor/libs/dropzone/dropzone.css'; ?>" />

  <!-- Row Group CSS -->
  <link rel="stylesheet" href="<?php echo BASE_URL . 'Assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css'; ?>">

  <!-- Page CSS -->
  <link rel="stylesheet" href="<?php echo BASE_URL . 'Assets/vendor/css/pages/cards-statistics.css'; ?>" />
  <link rel="stylesheet" href="<?php echo BASE_URL . 'Assets/vendor/css/pages/app-invoice.css'; ?>" />
  <!-- Helpers -->
  <script src="<?php echo BASE_URL . 'Assets/vendor/js/helpers.js'; ?>"></script>

  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
  <script src="<?php echo BASE_URL . 'Assets/vendor/js/template-customizer.js'; ?>"></script>
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="<?php echo BASE_URL . 'Assets/js/config.js'; ?>"></script>
</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->

      <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo">
          <a href="<?php echo BASE_URL ?>/admin" class="app-brand-link">
            <span class="app-brand-logo demo">
              <span style="color: var(--bs-primary)">
                <svg id="Capa_1" data-name="Capa 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 289.54 355.29"><defs><style>.cls-1{fill:#515ba6;}</style></defs><path class="cls-1" d="M225.85,246.69v29.08c0,4.39.42,8.75,0,13.15-1,11-6.3,19.22-15.54,25-12.72,7.95-25.48,15.82-38.22,23.72l-27,16.79a25.9,25.9,0,0,1-4.86,2.56c-4.9,1.72-9.06-.58-10.27-5.6a27.52,27.52,0,0,1-.44-6.4q0-31.39,0-62.78,0-10.56.05-21.13c0-12.12,5.3-21.16,16-26.9Q177.74,216.9,210,199.71a19.43,19.43,0,0,1,6.92-2.34,7.08,7.08,0,0,1,8,4.72,17.61,17.61,0,0,1,.92,6.63Q225.86,227.71,225.85,246.69Z" transform="translate(-10.11 -2.26)"/><path class="cls-1" d="M106.77,303.26q0,21.27,0,42.56a20,20,0,0,1-.82,6.34c-1.41,4.36-4.6,6.06-9,4.95a16.48,16.48,0,0,1-4.73-2.1Q58.63,334.19,25.1,313.36c-9.78-6.1-14.68-15-14.64-26.57,0-5.91.1-11.84-.08-17.75-.21-7.35-.38-14.69-.2-22,.32-13,.14-25.92.28-38.87a15.94,15.94,0,0,1,1.16-6.27,6.67,6.67,0,0,1,6.69-4.4,16.66,16.66,0,0,1,7.55,2.24q18.66,9.87,37.31,19.77c9.54,5.09,19,10.32,28.54,15.43,7.33,3.92,12.22,9.72,14.09,17.91a32.91,32.91,0,0,1,.93,7.27q0,21.59,0,43.17Z" transform="translate(-10.11 -2.26)"/><path class="cls-1" d="M117.47,222.78a37.66,37.66,0,0,1-14.67-3.93c-7.94-4.18-15.83-8.46-23.74-12.7q-26.16-14-52.3-28.07a28.16,28.16,0,0,1-5.4-3.46c-3.87-3.38-3.72-8.55.52-11.43a78.86,78.86,0,0,1,7.69-4.41c10.47-5.51,21-10.87,31.45-16.46,13.4-7.17,26.72-14.48,40-21.77,4.89-2.68,10-4.68,15.6-4.94,6.15-.29,11.87,1.52,17.28,4.37,4.51,2.37,9,4.85,13.47,7.24q23,12.17,46,24.31,8.93,4.72,17.82,9.5a26.22,26.22,0,0,1,2.88,1.74c4.1,2.94,4.5,7.63,1.11,11.33-2,2.18-4.66,3.3-7.15,4.65-10.39,5.65-20.88,11.13-31.31,16.7-13.95,7.45-27.93,14.84-41.8,22.41A44.74,44.74,0,0,1,117.47,222.78Z" transform="translate(-10.11 -2.26)"/><path class="cls-1" d="M298.15,38.66H268.41v-.38a3.38,3.38,0,0,1,0-.72,2.44,2.44,0,0,0,0-.27V5.39c0-3.1,0-3.1-3-3.13H187.3c-.62,0-1.22,0-1.84,0-1,0-1.49.47-1.48,1.49,0,.7,0,1.42,0,2.14q0,14.33,0,28.66V35a25.3,25.3,0,0,1-.06,3.61v0H13.19a1.5,1.5,0,0,0-1.5,1.5V57.83a1.5,1.5,0,0,0,1.5,1.5H183.91v1.38a3.06,3.06,0,0,1,.06.63c0,.72,0,1.44,0,2.14v38.6c0,1.44,0,2.87,0,4.3.24,5.07,3,8.34,8,9.45a22.11,22.11,0,0,0,5.5.35c8.95-.19,15.43,3.75,19.65,11.6,1.93,3.6,3.91,7.18,6,10.66,1.9,3.13,3.07,3.09,5,.1.45-.67.88-1.38,1.3-2.08,1.87-3.28,3.66-6.61,5.62-9.84,3.28-5.38,7.88-9,14.19-10.29,2.42-.48,4.88-.21,7.33-.32,3.79-.16,7.31-1,9.49-4.54a13.2,13.2,0,0,0,2.14-7.54c-.33-6.23,0-12.41.13-18.63.11-6.8,0-13.62,0-20.46V59.33h29.74a1.5,1.5,0,0,0,1.5-1.5V40.16A1.51,1.51,0,0,0,298.15,38.66Z" transform="translate(-10.11 -2.26)"/></svg>
                  <path d="M30.0944 2.22569C29.0511 0.444187 26.7508 -0.172113 24.9566 0.849138C23.1623 1.87039 22.5536 4.14247 23.5969 5.92397L30.5368 17.7743C31.5801 19.5558 33.8804 20.1721 35.6746 19.1509C37.4689 18.1296 38.0776 15.8575 37.0343 14.076L30.0944 2.22569Z" fill="currentColor" />
                  <path d="M30.171 2.22569C29.1277 0.444187 26.8274 -0.172113 25.0332 0.849138C23.2389 1.87039 22.6302 4.14247 23.6735 5.92397L30.6134 17.7743C31.6567 19.5558 33.957 20.1721 35.7512 19.1509C37.5455 18.1296 38.1542 15.8575 37.1109 14.076L30.171 2.22569Z" fill="url(#paint0_linear_2989_100980)" fill-opacity="0.4" />
                  <path d="M22.9676 2.22569C24.0109 0.444187 26.3112 -0.172113 28.1054 0.849138C29.8996 1.87039 30.5084 4.14247 29.4651 5.92397L22.5251 17.7743C21.4818 19.5558 19.1816 20.1721 17.3873 19.1509C15.5931 18.1296 14.9843 15.8575 16.0276 14.076L22.9676 2.22569Z" fill="currentColor" />
                  <path d="M14.9558 2.22569C13.9125 0.444187 11.6122 -0.172113 9.818 0.849138C8.02377 1.87039 7.41502 4.14247 8.45833 5.92397L15.3983 17.7743C16.4416 19.5558 18.7418 20.1721 20.5361 19.1509C22.3303 18.1296 22.9391 15.8575 21.8958 14.076L14.9558 2.22569Z" fill="currentColor" />
                  <path d="M14.9558 2.22569C13.9125 0.444187 11.6122 -0.172113 9.818 0.849138C8.02377 1.87039 7.41502 4.14247 8.45833 5.92397L15.3983 17.7743C16.4416 19.5558 18.7418 20.1721 20.5361 19.1509C22.3303 18.1296 22.9391 15.8575 21.8958 14.076L14.9558 2.22569Z" fill="url(#paint1_linear_2989_100980)" fill-opacity="0.4" />
                  <path d="M7.82901 2.22569C8.87231 0.444187 11.1726 -0.172113 12.9668 0.849138C14.7611 1.87039 15.3698 4.14247 14.3265 5.92397L7.38656 17.7743C6.34325 19.5558 4.04298 20.1721 2.24875 19.1509C0.454514 18.1296 -0.154233 15.8575 0.88907 14.076L7.82901 2.22569Z" fill="currentColor" />
                  <defs>
                    <linearGradient id="paint0_linear_2989_100980" x1="5.36642" y1="0.849138" x2="10.532" y2="24.104" gradientUnits="userSpaceOnUse">
                      <stop offset="0" stop-opacity="1" />
                      <stop offset="1" stop-opacity="0" />
                    </linearGradient>
                    <linearGradient id="paint1_linear_2989_100980" x1="5.19475" y1="0.849139" x2="10.3357" y2="24.1155" gradientUnits="userSpaceOnUse">
                      <stop offset="0" stop-opacity="1" />
                      <stop offset="1" stop-opacity="0" />
                    </linearGradient>
                  </defs>
                </svg>
              </span>
            </span>
            <span class="app-brand-text demo menu-text fw-bold mt-1">KYP BIOINGEN</span>
          </a>

          <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M11.4854 4.88844C11.0081 4.41121 10.2344 4.41121 9.75715 4.88844L4.51028 10.1353C4.03297 10.6126 4.03297 11.3865 4.51028 11.8638L9.75715 17.1107C10.2344 17.5879 11.0081 17.5879 11.4854 17.1107C11.9626 16.6334 11.9626 15.8597 11.4854 15.3824L7.96672 11.8638C7.48942 11.3865 7.48942 10.6126 7.96672 10.1353L11.4854 6.61667C11.9626 6.13943 11.9626 5.36568 11.4854 4.88844Z" fill="currentColor" fill-opacity="0.6" />
              <path d="M15.8683 4.88844L10.6214 10.1353C10.1441 10.6126 10.1441 11.3865 10.6214 11.8638L15.8683 17.1107C16.3455 17.5879 17.1192 17.5879 17.5965 17.1107C18.0737 16.6334 18.0737 15.8597 17.5965 15.3824L14.0778 11.8638C13.6005 11.3865 13.6005 10.6126 14.0778 10.1353L17.5965 6.61667C18.0737 6.13943 18.0737 5.36568 17.5965 4.88844C17.1192 4.41121 16.3455 4.41121 15.8683 4.88844Z" fill="currentColor" fill-opacity="0.38" />
            </svg>
          </a>
        </div>

        <div class="menu-inner-shadow"></div>

        <ul class="menu-inner py-1" id="MenuBar">
          <!-- Dashboards -->
          <li class="menu-item">
            <a href="<?php echo BASE_URL . 'admin' ?>" class="menu-link">
              <i class="menu-icon tf-icons mdi mdi-home-alert-outline"></i>
              <div data-i18n="Menu Principal">Menu Principal</div>
            </a>
          </li>

          <!-- Components -->
            <?php if (!empty($_SESSION['user'])) : ?>
            <!-- Gestion de Usuarios -->
            <li class="menu-header fw-light mt-4">
              <span class="menu-header-text">Gestión de Usuarios</span>
            </li>
            <!-- Usuarios -->
            <li class="menu-item <?php echo !empty($data['active']) ? $data['active'] : ''; ?>">
              <a href="<?php echo BASE_URL . 'Usuarios' ?>" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-account-cog-outline"></i>
                <div data-i18n="Usuarios">Usuarios</div>
              </a>
            </li>

            <li class="menu-item <?php echo !empty($data['activeRol']) ? $data['activeRol'] : ''; ?>">
              <a href="<?php echo BASE_URL . 'Usuarios/rol' ?>" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-key-alert-outline"></i>
                <div data-i18n="Roles y Permisos">Roles y Permisos</div>
              </a>
            </li>

            <!-- /Gestion de Usuarios -->

            <?php endif; ?>

          <?php if (!empty($_SESSION['ListPa']) || !empty($_SESSION['Coti']) || !empty($_SESSION['histo']) || !empty($_SESSION['Contra'])) : ?>

          <!-- Gestion de Pacientes -->
          <li class="menu-header fw-light mt-4">
            <span class="menu-header-text">Gestión de Pacientes</span>
          </li>

          <?php endif; ?>


          <?php if (!empty($_SESSION['ListPa'])) : ?>
          <!-- Listado, Modificado y Registro de Pacientes -->
          <li class="menu-item <?php echo !empty($data['activePaciente']) ? $data['activePaciente'] : ''; ?>">
            <a href="<?php echo BASE_URL . 'Pacientes' ?>" class="menu-link">
              <i class="menu-icon tf-icons mdi mdi-account-injury-outline"></i>
              <div data-i18n="Listado de Pacientes">Listado de Pacientes</div>
            </a>
          </li>

          <?php endif; ?>

          <?php if (!empty($_SESSION['Coti'])) : ?>
          <!-- Cotización de Pacientes -->
          <li class="menu-item <?php echo !empty($data['activeCotizacion']) ? $data['activeCotizacion'] : ''; ?>">
            <a href="<?php echo BASE_URL . 'Cotizacion' ?>" class="menu-link">
              <i class="menu-icon tf-icons mdi mdi-file-document-plus-outline"></i>
              <div>Cotización</div>
            </a>
          </li>

          <?php endif; ?>

          <?php if (!empty($_SESSION['histo'])) : ?>
          <li class="menu-item <?php echo !empty($data['activeHistorial']) ? $data['activeHistorial'] : ''; ?>">
            <a href="<?php echo BASE_URL . 'Historial' ?>" class="menu-link">
              <i class="menu-icon tf-icons mdi mdi-clipboard-text-clock-outline"></i>
              <div>Historial</div>
            </a>
          </li>
          
          <?php endif; ?>

          <?php if (!empty($_SESSION['Contra'])) : ?>

          <li class="menu-item <?php echo !empty($data['activePagos']) ? $data['activePagos'] : ''; ?>">
            <a href="<?php echo BASE_URL . 'Contrato/pagos' ?>" class="menu-link">
              <i class="menu-icon tf-icons mdi mdi-cash-multiple"></i>
              <div data-i18n="Pagos de Contrato">Pagos de Contrato</div>
            </a>
          </li>

          <?php endif; ?>
<!--
          <?php //if (!empty($_SESSION['compra'])) : ?>

          <li class="menu-item <?php //echo !empty($data['activeCompra']) ? $data['activeCompra'] : ''; ?>">
            <a href="<?php //echo BASE_URL . 'Pacientes/compras' ?>" class="menu-link">
              <i class="menu-icon tf-icons mdi mdi-cart-variant"></i>
              <div data-i18n="Compra de Productos">Compra de Productos</div>
            </a>
          </li>
-->
          <!-- /Gestion de Pacientes -->

          <?php //endif; ?>

          <?php if (!empty($_SESSION['citas'])) : ?>
          <!-- Visitas Médicas -->

          <li class="menu-header fw-light mt-4">
            <span class="menu-header-text">Visitas Médicas</span>
          </li>


          <li class="menu-item <?php echo !empty($data['activeCitas']) ? $data['activeCitas'] : ''; ?>">
            <a href="<?php echo BASE_URL . 'Citas' ?>" class="menu-link">
              <i class="menu-icon tf-icons mdi mdi-ambulance"></i>
              <div data-i18n="Citas">Citas</div>
            </a>
          </li>

          <!-- /Visitas Médicas -->
          <?php endif; ?>
  

          <?php if (!empty($_SESSION['cajaadmin'])) : ?>
          <!-- Caja Empresiarial -->

          <li class="menu-header fw-light mt-4">
            <span class="menu-header-text">Caja Empresiarial</span>
          </li>

          <li class="menu-item <?php echo !empty($data['activeCaja']) ? $data['activeCaja'] : ''; ?>">
            <a href="<?php echo BASE_URL . 'Caja' ?>" class="menu-link">
              <i class="menu-icon tf-icons mdi mdi-account-cash"></i>
              <div data-i18n="Caja Administrativa">Caja Administrativa</div>
            </a>
          </li>

          <!-- /Caja Empresiarial -->

          <?php endif; ?>

          <!-- Ordenes Internas 
          <li class="menu-header fw-light mt-4">
            <span class="menu-header-text">Ordenes Internas</span>
          </li>

          <li class="menu-item <?php echo !empty($data['activeTrabajo']) ? $data['activeTrabajo'] : ''; ?>">
            <a href="<?php echo BASE_URL . 'Ordenes/trabajo' ?>" class="menu-link">
              <i class="menu-icon tf-icons mdi mdi-clipboard-file-outline"></i>
              <div data-i18n="Orden de Trabajo">Orden de Trabajo</div>
            </a>
          </li>-->

          <!-- /Ordenes Internas -->


          <!-- Gestion de Proyectos 
          <li class="menu-header fw-light mt-4">
            <span class="menu-header-text">Proyectos de Innovación</span>
          </li>

          <li class="menu-item ">
            <a href="" class="menu-link">
              <i class="menu-icon tf-icons mdi mdi-application-edit-outline"></i>
              <div data-i18n="Enumeración">Enumeración</div>
            </a>
          </li>

          <li class="menu-item ">
            <a href="#" class="menu-link">
              <i class="menu-icon tf-icons mdi mdi-projector-screen-outline"></i>
              <div data-i18n="Proyectos">Proyectos</div>
            </a>
          </li>

          <li class="menu-item ">
            <a href="#" class="menu-link">
              <i class="menu-icon tf-icons mdi mdi-clipboard-list-outline"></i>
              <div data-i18n="Listado de Proyectos">Listado de Proyectos</div>
            </a>
          </li>

          <li class="menu-item ">
            <a href="#" class="menu-link">
              <i class="menu-icon tf-icons mdi mdi-folder-wrench"></i>
              <div data-i18n="Resumen de Proyectos">Resumen de Proyectos</div>
            </a>
          </li>-->

          <!-- /Gestion de Proyectos -->


        </ul>
      </aside>
      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">
        <!-- Navbar -->

        <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
          <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
              <i class="mdi mdi-menu mdi-24px"></i>
            </a>
          </div>

          <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <!-- Search -->
            <div class="navbar-nav align-items-center">
              <div class="nav-item navbar-search-wrapper mb-0">
                <a class="nav-item nav-link search-toggler fw-normal px-0" href="javascript:void(0);">
                  <i class="mdi mdi-magnify mdi-24px scaleX-n1-rtl"></i>
                  <span class="d-none d-md-inline-block text-muted">Search (Ctrl+/)</span>
                </a>
              </div>
            </div>
            <!-- /Search -->

            <ul class="navbar-nav flex-row align-items-center ms-auto">
              <!-- Style Switcher -->
              <li class="nav-item me-1 me-xl-0">
                <a class="nav-link btn btn-text-secondary rounded-pill btn-icon style-switcher-toggle hide-arrow" href="javascript:void(0);">
                  <i class="mdi mdi-24px"></i>
                </a>
              </li>
              <!--/ Style Switcher -->


              <!-- User -->
              <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                  <div class="avatar avatar-online">
                    <img src="<?php echo BASE_URL . 'Assets/img/avatars/1.png'; ?>" alt class="w-px-40 h-auto rounded-circle" />
                  </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li>
                    <a class="dropdown-item" href="pages-account-settings-account.html">
                      <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                          <div class="avatar avatar-online">
                            <img src="<?php echo BASE_URL . 'Assets/img/avatars/1.png'; ?>" alt class="w-px-40 h-auto rounded-circle" />
                          </div>
                        </div>
                        <div class="flex-grow-1">
                          <span class="fw-semibold d-block"><?php echo $_SESSION['nombres'] ?></span>
                          <small class="text-muted"><?php echo $_SESSION['email'] ?></small>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <div class="dropdown-divider"></div>
                  </li>
                  <li>
                    <a class="dropdown-item" href="<?php echo BASE_URL . 'Usuarios/Salir' ?>">
                      <i class="mdi mdi-logout me-2"></i>
                      <span class="align-middle">Salir</span>
                    </a>
                  </li>
                </ul>
              </li>
              <!--/ User -->
            </ul>
          </div>

          <!-- Search Small Screens -->
          <div class="navbar-search-wrapper search-input-wrapper d-none">
            <input type="text" class="form-control search-input container-xxl border-0" placeholder="Search..." aria-label="Search..." />
            <i class="mdi mdi-close search-toggler cursor-pointer"></i>
          </div>
        </nav>

        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->