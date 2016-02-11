<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

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
	public function index()
	{
		$data['title'] = "Dashboard";
		$data['user_type'] = $this->session->userdata('user_type');
        $data['whr'] = $data['user_type'] <= 2 ? "" : " AND user_id = " .$this->session->userdata('adminId');
		$query = $this->db->query('SELECT 
						ord.order_stage as order_stage,
						case  
						   when ord.order_stage = 1 then "New Order"
						   when ord.order_stage = 2 then "Orders approved but Not Sent" 
						   when ord.order_stage = 3 then "Orders In Print" 
						   when ord.order_stage = 4 then "Orders Printed" 
						   when ord.order_stage = 5 then "Orders Shipped" 
						   when ord.order_stage = 6 then "Orders Received" 
						end as order_status,
						COUNT(order_stage) as order_count,
						sum(no_of_copies) as quantity
						FROM `prp_orders` as ord 
						WHERE ord.deleted = 0 '.$data['whr'].'
						GROUP BY `order_stage`');
				$order_stage = $this->config->item('order_stage');
		$order_stage_cnt = "";
		foreach($order_stage as $key => $value){
				$order_count = 0;
				if($query->num_rows()){
					
					foreach($query->result() as $row){
						
						if($key == $row->order_stage)
						$order_count = $row->order_count;
						
					}				
				}
				$order_stage_cnt .= '<tr><td>'.$key.'</td><td>'.$value.'</td><td>'.$order_count.'</td></tr>';
		/*	if(key_exists($row->order_stage,$order_stage)){
				
			}*/
			//
			
		}
		$data['dashboar_data'] = $query;
		$data['order_stage_cnt'] = $order_stage_cnt;
		$this->load->template('dashboard',$data);
	}
}
