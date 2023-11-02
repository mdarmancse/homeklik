
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
                            <h2 class="pageheader-title">Rent Property</h2>
                            <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><i class="fas fa-tachometer-alt "></i><a href="<?php echo site_url('/') ?>" class="breadcrumb-link"> Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><i class="fa fa-fw fa-home"></i>Rent Property</li>
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
                        Rent Property
                       </h3>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="rent_property_ajax" class="table table-success table-bordered second" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Sl</th>
                                                <th>User Name</th>
                                                <th>Property Type</th>
                                                <th>Unit</th>
                                                <th>Photo</th>
                                                <th>Washrooms</th>
                                                <th>Bedrooms</th>
                                                <th>Parkings</th>
                                                <th>Size</th>
                                                <th>Province</th>
                                                <th>City</th>
                                                <th>Street Address</th>
                                                <th>Postal Code</th>
                                                <th>Price</th>
                                                
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
        $('#rent_property_ajax').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'dom' : 'bflrtip',
            ajax: {
                url: "<?php echo base_url('property/getRentPropertyAjaxData'); ?>",
                type: 'POST',
                // dataType: 'json',
                // dataSrc: ''
            },
            columns: [
                { data: 'id' },
                { data: 'user_name' },
                { data: 'property_type' },
                { data: 'unit' },
                { data: 'photo' },
                { data: 'washrooms' },
                { data: 'bedrooms' },
                { data: 'parkings' },
                { data: 'size' },
                { data: 'province' },
                { data: 'city' },
                { data: 'street_address' },
                { data: 'postal_code' },
                { data: 'price' }
            ]
        });
    });
    
  

 </script>
</html>

