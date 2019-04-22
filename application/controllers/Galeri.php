<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Galeri extends CI_Controller {

	function __construct() {
            parent::__construct();
            $this->themes = $this->config->item('themes');
            $this->load->model('Mdl_berita');
            $this->load->model('Mdl_galeri');
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
        
        public function foto($title='semua')
	{
            $data = array(
                'THEMES_PAGE'       => base_url('themes/'.$this->themes),
                'KATEGORI_TITLE'    => $title,
            );
            
            $params = array();
            
            $berita = $this->Mdl_galeri->getFotoListAll($title, $params);
            $data['KATEGORI_ITEM_LIST'] = $berita['results'];
                        
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
        
        
        public function video($title='semua')
	{
            $data = array(
                'THEMES_PAGE'       => base_url('themes/'.$this->themes),
                'KATEGORI_TITLE'    => $title,
            );
            
            $params = array();
            
            $berita = $this->Mdl_galeri->getVideoListAll($title, $params);
            $data['KATEGORI_ITEM_LIST'] = $berita['results'];
                        
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
