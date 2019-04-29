<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class lists extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->helper('html');
    $this->load->helper('file');
    $this->load->helper('common');
    $this->load->helper('upload');
    $this->load->library("Pagination");
    $this->load->library("Ajax_pagination");
    $this->load->model('List_Model');
    $this->load->library('javascript');
    $this->load->library('table');
    $this->load->helper('html');
    $this->load->library("session");
  }
  
  public function index()
  {
    if ($this->session->userdata('agent_name')=="") {
      redirect("../backend/logout/agent_logout");
    }
    $data['agent_currency'] =  agent_currency();
    $data['list'] =  $this->List_Model->temporarySearchProcess($_REQUEST);
    $data['nationality'] = $this->List_Model->getNationality();
    $data['hotel_facilities_list'] = $this->List_Model->hotel_facilities_list();
    // permission_get();
    $this->load->view('frontend/lists/index',$data); 
  }
  public function fav_search_list(){
    $data=$this->session->userdata();
    print_r($data);
  }
  public function search_list() {
    if ($_REQUEST['temp']==1) {
    // $listarray = json_decode($_REQUEST['listarray']);
    $path  = get_upload_path_by_type('searchdata') . $this->session->userdata('agent_id') . '/';
    $myFile = $path.date('Ymd').'search.txt';
    $temparray = file_get_contents($myFile);
    $listarray = json_decode($temparray,true);
    $Otelseasyoutput = $listarray['OtelseasyHotels'];
    $TBOoutput = $listarray['TBOHotels'];
    $mergeData = array_merge($Otelseasyoutput,$TBOoutput);
    $this->db->query("CREATE TABLE IF NOT EXISTS ci_sessions(HotelCode VARCHAR(100), HotelName VARCHAR(255), HotelPicture VARCHAR(2000), HotelDescription VARCHAR(2000),RoomName VARCHAR(255),Rating INT(11),TotalPrice VARCHAR(255),Currency VARCHAR(100),OriginalPrice VARCHAR(255),oldPrice VARCHAR(255),DataType VARCHAR(255),RatingImg VARCHAR(255),ReviewImg VARCHAR(2000),reviews VARCHAR(255),BookBtn VARCHAR(1000),HotelRequest VARCHAR(5000),Inclusion VARCHAR(2000),agent_id INT(11),ip_add VARCHAR(255),searchDate VARCHAR(255))");
        $ip_add = get_client_ip();
        $this->db->query("DELETE FROM ci_sessions where agent_id = ".$this->session->userdata('agent_id')." and ip_add = '".$ip_add."'");
        $this->db->query("DELETE FROM ci_sessions where searchDate < '".date('Y-m-d',strtotime('-1 day'))."'");
        foreach ($mergeData as $key => $value) {
                if ($value['DataType']!="TBO") {
                    if ($value['Rating']!=10) {
                        $RatingImg = '<img src="'.base_url().'skin/images/filter-rating-'.ceil($value['Rating']).ceil($value['Rating']).'.png" class="hotel-rating" alt=""/>';
                    } else {
                        $RatingImg = '<label style="width:100px;" class="hotel-rating"><i class="fa fa-building" style="color: #258732;"></i> Apartment</label>';
                    }
                    $ReviewImg =  base_url().'skin/images/user-rating-'.ceil($value['reviews']).'.png';
                    $imploderequestChildAge = array();
                    foreach ($_REQUEST['Child'] as $reqCkey => $reqCvalue) {
                      for ($i=1; $i <= $reqCvalue ; $i++) { 
                        foreach ($_REQUEST['room'.($reqCkey+1).'-childAge'] as $reCAkey => $reCAvalue) {
                          $requestChildAge[$reqCkey][$reCAkey] = 'room'.($reqCkey+1).'-childAge[]='.$reCAvalue;
                        }
                        $imploderequestChildAge[$reqCkey] = implode("&", $requestChildAge[$reqCkey]);

                      }
                    }

                    $imploderequestChildAge1 = implode("&", $imploderequestChildAge);
                    if ($imploderequestChildAge1!='') {
                      $imploderequestChildAge1 = '&'.$imploderequestChildAge1;
                    } 

                    $requestAdults = "adults[]=".implode("&adults[]=", $_REQUEST['adults']);

                    $requestChild = "Child[]=".implode("&Child[]=", $_REQUEST['Child']);

                    $request = 'RequestType=Book&hotel_id='.$value['HotelCode'].'&Check_in='.$_REQUEST['Check_in'].'&Check_out='.$_REQUEST['Check_out'].'&'.$requestAdults.'&'.$requestChild.$imploderequestChildAge1.'&no_of_rooms='.count($_REQUEST['adults']).'&nationality='.$_REQUEST['nationality'].'&location='.$_REQUEST['location'];    
                    $BookBtn = '<a onclick="tokenSetfn(\''.base_url().'payment/hotelBook?'.$request.'\',\''.str_replace("'", "", $value['HotelName']).'\',\''.str_replace("'", "", $value['HotelAddress']).'\',\''.$value['HotelPicture'].'\',\''.$value['HotelCode'].'\','.$value['Rating'].')" style="background:green;border-bottom: 2px solid green;cursor:pointer" href="#" class="hotel-view-btn">Book</a>';

                    $HotelRequest = base_url().'details?search_id='.$value['HotelCode'].'&mark_up=&Check_in='.$_REQUEST['Check_in'].'&Check_out='.$_REQUEST['Check_out'].'&'.$requestAdults.'&'.$requestChild.$imploderequestChildAge1.'&no_of_rooms='.count($_REQUEST['adults']).'&nationality='.$_REQUEST['nationality'].'&providers=otelseasy'; 

                    $revenue_markup = revenue_markup($value['HotelCode'],$value['contract_id'],$this->session->userdata('agent_id'));
                    $total_markup = mark_up_get()+general_mark_up_get();
                    if ($revenue_markup!="") {
                       $total_markup = $revenue_markup+mark_up_get();
                    }  
                    if (!is_numeric($value['oldPrice'])) {
                      $value['oldPrice'] = 0;
                    }
                    $OriginalPrice = (($value['OriginalPrice']*$total_markup)/100+$value['OriginalPrice'])*count($_REQUEST['adults']);
                    $oldPrice = (($value['OriginalPrice']*$total_markup)/100+$value['OriginalPrice'])*count($_REQUEST['adults']);
                } else {
                    $RatingImg = $value['RatingImg'];
                    $ReviewImg = $value['ReviewImg'];
                    $BookBtn = $value['BookBtn'];
                    $HotelRequest = $value['HotelRequest'];
                    $OriginalPrice = $value['OriginalPrice'];
                    $oldPrice = $value['oldPrice'];
                }
                $array = array(
                        'HotelCode' =>$value['HotelCode'],
                        'HotelName' =>$value['HotelName'],
                        'HotelPicture' =>$value['HotelPicture'],
                        'HotelDescription' =>$value['HotelDescription'],
                        'Rating' =>$value['Rating'],
                        'TotalPrice' => floatval(preg_replace('/[^\d.]/', '', $value['TotalPrice'])),
                        'Currency' =>$value['Currency'],
                        'OriginalPrice' =>$OriginalPrice,
                        'oldPrice' => $oldPrice,
                        'DataType' =>$value['DataType'],
                        'RatingImg' =>$RatingImg,
                        'ReviewImg' =>$ReviewImg,
                        'reviews' =>$value['reviews'],
                        'BookBtn' =>$BookBtn,
                        'HotelRequest' =>$HotelRequest,
                        'Inclusion' => isset($value['Inclusion']) ? $value['Inclusion'] : '',
                        'agent_id' =>$this->session->userdata('agent_id'),
                        'ip_add' => $ip_add,
                        'searchDate' => date("Y-m-d"),
                        );

                $this->db->insert('ci_sessions' ,$array);
        }
    }
        
    $data['rotateHotels'] = '';
    $rotateHotels = $this->List_Model->rotateHotels($_REQUEST);

    if (count($rotateHotels)!=0) {
        $data['rotateHotels'] = '<div id="myCarousel" class="carousel slide" data-ride="carousel"><div class="carousel-inner">';
      
        foreach ($rotateHotels as $key => $value) {
          if ($key == 0) {
            $data['rotateHotels'].= '<div class="item active" style="height:50px">
              <img src="'.$value->HotelPicture.'" alt="" class="hotel-slider--img">
                <div class="hotel-slider--info">
                <h4 class="hotel-slider__name">'.$value->HotelName.'</h4>
                <p class="hotel-slider__room"><small></small></p>
                '.$value->RatingImg.'
              </div>
              <div class="hotel-slider--book">
               <p class="color-green size20">
               <small>'.$value->Currency."</small> ".$value->OriginalPrice.'</p>
                '.$value->BookBtn.'
              </div></div>';

          } else {
            $data['rotateHotels'].= '<div class="item" style="height:50px">
              <img src="'.$value->HotelPicture.'" alt="" class="hotel-slider--img">
                <div class="hotel-slider--info">
                <h4 class="hotel-slider__name">'.$value->HotelName.'</h4>
                <p class="hotel-slider__room"><small></small></p>
                '.$value->RatingImg.'
              </div>
              <div class="hotel-slider--book">
               <p class="color-green size20"><small>'.$value->Currency."</small> ".$value->OriginalPrice.'</p>
                '.$value->BookBtn.'
              </div></div>';
          }
        }
        $data['rotateHotels'].='</div><a class="left carousel-control" href="#myCarousel" data-slide="prev">
          <span class="fa fa-chevron-left"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
          <span class="fa fa-chevron-right"></span>
        </a>
        </div>';
    }    
    
    

    $config['first_link'] = 'First';
    $config['div'] = 'result_search'; //Div tag id
    $config['base_url'] = base_url() . "lists/index";
    $config['total_rows'] = $this->List_Model->SearchListDataFetchcount();

    if ($_REQUEST['view_type']=="list") {
      $config['per_page'] = 15;
    } elseif ($_REQUEST['view_type']=="grid") {
      $config['per_page'] = 24;
    } else {
      $config['per_page'] = 18;
    }
    $config['postVar'] = 'page';
    $this->ajax_pagination->initialize($config);
    if (!isset($_REQUEST['page']) || $_REQUEST['page']=="") {
      $page = 0;
    } else {
      $page = $_REQUEST['page'];
    }
    $result["links"] = $this->ajax_pagination->create_links();
    $displayOrder =$this->List_Model->getDisplayOrder();
    if(count($displayOrder)!=0 && $displayOrder[0]->directhotels=='1') {
        $HotelList = $this->List_Model->SearchListDataFetch($config['per_page'],$page,"direct");
     } else {
        $HotelList = $this->List_Model->SearchListDataFetch($config['per_page'],$page,"tbo");
     }
    // $HotelIdList = array_slice($HotelCode,$page,$config['per_page'],true);

    $checkin_date=date_create($_REQUEST['Check_in']);
    $checkout_date=date_create($_REQUEST['Check_out']);
    $no_of_days=date_diff($checkin_date,$checkout_date);
    $nights = $no_of_days->format("%a");
    $useragent=$_SERVER['HTTP_USER_AGENT'];
    if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
        $_REQUEST['view_type'] = 'mobile';

    }



    if (count($HotelList)!=0) {
      foreach ($HotelList as $key => $value) {

        if (strlen($value->HotelDescription)> 180) {
          $HotelDescription[$key] = substr($value->HotelDescription, 0, 180).'...';
        } else {
          $HotelDescription[$key] = $value->HotelDescription;
        }
        if (!isset($RoomName[$key])) {
          $RoomName[$key] = '';
        }
        if($value->DataType=='TBO') {
          $reqDetails = '#';
          $reqClass = 'hotel-details';
          $target = '';
        } else {
          $reqDetails = $value->HotelRequest;
          $reqClass = '';
          $target = '_blank';
        }

        if ($_REQUEST['view_type']=="list") {
          if($value->DataType=='TBO') {
            $moreDetails = '<a href="#" class="hotel-more-btn1"><span>More Details</span> <i class="fa fa-chevron-right"></i></a>';
          } else {
            $moreDetails = '<a class="hotel-more-btn" onclick="MoreDetailsToggle('.$value->HotelCode.',\''.$value->DataType.'\')"><span>More Details</span> <i class="fa fa-chevron-down"></i></a>';
          }

            $data['list'][] =  '<div class="offset-2">
            <div class="col-md-3 offset-0">
            <div class="listitem">
            <a href="'.$value->HotelPicture.'"  data-title="'.$value->HotelName.'" data-gallery="multiimages" data-toggle="lightbox"><img src="'.$value->HotelPicture.'"  alt=""/></a>
            <div class="liover"></div>
            <a class="fav-icon" href="#" onclick="favourite_add('.$this->session->userdata("agent_id").','.$value->HotelCode.')"></a>
            <a class="book-icon" target="'.$target.'" href="'.$reqDetails.'"></a>
            </div>
            </div>
            <div class="col-md-9 offset-0">
            <div class="itemlabel3">
            <div class="labelright">
            <div class="customer-rating">
            <span class="size11 grey">'.$value->reviews.' Reviews</span>
            <img src="'.$value->ReviewImg.'" width="80" alt=""/><br/>
            </div>
            <h5 class="room-type"><span class="text-primary text-transform bold"></span> <span class="tool-tip" title="#"></span> </h5 class="room-type">
            <p></p>

            <div class="row"><div class="col-xs-12"><p class="color-green size24">
            <b style="width:100%;display:block;"><small>'.$value->Currency."</small> ".$value->OriginalPrice.'</b></p></div></div>
            <span class="size11 grey">'.$nights.' night</span>
            '.$value->BookBtn.'
            '.$moreDetails.'
            </div>
            <div class="labelleft2">      
            <a  target="'.$target.'" class="'.$reqClass.'" href="'.$reqDetails.'"><H3>'.$value->HotelName.'</H3></a>
            '.$value->RatingImg.'
            <p class="grey">'.utf8_encode($HotelDescription[$key]).'</p><br/>
            <ul class="hotelpreferences--search">
            </ul>
            </div>
            </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-12 more-wrap">
            <div class="more-content more-content'.$value->HotelCode.'">
            <div class="spin-wrapper-sub text-center" style="display: block;">
            <img src="'.base_url().'/assets/images/ellipsis-spinner.gif" alt="" width="75px">
            </div>
            </div>
            </div>
           

            <div class="clearfix"></div>
            <div class="offset-2"><hr class="featurette-divider3"></div>';
        } elseif ($_REQUEST['view_type']=="grid") {
            $data['list'][] =  '<div class="col-md-4">
          <div class="listitem">
          <a href="'.$value->HotelPicture.'"  data-title="'.$value->HotelName.'" data-gallery="multiimages" data-toggle="lightbox"><img src="'.$value->HotelPicture.'"  alt=""/></a>
          <div class="liover"></div>
          <a class="fav-icon" href="#" onclick="favourite_add('.$this->session->userdata("agent_id").','.$value->HotelCode.')"></a>
          <a class="book-icon" target="_blank" href="'.$reqDetails.'"></a>
          </div>
          <div class="itemlabel">
          <div class="right mt1" style="top:-19px;">
          '.$value->BookBtn.'
          </div>
          <b>'.$value->HotelName.'</b><br>
          <p class="lightgrey"><span class="green size14"><b><small>'.$value->Currency."</small> ".$value->OriginalPrice.'</b> </span> / '.$nights.' night</p>
          </div>
          </div>';
        } elseif ($_REQUEST['view_type']=="mobile") {
            $data['list'][] =  '<div class="offset-2">
            <div class="col-md-3 col-xs-4 offset-0">
            <div class="listitem listitem4">
            <a href="'.$value->HotelPicture.'"  data-title="'.$value->HotelName.'" data-gallery="multiimages" data-toggle="lightbox"><img src="'.$value->HotelPicture.'"  alt=""/></a>
            <div class="liover"></div>
            <a class="fav-icon" href="#" onclick="favourite_add('.$this->session->userdata("agent_id").','.$value->HotelCode.')"></a>
            <a class="book-icon" target="'.$target.'" href="'.$reqDetails.'"></a>
            </div>
            </div>
            <div class="col-md-9 col-xs-8 offset-0">
            <div class="itemlabel4 listitem4">
            <div class="labelright">
            <div class="row"><div class="col-xs-12"><p class="color-green size14">
            <b style="width:100%;display:block;"><small>'.$value->Currency."</small> ".$value->OriginalPrice.'</b></p></div></div>
            <span class="size11 grey">'.$nights.' night</span>
            '.$value->BookBtn.'
            </div>
            <div class="labelleft2">      
            <a  target="'.$target.'" class="'.$reqClass.'" href="'.$reqDetails.'"><H3 style="font-size:11px;">'.$value->HotelName.'</H3></a>
            '.$value->RatingImg.'
            <img src="'.$value->ReviewImg.'" class="review-sm" width="70" alt=""/>
            <ul class="hotelpreferences--search">
            </ul>
            </div>
            </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-12 more-wrap">
            <div class="more-content more-content'.$value->HotelCode.'">
            <div class="spin-wrapper-sub text-center" style="display: block;">
            <img src="'.base_url().'/assets/images/ellipsis-spinner.gif" alt="" width="75px">
            </div>
            </div>
            </div>';
        } else {
            $data['list'][] = '<div class="col-md-4">
          <div class="listitem">
          <a href="'.$value->HotelPicture.'"  data-title="'.$value->HotelName.'" data-gallery="multiimages" data-toggle="lightbox"><img src="'.$value->HotelPicture.'"  alt=""/></a>
          <div class="liover"></div>
          <a class="fav-icon" href="#"></a>
          <a class="book-icon" target="_blank" href="'.$reqDetails.'"></a>
          </div>
          <div class="itemlabel2">
          <div class="labelright">
          <div class="rate-size"><small>'.$value->RatingImg.'</small></div>
          <img src="'.$value->ReviewImg.'" width="60" alt=""><br>
          <span class="size11 grey">'.$value->reviews.' Reviews</span><br><br>
          <span class="green size18"><b><small>'.$value->Currency."</small> ".$value->OriginalPrice.'</b></span><br>
          <span class="size11 grey">'.$nights.' night</span><br><br><br>
          '.$value->BookBtn.'   
          </div>
          <div class="labelleft">     
          <b>'.$value->HotelName.'</b><br><br><br>
          <p class="grey">'.utf8_encode($HotelDescription[$key]).'</p>
          </div>
          </div>
          </div>';
        }

      }
    }

    if (count($HotelList)==0) {
      $data['list'][] = '<p class="text-center no-records"><i class="fa fa-warning"></i>No Records found.</p>';
    }
    // $data['list'][] = '<div class="col-md-12 pull-right"><div class="hpadding20">
    //   <ul class="pagination right paddingbtm20">
    //   '.$result["links"].'
    //   </ul>
    //   </div></div>';
    $minAmount = $this->db->query("SELECT IF(MIN(round(TotalPrice))='',0,min(round(TotalPrice))) as MinAmount FROM ci_sessions where TotalPrice != 0 AND ip_add = '".get_client_ip()."' AND agent_id = '".$this->session->userdata('agent_id')."'")->result();

    $data['countprice'][] = $config['total_rows']==0 ? 0 : $minAmount[0]->MinAmount;
    $data['counthotel'][] = $config['total_rows'];
    echo json_encode($data);
  }
  public function search_list1() {
    $HotelSet = array();
    $tempHotels = array();
    $tempData = $this->session->tempdata('tempData');
    $tempHotels = $this->session->tempdata('tempHotels');
    $tempBoard = $this->session->tempdata('tempBoard');
    $tempcontract = $this->session->tempdata('tempcontract');

    if (isset($_REQUEST['BB']) || isset($_REQUEST['RO']) || isset($_REQUEST['HB']) || isset($_REQUEST['FB'])) {
      foreach ($tempBoard as $key => $value) {
        if (isset($_REQUEST['BB']) && $value=='BB') {
          $HotelSet[$key] =  $tempHotels[$key];
        } else if(isset($_REQUEST['RO']) && $value=='RO') {
          $HotelSet[$key] =  $tempHotels[$key];
        } else if(isset($_REQUEST['HB']) && $value=='HB') {
          $HotelSet[$key] =  $tempHotels[$key];
        } else if(isset($_REQUEST['FB']) && $value=='FB') {
          $HotelSet[$key] =  $tempHotels[$key];
        }   
      }
      $tempHotels = array_unique($HotelSet);
    } else {
      $tempHotels = $this->session->tempdata('tempHotels');
      if (count($tempHotels)!=0) {
        $tempHotels = array_unique($tempHotels);
      }
      
    }

    $minPriceArray = array();
    $agent_currency =  agent_currency();
    if ($_REQUEST['mark_up']=="") {
      $agent_markup = mark_up_get()+general_mark_up_get();
      $mark_up = ""; 
    } else {
      $mark_up = $_REQUEST['mark_up']; 
      $agent_markup = mark_up_get()+general_mark_up_get()+$_REQUEST['mark_up'];
    }
    $checkin ="";
    $checkout='';
    $adults = '';
    $child = '';

    $Room1ChildAges='';
    $Room2ChildAges='';
    $Room3ChildAges='';
    $Room4ChildAges='';
    $Room5ChildAges='';
    $Room6ChildAges='';
    $Room7ChildAges='';
    $Room8ChildAges='';
    $Room9ChildAges='';
    $Room10ChildAges='';

    if ($_REQUEST['Check_in']!='') {
      $checkin = $_REQUEST['Check_in'];
    }
    if($_REQUEST['Check_out']!='') {
      $checkout=$_REQUEST['Check_out'];
    }
    if ($_REQUEST['adults']!='') {
      $adults = implode(",", $_REQUEST['adults']) ;
    }
    if ($_REQUEST['Child']!='') {
      $child = implode(",", $_REQUEST['Child']) ;
    }
    if ($_REQUEST['Child'][0]!=0 && isset($_REQUEST['room1-childAge'])) {
      $Room1ChildAges = implode(",", $_REQUEST['room1-childAge']) ;
    }
    if (isset($_REQUEST['Child'][1]) && $_REQUEST['Child'][1]!=0) {
      $Room2ChildAges = implode(",", $_REQUEST['room2-childAge']) ;
    }
    if (isset($_REQUEST['Child'][2]) &&  $_REQUEST['Child'][2]!=0) {
      $Room3ChildAges = implode(",", $_REQUEST['room3-childAge']) ;
    }
    if (isset($_REQUEST['Child'][3]) &&  $_REQUEST['Child'][3]!=0) {
      $Room4ChildAges = implode(",", $_REQUEST['room4-childAge']) ;
    }
    if (isset($_REQUEST['Child'][4]) &&  $_REQUEST['Child'][4]!=0) {
      $Room5ChildAges = implode(",", $_REQUEST['room5-childAge']) ;
    }
    if (isset($_REQUEST['Child'][5]) &&  $_REQUEST['Child'][5]!=0) {
      $Room6ChildAges = implode(",", $_REQUEST['room6-childAge']) ;
    }
    if (isset($_REQUEST['Child'][6]) &&  $_REQUEST['Child'][6]!=0) {
      $Room7ChildAges = implode(",", $_REQUEST['room7-childAge']) ;
    }
    if (isset($_REQUEST['Child'][7]) &&  $_REQUEST['Child'][7]!=0) {
      $Room8ChildAges = implode(",", $_REQUEST['room8-childAge']) ;
    }
    if (isset($_REQUEST['Child'][8]) &&  $_REQUEST['Child'][8]!=0) {
      $Room9ChildAges = implode(",", $_REQUEST['room9-childAge']) ;
    }
    if (isset($_REQUEST['Child'][9]) &&  $_REQUEST['Child'][9]!=0) {
      $Room10ChildAges = implode(",", $_REQUEST['room10-childAge']) ;
    }

    $total_markup = $agent_markup;
    if (isset($_REQUEST['price'])) {
      $price = explode(";", $_REQUEST['price']);
      
      if (agent_currency()=="AED") {
        $start_price = $price[0] - (($price[0]*$total_markup)/100);
        $end_price = $price['1'] - (($price['1']*$total_markup)/100);
      } else {
        $start_price = ceil(currency_type_aed(agent_currency(),"AED",$price[0] - (($price[0]*$total_markup)/100)));
        $end_price = ceil(currency_type_aed(agent_currency(),"AED",$price['1'] - (($price['1']*$total_markup)/100)));
      }
      
    }
    $config['first_link'] = 'First';
    $config['div'] = 'result_search'; //Div tag id
    $config['base_url'] = base_url() . "lists/index";

    $config['total_rows'] = $this->List_Model->search_list_count($_REQUEST,$start_price,$end_price,$tempHotels);
    // $xmlHotels = $this->xmlrequest($_REQUEST);
    // $config['total_rows'] = count($xmlHotels)+$total_rows;

    if ($_REQUEST['view_type']=="list") {
      $config['per_page'] = 15;
    } elseif ($_REQUEST['view_type']=="grid") {
      $config['per_page'] = 24;
    } else {
      $config['per_page'] = 18;
    }
    $config['postVar'] = 'page';
    $this->ajax_pagination->initialize($config);
    if (!isset($_REQUEST['page'])) {
      $page = 0;
    } else {
      $page = $_REQUEST['page'];
    }

    $result['view'] = $this->List_Model->search_list($config["per_page"], $page,$_REQUEST,$start_price,$end_price,$tempHotels);
    $result["links"] = $this->ajax_pagination->create_links();
    if (count($result['view'])!=0) {
      foreach ($result['view'] as $key => $value) {
        $Adroom = array();
        $AdAmount = array();
        $AdContract = array();
        foreach ($tempData[$value->hotel_id] as $key2 => $value2) {
          foreach ($value2 as $key3 => $value3) {
            if (isset($_REQUEST['BB']) || isset($_REQUEST['RO']) || isset($_REQUEST['HB']) || isset($_REQUEST['FB'])) {
              if (isset($_REQUEST['BB']) && $key3=="BB") {
                $AdAmount[] = $value3;
                $Adroom[] = $key2;
                $AdContract[] = $tempcontract[$value->hotel_id][$key2][$key3];
              } else if(isset($_REQUEST['RO']) && $key3=="RO") {
                $AdAmount[] = $value3;
                $Adroom[] = $key2;
                $AdContract[] = $tempcontract[$value->hotel_id][$key2][$key3];
              } else if(isset($_REQUEST['HB']) && $key3=="HB") {
                $AdAmount[] = $value3;
                $Adroom[] = $key2;
                $AdContract[] = $tempcontract[$value->hotel_id][$key2][$key3];
              } else if(isset($_REQUEST['FB']) && $key3=="FB") {
                $AdAmount[] = $value3;
                $Adroom[] = $key2;
                $AdContract[] = $tempcontract[$value->hotel_id][$key2][$key3];
              }
            } else {
              $AdAmount[] = $value3;
              $Adroom[] = $key2;
              $AdContract[] = $tempcontract[$value->hotel_id][$key2][$key3];
            }
          }
        }
        
        $Ckey = array_keys($AdAmount, min($AdAmount))[0];
        $MinAmountData = $this->List_Model->MinAmountData($value->hotel_id,$Adroom[$Ckey],$AdContract[$Ckey]);
      // // $MinAmountData['contract_id'] = 'CON066';
      // // $MinAmountData['board'] = 'BB';
      // // $MinAmountData['amount'] = '100';
      // // $MinAmountData['title'] = 'Test';
      // // $MinAmountData['RoomLeft'] = '2';
      // // $MinAmountData['oldPrice'] = '';
      // // $MinAmountData['night'] = '1';
      // // $MinAmountData['request'] = 'request';
      // // $MinAmountData['RoomName'] = 'RoomName';

        if ($MinAmountData!="false") {

       if (strlen($value->hotel_description)> 180) {
          $hotel_description = substr($value->hotel_description, 0, 180).'...';
        } else {
          $hotel_description = $value->hotel_description;
        }
        $hotel_facilities=explode(",",$value->hotel_facilities);
        $diagnosa = '';
        $icon_array = array();
        if (count($hotel_facilities)!=0) {
          for ($k=0; $k <=3 ; $k++) { 
            if (isset($hotel_facilities[$k])) {
              if (hotel_facility_icon_ajax($hotel_facilities[$k])!='' && hotel_facility_icon_name_ajax($hotel_facilities[$k])!='') {
                $icon_array[$k] = '<li><img  src="'.base_url().hotel_facility_icon_ajax($hotel_facilities[$k]).'"><span class="text-muted">'.hotel_facility_icon_name_ajax($hotel_facilities[$k]).'</span></li>';
                $diagnosa = $diagnosa.$icon_array[$k];
              }
            }
          }
        }
        $dd = '';
        

        $value->contract_id = $MinAmountData['contract_id'];
        $value->board = $MinAmountData['board'];

        $minPriceArray[] =  floatval(preg_replace('/[^\d.]/', '', $MinAmountData['amount']));
           // print_r($MinAmountData);
           // echo "<br>";
        $token  = date('YmdHis');
        $promote_tag = '';
        if ($value->promoteList==3) {
          $promote_tag = '<div class="promote-tag"><span>TOP</span></div>';
        } 

        if ($_REQUEST['view_type']=="list") {
          $requestChildAge = array();
          $imploderequestChildAge = array();
          $imploderequestChildAge1 = '';
          foreach ($_REQUEST['Child'] as $reqCkey => $reqCvalue) {
            for ($i=1; $i <= $reqCvalue ; $i++) { 
              foreach ($_REQUEST['room'.($reqCkey+1).'-childAge'] as $reCAkey => $reCAvalue) {
                $requestChildAge[$reqCkey][$reCAkey] = 'room'.($reqCkey+1).'-childAge[]='.$reCAvalue;
              }
              $imploderequestChildAge[$reqCkey] = implode("&", $requestChildAge[$reqCkey]);

            }
          }

          $imploderequestChildAge1 = implode("&", $imploderequestChildAge);
          if ($imploderequestChildAge1!='') {
            $imploderequestChildAge1 = '&'.$imploderequestChildAge1;
          } 

          $requestAdults = "adults[]=".implode("&adults[]=", $_REQUEST['adults']);
          $requestChild = "Child[]=".implode("&Child[]=", $_REQUEST['Child']);
          $request = 'room_id='.$value->BookroomId.'&hotel_id='.$value->hotel_id.'&mark_up=&contract_id='.$value->contract_id.'&Check_in='.$_REQUEST['Check_in'].'&Check_out='.$_REQUEST['Check_out'].'&'.$requestAdults.'&'.$requestChild.$imploderequestChildAge1.'&no_of_rooms='.count($_REQUEST['adults']).'&max_child_age='.$this->List_Model->max_child_age_get($value->contract_id).'&nationality='.$_REQUEST['nationality'];


          if ($value->board=="RO") {
            $title = "Room Only";
          } else if ($value->board=="BB") {
            $title = "Bed and Breakfast";
          } else if ($value->board=="HB") {
            $title = "Half Board";
          } else {
            $title = "Full Board";
          }
          if ($value->rating!=10) {
            $filterRating = '<img src="'.base_url().'skin/images/filter-rating-'.ceil($value->rating).ceil($value->rating).'.png" class="hotel-rating" alt=""/>';
          } else {
            $filterRating = '<label style="width:100px;" class="hotel-rating"><i class="fa fa-building" style="color: #258732;"></i> Apartment</label>';
          }

          if ($MinAmountData['RoomLeft'] > 0) {
            $leftStyle = '<small class="color-red">'.$MinAmountData['RoomLeft'].' left!</small>';
            $style = 'style="background:green;border-bottom: 2px solid green;"';
            $btn_name = 'Book';
          } else {
            $leftStyle = '';
            $style = '';
            $btn_name = 'On Request';
          }
          $data['list'][] =  '<div class="offset-2">
          <div class="col-md-3 offset-0">
          <div class="listitem">
          '.$promote_tag.'
          <a href="'.base_url().'uploads/gallery/'.$value->hotel_id.'/'.$value->Image1.'"  data-title="'.$value->hotel_name.'" data-gallery="multiimages" data-toggle="lightbox"><img src="'.base_url().'uploads/gallery/'.$value->hotel_id.'/'.$value->Image1.'"  alt=""/></a>
          <div class="liover"></div>
          <a class="fav-icon" href="#" onclick="favourite_add('.$this->session->userdata("agent_id").','.$value->hotel_id.')"></a>
          <a class="book-icon" target="_blank" href="'.base_url().'details?search_id='.$value->hotel_id.'&&mark_up='.$mark_up.'&&Check_in='.$checkin.'&&Check_out='.$checkout.'&&adults='.$adults.'&&child='.$child.'&&Room1ChildAges='.$Room1ChildAges.'&&Room2ChildAges='.$Room2ChildAges.'&&Room3ChildAges='.$Room3ChildAges.'&&Room4ChildAges='.$Room4ChildAges.'&&Room5ChildAges='.$Room5ChildAges.'&&Room6ChildAges='.$Room6ChildAges.'&&Room7ChildAges='.$Room7ChildAges.'&&Room8ChildAges='.$Room8ChildAges.'&&Room9ChildAges='.$Room9ChildAges.'&&Room10ChildAges='.$Room10ChildAges.'&&contract_id='.$value->contract_id.'&nationality='.$_REQUEST['nationality'].'"></a>
          </div>
          </div>
          <div class="col-md-9 offset-0">
          <div class="itemlabel3">
          <div class="labelright">
          <div class="customer-rating">
          <span class="size11 grey">'.$value->reviews.' Reviews</span>
          <img src="'.base_url().'skin/images/user-rating-'.ceil($value->starsrating).'.png" width="80" alt=""/><br/>
          </div>
          <h5 class="room-type"><span class="text-primary text-transform bold">'.$MinAmountData['RoomName'].'</span> <span class="tool-tip" title="'.$MinAmountData['title'].'">'.$MinAmountData['board'].'</span> </h5 class="room-type">
          <p>'.$leftStyle.'</p>

          <div class="row"><div class="col-xs-12"><p class="color-green size24">
          '.$MinAmountData['oldPrice'].'
          <b style="width:100%;display:block;"><small>'.$agent_currency."</small> ".$MinAmountData['amount'].'</b></p></div></div>
          <span class="size11 grey">'.$MinAmountData['night'].' night</span>
          <a '.$style.' onclick="tokenSetfn(\''.base_url().'payment?'.$MinAmountData['request'].'\')" href="#" class="hotel-view-btn">'.$btn_name.'</a>
          <a class="hotel-more-btn" onclick="MoreDetailsToggle('.$value->hotel_id.')"><span>More Details</span> <i class="fa fa-chevron-down"></i></a>
          </div>
          <div class="labelleft2">      
          <a  target="_blank" href="'.base_url().'details?search_id='.$value->hotel_id.'&&mark_up='.$mark_up.'&&Check_in='.$checkin.'&&Check_out='.$checkout.'&&adults='.$adults.'&&child='.$child.'&&Room1ChildAges='.$Room1ChildAges.'&&Room2ChildAges='.$Room2ChildAges.'&&Room3ChildAges='.$Room3ChildAges.'&&Room4ChildAges='.$Room4ChildAges.'&&Room5ChildAges='.$Room5ChildAges.'&&Room6ChildAges='.$Room6ChildAges.'&&Room7ChildAges='.$Room7ChildAges.'&&Room8ChildAges='.$Room8ChildAges.'&&Room9ChildAges='.$Room9ChildAges.'&&Room10ChildAges='.$Room10ChildAges.'&&contract_id='.$value->contract_id.'&nationality='.$_REQUEST['nationality'].'"><H3>'.$value->hotel_name.'</H3></a>
          '.$filterRating.'
          <p class="grey">'.$hotel_description.'</p><br/>
          <ul class="hotelpreferences--search">
          '.$diagnosa.'
          </ul>
          </div>
          </div>
          </div>
          <div class="clearfix"></div>
          <div class="col-sm-12 more-wrap">
          <div class="more-content more-content'.$value->hotel_id.'">
          <div class="spin-wrapper-sub text-center" style="display: block;">
          <img src="'.base_url().'/assets/images/ellipsis-spinner.gif" alt="" width="75px">
          </div>
          </div>
          </div>
          </div>
          </div>

          <div class="clearfix"></div>
          <div class="offset-2"><hr class="featurette-divider3"></div>';
        } elseif ($_REQUEST['view_type']=="grid") {
          $data['list'][] =  '<div class="col-md-4">
          <div class="listitem">
          '.$promote_tag.'
          <a href="'.base_url().'uploads/gallery/'.$value->hotel_id.'/'.$value->Image1.'"  data-title="'.$value->hotel_name.'" data-gallery="multiimages" data-toggle="lightbox"><img src="'.base_url().'uploads/gallery/'.$value->hotel_id.'/'.$value->Image1.'"  alt=""/></a>
          <div class="liover"></div>
          <a class="fav-icon" href="#"></a>
          <a class="book-icon" target="_blank" href="'.base_url().'details?search_id='.$value->hotel_id.'&&mark_up='.$mark_up.'&&Check_in='.$checkin.'&&Check_out='.$checkout.'&&adults='.$adults.'&&child='.$child.'&&Room1ChildAges='.$Room1ChildAges.'&&Room2ChildAges='.$Room2ChildAges.'&&Room3ChildAges='.$Room3ChildAges.'&&Room4ChildAges='.$Room4ChildAges.'&&Room5ChildAges='.$Room5ChildAges.'&&Room6ChildAges='.$Room6ChildAges.'&&Room7ChildAges='.$Room7ChildAges.'&&Room8ChildAges='.$Room8ChildAges.'&&Room9ChildAges='.$Room9ChildAges.'&&Room10ChildAges='.$Room10ChildAges.'&&contract_id='.$value->contract_id.'"></a>
          </div>
          <div class="itemlabel">
          <a target="_blank" href="'.base_url().'details?search_id='.$value->hotel_id.'&&mark_up='.$mark_up.'&&Check_in='.$checkin.'&&Check_out='.$checkout.'&&adults='.$adults.'&&child='.$child.'&&Room1ChildAges='.$Room1ChildAges.'&&Room2ChildAges='.$Room2ChildAges.'&&Room3ChildAges='.$Room3ChildAges.'&&Room4ChildAges='.$Room4ChildAges.'&&Room5ChildAges='.$Room5ChildAges.'&&Room6ChildAges='.$Room6ChildAges.'&&Room7ChildAges='.$Room7ChildAges.'&&Room8ChildAges='.$Room8ChildAges.'&&Room9ChildAges='.$Room9ChildAges.'&&Room10ChildAges='.$Room10ChildAges.'&&contract_id='.$value->contract_id.'&nationality='.$_REQUEST['nationality'].'" class="bookbtn bk-btn-clr right mt1">view</a>         
          <b>'.$value->hotel_name.'</b><br>
          <p class="lightgrey"><span class="green size14"><b>'.$agent_currency." ".$MinAmountData['amount'].'</b></span> avg/night</p>
          </div>
          </div>';
        } else {
          $data['list'][] = '<div class="col-md-4">
          <div class="listitem">
          '.$promote_tag.'
          <a href="'.base_url().'uploads/gallery/'.$value->hotel_id.'/'.$value->Image1.'"  data-title="'.$value->hotel_name.'" data-gallery="multiimages" data-toggle="lightbox"><img src="'.base_url().'uploads/gallery/'.$value->hotel_id.'/'.$value->Image1.'"  alt=""/></a>
          <div class="liover"></div>
          <a class="fav-icon" href="#"></a>
          <a class="book-icon" target="_blank" href="'.base_url().'details?search_id='.$value->hotel_id.'&&mark_up='.$mark_up.'&&Check_in='.$checkin.'&&Check_out='.$checkout.'&&adults='.$adults.'&&child='.$child.'&&Room1ChildAges='.$Room1ChildAges.'&&Room2ChildAges='.$Room2ChildAges.'&&Room3ChildAges='.$Room3ChildAges.'&&Room4ChildAges='.$Room4ChildAges.'&&Room5ChildAges='.$Room5ChildAges.'&&Room6ChildAges='.$Room6ChildAges.'&&Room7ChildAges='.$Room7ChildAges.'&&Room8ChildAges='.$Room8ChildAges.'&&Room9ChildAges='.$Room9ChildAges.'&&Room10ChildAges='.$Room10ChildAges.'&&contract_id='.$value->contract_id.'&nationality='.$_REQUEST['nationality'].'"></a>
          </div>
          <div class="itemlabel2">
          <div class="labelright">
          <img src="'.base_url().'skin/images/filter-rating-'.ceil($value->rating).'.png" width="60" alt=""><br><br><br>
          <img src="'.base_url().'skin/images/user-rating-'.ceil($value->starsrating).'.png" width="60" alt=""><br>
          <span class="size11 grey">'.$value->reviews.' Reviews</span><br><br>
          <span class="green size18"><b>'.$agent_currency." ".$MinAmountData['amount'].'</b></span><br>
          <span class="size11 grey">avg/night</span><br><br><br>
          <a target="_blank" href="'.base_url().'details?search_id='.$value->hotel_id.'&&mark_up='.$mark_up.'&&Check_in='.$checkin.'&&Check_out='.$checkout.'&&adults='.$adults.'&&child='.$child.'&&Room1ChildAges='.$Room1ChildAges.'&&Room2ChildAges='.$Room2ChildAges.'&&Room3ChildAges='.$Room3ChildAges.'&&Room4ChildAges='.$Room4ChildAges.'&&Room5ChildAges='.$Room5ChildAges.'&&Room6ChildAges='.$Room6ChildAges.'&&Room7ChildAges='.$Room7ChildAges.'&&Room8ChildAges='.$Room8ChildAges.'&&Room9ChildAges='.$Room9ChildAges.'&&Room10ChildAges='.$Room10ChildAges.'&&contract_id='.$value->contract_id.'&nationality='.$_REQUEST['nationality'].'" class="bookbtn bk-btn-clr right mt1">view</a>   
          </div>
          <div class="labelleft">     
          <b>'.$value->hotel_name.'</b><br><br><br>
          <p class="grey">'.$hotel_description.'</p>
          </div>
          </div>
          </div>';
        }

      }
    }
    }
    if (count($result['view'])==0) {
        $data['list'][] = '<p class="text-center no-records"><i class="fa fa-warning"></i>No Records found.</p>';
    }
    // exit();
      $data['list'][] = '<div class="col-md-12 pull-right"><div class="hpadding20">
      <ul class="pagination right paddingbtm20">
      '.$result["links"].'
      </ul>
      </div></div>';
      if (!isset($_REQUEST['price'])) {
        $data['countprice'][] = "1000";
      } else {
        $last_price = explode(";", $_REQUEST['price']);
        if (agent_currency()!="AED") {
          $data['countprice'][] = count($minPriceArray)!=0 ? min($minPriceArray) : 0;
        } else {
          $data['countprice'][] =  count($minPriceArray)!=0 ? min($minPriceArray) : 0;
        }
      }
      $data['counthotel'][] = $config['total_rows'];
    // countprice
      echo json_encode($data);
      
    }
    public function MoreDetailsData() {
      if ($_REQUEST['Reqtype']=="TBO") {
        $dd = $this->List_Model->TBORoomList($_REQUEST['hotel_id']);
      } else {
        $dd = $this->List_Model->moreDetailsFetch($_REQUEST['hotel_id']);
      }
      echo json_encode($dd);
    }
    public function ShortListHotels() {
      $this->List_Model->ShortListHotels($_REQUEST);
    }
    public function dummy() {
      // $dd = $this->List_Model->CountryList();
      // print_r($dd);
      // exit();
       // $dds = 
      $inp_arr = [
              "CountryCode"=>[
                  "value"=> 'PH'
              ]
          ];
      $output = $this->List_Model->DestinationCityList($inp_arr);
      print_r($output);
      exit();
      foreach ($this->List_Model->CountryList()['CountryList']['Country'] as $key1 => $value1) {
        
        if ($key1 > -1 && $key1 < 6) {
         $CountryCode = $value1['@attributes']['CountryCode'];
          $inp_arr = [
              "CountryCode"=>[
                  "value"=> $CountryCode
              ]
          ];
          $output = $this->List_Model->DestinationCityList($inp_arr);

          foreach ($output['CityList']['City'] as $key => $value) {
            echo $key1.' '. $value1['@attributes']['CountryCode'].' '.$value['@attributes']['CityCode'].' '.$value['@attributes']['CityName'];
            echo "<br>";
            // $dd = $this->db->query('INSERT INTO xml_city_tbl (CountryCode,CityCode,CityName) VALUES ("'.$CountryCode.'","'.$value['@attributes']['CityCode'].'","'.$value['@attributes']['CityName'].'")');
          }
        }
        // echo "success";
      }
    }
    public function bookredirectdata() {
      $data = array('hotelname' => $_REQUEST['name'],
        'hoteladrs' => $_REQUEST['adrs'],
        'hotelpic' => $_REQUEST['pic'],
        'hotelrating' => $_REQUEST['rating'],
        'sessionid' => $_REQUEST['sessionid'],
        'resultindex' => isset($_REQUEST['resultindex']) ? $_REQUEST['resultindex'] : '');
        $this->session->set_userdata('hoteldata'.$_REQUEST['code'],$data);
        echo json_encode(true);
    }
}


