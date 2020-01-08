<div class="modal-dialog ">
    <!-- Modal content-->
    <div class="modal-content" style="widths: 415px;">
      <div class="modal-body">
        <div class="row">
            <div class="form-group row col-md-12">
                <H4>Cancellation policy</H4>
            </div>
            <div class="form-group row col-md-12">
                <table class="table-responsive">
                    <thead>
                        <tr>
                            <td>Days From</td>
                            <td>Days To</td>
                            <td>Days in advance</td>
                            <td>Application</td>
                            <td>Cancellation Charge</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(count($view)!=0) {
                         foreach ($view as $key => $value) { ?>
                        <tr>
                            <td><?php echo $value->daysFrom; ?></td>
                            <td><?php echo $value->daysTo; ?></td>
                            <td><?php echo $value->daysInAdvance; ?></td>
                            <td><?php echo $value->application ?></td>
                            <td><?php echo $value->cancellationPercentage ?></td>
                        </tr>
                        <?php } } else { ?>
                            <tr>
                                <td colspan="5">
                                    Non Refundable
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            
            <div class="btn-toolbar pull-right">
                <button type="button" class="btn btn-default nBtn nclose" data-dismiss="canModal">X</button>
            </div>
        </div>
      </div>
    </div>
</div>

