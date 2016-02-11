<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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
		$basicUrl['sesMsg']="";
		$this->load->model("login_model");
		if($this->session->userdata("adminId")!="")
		redirect("dashboard");
		if(isset($_POST['submit'])){
			$this->login_model->chckLogin($_POST);	
		}
		if($this->session->flashdata('errMsg')!=""){
			$basicUrl['sesMsg']='<label id="password-error" class="error" for="password">'.$this->session->flashdata("errMsg").'</label>';	
		}
		$this->load->view('login',$basicUrl);
	}
	
	public function logout(){
		update_data("globalnp_users",array("updated_date"=>date("Y-m-d H:i:s")),array('id'=>$this->session->userdata('adminId')));
		$this->session->sess_destroy();
		redirect("login","refresh");
	}
	
}
