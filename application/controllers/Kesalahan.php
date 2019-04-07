<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kesalahan extends CI_Controller {

	function __construct() {
            parent::__construct();
            $this->themes = $this->config->item('themes');
        }        
        
        public function index($code='')
	{
            $data = array(
                'THEMES_PAGE'       => base_url('themes/'.$this->themes),
            );
            
            $data['HEADER_SECTION']     = $this->parser->parse($this->themes.'/layout/content/preloader', $data, true);
            $data['HEADER_SECTION']    .= $this->parser->parse($this->themes.'/layout/header/header', $data, true);
            
            $data['BODY_SECTION']       = $this->parser->parse($this->themes.'/layout/content/kesalahan/404_page', $data, true);
            $data['FOOTER_SECTION']     = $this->parser->parse($this->themes.'/layout/footer/footer', $data, true);
            $this->parser->parse($this->themes.'/layout/main_layout', $data);
	}
}        