   
    <div class="container login-container mt-5" id="requestHtml">
        <div class="row my-5 p-4">
            <div class="col-md-4 m-auto p-4 shadow rounded">
                <?= $this->session->flashdata("success"); ?>
                <form action="" method="post" id="forgetPasswordForm">
                    <div class="">
                        <h6 class="text-info h5"> <i class="fa fa-lock"></i> Forget Password (Student)</h6>
                        <div class="form-group">
                            <label for="userId" class="font-weight-bold"> Registered Mobile Number </label>
                            <input type="text" name="student_mobile" class="form-control" id="student_mobile">
                            <span class="text-danger" id="e_student_mobile"></span>
                        </div>

                        <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-info"> Send OTP
                                <img id="loader" style="display:none" src="<?= base_url('assets/images/loader/ajax-loader.gif')?>" alt="">
                            </button>
                        </div>
                    </div>
                </form>
                <div class="text-right">
                    <a href="<?= base_url('studentAuth')?>" class="text-primary">Log In</a>
                </div>
            </div>
        </div>
    </div>

<script>
    
$(document).ready(function(){
    //forget password form
    $("#forgetPasswordForm").on("submit", function(e){
        e.preventDefault();
        $.ajax({
            url: "<?= base_url('forgetPassword/studentOTP')?>",
            data: $(this).serialize(),
            type:"POST",
            dataType: "json",
            beforeSend:function(){
                $("#loader").show();
            },
            complete:function(){
                $("#loader").hide();
            },
            success:function(response){
                if(response["status"] == 0){
                    $("#e_student_mobile").html(response["student_mobile"]);
                }else{
                    $("#loader").hide();
                    $("#e_otp").html(response['otpStatus']);
                    $("#requestHtml").html(response['html']);
                    
                }
            }
        });
    });
   
})
    

    
function submitOTP(form){
    $.ajax({
        url: "<?= base_url('forgetPassword/checkStudentOTP')?>",
        data: {otp:$("#otp").val()},
        type:"POST",
        dataType: "json",
        beforeSend:function(){
            $("#loader").show();
        },
        complete:function(){
            $("#loader").hide();
        },
        success:function(response){
            if(response["status"] == 0){
                $("#e_otp").html(response["otp"]);
            }else{
                $("#loader").hide();
                $("#e_otp").html("");
                $("#requestHtml").html(response['html']);

            }
        }
    });
}        

    
function changePassword(){
    $.ajax({
        url: "<?= base_url('forgetPassword/changeStudentPassword')?>",
        data: {password:$("#password").val(), confirm_password:$("#confirm_password").val()},
        type:"POST",
        dataType: "json",
        beforeSend:function(){
            $("#loader").show();
        },
        complete:function(){
            $("#loader").hide();
        },
        success:function(response){
            if(response["status"] == 0){
                $("#e_password").html(response["password"]);
                $("#e_confirm_password").html(response["confirm_password"]);
                $("#e_message").html(response["message"]);
            }else{
                $("#loader").hide();
                $("#e_password").html("");
                $("#e_confirm_password").html("");
                window.location = "<?= base_url('studentAuth')?>";
            }
        }
    });
}    
</script>