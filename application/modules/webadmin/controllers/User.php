<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct() {
            parent::__construct();
            $this->themes = 'webadmin';
            $this->load->model('Mdl_galeri');
        } 
        
        function index()
        {
            $data = array(
                'TITLE_PAGE'    => 'Galeri Image',
                'THEMES_PAGE'   => base_url('themes/webadmin')
            );
            
            $data['FIELDS_LIST']        = $this->Mdl_galeri->getFields();
            $data['DATA_LIST']          = $this->Mdl_galeri->getList();
            
            $data['CONTENT_SECTION']    = $this->parser->parse($this->themes.'/layout/list/list', $data, true);
            $data['BODY_SECTION']       = $this->parser->parse($this->themes.'/layout/content/body_layout', $data, true);
                       
            $data['PLUGINS_CSS']        = $this->parser->parse($this->themes.'/layout/common/datatables_plugins', $data, true);
            $data['PLUGINS_SCRIPT']     = $this->parser->parse($this->themes.'/layout/common/datatables_addon', $data, true);
            
            $this->load->parseWebadmin($data);
        }
        
        
        function user_group()
        {
            $data = array(
                'TITLE_PAGE'    => 'Galeri Image',
                'THEMES_PAGE'   => base_url('themes/webadmin')
            );
            
            $data['FIELDS_LIST']        = $this->Mdl_galeri->getFields();
            $data['DATA_LIST']          = $this->Mdl_galeri->getList();
            
            $data['CONTENT_SECTION']    = $this->parser->parse($this->themes.'/layout/list/list', $data, true);
            $data['BODY_SECTION']       = $this->parser->parse($this->themes.'/layout/content/body_layout', $data, true);
                       
            //$data['CONTENT_SECTION']    = $this->parser->parse($this->themes.'/layout/list/list', $data, true);
            $data['PLUGINS_CSS']        = $this->parser->parse($this->themes.'/layout/common/datatables_plugins', $data, true);
            $data['PLUGINS_SCRIPT']     = $this->parser->parse($this->themes.'/layout/common/datatables_addon', $data, true);
            
            $this->load->parseWebadmin($data);
        }
        
        function user_otoritas()
        {
            $data = array(
                'TITLE_PAGE'    => 'Galeri Image',
                'THEMES_PAGE'   => base_url('themes/webadmin')
            );
            
            $data['FIELDS_LIST']        = $this->Mdl_galeri->getFields();
            $data['DATA_LIST']          = $this->Mdl_galeri->getList();
            
            $data['CONTENT_SECTION']    = $this->parser->parse($this->themes.'/layout/list/list', $data, true);
            $data['BODY_SECTION']       = $this->parser->parse($this->themes.'/layout/content/body_layout', $data, true);
                       
            //$data['CONTENT_SECTION']    = $this->parser->parse($this->themes.'/layout/list/list', $data, true);
            $data['PLUGINS_CSS']        = $this->parser->parse($this->themes.'/layout/common/datatables_plugins', $data, true);
            $data['PLUGINS_SCRIPT']     = $this->parser->parse($this->themes.'/layout/common/datatables_addon', $data, true);
            
            $this->load->parseWebadmin($data);
        }
        
}        