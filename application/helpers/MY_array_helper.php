<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function isAssoc($arr)
{
    return array_keys($arr) !== range(0, count($arr) - 1);
}


function convert_key_value_string($arr,$delimeter = ' '){
	
	return implode($delimeter, array_map(
	    function ($v, $k) { 
	    	return $k.'="'.$v.'"';
	    	//return $k . = . $v; 
	    }, 
	    $arr, 
	    array_keys($arr)
	));
}

?>