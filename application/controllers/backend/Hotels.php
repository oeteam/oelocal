<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Hotels extends MY_Controller {

	public function __construct() 
	{
		parent::__construct();
		$this->load->helper('url');
        $this->load->helper('html');
		$this->load->model("Hotels_Model");
		$this->load->model("List_Model");
		$this->load->model("Tour_Model");
        $this->load->helper('upload');
        $this->load->helper('common');
        $this->load->helper('manuallog');
        $this->load->library('email');
        $this->load->library('Calendar');
	}
	public function index() 
	{
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		$Profilemenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Hotels Profile'); 
		if (count($Profilemenu)!=0 && $Profilemenu[0]->view==1) {
      		$this->load->view('backend/hotels/index');
    	} else {
      		redirect(base_url().'backend/dashboard');
    	}
		
	}
	public function new_hotel()
	{
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}		
		$data = array();
		$data['view'] = array();
		$data['hotel_facilties'] = $this->Hotels_Model->hotel_facilties_get();
		$data['room_type'] = $this->Hotels_Model->room_type_get();
		$data['room_facilties'] = $this->Hotels_Model->room_facilties_get();
		$data['room_aminities'] = $this->Hotels_Model->room_aminities_get();
		$data['contry']= $this->Hotels_Model->SelectCountry();
    	$data['currency_list']= $this->Hotels_Model->currency();
    	$Hotelsprofilesmenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Hotels Profile'); 
		if (isset($_REQUEST['hotels_edit_id'])) {
			$data['view1'] = $this->Hotels_Model->general_settings_select($_REQUEST['hotels_edit_id']);
			$data['view'] =$this->Hotels_Model->hotel_detail_get($_REQUEST['hotels_edit_id']);

			$data['view']['rooms'] = $this->Hotels_Model->hotel_rooms_view($data['view'][0]->hotels_edit_id);
			$data['board'] = array($data['view'][0]->board => $data['view'][0]->board,'RO'=>'RO','BB'=>'BB','HB'=>'HB','FB'=>'FB','AL'=>'AL');
			$data['contract_type'] = array($data['view'][0]->contract_type =>$data['view'][0]->contract_type, 'FIT'=>'FIT','Non Refundable'=>'Non Refundable','Opaque'=>'Opaque');
			$data['classification'] = array($data['view'][0]->classification =>$data['view'][0]->classification,'Normal'=>'Normal','priority'=>'priority');
			$data['application'] = array($data['view'][0]->application =>$data['view'][0]->application,'Per Room'=>'Per Room','Per Person'=>'Per Person');
			$data['rate_type'] = array($data['view'][0]->rate_type =>$data['view'][0]->rate_type,'Net'=>'Net','Commision'=>'Commision');
			$data['tax_percentage'] = array($data['view'][0]->tax_percentage =>$data['view'][0]->tax_percentage,'Included'=>'Included','6'=>'6','8'=>'8','12' => '12','20'=>'20');
			$data['pay_mode'] = array($data['view'][0]->pay_mode =>$data['view'][0]->pay_mode,'Payment'=>'Payment','Prepayment'=>'Prepayment');
			if (count($Hotelsprofilesmenu)!=0 && $Hotelsprofilesmenu[0]->view==1 && $Hotelsprofilesmenu[0]->edit==1) {
			$this->load->view('backend/hotels/new_hotel',$data);
			} else {
	      		redirect(base_url().'backend/dashboard');
	    	}
		} else {
			$data['board'] = array('RO'=>'RO','BB'=>'BB','HB'=>'HB','FB'=>'FB','AL'=>'AL','Breakfast'=>'Breakfast','Lunch'=>'Lunch','Dinner'=>'Dinner');
			$data['contract_type'] = array('FIT'=>'FIT','Non Refundable'=>'Non Refundable','Opaque'=>'Opaque');
			$data['classification'] = array('Normal'=>'Normal','priority'=>'priority');
			$data['application'] = array('Per Room'=>'Per Room','Per Person'=>'Per Person');
			$data['rate_type'] = array('Net'=>'Net','Commision'=>'Commision');
			$data['tax_percentage'] = array('Included'=>'Included','6'=>'6','8'=>'8','12' => '12','20'=>'20');
			$data['pay_mode'] = array('Payment'=>'Payment','Prepayment'=>'Prepayment');
			if (count($Hotelsprofilesmenu)!=0 && $Hotelsprofilesmenu[0]->view==1 && $Hotelsprofilesmenu[0]->create==1) {
			$this->load->view('backend/hotels/new_hotel',$data);
			} else {
	      		redirect(base_url().'backend/dashboard');
	    	}
		}
	}
	public function room_type()
	{
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		$RoomType = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Room Type'); 
		if (count($RoomType)!=0 && $RoomType[0]->view==1) {
			$this->load->view('backend/hotels/room_type');
     	} else {
      		redirect(base_url().'backend/dashboard');
    	}
	}
	public function new_room_type()
	{   
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		$RoomType = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Room Type'); 
		if (isset($_REQUEST['edit_id']) && $_REQUEST['edit_id'] !="") {
			$data['edit'] = $this->Hotels_Model->room_type_single_data($_REQUEST['edit_id']);
			if (count($RoomType)!=0 && $RoomType[0]->view==1 && $RoomType[0]->edit==1) {
			$this->load->view('backend/hotels/new_room_type',$data);
			} else {
	      		redirect(base_url().'backend/dashboard');
	    	}
		} else {
			$data['edit'] =array();
			if (count($RoomType)!=0 && $RoomType[0]->view==1 && $RoomType[0]->create==1) {
				$this->load->view('backend/hotels/new_room_type',$data);
			} else {
	      		redirect(base_url().'backend/dashboard');
	    	}
		}	
	}
	public function add_room_type() {
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		if ($_REQUEST['room_type']=="") {
          $Return['error'] = 'Room Type field is required!';
          $Return['color'] = 'orange';
        } else {
        	if ($_REQUEST['edit_id']!="") {
        		$Update = $this->Hotels_Model->update($_REQUEST['room_type'],$_REQUEST['edit_id']);
				if ($Update==true) {
					$Return['error'] = "Updated Successfully";
	          		$Return['color'] = 'green';
	          		$Return['status'] = '1';
	          		$description = 'Room type details updated[ID: '.$_REQUEST['edit_id'].']';
	          		AdminlogActivity($description);
				} else {
					$Return['error'] = "Updated Unsuccessfully!";
	          		$Return['color'] = 'red';
				}
        	} else {
        		$result = $this->Hotels_Model->insert($_REQUEST['room_type']);
				$Return['error'] = "Inserted Successfully";
          		$Return['color'] = 'green';
          		$Return['status'] = '1';
          		$description = 'New room type details added[ID: '.$result.']';
          		AdminlogActivity($description);
        	}
        }
        echo json_encode($Return);
	}
	public function room_type_list() {
		if ($this->session->userdata('name')==""){
			redirect("../backend/");
		}
		$data = array();
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$room_type = $this->Hotels_Model->select();
		
		foreach($room_type->result() as $key => $r) {
		$RoomType = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Room Type');
		if($RoomType[0]->edit!=0){
			$edit='<a href="new_room_type?edit_id='.$r->id.'" class="sb2-2-1-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
		}else{
            $edit="";
        }
		if($RoomType[0]->delete!=0){
			$delete='<a href="#" onclick="deletefun('.$r->id.');" data-toggle="modal" data-target="#myModal" class="sb2-2-1-edit delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
		}else{
            $delete="";
        }

		$data[] = array(
					$key+1,
					$r->Room_Type,
					$r->Created_Date,
					$edit,
					$delete,
				);
			
      	}
		$output = array(
		   	"draw" => $draw,
			 "recordsTotal" => $room_type->num_rows(),
			 "recordsFiltered" => $room_type->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
	}
	public function delete_room_type() {
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		$result = $this->Hotels_Model->delete_room_type($_REQUEST['delete_id']);
		if ($result==true) {
			$Return['error'] = "Deleted Successfully";
      		$Return['color'] = 'green';
      		$Return['status'] = '1';
      		$description = 'Room type details deleted [ID: '.$_REQUEST['delete_id'].']';
      		AdminlogActivity($description);
		} else {
			$Return['error'] = "Deleted Unsuccessfully!";
      		$Return['color'] = 'red';
		}
        echo json_encode($Return);
	}
	public function hotel_facilities() {
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		$Facilities = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Hotel Facilities'); 
		if (count($Facilities)!=0 && $Facilities[0]->view==1) {
		$this->load->view('backend/hotels/hotel_facilities');
			
     	} else {
      		redirect(base_url().'backend/dashboard');
    	}

	}
	public function new_hotel_facilities() {
        if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		$Facilities = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Hotel Facilities'); 
		if (isset($_REQUEST['facility_edit_id']) && $_REQUEST['facility_edit_id'] !="") {
			$data['facility_edit'] = $this->Hotels_Model->hotel_facility_single_data($_REQUEST['facility_edit_id']);
			$data['icons'] =$this->Hotels_Model->hotel_facility_icons();
			if (count($Facilities)!=0 && $Facilities[0]->view==1 && $Facilities[0]->edit==1) {
			$this->load->view('backend/hotels/new_hotel_facilities',$data);
			
			} else {
	      		redirect(base_url().'backend/dashboard');
	    	}
		} else {
			$data['facility_edit'] =array();
			$data['icons'] =$this->Hotels_Model->hotel_facility_icons();
			if (count($Facilities)!=0 && $Facilities[0]->view==1 && $Facilities[0]->create==1) {
			$this->load->view('backend/hotels/new_hotel_facilities',$data);
			
			} else {
	      		redirect(base_url().'backend/dashboard');
	    	}
		}
	}
	public function hotel_facility_list() {
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		$data = array();
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$hotel_facility = $this->Hotels_Model->hotel_facility_select();
		foreach($hotel_facility->result() as $key => $r) {
		$Facilities = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Hotel Facilities'); 
			if($Facilities[0]->edit!=0){
				$edit='<a href="new_hotel_facilities?facility_edit_id='.$r->id.'" class="sb2-2-1-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
			}else{
            	$edit="";
        	}
			if($Facilities[0]->delete!=0){
				$delete='<a href="#" onclick="hotel_facility_deletefun('.$r->id.');" data-toggle="modal" data-target="#myModal" class="sb2-2-1-edit delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
			}else{
            	$delete="";
        	}
			
				$data[] = array(
					$key+1,
					$r->Hotel_Facility,
					'<span class="list-img"><img src="'.base_url().$r->icon_src.'" alt=""></span>',
					$r->Created_Date,
					$edit,
					$delete,
				);
			
      	}
		$output = array(
		   	"draw" => $draw,
			 "recordsTotal" => $hotel_facility->num_rows(),
			 "recordsFiltered" => $hotel_facility->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
	}
	public function add_hotel_facility() {
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		if ($_REQUEST['hotel_facility']=="") {
          $Return['error'] = 'Hotel Facility field is required!';
          $Return['color'] = 'orange';
        } else if ($_REQUEST['icon']=="") {
          $Return['error'] = 'Icon field is required!';
          $Return['color'] = 'orange';
        }
         else {
        	if ($_REQUEST['facility_edit_id']!="") {
        		$Update = $this->Hotels_Model->hotel_facility_update($_REQUEST['hotel_facility'],$_REQUEST['facility_edit_id'],$_REQUEST['icon']);
				if ($Update==true) {
					$Return['error'] = "Updated Successfully";
	          		$Return['color'] = 'green';
	          		$Return['status'] = '1'; 
	          		$description = 'Hotel facility details edited [ID: '.$_REQUEST['facility_edit_id'].']';
	          		AdminlogActivity($description);
				} else {
					$Return['error'] = "Updated Unsuccessfully!";
	          		$Return['color'] = 'red';
				}
        	} else {
        		$result = $this->Hotels_Model->hotel_facility_insert($_REQUEST['hotel_facility'],$_REQUEST['icon']);
				$Return['error'] = "Inserted Successfully";
          		$Return['color'] = 'green';
          		$Return['status'] = '1';
          		$description = 'New hotel facility added [ID: '.$result.']';
          		AdminlogActivity($description);
        	}
        }
        echo json_encode($Return);
	}
	public function delete_hotel_facility() {
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		$result = $this->Hotels_Model->delete_hotel_facility($_REQUEST['delete_id']);
		if ($result==true) {
			$Return['error'] = "Deleted Successfully";
      		$Return['color'] = 'green';
      		$Return['status'] = '1';
      		$Return['table'] = 'hotel_facility_table';
      		$description = 'Hotel facility details deleted [ID: '.$_REQUEST['delete_id'].']';
	        AdminlogActivity($description);
		} else {
			$Return['error'] = "Deleted Unsuccessfully!";
      		$Return['color'] = 'red';
		}
        echo json_encode($Return);
	}
	public function room_facilities()
	{
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		$RoomFacility = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Room Facilities'); 
		if (count($RoomFacility)!=0 && $RoomFacility[0]->view==1) {
			$this->load->view("backend/hotels/room_facilities");
					
     	} else {
      		redirect(base_url().'backend/dashboard');
    	}
	}
	public function new_room_facilities()
	{
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		$RoomFacility = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Room Facilities'); 
		if (isset($_REQUEST['room_facility_edit_id']) && $_REQUEST['room_facility_edit_id'] !="") {
			$data['room_facility_edit'] = $this->Hotels_Model->room_facility_single_data($_REQUEST['room_facility_edit_id']);
			$data['icons'] =$this->Hotels_Model->hotel_facility_icons();
			if (count($RoomFacility)!=0 && $RoomFacility[0]->view==1 && $RoomFacility[0]->edit==1) {
			$this->load->view("backend/hotels/new_room_facilities",$data);			
			} else {
	      		redirect(base_url().'backend/dashboard');
	    	}
		} else {
			$data['icons'] =$this->Hotels_Model->hotel_facility_icons();
			$data['room_facility_edit'] =array();
			if (count($RoomFacility)!=0 && $RoomFacility[0]->view==1 && $RoomFacility[0]->create==1) {
			$this->load->view("backend/hotels/new_room_facilities",$data);			
			} else {
	      		redirect(base_url().'backend/dashboard');
	    	}
		}
	}
	public function add_room_facility() {
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		if ($_REQUEST['room_facility']=="") {
          $Return['error'] = 'Room Facility field is required!';
          $Return['color'] = 'orange';
        } else if ($_REQUEST['icon']=="") {
          $Return['error'] = 'Icon field is required!';
          $Return['color'] = 'orange';
        } else {
        	if ($_REQUEST['room_facility_edit_id']!="") {
        		$Update = $this->Hotels_Model->room_facility_update($_REQUEST['room_facility'],$_REQUEST['room_facility_edit_id'],$_REQUEST['icon']);
				if ($Update==true) {
					$Return['error'] = "Updated Successfully";
	          		$Return['color'] = 'green';
	          		$Return['status'] = '1';
	          		$description = 'Room facility details edited [ID: '.$_REQUEST['room_facility_edit_id'].']';
	          		AdminlogActivity($description);
				} else {
					$Return['error'] = "Updated Unsuccessfully!";
	          		$Return['color'] = 'red';
				}
        	} else {
        		$result = $this->Hotels_Model->room_facility_insert($_REQUEST['room_facility'],$_REQUEST['icon']);
				$Return['error'] = "Inserted Successfully";
          		$Return['color'] = 'green';
          		$Return['status'] = '1';
          		$description = 'New room facility details added [ID: '.$result.']';
          		AdminlogActivity($description);
        	}
        }
        echo json_encode($Return);
	}
	public function room_facility_list() {
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		$data = array();
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$room_facility = $this->Hotels_Model->room_facility_select();
		foreach($room_facility->result() as $key => $r) {
			$RoomFacility = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Room Facilities'); 
			if($RoomFacility[0]->edit!=0){
				$edit='<a href="new_room_facilities?room_facility_edit_id='.$r->id.'" class="sb2-2-1-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
			}else{
            	$edit="";
        	}
			if($RoomFacility[0]->delete!=0){
				$delete='<a href="#" onclick="room_facility_deletefun('.$r->id.');" data-toggle="modal" data-target="#myModal" class="sb2-2-1-edit delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
			}else{
            	$delete="";
        	}
			
				$data[] = array(
					$key+1,
					$r->Room_Facility,
					'<span class="list-img"><img src="'.base_url().$r->icon_src.'" alt=""></span>',
					$r->Created_Date,
					$edit,
					$delete,
				);
			
      	}
		$output = array(
		   	"draw" 		      => $draw,
			"recordsTotal"    => $room_facility->num_rows(),
			"recordsFiltered" => $room_facility->num_rows(),
			"data"            => $data
		);
	  echo json_encode($output);
	}
	public function delete_room_facility() {
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		$result = $this->Hotels_Model->delete_room_facility($_REQUEST['delete_id']);
		if ($result==true) {
			$Return['error'] = "Deleted Successfully";
      		$Return['color'] = 'green';
      		$Return['status'] = '1';
      		$Return['table'] = 'room_facility_table';
      		$description = 'Room facility details deleted [ID: '.$_REQUEST['delete_id'].']';
	        AdminlogActivity($description);
		} else {
			$Return['error'] = "Deleted Unsuccessfully!";
      		$Return['color'] = 'red';
		}
        echo json_encode($Return);
	}
	public function add_new_hotel() {
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}

		if ($_REQUEST['hotels_edit_id']!="") {
			
			$update = $this->Hotels_Model->update_hotel($_REQUEST,$_REQUEST['hotels_edit_id']);
			if ($_REQUEST['deleted_id']!="") {
				$deleted_id = explode(",", $_REQUEST['deleted_id']);
				foreach ($deleted_id as $key => $value) {
					$this->Hotels_Model->delete_roomss($value);
				}
			}
			for ($i=1; $i <=5 ; $i++) { 
				if ($_FILES['img'.$i]['name']!="") {
					handle_hotel_gallery_image_upload($_REQUEST['hotels_edit_id'],$i);
				}
			}
			$description = 'Hotel details updated [id:'.$_REQUEST['hotels_edit_id'].', Hotel Code: HE0'.$_REQUEST['hotels_edit_id'].']';
            	AdminlogActivity($description);
		} else {
			$last_id = $this->Hotels_Model->maxgetid();
	        $hotel_last_id = $last_id[0]['id']+1;
	        $passwording = $last_id[0]['id']+423;
	        $password = "temp".$passwording."";
	        $hotel_code = "HE0".$hotel_last_id."";
	        $contract_code = "CON0".$hotel_last_id."";
			$hotel_id = $this->Hotels_Model->add_new_hotel($_REQUEST,$password,$hotel_code);
			if ($hotel_id!="") {
				for ($i=1; $i <=5 ; $i++) { 
					if ($_FILES['img'.$i]['name']!="") {
						handle_hotel_gallery_image_upload($hotel_id,$i);
					}
				}
				$description = 'New hotel added [id:'.$hotel_id.', Hotel Code: '.$hotel_code.']';
            	AdminlogActivity($description);
			}
		}
		
		redirect("../backend/hotels");
	}
	public function hotel_list() {
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		$data = array();
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		if (isset($_REQUEST['filter'])) {
			$filter = $_REQUEST['filter'];
		} else {
			$filter = "1";
		}
		$hotel = $this->Hotels_Model->hotel_list_select($filter);
		foreach($hotel->result() as $key => $r) {
		$Profilemenu =   menuPermissionAvailability($this->session->userdata('id'),'Hotels','Hotels Profile');
		$roomMenu =   menuPermissionAvailability($this->session->userdata('id'),'Hotels','Rooms');
			if($Profilemenu[0]->delete!=0)  {
				if ($r->delflg==0) {
					$permission = '<a href="#" onclick="hotelpermissionfun('.$r->id.',1);"  class="sb2-2-1-edit delete"><i class="fa fa-unlock-alt" aria-hidden="true"></i></a>';
				} else if ($r->delflg==2) {
					$permission = '<a href="#" onclick="hotelpermissionfun('.$r->id.',1);" class="sb2-2-1-edit delete"><i class="fa fa-check" aria-hidden="true"></i></a>
						<a href="#" onclick="deletehotelfun('.$r->id.');" data-toggle="modal" data-target="#myModal" class="sb2-2-1-edit delete"><i class="fa fa-ban red" aria-hidden="true"></i></a>';
				} else {
					$permission = '<a href="#" onclick="deletehotelfun('.$r->id.');" data-toggle="modal" data-target="#myModalban" class="sb2-2-1-edit delete"><i class="fa fa-ban red" aria-hidden="true"></i></a>';

				}

					
				$cross = '<a href="#" onclick="deletehotelper('.$r->id.');" data-toggle="modal" data-target="#myModal" class="sb2-2-1-edit delete"><i class="red accent-4 fa fa-trash-o" aria-hidden="true"></i></a>';	

			}else{
				 $permission="";
				 $cross="";

			}
			if($Profilemenu[0]->edit!=0) {
				$edit='<a href="hotels/new_hotel?hotels_edit_id='.$r->id.'" class="sb2-2-1-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
			}else{
				$edit="";
			}
			if($Profilemenu[0]->view!=0) {
				$view='<a href="hotels/hotel_detail_view?id='.$r->id.'"><i class="fa fa-eye" aria-hidden="true"></i></a>';
			}else{
				$view="";
			}
			if($roomMenu[0]->view!=0) {
				$roomView='<a title="view rooms" class="primary" href="hotels/hotel_rooms?id='.$r->id.'"><i class="light-blue darken-4 fa fa-arrow-circle-right" aria-hidden="true"></i></a>';
			}else{
				$roomView="";
			}
				if ($r->supplierName=="Otelseasy") {
					$supplierName = $r->supplierName;
				} else {
					$supplierName = '<a class="text-primary bold" style="color:blue" href="'.base_url().'/backend/agents/new_agent?edit_id='.$r->supplierid.'">'.$r->supplierName.'</a>';
				}
				$data[] = array(
					$roomView,
					$r->hotel_code,
					'<a><span class="list-enq-name">'.$r->hotel_name.'</span><span class="list-enq-city">'.$r->city.'</span></a>',
					$r->sale_number.'</br>'.
					$r->revenu_number,
					$r->sale_mail.'</br>'.
					$r->revenu_mail,
					$supplierName,
					$r->location,
	          		$view,
	          		$edit,
					$permission."".$cross,
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
	public function delete_hotel() {
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		$mail_settings = mail_details();
		$hotel_mail_details = $this->Hotels_Model->hotel_mail_details($_REQUEST['delete_id']);
		$hotel=$this->Hotels_Model->GetTitle();
		$result = $this->Hotels_Model->deletehotel($_REQUEST['delete_id']);
		if ($result==true) {
			$Return['error'] = "Blocked Successfully";
      		$Return['color'] = 'green';
      		$Return['status'] = '1';
      		$Return['table'] = 'hotel_table';
      		$description = 'Hotel blocked [id:'.$_REQUEST['delete_id'].', Hotel Code: HE0'.$_REQUEST['delete_id'].']';
            AdminlogActivity($description);
      		$subject = 'Your hotel Rejected';    		
		    $message = '<div class="wrapper" style="max-width: 400px;
                    width: 100%;
                    margin: 5% auto;
                    border-radius: 3px;
                     box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);">
                  <header style="padding: 10px 10%;
                    text-align: center;">
                    <img src="'.base_url().'skin/images/logo.png" alt="" style="width: 200px;">
                  </header>
                  <section style="padding: 10px 10%;text-align: center;">
                    <h2 style="text-align: center;">Sorry your hotel rejected!</h2>
                    <div style="margin-top: 25px;
                    margin-bottom: 10px;
                    display: inline-block;"><a style="background-color: #0074b9;
                        color: #fff;
                        text-decoration: none;
                        padding: 6px 12px;
                        border-radius: 3px;
                        box-shadow: 0 1px 2px 0 rgba(0,0,0,0.3);
                        letter-spacing: .5px;
                        text-transform: uppercase;" href="javascript:void()">Contact Admin</a></div>
                    <p style="color: cornsilk;
                    text-align: center;
                    color: #90A4AE;">We are sorry to inform you that your application has been Rejected.Sorry for the inconvenience...</p>
                  </section>
                  <footer style="text-align: center;
                    padding: 1px;
                    background-color: #37474F;
                    color: #fff;
                    border-radius: 0 0 3px 3px;">
                    <p>'.$hotel[0]->Title.' | 2017</p>
                  </footer>
                </div>';
		      $this->email->from($mail_settings[0]->smtp_user, $mail_settings[0]->company_name);
		      $this->email->to($hotel_mail_details[0]->contract_mail);
		      $this->email->Bcc($hotel_mail_details[0]->revenu_mail);
		      $this->email->Bcc($hotel_mail_details[0]->sale_mail);
		      $this->email->Bcc($hotel_mail_details[0]->finance_mail);		      
		      $this->email->subject($subject);
		      $this->email->message($message);		      
		      $this->email->send();
		} else {
			$Return['error'] = "Blocked Unsuccessfully!";
      		$Return['color'] = 'red';
      		$Return['table'] = 'hotel_table';
		}
        echo json_encode($Return);
	}
	public function hotel_detail_view() {
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		$data['view'] =$this->Hotels_Model->hotel_detail_get($_REQUEST['id']);
		$data['view1'] =$this->Hotels_Model->hotel_detail_get_room_type($_REQUEST['id']);
		$val=explode(",", $data['view'][0]->room_aminities);
		foreach ($val as $key => $value) {
			$data['room_aminities'][$key] =$this->Hotels_Model->get_aminity_text($value);
		}
		$hotel_facilities = explode(",",$data['view'][0]->hotel_facilities); 
		foreach ($hotel_facilities as $key => $value) {
			$data['hotel_facilities'][$key] = $this->Hotels_Model->hotel_facilities($value);
		}
       $room_facilities = explode(",",$data['view'][0]->room_facilities);
       foreach ($room_facilities as $key => $value) {
        $data['room_facilities'][$key] = $this->List_Model->room_facilities_data($value);
      } 
       $data['view']['rooms'] = $this->Hotels_Model->hotel_rooms_view($data['view'][0]->hotel_id);
		  foreach ($data['view']['rooms'] as $key => $value) {
					$data['view']['room_facilities'][$key] = explode(",",$value->room_facilities);
		  }
		 if ($data['view'][0]->board!="" && isset($data['view'][0]->board)) {
          $data['board'] = array($data['view'][0]->board => $data['view'][0]->board,'RO'=> 'RO' ,'BB' => 'BB','HB' => 'HB','FB' => 'FB','AL' => 'AL'); 
        } else {
          $data['board'] = array('' => '','RO'=> 'RO' ,'BB' => 'BB','HB' => 'HB','FB' => 'FB','AL' => 'AL'); 
        }
        // print_r($data['room_aminities']);
        // exit();
		$this->load->view('backend/hotels/hotel_detail_view',$data);
	}
	public function room_detail_viewing() {
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
	    $data['view'] =$this->Hotels_Model->hotel_detail_view_room_type($_REQUEST['id']);
		$room_facilities = explode(",",$data['view'][0]->room_facilities);
        foreach ($room_facilities as $key => $value) {
        	$data['room_facilities'][$key] = $this->List_Model->room_facilities_data($value);
        }  
	    $this->load->view('backend/hotels/room_modal',$data); 
    }
  	public function permission() {
	  	$mail_settings = mail_details();
	    $hotel_mail_details = $this->Hotels_Model->hotel_mail_details($_REQUEST['id']);
	    $hotel=$this->Hotels_Model->GetTitle();
	if ($_REQUEST['flag']==0) {
	      $message = 'hotel Rejected';
	      $subject = 'Rejected';
	      $this->email->from($mail_settings[0]->smtp_user, $mail_settings[0]->company_name);
	      $this->email->to($hotel_mail_details[0]->sale_mail);
	      // $this->email->cc($hotel_mail_details[0]->revenu_mail);
	      
	      $this->email->subject("Test");
	      $this->email->message($message);
	      
	      $this->email->send();
    } else if($_REQUEST['flag']==1) {
      $passwording = $_REQUEST['id']+423;
      $password = "temp".$passwording."";
      $update_password =  $this->Hotels_Model->update_hotel_pwd($_REQUEST,$password);
      $subject = 'Accepted';
      $message = '<div class="wrapper" style="max-width: 400px;
                    width: 100%;
                    margin: 5% auto;
                    border-radius: 3px;
                     box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);">
                  <header style="padding: 10px 10%;
                    text-align: center;">
                    <img src="'.base_url().'skin/images/logo.png" alt="" style="width: 200px;">
                  </header>
                  <section style="padding: 10px 10%;text-align: center;">
                    <h2 style="text-align: center;">Welcome to hotel easy</h2>
                    <div style="margin-top: 25px;
                    margin-bottom: 10px;
                    display: inline-block;"><a style="background-color: #0074b9;
                        color: #fff;
                        text-decoration: none;
                        padding: 6px 12px;
                        border-radius: 3px;
                        box-shadow: 0 1px 2px 0 rgba(0,0,0,0.3);
                        letter-spacing: .5px;
                        text-transform: uppercase;" href="javascript:void()">Try to login</a></div>
                    <p style="color: cornsilk;
                    text-align: center;
                    color: #90A4AE;">Your hotel id : HE0'.$_REQUEST['id'].'</p>
                    <p style="color: cornsilk;
                    text-align: center;
                    color: #90A4AE;">Your password : '.$password.'</p>
                  </section>
                  <footer style="text-align: center;
                    padding: 1px;
                    background-color: #37474F;
                    color: #fff;
                    border-radius: 0 0 3px 3px;">
                    <p>'.$hotel[0]->Title.' | 2017</p>
                  </footer>
                </div>';
      $this->email->from($mail_settings[0]->smtp_user, $mail_settings[0]->company_name);
      $this->email->to($hotel_mail_details[0]->sale_mail);
      // $this->email->cc($hotel_mail_details[0]->revenu_mail);
      
      $this->email->subject($subject);
      $this->email->message($message);
      
      $this->email->send();
    }
  	$result = $this->Hotels_Model->hotel_permission($_REQUEST);
	redirect("../backend/hotels/hotel_detail_view?id=".$_REQUEST['id']);

  }
  public function hotelpermission() {
  	$mail_settings = mail_details();
  	 $hotel=$this->Hotels_Model->GetTitle();
    $hotel_mail_details = $this->Hotels_Model->hotel_mail_details($_REQUEST['id']);
	  $passwording = $_REQUEST['id']+mt_rand(100,999);
	  $password_reset = $this->Hotels_Model->reset_password($_REQUEST['id']);
	  $password = "temp".$passwording."";
	  $update_password =  $this->Hotels_Model->update_hotel_pwd($_REQUEST,$password);
	  $subject = 'Accepted';
	  $message = '<div class="wrapper" style="max-width: 400px;
	                width: 100%;
	                margin: 5% auto;
	                border-radius: 3px;
	                 box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);">
	              <header style="padding: 10px 10%;
	                text-align: center;">
	                <img src="'.base_url().'skin/images/logo.png" alt="" style="width: 200px;">
	              </header>
	              <section style="padding: 10px 10%;text-align: center;">
	                <h2 style="text-align: center;">Welcome to hotel easy</h2>
	                <div style="margin-top: 25px;
	                margin-bottom: 10px;
	                display: inline-block;"><a style="background-color: #0074b9;
	                    color: #fff;
	                    text-decoration: none;
	                    padding: 6px 12px;
	                    border-radius: 3px;
	                    box-shadow: 0 1px 2px 0 rgba(0,0,0,0.3);
	                    letter-spacing: .5px;
	                    text-transform: uppercase;" href="javascript:void()">Welcome abroad!</a></div>
	                <p style="color: cornsilk;
	                text-align: center;
	                color: #90A4AE;">Your hotel id : HE0'.$_REQUEST['id'].'</p>
	                <p style="color: cornsilk;
	                text-align: center;
	                color: #90A4AE;">Your password : '.$password.'</p>
	                <p style="color: cornsilk;
	                text-align: center;
	                color: #90A4AE;"><a href="'.base_url().'hotel_panel">Click here to Login</a> <br>Kindly change your password after logging in.</p>
	              </section>
	              <footer style="text-align: center;
	                padding: 1px;
	                background-color: #37474F;
	                color: #fff;
	                border-radius: 0 0 3px 3px;">
	                <p>'.$hotel[0]->Title.' | 2017</p>
	              </footer>
	            </div>';
	  $this->email->from($mail_settings[0]->smtp_user, $mail_settings[0]->company_name);
	  $this->email->to($hotel_mail_details[0]->sale_mail);
	  $this->email->cc($hotel_mail_details[0]->revenu_mail);
	  
	  $this->email->subject($subject);
	  $this->email->message($message);
	  
	  $this->email->send();
  	$result = $this->Hotels_Model->hotel_permission($_REQUEST);
  	$description = 'Hotel unblocked [id:'.$_REQUEST['id'].', Hotel Code: HE0'.$_REQUEST['id'].']';
    AdminlogActivity($description);
  	echo json_encode("success");
  }
  public function hotel_rooms() {
      $roomMenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Rooms'); 
	  if (count($roomMenu)!=0 && $roomMenu[0]->view==1) {
		$this->load->view('backend/hotels/hotel_rooms'); 			
	  } else {
	    redirect(base_url().'backend/dashboard');
	  }
  }
  public function hotel_room_list() {
  	if ($this->session->userdata('name')=="") {
			redirect("../backend/");
	}
	$roomMenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Rooms'); 
	$data = array();
	// Datatables Variables
	$draw = intval($this->input->get("draw"));
	$start = intval($this->input->get("start"));
	$length = intval($this->input->get("length"));
  	$rooms = $this->Hotels_Model->hotel_rooms_list($_REQUEST['id']);
  		foreach($rooms->result() as $key => $r) {
  			if (count($roomMenu)!=0 && $roomMenu[0]->edit==1) {
				$edit = '<a href="#"  data-toggle="modal"onclick="edit_room('.$r->id.');"  data-target="#large_modal" class="sb2-2-1-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';		
			} else {
			   $edit='';
			}
			if (count($roomMenu)!=0 && $roomMenu[0]->delete==1) {
				$delete = '<a  href="#" onclick="deleteroomfun('.$r->id.');" data-toggle="modal" data-target="#myModal" class="sb2-2-1-edit delete"><i class="red accent-4 fa fa-trash-o" aria-hidden="true"></i></a>';		
			} else {
			   $delete='';
			}
  			if ($r->delflg==1) {
  				$status = "<span class='text-success bold'>Active</span>";
  			} else {
  				$status = "<span class='text-danger bold'>Inactive</span>";
  			}
  			if ($r->linked_to_room_type!="" && $r->linked_to_room_type!=Null) {
  				$linked_room_type = $this->Hotels_Model->room_type_single_data_get($r->linked_to_room_type,$r->hotel_id);
  			} else {
  				$linked_room_type="";
  			}
  			if ($r->images!="") {
             	$img_path = base_url()."uploads/rooms/".$r->id."/".$r->images."";
	        } else {
	            $img_path = base_url()."assets/images/user/1.png";
	        }
			$data[] = array(
				'<span class="list-img"><img src="'.$img_path.'" alt=""></span>',
				$r->room_name,
				$r->room_type_name,
				$linked_room_type,
				$r->total_rooms,
				$r->standard_capacity,
				$r->occupancy,
				$r->occupancy_child,
				$r->max_total,
				$status,
				$edit.$delete				
			);
      	}
		$output = array(
		   	"draw" => $draw,
			 "recordsTotal" => $rooms->num_rows(),
			 "recordsFiltered" => $rooms->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
   }
    public function room_add_popup() {
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
	    $data['room_type'] = $this->Hotels_Model->room_type_get();
		$data['room_facilties'] = $this->Hotels_Model->room_facilties_get();
		$roomMenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Rooms');
		if (isset($_REQUEST['room_id'])) {
			$data['title'] = "Edit Room";
			$data['view'] =$this->Hotels_Model->hotel_detail_view_room_type($_REQUEST['room_id']);
			$data['room_names'] = $this->Hotels_Model->room_names_get($data['view'][0]->hotel_id);
			$data['linkedRooms'] = $this->Hotels_Model->LinkedRoomDetailsGet($data['view'][0]->hotel_id,$_REQUEST['room_id']);
			if (count($roomMenu)!=0 && $roomMenu[0]->view==1 && $roomMenu[0]->edit==1) {
				$this->load->view('backend/hotels/room_add_modal',$data);  			
	  		} else {
	    		redirect(base_url().'backend/dashboard');
	  		}
		} else {
			$data['title'] = "Add Room";
			$data['linkedRooms'] = $this->Hotels_Model->LinkedRoomDetailsGet($_REQUEST['id'],"");
			if (count($roomMenu)!=0 && $roomMenu[0]->view==1 && $roomMenu[0]->create==1) {
				$this->load->view('backend/hotels/room_add_modal',$data);  			
	  		} else {
	    		redirect(base_url().'backend/dashboard');
	  		}
		}	   
    }
    public function hotels_room_allotement_room_name() {
    	$room_names= $this->Hotels_Model->room_names_get($_REQUEST['hotel_id']);
    	$data['room_names'] =  $room_names;
    	echo json_encode($data);
    }
    public function hotels_room_allotement_room_type() {
    	$room_names= $this->Hotels_Model->allotement_room_type_get($_REQUEST['hotel_id'],$_REQUEST['room_name']);
    	$data['room_type'] =  $room_names;
    	echo json_encode($data);
    }
    public function hotels_room_allotement_room_id() {
    	$room_names= $this->Hotels_Model->allotement_room_id_get($_REQUEST['hotel_id'],$_REQUEST['room_name'],$_REQUEST['room_type']);
    	$data['room_id'] =  $room_names[0]->id;
    	echo json_encode($data);
    }
    public function add_room_allotement() {

    	if ($_REQUEST['room_id']!="") {

    		$update = $this->Hotels_Model->update_room($_REQUEST);
    		if ($_FILES['image-file']['name']!="") {
				handle_hotel_room_image_login_upload($_REQUEST['room_id']);
		 	}
		 	$description = 'Room details updated [id:'.$_REQUEST['room_id'].', Hotel Code: HE0'.$_REQUEST['hotel_id'].']';
            AdminlogActivity($description);
    	} else {
			$hotel_room_id = $this->Hotels_Model->add_new_room($_REQUEST);
			handle_hotel_room_image_login_upload($hotel_room_id);
			$description = 'New room added [id:'.$hotel_room_id.', Hotel Code: HE0'.$_REQUEST['hotel_id'].']';
            AdminlogActivity($description);
    	}
    	redirect("../backend/hotels/hotel_rooms?id=".$_REQUEST['hotel_id']);
    }
    public function delete_room() {
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		$result = $this->Hotels_Model->delete_room($_REQUEST['delete_id']);
		if ($result==true) {
			$Return['error'] = "Deleted Successfully";
      		$Return['color'] = 'green';
      		$Return['status'] = '1';
      		$Return['table'] = 'room_table';
      		$description = 'Room details deleted [id:'.$_REQUEST['delete_id'].']';
            AdminlogActivity($description);
		} else {
			$Return['error'] = "Deleted Unsuccessfully!";
      		$Return['color'] = 'red';
      		$Return['table'] = 'room_table';
		}
        echo json_encode($Return);
	}
	public function room_rate() {
		// print_r($data['room_amount']);
  	    // exit();
  	    
        $data['view'] = $this->Hotels_Model->date_hotel_excel($_REQUEST['id']);
        $data['cutt_off'] = $this->Hotels_Model->room_rate_cutt_off_details($_REQUEST['id']);
  	    $data['view1'] = $this->Hotels_Model->hotel_rooms_list_count($_REQUEST['id']);
		$rooms = $this->Hotels_Model->hotel_rooms_list($_REQUEST['id']);
  	    $data['room_list'] = $rooms->result();
  	    foreach ($data['room_list'] as $key => $value) {
  	    	$data['room_amount'][] = $this->Hotels_Model->hotel_rooms_list_amount($value->id);
  	    }
  	    // print_r($data['room_amount']);
  	    // exit();
        $this->load->view('backend/hotels/room_rate',$data); 
    }
    public function hotel_room_list_excel() {
	  	if ($this->session->userdata('name')=="") {
				redirect("../backend/");
		}
  	    $check['view1'] = $this->Hotels_Model->hotel_rooms_list_count_check($_REQUEST['id']);
		$check['view2'] = $this->Hotels_Model->hotel_rooms_list_checking($_REQUEST['id']);
		$check['view3'] = $this->Hotels_Model->hotel_rooms_date_checking($_REQUEST['id']);
		$namez=$check['view1'][0]->room_name;
		$typez=$check['view1'][0]->room_type;
		if ((count($check['view2'])==0) && (count($check['view3']==0))){
        	$insert_date = $this->Hotels_Model->hotel_rooms_date_checking_insert($_REQUEST['id']);
			$rqst_update=$check['view1'];
        	$insert = $this->Hotels_Model->hotel_rooms_list_checking_insert($_REQUEST['id'],$namez,$typez);
        	redirect('../backend/hotels/hotel_room_list_excel?id='.$_REQUEST['id'].'');
             }
        else{
		$data = array();
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
        $rooms['view1'] = $this->Hotels_Model->hotel_rooms_list_exel1($_REQUEST['id']);
	  		foreach($rooms['view1']->result() as $key => $r) {	
				$data[] = array(
          			'<input type="hidden" name="room_id[]" id="room_id" value="'.$r->room_id.'"><input type="hidden" name="row_id[]" id="row_id" value="'.$r->row_id.'">'.$r->room.'',
					    $r->typ,
					'<input type="text" class="form-control" style="width: 60%; height: 10%;"  id="high1" name="high1[]" value="'.$r->high_1.'" >',
					'<input type="text" class="form-control" style="width: 60%; height: 10%;"  id="shoulder" name="shoulder[]" value="'.$r->shoulder_1.'">',
					'<input type="text" class="form-control" style="width: 60%; height: 10%;"  id="peak1" name="peak1[]" value="'.$r->peak_1.'">',
					'<input type="text" class="form-control" style="width: 60%; height: 10%;"  id="peak2" name="peak2[]" value="'.$r->peak_2.'">',
					'<input type="text" class="form-control" style="width: 60%; height: 10%;"  id="shoulder2" name="shoulder2[]" value="'.$r->shoulder_2.'">',
					'<input type="text" class="form-control" style="width: 60%; height: 10%;"  id="high2" name="high2[]" value="'.$r->high_2.'">',
					'<input type="text" class="form-control" style="width: 60%; height: 10%;"  id="low" name="low[]" value="'.$r->low.'">',
					'<input  style="width: 60%; height: 10%;"  id="d_price" name="d_price[]" value="'.$r->default_price.'" readonly>',
				
				);

			$output = array(
			   	"draw" => $draw,
				 "recordsTotal" => $rooms['view1']->num_rows(),
				 "recordsFiltered" => $rooms['view1']->num_rows(),
				 "data" => $data
			);
			}

		  echo json_encode($output);
		  exit();
		}
    }
    public function hotel_excel_update() {
   	    $u_id=$_REQUEST['hotel_id'];
   	    //$t_id=$_REQUEST['id'];
   	    $data = $this->Hotels_Model->room_rate_setting_date_update($_REQUEST);

   	    foreach ($_REQUEST['id'] as $key => $value) {
   	    	$data1=$this->Hotels_Model->room_rate_setting_amount_update($_REQUEST['id'][$key],$_REQUEST['hotel_id'],$_REQUEST['room_id'][$key],$_REQUEST['high_1'][$key],$_REQUEST['shoulder_1'][$key],$_REQUEST['peak_1'][$key],$_REQUEST['peak_2'][$key],$_REQUEST['shoulder_2'][$key],$_REQUEST['high_2'][$key],$_REQUEST['low'][$key]);
   	    }
   	    $data2 = $this->Hotels_Model->room_rate_setting_release_cuttoff_update($_REQUEST);
	    redirect('../backend/hotels/room_rate?id='.$u_id.'');
    }
    public function minimum_stay() {
   		
   		$data['view'] = $this->Hotels_Model->date_hotel_minimum_stay($_REQUEST['id']);
   		$data['view1'] = $this->Hotels_Model->date_hotel_close_period($_REQUEST['id']);
        $this->load->view('backend/hotels/room_minimum_stay',$data);

    }
    public function hotel_minimum_stay_update() {
	  	$hotel_id=$_REQUEST['hotel_id'];
	  	$data= $this->Hotels_Model->close_out_period_setting_date($_REQUEST);
	  	redirect('../backend/hotels/minimum_stay?id='.$hotel_id.'');
    }
    // public function hotel_observation() {
	  	// $data['view']= $this->Hotels_Model->observation_comment_get($_REQUEST);
	  	// $this->load->view('backend/hotels/observation',$data);
    // }
	public function hotel_observation_comment_update() {
		$data= $this->Hotels_Model->observation_comment_update($_REQUEST);
		redirect('../backend/hotels/hotel_rooms?id='.$_REQUEST['hotel_id'].'');
	}
	public function allotement() {
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		$redirect_con = "false";
		$rooms = $this->Hotels_Model->hotel_rooms_list($_REQUEST['id']);
		$data['contract'] = $this->Hotels_Model->hotel_contract_list($_REQUEST['id']);
		$data['hotels'] = $this->Hotels_Model->contract_hotel_list();
		$data['rooms'] = $rooms->result();
		foreach ($data['contract'] as $key => $value) {
			if ($value->contract_id!=$_REQUEST['con_id']) {
				$contract_check[] =  'false';
			} else {
				$contract_check[] =  "true";
			}
		}
		foreach (array_count_values($contract_check) as $key1 => $value1) {
			if ($key1=="true") {
				$redirect_con = 'true';
				break;
			}
		}
		if ($redirect_con=="false") {
            redirect(base_url()."backend/hotels/allotement?year=".$_REQUEST['year']."&month=".$_REQUEST['month']."&id=".$_REQUEST['id']."&con_id=".$data['contract'][0]->contract_id."&room_id=".$data['rooms'][0]->id."");
		}
		
		$calendar = new Calendar();
		$data['calendar'] = $calendar->show();
		$this->load->view('backend/hotels/allotement',$data);
	}
	public function hotel_detail_permission() {
		
		$data['view']  = $this->Hotels_Model->permission_agent_list($_REQUEST['id'])->result();
    	$data['view1'] = $this->Hotels_Model->permission_agent_id($_REQUEST['id']);
		$this->load->view('backend/hotels/hotel_detail_permission',$data);
	}
    public function permission_update() {
        if ($this->session->userdata('name')=="") {
            redirect("/logout");
    }
        foreach ($_REQUEST['id'] as $key => $value) {
            $id[$key] =  $value;
            if (isset($_REQUEST['voc_set_dr'][$key])) {
                $per = '1';
            } else {
                $per = '0';
            }
            

            $update = $this->Hotels_Model->permission_setting_update($_REQUEST['id'][$key],$_REQUEST['id'], $per);
        }
        redirect("../backend/hotels/hotel_detail_permission");
    }
	public function hotels_closeout_period() {
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
	    $data['view']= $this->Hotels_Model->all_hotel_contract();

	   $this->load->view('backend/hotels/hotel_closeout_period',$data);
	}
	public function closeout_hotel() {
		$data['id']=$_REQUEST['id'];
		$this->load->view('backend/hotels/hotel_closeout_period',$data);
		    
	}
	// public function add_closeout_hotel() {
	// 	$id=$_REQUEST['hotelid'];
	// 	$add_closeout= $this->Hotels_Model->add_hotel_closeout_period($_REQUEST);
	// 	redirect('../backend/hotels/hotels_closeout_period?id='.$id.'');
	// }
	public function update_close_hotel() {
		$add_closeout= $this->Hotels_Model->update_hotel_closeout_period($_REQUEST);
		if($_REQUEST['id']=="") {
			$description = 'New closeout details added [Hotel Code: HE0'.$_REQUEST['hotel_id'].', Contract ID: '.$_REQUEST['contract_id'].', From Date: '.$_REQUEST['from_date_edit'].', To Date: '.$_REQUEST['to_date_edit'].']'; 		
		} else {
			$description = 'Closeout details updated [Hotel Code: HE0'.$_REQUEST['hotel_id'].', Contract ID: '.$_REQUEST['contract_id'].', Closeout ID: '.$_REQUEST['id'].']';
    	}		
    	AdminlogActivity($description);
		echo  json_encode($add_closeout);
	}
    public function hotel_closeout_list() {
			if ($this->session->userdata('name')=="") {
				redirect("../backend/");
			}
			$data = array();
			$contractmenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Hotels Contract'); 
			// Datatables Variables
			$draw = intval($this->input->get("draw"));
			$start = intval($this->input->get("start"));
			$length = intval($this->input->get("length"));
			$hotel_closeout = $this->Hotels_Model->hotel_closeout_select($_REQUEST['id'],$_REQUEST['contract_id']);

			foreach($hotel_closeout->result() as $key => $r) {
				if($contractmenu[0]->edit!=0) { 
					$edit = '<a href="#" data-toggle="modal" onclick=close_out_edit('.$r->id.');
						 data-target="#childPolicy_modal" class="sb2-2-1-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
				} else {
					$edit = '';
				}
				if($contractmenu[0]->delete!=0) { 
					$delete = '<a href="#" onclick="closeout_period_delete('."'$r->id'".')"  class="sb2-2-1-delete" data-toggle="modal" data-target="#myModal" ><i class="red accent-4 fa fa-trash-o" aria-hidden="true"></i></a>';
				} else {
					$delete = '';
				}
				$explode_data[$key]= explode(",", $r->roomType);
			foreach ($explode_data[$key] as $key1 => $value1) {
				$room_type_data[$key][$key1] = get_room_name_type($value1);
			}
			$implode_data[$key] = implode(", ", $room_type_data[$key]);
					$data[] = array(
						$key+1,
						date('d/m/Y',strtotime($r->closedDate)),
						$r->reason,
						$implode_data[$key],
						$edit,
					 	$delete,
					);
		  	}
			$output = array(
			   	"draw" => $draw,
				 "recordsTotal" => $hotel_closeout->num_rows(),
				 "recordsFiltered" => $hotel_closeout->num_rows(),
				 "data" => $data
			);
		  echo json_encode($output);
		  exit();
	}
    public function dlt_closeout_period() {
		$result= $this->Hotels_Model->dlt_hotel_closeout_period($_REQUEST['delete_id']);
		if ($result==true) {
			$Return['error'] = "Deleted Successfully";
      		$Return['color'] = 'green';
      		$Return['status'] = '1';
      		$Return['table'] = 'hotel_closeout_table';
      		$description = 'Closeout details deleted [Closeout ID: '.$_REQUEST['delete_id'].']';
    		AdminlogActivity($description);
		} else {
			$Return['error'] = "Deleted Unsuccessfully!";
      		$Return['color'] = 'red';
      		$Return['table'] = 'hotel_closeout_table';
		}
        echo json_encode($Return);
    }
  	public function allotement_update() {
  		$date = explode("li-", $_REQUEST['calDate']);
  		if (!isset($_REQUEST['calEditAlot'])) {
  			$_REQUEST['calEditAlot'] = 0;
  		}
  		if (!isset($_REQUEST['calEditBal'])) {
  			$_REQUEST['calEditBal'] = 0;
  		}
		$this->Hotels_Model->allotement_update($date[1],$_REQUEST['calEditroom_id'],$_REQUEST['calEdithotel_id'],$_REQUEST['calEditAmt'],$_REQUEST['calEditAlot'],$_REQUEST['calEditBal'],$_REQUEST['calEditcontract_id']);
	  	if (isset($_REQUEST['calEditclosedout'])) {
	  		$this->Hotels_Model->closeOutSingleUpdate($date[1],$_REQUEST['calEdithotel_id'],$_REQUEST['calEditcontract_id'],$_REQUEST['calEditroom_id']);
	  	} else {
	  		$this->Hotels_Model->closeOutSingleDelete($date[1],$_REQUEST['calEdithotel_id'],$_REQUEST['calEditcontract_id'],$_REQUEST['calEditroom_id']);
	  	}
	  	echo json_encode(true);
	 	exit();
    }
    public function allot_update() {
  		$date = explode("li-", $_REQUEST['calDate']);
		if (!isset($_REQUEST['calEditAlot'])) {
  			$_REQUEST['calEditAlot'] = 0;
  		}
  		if (!isset($_REQUEST['calEditBal'])) {
  			$_REQUEST['calEditBal'] = 0;
  		}
		$dat=$this->Hotels_Model->allot_update($date[1],$_REQUEST['calEditroom_id'],$_REQUEST['calEdithotel_id'],$_REQUEST['calEditAlot'],$_REQUEST['calEditBal'],$_REQUEST['calEditcontract_id']);
	  	
	  	if (isset($_REQUEST['calEditclosedout'])) {
	    	$this->Hotels_Model->closeOutSingleUpdate($date[1],$_REQUEST['calEdithotel_id'],$_REQUEST['calEditcontract_id'],$_REQUEST['calEditroom_id']);
		} else {
		  	$this->Hotels_Model->closeOutSingleDelete($date[1],$_REQUEST['calEdithotel_id'],$_REQUEST['calEditcontract_id'],$_REQUEST['calEditroom_id']);
	  	}
	  	echo json_encode(true);
	 	exit();
    }
	public function close_out_update() {
		$data = array();
		$data['room_types'] = $this->Hotels_Model->stopSale_get_room_type($_REQUEST['hotel_id']);
		$contractmenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Hotels Contract'); 
		if (isset($_REQUEST['id'])) {
	  		$data['view']= $this->Hotels_Model->hotel_closeout_edit_data($_REQUEST['id']);
	  		 if (count($contractmenu)!=0 && $contractmenu[0]->edit==1) {
		      $this->load->view('backend/hotels/close_out_edit_modal',$data);     
		    } else {
		      redirect(base_url().'backend/dashboard');
		    }    
		} else {
			 if (count($contractmenu)!=0 && $contractmenu[0]->edit==1) {
		      $this->load->view('backend/hotels/close_out_edit_modal',$data);     
		    } else {
		      redirect(base_url().'backend/dashboard');
		    } 
		}  	
	}
    public function agent_permission_update() {
    	if ($this->session->userdata('name')=="") {
            redirect("/logout");
    	}
        if (isset($_REQUEST['agent_to'])) {
    		$implode_data = implode(",", $_REQUEST['agent_to']);
        } else {
        	$implode_data = "";
        }
        
        $agent_permission_update = $this->Hotels_Model->agent_permission_update($_REQUEST['hotel_id'],$implode_data,$_REQUEST['contract_id']);
        redirect('../backend/hotels/contract_menu?hotel_id='.$_REQUEST['hotel_id'].'');
    }
    public function password_update() {
    	$hotel_password = $this->Hotels_Model->password_update($_REQUEST['hotel_id'],$_REQUEST['password']);
    	echo json_encode($hotel_password);
    }
    public function contract_menu()
	{
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		$contractMenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Hotels Contract'); 
		if (count($contractMenu)!=0 && $contractMenu[0]->view==1) {
			$data['view']= $this->Hotels_Model->check_room();
			$this->load->view('backend/hotels/contract',$data);
    	} else {
      		redirect(base_url().'backend/dashboard');
    	}
	}
	public function contract_hotel() {
		if ($this->session->userdata('name')==""){
			redirect("../backend/");
		}
		$data = array();
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		if (!isset($_REQUEST['filter'])) {
			$_REQUEST['filter'] = 1;
		}
		$hotel_contract = $this->Hotels_Model->select_hotel_for_contract($_REQUEST['id'],$_REQUEST['filter']);
		foreach($hotel_contract->result() as $key => $r) {

			if ($r->nonRefundable==1) {
				$nonRefundable = '<span class="text-success">Yes</span>';
			} else {
				$nonRefundable = '<span class="text-danger">No</span>';
			}
			$room_id =	$this->Hotels_Model->hotel_rooms_view($r->hotel_id);

				// $allotement = '<a href="#" onclick="allotment_select('."'$r->hotel_id'".','."'$r->contract_id'".');" data-toggle="modal" data-target="#contract_model"><span class="text-primary bold">Click here</span></a>'; \
			$contractmenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Hotels Contract'); 
			$seasonmenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Contract Season'); 
				if($contractmenu[0]->view!=0) {
					$contract = '<a href="'.base_url().'backend/hotels/contractProcess?hotel_id='.$r->hotel_id.'&con_id='.$r->contract_id.'&room_id='.$room_id[0]->id.'"><span class="text-primary bold">'.$r->contract_id.'</span></a>';
				} else {
					$contract = $r->contract_id;
				}
				if($contractmenu[0]->edit!=0) {
					$edit='<a href="#" onclick="contract_edit('."'$r->hotel_id'".','."'$r->contract_id'".');" data-toggle="modal" data-target="#contract_model" class="sb2-2-1-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
					$countryAccess = '<a title="Country Accissible" href="#" onclick="country_accessible_modal('."'$r->hotel_id'".','."'$r->contract_id'".')"  class="sb2-2-1-delete" data-toggle="modal" data-target="#accessible_modal" ><i class="blue darken-1 fa fa-globe" aria-hidden="true"></i></a>';
					$agentAccess = '<a title="Agent Accissible" href="#" onclick="accessible_modal('."'$r->hotel_id'".','."'$r->contract_id'".')"  class="sb2-2-1-delete" data-toggle="modal" data-target="#accessible_modal" ><i class="teal darken-1 fa fa-user" aria-hidden="true"></i></a>';
					$copy='<a href="#" onclick="contract_copy('."'$r->hotel_id'".','."'$r->contract_id'".');" data-toggle="modal" data-target="#contract_model" class="sb2-2-1-copy"><i class="fa fa-files-o" aria-hidden="true"></i></a>';
				}else{
            		$edit = "";
            		$countryAccess = '';
            		$agentAccess = '';
            		$copy='';
        		}
				if($contractmenu[0]->delete!=0){
					$delete='<a href="#" onclick="contract_delete('."'$r->contract_id'".')"  class="sb2-2-1-delete" data-toggle="modal" data-target="#myModal" ><i class="red accent-4 fa fa-trash-o" aria-hidden="true"></i></a>';	
				}else{
            		$delete="";
        		}
        		if($seasonmenu[0]->view!=0) {
        			$season = '<a href="'.base_url().'backend/hotels/seasons?hotel_id='.$r->hotel_id.'&contract_id='.$r->contract_id.'"><span class="text-primary bold">Click here</span></a>';
        		} else {
        			$season = '';
        		}
        		if($r->contract_type=="Sub") {
        			if($contractmenu[0]->edit!=0) {
	        			$refCopy='<a href="#" onclick="RefreshCopy('."'$r->hotel_id'".','."'$r->contract_id'".');" data-toggle="modal" data-target="#refresh_modal" class="sb2-2-1-copy"><i class="fa fa-venus-mars" aria-hidden="true"></i></a>';
	        		} else {
	        			$refCopy="";
	        		}
				}
				else{
					$refCopy="";
				}
				if ($r->contract_flg==0) {
					if($contractmenu[0]->edit!=0){
						$switch = '<div class="switch">
	                      <label>
	                          <input type="checkbox"   id="contractPermission'.$r->contract_id.'"  onchange="contractPermission('."'$r->contract_id'".');" >
	                          <span class="lever"></span>
	                        </label>
	                  	</div>';
	                } else {
	                	$switch = "Disabled";
	                }
				} else {
					if($contractmenu[0]->edit!=0){
						$switch = '<div class="switch">
	                      <label>
	                          <input type="checkbox"  checked="checked" id="contractPermission'.$r->contract_id.'"  onchange="contractPermission('."'$r->contract_id'".');" >
	                          <span class="lever"></span>
	                        </label>
	                  	</div>';
	                } else {
	                	$switch = "Enabled";
	                }
				}
				if (count($room_id)!=0) {
				$from_date=date('d/m/Y', strtotime($r->from_date ));
				$to_date=date('d/m/Y', strtotime($r->to_date ));
				$allotement = '<a href="'.base_url().'backend/hotels/allotement?id='.$r->hotel_id.'&room_id='.$room_id[0]->id.'&con_id='.$r->contract_id.'" ><span class="text-primary bold">Click here</span></a>';
				$linkedContract = '<a href="'.base_url().'backend/hotels/contractProcess?hotel_id='.$r->hotel_id.'&room_id='.$room_id[0]->id.'&con_id='.$this->Hotels_Model->linkedContractGet($r->linkedContract).'" ><span class="text-primary bold">'.$this->Hotels_Model->linkedContractGet($r->linkedContract).'</span></a>';
				$data[] = array(
					$key+1,
					$contract,
					$r->contract_type,
					$r->contractName,
					$linkedContract,
					$r->board,
					$r->BookingCode,
					$r->max_child_age,
					$nonRefundable,
					$from_date,
					$to_date,
					$season,
					$countryAccess.$agentAccess,
					$switch, 
					$copy.$edit.$delete,
					$refCopy,
					
					// $r->from_date,
					// $r->to_date,
					// $r->contract_hold,
					
				);
			}
      	}
		$output = array(
		   	"draw" => $draw,
			 "recordsTotal" => $hotel_contract->num_rows(),
			 "recordsFiltered" => $hotel_contract->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
	}
	public function add_contract(){
		// $room_count=count($this->Hotels_Model->check_room($_REQUEST['id']));
		// $contract_id = $this->Hotels_Model->get_contract_id();
   	    $view = $this->Hotels_Model->add_contract($_REQUEST);
   	    $description = 'New contract added [Hotel Code: HE0'.$_REQUEST['id'].', Contract ID: CON0'.$view.']';
        AdminlogActivity($description);
   	    redirect("../backend/hotels/contract_menu?hotel_id=".$_REQUEST['id']);
	}
	public function contract_delete($contract_id){
		$this->Hotels_Model->contract_delete();
		redirect("../backend/hotels/contract_menu");
	}
	public function dummy(){
    	$this->db->select_max('contract_id');
        $this->db->from('hotel_tbl_contract');
        $query=$this->db->get();
        $data = $query->result();
        $con_id =  $data[0]->contract_id;
    	$contract_explode=explode('CON',$con_id);
        if($con_id!=""){
        	$cont_id=$contract_explode[1]+1;
        	$contract_id='CON'.$cont_id;
	        return $contract_id;
        }
        else{
	        // $contract_id=$query+1;
        	$contract_id=="CON01";
	        return $contract_id;
    	}
    }
    public function allotementBlkupdate() {
    	$update  = $this->Hotels_Model->allotementBlkupdate($_REQUEST);
    	if(isset($_REQUEST['other_season'])) {
    		$description = 'Allotment bulk update [Hotel Code: HE0'.$_REQUEST['hotel_id'].', Contract ID: '.$_REQUEST['bulk_alt_contract_id'].', From Date: '.$_REQUEST['bulk-alt-fromDate'].', To Date: '.$_REQUEST['bulk-alt-toDate'].']';
    	} else {
    		$description = 'Allotment bulk update [Hotel Code: HE0'.$_REQUEST['hotel_id'].', Contract ID: '.$_REQUEST['bulk_alt_contract_id'].', Season ID: '.implode(',',$_REQUEST['bulk-alt-season']).']';
    	}
        AdminlogActivity($description);
    	$Return['error'] = "Updated Successfully!";
        $Return['color'] = 'green';
        $Return['status'] = '1';
     
        echo json_encode($Return);
    	// redirect('../backend/hotels/contractProcess?month='.$_REQUEST['month'].'&year='.$_REQUEST['year'].'&hotel_id='.$_REQUEST['hotel_id'].'&room_id='.$_REQUEST['room_id'].'&con_id='.$_REQUEST['bulk_alt_contract_id']);
    }
    public function allotBlkupdate() {
    	if(isset($_REQUEST['hotel_id'])) {
	    	$update  = $this->Hotels_Model->allotBlkupdate($_REQUEST);
	    	$description = 'Stop sale bulk update [Hotel Code: HE0'.$_REQUEST['hotel_id'].', Contract ID: '.implode(",",$_REQUEST['bulk-alt-con-id']).', From Date: '.$_REQUEST['bulk-alt-fromDate'].', To Date: '.$_REQUEST['bulk-alt-toDate'].']';
	        AdminlogActivity($description);
	        $Return['error'] = "Updated Successfully!";
	        $Return['color'] = 'green';
	        $Return['status'] = '1';
	     
	        echo json_encode($Return);
	    	// redirect('../backend/hotels/hotels_stopSale?month='.$_REQUEST['month'].'&year='.$_REQUEST['year'].'&hotel_id='.$_REQUEST['hotel_id'].'&room_id='.$_REQUEST['room_id'].'&con_id='.$_REQUEST['bulk_alt_contract_id']);
    	} else {
    		redirect($_SERVER['HTTP_REFERER']);
    	}
    }
    public function contract_Modal() {
    	$contractMenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Hotels Contract'); 
    	$data['view'] = array();
    	$data['nationality'] = $this->Hotels_Model->nationalityList();
    	$data['market'] = $this->Hotels_Model->getMarket();
    	if (isset($_REQUEST['id'])) {
    		$data['view'] = $this->Hotels_Model->contractdetails($_REQUEST['id']);
    		if (count($contractMenu)!=0 && $contractMenu[0]->view==1 && $contractMenu[0]->edit==1) {
				$this->load->view('backend/hotels/contract_Modal',$data);
			} else {
	      		redirect(base_url().'backend/dashboard');
	    	}
    	} else {
    		if (count($contractMenu)!=0 && $contractMenu[0]->view==1 && $contractMenu[0]->create==1) {
				$this->load->view('backend/hotels/contract_Modal',$data);
			} else {
	      		redirect(base_url().'backend/dashboard');
	    	}
    	}
    }
    public function update_contract(){
   	    $view = $this->Hotels_Model->update_contract($_REQUEST);
   	    $description = 'Contract details updated [Hotel Code: HE0'.$_REQUEST['id'].', Contract ID : '.$_REQUEST['contract_id'].']';
        AdminlogActivity($description);
   	    redirect("../backend/hotels/contract_menu?hotel_id=".$_REQUEST['id']);
	}
	public function delete_contract() {
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		$result = $this->Hotels_Model->delete_contract($_REQUEST['delete_id']);
		$this->Hotels_Model->delete_policies($_REQUEST['delete_id']);
		if ($result==true) {
			$Return['error'] = "Deleted Successfully";
      		$Return['color'] = 'green';
      		$Return['status'] = '1';
      		$Return['table'] = 'hotel_contract';
      		$description = 'Contract details deleted [Contract ID : '.$_REQUEST['delete_id'].']';
        	AdminlogActivity($description);
		} else {
			$Return['error'] = "Deleted Unsuccessfully!";
      		$Return['color'] = 'red';
      		$Return['table'] = 'hotel_contract';
		}
        echo json_encode($Return);
	}
	public function policiesSubmit() {
		$this->Hotels_Model->update_hotel_policies($_REQUEST);
		$description = 'Contract policies updated [Hotel Code: HE0'.$_REQUEST['hotel_id'].', Contract ID: '.$_REQUEST['contract_id'].']';
        AdminlogActivity($description);
        echo json_encode(true);
		// redirect("../backend/hotels/contract_menu?hotel_id=".$_REQUEST['hotel_id']);
	}
	public function allotment_select_modal() {
		$data['list'] = $this->Hotels_Model->hotel_rooms_view($_REQUEST['hotel_id']);
		$this->load->view('backend/hotels/allotment_select_modal',$data);
	}
	public function hotels_stopSale() {
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}

		$this->load->model("Agents_Model");
		$this->load->library("Stopsale_calendar");

	    $data['view']= $this->Hotels_Model->all_contract();
	    $data['hotels'] = $this->Hotels_Model->contract_hotel_list();
	    if (isset($_REQUEST['hotel_id'])) {
	    	$hotel_id = $_REQUEST['hotel_id'];
	    } else {
	    	if (count($data['view'])!=0) {
	    		$hotel_id = $data['view'][0]->hotel_id;
	    	} else {
	    		$hotel_id = 0;
	    	}
	    }

	    if ($hotel_id==0) {
  			redirect(base_url().'backend/hotels/hotels_stopSaleAlert');
 			exit();
	    }
		$data['contract'] = $this->Hotels_Model->hotel_contract_list($hotel_id);
		$data['maincontract'] = $this->Hotels_Model->hotel_maincontract_list($hotel_id);
		$rooms = $this->Hotels_Model->hotel_rooms_list($hotel_id);
		$data['rooms'] = $rooms->result();
	    if (isset($_REQUEST['con_id'])) {
	    	$con_id = $_REQUEST['con_id'];
	    } else {
	    	$con_id = $data['contract'][0]->contract_id;
	    }
		$data['permission'] = $this->Hotels_Model->permission_agent_id($hotel_id,$con_id);
		$data['seasons'] = $this->Hotels_Model->seasonList($hotel_id,$con_id)->result();

		if (!isset($_REQUEST['hotel_id'])) {
		// if (count($_REQUEST)==0) {
			redirect(base_url().'backend/hotels/hotels_stopSale?hotel_id='.$hotel_id.'&con_id='.$con_id.'&room_id='.$data['rooms'][0]->id);
		}
		$calendar = new Stopsale_calendar();
		$data['calendar'] = $calendar->show();
		// print_r($data['contract']);
		$StopSale = menuPermissionAvailability($this->session->userdata('id'),'Hotels','S/O Sales & Availability'); 
		if (count($StopSale)!=0 && $StopSale[0]->view==1) {
     			$this->load->view('backend/hotels/hotels_stopSale',$data);
 
    	} else {
      			redirect(base_url().'backend/dashboard');
    	}

		
	}
	public function hotels_stopSale_id(){
		$this->load->model("Hotels_Model");
	    $data['view']= $this->Hotels_Model->all_contract();
	    // print_r($data['view']);
	    // exit();
	    $data['hotels'] = $this->Hotels_Model->contract_hotel_list();
		$data['contract'] = $this->Hotels_Model->hotel_maincontract_list($_REQUEST['hotel_id']);
		$rooms = $this->Hotels_Model->hotel_rooms_list($_REQUEST['hotel_id']);
		$data['rooms'] = $rooms->result();
		redirect(base_url().'backend/hotels/hotels_stopSale?hotel_id='.$_REQUEST['hotel_id'].'&con_id='.$data['contract'][0]->contract_id.'&room_id='.$data['rooms'][0]->id);
	}
	public function accessible_modal() {
		$this->load->model("Agents_Model");
    	$data['list'] = $this->Agents_Model->select('1')->result();
    	$data['permission'] = $this->Hotels_Model->permission_agent_id($_REQUEST['hotel_id'],$_REQUEST['id']);
		$this->load->view('backend/hotels/accessible_modal',$data);
	}
	public function country_accessible_modal() {
    	$data['list'] = $this->Hotels_Model->Country_list();
    	$data['permission'] = $this->Hotels_Model->permission_Country_list($_REQUEST['hotel_id'],$_REQUEST['id']);
		$this->load->view('backend/hotels/country_accessible_modal',$data);
	}
	public function country_permission_update() {
		if ($this->session->userdata('name')=="") {
            redirect("/logout");
    	}
        if (isset($_REQUEST['country_to'])) {
    		$implode_data = implode(",", $_REQUEST['country_to']);
        } else {
        	$implode_data = "";
        }
        $country_permission_update = $this->Hotels_Model->country_permission_update($_REQUEST['hotel_id'],$implode_data,$_REQUEST['contract_id']);
        redirect('../backend/hotels/contract_menu?hotel_id='.$_REQUEST['hotel_id'].'');
	}
	public function hotels_stopSale_list() {
		if ($this->session->userdata('name')==""){
			redirect("../backend/");
		}
		$data = array();
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$hotel_contract = $this->Hotels_Model->select_hotel_for_stopSale($_REQUEST['id']);
		

	  echo json_encode($output);
	  exit();
	}
	public function stopSale_Modal() {
		$data['contract'] = $this->Hotels_Model->select_hotel_for_contract($_REQUEST['hotel_id'])->result();
		$data['room_types'] = $this->Hotels_Model->stopSale_get_room_type($_REQUEST['hotel_id']);
		if (isset($_REQUEST['id'])) {
			$data['view'] = $this->Hotels_Model->stopSale_detail($_REQUEST['id']);
		}
		$this->load->view('backend/hotels/stopSale_Modal',$data);
	}
	public function stopsaleSubmit() {
		$this->Hotels_Model->stopsaleSubmit($_REQUEST);
        redirect('../backend/hotels/hotels_stopSale?hotel_id='.$_REQUEST['hotel_id'].'');
	}
	public function delete_StopSale() {
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		$result = $this->Hotels_Model->delete_StopSale($_REQUEST['delete_id']);
		if ($result==true) {
			$Return['error'] = "Deleted Successfully";
      		$Return['color'] = 'green';
      		$Return['status'] = '1';
      		$Return['table'] = 'stopSale_table';
		} else {
			$Return['error'] = "Deleted Unsuccessfully!";
      		$Return['color'] = 'red';
      		$Return['table'] = 'stopSale_table';
		}
        echo json_encode($Return);
	}
	public function contractProcess() {
		$this->load->model("Agents_Model");
    	$data['list'] = $this->Agents_Model->select('1')->result();
    	$data['permission'] = $this->Hotels_Model->permission_agent_id($_REQUEST['hotel_id'],$_REQUEST['con_id']);
		$data['policy'] = $this->Hotels_Model->get_policy($_REQUEST);

		$redirect_con = "false";
		$rooms = $this->Hotels_Model->hotel_rooms_list($_REQUEST['hotel_id']);
		$data['contract'] = $this->Hotels_Model->hotel_contract_list($_REQUEST['hotel_id']);
		$data['hotels'] = $this->Hotels_Model->contract_hotel_list();
		$data['rooms'] = $rooms->result();

		$data['seasons'] = $this->Hotels_Model->seasonList($_REQUEST['hotel_id'],$_REQUEST['con_id'])->result();
		$data['seasonsMax'] = $this->Hotels_Model->seasonListMax($_REQUEST['hotel_id'],$_REQUEST['con_id']);

		$calendar = new Calendar();

		$data['calendar'] = $calendar->show();
		$data['view'] = $this->Hotels_Model->permissionDetails($_REQUEST['hotel_id'],$_REQUEST['con_id']);
		$data['board'] = $this->Hotels_Model->BoardContractGet($_REQUEST['con_id']);
		$data['allotment'] = $this->Hotels_Model->getallotement($_REQUEST['con_id']);
		$this->load->view('backend/hotels/contractProcess',$data);
	}
	public function childPolicy_list() {
		if ($this->session->userdata('name')==""){
			redirect("../backend/");
		}
		$data = array();
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$hotel_contract = $this->Hotels_Model->select_childPolicy($_REQUEST['id'],$_REQUEST['con_id']);
		foreach($hotel_contract->result() as $key => $r) {
				$explode_data[$key]= explode(",", $r->roomType);
				foreach ($explode_data[$key] as $key1 => $value1) {
					$room_type_data[$key][$key1] = get_room_type($value1);
				}
				$implode_data[$key] = implode(", ", $room_type_data[$key]);
				$data[] = array(
					$key+1,
					$r->ageFrom,
					$r->ageTo,
					$implode_data[$key],
					$r->discount." ".$r->discountType,
					$r->board,
					'<a href="#" onclick="ChildPolicy_edit('."'$r->id'".');" data-toggle="modal" data-target="#childPolicy_modal" class="sb2-2-1-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
					 <a href="#" onclick="ChildPolicy_delete('."'$r->id'".')"  class="sb2-2-1-delete" data-toggle="modal" data-target="#myModal" ><i class="red accent-4 fa fa-trash-o" aria-hidden="true"></i></a>',
					
				);
      	}
		$output = array(
		   	"draw" => $draw,
			 "recordsTotal" => $hotel_contract->num_rows(),
			 "recordsFiltered" => $hotel_contract->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
	}
	public function childPolicy_Modal() {
		$data['room_types'] = $this->Hotels_Model->stopSale_get_room_type($_REQUEST['hotel_id']);
		$data['board'] = array('RO'=>'RO','BB'=>'BB','HB'=>'HB','FB'=>'FB','AL'=>'AL','Breakfast'=>'Breakfast','Lunch'=>'Lunch','Dinner'=>'Dinner');
		if (isset($_REQUEST['id'])) {
			$data['view'] = $this->Hotels_Model->ChildPolicy_details($_REQUEST['id']);
		}
		$this->load->view('backend/hotels/childPolicy_Modal',$data);
	}
	public function childPolicySubmit() {
		$result = $this->Hotels_Model->childPolicySubmit($_REQUEST);
	  	echo json_encode($result);
	}
	public function ChildPolicy_delete() {
		$result = $this->Hotels_Model->ChildPolicy_delete($_REQUEST['delete_id']);
		if ($result==true) {
			$Return['error'] = "Deleted Successfully";
      		$Return['color'] = 'green';
      		$Return['status'] = '1';
      		$Return['table'] = 'childPolicy_table';
		} else {
			$Return['error'] = "Deleted Unsuccessfully!";
      		$Return['color'] = 'red';
      		$Return['table'] = 'childPolicy_table';
		}
        echo json_encode($Return);
	}
	public function seasons() {
		$data['contract'] = $this->Hotels_Model->hotel_contract_list($_REQUEST['hotel_id']);
		$seasonmenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Contract Season'); 
	    if (count($seasonmenu)!=0 && $seasonmenu[0]->view==1) {
	      $this->load->view('backend/hotels/seasons',$data);
	    } else {
	      redirect(base_url().'backend/dashboard');
	    }		
	}
	public function seasonList() {
		if ($this->session->userdata('name')==""){
			redirect("../backend/");
		}
		$data = array();
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$seasons = $this->Hotels_Model->seasonList($_REQUEST['hotel_id'],$_REQUEST['contract_id']);
		foreach($seasons->result() as $key => $r) {
			$seasonmenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Contract Season'); 
	    	if ($seasonmenu[0]->edit==1) {
	    		$edit = '<a href="#" onclick="season_edit('."'$r->id'".');" data-toggle="modal" data-target="#season_modal" class="sb2-2-1-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
	    	} else {
	    		$edit = '';
	    	}
	    	if ($seasonmenu[0]->delete==1) {
	    		$delete = '<a href="#" onclick="season_delete('."'$r->id'".')"  class="sb2-2-1-delete" data-toggle="modal" data-target="#myModal" ><i class="red accent-4 fa fa-trash-o" aria-hidden="true"></i></a>';
	    	} else {
	    		$delete = '';
	    	}
				$data[] = array(
					$key+1,
					date('d/m/Y',strtotime($r->FromDate)),
					date('d/m/Y',strtotime($r->ToDate)),
					$r->SeasonName,
					$r->contract_id,
					$edit.$delete					
				);
      	}
		$output = array(
		   	"draw" => $draw,
			 "recordsTotal" => $seasons->num_rows(),
			 "recordsFiltered" => $seasons->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
	}
	public function season_modal() {
		$seasonmenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Contract Season');
		$data['contract_period'] = $this->Hotels_Model->contract_end_detail($_REQUEST['contract_id']); 
		if (isset($_REQUEST['id'])) {
			$_REQUEST['Season'] = $_REQUEST['id'];
			$data['view'] = $this->Hotels_Model->seasonDetails($_REQUEST);
			if (count($seasonmenu)!=0 && $seasonmenu[0]->view==1 && $seasonmenu[0]->edit==1) {
	          $this->load->view('backend/hotels/season_modal',$data);
	        } else {
	          redirect(base_url().'backend/dashboard');
	        }
		} else {
			$data =array();
			if (count($seasonmenu)!=0 && $seasonmenu[0]->view==1 && $seasonmenu[0]->create==1) {
	          $this->load->view('backend/hotels/season_modal',$data);
	        } else {
	          redirect(base_url().'backend/dashboard');
	        }
		}			
	}
	public function season_delete(){
		$result = $this->Hotels_Model->seasonDelete($_REQUEST);
		if ($result==true) {
			$Return['error'] = "Deleted Successfully";
      		$Return['color'] = 'green';
      		$Return['status'] = '1';
      		$Return['table'] = 'season_table';
      		$description = 'Season details deleted [Season ID: '.$_REQUEST['delete_id'].']';	
    	 	AdminlogActivity($description);
		} else {
			$Return['error'] = "Deleted Unsuccessfully!";
      		$Return['color'] = 'red';
      		$Return['table'] = 'season_table';
		}
        echo json_encode($Return);
	}
	public function SeasonSubmit() {
		$result = $this->Hotels_Model->SeasonSubmit($_REQUEST);
		if(isset($_REQUEST['season_id']) && $_REQUEST['season_id']!="") {
			// $description = 'Season details updated [Hotel Code: HE0'.$_REQUEST['hotel_id'].', Contract ID: '.$_REQUEST['contract_id'].', Season ID: '.$_REQUEST['season_id'].']';
    	} else {
    		$description = 'New Season details added [Hotel Code: HE0'.$_REQUEST['hotel_id'].', Contract ID: '.$_REQUEST['contract_id'].']';
    		AdminlogActivity($description);
    	}	
		echo json_encode($result);
	}
	public function BoardSupplement_modal() {
		$data['room_types'] = $this->Hotels_Model->stopSale_get_room_type($_REQUEST['hotel_id']);

		$board = $this->Hotels_Model->BoardContractGet($_REQUEST['contract_id']);
		$contractmenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Hotels Contract'); 
		if ($board=='FB') {
			$data['board'] = array('Breakfast'=>'Breakfast','Lunch'=>'Lunch','Dinner'=>'Dinner','Full Board' => 'Full Board');
		} else if($board=='HB') {
			$data['board'] = array('Breakfast'=>'Breakfast','Lunch'=>'Lunch','Dinner'=>'Dinner','Half Board'=>'Half Board');
		} else if($board=='AI') {
			$data['board'] = array('Breakfast'=>'Breakfast','Lunch'=>'Lunch','Dinner'=>'Dinner','All Inclusive'=>'All Inclusive');
		} else {
			$data['board'] = array('Breakfast'=>'Breakfast','Lunch'=>'Lunch','Dinner'=>'Dinner');
		}

		// $data['board'] = array('BB'=>'BB','HB'=>'HB','FB'=>'FB','AL'=>'AL');
		$data['seasons'] = $this->Hotels_Model->seasonList($_REQUEST['hotel_id'],$_REQUEST['contract_id'])->result();
		if (isset($_REQUEST['id']) && $_REQUEST['id']!="") {
			$data['view'] = $this->Hotels_Model->BoardSupplementDetails($_REQUEST['id']);
			if (count($contractmenu)!=0 && $contractmenu[0]->edit==1) {
		      $this->load->view('backend/hotels/BoardSupplement_modal',$data);    
		    } else {
		      redirect(base_url().'backend/dashboard');
		    }    
		} else {
			if (count($contractmenu)!=0 && $contractmenu[0]->create==1) {
		      $this->load->view('backend/hotels/BoardSupplement_modal',$data);    
		    } else {
		      redirect(base_url().'backend/dashboard');
		    }  
		}
		
	}
	public function SeasonDateCheck() {
		$data = $this->Hotels_Model->seasonDetails($_REQUEST);
		echo json_encode($data);
	}
	public function  BoardSupplementSubmit() {
		$result = $this->Hotels_Model->BoardSupplementSubmit($_REQUEST);
		if($_REQUEST['id']=="") {
			if(isset($_REQUEST['other_season'])) {
    		$description = 'New board supplement added [Hotel Code: HE0'.$_REQUEST['hotel_id'].', Contract ID: '.$_REQUEST['contract_id'].', From Date: '.$_REQUEST['fromDate'].', To Date: '.$_REQUEST['toDate'].', Season: Other]';
    		} else {
    			$description = 'New board supplement added [Hotel Code: HE0'.$_REQUEST['hotel_id'].', Contract ID: '.$_REQUEST['contract_id'].', Season ID: '.implode(',',$_REQUEST['season']).']';
    		}
		} else {
			$description = 'Board supplement updated [Hotel Code: HE0'.$_REQUEST['hotel_id'].', Contract ID: '.$_REQUEST['contract_id'].', Board Supplement ID: '.$_REQUEST['id'].']';
    	}		
    	AdminlogActivity($description);
		echo json_encode(true);
	}
	public function BoardSupplementList() {
		if ($this->session->userdata('name')==""){
			redirect("../backend/");
		}
		$data = array();
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$seasons = $this->Hotels_Model->BoardSupplementList($_REQUEST['hotel_id'],$_REQUEST['contract_id']);
		$room_type = $this->Hotels_Model->stopSale_get_room_type($_REQUEST['hotel_id']);
		foreach($seasons->result() as $key => $r) {
			$contractmenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Hotels Contract'); 
			$explode_data[$key]= explode(",", $r->roomType);
				foreach ($explode_data[$key] as $key1 => $value1) {
					 $room_type_data[$key][$key1] = get_room_name_type($value1);
				}
				if($r->season==="Other") {
					$season_name = "Other";
				}
				else {
					$season_name = $r->SeasonName;
				}
				if($contractmenu[0]->edit!=0) {
					$edit =  '<a href="#" onclick="BoardSupplement_edit('."'$r->edit_id'".');" data-toggle="modal" data-target="#childPolicy_modal" class="sb2-2-1-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
				} else {
					$edit = "";
				}
				if($contractmenu[0]->delete!=0) {
					$delete =  '<a href="#" onclick="BoardSupplement_delete('."'$r->edit_id'".')"  class="sb2-2-1-delete" data-toggle="modal" data-target="#myModal" ><i class="red accent-4 fa fa-trash-o" aria-hidden="true"></i></a>';
				} else {
					$delete = "";
				}
				$implode_data[$key] = implode(", ", $room_type_data[$key]);
				$data[] = array(
					$key+1,
					$r->board,
					$implode_data[$key],
					$season_name,
					date('d/m/Y',strtotime($r->fromDate)),
					date('d/m/Y',strtotime($r->toDate)),
					$r->startAge,
					$r->finalAge,
					round(contract_currency_type(hotel_currency_type($_REQUEST['hotel_id']),$r->amount)),
					$edit.$delete,
					
				);
      	}
		$output = array(
		   	"draw" => $draw,
			 "recordsTotal" => $seasons->num_rows(),
			 "recordsFiltered" => $seasons->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
	}
	public function BoardSupplement_delete() {
		$result = $this->Hotels_Model->BoardSupplement_delete($_REQUEST['delete_id']);
		if ($result==true) {
			$Return['error'] = "Deleted Successfully";
      		$Return['color'] = 'green';
      		$Return['status'] = '1';
      		$Return['table'] = 'BoardSupplement_table';
      		$description = 'Board supplement deleted [Supplement ID : '.$_REQUEST['delete_id'].']';
      		AdminlogActivity($description);
		} else {
			$Return['error'] = "Deleted Unsuccessfully!";
      		$Return['color'] = 'red';
      		$Return['table'] = 'BoardSupplement_table';
		}
        echo json_encode($Return);
	}
	public function GeneralSupplement_modal() {
		// $data['board'] = array('BB'=>'BB','HB'=>'HB','FB'=>'FB','AL'=>'AL');
		$data['room_types'] = $this->Hotels_Model->stopSale_get_room_type($_REQUEST['hotel_id']);
		$data['seasons'] = $this->Hotels_Model->seasonList($_REQUEST['hotel_id'],$_REQUEST['contract_id'])->result();
		$contractmenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Hotels Contract');
		if (isset($_REQUEST['id']) && $_REQUEST['id']!="") {
			$data['view'] = $this->Hotels_Model->GeneralSupplementDetails($_REQUEST['id']);
			if (count($contractmenu)!=0 && $contractmenu[0]->edit==1) {
		      $this->load->view('backend/hotels/GeneralSupplement_modal',$data);    
		    } else {
		      redirect(base_url().'backend/dashboard');
		    }    
		} else {
			if (count($contractmenu)!=0 && $contractmenu[0]->create==1) {
		      $this->load->view('backend/hotels/GeneralSupplement_modal',$data);    
		    } else {
		      redirect(base_url().'backend/dashboard');
		    }   
		}	
	}
	public function GeneralSupplementList() {
		if ($this->session->userdata('name')==""){
			redirect("../backend/");
		}
		$data = array();
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$seasons = $this->Hotels_Model->GeneralSupplementList($_REQUEST['hotel_id'],$_REQUEST['contract_id']);
		foreach($seasons->result() as $key => $r) {
			$contractmenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Hotels Contract');
			if($contractmenu[0]->edit!=0) { 
				$edit = '<a href="#" onclick="GeneralSupplement_edit('."'$r->edit_id'".');" data-toggle="modal" data-target="#childPolicy_modal" class="sb2-2-1-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
			} else {
				$edit = '';
			} 
			if($contractmenu[0]->delete!=0) { 
				$delete = '<a href="#" onclick="GeneralSupplement_delete('."'$r->edit_id'".')"  class="sb2-2-1-delete" data-toggle="modal" data-target="#myModal" ><i class="red accent-4 fa fa-trash-o" aria-hidden="true"></i></a>';
			} else {
				$delete = '';
			} 
			$explode_data[$key]= explode(",", $r->roomType);
				foreach ($explode_data[$key] as $key1 => $value1) {
					$room_type_data[$key][$key1] = get_room_name_type($value1);
				}
				$implode_data[$key] = implode(", ", $room_type_data[$key]);
				if ($r->mandatory==1) {
					$mandatory = '<span class="bold text-success">Yes</span>';
				} else {
					$mandatory = '<span class="bold text-danger">No</span>';
				}
				if($r->season==="Other") {
					$season_name = "Other";
				}
				else {
					$season_name = $r->SeasonName;
				}
				$data[] = array(
					$key+1,
					// $r->board,
					$r->type,
					$implode_data[$key],
					$season_name,
					date('d/m/Y',strtotime($r->fromDate)),
					date('d/m/Y',strtotime($r->toDate)),
					$r->MinChildAge,
					round(contract_currency_type(hotel_currency_type($_REQUEST['hotel_id']),$r->adultAmount)),
					round(contract_currency_type(hotel_currency_type($_REQUEST['hotel_id']),$r->childAmount)),
					$r->application,
					$mandatory,
					$edit.$delete,					
				);
      	}
		$output = array(
		   	"draw" => $draw,
			 "recordsTotal" => $seasons->num_rows(),
			 "recordsFiltered" => $seasons->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
	}
	public function GeneralSupplementSubmit() {
		$this->Hotels_Model->GeneralSupplementSubmit($_REQUEST);
		if($_REQUEST['id']=="") {
			if(isset($_REQUEST['other_season'])) {
    			$description = 'New general supplement added [Hotel Code: HE0'.$_REQUEST['hotel_id'].', Contract ID: '.$_REQUEST['contract_id'].', From Date: '.$_REQUEST['fromDate'].', To Date: '.$_REQUEST['toDate'].', Season: Other]';
    		} else {
    			$description = 'New general supplement added [Hotel Code: HE0'.$_REQUEST['hotel_id'].', Contract ID: '.$_REQUEST['contract_id'].', Season ID: '.implode(',',$_REQUEST['season']).']';
    		}
		} else {
			$description = 'General supplement updated [Hotel Code: HE0'.$_REQUEST['hotel_id'].', Contract ID: '.$_REQUEST['contract_id'].', General Supplement ID: '.$_REQUEST['id'].']';
    	}		
    	AdminlogActivity($description);
		echo json_encode(true);
	}
	public function GeneralSupplement_delete() {
		$result = $this->Hotels_Model->GeneralSupplement_delete($_REQUEST['delete_id']);
		if ($result==true) {
			$Return['error'] = "Deleted Successfully";
      		$Return['color'] = 'green';
      		$Return['status'] = '1';
      		$Return['table'] = 'GeneralSupplement_table';
      		$description = 'General supplement deleted [General Supplement ID: '.$_REQUEST['delete_id'].']';
    	
    		AdminlogActivity($description);
		} else {
			$Return['error'] = "Deleted Unsuccessfully!";
      		$Return['color'] = 'red';
      		$Return['table'] = 'GeneralSupplement_table';
		}
        echo json_encode($Return);
	}
	public function CancellationFee_modal() {
		$data['room_types'] = $this->Hotels_Model->stopSale_get_room_type($_REQUEST['hotel_id']);
		$data['seasons'] = $this->Hotels_Model->seasonList($_REQUEST['hotel_id'],$_REQUEST['contract_id'])->result();
		$contractmenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Hotels Contract');  
		if (isset($_REQUEST['id'])) {
			$data['view'] = $this->Hotels_Model->CancellationFeeDetails($_REQUEST['id']);
			if (count($contractmenu)!=0 && $contractmenu[0]->edit==1) {
		      $this->load->view('backend/hotels/CancellationFee_modal',$data);  
		    } else {
		      redirect(base_url().'backend/dashboard');
		    }    
		} else {
			if (count($contractmenu)!=0 && $contractmenu[0]->create==1) {
		      $this->load->view('backend/hotels/CancellationFee_modal',$data);  
		    } else {
		      redirect(base_url().'backend/dashboard');
		    } 
		}	
	}
	public function CancelationFeeSubmit() {
		$this->Hotels_Model->CancelationFeeSubmit($_REQUEST);
		if($_REQUEST['id']=="") {
			if(isset($_REQUEST['other_season'])) {
    		$description = 'New cancellation policy added [Hotel Code: HE0'.$_REQUEST['hotel_id'].', Contract ID: '.$_REQUEST['contract_id'].', From Date: '.$_REQUEST['fromDate'].', To Date: '.$_REQUEST['toDate'].', Season: Other]';
    		} else {
    			$description = 'New cancellation policy added [Hotel Code: HE0'.$_REQUEST['hotel_id'].', Contract ID: '.$_REQUEST['contract_id'].', Season ID: '.implode(',',$_REQUEST['Season']).']';
    		}
		} else {
			$description = 'Cancellation policy details updated [Hotel Code: HE0'.$_REQUEST['hotel_id'].', Contract ID: '.$_REQUEST['contract_id'].', Cancellation Policy ID: '.$_REQUEST['id'].']';
    	}		
    	AdminlogActivity($description);
		echo json_encode(true);
	}
	public function CancelationFeeList() {
		if ($this->session->userdata('name')==""){
			redirect("../backend/");
		}
		$data = array();
		$contractmenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Hotels Contract');  
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$seasons = $this->Hotels_Model->CancelationFeeList($_REQUEST['hotel_id'],$_REQUEST['contract_id']);
		foreach($seasons->result() as $key => $r) {		
		if($contractmenu[0]->edit!=0) {
			$edit = '<a href="#" onclick="CancelationFee_edit('."'$r->edit_id'".');" data-toggle="modal" data-target="#childPolicy_modal" class="sb2-2-1-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
		} else {
			$edit = '';
		}
		if($contractmenu[0]->delete!=0) {
			$delete = '<a href="#" onclick="CancelationFee_delete('."'$r->edit_id'".')"  class="sb2-2-1-delete" data-toggle="modal" data-target="#myModal" ><i class="red accent-4 fa fa-trash-o" aria-hidden="true"></i></a>';
		} else {
			$delete = '';
		}
			$explode_data[$key]= explode(",", $r->roomType);
			foreach ($explode_data[$key] as $key1 => $value1) {
				$room_type_data[$key][$key1] = get_room_name_type($value1);
			}
			$implode_data[$key] = implode(", ", $room_type_data[$key]);
			$data[] = array(
				$key+1,
				$r->SeasonName,
				date('d/m/Y',strtotime($r->fromDate)),
				date('d/m/Y',strtotime($r->toDate)),
				// $r->daysInAdvance,
				$r->daysFrom,
				$r->daysTo,
				$r->cancellationPercentage,
				$implode_data[$key],
				$r->application,
				$edit.$delete,
				
			);
      	}
		$output = array(
		   	"draw" => $draw,
			 "recordsTotal" => $seasons->num_rows(),
			 "recordsFiltered" => $seasons->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
	}
	public function CancelationFee_delete() {
		$result = $this->Hotels_Model->CancelationFee_delete($_REQUEST['delete_id']);
		if ($result==true) {
			$Return['error'] = "Deleted Successfully";
      		$Return['color'] = 'green';
      		$Return['status'] = '1';
      		$Return['table'] = 'CancelationFee_table';
      		$description = 'Cancellation policy details deleted [Cancellation Policy ID: '.$_REQUEST['delete_id'].']';	
    		AdminlogActivity($description);
		} else {
			$Return['error'] = "Deleted Unsuccessfully!";
      		$Return['color'] = 'red';
      		$Return['table'] = 'CancelationFee_table';
		}
        echo json_encode($Return);
	}
	public function extrabed_delete() {
		$result = $this->Hotels_Model->extrabed_delete($_REQUEST['delete_id']);
		if ($result==true) {
			$Return['error'] = "Deleted Successfully";
      		$Return['color'] = 'green';
      		$Return['status'] = '1';
      		$Return['table'] = 'extrabed_table';
      		$description = 'Extra bed details deleted [Extra bed ID: '.$_REQUEST['delete_id'].']';    			
    		AdminlogActivity($description);
		} else {
			$Return['error'] = "Deleted Unsuccessfully!";
      		$Return['color'] = 'red';
      		$Return['table'] = 'extrabed_table';
		}
        echo json_encode($Return);
	}
	public function MinimumStay_modal() {
		$data['seasons'] = $this->Hotels_Model->seasonList($_REQUEST['hotel_id'],$_REQUEST['contract_id'])->result();
		$contractmenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Hotels Contract'); 
		if (isset($_REQUEST['id'])) {
			$data['view'] = $this->Hotels_Model->MinimumStayDetails($_REQUEST['id']);
			if (count($contractmenu)!=0 && $contractmenu[0]->edit==1) {
		     $this->load->view('backend/hotels/MinimumStay_modal',$data);     
		    } else {
		      redirect(base_url().'backend/dashboard');
		    }    
		} else {
			if (count($contractmenu)!=0 && $contractmenu[0]->create==1) {
		     $this->load->view('backend/hotels/MinimumStay_modal',$data);     
		    } else {
		      redirect(base_url().'backend/dashboard');
		    }  
		}	
	}
	public function MinimumStayList() {
		if ($this->session->userdata('name')==""){
			redirect("../backend/");
		}
		$data = array();
		$contractmenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Hotels Contract');
		// Datatables Variables
		$draw 	= intval($this->input->get("draw"));
		$start 	= intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$seasons= $this->Hotels_Model->MinimumStayList($_REQUEST['hotel_id'],$_REQUEST['contract_id']);
		foreach($seasons->result() as $key => $r) {
			if($contractmenu[0]->edit!=0) { 
				$edit = '<a href="#" onclick="MinimumStay_edit('."'$r->edit_id'".');" data-toggle="modal" data-target="#childPolicy_modal" class="sb2-2-1-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
			} else {
				$edit = '';
			}
			if($contractmenu[0]->delete!=0) { 
				$delete = '<a href="#" onclick="MinimumStay_delete('."'$r->edit_id'".')"  class="sb2-2-1-delete" data-toggle="modal" data-target="#myModal" ><i class="red accent-4 fa fa-trash-o" aria-hidden="true"></i></a>';
			} else {
				$delete = '';
			}
			$data[] = array(
				$key+1,
				$r->SeasonName,
				date('d/m/Y',strtotime($r->fromDate)),
				date('d/m/Y',strtotime($r->toDate)),
				$r->minDay,
				$edit.$delete,				
			);
      	}
		$output = array(
		   	"draw" => $draw,
			 "recordsTotal" => $seasons->num_rows(),
			 "recordsFiltered" => $seasons->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
	}
	public function MinimumStaySubmit() {
		$this->Hotels_Model->MinimumStaySubmit($_REQUEST);
		if($_REQUEST['id']=="") {
			if(isset($_REQUEST['other_season'])) {
    		$description = 'New minimum stay details added [Hotel Code: HE0'.$_REQUEST['hotel_id'].', Contract ID: '.$_REQUEST['contract_id'].', From Date: '.$_REQUEST['fromDate'].', To Date: '.$_REQUEST['toDate'].', Season: Other]';
    		} else {
    			$description = 'New minimum stay details added [Hotel Code: HE0'.$_REQUEST['hotel_id'].', Contract ID: '.$_REQUEST['contract_id'].', Season ID: '.implode(',',$_REQUEST['Season']).']';
    		}
		} else {
			$description = 'Minimum stay details updated [Hotel Code: HE0'.$_REQUEST['hotel_id'].', Contract ID: '.$_REQUEST['contract_id'].', Minimum Stay ID: '.$_REQUEST['id'].']';
    	}		
    	AdminlogActivity($description);
		echo json_encode(true);
	}
	public function cancellationCheck_modal() {
		$this->load->view('backend/hotels/cancellationCheck_modal');
	}
	public function contractPermission() {
		$this->Hotels_Model->contractPermission($_REQUEST['contract_id'],$_REQUEST['permission']);
		echo json_encode(true);
	}
	public function update_Modal() {
    	// $data['view'] = array();
    	// if (isset($_REQUEST['id'])) {
    	// 	$data['view'] = $this->Hotels_Model->contractdetails($_REQUEST['id']);
    	// }
		$this->load->view('backend/hotels/update_popup');

    }
    public function MinimumStay_delete() {
    	if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		$result = $this->Hotels_Model->MinimumStay_delete($_REQUEST['delete_id']);
		if ($result==true) {
			$Return['error'] = "Deleted Successfully";
      		$Return['color'] = 'green';
      		$Return['status'] = '1';
      		$Return['table'] = 'MinimumStay_table';
      		$description = 'Minimum stay details deleted [Minimum Stay ID: '.$_REQUEST['delete_id'].']';	
    		AdminlogActivity($description);
		} else {
			$Return['error'] = "Deleted Unsuccessfully!";
      		$Return['color'] = 'red';
      		$Return['table'] = 'MinimumStay_table';
		}
        echo json_encode($Return);
    }
   public function menu_checkbox_modal_on(){

   	// print_r($_REQUEST);
   	// exit();
   	 $val=$_REQUEST['val'];
   	 $id=$_REQUEST['hotel_id'];
   	$on =$this->Hotels_Model->menu_checkbox_modal_on($val,$id);
   	echo json_encode(true);
   	

   }
   public function roomAminities() {
   	if ($this->session->userdata('name')==""){
			redirect("../backend/");
	}
		$RoomAminities = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Room Aminities');
		if (count($RoomAminities)!=0 && $RoomAminities[0]->view==1) {
    	$this->load->view('backend/hotels/roomAminities');
    	} else {
      	redirect(base_url().'backend/dashboard');
    	}
	
   }
   public function roomAminitiesList() {
		$data = array();
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$roomAminities = $this->Hotels_Model->roomAminitiesList();
		foreach($roomAminities->result() as $key => $r) {
		$RoomAminities = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Room Aminities');
		// print_r($RoomAminities);
		// exit();
		if($RoomAminities[0]->edit!=0) {
			$edit='<a href="#" onclick="roomAminities_Modal('."'$r->id'".');" data-toggle="modal" data-target="#AminitiesModal" class="sb2-2-1-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
		}else{
            $edit="";
        }
		if($RoomAminities[0]->delete!=0) {
			$delete='<a href="#" onclick="roomAminities_delete('."'$r->id'".')"  class="sb2-2-1-delete" data-toggle="modal" data-target="#myModal" ><i class="red accent-4 fa fa-trash-o" aria-hidden="true"></i></a>';
		}else{
            $delete="";
        }
			$data[] = array(
				$key+1,
				$r->Aminities,
				$edit.$delete,
				
			);
      	}
		$output = array(
		   	"draw" => $draw,
			 "recordsTotal" => $roomAminities->num_rows(),
			 "recordsFiltered" => $roomAminities->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
    }
    public function extrabedsubmit() {
    	$this->Hotels_Model->extrabedsubmit($_REQUEST);
    	if($_REQUEST['id']=="") {
			if(isset($_REQUEST['other_season'])) {
    		$description = 'New extra bed added [Hotel Code: HE0'.$_REQUEST['hotel_id'].', Contract ID: '.$_REQUEST['contract_id'].', From Date: '.$_REQUEST['fromDate'].', To Date: '.$_REQUEST['toDate'].', Season: Other]';
    		} else {
    			$description = 'New extra bed added [Hotel Code: HE0'.$_REQUEST['hotel_id'].', Contract ID: '.$_REQUEST['contract_id'].', Season ID: '.implode(',',$_REQUEST['Season']).']';
    		}
		} else {
			$description = 'Extra bed details updated [Hotel Code: HE0'.$_REQUEST['hotel_id'].', Contract ID: '.$_REQUEST['contract_id'].', Extra bed ID: '.$_REQUEST['id'].']';
    	}		
    	AdminlogActivity($description);
		echo json_encode(true);
    	// print_r($_REQUEST);
    }
    public function roomAminitieSubmit() {
		$this->Hotels_Model->roomAminitieSubmit($_REQUEST);
    	echo  json_encode(true);
    }
    public function roomAminities_Modal() {
    	if ($this->session->userdata('name')==""){
			redirect("../backend/");
		}
		$data['view'] = array();
		if ($_REQUEST['id']!="") {
			$data['view'] =  $this->Hotels_Model->roomAminitiesdeails($_REQUEST['id']);
		}
		$RoomAminities = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Room Aminities'); 
		if ((count($RoomAminities)!=0 && $RoomAminities[0]->view==1 && $RoomAminities[0]->create==1) || count($RoomAminities)!=0 && $RoomAminities[0]->view==1 && $RoomAminities[0]->edit==1) {
			$this->load->view('backend/hotels/roomAminitiesModal',$data);
		} else {
      		redirect(base_url().'backend/dashboard');
    	}
    }
    public function delete_roomAminities() {
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		$result = $this->Hotels_Model->delete_roomAminities($_REQUEST['delete_id']);
		if ($result==true) {
			$Return['error'] = "Deleted Successfully";
      		$Return['color'] = 'green';
      		$Return['status'] = '1';
      		$Return['table'] = 'room_aminities_table';
		} else {
			$Return['error'] = "Deleted Unsuccessfully!";
      		$Return['color'] = 'red';
		}
        echo json_encode($Return);
	}
	public function maincontractCheck() {
		$result = $this->Hotels_Model->maincontractCheck($_REQUEST);
        echo json_encode($result);
	}
	public function SalePermission(){
   	 $val3=$_REQUEST['val3'];
   	 $id=$_REQUEST['hotel_id'];
   	 //$val2=$_REQUEST['val2'];
   	 $conId=$_REQUEST['ConId'];
   	$on =$this->Hotels_Model->SalePermission($val3,$id,$conId);
   	echo json_encode(true);
   	
   }
   public function check_edit() {
   	$val = $_REQUEST['val'];
   	$id = $_REQUEST['hotel_id'];
   	$conId=$_REQUEST['ConId'];
   	$edit = $this->Hotels_Model->editPermission($val,$id,$conId);
   	echo json_encode(true);
   }
   public function cancellationPolicySelect() {
   	$data =$this->Hotels_Model->cancellationPolicySelect($_REQUEST);
   	echo json_encode($data);
   }
   public function CancellationPolicyContentget() {
	$data =$this->Hotels_Model->CancellationPolicyContentget($_REQUEST);
   	echo json_encode($data);
   }
   public function delete_hotelper() {
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		$result = $this->Hotels_Model->deleteHotelPer($_REQUEST['delete_id']);
		if ($result==true) {
			$Return['error'] = "Deleted Successfully";
      		$Return['color'] = 'green';
      		$Return['status'] = '1';
      		
      		$Return['table'] = 'hotel_table';
      		$description = 'Existing hotel details deleted [id:'.$_REQUEST['delete_id'].', Hotel Code: HE0'.$_REQUEST['delete_id'].']';
            AdminlogActivity($description);
		} else {
			$Return['error'] = "Deleted Unsuccessfully!";
      		$Return['color'] = 'red';
      		$Return['table'] = 'hotel_table';
		}
        echo json_encode($Return);
	}
	public function extrabed_modal() {
  		$data['board'] = array('RO'=> 'RO' ,'BB' => 'BB','HB' => 'HB','FB' => 'FB'); 
		$data['room_types'] = $this->Hotels_Model->stopSale_get_room_type($_REQUEST['hotel_id']);
		$data['seasons'] = $this->Hotels_Model->seasonList($_REQUEST['hotel_id'],$_REQUEST['contract_id'])->result();
		$contractmenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Hotels Contract'); 
		if(isset($_REQUEST['id'])) {
			$data['extrabed'] = $this->Hotels_Model->get_extrabed($_REQUEST['id']);
			 if (count($contractmenu)!=0 && $contractmenu[0]->edit==1) {
		      $this->load->view('backend/hotels/extrabed_modal',$data);    
		    } else {
		      redirect(base_url().'backend/dashboard');
		    }    
		} else {
			if (count($contractmenu)!=0 && $contractmenu[0]->create==1) {
		      $this->load->view('backend/hotels/extrabed_modal',$data);    
		    } else {
		      redirect(base_url().'backend/dashboard');
		    }   
		}
		// print_r($data['seasons']);
		// exit();
    	
	}
	public function extrabedList() {
		if ($this->session->userdata('name')==""){
			redirect("../backend/");
		}
		$data = array();
		$season = "";
		$contractmenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Hotels Contract'); 
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$seasons = $this->Hotels_Model->extrabedList($_REQUEST['hotel_id'],$_REQUEST['con_id']);
		foreach($seasons as $key => $r) {
			if($contractmenu[0]->edit!=0) { 
				$edit = '<a href="#" onclick="extrabed_edit('.$r->id.');" data-toggle="modal" data-target="#childPolicy_modal" class="sb2-2-1-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
			} else {
				$edit = '';
			}
			if($contractmenu[0]->delete!=0) { 
				$delete = '<a href="#" onclick="extrabed_delete('.$r->id.')"  class="sb2-2-1-delete" data-toggle="modal" data-target="#myModal" ><i class="red accent-4 fa fa-trash-o" aria-hidden="true"></i></a>';
			} else {
				$delete = '';
			}
			$explode_data[$key]= explode(",", $r->roomType);
			foreach ($explode_data[$key] as $key1 => $value1) {
				$room_type_data[$key][$key1] = get_room_name_type($value1);
			}
			$implode_data[$key] = implode(", ", $room_type_data[$key]);
			if($r->season==="All")
			{
				$season = $r->season;
			}
			elseif ($r->season==="Other") {
				$season = $r->season;
			}
			else {
				$season = $r->SeasonName;
			}

			$data[] = array(
				$key+1,
				$implode_data[$key],
				$season,
				date('d/m/Y',strtotime($r->from_date)),
				date('d/m/Y',strtotime($r->to_date)),
				$r->ChildAgeFrom !=0 ? $r->ChildAgeFrom : 'N.A',
				$r->ChildAgeTo !=0 ? $r->ChildAgeTo : 'N.A',
				ceil($r->ChildAmount) !=0 ? round(contract_currency_type(hotel_currency_type($_REQUEST['hotel_id']),$r->ChildAmount)) : 'N.A',
				ceil($r->amount) !=0 ?  round(contract_currency_type(hotel_currency_type($_REQUEST['hotel_id']),$r->amount)) : 'N.A',
				$edit.$delete,
			);
      	}
		$output = array(
		   	"draw" 			=> $draw,
			"recordsTotal" 	=> array_sum($seasons),
			"recordsFiltered" => array_sum($seasons),
			"data" => $data
		);
	  echo json_encode($output);
	  exit();
	}
	public function hotels_stopSaleAlert() {
		$this->load->view('backend/hotels/hotels_stopSaleAlert');
	}
	public function RefreshModal() {
		$data['view'] = array();
    	if (isset($_REQUEST['id'])) {
    		$data['view'] = $this->Hotels_Model->contractdetails($_REQUEST['id']);
    	}
		$this->load->view('backend/hotels/refreshCopy',$data);

    }
    public function RefreshCopyUpdate(){
    	$conid=$_REQUEST['conid'];
    	
    	if (isset($_POST['board'])) {
                  $boardCheck = 1;
        } else {
                  $boardCheck = 0;
        }
        if (isset($_POST['general'])) {
                  $generalCheck = 1;
        } else {
                  $generalCheck = 0;
        }
        if (isset($_POST['exbed'])) {
                  $exbedCheck = 1;
        } else {
                  $exbedCheck = 0;
        }
        if (isset($_POST['cancel'])) {
                  $cancelCheck = 1;
        } else {
                  $cancelCheck = 0;
        }
        if (isset($_POST['minimum'])) {
                  $minimumCheck = 1;
        } else {
                  $minimumCheck = 0;
        }
        

    	$data =$this->Hotels_Model->RefreshCopyUpdate($boardCheck,$conid,$generalCheck,$exbedCheck,$cancelCheck,$minimumCheck);
   		echo json_encode($data);
    }
    public function Disoffers()
	{
	    if ($this->session->userdata('name')=="") {
	      redirect("../backend/");
	    }
	    $discountMenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Discounts & Offers'); 
		if (count($discountMenu)!=0 && $discountMenu[0]->view==1) {
     			$this->load->view('backend/hotels/offersdiscounts'); 
    	} else {
      			redirect(base_url().'backend/dashboard');
    	}   	    
	}
	public function DiscountoffList(){
 		if ($this->session->userdata('name')=="") {
      		redirect("../backend/");
		}
    $data = array();
    $hotelName=array();
    $ContarctID = array();
    // Datatables Variables
    $draw = intval($this->input->get("draw"));
    $start = intval($this->input->get("start"));
    $length = intval($this->input->get("length"));
    if (isset($_REQUEST['filter'])) {
    	$filter = $_REQUEST['filter'];
    } else {
    	$filter = 1;
    }
    $discount = $this->Hotels_Model->selectDiscount($filter);
    foreach($discount->result() as $key => $r) {
    	$discountMenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Discounts & Offers');
		if($discountMenu[0]->edit!=0){
			$edit='<a href="newoffers?disEdit='.$r->id.'" class="sb2-2-1-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
		}else{
            $edit="";
        }
		if($discountMenu[0]->delete!=0){
			$delete=' <a href="#" onclick="discountdeletefun('.$r->id.');" data-toggle="modal" data-target="#myModal" class="sb2-2-1-edit delete"><i class="fa fa-trash-o red" aria-hidden="true"></i></a>';
		}else{
            $delete="";
        }
       	$hotel = explode(",", $r->hotelid);
       	foreach ($hotel as $exhkey => $exhvalue) {
       		$hotelName[$exhkey] = $this->Hotels_Model->gethotelname($exhvalue);
       	}
       	$impHotelName[$key] =  implode(",", $hotelName);
       	unset($hotelName);
       	
       	$impRoomName[$key] = $this->Hotels_Model->getroomnameNew($r->room);

        $contract=explode(",", $r->contract);
       	foreach ($contract as $Ckey => $Cvalue) {
       		$ContarctID[$Ckey] = $this->Hotels_Model->getcontractName($Cvalue);
       	}
       	$impContarct[$key] =  implode(",", $ContarctID);
       	unset($ContarctID);
       	if ($r->NonRefundable==0) {
       		$NonRefundable = '<span class="text-danger bold">No</span>';
       	} else {
       		$NonRefundable = '<span class="text-success bold">Yes</span>';
       	}
       	if ($r->Discount_flag==0) {
		 	if ($discountMenu[0]->edit==1) {
				$switch = '<div class="switch">
	              <label>
	                  <input type="checkbox"   id="discountStatus'.$r->id.'"  onchange="discountStatus('."'$r->id'".');" >
	                  <span class="lever"></span>
	                </label>
	          	</div>';
	        } else {
	        	$switch = "Disabled";
	        }

		} else {
			if ($discountMenu[0]->edit==1) {
				$switch = '<div class="switch">
	              <label>
	                  <input type="checkbox"  checked="checked" id="discountStatus'.$r->id.'"  onchange="discountStatus('."'$r->id'".');" >
	                  <span class="lever"></span>
	                </label>
	          	</div>';
	        } else {
	        	$switch = "Enabled";
	        }
		}
		if ($r->discount_type=="stay&pay") {
			$discountval = $r->stay_night.' stay / '.$r->pay_night.' pay - (nights)';
		} else {
			$discountval = $r->discount;
		}
		$validFrom  = date('d/m/Y' ,strtotime($r->BkFrom));
		$validUntill  = date('d/m/Y' ,strtotime($r->BkTo));
		$Bkbefore = $r->Bkbefore;
		if ($r->discount_type=='REB') {
			$validFrom = '';
			$validUntill = '';
		} 
		if ($r->discount_type=='EB' || $r->discount_type=='stay&pay') {
			$Bkbefore = '';
		}
		
        $data[] = array(
          $key+1,
          $impHotelName[$key],
          $impContarct[$key],
          $impRoomName[$key],
          $validFrom,
          $validUntill,
          date('d/m/Y' ,strtotime($r->Styfrom)),
          date('d/m/Y' ,strtotime($r->Styto)),
          $Bkbefore,
          $discountval,
          $NonRefundable,
          $switch,
          $edit.' '.$delete,
        );
      
    }
    $output = array(
       "draw" 	         => $draw,
       "recordsTotal" 	 => $discount->num_rows(),
       "recordsFiltered" => $discount->num_rows(),
       "data"            => $data
    );
    echo json_encode($output);
    exit();
	}
 	public function newoffers(){
		if ($this->session->userdata('name')=="") {
	      redirect("../backend/");
	    }
	    $data['view']= $this->Hotels_Model->hotel_select();
	    $data['contract'] = $this->Hotels_Model->hotel_contract_list($data['view'][0]->id);
	    $rooms = $this->Hotels_Model->hotel_rooms_list($data['view'][0]->id);
	    $data['rooms'] = $rooms->result();
	    $discountMenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Discounts & Offers');
	    if (isset($_REQUEST['disEdit']) && $_REQUEST['disEdit'] !="") {
	    	$data['edit'] = $this->Hotels_Model->hoteldiscountEdit($_REQUEST['disEdit']);
	    	if (count($discountMenu)!=0 && $discountMenu[0]->edit==1) {
	    		$this->load->view('backend/hotels/Newoffersdiscounts',$data);
	    	}else{
	    		redirect(base_url().'backend/dashboard');
	    	}
		} else {
			$data['edit'] =array();
			if (count($discountMenu)!=0 && $discountMenu[0]->create==1) {
    			$this->load->view('backend/hotels/Newoffersdiscounts',$data);
	    	}else{
    			redirect(base_url().'backend/dashboard');
    		}
		}	     
	}
	public function add_new_discount(){
	  $id = $this->Hotels_Model->DiscountSubmit($_REQUEST);
	  if(isset($_REQUEST['disEdit'])&& $_REQUEST['disEdit']!="") {
	  	$description = 'Discount and offers updated [Hotel ID: '.$_REQUEST['hoteltext'].', Contract ID: '.$_REQUEST['context'].', Discount ID: '.$_REQUEST['disEdit'].']';
      } else {
    	$description = 'New Discount and offers added [Hotel ID: '.$_REQUEST['hoteltext'].', Contract ID: '.$_REQUEST['context'].', From Date: '.$_REQUEST['from_date'].', To Date: '.$_REQUEST['to_date'].', Discount ID: '.$id.']';
      }
      AdminlogActivity($description);
	  redirect(base_url().'backend/hotels/Disoffers');
	}
	public function HotelSel() {
      $data = $this->Hotels_Model->SelectContract($_REQUEST);
      echo $data;
	}
	public function ConSel() {
      $data = $this->Hotels_Model->SelectRoom($_REQUEST);
      echo $data;
	}
	public function discountDelete() {
       $result = $this->Hotels_Model->discountDelete($_REQUEST['delete_id']);
        if ($result==true) {
			$Return['error'] = "Deleted Successfully";
	  		$Return['color'] = 'green';
	   		$Return['status'] = '1';
	   		$Return['table'] = 'discountTable';
	   		$description = 'Discount and offers details deleted [Discount ID: '.$_REQUEST['delete_id'].']';
     		AdminlogActivity($description);
		} else {
		 	$Return['error'] = "Deleted Unsuccessfully!";
	  		$Return['color'] = 'red';
		}
	    echo json_encode($Return);
	   // redirect(base_url().'backend/hotels/Disoffers');
	}
	public function bulkupdatemodal1(){
		$data['room_types'] = $this->Hotels_Model->stopSale_get_room_type($_REQUEST['hotel_id']);
		// print_r($data['room_types'] );
		// exit();
		$data['seasons'] = $this->Hotels_Model->seasonList($_REQUEST['hotel_id'],$_REQUEST['contract_id'])->result();
		$data['type'] = $this->Hotels_Model->getcontracttype($_REQUEST['contract_id'])->result();
		$this->load->view('backend/hotels/Bulkmodal',$data);
	}
	public function roomnameGet(){
	  $data = $this->Hotels_Model->roomName($_REQUEST['room']);
      echo json_encode($data);
	}
	public function RoomwiseBulkUpdate() {
		
    	$update  = $this->Hotels_Model->RoomwiseBulkUpdate($_REQUEST);
    	if(isset($_REQUEST['other_season'])) {
    		$description = 'Allotment room wise update [Hotel Code: HE0'.$_REQUEST['hotel_id'].', Contract ID: '.$_REQUEST['bulk_alt_contract_id'].', From Date: '.$_REQUEST['bulk-alt-fromDate'].', To Date: '.$_REQUEST['bulk-alt-toDate'].']';
    	} else {
    		$description = 'Allotment room wise update [Hotel Code: HE0'.$_REQUEST['hotel_id'].', Contract ID: '.$_REQUEST['bulk_alt_contract_id'].', Season ID: '.implode(',',$_REQUEST['bulk-alt-season']).']';
    	}
        AdminlogActivity($description);
        $Return['error'] = "Updated Successfully!";
        $Return['color'] = 'green';
        $Return['status'] = '1';
        echo json_encode($Return);
    	//redirect('../backend/hotels/contractProcess?hotel_id='.$_REQUEST['hotel_id'].'&room_id='.$_REQUEST['room_id'].'&con_id='.$_REQUEST['bulk_alt_contract_id']);
    }
    public function dateLoop() {
    	$result = array();
		$result['count'] = 0;
    	$checkin_date = date_create($_REQUEST['start']);
		$checkout_date=date_create($_REQUEST['end']);
		$no_of_days=date_diff($checkin_date,$checkout_date);
		$tot_days = $no_of_days->format("%a");
		// if ($tot_days!=0) {
		    for($i = 0; $i <= $tot_days; $i++) {
		        $result['date'][$i] = date('Y-m-d', strtotime($_REQUEST['start']. ' + '.$i.'  days'));
		        $result['day'][$i] = date('d', strtotime($_REQUEST['start']. ' + '.$i.'  days'));
		        $result['days'][$i] = date('D', strtotime($_REQUEST['start']. ' + '.$i.'  days'));
		        $result['monthYear'][$i] = date('M Y', strtotime($_REQUEST['start']. ' + '.$i.'  days'));
	        }
			$result['count'] = $tot_days;
		// } 
    	echo json_encode($result);
    }
    public function StateSelect() {
			$data = $this->Hotels_Model->SelectState($_REQUEST['Conid']);
			echo json_encode($data);
	}
	public function CitySelect() {
			$data = $this->Hotels_Model->CitySelect($_REQUEST['Conid']);
			echo json_encode($data);
	}
	public function ChangeHotelPassword() {
		$result = $this->Hotels_Model->ChangeHotelPassword($_REQUEST['cPassword'],$_REQUEST['nPassword'],$_REQUEST['email']);
		echo json_encode($result);
	}
	public function ChangeHotelPasswordCancel() {
		$result = $this->Hotels_Model->ChangeHotelPasswordCancel($_REQUEST['email']);
		echo json_encode(true);
	}
	public function Revenue() {
		$revenueMenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Revenue List'); 
		if (count($revenueMenu)!=0 && $revenueMenu[0]->view==1) {
     			$this->load->view('backend/hotels/Revenue'); 
    	} else {
      			redirect(base_url().'backend/dashboard');
    	}  		
	}
	public function RevenueSeason() {
		$this->load->view('backend/hotels/RevenueSeason');
	}
	public function Revenuelist() {
		if ($this->session->userdata('name')==""){
			redirect("../backend/");
		}
		$data = array();
		$season = "";
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$RevenueList = $this->Hotels_Model->RevenueList($_REQUEST['filter']);
		foreach($RevenueList->result() as $key => $r) {
			$revenueMenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Revenue List'); 
			if($revenueMenu[0]->edit!=0){
			$edit='<a href="RevenueEdit?id='.$r->id.'" class="sb2-2-1-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
			}else{
	            $edit="";
	        }
			if($revenueMenu[0]->delete!=0){
				$delete='<a href="#" onclick="Revenuedeletefun('.$r->id.');" data-toggle="modal" data-target="#myModal" class="sb2-2-1-edit delete"><i class="fa fa-trash-o red" aria-hidden="true"></i></a>';
			}else{
	            $delete="";
	        }
			$agentsName = array();
			$hotelName = array();
			$ContarctID = array();
			$hotel = explode(",", $r->hotels);
	       	foreach ($hotel as $exhkey => $exhvalue) {
	       		$hotelName[$exhkey] = $this->Hotels_Model->gethotelname($exhvalue);
	       	}
	       	$impHotelName[$key] =  implode(",", $hotelName);
			$contract=explode(",", $r->contracts);
	       	foreach ($contract as $Ckey => $Cvalue) {
	       		$ContarctID[$Ckey] = $this->Hotels_Model->getcontractName($Cvalue);
	       	}
	       	$impContarct[$key] =  implode(",", $ContarctID);

	       	if ($r->Season=='Other' || $r->Season=='') {
	       		$season = 'Other';
	       	} else {
	       		$seasonQuery = $this->Hotels_Model->RevenueSeasonDetails($r->Season);
	       		$season = $seasonQuery[0]->SeasonName;
	       	}

	       	$agents = explode(",", $r->Agents);
	       	foreach ($agents as $exakey => $exavalue) {
	       		$agentsName[$exakey] = $this->Hotels_Model->getagentname($exavalue);
	       	}
	       	$impAgentName[$key] =  implode(",", $agentsName);
	       	$tbo = "";
	       	if ($r->tbo!="") {
	       		if ($impHotelName[$key]!="") {
	       			$tbo = "TBO Hotels, ";
	       		} else {
	       			$tbo = "TBO Hotels";
	       		}
	       	}
	       	$Markuptype = $r->Markuptype=="Flat Rate" ? "AED" : '%';
	       	$ExtrabedMarkuptype = $r->ExtrabedMarkuptype=="Flat Rate" ? "AED" : '%';
	       	$GeneralSupMarkuptype = $r->GeneralSupMarkuptype=="Flat Rate" ? "AED" : '%';
	       	$BoardSupMarkuptype = $r->BoardSupMarkuptype=="Flat Rate" ? "AED" : '%';
			$data[] = array(
				$key+1,
				$tbo.$impHotelName[$key],
				date('d/m/Y' ,strtotime($r->FromDate)),
				date('d/m/Y' ,strtotime($r->ToDate)),
				$impContarct[$key],
				$impAgentName[$key],
				$r->Markup.' '.$Markuptype,
				$r->ExtrabedMarkup.' '.$ExtrabedMarkuptype,
				$r->GeneralSupMarkup.' '.$GeneralSupMarkuptype,
				$r->BoardSupMarkup.' '.$BoardSupMarkuptype,
				$edit.$delete,
			);
      	}
		$output = array(
		   	"draw" 			=> $draw,
			"recordsTotal" 	=> $RevenueList->num_rows(),
			"recordsFiltered" => $RevenueList->num_rows(),
			"data" => $data
		);
	  echo json_encode($output);
	  exit();
	}
	public function RevenueEdit() {
		$data['edit'] = array();
		$data['view']= $this->Hotels_Model->hotel_select();
	    $data['contract'] = $this->Hotels_Model->hotel_contract_list($data['view'][0]->id);
	    $rooms = $this->Hotels_Model->hotel_rooms_list($data['view'][0]->id);
	    $data['agents'] = $this->Hotels_Model->agentList();
	    $data['Season'] = $this->Hotels_Model->RevenueSeasonlist()->result();
		$revenueMenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Revenue List'); 
		if (isset($_REQUEST['id'])) {
			$data['edit']= $this->Hotels_Model->RevenueEdit($_REQUEST['id']);
			if (count($revenueMenu)!=0 && $revenueMenu[0]->edit==1) {
				$this->load->view('backend/hotels/RevenueEdit',$data);
			} else {
				redirect(base_url().'backend/dashboard');
			}
		} else {
			if (count($revenueMenu)!=0 && $revenueMenu[0]->create==1) {
				$this->load->view('backend/hotels/RevenueEdit',$data);
			} else {
				redirect(base_url().'backend/dashboard');
			}
		}		
	}
	public function RevenueSeasonlist() {
		if ($this->session->userdata('name')==""){
			redirect("../backend/");
		}
		$data = array();
		$season = "";
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$RevenueList = $this->Hotels_Model->RevenueSeasonlist();
		foreach($RevenueList->result() as $key => $r) {
			$data[] = array(
				$key+1,
				$r->SeasonName,
				date('d/m/Y' ,strtotime($r->FromDate)),
				date('d/m/Y' ,strtotime($r->ToDate)),
				'<a href="#" onclick="revenueSeasonEdit_fun('.$r->id.')" data-toggle="modal" data-target="#Revenueseason_modal" class="sb2-2-1-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
	   			<a href="#" onclick="RevenueSeasondeletefun('.$r->id.');" data-toggle="modal" data-target="#myModal" class="sb2-2-1-edit delete"><i class="fa fa-trash-o red" aria-hidden="true"></i></a>',
			);
      	}
		$output = array(
		   	"draw" 			=> $draw,
			"recordsTotal" 	=> $RevenueList->num_rows(),
			"recordsFiltered" => $RevenueList->num_rows(),
			"data" => $data
		);
	  echo json_encode($output);
	  exit();
	}
	public function revenueSeason_modal() {
		$data['view'] = $this->Hotels_Model->RevenueSeasonDetails($_REQUEST['id']);
		$this->load->view('backend/hotels/revenueSeason_modal',$data);
	}
	public function RevenueSeasonSubmit() {
		$result = $this->Hotels_Model->RevenueSeasonSubmit($_REQUEST);
		echo json_encode($result);
	}
	public function RevenueSeasondelete() {
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		$result = $this->Hotels_Model->RevenueSeasondelete($_REQUEST['delete_id']);
		if ($result==true) {
			$Return['error'] = "Deleted Successfully";
      		$Return['color'] = 'green';
      		$Return['status'] = '1';
      		$Return['table'] = 'Revenue_Seasonlist_table';
		} else {
			$Return['error'] = "Deleted Unsuccessfully!";
      		$Return['color'] = 'red';
		}
        echo json_encode($Return);
	}
	public function RevenueSeasonGet() {
		$query = $this->Hotels_Model->RevenueSeasonDetails($_REQUEST['id']);
		$Return['FromDate'] = $query[0]->FromDate;
		$Return['AltFromDate'] = date('d/m/Y',strtotime($query[0]->FromDate));
		$Return['ToDate'] = $query[0]->ToDate;
		$Return['AltToDate'] = date('d/m/Y',strtotime($query[0]->ToDate));
        echo json_encode($Return);
	}
	public function RevenueSubmit() {
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		$this->Hotels_Model->RevenueSubmit($_REQUEST);
		redirect("../backend/hotels/Revenue");
	}
	public function Revenuedelete() {
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		$result = $this->Hotels_Model->Revenuedelete($_REQUEST['delete_id']);
		if ($result==true) {
			$Return['error'] = "Deleted Successfully";
      		$Return['color'] = 'green';
      		$Return['status'] = '1';
      		$Return['table'] = 'Revenue_list_table';
      		$description = 'Hotel Revenue Deleted [ID:'.$_REQUEST['delete_id'].']';
    		AdminlogActivity($description);
		} else {
			$Return['error'] = "Deleted Unsuccessfully!";
      		$Return['color'] = 'red';
		}
        echo json_encode($Return);
	}
	public function discountStatus() {
		$this->Hotels_Model->discountStatus($_REQUEST['id'],$_REQUEST['status']);
		$description = 'Discount status updated [Discount ID: '.$_REQUEST['id'].']'; 
		AdminlogActivity($description);	
		echo json_encode(true);
	}
	public function MultipleDateBulkModal(){
		$data['room_types'] = $this->Hotels_Model->stopSale_get_room_type($_REQUEST['hotel_id']);
		// print_r($data['room_types'] );
		// exit();
		$data['seasons'] = $this->Hotels_Model->seasonList($_REQUEST['hotel_id'],$_REQUEST['contract_id'])->result();
		$data['type'] = $this->Hotels_Model->getcontracttype($_REQUEST['contract_id'])->result();
		$this->load->view('backend/hotels/MultipleDateBulkModal',$data);
	}
	public function MultipleDateBulkUpdate() {

		foreach ($_REQUEST['FromDate'] as $key => $value) {
			$this->Hotels_Model->SeasonUpdate($_REQUEST['SeasonName'][$key],$_REQUEST['hotel_id'],$_REQUEST['FromDate'][$key],$_REQUEST['ToDate'][$key],$_REQUEST['bulk_alt_contract_id']);
			if (!isset($_REQUEST['allotment'][$key])) {
				$_REQUEST['allotment'][$key] = '';
			}
			if (!isset($_REQUEST['Amount'][$key])) {
				$_REQUEST['Amount'][$key] = '';
			}
			if (!isset($_REQUEST['cutoff'][$key])) {
				$_REQUEST['cutoff'][$key] = '';
			}
			foreach ($_REQUEST['roomName'][$key] as $key1 => $value1) {
				$this->Hotels_Model->MultipleDateBulkUpdate($value1,$_REQUEST['hotel_id'],$_REQUEST['FromDate'][$key],$_REQUEST['ToDate'][$key],$_REQUEST['Amount'][$key][$key1],$_REQUEST['allotment'][$key][$key1],$_REQUEST['cutoff'][$key][$key1],$_REQUEST['bulk_alt_contract_id']);

			}
			
		}
    	$description = 'Allotment date wise update [Hotel Code: HE0'.$_REQUEST['hotel_id'].', Contract ID: '.$_REQUEST['bulk_alt_contract_id'].', Seasons: '.implode(',',$_REQUEST['SeasonName']).']';  
    	AdminlogActivity($description);	    	
		redirect("../backend/hotels/contractProcess?hotel_id=".$_REQUEST['hotel_id']."&con_id=".$_REQUEST['bulk_alt_contract_id']."&room_id=".$_REQUEST['room_id']."");
	}
	public function dateRangeSplit() {
		$query = $this->db->query('SELECT FromDate,ToDate,SeasonName ,DATEDIFF(ToDate,FromDate) as ranges FROM table order by DATEDIFF(ToDate,FromDate) asc;')->result();
		
		foreach ($query as $key => $value) {
			echo $value->FromDate;
			echo "    |     ";
			echo $value->ToDate;
			echo "    |     ";
			echo $value->SeasonName;
			echo "<br>";
		}
			echo "<br>";
			echo "<br>";
			echo "<br>";

		foreach ($query as $key1 => $value1) {
			foreach ($query as $key => $value) {
				if ($value1->FromDate > $value->FromDate && $value1->ToDate > $value->ToDate) {
					echo $value->FromDate;
					echo "    |     ";
					echo $value->ToDate;
					echo "    |     ";
					echo $value->SeasonName;
					echo "<br>";
				}
			}
		}
		// print_r($query);
	}
	public function SeasonSelect() {
      $data = $this->Hotels_Model->SelectSeason($_REQUEST);
     echo json_encode($data);
	}
	public function Ranking() {
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		$rankingMenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Hotel Ranking'); 
		if (count($rankingMenu)!=0 && $rankingMenu[0]->view==1) {
     		$this->load->view('backend/hotels/ranking');
    	} else {
      		redirect(base_url().'backend/dashboard');
    	}  		
	}
	public function ranking_list() {
		if ($this->session->userdata('name')==""){
			redirect("../backend/");
		}
		$data = array();
		$season = "";
		$hotelName = array();
		$hotel = array();
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		if (isset($_REQUEST['filter'])) {
			$filter = $_REQUEST['filter'];
		} else {
			$filter = 1;
		}
		$rankingList = $this->Hotels_Model->ranking_list($filter);
		foreach($rankingList->result() as $key => $r) {
			$rankingMenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Hotel Ranking'); 
			if($rankingMenu[0]->edit!=0){
			$edit='<a href="'.base_url().'backend/hotels/newranking/'.$r->id.'" class="sb2-2-1-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
			}else{
	            $edit="";
	        }
			if($rankingMenu[0]->delete!=0){
				$delete='<a href="#" onclick="rankingdeletefun('.$r->id.');" data-toggle="modal" data-target="#myModal" class="sb2-2-1-edit delete"><i class="fa fa-trash-o red" aria-hidden="true"></i></a>';
			}else{
	            $delete="";
	        }

			$hotel = explode(",", $r->Hotels);
	       	foreach ($hotel as $exhkey => $exhvalue) {
	       		$hotelName[$exhkey] = $this->Hotels_Model->gethotelname($exhvalue);
	       	}
	       	$impHotelName[$key] =  implode(",", $hotelName);
	       	unset($hotelName);
			if ($r->delFlag==0) {
				if (count($rankingMenu)!=0 && $rankingMenu[0]->edit==1) {
					$switch = '<div class="switch">
		              <label>
		                  <input type="checkbox"   id="rankingStatus'.$r->id.'"  onchange="rankingStatus('."'$r->id'".');" >
		                  <span class="lever"></span>
		                </label>
		          	</div>';
		        } else {
		        	$switch = 'Disabled';
		        }
			} else { 
				if (count($rankingMenu)!=0 && $rankingMenu[0]->edit==1) {
					$switch = '<div class="switch">
		              <label>
		                  <input type="checkbox"  checked="checked" id="rankingStatus'.$r->id.'"  onchange="rankingStatus('."'$r->id'".');" >
		                  <span class="lever"></span>
		                </label>
		          	</div>';
		        } else {
		        	$switch = 'Enabled';
		        }		        
			}
			$data[] = array(
				$key+1,
				$impHotelName[$key],
				$r->countryName,
				$r->CityName,
				date('d/m/Y' ,strtotime($r->FromDate)),
				date('d/m/Y' ,strtotime($r->ToDate)),
				$switch,
				$edit.' '.$delete,
			);
      	}
		$output = array(
		   	"draw" 			=> $draw,
			"recordsTotal" 	=> $rankingList->num_rows(),
			"recordsFiltered" => $rankingList->num_rows(),
			"data" => $data
		);
	  echo json_encode($output);
	  exit();
	}
	public function newranking($id="") {
		$data['Country']= $this->Tour_Model->SelectCountry();
		$rankingMenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Hotel Ranking'); 
		if ($id!="") {
			$data['edit'] = $this->Hotels_Model->hotelsRankingDetails($id);
			if (count($rankingMenu)!=0 && $rankingMenu[0]->view==1 && $rankingMenu[0]->edit==1) {
				$this->load->view('backend/hotels/editranking',$data);
			} else {
	      		redirect(base_url().'backend/dashboard');
	    	}		
		} else{
			$data['edit'] = array();
			if (count($rankingMenu)!=0 && $rankingMenu[0]->view==1 && $rankingMenu[0]->create==1) {
			$this->load->view('backend/hotels/editranking',$data);
			} else {
	      		redirect(base_url().'backend/dashboard');
	    	}	
		}	
	}
	public function HotelsSelect($cityCode) {
		$this->db->select('*');
		$this->db->from('hotel_tbl_hotels');
		$this->db->where('state',$cityCode);
		$this->db->order_by('hotel_name','asc');
		$query = $this->db->get()->result();
		echo json_encode($query);
	}
	public function rankingUpdate() {
		if ($this->session->userdata('name')==""){
			redirect("../backend/");
		}
		$this->Hotels_Model->rankingUpdate($_REQUEST);
		redirect("../backend/hotels/Ranking");

	}
	public function rankingStatus() {
		$array = array('delFlag' => $_REQUEST['status']);
		$this->db->where('id',$_REQUEST['id']);
		$this->db->update('hotel_tbl_ranking',$array);
		$id = $_REQUEST['id'];
		if ($_REQUEST['status']==0) {
			$description = 'Hotel ranking Disabled [id:'.$id.']';
		} else {
			$description = 'Hotel ranking Enabled [id:'.$id.']';
		}
		AdminlogActivity($description);
		echo json_encode(true);
	}
	public function delete_ranking() {
		$result = $this->Hotels_Model->ranking_delete($_REQUEST['delete_id']);
		if ($result==true) {
			$Return['error'] = "Deleted Successfully";
      		$Return['color'] = 'green';
      		$Return['status'] = '1';
      		$Return['table'] = 'ranking_table';
      		$description = 'Hotel ranking details deleted [ID: '.$_REQUEST['delete_id'].']';  
      		AdminlogActivity($description);
		} else {
			$Return['error'] = "Deleted Unsuccessfully!";
      		$Return['color'] = 'red';
      		$Return['table'] = 'ranking_table';
		}
        echo json_encode($Return);
	}
	public function DiscountExcelModal() {
		$data['view']= $this->Hotels_Model->hotel_select();
		$this->load->view('backend/hotels/DiscountExcelModal',$data);
	}
	public function contractList($hotelid) {
		$query = $this->Hotels_Model->hotel_contract_list($hotelid);
		$option = '';
		foreach ($query as $key => $value) {
			$option .='<option value="'.$value->contract_id.'">'.$value->contract_id.'</option>';
		}
		echo $option;
	}
	public function roomList($hotelid) {
		$query1 = $this->Hotels_Model->select_hotel_room($hotelid)->result();
		$option1 = '';
		foreach ($query1 as $key => $value1) {
			$option1 .='<option value="'.$value1->room_id.'">'.$value1->room_name.''.$value1->Room_Type.'</option>';
		}
		echo $option1;
	}
	public function DiscountExcelUpdate() {
		$file = $_FILES['excelfile']['tmp_name'];
		$this->load->library('excel');
		//read file from path
		$objPHPExcel = PHPExcel_IOFactory::load($file);
		 
		//get only the Cell Collection
		$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
		 
		//extract to a PHP readable array format
		foreach ($cell_collection as $cell) {
		    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
		    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
		    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
		 
		    //The header will/should be in row 1 only. of course, this can be modified to suit your need.
		    if ($row == 1) {
		        $header[$row][$column] = $data_value;
		    } else {
		        $arr_data[$row][$column] = $data_value;
		    }
		}
		 
		//send the data in an array format
		$data['header'] = $header;
		$data['values'] = $arr_data;
		foreach ($arr_data as $key => $value) {
			$validFrom = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($value['A']));
			$validUntill = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($value['B']));
			$StayFrom = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($value['C']));
			$StayTill = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($value['D']));
			$BookBefore = isset($value['E']) ? $value['E'] : "";
			$Discount = $value['F'];
			$NRF = $value['G']=='Yes' ? 1 : 0;

			$contract = implode(",", $_REQUEST['Contract_id']);
			$Rooms = implode(",", $_REQUEST['Rooms']);
			$DiscountCode = $_REQUEST['DiscountCode'];
			$array = array(
					'hotelid' => $_REQUEST['hotel_name'],
					'contract' => implode(",", $_REQUEST['Contract_id']),
					'room' => implode(",", $_REQUEST['Rooms']),
					'discount' => $Discount,
					'BkFrom' => $validFrom,
					'BkTo' => $validUntill,
					'Styfrom' => $StayFrom,
					'Styto' => $StayTill,
					'Bkbefore' => $BookBefore,
					'NonRefundable' => $NRF,
					'discountCode' => $_REQUEST['DiscountCode'],
					'Created_Date' => date('Y-m-d H:i:s'),
					'Created_By' => $this->session->userdata('name'),
			);

			$this->Hotels_Model->BulkDiscountUpdate($array);
		}

		$description = "Excel used bulk update [Discount code : ".$_REQUEST['discountCode'].", entry : ".count($array)."]";
		AdminlogActivity($description);
		redirect("../backend/hotels/Disoffers");
	}
	public function display_manage() {
		$displayMenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Display Management'); 
		if (count($displayMenu)!=0 && $displayMenu[0]->view==1) {
     			$this->load->view('backend/hotels/display_manage'); 
    	} else {
      			redirect(base_url().'backend/dashboard');
    	}  		
	}
	public function Displaylist() {
		if ($this->session->userdata('name')==""){
			redirect("../backend/");
		}
		$data = array();
		$season = "";
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$Displaylist = $this->Hotels_Model->Displaylist();
		foreach($Displaylist->result() as $key => $r) {
			$displayMenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Display Management'); 
			if($displayMenu[0]->edit!=0){
			$edit='<a href="displayEdit?id='.$r->id.'" class="sb2-2-1-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
			}else{
	            $edit="";
	        }
			if($displayMenu[0]->delete!=0){
				$delete='<a href="#" onclick="Displaydeletefun('.$r->id.');" data-toggle="modal" data-target="#myModal" class="sb2-2-1-edit delete"><i class="fa fa-trash-o red" aria-hidden="true"></i></a>';
			}else{
	            $delete="";
	        }			
			$agentsName = array();
	       	$agents = explode(",", $r->Agents);
	       	foreach ($agents as $exakey => $exavalue) {
	       		$agentsName[$exakey] = $this->Hotels_Model->getagentname($exavalue);
	       	}
	       	$impAgentName[$key] =  implode(",", $agentsName);

			$data[] = array(
				$key+1,
				$impAgentName[$key],
				$r->directhotels,
				$r->tbohotels,
				$edit.$delete,
			);
      	}
		$output = array(
		   	"draw" 			=> $draw,
			"recordsTotal" 	=> $Displaylist->num_rows(),
			"recordsFiltered" => $Displaylist->num_rows(),
			"data" => $data
		);
	  echo json_encode($output);
	  exit();
	}
	public function displayEdit() {
		$data['edit'] = array();
	    $data['agents'] = $this->Hotels_Model->agentList();
		$displayMenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Display Management'); 
		if (isset($_REQUEST['id'])) {
			$data['edit']= $this->Hotels_Model->DisplayEdit($_REQUEST['id']);
			if (count($displayMenu)!=0 && $displayMenu[0]->edit==1) {
				$this->load->view('backend/hotels/DisplayEdit',$data);
			} else {
				redirect(base_url().'backend/dashboard');
			}
		} else {
			if (count($displayMenu)!=0 && $displayMenu[0]->create==1) {
				$this->load->view('backend/hotels/DisplayEdit',$data);
			} else {
				redirect(base_url().'backend/dashboard');
			}
		}		
	}
	public function DisplaySubmit() {
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		$this->Hotels_Model->DisplaySubmit($_REQUEST);
		redirect("../backend/hotels/display_manage");
	}
	public function Displaydelete() {
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		$result = $this->Hotels_Model->Displaydelete($_REQUEST['delete_id']);
		if ($result==true) {
			$Return['error'] = "Deleted Successfully";
      		$Return['color'] = 'green';
      		$Return['status'] = '1';
      		$Return['table'] = 'Display_list_table';
      		$description = 'Display list Deleted [ID:'.$_REQUEST['delete_id'].']';
    		AdminlogActivity($description);
		} else {
			$Return['error'] = "Deleted Unsuccessfully!";
      		$Return['color'] = 'red';
		}
        echo json_encode($Return);
	}
	public function providedList() {
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		$listMenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Provided List'); 
		if (count($listMenu)!=0 && $listMenu[0]->view==1) {
     		$this->load->view('backend/hotels/providedList');
    	} else {
      		redirect(base_url().'backend/dashboard');
    	}  		
	}
	public function providedDetailsList() {
		if ($this->session->userdata('name')==""){
			redirect("../backend/");
		}
		$data = array();
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$providedList = $this->Hotels_Model->provided_list();
		foreach($providedList->result() as $key => $r) {
			if ($r->tboStatus==1) {
				$switch = '<div class="switch">
		              <label>
		                  <input type="checkbox"  checked="checked" id="tboStatus'.$r->id.'"  onchange="tboStatus('."'$r->id'".');" >
		                  <span class="lever"></span>
		                </label>
		          	</div>';
		    } else {
		        	$switch = '<div class="switch">
		              <label>
		                  <input type="checkbox"   id="tboStatus'.$r->id.'"  onchange="tboStatus('."'$r->id'".');" >
		                  <span class="lever"></span>
		                </label>
		          	</div>';
		    }
			$data[] = array(
				$key+1,
				$r->First_Name.' '.$r->Last_Name,
				$r->Agency_Name,
				$switch
			);
      	}
		$output = array(
		   	"draw" 			=> $draw,
			"recordsTotal" 	=> $providedList->num_rows(),
			"recordsFiltered" => $providedList->num_rows(),
			"data" => $data
		);
	  echo json_encode($output);
	  exit();
	}
	public function tboStatus() {
		$array = array('tboStatus' => $_REQUEST['status']);
		$this->db->where('id',$_REQUEST['id']);
		$this->db->update('hotel_tbl_agents',$array);
		$id = $_REQUEST['id'];
		if ($_REQUEST['status']==0) {
			$description = 'TBO Status Disabled [Agent id:'.$id.']';
		} else {
			$description = 'TBO Enabled [Agent id:'.$id.']';
		}
		AdminlogActivity($description);
		echo json_encode(true);
	}
	public function CountrySel() {
      $data = $this->Hotels_Model->SelectCon($_REQUEST);
      echo $data;
	}
	public function allotementBlkupdatewizard() {
		//print_r($_REQUEST);exit;
    	$update  = $this->Hotels_Model->allotementBlkupdatewizard($_REQUEST);
    	$description = 'Allotment bulk update [Hotel Code: HE0'.$_REQUEST['hotel_id'].', Contract ID: '.$_REQUEST['bulk_alt_contract_id'].', Season ID: '.$_REQUEST['season'].']';
        AdminlogActivity($description);
        $Return['error'] = "Updated Successfully!";
        $Return['color'] = 'green';
        $Return['status'] = '1';
     
        echo json_encode($Return);
    	//redirect('../backend/hotels/contractProcess?month='.$_REQUEST['month'].'&year='.$_REQUEST['year'].'&hotel_id='.$_REQUEST['hotel_id'].'&room_id='.$_REQUEST['room_id'].'&con_id='.$_REQUEST['bulk_alt_contract_id']);
    }
    public function RoomwiseBulkUpdateWizard() {
    	$update  = $this->Hotels_Model->RoomwiseBulkUpdateWizard($_REQUEST);
    	$description = 'Allotment room wise update [Hotel Code: HE0'.$_REQUEST['hotel_id'].', Contract ID: '.$_REQUEST['bulk_alt_contract_id'].', Season ID: '.implode(',',$_REQUEST['bulk-alt-season']).']';
        AdminlogActivity($description);
    	$Return['error'] = "Updated Successfully!";
        $Return['color'] = 'green';
        $Return['status'] = '1';
        echo json_encode($Return);
    }
    public function trending_hotels() {
		$displayMenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Trending Hotels'); 
		if (count($displayMenu)!=0 && $displayMenu[0]->view==1) {
     		$this->load->view('backend/hotels/trending_hotels'); 
    	} else {
      		redirect(base_url().'backend/dashboard');
    	}  		
	}
	public function trendingAdd() {
		$data['edit'] = array();
	    $data['view']= $this->Hotels_Model->hotel_select();
		$displayMenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Trending Hotels'); 
		if (isset($_REQUEST['id'])) {
			$data['edit']= $this->Hotels_Model->TrendingEdit($_REQUEST['id']);
			if (count($displayMenu)!=0 && $displayMenu[0]->edit==1) {
				$Trendinglist = $this->Hotels_Model->Trendinglist();
				$data['edit'] = $Trendinglist->result();
				$this->load->view('backend/hotels/trendingAdd',$data);
			} else {
				redirect(base_url().'backend/dashboard');
			}
		} else {
			if (count($displayMenu)!=0 && $displayMenu[0]->create==1) {
				$Trendinglist = $this->Hotels_Model->Trendinglist();
				$this->load->view('backend/hotels/trendingAdd',$data);
			} else {
				redirect(base_url().'backend/dashboard');
			}
		}		
	}
	public function add_trending_hotels(){
	  $id = $this->Hotels_Model->TrendingSubmit($_REQUEST);
	  if(isset($_REQUEST['trendEdit'])&& $_REQUEST['trendEdit']!="") {
	  	$description = 'Trending Hotels updated [Set1 Hotel ID: '.$_REQUEST['hotel1text'].', Set 2 Hotel ID: '.$_REQUEST['hotel2text'].', Set 3 Hotel ID: '.$_REQUEST['hotel3text'].', Set 4 Hotel ID: '.$_REQUEST['hotel4text'].', Set 5 Hotel ID: '.$_REQUEST['hotel5text'].', Set 6 Hotel ID: '.$_REQUEST['hotel6text'].', ID: '.$_REQUEST['trendEdit'].']';
      } else {
    	$description = 'New Trending Hotels added [Set1 Hotel ID: '.$_REQUEST['hotel1text'].', Set 2 Hotel ID: '.$_REQUEST['hotel2text'].', Set 3 Hotel ID: '.$_REQUEST['hotel3text'].', Set 4 Hotel ID: '.$_REQUEST['hotel4text'].', Set 45Hotel ID: '.$_REQUEST['hotel5text'].', Set 6 Hotel ID: '.$_REQUEST['hotel6text'].']';
      }
      AdminlogActivity($description);
	  redirect(base_url().'backend/hotels/trending_hotels');
	}
	public function Trendinglist() {
		if ($this->session->userdata('name')==""){
			redirect("../backend/");
		}
		$data = array();
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$Trendinglist = $this->Hotels_Model->Trendinglist();
		foreach($Trendinglist->result() as $key => $r) {
			$displayMenu = menuPermissionAvailability($this->session->userdata('id'),'Hotels','Display Management'); 
			if($displayMenu[0]->edit!=0){
			$edit='<a href="trendingAdd?id='.$r->id.'" class="sb2-2-1-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
			}else{
	  	          $edit="";
	        }	
	  		if($displayMenu[0]->delete!=0){
				$delete='<a href="#" onclick="Trendinghoteldeletefun('.$r->id.');" data-toggle="modal" data-target="#myModal" class="sb2-2-1-edit delete"><i class="fa fa-trash-o red" aria-hidden="true"></i></a>';
			}else{
	            $delete="";
	        }		
			$hotelsname = array();
	       	$hotels = explode(",", $r->hotelid);
	       	foreach ($hotels as $exakey => $exavalue) {
	       		$hotelsname[$exakey] = $this->Hotels_Model->gethotelname($exavalue);
	       	}
	       	$impHotelName[$key] =  implode(",", $hotelsname);

			$data[] = array(
				$key+1,
				$impHotelName[$key],
				$r->set,
				$edit,
			);
      	}
		$output = array(
		   	"draw" 			=> $draw,
			"recordsTotal" 	=> $Trendinglist->num_rows(),
			"recordsFiltered" => $Trendinglist->num_rows(),
			"data" => $data
		);
	  echo json_encode($output);
	  exit();
	}
	public function Trendingdelete() {
		if ($this->session->userdata('name')=="") {
			redirect("../backend/");
		}
		$result = $this->Hotels_Model->Trendingdelete($_REQUEST['delete_id']);
		if ($result==true) {
			$Return['error'] = "Deleted Successfully";
      		$Return['color'] = 'green';
      		$Return['status'] = '1';
      		$Return['table'] = 'Trending_hotel_list_table';
      		$description = 'Trending hotel list Deleted [ID:'.$_REQUEST['delete_id'].']';
    		AdminlogActivity($description);
		} else {
			$Return['error'] = "Deleted Unsuccessfully!";
      		$Return['color'] = 'red';
		}
        echo json_encode($Return);
	}
}





