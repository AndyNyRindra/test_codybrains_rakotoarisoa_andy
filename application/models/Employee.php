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

    //find by id
    public function find($id)
    {
        $query = $this->db->get_where('v_employee', array('id' => $id));
        if ($query->num_rows() > 0) {
            return $query->row();
        }
    }

    public function send_mail($id) {
        $employee = $this->find($id);
        $from_email = "testcodybrainsandy@gmail.com";
        $to_email = $employee -> email;

        //Load email library
        $this->load->library('email');

        $this->email->from($from_email, 'Management');
        $this->email->to($to_email);
        $this->email->subject('Employee creation');
        $this->email->message('The employee <b>'. $employee -> first_name. '</b> has been created successfully. Please use the following credentials to login: <ul><li>Registration number: <b>' . $employee -> registration_number . ' </b></li><li> Access code: <b>' . $employee -> access_code . '</b></li></ul><br> Cordially, <br><br> Management');

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset ($_SESSION['employee']) && $_SESSION['employee']->job_id == 0) {
            $this->email->cc($_SESSION['employee']->email);
        }
        //Send mail
        $this->email->send();
    }

}