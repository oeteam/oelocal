  <?php init_front_head_supplier(); ?>
<script src="<?php echo static_url(); ?>skin/js/booking.js"></script>
<style>
 .nav-tabs li {
  background: black;
 }
 .myTab2pos {
  padding : 10px;
 }
 .content5 {
    width: 100%;
    background-color: #e8e8e8;
    font-size: 11px;
    padding-top: 10px;
    padding-bottom: 10px;
}
.form-control {
    font-size: 11px;
    height: 29px;
}
.form-group {
    margin-bottom: 2px;
}
.btn {
  font-size: 11px;
}
</style>

      <div class="clearfix"></div>
      <div class="row" style=" margin-top: 20px;">
        <div class="col-md-offset-2 col-md-8" style="height: 58px">
        <div class="content5">
          <div class="row">
            <div class="col-md-12">
               <div class="col-md-2 form-group">
                  <label>Hotelname</label>
                  <select class="form-control">
                    <option>Hotelname</option>
                  </select>
                </div>
                <div class="col-md-2 form-group">
                  <label>Country</label>
                  <input type="text" name="co" class="form-control" id="co">
                </div>
                <div class="col-md-2 form-group">
                  <label>State</label>
                  <input type="text" class="form-control">
                </div>
                
                <div class="col-md-2 form-group">
                  <label>Cityname</label>
                  <input type="text" name="city" class="form-control" id="citys">
                </div>
                <div class="col-md-2 form-group">
                  <label title="Property Name">Prov.</label>
                  <input type="text" name="prov" class="form-control" id="prov">
                </div>
                
                <div class="col-md-2 form-group">
                  <label>Rating</label>
                  <select class="form-control">
                    <option>All</option>
                  </select>
                </div>

                <div class="col-md-2 form-group">
                  <label>Booking No.</label>
                  <input type="text" name="label" class="form-control" id="label">
                </div>
                <div class="col-md-2 form-group">
                  <label>Reference No.</label>
                  <input type="text" name="ctrip" class="form-control" id="ctrip">
                </div>
                <div class="col-md-2 form-group">
                  <label>Date</label>
                  <select class="form-control">
                    <option>All</option>
                  </select>
                </div>
                <div class="col-md-2 form-group">
                  <label>Check In</label>
                  <input type="text" name="ctrip" class="form-control" id="ctrip">
                </div>
                <div class="col-md-2 form-group">
                  <label>Check out</label>
                  <input type="text" name="ctrip" class="form-control" id="ctrip">
                </div>
                
             </div>
            <div class="clearfix"></div>
            <div class="col-md-12">
            <div class="col-md-12">
              <button class="pull-right btn btn-success" id="search">Search</button>
            </div> 
            </div> 
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</script>
<?php init_front_head_footer(); ?> 
