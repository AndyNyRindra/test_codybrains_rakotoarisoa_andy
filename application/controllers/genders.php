<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class genders extends CI_Controller
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
            $this->load->model('Employee');
            $this->Employee->is_admin();
            $crud = new grocery_CRUD();

            $crud->set_table('gender');
            $crud->set_subject('genders');
            $crud->set_rules('name', 'Name', 'required|alpha_numeric_spaces|max_length[50]', array('required' => 'Please set a name', 'alpha_numeric_spaces' => 'Please set a valid name.', 'max_length' => 'The name is too long.'));
            $crud->unset_clone();
            $crud->unset_read();
            $crud->unset_export();

            $crud->unset_print();

            $output = $crud->render();

            $this->load->view('grocery.php',(array)$output);

        }catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }

}