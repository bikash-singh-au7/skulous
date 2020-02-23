<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SubjectSetup extends CI_Controller {
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

    //Subject Navigation
	public function subject($action=null, $subaction=null){
		if($action == "add"){
            $this->load->view("header/header.php");
            $this->load->view("sidebar/sidebar.php");
            $this->load->view("header/topmenu.php");
			$this->load->view("subject/add-subject.php");
			$this->load->view("footer/footer.php");
		}elseif($action == "manage"){
            $data["data"] = $this->work->select_data("subject",["session_id" => $this->session->userdata('session_id')]);
            $this->load->view("header/header.php");
            $this->load->view("sidebar/sidebar.php");
            $this->load->view("header/topmenu.php");
			$this->load->view("subject/manage-subject.php", $data);
			$this->load->view("footer/footer.php");
		}
    }
    
    //Add Subject
    public function addSubject($action = null){
		if($action == "add"){
			$this->form_validation->set_error_delimiters("<span class='text-danger'>","</span>");
			$this->form_validation->set_rules("subject_name","Subject Name", "trim|required|is_unique[subject.subject_name]");
            $this->form_validation->set_rules("comment","Comment", "trim");
            
			if($this->form_validation->run()){
				$data = [
					"session_id" => $this->session->userdata("session_id"),	
					"subject_name" => $this->input->post("subject_name"),	
					"comment" => $this->input->post("comment")
				];
				if($this->work->insert_data("subject", $data)){
					$response["alert"] = "<div class='alert alert-success rounded-0 border'>Subject successfully added !!</div>";
					$response["status"] = 1;
				}else{
					$response["alert"] = "<div class='alert alert-danger rounded-0 border'>Subject does't added !!</div>";
					$response["status"] = 2;
				}
			}else{
				$response["subject_name"] = strip_tags(form_error('subject_name'));
				$response["comment"] = strip_tags(form_error('comment'));
				$response['status'] = 0;
			}
			echo json_encode($response);
		}elseif($action == "manage-add"){
			$this->form_validation->set_error_delimiters("<span class='text-danger'>","</span>");
			$this->form_validation->set_rules("subject_name","Subject Name", "trim|required|is_unique[subject.subject_name]");
            $this->form_validation->set_rules("comment","Comment", "trim");
            
			if($this->form_validation->run()){
				$data = [
					"session_id" => $this->session->userdata("session_id"),	
					"subject_name" => $this->input->post("subject_name"),	
					"comment" => $this->input->post("comment")
				];
				if($this->work->insert_data("subject", $data)){
					$response["alert"] = "<div class='alert alert-success rounded-0 border'>Subject successfully Added !!</div>";
					$response["status"] = 1;

					$data["action"] = "manage-add";
					$data["result"] = $this->work->select_data("subject", ["id"=>$this->work->get_last_id()]);
					$html = $this->load->view("subject/print-row", $data, true);
					
					$response["lastRow"] = $html;
					//
				}else{
					$response["alert"] = "<div class='alert alert-danger rounded-0 border'>Subject does't added !!</div>";
					$response["status"] = 2;
				}
			}else{
				$response["subject_name"] = strip_tags(form_error('subject_name'));
				$response["comment"] = strip_tags(form_error('comment'));
				$response['status'] = 0;
			}
			echo json_encode($response);
		}
    }
    
    //Update Subject
	public function updateClass($row_id=null){
		$this->form_validation->set_error_delimiters("<span class='text-danger'>","</span>");
			$this->form_validation->set_rules("subject_name","Subject Name", "trim|required");
			$this->form_validation->set_rules("subject_status","Status", "required");
			$this->form_validation->set_rules("subject_id","Subject Id", "required");
            $this->form_validation->set_rules("comment","Comment", "trim");
            
			if($this->form_validation->run()){
				$data = [
					"subject_name" => $this->input->post("subject_name"),	
					"subject_status" => $this->input->post("subject_status"),	
					"comment" => $this->input->post("comment")
				];
			if($this->work->update_data("subject", $data, ["id"=>$this->input->post("subject_id")])){
				$response["alert"] = "<div class='alert alert-success rounded-0 border'>Subject successfully updated !!</div>";
				$response["status"] = 1;
				
				$data["action"] = "update";
				$data["result"] = $this->work->select_data("subject", ["id"=>$this->input->post("subject_id")]);
				$html = $this->load->view("subject/print-row", $data, true);
				
				$response["rowId"] = "row-".$this->input->post("subject_id");
				$response["updatedRow"] = $html;
				
			}else{
				$response["alert"] = "<div class='alert alert-danger rounded-0 border'>Subject does't updated !!</div>";
				$response["status"] = 2;
			}
		}else{
			$response["subject_name"] = strip_tags(form_error('subject_name'));
			$response["comment"] = strip_tags(form_error('comment'));
			$response["subject_status"] = strip_tags(form_error('subject_status'));
			$response['status'] = 0;
		}
			
		echo json_encode($response);
	}

    //this function helps to fill the data in update modal
	public function getData(){
		date_default_timezone_set("Asia/Kolkata");
		$id = $this->input->post("subject_id");
		$data["value"] = $this->work->select_data("subject", ["id"=>$id]);
		$response["subject_id"] = $data["value"][0]->id;
		$response["subject_name"] = $data["value"][0]->subject_name;
		$response["comment"] = $data["value"][0]->comment;
		$response["subject_status"] = $data["value"][0]->subject_status;
		echo json_encode($response);
    }
    
    //Delete data
	public function deleteData(){
		$id = $this->input->post("subject_id");
		if($this->work->delete_data("subject", ["id"=>$id])){
			$response["rowId"] = "row-".$id;
			$response["alert"] = "<div class='alert alert-success rounded-0 border'>Subject deleted successfully !!</div>";
		}else{
			$response["alert"] = "<div class='alert alert-success rounded-0 border'>Subject does't deleted !!</div>";
		}
		echo json_encode($response);
	}


}




?>