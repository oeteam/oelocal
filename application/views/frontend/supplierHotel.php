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
.details {
  margin-top: 230px;
}
</style>
  
  <div class="clearfix"></div>
  <div class="row" style=" margin-top: 20px;">
    <div class="col-md-offset-2 col-md-8" style="height: 58px">
      <span class="msg"></span>
      <div class="clearfix"></div>
      <div class="content5">
          <div class="row">
            <div class="col-md-12" >
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
                <div class="clearfix"></div>
                <br>
                <div class="col-md-12 form-group">
                  <button class="pull-right btn btn-success ml10" data-toggle="modal" data-target="#myModal" onclick="addhotelmodal();">Add</button> 
                  <button class="pull-right btn btn-success ml10" id="search">Search</button>
                </div>         
             </div>
          </div>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="row" style=" margin-top: 42px;">
    <div class="col-md-offset-2 col-md-8">
      <h3>Hotel List</h3>
      <table class="table table-hover" id="hotel_table">
        <thead>
            <tr>
                <th><input type="checkbox" class="check-all"></th>
                <th>sl.no</th>
                <th>Hotel</th>
                <th>country</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Status</th>
                <th>Action</th>
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
  function edithotel(id) {
    $("#myModal").load(base_url+'HotelSupplier/addhotelmodal?hotels_edit_id='+id);
      $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
      });
  }
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
