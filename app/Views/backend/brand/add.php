
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
                            <h2 class="pageheader-title">Brand Add  </h2>
                            <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><i class="fas fa-tachometer-alt "></i><a href="<?php echo site_url('/') ?>" class="breadcrumb-link"> Dashboard</a></li>
                                        <li class="breadcrumb-item"><i class="fa fa-fw fa-image"></i><a href="<?php echo site_url('/brand') ?>" class="breadcrumb-link">Brand</a></li> 
                                        <li class="breadcrumb-item active" aria-current="page">Brand Add  </li>
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
                        Brand Add  
                       </h3>
                                    <div class="card-body">
                                        <form action="<?php echo base_url('brand/store');?>" enctype="multipart/form-data" data-parsley-validate="" novalidate="" method="post">
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 16px;" class="col-form-label"><b>Brand Name </b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                        <input required name="name" placeholder="Enter Brand Name" type="text" value="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 16px;" class="col-form-label"><b>Brand Logo </b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                    <input accept="image/*" type="file" data-parsley-filetype="image" data-parsley-fileextension="jpg jpeg png" required name="filePhoto" value="" id="filePhoto" class="required borrowerImageFile" data-errormsg="PhotoUploadErrorMsg">
                                                    <br/><br/>
                                                      <img id="previewHolder" alt="Uploaded Image Preview Holder" width="250px" height="250px" style="border-radius:3px;border:5px solid red;"/>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 16px;" class="col-form-label"><b>Web Url </b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                        <input required id="inputWebSite" name="url" data-parsley-type="url" placeholder="Enter URL" type="url" value="" class="form-control">
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
<script>
    function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#previewHolder').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  } else {
    alert('select a file to see preview');
    $('#previewHolder').attr('src', '');
  }
}

$("#filePhoto").change(function() {
  readURL(this);
});
</script>
</html>


