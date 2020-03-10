<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");

class PaymentSetup extends CI_Controller {
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
	public function payment($action=null, $subaction=null){
		if($action == "add"){
            $this->load->view("header/header.php");
            $this->load->view("sidebar/sidebar.php");
            $this->load->view("header/topmenu.php");
			$this->load->view("payment/add-payment.php");
			$this->load->view("footer/footer.php");
		}elseif($action == "manage"){
            $data["data"] = $this->work->select_destnict_data("payment", ["session_id"=>$this->session->userdata('session_id')], "reg_id");
            $this->load->view("header/header.php");
            $this->load->view("sidebar/sidebar.php");
            $this->load->view("header/topmenu.php");
			$this->load->view("payment/manage-payment.php", $data);
			$this->load->view("footer/footer.php");
		}elseif($action == 'report'){
            $data["action"] = "";
            
            $data["data"] = $this->work->select_destnict_data("payment", ["session_id"=>$this->session->userdata('session_id')], "reg_id");
            $data["batch"] = $this->work->select_data("batch", ["session_id"=>$this->session->userdata("session_id")]);
            
            if($subaction == "generate"){
                $batch_id = $this->input->post("batch_id");
                $amount = $this->input->post("amount");
                $date = $this->input->post("date");
                if($batch_id == "" && $date == "" && $amount == ""){
                    $data["data"] = $this->work->select_destnict_data("payment", ["session_id"=>$this->session->userdata('session_id')], "reg_id");
                }else{

                    //for batch
                    if($batch_id != "" && $date =="" && $amount == ""){
                        $cond = [
                            "registration.session_id"=>$this->session->userdata("session_id"),
                            "registration.batch_id"=>$batch_id
                        ];
                        
                        $data["data"] = $this->work->select_join($cond);
                    }
                    //for date
                    if($batch_id == "" && $date !="" && $amount == ""){
                        
                        $cond = [
                            "registration.session_id"=>$this->session->userdata("session_id"),
                            "payment.payment_date"=>$date
                        ];
                        
//                        $cond["Date(created_date)"]=$date;
                        $data["data"] = $this->work->select_join($cond);
                        $data["action"] = "date";
                    }

                    if($batch_id == "" && $date =="" && $amount != ""){
                        if($amount == "fullpaid"){
                            $cond = [
                                "registration.session_id"=>$this->session->userdata("session_id"),
                                "registration.full_paid"=>1
                            ];
                            $data["data"] = $this->work->select_join($cond);
                        }elseif($amount == "unpaid"){
                            $cond = [
                                "registration.session_id"=>$this->session->userdata("session_id"),
                            ];
                            
                            $r = [];
                            $p = $this->work->select_data("registration", $cond);
                            foreach($p as $pp){
                                $id = $pp->id;
                                $q = $this->work->select_data("payment", ["reg_id"=>$id]);
                                if(empty($q[0])){
                                    $r[] = $pp;
                                }
                            }
                            
                            $data["data"] = $r;
                            $data["action"] = "unpaid";
                            
                        }
                    }
                    
                    if($batch_id != "" && $amount != ""){
                        if($amount == "fullpaid"){
                            $cond = [
                                "registration.session_id"=>$this->session->userdata("session_id"),
                                "registration.batch_id"=>$batch_id,
                                "registration.full_paid"=>1,
                            ];
                            $data["data"] = $this->work->select_join($cond);
                        }elseif($amount == "unpaid"){
                            $cond = [
                                "registration.session_id"=>$this->session->userdata("session_id"),
                                "registration.batch_id"=>$batch_id,
                            ];
                            
                            $r = [];
                            $p = $this->work->select_data("registration", $cond);
                            foreach($p as $pp){
                                $id = $pp->id;
                                $q = $this->work->select_data("payment", ["reg_id"=>$id]);
                                if(empty($q[0])){
                                    $r[] = $pp;
                                }
                            }
                            
                            $data["data"] = $r;
                            $data["action"] = "unpaid";
                            
                        }
                    }
                    
                    if($batch_id != "" && $date != ""){
                         $cond = [
                            "registration.session_id"=>$this->session->userdata("session_id"),
                            "registration.batch_id"=>$batch_id,
                            "payment.payment_date"=>$date
                        ];
                        
                        $data["data"] = $this->work->select_join($cond);
                        $data["action"] = "date";
                    }
                }
                $this->load->view("header/header.php");
                $this->load->view("sidebar/sidebar.php");
                $this->load->view("header/topmenu.php");
                $this->load->view("payment/report.php", $data);
                $this->load->view("footer/footer.php");
                
            }else{
                $this->load->view("header/header.php");
                $this->load->view("sidebar/sidebar.php");
                $this->load->view("header/topmenu.php");
                $this->load->view("payment/report.php", $data);
                $this->load->view("footer/footer.php");
            }
        }
    }
    
    //make Payment
    public function makePayment($action = null){
        if($action == "manage"){
            $this->form_validation->set_rules("amount", "Amount", "required|trim|numeric|is_natural");
            $this->form_validation->set_rules("payment_date", "Payment Date", "required|trim|callback_valid_payment_date");
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
                    $data["data"] = $this->work->select_data("registration", ["id"=>$this->input->post("reg_id")]);
                    $data["action"] = "manage-update";
                    $html = $this->load->view("payment/print-row.php",$data, true);
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
            $this->form_validation->set_rules("payment_date", "Payment Date", "required|trim|callback_valid_payment_date");
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
                    $data["result"] = $this->work->select_data("registration", ["id"=>$this->input->post("reg_id")]);
                    $data["action"] = "update-row-after-pay";
                    $html = $this->load->view("payment/print-row.php",$data, true);
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
        }
		
        echo json_encode($response);
    }
    
    //search Data
    public function searchData($action = null){
//		if($action == "add"){
			$this->form_validation->set_rules("search","Search", "trim|required");
			if($this->form_validation->run()){
                $cond = [
                    "student_name" => $_POST["search"],
                    "father_name" => $_POST["search"],
                    "dob" => $_POST["search"],
                    "student_mobile"=>$_POST["search"],
                    "student_email"=>$_POST["search"]
                ];
				$data["result"] = $this->work->search_data("registration", ["session_id"=>$this->session->userdata("session_id")] ,$cond);
                $data["action"] = "search";
                
                $html = $this->load->view("payment/print-row.php", $data, true);
                $response["html"] = $html;
                $response["status"] = 1;
			}else{
				$response["search"] = strip_tags(form_error('search'));
				$response['status'] = 0;
			}
			echo json_encode($response);
//		}
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
    
    //Payment Info
    public function viewInfo(){
        $id = $this->input->post("reg_id");
        $data["action"] = "show_payment";
        $data["data"] = $this->work->select_data("payment", ['reg_id'=>$id]);
        $html = $this->load->view("payment/print-row", $data, true);
        $response["html"] = $html;
        $response["status"] = 11;
        echo json_encode($response);
    }
    
    //Delete Single-Single Payment
	public function deleteSinglePayment(){
		$id = $this->input->post("payment_id");
        $pay_info = $this->work->select_data('payment', ["id"=>$id]);
        $reg_id = $pay_info[0]->reg_id;

        //Now deleted amount
        $deletable_amount = $pay_info[0]->amount;

        //get discount from registration if available
        $reg_info = $this->work->select_data("registration", ["id"=>$reg_id]);
        $reg_discount = $reg_info[0]->discount;
        $full_paid = $reg_info[0]->full_paid;
        $batch_id = $reg_info[0]->batch_id;


        //get batch fee and batch discount if available
        $batch_info = $this->work->select_data("batch", ["id"=>$batch_id]);
        $batch_fee = $batch_info[0]->batch_fee;
        $batch_discount = $batch_info[0]->discount;


        //get total payment of this student
        $pay_info = $this->work->select_sum("payment", ["reg_id"=>$reg_id], "amount");
        $total_amount = $pay_info[0]->amount;

        //Total would after delete
        $total_after_deleted = $total_amount-$deletable_amount;


        $total_payble = $batch_fee-($batch_discount+$reg_discount);

        if($total_after_deleted >= $total_payble){
            $full_paid = 1;
        }else{
            $full_paid = 0;
        }

            
        
		if($this->work->delete_data("payment", ["id"=>$id])){
			$response["rowId"] = "pay".$id;
			$response["alert"] = "Data deleted!";
			$response["message"] = "Payment deleted successfully !!";
            $response["modal"] = "success";
            
            //update registration table if full paid
            if($full_paid == 0){
                if($this->work->update_data("registration", ["full_paid"=>0], ["id"=>$reg_id])){
                    $response["full_paid"] = 1;
                }else{
                    $response["full_paid"] = 0;
                }
            }
            
            //Update the Payment Row
            $response["number"] = "one";
            $response["rowId"] = "row-".$reg_id;
            $data["data"] = $this->work->select_data("registration", ["id"=>$reg_id]);
            $data["action"] = "manage-update";
            $html = $this->load->view("payment/print-row.php",$data, true);
            $response["html"] = $html;
            
            
		}else{
            $response["alert"] = "Not deleted!";
			$response["message"] = "Data does't Deleted.";
            $response["modal"] = "error";
		}
		echo json_encode($response);
	}

    //Delete All Payment of Particular Student
	public function deleteAllPayment(){
        //Payment_id name is present in delete modal. For reg_id
		$reg_id = $this->input->post("payment_id");
		if($this->work->delete_data("payment", ["reg_id"=>$reg_id])){
			$response["rowId"] = "row-".$reg_id;
			$response["alert"] = "Data deleted!</div>";
			$response["message"] = "Payment deleted successfully !!";
			$response["modal"] = "success";
            
            //update registration table if delete amount
            if($this->work->update_data("registration", ["full_paid"=>0], ["id"=>$reg_id])){
                $response["full_paid"] = 0;
            }else{
                $response["full_paid"] = 1;
            }
            
            
		}else{
            $response["alert"] = "Not deleted!</div>";
			$response["message"] = "Data does't Deleted.";
            $response["modal"] = "error";
		}
		echo json_encode($response);
	}

    
    //Send Sms
    public function sendsms(){
        $this->form_validation->set_rules("message", "Message", "required|trim");
        $this->form_validation->set_rules("sender", "Sender Id", "trim|exact_length[6]|alpha");
        $this->form_validation->set_rules("reg_id", "Registratio Id", "required");
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
                $response["modal"] = "success";
            }else{
                $response["status"] = 2;
                $response["alert"] = "SMS not send !";
                $response["message"] = "Oops error occured.";
                $response["modal"] = "error";
            }
        }else{
            $response["status"] = 0;
            $response["message"] = strip_tags(form_error("message"));
            $response["sender"] = strip_tags(form_error("sender"));
            $response["reg_id"] = strip_tags(form_error("reg_id"));
        }
        echo json_encode($response);
        
    }
    
    //Custom validation
    public function valid_payment_date($str){
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
                    $this->form_validation->set_message('valid_payment_date', 'The Payment date is not valid');
                    return FALSE;
                }

            }
        }
    }

}




?>