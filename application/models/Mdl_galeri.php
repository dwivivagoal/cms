<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_galeri extends CI_Model {

        function __construct() {
            parent::__construct();
            $this->table = array(
                'name'      => 'tbl_galeri',
                'coloumn'   => array(
                    'galeri_id'             => array('id'=>'galeri_id','label'=>'ID', 'visible'=>false, 'idkey'=>true),
                    'album_id'              => array('id'=>'album_id','label'=>'Album', 'visible'=>true, 'idkey'=>false),
                    'galeri_nama'           => array('id'=>'galeri_nama','label'=>'Nama', 'visible'=>true, 'idkey'=>false),
                    'galeri_image'          => array('id'=>'galeri_image','label'=>'File Gambar', 'visible'=>true, 'idkey'=>false),
                    'galeri_image_name'     => array('id'=>'galeri_image_name','label'=>'Nama Gambar', 'visible'=>true, 'idkey'=>false),
                    'galeri_embed'          => array('id'=>'galeri_embed','label'=>'Embed', 'visible'=>true, 'idkey'=>false),
                    'galeri_type'           => array('id'=>'galeri_type','label'=>'Type', 'visible'=>true, 'idkey'=>false),
                    'galeri_created_date'   => array('id'=>'galeri_created_date','label'=>'Created ', 'visible'=>true, 'idkey'=>false),
                    'galeri_created_by'     => array('id'=>'galeri_created_by','label'=>'Created By', 'visible'=>true, 'idkey'=>false),
                    'galeri_last_update'    => array('id'=>'galeri_last_update','label'=>'Last Update ', 'visible'=>true, 'idkey'=>false),
                    'galeri_last_update_by' => array('id'=>'galeri_last_update_by','label'=>'Last Update By', 'visible'=>true, 'idkey'=>false)
                ),
                
                'order'     => array(
                    array('galeri_id', 'desc')
                ),
                'key'       => 'galeri_id',
                'where'     => array(),
                'join'      => array(
                    array('tbl_galeri_album','tbl_galeri_album.album_id=tbl_galeri.album_id','left')
                )
            );
        } 
        
        
        function getHeadline($params)
        {
            $this->db->join('tbl_galeri_album', 'tbl_galeri_album.album_id=tbl_galeri.album_id', 'left');
            $this->db->where('galeri_type', 'image');
            $this->db->order_by($this->table['order'][0][0], $this->table['order'][0][1]);
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
            $this->db->order_by($this->table['order'][0][0], $this->table['order'][0][1]);
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
            $this->db->order_by($this->table['order'][0][0], $this->table['order'][0][1]);
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
            $this->db->order_by($this->table['order'][0][0], $this->table['order'][0][1]);
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
            $this->db->order_by($this->table['order'][0][0], $this->table['order'][0][1]);
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
            $this->db->order_by($this->table['order'][0][0], $this->table['order'][0][1]);
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
        
        function getFormFields()
        {
            $data = array();
            foreach($this->table['coloumn'] as $row):
                
                if (($row['form']['visible']) && ($row['form']['format'] != 'HIDDEN')) {
                    $data[] = array(
                        'label'     => $row['form']['label'],
                        'showfield' => $this->formbuilder->showformat($row['form']['id'], $row['form']['format'], '', '', '')
                    );
                } else {
                    $data[] = array(
                        'labelfield'    => '',
                        'showfield'     => $this->formbuilder->showformat($row['form']['id'], $row['form']['format'], '', '', '')
                    );
                }
            endforeach;
            return $data;
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
            $fields[] = 'galeri_id';
            foreach($this->table['coloumn'] as $row):
                if ($row['visible']){
                    $fields[] = $row['id'];
                };
            endforeach;
                        
            $this->db->select($fields);
            $this->db->order_by($this->table['order'][0][0], $this->table['order'][0][1]);
            $query = $this->db->get($this->table['name']);
            
            $result = $query->result();
            $no = 1;
            $loop = 0;
            foreach($result as $row):
                $data[$loop]['no']      = $no;
                $data[$loop]['actions'] = '<button data-id="'.$row->galeri_id.'" class=" btn-table-edit">Edit</button>&nbsp;&nbsp;'
                        . '<button data-id="'.$row->galeri_id.'" class=" btn-table-delete">Hapus</button>';
                foreach($fields as $row_field):
                    if ($row_field != 'galeri_id'){
                        $kata = $this->truncate_words($row->$row_field, 3);
                        $data[$loop]['fields'][]['key']  = $kata;
                    }
                endforeach;
                $no++;
                $loop++;
            endforeach;
            return $data;
    }
    
    function getFotoListAll($title, $params)
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
            //$this->db->where('tbl_kategori.kategori_id', $kategoriid);
            $this->db->order_by($this->table['order'][0][0], $this->table['order'][0][1]);
            $this->db->limit(10);
            
            $query = $this->db->get('tbl_galeri');
            $result = $query->result();
            foreach($result as $row):
                $data['results'][] = array(
                    'galeri_id'     => $row->kategori_id.'-'.$row->album_id.'-'.$row->galeri_id,
                    'image'         => base_url('public/images/galeri/'.$row->album_id.'/'.$row->galeri_image_name),
                    'title'         => $row->galeri_nama,
                    'alias'         => url_title($row->galeri_nama),
                    'kategori'      => $row->kategori_nama,
                    'publish_date'  => $row->publish_date
                );
            endforeach;
            return $data;
        }
        
        function getVideoListAll($title, $params)
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
            //$this->db->where('tbl_kategori.kategori_id', $kategoriid);
            $this->db->order_by($this->table['order'][0][0], $this->table['order'][0][1]);
            $this->db->limit(10);
            
            $query = $this->db->get('tbl_galeri');
            $result = $query->result();
            foreach($result as $row):
                $data['results'][] = array(
                    'galeri_id'     => $row->kategori_id.'-'.$row->album_id.'-'.$row->galeri_id,
                    'embed'         => $row->galeri_embed,
                    'title'         => $row->galeri_nama,
                    'alias'         => url_title($row->galeri_nama),
                    'publish_date'  => $row->publish_date
                );
            endforeach;
            return $data;
        }
        
}