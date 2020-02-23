<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StaffSetup extends CI_Controller {
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
	public function staff($action=null){
        $data["staff"] = $this->work->select_data("staff");
		if($action == "add"){
            $this->load->view("header/header.php");
            $this->load->view("sidebar/sidebar.php");
            $this->load->view("header/topmenu.php");
			$this->load->view("staff/add-staff.php", $data);
			$this->load->view("footer/footer.php");
		}elseif($action == "manage"){
            $data["data"] = $this->work->select_data("batch",["session_id" => $this->session->userdata('session_id')]);
            $this->load->view("header/header.php");
            $this->load->view("sidebar/sidebar.php");
            $this->load->view("header/topmenu.php");
			$this->load->view("batch/manage-batch.php", $data);
			$this->load->view("footer/footer.php");
		}
    }
    
    //Add Subject
    public function addStaff($action = null){
		if($action == "add"){
			$this->form_validation->set_error_delimiters("<span class='text-danger'>","</span>");
			$this->form_validation->set_rules("first_name","First Name", "trim|required");
			$this->form_validation->set_rules("middle_name","Middle Name", "trim");
			$this->form_validation->set_rules("last_name","Middle Name", "trim|required");
			$this->form_validation->set_rules("gender","Gender", "required");
			$this->form_validation->set_rules("mobile_number","Mobile Number", "trim|required|exact_length[10]|numeric|is_unique[staff.mobile_number]");
			$this->form_validation->set_rules("email","Email", "trim|required|valid_email|is_unique[staff.email]");
			$this->form_validation->set_rules("address","Address", "trim|required");
			if($this->form_validation->run()){
				$data = [
					"first_name" => $this->input->post("first_name"),	
					"middle_name" => $this->input->post("middle_name"),	
					"last_name" => $this->input->post("last_name"),	
					"gender" => $this->input->post("gender"),	
					"mobile_number" => $this->input->post("mobile_number"),	
					"email" => $this->input->post("email"),	
					"password" => rand(11111,99999),	
					"profile_pic" => "",	
					"address" => $this->input->post("address")
				];
				if($this->work->insert_data("staff", $data)){
					$response["alert"] = "<div class='alert alert-success rounded-0 border'>Staff successfully added !!</div>";
					$response["status"] = 1;
				}else{
					$response["alert"] = "<div class='alert alert-danger rounded-0 border'>Staff does't added !!</div>";
					$response["status"] = 2;
				}
			}else{
				$response["first_name"] = strip_tags(form_error('first_name'));
				$response["middle_name"] = strip_tags(form_error('middle_name'));
				$response["last_name"] = strip_tags(form_error('last_name'));
				$response["gender"] = strip_tags(form_error('gender'));
				$response["mobile_number"] = strip_tags(form_error('mobile_number'));
				$response["email"] = strip_tags(form_error('email'));
				$response["address"] = strip_tags(form_error('address'));
				$response['status'] = 0;
			}
			echo json_encode($response);
		}elseif($action == "manage-add"){
			$this->form_validation->set_error_delimiters("<span class='text-danger'>","</span>");
			$this->form_validation->set_rules("batch_name","Batch Name", "trim|required|is_unique[batch.batch_name]");
			$this->form_validation->set_rules("batch_medium","Batch Medium", "trim|required");
			$this->form_validation->set_rules("batch_seat","Batch Seat", "trim|required");
			$this->form_validation->set_rules("batch_fee","Batch Fee", "trim|required");
			$this->form_validation->set_rules("batch_start_date","Batch Starting Date", "trim|required");
			$this->form_validation->set_rules("batch_start_time","Batch Starting Time", "trim|required");
			$this->form_validation->set_rules("batch_end_time","Batch End Time", "trim|required");
			$this->form_validation->set_rules("class_id","Class", "required");
			$this->form_validation->set_rules("subject_id","Subject", "required");
			$this->form_validation->set_rules("comment","Comment", "trim");
            
			if($this->form_validation->run()){
				$data = [
					"session_id" => $this->session->userdata("session_id"),	
					"batch_name" => $this->input->post("batch_name"),	
					"batch_medium" => $this->input->post("batch_medium"),	
					"batch_seat" => $this->input->post("batch_seat"),	
					"available_seat" => $this->input->post("batch_seat"),	
					"batch_fee" => $this->input->post("batch_fee"),	
					"batch_start_date" => $this->input->post("batch_start_date"),	
					"batch_start_time" => $this->input->post("batch_start_time"),	
					"batch_end_time" => $this->input->post("batch_end_time"),	
					"class_id" => $this->input->post("class_id"),	
					"subject_id" => $this->input->post("subject_id"),	
					"comment" => $this->input->post("comment")
				];
				if($this->work->insert_data("batch", $data)){
					$response["alert"] = "<div class='alert alert-success rounded-0 border'>Batch successfully Added !!</div>";
					$response["status"] = 1;

					$data["action"] = "manage-add";
					$data["result"] = $this->work->select_data("batch", ["id"=>$this->work->get_last_id()]);
					$html = $this->load->view("batch/print-row", $data, true);
					
					$response["lastRow"] = $html;
					//
				}else{
					$response["alert"] = "<div class='alert alert-danger rounded-0 border'>Batch does't added !!</div>";
					$response["status"] = 2;
				}
			}else{
				$response["batch_name"] = strip_tags(form_error('batch_name'));
				$response["batch_medium"] = strip_tags(form_error('batch_medium'));
				$response["batch_seat"] = strip_tags(form_error('batch_seat'));
				$response["batch_fee"] = strip_tags(form_error('batch_fee'));
				$response["batch_start_date"] = strip_tags(form_error('batch_start_date'));
				$response["batch_start_time"] = strip_tags(form_error('batch_start_time'));
				$response["batch_end_time"] = strip_tags(form_error('batch_end_time'));
				$response["class_id"] = strip_tags(form_error('class_id'));
				$response["subject_id"] = strip_tags(form_error('subject_id'));
				$response["comment"] = strip_tags(form_error('comment'));
				$response['status'] = 0;
			}
			echo json_encode($response);
		}
    }
    
    //Update Subject
	public function updateBatch($row_id=null){
		$this->form_validation->set_error_delimiters("<span class='text-danger'>","</span>");
        $this->form_validation->set_error_delimiters("<span class='text-danger'>","</span>");
			$this->form_validation->set_rules("batch_name","Batch Name", "trim|required");
			$this->form_validation->set_rules("batch_status","Batch Status", "trim|required");
			$this->form_validation->set_rules("batch_medium","Batch Medium", "trim|required");
			$this->form_validation->set_rules("batch_seat","Batch Seat", "trim|required");
			$this->form_validation->set_rules("batch_fee","Batch Fee", "trim|required");
			$this->form_validation->set_rules("batch_start_date","Batch Starting Date", "trim|required");
			$this->form_validation->set_rules("batch_start_time","Batch Starting Time", "trim|required");
			$this->form_validation->set_rules("batch_end_time","Batch End Time", "trim|required");
			$this->form_validation->set_rules("class_id","Class", "required");
			$this->form_validation->set_rules("subject_id","Subject", "required");
			$this->form_validation->set_rules("comment","Comment", "trim");

        if($this->form_validation->run()){
            $data = [
                "batch_name" => $this->input->post("batch_name"),	
                "batch_status" => $this->input->post("batch_status"),	
                "batch_medium" => $this->input->post("batch_medium"),	
                "batch_seat" => $this->input->post("batch_seat"),	
                "batch_fee" => $this->input->post("batch_fee"),	
                "batch_start_date" => $this->input->post("batch_start_date"),	
                "batch_start_time" => $this->input->post("batch_start_time"),	
                "batch_end_time" => $this->input->post("batch_end_time"),	
                "class_id" => $this->input->post("class_id"),	
                "subject_id" => $this->input->post("subject_id"),	
                "comment" => $this->input->post("comment")
            ];
            if($this->work->update_data("batch", $data, ["id"=>$this->input->post("batch_id")])){
                $response["alert"] = "<div class='alert alert-success rounded-0 border'>Batch successfully updated !!</div>";
                $response["status"] = 1;

                $data["action"] = "update";
                $data["result"] = $this->work->select_data("batch", ["id"=>$this->input->post("batch_id")]);
                $html = $this->load->view("batch/print-row", $data, true);

                $response["rowId"] = "row-".$this->input->post("batch_id");
                $response["updatedRow"] = $html;

            }else{
                $response["alert"] = "<div class='alert alert-danger rounded-0 border'>Batch does't updated !!</div>";
                $response["status"] = 2;
            }
        }else{
            $response["batch_id"] = strip_tags(form_error('batch_id'));
            $response["batch_status"] = strip_tags(form_error('batch_status'));
            $response["batch_name"] = strip_tags(form_error('batch_name'));
            $response["batch_medium"] = strip_tags(form_error('batch_medium'));
            $response["batch_seat"] = strip_tags(form_error('batch_seat'));
            $response["batch_fee"] = strip_tags(form_error('batch_fee'));
            $response["batch_start_date"] = strip_tags(form_error('batch_start_date'));
            $response["batch_start_time"] = strip_tags(form_error('batch_start_time'));
            $response["batch_end_time"] = strip_tags(form_error('batch_end_time'));
            $response["class_id"] = strip_tags(form_error('class_id'));
            $response["subject_id"] = strip_tags(form_error('subject_id'));
            $response["comment"] = strip_tags(form_error('comment'));
            $response['status'] = 0;
        }

        echo json_encode($response);
	}

    //this function helps to fill the data in update modal
	public function getData(){
		date_default_timezone_set("Asia/Kolkata");
		$id = $this->input->post("batch_id");
		$data["value"] = $this->work->select_data("batch", ["id"=>$id]);
		$response["batch_id"] = $data["value"][0]->id;
		$response["batch_name"] = $data["value"][0]->batch_name;
		$response["batch_status"] = $data["value"][0]->batch_status;
		$response["batch_fee"] = $data["value"][0]->batch_fee;
		$response["batch_medium"] = $data["value"][0]->batch_medium;
		$response["batch_seat"] = $data["value"][0]->batch_seat;
		$response["batch_start_date"] = $data["value"][0]->batch_start_date;
		$response["batch_start_time"] = $data["value"][0]->batch_start_time;
		$response["batch_end_time"] = $data["value"][0]->batch_end_time;
		$response["subject_id"] = $data["value"][0]->subject_id;
		$response["class_id"] = $data["value"][0]->class_id;
		$response["comment"] = $data["value"][0]->comment;
		echo json_encode($response);
    }
    
    //view batch Info
    public function viewInfo(){
        $id = $this->input->post("batch_id");
        $data["action"] = "view";
        $data["data"] = $this->work->select_data("batch", ['id'=>$id]);
        $html = $this->load->view("batch/print-row", $data, true);
        $response["html"] = $html;
        $response["status"] = 1;
        echo json_encode($response);
    }
    
    //Delete data
	public function deleteData(){
		$id = $this->input->post("batch_id");
		if($this->work->delete_data("batch", ["id"=>$id])){
			$response["rowId"] = "row-".$id;
			$response["alert"] = "<div class='alert alert-success rounded-0 border'>Batch deleted successfully !!</div>";
		}else{
			$response["alert"] = "<div class='alert alert-success rounded-0 border'>Batch does't deleted !!</div>";
		}
		echo json_encode($response);
	}


}




?>