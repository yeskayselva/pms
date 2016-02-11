<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function get_addr($addr){
	
	$new_arr = array();
	foreach($addr as $key => $val){
		if($val != "")
		$new_arr[]=$val;
	}
	return implode(",<br>",$new_arr);
}


?>