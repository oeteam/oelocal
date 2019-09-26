<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo static_url(); ?>assets/css/prettify.css" />
<style type="text/css">
  .multi-select-trans .select-wrapper input.select-dropdown, .dropdown-content.select-dropdown.multiple-select-dropdown{
    display: none !important;
  }
  .multi-select-trans .multiselect.dropdown-toggle.btn.btn-default {
    border-color: transparent !important;
    transform: translateY(-8px) !important;
    padding: 0 !important;
    overflow: hidden !important;
  }
  .multi-select-trans .form-control {
    padding: 6px 0 !important;
  }
  .multi-select-trans1 .form-control {
    padding: 0px 0 !important;
  }
  .input-hide input {
    display: none ! important;
  }
  .input-hide li {
    display: none ! important;
  }

  .select-wrapper.multi-select-trans2 {
    border: none !important;
    box-shadow: none !important;
    padding: 6px 0px ! important;
  }
  .multi-select-trans2  .select-dropdown ,.select-wrapper.multi-select-trans2 .caret{
    display: none ! important;
  }

</style>

<div class="sb2-2">
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp">
                    <div class="inn-title">
                        <?php if (isset($edit[0]->id) && $edit[0]->id!="") { ?>
                        <span>Trending Hotels Edit  </span>
                        <span class="pull-right"><a href="<?php echo base_url(); ?>backend/hotels/trending_hotels" class="btn-sm btn-primary">Back</a></span>
                        <?php } else { ?>
                        <span>Trending Hotels Add  </span>
                        <span class="pull-right"><a href="<?php echo base_url(); ?>backend/hotels/trending_hotels" class="btn-sm btn-primary">Back</a></span>
                        <?php }?>
                    </div>
                    <div class="tab-inn">
                        <form method="post" action="" name="trendForm" id="trendForm" enctype="multipart/form-data"> 
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>"> 
                            <input type="hidden" name="trendEdit" value="<?php echo isset($edit[0]->id) ? $edit[0]->id : '' ?>">
                           
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-xs-5">
                                            <label>Set 1 Hotels</label>
                                            <select name="hotelone_select[]"  id="hotelone_undo_redo" class="form-control multi-select-trans2"  size="13" multiple="multiple">
                                            <?php $count=count($view);
                                                for ($i=0; $i <$count ; $i++) {  ?>
                                                <option value="<?php echo $view[$i]->id; ?>"><?php echo $view[$i]->hotel_name; ?></option>
                                            <?php  } ?>
                                            </select>
                                                           
                                        </div>
                                        <div class="col-xs-2">
                                            <button type="button" id="hotelone_undo_redo_undo" class="mt-6 no-border btn-sm btn-primary btn-block">Undo</button>
                                            <button type="button"  id="hotelone_undo_redo_rightAll" class="no-border btn-sm btn-default btn-block"><i class="fa fa-forward"></i></button>
                                            <button type="button" id="hotelone_undo_redo_rightSelected"  class="no-border btn-sm btn-default btn-block"><i class="fa fa-chevron-right"></i></button>
                                            <button type="button" id="hotelone_undo_redo_leftSelected" class="no-border btn-sm btn-default btn-block"><i class="fa fa-chevron-left"></i></button>
                                            <button type="button" id="hotelone_undo_redo_leftAll" class="no-border btn-sm btn-default btn-block"><i class="fa fa-backward"></i></button>
                                            <button type="button" id="hotelone_undo_redo_redo" class="no-border btn-sm btn-primary btn-block">Redo</button>
                                        </div>
                                        
                                        <div class="col-xs-5">
                                            <label>Selected Hotels</label>
                                            <select name="hotelone[]" class="form-control multi-select-trans2"  id="hotelone_undo_redo_to"  size="13" multiple="multiple"></select>
                                            <input type="hidden" name="hotel1text" id="hotel1text" value="<?php echo isset($edit[0]->hotelid) ? $edit[0]->hotelid : ''; ?>"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-xs-5">
                                            <label>Set 2 Hotels</label>
                                            <select name="hoteltwo_select[]"  id="hoteltwo_undo_redo" class="form-control multi-select-trans2"  size="13" multiple="multiple">
                                            <?php $count=count($view);
                                                for ($i=0; $i <$count ; $i++) {  ?>
                                                <option value="<?php echo $view[$i]->id; ?>"><?php echo $view[$i]->hotel_name; ?></option>
                                            <?php  } ?>
                                            </select>
                                                           
                                        </div>
                                        <div class="col-xs-2">
                                            <button type="button" id="hoteltwo_undo_redo_undo" class="mt-6 no-border btn-sm btn-primary btn-block">Undo</button>
                                            <button type="button"  id="hoteltwo_undo_redo_rightAll" class="no-border btn-sm btn-default btn-block"><i class="fa fa-forward"></i></button>
                                            <button type="button" id="hoteltwo_undo_redo_rightSelected"  class="no-border btn-sm btn-default btn-block"><i class="fa fa-chevron-right"></i></button>
                                            <button type="button" id="hoteltwo_undo_redo_leftSelected" class="no-border btn-sm btn-default btn-block"><i class="fa fa-chevron-left"></i></button>
                                            <button type="button" id="hoteltwo_undo_redo_leftAll" class="no-border btn-sm btn-default btn-block"><i class="fa fa-backward"></i></button>
                                            <button type="button" id="hoteltwo_undo_redo_redo" class="no-border btn-sm btn-primary btn-block">Redo</button>
                                        </div>
                                        
                                        <div class="col-xs-5">
                                            <label>Selected Hotels</label>
                                            <select name="hoteltwo[]" class="form-control multi-select-trans2"  id="hoteltwo_undo_redo_to"  size="13" multiple="multiple"></select>
                                            <input type="hidden" name="hotel2text" id="hotel2text" value="<?php echo isset($edit[0]->hotelid) ? $edit[0]->hotelid : ''; ?>"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix" style="margin-top: 75px ! important;"></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-xs-5">
                                            <label>Set 3 Hotels</label>
                                            <select name="hotelthree_select[]"  id="hotelthree_undo_redo" class="form-control multi-select-trans2"  size="13" multiple="multiple">
                                            <?php $count=count($view);
                                                for ($i=0; $i <$count ; $i++) {  ?>
                                                <option value="<?php echo $view[$i]->id; ?>"><?php echo $view[$i]->hotel_name; ?></option>
                                            <?php  } ?>
                                            </select>
                                                           
                                        </div>
                                        <div class="col-xs-2">
                                            <button type="button" id="hotelthree_undo_redo_undo" class="mt-6 no-border btn-sm btn-primary btn-block">Undo</button>
                                            <button type="button"  id="hotelthree_undo_redo_rightAll" class="no-border btn-sm btn-default btn-block"><i class="fa fa-forward"></i></button>
                                            <button type="button" id="hotelthree_undo_redo_rightSelected"  class="no-border btn-sm btn-default btn-block"><i class="fa fa-chevron-right"></i></button>
                                            <button type="button" id="hotelthree_undo_redo_leftSelected" class="no-border btn-sm btn-default btn-block"><i class="fa fa-chevron-left"></i></button>
                                            <button type="button" id="hotelthree_undo_redo_leftAll" class="no-border btn-sm btn-default btn-block"><i class="fa fa-backward"></i></button>
                                            <button type="button" id="hotelthree_undo_redo_redo" class="no-border btn-sm btn-primary btn-block">Redo</button>
                                        </div>
                                        
                                        <div class="col-xs-5">
                                            <label>Selected Hotels</label>
                                            <select name="hotelthree[]" class="form-control multi-select-trans2"  id="hotelthree_undo_redo_to"  size="13" multiple="multiple"></select>
                                            <input type="hidden" name="hotel3text" id="hotel3text" value="<?php echo isset($edit[0]->hotelid) ? $edit[0]->hotelid : ''; ?>"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-xs-5">
                                            <label>Set 4 Hotels</label>
                                            <select name="hotelfour_select[]"  id="hotelfour_undo_redo" class="form-control multi-select-trans2"  size="13" multiple="multiple">
                                            <?php $count=count($view);
                                                for ($i=0; $i <$count ; $i++) {  ?>
                                                <option value="<?php echo $view[$i]->id; ?>"><?php echo $view[$i]->hotel_name; ?></option>
                                            <?php  } ?>
                                            </select>
                                                           
                                        </div>
                                        <div class="col-xs-2">
                                            <button type="button" id="hotelfour_undo_redo_undo" class="mt-6 no-border btn-sm btn-primary btn-block">Undo</button>
                                            <button type="button"  id="hotelfour_undo_redo_rightAll" class="no-border btn-sm btn-default btn-block"><i class="fa fa-forward"></i></button>
                                            <button type="button" id="hotelfour_undo_redo_rightSelected"  class="no-border btn-sm btn-default btn-block"><i class="fa fa-chevron-right"></i></button>
                                            <button type="button" id="hotelfour_undo_redo_leftSelected" class="no-border btn-sm btn-default btn-block"><i class="fa fa-chevron-left"></i></button>
                                            <button type="button" id="hotelfour_undo_redo_leftAll" class="no-border btn-sm btn-default btn-block"><i class="fa fa-backward"></i></button>
                                            <button type="button" id="hotelfour_undo_redo_redo" class="no-border btn-sm btn-primary btn-block">Redo</button>
                                        </div>
                                        
                                        <div class="col-xs-5">
                                            <label>Selected Hotels</label>
                                            <select name="hotelfour[]" class="form-control multi-select-trans2"  id="hotelfour_undo_redo_to"  size="13" multiple="multiple"></select>
                                            <input type="hidden" name="hotel4text" id="hotel4text" value="<?php echo isset($edit[0]->hotelid) ? $edit[0]->hotelid : ''; ?>"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix" style="margin-top: 75px ! important;"></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-xs-5">
                                            <label>Set 5 Hotels</label>
                                            <select name="hotelfive_select[]"  id="hotelfive_undo_redo" class="form-control multi-select-trans2"  size="13" multiple="multiple">
                                            <?php $count=count($view);
                                                for ($i=0; $i <$count ; $i++) {  ?>
                                                <option value="<?php echo $view[$i]->id; ?>"><?php echo $view[$i]->hotel_name; ?></option>
                                            <?php  } ?>
                                            </select>
                                                           
                                        </div>
                                        <div class="col-xs-2">
                                            <button type="button" id="hotelfive_undo_redo_undo" class="mt-6 no-border btn-sm btn-primary btn-block">Undo</button>
                                            <button type="button"  id="hotelfive_undo_redo_rightAll" class="no-border btn-sm btn-default btn-block"><i class="fa fa-forward"></i></button>
                                            <button type="button" id="hotelfive_undo_redo_rightSelected"  class="no-border btn-sm btn-default btn-block"><i class="fa fa-chevron-right"></i></button>
                                            <button type="button" id="hotelfive_undo_redo_leftSelected" class="no-border btn-sm btn-default btn-block"><i class="fa fa-chevron-left"></i></button>
                                            <button type="button" id="hotelfive_undo_redo_leftAll" class="no-border btn-sm btn-default btn-block"><i class="fa fa-backward"></i></button>
                                            <button type="button" id="hotelfive_undo_redo_redo" class="no-border btn-sm btn-primary btn-block">Redo</button>
                                        </div>
                                        
                                        <div class="col-xs-5">
                                            <label>Selected Hotels</label>
                                            <select name="hotelfive[]" class="form-control multi-select-trans2"  id="hotelfive_undo_redo_to"  size="13" multiple="multiple"></select>
                                            <input type="hidden" name="hotel5text" id="hotel5text" value="<?php echo isset($edit[0]->hotelid) ? $edit[0]->hotelid : ''; ?>"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-xs-5">
                                            <label>Set 6 Hotels</label>
                                            <select name="hotelsix_select[]"  id="hotelsix_undo_redo" class="form-control multi-select-trans2"  size="13" multiple="multiple">
                                            <?php $count=count($view);
                                                for ($i=0; $i <$count ; $i++) {  ?>
                                                <option value="<?php echo $view[$i]->id; ?>"><?php echo $view[$i]->hotel_name; ?></option>
                                            <?php  } ?>
                                            </select>
                                                           
                                        </div>
                                        <div class="col-xs-2">
                                            <button type="button" id="hotelsix_undo_redo_undo" class="mt-6 no-border btn-sm btn-primary btn-block">Undo</button>
                                            <button type="button"  id="hotelsix_undo_redo_rightAll" class="no-border btn-sm btn-default btn-block"><i class="fa fa-forward"></i></button>
                                            <button type="button" id="hotelsix_undo_redo_rightSelected"  class="no-border btn-sm btn-default btn-block"><i class="fa fa-chevron-right"></i></button>
                                            <button type="button" id="hotelsix_undo_redo_leftSelected" class="no-border btn-sm btn-default btn-block"><i class="fa fa-chevron-left"></i></button>
                                            <button type="button" id="hotelsix_undo_redo_leftAll" class="no-border btn-sm btn-default btn-block"><i class="fa fa-backward"></i></button>
                                            <button type="button" id="hotelsix_undo_redo_redo" class="no-border btn-sm btn-primary btn-block">Redo</button>
                                        </div>
                                        
                                        <div class="col-xs-5">
                                            <label>Selected Hotels</label>
                                            <select name="hotelsix[]" class="form-control multi-select-trans2"  id="hotelsix_undo_redo_to"  size="13" multiple="multiple"></select>
                                            <input type="hidden" name="hotel6text" id="hotel6text" value="<?php echo isset($edit[0]->hotelid) ? $edit[0]->hotelid : ''; ?>"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix" style="margin-top: 75px ! important;"></div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?php  if (isset($edit[0]->id) && $edit[0]->id!="") { ?>
                                            <input type="button" id="trendUpdate" class="waves-effect waves-light btn-sm btn-success pull-right" value="Update">
                                        <?php } else { ?>
                                            <input type="button" id="trendUpdate" class="waves-effect waves-light btn-sm btn-success pull-right" value="Submit">
                                        <?php
                                        }
                                        ?>
                                    </div> 
                                </div>
                            </div>
                        </form>
                             
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo static_url(); ?>assets/js/prettify.min.js"></script>
<script src="<?php echo static_url(); ?>assets/js/multiselect.min.js"></script>
<script src="<?php echo static_url(); ?>assets/js/hotel.js"></script>
<script type="text/javascript"> 
        window.prettyPrint && prettyPrint();
        $('#hotelone_undo_redo').multiselect({
            sort : false,
            submitAllRight : true,
            search: {
                left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
            },
            fireSearch: function(value) {
                return value.length = 1;
            },
            afterMoveToLeft: function($left, $right, $options) { 
               selecthotel_one();
             },
             afterMoveToRight: function($left, $right, $options) { 
               selecthotel_one();
             }
        });
        function selecthotel_one(){
            var hotelValues = [];
            $('#hotelone_undo_redo_to option').each(function() {
                  hotelValues.push($(this).val());
            });
            $('[name="hotel1text"]').val(hotelValues);
        }
        $('#hoteltwo_undo_redo').multiselect({
            sort : false,
            submitAllRight : true,
            search: {
                left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
            },
            fireSearch: function(value) {
                return value.length = 1;
            },
            afterMoveToLeft: function($left, $right, $options) { 
               selecthotel_two();
             },
             afterMoveToRight: function($left, $right, $options) { 
               selecthotel_two();
             }
        });
        function selecthotel_two(){
            var hotelValues = [];
            $('#hoteltwo_undo_redo_to option').each(function() {
                  hotelValues.push($(this).val());
            });
            $('[name="hotel2text"]').val(hotelValues);
        }
        $('#hotelthree_undo_redo').multiselect({
            sort : false,
            submitAllRight : true,
            search: {
                left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
            },
            fireSearch: function(value) {
                return value.length = 1;
            },
            afterMoveToLeft: function($left, $right, $options) { 
               selecthotel_three();
             },
             afterMoveToRight: function($left, $right, $options) { 
               selecthotel_three();
             }
        });
        function selecthotel_three(){
            var hotelValues = [];
            $('#hotelthree_undo_redo_to option').each(function() {
                  hotelValues.push($(this).val());
            });
            $('[name="hotel3text"]').val(hotelValues);
        }
        $('#hotelfour_undo_redo').multiselect({
            sort : false,
            submitAllRight : true,
            search: {
                left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
            },
            fireSearch: function(value) {
                return value.length = 1;
            },
            afterMoveToLeft: function($left, $right, $options) { 
               selecthotel_four();
             },
             afterMoveToRight: function($left, $right, $options) { 
               selecthotel_four();
             }
        });
        function selecthotel_four(){
            var hotelValues = [];
            $('#hotelfour_undo_redo_to option').each(function() {
                  hotelValues.push($(this).val());
            });
            $('[name="hotel4text"]').val(hotelValues);
        }
        $('#hotelfive_undo_redo').multiselect({
            sort : false,
            submitAllRight : true,
            search: {
                left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
            },
            fireSearch: function(value) {
                return value.length = 1;
            },
            afterMoveToLeft: function($left, $right, $options) { 
               selecthotel_five();
             },
             afterMoveToRight: function($left, $right, $options) { 
               selecthotel_five();
             }
        });
        function selecthotel_five(){
            var hotelValues = [];
            $('#hotelfive_undo_redo_to option').each(function() {
                  hotelValues.push($(this).val());
            });
            $('[name="hotel5text"]').val(hotelValues);
        }
        $('#hotelsix_undo_redo').multiselect({
            sort : false,
            submitAllRight : true,
            search: {
                left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
            },
            fireSearch: function(value) {
                return value.length = 1;
            },
            afterMoveToLeft: function($left, $right, $options) { 
               selecthotel_six();
             },
             afterMoveToRight: function($left, $right, $options) { 
               selecthotel_six();
             }
        });
        function selecthotel_six(){
            var hotelValues = [];
            $('#hotelsix_undo_redo_to option').each(function() {
                  hotelValues.push($(this).val());
            });
            $('[name="hotel6text"]').val(hotelValues);
        }
   
</script>
<?php init_tail(); ?>



