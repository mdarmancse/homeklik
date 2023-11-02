
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
                            <h2 class="pageheader-title">Tour</h2>
                            <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><i class="fas fa-tachometer-alt "></i><a href="<?php echo site_url('/') ?>" class="breadcrumb-link"> Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><i class="fa fa-fw fa-plane"></i> Tour</li>
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
                         Tour
                        <!-- <a type="button" class="btn btn-sm btn-success" href="<?php echo site_url('/brand/add') ?>">Add Brand</a> -->


                                <!-- Wrap with <div>...buttons...</div> if you have multiple buttons -->
                       </h3>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tour_ajax" class="table table-striped table-bordered second" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Sl</th>
                                                <th>Listing ID</th>
                                                <th>Client Name</th>
                                                <th>Realtor Name</th>
                                                <th>Shift</th>
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
            <!-- Modal -->
<div id="assignRealtor" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Assign Realtor</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
                
            </div>
            <div class="modal-body">
                <form id="assign_realtor" name="assign_realtor" method="post" class="form-horizontal" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="hidden" name="tour_id" id="tour_id" value="">
                                <label class="control-label col-md-4"><?php echo "Assign Realtor" ?><span class="required">*</span></label>
                                <div class="col-sm-8">
                                    <select name="realtor_id" id="realtor_id" class="form-control form-filter input-sm">
                                        <option>-------Select------</option>
                                        <?php
                                        foreach ($realtors as $key => $value) { ?>
                                            <option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                                        <?php  } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-actions fluid">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-sm  danger-btn filter-submit margin-bottom btn-info" name="submit_page" id="submit_page" value="Assign"><span><?php echo "Assign" ?></span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--  -->
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
    $(document).ready(function() {
        $('#tour_ajax').DataTable({
            ajax: {
                url: "<?php echo base_url('tour/getAjaxData'); ?>",
                type: 'POST',
                dataType: 'json',
                dataSrc: ''
            },
            columns: [
                { data: 'id' },
                { data: 'listing_id' },
                { data: 'name' },
                { data: 'realtor_name' },
                { data: 'shift' },
                { data: 'action' },
              
            ]
        });
    });
     //add status
     function assignRealtor(entity_id) {
        $('#tour_id').val(entity_id);
        $('#assignRealtor').modal('show');
     }
     $('#assign_realtor').submit(function() {
        var tour_id = $('#tour_id').val();
        var realtor_id = $('#realtor_id').val();
        $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo base_url('tour/assign_realtor/') ?>"+tour_id + "/" + realtor_id,
                data: {
                    'tour_id': tour_id,
                    'realtor_id': realtor_id 
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
        return false;
    });
    function acceptRequest(tour_id,user_id) {
        bootbox.confirm({
            message: "<?php echo "Are you sure to accept this request?"; ?>",
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
                    $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: "<?php echo base_url('tour/confirmRequest/') ?>"+tour_id + "/"+ user_id,
                            data: {
                                'tour_id': tour_id,
                                'user_id':user_id,
                                'value': 1
                            },
                            success: function(response) {
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
                    return false;
    }
            }
        });
     }
     function deleteRequest(tour_id,user_id) {
        bootbox.confirm({
            message: "<?php echo "Are you sure to delete this request?"; ?>",
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
                    $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: "<?php echo base_url('tour/confirmRequest/') ?>"+tour_id + "/"+ user_id,
                            data: {
                                'tour_id': tour_id,
                                'user_id':user_id,
                                'value': 0
                            },
                            success: function(response) {
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
                    return false;
    }
            }
        });
     }

 </script>
</html>

