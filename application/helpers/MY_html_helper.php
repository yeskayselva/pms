<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function load_external_file($external_file){
	
	$prefix_var = 'load_';
	
	foreach($external_file as $key => $value){
		
		//$btn_name = is_array($value) ? $key : $value;
		if(is_array($value)){
			$btn_name = $key;
			$parameter = $value;
		}else{
			$btn_name = $key;
			$parameter = $value;
		}
		$btn_func = $prefix_var.$btn_name;
		$btn_func($parameter);
		
	}

}

function load_js($arr){
	
	$default_attr = array("type" => "text/javascript");
	if(is_array($arr) && !isAssoc($arr)){
		foreach($arr as $key => $val){
			$array_insert_data["src"] = $val;
			$merge_arr = array_merge($default_attr,$array_insert_data);
			echo '<script '.convert_key_value_string($merge_arr).'></script>';
		}
	}else if($arr !=""){
	 	$array_insert_data["src"] = $arr;
		$merge_arr = array_merge($default_attr,$array_insert_data);
		echo '<script '.convert_key_value_string($merge_arr).'></script>';
	}
	
}

function load_css($arr){
	
	$default_attr = array('rel'=>'stylesheet','type'=>'text/css');
	if(is_array($arr) && !isAssoc($arr)){
		foreach($arr as $key => $val){
			$array_insert_data["href"] = $val;
			$merge_arr = array_merge($default_attr,$array_insert_data);
			echo '<link '.convert_key_value_string($merge_arr).'/>';
		}
	}else if($arr !=""){
	 	$array_insert_data["href"] = $arr;
		$merge_arr = array_merge($default_attr,$array_insert_data);
		echo '<link '.convert_key_value_string($merge_arr).'/>';
	}
}

?>