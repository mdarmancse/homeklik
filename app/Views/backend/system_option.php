
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
                            <h2 class="pageheader-title">System Option</h2>
                            <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><i class="fa fa-fw fa-user-circle"></i><a href="<?php echo site_url('/') ?>" class="breadcrumb-link">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-fw far fa-wrench"></i> System Option</li>
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
                        System Option
                             
                       </h3>
                                    <div class="card-body">
                                        <form action="<?php echo base_url('system_option/update'); ?>" method="post">
                                            <?php
                                            foreach ($SystemOptionList as $key => $Option) {
                                                if ($Option['option_slug'] == 'latitude')
                                                {
                                                    $id = "latitude";
                                                }
                                                else if ($Option['option_slug'] == 'longitude')
                                                {
                                                    $id = "longitude";
                                                }
                                                else
                                                {
                                                    $id = "inputText3";
                                                }
                                            ?>
                                                <div class="row form-group">
                                                    <div class="col-md-3">
                                                        <label for="inputText3" class="col-form-label"><?php echo $Option['option_name']; ?></label>
                                                    </div>
                                                    <?php if ( $Option['option_slug'] == 'contact_us'){ ?>
                                                    
                                                    <div class="col-md-6">
                                                            <input type="hidden" name="SystemOptionID[]" value="<?php echo $Option['id']; ?>">
                                                            <?php if ($Option['option_slug'] != 'about_us' && $Option['option_slug'] != 'contact_us'
                                                                && $Option['option_slug'] != 'privacy_policy' && $Option['option_slug'] != 'terms_condition') { ?>
                                                                <input id="<?php echo $id ?>" name="OptionValue[]" type="text" value="<?php echo $Option['option_value'] ?>" class="form-control">
                                                                <?php } else { ?>
                                                            <textarea name="OptionValue[]" class="form-control ckeditor"><?php echo $Option['option_value'] ?></textarea>
                                                            <?php } ?>
                                                    </div>
                                                        <div  class="col-md-3">
                                                        <a href="#basic" data-toggle="modal" class="btn  btn-primary"> <?php echo "Pick Latitude / Longitude" ?> </a>
                                                    
                                                        </div>
                                                   <?php }else{ ?>
                                                    <div class="col-md-9">
                                                            <input type="hidden" name="SystemOptionID[]" value="<?php echo $Option['id']; ?>">
                                                            <?php if ($Option['option_slug'] != 'about_us' && $Option['option_slug'] != 'contact_us'
                                                                && $Option['option_slug'] != 'privacy_policy' && $Option['option_slug'] != 'terms_condition') { ?>
                                                                <input id="<?php echo $id ?>" name="OptionValue[]" type="text" value="<?php echo $Option['option_value'] ?>" class="form-control">
                                                                <?php } else { ?>
                                                            <textarea name="OptionValue[]" class="form-control ckeditor"><?php echo $Option['option_value'] ?></textarea>
                                                            <?php } ?>
                                                    </div>
                                                   <?php } ?>
                                                    
                                                </div>
                                                <?php } ?> 
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
    
$(function(){
    <?php if(session()->has("success")) { ?>
        Swal.fire({
            icon: 'success',
            title: 'Great!',
            text: '<?= session("success") ?>'
        })
        setTimeout(function() { 
                                            location.reload();
                                            }, 1000); 
    <?php } ?>
    <?php if(session()->has("error")) { ?>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?= session("error") ?>'
        })
        setTimeout(function() { 
                                            location.reload();
                                            }, 1000); 
    <?php } ?>
});
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

