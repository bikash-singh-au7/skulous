<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");

class BatchSetup extends CI_Controller {
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
	public function batch($action=null, $subaction=null){
        $data["classes"] = $this->work->select_data("classes", ["class_status" => 1, "session_id"=>$this->session->userdata('session_id')]);
        $data["subject"] = $this->work->select_data("subject", ["subject_status" => 1, "session_id"=>$this->session->userdata('session_id')]);
		if($action == "add"){
            $this->load->view("header/header.php");
            $this->load->view("sidebar/sidebar.php");
            $this->load->view("header/topmenu.php");
			$this->load->view("batch/add-batch.php", $data);
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
    public function addBatch($action = null){
		if($action == "add"){
			$this->form_validation->set_rules("batch_name","Batch Name", "trim|required|callback_is_bname_unique");
			$this->form_validation->set_rules("batch_medium","Batch Medium", "trim|required");
			$this->form_validation->set_rules("batch_seat","Batch Seat", "trim|required|is_natural_no_zero");
			$this->form_validation->set_rules("batch_fee","Batch Fee", "trim|required|is_natural_no_zero");
			$this->form_validation->set_rules("discount","Discount", "trim|is_natural");
			$this->form_validation->set_rules("batch_start_date","Batch Starting Date", "trim|required|callback_valid_batch_date");
			$this->form_validation->set_rules("batch_start_time","Batch Starting Time", "trim|required|callback_valid_start_time");
			$this->form_validation->set_rules("batch_end_time","Batch End Time", "differs[batch_start_time]|trim|required|callback_valid_end_time");
			$this->form_validation->set_rules("class_id","Class", "required");
			$this->form_validation->set_rules("subject_id","Subject", "required");
			$this->form_validation->set_rules("comment","Comment", "trim");
			if($this->form_validation->run()){
				$data = [
					"session_id" => $this->session->userdata("session_id"),	
					"batch_name" => strtoupper($this->input->post("batch_name")),	
					"batch_medium" => strtoupper($this->input->post("batch_medium")),	
					"batch_seat" => $this->input->post("batch_seat"),	
					"available_seat" => $this->input->post("batch_seat"),	
					"batch_fee" => $this->input->post("batch_fee"),	
					"discount" => $this->input->post("discount"),	
					"batch_start_date" => $this->input->post("batch_start_date"),	
					"batch_start_time" => $this->input->post("batch_start_time"),	
					"batch_end_time" => $this->input->post("batch_end_time"),	
					"class_id" => $this->input->post("class_id"),	
					"subject_id" => $this->input->post("subject_id"),	
					"comment" => strtoupper($this->input->post("comment"))
				];
				if($this->work->insert_data("batch", $data)){
                    $response["alert"] = "Created !!";
                    $response["message"] = "Batch successfully created.";
                    $response["modal"] = "success";
                    $response["status"] = 1;
                }else{
					$response["alert"] = "Oops error !!";
                    $response["message"] = "Batch does't created.";
                    $response["modal"] = "error";
                    $response["status"] = 2;
				}
			}else{
				$response["batch_name"] = strip_tags(form_error('batch_name'));
				$response["batch_medium"] = strip_tags(form_error('batch_medium'));
				$response["batch_seat"] = strip_tags(form_error('batch_seat'));
				$response["batch_fee"] = strip_tags(form_error('batch_fee'));
				$response["discount"] = strip_tags(form_error('discount'));
				$response["batch_start_date"] = strip_tags(form_error('batch_start_date'));
				$response["batch_start_time"] = strip_tags(form_error('batch_start_time'));
				$response["batch_end_time"] = strip_tags(form_error('batch_end_time'));
				$response["class_id"] = strip_tags(form_error('class_id'));
				$response["subject_id"] = strip_tags(form_error('subject_id'));
				$response["comment"] = strip_tags(form_error('comment'));
				$response['status'] = 0;
			}
			echo json_encode($response);
		}elseif($action == "manage-add"){
			$this->form_validation->set_rules("batch_name","Batch Name", "trim|required|callback_is_bname_unique");
			$this->form_validation->set_rules("batch_medium","Batch Medium", "trim|required");
			$this->form_validation->set_rules("batch_seat","Batch Seat", "trim|required|is_natural_no_zero");
			$this->form_validation->set_rules("batch_fee","Batch Fee", "trim|required|is_natural_no_zero");
			$this->form_validation->set_rules("discount","Discount", "trim|is_natural");
			$this->form_validation->set_rules("batch_start_date","Batch Starting Date", "trim|required|callback_valid_batch_date");
			$this->form_validation->set_rules("batch_start_time","Batch Starting Time", "trim|required|callback_valid_start_time");
			$this->form_validation->set_rules("batch_end_time","Batch End Time", "differs[batch_start_time]|trim|required|callback_valid_end_time");
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
					"discount" => $this->input->post("discount"),	
					"batch_start_date" => $this->input->post("batch_start_date"),	
					"batch_start_time" => $this->input->post("batch_start_time"),	
					"batch_end_time" => $this->input->post("batch_end_time"),	
					"class_id" => $this->input->post("class_id"),	
					"subject_id" => $this->input->post("subject_id"),	
					"comment" => $this->input->post("comment")
				];
				if($this->work->insert_data("batch", $data)){
					$response["alert"] = "Created !!";
                    $response["message"] = "Batch successfully created.";
                    $response["modal"] = "success";
                    $response["status"] = 1;

					$data["action"] = "manage-add";
					$data["result"] = $this->work->select_data("batch", ["id"=>$this->work->get_last_id()]);
					$html = $this->load->view("batch/print-row", $data, true);
					
					$response["lastRow"] = $html;
					//
				}else{
					$response["alert"] = "Oops error !!";
                    $response["message"] = "Batch does't created.";
                    $response["modal"] = "error";
                    $response["status"] = 2;
				}
			}else{
				$response["batch_name"] = strip_tags(form_error('batch_name'));
				$response["batch_medium"] = strip_tags(form_error('batch_medium'));
				$response["batch_seat"] = strip_tags(form_error('batch_seat'));
				$response["batch_fee"] = strip_tags(form_error('batch_fee'));
				$response["discount"] = strip_tags(form_error('discount'));
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
    
    //Update Batch
	public function updateBatch($row_id=null){
		$this->form_validation->set_error_delimiters("<span class='text-danger'>","</span>");
        $this->form_validation->set_error_delimiters("<span class='text-danger'>","</span>");
			$this->form_validation->set_rules("batch_name","Batch Name", "trim|required|callback_is_bname_unique_update");
			$this->form_validation->set_rules("batch_status","Batch Status", "trim|required");
			$this->form_validation->set_rules("batch_medium","Batch Medium", "trim|required");
			$this->form_validation->set_rules("batch_seat","Batch Seat", "trim|required");
			$this->form_validation->set_rules("batch_fee","Batch Fee", "trim|required");
			$this->form_validation->set_rules("discount","Discount", "trim|is_natural");
			$this->form_validation->set_rules("batch_start_date","Batch Starting Date", "trim|required|callback_valid_batch_date");
			$this->form_validation->set_rules("batch_start_time","Batch Starting Time", "trim|required|callback_valid_start_time_update");
			$this->form_validation->set_rules("batch_end_time","Batch End Time", "trim|required|callback_valid_end_time");
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
                "discount" => $this->input->post("discount"),	
                "batch_start_date" => $this->input->post("batch_start_date"),	
                "batch_start_time" => $this->input->post("batch_start_time"),	
                "batch_end_time" => $this->input->post("batch_end_time"),	
                "class_id" => $this->input->post("class_id"),	
                "subject_id" => $this->input->post("subject_id"),	
                "comment" => $this->input->post("comment")
            ];
            if($this->work->update_data("batch", $data, ["id"=>$this->input->post("batch_id")])){
                $response["alert"] = "Updated !!";
                $response["message"] = "Batch successfully updated.";
                $response["modal"] = "success";
                $response["status"] = 1;

                $data["action"] = "update";
                $data["result"] = $this->work->select_data("batch", ["id"=>$this->input->post("batch_id")]);
                $html = $this->load->view("batch/print-row", $data, true);

                $response["rowId"] = "row-".$this->input->post("batch_id");
                $response["updatedRow"] = $html;

            }else{
                $response["alert"] = "Oops error !!";
                $response["message"] = "Batch does't updated.";
                $response["modal"] = "error";
                $response["status"] = 2;
            }
        }else{
            $response["batch_id"] = strip_tags(form_error('batch_id'));
            $response["batch_status"] = strip_tags(form_error('batch_status'));
            $response["batch_name"] = strip_tags(form_error('batch_name'));
            $response["batch_medium"] = strip_tags(form_error('batch_medium'));
            $response["batch_seat"] = strip_tags(form_error('batch_seat'));
            $response["batch_fee"] = strip_tags(form_error('batch_fee'));
            $response["discount"] = strip_tags(form_error('discount'));
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
		$response["discount"] = $data["value"][0]->discount;
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
            $response["alert"] = "Deleted !!";
            $response["message"] = "Batch successfully deleted.";
            $response["modal"] = "success";
		}else{
			$response["alert"] = "Oops error !!";
            $response["message"] = "Batch does't deleted.";
            $response["modal"] = "error";
		}
		echo json_encode($response);
	}

    // ============================
    //Cutom Validation
    //For adding the data
    public function is_bname_unique($str){
        if($str != ""){
            $query = $this->work->select_data("batch", ["session_id"=>$this->session->userdata("session_id"), "batch_name"=>$str]);
            if(!empty($query[0])){
                $this->form_validation->set_message('is_bname_unique', 'This {field} is already exists');
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }
    
    public function valid_batch_date($str){
        if($str != ""){
            $session_query = $this->work->select_data("session", ["id"=>$this->session->userdata("session_id")]);
            $start_session = strtotime($session_query[0]->start_session);
            $end_session = strtotime($session_query[0]->end_session);
            
            $form_date = strtotime($str);
            if($form_date <= $end_session and $form_date >= $start_session){
                return TRUE;
            }else{
                $this->form_validation->set_message('valid_batch_date', 'The Batch date is not valid');
                return FALSE;
            }
        }
    }
    
    
    public function valid_start_time($str){
        if($str != ""){
            $query = $this->work->select_data("batch", ["session_id"=>$this->session->userdata("session_id"), "batch_start_time"=>$str, "batch_medium"=>$this->input->post("batch_medium"), "class_id"=>$this->input->post("class_id"), "subject_id"=>$this->input->post("subject_id")]);
            if(!empty($query[0])){
                $this->form_validation->set_message('valid_start_time', 'This {field} is already exists');
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }
    
     
    public function valid_end_time($str){
        if($str != ""){
            $batch_start_time = strtotime($this->input->post("batch_start_time"));
            $end_time_hour = date("h", strtotime($str))+date("h:m", strtotime("00:45"));
            $end_time_minut = date("m", strtotime($str));
            
            $after_one_hour = strtotime(date("h:m", strtotime($end_time_hour.":".$end_time_minut)));
            if(strtotime($str) <= $batch_start_time){
                $this->form_validation->set_message('valid_end_time', 'This {field} is greater Batch start time');
                return FALSE;
            }elseif(strtotime($str) > $after_one_hour){
                $this->form_validation->set_message('valid_end_time', 'This {field} must greater than start time + One Hour');
                return FALSE;
            }else{
                return TRUE;
            }
            
        }
    }
    
    
 
    //For update data
    public function is_bname_unique_update($str){
        if($str != ""){
            $query = $this->work->select_data("batch", ["session_id"=>$this->session->userdata("session_id"), "batch_name"=>$str, "id !="=>$this->input->post("batch_id")]);
            if(!empty($query[0])){
                $this->form_validation->set_message('is_bname_unique_update', 'This {field} is already exists');
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }
    
    public function valid_start_time_update($str){
        if($str != ""){
            $query = $this->work->select_data("batch", ["session_id"=>$this->session->userdata("session_id"), "batch_start_time"=>$str, "batch_medium"=>$this->input->post("batch_medium"), "class_id"=>$this->input->post("class_id"), "subject_id"=>$this->input->post("subject_id"), "id !="=>$this->input->post("batch_id")]);
            if(!empty($query[0])){
                $this->form_validation->set_message('valid_start_time_update', 'This {field} is already exists');
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }
    
    
    
}




?>