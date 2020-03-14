<?php
if($action == "otpForm"){
    ?>
    <div class="row my-5 p-4">
        <div class="col-md-4 m-auto p-4 shadow rounded">
            <?= $this->session->flashdata("success"); ?>
                <div class="">
                    <h6 class="text-info h5"> <i class="fa fa-lock"></i> Enter OTP</h6>
                    <div class="form-group">
                        <input type="text" name="otp" id="otp" class="form-control" autocomplete="off">
                        <span class="text-danger" id="e_otp"></span>
                    </div>

                    <div class="form-group">
                        <button type="button" name="submit" class="btn btn-info" onclick="submitOTP('otpForm')"> Reset Password
                            <img id="loader" style="display:none" src="<?= base_url('assets/images/loader/ajax-loader.gif')?>" alt="">
                        </button>
                    </div>
            </div>
        </div>
    </div>
    <?
}
if($action == "passwordForm"){
    ?>
    <div class="row my-5 p-4">
        <div class="col-md-4 m-auto p-4 shadow rounded">
            <?= $this->session->flashdata("success"); ?>
            
                <div class="">
                    <h6 class="text-info h5"> <i class="fa fa-lock"></i> Create New Password</h6>
                    <div class="form-group">
                        <label for="">New Password</label>
                        <input type="password" name="password" id="password" class="form-control" autocomplete="off">
                        <span class="text-danger" id="e_password"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" autocomplete="off">
                        <span class="text-danger" id="e_confirm_password"></span>
                        <span class="text-danger" id="e_message"></span>
                    </div>

                    <div class="form-group">
                        <button type="submit" name="button" class="btn btn-info" onclick="changePassword()"> Change Password
                            <img id="loader" style="display:none" src="<?= base_url('assets/images/loader/ajax-loader.gif')?>" alt="">
                        </button>
                    </div>
                </div>
           

        </div>
    </div>
    <?
}

?>
