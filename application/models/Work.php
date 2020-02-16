<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Work extends CI_Model{
    public function login($table = null, $data = null){
        $val = $this->db->where($data)
                        ->get($table);
        return $val;               
    }
    public function insert_data($table, $data){
        $val = $this->db->insert($table, $data);
        return $val;
    }
    public function select_data($table, $cond=null){
        if($cond == null){
            $data = $this->db->get($table);
        }else{
            $data = $this->db->where($cond)
                            ->get($table);
        }
        return $data->result();
        
    }
    public function delete_data($table, $cond=null){
        //$data = $this->db->get($table)
        if($cond != null){
            return $this->db->delete($table, $cond);
        }else{
            return $this->db->delete($table);
        }
    }
    public function update_data($table, $data, $cond=null){
            return $this->db->update($table,$data,$cond);
    }

    public function do_upload($path, $file_name ,$img_name=null){
        $config['upload_path']          = $path;
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 1000;
        $config['max_width']            = 1200;
        $config['max_height']           = 700;
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload($file_name))
            {
                return false;
            }else{
                return true;
            }
        }
    
}
?>