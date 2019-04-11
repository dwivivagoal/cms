<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

	function __construct() {
            parent::__construct();
            $this->themes = 'webadmin';
            $this->load->model('Mdl_menu');
        }        
      
        
        function index()
        {
            $data = array(
                'TITLE_PAGE'        => 'Menu',
                'THEMES_PAGE'       => base_url('themes/webadmin'),
                'URL_FORM_EDIT'     => site_url('webadmin/menu/form'),
                'URL_FORM_DELETE'   => site_url('webadmin/menu/delete')
            );
            $data['FIELDS_LIST']    = $this->Mdl_menu->getFields();
            $data['DATA_LIST']      = $this->Mdl_menu->getList();
            
            $data['CONTENT_SECTION']    = $this->parser->parse($this->themes.'/layout/list/list', $data, true);
            $data['BODY_SECTION']       = $this->parser->parse($this->themes.'/layout/content/body_layout', $data, true);
            
            $data['PLUGINS_CSS']        = $this->parser->parse($this->themes.'/layout/common/datatables_css', $data, true);
            $data['PLUGINS_SCRIPT']     = $this->parser->parse($this->themes.'/layout/common/datatables_plugins', $data, true);
            $data['ADDON_SCRIPT']       = $this->parser->parse($this->themes.'/layout/common/datatables_addon', $data, true);
            
            $this->load->parseWebadmin($data);
        }
        
        function form($id=0)
        {
            $data = array(
                'TITLE_PAGE'        => 'Menu',
                'THEMES_PAGE'       => base_url('themes/webadmin'),
                'URL_FORM_EDIT'     => site_url('webadmin/menu/form'),
                'URL_FORM_DELETE'   => site_url('webadmin/menu/delete')
            );
            $data['FIELDS_LIST']        = $this->Mdl_menu->getFormFields();
            
            if ((!empty($id)) || ($id > 0)){
                $data['DETAIL']          = $this->Mdl_menu->getDetail($id);
            } else {
                
            }
            $data['CONTENT_SECTION']    = $this->parser->parse($this->themes.'/layout/form/form', $data, true);
            $data['BODY_SECTION']       = $this->parser->parse($this->themes.'/layout/content/body_form_layout', $data, true);
            
            $data['PLUGINS_CSS']        = ''; //;
            $data['PLUGINS_SCRIPT']     = ''; //;
            $data['ADDON_SCRIPT']       = ''; //;
            
            $this->load->parseWebadmin($data);
        }
        
        function delete()
        {
            $params = $this->input->post();
            if (!empty($params['id'])){
                $data = $this->Mdl_menu->deleteData($params['id']);
            }
            echo json_encode($data);
        }
        
        
} 