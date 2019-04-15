<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_berita extends CI_Model {

        function __construct() {
            parent::__construct();
            $this->table = array(
                'name'      => 'tbl_berita',
                'coloumn'   => array(
                    'berita_image'          => array('id'=>'berita_image', 'label'=>'Gambar', 'visible'=>true, 'key'=>false), 
                    
                    'berita_id'             => array('id'=>'berita_id', 'label'=>'ID', 'visible'=>false, 'key'=>true),
                    'kategori_id'           => array('id'=>'kategori_id', 'label'=>'Kategori', 'visible'=>true, 'key'=>false),
                    'berita_penulis'        => array('id'=>'berita_penulis', 'label'=>'Penulis', 'visible'=>true, 'key'=>false),
                    'berita_judul'          => array('id'=>'berita_judul', 'label'=>'Judul', 'visible'=>true, 'key'=>false), 
                    'berita_alias'          => array('id'=>'berita_alias', 'label'=>'Alias', 'visible'=>false, 'key'=>false), 
                    'berita_isi'            => array('id'=>'berita_isi', 'label'=>'Isi', 'visible'=>false, 'key'=>false), 
                    'berita_isi_singkat'    => array('id'=>'berita_isi_singkat', 'label'=>'Isi Singkat', 'visible'=>false, 'key'=>false), 
                    'berita_hari'           => array('id'=>'berita_hari', 'label'=>'Hari', 'visible'=>false, 'key'=>false), 
                    'berita_tanggal'        => array('id'=>'berita_tanggal', 'label'=>'Tgl', 'visible'=>false, 'key'=>false), 
                    'berita_jam'            => array('id'=>'berita_jam', 'label'=>'Jam', 'visible'=>false, 'key'=>false), 
                    'berita_view'           => array('id'=>'berita_view', 'label'=>'View', 'visible'=>true, 'key'=>false), 
                    'berita_is_slider'      => array('id'=>'berita_is_slider', 'label'=>'Is Slider', 'visible'=>false, 'key'=>false), 
                    'berita_created_date'   => array('id'=>'berita_created_date', 'label'=>'Created Date', 'visible'=>true, 'key'=>false), 
                    'berita_created_by'     => array('id'=>'berita_created_by', 'label'=>'Created By', 'visible'=>false, 'key'=>false), 
                    'berita_last_updated_by'=> array('id'=>'berita_last_updated_by', 'label'=>'Last Update By', 'visible'=>false, 'key'=>false)
                ),
                'order'     => 'berita_id',
                'key'       => 'berita_id',
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
        
        function getList($params)
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
        
        function getSlider($params)
        {
            $this->db->join('tbl_kategori', 'tbl_kategori.kategori_id=tbl_berita.kategori_id', 'left');
            $this->db->where('berita_is_slider', 1);
            $this->db->order_by($this->table['order'], 'desc');
            $this->db->limit(5);
            $query = $this->db->get($this->table['name']);
            $result = $query->result();
            $data = array();
            foreach($result as $row):
                $image = base_url('public/images/berita/'.$row->berita_id.'/'.$row->berita_image);
                
                $data[] = array(
                    'image'     => $image,
                    'title'     => $row->berita_judul,
                    'kategori'  => $row->kategori_nama,
                    'link'      => site_url('berita/'.url_title($row->berita_judul)),
                    'summary'   => $row->berita_isi_singkat,
                );
            endforeach;
            return $data;
        }
        
        function getHeadline($params)
        {
            $this->db->join('tbl_kategori', 'tbl_kategori.kategori_id=tbl_berita.kategori_id', 'left');
            $this->db->where('berita_is_slider', 0);
            $this->db->order_by($this->table['order'], 'desc');
            $this->db->limit(5);
            $query = $this->db->get($this->table['name']);
            $result = $query->result();
            $jml = 1;
            foreach($result as $row):
                $image = base_url('public/images/berita/'.$row->berita_id.'/'.$row->berita_image);
                if ($jml <=3){
                    $data['headline'][] = array(
                        'image'     => $image,
                        'title'     => $row->berita_judul,
                        'kategori'  => $row->kategori_nama,
                        'link'      => site_url('berita/'.url_title($row->berita_judul)),
                        'summary'   => $row->berita_isi_singkat,
                    );
                } else {
                    $data['others'][] = array(
                        'image'     => $image,
                        'title'     => $row->berita_judul,
                        'kategori'  => $row->kategori_nama,
                        'link'      => site_url('berita/'.url_title($row->berita_judul)),
                        'summary'   => $row->berita_isi_singkat,
                    );
                }
                $jml++;
            endforeach;
            return $data;
        }
        
        function getPopular($params)
        {
            $fields = array(
                'tbl_berita.berita_id',
                'tbl_berita.berita_judul',
                "DATE_FORMAT(tbl_berita.berita_created_date, '%M %d, %Y') as publish_date",
                'tbl_kategori.kategori_nama',
                'tbl_berita.berita_image',
                'tbl_berita.berita_isi_singkat',
                'tbl_berita.berita_view'
            );
            $this->db->select($fields);
            $this->db->join('tbl_kategori', 'tbl_kategori.kategori_id=tbl_berita.kategori_id', 'left');
            $this->db->where('berita_is_slider', 0);
            $this->db->order_by('berita_view', 'desc');
            $this->db->order_by($this->table['order'], 'desc');
            $this->db->limit(4);
            $query = $this->db->get($this->table['name']);
            $result = $query->result();
            $jml    = 1;
            $others = 0;
            foreach($result as $row):
                $image = base_url('public/images/berita/'.$row->berita_id.'/'.$row->berita_image);
                if ($jml ==1){
                    $data['headline'][] = array(
                        'image'     => $image,
                        'title'     => $row->berita_judul,
                        'kategori'  => $row->kategori_nama,
                        'link'      => site_url('berita/'.url_title($row->berita_judul)),
                        'summary'   => $row->berita_isi_singkat,
                        'hit'       => $row->berita_view
                    );
                } else {
                    
                    if ($others == 0 ){
                        $data['others'][] = array(
                            'image'     => $image,
                            'title'     => $row->berita_judul,
                            'kategori'  => $row->kategori_nama,
                            'link'      => site_url('berita/'.url_title($row->berita_judul)),
                            'summary'   => $row->berita_isi_singkat,
                        );
                    } else {
                        $data['others_index'][] = array(
                            'image'     => $image,
                            'title'     => $row->berita_judul,
                            'kategori'  => $row->kategori_nama,
                            'link'      => site_url('berita/'.url_title($row->berita_judul)),
                            'summary'   => $row->berita_isi_singkat,
                        );
                    }
                    $others++;
                }
                $jml++;
            endforeach;
            return $data;
        }
        
        //last reading
        function getRecent($params)
        {
            $this->db->join('tbl_kategori', 'tbl_kategori.kategori_id=tbl_berita.kategori_id', 'left');
            $this->db->order_by('berita_last_updated', 'desc');
            $this->db->limit(4);
            $query = $this->db->get($this->table['name']);
            $result = $query->result();
            foreach($result as $row):
                $image = base_url('public/images/berita/'.$row->berita_id.'/'.$row->berita_image);
                
                $data[] = array(
                    'image'     => $image,
                    'title'     => $row->berita_judul,
                    'kategori'  => $row->kategori_nama,
                    'link'      => site_url('berita/'.url_title($row->berita_judul)),
                    'summary'   => $row->berita_isi_singkat,
                );
            endforeach;
            return $data;
        }
        
        // last favaorite
        function getFavorite($params)
        {
            $this->db->join('tbl_kategori', 'tbl_kategori.kategori_id=tbl_berita.kategori_id', 'left');
            $this->db->where('berita_is_slider', 1);
            $this->db->order_by($this->table['order'], 'desc');
            $this->db->limit(5);
            $query = $this->db->get($this->table['name']);
            $result = $query->result();
            foreach($result as $row):
                $image = base_url('public/images/berita/'.$row->berita_id.'/'.$row->berita_image);
                
                $data[] = array(
                    'image'     => $image,
                    'title'     => $row->berita_judul,
                    'kategori'  => $row->kategori_nama,
                    'link'      => site_url('berita/'.url_title($row->berita_judul)),
                    'summary'   => $row->berita_isi_singkat,
                );
            endforeach;
            return $data;
        }
        
        
        
        function getDetailId($params)
        {
            
        }
        
        function getDetailAlias($alias)
        {
            $this->db->where('berita_alias', strtolower($alias));
            $this->db->order_by('berita_id', 'desc');
            $this->db->limit(1);            
            $query = $this->db->get($this->table['name']);
            $data = array();
            if ($query->num_rows()==1){
                $row = $query->row();
                $gambar = base_url('public/images/berita/'.$row->berita_id.'/'.$row->berita_image);
                
                $data = array(
                    'id'        => $row->berita_id,
                    'title'         => $row->berita_judul,
                    'isi'           => $row->berita_isi,
                    'penulis'       => $row->berita_penulis,
                    'image'         => $gambar,
                    'view'          => $row->berita_view,
                    'published'     => base_url($row->berita_tanggal)
                );
            }
            return $data;
        }
        
        
        // last favaorite
        function getLatestByCategory($params)
        {
            $fields = array(
              "berita_id",
              "SUBSTRING_INDEX(berita_judul,' ',4) as berita_judul",
              "kategori_nama",
              "berita_image",
              "DATE_FORMAT(tbl_berita.berita_created_date, '%M %d, %Y') as publish_date",  
            );
            $this->db->select($fields);
            $this->db->join('tbl_kategori', 'tbl_kategori.kategori_id=tbl_berita.kategori_id', 'left');
            $this->db->where('tbl_kategori.kategori_id',RAND(1,7));
            $this->db->order_by($this->table['order'], 'desc');
            $this->db->limit(4);
            $query = $this->db->get($this->table['name']);
            $result = $query->result();
            
            $data = array(
                'HEADLINE'  => array(),
                'OTHERS'    => array(),
            );
            $no=1;
            foreach($result as $row):
                $image = base_url('public/images/berita/'.$row->berita_id.'/'.$row->berita_image);
                
                if ($no == 1){
                    $data['HEADLINE'][] = array(
                        'image'     => $image,
                        'title'     => $row->berita_judul,
                        'kategori'  => $row->kategori_nama,
                        'link'      => site_url('berita/'.url_title($row->berita_judul)),
                        'publish_date'  => $row->publish_date
                    );
                } else {
                    $data['OTHERS'][] = array(
                        'image'     => $image,
                        'title'     => $row->berita_judul,
                        'kategori'  => $row->kategori_nama,
                        'link'      => site_url('berita/'.url_title($row->berita_judul)),
                        'publish_date'  => $row->publish_date
                    );
                }
                $no++;
            endforeach;
            return $data;
        }
        
        // last favaorite
        function getLatest($params)
        {
            $fields = array(
              "berita_id",
              "SUBSTRING_INDEX(berita_judul,' ',4) as berita_judul",
              "kategori_nama",
              "berita_image",
              "DATE_FORMAT(tbl_berita.berita_created_date, '%M %d, %Y') as publish_date",  
            );
            $this->db->select($fields);
            $this->db->join('tbl_kategori', 'tbl_kategori.kategori_id=tbl_berita.kategori_id', 'left');
            $this->db->order_by($this->table['order'], 'desc');
            $this->db->limit(4);
            $query = $this->db->get($this->table['name']);
            $result = $query->result();
            
            $no=1;
            foreach($result as $row):
                $image = base_url('public/images/berita/'.$row->berita_id.'/'.$row->berita_image);
                
                if ($no == 1){
                    $data['HEADLINE'][] = array(
                        'image'     => $image,
                        'title'     => $row->berita_judul,
                        'kategori'  => $row->kategori_nama,
                        'link'      => site_url('berita/'.url_title($row->berita_judul)),
                        'publish_date'  => $row->publish_date
                    );
                } else {
                    $data['OTHERS'][] = array(
                        'image'     => $image,
                        'title'     => $row->berita_judul,
                        'kategori'  => $row->kategori_nama,
                        'link'      => site_url('berita/'.url_title($row->berita_judul)),
                        'publish_date'  => $row->publish_date
                    );
                }
                $no++;
            endforeach;
            return $data;
        }
        
        
        
        
}        