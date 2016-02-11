<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
  
class MY_Table extends CI_Table {

    public function __construct()
    {
    	
        parent::__construct();
        
    }
    public function table_header($tbl_head,$order_by,$order_by_type,$cls,$func){
		
		$asc_class = 'glyphicon-sort-by-attributes';
		
		$desc_class = 'glyphicon-sort-by-attributes-alt';
		
		$thead = '<th><input type="checkbox" name="checkall-toggle" value="" title="Check All" id="checkall"></th>';
		
		foreach($tbl_head  as $key => $value){
			 if($key != "#"){
				if($key == $order_by){
					if($order_by_type == 'asc')
					$thead .= '<th style = "max-width:150px;" > <a href="'.my_site_url($cls."/".$func.'/'.$key.'/desc').'" class="glyphicon  glyphicon-sort-by-attributes" >'.$value.'</a></th>';
					else
					$thead .=  '<th style = "max-width:150px;" > <a href="'.my_site_url($cls."/".$func.'/'.$key.'/asc').'" class="glyphicon  glyphicon-sort-by-attributes-alt" >'.$value.'</a></th>';
				}else{
					$thead .= '<th style = "max-width:150px;"> <a href="'.my_site_url($cls."/".$func.'/'.$key.'/desc').'" >'.$value.'</a></th>';
				}
				
			}else{
				$thead .= '<th style = "max-width:150px;">'.$value.'</th>';
			}
			
		}
		
		return $thead;
	}
	
	public function table_body($arr){
		
		$asc_class = 'glyphicon-sort-by-attributes';
		
		$desc_class = 'glyphicon-sort-by-attributes-alt';
		
		//$tbody = '<td><input type="checkbox" name="checkall-toggle" value="" title="Check All" class="checkall"></td>';
		$tbody = "";
		if(count($arr) > 1){
			foreach($arr  as $key => $value){
				$tbody .= '<tr>';
				foreach($value as $row_key => $row_val){
					if($row_key == 'id'){
						$tbody .= '<td><input type="checkbox" class="table_id" name = "table_id[]" value="'.$row_val.'"></td>';
					}else{
						$tbody .= '<td>'.$row_val.'</td>';	
					}
				}
				$tbody .= '</tr>';
				
			}
		}else{
			$tbody .= '<tr><td colspan="7" align="center">No Record Found</td></tr>';
		}
		
		
		return $tbody;
	}
	
	public function get_table_info($end_limit,$start_segment,$cls,$func,$tbl_head){
		
		$CI =& get_instance();
		
		$limit = $CI->uri->segment($start_segment+2)== "" ? " limit 0, $end_limit " : " limit ".$CI->uri->segment($start_segment+2).", $end_limit";
		
		$order_by = $CI->uri->segment($start_segment)=="" ? "created_date": $CI->uri->segment($start_segment); 
		
		$order_by_type = $CI->uri->segment($start_segment+1)=="" ? "desc" : $CI->uri->segment($start_segment+1);
		
		$orderBy=" ORDER BY ".$order_by." ".$order_by_type." ";
		
		$query_str = call_user_func($func);
		
		$data['link']= $CI->pagination->pagination_link(site_url($cls."/".$func."/".$order_by."/".$order_by_type),$CI->db->query($query_str)->num_rows(),$start_segment+2,$end_limit);
		
		$data['query'] = $CI->db->query($query_str.$orderBy.$limit);
		
		$data['thead'] =  $CI->table->table_header($tbl_head,$order_by,$order_by_type,$cls,$func);
		
		return  $data;
		
	}
	
}