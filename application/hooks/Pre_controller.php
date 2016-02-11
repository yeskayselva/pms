<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pre_controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//$this->load->library('session');

	}
	public function index()
	{
		$CI =& get_instance();
		$CI->load->library('session');
		if($CI->uri->segment(3) == "")
		$CI->config->set_item('add_permission',TRUE);
		else
		$CI->config->set_item('add_permission',FALSE);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */