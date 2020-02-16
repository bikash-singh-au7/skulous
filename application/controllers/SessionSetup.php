<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SessionSetup extends CI_Controller {
    public function __construct() {
		parent::__construct();
		//check login session is set or not
		if(!$this->session->userdata("id") && !$this->session->userdata("display_name")){
            redirect(base_url("auth"));
		}
        $this->load->view("header/header.php");
        $this->load->view("sidebar/sidebar.php");
        $this->load->view("header/topmenu.php");
    }
    public function index(){

    }
    public function session($action = null, $subaction=null){
		if($action == "select"){
			
			$this->form_validation->set_error_delimiters("<span class='text-danger text-small'>", "</span>");
			$this->form_validation->set_rules("session","Select Session", "required");
			if($this->form_validation->run()){
				$this->session->set_userdata("session_id", $_POST["session"]);
				redirect(base_url("welcome/"));
			}else{
				$data["session"] = $this->work->select_data("session", ["session_status"=>1]);
				$this->load->view("session/select-session.php", $data);
				$this->load->view("footer/footer.php");
			}	
		}elseif($action == "add"){
			$this->form_validation->set_error_delimiters("<span class='text-danger text-small'>", "</span>");
			$this->form_validation->set_rules("session_name", "Session Name",  "required");
			$this->form_validation->set_rules("start_session", "Session Start Date",  "required|is_unique[session.start_session]");
			$this->form_validation->set_rules("end_session", "Session End Date",  "required|is_unique[session.end_session]");

			if($this->form_validation->run()){
				if($this->input->post('start_session') == $this->input->post('end_session')){
					$this->session->set_flashdata("success", "<div class='alert alert-danger rounded-0 border'>Please Enter Valid Date</div>");
					redirect(base_url("sessionsetup/session/add"));	
				}else{
					$data = [
						"session_name" => $this->input->post("session_name"),
						"start_session" => $this->input->post("start_session"),
						"end_session" => $this->input->post("end_session")
					];
					if($this->work->insert_data("session", $data)){
						$this->session->set_flashdata("success", "<div class='alert alert-info rounded-0 border'>Session successfully created</div>");
						redirect(base_url("sessionsetup/session/select"));
					}else{
						$this->session->set_flashdata("success", "<div class='alert alert-danger rounded-0 border'><strong>Oops</strong> Session does not created</div>");
						redirect(base_url("sessionsetup/session/add"));
					}
				}
				
			}else{
				$this->load->view("session/add-session");
				$this->load->view("footer/footer");

				$response["session_name"] = strip_tags(form_error('session_name'));
				$response["start_session"] = strip_tags(form_error('start_session'));
				$response["end_session"] = strip_tags(form_error('end_session'));
				$response['status'] = 0;
				json_encode($response);
			}
		}elseif($action == "manage"){
			if($subaction == "delete"){
				if(isset($_POST["delSbmt"])){
					if($_POST["session_id"] != ""){
						if($this->work->delete_data("session", ["id"=>$_POST["session_id"]])){
							if($this->session->userdata("session_id") == $_POST["session_id"]){
								$this->session->unset_userdata("session_id");
								$this->session->set_flashdata("success", "<div class='alert alert-info rounded-0 border'><strong>Successfully</strong> Deleted!</div>");
								redirect(base_url("sessionsetup/session/select/"));
							}else{
								$this->session->set_flashdata("success", "<div class='alert alert-info rounded-0 border'><strong>Successfully</strong> Deleted!</div>");
								redirect(base_url("sessionsetup/session/manage/"));
							}
							
						}
					}
				}else{
					redirect(base_url("sessionsetup/session/manage/"));
				}
			}elseif($subaction == "update"){
				$this->form_validation->set_error_delimiters("<span class='text-danger text-small'>", "</span>");
				$this->form_validation->set_rules("session_id","", "required");
				$this->form_validation->set_rules("start_session","Session Start date", "required");
				$this->form_validation->set_rules("end_session","Session End date", "required");
				if($this->form_validation->run()){
					$data = [
						"session_name" => $this->input->post("session_name"),
						"start_session" => $this->input->post("start_session"),
						"end_session" => $this->input->post("end_session"),
						"session_status" => $this->input->post("session_status")
					];
					if($this->work->update_data("session", $data, ["id"=>$this->input->post("session_id")])){
						if($this->session->userdata("session_id") == $_POST["session_id"]){
							$this->session->unset_userdata("session_id");
							$this->session->set_flashdata("success", "<div class='alert alert-info rounded-0 border'><strong>Successfully</strong> Updated!</div>");
							redirect(base_url("sessionsetup/session/select/"));
						}else{
							$this->session->set_flashdata("success", "<div class='alert alert-info rounded-0 border'><strong>Successfully</strong> Updated!</div>");
							redirect(base_url("sessionsetup/session/manage/"));
						}
					}else{
						$this->session->set_flashdata("success", "<div class='alert alert-danger rounded-0 border'><strong>Oops</strong> Session does not updated!</div>");
					}
					redirect(base_url("sessionsetup/session/manage"));

				}else{
					redirect(base_url("sessionsetup/session/manage"));
				}
			}
			$data["session"] = $this->work->select_data("session");	
			$this->load->view("session/manage-session.php", $data);
			$this->load->view("footer/footer.php");
		}
    }
}
?>