
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
                            <h2 class="pageheader-title">Brokerage Add</h2>
                            <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><i class="fas fa-tachometer-alt "></i><a href="<?php echo site_url('/') ?>" class="breadcrumb-link"> Dashboard</a></li>
                                        <li class="breadcrumb-item"><i class="fa fa-fw fa-user-circle"></i><a href="<?php echo site_url('/brokerage') ?>" class="breadcrumb-link">Brokerage</a></li> 
                                        <li class="breadcrumb-item active" aria-current="page">Brokerage Add</li>
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
                        Brokerage Add
                             
                       </h3>
                                    <div class="card-body">
                                        <form action="<?= base_url('brokerage/store') ?>" data-parsley-validate="" novalidate=""  method="post">
                                        
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 16px;" class="col-form-label"><b>Brokerage Name </b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                        <input type="text" name="name"  placeholder="Enter Realtor Name"  value="" class="form-control" required>
                                                    </div>
                                                </div>
                                                
                                               
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 15px;"  class="col-form-label"><b> Address </b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                        <input name="address" type="textarea" placeholder="Enter Full Address" value="" class="form-control">
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 16px;"   class="col-form-label"><b>Mobile Number </b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                        <input name="mobile" placeholder="Enter Your Mobile Number" type="text" value="" class="form-control" required>
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
        <?php if(session()->has("brokerage_error")) { ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?= session("brokerage_error") ?>'
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
            url: "<?php echo base_url('brokerage/checkEmail'); ?>",
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

