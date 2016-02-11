<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
  
class Print_price_calc extends CI_Table {

    public function __construct()
    {
    	
        parent::__construct();
        
    }
    public function calculator($post_data){
		/*array('printer_id'=>'printer_id',
'book_type'=>'book_type',
'quantity'=>'quantity',
'width'=>'width',
'page_count'=>'page_count',
'dust_jacket'=>'dust_jacket',
'color_page_count'=>'color_page_count')
quantity,printer_id,book_type,width,page_count,dust_jacket,color_page_count
*/
		$CI =& get_instance();
		$result = $CI->db->query('SELECT * FROM `prp_print_price` WHERE deleted=0 AND `printer_id` = '.$post_data["printer_id"].' AND book_type = '.$post_data["book_type"]);
			$calc =array();
			if($result->num_rows()){
				foreach($result->result() as $row){
					$quantity_arr = explode('-',$row->quantity);
					if(($quantity_arr[0] <= $post_data['quantity']) && ($post_data['quantity'] <= $quantity_arr[1])){
							$book_quantity = $CI->db->query('SELECT * FROM `prp_print_price` WHERE deleted=0 AND `printer_id` = '.$post_data["printer_id"].' AND book_type = '.$post_data["book_type"].' AND quantity = "'.$row->quantity.'"');
							foreach($book_quantity->result() as $row){
								$book_size_arr = explode('X',$row->book_size);
								$calc[$row->id] = $book_size_arr[0];
							}
							asort($calc);
							foreach($calc as $key => $value){
								if($post_data["width"] <= $value){
									$cost_row = get_data('prp_print_price',array('id'=>$key))->row();
									$wrapper_cost = $post_data['page_count'] <= 224 ? $cost_row->wrapper_cost : $cost_row->wrapper_cost_2;
									$dust_jacket = $post_data['dust_jacket'] == '1' ? $cost_row->dust_jacket : 0;
								/*	if($cost_row->shrink_wrapping_cost == 1){
										$shrink_wrapping_cost = $post_data['quantity'] > 20 ? "0.60" : $cost_row->shrink_wrapping_cost;
									}else{
										
									}*/
									$shrink_wrapping_cost = $cost_row->shrink_wrapping_cost;
									$color_page_count = ($post_data['color_page_count']) ;
									$page_count = $post_data['page_count'];
									if($color_page_count%2!=0)
									{
										$color_page_count++;
										
									}
									$over_all_cost = $post_data['quantity'] * (($cost_row->per_page_cost * $page_count)+($cost_row->color_per_page_cost * $color_page_count)+$wrapper_cost+$dust_jacket+$cost_row->binding_cost+$shrink_wrapping_cost);
									return round($over_all_cost,2);
								}
							}
					}
				}
			}
	}
	
}