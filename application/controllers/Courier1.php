<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Courier1 extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->tbl = 'pms';
		
	}
	
	public function index()
	{
		$this->load->helper('printer');
		
		$seg = $this->uri->segment(3);
                              		
		$tbl_head = array('name'=>'Name','phone'=>'Phone','email'=>'Email','addr'=>'Address','created_date'=>'Created Date');
		
		$data = $this->get_table_info($tbl_head);

		$tbody = array();
		
		if($data['query']->num_rows()){
			
			foreach($data['query']->result() as $row ){
			// 1. pending 2. verified 3. hold 4. reject
			$country_data = $this->config->item('country');
			
			$tbody[] = array($row->id,$row->name,$row->phone,$row->email,$row->addr,default_date_format($row->created_date));
			
			}
			
		}
		
		if($this->input->get('download') == TRUE){
			
			$this->download($tbl_head,$tbody);
			
		}
		$data['tbody'] = $this->table->table_body($tbody);
		
		$data['action_tools'] = array('add','edit','delete','download');

		$data['title'] = "Manage Courier";
		
		$this->load->template('view_orders1',$data);
	}
	
	public function add_courier1(){
		//echo 'name'
		$data['title'] = 'Add Courier Companies';
		$data['external_files'] = array('css' => base_url('assets/bootstrap-datepicker/css/datepicker.css'),'js' => array(base_url('js/bootstrap-typeahead.js'),base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.js'),base_url('js/jquery.validate.js')));
		/*$data['input_arr'] = array('form' =>array('method'=>'POST'),
			  						'text' => array('label' => array('label_name'=>'Courier Name','class' =>'col-sm-2 col-sm-2 control-label','for' => 'name_for'),'name' => 'name'),
			  						'email' => array('label' => 'Email','name' => 'email'),
			  						'number' => array('label' => 'Phone','name' => 'phone'),
			  						'textarea' => array('label' => 'Address','name' => 'addr'),
			  						'dropdown' =>array('label' => 'Order Type','name' => 'order_type','value' => array(''=>'Select Order', 'small'  => 'Small Shirt','med'    => 'Medium Shirt','large'   => 'Large Shirt','xlarge' => 'Extra Large Shirt'),'active' => 'large','onChange'=>"some_function();"),
			  						'radio' => array('label' => 'Gender','name' => 'gender','checkbox_label' => array('male' => 'Male','female'=>'Female'),'active'=>'male'),
			  						'checkbox' => array('label' => 'Status','name' => 'status','checkbox_label' => array('one' => 'One','two'=>'Two'),'active'=>'one'),
			  						'action'=>array('save','save_new','save_close','close')
			  					);*/
	
		$data['input_arr'] = array('form' =>array('method'=>'POST'),
			  						'text' => array('label' => array('label_name'=>'Courier Name','class' =>'col-sm-2 col-sm-2 control-label','for' => 'name_for'),'name' => 'name','required' => 'true'),
			  						'email' => array('label' => 'Email','name' => 'email','required' => 'true'),
			  						'number' => array('label' => 'Phone','name' => 'phone','required' => 'true'),
			  						'textarea' => array('label' => 'Address','name' => 'addr','required' => 'true'),
			  						'dropdown' =>array('label' => 'Order Type','name' => 'order_type','value' => array(''=>'Select Order', '1'  => 'Small Shirt','2'    => 'Medium Shirt','3'   => 'Large Shirt','4' => 'Extra Large Shirt'),'active' => '','onChange'=>"some_function();",'required' => 'true'),
			  						'radio' => array('label' => 'Gender','name' => 'gender','checkbox_label' => array('1' => 'Male','2'=>'Female'),'active'=>'','required' => 'true'),
			  						'action'=>array('save','save_new','save_close','close')
			  					);
		$status = $this->check_edit_insert();
		if($status == ""){
			$data['active'] = array();
		}else{
			$data['active'] = get_data($this->tbl,array('id'=>$status))->row_array();
		}
		if(isset($_POST['save']) || isset($_POST['save_new']) || isset($_POST['save_close'])){
			//$status = $this->check_edit_insert();
			if($status == ""){
				$this->save($_POST);
			}else{
				$_POST['tbl'] = $this->tbl;
				$_POST['whr'] = array('id' => $status);
				$this->update($_POST);
			}

		}
		$this->load->template('add_courier1',$data);
		
	}
	
	
}
