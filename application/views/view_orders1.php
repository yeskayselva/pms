   <section id="main-content">
          <section class="wrapper">
              <!-- page start-->
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                              <?php echo $title;  ?>
                    			<div class="box-tools">
				                    <ul class="pagination pagination-sm no-margin">
				                      <?php toolbar($action_tools); ?>
				                      <!--<li><a href="#"><span class="glyphicon glyphicon-plus"></span>New</a></li>
				                      <li><a href="#"><span class="glyphicon glyphicon-edit"></span>Edit</a></li>
				                      <li><a href="#"><span class="glyphicon glyphicon-copy"></span>Copy</a></li>
				                      <li><a href="#"><span class="glyphicon glyphicon-ok-sign"></span>Publish</a></li>
				                      <li><a href="#"><span class="glyphicon glyphicon-remove-sign"></span>Unpublish</a></li>
				                      <li><a href="#"><span class="glyphicon glyphicon-trash"></span>Trash</a></li>
				                      <li><a href="#"><span class="glyphicon glyphicon-empty-trash"></span>Empty trash</a></li>
				                      <li><a href="#"><span class="glyphicon glyphicon-trash"></span>Show trash</a></li>-->
				                    </ul>
				                  </div>
                          </header>
                          <div class="panel-body">
                          		<?php $this->load->view("templates/message"); ?>
                          	   <div class="row margin-top-10">
                   <div class="col-xs-9">
                  			<div class="input-group">
                  				<input type="text" name="table_search" class="form-control input-sm" style="width: 150px;" placeholder="Search" value="<?php echo $this->input->cookie($search_cookie); ?>">
		                      	<div class="input-group-btn" style="display:initial">
		                        	<button class="btn btn-sm btn-default" id="search"><i id="search" class="fa fa-search"></i></button>
		                      	</div>
		                      	<div class="input-group-btn clear-button" style="display:initial">
		                        	<button class="btn btn-sm btn-default"><i id="clear" class="glyphicon glyphicon-remove"></i></button>
		                      	</div>
                    		</div>
                    		<!--<div class="input-group">
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
                    		</div>-->
                  	</div>
                  <div class="col-xs-3">
                  		<div class="dataTables_length dataTables_filter">
                  			<?php 
                  			echo form_dropdown('limit',array('10' => 10,'25' => 25,'100' => 100,'250' => 250,'500' => 500),$this->input->cookie($limit_cookie),'size="1" class="form-control"  aria-controls="example1" id="limit"');
                  			?>
             
                  			<label style="float: right;font-weight: normal;">
                  			 records per page
                  			</label>
                  		</div>
                  	</div>
                  </div>
                              <section id="unseen">
                              <form action="" method="post" id="table_form">
                                <table class="table table-bordered table-striped table-condensed" id="itemList">
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
					                  </form>
                              </section>
                          </div>
                      </section>
                  </div>
              </div>
              <!-- page end-->
          </section>
      </section>