<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_menu extends CI_Model {
    
    function __construct() {
        parent::__construct();
        
        $this->table = array(
            'name'      => 'tbl_menu',
            'coloumn'   => array(
                'menu_id'           => array('id'=>'menu_id', 'label'=>'ID'),
                'parent_id'         => array('id'=>'parent_id', 'label'=>'Parent'),
                'menu_title'        => array('id'=>'menu_title', 'label'=>'Title'),
                'menu_alias'        => array('id'=>'menu_alias', 'label'=>'Alias'),
                'menu_link'         => array('id'=>'menu_link', 'label'=>'Link'),
                'menu_type'         => array('id'=>'parent_id', 'label'=>'Type'),
                'menu_position'     => array('id'=>'menu_position', 'label'=>'Position'),
                'menu_is_active'    => array('id'=>'menu_is_active', 'label'=>'Active')
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
    
    function deleteData()
    {
        $data = array();
        return $data;
    }
    
    function getMenu($themes)
    {
        $data = array();
        $this->db->where('parent_id', 0);
        $this->db->order_by($this->table['order'][0][0], $this->table['order'][0][1]);
        $query = $this->db->get($this->table['name']);
        foreach($query->result() as $row):
            $child_menu = $this->childmenu($themes, $row->menu_id);            
            
            $data[] = array(
                'id'        => $row->menu_id,
                'title'     => $row->menu_title,
                'alias'     => $row->menu_alias,
                'link'      => $row->menu_link,
                'CHILD_MENU_SECTION'    => $child_menu 
            );
        endforeach;
        return $data;
    }
    
    function childmenu($themes, $id)
    {
        $this->db->where('parent_id', $id);
        $this->db->order_by($this->table['order'][0][0], $this->table['order'][0][1]);
        $query = $this->db->get($this->table['name']);
        foreach($query->result() as $row):
            $data['CHILD_MENU_LIST'][] = array(
                'id'        => $row->menu_id,
                'title'     => $row->menu_title,
                'alias'     => $row->menu_alias,
                'link'      => $row->menu_link,
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