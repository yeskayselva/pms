<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.png">

    <title><?php echo $title;?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url();?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
      <!--right slidebar-->
      <link href="<?php echo base_url();?>css/slidebars.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url();?>css/style.css" rel="stylesheet">
    <link href="<?php echo base_url();?>css/style-responsive.css" rel="stylesheet" />
	 <script src="<?php echo base_url();?>js/jquery.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>js/jquery.scrollTo.min.js"></script>
    <script src="<?php echo base_url();?>js/jquery.nicescroll.js" type="text/javascript"></script>

    <script src="<?php echo base_url();?>js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="<?php echo base_url();?>js/tooltip.js"></script>
	<script type="text/javascript">
	  var base_url = "<?php echo base_url(); ?>";
	  var site_url = "<?php echo site_url(); ?>";
	  var current_url = "<?php echo current_url(); ?>";
	  var limit_cookie = "<?php echo $limit_cookie; ?>";
	  var search_cookie = "<?php echo $search_cookie; ?>";
	  var fetch_class = "<?php echo $this->router->fetch_class(); ?>";
	  var fetch_method = "<?php echo $this->router->fetch_method(); ?>";
	  var add_link = "<?php echo my_site_url();?>"+fetch_class+'/add_'+fetch_class;
	  var delete_link = "<?php echo my_site_url();?>"+fetch_class+'/delete';
	</script>
	<script src="<?php echo base_url();?>js/default.js"></script>
  </head>

  <body>

  <section id="container" class="">
      <!--header start-->
      <header class="header white-bg">
          <div class="sidebar-toggle-box">
              <div data-original-title="Toggle Navigation" data-placement="right" class="fa fa-bars tooltips"></div>
          </div>
          <!--logo start-->
          
          <a href="index.html" class="logo"><img style="height: 40px;" class="logoImage" src="<?php echo base_url('img/notionlogo.png'); ?>" data-pin-nopin="true"></span></a>
          <!--logo end-->
         
          <div class="top-nav ">
              <ul class="nav pull-right top-menu">
                  <li>
                     <!-- <input type="text" class="form-control search" placeholder="Search">-->
                  </li>
                  <!-- user login dropdown start-->
                  <li class="dropdown">
                      <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                          <img alt="" src="<?php echo base_url();?>img/avatar1_small.jpg">
                          <span class="username"><?php echo $this->session->userdata('adminName');?></span>
                          <b class="caret"></b>
                      </a>
                      <ul class="dropdown-menu extended logout">
                          <div class="log-arrow-up"></div>
                          <li><a href="<?php echo site_url('login/logout');?>"><i class="fa fa-key"></i> Log Out</a></li>
                      </ul>
                  </li>
              </ul>
          </div>
      </header>