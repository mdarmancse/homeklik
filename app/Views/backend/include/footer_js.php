<!-- ============================================================== -->
<!-- end main wrapper  -->
<!-- ============================================================== -->
<!-- Optional JavaScript -->
<!-- jquery 3.3.1 -->
<!-- <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.js"></script>
<!-- bootstap bundle js -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.js') ?>"></script>
<!-- bootbox -->
<script src="<?= base_url('assets/vendor/bootbox/bootbox.min.js')?>"></script>
<!-- //Ck editor -->
<script src="<?= base_url('assets/vendor/ckeditor/ckeditor.js')?>"></script>
<!-- slimscroll js -->
<script src="<?= base_url('assets/vendor/slimscroll/jquery.slimscroll.js')?>"></script>

<!-- chart chartist js -->
<script src="<?= base_url('assets/vendor/charts/chartist-bundle/chartist.min.js')?>"></script>
<!-- sparkline js -->
<script src="<?= base_url('assets/vendor/charts/sparkline/jquery.sparkline.js')?>"></script>
<!-- morris js -->
<script src="<?= base_url('assets/vendor/charts/morris-bundle/raphael.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/charts/morris-bundle/morris.js')?>"></script>
<!-- chart c3 js -->
<script src="<?= base_url('assets/vendor/charts/c3charts/c3.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/charts/c3charts/d3-5.4.0.min.js')?>"></script>
<script src="<?= base_url('assets/vendor/charts/c3charts/C3chartjs.js')?>"></script>
<script src="<?= base_url('assets/vendor/parsley/parsley.js')?>"></script>
<!-- main js -->
<script src="<?= base_url('assets/libs/js/main-js.js')?>"></script>
<script src="<?= base_url('assets/libs/js/dashboard-ecommerce.js')?>"></script>
<script>
    $(document).ready(function() {
      $('#fullscreenButton').on('click', function() {
        toggleFullscreen();
      });
    });

    function toggleFullscreen() {
      if (!document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) {
        if (document.documentElement.requestFullscreen) {
          document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) {
          document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
          document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
        } else if (document.documentElement.msRequestFullscreen) {
          document.documentElement.msRequestFullscreen();
        }
      } else {
        if (document.exitFullscreen) {
          document.exitFullscreen();
        } else if (document.mozCancelFullScreen) {
          document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) {
          document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
          document.msExitFullscreen();
        }
      }
    }
  </script>
