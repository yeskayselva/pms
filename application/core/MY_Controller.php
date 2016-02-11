<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	public function __construct()
	{
		
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
		if($this->session->userdata("adminId")==""){
			$this->session->set_flashdata('redirect_url', site_url(uri_string()));
				redirect("login",'refresh');
		}
		
	}
	
		
	
	public function get_table_info($tbl_head){
		
		//(CONCAT(Column1, Column2) LIKE '%keyword1%')
		
		
		$cache_name = $this->router->fetch_class().'_'.$this->router->fetch_method();
		
		$data['limit_cookie'] = $cache_name.'_limit';

		$page_limit = $this->input->cookie($data['limit_cookie']) != "" ? $this->input->cookie($data['limit_cookie']) : 10;
		
		$table_info = array('page_limit' => $page_limit,'segment' => $this->max_segment(),'cls'=>$this->router->fetch_class(),'func'=>$this->router->fetch_method(),'tbl_head' => $tbl_head);
		// $start_segment+2 - it is used for pagination which is tell pagination link start form this segment
		
		$limit = $this->uri->segment($table_info['segment']+2)== "" ? " limit 0, ".$table_info['page_limit']:" limit ".$this->uri->segment($table_info['segment']+2).", ".$table_info['page_limit'];
		
		// ord.created_date -> ord should be common alies name to all query 
		$order_by = $this->uri->segment($table_info['segment'])=="" ? "ord.created_date": $this->uri->segment($table_info['segment']); 

		$order_by_type = $this->uri->segment($table_info['segment']+1)=="" ? "desc" : $this->uri->segment($table_info['segment']+1);
		
		$orderBy=" ORDER BY ".$order_by." ".$order_by_type." ";
		
		$query_str = call_user_func($table_info['cls']);
		/*echo site_url($cls."/".$func."/".$order_by."/".$order_by_type);
		//echo $query_str.$orderBy.$limit;
		exit;*/
		$search_arr = $tbl_head;
		$data['search_cookie'] = $cache_name.'_search_param';
		$chck_search_param = $this->input->cookie($data['search_cookie']);
		if($chck_search_param != ""){
			
			foreach($search_arr as $key => $val){
				if($key[0]=="#")
				unset($search_arr[$key]);
			}
			$make_impload = array();
			foreach($search_arr as $key => $val){
				$make_impload[] = $key." LIKE '%".$chck_search_param."%'";
			}
			$imp = implode(" OR ",$make_impload);
			
			$search = " AND (".$imp.")"; 
			
		}else{
			$search = "";
		}
		
		$data['link']= $this->pagination->pagination_link(site_url($table_info['cls']."/".$table_info['func']."/".$order_by."/".$order_by_type),$this->db->query($query_str.$search)->num_rows(),$table_info['segment']+2,$table_info['page_limit']);
		
		$data['query'] = $this->input->get('downlaod') == TRUE ? $this->db->query($query_str.$orderBy) : $this->db->query($query_str.$search.$orderBy.$limit);

		$data['thead'] =  $this->table->table_header($tbl_head,$order_by,$order_by_type,$table_info['cls'],$table_info['func'],$table_info['segment']);
		
		return  $data;
		
	}
	
	
	public function save($ins){
		
		if(isset($ins['tbl'])){
			$tbl = $ins['tbl'];
			unset($ins['tbl']);
		}else if(isset($this->tbl)){
			$tbl = $this->tbl;
		}
		
		if(isset($ins['save'])){
			$save_btn = 'save';
			unset($ins['save']);
		}else if(isset($ins['save_close']) ){
			$save_btn = 'save_close';
			unset($ins['save_close']);
		}else if(isset($ins['save_new'])){
			$save_btn = 'save_new';
			unset($ins['save_new']);
		}
		$ins['created_by']=$this->session->userdata('adminId');
		$ins['updated_by']=$this->session->userdata('adminId');
		$ins['created_date']=date("Y-m-d H:i:s");
		$ins['deleted']="0";
		$ins=insert_data($tbl,$ins);
		$last_insert_id = $this->db->insert_id();
		if($save_btn == 'save'){
			$redirect_url = current_url();
		}
		else if($save_btn == 'save_close'){
			$redirect_url = my_site_url($this->router->fetch_class());
		}else if($save_btn == 'save_new'){
			$redirect_url = my_site_url($this->router->fetch_class().'/'.$this->router->fetch_method());
		}
		
		flash_message(array('status' => $ins,'success_url' => $redirect_url));
		
	}
	
	public function update($ins){
		
		if(isset($ins['tbl'])){
			$tbl = $ins['tbl'];
			unset($ins['tbl']);
		}else if(isset($this->tbl)){
			$tbl = $this->tbl;
		}
		
		if(isset($ins['whr'])){
			$whr = $ins['whr'];
			unset($ins['whr']);
		}else if(isset($this->tbl)){
			$tbl = $this->tbl;
			$whr = array('id' => $this->check_edit_insert());
		}
		
		if(isset($ins['save'])){
			$save_btn = 'save';
			unset($ins['save']);
		}else if(isset($ins['save_close']) ){
			$save_btn = 'save_close';
			unset($ins['save_close']);
		}else if(isset($ins['save_new'])){
			$save_btn = 'save_new';
			unset($ins['save_new']);
		}
		$ins['updated_by']=$this->session->userdata('adminId');
		$ins=update_data($tbl,$ins,$whr);
		$last_insert_id = $this->db->insert_id();
		if($save_btn == 'save'){
			$redirect_url = current_url();
		}
		else if($save_btn == 'save_close'){
			$redirect_url = my_site_url($this->router->fetch_class());
		}else if($save_btn == 'save_new'){
			$redirect_url = my_site_url($this->router->fetch_class().'/'.$this->router->fetch_method());
		}
		flash_message(array('status' => $ins,'success_url' => $redirect_url));
		
	}
	
	public function delete(){
		if(isset($_POST['table_id'])){
			$this->db->where_in('id', $_POST['table_id']);
			$upd = $this->db->update($this->tbl, array('deleted' =>1,'updated_by' => $this->session->userdata('adminId'))); 
			if($upd){
				$redirect_url = my_site_url($this->router->fetch_class());
			}else {
				$redirect_url = my_site_url($this->router->fetch_class());
			}
		}else{
			$upd = FALSE;
			$redirect_url = my_site_url($this->router->fetch_class());
		}
		
		flash_message(array('status' => $upd,'success_url' => $redirect_url));
		/*echo $redirect_url = my_site_url($this->router->fetch_class().'/'.$this->router->fetch_method());
		exit;
		update_data($this->tbl,array('deleted' => 1),array('id' => $id));*/
	}
	
	public function download($table_header,$tbody){

		array_unshift($table_header , 'ID');
		
		$table_data = array_merge(array(array_values($table_header)),$tbody);
		
		$file_name_path =  FCPATH.'/';	
		
		$file = date('Ymd').'_.xls';
		
		$filename = $file_name_path.$file;
		
		$this->load->library('excel');
		
		$this->excel->create_excel_file($table_data,$filename);
		
		$file_url = base_url($file);
		
		header('Content-Type: application/octet-stream');
		
		header("Content-Transfer-Encoding: Binary"); 
		
		header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 

		readfile($file_url); // do the double-download-dance (dirty but worky)

	}
	
	public function check_edit_insert(){
		$max_segment = $this->max_segment();
		return $this->uri->segment(3);
		
	}
	
	public function max_segment(){
		return 3;
	}
	
}
