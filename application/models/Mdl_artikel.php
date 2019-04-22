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
    
        // last favaorite
        function getLatestListAll($title, $params)
        {
            $fields = array(
                'tbl_artikel.artikel_id',
                'tbl_artikel.artikel_judul',
                'tbl_artikel.artikel_alias',
                'tbl_artikel.artikel_doc',
                'tbl_artikel.artikel_penulis',
                'tbl_artikel.kategori_id',
                'tbl_kategori.kategori_nama',
                "DATE_FORMAT(tbl_artikel.artikel_created_date, '%M %d, %Y') as publish_date",  
            );
            $this->db->start_cache();
            $this->db->select($fields);
            $this->db->join('tbl_kategori', 'tbl_kategori.kategori_id=tbl_artikel.kategori_id', 'left');
            if ($title != 'semua'){
                $this->db->like('kategori_alias', $this->db->escape($title));
            }
            $data['total'] = $this->db->count_all_results($this->table['name']);
            
            $this->db->order_by($this->table['order'], 'desc');
            $this->db->limit(10);
            $query = $this->db->get();
            $data['filter'] = $query->num_rows();
            
            $result = $query->result();            
            foreach($result as $row):
                //$image = base_url('public/images/berita/'.$row->berita_id.'/'.$row->berita_image);
            
                $data['results'][] = array(
                        'image'         => '',
                        'title'         => $row->artikel_judul,
                        'penulis'       => $row->artikel_penulis,
                        'kategori'      => $row->kategori_nama,
                        'link'          => base_url('public/doc/artikel/'.$row->artikel_id.'/'.url_title($row->artikel_doc)),
                        'publish_date'  => $row->publish_date
                );
            endforeach;
            $this->db->stop_cache();
            $this->db->flush_cache();
            return $data;
        }
        
}


