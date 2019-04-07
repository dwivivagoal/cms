<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_kategori extends CI_Model {

        function __construct() {
            parent::__construct();
            $this->table = array(
                'name'      => 'tbl_kategori',
                'coloumn'   => array(),
                'order'     => array('kategori_id', 'desc'),
                'key'       => 'kategori_id',
                'where'     => array(),
                'join'      => array()
            );
        } 
        
        
        function getList($params)
        {
            $this->db->order_by($this->table['order'][0], $this->table['order'][1]);
            $this->db->limit(5);
            $query = $this->db->get($this->table['name']);
            $result = $query->result();
            foreach($result as $row):
                $data[] = array(
                    'title'     => $row->kategori_nama,
                    'alias'     => url_title($row->kategori_nama),
                    'link'      => site_url()
                );
            endforeach;
            return $data;
        }
        
        function getVideoContent($kategoriid)
        {
            $this->db->order_by();
            $this->db->limit(5);
            $query = $this->db->get($this->table['name']);
            $result = $query->result();
            foreach($result as $row):
                $data[] = array(
                    'title'     => $row->kategori_nama,
                    'alias'     => url_title($row->kategori_nama),
                    'link'      => site_url()
                );
            endforeach;
            
            return $data;
        }
        
        function getImageContent($kategoriid)
        {
            $this->db->order_by($this->table['order'][0], $this->table['order'][1]);
            $this->db->limit(5);
            $query = $this->db->get($this->table['name']);
            $result = $query->result();
            foreach($result as $row):
                $data[] = array(
                    'title'     => $row->kategori_nama,
                    'alias'     => url_title($row->kategori_nama),
                    'link'      => site_url()
                );
            endforeach;
            
            return $data;
        }
        
        function getNewsContent($kategoriid)
        {
            $this->db->order_by($this->table['order'][0], $this->table['order'][1]);
            $this->db->limit(5);
            $query = $this->db->get($this->table['name']);
            $result = $query->result();
            foreach($result as $row):
                $data[] = array(
                    'title'     => $row->kategori_nama,
                    'alias'     => url_title($row->kategori_nama),
                    'link'      => site_url()
                );
            endforeach;
            
            return $data;    
        }
        
        
}