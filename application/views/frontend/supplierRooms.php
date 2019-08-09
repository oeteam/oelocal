<?php init_front_head_supplier(); ?>
<script src="<?php echo get_cdn_url(); ?>skin/js/booking.js"></script>
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
              <label>Country</label>
              <input type="text" name="co" class="form-control" id="co">
            </div>
            <div class="col-md-2 form-group">
              <label>State</label>
              <input type="text" class="form-control">
            </div>
            <div class="col-md-2 form-group">
              <label>Cityname</label>
              <input type="text" name="city" class="form-control" id="city">
            </div>
            <div class="col-md-2 form-group">
              <label>Prov.</label>
              <input type="text" name="prov" class="form-control" id="prov">
            </div>
            <div class="col-md-2 form-group">
              <label>Hotelname</label>
              <select class="form-control">
                <option>Hotelname</option>
              </select>
            </div>
             <div class="col-md-2 form-group">
              <label>Room ID</label>
              <select class="form-control">
                <option>Room ID</option>
              </select>
            </div>
          </div>
          <div class="clearfix"></div>
                <br>
          <div class="col-md-12">
          <div class="col-md-12 form-group">
            <button class="pull-right btn btn-success ml10" data-toggle="modal" data-target="#myModal" onclick="addhotelmodal();">Add</button> 
            <button class="pull-right btn btn-success ml10" id="search">Search</button>
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
