<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AdminSetup extends CI_Controller{
    public function __construct() {
		parent::__construct();
		//check login session is set or not
		if(!$this->session->userdata("id") && !$this->session->userdata("display_name")){
            redirect(base_url("auth"));
		}
        
        if($this->session->userdata("type") != "admin"){
            redirect(base_url("auth"));
        }
		//check session is set or not
		if(!$this->session->userdata("session_id")){
            redirect(base_url("sessionsetup/session/select"));
        }
        
    }
    
    //Inquiry Navigation
	public function profile($action=null){
        $data["data"] = $this->work->select_data("admin");
		$this->load->view("header/header.php");
        $this->load->view("sidebar/sidebar.php");
        $this->load->view("header/topmenu.php");
		$this->load->view("admin-profile/profile.php", $data);
		$this->load->view("footer/footer.php");
    } 
    
    //Add format
    public function addData($action=null){
        $this->form_validation->set_rules("format_string", "Format String", "trim|required");
        
        if($this->form_validation->run()){
            $data = [
                "session_id" => $this->session->userdata("session_id"),
                "format_string" => $this->input->post("format_string")
            ];

            if($this->work->insert_data("reg_format", $data)){
                $data["action"] = "add";
                $last_insert_id = $this->db->insert_id();
                $data["data"] = $this->work->select_data("reg_format", ["id"=>$last_insert_id]);
                $response["html"] = $this->load->view("admin-profile/print-row.php", $data, true);
                
                
                $response["status"] = 1;
                $response["alert"] = "Format Added!";
                $response["message"] = "Format Successfully Done.";
                $response["modal"] = "success";
            }else{
                $response["status"] = 1;
                $response["alert"] = "Oops Error!";
                $response["message"] = "Format not added.";
                $response["modal"] = "error";
            }
            
        }else{
            $response["status"] = 0;
            $response["format_string"] = strip_tags(form_error("format_string"));
        }
        echo json_encode($response);
    }
    
    
    public function setting($action=null){
        if($action == "update"){
            $this->form_validation->set_rules("admin_id", "Admin id", "required");
            $this->form_validation->set_rules("old_password", "Old Password", "required|trim|callback_old_is_match");
            $this->form_validation->set_rules("new_password", "New Password", "required|trim");
            $this->form_validation->set_rules("confirm_password", "Confirm Password", "required|trim|matches[new_password]");

            if($this->form_validation->run()){
                $reg_id = $this->session->userdata("id");
                if($this->work->update_data("admin", ['password'=>md5($this->input->post("confirm_password"))], ["id"=>$this->input->post("admin_id")])){
                    $response['alert'] = "Updated!!";
                    $response['message'] = "Password Updated successfully!!";
                    $response['modal'] = "success";
                }else{
                    $response['alert'] = "Oops error!!";
                    $response['message'] = "Password does't updated!!";
                    $response['modal'] = "error";
                }
            }else{
                $response['status'] = 0;
                $response["old_password"] = strip_tags(form_error("old_password"));
                $response["new_password"] = strip_tags(form_error("new_password"));
                $response["confirm_password"] = strip_tags(form_error("confirm_password"));
            }
            echo json_encode($response);
        }else{
            $data["data"] = $this->work->select_data("reg_format", ["session_id"=>$this->session->userdata("session_id")]);
            $this->load->view("header/header.php");
            $this->load->view("sidebar/sidebar.php");
            $this->load->view("header/topmenu.php");
            $this->load->view("admin-profile/setting.php", $data);
            $this->load->view("footer/footer.php");
            }
    }
    
    
    public function getData($action=null){
        $id = $this->input->post("id");
        if($id != ""){
            $data = $this->work->select_data("admin", ["id"=>$id]);
            $response["admin_name"] = $data[0]->admin_name;
            $response["institute_name"] = $data[0]->institute_name;
            $response["institute_code"] = $data[0]->institute_code;
            $response["admin_mobile"] = $data[0]->admin_mobile;
            $response["admin_email"] = $data[0]->admin_email;
            $response["user_name"] = $data[0]->user_name;
            $response["status"] = 1;
        }else{
            $response["status"] = 0;
        }
        echo json_encode($response);
    } 
    
    public function getFormatString($action=null){
        $id = $this->input->post("format_id");
        if($id != ""){
            $data = $this->work->select_data("reg_format", ["id"=>$id]);
            $response["format_string"] = $data[0]->format_string;
            $response["format_status"] = $data[0]->status;
            $response["status"] = 1;
        }else{
            $response["status"] = 0;
        }
        echo json_encode($response);
    }
    
    public function updateFormat($action=null){
        $this->form_validation->set_rules("id","Id", "required");
        $this->form_validation->set_rules("format_string","Format", "required|trim");
        $this->form_validation->set_rules("status","Status", "required");
        
        if($this->form_validation->run()){
            $data = [	
                "format_string" => $this->input->post("format_string"),
                "status" => $this->input->post("status")
            ];
            if($this->work->update_data("reg_format", $data, ["id"=>$this->input->post("id")])){
                $response["rowId"] = "#row-".$this->input->post("id");
                $data["action"] = "update";
                $data["data"] = $this->work->select_data("reg_format", ["id"=>$this->input->post("id")]);
                $response["html"] = $this->load->view("admin-profile/print-row.php", $data, true);
                
                $response["alert"] = "Update!!";
                $response["message"] = "Format Successfully Updated";
                $response["modal"] = "success";
                $response["status"] = 1;
                //
            }else{
                $response["alert"] = "Oops Error!!";
                $response["message"] = "Data Not Updated";
                $response["modal"] = "error";
                $response["status"] = 2;
            }
        }else{
            $response["id"] = strip_tags(form_error('id'));
            $response["format_string"] = strip_tags(form_error('format_string'));
            $response["status"] = strip_tags(form_error('status'));
            $response['status'] = 0;
        }
        echo json_encode($response);
    }
 
    public function deleteFormatString($action=null){
        $id = $this->input->post("id");
		if($this->work->delete_data("reg_format", ["id"=>$id])){
			$response["rowId"] = "#row-".$id;
			$response["alert"] = "Deleted !!";
            $response["message"] = "Format successfully deleted.";
            $response["modal"] = "success";
		}else{
			$response["alert"] = "Oops error !!";
            $response["message"] = "Format does't deleted.";
            $response["modal"] = "error";
		}
		echo json_encode($response);
    }
    public function updateData($action=null){
        $this->form_validation->set_rules("id","Id", "required");
        $this->form_validation->set_rules("admin_name","Name", "required|trim");
        $this->form_validation->set_rules("institute_name","Institute Name", "required|trim");
        $this->form_validation->set_rules("institute_code","Institute Code", "required|trim");
        $this->form_validation->set_rules("admin_mobile","Name", "required|exact_length[10]|numeric");
        $this->form_validation->set_rules("admin_email","Email", "required|valid_email");
        $this->form_validation->set_rules("user_name","User Name", "required|trim");
        
        if($this->form_validation->run()){
            $data = [	
                "admin_name" => $this->input->post("admin_name"),
                "institute_name" => $this->input->post("institute_name"),
                "institute_code" => $this->input->post("institute_code"),
                "admin_mobile" => $this->input->post("admin_mobile"),
                "admin_email" => $this->input->post("admin_email"),
                "user_name" => $this->input->post("user_name"),
            ];
            if($this->work->update_data("admin", $data, ["id"=>$this->input->post("id")])){
                $this->session->set_flashdata("success", "<div class='alert alert-success rounded-0 border'>Profile successfully updated !!</div>");
                $response["status"] = 1;
                $response["redirect"] = base_url("adminSetup/profile");
                //
            }else{
                $response["alert"] = "Oops Error!!";
                $response["message"] = "Data Not Updated";
                $response["modal"] = "error";
                $response["status"] = 2;
            }
        }else{
            $response["id"] = strip_tags(form_error('id'));
            $response["admin_name"] = strip_tags(form_error('admin_name'));
            $response["institute_name"] = strip_tags(form_error('institute_name'));
            $response["institute_code"] = strip_tags(form_error('institute_code'));
            $response["admin_mobile"] = strip_tags(form_error('admin_mobile'));
            $response["admin_email"] = strip_tags(form_error('admin_email'));
            $response["user_name"] = strip_tags(form_error('user_name'));
            $response['status'] = 0;
        }
        echo json_encode($response);
    }
 
    
    //Old password is matched or not
	public function old_is_match($pwd){
        $data = $this->work->select_data("admin", ["id"=>$this->input->post("admin_id")]);
        $old_password = $data[0]->password;
        if($pwd == ""){
            return true;
        }else{
            if(md5($pwd) === $old_password){
                return TRUE;
            }else{
                $this->form_validation->set_message('old_is_match', 'Old Password is not matched');
                return FALSE;
            }
        }
    }
}
?>