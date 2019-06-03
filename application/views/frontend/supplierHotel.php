<?php init_front_head_supplier(); ?>
<style>
 .nav-tabs li {
  background: black;
 }
 .myTab2pos {
  padding : 10px;
 }
 .content5 {
    width: 100%;
    margin-top: 39px;
    background-color: #e8e8e8;
    font-size: 11px;
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
.details {
  margin-top: 230px;
}
</style>
  <div class="row" style="background: black">
    <div class="col-md-offset-2 col-md-8" style="height: 58px">

      <ul class="nav nav-tabs myTab2pos">
          <li>
              <a href="<?php echo base_url('HotelSupplier')?>">
                  Booking
              </a>
          </li>
          <li class="active">
              <a href="<?php echo base_url('HotelSupplier/hotels')?>">              
                Hotels
              </a>
          </li>
          <li>
              <a href="<?php echo base_url('HotelSupplier/rooms')?>">              
                Rooms
              </a>
          </li>
      </ul>
      <div class="clearfix"></div>
      <span class="msg"></span>
      <div class="clearfix"></div>
      <div class="content5">
          <div class="row">
            <div class="col-md-12">
                <div class="col-md-2 form-group">
                  <label>Co</label>
                  <input type="text" name="co" class="form-control" id="co">
                </div>
                <div class="col-md-2 form-group">
                  <label>Prov.</label>
                  <input type="text" name="prov" class="form-control" id="prov">
                </div>
                <div class="col-md-2 form-group">
                  <label>Cityname</label>
                  <input type="text" name="city" class="form-control" id="citys">
                </div>
                <div class="col-md-2 form-group">
                  <label></label>
                  <select class="form-control">
                    <option>Hotelname</option>
                  </select>
                </div>
                <div class="col-md-2 form-group">
                  <label></label>
                  <input type="text" class="form-control">
                </div>
                <div class="col-md-2 form-group">
                  <label>Rating</label>
                  <select class="form-control">
                    <option>All</option>
                  </select>
                </div>
                <div class="col-md-2 form-group">
                  <label>label</label>
                  <input type="text" name="label" class="form-control" id="label">
                </div>
                <div class="col-md-2 form-group">
                  <label>CTripPreBuy</label>
                  <input type="text" name="ctrip" class="form-control" id="ctrip">
                </div>
                <div class="col-md-2 form-group">
                  <label>Deliver By</label>
                  <select class="form-control">
                    <option>All</option>
                  </select>
                </div>
                <div class="col-md-2 form-group">
                  <label>Auto Deliver</label>
                  <select class="form-control">
                    <option>All</option>
                  </select>
                </div>
                <div class="col-md-2 form-group">
                  <label>Auto Accept w.Return</label>
                  <select class="form-control">
                    <option>All</option>
                  </select>
                </div>
                <div class="col-md-2 form-group">
                  <label>Auto Reject w.Return</label>
                  <select class="form-control">
                    <option>All</option>
                  </select>
                </div>
                <div class="col-md-2 form-group">
                  <label>Shut Down CTrip</label>
                  <select class="form-control">
                    <option>All</option>
                  </select>
                </div>
                <div class="col-md-2 form-group">
                  <label>CTrip</label>
                  <select class="form-control">
                    <option>All</option>
                  </select>
                </div>
                <div class="col-md-2 form-group">
                  <label>Qunar</label>
                  <select class="form-control">
                    <option>All</option>
                  </select>
                </div>
                <div class="col-md-2 form-group">
                  <label>Distribution AStatus</label>
                  <select class="form-control">
                    <option>All</option>
                  </select>
                </div>
                <div class="col-md-2 form-group">
                  <label>B2B</label>
                  <select class="form-control">
                    <option>All</option>
                  </select>
                </div>
                <div class="col-md-offset-9 col-md-2 form-group">
                  <button class="pull-right btn btn-success ml10" id="search">Search</button>
                </div> 
                <div class="col-md-1 form-group">
                  <button class="pull-right btn btn-success ml10" data-toggle="modal" data-target="#myModal" onclick="addhotelmodal();">Add</button> 
                </div>         
             </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="row">
      <div class="col-md-offset-2 col-md-8 details">
        <h3>Hotel List</h3>
        <table class="table table-hover" id="hotel_table">
          <thead>
              <tr>
                  <th>Hotel Id</th>
                  <th>Hotel</th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th>Country</th>
                  <th>View</th>
                  <th>Edit</th>
                  <th>Delete</th>
              </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
<div id="myModal" class="modal fade" role="dialog">
</div>
<script>
  function addhotelmodal() {
    $("#myModal").load(base_url+'HotelSupplier/addhotelmodal');
    $('#myModal').modal({
        backdrop: 'static',
        keyboard: false
    });
  }
  $(document).ready(function() {
    var hotel_table = $('#hotel_table').dataTable({
          "bDestroy": true,
          "ajax": {
              url : base_url+'HotelSupplier/hotel_list',
              type : 'GET'
          },
       "fnDrawCallback": function(settings){
          $('[data-toggle="tooltip"]').tooltip();          
        }
    });
  });
 </script>
<?php init_front_head_footer(); ?> 
