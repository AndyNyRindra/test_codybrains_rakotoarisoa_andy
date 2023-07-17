<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');

        $this->load->library('grocery_CRUD');
    }

    public function management()
    {
        try{
            $crud = new grocery_CRUD();

            $crud->set_table('employee');
            $crud->set_subject('Employee');
            $crud->set_relation('gender_id','gender','name');
            $crud->display_as('gender_id','Gender');
            $crud->set_relation('job_id','job','name');
            $crud->display_as('job_id','Job');

            $crud->fields('registration_number','first_name','last_name','email','gender_id','job_id','access_code', 'modification_date');
            $crud->change_field_type('access_code','invisible');
            $crud->change_field_type('registration_number','invisible');
            $crud->change_field_type('modification_date','invisible');

            $crud->unset_edit_fields(array('is_active','access_code','registration_number','hiring_date'));
            $crud->unset_clone();
            $crud->columns('registration_number','first_name','last_name','email','hiring_date','gender_id','job_id','modification_date');
            $crud->where('is_active',1);

            //display boolean with yes or no
            $crud->callback_read_field('is_active',array($this,'_callback_is_active'));
            $crud->callback_before_insert(array($this,'before_insert'));
            $crud->callback_before_update(array($this,'before_update'));
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
            $crud = new grocery_CRUD();

            $crud->set_table('employee');
            $crud->set_subject('Employee Inactive');
            $crud->set_relation('gender_id','gender','name');
            $crud->display_as('gender_id','Gender');
            $crud->set_relation('job_id','job','name');
            $crud->display_as('job_id','Job');
            $crud->add_action('Activate', '', 'employee/activate','ui-icon-plus');

            $crud->unset_clone();
            $crud->unset_add();
            $crud->unset_edit();
            $crud->unset_delete();
            $crud->columns('registration_number','first_name','last_name','email','hiring_date','gender_id','job_id','modification_date');
            $crud->where('is_active',0);

            //display boolean with yes or no
            $crud->callback_read_field('is_active',array($this,'_callback_is_active'));
            $output = $crud->render();

            $this->load->view('grocery.php',(array)$output);

        }catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }

    public function activate($primary_key)
    {
        $this->db->update('employee', array('is_active' => 1), array('id' => $primary_key));
        $this->db->update('employee', array('modification_date' => date('Y-m-d H:i:s')), array('id' => $primary_key));
        redirect('employee/inactive');
    }

    function before_insert($post_array) {

        //generate a random access code with 6 digits
        $post_array['access_code'] = rand(100000, 999999);

        return $post_array;
    }

    function before_update($post_array) {

        $post_array['modification_date'] = date('Y-m-d H:i:s');
        return $post_array;
    }

    function after_insert($post_array, $primary_key) {
        // update the registration number with the concatenation of EMP000... + primary key

        $this->db->update('employee', array('registration_number' => 'EMP' . str_pad($primary_key, 7, '0', STR_PAD_LEFT)), array('id' => $primary_key));
        return true;
    }

    function delete($primary_key) {

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
}