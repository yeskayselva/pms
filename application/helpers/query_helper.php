<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function printer($order_type = NULL)
{
	
	return 'SELECT * FROM `prp_printer` as ord WHERE deleted = 0';
}

function view_courier($order_type = NULL)
{
	
	return 'SELECT * FROM `prp_courier` as ord WHERE deleted = 0';
}
function courier1($order_type = NULL)
{
	
	return 'SELECT * FROM `pms` as ord WHERE deleted = 0';
}

?>