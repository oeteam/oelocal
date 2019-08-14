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

  #searchTable_wrapper .btn  {
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
                        <span> Booking Agent Report </span>
                    </div>
                    <div class="clearfix">
                    <br>
                    <div class="col-md-12">
                        <input type="hidden" id="filter" value="1">
                        <div class="table-responsive table-desi">
                            <table class="table table-condensed table-hover" id="bookingagentTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Agent Code</th>
                                        <th>Agent Name</th>
                                        <th>Count</th>
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
<script src="<?php echo static_url(); ?>assets/js/hotel_finance.js"></script>
<link href="<?php echo static_url(); ?>assets/select2/select2.css" rel="stylesheet" type="text/css" />
<script src="<?php echo static_url(); ?>assets/select2/select2.min.js" type="text/javascript"></script>
<script>
      var bookingagentTable = $('#bookingagentTable').dataTable({
        "bDestroy": true,
         dom: 'lBfrtip',
          buttons: [
              'copy', 'csv', 'excel', 'pdf', 'print'
          ],
        "ajax": {
          url : base_url+'backend/report/bookingAgentReportList',
          type : 'POST' 
          },

        "fnDrawCallback": function(settings){
               $('[data-toggle="tooltip"]').tooltip();          
        }
    });
</script>
<?php init_tail(); ?>

