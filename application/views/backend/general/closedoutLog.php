<?php init_head(); ?>
<style type="text/css">
.multi-select-trans1 .form-control {
    padding: 0px 0 !important;
  }
  .input-hide input {
    display: none ! important;
  }
  .input-hide li {
    display: none ! important;
  }
  .select2-choice {
     height: 35px ! important;
     line-height: 23px ! important;
  }
  #closedoutTable_wrapper .btn  {
      height: 27px;
      font-size: 12px;
      line-height: 28px;
      background: #009688;
      margin: 1px;
  }
</style>
<div class="sb2-2">
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp">
                    <div class="inn-title">
                        <span> Closed Out Log </span>
                    </div>
                    <form method="get" id="bookingReport_filter">
                                  <div class="col-md-12"> 
                                            <div class="form-group col-md-2">
                                                      <label for="from_date">From date</label>
                                              <input type="text" class="datePicker-hide datepicker input-group-addon" id="from_date" name="date" placeholder="dd/mm/yyyy" value="<?php echo date('Y-m-d') ?>" />
                                          <div class="input-group">
                                          <input class="form-control datepicker date-pic" id="alternate1" name="" value="<?php echo date('d/m/Y') ?>" readonly>
                                          <label for="from_date" class="input-group-addon"><i class="fa fa-calendar"></i></label>
                                          </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                                      <label for="to_date">To date</label>
                                              <input type="text" class="datePicker-hide datepicker input-group-addon" id="to_date" name="date" placeholder="dd/mm/yyyy" value="<?php echo date('Y-m-d') ?>" />
                                          <?php $today=date('d/m/Y'); ?>
                                          <div class="input-group">
                                          <input class="form-control datepicker date-pic" id="alternate2" name="" value="<?php echo $today ?>" readonly>
                                          <label for="to_date" class="input-group-addon"><i class="fa fa-calendar"></i></label>
                                          </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                         <label>Select Hotel</label>
                                          <select name="hotels" id="hotels">
                                            <option value="">--select--</option>
                                            <?php 
                                              foreach ($view as $key => $value) { ?>
                                                  <option value="<?php echo $value->hotel_id; ?>"><?php echo $value->hotel_name; ?></option>

                                            <?php } ?>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="col-md-2">
                                      <div class="form-group">
                                         <label>Select Contract</label>
                                         <select name="hotel_contract" id="hotel_contract">
                                            <option value="">--select--</option>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="form-group col-md-2 ">
                                          <input type="button" class="mar_top_23 btn-sm btn-primary" id="closedoutButton" value="Search">
                                  </div>
                                </div>
                      </form>
                    <div class="clearfix">
                    <br>
                    <div class="col-md-12">
                        <input type="hidden" id="filter" value="1">
                        <div class="table-responsive table-desi">
                            <table class="table table-condensed table-hover" id="closedoutTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>id</th>
                                        <th>Closed Date</th>
                                        <th>Room type</th>
                                        <th>Hotel Name</th>
                                        <th>Contract ID</th>
                                        <th>Status</th>
                                        <th title="Created Date">C.Date</th>
                                        <th title="Created By">C.By</th>
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
</div>
<!-- <script src="<?php echo base_url(); ?>assets/js/hotel_finance.js"></script> -->
<link href="<?php echo base_url(); ?>assets/select2/select2.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/select2/select2.min.js" type="text/javascript"></script>
<script>
   $("#hotels").select2({
    width: '100%'
});
	closedoutTableLoad();
	$("#closedoutButton").click(function() {
		closedoutTableLoad();
	})
    $("#from_date").datepicker({
      yearRange: "2016:<?php echo date('Y' ,strtotime('+2 year')) ?>",
      altField: "#alternate1",
      // altField: "#alternate",
      dateFormat: "yy-mm-dd",
      altFormat: "dd/mm/yy",
      changeYear : true,
      changeMonth : true,
      onSelect: function(dateText) {
	 		var nextDay = new Date(dateText);
	 		nextDay.setDate(nextDay.getDate());
	 		$("#to_date").datepicker('option', 'minDate', nextDay);
	 		setTimeout(function(){
	 			$( "#to_date" ).datepicker('show');
	 		}, 16);
	 	}
    });
    $("#alternate1").click(function() {
        $( "#from_date" ).trigger('focus');
    });
    $("#to_date").datepicker({
              yearRange: "2016:<?php echo date('Y' ,strtotime('+2 year')) ?>",
              altField: "#alternate2",
              // altField: "#alternate",
              dateFormat: "yy-mm-dd",
              altFormat: "dd/mm/yy",
              changeYear : true,
              changeMonth : true,
    });
    $("#alternate2").click(function() {
        $( "#to_date" ).trigger('focus');
    });
    function closedoutTableLoad() {
    	var from_date = $("#from_date").val();
    	var to_date   = $("#to_date").val();
	    var closedoutTable = $('#closedoutTable').dataTable({
	        "bDestroy": true,
	         dom: 'lBfrtip',
	          buttons: [
	              'copy', 'csv', 'excel', 'pdf', 'print'
	          ],
	        "ajax": {
	          url : base_url+'backend/common/closedoutLogList?from_date='+from_date+'&to_date='+to_date,
	          type : 'POST' 
	          },

	        "fnDrawCallback": function(settings){
	               $('[data-toggle="tooltip"]').tooltip();          
	        }
	    });
    }
    
</script>
<?php init_tail(); ?>

