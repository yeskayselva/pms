
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
                              Add Courier
                          </header>
                          <div class="panel-body">
                          	<?php $this->load->view("templates/message"); ?>
                              <form class="form-horizontal tasi-form" method="post" action="" name="print_calc" id="print_calc">
                              		<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Printer</label>
										<div class="col-sm-10">
											<select class="form-control" name="printer_id" required="true">
											    <option value="">-- Select Printer --</option>
											    <?php 
											    	$printer_name = get_data('prp_printer',array('deleted'=>'0'))->result();
											    	
											    	foreach($printer_name as $row){
														echo "<option value='".$row->id."'>".$row->name."</option>";
													}
											    ?>
										  </select>
										</div>
									</div>
                              		<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Books Type</label>
										<div class="col-sm-10">
											<select class="form-control" name="book_type"  required="true">
											    <option value="">-- Select --</option>
											    <?php 
														echo "<option value='1'>Paperback</option>";
														echo "<option value='2'>Hardbound</option>";
											    ?>
										  </select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Width</label>
										<div class="col-sm-10">
										<input type="text" class="form-control" name="width"  value="" required="true"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Height</label>
										<div class="col-sm-10">
										<input type="text" class="form-control" name="height"  value="" required="true"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Quantity</label>
										<div class="col-sm-10">
										<input type="text" class="form-control" name="quantity"  value="" required="true"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Page Count</label>
										<div class="col-sm-10">
										<input type="text" class="form-control" name="page_count"  value="" required="true"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Color Page Count</label>
										<div class="col-sm-10">
										<input type="text" class="form-control" name="color_page_count"  value="" required="true"/>
										</div>
									</div>
									<div class="form-group">
                                      <label class="col-sm-2 control-label col-lg-2" for="inputSuccess">Dust Jacket</label>
                                      <div class="col-lg-10">
                                          <div class="radio">
                                              <label>
                                                  <input type="radio" name="dust_jacket" value="1" checked="" required="true">
                                                  Yes
                                              </label>
                                          </div>
                                          <div class="radio">
                                              <label>
                                                  <input type="radio" name="dust_jacket" value="0" required="true">
                                                  NO
                                              </label>
                                          </div>

                                      </div>
                                  </div>
									<div class="form-group">
										<div class="col-sm-10">
											<button type="submit" class="btn btn-shadow btn-default" name="submit" value="Calculate">Calculate</button>
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
      
      