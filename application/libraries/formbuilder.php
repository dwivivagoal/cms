<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class formbuilder {
    
    protected $CI;
    
    public function __construct($params)
    {
        $CI =& get_instance();

        $CI->load->helper('url');
        $CI->load->helper('form');
        $CI->load->library('session');
    }
    
    function showFormat($name, $format, $value, $extra, $optionlist)
    {
	$extra .= ' id="'.$name.'" ';
                
        switch($format):
            default:
                $extra .= ' class="form-control"';
                $data = form_input($name, $value, $extra);
                break;
            case 'TEXTAREA':
                $extra .= ' class="form-control" style="resize:none;"';
                $data = form_textarea($name,$value, $extra);
                break;
            case 'TEXTHTML':
                $extra .= ' class="wysihtml5 form-control"';
                $data = form_textarea($name,$value, $extra);
                break;
            case 'TEXTHTML2':
                $extra .= '  style="display:none"';
                $data = form_textarea($name,$value, $extra);
                $data .= '<div name="'.$name.'" id="summernote_1"> </div>';
            break;
            case 'PASSWORD':
                $extra .= ' class="form-control"';
                $data = form_password($name,$value, $extra);
                break;
            case 'DATEPICKER':
                $extra .= ' class="form-control js-datepicker" '; 
                $data = form_input($name, $value, $extra);
                break;
            case 'DATETIMEPICKER':
                $extra .= ' class="form-control form_datetime" '; 
                $data = form_input($name, $value, $extra);
                break;
            case 'HIDDEN':
                $extra .= ' class="form-control"';
                $data = form_hidden($name, $value, $extra);
                break;
            case 'DROPDOWN':
                $extra .= ' class="form-control"';
                $data = form_dropdown($name, $optionlist, $value, $extra);
                break;
            case 'SELECT2':
                $extra .= 'class="form-control dropdown-select"  style="width:100%"';
                $data = form_dropdown($name, $optionlist, $value, $extra);
                break;
            case 'SELECT2MULTIPLE':
                $extra .= 'class="form-control dropdown-select-multiple" multiple="multiple" style="width:100%"';
                $data = form_dropdown($name, $optionlist, $value, $extra);
                break;
            case 'CHECKBOX':
                $data = form_checkbox($name, 1, $extra);
                break;
            case 'LABEL':
                /*
                $data[] = array(
                    'label'        => $this->table['coloumn'][$row]['label'],
                    'input_form'   => '<img src="'.$image.'" alt="'.$values[$row].'" style="width:150px;height:150px;">'
                );
                */
                $data = "<label class='form-control-label'>0</label>";
                break;
            case 'RADIO':
                $data = '';
                foreach ($optionlist as $row) {
                    $data .= form_radio($name, $row, $extra).$row;
                }
                break;
            case 'FILE':
                $extra .= 'class="file"';
                $data = form_upload($name, $value,$extra);
                break;
            case 'IMAGE':
                $extra .= 'class="form-control;"';
                $data = form_upload($name, $value,$extra);
                $data .= "<input type=\"hidden\" name=\"image\" id=\"image\" value=\"\" >" ;
                $data .= "<div style=\"border:solid 1px silver;width:320px;height:190px;\"><img src=\"\" id=\"imgUpload\" height=\"190\"></div>" ;
                $data .= "<div id=\"messageImage\"></div>" ;
                
                break;

            case 'IMAGE2':
                $extra .= 'class="form-control;"';
                $data = form_upload($name, $value,$extra);
                $data .= "<input type=\"hidden\" name=\"image2\" id=\"image2\" value=\"\" >" ;
                $data .= "<div style=\"border:solid 1px silver;width:320px;height:190px;\"><img src=\"\" id=\"imgUpload2\" height=\"190\"></div>" ;
                $data .= "<div id=\"messageImage\"></div>" ;
                break; 

             

            case 'JUST_IMAGE':
            $extra .= 'class="form-control;"';
            $data = '';
            $data .= "<input type=\"hidden\" name=\"image3\" id=\"image3\" value=\"\" >" ;
            $data .= "<div style=\"border:solid 1px silver;width:320px;height:190px;\"><img src=\"\" id=\"imgUpload3\" height=\"190\"></div>" ;
            $data .= "<div id=\"messageImage\"></div>" ;
            break; 

            case 'JUST_IMAGE2':
            $extra .= 'class="form-control;"';
            $data = '';
            $data .= "<input type=\"hidden\" name=\"image4\" id=\"image4\" value=\"\" >" ;
            $data .= "<div style=\"border:solid 1px silver;width:320px;height:190px;\"><img src=\"\" id=\"imgUpload4\" height=\"190\"></div>" ;
            $data .= "<div id=\"messageImage\"></div>" ;
            break; 

            case 'JUST_IMAGE3':
            $extra .= 'class="form-control;"';
            $data = '';
            $data .= "<input type=\"hidden\" name=\"image5\" id=\"image5\" value=\"\" >" ;
            $data .= "<div style=\"border:solid 1px silver;width:320px;height:190px;\"><img src=\"\" id=\"imgUpload5\" height=\"190\"></div>" ;
            $data .= "<div id=\"messageImage\"></div>" ;
            break; 
            
        endswitch;
        return $data; 
    }
    
    
    
}