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
        $data["data"] = $this->work->select_data("staff");
		if($action == "add"){
            $this->load->view("header/header.php");
            $this->load->view("sidebar/sidebar.php");
            $this->load->view("header/topmenu.php");
			$this->load->view("staff/add-staff.php", $data);
			$this->load->view("footer/footer.php");
		}elseif($action == "manage"){
            $this->load->view("header/header.php");
            $this->load->view("sidebar/sidebar.php");
            $this->load->view("header/topmenu.php");
			$this->load->view("staff/manage-staff.php", $data);
			$this->load->view("footer/footer.php");
		}elseif($action=="grantpermission"){
            $this->load->view("header/header.php");
            $this->load->view("sidebar/sidebar.php");
            $this->load->view("header/topmenu.php");
			$this->load->view("staff/grant-permission.php", $data);
			$this->load->view("footer/footer.php");
        }
    }
    
    //Get Permission
    public function getPermission($action=null){
        $id = $this->input->post("staff_id");
		$data["value"] = $this->work->select_data("staff_permission", ["id"=>$id]);
		if(!empty($data["value"][0])){
            $response["session"] = $data["value"][0]->session;
            $response["classes"] = $data["value"][0]->classes;
            $response["subject"] = $data["value"][0]->subject;
            $response["staff"] = $data["value"][0]->staff;
            $response["registration"] = $data["value"][0]->registration;
            $response["payment"] = $data["value"][0]->payment;
            $response["sms"] = $data["value"][0]->sms;
            $response["status"] = 1;
        }else{
            $response["status"] = 0;
        }
		echo json_encode($response);
    }
    
    public function addPermission(){
        $this->form_validation->set_rules("staff_id","", "required|trim|numeric|is_unique[staff_permission.staff_id]");
        $this->form_validation->set_rules("session","Session", "trim|numeric");
        $this->form_validation->set_rules("classes","Class", "trim|numeric");
        
        if($this->form_validation->run()){
            $data = [
                "staff_id" => $this->input->post("staff_id"),	
                "session" => $this->input->post("session"),	
                "classes" => $this->input->post("classes"),	
                "subject" => $this->input->post("subject"),	
                "staff" => $this->input->post("staff"),	
                "registration" => $this->input->post("registration"),	
                "payment" => $this->input->post("payment"),	
                "sms" => $this->input->post("sms")
                
            ];
            if($this->work->insert_data("staff_permission", $data)){
                $response["alert"] = "Success !!";
                $response["message"] = "Permission Granted.";
                $response["status"] = 1;
                $response["modal"] = "success";
            }else{
                $response["alert"] = "Oops error !!";
                $response["message"] = "PermissionNot Granted";
                $response["status"] = 2;
                $response["modal"] = "error";
            }
        }else{
            $response["alert"] = "error !!";
            $response["message"] = "You can not grant permission al multiple time.";
            $response["status"] = 1;
            $response["modal"] = "error";
        }
        echo json_encode($response);
    } 
    
    public function updatePermission(){
        $this->form_validation->set_rules("staff_id","", "required|trim|numeric");
        $this->form_validation->set_rules("session","Session", "trim|numeric");
        $this->form_validation->set_rules("classes","Class", "trim|numeric");
        
        if($this->form_validation->run()){
            $data = [	
                "session" => $this->input->post("session"),	
                "classes" => $this->input->post("classes"),	
                "subject" => $this->input->post("subject"),	
                "staff" => $this->input->post("staff"),	
                "registration" => $this->input->post("registration"),	
                "payment" => $this->input->post("payment"),	
                "sms" => $this->input->post("sms")
                
            ];
            if($this->work->update_data("staff_permission", $data, ["staff_id"=>$this->input->post("staff_id")])){
                $response["alert"] = "Success !!";
                $response["message"] = "Permission Granted.";
                $response["status"] = 1;
                $response["modal"] = "success";
            }else{
                $response["alert"] = "Oops error !!";
                $response["message"] = "PermissionNot Granted";
                $response["status"] = 2;
                $response["modal"] = "error";
            }
        }else{
            $response["alert"] = "Oops error !!";
            $response["message"] = "PermissionNot Granted";
            $response["status"] = 2;
            $response["modal"] = "error";
        }
        echo json_encode($response);
    }
    
    
    //Add Subject
    public function addStaff($action = null){
		if($action == "add"){
			$this->form_validation->set_rules("staff_name","Staff Name", "trim|required");
			$this->form_validation->set_rules("gender","Gender", "required");
			$this->form_validation->set_rules("mobile_number","Mobile Number", "trim|required|exact_length[10]|numeric|is_unique[staff.mobile_number]");
			$this->form_validation->set_rules("email","Email", "trim|required|valid_email|is_unique[staff.email]");
			$this->form_validation->set_rules("address","Address", "trim|required");
			if($this->form_validation->run()){
				$data = [
					"staff_name" => $this->input->post("staff_name"),	
					"gender" => $this->input->post("gender"),	
					"mobile_number" => $this->input->post("mobile_number"),	
					"email" => $this->input->post("email"),	
					"password" => rand(11111,99999),	
					"profile_pic" => "",	
					"address" => $this->input->post("address")
				];
				if($this->work->insert_data("staff", $data)){
					$response["alert"] = "Added !!";
					$response["message"] = "Staff successfully added !!";
					$response["status"] = 1;
					$response["modal"] = "success";
				}else{
					$response["alert"] = "Oops error !!";
					$response["message"] = "Staff does't added !!";
					$response["status"] = 1;
					$response["modal"] = "error";
				}
			}else{
				$response["staff_name"] = strip_tags(form_error('staff_name'));
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
	public function updateData($row_id=null){
		$this->form_validation->set_rules("staff_name","Staff Name", "trim|required");
        $this->form_validation->set_rules("mobile_number","Mobile Number", "trim|required|exact_length[10]|numeric");
        $this->form_validation->set_rules("email","Email", "trim|required|valid_email");
        $this->form_validation->set_rules("staff_status","Status", "trim|required");
        $this->form_validation->set_rules("address","Address", "trim|required");

        if($this->form_validation->run()){
            $data = [
					"staff_name" => $this->input->post("staff_name"),	
					"staff_status" => $this->input->post("staff_status"),	
					"mobile_number" => $this->input->post("mobile_number"),	
					"email" => $this->input->post("email"),	
					"address" => $this->input->post("address")
				];
            if($this->work->update_data("staff", $data, ["id"=>$this->input->post("staff_id")])){
                $response["alert"] = "Updated !!";
                $response["message"] = "Staff successfully updated !!";
                $response["status"] = 1;
                $response["modal"] = "success";

                $data["action"] = "update";
                $data["result"] = $this->work->select_data("staff", ["id"=>$this->input->post("staff_id")]);
                $html = $this->load->view("staff/print-row", $data, true);

                $response["rowId"] = "row-".$this->input->post("staff_id");
                $response["updatedRow"] = $html;

            }else{
                $response["alert"] = "Oops error !!";
					$response["message"] = "Staff does't updated !!";
					$response["status"] = 2;
					$response["modal"] = "error";
            }
        }else{
            $response["staff_name"] = strip_tags(form_error('staff_name'));
            $response["mobile_number"] = strip_tags(form_error('mobile_number'));
            $response["staff_status"] = strip_tags(form_error('staff_status'));
            $response["email"] = strip_tags(form_error('email'));
            $response["address"] = strip_tags(form_error('address'));
            $response['status'] = 0;
        }

        echo json_encode($response);
	}

    //this function helps to fill the data in update modal
	public function getData(){
		date_default_timezone_set("Asia/Kolkata");
		$id = $this->input->post("staff_id");
		$data["value"] = $this->work->select_data("staff", ["id"=>$id]);
		$response["staff_id"] = $data["value"][0]->id;
		$response["staff_name"] = $data["value"][0]->staff_name;
		$response["mobile_number"] = $data["value"][0]->mobile_number;
		$response["email"] = $data["value"][0]->email;
		$response["staff_status"] = $data["value"][0]->staff_status;
		$response["address"] = $data["value"][0]->address;
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