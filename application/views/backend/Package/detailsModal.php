  <style type="text/css">
      .btn-small {
        width: 21px;
        height: 25px;
        background: #255a79;
        display: block;
        text-align: center;
        color: white;
        line-height: 25px;
        border-radius: 7px;
        float: left;
        margin-right: 5px;
        cursor: pointer;
      }
      .bg-rebeccapurple {
         background: rebeccapurple;
      }
      .bg-red {
        background: red;
      }
      
  </style>
   <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close_edit_modal" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Details</h4>
            </div>
            <div class="modal-body">
                <small class="right details-validate"></small>
                <input type="hidden" name="trid" id="trid" value="<?php echo $trid ?>">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="overview">Overview :</label><span>*</span>
                        <textarea class="form-control" name="overview" id="overview" ><?php echo isset($overview)?$overview:"" ?></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="address">Address :</label><span>*</span>
                        <textarea class="form-control" name="address" id="address"><?php echo isset($address)?$address:"" ?></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="duration">Duration :</label><span>*</span>
                        <input type="text" class="form-control" name="duration" id="duration" value="<?php echo isset($duration)?$duration:''?>">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="inclusion">Inclusions :</label><span>*</span>
                        <textarea class="form-control" name="inclusion" id="inclusion"><?php echo isset($inclusion)?$inclusion:"" ?></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exclusion">Exclusions :</label><span>*</span>
                        <textarea class="form-control" name="exclusion" id="exclusion"><?php echo isset($exclusion)?$exclusion:"" ?></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="terms">Terms and Conditions :</label><span>*</span>
                        <textarea class="form-control" name="terms" id="terms"><?php echo isset($terms)?$terms:"" ?></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="hours">Operational Hours</label><span>*</span>
                        <textarea class="form-control" name="hours" id="hours"><?php echo isset($hours)?$hours:"" ?></textarea>
                    </div>
                </div>
                <div class="row"><br>
                    <h5>Booking Policy</h5><br>
                    <div class="form-group col-md-6">
                        <label for="cancelPolicy">Cancellation Policy</label><span>*</span>
                        <textarea class="form-control" name="cancelPolicy" id="cancelPolicy"><?php echo isset($cancelPolicy)?$cancelPolicy:"" ?></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="childPolicy">Child Policy</label><span>*</span>
                        <textarea class="form-control" name="childPolicy" id="childPolicy"><?php echo isset($childPolicy)?$childPolicy:"" ?></textarea>
                    </div>
                </div>
                <div class="row"><br>
                    <h5>Images</h5><br>
                    <div class="form-group col-md-12">
                        <label for="images">Images</label><span>*</span>
                        <input type="file" class="filepond" id="images" name="images[]" data-max-files="3" />
                </div>
                <div class="row">
                    <div class="btn-toolbar pull-right">
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background-color: unset"><br>
                <input type="button" id="submit_details" class="no-border btn-sm btn-success" data-dismiss="modal" value="Update">
            </div>
        </div>
    </div>
    

<script type="text/javascript">
$('#overview').trumbowyg();
$('#exclusion').trumbowyg();
$('#inclusion').trumbowyg();
$('#terms').trumbowyg();
$('#hours').trumbowyg();
$('#childPolicy').trumbowyg();
$('#cancelPolicy').trumbowyg();
$(function(){
    FilePond.registerPlugin(
      FilePondPluginImageExifOrientation,
      FilePondPluginImagePreview
    );
    // Turn input element into a pond
    $('.filepond').filepond();

    // Turn input element into a pond with configuration options
    $('.filepond').filepond({
        allowMultiple: true
    });

    // Set allowMultiple property to true
    $('.filepond').filepond('allowMultiple', true);
});
$("#submit_details").click(function() {
    var trid = $('#trid').val();
    $("#"+trid).find('td:eq(12)').find('textarea[name="overview[]"]').val($('#overview').val());
    $("#"+trid).find('td:eq(12)').find('textarea[name="address[]"]').val($('#address').val());
    $("#"+trid).find('td:eq(12)').find('input[name="duration[]"]').val($('#duration').val());
    $("#"+trid).find('td:eq(12)').find('textarea[name="inclusion[]"]').val($('#inclusion').val());
    $("#"+trid).find('td:eq(12)').find('textarea[name="exclusion[]"]').val($('#exclusion').val());
    $("#"+trid).find('td:eq(12)').find('textarea[name="terms[]"]').val($('#terms').val());
    $("#"+trid).find('td:eq(12)').find('textarea[name="hours[]"]').val($('#hours').val());
    $("#"+trid).find('td:eq(12)').find('textarea[name="cancelPolicy[]"]').val($('#cancelPolicy').val());
    $("#"+trid).find('td:eq(12)').find('textarea[name="childPolicy[]"]').val($('#childPolicy').val());
});

</script>