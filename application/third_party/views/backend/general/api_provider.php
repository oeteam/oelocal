<?php init_head(); ?>
<style type="text/css">
  #providerListTable .btn  {
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
                        <span>API User List </span>
                    </div>
                    <div class="clearfix">
                    <br>
                    <div class="col-md-12 mar_top_10">
                      <ul class="tabs" style="box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.16);">
                        <li class="tab col s2"><a class="Pending active" onclick="filter(1)" href="#">API User</a></li>
                        <li class="tab col s2"><a class="Rejected" onclick="filter(0)" href="#">User</a></li>
                      </ul>
                    </div>
                    <div class="col-md-12">
                    <div class="tab-inn">
                        <div class="table-responsive table-desi">
                            <table class="table table-condensed table-hover" id="providerListTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>contact</th>
                                        <th>Email</th>
                                        <th>Disable/Enable</th>
                                        <th>Live</th>
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
<script>
  filter(1);
  function filter(val) {
   var providerListTable = $('#providerListTable').dataTable({
                "bDestroy": true,
                "ajax": {
                    url : base_url+'/backend/Common/apiuserList?filter='+val,
                    type : 'GET'
                },
                "fnDrawCallback": function(settings){
                  $('[data-toggle="tooltip"]').tooltip();          
                }
              });

  }
    function api_status(id,val) {
      $.ajax({
          dataType: 'json',
          type: "Post",
          url: base_url+'/backend/Common/apiStatus?id='+id+'&status='+val,
          success: function(data) {
            addToast("Updated Successfully","green");
          }
      });
    }

    function api_live(id,val) {
      $.ajax({
          dataType: 'json',
          type: "Post",
          url: base_url+'/backend/Common/apilive?id='+id+'&status='+val,
          success: function(data) {
            addToast("Updated Successfully","green");
          }
      });
    }
    // function extranetStatus(id) {
    //     var extranetStatus = $("#extranetStatus"+id).val();
    //     if($("#extranetStatus"+id).is(':checked')) { 
    //       var status = '1';
    //     } else {
    //       var status = '0';
    //     }
    //     $.ajax({
    //         dataType: 'json',
    //         type: "Post",
    //         url: base_url+'/backend/Agents/extranetStatus?id='+id+'&status='+status,
    //         success: function(data) {
    //           addToast("Updated Successfully","green");
    //         }
    //     });
    // }
</script>
<?php init_tail(); ?>

