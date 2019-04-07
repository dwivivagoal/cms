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
        
        public function index()
	{
            $data = array(
                'SITE_URL'          => site_url(),
                'BASE_URL'          => base_url(),
                'THEMES_PAGE'       => base_url('themes/'.$this->themes),
                'PAGE_TITLE'        => $this->config->item('page_title').' '
            );            
            
            $data['HEADER_SECTION']     = $this->parser->parse($this->themes.'/layout/content/preloader', $data, true);
            $data['HEADER_SECTION']    .= $this->parser->parse($this->themes.'/layout/header/header', $data, true);
            $params = array();
            $data['SLIDER_LIST']        = $this->Mdl_berita->getSlider($params);
            $data['SLIDER_SECTION']     = $this->parser->parse($this->themes.'/layout/content/home/slider', $data, true);
            $headline                   = $this->Mdl_berita->getHeadline($params);
            $data['HEADLINE_LIST']      = $headline['headline'];
            $data['OTHERS_LIST']        = $headline['others'];
            $data['IMAGE_HEADLINE_LIST']    = $this->Mdl_galeri->getHeadline($params);
            $data['SLIDER_SECTION']        .= $this->parser->parse($this->themes.'/layout/content/home/headlines', $data, true);
            
            $data['VIDEO_KATEGORI_LIST']    = $this->Mdl_galeri->getVideoKategori($params);
            $data['KATEGORI_LIST_CONTENT']  = $data['VIDEO_KATEGORI_LIST'];
            
            $data['VIDEO_HEADLINE']         = $this->Mdl_galeri->getVideoHeadline($params);
            $popular                        = $this->Mdl_berita->getPopular($params);
            $data['POPULAR_LIST_FIRST']     = $popular['others'];
            $data['POPULAR_LIST']           = $popular['others_index'];
            $data['POPULAR_LIST_MAIN']      = $popular['headline'];
            $data['SLIDER_SECTION']        .= $this->parser->parse($this->themes.'/layout/content/home/popular', $data, true);
            
            //$data['SLIDER_SECTION']       .= $this->parser->parse($this->themes.'/layout/content/home/best', $data, true);            
            $popular_image = $this->Mdl_galeri->getImagePopular($params);
            $data['POPULAR_IMAGE_LIST']     = $popular_image;
            $data['SLIDER_SECTION']        .= $this->parser->parse($this->themes.'/layout/content/home/video', $data, true);
            
            
            $latestbycat1                                = $this->Mdl_berita->getLatestByCategory($params);
            $data['LATEST_HEADLINE_BYCAT_LIST1']         = $latestbycat1['HEADLINE'];
            $data['LATEST_BYCAT_LIST1']                  = $latestbycat1['OTHERS'];
            $latestbycat2                                = $this->Mdl_berita->getLatestByCategory($params);
            $data['LATEST_HEADLINE_BYCAT_LIST2']         = $latestbycat2['HEADLINE'];
            $data['LATEST_BYCAT_LIST2']                  = $latestbycat2['OTHERS'];
            
            $latest                         = $this->Mdl_berita->getLatest($params);
            $data['LATEST_HEADLINE_LIST']   = $latest['HEADLINE'];
            $data['LATEST_LIST']            = $latest['OTHERS'];
            $data['SLIDER_SECTION']        .= $this->parser->parse($this->themes.'/layout/content/home/news_index', $data, true);
            
            $data['BODY_SECTION']       = $this->parser->parse($this->themes.'/layout/content/body_layout', $data, true);
            $data['FOOTER_SECTION']     = $this->parser->parse($this->themes.'/layout/footer/footer', $data, true);
            $this->parser->parse($this->themes.'/layout/main_layout', $data);
	}
}
