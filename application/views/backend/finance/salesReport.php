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

  #salesReportTable_wrapper .btn  {
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
                        <span> Sales Report </span>
                    </div>
                    <input type="hidden" class="ad_pro" value="0">
                    <input type="hidden" class="ag_pro" value="0">
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
                                    <div class="form-group col-md-2">
                                          <label for="from_date">Type</label>
                                          <select name="type" id="type">
                                            <option value="Agent">Agent</option>
                                            <option value="Hotel">Hotel</option>
                                            <option value="Supplier">Supplier</option>
                                          </select>
                                    </div>
                                  <div class="form-group col-md-2 ">
                                          <input type="button" class="mar_top_23 btn-sm btn-primary" id="salesReportButton" value="Search">
                                  </div>
                                </div>
                      </form>
                    <div class="clearfix">
                    <br>
                    <div class="col-md-12">
                        <input type="hidden" id="filter" value="1">
                        <div class="table-responsive table-desi">
                            <table class="table table-condensed table-hover" id="salesReportTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>BookingID</th>
                                        <th>Booking Date</th>
                                        <th>Cost</th>
                                        <th>Selling</th>
                                        <th>Admin Profit</th> 
                                        <th>Admin.pro %</th> 
                                        <th>Agent Profit</th> 
                                        <th>Agent.pro %</th> 
                                        <th>Agent</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <td colspan="3">Total</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>100</td>
                                    <td>0</td>
                                    <td>100</td>
                                    <td></td>
                                  </tr>
                                </tfoot>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<script>
  salesreportfun();
  $("#salesReportButton").click(function() {
    salesreportfun();
    salesreportfun();
  })
    $("#from_date").datepicker({
      yearRange: "2016:<?php echo date('Y' ,strtotime('+2 year')) ?>",
      altField: "#alternate1",
      // altField: "#alternate",
      dateFormat: "yy-mm-dd",
      altFormat: "dd/mm/yy",
      changeYear : true,
      changeMonth : true,
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
    function salesreportfun() {
      var tot = 0;
      var from_date = $("#from_date").val();
      var to_date   = $("#to_date").val();
      var type   = $("#type").val();
      var salesReportTable = $('#salesReportTable').dataTable({
          "bDestroy": true,
           dom: 'lBfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
          "ajax": {
            url : base_url+'backend/finance/salespReportList?from_date='+from_date+'&to_date='+to_date+'&type='+type,
            type : 'POST',

          },
          "initComplete": function( settings, json ) {
            $("#salesReportTable").find('tfoot').find('td:eq(1)').text(json.TotCost);
            $("#salesReportTable").find('tfoot').find('td:eq(2)').text(json.Totselling);
            $("#salesReportTable").find('tfoot').find('td:eq(3)').text(json.AdminProfit);
            $("#salesReportTable").find('tfoot').find('td:eq(5)').text(json.AgentProfit);
            $('.ad_pro').val(json.AdminProfit);
            $('.ag_pro').val(json.AgentProfit);
          },
          "fnDrawCallback": function(settings){
                 $('[data-toggle="tooltip"]').tooltip(); 
          },
          "createdRow": function(  row, data, index ) {
            var tot_ad_pro = $(".ad_pro").val();
            var tot_ag_pro = $(".ag_pro").val();
            var ad_pro = $(row).find('td:eq(5)').text();
            var ag_pro = $(row).find('td:eq(7)').text();
            
            $(row).find('td:eq(6)').text(ad_pro/tot_ad_pro*100);
            $(row).find('td:eq(9)').text(ag_pro/tot_ag_pro*100);
          },
      });
    }
</script>
<?php init_tail(); ?>

