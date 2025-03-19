<?php
class User_model extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function add_user($data){
        $this->db->insert('users', $data);
        return $this->db->insert_id();  // return inserted user id
    }

    public function get_user($id){
        $this->db->where('id', $id);
        return $this->db->get('users')->row();
    }
}
?>