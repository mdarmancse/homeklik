
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
                            <h2 class="pageheader-title">Notification Add</h2>
                            <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><i class="fas fa-tachometer-alt "></i><a href="<?php echo site_url('/') ?>" class="breadcrumb-link"> Dashboard</a></li>
                                        <li class="breadcrumb-item"><i class="fa fa-fw fa-file"></i><a href="<?php echo site_url('/notification') ?>" class="breadcrumb-link">Notification</a></li> 
                                        <li class="breadcrumb-item active" aria-current="page">Notification Add</li>
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
                        Notification Add
                             
                       </h3>
                                    <div class="card-body">
                                        <form action="<?= base_url('notification/store') ?>" enctype="multipart/form-data" method="post">
                                                <div class="row form-group"  id="user_type_div">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 16px;" class="col-form-label"><b>User Type </b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                    <select required name="selection_type" class="form-control" id="selection_type" onchange="getUserType(this.value)">
                                                        <option value="">Select</option>
                                                        <?php $user_types = user_type();
                                                        if (!empty($user_types)) {
                                                            foreach ($user_types as $key => $value) { ?>
                                                                <option value="<?php echo $key ?>"><?php echo $value ?></option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="row form-group user_div">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 16px;" class="col-form-label"><b>Users </b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-1">
                                                        <div class="form-check">
                                                                <input id="all_user" class="form-check-input" type="checkbox" name="all_user" value="true" >
                                                                <label for="all_user" class="form-check-label">All</label>
                                                        </div>
                                                    </div>
                                                    <div  class="col-md-7">
                                                        <select name="user_id[]" multiple="" class="form-control" id="user_id">
                                                
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row form-group realtor_div" >
                                                    <div class="col-md-2">
                                                        <label style="font-size: 16px;" class="col-form-label"><b>Realtors </b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-1">
                                                        <div class="form-check">
                                                                <input id="all_realtor" class="form-check-input" type="checkbox" name="all_realtor" value="true">
                                                                <label for="all_realtor" class="form-check-label">All</label>
                                                        </div>
                                                    </div>
                                                    <div  class="col-md-7">
                                                        <select name="realtor_id[]" multiple="" class="form-control" id="realtor_id">
                                                
                                                        </select>
                                                    </div>
                                                </div>
                                    
                                    
                                                
                                               
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 16px;" class="col-form-label"><b>Notification Title </b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                        <input required name="notification_title" placeholder="Enter Notification Title" type="text" value="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                   <div class="col-md-2">
                                                        <label style="font-size: 16px;" class="col-form-label"><b>Image</b></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                    <input accept="image/*" type="file" data-parsley-filetype="image" data-parsley-fileextension="jpg jpeg png" required name="filePhoto" value="" id="filePhoto" class="required borrowerImageFile" data-errormsg="PhotoUploadErrorMsg">
                                                    <br/><br/>
                                                      <img id="previewHolder" alt="Uploaded Image Preview Holder" width="250px" height="250px" style="border-radius:3px;border:5px solid red;"/>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 16px;" class="col-form-label"><b>Notification Description </b><span class="required">*</span></label>
                                                    </div>
                                                    <div  class="col-md-6">
                                                         <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <label style="font-size: 16px;" class="col-form-label"><b>Save Notification </b></label>
                                                    </div>
                                                    <div  class="col-md-1">
                                                        <div class="form-check">
                                                                <input id="save" class="form-check-input" type="checkbox" name="save" value="true">
                                                        </div>
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</body>
<script>
    $('#form').parsley();
    </script>
<script>
    $(function(){
    <?php if(session()->has("notification_error")) { ?>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?= session("notification_error") ?>'
        })
        setTimeout(function() { 
                location.reload();
                }, 1000);   
    <?php } ?>
   
});
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

function getUserType(value) {
        // alert(value);
        if (value == 'user') {
            $('.user_div').show();
            $('.realtor_div').hide();
        } else if (value == 'realtor') {
            $('.user_div').hide();
            $('.realtor_div').show();
        } else {
            $('.user_div').hide();
            $('.realtor_div').hide();
        }
    }
    function showUserList() {
        document.getElementById('specific_users').style.display = 'block';
    }

    function allUsers() {
        document.getElementById('specific_users').style.display = 'none';
    }
    $("#user_id").select2({
            // tags: true,
            multiple: true,
            closeOnSelect: false,
            scrollAfterSelect: true,
            // tokenSeparators: [',', ' '],
            minimumResultsForSearch: 50,
            ajax: {
                url: "<?php echo base_url('user/getUsers') ?>",
                dataType: "json",
                type: "POST",
                data: function(params) {

                    var queryParameters = {
                        term: params.term
                    }
                    return queryParameters;
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.label,
                                id: item.id
                            }
                        })
                    };
                }
            }
    }).on('select2:selecting', e => $(e.currentTarget).data('scrolltop', $('.select2-results__options').scrollTop()))
    .on('select2:select', e => $('.select2-results__options').scrollTop($(e.currentTarget).data('scrolltop')))
    .on('select2:unselecting', e => $(e.currentTarget).data('scrolltop', $('.select2-results__options').scrollTop()))
    .on('select2:unselect', e => $('.select2-results__options').scrollTop($(e.currentTarget).data('scrolltop')));
    $("#realtor_id").select2({
            // tags: true,
            multiple: true,
            closeOnSelect: false,
            scrollAfterSelect: true,
            // tokenSeparators: [',', ' '],
            minimumResultsForSearch: 50,
            ajax: {
                url: "<?php echo base_url('realtor/getRealtors') ?>",
                dataType: "json",
                type: "POST",
                data: function(params) {

                    var queryParameters = {
                        term: params.term,

                    }
                    return queryParameters;
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.label,
                                id: item.id
                            }
                        })
                    };
                }
            }
    }).on('select2:selecting', e => $(e.currentTarget).data('scrolltop', $('.select2-results__options').scrollTop()))
    .on('select2:select', e => $('.select2-results__options').scrollTop($(e.currentTarget).data('scrolltop')))
    .on('select2:unselecting', e => $(e.currentTarget).data('scrolltop', $('.select2-results__options').scrollTop()))
    .on('select2:unselect', e => $('.select2-results__options').scrollTop($(e.currentTarget).data('scrolltop')));


$("#all_user").change(function() {
        if ($(this).is(':checked')) {
            $("#user_id").attr("disabled", "disabled");
        } else {
            $("#user_id").removeAttr("disabled");
        }
    })
    $("#all_realtor").change(function() {
        if ($(this).is(':checked')) {
            $("#realtor_id").attr("disabled", "disabled");
        } else {
            $("#realtor_id").removeAttr("disabled");
        }
    })

</script>

</html>

