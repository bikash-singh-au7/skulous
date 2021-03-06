<?php
    date_default_timezone_set("Asia/Kolkata");
    $today = date("Y-m-d");
?>   

<div class="container-fluid">
    <div class="row p-0">
        <div class="col-md-8 m-auto bg-white">
            <div class="page-header">
               <div class="inner-content">
                   <!-- Registration Details --> 
                   <div class="row">
                        <div class="col-md-12">
                            <?
                                if($this->session->flashdata("success") != ""){
                                    echo $this->session->flashdata("success");
                                }
                            ?>
                        </div>
                        <div class="col-md-12 p-0 m-0">
                            <div class="float-left px-2 py-2">
                                <p class="text-muted font-weight-bold m-0"> <i class="fa fa-user"></i> Admin Profile </p>
                            </div>
                            <div class="float-right px-2 py-1">
                                <button class="btn btn-success" onclick="updateData('<?= $data[0]->id?>')"> <span class="fa fa-edit"></span> Edit Profile  
                                <img id="editDataLoader" style="display:none" src="<?= base_url('assets/images/loader/ajax-loader.gif')?>">
                                </button>
                            </div>
                            
                        </div>
                    </div>
                    <div class="row px-2 py-2">
                        <div class="col-md-12 bg-white py-2 shadow-sm">
                            <p class="text-info font-weight-bold"> <i class="fa fa-user"></i> Personal Information</p>
                            <div class="float-left">
                                <img src="https://www.freeiconspng.com/uploads/male-icon-4.jpg" alt="" class="img profile-pic">
                            </div>
                            <div class="float-right">
                                <h5 class="text-info">  <i class="fa fa-user"></i> <?= $data[0]->admin_name?></h5>
                                <p class="p-0 m-0"> <i class="fa fa-phone"></i> <?= $data[0]->admin_mobile?></p>
                                <p class="p-0 m-0">  <i class="fa fa-envelope"></i> <?= $data[0]->admin_email?></p>
                            </div>
                        </div>
                        
                        <div class="col-md-12 bg-white py-2 mt-2 shadow-sm">
                            <p class="text-info font-weight-bold"> <i class="fa fa-lock"></i> Login Information</p>
                            <table class="table table-hover table-bordered">
                                <tr class="text-muted">
                                    <th>User Name</th>
                                    <th>Password</th>
                                    <th>Last Update</th>
                                    <th>Change Pasword</th>
                                </tr>
                                <tr class="text-muted">
                                    <td><?= $data[0]->user_name?></td>
                                    <td>*****</td>
                                    <td><?= date("d-M-Y", strtotime($data[0]->modified_date))?></td>
                                    <td class="text-center"> <button class="btn btn-info px-2 py-1" onclick="changePassword('<?= $data[0]->id?>')"> <i class="fa fa-edit"></i> </button> </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-12 bg-white py-2 mt-2 shadow-sm">
                            <p class="text-info font-weight-bold"> <i class="fa fa-industry"></i> Institute Information</p>
                            <table class="table table-hover table-bordered">
                                <tr class="text-muted">
                                    <th>Institute Name</th>
                                    <th>Institute Code</th>
                                </tr>
                                <tr class="text-muted">
                                    <td><?= $data[0]->institute_name?></td>
                                    <td><?= $data[0]->institute_code?></td>
                                    
                                </tr>
                            </table>
                        </div>
                        
                    </div>
               </div>     
            </div>

        </div>
    </div>
    
   <!--Update Form-->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="updateClasslabel">Update Profile</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="updateForm">
                    <div class="form-group">
                        <label for="">Name <span class="text-danger">*</span></label>
                        <input type="text" name="admin_name" class="form-control" placeholder="Name here" id="admin_name">
                        <span class="text-danger" id="e_admin_name"></span>
                        <input type="hidden" name="id" class="form-control" id="id">
                    </div>

                    <div class="form-group">
                        <label for="">Institute Name <span class="text-danger">*</span></label>
                        <input type="text" name="institute_name" class="form-control" value="" placeholder="Institute Name" id="institute_name">
                        <span class="text-danger" id="e_institute_name"></span>

                    </div>
                    <div class="form-group">
                        <label for="">Institute Code <span class="text-danger">*</span></label>
                        <input type="text" name="institute_code" class="form-control" value="" placeholder="Institute Code" id="institute_code">
                        <span class="text-danger" id="e_institute_code"></span>
                    </div>
                    
                    <div class="form-group">
                        <label for="">Mobile Number <span class="text-danger">*</span></label>
                        <input type="tel" name="admin_mobile" class="form-control" value="" placeholder="Mobile Number" id="admin_mobile">
                        <span class="text-danger" id="e_admin_mobile"></span>

                    </div>
                    
                    
                    <div class="form-group">
                        <label for="">Email Id <span class="text-danger">*</span></label>
                        <input type="email" name="admin_email" class="form-control" value="" placeholder="Email" id="admin_email">
                        <span class="text-danger" id="e_admin_email"></span>

                    </div>
                    
                    <div class="form-group">
                        <label for="">User Name <span class="text-danger">*</span></label>
                        <input type="text" name="user_name" class="form-control" value="" placeholder="User Name" id="user_name">
                        <span class="text-danger" id="e_user_name"></span>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info" name="updtSbmt" form="updateForm">Update
                    <img id="updateDataLoader" style="display:none" src="<?= base_url('assets/images/loader/ajax-loader.gif')?>">
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>  
   <!--Change Password-->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="updateClasslabel">Change Password</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 m-auto">
                        <form action="" method="post" id="changePasswordForm">
                            <div class="form-group">
                                <label for="">Old Password</label>
                                <input type="text" class="form-control" name="old_password" id="old_password">
                                <input type="hidden" name="admin_id" id="admin_id">
                                <span class="text-danger" id="e_old_password"></span>
                            </div>
                            <div class="form-group">
                                <label for="">New Password</label>
                                <input type="text" class="form-control" name="new_password" id="new_pasword">
                                <span class="text-danger" id="e_new_password"></span>
                            </div>
                            <div class="form-group">
                                <label for="">Confirm Password</label>
                                <input type="text" class="form-control" name="confirm_password" id="confirm_pasword">
                                <span class="text-danger" id="e_confirm_password"></span>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info" name="updtSbmt" form="changePasswordForm">Update
                    <img id="updateDataLoader" style="display:none" src="<?= base_url('assets/images/loader/ajax-loader.gif')?>">
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

<!---Ajax here-->
<script>
    //Make Payment
    function updateData(id){
        $("#updateModal").modal("show");
        $("#e_admin_name").html("");
        $("#e_institute_name").html("");
        $("#e_institute_code").html("");
        $("#e_admin_mobile").html("");
        $("#e_admin_email").html("");
        $("#e_user_name").html("");
        $.ajax({
            url: "<?= base_url('adminSetup/getData')?>",
            type: "POST",
            data : {id:id},
            dataType: "json",
            beforeSend:function(){
                $("#editDataLoader").show();
            },
            complete:function(){
                $("#editDataLoader").hide();
            },
            success: function(response){
                if(response["status"]==1){
                    $("#id").val(id);
                    $("#admin_name").val(response["admin_name"]);
                    $("#institute_name").val(response["institute_name"]);
                    $("#institute_code").val(response["institute_code"]);
                    $("#admin_mobile").val(response["admin_mobile"]);
                    $("#admin_email").val(response["admin_email"]);
                    $("#user_name").val(response["user_name"]);
                }else{
                    $("#updateModal").modal("hide");
                    Swal.fire(
                      'Oops error!!',
                      "Somthing is Wrong Try again sometime",
                      'error'
                    )
                }
            }
        });
        
    }
    
    $(function(){
        $("#updateForm").on("submit", function(e){
            e.preventDefault();
            $.ajax({
                url: "<?= base_url('adminSetup/updateData')?>",
                type: "POST",
                data : $(this).serialize(),
                dataType: "json",
                beforeSend:function(){
                    $("#updateDataLoader").show();
                    },
                complete:function(){
                    $("#updateDataLoader").hide();
                },
                success: function(response){
                    if(response["status"]==0){
                        $("#e_admin_name").html(response["admin_name"]);
                        $("#e_institute_name").html(response["institute_name"]);
                        $("#e_institute_code").html(response["institute_code"]);
                        $("#e_admin_mobile").html(response["admin_mobile"]);
                        $("#e_admin_email").html(response["admin_email"]);
                        $("#e_user_name").html(response["user_name"]);
                    }else if(response["status"]==2){
                        $("#updateModal").modal("hide");
                        Swal.fire(
                          response["alert"],
                          response["message"],
                          response["modal"]
                        )
                             
                    }else{
                        window.location = response["redirect"];
                    }
                }
            });
        })
    });
    
    
    
    function changePassword(id){
        $("#changePasswordModal").modal("show");
        $("#admin_id").val(id);
        
        $("#e_old_password").html("");
        $("#e_new_password").html("");
        $("#e_confirm_password").html("");
    }
    
    $("#changePasswordForm").on("submit", function(e){
        e.preventDefault();
        $.ajax({
            url:"<?= base_url('adminsetup/setting/update')?>",
            data: $(this).serialize(),
            dataType: 'json',
            type: 'POST',
            success: function(response){
                if(response["status"] == 0){
                    $("#e_old_password").html(response["old_password"]);
                    $("#e_new_password").html(response["new_password"]);
                    $("#e_confirm_password").html(response["confirm_password"]);
                }else{
                    // Set value
                    $(".form-control").val("");
                    
                    $("#changePasswordModal").modal("hide");
                    Swal.fire(
                      response["alert"],
                      response["message"],
                      response["modal"]
                    )
                }
            }
        })
    })
   
   
</script>



