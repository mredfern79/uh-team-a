<?php

class Site extends CI_Controller {

    function __construct()
    {
      parent::__construct();
      $this->load->library('session');
      $this->load->helper('url_helper');
      $this->load->helper('html');

      // run this to check session on page load
      $this->is_logged_in();
    }

    function members_area()
    {
      $this->load->helper('form');

      $data = array(
        'username' => 'phil'
      );

      $this->load->view('site/members', $data);
    }

    // Checking session data, so if cookie romoved can't access.
    // Cookies have been set to encrypted for safety. Could add cookie to DB
    function is_logged_in()
    {
      $is_logged_in = $this->session->userdata('is_logged_in');

      if (!isset($is_logged_in) || $is_logged_in != TRUE)
      {
        echo 'You don\'t have correct permissions. <a href="../login">Login</a>';
        die();
      }
    }

    function logout()
    {
      $this->session->unset_userdata('is_logged_in');
      redirect('login/index');
    }

}

?>
