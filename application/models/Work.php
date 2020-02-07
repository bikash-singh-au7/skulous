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
        if($cond != null){
            return $this->db->delete($table, $cond);
        }else{
            return $this->db->delete($table);
        }
    }
    public function update_data($table, $data, $cond=null){
            return $this->db->update($table,$data,$cond);
    }
    
}
?>