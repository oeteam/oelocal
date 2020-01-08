<?php init_hotel_login_header(); ?>
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
<div class="row">
	<div class="col-md-6">
		<h3>Booking view</h3>
	</div>
	<div class="col-md-6">
		</br>
		<span ><a class="pull-right btn btn-primary mar-left-5" href="<?php echo  base_url(); ?>Dashboard/hotel_room_booking_details">back</a>
		<?php if( $view[0]->booking_flag ==2 || $view[0]->booking_flag ==8) { ?>
		<!-- <a class="pull-right btn btn-danger mar-left-5"  data-toggle="modal" data-target="#myModal" onclick="deletefun('.$r->bk_id.');"  href="#" > Reject </a> -->
		<a href="#" class="pull-right btn btn-success mar-left-5" data-toggle="modal" data-target="#booking_modal" onclick="hotelactionfun('.$r->id.',1,'.$r->hotel_id.','.$r->agent_id.');" class="sb2-2-1-edit delete">Accept</a> <?php } ?>
	</div>
</div>
<div class="clearfix"></div>
</br>
</br>
<?php $currency_type="AED"; ?>
	<input type="hidden" name="id" id="id" value="<?php echo $view[0]->bkid ?>">
	<input type="hidden" name="Hid" id="Hotelid" value="<?php echo $view[0]->hotel_id ?>">
	<input type="hidden" name="Aid" id="Agentid" value="<?php echo $view[0]->agent_id ?>">

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
	</div>
	</br>
	<div class="col-md-12">
	<div class="col-md-12">
	<div class="col-md-12 ">
		<div class="row">
			<div class="col-md-12">
				<h4 class="dark bold">Day Details</h4>
				<p>Total Nights : <?php echo $view[0]->no_of_days ?></p>
				<span>Check In Date : </span><span class="bold"><?php $check_in=date_create($view[0]->check_in);
				 echo date_format($check_in,'d-M-Y') ?></span>&nbsp
				<span class="left_bor">&nbsp  Check Out Date : </span><span class="bold"><?php $check_out=date_create($view[0]->check_out);
				echo date_format($check_out,'d-M-Y') ?></span>
			</div>
				</br>
		</div>
		</div>
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
	
		<div class="col-md-12">
				<h4 class="dark bold">Booking Amount Breakup</h4>
		</div>
		<div class="scol-md-12">
			<div class="col-md-12">
				<!-- <h4 class="opensans dark bold">Booking Amount Breakup</h4> -->
					<?php 
			        //$total_markup 	 = $view[0]->agent_markup+$view[0]->admin_markup+$view[0]->search_markup;
					$book_room_count = $view[0]->book_room_count;
					$individual_amount = explode(",", $view[0]->individual_amount);
					$individual_discount = explode(",", $view[0]->individual_discount);
					$checkin_date=date_create($view[0]->check_in);
					$checkout_date=date_create($view[0]->check_in);
					$no_of_days=date_diff($checkin_date,$check_out);
					$tot_days = $no_of_days->format("%a");

					$roomExp = explode(",", $view[0]->room_id);
			        $ExtrabedDiscount = explode(",", $view[0]->ExtrabedDiscount);
			        $GeneralDiscount = explode(",", $view[0]->GeneralDiscount);
			        $BoardDiscount = explode(",", $view[0]->BoardDiscount);
			        $RequestType = explode(",", $view[0]->RequestType);
		        	$boardName = explode(",", $view[0]->boardName);
			        
				for ($i=1; $i <= $book_room_count; $i++) { 
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
			      	if (!isset($RequestType[$i])) {
			      		$RequestType[$i] = $RequestType[0];
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
				?>
				<div class="row payment-table-wrap">
            		<div class="col-md-12">
            			<h4 class="room-name">Room <?php echo $i; ?> <small class="text-danger"><?php echo  isset($RequestType[$i]) && $RequestType[$i]=="On Request" ? ' - On Request' : '' ?></small></h4>
            			<?php if (isset($DisTypExplode[$i-1]) && $DisTypExplode[$i-1]=="stay&pay") { ?>
        					<span class="pull-right"><small class="text-right red stay-pay-tag"><?php echo $discountCode[$i-1] ?> - Stay <?php echo $DisStayExplode[$i-1] ?> nights &amp; Pay <?php echo $DisPayExplode[$i-1] ?> nights</small></span>
        				<?php } ?>
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
        							if (!isset($individual_discount[$j])!=0) {
    									$individual_discount[$j] = 0;
    								} 
									$ExAmount[$j] = 0;
									$GAamount[$j] = 0;
									$GCamount[$j] = 0;
									$BAamount[$j] = 0;
									$BCamount[$j] = 0;
									$TBAamount[$j] = 0;
									$TBCamount[$j] = 0;
            					?>
            					<tr>
	            					<td><?php echo date('d/m/Y', strtotime($view[0]->check_in. ' + '.$j.'  days')); ?></td>
	            					<td><?php echo $RoomName ?></td>
	            					<td style="text-align: center"><?php echo $boardName[$i-1]; ?></td>
	            					<td style="text-align: right">
            								<?php 
            								
        									$roomAmount[$j] = $individual_amount[$j];

        									$DisroomAmount[$j] = $roomAmount[$j]-($roomAmount[$j]*$individual_discount[$j])/100;

            								if ($individual_discount[$j]!=0) { ?>
		            						<small class="old-price text-danger"><?php 
		            						echo currency_type($currency_type,$roomAmount[$j]) ?> <?php echo $currency_type ?></small>
		            						<br>
		            						<?php }
		            						if ($j==0) {
			            						$oneNight[] = $DisroomAmount[0];
			            					}
			            					echo currency_type($currency_type,$DisroomAmount[$j]) ?> <?php echo $currency_type ?>
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
		            					 	$ExDis = 0;
            								if ($ExtrabedDiscount[$i-1]==1) {
            									$ExDis = $individual_discount[$j];
            								}
		            					 	$ExAmount[$j]+= $examountExplode[$Exrkey]-(($examountExplode[$Exrkey]*$ExDis)/100);
		            					 	if ($ExDis!=0) { ?>
		            						<small class="old-price text-danger"><?php 
		            						echo currency_type($currency_type,$examountExplode[$Exrkey]) ?> <?php echo $currency_type ?></small>
		            						<br>
		            						<?php }
		            					 	if ($j==0) {
			            						$oneNight[] = $ExAmount[0];
			            					}
		            					 	?> <?php 
		            						echo currency_type($currency_type,$examountExplode[$Exrkey]-(($examountExplode[$Exrkey]*$ExDis)/100)) ?> <?php echo $currency_type ?></td>
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
		            					 		$GSDis = 0;
	            								if ($GeneralDiscount[$i-1]==1) {
	            									$GSDis = $individual_discount[$j];
	            								}
		            					 		$GAamount[$j]= $gsadultAmountExplode[$gsakey]-($gsadultAmountExplode[$gsakey]*$GSDis)/100;
		            					 		if ($GSDis!=0) { ?>
			            						<small class="old-price text-danger"><?php 
			            						echo currency_type($currency_type,$gsadultAmountExplode[$gsakey]) ?> <?php echo $currency_type ?></small>
			            						<br>
			            						<?php }
		            					 		if ($j==0) {
				            						$oneNight[] = $GAamount[0];
				            					}
		            					 	 	?> 
		            					 	 	<?php 
			            						echo currency_type($currency_type,$GAamount[$j]) ?> <?php echo $currency_type ?>
			            					</td>
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
		            					 		$GSDis = 0;
	            								if ($GeneralDiscount[$i-1]==1) {
	            									$GSDis = $individual_discount[$j];
	            								}
		            					 		$GCamount[$j] = $gschildAmountExplode[$gsckey]-($gschildAmountExplode[$gsckey]*$GSDis/100);
		            					 		if ($GSDis!=0) { ?>
			            						<small class="old-price text-danger"><?php 
			            						echo currency_type($currency_type,$gschildAmountExplode[$gsckey]) ?> <?php echo $currency_type ?></small>
			            						<br>
			            						<?php }
		            					 		if ($j==0) {
				            						$oneNight[] = $GCamount[0];
				            					}
		            					 	 ?> <?php 
			            						echo currency_type($currency_type,$GCamount[$j]) ?> <?php echo $currency_type ?></td>
		            					 </tr>
            					<?php } } ?> 

            					<?php } } } ?>
            					<!-- Adult General supplement list end -->
            					<!-- Adults Board supplement list start -->
            					<?php foreach ($board as $bkey => $bvalue) { 
            						if ($bvalue->stayDate==date('d/m/Y', strtotime($view[0]->check_in. ' + '.$j.'  days'))) {
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
            								$BSDis = 0;
            								if ($BoardDiscount[$i-1]==1) {
            									$BSDis = $individual_discount[$j];
            								}
            								$BAamount[$j] = $ABRwadultamountexplode[$ABRwkey]-($ABRwadultamountexplode[$ABRwkey]*$BSDis/100);
            								$TBAamount[$j] += $BAamount[$j];
            								if ($BSDis!=0) { ?>
			            						<small class="old-price text-danger"><?php 
			            						echo currency_type($currency_type,$ABRwadultamountexplode[$ABRwkey]) ?> <?php echo $currency_type ?></small>
			            						<br>
		            						<?php }
            								if ($j==0) {
			            						$oneNight[] = $BAamount[0];
			            					}
            							 ?><?php 
			            						echo currency_type($currency_type,$BAamount[$j]) ?> <?php echo $currency_type ?>
			            					</td>
            						</tr>
            						
            					<?php } } ?>
            					<!-- Adults Board supplement list end -->
            					<!-- Child Board supplement list start -->
            					<?php 
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
            								$BSDis = 0;
            								if ($BoardDiscount[$i-1]==1) {
            									$BSDis = $individual_discount[$j];
            								}
            								$BCamount[$j] = $CBRwchildamountexplode[$CBRwkey]-($CBRwchildamountexplode[$CBRwkey]*$BSDis/100);
            								$TBCamount[$j] += $BCamount[$j];
            								if ($BSDis!=0) { ?>
			            						<small class="old-price text-danger"><?php 
			            						echo currency_type($currency_type,$CBRwchildamountexplode[$CBRwkey]) ?> <?php echo $currency_type ?></small>
			            						<br>
		            						<?php }
            								if ($j==0) {
			            						$oneNight[] = $BCamount[0];
			            					}
            							 ?><?php 
			            						echo currency_type($currency_type,$TBCamount[$j]) ?> <?php echo $currency_type ?></td>
            						</tr>
            						
            					<?php } }  ?>
            					<?php } } ?>
            					<!-- Child Board supplement list end -->
            					<?php } ?>
            				</tbody>
            				<tfoot>
            					<tr>
            						<?php 

            						$total[$i] = array_sum($DisroomAmount)+array_sum($ExAmount)+array_sum($GAamount)+array_sum($GCamount)+array_sum($TBAamount)+array_sum($TBCamount); 
            						if (isset($DisTypExplode[$i-1]) && $DisTypExplode[$i-1]=="stay&pay" && $Fdays!=0) {
            							array_splice($DisroomAmount, 1,$Fdays);
            							if ($ExtrabedDiscount[$i-1]==1) {
            								array_splice($ExAmount,1,$Fdays);
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
            						
            						$totalNotMar[$i] = array_sum($DisroomAmount)+array_sum($ExAmount)+array_sum($GAamount)+array_sum($GCamount)+array_sum($TBAamount)+array_sum($TBCamount); 

            						
            						?>
            						<?php  ?>
            						<td colspan="3" style="text-align: right"><strong class="text-blue">Total</strong></td>
            						<td style="text-align: right; font-weight: 700; color: #0074b9">
            							<?php if (isset($DisTypExplode[$i-1]) && $DisTypExplode[$i-1]=="stay&pay") { ?>
			            						<small class="old-price text-danger"><?php 
			            						echo currency_type($currency_type,$total[$i]) ?> <?php echo $currency_type ?></small>
			            						<br>
		            						<?php }
	            						echo currency_type($currency_type,$totalNotMar[$i]) ?> <?php echo $currency_type ?>	
	            					</td>
            					</tr>
            				</tfoot>
            			</table>
            		</div>
            	</div>
            	<?php } ?>
			</div>
		</div>
		<div class="col-md-12">
			    <?php 
				$array_sumTotal 	= (array_sum($totalNotMar)*$view[0]->tax)/100 + array_sum($totalNotMar);
				 ?>
			    <div class="col-md-6 bold" style="padding-left: 0;">
				    <p>GRAND TOTAL</p>
			    </div>
			    <div class="col-md-6 bold" style="padding-left: 0;">
				    <p><?php 
				    $final_total = $array_sumTotal;
				    echo currency_type($currency_type,$final_total);
				    echo " ";
				    echo $currency_type;?> 
				    </p>
			    </div>
		
		</br>
		<div class="row">
			<div class="col-md-12">
				<h4 class="bold">Important Remarks</h4>
				<div style ="whitespace:pre-wrap"><?php  echo isset($view[0]->Important_Remarks_Policies) ? $view[0]->Important_Remarks_Policies : '' ?></div>
			</div>
			<?php if(count($cancelation)!=0) {
			 ?>
			<div class="col-md-12">
				<h4 class="bold">Cancelation Policy</h4>
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
					    		if ($Cancvalue->application=="NON REFUNDABLE") {  ?>
					    		<tr>
						    		<td><?php echo date('d/m/Y',strtotime($view[0]->Created_Date)) ?></td>
						    		<td><?php echo date('d/m/Y',strtotime($view[0]->check_in)) ?></td>
						    		<td><?php $charge = $final_total * ($Cancvalue->cancellationPercentage/100); 
						    		   echo $currency_type ?> <?php echo currency_type($currency_type,ceil($charge));
						    		?> (<?php echo $Cancvalue->application ?>)</td>
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
						    		if ($Cancvalue->application=="FIRST NIGHT") {
					    				$charge = $lastAmt*($Cancvalue->cancellationPercentage/100);
					    			} else {
					    				$charge = $final_total * ($Cancvalue->cancellationPercentage/100); 
					    			} 
						    		?></td>
						    		<td><?php echo date('d/m/Y' , strtotime('-'.$Cancvalue->daysTo.' days', strtotime($view[0]->check_in))) ?></td>
						    		<td><?php echo $currency_type ?> <?php echo currency_type($currency_type,ceil($charge)); ?> (<?php echo $Cancvalue->application ?>)</td>
						    	</tr>
							<?php } } ?>
				    	</tbody>
				</table>
			</div>
			<?php } ?>
			<div class="col-md-12">
				<h4 class="bold">Important Notes</h4>
				<div><?php  echo isset($view[0]->Important_Notes_Conditions) ? $view[0]->Important_Notes_Conditions : '' ?></div>
			</div>
		</div>
		<?php if ($view[0]->SpecialRequest!="") { ?>
		<div clas="row">
			<div class="col-md-12" >
				<div class="card">
					<div class="card-header text-uppercase" style="padding: 5px; border: 1px solid #ccc; ">
						<h4 class="bold" style=" border-bottom: 1px solid #ccc;">Special Request</h4>
						<br>
						<p><?php echo $view[0]->SpecialRequest ?></p>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		<div class="row">
			<div class="col-md-12">
				<h4 class="dark bold">progress : <?php if ($view[0]->booking_flag==0) { ?>
					<span class="red">Rejected</span>
				<?php } else if($view[0]->booking_flag==1) { ?><span class="green">Success</span><?php } else if($view[0]->booking_flag==2) { ?><span class="orange">Pending</span> <?php } else if($view[0]->booking_flag==4) { ?><span class="orange">Accept Pending</span> <?php }  else if($view[0]->booking_flag==5) { ?><span class="orange">Cancellation Pending</span> <?php }  else if($view[0]->booking_flag==3) { ?><span class="orange">Cancelled</span> <?php } ?></h4>
			</div>
		</div>
	</div>

	
	</div>
	</div>
	<div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body" style="height: 100px;">
                    <p>Do you want cancel this booking?</p>
                    <input type="hidden" name="id" id="idz" value="<?php echo $view[0]->bkid ?>">
                    <input type="hidden" name="hotel_id" id="hotelz_id" value="<?php echo $view[0]->hotel_id ?>">
                    <input type="hidden" name="agent_id" id="agentz_id" value="<?php echo $view[0]->agent_id ?>">
                    <button type="button" id="reject_button" class="ml10 btn btn-danger pull-right">Yes</button>
                    <button type="button" data-dismiss="modal" id="reject_button" class="close_but btn btn-primary ml10 pull-right">No</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="booking_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body" style="height: 200px;">
      	            <form   action="" id="invoice_form" name="invoice_form" method="post">
      	            	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                        <div class="col-md-12 form-group">
                        	<p>Do you want Accept this booking?</p>
                        </div>
      	                <div class="col-md-6 form-group">
                          		<input type="hidden" class="form-control" id="booking_invoice_id" name="booking_invoice_id" placeholder="Invoice ID" readonly>
                              <input type="hidden" name="id" id="booking_id" value="<?php echo $view[0]->bkid ?>">
                          	  <input type="hidden" name="hotel_id" id="hotels_id" value="<?php echo $view[0]->hotel_id ?>">
                              <input type="hidden" name="agent_id" id="agents_id" value="<?php echo $view[0]->agent_id ?>">
                          		<input type="hidden" name="invoice_ck" id="invoice_ck" value="0">
                          		<span class="text-danger invoice_err"></span>
      	                </div>
      	                <div class="col-md-6 form-group">
                          		<input type="hidden" class="form-control" id="booking_invoice_date" name="booking_invoice_date" placeholder="Invoice date" readonly >
                          		<span class="text-danger invoice_date_err"></span>
      	                </div> 
                        <div class="col-md-6 form-group">
                              <input type="text" class="form-control" id="booking_confirmation" name="booking_confirmation" placeholder="Confirmation number">
                        </div>
                        <div class="col-md-6 form-group">
                              <input type="text" class="form-control" id="booking_confirmation_name" name="booking_confirmation_name" placeholder="Confirmation name">
                        </div>
                        <div class="col-md-12 form-group">
                    	        <button type="button" id="accept_button"  class="ml10 btn btn-danger pull-right">Yes</button>
                    	        <button type="button" data-dismiss="modal" id="accept_no_button" class="close_but btn btn-primary ml10 pull-right">No</button>
                        </div>
    	              </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade col-md-6 col-md-offset-3" id="booking_success_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <!-- Modal content-->
          </div>
    </div>

<?php init_hotel_login_footer(); ?>

