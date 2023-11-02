
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
                            <h2 class="pageheader-title">User Add</h2>
                            <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><i class="fas fa-tachometer-alt "></i><a href="<?php echo site_url('/') ?>" class="breadcrumb-link"> Dashboard</a></li>
                                        <li class="breadcrumb-item"><i class="fa fa-fw fa-user-circle"></i><a href="<?php echo site_url('/user') ?>" class="breadcrumb-link">User</a></li> 
                                        <li class="breadcrumb-item active" aria-current="page">User Add</li>
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
                        User Add
                             
                       </h3>
                                    <div class="card-body">
                                        <form action="<?= base_url('user/store') ?>" data-parsley-validate="" novalidate=""  method="post">
                                        
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 16px;" class="col-form-label"><b>First Name </b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                        <input type="text" name="first_name"  placeholder="Enter Your First Name"  value="" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 16px;" placeholder="Enter Your Last Name" class="col-form-label"><b>Last Name</b></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                        <input name="last_name" type="text" value="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 16px;"  placeholder="Enter Your Mobile Number" class="col-form-label"><b>Mobile Number </b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                        <input name="mobile" type="text" value="" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 16px;" class="col-form-label"placeholder="Enter Your Email"><b>Email </b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                        <input placeholder="Enter Email" required="" data-parsley-type="email" oninput="checkEmail(this.value)" onblur="checkEmail(this.value)" name="email" type="email" id="email" value="" class="form-control">
                                                        <br> 
                                                        <div id="EmailExist"></div>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 16px;" class="col-form-label"><b>Password </b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                        <input id="pass2" name="password" type="password" placeholder="Enter Your Password" value="" class="form-control" required="">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 16px;" class="col-form-label"><b>Re-enter Password </b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                        <input  name="password" data-parsley-equalto="#pass2" type="password" placeholder="Re-enter Your Password" value="" class="form-control" required="">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 16px;" class="col-form-label"><b>User Type </b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                    <select name="user_type" class="form-control" id="input-select">
                                                            <option value="User">User</option>
                                                            <option value="Admin">Admin</option>
                                                            <option value="SuperAdmin">SuperAdmin</option>
                                                </select>
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
        <?php if(session()->has("user_error")) { ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?= session("user_error") ?>'
            })
            setTimeout(function() { 
                location.reload();
                }, 1000);      
        <?php } ?>
    });
    // Check Email Existence
    function checkEmail(email) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('user/checkEmail'); ?>",
            data: {
                    'email': email
                  },
            cache: false,
            success: function(response) {
                console.log(response);
                if (response.status == 1) {
                    document.getElementById("EmailExist").className = "alert alert-danger";
                    $('#EmailExist').show();
                    $('#EmailExist').html('Email already Exist');
                    
                    $(':input[name="submit_page"]').prop("disabled", true);
                } else {
                    $('#EmailExist').html("");
                    $('#EmailExist').hide();
                    $(':input[name="submit_page"]').prop("disabled", false);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                $('#EmailExist').show();
                $('#EmailExist').html(errorThrown);
            }
        });
    }
    </script>
    

</html>

