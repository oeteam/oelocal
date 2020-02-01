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

  #agent_table_wrapper .btn  {
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
                        <span>Package list</span>
                        <span class="pull-right"><a href="<?php echo base_url(); ?>backend/package/newpackage" class="btn-sm btn-primary">Add package</a></span>
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
                            <table class="table table-condensed table-hover" id="package_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Supplier</th>
                                        <th>From date</th>
                                        <th>To date</th>
                                        <th>Country</th>
                                        <th>Pax</th>
                                        <th title="Adult Cost">A.c</th>
                                        <th title="Child Cost">C.c</th>
                                        <th title="Adult Selling">A.s</th>
                                        <th title="Child Selling">C.s</th>
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
<script type="text/javascript">
  filter(1);
  function filter(val) {
    var package_table = $('#package_table').dataTable({
          "bDestroy": true,
           dom: 'lBfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
          "ajax": {
              url : base_url+'/backend/package/package_list?filter='+val,
              type : 'GET'
          },
      "fnDrawCallback": function(settings){
      $('[data-toggle="tooltip"]').tooltip();          
      }
    });
  }

  function editpackageModal(id) {
    alert("Under construction");
  }

  function packagedeletefun(id) {
    deletepopupfun(base_url+"backend/Package/packagedelete",id);
  }
  function commonDelete() {
      $.ajax({
      dataType: 'json',
      type: "POST",
      url: $("#delete_form").attr("action"),
      data: $("#delete_form").serialize(),
      cache: false,
      success: function (response) {
        close_delete_modal();
        $(".Rejected").trigger("click");
      }
    });
  }

</script> 
<?php init_tail(); ?>

