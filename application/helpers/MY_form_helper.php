<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function my_form($arr,$active){
	$prefix_var = 'new_';
	//$active = array('name' =>"selva",'email' => 'selva@gmail.com');
	$basic_input = array('text','email','number','password','hidden');
	foreach($arr as $key => $value){
		if(in_array($key,$basic_input)){
			if(array_key_exists($value['name'],$active)){
				$value['active'] = $active[$value['name']];
			}else{
				$value['active'] = "";
			}
			input_type($value,$key);
		}
		else if($key == 'action')
		toolbar($value);
		else{
			if(isset($value['name']) && array_key_exists($value['name'],$active)){
				$value['active'] = $active[$value['name']];
			}else{
				$value['active'] = "";
			}
			$form_fun = create_form_function($key);
			$form_fun($value);
		}
	}
	echo form_close();
	//exit;
}

function new_form($form_var){
    // We can option indivitual funciton 
	$default_attr = array('class' => "form-horizontal tasi-form",'method' => "post",'action' => '');
	$merge_arr = array_merge($default_attr,$form_var);
	$action = isset($merge_arr['action']) ? $merge_arr['action'] : '';
	unset($merge_arr['action']);
	echo form_open($action,$merge_arr);
}

function input_type($text_var,$type){
	echo '<div class="form-group">';
	if(isset($text_var['label'])){
		$lable_fun = create_form_function('label');
		$lable_fun($text_var['label'],$text_var['name']);	
		unset($text_var['label']);
	}
	$text_var['id'] = isset($text_var['id']) ? $text_var['id'] :  $text_var['name'];
	$default_attr = array('class' => "form-control",'type' => $type,'value' => set_value($text_var['name'],$text_var['active']));
	$merge_arr = array_merge($default_attr,$text_var);
	echo '<div class="col-sm-10">';
	echo form_input($merge_arr);
	echo '</div>';
	echo '</div>';
}

function new_textarea($text_var){
	echo '<div class="form-group">';
	if(isset($text_var['label'])){
		$lable_fun = create_form_function('label');
		$lable_fun($text_var['label'],$text_var['name']);	
		unset($text_var['label']);
	}
	$text_var['id'] = isset($text_var['id']) ? $text_var['id'] :  $text_var['name'];
	$default_attr = array('class' => "form-control",'type' => 'textarea','value' => set_value($text_var['name'],$text_var['active']));
	$merge_arr = array_merge($default_attr,$text_var);
	echo '<div class="col-sm-10">';
	echo form_textarea($merge_arr);
	echo '</div>';
	echo '</div>';
}

function new_checkbox($text_var){
	echo '<div class="form-group">';
	if(isset($text_var['label'])){
		$lable_fun = create_form_function('label');
		$for_name = isset($text_var['name']) ? $text_var['name'] : '';
		$lable_fun($text_var['label'],$for_name);	
		unset($text_var['label']);
	}
	$check_box_count = $text_var['checkbox_label'];
	unset($text_var['checkbox_label']);
	$text_var['id'] = isset($text_var['id']) ? $text_var['id'] :  $text_var['name'];
	$default_attr = array();
	$merge_arr = array_merge($default_attr,$text_var);
	echo '<div class="col-sm-10">';
	foreach($check_box_count as $key => $value){
		echo '<div class="checkbox">';
		echo '<label>';
		$merge_arr['value'] = $key;
		$merge_arr['checked'] = isset($merge_arr['active']) && $merge_arr['active'] == $key ? TRUE : FALSE;
		echo form_checkbox($merge_arr);
		echo $value;
		echo '</label>';
		echo '</div>';
	}
	echo '</div>';
	echo '</div>';
}

function new_radio($text_var){
	echo '<div class="form-group">';
	if(isset($text_var['label'])){
		$lable_fun = create_form_function('label');
		$for_name = isset($text_var['name']) ? $text_var['name'] : '';
		$lable_fun($text_var['label'],$for_name);	
		unset($text_var['label']);
	}
	$check_box_count = $text_var['checkbox_label'];
	unset($text_var['checkbox_label']);
	$text_var['id'] = isset($text_var['id']) ? $text_var['id'] :  $text_var['name'];
	$default_attr = array();
	$merge_arr = array_merge($default_attr,$text_var);
	echo '<div class="col-sm-10">';
	foreach($check_box_count as $key => $value){
		echo '<div class="checkbox">';
		echo '<label>';
		$merge_arr['value'] = $key;
		$merge_arr['checked'] = isset($merge_arr['active']) && $merge_arr['active'] == $key ? TRUE : FALSE;
		echo form_radio($merge_arr);
		echo $value;
		echo '</label>';
		echo '</div>';
	}
	echo '</div>';
	echo '</div>';
}

function new_dropdown($text_var){
	echo '<div class="form-group">';
	if(isset($text_var['label'])){
		$lable_fun = create_form_function('label');
		$lable_fun($text_var['label'],$text_var['name']);	
		unset($text_var['label']);
	}
	$text_var['id'] = isset($text_var['id']) ? $text_var['id'] :  $text_var['name'];
	$default_attr = array('class' => 'form-control');
	$merge_arr = array_merge($default_attr,$text_var);
	if(isset($merge_arr['value'])){
		$element = $merge_arr['value'];
		unset($merge_arr['value']);
	}else{
		$element = array();
	}if(isset($merge_arr['active'])){
		$active = $merge_arr['active'];
		unset($merge_arr['active']);
	}else{
		$active = '';
	}
	$output = convert_key_value_string($merge_arr);
	echo '<div class="col-sm-10">';
	echo form_dropdown($merge_arr['name'],$element,$active,$output);
	echo '</div>';
	echo '</div>';
}
/*
function new_text($text_var){
	echo '<div class="form-group">';
	if(isset($text_var['label'])){
		$lable_fun = create_form_function('label');
		$lable_fun($text_var['label'],$text_var['name']);	
		unset($text_var['label']);
	}
	$text_var['id'] = isset($text_var['id']) ? $text_var['id'] :  $text_var['name'];
	$default_attr = array('class' => "form-control",'type' => "text",'value' => '');
	$merge_arr = array_merge($default_attr,$text_var);
	echo '<div class="col-sm-10">';
	echo form_input($merge_arr);
	echo '</div>';
	echo '</div>';
}

function new_email($text_var){
	if(isset($text_var['label'])){
		$lable_fun = create_form_function('label');
		$lable_fun($text_var['label'],$text_var['name']);	
		unset($text_var['label']);
	}
	$text_var['id'] = isset($text_var['id']) ? $text_var['id'] :  $text_var['name'];
	$default_attr = array('class' => "form-control",'type' => "email",'value' => '');
	$merge_arr = array_merge($default_attr,$text_var);
	echo form_input($merge_arr);
}

function new_number($text_var){
	if(isset($text_var['label'])){
		$lable_fun = create_form_function('label');
		$lable_fun($text_var['label'],$text_var['name']);	
		unset($text_var['label']);
	}
	$text_var['id'] = isset($text_var['id']) ? $text_var['id'] :  $text_var['name'];
	$default_attr = array('class' => "form-control",'type' => "number",'value' => '');
	$merge_arr = array_merge($default_attr,$text_var);
	echo form_input($merge_arr);
}
*/
function new_label($label_var,$for = ''){
	$default_attr = array('class' =>'col-sm-2 col-sm-2 control-label');
	if(is_array($label_var)){
		
		if(isset($label_var['label_name'])){
			$label_name = $label_var['label_name'];
			$merge_arr = array_merge($default_attr,$label_var);
			$for = isset($merge_arr['for']) ? $merge_arr['for'] : '';
			unset($merge_arr['for'],$merge_arr['label_name']);
			echo form_label($label_var['label_name'],$for,$merge_arr);	
		}
		
	}else{
		echo form_label($label_var,$for,$default_attr);
		
	}
}

function create_form_function($key){
	
	$prefix_var = 'new_';
	
	return $prefix_var.$key;

	
}
?>