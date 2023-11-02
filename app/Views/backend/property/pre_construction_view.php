
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
                            <h2 class="pageheader-title">Pre-Construction Property</h2>
                            <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><i class="fas fa-tachometer-alt "></i><a href="<?php echo site_url('/') ?>" class="breadcrumb-link"> Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><i class="fa fa-fw fa-home"></i> Pre-Construction Property</li>
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
                        Pre-Construction Property
                        <a type="button" class="btn btn-sm btn-success" href="<?php echo site_url('/property/add-preconstruction-property') ?>">Add Property</a>
                       </h3>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="preconstruction_property_ajax" class="table table-success table-bordered second" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Sl</th>
                                                <th>Price</th>
                                                <th>Address</th>
                                                <th>Photo</th>
                                                <th>Bathrooms</th>
                                                <th>Bedrooms</th>
                                                <th>Parking</th>
                                                <th>Size</th>
                                                <th>Last Updated</th>
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
</body>
 <script>
    $(document).ready(function() {
        $('#preconstruction_property_ajax').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'dom' : 'bflrtip',
            ajax: {
                url: "<?php echo base_url('property/getPreconstructionAjaxData'); ?>",
                type: 'POST',
                // dataType: 'json',
                // dataSrc: ''
            },
            columns: [
                { data: 'id' },
                { data: 'price' },
                { data: 'address' },
                { data: 'photo' },
                { data: 'bathrooms' },
                { data: 'bedrooms' },
                { data: 'parking' },
                { data: 'size_total_text' },
                { data: 'last_updated' },
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
                        url: "<?php echo base_url() ?>property/ajaxDisable_Preconstruction",
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

