<?php  init_load_frontend_header();
 ?>

<style>
  .aboutus-title {
      color: black;
      top: 12%;
      font-size: 5em;
  }
  .aboutus-content {
      color: black;
      top: 38%;
      font-size: 2em;
  }
  .aboutus-desc {
      margin-top: 30px;
      margin: 3em auto 8em;
  }
  .aboutus-desc p::first-letter {
      text-transform: uppercase;
      color: black;
      font-weight: bold;
      font-size: 15px;
      margin-left: 20px;
  }
  .banner-bottom {
      background-image: url("<?php echo base_url() ?>agentLoginStyle/img/eventheader.jpg");
      height: 60%;
      position: relative;
      margin-bottom: 10px;
  }
  .title {
      color: #fff;
      position: absolute;
      top: 35%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 4em;
  }
  .desc {
      position: absolute;
      top: 55%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 2em;
      color: white;
  }
   .content-title {
      font-size: 4em;
  }


</style>
       <section class="banner-bottom">
        <p class="title">Events</p>
        <div class="desc">Dont miss the oppurtunity to be part of this events.</div>
      </section>
      <div class="row">
        <p class="text-center content-title"><?php echo $view[0]->event_name ?></p>
        <div class="col-md-6">
          <!-- <section class="banner-bottom"> -->
          <img src="<?php echo base_url()?>uploads/events/<?php echo $view[0]->id ?>/<?php echo $view[0]->event_image ?>" style="width: 100%" class="img-responsive">
      <!--   </section> -->
        </div>
        <div class="col-md-6">
          
         <!--  <section class="aboutus-desc">
            <div class="container aboutus-desc">
              <div class="row"> -->
                <div class="aboutus-desc">
                  <p><?php echo $view[0]->event_description ?></p>
                </div>
                <p><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo date("d M Y", strtotime($view[0]->start_date)); ?> to <?php  echo date("d M Y", strtotime($view[0]->end_date)); ?></p>
              <!-- </div>
            </div>
          </section> -->
        </div>
      </div>
      
        
       
       
     <?php init_load_frontend_footer(); ?>