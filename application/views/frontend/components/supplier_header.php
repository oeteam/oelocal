<?php 
  $this->load->helper("common");
  $id=$this->session->userdata('agent_id');
  $name=$this->session->userdata('agent_name');
  $flag=$this->session->userdata('currency');
  $view = agent_image();
  $contry = contry_image();
  $data = title();
  $flag_i = substr($flag, 0, 2);
  $flag_img = strtolower($flag_i);
  $record_num = $this->uri->segment_array();
?>
<!DOCTYPE html>
<html>
  <head>
  	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo base_url() ?>assets/images/fav.ico">
    <title><?php echo $data[0]->Title ?></title>
    <link rel="shortcut icon" href="<?php echo base_url() ?>assets/images/fav.ico">
    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>skin/dist/css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="<?php echo base_url(); ?>skin/assets/css/custom.css" rel="stylesheet" media="screen">
    <link href="<?php echo base_url(); ?>skin/assets/css/dashboard.css" rel="stylesheet" media="screen">
    <!-- Carousel -->
	  <link href="<?php echo base_url(); ?>skin/examples/carousel/carousel.css" rel="stylesheet">
    <!-- Font-Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>skin/assets/css/font-awesome.css" media="screen" /> -->
  	<!-- PIECHART -->
  	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>skin/assets/css/jquery.easy-pie-chart.css">
    <!-- MORRIS CHARTS -->
    <!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css"> -->

    <link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
   
    
    <!-- Picker UI-->	
	  <link rel="stylesheet" href="<?php echo base_url(); ?>skin/assets/css/jquery-ui.css" />		
    <link rel="stylesheet" href="<?php echo base_url(); ?>skin/assets/css/jquery.dataTables.min.css" />  
    <!-- jQuery -->	

    <script src="<?php echo base_url(); ?>skin/assets/js/jquery.v2.0.3.js"></script>
    <script src="<?php echo base_url(); ?>skin/assets/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src='http://maps.google.com/maps/api/js?key=AIzaSyAbjpN_xqyT_yhaKh0ikHujN_xCX7KWot4&sensor=false&libraries=places'></script>
    <script type="text/javascript">
        var base_url = "<?php  echo base_url();?>"; 
    </script> 
    <script src="<?php echo base_url(); ?>skin/js/jquery.toaster.js"></script>
    <script src="<?php echo base_url(); ?>skin/js/tost.js"></script>
    <script src="<?php echo base_url(); ?>skin/js/common.js"></script>
    <script src="<?php echo base_url('assets/js/bootstrap-multiselect.js'); ?>"></script>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-multiselect.css'); ?>"></link>
    <style>
    .timeline {
      list-style: none;
      padding-left: 0;
      position: relative;
    }
    .timeline:after {
      content: "";
      height: auto;
      width: 1px;
      background: #e3e3e3;
      position: absolute;
      top: 5px;
      left: 30px;
      bottom: 25px;
    }
    .timeline.timeline-sm:after {
      left: 12px;
    }
    .timeline li {
      position: relative;
      padding-left: 70px;
      margin-bottom: 20px;
    }
    .timeline li:after {
      content: "";
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background: #e3e3e3;
      position: absolute;
      left: 24px;
      top: 5px;
    } 
    .timeline .timeline-icon img {
       border-radius: 50%;
       height: 30px;
    }
    .timeline li .timeline-date {
      display: inline-block;
      width: 100%;
      color: #a6a6a6;
      font-style: italic;
      font-size: 13px;
    }
    .timeline .timeline-icons li {
      padding-top: 7px;
    }
    .timeline.timeline-icons li:after {
      width: 32px;
      height: 32px;
      background: #fff;
      border: 1px solid #e3e3e3;
      left: 14px;
      top: 0;
      z-index: 11;
    }
    .timeline.timeline-icons li .timeline-icon {
      position: absolute;
      left: 23.5px;
      top: 1px;
      z-index: 12;
    }
    .timeline.timeline-icons li .timeline-icon [class*=glyphicon] {
      top: -1px !important;
    }
    .timeline.timeline-icons.timeline-sm li {
      padding-left: 40px;
      margin-bottom: 10px;
    }
    .timeline.timeline-icons.timeline-sm li:after {
      left: -5px;
    }
    .timeline.timeline-icons.timeline-sm li .timeline-icon {
      left: -4.5px;
    }
    .timeline.timeline-advanced li {
      padding-top: 0;
    }
    .timeline.timeline-advanced li:after {
      background: #fff;
      border: 1px solid #29b6d8;
    }
    .timeline.timeline-advanced li:before {
      content: "";
      width: 52px;
      height: 52px;
      border: 10px solid #fff;
      position: absolute;
      left: 4px;
      top: -10px;
      border-radius: 50%;
      z-index: 12;
    }
    .timeline.timeline-advanced li .timeline-icon {
      color: #29b6d8;
    }
    .timeline.timeline-advanced li .timeline-date {
      width: 75px;
      position: absolute;
      right: 5px;
      top: 3px;
      text-align: right;
    }
    .timeline.timeline-advanced li .timeline-title {
      font-size: 17px;
      margin-bottom: 0;
      padding-top: 5px;
      font-weight: bold;
    }
    .timeline.timeline-advanced li .timeline-subtitle {
      display: inline-block;
      width: 100%;
      color: #a6a6a6;
    }
    .timeline.timeline-advanced li .timeline-content {
      margin-top: 10px;
      margin-bottom: 10px;
      padding-right: 70px;
    }
    .timeline.timeline-advanced li .timeline-content p {
      margin-bottom: 3px;
    }
    .timeline.timeline-advanced li .timeline-content .divider-dashed {
      padding-top: 0px;
      margin-bottom: 7px;
      width: 200px;
    }
    .timeline.timeline-advanced li .timeline-user {
      display: inline-block;
      width: 100%;
      margin-bottom: 10px;
    }
    .timeline.timeline-advanced li .timeline-user:before,
    .timeline.timeline-advanced li .timeline-user:after {
      content: " ";
      display: table;
    }
    .timeline.timeline-advanced li .timeline-user:after {
      clear: both;
    }
    .timeline.timeline-advanced li .timeline-user .timeline-avatar {
      border-radius: 50%;
      width: 32px;
      height: 32px;
      float: left;
      margin-right: 10px;
    }
    .timeline.timeline-advanced li .timeline-user .timeline-user-name {
      font-weight: bold;
      margin-bottom: 0;
    }
    .timeline.timeline-advanced li .timeline-user .timeline-user-subtitle {
      color: #a6a6a6;
      margin-top: -4px;
      margin-bottom: 0;
    }
    .timeline.timeline-advanced li .timeline-link {
      margin-left: 5px;
      display: inline-block;
    }
    .timeline-load-more-btn {
      margin-left: 70px;
    }
    .timeline-load-more-btn i {
      margin-right: 5px;
    }
    /* -----------------------------------------
       Dropdown
    ----------------------------------------- */
    .dropdown-menu{
        padding:0 0 0 0;
    }
    a.dropdown-menu-header {
        background: #f7f9fe;
        font-weight: bold;
        border-bottom: 1px solid #e3e3e3;
    }
    .dropdown-menu > li a {
        padding: 10px 20px;
    }
  </style>
  </head>
  <!--Start of Tawk.to Script-->
  <script type="text/javascript">
	var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
	(function(){
	var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
	s1.async=true;
	s1.src='https://embed.tawk.to/5be3cfb370ff5a5a3a712774/default';
	s1.charset='UTF-8';
	s1.setAttribute('crossorigin','*');
	s0.parentNode.insertBefore(s1,s0);
	})();
  </script>
<!--End of Tawk.to Script-->
  <style type="text/css">
    .form-control[readonly] {
      cursor: default ! important;
      background-color: white ! important;
    }
    .dtxt {
      font-size: 12px;
    }
  </style>
  <body id="top">
  <!-- CONTENT -->
    <?php $all_notification_count = agent_portal_notify_count();
                        $all_count = count(($all_notification_count));
                        $notify = agent_portal_notify();
                      if (count($notify)!=0) {
                          $req_notify_arr= array();
                          $reject_notify_arr= array();
                          $approved_notify_arr= array();
                        foreach ($notify as $key => $value) {
                          if ($value->booking_flag==2) {
                            $req_notify_arr[$key] =  $value->booking_flag;
                          }
                          if ($value->booking_flag==0) {
                            $reject_notify_arr[$key] =  $value->booking_flag;
                          }
                          if ($value->booking_flag==1) {
                            $approved_notify_arr[$key] =  $value->booking_flag;
                          }
                        }
                        $req_notify= count($req_notify_arr);
                        $reject_notify= count($reject_notify_arr);
                        $approved_notify= count($approved_notify_arr);
                        $notify_count = $req_notify+$reject_notify+$approved_notify;
                      } else {
                         $notify_count = "0";
                        }
                  ?>
    <div class="container2">        
        <div class="navbar-collapse collapse" style="background-color: #0074b9">
        	<div class="row">
        	<div class="col-md-offset-2 col-md-8">
                      <a href="#"><img src="<?php echo base_url(); ?>skin/images/dash/logo.png" width="109px;height: 40px;" alt="" style="background: aliceblue"/></a>                      
            <ul class="nav navbar-nav navbar-right">
            	 		<li><a href="<?php echo base_url(); ?>dashboard">Dashboard</a></li>
                       <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="fa fa-bell-o" aria-hidden="true"></i><span class="d-mes active"><?php echo $notify_count ?></span></a>
                            <ul class="dropdown-menu">
                              <li role="presentation">
                                <a href="#" class="dropdown-menu-header">Notifications</a>
                              </li>
                                <?php  if ($notify_count!=0) { ?>
                                  <ul class="timeline timeline-icons timeline-sm" style="margin:10px;width:210px">
                                    <?php foreach ($notify as $key => $value) {
                                      if ($value->booking_flag==1) { ?>
                                        <?php if ($value->readed==2){ ?>
                                              <li class='msgbox  offset-0'>
                                            <?php }else{ ?><li class='msgbox read offset-0'><?php } ?>
                                            <a href='<?php echo base_url(); ?>Payment/agent_booking_view?id=<?php echo $value->bk_id?>'><span class="timeline-icon"><img src='<?php echo base_url(); ?>uploads/rooms/<?php echo $value->room_id ?>/<?php echo $value->images ?>' alt='' width='30' class='left margright10 roundav'/></span>
                                          <span class='opensans size13 dark'><b><?php echo $value->hotel_name ?></b></span><br/><span class='opensans size12'><?php echo $value->hotel_name ?> Approved your booking</span></a></li>
                                      <?php } 
                                      if ($value->booking_flag==0) { ?>
                                        <?php if ($value->readed==2){ ?>
                                              <li class='msgbox  offset-0'>
                                            <?php }else{ ?><li class='msgbox read offset-0'><?php } ?><a href='<?php echo base_url(); ?>Payment/agent_booking_view?id=<?php echo $value->bk_id?>'><span class="timeline-icon"><img src='<?php echo base_url(); ?>uploads/rooms/<?php echo $value->room_id ?>/<?php echo $value->images ?>' alt='' width='30' class='left margright10 roundav'/></span>
                                          <span class='opensans size13 dark'><b> Rejected request</b> </span><br/><span class='opensans size12'><?php echo $value->hotel_name ?> rejected your booking</span></a></li>
                                      <?php }
                                      if ($value->booking_flag==2) { ?>
                                        <?php if ($value->readed==2){ ?>
                                              <li class='msgbox  offset-0'>
                                              <?php }else{ ?><li class='msgbox read offset-0'><?php } ?><a href='<?php echo base_url(); ?>Payment/agent_booking_view?id=<?php echo $value->bk_id?>'><span class="timeline-icon"><img src='<?php echo base_url(); ?>uploads/rooms/<?php echo $value->room_id ?>/<?php echo $value->images ?>' alt='' width='30' class='left margright10 roundav'/></span>
                                            <span class='opensans size13 dark'><b>New booking request</b></span></br><span class='opensans size12 dark'>You are booked <?php echo $value->hotel_name ?></span></a></li>
                                      <?php } ?>
                                    <?php }  ?>
                                  </ul>
                                     <li class='text-center viewmore'><a href='<?php echo base_url(); ?>Payment/all_notification'>view more</a></li>
                                <?php }  else { ?>
                                   <li class='text-center viewmore'><a href="#">No Notifications</a></li> 
                               <?php } ?>
                             
                            </ul>
                            <li><a href="<?php echo base_url(); ?>backend/logout/agent_logout">Logout</a></li>
                      </ul> 
                      </div>
                    </div>
                 </div>
              <!-- LEFT MENU -->
              <div class="row" style="background: black">
    <div class="col-md-offset-2 col-md-8" style="height: 58px">
      <ul class="nav nav-tabs myTab2pos">
          <li>
              <a href="<?php echo base_url('HotelSupplier')?>">
                  Booking
              </a>
          </li>
          <li>
              <a href="<?php echo base_url('HotelSupplier/hotels')?>">              
                Hotels
              </a>
          </li>
          <li>
              <a href="<?php echo base_url('HotelSupplier/rooms')?>">              
                Rooms
              </a>
          </li>
      </ul>
    </div>
  </div>


