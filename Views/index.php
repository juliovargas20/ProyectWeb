<!DOCTYPE html>

<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="<?php echo BASE_URL . 'Assets/'; ?>" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Iniciar Sesión - KYPBioingeniería</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_URL . 'Assets/img/favicon/kyp.ico'; ?>" />

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
    <link href="<?php echo BASE_URL . 'Assets/vendor/libs/sweetalert2/sweetalert2.min.css'; ?>" rel="stylesheet">

    <!-- Vendor -->
    <link rel="stylesheet" href="<?php echo BASE_URL . 'Assets/vendor/libs/formvalidation/dist/css/formValidation.min.css'; ?>" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="<?php echo BASE_URL . 'Assets/vendor/css/pages/page-auth.css'; ?>" />

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

    <div class="authentication-wrapper authentication-cover">
        <!-- Logo -->
        <a href="" class="auth-cover-brand d-flex align-items-center gap-2">
        <img src="<?php echo BASE_URL . 'Assets/img/logo_kyp2.png' ?>" alt="" width="150">
            
        </a>
        <!-- /Logo -->
        <div class="authentication-inner row m-0">
            <!-- /Left Section -->
            <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center justify-content-center p-5 pb-2">
                <img src="<?php echo BASE_URL . 'Assets/img/illustrations/auth-login-illustration-light.png'; ?>" class="auth-cover-illustration w-100" alt="auth-illustration" data-app-light-img="illustrations/auth-login-illustration-light.png" data-app-dark-img="illustrations/auth-login-illustration-dark.png" />
                <img src="<?php echo BASE_URL . 'Assets/img/illustrations/auth-cover-login-mask-light.png'; ?>" class="authentication-image" alt="mask" data-app-light-img="illustrations/auth-cover-login-mask-light.png" data-app-dark-img="illustrations/auth-cover-login-mask-dark.png" />
            </div>
            <!-- /Left Section -->

            <!-- Login -->
            <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-5 px-4 py-4">
                <div class="w-px-400 mx-auto pt-5 pt-lg-0">
                    <h4 class="mb-4 fw-semibold">Bienvenido a KYPBioingenieria! 👋</h4>

                    <form id="Frm" class="mb-3" autocomplete="off">
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Ingrese su Correo Electrónico de la empresa" autofocus />
                            <label for="email">Correo Electrónico</label>
                        </div>
                        <div class="mb-3">
                            <div class="form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                        <label for="password">Contraseña</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary d-grid w-100">Acceder</button>
                    </form>

                </div>
            </div>
            <!-- /Login -->
        </div>
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
    <script src="<?php echo BASE_URL . 'Assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js'; ?>"></script>
    <script src="<?php echo BASE_URL . 'Assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js'; ?>"></script>
    <script src="<?php echo BASE_URL . 'Assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js'; ?>"></script>
    <script src="<?php echo BASE_URL . 'Assets/vendor/libs/sweetalert2/sweetalert2.all.min.js'; ?>"></script>

    <!-- Main JS -->
    <script src="<?php echo BASE_URL . 'Assets/js/main.js'; ?>"></script>

    <!-- Page JS -->
    <script src="<?php echo BASE_URL . 'Assets/js/pages-auth.js'; ?>"></script>

    <script>
        const BASE_URL = '<?php echo BASE_URL ?>'
    </script>

    <!-- Funciones -->
    <script src="<?php echo BASE_URL . 'Assets/func/alert.js'; ?>"></script>
    <script src="<?php echo BASE_URL . 'Assets/func/login.js'; ?>"></script>

</body>

</html>