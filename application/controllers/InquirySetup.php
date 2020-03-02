<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InquirySetup extends CI_Controller {
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
	public function inquiry($action=null, $subaction=null){
        $data["subject"] = $this->work->select_data("subject", ["subject_status" => 1, "session_id"=>$this->session->userdata('session_id')]);
        $data["class"] = $this->work->select_data("classes", ["class_status" => 1, "session_id"=>$this->session->userdata('session_id')]);
		if($action == "add"){
            $this->load->view("header/header.php");
            $this->load->view("sidebar/sidebar.php");
            $this->load->view("header/topmenu.php");
			$this->load->view("inquiry/add-inquiry.php", $data);
			$this->load->view("footer/footer.php");
		}elseif($action == "manage"){
            $data["data"] = $this->work->select_data("inquiry",["session_id" => $this->session->userdata('session_id')]);
            $this->load->view("header/header.php");
            $this->load->view("sidebar/sidebar.php");
            $this->load->view("header/topmenu.php");
			$this->load->view("inquiry/manage-inquiry.php", $data);
			$this->load->view("footer/footer.php");
		}
    }
    
    //Add Student
    public function addInquiry($action = null){
		if($action == "add"){
			$this->form_validation->set_error_delimiters("<span class='text-danger'>","</span>");
			$this->form_validation->set_rules("student_name","Student Name", "trim|required");
			
			$this->form_validation->set_rules("student_mobile","Student Mobile", "trim|required|numeric|exact_length[10]");
			$this->form_validation->set_rules("student_email","Student Email", "trim|valid_email");
			
			$this->form_validation->set_rules("address","Address", "required|trim");
			$this->form_validation->set_rules("state","State", "required|trim");
			$this->form_validation->set_rules("dist","Dist", "required|trim");
			$this->form_validation->set_rules("class_id","Class", "required|trim");
			$this->form_validation->set_rules("subject_id","Subject", "required|trim");
			$this->form_validation->set_rules("medium","Medium", "required|trim");
			$this->form_validation->set_rules("refrence","Refrence", "trim");
			
			$this->form_validation->set_rules("comment","Comment", "trim");
			if($this->form_validation->run()){
				$data = [
					"session_id" => $this->session->userdata("session_id"),	
					"student_name" => $this->input->post("student_name"),	
					
					"student_mobile" => $this->input->post("student_mobile"),	
					"student_email" => $this->input->post("student_email"),	
						
					"address" => $this->input->post("address"),	
					"state" => $this->input->post("state"),	
					"dist" => $this->input->post("dist"),	
						
					"subject_id" => $this->input->post("subject_id"),	
					"class_id" => $this->input->post("class_id"),	
					"medium" => $this->input->post("medium"),	
					"inquiry_purpose" => $this->input->post("inquiry_purpose"),	
					"refrence" => $this->input->post("refrence"),	
					"comment" => $this->input->post("comment")
				];
				if($this->work->insert_data("inquiry", $data)){
                    
                    $response["alert"] = "Quiry Submited!!";
                    $response["message"] = "Data Successfully Added.";
					$response["status"] = 1;
				}else{
                    $response["alert"] = "Not Submited!!";
                    $response["message"] = "Oops Some Error Occured.";
					$response["status"] = 2;
                }
			}else{
				$response["student_name"] = strip_tags(form_error('student_name'));
				$response["student_mobile"] = strip_tags(form_error('student_mobile'));
				$response["student_email"] = strip_tags(form_error('student_email'));
				$response["address"] = strip_tags(form_error('address'));
				$response["state"] = strip_tags(form_error('state'));
				$response["dist"] = strip_tags(form_error('dist'));
				
				$response["class_id"] = strip_tags(form_error('class_id'));
				$response["subject_id"] = strip_tags(form_error('subject_id'));
				$response["inquiry_purpose"] = strip_tags(form_error('inquiry_purpose'));
				$response["medium"] = strip_tags(form_error('medium'));
				$response["refrence"] = strip_tags(form_error('refrence'));
				$response["comment"] = strip_tags(form_error('comment'));
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
    
    //Update Inquiry Data
	public function updateData($row_id=null){
		$this->form_validation->set_rules("student_name","Student Name", "trim|required");
			
        $this->form_validation->set_rules("student_mobile","Student Mobile", "trim|required|numeric|exact_length[10]");
        $this->form_validation->set_rules("student_email","Student Email", "trim|valid_email");

        $this->form_validation->set_rules("address","Address", "required|trim");
        $this->form_validation->set_rules("state","State", "required|trim");
        $this->form_validation->set_rules("dist","Dist", "required|trim");
        $this->form_validation->set_rules("class_id","Class", "required|trim");
        $this->form_validation->set_rules("subject_id","Subject", "required|trim");
        $this->form_validation->set_rules("medium","Medium", "required|trim");
        $this->form_validation->set_rules("refrence","Refrence", "trim");

        $this->form_validation->set_rules("comment","Comment", "trim");

        if($this->form_validation->run()){
            $data = [
                "student_name" => $this->input->post("student_name"),	

                "student_mobile" => $this->input->post("student_mobile"),	
                "student_email" => $this->input->post("student_email"),	

                "address" => $this->input->post("address"),	
                "state" => $this->input->post("state"),	
                "dist" => $this->input->post("dist"),	

                "subject_id" => $this->input->post("subject_id"),	
                "class_id" => $this->input->post("class_id"),	
                "medium" => $this->input->post("medium"),	
                "inquiry_purpose" => $this->input->post("inquiry_purpose"),	
                "refrence" => $this->input->post("refrence"),	
                "comment" => $this->input->post("comment")
            ];
            if($this->work->update_data("inquiry", $data, ["id"=>$this->input->post("inquiry_id")])){
                $response["status"] = 1;
                $response["alert"] = "Updated!";
                $response["message"] = "Data successfully updated.";

                $data["action"] = "update";
                $data["result"] = $this->work->select_data("inquiry", ["id"=>$this->input->post("inquiry_id")]);
                $html = $this->load->view("inquiry/print-row", $data, true);

                $response["rowId"] = "row-".$this->input->post("inquiry_id");
                $response["updatedRow"] = $html;

            }else{
                $response["alert"] = "Not Updated!";
                $response["message"] = "Data does't updated.";
                $response["status"] = 2;
            }
        }else{
            $response["student_name"] = strip_tags(form_error('student_name'));
            $response["student_mobile"] = strip_tags(form_error('student_mobile'));
            $response["student_email"] = strip_tags(form_error('student_email'));
            $response["address"] = strip_tags(form_error('address'));
            $response["state"] = strip_tags(form_error('state'));
            $response["dist"] = strip_tags(form_error('dist'));

            $response["class_id"] = strip_tags(form_error('class_id'));
            $response["subject_id"] = strip_tags(form_error('subject_id'));
            $response["inquiry_purpose"] = strip_tags(form_error('inquiry_purpose'));
            $response["medium"] = strip_tags(form_error('medium'));
            $response["refrence"] = strip_tags(form_error('refrence'));
            $response["comment"] = strip_tags(form_error('comment'));
            $response['status'] = 0;
        }

        echo json_encode($response);
	}
    
    //Update Status
	public function updateStatus($row_id=null){
		$this->form_validation->set_rules("inquiry_id","", "trim|required");
		$this->form_validation->set_rules("inquiry_status","", "trim|required");
        if($this->form_validation->run()){
            $data = [
                "inquiry_status" => $this->input->post("inquiry_status"),	
            ];
            if($this->work->update_data("inquiry", $data, ["id"=>$this->input->post("inquiry_id")])){
                $response["status"] = 1;
                $response["alert"] = "Updated!";
                $response["message"] = "Data successfully updated.";

                $data["action"] = "update";
                $data["result"] = $this->work->select_data("inquiry", ["id"=>$this->input->post("inquiry_id")]);
                $html = $this->load->view("inquiry/print-row", $data, true);

                $response["rowId"] = "row-".$this->input->post("inquiry_id");
                $response["updatedRow"] = $html;

            }else{
                $response["alert"] = "Not Updated!";
                $response["message"] = "Data does't updated.";
                $response["status"] = 2;
            }
        }else{
            
            $response["alert"] = "Somthing Wrong!";
            $response["message"] = "Data does't updated.";
            $response["status"] = 0;
        }

        echo json_encode($response);
	}

    //this function helps to fill the data in update modal
	public function getData(){
		date_default_timezone_set("Asia/Kolkata");
		$id = $this->input->post("inquiry_id");
		$data["value"] = $this->work->select_data("inquiry", ["id"=>$id]);
		$response["inquiry_id"] = $data["value"][0]->id;
		$response["student_name"] = $data["value"][0]->student_name;
		$response["student_mobile"] = $data["value"][0]->student_mobile;
		$response["student_email"] = $data["value"][0]->student_email;
		$response["address"] = $data["value"][0]->address;
		$response["state"] = $data["value"][0]->state;
		$response["dist"] = $data["value"][0]->dist;
		$response["class_id"] = $data["value"][0]->class_id;
		$response["subject_id"] = $data["value"][0]->subject_id;
		$response["medium"] = $data["value"][0]->medium;
		$response["inquiry_purpose"] = $data["value"][0]->inquiry_purpose;
		$response["comment"] = $data["value"][0]->comment;
		$response["refrence"] = $data["value"][0]->refrence;
		
		echo json_encode($response);
    }
    
    //view Info
    public function viewInfo(){
        $id = $this->input->post("inquiry_id");
        $data["action"] = "view";
        $data["data"] = $this->work->select_data("inquiry", ['id'=>$id]);
        $html = $this->load->view("inquiry/print-row", $data, true);
        $response["html"] = $html;
        $response["status"] = 11;
        echo json_encode($response);
    }
    
    //Delete data
	public function deleteData(){
		$id = $this->input->post("inquiry_id");
		if($this->work->delete_data("inquiry", ["id"=>$id])){
			$response["rowId"] = "row-".$id;
			$response["alert"] = "Data deleted!</div>";
			$response["message"] = "Inquiry deleted successfully !!</div>";
		}else{
            $response["alert"] = "Not deleted!</div>";
			$response["message"] = "Data does't Deleted.</div>";
		}
		echo json_encode($response);
	}

    
//Send Sms
    public function sendsms(){
        $this->form_validation->set_rules("message", "Message", "required|trim");
        $this->form_validation->set_rules("sender", "Sender Id", "trim|exact_length[6]|alpha");
        $this->form_validation->set_rules("inquiry_id", "Inquiry Id", "required");
        if($this->form_validation->run()){
            $data = $this->work->select_data("inquiry", ["id"=>$this->input->post("inquiry_id")]);
            $mobile_number = $data[0]->student_mobile;
            $student_name = $data[0]->student_name;
            $msg = $this->input->post("message");
            $sender = $this->input->post("sender");
            $msg = str_replace("@name", $student_name, $msg);
            
            if($this->work->send_sms($mobile_number, $msg, $sender)){
                $response["status"] = 1;
                $response["alert"] = "SMS Send !";
                $response["message"] = "Wow Message send successfully.";
            }else{
                $response["status"] = 2;
                $response["alert"] = "SMS not send !";
                $response["message"] = "Oops error occured.";
            }
        }else{
            $response["status"] = 0;
            $response["message"] = strip_tags(form_error("message"));
            $response["sender"] = strip_tags(form_error("sender"));
            $response["reg_id"] = strip_tags(form_error("reg_id"));
        }
        echo json_encode($response);
        
    }
    


}




?>