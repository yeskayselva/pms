<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_data($tbl,$arr=NULL,$limit=NULL,$offset=NULL){
	$CI =& get_instance();
	$query = $CI->db->get_where($tbl, $arr, $limit, $offset);
	return $query;
}
function get_data_db2($tbl,$arr=NULL,$limit=NULL,$offset=NULL){
	
	$CI =& get_instance();
	
	$CI->db2 = $CI->load->database('inventory', TRUE); 
	
	$query = $CI->db2->get_where($tbl, $arr, $limit, $offset);
	
	return $query;
}
function select_data($tbl,$arr=NULL){
	$CI =& get_instance();
	if ( ! is_null($arr)){
		$query = $CI->db->query("select ".implode(',',$arr)." from ".$tbl);
		return $query;
	}
	
}
function get_table($tbl){
	$CI =& get_instance();
	$query = $CI->db->get($tbl);
	return $query;
}
function insert_data($tbl,$arr=NULL){
	$CI =& get_instance();
	$query = $CI->db->insert($tbl, $arr);
	return $query;
}
function update_data($tbl,$arr=NULL,$upd){
	$CI =& get_instance();
	$query = $CI->db->update($tbl, $arr, $upd);
	return $query;
}
function delete_data($tbl,$arr=NULL){
	$CI =& get_instance();
	$query = $CI->db->delete($tbl,$arr); 
	return $query;
}

function view_orders($order_type = NULL)
{
	$CI =& get_instance();
	
	if($order_type != NULL)
	$seg = $order_type;
	else
	$seg = $CI->uri->segment(3);
	
	$user_type = $CI->session->userdata('user_type');
	
	$whr1 = ($user_type == 1 || $user_type == 2) ? "" : " AND ord.user_id=".$CI->session->userdata('adminId');
	
	if($seg != ""){
		$whr = "";
		if($seg == 6){
			
			if($CI->input->cookie('start_date') != "" AND $CI->input->cookie('end_date') != "")
			$whr .= " AND ord.created_date between '".date("Y-m-d H:i:s", strtotime($CI->input->cookie('start_date')." 00:00:00"))."' and '".date("Y-m-d H:i:s", strtotime($CI->input->cookie('end_date')." 23:59:59"))."' ";	
			$whr .= " AND ord.order_stage=".$seg;
		}
		else if($seg == 7){
			$book_info = $CI->input->cookie('book_id1');
			$job_id = $CI->input->cookie('job_id');
			if($book_info != "" || $job_id != ""){
					if($book_info != ""){
						$book_info = explode(',',$book_info);
						$len = count($book_info);
						$book_id = $book_info[$len-1];
						$whr .= " AND ord.book_id =".$book_id;	
					}
					if($job_id != ""){
						$whr .= " AND ord.id =".$job_id;	
					}
			}else{
				$whr .= " AND ord.order_stage=".$seg;
			}
			
		}else if($seg == 3){
			$due_date = $CI->input->cookie('due_date');
			if($due_date != ""){
					$due_date = date("Y-m-d 23:59:59", strtotime($due_date) );
					$whr .= " AND print_exp_date <= '".$due_date."' ";	
			}else{
				$whr .= " AND ord.order_stage=".$seg;	
			}
		}else if($seg == 8){
			$whr .= " AND ord.reprint_order_id != 0 AND ord.order_stage= 6 ";	
		}else{
			$whr .= " AND ord.order_stage=".$seg;	
		}
	}else{
		$whr = "";
	}


	//echo 'SELECT ord.*,books.bookname as title,usr.name as name,print_exp_date FROM `prp_orders` as ord join books on ord.book_id = books.id left join prp_assign_print on prp_assign_print.order_id = ord.id left join globalnp_users as usr on ord.user_id = usr.id  WHERE ord.deleted = 0 '.$whr.$whr1;
	return 'SELECT ord.*,books.bookname as title,usr.name as name,print_exp_date FROM `prp_orders` as ord join books on ord.book_id = books.id left join prp_assign_print on prp_assign_print.deleted = 0 AND prp_assign_print.order_id = ord.id left join globalnp_users as usr on ord.user_id = usr.id  WHERE ord.deleted = 0 '.$whr.$whr1;
}

function courier($order_type = NULL)
{
	
	/*echo 'SELECT * FROM `prp_courier` as ord WHERE deleted = 0';
	exit;*/
	return 'SELECT * FROM `prp_courier` as ord WHERE deleted = 0';
}

function default_date_format($act_date,$time = FALSE){
	
	if($time)
	$format = date("jS M Y h:i A",strtotime($act_date));
	else
	$format = date("jS M Y ",strtotime($act_date));
	return $format;
	
}
function tot_letfnav_count(){
		
	$CI =& get_instance();
	
	$tot_func = $CI->config->item('order_stage');
	
	$tot_letfnav_count_arr = array();
	
	foreach($tot_func as $key => $value){
		
		$tot_letfnav_count_arr[$key] =  $CI->db->query(view_orders($key))->num_rows();
		
	}
	return $tot_letfnav_count_arr;
	
}

	
function set_config($key,$file){
	$CI =& get_instance();
	$config_data = $CI->config->item($file);
	return $config_data[$key];
	
}


function flash_message($arr){
	
	// array('success_message' => 'Your order moved to previous stage...','error_message' => 'Error order moved to previous stage...','success_url' => site_url(),'error_url'=>site_url(),'status' =>$status)''
	
	// Mandatory field 1. success_url 2. status
	
	$CI =& get_instance();
	
	$error_url = isset($arr['error_url']) ? $arr['error_url'] : $arr['success_url'];
	
	if( !isset($arr['success_message'])){
		
		$arr['success_message'] = "Your process successfully completed";
		
	}
	if( !isset($arr['error_message'])){
		
		$arr['error_message'] = "Error while update process";
		
	}
	
	if(isset($arr['status'])){
		
		$CI->session->set_flashdata('success_message',$arr['success_message']);
		
		redirect($arr['success_url'],'refresh');
		
	}else{
		
		$CI->session->set_flashdata('error_message',$arr['error_message']);
		
		redirect($error_url,'refresh');
		
	}
	


}

function download_file($from,$to){
	
	$ch = curl_init($from);
	$fp = fopen($to, 'wb');
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_exec($ch);
	curl_close($ch);
	fclose($fp);
	//file_put_contents($to, file_get_contents($from));
	
	return $to;
		
}

function get_num_rows($fun){
	$CI =& get_instance();
	$query_str =  call_user_func($fun);
	$count = $CI->db->query($query_str)->num_rows();
	$qry_count = " (".$count.")";
	return $qry_count;
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */