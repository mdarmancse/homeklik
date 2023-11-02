
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
                            <h2 class="pageheader-title">City</h2>
                            <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><i class="fas fa-tachometer-alt "></i><a href="<?php echo site_url('/') ?>" class="breadcrumb-link"> Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><i class="fa fa-fw fa-building"></i> City</li>
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
                    <!-- Modal -->
                                <div class="modal fade" id="add_city" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">City Add</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                        <form id="form_add_city" name="form_add_city" method="post" class="form-horizontal" enctype="multipart/form-data">
                                                <div class="form-group">
                                                    <p style="margin:0px;color:red" id="error"></p>
                                                    <label for="inputText3" class="col-form-label">City Name</label>
                                                    <input required id="city_name" name="name" type="text" class="form-control">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                        </form>
                                        
                                        </div>
                                        
                                        </div>
                                    </div>
                                </div>
                                
                    <!-- Modal -->
                    <!-- Edit Modal -->
                    <div class="modal fade" id="edit_city" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">City Edit</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                        <form id="update_city" name="update_city" method="post" class="form-horizontal" enctype="multipart/form-data">
                                                <div class="form-group">
                                                    <p style="margin:0px;color:red" id="error"></p>
                                                    <label for="inputText3" class="col-form-label">City Name</label>
                                                    <input required id="edit_city_name" name="name" type="text" class="form-control">
                                                    <input id="city_id" name="text" type="hidden" class="form-control">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                        </form>
                                        
                                        </div>
                                        
                                        </div>
                                    </div>
                                </div>
                                
                    <!-- Modal -->
                    <!-- ============================================================== -->
                    <!-- data table  -->
                    <!-- ============================================================== -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                        <h3 class="card-header d-flex justify-content-between align-items-center">
                                City
                                <!-- <button type="button" class="btn btn-sm btn-success"  data-toggle="modal" data-target="#add_city">Add City</button> -->
                                <a type="button" class="btn btn-sm btn-success" href="<?php echo site_url('/city/add') ?>">Add City</a>
                                <!-- Wrap with <div>...buttons...</div> if you have multiple buttons -->
                       </h3>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="city_ajax" class="table table-striped table-bordered second" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Sl</th>
                                                <th>Name</th>
                                                <th>Status</th>
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
$(function(){
    <?php if(session()->has("city_success")) { ?>
        Swal.fire({
            icon: 'success',
            title: 'Great!',
            text: '<?= session("city_success") ?>'
        })
        setTimeout(function() { 
                location.reload();
                }, 1000);   
    <?php } ?>
    <?php if(session()->has("city_error")) { ?>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?= session("city_error") ?>'
        })
        setTimeout(function() { 
                location.reload();
                }, 1000);   
    <?php } ?>
    <?php if(session()->has("city_edit_success")) { ?>
        Swal.fire({
            icon: 'success',
            title: 'Great!',
            text: '<?= session("city_edit_success") ?>'
        })
        setTimeout(function() { 
                location.reload();
                }, 1000);   
    <?php } ?>
    <?php if(session()->has("city_edit_error")) { ?>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?= session("city_edit_error") ?>'
        })
        setTimeout(function() { 
                location.reload();
                }, 1000);   
    <?php } ?>
});
</script>
 <script>
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
                        url: "<?php echo base_url('city/status/') ?>"+entity_id + "/" + status,
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
     // Delete City
     function ajaxDelete(entity_id) {
        bootbox.confirm({
            message: "<?php echo "Are you sure to delete this item?"; ?>",
            buttons: {
                confirm: {
                    label: '<?php echo "Ok"; ?>',
                },
                cancel: {
                    label: '<?php echo "Cancel"; ?>',
                }
            },
            callback: function(deleteConfirm) {
                if (deleteConfirm) {
                    jQuery.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "<?php echo base_url('city/delete/') ?>"+entity_id,
                        data: {
                            'entity_id': entity_id
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
    $(document).ready(function() {
        $('#city_ajax').DataTable({
            ajax: {
                url: "<?php echo base_url('city/getAjaxData'); ?>",
                type: 'POST',
                dataType: 'json',
                dataSrc: ''
            },
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'status' },
                { data: 'action' }
            ]
        });
    });

 </script>
</html>

