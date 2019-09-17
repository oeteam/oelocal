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
  #CancellationPolicyTable_wrapper .btn  {
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
                        <span> Cancellation Policy Log </span>
                    </div>
                    <form method="get" id="bookingReport_filter">
                      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>"> 
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
                                   <div class="col-md-2">
                                      <div class="form-group">
                                         <label>Select User</label>
                                          <select name="user" id="user">
                                            <option value="">--select--</option>
                                            <?php 
                                              foreach ($users as $key => $value) { ?>
                                                  <option value="<?php echo $value->id; ?>"><?php echo $value->First_Name." ".$value->Last_Name; ?></option>

                                            <?php } ?>
                                          </select>
                                      </div>
                                    </div>
                                    <div class="col-md-2">
                                      <div class="form-group">
                                         <label>Select Hotel</label>
                                          <select name="hotels" id="hotels" onchange="contractSelect();">
                                            <option value="">--select--</option>
                                            <?php 
                                              foreach ($hotels as $key => $value) { ?>
                                                  <option value="<?php echo $value->id; ?>"><?php echo $value->hotel_name; ?></option>

                                            <?php } ?>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="col-md-2">
                                      <div class="form-group">
                                         <label for="contracts">Select Contract</label>
                                          <div class="multi-select-mod multi-select-trans1 input-hide">
                                          <select name="contracts" id="contracts" class="form-control">
                                            <option value="">--select--</option>
                                          </select>
                                        </div>
                                      </div>
                                  </div>
                                  <div class="form-group col-md-2 ">
                                          <input type="button" class="mar_top_23 btn-sm btn-primary" id="CancellationPolicyButton" value="Search">
                                  </div>
                                </div>
                      </form>
                    <div class="clearfix">
                    <br>
                    <div class="col-md-12">
                        <input type="hidden" id="filter" value="1">
                        <div class="table-responsive table-desi">
                            <table class="table table-condensed table-hover" id="CancellationPolicyTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>id</th>
                                        <th>Season</th>
                                        <th>From Date</th>
                                        <th>To Date</th>
                                        <th>Day From</th>
                                        <th>Day To</th>
                                        <th>Cancellation %</th>
                                        <th>Room Type</th>
                                        <th>Application</th>
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
<!-- <script src="<?php echo static_url(); ?>assets/js/hotel_finance.js"></script> -->
<link href="<?php echo static_url(); ?>assets/select2/select2.css" rel="stylesheet" type="text/css" />
<script src="<?php echo static_url(); ?>assets/select2/select2.min.js" type="text/javascript"></script>
<script>
  $("#hotels").select2({
    width: '100%'
  });
  $("#user").select2({
    width: '100%'
  });
  $("#contracts").select2({
    width: '100%'
  });
	CancellationPolicyTableLoad();
	$("#CancellationPolicyButton").click(function() {
		CancellationPolicyTableLoad();
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
    function CancellationPolicyTableLoad() {
    	var from_date = $("#from_date").val();
    	var to_date   = $("#to_date").val();
      var hotel = $('#hotels option:selected').val();
      var user = $('#user option:selected').val();
      var contract = $('#contracts option:selected').val();
	    var CancellationPolicyTable = $('#CancellationPolicyTable').dataTable({
	        "bDestroy": true,
	         dom: 'lBfrtip',
	          buttons: [
	              'copy', 'csv', 'excel', 'pdf', 'print'
	          ],
	        "ajax": {
	          url : base_url+'backend/common/CancellationPolicyLogList?from_date='+from_date+'&to_date='+to_date+'&hotel='+hotel+'&user='+user+'&contract='+contract,
	          type : 'POST' 
	          },

	        "fnDrawCallback": function(settings){
	               $('[data-toggle="tooltip"]').tooltip();          
	        }
	    });
    }
    function contractSelect(){
        $('#contracts option').remove();
        var hotel = $('#hotels option:selected').val();
        $.ajax({
            url: base_url+'backend/Common/ContractSelect?hotelid='+hotel,
            type: "POST",
            data:{},
            dataType: "json",
            success:function(data) {
              $('#contracts').append('<option value="">Select</option>');
                $.each(data, function(i, v) {
                  $('#contracts').append('<option value="'+v.contract_id +'">'+ v.contract_id +'</option>');
                });
            }
        });
    }
    
</script>
<?php init_tail(); ?>

