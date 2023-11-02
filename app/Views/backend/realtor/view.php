
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
                            <h2 class="pageheader-title">Realtors</h2>
                            <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><i class="fas fa-tachometer-alt "></i><a href="<?php echo site_url('/') ?>" class="breadcrumb-link"> Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><i class="fa fa-fw fa-user-circle"></i> Realtors</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title" id="exampleModalLabel">Realtor Details</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <table class="table">
                                        <tbody>
                                            <tr class="table-primary">
                                                <th scope="row"><b>Name :</b></th>
                                                <td class="name">Mark</td>
                                               
                                            </tr>
                                            <tr class="table-light">
                                                <th scope="row"><b>Email :</b></th>
                                                <td class="email">Jacob</td>
                                                
                                            </tr>
                                            <tr class="table-success">
                                                <th scope="row"><b>Mobile :</b></th>
                                                <td class="mobile">Mark</td>
                                               
                                            </tr>
                                            <tr class="table-light">
                                                <th scope="row"><b>Province :</b></th>
                                                <td class="province">Jacob</td>
                                                
                                            </tr>
                                            <tr class="table-secondary">
                                                <th scope="row"><b>City :</b></th>
                                                <td class="city">Mark</td>
                                               
                                            </tr>
                                            <tr class="table-light">
                                                <th scope="row"><b>Address :</b></th>
                                                <td class="address">Jacob</td>
                                                
                                            </tr>
                                            <tr class="table-info">
                                                <th scope="row"><b>RICO :</b></th>
                                                <td class="rico">Mark</td>
                                               
                                            </tr>
                                            <tr class="table-light">
                                                <th scope="row"><b>Unit :</b></th>
                                                <td class="unit">Jacob</td>
                                                
                                            </tr>
                                        </tbody>
                         </table>
                        </div>
                        </div>
                    </div>
                    </div>
                <!-- ============================================================== -->
              
                <div class="row">
                    <!-- ============================================================== -->
                    <!-- data table  -->
                    <!-- ============================================================== -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                        <h3 class="card-header d-flex justify-content-between align-items-center">
                                Realtors
                                <a type="button" class="btn btn-sm btn-success" href="<?php echo site_url('realtor/add') ?>">Add Realtor</a>
                             
                       </h3>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="realtor_ajax" class="table table-striped table-bordered second" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Sl</th>
                                                <th>Name</th>
                                                <th>Mobile</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th class="text-center">Action</th>
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
     $(function(){
        <?php if(session()->has("realtor_success")) { ?>
            Swal.fire({
                icon: 'success',
                title: 'Great!',
                text: '<?= session("realtor_success") ?>'
                
            })
            setTimeout(function() { 
            location.reload();
            }, 1000);      
        <?php } ?>
        <?php if(session()->has("realtor_edit_success")) { ?>
        Swal.fire({
            icon: 'success',
            title: 'Great!',
            text: '<?= session("realtor_edit_success") ?>'
        })
        setTimeout(function() { 
                location.reload();
                }, 1000);   
    <?php } ?>
    <?php if(session()->has("realtor_edit_error")) { ?>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?= session("realtor_edit_error") ?>'
        })
        setTimeout(function() { 
                location.reload();
                }, 1000);   
    <?php } ?>
    });
    $(document).ready(function() {
        $('#realtor_ajax').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'dom' : 'bflrtip',
            ajax: {
                url: "<?= base_url('realtor/getAjaxData'); ?>",
                type: 'POST',
            },
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'mobile' },
                { data: 'email' },
                { data: 'status' },
                { data: 'action' },
            ]
        });
    });
    // Status Change Realtor
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
            callback: function(disableConfirm) {
                if (disableConfirm) {
                    jQuery.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "<?php echo base_url('realtor/status/') ?>"+entity_id + "/" + status,
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
     // Delete Realtor
     function ajaxDelete(entity_id) {
        var message = (status == 0) ? "<?php echo "Do you want to Delete this item?"; ?>" : "<?php echo "Do you want to Delete this item?"; ?>";
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
                        url: "<?php echo base_url('realtor/delete/') ?>"+entity_id,
                        data: {
                            'entity_id': entity_id, 
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
    // Delete Realtor
    function ajaxDetails(entity_id) {
            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo base_url('realtor/details/') ?>"+entity_id,
                data: {
                    'entity_id': entity_id, 
                },
                success: function(response) {
                    console.log(response)
                    $('.name').html(response.name);
                    $('.email').html(response.email);
                    $('.mobile').html(response.mobile);
                    $('.address').html(response.address);
                    $('.province').html(response.province);
                    $('.city').html(response.city);
                    $('.unit').html(response.unit);
                    $('.rico').html(response.rico);
                    $('#exampleModal').modal('show');
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
         }


 </script>
</html>

