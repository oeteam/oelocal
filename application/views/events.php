<?php  init_load_frontend_header();
 ?>

<style>
  .banner-bottom {
    background-image: url("<?php echo get_cdn_url() ?>agentLoginStyle/img/eventheader.jpg");
    height: 60%;
    position: relative;
  }
  .aboutus-title {
        color: #fff;
        position: absolute;
        top: 35%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 4em;
  }
  .aboutus-desc {
    position: absolute;
    top: 55%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 2em;
    color: white;
  }
  .aboutus-desc p::first-letter {
    /*font-size: 200%;*/
    text-transform: uppercase;
    color: black;
    font-weight: bold;
    font-size: 15px;
    margin-left: 20px;
    color: #fff;
  }

</style>

      <!--baner-->
                  <!--carosel fade-->
             <!-- <img src="<?php //echo base_url() ?>uploads/about/<?php //echo $view[0]->wall_image ?>" > -->
      <!--baner-->
      <section class="banner-bottom">
        <p class="aboutus-title">Events</p>
        <div class="aboutus-desc">Dont miss the oppurtunity to be part of this events.</div>
      </section>
      <br><br>
      <section>
                  <div class="container">
                     <div class="row">
                        <?php if(!empty($view)){
                          foreach($view as $event_value){ ?>
                          <a href="<?php echo base_url()?>events_view/<?php echo $event_value->id ?>"> <div class="col-lg-4">
                              <div class="cuadro_intro_hover" style="height:245px">
                                 <img src="<?php echo get_cdn_url(); ?>uploads/events/<?php echo $event_value->id."/".$event_value->event_image ?>" class="img-responsive" width="100%"  alt=""/>
                                 <div class="caption">
                                    <div class="blur"></div>
                                    <div class="caption-text text-left">
                                       <h3 class="news-title"><?php echo $event_value->event_name; ?></h3>
                                        <p><i class="fa fa-map-marker"></i>&nbsp;&nbsp;<span><?php echo $event_value->event_adrs; ?></span></p>
                                        <p><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;&nbsp;<span><?php echo date("d M Y", strtotime($event_value->start_date)); ?> to <?php  echo date("d M Y", strtotime($event_value->end_date)); ?></span></p>
                                    </div>
                                 </div>
                              </div></a>
                           </div>
                           <?php } 
                         } else { ?>
                          <h3>No Events</h3>
                       <?php  } ?>
                        </div>
                     </div>
                  </div>
               </section>
       
     <?php init_load_frontend_footer(); ?>