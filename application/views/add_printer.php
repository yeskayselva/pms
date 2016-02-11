
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
                              Add Printer
                          </header>
                          <div class="panel-body">
                          	<?php $this->load->view("templates/message"); ?>
                              <form class="form-horizontal tasi-form" method="post" action="" name="add_order" id="add_order">
                              		<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Printer Name</label>
										<div class="col-sm-10">
										<input type="text" class="form-control typeahead" name="name" id="name" value="<?php echo $name;?>"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Vendor Name</label>
										<div class="col-sm-10">
										<input type="text" class="form-control" name="contact_person_2" id="contact_person_2" value="<?php echo $contact_person_2;?>"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Vendor Email</label>
										<div class="col-sm-10">
										<input type="text" class="form-control" name="email2" id="email2" value="<?php echo $email2;?>"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Vendor Phone</label>
										<div class="col-sm-10">
										<input type="text" class="form-control" name="phone2" id="phone2" value="<?php echo $phone2;?>"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Head Name</label>
										<div class="col-sm-10">
										<input type="text" class="form-control" name="contact_person_1" id="contact_person_1" value="<?php echo $contact_person_1;?>"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Head Email</label>
										<div class="col-sm-10">
										<input type="text" class="form-control" name="email1" id="email1" value="<?php echo $email1;?>"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Head Phone</label>
										<div class="col-sm-10">
										<input type="text" class="form-control" name="phone1" id="phone1" value="<?php echo $phone1;?>"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Contact Person</label>
										<div class="col-sm-10">
										<input type="text" class="form-control" name="contact_person_3" id="contact_person_3" value="<?php echo $contact_person_3;?>"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Contact Person Email</label>
										<div class="col-sm-10">
										<input type="text" class="form-control" name="email3" id="email3" value="<?php echo $email3;?>"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Contact Person Phone</label>
										<div class="col-sm-10">
										<input type="text" class="form-control" name="phone3" id="phone3" value="<?php echo $phone3;?>"/>
										</div>
									</div>
									<?php $this->load->view("templates/address",$address); ?>
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Currency</label>
										<div class="col-sm-10">
											<select class="form-control" name="currency" id="currency">
											    <?php 
											    	$currency_data = $this->config->item('currency');
											    	foreach($currency_data as $key => $value){
											    		if($key == $currency)
														echo "<option value='".$key."' selected='true'>".$value."</option>";
														else
														echo "<option value='".$key."'>".$value."</option>";
													}
											    ?>
										  </select>
										</div>
									</div>
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
			$("#add_order").validate({
			rules: {
				name: "required",
				country: "required",
				currency: "required",
				contact_person_2: "required",
				email2: "required",
				phone2: "required",
				
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
	
		
      	})
      </script>