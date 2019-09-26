<?php init_head(); ?>
<div class="sb2-2">
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp">
                    <div class="inn-title">
                        <span>Home Page Banner</span>
                        <?php 
                            // $displayMenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Display Management'); 
                            // if (count($displayMenu)!=0 && $displayMenu[0]->create==1) { ?>
                                <span class="pull-right"><a href="<?php echo base_url(); ?>backend/hotels/homebannerAdd" class="btn-sm btn-primary">Add</a></span>
                        <?php 
                            // } ?>
                    </div>
                    <div class="clearfix"></div>
            <br>
            <div class="col-md-12">
                    <div class="tab-inn">
                        <div class="table-responsive table-desi">
                            <table class="table table-condensed table-hover" id="homebanners_list_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Hotels</th>
                                        <th>Set</th>
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

<script src="<?php echo static_url(); ?>assets/js/hotel.js"></script>
<script type="text/javascript">
    var homebanners_list_table = $("#homebanners_list_table").dataTable({
        "bDestroy": true,
        "ajax": {
            url : base_url+'/backend/Hotels/Bannerlist',
            type : 'POST'

        },
        "fnDrawCallback": function(settings){
            $('[data-toggle="tooltip"]').tooltip();          
        }
    });
</script>
<?php init_tail(); ?>
