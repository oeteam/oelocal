<?php init_head();
$Settings = menuPermissionAvailability($this->session->userdata('id'),'General','Settings'); 

 ?>
    <div class="sb2-2">
        <div class="sb2-2-add-blog sb2-2-1">
            <div class="col-md-6">
                <h2>General Settings</h2>
            </div>
            <div class="col-md-6">
                <span class="pull-right"><a href="#" data-toggle="modal" data-target="#myModalbanner" onclick="banner_modal();" class="btn-sm btn-warning">Home Banners</a></span>
            </div>
            <div class="clearfix"></div>
            <br>
            <div class="col-md-12">
            <form action="<?php echo base_url(); ?>backend/login/handle_general_settings_image_upload" name="general_settings_form" id="general_settings_form" method="post" enctype="multipart/form-data">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="list-title">Title</label>
                        <input id="list-title" type="text" name="title" value="<?php echo $select[0]->Title; ?>" class="form-control">
                    </div>
                    <div class="form-group favicon_upload col-md-4">
                        <label for="favicon" class="control-label">Fav Icon</label>
                        <input type="file" onchange="return ValidateFileUpload();" id="fav_icon" name="fav_icon" class="form-control">
                    </div>
                    <div class="col-md-2" style="line-height: 74px;">
                        <span class="upload-img"><img src="<?php static_url(); ?>../../assets/images/fav.ico" alt="" id="load_image"></span>
                    </div>
                    <div class="form-group favicon_upload col-md-4">
                        <label for="favicon" class="control-label">Logo</label>
                        <input type="file" onchange="return ValidateFileUpload1();" id="logo" name="logo" class="form-control">
                    </div>
                    <div class="col-md-2" style="line-height: 74px;">
                        <span class="logo_img">
                                <img src="<?php static_url(); ?>../../assets/images/logo1.png" alt="" id="load_image1">
                        </span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="account">Account Details</label>
                        <textarea id="account" name="account" class="form-control" ><?php echo isset($select[0]->account) ? $select[0]->account : '' ?></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Account Email</label>
                        <input id="email" type="text" name="email" value="<?php echo $select[0]->email; ?>" class="form-control">
                    </div>

                </div>
                <?php if (count($Settings)!=0 && $Settings[0]->edit==1) { ?>
                <div class="row">
                    <div class="form-group col-md-12">
                            <button type="submit" id="general_setting_buttons" class="waves-effect waves-light btn-sm btn-success pull-right">Update</button>
                    </div>
                </div>
                <?php } ?>
            </form>
            </div>
        </div>

         <div class="sb2-2-add-blog sb2-2-1">
            <div class="col-md-6">
                <h2>Backend login</h2>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <p class="bold hashlink" style="line-height: 35px"><?php echo base_url().'getmyaccess/'.$select[0]->hashkey ?></p>
                </div>
                <div class="col-md-6">
                    <button class="btn-sm btn btn-primary" id="generateKey">Generate</button>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>

    <div id="myModalbanner" class="delete_modal modal">
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#generateKey").click(function() {
            $.ajax({
                dataType: 'json',
                type: 'post',
                url: base_url+'backend/common/generateKey',
                cache: false,
                success: function (response) {
                  $(".hashlink").text(base_url+'getmyaccess/'+response);  
                  addToast('Generated Successfully','green');

                },
                 error: function (xhr,status,error) {
                   alert("Error: " + error);
                }
              });
        })    
    })
</script>
<script src="<?php echo static_url(); ?>assets/js/general_settings.js"></script>
<?php init_tail(); ?>
