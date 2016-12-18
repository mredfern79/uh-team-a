<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Therapist_qualif extends CI_Controller {

	public function __construct()
    {
        parent:: __construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('session');
        $this->load->library('grocery_CRUD');
    }

    public function staff_qualif_output($output = null)
    {
        $this->load->helper('form');

        $data['output'] = $output;
        $data['main_content'] = 'site/staff_qualif_view';
        $data['user'] = $this->session->userdata('username');
        $data['al'] = $this->session->userdata('al');
        $this->load->view('includes/template', $data);
    }

    public function staff_qualif()
    {

        $crud = new grocery_CRUD();

        $crud->set_theme('flexigrid');

        $crud->set_table('therapistQualifications');
        //give focus on name used for operations e.g. Add Order, Delete Order
        $crud->set_subject('Therapist Qualifications');

        $crud->set_relation('qId', 'qualifications', '{qName} - {qLevel}');
        $crud->set_relation('staffNo', 'staff', '{fName} {lName}');
        
        $crud->display_as('staffNo', 'Therapist Name')
            ->display_as('qId', 'Qualification and Level')
            ->display_as('dateQualified', 'Date Qualified')
            ->display_as('qExpiryDdate', 'Qualification Expiry Date')
            ->display_as('enabled', 'Delete');

        $crud->field_type('enabled', 'dropdown', array('N' => 'Yes', 'Y' => 'No'));

        $crud->where('therapistQualifications.enabled', 'Y');

        // Check to see if qualification has expired. If it has expired flag date in red
        $crud->callback_column('qExpiryDdate',array($this,'_callback_active_state'));

        $crud->columns('staffNo', 'qId', 'dateQualified', 'qExpiryDdate');
        $crud->fields('staffNo', 'qId', 'dateQualified', 'qExpiryDdate', 'enabled');

        $crud->unset_export();
        $crud->unset_delete();

        $output = $crud->render();
		
        $this->staff_qualif_output($output);

    }

    public function _callback_active_state($value, $row)
    {
        if ($row->qExpiryDdate < date('Y-m-d')) {
            return "<pre style='background-color: Red;color:white;'>".$row->qExpiryDdate."</pre>";
        } else {
            return $row->qExpiryDdate;
        };
    }

    public function member_qualifications()
    {
        // Loading view home page views, Grocery CRUD Standard Library

        $crud = new grocery_CRUD();

        $staffNumber = $this->session->userdata('staffnum');
        

        // read only
        $crud->unset_operations();

        $crud->set_theme('flexigrid');

        //table name exact from database
        $crud->set_table('therapistQualifications');

        $crud->where('therapistQualifications.staffNo',$staffNumber);

        $crud->set_subject('My Qualifications');

        $crud->set_relation('qId', 'qualifications', '{qName} - {qLevel}');
        $crud->set_relation('staffNo', 'staff', '{fName} {lName}');
        
        $crud->display_as('staffNo', 'Therapist Name')
            ->display_as('qId', 'Qualification and Level')
            ->display_as('dateQualified', 'Date Qualified')
            ->display_as('qExpiryDdate', 'Qualification Expiry Date');


        $crud->where('therapistQualifications.enabled', 'Y');

        $crud->columns('staffNo', 'qId', 'dateQualified', 'qExpiryDdate');
        $crud->fields('staffNo', 'qId', 'dateQualified', 'qExpiryDdate');

        $output = $crud->render();

        $this->staff_qualif_output($output);

    }

    public function staff_qualifReadOnly()
    {

        $crud = new grocery_CRUD();

        $crud->set_theme('flexigrid');

        //table name exact from database
        $crud->set_table('therapistQualifications');
        //give focus on name used for operations e.g. Add Order, Delete Order
        $crud->set_subject('Therapist Qualifications');

        $crud->set_relation('qId', 'qualifications', '{qName} - {qLevel}');
        $crud->set_relation('staffNo', 'staff', '{fName} {lName}');
            
        $crud->display_as('staffNo', 'Therapist Name')
            ->display_as('qId', 'Qualification and Level')
            ->display_as('dateQualified', 'Date Qualified')
            ->display_as('qExpiryDdate', 'Qualification Expiry Date');

        $crud->columns('staffNo', 'qId', 'dateQualified', 'qExpiryDdate');
        $crud->fields('staffNo', 'qId', 'dateQualified', 'qExpiryDdate');

        // Read Only
        $crud->unset_operations();

        $crud->where('therapistQualifications.enabled', 'Y');

        $output = $crud->render();
            
        $this->staff_qualif_output($output);

    }

    public function staff_qualifDeleted()
    {

        $crud = new grocery_CRUD();

        $crud->set_theme('flexigrid');

        $crud->set_table('therapistQualifications');
        //give focus on name used for operations e.g. Add Order, Delete Order
        $crud->set_subject('Therapist Qualifications');

        $crud->set_relation('qId', 'qualifications', '{qName} - {qLevel}');
        $crud->set_relation('staffNo', 'staff', '{fName} {lName}');
        
        $crud->display_as('staffNo', 'Therapist Name')
            ->display_as('qId', 'Qualification and Level')
            ->display_as('dateQualified', 'Date Qualified')
            ->display_as('qExpiryDdate', 'Qualification Expiry Date')
            ->display_as('enabled', 'Delete');

        $crud->field_type('enabled', 'dropdown', array('N' => 'Yes', 'Y' => 'No'));

        $crud->where('therapistQualifications.enabled', 'Y');


        // Check to see if qualification has expired. If it has expired flag date in red
        $crud->callback_column('qExpiryDdate',array($this,'_callback_active_state'));

        $crud->columns('staffNo', 'qId', 'dateQualified', 'qExpiryDdate');
        $crud->fields('staffNo', 'qId', 'dateQualified', 'qExpiryDdate','enabled');

        $crud->unset_add();
        $crud->unset_delete();
        $crud->unset_export();

        $output = $crud->render();
        
        $this->staff_qualif_output($output);

    }

}
?>