<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Courier extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		
	}
	
	
	public function view_courier()
	{
		
		$this->load->helper('printer');
		
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
			$tbody .= '<tr><td>'.$row->id.'</td><td>'.$row->name.'</td><td>'.$row->phone.'</td><td>'.$row->email.'</td><td>'.get_addr($addr).'</td><td>'.default_date_format($row->created_date).'</td><td><a href = "'.site_url("courier/add_courier/".$row->id).'" ><button type="button" class="btn btn-warning"><i class="glyphicon glyphicon-edit" data-toggle="tooltip" title="Modify Courier Company"></i></button></a>&nbsp<a onclick="return confirm(\'Are you sure?\')" href = "'.site_url("courier/del_courier/".$row->id).'" ><button type="button" class="btn btn-danger"><i class="glyphicon glyphicon-remove" data-toggle="tooltip" title="Delete Courier Company"></i></button></a>&nbsp</td></tr>';

			}
			
		}else{
			$tbody .= '<tr><td colspan="7" align="center">No Record Found</td></tr>';
		}
		
		$data['tbody'] = $tbody;

		$data['title'] = "Manage Courier";
		
		$this->load->template('view_orders',$data);
	}
	
	public function add_courier(){
		
		
		$edit_order_id = $this->uri->segment(3);
		$address = array('addr1' => "",'addr2' => "",'city'=>"",'state'=>"",'pincode'=>"",'country'=>"");
		if($edit_order_id){
			$order_info = $this->db->query("SELECT * FROM `prp_courier` WHERE deleted = 0 AND id =".$edit_order_id)->row_array();
			$data['name'] = $order_info['name'];
			$data['email'] = $order_info['email'];
			$data['phone'] = $order_info['phone'];
			$address =  array('addr1' => $order_info['addr1'],'addr2' => $order_info['addr2'],'city'=>$order_info['city'],'state'=>$order_info['state'],'pincode'=>$order_info['pincode'],'country'=>$order_info['country']);
			$data['action'] = "Update";
		}else{
			$data['name'] ="";
			$data['email'] = "";
			$data['phone'] = "";
			/*$data['country'] = "";*/
			$data['action'] = "Save";
		}
		if(isset($_POST['submit'])){
			//$insert_data = array('user_id'=>$this->session->userdata('adminId'),'book_id'=>$book_id,'no_of_copies' => $_POST['no_of_copies'],'shipping_address' => $_POST['shipping_address'],'order_type' => $_POST['order_type'],'order_stage' => 1,'exp_date' => date("Y-m-d H:i:s",strtotime($_POST['exp_date'])),'description' => $_POST['description'],'created_date'=>date("Y-m-d H:i:s"));
			
			if($_POST['submit'] == "Save"){
				unset($_POST['submit']);
				$_POST['created_date'] = date("Y-m-d H:i:s");
				$ins_status = insert_data('prp_courier',$_POST);	
				$edit_order_id = $this->db->insert_id();
				$msg = 'New Courier Company Added.';
			}
			else if($_POST['submit'] == "Update"){
				unset($_POST['submit']);
				$whr = array('id'=>$edit_order_id);
				$ins_status = update_data('prp_courier',$_POST,$whr);
				$msg = "Courier Company Updated.";
			}
			
			if($ins_status){
				$this->session->set_flashdata('success_message', $msg);
				redirect(site_url("courier/view_courier"),'refresh');
			}else{
				$this->session->set_flashdata('error_message', 'Error while create new courier...');
				redirect(current_url(),'refresh');
				
			}
		}
		$data['address'] = $address;
		$data['title'] = "Add Courier Companies";
		
		$this->load->template('add_courier',$data);
		
	}
	
	public function del_order(){
		$del_id = $this->uri->segment("3");
		$del_data = array('deleted'=>'1');
		$whr = array('id'=>$del_id);
		$del_status = update_data('prp_printer',$del_data,$whr);
		if($del_status){
				$this->session->set_flashdata('success_message', 'Printer deleted successfully...');
				redirect(site_url("printer/view_printer/"),'refresh');
			}else{
				$this->session->set_flashdata('error_message', 'Error while delete printer...');
				redirect(current_url(),'refresh');
				
			}
	}
	

}
