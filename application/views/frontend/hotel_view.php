<script src="<?php echo base_url(); ?>assets/js/locationpicker.jquery.js"></script>
<style type="text/css">
  .modal-backdrop {
    z-index: 500;
  }
  .modal {
    z-index: 501;
  }
    #sales_password + .fa {
        cursor: pointer;
        pointer-events: all;
    }
     #revenue_password + .fa {
        cursor: pointer;
        pointer-events: all;
    }
     #contract_password + .fa {
        cursor: pointer;
        pointer-events: all;
    }
     #finance_password + .fa {
        cursor: pointer;
        pointer-events: all;
    }
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
    }  .multiselect {
        width:20em;
        height:15em;
        border:solid 1px #c0c0c0;
        overflow:auto;
    }
     
    .multiselect label {
        display:block;
    }
     
    .multiselect-on {
        color:#ffffff;
        background-color:#000099;
    }
    .custom-select-option{
        font-size: 10px;
    }

    .custom-dd-style {
        transform: translateY(10px);
        position: absolute;
        background: #fff;
        box-shadow: 0 2px 1px 0 #ccc;
        padding: 10px;
        z-index: 1;
        display: none;
    }
    .tab-content {
      background-color: white;
    }
    .tab-list li {
        width: 20%;
        text-align: center;
    }
    .js--image-preview {
      height: 213px;
      width: 100%;
      position: relative;
      overflow: hidden;
      background-image: url("");
      background-color: white;
      background-position: center center;
      background-repeat: no-repeat;
      background-size: cover;
    } 
    .box img {
      height:100%;
      width:100%;
    }
    .box {
      display: inline-block;
      height: 259px;
      width: 259px;
      margin: 10px;
      background-color: white;
      border-radius: 5px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
      -webkit-transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
      transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
      overflow: hidden;
    }
    .upload-options {
      position: relative;
      height: 40px;
      cursor: pointer;
      overflow: hidden;
      text-align: center;
      -webkit-transition: background-color ease-in-out 150ms;
      transition: background-color ease-in-out 150ms;
    }
    .upload-options label p i {
      font-size: 22px;
      color: #f7f7f7;
    }
    .upload-options input {
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
        overflow: hidden;
        position: absolute;
        z-index: -1;
    }
</style>
<div class="modal-dialog" style="overflow-y:auto;height: 100%;width: 70%;">
    <!-- Modal content-->

        <div class="modal-content">
            <div class="modal-body">
            <ul class="nav nav-tabs tab-list">
                <li class="home active"><a data-toggle="tab" href="#home"><i class="fa fa-map" aria-hidden="true"></i> <span>Location</span></a>
                </li>
                <li class="menu1"><a data-toggle="tab" href="#menu1"><i class="fa fa-info" aria-hidden="true"></i> <span>Details</span></a>
                </li>
                <li class="menu3"><a data-toggle="tab" href="#menu3"><i class="fa fa-picture-o" aria-hidden="true"></i> <span>Photo Gallery</span></a>
                <li class="menu4"><a data-toggle="tab" href="#menu4"><i class="fa fa-facebook" aria-hidden="true"></i> <span>Social Media</span></a>
                </li>
                <li class="menu5"><a data-toggle="tab" href="#menu5"><i class="fa fa-phone" aria-hidden="true"></i> <span>Contact Info</span></a></li>
            </ul>
            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <div class="box-inn-sp">
                        <div class="bor mar_top_0">
                        <div class="row">
                            <input type="hidden" id="us3-lat" />
                            <input type="hidden" id="us3-lon" />
                            <div class="form-group col-md-12">
                                <label for="us3-address">Where is the hotel location</label>
                                <input type="text" class="form-control" value="<?php echo $view[0]->location;?>">
                            </div>
                            <div class="form-horizontal col s12">
                                <div id="us3" style="width: 100%; height: 400px;"></div>
                            <script>
                                $('#us3').locationpicker({
                                    location: {
                                        latitude: <?php echo isset($view[0]->lattitude) && $view[0]->lattitude!="" ? $view[0]->lattitude : '25.253160' ?>,
                                        longitude: <?php echo isset($view[0]->longitude) && $view[0]->longitude !="" ? $view[0]->longitude : '55.328495' ?>
                                    },
                                    position:location,
                                    markerIcon: undefined,
                                    markerDraggable: false,
                                    radius: 300,
                                    styles: ['road','red'],
                                    enableAutocomplete: false,
                                    onchanged: function (currentLocation, radius, isMarkerDropped) {
                                    }
                                });
                            </script>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div id="menu1" class="tab-pane fade">
                    <div class="bor mar_top_0">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Hotel Name</label>
                                    <input type="text" class="form-control" value="<?php echo $view[0]->hotel_name;?>" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="property_name">Property Name</label><span>*</span>
                                    <input id="property_name" name="property_name" type="text" class="form-control" value="<?php echo isset($view[0]->property_name) ? $view[0]->property_name : '' ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="brand_name">Brand Name</label><span>*</span>
                                    <input id="brand_name" name="brand_name" type="text" class="form-control" value="<?php echo isset($view[0]->brand_name) ? $view[0]->brand_name : '' ?>" readonly>
                                </div>
                            
                                <div class="form-group col-md-6">
                                    <label>City</label>
                                    <input type="text" class="form-control" value="<?php echo $view[0]->city;?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>City near by places</label>
                                    <input type="text" class="form-control" value="<?php echo $view[0]->city_near_by;?>" readonly>
                                </div>
                        
                                
                                <div class="form-group col-md-6">
                                    <label>City description</label>
                                    <textarea  class="form-control" readonly><?php echo $view[0]->city_description;?></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Hotel facilities</label>
                                    <ul>
                                        <?php
                                           foreach ($hotel_facilities as $key => $value) {
                                            if (isset($value[0]->Hotel_Facility)) {
                                            ?>
                                            <li><?php echo $value[0]->Hotel_Facility ?></li>
                                        <?php } else {
                                          echo  "No Records";
                                        }
                                    } ?>
                                    </ul>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Room facilities</label>
                                    <ul>
                                        <?php foreach ($room_facilities as $key1 => $value3) {
                                            if (isset($value3[0]->Room_Facility)) {
                                            ?>
                                            <li><?php echo $value3[0]->Room_Facility; ?></li>
                                        <?php } else {
                                          echo  "No Records";
                                        } }?>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-md-6">
                                    
                                    <p><label>Complimentry</label></p>
                                    <input class="filled-in" type="checkbox" <?php echo $view[0]->wifi=="on" ? 'Checked' : '';?> readonly>
                                    <label >Wifi </label> &nbsp&nbsp&nbsp
                                    <input class="filled-in" type="checkbox" <?php echo $view[0]->internet=="on" ? 'Checked' : '';?> readonly>
                                    <label >Internet </label>&nbsp&nbsp&nbsp
                                    <input class="filled-in" type="checkbox" <?php echo $view[0]->parking=="on" ? 'Checked' : '';?> readonly>
                                    <label >Parking </label>
                                </div>
                                <div class="form-group col-md-6">
                                        <p><label>Star Rating</label></p>
                                        <input type="radio" class="filled-in"   value="5" <?php echo $view[0]->rating=="5" ? 'Checked' : '';?>  readonly />
                                        <label for="5">5</label>
                                        &nbsp&nbsp&nbsp
                                        <input type="radio" class="filled-in"  value="4" <?php echo $view[0]->rating=="4" ? 'Checked' : '';?> readonly />
                                        <label for="4">4</label>
                                        &nbsp&nbsp&nbsp
                                        <input type="radio" class="filled-in"  value="3" <?php echo $view[0]->rating=="3" ? 'Checked' : '';?> readonly />
                                        <label for="3">3</label>
                                        &nbsp&nbsp&nbsp
                                        <input type="radio" class="filled-in"  value="2" <?php echo $view[0]->rating=="2" ? 'Checked' : '';?> readonly />
                                        <label for="2">2</label>
                                        &nbsp&nbsp&nbsp
                                        <input type="radio" class="filled-in"  value="1" <?php echo $view[0]->rating=="1" ? 'Checked' : '';?> readonly />
                                        <label for="1">1</label>
                                        &nbsp&nbsp&nbsp
                                        <input type="radio" class="with-gap" value="10" <?php echo $view[0]->rating=="10" ? "checked" : '' ?>  />
                                        <label for="10">Hotel Apartment</label>
                                        &nbsp&nbsp&nbsp
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Search keywords</label>
                                    <?php $keywords  = explode("close", $view[0]->keywords) ?>
                                    <ul>
                                    <?php if ($view[0]->keywords!="") {
                                     foreach ($keywords as $key10 => $value10) {
                                        if ($value10!="") {
                                        ?>
                                        <li><?php echo $value10 ?></li>
                                    <?php } } } else {  echo "No Records"; }?>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Description</label>
                                    <textarea class="form-control" readonly><?php echo $view[0]->hotel_description;?></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>No of Rooms</label>
                                    <input type="text" class="form-control" value="<?php echo $view[0]->Number_of_room;?>" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Website</label>
                                    <input type="text" class="form-control" value="<?php echo $view[0]->website;?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <p><label for="accepting_vcc">Accepting VCC</label></p>
                                    <input name="accepting" type="radio" class="with-gap" id="yes" <?php echo $view[0]->accepting_vcc=="0" ? 'Checked' : 'disabled';?> value="0" readonly />
                                    <label for="yes">Yes</label>
                                    <input name="accepting" type="radio" class="with-gap" id="no" <?php echo $view[0]->accepting_vcc=="1" ? 'Checked' : 'disabled';?> value="1" readonly />
                                    <label for="no">No</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Channel Manager</label>
                                    <input type="text" class="form-control" value="<?php echo $view[0]->channel;?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Part of Any Chain or Collection</label>
                                    <input type="text" class="form-control" value="<?php echo $view[0]->chain;?>" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Selling Currency</label>
                                    <input type="text" class="form-control" value="<?php echo $view[0]->sell_currency;?>" readonly>
                                </div>
                            </div>
                         </div>   
                </div>
                <div id="menu3" class="tab-pane fade">
                    <div class="bor mar_top_0">
                        <div class="file-field input-field">
                            <div class="row">
                                <?php for($q=1 ; $q<=5; $q++) {
                                    $image = "Image".$q;
                                    if (isset($view[0]->$image) && $view[0]->$image!="") { ?>
                                <div class="box">
                                    <div class="js--image-preview">
                                        <?php if (isset($view[0]->$image) && $view[0]->$image!="" && $q==1) { ?>
                                        <span class="image-title">Main Image</span>
                                        <?php 
                                        }
                                            if (isset($view[0]->Image1)) { ?>
                                            <img src="<?php echo base_url(); ?>uploads/gallery/<?php echo $view[0]->hotels_edit_id; ?>/<?php echo $view[0]->$image;?>" class="img1preview" >
                                            <?php  } else { if(isset($_REQUEST['hotels_edit_id'])) { ?>
                                            <p class="center">No Records</p>
                                        <?php  } }?>
                                   </div>
                                    <div class="upload-options1">
                                        <label>
                                            <p><a href="#" data-toggle="modal" data-target="#<?php echo $image ?>"><i class="fa fa-eye"></i></a></p>
                                        </label>
                                    </div>
                                </div>
                                <?php } } 
                                    if (!isset($view[0]->Image1) ||  !isset($view[0]->Image2) || !isset($view[0]->Image3) || !isset($view[0]->Image4) || !isset($view[0]->Image5)) { ?>
                                        <p class="center">No photos available!</p>
                                 <?php   }    ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="menu4" class="tab-pane fade">
                    <div class="bor mar_top_0">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Facebook Url</label>
                                <input type="text" value="<?php echo $view[0]->facebook;?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label >Google Plus Url</label>
                                <input type="text" value="<?php echo $view[0]->google_plus;?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Twitter Url</label>
                                <input type="text" value="<?php echo $view[0]->twitter;?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Linkedin Url</label>
                                <input type="text" value="<?php echo $view[0]->linked_in;?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>WhatsApp Number</label>
                                <input type="text" value="<?php echo $view[0]->whatsapp;?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Vk Url</label>
                                <input type="text" value="<?php echo $view[0]->vk_url;?>" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="menu5" class="tab-pane fade">
                    <div class="bor mar_top_0">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <h4>Sales Team</h4>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="t5-n1">First Name</label>
                                        <input id="t5-n1" type="text" name="sales_fname"  class="form-control sales_fname" value="<?php echo $view[0]->sale_name;?>" readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="t5-n2">Last Name</label>
                                        <input id="t5-n2" type="text" name="sales_lname" class="form-control sales_lname" value="<?php echo $view[0]->sale_lname;?>" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="t5-n3">Phone</label>
                                        <input id="t5-n3" type="number" name="sales_phone" class="form-control sales_phone" value="<?php echo $view[0]->sale_number;?>" readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="t5-n4">Mobile</label>
                                        <input id="t5-n4" type="number" name="sales_mobile" class="form-control sales_mobile" value="<?php echo $view[0]->sale_mobile;?>" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="t5-n5">Email</label>
                                        <input id="t5-n5" type="email" name="sales_mail" class="form-control sales_mail" value="<?php echo $view[0]->sale_mail;?>" readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="t5-n6">Address</label>
                                        <textarea id="t5-n6" name="sales_address" class="form-control" readonly><?php echo $view[0]->sale_address;?></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <h4>Revenue Team</h4>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="t5-n1">First Name</label>
                                        <input id="t5-n1" type="text" name="revenue_fname"  class="form-control revenue_fname" value="<?php echo $view[0]->revenu_name;?>" readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="t5-n2">Last Name</label>
                                        <input id="t5-n2" type="text" name="revenue_lname" class="form-control revenue_lname" value="<?php echo $view[0]->revenu_lname;?>" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="t5-n3">Phone</label>
                                        <input id="t5-n3" type="number" name="revenue_phone" class="form-control revenue_phone" value="<?php echo $view[0]->revenu_number;?>" readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="t5-n4">Mobile</label>
                                        <input id="t5-n4" type="number" name="revenue_mobile" class="form-control revenue_mobile" value="<?php echo $view[0]->revenu_mobile;?>" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="t5-n5">Email</label>
                                        <input id="t5-n5" type="email" name="revenue_mail" class="form-control revenue_mail" value="<?php echo $view[0]->revenu_mail;?>" readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="t5-n6">Address</label>
                                        <textarea id="t5-n6" name="revenue_address" class="form-control" readonly><?php echo $view[0]->revenu_address;?></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                <div class="form-group col-md-12">
                                    <h4>Reservation Team</h4>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="contract_fname">First Name</label><span>*</span>
                                    <input  id="contract_fname" type="text" name="contract_fname"  class="form-control contract_fname" value="<?php echo isset($view[0]->contract_name) ? $view[0]->contract_name : '' ?>" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="contract_lname">Last Name</label>
                                    <input  id="contract_lname" type="text" name="contract_lname" class="form-control contract_lname" value="<?php echo isset($view[0]->contract_lname) ? $view[0]->contract_lname : '';?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="contract_phone">Phone</label><span>*</span>
                                    <input id="contract_phone" type="number" name="contract_phone" class="hide-spinner form-control contract_phone" value="<?php echo isset($view[0]->contract_number) ? $view[0]->contract_number : '';?>" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="contract_mobile">Mobile</label><span>*</span>
                                    <input id="contract_mobile" type="number" name="contract_mobile" class="hide-spinner form-control contract_mobile" value="<?php echo isset($view[0]->contract_mobile) ? $view[0]->contract_mobile : '';?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="contract_mail">Email</label><span>*</span>
                                    <input id="contract_mail" type="email" name="contract_mail" class="form-control contract_mail" value="<?php echo isset($view[0]->contract_mail) ? $view[0]->contract_mail : '';?>" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="contracts_address">Address</label><span>*</span>
                                    <textarea id="contracts_address" name="contracts_address" class="form-control contracts_address" readonly><?php echo isset($view[0]->contracts_address) ? $view[0]->contracts_address : '';?></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <h4>Finance Team</h4>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="finance_fname">First Name</label><span>*</span>
                                    <input id="finance_fname" type="text" name="finance_fname"  class="form-control finance_fname" value="<?php echo isset($view[0]->finance_name) ? $view[0]->finance_name : '' ?>" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="finance_lname">Last Name</label>
                                    <input  type="text" name="finance_lname" class="form-control finance_lname" value="<?php echo isset($view[0]->finance_lname) ? $view[0]->finance_lname : '';?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="finance_phone">Phone</label><span>*</span>
                                    <input id="finance_phone" type="number" name="finance_phone" class="hide-spinner form-control finance_phone" value="<?php echo isset($view[0]->finance_number) ? $view[0]->finance_number : '';?>" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="finance_mobile">Mobile</label><span>*</span>
                                    <input id="finance_mobile" type="number" name="finance_mobile" class="hide-spinner form-control finance_mobile" value="<?php echo isset($view[0]->finance_mobile) ? $view[0]->finance_mobile : '';?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="finance_mail">Email</label><span>*</span>
                                    <input id="finance_mail" type="email" name="finance_mail" class="form-control finance_mail" value="<?php echo isset($view[0]->finance_mail) ? $view[0]->finance_mail : '';?>" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="finance_address">Address</label><span>*</span>
                                    <textarea id="finance_address" name="finance_address" class="form-control finance_address" readonly><?php echo isset($view[0]->finance_address) ? $view[0]->finance_address : '';?></textarea>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>