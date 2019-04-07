<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php";

class MY_Loader extends MX_Loader {

    function parseGuest()
    {

    }


    function parseWebadmin($vars)
    {
        $data = array();
        $themes = 'webadmin';
        $data['BASE_URL']       = base_url();
        $data['SITE_URL']       = site_url();
        $data['THEMES_PAGE']    = base_url('themes/webadmin');
        $data = array_merge($data, $vars);
        
        $data['SIDEBAR_SECTION']    = $this->parser->parse($themes.'/layout/menu/sidebar', $data, true);
        $data['HEADER_SECTION']     = $this->parser->parse($themes.'/layout/header/header', $data, true);
        $data['TOP_MENU_SECTION']   = $this->parser->parse($themes.'/layout/menu/top_menu_section', $data, true);
        
        $data['BODY_SECTION']       = $this->parser->parse($themes.'/layout/content/body_layout', $data, true);
        $data['FOOTER_SECTION']     = $this->parser->parse($themes.'/layout/footer/footer', $data, true);
        
        $this->parser->parse($themes.'/layout/main_layout', $data);
    }
}