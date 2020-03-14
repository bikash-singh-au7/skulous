<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class StaffAuth extends CI_Controller{
    public function __construct(){
        parent::__construct();
        //check session is set or not
        if($this->session->userdata("id") && $this->session->userdata("display_name") && $this->session->userdata("type")) {
            redirect(base_url("welcome"));
        }
    }
    public function index(){
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('user_name', 'Username', 'required|min_length[5]|max_length[12]|alpha_numeric|trim');
        $this->form_validation->set_rules('user_password', 'Password', 'required|min_length[5]|max_length[12]|alpha_numeric|trim');
        if($this->form_validation->run()){
            $data = [
                "mobile_number" => $_POST["user_name"],
                "password" => md5($_POST["user_password"]),
                "staff_status" => 1
            ];
            
            
            
            
            $this->load->model("work");            
            $val = $this->work->login("staff", $data);
            if($val->num_rows() > 0){
                $info = $val->result();
                foreach($info as $value){
                    $this->session->set_userdata("id", $value->id);
                    $this->session->set_userdata("display_name", $value->staff_name);
                    $this->session->set_userdata("type", "staff");
                    redirect(base_url("welcome"));
                }
                
            }else{  
                $this->session->set_flashdata("success", "<div class='alert alert-danger rounded-0 border'> <strong>Opps</strong> User Name and Password is wrong</div>");
                redirect(base_url('staffauth/'));
            }
        }else{
            $this->load->view("header/header.php");
            $this->load->view("login/staff/staff-login");
        }
        
    }
}
?>