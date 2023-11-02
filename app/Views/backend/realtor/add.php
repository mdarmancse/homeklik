
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
                            <h2 class="pageheader-title">Realtor Add</h2>
                            <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><i class="fas fa-tachometer-alt "></i><a href="<?php echo site_url('/') ?>" class="breadcrumb-link"> Dashboard</a></li>
                                        <li class="breadcrumb-item"><i class="fa fa-fw fa-user-circle"></i><a href="<?php echo site_url('/realtor') ?>" class="breadcrumb-link">Realtor</a></li> 
                                        <li class="breadcrumb-item active" aria-current="page">Realtor Add</li>
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
                        Realtor Add
                             
                       </h3>
                                    <div class="card-body">
                                        <form action="<?= base_url('realtor/store') ?>" data-parsley-validate="" novalidate=""  method="post">
                                        
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 16px;" class="col-form-label"><b>Realtor Name </b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                        <input type="text" name="name"  placeholder="Enter Realtor Name"  value="" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 16px;" class="col-form-label"><b>User Name </b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                        <input type="text" name="username" oninput="checkUsername(this.value)" onblur="checkUsername(this.value)"  placeholder="Enter Realtor User Name"  value="" class="form-control" required>
                                                    
                                                        <br> 
                                                        <div id="UsernameExist"></div>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 16px;"  class="col-form-label"><b>RICO #</b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                        <input name="rico" type="text" placeholder="Enter RICO" value="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 15px;"  class="col-form-label"><b>RICO Registration Date</b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                        <input name="registration_date" type="date" placeholder="Enter RICO Registration Date" value="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 16px;"  class="col-form-label"><b>Postal Code</b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                        <input name="postal_code" type="text" placeholder="Enter Postal Code" value="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 16px;"  class="col-form-label"><b>Board Name</b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                        <input name="board_name" type="text" placeholder="Enter Board Name" value="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 15px;"  class="col-form-label"><b>Street Number </b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                        <input name="street_number" type="textarea" placeholder="Enter Street Number" value="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 15px;"  class="col-form-label"><b>Street Address 1 </b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                        <input name="street_address1" type="textarea" placeholder="Enter Street Address" value="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 15px;"  class="col-form-label"><b>Street Address 2 </b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                        <input name="street_address2" type="textarea" placeholder="Enter Additional Street Address" value="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 15px;"  class="col-form-label"><b>Unit / Apartment</b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                        <input name="unit" type="text" placeholder="Enter Unit" value="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 16px;" class="col-form-label"><b>Province</b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                    <select name="province" class="form-control" id="input-select">
                                                            <option value="Ontario">Ontario</option>
                                                            <option value="Alberta">Alberta</option>
                                                            <option value="Manitoba">Manitoba</option>
                                                    </select>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                       <div class="col-md-2">
                                                            <label style="font-size: 16px;" class="col-form-label"><b>City </b><span class="required">*</span></label>
                                                        </div>
                                                    <div  class="col-md-6">
                                                    <select name="city" class="form-control" id="input-select">
                                                            <option value="Toronto">Toronto</option>
                                                            <option value="Montreal">Montreal</option>
                                                            <option value="Calgary">Calgary</option>
                                                    </select>
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
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 16px;" class="col-form-label"placeholder="Enter Your Email"><b>Brokerage Name </b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                    <select required="" name="brokerage_id" id="brokerage_id" class="form-control form-filter input-sm">
                                                        <?php
                                                        foreach ($brokerages as $key => $value) { ?>
                                                            <option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                                                        <?php  } ?>
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
        <?php if(session()->has("realtor_error")) { ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?= session("realtor_error") ?>'
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
            url: "<?php echo base_url('realtor/checkEmail'); ?>",
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
    function checkUsername(username) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('realtor/checkUsername'); ?>",
            data: {
                    'username': username
                  },
            cache: false,
            success: function(response) {
                console.log(response);
                if (response.status == 1) {
                    document.getElementById("UsernameExist").className = "alert alert-danger";
                    $('#UsernameExist').show();
                    $('#UsernameExist').html('UserName already Exist');
                    
                    $(':input[name="submit_page"]').prop("disabled", true);
                } else {
                    $('#UsernameExist').html("");
                    $('#UsernameExist').hide();
                    $(':input[name="submit_page"]').prop("disabled", false);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                $('#UsernameExist').show();
                $('#UsernameExist').html(errorThrown);
            }
        });
    }
    </script>
    

</html>

