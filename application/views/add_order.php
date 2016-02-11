<?php  
$reprint_order = $this->input->get('reprint_order');
if($reprint_order != ""){
	$read_only = "readonly='true'";
}else{
	$read_only = "";
}
?>
<style>
/*.frmSearch {border: 1px solid #F0F0F0;background-color:#C8EEFD;margin: 2px 0px;padding:40px;}*/
#country-list{float:left;list-style:none;margin:0;padding:0;width:190px;}
#country-list li{padding: 10px; background:#FAFAFA;border-bottom:#F0F0F0 1px solid;}
#country-list li:hover{background:#F0F0F0;}
#search-box{padding: 10px;border: #F0F0F0 1px solid;}
.today{
	background-color: #ddd;
	background: #ddd;
	    cursor: pointer;
}
</style>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/bootstrap-datepicker/css/datepicker.css" />
   <script src="<?php echo base_url();?>js/bootstrap-typeahead.js" type="text/javascript"></script>
   <script type="text/javascript" src="<?php echo base_url();?>assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
   <script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js"></script>
   <section id="main-content">
          <section class="wrapper">
              <!-- page start-->
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                              <?php echo $title;?>
                          </header>
                          <div class="panel-body">
                          	<?php $this->load->view("templates/message"); ?>
                              <form class="form-horizontal tasi-form" method="post" action="" name="add_order" id="add_order" autocomplete="off">
                              		<!--<div class="frmSearch">
									<input type="text" id="search-box" placeholder="Country Name" />
									<div id="suggesstion-box"></div>
									</div>-->
	                              	<div class="form-group frmSearch">
										<label class="col-sm-2 col-sm-2 control-label">Book Name</label>
										<div class="col-sm-10">
										<input type="text" class="form-control typeahead" name="book_id" <?php echo $read_only; ?> id="book_id" value="<?php echo $book_id;?>"/>
										<div id="suggesstion-box"></div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">No Of Copies</label>
										<div class="col-sm-10">
										<input  type="text" <?php echo $read_only; ?> class="form-control" name="no_of_copies" id="no_of_copies" value="<?php echo $no_of_copies;?>"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Order Type</label>
										<div class="col-sm-10">
											<select class="form-control" name="order_type" id="order_type" <?php echo $read_only; ?>>
											    <option value="">-- Select --</option>
											    <?php 
											    	$this->load->helper("other");
											    	$order_type_arr = order_type();
											    	foreach($order_type_arr as $key => $value){
											    		if($key == $order_type)
														echo "<option value='".$key."' selected='true'>".$value."</option>";
														else
														echo "<option value='".$key."'>".$value."</option>";
													}
											    ?>
										  </select>
										</div>
									</div>
									<?php if($user_type <= 2) { ?>
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label" >Select User</label>
										<div class="col-sm-10">
											<select class="form-control" name="user_id" id="user_id" <?php echo $read_only; ?> >
											    <option value="">-- Select --</option>
											    <?php 
											    	$user_id_arr = get_data('globalnp_users',array('deleted'=>'0'))->result();
											    	foreach($user_id_arr as $row){
											    		if($row->id == $user_id)
														echo "<option value='".$row->id."' selected='true'>".$row->name."</option>";
														else
														echo "<option value='".$row->id."'>".$row->name."</option>";
													}
											    ?>
										  </select>
										</div>
									</div>
									<?php } ?>
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Expected Date</label>
										<div class="col-sm-10">
										<input type="text" class="form-control form-control-inline input-medium default-date-picker datepicker" name="exp_date" id="exp_date" value="<?php echo $exp_date;?>"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Instruction</label>
										<div class="col-sm-10">
										 <textarea class="form-control" rows="5" name="description" id="description"><?php echo $description;?></textarea>
										</div>
									</div>
									<div class="form-group payment">
										<label class="col-sm-12 col-sm-12 control-label" ><b>Payment Details</b></label>
										<!--<div class="col-sm-10">
										<input type="text" class="form-control form-control-inline input-medium" name="shipping_name" id="shipping_name" value="<?php echo $shipping_name;?>"/>
										</div>-->
									</div>
									<div class="form-group payment">
										<label class="col-sm-2 col-sm-2 control-label">Payment Amount + (Shipping Cost)</label>
										<div class="col-sm-10">
										<input type="text" class="form-control" name="payment" id="payment" value="<?php echo $payment;?>"/>
										
										</div>
									</div>
									<div class="form-group payment">
										<label class="col-sm-2 col-sm-2 control-label">Payment Type</label>
										<div class="col-sm-10">
										<select class="form-control" name="payment_type" id="payment_type">
											    <option value="">-- Select --</option>
											    <?php $paymentType =  $this->config->item('paymentType');
											    	foreach($paymentType as $key => $value){
											    		if($key == $payment_type)
														echo "<option value='".$key."' selected='true'>".$value."</option>";
														else
														echo "<option value='".$key."'>".$value."</option>";
													}
											    ?>
										  </select>
										</div>
									</div>
									<div class="form-group payment">
										<label class="col-sm-2 col-sm-2 control-label">Payment Date</label>
										<div class="col-sm-10">
										<input type="text" class="form-control form-control-inline input-medium default-date-picker datepicker1" name="payment_date" id="payment_date" value="<?php echo $payment_date;?>"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-12 col-sm-12 control-label" ><b>Who do we ship the book to?</b></label>
										<!--<div class="col-sm-10">
										<input type="text" class="form-control form-control-inline input-medium" name="shipping_name" id="shipping_name" value="<?php echo $shipping_name;?>"/>
										</div>-->
									</div>
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Shipping Name</label>
										<div class="col-sm-10">
										<input type="text" class="form-control form-control-inline input-medium" name="shipping_name" id="shipping_name" value="<?php echo $shipping_name;?>"/>
										</div>
									</div>
									
									<?php 
									
									$this->load->view("templates/address",$address); 
									?>
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Phone</label>
										<div class="col-sm-10">
										<input type="text" class="form-control form-control-inline input-medium" name="phone" id="phone" value="<?php echo $phone;?>"/>
										</div>
									</div>
									<?php if($reprint_order != "") { ?>
									<div class="form-group reprint_info">
										<label class="col-sm-12 col-sm-12 control-label" ><b>Reprint Information</b></label>
									</div>
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Reprint Fault by</label>
										<div class="col-sm-10">
											<select class="form-control" name="repritnt_reason_from_id" id="repritnt_reason_from_id" >
											    <option value="0">NotionPress</option>
											    <?php 
											    	$printer_info_arr = get_data('prp_printer',array('deleted'=>'0'))->result();
											    	foreach($printer_info_arr as $row){
											    		if($row->id == $repritnt_reason_from_id)
														echo "<option value='".$row->id."' selected='true'>".$row->name."</option>";
														else
														echo "<option value='".$row->id."'>".$row->name."</option>";
													}
											    ?>
										  </select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Reprint Reason : </label>
										<div class="col-sm-10">
										 <textarea class="form-control" rows="5" name="reprint_desc" id="reprint_desc"><?php echo $reprint_desc;?></textarea>
										</div>
									</div>
									<?php } ?>
									<div class="form-group">
										<div class="col-sm-12">
											<button type="submit" class="btn btn-lg btn-success btn-block" name="submit" value="<?php echo $action;?>"><?php echo $action;?></button>
										</div>
									</div>
									
                              </form>
                          </div>
                      </section>
                  </div>
              </div>
             
              <!-- page end-->
          </section>
      </section>
      <script>
      	$(document).ready(function(){
      		np_shipping_address = <?php echo $np_shipping_address; ?>;
      		console.log(np_shipping_address);
      		console.log(np_shipping_address.addr1);
      		
      		$('.datepicker').datepicker({
			    format: 'dd-mm-yyyy',
			    startDate: '-0d',
			    todayHighlight: true
			});
			
			$('.datepicker1').datepicker({
			    format: 'dd-mm-yyyy',
			    todayHighlight: true
			});
			
			$('.payment').hide();
			order_type = "<?php echo $order_type;?>";
			assign_addr(order_type);
			if(order_type == 4){
				$('.payment').show();
			}
			$("#order_type").change(function(){
				order_type = $(this).val();	
				assign_addr(order_type);
				if(order_type == 2){
				}
				if(order_type == 4){
					$('.payment').show();
				}else{
					$('.payment').hide();
				}
			});
			$("#add_order").validate({
			rules: {
				book_id: "required",
				no_of_copies:  {
					number: true,
					required:true,
				},
				order_type: "required",
				exp_date: "required",
				shipping_name: "required",
				phone: "required",
				payment_type: "required",
				user_id:"required",
				payment_date: "required",
				addr1: "required",
				addr2: "required",
				city: "required",
				state: "required",
				country: "required",
				pincode: "required",
				payment: {
					number: true,
					required:true,
				},
			},
			messages: {
				/*firstname: "Please enter your firstname",
				lastname: "Please enter your lastname",
				username: {
					required: "Please enter a username",
					minlength: "Your username must consist of at least 2 characters"
				},
				password: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long"
				},
				confirm_password: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long",
					equalTo: "Please enter the same password as above"
				},
				email: "Please enter a valid email address",
				agree: "Please accept our policy",
				topic: "Please select at least 2 topics"*/
			}
		});
		search_book_url = "<?php echo site_url() ?>orders/ajax_book_info/";
		
	$("#book_id").keyup(function(){
		$.ajax({
		type: "POST",
		url: search_book_url,
		data:'query='+$(this).val(),
		beforeSend: function(){
			$("#book_id").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			
			$("#suggesstion-box").show();
			$("#suggesstion-box").html(data);
			$("#book_id").css("background","#FFF");
		}
		});
	});
	
	$(document).on('click','.selectCountry',function(){
		country = $(this).html();
		$("#book_id").val(country);
		$("#suggesstion-box").hide();
	});

	function assign_addr(order_id){
		if(order_id == '2'){
			
			$("#shipping_name").val(np_shipping_address.shipping_name);
			$("#phone").val(np_shipping_address.phone);
			$("#addr1").val(np_shipping_address.addr1);
			$("#addr2").val(np_shipping_address.addr2);
			$("#city").val(np_shipping_address.city);
			$("#state").val(np_shipping_address.state);
			$("#pincode").val(np_shipping_address.pincode);
			$("#country").val(np_shipping_address.country);
		
		}else{
			
			$("#shipping_name").val("");
			$("#phone").val("");
			$("#addr1").val("");
			$("#addr2").val("");
			$("#city").val("");
			$("#state").val("");
			$("#pincode").val("");
			$("#country").val(1);
		}
		
	}		
});
      </script>