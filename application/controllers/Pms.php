<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pms extends MY_Controller {

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
	
	
	public function index(){
		$this->db->select('com.id as id,cus.name as name');
		$this->db->from('arm_customer as cus');
		$this->db->join('roundrobin_companies as com', 'com.id = cus.assigned_to');
		$this->db->where('cus.assigned_to', '2'); 
		$this->db->or_where('cus.id <', 100); 
		$this->db->order_by("cus.id", "desc"); 
		$this->db->limit(10, 20);
		$query = $this->db->get();
		echo $this->db->last_query();
		//var_dump(var_dump( $this->db ));
		exit;
	}
}
