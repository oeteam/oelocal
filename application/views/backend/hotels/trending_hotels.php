<?php init_head(); ?>
<div class="sb2-2">
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp">
                    <div class="inn-title">
                        <span>Trending Hotels</span>
                        <?php 
                            // $displayMenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Display Management'); 
                            // if (count($displayMenu)!=0 && $displayMenu[0]->create==1) { ?>
                                <span class="pull-right"><a href="<?php echo base_url(); ?>backend/hotels/trendingAdd" class="btn-sm btn-primary">Add</a></span>
                        <?php 
                            // } ?>
                    </div>
                    <div class="clearfix"></div>
            <br>
            <div class="col-md-12">
                    <div class="tab-inn">
                        <div class="table-responsive table-desi">
                            <table class="table table-condensed table-hover" id="trendingHotels_list_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Agents</th>
                                        <th>Hotels</th>
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
    var trendingHotels_list_table = $("#trendingHotels_list_table").dataTable();
</script>
<?php init_tail(); ?>
