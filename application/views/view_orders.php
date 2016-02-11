<style>
.today{
	background-color: #ddd;
	background: #ddd;
	    cursor: pointer;
}
#courier_id{
	width: 100px;
}
.closebtn{
	position: absolute;
    left: 0px;
    top: 0px;
    width: 20px;
    height: 20px;
    font-size: 14px;
    text-align: center;
    opacity: 1;
}
.closebtn a{
	font-size: 16px;
    vertical-align: top;
    display: inline-block;
    line-height: 16px;
    color: #aeb2b7;
}
</style>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/bootstrap-datetimepicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/bootstrap-datepicker/css/datepicker.css" />
   <script src="<?php echo base_url();?>js/bootstrap-typeahead.js" type="text/javascript"></script>
   <script type="text/javascript" src="<?php echo base_url();?>assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
   <script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js"></script>
   <section id="main-content">
   		
          <section class="wrapper">
      
<?php 
$seg = $this->uri->segment(3);
if($seg == 6)
$this->load->view("templates/filter"); 
else if($seg == 7){
	$this->load->view("templates/advanced_search"); 
}else if($seg == 3){
	$this->load->view("templates/due_date_filter"); 
}

$confirm_box_msg = $seg == 1 ? "Are you sure you want to approve and send this order to the printer" : "Are you sure you want to move to the next stage ?"; 
$warning_msg = $seg == 1 ? "Please select printer and enter the print expected date." : "Please select courier and enter the courier track no."; 
?>
              <!-- page start-->
              <div class="row">
              
              
              
                  <div class="col-lg-12">
                  	
                  	 
                  	
                      <section class="panel">
                          <header class="panel-heading">
                              <?php echo $title;  ?>
                    			<div class="box-tools">
				                    <ul class="pagination pagination-sm no-margin">
				                      <li><a href="#"><span class="glyphicon glyphicon-plus"></span>New</a></li>
				                      <li><a href="#"><span class="glyphicon glyphicon-edit"></span>Edit</a></li>
				                      <li><a href="#"><span class="glyphicon glyphicon-copy"></span>Copy</a></li>
				                      <li><a href="#"><span class="glyphicon glyphicon-ok-sign"></span>Publish</a></li>
				                      <li><a href="#"><span class="glyphicon glyphicon-remove-sign"></span>Unpublish</a></li>
				                      <li><a href="#"><span class="glyphicon glyphicon-trash"></span>Trash</a></li>
				                      <li><a href="#"><span class="glyphicon glyphicon-empty-trash"></span>Empty trash</a></li>
				                      <li><a href="#"><span class="glyphicon glyphicon-trash"></span>Show trash</a></li>
				                    </ul>
				                  </div>
                          </header>
                          <div class="panel-body">
                          		<?php $this->load->view("templates/message"); ?>
                          	   <div class="row margin-top-10">
                   <div class="col-xs-9">
                  			<div class="input-group">
                  				<input type="text" name="table_search" class="form-control input-sm" style="width: 150px;" placeholder="Search">
                  				<select name="example1_length" size="1" aria-controls="example1" class="form-control option-select">
                  				<option value="0" selected="selected">Select</option>
                  				<option value="1">option1</option>
                  				<option value="2">option2</option>
                  				<option value="3">option3</option>
                  				<option value="4">option4</option>
                  				<option value="5">option5</option>
                  				<option value="6">option6</option>
                  				<option value="7">option7</option>
                  				<option value="8">option8</option>
                  				<option value="9">option9</option>
                  				<option value="10">option10</option>
                  				</select>
		                      	<div class="input-group-btn" style="display:initial">
		                        	<button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
		                      	</div>
		                      	<div class="input-group-btn clear-button" style="display:initial">
		                        	<button class="btn btn-sm btn-default"><i class="glyphicon glyphicon-remove"></i></button>
		                      	</div>
                    		</div>
                  	</div>
                  <div class="col-xs-3">
                  		<div class="dataTables_length dataTables_filter">
                  			<select name="example1_length" size="1" class="form-control"  aria-controls="example1" id="limit">
                  				<option value="10" selected="selected">10</option>
                  				<option value="25">25</option><option value="50">50</option>
                  				<option value="100">100</option>
                  			</select>
                  			<label style="float: right;font-weight: normal;">
                  			 records per page
                  			</label>
                  		</div>
                  	</div>
                  </div>
                              <section id="unseen">
                                <table class="table table-bordered table-striped table-condensed">
                                  <thead>
                                  <tr>
                                  <?php echo $thead;?> 
                                  </tr>
                                  </thead>
                                  <tbody>                                               
                                               <?php  echo $tbody; ?>                                                
                                                <!-- Returns -->                                                 
                                            </tbody>
                              </table>
                              <div class='pagination-class leadsListPagination'>
					                    <?php
					                       echo $link;

					                    ?>
					                  </div>
                              </section>
                          </div>
                      </section>
                  </div>
              </div>
             <?php 
             $seg = $this->uri->segment(3);
             if($seg == 2)
             echo $approve_btn; ?>
              <!-- page end-->
          </section>
      </section>
       <div class="sb-slidebar sb-right sb-style-overlay">
        
          <h5 class="side-title">Book Info</h5>
          	<div class="loader" style="
			    position: absolute;
			    top: 0;
			    left: 0;
			    width: 100%;
			    height: 100%;display: none;
			">
			  <div class="background-overlay" style="
			    width: 100%;
			    height: 100%;
			    background: #333;
			    opacity: 0.5;
			"></div>
			<i class="fa fa-spinner fa-spin" style="
			    position: absolute;
			    line-height: normal;
			    font-size: 90px;
			    left: 50%;
			    top: 50%;
			    margin-left: -45px;
			    margin-top: -45px;
			"></i>
			</div>
			 <div class="external closebtn">
                  <a href="#"><i class="fa fa-times"></i></a>
              </div>
			          <ul class="p-task tasks-bar">
              <li>
                      <div class="task-info">
                          <div class="desc">Book Name : </div>
                          <div class="percent" id="book_name">sdfdsfsdfsdfs</div>
                      </div>
              </li> 
              <li>
                      <div class="task-info">
                          <div class="desc">Author Name : </div>
                          <div class="percent" id="book_author">sdfdsfsdfsdfs</div>
                      </div>
              </li>
              <li>
                      <div class="task-info">
                          <div class="desc">ISBN : </div>
                          <div class="percent" id="book_isbn">sdfdsfsdfsdfs</div>
                      </div>
              </li> 
              <li>
                      <div class="task-info">
                          <div class="desc">Book Type : </div>
                          <div class="percent" id="book_type">sdfdsfsdfsdfs</div>
                      </div>
              </li> 
              <li>
                      <div class="task-info">
                          <div class="desc">Book Size : </div>
                          <div class="percent" id="book_size">sdfdsfsdfsdfs</div>
                      </div>
              </li> 
              <li>
                      <div class="task-info">
                          <div class="desc">Page No : </div>
                          <div class="percent" id="page_no">sdfdsfsdfsdfs</div>
                      </div>
              </li>
              <li>
                      <div class="task-info">
                          <div class="desc">Dust Jacket : </div>
                          <div class="percent" id="dust_jacket">sdfdsfsdfsdfs</div>
                      </div>
              </li>
              <li>
                      <div class="task-info">
                          <div class="desc">Lamination : </div>
                          <div class="percent" id="lamination">sdfdsfsdfsdfs</div>
                      </div>
              </li>
              <li>
                      <div class="task-info">
                          <div class="desc">Color Page Number : </div>
                          <div class="percent" id="color_page_no">sdfdsfsdfsdfs</div>
                      </div>
              </li> 
              <li>
                      <div class="task-info">
                          <div class="desc">Paper GSM Type : </div>
                          <div class="percent" id="paper_type">sdfdsfsdfsdfs</div>
                      </div>
              </li> 
              <li>
                      <div class="task-info">
                          <div class="desc">Cover Type : </div>
                          <div class="percent" id="cover_type">sdfdsfsdfsdfs</div>
                      </div>
              </li>
              <li>
                      <div class="task-info">
                          <div class="desc">Book Special instruction : </div>
                          <div class="percent" id="special_inst">sdfdsfsdfsdfs</div>
                      </div>
              </li> 
              <!--<li>
                      <div class="task-info">
                          <div class="desc">File Origin : </div>
                          <div class="percent" id="file_origin">sdfdsfsdfsdfs</div>
                      </div>
              </li>-->
              <li class="external">
                  <a href="#">Close</a>
              </li>
              
          </ul>
      </div>
  <script>
  	 	$(document).ready(function(){
      		seg = "<?php echo $seg ?>";
      		if(seg != "6" && seg != "3"){
					$('.datepicker').datepicker({
					    format: 'dd-mm-yyyy',
					    startDate: '-0d',
					    todayHighlight: true
					});	
			}else{
					$('.datepicker').datepicker({
					    format: 'dd-mm-yyyy',
					    todayHighlight: true
					});	
			}
			
			$(".move").click(function(){
				elem = $(this);
				order_id = elem.closest("tr").attr('order_id');
				if(seg == 1){
					printer_id = elem.closest("tr").find('.printer_id').val();
					print_exp_date = elem.closest("tr").find('.print_exp_date').val();
					courier_mode = elem.closest("tr").find('.courier_mode').val();
					file_origin = elem.closest("tr").find('.file_origin_dropdown').val();
					if(printer_id !="" && print_exp_date !="")
					send_data = {'print_exp_date':print_exp_date,'printer_id': printer_id,'order_id':order_id,'courier_mode':courier_mode,'file_origin':file_origin};
					else if( print_exp_date !== 'undefined' || printer_id !== 'undefined' )
					send_data = false;
				}
				else if(seg == 4){
					courier_id = elem.closest("tr").find('.courier_id').val();
					courier_track_no = elem.closest("tr").find('.courier_track_no').val();
					if(courier_id !="" && courier_track_no !="")
					send_data = {'courier_track_no':courier_track_no,'courier_id': courier_id,'order_id':order_id};
					else if( courier_track_no !== 'undefined' || courier_id !== 'undefined' )
					send_data = false;
				}else
				send_data = {"order_id":+order_id};
				console.log(send_data);
				/*printer_id = elem.closest("tr").find('.printer_id').val();
				print_exp_date = elem.closest("tr").find('.print_exp_date').val();
				order_id = elem.closest("tr").attr('order_id');
				if(printer_id !="" && print_exp_date !="")
				send_data = {'print_exp_date':print_exp_date,'printer_id': printer_id,'order_id':order_id};
				else if( print_exp_date !== 'undefined' || printer_id !== 'undefined' )
				send_data = false;
				else
				$confirm_box_msg = $seg == 1 ? "Approve" : "Move To Next"; 
$warning_msg = "";	
				send_data = {order_id:"+order_id+"};
				console.log(send_data);*/
				
				if(send_data == false)
				alert("<?php echo $warning_msg; ?>");
				else{
					if(confirm("<?php echo $confirm_box_msg; ?>")){
						elem.attr("disabled","true");
					    $.ajax({
			                url: "<?php echo site_url('orders/move_order');?>",
			                type: 'POST',
			                data: send_data,
			                success: function(data) {
			                var json = $.parseJSON(data);
			                  console.log(json);
			                  if(json.status == "success"){
			                  	 elem.closest("tr").hide();
			                  	old_act_val = $("li .active").find(".order_stage_count").html();
			                  	 $("li .active").find(".order_stage_count").html(parseInt(old_act_val)-1);
							  	 old_value= $("li .active").parent().next().find(".order_stage_count").html();
							  	 $("li .active").parent().next().find(".order_stage_count").html(parseInt(old_value)+1);
							  }
			                }
			            });	
					}
				}
			});
			
			
			$(".book_spec").click(function(){
				elem = $(this);
				 $(".loader").show();
				bookid = elem.closest('tr').attr('book_id');
				quantity = elem.closest('tr').attr('quantity');
				send_data = {'book_id':bookid,'quantity': quantity};
				$.ajax({
			                url: "<?php echo site_url('orders/book_spec');?>",
			                type: 'POST',
			                data: send_data,
			                success: function(data) {
			                var json = $.parseJSON(data);
			                   $(".loader").hide();
			                //  book_name,book_author,book_type,book_size,page_no,dust_jacket,lamination,color_page_no,paper_type,cover_type,special_inst,file_origin
			                  $('#book_name').html(json.book_name);
			                  $('#book_author').html(json.book_author);
			                  $('#book_isbn').html(json.book_isbn);
			                  $('#book_type').html(json.book_type);
			                  $('#book_size').html(json.width+"x"+json.height);
			                  $('#page_no').html(json.page_count);
			                  $('#dust_jacket').html(json.dust_jacket);
			                  $('#lamination').html(json.lamination);
			                  $('#color_page_no').html(json.color_page);
			                  $('#paper_type').html(json.paper_gsm_type);
			                  $('#cover_type').html(json.cover_type);
			                  $('#special_inst').html(json.special_inst);
			                }
			            });	
			});
			
			$(document).on("change",".printer_id",function(){
				elem = $(this);
				 $(".loader").show();
				book_id = elem.closest('tr').attr('book_id');
				printer_id = elem.val();
				send_data = {'book_id':book_id,'printer_id': printer_id};
				$.ajax({
			                url: "<?php echo site_url('orders/ajax_file_origin_info');?>",
			                type: 'POST',
			                data: send_data,
			                success: function(data) {
			                	elem.closest("tr").find(".file_origin_ajax").html(data);
			                }
			            });	
			});
			$(document).keyup(function(e) {
				if (e.keyCode == 27) { // escape key maps to keycode `27`
					console.log("test");
					$(".book_spec").click();
	        		$(".sb-slidebar").css("transform","translate(0px)");
		    	}
			});	
		});		
  </script>