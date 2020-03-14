<div class="container-fluid">
    <div class="row p-0">
        <div class="col-md-11 m-auto">
            <div class="page-header">
               <div class="inner-content">
                   <!-- Class Details --> 
                   <div class="row">
                        <div class="col-md-12 p-0 m-0" id="alert">
                            
                        </div>
                        <div class="col-md-12 p-0 m-0 border">
                            <div class="float-left px-2 py-2">
                                <span class="text-muted font-weight-bold"> <i class="fa fa-cog"></i> Manage Staff</span>
                            </div>
                            <div class="float-right px-2">
                                <button class="btn btn-info px-2 my-1" type="button" data-toggle="modal" data-target="#addModal" id="addBtn"> <i class="fa fa-plus"></i> Add Staff </button>
                            </div>
                        </div>
                    </div>
                    <div class="">
                       <div class="row border">
                        <div class="col-md-12 m-auto p-2 table-responsive">
                            <table id="dataTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#Id</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th class="text-center">DOC</th>
                                        <th class="text-center">Action</th>
                                      
                                    </tr> 
                                </thead>
                                <tbody>
                                    <?php
                                        foreach($data as $value){
                                        ?>
                                            <tr id="row-<?=$value->id?>">
                                                <td><?=$value->id?></td>
                                                <td><?=$value->staff_name?></td>
                                                <td><?=$value->mobile_number?></td>
                                                <td><?=$value->email?></td>
                                                <td class="text-center">
                                                    <?php
                                                        if($value->staff_status == 1){
                                                            $status = 1;
                                                            echo"<span class='badge badge-info'>Active</span>";
                                                        }else{
                                                            $status = 0;
                                                            echo"<span class='badge badge-danger'>Disable</span>";
                                                        }
                                                    ?>
                                                </td>
                                                <td class="text-center"><?=date("d-M-Y h:m:s A", strtotime($value->created_date))?></td>
                                                    
                                                <td class="text-center">
                                                    <button class="btn btn-info px-2 py-1" onclick="getId('<?= $value->id?>')"> <i class="fa fa-edit"></i> </button>
                                                    
                                                    <button class="btn btn-success px-2 py-1" onclick="getPermission('<?= $value->id?>')"> <i class="fa fa-cog"></i> </button>
                                                    
                                                    <button class="btn btn-danger px-2 py-1" onclick="deleteData('<?= $value->id?>')"> <i class="fa fa-trash"></i> </button>
                                                </td>
                                                
                                            </tr>
                                            <?
                                        } 
                                    ?>
                                </tbody>
                            </table> 
                                
                        </div> 
                        </div>   
                    </div>  
               </div>     
        </div>
        
        <!--Delete session Modal---->
        <div class="modal fade" id="deleteModal-" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="deleteModallabel">Delete Subject</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img class="img img-responsive" height=100 src="<?= base_url('assets/images/danger.png')?>" alt="">
                    <h5 class="text-muted">Do you want to delete?</h5>
                </div>
                <div class="m-auto pb-2">
                    <form action="" method="post" id="deleteForm">
                        <input type="hidden" value="" name="subject_id" id="delete_subject_id">
                        <button type="submit" class="btn btn-danger" name="delSbmt">Delete</button>
                        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    </form>
                                                            
                </div>
                </div>
            </div>
        </div>

        <!--Update Form-->
        <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="updateModallabel"> <i class="fa fa-edit"></i> Update Staff</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="updateForm">
                        <div class="form-group">
                            <label for="">Staff name <span class="text-danger">*</span></label>
                            <input type="text" name="staff_name" class="form-control" value="" placeholder="Enter subject name" id="update_staff_name">
                            
                            <input type="hidden" name="staff_id" class="form-control" value="" id="update_staff_id">
                            
                            <span class="text-danger" id="e_update_staff_name"></span>
                            
                        </div>
                        <div class="form-group">
                            <label for="">Gender <span class="text-danger">*</span></label>
                            <select name="gender" id="update_gender" class="form-control">
                                <option value="">--Gender--</option>
                                <option value="MALE">MALE</option>
                                <option value="FEMALE">FEMALE</option>
                            </select>
                            <span class="text-danger" id="e_update_gender"></span>
                            
                        </div> 
                           
                        <div class="form-group">
                            <label for="">Mobile Number <span class="text-danger">*</span></label>
                            <input type="text" name="mobile_number" class="form-control" value="" placeholder="Enter subject name" id="update_mobile_number">
                            <span class="text-danger" id="e_update_mobile_number"></span>
                            
                        </div>
                                                                   
                        <div class="form-group">
                            <label for="">Email Address <span class="text-danger">*</span></label>
                            <input type="text" name="email" class="form-control" value="" placeholder="Enter subject name" id="update_email">
                            <span class="text-danger" id="e_update_email"></span>
                            
                        </div>
                                                                   
                        <div class="form-group">
                            <label for="">Update Status <span class="text-danger">*</span></label>
                            <select name="staff_status" id="update_staff_status" class="form-control">
                                <option value="">--Select--</option>
                                <option value="1">Active</option>
                                <option value="0">disabled</option>
                            </select>
                            <span class="text-danger" id="e_update_staff_status"></span>
                            
                        </div>
                                                                    
                        <div class="form-group">
                            <label for="">Address <span class="text-danger">*</span></label>
                            <input type="text" name="address" class="form-control" value="" placeholder="Enter subject name" id="update_address">
                            <span class="text-danger" id="e_update_address"></span>
                            
                        </div>
                                                                
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info" name="updtSbmt" form="updateForm">Update</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>

        <!--Permission form---->
        <div class="modal fade" id="permissionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="addModallabel">Grant Permission</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-4">
                    <form action="" method="post" id="permissionForm">
                        <div class="row">
                           <div class="col-md-6 border p-2 font-weight-bold">Operation Name</div>
                           <div class="col-md-6 border p-2 font-weight-bold">Checkout</div>
                           
                           <div class="col-md-6 border p-2">Session</div>
                           <div class="col-md-6 border p-2">
                               <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="session" id="session" value="1">
                                    <input type="hidden" class="" name="staff_id" id="permission_staff_id">
                                    <label class="custom-control-label" for="session">Toggle me</label>
                                </div>
                           </div>
                           <div class="col-md-6 border p-2">Class</div>
                           <div class="col-md-6 border p-2">
                               <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="classes" id="classes" value="1">
                                    <label class="custom-control-label" for="classes">Toggle me</label>
                                </div>
                           </div>
                           <div class="col-md-6 border p-2">Subject</div>
                           <div class="col-md-6 border p-2">
                               <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="subject" id="subject" value="1">
                                    <label class="custom-control-label" for="subject">Toggle me</label>
                                </div>
                           </div>
                           <div class="col-md-6 border p-2">Staff</div>
                           <div class="col-md-6 border p-2">
                               <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="staff" id="staff" value="1">
                                    <label class="custom-control-label" for="staff">Toggle me</label>
                                </div>
                           </div>
                           <div class="col-md-6 border p-2">Registration</div>
                           <div class="col-md-6 border p-2">
                               <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="registration" id="registration" value="1">
                                    <label class="custom-control-label" for="registration">Toggle me</label>
                                </div>
                           </div>
                           <div class="col-md-6 border p-2">Payment</div>
                           <div class="col-md-6 border p-2">
                               <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="payment" id="payment" value="1">
                                    <label class="custom-control-label" for="payment">Toggle me</label>
                                </div>
                           </div>

                           <div class="col-md-6 border p-2">SMS</div>
                           <div class="col-md-6 border p-2">
                               <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="sms" id="sms" value="1">
                                    <label class="custom-control-label" for="sms">Toggle me</label>
                                </div>
                           </div>

                       </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info" form="permissionForm">Grant</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!---Ajax here-->
<script>
    //get permission
    var url = "";
    function getPermission(id){
        $("#session").prop("checked", false);
        $("#classes").prop("checked", false);
        $("#subject").prop("checked", false);
        $("#staff").prop("checked", false);
        $("#registration").prop("checked", false);
        $("#payment").prop("checked", false);
        $("#sms").prop("checked", false);
        $("#permissionModal").modal("show");
        $("#permission_staff_id").val(id);
        $.ajax({
                url: '<?= base_url("staffsetup/getPermission")?>',
                type: 'POST',
                data: {staff_id:id},
                dataType: 'json',
                success: function(response){
                    if(response["status"] == 0){
                        url = "<?= base_url("staffsetup/addPermission")?>";
                    }else{
                        url = "<?= base_url("staffsetup/updatePermission")?>";
                        if(response["session"] != null){
                            $("#session").prop("checked", true);
                        }
                        if(response["classes"] != null){
                            $("#classes").prop("checked", true);
                        }
                        if(response["subject"] != null){
                            $("#subject").prop("checked", true);
                        }
                        if(response["staff"] != null){
                            $("#staff").prop("checked", true);
                        }
                        if(response["registration"] != null){
                            $("#registration").prop("checked", true);
                        }
                        if(response["payment"] != null){
                            $("#payment").prop("checked", true);
                        }
                        if(response["sms"] != null){
                            $("#sms").prop("checked", true);
                        }
                    }
                }
        });
    }

    $("body").on("submit", "#permissionForm", function(e){
        e.preventDefault();
        
        $.ajax({
            url: url,
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response){
                Swal.fire(
                  response["alert"],
                  response["message"],
                  response["modal"]
                )
                $("#permissionModal").modal("hide");
            }
        });
    });
    
    

    //delete
    function deleteData(id){
        $("#deleteModal").modal("show");
        $("#delete_subject_id").val(id);
        
        $("#alert").html("");
        
    }
    
    $(document).ready(function(){
        $("body").on("submit", "#deleteForm", function(e){
            e.preventDefault();
            $.ajax({
                url: '<?= base_url("subjectsetup/deleteData")?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){
                    $("#"+response["rowId"]).remove();
                    $("#deleteModal").modal("hide");
                    $("#alert").html(response["alert"]);
                }
            });
        })
    });

    //Get id for updating the data
    function getId(id){
        $("#updateModal").modal("show");
        $("#update_staff_id").val(id);
        $("#update_staff_status").removeAttr("selected");
        $("#update_gender").removeAttr("selected");
        $.ajax({
                url: '<?= base_url("staffsetup/getData")?>',
                type: 'POST',
                data: {staff_id:id},
                dataType: 'json',
                success: function(response){
                    $("#update_gender option[value="+response["gender"]+"]").attr('selected', 'selected');
                    $("#update_staff_name").val(response["staff_name"]);
                    $("#update_mobile_number").val(response["mobile_number"]);
                    $("#update_email").val(response["email"]);
                    $("#update_staff_status option[value="+response["staff_status"]+"]").attr('selected', 'selected');
                    $("#update_address").val(response["address"]);
                }
        });
    }

    //Add data
    $(document).ready(function(){
        $("body").on("submit", "#addForm", function(e){
            e.preventDefault();
            $.ajax({
                url: '<?= base_url("subjectsetup/addSubject/manage-add")?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){
                    if(response["status"] == 0){
                        //set error message 
                        $("#e_add_subject_name").html(response["subject_name"]);
                        $("#e_add_subject_code").html(response["subject_code"]);
                        $("#e_add_comment").html(response["coment"]);
                    }else{
                        //set blank value for error message
                        $("#e_add_subject_name").html("");
                        $("#e_add_subject_code").html("");
                        $("#e_add_comment").html("");

                        //set blank value after inserting the value
                        $("#add_subject_name").val("");
                        $("#add_subject_code").val("");
                        $("#add_comment").val("");
                        
                        //hide modal
                        $("#addModal").modal("hide");
                        //set message for alert box
                        Swal.fire(
                          response["alert"],
                          response["message"],
                          response["modal"]
                        );
                        //add new row
                        $("#dataTable").append(response["lastRow"]);

                    }
                }
            });
        });


        
        //update data
        $("body").on("submit", "#updateForm", function(e){
            e.preventDefault();
            $.ajax({
                url: '<?= base_url("staffsetup/updateData")?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){
                    if(response["status"] == 0){
                        //set error message 
                        $("#e_update_staff_name").html(response["staff_name"]);
                        $("#e_update_gender").html(response["gender"]);
                        $("#e_update_mobile_number").html(response["mobile_number"]);
                        $("#e_update_email").html(response["email"]);
                        $("#e_update_staff_status").html(response["staff_status"]);
                        $("#e_update_address").html(response["address"]);
                    }else{
                        //set blank value for error message
                        $("#e_update_staff_name").html("");
                        $("#e_update_mobile_number").html("");
                        $("#e_update_email").html("");
                        $("#e_staff_status").html("");
                        $("#e_update_address").html("");
                        
                        $("#update_staff_status option").removeAttr("selected");
                        
                        //set message for alert box
                        Swal.fire(
                          response["alert"],
                          response["message"],
                          response["modal"]
                        );
                        
                        $("#updateModal").modal("hide");
                        $("#"+response["rowId"]).html(response["updatedRow"]);

                    }
                }
            });
        });
        
        $("#addBtn").click(function(){
            $("#alert").html("");
        });
        $(".updateBtn").click(function(){
            $("#alert").html("");
        });

    });
</script>