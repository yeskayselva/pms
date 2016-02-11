<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
  
class MY_Pagination extends CI_Pagination {

    public function __construct()
    {
    	
        parent::__construct();
        
    }
    public function pagination_link($url,$tot,$uri_segment,$limit = NULL){
    	
    	if($limit!=NULL)
    	$config["per_page"]    = $limit;
    	else
    	$config["per_page"]    = 10;
		$config["base_url"]    = $url;
		
		$config['num_links']   = 3;
		
		$config['uri_segment'] = $uri_segment;
		
		$config["total_rows"]  = $tot;
		
		$config['full_tag_open'] = '<div class="dataTables_paginate paging_bootstrap pagination"><ul>';
		$config['full_tag_close'] = '</ul></div>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['next_link'] = 'Next →';
		$config['next_tag_open'] = '<li class="prev disabled">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '← Previous';
		$config['prev_tag_open'] = '<li class="next">';
		$config['prev_tag_close'] = '</li>';
		$this->initialize($config);
		
		return $this->create_links();
		
	}
	
	public function paginate_function($item_per_page, $current_page, $total_records, $total_pages)
	{
		
	    $pagination = '';
	    if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages){ //verify total pages and current page number
	        $pagination .= '<ul class="pagination">';
	       
	        $right_links    = $current_page + 3;
	        $previous       = $current_page - 3; //previous link
	        $next           = $current_page + 1; //next link
	        $first_link     = true; //boolean var to decide our first link
	       
	        if($current_page > 1){
	            $previous_link = ($previous==0)?1:$previous;
	            $pagination .= '<li class="first"><a onclick="return false" href="#" data-page="1" title="First">&laquo;</a></li>'; //first link
	            $pagination .= '<li><a onclick="return false" href="#" data-page="'.$previous_link.'" title="Previous">&lt;</a></li>'; //previous link
	                for($i = ($current_page-2); $i < $current_page; $i++){ //Create left-hand side links
	                    if($i > 0){
	                        $pagination .= '<li><a onclick="return false" href="#" data-page="'.$i.'" title="Page'.$i.'">'.$i.'</a></li>';
	                    }
	                }  
	            $first_link = false; //set first link to false
	        }
	       
	        if($first_link){ //if current active page is first link
	            $pagination .= '<li class="first active"><a href="#" onclick="return false">'.$current_page.'</a></li>';
	        }elseif($current_page == $total_pages){ //if it's the last active link
	            $pagination .= '<li class="last active"><a href="#" onclick="return false">'.$current_page.'</a></li>';
	        }else{ //regular current link
	            $pagination .= '<li class="active"><a href="#" onclick="return false">'.$current_page.'</a></li>';
	        }
	        for($i = $current_page+1; $i < $right_links ; $i++){ //create right-hand side links
	            if($i<=$total_pages){
	                $pagination .= '<li><a onclick="return false" href="#" data-page="'.$i.'" title="Page '.$i.'">'.$i.'</a></li>';
	            }
	        }
	        if($current_page < $total_pages){
	        	
	                $next_link = ($i > $total_pages)? $total_pages : $i;
	                $pagination .= '<li><a  onclick="return false" href="#" data-page="'.$next_link.'" title="Next">&gt;</a></li>'; //next link
	                $pagination .= '<li class="last"><a onclick="return false" href="#" data-page="'.$total_pages.'" title="Last">&raquo;</a></li>'; //last link
	                
	        }
	       
	        $pagination .= '</ul>';
	    }
	    return $pagination; //return pagination links
	}
}