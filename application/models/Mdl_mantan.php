<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_mantan extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->table = array(
            'name'      => 'tbl_mantan',
        );
    }
    
    
    function getListMantan()
    {
        
        $this->db->order_by('mantan_urut', 'asc');
        $query = $this->db->get($this->table['name']);
        
        $data       = array();
        $data_array = array();
        $i = 1;
        foreach($query->result() as $row):
            $data_array['ITEM_LIST'][] = array(
                    'nama'          => $row->mantan_nama,
                    'pangkat'       => $row->mantan_pangkat,
                    'nik'           => $row->mantan_nik,
                    'periode'       => $row->mantan_periode,
                    'image'         => base_url('public/images/mantan/'.$row->mantan_image_nama)
            );
            $i++;
            if ($i==4){
                $data['ITEM'][] = $this->parser->parse($this->themes.'/layout/content/page/mantan_item', $data_array, true);;
                $data_array = array();
                $i=1;
            }
        endforeach;
        return $data;
    }
    
}    
