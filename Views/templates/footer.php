<!-- / Content -->

<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl">
        <div class="footer-container d-flex align-items-center justify-content-between py-3 flex-md-row flex-column">
            <div class="mb-2 mb-md-0">
                ©
                <script>
                    document.write(new Date().getFullYear());
                </script>
                pagina principal:
                <a href="https://kypbioingenieria.com" target="_blank" class="footer-link fw-medium">kypbioingenieria.com</a>
            </div>
            <!--<div>
                <a href="https://themeforest.net/licenses/standard" class="footer-link me-4" target="_blank">License</a>
                <a href="https://1.envato.market/pixinvent_portfolio" target="_blank" class="footer-link me-4">More Themes</a>

                <a href="https://demos.pixinvent.com/materialize-html-admin-template/documentation/" target="_blank" class="footer-link me-4">Documentation</a>

                <a href="https://pixinvent.ticksy.com/" target="_blank" class="footer-link d-none d-sm-inline-block">Support</a>
            </div>-->
        </div>
    </div>
</footer>
<!-- / Footer -->

<div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
</div>
<!-- / Layout page -->
</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>

<!-- Drag Target Area To SlideIn Menu On Small Screens -->
<div class="drag-target"></div>
</div>
<!-- / Layout wrapper -->

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
<script src="<?php echo BASE_URL . 'Assets/vendor/libs/moment/moment.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'Assets/vendor/libs/select2/select2.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'Assets/vendor/libs/bloodhound/bloodhound.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'Assets/vendor/libs/flatpickr/flatpickr.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'Assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'Assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'Assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'Assets/vendor/libs/cleavejs/cleave.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'Assets/vendor/libs/cleavejs/cleave-phone.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'Assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'Assets/vendor/libs/sweetalert2/sweetalert2.all.min.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'Assets/vendor/libs/jquery-repeater/jquery-repeater.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'Assets/vendor/libs/dropzone/dropzone-min.js'; ?>"></script>

<!-- Main JS -->
<script src="<?php echo BASE_URL . 'Assets/js/main.js'; ?>"></script>

<!-- Page JS -->
<script src="<?php echo BASE_URL . 'Assets/func/alert.js'; ?>"></script>

<script>
    const base_url = '<?php echo BASE_URL; ?>'
</script>

<script src="<?php echo BASE_URL . 'Assets/func/data/data_coti.js'; ?>"></script>

<!-- Funciones -->
<?php if (!empty($data['scripts'])) { ?>
    <script src="<?php echo BASE_URL . 'Assets/func/'. $data['scripts']; ?>"></script>
<?php } ?>

</body>

</html>