<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct() {
            parent::__construct();
            $this->themes = $this->config->item('themes');
            $this->memberid = $this->session->userdata('user_id');
    }        
        
    
    
    function index()
    {
        $data = array(
            'THEMES_PAGE'   => base_url('themes/webadmin'),
            'SITE_URL'      => site_url(),
            'BASE_URL'      => base_url()

        );
        $this->parser->parse('webadmin/layout/form/login', $data);
    }


}   