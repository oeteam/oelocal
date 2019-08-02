<?php init_front_head_dashboard(); ?>
<style>
    html{
        overflow:scroll ! important;
    }
</style>
<div class="sb2-2">
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp">
					<div class="row">
						<div class="col-md-12">
							<h3>Load Credit Amount</h3>	<br>
							<p>Your credit amount is <?php echo $credit[0]->Credit_amount ?></p>						
						</div>
						<div class="clearfix"></div>
						</br>
						</br>
						<div class="col-md-12">
							<form method="post" id="creditamountform">
						        <div class="row">
				                    <div class="col-md-6 form-group">
					                <label>Credit Amount</label>
					                <input type="number" name="amount" class="form-control" id="amount" placeholder="Enter amount">
					                <span class="amt_error"></span>
					              	</div>
					              	<div class="col-md-6 form-group"><br>
                					<button type="button" class="btn btn-success ml10" id="loadCreditbutton" style="margin-top: 5px">Load Credit</button>
					              	</div>
				            	</div>
				            </form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div> 
</div>
<script> 
	$("#loadCreditbutton").click(function() {
      var amt = $("input[name='amount']").val();
        if(amt=="0" || amt=="") {
            $(".amt_error").text("(Please enter the amount)*");
            $(".amt_error").css('color','red');
            $("#amount").focus();
        } else {
        	$("#loadCreditbutton").attr('disabled');
            $("#creditamountform").attr("action",base_url+"profile/loadcreditamount");
            $("#creditamountform").submit();
        }
    });
</script>
