<?php init_front_head_dashboard(); ?>
<script src="<?php echo static_url(); ?>skin/js/booking.js"></script>
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
</style>
<div class="booking-view">
<div class="row">
	<div class="col-md-6">
		<h3>Booking view</h3>
	</div>
	<div class="col-md-6">
		</br>
		<a class="pull-right btn btn-primary" href="<?php echo  base_url(); ?>Payment/agent_booking">back</a>
	</div>
</div>
</div>
<div class="clearfix"></div>
</br>
</br>
<div class="my-card">
<div class="row">
	<div class="col-md-12">

		<div class="row">
			
			<div class="col-md-12">
				<h4 class="dark bold">Hotel Details</h4>
			</div>
			<div class="col-md-12">
				<div class="col-md-4">
					<div class="pro-bg">
					<img  class="img_size_custom"   width="300" src="<?php echo images_url(); ?>uploads/gallery/<?php echo $view[0]->hotel_id ?>/<?php echo $view[0]->Image1 ?>" class="left" alt="">
				</div>
				</div>
				<div class="col-md-8">
					<div class="col-md-6">
						<p><span class="opensans size17 bold"><?php echo $view[0]->hotel_name ?></span></p>
						
						<div class="row">
							<div class="col-md-12">
								<h4>Address</h4>
							</div>
							<div class="col-md-12">
								<div class="col-md-6">
									<?php echo $view[0]->sale_address ?>
									</br>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<p><img src="<?php echo static_url(); ?>skin/images/bigrating-<?php echo $view[0]->rating ?>.png" alt=""></p>
						<div class="row">
							<div class="col-md-12">
								<h4>Location</h4>
							</div>
							<div class="col-md-12">
								<div class="col-md-6">
									<?php echo $view[0]->location ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			</br>
			
			<div class="clearfix"></div>
			</br>
		
		</div><!-- mark -->

	</div>
	<div class="line2"></div>
	<div class="col-md-12 sleft_bor">
		<div class="row">
			<div class="col-md-12">
				<h4 class="dark bold">Booking Details</h4>
			</div>
			<div class="col-md-12">
				<div class="col-md-6">
					<span>Booking Id : <?php echo $view[0]->booking_id ?></span><br>
					<span>Booking date : <?php echo date('d/m/Y',strtotime($view[0]->booking_date)) ?></span>
					<?php if ($view[0]->boardName!="") { ?>
						<br><span>Board : <?php echo $view[0]->boardName; ?></span>
					<?php } ?>
				</div>
			</div>
		</div>
		</br>
		<div class="line2"></div>
		<div class="row">
			<div class="col-md-12">
				<div class="padding20 margtop25" style="background-color: ghostwhite;">
					<div class="row">
						<div class="col-sm-6"  style="border-right: 1px dashed #bbb">
							<label>Adult(s) Details <span class="badge"><?php echo $view[0]->adults_count ?></span></label>
								
						</div>
						<div class="col-sm-6">
							<label>Children(s) Details <span class="badge"><?php echo $view[0]->childs_count ?></span></label>
						</div>
					</div>
				</div><br>
				<div class="col-mds-12">
				<h4>Contact Details</h4> 
					<table class="table table-striped table-dark">
						<thead>
							<tr>
								<td>Name</td>
								<td>Email</td>
								<td>Contact number</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php echo $view[0]->bk_contact_fname." ".$view[0]->bk_contact_lname; ?></td>
								<td><?php echo $view[0]->bk_contact_email ?></td>
								<td><?php echo $view[0]->bk_contact_number ?></td>	
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<h4>Day Details</h4> 
				<p>Total Days : <?php echo $view[0]->no_of_days ?></p>
				<p>No of rooms : <?php echo $view[0]->book_room_count ?></p>
				<span>Check In Date : </span><span class="bold"><?php $check_in=date_create($view[0]->check_in);
				 echo date_format($check_in,'d-M-Y') ?></span>&nbsp
				<span class="left_bor">&nbsp  Check Out Date : </span><span class="bold"><?php $check_out=date_create($view[0]->check_out);
				echo date_format($check_out,'d-M-Y') ?></span>
			</div>
			</br>
			<?php if(count($travellers)!=0) { ?>
			<div class="col-md-12">
				<div class="col-mds-12">
					<h4>Traveller Details</h4> 
						<table class="table table-striped table-dark">
							<thead>
								<tr>
									<td>Rooms</td>
									<td>Name</td>
									<td>Age</td>
								</tr>
							</thead>
							<tbody>	
								<?php 
								for ($w=1; $w <=$view[0]->book_room_count; $w++) { 
									foreach($travellers as $value) {
										if($w==$value->roomindex) { ?>
										<tr>
											<td>Room <?php echo $w ?></td>
											<td><?php echo $value->title." ".$value->firstname." ".$value->lastname; ?></td>
											<td><?php echo $value->age ?></td>								
										</tr>
									<?php }
									} 
								} ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<?php } ?>
			<div class="line2"></div>
			<div class="col-md-12">
				<h4 class="dark bold">Booking Amount Breakup</h4>
				<?php 
				// print_r($ExBed);
				$revenueMarkup = explode(",", $view[0]->revenueMarkup);
				$revenueMarkupType = explode(",", $view[0]->revenueMarkupType);
				$revenueExtrabedMarkup = explode(",", $view[0]->revenueExtrabedMarkup);
				$revenueExtrabedMarkupType = explode(",", $view[0]->revenueExtrabedMarkupType);
				$revenueBoardMarkup = explode(",", $view[0]->revenueBoardMarkup);
				$revenueBoardMarkupType = explode(",", $view[0]->revenueBoardMarkupType);
				$revenueGeneralMarkupType = explode(",", $view[0]->revenueGeneralMarkupType);
				$revenueGeneralMarkup = explode(",", $view[0]->revenueGeneralMarkup);

				$book_room_count = $view[0]->book_room_count;
				$individual_amount = explode(",", $view[0]->individual_amount);
				$individual_discount = explode(",", $view[0]->individual_discount);
				$checkin_date=date_create($view[0]->check_in);
				$checkout_date=date_create($view[0]->check_out);
				$no_of_days=date_diff($checkin_date,$check_out);
				$tot_days = $no_of_days->format("%a");

				$roomExp = explode(",", $view[0]->room_id);
		        $ExtrabedDiscount = explode(",", $view[0]->ExtrabedDiscount);
		        $GeneralDiscount = explode(",", $view[0]->GeneralDiscount);
		        $BoardDiscount = explode(",", $view[0]->BoardDiscount);
		        $RequestType = explode(",", $view[0]->RequestType);

		        $boardName = explode(",", $view[0]->boardName);
				$contract_id = explode(",", $view[0]->contract_id);
				$admin_markup = explode(",", $view[0]->admin_markup);
				for ($i=1; $i <= $book_room_count; $i++) {
					if (isset($admin_markup[$i-1])) {
			          $total_markup = $view[0]->agent_markup+$admin_markup[$i-1]+$view[0]->search_markup;
			        } else {
			          $total_markup = $view[0]->agent_markup+$admin_markup[0]+$view[0]->search_markup;
			        }
					if(isset($amenddata)&&$amenddata!="") { 
						foreach ($amenddata as $key => $value) {
							if ( $value->status==1) {
				        		$varIndividual = 'Room'.$i.'individual_amount';
								$amendmentarr[$i-1][$key] = explode(",",$value->$varIndividual);
							}
						}
				    }
					if (!isset($ExtrabedDiscount[$i-1])) {
						$ExtrabedDiscount[$i-1] = 0;
					}
					if (!isset($GeneralDiscount[$i-1])) {
						$GeneralDiscount[$i-1] = 0;
					}
					if (!isset($BoardDiscount[$i-1])) {
						$BoardDiscount[$i-1] = 0;
					}
					if (!isset($roomExp[$i-1])) {
						$room_id = $roomExp[0];
					} else {
						$room_id = $roomExp[$i-1];
					}

					$Fdays = 0;
			      	$discountType = "";
			      	$DisTypExplode = explode(",", $view[0]->discountType);
			      	$DisStayExplode = explode(",", $view[0]->discountStay);
			      	$DisPayExplode = explode(",", $view[0]->discountPay);
			      	$discountCode = explode(",", $view[0]->discountCode);
			      	if (!isset($DisTypExplode[$i])) {
			      		$DisTypExplode[$i] = $DisTypExplode[0];
			      	}
			      	if (!isset($DisStayExplode[$i])) {
			      		$DisStayExplode[$i] = $DisStayExplode[0];
			      	}
			      	if (!isset($DisTypExplode[$i])) {
			      		$DisPayExplode[$i] = $DisPayExplode[0];
			      	}
			      	if (!isset($discountCode[$i])) {
			      		$discountCode[$i] = $discountCode[0];
			      	}

			        if (isset($DisTypExplode[$i-1]) && $DisTypExplode[$i-1]=="stay&pay") {
			          $Cdays = $tot_days/$DisStayExplode[$i-1];
			          $parts = explode('.', $Cdays);
			          $Cdays = $parts[0];
			          $Sdays = $DisStayExplode[$i-1]*$Cdays;
			          $Pdays = $DisPayExplode[$i-1]*$Cdays;
			          $Tdays = $tot_days-$Sdays;
			          $Fdays = $Pdays+$Tdays;
			          $discountType = $DisTypExplode[$i-1];
			        }
			        // if ($DisTypExplode[$i-1]=="" && $view[0]->discountCode!="") {
			        //   $discountType = 'Discount';
			        // }

					$varIndividual = 'Room'.$i.'individual_amount';
					if($view[0]->$varIndividual!="") {
						$individual_amount = explode(",", $view[0]->$varIndividual);
					}

					$varIndividualDis = 'Room'.$i.'Discount';
					if($view[0]->$varIndividual!="") {
						$individual_discount = explode(",", $view[0]->$varIndividualDis);
					}

					$RoomName = roomnameGET($room_id,$view[0]->hotel_id);
					if (!isset($boardName[$i-1])) {
						$boardName[$i-1] = $boardName[0];
					}


					$varRoomrevenueMarkup = 'Room'.$i.'revenueMarkup';
					$varRoomrevenueMarkupType = 'Room'.$i.'revenueMarkupType';
					if ($view[0]->$varRoomrevenueMarkup!="") {
						$$varRoomrevenueMarkup = explode(",", $view[0]->$varRoomrevenueMarkup);
						$$varRoomrevenueMarkupType = explode(",", $view[0]->$varRoomrevenueMarkupType);
				 	}
				 	
				 	$varRoomrevenueExtrabedMarkup = 'Room'.$i.'revenueExtrabedMarkup';
					$varRoomrevenueExtrabedMarkupType = 'Room'.$i.'revenueExtrabedMarkupType';
					if ($view[0]->$varRoomrevenueExtrabedMarkup!="") {
						$$varRoomrevenueExtrabedMarkup = explode(",", $view[0]->$varRoomrevenueExtrabedMarkup);
						$$varRoomrevenueExtrabedMarkupType = explode(",", $view[0]->$varRoomrevenueExtrabedMarkupType);
				 	}

				 	$varRoomrevenueBoardMarkup = 'Room'.$i.'revenueBoardMarkup';
					$varRoomrevenueBoardMarkupType = 'Room'.$i.'revenueBoardMarkupType';
					if ($view[0]->$varRoomrevenueBoardMarkup!="") {
						$$varRoomrevenueBoardMarkup = explode(",", $view[0]->$varRoomrevenueBoardMarkup);
						$$varRoomrevenueBoardMarkupType = explode(",", $view[0]->$varRoomrevenueBoardMarkupType);
				 	}

				 	$varRoomrevenueGeneralMarkup = 'Room'.$i.'revenueGeneralMarkup';
					$varRoomrevenueGeneralMarkupType = 'Room'.$i.'revenueGeneralMarkupType';
					if ($view[0]->$varRoomrevenueGeneralMarkup!="") {
						$$varRoomrevenueGeneralMarkup = explode(",", $view[0]->$varRoomrevenueGeneralMarkup);
						$$varRoomrevenueGeneralMarkupType = explode(",", $view[0]->$varRoomrevenueBoardMarkupType);
				 	}
				?>
				<div class="row payment-table-wrap">
            		<div class="col-md-12">
            			<h4 class="room-name">Room <?php echo $i; ?></h4>
            			<span class="pull-right">
            			<!-- 	<?php if (isset($DisTypExplode[$i-1]) && $DisTypExplode[$i-1]!="" && $DisTypExplode[$i-1]!="stay&pay") { ?>
            					<small class="text-right red stay-pay-tag"><?php echo $discountCode[$i-1] ?> - <?php echo $DisTypExplode[$i-1] ?></small>
            				<?php } ?> -->	

            				<?php 
            					if (isset($DisTypExplode[$i-1]) && $DisTypExplode[$i-1]=="stay&pay") { ?>
            					<small class="text-right red stay-pay-tag"><?php echo $discountCode[$i-1] ?> - Stay <?php echo $DisStayExplode[$i-1] ?> nights &amp; Pay <?php echo $DisPayExplode[$i-1] ?> nights</small>
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
            					<?php 
            					$oneNight = array();
            					for ($j=0; $j < $tot_days ; $j++) { 
	        						if (!isset($individual_discount[$j])) {
										$individual_discount[$j] = 0;
									}
									$ExAmount[$j] = 0;
									$TExAmount[$j] = 0;
									$GAamount[$j] = 0;
									$GCamount[$j] = 0;
									$BAamount[$j] = 0;
									$BCamount[$j] = 0;
									$TBAamount[$j] = 0;
									$TBCamount[$j] = 0;


									if (isset($$varRoomrevenueMarkup[$j])) {
    									$revenueMarkup[$i-1] = $$varRoomrevenueMarkup[$j];
    									$revenueMarkupType[$i-1] = $$varRoomrevenueMarkupType[$j];
    								}

    								if (isset($$varRoomrevenueExtrabedMarkup[$j])) {
    									$revenueExtrabedMarkup[$i-1] = $$varRoomrevenueExtrabedMarkup[$j];
    									$revenueExtrabedMarkupType[$i-1] = $$varRoomrevenueExtrabedMarkupType[$j];
    								}

    								if (isset($$varRoomrevenueBoardMarkup[$j])) {
    									$revenueBoardMarkup[$i-1] = $$varRoomrevenueBoardMarkup[$j];
    									$revenueBoardMarkupType[$i-1] = $$varRoomrevenueBoardMarkupType[$j];
    								}

    								if (isset($$varRoomrevenueGeneralMarkup[$j])) {
    									$revenueGeneralMarkup[$i-1] = $$varRoomrevenueGeneralMarkup[$j];
    									$revenueGeneralMarkupType[$i-1] = $$varRoomrevenueGeneralMarkupType[$j];
    								}
        						?>
            					<tr>
	            					<td><?php echo date('d/m/Y', strtotime($view[0]->check_in. ' + '.$j.'  days')); ?></td>
	            					<td><?php echo $RoomName ?></td>
	            					<td style="text-align: center"><?php echo $boardName[$i-1]; ?></td>
	            					<td style="text-align: right">
            							<p class="new-price">

            								<?php 
            								$amendmentarrTot = array();
            								if(isset($amendmentarr[$i-1])) {
	            								foreach ($amendmentarr[$i-1] as $key => $value) {
	        										$amendmentarrTot[$key] = $value[$j]; 
	        									}
	        									$individual_amount1[$j] = array_sum($amendmentarrTot)+$individual_amount[$j];
	        								} else {
	        									$individual_amount1[$j] = $individual_amount[$j];
	        								}
            								$rmAmount = 0;
            								if ($revenueMarkup[$i-1]!="" && $revenueMarkup[$i-1]!=0) {
            									if ($revenueMarkupType[$i-1]=='Percentage') {
            										$rmAmount = ($individual_amount1[$j]*$revenueMarkup[$i-1])/100;
            									} else {
            										$rmAmount = $revenueMarkup[$i-1];
            									}
            								}
        									$roomAmount[$j] = (($individual_amount1[$j]*$total_markup)/100)+$individual_amount1[$j]+$rmAmount;

        									$DisroomAmount[$j] = $roomAmount[$j]-($roomAmount[$j]*$individual_discount[$j])/100;
            								$WiDisroomAmount[$j] = $roomAmount[$j];
            								if ($individual_discount[$j]!=0) { ?>
		            						<small class="old-price text-danger"><?php 
		            						echo currency_type(agent_currency(),$roomAmount[$j]) ?> <?php echo agent_currency() ?></small>
		            						<br>
		            						<?php }
		            						if ($j==0) {
			            						$oneNight[] = $DisroomAmount[0];
			            					}
            								echo currency_type(agent_currency(),$DisroomAmount[$j]); ?> <?php echo agent_currency() ?></p>
	            					</td>
            					</tr>
            					<!-- Extrabed list start -->
            					<?php if (count($ExBed)!=0) {
            						foreach ($ExBed as $Exkey => $Exvalue) {
            							if ($Exvalue->date==date('Y-m-d', strtotime($view[0]->check_in. ' + '.$j.'  days'))) {
            								$exroomExplode = explode(",", $Exvalue->rooms);
            								$examountExplode = explode(",", $Exvalue->Exrwamount);
            								$exTypeExplode = explode(",", $Exvalue->Type);
            								foreach ($exroomExplode as $Exrkey => $EXRvalue) {
            									if ($EXRvalue==$i) {
            					 ?>
		            					 <tr>
		            					 	<td></td>
		            					 	<td><?php echo $exTypeExplode[$Exrkey] ?></td>
		            					 	<td class="text-center">-</td>
		            					 	<td class="text-right"><?php 
		            					 	$ExMAmount = 0;
						                      if (isset($revenueMarkup[$i-1])) {
						                        if ($revenueMarkup[$i-1]!="") {
						                          if ($exTypeExplode[$Exrkey]=="Adult Extrabed" || $exTypeExplode[$Exrkey]=="Child Extrabed") {
						                            if ($revenueExtrabedMarkupType[$i-1]=='Percentage') {
						                              $ExMAmount = ($examountExplode[$Exrkey]*$revenueExtrabedMarkup[$i-1])/100;
						                            } else {
						                              $ExMAmount = $revenueExtrabedMarkup[$i-1];
						                            }
						                          } else {
						                            if ($revenueBoardMarkupType[$i-1]=='Percentage') {
						                              $ExMAmount = ($examountExplode[$Exrkey]*$revenueBoardMarkup[$i-1])/100;
						                            } else {
						                              $ExMAmount = $revenueBoardMarkup[$i-1];
						                            }
						                          }
						                        }
						                      } else {
						                        if ($revenueMarkup[0]!="") {
						                          if ($exTypeExplode[$Exrkey]=="Adult Extrabed" || $exTypeExplode[$Exrkey]=="Child Extrabed") {
						                            if ($revenueExtrabedMarkupType[0]=='Percentage') {
						                              $ExMAmount = ($examountExplode[$Exrkey]*$revenueExtrabedMarkup[0])/100;
						                            } else {
						                              $ExMAmount = $revenueExtrabedMarkup[0];
						                            }
						                          } else {
						                            if ($revenueBoardMarkupType[0]=='Percentage') {
						                              $ExMAmount = ($examountExplode[$Exrkey]*$revenueBoardMarkup[0])/100;
						                            } else {
						                              $ExMAmount = $revenueBoardMarkup[0];
						                            }
						                          }
						                        }
						                      }
            								$ExDis = 0;
            								if ($ExtrabedDiscount[$i-1]==1) {
            									$ExDis = $individual_discount[$j];
            								}

		            					 	$ExAmount[$j] = (($examountExplode[$Exrkey]*$total_markup)/100)+$examountExplode[$Exrkey]+$ExMAmount-(((($examountExplode[$Exrkey]*$total_markup)/100)+$examountExplode[$Exrkey]+$ExMAmount)*$ExDis/100);

		            					 	$TExAmount[$j] +=(($examountExplode[$Exrkey]*$total_markup)/100)+$examountExplode[$Exrkey]+$ExMAmount-(((($examountExplode[$Exrkey]*$total_markup)/100)+$examountExplode[$Exrkey]+$ExMAmount)*$ExDis/100);
		            					 	if ($ExDis!=0) { ?>
		            					 		<small class="old-price text-danger"><?php 
		            							echo currency_type(agent_currency(),(($examountExplode[$Exrkey]*$total_markup)/100)+$examountExplode[$Exrkey]+$ExMAmount) ?> <?php echo agent_currency() ?>
		            							</small>
			            						<br>
		            						<?php }
		            					 	if ($j==0) {
			            						$oneNight[] = $ExAmount[0];
			            					}
		            					 	echo currency_type(agent_currency(),$ExAmount[$j]); ?> <?php echo agent_currency() ?></td>
		            					 </tr>

            					<?php } } } } } ?>
            					<!-- Extrabed list end -->
            					<!-- Adult and room General supplement list start -->
            					<?php if (count($general)!=0) {
            						foreach ($general as $gskey => $gsvalue) {
            					 		if ($gsvalue->gstayDate==date('d/m/Y', strtotime($view[0]->check_in. ' + '.$j.'  days'))) {
            					 			$gsadultExplode = explode(",", $gsvalue->Rwadult);
            					 			$gsadultAmountExplode = explode(",", $gsvalue->Rwadultamount);
            					 			foreach ($gsadultExplode as $gsakey => $gsavalue) {
            					 				if ($gsavalue==$i) {
            					 ?>
		            					 <tr>
		            					 	<td></td>
		            					 	<td><?php echo $gsvalue->application=="Per Room" ? $gsvalue->generalType : 'Adults '.$gsvalue->generalType ; ?></td>
		            					 	<td class="text-center">-</td>
		            					 	<td class="text-right"><?php 
		            					 		$GSMAmount = 0;
												if (isset($revenueMarkup[$i-1])) {
													if ($revenueGeneralMarkup[$i-1]!="") {
													  if ($revenueGeneralMarkupType[$i-1]=='Percentage') {
													    $GSMAmount = ($gsadultAmountExplode[$gsakey]*$revenueGeneralMarkup[$i-1])/100;
													  } else {
													    $GSMAmount = $revenueGeneralMarkup[$i-1];
													  }
													}
												} else {
													if ($revenueGeneralMarkup[0]!="") {
													  if ($revenueGeneralMarkupType[0]=='Percentage') {
													    $GSMAmount = ($gsadultAmountExplode[$gsakey]*$revenueGeneralMarkup[0])/100;
													  } else {
													    $GSMAmount = $revenueGeneralMarkup[0];
													  }
													}
												}
	            								$GSDis = 0;
	            								if ($GeneralDiscount[$i-1]==1) {
	            									$GSDis = $individual_discount[$j];
	            								}
		            					 		$GAamount[$j] = (($gsadultAmountExplode[$gsakey]*$total_markup)/100)+$gsadultAmountExplode[$gsakey]+$GSMAmount-(((($gsadultAmountExplode[$gsakey]*$total_markup)/100)+$gsadultAmountExplode[$gsakey]+$GSMAmount)*$GSDis/100);
		            					 		if ($GSDis!=0) { ?>
				            						<small class="old-price text-danger"><?php 
		            							echo currency_type(agent_currency(),(($gsadultAmountExplode[$gsakey]*$total_markup)/100)+$gsadultAmountExplode[$gsakey]+$GSMAmount) ?> <?php echo agent_currency() ?>
		            								</small>
	            								<?php }
	            					 			if ($j==0) {
				            						$oneNight[] = $GAamount[0];
				            					}
		            					 	echo currency_type(agent_currency(),$GAamount[$j]); ?> <?php echo agent_currency() ?></td>
		            					 </tr>
            					<?php } } ?> 
            					<!-- Adult and room General supplement list end -->
            					<!-- Adult General supplement list start -->

            					<?php
            						$gschildExplode = explode(",", $gsvalue->Rwchild);
    					 			$gschildAmountExplode = explode(",", $gsvalue->RwchildAmount);
            					 foreach ($gschildExplode as $gsckey => $gscvalue) {
            					 				if ($gscvalue==$i) { ?>
    					 				<tr>
		            					 	<td></td>
		            					 	<td><?php echo 'Child '.$gsvalue->generalType ; ?></td>
		            					 	<td class="text-center">-</td>
		            					 	<td class="text-right"><?php 
		            					 		$GSMAmount = 0;
							                      if (isset($revenueMarkup[$i-1])) {
							                        if ($revenueGeneralMarkup[$i-1]!="") {
							                          if ($revenueGeneralMarkupType[$i-1]=='Percentage') {
							                            $GSMAmount = ($gschildAmountExplode[$gsckey]*$revenueGeneralMarkup[$i-1])/100;
							                          } else {
							                            $GSMAmount = $revenueGeneralMarkup[$i-1];
							                          }
							                        }
							                      } else {
							                        if ($revenueGeneralMarkup[0]!="") {
							                          if ($revenueGeneralMarkupType[0]=='Percentage') {
							                            $GSMAmount = ($gschildAmountExplode[$gsckey]*$revenueGeneralMarkup[0])/100;
							                          } else {
							                            $GSMAmount = $revenueGeneralMarkup[0];
							                          }
							                        }
							                      }

		            					 		$GCamount[$j] = ((($gschildAmountExplode[$gsckey]*$total_markup)/100)+$gschildAmountExplode[$gsckey]+$GSMAmount)-((($gschildAmountExplode[$gsckey]*$total_markup)/100)+$gschildAmountExplode[$gsckey]+$GSMAmount)*$GSDis/100;
		            					 		if ($GSDis!=0) { ?>
				            						<small class="old-price text-danger"><?php 
		            							echo currency_type(agent_currency(),(($gschildAmountExplode[$gsckey]*$total_markup)/100)+$gschildAmountExplode[$gsckey]+$GSMAmount) ?> <?php echo agent_currency() ?>
		            								</small>
	            								<?php }
		            					 		if ($j==0) {
				            						$oneNight[] = $GCamount[0];
				            					}
		            					 	echo currency_type(agent_currency(),$GCamount[$j]); ?> <?php echo agent_currency() ?></td>
		            					 </tr>
            					<?php } } ?> 

            					<?php } } } ?>
            					<!-- Adult General supplement list end -->
            					<!-- Adults Board supplement list start -->
            					<?php foreach ($board as $bkey => $bvalue) { 
            						if ($bvalue->stayDate==date('d/m/Y', strtotime($view[0]->check_in. ' + '.$j.'  days'))) {
        								$ABReqwadultexplode = explode(",", $bvalue->Breqadults);
            							$ABRwadultexplode = explode(",", $bvalue->Rwadult);
            							$ABRwadultamountexplode = explode(",", $bvalue->RwadultAmount);
            							foreach ($ABRwadultexplode as $ABRwkey => $ABRwvalue) {
            								if ($ABRwvalue==$i) {
            						?>
            						<tr>
            							<td></td>
            							<td>Adult <?php echo $bvalue->board; ?></td>
            							<td class="text-center">-</td>
            							<td class="text-right"><?php 
            								$BSMAmount = 0;
							                  if (isset($revenueMarkup[$i-1])) {
							                    if ($revenueBoardMarkup[$i-1]!="") {
							                      if ($revenueBoardMarkupType[$i-1]=='Percentage') {
							                        $BSMAmount = ($ABRwadultamountexplode[$ABRwkey]*$revenueBoardMarkup[$i-1])/100;
							                      } else {
							                        $BSMAmount = $revenueBoardMarkup[$i-1]*$ABReqwadultexplode[$ABRwkey];
							                      }
							                    }
							                  } else {
							                    if ($revenueBoardMarkup[0]!="") {
							                      if ($revenueBoardMarkupType[0]=='Percentage') {
							                        $BSMAmount = ($ABRwadultamountexplode[$ABRwkey]*$revenueBoardMarkup[0])/100;
							                      } else {
							                        $BSMAmount = $revenueBoardMarkup[0]*$ABReqwadultexplode[$ABRwkey];
							                      }
							                    }
							                  }
            								$BSDis = 0;
            								if ($BoardDiscount[$i-1]==1) {
            									$BSDis = $individual_discount[$j];
            								}
            								$BAamount[$j] = ((($ABRwadultamountexplode[$ABRwkey]*$total_markup)/100)+$ABRwadultamountexplode[$ABRwkey]+$BSMAmount)-((($ABRwadultamountexplode[$ABRwkey]*$total_markup)/100)+$ABRwadultamountexplode[$ABRwkey]+$BSMAmount)*$BSDis/100;
            								$TBAamount[$j] += $BAamount[$j];
            								if ($BSDis!=0) { ?>
			            						<small class="old-price text-danger"><?php 
		            							echo currency_type(agent_currency(),((($ABRwadultamountexplode[$ABRwkey]*$total_markup)/100)+$ABRwadultamountexplode[$ABRwkey]+$BSMAmount)) ?> <?php echo agent_currency() ?></small>
			            						<br>
		            						<?php }
            								if ($j==0) {
			            						$oneNight[] = $BAamount[0];
			            					}
            							echo currency_type(agent_currency(),$BAamount[$j]); ?> <?php echo agent_currency() ?></td>
            						</tr>
            						
            					<?php } } ?>
            					<!-- Adults Board supplement list end -->
            					<!-- Child Board supplement list start -->
            					<?php 
            							$CBReqwchildexplode = explode(",", $bvalue->BreqchildCount);
            							$CBRwchildexplode = explode(",", $bvalue->Rwchild);
            							$CBRwchildamountexplode = explode(",", $bvalue->RwchildAmount);
            							foreach ($CBRwchildexplode as $CBRwkey => $CBRwvalue) {
            								if ($CBRwvalue==$i) {
            						?>
            						<tr>
            							<td></td>
            							<td>Child <?php echo $bvalue->board; ?></td>
            							<td class="text-center">-</td>
            							<td class="text-right"><?php 
            								$BSMAmount = 0;
							                  if (isset($revenueMarkup[$i-1])) {
							                    if ($revenueBoardMarkup[$i-1]!="") {
							                      if ($revenueBoardMarkupType[$i-1] == 'Percentage') {
							                        $BSMAmount = ($CBRwchildamountexplode[$CBRwkey]*$revenueBoardMarkup[$i-1])/100;
							                      } else {
							                        $BSMAmount = $revenueBoardMarkup[$i-1]*$CBReqwchildexplode[$CBRwkey];
							                      }
							                    }
							                  } else {
							                    if ($revenueBoardMarkup[0]!="") {
							                      if ($revenueBoardMarkupType[0] == 'Percentage') {
							                        $BSMAmount = ($CBRwchildamountexplode[$CBRwkey]*$revenueBoardMarkup[0])/100;
							                      } else {
							                        $BSMAmount = $revenueBoardMarkup[0]*$CBReqwchildexplode[$CBRwkey];
							                      }
							                    }
							                  }
            								$BSDis = 0;
            								if ($BoardDiscount[$i-1]==1) {
            									$BSDis = $individual_discount[$j];
            								}
            								$BCamount[$j] = ((($CBRwchildamountexplode[$CBRwkey]*$total_markup)/100)+$CBRwchildamountexplode[$CBRwkey]+$BSMAmount)-((($CBRwchildamountexplode[$CBRwkey]*$total_markup)/100)+$CBRwchildamountexplode[$CBRwkey]+$BSMAmount)*$BSDis/100;

            								$TBCamount[$j] += $BCamount[$j];
            								if ($BSDis!=0) { ?>
		            						<small class="old-price text-danger"><?php 
		            							echo currency_type(agent_currency(),((($CBRwchildamountexplode[$CBRwkey]*$total_markup)/100)+$CBRwchildamountexplode[$CBRwkey]+$BSMAmount)) ?> <?php echo agent_currency() ?>
		            						</small>
		            						<br>
	            						<?php }
            								if ($j==0) {
			            						$oneNight[] = $BCamount[0];
			            					}
            							echo currency_type(agent_currency(),$BCamount[$j]); ?> <?php echo agent_currency() ?></td>
            						</tr>
            						
            					<?php } }  ?>
            					<?php } } ?>
            					<!-- Child Board supplement list end -->
            					<?php } ?>
            				</tbody>
            				<tfoot>
            					<tr>
            						<?php 
            						$witotal[$i] = array_sum($WiDisroomAmount)+array_sum($TExAmount)+array_sum($GAamount)+array_sum($GCamount)+array_sum($TBAamount)+array_sum($TBCamount);

            						$total[$i] = array_sum($DisroomAmount)+array_sum($TExAmount)+array_sum($GAamount)+array_sum($GCamount)+array_sum($TBAamount)+array_sum($TBCamount); 

            						if (isset($DisTypExplode[$i-1]) && $DisTypExplode[$i-1]=="stay&pay" && $Fdays!=0) {
            							array_splice($DisroomAmount, 1,$Fdays);
            							if ($ExtrabedDiscount[$i-1]==1) {
            								array_splice($TExAmount,1,$Fdays);
            							}
            							if ($GeneralDiscount[$i-1]==1) {
            								array_splice($GAamount,1,$Fdays);
            								array_splice($GCamount,1,$Fdays);
            							}
            							if ($BoardDiscount[$i-1]==1) {
            								array_splice($TBAamount,1,$Fdays);
            								array_splice($TBCamount,1,$Fdays);
            							}
            						} 


            						$totRmAmt[$i] = array_sum($DisroomAmount)+array_sum($TExAmount)+array_sum($GAamount)+array_sum($GCamount)+array_sum($TBAamount)+array_sum($TBCamount); 
            						?>

            						<td colspan="3" style="text-align: right"><strong class="text-blue">Total</strong></td>
            						<td style="text-align: right; font-weight: 700; color: #0074b9">
            							<?php if (isset($DisTypExplode[$i-1]) && $DisTypExplode[$i-1]=="stay&pay") { ?>
	        								<small class="old-price text-danger" style="font-size: 11px;font-weight: 100;"><?php echo currency_type(agent_currency(),$total[$i]); ?> <?php echo agent_currency() ?></small><br>
	        							<?php } ?>
            							<?php echo currency_type(agent_currency(),$totRmAmt[$i])  ?> <?php echo agent_currency() ?></td>
            					</tr>
            				</tfoot>
            			</table>
            		<div>
            	</div>
            	<br>
            	<?php } ?>
			</div>
			<div class="col-md-12">
			    <div class="col-md-6">
				    <p>Tax</p>
			    </div>
			    <div class="col-md-6">
				    <p><?php echo $view[0]->tax ?>%</p>
			    </div>
			    <?php 
				$array_sumTotal = (array_sum($totRmAmt)*$view[0]->tax)/100+array_sum($totRmAmt);
				$wioarray_sumTotal = ceil((array_sum($witotal)*$view[0]->tax)/100+array_sum($witotal));
				?>
			    <div class="col-md-6 bold">
				    <p>GRAND TOTAL</p>
			    </div>
			    <div class="col-md-6 bold">
				    <p><?php 
				    $final_total = $array_sumTotal;

				    echo agent_currency() ?> <?php echo currency_type(agent_currency(),$final_total) ?></p>
			    </div>
				<!-- </div> -->
			</div>
		</div>
		</br>
		<?php if($view[0]->SpecialRequest!="") { ?>
			<div class="col-mds-12">
				<div class="card">
					<div class="card-header text-uppercase" style="padding: 10px; border: 1px solid #ccc; ">
						<h4 class="bold" style=" border-bottom:  1px solid #ccc;">Special Request</h4>
						<br>
						<p><?php echo $view[0]->SpecialRequest ?></p>
					</div>
				</div>
			</div>
		<?php } ?>
		<div class="row">
			<div class="col-md-12">
				<h4 class="bold">Important Remarks</h4>
				<div style ="whitespace:pre-wrap"><?php  echo isset($view[0]->Important_Remarks_Policies) ? $view[0]->Important_Remarks_Policies : '' ?></div>
			</div>
			<?php if(count($cancelation)!=0) {
			 ?>
			<div class="col-md-12">
				<h4 class="bold">Cancelation Policy</h4>
				<?php $roomExp = explode(",", $view[0]->room_id);
				foreach ($roomExp as $key => $value) { ?>
				<h5 class="room-name">Room <?php echo $key+1 ?> </h5>
				<table class="table table-bordered table-hover">
						<thead>
					      <tr style="background-color: #0074b9;color: white">
					        <th>Cancelled on or After</th>
					        <th>Cancelled on or Before</th>
					        <th>Cancellation Charge</th>
					      </tr>
					    </thead>
					    <tbody> 
					    	<?php foreach ($cancelation as $Canckey => $Cancvalue) { 
					    		if ($Cancvalue->roomIndex==($key+1) || $Cancvalue->roomIndex=="") {
					    		if ($Cancvalue->application=="NON REFUNDABLE") {  ?>
					    		<tr>
						    		<td><?php echo date('d/m/Y',strtotime($view[0]->Created_Date)) ?></td>
						    		<td><?php echo date('d/m/Y',strtotime($view[0]->check_in)) ?></td>
						    		<td><?php $charge = $final_total * ($Cancvalue->cancellationPercentage/100); 
						    		   echo agent_currency() ?> <?php echo currency_type(agent_currency(),$charge);
						    		?>
						    		(<?php echo $Cancvalue->application ?>)</td>
						    	</tr>
					    	<?php 	} else { ?>
						    	<tr>
						    		<td><?php 
						    		$lastAmt = array_sum($oneNight);
						    		if(date('Y-m-d' , strtotime('-'.($Cancvalue->daysFrom).' days', strtotime($view[0]->check_in))) < date('Y-m-d')) {
						    			echo date('d/m/Y');
						    		} else {
						    			echo date('d/m/Y' , strtotime('-'.($Cancvalue->daysFrom).' days', strtotime($view[0]->check_in)));
						    		}
						    		?></td>
						    		<td><?php echo date('d/m/Y' , strtotime('-'.$Cancvalue->daysTo.' days', strtotime($view[0]->check_in))) ?></td>
						    		<td><?php 
						    			if ($Cancvalue->application=="FIRST NIGHT") {
						    				$charge = $lastAmt*($Cancvalue->cancellationPercentage/100);
						    			} else {
						    				$charge = $final_total * ($Cancvalue->cancellationPercentage/100); 
						    			}
						    			
						    		   echo agent_currency() ?> <?php echo currency_type(agent_currency(),$charge);
						    		?>
						    		(<?php echo $Cancvalue->application ?>)</td>
						    	</tr>
							<?php } } } ?>
				    	</tbody>
				</table>
			<?php } ?>
			</div>
			<?php } ?>
			<div class="col-md-12">
				<h4 class="bold">Important Notes</h4>
				<div><?php  echo isset($view[0]->Important_Notes_Conditions) ? $view[0]->Important_Notes_Conditions : '' ?></div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<h4>progress : <?php if ($view[0]->booking_flag==0) { ?>
					<span class="red">Rejected</span>
				<?php } else if($view[0]->booking_flag==1) { ?><span class="green">Success</span><?php } else if($view[0]->booking_flag==2) { ?><span class="orange">Pending</span> <?php } else if($view[0]->booking_flag==8) {
					?><span class="orange">On Request</span>
				<?php } ?></h4>
			</div>
		</div>
	</div>
</div>
</div>
<?php init_front_head_footer(); ?> 


