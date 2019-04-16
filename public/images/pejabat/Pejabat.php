<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pejabat extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $username = $this->session->userdata('nama_lengkap');
        if (empty($username)){
            redirect(site_url('webadmin/login'), 'refresh');
        }
        $this->load->model('Mdl_pejabat');
        $this->menu = setMenu();
    }
    
    function index()
    {
        $data = array(
            'SITE_URL'          => site_url(),
            'BASE_URL'          => base_url(),
            'THEMES_URL'        => base_url('themes/webadmin/'),
            'PAGE_TITLE_LAYOUT' => 'Pejabat',
            'LIST_FIELDS'       => $this->Mdl_pejabat->getfields(),
            'FIELDS_FORM'       => $this->Mdl_pejabat->getfieldsform(),
            'TABLE_ID'          => 'table_pejabat',
            'SITE_AJAX_URL'     => site_url('webadmin/pejabat/getlist'),
            'NOTIFY'            => ''
        );
        $data = array_merge($this->menu, $data);
        $data['PEJABAT_ACTIVE']    = 'active';
        $data['PEJABAT_SELECTED']  = '<span class="selected"></span>';
        $data['active_pejabat']        = 'active';
        
        $data['HEADER_SECTION'] = $this->parser->parse('webadmin/layout/header/header', $data, true);
        $data['MENU_SIDEBAR'] = $this->parser->parse('webadmin/layout/menu/menu_sidebar', $data, true);
        
        $data['CONTENT_SECTION'] = '';
        $data['CONTENT_SECTION'] .= $this->parser->parse('webadmin/layout/header/breadscrumb', $data, true);
        
        $status = $this->session->flashdata('STATUS');if (!empty($status)){
            $data['MSG']            = $this->session->flashdata('MSG');
            $data['NOTIFY']         = $this->parser->parse('webadmin/layout/content/notify_success', $data, true); 
        }
        $data['CONTENT_SECTION'] .= $this->parser->parse('webadmin/layout/list/list', $data, true);
        
        $data['FOOTER_SECTION']     = $this->parser->parse('webadmin/layout/footer/footer', $data, true);
        
        $data['PLUGINS_CSS']        = $this->parser->parse('webadmin/layout/common/table_css_plugins', $data, true);
        $data['PLUGINS_SCRIPTS']    = $this->parser->parse('webadmin/layout/common/table_plugins', $data, true);
        $data['ADDON_SCRIPTS']      = $this->parser->parse('webadmin/layout/common/table_scripts', $data, true);
        $data['ADDON_SCRIPTS']      .= $this->parser->parse('webadmin/layout/js/js_pejabat', $data, true);
        
        $this->parser->parse('webadmin/layout/main_layout', $data);
    }
    
    function getlist()
    {
        $params = $this->input->post();
        $params['length']   = $params['iDisplayLength'];
        $params['start']   = $params['iDisplayStart'];
        
        $list = $this->Mdl_pejabat->getListData($params);
        if ($params['start']==0){
            $nomor = 1;
        } else {
            $nomor = $params['start']+1;
        }
        $data = array();
        foreach($list['records']->result() as $row):
            
            $button = '<div class="btn-group btn-group-sm btn-group-solid margin-bottom-10">';
            $button .= '<button type="button" class="btn yellow btn-editable" data-id="'.$row->pejabat_id.'"><i class="fa fa-pencil"></i> Ubah</button>';
            $button .= '<button type="button" class="btn red btn-removable" data-id="'.$row->pejabat_id.'"><i class="fa fa-trash-o"></i> Hapus</button>';
            $button .= '</div>';
            
            if (!empty($row->pejabat_image_name)){
                $file_gambar = 'public/images/pejabat/'.$row->pejabat_image_name;
                if (file_exists($file_gambar)){
                    $gambar = base_url($file_gambar);
                } else {
                    $gambar = base_url('public/images/pejabat/12345.png');
                }
            } else {
                    $gambar = base_url('public/images/pejabat/12345.png');
                
            }
            
            $data[] = array(
                $nomor,
                '<img src="'.$gambar.'" width="90" alt="'.$row->pejabat_nama.'">',
                $row->pejabat_urut,
                $row->pejabat_nama,
                $row->pejabat_pangkat,
                $row->pejabat_nik,
                $row->pejabat_periode,
                $button
            );
            $nomor++;
        endforeach;
        $output = array(
                'aaData'        => $data,
                'sEcho'         => $params['sEcho'],
                'iTotalRecords'         => $list['total'],
                'iTotalDisplayRecords'  => $list['total_filter']                
        );
        echo json_encode($output);
    }
    
    function form($id=0)
    {
        $data = array(
            'SITE_URL'          => site_url(),
            'BASE_URL'          => base_url(),
            'THEMES_URL'        => base_url('themes/webadmin/'),
            'PAGE_TITLE_LAYOUT' => 'Pejabat Teras',
            'FIELDS_FORM'       => $this->Mdl_pejabat->getfieldsform(),
            'FORM_ID'          => 'form-pejabat',
            'SITE_FORM_LINK'    => site_url('webadmin/pejabat/simpan'),
            'NOTIFY'            => ''
        );
        
        $data = array_merge($this->menu, $data);
        $data['PEJABAT_ACTIVE']     = 'active';
        $data['PEJABAT_SELECTED']   = '<span class="selected"></span>';
        $data['active_pejabat']      = 'active';
        
        if ($id==0){
            $id='';
            $data['IMAGE_SRC']      = ''; 
            $data['ID']                 = ''; 
            $data['PEJABAT_URUT']           = ''; 
            $data['PEJABAT_NAMA']           = ''; 
            $data['PEJABAT_PANGKAT']        = ''; 
            $data['PEJABAT_JABATAN']        = ''; 
            $data['PEJABAT_NIK']            = ''; 
            $data['PEJABAT_PERIODE']        = ''; 
            
        } else {
            $pejabat_array                  = $this->Mdl_pejabat->getDetail($id);
            $data['IMAGE_SRC']              = base_url('public/images/pejabat/'.$pejabat_array['aaData']['pejabat_image_name']); 
            $data['ID']                     = $id; 
            $data['PEJABAT_URUT']           = $pejabat_array['aaData']['pejabat_urut']; 
            $data['PEJABAT_NAMA']           = $pejabat_array['aaData']['pejabat_nama']; 
            $data['PEJABAT_PANGKAT']        = $pejabat_array['aaData']['pejabat_pangkat']; 
            $data['PEJABAT_JABATAN']        = $pejabat_array['aaData']['pejabat_jabatan']; 
            $data['PEJABAT_NIK']            = $pejabat_array['aaData']['pejabat_nik']; 
            $data['PEJABAT_PERIODE']        = $pejabat_array['aaData']['pejabat_periode']; 
        };        
        
        $data['HEADER_SECTION'] = $this->parser->parse('webadmin/layout/header/header', $data, true);
        $data['MENU_SIDEBAR'] = $this->parser->parse('webadmin/layout/menu/menu_sidebar', $data, true);
        
        $data['CONTENT_SECTION'] = '';
        $data['CONTENT_SECTION'] .= $this->parser->parse('webadmin/layout/header/breadscrumb', $data, true);
        
        $status = $this->session->flashdata('STATUS');if (!empty($status)){
            $data['MSG']            = $this->session->flashdata('MSG');
            $data['NOTIFY']         = $this->parser->parse('webadmin/layout/content/notify_alert', $data, true); 
        }
        $data['CONTENT_SECTION'] .= $this->parser->parse('webadmin/layout/form/form', $data, true);
        
        $data['FOOTER_SECTION']     = $this->parser->parse('webadmin/layout/footer/footer', $data, true);
        
        $data['PLUGINS_CSS']        = $this->parser->parse('webadmin/layout/common/form_css_component', $data, true);
        $data['PLUGINS_SCRIPTS']    = $this->parser->parse('webadmin/layout/common/form_component', $data, true);; ; 
        $data['ADDON_SCRIPTS']      = ''; 
        $data['ADDON_SCRIPTS']      .= $this->parser->parse('webadmin/layout/js/js_pejabat_form', $data, true);
        
        $this->parser->parse('webadmin/layout/main_layout', $data);
    }
    
    function simpan($id=0)
    {
        if ($id==0){
            $id='';
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('pejabat_nama', 'Nama Pejabat', 'trim|required');
        //$this->form_validation->set_rules('pejabat_pangkat', 'Pangkat', 'trim|required');
        //$this->form_validation->set_rules('pejabat_jabatan', 'Jabatan', 'trim|required');
        $this->form_validation->set_rules('pejabat_urut', 'No urut', 'trim|required');
        
        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('STATUS',0);
            $this->session->set_flashdata('MSG','Gagal: '.validation_errors());
            redirect('webadmin/pejabat/form/'.$id);
        }
        else
        {
            $params = $this->input->post();
            if ($params['id']==0){
                if ($this->Mdl_pejabat->tambah($params)){
                    $this->session->set_flashdata('STATUS',1);
                    $this->session->set_flashdata('MSG','Berhasil: Data telah disimpan ');
                    redirect('webadmin/pejabat');
                } else {
                    $this->session->set_flashdata('STATUS',2);
                    $this->session->set_flashdata('MSG','Gagal: Data tidak dapat disimpan');
                     redirect('webadmin/pejabat/form/'.$id);
                }
            } else {
                if ($this->Mdl_pejabat->ubah($params['id'],$params)){
                    $this->session->set_flashdata('STATUS',1);
                    $this->session->set_flashdata('MSG','Berhasil: Data berhasil di update ');
                    redirect('webadmin/pejabat');
                } else {
                    $this->session->set_flashdata('STATUS',2);
                    $this->session->set_flashdata('MSG','Gagal: Data tidak berhasil di update');
                     redirect('webadmin/pejabat/form/'.$id);
                }
            }
            
        }
    }
    
    function hapus()
    {
        $params = $this->input->post();
        if ($this->Mdl_pejabat->hapus($params['id'])){
            $data = array(
                'status'  => 1, 
                'msg' => 'Berhasil: Data telah dihapus'
            );
        } else {
            $data = array(
                'status'  => 0, 
                'msg' => 'Gagal: Data tidak berhasil dihapus'
            );  
        };
        echo json_encode($data);
    }
    
    
}