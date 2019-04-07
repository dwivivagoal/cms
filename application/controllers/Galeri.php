<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Galeri extends CI_Controller {

	function __construct() {
            parent::__construct();
            $this->themes = $this->config->item('themes');
        }        
        
        public function index()
	{
            $data = array(
                'THEMES_PAGE'       => base_url('themes/'.$this->themes),
            );
            
            $data['HEADER_SECTION']     = $this->parser->parse($this->themes.'/layout/content/preloader', $data, true);
            $data['HEADER_SECTION']    .= $this->parser->parse($this->themes.'/layout/header/header', $data, true);
            
            $data['SLIDER_SECTION']     = $this->parser->parse($this->themes.'/layout/content/home/slider', $data, true);
            $data['SLIDER_SECTION']    .= $this->parser->parse($this->themes.'/layout/content/home/headlines', $data, true);
            $data['SLIDER_SECTION']    .= $this->parser->parse($this->themes.'/layout/content/home/popular', $data, true);
            //$data['SLIDER_SECTION']    .= $this->parser->parse($this->themes.'/layout/content/home/best', $data, true);            
            //$data['SLIDER_SECTION']    .= $this->parser->parse($this->themes.'/layout/content/home/video', $data, true);
            //$data['SLIDER_SECTION']    .= $this->parser->parse($this->themes.'/layout/content/home/news_index', $data, true);
            
            $data['BODY_SECTION']       = $this->parser->parse($this->themes.'/layout/content/body_layout', $data, true);
            $data['FOOTER_SECTION']     = $this->parser->parse($this->themes.'/layout/footer/footer', $data, true);
            $this->parser->parse($this->themes.'/layout/main_layout', $data);
	}
}
