<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AdminSetup extends CI_Controller{
    public function __construct() {
		parent::__construct();
		//check login session is set or not
		if(!$this->session->userdata("id") && !$this->session->userdata("display_name")){
            redirect(base_url("auth"));
		}
		//check session is set or not
		if(!$this->session->userdata("session_id")){
            redirect(base_url("sessionsetup/session/select"));
        }
        
    }
    
    //Inquiry Navigation
	public function profile($action=null){
        $data["data"] = $this->work->select_data("admin");
		$this->load->view("header/header.php");
        $this->load->view("sidebar/sidebar.php");
        $this->load->view("header/topmenu.php");
		$this->load->view("admin-profile/profile.php", $data);
		$this->load->view("footer/footer.php");
    } 
    
    //Inquiry Navigation
	public function setting($action=null){
        $data["data"] = $this->work->select_data("reg_format", ["session_id"=>$this->session->userdata("session_id")]);
		$this->load->view("header/header.php");
        $this->load->view("sidebar/sidebar.php");
        $this->load->view("header/topmenu.php");
		$this->load->view("admin-profile/setting.php", $data);
		$this->load->view("footer/footer.php");
    }
    public function addData($action=null){
        $this->form_validation->set_rules("format_string", "Format String", "trim|required");
        
        if($this->form_validation->run()){
            $data = [
                "session_id" => $this->session->userdata("session_id"),
                "format_string" => $this->input->post("format_string")
            ];

            if($this->work->insert_data("reg_format", $data)){
                $response["status"] = 1;
                $response["alert"] = "Format Added!";
                $response["message"] = "Format Successfully Done.";
                $response["modal"] = "success";
            }else{
                $response["status"] = 1;
                $response["alert"] = "Oops Error!";
                $response["message"] = "Format not added.";
                $response["modal"] = "error";
            }
            
        }else{
            $response["status"] = 0;
            $response["format_string"] = strip_tags(form_error("format_string"));
        }
        echo json_encode($response);
    }
    
}
?>