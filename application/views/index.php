<?php init_load_frontend_header(); 

$HotelsView = HotelsView();
$Hotelsbanner = Hotelsbanner();
// print_r($Hotelsbanner);exit;
?>
<!-- <script type="text/javascript">
   if (location.protocol != 'https:')
   {
    location.href = 'https:' + window.location.href.substring(window.location.protocol.length);
   }
</script> -->
<!--baner-->

<section>
   <div id="carouselFade" class="carousel slide carousel-fade" data-ride="carousel">
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
         <div class="item active">
            <div class="bnr-ad"></div>
            <div class="carousel-caption">
               <h3>Top International Hotels and Corporate Partner Are Now Connected</h3>
               <p>Top International Hotels and Corporate Partner  with otelseasy.com</p>
            </div>
         </div>
         <div class="item">
            <div class="carousel-caption">
                     <!--                  <h3>Extraordinary Experience</h3>
                        <p>Start the day relaxing over a cup of hot coffee at your private sit out, as you enjoy the Sun come through the misty mountains among clatter of the fauna and flora that surround you. </p>-->
                     </div>
                  </div>
                  <div class="item">
                     <div class="carousel-caption">
                     <!--        <h3>Want to enjoy something unique? </h3>
                        <p>Be sure to enjoy a nice dip in your private plunge pool.</p>-->
                     </div>
                  </div>
               </div>
               <div id="box-hldr">
                  <div class="col-md-12">
                     <div class="panel with-nav-tabs panel-info">
                        <div class="panel-heading toggle-style">
                           <ul class="nav nav-tabs">
                              <li class="active small-width-100"><a href="#Agentlogin" data-toggle="tab"> Agent Login </a></li>
                              <li class="hidden-xs"><a href="#SupplierLogin" data-toggle="tab"> Supplier Login</a></li>
                           </ul>
                        </div>

                        <div class="panel-body">
                           <div class="tab-content">
                              <div id="Agentlogin" class="tab-pane fade in active register">
                                 <div class="container-fluid">
                                    <form  method="post" action="<?php echo base_url('hotels'); ?>" id="front_login">
                                       <div class="row">
                                          <div class="row">
                                             <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                   <div class="input-group">
                                                      <div class="input-group-addon">
                                                         <span class="fa fa-key"></span>
                                                      </div>
                                                      <input type="text" name="agent_code" id="agent_code" placeholder="Agent Code" class="form-control">
                                                   </div>
                                                </div>
                                                <div class="form-group">
                                                   <div class="input-group">
                                                      <div class="input-group-addon">
                                                         <span class="glyphicon glyphicon-user"></span>
                                                      </div>
                                                      <input type="text" placeholder="User Name" name="user_name" id="user_name" class="form-control">
                                                   </div>
                                                </div>
                                             </div>

                                          </div>
                                          <div class="row">
                                             <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                   <div class="input-group">
                                                      <div class="input-group-addon">
                                                         <span class="glyphicon glyphicon-lock"></span>
                                                      </div>

                                                      <input type="password" placeholder="Password" name="password" class="form-control">
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <p>
                                             <span class="error_msg"></span>
                                          </p>
                                          <!-- <div class="col-xs-12 col-sm-12 col-md-12">-->
                                             <div class="col-xs-8 col-sm-8 col-md-8">
                                                <div class="form-group">
                                                   <div class="account">
                                                      <a href="<?php echo base_url('forgetAgentPassword') ?>" data-toggle="modal" target="_blank"> Can't access my account!</a>
                                                   </div>
                                                </div>
                                             </div>

                                             <div class="col-xs-4 col-sm-4 col-md-4">
                                                <div class="btn-hldr">
                                                   <button type="submit" class="btn btn-primary" type="submit" id="login_form_frontend_button">Sign In</button>
                                                </div>
                                             </div>
                                          </form>
                                       </div>

                                    </div> 
                                    <div class="row">
                                       <div class="panel-footer">
                                          <div class="panel-heading">
                                             <a style="text-decoration:none !important;" href="<?php echo base_url('Profile/agent_register'); ?>" >
                                                <h3 class="panel-title" >Register your company today</h3>
                                             </a>
                                          </div>
                                       </div>
                                    </div>
                                 </div>

                                 <div id="SupplierLogin" class="tab-pane fade">
                                    <div class="container-fluid">
                                       <div class="row">
                                          <form method="post" action="<?php echo base_url('dashboard/hotel_panel'); ?>" id="hotel_panel_login">
                                             <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                   <div class="form-group">
                                                      <div class="input-group">
                                                         <div class="input-group-addon iga1">
                                                            <span class="fa fa-key"></span>
                                                         </div>
                                                         <input type="text" class="form-control" name="user_name" id="user_name" placeholder="Hotel code" class="validate">
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                   <div class="form-group">
                                                      <div class="input-group">
                                                         <div class="input-group-addon iga1">
                                                            <span class="glyphicon glyphicon-lock"></span>
                                                         </div>
                                                         <input type="password" class="form-control" name="password" id="password" placeholder="Password" class="validate">
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <p>
                                                <span class="error_msg1"></span>
                                             </p>
                                             <div class="col-xs-8 col-sm-8 col-md-8">
                                                <div class="form-group">
                                                   <div class="account">
                                                      <input type="checkbox" id="KeepMe" />
                                                      <label for="KeepMe">Keep me signed in</label>
                                                   </div>
                                                </div>
                                             </div>

                                             <div class="col-xs-4 col-sm-4 col-md-4">
                                                <div class="btn-hldr">
                                                   <button class="btn btn-primary"  id="login_form_hotel_panel" type="Submit">Sign In</button>
                                                </div>
                                             </div>
                                          </form>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="panel-footer">
                                          <div class="panel-heading">
                                             <a style="text-decoration:none !important;" href="#" data-toggle="modal" data-target="#myModal">
                                                <h3 class="panel-title" >Register your hotel today</h3>
                                             </a>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div><!--panel-body-->

                        </div>
                     </div>
                  </div>
                  <!--carosel fade-->
               </section>
               <!--baner-->
               <section class="baner-botom hidden-xs">
                  <div class="container">
                     <div class="row">
                        <div class="col-md-4">
                           <p class="news-evnts">Latest Events,Deals and News</p>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                           <a href='<?php echo base_url()?>events'><p class="view-more">View More</p></a>
                        </div>
                     </div>
                  </div>
               </section>
               <section>
                  <div class="container hidden-xs">
                     <div class="row">
                        <?php
                         foreach($HotelsView as $h_value){
                          ?>
                           <div class="col-lg-3">
                              <div class="cuadro_intro_hover ">
                                 <img src="<?php echo base_url(); ?>uploads/gallery/<?php echo $h_value->id."/".$h_value->Image1 ?>" class="img-responsive" width="100%"  alt=""/>
                                 <div class="caption">
                                    <div class="blur"></div>
                                    <div class="caption-text">
                                       <h3 class="news-title"><?php echo $h_value->hotel_name; ?></h3>
                                       <p class="news-dec"><?php echo strlen($h_value->hotel_description) > 80 ? mb_substr($h_value->hotel_description,0,80).'..' : $h_value->hotel_description ; ?></p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <?php } ?>
                        </div>
                     </div>
                  </div>
               </section>
               <section class="hidden-xs">
                  <div class="container">
                     <div class="row">
                        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                         <!-- otelseasy1 -->
                         <ins class="adsbygoogle"
                              style="display:block"
                              data-ad-client="ca-pub-3420800144798744"
                              data-ad-slot="2997535336"
                              data-ad-format="auto"
                              data-full-width-responsive="true"></ins>
                         <script>
                         (adsbygoogle = window.adsbygoogle || []).push({});
                         </script>
                     </div>
                  </div>
               </section>
               <section class="midle-sec hidden-xs">
                  <div class="container">
                     <div class="row">
                        <div class="col-md-6">
                           <div class="signup-hldr">
                              <h3 class="signup-title">The hottest hotel deals.Straight to your inbox</h3>
                              <div class="advance-search">
                                 <form  method="post" action="" >
                                    <div class="row">
                                       <!-- Store Search -->
                                       <div class="col-lg-9">
                                          <div class="block d-flex">
                                             <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="search" placeholder="Search ">
                                             <!-- Search Button -->
                                             <button class="btn btn-main">SEARCH</button>
                                          </div>
                                       </div>
                                    </div>
                                 </form>
                              </div>
                              <h3 class="signup-title">So many fans, but who's counting?</h3>
                                 <!-- Total -->
                                 <!-- Facebook -->

                                 <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fotelseasy&tabs&width=340&height=70&small_header=true&adapt_container_width=true&hide_cover=true&show_facepile=true&appId" width="340" height="70" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>

                                <!--  <button data-easyshare-button="facebook">
                                    <span class="fa fa-facebook"></span>
                                    <span></span>
                                 </button>
                                 <span data-easyshare-button-count="facebook">0</span> -->
                                 <!-- Google+ -->
                                 <!-- <button data-easyshare-button="google">
                                    <span class="fa fa-google-plus"></span>
                                    <span>+1</span>
                                 </button>
                                 <span data-easyshare-button-count="google">0</span>
                                 <button data-easyshare-button="linkedin">
                                    <span class="fa fa-youtube-square"></span>
                                 </button>
                                 <span data-easyshare-button-count="linkedin">0</span>  -->
                             <!--  <div data-easyshare data-easyshare-url="">
                              </div> -->
                           </div>
                        </div>

                           <div class="col-md-6" style="background-color: #f4f4f4;">
                              <?php if (count($Hotelsbanner)!=0) { ?>
                              <div class="cuadro_intro_hover" style="height:275px">
                                 <div>
                                 <img src="<?php echo base_url(); ?>uploads/gallery/<?php echo $Hotelsbanner[0]->id."/".$Hotelsbanner[0]->Image1 ?>" class="img-responsive"  alt="" style="height:100%;margin: 0 auto;"/>
                                 </div>
                                 <div class="caption" style="top:200px">
                                    <div class="blur"></div>
                                    <div class="caption-text">
                                       <h3 class="news-title"><?php echo $Hotelsbanner[0]->hotel_name; ?></h3>
                                       <p class="news-dec"><?php echo strlen($Hotelsbanner[0]->hotel_description) > 80 ? mb_substr($Hotelsbanner[0]->hotel_description,0,80).'..' : $Hotelsbanner[0]->hotel_description ; ?></p>
                                    </div>
                                 </div>
                              </div>
                              <?php } ?>
                           </div>
                     </div>
                  </div>
               </section>
               <!-- Modal -->
               <div id="myModal" class="modal fade" role="dialog">
                 <div class="col-md-10 col-md-offset-1" style="margin-top: 3%">
                   <!-- Modal content-->
                   <div class="modal-content">
                    <form method="post" action="<?php echo base_url('dashboard/popup'); ?>" id="front_hotel_add"> 
                     <div class="modal-header">
                       <button type="button" class="close button-class" data-dismiss="modal"><img src="<?php echo base_url(); ?>/assets/images/closeall.png" width="20px"> </button>
                    </div>
                    <div class="modal-body">
                     <div class="col-sm-12">
                        <h3 class="formheadingrg"><span></span> Hotel Details</h3>
                     </div>
                     <div class="row">
                        <div class="col-sm-6">
                         <div class=form-horizondal>
                          <div class="form-group">
                           <label for="inputEmail3" class="col-sm-3 control-label fontstyl">Hotel Name :<span class="starcolor">*</span></label>
                           <div class="col-sm-9">
                             <input type="text" class="form-control" name="property" id="property" >
                             <span class="property_err popup_err blink_me"></span>
                          </div>
                       </div>
                    </div>
                 </div>
                 <div class="col-sm-6">
                   <div class=form-horizondal>
                    <div class="form-group">
                     <label for="inputEmail3" class="col-sm-3 control-label fontstyl">Selling Currency:<span class="starcolor">*</span></label>
                     <div class="col-sm-9">
                       <select type="text" class="form-control" name="sell_currency" id="sell_currency">
                         <?php foreach ($currency_list as $key => $value) { 
                           if($view[0]->currency_type==$value->currency_type) {?>
                              <option selected="" value="<?php echo $value->currency_type ?>"><?php echo $value->currency_name. ' ('.($value->currency_type).')'?></option>
                              <?php } else { ?>
                                 <option  value="<?php echo $value->currency_type ?>"><?php echo $value->currency_name. ' ('.($value->currency_type).')' ?></option>
                                 <?php  } } ?>
                              </select>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-6">
                   <div class=form-horizondal>
                    <div class="form-group">
                     <label for="inputEmail3" class="col-sm-3 control-label fontstyl">Star Ratings :</label>
                     <div class="col-sm-9">
                       <fieldset>
                         <div class="col-sm-12">
                          <span class="star-cb-group form">
                            <input type="radio" id="rating-1" name="str1" value="1" /><label for="rating-1">1</label>
                            <input type="radio" id="rating-2" name="str1" value="2" /><label for="rating-2">2</label>
                            <input type="radio" id="rating-3" name="str1" value="3" /><label for="rating-3">3</label>
                            <input type="radio" id="rating-4" name="str1" value="3" /><label for="rating-3">4</label>
                            <input type="radio" id="rating-5" name="str1" value="5" checked="checked"/><label for="rating-5">5</label>
                            <input type="radio" id="rating-10" name="str1" value="10"/><label for="10">Hotel Apartment</label>
                         </span>
                      </div>
                   </fieldset>
                </div>
             </div>
          </div>
       </div>
       <div class="col-sm-6">
          <div class=form-horizondal>
           <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label fontstyl">Accepting VCC :</label>
            <div class="col-sm-9">
              <fieldset>
                <span class="star-cb-group">
                  <input type="radio" id="acs" name="acs" value="0" checked="checked" /><label for="yes">Yes</label>
                  <input type="radio" id="acs" name="acs" value="1" /><label for="rating-5">No</label>
               </span>
            </fieldset>
         </div>
      </div>
   </div>
</div>
</div>
<div class="row">
   <div class="col-sm-6">
    <div class=form-horizondal>
     <div class="form-group">
      <label for="inputEmail3" class="col-sm-3 control-label fontstyl">No of Rooms :<span class="starcolor">*</span></label>
      <div class="col-sm-9">
        <input type="number" class="form-control" id="numroom" name="numroom">
        <span class="numroom_err popup_err blink_me"></span>
     </div>
  </div>
</div>
</div>
<div class="col-sm-6">
 <div class=form-horizondal>
  <div class="form-group">
   <label for="inputEmail3" class="col-sm-3 control-label fontstyl">Channel Manager:(if any)</label>
   <div class="col-sm-9">
     <input type="text" class="form-control" id="channel" name="channel">
  </div>
</div>
</div>
</div>
</div>
<div class="row">
   <div class="col-sm-6">
    <div class=form-horizondal>
     <div class="form-group">
      <label for="inputEmail3" class="col-sm-3 control-label fontstyl">Website :</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" id="website" name="website">
        <span class="website_err popup_err blink_me"></span>
     </div>
  </div>
</div>
</div>
<div class="col-sm-6">
 <div class=form-horizondal>
  <div class="form-group">
   <label for="inputEmail3" class="col-sm-3 control-label fontstyl ">Part of Any Chain or Collection:</label>
   <div class="col-sm-9">
     <input type="text" class="form-control" id="chain" name="chain">
  </div>
</div>
</div>
</div>
</div>  <hr>
<div class="col-sm-12">
   <h3 class="formheadingrg"><span></span>Contact Details</h3>
</div>
<br><br>
<div class="row">
   <div class="col-sm-1">
   </div>
   <div class="col-sm-2">
   </div>
   <div class="col-sm-2">
    <div class="form-group">
       <label for="Sales" class="fontstyl">Sales Team</label>
    </div>
 </div>
 <div class="col-sm-2">
    <div class="form-group">
       <label for="Revenue" class="fontstyl">Revenue Team</label>
    </div>
 </div>
 <div class="col-sm-2">
    <div class="form-group">
       <label for="Revenue" class="fontstyl">Contract Team</label>
    </div>
 </div>
 <div class="col-sm-2">
    <div class="form-group">
       <label for="Revenue" class="fontstyl">Finance Team</label>
    </div>
 </div>
 <div class="col-sm-1">
 </div>
</div> 
<div class="row">
   <div class="col-sm-1">
   </div>
   <div class="col-sm-2">
    <label for="salename"  class="fontstyl">Name<span class="starcolor">*</span></label>
 </div>
 <div class="col-sm-2">
    <div class="form-group">
       <input type="text" class="form-control " id="sale_name" name="sale_name">
       <span class="sale_name_err popup_err blink_me"></span>
    </div>
 </div>
 <div class="col-sm-2">
    <div class="form-group">
       <input type="text" class="form-control" id="revenu_name" name="revenu_name">
       <span class="revenu_name_err popup_err blink_me"></span>
    </div>
 </div>
 <div class="col-sm-2">
    <div class="form-group">
       <input type="text" class="form-control " id="contract_name" name="contract_name">
       <span class="contract_name_err popup_err blink_me"></span>
    </div>
 </div>
 <div class="col-sm-2">
    <div class="form-group">
       <input type="text" class="form-control " id="finance_name" name="finance_name">
       <span class="finance_name_err popup_err blink_me"></span>
    </div>
 </div>
</div>
<div class="row">
   <div class="col-sm-1">
   </div>
   <div class="col-sm-2">
    <label for="mailstr"  class="fontstyl">Email<span class="starcolor">*</span></label>
 </div>
 <div class="col-sm-2">
    <div class="form-group">
       <input type="email" class="form-control " id="sale_mail" name="sale_mail">
       <span class="sale_mail_err popup_err blink_me"></span>
    </div>
 </div>
 <div class="col-sm-2">
    <div class="form-group">
       <input type="email" class="form-control" id="revenu_mail" name="revenu_mail">
       <span class="revenu_mail_err popup_err blink_me"></span>
    </div>
 </div>
 <div class="col-sm-2">
    <div class="form-group">
       <input type="email" class="form-control " id="contract_mail" name="contract_mail">
       <span class="contract_mail_err popup_err blink_me"></span>
    </div>
 </div>
 <div class="col-sm-2">
    <div class="form-group">
       <input type="email" class="form-control " id="finance_mail" name="finance_mail">
       <span class="finance_mail_err popup_err blink_me"></span>
    </div>
 </div>
</div> 
<div class="row">
   <div class="col-sm-1">
   </div>
   <div class="col-sm-2">
    <label for="mbnum"  class="fontstyl">Number:<span class="starcolor">*</span></label>
 </div>
 <div class="col-sm-2">
    <div class="form-group">
       <input type="text" class="hide-spinner form-control " id="sale_number" name="sale_number">
       <span class="sale_number_err popup_err blink_me"></span>
    </div>
 </div>
 <div class="col-sm-2">
    <div class="form-group">
       <input type="text" class="hide-spinner form-control" id="revenu_number" name="revenu_number">
       <span class="revenu_number_err popup_err blink_me"></span>
    </div>
 </div>
 <div class="col-sm-2">
    <div class="form-group">
       <input type="text" class="form-control " id="contract_number" name="contract_number">
       <span class="contract_number_err popup_err blink_me"></span>
    </div>
 </div>
 <div class="col-sm-2">
    <div class="form-group">
       <input type="text" class="form-control " id="finance_number" name="finance_number">
       <span class="finance_number_err popup_err blink_me"></span>
    </div>
 </div>

</div>
<div class="row">
   <div class="col-sm-1">
   </div>
   <div class="col-sm-2">
    <label for="mailstr"  class="fontstyl">Password<span class="starcolor">*</span></label>
 </div>
 <div class="col-sm-2">
    <div class="form-group">
       <input type="password" class="form-control " id="sale_password" name="sale_password">
       <span class="sale_password_err popup_err blink_me"></span>
    </div>
 </div>
 <div class="col-sm-2">
    <div class="form-group">
       <input type="password" class="form-control" id="revenu_password" name="revenu_password">
       <span class="revenu_password_err popup_err blink_me"></span>
    </div>
 </div>
 <div class="col-sm-2">
    <div class="form-group">
       <input type="password" class="form-control " id="contract_password" name="contract_password">
       <span class="contract_password_err popup_err blink_me"></span>
    </div>
 </div>
 <div class="col-sm-2">
    <div class="form-group">
       <input type="password" class="form-control " id="finance_password" name="finance_password">
       <span class="finance_password_err popup_err blink_me"></span>
    </div>
 </div>
</div> 
<div class="row">
   <div class="col-sm-1">
   </div>
   <div class="col-sm-2">

   </div>
   <div class="col-sm-2">
     <div class="form-group">
                <!-- <input type="password" class="form-control " id="sale_password" name="sale_password">
                   <span class="sale_password_err popup_err blink_me"></span> --> 
                </div>
             </div>
             <div class="col-sm-2">
                <div class="form-group">
                 <input type="checkbox" class="filled-in" name="check1" id="check1" />
                 <label for="check1">Same as SalesTeam</label>
              </div>
           </div>
           <div class="col-sm-2">
             <div class="form-group">
                <input type="checkbox" class="filled-in" name="check2" id="check2" />
                <label for="check1">Same as RevenueTeam</label>
             </div>
          </div>
          <div class="col-sm-2">
             <div class="form-group">
              <input type="checkbox" class="filled-in" name="check3" id="check3" />
              <label for="check1">Same as ContractTeam</label>
           </div>
        </div>
        <div class="col-sm-1">
        </div>

     </div> 
     <div class="modal-footer">
        <button action="#" type="button" class="btn btn-warning button-class" id="login_form_add_hotel" value="Adding" name="login_form_add_hotel">Send</button>
     </div>
  </form>
</div>

</div>
</div>
<!-- Modal -->

<?php init_load_frontend_footer(); ?>
