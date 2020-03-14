<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class StudentAuth extends CI_Controller{
    public function __construct(){
        parent::__construct();
        //check session is set or not
        if($this->session->userdata("id") && $this->session->userdata("student_name")){
            redirect(base_url("student"));
        }
    }
    public function index(){
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('user_name', 'Username', 'required|min_length[5]|max_length[12]|alpha_numeric');
        $this->form_validation->set_rules('user_password', 'Password', 'required|min_length[5]|max_length[12]|alpha_numeric');
        if($this->form_validation->run()){
            $data = [
                "student_mobile" => $_POST["user_name"],
                "password" => md5($_POST["user_password"]),
                "reg_status" => 1
            ];
            $this->load->model("work");            
            $val = $this->work->login("registration", $data);
            if($val->num_rows() > 0){
                $info = $val->result();
                foreach($info as $value){
                    $this->session->set_userdata("id", $value->id);
                    $this->session->set_userdata("student_name", $value->student_name);
                    redirect(base_url("student/index"));
                }
                
            }else{
                $this->session->set_flashdata("success", "<div class='alert alert-danger rounded-0 border'> <strong>Opps</strong> User Name and Password is wrong</div>");
                redirect(base_url('studentauth/'));
            }
        }else{
            $this->load->view("header/header.php");
            $this->load->view("login/student/student-login");
        }
        
    }
}
?>