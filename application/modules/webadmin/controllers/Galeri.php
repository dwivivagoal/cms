<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Galeri extends CI_Controller {

	function __construct() {
            parent::__construct();
            $this->themes = 'webadmin';
            $this->load->model('Mdl_galeri');
            
        }        
      
        
        function Image()
        {
            $data = array(
                'TITLE_PAGE'    => 'Berita',
                'THEMES_PAGE'   => base_url('themes/webadmin')
            );
            
            $data['FIELDS_LIST']        = $this->Mdl_content->getFields();
            $data['DATA_LIST']          = $this->Mdl_content->getList();
            $data['CONTENT_SECTION']    = $this->parser->parse($this->themes.'/layout/list/list', $data, true);
            $data['PLUGINS_CSS']        = $this->parser->parse($this->themes.'/layout/common/datatables_plugins', $data, true);
            $data['PLUGINS_SCRIPT']     = $this->parser->parse($this->themes.'/layout/common/datatables_addon', $data, true);
            
            $this->load->parseWebadmin($data);
        }
        
        function Video()
        {
            $data = array(
                'TITLE_PAGE'    => 'Berita',
                'THEMES_PAGE'   => base_url('themes/webadmin')
            );
            
            $data['FIELDS_LIST']        = $this->Mdl_content->getFields();
            $data['DATA_LIST']          = $this->Mdl_content->getList();
            $data['CONTENT_SECTION']    = $this->parser->parse($this->themes.'/layout/list/list', $data, true);
            $data['PLUGINS_CSS']        = $this->parser->parse($this->themes.'/layout/common/datatables_plugins', $data, true);
            $data['PLUGINS_SCRIPT']     = $this->parser->parse($this->themes.'/layout/common/datatables_addon', $data, true);
            
            $this->load->parseWebadmin($data);
        }
        
}    