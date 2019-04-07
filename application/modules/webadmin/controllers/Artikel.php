<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artikel extends CI_Controller {

	function __construct() {
            parent::__construct();
            $this->themes = 'webadmin';
            $this->load->model('Mdl_artikel');
        }        
      
        
        function index()
        {
            $data = array();
            $data['FIELDS_LIST']    = $this->Mdl_artikel->getFields();
            $data['DATA_LIST']      = $this->Mdl_artikel->getList();
            $data['CONTENT_SECTION']    = $this->parser->parse($this->themes.'/layout/list/list', $data, true);
            $data['PLUGINS_CSS']        = $this->parser->parse($this->themes.'/layout/common/datatables_plugins', $data, true);
            $data['PLUGINS_SCRIPT']     = $this->parser->parse($this->themes.'/layout/common/datatables_addon', $data, true);
            
            $this->load->parseWebadmin($data);
        }
}    