<div class="modal-dialog" style="height: auto;">
    	<!-- Modal content-->
  	<div class="modal-content modal-content  col-md-9 col-md-offset-3">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <h4>Do you want to delete this !</h4>
          </div>
          <div class="modal-footer">
            <form action="<?php echo base_url(); ?>backend/Booking/deleteamendment" class="delete_id" id="delete_form">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>"> 
                <input type="hidden" id="delete_id" name="delete_id" value="<?php echo isset($_REQUEST['id']) ? $_REQUEST['id'] : '' ?>">
                <input type="hidden" id="bkid" name="bkid" value="<?php echo isset($_REQUEST['bkid']) ? $_REQUEST['bkid'] : '' ?>">
                <button type="button" onclick="commonDelete();" class="waves-effect waves-light btn-sm btn-danger pull-right">Delete</button>
            </form>
          </div>
        </div>
	</div>