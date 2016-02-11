<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['order_type'] = array('1'=>'Web Author Copies',  '2'=>'Refill Order','3'=>'Complimentary Copies','4'=>'Extra Author Copies');
 
$config['user_type'] = array('1'=>'Admin',  '2'=>'Vendor','3'=>'Project Manager','4'=>'Support');

$config['order_stage'] = array('1' => "New Orders",
								'2' => "Orders approved",
								'3' => "Orders In Print",
								'4' => "Orders Printed",
								'5' => "Orders Shipped",
								'6' => "Orders Complete",
								'7' => "Advanced Search",
								'8' => "Reprint Order");
$config['left_menu'] = array('view_covers'=>'View Covers');
$config['country'] = array('1'=>'India','2' => 'Singapore');
$config['currency'] = array('1'=>'INR','2' => 'SGD');
$config['paymentType'] = array(
			1 => "Cheque",
			2 => "Pay U",
			3 => "Cash",
			4 => "DD",
			5 => "Neft Transfer",
			7 => "IMPS",
			6 => "Others"
		);

	$config['smtp_host'] = 'smtp.mandrillapp.com';
		$config['smtp_user'] = 'editor@notionpress.com';
		$config['smtp_pass']= 'jHVkXpV-hBLZD4Wxy1Hyzg';
		$config['from_email']= 'vendor-support@notionpress.com';
		$config['courier_mode'] = array('1' => "Surface",
								'2' => "Air",
								);
		$config['np_shipping_address'] = array('shipping_name'=>'Notion Press Media pvt ltd',
												'phone'=>'9543130105',
												'addr1' => '38 McNichols Rd',
												'addr2' => 'Chetpet',
												'city'=>'Chennai',
												'state'=>'Tamil Nadu',
												'pincode'=>'600031',
												'country'=>'1');
?>
