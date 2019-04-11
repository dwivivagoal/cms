<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct() {
            parent::__construct();
            $this->themes = $this->config->item('themes');
            $this->load->model('Mdl_berita');
            $this->load->model('Mdl_galeri');
            $this->load->model('Mdl_kategori');
    }        
        
    
    
    function index()
    {
        $data = array();
        $data['BODY_SECTION']       = $this->parser->parse($this->themes.'/layout/content/body_layout', $data, true);
            
        $this->load->parseWebadmin($data);
    }


}   