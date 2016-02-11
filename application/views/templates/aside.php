 <?php 
 	$user_type = $this->session->userdata('user_type');
 	$seg1 = $this->uri->segment(1);
 	$seg2 = $this->uri->segment(2);
 	$seg3 = $this->uri->segment(3);
 	$act = 'class="active"';
 	$side_bar_txt = '';
 	$side_bar = array(
 					'dashboard/index'=>array('icon'=>'fa fa-dashboard','text'=>'Dashboard'),
 					'orders/add_order'=>array('icon'=>'fa fa-tasks','text'=>'Add Order'),
 					'printer/index'=>array('icon'=>'fa fa-book','text'=>'Printer','child' => array('printer/add_printer'=>array('icon'=>'fa fa-tasks','text'=>'Add Printer'),'printer/view_printer'=>array('icon'=>'fa fa-tasks','text'=>'View Printer'))),
 					'courier1/index'=>array('icon'=>'fa fa-book','text'=>'Courier1','child' => array('courier1/add_courier1'=>array('icon'=>'fa fa-tasks','text'=>'Add Courier1'),'courier1/index'=>array('icon'=>'fa fa-tasks','text'=>'View Courier1','count' => TRUE))),
 				);
 	foreach($side_bar as $key => $value){
 		
 		if(isset($value['child'])){
 			$key_arr = explode('/',$key);
 			$act_parent = $seg1 == $key_arr[0] ? ' class="dcjq-parent active" ' : '';
 			$hide_child = $seg1 == $key_arr[0] ?  'style="display: block"' : '';
			 $side_bar_txt .= " <li class='sub-menu' >".anchor($key,"<i class='{$value['icon']}'></i><span>{$value['text']}</span>", "$act_parent")."<ul class='sub' ".$hide_child.">";
			foreach($value['child'] as $ch_key => $ch_val){
				$ch_key_arr = explode('/',$ch_key);
				$qry_count = (isset($ch_val['count'])) && ($ch_val['count'] == TRUE) ? get_num_rows($ch_key_arr[0]) : "";
				$active = ($seg1.'/'.$seg2 == $ch_key) ? $act : '';
				$side_bar_txt .=  "<li ".$active.">".anchor($ch_key,"{$ch_val['text']}$qry_count", '')."</li>";
			}
			$side_bar_txt .= "</ul></li>";
			
		}else{
			 $qry_count = (isset($ch_val['count'])) && ($ch_val['count'] == TRUE) ? get_num_rows($ch_key_arr[0]) : "";
			 $active = ($seg1.'/'.$seg2 == $key) ? $act : '';
			 $side_bar_txt .=  "<li>".anchor($key,"<i class='{$value['icon']}'></i><span>{$value['text']}$qry_count</span>", $active)."</li>";
		}
		
	}
 ?>
 <aside>
          <div id="sidebar"  class="nav-collapse ">
              <ul class="sidebar-menu" id="nav-accordion">
                  <?php echo $side_bar_txt;?>
              </ul>
          </div>
 </aside>