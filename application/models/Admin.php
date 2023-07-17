<?php

class Admin extends CI_Model
{
    public $name;
    public $email;
    public $password;

    public function signin()
    {
        session_start();
        $this->email = $this->input->post('email');
        $this->password = md5($this->input->post('password'));
        $query = $this->db->get_where('admins', array('email' => $this->email, 'password' => $this->password));
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $_SESSION['admin_id'] = $row->id;
            return true;
        } else {
            return false;
        }
    }
}