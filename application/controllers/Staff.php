<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller {

	public function __construct()
    {
        parent:: __construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('session');

        $this->load->library('grocery_CRUD');
    }

    public function staff_output($output = null)
    {
        $this->load->helper('form');

        $data['output'] = $output;
        $data['main_content'] = 'site/staff_view';
        $data['user'] = $this->session->userdata('username');
        $data['al'] = $this->session->userdata('al');
        $this->load->view('includes/template', $data);
    }

	// Staff table is called frome here
    public function staff()
    {
        // Loading view home page views, Grocery CRUD Standard Library

        $crud = new grocery_CRUD();

        $crud->set_theme('flexigrid');

        //table name exact from database
        $crud->set_table('staff');
        	        //give focus on name used for operations e.g. Add Order, Delete Order
        $crud->set_subject('Staff');
        $crud->columns('staffNo', 'fName', 'lName', 'staffLogin', 'staffPassword', 'accessLevel');
        	        //change column heading name for readability ('columm name', 'name to display in frontend column header')
        $crud->display_as('staffNo', 'STAFF NO.')
            ->display_as('fName', 'First Name')
            ->display_as('lName', 'Last Name')
            ->display_as('staffLogin', 'Username')
            ->display_as('staffPassword', 'Password')
            ->display_as('sPosition', 'Staff Position')
            ->display_as('enabled', 'Delete');

        $crud->field_type('enabled', 'dropdown', array('N' => 'Yes', 'Y' => 'No'));

        $crud->fields('staffNo', 'fName', 'lName', 'staffLogin', 'staffPassword', 'accessLevel', 'enabled');

        //form validation (could match database columns set to "not null")
        $crud->required_fields('staffNo', 'fName', 'lName', 'enabled', 'staffLogin', 'staffPassword', 'accessLevel');

        $crud->field_type('accessLevel', 'dropdown', array('1' => 'Manager/HR', '2' => 'Marketing', '3' => 'Therapist'));

        $crud->unique_fields(array('staffNo','fName', 'lName', 'staffLogin'));

        $crud->field_type('staffPassword', 'password');

        $crud->where('enabled', 'Y');

        $crud->unset_export();
        $crud->unset_delete();

        $output = $crud->render();

        $this->staff_output($output);
    }

	public function staff_member()
	{
	// Loading view home page views, Grocery CRUD Standard Library

		$crud = new grocery_CRUD();

		$staffNumber = $this->session->userdata('staffnum');
		$crud->where('staffNo',$staffNumber);

		$crud->set_theme('flexigrid');

		//table name exact from database
		$crud->set_table('staff');

		//give focus on name used for operations e.g. Add Order, Delete Order
		$crud->set_subject('Staff');
		$crud->columns('staffNo', 'fName', 'lName', 'staffLogin', 'staffPassword', 'accessLevel');
		//change column heading name for readability ('columm name', 'name to display in frontend column header')
		$crud->display_as('staffNo', 'STAFF NO.')
            ->display_as('fName', 'First Name')
            ->display_as('lName', 'Last Name')
            ->display_as('staffLogin', 'Username')
            ->display_as('staffPassword', 'Password')
            ->display_as('sPosition', 'Staff Position')
            ->display_as('enabled', 'Archived');

		$crud->field_type('enabled', 'dropdown', array('N' => 'Yes', 'Y' => 'No'));

        $crud->where('enabled', 'N');

        $crud->unset_delete();

		$crud->fields('fName', 'lName', 'staffLogin', 'staffPassword');

		//form validation (could match database columns set to "not null")
		$crud->required_fields('staffNo', 'fName', 'lName', 'enabled', 'staffLogin', 'staffPassword', 'accessLevel');

        //remove add new staff function
        $crud->unset_add();
        $crud->unset_delete();
        $crud->unset_export();

		$output = $crud->render();

		$this->staff_member_output($output);

	}

    public function staffDeleted()
    {
        // Loading view home page views, Grocery CRUD Standard Library

        $crud = new grocery_CRUD();

        $crud->set_theme('flexigrid');

        //table name exact from database
        $crud->set_table('staff');
                    //give focus on name used for operations e.g. Add Order, Delete Order
        $crud->set_subject('Staff');
        $crud->columns('staffNo', 'fName', 'lName', 'staffLogin', 'staffPassword', 'accessLevel');
                    //change column heading name for readability ('columm name', 'name to display in frontend column header')
        $crud->display_as('staffNo', 'STAFF NO.')
            ->display_as('fName', 'First Name')
            ->display_as('lName', 'Last Name')
            ->display_as('staffLogin', 'Username')
            ->display_as('staffPassword', 'Password')
            ->display_as('sPosition', 'Staff Position')
            ->display_as('enabled', 'Delete');

        $crud->field_type('enabled', 'dropdown', array('N' => 'Yes', 'Y' => 'No'));

        $crud->where('enabled', 'N');

        $crud->fields('staffNo', 'fName', 'lName', 'staffLogin', 'staffPassword', 'accessLevel', 'enabled');

        //form validation (could match database columns set to "not null")
        $crud->required_fields('staffNo', 'fName', 'lName', 'enabled', 'staffLogin', 'staffPassword', 'accessLevel');

        $crud->field_type('accessLevel', 'dropdown', array('1' => 'Manager/HR', '2' => 'Marketing', '3' => 'Therapist'));

        $crud->unique_fields(array('staffNo','fName', 'lName', 'staffLogin'));

        $crud->field_type('staffPassword', 'password');

        $crud->where('enabled', 'N');

        $crud->unset_add();
        $crud->unset_delete();
        $crud->unset_export();

        $output = $crud->render();

        $this->staff_output($output);
    }
}
?>
