<?php init_head(); 
?>
<style type="text/css">
.multi-select-trans1 .form-control {
    padding: 0px 0 !important;
  }
  .input-hide input {
    display: none ! important;
  }
  .input-hide li {
    display: none ! important;
  }

  #packagesupplier_table_wrapper .btn  {
      height: 27px;
      font-size: 12px;
      line-height: 28px;
      background: #009688;
      margin: 1px;
  }
</style>
<div class="sb2-2">
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp">
                    <div class="inn-title">
                        <span>Supplier list</span>
                        <span class="pull-right"><a href="#"  id="add_supplier" data-toggle="modal" data-target="#supplierModal" class="btn-sm btn-primary">Add Supplier</a></span>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mar_top_10">
                          <ul class="tabs" style="box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.16);">
                            <li class="tab col s2"><a class="Accepted active" href="#" onclick="filter('1')">Accepted</a></li>
                            <li class="tab col s2"><a class="Rejected" href="#" onclick="filter('0')">Blocked</a></li>
                          </ul>
                        </div>
                    </div>
                    <div class="clearfix">
                    <br>
                    <div class="col-md-12">
                    <div class="tab-inn">
                        <div class="table-responsive table-desi">
                            <table class="table table-condensed table-hover" id="packagesupplier_table">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>User Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Country</th>
                                        <th>City</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<div id="supplierModal" class="delete_modal modal fade col-md-12" role="dialog" style="max-height: 78%; width: 80%;">
 
</div>
<script type="text/javascript">
  filter(1);
  function filter(val) {
    var packagesupplier_table = $('#packagesupplier_table').dataTable({
          "bDestroy": true,
           dom: 'lBfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
          "ajax": {
              url : base_url+'/backend/package/packagesupplier_list?filter='+val,
              type : 'GET'
          },
      "fnDrawCallback": function(settings){
      $('[data-toggle="tooltip"]').tooltip();          
      }
    });
  }


  $("#add_supplier").click(function() {
    $("#supplierModal").load(base_url+'backend/Package/packagesupplierModal');
  })

  function editsupplierModal(id) {
    $("#supplierModal").load(base_url+'backend/Package/packagesupplierModal?id='+id);
  }


  function supplierpermissionfun(id,val) {
    if(val==1) {
      addToast("Unblocked Successfully","green");
    } else {
      addToast("Blocked Successfully","green");
    }
    
  $.ajax({
        dataType: 'json',
        type: 'post',
        url: base_url+'/backend/Package/supplierpermission?id='+id+'&&flag='+val,
        data: $('#room_facility_form').serialize(),
        cache: false,
        success: function (response) {
          if (val==1) {
            $(".Accepted").trigger('click');
          } else {
            $(".Rejected").trigger('click');
          }
        },
         error: function (xhr,status,error) {
           alert("Error: " + error);
        }
      });
  
}
</script>
<?php init_tail(); ?>

