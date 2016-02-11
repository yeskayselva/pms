<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }
	public function chckLogin()
	{
		$CI =& get_instance();
		$chkUser=get_data('globalnp_users',array('email'=>$_POST['userName'],'password'=>md5($_POST['password']),'deleted'=>0));
		if($chkUser->num_rows()){
			$userName=$chkUser->row()->name;
			$newdata = array(
                   'adminName'  => $userName,
                   'adminId'     => $chkUser->row()->id,
                   'user_type'  => $chkUser->row()->type
               );
			$CI->session->set_userdata($newdata);
			$_POST['redirect_url'] != "" ? redirect($_POST['redirect_url']) : redirect("dashboard");			
		}
		else{
			$CI->session->set_flashdata('errMsg', 'Invalid UserName and Password');
			redirect("login",'refresh');	
		}
	}
}
