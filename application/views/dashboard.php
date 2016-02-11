<section id="main-content">
          <section class="wrapper">
          
          <div class="row state-overview">
          <?php
         // $user_type = $this->session->userdata('user_type');
          //$whr = $user_type <= 2 ? "" : " AND user_id = " .$this->session->userdata('user_type');
          $new_order = 0;
          $print_job = 0;
          $new_order_quantity = 0;
          $print_job_quantity = 0;
          if($dashboar_data->num_rows()){
		  	foreach($dashboar_data->result() as $row){
		  		if($row->order_stage == '1'){
		  			$new_order = $row->order_count;
					$new_order_quantity = $row->quantity;
				}
				if($row->order_stage == '3'){
		  			$print_job = $row->order_count;
					$print_job_quantity = $row->quantity;
				}
				
				
			}
		  }
		 $complete_order_today_row =  $this->db->query("select count(*) as complete_order,sum(no_of_copies) as no_of_copies from prp_orders where order_stage = 6 AND updated_date >= '".date('Y-m-d')."'".$whr)->row();
          if($complete_order_today_row->complete_order){
		  	$complete_order_today = $complete_order_today_row->complete_order;
		  	$complete_order_today_quantity = $complete_order_today_row->no_of_copies;
		  }else{
		  	$complete_order_today = 0;
		  	$complete_order_today_quantity = 0;
		  }
		  $complete_order_month_row =  $this->db->query("select count(*) as complete_order,sum(no_of_copies) as no_of_copies from prp_orders where order_stage = 6 AND updated_date >= '".date('Y-m-01',strtotime('this month'))."'".$whr)->row();
          if($complete_order_month_row->complete_order){
		  	$complete_order_month = $complete_order_month_row->complete_order;
		  	$complete_order_month_quantity = $complete_order_month_row->no_of_copies;
		  }else{
		  	$complete_order_month = 0;
		  	$complete_order_month_quantity = 0;
		  }

		  $print_job_due_row =  $this->db->query("SELECT count(*) as complete_order,sum(no_of_copies) as no_of_copies FROM `prp_orders` as ord
														JOIN prp_assign_print as assign on DATE(assign.print_exp_date) <= '".date('Y-m-d')."' AND ord.id = assign.order_id
														WHERE ord.deleted = 0 AND ord.`order_stage` = 3 ".$whr)->row();
          if($print_job_due_row->complete_order){
		  	$print_job_due_order = $print_job_due_row->complete_order;
		  	$print_job_due_order_quantity = $print_job_due_row->no_of_copies;
		  }else{
		  	$print_job_due_order = 0;
		  	$print_job_due_order_quantity = 0;
		  }
		  
           ?>
                  <div class="col-lg-6 col-sm-6">
                      <section class="panel">
                          <div class="symbol terques">
                              <i class="fa fa-user"></i>
                          </div>
                          <div class="value">
                              <h1 class="count"><?php echo $new_order; ?></h1>
                              <p>New Orders</p>
                              <p>Quantity : <?php echo $new_order_quantity; ?></p>
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-6 col-sm-6">
                      <section class="panel">
                          <div class="symbol red">
                              <i class="fa fa-tags"></i>
                          </div>
                          <div class="value">
                              <h1 class=" count2"><?php echo $print_job_due_order; ?></h1>
                              <p>Print Due Today</p>
                              <p>Quantity : <?php echo $print_job_due_order_quantity; ?></p>
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-6 col-sm-6">
                      <section class="panel">
                          <div class="symbol yellow">
                              <i class="fa fa-shopping-cart"></i>
                          </div>
                          <div class="value">
                              <h1 class=" count2"><?php echo $complete_order_today; ?></h1>
                              <p>Complete Order Today</p>
                              <p>Quantity : <?php echo $complete_order_today_quantity; ?></p>
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-6 col-sm-6">
                      <section class="panel">
                          <div class="symbol blue">
                              <i class="fa fa-bar-chart-o"></i>
                          </div>
                          <div class="value">
                              <h1 class=" count2"><?php echo $complete_order_month; ?></h1>
                              <p>Complete Order Month</p>
                              <p>Quantity : <?php echo $complete_order_month_quantity; ?></p>
                          </div>
                      </section>
                  </div>
              </div>
              <!-- page start-->
       <!--        <div class="row">
                  <div class="col-lg-4">
                      <section class="panel">
                          <div class="panel-body">
                              <a href="#" class="task-thumb">
                                  <img src="img/ring.jpg" alt="">
                              </a>
                              <div class="task-thumb-details">
                                  <h1><a href="#">Notionpresss</a></h1>
                                  <p>Order Stage</p>
                              </div>
                          </div>
                          <table class="table table-hover personal-task">
                              <tbody>
                               <?php echo $order_stage_cnt;?>
                              </tbody>
                          </table>
                      </section>
                  </div>
                  <div class="col-lg-8">
                      <section class="panel">
                          <div class="panel-body progress-panel">
                              <div class="task-progress">
                                  <h1>Work Progress</h1>
                                  <p>Anjelina Joli</p>
                              </div>
                              <div class="task-option">
                                  <select class="styled">
                                      <option>Anjelina Joli</option>
                                      <option>Tom Crouse</option>
                                      <option>Jhon Due</option>
                                  </select>
                              </div>
                          </div>
                          <table class="table table-hover personal-task">
                              <tbody>
                              <tr>
                                  <td>1</td>
                                  <td>
                                      Target Sell
                                  </td>
                                  <td>
                                      <span class="badge bg-important">75%</span>
                                  </td>
                                  <td>
                                    <div id="work-progress1"></div>
                                  </td>
                              </tr>
                              <tr>
                                  <td>2</td>
                                  <td>
                                      Product Delivery
                                  </td>
                                  <td>
                                      <span class="badge bg-success">43%</span>
                                  </td>
                                  <td>
                                      <div id="work-progress2"></div>
                                  </td>
                              </tr>
                              <tr>
                                  <td>3</td>
                                  <td>
                                      Payment Collection
                                  </td>
                                  <td>
                                      <span class="badge bg-info">67%</span>
                                  </td>
                                  <td>
                                      <div id="work-progress3"></div>
                                  </td>
                              </tr>
                              <tr>
                                  <td>4</td>
                                  <td>
                                      Work Progress
                                  </td>
                                  <td>
                                      <span class="badge bg-warning">30%</span>
                                  </td>
                                  <td>
                                      <div id="work-progress4"></div>
                                  </td>
                              </tr>
                              <tr>
                                  <td>5</td>
                                  <td>
                                      Delivery Pending
                                  </td>
                                  <td>
                                      <span class="badge bg-primary">15%</span>
                                  </td>
                                  <td>
                                      <div id="work-progress5"></div>
                                  </td>
                              </tr>
                              </tbody>
                          </table>
                      </section>
                  </div>
              </div>-->
           
              <!-- page end-->
          </section>
      </section>