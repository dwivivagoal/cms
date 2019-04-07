<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_guestbook extends CI_Model {

        function __construct() {
            parent::__construct();
            $this->table = array(
                'name'      => 'tbl_bukutanu',
                'coloumn'   => array(
                    'bukutamu_id'               => array('id'=>'bukutamu_id', 'label'=>'ID', 'visible'=>false, 'key'=>true),
                    'nama_lengkap'              => array('id'=>'nama_lengkap', 'label'=>'Judul', 'visible'=>true, 'key'=>false),
                    'email'                     => array('id'=>'email', 'label'=>'Email', 'visible'=>true, 'key'=>false),
                    'no_hp'                     => array('id'=>'no_hp', 'label'=>'No HP', 'visible'=>false, 'key'=>false), 
                    'judul_pesan'               => array('id'=>'judul_pesan', 'label'=>'Judul Pesan', 'visible'=>false, 'key'=>false), 
                    'isi_pesan'                 => array('id'=>'iside', 'label'=>'Isi Pesan', 'visible'=>false, 'key'=>false), 
                    
                    'created_date'      => array('id'=>'created_date', 'label'=>'Created Date', 'visible'=>true, 'key'=>false), 
                    'ip_address'        => array('id'=>'ip_address', 'label'=>'IP_address', 'visible'=>false, 'key'=>false), 
                    'ua'                => array('id'=>'ua', 'label'=>'User Agent', 'visible'=>true, 'key'=>false), 
                    'show_in_web'       => array('id'=>'show_in_web', 'label'=>'Active', 'visible'=>false, 'key'=>false)
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
        