<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Printer extends MY_Controller {

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
	
	
	public function view_printer()
	{
		
		$this->load->helper('printer');
		
		$seg = $this->uri->segment(3);
                              		
		$tbl_head = array('id'=>'Printer Id','name'=>'Name','phone2'=>'Contact Phone','email2'=>'Contact Email','#2'=>'Country','created_date'=>'Created Date','#1'=>'Action');

		$data = $this->get_table_info(10,3,$this->router->fetch_class(),$this->router->fetch_method(),$tbl_head);

		$tbody = "";
		
		if($data['query']->num_rows()){
			foreach($data['query']->result() as $row ){
			// 1. pending 2. verified 3. hold 4. reject
			$country_data = $this->config->item('country');
			$addr = array($row->addr1,$row->addr2,$row->city,$row->state,$country_data[$row->country],$row->pincode);
			$tbody .= '<tr><td>'.$row->id.'</td><td>'.$row->name.'</td><td>'.$row->phone2.'</td><td>'.$row->email2.'</td><td>'.get_addr($addr).'</td><td>'.default_date_format($row->created_date).'</td><td><a href = "'.site_url("printer/add_printer/".$row->id).'" ><button type="button" class="btn btn-warning"><i class="glyphicon glyphicon-edit" data-toggle="tooltip" title="Modify Printer"></i></button></a>&nbsp<a  onclick="return confirm(\'Are you sure?\')" href = "'.site_url("printer/del_order/".$row->id).'" ><button type="button" class="btn btn-danger"><i class="glyphicon glyphicon-remove" data-toggle="tooltip" title="Delete Printer"></i></button></a>&nbsp</td></tr>';

			}
			
		}else{
			$tbody .= '<tr><td colspan="7" align="center">No Record Found</td></tr>';
		}
		
		$data['tbody'] = $tbody;

		$data['title'] = "Manage Printer";
		
		$this->load->template('view_orders',$data);
	}
	
	public function add_printer(){
		
		
		$edit_order_id = $this->uri->segment(3);
		$address = array('addr1' => "",'addr2' => "",'city'=>"",'state'=>"",'pincode'=>"",'country'=>"");
		if($edit_order_id){
			$order_info = $this->db->query("SELECT * FROM `prp_printer` WHERE deleted = 0 AND id =".$edit_order_id)->row_array();
			$data['name'] = $order_info['name'];
			$data['contact_person_1'] = $order_info['contact_person_1'];
			$data['contact_person_2'] = $order_info['contact_person_2'];
			$data['contact_person_3'] = $order_info['contact_person_3'];
			$data['email1'] = $order_info['email1'];
			$data['email2'] = $order_info['email2'];
			$data['email3'] = $order_info['email3'];
			$data['phone1'] = $order_info['phone1'];
			$data['phone2'] = $order_info['phone2'];
			$data['phone3'] = $order_info['phone3'];
			$data['currency'] = $order_info['currency'];
			$address =  array('addr1' => $order_info['addr1'],'addr2' => $order_info['addr2'],'city'=>$order_info['city'],'state'=>$order_info['state'],'pincode'=>$order_info['pincode'],'country'=>$order_info['country']);
			$data['action'] = "Update";
		}else{
			$data['name'] ="";
			$data['contact_person_1'] = "";
			$data['contact_person_2'] = "";
			$data['contact_person_3'] = "";
			$data['email1'] = "";
			$data['email2'] = "";
			$data['email3'] = "";
			$data['phone1'] = "";
			$data['phone2'] = "";
			$data['phone3'] = "";
			/*$data['country'] = "";*/
			$data['currency'] = "";
			$data['action'] = "Save";
		}
		if(isset($_POST['submit'])){
			//$insert_data = array('user_id'=>$this->session->userdata('adminId'),'book_id'=>$book_id,'no_of_copies' => $_POST['no_of_copies'],'shipping_address' => $_POST['shipping_address'],'order_type' => $_POST['order_type'],'order_stage' => 1,'exp_date' => date("Y-m-d H:i:s",strtotime($_POST['exp_date'])),'description' => $_POST['description'],'created_date'=>date("Y-m-d H:i:s"));
			
			if($_POST['submit'] == "Save"){
				unset($_POST['submit']);
				$_POST['created_date'] = date("Y-m-d H:i:s");
				$ins_status = insert_data('prp_printer',$_POST);	
				$edit_order_id = $this->db->insert_id();
				$msg = 'New printer created successfully...';
			}
			else if($_POST['submit'] == "Update"){
				unset($_POST['submit']);
				$whr = array('id'=>$edit_order_id);
				$ins_status = update_data('prp_printer',$_POST,$whr);
				$msg = "Printer updated successfully....";
			}
			
			if($ins_status){
				$this->session->set_flashdata('success_message', $msg);
				redirect(site_url("printer/view_printer"),'refresh');
			}else{
				$this->session->set_flashdata('error_message', 'Error while create new printer...');
				redirect(current_url(),'refresh');
				
			}
		}
		$data['address'] = $address;
		$data['title'] = "Add Printer";
		
		$this->load->template('add_printer',$data);
		
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
	
	public function print_calc(){
		
		$data['title'] = "Printing Calculator";
		$this->load->library('Print_price_calc');
		if(isset($_POST['submit'])){
			$over_all_cost = $this->print_price_calc->calculator($_POST);
			$this->session->set_flashdata('success_message', 'Overall Printing Cost : '.$over_all_cost);
			redirect(current_url(),'refresh');
		}
		
		$this->load->template('print_calc',$data);
		
	}

	public function get_book_info(){
		
	}
}
