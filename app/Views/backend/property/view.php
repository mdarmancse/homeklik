
<?php require(APPPATH . 'Views/backend/include/header.php'); ?>
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
                            <h2 class="pageheader-title">Property</h2>
                            <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><i class="fas fa-tachometer-alt "></i><a href="<?php echo site_url('/') ?>" class="breadcrumb-link"> Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><i class="fa fa-fw fa-home"></i> Property</li>
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
                    <!-- ============================================================== -->
                    <!-- data table  -->
                    <!-- ============================================================== -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                        <h3 class="card-header d-flex justify-content-between align-items-center">
                        Property
                       
                             
                       </h3>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="property_ajax" class="table table-success table-bordered second" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Sl</th>
                                                <th>Listing ID</th>
                                                <th>Price</th>
                                                <th>Address</th>
                                                <th>Photo</th>
                                                <th>Bathrooms</th>
                                                <th>Bedrooms</th>
                                                <th>Parking</th>
                                                <th>Size</th>
                                                <th>Last Updated</th>
                                                <th>Featured</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                        
                                    </table>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end data table  -->
                    <!-- ============================================================== -->
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
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
</body>

 <script>
    $(document).ready(function() {
        $('#property_ajax').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'dom' : 'bflrtip',
            ajax: {
                url: "<?php echo base_url('property/getAjaxData') ?>",
                type: 'POST',
                // dataType: 'json',
                // dataSrc: ''
            },
            columns: [
                { data: 'id' },
                { data: 'listing_id' },
                { data: 'price' },
                { data: 'address' },
                { data: 'photo' },
                { data: 'bathrooms' },
                { data: 'bedrooms' },
                { data: 'parking' },
                { data: 'size_total_text' },
                { data: 'last_updated' },
                { data: 'is_featured' },
                { data: 'action' },
            ]
        });
    });
     // Status Change City
     function ajaxDisable(entity_id,status) {
        var message = (status == 0) ? "<?php echo "Do you want to Activate this item?"; ?>" : "<?php echo "Do you want to Deactivate this item?"; ?>";
        bootbox.confirm({
            message: message,
            buttons: {
                confirm: {
                    label: '<?php echo "Ok"; ?>',
                },
                cancel: {
                    label: '<?php echo "Cancel"; ?>',
                }
            },
            callback: function(dsiableConfirm) {
                if (dsiableConfirm) {
                    jQuery.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "<?php echo base_url('property/status/') ?>"+entity_id + "/" + status,
                        data: {
                            'entity_id': entity_id,
                            'status': status 
                        },
                        success: function(response) {
                            console.log(response)
                            if(response.status == 1)
                                {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Great!',
                                        text: response.message
                                    })
                                    setTimeout(function() { 
                                            location.reload();
                                            }, 1000);                
                                }
                
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            alert(errorThrown);
                        }
                    });
                }
            }
        });
       
    }

    // Status Change City
    function ajaxFeature(entity_id,status) {
        var message = (status == 0) ? "<?php echo "Do you want to Featured this item?"; ?>" : "<?php echo "Do you want to Unfeatured this item?"; ?>";
        bootbox.confirm({
            message: message,
            buttons: {
                confirm: {
                    label: '<?php echo "Ok"; ?>',
                },
                cancel: {
                    label: '<?php echo "Cancel"; ?>',
                }
            },
            callback: function(disableConfirm) {
                if (disableConfirm) {
                    jQuery.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "<?php echo base_url('property/feature/') ?>"+entity_id + "/" + status,
                        data: {
                            'entity_id': entity_id,
                            'status': status 
                        },
                        success: function(response) {
                            console.log(response)
                            if(response.status == 1)
                                {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Great!',
                                        text: response.message
                                    })
                                    setTimeout(function() { 
                                            location.reload();
                                            }, 1000);                
                                }
                
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            alert(errorThrown);
                        }
                    });
                }
            }
        });
       
    }
  

 </script>
</html>

