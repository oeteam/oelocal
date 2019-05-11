<?php init_head(); ?>
<script src="<?php echo base_url(); ?>assets/js/review.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<div class="sb2-2">
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp">
                    <div class="inn-title">
                        <span>Review </span><span class="pull-right"><a href="<?php echo base_url(); ?>backend/reviews" class="btn-sm btn-primary">Back</a></span>
                    </div>
                    <div class="tab-inn">
                         <input type="hidden" name="edit_id" value="<?php echo isset($edit[0]->id) ? $edit[0]->id : '' ?>"> 
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="username">Username</label>
                                    <input id="username" name="username" type="text" class="form-control"  value="<?php echo isset($edit[0]->Username) ? $edit[0]->Username : '' ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="evaluation">Evaluation</label>
                                    <input type="text" class="form-control" value="<?php echo isset($edit[0]->Evaluation) ? $edit[0]->Evaluation : '' ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="title">Title</label>
                                    <input id="title" name="title" type="text" class="form-control" value="<?php echo isset($edit[0]->Title) ? $edit[0]->Title : '' ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="comment">Comment</label>
                                    <input id="comment" name="comment" type="text" class="form-control" value="<?php echo isset($edit[0]->Comment) ? $edit[0]->Comment : '' ?>">
                                </div>
                            </div>
                            <div class="row">
                              <div class="form-group col-md-6">
                                  	<label for="cleanliness">Cleanliness</label>
                                      <?php if(isset($edit[0]->Cleanliness)) {
                                        $cleanliness_arr = explode(";",$edit[0]->Cleanliness);
                                        $cleanliness = $cleanliness_arr[1];
                                      } else {
                                        $cleanliness = '';
                                      } ?>
                                      <input id="cleanliness" name="cleanliness" type="range" class="validate" min="0" max="5" step="0.1" value ="<?php echo $cleanliness ?>">
                               </div>
                               <div class="form-group col-md-6">
                                  	<label for="room_comfort">Room Comfort</label>
                                    <?php if(isset($edit[0]->Room_Comfort)) {
                                        $room_comfort_arr = explode(";",$edit[0]->Room_Comfort);
                                        $room_comfort = $room_comfort_arr[1];
                                      } else {
                                        $room_comfort = '';
                                      } ?>
                                      <input id="room_comfort" name="room_comfort" type="range" class="validate"  min="0" max="5" step="0.1" value ="<?php echo $room_comfort ?>">
                               </div>
                               <div class="form-group col-md-6">
                                  	<label for="location">Location</label>
                                    <?php if(isset($edit[0]->Location)) {
                                        $location_arr = explode(";",$edit[0]->Location);
                                        $location = $location_arr[1];
                                      } else {
                                        $location = '';
                                      } ?>
                                      <input id="location" name="location" type="range" class="validate" min="0" max="5" step="0.1" value ="<?php echo $location ?>">
                               </div>
                                <div class="form-group col-md-6">
                                  	<label for="service_staff">Service & Staff</label>
                                    <?php if(isset($edit[0]->Service_Staff)) {
                                        $servicestaff_arr = explode(";",$edit[0]->Service_Staff);
                                        $servicestaff = $servicestaff_arr[1];
                                      } else {
                                        $servicestaff = '';
                                      } ?>
                                      <input id="service_staff" name="service_staff" type="range" class="validate"  min="0" max="5" step="0.1" value ="<?php echo $servicestaff ?>">
                               </div>
                                <div class="form-group col-md-6">
                                  	<label for="sleep_quality">Sleep Quality</label>
                                    <?php if(isset($edit[0]->Sleep_Quality)) {
                                        $sleepquality_arr = explode(";",$edit[0]->Sleep_Quality);
                                        $sleepquality = $sleepquality_arr[1];
                                      } else {
                                        $sleepquality = '';
                                      } ?>
                                      <input id="sleep_quality" name="sleep_quality" type="range" class="validate"  min="0" max="5" step="0.1" value ="<?php echo $sleepquality ?>">
                               </div>
                               <div class="form-group col-md-6">
                                  	<label for="value_price">Value For Price</label>
                                     <?php if(isset($edit[0]->Value_Price)) {
                                        $valueprice_arr = explode(";",$edit[0]->Value_Price);
                                        $valueprice = $valueprice_arr[1];
                                      } else {
                                        $valueprice = '';
                                      } ?>
                                      <input id="value_price" name="value_price" type="range" class="validate"  min="0" max="5" step="0.1" value ="<?php echo isset($edit[0]->Value_Price) ? $edit[0]->Value_Price : '' ?>">
                               </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
  $(window).load(function() {
    $(".validate").trigger("change");
  })
</script>
<?php init_tail(); ?>