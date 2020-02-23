<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SessionSetup extends CI_Controller {
    public function __construct() {
		parent::__construct();
		//check login session is set or not
		if(!$this->session->userdata("id") && !$this->session->userdata("display_name")){
            redirect(base_url("auth"));
		}
		/*
        $this->load->view("header/header.php");
        $this->load->view("sidebar/sidebar.php");
		$this->load->view("header/topmenu.php");
		*/
    }
    public function index(){
		redirect(base_url("sessionsetup/session/add"));
	}
	
	
	//Navigate Session
    public function session($action = null, $subaction=null){
		if($action == "select"){
			$this->form_validation->set_error_delimiters("<span class='text-danger text-small'>", "</span>");
			$this->form_validation->set_rules("session","Select Session", "required");
			if($this->form_validation->run()){
				$this->session->set_userdata("session_id", $_POST["session"]);
				redirect(base_url("welcome/"));
			}else{
				$data["session"] = $this->work->select_data("session", ["session_status"=>1]);
				$this->load->view("header/header.php");
				$this->load->view("sidebar/sidebar.php");
				$this->load->view("header/topmenu.php");
				$this->load->view("session/select-session.php", $data);
				$this->load->view("footer/footer.php");
			}	
		}elseif($action == "add"){
			$this->load->view("header/header.php");
        	$this->load->view("sidebar/sidebar.php");
        	$this->load->view("header/topmenu.php");
			$this->load->view("session/add-session.php");
			$this->load->view("footer/footer.php");

		}elseif($action == "manage"){
			$data["session"] = $this->work->select_data("session");	
			$this->load->view("header/header.php");
			$this->load->view("sidebar/sidebar.php");
			$this->load->view("header/topmenu.php");
			$this->load->view("session/manage-session.php", $data);
			$this->load->view("footer/footer.php");
		}else{
			redirect(base_url("sessionsetup/session/add"));
		}
	}


	//Add Session
	public function addSession($action = null){

		if($action == "add"){
			$this->form_validation->set_error_delimiters("<span class='text-danger text-small'>", "</span>");
			$this->form_validation->set_rules("session_name", "Session Name",  "required");
			$this->form_validation->set_rules("start_session", "Session Start Date",  "required|is_unique[session.start_session]");
			$this->form_validation->set_rules("end_session", "Session End Date",  "required|callback_is_same|is_unique[session.end_session]");

			if($this->form_validation->run()){
				$data = [
					"session_name" => $this->input->post("session_name"),
					"start_session" => $this->input->post("start_session"),
					"end_session" => $this->input->post("end_session")
				];
				if($this->work->insert_data("session", $data)){
					$response["alert"] = "<div class='alert alert-success rounded-0 border'>Session successfully created !!</div>";
					$response["status"] = 1;

					$data["action"] = "add";
					$data["result"] = $this->work->select_data("session", ["id"=>$this->work->get_last_id()]);
					$html = $this->load->view("session/print-row", $data, true);
					
					$response["lastRow"] = $html;
					//
				}else{
					$response["alert"] = "<div class='alert alert-danger rounded-0 border'>Session does't created !!</div>";
					$response["status"] = 2;
				}
			}else{
				$response["session_name"] = strip_tags(form_error('session_name'));
				$response["start_session"] = strip_tags(form_error('start_session'));
				$response["end_session"] = strip_tags(form_error('end_session'));
				$response['status'] = 0;
			}
			echo json_encode($response);
		}if($action == "manage-add"){
			$this->form_validation->set_error_delimiters("<span class='text-danger text-small'>", "</span>");
			$this->form_validation->set_rules("session_name", "Session Name",  "required");
			$this->form_validation->set_rules("start_session", "Session Start Date",  "required|is_unique[session.start_session]");
			$this->form_validation->set_rules("end_session", "Session End Date",  "required|callback_is_same|is_unique[session.end_session]");

			if($this->form_validation->run()){
				$data = [
					"session_name" => $this->input->post("session_name"),
					"start_session" => $this->input->post("start_session"),
					"end_session" => $this->input->post("end_session")
				];
				if($this->work->insert_data("session", $data)){
					$response["alert"] = "<div class='alert alert-success rounded-0 border'>Session successfully created !!</div>";
					$response["status"] = 1;

					$data["action"] = "manage-add";
					$data["result"] = $this->work->select_data("session", ["id"=>$this->work->get_last_id()]);
					$html = $this->load->view("session/print-row", $data, true);
					
					$response["lastRow"] = $html;
					//
				}else{
					$response["alert"] = "<div class='alert alert-danger rounded-0 border'>Session does't created !!</div>";
					$response["status"] = 2;
				}
			}else{
				$response["session_name"] = strip_tags(form_error('session_name'));
				$response["start_session"] = strip_tags(form_error('start_session'));
				$response["end_session"] = strip_tags(form_error('end_session'));
				$response['status'] = 0;
			}
			echo json_encode($response);
		}
	}

	//Update Session
	public function updateSession($row_id=null){
		$this->form_validation->set_error_delimiters("<span class='text-danger text-small'>", "</span>");
		$this->form_validation->set_rules("session_id","", "required");
		$this->form_validation->set_rules("session_name","Session Name", "required|trim");
		$this->form_validation->set_rules("start_session","Session Start date", "required");
		$this->form_validation->set_rules("end_session","Session End date", "required");
		$this->form_validation->set_rules("session_status","Session Status", "required");

		if($this->form_validation->run()){
			$data = [
				"session_name" => $this->input->post("session_name"),
				"start_session" => $this->input->post("start_session"),
				"end_session" => $this->input->post("end_session"),
				"session_status" => $this->input->post("session_status")
			];
			if($this->work->update_data("session", $data, ["id"=>$this->input->post("session_id")])){
				$response["alert"] = "<div class='alert alert-success rounded-0 border'>Session successfully updated !!</div>";
				$response["status"] = 1;
				
				$data["action"] = "update";
				$data["result"] = $this->work->select_data("session", ["id"=>$this->input->post("session_id")]);
				$html = $this->load->view("session/print-row", $data, true);
				
				$response["rowId"] = "row-".$this->input->post("session_id");
				$response["updatedRow"] = $html;
				
			}else{
				$response["alert"] = "<div class='alert alert-danger rounded-0 border'>Session does't updated !!</div>";
				$response["status"] = 2;
			}
		}else{
			$response["session_name"] = strip_tags(form_error('session_name'));
			$response["start_session"] = strip_tags(form_error('start_session'));
			$response["end_session"] = strip_tags(form_error('end_session'));
			$response['status'] = 0;
		}
			
		echo json_encode($response);
	}

	//this function helps to fill the data in update modal
	public function getData(){
		date_default_timezone_set("Asia/Kolkata");
		$id = $this->input->post("session_id");
		$data["value"] = $this->work->select_data("session", ["id"=>$id]);
		$response["session_id"] = $data["value"][0]->id;
		$response["session_name"] = $data["value"][0]->session_name;
		$response["start_session"] = date("Y-m-d", strtotime($data["value"][0]->start_session));
		$response["session_status"] = $data["value"][0]->session_status;
		$response["end_session"] = date("Y-m-d", strtotime($data["value"][0]->end_session));
		echo json_encode($response);
	}

	//Delete session data
	public function deleteData(){
		$id = $this->input->post("session_id");
		if($this->work->delete_data("session", ["id"=>$id])){
			$response["rowId"] = "row-".$id;
			$response["alert"] = "<div class='alert alert-success rounded-0 border'>Session deleted successfully !!</div>";
		}else{
			$response["alert"] = "<div class='alert alert-success rounded-0 border'>Session does't deleted !!</div>";
		}
		echo json_encode($response);
	}

	//Custom Validation
	public function is_same($str){
		if($str == $this->input->post('start_session')){
			$this->form_validation->set_message('is_same', "The %s and Session start date not be same!!");
			return false;
		}else{
			return true;
		}
	}
}
?>