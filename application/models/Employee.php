<?php

class Employee extends CI_Model
{

    public function signin()
    {
        session_start();
        $registration_number = $this->input->post('registration_number');
        $access_code = $this->input->post('access_code');
        $query = $this->db->get_where('v_employee', array('registration_number' => $registration_number, 'access_code' => $access_code));
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $_SESSION['employee'] = $row;
            return true;
        } else {
            return false;
        }
    }

    public function is_admin()
    {
        session_start();
        if (isset($_SESSION['employee']) && $_SESSION['employee']->job_id == 0) {
            return;
        } else {
            redirect('employees/signout');
        }
    }

}