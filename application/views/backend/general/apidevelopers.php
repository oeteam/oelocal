<?php init_head(); ?>

<style>
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
    .multi-select-mod button {
        background-color: transparent;
        color: #ccc;
        box-shadow: none;
        border: 1px solid #ccc;
        height: 34px;
        font-size: 14px;
        font-weight: normal;
        text-transform: capitalize;
        padding: 0 1rem;
    }

    .multi-select-mod button:hover {
        background-color: transparent;
        box-shadow: none;
        color: #ccc;
        border: 1px solid #ccc;
    }

    .multi-select-mod .dropdown-menu {
        left: 0;
        top: 34px;
    }

    .multi-select-mod label {
        color: black;
    }
    .multi-select-mod li.active a, .multi-select-mod li.active a:hover {
        background-color: #f1f1f1;
    }

    .multi-select-mod li.active a label {
        color: #000;
    }
    .multi-select-mod [type="checkbox"]:not(:checked), [type="checkbox"]:checked {
        left: auto !important;
        opacity: 1 !important;
    }

    .multi-select-mod .btn-group, .multi-select-mod button, .multi-select-mod .dropdown-menu {
        width: 100%;
    }
    .multi-select-trans .multiselect.dropdown-toggle.btn.btn-default {
        border: 1px solid #cccccc ! important;
        margin-top: 9px;
    }
    .caret {
        display: none;
    } 
    .select {
        -webkit-appearance:none
    } 


/* Styles for CodePen Demo Only */
</style>


<div class="sb2-2">
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp">
                    <div class="inn-title">
                        <?php if (isset($details[0]->id) && $details[0]->id!="") { ?>
                        <span>Edit Developer </span>
                        <?php } else { ?>
                        <span>Add Developer </span>
                        <?php }?>
                        <span class="pull-right" style="margin-left: 10px;"><a href="<?php echo base_url(); ?>backend/Common/api_provider" class="btn-sm btn-primary">Back</a></span>
                    </div>
                    <div class="tab-inn">
                       <!--  <?php if (isset($edit[0]->id) && $edit[0]->id!="") { ?>
                        <h2>Edit Agent</h2>
                        <?php } else { ?>
                        <h2>Add New Agent</h2>
                        <?php }?> -->
                        <form method="post" action="<?php echo base_url('backend/common/add_developer'); ?>" name="developer_form" id="developer_form" enctype="multipart/form-data"> 
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>"> 
                            <input type="hidden" name="edit_id" value="<?php echo isset($details[0]->id) ? $details[0]->id : '' ?>">
                             <input type="hidden" name="agent_id" value="<?php echo $_REQUEST['id']?>">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="developer_mail">Developer Email*</label>
                                                <input id="developer_mail" name="developer_mail" type="text" class="form-control" value="<?php echo isset($details[0]->developerMail) ? $details[0]->developerMail : '' ?>">
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="support_mail">Support Email*</label>
                                                <input id="support_mail" name="support_mail" type="text" class="form-control" value="<?php echo isset($details[0]->supportMail) ? $details[0]->supportMail : '' ?>">
                                                
                                             </div>
                                        </div>
                                        <div class="col-md-6">
                                             <div class="form-group">
                                                <label for="developer_con">Developer Contact*</label>
                                                <input id="developer_con" name="developer_con" type="email" onsubmit="email_validation()"  class="form-control" value="<?php echo isset($details[0]->developerContact) ? $details[0]->developerContact : '' ?>">
                                            </div>
                                        </div> 
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="support_con">Support Contact*</label>
                                                <input id="support_con" name="support_con" type="text" class="form-control" value="<?php echo isset($details[0]->supportContact) ? $details[0]->supportContact : '' ?>">
                                            </div>
                                        </div>   
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ip_test">IP Address - Test*</label>
                                            <span>
                                            <button type="button" id="testipadd" class="btn-sm btn-primary pull-right"><i class="fa fa-plus"></i></button>
                                            </span>
                                            <table class="testTable">
                                                
                                                <?php if (isset($details[0]->IP_Test) && $details[0]->IP_Test!="") {
                                                    $IP_TestArr = explode(",", $details[0]->IP_Test);
                                                    foreach ($IP_TestArr as $key => $value) {
                                                 ?>
                                                <tr> 
                                                    <td><input name="ip_test[]" type="text" value="<?php echo $value ?>"></td><td><button onclick="removetesttrfun(event)" type="button" class="btn-sm btn-danger red pull-right"><i class="fa fa-trash"></i></button></td>
                                                </tr>
                                                <?php } } else { ?>
                                                    <tr>
                                                        <td> <input id="ip_test" name="ip_test[]" type="text" class="form-control"></td>
                                                        <td><button onclick="removetesttrfun(event)" type="button" class="btn-sm btn-danger red pull-right"><i class="fa fa-trash"></i></button></td>
                                                    </tr>
                                                <?php } ?>
                                            </table>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            <label for="ip_test">IP Address - Whitelist*</label>
                                            <span>
                                            <button type="button" id="whiteipadd" class="btn-sm btn-primary pull-right"><i class="fa fa-plus"></i></button>
                                            </span>
                                            <table class="whiteTable">
                                                <?php if (isset($details[0]->IP_whitelist) && $details[0]->IP_whitelist!="") {
                                                    $IP_whitelistArr = explode(",", $details[0]->IP_whitelist);
                                                    foreach ($IP_whitelistArr as $key => $value) {
                                                 ?>
                                                 <tr>
                                                    <td><input id="ip_whitelist" name="ip_whitelist[]" type="text" class="form-control" value="<?php echo $value ?>"></td>
                                                    <td><button onclick="removewhitetrfun(event)" type="button" class="btn-sm btn-danger red pull-right"><i class="fa fa-trash"></i></button></td>
                                                </tr>
                                                <?php } } else { ?>
                                                <tr>
                                                    <td><input id="ip_whitelist" name="ip_whitelist[]" type="text" class="form-control"></td>
                                                    <td><button onclick="removewhitetrfun(event)" type="button" class="btn-sm btn-danger red pull-right"><i class="fa fa-trash"></i></button></td>
                                                </tr>
                                                 <?php } ?>
                                            </table>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            <label for="usage">API Usage Limit per Second*</label>
                                            <input id="usage" name="usage" type="text" class="form-control" value="<?php echo isset($details[0]->usageLimit) ? $details[0]->usageLimit : '' ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="mode">Mode*</label>
                                                <br>
                                                <p>
                                                    <?php  if (isset($details[0]->mode) && $details[0]->mode=="test") { ?>
                                                        <input class="with-gap" name="mode" type="radio" id="test1" checked="" value="test">
                                                        <label for="test1">Test</label>
                                                        <input class="with-gap" name="mode" type="radio" id="test2"  value="live">
                                                        <label for="test2">Live</label>
                                                    <?php } else { ?>
                                                       <input class="with-gap" name="mode" type="radio" id="test1" value="test">
                                                        <label for="test1">Test</label>
                                                        <input class="with-gap" name="mode" type="radio" id="test2" checked  value="live">
                                                        <label for="test2">Live</label>
                                                    <?php } ?>
                                                </p>
                                            </div> 
                                        </div>
                                    </div> 
                                </div>
                            </div>
                            <br>                             
                            <div class="row">
                                <div class="col-md-12">
                                   <div class="form-group">
                                    <?php  if (isset($details[0]->id) && $details[0]->id!="") { ?>
                                     <input type="button" id="add_developer_button" class="waves-effect waves-light btn-sm btn-success pull-right" value="Update">
                                    <?php } else { ?>
                                     <input type="button" id="add_developer_button" class="waves-effect waves-light btn-sm btn-success pull-right" value="Submit">
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
<script>
    $("#testipadd").click(function() {
        $(".testTable").append('<tr> <td><input type="text" name="ip_test[]"></td><td><button onclick="removetesttrfun(event)" type="button" class="btn-sm btn-danger red pull-right"><i class="fa fa-trash"></i></button></td></tr>');
    });
    $("#whiteipadd").click(function() {
        $(".whiteTable").append('<tr> <td><input name="ip_whitelist[]" type="text"></td><td><button onclick="removetesttrfun(event)" type="button" class="btn-sm btn-danger red pull-right"><i class="fa fa-trash"></i></button></td></tr>');
    });
    function removetesttrfun(e) {
        var tr = e.target.closest('tr').remove();
    }
    function removewhitetrfun(e) {
        var tr = e.target.closest('tr').remove();
    }
    $('#add_developer_button').click(function (e) {
        e.preventDefault();
        $.ajax({
          dataType: 'json',
          type: 'post',
          url: base_url+'/backend/common/developer_validation',
          data: $('#developer_form').serialize(),
          cache: false,
          success: function (response) {
            if (response.status == "1") {
              addToast(response.error,response.color);
              window.setTimeout(function(){
                 $("#developer_form").submit();
              }, 1500);
            }
             else {
              addToast(response.error,response.color);
            }
          },
           error: function (xhr,status,error) {
             alert("Error: " + error);
          }
        });
    });

</script>
<?php init_tail(); ?>

