<?php init_head(); ?>
<script src="<?php echo base_url(); ?>assets/js/booking.js"></script>
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
<div class="sb2-2">
    <div class="sb2-2-3">
	    <div class="col-sm-12 col-xs-12">
		    <div class="card">
		        <div class="card-header text-uppercase" style="padding: 10px; border-bottom: 1px solid #ccc;"><h3>Hotel Details</h3>
		        </div>
		        <div class="card-block"  style="padding: 15px;">
		          	<div class="row m-b-1">
				        <div class="col-md-3 col-sm-3">
				            <div class="text-center mb-sm-0" style="background-color: #eaeaea">
				            	<?php  
				            		if (isset($view[0]->Image1)) { ?>
                                            <img src="<?php echo base_url(); ?>uploads/gallery/<?php echo $view[0]->hotel_id; ?>/<?php echo $view[0]->Image1;?>" width="70%"  >
                                            <?php  } else {  { ?>
                                            <img src="">
                                <?php  } }?>

				            </div>
				        </div>
				        <?php $currency="AED"; ?>
				        <div class="col-md-9 col-sm-9">
				            <div class="row">
					            <div class="col-sm-6">
					               <form class="form-horizontal" role="form">
			                            <div class="form-group">
			                                <label class="col-sm-6 col-md-6 col-lg-5" style="color: #000; font-size: 13px;">
			                                    <i class="fa fa-hotel" style="color: #4caf50;"></i>&nbsp;
			                                    	Hotel name :
			                                </label>
			                                <div class="col-sm-6 col-md-6 col-lg-7">
			                                	<label for=""><?php echo $view[0]->hotel_name ?>
			                                	
			                                	</label>
			                              	</div>
			                            </div>
			                            <div class="form-group">
			                                <label class="col-sm-6 col-md-6 col-lg-5" style="color: #000; font-size: 13px;">
			                                <i class="fa fa-map-marker" style="color: #4caf50;"></i>&nbsp;
			                                    	Location :
			                                </label>
			                                <div class="col-sm-6 col-md-6 col-lg-7">
			                                    <label for=""><?php echo $view[0]->location ?></label>
			                                </div>
			                            </div>
			                            <div class="form-group">
			                                <label class="col-sm-6 col-md-6 col-lg-5" style="color: #000; font-size: 13px;">
			                                <i class="fa fa-calendar" style="color: #4caf50;"></i>&nbsp;
			                                    	Joining Date :
			                                </label>
			                                <div class="col-sm-6 col-md-6 col-lg-7">
			                                    <label for=""><?php echo date('d/m/Y',strtotime($view[0]->Created_Date)) ?></label>
			                                </div>
			                            </div>
			                            <div class="form-group">
			                                <label class="col-sm-6 col-md-6 col-lg-5" style="color: #000; font-size: 13px;">
			                                    	<i class="fa fa-mobile" style="color: #4caf50;"></i>&nbsp;
			                                    	Phone No :
			                                </label>
			                                <div class="col-sm-6 col-md-6 col-lg-7">
			                                      <label for=""><?php echo $view[0]->sale_number ?></label>
			                                </div>
			                            </div>
			                        </form>
					            </div>
					            <div class="col-sm-6">
					                <form class="form-horizontal" role="form">
			                            <div class="form-group">
			                                <label class="col-sm-6 col-md-6 col-lg-5" style="color: #000; font-size: 13px;">
			                                <i class="fa fa-address-book-o" style="color: #4caf50;"></i>&nbsp;
			                                    	Address :  
			                                </label>
			                                <div class="col-sm-6 col-md-6 col-lg-7">
			                                     <label for=""><?php echo $view[0]->sale_address ?></label>
			                                </div>
			                            </div>
			                        </form>			              		
					            </div>
				            </div>
				        </div>
		            </div>
		        </div>
		    </div>
	  	</div>

		<div class="col-md-12 sleft_bor">
			<div class="row">
				<div class="col-md-6">
					<h4 class="dark bold">Agent Name : <?php echo $view[0]->AFName.' '.$view[0]->ALName ?></h4>
					<br>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<h4 class="dark bold">Booking Details</h4>
					<br>
				</div>
				<div class="col-md-6">
						</br>
						<span class="pull-right" >
						<?php 
						$Booking = menuPermissionAvailability($this->session->userdata('id'),'Booking','Hotel Booking'); 
            			if($Booking[0]->edit!=0) {
							if( $view[0]->booking_flag ==2 || $view[0]->booking_flag ==4 || $view[0]->booking_flag ==8) { ?>
							<a href="#" class="btn-sm btn-success  " data-toggle="modal" id="Ammendment_modal_btn" data-target="#Ammendment_modal"  class="sb2-2-1-edit delete">Ammendment</a> &nbsp
							<a href="#" class="btn-sm btn-success  " data-toggle="modal" data-target="#booking_modal"  class="sb2-2-1-edit delete">Accept</a> &nbsp<a class="btn-sm btn-danger "  data-toggle="modal" data-target="#myModal" onclick="deletefun('.$r->bk_id.');"  href="#" > Cancel </a> <?php } ?>
							<?php if( $view[0]->booking_flag ==1 ) { ?> 
							<a class="btn-sm btn-danger "  data-toggle="modal" data-target="#myModal"   href="#" > Cancel </a> <?php } ?>
							<?php if( $view[0]->booking_flag ==5) { ?>
							<a class="btn-sm btn-danger "  data-toggle="modal" data-target="#myModal" onclick="deletefun('.$r->bk_id.');"  href="#" >cancellation approved</a> <?php } 
						} ?>
						 &nbsp<a class="btn-sm btn-primary" href="<?php echo  base_url(); ?>backend/booking">back</a>
					</span>
				</div>
			</div>
			<input type="hidden" name="id" id="id" value="<?php echo $view[0]->bkid ?>">
			<input type="hidden" name="Hid" id="Hotelid" value="<?php echo $view[0]->hotel_id ?>">
			<input type="hidden" name="Aid" id="Agentid" value="<?php echo $view[0]->agent_id ?>">
		
				<!-- <div class="col-md-12">-->
			<div class="row">
				<div class="col-md-6"> 
					<span>Booking Id : <?php echo $view[0]->booking_id ?></span><br>
					<span>Booking date : <?php echo date('d/m/Y',strtotime($view[0]->booking_date)) ?></span>
					<br>
					<span>Nationality : <?php echo NationalityIduseGetName($view[0]->nationality) ?></span>
					<?php
					 if ($view[0]->boardName!="") { ?>
						<br><span>Board : <?php echo $view[0]->boardName ?></span>
					<?php } ?>
				</div>
			</div>
			
			</br>
			<div class="row">
				<div class="col-md-6">
								<h4 class="dark bold" >Adult(s) Details - <?php echo $view[0]->adults_count ?> adults</h4>
				</div>
				<div class="col-md-6">
					<h4 class="dark bold"> Childs(s) Details - <?php echo $view[0]->childs_count ?> childs</h4>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="scol-md-12">
					<div class="col-md-9" >
			            <h4 class="dark bold" >Contact Details</h4> <br>
						<table class="table-bordered">
							<thead  style="background-color: #F2F2F2;">
								<tr>
									<td>Rooms</td>
									<td>Name</td>
									<td>Email</td>
									<td>Contact number</td>
								</tr>
							</thead>
							<tbody>
								<?php 
								for ($w=1; $w <=$view[0]->book_room_count; $w++) { 
								$RoomFname = "Room".$w."-FName";
								$RoomLname = "Room".$w."-LName";

								 ?>
								<tr>
									<td>Room <?php echo $w ?></td>
									<?php if ($w==1) { ?>
										<td><?php echo $view[0]->bk_contact_fname." ".$view[0]->bk_contact_lname; ?></td>
										<td><?php echo $view[0]->bk_contact_email ?></td>
										<td><?php echo $view[0]->bk_contact_number ?></td>
									<?php } else { ?>
										<td><?php echo $view[0]->$RoomFname; ?> <?php echo isset($view[0]->$RoomLname) ? $view[0]->$RoomLname : '' ?></td>
										<td></td>
										<td></td>
									<?php } ?>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>

				</div>
			</div>
			<br>
			
			<div class="row">
				<div class="scol-md-12">
					<div class="col-md-9">
								<h4 class="dark bold" >Day Details</h4> 
								<br>
								<p>Total Days : <?php echo $view[0]->no_of_days ?></p>
								<p>No of rooms : <?php echo $view[0]->book_room_count ?></p>
								<span>Check In Date : </span><span class="bold"><?php $check_in=date_create($view[0]->check_in);
				 				echo date_format($check_in,'d-M-Y') ?></span>&nbsp
								<span class="left_bor">&nbsp  Check Out Date : </span><span class="bold"><?php $check_out=date_create($view[0]->check_out);
								echo date_format($check_out,'d-M-Y') ?></span>
					</div>
				</div>
			</div>
			<?php if(isset($amendments) && count($amendments)!="") { ?>
				<br>
			<div class="row">
				<div class="scol-md-12">
					<div class="col-md-9">
					<a class="btn-sm btn-info" id="listamendment" style="cursor:pointer;">Amendment List</a><br><br>
					<table class="table table-bordered hide" id="amendmentTable">
						<thead>
							<tr>
								<td>Name</td>
								<td>Created Date</td>
								<td>Total Amount</td>
								<td>Action</td>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($amendments as $key => $value) { 
							$totalamt = array_sum(explode(",",$value->Room1individual_amount))+array_sum(explode(",",$value->Room2individual_amount))+array_sum(explode(",",$value->Room3individual_amount))+array_sum(explode(",",$value->Room4individual_amount))+array_sum(explode(",",$value->Room5individual_amount))+array_sum(explode(",",$value->Room5individual_amount));
							?>
							<tr>
								<td>Amendment <?php echo $key+1; ?></td>
								<td><?php echo date('d/m/Y', strtotime($value->Created_Date)) ?></td>
								<td><?php echo $totalamt ?></td>
								<td><?php if($value->status==0) { ?> <a href="#" class="btn-sm btn-warning" onclick="amendacceptfun(<?php echo $value->id ?>);" class="sb2-2-1-edit delete"><i class="fa fa-check" aria-hidden="true"></i></a> <?php } ?><a title="Reject" href="#" class="btn-sm btn-danger" onclick="deleteamendmentfun(<?php echo $value->id ?>);" data-toggle="modal" data-target="#myModal" class="sb2-2-1-edit delete"><i class="fa fa-remove" aria-hidden="true"></i></a> <a href="#" class="btn-sm btn-success  " data-toggle="modal" id="Ammendment_modal_view_btn" data-id="<?php echo $value->id ?>" data-target="#Ammendment_modal"  class="sb2-2-1-edit delete" onclick="amendmentView(<?php echo $value->id ?>)"><i class="fa fa-eye" aria-hidden="true"></i></a></td> 
							</tr>
						<?php } ?>
						</tbody>			
				    </table>
				</div>
				</div>
			</div>

		    <?php } ?>
			</br>
			<?php 
			$net_adult_amount = 0;
			$net_child_amount = 0;
			?>
    		<div class="">
      			<div class="card">
  					<?php 
						$net_general_adult = 0;
						$net_general_child = 0;
						$net_Ex_amount  = 0;
					?>
                	<div class="card-header text-uppercase" style="padding: 10px; border-bottom: 1px solid #ccc;">
						<div class="card-header text-uppercase" style="padding: 10px; border-bottom: 1px solid #ccc; ">
    						<h3>Booking Amount Breakup - <?php echo $view[0]->contract_id ?>
    						<span class="pull-right" style="font-size: 18px; text-transform: capitalize;">progress : <?php if ($view[0]->booking_flag==0) { ?>
							<span class="text-danger">Rejected</span>
							<?php } else if($view[0]->booking_flag==1) { ?><span class="text-success">Success</span><?php } else if($view[0]->booking_flag==2) { ?><span class="label label-warning">Pending</span> <?php } else if($view[0]->booking_flag==3) { ?><span class="text-danger">Cancelled</span> <?php } else if($view[0]->booking_flag==4) { ?><span class="text-danger">Accepted Pending</span> <?php } else if($view[0]->booking_flag==5) { ?><span class="text-danger">Cancellation Pending</span> <?php } else if($view[0]->booking_flag==8) { ?><span class="label label-warning">ON Request</span><?php } ?></span>
							</h3>
        				</div>
        				<div class="card-header text-uppercase" style="padding: 10px; border-bottom: 1px solid #ccc; ">
							<?php 
					        $total_markup = $view[0]->agent_markup+$view[0]->admin_markup+$view[0]->search_markup;
							$book_room_count = $view[0]->book_room_count;
							$individual_amount = explode(",", $view[0]->individual_amount);
							if ($view[0]->individual_discount!="") {
								$individual_discount = explode(",", $view[0]->individual_discount);
							}
							$checkin_date=date_create($view[0]->check_in);
							$checkout_date=date_create($view[0]->check_out);
							$no_of_days=date_diff($checkin_date,$check_out);
							$tot_days = $no_of_days->format("%a");

					        $roomExp = explode(",", $view[0]->room_id);
					        $ExtrabedDiscount = explode(",", $view[0]->ExtrabedDiscount);
					        $GeneralDiscount = explode(",", $view[0]->GeneralDiscount);
					        $BoardDiscount = explode(",", $view[0]->BoardDiscount);
					        $RequestType = explode(",", $view[0]->RequestType);

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
							 ?>
							<div class="row payment-table-wrap">
			            		<div class="col-md-12">
			            			<h4 class="room-name">Room <?php echo $i; ?>  <small style="text-transform: none;font-weight: bolder;"><?php echo isset($RequestType[$i-1]) ? ' - '.$RequestType[$i-1] : '' ?></small></h4>
			            			<span class="pull-right">
			            				<?php if (isset($DisTypExplode[$i-1]) && $DisTypExplode[$i-1]!="" && $DisTypExplode[$i-1]!="stay&pay") { ?>
			            					<small class="text-right red stay-pay-tag"><?php echo $discountCode[$i-1] ?> - <?php echo $DisTypExplode[$i-1] ?></small>
			            				<?php } ?>

			            				<?php if (isset($DisTypExplode[$i-1]) && $DisTypExplode[$i-1]=="stay&pay") { ?>
			            					<small class="text-right red stay-pay-tag"><?php echo $discountCode[$i-1] ?> - Stay <?php echo $DisStayExplode[$i-1] ?> nights &amp; Pay <?php echo $DisPayExplode[$i-1] ?> nights</small>
			            				<?php } ?>
			            			</span>
			            			<br>
			            			<table class="table-bordered" >
			            				<thead style="background-color: #F2F2F2;">
			            					<tr>
			            						<th style="width: 85px;">Date</th>
				            					<th style="width: calc(100% - 265px);">Room Type</th>
				            					<th style="width: 60px; text-align: center">Board</th>
				            					<th style="width: 60px; text-align: center">Cost Rate</th>
				            					<th style="width: 120px; text-align: right">Selling Rate</th>
			            					</tr>
			            				</thead>
			            				<tbody>
			            					<?php 
			            					$oneNight = array();
			            					$oneNight1 = array();
			            					for ($j=0; $j < $tot_days ; $j++) { 
		            							if (!isset($individual_discount[$j])) {
	        										$individual_discount[$j] = 0;
	        									}

												$ExAmount[$j] = 0;
												$TExAmount[$j] = 0;
												$GAamount[$j] = 0;
												$GCamount[$j] = 0;
												$BAamount[$j] = 0;
												$TBAamount[$j] = 0;
												$BCamount[$j] = 0;
												$TBCamount[$j] = 0;
												
												$EAmoNotMar[$j]=0;
												$GAmoNotMar[$j]=0;
												$BAAmoNotMar[$j]=0;
												$GCAmoNotMar[$j]=0;
												$BCAmoNotMar[$j]=0;
												$totalNotMar[$j]=0;
												$TBAAmoNotMar[$j]=0;
												$TBCAmoNotMar[$j]=0;
												$RAmoADMar[$j]=0;
												$EAmoADMar[$j]=0;
												$GAmoADMar[$j]=0;
												$GCAmoADMar[$j]=0;
												$BAAmoADMar[$j]=0;
												$BCAmoAdMar[$j]=0;

												$CPRMRate[$j]=0;
												$CPEAmoAD[$j]=0;
												$CPGAmoAD[$j]=0;
												$CPAmoAD[$j]=0;
												$CPBAAmoAD[$j]=0;
												$CPBCAmoAd[$j]=0;

		            						?>
		            						<tr>
			            					<td><?php echo date('d/m/Y', strtotime($view[0]->check_in. ' + '.$j.'  days')); ?></td>
			            					<td><?php echo $RoomName ?></td>
			            					<td style="text-align: center"><?php echo $view[0]->boardName; ?></td>
			            					<td style="text-align: right">
	            								<p class="new-price">
		            								<?php 
		            								$rmAmount = 0;
		            								if ($view[0]->revenueMarkup!="" && $view[0]->revenueMarkup!=0) {
		            									if ($view[0]->revenueMarkupType=='Percentage') {
		            										$rmAmount = ($individual_amount[$j]*$view[0]->revenueMarkup)/100;
		            									} else {
		            										$rmAmount = $view[0]->revenueMarkup;
		            									}
		            								}
		        									$RAmoADMar[$j] = $individual_amount[$j]*($total_markup/100)+$rmAmount;
		            								$CPRMRate[$j] = $individual_amount[$j]-($individual_amount[$j]*$individual_discount[$j])/100;
		            								$RAmoADMar[$j] = $RAmoADMar[$j]-($RAmoADMar[$j]*$individual_discount[$j])/100;

		            								if ($j==0) {
					            						$oneNight1[] = $CPRMRate[0];
					            					}
		        									echo number_format(backend_currency_type($CPRMRate[$j]),2),admin_currency();
		            								 ?> 	
	            								</p>
			            					</td>
			            					<td style="text-align: right">
		            								<p class="new-price">
		            								<?php 

		        									$roomAmount[$j] = (($individual_amount[$j]*$total_markup)/100)+$individual_amount[$j]+$rmAmount;
		        									$RAmoNotMar[$j] = $individual_amount[$j];

		        									$DisroomAmount[$j] = $roomAmount[$j]-($roomAmount[$j]*$individual_discount[$j])/100;
            										$WiDisroomAmount[$j] = $roomAmount[$j];

            										if ($individual_discount[$j]!=0) { ?>
					            						<small class="old-price text-danger"><?php 

					            						echo number_format(backend_currency_type($roomAmount[$j]),2),admin_currency();
					            						 ?></small>
					            						<br>
					            						<?php }
					            						if ($j==0) {
						            						$oneNight[] = $DisroomAmount[0];
						            					}
		        									echo number_format(backend_currency_type($DisroomAmount[$j]),2),admin_currency(); 
		            								 ?> 
		            								</p>
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
			            					 	<td class="text-center">
		            								<?php 
		            								$ExMAmount = 0;
		            								if ($view[0]->revenueMarkup!="") {
		            									if ($exTypeExplode[$Exrkey]=="Adult Extrabed" || $exTypeExplode[$Exrkey]=="Child Extrabed") {
			            									if ($view[0]->revenueExtrabedMarkupType=='Percentage') {
			            										$ExMAmount = ($examountExplode[$Exrkey]*$view[0]->revenueExtrabedMarkup)/100;
			            									} else {
			            										$ExMAmount = $view[0]->revenueExtrabedMarkup;
			            									}
		            									} else {
		            										if ($view[0]->revenueBoardMarkupType=='Percentage') {
			            										$ExMAmount = ($examountExplode[$Exrkey]*$view[0]->revenueBoardMarkup)/100;
			            									} else {
			            										$ExMAmount = $view[0]->revenueBoardMarkup;
			            									}
		            									}
		            								}
		            								$ExDis = 0;
		            								if ($ExtrabedDiscount[$i-1]==1) {
		            									$ExDis = $individual_discount[$j];
		            								}
		            								$CPEAmoAD[$j] = $examountExplode[$Exrkey]-(($examountExplode[$Exrkey]*$ExDis)/100);
		        									$EAmoADMar[$j] = ($examountExplode[$Exrkey]*($total_markup/100)+$ExMAmount)-($examountExplode[$Exrkey]*($total_markup/100)+$ExMAmount)*$ExDis/100;
		        									if ($j==0) {
					            						$oneNight1[] = $CPEAmoAD[0];
					            					}
		        									echo number_format(backend_currency_type($CPEAmoAD[$j]),2),admin_currency(); 
		            								 ?> 
		            								
			            						</td>
			            					 	<td class="text-right"><?php 
				            					 	$ExAmount[$j] = (($examountExplode[$Exrkey]*$total_markup)/100)+$examountExplode[$Exrkey]+$ExMAmount-(((($examountExplode[$Exrkey]*$total_markup)/100)+$examountExplode[$Exrkey]+$ExMAmount)*$ExDis/100);

				            					 	$TExAmount[$j] +=(($examountExplode[$Exrkey]*$total_markup)/100)+$examountExplode[$Exrkey]+$ExMAmount-(((($examountExplode[$Exrkey]*$total_markup)/100)+$examountExplode[$Exrkey]+$ExMAmount)*$ExDis/100);
				            					 	$EAmoNotMar[$j] += $examountExplode[$Exrkey]-($examountExplode[$Exrkey]*$ExDis/100);
				            					 	if ($ExDis!=0) { ?>
					            						<small class="old-price text-danger"><?php 
					            						echo number_format(backend_currency_type((($examountExplode[$Exrkey]*$total_markup)/100)+$examountExplode[$Exrkey]+$ExMAmount),2),admin_currency();
					            						 ?></small>
					            						<br>
				            						<?php }
				            					 	if ($j==0) {
					            						$oneNight[] = $TExAmount[0];
					            					}
				            					 	echo number_format(backend_currency_type($ExAmount[$j]),2),admin_currency(); 
			            					 	 ?></td>
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
			            					 	<td class="text-center">
		            								<?php 
		            								$GSMAmount = 0;
		            								if ($view[0]->revenueMarkup!="") {
		            									if ($view[0]->revenueGeneralMarkupType=='Percentage') {
		            										$GSMAmount = ($gsadultAmountExplode[$gsakey]*$view[0]->revenueGeneralMarkup)/100;
		            									} else {
		            										$GSMAmount = $view[0]->revenueGeneralMarkup;
		            									}
		            								}
		            								$GSDis = 0;
		            								if ($GeneralDiscount[$i-1]==1) {
		            									$GSDis = $individual_discount[$j];
		            								}
		            								$CPGAmoAD[$j] = $gsadultAmountExplode[$gsakey]-($gsadultAmountExplode[$gsakey]*$GSDis)/100;
		        									$GAmoADMar[$j] = $gsadultAmountExplode[$gsakey]*$total_markup/100+$GSMAmount-($gsadultAmountExplode[$gsakey]*$total_markup/100+$GSMAmount)*$GSDis/100;
		        									if ($j==0) {
					            						$oneNight1[] = $CPGAmoAD[0];
					            					}
		        									echo number_format(backend_currency_type($CPGAmoAD[$j]),2),admin_currency(); 
		            								 ?> 
		            								
			            						</td>
			            					 	<td class="text-right"><?php 
			            					 		$GAamount[$j] = ((($gsadultAmountExplode[$gsakey]*$total_markup)/100)+$gsadultAmountExplode[$gsakey]+$GSMAmount)-((($gsadultAmountExplode[$gsakey]*$total_markup)/100)+$gsadultAmountExplode[$gsakey]+$GSMAmount)*$GSDis/100;
			            					 		$GAmoNotMar[$j]=$gsadultAmountExplode[$gsakey]-($gsadultAmountExplode[$gsakey]*$GSDis)/100;
			            					 		if ($GSDis!=0) { ?>
					            						<small class="old-price text-danger"><?php 
					            						echo number_format(backend_currency_type((($examountExplode[$Exrkey]*$total_markup)/100)+$examountExplode((($gsadultAmountExplode[$gsakey]*$total_markup)/100)+$gsadultAmountExplode[$gsakey]+$GSMAmount)),2),admin_currency();
					            						 ?></small>
					            						<br>
				            						<?php }
			            					 		if ($j==1) {
					            						$oneNight[] = $GAamount[0];
					            					}
			            					 	echo number_format(backend_currency_type($GAamount[$j]),2),admin_currency();
			            					 	?></td>
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
					            					 	<td class="text-center">
			            								<?php 
			            								$GSMAmount = 0;
			            								if ($view[0]->revenueMarkup!="") {
			            									if ($view[0]->revenueGeneralMarkupType=='Percentage') {
			            										$GSMAmount = ($gschildAmountExplode[$gsckey]*$view[0]->revenueGeneralMarkup)/100;
			            									} else {
			            										$GSMAmount = $view[0]->revenueGeneralMarkup;
			            									}
			            								}
			            								$GSDis = 0;
			            								if ($GeneralDiscount[$i-1]==1) {
			            									$GSDis = $individual_discount[$j];
			            								}


			            								$CPAmoAD[$j] = $gschildAmountExplode[$gsckey]-$gschildAmountExplode[$gsckey]*$GSDis/100;
			        									$GCAmoADMar[$j] = ($gschildAmountExplode[$gsckey]*$total_markup/100+$GSMAmount)-($gschildAmountExplode[$gsckey]*$total_markup/100+$GSMAmount)*$GSDis/100;
			        									if ($j==0) {
						            						$oneNight1[] = $CPAmoAD[0];
						            					}
			        									echo number_format(backend_currency_type($CPAmoAD[$j]),2),admin_currency();
			            								 ?> 
		            								
			            								</td>
					            					 	<td class="text-right"><?php 
					            					 		$GCamount[$j] = ((($gschildAmountExplode[$gsckey]*$total_markup)/100)+$gschildAmountExplode[$gsckey]+$GSMAmount)-((($gschildAmountExplode[$gsckey]*$total_markup)/100)+$gschildAmountExplode[$gsckey]+$GSMAmount)*$GSDis/100;
					            					 		$GCAmoNotMar[$j] = $gschildAmountExplode[$gsckey]-$gschildAmountExplode[$gsckey]*$GSDis/100;
				            					 			if ($GSDis!=0) { ?>
							            						<small class="old-price text-danger"><?php 
							            						echo number_format(backend_currency_type(((($gschildAmountExplode[$gsckey]*$total_markup)/100)+$gschildAmountExplode[$gsckey]+$GSMAmount)),2),admin_currency();
							            						 ?></small>
							            						<br>
						            						<?php }
					            					 		if ($j==1) {
							            						$oneNight[] = $GCamount[0];
							            					}
					            					 	echo number_format(backend_currency_type($GCamount[$j]),2),admin_currency();
					            					 	?></td>
					            					 </tr>
				            					<?php } } ?> 

			            					<?php } } } ?>
			            					<!-- Adult General supplement list end -->
			            					<!-- Adults Board supplement list start -->
			            					<?php 
			            					foreach ($board as $bkey => $bvalue) { 
			            						if (($room_id==$bvalue->room_id || $bvalue->room_id=="") && $bvalue->stayDate==date('d/m/Y', strtotime($view[0]->check_in. ' + '.$j.'  days'))) {
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
			            							<td class="text-center">
			            								<?php
			            								$BSMAmount = 0;
			            								if ($view[0]->revenueMarkup!="") {
			            									if ($view[0]->revenueBoardMarkupType=='Percentage') {
			            										$BSMAmount = ($ABRwadultamountexplode[$ABRwkey]*$view[0]->revenueBoardMarkup)/100;
			            									} else {
			            										$BSMAmount = $view[0]->revenueBoardMarkup*$ABReqwadultexplode[$ABRwkey];
			            									}
			            								}
			            								$BSDis = 0;
			            								if ($BoardDiscount[$i-1]==1) {
			            									$BSDis = $individual_discount[$j];
			            								}
			            								$CPBAAmoAD[$j] = $ABRwadultamountexplode[$ABRwkey]-($ABRwadultamountexplode[$ABRwkey]*$BSDis/100);

			        									$BAAmoADMar[$j] = $ABRwadultamountexplode[$ABRwkey]*$total_markup/100+$BSMAmount-($ABRwadultamountexplode[$ABRwkey]*$total_markup/100+$BSMAmount)*$BSDis/100;
			        									if ($j==0) {
						            						$oneNight1[] = $CPBAAmoAD[0];
						            					}
			        									echo number_format(backend_currency_type($CPBAAmoAD[$j]),2),admin_currency() 
			            								 ?> 
		            								
			            								</td>
			            							<td class="text-right"><?php 
			            								$BAamount[$j] = ((($ABRwadultamountexplode[$ABRwkey]*$total_markup)/100)+$ABRwadultamountexplode[$ABRwkey]+$BSMAmount)-((($ABRwadultamountexplode[$ABRwkey]*$total_markup)/100)+$ABRwadultamountexplode[$ABRwkey]+$BSMAmount)*$BSDis/100;
			            								$BAAmoNotMar[$j]= $ABRwadultamountexplode[$ABRwkey]-($ABRwadultamountexplode[$ABRwkey]*$BSDis/100);

			            								$TBAAmoNotMar[$j] += $BAAmoNotMar[$j];

			            								$TBAamount[$j] += $BAamount[$j] ;
			            								if ($BSDis!=0) { ?>
							            						<small class="old-price text-danger"><?php 
							            						echo number_format(backend_currency_type(((($ABRwadultamountexplode[$ABRwkey]*$total_markup)/100)+$ABRwadultamountexplode[$ABRwkey]+$BSMAmount)),2),admin_currency();
							            						 ?></small>
							            						<br>
					            						<?php }
			            								if ($j==0) {
						            						$oneNight[] = $TBAamount[0];
						            					}
			            							echo number_format(backend_currency_type($BAamount[$j]),2),admin_currency()
			            							 ?></td>
			            						</tr>
			            						
			            					<?php } } ?>
			            					<!-- Adults Board supplement list end -->
			            					<!-- Child Board supplement list start -->
			            					<?php 
			            							$CBRwchildexplode = explode(",", $bvalue->Rwchild);
			            							$CBReqwchildexplode = explode(",", $bvalue->BreqchildCount);
			            							$CBRwchildamountexplode = explode(",", $bvalue->RwchildAmount);
			            							foreach ($CBRwchildexplode as $CBRwkey => $CBRwvalue) {
			            								if ($CBRwvalue==$i) {
			            						?>
			            						<tr>
			            							<td></td>
			            							<td>Child <?php echo $bvalue->board; ?></td>
			            							<td class="text-center">-</td>
			            							<td class="text-center">
			            								<?php 
			            								$BSMAmount = 0;
			            								if ($view[0]->revenueMarkup!="") {
			            									if ($view[0]->revenueBoardMarkupType=='Percentage') {
			            										$BSMAmount = ($CBRwchildamountexplode[$CBRwkey]*$view[0]->revenueBoardMarkup)/100;
			            									} else {
			            										$BSMAmount = $view[0]->revenueBoardMarkup*$CBReqwchildexplode[$CBRwkey];
			            									}
			            								}
			            								$BSDis = 0;
			            								if ($BoardDiscount[$i-1]==1) {
			            									$BSDis = $individual_discount[$j];
			            								}
		            									$CPBCAmoAd[$j] = $CBRwchildamountexplode[$CBRwkey]-($CBRwchildamountexplode[$CBRwkey]*$BSDis/100);

			        									$BCAmoAdMar[$j] = ($CBRwchildamountexplode[$CBRwkey]*$total_markup/100+$BSMAmount)-($CBRwchildamountexplode[$CBRwkey]*$total_markup/100+$BSMAmount)*$BSDis/100;
			        									if ($j==0) {
						            						$oneNight1[] = $CPBCAmoAd[0];
						            					}
			        									echo number_format(backend_currency_type($CPBCAmoAd[$j]),2),admin_currency(); 
			            								 ?> 
		            								
			            							</td>
			            							<td class="text-right"><?php 
			            								$BCamount[$j] = ((($CBRwchildamountexplode[$CBRwkey]*$total_markup)/100)+$CBRwchildamountexplode[$CBRwkey]+$BSMAmount)-((($CBRwchildamountexplode[$CBRwkey]*$total_markup)/100)+$CBRwchildamountexplode[$CBRwkey]+$BSMAmount)*$BSDis/100;
			            								$BCAmoNotMar[$j]= $CBRwchildamountexplode[$CBRwkey]-($CBRwchildamountexplode[$CBRwkey]*$BSDis/100);
			            								$TBCAmoNotMar[$j]+=$BCAmoNotMar[$j];
			            								$TBCamount[$j] += $BCamount[$j];
			            								if ($BSDis!=0) { ?>
						            						<small class="old-price text-danger"><?php 
						            						echo number_format(backend_currency_type(((($ABRwadultamountexplode[$ABRwkey]*$total_markup)/100)+$ABRwadultamountexplode[$ABRwkey]+$BSMAmount)),2),admin_currency();
						            						 ?></small>
						            						<br>
					            						<?php }
			            								if ($j==0) {
						            						$oneNight[] = $TBCamount[0];
						            					}
			            							echo number_format(backend_currency_type(((($CBRwchildamountexplode[$CBRwkey]*$total_markup)/100)+$CBRwchildamountexplode[$CBRwkey]+$BSMAmount)),2),admin_currency();
			            							 ?></td>
			            						</tr>
		            						
			            					<?php } }  ?>
			            					<?php } } ?>
			            					<!-- Child Board supplement list end -->
			            					<?php } ?>
            							</tbody>
            							<tfoot>
			            					<tr>
			            						<?php 
			            						$CPtotal[$i] = array_sum($CPRMRate)+array_sum($CPEAmoAD)+array_sum($CPGAmoAD)+array_sum($CPAmoAD)+array_sum($CPBAAmoAD)+array_sum($CPBCAmoAd);

		            							$witotal[$i] = array_sum($WiDisroomAmount)+array_sum($TExAmount)+array_sum($GAamount)+array_sum($GCamount)+array_sum($TBAamount)+array_sum($TBCamount);
			            						
			            						  $total[$i] = array_sum($DisroomAmount)+array_sum($TExAmount)+array_sum($GAamount)+array_sum($GCamount)+array_sum($TBAamount)+array_sum($TBCamount);
			            							
			            							$totalNotMar[$i]=array_sum($CPRMRate)+array_sum($EAmoNotMar)+array_sum($GAmoNotMar)+array_sum($GCAmoNotMar)+array_sum($TBAAmoNotMar)+array_sum($TBCAmoNotMar);
			            							$totAdMar[$i]=array_sum($RAmoADMar)+array_sum($EAmoADMar)+array_sum($GAmoADMar)+array_sum($GCAmoADMar)+array_sum($BAAmoADMar)+array_sum($BCAmoAdMar);

			            							if (isset($DisTypExplode[$i-1]) && $DisTypExplode[$i-1]=="stay&pay" && $Fdays!=0) {
				            							array_splice($CPRMRate, 1,$Fdays);
				            							array_splice($DisroomAmount, 1,$Fdays);
				            							if ($ExtrabedDiscount[$i-1]==1) {
				            								array_splice($EAmoNotMar,1,$Fdays);
				            								array_splice($TExAmount,1,$Fdays);
				            							}
				            							if ($GeneralDiscount[$i-1]==1) {
				            								array_splice($GAmoNotMar,1,$Fdays);
				            								array_splice($GCAmoNotMar,1,$Fdays);

				            								array_splice($GAamount,1,$Fdays);
				            								array_splice($GCamount,1,$Fdays);
				            							}
				            							if ($BoardDiscount[$i-1]==1) {
				            								array_splice($TBAAmoNotMar,1,$Fdays);
				            								array_splice($TBCAmoNotMar,1,$Fdays);

				            								array_splice($TBAamount,1,$Fdays);
				            								array_splice($TBCamount,1,$Fdays);
				            							}
				            						} 

			            							$costPrice[$i] = array_sum($CPRMRate)+array_sum($EAmoNotMar)+array_sum($GAmoNotMar)+array_sum($GCAmoNotMar)+array_sum($TBAAmoNotMar)+array_sum($TBCAmoNotMar);


			            							$totRmAmt[$i] = array_sum($DisroomAmount)+array_sum($TExAmount)+array_sum($GAamount)+array_sum($GCamount)+array_sum($TBAamount)+array_sum($TBCamount); 
			            						 ?>
			            						<td colspan="3" style="text-align: right"><strong class="text-blue">Total</strong></td>
			            						<td style="text-align: right; font-weight: 700; color: #0074b9">
			            							<?php if (isset($DisTypExplode[$i-1]) && $DisTypExplode[$i-1]=="stay&pay") { ?>
			            								<small class="old-price text-danger" style="font-size: 11px;font-weight: 100;"><?php echo number_format(backend_currency_type($totalNotMar[$i]),2),admin_currency(); ?></small><br>
			            							<?php } ?>
			            							<?php echo number_format(backend_currency_type($costPrice[$i]),2),admin_currency() ?> </td>
			            						<td style="text-align: right; font-weight: 700; color: #0074b9">
			            							<?php if (isset($DisTypExplode[$i-1]) && $DisTypExplode[$i-1]=="stay&pay") { ?>
			            								<small class="old-price text-danger" style="font-size: 11px;font-weight: 100;"><?php echo number_format(backend_currency_type($total[$i]),2),admin_currency(); ?></small><br>
			            							<?php } ?>
			            							<?php echo number_format(backend_currency_type($totRmAmt[$i]),2),admin_currency(); ?> </td>
			            					</tr>
            							</tfoot>
            						</table>
            						<br>
            					</div>
            				</div>
            				<?php } ?>
						</div>
				
						<div class="card-block"  style="padding: 15px;">
          					<div class="row m-b-1">
            					<div class="col-md-12">
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
							$array_sumTotalNM= (array_sum($totalNotMar)*$view[0]->tax)/100 + array_sum($totalNotMar);

			   				 ?>
			    			
						    <div class="col-md-6 bold">
							    <p>GRAND TOTAL</p>
						    </div>

						    <div class="col-md-6 bold">
							    <p><?php 
							    $costPrice = array_sum($costPrice);
							   
							    $final_total = $array_sumTotal;
							    $array_sumTotalNM = $array_sumTotalNM-($array_sumTotalNM*$view[0]->discount)/100;
								$Agentprofit= ($costPrice*($view[0]->agent_markup))/100;
								$Adminprofit= ($costPrice*($view[0]->admin_markup))/100;
								if ($Adminprofit==0) {
									$Adminprofit= $final_total-($Agentprofit+$costPrice);
								}
							    echo number_format(backend_currency_type($final_total),2);
							    	 echo ' '.admin_currency();
							     ?></p>
						    </div>
						    <div class="col-md-6 bold">
							    <p>Admin Profit</p>
						    </div>
						    <div class="col-md-6 bold">
							    <p><?php 
							    	 echo number_format(backend_currency_type($Adminprofit),2);
							    	 echo ' '.admin_currency();
							    	?>
							    </p>
						    </div>
						    <div class="col-md-6 bold">
							    <p>Agent Profit</p>
						    </div>
						    <div class="col-md-6 bold">
							    <p><?php 
							    	 echo number_format(ceil(backend_currency_type($Agentprofit)),2);
							    	 echo ' '.admin_currency();
							    	?>
							    </p>
						    </div>
							<div class="col-md-6 bold">
							    <p>COST PRICE TOTAL</p>
						    </div>
						    <div class="col-md-6 bold">
							    <p><?php echo number_format(backend_currency_type($costPrice),2);
							    	 echo ' '.admin_currency() ?></p>
						    </div>
						    <div class="col-md-6 bold">
							    <p>Payment Type</p>
						    </div>
						    <div class="col-md-6 bold">
							    <p><?php echo count($payment)!=0 ? 'ONLINE' : 'CREDIT AMOUNT' ?></p>
						    </div>
						    <?php if (count($payment)!=0) { ?>
							    <div class="col-md-6 bold">
								    <p>Transaction Reference</p>
							    </div>
							    <div class="col-md-6 bold">
								    <p><?php echo $payment[0]->orderNumber ?></p>
							    </div>
						    <?php } ?>
						</div>
            						
								</div>
							</div>
						</div> 
				</div>
			</div>
		</div>
	</div>
</div>
<?php if ($view[0]->SpecialRequest!="") { ?>
<div class="col-sm-12 col-xs-12">
	<div class="card">
		<div class="card-header text-uppercase" style="padding: 10px; border-bottom: 1px solid #ccc;">
			<h4 class="bold">Special Request</h4>
			<br>
			<p><?php echo $view[0]->SpecialRequest ?></p>
		</div>
	</div>
</div>
<?php } ?>
<?php if(count($cancelation)!=0) { 
	?>
	<div class="col-sm-12 col-xs-12">
	<div class="card">
		<h4 class="bold" style="margin-left: 10px;">Cancelation Policy</h4>
		<?php $roomExp = explode(",", $view[0]->room_id);
		foreach ($roomExp as $key => $value) { ?>
		<div class="card-header text-uppercase" style="padding: 10px; border-bottom: 1px solid #ccc;">
		<h5 class="room-name">Room <?php echo $key+1 ?> </h5>
			<table class="table table-bordered table-hover">
						<thead>
					      <tr style="background-color: #0074b9;color: white">
					        <th>Cancelled on or After</th>
					        <th>Cancelled on or Before</th>
					        <th>Cancellation Charge (COST)</th>
					        <th>Cancellation Charge (SELLING)</th>
					      </tr>
					    </thead>
					    <tbody> 
					    	<?php 
					    	foreach ($cancelation as $Canckey => $Cancvalue) { 
					    		if ($Cancvalue->roomIndex==($key+1) || $Cancvalue->roomIndex=="") {
					    		if ($Cancvalue->application=="NON REFUNDABLE") {  ?>
					    		<tr>
						    		<td><?php echo date('d/m/Y') ?></td>
						    		<td><?php echo date('d/m/Y',strtotime($view[0]->check_in)) ?></td>
							    	<td><?php $charge1 = $costPrice*($Cancvalue->cancellationPercentage/100);
						    		 echo number_format(ceil(backend_currency_type($charge1)),2);
							    	 echo ' '.admin_currency();?>
							    	 (<?php echo $Cancvalue->application ?>)</td>
						    		<td><?php $charge = $final_total*($Cancvalue->cancellationPercentage/100);
						    		 echo number_format(ceil(backend_currency_type($charge)),2);
							    	 echo ' '.admin_currency();?>
							    	 (<?php echo $Cancvalue->application ?>)</td>
						    	</tr>
					    	<?php 	} else { ?>
						    	<tr>
						    		<td><?php 
						    		$lastAmt = array_sum($oneNight);
						    		$lastAmt1 = array_sum($oneNight1);
						    		if(date('Y-m-d' , strtotime('-'.($Cancvalue->daysFrom).' days', strtotime($view[0]->check_in))) < date('Y-m-d')) {
						    			echo date('d/m/Y');
						    		} else {
						    			echo date('d/m/Y' , strtotime('-'.($Cancvalue->daysFrom).' days', strtotime($view[0]->check_in)));
						    		}
						    		?></td>
						    		<td><?php echo date('d/m/Y' , strtotime('-'.$Cancvalue->daysTo.' days', strtotime($view[0]->check_in))) ?></td>
							    	<td><?php 
						    			if ($Cancvalue->application=="FIRST NIGHT") {
						    				$charge1 = $lastAmt1*($Cancvalue->cancellationPercentage/100);
						    			} else {
						    				$charge1 = $costPrice*($Cancvalue->cancellationPercentage/100);
						    			}
						    			if ($Cancvalue->application=="FREE OF CHARGE") {
						    				echo 0;
						    		 		echo ' '.admin_currency();
						    			} else {
						    		 		echo number_format(ceil(backend_currency_type($charge1)),2);
						    		 		echo ' '.admin_currency();
						    			}
							    	 	?>
							    	 (<?php echo $Cancvalue->application ?>)</td>
						    		<td><?php 
						    			if ($Cancvalue->application=="FIRST NIGHT") {
						    				$charge = $lastAmt*($Cancvalue->cancellationPercentage/100);
						    			} else {
						    				$charge = $final_total*($Cancvalue->cancellationPercentage/100);
						    			}
						    			if ($Cancvalue->application=="FREE OF CHARGE") {
						    				echo 0;
						    		 		echo ' '.admin_currency();
						    			} else {
						    		 		echo number_format(ceil(backend_currency_type($charge)),2);
						    		 		echo ' '.admin_currency();
						    			}
							    	 	?>
							    	 (<?php echo $Cancvalue->application ?>)</td>
						    	</tr>
							<?php } } } ?>
				    	</tbody>
				</table>
		</div>
		<br>
		<?php } ?>
	</div>
	</div>
<?php } ?>
<div class="col-sm-12 col-xs-12">
	<div class="card">
		<div class="card-header text-uppercase" style="padding: 10px; border-bottom: 1px solid #ccc;">
			<h5 class="bold">Remarks</h5>
			<form id="bookingRemarkForm">
				<input type="hidden" name="bkId" value="<?php echo $_REQUEST['id']  ?>">
				<textarea id="bookingRemark" name="bookingRemark" class="form-control"></textarea>
				<div class="row"> 
					<br>
					<div class="col-xs-12"> 
					<button type="button" id="bookingRemarkBtn" class="btn-sm btn-success pull-right">Add</button>
					</div>
					<br>
				</div>
			</form>
		</div>
		<br>
		<div class="card-header" style="padding: 10px; border-bottom: 1px solid #ccc;">
		<table class="table table-bordered table-hover">
			<thead class="text-uppercase">
		      <tr style="background-color: #0074b9;color: white">
		        <th>Remarks</th>
		        <th>User</th>
		        <th>Date</th>
		        <th>Time</th>
		        <?php if ($this->session->userdata('role')==1) { ?>
		        	<th class="text-center">Action</th>
		        <?php } ?>
		      </tr>
		    </thead>
		    <tbody>
		    	<?php foreach ($remarks as $key => $value) { ?>
			    	<tr>
			    		<td><?php echo $value->remarks ?></td>
			    		<td><?php echo $value->Name ?></td>
			    		<td><?php echo Date('d/m/Y' ,strtotime($value->createdDate)) ?></td>
			    		<td><?php echo Date('H:i:s' ,strtotime($value->createdDate)) ?></td>
		        		<?php if ($this->session->userdata('role')==1) { ?>
			    			<td class="text-center"><button onclick="remarksDelete('<?php echo $value->id ?>')" class="btn-sm btn-danger"><i class="fa fa-trash"></i></button></td>
		        		<?php } ?>
			    	</tr>
		    	<?php } ?>
		    </tbody>
	    </table>
		</div>
	</div>
</div>
<div class="col-sm-12 col-xs-12">
	<div class="card">
		<div class="card-header text-uppercase" style="padding: 10px; border-bottom: 1px solid #ccc;">
			<h5 class="bold">Logs</h5>
		</div>
		<br>
		<div class="card-header" style="padding: 10px; border-bottom: 1px solid #ccc;">
		<table class="table table-bordered table-hover">
			<thead class="text-uppercase">
		      <tr style="background-color: #0074b9;color: white">
		        <th>Date</th>
		        <th>Action</th>
		        <th>User</th>
		        <th>Description</th>
		       
		      </tr>
		    </thead>
		    <tbody>
		    	<?php foreach ($logs as $key => $value) { ?>
			    	<tr>
			    		<td><?php echo $value->Date ?></td>
			    		<td><?php echo $value->action ?></td>
			    		<td><?php echo $value->user ?></td>
			    		<td><?php echo $value->description ?></td>
			    	</tr>
		    	<?php } ?>
		    </tbody>
	    </table>
		</div>
	</div>
</div>
<!-- Modal-->
<div id="myModal" class="modal fade delete_modal" role="dialog">
        <div class="modal-dialog">
        <!-- Modal content-->
            <div class="modal-content">
            	<div class="modal-header">
	                <span>Do you want cancel this booking?</span>
	                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <!-- <h4 class="modal-title">Add Reference Id</h4> -->
        		</div>
                <div class="modal-body" style="height: 300px;">
                	<form   action="" id="invoice_form1" name="invoice_form1" method="post">
                    <input type="hidden" name="id" id="idz" value="<?php echo $view[0]->bkid ?>">
                    <input type="hidden" name="hotel_id" id="hotelz_id" value="<?php echo $view[0]->hotel_id ?>">
                    <input type="hidden" name="agent_id" id="agentz_id" value="<?php echo $view[0]->agent_id ?>">
                    
                	<div class="col-sm-12 col-xs-12">
						
							<div class="card-header text-uppercase" style="padding: 10px; border-bottom: 1px solid #ccc;">
								<h4 class="bold">Cancelation Policy</h4><br>
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
									    		<td><?php echo date('d/m/Y') ?></td>
									    		<td><?php echo date('d/m/Y',strtotime($view[0]->check_in)) ?></td>
									    		<td><?php echo $Cancvalue->cancellationPercentage ?>% (<?php echo $Cancvalue->application ?>)</td>
									    	</tr>
								    	<?php 	} else { ?>
									    	<tr>
									    		<td><?php 
									    		if(date('Y-m-d' , strtotime('-'.($Cancvalue->daysFrom).' days', strtotime($view[0]->check_in))) < date('Y-m-d')) {
									    			echo date('d/m/Y');
									    		} else {
									    			echo date('d/m/Y' , strtotime('-'.($Cancvalue->daysFrom).' days', strtotime($view[0]->check_in)));
									    		}
									    		?></td>
									    		<td><?php echo date('d/m/Y' , strtotime('-'.$Cancvalue->daysTo.' days', strtotime($view[0]->check_in))) ?></td>
									    		<td><?php echo $Cancvalue->cancellationPercentage ?>% (<?php echo $Cancvalue->application ?>)</td>
									    	</tr>
										<?php } } ?>
							    	</tbody>
								</table>
							</div>
							<br>
						</div>
					
                	<div class="row">
                	<div class="col-md-12 form-group">
	                    <button type="button" id="reject_button" class="btn-sm btn-success pull-right" style="margin-left: 5px;">Yes</button>
	            		<button type="button" data-dismiss="modal"  style="margin-left: 10px;" class="btn-sm btn-danger pull-right">No</button>
                	</div>
                	</div>
                	<script type="text/javascript">
                		  $("#reject_button").click(function(e){

						    var id = $("#idz").val();
						    var hotel_id = $("#hotelz_id").val();
						    var agent_id = $("#agentz_id").val();
						    addToast("Canceld Successfully","green");
						    $.ajax({
						      // dataType: 'json',
						      type: "POST",
						      url: base_url+'backend/booking/cancellationUpdate?book_id='+id+'&hotel_id='+hotel_id+'&agent_id='+agent_id,
						      cache: false,
						      success: function (response) {
						        document.location.reload(true); 
						      }
						    });

						  });
                	</script>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade  delete_modal" id="booking_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
            	<div class="modal-header">
	                <span>Do you want Accept this booking?</span>
	                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <!-- <h4 class="modal-title">Add Reference Id</h4> -->
        		</div>
                <div class="modal-body" style="height: 100px;">
      	            <form   action="" id="invoice_form" name="invoice_form" method="post">
      	                <div class="col-md-6 form-group">
                          		<input type="hidden" class="form-control" id="booking_invoice_id" name="booking_invoice_id" placeholder="Invoice ID" readonly>
                              <input type="hidden" name="id" id="book_id" value="<?php echo $view[0]->bkid ?>">
                          	  <input type="hidden" name="hotel_id" id="hotels_id" value="<?php echo $view[0]->hotel_id ?>">
                              <input type="hidden" name="agent_id" id="agents_id" value="<?php echo $view[0]->agent_id ?>">
                          		<input type="hidden" name="invoice_ck" id="invoice_ck" value="0">
                          		<span class="text-danger invoice_err"></span>
      	                </div>
      	                <div class="col-md-6 form-group">
                          		<input type="hidden" class="form-control" id="booking_invoice_date" name="booking_invoice_date" placeholder="Invoice date" readonly >
                          		<span class="text-danger invoice_date_err"></span>
      	                </div> 
      	                <?php if($view[0]->booking_flag==4) { ?>
                        <div class="col-md-6 form-group">
                              <input type="text" class="form-control" id="booking_confirmation" name="booking_confirmation" value="<?php echo $view[0]->confirmationNumber ?>" readonly>
                        </div>
                        <div class="col-md-6 form-group">
                              <input type="text" class="form-control" id="booking_confirmation_name" name="booking_confirmation_name" value="<?php echo $view[0]->confirmationName ?>" readonly>
                        </div>
                        <?php 	} else { ?>
                        <div class="col-md-6 form-group">
                            <input type="text" class="form-control" id="booking_confirmation" name="booking_confirmation" placeholder="Confirmation number">
                      	</div>
	                    <div class="col-md-6 form-group">
	                        <input type="text" class="form-control" id="booking_confirmation_name" name="booking_confirmation_name" placeholder="Confirmation name">
	                    </div>
	                    <?php  } ?>
                        
    	            </form>
                </div>
                <div class="modal-footer">
		           <div class="row">
		           		<div class="col-md-12 form-group">
				           <button type="button" data-dismiss="modal" id="accept_no_button" class="btn-sm btn-danger ">No</button>
				           <button type="button" id="accept_button"  class="btn-sm btn-success">Yes</button>
				        </div>
		         		</div>
		         	</div>
            </div>
        </div>
    </div>

    <div class="modal fade col-md-6 col-md-offset-3" id="booking_success_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <!-- Modal content-->
          </div>
    </div>

    <div class="modal fade col-md-12 delete_modal" style="width: 94%;" id="Ammendment_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    </div>
<script type="text/javascript">
	$("#Ammendment_modal_btn").click(function() {
		$("#Ammendment_modal").load(base_url+"backend/booking/AmmendmentModal?id=<?php echo $_REQUEST['id'] ?>");
		$("#Ammendment_modal").modal();
	})
	function amendmentView(id) {
		$("#Ammendment_modal").load(base_url+"backend/booking/AmmendmentModal?id=<?php echo $_REQUEST['id'] ?>&amendid="+id);
		$("#Ammendment_modal").modal();

	}
	// $("#Ammendment_modal_view_btn").click(function(){
	// 	var amendid=$(this).data('id')
		
	// })
	$("#bookingRemarkBtn").click(function() {
	    var bookingRemark = $("#bookingRemark").val();
	    if (bookingRemark=="") {
	    	addToast("Remarks field is required!","orange");
	    	$("#bookingRemark").focus();
	    } else {
	    	addToast("Updated Successfully","green");
	    	$("#bookingRemarkForm").attr('action',base_url+'backend/booking/bookingRemarkSubmit');
	    	$("#bookingRemarkForm").submit();
	    }
	  });
	function remarksDelete(id) {
    	addToast("Deleted Successfully","green");
		window.location = base_url+"backend/booking/remarksDelete?id="+id+'&bkid='+<?php echo $view[0]->bkid ?>;
	}
	function amendacceptfun(id) {
        $.ajax({
            dataType: 'json',
            type: "Post",
            url: base_url+'/backend/Booking/acceptAmendment?id='+id,
            success: function(data) {
              addToast("Updated Successfully","green");
            }
        });
    }
    function deleteamendmentfun(id) {
  		$("#myModal").load(base_url+'backend/Booking/deleteAmendmentfun?id='+id);
	}
	function commonDelete() {
		$.ajax({
		  dataType: 'json',
		  type: "POST",
		  url: $("#delete_form").attr("action"),
		  data: $("#delete_form").serialize(),
		  cache: false,
		  success: function (response) {
	      	addToast(response.error,response.color);
	      	close_delete_modal();
	 	  }
		});
	}
	$('#listamendment').click(function() {
    	$("#amendmentTable").removeClass("hide");
    })

	</script>
<?php init_tail(); ?>



