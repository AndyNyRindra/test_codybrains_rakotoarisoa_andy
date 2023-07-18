<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class employees extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');

        $this->load->library('grocery_CRUD');
        $crud = new grocery_CRUD();

        // Vérifier l'accès aux pages d'ajout, d'édition et de suppression
        $this->check_access($crud);
    }

    private function check_admin () {
        $this->load->model('Employee');
        $this->Employee->is_admin();
    }

    private function check_access($crud)
    {
        // Vérification pour les pages d'ajout, d'édition et de suppression
        $state = $crud->getState();

        if ($state == 'edit' || $state == 'delete') {
            // Vérifiez la connexion et les autorisations avant d'afficher la page
            $this->check_admin();
        }
        if ($state == 'add') {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            // Vérifiez la connexion et les autorisations avant d'afficher la page
            if (isset($_SESSION['employee']) && $_SESSION['employee']->job_id != 0) {
                redirect('employees/signout');
            }
        }
    }

    public function management()
    {
        try{

            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $crud = new grocery_CRUD();

            $crud->set_table('employee');
            $crud->set_subject('Employee');
            $crud->set_relation('gender_id','gender','name');
            $crud->display_as('gender_id','genders');
            $crud->set_relation('job_id','job','name');
            $crud->display_as('job_id','jobs');

            $crud->fields('registration_number','first_name','last_name','email','gender_id','job_id','access_code', 'modification_date');
            $crud->change_field_type('access_code','invisible');
            $crud->change_field_type('registration_number','invisible');
            $crud->change_field_type('modification_date','invisible');

            $crud->unset_edit_fields(array('is_active','access_code','registration_number','hiring_date'));
            $crud->unset_clone();
            $crud->unset_export();
            $crud->unset_print();

            if (!isset($_SESSION['employee']) || $_SESSION['employee']->job_id != 0) {
                $crud->unset_edit();
                $crud->unset_delete();
            }
            if (isset($_SESSION['employee']) && $_SESSION['employee']->job_id != 0) {
                $crud->unset_add();
            }
            $crud->columns('registration_number','first_name','last_name','email','hiring_date','gender_id','job_id','modification_date');
            $crud->where('is_active',1);

            //display boolean with yes or no
            $crud->callback_read_field('is_active',array($this,'_callback_is_active'));
            $crud->callback_before_insert(array($this,'before_insert'));
            $crud->callback_before_update(array($this,'before_update'));
            $crud->callback_before_delete(array($this, 'check_admin'));
            $crud->callback_after_insert(array($this,'after_insert'));
            $crud->callback_delete(array($this,'delete'));
            $output = $crud->render();

            $this->load->view('grocery.php',(array)$output);

        }catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }



    public function inactive()
    {
        try{
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $crud = new grocery_CRUD();

            $crud->set_table('employee');
            $crud->set_subject('Employee Inactive');
            $crud->set_relation('gender_id','gender','name');
            $crud->display_as('gender_id','genders');
            $crud->set_relation('job_id','job','name');
            $crud->display_as('job_id','jobs');

            if (isset($_SESSION['employee']) && $_SESSION['employee']->job_id == 0) {
                $crud->add_action('Activate', '', 'employees/activate','ui-icon-plus');
            }

            $crud->unset_clone();
            $crud->unset_add();
            $crud->unset_edit();
            $crud->unset_delete();
            $crud->unset_export();
            $crud->unset_print();
            $crud->columns('registration_number','first_name','last_name','email','hiring_date','gender_id','job_id','modification_date');
            $crud->where('is_active',0);

            //display boolean with yes or no
            $crud->callback_read_field('is_active',array($this,'_callback_is_active'));
            $output = $crud->render();

            $this->load->view('inactive.php',(array)$output);

        }catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }

    public function activate($primary_key)
    {
        $this->check_admin();
        $this->db->update('employee', array('is_active' => 1), array('id' => $primary_key));
        $this->db->update('employee', array('modification_date' => date('Y-m-d H:i:s')), array('id' => $primary_key));
        redirect('employees/inactive');
    }

    function before_insert($post_array) {

        //generate a random access code with 6 digits
        $post_array['access_code'] = rand(100000, 999999);

        return $post_array;
    }

    function before_update($post_array) {

        $this->check_admin();
        $post_array['modification_date'] = date('Y-m-d H:i:s');
        return $post_array;
    }

    function after_insert($post_array, $primary_key) {
        // update the registration number with the concatenation of EMP000... + primary key

        $this->db->update('employee', array('registration_number' => 'EMP' . str_pad($primary_key, 7, '0', STR_PAD_LEFT)), array('id' => $primary_key));
        $this->load->model('Employee');
        $this->Employee->send_mail($primary_key);
        return true;
    }

    function delete($primary_key) {
        $this->check_admin();
        $this->db->update('employee', array('is_active' => 0), array('id' => $primary_key));
        $this->db->update('employee', array('modification_date' => date('Y-m-d H:i:s')), array('id' => $primary_key));

        return true;
    }

    function _callback_is_active($value, $row)
    {
        if($value == 1)
        {
            return 'Yes';
        }
        else
        {
            return 'No';
        }
    }


    public function signin()
    {
        $data = array();
        $form_data = array();
        $form_data['url'] = 'employees/login';
        $form_data['redirect'] = 'employees/management';
        $form_data['attributes'] = array('id' => 'signin');
        $data['form_data'] = $form_data;
        $this->load->view('signin', $data);
    }

    public function login() {
        $this->form_validation->set_rules('registration_number', 'Registration number', 'required');
        $this->form_validation->set_rules('access_code', 'Access Code', 'required');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(["success" => false, "msg" => "Please try again"]);
        } else {
            $this->load->model('Employee');
            if ($this->Employee->signin()) {
                echo json_encode(["success" => true, "msg" => "Welcome"]);
            } else {
                echo json_encode(["success" => false, "msg" => "Incorrect credentials, please try again"]);
            }
        }
    }

    public function signout()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        redirect('employees/signin');
    }

    public function signup() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        redirect('employees/management/add');
    }

}