<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
    public function __construct() {
		parent::__construct();
		//check login session is set or not
		if(!$this->session->userdata("id") && !$this->session->userdata("display_name") && !$this->session->userdata("type")){
            redirect(base_url("auth"));
		}
		//check session is set or not
		if(!$this->session->userdata("session_id")){
            redirect(base_url("sessionsetup/session/select"));
        }
        $this->load->view("header/header.php");
        $this->load->view("sidebar/sidebar.php");
        $this->load->view("header/topmenu.php");
    }

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */


	//Index Section 
	public function index(){
		$this->load->view("home/home.php");
		$this->load->view("footer/footer.php");
	}

	//Class Section
	public function classes($action=null, $subaction=null){
		if($action == "add"){
			$this->form_validation->set_error_delimiters("<span class='text-danger'>","</span>");
			$this->form_validation->set_rules("class_name","Class Name", "trim|required|is_unique[classes.class_name]");
			$this->form_validation->set_rules("comment","Comment", "trim");

			if($this->form_validation->run()){
				$data = [
					"session_id" => $this->session->userdata("session_id"),	
					"class_name" => $this->input->post("class_name"),	
					"comment" => $this->input->post("comment")
				];
				if($this->work->insert_data("classes", $data)){
					$this->session->set_flashdata("success", "<div class='alert alert-info rounded-0 border'>Class successfully created!</div>");
				}else{
					$this->session->set_flashdata("success", "<div class='alert alert-danger rounded-0 border'><strong>Oops</strong> Class does't created!</div>");
				}
				redirect(base_url("welcome/classes/add"));
			}else{
				$this->load->view("classes/add-class.php");
				$this->load->view("footer/footer.php");
			}
		}elseif($action == "manage"){
			if($subaction == "delete"){
				if(isset($_POST["delSbmt"])){
					if($_POST["class_id"] != ""){
						if($this->work->delete_data("classes", ["id"=>$_POST["class_id"]])){
							$this->session->set_flashdata("success", "<div class='alert alert-info rounded-0 border'><strong>Class</strong> Successfully Deleted!</div>");
						}else{
							$this->session->set_flashdata("success", "<div class='alert alert-danger rounded-0 border'><strong>Opps</strong> Class does't Deleted!</div>");
						}
						redirect(base_url("welcome/classes/manage/"));
					}
				}else{
					redirect(base_url("welcome/classes/manage/"));
				}
			}elseif($subaction == "update"){
				$this->form_validation->set_error_delimiters("<span class='text-danger text-small'>", "</span>");
				$this->form_validation->set_rules("class_id","", "required");
				$this->form_validation->set_rules("class_name","Class Name", "trim|required");
				$this->form_validation->set_rules("comment","Comment", "trim");
				if($this->form_validation->run()){
					$data = [
						"class_name" => $_POST["class_name"],
						"class_status" => $this->input->post("class_status"),
						"comment" => $this->input->post("comment")
					];
					print_r($data);
					echo $this->input->post("class_id");
					if($this->work->update_data("classes", $data, ["id"=>$this->input->post("class_id")])){
						$this->session->set_flashdata("success", "<div class='alert alert-info rounded-0 border'><strong>Successfully</strong> Updated!</div>");
					}else{
						$this->session->set_flashdata("success", "<div class='alert alert-danger rounded-0 border'><strong>Oops</strong> Class does not update!</div>");
					}
					redirect(base_url("welcome/classes/manage"));
	
				}else{
					$this->session->set_flashdata("success", "<div class='alert alert-danger rounded-0 border'><strong>Oops</strong> Enter Correct Data!</div>");
					redirect(base_url("welcome/classes/manage"));
				}
			}
			$data["data"] = $this->work->select_data("classes",["session_id" => $this->session->userdata('session_id')]);
			$this->load->view("classes/manage-class.php", $data);
			$this->load->view("footer/footer.php");
		}
	}

	//Subject Section
	public function subject($action=null, $subaction=null){
		if($action == "add"){
			$this->form_validation->set_error_delimiters("<span class='text-danger'>","</span>");
			$this->form_validation->set_rules("subject_name","Subject Name", "trim|required|is_unique[subject.subject_name]");
			$this->form_validation->set_rules("comment","Comment", "trim");

			if($this->form_validation->run()){
				$data = [
					"session_id" => $this->session->userdata("session_id"),	
					"subject_name" => $this->input->post("subject_name"),	
					"comment" => $this->input->post("comment")
				];
				if($this->work->insert_data("subject", $data)){
					$this->session->set_flashdata("success", "<div class='alert alert-info rounded-0 border'>Subject successfully Added!</div>");
				}else{
					$this->session->set_flashdata("success", "<div class='alert alert-danger rounded-0 border'><strong>Oops</strong> Subject does't Added!</div>");
				}
				if($subaction == "manage"){
					redirect(base_url("welcome/subject/manage"));
				}else{
					redirect(base_url("welcome/subject/add"));
				}
			}else{
				$this->load->view("subject/add-subject.php");
				$this->load->view("footer/footer.php");
			}
		}elseif($action == "manage"){
			if($subaction == "delete"){
				if(isset($_POST["delSbmt"])){
					if(isset($_POST["subject_id"])){
						if($this->work->delete_data("subject", ["id"=>$_POST["subject_id"]])){
							$this->session->set_flashdata("success", "<div class='alert alert-info rounded-0 border'><strong>Subject</strong> Successfully Deleted!</div>");
						}else{
							$this->session->set_flashdata("success", "<div class='alert alert-danger rounded-0 border'><strong>Opps</strong> Subject does't Deleted!</div>");
						}
						redirect(base_url("welcome/subject/manage/"));
					}
				}else{
					redirect(base_url("welcome/subject/manage/"));
				}
			}elseif($subaction == "update"){
				$this->form_validation->set_error_delimiters("<span class='text-danger text-small'>", "</span>");
				$this->form_validation->set_rules("subject_id","", "required");
				$this->form_validation->set_rules("subject_name","Subjact Name", "trim|required");
				$this->form_validation->set_rules("comment","Comment", "trim");
				if($this->form_validation->run()){
					$data = [
						"subject_name" => $_POST["subject_name"],
						"subject_status" => $this->input->post("subject_status"),
						"comment" => $this->input->post("comment")
					];
					
					if($this->work->update_data("subject", $data, ["id"=>$this->input->post("subject_id")])){
						$this->session->set_flashdata("success", "<div class='alert alert-info rounded-0 border'><strong>Successfully</strong> Updated!</div>");
					}else{
						$this->session->set_flashdata("success", "<div class='alert alert-danger rounded-0 border'><strong>Oops</strong> does not update!</div>");
					}
					redirect(base_url("welcome/subject/manage"));
	
				}else{
					$this->session->set_flashdata("success", "<div class='alert alert-danger rounded-0 border'><strong>Oops</strong> Enter Correct Data!</div>");
					redirect(base_url("welcome/subject/manage"));
				}
			}
			$data["data"] = $this->work->select_data("subject",["session_id" => $this->session->userdata('session_id')]);
			$this->load->view("subject/manage-subject.php", $data);
			$this->load->view("footer/footer.php");
		}
	}

	//Batch Section
	public function batch($action=null, $subaction=null){
		if($action == "add"){
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
					$this->session->set_flashdata("success", "<div class='alert alert-info rounded-0 border'>Batch successfully Added!</div>");
				}else{
					$this->session->set_flashdata("success", "<div class='alert alert-danger rounded-0 border'><strong>Oops</strong> Batch does't Added!</div>");
				}
				if($subaction == "manage"){
					redirect(base_url("welcome/batch/manage"));
				}else{
					redirect(base_url("welcome/batch/add"));
				}
			}else{
				$data["classes"] = $this->work->select_data("classes", ["class_status" => 1, "session_id"=>$this->session->userdata('session_id')]);
				$data["subject"] = $this->work->select_data("subject", ["subject_status" => 1, "session_id"=>$this->session->userdata('session_id')]);
				$this->load->view("batch/add-batch.php", $data);
				$this->load->view("footer/footer.php");
			}
		}elseif($action == "manage"){
			if($subaction == "delete"){
				if(isset($_POST["delSbmt"])){
					if(isset($_POST["batch_id"])){
						if($this->work->delete_data("batch", ["id"=>$_POST["batch_id"]])){
							$this->session->set_flashdata("success", "<div class='alert alert-info rounded-0 border'><strong>Batch</strong> Successfully Deleted!</div>");
						}else{
							$this->session->set_flashdata("success", "<div class='alert alert-danger rounded-0 border'><strong>Opps</strong> Batch does't Deleted!</div>");
						}
						redirect(base_url("welcome/batch/manage/"));
					}
				}else{
					redirect(base_url("welcome/batch/manage/"));
				}
			}elseif($subaction == "update"){
				$this->form_validation->set_error_delimiters("<span class='text-danger'>","</span>");
				$this->form_validation->set_rules("batch_name","Batch Name", "trim|required");
				$this->form_validation->set_rules("batch_medium","Batch Medium", "trim|required");
				$this->form_validation->set_rules("batch_seat","Batch Seat", "trim|required");
				$this->form_validation->set_rules("batch_fee","Batch Fee", "trim|required");
				$this->form_validation->set_rules("batch_start_date","Batch Starting Date", "trim|required");
				$this->form_validation->set_rules("batch_start_time","Batch Starting Time", "trim|required");
				$this->form_validation->set_rules("batch_end_time","Batch End Time", "trim|required");
				$this->form_validation->set_rules("batch_status","Batch Status", "trim|required");
				$this->form_validation->set_rules("class_id","Class", "required");
				$this->form_validation->set_rules("subject_id","Subject", "required");
				$this->form_validation->set_rules("batch_id","", "required");
				$this->form_validation->set_rules("comment","Comment", "trim");
				if($this->form_validation->run()){
					$data = [
						"batch_name" => $this->input->post("batch_name"),	
						"batch_medium" => $this->input->post("batch_medium"),
						"batch_seat" => $this->input->post("batch_seat"),	
						"batch_fee" => $this->input->post("batch_fee"),	
						"batch_start_date" => $this->input->post("batch_start_date"),	
						"batch_start_time" => $this->input->post("batch_start_time"),	
						"batch_end_time" => $this->input->post("batch_end_time"),	
						"batch_status" => $this->input->post("batch_status"),	
						"class_id" => $this->input->post("class_id"),	
						"subject_id" => $this->input->post("subject_id"),	
						"comment" => $this->input->post("comment")
					];
					
					if($this->work->update_data("batch", $data, ["id"=>$this->input->post("batch_id")])){
						$this->session->set_flashdata("success", "<div class='alert alert-info rounded-0 border'><strong>Successfully</strong> Updated!</div>");
					}else{
						$this->session->set_flashdata("success", "<div class='alert alert-danger rounded-0 border'><strong>Oops</strong> does not update!</div>");
					}
					redirect(base_url("welcome/batch/manage"));
	
				}else{
					$this->session->set_flashdata("success", "<div class='alert alert-danger rounded-0 border'><strong>Oops</strong> Enter Correct Data!</div>");
					redirect(base_url("welcome/batch/manage"));
				}
			}

			$data["classes"] = $this->work->select_data("classes", ["class_status" => 1, "session_id"=>$this->session->userdata('session_id')]);
			$data["subject"] = $this->work->select_data("subject", ["subject_status" => 1, "session_id"=>$this->session->userdata('session_id')]);
			$data["data"] = $this->work->select_data("batch",["session_id" => $this->session->userdata('session_id')]);
			$this->load->view("batch/manage-batch.php", $data);
			$this->load->view("footer/footer.php");
		}
	}

	//Staff Section
	public function staff($action=null, $subaction=null){
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

				//for image uploading
				$path = "./assets/images/staff/";
				$file_name = "profile_pic";
				$name = "";
				if(!empty($_FILES["profile_pic"]["name"])){
					$upload = $this->work->do_upload($path, $file_name);
					if(!$upload){
						$error = array('error' => $this->upload->display_errors("<span class='text-danger'>", "</span>"));
						$this->load->view("staff/add-staff.php", $error);
						$this->load->view("footer/footer.php");
						$flag = 0;
					}else {
						$flag = 1;
						$name = $this->upload->data('file_name');
					}
				}else {
					$flag = 1;
				}
				$data = [
					"first_name" => $this->input->post("first_name"),	
					"middle_name" => $this->input->post("middle_name"),	
					"last_name" => $this->input->post("last_name"),	
					"gender" => $this->input->post("gender"),	
					"mobile_number" => $this->input->post("mobile_number"),	
					"email" => $this->input->post("email"),	
					"profile_pic" => $name,	
					"address" => $this->input->post("address")
				];
				

				if($flag){
					if($this->work->insert_data("staff", $data)){
						$this->session->set_flashdata("success", "<div class='alert alert-info rounded-0 border'>Staff successfully Added!</div>");
					}else{
						$this->session->set_flashdata("success", "<div class='alert alert-danger rounded-0 border'><strong>Oops</strong> Staff does't Added!</div>");
					}
					if($subaction == "manage"){
						redirect(base_url("welcome/staff/manage"));
					}else{
						redirect(base_url("welcome/staff/add"));
					}
				}
			}else{
				$error = ["error"=>""];
				$this->load->view("staff/add-staff.php",$error);
				$this->load->view("footer/footer.php");
			}
		}elseif($action == "manage"){
			if($subaction == "delete"){
				if(isset($_POST["delSbmt"])){
					if(isset($_POST["batch_id"])){
						if($this->work->delete_data("batch", ["id"=>$_POST["batch_id"]])){
							$this->session->set_flashdata("success", "<div class='alert alert-info rounded-0 border'><strong>Batch</strong> Successfully Deleted!</div>");
						}else{
							$this->session->set_flashdata("success", "<div class='alert alert-danger rounded-0 border'><strong>Opps</strong> Batch does't Deleted!</div>");
						}
						redirect(base_url("welcome/batch/manage/"));
					}
				}else{
					redirect(base_url("welcome/batch/manage/"));
				}
			}elseif($subaction == "update"){
				$this->form_validation->set_error_delimiters("<span class='text-danger'>","</span>");
				$this->form_validation->set_rules("batch_name","Batch Name", "trim|required");
				$this->form_validation->set_rules("batch_medium","Batch Medium", "trim|required");
				$this->form_validation->set_rules("batch_start_date","Batch Starting Date", "trim|required");
				$this->form_validation->set_rules("batch_start_time","Batch Starting Date", "trim|required");
				$this->form_validation->set_rules("batch_end_time","Batch Starting Date", "trim|required");
				$this->form_validation->set_rules("class_id","Class", "required");
				$this->form_validation->set_rules("subject_id","Subject", "required");
				$this->form_validation->set_rules("batch_id","", "required");
				$this->form_validation->set_rules("comment","Comment", "trim");
				if($this->form_validation->run()){
					$data = [
						"batch_name" => $this->input->post("batch_name"),	
						"batch_medium" => $this->input->post("batch_medium"),	
						"batch_start_date" => $this->input->post("batch_start_date"),	
						"batch_start_time" => $this->input->post("batch_start_time"),	
						"batch_end_time" => $this->input->post("batch_end_time"),	
						"class_id" => $this->input->post("class_id"),	
						"subject_id" => $this->input->post("subject_id"),	
						"comment" => $this->input->post("comment")
					];
					
					if($this->work->update_data("batch", $data, ["id"=>$this->input->post("batch_id")])){
						$this->session->set_flashdata("success", "<div class='alert alert-info rounded-0 border'><strong>Successfully</strong> Updated!</div>");
					}else{
						$this->session->set_flashdata("success", "<div class='alert alert-danger rounded-0 border'><strong>Oops</strong> does not update!</div>");
					}
					redirect(base_url("welcome/batch/manage"));
	
				}else{
					$this->session->set_flashdata("success", "<div class='alert alert-danger rounded-0 border'><strong>Oops</strong> Enter Correct Data!</div>");
					redirect(base_url("welcome/batch/manage"));
				}
			}

			$data["data"] = $this->work->select_data("staff");
			$this->load->view("staff/manage-staff.php", $data);
			$this->load->view("footer/footer.php");
		}
	}

	//Registration Section
	//Staff Section
	public function registration($action=null, $subaction=null){
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

				//for image uploading
				$path = "./assets/images/staff/";
				$file_name = "profile_pic";
				$name = "";
				if(!empty($_FILES["profile_pic"]["name"])){
					$upload = $this->work->do_upload($path, $file_name);
					if(!$upload){
						$error = array('error' => $this->upload->display_errors("<span class='text-danger'>", "</span>"));
						$this->load->view("staff/add-staff.php", $error);
						$this->load->view("footer/footer.php");
						$flag = 0;
					}else {
						$flag = 1;
						$name = $this->upload->data('file_name');
					}
				}else {
					$flag = 1;
				}
				$data = [
					"first_name" => $this->input->post("first_name"),	
					"middle_name" => $this->input->post("middle_name"),	
					"last_name" => $this->input->post("last_name"),	
					"gender" => $this->input->post("gender"),	
					"mobile_number" => $this->input->post("mobile_number"),	
					"email" => $this->input->post("email"),	
					"profile_pic" => $name,	
					"address" => $this->input->post("address")
				];
				

				if($flag){
					if($this->work->insert_data("staff", $data)){
						$this->session->set_flashdata("success", "<div class='alert alert-info rounded-0 border'>Staff successfully Added!</div>");
					}else{
						$this->session->set_flashdata("success", "<div class='alert alert-danger rounded-0 border'><strong>Oops</strong> Staff does't Added!</div>");
					}
					if($subaction == "manage"){
						redirect(base_url("welcome/staff/manage"));
					}else{
						redirect(base_url("welcome/staff/add"));
					}
				}
			}else{
				$error = ["error"=>""];
				$this->load->view("registration/add-registration.php",$error);
				$this->load->view("footer/footer.php");
			}
		}elseif($action == "manage"){
			if($subaction == "delete"){
				if(isset($_POST["delSbmt"])){
					if(isset($_POST["batch_id"])){
						if($this->work->delete_data("batch", ["id"=>$_POST["batch_id"]])){
							$this->session->set_flashdata("success", "<div class='alert alert-info rounded-0 border'><strong>Batch</strong> Successfully Deleted!</div>");
						}else{
							$this->session->set_flashdata("success", "<div class='alert alert-danger rounded-0 border'><strong>Opps</strong> Batch does't Deleted!</div>");
						}
						redirect(base_url("welcome/batch/manage/"));
					}
				}else{
					redirect(base_url("welcome/batch/manage/"));
				}
			}elseif($subaction == "update"){
				$this->form_validation->set_error_delimiters("<span class='text-danger'>","</span>");
				$this->form_validation->set_rules("batch_name","Batch Name", "trim|required");
				$this->form_validation->set_rules("batch_medium","Batch Medium", "trim|required");
				$this->form_validation->set_rules("batch_start_date","Batch Starting Date", "trim|required");
				$this->form_validation->set_rules("batch_start_time","Batch Starting Date", "trim|required");
				$this->form_validation->set_rules("batch_end_time","Batch Starting Date", "trim|required");
				$this->form_validation->set_rules("class_id","Class", "required");
				$this->form_validation->set_rules("subject_id","Subject", "required");
				$this->form_validation->set_rules("batch_id","", "required");
				$this->form_validation->set_rules("comment","Comment", "trim");
				if($this->form_validation->run()){
					$data = [
						"batch_name" => $this->input->post("batch_name"),	
						"batch_medium" => $this->input->post("batch_medium"),	
						"batch_start_date" => $this->input->post("batch_start_date"),	
						"batch_start_time" => $this->input->post("batch_start_time"),	
						"batch_end_time" => $this->input->post("batch_end_time"),	
						"class_id" => $this->input->post("class_id"),	
						"subject_id" => $this->input->post("subject_id"),	
						"comment" => $this->input->post("comment")
					];
					
					if($this->work->update_data("batch", $data, ["id"=>$this->input->post("batch_id")])){
						$this->session->set_flashdata("success", "<div class='alert alert-info rounded-0 border'><strong>Successfully</strong> Updated!</div>");
					}else{
						$this->session->set_flashdata("success", "<div class='alert alert-danger rounded-0 border'><strong>Oops</strong> does not update!</div>");
					}
					redirect(base_url("welcome/batch/manage"));
	
				}else{
					$this->session->set_flashdata("success", "<div class='alert alert-danger rounded-0 border'><strong>Oops</strong> Enter Correct Data!</div>");
					redirect(base_url("welcome/batch/manage"));
				}
			}

			$data["data"] = $this->work->select_data("staff");
			$this->load->view("staff/manage-staff.php", $data);
			$this->load->view("footer/footer.php");
		}
	}

	//Logout Section
	public function logout(){
		$this->session->unset_userdata("id");
		$this->session->unset_userdata("display_name");
		$this->session->unset_userdata("session_id");
		redirect(base_url("auth"));
	}
    
    
	//Logout Section
	public function staffLogout(){
		$this->session->unset_userdata("id");
		$this->session->unset_userdata("display_name");
		$this->session->unset_userdata("session_id");
		redirect(base_url("staffauth"));
	}
	
}
