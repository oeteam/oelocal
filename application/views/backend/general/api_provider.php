<?php init_head(); ?>
<div class="sb2-2">
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp">
                    <div class="inn-title">
                        <span>API Provided List </span>
                    </div>
                    <div class="clearfix">
                    <br>
                    <div class="col-md-12">
                    <div class="tab-inn">
                        <div class="table-responsive table-desi">
                            <table class="table table-condensed table-hover" id="providerListTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>contact</th>
                                        <th>Email</th>
                                        <th>Disable/Enable</th>
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
<script>
   // var providerListTable = $('#providerListTable').dataTable({
   //              "bDestroy": true,
   //              "ajax": {
   //                  url : base_url+'/backend/Agents/providerDetailsList',
   //                  type : 'GET'
   //              },
   //              "fnDrawCallback": function(settings){
   //                $('[data-toggle="tooltip"]').tooltip();          
   //              }
   //            });
   //  function extranetStatus(id) {
   //      var extranetStatus = $("#extranetStatus"+id).val();
   //      if($("#extranetStatus"+id).is(':checked')) { 
   //        var status = '1';
   //      } else {
   //        var status = '0';
   //      }
   //      $.ajax({
   //          dataType: 'json',
   //          type: "Post",
   //          url: base_url+'/backend/Agents/extranetStatus?id='+id+'&status='+status,
   //          success: function(data) {
   //            addToast("Updated Successfully","green");
   //          }
   //      });
   //  }
</script>
<?php init_tail(); ?>

