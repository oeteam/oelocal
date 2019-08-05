<?php init_front_head(); ?> 
<?php init_front_head_menu(); ?> 
  
<script type="text/javascript" src="<?php echo base_url(); ?>skin/js/payment.js"></script>
<style type="text/css">
	.stay-pay-tag {
	    background: red;
	    color: white;
	    height: 20px;
	    display: block;
	    line-height: 20px;
	    padding: 0px 10px 10px;
	    border-bottom-left-radius: 20px;
	    border-top-left-radius: 20px;
	    font-weight: bolder;
	}
	.b-rates--tax {
	  background-color: #eee;
	  padding: 10px 10px;
	  font-weight: bold;
	  margin-bottom: 0;
	  color: #455A64;
	}        
	.b-rates--grand {
	  margin-top: 0;
	  background-color: #5cb85c;
	  padding: 15px 10px;
	  font-size: 18px;
	  color: #fff;
	  font-weight: bold;
	  border-radius: 0 0 6px 6px;
	}
	.payment-radio-group {

	}
	.payment-radio__btn:checked + label::before {
	  content: "\f192";
	  color: #15C85B;
	}
	.payment-radio__btn:checked + label {
	  border: 1px solid #C3F1D5;
	  background-color: #F4FDF8;
	}
	.payment-radio__label {
	  display: block;
	  position: relative;
	  border: 1px solid #ccc;
	  min-height: 55px;
	  padding: 10px 0 10px 45px;
	  border-radius: 5px;
	  margin-top: 15px;
	  cursor: pointer;
	}
	.payment-radio__label::before {
	  content: "\f10c";
	  font: normal normal normal 14px/1 FontAwesome;
	  text-rendering: auto;
	  -webkit-font-smoothing: antialiased;
	  -moz-osx-font-smoothing: grayscale;
	  position: absolute;
	  left: 15px;
	  top: 50%;
	  transform: translateY(-50%);
	  font-size: 20px;
	  color: #ccc;
	}
	.payment-radio__label > span {
	  color: #4D4E4E;
	  line-height: 2.3;
	}
	.payment-radio__label > small {
	  display: block;
	  width: calc(100% - 60px);
	  color: #b3b3b3;
	  font-weight: 100;
	  letter-spacing: .5px;
	}
	.payment-radio__label > span + small {
	  line-height: 1.3;
	}
	.payment-radio__label >img {
	  position: absolute;
	  right: 0;
	  top: 50%;
	  transform: translateY(-50%);
	}
</style>
	<div class="container breadcrub">
		<ol class="track-progress" data-steps="5">
	      <li class="done">
	        <span>Search</span>
	      </li><li class="done">
	        <span>Search Hotel</span>
	        <i></i>
	      </li><li class="done">
	        <span>Pax Information</span>
	        <i></i>
	      </li><li class="active">
	        <span>Review Booking</span>
	        <i></i>
	      </li><li>
	        <span>Confirm</span>
	      </li>
	    </ol>
	</div>	
	<!-- CONTENT -->
	<div class="container">
		<div class="container mt25 offset-0">
          	<!-- LEFT CONTENT -->
			<div class="col-md-4" >
				<div class="pagecontainer2 paymentbox grey">
						<!-- <span class="opensans size18 dark bold">Book Hotel Details</span> <br> <br> -->
						<img src="<?php echo base_url();?>uploads/rooms/<?php echo $_REQUEST['room_id'] ?>/<?php echo $view[0]->images ?>" class="left margright20" width="100%" alt=""/>
						
						
					<div class="clearfix"></div>
					<div class="hpadding20 margtop20">
						<p><span class="opensans size20 bold"><?php echo $view[0]->hotel_name?></span></p>
					    <p><img src="<?php echo base_url();?>skin/images/bigrating-<?php echo $view[0]->rating ?>.png" alt=""/></p>
				    </div>		
		            <div class="line3"></div>
		            <div class="hpadding20 margtop20">
						<span class="opensans size15 bold">Location</span><br>
						<td class="center green bold"><?php echo $view[0]->location ?></td> <br> <br>
						<div class="clearfix"></div>	
						<div class="wh50percent chckin_err textleft left"><br></div>
						<div class="wh50percent  textleft right"><br></div>
					</div>					    			
					<div class="line3"></div>
					<div class="hpadding20 margtop20" style="min-height: 83px;">
						<span class="opensans size15 bold">Address</span>
						<br>
					     <td class="center green bold"><?php echo $view[0]->sale_address?></td> <br> <br>
				    </div>
					<div class="line3"></div>
				</div><br/>
			</div>
			<!-- END OF LEFT CONTENT -->
			<!-- RIGHT CONTENT -->
			<?php
				$start = $_REQUEST['Check_in'];
				$end = $_REQUEST['Check_out'];
				$first_date = strtotime($start);
				$second_date = strtotime($end);
		        $offset = $second_date-$first_date; 
		        $result = array();
	          	$checkin_date=date_create($_REQUEST['Check_in']);
				$checkout_date=date_create($_REQUEST['Check_out']);
				$no_of_days=date_diff($checkin_date,$checkout_date);
				$tot_days = $no_of_days->format("%a");
		        for($i = 0; $i <= floor($offset/24/60/60); $i++) {
		            $result[1+$i]['day'] = date('l', strtotime($start. ' + '.$i.' days'));
	        		$result[1+$i]['date'] = date('m/d/Y', strtotime($start. ' + '.$i.'  days'));
	       			$result[1+$i]['amount'] = special_offer_amount($result[1+$i]['date'],$_REQUEST['room_id'],$_REQUEST['hotel_id'],$_REQUEST['contract_id']);
		        }
		        $viwedate1 = date("d/m/Y", strtotime(isset($_REQUEST['Check_in']) ? $_REQUEST['Check_in'] : ''));
                $viwedate2 = date("d/m/Y", strtotime(isset($_REQUEST['Check_out']) ? $_REQUEST['Check_out'] : ''));
            ?>
			<div class="col-md-8 pagecontainer2 offset-0" style="padding-bottom: 35px ! important">
			<?php if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="failed") { ?> 
	           	<div class="alert failed-msg alert-danger alert-dismissible" role="alert" style="position:fixed;width:49.35%">
				  <strong>Payment failed!</strong> Please choose other payment option.
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>
				<script>
					window.setTimeout(function() {
					    $(".failed-msg").fadeTo(500, 0).slideUp(500, function(){
					        $(this).remove(); 
					    });
					}, 4000);
				</script>
    	    <?php } ?>
			<form method="post" name="payment_form" id="payment_form">
				<input type="hidden" name="nationality" value="<?php echo $_REQUEST['nationality'] ?>">
				<?php foreach ($_REQUEST['RequestType'] as $key => $value) { ?>
					<input type="hidden" name="RequestType[]" value="<?php echo $value ?>">
				<?php }	?>
				<input type="hidden" name="adults" id="adults" value="<?php echo array_sum($_REQUEST['reqadults']) ?>">
				<input type="hidden" name="childs" id="childs" value="<?php echo array_sum($_REQUEST['reqChild']) ?>">
				<input type="hidden" name="mark_up" id="mark_up" value="">
				<input type="hidden" name="hotel_id" id="hotel_id" value="<?php echo $_REQUEST['hotel_id'] ?>">
				<input type="hidden" name="tax" id="tax" value="<?php echo $tax; ?>">
				<input type="hidden" name="Check_in" value="<?php echo isset($_REQUEST['Check_in']) ? $_REQUEST['Check_in'] : '' ?>">
				<input type="hidden"  name="Check_out"  value="<?php echo isset($_REQUEST['Check_out']) ? $_REQUEST['Check_out'] : '' ?>" />
				<input type="hidden" name="no_of_rooms"  value="<?php echo $_REQUEST['no_of_rooms'] ?>">
				<input type="hidden" name="no_of_days"  value="<?php echo $tot_days ?>">
				<input type="hidden" name="room_index"  value="<?php echo $_REQUEST['room_index'] ?>">
				<input type="hidden" name="contract_index"  value="<?php echo $_REQUEST['contract_index'] ?>">
				<input type="hidden" name="room_id"  value="<?php echo $_REQUEST['room_index'] ?>">
				<input type="hidden" name="contract_id"  value="<?php echo $_REQUEST['contract_index'] ?>">
				<input type="hidden" name="token" value="<?php echo $_REQUEST['token'] ?>">
				<div class="padding30 grey">
					<span class="opensans size18 dark bold"><?php echo $view[0]->room_name." ".$view[0]->Room_Type ?></span>
					<div class="clearfix"></div>
					<div class="line4"></div>
					<div class="row margtop15">
						<div class="col-sm-3">
							<span class="opensans size13"><b>Check in date</b></span>
							<input type="hidden" class="form-control wh90percent mySelectCalendar" id="datepicker3" name="Check_in" placeholder="mm/dd/yyyy" readonly value="<?php echo isset($_REQUEST['Check_in']) ? $_REQUEST['Check_in'] : '' ?>" />
							<input type="text" class="form-control wh90percent" value="<?php echo $viwedate1  ?>" readonly>
						</div>
						<?php $date = date('m/d/Y', strtotime("+1 day", strtotime(date('m/d/Y')))); ?>
						<div class="col-sm-3">
							<span class="opensans size13"><b>Check out date</b></span>
							<input type="hidden" class="form-control wh90percent mySelectCalendar" id="datepicker3" name="Check_out" readonly placeholder="mm/dd/yyyy" value="<?php echo isset($_REQUEST['Check_out']) ? $_REQUEST['Check_out'] : '' ?>" />
							<input type="text" class="form-control wh90percent" value="<?php echo $viwedate2  ?>" readonly>
						</div>
						<div class="col-sm-3 text-center">
							<span class="opensans size13"><b>Number of Days</b></span>
							<h4><?php echo $tot_days ?></h4>
						</div>
						<div class="col-sm-3 text-center">
							<span class="opensans size13"><b>Number of Rooms</b></span>
							<h4><?php echo $_REQUEST['no_of_rooms'] ?></h4>
						</div>
					</div>

					<div class="padding20 margtop25" style="background-color: ghostwhite;">
						<div class="row">
							<div class="col-sm-6"  style="border-right: 1px dashed #bbb;">
								<?php 
				                       $adultss= array_sum($_REQUEST['reqadults']); ?>
								<label>Adult(s) : <span class="badge"><?php echo $adultss ?></span></label>
									
							</div>
							<div class="col-sm-6">
								<?php if (isset($_REQUEST['reqChild'])) {
			            				$childss= array_sum($_REQUEST['reqChild']);
			            			} else {
			            				$childss= "0";
			            			} ?>
								<label>Child(s) : <span class="badge"><?php echo $childss ?></span></label>
							</div>
						</div>
					</div>
						<?php for ($x=0; $x < count($_REQUEST['reqadults']); $x++) { ?>
					<div class="col-md-6 textleft">
						<input type="text" class="hide" id="first_name" name="first_name[]" value="<?php echo $_REQUEST['Room'.($x+1).'AdultFirstName'][0] ?>">

						</div>
						<div class="col-md-6 textleft">
							<input type="text" class="hide" name="last_name[]" id="last_name" value="<?php echo $_REQUEST['Room'.($x+1).'AdultLastName'][0] ?>">
						</div>
						<?php } ?>
						<div class="col-md-6 textleft">
							</span><input type="text" class="hide" name="email" id="email" value="<?php echo $_REQUEST['email'] ?>">
						</div>
						<div class="col-md-6 textleft">
							<input type="text" class="hide" name="contact_num" id="contact_num" value="<?php echo $_REQUEST['contact_num'] ?>">
						</div>


						<?php
							$ctGadultamount = 0;
							$ctGchildamount = 0;
		                    $ctBadultamount = 0;
							$ctBchildamount = 0;
		                 	$textrabedamount = 0;
              			 ?>
                                <?php for ($x=0; $x < count($_REQUEST['reqadults']); $x++) { 
			                for ($i=0; $i < $_REQUEST['reqadults'][$x] ; $i++) {  ?>
		                  	<input class="form-control input-sm Room-1Adulttitle hide" name="Room<?php echo $x+1 ?>Adulttitle[]">   
		                        <input type="text" class="hide form-control validated name-validate input-sm" name="Room<?php echo $x+1 ?>AdultFirstName[]">
		                    <input type="text" class="form-control hide validated name-validate  input-sm" name="Room<?php echo $x+1 ?>AdultLastName[]">
		                    <input type="number" class="form-control hide validate validated input-sm" name="Room<?php echo $x+1 ?>AdultAge[]">
		                <?php } ?>
		                <?php for ($j=0; $j <$_REQUEST['reqChild'][$x] ; $j++) { ?>
		                	<input class="form-control input-sm Room-1Adulttitle hide" name="Room<?php echo ($x+1)  ?>ChildTitle[]">
							<input type="text" class="form-control hide validated name-validate  input-sm" name="Room<?php echo ($x+1)  ?>ChildFirstName[]">
							<input type="text" class="form-control validated name-validate hide  input-sm" name="Room<?php echo ($x+1)  ?>ChildLastName[]">
		                <?php } ?>
		                <?php } ?>
                     <input type="hidden" name="boardChildTotal" value="<?php echo $ctBchildamount ?>">

                    <div class="clearfix"></div>
                    <div class="col-md-12">
						<div class="row">
						<?php if(count($additionalfoodrequest)!=0) { ?>
						<span class="size16px bold dark">Add meals</span><br/><br/>
						<?php } ?>
							<div class="row">
								<?php if(count($additionalfoodrequest)!=0) {
									foreach ($additionalfoodrequest['board'] as $frkey => $frvalue) {
									?>
									<div class="col-sm-4 text-center">
											<?php 
												if ($this->session->userdata($frvalue)['supplementType']==$frvalue && $this->session->userdata($frvalue)['contract_id']==$_REQUEST['contract_id'] && $this->session->userdata($frvalue)['room_id']==$_REQUEST['room_id']  && $this->session->userdata($frvalue)['token']==$_REQUEST['token']) { ?>
												<a href="#" class="additional-food disabled">
													<img src="<?php echo base_url();?>assets/images/<?php echo strtolower($frvalue); ?>.png" width="55px" alt="breakfast"/>
													<p>Add <?php echo $frvalue; ?></p>
												</a>
											<?php } else { ?>
												<a href="#" onclick="aditionalfoodRequest1('board%5B%5D','<?php echo $frvalue; ?>');" class="additional-food">
													<img src="<?php echo base_url();?>assets/images/<?php echo strtolower($frvalue); ?>.png" width="55px" alt="breakfast"/>
													<p>Add <?php echo $frvalue; ?></p>
												</a>
											<?php	} ?>
									</div>
								<?php
								 } 
							} ?>
							</div>
							<div class="row" style="margin-top: 10px;">
								<div class="col-sm-12">
								<?php 
								$BreakfastAmount = 0;
								$LunchAmount = 0;
								$DinnerAmount = 0;
								for ($i=0; $i < count($_REQUEST['reqadults']); $i++) { ?>
								<?php $IndexSplit = explode("-", $_REQUEST['Room'.($i+1)]);
								if ($this->session->userdata('Breakfast')!="" && isset($this->session->userdata('Breakfast')['contract_id'][$i]) && $this->session->userdata('Breakfast')['contract_id'][$i]==$IndexSplit[0] && $this->session->userdata('Breakfast')['room_id'][$i]==$IndexSplit[1] && $this->session->userdata('Breakfast')['token']==$_REQUEST['token'] && isset($this->session->userdata('Breakfast')['splAdultsCheck'][$i])) { ?>
									<div class="additional-food-amount">
										<p>
											<a href="#" onclick="aditionalfoodRequest1('board%5B%5D','Breakfast');" class=""><i class="fa fa-pencil-square-o"></i>&nbsp;</a>
											<span>Breakfast Amount </span>: <b><?php echo currency_type(agent_currency(),isset($Breakfast['totAmounts'][$i]) ? $Breakfast['totAmounts'][$i] : 0); ?> <?php echo agent_currency(); ?></b>
											<span style="
											    margin-left: 20%;
											    font-size: 15px;
											    font-weight: bold;
											    color: #0074b9;
											">Room <?php echo $i+1 ?> <img src="<?php echo base_url();?>assets/images/breakfast.png" width="25px" alt="breakfast"></span>
											<a href="#" onclick="aditionalfoodRemoveRequest1('board%5B%5D','Breakfast',<?php echo $i ?>);" class="pull-right additional-close"><i class="fa fa-times-circle"></i></a>
											
										</p>
									</div>
									<?php 
										$BreakfastAmount =  $Breakfast['totAmounts'][$i];
									?>
								<?php } ?>
								<?php
								 if ($this->session->userdata('Lunch')!="" && isset($this->session->userdata('Lunch')['contract_id'][$i]) && $this->session->userdata('Lunch')['contract_id'][$i]==$IndexSplit[0] && $this->session->userdata('Lunch')['room_id'][$i]==$IndexSplit[1] && $this->session->userdata('Lunch')['token']==$_REQUEST['token'] && isset($this->session->userdata('Lunch')['splAdultsCheck'][$i])) { 
								 	?>
									<div class="additional-food-amount">
										<p>
											<a href="#" onclick="aditionalfoodRequest1('board%5B%5D','Lunch');" class=""><i class="fa fa-pencil-square-o"></i>&nbsp;</a>
											<span>Lunch Amount </span>: <b><?php echo currency_type(agent_currency(),isset($Lunch['totAmounts'][$i]) ? $Lunch['totAmounts'][$i] : 0); ?> <?php echo agent_currency(); ?></b>
											<span style="
											    margin-left: 20%;
											    font-size: 15px;
											    font-weight: bold;
											    color: #0074b9;
											">Room <?php echo $i+1 ?> <img src="<?php echo base_url();?>assets/images/lunch.png" width="25px" alt="lunch"></span>
											<a href="#" onclick="aditionalfoodRemoveRequest1('board%5B%5D','Lunch',<?php echo $i ?>);" class="pull-right additional-close"><i class="fa fa-times-circle"></i></a>
											
										</p>
									</div>
									<?php 
										$LunchAmount = $Lunch['totAmounts'][$i];
									 ?>
								<?php } ?>
								<?php if ($this->session->userdata('Dinner')!="" && isset($this->session->userdata('Dinner')['contract_id'][$i]) && $this->session->userdata('Dinner')['contract_id'][$i]==$IndexSplit[0] && $this->session->userdata('Dinner')['room_id'][$i]==$IndexSplit[1] && $this->session->userdata('Dinner')['token']==$_REQUEST['token'] && isset($this->session->userdata('Dinner')['splAdultsCheck'][$i])) { ?>
									<div class="additional-food-amount">
										<p>
											<a href="#" onclick="aditionalfoodRequest1('board%5B%5D','Dinner');" class=""><i class="fa fa-pencil-square-o"></i>&nbsp;</a>
											<span>Dinner Amount </span>: <b><?php echo currency_type(agent_currency(),isset($Dinner['totAmounts'][$i]) ? $Dinner['totAmounts'][$i] : 0); ?> <?php echo agent_currency(); ?></b>
											<span style="
											    margin-left: 20%;
											    font-size: 15px;
											    font-weight: bold;
											    color: #0074b9;
											">Room <?php echo $i+1 ?> <img src="<?php echo base_url();?>assets/images/dinner.png" width="25px" alt="dinner"></span>
											<a href="#" onclick="aditionalfoodRemoveRequest1('board%5B%5D','Dinner',<?php echo $i ?>);" class="pull-right additional-close"><i class="fa fa-times-circle"></i></a>
											
										</p>
									</div>
									<?php
										$DinnerAmount = $Dinner['totAmounts'][$i];
									?>

								<?php } 
									$totalFoodAmount = $BreakfastAmount+$LunchAmount+$DinnerAmount;
									}
								?>
								</div>
							</div>
						</div>
					</div>
					<h4 class="opensans dark bold">Booking Amount Breakup</h4>
					<?php 
						if (isset($_REQUEST['board'])) {
							foreach ($_REQUEST['board'] as $reqkey1 => $reqvalue1) { ?>
								<input type="hidden" name="board[]" value="<?php echo $reqvalue1 ?>">
					<?php	
							}
						}

						if (isset($_REQUEST['reqadults'])) {
							foreach ($_REQUEST['reqadults'] as $reqkey2 => $reqvalue2) { ?>
								<input type="hidden" name="reqadults[]" value="<?php echo $reqvalue2 ?>">
					<?php	}
						}
						if (isset($_REQUEST['reqChild'])) {
							foreach ($_REQUEST['reqChild'] as $reqkey3 => $reqvalue3) { ?>
								<input type="hidden" name="reqChild[]" value="<?php echo $reqvalue3 ?>">
					<?php	}
							for ($k=0; $k <= count($_REQUEST['reqChild']) ; $k++) { 
                          		if (isset($_REQUEST['reqroom'.$k.'-childAge'])) { 
                          			foreach ($_REQUEST['reqroom'.$k.'-childAge'] as $reqkey4 => $reqvalue4) {
								 ?>
                          			<input type="hidden" name="<?php echo 'reqroom'.$k.'-childAge'; ?>[]" value="<?php echo $reqvalue4 ?>">
                   <?php  		
               						}
               					}
							}

						}
					?>


					<input type="hidden" name="max_child_age" value="">
					

				<?php 
				$agent_markup = mark_up_get();
				$general_markup = general_mark_up_get();
				$oneNight = array();
				foreach ($_REQUEST['reqadults'] as $RAkey => $RAvalue) { 
						$IndexSplit = explode("-", $_REQUEST['Room'.($RAkey+1)]);
						$contractId= $IndexSplit[0];
						$RoomId= $IndexSplit[1];
        				$revenue_markup = revenue_markup1($_REQUEST['hotel_id'],$contractId,$this->session->userdata('agent_id'));
        				$extrabed = $this->Payment_Model->get_PaymentConfirmextrabedAllotment($_REQUEST,$IndexSplit[0],$IndexSplit[1],$RAkey);
        				
        				$general = $this->Payment_Model->get_Confirmgeneral_supplement($_REQUEST,$IndexSplit[0],$IndexSplit[1],$RAkey+1);
        				// stay and pay dicount start 
        				$Fdays = 0;
						$discountGet = Alldiscount(date('Y-m-d',strtotime($_REQUEST['Check_in'])),date('Y-m-d',strtotime($_REQUEST['Check_out'])),$_REQUEST['hotel_id'],$RoomId,$contractId,'Room');
						  if ($discountGet['dis']=="true") {
						    $Cdays = $tot_days/$discountGet['stay'];
						    $parts = explode('.', $Cdays);
							$Cdays = $parts[0];
						    $Sdays = $discountGet['stay']*$Cdays;
						    $Pdays = $discountGet['pay']*$Cdays;
						    $Tdays = $tot_days-$Sdays;
						    $Fdays = $Pdays+$Tdays;
						    $discountGet['stay'];
						    $discountGet['pay'];
						  }
        				// stay and pay dicount end 

					?>
					<input type="hidden" name="RoomIndex[]" value="<?php echo $_REQUEST['Room'.($RAkey+1)] ?>">
	            	<div class="row payment-table-wrap">
	            		<div class="col-md-12">
	            			<h4 class="room-name">Room <?php echo $RAkey+1 ?></h4>
	            			<span class="pull-right">
	            				<?php if ($discountGet['dis']=="true") { ?>
	            					<small class="text-right red stay-pay-tag">Stay <?php echo $discountGet['stay'] ?> nights &amp; Pay <?php echo $discountGet['pay'] ?> nights</small>
	            				<?php } ?>
	            			</span>
	            			<table class="table-bordered" >
	            				<thead>
	            					<tr>
	            						<th style="width: 85px;">Date</th>
		            					<th style="width: calc(100% - 265px);">Room Type</th>
		            					<th style="width: 60px; text-align: center">Board</th>
		            					<th style="width: 120px; text-align: right">Rate</th>
	            					</tr>
	            				</thead>
	            				<tbody>
	            					<?php for ($i=1; $i <=$tot_days ; $i++) {
            						$result[$i]['amount'] = special_offer_amount($result[$i]['date'],$RoomId,$_REQUEST['hotel_id'],$contractId);
            						$result[$i]['roomName'] = roomnameGET($RoomId,$_REQUEST['hotel_id']);
	            					$FextrabedAmount[$i-1]  = 0;
	            					$TFextrabedAmount[$i-1]  = 0;
	            					$GAamount[$i-1] = 0;
	            					$GCamount[$i-1] = 0;
	            					$BBAamount[$i-1] = 0;
	            					$BBCamount[$i-1] = 0;
	            					$LAamount[$i-1] = 0;
	            					$LCamount[$i-1] = 0;
	            					$DAamount[$i-1] = 0;
	            					$DCamount[$i-1] = 0;
	            					$TGAamount[$i-1] = 0;
	            					$TGCamount[$i-1] = 0;

	            					$RMdiscount = DateWisediscount(date('Y-m-d' ,strtotime($result[$i]['date'])),$_REQUEST['hotel_id'],$RoomId,$contractId,'Room',date('Y-m-d',strtotime($_REQUEST['Check_in'])),date('Y-m-d',strtotime($_REQUEST['Check_out'])),$discountGet['dis']);
	            					$RMdiscountval[$i] = $RMdiscount['discount'];
	            						$GDis = 0;
		            					if ($RMdiscount['discount']!=0 && $RMdiscount['General']!=0) { 
											$GDis = $RMdiscount['discount'];
										}
										$exDis = 0;
	        							if ($RMdiscount['discount']!=0 && $RMdiscount['Extrabed']!=0) { 
	        								$exDis = $RMdiscount['discount'];
	    								}
	            						$BDis = 0;
	    								if ($RMdiscount['discount']!=0 && $RMdiscount['Board']!=0) { 
	            							$BDis = $RMdiscount['discount'];
    									}
            					 	?>
	            					<!-- Room amount breakup start -->
	            					<tr>
	            						<input type="hidden" name="per_day_amount[]" value="<?php echo $result[$i]['amount']; ?>">
	            						<input type="hidden" name="Room<?php echo $RAkey+1 ?>per_day_amount[]" value="<?php echo $result[$i]['amount']; ?>">
		            					<td><?php echo date('d/m/Y' ,strtotime($result[$i]['date'])) ?></td>
		            					<td><?php echo $result[$i]['roomName'] ?></td>
		            					<td style="text-align: center"><?php echo $boardName ?></td>
		            					<td style="text-align: right"><?php 
		            					$rmamount = 0;
		            					$total_markup = $agent_markup+$general_markup;
		            					if ($revenue_markup['Markup']!='') {
		          							$total_markup = $agent_markup;
									        if ($revenue_markup['Markuptype']=="Percentage") {
									          $rmamount = (($result[$i]['amount']*$revenue_markup['Markup'])/100);
									        } else {
									          $rmamount = $revenue_markup['Markup'];
									        }
									      }
		            					$roomAmount[$i]  = (($result[$i]['amount']*$total_markup)/100)+$result[$i]['amount']+$rmamount;
		            					$DisroomAmount[$i] = $roomAmount[$i]-($roomAmount[$i]*$RMdiscount['discount'])/100;
            							$WiDisroomAmount[$i] = $roomAmount[$i];

            							if ($RMdiscount['discount']!=0) { ?>
		            						<small class="old-price text-danger"><?php 
		            						echo currency_type(agent_currency(),$roomAmount[$i]) ?> <?php echo agent_currency() ?></small>
		            						<br>
		            					<?php }
		            					if ($i==1) {
		            						$oneNight[$RAkey][] = $DisroomAmount[1];
		            					}
		            					echo currency_type(agent_currency(),$DisroomAmount[$i]) ?> <?php echo agent_currency() ?></td>
	            					</tr>
	            					<!-- Room amount breakup end -->
	            					<!-- General Supplement breakup start -->
	            					<?php if($general['gnlCount']!=0) {
	            						//  General Supplement adult breakup start
	            						foreach ($general['date'] as $GAkey => $GAvalue) {
	            							if ($GAvalue==date('d/m/Y' ,strtotime($result[$i]['date']))) {
	            								foreach ($general['general'][$GAkey] as $GSNkey => $GSNvalue) {
	            									if (isset($general['RWadultamount'][$GAkey][$GSNvalue])) {
	            						 ?>
	            							<tr>
	            								<td></td>
	            								<td>Adult <?php echo $GSNvalue  ?></td>
	            								<td class="text-center">-</td>
	            								<td class="text-right"><?php
	            									$GSAmamount = 0;
		            								$total_markup = $agent_markup+$general_markup;
	            									if ($revenue_markup['GeneralSupMarkup']!='') {
		            									$total_markup = $agent_markup;
												        if ($revenue_markup['GeneralSupMarkuptype']=="Percentage") {
												          $GSAmamount = (($general['RWadultamount'][$GAkey][$GSNvalue][$RAkey+1]*$revenue_markup['GeneralSupMarkup'])/100);
												        } else {
												          $GSAmamount = $revenue_markup['GeneralSupMarkup'];
												        }
												      }

	            									$GAamount[$i-1] = ($general['RWadultamount'][$GAkey][$GSNvalue][$RAkey+1]*$total_markup)/100+$general['RWadultamount'][$GAkey][$GSNvalue][$RAkey+1]+$GSAmamount;

	            									$TGAamount[$i-1] += $GAamount[$i-1]-($GAamount[$i-1]*$GDis)/100;
            										if ($RMdiscount['discount']!=0 && $RMdiscount['General']!=0) { 
        											?>
					            						<small class="old-price text-danger"><?php 
					            						echo currency_type(agent_currency(),$GAamount[$i-1]) ?> <?php echo agent_currency() ?></small>
					            						<br>
		                    						<?php }
		            								if ($i==1) {
					            						$oneNight[$RAkey][] = $GAamount[$i-1]-($GAamount[$i-1]*$GDis)/100;
					            					}	
	            								 echo currency_type(agent_currency(),$GAamount[$i-1]-($GAamount[$i-1]*$GDis)/100)." ".agent_currency(); ?></td>
	            							</tr>
	            						<?php } } } }	?>
	            						<!--  General Supplement adult breakup end -->
            						    <!-- General Supplement child breakup start -->
	            					<?php	foreach ($general['date'] as $GCkey => $GCvalue) {
	            							if ($GCvalue==date('d/m/Y' ,strtotime($result[$i]['date']))) {
	            								foreach ($general['general'][$GCkey] as $GSNkey => $GSNvalue) {
	            									if (isset($general['RWchildAmount'][$GCkey]) && isset($general['RWchildAmount'][$GCkey][$GSNvalue][$RAkey+1])) {
	            						 ?>
	            							<tr>
	            								<td></td>
	            								<td>Child <?php echo $GSNvalue  ?></td>
	            								<td class="text-center">-</td>
	            								<td class="text-right"><?php
	            									$GSCmamount = 0;
		            								$total_markup = $agent_markup+$general_markup;
	            									if ($revenue_markup['GeneralSupMarkup']!='') {
		            									$total_markup = $agent_markup;
												        if ($revenue_markup['GeneralSupMarkuptype']=="Percentage") {
												          $GSCmamount = ((array_sum($general['RWchildAmount'][$GCkey][$GSNvalue][$RAkey+1])*$revenue_markup['GeneralSupMarkup'])/100);
												        } else {
												          $GSCmamount = $revenue_markup['GeneralSupMarkup'];
												        }
												      }

	            									$GCamount[$i-1] = (array_sum($general['RWchildAmount'][$GCkey][$GSNvalue][$RAkey+1])*$total_markup)/100+array_sum($general['RWchildAmount'][$GCkey][$GSNvalue][$RAkey+1])+$GSCmamount;
	            									$TGCamount[$i-1] = $GCamount[$i-1]-($GCamount[$i-1]*$GDis)/100;
	            									if ($RMdiscount['discount']!=0 && $RMdiscount['General']!=0) { 
            										?>
					            						<small class="old-price text-danger"><?php 
					            						echo currency_type(agent_currency(),$GCamount[$i-1]) ?> <?php echo agent_currency() ?></small>
					            						<br>
		                    						<?php }
            									if ($i==1) {
				            						$oneNight[$RAkey][] = $GCamount[$i-1]-($GCamount[$i-1]*$GDis)/100;
				            					 }	
	            								 echo currency_type(agent_currency(),$GCamount[$i-1]-($GCamount[$i-1]*$GDis)/100)." ".agent_currency(); ?></td>
	            							</tr>
	            						<?php  } } } }	?>
	            						<!--  General Supplement child breakup start -->

	            					<?php } ?>
	            					<!-- General Supplement breakup end -->
	            					<!-- Extra bed breakup start -->
	            					<?php 
	            					if (isset($extrabed['date'][$i-1]) && isset($extrabed['RwextrabedAmount'][$i-1][$RAkey])) {

	            						foreach ($extrabed['RwextrabedAmount'][$i-1][$RAkey] as $exMkey => $exMvalue) {
	            					 ?>
		            					<tr>
		            						<td></td>
		            						<td><?php echo $extrabed['extrabedType'][$i-1][$RAkey][$exMkey];  ?></td>
		            						<td style="text-align: center">-</td>
		            						<td style="text-align: right"><?php 
		            							$EXamount = 0;
	            								$total_markup = $agent_markup+$general_markup;
            										if ($extrabed['extrabedType'][$i-1][$RAkey][$exMkey]=="Adult Extrabed" || $extrabed['extrabedType'][$i-1][$RAkey][$exMkey]=="Child Extrabed") {
		            									if ($revenue_markup['ExtrabedMarkup']!='') {
		            										$total_markup = $agent_markup;
			            									if ($revenue_markup['ExtrabedMarkuptype']=="Percentage") {
													          $EXamount = (($extrabed['RwextrabedAmount'][$i-1][$RAkey][$exMkey]*$revenue_markup['ExtrabedMarkup'])/100);
													        } else {
													          $EXamount = $revenue_markup['ExtrabedMarkup'];
													        }
												        }
	            									} else {
		            									if ($revenue_markup['BoardSupMarkup']!='') {
		            										$total_markup = $agent_markup;
		            										if ($revenue_markup['BoardSupMarkuptype']=="Percentage") {
													          $EXamount = (($extrabed['RwextrabedAmount'][$i-1][$RAkey][$exMkey]*$revenue_markup['BoardSupMarkup'])/100);
													        } else {
													          $EXamount = $revenue_markup['BoardSupMarkup'];
													        }
												        }
	            									}


											        
		            							$FextrabedAmount[$i-1] =  ($extrabed['RwextrabedAmount'][$i-1][$RAkey][$exMkey]*$total_markup)/100+$extrabed['RwextrabedAmount'][$i-1][$RAkey][$exMkey]+$EXamount; 
		            							
		            							$TFextrabedAmount[$i-1] += $FextrabedAmount[$i-1]-($FextrabedAmount[$i-1]*$exDis)/100; 
		            							if ($RMdiscount['discount']!=0 && $RMdiscount['Extrabed']!=0) { 
		            								?>
					            						<small class="old-price text-danger"><?php 
					            						echo currency_type(agent_currency(),$FextrabedAmount[$i-1]) ?> <?php echo agent_currency() ?></small>
					            						<br>
	                    						<?php }
	                    						if ($i==1) {
				            						$oneNight[$RAkey][] = $FextrabedAmount[$i-1]-($FextrabedAmount[$i-1]*$exDis)/100;
				            					 }
	                    						echo currency_type(agent_currency(),$FextrabedAmount[$i-1]-($FextrabedAmount[$i-1]*$exDis)/100) ?> <?php echo agent_currency() ?>
	                    					</td>
		            					</tr>
	            					<?php } } ?>
	            					<!-- Extra bed breakup end -->
	            					<!-- Breakfast breakup start -->
	            					<?php 

	            					if ($this->session->userdata('Breakfast')!="" && isset($this->session->userdata('Breakfast')['contract_id'][$RAkey]) && $this->session->userdata('Breakfast')['contract_id'][$RAkey]==$IndexSplit[0] && $this->session->userdata('Breakfast')['room_id'][$RAkey]==$IndexSplit[1] && $this->session->userdata('Breakfast')['token']==$_REQUEST['token'] && isset($this->session->userdata('Breakfast')['splAdultsCheck'][$RAkey])) {
	            					 // Breakfast Adult breakup start 
            					 		if (isset($Breakfast['Room'.($RAkey+1)]['adults'])) {
	            						foreach ($Breakfast['Room'.($RAkey+1)]['adults']['date'] as $BADkey => $BADvalue) { 
	            							if ($BADvalue==date('Y-m-d' ,strtotime($result[$i]['date'])) && isset($Breakfast['Room'.($RAkey+1)]['adults']['adultAmount'][$BADkey][$RAkey+1])) { ?>
	            								
	            								<tr>
	            									<td></td>
	            									<td>Adult Breakfast</td>
	            									<td style="text-align: center;">-</td>
	            									<td style="text-align: right;"><?php 
	            										$BsAamount = 0;
		            									$total_markup = $agent_markup+$general_markup;
	            										if ($revenue_markup['BoardSupMarkup']!='') {
	            										  $total_markup = $agent_markup;
											              if ($revenue_markup['BoardSupMarkuptype']=="Percentage") {
											                $BsAamount = (($Breakfast['Room'.($RAkey+1)]['adults']['adultAmount'][$BADkey][$RAkey+1]*$revenue_markup['BoardSupMarkup'])/100);
											              } else {
											                $BsAamount = $revenue_markup['BoardSupMarkup']*$this->session->userdata('Breakfast')['splAdults'][$RAkey];
											              }
											            }
	            										$BBAamount[$i-1] = ($Breakfast['Room'.($RAkey+1)]['adults']['adultAmount'][$BADkey][$RAkey+1]*$total_markup)/100+$Breakfast['Room'.($RAkey+1)]['adults']['adultAmount'][$BADkey][$RAkey+1]+$BsAamount;
            											$BBAamount[$i-1] = $BBAamount[$i-1]-($BBAamount[$i-1]*$BDis)/100;
	            										if ($RMdiscount['discount']!=0 && $RMdiscount['Board']!=0) { 
            											?>
							            						<small class="old-price text-danger"><?php 
							            						echo currency_type(agent_currency(),($Breakfast['Room'.($RAkey+1)]['adults']['adultAmount'][$BADkey][$RAkey+1]*$total_markup)/100+$Breakfast['Room'.($RAkey+1)]['adults']['adultAmount'][$BADkey][$RAkey+1]+$BsAamount) ?> <?php echo agent_currency() ?></small>
							            						<br>
			                    						<?php }
	            										if ($i==1) {
						            						$oneNight[$RAkey][] = $BBAamount[$i-1];
						            					 }
	            										echo currency_type(agent_currency(),$BBAamount[$i-1]) ?> <?php echo agent_currency()
	            										 ?></td>
	            								</tr>
	            						
	            							<?php } ?>
	            						<?php } } ?>
            					 	<!--  Breakfast Adult breakup end  -->
            					 	<!--  Breakfast child breakup start  -->
            					 		<?php 
            					 		if (isset($Breakfast['Room'.($RAkey+1)]['childs'])) {
            					 		 foreach ($Breakfast['Room'.($RAkey+1)]['childs']['date'] as $BADkey => $BADvalue) { 
	            							if ( $BADvalue==date('Y-m-d' ,strtotime($result[$i]['date'])) && isset($Breakfast['Room'.($RAkey+1)]['childs']['childAmount'][$BADkey][$RAkey+1])) { ?>
	            								
	            								<tr>
	            									<td></td>
	            									<td>Child Breakfast</td>
	            									<td style="text-align: center;">-</td>
	            									<td style="text-align: right;"><?php 
	            										$BsCamount = 0;
		            									$total_markup = $agent_markup+$general_markup;
	            										if ($revenue_markup['BoardSupMarkup']!='') {
		            									  $total_markup = $agent_markup;
											              if ($revenue_markup['BoardSupMarkuptype']=="Percentage") {
											                $BsCamount = ((array_sum($Breakfast['Room'.($RAkey+1)]['childs']['childAmount'][$BADkey][$RAkey+1])*$revenue_markup['BoardSupMarkup'])/100);
											              } else {
											                $BsCamount = $revenue_markup['BoardSupMarkup']*$this->session->userdata('Breakfast')['splChild'][$RAkey];
											              }
											            }


	            										$BBCamount[$i-1] = (array_sum($Breakfast['Room'.($RAkey+1)]['childs']['childAmount'][$BADkey][$RAkey+1])*$total_markup)/100+array_sum($Breakfast['Room'.($RAkey+1)]['childs']['childAmount'][$BADkey][$RAkey+1])+$BsCamount;
            											$BBCamount[$i-1] = $BBCamount[$i-1]-($BBCamount[$i-1]*$BDis)/100;
	            										if ($RMdiscount['discount']!=0 && $RMdiscount['Board']!=0) { 
            											?>
							            						<small class="old-price text-danger"><?php 
							            						echo currency_type(agent_currency(),(array_sum($Breakfast['Room'.($RAkey+1)]['childs']['childAmount'][$BADkey][$RAkey+1])*$total_markup)/100+array_sum($Breakfast['Room'.($RAkey+1)]['childs']['childAmount'][$BADkey][$RAkey+1])+$BsCamount) ?> <?php echo agent_currency() ?></small>
							            						<br>
			                    						<?php }
	            										if ($i==1) {
						            						$oneNight[$RAkey][] = $BBCamount[$i-1];
						            					 }
	            										echo currency_type(agent_currency(),$BBCamount[$i-1]) ?> <?php echo agent_currency()
	            										 ?></td>
	            								</tr>
	            						
	            							<?php } ?>
	            						<?php } } ?>
            					 	<!--  Breakfast child breakup end  -->
	            					<?php } ?>
            					 	<!--  Breakfast breakup end  -->
            					 	<!-- Lunch breakup start -->
	            					<?php 

            						if ($this->session->userdata('Lunch')!="" && isset($this->session->userdata('Lunch')['contract_id'][$RAkey]) && $this->session->userdata('Lunch')['contract_id'][$RAkey]==$IndexSplit[0] && $this->session->userdata('Lunch')['room_id'][$RAkey]==$IndexSplit[1] && $this->session->userdata('Lunch')['token']==$_REQUEST['token'] && isset($this->session->userdata('Lunch')['splAdultsCheck'][$RAkey])) { 
	            					 // Lunch Adult breakup start 

            					 		if (isset($Lunch['Room'.($RAkey+1)]['adults'])) {
	            						foreach ($Lunch['Room'.($RAkey+1)]['adults']['date'] as $LADkey => $LADvalue) { 
	            							if ($LADvalue==date('Y-m-d' ,strtotime($result[$i]['date'])) && isset($Lunch['Room'.($RAkey+1)]['adults']['adultAmount'][$LADkey][$RAkey+1])) { ?>
	            								<tr>
	            									<td></td>
	            									<td>Adult Lunch</td>
	            									<td style="text-align: center;">-</td>
	            									<td style="text-align: right;"><?php 
	            										$LsAamount = 0;
		            									$total_markup = $agent_markup+$general_markup;
	            										if ($revenue_markup['BoardSupMarkup']!='') {
		            									$total_markup = $agent_markup;
											              if ($revenue_markup['BoardSupMarkuptype']=="Percentage") {
											                $LsAamount = (($Lunch['Room'.($RAkey+1)]['adults']['adultAmount'][$LADkey][$RAkey+1]*$revenue_markup['BoardSupMarkup'])/100);
											              } else {
											                $LsAamount = $revenue_markup['BoardSupMarkup']*$this->session->userdata('Lunch')['splAdults'][$RAkey];
											              }
											            }

	            										$LAamount[$i-1] = ($Lunch['Room'.($RAkey+1)]['adults']['adultAmount'][$LADkey][$RAkey+1]*$total_markup)/100+$Lunch['Room'.($RAkey+1)]['adults']['adultAmount'][$LADkey][$RAkey+1]+$LsAamount;

            											$LAamount[$i-1] = $LAamount[$i-1]-($LAamount[$i-1]*$BDis)/100;
	            										if ($RMdiscount['discount']!=0 && $RMdiscount['Board']!=0) { 
            											?>
							            						<small class="old-price text-danger"><?php 
							            						echo currency_type(agent_currency(),($Lunch['Room'.($RAkey+1)]['adults']['adultAmount'][$LADkey][$RAkey+1]*$total_markup)/100+$Lunch['Room'.($RAkey+1)]['adults']['adultAmount'][$LADkey][$RAkey+1]+$LsAamount) ?> <?php echo agent_currency() ?></small>
							            						<br>
			                    						<?php }

	            										if ($i==1) {
						            						$oneNight[$RAkey][] = $LAamount[$i-1];
						            					 }
	            										echo currency_type(agent_currency(),$LAamount[$i-1]) ?> <?php echo agent_currency()
	            										 ?></td>
	            								</tr>
	            						
	            							<?php } ?>
	            						<?php } } ?>
            					 	<!--  Lunch Adult breakup end  -->
            					 	<!--  Lunch child breakup start  -->
            					 		<?php 
            					 		if (isset($Lunch['Room'.($RAkey+1)]['childs'])) {
            					 		foreach ($Lunch['Room'.($RAkey+1)]['childs']['date'] as $LADkey => $LADvalue) { 
	            							if ($LADvalue==date('Y-m-d' ,strtotime($result[$i]['date'])) && isset($Lunch['Room'.($RAkey+1)]['childs']['childAmount'][$LADkey][$RAkey+1])) { ?>
	            								<tr>
	            									<td></td>
	            									<td>Child Lunch</td>
	            									<td style="text-align: center;">-</td>
	            									<td style="text-align: right;"><?php 
	            										$LsCamount = 0;
		            									$total_markup = $agent_markup+$general_markup;
	            										if ($revenue_markup['BoardSupMarkup']!='') {
		            									  $total_markup = $agent_markup;
											              if ($revenue_markup['BoardSupMarkuptype']=="Percentage") {
											                $LsCamount = ((array_sum($Lunch['Room'.($RAkey+1)]['childs']['childAmount'][$LADkey][$RAkey+1])*$revenue_markup['BoardSupMarkup'])/100);
											              } else {
											                $LsCamount = $revenue_markup['BoardSupMarkup']*$this->session->userdata('Lunch')['splChild'][$RAkey];
											              }
											            }

	            										$LCamount[$i-1] = (array_sum($Lunch['Room'.($RAkey+1)]['childs']['childAmount'][$LADkey][$RAkey+1])*$total_markup)/100+array_sum($Lunch['Room'.($RAkey+1)]['childs']['childAmount'][$LADkey][$RAkey+1])+$LsCamount;
            											$LCamount[$i-1] = $LCamount[$i-1]-($LCamount[$i-1]*$BDis)/100;
	            										if ($RMdiscount['discount']!=0 && $RMdiscount['Board']!=0) { 
            											?>
							            						<small class="old-price text-danger"><?php 
							            						echo currency_type(agent_currency(),(array_sum($Lunch['Room'.($RAkey+1)]['childs']['childAmount'][$LADkey][$RAkey+1])*$total_markup)/100+array_sum($Lunch['Room'.($RAkey+1)]['childs']['childAmount'][$LADkey][$RAkey+1])+$LsCamount) ?> <?php echo agent_currency() ?></small>
							            						<br>
			                    						<?php }
	            										if ($i==1) {
						            						$oneNight[$RAkey][] = $LCamount[$i-1];
						            					 }
	            										echo currency_type(agent_currency(),$LCamount[$i-1]) ?> <?php echo agent_currency()
	            										 ?></td>
	            								</tr>
	            						
	            							<?php } ?>
	            						<?php } } ?>
            					 	<!--  Lunch child breakup end  -->
	            					<?php } ?>
            					 	<!--  Lunch breakup end  -->
            					 	<!-- Dinner breakup start -->
	            					<?php 
	            					
	            					if ($this->session->userdata('Dinner')!="" && isset($this->session->userdata('Dinner')['contract_id'][$RAkey]) && $this->session->userdata('Dinner')['contract_id'][$RAkey]==$IndexSplit[0] && $this->session->userdata('Dinner')['room_id'][$RAkey]==$IndexSplit[1] && $this->session->userdata('Dinner')['token']==$_REQUEST['token'] && isset($this->session->userdata('Dinner')['splAdultsCheck'][$RAkey])) {
	            					 // Dinner Adult breakup start 

            					 		if (isset($Dinner['Room'.($RAkey+1)]['adults'])) {
	            						foreach ($Dinner['Room'.($RAkey+1)]['adults']['date'] as $DAkey => $DAvalue) { 
	            							if ($DAvalue==date('Y-m-d' ,strtotime($result[$i]['date'])) && isset($Dinner['Room'.($RAkey+1)]['adults']['adultAmount'][$DAkey][$RAkey+1])) { ?>
	            								<tr>
	            									<td></td>
	            									<td>Adult Dinner</td>
	            									<td style="text-align: center;">-</td>
	            									<td style="text-align: right;"><?php 
	            										$DsAamount = 0;
		            									$total_markup = $agent_markup+$general_markup;
	            										if ($revenue_markup['BoardSupMarkup']!='') {
		            									  $total_markup = $agent_markup;
											              if ($revenue_markup['BoardSupMarkuptype']=="Percentage") {
											                $DsAamount = (($Dinner['Room'.($RAkey+1)]['adults']['adultAmount'][$DAkey][$RAkey+1]*$revenue_markup['BoardSupMarkup'])/100);
											              } else {
											                $DsAamount = $revenue_markup['BoardSupMarkup']*$this->session->userdata('Dinner')['splAdults'][$RAkey];
											              }
											            }
	            										$DAamount[$i-1] = ($Dinner['Room'.($RAkey+1)]['adults']['adultAmount'][$DAkey][$RAkey+1]*$total_markup)/100+$Dinner['Room'.($RAkey+1)]['adults']['adultAmount'][$DAkey][$RAkey+1]+$DsAamount;
            											$DAamount[$i-1] = $DAamount[$i-1]-($DAamount[$i-1]*$BDis)/100;
	            										if ($RMdiscount['discount']!=0 && $RMdiscount['Board']!=0) {
            										    ?>
						            						<small class="old-price text-danger"><?php 
						            						echo currency_type(agent_currency(),($Dinner['Room'.($RAkey+1)]['adults']['adultAmount'][$DAkey][$RAkey+1]*$total_markup)/100+$Dinner['Room'.($RAkey+1)]['adults']['adultAmount'][$DAkey][$RAkey+1]+$DsAamount) ?> <?php echo agent_currency() ?></small>
						            						<br>
			                    						<?php }
	            										if ($i==1) {
						            						$oneNight[$RAkey][] = $DAamount[$i-1];
						            					 }
	            										echo currency_type(agent_currency(),$DAamount[$i-1]) ?> <?php echo agent_currency()
	            										 ?></td>
	            								</tr>
	            						
	            							<?php } ?>
	            						<?php } } ?>
            					 	<!--  Lunch Adult breakup end  -->
            					 	<!--  Dinner child breakup start  -->
            					 		<?php 
            					 		if (isset($Dinner['Room'.($RAkey+1)]['childs'])) {
            					 		foreach ($Dinner['Room'.($RAkey+1)]['childs']['date'] as $DAkey => $DAvalue) { 
	            							if ($DAvalue==date('Y-m-d' ,strtotime($result[$i]['date'])) && isset($Dinner['Room'.($RAkey+1)]['childs']['childAmount'][$DAkey][$RAkey+1])) { ?>
	            								<tr>
	            									<td></td>
	            									<td>Child Dinner</td>
	            									<td style="text-align: center;">-</td>
	            									<td style="text-align: right;"><?php 
	            										$DsCamount = 0;
		            									$total_markup = $agent_markup+$general_markup;
	            										if ($revenue_markup['BoardSupMarkup']!='') {
		            									  $total_markup = $agent_markup;
											              if ($revenue_markup['BoardSupMarkuptype']=="Percentage") {
											                $DsCamount = ((array_sum($Dinner['Room'.($RAkey+1)]['childs']['childAmount'][$DAkey][$RAkey+1])*$revenue_markup['BoardSupMarkup'])/100);
											              } else {
											                $DsCamount = $revenue_markup['BoardSupMarkup']*$this->session->userdata('Dinner')['splChild'][$RAkey];
											              }
											            }
	            										$DCamount[$i-1] = (array_sum($Dinner['Room'.($RAkey+1)]['childs']['childAmount'][$DAkey][$RAkey+1])*$total_markup)/100+array_sum($Dinner['Room'.($RAkey+1)]['childs']['childAmount'][$DAkey][$RAkey+1])+$DsCamount;
	            										$DCamount[$i-1] = $DCamount[$i-1]-($DCamount[$i-1]*$BDis)/100;
	            										if ($RMdiscount['discount']!=0 && $RMdiscount['Board']!=0) { 
            											?>
							            						<small class="old-price text-danger"><?php 
							            						echo currency_type(agent_currency(),(array_sum($Dinner['Room'.($RAkey+1)]['childs']['childAmount'][$DAkey][$RAkey+1])*$total_markup)/100+array_sum($Dinner['Room'.($RAkey+1)]['childs']['childAmount'][$DAkey][$RAkey+1])+$DsCamount) ?> <?php echo agent_currency() ?></small>
							            						<br>
			                    						<?php }
	            										if ($i==1) {
						            						$oneNight[$RAkey][] = $DCamount[$i-1];
						            					}
	            										echo currency_type(agent_currency(),$DCamount[$i-1]) ?> <?php echo agent_currency()
	            										 ?></td>
	            								</tr>
	            						
	            							<?php } ?>
	            						<?php } } ?>
            					 	<!--  Dinner child breakup end  -->
	            					<?php } ?>
            					 	<!--  Dinner breakup end  -->
	            					<?php } ?>
	            				</tbody>
	            				<tfoot>
	            					<tr>
	            						<td colspan="3" style="text-align: right"><?php 

	            						$witotal[$RAkey] = array_sum($WiDisroomAmount)+array_sum($TFextrabedAmount)+array_sum($BBAamount)+array_sum($BBCamount)+array_sum($LAamount)+array_sum($LCamount)+array_sum($DAamount)+array_sum($DCamount)+array_sum($TGAamount)+array_sum($TGCamount);
	            						
	            						$total[$RAkey] = array_sum($DisroomAmount)+array_sum($TFextrabedAmount)+array_sum($BBAamount)+array_sum($BBCamount)+array_sum($LAamount)+array_sum($LCamount)+array_sum($DAamount)+array_sum($DCamount)+array_sum($TGAamount)+array_sum($TGCamount); 
	            						if ($discountGet['dis']=="true") {
	            							if ($discountGet['Extrabed']==1) {
	            								array_splice($TFextrabedAmount,$Fdays);
	            							}
	            							if ($discountGet['General']==1) {
	            								array_splice($TGAamount,$Fdays);
	            								array_splice($TGCamount,$Fdays);
	            							}
	            							if ($discountGet['Board']==1) {
	            								array_splice($BBAamount,$Fdays);
	            								array_splice($BBCamount,$Fdays);

	            								array_splice($LAamount,$Fdays);
	            								array_splice($LCamount,$Fdays);

	            								array_splice($DAamount,$Fdays);
	            								array_splice($DCamount,$Fdays);
	            							}
            							}
	            						$totRmAmt[$RAkey] = array_sum(array_splice($DisroomAmount, 1,$Fdays))+array_sum($TFextrabedAmount)+array_sum($BBAamount)+array_sum($BBCamount)+array_sum($LAamount)+array_sum($LCamount)+array_sum($DAamount)+array_sum($DCamount)+array_sum($TGAamount)+array_sum($TGCamount); 
	            						unset($DisroomAmount);
	            						unset($WiDisroomAmount);
	            						?><strong class="text-blue">Total</strong></td>
	            						<td style="text-align: right; font-weight: 700; color: #0074b9">
	            							<?php 
	            								if ($discountGet['dis']=="true") { ?>
	            									<small class="old-price text-danger" style="font-size: 11px;font-weight: 100;"><?php echo currency_type(agent_currency(),$total[$RAkey])." ".agent_currency(); ?></small><br>
	            									<?php echo currency_type(agent_currency(),$totRmAmt[$RAkey])." ".agent_currency(); ?>
            								<?php 
            									$total[$RAkey] = $totRmAmt[$RAkey];
            									} else {
	            									echo currency_type(agent_currency(),$total[$RAkey])." ".agent_currency();  
            									}
	            							?></td>
	            					</tr>
	            				</tfoot>
	            			</table>
	            		</div>
	            	</div>
            	<?php }  ?>
                </div>
               
			<!-- <div class="clearfix pbottom15"></div> -->
			<div class="col-md-12"> 
			<div class="row b-rates margtop10">
	            <div class="col-sm-12">
		            <div class="col-sm-12">
		              <h5 class="b-rates--tax">Tax : <span class="right"><?php echo $tax; ?>%</span></h5>
		                <?php 
	                		$finalAmount = array_sum($total);
							$finalAmount = ($finalAmount*$tax)/100+$finalAmount;
							$grandTotal = ($finalAmount*$tax)/100+$finalAmount;
					    ?>
		              	<h5 class="b-rates--grand">GRAND TOTAL : 
		              	<span class="right"><?php echo agent_currency(); ?> 
			              	<span class="b-rates--grand-total"><?php echo currency_type(agent_currency(),$finalAmount);?> </span>
						</span>
						</h5>
						<?php 
							$this->session->set_userdata('tot-'.$_REQUEST['hotel_id'],$finalAmount);
						?>
		            </div>
	            </div>
	          </div>
	        </div>
			<div class="col-md-12 padding30" style="padding-bottom: 0px;padding-top: 0px;">
        		<h4 class="opensans dark bold">Special Request</h4>        		<textarea name="SpecialRequest" class="form-control" placeholder="eg: I want early check-in or specify the time you will check-in"></textarea>
        	</div>
			<div class="col-md-12 padding30">
				<span class="opensans size18 blue bold">Important Remarks & Policies</span><br><br>
				<div><?php echo isset($contract[0]->Important_Remarks_Policies) ? $contract[0]->Important_Remarks_Policies : 'Not Applicable'; ?></div>
			</div> 
			<br>
			<div class="alert alert-info padding30">
				<span class="opensans size18 blue bold">Cancellation Policy *</span><br><br>
				<?php 

				for ($i=0; $i < count($_REQUEST['reqadults']); $i++) { 
					$IndexSplit = explode("-", $_REQUEST['Room'.($i+1)]);
					$Cancellation[$i] = $this->Payment_Model->get_CancellationPolicy_table($_REQUEST,$IndexSplit[0],$IndexSplit[1]);
				?>	
				<div class="payment-table-wrap">
					<h4 class="room-name">Room <?php echo $i+1 ?> - <?php echo roomnameGET($RoomId,$_REQUEST['hotel_id']) ?></h4>
					<table class="table table-bordered table-hover">
						<thead>
					      <tr>
					        <th>Cancelled on or After</th>
					        <th>Cancelled on or Before</th>
					        <th>Cancellation Charge</th>
					      </tr>
					    </thead>
					    <tbody> 
					    	<?php 
					    	if (count($Cancellation[$i])!=0) {
					    		if ($Cancellation[$i][0]['application']=="Nonrefundable") { ?>
					    			<tr>
		                              <td colspan="3">
		                               		This booking is Nonrefundable
		                              </td>
		                            </tr>
			    			<?php } else {
					    	  foreach ($Cancellation[$i] as $key => $Cancvalue) {
					    	?>
					    	<tr>
					    		<td><?php echo $Cancvalue['after'] ?></td>
					    		<td><?php echo $Cancvalue['before'] ?></td>
					    		<td><?php 
					    		if ($Cancvalue['application']=="FIRST NIGHT") {
					    			$finalAmount = array_sum($oneNight[$i]);
					    		}

					    		if ($Cancvalue['application']=="FREE OF CHARGE") {
					    			$finalAmount = 0;
					    		}

					    		$charge = $total[$i]*($Cancvalue['percentage']/100);
					    		echo currency_type(agent_currency(),$charge)." ".agent_currency()
					    		// echo $Cancvalue['percentage'] ?> (<?php echo $Cancvalue['application'] ?>)</td>
					    	</tr>
					      <?php  } } } else { ?> 
                            <tr>
                              <td colspan="3">
                               		This booking is Nonrefundable
                              </td>
                            </tr>
                          <?php } ?>
				    	</tbody>
					</table>
					
				</div> 

				<?php 
				}
				?>
				<br>
					<input type="checkbox" name="cancel_agree" id="cancel_agree">
						<span id="check_box_cancellation_err blink_me"></span>
				 	<label class="opensans size12 blue bold" for="cancel_agree">If you agree to the cancellation policy, kindly select the checkbox and proceed.</label> 
			</div>


			<div class="row">
				<div class="col-md-12">
					<div class="col-md-12 pay_options">
						<h4 class="hpadding20 dark bold">Choose a Payment Option <small class="pay_error"></small></h4>
						<div class="hpadding20">
						<?php 
						$check_tot = $grandTotal;
						if ($check_tot <= $agent_credit_amount) { ?>
							<div class="payment-radio-group clearfix">
				                <input type="radio" id="credit" name="paymenttype" value="credit" class="hidden payment-radio__btn">
				                <label for="credit" class="payment-radio__label">
				                  <span>Credit Amount</span>
				                  <small>The amount paid will be deducted from the agent credit.</small>
				                  <img src="" alt="" height="30">
				                </label>
			              	</div>
						<?php } else { ?>
							<div class="payment-radio-group clearfix">
				                <label for="credit" class="payment-radio__label" style="border: 1px solid red;">
				                  <span>Credit Amount</span>
				                  <small style="color: red;">You have insufficient funds</small>
				                  <img src="" alt="" height="30">
				                </label>
			              	</div>
						<?php }
						if($paypal[0]->active=='1'){ ?>
							<div class="payment-radio-group clearfix">
				                <input type="radio" id="paypal" name="paymenttype" value="paypal" class="hidden payment-radio__btn">
				                <label for="paypal" class="payment-radio__label">
				                  <span>Paypal</span>
				                  <small>The amount paid will be deducted from the paypal.</small>
				                  <img src="" alt="" height="30">
				                </label>
				              </div>
						<?php } 
						if($checkout[0]->active=='1'){ ?>
							<div class="payment-radio-group clearfix">
				                <input type="radio" id="checkout" name="paymenttype" value="checkout" class="hidden payment-radio__btn">
				                <label for="checkout" class="payment-radio__label">
				                  <span>2Checkout</span>
				                  <small>The amount paid will be deducted from the 2Checkout.</small>
				                  <img src="" alt="" height="30">
				                </label>
				              </div>
						<?php } 
						if($braintree[0]->active=='1'){ ?>
							<div class="payment-radio-group clearfix">
				                <input type="radio" id="braintree" name="paymenttype" value="braintree" class="hidden payment-radio__btn">
				                <label for="braintree" class="payment-radio__label">
				                  <span>Braintree</span>
				                  <small>The amount paid will be deducted from the Braintree.</small>
				                  <img src="" alt="" height="30">
				                </label>
			                </div>
						<?php } 
						if($mollie[0]->active=='1'){ ?>
							<div class="payment-radio-group clearfix">
				                <input type="radio" id="mollie" name="paymenttype" value="mollie" class="hidden payment-radio__btn">
				                <label for="mollie" class="payment-radio__label">
				                  <span>Mollie</span>
				                  <small>The amount paid will be deducted from the Mollie.</small>
				                  <img src="" alt="" height="30">
				                </label>
			                </div>
						<?php } 
						if($authorize_sim[0]->active=='1'){ ?>
							<div class="payment-radio-group clearfix">
				                <input type="radio" id="authorize_sim" name="paymenttype" value="authorize_sim" class="hidden payment-radio__btn">
				                <label for="authorize_sim" class="payment-radio__label">
				                  <span>Authorize.net SIM</span>
				                  <small>The amount paid will be deducted from the Authorize.net SIM.</small>
				                  <img src="" alt="" height="30">
				                </label>
			                </div>
						<?php } 
						if($authorize_aim[0]->active=='1'){ ?>
							<div class="payment-radio-group clearfix">
				                <input type="radio" id="authorize_aim" name="paymenttype" value="authorize_aim" class="hidden payment-radio__btn">
				                <label for="authorize_aim" class="payment-radio__label">
				                  <span>Authorize.net AIM</span>
				                  <small>The amount paid will be deducted from the Authorize.net AIM.</small>
				                  <img src="" alt="" height="30">
				                </label>
			                </div>
						<?php } 
						if($stripe[0]->active=='1'){ ?>
							<div class="payment-radio-group clearfix">
				                <input type="radio" id="stripe" name="paymenttype" value="stripe" class="hidden payment-radio__btn">
				                <label for="stripe" class="payment-radio__label">
				                  <span>Stripe</span>
				                  <small>The amount paid will be deducted from the Stripe.</small>
				                  <img src="" alt="" height="30">
				                </label>
			                </div>
						<?php } 
						if($telr[0]->active=='1'){ ?>
							<div class="payment-radio-group clearfix">
				                <input type="radio" id="telr" name="paymenttype" value="telr" class="hidden payment-radio__btn">
				                <label for="telr" class="payment-radio__label">
				                  <span>Credit card/Debit card</span>
				                  <small>The amount paid will be deducted from the Credit card/Debit card.</small>
				                  <img src="" alt="" height="30">
				                </label>
			                </div>
						<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</form>

		<div class="col-md-12 mt10">
			<?php
			if ($finalAmount <= $agent_credit_amount || $paypal[0]->active=='1'|| $checkout[0]->active=='1' || $braintree[0]->active=='1' || $mollie[0]->active=='1' || $authorize_sim[0]->active=='1'|| $authorize_aim[0]->active=='1'|| $stripe[0]->active=='1' || $telr[0]->active=='1') { ?>
				<div class="form-group col-md-12">
					<button class="bluebtn pull-right" id="Confirm_book" type="button" name="Continue_book">Confirm</button>
				</div>
			<?php	} else { ?> 
				<div class="clearfix"></div>
				<div class="row">
					<div class="col-md-12">
						<p class="text-center text-danger">Credit amount too low.please contact admin and no other payment methods found.</p>
					</div>
				</div>
			<?php } ?>
			</div>
			<div class="clear-fix"></div>
		</div>
	</div>
<div class="modal fade " id="boardAllocation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

		<!-- END OF RIGHT CONTENT -->
	</div>
</div>

<!-- END OF CONTENT -->
<?php init_front_black_tail(); ?> 

	

