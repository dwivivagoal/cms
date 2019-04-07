<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_content extends CI_Model {

        function __construct() {
            parent::__construct();
            $this->table = array(
                'name'      => 'tbl_contentweb',
                'coloumn'   => array(
                    'berita_gambar'             => array('id'=>'content_gambar', 'label'=>'Gambar', 'visible'=>true, 'key'=>false), 
                    
                    'content_id'                => array('id'=>'content_id', 'label'=>'ID', 'visible'=>false, 'key'=>true),
                    'content_nama'              => array('id'=>'content_nama', 'label'=>'Judul', 'visible'=>true, 'key'=>false),
                    'content_nama2'             => array('id'=>'content_nama2', 'label'=>'Sub Judul', 'visible'=>true, 'key'=>false),
                    'content_keterangan'        => array('id'=>'content_keterangan', 'label'=>'Keterangan', 'visible'=>false, 'key'=>false), 
                    'content_alias'             => array('id'=>'content_alias', 'label'=>'Alias', 'visible'=>false, 'key'=>false), 
                    'is-active'                 => array('id'=>'is_active', 'label'=>'Is Active', 'visible'=>false, 'key'=>false), 
                    
                    'content_created_date'      => array('id'=>'content_created_date', 'label'=>'Created Date', 'visible'=>true, 'key'=>false), 
                    'content_created_by'        => array('id'=>'content_created_by', 'label'=>'Created By', 'visible'=>false, 'key'=>false), 
                    'content_last_updated'      => array('id'=>'content_last_updated', 'label'=>'Last Update', 'visible'=>true, 'key'=>false), 
                    'content_last_updated_by'   => array('id'=>'content_last_updated_by', 'label'=>'Last Update By', 'visible'=>false, 'key'=>false)
                ),
                'order'     => 'content_id',
                'key'       => 'content_id',
                'where'     => array(),
                'join'      => array()
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
        