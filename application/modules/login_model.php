<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }
	public function chckLogin()
	{
		$CI =& get_instance();
		$chkUser=get_data('tbl_users',array('name'=>$_POST['userName'],'password'=>md5($_POST['password'])));
		if($chkUser->num_rows()){
			$userName=$chkUser->row()->name;
			$newdata = array(
                   'adminName'  => $userName,
                   'adminId'     => $chkUser->row()->id
               );
			$CI->session->set_userdata($newdata);
			redirect("admin/dashboard");			
		}
		else{
			$CI->session->set_flashdata('errMsg', 'Invalid UserName and Password');
			redirect("admin/login",'refresh');	
		}
	}
}
