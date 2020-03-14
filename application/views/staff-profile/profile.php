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
                                <p class="text-muted font-weight-bold m-0"> <i class="fa fa-user"></i> Staff Profile </p>
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
                                <h5 class="text-info">  <i class="fa fa-user"></i> <?= $data[0]->staff_name?></h5>
                                <p class="p-0 m-0"> <i class="fa fa-phone"></i> <?= $data[0]->mobile_number?></p>
                                <p class="p-0 m-0">  <i class="fa fa-envelope"></i> <?= $data[0]->email?></p>
                            </div>
                        </div>
                        
                        <div class="col-md-12 bg-white py-2 mt-2 shadow-sm">
                            <p class="text-info font-weight-bold"> <i class="fa fa-lock"></i> Login Information</p>
                            <table class="table table-hover table-bordered">
                                <tr class="text-muted">
                                    <th>User Name</th>
                                    <th>Password</th>
                                    <th>Change Pasword</th>
                                </tr>
                                <tr class="text-muted">
                                    <td><?= $data[0]->mobile_number?></td>
                                    <td>*****</td>
                                    <td class="text-center"> <button class="btn btn-info px-2 py-1" onclick="changePassword('<?= $data[0]->id?>')"> <i class="fa fa-edit"></i> </button> </td>
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
                        <input type="text" name="staff_name" class="form-control" placeholder="Name here" id="staff_name">
                        
                        <input type="hidden" name="staff_status" class="form-control" value="1">
                        
                        <span class="text-danger" id="e_staff_name"></span>
                        <input type="hidden" name="id" class="form-control" id="id">
                    </div>

                    
                    <div class="form-group">
                        <label for="">Gender <span class="text-danger">*</span></label>
                        <select name="gender" id="gender" class="form-control">
                            <option value="">--Gender--</option>
                            <option value="MALE">MALE</option>
                            <option value="FEMALE">FEMALE</option>
                        </select>
                        <span class="text-danger" id="e_gender"></span>

                    </div>
                    
                    <div class="form-group">
                        <label for="">Mobile Number <span class="text-danger">*</span></label>
                        <input type="tel" name="mobile_number" class="form-control" value="" placeholder="Mobile Number" id="mobile_number">
                        <span class="text-danger" id="e_mobile_number"></span>

                    </div>
                    
                    
                    <div class="form-group">
                        <label for="">Email Id <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="" placeholder="Email" id="email">
                        <span class="text-danger" id="e_email"></span>

                    </div>
                  
                    
                    <div class="form-group">
                        <label for="">Address <span class="text-danger">*</span></label>
                        <input type="text" name="address" class="form-control" value="" placeholder="Address" id="address">
                        <span class="text-danger" id="e_address"></span>

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
                                <input type="hidden" name="id" id="staff_id">
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
    //Update Data
    function updateData(id){
        $("#updateModal").modal("show");
        $("#e_staff_name").html("");
        $("#e_gender").removeAttr("selected");
        $("#e_mobile_number").html("");
        $("#e_email").html("");
        $("#e_address").html("");
        $.ajax({
            url: "<?= base_url('staffSetup/getData')?>",
            type: "POST",
            data : {staff_id:id},
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
                    $("#staff_name").val(response["staff_name"]);
                    $("#gender option[value="+response["gender"]+"]").attr('selected', 'selected');
                    $("#mobile_number").val(response["mobile_number"]);
                    $("#email").val(response["email"]);
                    $("#address").val(response["address"]);
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
                url: "<?= base_url('staffSetup/updateData')?>",
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
                        $("#e_staff_name").html(response["staff_name"]);
                        $("#e_gender").html(response["gender"]);
                        $("#e_mobile_number").html(response["mobile_number"]);
                        $("#e_email").html(response["email"]);
                        $("#e_address").html(response["address"]);
                    }else{
                        window.location = response["redirect"];
                    }
                }
            });
        })
    });
    
    
    
    function changePassword(id){
        $("#changePasswordModal").modal("show");
        $("#staff_id").val(id);
        
        $("#e_old_password").html("");
        $("#e_new_password").html("");
        $("#e_confirm_password").html("");
    }
    
    $("#changePasswordForm").on("submit", function(e){
        e.preventDefault();
        $.ajax({
            url:"<?= base_url('staffsetup/updatePassword')?>",
            data: $(this).serialize(),
            dataType: 'json',
            type: 'POST',
            success: function(response){
                if(response["status"] == 0){
                    $("#e_old_password").html(response["old_password"]);
                    $("#e_new_password").html(response["new_password"]);
                    $("#e_confirm_password").html(response["confirm_password"]);
                }else{                    
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



