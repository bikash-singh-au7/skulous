<?php
    $data["data"] = $this->work->select_data("registration", ["id"=>$this->session->userdata("id")]);
    $data = $data["data"];
    ?>
    <div class="container">
        <div class="row">
           <div class="col-md-7  m-auto">
            <?
            foreach($data as $value){
                ?>  <div class="row px-2 my-1">
                        <div class="col-md-12 m-0 shadow-sm bg-white">
                            <h6 class="py-2 "> <i class="fa fa-edit"></i> Change Password</h6>
                        </div>
                    </div>
                    <div class="row px-2">
                       
                        <!--Personal Details--->
                        <div class="col-md-12 shadow-sm py-2 mb-1 bg-white m-auto">
                            <div class="row">
                                <div class="col-md-12 m-auto">
                                    <form action="" method="post" id="updateForm">
                                        <div class="form-group">
                                            <label for="">Old Password</label>
                                            <input type="password" class="form-control" name="old_password" id="old_password">
                                            <span class="text-danger" id="e_old_password"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="">New Password</label>
                                            <input type="password" class="form-control" name="new_password" id="new_pasword">
                                            <span class="text-danger" id="e_new_password"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Confirm Password</label>
                                            <input type="password" class="form-control" name="confirm_password" id="confirm_pasword">
                                            <span class="text-danger" id="e_confirm_password"></span>
                                        </div>
                                        
                                    </form>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-info rounded-0" form="updateForm"> <i class="fa fa-send"></i> Update</button>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                <?
            }
        ?>
        </div>
    </div>
</div>
<script>
    $("#updateForm").on("submit", function(e){
        e.preventDefault();
        $.ajax({
            url:"<?= base_url('student/setting/update')?>",
            data: $(this).serialize(),
            dataType: 'json',
            type: 'POST',
            success: function(response){
                if(response["status"] == 0){
                    $("#e_old_password").html(response["old_password"]);
                    $("#e_new_password").html(response["new_password"]);
                    $("#e_confirm_password").html(response["confirm_password"]);
                }else{
                    // Set message
                    $("#e_old_password").html("");
                    $("#e_new_password").html("");
                    $("#e_confirm_password").html("");
                    
                    // Set value
                    $(".form-control").val("");
                    
                    // set message for alert box
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