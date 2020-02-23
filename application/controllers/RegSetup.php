<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RegSetup extends CI_Controller {
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
	public function registration($action=null, $subaction=null){
        $data["batch"] = $this->work->select_data("batch", ["batch_status" => 1, "session_id"=>$this->session->userdata('session_id')]);
		if($action == "add"){
            $this->load->view("header/header.php");
            $this->load->view("sidebar/sidebar.php");
            $this->load->view("header/topmenu.php");
			$this->load->view("registration/add-registration.php", $data);
			$this->load->view("footer/footer.php");
		}elseif($action == "manage"){
            $data["data"] = $this->work->select_data("registration",["session_id" => $this->session->userdata('session_id')]);
            $this->load->view("header/header.php");
            $this->load->view("sidebar/sidebar.php");
            $this->load->view("header/topmenu.php");
			$this->load->view("registration/manage-registration.php", $data);
			$this->load->view("footer/footer.php");
		}
    }
    
    //Add Subject
    public function addReg($action = null){
		if($action == "add"){
			$this->form_validation->set_error_delimiters("<span class='text-danger'>","</span>");
			$this->form_validation->set_rules("student_name","Student Name", "trim|required");
			$this->form_validation->set_rules("gender","Gender", "trim|required");
			$this->form_validation->set_rules("category","Category", "trim|required");
			$this->form_validation->set_rules("dob","Dob", "trim|required");
			$this->form_validation->set_rules("father_name","Father Name", "trim|required");
			$this->form_validation->set_rules("mother_name","Mother Name", "trim|required");
			$this->form_validation->set_rules("student_mobile","Student Mobile", "trim|required|numeric|exact_length[10]");
			$this->form_validation->set_rules("student_email","Student Email", "trim|valid_email");
			$this->form_validation->set_rules("parent_mobile","Parent Mobile", "trim|numeric|exact_length[10]");
			$this->form_validation->set_rules("parent_email","Parent Email", "trim|valid_email");
			$this->form_validation->set_rules("address","Address", "required|trim");
			$this->form_validation->set_rules("state","State", "required|trim");
			$this->form_validation->set_rules("dist","Dist", "required|trim");
			$this->form_validation->set_rules("pin_code","Pin Code", "required|trim");
			$this->form_validation->set_rules("school","school", "trim");
			$this->form_validation->set_rules("board","board", "trim");
			$this->form_validation->set_rules("batch_id","Batch id", "required");
			$this->form_validation->set_rules("discount","Discount", "trim|numeric");
			$this->form_validation->set_rules("payment_amount","Payment Amount", "trim|numeric");
			$this->form_validation->set_rules("payment_date","Payment Date", "");
			$this->form_validation->set_rules("comment","Comment", "trim");
			if($this->form_validation->run()){
				$data = [
					"session_id" => $this->session->userdata("session_id"),	
					"student_name" => $this->input->post("student_name"),	
					"gender" => $this->input->post("gender"),	
					"category" => $this->input->post("category"),	
					"dob" => $this->input->post("dob"),	
					"father_name" => $this->input->post("father_name"),	
					"mother_name" => $this->input->post("mother_name"),	
					"student_mobile" => $this->input->post("student_mobile"),	
					"student_email" => $this->input->post("student_email"),	
					"password" => rand(11111,99999),	
					"parent_mobile" => $this->input->post("parent_mobile"),	
					"parent_email" => $this->input->post("parent_email"),	
					"address" => $this->input->post("address"),	
					"state" => $this->input->post("state"),	
					"dist" => $this->input->post("dist"),	
					"pin_code" => $this->input->post("pin_code"),	
					"school" => $this->input->post("school"),	
					"board" => $this->input->post("board"),	
					"batch_id" => $this->input->post("batch_id"),	
					"discount" => $this->input->post("discount"),	
					"comment" => $this->input->post("comment")
				];
				if($this->work->insert_data("registration", $data)){
					$response["alert"] = "<div class='alert alert-success rounded-0 border'>Student successfully added !!</div>";
					$response["status"] = 1;
				}else{
					$response["alert"] = "<div class='alert alert-danger rounded-0 border'>Student does't added !!</div>";
					$response["status"] = 2;
				}
			}else{
				$response["student_name"] = strip_tags(form_error('student_name'));
				$response["gender"] = strip_tags(form_error('gender'));
				$response["category"] = strip_tags(form_error('category'));
				$response["dob"] = strip_tags(form_error('dob'));
				$response["father_name"] = strip_tags(form_error('father_name'));
				$response["mother_name"] = strip_tags(form_error('mother_name'));
				$response["student_mobile"] = strip_tags(form_error('student_mobile'));
				$response["student_email"] = strip_tags(form_error('student_email'));
				$response["parent_mobile"] = strip_tags(form_error('parent_mobile'));
				$response["parent_email"] = strip_tags(form_error('parent_email'));
				$response["address"] = strip_tags(form_error('address'));
				$response["state"] = strip_tags(form_error('state'));
				$response["dist"] = strip_tags(form_error('dist'));
				$response["pin_code"] = strip_tags(form_error('pin_code'));
				$response["school"] = strip_tags(form_error('school'));
				$response["board"] = strip_tags(form_error('board'));
				$response["batch_id"] = strip_tags(form_error('batch_id'));
				$response["discount"] = strip_tags(form_error('discount'));
				$response["comment"] = strip_tags(form_error('comment'));
				$response["payment_amount"] = strip_tags(form_error('payment_amount'));
				$response["payment_date"] = strip_tags(form_error('payment_date'));
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