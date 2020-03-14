<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");

class Student extends CI_Controller {
    public function __construct() {
		parent::__construct();
		//check login session is set or not
		if(!$this->session->userdata("id") && !$this->session->userdata("student_name")){
            redirect(base_url("studentauth"));
		}
        
    }
    //Subject Navigation
	public function index($action=null, $subaction=null){
        $this->load->view("student/header/header.php");
        $this->load->view("student/sidebar/sidebar.php");
        $this->load->view("student/header/topmenu.php");
        $this->load->view("student/home/home.php");
        $this->load->view("student/footer/footer.php");
    }
    
    //Subject Navigation
	public function profile($action=null, $subaction=null){
        $this->load->view("student/header/header.php");
        $this->load->view("student/sidebar/sidebar.php");
        $this->load->view("student/header/topmenu.php");
        $this->load->view("student/profile/profile.php");
        $this->load->view("student/footer/footer.php");
    }
    
     //Subject Navigation
	public function payment($action=null, $subaction=null){
        $this->load->view("student/header/header.php");
        $this->load->view("student/sidebar/sidebar.php");
        $this->load->view("student/header/topmenu.php");
        $this->load->view("student/payment/payment.php");
        $this->load->view("student/footer/footer.php");
    }
    
    //Subject Navigation
	public function setting($action=null){
        if($action == "update"){
            $this->form_validation->set_rules("old_password", "Old Password", "required|trim|callback_old_is_match");
            $this->form_validation->set_rules("new_password", "New Password", "required|trim");
            $this->form_validation->set_rules("confirm_password", "Confirm Password", "required|trim|matches[new_password]");

            if($this->form_validation->run()){
                $reg_id = $this->session->userdata("id");
                if($this->work->update_data("registration", ['password'=>md5($this->input->post("confirm_password"))], ["id"=>$reg_id])){
                    $response['alert'] = "Updated!!";
                    $response['message'] = "Password Updated successfully!!";
                    $response['modal'] = "success";
                }else{
                    $response['alert'] = "Oops error!!";
                    $response['message'] = "Password does't updated!!";
                    $response['modal'] = "error";
                }
            }else{
                $response['status'] = 0;
                $response["old_password"] = strip_tags(form_error("old_password"));
                $response["new_password"] = strip_tags(form_error("new_password"));
                $response["confirm_password"] = strip_tags(form_error("confirm_password"));
            }
            echo json_encode($response);
        }else{
            $this->load->view("student/header/header.php");
            $this->load->view("student/sidebar/sidebar.php");
            $this->load->view("student/header/topmenu.php");
            $this->load->view("student/setting/change-password.php");
            $this->load->view("student/footer/footer.php");
        }
    }
    
    //Subject Navigation
	public function logout(){
        $this->session->unset_userdata("id");
        $this->session->unset_userdata("student_name");
        redirect(base_url("studentauth"));
    }

    //Old password is matched or not
	public function old_is_match($pwd){
        $data = $this->work->select_data("registration", ["id"=>$this->session->userdata("id")]);
        $old_password = $data[0]->password;
        if($pwd == ""){
            return true;
        }else{
            if(md5($pwd) === $old_password){
                return TRUE;
            }else{
                $this->form_validation->set_message('old_is_match', 'Old Password is not matched');
                return FALSE;
            }
        }
    }
    
    
    
}




?>