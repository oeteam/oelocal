<?php init_front_head(); ?> 
<?php init_front_head_menu(); 
  $CustomerSupport = CustomerSupport();
?> 

<script type="text/javascript" src="<?php echo base_url(); ?>skin/js/xml_payment.js"></script>
<script>
  function divLoading(flag) {
  var spinWrapper = $('.spin-wrapper');
    if (flag === 'start') {
        spinWrapper.show();
    }
    if (flag === 'stop') {
        spinWrapper.fadeOut();
    }
  }
  divLoading("start");
  function FullLoading(flag, dest, from, to) {
    const fullLoading = document.querySelector('#fullLoading');
    let destination = dest || 'Dubai';
    let fromDate = from || '12/05/2018';
    let toDate = to || '16/05/2018';

    function startLoading() {
        let html = `<div id="fullLoading" class="full-loading">
        <p><img src="`+base_url+`/assets/images/logo-white.png" style="width: 128px;top: 75px;"></p>
        <img src="`+base_url+`skin/images/fullloading.gif" alt=""><div class="fl-data"><h2 class="fl-title">Searching the best prices<small style="color:white"> for you...</small></h2><div class="fl-info-card"><div class="top"><span>- Destination -</span><p>${destination}</p></div><div class="mid"><div><span>From</span><p>${fromDate}</p></div><div><span>To</span><p>${toDate}</p></div></div></div></div></div>`;
        document.body.innerHTML += html;
    }

    function stopLoading() {
      document.body.removeChild(fullLoading);
    }

    flag == 'start' ? startLoading() : stopLoading();
}
  let RoomCombination = new Array();
  RoomCombination = <?php echo json_encode($RoomCombination) ?>;
   $(".xml-default").remove();
function RoomCombinationinitCheck() {
  $(".r-type").find('input').prop('disabled',true);
  $.each(RoomCombination,function(j,v) {
    if (isNaN(RoomCombination.RoomIndex)) {
      $('#Room'+1+v.RoomIndex).prop('disabled',false);
      $('#listRoom'+1+v.RoomIndex).removeClass("hide");
      $('#Room'+1+v.RoomIndex).closest('li').find('.av-div').addClass('availability');
    } else {
      $('#Room'+1+RoomCombination.RoomIndex).prop('disabled',false);
      $('#listRoom'+1+RoomCombination.RoomIndex).removeClass("hide");
      $('#Room'+1+RoomCombination.RoomIndex).closest('li').find('.av-div').addClass('availability');
    }
    
  });
  // var availableRooms = $('.r-type--room:first-child').find('.availability').closest('li');
  // $.each(availableRooms, function(){
  //    $(this).closest('ul').prepend($(this).closest('li'));
  // })
  RoomCombinationCheck();
} 
function RoomCombinationCheck() {
  var room1 =  $('input[name="Room1"]:checked').val();
  for (var i = 2; i <= <?php echo count($_REQUEST['adults']) ?>; i++) {
    $(".r-type").find('input[name="Room'+i+'"]').prop('disabled',true);
    $(".r-type").find('input[name="Room'+i+'"]').closest('li').find('.av-div').removeClass('availability');
    $(".r-type").find('input[name="Room'+i+'"]').prop('checked',false);

  }
   $.each(RoomCombination,function(j,v) {
    for (var i = 2; i <= <?php echo count($_REQUEST['adults']) ?>; i++) {
      if (isNaN(RoomCombination.RoomIndex)) {       
        $('#listRoom'+i+v.RoomIndex[i-1]).removeClass("hide");   
      } else {
        $('#listRoom'+i+RoomCombination.RoomIndex[i-1]).removeClass("hide");
      }
    }
  });

  $.each(RoomCombination,function(j,v) {
    if (isNaN(RoomCombination.RoomIndex)) {
      if (v.RoomIndex[0]==room1) {
        for (var i = 2; i <= <?php echo count($_REQUEST['adults']) ?>; i++) {
          $('#Room'+i+v.RoomIndex[i-1]).prop('disabled',false);
          $('#Room'+i+v.RoomIndex[i-1]).closest('li').find('.av-div').addClass('availability');
        }
      }
    }
  });

  var availableRooms = $('.r-type--room').not(':first-child').find('.availability').closest('li');
  $.each(availableRooms, function(){
      $(this).closest('ul').prepend($(this).closest('li'));
  })
  var comAmnt = $('input[type="radio"]:checked').closest('li').find('.com-amnt');
  var sum = 0
  $.each(comAmnt,function(i,v) {
    sum += Number($(this).val().replace(/,/g , '')); 
  });
  $(".b-rates--grand-total").text(sum);
}
divLoading("stop");
function goBack() {
    window.history.back();
}

$(document).ready(function() {
  $('input[name="Room1"]').on('change',function() {
    RoomCombinationCheck();
  });

  $('input[type="radio"]').on('change',function() {
    var comAmnt = $('input[type="radio"]:checked').closest('li').find('.com-amnt');
    var sum = 0
    $.each(comAmnt,function(i,v) {
      sum += Number($(this).val().replace(/,/g , '')); 
    });
    $(".b-rates--grand-total").text(sum);
  });
  RoomCombinationinitCheck();
  // ConSelectFun();
  var startStamp = new Date($("#startTime").val()).getTime();
  var start = new Date($("#startTime").val());
  var maxTime = (30*60)*1000;
  var timeoutVal = Math.floor(maxTime/100);
  animateUpdate();

  function updateProgress(percentage) {
    $("#book-progress").val((100-percentage));
  }

  function animateUpdate() {
      var now = new Date();
      var timeDiff = now.getTime() - start.getTime();
      var perc = Math.round((timeDiff/maxTime)*100);
        if (perc <= 100) {
         updateProgress(perc);
         setTimeout(animateUpdate, timeoutVal);
        } else {
            // window.location = base_url+"hotels";
        }
  }
  function updateClock() {
    var now = new Date();
      var timeDiff = now.getTime() - start.getTime();
    var nowTime = new Date().getTime();

    var diff = Math.round((nowTime-startStamp)/1000);

    var d = Math.floor(diff/(24*60*60)); /* though I hope she won't be working for consecutive days :) */
    diff = diff-(d*24*60*60);
    var h = Math.floor(diff/(60*60));
    diff = diff-(h*60*60);
    var m = Math.floor(diff/(60));
    diff = diff-(m*60);
    var s = diff;
        if(m<=30) {
          if (s<10) {
            s = '0'+s;
          }
          if (m<10) {
            m = '0'+m;
          }
          $("#timeLeft").text((30-m)+":"+(60-s));
        }
  }
  setInterval(updateClock, 1000);
});
// function ConSelectFun(){
 
//   $('#stateSelect option').remove();
//     var ConSelect = $('#nationality').val();
//     $.ajax({
//         url: base_url+'payment/StateSelect?Conid='+ConSelect,
//         type: "POST",
//         data:{},
//         dataType: "json",
//         success:function(data) {
//           $('#stateSelect').append('<option value="">Select</option>');
//             $.each(data, function(i, v) {
//                 $('#stateSelect').append('<option  value="'+ v.id +'">'+ v.name +'</option>');
//             });
//         }
//     });
// }
function StateSelectFun(){
    $('#citySelect option').remove();
    var StateSelect = $('#stateSelect').val();
    $.ajax({
        url: base_url+'payment/CitySelect?Stateid='+StateSelect,
        type: "POST",
        data:{},
        dataType: "json",
        success:function(data) {
          $('#citySelect').append('<option value="">Select</option>');
            $.each(data, function(i, v) {

                $('#citySelect').append('<option  value="'+ v.id +'">'+ v.name +'</option>');
            });
        }
    });
}

$(document).ready(function() {
  if (window.history && window.history.pushState) {
    addEventListener('load', function() {
        history.pushState(null, null, null); // creates new history entry with same URL
        addEventListener('popstate', function() {
            var stayOnPage = confirm("Do you want to leave this page and search again with same keywords?");
            if (!stayOnPage) {
                window.location = "<?php echo base_url('hotels') ?>";
            } else {
               FullLoading('start', '<?php echo $_REQUEST['location'] ?>', '<?php echo date('d/m/Y' ,strtotime($_REQUEST['Check_in'])) ?>', '<?php echo date('d/m/Y' ,strtotime($_REQUEST['Check_out'])) ?>');
               history.back() 

            }
        });    
    });
}

  $(".cancellation-span").hover(function(){
    $(this).closest('.av-div').find('.cancellation-table').css("display", "block");
    }, function(){
    $(this).closest('.av-div').find('.cancellation-table').css("display", "none");
  });
})


</script>

<style>

        .m-0 {
          margin: 0;
        }

        .p-t-0 {
          padding-top: 0;
        }

        .booking-timer {
          transform: translateY(-15px)
        }
        .booking-summary {
          margin-left: 10px;
          padding-right: 10px;
        }

        .booking-details-info > div  {
          min-height: 40px;
        }

        .bg-blue {
          background-color: #0074b9
        }

        /* GUEST TABLE STYLES */
        .guest-table {
            width: 100%;
            margin: 0;
        }
        .guest-table tbody tr > td, .guest-table thead tr > th {
            padding: 5px 8px;
        }
        .guest-table thead > tr > th {
            background-color: #f5f5f5;
            color: #737373;
        }

        .guest-table .room-no > td {
            background-color: #fafafa;
            color: #0074b9;
            font-weight: 600;
            font-size: 12px;
        }

        /* r-type : Room Type */
        .r-type {
          padding: 0 15px;
        }

        .r-type--room {
          border: 1px solid #e6e6e6;
        }

        .r-type--room > h5 {
          margin: 0 -15px 10px;
          padding: 8px 15px;
          background-color: #f0f9ff;
          color: #007acc;
        }

        .r-type--room ul > li {
          margin: 0 -5px;
        }
        .r-type--room ul > li > label {
          display: block;
        }
        .r-type--room ul > li > label > input[type="radio"] {
          display: none;
        }

        .r-type--room ul > li > label > input[type="radio"] + div {
          background-color: #fafdff;
          padding: 5px;
          border-radius: 5px;
          border: 1px solid #ebebeb;
          margin-bottom: 8px;
          cursor: pointer;
          opacity: .8;
          filter: grayscale(100%);
          transition: all .3s;
        }

        .r-type--room ul > li > label > input[type="radio"] + div > h5 > i {
          /*display: none;*/
        }  

        .r-type--room ul > li > label > input[type="radio"] + div.availability  > h5 > i:first-child {
          display: none;
        }
        .r-type--room ul > li > label > input[type="radio"] + div.availability  > h5 > i:last-child {
          display: inline;
          margin-right: 2px;
        }
                 

        .availability {
          border: 1px solid #5cb880 ! important;
          filter: grayscale(0) ! important;
        }
        .r-type--room ul > li > label > input[type="radio"]:disabled + div  > h5 > i:first-child {          display: none;
        }

        .r-type--room ul > li > label > input[type="radio"]:checked + div {
          border: 1px solid #5cb880;
          opacity: 1;
          filter: none;
        }

        .r-type--room ul > li > label > input[type="radio"]:checked + div > h5 > i {
          display: none;
          margin-right: 2px;
        }

        .r-type--room ul > li > label > input[type="radio"]:checked + div.availability  > h5 > i:first-child {
          display: inline;
        }
        .r-type--room ul > li > label > input[type="radio"]:checked + div.availability  > h5 > i:last-child {
          display: none;
        }

        .r-type--name {
          font-size: 12px;
          font-weight: bold;
          color: #607D8B;
        }

        .validate + .required-msg,.name-validate + .required-msg {
          color: #e16359;
        display: block;
        text-align: right;
        margin-right: 6px;
        position: relative;
        top: -17px;
        opacity: 1;
        height: 0px;
        font-size: 11px;
        font-weight: 100;
        }

        .room-type-validate ,.traveller-validate{
          color: #e16359;
          display: block;
        }
        .validated + .required-msg, .room-type-validate.validated {
          display: none ! important;
        }

        .av-div > small {
          font-size: 11px;
          color: hsl(240, 8%, 69%);
          margin-left: 1px;
        }

        .av-div > .r-type--includes {
          color: #91919e;
        }

        

        /* b-rates : booking-rates */
        .b-rates--tax {
          background-color: #eee;
          padding: 10px 10px;
          font-weight: bold;
          margin-bottom: 0;
          color: #455A64;
        }        
        .b-rates--grand {
          margin-top: 0;
          background-color: #5cb85c;
          padding: 15px 10px;
          font-size: 18px;
          color: #fff;
          font-weight: bold;
          border-radius: 0 0 6px 6px;
        }
       /* Extra small devices (phones, 600px and down) */
        @media(max-width: 600px) {
          .bor-sm {
            border-right: none ! important;
          }
          .guest-table {
              width: 100%;
              margin-bottom: 15px;
              overflow-x: scroll;
              overflow-y: hidden;
              border: 1px solid #dddddd
          }
          .container {
            margin-right: -10px;
            margin-left: -24px;
            padding-right: 0px;
            padding-left: 0px;
          }
          .booking-summary {
            margin-top: 39px;
          }
          .container > .navbar-header, .container > .navbar-collapse {
            margin-right: 31px; 
            margin-left: 47px; 
            }
            #book-progress{
              width:100%;
            }
        } 

        /* Small devices (portrait tablets and large phones, 600px and up) */
        @media(min-width: 600px) {

          .guest-table {
            width: 100%;
          }
           .booking-summary {
            margin-top: 39px;
          }
        } 

        /* Medium devices (landscape tablets, 768px and up) */
        @media (min-width: 768px) {
          .guest-table {
            width:100%;
          }
        } 

        /* Large devices (laptops/desktops, 992px and up) */
        @media(min-width: 992px) {
          .guest-table {
            width: 100%;
          }
        } 
         /* Extra large devices (large laptops and desktops, 1200px and up) */
        @media(min-width: 1200px) {
          .guest-table {
            width: 100%;
          }
        }
        .full-loading {
            position: fixed;
            top: 0;
            width: 100%;
            bottom: 0;
            left: 0;
            background-color: #006699;
            text-align: center;
            /*font-family: 'Titillium Web';*/
            z-index: 9999999;
        }
        
        .full-loading img {
            width: 30vw;
            position: relative;
            top: -3em;
        }
        
        .fl-data {
            position: relative;
            top: -9vw;
        }
        
        .fl-title {
            text-transform: uppercase;
            margin: 0;
            letter-spacing: 2px;
            color: white;
        }
        
        .fl-subtext {
            margin: 0;
            color: white;
        }
        
        .fl-info-card {
            height: 170px;
            width: 450px;
            margin: 1.5em auto 0;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 1px 0 #ccc;
            overflow: hidden;
        }
        
        .fl-info-card .top {
            height: 70px;
            background-color: #0784ff;
            padding: 0 15px;
        }
        
        .fl-info-card .top>p {
            margin: 0;
            text-transform: uppercase;
            font-size: 20px;
            line-height: 1.5;
            color: #fff;
            font-weight: bold;
            letter-spacing: 1px;
        }
        
        .fl-info-card .top>span {
            display: block;
            text-transform: uppercase;
            font-size: 12px;
            padding-top: 10px;
            color: rgba(255, 255, 255, 0.5);
        }
        
        .fl-info-card .mid {
            display: flex;
            border-bottom: 2px solid #F5F5F5;
        }
        
        .fl-info-card .mid>div {
            flex: 1;
            padding: 10px;
            position: relative;
        }
        
        .fl-info-card .mid>div:first-child::after {
            content: "";
            height: 60%;
            background-color: #F5F5F5;
            width: 2px;
            position: absolute;
            right: 0;
            top: 20%;
        }
        
        .fl-info-card .mid>div>p {
            margin: 0;
            color: #0784ff;
        }
        
        .fl-info-card .mid>div>span {
            color: #9E9E9E;
            font-size: 14px;
        }

      </style>
  <div class="container breadcrub hidden-xs">
    <ol class="track-progress" data-steps="5">
        <li class="done">
          <span>Search</span>
        </li><li class="done">
          <span>Search Hotel</span>
          <i></i>
        </li><li class="active">
          <span>Pax Information</span>
          <i></i>
        </li><li>
          <span>Review Booking</span>
          <i></i>
        </li><li>
          <span>Confirm</span>
        </li>
      </ol>
  </div>  
  <!-- CONTENT -->
  <?php
    if (count($HotelRoom)==0) { ?>
      <style>
    .empty-state {position: relative;padding: 3em 0}
    .empty-state > img {
      left: 50%;
      position: relative;
      transform: translateX(-50%);
      opacity: .7;
      width: 100%;
      max-width: 30em;
    }
    .empty-state > .empty-state__message, .empty-state > .empty-state__info {text-align: center}
    .empty-state > .empty-state__info {color: #b3b3b3}

  </style>
  <div class="empty-state">
    <img src="<?php echo base_url(); ?>skin/images/empty-state.png" alt="No Records">
    <h4 class="empty-state__message">No results found!</h4>
    <p class="empty-state__info">This service is temporary unavailable !</p>
  </div>
    <?php } else {
          
    $start = $_REQUEST['Check_in'];
    $end = $_REQUEST['Check_out'];
    $first_date = strtotime($start);
    $second_date = strtotime($end);
      $offset = $second_date-$first_date; 
      $result = array();
      $checkin_date=date_create($_REQUEST['Check_in']);
    $checkout_date=date_create($_REQUEST['Check_out']);
    $no_of_days=date_diff($checkin_date,$checkout_date);
    $tot_days = $no_of_days->format("%a");
    for($i = 0; $i <= floor($offset/24/60/60); $i++) {
          $result[1+$i]['date'] = date('m/d/Y', strtotime($start. ' + '.$i.'  days'));
      }
    $viwedate1 = date("d/m/Y", strtotime(isset($_REQUEST['Check_in']) ? $_REQUEST['Check_in'] : ''));
        $viwedate2 = date("d/m/Y", strtotime(isset($_REQUEST['Check_out']) ? $_REQUEST['Check_out'] : ''));
  ?>
  <div class="container">
    <form id="roomdataform" name="roomdataform">
      <input type="hidden" name="hotel_id"  value="<?php echo $_REQUEST['hotel_id'] ?>">
      <textarea class="hide" name="RoomData" 
       style="display:none;"/>
        <?php echo json_encode($AvailableRooms); ?>
      </textarea>
    </form>
  <form method="get" name="xml_payment_form" id="xml_payment_form">
  <div class="col-sm-12 mt25 booking-summary">
        <div class="pagecontainer2 padding30 p-t-0" style="padding-bottom: 10px;">
          <h3 class="text-green">Booking Summary <span class="right text-right booking-timer">
              <small>Time Left : <b id="timeLeft">30:18</b></small>
              <progress id="book-progress" value="98" max="100"></progress>
            </span>
          </h3>          
          <div class="clearfix pbottom15"></div>
          <div class="row">
            <div class="col-sm-3">
              <img src="<?php echo $HotelPicture ?>" class="margtop20  img-responsive hidden-xs" width="100%" alt="">
              <p><span class="bold"><?php echo $HotelName ?></span></p>
              <?php if ($HotelRating =='OneStar' || $HotelRating =='1') {
              $star = '1';
            } else if($HotelRating =='TwoStar' || $HotelRating =='2') {
              $star = '2';
            } else if($HotelRating =='ThreeStar' || $HotelRating =='3') {
              $star = '3';
            } else if($HotelRating =='FourStar' || $HotelRating =='4') {
              $star = '4';
            } else if($HotelRating =='FiveStar' || $HotelRating =='5') {
              $star = '5';
            } ?>
              <p><img src="<?php echo base_url();?>skin/images/bigrating-<?php echo $star ?>.png" alt=""/></p>
            
              <p class="text-muted"><?php echo $HotelAdrs; ?></p>
            </div>
            <div class="col-sm-9">

              <div class="padding20 margtop15" style="background-color: #f0f9ff">
                <div class="row booking-details-info">
                  <div class="col-sm-3 col-xs-6 text-center" style="border-right: 1px dashed #bbb">
                    <span class="text-muted m-0">Check in date</span><br>
                    <span class="text-blue"><?php echo $viwedate1; ?></span>
                  </div>
                  <div class="col-sm-3 col-xs-6 text-center bor-sm" style="border-right: 1px dashed #bbb">
                    <span class="text-muted m-0">Check out date</span><br>
                    <span class="text-blue"><?php echo $viwedate2; ?></span>
                  </div>
                    <?php 
                       $adult= array_sum($_REQUEST['adults']);
                  if (isset($_REQUEST['Child'][0])) {
                    $childs= array_sum($_REQUEST['Child']);
                  } else {
                    $childs= "0";
                  }
                      $adultss= array_sum($_REQUEST['adults']); 
                    ?>
                  <div class="col-sm-3 col-xs-6 text-center" style="border-right: 1px dashed #bbb">
                    <label class="margtop10 text-muted">Adult(s) <span class="badge bg-blue"><?php echo $adultss ?></span></label>
                  </div>
                  <div class="col-sm-3 col-xs-6 text-center">
                    <label class="margtop10 text-muted">Children(s) <span class="badge bg-blue"><?php echo $childs ?></span></label>
                  </div>
                </div>

              </div>
    <input type="hidden" id="startTime" value="<?php echo date('D M d Y H:i:s',strtotime($_REQUEST['token'])); ?>">

          
        <input type="hidden" name="sessionID"  value="<?php echo $sessionId ?>">
          <input type="hidden" name="RequestType" value="<?php echo isset($_REQUEST['RequestType']) ? $_REQUEST['RequestType'] : 'Book' ?>">
        <?php foreach ($_REQUEST['adults'] as $key => $value) { ?>
          <input type="hidden" name="adults[]" value="<?php echo $value ?>">
        <?php } ?>
        <?php foreach ($_REQUEST['Child'] as $key => $value) { ?>
          <input type="hidden" name="Child[]" value="<?php echo $value ?>">
        <?php } ?>
        <input type="hidden" name="room_index"  value="<?php echo $_REQUEST['roomIndex'] ?>">
        <input type="hidden" name="no_of_days"  value="<?php echo $tot_days ?>">
        <input type="hidden" name="hotel_id" id="hotel_id" value="<?php echo $_REQUEST['hotel_id'] ?>">
        <input type="hidden" name="countryname" id="countryname" value="<?php echo $_REQUEST['countryname'] ?>">
        <input type="hidden" name="cityname" id="cityname" value="<?php echo $_REQUEST['cityname'] ?>">
        <input type="hidden" name="citycode" id="citycode" value="<?php echo $_REQUEST['citycode'] ?>">
        <input type="hidden" name="no_of_rooms" id="no_of_rooms" value="<?php echo count($_REQUEST['adults']); ?>">       
        <input type="hidden" name="Check_in" value="<?php echo isset($_REQUEST['Check_in']) ? $_REQUEST['Check_in'] : '' ?>">
        <input type="hidden"  name="Check_out"  value="<?php echo isset($_REQUEST['Check_out']) ? $_REQUEST['Check_out'] : '' ?>" />
        <?php if (isset($HotelRoom[0])) {
            $RoomTypeName = $HotelRoom[0]['RoomTypeName'];
            $xmlCurrency = $HotelRoom[0]['RoomRate']['@attributes']['Currency'];
          } else {
            $RoomTypeName = $HotelRoom['RoomTypeName'];
            $xmlCurrency = $HotelRoom['RoomRate']['@attributes']['Currency'];
          }
        ?>
              <div class="row hide">
                <div class="col-sm-12">
                  <h5 class="margtop15">Address Information</h5>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <input type="text" class="form-control email validate validated" name="email" id="email"  placeholder="Email" value="<?php echo $agent_info[0]->Email ?>">
                    <small class="required-msg">*required</small>
                  </div>
                  <div class="form-group">
                    <textarea class="form-control address1 validate validated" name="address1" id="address1" placeholder="Address Line 1"><?php echo $agent_info[0]->Address ?></textarea>
                    <small class="required-msg">*required</small>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <input type="number" class="hide-spinner  form-control contact_num validate validated" name="contact_num" id="contact_num"
                      placeholder="Contact number" value="<?php echo $agent_info[0]->Mobile ?>">
                      <small class="required-msg">*required</small>
                  </div>
                  <div class="form-group">
                    <textarea class="form-control address2" name="address2" id="address2" placeholder="Address Line 2"><?php echo $agent_info[0]->Address ?></textarea>
                  </div>
                </div>

                <div class="col-sm-3">
                  <input type="hidden" id="nationality" name="nationality" value="<?php echo $_REQUEST['nationality'] ?>">
                  <input type="hidden" name="stateSelect" value="<?php echo $agent_info[0]->State ?>">
                  <!-- <div class="multi-select-mod multi-select-trans multi-select-trans1">
                    <select name="stateSelect" id="stateSelect" class="form-control stateSelect validate validated"></select>
                    <small class="required-msg">*required</small>
                  </div> -->
                </div>
                <div class="col-sm-3"><input type="text" class="form-control citySelect validate validated" value="<?php echo $agent_info[0]->City ?>" name="citySelect" placeholder="City">
                <small class="required-msg">*required</small></div>
                <div class="col-sm-3"> <input type="text" class="form-control areacode validate validated" name="areacode" id="areacode"
                    placeholder="Area code" value="<?php echo $agent_info[0]->Fax ?>"><small class="required-msg">*required</small></div>
                <div class="col-sm-3"><input type="text" class="form-control zipcode validate validated" name="zipcode" id="zipcode" value="<?php echo $agent_info[0]->Pincode ?>" 
                    placeholder="Zip Code"><small class="required-msg">*required</small></div>
              </div>

              <h4 class="text-green margtop25">Travellers Details <small class="right traveller-validate validated"></small></h4>

          <div class="row">
            <div class="col-sm-12" >
              <table class="table table-bordered guest-table">
                <thead>
                  <tr>
                    <th class="text-center col-1">#</th>
                    <th class="col-2">Adult/Children</th>
                    <th style="width: 90px">Title</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th style="width: 110px" class="text-center">Age</th>
                  </tr>
                </thead>
                <tbody class="guesttbody">
                  <?php for ($x=0; $x < count($_REQUEST['adults']); $x++) { 
                   ?> 
                  <tr class="room-no">
                    <td class="text-center"><i class="fa fa-home"></i></td>
                    <td colspan="5">Room <?php echo $x+1 ?></td>
                  </tr>
                  <?php for ($i=0; $i < $_REQUEST['adults'][$x] ; $i++) {  ?>
                  <tr>
                    <td class="text-center"><?php echo $i+1 ?></td>
                    <td>Adult</td>
                    <td><select class="form-control input-sm Room-1Adulttitle" name="Room<?php echo $x+1 ?>Adulttitle[]">
                        <option value="Mr">Mr</option>
                        <option value="Mrs">Mrs</option>
                        <option value="Ms">Ms</option>
                        <option value="Miss">Miss</option>
                      </select></td>
                    <td><input type="text" class="form-control validated name-validate input-sm" name="Room<?php echo $x+1 ?>AdultFirstName[]">
                      <small class="required-msg">*required</small></td>
                    <td><input type="text" class="form-control validated name-validate  input-sm" name="Room<?php echo $x+1 ?>AdultLastName[]">
                      <small class="required-msg">*required</small></td>
                    <td class="text-center"><input type="number" style="width: 65px" class="form-control validate validated input-sm" name="Room<?php echo $x+1 ?>AdultAge[]">
                      <small class="required-msg">*required</small></td>
                  </tr>
                <?php } ?>
                <?php for ($j=0; $j <$_REQUEST['Child'][$x] ; $j++) { ?>
                  <tr>
                    <td class="text-center"><?php echo $j+1 ?></td>
                    <td>Child</td>
                    <td><select class="form-control input-sm Room-1Adulttitle" name="Room<?php echo ($x+1)  ?>ChildTitle[]">
                      <option value="Mr">Mr</option>
                        <option value="Ms">Ms</option>
                      </select></td>
                    <td><input type="text" class="form-control validated name-validate  input-sm" name="Room<?php echo ($x+1)  ?>ChildFirstName[]"><small class="required-msg">*required</small></td>
                    <td><input type="text" class="form-control validated name-validate input-sm" name="Room<?php echo ($x+1)  ?>ChildLastName[]"><small class="required-msg">*required</small></td>
                    <td class="text-center"><input type="number" class="form-control validate validated input-sm" name="Room<?php echo ($x+1)  ?>ChildAge[]" value="<?php echo $_REQUEST['room'.($x+1).'-childAge'][$j] ?>" readonly><small class="required-msg">*required</small></td>
                  </tr>
                <?php } ?>
                <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
          
            </div>

          </div>

            <div class="col-sm-12 ">
              <div class="row b-rates margtop10" style="background: #f0f9ff;">
              <!-- <h5 class="b-rates--tax">Tax Amount : <span class="right">AED 1250</span></h5> -->
              <h5 class="text-green pull-right" style="font-weight: bold">GRAND TOTAL : <?php echo agent_currency(); ?> <span class="b-rates--grand-total">0</span><button class="bluebtn" id="Continue_book_xml" type="button" name="Continue_book_xml" style="margin-left: 5px">Continue</button><span>
            </h5>
            </div>
          </div>
          <h4 class="text-green margtop10">Room Types <small class="right room-type-validate validated">*Please select all room combination</small></h4>
          <?php
           if (isset($HotelRoom[0])) {
              $RoomTypeName = $HotelRoom[0]['RoomTypeName'];
              $xmlCurrency = $HotelRoom[0]['RoomRate']['@attributes']['Currency'];
            } else {
              $RoomTypeName = $HotelRoom['RoomTypeName'];
              $xmlCurrency = $HotelRoom['RoomRate']['@attributes']['Currency'];
            }
          ?>
          <div class="row r-type margtop10">
            <?php
            $total_markup = $agent_markup+$admin_markup;
            if ($revenue_markup!='') {
              $total_markup = $agent_markup+$revenue_markup;
            }
            $div = 12/count($_REQUEST['adults']);
             for ($i=0; $i < count($_REQUEST['adults']) ; $i++) { ?> 
            <div class="col-sm-<?php echo $div ?> r-type--room">
              <h5>Room <?php echo $i+1 ?> (Adult <?php echo $_REQUEST['adults'][$i] ?><?php echo $_REQUEST['Child'][$i]!="" && $_REQUEST['Child'][$i]!=0 ? ' Child '.$_REQUEST['Child'][$i] : '' ?>)</h5>
              <ul class="list-unstyled r-type--list">
                <?php 
                 if (isset($HotelRoom[0])) {
                  $HotelRooms = $HotelRoom;
                } else {
                  $HotelRooms[0] = $HotelRoom;
                }
                foreach ($HotelRooms as $key => $value) { 
                  // print_r($value['CancelPolicies']);
                  $checked = '';
                  if ($key==0 && $i==0) {
                    $checked ='checked';
                  }
                // foreach ($RoomCombination as $combination) {
                //   if($combination['RoomIndex'][$i]==$value['RoomIndex']) {
                ?> 
                <li id="listRoom<?php echo $i+1 ?><?php echo $value['RoomIndex'] ?>" class="hide">
                  <label for="Room<?php echo $i+1 ?><?php echo $value['RoomIndex'] ?>">
                    <input type="radio" <?php echo $checked; ?> name="Room<?php echo $i+1 ?>" id="Room<?php echo $i+1 ?><?php echo $value['RoomIndex'] ?>" value="<?php echo $value['RoomIndex'] ?>">
                    <div class="av-div">
                       <h5 class="r-type--name m-0"><i class="fa fa-check-circle text-green"></i><i class="fa fa-circle-thin text-green" style="    margin-right: 2px;"></i><?php echo $value['RoomTypeName'] ?> - <?php echo count($value['Inclusion'])!=0 ? $value['Inclusion'] : 'Room Only' ?>
                     <?php 
                     if (isset($value['CancelPolicies']['CancelPolicy'][0])) {
                                  $cancelList = $value['CancelPolicies']['CancelPolicy'];
                                } else {
                                  $cancelList[0] = $value['CancelPolicies']['CancelPolicy'];
                               } 
                               if (isset($value['CancelPolicies']['CancelPolicy'][0])) {
                                  $NoShowPolicy = $value['CancelPolicies']['NoShowPolicy'];
                                } else {
                                  $NoShowPolicy[0] = $value['CancelPolicies']['NoShowPolicy'];
                               } 
                               if(isset($cancelList[0]['@attributes']) && $cancelList[0]['@attributes']['CancellationCharge']==0) { ?>
                                <span class="pull-right" data-toggle="modal" data-target="#myModalRoom<?php echo $i+1 ?><?php echo $value['RoomIndex'] ?>">Free of Cancellation till <?php echo $cancelList[0]['@attributes']['ToDate']?> <span>
                               <?php } else { ?>
                                  <span class="pull-right" data-toggle="modal" data-target="#myModalRoom<?php echo $i+1 ?><?php echo $value['RoomIndex'] ?>">cancellation<span>
                              <?php } ?>
                        </h5>

                      
                      <?php if(!is_array($value['Inclusion']) && count($value['Inclusion'])!=0) { ?>
                      <small class="r-type-includes"><?php echo is_array($value['Inclusion']) && count($value['Inclusion'])==0 ? '' : $value['Inclusion'] ?></small><br>
                     <?php } ?>
                      <?php 
                      if (isset($value['Supplements']['Supplement'][0])) {
                        $Supplements = $value['Supplements']['Supplement'];
                      } else {
                        $Supplements[0] = $value['Supplements']['Supplement'];
                      }
                      foreach ($Supplements as $key1 => $value1) {
                        if (isset($value1['@attributes']['SuppName'])) { 
                            ?>
                            <p class="m-0" style="color: hsl(240, 8%, 69%)">
                            <small><?php echo $value1['@attributes']['SuppName'] ?> - <?php echo $value1['@attributes']['SuppChargeType']=="AtProperty" ? '<span style="color: #0074b9;" title="Exclusive">Excl.</span> ' : '<span style="color: #0074b9;" title="Inclusive">Incl.</span> '  ?> <?php 
                          $suppl = $value1['@attributes']['Price'];
                          $supplAmnt = ($suppl*$total_markup)/100+$suppl;
                          echo $value1['@attributes']['CurrencyCode'].' '.$suppl; ?></small>
                          </p>

                      <?php  }
                      } ?>
                      <?php $DayRates = $value['RoomRate']['@attributes']['TotalFare'];
                        $DayRates = ($DayRates*$total_markup)/100+$DayRates ?>
                      <p class="text-green m-0 bold">
                        <input type="hidden" class="com-amnt" value="<?php echo xml_currency_change($DayRates,$value['RoomRate']['@attributes']['Currency'],agent_currency()); ?>">
                        <small><?php echo agent_currency().' '.xml_currency_change($DayRates,$value['RoomRate']['@attributes']['Currency'],agent_currency()); ?></small>
                      </p>
                    </div>
                  </label>
                </li>
                <div id="myModalRoom<?php echo $i+1 ?><?php echo $value['RoomIndex'] ?>" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-sm">

                          <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Cancellation Policies</h4>
                              </div>
                              <div class="modal-body">
                                  <table class="table table-bordered table-hover cancellation-table">
                                    <thead style="background: #0074b9;color: white;">
                                      <tr>
                                        <td>Cancelled on or After</td>
                                        <td>Cancelled on or Before</td>
                                        <td>Cancellation Charge</td>
                                      </tr>
                                    </thead>
                                    <tbody style="background: white;color: black;">
                                      <?php 
                                        if (isset($cancelList[0]['@attributes'])) {
                                          foreach ($cancelList as $key => $value1) {
                                      ?>
                                      <tr>
                                        <td><?php echo $value1['@attributes']['FromDate'] ?></td>
                                        <td><?php echo $value1['@attributes']['ToDate'] ?></td>
                                        <td><?php echo $value1['@attributes']['CancellationCharge']; if($value1['@attributes']['ChargeType']=='Percentage') { 
                                            echo '%' ; 
                                          } else { 
                                            echo ' USD'; 
                                          } ?> 
                                        </td>
                                      </tr>
                                    <?php } } ?>
                                    <?php 
                                        if (isset($NoShowPolicy[0]['@attributes'])) {
                                          foreach ($NoShowPolicy as $key => $value1) {
                                      ?>
                                      <tr>
                                        <td><?php echo $value1['@attributes']['FromDate'] ?></td>
                                        <td><?php echo $value1['@attributes']['ToDate'] ?></td>
                                        <td><?php echo $value1['@attributes']['CancellationCharge']; if($value1['@attributes']['ChargeType']=='Percentage') { 
                                            echo '%' ; 
                                          } else { 
                                            echo ' USD'; 
                                          } ?> 
                                        </td>
                                      </tr>
                                    <?php } } ?>
                                    <tr>
                                      <td colspan="3">
                                        <?php echo $value['CancelPolicies']['DefaultPolicy']?>
                                      </td>
                                    </tr>
                                    </tbody>
                                  </table>
                              </div>
                            </div>
                          </div>
                </div>
                 <?php //}
                // } 
              }?>
              </ul>
            </div>
            <?php } ?>
            <div class="col-md-2 col-md-offset-5">
              <div class="spin-wrapper" style="display: none">
                <img style="width: 100px;" src="<?php echo base_url(); ?>/assets/images/ellipsis-spinner.gif" alt="">
              </div>
            </div>
          </div>
        </div>
  </div>

  </div>
  </form>
    
    <!-- END OF RIGHT CONTENT -->
  </div>
</div>
<?php  } ?>
<!-- END OF CONTENT -->
  
  <!-- Central Modal Medium Warning -->
  <div class="modal fade " id="boardAllocation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  
  </div>
  <!-- Central Modal Medium Warning-->
  

<?php init_front_black_tail(); ?> 

  


