<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_link extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->table = array(
            'name'      => 'tbl_link',
            'coloumn'   => array(
                'link_id'       => array('id'=>'link_id'),
                'link_title'    => array('id'=>'link_title'),
                'link_image'    => array('id'=>'link_image'),
                'link_url'      => array('id'=>'link_url')
            ),
        );  
    }
    
    
    function getListAll()
    {
        
        $query = $this->db->get($this->table['name']);
        foreach($query->result() as $row):
            $image = '';
            $data[] = array(
                'title'     => $row->link_title,
                'url'       => $row->link_url,
                'image'     => base_url('public/images/link/'.$row->link_image),
            );
        endforeach;
        return $data;
    }
    
}    