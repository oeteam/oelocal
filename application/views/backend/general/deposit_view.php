<?php init_head(); ?>
<div class="sb2-2">
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp">
                    <div class="inn-title">
                        <span>API User Deposit Details</span>
                        <span class="pull-right"><a href="<?php echo base_url(); ?>backend/common/api_provider" class="btn-sm btn-primary">Back</a></span>
                        <span class="pull-right" style="margin-right: 5px;"><a href="#" data-toggle="modal" data-target="#deposit_add_out_add" class="btn-sm btn-success">Add</a></span>
                    </div>
                    <hr>
                    <div class="tab-inn">
                        <div class="table-responsive table-desi">
                            <table class="table table-condensed table-hover"  id="apiuser_deposit_detail">
                            	<input type="hidden" name="apiuser_id" id="apiuser_id" value="<?php echo($_REQUEST['id']) ?>">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Deposit amount</th>
                                        <th>Total</th>
                                        <th>Deposit date</th>
                                        <th>Deposited from</th>
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
<div class="delete_modal modal fade" id="deposit_add_out_add" role="dialog">
  <div class="modal-dialog ">
 <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close close_edit_modal" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">Add New Details</h4>
    </div>
    <div class="modal-body">
        <div class="inn-title">
        </div>
         </br>
	    <div class="row" style="margin-top: -8%;">
	        <form action="add_deposit" method="post" id="add_deposit" name="add_deposit" enctype="multipart/form-data">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">  
	            <input type="hidden" value="<?php echo isset($_REQUEST['id'])?$_REQUEST['id'] : ''?> " name="apiuser_id">
	            <input type="hidden" value="<?php echo $view[0]->deposit_amount ?>" name="deposit">
	             <div class="form-group col-md-12">
	                <label for="amount">Deposit Amount</label>
	                <input id="amount" name="amount" type="text" class="form-control" value="">
	            </div>
	        </form>
	    </div>
    </div>
    <div class="modal-footer">
        <input type="button" id="deposit_button" class="btn-sm btn-success" value="Submit">
    </div>
 </div>
  </div>
</div>
<script>
    var apiuser_id =  $("#apiuser_id").val();
    var apiuser_deposit_detail = $('#apiuser_deposit_detail').dataTable({
            "bDestroy": true,
            "ajax": {
                url : base_url+'/backend/common/apiuser_deposit_view_tbl?id='+apiuser_id,
                type : 'GET'
            },
        "fnDrawCallback": function(settings){
        $('[data-toggle="tooltip"]').tooltip();          
        }
    });
    $('#deposit_button').click(function (e) {
        var apiuser_id = $("#apiuser_id").val();
        var amount   = $("#amount").val();
        if(amount==""){
            addToast('Deposit amount Is Required',"orange");
            $("#amount").focus();
        }
        else {
          $("#add_deposit").submit();
          addToast("Deposit amount added Successfully","green");
        }    
    }); 
</script>
<?php init_tail(); ?>
