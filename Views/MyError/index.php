<!DOCTYPE html>

<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="<?php echo BASE_URL . 'Assets/'; ?>"
  data-template="vertical-menu-template">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>No Autorizado | KYPBioingeniería</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_URL . 'Assets/img/favicon/favicon.ico'; ?>" />

    <!-- Fonts -->
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
      rel="stylesheet" />

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

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="<?php echo BASE_URL . 'Assets/vendor/css/pages/page-misc.css'; ?>" />
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

    <!-- Not Authorized -->
    <div class="misc-wrapper">
      <h1 class="mb-2 mx-2" style="font-size: 6rem">401</h1>
      <h4 class="mb-2 fw-semibold">No esta Autorizado! 🔐</h4>
      <p class="mb-2 mx-2">No tienes los permisos para acceder a esta sección</p>
      <p class="mb-2 mx-2">Comunicate con el Administrador</p>
      <div class="d-flex justify-content-center mt-5">
        <img
          src="<?php echo BASE_URL . 'Assets/img/illustrations/misc-not-authorized-object.png'; ?>"
          alt="misc-not-authorized"
          class="img-fluid misc-object d-none d-lg-inline-block"
          width="190" />
        <img
          src="<?php echo BASE_URL . 'Assets/img/illustrations/misc-bg-light.png'; ?>"
          alt="misc-not-authorized"
          class="misc-bg d-none d-lg-inline-block"
          data-app-light-img="illustrations/misc-bg-light.png"
          data-app-dark-img="illustrations/misc-bg-dark.png" />
        <div class="d-flex flex-column align-items-center">
          <img
            src="<?php echo BASE_URL . 'Assets/img/illustrations/misc-not-authorized-illustration.png'; ?>"
            alt="misc-not-authorized"
            class="img-fluid zindex-1"
            width="160" />
          <div>
            <a href="<?php echo BASE_URL.'admin';?>" class="btn btn-primary text-center my-4">Back to home</a>
          </div>
        </div>
      </div>
    </div>
    <!-- /Not Authorized -->

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

    <!-- Page JS -->
  </body>
</html>
