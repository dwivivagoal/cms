<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_galeri extends CI_Model {

        function __construct() {
            parent::__construct();
            $this->table = array(
                'name'      => 'tbl_galeri',
                'coloumn'   => array(),
                'order'     => 'galeri_id',
                'key'       => 'galeri_id',
                'where'     => array(),
                'join'      => array()
            );
        } 
        
        
        function getHeadline($params)
        {
            $this->db->join('tbl_galeri_album', 'tbl_galeri_album.album_id=tbl_galeri.album_id', 'left');
            $this->db->where('galeri_type', 'image');
            $this->db->order_by($this->table['order'], 'desc');
            $this->db->limit(2);
            $query = $this->db->get($this->table['name']);
            $result = $query->result();
            foreach($result as $row):
                $image = base_url('public/images/galeri/'.$row->album_id.'/'.$row->galeri_image_name);
                
                $data[] = array(
                    'image'     => $image,
                    'title'     => $row->galeri_nama,
                    'kategori'  => $row->album_nama,
                    'link'      => site_url('galeri/'.url_title($row->galeri_nama))
                );
            endforeach;
            return $data;
        }
        
        function getVideoHeadline($params)
        {
            $this->db->join('tbl_galeri_album', 'tbl_galeri_album.album_id=tbl_galeri.album_id', 'left');
            $this->db->where('galeri_type', 'video');
            $this->db->order_by($this->table['order'], 'desc');
            $this->db->limit(2);
            $query = $this->db->get($this->table['name']);
            $result = $query->result();
            foreach($result as $row):
                $image = base_url('public/images/galeri/'.$row->album_id.'/'.$row->galeri_image_name);
                
                $data[] = array(
                    'image'     => $image,
                    'title'     => $row->galeri_nama,
                    'kategori'  => $row->album_nama,
                    'link'      => site_url('galeri/'.url_title($row->galeri_nama))
                );
            endforeach;
            return $data;
        }
        
        function getVideoKategori($params)
        {
            $fields = array(
                'COUNT(tbl_kategori.kategori_id) as jumlah',
                'tbl_kategori.kategori_id',
                'tbl_kategori.kategori_nama'
            ); 
            $this->db->select($fields);
            $this->db->join('tbl_galeri_album', 'tbl_galeri_album.album_id=tbl_galeri.album_id', 'left');
            $this->db->join('tbl_kategori', 'tbl_kategori.kategori_id=tbl_galeri_album.kategori_id', 'left');
            $this->db->where('galeri_type', 'video');
            $this->db->where('tbl_kategori.kategori_nama !=', '');
            $this->db->group_by('tbl_kategori.kategori_id');
            //$this->db->order_by('jumlah', 'desc');            
            $this->db->limit(3);
            $query = $this->db->get($this->table['name']);
            $result = $query->result();
            $no = 1;
            $data = array();
            foreach($result as $row):
                $isactive   = 'fade ';
                $active     = ' ';
                $selected = '';
            
                if ($no == 1){
                    $isactive   = 'show active';
                    $active     = 'active show';
                    $selected   = 'aria-selected="true"';
                }
                $list_array = array();
                $list_array = $this->getVideoListIndex($row->kategori_id);
                
                $data[] = array(
                    'title'         => $row->kategori_nama,
                    'alias'         => url_title($row->kategori_nama),
                    'link'          => site_url(),
                    'css_active'    => $isactive,
                    'active'        => $active,
                    'selected'      => $selected,
                    'INDEX_KATEGORI_LIST'   => $list_array
                );
                $no++;
            endforeach;
            return $data;
        }
        
        function getVideoListIndex($kategoriid)
        {
            $fields = array(
                'tbl_galeri.galeri_id',
                'tbl_galeri.galeri_nama',
                'tbl_galeri.galeri_image_name',
                'tbl_galeri.galeri_embed',
                "DATE_FORMAT(tbl_galeri.galeri_created_date, '%M %d, %Y') as publish_date",
                'tbl_galeri_album.album_id',
                'tbl_galeri_album.album_nama',
                'tbl_kategori.kategori_id',
                'tbl_kategori.kategori_nama'
            );
            $this->db->select($fields);
            $this->db->join('tbl_galeri_album', 'tbl_galeri_album.album_id=tbl_galeri.album_id', 'left');
            $this->db->join('tbl_kategori', 'tbl_kategori.kategori_id=tbl_galeri_album.kategori_id', 'left');
            $this->db->where('galeri_type', 'video');
            $this->db->where('tbl_kategori.kategori_id', $kategoriid);
            $this->db->order_by('galeri_id', 'desc');
            $this->db->limit(3);
            
            $query = $this->db->get('tbl_galeri');
            $result = $query->result();
            foreach($result as $row):
                $data[] = array(
                    'galeri_id'     => $row->kategori_id.'-'.$row->album_id.'-'.$row->galeri_id,
                    'embed'         => $row->galeri_embed,
                    'title'         => $row->galeri_nama,
                    'alias'         => url_title($row->galeri_nama),
                    'publish_date'  => $row->publish_date
                );
            endforeach;
            return $data;
        }
        
        
        function getVideo($params)
        {
            $this->db->join('tbl_galeri_album', 'tbl_galeri_album.album_id=tbl_galeri.album_id', 'left');
            $this->db->where('galeri_type', 'video');
            $this->db->order_by($this->table['order'], 'desc');
            $this->db->limit(2);
            $query = $this->db->get($this->table['name']);
            $result = $query->result();
            foreach($result as $row):
                $image = base_url('public/images/galeri/'.$row->album_id.'/'.$row->galeri_image_name);
                
                $data[] = array(
                    'image'     => $image,
                    'title'     => $row->galeri_nama,
                    'kategori'  => $row->album_nama,
                    'link'      => site_url('galeri/'.url_title($row->galeri_nama))
                );
            endforeach;
            return $data;
        }
        
        function getImage($params)
        {
            $this->db->join('tbl_galeri_album', 'tbl_galeri_album.album_id=tbl_galeri.album_id', 'left');
            $this->db->where('galeri_type', 'image');
            $this->db->order_by($this->table['order'], 'desc');
            $this->db->limit(2);
            $query = $this->db->get($this->table['name']);
            $result = $query->result();
            foreach($result as $row):
                $image = base_url('public/images/galeri/'.$row->album_id.'/'.$row->galeri_image_name);
                
                $data[] = array(
                    'image'     => $image,
                    'title'     => $row->galeri_nama,
                    'kategori'  => $row->album_nama,
                    'link'      => site_url('galeri/'.url_title($row->galeri_nama))
                );
            endforeach;
            return $data;
        }
        
        function getImagePopular($params)
        {
            $fields = array(
                'tbl_galeri.galeri_id',
                'tbl_galeri.galeri_nama',
                'tbl_galeri.galeri_image_name',
                'tbl_galeri.galeri_embed',
                "DATE_FORMAT(tbl_galeri.galeri_created_date, '%M %d, %Y') as publish_date",
                'tbl_galeri_album.album_id',
                'tbl_galeri_album.album_nama',
                'tbl_kategori.kategori_id',
                'tbl_kategori.kategori_nama'
            );
            $this->db->select($fields);
            $this->db->join('tbl_galeri_album', 'tbl_galeri_album.album_id=tbl_galeri.album_id', 'left');
            $this->db->join('tbl_kategori', 'tbl_kategori.kategori_id=tbl_galeri_album.kategori_id', 'left');
            $this->db->where('galeri_type', 'image');
            $this->db->order_by($this->table['order'], 'desc');
            $this->db->limit(4);
            $query = $this->db->get($this->table['name']);
            $result = $query->result();
            foreach($result as $row):
                $image = base_url('public/images/galeri/'.$row->album_id.'/'.$row->galeri_image_name);
                
                $data[] = array(
                    'image'     => $image,
                    'title'     => $row->galeri_nama,
                    'kategori'  => $row->album_nama,
                    'link'      => site_url('galeri/'.url_title($row->galeri_nama)),
                    'publish_date'  => $row->publish_date
                );
            endforeach;
            return $data;
        }
        
}