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
			$this->form_validation->set_rules("subject_name","Subject Name", "trim|required|callback_is_subname_unique");
			$this->form_validation->set_rules("subject_code","Subject Code", "trim|required|callback_is_subcode_unique");
            $this->form_validation->set_rules("comment","Comment", "trim");
            
			if($this->form_validation->run()){
				$data = [
					"session_id" => $this->session->userdata("session_id"),	
					"subject_name" => strtoupper($this->input->post("subject_name")),	
					"subject_code" => strtoupper($this->input->post("subject_code")),	
					"comment" => strtoupper($this->input->post("comment"))
				];
				if($this->work->insert_data("subject", $data)){
					$response["alert"] = "Added !!";
                    $response["message"] = "Subject successfully added.";
                    $response["modal"] = "success";
					$response["status"] = 1;
				}else{
					$response["alert"] = "Oops error !!";
                    $response["message"] = "Subject does't added.";
                    $response["modal"] = "error";
                    $response["status"] = 2;
				}
			}else{
				$response["subject_name"] = strip_tags(form_error('subject_name'));
				$response["subject_code"] = strip_tags(form_error('subject_code'));
				$response["comment"] = strip_tags(form_error('comment'));
				$response['status'] = 0;
			}
			echo json_encode($response);
		}elseif($action == "manage-add"){
			$this->form_validation->set_rules("subject_name","Subject Name", "trim|required|callback_is_subname_unique");
			$this->form_validation->set_rules("subject_code","Subject Code", "trim|required|callback_is_subcode_unique");
            $this->form_validation->set_rules("comment","Comment", "trim");
            
			if($this->form_validation->run()){
				$data = [
					"session_id" => $this->session->userdata("session_id"),	
					"subject_name" => strtoupper($this->input->post("subject_name")),	
					"subject_code" => strtoupper($this->input->post("subject_code")),	
					"comment" => strtoupper($this->input->post("comment"))
				];
				if($this->work->insert_data("subject", $data)){
					$response["alert"] = "Added !!";
                    $response["message"] = "Subject successfully added.";
                    $response["modal"] = "success";
					$response["status"] = 1;

					$data["action"] = "manage-add";
					$data["result"] = $this->work->select_data("subject", ["id"=>$this->work->get_last_id()]);
					$html = $this->load->view("subject/print-row", $data, true);
					
					$response["lastRow"] = $html;
					//
				}else{
					$response["alert"] = "Oops error !!";
                    $response["message"] = "Subject does't added.";
                    $response["modal"] = "error";
                    $response["status"] = 2;
				}
			}else{
				$response["subject_name"] = strip_tags(form_error('subject_name'));
				$response["subject_code"] = strip_tags(form_error('subject_code'));
				$response["comment"] = strip_tags(form_error('comment'));
				$response['status'] = 0;
			}
			echo json_encode($response);
		}
    }
    
    //Update Subject
	public function updateSubject($row_id=null){
        $this->form_validation->set_rules("subject_name","Subject Name", "trim|required|callback_is_unique_subname_update");
        $this->form_validation->set_rules("subject_code","Subject Code", "trim|required|callback_is_unique_subcode_update");
        $this->form_validation->set_rules("subject_status","Status", "required");
        $this->form_validation->set_rules("subject_id","Subject Id", "required");
        $this->form_validation->set_rules("comment","Comment", "trim");

        if($this->form_validation->run()){
            $data = [
                "subject_name" => strtoupper($this->input->post("subject_name")),	
                "subject_code" => strtoupper($this->input->post("subject_code")),	
                "subject_status" => $this->input->post("subject_status"),	
                "comment" => strtoupper($this->input->post("comment"))
            ];
        if($this->work->update_data("subject", $data, ["id"=>$this->input->post("subject_id")])){
            $response["alert"] = "Updated !!";
            $response["message"] = "Subject successfully updated.";
            $response["modal"] = "success";
            $response["status"] = 1;

            $data["action"] = "update";
            $data["result"] = $this->work->select_data("subject", ["id"=>$this->input->post("subject_id")]);
            $html = $this->load->view("subject/print-row", $data, true);

            $response["rowId"] = "row-".$this->input->post("subject_id");
            $response["updatedRow"] = $html;

        }else{
            $response["alert"] = "Oops error !!";
            $response["message"] = "Subject does't updated.";
            $response["modal"] = "error";
            $response["status"] = 2;
        }
    }else{
        $response["subject_name"] = strip_tags(form_error('subject_name'));
        $response["subject_code"] = strip_tags(form_error('subject_code'));
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
		$response["subject_code"] = $data["value"][0]->subject_code;
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
    
    // ============================
    //Cutom Validation
    //For adding the data
    public function is_subname_unique($str){
        if($str != ""){
            $query = $this->work->select_data("subject", ["session_id"=>$this->session->userdata("session_id"), "subject_name"=>$str]);
            if(!empty($query[0])){
                $this->form_validation->set_message('is_subname_unique', 'This {field} is already exists');
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }
    public function is_subcode_unique($str){
        if($str != ""){
            $query = $this->work->select_data("subject", ["session_id"=>$this->session->userdata("session_id"), "subject_code"=>$str]);
            if(!empty($query[0])){
                $this->form_validation->set_message('is_subcode_unique', 'This {field} is already exists');
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }
    
 
    //For update data
    public function is_unique_subname_update($str){
        if($str != ""){
            $query = $this->work->select_data("subject", ["session_id"=>$this->session->userdata("session_id"), "subject_name"=>$str, "id !="=> $this->input->post("subject_id")]);
            if(!empty($query[0])){
                $this->form_validation->set_message('is_unique_subname_update', 'This {field} is already exists');
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }
    public function is_unique_subcode_update($str){
        if($str != ""){
            $query = $this->work->select_data("subject", ["session_id"=>$this->session->userdata("session_id"), "subject_code"=>$str, "id !="=> $this->input->post("subject_id")]);
            if(!empty($query[0])){
                $this->form_validation->set_message('is_unique_subcode_update', 'This {field} is already exists');
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }

}




?>