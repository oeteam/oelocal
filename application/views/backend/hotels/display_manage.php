<?php init_head(); ?>
<div class="sb2-2">
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp">
                    <div class="inn-title">
                        <span>Display Management</span>
                        <?php $displayMenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Display Management'); 
                            if (count($displayMenu)!=0 && $displayMenu[0]->create==1) { ?>
                                <span class="pull-right"><a href="<?php echo base_url(); ?>backend/hotels/displayEdit" class="btn-sm btn-primary">Add</a></span>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>
            <br>
            <div class="col-md-12">
                    <div class="tab-inn">
                        <div class="table-responsive table-desi">
                            <table class="table table-condensed table-hover" id="Display_list_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Agents</th>
                                        <th>Direct Hotels</th>
                                        <th>TBO Hotels</th>
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

<script src="<?php echo base_url(); ?>assets/js/hotel.js"></script>
<script type="text/javascript">
    var Display_list_table = $("#Display_list_table").dataTable({
        "bDestroy": true,
        "ajax": {
            url : base_url+'/backend/Hotels/Displaylist',
            type : 'POST'

        },
    "fnDrawCallback": function(settings){
    $('[data-toggle="tooltip"]').tooltip();          
    }
  });
</script>
<?php init_tail(); ?>
