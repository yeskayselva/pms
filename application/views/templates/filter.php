   <?php 
   $result =  get_data("prp_printer",array('deleted'=>'0'));?>
     <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                           <header class="panel-heading">
                              Filter
                          </header>
                          <div class="panel-body">
                              <form class="form-inline" action="" method="post">
                                  <div class="form-group">
                                      <label>Start Date</label>
                                      <input type="text" class="form-control datepicker" id="start_date" value="<?php echo $this->input->cookie('start_date'); ?>" >
                                  </div>
                                  <div class="form-group">
                                      <label>End Date</label>
                                      <input type="text" class="form-control datepicker" id="end_date" value="<?php echo $this->input->cookie('end_date'); ?>" >
                                  </div>
                                  <div class="form-group">
                                      <label>Printer : </label>
                                       <select class="form-control" id="printer">
                                       <option value="">--Select Printer--</option>
                                      <?php if($result->num_rows()){
									  		
									  		foreach($result->result() as $row){
									  			if($this->input->cookie('printer') == $row->id)
													echo '<option value="'.$row->id.'" selected>'.$row->name.'</option>';
												else
													echo '<option value="'.$row->id.'">'.$row->name.'</option>';
												
											}
									  	
									  }
									  ?>
                                      </select>
                                     
                                  </div>
                                  <button class="btn btn-primary" type="submit" id="filter">Filter</button>
                                  <button class="btn btn-primary" type="button" id="clear">Clear</button>
                                  <button class="btn btn-primary" type="submit" id="download" name="download" value="download">Download</button>
                              </form>

                          </div>
                      </section>

                  </div>
              </div>
<script>
	$(document).ready(function(){
		
		$("#clear").click(function(){
				$(".datepicker").val("");	
				document.cookie="start_date=; path=/; expires=Thu, 01 Jan 1970 00:00:01 GMT;";
				document.cookie="end_date=; path=/; expires=Thu, 01 Jan 1970 00:00:01 GMT;";
				document.cookie="printer=; path=/; expires=Thu, 01 Jan 1970 00:00:01 GMT;";
				window.location.href = "<?php echo current_url();?>";
				
			});
			$("#filter").click(function(){
				start_date = $("#start_date").val();
				end_date = $("#end_date").val();
				printer = $("#printer").val();
				if(start_date == "" || end_date == ""){
					if(printer == ""){
						$("#start_date,#end_date").css("border-color","red");
						return false;
					}else{
						document.cookie='start_date='+start_date+';path=/';
						document.cookie='end_date='+end_date+';path=/';
						document.cookie='printer='+printer+';path=/';
					}
				}else{
					document.cookie='start_date='+start_date+';path=/';
					document.cookie='end_date='+end_date+';path=/';
					document.cookie='printer='+printer+';path=/';
				}
			});
		
	})
</script>