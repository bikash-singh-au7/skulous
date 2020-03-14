<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");

class SmsSetup extends CI_Controller {
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
	public function sms($action=null, $subaction=null){
		$this->load->view("header/header.php");
        $this->load->view("sidebar/sidebar.php");
        $this->load->view("header/topmenu.php");
        $this->load->view("sms/send-sms.php");
        $this->load->view("footer/footer.php");
    }
    
   
    //Send Sms
    public function sendSms($action=null){ 
        $action = $this->input->post("action");
        if($action == "inquiry"){
            $table = "inquiry";
            $cond = ["session_id"=>$this->session->userdata("session_id")];
        }elseif($action == "student"){
            $table = "registration";
            $cond = ["session_id"=>$this->session->userdata("session_id")];
        }elseif($action == "batch"){
            $table = "registration";
            $cond = ["session_id"=>$this->session->userdata("session_id"),"batch_id"=>$this->input->post("batch_id")];
        }
        
        $this->form_validation->set_rules("message", "Message", "required|trim");
        $this->form_validation->set_rules("sender", "Sender Id", "trim|exact_length[6]|alpha");
        
        if($this->form_validation->run()){
            $sender = $this->input->post("sender");
            $data = $this->work->select_data($table, $cond);
            if($action=='inquiry'){
                foreach($data as $value){
                    $msg = $this->input->post("message");
                    $mobile_number = $value->student_mobile;
                    $student_name = $value->student_name;
                    $msg = str_replace("@name", $student_name, $msg);
                    if($this->work->send_sms($mobile_number, $msg, $sender)){
                        $status = 1;
                    }else{
                        $status = 0;
                    }
                }
            }else{
                foreach($data as $value){
                    $msg = $this->input->post("message");
                    $mobile_number = $value->student_mobile;
                    $student_name = $value->student_name;
                    $reg_discount = $value->discount;
                    // For dues amount if action is student
                    // Get batch id
                    
                    $batch_id = $value->batch_id;
                    //Batch information
                    $batch_data = $this->work->select_data("batch", ["id"=>$batch_id]);
                    
                    //Batch Fee amount from Batch Table
                    $batch_fee = $batch_data[0]->batch_fee;
                    //Batch Discount amount from Batch Table
                    $batch_discount = $batch_data[0]->discount;
                    
                    //Check full paid or Not
                    $full_paid = $value->full_paid;
                     
                    //Total Payment of particular student
                    $sum_payment = $this->work->select_sum("payment", ["reg_id"=>$value->id], "amount");
                    $total_paid_amount = $sum_payment[0]->amount;
                    
                    //Find Due amount   
                    
                    if($full_paid){
                        $dues_amount = 0;
                    }else{
                        $dues_amount = $batch_fee - ($reg_discount+$batch_discount+$total_paid_amount);
                    }
                   
                    $msg = str_replace("@name", $student_name, $msg);
                    $msg = str_replace("@fee", $dues_amount, $msg);
                    if($this->work->send_sms($mobile_number, $msg, $sender)){
                        $status = 1;
                    }else{
                        $status = 0;
                    }
                }
            }

            if($status){
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
    
    
    
    
    public function smsBal(){
        $data["action"] = "smsBal";
        $html = $this->load->view("sms/print-row.php",$data, true);
        $response["html"] = $html;
        echo json_encode($response);
        
    }
    public function noOfStudent(){
        $action = $this->input->post("action");
        if($action == "student"){
            $response["student"] = $this->work->count_data("registration", ["session_id"=>$this->session->userdata("session_id")], "id");
        }elseif($action == "inquiry"){
            $response["student"] = $this->work->count_data("inquiry", ["session_id"=>$this->session->userdata("session_id")], "id");
        }elseif($action == "batch"){
            $batch_id = $this->input->post("batch_id");
            $response["student"] = $this->work->count_data("registration", ["session_id"=>$this->session->userdata("session_id"), "batch_id"=>$batch_id], "id");
        }
        
        echo json_encode($response);
        
    }
}
?>