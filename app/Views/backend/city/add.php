
<?php require(APPPATH . 'Views/backend/include/header.php'); ?>
<script></script>
<body>

    <div class="dashboard-main-wrapper">
  
    <?php require(APPPATH . 'Views/backend/include/navbar.php'); ?>
        
        
    <?php require(APPPATH . 'Views/backend/include/sidebar.php'); ?>
        
    <div class="dashboard-wrapper">
            <div class="container-fluid  dashboard-content">
                <!-- ============================================================== -->
                <!-- pageheader -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">City Add</h2>
                            <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><i class="fas fa-tachometer-alt "></i><a href="<?php echo site_url('/') ?>" class="breadcrumb-link"> Dashboard</a></li>
                                        <li class="breadcrumb-item"><i class="fa fa-fw fa-building"></i><a href="<?php echo site_url('/city') ?>" class="breadcrumb-link">City</a></li> 
                                        <li class="breadcrumb-item active" aria-current="page">City Add</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end pageheader -->
                <!-- ============================================================== -->
              
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                        <h3 class="card-header d-flex justify-content-between align-items-center">
                        City Add
                             
                       </h3>
                                    <div class="card-body">
                                        <form action="<?= base_url('city/store') ?>" data-parsley-validate="" novalidate="" method="post">
                                        
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 16px;" class="col-form-label"><b>City Name </b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                        <input required name="name" placeholder="Enter City Name" type="text" value="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 16px;" class="col-form-label"><b>Latitude </b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                        <input required name="latitude" id="latitude" placeholder="Enter Latitude" type="text" value="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 16px;" class="col-form-label"><b>Longitude </b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                        <input required name="longitude" id="longitude" placeholder="Enter Longitude" type="text" value="" class="form-control">
                                                    </div>
                                                    <div  class="col-md-4">
                                                    <a href="#basic" data-toggle="modal" class="btn  btn-primary"> <?php echo "Pick Latitude / Longitude" ?> </a>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 16px;" class="col-form-label"><b>Is Featured</b></label>
                                                    </div>
                                                    <div  class="col-md-1">
                                                    <label class="custom-control custom-checkbox">
                                                        <input  name="is_featured" type="checkbox" value="1" class="custom-control-input"><span class="custom-control-label"></span>
                                                    </label>
                                                    </div>
                                                </div>
                                            
                                               
                                                <div class="float-right">
                                                     <button type="submit" name="submit_page" id="submit_page" value="Submit" class="btn btn-success danger-btn"><?php echo "Submit" ?></button>
                                                </div>              
                                        </form>
                                    </div>
                                    <div class="card-footer float-right">
                                    </div>
                                    
                        </div>
                       
                    </div>
                </div>
<div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><?php echo "Pick Latitude / Longitude" ?></h4>
            </div>
            <div class="modal-body">
                <form class="form-inline margin-bottom-10" action="#">
                    <div class="input-group">
                        <input type="text" class="form-control" id="gmap_geocoding_address" placeholder="<?php echo "Address" ?>">
                        <span class="input-group-btn">
                            <button class="btn blue" id="gmap_geocoding_btn"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form>
                <div id="gmap_geocoding" class="gmaps">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal"><?php echo "Close" ?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
                
            </div>
            <!-- ============================================================== -->
            <?php require(APPPATH . 'Views/backend/include/footer.php'); ?>
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
        </div>
        
    </div>
    <?php require(APPPATH . 'Views/backend/include/footer_js.php'); ?>
</body>
<script src="//maps.google.com/maps/api/js?key=<?= MAP_API_KEY ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/vendor/gmaps/gmaps.min.js')?>"></script>
    <script>
    $('#form').parsley();
    </script>
     <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
<script>
$("#basic").on("shown.bs.modal", function() {
        mapGeocoding(); // init geocoding Maps
    });

    var currentLat = $("#latitude").val();
    var currentLng = $("#longitude").val();

    var mapGeocoding = function() {
        var map = new GMaps({
            div: '#gmap_geocoding',
            lat: (currentLat) ? currentLat : 22.359091474324057,
            lng: (currentLng) ? currentLng : 91.82152204807325,
            click: function(e) {
                placeMarker(e.latLng);
            }
        });
        map.addMarker({
            lat: (currentLat) ? currentLat : 22.359091474324057,
            lng: (currentLng) ? currentLng : 91.82152204807325,
            title: 'GEC Circle',
            draggable: true,
            dragend: function(event) {
                $("#latitude").val(event.latLng.lat());
                $("#longitude").val(event.latLng.lng());
            }
        });

        function placeMarker(location) {
            map.removeMarkers();
            $("#latitude").val(location.lat());
            $("#longitude").val(location.lng());
            map.addMarker({
                lat: location.lat(),
                lng: location.lng(),
                draggable: true,
                dragend: function(event) {
                    $("#latitude").val(event.latLng.lat());
                    $("#longitude").val(event.latLng.lng());
                }
            })
        }

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                map.setCenter(initialLocation);
            });
        }
        var handleAction = function() {
            var text = $.trim($('#gmap_geocoding_address').val());
            GMaps.geocode({
                address: text,
                callback: function(results, status) {
                    if (status == 'OK') {
                        map.removeMarkers();
                        var latlng = results[0].geometry.location;
                        map.setCenter(latlng.lat(), latlng.lng());
                        map.addMarker({
                            lat: latlng.lat(),
                            lng: latlng.lng(),
                            draggable: true,
                            dragend: function(event) {
                                $("#latitude").val(event.latLng.lat());
                                $("#longitude").val(event.latLng.lng());
                            }
                        });
                        $("#latitude").val(latlng.lat());
                        $("#longitude").val(latlng.lng());
                    }
                }
            });
        }
        $('#gmap_geocoding_btn').click(function(e) {
            e.preventDefault();
            handleAction();
        });
        $("#gmap_geocoding_address").keypress(function(e) {
            var keycode = (e.keyCode ? e.keyCode : e.which);
            if (keycode == '13') {
                e.preventDefault();
                handleAction();
            }
        });
    }
</script>
</html>

