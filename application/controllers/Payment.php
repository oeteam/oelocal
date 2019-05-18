<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Payment extends MY_Controller {
  public function __construct()
     {
          parent::__construct();
          $this->load->model('Payment_Model');
          $this->load->model('Hotels_Model');
          $this->load->model('Booking_Model');
          $this->load->model('Common_Model');
          $this->load->model('List_Model');
          $this->load->model('Finance_Model');
          $this->load->helper('url');
          $this->load->helper('html');
          $this->load->library('email');
          $this->load->helper('common');
          $this->load->helper('upload');
          $this->load->library('session');
          $this->load->library('gateways/App_gateway', '', 'App_gateway');
          $this->load->library('gateways/Paypal_gateway', '', 'Paypal_gateway');
          $this->load->library('gateways/Two_checkout_gateway', '', 'Two_checkout_gateway');
          $this->load->library('gateways/Paypal_braintree_gateway', '', 'Paypal_braintree_gateway');
          $this->load->library('gateways/Authorize_sim_gateway', '', 'Authorize_sim_gateway');
          $this->load->library('gateways/Stripe_gateway', '', 'Stripe_gateway');
          $this->load->library('gateways/Paypal_gateway', '', 'Paypal_gateway');
          $this->load->library('gateways/Telr_gateway', '', 'Telr_gateway');
          $this->load->library('gateways/Mollie_gateway', '', 'Mollie_gateway');
     }
     public function index() {
      if ($this->session->userdata('agent_id')=="") {
        redirect(base_url());
      }
      if (!isset($_REQUEST['adults'][0])) {
        redirect('../hotels');
      }

      $bookbuttondata = $this->session->userdata('hoteldata');
      $data['additionalfoodrequest'] = array();
      $data['board'] = array();
      $data['general'] = array();
      $data['view'] = $this->Payment_Model->hotelDetails($_REQUEST['hotel_id']);
       $hotel_facilities = explode(",",$data['view'][0]->hotel_facilities); 
      foreach ($hotel_facilities as $key => $value) {
        $data['hotel_facilities'][$key] = $this->List_Model->hotel_facilities_data($value);
      }

      $room_facilities = explode(",",$data['view'][0]->room_facilities); 
      foreach ($room_facilities as $key => $value) {
        $data['room_facilities'][$key] = $this->List_Model->room_facilities_data($value);
      }
      $data['tax'] = $this->Payment_Model->general_tax($_REQUEST['hotel_id']);
      $rooms  =array();
      $contracts =$this->List_Model->contractchecking($_REQUEST);
      $Rooms = $this->Hotels_Model->select_hotel_room($_REQUEST['hotel_id'])->result();
      $agent_markup = mark_up_get()+general_mark_up_get();
      $i = 0;
      foreach ($Rooms as $key => $value) {
        foreach ($contracts['contract_id'] as $key1 => $value1) {
          $revenue_markup = revenue_markup($_REQUEST['hotel_id'],$value1,$this->session->userdata('agent_id'));
          $total_markup = $agent_markup;
          if ($revenue_markup!='') {
            $total_markup = $revenue_markup+mark_up_get();
          }
          $contractBoardget = $this->List_Model->contractBoardget($_REQUEST['hotel_id'],$value1);

          $room_current_count = $this->List_Model->room_current_count($value->room_id,$_REQUEST['Check_in'],$_REQUEST['Check_out'],$value1,$_REQUEST['adults'],$_REQUEST['Child'],$_REQUEST,$total_markup,$value1);
          $room_closedout = $this->List_Model->all_closedout_room($_REQUEST['hotel_id'],$value1,$_REQUEST,$value);
          $minimumStay = $this->List_Model->minimumStayCheckAvailability($_REQUEST,$value->room_id);
          if($room_closedout['condition']!=1 && $minimumStay=="true" && $room_current_count['price']!=0 && $room_current_count['condition']!="false") {
            $rooms[$i]['RoomName'] = $value->room_name.' '.$value->Room_Type;
            $rooms[$i]['RoomIndex'] = $value->room_id.'-'.$value1;
            $rooms[$i]['room_id'] = $value->room_id;
            $rooms[$i]['board'] = $contractBoardget->board;
            $rooms[$i]['contract_id'] = $value1;
            $rooms[$i]['price'] = currency_type(agent_currency(),$room_current_count['price']);
            $rooms[$i]['generalsupplementType'] = count($room_current_count['generalsupplementType'])!=0 ? array_unique($room_current_count['generalsupplementType']) : array();
            if ($room_current_count['allotement']> 0) {
              $rooms[$i]['RequestType'] = 'Book';
            } else {
              $rooms[$i]['RequestType'] = 'On Request';
            }
            $i++;
          }
        }
      }
      $data['rooms'] = $rooms;
      $data['total_markup'] = $total_markup;
      $data['agent_info'] = $this->Common_Model->agent_info();
      $this->load->view('frontend/payment',$data);
     }
     public function payment_booking() {
         if (!isset($_REQUEST['reqadults'])) {
          redirect('../hotels');
        }
        $data['board'] = array();
        $data['additionalfoodrequest'] = array();
        $_REQUEST['room_id'] = $_REQUEST['room_index'];
        $_REQUEST['contract_id'] = $_REQUEST['contract_index'];
        $id = $_REQUEST['room_id'];
        $data['tax'] = $this->Payment_Model->general_tax($_REQUEST['hotel_id']);
        $data['view'] = $this->Payment_Model->hotel_details_view($id);
        $revenue_markup = revenue_markup($_REQUEST['hotel_id'],$_REQUEST['contract_index'],$this->session->userdata('agent_id'));
        $total_markup = mark_up_get()+general_mark_up_get();
        if ($revenue_markup!='') {
          $total_markup = $revenue_markup+mark_up_get();
        }
        $data['contract'] = $this->Payment_Model->get_policy_contract($_REQUEST['hotel_id'],$_REQUEST['contract_id']);
        $data['CancellationPolicy'] = $this->Payment_Model->get_CancellationPolicy_tableFlow($_REQUEST);
        $data['total_markup'] = $total_markup;
        $data['agent_currency'] = $this->Payment_Model->agent_currency_typesss();
        $data['general'] = $this->Payment_Model->get_Confirmgeneral_supplement($_REQUEST);
        if (isset($_REQUEST['board'])) {
          $data['board'] = $this->Payment_Model->get_PaymentConfirmboard_supplement($_REQUEST);
        }
        $data['extrabed'] = $this->Payment_Model->get_PaymentConfirmextrabedAllotment($_REQUEST);
      $contractBoardCheck = $this->Payment_Model->contractBoardCheck($_REQUEST['contract_id']);
      $data['boardName'] = $contractBoardCheck;
      if ($contractBoardCheck=="RO") {
        $Breakfast = $this->Payment_Model->additionalfoodrequest($_REQUEST,'Breakfast');
        if ($Breakfast!=false) {
          $data['additionalfoodrequest']['board'][] = 'Breakfast';
        }
        $Lunch = $this->Payment_Model->additionalfoodrequest($_REQUEST,'Lunch');
        if ($Lunch!=false) {
          $data['additionalfoodrequest']['board'][] = 'Lunch';
        }
        $Dinner = $this->Payment_Model->additionalfoodrequest($_REQUEST,'Dinner');
        if ($Dinner!=false) {
          $data['additionalfoodrequest']['board'][] = 'Dinner';
        }
      } else if ($contractBoardCheck=="BB") {
        $Lunch = $this->Payment_Model->additionalfoodrequest($_REQUEST,'Lunch');
        if ($Lunch!=false) {
          $data['additionalfoodrequest']['board'][] = 'Lunch';
        }
        $Dinner = $this->Payment_Model->additionalfoodrequest($_REQUEST,'Dinner');
        if ($Dinner!=false) {
          $data['additionalfoodrequest']['board'][] = 'Dinner';
        }
      } else if ($contractBoardCheck=="HB") {
        $Lunch = $this->Payment_Model->additionalfoodrequest($_REQUEST,'Lunch');
        if ($Lunch!=false) {
          $data['additionalfoodrequest']['board'][] = 'Lunch';
        }
      } 
      if ($this->session->userdata('Breakfast')!="") { 
       $data['Breakfast'] = $this->Payment_Model->supplementcheck($this->session->userdata('Breakfast'));
      } 
      if ($this->session->userdata('Lunch')!="") { 
       $data['Lunch'] = $this->Payment_Model->supplementcheck($this->session->userdata('Lunch'));
      } 
      if ($this->session->userdata('Dinner')!="") { 
       $data['Dinner'] = $this->Payment_Model->supplementcheck($this->session->userdata('Dinner'));
      } 
      // print_r($data['Breakfast1']);
      // exit();
      $data['agent_credit_amount'] = $this->Payment_Model->agent_credit_amount();
      $data['roomAvailability'] =  $this->Payment_Model->roomAvailability($_REQUEST['room_id'],$_REQUEST['Check_in'],$_REQUEST['Check_out'],$_REQUEST['contract_id'],$_REQUEST['hotel_id']);

      $data['discount'] = $this->List_Model->discountCheck($_REQUEST['Check_in'],$_REQUEST['Check_out'],$_REQUEST['hotel_id'],$_REQUEST['room_id'],$_REQUEST['contract_id']);
      $data['paypal'] = $this->List_Model->getpaypaldetails();
      $data['checkout'] = $this->List_Model->getcheckoutdetails();
      $data['braintree'] = $this->List_Model->getbraintreedetails();
      $data['mollie'] = $this->List_Model->getmolliedetails();
      $data['stripe'] = $this->List_Model->getstripedetails();
      $data['authorize_sim'] = $this->List_Model->getsimdetails();
      $data['authorize_aim'] = $this->List_Model->getaimdetails();
      $data['telr'] = $this->List_Model->gettelrdetails();
      $this->session->unset_userdata('booking_data');
      $this->load->view('frontend/payment_booking',$data);
     }
     public function payment_booking_confirm() {
      $this->load->model('List_Model');
        if (!isset($_REQUEST['adults'])) {
          redirect('../hotels');
        }
        $this->session->set_userdata('booking_data',$_REQUEST);
        $payment_method = $_REQUEST['paymenttype'];
        if($payment_method!='credit'){
          $this->booking_online_payment($_REQUEST);
        } else {
          $this->bookingdataInsert('Credit',$_REQUEST);
        }
     }
     public function agent_booking() {
      $this->load->view('frontend/booking/agent_booking');
     }
     public function agent_booking_list() {
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

      /*Xml Agent booking list start*/
      $xmlbooking_list = $this->Payment_Model->xml_booking_list($filter);
      foreach ($xmlbooking_list->result() as $key1 => $r) {
        $invoice = '';
        $voucher = '';
        if ($r->bookingFlg==2) {
          $status= "<span class='text-primary'>pending</span>";
          $voucher = '<a class="text-primary" href="'.base_url().'Payment/xmlvoucher_pdf?id='.$r->id.'&ConfirmationNo='.$r->ConfirmationNo.'&invoiceno='.$r->InvoiceNumber.'">VOUCHER_0'.$r->id.'</a>';
        } else if ($r->bookingFlg==1) {
          $status= "<span class='text-success'>Accepted</span>";
          $invoice = '<a class="text-primary" href="'.base_url().'Payment/xmlinvoice_pdf?id='.$r->id.'&ConfirmationNo='.$r->ConfirmationNo.'&invoiceno='.$r->InvoiceNumber.'">'.$r->InvoiceNumber.'</a>';
          $voucher = '<a class="text-primary" href="'.base_url().'Payment/xmlvoucher_pdf?id='.$r->id.'&ConfirmationNo='.$r->ConfirmationNo.'&invoiceno='.$r->InvoiceNumber.'">VOUCHER_0'.$r->id.'</a>';
        } else if ($r->bookingFlg==3) {
          $status= "<span class='text-danger'>Cancelled</span>";
        } else if ($r->bookingFlg==5) {
          $status= "<span class='text-danger'>Cancellation Pending</span>";
        }
        $data[] = array(
              '',
              $r->BookingId,
              date('d/m/Y',strtotime($r->Bookingdate)),
              $r->hotel_name,
              $r->RoomTypeName,
              $invoice,
              $voucher,
              date('d/m/Y',strtotime($r->Check_in)),
              date('d/m/Y',strtotime($r->Check_out)),
              $r->no_of_days,
              $r->no_of_rooms,
              $r->total_amount,
              $status,
              '<a title="view" class="btn btn-sm btn-success" href="'.base_url().'Payment/xml_booking_view?id='.$r->id.'&ConfirmationNo='.$r->ConfirmationNo.'"><i class="fa fa-eye" aria-hidden="true"></i></a>'
        );
      }
      /*Xml Agent booking list end*/

      $booking_list = $this->Payment_Model->agent_booking_list($filter);
      // print_r($booking_list->result());
      // exit();
        foreach($booking_list->result() as $key => $r) {
          $check_in =strtotime($r->check_in);
          // $check_in = date("d-m-Y",$date);
          
          $Totselling= $this->Finance_Model->TotsellingGet($r->id);
          $final_total = ceil($Totselling);

          if ($r->booking_flag==2) {
            $status= "<span class='text-primary'>pending</span>";
            $permission = ' <a title="cancel" href="#" class="btn btn-sm btn-danger" onclick="deletefun('.$r->bk_id.','.$check_in.');" data-toggle="modal" data-target="#myModal" class="sb2-2-1-edit delete"><i class="fa fa-remove" aria-hidden="true"></i></a>';
          } else if ($r->booking_flag==1) {
            $status= "<span class='text-success'>Accepted</span>";
            $permission = ' <a title="cancel" href="#" class="btn btn-sm btn-danger" onclick="deletefun('.$r->bk_id.','.$check_in.');" data-toggle="modal" data-target="#myModal" class="sb2-2-1-edit delete"><i class="fa fa-remove" aria-hidden="true"></i></a>';
          } else if ($r->booking_flag==0) {
            $status= "<span class='text-danger'>Rejected</span>";
            $permission = ' <a title="Already Rejected" href="#" class="btn btn-sm btn-danger"  class="sb2-2-1-edit delete"><i class="fa fa-ban" aria-hidden="true"></i></a>';
          } else if ($r->booking_flag==3) {
            $status= "<span class='text-danger'>Cancelled</span>";
            $permission = ' <a title="Already cancelled" href="#" class="btn btn-sm btn-danger"  class="sb2-2-1-edit delete"><i class="fa fa-ban" aria-hidden="true"></i></a>';
          } else if ($r->booking_flag==4) {
            $status= "<span class='text-danger'>Accept Pending</span>";
            $permission = ' <a title="cancel" href="#" class="btn btn-sm btn-danger" onclick="deletefun('.$r->bk_id.','.$check_in.');" data-toggle="modal" data-target="#myModal" class="sb2-2-1-edit delete"><i class="fa fa-remove" aria-hidden="true"></i></a>';
          } else if ($r->booking_flag==5) {
            $status= "<span class='text-danger'>Cancellation pending</span>";
            $permission = '';
          } else if ($r->booking_flag==8) {
            $status= "<span class='text-primary'>pending</span>";
            $permission = ' <a title="cancel" href="#" class="btn btn-sm btn-danger" onclick="deletefun('.$r->bk_id.','.$check_in.');" data-toggle="modal" data-target="#myModal" class="sb2-2-1-edit delete"><i class="fa fa-remove" aria-hidden="true"></i></a>';
          }
          $view='<a title="view" class="btn btn-sm btn-success" href="'.base_url().'Payment/agent_booking_view?id='.$r->bk_id.'"><i class="fa fa-eye" aria-hidden="true"></i></a>'.$permission;
          if (isset($r->invoice_id) && $r->invoice_id!="" && $r->booking_flag==1) {
            $invoice = '<a class="text-primary" href="'.base_url().'Payment/invoice_pdf?id='.$r->bk_id.'">'.$r->invoice_id.'</a>';
          } else {
            $invoice = '<a class="text-primary" href="'.base_url().'Payment/invoice_pdf?id='.$r->bk_id.'">TEMPINVOICE'.$r->bk_id.'</a>';
          }
          if ($r->booking_flag==1) {
            $voucher = '<a class="text-primary" href="'.base_url().'Payment/voucher_pdf?id='.$r->bk_id.'">VOUCHER_0'.$r->bk_id.'</a>';
          } else{
            $voucher = '<a class="text-primary" href="'.base_url().'Payment/voucher_pdf?id='.$r->bk_id.'">VOUCHER_0'.$r->bk_id.'</a>';
          }
          
           if ($r->booking_flag==2 || $r->booking_flag==8) {
              $status= "<span class='text-primary'>pending</span>";
              $data[] = array(
              '',
              $r->booking_id,
              date('d/m/Y',strtotime($r->Created_Date)),
              strlen($r->hotel_name)> 15 ? substr($r->hotel_name,0,15)."..." : $r->hotel_name,
              strlen($r->Room_Type)> 15 ? substr($r->Room_Type,0,15)."..." : $r->Room_Type,
              $invoice,
              $voucher,
              date('d/m/Y' ,strtotime($r->check_in)),
              date('d/m/Y' ,strtotime($r->check_out)),
              $r->no_of_days,
              $r->book_room_count,
              agent_currency()." ".currency_type(agent_currency(),$final_total),
              $status,
              $view,
              );
             } else if ($r->booking_flag==4) {
              $data[] = array(
              '',
              $r->booking_id,
              date('d/m/Y',strtotime($r->Created_Date)),
              strlen($r->hotel_name)> 15 ? substr($r->hotel_name,0,15)."..." : $r->hotel_name,
              strlen($r->Room_Type)> 15 ? substr($r->Room_Type,0,15)."..." : $r->Room_Type,
              $invoice,
              $voucher,
              date('d/m/Y' ,strtotime($r->check_in)),
              date('d/m/Y' ,strtotime($r->check_out)),
              $r->no_of_days,
              $r->book_room_count,
              agent_currency()." ".currency_type(agent_currency(),$final_total),
              $status,
              $view,
              );
             }  else if ($r->booking_flag==1) {
              $status= "<span class='text-success'>Accepted</span>";
              $data[] = array(
              '',
              $r->booking_id,
              date('d/m/Y',strtotime($r->Created_Date)),
              strlen($r->hotel_name)> 15 ? substr($r->hotel_name,0,15)."..." : $r->hotel_name,
              strlen($r->Room_Type)> 15 ? substr($r->Room_Type,0,15)."..." : $r->Room_Type,
              $invoice,
              $voucher,
              date('d/m/Y' ,strtotime($r->check_in)),
              date('d/m/Y' ,strtotime($r->check_out)),
              $r->no_of_days,
              $r->book_room_count,
              agent_currency()." ".currency_type(agent_currency(),$final_total),
              $status,
              $view,
              );
            } else if ($r->booking_flag==0) {
              $status= "<span class='text-danger'>Rejected</span>";
              $data[] = array(
              '',
              $r->booking_id,
              date('d/m/Y',strtotime($r->Created_Date)),
              strlen($r->hotel_name)> 15 ? substr($r->hotel_name,0,15)."..." : $r->hotel_name,
              strlen($r->Room_Type)> 15 ? substr($r->Room_Type,0,15)."..." : $r->Room_Type,
              $invoice,
              $voucher,
              date('d/m/Y' ,strtotime($r->check_in)),
              date('d/m/Y' ,strtotime($r->check_out)),
              $r->no_of_days,
              $r->book_room_count,
              agent_currency()." ".currency_type(agent_currency(),$final_total),
              $status,
              $view,
              );
            } else if ($r->booking_flag==3) {
              $status= "<span class='text-danger'>Cancelled</span>";
              $data[] = array(
              '',
              $r->booking_id,
              date('d/m/Y',strtotime($r->Created_Date)),
              strlen($r->hotel_name)> 15 ? substr($r->hotel_name,0,15)."..." : $r->hotel_name,
              strlen($r->Room_Type)> 15 ? substr($r->Room_Type,0,15)."..." : $r->Room_Type,
              $invoice,
              $voucher,
              date('d/m/Y' ,strtotime($r->check_in)),
              date('d/m/Y' ,strtotime($r->check_out)),
              $r->no_of_days,
              $r->book_room_count,
              agent_currency()." ".currency_type(agent_currency(),$final_total),
              $status,
              $view,
            );
          }  else if ($r->booking_flag==5) {
              $data[] = array(
              '',
              $r->booking_id,
              date('d/m/Y',strtotime($r->Created_Date)),
              strlen($r->hotel_name)> 15 ? substr($r->hotel_name,0,15)."..." : $r->hotel_name,
              strlen($r->Room_Type)> 15 ? substr($r->Room_Type,0,15)."..." : $r->Room_Type,
              $invoice,
              $voucher,
              date('d/m/Y' ,strtotime($r->check_in)),
              date('d/m/Y' ,strtotime($r->check_out)),
              $r->no_of_days,
              $r->book_room_count,
              agent_currency()." ".currency_type(agent_currency(),$final_total),
              $status,
              $view,
            );
          } 
        }
        $output = array(
         "draw"            => $draw,
         "recordsTotal"    => $booking_list->num_rows()+$xmlbooking_list->num_rows(),
         "recordsFiltered" => $booking_list->num_rows()+$xmlbooking_list->num_rows(),
         "data" => $data
        );
        echo json_encode($output);
        exit();
     }
     public function agent_booking_view() {
      $off = $this->Payment_Model->notification_off($_REQUEST['id']);
      // $data['total_markup'] = $_REQUEST['mark_up'];
      $data['view'] = $this->Payment_Model->agent_booking_detail($_REQUEST['id']);
      $data['board'] = $this->Payment_Model->board_booking_detail($_REQUEST['id']);
      $data['general'] = $this->Payment_Model->general_booking_detail($_REQUEST['id']);
      $data['cancelation'] =  $this->Payment_Model->get_cancellation_terms($_REQUEST['id']);

      $data['ExBed']  =  $this->Payment_Model->getExtrabedDetails($_REQUEST['id']);

      $this->load->view('frontend/booking/agent_booking_view',$data);
     }
     public function agent_booking_cancel() {
      $id     =$_REQUEST['id'];
      $cancel = $this->Payment_Model->agent_booking_cancel($_REQUEST['id']);
      echo  json_encode(true);
     }
     public function agent_booking_profit() {
      $this->load->view('frontend/booking/agent_booking_profit');
     }
     public function agent_booking_profit_list() {
      $data = array();
      // Datatables Variables
      $draw = intval($this->input->get("draw"));
      $start = intval($this->input->get("start"));
      $length = intval($this->input->get("length"));
      $booking_list = $this->Payment_Model->agent_booking_profit_list();
        foreach($booking_list->result() as $key => $r) {
          $board_data = array();
          $general_data = array();
          $ExBed =array();
          $board_data   = $this->Payment_Model->board_booking_detail($r->id);
          $general_data = $this->Payment_Model->general_booking_detail($r->id);
          $ExBed        = $this->Payment_Model->getExtrabedDetails($r->id);
          $net_adult_amount = $net_child_amount = $net_general_adult = $net_general_child = $general = $board = $final_total =$ExAmount= 0;
          if(count($board_data)!=0 && count($board_data)!="") 
          {
            foreach ($board_data as $key1 => $value1) 
            {
              $board_adult_amount = $board_child_amount = 0;
              $board_adult_amount = $board_data[$key1]->adultamount * $board_data[$key1]->Breqadults;
              $board_child_amount = $board_data[$key1]->childAmount * $board_data[$key1]->BreqchildCount;
              $net_adult_amount += $board_adult_amount;
              $net_child_amount += $board_child_amount;
              $board = $net_adult_amount + $net_child_amount;
            }
          }
          if(count($general_data)!=0 && count($general_data)!="") 
          {
            foreach ($general_data as $key2 => $value2) 
            {
              $general_adult_amount = $general_child_amount = 0;
              $general_adult_amount = $general_data[$key2]->gadultamount * $general_data[$key2]->reqadults;
              $general_child_amount = $general_data[$key2]->gchildamount * $general_data[$key2]->reqChild;
              $net_general_adult += $general_adult_amount;
              $net_general_child += $general_child_amount;
              $general = $net_general_adult + $net_general_child;
            }
          }
          $amount =0;
          if(count($ExBed)!=0 && count($ExBed)!="") 
          { 
            foreach ($ExBed as $key3 => $value3) {
              $amount=$ExBed[$key3]->amount;
             
            }
            $ExAmount=($amount*($r->agent_markup))/100+$amount;

          }
          $supplement_total=$board +$general+$amount;
          $final_total = ceil($r->total_amount + $supplement_total);

          $array_sum[$key] = array_sum(explode(",", $r->individual_amount));
          if ($r->booking_flag==2) {
            $status= "<span class='text-primary'>pending</span>";
          } else if ($r->booking_flag==1) {
            $status= "<span class='text-success'>Accepted</span>";
          } else if ($r->booking_flag==0) {
            $status= "<span class='text-danger'>Rejected</span>";
          } else if ($r->booking_flag==3) {
            $status= "<span class='text-danger'>Cancelled</span>";
          }
            $data[] = array(
            $key+1,
            $r->booking_id,
            date('d/m/Y',strtotime($r->Created_Date)),
            strlen($r->Room_Type)> 15 ? substr($r->Room_Type,0,15)."..." : $r->Room_Type,
            date('d/m/Y',strtotime($r->check_in)),
            date('d/m/Y',strtotime($r->check_out)),
            $r->no_of_days,
            $r->book_room_count,
            $r->agent_markup."%",
            agent_currency()." ".currency_type(agent_currency(), (($final_total)*$r->agent_markup)/100),
            $r->Created_Date,
            '<a title="view" class="btn btn-sm btn-success" href="'.base_url().'Payment/agent_booking_profit_view?id='.$r->bk_id.'"><i class="fa fa-eye" aria-hidden="true"></i></a>',
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
     public function invoice_pdf() {
      $data = $this->Payment_Model->agent_booking_detail($_REQUEST['id']);
     

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
      $agent_name=$data[0]->First_Name." ".$data[0]->Last_Name;
      $agent_number=$data[0]->Mobile;
      $agent_email=$data[0]->Email;

      //HOTEL DETAILS
      $invoice_company_name=$data[0]->hotel_name;
      $invoice_company_address=$data[0]->location." ".$data[0]->city;
      $invoice_company_city=$data[0]->city;

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
            <td><img width="100" src="http://otelseasy.com/skin/images/dash/logo.png" /></td>
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
      $invoice_data_date= date("d-m-Y",strtotime($data[0]->invoice_date));
      $invoice_number = $data[0]->invoice_id;
      if ($invoice_number=="") {
        $invoice_number = "TEMPINVOICE".$_REQUEST['id'];
      }
      $reference_id = $data[0]->reference_id;
      $confirmationNumber = $data[0]->confirmationNumber;
      $confirmationName = $data[0]->confirmationName;
      $customer_name=$data[0]->bk_contact_fname." ".$data[0]->bk_contact_lname;
      $customer_email=$data[0]->bk_contact_email;
      $customer_phone=$data[0]->bk_contact_number;
      $booking_id=$data[0]->bk_id;
      
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
            <td style="text-align:right;">Booking reference number : '.$booking_id.'</td>
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
    $room=$data[0]->room_name." ".$data[0]->Room_Type;
    $days=$data[0]->no_of_days;
    $no_of_rooms=$data[0]->book_room_count;
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

//ADULT & CHILD DETAILS 
   $child_no=$data[0]->childs_count;
   $adult_no=$data[0]->adults_count;

    $tb4='
    <style type="text/css">
    .tb4h {font-size:10px; background-color:ghostwhite; padding-top:5px;padding-bottom:5px}
    </style>

    <table class="tb4h">
      <tr>
        <td>Adult(s) : '.$adult_no.'</td>
        <td>Child(s) : '.$child_no.'</td>
      </tr>
    </table>

    ';

 // $pdf->writeHTML($tb4,true,false,false,false,'');


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
        $total_markup = $data[0]->agent_markup+$data[0]->admin_markup+$data[0]->search_markup;
        $book_room_count = $data[0]->book_room_count;
        $individual_amount = explode(",", $data[0]->individual_amount);
        $individual_discount = explode(",", $data[0]->individual_discount);
        $checkin_date=date_create($data[0]->check_in);
        $checkout_date=date_create($data[0]->check_out);
        $no_of_days=date_diff($checkin_date,$checkout_date);
        $tot_days = $no_of_days->format("%a");


       $board = $this->Payment_Model->board_booking_detail($_REQUEST['id']);
       $general = $this->Payment_Model->general_booking_detail($_REQUEST['id']);
       $cancelation =  $this->Payment_Model->get_cancellation_terms($_REQUEST['id']);

       $ExBed =  $this->Payment_Model->getExtrabedDetails($_REQUEST['id']);
       $Fdays = 0;
       $discountType = "";
        if ($data[0]->discountType=="stay&pay") {
          $Cdays = $tot_days/$data[0]->discountStay;
          $parts = explode('.', $Cdays);
          $Cdays = $parts[0];
          $Sdays = $data[0]->discountStay*$Cdays;
          $Pdays = $data[0]->discountPay*$Cdays;
          $Tdays = $tot_days-$Sdays;
          $Fdays = $Pdays+$Tdays;
          $discountType = 'Stay/Pay';
        }
        if ($data[0]->discountType=="" && $data[0]->discountCode!="") {
          $discountType = 'Discount';
        }
        for ($i=1; $i <= $book_room_count; $i++) {
                 $tb51.='
                  <h4 class="room-name">Room '.$i.'</h4>
                  <table style="border-collapse: collapse;border:1px solid #dddddd" class="tg">
                  <thead>
                    <tr style="background-color: #0074b9;">
                      <td style="color: white">Date</td>
                      <td style="color: white">Room type</td>
                      <td style="color: white">Board</td>
                      <td style="color: white">Rate</td>
                    </tr>
                  </thead>
                  <tbody>';
                  for ($j=0; $j < $tot_days ; $j++) {
                    $ExAmount[$j] = 0;
                    $TExAmount[$j] = 0;
                    $GAamount[$j] = 0;
                    $GCamount[$j] = 0;
                    $BAamount[$j] = 0;
                    $BCamount[$j] = 0;
                    $TBAamount[$j] = 0;
                    $TBCamount[$j] = 0;
                    // Room only Rate start
                    $roomAmount[$j] = (($individual_amount[$j]*$total_markup)/100)+$individual_amount[$j];
                    if (!isset($individual_discount[$j])) {
                      $individual_discount[$j] = 0;
                    }
                   
                    $roomDisAmount[$j] = $roomAmount[$j] - (($roomAmount[$j]*$individual_discount[$j])/100);
                    $tb51 .='<tr>
                              <td>'.date('d/m/Y', strtotime($data[0]->check_in. ' + '.$j.'  days')).'</td>
                              <td>'.$data[0]->room_name." ".$data[0]->Room_Type.'</td>
                              <td>'.$data[0]->boardName.'</td>
                              <td style="text-align: right">
                              '.number_format(currency_type(agent_currency(),$roomDisAmount[$j]),2).' '.agent_currency().'</td>
                            </tr>';
                    // Room only Rate end
                    // Extrabed list start
                      if (count($ExBed)!=0) {
                        foreach ($ExBed as $Exkey => $Exvalue) {
                          if ($Exvalue->date==date('Y-m-d', strtotime($data[0]->check_in. ' + '.$j.'  days'))) {
                            $exroomExplode = explode(",", $Exvalue->rooms);
                            $examountExplode = explode(",", $Exvalue->Exrwamount);
                            $exTypeExplode = explode(",", $Exvalue->Type);
                            foreach ($exroomExplode as $Exrkey => $EXRvalue) {
                              if ($EXRvalue==$i) { 

                                $ExAmount[$j] = (($examountExplode[$Exrkey]*$total_markup)/100)+$examountExplode[$Exrkey];

                                $TExAmount[$j] +=(($examountExplode[$Exrkey]*$total_markup)/100)+$examountExplode[$Exrkey];
                        $tb51 .= '<tr>
                                  <td></td>
                                  <td>'.$exTypeExplode[$Exrkey].'</td>
                                  <td>-</td>
                                  <td style="text-align:right">'.number_format(currency_type(agent_currency(),$ExAmount[$j]),2).' '.agent_currency().'</td>
                                  </tr>';

                      } } } } }
                    // Extrabed list end 
                    // Adult and room General supplement list start

                      if (count($general)!=0) {
                        foreach ($general as $gskey => $gsvalue) {
                          if ($gsvalue->gstayDate==date('d/m/Y', strtotime($data[0]->check_in. ' + '.$j.'  days'))) {
                            $gsadultExplode = explode(",", $gsvalue->Rwadult);
                            $gsadultAmountExplode = explode(",", $gsvalue->Rwadultamount);
                            foreach ($gsadultExplode as $gsakey => $gsavalue) {
                              if ($gsavalue==$i) {
                                $GAamount[$j] = (($gsadultAmountExplode[$gsakey]*$total_markup)/100)+$gsadultAmountExplode[$gsakey];

                                  $tb51 .= '<tr>
                                        <td></td>
                                        <td>'.$gsvalue->application=="Per Room" ? $gsvalue->generalType : 'Adults '.$gsvalue->generalType.'</td>
                                        <td>-</td>
                                        <td style="text-align:right">'.number_format(currency_type(agent_currency(),$GAamount[$j]),2).' '.agent_currency().'</td>
                                        </tr>';
                                } 
                              }

                          $gschildExplode = explode(",", $gsvalue->Rwchild);
                          $gschildAmountExplode = explode(",", $gsvalue->RwchildAmount);
                           foreach ($gschildExplode as $gsckey => $gscvalue) {
                                if ($gscvalue==$i) {
                                  $GCamount[$j] = (($gschildAmountExplode[$gsckey]*$total_markup)/100)+$gschildAmountExplode[$gsckey];

                                  $tb51 .= '<tr>
                                    <td></td>
                                    <td>Child '.$gsvalue->generalType.'</td>
                                    <td>-</td>
                                    <td style="text-align:right">'.number_format(currency_type(agent_currency(),$GCamount[$j]),2).' '.agent_currency().'</td>
                                    </tr>';
                                }  
                            }

                      } } }

                    // Adult and room General supplement list end
                    // Adults Board supplement list start

                      foreach ($board as $bkey => $bvalue) { 
                        if ($bvalue->stayDate==date('d/m/Y', strtotime($data[0]->check_in. ' + '.$j.'  days'))) {
                          $ABRwadultexplode = explode(",", $bvalue->Rwadult);
                          $ABRwadultamountexplode = explode(",", $bvalue->RwadultAmount);
                          foreach ($ABRwadultexplode as $ABRwkey => $ABRwvalue) {
                            if ($ABRwvalue==$i) {
                              $BAamount[$j] = (($ABRwadultamountexplode[$ABRwkey]*$total_markup)/100)+$ABRwadultamountexplode[$ABRwkey];;
                              $TBAamount[$j] += $BAamount[$j];

                              $tb51 .= '<tr>
                                    <td></td>
                                    <td>Child '.$bvalue->board.'</td>
                                    <td>-</td>
                                    <td style="text-align:right">'.number_format(currency_type(agent_currency(),$BAamount[$j]),2).' '.agent_currency().'</td>
                                    </tr>';

                            } }
                    // Adults Board supplement list end
                    // Child Board supplement list start
                          $CBRwchildexplode = explode(",", $bvalue->Rwchild);
                          $CBRwchildamountexplode = explode(",", $bvalue->RwchildAmount);
                          foreach ($CBRwchildexplode as $CBRwkey => $CBRwvalue) {
                            if ($CBRwvalue==$i) {
                              $BCamount[$j] = (($CBRwchildamountexplode[$CBRwkey]*$total_markup)/100)+$CBRwchildamountexplode[$CBRwkey];

                              $TBCamount[$j] += $BCamount[$j];

                              $tb51 .= '<tr>
                                    <td></td>
                                    <td>Child '.$bvalue->board.'</td>
                                    <td>-</td>
                                    <td style="text-align:right">'.number_format(currency_type(agent_currency(),$BCamount[$j]),2).' '.agent_currency().'</td>
                                    </tr>';

                            } }
                    } }
                    // Child Board supplement list end

                  }

                  $total[$i] = array_sum($roomDisAmount)+array_sum($TExAmount)+array_sum($GAamount)+array_sum($GCamount)+array_sum($TBAamount)+array_sum($TBCamount);

                  $total1[$i] = array_sum($roomAmount)+array_sum($TExAmount)+array_sum($GAamount)+array_sum($GCamount)+array_sum($TBAamount)+array_sum($TBCamount);
                  $totRmAmt[$i] = array_sum(array_splice($roomDisAmount, 1,$Fdays))+array_sum($TExAmount)+array_sum($GAamount)+array_sum($GCamount)+array_sum($TBAamount)+array_sum($TBCamount);
          $tb51 .='</tbody>
                    <tfoot>
                      <tr>
                        <td colspan="3" style="text-align: right"><strong style="color:#0074b9">Total</strong></td>
                        <td style="text-align:right"><strong style="color:#0074b9">'.currency_type(agent_currency(),$total[$i]).' '.agent_currency().'</strong></td>
                      </tr>
                    </tfoot>
                </table>';
        }
      $pdf->writeHTML($tb51,true,false,false,false,'');
      
      $array_sumTotal = (array_sum($totRmAmt)*$data[0]->tax)/100+array_sum($totRmAmt);
      $array_wiDissumTotal = ceil((array_sum($total1)*$data[0]->tax)/100+array_sum($total1));
      $final_total = $array_sumTotal;
      $tb52 ='<table style="border-collapse: collapse">
                <tr>
                  <td colspan="3"></td>
                  <td>Tax :</td>
                  <td style="text-align:right">'.$data[0]->tax.'%</td>
                </tr>';
                if (array_sum($individual_discount)!=0) {
                  $tb52 .= '<tr>
                        td colspan="3"></td>
                        <td></td>
                        <td>
                          <small style="color:red;text-decoration: line-through;">small style="color:red;text-decoration: line-through;">'.currency_type(agent_currency(),$array_wiDissumTotal).' '.agent_currency().'</small> '.$discountType.'</small>
                        </td>
                      </tr>';
                }
                if ($data[0]->discountType=="stay&pay") {
                  $tb52 .= '<tr>
                  <td colspan="3"></td>
                  <td></td>
                  <td style="text-align:right"><small style="color:red;text-decoration: line-through;">'.currency_type(agent_currency(),array_sum($total)) .' '.agent_currency().'</small> '.$discountType.'</td>
                </tr>';
                }
                $tb52 .= '<tr>
                  <td colspan="3"></td>
                  <td>GRAND TOTAL :</td>
                  <td style="text-align:right">'.currency_type(agent_currency(),ceil($final_total)).' '.agent_currency().'</td>
                </tr>
            </table>';
      $pdf->writeHTML($tb52,true,false,false,false,'');
//AMOUNT DETAILS END


   $remarks=$data[0]->Important_Remarks_Policies;
  $conditions=$data[0]->Important_Notes_Conditions;
  $cancelation = $this->Payment_Model->get_cancellation_terms($_REQUEST['id']); 

       $tb72='
    <table style="border-collapse: collapse">
        <tbody>
          <tr>
            <td style="font-size:10px;text-indent:20px"><div style="font-weight:bold">Important Remarks & Policies : </div>'.$remarks.' </td>
          </tr></tbody>
      </table><br>';
      $pdf->writeHTML($tb72,true,false,false,false,'');
    if(count($cancelation)!=0) {

        $tb7 =' <table style="border-collapse: collapse">
                <tbody>
                  <tr>
                    <td style="font-size:10px;text-indent:20px"><div style="font-weight:bold">Cancellation policy:</div></td>
                  </tr></tbody>
                </table>
                <br>
                <br>
                <style type="text/css">
                  .tg  {border-spacing:0;border:1px solid #dddddd; border-collapse: collapse;text-align:center;}
                  .tg td{font-size:11px;border-style:solid #dddddd;border-width:1px;word-break:normal;color:#333;  border-collapse: separate;}
                  .tg tr td{font-size:11px;border-style:solid #dddddd;border-width:1px;word-break:normal;color:#333;  border-collapse: separate;}
                  
                  </style>
                <table style="border-collapse: collapse;border:1px solid #dddddd" class="tg">
                  <thead>
                    <tr style="background-color: #0074b9;">
                      <td style="color: white">Cancelled on or After</td>
                      <td style="color: white">Cancelled on or Before</td>
                      <td style="color: white">Cancellation Charge</td>
                    </tr>
                  </thead>
                  <tbody>';
                 foreach ($cancelation as $Canckey => $Cancvalue) { 
                    if ($Cancvalue->application=="NON REFUNDABLE") {
                      $tb7 .='<tr>
                        <td>'.date('d/m/Y',strtotime($data[0]->Created_Date)).'</td>
                        <td>'.date('d/m/Y',strtotime($data[0]->check_in)).'</td>
                        <td>'.$Cancvalue->cancellationPercentage.'% '.$Cancvalue->application.'</td>
                      </tr>';
                    } else {
                      if(date('Y-m-d' , strtotime('-'.($Cancvalue->daysFrom).' days', strtotime($data[0]->check_in))) < date('Y-m-d')) {
                        $afterDate =  date('d/m/Y');
                      } else {
                        $afterDate =  date('d/m/Y' , strtotime('-'.($Cancvalue->daysFrom).' days', strtotime($data[0]->check_in)));
                      }

                      $tb7 .='<tr>
                        <td>'.$afterDate.'</td>
                        <td>'.date('d/m/Y' , strtotime('-'.$Cancvalue->daysTo.' days', strtotime($data[0]->check_in))).'</td>
                        <td>'.$Cancvalue->cancellationPercentage.'% '.$Cancvalue->application.'</td>
                      </tr>';
                    }
                  }
                  $tb7 .='</tbody>
                </table>';
      $pdf->writeHTML($tb7,true,false,false,false,'');

    }
    
    $tb8 ='<table style="border-collapse: collapse">
        <tbody><tr>
            <td style="font-size:10px;text-indent:20px"><div style="font-weight:bold">Important Notes & Conditions: </div>'.$conditions.'</td>   
          </tr></tbody>
      </table>';

      $pdf->writeHTML($tb8,true,false,false,false,'');



    $bankDetails = $this->Payment_Model->bankDetails();
    $tb8 ='<table style="border-collapse: collapse">
        <tbody><tr>
            <td style="font-size:10px;text-indent:20px"><div style="font-weight:bold">Important notes & conditions: </div>'.$conditions.'</td>   
          </tr></tbody>
      </table>';

      // $pdf->writeHTML($tb8,true,false,false,false,'');

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


        $type = 'D';
        ob_clean();
        $pdf->Output($invoice_number.'.pdf', $type);
    }
    public function invoice_pdf1(){
      $data['view'] = $this->Payment_Model->agent_booking_detail($_REQUEST['id']);
      $this->load->view('frontend/booking/invoice_pdf',$data);
      // $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
      // $pdf->SetTitle('My Title');
      // $pdf->SetHeaderMargin(30);
      // $pdf->SetTopMargin(20);
      // $pdf->setFooterMargin(20);
      // $pdf->SetAutoPageBreak(true);
      // $pdf->SetAuthor('Author');
      // $pdf->SetDisplayMode('real', 'default');

    }
    public function agent_booking_profit_view() {
      $data['view'] = $this->Payment_Model->agent_booking_detail($_REQUEST['id']);
      $data['board'] = $this->Payment_Model->board_booking_detail($_REQUEST['id']);
      $data['general'] = $this->Payment_Model->general_booking_detail($_REQUEST['id']);
      $data['cancelation'] =  $this->Payment_Model->get_cancellation_terms($_REQUEST['id']);
      $data['ExBed']  =  $this->Payment_Model->getExtrabedDetails($_REQUEST['id']);
      $this->load->view('frontend/booking/agent_booking_profit_view',$data);
     }
    public function agent_invoice() {

      $this->load->view('frontend/booking/agent_invoice');
     }
    public function agent_invoice_list() {
      $data = array();
      // Datatables Variables
      $draw = intval($this->input->get("draw"));
      $start = intval($this->input->get("start"));
      $length = intval($this->input->get("length"));
      $booking_list = $this->Payment_Model->agent_invoice_list();
        foreach($booking_list->result() as $key => $r) {
          $board_data = array();
          $general_data = array();
          $ExBed = array();
          $board_data = $this->Payment_Model->board_booking_detail($r->id);
          $general_data = $this->Payment_Model->general_booking_detail($r->id);
          $ExBed =$this->Payment_Model->getExtrabedDetails($r->id);
          $net_adult_amount = $net_child_amount = $net_general_adult = $net_general_child = $general = $board = $ExAmount = $final_total = 0;
          if(count($board_data)!=0 && count($board_data)!="") 
          {
            foreach ($board_data as $key1 => $value1) 
            {
              $Chamntarray_explode= explode(",", $value1->childAmount);
              $Charray_sum = array_sum($Chamntarray_explode);
              $board_adult_amount = $board_child_amount = 0;
              $total_board_adult = $board_data[$key1]->adultamount * $board_data[$key1]->Breqadults;
              $total_board_child = $Charray_sum * $board_data[$key1]->BreqchildCount;
              $board_adult_amount = $total_board_adult+(($total_board_adult * $board_data[$key1]->total_markup)/100);
              $board_child_amount = $total_board_child+(($total_board_child * $board_data[$key1]->total_markup)/100);
              $net_adult_amount += $board_adult_amount;
              $net_child_amount += $board_child_amount;
              $board = $net_adult_amount + $net_child_amount;
            }
          }
          if(count($general_data)!=0 && count($general_data)!="") 
          {
            foreach ($general_data as $key2 => $value2) 
            {
              $general_adult_amount = $general_child_amount = 0;
              $total_general_adult = $general_data[$key2]->gadultamount * $general_data[$key2]->reqadults;
              $total_general_child = $general_data[$key2]->gchildamount * $general_data[$key2]->reqChild;
              $general_adult_amount = $total_general_adult + (($total_general_adult * $general_data[$key2]->total_markup)/100);
              $general_child_amount = $total_general_child + (($total_general_child * $general_data[$key2]->total_markup)/100);
              $net_general_adult += $general_adult_amount;
              $net_general_child += $general_child_amount;
              $general = $net_general_adult + $net_general_child;
            }
          }
          $amount =0;
          if(count($ExBed)!=0 && count($ExBed)!="") 
          { 
            foreach ($ExBed as $key3 => $value3) {
              $amount=$ExBed[$key3]->amount;
             
            }
            $ExAmount=($amount*($r->admin_markup+$r->agent_markup))/100+$amount;

          }
          $supplement_total=$board +$general;
          $final_total = ceil($r->total_amount + $supplement_total+$ExAmount);
          if ($r->booking_flag==2) {
            $status= "<span class='text-primary'>pending</span>";
          } else if ($r->booking_flag==6) {
            $status= "<span class='text-primary'>pending</span>";
          } else if ($r->booking_flag==1) {
            $status= "<span class='text-success'>Accepted</span>";
          } else if ($r->booking_flag==0) {
            $status= "<span class='text-danger'>Rejected</span>";
          } else if ($r->booking_flag==3) {
            $status= "<span class='text-danger'>Cancelled</span>";
          }
          if (isset($r->invoice_id) && $r->invoice_id!="") {
            $invoice = '<a class="text-primary" href="'.base_url().'Payment/invoice_pdf?id='.$r->bk_id.'">'.$r->invoice_id.'</a>';
          } else {
            $invoice = '';
          }
          if (isset($r->reference_id) && $r->reference_id!="") {
            $voucher = '<a class="text-primary" href="'.base_url().'Payment/voucher_pdf?id='.$r->bk_id.'">'.$r->reference_id.'</a>';
          } else {
            $voucher = '';
          }
            $data[] = array(
            $key+1,
            $r->book_id,
            date('d/m/Y',strtotime($r->Created_Date)),
            strlen($r->hotel_name)> 15 ? substr($r->hotel_name,0,15)."..." : $r->hotel_name,
            strlen($r->Room_Type)> 15 ? substr($r->Room_Type,0,15)."..." : $r->Room_Type,
            $invoice,
            $voucher,
            date('d/m/Y',strtotime($r->check_in)),
            date('d/m/Y',strtotime($r->check_out)),
            $r->no_of_days,
            $r->book_room_count,
            agent_currency()." ".currency_type(agent_currency(),$final_total),
            $status,
            '<a title="view" class="btn btn-sm btn-success" href="'.base_url().'Payment/agent_invoice_view?id='.$r->bk_id.'"><i class="fa fa-eye" aria-hidden="true"></i></a>',
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
    public function agent_invoice_view() {
      $data['view'] = $this->Payment_Model->agent_booking_detail($_REQUEST['id']);
      $data['board'] = $this->Payment_Model->board_booking_detail($_REQUEST['id']);
      $data['general'] = $this->Payment_Model->general_booking_detail($_REQUEST['id']);
      $data['cancelation'] =  $this->Payment_Model->get_cancellation_terms($_REQUEST['id']);
      $data['ExBed']  =  $this->Payment_Model->getExtrabedDetails($_REQUEST['id']);
      $this->load->view('frontend/booking/agent_invoice_view',$data);
     }
    public function all_notification() {
      $this->load->view('frontend/notification');
     }
    public function clear_all_notification() {
      $data['view'] = $this->Payment_Model->clear_all_notifications($_REQUEST['id']);
      redirect('../hotels');
     }
    public function voucher_pdf() {
      $data = $this->Payment_Model->agent_booking_detail($_REQUEST['id']);
      require_once APPPATH . 'third_party/tcpdf/tcpdf.php';
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
      $agent_name=$data[0]->First_Name." ".$data[0]->Last_Name;
      $agent_number=$data[0]->Mobile;
      $agent_email=$data[0]->Email;
      $agent_address=$data[0]->Address;

      //HOTEL DETAILS
      $invoice_company_name=$data[0]->hotel_name;
      $invoice_company_address=$data[0]->location." ".$data[0]->city;
      $invoice_company_city=$data[0]->city;


      $a_folder = $data[0]->agent_id;
      $a_logo = $data[0]->logo;

      if (file_exists(base_url().'uploads/agent_logo/'.$a_folder.'/'.$a_logo)) {
        $a_logo = '<td width="10%"><img width="50" style="float:right"  src="'.base_url().'uploads/agent_logo/'.$a_folder.'/'.$a_logo.'" /></td>';
      } else {
        $a_logo = '';
      }
      $tbl_header = '<table border="0"  cellspacing="2" nobr="true" style="border-bottom:1px solid #999">';
      $tbl_footer = '</table>';
      $tbl = '';
      $tbl1 = '';
      if ($a_logo!="") {
        $tbl1 .= 
        ' <tr >
            <td width="30%"><img width="100" src="http://otelseasy.com/skin/images/dash/logo.png" /></td> 
             <td width="60%" style="text-align:right;"><span  style="float:left" >'.$agent_name.'<br>'.$agent_number.'<br>'.$agent_email.'</span>
            </td>
            '.$a_logo.'
          </tr>
        ';
      } else {
        $tbl1 .= 
        '
          <tr >
            <td width="30%"><img width="100" src="http://otelseasy.com/skin/images/dash/logo.png" /></td> 
             <td width="70%" style="text-align:right;"><span  style="float:left" >'.$agent_name.'<br>'.$agent_number.'<br>'.$agent_email.'</span>
            </td>
          </tr>
        ';
      }
       $tbl .= 
        '
          <tr>
            <td width="30%"><img width="100" src="http://otelseasy.com/skin/images/dash/logo.png" /></td> 
            <td width="70%" style="text-align:right;">
              <div  style="font-size:14px ;font-weight:bold;color:#337ab7;">VOUCHER</div>
              <span style="font-size:8px;"># VOUCHER_0'.$_REQUEST['id'].'</span>
          </td>

          </tr>';

  $pdf->writeHTML($tbl_header.$tbl1.$tbl_footer, true, false, false, false, '');

      // $html='
      //       <div  style="font-size:14px ;font-weight:bold;color:#337ab7;">VOUCHER</div>
      //       <div  style="font-size:12px ">Issued to : </div>
      //       ';
      // $pdf->writeHTML($html, false, false, false, false, '');

//INVOICE DETAILS
  $invoice_data_date= date("d-m-Y",strtotime($data[0]->invoice_date));
  $invoice_number = $data[0]->invoice_id;
  $reference_id = $data[0]->reference_id;
  $customer_name=$data[0]->bk_contact_fname." ".$data[0]->bk_contact_lname;
  $customer_email=$data[0]->bk_contact_email;
  $customer_phone=$data[0]->bk_contact_number;
  $booking_id=$data[0]->bk_id;
  $tb2 ='
  <div style="width:50%;display:block;">

  <table class="table2">
    <tbody>
      <tr>
        <td style=""></td>
        <td style="text-align:right;font-weight:bolder;">Issued To</td>
      </tr>
      <tr>
        <td style="font-size:10px;"></td>
        <td style="text-align:right;font-size:10px;">'.$data[0]->bk_contact_fname.' '.$data[0]->bk_contact_lname.'</td>
      </tr>
      <tr>
        <td style="font-size:10px;">Booking reference number :'.$data[0]->booking_id.'</td>
        <td style="text-align:right;font-size:10px;">'.$customer_email.'</td>
      </tr>
      <tr>
        <td style="font-size:10px;">Hotel name : '.$data[0]->hotel_name.'</td>
        <td style="text-align:right;font-size:10px;">'.$customer_phone.'</td>
      </tr>
    </tbody>
  </table>
  </div>
  ';

$pdf->writeHTML($tb2, true, false, false, false, '');
  

// CHECKOUT DETAILS
    $room=$data[0]->room_name." ".$data[0]->Room_Type;
    $days=$data[0]->no_of_days;
    $no_of_rooms=$data[0]->book_room_count;
    $check_in=date('d-m-Y',strtotime($data[0]->check_in));
    $check_out=date('d-m-Y',strtotime($data[0]->check_out));
    $Rwadult = explode(",", $data[0]->Rwadults); 
    $Rwchild = explode(",", $data[0]->Rwchild); 
    $tb3='
    <style type="text/css">
    .tg  {border-spacing:0; border-collapse: collapse;text-align:center;border:1px solid black}
    .tg td{font-size:10px;padding-top:2px 20px;word-break:normal;color:#333;background-color:ghostwhite; padding-bottom: 20px; border-collapse: separate;}
    .tg th{font-size:11px;overflow:hidden;color:#333;color:black;text-align:left}
    .rgt_bor {border: 1px solid black;}
    .tg tr{width: 100%;height:20px;}
    .tgh {height:20px; line-height:18px;}
    </style>
    <table class="tg">
      <tr>
        <th class="tgh rgt_bor" style="border:none">Guest details </th>
        <th class="tgh rgt_bor" style="border:none" colspan="2"></th>
      </tr>';
      foreach ($Rwadult as $rwkey => $rwvalue) {
        $roomFName= 'Room'.($rwkey+1).'-FName';
        $roomLName= 'Room'.($rwkey+1).'-LName';
        if ($rwkey==0) {
          $tb3.= '
          <tr>
            <td class="tgh rgt_bor" rowspan="2">Room '.($rwkey+1).'</td>
            <td class="tgh rgt_bor">First Name : '.$data[0]->$roomFName.'</td>
            <td class="tgh rgt_bor">Last Name : '.$data[0]->$roomLName.'</td>
          </tr>
          <tr>
            <td class="tgh rgt_bor">No of adults : '.$rwvalue.'</td>
            <td class="tgh rgt_bor">No of Children : '.$Rwchild[$rwkey].'</td>
          </tr>';
        } else {
          $tb3.= '
          <tr>
            <td class="tgh rgt_bor" rowspan="2">Room '.($rwkey+1).'</td>
            <td class="tgh rgt_bor">First Name : '.$data[0]->$roomFName.'</td>
            <td class="tgh rgt_bor">Last Name : '.$data[0]->$roomLName.'</td>
          </tr>
          <tr>
            <td class="tgh rgt_bor">No of adults : '.$rwvalue.'</td>
            <td class="tgh rgt_bor">No of Children : '.$Rwchild[$rwkey].'</td>
          </tr>';
        }
       
      }

    $tb3.='</table>
    ';

    $pdf->writeHTML($tb3, true, false, false, false, '');


//AMOUNT DETAILS
 $tb51='<style type="text/css">
                  .tg  {border-spacing:0;border:1px solid #dddddd; border-collapse: collapse;text-align:center;}

                  .tg tr td{font-size:11px;word-break:normal;color:#333;border:1px solid #dddddd; }
                  
                  
                  </style>';
   $total_markup = $data[0]->agent_markup+$data[0]->admin_markup+$data[0]->search_markup;
        $book_room_count = $data[0]->book_room_count;
        $individual_amount = explode(",", $data[0]->individual_amount);
        $individual_discount = explode(",", $data[0]->individual_discount);
          $checkin_date=date_create($data[0]->check_in);
          $checkout_date=date_create($data[0]->check_out);
        $no_of_days=date_diff($checkin_date,$checkout_date);
        $tot_days = $no_of_days->format("%a");


       $board = $this->Payment_Model->board_booking_detail($_REQUEST['id']);
       $general = $this->Payment_Model->general_booking_detail($_REQUEST['id']);
       $cancelation =  $this->Payment_Model->get_cancellation_terms($_REQUEST['id']);

       $ExBed =  $this->Payment_Model->getExtrabedDetails($_REQUEST['id']);

        for ($i=1; $i <= $book_room_count; $i++) {
                 $tb51.='
                  <h4 class="room-name">Room '.$i.'</h4>
                  <table style="border-collapse: collapse;border:1px solid #dddddd" class="tg">
                  <thead>
                    <tr style="background-color: #0074b9;">
                      <td style="color: white">Date</td>
                      <td style="color: white">Room type</td>
                      <td style="color: white">Board</td>
                    </tr>
                  </thead>
                  <tbody>';
                  for ($j=0; $j < $tot_days ; $j++) {
                    $ExAmount[$j] = 0;
                    $TExAmount[$j] = 0;
                    $GAamount[$j] = 0;
                    $GCamount[$j] = 0;
                    $BAamount[$j] = 0;
                    $BCamount[$j] = 0;
                    $TBAamount[$j] = 0;
                    $TBCamount[$j] = 0;
                    if (!isset($individual_discount[$j])) {
                      $individual_discount[$j] = 0;
                    }
                    // Room only Rate start
                    $roomAmount[$j] = (($individual_amount[$j]*$total_markup)/100)+$individual_amount[$j];
                    $DisroomAmount[$j] = $roomAmount[$j]-($roomAmount[$j]*$individual_discount[$j])/100;
                    $tb51 .='<tr>
                              <td>'.date('d/m/Y', strtotime($data[0]->check_in. ' + '.$j.'  days')).'</td>
                              <td>'.$data[0]->room_name." ".$data[0]->Room_Type.'</td>
                              <td>'.$data[0]->boardName.'</td>
                            </tr>';
                    // Room only Rate end
                    // Extrabed list start
                      if (count($ExBed)!=0) {
                        foreach ($ExBed as $Exkey => $Exvalue) {
                          if ($Exvalue->date==date('Y-m-d', strtotime($data[0]->check_in. ' + '.$j.'  days'))) {
                            $exroomExplode = explode(",", $Exvalue->rooms);
                            $examountExplode = explode(",", $Exvalue->Exrwamount);
                            $exTypeExplode = explode(",", $Exvalue->Type);
                            foreach ($exroomExplode as $Exrkey => $EXRvalue) {
                              if ($EXRvalue==$i) { 

                                $ExAmount[$j] = (($examountExplode[$Exrkey]*$total_markup)/100)+$examountExplode[$Exrkey];

                                $TExAmount[$j] +=(($examountExplode[$Exrkey]*$total_markup)/100)+$examountExplode[$Exrkey];
                        $tb51 .= '<tr>
                                  <td></td>
                                  <td>'.$exTypeExplode[$Exrkey].'</td>
                                  <td>-</td>
                                  </tr>';

                      } } } } }
                    // Extrabed list end 
                    // Adult and room General supplement list start

                      if (count($general)!=0) {
                        foreach ($general as $gskey => $gsvalue) {
                          if ($gsvalue->gstayDate==date('d/m/Y', strtotime($data[0]->check_in. ' + '.$j.'  days'))) {
                            $gsadultExplode = explode(",", $gsvalue->Rwadult);
                            $gsadultAmountExplode = explode(",", $gsvalue->Rwadultamount);
                            foreach ($gsadultExplode as $gsakey => $gsavalue) {
                              if ($gsavalue==$i) {
                                $GAamount[$j] = (($gsadultAmountExplode[$gsakey]*$total_markup)/100)+$gsadultAmountExplode[$gsakey];

                                  $tb51 .= '<tr>
                                        <td></td>
                                        <td>'.$gsvalue->application=="Per Room" ? $gsvalue->generalType : 'Adults '.$gsvalue->generalType.'</td>
                                        <td>-</td>
                                        </tr>';
                                } 
                              }

                          $gschildExplode = explode(",", $gsvalue->Rwchild);
                          $gschildAmountExplode = explode(",", $gsvalue->RwchildAmount);
                           foreach ($gschildExplode as $gsckey => $gscvalue) {
                                if ($gscvalue==$i) {
                                  $GCamount[$j] = (($gschildAmountExplode[$gsckey]*$total_markup)/100)+$gschildAmountExplode[$gsckey];

                                  $tb51 .= '<tr>
                                    <td></td>
                                    <td>Child '.$gsvalue->generalType.'</td>
                                    <td>-</td>
                                    </tr>';
                                }  
                            }

                      } } }

                    // Adult and room General supplement list end
                    // Adults Board supplement list start

                      foreach ($board as $bkey => $bvalue) { 
                        if ($bvalue->stayDate==date('d/m/Y', strtotime($data[0]->check_in. ' + '.$j.'  days'))) {
                          $ABRwadultexplode = explode(",", $bvalue->Rwadult);
                          $ABRwadultamountexplode = explode(",", $bvalue->RwadultAmount);
                          foreach ($ABRwadultexplode as $ABRwkey => $ABRwvalue) {
                            if ($ABRwvalue==$i) {
                              $BAamount[$j] = (($ABRwadultamountexplode[$ABRwkey]*$total_markup)/100)+$ABRwadultamountexplode[$ABRwkey];;
                              $TBAamount[$j] += $BAamount[$j];

                              $tb51 .= '<tr>
                                    <td></td>
                                    <td>Child '.$bvalue->board.'</td>
                                    <td>-</td>
                                    </tr>';

                            } }
                    // Adults Board supplement list end
                    // Child Board supplement list start
                          $CBRwchildexplode = explode(",", $bvalue->Rwchild);
                          $CBRwchildamountexplode = explode(",", $bvalue->RwchildAmount);
                          foreach ($CBRwchildexplode as $CBRwkey => $CBRwvalue) {
                            if ($CBRwvalue==$i) {
                              $BCamount[$j] = (($CBRwchildamountexplode[$CBRwkey]*$total_markup)/100)+$CBRwchildamountexplode[$CBRwkey];

                              $TBCamount[$j] += $BCamount[$j];

                              $tb51 .= '<tr>
                                    <td></td>
                                    <td>Child '.$bvalue->board.'</td>
                                    <td>-</td>
                                    </tr>';

                            } }
                    } }
                    // Child Board supplement list end

                  }

            $total[$i] = array_sum($DisroomAmount)+array_sum($TExAmount)+array_sum($GAamount)+array_sum($GCamount)+array_sum($TBAamount)+array_sum($TBCamount);
              $tb51 .='</tbody>
                    
                </table>';
        }
        $pdf->writeHTML($tb51,true,false,false,false,'');

      $array_sumTotal = (array_sum($total)*$data[0]->tax)/100+array_sum($total);
      $final_total = $array_sumTotal-($array_sumTotal*$data[0]->discount)/100;
    $tb5='
    <table style="border-collapse: collapse">
        <tbody>
          <tr>
            <td style="font-size:10px;text-indent:20px"></td>
            <td style="text-align:right ">';
    
    $tb5 .='<div style="font size:16px;font-weight:bold">Total amount : '.currency_type(agent_currency(),ceil($final_total)).' '.agent_currency().'</div></td>
          </tr>
        </tbody>
      </table>';

    // $pdf->writeHTML($tb5,true,false,false,false,'');


    $tb6 = '<table style="border-collapse: collapse">
              <tbody>
                <tr>
                  <td style="font-size:12px;font-weight:bold">Agent details :</td>
                  <td style="text-align:right "></td>
                </tr>
                <tr>
                  <td style="font-size:11px">'.$data[0]->First_Name.' '.$data[0]->Last_Name.'</td>
                  <td style="text-align:right "></td>
                </tr>
                <tr>
                  <td style="font-size:11px">'.$data[0]->Address.'</td>
                  <td style="text-align:right "></td>
                </tr>
                <tr>
                  <td style="font-size:11px">'.$data[0]->Mobile.'</td>
                  <td style="text-align:right "></td>
                </tr>
                <tr>
                  <td style="font-size:11px">'.$data[0]->Email.'</td>
                  <td style="text-align:right "></td>
                </tr>
              </tbody>
            </table>';
    // $pdf->writeHTML($tb6,true,false,false,false,'');

      if ($data[0]->SpecialRequest!="") {
       $tb72='
        <table style="border-collapse: collapse">
            <tbody>
              <tr>
                <th style="font-size:10px;font-weight:bold">Special Request : <br></th>
              </tr>

              <tr>
                <td style="font-size:10px;text-indent:20px">'.$data[0]->SpecialRequest.' </td>
              </tr></tbody>
          </table><br>';
      $pdf->writeHTML($tb72,true,false,false,false,'');
      }
       $remarks=$data[0]->Important_Remarks_Policies;
  $conditions=$data[0]->Important_Notes_Conditions;
  $cancelation = $this->Payment_Model->get_cancellation_terms($_REQUEST['id']); 

       $tb72='
    <table style="border-collapse: collapse">
        <tbody>
          <tr>
            <td style="font-size:10px;text-indent:20px"><div style="font-weight:bold">Important Remarks & Policies : </div>'.$remarks.' </td>
          </tr></tbody>
      </table><br>';
      $pdf->writeHTML($tb72,true,false,false,false,'');
    
    $tb8 ='<table style="border-collapse: collapse">
        <tbody><tr>
            <td style="font-size:10px;text-indent:20px"><div style="font-weight:bold">Important Notes & Conditions: </div>'.$conditions.'</td>   
          </tr></tbody>
      </table>';

      $pdf->writeHTML($tb8,true,false,false,false,'');
 
         $type = 'D';
         ob_clean();
    $pdf->Output('VOUCHER_0'.$_REQUEST['id'].'.pdf', $type);

    }
    public function boardAllocation() {
      $this->load->view('frontend/boardAllocation');
    }
    public function supplementFormcheck() {
      $supplement = $this->Payment_Model->supplementcheck($_REQUEST);
      echo json_encode($supplement);
    }
    public function supplementFormSubmit() {
      // $array = array($_REQUEST['supplementType'] => $_REQUEST);
      $this->session->set_userdata(array(
          $_REQUEST['supplementType']  =>  $_REQUEST,
      ));
      echo json_encode(true);
    }
    public function supplementFormRemove() {
      $this->session->set_userdata($_REQUEST['board']);
      echo json_encode(true);
    }
    public function dummy() {
      xmlbookingMailNotification(1);
     // emailNotification('Booking','Accept',$this->session->userdata('agent_id'),'56','56','167','0','On Requst');
    }
    public function offlineRequest() {
      $this->load->view('frontend/offlineRequest');
    }
    public function OfflineRequestModal() {
      $data['nationality'] = $this->List_Model->getNationality();
      $this->load->view('frontend/OfflineRequestModal',$data);
    }
    public function offlineRequestList() {
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
    $query = $this->Payment_Model->offlineRequestList($filter);
    foreach($query->result() as $key => $r) {
        if ($r->bookingFlg==2) {
          $status = '<span class="text-primary">Pending</span>';
        } else if($r->bookingFlg==0) {
          $status = '<span class="text-danger">Cancelled</span>';
        } else {
          $status = '<span class="text-success">Success</span>';
        }
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
          $r->Destination,
          date('d/m/Y' , strtotime($r->createdDate)),
          $r->hotel_name,
          $r->room_name,
          date('d/m/Y' , strtotime($r->check_in)),
          date('d/m/Y' , strtotime($r->check_out)),
          $r->no_of_rooms,
          agent_currency()." ".currency_type(agent_currency(),$SellingPriceArr),
          $status,
          '<a title="view" class="btn btn-sm btn-success" href="'.base_url().'Payment/agent_Offlinebooking_view?id='.$r->id.'"><i class="fa fa-eye" aria-hidden="true"></i></a>'
        );
      
    }
    $output = array(
        "draw" => $draw,
       "recordsTotal" => $query->num_rows(),
       "recordsFiltered" => $query->num_rows(),
       "data" => $data
    );
    echo json_encode($output);
    exit();
    }
    public function OfflineRequestSubmit() {
      $result = $this->Payment_Model->OfflineRequestSubmit($_REQUEST);
      $type="hotel";
      AgentlogActivity('New hotel offline request added [ID: '.$result.']');
      offlinerequestMailNotification($result,$type);
      echo json_encode(true);
    }
    public function CancellationBookingModal() {
      $data['view'] = $this->Payment_Model->agent_booking_detail($_REQUEST['id']);
      $data['cancelation'] =  $this->Payment_Model->get_cancellation_terms($_REQUEST['id']);
      $this->load->view('frontend/booking/CancellationBookingModal',$data);
    }
    public function reloadRequestCatchfun() {
      $this->session->set_userdata(array(
          'reloadRequestCatchfun'  =>  $_REQUEST,
      ));
      echo json_encode(true);
    }
    public function agent_Offlinebooking_view() {
      $data['view'] = $this->Payment_Model->agent_Offlinebooking_details($_REQUEST['id']);
      $this->load->view('frontend/booking/Offlinebooking_view',$data);
    }
    public function payments() {
      if ($this->session->userdata('agent_id')=="") {
        redirect(base_url());
      }
      $bookbuttondata = $this->session->userdata('hoteldata'.$_REQUEST['hotel_id']);
      $nationality = $this->db->query('SELECT sortname FROM countries where id = '.$_REQUEST['nationality'].'')->result();
       $nationality = $nationality[0]->sortname;   
      $HotelInfo = array();
       $inp_arr_hotel = [
          "ResultIndex" => [
            "value" => $bookbuttondata['resultindex']
          ],
          "SessionId" => [
            "value" => $bookbuttondata['sessionid']
          ],
          "HotelCode" => [
            "value" => $_REQUEST['hotel_id']
          ],
        ];
      $data['HotelInfo'] = $this->List_Model->HotelDetails($inp_arr_hotel);
     // print_r($HotelInfo['HotelDetails']['Description']);exit;
      $HotelRoom = array();
      $cancelinfo = array();
      $data['nationality'] = $this->List_Model->getNationality();
      // Available hotel rooms request start
          $inp_arr_hotel1 = [
          "SessionId" => [
            "value" => $bookbuttondata['sessionid']
          ],
          "ResultIndex" => [
            "value" => $bookbuttondata['resultindex']
          ],
          "HotelCode" => [
            "value" => $_REQUEST['hotel_id']
          ],
          "IsCancellationPolicyRequired" => [
            "value" => true
          ],
          "ResponseTime" => [
            "value" => 0
          ],
        ];
          
        $AvailableRooms =  $this->List_Model->AvailableHotelRooms($inp_arr_hotel1);
        if ($AvailableRooms['Status']['StatusCode']==01) {
        // Available hotel rooms request end
          $data['sessionId'] = $bookbuttondata['sessionid'];
          $Rooms=$AvailableRooms['HotelRooms']['HotelRoom'];
          // $path  = get_upload_path_by_type('searchRoomdata') . $this->session->userdata('agent_id') . '/';
          //  _maybe_create_upload_path($path);
          //  $myFile = $path.date('Ymd').'-'.$_REQUEST['hotel_id'].'.txt';
          //  if (file_exists($myFile)) {
          //   file_put_contents($myFile, "");
          //   $fh = fopen($myFile, 'a');
          //   fwrite($fh, json_encode($Rooms));
          // } else {
          //   $fh = fopen($myFile, 'w');
          //   fwrite($fh, json_encode($Rooms));
          // }
          $Rooms = array_slice($Rooms, 0, 100); 
          $HotelRoom = $Rooms;
          $RoomCombination = $AvailableRooms['OptionsForBooking']['RoomCombination'];
          }
      $data['HotelName'] = $bookbuttondata['hotelname'];
      $data['HotelAdrs'] = $bookbuttondata['hoteladrs'];
      $data['HotelPicture'] = $bookbuttondata['hotelpic'];
      $data['HotelRating'] = $bookbuttondata['hotelrating'];
      $data['HotelRoom'] = $HotelRoom;
      $data['RoomCombination'] = $RoomCombination;
      $data['AvailableRooms'] = $AvailableRooms;
      $data['agent_markup'] = mark_up_get();
      $data['admin_markup'] = general_mark_up_get();
      $data['revenue_markup'] =  xmlrevenue_markup('tbo',$this->session->userdata('agent_id'));
      $data['agent_info'] = $this->Common_Model->agent_info();
      $this->load->view('frontend/xml_payment',$data);
    }
    public function StateSelect() {
      $data = $this->List_Model->SelectState($_REQUEST['Conid']);
      echo json_encode($data);
    }
     public function CitySelect() {
      $data = $this->List_Model->Selectcity($_REQUEST['Stateid']);
      echo json_encode($data);
    }
    public function xml_payment_booking() {
      if ($this->session->userdata('agent_id')=="") {
        redirect(base_url());
      }

      $roomdata = $this->session->userdata('roomdata'.$_REQUEST['hotel_id']);
      $bookbuttondata = $this->session->userdata('hoteldata'.$_REQUEST['hotel_id']);
      $nationality = $this->db->query('SELECT sortname FROM countries where id = '.$_REQUEST['nationality'].'')->result();
       $nationality = $nationality[0]->sortname;
      $HotelRoom = array();
      $cancelinfo = array();
      $HotelNorms = array();
      $RoomIndex = array();
      $availablity = 0;
      $data['nationality'] = $this->List_Model->getNationality();
      $data['agent_credit_amount'] = $this->Payment_Model->agent_credit_amount();
      // Available hotel rooms request start
          $inp_arr_hotel1 = [
          "SessionId" => [
            "value" => $bookbuttondata['sessionid']
          ],
          "ResultIndex" => [
            "value" => $bookbuttondata['resultindex']
          ],
          "HotelCode" => [
            "value" => $_REQUEST['hotel_id']
          ],
          "ResponseTime" => [
            "value" => 0
          ],
        ];
          
        $AvailableRooms = $array = json_decode($roomdata, true);
        if ($AvailableRooms['Status']['StatusCode']==01) {
        // Available hotel rooms request end
          $Rooms=$AvailableRooms['HotelRooms']['HotelRoom'];
          $OptionsForBooking = $AvailableRooms['OptionsForBooking'];
          if (isset($Rooms[0])) {
            for ($i=1; $i <=count($_REQUEST['adults']) ; $i++) { 
              foreach ($Rooms as $key => $value) {
                 if ($_REQUEST['Room'.$i]==$value['RoomIndex']) {
                    $HotelRoom[] = $value;
                 }
              }
            }
          } else {
            $HotelRoom = $Rooms;
          }

          foreach ($_REQUEST['adults'] as $key => $value) {
              $RoomIndex[] = ["RoomIndex"=>[
                          "value"=> $_REQUEST['Room'.($key+1)]
                      ]];
          }
          $inp_arr = [
              "ResultIndex" =>[
                "value"=> $bookbuttondata['resultindex']
              ],
              "SessionId"=>[
                "value"=>$bookbuttondata['sessionid']
              ],
              "HotelCode"=>[
                "value"=>$_REQUEST['hotel_id']
              ],
              "OptionsForBooking"=>[
                "value"=>[
                  "FixedFormat"=>[
                    "value"=>$OptionsForBooking['FixedFormat']
                  ],
                  "RoomCombination"=>[
                    "value"=>$RoomIndex
                  ]
                ]
              ]
          ];
          // $HotelCancellation = $this->List_Model->HotelCancellationPolicy($inp_arr);
          // if ($HotelCancellation['Status']['StatusCode']==01) {
          //   $cancelinfo = $HotelCancellation['HotelCancellationPolicies'];
          // }
          $PriceChanged =array();
          $CancellationPolicy = $this->List_Model->AvailabilityAndPricing($inp_arr);
          if ($CancellationPolicy['Status']['StatusCode']==01) {
            $cancelinfo = $CancellationPolicy['HotelCancellationPolicies'];
            if ($CancellationPolicy['AvailableForBook']=='false' && $CancellationPolicy['AvailableForConfirmBook']=='false') {
               $availablity += 1;
            }
            if ($CancellationPolicy['CancellationPoliciesAvailable']=='false' || $CancellationPolicy['PriceVerification']['@attributes']['Status']=='Failed' || $CancellationPolicy['HotelDetailsVerification']['@attributes']['Status']=='Failed') {
               $availablity += 1;
            }
            $HotelNorms = $CancellationPolicy['HotelCancellationPolicies'];
            $PriceChanged = $CancellationPolicy['PriceVerification'];
            if ($PriceChanged['@attributes']['Status']=="Successful" && $PriceChanged['@attributes']['PriceChanged']=="true" && $PriceChanged['@attributes']['AvailableOnNewPrice']=="true") {
              $availablity = 0;
            }
          } else {
            if ($CancellationPolicy['AvailableForBook']=='false' && $CancellationPolicy['AvailableForConfirmBook']=='false') {
               $availablity += 1;
            }
          }
        }  
      $data['HotelName'] = $bookbuttondata['hotelname'];
      $data['HotelAdrs'] = $bookbuttondata['hoteladrs'];
      $data['HotelPicture'] = $bookbuttondata['hotelpic'];
      $data['HotelRating'] = $bookbuttondata['hotelrating'];
      $data['HotelRoom'] = $HotelRoom;
      $data['cancelinfo'] = $cancelinfo;
      $data['HotelNorms'] = $HotelNorms;
      $data['PriceChanged'] = $PriceChanged;
      $data['availablityerr'] = $availablity;
      $data['agent_markup'] = mark_up_get();
      $data['admin_markup'] = general_mark_up_get();
      $data['revenue_markup'] =  xmlrevenue_markup('tbo',$this->session->userdata('agent_id'));
      $data['paypal'] = $this->List_Model->getpaypaldetails();
      $data['checkout'] = $this->List_Model->getcheckoutdetails();
      $data['braintree'] = $this->List_Model->getbraintreedetails();
      $data['mollie'] = $this->List_Model->getmolliedetails();
      $data['stripe'] = $this->List_Model->getstripedetails();
      $data['authorize_sim'] = $this->List_Model->getsimdetails();
      $data['authorize_aim'] = $this->List_Model->getaimdetails();
      $data['telr'] = $this->List_Model->gettelrdetails();
      $this->load->view('frontend/xml_payment_booking',$data);
    }
    public function xml_payment_booking_confirm() {
      $this->load->model('List_Model');
      if (!isset($_REQUEST['adults'])) {
        redirect('../hotels');
      }
      $this->session->set_userdata('xml_booking_data',$_REQUEST);
      $payment_method = $_REQUEST['paymenttype'];
      if($payment_method!='credit'){
        $this->xml_booking_online_payment($_REQUEST);
      } else {
        $this->xmlbookingdataInsert('Credit',$_REQUEST);
      }
    }
    // @view xml booking details
    // view xml booking details on agent login
    public function xml_booking_view() {
      $output = $this->Booking_Model->xmlhotel_booking_details($_REQUEST['id']);
      $inp_arr =[
          "ConfirmationNo"=>[
            "value" => $_REQUEST['ConfirmationNo']
          ]
      ];
      $xmlData =  $this->List_Model->HotelBookingDetail($inp_arr);
      $data['view'] = array();
      $data['view1'] = $output;
      if ($xmlData['Status']['StatusCode']==01) {
        // if ($output[0]->BookingId=="" || $output[0]->InvoiceNumber=="") {
          $insertXMlBookingId = $this->Booking_Model->updateXMlBookingId($_REQUEST['id'],$xmlData['BookingDetail']['@attributes']['BookingId'],$xmlData['BookingDetail']['@attributes']['InvoiceNumber'],$xmlData['BookingDetail']['@attributes']['BookingStatus']);
        // }
        $data['view'] = $xmlData['BookingDetail'];
      }
      $this->load->view('frontend/booking/agent_xml_booking_view',$data);    
    }
    // @generate invoice in pdf
    // generating invoices in pdf for xml bookings
    public function xmlinvoice_pdf() {
      $output = $this->Booking_Model->xmlhotel_booking_details($_REQUEST['id']);
      $inp_arr =[
          "ConfirmationNo"=>[
            "value" => $_REQUEST['ConfirmationNo']
          ]
      ];
      $xmlData =  $this->List_Model->HotelBookingDetail($inp_arr);
      $view = array();
      $view1 = $output;
      if ($xmlData['Status']['StatusCode']==01) {
        if ($output[0]->BookingId=="" || $output[0]->InvoiceNumber=="") {
          $insertXMlBookingId = $this->Booking_Model->updateXMlBookingId($_REQUEST['id'],$xmlData['BookingDetail']['@attributes']['BookingId'],$xmlData['BookingDetail']['@attributes']['InvoiceNumber'],$xmlData['BookingDetail']['@attributes']['BookingStatus']);
        }
        $view = $xmlData['BookingDetail'];
      }
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
      $agent_name=$view1[0]->AFName." ".$view1[0]->ALName;
      $agent_number=$view1[0]->Mobile;
      $agent_email=$view1[0]->Email;

      //HOTEL DETAILS
      $invoice_company_name=$view['HotelName'];
      $invoice_company_address=$view['AddressLine1'];
      $invoice_company_city=$view['City'];

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
            <td><img width="100" src="http://otelseasy.com/skin/images/dash/logo.png" /></td>
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
      $invoice_data_date= date('d/m/Y',strtotime($view['BookingDate']));
      $invoice_number = $_REQUEST['invoiceno'];
      if ($invoice_number=="") {
        $invoice_number = "Invoice0000";
      }
    
      $confirmationNumber = $_REQUEST['ConfirmationNo'];
       // $confirmationName = $data[0]->confirmationName;
      $Guest = array();
      if (isset($view['Roomtype']['RoomDetails'][0])) {
        foreach ($view['Roomtype']['RoomDetails'] as $key => $value) {
          if (isset($value['GuestInfo']['Guest'][0])) {
            $GuestDetails = $value['GuestInfo']['Guest'][0];
          } else {
            $GuestDetails = $value['GuestInfo']['Guest'];
          }
          $Guest[$key]['Room'] = $GuestDetails['@attributes']['GuestInRoom'];
          $Guest[$key]['Name'] = $GuestDetails['FirstName'].' '.$GuestDetails['LastName'];
          $Guest[$key]['Age'] = $GuestDetails['Age'];
          $Guest[$key]['LeadGuest'] = $GuestDetails['@attributes']['LeadGuest'];
        }
      } else {
        if (isset($view['Roomtype']['RoomDetails']['GuestInfo']['Guest'][0])) {
          $GuestDetails =$view['Roomtype']['RoomDetails']['GuestInfo']['Guest'][0];
        } else {
          $GuestDetails =$view['Roomtype']['RoomDetails']['GuestInfo']['Guest'];
        }
          $Guest[0]['Room'] = $GuestDetails['@attributes']['GuestInRoom'];
          $Guest[0]['Name'] = $GuestDetails['FirstName'].' '.$GuestDetails['LastName'];
          $Guest[0]['Age'] = $GuestDetails['Age'];
          $Guest[0]['LeadGuest'] = $GuestDetails['@attributes']['LeadGuest'];
      }
      foreach ($Guest as $key => $value) { 
        $customer_name = $Guest[$key]['Name'];
      }
      $booking_id=$view['@attributes']['BookingId'];
      
      $tb2 ='
      <table class="table2">
        <tbody>
          <tr>
            <td style="text-indent:5px;">'.$customer_name.'</td>
            <td style="text-align:right;">Invoice date  : '.$invoice_data_date.'</td>
          </tr>
          <tr>
            <td style="text-indent:5px;"></td>
            <td style="text-align:right;">Invoice number  : '.$invoice_number.'</td>
          </tr>
          <tr>
            <td style="text-indent:5px;"></td>
            <td style="text-align:right;">Booking reference number : '.$booking_id.'</td>
          </tr>
          <tr>
            <td style="text-indent:5px;"></td>
            <td style="text-align:right;">Confirmation Number : '.$confirmationNumber.'</td>
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
      // $room=$RoomDetails['RoomName'];
      $check_in=date_create($view['CheckInDate']);
      $check_out=date_create($view['CheckOutDate']);
      $no_of_days=date_diff($check_in,$check_out);
      $days = $no_of_days->format("%a");
      $no_of_rooms=$view1[0]->no_of_rooms;
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
          <th class="tgh rgt_bor">Days</th>
          <th class="tgh rgt_bor">No of Rooms</th>
          <th class="tgh rgt_bor">Check In</th>
          <th class="tgh">Check Out</th>
        </tr>
        <tr>
          <td class="tgd rgt_bor">'.$invoice_company_name.'</td>
          <td class="tgd rgt_bor">'.$days.'</td>
          <td class="tgd rgt_bor">'.$no_of_rooms.'</td>
          <td class="tgd rgt_bor">'.date('d/m/Y',strtotime($view['CheckInDate'])).'</td>
          <td class="tgd">'.date('d/m/Y',strtotime($view['CheckOutDate'])).'</td>
        </tr>
      </table>

      ';
      //ADULT & CHILD DETAILS 
      $AdultCount = 0;
      $ChildCount = 0;
      if (isset($view['Roomtype']['RoomDetails'][0])) {
        foreach ($view['Roomtype']['RoomDetails'] as $key => $value) {
          $AdultCount +=$value['AdultCount'];
          $ChildCount = $view['Roomtype']['RoomDetails'][$key]['ChildCount'];
          $ChildCount = is_array($ChildCount) ? 0 : $ChildCount;
          $ChildCount += $ChildCount;
        }
      } else {
        $AdultCount = $view['Roomtype']['RoomDetails']['AdultCount'];
        $ChildCount = $view['Roomtype']['RoomDetails']['ChildCount'];
        $ChildCount = is_array($ChildCount) ? 0 : $ChildCount;
      }
      $child_no=$ChildCount;
      $adult_no= $AdultCount;

      $tb4='
      <style type="text/css">
      .tb4h {font-size:10px; background-color:ghostwhite; padding-top:5px;padding-bottom:5px}
      </style>

      <table class="tb4h">
        <tr>
          <td>Adult(s) : '.$adult_no.'</td>
          <td>Child(s) : '.$child_no.'</td>
        </tr>
      </table>

      ';
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
      $tb51=
      '<style type="text/css">
        .tg  {border-spacing:0;border:1px solid #dddddd; border-collapse: collapse;text-align:center;}
        .tg td{font-size:11px;border-style:solid #dddddd;border-width:1px;word-break:normal;color:#333;  border-collapse: separate;}
        .tg tr td{font-size:11px;border-style:solid #dddddd;border-width:1px;word-break:normal;color:#333;  border-collapse: separate;}                   
      </style>';
      $total_markup = $view1[0]->agent_markup+$view1[0]->admin_markup;
      $book_room_count = $view1[0]->no_of_rooms;
      $checkin_date=date_create($view['CheckInDate']);
      $checkout_date=date_create($view['CheckOutDate']);
      $no_of_days=date_diff($checkin_date,$check_out);
      $tot_days = $no_of_days->format("%a");
      for ($i=1; $i <= $book_room_count; $i++) {
        $tb51.='
        <h4 class="room-name">Room '.$i.'</h4>
          <table style="border-collapse: collapse;border:1px solid #dddddd" class="tg">
            <thead>
              <tr style="background-color: #0074b9;">
                <td style="color: white">Date</td>
                <td style="color: white">Room type</td>
                <td style="color: white">Board</td>
                <td style="color: white">Rate</td>
              </tr>
            </thead>
            <tbody>';
              if (isset($view['Roomtype']['RoomDetails'][$i-1])) {
                $RoomDetails = $view['Roomtype']['RoomDetails'][$i-1] ;
              } else {
                $RoomDetails = $view['Roomtype']['RoomDetails'];
              }
              $amount[$i] = $RoomDetails['RoomRate']['@attributes']['RoomFare'];
              $total[$i] = $RoomDetails['RoomRate']['@attributes']['TotalFare'];
              $tax[$i] = $RoomDetails['RoomRate']['@attributes']['RoomTax'];
              $RoomFare = $RoomDetails['RoomRate']['@attributes']['RoomFare'];
              $RoomFare = ($RoomFare*$total_markup/100)+$RoomFare;
              $tb51 .='<tr>
                <td>'.date('d/m/Y',strtotime($view['CheckInDate'])) .' to '.date('d/m/Y',strtotime($view['CheckOutDate'])).'</td>
                <td>'.$RoomDetails['RoomName'].'</td>
                <td></td>
                <td style="text-align: right">'.xml_currency_change($RoomFare,'USD',agent_currency()).' '.agent_currency().'</td>
              </tr>';
              $RoomRate = $RoomDetails['RoomRate']['@attributes']['RoomFare'];
                                   $RoomRate = ($RoomRate*$total_markup/100)+$RoomRate;
            $tb51 .='</tbody>
              <tfoot>
              <tr>
                <td colspan="3" style="text-align: right"><strong style="color:#0074b9">Total</strong></td>
                <td style="text-align:right"><strong style="color:#0074b9">'.xml_currency_change($RoomRate,'USD',agent_currency()).' '.agent_currency().'</strong></td>
              </tr>
              </tfoot>
          </table>';
      }
      $pdf->writeHTML($tb51,true,false,false,false,'');
      $taxamount = array_sum($tax);
                   $taxamount = ($taxamount*$total_markup/100)+$taxamount;

      $totalAmount = array_sum($total);
                  $totalAmount = ($totalAmount*$total_markup/100)+$totalAmount;
      $tb52 ='<table style="border-collapse: collapse">
                <tr>
                  <td colspan="3"></td>
                  <td>Tax :</td>
                  <td style="text-align:right">'.xml_currency_change($taxamount,'USD',agent_currency()).' '.agent_currency().'</td>
                </tr>';
                
                $tb52 .= '<tr>
                  <td colspan="3"></td>
                  <td>GRAND TOTAL :</td>
                  <td style="text-align:right">'.xml_currency_change($totalAmount,'USD',agent_currency()).' '.agent_currency().'</td>
                </tr>
            </table>';
      $pdf->writeHTML($tb52,true,false,false,false,'');
      //AMOUNT DETAILS END
      $defaultPolicy = isset($view['HotelCancelPolicies']['DefaultPolicy']) ? $view['HotelCancelPolicies']['DefaultPolicy'] : '' ;
      $tb72='
        <table style="border-collapse: collapse">
            <tbody>
              <tr>
                <td style="font-size:10px;text-indent:20px"><div style="font-weight:bold">Important Remarks & Policies : </div>'.$defaultPolicy.' </td>
              </tr></tbody>
          </table><br><br><br>';
      $pdf->writeHTML($tb72,true,false,false,false,'');
      if(isset($view['HotelCancelPolicies']['CancelPolicy']) && count($view['HotelCancelPolicies']['CancelPolicy'])!=0) {  
        $cancelation = $view['HotelCancelPolicies']['CancelPolicy'];
        $NoShowPolicy = $view['HotelCancelPolicies']['NoShowPolicy'];   
        $tb7 =' <br><br><table style="border-collapse: collapse">
                <tbody>
                  <tr>
                    <td style="font-size:10px;text-indent:20px"><div style="font-weight:bold">Cancellation policy:</div></td>
                  </tr></tbody>
                </table>
                <br>
                <br>
                <style type="text/css">
                  .tg  {border-spacing:0;border:1px solid #dddddd; border-collapse: collapse;text-align:center;}
                  .tg td{font-size:11px;border-style:solid #dddddd;border-width:1px;word-break:normal;color:#333;  border-collapse: separate;}
                  .tg tr td{font-size:11px;border-style:solid #dddddd;border-width:1px;word-break:normal;color:#333;  border-collapse: separate;}
                  
                  </style>
                <table style="border-collapse: collapse;border:1px solid #dddddd" class="tg">
                  <thead>
                    <tr style="background-color: #0074b9;">
                      <td style="color: white">Cancelled on or After</td>
                      <td style="color: white">Cancelled on or Before</td>
                      <td style="color: white">Cancellation Charge</td>
                    </tr>
                  </thead>
                  <tbody>';
                  if (isset($cancelation[0])) {
                  foreach ($cancelation as $Canckey => $Cancvalue) { 
                    if($Cancvalue['@attributes']['ChargeType'] == 'Fixed'){ 
                      $cancelcharge = xml_currency_change($Cancvalue['@attributes']['CancellationCharge'],'USD',agent_currency()).' '.agent_currency();
                    } else {
                        $cancelcharge = $Cancvalue['@attributes']['CancellationCharge'].'%' ;
                    } 
                      $tb7 .='<tr>
                        <td>'.date('d/m/Y' , strtotime($Cancvalue['@attributes']['FromDate'])).'</td>
                        <td>'.date('d/m/Y' , strtotime($Cancvalue['@attributes']['ToDate'])).'</td>

                        <td>'.$cancelcharge.'</td>
                      </tr>';
                    } 
                  }else {
                    if($cancelation['@attributes']['ChargeType'] == 'Fixed'){ 
                      $cancelcharge = xml_currency_change($cancelation['@attributes']['CancellationCharge'],'USD',agent_currency()).' '.agent_currency();
                    } else {
                        $cancelcharge = $cancelation['@attributes']['CancellationCharge'].'%' ;
                    } 
                      $tb7 .='<tr>
                        <td>'.date('d/m/Y' , strtotime($cancelation['@attributes']['FromDate'])).'</td>
                        <td>'.date('d/m/Y' , strtotime($cancelation['@attributes']['ToDate'])).'</td>
                        <td>'. $cancelcharge.'</td>
                      </tr>';
                  }
                  if (isset($NoShowPolicy[0])) {
                    foreach ($NoShowPolicy as $Canckey => $Cancvalue) {
                      if($Cancvalue['@attributes']['ChargeType'] == 'Fixed'){ 
                          $cancelcharge = xml_currency_change($Cancvalue['@attributes']['CancellationCharge'],'USD',agent_currency()).' '.agent_currency();
                      } else {
                            $cancelcharge = $Cancvalue['@attributes']['CancellationCharge'].'%' ;
                      } 
                      $tb7 .='<tr>
                        <td>'.date('d/m/Y' , strtotime($Cancvalue['@attributes']['FromDate'])).'</td>
                        <td>'. date('d/m/Y' , strtotime($Cancvalue['@attributes']['ToDate'])).'</td>
                        <td>'.$cancelcharge.'%</td>
                      </tr>';
                    } 
                  } else {
                    if($NoShowPolicy['@attributes']['ChargeType'] == 'Fixed'){ 
                      $cancelcharge = xml_currency_change($NoShowPolicy['@attributes']['CancellationCharge'],'USD',agent_currency()).' '.agent_currency();
                    } else {
                        $cancelcharge = $NoShowPolicy['@attributes']['CancellationCharge'].'%' ;
                    } 
                    $tb7 .='<tr>
                        <td>'.date('d/m/Y' , strtotime($NoShowPolicy['@attributes']['FromDate'])).'</td>
                        <td>'.date('d/m/Y' , strtotime($NoShowPolicy['@attributes']['ToDate'])).'</td>
                        <td>'.$cancelcharge.'</td>
                      </tr>';

                  }
                $tb7 .='</tbody>
                </table>';
                  
                 
        $pdf->writeHTML($tb7,true,false,false,false,'');
      }
  
      $HotelPolicyDetails = isset($view['HotelPolicyDetails']) ? $view['HotelPolicyDetails'] : '';
      $tb8 ='<table style="border-collapse: collapse">
        <tbody><tr>
            <td style="font-size:10px;text-indent:20px"><div style="font-weight:bold">Important Notes & Conditions: </div>'.$HotelPolicyDetails.'</td>   
          </tr></tbody>
      </table>';

      $pdf->writeHTML($tb8,true,false,false,false,'');



      $bankDetails = $this->Payment_Model->bankDetails();
      // $pdf->writeHTML($tb8,true,false,false,false,'');

      $tb9 = '<br><br><table style="border-collapse: collapse">
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


      $type = 'D';
      ob_clean();
      $pdf->Output($invoice_number.'.pdf', $type);
    }
    // @generate voucher pdf
    // genarate voucher pdfs for xml bookings
    public function xmlvoucher_pdf() {
      $output = $this->Booking_Model->xmlhotel_booking_details($_REQUEST['id']);
      $inp_arr =[
          "ConfirmationNo"=>[
            "value" => $_REQUEST['ConfirmationNo']
          ]
      ];
      $xmlData =  $this->List_Model->HotelBookingDetail($inp_arr);
      $view = array();
      $view1 = $output;
      if ($xmlData['Status']['StatusCode']==01) {
        if ($output[0]->BookingId=="" || $output[0]->InvoiceNumber=="") {
          $insertXMlBookingId = $this->Booking_Model->updateXMlBookingId($_REQUEST['id'],$xmlData['BookingDetail']['@attributes']['BookingId'],$xmlData['BookingDetail']['@attributes']['InvoiceNumber'],$xmlData['BookingDetail']['@attributes']['BookingStatus']);
        }
        $view = $xmlData['BookingDetail'];
      }
      require_once APPPATH . 'third_party/tcpdf/tcpdf.php';
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
      $agent_name=$view1[0]->AFName." ".$view1[0]->ALName;
      $agent_number=$view1[0]->Mobile;
      $agent_email=$view1[0]->Email;

      //HOTEL DETAILS
      $invoice_company_name=$view['HotelName'];
      $invoice_company_address=$view['AddressLine1'];
      $invoice_company_city=$view['City'];

      $a_folder = $view1[0]->agent_id;
      $a_logo = $view1[0]->logo;

      if (file_exists(base_url().'uploads/agent_logo/'.$a_folder.'/'.$a_logo)) {
        $a_logo = '<td width="10%"><img width="50" style="float:right"  src="'.base_url().'uploads/agent_logo/'.$a_folder.'/'.$a_logo.'" /></td>';
      } else {
        $a_logo = '';
      }
      $tbl_header = '<table border="0"  cellspacing="2" nobr="true" style="border-bottom:1px solid #999">';
      $tbl_footer = '</table>';
      $tbl = '';
      $tbl1 = '';
      if ($a_logo!="") {
        $tbl1 .= 
        ' <tr >
            <td width="30%"><img width="100" src="http://otelseasy.com/skin/images/dash/logo.png" /></td> 
             <td width="60%" style="text-align:right;"><span  style="float:left" >'.$agent_name.'<br>'.$agent_number.'<br>'.$agent_email.'</span>
            </td>
            '.$a_logo.'
          </tr>
        ';
      } else {
        $tbl1 .= 
        '
          <tr >
            <td width="30%"><img width="100" src="http://otelseasy.com/skin/images/dash/logo.png" /></td> 
             <td width="70%" style="text-align:right;"><span  style="float:left" >'.$agent_name.'<br>'.$agent_number.'<br>'.$agent_email.'</span>
            </td>
          </tr>
        ';
      }
       $tbl .= 
        '
          <tr>
            <td width="30%"><img width="100" src="http://otelseasy.com/skin/images/dash/logo.png" /></td> 
            <td width="70%" style="text-align:right;"><span  style="float:left" >'.$agent_name.'<br>'.$agent_number.'<br>'.$agent_email.'</span></td>

          </tr>';
      
      $pdf->writeHTML($tbl_header . $tbl1 . $tbl_footer, true, false, false, false, '');

      // $html='
      //       <div  style="font-size:14px ;font-weight:bold;color:#337ab7;">VOUCHER</div>
      //       <div  style="font-size:12px ">Issued to : </div>
      //       ';
      // $pdf->writeHTML($html, false, false, false, false, '');  
      $confirmationNumber = $_REQUEST['ConfirmationNo'];
       // $confirmationName = $data[0]->confirmationName;
      $AdultCount = 0;
      $ChildCount = 0;
      if (isset($view['Roomtype']['RoomDetails'][0])) {
        foreach ($view['Roomtype']['RoomDetails'] as $key => $value) {
          $AdultCount +=$value['AdultCount'];
          $ChildCount = $view['Roomtype']['RoomDetails'][$key]['ChildCount'];
          $ChildCount = is_array($ChildCount) ? 0 : $ChildCount;
          $ChildCount += $ChildCount;
        }
      } else {
        $AdultCount = $view['Roomtype']['RoomDetails']['AdultCount'];
        $ChildCount = $view['Roomtype']['RoomDetails']['ChildCount'];
        $ChildCount = is_array($ChildCount) ? 0 : $ChildCount;
      }
      $child_no=$ChildCount;
      $adult_no= $AdultCount;
      $Guest = array();
      if (isset($view['Roomtype']['RoomDetails'][0])) {
        foreach ($view['Roomtype']['RoomDetails'] as $key => $value) {
          if (isset($value['GuestInfo']['Guest'][0])) {
            $GuestDetails = $value['GuestInfo']['Guest'][0];
          } else {
            $GuestDetails = $value['GuestInfo']['Guest'];
          }
          $Guest[$key]['Room'] = $GuestDetails['@attributes']['GuestInRoom'];
          $Guest[$key]['Name'] = $GuestDetails['FirstName'].' '.$GuestDetails['LastName'];
          $Guest[$key]['Age'] = $GuestDetails['Age'];
          $Guest[$key]['LeadGuest'] = $GuestDetails['@attributes']['LeadGuest'];
        }
      } else {
        if (isset($view['Roomtype']['RoomDetails']['GuestInfo']['Guest'][0])) {
          $GuestDetails =$view['Roomtype']['RoomDetails']['GuestInfo']['Guest'][0];
        } else {
          $GuestDetails =$view['Roomtype']['RoomDetails']['GuestInfo']['Guest'];
        }
          $Guest[0]['Room'] = $GuestDetails['@attributes']['GuestInRoom'];
          $Guest[0]['Name'] = $GuestDetails['FirstName'].' '.$GuestDetails['LastName'];
          $Guest[0]['Age'] = $GuestDetails['Age'];
          $Guest[0]['LeadGuest'] = $GuestDetails['@attributes']['LeadGuest'];
      }
      foreach ($Guest as $key => $value) { 
        $customer_name = $Guest[$key]['Name'];
      }

      $booking_id=$view['@attributes']['BookingId'];
      $tb2 ='
      <div style="width:50%;display:block;">

      <table class="table2">
        <tbody>
          <tr>
            <td style=""></td>
            <td style="text-align:right;font-weight:bolder;">Issued To</td>
          </tr>
          <tr>
            <td style="font-size:10px;"></td>
            <td style="text-align:right;font-size:10px;">'.$customer_name.'</td>
          </tr>
          <tr>
            <td style="font-size:10px;">Booking reference number :'.$booking_id.'</td>
            <td style="text-align:right;font-size:10px;"></td>
          </tr>
          <tr>
            <td style="font-size:10px;">Confirmation number :'.$confirmationNumber.'</td>
            <td style="text-align:right;font-size:10px;"></td>
          </tr>
          <tr>
            <td style="font-size:10px;">Hotel name : '.$invoice_company_name.'</td>
            <td style="text-align:right;font-size:10px;"></td>
          </tr>
        </tbody>
      </table>
      </div>
      ';

      $pdf->writeHTML($tb2, true, false, false, false, '');
      

      // CHECKOUT DETAILS
      $check_in=date_create($view['CheckInDate']);
      $check_out=date_create($view['CheckOutDate']);
      $no_of_days=date_diff($check_in,$check_out);
      $days = $no_of_days->format("%a");
      $no_of_rooms=$view1[0]->no_of_rooms;
      $tb3='
      <style type="text/css">
      .tg  {border-spacing:0; border-collapse: collapse;text-align:center;border:1px solid black}
      .tg td{font-size:10px;padding-top:2px 20px;word-break:normal;color:#333;background-color:ghostwhite; padding-bottom: 20px; border-collapse: separate;}
      .tg th{font-size:11px;overflow:hidden;color:#333;color:black;text-align:left}
      .rgt_bor {border: 1px solid black;}
      .tg tr{width: 100%;height:20px;}
      .tgh {height:20px; line-height:18px;}
      </style>
      <table class="tg">
        <tr>
          <th class="tgh rgt_bor" style="border:none">Guest details </th>
          <th class="tgh rgt_bor" style="border:none" colspan="2"></th>
        </tr>';

       foreach ($Guest as $key => $value) {
          $tb3.= '
            <tr>
              <td class="tgh rgt_bor" rowspan="2">Room '.$Guest[$key]['Room'].'</td>
              <td class="tgh rgt_bor" colspan="2">Name : '.$Guest[$key]['Name'].'</td>
            </tr>
            <tr>
              <td class="tgh rgt_bor">No of adults : '.$adult_no.'</td>
              <td class="tgh rgt_bor">No of Children : '.$child_no.'</td>
            </tr>';      
        }

      $tb3.='</table>
      ';
      $pdf->writeHTML($tb3, true, false, false, false, '');


      //AMOUNT DETAILS
      $tb51='<style type="text/css">
        .tg  {border-spacing:0;border:1px solid #dddddd; border-collapse: collapse;text-align:center;}
        .tg tr td{font-size:11px;word-break:normal;color:#333;border:1px solid #dddddd; }               
      </style>';
      $total_markup = $view1[0]->agent_markup+$view1[0]->admin_markup;
      $book_room_count = $view1[0]->no_of_rooms;
      $checkin_date=date_create($view['CheckInDate']);
      $checkout_date=date_create($view['CheckOutDate']);
      $no_of_days=date_diff($checkin_date,$check_out);
      $tot_days = $no_of_days->format("%a");
      for ($i=1; $i <= $book_room_count; $i++) {
        $tb51.='
          <h4 class="room-name">Room '.$i.'</h4>
          <table style="border-collapse: collapse;border:1px solid #dddddd" class="tg">
            <thead>
              <tr style="background-color: #0074b9;">
                <td style="color: white">Date</td>
                <td style="color: white">Room type</td>
                <td style="color: white">Board</td>
              </tr>
            </thead>
            <tbody>';
              if (isset($view['Roomtype']['RoomDetails'][$i-1])) {
                $RoomDetails = $view['Roomtype']['RoomDetails'][$i-1] ;
              } else {
                $RoomDetails = $view['Roomtype']['RoomDetails'];
              }
              $amount[$i] = $RoomDetails['RoomRate']['@attributes']['RoomFare'];
              $total[$i] = $RoomDetails['RoomRate']['@attributes']['TotalFare'];
              $tax[$i] = $RoomDetails['RoomRate']['@attributes']['RoomTax'];
              $RoomFare = $RoomDetails['RoomRate']['@attributes']['RoomFare'];
              $RoomFare = ($RoomFare*$total_markup/100)+$RoomFare;
              for ($j=0; $j < $tot_days ; $j++) {
              $tb51 .='<tr>
                  <td >'.date('d/m/Y', strtotime($view['CheckInDate']. ' + '.$j.'  days')).'</td>
                  <td>'.$RoomDetails['RoomName'].'</td>
                  <td></td>
                </tr>';
              }
              $RoomRate = $RoomDetails['RoomRate']['@attributes']['RoomFare'];
                                   $RoomRate = ($RoomRate*$total_markup/100)+$RoomRate;
            $tb51 .='</tbody>
        </table>';
      }
      $pdf->writeHTML($tb51,true,false,false,false,'');    
      if (count($view['SpecialRequest'])!=0 && isset($view['SpecialRequest'])) {
       $tb72='
        <table style="border-collapse: collapse">
            <tbody>
              <tr>
                <th style="font-size:10px;font-weight:bold">Special Request : <br></th>
              </tr>

              <tr>
                <td style="font-size:10px;text-indent:20px">'.$view[0]->SpecialRequest.' </td>
              </tr></tbody>
          </table><br>';
      $pdf->writeHTML($tb72,true,false,false,false,'');
      }
      $defaultPolicy = isset($view['HotelCancelPolicies']['DefaultPolicy']) ? $view['HotelCancelPolicies']['DefaultPolicy'] : '' ;
      $HotelPolicyDetails = isset($view['HotelPolicyDetails']) ? $view['HotelPolicyDetails'] : '';
      $tb72='
      <table style="border-collapse: collapse">
        <tbody>
          <tr>
            <td style="font-size:10px;text-indent:20px"><div style="font-weight:bold">Important Remarks & Policies : </div>'.$defaultPolicy.' </td>
          </tr></tbody>
      </table><br>';
      $pdf->writeHTML($tb72,true,false,false,false,'');
    
      $tb8 ='<table style="border-collapse: collapse">
        <tbody><tr>
            <td style="font-size:10px;text-indent:20px"><div style="font-weight:bold">Important Notes & Conditions: </div>'.$HotelPolicyDetails.'</td>   
          </tr></tbody>
      </table>';

      $pdf->writeHTML($tb8,true,false,false,false,'');
 
         $type = 'D';
         ob_clean();
      $pdf->Output('VOUCHER_0'.$_REQUEST['id'].'.pdf', $type);
    }
    public function booking_online_payment($data) {
        $this->session->set_userdata('pay_currency',agent_currency());
        $this->session->set_userdata('totalamount',$data['tot']);
      if($data['paymenttype']=="checkout"){
        $details['checkoutdata']    = $this->Common_Model->checkoutdetails();
        $this->load->view('frontend/payments/checkout_payment',$details);
      } else if($data['paymenttype']=="braintree"){
         $braintree   = $this->Common_Model->braintreedetails();
         $details['token'] = $this->Paypal_braintree_gateway->generate_token($braintree);
         $this->load->view('frontend/payments/braintree_payment',$details);
      } else if($data['paymenttype']=='authorize_sim') {
         $simdetails   = $this->Common_Model->authorizeSIMdetails();
         $this->Authorize_sim_gateway->process_payment_booking($simdetails);
      } else if($data['paymenttype']=='stripe') {
         $stripedetails   = $this->Common_Model->stripedetails();
         $this->Stripe_gateway->process_payment_booking($stripedetails);
      } else if($data['paymenttype']=='authorize_aim') {
         $details['aimdetails']   = $this->Common_Model->authorizeAIMdetails();
         $this->load->view('frontend/payments/authorizeaim_payment',$details);
      } else if($data['paymenttype']=='paypal') {
         $details   = $this->Common_Model->paypaldetails();
         $this->Paypal_gateway->process_payment_booking($details);
      } else if($data['paymenttype']=='telr') {
         $details   = $this->Common_Model->telrdetails();
         $this->Telr_gateway->process_payment_booking($details);
      } else if($data['paymenttype']=='mollie') {
         $details   = $this->Common_Model->molliedetails();
         $this->Mollie_gateway->process_payment_booking($details);
      }
    }
    public function bookingdataInsert($type,$data) {
        $_REQUEST = $data;
        $discount = $this->List_Model->discountCheck($data['Check_in'],$data['Check_out'],$data['hotel_id'],$data['room_id'],$data['contract_id']);
        
        $checkin_date=date_create($data['Check_in']);
        $checkout_date=date_create($data['Check_out']);
        $no_of_days=date_diff($checkin_date,$checkout_date);
        $tot_days = $no_of_days->format("%a");
        $discountCodes = array();
        for ($i=0; $i < $tot_days ; $i++) {
          $dateOut = date('Y-m-d', strtotime($data['Check_in']. ' + '.$i.'  days'));
          $discountCodes[$i] = DateWisediscountCode($dateOut,$data['hotel_id'],$data['room_id'],$data['contract_id'],'Room',$data['Check_in'],$data['Check_out']);
        }

        $discountCode = implode(",", array_unique($discountCodes));

        $agent_credit_amount = $this->Payment_Model->agent_credit_amount();
        $roomAvailability =  $this->Payment_Model->roomAvailability($data['room_id'],$data['Check_in'],$data['Check_out'],$data['contract_id'],$data['hotel_id']);
        $max_id = $this->Payment_Model->max_booking_id();
        if ($max_id[0]->id=="") {
          $max_booking_id = "HAB01";
        } else {
          $booking_id = $max_id[0]->id+1;
          $max_booking_id = "HAB0".$booking_id;
        }
        $implodeChildAge = 0;
        $implodechildamount = 0;
        $agent_markup = mark_up_get();
        $agent_general_markup = general_mark_up_get();
        $contract_markup = $this->List_Model->contract_markup($data['hotel_id'],$data['contract_id']);
        $revenue_markup = revenue_markup($data['hotel_id'],$data['contract_id'],$this->session->userdata('agent_id'));
         $total_markup = $agent_markup+$agent_general_markup;
        if ($revenue_markup!='') {
          $total_markup = $agent_markup+$revenue_markup;
          $agent_general_markup = 0;
          $contract_markup = $revenue_markup;
        }
        $search_markup = 0;
      
        $admin_markup = $contract_markup+$agent_general_markup;
        $normal_price = array_sum($data['per_day_amount']);

        $discountGet =  Alldiscount(date('Y-m-d',strtotime($data['Check_in'])),date('Y-m-d',strtotime($data['Check_out'])),$data['hotel_id'],$data['room_id'],$data['contract_id'],'Room'); 
        if ($discountGet['dis']=='true') {
          $Cdays = $tot_days/$discountGet['stay'];
          $parts = explode('.', $Cdays);
          $Cdays = $parts[0];
          $Sdays = $discountGet['stay']*$Cdays;
          $Pdays = $discountGet['pay']*$Cdays;
          $Tdays = $tot_days-$Sdays;
          $Fdays = ($Pdays+$Tdays)*$data['no_of_rooms'];
          $per_day_amount = $data['per_day_amount'];
          $per_day_amount = array_splice($per_day_amount,1,$Fdays);
          $normal_price = array_sum($per_day_amount);
        }
        $data['mark_up'] = is_numeric($data['mark_up']) ? $data['mark_up'] : 0;
        $per_room_amount =(($normal_price*$data['mark_up'])/100)+$normal_price;

        $tot_per_room_amount  = $per_room_amount*$data['no_of_rooms'];
        

        $tax_amount =($tot_per_room_amount*$data['tax'])/100;
        $total_amount =$tot_per_room_amount+$tax_amount;
        
        $agent_used_amount = ($normal_price*$data['no_of_rooms']);

        
        $total_agent_used_amount = (($agent_used_amount*$admin_markup)/100)+$agent_used_amount+$tax_amount;
        
        
        $agent_currency_type = $this->Payment_Model->agent_currency_type();
        
        $insert_id = $this->Payment_Model->room_booking_add($data,$max_booking_id,$agent_markup,$admin_markup,$normal_price,$per_room_amount,$tax_amount,$total_amount,$agent_currency_type,$search_markup,$discount,$discountCode);
        $CancellationPolicy = $this->Payment_Model->get_CancellationPolicy_contractConfirm($data);
        
        if (count($CancellationPolicy)!=0) {
            foreach ($CancellationPolicy as $Cpkey => $Cpvalue) {
              $this->Payment_Model->addCancellationBooking($insert_id,$Cpvalue['msg'],$Cpvalue['percentage'],$Cpvalue['daysFrom'],$Cpvalue['daysTo'],$Cpvalue['application']);
            }
        }
        $ExtrabedAmount =$this->Payment_Model->get_PaymentConfirmextrabedAllotment($data);
        // print_r($ExtrabedAmount);
        $amount = array();
        if ($ExtrabedAmount['count']!=0) {
          foreach ($ExtrabedAmount['date'] as $key => $value){
              $date=$value;
              $amount[$key]= $ExtrabedAmount['extrabedAmount'][$key];
              
              foreach ($ExtrabedAmount['RwextrabedAmount'][$key] as $Rwexamtarrkey => $Rwexamtarrvalue) {
                $RwexamtarrAmount[$Rwexamtarrkey] = implode(",", $Rwexamtarrvalue);
              }
              $Exrwamount[$key] = implode(",", $RwexamtarrAmount);
             
              foreach ($ExtrabedAmount['Exrooms'][$key] as $Rwexroomarrkey => $Rwexroomarrvalue) {
                $RwexamtarrRoom[$Rwexroomarrkey] = implode(",", $Rwexroomarrvalue);
              }
              $Exrooms[$key] = implode(",", $RwexamtarrRoom);

              foreach ($ExtrabedAmount['extrabedType'][$key] as $Rwextypearrkey => $Rwextypearrvalue) {
                $RwexamtarrType[$Rwextypearrkey] = implode(",", $Rwextypearrvalue);
              }
              $ExrwType[$key] = implode(",", $RwexamtarrType);
              
              $InsertExtrabedAmount=$this->Payment_Model->AddPaymentConfirmExtrabed($date,$amount[$key],$insert_id,$Exrooms[$key],$Exrwamount[$key],$ExrwType[$key]);
          }
        }
        
        /*board Supplement details Add start*/
        $boardData = array();
        $ABadultamount = array();
        $tmangadultamount = array();
        $tmangchildamount = array();
        $implodechildcount = 0;

         $contractBoardCheck = $this->Payment_Model->contractBoardCheck($data['contract_id']);
      
       // $stayDate = $value;
       $BookingDate = date('Y-m-d');
      $checkin_date=date_create($data['Check_in']);
      $checkout_date=date_create($data['Check_out']);
      $no_of_days=date_diff($checkin_date,$checkout_date);
      $tot_days = $no_of_days->format("%a");
      $BreakfastTotal = 0;
      $LunchTotal = 0;
      $DinnerTotal = 0;
      if ($this->session->userdata('Breakfast')!="" && $this->session->userdata('Breakfast')['contract_id']==$data['contract_id'] && $this->session->userdata('Breakfast')['room_id']==$data['room_id'] && $this->session->userdata('Breakfast')['token']==$data['token']) { 
        for($i = 0; $i < $tot_days; $i++) {
           $date = date('Y-m-d', strtotime($data['Check_in']. ' + '.$i.'  days'));
           if (isset($this->session->userdata('Breakfast')[$date])) {
             $stdate[$i] = date('d/m/Y', strtotime($data['Check_in']. ' + '.$i.'  days'));
             $dataBreakfast = $this->Payment_Model->supplementConfirm($this->session->userdata('Breakfast'),$date);
             


             if ($dataBreakfast!=0) {
              
              if (isset($dataBreakfast['adults'])) {
                $rwbadults = implode(",", $dataBreakfast['adults']['rooms']);
                $rwbadlutamount = implode(",", $dataBreakfast['adults']['adultAmount']);
              } else {
                $rwbadults = "";
                $rwbadlutamount = "";
              }
              if (isset($dataBreakfast['childs'])) {
                $rwbchild = implode(",", $dataBreakfast['childs']['rooms']);
                foreach ($dataBreakfast['childs']['childAmount'] as $rwbckey => $rwbcvalue) {
                  $rwbcamountarr[] = array_sum($rwbcvalue);
                }
                $rwbchildamount = implode(",", $rwbcamountarr);
              } else {
                $rwbchild = "";
                $rwbchildamount = "";
              }
              $bkboardSupplementConfirm = $this->Payment_Model->bkboardSupplementConfirm($stdate[$i], $BookingDate, 'Breakfast', $dataBreakfast['adultsAmount'] , $dataBreakfast['ChildAge'], $dataBreakfast['ChildAmount'], ($search_markup+$agent_markup), $total_markup, $admin_markup,$insert_id,$dataBreakfast['adultsCount'],'1',$rwbadults,$rwbadlutamount,$rwbchild,$rwbchildamount);
              $BreakfastTotal+=$dataBreakfast['totalAmount'];
             }
          }
        }
        $this->session->unset_userdata('Breakfast');
      } 
      if ($this->session->userdata('Lunch')!="" && $this->session->userdata('Lunch')['contract_id']==$data['contract_id'] && $this->session->userdata('Lunch')['room_id']==$data['room_id'] && $this->session->userdata('Lunch')['token']==$data['token']) { 
       for($i = 0; $i < $tot_days; $i++) {
           $date = date('Y-m-d',strtotime($data['Check_in']. ' + '.$i.'  days'));
           if (isset($this->session->userdata('Lunch')[$date])) {
             $stdate[$i] = date('d/m/Y', strtotime($data['Check_in']. ' + '.$i.'  days'));
             $dataLunch = $this->Payment_Model->supplementConfirm($this->session->userdata('Lunch'),$date);
             if ($dataLunch!=0) {
                if (isset($dataLunch['adults'])) {
                  $rwladults = implode(",", $dataLunch['adults']['rooms']);
                  $rwladlutamount = implode(",", $dataLunch['adults']['adultAmount']);
                } else {
                  $rwladults = "";
                  $rwladlutamount = "";
                }
                if (isset($dataLunch['childs'])) {
                  $rwlchild = implode(",", $dataLunch['childs']['rooms']);
                  foreach ($dataLunch['childs']['childAmount'] as $rwlckey => $rwlcvalue) {
                    $rwlcamountarr[] = array_sum($rwlcvalue);
                  }
                  $rwlchildamount = implode(",", $rwlcamountarr);
                } else {
                  $rwlchild = "";
                  $rwlchildamount = "";
                }

              $bkboardSupplementConfirm = $this->Payment_Model->bkboardSupplementConfirm($stdate[$i], $BookingDate, 'Lunch', $dataLunch['adultsAmount'] , $dataLunch['ChildAge'], $dataLunch['ChildAmount'], ($search_markup+$agent_markup), $total_markup, $admin_markup,$insert_id,$dataLunch['adultsCount'],'1',$rwladults,$rwladlutamount,$rwlchild,$rwlchildamount);
              $LunchTotal+=$dataLunch['totalAmount'];
             }
           }
        }
        $this->session->unset_userdata('Lunch');
      } 
      if ($this->session->userdata('Dinner')!="" && $this->session->userdata('Dinner')['contract_id']==$data['contract_id'] && $this->session->userdata('Dinner')['room_id']==$data['room_id'] && $this->session->userdata('Dinner')['token']==$data['token']) { 
       $data['Dinner'] = $this->Payment_Model->supplementConfirm($this->session->userdata('Dinner'));
       for($i = 0; $i < $tot_days; $i++) {
           $date = date('Y-m-d', strtotime($data['Check_in']. ' + '.$i.'  days'));
           if (isset($this->session->userdata('Dinner')[$date])) {
             $stdate[$i] = date('d/m/Y', strtotime($data['Check_in']. ' + '.$i.'  days'));
             $dataDinner = $this->Payment_Model->supplementConfirm($this->session->userdata('Dinner'),$date);
             if ($dataDinner!=0) {
                if (isset($dataDinner['adults'])) {
                  $rwdadults = implode(",", $dataDinner['adults']['rooms']);
                  $rwdadlutamount = implode(",", $dataDinner['adults']['adultAmount']);
                } else {
                  $rwdadults = "";
                  $rwdadlutamount = "";
                }
                if (isset($dataDinner['childs'])) {
                  $rwdchild = implode(",", $dataDinner['childs']['rooms']);
                  foreach ($dataDinner['childs']['childAmount'] as $rwdckey => $rwdcvalue) {
                    $rwdcamountarr[] = array_sum($rwdcvalue);
                  }
                  $rwdchildamount = implode(",", $rwdcamountarr);
                } else {
                  $rwdchild = "";
                  $rwdchildamount = "";
                }
              $bkboardSupplementConfirm = $this->Payment_Model->bkboardSupplementConfirm($stdate[$i], $BookingDate, 'Dinner', $dataDinner['adultsAmount'] , $dataDinner['ChildAge'], $dataDinner['ChildAmount'], ($search_markup+$agent_markup), $total_markup, $admin_markup,$insert_id,$dataDinner['adultsCount'],'1',$rwdadults,$rwdadlutamount,$rwdchild,$rwdchildamount);
              $DinnerTotal+=$dataDinner['totalAmount'];
             }
           }
        }
        $this->session->unset_userdata('Dinner');
      } 
        $totalBsamount = $BreakfastTotal+$LunchTotal+$DinnerTotal;

        /*board Supplement details Add end*/
        /*General Supplement details Add start*/
        $gadultamount = array();
        $tgadultamount = array();
        $gchildamount = array();
        $tgchildamount = array();
        $general = $this->Payment_Model->get_Confirmgeneral_supplement($data);
        if ($general['gnlCount']!=0) {
          foreach ($general['date'] as $key3 => $value3) {
            foreach ($general['general'][$key3] as $key4 => $value4) {
              $gstayDate = $value3;
              $gBookingDate = date('Y-m-d');
              $generalType = $value4;
              if (isset($general['adultamount'][$key3][$value4])) {
                $gadultamount[$key4] = $general['adultamount'][$key3][$value4];

                if (array_sum($data['reqChild'])!=0 && isset($general['childamount'][$key3][$value4])) {
                  $gchildamount[$key4] = $general['childamount'][$key3][$value4];
                } else {
                  $gchildamount[$key4] = 0;
                }
                $tgadultamount[] = $general['adultamount'][$key3][$value4];
                $tgchildamount[] = $gchildamount[$key4];
                $Rwgadult[$key4] = implode(",", $general['RWadult'][$key3][$value4]);
                if (isset($general['RWchild'][$key3][$value4])) {
                  $Rwgchild[$key4] = implode(",", $general['RWchild'][$key3][$value4]);
                } else {
                  $Rwgchild[$key4] = "";
                }
                $RwgAdultamount[$key4] = implode(",", $general['RWadultamount'][$key3][$value4]);
                if (isset($general['RWchildAmount'][$key3][$value4])) {
                    foreach ($general['RWchildAmount'][$key3][$value4] as $gscarkey => $gscarvalue) {
                        $gscarr[] =array_sum($gscarvalue);
                    }
                   $RwgChildamount[$key4] = implode(",", $gscarr);
                } else {
                  $RwgChildamount[$key4] = "";
                }
                $Rwgsapplication[$key4] = $general['application'][$key3][$key4];
                $bkgeneralSupplementConfirm = $this->Payment_Model->bkgeneralSupplementConfirm($gstayDate, $gBookingDate, $generalType, $gadultamount[$key4] , $gchildamount[$key4], ($search_markup+$agent_markup), $total_markup, $admin_markup,$insert_id,array_sum($data['reqadults']),array_sum($data['reqChild']),1,$Rwgadult[$key4],$Rwgchild[$key4],$RwgAdultamount[$key4],$RwgChildamount[$key4],$Rwgsapplication[$key4]);
              }
            }
          }
        }
        $totalGsamount = ((array_sum($tgadultamount))+(array_sum($tgchildamount)))+array_sum($tmangadultamount)+array_sum($tmangchildamount)+array_sum($amount);
        
        $totalGBamount = ((($totalGsamount+$totalBsamount)*$admin_markup)/100)+($totalGsamount+$totalBsamount);

        /*General Supplement details Add end*/
        $this->Payment_Model->confirm_notification($this->session->userdata('agent_id'),$data['hotel_id'],$insert_id);
        if($type=='Credit') {
          $agent_credit_get = $this->Payment_Model->agent_credit_get();

          $discountAmount = ($total_agent_used_amount+$totalGBamount)-(($total_agent_used_amount+$totalGBamount)*$discount/100);

          $agent_amount = $agent_credit_get-$discountAmount;
          if ($data['RequestType']=='Book') {
            $sub_agent_price_update = $this->Payment_Model->agent_price_update($agent_amount);
            $this->Payment_Model->agent_amount_status_update($agent_credit_get,$discountAmount,$insert_id);
          }
        } else {
          $this->Payment_Model->add_payment_records($data,$insert_id);
        }
        
        AgentlogActivity('New hotel booking added [BookingID: HAB0'.$insert_id.' ,HotelID: HOB0'.$data['hotel_id'].' ,Provider: Otelsesy]');
        //emailNotification('Booking','Accept',$this->session->userdata('agent_id'),$data['hotel_id'],$insert_id,$data['room_id'],$discount,$data['RequestType']);
        // print_r($ExtrabedAmount);
        // exit();
        $this->session->set_flashdata('message', 'Booked Successfully');
        redirect('../hotels');
      }
    public function booking_online_payment_response() {
      if ($_REQUEST['msg']=='success') {
        $data = $this->session->userdata('booking_data');
        $data = array_merge($data,$_REQUEST);
        $this->bookingdataInsert($_REQUEST['gateway'],$data); 
      }
      else if($_REQUEST['msg']=='failed') {
        $data = $this->session->userdata('booking_data');
        $data = array_merge($data,$_REQUEST);
        redirect(base_url().'/Payment/payment_booking?'.http_build_query($data));
      }
    }
    public function telr_test() {
      $this->Telr_gateway->process_test_payment();  
    }
    public function returnTelr() {
      print_r($_REQUEST);exit();
    }
    public function returncancelTelr() {
      print_r($_REQUEST);exit();
    }
    public function xml_booking_online_payment($data) {
      $this->session->set_userdata('pay_currency',agent_currency());
      $this->session->set_userdata('totalamount',$data['tot']);
      if($data['paymenttype']=="checkout"){
        $details['checkoutdata']    = $this->Common_Model->checkoutdetails();
        $this->load->view('frontend/payments/xml_checkout_payment',$details);
      } else if($data['paymenttype']=="braintree"){
         $braintree   = $this->Common_Model->braintreedetails();
         $details['token'] = $this->Paypal_braintree_gateway->generate_token($braintree);
         $this->load->view('frontend/payments/xml_braintree_payment',$details);
      } else if($data['paymenttype']=='authorize_sim') {
         $simdetails   = $this->Common_Model->authorizeSIMdetails();
         $this->Authorize_sim_gateway->process_payment_xml_booking($simdetails);
      } else if($data['paymenttype']=='stripe') {
         $stripedetails   = $this->Common_Model->stripedetails();
         $this->Stripe_gateway->process_payment_xml_booking($stripedetails);
      } else if($data['paymenttype']=='authorize_aim') {
         $details['aimdetails']   = $this->Common_Model->authorizeAIMdetails();
         $this->load->view('frontend/payments/xml_authorizeaim_payment',$details);
      } else if($data['paymenttype']=='paypal') {
         $details   = $this->Common_Model->paypaldetails();
         $this->Paypal_gateway->process_payment_xml_booking($details);
      } else if($data['paymenttype']=='telr') {
         $details   = $this->Common_Model->telrdetails();
         $this->Telr_gateway->process_payment_xml_booking($details);
      } else if($data['paymenttype']=='mollie') {
         $details   = $this->Common_Model->molliedetails();
         $this->Mollie_gateway->process_payment_xml_booking($details);
      }
    }
    public function xml_booking_online_payment_response() {
      if ($_REQUEST['msg']=='success') {
        $data = $this->session->userdata('xml_booking_data');
        $data = array_merge($data,$_REQUEST);
        $this->xmlbookingdataInsert($_REQUEST['gateway'],$data); 
      }
      else if($_REQUEST['msg']=='failed') {
        $data = $this->session->userdata('xml_booking_data');
        $data = array_merge($data,$_REQUEST);
        redirect(base_url().'/Payment/xml_payment_booking?'.http_build_query($data));
      }
    }
    public function xmlbookingdataInsert($type,$data) {  
      $revenue_markup = xmlrevenue_markup('tbo',$this->session->userdata('agent_id'));
      $admin_markup = general_mark_up_get();
      if ($revenue_markup!='') {
        $admin_markup = $revenue_markup;
      } 
       $bookbuttondata = $this->session->userdata('hoteldata'.$_REQUEST['hotel_id']);
       $_REQUEST = $data;
       $Supplements = array();
       $nationality = $this->db->query('SELECT * FROM countries where id = '.$_REQUEST['nationality'].'')->result();
       $Country = $nationality[0]->name;
       $Countryshort = $nationality[0]->sortname;
       $CountryCode =$nationality[0]->phonecode;
       // $city = $this->db->query('SELECT name FROM cities where id = '.$_REQUEST['citySelect'].'')->result();
       $cityname = $_REQUEST['citySelect'];
       $state = $this->db->query('SELECT name FROM states where id = '.$_REQUEST['stateSelect'].'')->result();
       $statename = $state[0]->name;
       for($x=0;$x<$_REQUEST['no_of_rooms'];$x++){
          for ($i=0; $i < $_REQUEST['adults'][$x] ; $i++) { 
            $Guest[] = [
              "Guest"=>[
                "attr"=>[
                  "LeadGuest"=> $i==0 && $x==0 ? true : 0,
                  "GuestType"=>'Adult',
                  "GuestInRoom"=>$x+1
                ],
                "value"=>[
                  "Title"=>[
                    "value"=>$_REQUEST['Room'.($x+1).'Adulttitle'][$i]
                  ],
                  "FirstName"=>[
                    "value"=> $_REQUEST['Room'.($x+1).'AdultFirstName'][$i]
                  ],
                  "LastName"=>[
                    "value"=>$_REQUEST['Room'.($x+1).'AdultLastName'][$i]
                  ],
                  "Age"=>[
                    "value"=>$_REQUEST['Room'.($x+1).'AdultAge'][$i]
                  ]
                ]
              ]
            ];
          }

          for ($i=0; $i < $_REQUEST['Child'][$x] ; $i++) { 
            $Guest[] = [
              "Guest"=>[
                "attr"=>[
                  "LeadGuest"=> 0,
                  "GuestType"=>'Child',
                  "GuestInRoom"=>$x+1
                ],
                "value"=>[
                  "Title"=>[
                    "value"=>$_REQUEST['Room'.($x+1).'ChildTitle'][$i]
                  ],
                  "FirstName"=>[
                    "value"=> $_REQUEST['Room'.($x+1).'ChildFirstName'][$i]
                  ],
                  "LastName"=>[
                    "value"=>$_REQUEST['Room'.($x+1).'ChildLastName'][$i]
                  ],
                  "Age"=>[
                    "value"=>$_REQUEST['Room'.($x+1).'ChildAge'][$i]
                  ]
                ]
              ]
            ];
          }


        }

      foreach ($_REQUEST['RoomTypeName'] as $key => $value) {
        if (isset($_REQUEST['Room'.($key+1).'SuppID'])) {
          foreach ($_REQUEST['Room'.($key+1).'SuppID'] as $key1 => $value1) {
            $Supplements[$key1] = [
                      "SuppInfo"=>[
                        "attr"=>[
                          "SuppID"=>$value1,
                          "SuppChargeType"=>$_REQUEST['Room'.($key+1).'SuppChargeType'][$key1],
                          "Price"=>$_REQUEST['Room'.($key+1).'Price'][$key1],
                          "SuppIsSelected"=>true,
                        ]
                      ]
                    ];

          }
        }
        $HotelRoom[$key] = [
            "HotelRoom"=>[
              "value"=>[
                "RoomIndex"=>[
                  "value"=>$_REQUEST['RoomIndex'][$key]
                ],
                "RoomTypeName"=>[
                  "value"=>$value
                ],
                "RoomTypeCode"=>[
                  "value"=>$_REQUEST['RoomTypeCode'][$key]
                ],
                "RatePlanCode"=>[
                  "value"=>$_REQUEST['RatePlanCode'][$key]
                ],
                "RoomRate"=>[
                  "attr"=>[
                    "Currency"=>'USD',
                    "RoomFare" =>$_REQUEST['RoomFare'][$key],
                    "RoomTax" =>$_REQUEST['RoomTax'][$key],
                    "TotalFare"=>$_REQUEST['TotalFare'][$key]
                  ]
                ],
                "Supplements"=>[
                  "value"=>count($Supplements)!=0 ? $Supplements : ''
                ]
              ]
            ]
          ];
      }
      $rand = $s = substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 4)), 0, 4);
      $ClientReferenceNumber = date('dmyHms')."750#".$rand;
      $inp_arr_hotel = [ 
        "ClientReferenceNumber"=>[
          "value"=> $ClientReferenceNumber
        ],
        "GuestNationality"=>[
          "value"=>$Countryshort
        ],  
        "Guests"=>[
          "value"=>$Guest
        ],
        "AddressInfo"=>[
                        "value"=>[
                          "AddressLine1"=>[
                            "value"=>$_REQUEST['address1']
                          ],
                          "AddressLine2"=>[
                            "value"=>$_REQUEST['address2']
                          ],
                          "CountryCode"=>[
                            "value"=>$CountryCode
                          ],
                          "AreaCode"=>[
                            "value"=>$_REQUEST['areacode']
                          ],
                          "PhoneNo"=>[
                            "value"=>$_REQUEST['contact_num']
                          ],
                          "Email"=>[
                            "value"=>$_REQUEST['email']
                          ],
                          "City"=>[
                            "value"=>$cityname
                          ],
                          "State"=>[
                            "value"=>$statename
                          ],
                          "Country"=>[
                            "value"=>$Country
                          ],
                          "ZipCode"=>[
                            "value"=>$_REQUEST['zipcode']
                          ]
                        ]
        ],
        "PaymentInfo"=>[
          "attr"=>[
            "VoucherBooking"=>true,
            "PaymentModeType"=>'Limit',
          ]
        ],
        "SessionId"=>[
            "value"=>$_REQUEST['sessionID']
        ],
        "NoOfRooms"=>[
            "value"=>$_REQUEST['no_of_rooms']
        ],
        "ResultIndex"=>[
            "value"=> $bookbuttondata['resultindex']
        ],
        "HotelCode"=>[
            "value"=>$_REQUEST['hotel_id']
        ],
        "HotelName"=>[
            "value"=>$_REQUEST['hotel_name']
        ],        
        "HotelRooms"=>[
            "value"=>$HotelRoom
        ]
      ];
      $Bookingresponse =  $this->List_Model->HotelBook($inp_arr_hotel);
      if ($Bookingresponse['Status']['StatusCode']==01) {
        if (is_array($Bookingresponse['BookingId'])) {
         $BookingId =  implode(" ", $Bookingresponse['BookingId']);
        } else {
         $BookingId =  $Bookingresponse['BookingId'];          
        }
         $PriceChange = $Bookingresponse['PriceChange']['@attributes']['Status'];

         $guestfname = $_REQUEST['Room1AdultFirstName'][0];
         $guestlname =  $_REQUEST['Room1AdultLastName'][0];


         $insert_id = $this->Payment_Model->TBOBookingConfirm($this->session->userdata('agent_id'),$ClientReferenceNumber,$BookingId,$Bookingresponse['TripId'],$Bookingresponse['ConfirmationNo'],$Bookingresponse['BookingStatus'],$_REQUEST['hotel_name'],$_REQUEST['RoomTypeName'][0],$_REQUEST['Check_in'],$_REQUEST['Check_out'],$_REQUEST['tot'],$_REQUEST['no_of_days'],$_REQUEST['no_of_rooms'],$_REQUEST['hotel_id'],$PriceChange,$admin_markup,$guestfname,$guestlname);
         if($type=='Credit') {
          $agent_credit_get = $this->Payment_Model->agent_credit_get();
          $agent_amount = $agent_credit_get-$_REQUEST['tot'];
          if ($data['RequestType']=='Book') {
            $sub_agent_price_update = $this->Payment_Model->agent_price_update($agent_amount);
            $this->Payment_Model->agent_amount_status_update($agent_credit_get,$discountAmount,$insert_id);
          }
        } else {
          $this->Payment_Model->add_xml_payment_records($data,$insert_id);
        }
        $this->session->set_flashdata('message', 'Booked Successfully');
        redirect('../hotels');
      } else {
        log_message('custom', 'TBO BOOKING : '.$Bookingresponse['Status']['Description']);
        $this->session->set_flashdata('failed', 'Booking Failed');
        redirect('../hotels');
      }
    }
    public function roomredirectdata() {
      $this->session->set_userdata('roomdata'.$_REQUEST['hotel_id'],$_REQUEST['RoomData']);
      echo json_encode(true);
    }
    public function hotelBook() {
      if ($this->session->userdata('agent_id')=="") {
        redirect(base_url());
      }
      if (!isset($_REQUEST['adults'][0])) {
        redirect('../hotels');
      }
      $bookbuttondata = $this->session->userdata('hoteldata');
      $data['view'] = $this->Payment_Model->hotelDetails($_REQUEST['hotel_id']);
      $hotel_facilities = explode(",",$data['view'][0]->hotel_facilities); 
      foreach ($hotel_facilities as $key => $value) {
        $data['hotel_facilities'][$key] = $this->List_Model->hotel_facilities_data($value);
      }

      $room_facilities = explode(",",$data['view'][0]->room_facilities); 
      foreach ($room_facilities as $key => $value) {
        $data['room_facilities'][$key] = $this->List_Model->room_facilities_data($value);
      }
      $contracts =$this->List_Model->contractchecking($_REQUEST);
      $Rooms = $this->Hotels_Model->select_hotel_room($_REQUEST['hotel_id'])->result();
      $agent_markup = mark_up_get()+general_mark_up_get();

      // print_r($_REQUEST['adults']);
      // exit();
      $rooms = array();
      for ($i=0; $i < count($_REQUEST['adults']); $i++) { 
        foreach ($Rooms as $key => $value) {
          foreach ($contracts['contract_id'] as $key1 => $value1) {
            $revenue_markup = revenue_markup($_REQUEST['hotel_id'],$value1,$this->session->userdata('agent_id'));
            $total_markup = $agent_markup;
            if ($revenue_markup!='') {
              $total_markup = $revenue_markup+mark_up_get();
            }
            $contractBoardget = $this->List_Model->contractBoardget($_REQUEST['hotel_id'],$value1);
            $room_current_count_price = $this->List_Model->room_current_count_price($value->room_id,$_REQUEST['Check_in'],$_REQUEST['Check_out'],$value1,$_REQUEST['adults'][$i],$_REQUEST['Child'][$i],$_REQUEST,$total_markup,$value1,$i+1);
            $room_closedout = $this->List_Model->all_closedout_room($_REQUEST['hotel_id'],$value1,$_REQUEST,$value);
            $minimumStay = $this->List_Model->minimumStayCheckAvailability($_REQUEST,$value->room_id);
              if($room_closedout['condition']!=1 && $minimumStay=="true" && $room_current_count_price['price']!=0 && $room_current_count_price['condition']!="false") {
                $rooms[$i]['RoomName'][] = $value->room_name.' '.$value->Room_Type;
                $index = array();
                for($m=0;$m<count($_REQUEST['adults']);$m++){
                  $index[$m] = $value1.'-'.$value->room_id;
                } 
                $rooms[$i]['Index'][]['RoomIndex'] = $index;
                $rooms[$i]['RoomIndex'][] = $value1.'-'.$value->room_id;
                $rooms[$i]['room_id'][] = $value->room_id;
                $rooms[$i]['board'][] = $contractBoardget->board;
                $rooms[$i]['contract_id'][] = $value1;
                $rooms[$i]['price'][] = $room_current_count_price['price'];
                $rooms[$i]['general'][] = $room_current_count_price['generalsupplementType'];
                $rooms[$i]['extrabed'][] = $room_current_count_price['extrabedType'];
                $rooms[$i]['Boardsupplement'][] = $room_current_count_price['BoardsupplementType'];
                $rooms[$i]['CancellationPolicy'][] = $this->Payment_Model->get_CancellationPolicy_table($_REQUEST,$value1,$value->room_id);
                $rooms[$i]['generalsupplementType'][] = count($room_current_count_price['generalsupplementType'])!=0 ? array_unique($room_current_count_price['generalsupplementType']) : array();
                if ($room_current_count_price['allotement']> 0) {
                  $rooms[$i]['RequestType'][] = 'Book';
                } else {
                  $rooms[$i]['RequestType'][] = 'On Request';
                }
              }
          }
        }
      }

      $data['rooms'] = $rooms; 
      //print_r(array_column($data['rooms'], 'generalsupplementType'));exit;
      $RoomCombination = array_column($data['rooms'], 'Index');
      $data['RoomCombination'] = count($rooms)!=0 ? $RoomCombination[0] : '';
      $data['agent_info'] = $this->Common_Model->agent_info();
      $this->load->view('frontend/hotelbook',$data);
    }
    public function searchRoomdata() {
      $agent_markup = mark_up_get();
      $admin_markup = general_mark_up_get();
      $revenue_markup =  xmlrevenue_markup('tbo',$this->session->userdata('agent_id'));

      $total_markup = $agent_markup+$admin_markup;
      if ($revenue_markup!='') {
        $total_markup = $agent_markup+$revenue_markup;
      }
      $path  = get_upload_path_by_type('searchRoomdata') . $this->session->userdata('agent_id') . '/';
      $myFile = $path.date('Ymd').'-'.$_REQUEST['hotel_id'].'.txt';
      $temparray = file_get_contents($myFile);
      $HotelRoom = json_decode($temparray,true);
      $return = array_slice($HotelRoom, ($_REQUEST['offset']*$_REQUEST['perpage']), $_REQUEST['perpage']); 
      if (count($return)!=0) {
      
      if (isset($return[0])) {
        $HotelRooms = $return;
      } else {
        $HotelRooms[0] = $return;
      }
      $data = '';
      foreach ($HotelRooms as $key => $value) {
        $board = count($value['Inclusion'])!=0 ? $value['Inclusion'] : 'Room Only';
        if (isset($value['CancelPolicies']['CancelPolicy'][0])) {
            $cancelList = $value['CancelPolicies']['CancelPolicy'];
          } else {
            $cancelList[0] = $value['CancelPolicies']['CancelPolicy'];
         } 
         $NoShowPolicy = array();
         if (isset($value['CancelPolicies']['NoShowPolicy'])) {
           if (isset($value['CancelPolicies']['CancelPolicy'][0])) {
              $NoShowPolicy = $value['CancelPolicies']['NoShowPolicy'];
            } else {
              $NoShowPolicy[0] = $value['CancelPolicies']['NoShowPolicy'];
           } 
         } 

        if(isset($cancelList[0]['@attributes']) && $cancelList[0]['@attributes']['CancellationCharge']==0) {
           $cancellationTab = '<span class="pull-right" data-toggle="modal" data-target="#myModalRoom-'.$value['RoomIndex'].'">Free of Cancellation till '.$cancelList[0]['@attributes']['ToDate'].' <span>';
         } else { 
            $cancellationTab = '<span class="pull-right" data-toggle="modal" data-target="#myModalRoom-'.$value['RoomIndex'].'">cancellation<span>';
          } 

        $data .= '<li id="listRoom1'.$value['RoomIndex'].'" class="hide">
                  <label for="Room1'.$value['RoomIndex'].'">
                    <input type="radio" name="Room1" id="Room1'.$value['RoomIndex'].'" class="roomval" value="'.$value['RoomIndex'].'">
                    <div class="av-div">
                       <h5 class="r-type--name m-0"><i class="fa fa-check-circle text-green"></i><i class="fa fa-circle-thin text-green" style="    margin-right: 2px;"></i>'.$value['RoomTypeName'].' - '.$board.$cancellationTab.'
                        </h5>';

                      
                       if(!is_array($value['Inclusion']) && count($value['Inclusion'])!=0) {
                        $data .= '<small class="r-type-includes">'.is_array($value['Inclusion']) && count($value['Inclusion'])==0 ? '' : $value['Inclusion'].'</small><br>';
                      } 
                      if (isset($value['Supplements']['Supplement'][0])) {
                        $Supplements = $value['Supplements']['Supplement'];
                      } else {
                        $Supplements[0] = $value['Supplements']['Supplement'];
                      }
                      foreach ($Supplements as $key1 => $value1) {
                        if (isset($value1['@attributes']['SuppName'])) { 
                          $suppl = $value1['@attributes']['Price'];
                          $supplAmnt = ($suppl*$total_markup)/100+$suppl;
                          $suptype = $value1['@attributes']['SuppChargeType']=="AtProperty" ? '<span style="color: #0074b9;" title="Exclusive">Excl.</span> ' : '<span style="color: #0074b9;" title="Inclusive">Incl.</span>'.$value1['@attributes']['CurrencyCode'];
                            $data .= '<p class="m-0" style="color: hsl(240, 8%, 69%)">
                            <small>'.$value1['@attributes']['SuppName'].' - '.$suptype.' '.$suppl.'</small>
                          </p>';

                       }
                      } 
                      $DayRates = $value['RoomRate']['@attributes']['TotalFare'];
                        $DayRates = ($DayRates*$total_markup)/100+$DayRates; 
                       $data .= '<p class="text-green m-0 bold">
                        <input type="hidden" class="com-amnt" value="'.xml_currency_change($DayRates,$value['RoomRate']['@attributes']['Currency'],agent_currency()).'">
                        <small>'.agent_currency().' '.xml_currency_change($DayRates,$value['RoomRate']['@attributes']['Currency'],agent_currency()).'</small>
                      </p>
                    </div>
                  </label>
                </li>
                <div id="myModalRoom-'.$value['RoomIndex'].'" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-sm">
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
                                    <tbody style="background: white;color: black;">';
                                        if (isset($cancelList[0]['@attributes'])) {
                                          foreach ($cancelList as $key => $value1) {
                                            if($value1['@attributes']['ChargeType']=='Percentage') { 
                                              $disType =  ' %'; 
                                            } else { 
                                               $disType = ' USD'; 
                                            }

                                        $data .= '<tr>
                                          <td>'.$value1['@attributes']['FromDate'].'</td>
                                          <td>'.$value1['@attributes']['ToDate'].'</td>
                                          <td>'.$value1['@attributes']['CancellationCharge'].$disType.'</td>
                                        </tr>';
                                     } } 
                                    
                                        if (isset($NoShowPolicy[0]['@attributes'])) {
                                          foreach ($NoShowPolicy as $key => $value1) {
                                          if($value1['@attributes']['ChargeType']=='Percentage') { 
                                            $disType =  ' %'; 
                                          } else { 
                                             $disType = ' USD'; 
                                          }
                                      $data .= '<tr>
                                        <td>'.$value1['@attributes']['FromDate'].'</td>
                                        <td>'.$value1['@attributes']['ToDate'].'</td>
                                        <td>'.$value1['@attributes']['CancellationCharge'].'</td>
                                      </tr>';
                                     } } 
                                    $data .= '<tr>
                                      <td colspan="3">
                                        '.$value['CancelPolicies']['DefaultPolicy'].'
                                      </td>
                                    </tr>
                                    </tbody>
                                  </table>
                              </div>
                            </div>
                          </div>
                </div>';
        }
        echo $data;
      } else {
        echo 0;
      }
    }
}

