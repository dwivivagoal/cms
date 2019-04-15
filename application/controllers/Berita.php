<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berita extends CI_Controller {

	function __construct() {
            parent::__construct();
            $this->themes = $this->config->item('themes');
            $this->load->model('Mdl_berita');
        }      
        
        
        public function index()
	{
            if (empty($title)){
                redirect('404', refresh);
            }
            
            $berita = $this->Mdl_berita->getDetailAlias($title);
            
            $data = array(
                'THEMES_PAGE'       => base_url('themes/'.$this->themes),
            );
            $data = array_merge($data, $berita);
                        
            $data['HEADER_SECTION']     = $this->parser->parse($this->themes.'/layout/content/preloader', $data, true);
            $data['HEADER_SECTION']    .= $this->parser->parse($this->themes.'/layout/header/header', $data, true);
            
            $data['SLIDER_SECTION']       = $this->parser->parse($this->themes.'/layout/content/kategori/body_layout', $data, true);
                       
            $data['FOOTER_SECTION']     = $this->parser->parse($this->themes.'/layout/footer/footer', $data, true);
            $this->load->parseGuest($data);
	}
        
        
        
        public function detail($title='')
	{
            if (empty($title)){
                redirect('404', refresh);
            }
            
            $berita = $this->Mdl_berita->getDetailAlias($title);
            
            $data = array(
                'THEMES_PAGE'       => base_url('themes/'.$this->themes),
            );
            $data = array_merge($data, $berita);
                        
            $data['HEADER_SECTION']     = $this->parser->parse($this->themes.'/layout/content/preloader', $data, true);
            $data['HEADER_SECTION']    .= $this->parser->parse($this->themes.'/layout/header/header', $data, true);
            
            $data['SLIDER_SECTION']       = $this->parser->parse($this->themes.'/layout/content/detail/body_layout', $data, true);
                       
            $data['FOOTER_SECTION']     = $this->parser->parse($this->themes.'/layout/footer/footer', $data, true);
            $this->load->parseGuest($data);
	}
        
        
        public function kategori($title='')
	{
            if (empty($title)){
                redirect('404', refresh);
            }
            
            $data = array(
                'THEMES_PAGE'       => base_url('themes/'.$this->themes),
            );
            
            $params = array();
            $data['KATEGORI_ITEM_LIST'] = $this->Mdl_berita->getLatest($params);            
                        
            $data['HEADER_SECTION']     = $this->parser->parse($this->themes.'/layout/content/preloader', $data, true);
            $data['HEADER_SECTION']    .= $this->parser->parse($this->themes.'/layout/header/header', $data, true);
            
            $data['KATEGORI_ITEM_SECTION']  = $this->parser->parse($this->themes.'/layout/content/kategori/kategori_item', $data, true);
            
            $data['KATEGORI_RIGHT_SECTION']  = $this->parser->parse($this->themes.'/layout/content/link_item', $data, true);
            $data['KATEGORI_RIGHT_SECTION']  .= $this->parser->parse($this->themes.'/layout/content/favorite_item', $data, true);
            $data['KATEGORI_RIGHT_SECTION']  .= $this->parser->parse($this->themes.'/layout/content/category_item', $data, true);
            
            
            $data['SLIDER_SECTION']         = $this->parser->parse($this->themes.'/layout/content/kategori/body_layout', $data, true);
                       
            $data['FOOTER_SECTION']     = $this->parser->parse($this->themes.'/layout/footer/footer', $data, true);
            $this->load->parseGuest($data);
	}
        
        
}
