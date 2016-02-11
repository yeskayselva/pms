<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Courier extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		
	}
	
	
	public function view_courier()
	{
		
		
		$seg = $this->uri->segment(3);
                              		
		$tbl_head = array('id'=>'Courier Id','name'=>'Name','phone'=>'Phone','email'=>'Email','#2'=>'Address','created_date'=>'Created Date','#1'=>'Action');

		$data = $this->get_table_info(10,3,$this->router->fetch_class(),$this->router->fetch_method(),$tbl_head);

		$tbody = "";
		
		if($data['query']->num_rows()){
			foreach($data['query']->result() as $row ){
			// 1. pending 2. verified 3. hold 4. reject
			$country_data = $this->config->item('country');
			
			$addr = array($row->addr1,$row->addr2,$row->city,$row->state,$country_data[$row->country],$row->pincode);
			//$addr = $row->addr1.','.$row->addr2.','.$row->city.','.$row->state.','.$row->country;
			$tbody .= '<tr><td>'.$row->id.'</td><td>'.$row->name.'</td><td>'.$row->phone.'</td><td>'.$row->email.'</td><td>'.get_addr($addr).'</td><td>'.default_date_format($row->created_date).'</td><td><a href = "'.site_url("courier/add_courier/".$row->id).'" ><button type="button" class="btn btn-default">Edit</button></a>&nbsp<a onclick="return confirm(\'Are you sure?\')" href = "'.site_url("courier/del_courier/".$row->id).'" ><button type="button" class="btn btn-default">Delete</button></a>&nbsp</td></tr>';

			}
			
		}else{
			$tbody .= '<tr><td colspan="7" align="center">No Record Found</td></tr>';
		}
		
		$data['tbody'] = $tbody;

		$data['title'] = "Manage Courier";
		
		$this->load->template('view_orders',$data);
	}
	
		
		
	

}
