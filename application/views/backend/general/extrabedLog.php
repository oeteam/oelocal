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

  #ExtrabedTable_wrapper .btn  {
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
                        <span> Edxtrabed Log </span>
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
                                  <div class="form-group col-md-2 ">
                                          <input type="button" class="mar_top_23 btn-sm btn-primary" id="ExtrabedButton" value="Search">
                                  </div>
                                </div>
                      </form>
                    <div class="clearfix">
                    <br>
                    <div class="col-md-12">
                        <input type="hidden" id="filter" value="1">
                        <div class="table-responsive table-desi">
                            <table class="table table-condensed table-hover" id="ExtrabedTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>id</th>
                                        <th>Room Type</th>
                                        <th>Season</th>
                                        <th>From Date</th>
                                        <th>To Date</th>
                                        <th>Child Age From</th>
                                        <th>Child Age To</th>
                                        <th>Child Amount</th>
                                        <th>Adult Amount</th>
                                        <th>Hotel Name</th>
                                        <th>Contract ID</th>
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
<script>
	ExtrabedTableLoad();
	$("#ExtrabedButton").click(function() {
		ExtrabedTableLoad();
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
    function ExtrabedTableLoad() {
    	var from_date = $("#from_date").val();
    	var to_date   = $("#to_date").val();
	    var ExtrabedTable = $('#ExtrabedTable').dataTable({
	        "bDestroy": true,
	         dom: 'lBfrtip',
	          buttons: [
	              'copy', 'csv', 'excel', 'pdf', 'print'
	          ],
	        "ajax": {
	          url : base_url+'backend/common/extrabedLogList?from_date='+from_date+'&to_date='+to_date,
	          type : 'POST' 
	          },

	        "fnDrawCallback": function(settings){
	               $('[data-toggle="tooltip"]').tooltip();          
	        }
	    });
    }
    
</script>
<?php init_tail(); ?>

