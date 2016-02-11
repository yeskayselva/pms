 <style>
 	#country-list{float:left;list-style:none;margin:0;padding:0;width:190px;}
	#country-list li{padding: 10px; background:#FAFAFA;border-bottom:#F0F0F0 1px solid;}
	#country-list li:hover{background:#F0F0F0;}
	#search-box{padding: 10px;border: #F0F0F0 1px solid;}
 </style>
   <?php 
   $result =  get_data("prp_printer",array('deleted'=>'0'));?>
     <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                           <header class="panel-heading">
                              Advanced Search
                          </header>
                          <div class="panel-body">
                              <form class="form-inline" action="" method="post">
                                  <div class="form-group">
                                      <label>Book Name (or) Book Id (or) ISBN</label>
                                      <input type="text" class="form-control" id="book_id1" value="<?php echo $this->input->cookie('book_id1'); ?>" >
                                      <div id="suggesstion-box"></div>
                                  </div>
                                  <div class="form-group">
                                      <label>Job Id : </label>
                                      <input type="text" class="form-control" id="job_id" value="<?php echo $this->input->cookie('job_id'); ?>" >
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
				$(".datepicker").val("");	
				document.cookie="book_id1=; path=/; expires=Thu, 01 Jan 1970 00:00:01 GMT;";
				document.cookie="job_id=; path=/; expires=Thu, 01 Jan 1970 00:00:01 GMT;";
				window.location.href = "<?php echo current_url();?>";
				
			});
			
				search_book_url = "<?php echo site_url() ?>orders/ajax_advanced_search_auto/";
		
			$("#book_id1").keyup(function(){
				$.ajax({
				type: "POST",
				url: search_book_url,
				data:'query='+$(this).val(),
				beforeSend: function(){
					$("#book_id1").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
				},
				success: function(data){
					
					$("#suggesstion-box").show();
					$("#suggesstion-box").html(data);
					$("#book_id1").css("background","#FFF");
				}
				});
			});
	
			$(document).on('click','.selectCountry',function(){
				country = $(this).html();
				$("#book_id1").val(country);
				$("#suggesstion-box").hide();
			});

			$("#filter").click(function(){
				book_id1 = $("#book_id1").val();
				job_id = $("#job_id").val();
				document.cookie='book_id1='+book_id1+';path=/';
				document.cookie='job_id='+job_id+';path=/';
			});
		
	})
</script>