<?php init_front_head_dashboard(); ?>
<script src="<?php echo static_url(); ?>skin/js/booking.js"></script>
<div class="sb2-2">
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp">
					<div class="row">
						<div class="col-md-6">
							<h3>Offline Request List</h3>
							<span class="msg"></span>
						</div>
						<div class="col-md-6">
							</br>
							<a class="pull-right btn btn-primary" data-toggle="modal" data-target="#myModal" onclick="OfflineRequestModal();">Add</a>
						</div>
						<div class="clearfix"></div>
						<div class="row">
							<div class="col-md-12">
								<input type="hidden" id="filter" value="2">
				                <div class="col-md-12 mar_top_10">
				                    <ul class="tabs" style="box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.16);padding-left: 0px;">
				                    	<li class="tab col s2"><a class="Pending active" href="#" onclick="OfflineHotelfilter('2')">Pending</a></li>
				                    	<li class="tab col s2"><a class="Accepted" href="#" onclick="OfflineHotelfilter('1')">Accepted</a></li>
			                            <li class="tab col s2"><a class="Cancelled" href="#" onclick="OfflineHotelfilter('0')">Cancelled</a></li>
				                    </ul>
				                </div>
				            </div>
			            </div>
						<div class="clearfix"></div>
						</br>
						</br>
						<div class="col-md-12">
							<table class="table table-striped center" id="offlineRequestTable">
				  				<thead class="thead-dark">
									<tr>
										<td>Slno</td>
										<td>Book Id</td>
										<td>Destination</td>
										<td>Request date</td>
										<td>Hotel Name</td>
										<td>Room Name</td>
										<!-- <td>invoice</td> -->
										<!-- <td>voucher</td> -->
										<td>Check In</td>
										<td>Check Out</td>
										<td>No of rooms</td>
										<td>Price</td>
										<td>Status</td>
										<td>Action</td>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div> 
</div>
<div id="myModal" class="modal fade" role="dialog">
</div>
<script type="text/javascript">
	function OfflineHotelfilter(val) {
	$(".Pending").removeClass('active');
    $(".Accepted").removeClass('active');
    $(".Cancelled").removeClass('active');
    $("#filter").val(val);
    if(val==1) {
      $(".Accepted").addClass('active');
    } else if(val==2) {
      $(".Pending").addClass('active');
    }else if(val==0) {
      $(".Cancelled").addClass('active');
    }
	    var offlineRequestTable = $('#offlineRequestTable').dataTable({
	        "bDestroy": true,
	        "ajax": {
	            url : base_url+'Payment/offlineRequestList?filter='+val,
	            type : 'GET'
	        },
		    "fnDrawCallback": function(settings){
		    	$('[data-toggle="tooltip"]').tooltip();          
		    }
	    }); 
	}
</script>
<?php init_front_head_footer(); ?> 