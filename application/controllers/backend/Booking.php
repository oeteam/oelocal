<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends MY_Controller {

	
	public function __construct() {
          parent::__construct();
          $this->load->library('email');
          $this->load->model('Booking_Model');
          $this->load->model('Hotels_Model');
          $this->load->model('Payment_Model');
          $this->load->model('OfflineModel');
          $this->load->model('Finance_Model');
          $this->load->model('List_Model');
          $this->load->helper('url');
          $this->load->helper('html');
          $this->load->helper('form');
          $this->load->helper('upload');
          $this->load->helper('common');
          $this->load->helper('manuallog');
  }
	public function index() {
      if ($this->session->userdata('name')=="") {
        redirect("../backend/");
      }
      $Booking = menuPermissionAvailability($this->session->userdata('id'),'Booking','Hotel Booking'); 
      if (count($Booking)!=0 && $Booking[0]->view==1) {
        $this->load->view('backend/booking/index');
      } else {
        redirect(base_url().'backend/dashboard');
      } 		 
	}
  public function hotel_booking_list() {
      $data = array();
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        if (isset($_REQUEST['filter'])) {
          $filter = $_REQUEST['filter'];
        } else {
          $filter = "2";
        }
        // @xmlBooking list
        // This list datas get from xml 
        // xml booking list start 
        $XMlbooking_list = $this->Booking_Model->XMlbooking_list($filter);

        foreach ($XMlbooking_list->result() as $key => $r) {
            $Booking = menuPermissionAvailability($this->session->userdata('id'),'Booking','Hotel Booking'); 
            if($Booking[0]->view!=0){
                $view = '<a title="view"  href="'.base_url().'backend/booking/xmlhotel_booking_details?id='.$r->id.'&provider='.$r->XMLProvider.'"><i class="fa fa-eye" aria-hidden="true"  style="margin-right: 5px;"></i></a>';
            }else{
                  $view="";
            }
            if($Booking[0]->edit!=0){
                  $cancel='<a title="cancel" href="#" onclick="xmlcancelPopup('.$r->id.');" data-toggle="modal" data-target="#cancelModel" class="sb2-2-1-edit delete"><i class="fa fa-times-circle  red" style="margin-right: 5px; aria-hidden="true"></i></a>';
                  $edit='<a title="accept" href="#" onclick="add_reference_entryxml_fun('.$r->id.','.$r->agent_id.','.$r->Hotel_id.','."'$r->Check_in'".');" data-toggle="modal" data-target="#reference_add_modal"><i class="fa fa-check" aria-hidden="true" style="margin-right: 5px;"></i></a>';          
            }else{
                  $edit="";
                  $cancel = "";
            }
          if ($r->bookingFlg==2) {
              $status= "<span class='text-primary'>pending</span>";
              $button = $view.$edit.$cancel;
          } elseif($r->bookingFlg==1) {
              $status= "<span class='text-success'>Accepted</span>";
              $button = $view.$cancel;
          } elseif($r->bookingFlg==3) {
              $status= "<span class='text-danger'>Cancelled</span>";
              $button = $view;
          } elseif($r->bookingFlg==5) {
              $status= "<span class='text-danger'>Cancellation pending</span>";
              $button = $view;
          } elseif($r->bookingFlg==9) {
              $status= "<span class='text-danger'>Amendment Request Send</span>";
              $button = $view;
          }
            $data[] = array(
              '',
              $r->BookingId,
              "<span class='hide'>".strtotime($r->Bookingdate)."</span>".date('d/m/Y',strtotime($r->Bookingdate)),
              $r->hotel_name,
              $r->RoomTypeName,
              date('d/m/Y',strtotime($r->Check_in)),
              date('d/m/Y',strtotime($r->Check_out)),
              $r->no_of_days,
              $r->no_of_rooms,
              admin_currency().' '.ceil(backend_currency_type($r->total_amount)),
              $status,
              $r->ConfirmationNo,
              $button,
              );

          }

        // xml booking list end
        $booking_list = $this->Booking_Model->hotel_booking_list($filter);
          foreach($booking_list->result() as $key => $r) {
            $Booking = menuPermissionAvailability($this->session->userdata('id'),'Booking','Hotel Booking'); 
            if($Booking[0]->view!=0){
                  $view='<a title="view"  href="'.base_url().'backend/booking/hotel_booking_details?id='.$r->id.'"><i class="fa fa-eye" aria-hidden="true"  style="margin-right: 5px;"></i></a>';
            }else{
                  $view="";
            }
            if($Booking[0]->edit!=0){
                  $edit='<a title="accept" href="#" onclick="add_reference_entry_fun('.$r->book_id.','.$r->agent.','.$r->hotel_id.','."'$r->check_in'".');" data-toggle="modal" data-target="#reference_add_modal"><i class="fa fa-check" aria-hidden="true" style="margin-right: 5px;"></i></a>';
                   $cancel='<a title="cancel" href="#" onclick="cancelPopup('.$r->book_id.','.$r->hotel_id.');" data-toggle="modal" data-target="#cancelModel" class="sb2-2-1-edit delete"><i class="fa fa-times-circle  red" style="margin-right: 5px; aria-hidden="true"></i></a>';
                  $editOk='<a title="cancel" href="#" onclick="cancelPopup('.$r->book_id.','.$r->hotel_id.');" data-toggle="modal" data-target="#cancelModel" class="sb2-2-1-edit delete"><i class="fa fa-thumbs-o-up" style="margin-right: 5px; aria-hidden="true"></i></a>';                   
            }else{
                  $edit="";
                  $cancel = "";
                  $editOk = "";
            } 

           
            // $reject='<a title="reject" href="#" onclick="rejectPopup('.$r->book_id.','.$r->hotel_id.');" data-toggle="modal" data-target="#rejectModel" class="sb2-2-1-edit delete"><i class="  fa fa-ban red" style="margin-right: 5px; aria-hidden="true"></i></a>';

            $reject='';
            $total = $this->Payment_Model->TotalBookingAmountDetailsGet($r->id);
            $Totselling = $total['Selling'];

            if ($r->booking_flag==2) {
              $status= "<span class='text-primary'>pending</span>";
              $button = $view.$edit.$cancel.$reject;
            } else if ($r->booking_flag==1) {
              $status= "<span class='text-success'>Accepted</span>";
              $button = $view.$cancel.$reject;
            } else if ($r->booking_flag==0) {
              $status= "<span class='text-danger'>Rejected</span>";
              $button = $view;
            } else if ($r->booking_flag==3) {
              $status= "<span class='text-danger'>Cancelled</span>";
              $button = $view;
            } else if ($r->booking_flag==4) {
              $status= "<span class='text-warning'>Hotel Approved</span>";
              $button = $view.$edit.$cancel.$reject;
            } else if ($r->booking_flag==5) {
              $status= "<span class='text-danger'>Cancellation Pending</span>";
              $button = $view.$editOk;
            } else if($r->booking_flag==8) {
              $status= "<span class='text-danger'>On Request</span>";
              $button =   $view.$edit.$cancel.$reject;
            }


              $data[] = array(
                '',
                $r->booking_id,
                "<span class='hide'>".strtotime($r->Created_Date)."</span>".date('d/m/Y',strtotime($r->Created_Date)),
                $r->hotel_name,
                $r->room_name." ".$r->Room_Type,
                date('d/m/Y',strtotime($r->check_in)),
                date('d/m/Y',strtotime($r->check_out)),
                $r->no_of_days,
                $r->book_room_count,
                admin_currency().' '.ceil(backend_currency_type($Totselling)),
                $status,
                $r->confirmationNumber,
                $button,
              );
          }
          $output = array(
           "draw" => $draw,
           "recordsTotal" => $booking_list->num_rows()+$XMlbooking_list->num_rows(),
           "recordsFiltered" => $booking_list->num_rows()+$XMlbooking_list->num_rows(),
           "data" => $data
          );
          echo json_encode($output);
          exit();
  }
  public function hotel_booking_details() {
      $data['view'] = $this->Booking_Model->hotel_booking_detail($_REQUEST['id']);
      $data['board'] = $this->Hotels_Model->board_booking_detail($_REQUEST['id']);
      $data['general'] = $this->Hotels_Model->general_booking_detail($_REQUEST['id']);
      $data['ExBed']  =  $this->Hotels_Model->getExtrabedDetails($_REQUEST['id']);
      $data['cancelation'] =  $this->Payment_Model->get_cancellation_terms($_REQUEST['id']);
      $data['remarks'] =  $this->Booking_Model->get_booking_remarks($_REQUEST['id']);
      $data['payment'] =  $this->Booking_Model->PamentDetailsForBooking($_REQUEST['id']);
      $data['logs'] = $this->Booking_Model->getBookingLogs($_REQUEST['id']);
      $this->load->view('backend/booking/hotel_booking_view',$data);
  }
  public function hotel_portel_admin_permission() {

      $result = $this->Booking_Model->hotel_booking_admin_approved($_REQUEST);
      // $result0= $this->Booking_Model->booking_approvel_notification($_REQUEST);
      // $result1= $this->Booking_Model->hotel_booking_approved_invoice($_REQUEST['id'],$_REQUEST);
      // print_r($result1);
      // exit();
      $description = 'Hotel booking accepted [ID: HAB0'.$_REQUEST['id'].', Provider: Otelseasy]';
      AdminlogActivity($description);
      echo json_encode(true);
      // redirect("../backend/booking/");
  }
  public function hotel_booking_admin_list() {
      $data = array();
      // Datatables Variables
      $draw = intval($this->input->get("draw"));
      $start = intval($this->input->get("start"));
      $length = intval($this->input->get("length"));
      $booking_list = $this->Hotels_Model->hotel_room_booking_list();
        foreach($booking_list->result() as $key => $r) {
          if ($r->booking_flag==2) {
            $status= "<span class='text-primary'>pending</span>";
            $booking_success = '<a href="#" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#booking_modal" onclick="hotelactionfun('.$r->id.',1);" class="sb2-2-1-edit delete"><i class="fa fa-check" aria-hidden="true"></i></a> ';
            $permission = ' <a title="Reject" href="#" class="btn btn-sm btn-danger" onclick="deletefun('.$r->bk_id.');" data-toggle="modal" data-target="#myModal" class="sb2-2-1-edit delete"><i class="fa fa-remove" aria-hidden="true"></i></a>';
          } else if ($r->booking_flag==4) {
            $status= "<span class='text-success'>Accepted</span>";
            $booking_success = '<a href="#" data-toggle="modal" data-target="#booking_success_modal" onclick="hotel_invoice('.$r->id.',1);"  class="btn btn-sm btn-success" class="sb2-2-1-edit delete"><i class="fa fa-check" aria-hidden="true"></i></a> ';
            $permission = '';
          } else if ($r->booking_flag==0) {
            $status= "<span class='text-danger'>Rejected</span>";
            $booking_success = '';
            $permission = ' <a title="Already Rejected" href="#" class="btn btn-sm btn-danger"  class="sb2-2-1-edit delete"><i class="fa fa-ban" aria-hidden="true"></i></a>';
          } else if ($r->booking_flag==3) {
            $status= "<span class='text-danger'>Cancelled</span>";
            $booking_success = '';
            $permission = ' <a title="Already Rejected" href="#" class="btn btn-sm btn-danger"  class="sb2-2-1-edit delete"><i class="fa fa-ban" aria-hidden="true"></i></a>';
          }
            $data[] = array(
            $key+1,
            $r->booking_id,
            strlen($r->Room_Type)> 15 ? substr($r->Room_Type,0,15)."..." : $r->Room_Type,
            $r->check_in,
            $r->check_out,
            $r->no_of_days,
            $r->book_room_count,
            $r->sell_currency." ".(($r->normal_price*$r->no_of_days)*$r->no_of_days),
            $status,
            $booking_success . '<a title="view" class="btn btn-sm  btn-primary"  href="'.base_url().'Dashboard/hotel_booking_view?id='.$r->bk_id.'"><i class="fa fa-eye" aria-hidden="true"></i></a>'.$permission,
          );
        }
        $output = array(
          "draw" => $draw,
         "recordsTotal"    => $booking_list->num_rows(),
         "recordsFiltered" => $booking_list->num_rows(),
         "data" => $data
        );
        echo json_encode($output);
        exit();
  }
  public function reference_id_checking() {
        $check_reference= $this->Booking_Model->check_reference($_REQUEST);
        echo json_encode($check_reference);
        exit();
  }
  public function booking_reference_id_popup() {
        $data['view'] = $this->Booking_Model->BookingDetailGet($_REQUEST);
        $this->load->view('backend/booking/booking_reference_id_popup',$data);
  }
  public function addreference_id() {
        $add_reference= $this->Booking_Model->add_reference($_REQUEST);
        redirect('../backend/booking/hotel_portel_admin_permission?id='.$_REQUEST['book_id'].'&&agent_id='.$_REQUEST['agent_id'].'&&hotel_id='.$_REQUEST['hotel_id'].'');
        
  }
  public function BookingCancel() {
        //$data['view'] = $this->Booking_Model->BookingDetailGet($_REQUEST);
        $this->load->view('backend/booking/cancelPop');
  }
  public function BookingReject() {
        //$data['view'] = $this->Booking_Model->BookingDetailGet($_REQUEST);
        $this->load->view('backend/booking/rejectPop');
  }
  public function cancellationUpdate() {
      $id     =$_REQUEST['book_id'];
      $hotelId= $_REQUEST['hotel_id'];
      $hotelId= $_REQUEST['hotel_id'];
      $BkId=$_REQUEST['id'];
      $agent=$_REQUEST['agent_id'];
      $agent_details = $this->Hotels_Model->agent_details_from_booking($id);
      $CancellationRefund = $this->Booking_Model->CancellationRefundProcess($id,$agent_details[0]->check_in,$this->session->userdata('name'));
      $mail_settings = mail_details();
      $hotel         = $this->Hotels_Model->GetTitle();
      $sent_mail     = $this->Booking_Model->mail_details_from_booking($id);
      $update        = $this->Booking_Model->cancellationUpdate($id);
      $hotel_mail_details = $this->Hotels_Model->hotel_mail_details($hotelId);
      $result = $this->Hotels_Model->booking_rejected_notification($BkId,$hotelId,$agent);
      $reject = $this->Hotels_Model->booking_reject($_REQUEST['id']);
      // $subject       = 'Booking has been Canceled';
      // $message       = '<div class="wrapper" style="max-width: 400px;
      //                   width: 100%;
      //                   margin: 5% auto;
      //                   border-radius: 3px;
      //                    box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);">
      //                 <header style="padding: 10px 10%;
      //                   text-align: center;">
      //                   <img src="'.base_url().'skin/images/logo.png" alt="" style="width: 200px;">
      //                 </header>
      //                 <section style="padding: 10px 10%;text-align: center;">
      //                   <h2 style="text-align: center;">  This booking has been Canceled</h2>
      //                   <div style="margin-top: 25px;
      //                   margin-bottom: 10px;
      //                   display: inline-block;"><a style="background-color: #0074b9;
      //                       color: #fff;
      //                       text-decoration: none;
      //                       padding: 6px 12px;
      //                       border-radius: 3px;
      //                       box-shadow: 0 1px 2px 0 rgba(0,0,0,0.3);
      //                       letter-spacing: .5px;
      //                       text-transform: uppercase;" href="javascript:void()">Booked Id : '.$agent_details[0]->booking_id.'</a></div>
      //                   <p style="color: cornsilk;
      //                   text-align: center;
      //                   color: #90A4AE;">'.$agent_details[0]->hotel_name.' - '.$agent_details[0]->room_name.'</p>
      //                 </section>
      //                 <footer style="text-align: center;
      //                   padding: 1px;
      //                   background-color: #37474F;
      //                   color: #fff;
      //                   border-radius: 0 0 3px 3px;">
      //                   <p>'.$hotel[0]->Title.' | 2017</p>
      //                 </footer>
      //               </div>';
      // $this->email->from($mail_settings[0]->smtp_user,$mail_settings[0]->company_name);
      // $this->email->to($agent_details[0]->Email);
      // $this->email->Bcc($hotel_mail_details[0]->revenu_mail);
      // $this->email->Bcc($hotel_mail_details[0]->sale_mail);
      // $this->email->Bcc($hotel_mail_details[0]->finance_mail);
      // $this->email->subject($subject);
      // $this->email->message($message);
      // $this->email->send();
      // print_r($hotel_mail_details);
      // exit();
      $description = 'Hotel booking cancelled [ID: '.$_REQUEST['hotel_id'].', Provider: Otelseasy]';
      AdminlogActivity($description); 
      redirect("../backend/booking/");
  }
  public function rejectionUpdate() {
    
      $id=$_REQUEST['id'];
      
      $agent_details = $this->Hotels_Model->agent_details_from_booking($id);
      $mail_settings = mail_details();
      $hotel         = $this->Hotels_Model->GetTitle();
      $sent_mail     = $this->Booking_Model->mail_details_from_booking($id);
      $update        = $this->Booking_Model->rejectionUpdate($id);
      $hotel_mail_details = $this->Hotels_Model->hotel_mail_details($hotelId);
      
      // $subject       = ' Booking has been Rejected';
      // $message       = '<div class="wrapper" style="max-width: 400px;
      //                   width: 100%;
      //                   margin: 5% auto;
      //                   border-radius: 3px;
      //                    box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);">
      //                 <header style="padding: 10px 10%;
      //                   text-align: center;">
      //                   <img src="'.base_url().'skin/images/logo.png" alt="" style="width: 200px;">
      //                 </header>
      //                 <section style="padding: 10px 10%;text-align: center;">
      //                   <h2 style="text-align: center;"> This booking has been Rejected</h2>
      //                   <div style="margin-top: 25px;
      //                   margin-bottom: 10px;
      //                   display: inline-block;"><a style="background-color: #0074b9;
      //                       color: #fff;
      //                       text-decoration: none;
      //                       padding: 6px 12px;
      //                       border-radius: 3px;
      //                       box-shadow: 0 1px 2px 0 rgba(0,0,0,0.3);
      //                       letter-spacing: .5px;
      //                       text-transform: uppercase;" href="javascript:void()">Booked Id : '.$agent_details[0]->booking_id.'</a></div>
      //                   <p style="color: cornsilk;
      //                   text-align: center;
      //                   color: #90A4AE;">'.$agent_details[0]->hotel_name.' - '.$agent_details[0]->room_name.'</p>
      //                 </section>
      //                 <footer style="text-align: center;
      //                   padding: 1px;
      //                   background-color: #37474F;
      //                   color: #fff;
      //                   border-radius: 0 0 3px 3px;">
      //                   <p>'.$hotel[0]->Title.' | 2017</p>
      //                 </footer>
      //               </div>';
      // $this->email->from($mail_settings[0]->smtp_user,$mail_settings[0]->company_name);
      // $this->email->to($agent_details[0]->Email);
      // $this->email->Bcc($hotel_mail_details[0]->revenu_mail);
      // $this->email->Bcc($hotel_mail_details[0]->sale_mail);
      // $this->email->Bcc($hotel_mail_details[0]->finance_mail);
      // $this->email->subject($subject);
      // $this->email->message($message);
      // $this->email->send();
      // print_r($hotel_mail_details[0]->revenu_mail);
      //  exit();
      echo  json_encode(true);
      
  }
  public function rejectionno() {
    redirect('../backend/booking/');
  }
  public function cancellationno() {
    redirect('../backend/booking/');
  }
  public function CancelInView(){
    $hotelId= $_REQUEST['hotel_id'];
    $BkId=$_REQUEST['id'];
    $agent=$_REQUEST['agent_id'];
    $result = $this->Hotels_Model->booking_rejected_notification($BkId,$hotelId,$agent);
    $reject = $this->Hotels_Model->booking_reject($_REQUEST['id']);
    echo  json_encode(true);
  }
  public function Offlinebooking() {
    if ($this->session->userdata('name')=="") {
        redirect("../backend/");
    }
    $hotelMenu = menuPermissionAvailability($this->session->userdata('id'),'Offline Requests','Hotels'); 
    if (count($hotelMenu)!=0 && $hotelMenu[0]->view==1) {
      $this->load->view('backend/booking/Offlinebooking'); 
    } else {
      redirect(base_url().'backend/dashboard');
    }        
  }
  public function offline_booking_list() {
      $data = array();
      // Datatables Variables
      $draw = intval($this->input->get("draw"));
      $start = intval($this->input->get("start"));
      $length = intval($this->input->get("length"));
      if (!isset($_REQUEST['filter'])) {
        $_REQUEST['filter'] = 2;
      }
      $booking_list = $this->Hotels_Model->hotel_offline_booking_list($_REQUEST['filter']);
        foreach($booking_list->result() as $key => $r) {
          $hotelMenu = menuPermissionAvailability($this->session->userdata('id'),'Offline Requests','Hotels'); 
          if($hotelMenu[0]->edit!=0) {
            $reject = '<a title="Reject" href="#" class="btn-sm" onclick="OffllineBookingactionfun('.$r->id.',0);" data-toggle="modal" data-target="#booking_modal" class="sb2-2-1-edit delete"><i class="fa fa-remove" aria-hidden="true"></i></a>';
            $accept = '<a href="#" class="btn-sm" data-toggle="modal" data-target="#booking_modal" onclick="OffllineBookingactionfun('.$r->id.',1);" class="sb2-2-1-edit delete"><i class="fa fa-check" aria-hidden="true"></i></a>';
          } else {
            $reject = '';
            $accept = '';
          }
          if($hotelMenu[0]->view!=0){
            $view='<a title="view" class="btn-sm"  href="'.base_url().'backend/booking/hotel_offlinebooking_view?id='.$r->id.'"><i class="fa fa-eye" aria-hidden="true"></i></a>';
          } else {
            $view="";
          }
          if ($r->bookingFlg==2) {
            $status= "<span class='text-primary'>pending</span>";
            $booking_success = $accept;
            $permission = $reject;
          } else if ($r->bookingFlg==1) {
            $status= "<span class='text-success'>Accepted</span>";
            $booking_success = '';
            $permission = $reject;
          } else  {
            $status= "<span class='text-danger'>Cancelled</span>";
            $booking_success = '';
            $permission = '';
          }    
            $checkin_date=date_create($r->check_in);
            $checkout_date=date_create($r->check_out);
            $no_of_days=date_diff($checkin_date,$checkout_date);
            $tot_days = $no_of_days->format("%a");
            $SellingPricear = array();
            for ($i=1; $i <= $r->no_of_rooms; $i++) { 
              $roomSelling = 'room'.$i.'Selling';
              $SellingPrice = explode(",", $r->$roomSelling);
              $SellingPricear[$i] = array_sum($SellingPrice);
            }
            $SellingPriceArr = array_sum($SellingPricear);

            $data[] = array(
              $key+1,
              'HOB'.$r->id,
              date('d/m/Y' ,strtotime($r->createdDate)),
              $r->hotel_name,
              $r->room_name,
              $r->Destination,
              $r->SupplierName,
              date('d/m/Y' ,strtotime($r->check_in)),
              date('d/m/Y' ,strtotime($r->check_out)),
              $tot_days,
              $r->no_of_rooms,
              $SellingPriceArr,
              $status,
              $booking_success .$view.$permission,
          );
        }
        $output = array(
          "draw" => $draw,
         "recordsTotal"    => $booking_list->num_rows(),
         "recordsFiltered" => $booking_list->num_rows(),
         "data" => $data
        );
        echo json_encode($output);
        exit();
  }
  public function hotel_offlinebooking_view() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $data['view'] = $this->Hotels_Model->Offlinebooking_details($_REQUEST['id']);
    $data['remarks'] =  $this->Booking_Model->get_offlinebooking_remarks($_REQUEST['id'],'hotel');
    $this->load->view('backend/booking/hotel_offlinebooking_view',$data);
  }
  public function OfflineEditModal() {
    if ($this->session->userdata('name')=="") {
        redirect("../backend/");
      }
    $data['view'] = $this->Hotels_Model->Offlinebooking_details($_REQUEST['id']);
    $this->load->view('backend/booking/OfflineEditModal',$data);
  }
  public function OfflineRequestupdate() {
    $this->Hotels_Model->OfflineRequestupdate($_REQUEST);
    $description = 'Hotel offline request edited [ID: '.$_REQUEST['id'].']';
    AdminlogActivity($description);
    redirect("../backend/booking/hotel_offlinebooking_view?id=".$_REQUEST['id']);
  }
  public function OfflineActionModal() {
    $data['view'] = $this->Hotels_Model->Offlinebooking_details($_REQUEST['id']);
    $this->load->view('backend/booking/OfflineActionModal',$data);
  }
  public function OfflineActionSubmit() {
    $this->Hotels_Model->OfflineActionupdate($_REQUEST);
    $data = $this->Hotels_Model->Offlinebooking_details($_REQUEST['id']);
     if ($_REQUEST['val']==1) {
      $this->load->library('email');
      $this->hotelrequest_accepted_mailinvoice_attach($_REQUEST['id']);
      $mail_settings = mail_details();
      $subject = 'YOUR BOOKING IS CONFIRMED (BOOKING ID : HOB'.$data[0]->requestid.')';
      $message = 'Dear '.$data[0]->ContactName.',<br><br>
            Thank you for booking with Otelseasy.com<br><br>
            Your booking is confirmed.<br><br>
            
            -------------------------------------------------------------
            <br><br>

            Once again thank you for booking with Otelseasy.com <br><br>

            Thank you<br><br>
            Best Regards,<br>
            OTELSEASY.COM<br>
            '.$mail_settings[0]->smtp_user.'<br>
            971 54 441 2554<br>
            <strong><a style="color:blue;" href="'.base_url().'">www.otelseasy.com</a></strong><br>.';  
      $this->email->from($mail_settings[0]->smtp_user, $mail_settings[0]->company_name);
      $this->email->to($data[0]->ContactEmail);
      $this->email->Bcc($mail_settings[0]->smtp_user); 
      $this->email->subject($subject);
      $this->email->message($message);  
     $path = get_upload_path_by_type('offline_requests_invoice_pdf').$this->session->userdata('id').'/'.'Invoice00'.$data[0]->requestid.'.pdf'; 
      $this->email->attach($path,'');      
      $this->email->send();
      $description = 'Hotel offline request accepted [ID: '.$_REQUEST['id'].']';
      AdminlogActivity($description);
    }else {
      $description = 'Hotel offline request cancelled [ID: '.$_REQUEST['id'].']';
      AdminlogActivity($description);
    }
    echo json_encode(true);
  }
  // @xml Booking details
  // This detail datas get from our db and db data's use to fetch data from xml
  public function xmlhotel_booking_details() {
    $output = $this->Booking_Model->xmlhotel_booking_details($_REQUEST['id']);
    $inp_arr =[
          "ConfirmationNo"=>[
            "value" => $output[0]->ConfirmationNo
          ]
      ];
      
    $xmlData =  $this->List_Model->HotelBookingDetail($inp_arr);
    $data['view'] = array();
    $data['view1'] = $output;
    if ($xmlData['Status']['StatusCode']==01) {
      if ($output[0]->BookingId=="" || $output[0]->InvoiceNumber=="") {
        $insertXMlBookingId = $this->Booking_Model->updateXMlBookingId($_REQUEST['id'],$xmlData['BookingDetail']['@attributes']['BookingId'],$xmlData['BookingDetail']['@attributes']['InvoiceNumber'],$xmlData['BookingDetail']['@attributes']['BookingStatus']);
      }
      $data['view'] = $xmlData['BookingDetail'];
    }
    $data['amendment'] = $this->Booking_Model->amendmentdetails($_REQUEST['id']);
    $this->load->view('backend/booking/xmlhotel_booking_view',$data);
  }
  // @xml booking reference modal
  // This modal used for Accept the xml booking in backend
  public function xmlbooking_reference_id_popup() {
    $data['view'] = $this->Booking_Model->xmlhotel_booking_details($_REQUEST['book_id']);
    $this->load->view('backend/booking/xmlbooking_reference_id_popup',$data);
  }
  // @xml booking reference function
  // This function used for Accept the xml booking in backend
  public function hotel_portel_xmlaccept() {
    $this->Booking_Model->hotel_portel_xmlaccept($_REQUEST);
    $description = 'Hotel booking has been accepted [ID: '.$_REQUEST['id'].', Provider: TBO]';
    AdminlogActivity($description);
    echo json_encode(true);
  }
  public function xmlBookingCancelModal() {
    $this->load->view('backend/booking/xmlBookingCancelModal');
  }
  public function xmlcancellationUpdate() {
    $output = $this->Booking_Model->xmlhotel_booking_details($_REQUEST['id']);
    $inp_arr =[
          "ConfirmationNo"=>[
            "value" => $output[0]->ConfirmationNo
          ],
          "RequestType"=>[
            "value" => $_REQUEST['RequestType']
          ],
          "Remarks"=>[
            "value" => $_REQUEST['narration']
          ]
      ];
      
    $xmlData =  $this->List_Model->HotelCancel($inp_arr);

    if ($xmlData["Status"]['StatusCode']=="05") {
      $CancellationCharge = is_array($xmlData['CancellationCharge']) ? 0 : $xmlData['CancellationCharge'];
      $RefundAmount = is_array($xmlData['RefundAmount']) ? 0 : $xmlData['RefundAmount'];
      $ProviderStatus = $xmlData['RequestStatus'];
      $booking_flag = 5;
      $this->Booking_Model->xmlCancelUpdate($_REQUEST['id'],$CancellationCharge,$RefundAmount,$ProviderStatus,$booking_flag);
      $this->session->set_flashdata("msg","This booking will be automatically cancelled in 24 hours. If not, please contact our Operations Team at ops@tboholidays.com");
    } else if ($xmlData["Status"]['StatusCode']=="01") {
      $CancellationCharge = is_array($xmlData['CancellationCharge']) ? 0 : $xmlData['CancellationCharge'];
      $booking_flag = 3;
      $RefundAmount = is_array($xmlData['RefundAmount']) ? 0 : $xmlData['RefundAmount'];
      $ProviderStatus = $xmlData['RequestStatus'];
      $this->Booking_Model->xmlCancelUpdate($_REQUEST['id'],$CancellationCharge,$RefundAmount,$ProviderStatus,$booking_flag);
      $this->session->set_flashdata("msg","Booking Cancelled Successfully");
    } else {
      $this->session->set_flashdata("msg","Booking Cancelled failed. please contact our Operations Team at ops@tboholidays.com");
    }
    $description = 'Hotel booking cancel request sent [ID: '.$_REQUEST['id'].', Provider: TBO]';
    AdminlogActivity($description);
    redirect($_SERVER['HTTP_REFERER']);
  }
  public function TourBooking() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $tourMenu = menuPermissionAvailability($this->session->userdata('id'),'Booking','Tour Booking'); 
    if (count($tourMenu)!=0 && $tourMenu[0]->view==1) {
      $this->load->view('backend/booking/tourbooking');      
    } else {
      redirect(base_url().'backend/dashboard');
    }          
  }
  public function tour_booking_list() {
    $data = array();
    // Datatables Variables
    $draw = intval($this->input->get("draw"));
    $start = intval($this->input->get("start"));
    $length = intval($this->input->get("length"));
    if (isset($_REQUEST['filter'])) {
      $filter = $_REQUEST['filter'];
    } else {
      $filter = "2";
    }
    $booking_list = $this->Booking_Model->tour_booking_list($filter);
    foreach($booking_list->result() as $key => $r) {
        $tourMenu = menuPermissionAvailability($this->session->userdata('id'),'Booking','Tour Booking');
        if($tourMenu[0]->view!=0){
            $view='<a title="view"  href="'.base_url().'backend/booking/tour_booking_details?id='.$r->id.'"><i class="fa fa-eye" aria-hidden="true"  style="margin-right: 5px;"></i></a>';
        } else {
            $view="";
        }
        if($tourMenu[0]->edit!=0){
            $edit='<a title="accept" href="#" onclick="tour_add_reference_entry_fun('.$r->bookid.','.$r->agent_id.','.$r->tour_id.','."'$r->arrivaldate'".');" data-toggle="modal" data-target="#reference_add_modal"><i class="fa fa-check" aria-hidden="true" style="margin-right: 5px;"></i></a>';
            $cancel='<a title="cancel" href="#" onclick="tourcancelPopup('.$r->bookid.','.$r->tour_id.');" data-toggle="modal" data-target="#cancelModel" class="sb2-2-1-edit delete"><i class="fa fa-times-circle  red" style="margin-right: 5px; aria-hidden="true"></i></a>';
            $editOk='<a title="cancel" href="#" onclick="tourcancelPopup('.$r->bookid.','.$r->tour_id.');" data-toggle="modal" data-target="#cancelModel" class="sb2-2-1-edit delete"><i class="fa fa-thumbs-o-up" style="margin-right: 5px; aria-hidden="true"></i></a>';
               
        } else {
            $edit = "";
            $cancel = "";
            $editOk = "";
        } 
        $reject='';
        if ($r->booking_flag==2) {
          $status= "<span class='text-primary'>pending</span>";
          $button = $view.$edit.$cancel.$reject;
        } else if ($r->booking_flag==1) {
          $status= "<span class='text-success'>Accepted</span>";
          $button = $view.$cancel.$reject;
        } else if ($r->booking_flag==0) {
          $status= "<span class='text-danger'>Rejected</span>";
          $button = $view;
        } else if ($r->booking_flag==3) {
          $status= "<span class='text-danger'>Cancelled</span>";
          $button = $view;
        } else if ($r->booking_flag==4) {
          $status= "<span class='text-warning'>Hotel Approved</span>";
          $button = $view.$edit.$cancel.$reject;
        } else if ($r->booking_flag==5) {
          $status= "<span class='text-danger'>Cancellation Pending</span>";
          $button = $view.$editOk;
        } else if($r->booking_flag==8) {
          $status= "<span class='text-danger'>On Request</span>";
          $button =   $view.$edit.$cancel.$reject;
        }
        $total_markup = $r->agent_markup+$r->admin_markup; 
        $total_amount = ($r->total_amount*$total_markup)/100+$r->total_amount;
          $data[] = array(
            $key+1,
            $r->booking_id,
            date('d/m/Y',strtotime($r->Created_Date)),
            $r->type,
            date('d/m/Y',strtotime($r->arrivaldate)),
            $r->duration.' '.$r->durationType,
            admin_currency()." ".currency_type(admin_currency(),$total_amount),
            $status,
            $button,
          );
    }
    $output = array(
     "draw" => $draw,
     "recordsTotal" => $booking_list->num_rows(),
     "recordsFiltered" => $booking_list->num_rows(),
     "data" => $data
    );
    echo json_encode($output);
    exit();
  }
  public function tour_booking_details() {
    $data['view'] = $this->Booking_Model->tour_booking_detail($_REQUEST['id']);
    $data['cancelation'] =  $this->Booking_Model->gettourbookpolicy($_REQUEST['id']);
    $data['multiservice'] =  $this->Booking_Model->gettourbookmultiservice($_REQUEST['id']);
    $this->load->view('backend/booking/tour_booking_view',$data);
  }
  public function TransferBooking() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $transferMenu = menuPermissionAvailability($this->session->userdata('id'),'Booking','Transfer Booking');
    if (count($transferMenu)!=0 && $transferMenu[0]->view==1) {
      $this->load->view('backend/booking/transferbooking');      
    } else {
      redirect(base_url().'backend/dashboard');
    }          
  }
  public function transfer_booking_list() {
    $data = array();
    // Datatables Variables
    $draw = intval($this->input->get("draw"));
    $start = intval($this->input->get("start"));
    $length = intval($this->input->get("length"));
    if (isset($_REQUEST['filter'])) {
      $filter = $_REQUEST['filter'];
    } else {
      $filter = "2";
    }
    $booking_list = $this->Booking_Model->transfer_booking_list($filter);
    foreach($booking_list->result() as $key => $r) {
        $transferMenu = menuPermissionAvailability($this->session->userdata('id'),'Booking','Transfer Booking');
        if($transferMenu[0]->view!=0){
            $view='<a title="view"  href="'.base_url().'backend/booking/transfer_booking_details?id='.$r->bookid.'"><i class="fa fa-eye" aria-hidden="true"  style="margin-right: 5px;"></i></a>';
        } else {
            $view="";
        }
        if($transferMenu[0]->edit!=0){
            $edit='<a title="accept" href="#" onclick="transfer_add_reference_entry_fun('.$r->bookid.','.$r->agent_id.','.$r->vehicleid.');" data-toggle="modal" data-target="#reference_add_modal"><i class="fa fa-check" aria-hidden="true" style="margin-right: 5px;"></i></a>';  
            $cancel='<a title="cancel" href="#" onclick="transfercancelPopup('.$r->bookid.');" data-toggle="modal" data-target="#cancelModel" class="sb2-2-1-edit delete"><i class="fa fa-times-circle  red" style="margin-right: 5px; aria-hidden="true"></i></a>';
            $editOk='<a title="cancel" href="#" onclick="transfercancelPopup('.$r->bookid.');" data-toggle="modal" data-target="#cancelModel" class="sb2-2-1-edit delete"><i class="fa fa-thumbs-o-up" style="margin-right: 5px; aria-hidden="true"></i></a>';
        } else {
            $edit="";
            $cancel="";
            $editOk="";
        } 
        $reject='';
        if ($r->booking_flag==2) {
          $status= "<span class='text-primary'>pending</span>";
          $button = $view.$edit.$cancel.$reject;
        } else if ($r->booking_flag==1) {
          $status= "<span class='text-success'>Accepted</span>";
          $button = $view.$cancel.$reject;
        } else if ($r->booking_flag==0) {
          $status= "<span class='text-danger'>Rejected</span>";
          $button = $view;
        } else if ($r->booking_flag==3) {
          $status= "<span class='text-danger'>Cancelled</span>";
          $button = $view;
        } else if ($r->booking_flag==4) {
          $status= "<span class='text-warning'>Hotel Approved</span>";
          $button = $view.$edit.$cancel.$reject;
        } else if ($r->booking_flag==5) {
          $status= "<span class='text-danger'>Cancellation Pending</span>";
          $button = $view.$editOk;
        } else if($r->booking_flag==8) {
          $status= "<span class='text-danger'>On Request</span>";
          $button =   $view.$edit.$cancel.$reject;
        }
        $total_markup = $r->agent_markup+$r->admin_markup; 
        $total_amount = ($r->total_amount*$total_markup)/100+$r->total_amount;
          $data[] = array(
              $key+1,
              $r->booking_id,
              date('d/m/Y',strtotime($r->Created_Date)),
              $r->transfertype,
              $r->arrivaldate,
              $r->From_location.'<b> to </b> '.$r->To_location,
              admin_currency()." ".currency_type(admin_currency(),$total_amount),
            $status,
            $button,
          );
    }
    $output = array(
     "draw" => $draw,
     "recordsTotal" => $booking_list->num_rows(),
     "recordsFiltered" => $booking_list->num_rows(),
     "data" => $data
    );
    echo json_encode($output);
    exit();
  }
  public function transfer_booking_details() {
    $data['view'] = $this->Booking_Model->transfer_booking_detail($_REQUEST['id']);
    $data['cancelation'] =  $this->Booking_Model->gettransferbookpolicy($_REQUEST['id']);
    $this->load->view('backend/booking/transfer_booking_view',$data);
  }
  public function transfer_portel_admin_permission() {
    $result = $this->Booking_Model->transfer_booking_admin_approved($_REQUEST);
    $description = 'Transfer booking accepted [ID: '.$_REQUEST['id'].']';
    AdminlogActivity($description);
    echo json_encode(true);
  }
  public function transferbooking_reference_id_popup() {
    $data['view'] = $this->Booking_Model->TransferBookingDetailGet($_REQUEST['book_id']);
    $this->load->view('backend/booking/transfer_booking_reference_id_popup',$data);
  }
  public function transferbookingcancel() {
    //$data['view'] = $this->Booking_Model->BookingDetailGet($_REQUEST);
    $this->load->view('backend/booking/transfercancelPop');
  }
  public function transfercancellationno() {
    redirect('../backend/booking/TransferBooking');
  }
  public function transfercancellationUpdate() {
    $id     =$_REQUEST['book_id'];
    $update        = $this->Booking_Model->transfercancellationUpdate($id);
    $description = 'Transfer booking cancelled [ID: '.$_REQUEST['book_id'].']';
    AdminlogActivity($description);
    redirect("../backend/booking/TransferBooking");
  }
  public function tourcancellationUpdate() {
    $id     =$_REQUEST['book_id'];
    $update        = $this->Booking_Model->tourcancellationUpdate($id);
    $description = 'Tour booking cancelled [ID: '.$_REQUEST['book_id'].']';
    AdminlogActivity($description);
    redirect("../backend/booking/TourBooking");
  }
  public function tour_portel_admin_permission() {
    $result = $this->Booking_Model->tour_booking_admin_approved($_REQUEST);
    $description = 'Tour booking accepted [ID: '.$_REQUEST['id'].']';
    AdminlogActivity($description);
    echo json_encode(true);
  }
  public function tourbooking_reference_id_popup() {
    $data['view'] = $this->Booking_Model->TourBookingDetailGet($_REQUEST['book_id']);
    $this->load->view('backend/booking/tour_booking_reference_id_popup',$data);
  }
  public function tourbookingcancel() {
    $this->load->view('backend/booking/tourcancelPop');
  }
  public function tourcancellationno() {
    redirect('../backend/booking/TourBooking');
  }
  public function hotelrequest_accepted_mailinvoice_attach($id) {
    $data = $this->Hotels_Model->Offlinebooking_details($id);
     

      require_once APPPATH . 'third_party/tcpdf/tcpdf.php';
      ob_start();
      $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

      $this->load->library('Pdf');
      $dimensions = $pdf->getPageDimensions();
      $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
      // $pdf->SetHeaderMargin(30);
      // $pdf->SetTopMargin(20);
      $pdf->setFooterMargin(20);
      $pdf->SetAutoPageBreak(true);
      $pdf->SetDisplayMode('real', 'default');

      //HEADER
      $pdf->SetAuthor('Otelseasy');
      $pdf->SetTitle('Otelseasy');

      //DESIGN
      // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
      // $pdf->SetHeaderMargin(20);


      $pdf->AddPage();

      $info_right_column = '';
      $info_left_column  = '';
      $invoice='';
      
      //AGENT DETAILS
      $agent_name=$data[0]->AFName." ".$data[0]->ALName;
      $agent_number=$data[0]->Mobile;
      $agent_email=$data[0]->Email;

      //HOTEL DETAILS
      $invoice_company_name=$data[0]->hotel_name;
      $invoice_company_address=$data[0]->hotel_addresss;
     
       // write the first column
       // $info_left_column .= "";
       // $pdf->MultiCell(($dimensions['wk'] / 2) - $dimensions['lm'], 0, $info_left_column, 0, 'L', 0, 0, '', '', true, 0, true, true, 0);
       // // write the second column
       // $pdf->MultiCell(($dimensions['wk'] / 2) - $dimensions['rm'], 0, $info_right_column, 0, 'R', 0, 0, '', '', true, 0, true, false, 0);
       
       // $pdf->ln(6);
       // // Get Y position for the separation
       // $y= $pdf->getY();

     
       
      $tbl_header = '<table border="0"  cellspacing="2" nobr="true" style="border-bottom:1px solid #999">';
      $tbl_footer = '</table>';
      $tbl = '';

      $tbl .= 
        '
          <tr>
            <td><img width="100" src="'.base_url().'skin/images/dash/logo.png" /></td>
            <td style="text-align:right;">'.$agent_name.'<br>'.$agent_number.'<br>'.$agent_email. '
            </td>
          </tr>
        ';

  $pdf->writeHTML($tbl_header . $tbl . $tbl_footer, true, false, false, false, '');

      $html='
            <div  style="font-size:14px ;font-weight:bold;color:#337ab7;">INVOICE</div>
            <div  style="font-size:12px ">Issued to : </div>
            ';
      $pdf->writeHTML($html, false, false, false, false, '');

    //INVOICE DETAILS
      $invoice_data_date= date("d-m-Y");
      $invoice_number = "Invoice00".$data[0]->requestid;
      $reference_id = "HOB".$data[0]->requestid;
      $customer_name=$data[0]->ContactName;
      $customer_email=$data[0]->ContactEmail;
      $customer_phone=$data[0]->ContactNumber;
            
      $tb2 ='
      <table class="table2">
        <tbody>
          <tr>
            <td style="text-indent:5px;">'.$customer_name.'</td>
            <td style="text-align:right;">Invoice date  : '.$invoice_data_date.'</td>
          </tr>
          <tr>
            <td style="text-indent:5px;">'.$customer_phone.'</td>
            <td style="text-align:right;">Invoice number  : '.$invoice_number.'</td>
          </tr>
          <tr>
            <td style="text-indent:5px;">'.$customer_email.'</td>
            <td style="text-align:right;">Booking reference number : '.$reference_id.'</td>
          </tr>
          <tr>
            <td style="text-indent:5px;"></td>
            <td style="text-align:right;">Hotel name : '.$invoice_company_name.'</td>
          </tr>
        </tbody>
      </table>
      ';

    $pdf->writeHTML($tb2, true, false, false, false, '');


// CHECKOUT DETAILS
    $room=$data[0]->room_name;
    $checkin_date=date_create($data[0]->check_in);
    $checkout_date=date_create($data[0]->check_out);
    $no_of_days=date_diff($checkin_date,$checkout_date);
    $days = $no_of_days->format("%a");
    $no_of_rooms=$data[0]->no_of_rooms;
    $check_in=date('d-m-Y',strtotime($data[0]->check_in));
    $check_out=date('d-m-Y',strtotime($data[0]->check_out));

    $tb3='
    <style type="text/css">
    .tg  {border-spacing:0;border:1px solid grey; border-collapse: collapse;text-align:center;}
    .tg td{font-size:10px;padding-top:2px 20px;border-style:solid;border-width:1px;word-break:normal;color:#333;background-color:ghostwhite; padding-bottom: 20px; border-collapse: separate;}
    .tg th{font-size:11px;padding:2px 20px;border-style:solid;border-width:1px;overflow:hidden;color:#333;background-color:ghostwhite; border-bottom: 1px solid #f0f8ff; height:20px;}
    .rgt_bor {border-right: 1px dashed #ccc;}
    .tg tr{width: 100%;}
    </style>
    <table class="tg">
      <tr>
        <th class="tgh rgt_bor" >Hotel Name</th>
        <th class="tgh rgt_bor">Room Type</th>
        <th class="tgh rgt_bor">Days</th>
        <th class="tgh rgt_bor">No of Rooms</th>
        <th class="tgh rgt_bor">Check In</th>
        <th class="tgh">Check Out</th>
      </tr>
      <tr>
        <td class="tgd rgt_bor">'.$invoice_company_name.'</td>
        <td class="tgd rgt_bor">'.$room.'</td>
        <td class="tgd rgt_bor">'.$days.'</td>
        <td class="tgd rgt_bor">'.$no_of_rooms.'</td>
        <td class="tgd rgt_bor">'.$check_in.'</td>
        <td class="tgd">'.$check_out.'</td>
      </tr>
    </table>

    ';

    // $pdf->writeHTML($tb3, true, false, false, false, '');

    //AMOUNT DETAILS START

      $tb5='
    <table style="border-collapse: collapse">
        <tbody>
          <tr>
            <th style="font-size:10px;font-weight:bold">Booking Amount Breakup : <br></th>
          </tr>
        </tbody>
      </table>';
      $pdf->writeHTML($tb5,true,false,false,false,'');


      $tb51='<style type="text/css">
                  .tg  {border-spacing:0;border:1px solid #dddddd; border-collapse: collapse;text-align:center;}
                  .tg td{font-size:11px;border-style:solid #dddddd;border-width:1px;word-break:normal;color:#333;  border-collapse: separate;}
                  .tg tr td{font-size:11px;border-style:solid #dddddd;border-width:1px;word-break:normal;color:#333;  border-collapse: separate;}
                  
                  
                  </style>';
          for ($i=1; $i <= $no_of_rooms; $i++) {
                 $tb51.='
                  <h4 class="room-name">Room '.$i.'</h4>
                  <table style="border-collapse: collapse;border:1px solid #dddddd" class="tg">
                  <thead>
                    <tr style="background-color: #0074b9;">
                      <td style="color: white">Date</td>
                      <td style="color: white">Room type</td>
                      <td style="color: white">Rate</td>
                    </tr>
                  </thead>
                  <tbody>';
                  $roomSelling = 'room'.$i.'Selling';
                  $SellingPrice = explode(",", $data[0]->$roomSelling);
                  for ($j=0; $j < $days ; $j++) {
                    $tb51 .='<tr>
                              <td>'.date('d/m/Y', strtotime($data[0]->check_in. ' + '.$j.'  days')).'</td>
                              <td>'.$data[0]->room_name.'</td>
                              <td style="text-align: right">
                              '.number_format(currency_type(admin_currency(),$SellingPrice[$j]),2).' '.admin_currency().'</td>
                            </tr>';
                  }

          $tb51 .='</tbody>
                    <tfoot>
                      <tr>
                        <td colspan="2" style="text-align: right"><strong style="color:#0074b9">Total</strong></td>
                        <td style="text-align:right"><strong style="color:#0074b9">'.currency_type(admin_currency(),array_sum($SellingPrice)).' '.admin_currency().'</strong></td>
                      </tr>
                    </tfoot>
                </table>';
        }
      $pdf->writeHTML($tb51,true,false,false,false,'');

      $final_total = array_sum($SellingPrice);
      $tb52 ='<table style="border-collapse: collapse">
                <tr>
                  <td colspan="3"></td>
                  <td>Tax :</td>
                  <td style="text-align:right">0%</td>
                </tr>';
                $tb52 .= '<tr>
                  <td colspan="3"></td>
                  <td>GRAND TOTAL :</td>
                  <td style="text-align:right">'.currency_type(admin_currency(),($final_total)).' '.admin_currency().'</td>
                </tr>
            </table>';
      $pdf->writeHTML($tb52,true,false,false,false,'');
    //AMOUNT DETAILS END
    $bankDetails = $this->Payment_Model->bankDetails();
      $tb9 = '<table style="border-collapse: collapse">
        <thead><tr>
            <td style="font-size:10px;text-indent:20px"><div style="font-weight:bold">Otelseasy Bank Account Details: </div></td>   
            </tr>
            <br>
            <tr>
            <td style="font-size:10px;">'.nl2br($bankDetails[0]->account).'</td>
            </tr>
            <tr><td style="font-size:10px;">'.$bankDetails[0]->email.'</td></tr>
            </thead>
      </table>';
      
      $pdf->writeHTML($tb9,true,false,false,false,'');
      $path = get_upload_path_by_type('offline_requests_invoice_pdf').$this->session->userdata('id').'/';
      _maybe_create_upload_path($path);
      $files = glob($path.'*'); 
      foreach($files as $file){
          if(is_file($file))
          unlink($file); 
      }
      $newpath  = $path . $invoice_number.'.pdf';
      $type = 'F';
      $pdf->Output($newpath, $type);
  }
  public function xmlBookingAmendmentModal() {
    $output = $this->Booking_Model->xmlhotel_booking_details($_REQUEST['id']);
    $inp_arr =[
          "ConfirmationNo"=>[
            "value" => $output[0]->ConfirmationNo
          ]
      ];
      
    $xmlData =  $this->List_Model->HotelBookingDetail($inp_arr);
    $data['view'] = array();
    $data['view1'] = $output;
    $data['bookid'] = $_REQUEST['id'];
    if ($xmlData['Status']['StatusCode']==01) {
      if ($output[0]->BookingId=="" || $output[0]->InvoiceNumber=="") {
        $insertXMlBookingId = $this->Booking_Model->updateXMlBookingId($_REQUEST['id'],$xmlData['BookingDetail']['@attributes']['BookingId'],$xmlData['BookingDetail']['@attributes']['InvoiceNumber']);
      }
      $data['view'] = $xmlData['BookingDetail'];
    }
    $this->load->view('backend/booking/xmlBookingAmendmentModal',$data);
  }
  public function amendmentRequest() {
    $output = $this->Booking_Model->xmlhotel_booking_details($_REQUEST['bookid']);
    $roompos = array_unique($_REQUEST['roompos']);
    foreach ($roompos as $key => $value) {
      if($value=="room1") {
        $room = "FirstRoom";
      } else if($value=="room2") {
        $room = "SecondRoom";
      } else if($value=="room3") {
        $room = "ThirdRoom";
      } else if($value=="room4") {
        $room = "FourthRoom";
      } else if($value=="room5") {
        $room = "FifthRoom";
      } else if($value=="room6") {
        $room = "SixthRoom";
      } else if($value=="room7") {
        $room = "SeventhRoom";
      } else if($value=="room8") {
        $room = "EighthRoom";
      } else if($value=="room9") {
        $room = "NinthRoom";
      } else if($value=="room10") {
        $room = "TenthRoom";
      }
      
      $num = count($_REQUEST[$value.'-firstname']);
     
      for($i=0;$i<$num;$i++) {
        if ($_REQUEST[$value.'-action'][$i]=="Delete") {
          $guest[$i] = [
                "Guest" =>[
                  "attr"=>[
                    "Action"=> $_REQUEST[$value.'-action'][$i],
                    "ExistingName" => $_REQUEST[$value.'-existing'][$i],
                    "GuestType" => $_REQUEST[$value.'-guesttype'][$i],
                    "Age" => 0
                  ]
                ]
              ];
        } else {
          $guest[$i] = [
                "Guest" =>[
                  "attr"=>[
                    "Action"=> $_REQUEST[$value.'-action'][$i],
                    "ExistingName" => $_REQUEST[$value.'-existing'][$i],
                    "GuestType" => $_REQUEST[$value.'-guesttype'][$i],
                    "Title" => $_REQUEST[$value.'-title'][$i],
                    "FirstName" => $_REQUEST[$value.'-firstname'][$i],
                    "LastName" => $_REQUEST[$value.'-lastname'][$i],
                    "Age" => $_REQUEST[$value.'-age'][$i]
                  ]
                ]
              ];
        }       
      }
      $roomreq[$key] = [
            "RoomReq" =>[
              "attr"=>[
                "Amend"=> $room,
              ],
              "value" => $guest
            ]
          ]; 
          unset($guest);
    }  
    $inp_arr = [
      "Request" => [
        "attr" => [
          "Type" => "OfflineAmendment",
          "PriceChange" => "Approved",
          "Remarks" => "guest name amendment requested"
        ]
      ],
      "ConfirmationNo" => [
        "value" => $output[0]->ConfirmationNo
      ],
      "AmendInformation" =>[
        "value" => [
          "Rooms" => [
            "value" => $roomreq,
          ]  
        ]
      ]
    ]; 
    $Amendmentresponse =  $this->List_Model->Amendment($inp_arr);
    if($Amendmentresponse['Status']['StatusCode']=='01') {
      foreach ($roompos as $key => $value) {
        $num = count($_REQUEST[$value.'-firstname']);
        for($i=0;$i<$num;$i++) {
          if ($_REQUEST[$value.'-action'][$i]=="Delete") {
            $data = array(
              "action" => $_REQUEST[$value.'-action'][$i],
              "existingName" => $_REQUEST[$value.'-existing'][$i],
              "guestType" => $_REQUEST[$value.'-guesttype'][$i],
              "age" => 0,
              "bookingId" => $_REQUEST['bookid'],
              "requestedBy" => $this->session->userdata('id'),
              "requestedDate" => date('Y-m-d H:i:s'),
              "room" => $roompos[$i]
            );
          } else {
            $data = array(
              "action" => $_REQUEST[$value.'-action'][$i],
              "existingName" => $_REQUEST[$value.'-existing'][$i],
              "guestType" => $_REQUEST[$value.'-guesttype'][$i],
              "title" =>  $_REQUEST[$value.'-title'][$i],
              "firstName" => $_REQUEST[$value.'-firstname'][$i],
              "lastName" => $_REQUEST[$value.'-lastname'][$i],
              "age" => $_REQUEST[$value.'-age'][$i],
              "bookingId" => $_REQUEST['bookid'],
              "requestedBy" => $this->session->userdata('id'),
              "requestedDate" => date('Y-m-d H:i:s'),
              "room" => $roompos[$i]
            );
          }
          $this->Booking_Model->addAmendment($data);
        }
      }
      $result = $this->Booking_Model->updateXmlBooking($_REQUEST['bookid']);
      $return['msg'] = 'Your amendment request has been successfully submitted';
      $return['color'] = 'green';
    } else {
      $return['msg'] = $Amendmentresponse['Status']['Description'];
      $return['color'] = 'red';
    }    
      echo json_encode($return);
  }
  public function amendmentCheckStatus() {
    $output = $this->Booking_Model->xmlhotel_booking_details($_REQUEST['bookingid']);
    $inp_arr = [
      "Request" => [
        "attr" => [
          "Type" => "CheckStatus",
          "PriceChange" => "InformationRequired",
          "Remarks" => "checking status of amendment request"
        ]
      ],
      "ConfirmationNo" => [
        "value" => $output[0]->ConfirmationNo
      ]
    ];
    $status =  $this->List_Model->Amendment($inp_arr);
    print_r($status);exit();
  }
  public function bookingRemarkSubmit() {
    $this->Booking_Model->bookingRemarkSubmit($_REQUEST);
    $description = 'Hotel booking remarks updated [ID: '.$_REQUEST['bkId'].', Provider: Otelseasy]';
    AdminlogActivity($description);
    redirect(base_url().'backend/booking/hotel_booking_details?id='.$_REQUEST['bkId']);
  }
  public function remarksDelete() {
    $this->Booking_Model->remarksDelete($_REQUEST['id']);
    $description = 'Hotel booking remarks Deleted [ID: '.$_REQUEST['id'].', Provider: Otelseasy]';
    AdminlogActivity($description);
    redirect(base_url().'backend/booking/hotel_booking_details?id='.$_REQUEST['bkid']);
  }
  public function recentBookingList() {
    $data = array();
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        if (isset($_REQUEST['filter'])) {
          $filter = $_REQUEST['filter'];
        } else {
          $filter = "2";
        }
        // @xmlBooking list
        // This list datas get from xml 
        // xml booking list start 
        $XMlbooking_list = $this->Booking_Model->XMlbooking_list($filter);

        foreach ($XMlbooking_list->result() as $key => $r) {
            $Booking = menuPermissionAvailability($this->session->userdata('id'),'Booking','Hotel Booking'); 
            if($Booking[0]->view!=0){
                $view = '<a title="view"  href="'.base_url().'backend/booking/xmlhotel_booking_details?id='.$r->id.'&provider='.$r->XMLProvider.'"><i class="fa fa-eye" aria-hidden="true"  style="margin-right: 5px;"></i></a>';
            }else{
                  $view="";
            }
            if($Booking[0]->edit!=0){
                  $cancel='<a title="cancel" href="#" onclick="xmlcancelPopup('.$r->id.');" data-toggle="modal" data-target="#cancelModel" class="sb2-2-1-edit delete"><i class="fa fa-times-circle  red" style="margin-right: 5px; aria-hidden="true"></i></a>';
                  $edit='<a title="accept" href="#" onclick="add_reference_entryxml_fun('.$r->id.','.$r->agent_id.','.$r->Hotel_id.','."'$r->Check_in'".');" data-toggle="modal" data-target="#reference_add_modal"><i class="fa fa-check" aria-hidden="true" style="margin-right: 5px;"></i></a>';          
            }else{
                  $edit="";
                  $cancel = "";
            }
          if ($r->bookingFlg==2) {
              $status= "<span class='text-primary'>pending</span>";
              $button = $view.$edit.$cancel;
          } elseif($r->bookingFlg==1) {
              $status= "<span class='text-success'>Accepted</span>";
              $button = $view.$cancel;
          } elseif($r->bookingFlg==3) {
              $status= "<span class='text-danger'>Cancelled</span>";
              $button = $view;
          } elseif($r->bookingFlg==5) {
              $status= "<span class='text-danger'>Cancellation pending</span>";
              $button = $view;
          } elseif($r->bookingFlg==9) {
              $status= "<span class='text-danger'>Amendment Request Send</span>";
              $button = $view;
          }
            $data[] = array(
              '',
              $r->BookingId,
              "<span class='hide'>".strtotime($r->Bookingdate)."</span>".date('d/m/Y',strtotime($r->Bookingdate)),
              $r->hotel_name,
              $r->RoomTypeName,
              date('d/m/Y',strtotime($r->Check_in)),
              date('d/m/Y',strtotime($r->Check_out)),
              $r->no_of_days,
              $r->no_of_rooms,
              admin_currency().' '.ceil(backend_currency_type($r->total_amount)),
              $status,
              $r->ConfirmationNo,
              $view,
              );

          }

        // xml booking list end
        $booking_list = $this->Booking_Model->hotel_booking_list($filter);
          foreach($booking_list->result() as $key => $r) {
            $Booking = menuPermissionAvailability($this->session->userdata('id'),'Booking','Hotel Booking'); 
            if($Booking[0]->view!=0){
                  $view='<a title="view"  href="'.base_url().'backend/booking/hotel_booking_details?id='.$r->id.'"><i class="fa fa-eye" aria-hidden="true"  style="margin-right: 5px;"></i></a>';
            }else{
                  $view="";
            }
            if($Booking[0]->edit!=0){
                  $edit='<a title="accept" href="#" onclick="add_reference_entry_fun('.$r->book_id.','.$r->agent.','.$r->hotel_id.','."'$r->check_in'".');" data-toggle="modal" data-target="#reference_add_modal"><i class="fa fa-check" aria-hidden="true" style="margin-right: 5px;"></i></a>';
                   $cancel='<a title="cancel" href="#" onclick="cancelPopup('.$r->book_id.','.$r->hotel_id.');" data-toggle="modal" data-target="#cancelModel" class="sb2-2-1-edit delete"><i class="fa fa-times-circle  red" style="margin-right: 5px; aria-hidden="true"></i></a>';
                  $editOk='<a title="cancel" href="#" onclick="cancelPopup('.$r->book_id.','.$r->hotel_id.');" data-toggle="modal" data-target="#cancelModel" class="sb2-2-1-edit delete"><i class="fa fa-thumbs-o-up" style="margin-right: 5px; aria-hidden="true"></i></a>';                   
            }else{
                  $edit="";
                  $cancel = "";
                  $editOk = "";
            } 

           
            // $reject='<a title="reject" href="#" onclick="rejectPopup('.$r->book_id.','.$r->hotel_id.');" data-toggle="modal" data-target="#rejectModel" class="sb2-2-1-edit delete"><i class="  fa fa-ban red" style="margin-right: 5px; aria-hidden="true"></i></a>';

            $reject='';
            $Totselling = $this->Finance_Model->TotsellingGet($r->id);

            if ($r->booking_flag==2) {
              $status= "<span class='text-primary'>pending</span>";
              $button = $view.$edit.$cancel.$reject;
            } else if ($r->booking_flag==1) {
              $status= "<span class='text-success'>Accepted</span>";
              $button = $view.$cancel.$reject;
            } else if ($r->booking_flag==0) {
              $status= "<span class='text-danger'>Rejected</span>";
              $button = $view;
            } else if ($r->booking_flag==3) {
              $status= "<span class='text-danger'>Cancelled</span>";
              $button = $view;
            } else if ($r->booking_flag==4) {
              $status= "<span class='text-warning'>Hotel Approved</span>";
              $button = $view.$edit.$cancel.$reject;
            } else if ($r->booking_flag==5) {
              $status= "<span class='text-danger'>Cancellation Pending</span>";
              $button = $view.$editOk;
            } else if($r->booking_flag==8) {
              $status= "<span class='text-danger'>On Request</span>";
              $button =   $view.$edit.$cancel.$reject;
            }


              $data[] = array(
                '',
                $r->booking_id,
                "<span class='hide'>".strtotime($r->Created_Date)."</span>".date('d/m/Y',strtotime($r->Created_Date)),
                $r->hotel_name,
                $r->room_name." ".$r->Room_Type,
                date('d/m/Y',strtotime($r->check_in)),
                date('d/m/Y',strtotime($r->check_out)),
                $r->no_of_days,
                $r->book_room_count,
                admin_currency().' '.ceil(backend_currency_type($Totselling)),
                $status,
                $r->confirmationNumber,
                $view,
              );
          }
          $output = array(
           "draw" => $draw,
           "recordsTotal" => $booking_list->num_rows()+$XMlbooking_list->num_rows(),
           "recordsFiltered" => $booking_list->num_rows()+$XMlbooking_list->num_rows(),
           "data" => $data
          );
          echo json_encode($output);
          exit();
  }
  public function offlineremarksDelete() {
    $this->Booking_Model->offlineremarksDelete($_REQUEST['id'],$_REQUEST['type']);
    $description = 'Offline '.$_REQUEST['type'].' booking remarks Deleted [ID: '.$_REQUEST['id'].', Provider: Otelseasy]';
    AdminlogActivity($description);
    if ($_REQUEST['type']=="hotel") {
      $url = "booking/hotel_offlinebooking_view";
    } else if($_REQUEST['type']=="tour") {
      $url = "offlinerequest/offline_tour_request_view";
    }
    redirect(base_url().'backend/'.$url.'?id='.$_REQUEST['id']);
  }
  public function OfflinebookingRemarkSubmit() {
    $this->Booking_Model->OfflinebookingRemarkSubmit($_REQUEST);
    $description = 'Offline '.$_REQUEST['type'].' booking remarks updated [ID: '.$_REQUEST['bkId'].', Provider: Otelseasy]';
    AdminlogActivity($description);
    if ($_REQUEST['type']=="hotel") {
      $url = "booking/hotel_offlinebooking_view";
    } else if($_REQUEST['type']=="tour") {
      $url = "offlinerequest/offline_tour_request_view";
    }
    redirect(base_url().'backend/'.$url.'?id='.$_REQUEST['bkId']);
  }
  public function AmmendmentModal() {
    $data['view'] = $this->Booking_Model->hotel_booking_detail($_REQUEST['id']);
    $this->load->view('backend/booking/AmmendmentModal',$data);
  }
  public function amendmentUpdate() {
    $Room1individual_amount = '';
    $Room2individual_amount = '';
    $Room3individual_amount = '';
    $Room4individual_amount = '';
    $Room5individual_amount = '';
    $Room6individual_amount = '';
    if (isset($_REQUEST['Room1'])) {
      $Room1individual_amount = implode(",", $_REQUEST['Room1']);
    }
    if (isset($_REQUEST['Room2'])) {
      $Room2individual_amount = implode(",", $_REQUEST['Room2']);
    }
    if (isset($_REQUEST['Room3'])) {
      $Room3individual_amount = implode(",", $_REQUEST['Room3']);
    }
    if (isset($_REQUEST['Room4'])) {
      $Room4individual_amount = implode(",", $_REQUEST['Room4']);
    }
    if (isset($_REQUEST['Room5'])) {
      $Room5individual_amount = implode(",", $_REQUEST['Room5']);
    }
    if (isset($_REQUEST['Room6'])) {
      $Room6individual_amount = implode(",", $_REQUEST['Room6']);
    }
    $array = array('bookID' => $_REQUEST['id'],
                   'Room1individual_amount' => $Room1individual_amount,
                   'Room2individual_amount' => $Room2individual_amount,
                   'Room3individual_amount' => $Room3individual_amount,
                   'Room4individual_amount' => $Room4individual_amount,
                   'Room5individual_amount' => $Room5individual_amount,
                   'Room6individual_amount' => $Room6individual_amount,
                   'Created_Date' => date('Y-m-d H:i:s'),
                   'Created_By'   =>  $this->session->userdata('id')
    );
    $this->db->insert('hotel_tbl_hotelamendments',$array);
    redirect(base_url().'backend/booking/hotel_booking_details?id='.$_REQUEST['id']);
  }
}
?>

