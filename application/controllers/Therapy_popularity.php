<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Therapy_popularity extends CI_Controller {

	public function __construct()
    {
        parent:: __construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('session');

        $this->load->library('grocery_CRUD');
    }

    public function therapy_popularity_output($output = null)
    {
        $this->load->helper('form');

        $data['output'] = $output;
        $data['main_content'] = 'site/therapy_popularity_view';
        $data['user'] = $this->session->userdata('username');
        $data['al'] = $this->session->userdata('al');
        $this->load->view('includes/template', $data);
    }

    public function therapy_popularity()
    {
        $crud = new grocery_CRUD();
        $crud->set_theme('flexigrid');

        //table name exact from database
        $crud->set_table('therapypopularity');
        $crud->set_primary_key('Therapy');
        //give focus on name used for operations e.g. Add Order, Delete Order
        $crud->set_subject('Popularity');
        $crud->unset_operations();

        $output = $crud->render();

        $this->therapy_popularity_output($output);
    }

    public function therapy_popularity_php()
    {
        $crud = new grocery_CRUD();
        $crud->set_model('custom_query_model');
        $crud->set_table('therapy', 'therapySession');
        $crud->basic_model->set_query_str(' SELECT therapyName , count(sessionId) as `total number of sessions` 
                                            from therapy t, therapySession ts
                                            where ts.therapyId = t.therapyId
                                            group by ts.therapyId
                                            order by `total number of sessions` desc;');

        $crud->unset_operations();


        $output = $crud->render();

        $this->therapy_popularity_output($output);
    }

}
?>
