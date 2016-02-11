<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		
	}
	
	
	public function view_orders()
	{

		$seg = $this->uri->segment(3);
        $this->load->helper('printer');
        $user_type = $this->session->userdata('user_type');
        $view_print = "";  
		$tbl_head = array('id'=>'#','title'=>'Book Name','name'=>'Ord By','#1'=>'No of Copies','#2'=>'Ins','#3'=>'To Addr','exp_date'=>'Exp Date','order_type'=>'Ord Type','created_date'=>'Created Date');
		if($seg >'2')
		unset($tbl_head["#2"]);
		if($seg >= 5){
				$tbl_head['#9.5'] = 'Ship-Date';
		}
		
		if($seg == 1){
			if($user_type <= 2){
				$tbl_head['#4'] = 'Printer';
				$tbl_head['#4.5'] = 'Courier Mode';
				/*$tbl_head['#5'] = 'Print Cost';*/		
				$tbl_head['#6'] = 'Print Exp Date';	
				$tbl_head['#6.5'] = 'File Origin';			
				$tbl_head['#10'] = 'Action';	
				$move_print = "<td>".$this->printer_dropdown()."</td><td>".$this->courier_mode_dropdown()."</td><td><input type='text' size='10' class='form-control datepicker print_exp_date' value=''/></td><td class = 'file_origin'>".$this->file_orign_dropdown()."</td>";
			}else{
				$tbl_head['#10'] = 'Action';
				$move_print = "";
			}
		}else if($seg == 4){
				if($user_type <= 2){
					$tbl_head['#4'] = 'Printer';
					$tbl_head['#4.5'] = 'Courier Mode';
					$tbl_head['#5'] = 'Print Cost';		
					$tbl_head['#5.2'] = 'Print Cost + Vat';		
					$tbl_head['#5.3'] = 'Received Amount';				
					$tbl_head['#5.5'] = 'Prod. Per Copy';
					$tbl_head['#5.4'] = 'Total Prod. Cost';		
					$tbl_head['#5.6'] = 'Net Prod. Cost';	
					$tbl_head['#5.7'] = 'TPC - PC';		
					$tbl_head['#6'] = 'Print Exp Date';
					$tbl_head['#6.5'] = 'File Origin';
					$tbl_head['#7'] = 'Courier';
					$tbl_head['#8'] =  'Courier Track No';		
					$tbl_head['#10'] = 'Action';	
					$move_print = "<td>".$this->courier_dropdown()."</td><td><input type='text' id='courier_track_no' name='courier_track_no' class='courier_track_no' value=''/></td>";
				}else{
					$tbl_head['#6'] = 'Print Exp Date';
					//$tbl_head['#10'] = 'Action';
					$move_print = "";
				}
				
		}
		else{
			if($user_type <= 2){
				$tbl_head['#4'] = 'Printer';
				$tbl_head['#4.5'] = 'Courier Mode';
				$tbl_head['#5'] = 'Print Cost';
				$tbl_head['#5.2'] = 'Print Cost + Vat';	
				$tbl_head['#5.3'] = 'Received Amount';				
				$tbl_head['#5.5'] = 'Prod. Per Copy';
				$tbl_head['#5.4'] = 'Total Prod. Cost';		
				$tbl_head['#5.6'] = 'Net Prod. Cost';	
				$tbl_head['#5.7'] = 'TPC - PC';	
				$tbl_head['#6'] = 'Print Exp Date';	
				$tbl_head['#6.5'] = 'File Origin';
				if($seg != 2 && $seg != 3){
					$tbl_head['#7'] = 'Courier';
					$tbl_head['#8'] =  'Courier Track No';		
				}
				if($seg != 2)
				$tbl_head['#10'] = 'Action';	
			}else{
				
				$tbl_head['#4'] = 'Print Exp Date';
				if($seg != 2 && $seg != 3){
					$tbl_head['#7'] = 'Courier';
					$tbl_head['#8'] =  'Courier Track No';	
				}	
			}
			$move_print = "";
		}
		
		if($seg == 7){
			unset($tbl_head['#10']);
			$tbl_head['#15'] = "Ord Stage";
			//11 - Reprint, 12 - 
		}
		if($seg == 8){
			unset($tbl_head['#10']);
			$tbl_head['#12'] = "Ord id";
			$tbl_head['#13'] = "Fault By";
			$tbl_head['#14'] = "Re-Desc";
		}
		if($user_type == "3")
		unset($tbl_head['#10']);
		
		if($seg == 2 && $user_type <= 2){
			$tbl_head['#10'] = 'Action';
		}
		
		$data = $this->get_table_info(50,4,$this->router->fetch_class(),$this->router->fetch_method(),$tbl_head);
		
		$tbody = "";
		$downlaod_data[] = array_values($tbl_head);
		/*var_dump($data['query']->result());
		exit;*/
		if($data['query']->num_rows()){
			foreach($data['query']->result() as $row ){
				if($row->user_id == '100') 
				$user_name = 'Web -'.$row->store_order_id;
				else 
				$user_name = $row->name;
				if($seg != 1){
					if($seg == 6 && $this->input->cookie('printer') != ""){
						$whr = " AND prnt.id = ".$this->input->cookie('printer')." ";	
					}else{
						$whr = "";
					}
					$assign_print_arr =$this->db->query("select *,prnt.id as printer_id from prp_assign_print as assign join prp_printer as prnt on prnt.deleted=0 and prnt.id = assign.printer_id  where assign.deleted=0 and assign.order_id = ".$row->id.$whr);
					
					if($assign_print_arr->num_rows()){
						$assign_print = $assign_print_arr->row();
						if($this->session->userdata('user_type') <= 2){
							$file_origin = $this->file_origin_info($row->book_id,$assign_print->printer_id);
							$production_cost_per_copy = $this->production_cost($row->book_id);
							$receive_amount = $this->receive_amount($row->id);
							$cost_diff = $receive_amount - $assign_print->print_cost_vat;
							$production_cost = $production_cost_per_copy*$row->no_of_copies;
							$tpc_pc = $production_cost - $assign_print->print_cost_vat;
							$courier_mode = $this->config->item('courier_mode');
							$due_date = $seg == 3 ?  $this->duedata($assign_print->print_exp_date) : "";
							$view_print = "<td>".$assign_print->name."</td><td>".$courier_mode[$row->courier_mode]."</td><td>".number_format((float)$assign_print->print_cost,2)."</td><td>".number_format((float)$assign_print->print_cost_vat)."</td><td>".number_format($receive_amount)."</td><td>".number_format((float)$production_cost_per_copy)."</td><td>".number_format((float)$production_cost)."</td><td>".number_format((float)$cost_diff)."</td><td>".number_format($tpc_pc)."</td><td>".default_date_format($assign_print->print_exp_date).$due_date."</td><td class = 'file_origin'>$file_origin</td>";	
						}
						else
						$view_print = "<td>".default_date_format($assign_print->print_exp_date)."</td>";	
					}else if($seg == 7 && $user_type <= 2 ){
							$view_print = "<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td class = 'file_origin'></td>";	
					}else if($seg == 7){
							$view_print = "";	
					}
				}
				$courier_view_arr =$this->db->query("select cour.name as name,assign.courier_track_no from prp_assign_courier as assign join prp_courier as cour on cour.deleted=0 and cour.id = assign.courier_id  where assign.deleted=0 and assign.order_id = ".$row->id);
				if($courier_view_arr->num_rows()){
					$courier_view_arr = $courier_view_arr->row();
					if($seg == 5 || $seg == 6 || $seg == 7 || $seg == 8){
						$courier_view = "<td>".$courier_view_arr->name."</td><td>".$courier_view_arr->courier_track_no."</td>";
						if($seg == 8)
						$courier_view .= "<td>".$row->reprint_order_id."</td><td>".$this->printer_name($row->repritnt_reason_from_id)."</td><td>".$row->reprint_desc."</td>";
					}else{
						$courier_view = "";
					}	
				}else if($seg == 7){
					$courier_view = "<td></td><td></td>";
				}else{
						$courier_view = "";
				}
				if($seg == 7){
					$order_stage = $this->config->item('order_stage');	
					$order_stage_view = "<td>".$order_stage[$row->order_stage]."</td>";	
				}else{
					$order_stage_view = "";
				}
				$country_data = $this->config->item('country');
				$addr = array($row->shipping_name,$row->addr1,$row->addr2,$row->city,$row->state,$country_data[$row->country],$row->pincode,$row->phone);
			// 1. pending 2. verified 3. hold 4. reject
			$access_level = $user_type != "3" ? $this->access_level($row->id) : "";

			 $ins =  $seg <= '2' ? "<td>".$row->description."</td>" : "";
			$ship_date = $seg >= 5 ? "<td>".default_date_format($row->shipped_date)."</td>" : "";
			//if($assign_print_arr->num_rows() && $seg == 5)
			if($seg == 6){
				if($assign_print_arr->num_rows()){
					if(isset($_POST['download']) && $_POST['download'] == 'download'){

						$downlaod_data[] = array($row->id,$row->title,$user_name,$row->no_of_copies,$row->description,get_addr($addr),default_date_format($row->exp_date),set_config($row->order_type,"order_type"),default_date_format($row->created_date),$assign_print->name,$courier_mode[$row->courier_mode],$assign_print->print_cost,$assign_print->print_cost_vat,$receive_amount,$production_cost_per_copy,$production_cost,$cost_diff,$tpc_pc,default_date_format($assign_print->print_exp_date),$file_origin,$courier_view_arr->name,$courier_view_arr->courier_track_no);
					}
					else
					$tbody .= '<tr order_id="'.$row->id.'" book_id="'.$row->book_id.'" quantity="'.$row->no_of_copies.'"><td>'.$row->id.'</td><td>'.$row->title.'</td><td>'.$user_name.'</td><td>'.$row->no_of_copies.'</td>'.$ins.'<td>'.get_addr($addr).'</td><td>'.default_date_format($row->exp_date).'</td><td>'.set_config($row->order_type,"order_type").'</td><td>'.default_date_format($row->created_date,TRUE).'</td>'.$ship_date.$view_print.$courier_view.$move_print.$order_stage_view.$access_level.'</tr>';	
				}
			}else{
				$tbody .= '<tr order_id="'.$row->id.'" book_id="'.$row->book_id.'" quantity="'.$row->no_of_copies.'"><td>'.$row->id.'</td><td>'.$row->title.'</td><td>'.$user_name.'</td><td>'.$row->no_of_copies.'</td>'.$ins.'<td>'.get_addr($addr).'</td><td>'.default_date_format($row->exp_date).'</td><td>'.set_config($row->order_type,"order_type").'</td><td>'.default_date_format($row->created_date,TRUE).'</td>'.$ship_date.$view_print.$courier_view.$move_print.$order_stage_view.$access_level.'</tr>';	
			}
			
		}
			
		}else{
			$tbody .= '<tr><td colspan="21" align="center">No Orders Found</td></tr>';
		}
		if(isset($_POST['download']) && $_POST['download'] == 'download'){
				echo $this->download_report("data_export_" . date("Y-m-d") . ".csv",$downlaod_data);
				die();	
		}
		
		 if( $this->session->userdata('user_type') <= 2 && $data['query']->num_rows() ){
             $data['approve_btn'] =  '<a  onclick="return confirm(\'Are you sure you want send this orders to printer ?\')"  href="'.site_url("print_cron/send_order").'" ><button type="button" class="btn btn-danger">Send Orders Manually</button></a>';
          }else{
		  	$data['approve_btn'] = "";
		  }
		$data['tbody'] = $tbody;
		
		$arr = $this->config->item('order_stage');

		$data['title'] = $arr[$seg];
		
		$this->load->template('view_orders',$data);
	}
	
	public function add_order(){
		$data['title'] = "Add New Print Order";
		$this->load->helper('email');
		$edit_order_id = $this->uri->segment(3);
		$reprint_order = $this->input->get('reprint_order');
		$user_type = $this->session->userdata('user_type');
		$data['user_type'] = $user_type;
		$address = array('addr1' => "",'addr2' => "",'city'=>"",'state'=>"",'pincode'=>"",'country'=>"");
		//$address =  $user_type == 2 ?  array('addr1' => '38, McNichols Rd','addr2' => 'Chetpet','city'=>'Chennai','state'=>'Tamil Nadu','pincode'=>'600031','country'=>'1') : array('addr1' => "",'addr2' => "",'city'=>"",'state'=>"",'pincode'=>"",'country'=>"");
		if($edit_order_id){
			$order_info = $this->db->query("SELECT ord.*,pay.id as id,order_type,no_of_copies,exp_date,description,payment,payment_type,payment_date,concat(books.bookname,',',ord.book_id) as book_id FROM `prp_orders` as ord 
											LEFT JOIN prp_payment as pay on pay.deleted = 0 AND pay.order_id = ord.id
											JOIN books on  books.id = ord.book_id 
											WHERE ord.deleted = 0 AND ord.id =".$edit_order_id)->row_array();

			$data['order_type'] = $order_info['order_type'];
			$data['user_id'] = $order_info['user_id'];
			$data['no_of_copies'] = $order_info['no_of_copies'];
			$data['exp_date'] = date("d-m-Y",strtotime($order_info['exp_date']));
			$data['description'] = $order_info['description'];
			$data['shipping_name'] = $order_info['shipping_name'];
			$data['phone'] = $order_info['phone'];
			$data['payment'] = $order_info['payment'];
			$data['payment_type'] = $order_info['payment_type'];
			$data['payment_date'] = date("d-m-Y",strtotime($order_info['payment_date']));
			$data['book_id'] = $order_info['book_id'];
			$data['repritnt_reason_from_id'] = $order_info['repritnt_reason_from_id'];
			$data['reprint_desc'] = $order_info['reprint_desc'];
			if($reprint_order != ""){
				if(!$order_info['reprint_order_id']){
					$data['action'] = "Save";
					$data['title'] = "Add Reprint Print Order";
				}else{
					$data['action'] = "Update";
					$data['title'] = "Update Reprint Print Order";
				}	//$data['action'] = $reprint_order != "" ? "Save" : "Update";
			}
			else{
				$data['title'] = "Update Print Order";
				$data['action'] = "Update";
			}
			$address =  array('addr1' => $order_info['addr1'],'addr2' => $order_info['addr2'],'city'=>$order_info['city'],'state'=>$order_info['state'],'pincode'=>$order_info['pincode'],'country'=>$order_info['country']);
		}else{
			$data['order_type'] = "";
			$data['user_id'] = "";
			$data['no_of_copies'] = "";
			$data['exp_date'] = "";
			$data['shipping_name'] =  "";
			$data['phone'] =  "";
			$data['description'] ="";
			$data['payment'] = "";
			$data['payment_type'] = "";
			$data['payment_date'] = "";
			$data['book_id'] = "";
			$data['repritnt_reason_from_id'] = "";
			$data['reprint_desc'] = "";
			$data['action'] = "Save";
		}
		if(isset($_POST['submit'])){
			$post_data = $_POST;
			$book_info = explode(',',$_POST['book_id']);
			$len = count($book_info);
			$book_id = $book_info[$len-1];
			$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : $this->session->userdata("adminId");
			$insert_data = array('user_id'=>$user_id,'shipping_name'=>$_POST['shipping_name'],'phone'=>$_POST['phone'],'book_id'=>$book_id,'no_of_copies' => $_POST['no_of_copies'],'addr1' => $_POST['addr1'],'addr2' => $_POST['addr2'],'city' => $_POST['city'],'state' => $_POST['state'],'country' => $_POST['country'],'pincode' => $_POST['pincode'],'order_type' => $_POST['order_type'],'order_stage' => 1,'exp_date' => date("Y-m-d H:i:s",strtotime($_POST['exp_date'])),'description' => $_POST['description'],'created_date'=>date("Y-m-d H:i:s"));
			if($reprint_order != ""){
				$insert_data['repritnt_reason_from_id'] = 	$_POST['repritnt_reason_from_id'];	
				$insert_data['reprint_desc'] = 	$_POST['reprint_desc'];	
				$insert_data['reprint_order_id'] = 	$reprint_order;	
			}
			if($_POST['submit'] == "Save"){
				$success_msg = "Order has been added.";
				$ins_status = insert_data('prp_orders',$insert_data);	
				$edit_order_id = $this->db->insert_id();
			}
			else if($_POST['submit'] == "Update"){
				$success_msg = "Order has been updated.";
				$whr = array('id'=>$edit_order_id);
				$order_old_info = get_data('prp_orders',$whr)->row();
				$ins_status = update_data('prp_orders',$insert_data,$whr);
				if($ins_status){
					if($order_old_info->order_type != $_POST['order_type'] && $order_old_info->order_type == 4)
					update_data('prp_payment',array('deleted'=>'1'),array('order_id' => $edit_order_id));
				}
				
			}
			
			if($ins_status){
				$ins_status = $this->insert_payment($edit_order_id,$post_data);	
				/*if($_POST['order_type'] == 4){
					$ins_status = $this->insert_payment($edit_order_id,$post_data);	
				}*/
			}
			//if($this->session->userdata('user_type') > 2){
				
				if($_POST['submit'] == "Save"){
						$template = 3;
						$email_row = get_data('prp_email_template',array('id'=>$template))->row();
						$content = $email_row->content;
						$subject = $email_row->subject;
						$book_name = get_data('books',array('id'=>$book_id))->row()->bookname;
						$subject = str_replace(array("#ORDERID#"),array($edit_order_id),$subject);
						$content = str_replace(array("#BOOKID#"," #BOOKNAME#","#USERNAME#","#QUANTITY#","#ORDERID#"), array($book_id,$book_name,$this->session->userdata('adminName'),$_POST['no_of_copies'],$edit_order_id), $content);
						$to = get_data('globalnp_users',array('id'=>$user_id))->row()->email;
						sendEmail($to,$template,NULL,$content,$subject);
				}
				
			//}

			if($ins_status){
				$this->session->set_flashdata('success_message', $success_msg);
				redirect(site_url("orders/view_orders/1"),'refresh');
			}else{
				$this->session->set_flashdata('error_message', 'Error while updated order...');
				redirect(current_url(),'refresh');
				
			}
		}
		$data['address'] = $address;
		/*echo $data['user_id'];
		exit;*/
		$data['np_shipping_address'] = json_encode($this->config->item('np_shipping_address'));
		$this->load->template('add_order',$data);
		
	}
	
	public function ajax_book_info(){
		
		$search_cont = $_POST['query'];
		
		if(!empty($_POST["query"])) {
			$query = $this->db->query("SELECT CONCAT(bookname,',',id) as name FROM books WHERE status=0 and published=1 and (bookname LIKE '%".$search_cont."%' OR id LIKE '%".$search_cont."%') LIMIT 0,10");
			//$result = $db_handle->runQuery($query);
			if($query->num_rows()) {
				echo '<ul id="country-list">';
				foreach($query->result_array() as $country) {
					echo "<li class='selectCountry' >".$country["name"]."</li>";
				}
				echo '</ul>';
			}
		}

	}
	
	public function ajax_advanced_search_auto(){
		$CI =& get_instance();
		$CI->db2 = $CI->load->database('inventory', TRUE); 
		$search_cont = $_POST['query'];
		//echo "SELECT CONCAT(bookname,',',books.id,',',bookfront.value) as name FROM books LEFT join bookfront on bookfront.bookid = books.id AND bookfront.name = 'assignedisbn' WHERE status=0 and published=1 and (bookname LIKE '%".$search_cont."%' OR books.id LIKE '%".$search_cont."%' OR bookfront.value LIKE '%".$search_cont."%') LIMIT 0,10";
		if(!empty($_POST["query"])) {
			$query = $CI->db2->query("SELECT CONCAT(title,',',isbn,',',bookid) as name FROM storelisting WHERE deleted=0 and (title LIKE '%".$search_cont."%' OR bookid LIKE '%".$search_cont."%' OR isbn LIKE '%".$search_cont."%') LIMIT 0,10");
			//$result = $db_handle->runQuery($query);
			if($query->num_rows()) {
				echo '<ul id="country-list">';
				foreach($query->result_array() as $country) {
					echo "<li class='selectCountry' >".$country["name"]."</li>";
				}
				echo '</ul>';
			}
		}

	}
	
	
	public function insert_payment($order_id,$post_data){
		/*if($post_data['order_type'] == 4){
		}*/
		$payment = isset($post_data['payment']) ? $post_data['payment'] : 0;
		$payment_type = (isset($post_data['payment_type']) && $post_data['payment_type'] != "") ? $post_data['payment_type'] : 6;
		$payment_date = (isset($post_data['payment_date']) && $post_data['payment_date'] != "") ? date("Y-m-d H:i:s",strtotime($post_data['payment_date'])) : date("Y-m-d H:i:s");
		$payment_data = array('order_id'=>$order_id,'payment'=>$payment,'payment_type'=>$payment_type,'payment_date'=>$payment_date,'created_date'=>date("Y-m-d H:i:s"));	
		$ins_status = insert_data('prp_payment',$payment_data);
		return $ins_status;
	}
	
	public function del_order(){
		$del_id = $this->uri->segment("3");
		$del_data = array('deleted'=>'1');
		$whr = array('id'=>$del_id);
		$del_status = update_data('prp_orders',$del_data,$whr);
		$del_status =  update_data('prp_payment',$del_data,array('order_id'=>$del_id));
		if($del_status){
				$this->session->set_flashdata('success_message', 'Your order deleted successfully...');
				redirect(site_url("orders/view_orders/1"),'refresh');
			}else{
				$this->session->set_flashdata('error_message', 'Error while delete order...');
				redirect(current_url(),'refresh');
				
			}
	}
	
	public function move_to_previous(){
		$order_id = $this->uri->segment(3);
		$del_data = array('deleted'=>'1');
		$whr = array('order_id'=>$order_id);
		$del_assign_printer = update_data('prp_assign_print',$del_data,$whr);
		$move_to_previous =  update_data('prp_orders',array('order_stage' => '1'),array('id'=>$order_id));
		if($move_to_previous){
			$this->session->set_flashdata('success_message', 'Your order moved to previous stage...');
			redirect(site_url("orders/view_orders/1"),'refresh');
		}else{
			$this->session->set_flashdata('error_message', 'Error order moved to previous stage...');
			redirect(current_url(),'refresh');
			
		}
	}
	
	public function move_order(){
		$this->load->helper("email");
		extract($_POST);
		$whr = array('id'=>$order_id);
		$prp_order_row = get_data('prp_orders',array('id'=>$order_id))->row();
		if($prp_order_row->order_type == 1)
		$email_template = 4;
		else if($prp_order_row->order_type == 3)
		$email_template = 2;
		else
		$email_template = 5;
		$redirect_id = $prp_order_row->order_stage;
		$book_id = $prp_order_row->book_id;
		if(isset($print_exp_date) && isset($printer_id) || $redirect_id == "1"){
			$move_status =  $this->assign_printer($order_id,$book_id,$printer_id,$print_exp_date);
			$upd_courier_mode = update_data('prp_orders',array('courier_mode'=>$courier_mode),array('id'=>$order_id));
			if($file_origin != "")
			update_data('prp_file_origin',array('file_origin'=>$file_origin),array('printer_id'=>$printer_id,'book_id'=>$book_id,'deleted'=>'0'));
		}
		elseif(isset($courier_track_no) && isset($courier_id) || $redirect_id == "4"){
				$move_status =  $this->assign_courier($order_id,$book_id,$courier_id,$courier_track_no);
				$courier_row = get_data("prp_courier",array("deleted"=>'0','id'=>$courier_id))->row_array();
				$email_cont = get_data('prp_email_template',array('id'=>$email_template))->row_array();
				$to = $this->db->query("select email from books join users on users.id=books.userid where books.id =".$book_id)->row()->email;
				$orderId = $prp_order_row->order_type == 1 ? "#".$prp_order_row->store_order_id : "#".$order_id;
				$contant=str_replace(array("#courier_name","#courier_track_no","#ORDERID#"), array($courier_row['name'],$courier_track_no,$orderId),$email_cont['content']);
				$subject=str_replace(array("#ORDERID#"), array($orderId), $email_cont['subject']);
				$move_status = update_data('prp_orders',array('shipped_date'=>date("Y-m-d H:i:s")),array('id'=>$order_id)); 
				if($prp_order_row->order_type != 2){
					if($prp_order_row->order_type == 1)
					update_data('jobs_print',array('completed' => 'Y','courier_name' =>$courier_row['name'],'courier_number' => $courier_track_no,'courier_date' => date("Y-m-d H:i:s")),array('orderid' =>$prp_order_row->store_order_id) );
					sendEmail($to,$email_template,NULL,$contant,$subject);
				}
		}
		else
		$move_status = true;
		if($move_status){
				$move_status = $this->db->query('UPDATE prp_orders SET order_stage = order_stage + 1 WHERE id = '.$order_id);
				echo json_encode(array('status'=>'success'));
			}else{
				echo json_encode(array('status'=>'fail'));
				
			}
			
	}
	
	public function access_level($order_id){
		$seg = $this->uri->segment(3);
		$order_info = get_data("prp_orders",array('id'=>$order_id))->row();
		$book_id = $order_info->book_id;
		$move_botton_text = $seg == 1 ? "Approve" : "Move"; 
		$move_botton_tooltip = $seg == 1 ? "Approve Order" : "Move"; 
		$user_type = $this->session->userdata('user_type');
		$edit_url = $order_info->reprint_order_id == 0 ? site_url("orders/add_order/".$order_id) : site_url("orders/add_order/".$order_id."?reprint_order=".$order_info->reprint_order_id);
		$edit =  '<a href = "'.$edit_url.'" ><button type="button" class="btn btn-warning"><i class="glyphicon glyphicon-edit" data-toggle="tooltip" title="Modify Order"></i></button></a>&nbsp';
		$delete = '<a onclick="return confirm(\'Are you sure you want to delete this order ?\')" href = "'.site_url("orders/del_order/".$order_id).'" ><button type="button" class="btn btn-danger"><i class="glyphicon glyphicon-remove" data-toggle="tooltip" title="Delete Order"></i></button></a>&nbsp';
		//$move = '<a href = "'.site_url("orders/move_order/".$order_id).'" ><button type="button" class="btn btn-default">Move</button></a>&nbsp';
		$move = '<button type="button" class="btn btn-success move" data-toggle="tooltip" title="'.$move_botton_tooltip.'">'.$move_botton_text.'</button>&nbsp';
		$reprint =  '<a href = "'.site_url("orders/add_order/".$order_id."?reprint_order=".$order_id).'" ><button type="button" class="btn btn-warning" data-toggle="tooltip" title="Reprint Order">Reprint</button></a>&nbsp';
		$move_to_previous =  '<a  onclick="return confirm(\'Are you sure you want move to previous stage ?\')" href = "'.site_url("orders/move_to_previous/".$order_id).'" ><button type="button" class="btn btn-warning" data-toggle="tooltip" title="Move To Previous Stage">Back</button></a>&nbsp';
		$book_spec = '<button type="button" class="btn btn-info book_spec sb-toggle-right" style="margin-top:0px;"><i class="glyphicon glyphicon-zoom-in" data-toggle="tooltip" title="View Book Spec"></i></button>&nbsp';
		$acc_cont = "<td>";
		$book_spec_row = get_data_db2('book_spec',array('deleted'=>'0','book_id'=>$book_id))->num_rows();
		if($seg == "1"){
				$acc_cont .= $edit.$delete;
			if($user_type == "1" || $user_type == "2"){
				if($book_spec_row)
				$acc_cont .= $move.$book_spec;	
			}
		}else if($seg == 2 && $user_type <= "2"){   
			$acc_cont.= $move_to_previous;
			
		}else if($seg == 6 && $user_type <= "2"){   
			$acc_cont.= $reprint;
			
		}else if($seg == 7){   
			$acc_cont = "";
		}else if($seg == 8){   
			$acc_cont = "";
		}else{
			if($user_type == "1"){
				$acc_cont .= $edit.$delete.$move;	
			}else if($user_type == "2"){
				if($seg != "2")
				$acc_cont .= $move;	
				else
				$acc_cont = "";
			}else{
				$acc_cont = "";
			}
		}
		return $acc_cont.'</td>';
	}
	
	public function printer_dropdown(){
		$selectBox = '<select class="form-control printer_id" name="country" id="country"><option value="">-- Select --</option>';
		$result = get_data("prp_printer",array('deleted'=>'0'));
		if($result->num_rows()){
			foreach($result->result() as $row){
				$selectBox .= '<option value="'.$row->id.'">'.$row->name.'</option>';
			}
		}
		return $selectBox .= '</select>';
	}
	public function courier_dropdown(){
		$selectBox = '<select class="form-control courier_id" name="courier_id" id="courier_id"><option value="">-- Select --</option>';
		$result = get_data("prp_courier",array('deleted'=>'0'));
		if($result->num_rows()){
			foreach($result->result() as $row){
				$selectBox .= '<option value="'.$row->id.'">'.$row->name.'</option>';
			}
		}
		return $selectBox .= '</select>';
	}
	public function courier_mode_dropdown(){
		$courier_mode = $this->config->item('courier_mode');
		$selectBox = '<select class="form-control courier_mode" name="courier_mode" id="courier_mode">';
			foreach($courier_mode as $key => $value){
				$selectBox .= '<option value="'.$key.'">'.$value.'</option>';
			}
		 	return $selectBox.= '</select>';
	}
	
	public function assign_printer($order_id,$book_id,$printer_id,$print_exp_date){
		$print_cost = $this->print_cost_calculate($order_id,$printer_id);
		$vat = get_data('prp_printer',array('deleted'=>'0'))->row()->vat;
		return insert_data('prp_assign_print',array('order_id'=>$order_id,'book_id'=>$book_id,'print_cost'=>$print_cost,'print_cost_vat'=>$print_cost*$vat,'printer_id'=>$printer_id,'print_exp_date'=>date("Y-m-d H:i:s",strtotime($print_exp_date)),'created_date'=>date("Y-m-d H:i:s")));
	}
	public function assign_courier($order_id,$book_id,$courier_id,$courier_track_no){
		return insert_data('prp_assign_courier',array('order_id'=>$order_id,'book_id'=>$book_id,'courier_id'=>$courier_id,'courier_track_no'=>$courier_track_no,'created_date'=>date("Y-m-d H:i:s")));
	}
	
	public function book_spec(){
		$result = get_data_db2('book_spec',array('deleted'=>'0','book_id'=>$_POST['book_id']));
		if($result->num_rows()){
			echo json_encode($result->row());
		}
	}
	
	public function print_cost_calculate($order_id,$printer_id){
		$prp_order_row = get_data('prp_orders',array('id'=>$order_id))->row();
		$result = get_data_db2('book_spec',array('deleted'=>'0','book_id'=>$prp_order_row->book_id));
		if($result->num_rows()){
			
			$book_spec = $result->row();
			
			$book_type = $book_spec->book_type == "Paperback" ? "1" : "2";
			
			$dust_jacket = $book_spec->dust_jacket == "Yes" ? "1" : "0";
			/*quantity,printer_id,book_type,width,page_count,dust_jacket,color_page_count*/
			//$printer_id = get_data('prp_assign_print',array('id'=>$order_id))->row()->printer_id;
			$print_data = array('quantity'=>$prp_order_row->no_of_copies,'printer_id'=>$printer_id,'book_type'=>$book_type,'width'=>$book_spec->width,
				  'page_count'=>$book_spec->page_count,'dust_jacket'=>$dust_jacket,'color_page_count'=>$book_spec->color_page);
			$this->load->library('print_price_calc');
			return $this->print_price_calc->calculator($print_data);
		}
		
	}
	
	public function download_report($filename,array $array){

		$i = 0;
		$now = gmdate("D, d M Y H:i:s");
	    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
	    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
	    header("Last-Modified: {$now} GMT");

	    // force download  
	    header("Content-Type: application/force-download");
	    header("Content-Type: application/octet-stream");
	    header("Content-Type: application/download");

	    // disposition / encoding on response body
	    header("Content-Disposition: attachment;filename={$filename}");
	    header("Content-Transfer-Encoding: binary");
	    
	    if (count($array) == 0) {
	     return null;
	   }
	   ob_start();
	   $df = fopen("php://output", 'w');
	   fputcsv($df, array_keys(reset($array)));
	   foreach ($array as $row) {
	      	fputcsv($df, $row,$delimiter=',');
	      	$i++;
	   }
	   fclose($df);
	   return ob_get_clean();
	   
	}
	public function file_origin_info($book_id,$printer_id){
		if(isset($printer_id) && isset($book_id))
		$file_origin =  get_data("prp_file_origin",array('deleted'=>'0','printer_id'=>$printer_id,'book_id'=>$book_id));
		if($file_origin->num_rows())
		return $file_origin->row()->file_origin;
		else
		return "FTP";
	}
	public function ajax_file_origin_info(){
		$printer_id = $_POST['printer_id'];
		$book_id = $_POST['book_id'];
		echo $this->file_origin_info($book_id,$printer_id);
		/*if(isset($printer_id) && isset($book_id))
		$file_origin =  get_data("prp_file_origin",array('deleted'=>'0','printer_id'=>$printer_id,'book_id'=>$book_id));
		if($file_origin->num_rows())
		echo $file_origin->row()->file_origin;
		else
		echo "FTP";*/
	}
	
	public function production_cost($book_id){
		
		$production_cost_info = get_data_db2('book_spec',array('deleted'=>0,'book_id'=>$book_id));
		
		if($production_cost_info->num_rows()){
			
			$production_cost = $production_cost_info->row()->production_cost;
			
		}else{
			
			$production_cost = "Spec Not Updated";
			
		}
		return $production_cost;
		
	}
	public function receive_amount($order_id){
		
		$payment_info = get_data('prp_payment',array('deleted'=>'0','order_id'=>$order_id));
		
		if($payment_info->num_rows()){
			$payment = $payment_info->row()->payment;
		}else{
			$payment = 0;
		}
		return $payment;
	}
	
	public function file_orign_dropdown(){
		$view_print = '<span class = "file_origin_ajax"></span><select class="form-control file_origin_dropdown"><option value="">-Select-</option><option value="FTP">FTP</option><option value="Hard Disk">Hard Disk</option></select>';   		
		return $view_print;
	}
	
	public function duedata($past_date){
		$past_date=date_create($past_date);
		$cur_date=date_create(date('Y-m-d'));
		$diff=date_diff($cur_date,$past_date);
		$sign = $diff->format("%R");
		if($sign == "+"){
			$due_feature = $diff->format("%a") == "0" ? "Due Today" : $diff->format("%R%a");
			$date_diff = " <span class='btn btn-success btn-xs'  >".$due_feature."</span>";	
		}
		else{
			$minus_date = $diff->format("%a")+1;
			$date_diff = " <span class='btn btn-danger btn-xs'; >-".$minus_date."</span>";
		}
		return $date_diff;
	}
	
	public function printer_name($printer_id){
		$printer_name = "";
		if($printer_id){
			$printer_name = get_data('prp_printer',array('id'=>$printer_id))->row()->name;
		}else{
			$printer_name = "NotionPress";
		}
		return $printer_name;
		
	}
	/*
	function array2csv(array &$array)
	{
	   
	}*/
}
