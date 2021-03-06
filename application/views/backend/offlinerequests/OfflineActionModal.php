<div class="modal-content modal-content  col-md-6 col-md-offset-3">
  <form id="offlineTourRequestActionForm" method="post">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>"> 
    <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
    <input type="hidden" name="val" value="<?php echo $_REQUEST['val']; ?>">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
  </div>
  <div class="modal-body">
    <?php if ($_REQUEST['val']==0) { ?>
      <h4>Do you want to Cancel this request!</h4>
    <?php } else { ?>
      <h4>Do you want to accept this request!</h4>
      <br>
        <div class="row">
          <input type="hidden" name="tour_type" id="tour_type" value="<?php echo $view[0]->tour_type; ?>">
            <input type="hidden" name="tdate" id="tdate" value="<?php echo $view[0]->tdate; ?>">
            <input type="hidden" name="sellingprice" id="sellingprice" value="<?php echo $view[0]->sellingprice; ?>">
          <div class="col-md-6 form-group">
            <input type="number" name="conNumber" id="conNumber" class="form-control" placeholder="Confirmation Number">
          </div>
          <div class="col-md-6 form-group">
            <input type="text" name="conName" id="conName" class="form-control" placeholder="Confirmation Name">
          </div>
        </div>
   <?php  } ?>
  </div>
  <div class="modal-footer">
    <?php if ($_REQUEST['val']==0) { ?>
      <button class="btn-sm btn-danger" data-dismiss="modal">No</button>
      <input type="button" class="btn-sm btn-success" id="CancelClick" value="Yes">
    <?php } else { ?>
      <button class="btn-sm btn-danger" data-dismiss="modal">No</button>
      <input type="button" class="btn-sm btn-success" id="AcceptClick" value="Yes">
   <?php  } ?>
  </div>
</div>
  </form>
<script type="text/javascript">
  $("#AcceptClick").click(function() {
      var conNumber = $("#conNumber").val();
      var conName = $("#conName").val();
      var tour_type = $("#tour_type").val();
      var tdate = $("#tdate").val();
      var sellingprice = $("#sellingprice").val();
      if(tour_type=="" || tdate=="" || sellingprice=="" || sellingprice=='0') {
          addToast("Please edit the requests and add both tour and price details","orange");
          $("#tour_type").focus();
      } else if (conNumber=="") {
        addToast("Confirmation Number field is required!","orange");
        $("#conNumber").focus();
      } else if(conName=="") {
        addToast("Confirmation Name field is required!","orange");
        $("#conName").focus();
      } else {
        addToast("Mail is sending. Please wait for few moments","green");
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: base_url+'backend/offlinerequest/OfflineActionSubmit',
            data : $("#offlineTourRequestActionForm").serialize(),
            cache: false,
            success: function(response) {
              addToast("Accepted Successfully","green");
              document.location.reload(true);
            },
           error: function (xhr,status,error) {
             alert("Error: " + error);
          }
        });
      }
  });
  $("#CancelClick").click(function() {
    $.ajax({
          dataType: 'json',
          type: "POST",
          url: base_url+'backend/offlinerequest/OfflineActionSubmit',
          data : $("#offlineTourRequestActionForm").serialize(),
          cache: false,
          success: function(response) {
            addToast("Cancelled Successfully","green");
            document.location.reload(true);
          },
         error: function (xhr,status,error) {
           alert("Error: " + error);
        }
      });
  });
</script>