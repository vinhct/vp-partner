<?php
Class Useragent_model extends MY_Model
{
    var $table = 'useragent';
    function  get_info_admin($username){

        $this->db->where('username',$username);
        $query = $this->db->get($this->table);
        if($query->result())
        {
            return $query->result();
        }else{
            return FALSE;
        }
    }

    function  get_info_admin_nickname($username){

        $this->db->where('nickname',$username);
        $query = $this->db->get($this->table);
        if($query->result())
        {
            return $query->result();
        }else{
            return FALSE;
        }
    }

   function get_max_id(){
    $this->db->select_max('id');
    $query = $this->db->get($this->table)->row();
    return $query->id;
   }
}