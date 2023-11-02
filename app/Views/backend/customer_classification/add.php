
<?php require(APPPATH . 'Views/backend/include/header.php'); ?>
<script></script>
<body>

    <div class="dashboard-main-wrapper">
  
    <?php require(APPPATH . 'Views/backend/include/navbar.php'); ?>
        
        
    <?php require(APPPATH . 'Views/backend/include/sidebar.php'); ?>

        <?php


        ?>
        
    <div class="dashboard-wrapper">
            <div class="container-fluid  dashboard-content">
                <!-- ============================================================== -->
                <!-- pageheader -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">Customer Classifications Add</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><i class="fas fa-tachometer-alt "></i><a href="<?php echo site_url('/') ?>" class="breadcrumb-link"> Dashboard</a></li>
                                        <li class="breadcrumb-item"><i class="fa fa-fw fa-building"></i><a href="<?php echo site_url('/customer_classification') ?>" class="breadcrumb-link">Customer Classifications</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Customer Classifications Add</li>
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
                        Customer Classifications Add
                             
                       </h3>
                                    <div class="card-body">
                                        <form action="<?= base_url('customer_classification/store') ?>" data-parsley-validate="" novalidate="" method="post">
                                        
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 16px;" class="col-form-label"><b> Name </b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                        <input required name="name" placeholder="Enter  Name" type="text" value="" class="form-control">
                                                    </div>
                                                </div>

                                            <div class="row form-group">
                                                <div class="col-md-2">
                                                    <label style="font-size: 16px;" class="col-form-label"><b> Default Status </b><span class="required">*</span></label>
                                                </div>
                                                <div  class="col-md-6">
                                                    <input required name="default_status" placeholder="Default Status" type="text" value="" class="form-control">
                                                </div>
                                            </div>


                                            <div class="row form-group">
                                                <div class="col-md-2">
                                                    <label style="font-size: 16px;" class="col-form-label"><b> Default Number </b><span class="required">*</span></label>
                                                </div>
                                                <div  class="col-md-6">
                                                    <input required name="default_number" placeholder="Default Number" type="number" value="" class="form-control">
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

</html>

