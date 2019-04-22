<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_menu extends CI_Model {
    
    function __construct() {
        parent::__construct();
        
        $this->table = array(
            'name'      => 'tbl_menu',
            'coloumn'   => array(
                'menu_id'           => array('id'=>'menu_id', 'label'=>'ID','visible'=>false, 'key'=>true, 'form'=> array(
                    'id'=>'menu_id', 'label'=>'ID', 'visible'=>true, 'format'=>'HIDDEN')
                ),
                'parent_id'         => array('id'=>'parent_id', 'label'=>'Parent','visible'=>true, 'key'=>false, 'form'=> array(
                    'id'=>'parent_id', 'label'=>'Parent', 'visible'=>true, 'format'=>'DROPDOWN')
                ),
                'menu_title'        => array('id'=>'menu_title', 'label'=>'Title','visible'=>true, 'key'=>false, 'form'=> array(
                    'id'=>'menu_title', 'label'=>'Title', 'visible'=>true, 'format'=>'TEXT')
                ),
                'menu_alias'        => array('id'=>'menu_alias', 'label'=>'Alias','visible'=>false, 'key'=>false, 'form'=> array(
                    'id'=>'menu_alias', 'label'=>'Alias', 'visible'=>true, 'format'=>'TEXT')
                ),
                'menu_link'         => array('id'=>'menu_link', 'label'=>'Link','visible'=>true, 'key'=>false, 'form'=> array(
                    'id'=>'menu_link', 'label'=>'Link', 'visible'=>true, 'format'=>'TEXT')
                ),
                'menu_type'         => array('id'=>'menu_type', 'label'=>'Type','visible'=>true, 'key'=>false, 'form'=> array(
                    'id'=>'menu_type', 'label'=>'Type', 'visible'=>true, 'format'=>'DROPDOWN')
                ),
                'menu_position'     => array('id'=>'menu_position', 'label'=>'Position','visible'=>true, 'key'=>false, 'form'=> array(
                    'id'=>'menu_position', 'label'=>'Position', 'visible'=>true, 'format'=>'DROPDOWN')
                ),
                'menu_is_active'    => array('id'=>'menu_is_active', 'label'=>'Active','visible'=>true, 'key'=>false, 'form'=> array(
                    'id'=>'menu_is_active', 'label'=>'Is Active', 'visible'=>true, 'format'=>'CHECKBOX')
                )
            ),
            'order'     => array(
                array('menu_id','asc'),
                array('menu_position','desc'),
            ),    
            'key'       => 'menu_id',
            'where'     => array(),
            'join'      => array()
        );
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
            $fields[] = 'menu_id';
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
                $data[$loop]['actions'] = '<button data-id="'.$row->menu_id.'" class=" btn-table-edit">Edit</button>&nbsp;&nbsp;<button data-id="'.$row->menu_id.'" class=" btn-table-delete">Hapus</button>';
                foreach($fields as $row_field):
                    if ($row_field != 'menu_id'){
                        $kata = $this->truncate_words($row->$row_field, 3);
                        $data[$loop]['fields'][]['key']  = $kata;
                    }
                endforeach;
                $no++;
                $loop++;
            endforeach;
            return $data;
    }
    
    function getDetail()
    {
        $data = array();
        return $data;
    }
    
    function addData()
    {
        $data = array();
        return $data;
    }
    
    function editData()
    {
        $data = array();
        return $data;
    }
    
    function deleteData($id)
    {
        $data = array();
        $this->db->where($this->table['key'], $id);
        if ($this->db->delete($this->table['name'])){
            $data = array(
                'status'    => 1,
                'msg'       => 'Data Berhasil di hapus'
            );
        } else {
            $data = array(
                'status'    => 1,
                'msg'       => 'Gagal Hapus'
            );
        }
        return $data;
    }
    
    function getMenu($themes)
    {
        $data = array();
        $this->db->where('parent_id', 0);
        $this->db->where('menu_is_active', 1);
        $this->db->order_by($this->table['order'][0][0], $this->table['order'][0][1]);
        $query = $this->db->get($this->table['name']);
        foreach($query->result() as $row):
            $child_menu = $this->childmenu($themes, $row->menu_id);            
            
            $data[] = array(
                'id'        => $row->menu_id,
                'title'     => $row->menu_title,
                'alias'     => $row->menu_alias,
                'link'      => site_url($row->menu_link),
                'CHILD_MENU_SECTION'    => $child_menu 
            );
        endforeach;
        return $data;
    }
    
    function childmenu($themes, $id)
    {
        $this->db->where('parent_id', $id);
        $this->db->where('menu_is_active', 1);
        $this->db->order_by($this->table['order'][0][0], $this->table['order'][0][1]);
        $query = $this->db->get($this->table['name']);
        foreach($query->result() as $row):
            $data['CHILD_MENU_LIST'][] = array(
                'id'        => $row->menu_id,
                'title'     => $row->menu_title,
                'alias'     => $row->menu_alias,
                'link'      => site_url($row->menu_link.'/'.$row->menu_alias),
            );
        endforeach;
        if ($query->num_rows()>0){
            $child_menu = $this->parser->parse($themes.'/layout/menu/top_child_menu', $data, true);
        } else {
            $child_menu = '';
        }
        return $child_menu;
    }
}    