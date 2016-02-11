   <?php load_external_file($external_files); ?>
   <section id="main-content">
          <section class="wrapper">
              <!-- page start-->
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                      
                          <?php $this->load->view("templates/page_title"); ?>
                          
                          <div class="panel-body">
                          
                      	  <?php 
                      	
                  				$this->load->view("templates/message");
                  			
                      			my_form($input_arr,$active);

                      	  ?>
                          </div>
                      </section>
                  </div>
              </div>
             
              <!-- page end-->
          </section>
      </section>