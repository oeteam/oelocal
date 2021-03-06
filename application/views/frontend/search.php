<?php init_front_head(); ?> 
<?php init_front_head_menu(); 
$defaultNationality = defaultNationalityGET(); 
?> 
<script type="text/javascript" src="<?php echo static_url(); ?>skin/js/search.js"></script>
<!-- id="dajy" was here -->
<style>
    .full-loading {
        position: fixed;
        top: 0;
        right: 0;
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
	.date-picker-wrapper {
		/*left: 976.234px ! important;*/
		/*top: 302px ! important;*/
		margin-top: 5px ! important;
		/*margin-left: 2.3px ! important;*/
	}

	/*.search-dropdown:empty {
		display: none;
	}*/
	.search-dropdown {
		position: absolute;
	    max-height: 200px;
	    top: 100%;
	    left: 0;
	    z-index: 1000;
	    width: 93.5%;
	    padding: 0;
	    margin: 0;
	    font-size: 14px;
	    list-style: none;
	    background-color: #ffffff;
	    border: 1px solid rgba(0, 0, 0, 0.15);
	    border-radius: 4px;
	    -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
	    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
	}
	.focus-li > a > i {
		color: #72bf66;
	}
	.focus-li {
	    background-color: #eee;
	}
	.search-dropdown li {
	    padding: 3px 8px;
	    cursor: pointer;
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
	}
</style>
<div id="" class="fullscreen-container mtslide sliderbg fixed">
	<div class="fullscreenbanner">
		<ul>
			<!-- papercut fade turnoff flyin slideright slideleft slideup slidedown-->
			<!-- FADE -->
			<li data-transition="fade" data-slotamount="1" data-masterspeed="300"> 										
				<img src="<?php echo static_url(); ?>skin/images/slider/slider1.jpg" width="100%" alt=""/>
			</li>	

			<li data-transition="fade" data-slotamount="1" data-masterspeed="300"> 										
				
				<img src="<?php echo static_url(); ?>skin/images/slider/slider2.jpg" width="100%" alt=""/>
			</li>	

			<li data-transition="fade" data-slotamount="1" data-masterspeed="300"> 										
				<img src="<?php echo static_url(); ?>skin/images/slider/slider3.jpg" width="100%" alt=""/>
			</li>
			
			<li data-transition="fade" data-slotamount="1" data-masterspeed="300"> 										
				<img src="<?php echo static_url(); ?>skin/images/slider/slider4.jpg" width="100%" alt=""/>
			</li>
			

		</ul>
		<div class="tp-bannertimer none"></div>
	</div>
</div>
<script type="text/javascript">

	var tpj=jQuery;
	tpj.noConflict();

	tpj(document).ready(function() {
		favourite_dropdown();
		if (tpj.fn.cssOriginal!=undefined)
			tpj.fn.css = tpj.fn.cssOriginal;

		tpj('.fullscreenbanner').revolution(
		{
			delay:9000,
			startwidth:1170,
			startheight:500,

				onHoverStop:"on",						// Stop Banner Timet at Hover on Slide on/off

				thumbWidth:100,							// Thumb With and Height and Amount (only if navigation Tyope set to thumb !)
				thumbHeight:50,
				thumbAmount:3,

				hideThumbs:0,
				navigationType:"bullet",				// bullet, thumb, none
				navigationArrows:"solo",				// nexttobullets, solo (old name verticalcentered), none

				navigationStyle:false,				// round,square,navbar,round-old,square-old,navbar-old, or any from the list in the docu (choose between 50+ different item), custom


				navigationHAlign:"left",				// Vertical Align top,center,bottom
				navigationVAlign:"bottom",					// Horizontal Align left,center,right
				navigationHOffset:30,
				navigationVOffset:30,

				soloArrowLeftHalign:"left",
				soloArrowLeftValign:"center",
				soloArrowLeftHOffset:20,
				soloArrowLeftVOffset:0,

				soloArrowRightHalign:"right",
				soloArrowRightValign:"center",
				soloArrowRightHOffset:20,
				soloArrowRightVOffset:0,

				touchenabled:"on",						// Enable Swipe Function : on/off
				hideArrowsOnMobile: "off",


				stopAtSlide:-1,							// Stop Timer if Slide "x" has been Reached. If stopAfterLoops set to 0, then it stops already in the first Loop at slide X which defined. -1 means do not stop at any slide. stopAfterLoops has no sinn in this case.
				stopAfterLoops:-1,						// Stop Timer if All slides has been played "x" times. IT will stop at THe slide which is defined via stopAtSlide:x, if set to -1 slide never stop automatic

				hideCaptionAtLimit:0,					// It Defines if a caption should be shown under a Screen Resolution ( Basod on The Width of Browser)
				hideAllCaptionAtLilmit:0,				// Hide all The Captions if Width of Browser is less then this value
				hideSliderAtLimit:0,					// Hide the whole slider, and stop also functions if Width of Browser is less than this value

				fullWidth:"off",							// Same time only Enable FullScreen of FullWidth !!
				autoHeight: "off",
				fullScreen:"off",						// Same time only Enable FullScreen of FullWidth !!

				shadow:0								//0 = no Shadow, 1,2,3 = 3 Different Art of Shadows -  (No Shadow in Fullwidth Version !)

			});

	// tpj('#datepicker3').dateRangePicker({
	// 	  selectForward: true,
	// 	  monthSelect: true,
	// 	  yearSelect: true,
 //          autoClose: true,
 //          format: 'MM/DD/YYYY',
 //          separator : ' to ',
 //          startDate: '<?php echo date('m/d/Y') ?>',
 //          endDate: false,
 //          minDays: 2,
 //          maxDays: 30,
 //          getValue: function()
 //          {
 //            if (tpj('#datepicker3').val() && tpj('#datepicker2').val() )
 //              return tpj('#datepicker3').val() + ' to ' + tpj('#datepicker2').val();
 //            else
 //              return '';
 //          },
 //          setValue: function(s,s1,s2)
 //          {
 //            altDate = s1.split('/');
 //            altDate2 = s2.split('/');
 //            tpj('#datepicker3').val(s1);
 //            tpj('#datepicker2').val(s2);
 //            tpj("#alternate3").val(altDate[1]+'/'+altDate[0]+'/'+altDate[2]);
 //            tpj("#alternate2").val(altDate2[1]+'/'+altDate2[0]+'/'+altDate2[2]);
 //          },


 //      });

	// tpj("#alternate3").click(function(evt) {
 //      evt.stopPropagation();
 //          tpj('#datepicker3').data('dateRangePicker').open();
 //    });
 //     tpj("#alternate2").click(function(evt) {
 //        evt.stopPropagation();
 //        tpj('#datepicker3').data('dateRangePicker').open();
 //    });


 var nextDay = new Date(tpj("#datepicker2").val());
 nextDay.setDate(nextDay.getDate() + 1);
 tpj("#datepicker2").datepicker({
 	minDate: +1,
 	altField: "#alternate2",
 	altFormat: "dd/mm/yy",
 	onSelect: function(dateText) {
 		total_night_calc1();

 	}
 });
 tpj("#datepicker3").datepicker({
 	minDate: 0,
 	altField: "#alternate3",
 	altFormat: "dd/mm/yy",
 	onSelect: function(dateText) {
 		var nextDay = new Date(dateText);
 		nextDay.setDate(nextDay.getDate() + 1);
 		tpj("#datepicker2").datepicker('option', 'minDate', nextDay);
 		total_night_calc1();
 		setTimeout(function(){
 			tpj( "#datepicker2" ).datepicker('show');
 		}, 16);
 	}
 });
 tpj("#alternate2").click(function() {
 	tpj( "#datepicker2" ).trigger('focus');
 });
 tpj("#alternate3").click(function() {
 	tpj( "#datepicker3" ).trigger('focus');
 });
 tpj("#nights").change(function() {
 	var night = tpj("#nights").val();
 	if (night<1) {
		alert("Total nights should be greater than 0");
		tpj("#nights").val('1');
	} else {
		var nextDay = new Date(tpj("#datepicker3").val());
 		tpj("#datepicker2").datepicker('option', 'minDate', nextDay); 
	}
 });
/* var input = document.getElementById('location');
 var autocomplete = new google.maps.places.Autocomplete(input);*/


 <?php for ($l = 1; $l <=7 ; $l++) { ?>
 	tpj(".room<?php echo $l ?>-child").change(function() {
 		var room = tpj(this).val();
 		<?php for ($k = 1; $k <= 4; $k++) { ?>
 			tpj(".room<?php echo $l ?>-child<?php echo $k ?>").addClass('hide');
 			tpj(".room<?php echo $l ?>-childAges<?php echo $k ?>").attr("disabled","disabled");
 		<?php } ?>
 		if (room!=0) {
 			if (room==1) {
 				tpj(".room<?php echo $l ?>-child-p").text("Child Age");
 			} else {
 				tpj(".room<?php echo $l ?>-child-p").text("Children Age");
 			}
 			tpj(".room<?php echo $l ?>-childAge").removeClass('hide');

 			for (var k = 1; k <= room; k++) {
 				tpj(".room<?php echo $l ?>-child"+k).removeClass('hide');
 				tpj(".room<?php echo $l ?>-childAges"+k).removeAttr("disabled");
 			}
 		} else {
 			tpj(".room<?php echo $l ?>-childAge").addClass('hide');
 		}
 	});
 <?php } ?>



});
window.onload = function() {
	window.setTimeout(function(){
		message_hide();
	}, 3000);
};
function message_hide() {
	tpj(".sucess_msg_fix_toaster").hide();
}
function favourite_dropdown() {
	tpj.ajax({    
		type: 'post',
		url: base_url+'dashboard/favourite_dropdown',
		cache: false,
		success: function (response) {
        // alert(response);
        tpj(".favourite_dropdown").html(response);
    }        
});
}
function currency_change(type){
	tpj.ajax({    
		type: 'post',
		url: base_url+'login/sessions_reset?type='+type,
		cache: false,
		success: function (response) {
			document.location.reload(true);
        // window.location.href=window.location.href;
    }        
});
}
</script>
<!-- WRAP -->
<div class="wrap cstyle03 small-bg-none" style="height: 100%">
	 
	<div class="container mt-250 z-index100">		
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="bs-example bs-example-tabs cstyle04">
					
					<ul class="nav nav-tabs hidden-xs" id="myTab">
						<li onclick="mySelectUpdate()" class="active hide"><a data-toggle="tab" href="#hotel"><span class="hotel"></span>Hotel</a></li>
						<!-- <li onclick="mySelectUpdate()" class=""><a data-toggle="tab" href="#Sights"><span class="sights"></span>Sights</a></li> -->
					</ul>
					<form action="#" id="hotel_search_form" method="get">
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
						<input type="hidden" name="price" value="10;10000">
						<input type="hidden" name="view_type" id="view_type" value="list">
						<div class="tab-content" id="myTabContent">
							<div class="blur-me"></div>
							<div id="hotel" class="tab-pane fade active in">
								<div class="row">
									<div class="col-xs-12 col-md-6">
										<label for="" class="dest_err control-label text-white">Enter Destination</label>
										<!--<input type="text" class="form-control b-r-40" name="location" placeholder="Enter country name" id="location">-->
										<input type="text" class="form-control b-r-40" name="location" placeholder="Enter country name" id="location" autocomplete="off">
										<input type="hidden" class="form-control b-r-40" name="citycode" id="citycode">
										<input type="hidden" class="form-control b-r-40" name="cityname" id="cityname">
										<input type="hidden" class="form-control b-r-40" name="countryname" id="countryname">
										<ul class="search-dropdown txtcountry" style="margin-left:15px;margin-right:0px;display:none;overflow-y: scroll;" role="menu" aria-labelledby="dropdownMenu"  id="DropdownCountry"></ul>
									</div>	
									<?php $date = date('m/d/Y', strtotime("+1 day", strtotime(date('m/d/Y'))));
									$date1 = date('d/m/Y', strtotime("+1 day", strtotime(date('m/d/Y')))); ?>
									<div class="col-xs-12 col-md-6">
										<label class="nat_err control-label text-white">Nationality</label>
										<select class="form-control" name="nationality" id="Nationality">
											<option value="">--select--</option>
											<?php 
											foreach ($nationality as $key => $value) { 
												if ($defaultNationality!=" " && $defaultNationality==$value->id) {
													$selected = "selected";
												} else {
													$selected = "";
												}
												?>
												<option <?php echo $selected ?> value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="row" style="margin-top: 15px;">
									<div class="col-xs-12 col-md-6">
										<label for="" class="control-label htl_err text-white">Search by Hotel Name</label>
										<input type="text" id="hotel_name" name="hotel_name" class="form-control b-r-40" placeholder="Enter hotel name" />
									</div>	
									<div class="col-xs-12 col-md-2">
										<div class=" textleft">
											<label for="" class="chckin_err control-label text-white">Check In</label>
											<input type="text" style="width: 100% ! important;opacity: 0" class="mySelectCalendar" id="datepicker3" name="Check_in" placeholder="mm/dd/yyyy" value="<?php echo date('m/d/Y') ?>" />
										</div>
										<div class="input-group" style="transform: translateY(-27px);">
											<input type="text"  name="" class="form-control" id="alternate3" value="<?php echo date('d/m/Y') ?>">
											<label for="datepicker3" class="input-group-addon"><i class="fa fa-calendar"></i></label>
										</div>
									</div>
									<div class="col-xs-12 col-md-2">
										<label for="" class="control-label nights_err text-white">Nights</label>
										<input type="text" id="nights" name="nights" class="form-control b-r-40" placeholder="Nights" value="1" />
									</div>
									<div class="col-xs-12 col-md-2">
										<div class=" textleft">
											<label for="" class="chckout_err control-label text-white">Check Out</label>
											<input type="text" style="width: 0px ! important;opacity: 0" class=" mySelectCalendar" id="datepicker2" name="Check_out" placeholder="mm/dd/yyyy" value="<?php echo $date; ?>" />
										</div>
										<div class="input-group"  style="transform: translateY(-5px);">
											<input type="text" name="" class="form-control" id="alternate2" value="<?php echo $date1; ?>">
											<label for="datepicker2" class="input-group-addon"><i class="fa fa-calendar"></i></label>
										</div>
									</div>
									<div class="col-xs-12 col-md-6">
										<label for="" class="rate_err control-label text-white">Category</label><br>
										<input type="checkbox" class="rate rating5" name="rating5" value="5"> <span class="white">5</span>
										<input type="checkbox" class="rate rating4" name="rating4" value="4"> <span class="white">4</span>
										<input type="checkbox" class="rate rating3" name="rating3" value="3"> <span class="white">3</span>
										<input type="checkbox" class="rate rating2" name="rating2" value="2"> <span class="white">2</span>
										<input type="checkbox" class="rate rating2" name="rating1" value="1"> <span class="white">1</span>
										<input type="checkbox" class="rate rating2" name="rating10" value="10"> <span class="white">Apartment</span>
										<input type="checkbox" class="ratingall" value=""> <span class="white">All</span>
									</div>
									<div class="col-xs-3 col-md-1">
										<label for="" class="control-label text-white">Rooms</label><br>
										<select  class="form-control mySelectBoxClass" id="Rooms" onchange="roomsCheck();">
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="6">6</option>
										<!-- 	<option value="7">7</option>
											<option value="8">8</option>
											<option value="9">9</option>
											<option value="10">10</option> -->
										</select>
									</div>
									<div class="col-xs-3 col-md-1">
										<label for="" class="adults_err control-label text-white">Adults</label>
										<select id="adults" name="adults[]" class="form-control mySelectBoxClass">
											<option value="1">1</option>
											<option selected value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="6">6</option>
											<option value="7">7</option>
											<option value="8">8</option>
											<option value="9">9</option>
											<option value="10">10</option>
										</select>
									</div>
									<div class="col-xs-3 col-md-1">
										<label for="" class="control-label text-white">Child</label>
										<select name="Child[]" class="form-control mySelectBoxClass room1-child">
											<option value="0"></option>
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
										</select>
									</div>
									<div class="clearfix hidden-lg"></div>
									<!-- <div class="hidden-xs col-xs-6 col-md-3"> -->
										<!-- <label for="" class="control-label text-white">Markup %</label> -->
										<input type="hidden" name="mark_up" class="form-control b-r-40"/>
										<!-- </div> -->
										
										<div class="col-xs-12 col-md-3">
											<div class="row room1-childAge <?php echo isset($_REQUEST['Child'][0]) && $_REQUEST['Child'][0]!="" && $_REQUEST['Child'][0]!=0 ? '' : 'hide' ?>" style="transform: translateX(-8px);margin: 0 -8px;">
												<p style="margin-bottom: 0 ! important"><label class="room1-child-p rate_err control-label text-white" style="padding-left: 15px;">Children Age</label></p>
												<?php for ($l=1; $l <= 4 ; $l++) {  ?>
													<div class="col-xs-3 room1-child<?php echo $l; ?> <?php echo isset($_REQUEST['Child'][0]) && $_REQUEST['Child'][0]!="" && $_REQUEST['Child'][0]!=0 && $_REQUEST['Child'][0] >= $l ? '' : 'hide' ?>" style="padding-right: 0;">
														<select name="room1-childAge[]" class="form-control mySelectBoxClass room1-childAges<?php echo $l; ?>" <?php echo isset($_REQUEST['Child'][0]) && $_REQUEST['Child'][0]!="" && $_REQUEST['Child'][0]!=0 && $_REQUEST['Child'][0] >= $l ? '' : 'disabled' ?>  id="room1-childAge<?php echo $l; ?>">
															<?php for ($i=0; $i <18 ; $i++) { ?>
																<option value="<?php echo $i ?>"><?php echo $i ?></option>
															<?php } ?>
														</select>
													</div>
												<?php } ?>
												
											</div>
										</div>
										
										<?php for ($i=2; $i <=10 ; $i++) { ?>
											<div class="room<?php echo $i; ?> hide roomshide">
												<div class="col-xs-3 col-md-1 col-md-offset-7">
													<label for="" class="adults_err control-label text-white">Adults</label>
													<select id="adults"  disabled="" name="adults[]" class="room<?php echo $i; ?>-adults roomadults form-control mySelectBoxClass">
														<option value="1">1</option>
														<option selected value="2">2</option>
														<option value="3">3</option>
														<option value="4">4</option>
														<option value="5">5</option>
														<option value="6">6</option>
														<option value="7">7</option>
														<option value="8">8</option>
														<option value="9">9</option>
														<option value="10">10</option>
													</select>
												</div>
												<div class="col-xs-3 col-md-1">
													<label for="" class="control-label text-white">Child</label>
													<select name="Child[]" disabled="" class="roomsChild form-control mySelectBoxClass room<?php echo $i ?>-child"> 
														<option value="0"></option>
														<option value="1">1</option>
														<option value="2">2</option>
														<option value="3">3</option>
														<option value="4">4</option>
													</select>
												</div>
												<div class="clearfix hidden-lg"></div>
												<div class="col-xs-12 col-md-3 scol-md-offset-9">
													<div class="row room<?php echo $i ?>-childAge hide" style="transform: translateX(-8px);margin: 0 -8px;">
														<p style="margin-bottom: 0 ! important"><label class="room<?php echo $i ?>-child-p rate_err control-label text-white" style="padding-left: 15px;">Children Age</label></p>
														<?php for ($l=1; $l <= 4 ; $l++) {  ?>
															<div class="col-xs-3 room<?php echo $i ?>-child<?php echo $l; ?> hide" style="padding-right: 0;">
																<select name="room<?php echo $i; ?>-childAge[]" class="form-control mySelectBoxClass room<?php echo $i; ?>-childAges<?php echo $l; ?>" disabled  id="room<?php echo $i; ?>-childAge<?php echo $l; ?>">
																	<?php for ($j=0; $j <18 ; $j++) { ?>
																		<option value="<?php echo $j ?>"><?php echo $j ?></option>
																	<?php } ?>
																</select>
															</div>
														<?php } ?>
													</div>
												</div>
											</div>
										<?php } ?>
										<div class="col-xs-12 col-md-6 col-md-offset-6">
											<button type="submit" id="search_btn" class="btn-search btn-block">Find Hotels</button>
										</div>
									</div>

									<div class="clearfix"></div>
									<div class="room1 margtop15">
										<div class="w50percentlast">
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="lastminute hidden-xs" style="height: auto;background: white;">
			<div class="container ">	
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<h3 class="text-center">Trending Hotels Details</h3>
						<div class="row">
						<?php foreach ($trending as $key => $value) { 

							if ($value->rating==10) {
								$star = '<label style="width:100px;" class="hotel-rating"><i class="fa fa-building" style="color: #258732;"></i> Apartment</label>';
							} else {
								$star = '<img src="'.static_url().'skin/images/filter-rating-'.$value->rating.$value->rating.'.png">';
							}
							?>
							<a href="<?php echo base_url() ?>details?search_id=<?php echo $value->id; ?>&&mark_up=&&Check_in=<?php echo date('m/d/Y',strtotime( '+2 days' )) ?>&&Check_out=<?php echo date('m/d/Y',strtotime( '+3 days' )) ?>&&adults[]=2&&Child[]=0&&Room1ChildAges=&&Room2ChildAges=&&Room3ChildAges=&&Room4ChildAges=&&Room5ChildAges=&&Room6ChildAges=&&Room7ChildAges=&&Room8ChildAges=&&Room9ChildAges=&&Room10ChildAges=&&contract_id=&providers=otelseasy&nationality=">
								<div class="col-lg-4">
									<div class="cuadro_intro_hover ">
										<div  style="background: url(<?php echo base_url().'uploads/gallery/'.$value->id.'/'.$value->Image1 ?>);background-position: center center;background-repeat: no-repeat;background-size: cover;height: 215px;" >
										</div>
										<div class="caption-text">
		                                       <h3 class="news-title"><?php echo $value->hotel_name; ?></h3>
		                               </div>
										<div class="caption">
		                                    <div class="blur"></div>
		                                    <div class="caption-text">
		                                       <h3 class="news-title" style="border: none;"></h3>
		                                       <p class="news-dec"><?php echo strlen($value->hotel_description) > 180 ? mb_substr($value->hotel_description,0,180).'..' : $value->hotel_description ; ?></p>
		                                       <p class="news-dec text-left" style="text-indent: 10px;">Location : <?php echo $value->city; ?></p>
		                                       <p class="news-dec text-left" style="text-indent: 10px;">Category :  <?php echo $star; ?></p>
		                                    </div>
		                                 </div>
									</div>
								</div>
							</a>
						<?php } ?>
						</div>
					</div>
				</div>
				</div>
<style type="text/css">
.footerbgblack,.footerbg3black {
	font-size: 14px;
}
.cuadro_intro_hover:hover {
    filter: brightness(125%);
}
.cuadro_intro_hover {
    padding: 0px;
    position: relative;
    overflow: hidden;
    height: 360px;
    margin-bottom: 20px;
}
.caption {
    position: absolute;
    top: 210px;
    -webkit-transition: all 0.3s ease-in-out;
    -moz-transition: all 0.3s ease-in-out;
    -o-transition: all 0.3s ease-in-out;
    -ms-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
    width: 100%;
}
.cuadro_intro_hover .blur {
    background-color: rgb(76, 76, 76);
    height: 300px;
    z-index: 5;
    position: absolute;
    width: 100%;
}
.cuadro_intro_hover .caption-text {
    z-index: 10;
    color: #fff;
    position: absolute;
    height: 300px;
    text-align: center;
    top: -20px;
    width: 100%;
}
.news-title {
    margin-bottom: 0px;
    padding-bottom: 0px;
    /* margin-top: 10px; */
    border-top: 1px solid white;
    padding: 10px;
    font-family: 'Roboto', sans-serif;
    font-size: 17px;
    color: #FFF;
    background: #4c4c4c;
}
.news-dec {
    font-family: 'Roboto', sans-serif;
    font-size: 12px;
    color: #FFF;
}
.cuadro_intro_hover img {
    z-index: 4;
}
.cuadro_intro_hover .blur {
    background-color: rgb(76, 76, 76);
    height: 300px;
    z-index: 5;
    position: absolute;
    width: 100%;
}
.illustration {
	width: 325px;
}
@media only screen and (max-width: 480px) and (min-width: 320px) {
     .small-bg-none {
       background: none !important;
     }
}
</style>
		<!-- END OF WRAP -->
<?php init_front_black_tail(); ?>

