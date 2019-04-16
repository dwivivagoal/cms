<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_pejabat extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->table = array(
            'name'      => 'tbl_pejabat',
        );
    }
    
    function getListPejabat()
    {
        $this->db->order_by('pejabat_urut', 'asc');
        $query = $this->db->get($this->table['name']);
        $data = array();
        $i = 1;
        foreach($query->result() as $row):
            if ($i<=2){
                $data['KADIS'][] = array(
                        'nama'          => $row->pejabat_nama,
                        'pangkat'       => $row->pejabat_pangkat,
                        'jabatan'       => $row->pejabat_jabatan,
                        'nik'           => $row->pejabat_nik,
                        'periode'       => $row->pejabat_periode,
                        'image'         => base_url('public/images/pejabat/'.$row->pejabat_image_name)
                );
            } else {
                $data_array = array(
                            'nama'          => $row->pejabat_nama,
                            'pangkat'       => $row->pejabat_pangkat,
                            'jabatan'       => $row->pejabat_jabatan,
                            'nik'           => $row->pejabat_nik,
                            'periode'       => $row->pejabat_periode,
                            'image'         => base_url('public/images/pejabat/'.$row->pejabat_image_name)
                );
                
                if (($i%2) == 0) {
                    $data['PEJABAT'][]['ITEM_PEJABAT'] = $this->parser->parse($this->themes.'/layout/content/page/pejabat_item', $data_array, true);                
                    $data['PEJABAT'][]['ITEM_PEJABAT'] = $this->parser->parse($this->themes.'/layout/content/page/pejabat_item_close', $data_array, true);                
                    
                } else {
                    $data['PEJABAT'][]['ITEM_PEJABAT'] = $this->parser->parse($this->themes.'/layout/content/page/pejabat_item_open', $data_array, true);                
                    $data['PEJABAT'][]['ITEM_PEJABAT'] = $this->parser->parse($this->themes.'/layout/content/page/pejabat_item', $data_array, true);                
                    $data['PEJABAT'][]['ITEM_PEJABAT'] = $this->parser->parse($this->themes.'/layout/content/page/pejabat_item_blank', $data_array, true);
                } 
            }
            $i++;
        endforeach;
        return $data;
    }
    
}    
