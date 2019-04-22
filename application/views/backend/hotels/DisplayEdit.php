<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/prettify.css" />
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
                        <span>Display Management Edit  </span>
                        <span class="pull-right"><a href="<?php echo base_url(); ?>backend/hotels/display_manage" class="btn-sm btn-primary">Back</a></span>
                        <?php } else { ?>
                        <span>Display Management Add  </span>
                        <span class="pull-right"><a href="<?php echo base_url(); ?>backend/hotels/display_manage" class="btn-sm btn-primary">Back</a></span>
                        <?php }?>
                    </div>
                    <div class="tab-inn">
                        <form method="post" action="DisplaySubmit" name="DisplayForm" id="DisplayForm" enctype="multipart/form-data"> 
                            <input type="hidden" name="id" value="<?php echo isset($edit[0]->id) ? $edit[0]->id : '' ?>">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-xs-5">
                                           <label> Agents</label>
                                            <select  id="Agents_undo_redo" class="form-control multi-select-trans2"  size="13" multiple="multiple">
                                                <?php foreach ($agents as $key => $value) { ?>
                                                    <option value="<?php echo $value->id ?>"><?php echo $value->First_Name.' '.$value->Last_Name ?></option>
                                                <?php } ?>
                                            </select>
                                                           
                                        </div>
                                        
                                        <div class="col-xs-2">
                                            <button type="button" id="Agents_undo_redo_undo" class="mt-6 no-border btn-sm btn-primary btn-block">Undo</button>
                                            <button type="button" onclick="DisplayAgentSelect();"  id="Agents_undo_redo_rightAll" class="no-border btn-sm btn-default btn-block"><i class="fa fa-forward"></i></button>
                                            <button type="button" onclick="DisplayAgentSelect();"  id="Agents_undo_redo_rightSelected" class="no-border btn-sm btn-default btn-block"><i class="fa fa-chevron-right"></i></button>
                                            <button type="button" id="Agents_undo_redo_leftSelected" class="no-border btn-sm btn-default btn-block"><i class="fa fa-chevron-left"></i></button>
                                            <button type="button" id="Agents_undo_redo_leftAll" class="no-border btn-sm btn-default btn-block"><i class="fa fa-backward"></i></button>
                                            <button type="button" id="Agents_undo_redo_redo" class="no-border btn-sm btn-primary btn-block">Redo</button>
                                        </div>
                                        
                                        <div class="col-xs-5">
                                            <label>Selected Agents</label>
                                            <select name="Agents[]" class="form-control multi-select-trans2" id="Agents_undo_redo_to"  size="13" multiple="multiple"></select>
                                            <input type="hidden" name="Agentstext" id="Agentstext" value="<?php echo isset($edit[0]->Agents) ? $edit[0]->Agents : ''; ?>"></p>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="list-title">Direct Hotels</label><br>
                                        <input type="radio" id="dfirst" class="direct-display" name="direct" <?php echo isset($edit[0]->directhotels) && $edit[0]->directhotels == "1" ? 'checked' : '' ?> value="1" />
                                        <label for="dfirst">First</label>                              &nbsp&nbsp&nbsp
                                        <input type="radio" id="dsecond" class="direct-display" name="direct" <?php echo isset($edit[0]->directhotels) && $edit[0]->directhotels == "2" ? 'checked' : '' ?> value="2"/>
                                        <label for="dsecond">Second</label>
                                    </div>
                                     <div class="form-group">
                                        <label for="list-title">TBO Hotels</label><br>
                                        <input type="radio" id="tfirst" class="tbo-display" name="tbo" value="1" <?php echo isset($edit[0]->tbohotels) && $edit[0]->tbohotels == "1" ? 'checked' : '' ?> />
                                        <label for="tfirst">First</label>                              &nbsp&nbsp&nbsp
                                        <input type="radio" id="tsecond" class="tbo-display" name="tbo" value="2" <?php echo isset($edit[0]->tbohotels) && $edit[0]->tbohotels == "2" ? 'checked' : '' ?> />
                                        <label for="tsecond">Second</label>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix" style="margin-top: 75px ! important;"></div>
                            <br>
                            <div class="clearfix" style="margin-top: 10px ! important;"></div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?php  if (isset($edit[0]->id) && $edit[0]->id!="") { ?>
                                            <input type="button" id="DisplayUpdate" class="waves-effect waves-light btn-sm btn-success pull-right" value="Update">
                                        <?php } else { ?>
                                            <input type="button" id="DisplayUpdate" class="waves-effect waves-light btn-sm btn-success pull-right" value="Submit">
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
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/prettify.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/multiselect.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/hotel.js"></script>
<script type="text/javascript">
    // $(document).ready(function() {
        // make code pretty
        // stayChange();

        window.prettyPrint && prettyPrint();
        $('#Agents_undo_redo').multiselect({
            search: {
                left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
            },
            fireSearch: function(value) {
                return value.length = 1;

            },
            afterMoveToLeft: function($left, $right, $options) { 
               DisplayAgentSelect();
             },
             afterMoveToRight: function($left, $right, $options) { 
               DisplayAgentSelect();
             }
        });

       
    function DisplayAgentSelect() {
        var agentValues = [];
        $('#Agents_undo_redo_to option').each(function() {
              agentValues.push($(this).val());
        });
        $('[name="Agentstext"]').val(agentValues);
    }

    <?php if (count($edit)!=0) { ?>
            var Agentstext = $("#Agentstext").val().split(",");
            $.each(Agentstext, function(i, v) {
                $('#Agents_undo_redo option[value='+v+']').attr('selected','selected');
            });

            $("#Agents_undo_redo_rightSelected").trigger('click');
            $('#Agents_undo_redo_to').prop('selectedIndex', 0).focus();  

    <?php } ?>
    $(".direct-display").click(function() {
        var type=$('input[name=direct]:checked').val();
        if(type=='1') {
          $("#tfirst").prop('checked',false);
          $("#tsecond").prop('checked', true);
        } else if(type=='2'){ 
          $("#tsecond").prop('checked',false);
          $("#tfirst").prop('checked', true);
        }
     })

    $(".tbo-display").click(function() {
        var type=$('input[name=tbo]:checked').val();
        alert(type);
        if(type=='1') {
          $("#dfirst").prop('checked',false);
          $("#dsecond").prop('checked', true);
        } else if(type=='2'){ 
          $("#dsecond").prop('checked',false);
          $("#dfirst").prop('checked', true);
        }
     })
</script>
<?php init_tail(); ?>



