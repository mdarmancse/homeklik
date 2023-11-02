
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
                            <h2 class="pageheader-title">Slider Image</h2>
                            <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><i class="fas fa-tachometer-alt "></i><a href="<?php echo site_url('/') ?>" class="breadcrumb-link"> Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><i class="fa fa-fw fa-image"></i> Slider Image</li>
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
                        Slider Image
                        <a type="button" class="btn btn-sm btn-success" href="<?php echo site_url('/slider/add') ?>">Add Slider</a>


                                <!-- Wrap with <div>...buttons...</div> if you have multiple buttons -->
                       </h3>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="slider_ajax" class="table table-striped table-bordered second" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Sl</th>
                                                <th>Image</th>
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
    <?php if(session()->has("slider_success")) { ?>
        Swal.fire({
            icon: 'success',
            title: 'Great!',
            text: '<?= session("slider_success") ?>'
        })
        setTimeout(function() { 
                location.reload();
                }, 1000);   
    <?php } ?>
    <?php if(session()->has("slider_error")) { ?>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?= session("slider_error") ?>'
        })
        setTimeout(function() { 
                location.reload();
                }, 1000);   
    <?php } ?>
    <?php if(session()->has("slider_delete_success")) { ?>
        Swal.fire({
            icon: 'success',
            title: 'Great!',
            text: '<?= session("slider_delete_success") ?>'
        })
        setTimeout(function() { 
                location.reload();
                }, 1000);   
    <?php } ?>
    <?php if(session()->has("slider_delete_error")) { ?>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?= session("slider_delete_error") ?>'
        })
        setTimeout(function() { 
                location.reload();
                }, 1000);   
    <?php } ?>
});
    // Status Change Slider
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
                        url: "<?php echo base_url('slider/status/') ?>"+entity_id + "/" + status,
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
     // Status Change Slider
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
            callback: function(dsiableConfirm) {
                if (dsiableConfirm) {
                    jQuery.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "<?php echo base_url('slider/delete/') ?>"+entity_id,
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
    $(document).ready(function() {
        $('#slider_ajax').DataTable({
            ajax: {
                url: "<?php echo base_url('slider/getAjaxData'); ?>",
                type: 'POST',
                dataType: 'json',
                dataSrc: ''
            },
            columns: [
                { data: 'id' },
                { data: 'image' },
                { data: 'status' },
                { data: 'action' }
            ]
        });
    });

 </script>
</html>

