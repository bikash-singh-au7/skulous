<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");

class ForgetPassword extends CI_Controller {
    public function __construct() {
		parent::__construct();
		//check login session is set or not
		
        
    }
    
    //======================Admin Forget Password==========================///
    
    public function admin($action=null){
        $this->load->view("header/header.php");
        $this->load->view("forget-password/admin/fp.php");
        $this->load->view("footer/footer.php");
    }
    
    public function adminOTP(){
        $this->form_validation->set_rules("admin_mobile", "Admin Mobile", "required|trim");
        if($this->form_validation->run()){
            $admin_mobile = $this->input->post("admin_mobile");
            $data = $this->work->select_data("admin", ["admin_status"=>1, "admin_mobile"=>$admin_mobile]);
            
            if(!empty($data[0])){
                $otp = rand(1111,9999);
                $this->session->set_userdata("otp", $otp);
                $this->session->set_userdata("id", $data[0]->id);
                $msg = "Your OTP is : ".$otp." Please dont share with anyone";
                if($this->work->send_sms($admin_mobile, $msg, "VJTEXT")){
                    $response["status"] = 1;
                    $response["otpStatus"] = "<span class='text-success'>Otp send Successfully</span>";
                    $response["html"] = $this->load->view("forget-password/admin/print-row.php", ["action"=>"otpForm"], true);
                }else{
                    $response["status"] = 0;
                    $response["otpStatus"] = "Otp not send";
                }
            }else{
                $response["status"] = 0;
                $response["admin_mobile"] = "Mobile is not registered!!";
            }
        }else{
            $response["status"] = 0;
            $response["admin_mobile"] = strip_tags(form_error("admin_mobile"));
        }
        echo json_encode($response);
    }
    
    public function checkAdminOTP(){
        $this->form_validation->set_rules("otp", "OTP", "required|trim|max_length[4]");
        if($this->form_validation->run()){
            $otp = $this->input->post("otp");
            $session_otp = $this->session->userdata("otp");
            
            if($otp == $session_otp){
                    $response["status"] = 1;
                    $response["html"] = $this->load->view("forget-password/admin/print-row.php", ["action"=>"passwordForm"], true);
            }else{
                $response["status"] = 0;
                $response["otp"] = "Please enter valid OTP !!";
            }
        }else{
            $response["status"] = 0;
            $response["otp"] = strip_tags(form_error("otp"));
        }
        echo json_encode($response);
    }
    
    public function changeAdminPassword(){
        $this->form_validation->set_rules("password", "password", "required|trim|max_length[8]");
        $this->form_validation->set_rules("confirm_password", "Conform password", "required|trim|matches[password]");
        if($this->form_validation->run()){
            $password = $this->input->post("password");
            $id = $this->session->userdata("id");
            $data = [
                "password"=> md5($password)
            ];
            if($this->work->update_data("admin", $data, ['id'=>$id])){
                $response["status"] = 1;
                $this->session->unset_userdata("otp");
                $this->session->unset_userdata("id");
                $this->session->set_flashdata("success", "<div class='alert alert-success'>Password Successfully updated! Login Again.</div>");
                $response["html"] = "<a href='".base_url("auth")."' class='btn btn-info'> Login Now </a>";
            }else{
                $response["status"] = 0;
                $response["message"] = "Oops error occured! try after some time";
            }
        }else{
            $response["status"] = 0;
            $response["password"] = strip_tags(form_error("password"));
            $response["confirm_password"] = strip_tags(form_error("confirm_password"));
        }
        echo json_encode($response);
    }
    
    
    
    //================Staff Forget Password================//
    public function staff($action=null){
        $this->load->view("header/header.php");
        $this->load->view("forget-password/staff/fp.php");
        $this->load->view("footer/footer.php");
    }
    
    public function staffOTP(){
        $this->form_validation->set_rules("staff_mobile", "Staff Mobile", "required|trim|numeric");
        if($this->form_validation->run()){
            $staff_mobile = $this->input->post("staff_mobile");
            $data = $this->work->select_data("staff", ["staff_status"=>1, "mobile_number"=>$staff_mobile]);
            
            if(!empty($data[0])){
                $otp = rand(1111,9999);
                $this->session->set_userdata("otp", $otp);
                $this->session->set_userdata("id", $data[0]->id);
                $msg = "Your OTP is : ".$otp." Please dont share with anyone";
                if($this->work->send_sms($staff_mobile, $msg, "VJTEXT")){
                    $response["status"] = 1;
                    $response["otpStatus"] = "<span class='text-success'>Otp send Successfully</span>";
                    $response["html"] = $this->load->view("forget-password/staff/print-row.php", ["action"=>"otpForm"], true);
                }else{
                    $response["status"] = 0;
                    $response["otpStatus"] = "Otp not send";
                }
            }else{
                $response["status"] = 0;
                $response["staff_mobile"] = "Mobile is not registered!!";
            }
        }else{
            $response["status"] = 0;
            $response["staff_mobile"] = strip_tags(form_error("staff_mobile"));
        }
        echo json_encode($response);
    }
    
    public function checkStaffOTP(){
        $this->form_validation->set_rules("otp", "OTP", "required|trim|max_length[4]");
        if($this->form_validation->run()){
            $otp = $this->input->post("otp");
            $session_otp = $this->session->userdata("otp");
            
            if($otp == $session_otp){
                    $response["status"] = 1;
                    $response["html"] = $this->load->view("forget-password/staff/print-row.php", ["action"=>"passwordForm"], true);
            }else{
                $response["status"] = 0;
                $response["otp"] = "Please enter valid OTP !!";
            }
        }else{
            $response["status"] = 0;
            $response["otp"] = strip_tags(form_error("otp"));
        }
        echo json_encode($response);
    }
    public function changeStaffPassword(){
        $this->form_validation->set_rules("password", "password", "required|trim|max_length[8]");
        $this->form_validation->set_rules("confirm_password", "Conform password", "required|trim|matches[password]");
        if($this->form_validation->run()){
            $password = $this->input->post("password");
            $id = $this->session->userdata("id");
            $data = [
                "password"=> md5($password)
            ];
            if($this->work->update_data("staff", $data, ['id'=>$id])){
                $response["status"] = 1;
                $this->session->unset_userdata("otp");
                $this->session->unset_userdata("id");
                $this->session->set_flashdata("success", "<div class='alert alert-success'>Password Successfully updated! Login Again.</div>");
                $response["html"] = "<a href='".base_url("staffAuth")."' class='btn btn-info'> Login Now </a>";
            }else{
                $response["status"] = 0;
                $response["message"] = "Oops error occured! try after some time";
            }
        }else{
            $response["status"] = 0;
            $response["password"] = strip_tags(form_error("password"));
            $response["confirm_password"] = strip_tags(form_error("confirm_password"));
        }
        echo json_encode($response);
    }
    
    
    //================Student Forget Password================//
    public function student($action=null){
        $this->load->view("header/header.php");
        $this->load->view("forget-password/student/fp.php");
        $this->load->view("footer/footer.php");
    }
    
    public function studentOTP(){
        $this->form_validation->set_rules("student_mobile", "Student Mobile", "required|trim|numeric|exact_length[10]");
        if($this->form_validation->run()){
            $student_mobile = $this->input->post("student_mobile");
            $data = $this->work->select_data("registration", ["reg_status"=>1, "student_mobile"=>$student_mobile]);
            
            if(!empty($data[0])){
                $otp = rand(1111,9999);
                $this->session->set_userdata("otp", $otp);
                $this->session->set_userdata("id", $data[0]->id);
                $msg = "Your OTP is : ".$otp." Please dont share with anyone";
                if($this->work->send_sms($student_mobile, $msg, "VJTEXT")){
                    $response["status"] = 1;
                    $response["otpStatus"] = "<span class='text-success'>Otp send Successfully</span>";
                    $response["html"] = $this->load->view("forget-password/student/print-row.php", ["action"=>"otpForm"], true);
                }else{
                    $response["status"] = 0;
                    $response["otpStatus"] = "Otp not send";
                }
            }else{
                $response["status"] = 0;
                $response["student_mobile"] = "Mobile is not registered!!";
            }
        }else{
            $response["status"] = 0;
            $response["student_mobile"] = strip_tags(form_error("student_mobile"));
        }
        echo json_encode($response);
    }
    
    public function checkStudentOTP(){
        $this->form_validation->set_rules("otp", "OTP", "required|trim|max_length[4]");
        if($this->form_validation->run()){
            $otp = $this->input->post("otp");
            $session_otp = $this->session->userdata("otp");
            
            if($otp == $session_otp){
                    $response["status"] = 1;
                    $response["html"] = $this->load->view("forget-password/student/print-row.php", ["action"=>"passwordForm"], true);
            }else{
                $response["status"] = 0;
                $response["otp"] = "Please enter valid OTP !!";
            }
        }else{
            $response["status"] = 0;
            $response["otp"] = strip_tags(form_error("otp"));
        }
        echo json_encode($response);
    }
    
    public function changeStudentPassword(){
        $this->form_validation->set_rules("password", "password", "required|trim|max_length[8]");
        $this->form_validation->set_rules("confirm_password", "Conform password", "required|trim|matches[password]");
        if($this->form_validation->run()){
            $password = $this->input->post("password");
            $id = $this->session->userdata("id");
            $data = [
                "password"=> md5($password)
            ];
            if($this->work->update_data("registration", $data, ['id'=>$id])){
                $response["status"] = 1;
                $this->session->unset_userdata("otp");
                $this->session->unset_userdata("id");
                $this->session->set_flashdata("success", "<div class='alert alert-success'>Password Successfully updated! Login Now.</div>");
                $response["html"] = "<a href='".base_url("studentAuth")."' class='btn btn-info'> Login Now </a>";
            }else{
                $response["status"] = 0;
                $response["message"] = "Oops error occured! try after some time";
            }
        }else{
            $response["status"] = 0;
            $response["password"] = strip_tags(form_error("password"));
            $response["confirm_password"] = strip_tags(form_error("confirm_password"));
        }
        echo json_encode($response);
    }
}

?>