<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct() {
            parent::__construct();
            $this->themes = $this->config->item('themes');
            $this->load->model('Mdl_berita');
            $this->load->model('Mdl_galeri');
            $this->load->model('Mdl_kategori');
            $this->load->model('Mdl_menu');
        }        
        
        public function index()
        {
            $data = array();
            $params = array();
            $data['SLIDER_LIST']            = $this->Mdl_berita->getSlider($params);
            $data['SLIDER_SECTION']         = $this->parser->parse($this->themes.'/layout/content/home/slider', $data, true);
            $headline                       = $this->Mdl_berita->getHeadline($params);
            $data['HEADLINE_LIST']          = $headline['headline'];
            $data['OTHERS_LIST']            = $headline['others'];
            $data['IMAGE_HEADLINE_LIST']    = $this->Mdl_galeri->getHeadline($params);
            $data['SLIDER_SECTION']        .= $this->parser->parse($this->themes.'/layout/content/home/headlines', $data, true);
            
            $data['VIDEO_KATEGORI_LIST']    = $this->Mdl_galeri->getVideoKategori($params);
            $data['KATEGORI_LIST_CONTENT']  = $data['VIDEO_KATEGORI_LIST'];
            
            $data['VIDEO_HEADLINE']         = $this->Mdl_galeri->getVideoHeadline($params);
            $popular                        = $this->Mdl_berita->getPopular($params);
            $recent                         = $this->Mdl_berita->getRecent($params);
            
            $data['POPULAR_LIST_FIRST']     = $popular['others'];
            $data['POPULAR_LIST']           = $popular['others_index'];
            $data['POPULAR_LIST_MAIN']      = $popular['headline'];
            $data['RECENT_LIST']            = $recent;
            
            $data['SLIDER_SECTION']        .= $this->parser->parse($this->themes.'/layout/content/home/popular', $data, true);
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
            
            $this->load->parseGuest($data);
        }
        
        public function content($alias='')
        {
            $this->load->model('Mdl_content');
            $params = array();
            $data = $this->Mdl_content->getDetailAlias($alias);
            
            $data['OTHERS_CONTENT'] = '';
            $data['SLIDER_SECTION'] = $this->parser->parse($this->themes.'/layout/content/page/body_layout', $data, true);
            $this->load->parseGuest($data);
        }
        
        public function map($alias='lokasi')
        {
            $this->load->model('Mdl_content');
            $params = array();
            $data = $this->Mdl_content->getDetailAlias('lokasi');
            
            $data['OTHERS_CONTENT'] = $this->parser->parse($this->themes.'/layout/content/page/maps', $data, true);
            $data['SLIDER_SECTION'] = $this->parser->parse($this->themes.'/layout/content/page/body_layout', $data, true);
            $this->load->parseGuest($data);
        }
        
        
        public function organisasi()
        {
            $this->load->model('Mdl_content');
            $params = array();
            $data = $this->Mdl_content->getDetailAlias('struktur-organisasi');
            
            $data['OTHERS_CONTENT'] = $this->parser->parse($this->themes.'/layout/content/page/organisasi', $data, true);
            $data['SLIDER_SECTION'] = $this->parser->parse($this->themes.'/layout/content/page/body_layout', $data, true);
            $this->load->parseGuest($data);
        }
        
        public function pejabat()
        {
            $this->load->model('Mdl_content');
            $data = $this->Mdl_content->getDetailAlias('pejabat-dislitbangad');
            $this->load->model('Mdl_pejabat');
            $pejabat = $this->Mdl_pejabat->getListPejabat();
            
            $data['KADIS']          = $pejabat['KADIS'];
            $data['PEJABAT']        = $pejabat['PEJABAT'];
            
            $data['OTHERS_CONTENT'] = $this->parser->parse($this->themes.'/layout/content/page/pejabat', $data, true);
            $data['SLIDER_SECTION'] = $this->parser->parse($this->themes.'/layout/content/page/body_layout', $data, true);
            $this->load->parseGuest($data);
        }
        
        public function kadislitbangad()
        {
            $this->load->model('Mdl_content');
            $params = array();
            $data = $this->Mdl_content->getDetailAlias('kadislitbang');
            
            $data['SLIDER_SECTION'] = $this->parser->parse($this->themes.'/layout/content/page/body_layout', $data, true);
            $this->load->parseGuest($data);
        }
        
        public function mantan()
        {
            $this->load->model('Mdl_content');
            $params = array();
            $data = $this->Mdl_content->getDetailAlias('mantan-kadislitbang');
            
            $this->load->model('Mdl_mantan');
            $data['MANTAN'] = $this->Mdl_mantan->getListMantan();
            print_r($data['MANTAN']);
            
            $data['OTHERS_CONTENT'] = $this->parser->parse($this->themes.'/layout/content/page/mantan', $data, true);
            $data['SLIDER_SECTION'] = $this->parser->parse($this->themes.'/layout/content/page/body_layout', $data, true);
            $this->load->parseGuest($data);
        }
        
        
}
