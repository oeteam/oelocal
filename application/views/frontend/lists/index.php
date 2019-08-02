<?php init_front_head(); ?> 
<?php init_front_head_menu(); ?> 
<!-- <script type="text/javascript" src='http://maps.google.com/maps/api/js?key=AIzaSyAbjpN_xqyT_yhaKh0ikHujN_xCX7KWot4&libraries=places'></script> -->
<script type="text/javascript" src="<?php echo base_url(); ?>skin/js/list.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>skin/js/destination_autocomplete.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/advertisement.js"></script>
<script>
    FullLoading('start', '<?php echo $_REQUEST['location'] ?>', '<?php echo date('d/m/Y' ,strtotime($_REQUEST['Check_in'])) ?>', '<?php echo date('d/m/Y' ,strtotime($_REQUEST['Check_out'])) ?>');
	$(document).ready(function() {
		var nextDay = new Date($("#datepicker").val());
		nextDay.setDate(nextDay.getDate() + 1);
		$("#datepicker").datepicker({
			minDate: 0,
			altField: "#alternate",
			altFormat: "dd/mm/yy",
			onSelect: function(dateText) {
				var nextDay = new Date(dateText);
				nextDay.setDate(nextDay.getDate() + 1);
				$("#datepicker2").datepicker('option', 'minDate', nextDay);
				total_night_calc1();
				setTimeout(function(){
					$( "#datepicker2" ).datepicker('show');
				}, 16);     
			}
		});
		$("#datepicker2").datepicker({
			minDate: nextDay,
			altField: "#alternate2",
			altFormat: "dd/mm/yy",
			onSelect: function(dateText) {
				total_night_calc1();
			}
		});
		$("#alternate").click(function() {
			$( "#datepicker" ).trigger('focus');
		});
		$("#alternate2").click(function() {
			$( "#datepicker2" ).trigger('focus');
		});

		/*Mobile view*/

		var nextDay = new Date($("#datepickersm").val());
		nextDay.setDate(nextDay.getDate() + 1);
		$("#datepickersm").datepicker({
			minDate: 0,
			altField: "#alternatesm",
			altFormat: "dd/mm/yy",
			onSelect: function(dateText) {
				var nextDay = new Date(dateText);
				nextDay.setDate(nextDay.getDate() + 1);
				$("#datepicker2sm").datepicker('option', 'minDate', nextDay);
				total_night_calc1();
				setTimeout(function(){
					$( "#datepicker2sm" ).datepicker('show');
				}, 16);     
			}
		});
		$("#datepicker2sm").datepicker({
			minDate: nextDay,
			altField: "#alternate2",
			altFormat: "dd/mm/yy",
			onSelect: function(dateText) {
				total_night_calc1();
			}
		});
		$("#alternatesm").click(function() {
			$( "#datepickersm" ).trigger('focus');
		});
		$("#alternate2sm").click(function() {
			$( "#datepicker2sm" ).trigger('focus');
		});
   

	  <?php for ($l = 1; $l <=11 ; $l++) { ?>
	  	$(".room<?php echo $l ?> .room<?php echo $l ?>-child").change(function() {
	  		var room = $(this).val();
	  		<?php for ($k = 1; $k <= 4; $k++) { ?>
	  			$(".room<?php echo $l ?>-child<?php echo $k ?>").addClass('hide');
	  			$(".room<?php echo $l ?>-childAges<?php echo $k ?>").attr("disabled","disabled");
	  		<?php } ?>
	  		if (room!=0) {
	  			if (room==1) {
	  				$(".room<?php echo $l ?>-child-p").text("Child Age");
	  			} else {
	  				$(".room<?php echo $l ?>-child-p").text("Children Age");
	  			}
	  			$(".room<?php echo $l ?>-childAge").removeClass('hide');

	  			for (var k = 1; k <= room; k++) {
	  				$(".room<?php echo $l ?>-child"+k).removeClass('hide');
	  				$(".room<?php echo $l ?>-childAges"+k).removeAttr("disabled");
	  			}
	  		} else {
	  			$(".room<?php echo $l ?>-childAge").addClass('hide');
	  		}
	  	});
	  <?php } ?>

	});

</script>
<script>
	$(document).ready(function(){
		$('#result_search').on('click','.hotel-more-btn1', function(e){
			$(e.target).closest('.labelright').find('.hotel-view-btn').trigger('click');
		})


		$(document).on('click','.hotel-details' ,function() {
		    $(this).closest('.itemlabel3').find(".hotel-view-btn").trigger("click");
		})


	})

	<?php for ($i = 1; $i <= 10; $i++) {  ?>
		function addroomcustom<?php echo $i ?>(id){
			$('.room<?php echo $i ?>').addClass('block');
			$('.room<?php echo $i ?>').removeClass('none');

			$("#room"+id+"-adults").removeAttr("disabled");
			$("#room"+id+"-adultssm").removeAttr("disabled");
			$(".room"+id+"-child").removeAttr("disabled");

			$('.addroom<?php echo $i-1 ?>').removeClass('block');
			$('.addroom<?php echo $i-1 ?>').addClass('none');
		}
		function removeroomcustom<?php echo $i ?>(id){
			$('.room<?php echo $i ?>').addClass('none');
			$('.room<?php echo $i ?>').removeClass('block');

			$('.addroom<?php echo $i-1 ?>').removeClass('none');
			$('.addroom<?php echo $i-1 ?>').addClass('block');			
			$("#room"+id+"-adults").attr("disabled","disabled");
			$("#room"+id+"-adultssm").attr("disabled","disabled");
			$(".room"+id+"-child").attr("disabled","disabled");
		}
	<?php } ?>
	function tokenSetfn(url,name,adrs,pic,code,rating) {
		$.ajax({
		    dataType: 'json',
		    type: 'post',
		    url: base_url+'lists/bookredirectdata?name='+name+',&adrs='+adrs+'&pic='+pic+'&rating='+rating+'&code='+code+'&sessionid=',
		    cache: false,
		    success: function (respose) {
		     	strdate = new Date();
		        var date = moment(strdate).format('YYYYMMDDHHmmss');
		        window.location = url+"&token="+date;
			// window.open(url+"&token="+date,'_blank');
		    }, 
		   error: function(xhr,err){
    			strdate = new Date();
			var date = moment(strdate).format('YYYYMMDDHHmmss');
		        window.location = url+"&token="+date;
			// window.open(url+"&token="+date,'_blank');
		   }
		});
	}

</script>
<style>

.carousel {
      margin: 0 15px 40px;
      border-radius: 5px;
      overflow: hidden;
}

.carousel .item {
  height: 75px ! important;
  background-color: aliceblue;
}

.carousel-control {
  width: 5%;
}

.corousel-control.right {
  background-image: linear-gradient(to right, rgba(0, 0, 0, 0.0001) 0, rgba(0, 0, 0, 0.5) 100%);
}

.carousel-control .fa-chevron-left, .carousel-control .fa-chevron-right {
  line-height: 70px;
}

.hotel-slider--img {
    width: 125px !important;
    min-width: 125px !important;
    height: 100% !important;
    object-fit: fill !important;
}

.hotel-slider--info {
    width: 59%;
    float: left;
    padding: 5px 15px;
    margin-left: 125px;
    overflow: hidden;
}

.hotel-slider__name {
    margin: 0 0 3px;
    color: #0e87c3;
    font-family: 'Open Sans';
    font-weight: bold;
}

.hotel-slider__room {
  margin: 0;
}

.hotel-slider--book {
    text-align: center;
    width: 20%;
    float: right;
    margin-right: 2%;
}

.hotel-slider--book > p {
    margin-bottom: 5px;
    margin-top: 10px;
    font-size: 16px;
    font-weight: bold;
 }

.hotel-slider--book .hotel-view-btn {
  margin-top: 0;
  /*background-color: green;*/
  /*border-color: green;*/
  padding: 0;
  width: 60%;
  margin: 0 auto;
}

</style>
<style type="text/css"> 
.date-picker-wrapper {
	/*left: 414.234px ! important;*/
	top: 412px ! important;
}
.rate-size img {
	width: 60px ! important;
	padding-bottom :5px !important;
}
</style>
<style>
        .full-loading {
            position: fixed;
            top: 0;
            width: 100%;
            bottom: 0;
            left: 0;
            background-color: #006699;
            text-align: center;
            /*font-family: 'Titillium Web';*/
            z-index: 9999999;
        }
        
        .full-loading img {
            width: 30vw;
            position: relative;
            top: -3em;
        }
        
        .fl-data {
            position: relative;
            top: -9vw;
        }
        
        .fl-title {
            text-transform: uppercase;
            margin: 0;
            letter-spacing: 2px;
            color: white;
        }
        
        .fl-subtext {
            margin: 0;
            color: white;
        }
        
        .fl-info-card {
            height: 170px;
            width: 450px;
            margin: 1.5em auto 0;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 1px 0 #ccc;
            overflow: hidden;
        }
        
        .fl-info-card .top {
            height: 70px;
            background-color: #0784ff;
            padding: 0 15px;
        }
        
        .fl-info-card .top>p {
            margin: 0;
            text-transform: uppercase;
            font-size: 20px;
            line-height: 1.5;
            color: #fff;
            font-weight: bold;
            letter-spacing: 1px;
        }
        
        .fl-info-card .top>span {
            display: block;
            text-transform: uppercase;
            font-size: 12px;
            padding-top: 10px;
            color: rgba(255, 255, 255, 0.5);
        }
        
        .fl-info-card .mid {
            display: flex;
            border-bottom: 2px solid #F5F5F5;
        }
        
        .fl-info-card .mid>div {
            flex: 1;
            padding: 10px;
            position: relative;
        }
        
        .fl-info-card .mid>div:first-child::after {
            content: "";
            height: 60%;
            background-color: #F5F5F5;
            width: 2px;
            position: absolute;
            right: 0;
            top: 20%;
        }
        
        .fl-info-card .mid>div>p {
            margin: 0;
            color: #0784ff;
        }
        
        .fl-info-card .mid>div>span {
            color: #9E9E9E;
            font-size: 14px;
        }

.hotelstab2         {
	position: relative;
}
.search-dropdown {
    position: absolute;
    max-height: 200px;
    top: 50px;
    left: 0;
    z-index: 1000;
    width: 99.7%;
    padding: 0;
    margin: 0;
    font-size: 12px;
    list-style: none;
    background-color: #ffffff;
    border: 1px solid rgba(0, 0, 0, 0.15);
    border-radius: 4px;
    -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
}
.search-dropdown li {
	padding: 3px 8px;
	cursor: pointer;
}
.focus-li > a > i {
	color: #72bf66;
}
.focus-li {
    background-color: #eee;
}
.search-dropdown li:hover {
	background-color: #eee;
}
.search-dropdown li > a > i {
	margin-right: 8px;
}
.search-dropdown li:hover > a > i {
	color: #72bf66;
}
.search-dropdown li a {
	text-decoration: none;
	width: 100%;
	display: block;
	letter-spacing: .5px;
}
.search-dropdown li > a > span {
	color: #9e9e9e;
	font-size: 80%;
	letter-spacing: .5px;
}
.hotel-more-btn1 {
	color: #808080;
    width: 60%;
    display: block;
    margin: 0 auto;
    text-align: center;
    margin-top: 10px;
    opacity: .8;
    cursor: pointer;
}
.bottom-btn-sm {
	  	    width: 25%;
		    height: 55px;
		    background: rgba(0, 102, 153, 0.87);
		    color: white;
		    font-size: 21px;
		    float: left;
		    margin: 0px;
		    border: 1px solid white;
		  }
  .filter-drom-sm {
  	    float: left;
	    display: block;
	    border: 1px solid white;
	    background: #04557d;
	    color: white;
        width: 100%;
  }
@media (max-width: 767px) {
	.narrow-sm {
		line-height: 147px ! important;
	}
	.listitem4 {
		height: 111px ! important;
	}
	.hotel-rating {
	  	width: 75px ! important;
	  	font-size: 11px ! important;
	  }
	  .hotel-view-btn {
	  	font-size: 14px ! important;
	  }
	  .review-sm {
		display: block;
	}
}	
@media only screen and (max-width: 480px) and (min-width: 320px) {
	     .fl-info-card {
	        width: 80% ! important;
		    flex: 1 ! important;
		    margin-top: 28px ! important;
	     }
	     .fl-title {
     	    font-size: 11px ! important;
   			margin-top: 62px ! important;
	     }
	     .full-loading img {
    		top: 25px ! important;
	     }
	     .fl-info-card .top p {
     	    font-size: 14px ! important;
	     }
	     .fl-data {
     	    width: 99% ! important;
    		margin: 0 auto ! important;
	     }
	     .container-sm {
     	    margin: 0px ! important;
		    padding: 0px ! important;
		    margin-top: 60px ! important;
		    /*position: fixed ! important;*/
	     }
	     .filtertip {
	     	height: 32px ! important;
	     }
	     .narrow-sm {
	     	line-height: 32px ! important;
	     }
	     .no-records {
     	    width: 80% ! important;
    		margin: 0 auto ! important;
	     }
	     
		  .hotel-rating {
		  	width: 65px ! important;
		  	font-size: 9px ! important;
		  }
		  .hotel-view-btn {
		  	font-size: 11px ! important;
		  	margin-top: 5px ! important;
		  }
		  .rightcontent {
		  	margin-top: -35px ! important;
		  }
	}
</style>
<div class="clearfix"></div>
<div class="container breadcrub hidden-xs">
	<div>
		<a class="homebtn left" href="<?php echo base_url(); ?>/hotels"></a>
		<div class="left">
			<ul class="bcrumbs">
				<li>/</li>
				<li><a href="#">Hotels</a></li>
				<?php if (isset($_REQUEST['location'])) { ?>
					<li>/</li>
					<li><a href="#"><?php echo isset($_REQUEST['location']) ? $_REQUEST['location'] : '' ?></a></li>
				<?php } ?>
				<?php if (isset($_REQUEST['hotel_name']) && $_REQUEST['hotel_name']!="") { ?>
					<li>/</li>					
					<li><a href="#" class="active"><?php echo isset($_REQUEST['hotel_name']) ? $_REQUEST['hotel_name'] : '' ?></a></li>	
				<?php } ?>				
			</ul>				
		</div>
		<a class="backbtn right" href="<?php echo base_url(); ?>hotels"></a>
	</div>
	<div class="clearfix"></div>
	<div class="brlines"></div>
</div>	

<!-- CONTENT -->
<div class="container container-sm">
	<div class="container pagecontainer offset-0">	

			<!-- FILTERS -->
			<div class="col-md-3 filters offset-0">
				<!-- TOP TIP -->
				<div class="filtertip">
					<div class="padding20 hidden-xs">
						<p class="size13">
							Total 
							<span class="size18 bold counthotel"></span> <span class="htlcnt">Hotels</span> </p>
							<p class="size13">starting at</p>
							<p class="size30 bold"><?php echo $agent_currency; ?> <span class="countprice"></span></p>
							<p class="size13">Narrow results 
						</p>
					</div>
					<p class="hidden-lg hidden-md narrow-sm"> Total <span class="size18 bold counthotel"></span> <span class="htlcnt">Hotels</span>
						<span class="size13">starting at </span><span class="size18 bold"><?php echo $agent_currency; ?> <span class="countprice"></span></span> <span class="size13">Narrow results</span>
					</p>
					<div class="tip-arrow"></div>
				</div>
					<div class="bookfilters hpadding20 hidden-xs">
						<form id="Mian_search_form"  method="get">
							<input type="hidden" class="citycode" name="citycode"  value="<?php echo $_REQUEST['citycode'] ?>">
							<input type="hidden" class="cityname" name="cityname"  value="<?php echo $_REQUEST['cityname'] ?>">
							<input type="hidden" class="countryname" name="countryname" value="<?php echo $_REQUEST['countryname'] ?>">

							<input type="hidden" name="page" value="<?php isset($_REQUEST['page']) ? $_REQUEST['page'] : "1" ?>">
							<input type="hidden" name="view_type" value="<?php echo isset($_REQUEST['view_type']) ? $_REQUEST['view_type'] : 'list' ?>">
							<!-- HOTELS TAB -->
						<div class="hotelstab2">
							<span class="opensans size1 dest_err">Enter Destination</span>
							<input type="text" name="location" id="location" class="form-control" placeholder="Enter country name" value="<?php echo isset($_REQUEST['location']) ? $_REQUEST['location'] : '' ?>" autocomplete="off">
							
							<ul class="txtcountry search-dropdown" style="margin-right:0px;display:none;overflow-y: scroll;" role="menu" aria-labelledby="dropdownMenu"  id="DropdownCountry"></ul>
							<div class="clearfix pbottom15"></div>
							<span class="opensans size13 nat_err">Nationality</span>
							<select class="form-control" name="nationality" id="nationality">
								<?php foreach ($nationality as $key => $value) { ?>
									<option <?php echo isset($_REQUEST['nationality']) && $value->id==$_REQUEST['nationality'] ? 'selected' : '' ?> value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
								<?php } ?>
							</select>
							<div class="clearfix pbottom15"></div>
							<span class="opensans size13 htl_err">Hotel Name</span>
							<input type="text" name="hotel_name" id="hotel_name" class="form-control"  value="<?php echo isset($_REQUEST['hotel_name']) ? $_REQUEST['hotel_name'] : '' ?>">
							<div class="clearfix pbottom15"></div>
							<div class="w50percent">
								<div class=" textleft">
									<span class="opensans size13 chckin_err">Check in date</span>
									<input type="text"  style="width: 1000%;opacity: 0;height: 40px;"  class="mySelectCalendar" id="datepicker" name="Check_in" value="<?php echo isset($_REQUEST['Check_in']) ? $_REQUEST['Check_in'] : '' ?>" placeholder="dd/mm/yyyy"/>
								</div>
								<div class="input-group" style="transform: translateY(-34px);">
									<input type="text" name="" class="form-control" id="alternate" value="<?php echo isset($_REQUEST['Check_in']) ? date('d/m/Y' ,strtotime($_REQUEST['Check_in'])) : '' ?>">
									<label for="datepicker" class="input-group-addon" style="padding: 5px"><i class="fa fa-calendar"></i></label>
								</div>
							</div>

							<div class="w50percentlast">
								<div class=" textleft right">
									<span class="opensans size13 chckout_err">Check out date</span>
									<input type="text" style="width: 1000%;opacity: 0;height: 40px;"  class="mySelectCalendar" id="datepicker2" name="Check_out" value="<?php echo isset($_REQUEST['Check_out']) ? $_REQUEST['Check_out'] : '' ?>" placeholder="dd/mm/yyyy"/>
								</div>
								<div class="input-group" style="transform: translateY(-34px);">
									<input type="text" name="" class="form-control" id="alternate2" value="<?php echo isset($_REQUEST['Check_out']) ? date('d/m/Y' ,strtotime($_REQUEST['Check_out'])) : '' ?>">
									<label for="datepicker2" class="input-group-addon"  style="padding: 5px"><i class="fa fa-calendar"></i></label>
								</div>
							</div>
							
							<div class="clearfix pbottom15"></div>
							<input type="hidden" name="mark_up" value="<?php echo isset($_REQUEST['mark_up']) ? $_REQUEST['mark_up'] :'' ?>" class="form-control"/>
							
							<div class="room1" >
								<div class="w50percent">
									<div class="wh90percent textleft">
										<span class="opensans size13"><b>ROOM 1</b></span><br/>
										
										<!-- <div class="addroom1 block"><a onclick="addroom2()" class="grey cpointer">+ Add room</a></div> -->
									</div>
								</div>
								<div class="w50percentlast">	
									<div class="wh90percent textleft right ohidden">
										<div class="w50percent">
											<div class="wh90percent textleft left">
												<span class="opensans size13 adults_err">Adult </span>
												<?php if(!isset($_REQUEST['adults'][0]))
												$_REQUEST['adults'][0]="2";
												?>
												<select class="form-control mySelectBoxClass" name="adults[]" id="adults">
													<?php for ($i=1; $i <=10 ; $i++) { 
														if ($_REQUEST['adults'][0]==$i) {?>
															<option  selected="" value="<?php echo $i?>"><?php echo $i?></option>
														<?php } else { ?>
															<option value="<?php echo $i?>"><?php echo $i?></option>

														<?php 	}
													} ?>
												</select>
											</div>
										</div>							
										<div class="w50percentlast">
											<div class="wh90percent textleft right ohidden">
												<span class="opensans size13">Child</span>
												<select name="Child[]" class="form-control mySelectBoxClass room1-child">
													<?php for ($i=0; $i <5 ; $i++) { 
														if ($_REQUEST['Child'][0]==$i) {?>
															<option  selected="" value="<?php echo $i?>"><?php echo $i?></option>
														<?php } else { ?>
															<option value="<?php echo $i?>"><?php echo $i?></option>

														<?php 	}
													} ?>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="row room1-childAge <?php echo isset($_REQUEST['Child'][0]) && $_REQUEST['Child'][0]!="" && $_REQUEST['Child'][0]!=0 ? '' : 'hide' ?>" style="transform: translateX(-8px);margin: 0 -8px;">
									<p class="room1-child-p" style="padding-left: 15px;">Children Age</p>
									<?php for ($l=1; $l <= 4 ; $l++) {  ?>
										<div class="col-xs-3 room1-child<?php echo $l; ?> <?php echo isset($_REQUEST['Child'][0]) && $_REQUEST['Child'][0]!="" && $_REQUEST['Child'][0]!=0 && $_REQUEST['Child'][0] >= $l ? '' : 'hide' ?>" style="padding-right: 0;">
											<select name="room1-childAge[]" class="form-control mySelectBoxClass room1-childAges<?php echo $l; ?>" <?php echo isset($_REQUEST['Child'][0]) && $_REQUEST['Child'][0]!="" && $_REQUEST['Child'][0]!=0 && $_REQUEST['Child'][0] >= $l ? '' : 'disabled' ?>  id="room1-childAge<?php echo $l; ?>">
												<?php for ($i=0; $i <18 ; $i++) { 
													if (isset($_REQUEST['room1-childAge'][$l-1]) && $_REQUEST['room1-childAge'][$l-1]==$i) { ?>
														<option selected=""  value="<?php echo $i ?>"><?php echo $i ?></option>
													<?php } else { ?>
														<option  value="<?php echo $i ?>"><?php echo $i ?></option>
													<?php } } ?>
												</select>
											</div>
										<?php } ?>
									</div>
									<div class="row col-md-12">
										<div class="addroom1 <?php echo isset($_REQUEST['adults'][1]) ? 'none' : 'block'; ?>"><a onclick="addroomcustom2('2')" class="grey cpointer">+ Add room</a></div>
									</div>
								</div>

								<?php 
								for ($i=2; $i <=6 ; $i++) { ?>
									<div class="room<?php echo $i; ?> <?php echo isset($_REQUEST['adults'][$i-1]) ? 'block' : 'none' ?>">
										<div class="clearfix"></div>
										<div class="line1"></div>
										<div class="w50percent">
											<div class="wh90percent textleft">
												<span class="opensans size13"><b>ROOM <?php echo $i; ?></b></span><br/>
											</div>
										</div>

										<div class="w50percentlast">	
											<div class="wh90percent textleft right">
												<div class="w50percent">
													<div class="wh90percent textleft left">
														<span class="opensans size13">Adult</span>
														<select name="adults[]" class="form-control mySelectBoxClass" id="room<?php echo $i ?>-adults"  <?php echo isset($_REQUEST['adults'][$i-1]) ? '' : 'disabled' ?>>
															<?php for ($k=1; $k <=10 ; $k++) { ?>
																<option <?php echo isset($_REQUEST['adults'][$i-1]) && $_REQUEST['adults'][$i-1]==$k ? 'selected' : '' ?> value="<?php echo $k; ?>"><?php echo $k; ?></option>
															<?php } ?>
														</select>
													</div>
												</div>							
												<div class="w50percentlast">
													<div class="wh90percent textleft right">
														<span class="opensans size13">Child</span>
														<select name="Child[]" class="form-control mySelectBoxClass room<?php echo $i ?>-child" <?php echo isset($_REQUEST['Child'][$i-1]) ? '' : 'disabled' ?>>
															<?php for ($q=0; $q <=4 ; $q++) { ?>
																<option <?php echo isset($_REQUEST['Child'][$i-1]) && $_REQUEST['Child'][$i-1]==$q ? 'selected' : '' ?>><?php echo $q; ?></option>
															<?php } ?>
														</select>
													</div>
												</div>
											</div>
										</div>
										<div class="clearfix"></div>
										<div class="row room<?php echo $i; ?>-childAge <?php echo  isset($_REQUEST['room'.$i.'-childAge']) ? '' : 'hide' ?>" style="transform: translateX(-8px);margin: 0 -8px;">
											<p class="room<?php echo $i; ?>-child-p" style="padding-left: 15px;">Children Age</p>

											<?php for ($k=1; $k <=4 ; $k++) { ?>
												<div class="col-xs-3 room<?php echo $i; ?>-child<?php echo $k; ?> <?php echo isset($_REQUEST['room'.$i.'-childAge'][$k-1]) ? '' : 'hide' ?>" style="padding-right: 0;">
													<select name="room<?php echo $i; ?>-childAge[]" class="form-control mySelectBoxClass room<?php echo $i; ?>-childAges<?php echo $k ?> " id="room<?php echo $i; ?>-childAge" <?php echo isset($_REQUEST['room'.$i.'-childAge'][$k-1]) ? '' : 'disabled' ?> >
														<?php for ($j=0; $j <18 ; $j++) { ?>
															<option <?php echo isset($_REQUEST['room'.$i.'-childAge'][$k-1]) && $_REQUEST['room'.$i.'-childAge'][$k-1]==$j ? 'selected' : '' ?> value="<?php echo $j ?>"><?php echo $j ?></option>
														<?php } ?>
													</select>
												</div>
											<?php } ?>

										</div>
										<div class="row col-md-12">
											<?php if ($i!=6) { ?>
												<div class="addroom<?php echo $i; ?> <?php echo isset($_REQUEST['adults'][$i]) ? 'none' : 'block' ?>  grey"><a onclick="addroomcustom<?php echo $i+1; ?>(<?php echo $i+1; ?>)" class="grey cpointer">+ Add room</a> | <a onclick="removeroomcustom<?php echo $i; ?>(<?php echo $i; ?>)" class="orange cpointer"><img src="<?php echo base_url(); ?>skin/images/delete.png" alt="delete"/></a></div>
											<?php } else { ?>
												<a onclick="removeroomcustom<?php echo $i; ?>(<?php echo $i; ?>)" class="orange cpointer"><img src="<?php echo base_url(); ?>skin/images/delete.png" alt="delete"/></a>
											<?php } ?>
										</div>
									</div>
								<?php } ?>

								<div class="clearfix pbottom15"></div>
								<button type="button" id="search_button" class="btn-search3">Search</button>
							</div>
							<!-- END OF HOTELS TAB -->
							</form>
					</div>
						<!-- END OF BOOK FILTERS -->	

						<div class="line2 hidden-xs"></div>
						<form id="search_form"  method="post" class="hidden-xs">
							<input type="hidden" class="form-control b-r-40" name="citycode" class="citycode" value="<?php echo $_REQUEST['citycode'] ?>">
							<input type="hidden" class="form-control b-r-40" name="cityname" class="cityname" value="<?php echo $_REQUEST['cityname'] ?>">
							<input type="hidden" class="form-control b-r-40" name="countryname" class="countryname" value="<?php echo $_REQUEST['countryname'] ?>">
							<input type="hidden" name="mark_up" value="0">
							<input type="hidden" name="Check_in" value="<?php echo $_REQUEST['Check_in'] ?>">
							<input type="hidden" name="Check_out" value="<?php echo $_REQUEST['Check_out'] ?>">
							<input type="hidden" name="view_type" value="<?php echo $_REQUEST['view_type'] ?>">
							<input type="hidden" name="location" value="<?php echo $_REQUEST['location'] ?>">
							<input type="hidden" name="nationality" value="<?php echo $_REQUEST['nationality'] ?>">
							<input type="hidden" name="hotel_name" value="<?php echo $_REQUEST['hotel_name'] ?>">
							<input type="hidden" name="page" value="<?php isset($_REQUEST['page']) ? $_REQUEST['page'] : "1" ?>" id="page">
							<input type="hidden" name="view_type" id="view_type" value="<?php echo isset($_REQUEST['view_type']) ? $_REQUEST['view_type'] : 'list' ?>">
							<?php foreach ($_REQUEST['adults'] as $key => $value) { ?>
								<input type="hidden" name="adults[]" value="<?php echo $value ?>">
							<?php } ?>
							<?php foreach ($_REQUEST['Child'] as $key => $value) { ?>
								<input type="hidden" name="Child[]" value="<?php echo $value ?>">
							<?php } ?>
							<?php if (isset($_REQUEST['room1-childAge'])) {
									foreach ($_REQUEST['room1-childAge'] as $key => $value) { ?>
										<input type="hidden" name="room1-childAge[]" value="<?php echo $value; ?>">
							<?php   }
							} ?>
							<?php if (isset($_REQUEST['room2-childAge'])) {
									foreach ($_REQUEST['room2-childAge'] as $key => $value) { ?>
										<input type="hidden" name="room2-childAge[]" value="<?php echo $value; ?>">
							<?php   }
							} ?>
							<?php if (isset($_REQUEST['room3-childAge'])) {
									foreach ($_REQUEST['room3-childAge'] as $key => $value) { ?>
										<input type="hidden" name="room3-childAge[]" value="<?php echo $value; ?>">
							<?php   }
							} ?>
							<?php if (isset($_REQUEST['room4-childAge'])) {
									foreach ($_REQUEST['room4-childAge'] as $key => $value) { ?>
										<input type="hidden" name="room4-childAge[]" value="<?php echo $value; ?>">
							<?php   }
							} ?>
							<?php if (isset($_REQUEST['room5-childAge'])) {
									foreach ($_REQUEST['room5-childAge'] as $key => $value) { ?>
										<input type="hidden" name="room5-childAge[]" value="<?php echo $value; ?>">
							<?php   }
							} ?>
							<?php if (isset($_REQUEST['room6-childAge'])) {
									foreach ($_REQUEST['room6-childAge'] as $key => $value) { ?>
										<input type="hidden" name="room6-childAge[]" value="<?php echo $value; ?>">
							<?php   }
							} ?>
							<?php if (isset($_REQUEST['room7-childAge'])) {
									foreach ($_REQUEST['room7-childAge'] as $key => $value) { ?>
										<input type="hidden" name="room7-childAge[]" value="<?php echo $value; ?>">
							<?php   }
							} ?>
							<?php if (isset($_REQUEST['room8-childAge'])) {
									foreach ($_REQUEST['room8-childAge'] as $key => $value) { ?>
										<input type="hidden" name="room8-childAge[]" value="<?php echo $value; ?>">
							<?php   }
							} ?>
							<?php if (isset($_REQUEST['room9-childAge'])) {
									foreach ($_REQUEST['room9-childAge'] as $key => $value) { ?>
										<input type="hidden" name="room9-childAge[]" value="<?php echo $value; ?>">
							<?php   }
							} ?>
							<?php if (isset($_REQUEST['room10-childAge'])) {
									foreach ($_REQUEST['room10-childAge'] as $key => $value) { ?>
										<input type="hidden" name="room10-childAge[]" value="<?php echo $value; ?>">
							<?php   }
							} ?>
						<div class="hidden-xs"><h3 class="opensans dark">Filter by</h3></div>
						<div class="line2 hidden-xs"></div>
						<!-- Board -->	

						<!-- Star ratings -->	
						<button type="button" class="collapsebtn hidden-xs" data-toggle="collapse" data-target="#collapse1">
							Star rating <span class="collapsearrow"></span>
						</button>
						<div id="collapse1" class="collapse in hidden-xs">
							<div class="hpadding20">
								<div class="checkbox">
									<label>
									<?php if(isset($_REQUEST['rating5']) && $_REQUEST['rating5']=="5") { ?>
										<input type="checkbox" class="rating" checked="" name="rating5" value="5">
									<?php } else { ?> 
										<input type="checkbox" class="rating"  name="rating5" value="5">
										<?php }?><img src="<?php echo base_url(); ?>skin/images/filter-rating-5.png" class="imgpos1" alt=""/> 5 Stars
									</label>
								</div>
								<div class="checkbox">
									<label>
									<?php if(isset($_REQUEST['rating4']) && $_REQUEST['rating4']=="4") { ?>
										<input type="checkbox" class="rating" checked="" name="rating4" value="4">
									<?php } else { ?> 
										<input type="checkbox" class="rating"  name="rating4" value="4">
										<?php }?><img src="<?php echo base_url(); ?>skin/images/filter-rating-4.png" class="imgpos1" alt=""/> 4 Stars
									</label>
								</div>
								<div class="checkbox">
									<label>
									<?php if(isset($_REQUEST['rating3']) && $_REQUEST['rating3']=="3") { ?>
										<input type="checkbox" class="rating" checked="" name="rating3" value="3">
									<?php } else { ?> 
										<input type="checkbox" class="rating"  name="rating3" value="3">
										<?php }?><img src="<?php echo base_url(); ?>skin/images/filter-rating-3.png" class="imgpos1" alt=""/> 3 Stars
									</label>
								</div>
								<div class="checkbox">
									<label>
									<?php if(isset($_REQUEST['rating2']) && $_REQUEST['rating2']=="2") { ?>
										<input type="checkbox" class="rating" checked="" name="rating2" value="2">
									<?php } else { ?> 
										<input type="checkbox" class="rating"  name="rating2" value="2">
										<?php }?><img src="<?php echo base_url(); ?>skin/images/filter-rating-2.png" class="imgpos1" alt=""/> 2 Stars
									</label>
								</div>
								<div class="checkbox">
									<label>
									<?php if(isset($_REQUEST['rating1']) && $_REQUEST['rating1']=="1") { ?>
										<input type="checkbox" class="rating" checked="" name="rating1" value="1">
									<?php } else { ?> 
										<input type="checkbox" class="rating"  name="rating1" value="1">
										<?php }?><img src="<?php echo base_url(); ?>skin/images/filter-rating-1.png" class="imgpos1" alt=""/> 1 Star
									</label>
								</div>
								<div class="checkbox">
									<label>
									<?php if(isset($_REQUEST['rating10']) && $_REQUEST['rating10']=="10") { ?>
										<input type="checkbox" class="rating" checked="" name="rating10" value="10">
									<?php } else { ?> 
										<input type="checkbox" class="rating"  name="rating10" value="10">
										<?php }?><i class="fa fa-building" style="margin-left: 10px; color: #1280b7;"></i> Appartment
									</label>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
												<!-- End of Star ratings -->	

						<div class="line2"></div>

												<!-- Price range -->					
						<button type="button" class="collapsebtn hide" data-toggle="collapse" data-target="#collapse2">
							Price range <?php echo $agent_currency; ?> <span class="collapsearrow"></span>
						</button>

												<div id="collapse2" class="collapse in hide">
													<div class="padding20">
														<div class="layout-slider wh100percent">
															<span class="cstyle09 Slider-class">
																<!-- <input id="Slider1" type="slider" name="price" value="10;10000" /> -->
															</span>
														</div>
														<script type="text/javascript" >
															// $(document).ready(function(){
															// 	$("#Slider1").slider({ from: <?php echo ceil(currency_type1(agent_currency(),"10")) ?>, to: <?php echo ceil(currency_type1(agent_currency(),"10000")) ?>, step: 5, smooth: true, round: 0, dimension: "&nbsp;<?php echo agent_currency(); ?>", skin: "round" });
															// })
														</script>
													</div>
												</div>

												<!-- End of Price range -->	

												<div class="line2"></div>

												<!-- Hotel Preferences -->
												<!-- <button type="button" class="collapsebtn last" data-toggle="collapse" data-target="#collapse4">
													Hotel Preferences <span class="collapsearrow"></span>
												</button>	 -->
												<!-- <div id="collapse4" class="collapse in">
													<div class="hpadding20">
														<div id="hotel_preference"></div>
														<?php foreach ($hotel_facilities_list as $key => $value) { ?>
															<div class="checkbox">
																<label>
																	<input name="preference[]" class="preference_filter"  type="checkbox" value="<?php echo $value->id ?>"><?php echo $value->Hotel_Facility ?>
																</label>
															</div>
														<?php } ?>
													</div>
													<div class="clearfix"></div>						
												</div>	 -->
												<!-- End of Hotel Preferences -->

												<!-- <div class="line2"></div> -->
												<div class="clearfix"></div>
												<br/>
												<br/>
												<br/>


											</div>
											<!-- END OF FILTERS -->

					<!-- LIST CONTENT-->
					<div class="rightcontent col-md-9 offset-0">
						<div class="spin-wrapper" style="display: none">
							<img src="<?php echo base_url(); ?>/assets/images/ellipsis-spinner.gif" alt="">
						</div>

						<div class="hpadding20">
							<!-- Top filters -->
						<div class="topsortby hidden-xs">
							<div class="col-md-4 col-lg-3 offset-0">

								<div class="left mt7"><b>Sort by:</b></div>

								<div class="right wh70percent">
									<select name="guest_rating" id="guest_rating" class="form-control mySelectBoxClass ">
										<option value="">Stars</option>
											<option  value="1">stars [5->1]</option>
											<option  value="2">stars [1->5]</option>
									</select>
								</div>

						</div>			
						<div class="col-md-2 col-lg-3">
							<div class="w90percent">
								<div class="wh90percent">
									<select name="name_order" id="name_order" class="form-control mySelectBoxClass ">
										<option selected>Name</option>
										<option value="1">A to Z</option>
										<option value="2">Z to A</option>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-2 col-lg-2">
							<div class="w90percentlast">
								<div class="wh100percent">
									<select name="price_order" id="price_order" class="form-control mySelectBoxClass ">
									  <option selected>Price</option>
									  <option value="1">Low - High</option>
									  <option value="2">High - Low</option>
									</select>
								</div>
							</div>					
						</div>
						<div class="col-md-4 col-lg-4 offset-0 hidden-xs">
							<button type="button" class="popularbtn left hidden-md">Most Popular</button>
							<div class="right">
								<button type="button" class="gridbtn">&nbsp;</button>
								<button type="button" class="listbtn active">&nbsp;</button>
								<button type="button"  class="grid2btn">&nbsp;</button>
							</div>
						</div>
					</div>
					<input type="hidden" name="hotel_id" id="hotel_id">
					<input type="hidden" name="roomIndex" id="roomIndex">
					<input type="hidden" name="resultIndex" id="resultIndex">
					<input type="hidden" name="Reqtype" id="Reqtype">
					<input type="hidden" name="roomName" id="roomName">
					<input type="hidden" name="temp" id="temp" value="1">
					<textarea name="listarray" id="listarray"
					 style="display:none;"/>
						<?php echo json_encode($list); ?>
					</textarea>
				</form>
				<!-- End of topfilters-->
			</div>
			<!-- End of padding -->

			<br/><br/>
			<div class="clearfix"></div>

			<div class="itemscontainer offset-1" style="height: 869px;overflow-y: scroll;padding-bottom: 40px;">
				<div id="rotateBanner"></div>
				<div id="result_search" class="shide" >
					
				</div>
				
        	</div>
        	<div class="hidden-lg hidden-md">
		        <div class="row" style="position: fixed;width: 100%;display: block;margin: -1.5px;bottom: 0;">
		        	<button class="bottom-btn-sm" data-toggle="modal" data-target="#searchModal"><i class="fa fa-search"></i></button>
		        	<div class="btn-group dropup" style="width: 25%;float: left">
					  	<button type="button" style="width: 100%" class="bottom-btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    <i class="fa fa-money"></i>
					  	</button>
						  <div class="dropdown-menu">
						    <li class="btn filter-drom-sm" onclick="filtersmrate('1')" style="">Low to High</li>
						    <li class="btn filter-drom-sm" onclick="filtersmrate('2')" style="">High to Low</li>
						  </div>
					</div>
					<div class="btn-group dropup" style="width: 25%;float: left">
			        	<button style="width: 100%" class="bottom-btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-star-half-o"></i></button>
			        	<div class="dropdown-menu">
						    <li class="btn filter-drom-sm" onclick="filtersmstar('1')">5 to 1</li>
						    <li class="btn filter-drom-sm" onclick="filtersmstar('1')">1 to 5</li>
					    </div>
					</div>
		        	<button class="bottom-btn-sm" data-toggle="modal" data-target="#filterModal"><i class="fa fa-filter"></i></button>
		        </div>	
		    </div>
    </div>
    
    <!-- END OF LIST CONTENT-->



</div>
<!-- END OF container-->

</div>
<!-- END OF CONTENT -->

<script type="text/javascript">
	$(document).ready(function() {
		$(document).on('click', '[data-toggle="lightbox"]', function(event) {
		    $(".modal-body").html('<img width="100%" src="'+$(this).attr('href')+'"/>'); 
		});
	});
</script>
<div id="searchModal" class="modal bottom fade" role="dialog">
  <div class="modal-dialog" style="margin: 0;padding: 0;height: 100%;">

    <!-- Modal content-->
    <div class="modal-content" style="height: 100%;">
      <div class="modal-header" style="background: #006699;color: white;">
        <button type="button" class="close" data-dismiss="modal" style="opacity: 2;color: white;">&times;</button>
        <h4 class="modal-title">Search By</h4>
      </div>
      <div class="modal-body">
      	<form id="Mian_search_form_sm">
      		<input type="hidden" class="citycode" name="citycode"  value="<?php echo $_REQUEST['citycode'] ?>">
			<input type="hidden" class="cityname" name="cityname"  value="<?php echo $_REQUEST['cityname'] ?>">
			<input type="hidden" class="countryname" name="countryname" value="<?php echo $_REQUEST['countryname'] ?>">

			<input type="hidden" name="page" value="<?php isset($_REQUEST['page']) ? $_REQUEST['page'] : "1" ?>">
			<input type="hidden" name="view_type" value="<?php echo isset($_REQUEST['view_type']) ? $_REQUEST['view_type'] : 'list' ?>">
        	<div class="hotelstab2" style="overflow-y: scroll;height: 535px;overflow-x: hidden">
				<span class="opensans size1 dest_err">Enter Destination</span>
				<input type="text" name="location" id="locationsm" class="form-control" placeholder="Enter country name" value="<?php echo isset($_REQUEST['location']) ? $_REQUEST['location'] : '' ?>" autocomplete="off"  onkeyup="locationSearchfun()">
				
				<ul class="txtcountry search-dropdown" style="margin-right:0px;display:none;overflow-y: scroll;" role="menu" aria-labelledby="dropdownMenu"  id="DropdownCountrysm"></ul>
				<div class="clearfix pbottom15"></div>
				<span class="opensans size13 nat_err">Nationality</span>
				<select class="form-control" name="nationality" id="nationalitysm">
					<?php foreach ($nationality as $key => $value) { ?>
						<option <?php echo isset($_REQUEST['nationality']) && $value->id==$_REQUEST['nationality'] ? 'selected' : '' ?> value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
					<?php } ?>
				</select>
				<div class="clearfix pbottom15"></div>
				<span class="opensans size13 htl_err">Hotel Name</span>
				<input type="text" name="hotel_name" id="hotel_namesm" class="form-control"  value="<?php echo isset($_REQUEST['hotel_name']) ? $_REQUEST['hotel_name'] : '' ?>">
				<div class="clearfix pbottom15"></div>
				<div class=" textleft">
					<span class="opensans size13 chckin_err">Check in date</span>
					<input type="text"  style="width: 1000%;opacity: 0;height: 36px;"  class="mySelectCalendar" id="datepickersm" name="Check_in" value="<?php echo isset($_REQUEST['Check_in']) ? $_REQUEST['Check_in'] : '' ?>" placeholder="dd/mm/yyyy"/>
				</div>
				<div class="input-group" style="transform: translateY(-34px);">
					<input type="text" name="" class="form-control" id="alternatesm" value="<?php echo isset($_REQUEST['Check_in']) ? date('d/m/Y' ,strtotime($_REQUEST['Check_in'])) : '' ?>">
					<label for="datepicker" class="input-group-addon" style="padding: 5px"><i class="fa fa-calendar"></i></label>
				</div>
				<div class="clearfix pbottom15"></div>
				<div class=" textleft" style="margin-top:-26px; ">
					<span class="opensans size13 chckout_err">Check out date</span>
					<input type="text" style="width: 1000%;opacity: 0;height: 36px;"  class="mySelectCalendar" id="datepicker2sm" name="Check_out" value="<?php echo isset($_REQUEST['Check_out']) ? $_REQUEST['Check_out'] : '' ?>" placeholder="dd/mm/yyyy"/>
				</div>
				<div class="input-group" style="transform: translateY(-34px);">
					<input type="text" name="" class="form-control" id="alternate2sm" value="<?php echo isset($_REQUEST['Check_out']) ? date('d/m/Y' ,strtotime($_REQUEST['Check_out'])) : '' ?>">
					<label for="datepicker2" class="input-group-addon"  style="padding: 5px"><i class="fa fa-calendar"></i></label>
				</div>
				
				<div class="clearfix pbottom15"></div>
				<input type="hidden" name="mark_up" value="<?php echo isset($_REQUEST['mark_up']) ? $_REQUEST['mark_up'] :'' ?>" class="form-control"/>
				
				<div class="room1" >
					<div class="w50percent">
						<div class="wh90percent textleft">
							<span class="opensans size13"><b>ROOM 1</b></span><br/>
							
							<!-- <div class="addroom1 block"><a onclick="addroom2()" class="grey cpointer">+ Add room</a></div> -->
						</div>
					</div>
					<div class="w50percentlast">	
						<div class="wh90percent textleft right ohidden">
							<div class="w50percent">
								<div class="wh90percent textleft left">
									<span class="opensans size13 adults_err">Adult </span>
									<?php if(!isset($_REQUEST['adults'][0]))
									$_REQUEST['adults'][0]="2";
									?>
									<select class="form-control mySelectBoxClass" name="adults[]" id="adultssm">
										<?php for ($i=1; $i <=30 ; $i++) { 
											if ($_REQUEST['adults'][0]==$i) {?>
												<option  selected="" value="<?php echo $i?>"><?php echo $i?></option>
											<?php } else { ?>
												<option value="<?php echo $i?>"><?php echo $i?></option>

											<?php 	}
										} ?>
									</select>
								</div>
							</div>							
							<div class="w50percentlast">
								<div class="wh90percent textleft right ohidden">
									<span class="opensans size13">Child</span>
									<select name="Child[]" class="form-control mySelectBoxClass room1-child">
										<?php for ($i=0; $i <5 ; $i++) { 
											if ($_REQUEST['Child'][0]==$i) {?>
												<option  selected="" value="<?php echo $i?>"><?php echo $i?></option>
											<?php } else { ?>
												<option value="<?php echo $i?>"><?php echo $i?></option>

											<?php 	}
										} ?>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="row room1-childAge <?php echo isset($_REQUEST['Child'][0]) && $_REQUEST['Child'][0]!="" && $_REQUEST['Child'][0]!=0 ? '' : 'hide' ?>" style="transform: translateX(-8px);margin: 0 -8px;">
						<p class="room1-child-p" style="padding-left: 15px;">Children Age</p>
						<?php for ($l=1; $l <= 4 ; $l++) {  ?>
							<div class="col-xs-3 room1-child<?php echo $l; ?> <?php echo isset($_REQUEST['Child'][0]) && $_REQUEST['Child'][0]!="" && $_REQUEST['Child'][0]!=0 && $_REQUEST['Child'][0] >= $l ? '' : 'hide' ?>" style="padding-right: 0;">
								<select name="room1-childAge[]" class="form-control mySelectBoxClass room1-childAges<?php echo $l; ?>" <?php echo isset($_REQUEST['Child'][0]) && $_REQUEST['Child'][0]!="" && $_REQUEST['Child'][0]!=0 && $_REQUEST['Child'][0] >= $l ? '' : 'disabled' ?>  id="room1-childAge<?php echo $l; ?>">
									<?php for ($i=0; $i <18 ; $i++) { 
										if (isset($_REQUEST['room1-childAge'][$l-1]) && $_REQUEST['room1-childAge'][$l-1]==$i) { ?>
											<option selected=""  value="<?php echo $i ?>"><?php echo $i ?></option>
										<?php } else { ?>
											<option  value="<?php echo $i ?>"><?php echo $i ?></option>
										<?php } } ?>
									</select>
								</div>
							<?php } ?>
						</div>
						<div class="row col-md-12">
							<div class="addroom1 <?php echo isset($_REQUEST['adults'][1]) ? 'none' : 'block'; ?>"><a onclick="addroomcustom2('2')" class="grey cpointer">+ Add room</a></div>
						</div>
					</div>

					<?php 
					for ($i=2; $i <=10 ; $i++) { ?>
						<div class="room<?php echo $i; ?> <?php echo isset($_REQUEST['adults'][$i-1]) ? 'block' : 'none' ?>">
							<div class="clearfix"></div>
							<div class="line1"></div>
							<div class="w50percent">
								<div class="wh90percent textleft">
									<span class="opensans size13"><b>ROOM <?php echo $i; ?></b></span><br/>
								</div>
							</div>

							<div class="w50percentlast">	
								<div class="wh90percent textleft right">
									<div class="w50percent">
										<div class="wh90percent textleft left">
											<span class="opensans size13">Adult</span>
											<select name="adults[]" class="form-control mySelectBoxClass" id="room<?php echo $i ?>-adultssm"  <?php echo isset($_REQUEST['adults'][$i-1]) ? '' : 'disabled' ?>>
												<?php for ($k=1; $k <=30 ; $k++) { ?>
													<option <?php echo isset($_REQUEST['adults'][$i-1]) && $_REQUEST['adults'][$i-1]==$k ? 'selected' : '' ?> value="<?php echo $k; ?>"><?php echo $k; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>							
									<div class="w50percentlast">
										<div class="wh90percent textleft right">
											<span class="opensans size13">Child</span>
											<select name="Child[]" class="form-control mySelectBoxClass room<?php echo $i ?>-child" <?php echo isset($_REQUEST['Child'][$i-1]) ? '' : 'disabled' ?>>
												<?php for ($q=0; $q <=4 ; $q++) { ?>
													<option <?php echo isset($_REQUEST['Child'][$i-1]) && $_REQUEST['Child'][$i-1]==$q ? 'selected' : '' ?>><?php echo $q; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="row room<?php echo $i; ?>-childAge <?php echo  isset($_REQUEST['room'.$i.'-childAge']) ? '' : 'hide' ?>" style="transform: translateX(-8px);margin: 0 -8px;">
								<p class="room<?php echo $i; ?>-child-p" style="padding-left: 15px;">Children Age</p>

								<?php for ($k=1; $k <=4 ; $k++) { ?>
									<div class="col-xs-3 room<?php echo $i; ?>-child<?php echo $k; ?> <?php echo isset($_REQUEST['room'.$i.'-childAge'][$k-1]) ? '' : 'hide' ?>" style="padding-right: 0;">
										<select name="room<?php echo $i; ?>-childAge[]" class="form-control mySelectBoxClass room<?php echo $i; ?>-childAges<?php echo $k ?> " id="room<?php echo $i; ?>-childAge" <?php echo isset($_REQUEST['room'.$i.'-childAge'][$k-1]) ? '' : 'disabled' ?> >
											<?php for ($j=0; $j <18 ; $j++) { ?>
												<option <?php echo isset($_REQUEST['room'.$i.'-childAge'][$k-1]) && $_REQUEST['room'.$i.'-childAge'][$k-1]==$j ? 'selected' : '' ?> value="<?php echo $j ?>"><?php echo $j ?></option>
											<?php } ?>
										</select>
									</div>
								<?php } ?>

							</div>
							<div class="row col-md-12">
								<?php if ($i!=10) { ?>
									<div class="addroom<?php echo $i; ?> <?php echo isset($_REQUEST['adults'][$i]) ? 'none' : 'block' ?>  grey"><a onclick="addroomcustom<?php echo $i+1; ?>(<?php echo $i+1; ?>)" class="grey cpointer">+ Add room</a> | <a onclick="removeroomcustom<?php echo $i; ?>(<?php echo $i; ?>)" class="orange cpointer"><img src="<?php echo base_url(); ?>skin/images/delete.png" alt="delete"/></a></div>
								<?php } else { ?>
									<a onclick="removeroomcustom<?php echo $i; ?>(<?php echo $i; ?>)" class="orange cpointer"><img src="<?php echo base_url(); ?>skin/images/delete.png" alt="delete"/></a>
								<?php } ?>
							</div>
						</div>
					<?php } ?>

					<div class="clearfix pbottom15"></div>
					<button type="button" id="search_buttonsm" class="btn-search3 pbottom15" style="width: 100%;margin-bottom: 20px">Search</button>
				</div>
							<!-- END OF HOTELS TAB -->
			</form>
      </div>
    </div>

  </div>
</div>

<div id="filterModal" class="modal bottom fade" role="dialog">
  <div class="modal-dialog" style="margin: 0;padding: 0;height: 100%;">

    <!-- Modal content-->
    <div class="modal-content" style="height: 100%;">
      <div class="modal-header" style="background: #006699;color: white;">
        <button type="button" class="close" data-dismiss="modal" style="opacity: 2;color: white;">&times;</button>
        <h4 class="modal-title">Filter By</h4>
      </div>
      <div class="modal-body" style="padding-top: 20px;padding-bottom: 20px;padding-left: 0px;padding-right:0px; ">
      	<form id="search_form_sm">
      		<input type="hidden" class="form-control b-r-40" name="citycode" class="citycode" value="<?php echo $_REQUEST['citycode'] ?>">
			<input type="hidden" class="form-control b-r-40" name="cityname" class="cityname" value="<?php echo $_REQUEST['cityname'] ?>">
			<input type="hidden" class="form-control b-r-40" name="countryname" class="countryname" value="<?php echo $_REQUEST['countryname'] ?>">
			<input type="hidden" name="mark_up" value="<?php echo $_REQUEST['mark_up'] ?>">
			<input type="hidden" name="Check_in" value="<?php echo $_REQUEST['Check_in'] ?>">
			<input type="hidden" name="Check_out" value="<?php echo $_REQUEST['Check_out'] ?>">
			<input type="hidden" name="view_type" value="<?php echo $_REQUEST['view_type'] ?>">
			<input type="hidden" name="location" value="<?php echo $_REQUEST['location'] ?>">
			<input type="hidden" name="nationality" value="<?php echo $_REQUEST['nationality'] ?>">
			<input type="hidden" name="hotel_name" value="<?php echo $_REQUEST['hotel_name'] ?>">
			<input type="hidden" name="page" value="<?php isset($_REQUEST['page']) ? $_REQUEST['page'] : "1" ?>" id="page">
			<input type="hidden" name="view_type" id="view_type" value="<?php echo isset($_REQUEST['view_type']) ? $_REQUEST['view_type'] : 'list' ?>">
			<?php foreach ($_REQUEST['adults'] as $key => $value) { ?>
				<input type="hidden" name="adults[]" value="<?php echo $value ?>">
			<?php } ?>
			<?php foreach ($_REQUEST['Child'] as $key => $value) { ?>
				<input type="hidden" name="Child[]" value="<?php echo $value ?>">
			<?php } ?>
			<?php if (isset($_REQUEST['room1-childAge'])) {
					foreach ($_REQUEST['room1-childAge'] as $key => $value) { ?>
						<input type="hidden" name="room1-childAge[]" value="<?php echo $value; ?>">
			<?php   }
			} ?>
			<?php if (isset($_REQUEST['room2-childAge'])) {
					foreach ($_REQUEST['room2-childAge'] as $key => $value) { ?>
						<input type="hidden" name="room2-childAge[]" value="<?php echo $value; ?>">
			<?php   }
			} ?>
			<?php if (isset($_REQUEST['room3-childAge'])) {
					foreach ($_REQUEST['room3-childAge'] as $key => $value) { ?>
						<input type="hidden" name="room3-childAge[]" value="<?php echo $value; ?>">
			<?php   }
			} ?>
			<?php if (isset($_REQUEST['room4-childAge'])) {
					foreach ($_REQUEST['room4-childAge'] as $key => $value) { ?>
						<input type="hidden" name="room4-childAge[]" value="<?php echo $value; ?>">
			<?php   }
			} ?>
			<?php if (isset($_REQUEST['room5-childAge'])) {
					foreach ($_REQUEST['room5-childAge'] as $key => $value) { ?>
						<input type="hidden" name="room5-childAge[]" value="<?php echo $value; ?>">
			<?php   }
			} ?>
			<?php if (isset($_REQUEST['room6-childAge'])) {
					foreach ($_REQUEST['room6-childAge'] as $key => $value) { ?>
						<input type="hidden" name="room6-childAge[]" value="<?php echo $value; ?>">
			<?php   }
			} ?>
			<?php if (isset($_REQUEST['room7-childAge'])) {
					foreach ($_REQUEST['room7-childAge'] as $key => $value) { ?>
						<input type="hidden" name="room7-childAge[]" value="<?php echo $value; ?>">
			<?php   }
			} ?>
			<?php if (isset($_REQUEST['room8-childAge'])) {
					foreach ($_REQUEST['room8-childAge'] as $key => $value) { ?>
						<input type="hidden" name="room8-childAge[]" value="<?php echo $value; ?>">
			<?php   }
			} ?>
			<?php if (isset($_REQUEST['room9-childAge'])) {
					foreach ($_REQUEST['room9-childAge'] as $key => $value) { ?>
						<input type="hidden" name="room9-childAge[]" value="<?php echo $value; ?>">
			<?php   }
			} ?>
			<?php if (isset($_REQUEST['room10-childAge'])) {
					foreach ($_REQUEST['room10-childAge'] as $key => $value) { ?>
						<input type="hidden" name="room10-childAge[]" value="<?php echo $value; ?>">
			<?php   }
			} ?>
			<button type="button" class="collapsebtn" data-toggle="collapse" data-target="#collapse6sm">
				Hotel Name <span class="collapsearrow" style="margin-top: 0px"><i class="fa fa-plus" aria-hidden="true"></i></span>
			</button>
			<div id="collapse6sm" class="collapse in">
				<div class="hpadding20">
					<input type="text" name="hotel_name_filter" id="hotel_name_filtersm" placeholder="Hotel name" class="form-control" value="" style="margin-top: 10px;margin-bottom: 10px; ">
				</div>
			</div>
			<button type="button" class="collapsebtn" data-toggle="collapse" data-target="#collapse1sm">
				Star rating <span class="collapsearrow" style="margin-top: 0px"><i class="fa fa-plus" aria-hidden="true"></i></span>
			</button>
			<div id="collapse1sm" class="collapse in">
				<div class="hpadding20">
					<div class="checkbox">
						<label>
						<?php if(isset($_REQUEST['rating5']) && $_REQUEST['rating5']=="5") { ?>
							<input type="checkbox" class="rating-sm" checked="" name="rating5" value="5">
						<?php } else { ?> 
							<input type="checkbox" class="rating-sm"  name="rating5" value="5">
							<?php }?><img src="<?php echo base_url(); ?>skin/images/filter-rating-5.png" class="imgpos1" alt=""/> 5 Stars
						</label>
					</div>
					<div class="checkbox">
						<label>
						<?php if(isset($_REQUEST['rating4']) && $_REQUEST['rating4']=="4") { ?>
							<input type="checkbox" class="rating-sm" checked="" name="rating4" value="4">
						<?php } else { ?> 
							<input type="checkbox" class="rating-sm"  name="rating4" value="4">
							<?php }?><img src="<?php echo base_url(); ?>skin/images/filter-rating-4.png" class="imgpos1" alt=""/> 4 Stars
						</label>
					</div>
					<div class="checkbox">
						<label>
						<?php if(isset($_REQUEST['rating3']) && $_REQUEST['rating3']=="3") { ?>
							<input type="checkbox" class="rating-sm" checked="" name="rating3" value="3">
						<?php } else { ?> 
							<input type="checkbox" class="rating-sm"  name="rating3" value="3">
							<?php }?><img src="<?php echo base_url(); ?>skin/images/filter-rating-3.png" class="imgpos1" alt=""/> 3 Stars
						</label>
					</div>
					<div class="checkbox">
						<label>
						<?php if(isset($_REQUEST['rating2']) && $_REQUEST['rating2']=="2") { ?>
							<input type="checkbox" class="rating-sm" checked="" name="rating2" value="2">
						<?php } else { ?> 
							<input type="checkbox" class="rating-sm"  name="rating2" value="2">
							<?php }?><img src="<?php echo base_url(); ?>skin/images/filter-rating-2.png" class="imgpos1" alt=""/> 2 Stars
						</label>
					</div>
					<div class="checkbox">
						<label>
						<?php if(isset($_REQUEST['rating1']) && $_REQUEST['rating1']=="1") { ?>
							<input type="checkbox" class="rating-sm" checked="" name="rating1" value="1">
						<?php } else { ?> 
							<input type="checkbox" class="rating-sm"  name="rating1" value="1">
							<?php }?><img src="<?php echo base_url(); ?>skin/images/filter-rating-1.png" class="imgpos1" alt=""/> 1 Star
						</label>
					</div>
					<div class="checkbox">
						<label>
						<?php if(isset($_REQUEST['rating10']) && $_REQUEST['rating10']=="10") { ?>
							<input type="checkbox" class="rating-sm" checked="" name="rating10" value="10">
						<?php } else { ?> 
							<input type="checkbox" class="rating-sm"  name="rating10" value="10">
							<?php }?><i class="fa fa-building" style="margin-left: 10px; color: #1280b7;"></i> Appartment
						</label>
					</div>
				</div>
			</div>
			<button type="button" class="collapsebtn" data-toggle="collapse" data-target="#collapse5sm">
				Sort By <span class="collapsearrow" style="margin-top: 0px"><i class="fa fa-plus" aria-hidden="true"></i></span>
			</button>
			<div id="collapse5sm" class="collapse in">
				<div class="hpadding20">
					<div style="margin-top:10px ">
						<select name="name_order" class="name-filter-sm form-control">
							<option value="">Name</option>
							<option value="1">A to Z</option>
							<option value="2">Z to A</option>
						</select>
						<select name="guest_rating" class="star-filter-sm form-control" style="margin-top:10px ">
							<option value="">Stars</option>
							<option  value="1">stars [5->1]</option>
							<option  value="2">stars [1->5]</option>
						</select>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="col-xs-12">
			<button type="button"  onclick="applyfilter();" class="btn-search3 pbottom15" style="width: 90%; margin-top: 5%;">Apply Filter</button>
			<button type="button" onclick="clearfilter();" class="btn-search3 pbottom15" style="width: 90%; margin-top: 21%;background: #006699;border: 1px solid #2376a0;">Clear Filter</button>
			</div>
			<input type="hidden" name="hotel_id">
			<input type="hidden" name="roomIndex">
			<input type="hidden" name="resultIndex">
			<input type="hidden" name="Reqtype">
			<input type="hidden" name="roomName">
			<input type="hidden" name="temp" value="0">
			<input type="hidden" name="listarray" value="">
			<input type="hidden" name="price" value="10;10000000000" />
			<input type="hidden" id="price_order_sm" name="price_order" value="">
  		</form>
  		<script type="text/javascript">
  			function clearfilter() {
				$("#hotel_name_filtersm").val("");
				$(".rating-sm").prop("checked",false);
				$(".name-filter-sm").prop("selected",true).val("");
				$(".star-filter-sm").prop("selected",true).val("");
				$("#price_order_sm").val("");
			}
			function filtersmrate(val) {
				$("#price_order_sm").val(val);
				applyfilter();
			}
			function filtersmstar(val) {
				$(".star-filter-sm").find("option[value=" + val +"]").prop("selected",true);
				applyfilter();
			}
			function applyfilter() {
				$(".close").trigger("click");
			  hotelLoading('start');
			  $.ajax({
			      dataType: 'json',
			      type: 'post',
			      url: base_url+'lists/search_list',
			      data: $('#search_form_sm').serialize(),
			      cache: false,
			      // async: false,
			      success: function (response) {
			        hotelLoading('stop');
			        $("#rotateBanner").html(response.rotateHotels);
			        $("#result_search").html(response.list);
			        count(response.counthotel,response.countprice);
			        $("#Slider1").val("10:"+response.maxprice);
					$("#Slider1").slider({ from: <?php echo ceil(currency_type1(agent_currency(),"10")) ?>, to: '"'+response.maxprice+'"' , step: 5, smooth: true, round: 0, dimension: "&nbsp;<?php echo agent_currency(); ?>", skin: "round" });
			        StartAnime2();

			        $('.hotel-more-btn').click(function() {
			          var toggled = $(this).closest('.offset-2').find('.more-wrap').hasClass('in');
			        $('.hotel-more-btn').children('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
			          $('.hotel-more-btn').children('span').text('More Details');
			          if (toggled) {
			            $('.more-wrap').removeClass('in');
			            $('.more-wrap').slideUp();
			            $(this).children('span').text('More Details');
			            $(this).children('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
			          }
			          else {
			            $('.more-wrap').removeClass('in');
			            $('.more-wrap').slideUp('fast');
			            $(this).children('span').text('Hide Details');
			            $(this).children('i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
			            $(this).closest('.offset-2').find('.more-wrap').addClass('in');
			            $(this).closest('.offset-2').find('.more-wrap').slideDown();
			          }
			       });
			        

			      }/*,
			       error: function (xhr,status,error) {
			         alert("Error: " + error);
			      }*/
			    });
			}
  		</script>
      </div>
    </div>

  </div>
</div>
<?php init_front_black_tail(); ?> 
<script type="text/javascript" src="<?php echo base_url(); ?>skin/plugins/jslider/js/jquery.slider - Copy.js"></script>


