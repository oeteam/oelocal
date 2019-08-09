<script src="<?php echo get_cdn_url(); ?>skin/js/booking.js"></script>
<div class="modal-dialog" style="height: auto;">
    	<!-- Modal content-->
  	<div class="modal-content">
    		<div class="modal-body">
	        <p>Do you want cancel this booking?</p>
	        <input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id'] ?>">
          <div class="row">
            <?php  if(count($cancelation)!=0) {

              $myDateTime = DateTime::createFromFormat('d/m/Y H:i', $view[0]->arrivaldate);
              $fromdate = $myDateTime->format('Y-m-d'); 
             ?>
            <div class="col-md-12">
              <h4 class="bold">Cancelation Policy</h4>
              <table class="table table-bordered table-hover">
                  <thead>
                      <tr style="background-color: #0074b9;color: white">
                        <th>Cancelled on or After</th>
                        <th>Cancelled on or Before</th>
                        <th>Cancellation Charge</th>
                      </tr>
                    </thead>
                    <tbody> 
                      <?php foreach ($cancelation as $Canckey => $Cancvalue) { 
                       ?>
                        <tr>
                          <td><?php 
                          if(date('Y-m-d' , strtotime('-'.($Cancvalue->daysFrom).' days', strtotime($fromdate))) < $view[0]->Created_Date) {
                            echo date('d/m/Y',strtotime($view[0]->Created_Date));
                          } else {
                            echo date('d/m/Y' , strtotime('-'.($Cancvalue->daysFrom).' days', strtotime($fromdate)));
                          }
                          ?></td>
                          <td><?php if(date('Y-m-d' , strtotime('-'.($Cancvalue->daysTo).' days', strtotime($fromdate))) < $view[0]->Created_Date) {
                              echo date('d/m/Y',strtotime($view[0]->Created_Date));
                            } else {
                              echo date('d/m/Y' , strtotime('-'.($Cancvalue->daysTo).' days', strtotime($fromdate)));
                            } ?>
                          <td><?php echo $Cancvalue->cancellationPercentage ?>% </td>
                        </tr>
                    <?php } } ?>
                    </tbody>
              </table>
            </div>
          </div>
          <div class="row" style="padding: 10px">
            <div class="col-md-12">
    	        <button type="button" id="cancel_transfer" class="ml10 btn btn-danger pull-right">Yes</button>
    	        <button type="button" data-dismiss="modal" id="cancel_reject" class="close_but btn btn-primary ml10 pull-right">No</button>
            </div>
          </div>
    		</div>
  	</div>
	</div>
