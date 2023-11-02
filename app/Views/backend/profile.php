
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
                            <h2 class="pageheader-title">Profile</h2>
                            <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><i class="fas fa-tachometer-alt "></i><a href="<?php echo site_url('/') ?>" class="breadcrumb-link"> Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><i class="fa fa-fw fa-user"></i> Profile</li>
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
                        <div class="tab-regular">
                                <ul class="nav nav-tabs " id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Profile</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Change Password</a>
                                    </li>
                                   
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <form action="<?= base_url('profile/update-profile') ?>" data-parsley-validate="" novalidate="" method="post">
                                            
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label style="font-size: 16px;" class="col-form-label"><b>First Name </b><span class="required">*</span></label>
                                                </div>
                                                <div  class="col-md-9">
                                                    <input required name="first_name" placeholder="Enter First Name" type="text" value="<?php echo session()->get('first_name') ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label style="font-size: 16px;" class="col-form-label"><b>Last Name </b></label>
                                                </div>
                                                <div  class="col-md-9">
                                                    <input name="last_name" placeholder="Enter Last Name" type="text" value="<?php echo session()->get('last_name') ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label style="font-size: 16px;" class="col-form-label"><b>Mobile </b><span class="required">*</span></label>
                                                </div>
                                                <div  class="col-md-9">
                                                    <input required name="mobile" id="mobile" placeholder="Enter Mobile" type="text" value="<?php echo session()->get('mobile') ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label style="font-size: 16px;" class="col-form-label"><b>Email </b><span class="required">*</span></label>
                                                </div>
                                                <div  class="col-md-9">
                                                    <input required name="email" id="email" placeholder="Enter Email" type="email" value="<?php echo session()->get('email') ?>" class="form-control">
                                                </div>
                                                <div  class="col-md-4">
                                                </div>
                                            </div>
                                            <div>
                                                <button type="submit" name="update_profile" id="update_profile" value="Submit" class="btn btn-success danger-btn"><?php echo "Update" ?></button>
                                            </div>              
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <form action="<?= base_url('profile/change-password') ?>" data-parsley-validate="" novalidate="" method="post">
                                            
                                    <div class="row form-group">
                                                    <div class="col-md-5">
                                                        <label style="font-size: 16px;" class="col-form-label"><b>New Password </b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-7">
                                                        <input id="pass2" name="password" type="password" placeholder="Enter New Password" value="" class="form-control" required="">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-md-5">
                                                        <label style="font-size: 16px;" class="col-form-label"><b>Re-type Password </b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-7">
                                                        <input  name="password" data-parsley-equalto="#pass2" type="password" placeholder="Re-type Your Password" value="" class="form-control" required="">
                                                    </div>
                                                </div>
                                           
                                            <div>
                                                <button type="submit" name="update_profile" id="update_profile" value="Submit" class="btn btn-success danger-btn"><?php echo "Update" ?></button>
                                            </div>              
                                        </form>
                                    </div>
                                </div>
                            </div>
                       </h3>
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
    $(function(){
        <?php if(session()->has("password_success")) { ?>
        Swal.fire({
            icon: 'success',
            title: 'Great!',
            text: '<?= session("password_success") ?>'
        })
        setTimeout(function() { 
                location.reload();
                }, 1000);   
    <?php } ?>
    <?php if(session()->has("password_error")) { ?>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?= session("password_error") ?>'
        })
        setTimeout(function() { 
                location.reload();
                }, 1000);   
    <?php } ?>
    <?php if(session()->has("profile_update_success")) { ?>
        Swal.fire({
            icon: 'success',
            title: 'Great!',
            text: '<?= session("profile_update_success") ?>'
        })
        setTimeout(function() { 
                location.reload();
                }, 1000);   
    <?php } ?>
    <?php if(session()->has("profile_update_error")) { ?>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?= session("profile_update_error") ?>'
        })
        setTimeout(function() { 
                location.reload();
                }, 1000);   
    <?php } ?>
    });
</script>
</html>

