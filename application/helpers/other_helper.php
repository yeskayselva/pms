<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function order_type(){
	
	//1- admin2-vendor,3-project manager,4-support
	
	$CI =& get_instance();
	$user_type = $CI->session->userdata("user_type");
	if($user_type == "1"){
		
		return array('1'=>'Web Author Copies',  '2'=>'Refill Order','3'=>'Complimentary Copies','4'=>'Extra Author Copies');
		
	}else if($user_type == "2"){
		
		return array('2'=>'Refill Order','3'=>'Complimentary Copies','4'=>'Extra Author Copies');
		
	}else if($user_type == "3"){
		
		return array('3'=>'Complimentary Copies','4'=>'Extra Author Copies');
		
	}else if($user_type == "4"){
		
		return array('3'=>'Complimentary Copies','4'=>'Extra Author Copies');
		
	}
	
}


?>