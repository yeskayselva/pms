   <section id="main-content">
          <section class="wrapper">
              <!-- page start-->
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                              <?php echo $title;  ?>
                          </header>
                          <div class="panel-body">
                          		<?php $this->load->view("templates/message"); ?>
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
             
              <!-- page end-->
          </section>
      </section>