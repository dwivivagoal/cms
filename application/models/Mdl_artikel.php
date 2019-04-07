<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_artikel extends CI_Model {
    
    function __construct() {
        parent::__construct();
        
        $this->table = array(
            'name'      => 'tbl_artikel',
            'coloumn'   => array(
                'artikel_id'        => array('id'=>'artikel_id', 'label'=>'ID', 'visible'=>false, 'key'=>true), 
                'kategori_id'       => array('id'=>'kategori_id', 'label'=>'Kategori', 'visible'=>true, 'key'=>false), 
                'artikel_judul'     => array('id'=>'artikel_judul', 'label'=>'Judul', 'visible'=>true, 'key'=>false), 
                'artikel_alias'     => array('id'=>'artikel_alias', 'label'=>'Alias', 'visible'=>false, 'key'=>false), 
                'artikel_isi'       => array('id'=>'artikel_isi', 'label'=>'isi', 'visible'=>false, 'key'=>false), 
                'artikel_doc'       => array('id'=>'artikel_doc', 'label'=>'Doc', 'visible'=>false, 'key'=>false), 
                'artikel_image'     => array('id'=>'artikel_image', 'label'=>'Image', 'visible'=>true, 'key'=>false), 
                'artikel_penulis'   => array('id'=>'artikel_penulis', 'label'=>'Penulis', 'visible'=>true, 'key'=>false), 
                'is_headline'       => array('id'=>'is_headline', 'label'=>'Is Headline', 'visible'=>false, 'key'=>false), 
                'artikel_created_date'  => array('id'=>'artikel_created_date', 'label'=>'Created Date', 'visible'=>true, 'key'=>false), 
                'artikel_created_by'    => array('id'=>'artikel_created_by', 'label'=>'Created By', 'visible'=>false, 'key'=>false), 
                'artikel_last_updated'  => array('id'=>'artikel_last_updated', 'label'=>'Last Update', 'visible'=>false, 'key'=>false), 
                'artikel_last_updated_by'   => array('id'=>'artikel_last_updated_by', 'label'=>'Last Update By', 'visible'=>false, 'key'=>false)
            ), 
            'order' => 'artikel_id',
            'join'  => '',
            'key'   => '',
            'where' => ''
        );      
    }
    
    function getFields()
        {
            $data = array();
            foreach($this->table['coloumn'] as $row):
                if ($row['visible']){
                    $data[] = array(
                        'label'     => $row['label']
                    );
                };
            endforeach;
            return $data;
        }
    
    function truncate_words($string,$words=20) {
            return preg_replace('/((\w+\W*){'.($words-1).'}(\w+))(.*)/', '${1}', $string);
    }
        
    function getList()
    {
            $fields = array();
            foreach($this->table['coloumn'] as $row):
                if ($row['visible']){
                    $fields[] = $row['id'];
                };
            endforeach;
            
            $this->db->select($fields);
            $this->db->order_by($this->table['order'], 'desc');
            $query = $this->db->get($this->table['name']);
            
            
            $result = $query->result();
            $no = 1;
            $loop = 0;
            foreach($result as $row):
                $data[$loop]['no']      = $no;
                $data[$loop]['actions'] = '<button>Edit</button>&nbsp;&nbsp;<button>Hapus</button>';
                foreach($fields as $row_field):
                    $kata = $this->truncate_words($row->$row_field, 3);
                    $data[$loop]['fields'][]['key']  = $kata;
                endforeach;
                $no++;
                $loop++;
            endforeach;
            return $data;
    }
    
    
}


