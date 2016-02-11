   <?php 
   $result =  get_data("prp_printer",array('deleted'=>'0'));?>
     <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                           <header class="panel-heading">
                              Due Date Filter
                          </header>
                          <div class="panel-body">
                              <form class="form-inline" action="" method="post">
                                  <div class="form-group">
                                      <label>Due Date</label>
                                      <input type="text" class="form-control datepicker" id="due_date" value="<?php echo $this->input->cookie('due_date'); ?>" >
                                  </div>
                                  <button class="btn btn-primary" type="submit" id="filter">Filter</button>
                                  <button class="btn btn-primary" type="button" id="clear">Clear</button>
                                  <!--<button class="btn btn-primary" type="submit" id="download" name="download" value="download">Download</button>-->
                              </form>

                          </div>
                      </section>

                  </div>
              </div>
<script>
	$(document).ready(function(){
		
		$("#clear").click(function(){
				document.cookie="due_date=; path=/; expires=Thu, 01 Jan 1970 00:00:01 GMT;";
				window.location.href = "<?php echo current_url();?>";	
		});
			$("#filter").click(function(){
				due_date = $("#due_date").val();
				document.cookie='due_date='+due_date+';path=/';
			});
		
	})
</script>