<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ClassSetup extends CI_Controller {
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
        /*
        $this->load->view("header/header.php");
        $this->load->view("sidebar/sidebar.php");
        $this->load->view("header/topmenu.php");
        */
    }

    //Class Navigation
	public function classes($action=null, $subaction=null){
		if($action == "add"){
            $this->load->view("header/header.php");
            $this->load->view("sidebar/sidebar.php");
            $this->load->view("header/topmenu.php");
			$this->load->view("classes/add-class.php");
			$this->load->view("footer/footer.php");
		}elseif($action == "manage"){
            $data["data"] = $this->work->select_data("classes",["session_id" => $this->session->userdata('session_id')]);
            $this->load->view("header/header.php");
            $this->load->view("sidebar/sidebar.php");
            $this->load->view("header/topmenu.php");
			$this->load->view("classes/manage-class.php", $data);
			$this->load->view("footer/footer.php");
		}
    }
    
    //Add Class
    public function addClass($action = null){
		if($action == "add"){
			$this->form_validation->set_error_delimiters("<span class='text-danger'>","</span>");
			$this->form_validation->set_rules("class_name","Class Name", "trim|required|callback_is_unique");
            $this->form_validation->set_rules("comment","Comment", "trim");
            
			if($this->form_validation->run()){
				$data = [
					"session_id" => $this->session->userdata("session_id"),	
					"class_name" => $this->input->post("class_name"),	
					"comment" => strtoupper($this->input->post("comment"))
				];
				if($this->work->insert_data("classes", $data)){
					$response["alert"] = "Added !!";
					$response["message"] = "Class successfully created.";
					$response["modal"] = "success";
					$response["status"] = 1;
				}else{
                    $response["alert"] = "Oops error !!";
					$response["message"] = "Class does't created.";
					$response["modal"] = "error";
					$response["status"] = 2;
				}
			}else{
				$response["class_name"] = strip_tags(form_error('class_name'));
				$response["comment"] = strip_tags(form_error('comment'));
				$response['status'] = 0;
			}
			echo json_encode($response);
		}elseif($action == "manage-add"){
			$this->form_validation->set_error_delimiters("<span class='text-danger'>","</span>");
			$this->form_validation->set_rules("class_name","Class Name", "trim|required|callback_is_unique");
            $this->form_validation->set_rules("comment","Comment", "trim");
            
			if($this->form_validation->run()){
				$data = [
					"session_id" => $this->session->userdata("session_id"),	
					"class_name" => $this->input->post("class_name"),	
					"comment" => strtoupper($this->input->post("comment"))
				];
				if($this->work->insert_data("classes", $data)){
					$response["alert"] = "Added !!";
					$response["message"] = "Class successfully created.";
					$response["modal"] = "success";
					$response["status"] = 1;

					$data["action"] = "manage-add";
					$data["result"] = $this->work->select_data("classes", ["id"=>$this->work->get_last_id()]);
					$html = $this->load->view("classes/print-row", $data, true);
					
					$response["lastRow"] = $html;
					//
				}else{
					$response["alert"] = "Oops error !!";
					$response["message"] = "Class does't created.";
					$response["modal"] = "error";
					$response["status"] = 2;
				}
			}else{
				$response["class_name"] = strip_tags(form_error('class_name'));
				$response["comment"] = strip_tags(form_error('comment'));
				$response['status'] = 0;
			}
			echo json_encode($response);
		}
    }
    
    //Update Session
	public function updateClass($row_id=null){
		$this->form_validation->set_error_delimiters("<span class='text-danger'>","</span>");
			$this->form_validation->set_rules("class_name","Class Name", "trim|required|callback_is_unique_update");
			$this->form_validation->set_rules("class_status","Status", "required");
			$this->form_validation->set_rules("class_id","Class Id", "required");
            $this->form_validation->set_rules("comment","Comment", "trim");
            
			if($this->form_validation->run()){
				$data = [
					"class_name" => $this->input->post("class_name"),	
					"class_status" => $this->input->post("class_status"),	
					"comment" => strtoupper($this->input->post("comment"))
				];
			if($this->work->update_data("classes", $data, ["id"=>$this->input->post("class_id")])){
                $response["alert"] = "Updated !!";
                $response["message"] = "Class successfully updated.";
                $response["modal"] = "success";
				$response["status"] = 1;
				
				$data["action"] = "update";
				$data["result"] = $this->work->select_data("classes", ["id"=>$this->input->post("class_id")]);
				$html = $this->load->view("classes/print-row", $data, true);
				
				$response["rowId"] = "row-".$this->input->post("class_id");
				$response["updatedRow"] = $html;
				
			}else{
				$response["alert"] = "Oops error !!";
                $response["message"] = "Class does't updated.";
                $response["modal"] = "error";
				$response["status"] = 2;
			}
		}else{
			$response["class_name"] = strip_tags(form_error('class_name'));
			$response["comment"] = strip_tags(form_error('comment'));
			$response["class_status"] = strip_tags(form_error('class_status'));
			$response['status'] = 0;
		}
			
		echo json_encode($response);
	}

    //this function helps to fill the data in update modal
	public function getData(){
		date_default_timezone_set("Asia/Kolkata");
		$id = $this->input->post("class_id");
		$data["value"] = $this->work->select_data("classes", ["id"=>$id]);
		$response["class_id"] = $data["value"][0]->id;
		$response["class_name"] = $data["value"][0]->class_name;
		$response["comment"] = $data["value"][0]->comment;
		$response["class_status"] = $data["value"][0]->class_status;
		echo json_encode($response);
    }
    
    //Delete data
	public function deleteData(){
		$id = $this->input->post("class_id");
		if($this->work->delete_data("classes", ["id"=>$id])){
			$response["rowId"] = "row-".$id;
			$response["alert"] = "Deleted !!";
            $response["message"] = "Class successfully deleted.";
            $response["modal"] = "success";
		}else{
			$response["alert"] = "Oops error !!";
            $response["message"] = "Class does't deleted.";
            $response["modal"] = "error";
		}
		echo json_encode($response);
	}
    
    // ============================
    //Cutom Validation
    public function is_unique($str){
        if($str != ""){
            $query = $this->work->select_data("classes", ["session_id"=>$this->session->userdata("session_id"), "class_name"=>$str]);
            if(!empty($query[0])){
                $this->form_validation->set_message('is_unique', 'This class name is already exists');
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }
    
    
    //For update data
    public function is_unique_update($str){
        if($str != ""){
            $query = $this->work->select_data("classes", ["session_id"=>$this->session->userdata("session_id"), "class_name"=>$str, "id !="=> $this->input->post("class_id")]);
            if(!empty($query[0])){
                $this->form_validation->set_message('is_unique_update', 'This class name is already exists');
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }

}




?>