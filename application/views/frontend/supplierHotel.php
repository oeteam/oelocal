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
                  <select class="form-control" name="HotelSelect" id="HotelSelect">
                    <option value="">Select Hotel</option>
                    <?php foreach ($hotels as $value) { ?>
                      <option value="<?php echo $value->id ?>"><?php echo $value->hotel_name?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-md-2 form-group">
                  <label>Country</label>
                  <select name="con" id="con" class="form-control" onchange ="ConSelect();">
                    <option value=""> Country </option>
                    <?php $count=count($contry);
                    for ($i=0; $i <$count ; $i++) { ?>
                    <option value="<?php echo $contry[$i]->id;?>" sortname="<?php echo  $contry[$i]->sortname; ?>"><?php echo $contry[$i]->name; ?></option>
                    <?php  } ?>
                  </select>
                </div>
                <div class="col-md-2 form-group">
                  <label>State</label>
                  <input type="hidden" id="hiddenSt">
                    <div class="multi-select-mod multi-select-trans multi-select-trans1">
                    <select name="state" id="state"  class="form-control">
                    <option value="">Select</option>
                    </select> 
                  </div>
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
                  <select class="form-control" name="starRate" id="starRate">
                    <option value="">Select</option>
                    <option value="all">All</option>
                    <option value="5">5</option>
                    <option value="4">4</option>
                    <option value="3">3</option>
                    <option value="2">2</option>
                    <option value="1">1</option>
                    <option value="10">Apartment</option>
                  </select>
                </div>
                <div class="clearfix"></div>
                <br>
                <div class="col-md-12 form-group">
                  <button class="pull-right btn btn-success ml10" data-toggle="modal" data-target="#myModal" onclick="addhotelmodal();">Add</button> 
                  <button class="pull-right btn btn-success ml10" id="hotelSearch">Search</button>
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
<div id="delModal" class="delete_modal modal">
        <div class="modal-content modal-content  col-md-6 col-md-offset-3">
          
            <button type="button" class="close" data-dismiss="modal">&times;</button>

          <div class="modal-body">
            <h4>Do you want to delete this !</h4>
            <form action="<?php echo base_url(); ?>backend/" class="delete_id" id="delete_form">
                <input type="hidden" id="delete_id" name="delete_id" value="<?php echo isset($_REQUEST['id']) ? $_REQUEST['id'] : '' ?>">
                <button type="button" onclick="commonDelete();" class="waves-effect waves-light btn-sm btn-danger pull-right">Delete</button><br><br>
            </form>
          </div>
        </div>
      </div>
<script>
  function edithotel(id) {
    $("#myModal").load(base_url+'HotelSupplier/addhotelmodal?hotels_edit_id='+id);
      $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
      });
  }
  function viewhotel(id) {
    $("#myModal").load(base_url+'HotelSupplier/hotel_detail_view?id='+id);
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
  function deletehotelper(id) {
    deletepopupfun(base_url+"HotelSupplier/delete_hotelper",id);
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
  $("#hotelSearch").click(function() {
        var Con       = $("#con option:selected").val();
        var state       = $("#state option:selected").val();
        var hotelid      = $("#HotelSelect option:selected").val();
        var city = $('#citys').val();
        var prov = $("#prov").val();
        var rating = $("#starRate").val();
        var hotel_table = $('#hotel_table').dataTable({
          "pageLength": 100,
          "ordering":false,
          "bDestroy": true,
          "ajax": {
            url : base_url+'HotelSupplier/hotelsearch?hotel='+hotelid+
            '&con='+Con+'&state='+state+'&city='+city+'&prov='+prov+'&rating='+rating,
            type : 'POST' 
            },

          "fnDrawCallback": function(settings){
                 $('[data-toggle="tooltip"]').tooltip();          
          },
        }); 
            
          
  });

 </script>
 <script src="<?php echo get_cdn_url(); ?>skin/js/supplier.js"></script>
<?php init_front_head_footer(); ?> 
