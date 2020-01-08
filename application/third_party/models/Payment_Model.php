<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_Model extends CI_Model {
 
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function hotel_details_view($id) {
        $this->db->select('*');
        $this->db->from('hotel_tbl_hotel_room_type');
        $this->db->join('hotel_tbl_hotels','hotel_tbl_hotel_room_type.hotel_id = hotel_tbl_hotels.id', 'left');
        // $this->db->join('hotel_tbl_policies','hotel_tbl_hotels.id = hotel_tbl_policies.hotel_id', 'left');
        // $this->db->from('hotel_tbl_room_type');
        $this->db->join('hotel_tbl_room_type','hotel_tbl_hotel_room_type.room_type = hotel_tbl_room_type.id', 'left');
        $this->db->where('hotel_tbl_hotel_room_type.delflg',1);
        $this->db->where('hotel_tbl_hotels.delflg',1);
        $this->db->where('hotel_tbl_room_type.delflg',1);
        $this->db->where('hotel_tbl_hotel_room_type.id',$id);
        // $this->db->where('id',$id);
        $query=$this->db->get();
        return $query->result();
    }
    public function get_policy_contract($hotel_id,$contract_id){
        $this->db->select('*');
        $this->db->from('hotel_tbl_policies');
        $this->db->where('hotel_id',$hotel_id);
        $this->db->where('contract_id',$contract_id);
        $query = $this->db->get();
        return $query->result();
    }
    public function room_booking_add($datas) {
        $this->db->insert('hotel_tbl_booking',$datas);
        $bool_id = $this->db->insert_id();
        return $bool_id;
    }
    public function max_booking_id() {
        $this->db->select_max('id');
        $this->db->from('hotel_tbl_booking');
        $query=$this->db->get();
        return $query->result();
    }
    public function room_price_get($id) {
        $this->db->select('price');
        $this->db->where('id',$id);
        $this->db->from('hotel_tbl_hotel_room_type');
        $query=$this->db->get();
        return $query->result();
    }
    public function agent_currency_type() {
        $id = $this->session->userdata('agent_id');
        $this->db->select('Preferred_Currency');
        $this->db->where('id',$id);
        $this->db->from('hotel_tbl_agents');
        $query=$this->db->get();
        $result = $query->result();
        return $result[0]->Preferred_Currency;
    }
    public function agent_credit_get() {
       $id = $this->session->userdata('agent_id');
        $this->db->select('Credit_amount');
        $this->db->where('id',$id);
        $this->db->from('hotel_tbl_agents');
        $query=$this->db->get();
        $result = $query->result();
        return $result[0]->Credit_amount;
    }
    public function agent_price_update($amount) {
      $id = $this->session->userdata('agent_id');
      $datas= array(
                    'Credit_amount' => $amount);
      $this->db->where('id',$id);
      $this->db->update('hotel_tbl_agents',$datas);
      return true;
    }
    public function agent_booking_list($filter) {
      $id = $this->session->userdata('agent_id');
      $this->db->select('hotel_tbl_booking.id as bk_id,hotel_tbl_booking.* ,hotel_tbl_booking.booking_id as book_id, hotel_tbl_hotels.hotel_name, ,hotel_tbl_room_type.Room_Type');
      $this->db->from('hotel_tbl_booking');
      $this->db->distinct();
      $this->db->join('hotel_tbl_hotels','hotel_tbl_booking.hotel_id = hotel_tbl_hotels.id', 'left');
      $this->db->join('hotel_tbl_hotel_room_type','hotel_tbl_booking.room_id = hotel_tbl_hotel_room_type.id', 'left');
      $this->db->join('hotel_tbl_room_type','hotel_tbl_hotel_room_type.room_type = hotel_tbl_room_type.id', 'left');
      $this->db->join('hotel_tbl_bookingboard','hotel_tbl_booking.id = hotel_tbl_bookingboard.bookingID', 'left');
      $this->db->join('hotel_tbl_bookgeneralsupplement','hotel_tbl_booking.id = hotel_tbl_bookgeneralsupplement.bookingID', 'left');
      $this->db->where('hotel_tbl_booking.agent_id',$id);
      $this->db->where('hotel_tbl_booking.booking_flag',$filter);
      $this->db->order_by('hotel_tbl_booking.id','desc');
      // $this->db->where('hotel_tbl_booking.booking_flag !=',3);
      return $query=$this->db->get();
    } 
    public function agent_booking_detail($book_id) {
      $this->db->select('hotel_tbl_booking.booking_id as bk_id,hotel_tbl_booking.*,hotel_tbl_hotels.*,hotel_tbl_hotel_room_type.*,hotel_tbl_room_type.*,hotel_tbl_agents.*,hotel_tbl_policies.*,hotel_tbl_booking.Created_Date as booking_date,hotel_tbl_booking.board as boardName');
      $this->db->from('hotel_tbl_booking');
      $this->db->join('hotel_tbl_hotels','hotel_tbl_booking.hotel_id = hotel_tbl_hotels.id', 'left');
      $this->db->join('hotel_tbl_hotel_room_type','hotel_tbl_booking.room_id = hotel_tbl_hotel_room_type.id', 'left');
      $this->db->join('hotel_tbl_room_type','hotel_tbl_hotel_room_type.room_type = hotel_tbl_room_type.id', 'left');
      $this->db->join('hotel_tbl_agents','hotel_tbl_booking.agent_id = hotel_tbl_agents.id', 'left');
      $this->db->join('hotel_tbl_policies','hotel_tbl_booking.hotel_id = hotel_tbl_policies.hotel_id', 'left');
      $this->db->where('hotel_tbl_booking.id',$book_id);
      // $this->db->where('hotel_tbl_booking.booking_flag !=',3);
      $query=$this->db->get();
      return $query->result();
    } 
    public function board_booking_detail($book_id) {
      $this->db->select('*');
      $this->db->from('hotel_tbl_bookingboard');
      $this->db->where('bookingID',$book_id);
      $query = $this->db->get();
      return $query->result();
    }
    public function general_booking_detail($book_id) {
      $this->db->select('*');
      $this->db->from('hotel_tbl_bookgeneralsupplement');
      $this->db->where('bookingID',$book_id);
      $query = $this->db->get();
      return $query->result();
    }
    public function agent_booking_cancel($id) {
      $datas = array(
        'booking_flag' => '5',
        'Updated_Date' => date('Y-m-d H:i:s'),
        'Updated_By' => '');
      $this->db->where('id',$id);
      $this->db->update('hotel_tbl_booking',$datas);


      $this->db->select('*');
      $this->db->from('hotel_tbl_user');
      $query1=$this->db->get();
      $result1 = $query1->result();
      foreach ($result1 as $key => $value) {
        $user_id[] = $value->id;
      }
      $implode = implode(",", $user_id);
      $agent_id = $this->session->userdata('agent_id');
      $data = array('user_id' => $implode,
                    'agent_id' => $agent_id,
                    'rejected' => 0,
                    'notification_type' => 'booking Cancelled',
                    'notification_msg' => 'You have new booking Cancelled Request');
      $this->db->insert('hotel_tbl_notification',$data);

      $datas1 = array('user_id' => $implode,
                'notification_type' => 'hotel_booking_cancelled');

      $this->db->insert('hotel_tbl_notifications_list',$datas1);
      return true;
    }
    public function general_tax($id) {
      $this->db->select('tax_percentage');
      $this->db->from('hotel_tbl_contract');
      $this->db->where('hotel_id',$id);
      $query=$this->db->get();
      $result = $query->result();
      if (count($result)!=0) {
        return $result[0]->tax_percentage;
      }
      return 0;
    }
    public function agent_booking_profit_list() {
      $id = $this->session->userdata('agent_id');
      $this->db->select('hotel_tbl_booking.id as bk_id, hotel_tbl_booking.* , hotel_tbl_hotels.hotel_name, ,hotel_tbl_room_type.Room_Type');
      $this->db->distinct();
      $this->db->from('hotel_tbl_booking');
      $this->db->join('hotel_tbl_hotels','hotel_tbl_booking.hotel_id = hotel_tbl_hotels.id', 'left');
      $this->db->join('hotel_tbl_hotel_room_type','hotel_tbl_booking.room_id = hotel_tbl_hotel_room_type.id', 'left');
      $this->db->join('hotel_tbl_room_type','hotel_tbl_hotel_room_type.room_type = hotel_tbl_room_type.id', 'left');
      $this->db->join('hotel_tbl_bookingboard','hotel_tbl_booking.id = hotel_tbl_bookingboard.bookingID', 'left');
      $this->db->join('hotel_tbl_bookgeneralsupplement','hotel_tbl_booking.id = hotel_tbl_bookgeneralsupplement.bookingID', 'left');
      $this->db->where('hotel_tbl_booking.agent_id',$id);
      $this->db->where('hotel_tbl_booking.booking_flag',1);
      // $this->db->where('hotel_tbl_booking.booking_flag !=',0);
      // $this->db->where('hotel_tbl_booking.booking_flag !=',2);
      $this->db->order_by('hotel_tbl_booking.id','desc');
      return $query=$this->db->get();
    } 
    public function agent_credit_amount() {
      $id = $this->session->userdata('agent_id');
      $this->db->select('Credit_amount');
      $this->db->from('hotel_tbl_agents');
      $this->db->where('id',$id);
      $query=$this->db->get();
      $result = $query->result();
      return $result[0]->Credit_amount;
    }
    public function agent_currency_typesss() {
      $id = $this->session->userdata('agent_id');
      $this->db->select('Preferred_Currency');
      $this->db->from('hotel_tbl_agents');
      $this->db->where('id',$id);
      $query=$this->db->get();
      $result = $query->result();
      return $result[0]->Preferred_Currency;
    }
    public function add_agent_credit($agent_id,$amount) {
      $datas= array(
                    'Credit_amount' => $amount);
      $this->db->where('id',$agent_id);
      $this->db->update('hotel_tbl_agents',$datas);
      return true;
    }
    public function get_current_agent_credit($agent_id) {
      $this->db->select('Credit_amount');
      $this->db->from('hotel_tbl_agents');
      $this->db->where('id',$agent_id);
      $query = $this->db->get();
      return $query->result();
    }
    public function insert_agent_detail($agent_id,$credit,$total,$createdBy) {
      $data = array
              ('Agent_id' => $agent_id, 
                'credit_amount' => $credit,
                'Total_credit' => $total,
                'narration' => 'Refund',
                'created_date' => date('Y-m-d H:i:s'),
                'created_by' => $createdBy,
              );
      $this->db->insert('hotel_tbl_agent_credit_detail',$data);
    }
    public function agent_invoice_list() {
      $id = $this->session->userdata('agent_id');
      $this->db->select('hotel_tbl_booking.id as bk_id,hotel_tbl_booking.* ,hotel_tbl_booking.booking_id as book_id, hotel_tbl_hotels.hotel_name, ,hotel_tbl_room_type.Room_Type');
      $this->db->distinct();
      $this->db->from('hotel_tbl_booking');
      $this->db->join('hotel_tbl_hotels','hotel_tbl_booking.hotel_id = hotel_tbl_hotels.id', 'left');
      $this->db->join('hotel_tbl_hotel_room_type','hotel_tbl_booking.room_id = hotel_tbl_hotel_room_type.id', 'left');
      $this->db->join('hotel_tbl_room_type','hotel_tbl_hotel_room_type.room_type = hotel_tbl_room_type.id', 'left');
      $this->db->join('hotel_tbl_bookingboard','hotel_tbl_booking.id = hotel_tbl_bookingboard.bookingID', 'left');
      $this->db->join('hotel_tbl_bookgeneralsupplement','hotel_tbl_booking.id = hotel_tbl_bookgeneralsupplement.bookingID', 'left');
      $this->db->where('hotel_tbl_booking.agent_id',$id);
      $this->db->where('hotel_tbl_booking.booking_flag',1);
      $this->db->order_by('hotel_tbl_booking.id','desc');
      return $query=$this->db->get();
    }
    public function agent_amount_status_update($credit_amt ,$used_amt,$booking_id) {
      $datas= array(
                    'Credit_amount' => $credit_amt,
                    'used_amount' => $used_amt,
                    'booking_id' => $booking_id,
                    'date' => date('Y-m-d H:i:s'),
                    'agent_id' =>  $this->session->userdata('agent_id'),
                  );
      $this->db->insert('hotels_tbl_agent_amount_status',$datas);
      return true;
    }
    public function confirm_notification($agent_id,$hotel_id,$book_id) {
      $this->db->select('*');
      $this->db->from('hotel_tbl_user');
      $query=$this->db->get();
      $result = $query->result();
      foreach ($result as $key => $value) {
        $user_id[] = $value->id;
      }
      $implode = implode(",", $user_id);
      $date = date('Y-m-d H:i:s');
      $data = array('user_id'           => $implode,
                    'hotel_id'          => $hotel_id,
                    'agent_id'          => $agent_id,
                    'booking_id'        => $book_id,
                    'rejected'          => 2,
                    'notification_date' => $date,
                    'notification_type' => 'booked',
                    'notification_msg' => 'You have new booking Request');
      $this->db->insert('hotel_tbl_notification',$data);

      $datas1 = array('user_id' => $implode,
                'notification_type' => 'hotel_booking_request');

      $this->db->insert('hotel_tbl_notifications_list',$datas1);
      return true;
    }
    public function notification_off($booking_id) {
      $data= array('readed' => 2,);
      $this->db->where('booking_id',$booking_id);
      $this->db->update('hotel_tbl_notification',$data);
      return true;
    }
    public function clear_all_notifications($id){
      $data= array('readed' => 2,);
      $this->db->where('agent_id',$id);
      $this->db->update('hotel_tbl_notification',$data);
      return true;
    }
    public function get_board_supplement($request) {
      $adultBoardAmount = array();
      $childBoardAmount = array();
      $childBoardcnt = array();
      $childBoardcount = array();
      $childBoardAge = array();
      $adultAmount = array();
      $childAmount = array();
      $return = array();
      $bsarraySum = array();
      $adultscount = array_sum($request['adults']);
      $childscount = array_sum($request['Child']);
      $roomType = $this->db->query("SELECT * FROM hotel_tbl_hotel_room_type WHERE id = '".$request['room_id']."'")->result();
      $checkin_date=date_create($request['Check_in']);
      $checkout_date=date_create($request['Check_out']);
      $no_of_days=date_diff($checkin_date,$checkout_date);
      $tot_days = $no_of_days->format("%a");
      for($i = 0; $i < $tot_days; $i++) {
        $date[$i] = date('Y-m-d', strtotime($request['Check_in']. ' + '.$i.'  days'));
        $dateFormatdate[$i] = date('d/m/Y', strtotime($request['Check_in']. ' + '.$i.'  days'));
        $dateFormatday[$i] = date('D', strtotime($request['Check_in']. ' + '.$i.'  days'));
        if (isset($request['board'])) {
          foreach ($request['board'] as $key => $value) {
              $boardSplmntCheck[$i] = $this->db->query("SELECT * FROM hotel_tbl_boardsupplement WHERE '".$date[$i]."' BETWEEN fromDate AND toDate AND contract_id = '".$request['contract_id']."' AND hotel_id = '".$request['hotel_id']."' AND board = '".$value."'")->result();
              $bsarraySum[$i] = count($boardSplmntCheck[$i]);
              foreach ($boardSplmntCheck[$i] as $key1 => $value1) {
                $explodeBoardroomtype[$key1] = explode(",", $value1->roomType);
                foreach ($explodeBoardroomtype[$key1] as $key2 => $value2) {
                  
                  if ($value2==$roomType[0]->id) {
                    if ($request['max_child_age'] < $value1->startAge || $request['max_child_age'] < $value1->finalAge) 
                    {
                      $adultBoardAmount[$value] = $value1->amount;
                    } 
                    // if($request['max_child_age'] >= $value1->finalAge) {
                        $childBoardcnt[$value][$key1] = array();
                        for ($j=1; $j <= count($request['Child']); $j++) { 
                          if (isset($request['room'.$j.'-childAge'])) {
                            foreach ($request['room'.$j.'-childAge'] as $key4 => $value4) {
                              if ($value1->startAge <= $value4 && $value1->finalAge >= $value4) {
                                $childBoardcnt[$value][$key1][] = $value4;
                              } 
                            }
                          }
                        }
                        if (count($childBoardcnt[$value][$key1])!=0) {
                          $childBoardcount[$value][$key1] = count($childBoardcnt[$value][$key1]);
                          $childBoardAge[$value][$key1] = $value1->startAge." to ".$value1->finalAge;
                          $childBoardAmount[$value][$key1] = $value1->amount;
                        } 
                    // }
                  }
                }
            }
          }   
        }   
        $return['date'][$i] = $dateFormatdate[$i];
        $return['day'][$i] = $dateFormatday[$i];
        $return['adultamount'][$i] = $adultBoardAmount;
        $return['childamount'][$i] = $childBoardAmount;
        $return['childcount'][$i] = $childBoardcount;
        $return['childage'][$i] = $childBoardAge;
        $return['board'][$i] = $request['board'];
          
      }
      $return['bsCount'] = array_sum($bsarraySum);
      return $return;
    }
    public function get_general_supplement($request) {
      /*Standard capacity get from rooms start*/

      $this->db->select('*');
      $this->db->from('hotel_tbl_hotel_room_type');
      $this->db->where('hotel_id',$request['hotel_id']);
      $this->db->where('id',$request['room_id']);
      $Rmquery = $this->db->get();
      $Rmrow_values  = $Rmquery->row_array();
      $occupancyAdult = $Rmrow_values['occupancy'];
      $occupancyChild = $Rmrow_values['occupancy_child'];
      $standard_capacity = $Rmrow_values['standard_capacity'];

      /*Standard capacity get from rooms end*/

      $adultAmount =array();
      $return = array();
      $RWadultAmount = array();
      $childAmount =array();
      $RWchildAmount = array();
      $generalsupplementType = array();
      $boardSplmntCheck  = array();
      $gsarraySum = array();
      $mangsarraySum = array();
      $ManadultAmount  = array();
      $MangeneralsupplementforAdults = array();
      $ManchildAmount = array();
      $MangeneralsupplementforChilds = array();
      $MangeneralsupplementType = array();
      $extrabedAmount = array();

      $roomType = $this->db->query("SELECT * FROM hotel_tbl_hotel_room_type WHERE id = '".$request['room_id']."'")->result();
      // print_r($request);
      $checkin_date=date_create($request['Check_in']);
      $checkout_date=date_create($request['Check_out']);
      $no_of_days=date_diff($checkin_date,$checkout_date);
      $tot_days = $no_of_days->format("%a");
      for($i = 0; $i < $tot_days; $i++) {
        $date[$i] = date('Y-m-d', strtotime($request['Check_in']. ' + '.$i.'  days'));
        $dateFormatdate[$i] = date('d/m/Y', strtotime($request['Check_in']. ' + '.$i.'  days'));
        $dateFormatday[$i] = date('D', strtotime($request['Check_in']. ' + '.$i.'  days'));
        
        /*Mandatory General Supplement start*/
        $adultAmount =array();
        $RWadultAmount = array();
        $generalSplmntCheck[$i] = $this->db->query("SELECT * FROM hotel_tbl_generalsupplement WHERE '".$date[$i]."' BETWEEN fromDate AND toDate AND contract_id = '".$request['contract_id']."'  AND hotel_id = '".$request['hotel_id']."'  AND mandatory = 1")->result();
          $gsarraySum[$i] = count($generalSplmntCheck[$i]);
        if (count($generalSplmntCheck[$i])!=0) {
          foreach ($generalSplmntCheck[$i] as $key1 => $value1) {
                $explodeRoomType[$key1] = explode(",", $value1->roomType);
                foreach ($explodeRoomType[$key1] as $key4 => $value4) {
                    if ($value4==$roomType[0]->id) {
                      if ($value1->application=="Per Person") {
                        if (round($value1->adultAmount)!=0) {
                          $adultAmount[$value1->type] = $value1->adultAmount*array_sum($request['adults']);
                        }
                        for ($j=1; $j <= count($request['adults']); $j++) {
                          if (round($value1->adultAmount)!=0) {
                            $RWadultAmount[$value1->type][$j] = $value1->adultAmount*$request['adults'][$j-1];
                          }
                          if (isset($request['room'.$j.'-childAge'])) {
                            foreach ($request['room'.$j.'-childAge'] as $key44 => $value44) {
                              if ($value1->MinChildAge < $value44) {
                                if (round($value1->childAmount)!=0) {
                                  $childAmount[$value1->type] = $value1->childAmount;
                                  $RWchildAmount[$value1->type][$j][$key44] = $value1->childAmount;
                                }
                              } 
                            }

                          }

                        }
                      } else {
                        if (round($value1->adultAmount)!=0) {
                          $adultAmount[$value1->type] = $value1->adultAmount*count($request['adults']);
                           $RWadultAmount[$value1->type][1] = $value1->adultAmount*count($request['adults']);
                        }
                      }
                      $generalsupplementType[$key1] = $value1->type;
                    }
                }
                
            }
        }
        /*Mandatory General Supplement end*/
        $return['date'][$i] = $dateFormatdate[$i];
        $return['day'][$i] = $dateFormatday[$i];
        $return['adultamount'][$i] = $adultAmount;
        $return['RWadultamount'][$i] = $RWadultAmount;
        $return['childamount'][$i] = $childAmount;
        $return['RWchildAmount'][$i] = $RWchildAmount;
        $return['general'][$i] = array_unique($generalsupplementType);
        $return['ManadultAmount'][$i] = $ManadultAmount;
        $return['ManchildAmount'][$i] = $ManchildAmount;
        $return['ManchildAmount'][$i] = $ManchildAmount;
        $return['Manadultcount'][$i] = $MangeneralsupplementforAdults;
        $return['Manchildcount'][$i] = $MangeneralsupplementforChilds;
        $return['mangeneral'][$i] = array_unique($MangeneralsupplementType);
      }
      $return['gnlCount'] = array_sum($gsarraySum)+array_sum($mangsarraySum);
      return $return;
    }
    public function get_PaymentConfirmboard_supplement($request) {
      $adultBoardAmount = array();
      $childBoardAmount = array();
      $childBoardcnt = array();
      $childBoardcount = array();
      $childBoardAge = array();
      $adultAmount = array();
      $childAmount = array();
      $return = array();
      $bsarraySum = array();
      $adultscount = array_sum($request['reqadults']);
      $childscount = array_sum($request['reqChild']);
      $roomType = $this->db->query("SELECT * FROM hotel_tbl_hotel_room_type WHERE id = '".$request['room_id']."'")->result();
      $checkin_date=date_create($request['Check_in']);
      $checkout_date=date_create($request['Check_out']);
      $no_of_days=date_diff($checkin_date,$checkout_date);
      $tot_days = $no_of_days->format("%a");
      for($i = 0; $i < $tot_days; $i++) {
        $date[$i] = date('Y-m-d', strtotime($request['Check_in']. ' + '.$i.'  days'));
        $dateFormatdate[$i] = date('d/m/Y', strtotime($request['Check_in']. ' + '.$i.'  days'));
        $dateFormatday[$i] = date('D', strtotime($request['Check_in']. ' + '.$i.'  days'));
        if (isset($request['board'])) {
          foreach ($request['board'] as $key => $value) {
              $boardSplmntCheck[$i] = $this->db->query("SELECT * FROM hotel_tbl_boardsupplement WHERE '".$date[$i]."' BETWEEN fromDate AND toDate AND contract_id = '".$request['contract_id']."' AND hotel_id = '".$request['hotel_id']."' AND board = '".$value."'")->result();
              $bsarraySum[$i] = count($boardSplmntCheck[$i]);
              foreach ($boardSplmntCheck[$i] as $key1 => $value1) {
                $explodeBoardroomtype[$key1] = explode(",", $value1->roomType);
                foreach ($explodeBoardroomtype[$key1] as $key2 => $value2) {
                  
                  if ($value2==$roomType[0]->id) {
                    if ($request['max_child_age'] < $value1->startAge || $request['max_child_age'] < $value1->finalAge) 
                    {
                      $adultBoardAmount[$value] = $value1->amount;
                    } 
                    // if($request['max_child_age'] >= $value1->finalAge) {

                        $childBoardcnt[$value][$key1] = array();
                        for ($j=1; $j <= count($request['reqadults']); $j++) { 
                          if (isset($request['reqroom'.$j.'-childAge'])) {

                            foreach ($request['reqroom'.$j.'-childAge'] as $key4 => $value4) {
                              if ($value1->startAge <= $value4 && $value1->finalAge >= $value4) {
                                $childBoardcnt[$value][$key1][] = $value4;
                              } 
                            }
                          }
                        }
                        if (count($childBoardcnt[$value][$key1])!=0) {
                          $childBoardcount[$value][$key1] = count($childBoardcnt[$value][$key1]);
                          $childBoardAge[$value][$key1] = $value1->startAge." to ".$value1->finalAge;
                          $childBoardAmount[$value][$key1] = $value1->amount;
                        } 
                    // }
                  }
                }
            }
          }   
        }   
        $return['date'][$i] = $dateFormatdate[$i];
        $return['day'][$i] = $dateFormatday[$i];
        $return['adultamount'][$i] = $adultBoardAmount;
        $return['childamount'][$i] = $childBoardAmount;
        $return['childcount'][$i] = $childBoardcount;
        $return['childage'][$i] = $childBoardAge;
        $return['board'][$i] = $request['board'];
          
      }
      $return['bsCount'] = array_sum($bsarraySum);
      return $return;
    }
    public function bkboardSupplementConfirm($stayDate, $BookingDate, $board, $adultamount, $childage, $childAmount, $agent_markup, $total_markup, $admin_markup,$booking_id,$reqadults,$reqchildCount,$rwadult,$rwadultamount,$rwchild,$rwchildAmount,$contract_id,$room_id,$index) {
      $datas= array(
                  'bookingID' =>$booking_id,
                  'stayDate' =>$stayDate,
                  'BookingDate' =>$BookingDate,
                  'board' =>$board,
                  'adultamount' =>$adultamount,
                  'childage' =>$childage,
                  'childAmount' =>$childAmount,
                  'agent_markup' =>$agent_markup,
                  'total_markup' =>$total_markup,
                  'admin_markup' =>$admin_markup,
                  'Breqadults' => $reqadults,
                  'BreqchildCount' => $reqchildCount,
                  'Rwadult' => $rwadult,
                  'RwadultAmount' => $rwadultamount,
                  'Rwchild' => $rwchild,
                  'RwchildAmount' => $rwchildAmount,
                  'room_id' => $room_id,
                  'contract_id' => $contract_id,
                  'roomIndex' => $index,
                  'createdDate' => date('Y-m-d H:i:s'),
                  'createdBy' =>  $this->session->userdata('agent_id'),
                );
        $this->db->insert('hotel_tbl_bookingboard',$datas);
     return true;
    }
    public function bkgeneralSupplementConfirm($gstayDate, $gBookingDate, $generalType, $gadultamount , $gchildamount, $agent_markup, $total_markup, $admin_markup,$booking_id,$reqadults,$reqChild,$mand,$Rwadult,$Rwchild,$Rwadultamount,$RwchildAmount,$application,$room_id,$contract_id,$index) {
      $datas= array(
                  'bookingID' =>$booking_id,
                  'gstayDate' =>$gstayDate,
                  'gBookingDate' =>$gBookingDate,
                  'generalType' =>$generalType,
                  'gadultamount' =>$gadultamount,
                  'gchildamount' =>$gchildamount,
                  'agent_markup' =>$agent_markup,
                  'total_markup' =>$total_markup,
                  'admin_markup' =>$admin_markup,
                  'reqadults' =>$reqadults,
                  'reqChild' =>$reqChild,
                  'mandatory' =>$mand,
                  'Rwadult' =>$Rwadult,
                  'Rwchild' =>$Rwchild,
                  'Rwadultamount' =>$Rwadultamount,
                  'RwchildAmount' =>$RwchildAmount,
                  'application' => $application,
                  'room_id' => $room_id,
                  'contract_id' => $contract_id,
                  'roomIndex'   =>$index,
                  'createdDate' => date('Y-m-d H:i:s'),
                  'createdBy' =>  $this->session->userdata('agent_id'),
                );
        $this->db->insert('hotel_tbl_bookGeneralSupplement',$datas);
     return true;
    }
    public function get_Confirmgeneral_supplement($request,$contract_id,$room_id,$j) {

      /*Standard capacity get from rooms start*/

      $this->db->select('occupancy,occupancy_child,standard_capacity');
      $this->db->from('hotel_tbl_hotel_room_type');
      $this->db->where('hotel_id',$request['hotel_id']);
      $this->db->where('id',$room_id);
      $Rmquery = $this->db->get();
      $Rmrow_values  = $Rmquery->row_array();
      $occupancyAdult = $Rmrow_values['occupancy'];
      $occupancyChild = $Rmrow_values['occupancy_child'];
      $standard_capacity = $Rmrow_values['standard_capacity'];

      /*Standard capacity get from rooms end*/

      $return = array();
      $adultAmount =array();
      $RWadultAmount = array();
      $RWadult = array();
      $RWchild = array();
      $childAmount =array();
      $RWchildAmount = array();
      $generalsupplementType = array();
      $generalsupplementapplication = array();
      $boardSplmntCheck  = array();
      $gsarraySum = array();
      $mangsarraySum = array();
      $ManadultAmount  = array();
      $MangeneralsupplementforAdults = array();
      $ManchildAmount = array();
      $MangeneralsupplementforChilds = array();
      $MangeneralsupplementType = array();
      $roomType = $this->db->query("SELECT * FROM hotel_tbl_hotel_room_type WHERE id = '".$room_id."'")->result();
      // print_r($request);
      $checkin_date=date_create($request['Check_in']);
      $checkout_date=date_create($request['Check_out']);
      $no_of_days=date_diff($checkin_date,$checkout_date);
      $tot_days = $no_of_days->format("%a");
      for($i = 0; $i < $tot_days; $i++) {
        $date[$i] = date('Y-m-d', strtotime($request['Check_in']. ' + '.$i.'  days'));
        $dateFormatdate[$i] = date('d/m/Y', strtotime($request['Check_in']. ' + '.$i.'  days'));
        $dateFormatday[$i] = date('D', strtotime($request['Check_in']. ' + '.$i.'  days'));
        
        /*Mandatory General Supplement start*/
        $adultAmount =array();
        $RWadultAmount = array();
        $generalSplmntCheck[$i] = $this->db->query("SELECT * FROM hotel_tbl_generalsupplement WHERE '".$date[$i]."' BETWEEN fromDate AND toDate AND contract_id = '".$contract_id."'  AND hotel_id = '".$request['hotel_id']."'  AND mandatory = 1 AND FIND_IN_SET('".$room_id."', IFNULL(roomType,'')) > 0")->result();
          $gsarraySum[$i] = count($generalSplmntCheck[$i]);
        if (count($generalSplmntCheck[$i])!=0) {
          foreach ($generalSplmntCheck[$i] as $key1 => $value1) {
            if ($value1->application=="Per Person") {
              if (round($value1->adultAmount)!=0) {
                $adultAmount[$value1->type] = $value1->adultAmount*$request['reqadults'][$j-1];
              }
              if (round($value1->adultAmount)!=0) {
                $RWadultAmount[$value1->type][$j] = $value1->adultAmount*$request['reqadults'][$j-1];
                $RWadult[$value1->type][$j] = $j;
              }
              if (isset($request['reqroom'.$j.'-childAge'])) {
                foreach ($request['reqroom'.$j.'-childAge'] as $key44 => $value44) {
                  if ($value1->MinChildAge < $value44) {
                    if (round($value1->childAmount)!=0) {
                      $childAmount[$value1->type] = $value1->childAmount;
                      $RWchildAmount[$value1->type][$j][$key44] = $value1->childAmount;
                      $RWchild[$value1->type][$j] = $j;
                    }
                    // $childAmount[$value1->type] = $value1->childAmount;
                  } 
                }

              }
            } else {
              if (round($value1->adultAmount)!=0) {
                $adultAmount[$value1->type] = $value1->adultAmount;
                $childAmount[$value1->type] = 0;
                $RWadultAmount[$value1->type][1] = $value1->adultAmount;
                $RWadult[$value1->type][1] = 1;
              }
            }
            $generalsupplementType[$key1] = $value1->type;
            $generalsupplementapplication[$key1] = $value1->application;
                
          }
        }

        $return['date'][$i] = $dateFormatdate[$i];
        $return['day'][$i] = $dateFormatday[$i];
        $return['adultamount'][$i] = $adultAmount;
        $return['RWadultamount'][$i] = $RWadultAmount;
        $return['RWadult'][$i] = $RWadult;
        $return['RWchild'][$i] = $RWchild;
        $return['childamount'][$i] = $childAmount;
        $return['RWchildAmount'][$i] = $RWchildAmount;
        $return['general'][$i] = array_unique($generalsupplementType);
        $return['application'][$i] = array_unique($generalsupplementapplication);
        $return['ManadultAmount'][$i] = $ManadultAmount;
        $return['ManchildAmount'][$i] = $ManchildAmount;
        $return['ManchildAmount'][$i] = $ManchildAmount;
        $return['Manadultcount'][$i] = $MangeneralsupplementforAdults;
        $return['Manchildcount'][$i] = $MangeneralsupplementforChilds;
        $return['mangeneral'][$i] = array_unique($MangeneralsupplementType);
      }
      $return['gnlCount'] = array_sum($gsarraySum)+array_sum($mangsarraySum);
      // print_r($return);
      // exit();
      return $return;
    }
    public function get_CancellationPolicy_contract($request) {
      $refund= $this->db->query("SELECT * FROM hotel_tbl_contract WHERE contract_id = '".$request['contract_id']."' AND nonRefundable = 1")->result();
      if (count($refund)!=0) {
        $data[0] = "This booking is Nonrefundable";
      } else {

        $roomType = $this->db->query("SELECT * FROM hotel_tbl_hotel_room_type WHERE id = '".$request['room_id']."'")->result();
        $data = array();
        $checkin_date=date_create($request['Check_in']);
        $checkout_date=date_create($request['Check_out']);
        $no_of_days=date_diff($checkin_date,$checkout_date);
        $tot_days = $no_of_days->format("%a");
        for($i = 0; $i < $tot_days; $i++) {
          $date[$i] = date('Y-m-d', strtotime($request['Check_in']. ' + '.$i.'  days'));
          $CancellationPolicyCheck[$i] = $this->db->query("SELECT * FROM hotel_tbl_cancellationfee WHERE '".$date[$i]."' BETWEEN fromDate AND toDate AND contract_id = '".$request['contract_id']."'  AND hotel_id = '".$request['hotel_id']."'")->result();
          if (count($CancellationPolicyCheck[$i])!=0) {
            foreach ($CancellationPolicyCheck[$i] as $key => $value) {
                $exploderoomType[$key] = explode(",", $value->roomType);
                foreach ($exploderoomType[$key] as $key1 => $value1) {
                  if ($value1==$roomType[0]->id) {
                      if ($value->daysInAdvance==0) {
                        $daysInAdvance = 'your check-in date';
                      } else if($value->daysInAdvance==1) {
                        $daysInAdvance = 'within 24 hours of your check-in';
                      } else {
                        $daysInAdvance = 'within '.$value->daysInAdvance.' days of your check-in';
                      }
                      if ($value->application=="FIRST NIGHT") {
                        $data[$key] = '<span>
                                   If you cancel '.$daysInAdvance.',you will pay '.$value->cancellationPercentage.'% of one night stay with supplementary charges no matter the number of stay days.
                                </span>';
                      } else if ($value->application=="STAY") {

                          $data[$key] = '<span>
                                      If you cancel '.$daysInAdvance.', you will pay '.$value->cancellationPercentage.'% of the booking amount.
                                </span>';
                      } else {
                        $data[$key] = '<span>
                                   If you cancel '.$daysInAdvance.',  Cancellation charge is free .
                              </span>';
                      }
                  }
                }
            }
          }
        }
        

      }
      return $data;
    }
    public function addCancellationBooking($booking_id,$msg,$percentage,$daysFrom,$daysTo,$application,$room_id="",$contract_id="",$index) {
      $datas= array(
                  'bookingID'               =>$booking_id,
                  'room_id'                 =>$room_id,
                  'contract_id'             =>$contract_id,
                  'roomIndex'                =>$index,
                  'daysFrom'                =>$daysFrom,
                  'daysTo'                  =>$daysTo,
                  'cancellationPercentage'  =>$percentage,
                  'application'             =>$application,
                  'msg'                     =>$msg,
                  'createdDate'             => date('Y-m-d H:i:s'),
                  'createdBy'               =>  $this->session->userdata('agent_id'),
                );
        $this->db->insert('hotel_tbl_bookcancellationpolicy',$datas);
     return true;
    }
    public function board_single_amount($id,$check_in) {
      $this->db->select('*');
      $this->db->from('hotel_tbl_bookingboard');
      $this->db->where('bookingID',$id);
      $this->db->where('stayDate',$check_in);
      $query=$this->db->get();
      return $query->result();
    }
    public function board_amount($request) {
      $this->db->select('*');
      $this->db->from('hotel_tbl_bookingboard');
      $this->db->where('bookingID',$request);
      $query=$this->db->get();
      return $query->result();
    }
    public function general_single_amount($id,$check_in) {
      $this->db->select('*');
      $this->db->from('hotel_tbl_bookgeneralsupplement');
      $this->db->where('bookingID',$id);
      $this->db->where('gstayDate',$check_in);
      $query=$this->db->get();
      return $query->result();
    }
    public function general_amount($request) {
      $this->db->select('*');
      $this->db->from('hotel_tbl_bookgeneralsupplement');
      $this->db->where('bookingID',$request);
      $query=$this->db->get();
      return $query->result();
    }
    public function get_cancellationamount($request) {
      $this->db->select('*');
      $this->db->from('hotel_tbl_bookcancellationpolicy');
      $this->db->where('hotel_tbl_bookcancellationpolicy.bookingId',$request);
      $query=$this->db->get();
      return $query->result();
    }
    public function get_first_night_amount($request) {
      $this->db->select('*');
      $this->db->from('hotel_tbl_bookcancellationpolicy');
      $this->db->join('hotel_tbl_booking','hotel_tbl_bookcancellationpolicy.bookingId = hotel_tbl_booking.id', 'left');
      $this->db->where('bookingId',$request);
      $query=$this->db->get();
      return $query->result();
    }
    public function loget_cancellation_terms($request) {
      $this->db->select('*');
      $this->db->from('hotel_tbl_bookcancellationpolicy');
      $this->db->where('hotel_tbl_bookcancellationpolicy.bookingId',$request);
      $this->db->order_by('hotel_tbl_bookcancellationpolicy.daysInAdvance','asc');
      $query=$this->db->get();
      return $query->result();
    }
    public function extrabedAllotment($request) {
      $extrabedAmount  = array();
      $extraBedtotal  = array();
      $extrabedType = array();

      $this->db->select('*');
      $this->db->from('hotel_tbl_contract');
      $this->db->where('hotel_id',$request['hotel_id']);
      $this->db->where('contract_id',$request['contract_id']);
      $query = $this->db->get();
      $row_values  = $query->row_array();
      $tax = $row_values['tax_percentage'];
      $max_child_age = $row_values['max_child_age'];
      $contract_board = $row_values['board'];
      $contract_id = $request['contract_id'];

      // foreach ($request['Child'] as $Rreqkey => $Rreqvalue) {
      //     if ($Rreqvalue!=0) {
      //       for ($q=1; $q <=$Rreqvalue ; $q++) { 
      //           if ( isset($request['room'.($Rreqkey+1).'-childAge'][$q-1]) && $request['room'.($Rreqkey+1).'-childAge'][$q-1] >= $max_child_age) {
      //             $request['adults'][$Rreqkey]+=1;
      //             $request['Child'][$Rreqkey]-=1;
      //             unset($request['room'.($Rreqkey+1).'-childAge'][$q-1]);
      //           }
      //       }
      //     }
      //   }


      $this->db->select('*');
      $this->db->from('hotel_tbl_hotel_room_type');
      $this->db->where('hotel_id',$request['hotel_id']);
      $this->db->where('id',$request['room_id']);
      $Rmquery = $this->db->get();
      $Rmrow_values  = $Rmquery->row_array();
      $occupancyAdult = $Rmrow_values['occupancy'];
      $occupancyChild = $Rmrow_values['occupancy_child'];
      $standard_capacity = $Rmrow_values['standard_capacity'];
      $max_capacity = $Rmrow_values['max_total'];
      $Room_Type = $Rmrow_values['id'];


      $start_date = $request['Check_in'];
      $end_date = $request['Check_out'];
      $checkin_date=date_create($start_date);
      $checkout_date=date_create($end_date);
      $no_of_days=date_diff($checkin_date,$checkout_date);
      $tot_days = $no_of_days->format("%a");
      for($i = 0; $i < $tot_days; $i++) {
      /*Extrabed allotment start*/
          $date[$i] = date('Y-m-d', strtotime($start_date. ' + '.$i.'  days'));

          if ($contract_board=="BB") {
              $contract_boardRequest = array('Breakfast');
          } else if($contract_board=="HB") {
              $contract_boardRequest = array('Breakfast','Dinner');
          } else if($contract_board=="FB") {
              $contract_boardRequest = array('Breakfast','Dinner','Lunch');
          } else {
              $contract_boardRequest = array();
          }
          $implodeboardRequest = implode("','", $contract_boardRequest);

           $extrabedallotment[$i] = $this->db->query("SELECT * FROM hotel_tbl_extrabed WHERE '".$date[$i]."' BETWEEN from_date AND to_date AND contract_id = '".$contract_id."' AND  hotel_id = '".$request['hotel_id']."'")->result();
            if (count($extrabedallotment[$i])!=0) {
            foreach ($extrabedallotment[$i] as $key15 => $value15) {
                 foreach ($request['adults'] as $key17 => $value7) {
                  if (($value7+$request['Child'][$key17]) > $standard_capacity) {

                    // for ($k=1; $k <= count($request['adults']); $k++) { 

                      if (isset($request['room'.($key17+1).'-childAge'])) {
                        foreach ($request['room'.($key17+1).'-childAge'] as $key18 => $value18) {
                            if ($max_child_age < $value18) {
                              $explodeexRType = explode(",", $value15->roomType);
                              foreach ($explodeexRType as $exexrtypekey => $exexrtypevalue) {
                                if ($Room_Type==$exexrtypevalue) {
                                  $extrabedAmount[$i][$key17][] =  $value15->amount;
                                  $extrabedType[$i][$key17][] =  'Adult Extrabed';
                                }
                              }
                            } else {
                              if ($value15->ChildAmount!=0 && $value15->ChildAmount!="") {
                                  if ($value15->ChildAgeFrom <= $value18 && $value15->ChildAgeTo >= $value18) {
                                    $extrabedAmount[$i][$key17][$key18] =  $value15->ChildAmount;
                                    $extrabedType[$i][$key17][$key18] =  'Child Extrabed';
                                  }
                              } else {
                                $boardalt[$i] = $this->db->query("SELECT * FROM hotel_tbl_boardsupplement WHERE '".$date[$i]."' BETWEEN fromDate AND toDate AND contract_id = '".$contract_id."' AND board IN ('".$implodeboardRequest."')")->result();
                                if (count($boardalt[$i])!=0) {
                                  foreach ($boardalt[$i] as $key21 => $value21) {
                                    if ($value21->startAge <= $value18 && $value21->finalAge >= $value18) {
                                        $explodeRType = explode(",", $value21->roomType);
                                        foreach ($explodeRType as $exrtypekey => $exrtypevalue) {
                                          if ($Room_Type==$exrtypevalue) {
                                            $extrabedAmount[$i][$key17][$key18] =  $value21->amount;
                                            $extrabedType[$i][$key17][$key18] =  'Child '.$value21->board;
                                          }
                                        }
                                    }
                                    
                                  }
                                }
                              }  

                            }
                        }
                        
                      }

                    // }
                    if ($value7 > $standard_capacity) {
                      $explodeexRType = explode(",", $value15->roomType);
                      foreach ($explodeexRType as $exexrtypekey => $exexrtypevalue) {
                        if ($Room_Type==$exexrtypevalue) {
                          $extrabedAmount[$i][$key17][] =  $value15->amount;
                          $extrabedType[$i][$key17][] =  'Adult Extrabed';
                        }
                      }
                    }
                    // echo $request['Child'][$key17];
                    // echo "<BR>";

                  }
                 }
            }
          }

          /* Board wise supplement check start */
            $boardSp[$i] = array();
            if($contract_board=="HB") {
              $boardSp[$i] = $this->db->query("SELECT startAge,finalAge,amount,board FROM hotel_tbl_boardsupplement WHERE '".$date[$i]."' BETWEEN fromDate AND toDate AND contract_id = '".$contract_id."' AND board = 'Half Board' AND FIND_IN_SET('".$Room_Type."', IFNULL(roomType,'')) > 0")->result();
            } else if($contract_board=="FB") {
              $boardSp[$i] = $this->db->query("SELECT startAge,finalAge,amount,board FROM hotel_tbl_boardsupplement WHERE '".$date[$i]."' BETWEEN fromDate AND toDate AND contract_id = '".$contract_id."' AND board = 'Full Board' AND FIND_IN_SET('".$Room_Type."', IFNULL(roomType,'')) > 0")->result();
            }

            if (count($boardSp[$i])!=0) {
              foreach ($boardSp[$i] as $key21 => $value21) {
                foreach ($request['adults'] as $key17 => $value17) {
                  if (($value17+$request['Child'][$key17]) > $standard_capacity) {
                    if (isset($request['room'.($key17+1).'-childAge'])) {
                      foreach ($request['room'.($key17+1).'-childAge'] as $key18 => $value18) {
                        if ($value21->startAge <= $value18 && $value21->finalAge >= $value18) {
                          if (round($value21->amount)!=0) {
                            $extrabedAmount[$i][$key17][] =  $value21->amount;
                            $extrabedType[$i][$key17][] =  'Child '.$value21->board;
                          }
                        }
                      }
                    }
                  }
                  if ($value21->startAge >= 18) {
                    if (round($value21->amount)!=0) {
                      $extrabedAmount[$i][$key17][] =  $value21->amount;
                      $extrabedType[$i][$key17][] =  'Adult '.$value21->board;
                    }
                  }
                }
              }
            }

        /* Board wise supplement check end */
         
          if (isset($extrabedAmount[$i])) {
            $Texamount[$i] = array();
            foreach ($extrabedAmount[$i] as $Texamkey => $Texam) {
                $Texamount[$i][] = array_sum($Texam);
            }
            $extraBedtotal[$i] = array_sum($Texamount[$i]);
          }

        }
        if (count($extraBedtotal)!=0) {
          $return['date'] = $date;
          $return['extrabedAmount'] = $extraBedtotal;
          $return['extrabedType'] = $extrabedType;
          $return['RwextrabedAmount'] = $extrabedAmount;
          $return['count'] = count($extraBedtotal);
        } else {
          $return['count'] = 0;
        }
        // print_r($extrabedAmount);
        // exit();
        return $return;
    }
  public function get_PaymentConfirmextrabedAllotment($request,$contract_id,$room_id,$index) {
    
    $extrabedAmount  = array();
    $extraBedtotal  = array();
    $exrooms = array();
    $extrabedType = array();

    $this->db->select('tax_percentage,max_child_age,board');
    $this->db->from('hotel_tbl_contract');
    $this->db->where('hotel_id',$request['hotel_id']);
    $this->db->where('contract_id',$contract_id);
    $query = $this->db->get();
    $row_values  = $query->row_array();
    $tax = $row_values['tax_percentage'];
    $max_child_age = $row_values['max_child_age'];
    $contract_board = $row_values['board'];
      
    $this->db->select('occupancy,occupancy_child,standard_capacity,max_total');
    $this->db->from('hotel_tbl_hotel_room_type');
    $this->db->where('hotel_id',$request['hotel_id']);
    $this->db->where('id',$room_id);
    $Rmquery = $this->db->get();
    $Rmrow_values  = $Rmquery->row_array();
    $occupancyAdult = $Rmrow_values['occupancy'];
    $occupancyChild = $Rmrow_values['occupancy_child'];
    $standard_capacity = $Rmrow_values['standard_capacity'];
    $max_capacity = $Rmrow_values['max_total'];
    $Room_Type = $room_id;


    $start_date = $request['Check_in'];
    $end_date = $request['Check_out'];
    $checkin_date=date_create($start_date);
    $checkout_date=date_create($end_date);
    $no_of_days=date_diff($checkin_date,$checkout_date);
    $tot_days = $no_of_days->format("%a");
    for($i = 0; $i < $tot_days; $i++) {
    /*Extrabed allotment start*/
        $date[$i] = date('Y-m-d', strtotime($start_date. ' + '.$i.'  days'));

        if ($contract_board=="BB") {
            $contract_boardRequest = array('Breakfast');
        } else if($contract_board=="HB") {
            $contract_boardRequest = array('Breakfast','Dinner');
        } else if($contract_board=="FB") {
            $contract_boardRequest = array('Breakfast','Dinner','Lunch');
        } else {
            $contract_boardRequest = array();
        }
        $implodeboardRequest = implode("','", $contract_boardRequest);

         $extrabedallotment[$i] = $this->db->query("SELECT * FROM hotel_tbl_extrabed WHERE '".$date[$i]."' BETWEEN from_date AND to_date AND contract_id = '".$contract_id."' AND  hotel_id = '".$request['hotel_id']."' AND FIND_IN_SET('".$Room_Type."', IFNULL(roomType,'')) > 0")->result();
          if (count($extrabedallotment[$i])!=0) {
          foreach ($extrabedallotment[$i] as $key15 => $value15) {
            if (($request['reqadults'][$index]+$request['reqChild'][$index]) > $standard_capacity) {
                if (isset($request['reqroom'.($index+1).'-childAge'])) {
                  foreach ($request['reqroom'.($index+1).'-childAge'] as $key18 => $value18) {
                      if ($max_child_age < $value18) {
                        $extrabedAmount[$i][$index][] =  $value15->amount;
                        $exrooms[$i][$index][] = $index+1;
                        $extrabedType[$i][$index][] =  'Adult Extrabed';
                      } else {
                        if ($value15->ChildAmount!=0 && $value15->ChildAmount!="") {
                            if ($value15->ChildAgeFrom <= $value18 && $value15->ChildAgeTo >= $value18) {
                              $extrabedAmount[$i][$index][$key18] =  $value15->ChildAmount;
                              $extrabedType[$i][$index][$key18] =  'Child Extrabed';
                              $exrooms[$i][$index][$key18] = $index+1;
                            }
                        } else {
                          $boardalt[$i] = $this->db->query("SELECT * FROM hotel_tbl_boardsupplement WHERE '".$date[$i]."' BETWEEN fromDate AND toDate AND contract_id = '".$contract_id."' AND board IN ('".$implodeboardRequest."') AND FIND_IN_SET('".$Room_Type."', IFNULL(roomType,'')) > 0")->result();
                          if (count($boardalt[$i])!=0) {
                            foreach ($boardalt[$i] as $key21 => $value21) {
                              if ($value21->startAge <= $value18 && $value21->finalAge >= $value18) {
                                $extrabedAmounttmp[$i][$index][$key21][$key18] =  $value21->amount;
                                $extrabedAmount[$i][$index][$key21] =  array_sum($extrabedAmounttmp[$i][$index][$key21]);
                                $exrooms[$i][$index][$key18] = $index+1;
                                $extrabedType[$i][$index][$key21] =  'Child '.$value21->board;
                              }
                            }
                          }
                        } 

                      }
                  }


                }

              // }
              if ($request['reqadults'][$index] > $standard_capacity) {
                $extrabedAmount[$i][$index][] =  $value15->amount;
                $exrooms[$i][$index][] = $index+1;
                $extrabedType[$i][$index][] =  'Adult Extrabed';
              }
            }
          }
        }
        if (count($extrabedallotment[$i])==0) {
        $boardalt[$i] = $this->db->query("SELECT * FROM hotel_tbl_boardsupplement WHERE '".$date[$i]."' BETWEEN fromDate AND toDate AND contract_id = '".$contract_id."' AND board IN ('".$implodeboardRequest."') AND FIND_IN_SET('".$Room_Type."', IFNULL(roomType,'')) > 0")->result();
          if (($request['reqadults'][$index]+$request['reqChild'][$index]) > $standard_capacity) {
            if (isset($request['reqroom'.($index+1).'-childAge'])) {
              foreach ($request['reqroom'.($index+1).'-childAge'] as $key18 => $value18) {
                if (count($boardalt[$i])!=0) {
                  foreach ($boardalt[$i] as $key21 => $value21) {
                    if ($value21->startAge <= $value18 && $value21->finalAge >= $value18) {
                      $extrabedAmounttmp[$i][$index][$key21][$key18] =  $value21->amount;
                      $extrabedAmount[$i][$index][$key21] =  array_sum($extrabedAmounttmp[$i][$index][$key21]);
                      $exrooms[$i][$index][$key18] = $index+1;
                      $extrabedType[$i][$index][$key21] =  'Child '.$value21->board;
                    }
                  }
                }
              }
            }
          }
        }


        /* Board wise supplement check start */
          $boardSp[$i] = array();
          if($contract_board=="HB") {
            $boardSp[$i] = $this->db->query("SELECT startAge,finalAge,amount,board FROM hotel_tbl_boardsupplement WHERE '".$date[$i]."' BETWEEN fromDate AND toDate AND contract_id = '".$contract_id."' AND board = 'Half Board' AND FIND_IN_SET('".$Room_Type."', IFNULL(roomType,'')) > 0")->result();
          } else if($contract_board=="FB") {
            $boardSp[$i] = $this->db->query("SELECT startAge,finalAge,amount,board FROM hotel_tbl_boardsupplement WHERE '".$date[$i]."' BETWEEN fromDate AND toDate AND contract_id = '".$contract_id."' AND board = 'Full Board' AND FIND_IN_SET('".$Room_Type."', IFNULL(roomType,'')) > 0")->result();
          }

          if (count($boardSp[$i])!=0) {
            foreach ($boardSp[$i] as $key21 => $value21) {
              if (($request['reqadults'][$index]+$request['reqChild'][$index]) > $standard_capacity) {
                if (isset($request['reqroom'.($index+1).'-childAge'])) {
                  foreach ($request['reqroom'.($index+1).'-childAge'] as $key18 => $value18) {
                    if ($value21->startAge <= $value18 && $value21->finalAge >= $value18) {
                      if (round($value21->amount)!=0) {
                        $extrabedAmount[$i][$index][] =  $value21->amount;
                        $extrabedType[$i][$index][] =  'Child '.$value21->board;
                      }
                    }
                  }
                }
              }
              if ($value21->startAge >= 18) {
                if (round($value21->amount)!=0) {
                  $extrabedAmount[$i][$index][] =  $value21->amount;
                  $extrabedType[$i][$index][] =  'Adult '.$value21->board;
                }
              }
            }
          }

      /* Board wise supplement check end */
       

        if (isset($extrabedAmount[$i])) {
          $Texamount[$i] = array();
          foreach ($extrabedAmount[$i] as $Texamkey => $Texam) {
              $Texamount[$i][] = array_sum($Texam);
          }
          $extraBedtotal[$i] = array_sum($Texamount[$i]);
        }
      }
      if (count($extraBedtotal)!=0) {
        $return['date'] = $date;
        $return['extrabedAmount'] = $extraBedtotal;
        $return['extrabedType'] = $extrabedType;
        $return['RwextrabedAmount'] = $extrabedAmount;
        $return['Exrooms'] = $exrooms;
        $return['count'] = count($extraBedtotal);
      } else {
        $return['count'] = 0;
      }
      return $return;
  }
  public function AddPaymentConfirmExtrabed($date,$amount,$bookId,$rooms,$rwamount,$type,$room_id,$contract_id,$index){
    $data= array(
                  'date'   =>   $date,
                  'amount' =>   $amount,
                  'rooms' =>   $rooms,
                  'Exrwamount' =>   $rwamount,
                  'Type' =>   $type,
                  'bookId' =>   $bookId,
                  'room_id' =>   $room_id,
                  'contract_id' =>   $contract_id,
                  'roomIndex'   =>$index,
                );

    $this->db->insert('bookingextrabed',$data);
    return true;
  }
  public function getExtrabedDetails($book_id){
    $this->db->select('*');
    $this->db->from('bookingextrabed');
    $this->db->where('bookID',$book_id);
    $query = $this->db->get();
    return $query->result();

  }
  public function refundablecheck($contract_id) {
    $this->db->select('*');
    $this->db->from('hotel_tbl_contract');
    $this->db->where('contract_id',$contract_id);
    $query = $this->db->get()->result();
    if ($query[0]->nonRefundable!=1) {
      return true;
    } else {
      return false;
    }
  }
  public function additionalfoodrequest($request,$boardRequest) {
    $adultBoardAmount = array();
    $childBoardAmount = array();
    $childarrayBoardSumData = array();
    $bsCount = array();
    $BoardsupplementType = array();
    $start_date = $request['Check_in'];
    $end_date = $request['Check_out'];
    $checkin_date=date_create($start_date);
    $checkout_date=date_create($end_date);
    $no_of_days=date_diff($checkin_date,$checkout_date);
    $tot_days = $no_of_days->format("%a");
    for ($j=0; $j < count($_REQUEST['reqadults']); $j++) { 
      $IndexSplit = explode("-", $_REQUEST['Room'.($j+1)]);
      $contractId= $IndexSplit[0];
      $RoomId= $IndexSplit[1];
      for($i = 0; $i < $tot_days; $i++) {
        $date[$i] = date('Y-m-d', strtotime($start_date. ' + '.$i.'  days'));
        $boardSplmntCheck[$i] = $this->db->query("SELECT * FROM hotel_tbl_boardsupplement WHERE '".$date[$i]."' BETWEEN fromDate AND toDate AND contract_id = '".$contractId."'  AND FIND_IN_SET('".$RoomId."', IFNULL(roomType,'')) > 0 AND board = '".$boardRequest."' ")->result();
        foreach ($boardSplmntCheck[$i] as $key7 => $value7) {
          $BoardsupplementType[] = $value7->board;
        }
      }
    }
    if (count($BoardsupplementType)!=0) {
      return true;
    } else {
      return false;
    }
  }
  public function contractBoardCheck($contract_id) {
    $this->db->select('board');
    $this->db->from('hotel_tbl_contract');
    $this->db->where('contract_id',$contract_id);
    $query = $this->db->get()->result();
    return $query['0']->board;
  }
  public function get_CancellationRefund_contract($request) {
    $refund= $this->db->query("SELECT * FROM hotel_tbl_contract WHERE contract_id = '".$request['contract_id']."'")->result();
    return $refund;
    
  }
  public function supplementcheck($request) {
    // Total date fetch start
    $start_date = $request['Check_in'];
    $end_date = $request['Check_out'];
    $checkin_date=date_create($start_date);
    $checkout_date=date_create($end_date);
    $no_of_days=date_diff($checkin_date,$checkout_date);
    $tot_days = $no_of_days->format("%a");
    // Total date fetch end
    $totAmounts = array();
    $data = array();
    $data1 = array();
    $data2 = array();
    $adultBoardAmount = array();
    $childBoardAmount[] = array();
    foreach ($request['RoomIndex'] as $key => $value) {
      // Markup define start
      // $revenue_markup = revenue_markup1($_REQUEST['hotel_id'],$request['contract_id'][$key],$this->session->userdata('agent_id'));
      $agent_markup = mark_up_get()+general_mark_up_get();
      // if ($revenue_markup['Markup']!='') {
      //   $agent_markup = mark_up_get();
      // }
      // $total_markup = $agent_markup;
      // Markup define end
      // Max child get start
      $this->db->select('max_child_age');
      $this->db->from('hotel_tbl_contract');
      $this->db->where('contract_id',$request['contract_id'][$key]);
      $query1 = $this->db->get()->result();
      $max_child_age = $query1[0]->max_child_age;
      // Max child get end
        $adultBoardAmountRM[$key] = array();
      for($i = 0; $i < $tot_days; $i++) {
        $date[$i] = date('Y-m-d', strtotime($start_date. ' + '.$i.'  days'));
        $revenue_markup = revenue_markup2($_REQUEST['hotel_id'],$request['contract_id'][$key],$this->session->userdata('agent_id'),$date[$i]);
        if ($revenue_markup['Markup']!='') {
          $agent_markup = mark_up_get();
        }
        $total_markup = $agent_markup;
        
        if(isset($request['Room'.($key+1)][$date[$i]])) {
          $boardSplmntCheck[$i] = $this->db->query("SELECT * FROM hotel_tbl_boardsupplement WHERE '".$date[$i]."' BETWEEN fromDate AND toDate AND contract_id = '".$request['contract_id'][$key]."' AND FIND_IN_SET('".$request['room_id'][$key]."', IFNULL(roomType,'')) > 0 AND board = '".$request['supplementType']."' ")->result();
          if (count($boardSplmntCheck[$i])!=0) {
            $SupplementAvailDate[$i] = $date[$i];
          }
          foreach ($boardSplmntCheck[$i] as $key7 => $value7) {
            if ($max_child_age<$value7->startAge || $max_child_age<$value7->finalAge) {
              $Bsamount = 0;
              if ($revenue_markup['BoardSupMarkup']!='') {
                if ($revenue_markup['BoardSupMarkuptype']=="Percentage") {
                  $Bsamount = (($value7->amount*$revenue_markup['BoardSupMarkup'])/100);
                } else {
                  $Bsamount = $revenue_markup['BoardSupMarkup'];
                }
              }
              $adultBoardAmountRM[$key][$i] = (($value7->amount*$total_markup)/100)+$Bsamount+$value7->amount;
              if (isset($request['splAdults'][$key]) && isset($request['splAdultsCheck'][$key])) {
                $data['Room'.($key+1)]['adults']['date'][$i] = $date[$i];
                $data['Room'.($key+1)]['adults']['adultAmount'][$i][$key+1] = $value7->amount*$request['splAdults'][$key];
              }
            }
            if (isset($request['splRoom'.$value.'-ChildAge'])) {
              foreach ($request['splRoom'.$value.'-ChildAge'] as $key4 => $value4) {
                if ($value7->startAge <= $value4 && $value7->finalAge >= $value4) {
                  $childBoardAmount[$i]['room'.$value.'-child'.($key4).'Age-rate']= $value7->amount;
                  if (isset($request['room'.$value.'-child'.($key4).'Age-rateCheck'])) {
                    $data['Room'.($key+1)]['childs']['date'][$i] = $date[$i];
                    $data['Room'.($key+1)]['childs']['childAmount'][$i][$value][$key4] = $value7->amount;
                  }
                } 
              }
            }
          }
        }
      }
      $adultBoardAmount[$key] = array_sum($adultBoardAmountRM[$key]);
      foreach ($childBoardAmount as $reqChildkey => $reqChildvalue) {
        foreach ($reqChildvalue as $reqChildkey1 => $reqChildvalue1) {
            $BsCamount = 0;
            if ($revenue_markup['BoardSupMarkup']!='') {
              if ($revenue_markup['BoardSupMarkuptype']=="Percentage") {
                $BsCamount = (($reqChildvalue1*$revenue_markup['BoardSupMarkup'])/100);
              } else {
                $BsCamount = $revenue_markup['BoardSupMarkup'];
              }
            }


            if(isset($data1[$reqChildkey1])) {
              $data1[$reqChildkey1]+= ($reqChildvalue1*$total_markup)/100+$reqChildvalue1+$BsCamount;
            } else {
              $data1[$reqChildkey1] = ($reqChildvalue1*$total_markup)/100+$reqChildvalue1+$BsCamount;
            }
            if (isset($request[$reqChildkey1."Check"])) {
              if(isset($data2[$reqChildkey1])) {
                $data2[$reqChildkey1]+= ($reqChildvalue1*$total_markup)/100+$reqChildvalue1+$BsCamount;
              } else {
                $data2[$reqChildkey1] = ($reqChildvalue1*$total_markup)/100+$reqChildvalue1+$BsCamount;
              }
            }
        }
        
      }
      $totChildAmount = array_sum($data2);
      $data['child'] = $data1;
      $totAdultAmount = array();
        $data['adult']['room'.($key+1).'-adult-rate'] = ceil($adultBoardAmount[$key]*$request['splAdults'][$key]);
        if (isset($request['splAdultsCheck'][$key])) {
          $totAdultAmount[] = ($adultBoardAmount[$key]*$request['splAdults'][$key]);
        }
      $totAmounts[$key] = ceil(array_sum($totAdultAmount)+$totChildAmount);
    }
    $data['totAmounts'] = $totAmounts;
    $data['totAmount'] = array_sum($totAmounts);
    return $data;
  }
  public function supplementConfirm($request,$Bookdate,$contract_id,$room_id,$j) {
    $data = array();
    $data1 = array();
    $data2 = array();
    $adultBoardAmount = array();
    $childBoardAmount = array();
    $childBoardAge = array();
    $this->db->select('*');
    $this->db->from('hotel_tbl_contract');
    $this->db->where('contract_id',$contract_id);
    $query1 = $this->db->get()->result();
    $max_child_age = $query1[0]->max_child_age;

    $boardSplmntCheck = $this->db->query("SELECT * FROM hotel_tbl_boardsupplement WHERE '".$Bookdate."' BETWEEN fromDate AND toDate AND contract_id = '".$contract_id."' AND FIND_IN_SET('".$room_id."', IFNULL(roomType,'')) > 0 AND board = '".$request['supplementType']."' ")->result();

    if (count($boardSplmntCheck)!=0) {
      foreach ($boardSplmntCheck as $key7 => $value7) {
        if ($max_child_age<$value7->startAge || $max_child_age<$value7->finalAge) {
          $adultBoardAmount = $value7->amount;
          if (isset($request['splAdults'][$j-1]) && isset($request['splAdultsCheck'][$j-1])) {
            $data['adults']['adultAmount'][$j] = $value7->amount*$request['splAdults'][$j-1];
            $data['adults']['rooms'][$j] = $j;
          }
        }
        if (isset($request['splRoom'.$j.'-ChildAge'])) {
          foreach ($request['splRoom'.$j.'-ChildAge'] as $key4 => $value4) {
            if ($value7->startAge <= $value4 && $value7->finalAge >= $value4) {
              if (isset($request['room'.$j.'-child'.($key4).'Age-rateCheck'])) {
                $childBoardAmount[]= $value7->amount;
                $childBoardAge[]= ($value7->startAge."-".$value7->finalAge);
                if (isset($request['room'.$j.'-child'.($key4).'Age-rateCheck'])) {
                  $data['childs']['rooms'][$j] = $j;
                  $data['childs']['childAmount'][$j][$key4] = $value7->amount;
                }
              }
            } 
          }
        }
      }
      $adults_count= 0;
      if (isset($request['splAdultsCheck'][$j-1])) {
        $adults_count+= $request['splAdults'][$j-1];
      }
      
      $data['adultsCount'] = $adults_count;
      $data['adultsAmount'] = $adultBoardAmount;
      $data['ChildAmount'] = implode(",", $childBoardAmount);
      $data['ChildAge'] = implode(",", $childBoardAge);
      $data['totalAmount'] = ($adultBoardAmount*$adults_count)+array_sum($childBoardAmount);
    } else {
      $data = 0;
    }

    return $data;
  }
  public function get_CancellationPolicy_contractConfirm($request,$contract_id,$room_id) {
      $checkin_date=date_create($request['Check_in']);
      $checkout_date=date_create($request['Check_out']);
      $no_of_days=date_diff($checkin_date,$checkout_date);
      $tot_days = $no_of_days->format("%a");

      $refund= $this->db->query("SELECT * FROM hotel_tbl_contract WHERE contract_id = '".$contract_id."' AND nonRefundable = 1")->result();

      $disNRFVal = array();
      for ($i=0; $i < $tot_days ; $i++) {
        $dateOut = date('Y-m-d', strtotime($_REQUEST['Check_in']. ' + '.$i.'  days'));
        $disNRF[$i] = DateWisediscountNonRefundable($dateOut,$request['hotel_id'],$room_id,$contract_id,'Room',$_REQUEST['Check_in'],$_REQUEST['Check_out']);
        if ($disNRF[$i]['NRF']==1) {
          $disNRFVal = $disNRF[$i]['discount'];
        }
      }

      if (count($refund)!=0) {
        $data[0]['msg'] = "This booking is Nonrefundable";
        $data[0]['percentage'] = 100;
        $data[0]['daysInAdvance'] = 0;
        $data[0]['application'] = 'NON REFUNDABLE';
        $data[0]['daysFrom'] = '365';
        $data[0]['daysTo'] = '0';
      } else if(count($disNRFVal)!=0) {
        $data[0]['msg'] = "This booking is Nonrefundable";
        $data[0]['percentage'] = 100;
        $data[0]['daysInAdvance'] = 0;
        $data[0]['application'] = 'NON REFUNDABLE';
        $data[0]['daysFrom'] = '365';
        $data[0]['daysTo'] = '0';
      } else {

        $roomType = $this->db->query("SELECT * FROM hotel_tbl_hotel_room_type WHERE id = '".$room_id."'")->result();
        $data = array();
        

        $start=date_create(date('m/d/Y'));
        $end=date_create($request['Check_in']);
        $nod=date_diff($start,$end);
        $tot_days1 = $nod->format("%a");

        for($i = 0; $i < $tot_days; $i++) {
          $date[$i] = date('Y-m-d', strtotime($request['Check_in']. ' + '.$i.'  days'));
          $CancellationPolicyCheck[$i] = $this->db->query("SELECT * FROM hotel_tbl_cancellationfee WHERE '".$date[$i]."' BETWEEN fromDate AND toDate AND contract_id = '".$contract_id."'  AND hotel_id = '".$request['hotel_id']."' AND daysTo <= '".$tot_days1."' order by daysTo asc")->result();
          if (count($CancellationPolicyCheck[$i])!=0) {
            foreach ($CancellationPolicyCheck[$i] as $key => $value) {
                $exploderoomType[$key] = explode(",", $value->roomType);
                foreach ($exploderoomType[$key] as $key1 => $value1) {
                  if ($value1==$roomType[0]->id) {
                      if ($value->daysFrom==0) {
                        $daysInAdvance = 'your check-in date';
                      } else if($value->daysFrom==1) {
                        $daysInAdvance = 'within 24 hours of your check-in';
                      } else {
                        $daysInAdvance = 'within '.$value->daysFrom.' days of your check-in';
                      }
                      $data[$key]['daysFrom'] = $value->daysFrom;
                      $data[$key]['daysTo'] = $value->daysTo;
                      $data[$key]['percentage'] = $value->cancellationPercentage;
                      $data[$key]['application'] = $value->application;
                      if ($value->application=="FIRST NIGHT") {
                        $data[$key]['msg'] = '<span>
                                   If you cancel '.$daysInAdvance.',you will pay '.$value->cancellationPercentage.'% of one night stay with supplementary charges no matter the number of stay days.
                                </span>';
                      } else if ($value->application=="STAY") {
                          $data[$key]['msg'] = '<span>
                                      If you cancel '.$daysInAdvance.', you will pay '.$value->cancellationPercentage.'% of the booking amount.
                                </span>';
                      } else {
                        $data[$key]['msg'] = '<span>
                                   If you cancel '.$daysInAdvance.',  Cancellation charge is free .
                              </span>';
                      }
                  }
                }
            }
          }
        }
        

      }
      return $data;
  }
  public function get_cancellationamountCancelPeriod($request,$day) {
    return $this->db->query('SELECT * FROM hotel_tbl_bookcancellationpolicy WHERE bookingId = '.$request.' AND daysInAdvance = (SELECT MIN(daysInAdvance) FROM hotel_tbl_bookcancellationpolicy WHERE bookingId = '.$request.' AND daysInAdvance >= '.$day.')')->result();
  }
  public function roomAvailability($room_id,$start_date,$end_date,$contract_id,$hotel_id) {
    $bookedCount = all_booked_room_ajax($room_id,$start_date,$end_date,$contract_id);

    $linkedRoomAllotment = 0;
    $checkin_date=date_create($start_date);
    $checkout_date=date_create($end_date);
    $no_of_days=date_diff($checkin_date,$checkout_date);
    $tot_days = $no_of_days->format("%a");
    for($i = 0; $i < $tot_days; $i++) {
        $date[$i] = date('Y-m-d', strtotime($start_date. ' + '.$i.'  days'));
    }
    $implode = implode("','",$date);

    $this->db->select('allotement,linked_to_room_type');
    $this->db->from('hotel_tbl_hotel_room_type');
    $this->db->where('hotel_id',$hotel_id);
    $this->db->where('id',$room_id);
    $query1=$this->db->get();
    $result1 = $query1->result();

    if ($result1[0]->linked_to_room_type!="" && $result1[0]->linked_to_room_type!=Null) {
      $this->db->select('allotement');
      $this->db->from('hotel_tbl_allotement');
      $this->db->where('hotel_id',$hotel_id);
      $this->db->where('room_id',$result1[0]->linked_to_room_type);
      $this->db->where_in('allotement_date',$implode);
      $this->db->where('contract_id',$contract_id);
      $query3=$this->db->get();
      $result3 = $query3->result();
      if (count($result3)!=0) {
        $linkedRoomAllotment = $result3[0]->allotement;
      } 
    }

    $this->db->select('*');
    $this->db->from('hotel_tbl_contract');
    $this->db->where('hotel_id',$hotel_id);
    $this->db->where('contract_id',$contract_id);
    $linkedcontract=$this->db->get()->result();
    if ($linkedcontract[0]->contract_type=="Sub") {
      $contract_id = "CON0".$linkedcontract[0]->linkedContract;
    }
    $this->db->select('allotement');
    $this->db->from('hotel_tbl_allotement');
    $this->db->where('hotel_id',$hotel_id);
    $this->db->where('room_id',$room_id);
    $this->db->where_in('allotement_date',$implode);
    $this->db->where('contract_id',$contract_id);
    $query=$this->db->get();
    $result = $query->result();
    if (count($result)!=0) {
      $allotement = $result[0]->allotement;
    } else {
      $allotement = $result1[0]->allotement;
    }
    return ($allotement+$linkedRoomAllotment)-$bookedCount;
  }
  public function get_CancellationPolicy_tableFlow($request) {
    $refund= $this->db->query("SELECT * FROM hotel_tbl_contract WHERE contract_id = '".$request['contract_id']."' AND nonRefundable = 1")->result();
    $checkin_date=date_create($_REQUEST['Check_in']);
    $checkout_date=date_create($_REQUEST['Check_out']);
    $no_of_days=date_diff($checkin_date,$checkout_date);
    $tot_days = $no_of_days->format("%a");

    $disNRFVal = '';

    for ($i=0; $i < $tot_days ; $i++) {
      $dateOut = date('Y-m-d', strtotime($_REQUEST['Check_in']. ' + '.$i.'  days'));
      $disNRF[$i] = DateWisediscountNonRefundable($dateOut,$request['hotel_id'],$request['room_id'],$request['contract_id'],'Room',$_REQUEST['Check_in'],$_REQUEST['Check_out']);
      if ($disNRF[$i]['NRF']==1) {
        $disNRFVal = $disNRF[$i]['discount'];
      }
    }
    

    if (count($refund)!=0) {
      $data[0]['description'] = "This booking is Nonrefundable";
      $data[0]['after'] = "";
      $data[0]['before'] = "";
      $data[0]['percentage'] = "";
      $data[0]['application'] = "Nonrefundable";
    } else if($disNRFVal!='') {
      $data[0]['description'] = "This booking is Nonrefundable";
      $data[0]['after'] = '';
      $data[0]['before'] = '';
      $data[0]['percentage'] = "";
      $data[0]['application'] = "Nonrefundable";
    } else {
      $roomType = $this->db->query("SELECT * FROM hotel_tbl_hotel_room_type WHERE id = '".$request['room_id']."'")->result();
      $data = array();
      $checkin_date=date_create($request['Check_in']);
      $checkout_date=date_create($request['Check_out']);
      $no_of_days=date_diff($checkin_date,$checkout_date);
      $tot_days = $no_of_days->format("%a");


      $start=date_create(date('m/d/Y'));
      $end=date_create($request['Check_in']);
      $nod=date_diff($start,$end);
      $tot_days1 = $nod->format("%a");

      for($i = 0; $i < $tot_days; $i++) {
        $date[$i] = date('Y-m-d', strtotime($request['Check_in']. ' + '.$i.'  days'));
        $CancellationPolicyCheck[$i] = $this->db->query("SELECT * FROM hotel_tbl_cancellationfee WHERE '".$date[$i]."' BETWEEN fromDate AND toDate AND contract_id = '".$request['contract_id']."'  AND hotel_id = '".$request['hotel_id']."' AND daysTo <= '".$tot_days1."' order by daysTo asc")->result();
        if (count($CancellationPolicyCheck[$i])!=0) {
          foreach ($CancellationPolicyCheck[$i] as $key => $value) {
              $exploderoomType[$key] = explode(",", $value->roomType);
              foreach ($exploderoomType[$key] as $key1 => $value1) {

                
                if ($value1==$roomType[0]->id) {
                    $after = date('Y-m-d', strtotime('-'.$value->daysFrom.' days', strtotime($request['Check_in'])));
                    $before = date('Y-m-d', strtotime('-'.$value->daysTo.' days', strtotime($request['Check_in'])));
                    if ($after < date('Y-m-d')) {
                      $data[$key]['after'] = date('d/m/Y');
                    } else {
                      $data[$key]['after'] = date('d/m/Y', strtotime('-'.$value->daysFrom.' days', strtotime($request['Check_in'])));
                    }
                    if ($before < date('Y-m-d')) {
                      $data[$key]['before'] = date('d/m/Y');
                    } else {
                      $data[$key]['before'] = date('d/m/Y', strtotime('-'.$value->daysTo.' days', strtotime($request['Check_in'])));
                    }

                    if ($value->daysFrom==0) {
                      $daysInAdvance = 'your check-in date';
                    } else if($value->daysFrom==1) {
                      $daysInAdvance = 'within 24 hours of your check-in';
                    } else {
                      $daysInAdvance = 'within '.$value->daysFrom.' days of your check-in';
                    }

                    
                    $data[$key]['percentage'] = $value->cancellationPercentage;
                        $data[$key]['application'] = $value->application;

                    if ($value->application=="FIRST NIGHT") {
                      $data[$key]['description'] = '<span>
                                 If you cancel '.$daysInAdvance.',you will pay '.$value->cancellationPercentage.'% of one night stay with supplementary charges no matter the number of stay days.
                              </span>';

                    } else if ($value->application=="STAY") {

                        $data[$key]['description'] = '<span>
                                    If you cancel '.$daysInAdvance.', you will pay '.$value->cancellationPercentage.'% of the booking amount.
                              </span>';
                    } else {
                      $data[$key]['description'] = '<span>
                                 If you cancel '.$daysInAdvance.',  Cancellation charge is free .
                            </span>';
                    }
                }
              }
          }
        }
      }
      

    }
    return $data;
  }
  public function offlineRequestList($filter) {
    $this->db->select('*');
    $this->db->from('hotel_tbl_offlinerequest');
    $this->db->where('AgentId',$this->session->userdata('agent_id'));
    $this->db->where('bookingFlg',$filter);
    $query = $this->db->get();
    return $query;
  }
  public function OfflineRequestSubmit($request) {
    
    $Room1ChildAge = '';
    if (isset($request['room1-childAge'])) {
        $Room1ChildAge = implode(",", $request['room1-childAge']);
    }
    $Room2ChildAge = '';
    if (isset($request['room2-childAge'])) {
        $Room2ChildAge = implode(",", $request['room2-childAge']);
    }
    $Room3ChildAge = '';
    if (isset($request['room3-childAge'])) {
        $Room3ChildAge = implode(",", $request['room3-childAge']);
    }
    $Room4ChildAge = '';
    if (isset($request['room4-childAge'])) {
        $Room4ChildAge = implode(",", $request['room4-childAge']);
    }
    $Room5ChildAge = '';
    if (isset($request['room5-childAge'])) {
        $Room5ChildAge = implode(",", $request['room5-childAge']);
    }
    $Room6ChildAge = '';
    if (isset($request['room6-childAge'])) {
        $Room6ChildAge = implode(",", $request['room6-childAge']);
    }
    $Room7ChildAge = '';
    if (isset($request['room7-childAge'])) {
        $Room7ChildAge = implode(",", $request['room7-childAge']);
    }
    $Room8ChildAge = '';
    if (isset($request['room8-childAge'])) {
        $Room8ChildAge = implode(",", $request['room8-childAge']);
    }
    $Room9ChildAge = '';
    if (isset($request['room9-childAge'])) {
        $Room9ChildAge = implode(",", $request['room9-childAge']);
    }
    $Room10ChildAge = '';
    if (isset($request['room10-childAge'])) {
        $Room10ChildAge = implode(",", $request['room10-childAge']);
    }


    $Room1ContactName = ''; 
    $Room2ContactName = ''; 
    $Room3ContactName = ''; 
    $Room4ContactName = ''; 
    $Room5ContactName = ''; 
    $Room6ContactName = ''; 
    $Room7ContactName = ''; 
    $Room8ContactName = ''; 
    $Room9ContactName = ''; 
    $Room10ContactName = ''; 


    $adults = implode(",", $request['adults']);
    $Child = implode(",", $request['Child']);
    $data =  array(
                  'hotel_name' => $request['hotel_name'], 
                  'Destination' => $request['Destination'], 
                  'check_in' => $request['CheckIn'], 
                  'check_out' => $request['CheckOut'], 
                  'no_of_rooms' => $request['noOfRooms'], 
                  'Nationality' => $_REQUEST['nationality'],
                  'adults' => $adults, 
                  'child' => $Child, 
                  'Room1ChildAge' => $Room1ChildAge, 
                  'Room2ChildAge' => $Room2ChildAge, 
                  'Room3ChildAge' => $Room3ChildAge, 
                  'Room4ChildAge' => $Room4ChildAge, 
                  'Room5ChildAge' => $Room5ChildAge, 
                  'Room6ChildAge' => $Room6ChildAge, 
                  'Room7ChildAge' => $Room7ChildAge, 
                  'Room8ChildAge' => $Room8ChildAge, 
                  'Room9ChildAge' => $Room9ChildAge, 
                  'Room10ChildAge' => $Room10ChildAge, 
                  'SpecialRequest' => $request['SpecialRequest'], 
                  'budget' => $request['budget'],
                  'createdDate' => date('Y-m-d'),
                  'AgentId' => $this->session->userdata('agent_id'),
              );
 
    $this->db->insert('hotel_tbl_offlinerequest',$data);
    return $this->db->insert_id();

  }
  public function get_cancellation_terms($request) {
    $this->db->select('*');
    $this->db->from('hotel_tbl_bookcancellationpolicy');
    $this->db->where('hotel_tbl_bookcancellationpolicy.bookingId',$request);
    $this->db->order_by('hotel_tbl_bookcancellationpolicy.daysInAdvance','asc');
    $query=$this->db->get();
    return $query->result();
  }
  public function bankDetails() {
    $this->db->select('*');
    $this->db->from('hotel_tbl_general_settings');
    $this->db->where('id',1);
    $query=$this->db->get();
    return $query->result();
  }
    public function agent_Offlinebooking_details($id) {
      $this->db->select('*');
      $this->db->from('hotel_tbl_offlinerequest');
      $this->db->where('id',$id);
      $query=$this->db->get();
      return $query->result();
    }
    public function TBOBookingConfirm($agent_id,$ClientReferenceNumber,$BookingId,$TripId,$ConfirmationNo,$BookingStatus,$hotel_name,$RoomTypeName,$Check_in,$Check_out,$total_amount,$no_of_days,$no_of_rooms,$Hotel_id,$PriceChange,$admin_markup,$guestfname,$guestlname,$board) {
      $data = array(
                    'XMLProvider' => 'TBO',
                    'agent_id'    => $agent_id,
                    'ClientReferenceNumber'    => $ClientReferenceNumber,
                    'BookingId'    => $BookingId,
                    'TripId'    => $TripId,
                    'ConfirmationNo' => $ConfirmationNo,
                    'BookingStatus' => $BookingStatus,
                    'hotel_name' => $hotel_name,
                    'RoomTypeName' => $RoomTypeName,
                    'Check_in' => $Check_in,
                    'Check_out' => $Check_out,
                    'total_amount' => $total_amount,
                    'no_of_days' => $no_of_days,
                    'no_of_rooms' => $no_of_rooms,
                    'Hotel_id' => $Hotel_id,
                    'agent_markup' =>  mark_up_get(),
                    'admin_markup' =>  $admin_markup,
                    'CreatedDate'    => date('Y-m-d H:i:s'),
                    'CreatedBy'    => $agent_id,
                    'Bookingdate'    => date('m/d/Y'),
                    'PriceChange' => $PriceChange,
                    'bk_contact_fname' => $guestfname,
                    'bk_contact_lname' => $guestlname,
                    'board' => implode("==", $board),
      );
      $this->db->insert('xml_hotel_booking',$data);
      $id = $this->db->insert_id();
      $description = 'New hotel booking added [BookingID: '.$BookingId.' ,HotelID: '.$Hotel_id.' ,Provider: TBO]';
      AgentlogActivity($description);
      // xmlbookingMailNotification($id);
      return $id;
    }
    public function xml_booking_list($filter) {
      $this->db->select('*');
      $this->db->from('xml_hotel_booking');
      $this->db->where('bookingFlg',$filter);
      $this->db->where('agent_id',$this->session->userdata('agent_id'));
      $this->db->order_by('id','desc');
      $query = $this->db->get();
      return $query;
    }
    public function add_payment_records($request,$bookingid) {
      $data = array('bookingId' => $bookingid,
                    'amount' => $request['amount'],
                    'currency' => $request['currency'],
                    'transactionId' => $request['transid'],
                    'orderNumber' => $request['ordernumber'],
                    'method' => $request['gateway'],
                    'date' => date('Y-m-d H:i:s'),
                    'agentId' => $this->session->userdata('agent_id'),
                    'provider' => 'Otelseasy');
      $this->db->insert('tbl_onlinepaymentrecords',$data);
      return true;
    }
    public function add_xml_payment_records($request,$bookingid) {
      $data = array('bookingId' => $bookingid,
                    'amount' => $request['amount'],
                    'currency' => $request['currency'],
                    'transactionId' => $request['transid'],
                    'orderNumber' => $request['ordernumber'],
                    'method' => $request['gateway'],
                    'date' => date('Y-m-d H:i:s'),
                    'agentId' => $this->session->userdata('agent_id'),
                    'provider' => 'TBO');
      $this->db->insert('tbl_onlinepaymentrecords',$data);
      return true;
    }
    public function hotelDetails($hotel_id) {
      $this->db->select('*');
      $this->db->from('hotel_tbl_hotels');
      $this->db->where('id',$hotel_id);
      $query = $this->db->get()->result();
      return $query;
    }
    public function get_CancellationPolicy_table($request,$contract_id,$room_id) {
      $refund= $this->db->query("SELECT id FROM hotel_tbl_contract WHERE contract_id = '".$contract_id."' AND nonRefundable = 1")->result();
      $checkin_date=date_create($_REQUEST['Check_in']);
      $checkout_date=date_create($_REQUEST['Check_out']);
      $no_of_days=date_diff($checkin_date,$checkout_date);
      $tot_days = $no_of_days->format("%a");

      $disNRFVal = '';
      $roomType = $this->db->query("SELECT CONCAT(a.room_name,' ',b.Room_Type) as Name FROM hotel_tbl_hotel_room_type a INNER JOIN hotel_tbl_room_type b ON b.id = a.room_type WHERE a.id = '".$room_id."'")->result();

      for ($i=0; $i < $tot_days ; $i++) {
        $dateOut = date('Y-m-d', strtotime($_REQUEST['Check_in']. ' + '.$i.'  days'));
        $disNRF[$i] = DateWisediscountNonRefundable($dateOut,$request['hotel_id'],$room_id,$contract_id,'Room',$_REQUEST['Check_in'],$_REQUEST['Check_out']);
        if ($disNRF[$i]['NRF']==1) {
          $disNRFVal = $disNRF[$i]['discount'];
        }
      }

      $data[0]['RoomName'] = $roomType[0]->Name;

      if (count($refund)!=0) {
        $data[0]['description'] = "This booking is Nonrefundable";
        $data[0]['after'] = "";
        $data[0]['before'] = "";
        $data[0]['percentage'] = "";
        $data[0]['application'] = "Nonrefundable";
        $data[0]['RoomName'] = $roomType[0]->Name;
      } else if($disNRFVal!='') {
        $data[0]['description'] = "This booking is Nonrefundable";
        $data[0]['after'] = '';
        $data[0]['before'] = '';
        $data[0]['percentage'] = "";
        $data[0]['RoomName'] = $roomType[0]->Name;
        $data[0]['application'] = "Nonrefundable";
      } else {
        $data = array();
        $checkin_date=date_create($request['Check_in']);
        $checkout_date=date_create($request['Check_out']);
        $no_of_days=date_diff($checkin_date,$checkout_date);
        $tot_days = $no_of_days->format("%a");


        $start=date_create(date('m/d/Y'));
        $end=date_create($request['Check_in']);
        $nod=date_diff($start,$end);
        $tot_days1 = $nod->format("%a");
        for($i = 0; $i < $tot_days; $i++) {
          $date[$i] = date('Y-m-d', strtotime($request['Check_in']. ' + '.$i.'  days'));
          $CancellationPolicyCheck[$i] = $this->db->query("SELECT * FROM hotel_tbl_cancellationfee WHERE '".$date[$i]."' BETWEEN fromDate AND toDate AND contract_id = '".$contract_id."'  AND FIND_IN_SET('".$room_id."', IFNULL(roomType,'')) > 0 AND hotel_id = '".$request['hotel_id']."' AND daysTo <= '".$tot_days1."' order by daysFrom desc")->result();
          if (count($CancellationPolicyCheck[$i])!=0) {
            foreach ($CancellationPolicyCheck[$i] as $key => $value) {
              $after = date('Y-m-d', strtotime('-'.$value->daysFrom.' days', strtotime($request['Check_in'])));
              $before = date('Y-m-d', strtotime('-'.$value->daysTo.' days', strtotime($request['Check_in'])));
              if ($after < date('Y-m-d')) {
                $data[$key]['after'] = date('d/m/Y');
              } else {
                $data[$key]['after'] = date('d/m/Y', strtotime('-'.$value->daysFrom.' days', strtotime($request['Check_in'])));
              }
              if ($before < date('Y-m-d')) {
                $data[$key]['before'] = date('d/m/Y');
              } else {
                $data[$key]['before'] = date('d/m/Y', strtotime('-'.$value->daysTo.' days', strtotime($request['Check_in'])));
              }

              if ($value->daysFrom==0) {
                $daysInAdvance = 'your check-in date';
              } else if($value->daysFrom==1) {
                $daysInAdvance = 'within 24 hours of your check-in';
              } else {
                $daysInAdvance = 'within '.$value->daysFrom.' days of your check-in';
              }
              
              $data[$key]['percentage'] = $value->cancellationPercentage;
              $data[$key]['application'] = $value->application;
              $data[$key]['RoomName'] = $roomType[0]->Name;

              if ($value->application=="FIRST NIGHT") {
                $data[$key]['description'] = '<span>
                           If you cancel '.$daysInAdvance.',you will pay '.$value->cancellationPercentage.'% of one night stay with supplementary charges no matter the number of stay days.
                        </span>';

              } else if ($value->application=="STAY") {

                  $data[$key]['description'] = '<span>
                              If you cancel '.$daysInAdvance.', you will pay '.$value->cancellationPercentage.'% of the booking amount.
                        </span>';
              } else {
                $data[$key]['description'] = '<span>
                           If you cancel '.$daysInAdvance.',  Cancellation charge is free .
                      </span>';
              }
            }
          }
        }
        if (count($data)==0) {
          $data[0]['description'] = "This booking is Nonrefundable";
          $data[0]['after'] = "";
          $data[0]['before'] = "";
          $data[0]['percentage'] = "";
          $data[0]['application'] = "Nonrefundable";
          $data[0]['RoomName'] = $roomType[0]->Name;
        }

      }

      return $data;
    }
    public function roomList($hotel_id,$key,$data) {
        $this->db->select('a.id as room_id,b.Room_Type,a.room_name');
        $this->db->from('hotel_tbl_hotel_room_type a');
        $this->db->join('hotel_tbl_room_type b', 'b.id = a.room_type', 'inner');
        $this->db->where('a.max_total >=',($data['adults'][$key]+$data['Child'][$key]));
        $this->db->where('a.occupancy >=',$data['adults'][$key]);
        $this->db->where('a.occupancy_child >=',$data['Child'][$key]);
        $this->db->where('a.hotel_id',$hotel_id);
        $this->db->where('a.delflg',1);
        return $query=$this->db->get()->result();
    }
    public function room_current_count_price($room_id,$start_date,$end_date,$contract_id,$adults,$child,$request,$markup,$index) {
          /*Tax percentage grt from contract start*/
          $discountGet = Alldiscount(date('Y-m-d',strtotime($start_date)),date('Y-m-d',strtotime($end_date)),$request['hotel_id'],$room_id,$contract_id,'Room');

          $revenue_markup = revenue_markup1($_REQUEST['hotel_id'],$contract_id,$this->session->userdata('agent_id'));
          $agent_markup = mark_up_get();
          $general_markup = general_mark_up_get();
          $request['contract_id']  = $contract_id;

          $this->db->select('linkedContract,contract_type');
          $this->db->from('hotel_tbl_contract');
          $this->db->where('hotel_id',$request['hotel_id']);
          $this->db->where('contract_id',$contract_id);
          $linkedcontract=$this->db->get()->result();
          if ($linkedcontract[0]->contract_type=="Sub") {
            $Lcontract_id = "CON0".$linkedcontract[0]->linkedContract;
          } else {
            $Lcontract_id = $contract_id;
          }

        $this->db->select('tax_percentage,max_child_age,board,nonRefundable');
        $this->db->from('hotel_tbl_contract');
        $this->db->where('hotel_id',$request['hotel_id']);
        $this->db->where('contract_id',$contract_id);
        $query = $this->db->get();
        $row_values  = $query->row_array();
        $tax = $row_values['tax_percentage'];
        $max_child_age = $row_values['max_child_age'];
        

        $contract_board = $row_values['board'];
        $nonRefundable = '';
        if ($row_values['nonRefundable']==1) {
          $nonRefundable = 'Non Refundable';
        }
        /*Tax percentage grt from contract end*/

        /*Standard capacity get from rooms start*/

        $this->db->select('occupancy,occupancy_child,standard_capacity,max_total,linked_to_room_type');
        $this->db->from('hotel_tbl_hotel_room_type');
        $this->db->where('hotel_id',$request['hotel_id']);
        $this->db->where('id',$room_id);
        $Rmquery = $this->db->get();
        $Rmrow_values  = $Rmquery->row_array();
        $occupancyAdult = $Rmrow_values['occupancy'];
        $occupancyChild = $Rmrow_values['occupancy_child'];
        $standard_capacity = $Rmrow_values['standard_capacity'];
        $max_capacity = $Rmrow_values['max_total'];
        /*Standard capacity get from rooms end*/
        $BoardsupplementType = array();
        $adultBoardAmount = array();
        $childBoardAmount = array();
        $childarrayBoardSumData =array();
        $adultAmount = array();
        $childAmount = array();
        $adultAmountPR = array();
        $childAmountPR = array();
        $generalsupplementType  = array();
        $ManadultAmount  = array();
        $ManadultAmountPR = array();
        $MangeneralsupplementforAdults = array();
        $ManchildAmount = array();
        $MangeneralsupplementforChilds = array();
        $MangeneralsupplementType = array();
        $generalsupplementforAdults = array();
        $generalsupplementforChilds = array();
        $extrabedAmount  = array();
        $extrabedType = array();
        
        $adultscount = $adults;
        $childscount = $child;
        $roomType = $this->db->query("SELECT id FROM hotel_tbl_hotel_room_type WHERE id = '".$room_id."'")->result();
        $cut_off_date = array();
        $cut_off_msg = "";
        $checkin_date=date_create($start_date);
        $checkout_date=date_create($end_date);
        $no_of_days=date_diff($checkin_date,$checkout_date);
        $tot_days = $no_of_days->format("%a");
        for($i = 0; $i < $tot_days; $i++) {
          $date[$i] = date('Y-m-d', strtotime($start_date. ' + '.$i.'  days'));
          $RMdiscount = DateWisediscount(date('Y-m-d',strtotime($start_date)),$request['hotel_id'],$room_id,$Lcontract_id,'Room',date('Y-m-d',strtotime($start_date)),date('Y-m-d',strtotime($end_date)));
          $EDis = 0;
          $GDis = 0;
          $BDis = 0;
          if (is_numeric($RMdiscount['discount']) && $discountGet['dis']!="true") {
            if ($RMdiscount['Extrabed']==1) {
              $EDis = $RMdiscount['discount'];
            }
            if ($RMdiscount['General']==1) {
              $GDis = $RMdiscount['discount'];
            }
            if ($RMdiscount['Board']==1) {
              $BDis = $RMdiscount['discount'];
            }
          } 
          if (isset($request['board'])) {
            foreach ($request['board'] as $key5 => $value5) {
              $boardSplmntCheck[$i] = $this->db->query("SELECT * FROM hotel_tbl_boardsupplement WHERE '".$date[$i]."' BETWEEN fromDate AND toDate AND contract_id = '".$contract_id."' AND FIND_IN_SET('".$roomType[0]->id."', IFNULL(roomType,'')) > 0 AND board = '".$value5."'")->result();
              foreach ($boardSplmntCheck[$i] as $key7 => $value7) {

                $explodeBoardroomtype[$key7] = explode(",", $value7->roomType);

                foreach ($explodeBoardroomtype[$key7] as $key6 => $value6) {

                  if ($value6==$roomType[0]->id) {

                        //   $boardsupplementData[$key7] = $value7;
                    if ($max_child_age<$value7->startAge || $max_child_age<$value7->finalAge) {

                      $BoardsupplementType[$key5] = $value7->board;

                      $adultBoardAmount[$key5] = $value7->amount;
                    }
                          // if($max_child_age >= $value7->finalAge) {

                    $childBoardcnt[$i] = array();
                      if (isset($request['room'.$index.'-childAge'])) {
                        foreach ($request['room'.$index.'-childAge'] as $key4 => $value4) {
                          if ($value7->startAge <= $value4 && $value7->finalAge >= $value4) {
                           $childBoardcnt[$i][]= $value4;
                         } 
                       }

                     }
                   if (count($childBoardcnt[$i])!=0) {
                    $childBoardAmount[$i][] = $value7->amount*count($childBoardcnt[$i]);
                  } 
                          // }
                }
              }
            }
          }
        }

        $adultarrayBoardSumData[$i] = array_sum($adultBoardAmount);
        if (isset($childBoardAmount[$i])) {
          $childarrayBoardSumData[$i] = array_sum($childBoardAmount[$i]);
        }
        /*mandatory General Supplement start*/

        $generalSplmntCheck[$i] = $this->db->query("SELECT * FROM hotel_tbl_generalsupplement WHERE '".$date[$i]."' BETWEEN fromDate AND toDate AND contract_id = '".$contract_id."'  AND FIND_IN_SET('".$roomType[0]->id."', IFNULL(roomType,'')) > 0 AND mandatory = 1")->result();

        $gsarraySum[$i] = count($generalSplmntCheck[$i]);
        if ($gsarraySum[$i]!=0) {
          $gsData[$i] = $generalSplmntCheck[$i];
          $markup = $agent_markup+$general_markup;
          foreach ($gsData[$i] as $key3 => $value3) {

            $explodeRoomType[$key3] = explode(",", $value3->roomType);
            if ($value3->application=="Per Person") {
              $GSAmamount = 0;
              if ($revenue_markup['GeneralSupMarkup']!='') {
                $markup = $agent_markup;
                if ($revenue_markup['GeneralSupMarkuptype']=="Percentage") {
                  $GSAmamount = (($value3->adultAmount*$revenue_markup['GeneralSupMarkup'])/100);
                } else {
                  $GSAmamount = $revenue_markup['GeneralSupMarkup'];
                }
              }
              $adultAmount[] = (($value3->adultAmount*$markup/100)+$value3->adultAmount+$GSAmamount)-(($value3->adultAmount*$markup/100)+$value3->adultAmount+$GSAmamount)*$GDis/100;
                if (isset($request['room'.$index.'-childAge'])) {
                  foreach ($request['room'.$index.'-childAge'] as $key44 => $value44) {
                    if ($value3->MinChildAge < $value44) {
                      $GSCmamount = 0;
                      if ($revenue_markup['GeneralSupMarkup']!='') {
                        $markup = $agent_markup;
                        if ($revenue_markup['GeneralSupMarkuptype']=="Percentage") {
                          $GSCmamount = (($value3->childAmount*$revenue_markup['GeneralSupMarkup'])/100);
                        } else {
                          $GSCmamount = $revenue_markup['GeneralSupMarkup'];
                        }
                      }
                      $childAmount[] = (($value3->childAmount*$markup/100)+$value3->childAmount+$GSCmamount)-(($value3->childAmount*$markup/100)+$value3->childAmount+$GSCmamount)*$GDis/100;
                    } 
                  }

                }
            } else {
              $GSAmamount = 0;
              if ($revenue_markup['GeneralSupMarkup']!='') {
                $markup = $agent_markup;
                if ($revenue_markup['GeneralSupMarkuptype']=="Percentage") {
                  $GSAmamount = (($value3->adultAmount*$revenue_markup['GeneralSupMarkup'])/100);
                } else {
                  $GSAmamount = $revenue_markup['GeneralSupMarkup'];
                }
              }
              $GSCmamount = 0;
              if ($revenue_markup['GeneralSupMarkup']!='') {
                $markup = $agent_markup;
                if ($revenue_markup['GeneralSupMarkuptype']=="Percentage") {
                  $GSCmamount = (($value3->childAmount*$revenue_markup['GeneralSupMarkup'])/100);
                } else {
                  $GSCmamount = $revenue_markup['GeneralSupMarkup'];
                }
              }
              $adultAmountPR[] = (($value3->adultAmount*$markup/100)+$value3->adultAmount+$GSAmamount)-(($value3->adultAmount*$markup/100)+$value3->adultAmount+$GSAmamount)*$GDis/100;
              $childAmountPR[] = (($value3->childAmount*$markup/100)+$value3->childAmount+$GSCmamount)-(($value3->childAmount*$markup/100)+$value3->childAmount+$GSCmamount)*$GDis/100;
            }
            $generalsupplementType[] = $value3->type;
            $generalsupplementforAdults[] = $occupancyAdult;
            $generalsupplementforChilds[] =  $occupancyChild;
          }

        }
        /*mandatory General Supplement end*/
        /*Extrabed allotment start*/

        if ($contract_board=="BB") {
          $contract_boardRequest = array('Breakfast');
        } else if($contract_board=="HB") {
          $contract_boardRequest = array('Breakfast','Dinner');
        } else if($contract_board=="FB") {
          $contract_boardRequest = array('Breakfast','Dinner','Lunch');
        } else {
          $contract_boardRequest = array();
        }
        $implodeboardRequest = implode("','", $contract_boardRequest);

        $extrabedallotment[$i] = $this->db->query("SELECT amount,ChildAmount,ChildAgeFrom,ChildAgeTo FROM hotel_tbl_extrabed WHERE '".$date[$i]."' BETWEEN from_date AND to_date AND contract_id = '".$contract_id."' AND  hotel_id = '".$request['hotel_id']."' AND FIND_IN_SET('".$roomType[0]->id."', IFNULL(roomType,'')) > 0")->result();

        if (count($extrabedallotment[$i])!=0) {
          $markup = $agent_markup+$general_markup;
          foreach ($extrabedallotment[$i] as $key15 => $value15) {
            if (($adults+$child) > $standard_capacity) {
                        // for ($k=1; $k <= count($adults); $k++) { 
              if (isset($request['room'.$index.'-childAge'])) {
                foreach ($request['room'.$index.'-childAge'] as $key18 => $value18) {
                  if ($max_child_age < $value18) {
                    $EXamount = 0;
                   if ($revenue_markup['ExtrabedMarkup']!='') {
                      $markup = $agent_markup;
                      if ($revenue_markup['ExtrabedMarkuptype']=="Percentage") {
                        $EXamount = (($value15->amount*$revenue_markup['ExtrabedMarkup'])/100);
                      } else {
                        $EXamount = $revenue_markup['ExtrabedMarkup'];
                      }
                    }

                   $extrabedAmount[] =  (($value15->amount*$markup/100)+$value15->amount+$EXamount)-(($value15->amount*$markup/100)+$value15->amount+$EXamount)*$EDis/100;
                   $extrabedType[] =  'Adult Extrabed';
                 } else {
                  if ($value15->ChildAmount!=0 && $value15->ChildAmount!="") {
                    if ($value15->ChildAgeFrom <= $value18 && $value15->ChildAgeTo >= $value18) {
                      $EXamount = 0;
                      if ($revenue_markup['ExtrabedMarkup']!='') {
                        $markup = $agent_markup;
                        if ($revenue_markup['ExtrabedMarkuptype']=="Percentage") {
                          $EXamount = (($value15->ChildAmount*$revenue_markup['ExtrabedMarkup'])/100);
                        } else {
                          $EXamount = $revenue_markup['ExtrabedMarkup'];
                        }
                      }
                      $extrabedAmount[] = (($value15->ChildAmount*$markup/100)+$value15->ChildAmount+$EXamount)-(($value15->ChildAmount*$markup/100)+$value15->ChildAmount+$EXamount)*$EDis/100;
                      $extrabedType[] =  'Child Extrabed';
                    }
                  } else {
                    $boardalt[$i] = $this->db->query("SELECT startAge,finalAge,amount,board FROM hotel_tbl_boardsupplement WHERE '".$date[$i]."' BETWEEN fromDate AND toDate AND contract_id = '".$contract_id."' AND board IN ('".$implodeboardRequest."') AND FIND_IN_SET('".$roomType[0]->id."', IFNULL(roomType,'')) > 0")->result();
                      if (count($boardalt[$i])!=0) {
                        foreach ($boardalt[$i] as $key21 => $value21) {
                          if ($value21->startAge <= $value18 && $value21->finalAge >= $value18) {
                            $BsCamount = 0;
                            if ($revenue_markup['BoardSupMarkup']!='') {
                              $markup = $agent_markup;
                              if ($revenue_markup['BoardSupMarkuptype']=="Percentage") {
                                $BsCamount = (($value21->amount*$revenue_markup['BoardSupMarkup'])/100);
                              } else {
                                $BsCamount = $revenue_markup['BoardSupMarkup'];
                              }
                            }
                           $extrabedAmount[] = (($value21->amount*$markup/100)+$value21->amount+$BsCamount)-(($value21->amount*$markup/100)+$value21->amount+$BsCamount)*$BDis/100;
                            $extrabedType[] =  'Child '.$value21->board;
                        }

                      }
                    }
                  }  

                }
              }

            }

                        // }
                        // if ($request['Child'][$key17]==0) {
            if ($adults > $standard_capacity) {
              $EXamount = 0;
              if ($revenue_markup['ExtrabedMarkup']!='') {
                $markup = $agent_markup;
                if ($revenue_markup['ExtrabedMarkuptype']=="Percentage") {
                  $EXamount = (($value15->amount*$revenue_markup['ExtrabedMarkup'])/100);
                } else {
                  $EXamount = $revenue_markup['ExtrabedMarkup'];
                }
              }
              $extrabedAmount[] =  (($value15->amount*$markup/100)+$value15->amount+$EXamount)-(($value15->amount*$markup/100)+$value15->amount+$EXamount)*$EDis/100;
              $extrabedType[] =  'Adult Extrabed';
            }
                        // echo $request['Child'][$key17];
                        // echo "<BR>";

          }
      }
    }
    if (count($extrabedallotment[$i])==0) {
      $boardalt[$i] = $this->db->query("SELECT startAge,finalAge,amount,board FROM hotel_tbl_boardsupplement WHERE '".$date[$i]."' BETWEEN fromDate AND toDate AND contract_id = '".$contract_id."' AND board IN ('".$implodeboardRequest."') AND FIND_IN_SET('".$roomType[0]->id."', IFNULL(roomType,'')) > 0")->result();
      $markup = $agent_markup+$general_markup;
      if (($adults+$child) > $standard_capacity) {
        if (isset($request['room'.$index.'-childAge'])) {
          foreach ($request['room'.$index.'-childAge'] as $key18 => $value18) {
            if (count($boardalt[$i])!=0) {
              foreach ($boardalt[$i] as $key21 => $value21) {
                if ($value21->startAge <= $value18 && $value21->finalAge >= $value18) {
                  $BsCamount = 0;
                  if ($revenue_markup['BoardSupMarkup']!='') {
                    $markup = $agent_markup;
                    if ($revenue_markup['BoardSupMarkuptype']=="Percentage") {
                      $BsCamount = (($value21->amount*$revenue_markup['BoardSupMarkup'])/100);
                    } else {
                      $BsCamount = $revenue_markup['BoardSupMarkup'];
                    }
                  }
                  $extrabedAmount[] = (($value21->amount*$markup/100)+$value21->amount+$BsCamount)-(($value21->amount*$markup/100)+$value21->amount+$BsCamount)*$BDis/100;
                  $extrabedType[] =  'Child '.$value21->board;
                }

              }
            }
          }
        }
      }
    }
    /* Board wise supplement check start */
    $boardSp[$i] = array();
    if($contract_board=="HB") {
      $boardSp[$i] = $this->db->query("SELECT startAge,finalAge,amount,board FROM hotel_tbl_boardsupplement WHERE '".$date[$i]."' BETWEEN fromDate AND toDate AND contract_id = '".$contract_id."' AND board = 'Half Board' AND FIND_IN_SET('".$roomType[0]->id."', IFNULL(roomType,'')) > 0")->result();
    } else if($contract_board=="FB") {
      $boardSp[$i] = $this->db->query("SELECT startAge,finalAge,amount,board FROM hotel_tbl_boardsupplement WHERE '".$date[$i]."' BETWEEN fromDate AND toDate AND contract_id = '".$contract_id."' AND board = 'Full Board' AND FIND_IN_SET('".$roomType[0]->id."', IFNULL(roomType,'')) > 0")->result();
    }
    if (count($boardSp[$i])!=0) {
      $markup = $agent_markup+$general_markup;
      foreach ($boardSp[$i] as $key21 => $value21) {
          if (($adults+$child) > $standard_capacity) {
            if (isset($request['room'.$index.'-childAge'])) {
              foreach ($request['room'.$index.'-childAge'] as $key18 => $value18) {
                if ($value21->startAge <= $value18 && $value21->finalAge >= $value18) {
                  $BsCamount = 0;
                  if ($revenue_markup['BoardSupMarkup']!='') {
                    $markup = $agent_markup;
                    if ($revenue_markup['BoardSupMarkuptype']=="Percentage") {
                      $BsCamount = (($value21->amount*$revenue_markup['BoardSupMarkup'])/100);
                    } else {
                      $BsCamount = $revenue_markup['BoardSupMarkup'];
                    }
                  }
                  $extrabedAmount[] =  (($value21->amount*$markup/100)+$value21->amount+$BsCamount)-(($value21->amount*$markup/100)+$value21->amount+$BsCamount)*$BDis/100;
                  $extrabedType[] =  'Child '.$value21->board;
                }
              }
            }
          }
          if ($value21->startAge >= 18) {
            $BsAamount = 0;
            if ($revenue_markup['BoardSupMarkup']!='') {
              $markup = $agent_markup;
              if ($revenue_markup['BoardSupMarkuptype']=="Percentage") {
                $BsAamount = (($value21->amount*$revenue_markup['BoardSupMarkup'])/100);
              } else {
                $BsAamount = $revenue_markup['BoardSupMarkup'];
              }
            }
            $extrabedAmount[] = (($value21->amount*$markup/100)+$value21->amount+$BsAamount)-(($value21->amount*$markup/100)+$value21->amount+$BsAamount)*$BDis/100;
            $extrabedType[] =  'Adult '.$value21->board;
          }
      }
    }

    /* Board wise supplement check end */
    /*Extrabed allotment end*/
    }

    $implode = implode("','",$date);
    $linkedAllotmentquery = array();
    if ($Rmrow_values['linked_to_room_type']!="" && $Rmrow_values['linked_to_room_type']!=NULL) {
      $linkedAllotmentquery = $this->db->query("SELECT allotement FROM hotel_tbl_allotement WHERE allotement_date IN ('".$implode."') AND room_id = '".$Rmrow_values['linked_to_room_type']."' AND contract_id = '".$Lcontract_id."'")->result();
    }

    $query = $this->db->query("SELECT hotel_id,room_id,allotement_date,contract_id,allotement,cut_off FROM hotel_tbl_allotement WHERE allotement_date IN ('".$implode."') AND room_id = '".$room_id."' AND contract_id = '".$Lcontract_id."'")->result();

    if (count($query)!=0) {
      foreach ($query as $key1 => $value1) {

        $RMdiscount = DateWisediscount($value1->allotement_date,$value1->hotel_id,$value1->room_id,$Lcontract_id,'Room',date('Y-m-d',strtotime($start_date)),date('Y-m-d',strtotime($end_date)));
        
        $amtGet = $this->db->query("SELECT amount FROM hotel_tbl_allotement WHERE allotement_date = '".$value1->allotement_date."' AND room_id = '".$room_id."' AND contract_id = '".$contract_id."'")->result();

        if (count($amtGet)!=0) {
          $ramount = $amtGet[0]->amount;
        } else {
          $ramount = 0;
        }

        $markup = $agent_markup+$general_markup;
        if ($markup!=0) {
          $rmamount = 0;
          if ($revenue_markup['Markup']!='') {
            $markup = $agent_markup;
            if ($revenue_markup['Markuptype']=="Percentage") {
              $rmamount = (($ramount*$revenue_markup['Markup'])/100);
            } else {
              $rmamount = $revenue_markup['Markup'];
            }
          }
          $ramount = (($ramount*$markup)/100)+$rmamount+$ramount;
        } else {
          $rmamount = 0;
          if ($revenue_markup['Markup']!='') {
            $markup = $agent_markup;
            if ($revenue_markup['Markuptype']=="Percentage") {
              $rmamount = (($ramount*$revenue_markup['Markup'])/100);
            } else {
              $rmamount = $revenue_markup['Markup'];
            }
          }
          $ramount = $ramount+$rmamount;
        }
        if (is_numeric($RMdiscount['discount']) && $discountGet['dis']!="true") {
          $RMdiscount = $RMdiscount['discount'];
        } else {
          $RMdiscount = 0;
        }
        $amount[$key1] = $ramount-($ramount*$RMdiscount)/100;
        $Disamount[$key1] = $ramount;
        $discount[$key1] = $RMdiscount;
        if ($ramount!=0) {
          if (isset($linkedAllotmentquery[$key1]->allotement)) {
            $linkedAllotment=$linkedAllotmentquery[$key1]->allotement;
          } else {
            $linkedAllotment=0;
          }
          $booked = $this->List_Model->all_booked_roomDatewise($value1->hotel_id,$value1->room_id,$value1->allotement_date,$value1->contract_id);
          $allotement[] = ($value1->allotement+$linkedAllotment)-$booked;
        } else {
          $allotement[] = 0;
        }

        $current_date = date_create(date('Y-m-d'));
        $ck_2 = date_create($value1->allotement_date);
        $date_diff_check = date_diff($current_date,$ck_2);
        $check_cutoff1 = $date_diff_check->format("%a");
        if ($check_cutoff1<$value1->cut_off) {
          $cut_off_date[] = date('d/m/Y', strtotime($value1->allotement_date));
        }  
      }


      if (count($cut_off_date)!=0) {
        $cut_off_msg = "Cannot book selected dates (".implode(",", $cut_off_date).") due to cut off period. Kindly select another date";
      }

      foreach ($query as $key => $value) {
        $c1 = date_create(date('Y-m-d'));
        $c2 = date_create($value->allotement_date);
        $days=date_diff($c1,$c2);
        $check_cutoff = $days->format("%a");

        if ($check_cutoff<$value->cut_off) {
          $data['condition'] =  "false";
          break;
        } else {
          $data['condition'] =  "true";
        }
      }

      if (isset($request['nationality'])) {
        $nationality = $this->db->query("SELECT contract_id FROM hotel_tbl_contract WHERE contract_id = '".$contract_id."' AND FIND_IN_SET('".$request['nationality']."', IFNULL(nationalityPermission,'')) = 0")->result();
        if (count($nationality)==0) {
          $data['condition'] =  "false";
        }

      }

      $data['cut_off_msg'] = $cut_off_msg;
      $adultsRoomCount = $adults;
      if ($discountGet['dis']=="true") {
        $Cdays = $tot_days/$discountGet['stay'];
        $parts = explode('.', $Cdays);
        $Cdays = $parts[0];
        $Sdays = $discountGet['stay']*$Cdays;
        $Pdays = $discountGet['pay']*$Cdays;
        $Tdays = $tot_days-$Sdays;
        $Fdays = $Pdays+$Tdays;
        $discountGet['stay'];
        $discountGet['pay'];
        array_splice($amount, $Fdays);
        if ($discountGet['Extrabed']==1) {
          array_splice($extrabedAmount, $Fdays);
        }
        if ($discountGet['General']==1) {
          array_splice($ManadultAmount, $Fdays);
          array_splice($ManchildAmount, $Fdays);
        }
        // if ($discountGet['Board']==1) {
        //   array_splice($extrabedAmount, $Fdays);
        // }
        $discount[0] = 1;
      }
      $array_sumAdultAmount = array_sum($adultAmount)*array_sum($request['adults'])+(array_sum($adultAmountPR)*count($request['adults']));
      $array_sumChildAmount = array_sum($childAmount);
      $manGenarray_sumAdultAmount =  array_sum($ManadultAmount)+array_sum($ManadultAmountPR);
      $manGenarray_sumChildAmount = array_sum($ManchildAmount);
      $extrabedTotalAmount = array_sum($extrabedAmount);

      if ($markup!=0) {
            // $totalAdultBoardSumData = (($totalAdultBoardSumData*$markup)/100)+$totalAdultBoardSumData;
            // $totalChildBoardSumData = (($totalChildBoardSumData*$markup)/100)+$totalChildBoardSumData;
        $array_sumAdultAmount = $array_sumAdultAmount;
        $array_sumChildAmount = $array_sumChildAmount;
        $manGenarray_sumAdultAmount = (($manGenarray_sumAdultAmount*$markup)/100)+$manGenarray_sumAdultAmount;
        $manGenarray_sumChildAmount = (($manGenarray_sumChildAmount*$markup)/100)+$manGenarray_sumChildAmount;
        $extrabedTotalAmount =  $extrabedTotalAmount;
      }


      $totalbkamount = ((array_sum($amount))+$array_sumAdultAmount+$array_sumChildAmount+$manGenarray_sumAdultAmount+$manGenarray_sumChildAmount)+$extrabedTotalAmount;
      $totalbkamount1 = ((array_sum($Disamount))+$array_sumAdultAmount+$array_sumChildAmount+$manGenarray_sumAdultAmount+$manGenarray_sumChildAmount)+$extrabedTotalAmount;

      if($tax!=0) {
        $totalbkamount = ((($totalbkamount*$tax)/100)+$totalbkamount);
        $totalbkamount1 = ((($totalbkamount*$tax)/100)+$totalbkamount);
      }
      $data['price'] = $totalbkamount;
      $data['discountAmount'] = $totalbkamount1;
      $rtrn = array();
      if ((($adults+$child) > $max_capacity) || ($adults > $occupancyAdult) || ($child > $occupancyChild)) {
        $rtrn[] = 1;
      } else {
        $rtrn[] = 0;
      }
      if (array_sum($rtrn) == 0 && $cut_off_msg=="") {
        $data['allotement'] = min($allotement);
      } else {
        $data['allotement'] = 0;
        $data['condition'] =  "false";
      }
      $data['generalsupplementType'] = array_unique($generalsupplementType);
      $data['MangeneralsupplementType'] = array_unique($MangeneralsupplementType);
      $data['BoardsupplementType'] = implode(", ", array_unique($BoardsupplementType));
      $data['nonRefundable'] = $nonRefundable;
      $data['extrabedType'] = $extrabedType;
      $data['discount'] = array_sum($discount);

    } else {
      $this->db->select('price,allotement');
      $this->db->from('hotel_tbl_hotel_room_type');
      $this->db->where('id',$room_id);
      $query1=$this->db->get();
      $final =  $query1->result();
      $data['cut_off_msg'] = $cut_off_msg;
      $data['condition'] =  "TRUE";
      $data['price'] = $final[0]->price;
      $data['discountAmount'] = $final[0]->price;
      $data['allotement'] = $final[0]->allotement;
      $data['generalsupplementType'] = array_unique($generalsupplementType);
      $data['MangeneralsupplementType'] = array_unique($MangeneralsupplementType);
      $data['BoardsupplementType'] = implode(", ", array_unique($BoardsupplementType));
      $data['extrabedType'] = $extrabedType;
      $data['nonRefundable'] = $nonRefundable;
      $data['discount'] = 0;
    }
    return $data;
    }
    public function TotalBookingAmountDetailsGet($book_id) {
      $return['Cost'] = 0;
      $return['Selling'] = 0;
      $return['AgentProfit'] = 0;
      $return['AdminProfit'] = 0;
      $view = $this->Payment_Model->booking_details($book_id);
      $board = $this->Payment_Model->board_booking_detail($book_id);
      $general = $this->Payment_Model->general_booking_detail($book_id);
      $cancelation =  $this->Payment_Model->get_cancellation_terms($book_id);
      $ExBed =  $this->Payment_Model->getExtrabedDetails($book_id);
      $amenddata = $this->Payment_Model->getamendmentdata($book_id);

      $book_room_count = $view[0]->book_room_count;
      $individual_amount = explode(",", $view[0]->individual_amount);
      if ($view[0]->individual_discount!="") {
        $individual_discount = explode(",", $view[0]->individual_discount);
      }

      $tot_days = $view[0]->no_of_days;

      $roomExp = explode(",", $view[0]->room_id);
      $ExtrabedDiscount = explode(",", $view[0]->ExtrabedDiscount);
      $GeneralDiscount = explode(",", $view[0]->GeneralDiscount);
      $BoardDiscount = explode(",", $view[0]->BoardDiscount);
      $RequestType = explode(",", $view[0]->RequestType);

      $admin_markup = explode(",", $view[0]->admin_markup);

      $revenueMarkup = explode(",", $view[0]->revenueMarkup);
      $revenueMarkupType = explode(",", $view[0]->revenueMarkupType);
      $revenueExtrabedMarkup = explode(",", $view[0]->revenueExtrabedMarkup);
      $revenueExtrabedMarkupType = explode(",", $view[0]->revenueExtrabedMarkupType);
      $revenueBoardMarkup = explode(",", $view[0]->revenueBoardMarkup);
      $revenueBoardMarkupType = explode(",", $view[0]->revenueBoardMarkupType);
      $revenueGeneralMarkupType = explode(",", $view[0]->revenueGeneralMarkupType);
      $revenueGeneralMarkup = explode(",", $view[0]->revenueGeneralMarkup);

      for ($i=1; $i <= $book_room_count; $i++) {
        if (isset($admin_markup[$i-1])) {
          $total_markup = $view[0]->agent_markup+$admin_markup[$i-1]+$view[0]->search_markup;
        } else {
          $total_markup = $view[0]->agent_markup+$admin_markup[0]+$view[0]->search_markup;
        }
        if(isset($amenddata)&& $amenddata!="") {
          foreach ($amenddata as $key => $value) {
            $varIndividual = 'Room'.$i.'individual_amount';
            $amendmentarr[$i-1][$key] = explode(",",$value->$varIndividual);

          }
        }
        if (!isset($ExtrabedDiscount[$i-1])) {
          $ExtrabedDiscount[$i-1] = 0;
        }
        if (!isset($GeneralDiscount[$i-1])) {
          $GeneralDiscount[$i-1] = 0;
        }
        if (!isset($BoardDiscount[$i-1])) {
          $BoardDiscount[$i-1] = 0;
        }
        if (!isset($roomExp[$i-1])) {
          $room_id = $roomExp[0];
        } else {
          $room_id = $roomExp[$i-1];
        }

        $Fdays = 0;
        $discountType = "";
        $DisTypExplode = explode(",", $view[0]->discountType);
        $DisStayExplode = explode(",", $view[0]->discountStay);
        $DisPayExplode = explode(",", $view[0]->discountPay);
        $discountCode = explode(",", $view[0]->discountCode);
        if (!isset($DisTypExplode[$i])) {
          $DisTypExplode[$i] = $DisTypExplode[0];
        }
        if (!isset($DisStayExplode[$i])) {
          $DisStayExplode[$i] = $DisStayExplode[0];
        }
        if (!isset($DisTypExplode[$i])) {
          $DisPayExplode[$i] = $DisPayExplode[0];
        }
        if (!isset($discountCode[$i])) {
          $discountCode[$i] = $discountCode[0];
        }
        if (isset($DisTypExplode[$i-1]) && $DisTypExplode[$i-1]=="stay&pay") {
          $Cdays = $tot_days/$DisStayExplode[$i-1];
          $parts = explode('.', $Cdays);
          $Cdays = $parts[0];
          $Sdays = $DisStayExplode[$i-1]*$Cdays;
          $Pdays = $DisPayExplode[$i-1]*$Cdays;
          $Tdays = $tot_days-$Sdays;
          $Fdays = $Pdays+$Tdays;
          $discountType = $DisTypExplode[$i-1];
        }

        $varIndividual = 'Room'.$i.'individual_amount';
        if($view[0]->$varIndividual!="") {
          $individual_amount = explode(",", $view[0]->$varIndividual);
        }

        $varIndividualDis = 'Room'.$i.'Discount';
        if($view[0]->$varIndividual!="") {
          $individual_discount = explode(",", $view[0]->$varIndividualDis);
        }

        $varRoomrevenueMarkup = 'Room'.$i.'revenueMarkup';
        $varRoomrevenueMarkupType = 'Room'.$i.'revenueMarkupType';
        if ($view[0]->$varRoomrevenueMarkup!="") {
          $$varRoomrevenueMarkup = explode(",", $view[0]->$varRoomrevenueMarkup);
          $$varRoomrevenueMarkupType = explode(",", $view[0]->$varRoomrevenueMarkupType);
        }
        
        $varRoomrevenueExtrabedMarkup = 'Room'.$i.'revenueExtrabedMarkup';
        $varRoomrevenueExtrabedMarkupType = 'Room'.$i.'revenueExtrabedMarkupType';
        if ($view[0]->$varRoomrevenueExtrabedMarkup!="") {
          $$varRoomrevenueExtrabedMarkup = explode(",", $view[0]->$varRoomrevenueExtrabedMarkup);
          $$varRoomrevenueExtrabedMarkupType = explode(",", $view[0]->$varRoomrevenueExtrabedMarkupType);
        }

        $varRoomrevenueBoardMarkup = 'Room'.$i.'revenueBoardMarkup';
        $varRoomrevenueBoardMarkupType = 'Room'.$i.'revenueBoardMarkupType';
        if ($view[0]->$varRoomrevenueBoardMarkup!="") {
          $$varRoomrevenueBoardMarkup = explode(",", $view[0]->$varRoomrevenueBoardMarkup);
          $$varRoomrevenueBoardMarkupType = explode(",", $view[0]->$varRoomrevenueBoardMarkupType);
        }

        $varRoomrevenueGeneralMarkup = 'Room'.$i.'revenueGeneralMarkup';
        $varRoomrevenueGeneralMarkupType = 'Room'.$i.'revenueGeneralMarkupType';
        if ($view[0]->$varRoomrevenueGeneralMarkup!="") {
          $$varRoomrevenueGeneralMarkup = explode(",", $view[0]->$varRoomrevenueGeneralMarkup);
          $$varRoomrevenueGeneralMarkupType = explode(",", $view[0]->$varRoomrevenueBoardMarkupType);
        }


        $oneNight = array();
        for ($j=0; $j < $tot_days ; $j++) { 
          if (!isset($individual_discount[$j])) {
            $individual_discount[$j] = 0;
          }
          $CPRMRate[$j]=0;
          $DisroomAmount[$j] = 0;
          $CPEAmoAD[$j] = 0;
          $ExAmount[$j] = 0;
          $TExAmount[$j] = 0;
          $APTExAmount[$j] = 0;
          $CPGAmoAD[$j] = 0;
          $CPAmoAD[$j] = 0; 
          $GCamount[$j] = 0;
          $APGCamount[$j] =0;
          $CPBAAmoAD[$j] = 0;
          $BAamount[$j] = 0;
          $TBAamount[$j] = 0;
          $APTBAamount[$j] =0;
          $CPBCAmoAd[$j]  = 0;
          $BCamount[$j] = 0;
          $TBCamount[$j]  = 0;
          $APTBCamount[$j]  = 0;
          $CPGAmoAD[$j] = 0;
          $GAamount[$j] = 0;
          $APGAamount[$j] = 0;
          $TPBAamount[$j] = 0;
          
          if (isset($$varRoomrevenueMarkup[$j])) {
            $revenueMarkup[$i-1] = $$varRoomrevenueMarkup[$j];
            $revenueMarkupType[$i-1] = $$varRoomrevenueMarkupType[$j];
          }

          if (isset($$varRoomrevenueExtrabedMarkup[$j])) {
            $revenueExtrabedMarkup[$i-1] = $$varRoomrevenueExtrabedMarkup[$j];
            $revenueExtrabedMarkupType[$i-1] = $$varRoomrevenueExtrabedMarkupType[$j];
          }

          if (isset($$varRoomrevenueBoardMarkup[$j])) {
            $revenueBoardMarkup[$i-1] = $$varRoomrevenueBoardMarkup[$j];
            $revenueBoardMarkupType[$i-1] = $$varRoomrevenueBoardMarkupType[$j];
          }

          if (isset($$varRoomrevenueGeneralMarkup[$j])) {
            $revenueGeneralMarkup[$i-1] = $$varRoomrevenueGeneralMarkup[$j];
            $revenueGeneralMarkupType[$i-1] = $$varRoomrevenueGeneralMarkupType[$j];
          }


          $amendmentarrTot = array();
          if(isset($amendmentarr[$i-1])) {
            foreach ($amendmentarr[$i-1] as $key => $value) {
              $amendmentarrTot[$key] = $value[$j]; 
            }
            $individual_amount1[$j] = array_sum($amendmentarrTot)+$individual_amount[$j];
          } else {
            $individual_amount1[$j] = $individual_amount[$j];
          }
          /* Room rates start */
          $rmAmount = 0;
          if (isset($revenueMarkup[$i-1])) {
            if ($revenueMarkup[$i-1]!="" && $revenueMarkup[$i-1]!=0) {
              if ($revenueMarkupType[$i-1]=='Percentage') {
                $rmAmount = ($individual_amount1[$j]*$revenueMarkup[$i-1])/100;
              } else {
                $rmAmount = $revenueMarkup[$i-1];
              }
            }
          } else {
            if ($revenueMarkup[0]!="" && $revenueMarkup[0]!=0) {
              if ($revenueMarkupType[0]=='Percentage') {
                $rmAmount = ($individual_amount1[$j]*$revenueMarkup[0])/100;
              } else {
                $rmAmount = $revenueMarkup[0];
              }
            }
          }
          
          
          // Cost Room price 
            $CPRMRate[$j] = $individual_amount1[$j]-($individual_amount1[$j]*$individual_discount[$j])/100;
          // Selling Room price start
            if (isset($admin_markup[$i-1])) {
              $admin_markuprate= $admin_markup[$i-1];
            } else {
              $admin_markuprate= $admin_markup[0];
            }
            $Adminprofit[$j] =  (($individual_amount1[$j]*$admin_markuprate)/100)+$rmAmount;
            $roomAmount[$j] = (($individual_amount1[$j]*$total_markup)/100)+$individual_amount1[$j]+$rmAmount;
            $DisroomAmount[$j] = $roomAmount[$j]-($roomAmount[$j]*$individual_discount[$j])/100;
          /* Room rates end */
          /* Extrabed rate start */
            if (count($ExBed)!=0) {
              foreach ($ExBed as $Exkey => $Exvalue) {
                if ($Exvalue->date==date('Y-m-d', strtotime($view[0]->check_in. ' + '.$j.'  days'))) {
                  $exroomExplode = explode(",", $Exvalue->rooms);
                  $examountExplode = explode(",", $Exvalue->Exrwamount);
                  $exTypeExplode = explode(",", $Exvalue->Type);
                  foreach ($exroomExplode as $Exrkey => $EXRvalue) {
                    if ($EXRvalue==$i) {
                      $ExMAmount = 0;
                      if (isset($revenueMarkup[$i-1])) {
                        if ($revenueMarkup[$i-1]!="") {
                          if ($exTypeExplode[$Exrkey]=="Adult Extrabed" || $exTypeExplode[$Exrkey]=="Child Extrabed") {
                            if ($revenueExtrabedMarkupType[$i-1]=='Percentage') {
                              $ExMAmount = ($examountExplode[$Exrkey]*$revenueExtrabedMarkup[$i-1])/100;
                            } else {
                              $ExMAmount = $revenueExtrabedMarkup[$i-1];
                            }
                          } else {
                            if ($revenueBoardMarkupType[$i-1]=='Percentage') {
                              $ExMAmount = ($examountExplode[$Exrkey]*$revenueBoardMarkup[$i-1])/100;
                            } else {
                              $ExMAmount = $revenueBoardMarkup[$i-1];
                            }
                          }
                        }
                      } else {
                        if ($revenueMarkup[0]!="") {
                          if ($exTypeExplode[$Exrkey]=="Adult Extrabed" || $exTypeExplode[$Exrkey]=="Child Extrabed") {
                            if ($revenueExtrabedMarkupType[0]=='Percentage') {
                              $ExMAmount = ($examountExplode[$Exrkey]*$revenueExtrabedMarkup[0])/100;
                            } else {
                              $ExMAmount = $revenueExtrabedMarkup[0];
                            }
                          } else {
                            if ($revenueBoardMarkupType[0]=='Percentage') {
                              $ExMAmount = ($examountExplode[$Exrkey]*$revenueBoardMarkup[0])/100;
                            } else {
                              $ExMAmount = $revenueBoardMarkup[0];
                            }
                          }
                        }
                      }
                      $ExDis = 0;
                      if ($ExtrabedDiscount[$i-1]==1) {
                        $ExDis = $individual_discount[$j];
                      }
                      // Extrabed Cost Price
                      $CPEAmoAD[$j] = $examountExplode[$Exrkey]-(($examountExplode[$Exrkey]*$ExDis)/100);
                      // Extrabed Selling Price
                      $ExAmount[$j] = (($examountExplode[$Exrkey]*$total_markup)/100)+$examountExplode[$Exrkey]+$ExMAmount-(((($examountExplode[$Exrkey]*$total_markup)/100)+$examountExplode[$Exrkey]+$ExMAmount)*$ExDis/100);
                      $TExAmount[$j] +=$ExAmount[$j];
                      $APTExAmount[$j] +=(($examountExplode[$Exrkey]*$admin_markuprate)/100)+$ExMAmount-(((($examountExplode[$Exrkey]*$admin_markuprate)/100)+$ExMAmount)*$ExDis/100);
                    } 
                  } 
                } 
              }
            }
          /* Extrabed rate end */
 
          /* General supplement start */
            if (count($general)!=0) {
              foreach ($general as $gskey => $gsvalue) {
                if ($gsvalue->gstayDate==date('d/m/Y', strtotime($view[0]->check_in. ' + '.$j.'  days'))) {
                  $gsadultExplode = explode(",", $gsvalue->Rwadult);
                  $gsadultAmountExplode = explode(",", $gsvalue->Rwadultamount);
                  // Adult general supplements start
                  foreach ($gsadultExplode as $gsakey => $gsavalue) {
                    if ($gsavalue==$i) {
                      $GSMAmount = 0;
                      if (isset($revenueMarkup[$i-1])) {
                        if ($revenueGeneralMarkup[$i-1]!="") {
                          if ($revenueGeneralMarkupType[$i-1]=='Percentage') {
                            $GSMAmount = ($gsadultAmountExplode[$gsakey]*$revenueGeneralMarkup[$i-1])/100;
                          } else {
                            $GSMAmount = $revenueGeneralMarkup[$i-1];
                          }
                        }
                      } else {
                        if ($revenueGeneralMarkup[0]!="") {
                          if ($revenueGeneralMarkupType[0]=='Percentage') {
                            $GSMAmount = ($gsadultAmountExplode[$gsakey]*$revenueGeneralMarkup[0])/100;
                          } else {
                            $GSMAmount = $revenueGeneralMarkup[0];
                          }
                        }
                      }
                      $GSDis = 0;
                      if ($GeneralDiscount[$i-1]==1) {
                        $GSDis = $individual_discount[$j];
                      }
                      // Adult general cost rate
                      $CPGAmoAD[$j] = $gsadultAmountExplode[$gsakey]-($gsadultAmountExplode[$gsakey]*$GSDis)/100;
                      // Adult general selling rate
                      
                      $GAamount[$j] = ((($gsadultAmountExplode[$gsakey]*$total_markup)/100)+$gsadultAmountExplode[$gsakey]+$GSMAmount)-((($gsadultAmountExplode[$gsakey]*$total_markup)/100)+$gsadultAmountExplode[$gsakey]+$GSMAmount)*$GSDis/100;
                      
                      $APGAamount[$j] = ((($gsadultAmountExplode[$gsakey]*$admin_markuprate)/100)+$GSMAmount)-((($gsadultAmountExplode[$gsakey]*$admin_markuprate)/100)+$GSMAmount)*$GSDis/100;
                    }
                  }
                  // Adult general supplements end
                  // Child general supplements start
                  $gschildExplode = explode(",", $gsvalue->Rwchild);
                  $gschildAmountExplode = explode(",", $gsvalue->RwchildAmount);

                  foreach ($gschildExplode as $gsckey => $gscvalue) {
                    if ($gscvalue==$i) {
                      $GSMAmount = 0;
                      if (isset($revenueMarkup[$i-1])) {
                        if ($revenueGeneralMarkup[$i-1]!="") {
                          if ($revenueGeneralMarkupType[$i-1]=='Percentage') {
                            $GSMAmount = ($gschildAmountExplode[$gsckey]*$revenueGeneralMarkup[$i-1])/100;
                          } else {
                            $GSMAmount = $revenueGeneralMarkup[$i-1];
                          }
                        }
                      } else {
                        if ($revenueGeneralMarkup[0]!="") {
                          if ($revenueGeneralMarkupType[0]=='Percentage') {
                            $GSMAmount = ($gschildAmountExplode[$gsckey]*$revenueGeneralMarkup[0])/100;
                          } else {
                            $GSMAmount = $revenueGeneralMarkup[0];
                          }
                        }
                      }
                      $GSDis = 0;
                      if ($GeneralDiscount[$i-1]==1) {
                        $GSDis = $individual_discount[$j];
                      }
                      // Child general cost rate
                      $CPAmoAD[$j] = $gschildAmountExplode[$gsckey]-$gschildAmountExplode[$gsckey]*$GSDis/100;
                      // Child general selling rate
                      
                      $GCamount[$j] = ((($gschildAmountExplode[$gsckey]*$total_markup)/100)+$gschildAmountExplode[$gsckey]+$GSMAmount)-((($gschildAmountExplode[$gsckey]*$total_markup)/100)+$gschildAmountExplode[$gsckey]+$GSMAmount)*$GSDis/100;
                      
                      $APGCamount[$j] = ((($gschildAmountExplode[$gsckey]*$admin_markuprate)/100)+$GSMAmount)-((($gschildAmountExplode[$gsckey]*$admin_markuprate)/100)+$GSMAmount)*$GSDis/100;
                    }
                  }
                  // Child general supplements end


                }
              }
            }
          /* General supplement end */

          /* Board supplement start */
          foreach ($board as $bkey => $bvalue) { 
            if (($room_id==$bvalue->room_id || $bvalue->room_id=="") && $bvalue->stayDate==date('d/m/Y', strtotime($view[0]->check_in. ' + '.$j.'  days'))) {

              // Adult Board start
              $ABReqwadultexplode = explode(",", $bvalue->Breqadults);
              $ABRwadultexplode = explode(",", $bvalue->Rwadult);
              $ABRwadultamountexplode = explode(",", $bvalue->RwadultAmount);
              foreach ($ABRwadultexplode as $ABRwkey => $ABRwvalue) {
                if ($ABRwvalue==$i) {
                  $BSMAmount = 0;
                  if (isset($revenueMarkup[$i-1])) {
                    if ($revenueBoardMarkup[$i-1]!="") {
                      if ($revenueBoardMarkupType[$i-1]=='Percentage') {
                        $BSMAmount = ($ABRwadultamountexplode[$ABRwkey]*$revenueBoardMarkup[$i-1])/100;
                      } else {
                        $BSMAmount = $revenueBoardMarkup[$i-1]*$ABReqwadultexplode[$ABRwkey];
                      }
                    }
                  } else {
                    if ($revenueBoardMarkup[0]!="") {
                      if ($revenueBoardMarkupType[0]=='Percentage') {
                        $BSMAmount = ($ABRwadultamountexplode[$ABRwkey]*$revenueBoardMarkup[0])/100;
                      } else {
                        $BSMAmount = $revenueBoardMarkup[0]*$ABReqwadultexplode[$ABRwkey];
                      }
                    }
                  }
                  $BSDis = 0;
                  if ($BoardDiscount[$i-1]==1) {
                    $BSDis = $individual_discount[$j];
                  }
                  // Adult board cost rate
                  $CPBAAmoAD[$j] = $ABRwadultamountexplode[$ABRwkey]-($ABRwadultamountexplode[$ABRwkey]*$BSDis/100);
                  $TPBAamount[$j] += $CPBAAmoAD[$j];
                  
                  // Adult board selling rate
                  $BAamount[$j] = ((($ABRwadultamountexplode[$ABRwkey]*$total_markup)/100)+$ABRwadultamountexplode[$ABRwkey]+$BSMAmount)-((($ABRwadultamountexplode[$ABRwkey]*$total_markup)/100)+$ABRwadultamountexplode[$ABRwkey]+$BSMAmount)*$BSDis/100;
                  $TBAamount[$j] += $BAamount[$j];
                  $APTBAamount[$j] += ((($ABRwadultamountexplode[$ABRwkey]*$admin_markuprate)/100)+$BSMAmount)-((($ABRwadultamountexplode[$ABRwkey]*$admin_markuprate)/100)+$BSMAmount)*$BSDis/100;
                }
              }
              // Adult Board end

              // Child Board start
              $CBReqwchildexplode = explode(",", $bvalue->BreqchildCount);
              $CBRwchildexplode = explode(",", $bvalue->Rwchild);
              $CBRwchildamountexplode = explode(",", $bvalue->RwchildAmount);
              foreach ($CBRwchildexplode as $CBRwkey => $CBRwvalue) {
                if ($CBRwvalue==$i) {
                  $BSMAmount = 0;
                  if (isset($revenueMarkup[$i-1])) {
                    if ($revenueBoardMarkup[$i-1]!="") {
                      if ($revenueBoardMarkupType[$i-1] == 'Percentage') {
                        $BSMAmount = ($CBRwchildamountexplode[$CBRwkey]*$revenueBoardMarkup[$i-1])/100;
                      } else {
                        $BSMAmount = $revenueBoardMarkup[$i-1]*$CBReqwchildexplode[$CBRwkey];
                      }
                    }
                  } else {
                    if ($revenueBoardMarkup[0]!="") {
                      if ($revenueBoardMarkupType[0] == 'Percentage') {
                        $BSMAmount = ($CBRwchildamountexplode[$CBRwkey]*$revenueBoardMarkup[0])/100;
                      } else {
                        $BSMAmount = $revenueBoardMarkup[0]*$CBReqwchildexplode[$CBRwkey];
                      }
                    }
                  }
                  $BSDis = 0;
                  if ($BoardDiscount[$i-1]==1) {
                    $BSDis = $individual_discount[$j];
                  }
                  // Child Board cost price
                  $CPBCAmoAd[$j] = $CBRwchildamountexplode[$CBRwkey]-($CBRwchildamountexplode[$CBRwkey]*$BSDis/100);
                  // Child Board selling price
                  $BCamount[$j] = ((($CBRwchildamountexplode[$CBRwkey]*$total_markup)/100)+$CBRwchildamountexplode[$CBRwkey]+$BSMAmount)-((($CBRwchildamountexplode[$CBRwkey]*$total_markup)/100)+$CBRwchildamountexplode[$CBRwkey]+$BSMAmount)*$BSDis/100;
                  $TBCamount[$j] += $BCamount[$j];
                  $APTBCamount[$j] += ((($CBRwchildamountexplode[$CBRwkey]*$admin_markuprate)/100)+$BSMAmount)-((($CBRwchildamountexplode[$CBRwkey]*$admin_markuprate)/100)+$BSMAmount)*$BSDis/100;
                }
              }
              // Child Board end

            }
          }
          /* Board supplement end */
        }

        // Roomwise total rates start
        if (isset($DisTypExplode[$i-1]) && $DisTypExplode[$i-1]=="stay&pay" && $Fdays!=0) {
        array_splice($CPRMRate, 1,$Fdays);
        array_splice($DisroomAmount, 1,$Fdays);
        array_splice($Adminprofit, 1,$Fdays);

        if ($ExtrabedDiscount[$i-1]==1) {
          array_splice($CPEAmoAD,1,$Fdays);
          array_splice($TExAmount,1,$Fdays);
          array_splice($APTExAmount,1,$Fdays);
        }
        if ($GeneralDiscount[$i-1]==1) {
          array_splice($CPGAmoAD,1,$Fdays);
          array_splice($CPAmoAD,1,$Fdays);

          array_splice($GAamount,1,$Fdays);
          array_splice($APGAamount,1,$Fdays);
          array_splice($GCamount,1,$Fdays);
          array_splice($APGCamount,1,$Fdays);
        }
        if ($BoardDiscount[$i-1]==1) {
          array_splice($TPBAamount,1,$Fdays);
          array_splice($CPBCAmoAd,1,$Fdays);

          array_splice($TBAamount,1,$Fdays);
          array_splice($APTBAamount,1,$Fdays);
          array_splice($TBCamount,1,$Fdays);
          array_splice($APTBCamount,1,$Fdays);
        }
      } 
      $costPrice[$i] = array_sum($CPRMRate)+array_sum($CPEAmoAD)+array_sum($CPGAmoAD)+array_sum($CPAmoAD)+array_sum($TPBAamount)+array_sum($CPBCAmoAd);


      $totRmAmt[$i] = array_sum($DisroomAmount)+array_sum($TExAmount)+array_sum($GAamount)+array_sum($GCamount)+array_sum($TBAamount)+array_sum($TBCamount); 
        

      $toadminProfit[$i] = array_sum($Adminprofit)+array_sum($APTExAmount)+array_sum($APGAamount)+array_sum($APGCamount)+array_sum($APTBAamount)+array_sum($APTBCamount);  
      // Roomwise total rates end
      }
      $costPrice = array_sum($costPrice);
      $tax = $view[0]->tax;
      if ($view[0]->tax=="") {
        $tax = 0;
      }
      $sellingPrice = ((array_sum($totRmAmt)*$tax)/100)+(array_sum($totRmAmt));
      $Agentprofit= ($costPrice*($view[0]->agent_markup))/100;
      $Adminprofit= array_sum($toadminProfit);
      if ($Adminprofit==0) {
        $Adminprofit= $sellingPrice-($Agentprofit+$costPrice);
      }
      $return['Cost'] = $costPrice;
      $return['Selling'] = $sellingPrice;
      $return['AgentProfit'] = $Agentprofit;
      $return['AdminProfit'] = $Adminprofit;
      return $return;
    }
    public function booking_details($book_id) {
      $this->db->select('*');
      $this->db->from('hotel_tbl_booking');
      $this->db->where('id',$book_id);
      $query=$this->db->get();
      return $query->result();
    }
    public function getamendmentdata($id) {
      $this->db->select("*");
      $this->db->from("hotel_tbl_hotelamendments");
      $this->db->where("bookID",$id);
      $this->db->where("status",'1');
      $query = $this->db->get()->result();
      return $query;
    }
    public function roomwisepaxdata($hotel_id,$key,$data,$contract) {
      $start_date = $data['Check_in'];
      $end_date = $data['Check_out'];
      $first_date = strtotime($start_date);
      $second_date = strtotime($end_date);
      $offset = $second_date-$first_date; 
      $result = array();
      $checkin_date=date_create($data['Check_in']);
      $checkout_date=date_create($data['Check_out']);
      $no_of_days=date_diff($checkin_date,$checkout_date);
      $tot_days = $no_of_days->format("%a");

      $bookDate = date_create(date('Y-m-d'));
      for($i = 0; $i < $tot_days; $i++) {
        $dateAlt[$i] = date('Y-m-d', strtotime($start_date. ' + '.$i.'  days'));
      }
      $implode_data = implode("','", $dateAlt);

      $implode_data2 = implode("','", array_unique($contract));
      $RoomChildAge1 = 0; 
      $RoomChildAge2 = 0; 
      $RoomChildAge3 = 0; 
      $RoomChildAge4 = 0; 

      if (isset($_REQUEST['room'.($key+1).'-childAge'][0])) {
        $RoomChildAge1 = $_REQUEST['room'.($key+1).'-childAge'][0]; 
      }
      if (isset($_REQUEST['room'.($key+1).'-childAge'][1])) {
        $RoomChildAge2 = $_REQUEST['room'.($key+1).'-childAge'][1]; 
      }
      if (isset($_REQUEST['room'.($key+1).'-childAge'][2])) {
        $RoomChildAge3 = $_REQUEST['room'.($key+1).'-childAge'][2]; 
      }
      if (isset($_REQUEST['room'.($key+1).'-childAge'][3])) {
        $RoomChildAge4 = $_REQUEST['room'.($key+1).'-childAge'][3]; 
      }

      $markup = mark_up_get();
      $general_markup = general_mark_up_get();

      $room = "SELECT *,TotalPrice-(TtlPrice*fday)+(exAmountTot-(exAmount*fday))+(boardChildAmountTot-(boardChildAmount*fday))+(exChildAmountTot-(exChildAmount*fday))+(generalsubAmountTot-(generalsubAmount*fday)) as dd 
      FROM (
        SELECT *,sum(FinalAmnt) as TotalPrice,count(*) as counts,IF(min(allotment)<=0,'On Request','Book') as RequestType,sum(exAmount) as exAmountTot,sum(exChildAmount) as exChildAmountTot
        ,sum(boardChildAmount) as boardChildAmountTot,sum(generalsubAmount) as generalsubAmountTot,IF(sum(exAmount)!=0,'Adult Extrabed','') as extraLabel,
        IF(sum(exChildAmount)!=0,'Child Extrabed','') as extraChildLabel,IF(sum(boardChildAmount)!=0,'Child supplements','') as boardChildLabel 
         FROM (
         SELECT *,IF(".$data['adults'][$key]."
            +IF(0=".$RoomChildAge1.",0,IF(max_child_age< ".$RoomChildAge1.",1,0))
            +IF(0=".$RoomChildAge2.",0,IF(max_child_age< ".$RoomChildAge2.",1,0))
            +IF(0=".$RoomChildAge3.",0,IF(max_child_age< ".$RoomChildAge3.",1,0))
            +IF(0=".$RoomChildAge4.",0,IF(max_child_age< ".$RoomChildAge4.",1,0)) > standard_capacity && extrabed=0,0,TtlPrice) as FinalAmnt,
      IF(extrabed!=0,IF(StayExbed=1,extrabed,extrabed-(extrabed*exdis/100)),0) as exAmount,

      IF(StayExbed=1,
      IF(extrabedChild=0,0,extrabedChild) ,(IF(extrabedChild=0,0,extrabedChild)- IF(extrabedChild=0,0,extrabedChild)*exdis/100)) as exChildAmount ,
      
      IF(StayBoard=1,
      IF(extrabedChild=0,extrabedChild1,0) ,(IF(extrabedChild=0,extrabedChild1,0)- IF(extrabedChild=0,extrabedChild1,0)*exdis/100)) as boardChildAmount,

      IF(generalsub!=0,IF(StayGeneral=1, generalsub,generalsub-(generalsub*generaldis/100)),0) as generalsubAmount

      FROM (select con.board,CONCAT(f.room_name,' ',g.Room_Type) as RoomName,a.hotel_id,a.contract_id,a.room_id,
      if(con.contract_type='Sub',(select GetAllotmentCount1(a.allotement_date,a.hotel_id,CONCAT('CON0',linkedcontract),a.room_id ,'".date('Y-m-d')."',".$tot_days.",".count($data['adults']).")),(select GetAllotmentCount1(a.allotement_date,a.hotel_id,a.contract_id,a.room_id ,'".date('Y-m-d')."',".$tot_days.",".count($data['adults'])."))) as allotment, a.amount as TtlPrice1,dis.discount_type,dis.Extrabed as StayExbed,dis.General as StayGeneral,dis.Board as StayBoard,IF(dis.stay_night!='',(dis.pay_night*ceil(".$tot_days."/dis.stay_night))+(".$tot_days."-(dis.stay_night*ceil(".$tot_days."/dis.stay_night))),0) as fday ,CONCAT(con.contract_id,'-',a.room_id) as RoomIndex, rev.ExtrabedMarkup,rev.ExtrabedMarkuptype,f.standard_capacity,con.max_child_age,

        ((a.amount+(a.amount*".$markup."/100)+IF(rev.Markup!='',IF(rev.Markuptype='Percentage',(a.amount*rev.Markup/100),(rev.Markup)), (a.amount*".$general_markup."/100)))
        - (a.amount+(a.amount*".$markup."/100)+IF(rev.Markup!='',IF(rev.Markuptype='Percentage',(a.amount*rev.Markup/100),(rev.Markup)), (a.amount*".$general_markup."/100)))*

         (select GetDiscount(a.allotement_date,a.hotel_id,a.contract_id,a.room_id,'".date('Y-m-d')."',".$tot_days.")/100)
         ) as TtlPrice,
        (select IF(count(1)!=0,IF(ExtrabedMarkup!='',IF(ExtrabedMarkuptype='Percentage',amount+(amount*ExtrabedMarkup/100)+(amount*".$markup."/100),amount+ExtrabedMarkup+(amount*".$markup."/100)),amount+(sum(amount)*".($markup+$general_markup)."/100)),0) from hotel_tbl_extrabed where a.allotement_date BETWEEN from_date AND to_date AND contract_id = a.contract_id AND hotel_id = a.hotel_id AND FIND_IN_SET(a.room_id, IFNULL(roomType,'')) > 0 AND 
            ".$data['adults'][$key]."
            +IF(0=".$RoomChildAge1.",0,IF(con.max_child_age< ".$RoomChildAge1.",1,0))
            +IF(0=".$RoomChildAge2.",0,IF(con.max_child_age< ".$RoomChildAge2.",1,0))
            +IF(0=".$RoomChildAge3.",0,IF(con.max_child_age< ".$RoomChildAge3.",1,0))
            +IF(0=".$RoomChildAge4.",0,IF(con.max_child_age< ".$RoomChildAge4.",1,0)) > f.standard_capacity ) as extrabed, 
            
         if(".$data['adults'][$key]."
            +IF(0=".$RoomChildAge1.",0,IF(con.max_child_age< ".$RoomChildAge1.",1,0))
            +IF(0=".$RoomChildAge2.",0,IF(con.max_child_age< ".$RoomChildAge2.",1,0))
            +IF(0=".$RoomChildAge3.",0,IF(con.max_child_age< ".$RoomChildAge3.",1,0))
            +IF(0=".$RoomChildAge4.",0,IF(con.max_child_age< ".$RoomChildAge4.",1,0)) > f.standard_capacity,
             
        (select IF(count(1)=0,'',IF(0=".$RoomChildAge1.",0,IF(ChildAgeFrom < ".$RoomChildAge1." && ChildAgeTo >= ".$RoomChildAge1.",IF(ExtrabedMarkup!='' && ChildAmount!=0,IF(ExtrabedMarkuptype='Percentage',ChildAmount+(ChildAmount*ExtrabedMarkup/100), ChildAmount+ExtrabedMarkup) ,ChildAmount+(ChildAmount*".$general_markup."/100))+(ChildAmount*".$markup."/100),0))) from hotel_tbl_extrabed where a.allotement_date BETWEEN from_date AND to_date AND contract_id = a.contract_id AND hotel_id = a.hotel_id AND FIND_IN_SET(a.room_id, IFNULL(roomType,'')) > 0 AND ".($data['adults'][$key]+$data['Child'][$key])." > f.standard_capacity) ,0) as extrabedChild, 

        if(".$data['adults'][$key]."
            +IF(0=".$RoomChildAge1.",0,IF(con.max_child_age< ".$RoomChildAge1.",1,0))
            +IF(0=".$RoomChildAge2.",0,IF(con.max_child_age< ".$RoomChildAge2.",1,0))
            +IF(0=".$RoomChildAge3.",0,IF(con.max_child_age< ".$RoomChildAge3.",1,0))
            +IF(0=".$RoomChildAge4.",0,IF(con.max_child_age< ".$RoomChildAge4.",1,0)) > f.standard_capacity,
        (select IF(count(1)=0,0,IF(0=IF(0=".$RoomChildAge1.",0,IF(con.max_child_age >= ".$RoomChildAge1.",1,0)),0,sum(IF(startAge <= ".$RoomChildAge1." && finalAge >= ".$RoomChildAge1.",IF(BoardSupMarkup!='',IF(BoardSupMarkuptype='Percentage',amount+(amount*BoardSupMarkup/100)+(amount*".$markup."/100),amount+(BoardSupMarkup)+(amount*".$markup."/100)),amount+(amount*".($markup+$general_markup)."/100)),0))))

        +IF(count(1)=0,0,IF(0=IF(0=".$RoomChildAge2.",0,IF(con.max_child_age >= ".$RoomChildAge2.",1,0)),0,sum(IF(startAge <= ".$RoomChildAge2." && finalAge >= ".$RoomChildAge2.",IF(BoardSupMarkup!='',IF(BoardSupMarkuptype='Percentage',amount+(amount*BoardSupMarkup/100)+(amount*".$markup."/100),amount+(BoardSupMarkup)+(amount*".$markup."/100)),amount+(amount*".($markup+$general_markup)."/100)),0))))

        +IF(count(1)=0,0,IF(0=IF(0=".$RoomChildAge3.",0,IF(con.max_child_age >= ".$RoomChildAge3.",1,0)),0,sum(IF(startAge <= ".$RoomChildAge3." && finalAge >= ".$RoomChildAge3.",IF(BoardSupMarkup!='',IF(BoardSupMarkuptype='Percentage',amount+(amount*BoardSupMarkup/100)+(amount*".$markup."/100),amount+(BoardSupMarkup)+(amount*".$markup."/100)),amount+(amount*".($markup+$general_markup)."/100)),0))))

        +IF(count(1)=0,0,IF(0=IF(0=".$RoomChildAge4.",0,IF(con.max_child_age >= ".$RoomChildAge4.",1,0)),0,sum(IF(startAge <= ".$RoomChildAge4." && finalAge >= ".$RoomChildAge4.",IF(BoardSupMarkup!='',IF(BoardSupMarkuptype='Percentage',amount+(amount*BoardSupMarkup/100)+(amount*".$markup."/100),amount+(BoardSupMarkup)+(amount*".$markup."/100)),amount+(amount*".($markup+$general_markup)."/100)),0)))) from hotel_tbl_boardsupplement where a.allotement_date BETWEEN 
        fromDate AND toDate AND contract_id = a.contract_id AND hotel_id = a.hotel_id AND FIND_IN_SET(a.room_id, IFNULL(roomType,'')) > 0 AND IF(con.board='RO',board IN (''),IF(con.board='BB',board IN ('Breakfast'),IF(con.board='HB',board IN ('Breakfast','Dinner'),board IN ('Breakfast','Lunch','Dinner'))))) ,0) as extrabedChild1,

        (select IF(count(1)=0,0,IF(application='Per Person',IF(GeneralSupMarkup!='',IF(GeneralSupMarkuptype='Percentage',(adultAmount*".$data['adults'][$key].")+(adultAmount*".$data['adults'][$key].")*GeneralSupMarkup/100,(adultAmount*".$data['adults'][$key].")+(GeneralSupMarkup*".$data['adults'][$key].")),(adultAmount*".$data['adults'][$key].")+((adultAmount*".$data['adults'][$key].")*".$general_markup."/100)) + ((adultAmount*".$data['adults'][$key].")*".$markup."/100) ,IF(GeneralSupMarkup!='',IF(GeneralSupMarkuptype='Percentage',(adultAmount)+(adultAmount)*GeneralSupMarkup/100,adultAmount+GeneralSupMarkup) ,adultAmount+((adultAmount)*".$general_markup."/100))+((adultAmount)*".$markup."/100)))  
          + 

           IF(count(1)=0,0, IF(0=".$RoomChildAge1." && childAmount=0,0,IF(MinChildAge < ".$RoomChildAge1.", IF(application='Per Person',IF(GeneralSupMarkup!='',IF(GeneralSupMarkuptype='Percentage',(childAmount)+((childAmount)*GeneralSupMarkup/100),(childAmount)+GeneralSupMarkup),(childAmount+((childAmount)*".$general_markup."/100))),IF(GeneralSupMarkup!='',IF(GeneralSupMarkuptype='Percentage',(childAmount)+(childAmount*GeneralSupMarkup/100),childAmount+GeneralSupMarkup) ,childAmount))+((childAmount)*".$markup."/100) ,0) )) 

          + IF(count(1)=0,0, IF(0=".$RoomChildAge2." && childAmount=0,0,IF(MinChildAge < ".$RoomChildAge2.", IF(application='Per Person',IF(GeneralSupMarkup!='',IF(GeneralSupMarkuptype='Percentage',(childAmount)+((childAmount)*GeneralSupMarkup/100),(childAmount)+GeneralSupMarkup),(childAmount+((childAmount)*".$general_markup."/100))),IF(GeneralSupMarkup!='',IF(GeneralSupMarkuptype='Percentage',(childAmount)+(childAmount*GeneralSupMarkup/100),childAmount+GeneralSupMarkup) ,childAmount))+((childAmount)*".$markup."/100) ,0) ))

          +  IF(count(1)=0,0, IF(0=".$RoomChildAge3." && childAmount=0,0,IF(MinChildAge < ".$RoomChildAge3.", IF(application='Per Person',IF(GeneralSupMarkup!='',IF(GeneralSupMarkuptype='Percentage',(childAmount)+((childAmount)*GeneralSupMarkup/100),(childAmount)+GeneralSupMarkup),(childAmount+((childAmount)*".$general_markup."/100))),IF(GeneralSupMarkup!='',IF(GeneralSupMarkuptype='Percentage',(childAmount)+(childAmount*GeneralSupMarkup/100),childAmount+GeneralSupMarkup) ,childAmount))+((childAmount)*".$markup."/100) ,0) ))

          +  IF(count(1)=0,0, IF(0=".$RoomChildAge4." && childAmount=0,0,IF(MinChildAge < ".$RoomChildAge4.", IF(application='Per Person',IF(GeneralSupMarkup!='',IF(GeneralSupMarkuptype='Percentage',(childAmount)+((childAmount)*GeneralSupMarkup/100),(childAmount)+GeneralSupMarkup),(childAmount+((childAmount)*".$general_markup."/100))),IF(GeneralSupMarkup!='',IF(GeneralSupMarkuptype='Percentage',(childAmount)+(childAmount*GeneralSupMarkup/100),childAmount+GeneralSupMarkup) ,childAmount))+((childAmount)*".$markup."/100) ,0) ))

         from hotel_tbl_generalsupplement where a.allotement_date BETWEEN fromDate AND toDate AND contract_id = a.contract_id AND hotel_id = a.hotel_id AND FIND_IN_SET(a.room_id, IFNULL(roomType,'')) > 0 AND  mandatory = 1) as generalsub, 

      (SELECT IF(min(discount)!='',discount,0) FROM `hoteldiscount` where Discount_flag = 1 AND FIND_IN_SET(a.allotement_date,BlackOut)=0  AND Extrabed = 1 AND FIND_IN_SET(a.hotel_id ,hotelid) > 0  AND FIND_IN_SET(a.room_id,room) > 0  AND FIND_IN_SET(a.contract_id,contract) > 0 AND ((Styfrom <= a.allotement_date AND Styto >= a.allotement_date  AND  BkFrom <= '".date('Y-m-d')."' AND BkTo >= '".date('Y-m-d')."'  AND Bkbefore < DATEDIFF(a.allotement_date,'".date('Y-m-d')."') AND numofnights <= ".$tot_days." AND discount_type = 'MLOS')  OR (Styfrom <= a.allotement_date AND Styto >= a.allotement_date  AND  BkFrom <= '".date('Y-m-d')."' AND BkTo >= '".date('Y-m-d')."' AND Bkbefore < DATEDIFF(a.allotement_date,'".date('Y-m-d')."')  AND discount_type = '') OR (Styfrom <= a.allotement_date AND Styto >= a.allotement_date  AND  BkFrom <= '".date('Y-m-d')."' AND BkTo >= '".date('Y-m-d')."' AND discount_type = 'EB') OR (Styfrom <= a.allotement_date AND Styto >= a.allotement_date AND Bkbefore < DATEDIFF(a.allotement_date,'".date('Y-m-d')."')  AND discount_type = 'REB')) order by Bkbefore desc limit 1) as exdis,

         (SELECT IF(min(discount)!='',discount,0) FROM `hoteldiscount` where Discount_flag = 1 AND FIND_IN_SET(a.allotement_date,BlackOut)=0  AND Board = 1 AND FIND_IN_SET(a.hotel_id ,hotelid) > 0  AND FIND_IN_SET(a.room_id,room) > 0  AND FIND_IN_SET(a.contract_id,contract) > 0 AND ((Styfrom <= a.allotement_date AND Styto >= a.allotement_date  AND  BkFrom <= '".date('Y-m-d')."' AND BkTo >= '".date('Y-m-d')."'  AND Bkbefore < DATEDIFF(a.allotement_date,'".date('Y-m-d')."') AND numofnights <= ".$tot_days." AND discount_type = 'MLOS')  OR (Styfrom <= a.allotement_date AND Styto >= a.allotement_date  AND  BkFrom <= '".date('Y-m-d')."' AND BkTo >= '".date('Y-m-d')."' AND Bkbefore < DATEDIFF(a.allotement_date,'".date('Y-m-d')."')  AND discount_type = '') OR (Styfrom <= a.allotement_date AND Styto >= a.allotement_date  AND  BkFrom <= '".date('Y-m-d')."' AND BkTo >= '".date('Y-m-d')."' AND discount_type = 'EB') OR (Styfrom <= a.allotement_date AND Styto >= a.allotement_date AND Bkbefore < DATEDIFF(a.allotement_date,'".date('Y-m-d')."')  AND discount_type = 'REB')) order by Bkbefore desc limit 1) as boarddis,

         (SELECT IF(min(discount)!='',discount,0) FROM `hoteldiscount` where Discount_flag = 1 AND FIND_IN_SET(a.allotement_date,BlackOut)=0  AND General = 1 AND FIND_IN_SET(a.hotel_id ,hotelid) > 0  AND FIND_IN_SET(a.room_id,room) > 0  AND FIND_IN_SET(a.contract_id,contract) > 0 AND ((Styfrom <= a.allotement_date AND Styto >= a.allotement_date  AND  BkFrom <= '".date('Y-m-d')."' AND BkTo >= '".date('Y-m-d')."'  AND Bkbefore < DATEDIFF(a.allotement_date,'".date('Y-m-d')."') AND numofnights <= ".$tot_days." AND discount_type = 'MLOS')  OR (Styfrom <= a.allotement_date AND Styto >= a.allotement_date  AND  BkFrom <= '".date('Y-m-d')."' AND BkTo >= '".date('Y-m-d')."' AND Bkbefore < DATEDIFF(a.allotement_date,'".date('Y-m-d')."')  AND discount_type = '') OR (Styfrom <= a.allotement_date AND Styto >= a.allotement_date  AND  BkFrom <= '".date('Y-m-d')."' AND BkTo >= '".date('Y-m-d')."' AND discount_type = 'EB') OR (Styfrom <= a.allotement_date AND Styto >= a.allotement_date AND Bkbefore < DATEDIFF(a.allotement_date,'".date('Y-m-d')."')  AND discount_type = 'REB')) order by Bkbefore desc limit 1) as generaldis

      FROM hotel_tbl_allotement a INNER JOIN hotel_tbl_contract con ON con.contract_id = a.contract_id 

      LEFT JOIN hotel_tbl_revenue rev ON FIND_IN_SET(a.hotel_id, IFNULL(rev.hotels,'')) > 0 AND FIND_IN_SET(a.contract_id, IFNULL(rev.contracts,'')) > 0 AND  FIND_IN_SET(".$this->session->userdata('agent_id').", IFNULL(rev.Agents,'')) > 0  AND rev.FromDate <= a.allotement_date AND  rev.ToDate >= a.allotement_date

      LEFT JOIN hoteldiscount dis ON FIND_IN_SET(a.hotel_id,dis.hotelid) > 0 AND FIND_IN_SET(a.contract_id,dis.contract) > 0 
      AND FIND_IN_SET(a.room_id,dis.room) > 0 AND Discount_flag = 1 AND (Styfrom <= '".date('Y-m-d',strtotime($data['Check_in']))."' AND Styto >= '".date('Y-m-d',strtotime($data['Check_in']))."' 
      AND BkFrom <= '".date('Y-m-d')."' AND BkTo >= '".date('Y-m-d')."') AND Bkbefore < DATEDIFF(a.allotement_date,'".date('Y-m-d')."') AND FIND_IN_SET(a.allotement_date,BlackOut)=0 
      AND discount_type = 'stay&pay' AND stay_night <= ".$tot_days." INNER JOIN hotel_tbl_hotel_room_type f ON f.id = a.room_id INNER JOIN hotel_tbl_room_type g ON g.id = f.room_type  where (f.max_total >= ".($data['adults'][$key]+$data['Child'][$key])." AND f.occupancy >= ".$data['adults'][$key]."
        +IF(0=".$RoomChildAge1.",0,IF(con.max_child_age< ".$RoomChildAge1.",1,0))
        +IF(0=".$RoomChildAge2.",0,IF(con.max_child_age< ".$RoomChildAge2.",1,0))
        +IF(0=".$RoomChildAge3.",0,IF(con.max_child_age< ".$RoomChildAge3.",1,0))
        +IF(0=".$RoomChildAge4.",0,IF(con.max_child_age< ".$RoomChildAge4.",1,0))

      AND f.occupancy_child >= ".$data['Child'][$key].") AND f.delflg = 1 AND a.allotement_date IN ('".$implode_data."') AND a.contract_id IN ('".$implode_data2."') AND a.amount !=0 AND (SELECT count(*) FROM hotel_tbl_minimumstay WHERE a.allotement_date BETWEEN fromDate AND toDate AND contract_id = a.contract_id AND minDay > ".$tot_days.") = 0  AND a.hotel_id = ".$hotel_id." AND DATEDIFF(a.allotement_date,'".date('Y-m-d')."') >= a.cut_off ) extra ) discal where discal.FinalAmnt!=0 GROUP BY hotel_id,room_id,contract_id HAVING counts = ".$tot_days.") x order by dd asc";
      return $this->db->query($room)->result();
    }
    public function gettravellerdata($id) {
      $this->db->select("*");
      $this->db->from("traveller_details");
      $this->db->where("bookingid",$id);
      $query = $this->db->get()->result();
      return $query;
  }
}
