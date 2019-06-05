<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class HotelSupplier extends MY_Controller {
	
	public function __construct()
     {
          parent::__construct();
          $this->load->helper('url');
          $this->load->helper('html');
          $this->load->model('Supplier_Model');
          $this->load->helper('upload');
          $this->load->helper('common');
     }
	public function index()
	{
          $this->load->view('frontend/supplier');
     }
     public function hotels() {
           $this->load->view('frontend/supplierHotel');
     }
     public function rooms() {
          $this->load->view('frontend/supplierRooms');
     }
     public function addhotelmodal() {
           $data['hotel_facilties'] = $this->Supplier_Model->hotel_facilties_get();
               $data['room_type'] = $this->Supplier_Model->room_type_get();
               $data['room_facilties'] = $this->Supplier_Model->room_facilties_get();
               $data['room_aminities'] = $this->Supplier_Model->room_aminities_get();
               $data['contry']= $this->Supplier_Model->SelectCountry();
               $data['currency_list']= $this->Supplier_Model->currency();
          if (isset($_REQUEST['hotels_edit_id'])) {
               $data['view'] =$this->Supplier_Model->hotel_detail_get($_REQUEST['hotels_edit_id']);
               $this->load->view('frontend/addhotelmodal',$data);
          } else {
               $this->load->view('frontend/addhotelmodal',$data);
          }
     
    }
     public function StateSelect() {
          $data = $this->Supplier_Model->SelectState($_REQUEST['Conid']);
          echo json_encode($data);
     }
     public function add_new_hotel() {
               $last_id = $this->Supplier_Model->maxgetid();
               $hotel_last_id = $last_id[0]['id']+1;
               $passwording = $last_id[0]['id']+423;
               $password = "temp".$passwording."";
               $hotel_code = "HE0".$hotel_last_id."";
               $contract_code = "CON0".$hotel_last_id."";
               $hotel_id = $this->Supplier_Model->add_new_hotel($_REQUEST,$password,$hotel_code);
               if ($hotel_id!="") {
                    for ($i=1; $i <=5 ; $i++) { 
                         if ($_FILES['img'.$i]['name']!="") {
                              handle_hotel_gallery_image_upload($hotel_id,$i);
                         }
                    }
                    $description = 'New hotel added [id:'.$hotel_id.', Hotel Code: '.$hotel_code.']';
                    AgentlogActivity($description);
               }          
               redirect("hotelsupplier/hotels");  
     }
     public function hotel_list() {
          $data = array();
          // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));
          $hotel = $this->Supplier_Model->hotel_list_select();
          foreach($hotel->result() as $key => $r) {
               $cross = '<a href="#" onclick="deletehotelper('.$r->id.');" data-toggle="modal" data-target="#myModal" class="sb2-2-1-edit delete"><i class="red accent-4 fa fa-trash-o" aria-hidden="true"></i></a>';  
               $edit='<a href="addhotelmodal?hotels_edit_id='.$r->id.'" class="sb2-2-1-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
               $view='<a href="hotels/hotel_detail_view?id='.$r->id.'" data-target="#myModal"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                    $data[] = array(
                         $r->hotel_code,
                         '<a><span class="list-enq-name">'.$r->hotel_name.'</span><span class="list-enq-city">'.$r->city.'</span></a>',
                         $r->sale_number.'</br>'.
                         $r->revenu_number,
                         $r->sale_mail.'</br>'.
                         $r->revenu_mail,
                         $r->location,
                         $view,
                         $edit,
                         $cross,
                    );
          }
          $output = array(
               "draw"             => $draw,
                "recordsTotal"    => $hotel->num_rows(),
                "recordsFiltered" => $hotel->num_rows(),
                "data"            => $data
          );
       echo json_encode($output);
     }
     public function checkHotel($hotel) {
          $status = $this->Supplier_Model->checkHotel($hotel);
          if($status!=0) {
               $return['status'] = '1';
          } else {
               $return['status'] = '0';
          }
          echo json_encode($return);
     }

}