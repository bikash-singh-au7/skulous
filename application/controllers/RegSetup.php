<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");

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
            //Check Format Id
            $format_string = $this->work->select_data("reg_format", ["session_id"=>$this->session->userdata("session_id"), "status"=>1]);
            $format_string = $format_string[0]->format_string;
            if($format_string == ""){
                redirect(base_url("adminsetup/setting"));
            }
            
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
    
    //Add Student
    public function addReg($action = null){
		if($action == "add"){
            $batch_id = $this->input->post("batch_id");
            $available_seat = -1;
            if($batch_id != ""){
                $batch_info = $this->work->select_data("batch", ["id"=>$batch_id]);
                $available_seat = $batch_info[0]->available_seat;
            }
            
            //check available seat
            if($available_seat == 0){
                $response["alert"] = "Batch Full !!";
                $response["message"] = "Batch Seat full Select another batch";
                $response["status"] = 2;
                $response["modal"] = "error";
            }else{
            
                $this->form_validation->set_rules("student_name","Student Name", "trim|required");
                $this->form_validation->set_rules("gender","Gender", "trim|required");
                $this->form_validation->set_rules("category","Category", "trim|required");
                $this->form_validation->set_rules("dob","Dob", "trim|required");
                $this->form_validation->set_rules("father_name","Father Name", "trim|required");
                $this->form_validation->set_rules("mother_name","Mother Name", "trim|required");
                $this->form_validation->set_rules("student_mobile","Student Mobile", "trim|required|numeric|exact_length[10]|callback_student_mobile");
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
                $this->form_validation->set_rules("discount","Discount", "trim|numeric|callback_check_discount");
                $this->form_validation->set_rules("payment_amount","Payment Amount", "trim|numeric|is_natural_no_zero");
                $this->form_validation->set_rules("payment_date","Payment Date", "trim|callback_valid_payment_date");
                $this->form_validation->set_rules("comment","Comment", "trim");
                if($this->form_validation->run()){

                    //For Student Id
                    $format_string = $this->work->select_data("reg_format", ["session_id"=>$this->session->userdata("session_id"), "status"=>1]);
                    $format_string = $format_string[0]->format_string;
                    $str_arr = explode ("-", $format_string);  
                    $student_id = "";
                    foreach($str_arr as $str){
                        if($str === "Y"){
                            $value = $this->work->select_data("session", ["id"=>$this->session->userdata("session_id")]);
                            $student_id = $student_id.date("Y", strtotime($value[0]->start_session));
                        }elseif($str === "y"){
                            $value = $this->work->select_data("session", ["id"=>$this->session->userdata("session_id")]);
                            $student_id = $student_id.date("y", strtotime($value[0]->start_session));
                        }elseif($str === "S"){
                            $batch_info = $this->work->select_data("batch", ["id"=>$this->input->post("batch_id")]);
                            $subject_id = $batch_info[0]->subject_id;

                            $value = $this->work->select_data("subject", ["id"=>$subject_id]);
                            $student_id = $student_id.$value[0]->subject_code;
                        }elseif($str === "I"){
                            $value = $this->work->select_data("admin", ["id"=>$this->session->userdata("id")]);
                            $student_id = $student_id.$value[0]->institute_code;
                        }elseif(is_numeric($str)){
                            $max_id = $this->work->select_max("registration", ["session_id"=>$this->session->userdata("session_id")], "id");

                            if($max_id[0]->id == 0){
                                $max_id = 1;
                            }else{
                                $max_id = $max_id[0]->id;
                            }

                            $student_id = $student_id.sprintf("%0".$str."d", $max_id);
                        }
                    }

                    $data = [
                        "student_id" => $student_id,	
                        "session_id" => $this->session->userdata("session_id"),	
                        "student_name" => strtoupper($this->input->post("student_name")),	
                        "gender" => strtoupper($this->input->post("gender")),	
                        "category" => strtoupper($this->input->post("category")),	
                        "dob" => $this->input->post("dob"),	
                        "father_name" => strtoupper($this->input->post("father_name")),	
                        "mother_name" => strtoupper($this->input->post("mother_name")),	
                        "student_mobile" => $this->input->post("student_mobile"),	
                        "student_email" => $this->input->post("student_email"),	
                        "password" => rand(11111,99999),	
                        "parent_mobile" => $this->input->post("parent_mobile"),	
                        "parent_email" => $this->input->post("parent_email"),	
                        "address" => strtoupper($this->input->post("address")),	
                        "state" => $this->input->post("state"),	
                        "dist" => $this->input->post("dist"),	
                        "pin_code" => $this->input->post("pin_code"),	
                        "school" => strtoupper($this->input->post("school")),	
                        "board" => strtoupper($this->input->post("board")),	
                        "batch_id" => $this->input->post("batch_id"),	
                        "discount" => $this->input->post("discount"),	
                        "comment" => strtoupper($this->input->post("comment"))
                    ];
                    if($this->work->insert_data("registration", $data)){
                        
                        
                        //=============================================
                        //For Payment
                                                
                        $response["payment_alert"] = "";
                        //now payment amount
                        $payment_amount = $this->input->post("payment_amount");
                        
                        if($payment_amount != ""){
                            //created last id
                            $reg_id = $this->db->insert_id();
                            //get batch fee and batch discount if available
                            $batch_info = $this->work->select_data("batch", ["id"=>$this->input->post("batch_id")]);
                            $batch_fee = $batch_info[0]->batch_fee;
                            $batch_discount = $batch_info[0]->discount;
                            
                            //get discount from registration if available
                            $reg_info = $this->work->select_data("registration", ["id"=>$reg_id]);
                            $reg_discount = $reg_info[0]->discount;

                            $payble_amount = $batch_fee-($batch_discount+$reg_discount);
                            
                            if($payment_amount >= $payble_amount){
                                $full_paid = 1;
                            }else{
                                $full_paid = 0;
                            }
                            
                            
                            $data = [
                                "session_id" => $this->session->userdata("session_id"),
                                "reg_id" => $reg_id,
                                "amount" => $payment_amount,
                                "payment_date" => $this->input->post("payment_date")
                            ];
                            if($this->work->insert_data("payment", $data)){
                                $response["payment_alert"] = "1";
                                //update registration table if full paid
                                if($full_paid){
                                    if($this->work->update_data("registration", ["full_paid"=>$full_paid], ["id"=>$reg_id])){
                                        $response["full_paid"] = 1;
                                    }else{
                                        $response["full_paid"] = 0;
                                    }
                                }
                                
                                
                            }else{
                                $response["payment_alert"] = "0";
                            }
                        }
                        
                        if($response["payment_alert"] == ""){
                            $response["alert"] = "Registration Done !!";
                            $response["message"] = "Registration successfully done.";
                        }elseif($response["payment_alert"] == "1"){
                            $response["alert"] = "Registration & Payment Done !!";
                            $response["message"] = "Registration & Payment successfully done.";
                        }else{
                            $response["alert"] = "Registration Done But Payment error !!";
                            $response["message"] = "Registration successfully done but error occured in Payment.";
                        }
                        
                        //============================================//
                        /* Reduce the batch seat with -1 */
                        if($this->work->update_data("batch", ["available_seat"=>$available_seat-1], ["id"=>$batch_id])){
                            $response["updated_batch_seat"] = $available_seat-1;
                        }else{
                            $response["updated_batch_seat"] = "Batch seat not reduce";
                        }
                        //============================================//
                        
                        $response["modal"] = "success";
                        $response["status"] = 1;
                    }else{
                        $response["alert"] = "Oops error !!";
                        $response["message"] = "Registration not done.";
                        $response["status"] = 2;
                        $response["status"] = "error";
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
    
    //Update Student Data
	public function updateRegData($row_id=null){
		$this->form_validation->set_rules("student_name","Student Name", "trim|required");
        $this->form_validation->set_rules("gender","Gender", "trim|required");
        $this->form_validation->set_rules("category","Category", "trim|required");
        $this->form_validation->set_rules("dob","Dob", "trim|required");
        $this->form_validation->set_rules("father_name","Father Name", "trim|required");
        $this->form_validation->set_rules("mother_name","Mother Name", "trim|required");
        $this->form_validation->set_rules("student_mobile","Student Mobile", "trim|required|numeric|exact_length[10]|callback_student_mobile_update");
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
        $this->form_validation->set_rules("discount","Discount", "trim|numeric|callback_check_discount");
        $this->form_validation->set_rules("payment_amount","Payment Amount", "trim|numeric|is_natural");
        $this->form_validation->set_rules("payment_date","Payment Date", "trim|callback_valid_payment_date");
        $this->form_validation->set_rules("comment","Comment", "trim");

        if($this->form_validation->run()){
            $data = [
                "student_name" => $this->input->post("student_name"),	
                "gender" => $this->input->post("gender"),	
                "category" => $this->input->post("category"),	
                "dob" => $this->input->post("dob"),	
                "father_name" => $this->input->post("father_name"),	
                "mother_name" => $this->input->post("mother_name"),	
                "student_mobile" => $this->input->post("student_mobile"),	
                "student_email" => $this->input->post("student_email"),	
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
            if($this->work->update_data("registration", $data, ["id"=>$this->input->post("reg_id")])){
                $response["status"] = 1;
                $response["alert"] = "Updated!";
                $response["message"] = "Data successfully updated.";

                $data["action"] = "update";
                $data["result"] = $this->work->select_data("registration", ["id"=>$this->input->post("reg_id")]);
                $html = $this->load->view("registration/print-row", $data, true);

                $response["rowId"] = "row-".$this->input->post("reg_id");
                $response["updatedRow"] = $html;

            }else{
                $response["alert"] = "Not Updated!";
                $response["message"] = "Data does't updated.";
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
            $response["payble_amount"] = strip_tags(form_error('payble_amount'));
            $response["discount"] = strip_tags(form_error('discount'));
            $response["comment"] = strip_tags(form_error('comment'));
            $response["payment_amount"] = strip_tags(form_error('payment_amount'));
            $response["payment_date"] = strip_tags(form_error('payment_date'));
            $response['status'] = 0;
        }

        echo json_encode($response);
	}

    //this function helps to fill the data in update modal
	public function getData(){
		date_default_timezone_set("Asia/Kolkata");
		$id = $this->input->post("reg_id");
		$data["value"] = $this->work->select_data("registration", ["id"=>$id]);
		$response["student_name"] = $data["value"][0]->student_name;
		$response["reg_id"] = $data["value"][0]->id;
		$response["gender"] = $data["value"][0]->gender;
		$response["category"] = $data["value"][0]->category;
		$response["dob"] = $data["value"][0]->dob;
		$response["father_name"] = $data["value"][0]->father_name;
		$response["mother_name"] = $data["value"][0]->mother_name;
		$response["student_mobile"] = $data["value"][0]->student_mobile;
		$response["student_email"] = $data["value"][0]->student_email;
		$response["parent_mobile"] = $data["value"][0]->parent_mobile;
		$response["parent_email"] = $data["value"][0]->parent_email;
		$response["address"] = $data["value"][0]->address;
		$response["state"] = $data["value"][0]->state;
		$response["dist"] = $data["value"][0]->dist;
		$response["pin_code"] = $data["value"][0]->pin_code;
		$response["school"] = $data["value"][0]->school;
		$response["board"] = $data["value"][0]->board;
		$response["batch_id"] = $data["value"][0]->batch_id;
//		$response["payble_amount"] = $data["value"][0]->payble_amount;
		$response["discount"] = $data["value"][0]->discount;
		$response["comment"] = $data["value"][0]->comment;
		echo json_encode($response);
    }
    
    //view Registration Info
    public function viewInfo(){
        $id = $this->input->post("reg_id");
        $data["action"] = "view";
        $data["data"] = $this->work->select_data("registration", ['id'=>$id]);
        $html = $this->load->view("registration/print-row", $data, true);
        $response["html"] = $html;
        $response["status"] = 1;
        echo json_encode($response);
    }
    
    //Delete data
	public function deleteData(){
		$id = $this->input->post("reg_id");
        //get registration ingo
        $reg_info = $this->work->select_data("registration", ["id"=>$id]);
        $batch_id = $reg_info[0]->batch_id;
        
        //get batch info
        $batch_info = $this->work->select_data("batch", ["id"=>$batch_id]);
        $available_seat = $batch_info[0]->available_seat;
        
        
		if($this->work->delete_data("registration", ["id"=>$id])){
            //update batch seat
			$this->work->update_data("batch", ["available_seat"=>$available_seat+1], ["id"=>$batch_id]);
            
            $response["rowId"] = "row-".$id;
            
			$response["alert"] = "Deleted !!";
			$response["message"] = "Student deleted successfully !!";
			$response["modal"] = "success";
		}else{
			$response["alert"] = "Oops error !!";
			$response["message"] = "Student does't deleted !!";
			$response["modal"] = "error";
		}
		echo json_encode($response);
	}
    
    // Get Payment
    public function batchFee(){
       $batch_id = $this->input->post("batch_id");
       $data["fee"] = $this->work->select_data("batch",["id"=>$batch_id]);
       $fee = $data["fee"][0]->batch_fee;
       $response["fee"]= $fee;
       $response["available_seat"]= $data["fee"][0]->available_seat;
       $response["discount"]= $data["fee"][0]->discount;
       echo json_encode($response);
   } 
    
    //Send Sms
    public function sendsms(){
        $this->form_validation->set_rules("message", "Message", "required|trim");
        $this->form_validation->set_rules("sender", "Sender Id", "trim|exact_length[6]|alpha");
        $this->form_validation->set_rules("reg_id", "Registration Id", "required");
        if($this->form_validation->run()){
            $data = $this->work->select_data("registration", ["id"=>$this->input->post("reg_id")]);
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
    
    //make Payment
    public function makePayment($action = null){
        if($action == "manage"){
            $this->form_validation->set_rules("amount", "Amount", "required|trim|numeric|is_natural");
            $this->form_validation->set_rules("payment_date", "Payment Date", "required|trim|callback_valid_payment_date_for_payment");
            $this->form_validation->set_rules("reg_id", "Reg Id", "required|trim");
            if($this->form_validation->run()){
                
                $reg_id = $this->input->post("reg_id");
                
                //get discount from registration if available
                $reg_info = $this->work->select_data("registration", ["id"=>$reg_id]);
                $reg_discount = $reg_info[0]->discount;
                $full_paid = $reg_info[0]->full_paid;
                $batch_id = $reg_info[0]->batch_id;
                
                if($full_paid){
                    $full_paid = 0;
                }else{
                    //get batch fee and batch discount if available
                    $batch_info = $this->work->select_data("batch", ["id"=>$batch_id]);
                    $batch_fee = $batch_info[0]->batch_fee;
                    $batch_discount = $batch_info[0]->discount;


                    //get total payment of this student
                    $pay_info = $this->work->select_sum("payment", ["reg_id"=>$reg_id], "amount");
                    $total_amount = $pay_info[0]->amount;

                    //get now payment amount
                    $now_payment_amount = $this->input->post("amount");

                    $dues_amount = $batch_fee-($batch_discount+$reg_discount+$total_amount+$now_payment_amount);

                    if($dues_amount <= 0){
                        $full_paid = 1;
                    }else{
                        $full_paid = 0;
                    }
                }
                
                
                
                $data = [
                    "session_id" => $this->session->userdata("session_id"),
                    "reg_id" => $this->input->post("reg_id"),
                    "amount" => $this->input->post("amount"),
                    "payment_date" => $this->input->post("payment_date")
                ];

                if($this->work->insert_data("payment", $data)){
                    $response["status"] = 1;
                    $response["alert"] = "Payment Done!";
                    $response["message"] = "Payment Successfully Done.";
                    $response["modal"] = "success";
                    
                    //update registration table if full paid
                    if($full_paid){
                        if($this->work->update_data("registration", ["full_paid"=>$full_paid], ["id"=>$reg_id])){
                            $response["full_paid"] = 1;
                        }else{
                            $response["full_paid"] = 0;
                        }
                    }
                    
                    //Update the Payment Row
                    $response["rowId"] = "row-".$this->input->post("reg_id");
                    $data["action"] = "update";
                    $data["result"] = $this->work->select_data("registration", ["id"=>$this->input->post("reg_id")]);
                    $html = $this->load->view("registration/print-row", $data, true);
                    $response["html"] = $html;
                    
                }else{
                    $response["status"] = 2;
                    $response["alert"] = "Oops error!";
                    $response["message"] = "Payment Not Done.";
                    $response["modal"] = "error";
                }
            }else{
                $response["status"] = 0;
                $response["amount"] = strip_tags(form_error("amount"));
                $response["payment_date"] = strip_tags(form_error("payment_date"));
            }
        }else{
            $this->form_validation->set_rules("amount", "Amount", "required|trim|numeric|is_natural");
            $this->form_validation->set_rules("payment_date", "Payment Date", "required|trim");
            $this->form_validation->set_rules("reg_id", "Reg Id", "required|trim");
            if($this->form_validation->run()){
                $data = [
                    "session_id" => $this->session->userdata("session_id"),
                    "reg_id" => $this->input->post("reg_id"),
                    "amount" => $this->input->post("amount"),
                    "payment_date" => $this->input->post("payment_date")
                ];

                if($this->work->insert_data("payment", $data)){
                    $response["status"] = 1;
                    $response["alert"] = "Payment Done!";
                    $response["message"] = "Payment Successfully Done.";
                    $response["modal"] = "success";
                }else{
                    $response["status"] = 2;
                    $response["alert"] = "Oops error!";
                    $response["message"] = "Payment Not Done.";
                    $response["modal"] = "error";
                }
            }else{
                $response["status"] = 0;
                $response["amount"] = strip_tags(form_error("amount"));
                $response["payment_date"] = strip_tags(form_error("payment_date"));
            }
        }
		
        echo json_encode($response);
    }
    
    // Custom validation
    // Validation for discount amount
    public function check_discount($amount){
        if($this->input->post("batch_id") != ""){
            $batch_info = $this->work->select_data("batch", ["id"=>$this->input->post("batch_id")]);
            $batch_fee = $batch_info[0]->batch_fee;
            $discount = $batch_info[0]->discount;

            $payble_amount = $batch_fee-$discount;
            
            if($amount == ""){
                return true;
            }elseif($amount < 0){
                $this->form_validation->set_message("check_discount", "Discount amount must be greater than 0");
                return false;
            }elseif($amount > $payble_amount){
                $this->form_validation->set_message("check_discount", "Discount amount must be less than ".$payble_amount);
                return false;
            }else{
                return true;
            }
        }
        
        
    }
    
    public function student_mobile($mob){
        if($mob != ""){
            $query = $this->work->select_data("registration", ["session_id"=>$this->session->userdata("session_id"), "student_mobile"=>$mob]);
            if(!empty($query[0])){
                $this->form_validation->set_message('student_mobile', 'This {field} is already exists');
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }
    
    public function valid_payment_date($str){
        if($this->input->post("payment_amount") != ""){
            if($str != ""){
                //session info
                $session_query = $this->work->select_data("session", ["id"=>$this->session->userdata("session_id")]);
                $end_session = strtotime($session_query[0]->end_session);

                //batch info
                if($this->input->post("batch_id") != ""){
                    $batch_query = $this->work->select_data("batch", ["id"=>$this->input->post("batch_id")]);
                    $batch_start_date = strtotime($batch_query[0]->batch_start_date);

                    $form_date = strtotime($str);
                    if($form_date >= $batch_start_date and $form_date <= $end_session){
                        return TRUE;
                    }else{
                        $this->form_validation->set_message('valid_payment_date', 'The Payment date is not valid');
                        return FALSE;
                    }
                }

            }
        }
    }
    
    // For update the data
    public function student_mobile_update($mob){
        if($mob != ""){
            $query = $this->work->select_data("registration", ["session_id"=>$this->session->userdata("session_id"), "student_mobile"=>$mob, "id !="=>$this->input->post("reg_id")]);
            if(!empty($query[0])){
                $this->form_validation->set_message('student_mobile_update', 'This {field} is already exists');
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }
    
    //Custom validation
    public function valid_payment_date_for_payment($str){
        if($this->input->post("amount") != ""){
            if($str != ""){
                //session info
                $session_query = $this->work->select_data("session", ["id"=>$this->session->userdata("session_id")]);
                $end_session = strtotime($session_query[0]->end_session);
                
                $reg_query = $this->work->select_data("registration", ["id"=>$this->input->post("reg_id")]);
                $batch_id = $reg_query[0]->batch_id;

                //batch info
                $batch_query = $this->work->select_data("batch", ["id"=>$batch_id]);
                $batch_start_date = strtotime($batch_query[0]->batch_start_date);

                $form_date = strtotime($str);
                if($form_date >= $batch_start_date and $form_date <= $end_session){
                    return TRUE;
                }else{
                    $this->form_validation->set_message('valid_payment_date_for_payment', 'The Payment date is not valid');
                    return FALSE;
                }

            }
        }
    }
    
}




?>