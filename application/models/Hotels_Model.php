<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Hotels_Model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	public function insert($room_Type)
	{
		$data= array(
		          'Room_Type' 	 => $room_Type,
		      	  'Created_Date' => date('Y-m-d H:i:s'),
		      	  'Created_By' 	 =>  $this->session->userdata('id'),);
		$this->db->insert('hotel_tbl_room_type',$data);
		$id = $this->db->insert_id();
		return $id;
	}
	public function select()
	{    
		$this->db->select('*');
		$this->db->from('hotel_tbl_room_type');
		$this->db->where('delflg',1);
		$this->db->order_by('id','desc');
	    $query=$this->db->get();
		return $query;
	}
	public function select_hotel_room($hotel_log_id)
	{    
		$this->db->select('hotel_tbl_hotel_room_type.id as room_id,hotel_tbl_hotel_room_type.*,hotel_tbl_room_type.*,hotel_tbl_hotels.*');
        $this->db->from('hotel_tbl_hotel_room_type');
		$this->db->join('hotel_tbl_room_type', 'hotel_tbl_room_type.id = hotel_tbl_hotel_room_type.room_type', 'left');
		$this->db->join('hotel_tbl_hotels', 'hotel_tbl_hotels.id = hotel_tbl_hotel_room_type.hotel_id', 'left');
        $this->db->where('hotel_tbl_hotel_room_type.delflg',1);
        $this->db->where('hotel_tbl_hotel_room_type.hotel_id',$hotel_log_id);
        return $query=$this->db->get();
	}
	public function select_hotel_room_type()
	{    
		$this->db->select('*');
		$this->db->from('hotel_tbl_room_type');
		$this->db->where('delflg',1);
		$this->db->order_by('id','desc');
	    $query=$this->db->get();
		return $query;
	}
	public function delete_room_type($id)
	{
		$room_Type = $this->db->query('SELECT Room_Type FROM hotel_tbl_room_type WHERE id = '.$id.'')->result();

		$this->db->where('id',$id);
		$this->db->delete('hotel_tbl_room_type');
		
		$room_Type = $room_Type[0]->Room_Type;
		return true;
	}
	public function delete_hotel($id)
	{   
		$data= array(
		          'delflag' => 0,);
		$this->db->where('id',$id);
		$this->db->update('hotel_tbl_hotels',$data);

		$hotel = $this->db->query('SELECT hotel_name FROM hotel_tbl_hotels WHERE id = '.$id.'')->result();
		$hotel = $hotel[0]->hotel_name;
		return true;
	}
	public function room_type_single_data($id) {
		$this->db->where('id',$id);
		$this->db->from('hotel_tbl_room_type');
		$this->db->limit('1');
	    $query=$this->db->get();
		return $query->result();
	}
	public function update($room_Type,$id)
	{
		$data= array(
		          'Room_Type' 		=> $room_Type,
		      	  'Updated_Date' 	=> date('Y-m-d H:i:s'),
		      	  'Updated_By' 		=>  $this->session->userdata('id'),);
		$this->db->where('id',$id);
		$this->db->update('hotel_tbl_room_type',$data);
		return true;
	}
	public function hotel_facility_select()
	{    
		$this->db->select('hotel_tbl_hotel_facility.* , hotel_tbl_icons.icon_src');
		$this->db->from('hotel_tbl_hotel_facility');
		$this->db->join('hotel_tbl_icons','hotel_tbl_hotel_facility.Icon = hotel_tbl_icons.id');
		$this->db->where('hotel_tbl_hotel_facility.delflg',1);
		$this->db->order_by('hotel_tbl_hotel_facility.id','desc');
	    $query=$this->db->get();
		return $query;
	}
	public function hotel_facility_update($hotel_facility,$id,$icon)
	{
		$data= array(
		          'Hotel_Facility' 	=> $hotel_facility,
		          'Icon' 			=> $icon,
		      	  'Updated_Date' 	=> date('Y-m-d H:i:s'),
		      	  'Updated_By' 		=>  $this->session->userdata('id'),);
		$this->db->where('id',$id);
		$this->db->update('hotel_tbl_hotel_facility',$data);

		return true;
	}
	public function hotel_facility_insert($hotel_facility,$icon)
	{
		$data= array(
		          'Hotel_Facility' => $hotel_facility,
		          'Icon' 		   => $icon,
		      	  'Created_Date'   => date('Y-m-d H:i:s'),
		      	  'Created_By'     =>  $this->session->userdata('id'),);
		$this->db->insert('hotel_tbl_hotel_facility',$data);
		$id = $this->db->insert_id();
		return $id;
	}
	public function hotel_facility_single_data($id) {
		$this->db->where('id',$id);
		$this->db->from('hotel_tbl_hotel_facility');
		$this->db->limit('1');
	    $query=$this->db->get();
		return $query->result();
	}
	public function delete_hotel_facility($id)
	{
		$data= array(
		          'delflg' => "0",
		          'Updated_Date'   => date('Y-m-d H:i:s'),
		      	  'Updated_By'     =>  $this->session->userdata('id')
		      );
		$this->db->where('id',$id);
		$this->db->update('hotel_tbl_hotel_facility',$data);


		$hotel_facility = $this->db->query('SELECT Hotel_Facility FROM hotel_tbl_hotel_facility WHERE id = '.$id.'')->result();
		$hotel_facility = $hotel_facility[0]->Hotel_Facility;


		return true;
	}
	public function room_facility_insert($room_facility,$icon) {

		$data= array(
		          'Room_Facility' => $room_facility,
		          'Icon'   		  => $icon,
		      	  'Created_Date'  => date('Y-m-d H:i:s'),
		      	  'Created_By'    =>  $this->session->userdata('id'),);
		$this->db->insert('hotel_tbl_room_facility',$data);
		$id = $this->db->insert_id();
		return $id;
	}
	public function room_facility_select()
	{    
		$this->db->select('hotel_tbl_room_facility.* , hotel_tbl_icons.icon_src');
		$this->db->from('hotel_tbl_room_facility');
		$this->db->join('hotel_tbl_icons','hotel_tbl_room_facility.Icon = hotel_tbl_icons.id');
		$this->db->where('hotel_tbl_room_facility.delflg',1);
		$this->db->order_by('hotel_tbl_room_facility.id','desc');
	    $query=$this->db->get();
		return $query;
	}
	public function delete_room_facility($id)
	{
		$data= array(
		          'delflg' => "0",
		      	  'Updated_Date'  => date('Y-m-d H:i:s'),
		      	  'Updated_By'    =>  $this->session->userdata('id'));
		$this->db->where('id',$id);
		$this->db->update('hotel_tbl_room_facility',$data);

		$room_facility = $this->db->query('SELECT Room_Facility FROM hotel_tbl_room_facility WHERE id = '.$id.'')->result();
		$room_facility = $room_facility[0]->Room_Facility;


		return true;
	}
	public function deletehotel($id)
	{
		$data= array(
		          'delflg' =>"0");
		$this->db->where('id',$id);
		$this->db->update('hotel_tbl_hotels',$data);

		$hotel = $this->db->query('SELECT hotel_name FROM hotel_tbl_hotels WHERE id = '.$id.'')->result();
		$hotel = $hotel[0]->hotel_name;

		return true;
	}
	public function room_facility_single_data($id) {
		$this->db->where('id',$id);
		$this->db->from('hotel_tbl_room_facility');
		$this->db->limit('1');
	    $query=$this->db->get();
		return $query->result();
	}
	public function room_facility_update($room_facility,$id,$icon)
	{
		$data= array(
		          'Room_Facility' => $room_facility,
		          'Icon'   		  => $icon,
		      	  'Updated_Date'  => date('Y-m-d H:i:s'),
		      	  'Updated_By'    =>  $this->session->userdata('id'),);
		$this->db->where('id',$id);
		$this->db->update('hotel_tbl_room_facility',$data);

		return true;
	}
	public function hotel_facility_icons() {
		$this->db->from('hotel_tbl_icons');
	    $query=$this->db->get();
		return $query->result();
	}
	public function hotel_facilties_get() {
		$this->db->select('hotel_tbl_hotel_facility.* , hotel_tbl_icons.icon_src');
		$this->db->from('hotel_tbl_hotel_facility');
		$this->db->join('hotel_tbl_icons','hotel_tbl_hotel_facility.Icon = hotel_tbl_icons.id');
		$this->db->where('hotel_tbl_hotel_facility.delflg',1);
		$this->db->order_by('hotel_tbl_hotel_facility.id','desc');
	    $query=$this->db->get();
		return $query->result();
	}
	public function room_type_get() {
		$this->db->select('*');
		$this->db->from('hotel_tbl_room_type');
		$this->db->where('delflg',1);
		$this->db->order_by('id','desc');
	    $query=$this->db->get();
		return $query->result();
	}
	public function room_facilties_get() {
		$this->db->select('hotel_tbl_room_facility.* , hotel_tbl_icons.icon_src');
		$this->db->from('hotel_tbl_room_facility');
		$this->db->join('hotel_tbl_icons','hotel_tbl_room_facility.Icon = hotel_tbl_icons.id');
		$this->db->where('hotel_tbl_room_facility.delflg',1);
		$this->db->order_by('hotel_tbl_room_facility.id','desc');
	    $query=$this->db->get();
		return $query->result();
	}
	public function room_aminities_get(){
		$this->db->select('*');
		$this->db->from('hotel_tbl_roomaminities');
		$query=$this->db->get();
		return $query->result();
	}
	public function room_facilties_get_hotel_login() {
		$this->db->select('hotel_tbl_room_facility.* , hotel_tbl_icons.icon_src');
		$this->db->from('hotel_tbl_room_facility');
		$this->db->join('hotel_tbl_icons','hotel_tbl_room_facility.Icon = hotel_tbl_icons.id');
		$this->db->where('hotel_tbl_room_facility.delflg',1);
		$this->db->order_by('hotel_tbl_room_facility.id','desc');
	    $query=$this->db->get();
		return $query->result();
	}
	public function add_new_hotel($data,$password,$hotel_id) {
		if (!isset($data['parking'])) {
			$data['parking']=0;
		}
		if (!isset($data['wifi'])) {
			$data['wifi']=0;
		}
		if (!isset($data['internet'])) {
			$data['internet']=0;
		}
		if (!isset($data['accepting'])) {
			$data['accepting'] = 1;
		}
		if (!isset($data['rating'])) {
			$data['rating'] = 2;
		}
		$data = array('location' => $data['location'],
					  'lattitude' => $data['latitude'], 
					  'longitude' => $data['longitude'], 
					  'hotel_name' => $data['hotel_name'], 
					  // 'market' => $data['market'], 
					  'property_name' => $data['property_name'], 
					  'brand_name' => $data['brand_name'], 
					  // 'board' => $data['board'], 
					  'country' => $data['ConSelect'],
					  'state'=> $data['stateSelect'], 
					  'city' => $data['city'], 
					  'city_near_by' => $data['citynearby'], 
					  'city_description' => $data['citydes'], 
					  'hotel_facilities' => implode(",",$data['hotel_facilties']),
					  'room_facilities' => implode(",",$data['room_facilties1']), 
					  'keywords'=>$data['keywords'], 
					  'wifi' => $data['wifi'], 
					  'internet' => $data['internet'], 
					  'parking' => $data['parking'], 
					  'rating' => $data['rating'], 
					  'hotel_description' => $data['hotel_description'], 
					  'Number_of_room' => $data['total_no_of_rooms'], 
					  'website' => $data['Website'], 
					  'accepting_vcc' => $data['accepting'], 
					  'channel' => $data['channel_manager'], 
					  'chain' => $data['part_of_chain'], 
					  'sell_currency' => $data['sell_currency'], 
					  'facebook' => $data['facebook'], 
					  'google_plus' => $data['googleplus'], 
					  'twitter' => $data['twitter'], 
					  'linked_in' => $data['Linkedin'], 
					  'whatsapp' => $data['WhatsApp'], 
					  'vk_url' => $data['vkcom'], 
					  'sale_name' => $data['sales_fname'], 
					  'sale_lname' => $data['sales_lname'], 
					  'sale_number' => $data['sales_phone'], 
					  'sale_mobile' => $data['sales_mobile'], 
					  'sale_mail' => $data['sales_mail'], 
					  'sale_address' => $data['sales_address'], 
					  'sale_password' => $data['sales_password'],
					  'password_sale' => md5($data['sales_password']),
					  'revenu_name' => $data['revenue_fname'], 
					  'revenu_lname' => $data['revenue_lname'], 
					  'revenu_mail' => $data['revenue_mail'], 
					  'revenu_number' => $data['revenue_phone'], 
					  'revenu_mobile' => $data['revenue_mobile'], 
					  'revenu_address' => $data['revenue_address'],
					  'revenue_password'=>$data['revenue_password'],
					  'password_revenue'=>md5($data['revenue_password']),
					  'contract_name' => $data['contract_fname'], 
					  'contract_lname' => $data['contract_lname'], 
					  'contract_mail' => $data['contract_mail'], 
					  'contract_number' => $data['contract_phone'], 
					  'contract_mobile' => $data['contract_mobile'], 
					  'contracts_address' => $data['contracts_address'],
					  'contract_password' => $data['contract_password'],
					  'password_contract' => md5($data['contract_password']),
					  'finance_name' => $data['finance_fname'], 
					  'finance_lname' => $data['finance_lname'], 
					  'finance_number' => $data['finance_phone'], 
					  'finance_mobile' => $data['finance_mobile'], 
					  'finance_mail' => $data['finance_mail'], 
					  'finance_address' => $data['finance_address'], 
					  'finance_password' => $data['finance_password'],
					  'password_finance' => md5($data['finance_password']),
					  'password' => md5($password),
					  'hotel_code' => $hotel_id, 
					  'country_code' => $data['country'],
					  'promoteList' => $data['promoteList'],
					  'Preferred_currency' 	=> $data['Preferred_currency'],
					  'created_date' => date('Y-m-d'), 
					  'created_by' => $this->session->userdata('id'), 
				);
		$this->db->insert('hotel_tbl_hotels',$data);
        $hotel_id = $this->db->insert_id();
		return $hotel_id; 
	}
	public function add_new_room_types($room_type_val,$room_type_price,$room_type_facilities,$room_type_occupancy,$room_type_childoccupancy,$no_of_rooms,$id,$room_name_val) {
		$data = array('hotel_id' => $id,
					  'room_name' => $room_name_val,
					  'room_type' => $room_type_val, 
					  'allotement' => $request['allotement'], 
					  'price' => $room_type_price, 
					  'room_facilities' => $room_type_facilities, 
					  'occupancy' => $room_type_occupancy, 
					  'occupancy_child' => $room_type_childoccupancy, 
					  'total_rooms' => $no_of_rooms, 
					  'created_date' => date('Y-m-d'), 
					  'created_by' => $this->session->userdata('id'), 
				);
		$this->db->insert('hotel_tbl_hotel_room_type',$data);
        $hotel_room_id = $this->db->insert_id();
		return $hotel_room_id;
	}
	public function hotel_list_select($filter) {
		$this->db->select('*,IF(supplier=1,(select CONCAT(Agent_Code," - ",First_Name," ",Last_Name) from hotel_tbl_agents where id = supplierid),"Otelseasy") as supplierName');
		$this->db->from('hotel_tbl_hotels');
		$this->db->where('delflg',$filter);
		$this->db->order_by('id','desc');
	    $query=$this->db->get();
		return $query;
	}
    public function hotel_detail_get($id) {
        $this->db->select('hotel_tbl_hotels.id as hotels_edit_id,hotel_tbl_hotels.*,hotel_tbl_policies.*,hotel_tbl_hotels.delflg as hotels_delflg,hotel_tbl_contract.*');
        $this->db->from('hotel_tbl_hotels');
        $this->db->join('hotel_tbl_policies', 'hotel_tbl_policies.hotel_id = hotel_tbl_hotels.id', 'left');
        $this->db->join('hotel_tbl_contract', 'hotel_tbl_contract.hotel_id = hotel_tbl_hotels.id', 'left');
        $this->db->where('hotel_tbl_hotels.id',$id);
        $query=$this->db->get();
        return $query->result();
    }
    public function hotel_detail_get_room_type($id) {
        $this->db->select('hotel_tbl_hotel_room_type.*,hotel_tbl_room_type.*');
        $this->db->from('hotel_tbl_hotel_room_type');
		$this->db->join('hotel_tbl_room_type', 'hotel_tbl_room_type.id = hotel_tbl_hotel_room_type.room_type', 'left');
        $this->db->where('hotel_tbl_hotel_room_type.delflg',1);
        $this->db->where('hotel_tbl_hotel_room_type.hotel_id',$id);
        $query=$this->db->get();
        return $query->result();
    }
    public function hotel_facilities($id) {
        $this->db->select('hotel_tbl_hotel_facility.* , hotel_tbl_icons.icon_src');
      $this->db->from('hotel_tbl_hotel_facility');
      $this->db->join('hotel_tbl_icons','hotel_tbl_icons.id = hotel_tbl_hotel_facility.Icon', 'left');
      $this->db->where('hotel_tbl_hotel_facility.id',$id);
      $query=$this->db->get();
      return $query->result();
   }
   public function hotel_rooms_view($id) {
        $this->db->select('hotel_tbl_hotel_room_type.*,hotel_tbl_room_type.room_type as room_type_name');
        $this->db->from('hotel_tbl_hotel_room_type');
        $this->db->join('hotel_tbl_room_type','hotel_tbl_room_type.id = hotel_tbl_hotel_room_type.room_type', 'left');
        $this->db->where('hotel_tbl_hotel_room_type.hotel_id',$id);
        $this->db->where('hotel_tbl_hotel_room_type.delflg',1);
        $this->db->order_by('hotel_tbl_hotel_room_type.id','desc');
        $query=$this->db->get();
        return $query->result();
    }
    public function detail_viewing($id) {
        $this->db->select('*');
        $this->db->from('hotel_tbl_hotels');
        $this->db->where('delflg',1);
        $this->db->where('id',$id);
        $query=$this->db->get();
        return $query->result();
    }
   public function hotel_detail_view_room_type($id) {
        $this->db->select('hotel_tbl_hotel_room_type.*,hotel_tbl_room_type.*,hotel_tbl_hotel_room_type.id as room_id');
        $this->db->from('hotel_tbl_hotel_room_type');
		$this->db->join('hotel_tbl_room_type', 'hotel_tbl_room_type.id = hotel_tbl_hotel_room_type.room_type', 'left');
        $this->db->where('hotel_tbl_hotel_room_type.delflg',1);
        $this->db->where('hotel_tbl_hotel_room_type.id',$id);
        $query=$this->db->get();
        return $query->result();
    }
    public function room_facilties_get_views() {
		$this->db->select('hotel_tbl_room_facility.* , hotel_tbl_hotels.room_facilities');
		$this->db->from('hotel_tbl_room_facility');
		$this->db->join('hotel_tbl_hotels','hotel_tbl_room_facility.room_facilities = hotel_tbl_hotels.id');
		$this->db->where('hotel_tbl_room_facility.delflg',1);
		$this->db->order_by('hotel_tbl_room_facility.id','desc');
	    $query=$this->db->get();
		return $query->result();
	}
	public function maxgetid() {
		$this->db->select_max('id');
		$this->db->from('hotel_tbl_hotels');
		$query=$this->db->get();
		return $query->result_array();
	}
	public function addhotelreqst($property,$hotel_id,$sell_currency,$star,$vcc,$num_room,$channel,$website,$chain,$sale_name,$revenu_name,$sale_mail,$revenu_mail,$sale_number,$password,$revenu_number,$contract_name,$finance_name,$contract_mail,$finance_mail,$contract_number,$finance_number) {
        $data= array(
        	      'delflg'       	=> "2",
        	      'hotel_name'    	=>  $property,
        	      'hotel_code'    	=>  $hotel_id,
        	      'sell_currency' 	=>  $sell_currency,
        	      'rating'        	=>  $star,
        	      'accepting_vcc' 	=>  $vcc,
        	      'Number_of_room'	=>  $num_room,
        	      'channel'       	=>  $channel,
        	      'website'       	=>  $website,
        	      'chain'         	=>  $chain,
        	      'sale_name'     	=>  $sale_name,
        	      'revenu_name'   	=>  $revenu_name,
        	      'contract_name' 	=>  $contract_name,
        	      'finance_name'  	=>  $finance_name,
        	      'contract_mail' 	=>  $contract_mail,
        	      'finance_mail'  	=>  $finance_mail,
        	      'contract_number'	=>  $contract_number,
        	      'finance_number'  =>  $finance_number,
        	      'sale_mail'     	=>  $sale_mail,
        	      'revenu_mail'   	=>  $revenu_mail,
        	      'sale_number'   	=>  $sale_number,
        	      'revenu_number' 	=>  $revenu_number,
        	      'password'      	=>  md5($password),
		      	  'created_date'  	=>  date('Y-m-d'),
		      	);
		$this->db->insert('hotel_tbl_hotels',$data);
		$hotel_id = $this->db->insert_id();
		return $hotel_id;
    }
    public function hotel_permission($request) {
    	$data= array(
		      	  'delflg' => $request['flag'],
		      	  'updated_date' => date('Y-m-d'),
		      	  'updated_by' =>  $this->session->userdata('id'),);
		$this->db->where('id',$request['id']);
		$this->db->update('hotel_tbl_hotels',$data);
		return true;
    }
    //  public function authorizehotelportel($user_name, $password) {
    //     $this->db->select('id,hotel_name,hotel_code');
    //     $this->db->where('hotel_code',$user_name);
    //     $this->db->where('password',$password);
    //     $this->db->where('delflg',"1");
    //     $this->db->from('hotel_tbl_hotels');
    //     $this->db->limit('1');
    //     $query = $this->db->get();
    //     if (count($query->result())!=0) {
    //         return $query->result();
    //     } else {
    //         return "failed";
    //     }
    // }       
     public function authorizehotelportel($user_name, $password) {
        $this->db->select('id,hotel_name,hotel_code');
        $this->db->where('hotel_code',$user_name);
        $this->db->where('password',$password);
        $this->db->where('delflg',"1");
        $this->db->from('hotel_tbl_hotels');
        $this->db->limit('1');
        $query = $this->db->get();
        if (count($query->result())!=0) {
            return $query->result();
            exit();
	         }elseif (count($query->result())==0) {
		        	$this->db->select('id,hotel_name,hotel_code');
		            $this->db->where('hotel_code',$user_name);
		            $this->db->where('password_sale',$password);
		            $this->db->where('delflg',"1");
		            $this->db->from('hotel_tbl_hotels');
		            $this->db->limit('1');
		            $query = $this->db->get();
		              if (count($query->result())!=0) {
		                 return $query->result();
		                 exit();
		                 }elseif (count($query->result())==0) {
				         	 $this->db->select('id,hotel_name,hotel_code');
				             $this->db->where('hotel_code',$user_name);
				             $this->db->where('password_revenue',$password);
				             $this->db->where('delflg',"1");
				             $this->db->from('hotel_tbl_hotels');
				             $this->db->limit('1');
				             $query = $this->db->get();
				               if (count($query->result())!=0) {
				                 return $query->result();
				                 exit();
				                 }elseif (count($query->result())==0) {
						        	$this->db->select('id,hotel_name,hotel_code');
						            $this->db->where('hotel_code',$user_name);
						            $this->db->where('password_contract',$password);
						            $this->db->where('delflg',"1");
						            $this->db->from('hotel_tbl_hotels');
						            $this->db->limit('1');
						            $query = $this->db->get();
						              if (count($query->result())!=0) {
						                 return $query->result();
						                 exit();
						                 }elseif (count($query->result())==0) {
							        	    $this->db->select('id,hotel_name,hotel_code');
								            $this->db->where('hotel_code',$user_name);
								            $this->db->where('password_finance',$password);
								            $this->db->where('delflg',"1");
								            $this->db->from('hotel_tbl_hotels');
								            $this->db->limit('1');
								            $query = $this->db->get();
								              if (count($query->result())!=0) {
								                 return $query->result();
								                 exit();
							                  }else {
							                     return "failed";
							                     exit();
							                   }
				                         }
                                           else {
                                            return "failed";
                                           }
                                 }
	                    } 
	          }
	    else {
           return "failed";
        }
	 }      
    public function add_hotel_policies($data,$id) {
    	$data= array( 
        	      'hotel_id'        => $id,
        	      'Important_Remarks_Policies'    =>  $data['imp_remarks'],
        	      'Important_Notes_Conditions'      =>  $data['cancel_policy'],
        	      'cancelation_policy'      =>  $data['imp_notes'],
		      	  'Created_Date'  => date('Y-m-d'),
		      	  'Created_By'  => $this->session->userdata('id'),
		      	);
		$this->db->insert('hotel_tbl_policies',$data);
		return true;
    }
    public function update_hotel($data,$hotel_id) {
		if (!isset($data['parking'])) {
			$data['parking']=0;
		}
		if (!isset($data['wifi'])) {
			$data['wifi']=0;
		}
		if (!isset($data['internet'])) {
			$data['internet']=0;
		}
		if (!isset($data['accepting'])) {
			$data['accepting'] = 1;
		}
		if (!isset($data['rating'])) {
			$data['rating'] = 2;
		}
		$data = array('location' 			=> $data['location'],
					  'lattitude' 		    => $data['latitude'], 
					  'longitude' 			=> $data['longitude'], 
					  'hotel_name' 			=> $data['hotel_name'], 
					  // 'market' 				=> $data['market'], 
					  'property_name' 		=> $data['property_name'], 
					  'brand_name' 			=> $data['brand_name'], 
					  // 'board' 				=> $data['board'], 
					  'city' 				=> $data['city'],
					  'country' 			=> $data['ConSelect'],
					  'state' 				=> $data['stateSelect'], 
					  'city_near_by' 		=> $data['citynearby'], 
					  'city_description' 	=> $data['citydes'], 
					  'hotel_facilities' 	=> implode(",",$data['hotel_facilties']),
					  'room_facilities' 	=> implode(",",$data['room_facilties1']), 
					  'keywords'			=> $data['keywords'], 
					  'wifi' 				=> $data['wifi'], 
					  'internet' 			=> $data['internet'], 
					  'parking' 			=> $data['parking'], 
					  'rating' 				=> $data['rating'], 
					  'hotel_description' 	=> $data['hotel_description'], 
					  'Number_of_room' 		=> $data['total_no_of_rooms'], 
					  'website' 			=> $data['Website'], 
					  'accepting_vcc' 		=> $data['accepting'], 
					  'channel' 			=> $data['channel_manager'], 
					  'chain' 				=> $data['part_of_chain'], 
					  'sell_currency' 		=> $data['sell_currency'], 
					  'facebook' 			=> $data['facebook'], 
					  'google_plus' 		=> $data['googleplus'], 
					  'twitter' 			=> $data['twitter'], 
					  'linked_in' 			=> $data['Linkedin'], 
					  'whatsapp' 			=> $data['WhatsApp'], 
					  'vk_url' 				=> $data['vkcom'], 
					  'sale_name' 			=> $data['sales_fname'], 
					  'sale_lname' 			=> $data['sales_lname'], 
					  'sale_number' 		=> $data['sales_phone'], 
					  'sale_mobile' 		=> $data['sales_mobile'], 
					  'sale_mail' 			=> $data['sales_mail'], 
					  'sale_address' 		=> $data['sales_address'],
					  'sale_password'	 	=> $data['sales_password'],
					  'password_sale' 		=> md5($data['sales_password']),
					  'revenu_name' 		=> $data['revenue_fname'], 
					  'revenu_lname' 		=> $data['revenue_lname'], 
					  'revenu_mail' 		=> $data['revenue_mail'], 
					  'revenu_number' 		=> $data['revenue_phone'], 
					  'revenu_mobile' 		=> $data['revenue_mobile'], 
					  'revenu_address' 		=> $data['revenue_address'],
					  'revenue_password'	=>$data['revenue_password'],
					  'password_revenue'	=>md5($data['revenue_password']),
					  'contract_name' 		=> $data['contract_fname'], 
					  'contract_lname' 		=> $data['contract_lname'], 
					  'contract_mail' 		=> $data['contract_mail'], 
					  'contract_number' 	=> $data['contract_phone'], 
					  'contract_mobile' 	=> $data['contract_mobile'], 
					  'contracts_address' 	=> $data['contracts_address'],
					  'contract_password' 	=> $data['contract_password'],
					  'password_contract' 	=> md5($data['contract_password']),
					  'finance_name' 		=> $data['finance_fname'], 
					  'finance_lname' 		=> $data['finance_lname'], 
					  'finance_number' 		=> $data['finance_phone'], 
					  'finance_mobile' 		=> $data['finance_mobile'], 
					  'finance_mail' 		=> $data['finance_mail'], 
					  'finance_address' 	=> $data['finance_address'],
					  'finance_password' 	=> $data['finance_password'],
					  'password_finance' 	=> md5($data['finance_password']),
					  'country_code' 		=> $data['country'],
					  'promoteList' 		=> $data['promoteList'],
					  'Preferred_currency' 	=> $data['Preferred_currency'],
					  'updated_date' 		=> date('Y-m-d'), 
					  'updated_by' 			=> $this->session->userdata('id'), 
				);

		$this->db->where('id',$hotel_id);
		$result = $this->db->update('hotel_tbl_hotels',$data);
		return $result; 
	}
	public function hotel_login_details($hotel_log_id) {
		$this->db->select('*');
        $this->db->where('id',$hotel_log_id);
		$this->db->from('hotel_tbl_hotels');
		$query=$this->db->get();
		return $query->result_array();
	}
	public function hotel_facilities_data($id) {
        $this->db->select('hotel_tbl_hotel_facility.* , hotel_tbl_icons.icon_src');
      $this->db->from('hotel_tbl_hotel_facility');
      $this->db->join('hotel_tbl_icons','hotel_tbl_icons.id = hotel_tbl_hotel_facility.Icon', 'left');
      $this->db->where('hotel_tbl_hotel_facility.id',$id);
      $query=$this->db->get();
      return $query->result();
    }
    public function hotel_facilities_all_data() {
        $this->db->select('hotel_tbl_hotel_facility.* , hotel_tbl_icons.icon_src');
      $this->db->from('hotel_tbl_hotel_facility');
      $this->db->join('hotel_tbl_icons','hotel_tbl_icons.id = hotel_tbl_hotel_facility.Icon', 'left');
      $this->db->where('hotel_tbl_hotel_facility.delflg',1);
      $query=$this->db->get();
      return $query->result();
    }
    public function room_facilities_data($id) {
        $this->db->select('hotel_tbl_room_facility.* , hotel_tbl_icons.icon_src');
      $this->db->from('hotel_tbl_room_facility');
      $this->db->join('hotel_tbl_icons','hotel_tbl_icons.id = hotel_tbl_room_facility.Icon', 'left');
      $this->db->where('hotel_tbl_room_facility.id',$id);
      $query=$this->db->get();
      return $query->result();
    }
    public function get_aminity_text($value) {
    	$this->db->select('*');
    	$this->db->from('hotel_tbl_roomaminities');
    	$this->db->where('id',$value);
      	$query=$this->db->get();
      	return $query->result();
    }
    public function get_aminities()
    {
    	$this->db->select('*');
    	$this->db->from('hotel_tbl_roomaminities');
      	$query=$this->db->get();
      	return $query->result();
    }
    public function room_facilities_all_data() {
        $this->db->select('hotel_tbl_room_facility.* , hotel_tbl_icons.icon_src');
      $this->db->from('hotel_tbl_room_facility');
      $this->db->join('hotel_tbl_icons','hotel_tbl_icons.id = hotel_tbl_room_facility.Icon', 'left');
      $this->db->where('hotel_tbl_room_facility.delflg',1);
      $query=$this->db->get();
      return $query->result();
    }
	public function update_hotel_policies($request) {
		$this->db->select('*');
		$this->db->from('hotel_tbl_policies');
		$this->db->where('hotel_id',$request['hotel_id']);
		$this->db->where('contract_id',$request['contract_id']);
		$result = $this->db->get()->result();
		if (count($result)==0) {
			$data= array( 
        	      'hotel_id'        => $request['hotel_id'],
        	      'contract_id'        => $request['contract_id'],
        	      'Important_Remarks_Policies'    =>  $request['imp_remarks'],
        	      'Important_Notes_Conditions'      =>  $request['imp_notes'],
		      	  'Created_Date'  => date('Y-m-d'),
		      	  'Created_By'  => $this->session->userdata('id'),
		      	);
			$this->db->insert('hotel_tbl_policies',$data);
		} else {
	    	$data= array( 
	        	      'Important_Remarks_Policies'    =>  $request['imp_remarks'],
	        	      'Important_Notes_Conditions'      =>  $request['imp_notes'],
			      	  'Updated_Date'  => date('Y-m-d'),
			      	  'Updated_By'  => $this->session->userdata('id'),
			      	);
	        $this->db->where('hotel_id',$request['hotel_id']);
	        $this->db->where('contract_id',$request['contract_id']);
			$this->db->update('hotel_tbl_policies',$data);
		}
		if (isset($request['CancellationPolicySelect']) && $request['CancellationPolicySelect']!="") {
			$data= array( 
	        	      'cancelation_policy'      =>  $request['cancel_policy'],
			      	);
	        $this->db->where('hotel_id',$request['hotel_id']);
	        $this->db->where('contract_id',$request['contract_id']);
	        $this->db->where('id',$request['CancellationPolicySelect']);
			$this->db->update('hotel_tbl_cancellationfee',$data);
		}
		return true;
    }
    public function delete_roomss($id) {
    	$data= array( 
    	      'delflg'    =>  0,
	      	  'updated_date'  => date('Y-m-d'),
	      	  'updated_by'  => $this->session->userdata('id'),
	      	);
    	$this->db->where('id',$id);
		$this->db->update('hotel_tbl_hotel_room_type',$data);
		return true;
    }
    public function update_roomss($room_type_val,$room_type_price,$room_type_facilities,$room_type_occupancy,$room_type_childoccupancy,$no_of_rooms,$id,$room_name_val) {
		$data = array(
					  'room_type' => $room_type_val, 
					  'room_name' => $room_name_val, 
					  'price' => $room_type_price, 
					  'room_facilities' => $room_type_facilities, 
					  'occupancy' => $room_type_occupancy, 
					  'occupancy_child' => $room_type_childoccupancy, 
					  'total_rooms' => $no_of_rooms, 
					  'updated_date' => date('Y-m-d'), 
					  'updated_by' => $this->session->userdata('id'), 
				);
		$this->db->where('id',$id);
		$this->db->update('hotel_tbl_hotel_room_type',$data);
		return true;
	}
	public function updateinghoteldetaillog($data,$hotel_log_id,$aminity,$keyword) {
        
        if (!isset($data['parking'])) {
			$data['parking']=0;
		}
		if (!isset($data['wifi'])) {
			$data['wifi']=0;
		}
		if (!isset($data['internet'])) {
			$data['internet']=0;
		}
		$data= array(
			'hotel_name'         => $data['hotel_name'],
			'lattitude'          => $data['us3-lat'],
			'longitude'          => $data['us3-lon'],
			'market'			 => $data['market'],
			'property_name'		 => $data['property_name'],
			'brand_name'		 => $data['brand_name'],
		    'city'               => $data['city'],
		    'country' 			 => $data['contry'],
			'state' 			 => $data['state'], 
		    'city_near_by'       => $data['citynearby'],
		    'board'				 => $data['board'],
		    'hotel_facilities'   => implode(",",$data['hotel_facilties']),
		    'room_facilities'    => implode(",",$data['room_facilties1']),
			'keywords'           => implode("close",$keyword),
		    'wifi'               => $data['wifi'],
		    'internet'           => $data['internet'],
		    'parking'            => $data['parking'],
		    'rating'             => $data['starr'],
		    'city_description'   => $data['citydes'],
		    'Number_of_room'     => $data['total_no_of_rooms'],
		    'website'            => $data['Website'],
		    'accepting_vcc'      => $data['accept_vcc'],
		    'hotel_description'  => $data['hotel_description'],
		    'sell_currency'      => $data['sell_currency'],
		    'chain'              => $data['part_of_chain'],
		    'channel'            => $data['channel_manager'],
		    'location'           => $data['locationss'],
		    'country_code'       => $data['country'],
		    'Updated_By'         => '',
		    'Updated_Date'       => date('Y-m-d H:i:s'));
		          
		$this->db->where('id',$hotel_log_id);
		$result=$this->db->update('hotel_tbl_hotels',$data);
		return $result;
	}
	public function updateinghoteldetaillog_contact($data,$hotel_log_id) {
		// print_r($data);
		// exit();
		$data= array(
		    'sale_name'       => $data['sales_fname'],
		    'sale_lname'      => $data['sales_lname'],
		    'sale_number'     => $data['sales_phone'],
		    'sale_mobile'     => $data['sales_mobile'],
		    'sale_address'    => $data['sales_address'],
		    'revenu_name'     => $data['revenue_fname'],
		    'revenu_lname'    => $data['revenue_lname'],
		    'revenu_number'   => $data['revenue_phone'],
		    'revenu_mobile'   => $data['revenue_mobile'],
		    'revenu_address'  => $data['revenue_address'],
			'contract_name'   => $data['contract_fname'], 
			'contract_lname'  => $data['contract_lname'], 
			'contract_number' => $data['contract_phone'], 
			'contract_mobile' => $data['contract_mobile'], 
			'contracts_address' => $data['contracts_address'],
			'finance_name'      => $data['finance_fname'], 
			'finance_lname'     => $data['finance_lname'], 
			'finance_number'    => $data['finance_phone'], 
			'finance_mobile'    => $data['finance_mobile'], 
			'finance_address'   => $data['finance_address'],);
		          
		$this->db->where('id',$hotel_log_id);
		$result=$this->db->update('hotel_tbl_hotels',$data);
		return $result;
	}
	public function updateinghoteldetaillog_social($data,$hotel_log_id) {
		$data= array(
			'facebook'      => $data['facebook'],
			'google_plus'   => $data['google_plus'],
			'twitter'       => $data['twitter'],
		    'linked_in'     => $data['linked_in'],
		    'whatsapp'      => $data['whatsapp'],
		    'vk_url'        => $data['vk_url'],);
		          
		$this->db->where('id',$hotel_log_id);
		$result=$this->db->update('hotel_tbl_hotels',$data);
		return $result;
	}
   
   public function hotel_login_room_details($request,$hotel_log_id)
	{    
		$data= array(
		          'hotel_id'        => $hotel_log_id,
		          'room_type'       => $request['room_type'],
		          'price'           => $request['price'],
		          'room_facilities' => implode(",",$request['room_facilti']),
		          'occupancy'       => $request['max_occ_adult'],
		          'occupancy_child' => $request['max_occ_child'],
		          'room_name' 		=> $request['room_name'],
		          'standard_capacity'=> $request['standard_capacity'],
		          'max_total' 		=> $request['max_total'],
		          'total_rooms'     => $request['no_rooms'],
		          'allotement'     	=> $request['allotement'],
		          'created_date'    => date('Y-m-d H:i:s'),
		      	  'created_by' 		=> '');
	
		$this->db->insert('hotel_tbl_hotel_room_type',$data);
		$hotel_room_id = $this->db->insert_id();
		return $hotel_room_id;
	}
  public function hotel_login_room_details_uploads($request,$room_id)
	{    
		$data= array(
		          'room_type'       => $request['room_type'],
		          'price'           => $request['price'],
		          'room_facilities' => implode(",",$request['room_facilti']),
		          'occupancy'       => $request['max_occ_adult'],
		          'occupancy_child' => $request['max_occ_childe'],
		          'total_rooms'     => $request['no_rooms'],
		          'allotement'     	=> $request['allotement'],
		      	  'updated_date'    => date('Y-m-d H:i:s'),
		      	  'updated_by'		=> '');
		$this->db->where('id',$room_id);
		$this->db->update('hotel_tbl_hotel_room_type',$data);
		return true;
	 }
   public function delete_room_type_hotel_portel($room_id)
	{ 
		$data= array(
		          'delflg' => 0,);
		$this->db->where('id',$room_id);
		$this->db->update('hotel_tbl_hotel_room_type',$data);
		return true;
	}
	public function hotel_mail_details($id) {
		$this->db->select('*');
        $this->db->where('id',$id);
		$this->db->from('hotel_tbl_hotels');
		$query=$this->db->get();
		return $query->result();
	}
	public function reset_password($id) {
		$data= array(
		          'password_reset' => 1,);
		$this->db->where('id',$id);
		$this->db->update('hotel_tbl_hotels',$data);
		return true;
	}
	public function hotel_room_booking_list($filter) {
      $id = $this->session->userdata('hotelid');
      $this->db->select('hotel_tbl_booking.id as bk_id ,hotel_tbl_booking.* , hotel_tbl_hotels.hotel_name, ,hotel_tbl_room_type.Room_Type, hotel_tbl_hotels.sell_currency');
      $this->db->from('hotel_tbl_booking');
      $this->db->join('hotel_tbl_hotels','hotel_tbl_booking.hotel_id = hotel_tbl_hotels.id', 'left');
      $this->db->join('hotel_tbl_hotel_room_type','hotel_tbl_booking.room_id = hotel_tbl_hotel_room_type.id', 'left');
      $this->db->join('hotel_tbl_room_type','hotel_tbl_hotel_room_type.room_type = hotel_tbl_room_type.id', 'left');
      $this->db->where('hotel_tbl_booking.hotel_id',$id);
      $this->db->where('hotel_tbl_booking.booking_flag',$filter);
      // $this->db->where('hotel_tbl_booking.check_in >=',date('m/d/Y'));
      // $this->db->where('hotel_tbl_booking.booking_flag !=',3);
      $this->db->order_by('hotel_tbl_booking.id','desc');
      return $query=$this->db->get();
    } 
    public function hotel_booking_detail($book_id) {
      $id = $this->session->userdata('hotelid');
      $this->db->select('*,hotel_tbl_booking.Created_Date as booking_date,hotel_tbl_booking.board as boardName,hotel_tbl_booking.id as bkid');
      $this->db->from('hotel_tbl_booking');
      $this->db->join('hotel_tbl_hotels','hotel_tbl_booking.hotel_id = hotel_tbl_hotels.id', 'left');
      $this->db->join('hotel_tbl_hotel_room_type','hotel_tbl_booking.room_id = hotel_tbl_hotel_room_type.id', 'left');
      $this->db->join('hotel_tbl_room_type','hotel_tbl_hotel_room_type.room_type = hotel_tbl_room_type.id', 'left');
      $this->db->where('hotel_tbl_booking.id',$book_id);
      $this->db->where('hotel_tbl_booking.hotel_id',$id);
      // $this->db->where('hotel_tbl_booking.booking_flag !=',3);
      $query=$this->db->get();
      return $query->result();
    } 
	public function hotel_policies_check($id) {
	 	$this->db->select('*');
        $this->db->where('hotel_id',$id);
		$this->db->from('hotel_tbl_policies');
		$query=$this->db->get();
		return $query->result();
	}
	public function hotel_booking_permission($request) {
		$data= array(
		      	  'booking_flag' => 4,
		      	  'Updated_Date' => date('Y-m-d'),
		      	  'Updated_By' =>  $this->session->userdata('id'),);
		$this->db->where('id',$request['id']);
		$this->db->update('hotel_tbl_booking',$data);
		return true;
	}
	public function booking_reject($id) {
      $datas = array(
        'booking_flag' => 3);
      $this->db->where('id',$id);
      $this->db->update('hotel_tbl_booking',$datas);
      return true;
    }
    public function booking_cancel_Request($id) {
      $datas = array(
        'booking_flag' => 5);
      $this->db->where('id',$id);
      $this->db->update('hotel_tbl_booking',$datas);
      return true;
    }
    public function invoice_check($id) {
    	$this->db->select('*');
        $this->db->where('invoice_id',$id);
		$this->db->from('hotels_tbl_booking_invoice');
		$query=$this->db->get();
		return $query->result();
    }
   
    public function hotel_invoice($id) {
    	$this->db->select('*');
        $this->db->where('booking_id',$id);
		$this->db->from('hotels_tbl_booking_invoice');
		$query=$this->db->get();
		return $query->result();
    }
    public function hotel_room_booking_history_list() {
      $id = $this->session->userdata('hotelid');
      $this->db->select('hotel_tbl_booking.* , hotel_tbl_hotels.hotel_name, ,hotel_tbl_room_type.Room_Type, hotel_tbl_hotels.sell_currency');
      $this->db->from('hotel_tbl_booking');
      $this->db->join('hotel_tbl_hotels','hotel_tbl_booking.hotel_id = hotel_tbl_hotels.id', 'left');
      $this->db->join('hotel_tbl_hotel_room_type','hotel_tbl_booking.room_id = hotel_tbl_hotel_room_type.id', 'left');
      $this->db->join('hotel_tbl_room_type','hotel_tbl_hotel_room_type.room_type = hotel_tbl_room_type.id', 'left');
      $this->db->where('hotel_tbl_booking.hotel_id',$id);
      $this->db->where('hotel_tbl_booking.check_out <',date('m/d/Y'));
      $this->db->where('hotel_tbl_booking.booking_flag ',4);
      $this->db->order_by('hotel_tbl_booking.id','desc');
      return $query=$this->db->get();
    } 
    public function hotel_login_policies($id) {
		$this->db->select('*');
        $this->db->where('hotel_id',$id);
		$this->db->from('hotel_tbl_policies');
		$query=$this->db->get();
		return $query->result();
	}
	public function agent_details_from_booking($id) {
      $this->db->select('*');
      $this->db->from('hotel_tbl_booking');
      $this->db->join('hotel_tbl_agents','hotel_tbl_booking.agent_id = hotel_tbl_agents.id', 'left');
      $this->db->join('hotel_tbl_hotels','hotel_tbl_booking.hotel_id = hotel_tbl_hotels.id', 'left');
      $this->db->join('hotel_tbl_hotel_room_type','hotel_tbl_booking.room_id = hotel_tbl_hotel_room_type.id', 'left');
      $this->db->join('hotel_tbl_room_type','hotel_tbl_hotel_room_type.room_type = hotel_tbl_room_type.id', 'left');
      $this->db->where('hotel_tbl_booking.id',$id);
      $query=$this->db->get();
      return $query->result();
    }
    public function user_details_from_booking() {
	    $this->db->select('*');
	    $this->db->from('hotel_tbl_user');
	    $this->db->where('id','1');
	    $query=$this->db->get();
	    return  $query->result();
    }
    public function update_hotel_pwd($request,$pwd) {
    	$data= array( 
		      	  'password' => md5($pwd));
    	$this->db->where('id',$request['id']);
		$this->db->update('hotel_tbl_hotels',$data);
		return true;
    }
    public function hotels_rooms_counts($id,$flag) {
      $this->db->select('*');
      $this->db->from('hotel_tbl_hotels');
      $this->db->where('id',$id);
      $this->db->where('delflg',$flag);
      $query=$this->db->get();
      return $query->result();
    }
    public function check_password_reset($id) {
      $this->db->select('password_reset,hotel_code,id');
      $this->db->from('hotel_tbl_hotels');
      $this->db->where('id',$id);
      $query=$this->db->get();
      return $query->result();
    }
  //   public function add_hotel_contract($data,$con_id,$hotel_id) {
  //   	$datas= array( 
  //       	      'contract_id'        => $con_id,
  //       	      'hotel_id'           => $hotel_id,
  //       	      'contract_type'      => $data['contract_type'],
  //       	      'classification'     => $data['classification'],
		//       	  'application'        => $data['application'],
		//       	  'max_child_age'      => $data['max_child_age'],
		//       	  'rate_type'          => $data['rate_type'],
		//       	  'tax_percentage'     => $data['tax_percentage'],
		//       	  'credit_limit'       => $data['credit_limit'],
		//       	  'credit_period'      => $data['credit_period'],
		//       	  'pay_mode'           => $data['pay_mode'],
		//       	  'cheque_no'          => $data['check_number'],
		//       	  'bank_name'          => $data['bank_name'],
		//       	  'account_number'     => $data['account_number'],
		//       	  'account_holder'     => $data['account_holder'],
		//       	  'iban'               => $data['iban'],
		//       	  'swift'              => $data['swift'],
		//       	  'ifsc'               => $data['ifsc'],
		//       	  'hotel_admin_name'   => $data['hotel_admin_name'],
		//       	  'hotel_admin_email'  => $data['hotel_admin_email'],
		//       	  'markup'             => $data['markup'],
		//       	);
		// $this->db->insert('hotel_tbl_contract',$datas);
		// return true;
  //   }
    public function hotel_contract_check($id) {
	 	$this->db->select('*');
        $this->db->where('hotel_id',$id);
		$this->db->from('hotel_tbl_contract');
		$query=$this->db->get();
		return $query->result();
	}
	public function update_hotel_contract($data,$id) {
		$datas= array( 
        	      'contract_type'       => $data['contract_type'],
        	      'classification'      => $data['classification'],
		      	  'application'         => $data['application'],
		      	  'max_child_age'       => $data['max_child_age'],
		      	  'rate_type'           => $data['rate_type'],
		      	  'tax_percentage'      => $data['tax_percentage'],
		      	  'credit_limit'        => $data['credit_limit'],
		      	  'credit_period'       => $data['credit_period'],
		      	  'pay_mode'            => $data['pay_mode'],
		      	  'cheque_no'           => $data['check_number'],
		      	  'bank_name'           => $data['bank_name'],
		      	  'account_number'      => $data['account_number'],
		      	  'account_holder'      => $data['account_holder'],
		      	  'iban'                => $data['iban'],
		      	  'swift'               => $data['swift'],
		      	  'ifsc'                => $data['ifsc'],
		      	  'hotel_admin_name'    => $data['hotel_admin_name'],
		      	  'hotel_admin_email'   => $data['hotel_admin_email'],
		      	  'markup'              => $data['markup'],
		      	);
        $this->db->where('hotel_id',$id);
		$this->db->update('hotel_tbl_contract',$datas);
		return true;
    }
    public function hotel_rooms_list($id) {
        $this->db->select('hotel_tbl_hotel_room_type.*,hotel_tbl_room_type.Room_Type as room_type_name');
        $this->db->from('hotel_tbl_hotel_room_type');
        $this->db->join('hotel_tbl_room_type','hotel_tbl_room_type.id = hotel_tbl_hotel_room_type.room_type', 'left');
        $this->db->where('hotel_tbl_hotel_room_type.hotel_id',$id);
        $this->db->where('hotel_tbl_hotel_room_type.delflg',1);
        $this->db->order_by('hotel_tbl_hotel_room_type.id','desc');
        return $query=$this->db->get();
    }
    public function room_names_get($hotel_id) {
    	$this->db->select('room_name');
        $this->db->from('hotel_tbl_hotel_room_type');
        $this->db->where('hotel_id',$hotel_id);
        $this->db->where('delflg',1);
        $query=$this->db->get();
        return $query->result();
    }
    public function LinkedRoomDetailsGet($hotel_id,$room_id) {
    	$this->db->select('hotel_tbl_hotel_room_type.id,hotel_tbl_room_type.Room_Type,hotel_tbl_hotel_room_type.room_name');
        $this->db->from('hotel_tbl_hotel_room_type');
        $this->db->join('hotel_tbl_room_type','hotel_tbl_room_type.id = hotel_tbl_hotel_room_type.room_type', 'left');
        $this->db->where('hotel_tbl_hotel_room_type.hotel_id',$hotel_id);
        if (isset($room_id) && $room_id!="") {
        	$this->db->where('hotel_tbl_hotel_room_type.id !=',$room_id);
        }
        $this->db->where('hotel_tbl_hotel_room_type.delflg',1);
        $query=$this->db->get();
        return $query->result();
    }
    public function add_new_room($request) {
    	if (!isset($request['allotement_room_name'])) {
    		$request['allotement_room_name']="";
    	}
    	if (!isset($request['allotement_room_type'])) {
    		$request['allotement_room_type']="";
    	}
    	if (!isset($request['allotement_id'])) {
    		$request['allotement_id']="";
    	}
		$data = array('hotel_id'               => $request['hotel_id'],
					  'room_name'              => $request['room_name'],
					  'room_type'              => $request['roomtype'], 
					  // 'allotement'             => $request['allotement'], 
					  // 'price'                  => $request['price'], 
					  'room_facilities'        => implode(",", $request['room_facilties']), 
					  'occupancy'              => $request['occupancy'], 
					  'occupancy_child'        => $request['occupancy_child'], 
					  'total_rooms'            => $request['no_of_rooms'], 
					  'max_total'		   	   => $request['max_total'],
					  'standard_capacity'      => $request['standarad'],
					  'linked_to_room_type'    => $request['LinkedRoom'],
					  'created_date'           => date('Y-m-d'), 
					  'created_by'             => $this->session->userdata('id'), 
				);
		$this->db->insert('hotel_tbl_hotel_room_type',$data);
        $hotel_room_id = $this->db->insert_id();
		return $hotel_room_id;
	}
	public function allotement_room_id_get($hotel_id,$room_name,$room_type) {
    	$this->db->select('hotel_tbl_hotel_room_type.id');
        $this->db->from('hotel_tbl_hotel_room_type');
        $this->db->join('hotel_tbl_room_type','hotel_tbl_room_type.id = hotel_tbl_hotel_room_type.room_type', 'left');
        $this->db->where('hotel_tbl_hotel_room_type.hotel_id',$hotel_id);
        $this->db->where('hotel_tbl_hotel_room_type.room_name',$room_name);
        $this->db->where('hotel_tbl_hotel_room_type.room_type',$room_type);
        $this->db->where('hotel_tbl_hotel_room_type.delflg',1);
        $query=$this->db->get();
        return $query->result();
    }
    public function room_type_single_data_get($id,$hotel_id) {
    	$this->db->select('hotel_tbl_hotel_room_type.room_name,hotel_tbl_room_type.Room_Type');
        $this->db->from('hotel_tbl_hotel_room_type');
        $this->db->join('hotel_tbl_room_type','hotel_tbl_room_type.id = hotel_tbl_hotel_room_type.room_type', 'left');
		$this->db->where('hotel_tbl_hotel_room_type.id',$id);
		$this->db->where('hotel_tbl_hotel_room_type.hotel_id',$hotel_id);
		$this->db->limit('1');
	    $query=$this->db->get();
		$final =  $query->result();
		if (count($final)!=0) {
			return $final[0]->room_name." ".$final[0]->Room_Type;
		} else {
			return '';
		}
	}
	public function update_room($request) {
    	if (!isset($request['allotement_room_name'])) {
    		$request['allotement_room_name']="";
    	}
    	if (!isset($request['allotement_room_type'])) {
    		$request['allotement_room_type']="";
    	}
    	if (!isset($request['allotement_id'])) {
    		$request['allotement_id']="";
    	}
		$data = array('hotel_id'           => $request['hotel_id'],
					  'room_name'          => $request['room_name'],
					  'room_type'          => $request['roomtype'], 
					  // 'price'              => $request['price'], 
					  // 'allotement'         => $request['allotement'], 
					  'room_facilities'    => implode(",", $request['room_facilties']), 
					  'occupancy'          => $request['occupancy'], 
					  'occupancy_child'    => $request['occupancy_child'], 
					  'total_rooms'        => $request['no_of_rooms'], 
					  'max_total'		   => $request['max_total'],
					  'standard_capacity'  => $request['standarad'],
					  'linked_to_room_type'    => $request['LinkedRoom'],
					  'updated_date'       => date('Y-m-d'), 
					  'updated_by' => $this->session->userdata('id'), 
				);
		$this->db->where('id',$request['room_id']);
		$this->db->update('hotel_tbl_hotel_room_type',$data);
		return true;
	}
	public function delete_room($id) {
		$data = array('delflg' => 0,
					  'updated_date' => date('Y-m-d'), 
					  'updated_by' => $this->session->userdata('id'), 
				);
		$this->db->where('id',$id);
		$this->db->update('hotel_tbl_hotel_room_type',$data);
		return true;
	}
    public function hotel_contract_details($hotel_id) {
		$this->db->where('hotel_id',$hotel_id);
		$this->db->from('hotel_tbl_contract');
	    $query=$this->db->get();
		return $query->result();
	}
	public function hotel_rooms_list_count($id) {
        $this->db->select('*,hotel_tbl_hotel_room_type.id as count');
        $this->db->from('hotel_tbl_hotel_room_type');
        $this->db->where('hotel_id',$id);
        $this->db->where('delflg',1);
        $this->db->order_by('id','desc');
        // return $query=$this->db->get();
        $query=$this->db->get();
		return $query->result();
    }
   public function hotel_rooms_list_count_check($id) {
        $this->db->select('hotel_tbl_hotel_room_type.*,hotel_tbl_room_type.Room_Type as room_type_name');
        $this->db->from('hotel_tbl_hotel_room_type');
        $this->db->join('hotel_tbl_room_type','hotel_tbl_room_type.id = hotel_tbl_hotel_room_type.room_type', 'left');
        $this->db->where('hotel_tbl_hotel_room_type.hotel_id',$id);
        $this->db->where('hotel_tbl_hotel_room_type.delflg',1);
        $this->db->order_by('hotel_tbl_hotel_room_type.id','desc');
        // return $query=$this->db->get();
        $query=$this->db->get();
		return $query->result();
    } 
    public function observation_comment_get($request)
    {
    	$this->db->select('*');
        $this->db->from('hotel_tbl_hotels');
        $this->db->where('id',$request['id']);
        $query=$this->db->get();
        return $query->result();
    }
    public function observation_comment_update($request)
    {
    	$data= array('observation_command' 	=> $request['comment']);
    	 $this->db->where('id',$request['hotel_id']);
    	$this->db->update('hotel_tbl_hotels',$data);
    	return true;
    }
	public function hotel_rooms_list_count_details($hotel_log_id) {
        $this->db->select('*,hotel_tbl_hotel_room_type.id as count');
        $this->db->from('hotel_tbl_hotel_room_type');
        $this->db->where('hotel_id',$hotel_log_id);
        $this->db->where('delflg',1);
        $this->db->order_by('id','desc');
        // return $query=$this->db->get();
        $query=$this->db->get();
		return $query->result();
    }
    public function permission_agent_list($id) {
        $this->db->select('*');
        $this->db->from('hotel_tbl_agents');
        $this->db->where('delflg',1);
      	return  $query=$this->db->get();
    }
     
 
	public function add_hotel_closeout_period($request){

		$data= array( 'hotel_id'   => $request['hotelid'],
			          'from_date'  => $request['from_date'],
			          'to_date'    => $request['to_date'],

			          'reason'     => $request['reason'],
			          'delflg'     => 1,
			        );
		$this->db->insert('hotel_tbl_closeout_period',$data);
		return true;
	}
	public function update_hotel_closeout_period($request){

		$implode_room_types = "";
    	if (isset($request['room_type'])) {
    		$implode_room_types = implode(",", $request['room_type']);
    	}
    	if ($request['id']!="") {
    		$data= array('reason'     => $request['reason'],
    					  'roomType'  => $implode_room_types,
    					  'UpdatedBy' => $this->session->userdata('id'),
    					  'UpdatedDate' => date('Y-m-d H:i:s')
			        );
			$this->db->where('id',$request['id']);
			$this->db->update('hotel_tbl_closeout_period',$data);
			// Log entry start
			$id = $request['id'];
			$dataLOG= array( 
					'id'			  => $id,
				 	'hotel_id'   => $request['hotel_id'],
			        'contract_id' => $request['contract_id'],
			        'closedDate'  => $request['closedDate'],
			        'roomType'   => $implode_room_types,
			        'reason'     => $request['reason'],
			        'delflg'     => 1,
			        'CreatedBy' => $this->session->userdata('id'),
			  		'CreatedDate' => date('Y-m-d H:i:s'),
			  		'Status'  	=> 'close'
			);
			$this->db->insert('hotel_tbl_closeout_period_log',$dataLOG);
			// Log entry end
    	} else {
    		$start_date=date_create($request['from_date_edit']);
	        $end_date=date_create($request['to_date_edit']);
	        $no_of_days=date_diff($start_date,$end_date);
	        $tot_days = $no_of_days->format("%a");
        	for($i = 0; $i <= $tot_days; $i++) {
		       $result[$i]= date('Y-m-d', strtotime($request['from_date_edit']. ' + '.$i.'  days'));
	        }
	        foreach ($result as $key => $value) {
	        	$this->db->select('*');
	        	$this->db->from('hotel_tbl_closeout_period');
				$this->db->where('closedDate',$value);
				$this->db->where('hotel_id',$request['hotel_id']);
				$this->db->where('contract_id',$request['contract_id']);
      	  		$query[$key]=$this->db->get()->result();
      	  		if (count($query[$key])!=0) {
  	  				$data= array('reason'     => $request['reason'],
  	  							  'roomType'  => $implode_room_types,
					        );
					$this->db->where('closedDate',$value);
					$this->db->where('hotel_id',$request['hotel_id']);
					$this->db->where('contract_id',$request['contract_id']);
					$this->db->update('hotel_tbl_closeout_period',$data);
					// Log entry start
					$dataLOG= array( 
						 	'hotel_id'   => $request['hotel_id'],
					        'contract_id' => $request['contract_id'],
					        'closedDate'  => $value,
					        'roomType'   => $implode_room_types,
					        'reason'     => $request['reason'],
					        'delflg'     => 1,
					        'CreatedBy' => $this->session->userdata('id'),
					  		'CreatedDate' => date('Y-m-d H:i:s'),
					  		'Status' 	 => 'close'
					);
					$this->db->insert('hotel_tbl_closeout_period_log',$dataLOG);
					// Log entry end
      	  		} else {
      	  			$data= array( 'hotel_id'   => $request['hotel_id'],
						          'contract_id' => $request['contract_id'],
						          'closedDate'  => $value,
						           'roomType'   => $implode_room_types,
						          'reason'     => $request['reason'],
						          'delflg'     => 1,
						          'CreatedBy' => $this->session->userdata('id'),
    					  		  'CreatedDate' => date('Y-m-d H:i:s')
						        );
					$this->db->insert('hotel_tbl_closeout_period',$data);
					// Log entry start
					$id = $this->db->insert_id();
					$dataLOG= array( 
							'id'			  => $id,
						 	'hotel_id'   => $request['hotel_id'],
					        'contract_id' => $request['contract_id'],
					        'closedDate'  => $value,
					        'roomType'   => $implode_room_types,
					        'reason'     => $request['reason'],
					        'delflg'     => 1,
					        'CreatedBy' => $this->session->userdata('id'),
					  		'CreatedDate' => date('Y-m-d H:i:s'),
					  		'Status'	=> 'close'
					);
					$this->db->insert('hotel_tbl_closeout_period_log',$dataLOG);
					// Log entry end
      	  		}
	        }
    	}
		return true;
	}
	public function dlt_hotel_closeout_period($id){
		$this->db->select('*');
		$this->db->from('hotel_tbl_closeout_period');
		$this->db->where('id',$id);
		$this->db->where('id',$id);
	    $details=$this->db->get()->result();
		$this->db->where('id',$id);
		$this->db->delete('hotel_tbl_closeout_period');
		$dataLOG= array( 
				'id'			  => $id,
			 	'hotel_id'   => $details[0]->hotel_id,
		        'contract_id' => $details[0]->contract_id,
		        'closedDate'  => $details[0]->closedDate,
		        'roomType'   => $details[0]->roomType,
		        'reason'     => $details[0]->reason,
		        'delflg'     => 1,
		        'CreatedBy' => $this->session->userdata('id'),
		  		'CreatedDate' => date('Y-m-d H:i:s'),
		  		'Status'  	=> 'open'
			);
			$this->db->insert('hotel_tbl_closeout_period_log',$dataLOG);
			// Log entry end
		return true;
	}
   	public function hotel_closeout_select($id,$contract_id) {    
		$this->db->select('*');
		$this->db->from('hotel_tbl_closeout_period');
		$this->db->where('delflg',1);
		$this->db->where('hotel_id',$id);
		$this->db->where('contract_id',$contract_id);
		$this->db->order_by('closedDate','asc');
	    $query=$this->db->get();
		return $query;
	}
	public function hotel_closeout_edit_data($id) {
		$this->db->select('*');
		$this->db->from('hotel_tbl_closeout_period');
		$this->db->where('id',$id);
	    $query=$this->db->get();
		return $query->result();
	}
	// public function hotel_closeout_edit_data($id,$request)
	// {
	// 	$data= array('hotel_id'    => $request['hotel_id'],
	// 		          'from_date'  => $request['from_date'],
	// 		          'to_date'    => $request['to_date'],
	// 		          'reason'     => $request['reason'],
	// 		          'delflg'     => 1,
	// 		        );
	// 	$this->db->where('id',$id);
	// 	$this->db->update('hotel_tbl_hotel_facility',$data);
	// 	return true;
	// }
	 public function permission_agent_id($hotel_id,$contract_id) {
        $this->db->select('*');
        $this->db->from('hotel_agent_permission');
       	$this->db->where('hotel_id',$hotel_id);
       	$this->db->where('contract_id',$contract_id);
      	$query=$this->db->get();
		return $query->result();
    }
	public function allotement_update($alotement_date,$room_id,$hotel_id,$price,$alotement,$cut_off,$contract_id) {
		$price = backend_Aed_convertion(hotel_currency_type($hotel_id),$price);
		$this->db->select('*');
    	$this->db->from('hotel_tbl_contract');
    	$this->db->where('hotel_id',$hotel_id);
    	$this->db->where('contract_id',$contract_id);
    	$contract_type = $this->db->get()->result();

		$this->db->select('*');
		$this->db->from('hotel_tbl_allotement');
		$this->db->where('hotel_id',$hotel_id);
		$this->db->where('room_id',$room_id);
		$this->db->where('contract_id',$contract_id);
		$this->db->where('allotement_date',$alotement_date);
	    $query=$this->db->get();
		$final = $query->result();
		if (count($final)!=0) {
			if ($contract_type[0]->contract_type!="Main") {
				$data1= array( 'amount'     => $price,
		        );
				$this->db->where('contract_id',$contract_id);
				$this->db->where('hotel_id',$hotel_id);
				$this->db->where('room_id',$room_id);
				$this->db->where('allotement_date',$alotement_date);
				$this->db->update('hotel_tbl_allotement',$data1);
				// Log entry start
			    $dataLOG= array( 
			         'room_id'          => $room_id,
			         'hotel_id'         => $hotel_id,
			         'allotement_date'  => $alotement_date,
			         'amount'           => $data1['amount'],
			         'allotement'       => 0,
			         'cut_off'          => 0,
			         'contract_id'      => $contract_id,
			         'CreatedDate'      => date('Y-m-d H:i:s'),
			         'CreatedBy'        => $this->session->userdata('id'),
			         'Status'           => 'updated'
			        );
			    $this->db->insert('hotel_tbl_allotement_log',$dataLOG);
				// Log entry end
			} else {
				$data1= array( 'amount'     => $price,
					          'allotement'     => $alotement,
					          'cut_off' => $cut_off,
		        );
				$this->db->where('contract_id',$contract_id);
				$this->db->where('hotel_id',$hotel_id);
				$this->db->where('room_id',$room_id);
				$this->db->where('allotement_date',$alotement_date);
				$this->db->update('hotel_tbl_allotement',$data1);
				// Log entry start
				$dataLOG= array( 
			         'room_id'          => $room_id,
			         'hotel_id'         => $hotel_id,
			         'allotement_date'  => $alotement_date,
			         'amount'           => $price,
			         'allotement'       => $alotement,
			         'cut_off'          => $cut_off,
			         'contract_id'      => $contract_id,
			         'CreatedDate'      => date('Y-m-d H:i:s'),
			         'CreatedBy'        => $this->session->userdata('id'),
			         'Status'           => 'updated'
			        );
			    $this->db->insert('hotel_tbl_allotement_log',$dataLOG);
				// Log entry end
			}
		} else {
			if ($contract_type[0]->contract_type!="Main") {
				$data= array( 'room_id'  => $room_id,
					          'hotel_id'    => $hotel_id,
					          'allotement_date' => $alotement_date,
					          'amount'     => $price,
					          'contract_id' => $contract_id
		        );
				$this->db->insert('hotel_tbl_allotement',$data);
				$id = $this->db->insert_id();
				// Log entry start
				    $dataLOG= array( 
				         'id'               => $id,
				         'room_id'          => $room_id,
				         'hotel_id'         => $hotel_id,
				         'allotement_date'  => $alotement_date,
				         'amount'           => $price,
				         'contract_id'      => $contract_id,
				         'CreatedDate'      => date('Y-m-d H:i:s'),
				         'CreatedBy'        => $this->session->userdata('id'),
				         'Status'           => 'inserted'
				        );
				$this->db->insert('hotel_tbl_allotement_log',$dataLOG);
				// Log entry end

			} else {
				$data= array( 'room_id'  => $room_id,
					          'hotel_id'    => $hotel_id,
					          'allotement_date' => $alotement_date,
					          'amount'     => $price,
					          'allotement'     => $alotement,
					          'cut_off' => $cut_off,
					          'contract_id' => $contract_id
		        );
				$this->db->insert('hotel_tbl_allotement',$data);
				$id = $this->db->insert_id();
				// Log entry start
				    $dataLOG= array( 
				         'id'               => $id,
				         'room_id'          => $room_id,
				         'hotel_id'         => $hotel_id,
				         'allotement_date'  => $alotement_date,
				         'amount'    		=> $price,
					     'allotement'     	=> $alotement,
					     'cut_off'          => $cut_off,
				         'contract_id'      => $contract_id,
				         'CreatedDate'      => date('Y-m-d H:i:s'),
				         'CreatedBy'        => $this->session->userdata('id'),
				         'Status'           => 'inserted'
				        );
				$this->db->insert('hotel_tbl_allotement_log',$dataLOG);
				// Log entry end
			}
		}
		return true;
	}
	public function allot_update($alotement_date,$room_id,$hotel_id,$alotement,$cut_off,$contract_id) {
		$this->db->select('*');
		$this->db->from('hotel_tbl_allotement');
		$this->db->where('hotel_id',$hotel_id);
		$this->db->where('room_id',$room_id);
		$this->db->where('contract_id',$contract_id);
		$this->db->where('allotement_date',$alotement_date);
	    $query=$this->db->get();
		$final = $query->result();
		if (count($final)!=0) {
			$data1= array( 
						// 'amount'     => $price,
				          'allotement'     => $alotement,
				          'cut_off' 	   => $cut_off,
				          'contract_id'    => $contract_id
	        );
			$this->db->where('hotel_id',$hotel_id);
			$this->db->where('room_id',$room_id);
			$this->db->where('allotement_date',$alotement_date);
			$this->db->update('hotel_tbl_allotement',$data1);
		} else {
			$data= array( 'room_id'  		=> $room_id,
				          'hotel_id'    	=> $hotel_id,
				          'allotement_date' => $alotement_date,
				          // 'amount'     => $price,
				          'allotement'     	=> $alotement,
				          'cut_off' 		=> $cut_off,
				          'contract_id' 	=> $contract_id
	        );
			$this->db->insert('hotel_tbl_allotement',$data);
		}
		return true;
	}
	public function agent_permission_update($id,$agent_id,$contract_id)
	{
		$this->db->select('*');
        $this->db->from('hotel_agent_permission');
        $this->db->where('hotel_id',$id);
        $this->db->where('contract_id',$contract_id);
        $query=$this->db->get();
        $final = $query->result();
        if(count($final) != 0 ){
			$data= array(
						 'permission' 	  => $agent_id,
						);

			$this->db->where('hotel_id',$id);
			$this->db->where('contract_id',$contract_id);
			$this->db->update('hotel_agent_permission',$data);						 
		}
		else {
		  $data1= array( 
						 'hotel_id' 	  => $id,
						 'permission' 	  => $agent_id,
						 'contract_id' 	  => $contract_id,
	        			);
			$this->db->insert('hotel_agent_permission',$data1);
		}
		return true;
	}
	public function password_update($hotel_id,$password) {
		$data= array(
		 'password' 	  => md5($password),
		);
		$this->db->where('id',$hotel_id);
		$this->db->update('hotel_tbl_hotels',$data);	
		return true;
	}
	 public function invoice_insert($id,$request) {
    	// $this->db->select_max('invoice_id');
     //    $this->db->from('hotel_tbl_booking');
     //     // $this->db->where('id',$id);        
     //     $query=$this->db->get()->result();
     //    if (count($query)==0) {
     //        $max_id = "INVOICE001";
     //    } else {
     //        $max = $query[0]->invoice_id;
     //        $max_invoice = explode("INVOICE" , $max);
     //        $max_id ="INVOICE00".($max_invoice[1]+ 1) ;
     //    }

        $data= array(
              // 'invoice_date' =>  date('Y-m-d'),
              // 'invoice_id'   =>  $max_id,
              'confirmationNumber' => $request['booking_confirmation'],
              'confirmationName' => $request['booking_confirmation_name'],
              
          );
         $this->db->where('id',$id);
        $this->db->update('hotel_tbl_booking',$data);


        $this->db->select('*');
		$this->db->from('hotel_tbl_user');
		$query1=$this->db->get();
		$result1 = $query1->result();
		foreach ($result1 as $key => $value) {
		$user_id[] = $value->id;
		}
		$implode = implode(",", $user_id);

		$data1 = array(
			        'hotel_id'          => $request['hotel_id'],
                    'agent_id'          => $request['agent_id'],
                    'booking_id'        => $request['id'],
			        'user_id'           => $implode,
                    'notification_date' => date('Y-m-d H:i:s'),
                    'notification_msg' => 'You have new booking approved Request',
		            'notification_type' => 'Approved your Request');

		$this->db->insert('hotel_tbl_notification',$data1);

		$datas1 = array('user_id' => $implode,
		        'notification_type' => 'hotel_booking_accept');

		$this->db->insert('hotel_tbl_notifications_list',$datas1);
        return $data;
	 }
	public function general_settings_select($id) {    
        $this->db->select('*');
        $this->db->from('hotel_tbl_hotels');
        $this->db->where('id',$id);
        //$this->db->order_by('id','desc');
        $query=$this->db->get();
        return $query->result();
    }
    public function currency(){
	    $this->db->select('*');
	    $this->db->from('currency_update');
	    $query=$this->db->get();
	    return $query->result();
	}
	public function currency_settings_select(){
		$this->db->select('*');
        $this->db->from('hotel_tbl_general_settings');
        $this->db->where('id',1);
        $this->db->order_by('id','desc');
        $query=$this->db->get();
        return $query->result();

	}
    public function booking_rejected_notification($id,$hotel_id,$agent_id) {
	    $data= array(
	              'hotel_id' => $hotel_id,
	              'agent_id' => $agent_id,
	              'booking_id' => $id,
	              'notification_msg' => 'You have new booking Rejected Request',
	              'notification_type' => 'Rejected Your booking Request',
	              'notification_date' => date('Y-m-d H:i:s'),
	              );
	    $this->db->insert('hotel_tbl_notification',$data);
	    return true;
	    }
    public function booking_details_portel_flag_off($id) {
	    $data= array(
	              'rejected' => 3,
	              );
	    $this->db->where('id',$id);
		$this->db->update('hotel_tbl_notification',$data);
	    return true;
	    } 
	public function all_hotel_contract() {
	    $this->db->select('*');
        $this->db->from('hotel_tbl_hotels');
        $this->db->where('delflg',1);
        $this->db->order_by('id','desc');
        $query=$this->db->get();
        return $query->result();
    }
    public function all_contract() {
	    $this->db->select('hotel_tbl_contract.*,hotel_tbl_hotels.hotel_name');
        $this->db->from('hotel_tbl_contract');
        $this->db->join('hotel_tbl_hotels','hotel_tbl_hotels.id=hotel_tbl_contract.hotel_id','join');
   		$this->db->where('to_date >',date('Y-m-d', strtotime('-1 days')));
        $this->db->order_by('hotel_tbl_hotels.hotel_name','asc');
        $this->db->group_by('hotel_id');
        $query=$this->db->get();
        return $query->result();
    }
    public function select_hotel_for_contract($id,$filter=NULL) {
	    $this->db->select('*');
        $this->db->from('hotel_tbl_contract');
        $this->db->where('hotel_id',$id);
        if ($filter==0) {
        	$this->db->where('to_date <',date('Y-m-d'));
        } else {
        	$this->db->where('to_date >',date('Y-m-d', strtotime('-1 days')));
        }
        $query=$this->db->get();
		return $query;
    }
    public function check_room(){
    	$this->db->select('*');
    	$this->db->from('hotel_tbl_hotel_room_type');
    	$this->db->join('hotel_tbl_hotels','hotel_tbl_hotels.id = hotel_tbl_hotel_room_type.hotel_id','left');
    	$this->db->where('hotel_tbl_hotel_room_type.delflg',1);
    	$this->db->where('hotel_tbl_hotels.delflg',1);
        $this->db->order_by('hotel_tbl_hotels.hotel_name','asc');
        $this->db->group_by('hotel_tbl_hotel_room_type.hotel_id');
    	$query=$this->db->get();
    	return $query->result();
    }
    public function get_contract_id(){
    	// $contract_explode='';
		$con_id=$this->db->insert_id();
		print_r($con_id);
		exit();

    	$this->db->select('contract_id');
    	$this->db->from('hotel_tbl_contract');
    	// $this->db->select_max('contract_id');
     	//    $this->db->from('hotel_tbl_contract');
	    //   $query=$this->db->get();
	    //   $data = $query->result();
	    //   $count=count($data);
	    //   for($i=0 ; $i<$count ; $i++){
    	// $contract_explode.=$data[$i]->contract_id;
	    //   }
	    //   $exp_con=explode('CON0',$contract_explode);
	    //   $array_count=count($exp_con);
	    //   for($i=0; i<$array_count; $i++){

      	//   }
        // $con_id =  $data[0]->contract_id;
    	// $contract_explode=explode('CON',$con_id);
        // if($con_id!=""){
        	// $cont_id=$contract_explode[1]+1;
	    //    	$contract_id='CON0'.$cont_id;
	    //    }
	    //    else{
	    //    	$contract_id="CON01";
    	// }
    	// print_r($contract_id);
    	// print_r($con_id);
    	print_r($exp_con);
    	exit();
        // return $contract_id;
    }
    public function add_contract($request){
    	$id=$request['id'];
		if ($request['contract_id']!="") {
	    	$this->db->select('*');
	    	$this->db->from('hotel_tbl_contract');
	    	$this->db->where('contract_id',$request['contract_id']);
	    	$output = $this->db->get()->result();
	    	$contract_flg = $output[0]->contract_flg;
    	} else {
    		$contract_flg = 0;
    	}
    	if ($request['contract_type']!="Sub") {
			$request['linked_contract'] = "";
    	} else {
			$request['linked_contract'] = $request['linked_contract'];
    	}
    	if (isset($request['nonRefundable'])) {
    		$nonRefundable = 1;
    	} else {
    		$nonRefundable = 0;
    	}
    	$nationality = '';
    	if (isset($request['nationality_to']) && count($request['nationality_to'])!=0) {
    		$nationality = implode(",", $request['nationality_to']);
    	}
    	$market = '';
    	if (isset($request['market']) && count($request['market'])!=0) {
    		$market = implode(",", $request['market']);
    	}
    	$array= array(	
			        	'tax_percentage' 	=> $request['tax'],
			        	'max_child_age' 	=> $request['max_age'],
			        	'from_date' 		=> $request['date_picker'],
			        	'to_date' 			=> $request['date_picker1'],
			        	// 'markup' 			=> $request['markup'],
			        	'contract_type' 	=> $request['contract_type'],
			        	'board' 			=> $request['board'],
			        	'hotel_id' 			=> $id,
			        	'contract_flg' 		=> 0,
			        	'contractName' 		=> $request['contract_name'],
			        	'linkedContract' 	=> $request['linked_contract'],
			        	'nonRefundable' 	=> $nonRefundable,
			        	'nationalityPermission' => $nationality,
			        	'market'			=> $market,
        				'BookingCode' => $request['BookingCode'],
			        	'Created_Date' => date("Y-m-d H:i:s"),
        				'Created_By' =>  $this->session->userdata('id'),
        				'contract_agreement' => $request['contract_agreement'],
        				'deactive' => isset($request['deactive']) ? 1 : 0,
						'deactiveDate' => isset($request['deactive']) ? $request['deactiveDate'] : '',
					);
		$this->db->insert('hotel_tbl_contract',$array);
		$con_id = $this->db->insert_id();
		
		if($con_id!=""){
        	$contract_id='CON0'.$con_id;
        }
        else{
        	$contract_id="CON01";
    	}
		$array = array(
    					'contract_id' => $contract_id,
    					'Updated_Date' => date("Y-m-d H:i:s"),
        				'Updated_By' =>  $this->session->userdata('id'),
					);
		$this->db->where('id', $con_id);
		$this->db->update('hotel_tbl_contract', $array);
		if ($request['contract_id']!="") {
			/*Alotement copy start*/
			$this->db->query("INSERT INTO hotel_tbl_allotement (room_id, hotel_id, allotement_date,amount,allotement,cut_off,contract_id) SELECT room_id, hotel_id, allotement_date,amount,allotement,cut_off,'".$contract_id."' FROM   hotel_tbl_allotement WHERE  contract_id = '".$request['contract_id']."' AND allotement_date BETWEEN  '".$_REQUEST['date_picker']."' AND '".$_REQUEST['date_picker1']."'");

			/*Alotement copy end*/
			/*Board Supplement copy start*/
			$this->db->query("INSERT INTO hotel_tbl_boardsupplement (board, roomType, season,fromDate,toDate,startAge,finalAge,amount,hotel_id,contract_id) SELECT board, roomType, season,fromDate,toDate,startAge,finalAge,amount,hotel_id,'".$contract_id."' FROM   hotel_tbl_boardsupplement WHERE  contract_id = '".$request['contract_id']."'");
			/*Board Supplement copy end*/
			/*General Supplement copy start*/
			$this->db->query("INSERT INTO hotel_tbl_generalsupplement (type, roomType, season,fromDate,toDate,adultAmount,childAmount,application,mandatory,hotel_id,contract_id) SELECT type, roomType, season,fromDate,toDate,adultAmount,childAmount,application,mandatory,hotel_id,'".$contract_id."' FROM   hotel_tbl_generalsupplement WHERE  contract_id = '".$request['contract_id']."'");
			/*General Supplement copy end*/
			/*Child policy copy start*/
			$this->db->query("INSERT INTO hotel_tbl_childpolicy (ageFrom, ageTo, roomType,discount,discountType,board,hotel_id,contract_id) SELECT ageFrom, ageTo, roomType,discount,discountType,board,hotel_id,'".$contract_id."' FROM   hotel_tbl_childpolicy WHERE  contract_id = '".$request['contract_id']."'");
			/*Child policy copy end*/
			/*Cancellation policy copy start*/
			$this->db->query("INSERT INTO hotel_tbl_cancellationfee (season, fromDate,toDate, roomType,daysInAdvance,cancellationPercentage,application,hotel_id,contract_id,daysFrom,daysTo) SELECT season, fromDate,toDate, roomType,daysInAdvance,cancellationPercentage,application,hotel_id,'".$contract_id."',daysFrom,daysTo FROM   hotel_tbl_cancellationfee WHERE  contract_id = '".$request['contract_id']."'");
			/*Cancellation policy copy end*/
			/*Minimum stay copy start*/
			$this->db->query("INSERT INTO hotel_tbl_minimumstay (season, fromDate,toDate, minDay,hotel_id,contract_id) SELECT season, fromDate,toDate, minDay,hotel_id,'".$contract_id."' FROM   hotel_tbl_minimumstay WHERE  contract_id = '".$request['contract_id']."'");
			/*Minimum stay copy end*/
			/*Closed out copy start*/
			$this->db->query("INSERT INTO hotel_tbl_closeout_period (from_date, to_date,reason, delflg,closedDate,hotel_id,contract_id) SELECT from_date, to_date,reason, delflg,closedDate,hotel_id,'".$contract_id."' FROM   hotel_tbl_closeout_period WHERE  contract_id = '".$request['contract_id']."' AND closedDate BETWEEN  '".$_REQUEST['date_picker']."' AND '".$_REQUEST['date_picker1']."'");
			/*Closed out copy end*/
			/*Policies copy start*/
			$this->db->query("INSERT INTO hotel_tbl_policies (Important_Remarks_Policies, Important_Notes_Conditions,cancelation_policy, Created_Date,Created_By,delflg,hotel_id,contract_id) SELECT Important_Remarks_Policies, Important_Notes_Conditions,cancelation_policy, '".date('d-m-Y')."','".$this->session->userdata('name')."',delflg,hotel_id,'".$contract_id."' FROM   hotel_tbl_policies WHERE  contract_id = '".$request['contract_id']."'");
			/*Policies copy end*/
			/*Season copy start*/
			$this->db->query("INSERT INTO hotel_tbl_season (FromDate, ToDate,SeasonName,hotel_id,contract_id) SELECT FromDate, ToDate,SeasonName,hotel_id,'".$contract_id."' FROM   hotel_tbl_season WHERE  contract_id = '".$request['contract_id']."'");
			/*Season copy end*/

			/*Extrabed copy start*/
			$this->db->query("INSERT INTO hotel_tbl_extrabed (roomType, season,from_date,to_date,ChildAmount,ChildAgeFrom,ChildAgeTo,amount,hotel_id,contract_id) SELECT  roomType, season,from_date,to_date,ChildAmount,ChildAgeFrom,ChildAgeTo,amount,hotel_id,'".$contract_id."' FROM   hotel_tbl_extrabed WHERE  contract_id = '".$request['contract_id']."'");
			/*Extrabed copy end*/
			/*Country permission copy start*/
			$this->db->query("INSERT INTO hotel_country_permission (permission, hotel_id,contract_id) SELECT permission, hotel_id,'".$contract_id."' FROM   hotel_country_permission WHERE  contract_id = '".$request['contract_id']."'");
			/*Country permission copy end*/
			/*agent permission copy start*/
			$this->db->query("INSERT INTO hotel_agent_permission (permission, hotel_id,contract_id) SELECT permission, hotel_id,'".$contract_id."' FROM   hotel_agent_permission WHERE  contract_id = '".$request['contract_id']."'");
			/*agent permission copy end*/
		}
		return $con_id;
    }
    public function contract_delete($id){
    	$this->db->where('contract_id', $id);
		$this->db->delete('hotel_tbl_contract');
    }
    public function get_room_id($hotel_id){
    	$this->db->distinct();
    	$this->db->select('room_id');
    	$this->db->from('hotel_tbl_allotement');
    	$this->db->where('hotel_id',$hotel_id);
    	$this->db->order_by('room_id', "asc");
    	$query=$this->db->get();
        return $query->result();
    }
    public function allotementBlkupdate($request) {
    	$this->db->select('*');
    	$this->db->from('hotel_tbl_contract');
    	$this->db->where('contract_id',$request['bulk_alt_contract_id']);
    	$contract_type = $this->db->get()->result();

    	$data =array();
		if (isset($request['other_season'])) {
			
			$start_date=date_create($request['bulk-alt-fromDate']);
	        $end_date=date_create($request['bulk-alt-toDate']);
	        $no_of_days=date_diff($start_date,$end_date);
	        $tot_days = $no_of_days->format("%a");
	        if (isset($request['bulk-alt-room_id'])) 
	        {
		        foreach ($request['bulk-alt-room_id'] as $key => $value) 
		        {	
	    			foreach ($_REQUEST['bulk-alt-days'] as $DayCKkey => $DayCKvalue) {
			        	for($i = 0; $i <= $tot_days; $i++) 
			        	{
		        			if ($DayCKvalue==date('D', strtotime($request['bulk-alt-fromDate']. ' + '.$i.'  days'))) {
						       
						       $result[$i]= date('Y-m-d', strtotime($request['bulk-alt-fromDate']. ' + '.$i.'  days'));
						      	$this->db->select('*');
						      	$this->db->from('hotel_tbl_allotement');
						    	$this->db->where('room_id',$value);
						    	$this->db->where('hotel_id',$request['hotel_id']);
						    	$this->db->where('allotement_date',$result[$i]);
						    	$this->db->where('contract_id',$request['bulk_alt_contract_id']);
						    	$query=$this->db->get();
					        	$query_out[$i] = $query->result();
					    		if (count($query_out[$i])!=0) 
					    		{
					    			if ($contract_type[0]->contract_type!="Main") 
					    			{
					    				if ($request['bulk-alt-amount']!="") 
					    				{
								    		$data['amount'] = backend_Aed_convertion(hotel_currency_type($request['hotel_id']),$request['bulk-alt-amount']);
								    		$data['allotement'] =  0;
								    		$data['cut_off'] =  0;
									    	$this->db->where('contract_id',$request['bulk_alt_contract_id']);
								    		$this->db->where('room_id',$value);
								    		$this->db->where('hotel_id',$request['hotel_id']);
								    		$this->db->where('allotement_date',$query_out[$i][0]->allotement_date);
								    		$this->db->update('hotel_tbl_allotement',$data);
								    		// Log entry start
								    		$dataLOG= array( 
												 'id'				=> $query_out[$i][0]->id,
												 'room_id' 	     	=> $value,
												 'hotel_id' 	 	=> $request['hotel_id'],
												 'allotement_date' 	=> $query_out[$i][0]->allotement_date,
												 'amount'			=> $data['amount'],
												 'allotement'		=> $data['allotement'],
												 'cut_off' 			=> $data['cut_off'],
												 'contract_id'		=> $request['bulk_alt_contract_id'],
												 'CreatedDate'  	=> date('Y-m-d H:i:s'),
								     			 'CreatedBy'     	=> $this->session->userdata('id'),
								     			 'Status'			=> 'updated'
												);
												$this->db->insert('hotel_tbl_allotement_log',$dataLOG);
								    		// Log entry end
								    	}
					    			} 
					    			else 
					    			{

						    			if ($request['bulk-alt-amount']!="") {
								    		$data['amount'] = backend_Aed_convertion(hotel_currency_type($request['hotel_id']),$request['bulk-alt-amount']);
								    	}
								    	if ($request['bulk-alt-allotment']!="") {
								    		$data['allotement'] =  $request['bulk-alt-allotment'];
								    	}
								    	if ($request['bulk-alt-cut-off']!="") {
								    		$data['cut_off'] =  $request['bulk-alt-cut-off'];
								    	}
							    		$data['contract_id'] =  $request['bulk_alt_contract_id'];
							    		
							    		$this->db->where('contract_id',$request['bulk_alt_contract_id']);
							    		$this->db->where('room_id',$value);
							    		$this->db->where('hotel_id',$request['hotel_id']);
							    		$this->db->where('allotement_date',$query_out[$i][0]->allotement_date);
							    		$this->db->update('hotel_tbl_allotement',$data);
							    		// Log entry start
								    	$dataLOG= array( 
												 'id'				=> $query_out[$i][0]->id,
												 'room_id' 	     	=> $value,
												 'hotel_id' 	 	=> $request['hotel_id'],
												 'allotement_date' 	=> $query_out[$i][0]->allotement_date,
												 'amount'			=> $data['amount'],
												 'allotement'		=> $data['allotement'],
												 'cut_off' 			=> $data['cut_off'],
												 'contract_id'		=> $request['bulk_alt_contract_id'],
												 'CreatedDate'  	=> date('Y-m-d H:i:s'),
								     			 'CreatedBy'     	=> $this->session->userdata('id'),
								     			 'Status'			=> 'updated'
												);
										$this->db->insert('hotel_tbl_allotement_log',$dataLOG);
								    	// Log entry end
					    			}
						    	} 
						    	else 
						    	{
					    			if ($contract_type[0]->contract_type!="Main") 
					    			{
					    				$data1 = array('amount'			=> backend_Aed_convertion(hotel_currency_type($request['hotel_id']),$request['bulk-alt-amount']),
							    					  'allotement'		=> 0,
							    					  'cut_off'			=> 0,
							    					  'allotement_date'	=> $result[$i],
							    					  'room_id'			=> $value,
							    					  'hotel_id'		=> $request['hotel_id'],
						    						  'contract_id' 	=> $request['bulk_alt_contract_id']
							    		);
							    		$this->db->insert('hotel_tbl_allotement',$data1);
							    		$id = $this->db->insert_id();
							    		// Log entry start
								    		$dataLOG= array( 
												 'id'				=> $id,
												 'room_id' 	     	=> $value,
												 'hotel_id' 	 	=> $request['hotel_id'],
												 'allotement_date' 	=> $result[$i],
												 'amount'			=> $data1['amount'],
												 'allotement'		=> 0,
												 'cut_off' 			=> 0,
												 'contract_id'		=> $request['bulk_alt_contract_id'],
												 'CreatedDate'  	=> date('Y-m-d H:i:s'),
								     			 'CreatedBy'     	=> $this->session->userdata('id'),
								     			 'Status'			=> 'inserted'
												);
										$this->db->insert('hotel_tbl_allotement_log',$dataLOG);
								    	// Log entry end
				    				} else 
				    				{
							    		$data1 = array('amount'		=> backend_Aed_convertion(hotel_currency_type($request['hotel_id']),$request['bulk-alt-amount']),
							    					  'allotement'	=> $request['bulk-alt-allotment'],
							    					  'cut_off'		=> $request['bulk-alt-cut-off'],
							    					  'allotement_date'=> $result[$i],
							    					  'room_id'=> $value,
							    					  'hotel_id'=> $request['hotel_id'],
						    						  'contract_id' => $request['bulk_alt_contract_id']
							    		);
							    		$this->db->insert('hotel_tbl_allotement',$data1);
							    		$id = $this->db->insert_id();
							    		// Log entry start
								    		$dataLOG= array( 
												 'id'				=> $id,
												 'room_id' 	     	=> $value,
												 'hotel_id' 	 	=> $request['hotel_id'],
												 'allotement_date' 	=> $result[$i],
												 'amount'			=> $data1['amount'],
												 'allotement'		=> $request['bulk-alt-allotment'],
												 'cut_off' 			=> $request['bulk-alt-cut-off'],
												 'contract_id'		=> $request['bulk_alt_contract_id'],
												 'CreatedDate'  	=> date('Y-m-d H:i:s'),
								     			 'CreatedBy'     	=> $this->session->userdata('id'),
								     			 'Status'			=> 'inserted'
												);
										$this->db->insert('hotel_tbl_allotement_log',$dataLOG);
								    	// Log entry end
						    		}
						    	}
						    }
	        			}
			    	}
		        }
	        }
	        $start1_date=date_create($request['bulk-alt-fromDate']);
	        $end1_date=date_create($request['bulk-alt-toDate']);
	        $no_of_days1=date_diff($start1_date,$end1_date);
	        $tot_days1 = $no_of_days1->format("%a");
	        foreach ($_REQUEST['bulk-alt-days'] as $DayCKkey => $DayCKvalue) {
		    	for($i = 0; $i <= $tot_days1; $i++) 
		    	{
	    			if ($DayCKvalue==date('D', strtotime($request['bulk-alt-fromDate']. ' + '.$i.'  days'))) {
			       		$result1[$i]= date('Y-m-d', strtotime($request['bulk-alt-fromDate']. ' + '.$i.'  days'));
	    			}
		        }
	        }
	        /* Closed condtion */
	        if (isset($request['Close'])) {
	        	foreach ($result1 as $key1 => $value1) {
	        		$this->db->select('*');
		        	$this->db->from('hotel_tbl_closeout_period');
					$this->db->where('closedDate',$value1);
					$this->db->where('hotel_id',$request['hotel_id']);
					$this->db->where('contract_id',$request['bulk_alt_contract_id']);
	      	  		$query1[$key1]=$this->db->get()->result();
	      	  		if (count($query1[$key1])!=0) {
						$explodeCoRR = explode(",", $query1[$key1][0]->roomType);
      	  				$arr_1 = array_merge($explodeCoRR,$request['bulk-alt-room_id']);
      	  				$implode_room_types = implode(",", array_unique($arr_1));
      	  				$data= array('roomType'      =>$implode_room_types,
							          'reason'       => "",
							        );
						$this->db->where('closedDate',$value1);
						$this->db->where('hotel_id',$request['hotel_id']);
						$this->db->where('contract_id',$request['bulk_alt_contract_id']);
						$this->db->update('hotel_tbl_closeout_period',$data);
						// Log entry start
                        $dataLOG= array( 
                                'hotel_id'   => $request['hotel_id'],
                                'contract_id' => $request['bulk_alt_contract_id'],
                                'closedDate'  => $value1,
                                'roomType'   => $implode_room_types,
                                'reason'     => "",                              
                                'CreatedBy' => $this->session->userdata('id'),
                                'CreatedDate' => date('Y-m-d H:i:s'),
                                'Status'     => 'close'
                        );
                        $this->db->insert('hotel_tbl_closeout_period_log',$dataLOG);
                        // Log entry end
					} else {
						$implode_room_types = implode(",", $request['bulk-alt-room_id']);
	      	  			$data= array( 'hotel_id'     => $request['hotel_id'],
							          'contract_id'  => $request['bulk_alt_contract_id'],
							          'closedDate'   => $value1,
							          'reason'       => "",
							          'roomType'     => $implode_room_types,
							          'delflg'       => 1,
							        );
						$this->db->insert('hotel_tbl_closeout_period',$data);
						$id = $this->db->insert_id();
						// Log entry start
                        $dataLOG= array( 
                                'id'        => $id,
                                'hotel_id'   => $request['hotel_id'],
                                'contract_id' => $request['bulk_alt_contract_id'],
                                'closedDate'  => $value1,
                                'roomType'   => $implode_room_types,
                                'reason'     => "",
                                'delflg'    => 1,
                                'CreatedBy' => $this->session->userdata('id'),
                                'CreatedDate' => date('Y-m-d H:i:s'),
                                'Status'     => 'close'
                        );
                        $this->db->insert('hotel_tbl_closeout_period_log',$dataLOG);
                        // Log entry end
					}
	        	}
        	}


        	/* Open condtion */
	        if (isset($request['Open'])) {
	        	foreach ($result1 as $key1 => $value1) {
    				$this->db->select('roomType');
		        	$this->db->from('hotel_tbl_closeout_period');
					$this->db->where('closedDate',$value1);
					$this->db->where('hotel_id',$request['hotel_id']);
					$this->db->where('contract_id',$request['bulk_alt_contract_id']);
					$query1[$key1]=$this->db->get()->result();
					if (count($query1[$key1])!=0) {
						$explodeCoRR = explode(",", $query1[$key1][0]->roomType);
      	  				$arr_1 = array_diff($explodeCoRR,$request['bulk-alt-room_id']);
      	  				if (count($arr_1)!=0) {
      	  					$implode_room_types = implode(",", $arr_1);
	      	  				$data= array('roomType'   	 => $implode_room_types,
							          'reason'     	 => "",
						        );
							$this->db->where('closedDate',$value1);
							$this->db->where('hotel_id',$request['hotel_id']);
							$this->db->where('contract_id',$request['bulk_alt_contract_id']);
							$this->db->update('hotel_tbl_closeout_period',$data);
							// Log entry start
                            $dataLOG= array( 
                                    'hotel_id'   => $request['hotel_id'],
                                    'contract_id' => $request['bulk_alt_contract_id'],
                                    'closedDate'  => $value1,
                                    'roomType'   => $implode_room_types,
                                    'reason'     => "",
                                    'CreatedBy' => $this->session->userdata('id'),
                                    'CreatedDate' => date('Y-m-d H:i:s'),
                                    'Status'     => 'open'
                            );
                            $this->db->insert('hotel_tbl_closeout_period_log',$dataLOG);
                            // Log entry end
      	  				} else {
		  	  				$this->db->where('closedDate',$value1);
							$this->db->where('hotel_id',$request['hotel_id']);
							$this->db->where('contract_id',$request['bulk_alt_contract_id']);
							$this->db->delete('hotel_tbl_closeout_period');
							// Log entry start
                            $dataLOG= array( 
                                    'hotel_id'   => $request['hotel_id'],
                                    'contract_id' => $request['bulk_alt_contract_id'],
                                    'closedDate'  => $value1,
                                    'roomType'   => $implode_room_types,
                                    'reason'     => "",
                                    'CreatedBy' => $this->session->userdata('id'),
                                    'CreatedDate' => date('Y-m-d H:i:s'),
                                    'Status'     => 'open'
                            );
                            $this->db->insert('hotel_tbl_closeout_period_log',$dataLOG);
                            // Log entry end
      	  				}
					}
				}
        	}

		} 
		// else {

	 //    	foreach ($request['bulk-alt-season'] as $reqkey => $reqvalue) {
	 //    		$this->db->select('*');
	 //    		$this->db->from('hotel_tbl_season');
	 //    		$this->db->where('contract_id',$request['bulk_alt_contract_id']);
	 //    		$this->db->where('hotel_id',$request['hotel_id']);
	 //    		$this->db->where('id',$request['bulk-alt-season'][$reqkey]);
	 //    		$result_data = $this->db->get()->result();
	    		
		//     	$start_date=date_create($result_data[0]->FromDate);
		//         $end_date=date_create($result_data[0]->ToDate);
		//         $no_of_days=date_diff($start_date,$end_date);
		//         $tot_days = $no_of_days->format("%a");
		//         if (isset($request['bulk-alt-room_id'])) {
		// 	        foreach ($request['bulk-alt-room_id'] as $key => $value) {	
		// 	        	foreach ($_REQUEST['bulk-alt-days'] as $DayCKkey => $DayCKvalue) {
		// 		        	for($i = 0; $i <= $tot_days; $i++) {
		// 		        		if ($DayCKvalue==date('D', strtotime($result_data[0]->FromDate. ' + '.$i.'  days'))) {
				        			
		// 					       $result[$i]= date('Y-m-d', strtotime($result_data[0]->FromDate. ' + '.$i.'  days'));
		// 					      	$this->db->select('*');
		// 					      	$this->db->from('hotel_tbl_allotement');
		// 					    	$this->db->where('room_id',$value);
		// 					    	$this->db->where('hotel_id',$request['hotel_id']);
		// 					    	$this->db->where('allotement_date',$result[$i]);
		// 					    	$this->db->where('contract_id',$request['bulk_alt_contract_id']);
		// 					    	$query=$this->db->get();
		// 				        	$query_out[$i] = $query->result();
		// 				    		if (count($query_out[$i])!=0) {
		// 				    			if ($contract_type[0]->contract_type!="Main") {
		// 				    				if ($request['bulk-alt-amount']!="") {
		// 							    		$data['amount'] = backend_Aed_convertion(hotel_currency_type($request['hotel_id']),$request['bulk-alt-amount']);
		// 							    		$data['allotement'] =  0;
		// 							    		$data['cut_off'] =  0;
		// 								    	$this->db->where('contract_id',$request['bulk_alt_contract_id']);
		// 							    		$this->db->where('room_id',$value);
		// 							    		$this->db->where('hotel_id',$request['hotel_id']);
		// 							    		$this->db->where('allotement_date',$query_out[$i][0]->allotement_date);
		// 							    		$this->db->update('hotel_tbl_allotement',$data);
		// 							    	}
		// 				    			} else {

		// 					    			if ($request['bulk-alt-amount']!="") {
		// 							    		$data['amount'] = backend_Aed_convertion(hotel_currency_type($request['hotel_id']),$request['bulk-alt-amount']);
		// 							    	}
		// 							    	if ($request['bulk-alt-allotment']!="") {
		// 							    		$data['allotement'] =  $request['bulk-alt-allotment'];
		// 							    	}
		// 							    	if ($request['bulk-alt-cut-off']!="") {
		// 							    		$data['cut_off'] =  $request['bulk-alt-cut-off'];
		// 							    	}
		// 							    	if ($request['bulk-alt-amount']!="" || $request['bulk-alt-allotment']!="" || $request['bulk-alt-cut-off']!="") {
		// 							    		$this->db->where('contract_id',$request['bulk_alt_contract_id']);
		// 							    		$this->db->where('room_id',$value);
		// 							    		$this->db->where('hotel_id',$request['hotel_id']);
		// 							    		$this->db->where('allotement_date',$query_out[$i][0]->allotement_date);
		// 							    		$this->db->update('hotel_tbl_allotement',$data);
		// 							    	}
		// 				    			}
		// 					    	} else {
		// 				    			if ($contract_type[0]->contract_type!="Main") {
		// 				    				$data1 = array('amount'    => backend_Aed_convertion(hotel_currency_type($request['hotel_id']),$request['bulk-alt-amount']),
		// 						    					  'allotement' => 0,
		// 						    					  'cut_off'    => 0,
		// 						    					  'allotement_date'=> $result[$i],
		// 						    					  'room_id'=> $value,
		// 						    					  'hotel_id'=> $request['hotel_id'],
		// 					    						  'contract_id' => $request['bulk_alt_contract_id']
		// 						    		);
		// 						    		$this->db->insert('hotel_tbl_allotement',$data1);
		// 			    				} else {
		// 						    		$data1 = array('amount'=> backend_Aed_convertion(hotel_currency_type($request['hotel_id']),$request['bulk-alt-amount']),
		// 						    					  'allotement'=> $request['bulk-alt-allotment'],
		// 						    					  'cut_off'=> $request['bulk-alt-cut-off'],
		// 						    					  'allotement_date'=> $result[$i],
		// 						    					  'room_id'=> $value,
		// 						    					  'hotel_id'=> $request['hotel_id'],
		// 					    						  'contract_id' => $request['bulk_alt_contract_id']
		// 						    		);
		// 						    		$this->db->insert('hotel_tbl_allotement',$data1);
		// 					    		}
		// 					    	}
		// 					    }
		// 				    }
		// 			    }
		// 	        }
		//         }

		//         $start1_date=date_create($result_data[0]->FromDate);
		//         $end1_date=date_create($result_data[0]->ToDate);
		//         $no_of_days1=date_diff($start1_date,$end1_date);
		//         $tot_days1 = $no_of_days1->format("%a");
		//         foreach ($_REQUEST['bulk-alt-days'] as $DayCKkey => $DayCKvalue) {
		// 	    	for($i = 0; $i <= $tot_days1; $i++) {
		// 	    		if ($DayCKvalue==date('D', strtotime($result_data[0]->FromDate. ' + '.$i.'  days'))) {
		// 		       		$result1[$i]= date('Y-m-d', strtotime($result_data[0]->FromDate. ' + '.$i.'  days'));
		// 	    		}
		// 	        }
		//         }

		//         /* Closed condtion */
	 //    		if (isset($request['Close'])) {
	 //    			foreach ($result1 as $key1 => $value1) {
	 //    				$this->db->select('roomType');
		// 	        	$this->db->from('hotel_tbl_closeout_period');
		// 				$this->db->where('closedDate',$value1);
		// 				$this->db->where('hotel_id',$request['hotel_id']);
		// 				$this->db->where('contract_id',$request['bulk_alt_contract_id']);
		// 				$query1[$key1]=$this->db->get()->result();
		// 				if (count($query1[$key1])!=0) {
		// 					$explodeCoRR = explode(",", $query1[$key1][0]->roomType);
	 //      	  				$arr_1 = array_merge($explodeCoRR,$request['bulk-alt-room_id']);
	 //      	  				$implode_room_types = implode(",", array_unique($arr_1));
	 //      	  				$data= array('roomType'      =>$implode_room_types,
		// 						          'reason'       => "",
		// 						        );
		// 					$this->db->where('closedDate',$value1);
		// 					$this->db->where('hotel_id',$request['hotel_id']);
		// 					$this->db->where('contract_id',$request['bulk_alt_contract_id']);
		// 					$this->db->update('hotel_tbl_closeout_period',$data);
		// 				} else {
		// 					$implode_room_types = implode(",", $request['bulk-alt-room_id']);
		//       	  			$data= array( 'hotel_id'     => $request['hotel_id'],
		// 						          'contract_id'  => $request['bulk_alt_contract_id'],
		// 						          'closedDate'   => $value1,
		// 						          'reason'       => "",
		// 						          'roomType'     => $implode_room_types,
		// 						          'delflg'       => 1,
		// 						        );
		// 					$this->db->insert('hotel_tbl_closeout_period',$data);
		// 				}
  //   				}
	 //    		}

	 //    		/* Open condtion */

	 //    		if (isset($request['Open'])) {
	 //    			foreach ($result1 as $key1 => $value1) {
	 //    				$this->db->select('roomType');
		// 	        	$this->db->from('hotel_tbl_closeout_period');
		// 				$this->db->where('closedDate',$value1);
		// 				$this->db->where('hotel_id',$request['hotel_id']);
		// 				$this->db->where('contract_id',$request['bulk_alt_contract_id']);
		// 				$query1[$key1]=$this->db->get()->result();
		// 				if (count($query1[$key1])!=0) {
		// 					$explodeCoRR = explode(",", $query1[$key1][0]->roomType);
	 //      	  				$arr_1 = array_diff($explodeCoRR,$request['bulk-alt-room_id']);
	 //      	  				if (count($arr_1)!=0) {
	 //      	  					$implode_room_types = implode(",", $arr_1);
		//       	  				$data= array('roomType'   	 => $implode_room_types,
		// 						          'reason'     	 => "",
		// 					        );
		// 						$this->db->where('closedDate',$value1);
		// 						$this->db->where('hotel_id',$request['hotel_id']);
		// 						$this->db->where('contract_id',$request['bulk_alt_contract_id']);
		// 						$this->db->update('hotel_tbl_closeout_period',$data);
	 //      	  				} else {
		// 	  	  				$this->db->where('closedDate',$value1);
		// 						$this->db->where('hotel_id',$request['hotel_id']);
		// 						$this->db->where('contract_id',$request['bulk_alt_contract_id']);
		// 						$this->db->delete('hotel_tbl_closeout_period');
	 //      	  				}
		// 				}
  //   				}
	 //    		}
	 //    	}
	 //    }

    return true;
    }
    public function allotBlkupdate($request) {
    	$start_date=date_create($request['bulk-alt-fromDate']);
        $end_date=date_create($request['bulk-alt-toDate']);
        $no_of_days=date_diff($start_date,$end_date);
        $tot_days = $no_of_days->format("%a");
        if (isset($request['bulk-alt-con-id'])) {
        	foreach ($request['bulk-alt-con-id'] as $key4 => $value4) {
        		// print_r($value4);
        		// exit();
		        if (isset($request['bulk-alt-room_id'])) {
		        	// print_r($request['bulk-alt-con-id']);
		        	// exit();
			        foreach ($request['bulk-alt-room_id'] as $key => $value) {
			        	for($i = 0; $i <= $tot_days; $i++) {
					       $result[$i]= date('Y-m-d', strtotime($request['bulk-alt-fromDate']. ' + '.$i.'  days'));
					      	$this->db->select('*');
					      	$this->db->from('hotel_tbl_allotement');
					    	$this->db->where('room_id',$value);
					    	$this->db->where('hotel_id',$request['hotel_id']);
					    	$this->db->where('allotement_date',$result[$i]);
					    	$this->db->where('contract_id',$value4);
					    	$query=$this->db->get();
				        	$query_out[$i] = $query->result();
				    		if (count($query_out[$i])!=0) {
						    	if ($request['bulk-alt-allotment']!="") {
						    		$data['allotement'] =  $request['bulk-alt-allotment'];
						    	}
						    	if ($request['bulk-alt-cut-off']!="") {
						    		$data['cut_off'] =  $request['bulk-alt-cut-off'];
						    	}
						    	if ($request['bulk-alt-allotment']!="" || $request['bulk-alt-cut-off']!="") {
						    		$this->db->where('contract_id',$value4);
						    		$this->db->where('room_id',$value);
						    		$this->db->where('hotel_id',$request['hotel_id']);
						    		$this->db->where('allotement_date',$query_out[$i][0]->allotement_date);
						    		$this->db->update('hotel_tbl_allotement',$data);
						    	}
					    	} else {
					    		$data1 = array(
					    					  'allotement'     => $request['bulk-alt-allotment'],
					    					  'cut_off'        => $request['bulk-alt-cut-off'],
					    					  'allotement_date'=> $result[$i],
					    					  'room_id'        => $value,
					    					  'hotel_id'       => $request['hotel_id'],
				    						  'contract_id'    => $value4
					    		);
					    		$this->db->insert('hotel_tbl_allotement',$data1);
					    	}
					    }
			        }
		        }
		    }
	    }
        $start1_date=date_create($request['bulk-alt-fromDate']);
	        $end1_date=date_create($request['bulk-alt-toDate']);
	        $no_of_days1=date_diff($start_date,$end_date);
	        $tot_days1 = $no_of_days1->format("%a");
        	for($i = 0; $i <= $tot_days1; $i++) {
		       $result1[$i]= date('Y-m-d', strtotime($request['bulk-alt-fromDate']. ' + '.$i.'  days'));
	        }
	    if(isset($request['bulk-alt-con-id'])){
	    	foreach ($request['bulk-alt-con-id'] as $key2 => $value2) {
	    		/* Closed condtion */
	    		if (isset($request['Close'])) {
	    			foreach ($result1 as $key1 => $value1) {
	    				$this->db->select('roomType');
			        	$this->db->from('hotel_tbl_closeout_period');
						$this->db->where('closedDate',$value1);
						$this->db->where('hotel_id',$request['hotel_id']);
						$this->db->where('contract_id',$value2);
						$query1[$key1]=$this->db->get()->result();
						if (count($query1[$key1])!=0) {
							$explodeCoRR = explode(",", $query1[$key1][0]->roomType);
	      	  				$arr_1 = array_merge($explodeCoRR,$request['bulk-alt-room_id']);
	      	  				$implode_room_types = implode(",", array_unique($arr_1));
	      	  				$data= array('roomType'      =>$implode_room_types,
								          'reason'       => "",
								        );
							$this->db->where('closedDate',$value1);
							$this->db->where('hotel_id',$request['hotel_id']);
							$this->db->where('contract_id',$value2);
							$this->db->update('hotel_tbl_closeout_period',$data);
						} else {
							$implode_room_types = implode(",", $request['bulk-alt-room_id']);
		      	  			$data= array( 'hotel_id'     => $request['hotel_id'],
								          'contract_id'  => $value2,
								          'closedDate'   => $value1,
								          'reason'       => "",
								          'roomType'     => $implode_room_types,
								          'delflg'       => 1,
								        );
							$this->db->insert('hotel_tbl_closeout_period',$data);
						}
    				}
	    		}
	    		/* Open condtion */

	    		if (isset($request['Open'])) {
	    			foreach ($result1 as $key1 => $value1) {
	    				$this->db->select('roomType');
			        	$this->db->from('hotel_tbl_closeout_period');
						$this->db->where('closedDate',$value1);
						$this->db->where('hotel_id',$request['hotel_id']);
						$this->db->where('contract_id',$value2);
						$query1[$key1]=$this->db->get()->result();
						if (count($query1[$key1])!=0) {
							$explodeCoRR = explode(",", $query1[$key1][0]->roomType);
	      	  				$arr_1 = array_diff($explodeCoRR,$request['bulk-alt-room_id']);
	      	  				if (count($arr_1)!=0) {
	      	  					$implode_room_types = implode(",", $arr_1);
		      	  				$data= array('roomType'   	 => $implode_room_types,
								          'reason'     	 => "",
							        );
								$this->db->where('closedDate',$value1);
								$this->db->where('hotel_id',$request['hotel_id']);
								$this->db->where('contract_id',$value2);
								$this->db->update('hotel_tbl_closeout_period',$data);
	      	  				} else {
			  	  				$this->db->where('closedDate',$value1);
								$this->db->where('hotel_id',$request['hotel_id']);
								$this->db->where('contract_id',$value2);
								$this->db->delete('hotel_tbl_closeout_period');
	      	  				}
						}
    				}
	    		}
			}
		}
    return true;
    }
    public function contractdetails($contract_id)
    {
    	$this->db->select('*');
        $this->db->from('hotel_tbl_contract');
        $this->db->where('contract_id',$contract_id);
        $query=$this->db->get();
        return $query->result();
    }
    public function update_contract($request) {
    	if ($request['contract_type']!="Sub") {
			$request['linked_contract'] = "";
    	} else {
			$request['linked_contract'] = $request['linked_contract'];
    	}
    	if (isset($request['nonRefundable'])) {
    		$nonRefundable = 1;
    	} else {
    		$nonRefundable = 0;
    	}
    	$nationality = '';
    	if (isset($request['nationality_to']) && count($request['nationality_to'])!=0) {
    		$nationality = implode(",", $request['nationality_to']);
    	}
    	$market = '';
    	if (isset($request['market']) && count($request['market'])!=0) {
    		$market = implode(",", $request['market']);
    	}
    	
		$array= array(	
        	'tax_percentage'  => $request['tax'],
        	'max_child_age'   => $request['max_age'],
        	'from_date'       => $request['date_picker'],
        	'to_date'         => $request['date_picker1'],
        	// 'markup'          => $request['markup'],
        	'contract_type'   => $request['contract_type'],
        	'board'           => $request['board'],
        	'contractName'    => $request['contract_name'],
        	'linkedContract'  => $request['linked_contract'],
        	'nonRefundable'   => $nonRefundable,
        	'nationalityPermission' => $nationality,
        	'market'			=> $market,
        	'BookingCode' => $request['BookingCode'],
        	'Updated_Date' => date("Y-m-d H:i:s"),
			'Updated_By' =>  $this->session->userdata('id'),
			'contract_agreement' => $request['contract_agreement'],
			'deactive' => isset($request['deactive']) ? 1 : 0,
			'deactiveDate' => isset($request['deactive']) ? $request['deactiveDate'] : '',
		);
        $this->db->where('contract_id',$request['contract_id']);
        $this->db->where('hotel_id',$request['id']);
		$this->db->update('hotel_tbl_contract',$array);
		return true;
    }
    public function delete_contract($id)
	{
		$this->db->where('contract_id',$id);
		$this->db->delete('hotel_tbl_contract');

		$this->db->where('contract_id', $id);
		$this->db->delete('hotel_tbl_boardsupplement');

		$this->db->where('contract_id',$id);
		$this->db->delete('hotel_tbl_childpolicy');

		$this->db->where('contracts',$id);
		$this->db->delete('hotels_tbl_stopsale');

		$this->db->where('contract_id',$id);
		$this->db->delete('hotel_tbl_policies');

		$this->db->where('contract_id',$id);
		$this->db->delete('hotel_tbl_cancellationfee');

		$this->db->where('contract_id',$id);
		$this->db->delete('hotel_tbl_minimumstay');

		$this->db->where('contract_id',$id);
		$this->db->delete('hotel_tbl_allotement');

		$this->db->where('contract_id',$id);
		$this->db->delete('hotel_country_permission');

		$this->db->where('contract_id',$id);
		$this->db->delete('hotel_agent_permission');

		return true;
	}
	public function get_policy($request) {
		$this->db->select('*');
        $this->db->from('hotel_tbl_policies');
        $this->db->where('contract_id',$request['con_id']);
        $this->db->where('hotel_id',$request['hotel_id']);
        $query=$this->db->get();
        return $query->result();
	}
	public function get_policy_new($hotel_id,$contract_id) {
		$this->db->select('*');
        $this->db->from('hotel_tbl_policies');
        $this->db->where('contract_id',$contract_id);
        $this->db->where('hotel_id',$hotel_id);
        $query=$this->db->get();
        return $query->result();
	}
	public function get_policy_id($request){
		$this->db->select('*');
        $this->db->from('hotel_tbl_policies');
        $this->db->where('contract_id',$request['id']);
        $this->db->where('hotel_id',$request['hotel_id']);
        $query=$this->db->get();
        return $query->result();
	}
	public function delete_policies($id) {
		$this->db->where('contract_id',$id);
		$this->db->delete('hotel_tbl_policies');
		return true;
	}
	public function hotel_contract_list($hotel_id) {
		$this->db->select('*');
        $this->db->from('hotel_tbl_contract');
        $this->db->where('hotel_id',$hotel_id);
        $this->db->where('to_date >',date('Y-m-d', strtotime('-1 days')));
        $this->db->group_by('contract_id');
        $query=$this->db->get();
        return $query->result();
	}
	public function edit_permission_check($hotel_id) {
		$this->db->select('edit_rate');
        $this->db->from('hotel_tbl_hotels');
        $this->db->where('id',$hotel_id);
        $query=$this->db->get();
        return $query->result();
	}
	public function contract_end_detail($contract_id) {
		$this->db->select('*');
        $this->db->from('hotel_tbl_contract');
        $this->db->where('contract_id',$contract_id);
        $query=$this->db->get();
        return $query->result();
	}
	public function contract_hotel_list() {
		$this->db->select('*');
        $this->db->from('hotel_tbl_contract');
        $this->db->join('hotel_tbl_hotels','hotel_tbl_hotels.id = hotel_tbl_contract.hotel_id','left');
        $this->db->order_by('hotel_tbl_hotels.hotel_name','asc');
        $this->db->group_by('hotel_tbl_contract.hotel_id');
        $query=$this->db->get();
        return $query->result();
	}
	public function Country_list() {
		$this->db->select('*');
        $this->db->from('country_tbl');
        $query=$this->db->get();
        return $query->result();
	}
	public function country_permission_update($id,$country_id,$contract_id)
	{
		$this->db->select('*');
        $this->db->from('hotel_country_permission');
        $this->db->where('hotel_id',$id);
        $this->db->where('contract_id',$contract_id);
        $query=$this->db->get();
        $final = $query->result();
        if(count($final) != 0 ){
			$data= array(
						 'permission' 	  => $country_id,
						);

			$this->db->where('hotel_id',$id);
			$this->db->where('contract_id',$contract_id);
			$this->db->update('hotel_country_permission',$data);						 
		}
		else {
		  $data1= array( 
						 'hotel_id' 	  => $id,
						 'permission' 	  => $country_id,
						 'contract_id' 	  => $contract_id,
	        			);
			$this->db->insert('hotel_country_permission',$data1);
		}
		return true;
	}
	public function permission_Country_list($hotel_id,$contract_id) {
        $this->db->select('*');
        $this->db->from('hotel_country_permission');
       	$this->db->where('hotel_id',$hotel_id);
       	$this->db->where('contract_id',$contract_id);
      	$query=$this->db->get();
		return $query->result();
    }
    public function stopSale_get_room_type($id) {
        $this->db->select('hotel_tbl_hotel_room_type.*,hotel_tbl_room_type.Room_Type');
        $this->db->from('hotel_tbl_hotel_room_type');
		$this->db->join('hotel_tbl_room_type', 'hotel_tbl_room_type.id = hotel_tbl_hotel_room_type.room_type', 'left');
        $this->db->where('hotel_tbl_hotel_room_type.delflg',1);
        $this->db->where('hotel_tbl_hotel_room_type.hotel_id',$id);
        // $this->db->group_by('hotel_tbl_room_type.room_type');
        $query=$this->db->get();
        return $query->result();
    }
    public function stopsaleSubmit($request) {
    	$implode_contracts = "";
    	if (isset($request['contract'])) {
    		$implode_contracts = implode(",", $request['contract']);
    	}
    	$implode_room_types = "";
    	if (isset($request['room_types'])) {
    		$implode_room_types = implode(",", $request['room_types']);
    	}
    	if (isset($request['id'])) {
    		$data= array( 
					 'from_date' 	  => $request['from_date'],
					 'to_date' 	  	  => $request['to_date'],
					 'contracts' 	  => $implode_contracts,
					 'room_types' 	  => $implode_room_types,
					 'updatedDate' 	  => date('d/m/Y'),
					 'updatedBy' 	  => $this->session->userdata('name'),
	    			);
    		$this->db->where('id',$request['id']);
			$this->db->update('hotels_tbl_stopSale',$data);
    	} else {
    		$data= array( 
					 'hotel_id' 	  => $request['hotel_id'],
					 'from_date' 	  => $request['from_date'],
					 'to_date' 	      => $request['to_date'],
					 'contracts' 	  => $implode_contracts,
					 'room_types' 	  => $implode_room_types,
					 'createdDate' 	  => date('d/m/Y'),
					 'createdBy' 	  => $this->session->userdata('name'),
	    			);
			$this->db->insert('hotels_tbl_stopSale',$data);
    	}
    	return true;
    	
    }
    public function select_hotel_for_stopSale($hotel_id) {
    	$this->db->select('*');
        $this->db->from('hotels_tbl_stopSale');
        $this->db->where('hotel_id',$hotel_id);
        $query=$this->db->get();
        return $query;
    }
    public function delete_StopSale($id) {
    	$this->db->where('id',$id);
		$this->db->delete('hotels_tbl_stopSale');
		return true;
    }
    public function stopSale_detail($id) {
    	$this->db->select('*');
        $this->db->from('hotels_tbl_stopSale');
        $this->db->where('id',$id);
        $query=$this->db->get();
        return $query->result();
    }
    public function select_childPolicy($hotel_id,$con_id) {
    	$this->db->select('*');
        $this->db->from('hotel_tbl_childpolicy');
        $this->db->where('hotel_id',$hotel_id);
        $this->db->where('contract_id',$con_id);
        return $query=$this->db->get();
    }
    public function childPolicySubmit($request) {
    	$countResult =array();
    	$implode_room_types = "";
    	if (isset($request['room_type'])) {
    		$implode_room_types = implode(",", $request['room_type']);
    	}
   //  	if (isset($request['id']) && $request['id']!="") {
   //  		$data1= array( 
			// 			 'ageFrom' 	  => $request['age_from'],
			// 			 'ageTo' 	  => $request['age_to'],
			// 			 'roomType' 	  => $implode_room_types,
			// 			 'discount' 	  => $request['discount'],
			// 			 'board' 	  => $request['board'],
			// 			 'discountType' 	  => $request['discountType'],
		 //    			);
			// $this->db->where('id',$request['id']);
			// $this->db->update('hotel_tbl_childpolicy',$data1);
			// $msg = true;
   //  	} else {
    		for ($i=$request['age_from']; $i <= $request['age_to']; $i++) { 
    			if ($request['id']!="") {
	    			$this->db->select('*');
		    		$this->db->from('hotel_tbl_childpolicy');
		    		$this->db->where('hotel_id',$request['hotel_id']);
		    		$this->db->where('contract_id',$request['contract_id']);
		    		$this->db->where('board',$request['board']);
		    		$this->db->where('id !=',$request['id']);
		            $where = "'".$i."' BETWEEN ageFrom AND ageTo";
	    			$this->db->where($where);
	    			$result[$i] = $this->db->get()->result();
	    			if (count($result[$i])!=0) {
	    				$countResult[] = $i;
	    			}
    			} else {
    				$this->db->select('*');
		    		$this->db->from('hotel_tbl_childpolicy');
		    		$this->db->where('hotel_id',$request['hotel_id']);
		    		$this->db->where('contract_id',$request['contract_id']);
		    		$this->db->where('board',$request['board']);
		            $where = "'".$i."' BETWEEN ageFrom AND ageTo";
	    			$this->db->where($where);
	    			$result[$i] = $this->db->get()->result();
	    			if (count($result[$i])!=0) {
	    				$countResult[] = $i;
	    			}
    			}
    		}
    		$count = implode(", ", $countResult);
    		if ($count!="") {
    			$msg = "This (".$count.") ages are already exist !";
    		} else {
    			if ($request['id']!="") {
    				$data1= array( 
								 'ageFrom' 	      => $request['age_from'],
								 'ageTo' 	      => $request['age_to'],
								 'roomType' 	  => $implode_room_types,
								 'discount' 	  => $request['discount'],
								 'board' 	      => $request['board'],
								 'discountType'   => $request['discountType'],
				    			);
					$this->db->where('id',$request['id']);
					$this->db->update('hotel_tbl_childpolicy',$data1);
    			} else {
	    			$data= array( 
							 'ageFrom' 	    => $request['age_from'],
							 'ageTo' 	    => $request['age_to'],
							 'roomType' 	=> $implode_room_types,
							 'discount' 	=> $request['discount'],
							 'board' 	    => $request['board'],
							 'hotel_id' 	=> $request['hotel_id'],
							 'contract_id' 	=> $request['contract_id'],
							 'discountType' => $request['discountType'],
			    			);
					$this->db->insert('hotel_tbl_childpolicy',$data);
    			}
				$msg = true;
    		}
	    	
    	// }
		return $msg;
    }
    public function ChildPolicy_delete($id)	{
		$this->db->where('id',$id);
		$this->db->delete('hotel_tbl_childpolicy');
		return true;
	}
	public function ChildPolicy_details($id) {
		$this->db->select('*');
        $this->db->from('hotel_tbl_childpolicy');
        $this->db->where('id',$id);
        return $query=$this->db->get()->result();
	}
	public function seasonList($hotel_id,$contract_id) {
		$this->db->select('*');
        $this->db->from('hotel_tbl_season');
        $this->db->where('hotel_id',$hotel_id);
        $this->db->where('contract_id',$contract_id);
        return $query=$this->db->get();
	}
	public function get_extrabed($id) {
		$this->db->select('*');
        $this->db->from('hotel_tbl_extrabed');
        $this->db->where('id',$id);
        return $query=$this->db->get()->result();
	}
	public function SeasonSubmit($request) {
		if (isset($request['season_id']) && $request['season_id']!="") {
			if(isset($request['update_terms']) && $request['update_terms']=="on") {
				$checked_date =array();
				$start_date=date_create($request['fromDate']);
				$end_date=date_create($request['toDate']);
				$no_of_days=date_diff($start_date,$end_date);
				$tot_days = $no_of_days->format("%a");
				if ($request['fromDate'] > $request['toDate']) {
					$msg = 'To date should greater than From date !';
				} else {
					for($i = 0; $i <= $tot_days; $i++) {
			       		$result[1+$i]['date'] = date('Y-m-d', strtotime($request['fromDate']. ' + '.$i.'  days'));
				       	$this->db->select('*');
				        $this->db->from('hotel_tbl_season');
			            $where = "'".$result[1+$i]['date']."' BETWEEN FromDate AND ToDate";
				        $this->db->where($where);
				        $this->db->where('contract_id',$request['contract_id']);
				        $this->db->where('hotel_id',$request['hotel_id']);
				        $query[$result[1+$i]['date']]=$this->db->get()->result();
				        if (count($query[$result[1+$i]['date']])) {
				        	$checked_date[] = date('d-m-Y',strtotime($result[1+$i]['date']));
				        } 
			    	}
			    	if (count($checked_date)!="") {
			    		$msg = 'These ('.implode(", ", $checked_date).') days are already Exist !';
			    	} else {
		    		   	$data= array( 
						 'FromDate' 	  => $request['fromDate'],
						 'ToDate' 	      => $request['toDate'],
						 'SeasonName' 	  => $request['SeasonName'],
						 'hotel_id' 	  => $request['hotel_id'],
		 				 'contract_id' 	  => $request['contract_id'],
		    			);
		    			$this->db->where('id',$request['season_id']);
						$this->db->update('hotel_tbl_season',$data);
		    		    $data1 = array( 
						 'fromDate' 	  => $request['fromDate'],
						 'toDate' 	      => $request['toDate'],
						);
						$this->db->where(array('season'=>$request['season_id'],'contract_id'=>$request['contract_id'],'hotel_id'=>$request['hotel_id']));
						$this->db->update('hotel_tbl_boardsupplement',$data1);
						$this->db->where(array('season'=>$request['season_id'],'contract_id'=>$request['contract_id'],'hotel_id'=>$request['hotel_id']));
						$this->db->update('hotel_tbl_generalsupplement',$data1);
						$this->db->where(array('season'=>$request['season_id'],'contract_id'=>$request['contract_id'],'hotel_id'=>$request['hotel_id']));
						$this->db->update('hotel_tbl_cancellationfee',$data1);
						$this->db->where(array('season'=>$request['season_id'],'contract_id'=>$request['contract_id'],'hotel_id'=>$request['hotel_id']));
						$this->db->update('hotel_tbl_minimumstay',$data1);
						$extrabedData= array( 
						 'from_date' 	  => $request['fromDate'],
						 'to_date' 	      => $request['toDate'],
						);
						$this->db->where(array('season'=>$request['season_id'],'contract_id'=>$request['contract_id'],'hotel_id'=>$request['hotel_id']));
						$this->db->update('hotel_tbl_extrabed',$extrabedData);
					    $msg = true;
			    	}
				}
				return $msg;	
			} else {
				$checked_date =array();
				$start_date=date_create($request['fromDate']);
				$end_date=date_create($request['toDate']);
				$no_of_days=date_diff($start_date,$end_date);
				$tot_days = $no_of_days->format("%a");
				if ($request['fromDate'] > $request['toDate']) {
					$msg = 'To date should greater than From date !';
				} else {
					for($i = 0; $i <= $tot_days; $i++) {
			       		$result[1+$i]['date'] = date('Y-m-d', strtotime($request['fromDate']. ' + '.$i.'  days'));
				       	$this->db->select('*');
				        $this->db->from('hotel_tbl_season');
			            $where = "'".$result[1+$i]['date']."' BETWEEN FromDate AND ToDate";
				        $this->db->where($where);
				        $this->db->where('contract_id',$request['contract_id']);
				        $this->db->where('hotel_id',$request['hotel_id']);
				        $query[$result[1+$i]['date']]=$this->db->get()->result();
				        if (count($query[$result[1+$i]['date']])) {
				        	$checked_date[] = date('d-m-Y',strtotime($result[1+$i]['date']));
				        } 
			    	}
			    	if (count($checked_date)!="") {
			    		$msg = 'These ('.implode(", ", $checked_date).') days are already Exist !';
			    	} else {
		    		   $data= array( 
						 'FromDate' 	  => $request['fromDate'],
						 'ToDate' 	      => $request['toDate'],
						 'SeasonName' 	  => $request['SeasonName'],
						 'hotel_id' 	  => $request['hotel_id'],
		 				 'contract_id' 	  => $request['contract_id'],
		    			);
						$this->db->where('id',$request['season_id']);
						$this->db->update('hotel_tbl_season',$data);
					    $msg = true;
			    	}
				}
				return $msg;	
			}	
		} else {
			$checked_date =array();
			$start_date=date_create($request['fromDate']);
			$end_date=date_create($request['toDate']);
			$no_of_days=date_diff($start_date,$end_date);
			$tot_days = $no_of_days->format("%a");
			if ($request['fromDate'] > $request['toDate']) {
				$msg = 'To date should greater than From date !';
			} else {
				for($i = 0; $i <= $tot_days; $i++) {
		       	 $result[1+$i]['date'] = date('Y-m-d', strtotime($request['fromDate']. ' + '.$i.'  days'));
		       	$this->db->select('*');
		        $this->db->from('hotel_tbl_season');
	            $where = "'".$result[1+$i]['date']."' BETWEEN FromDate AND ToDate";
		        $this->db->where($where);
		        $this->db->where('contract_id',$request['contract_id']);
		        $this->db->where('hotel_id',$request['hotel_id']);
		        $query[$result[1+$i]['date']]=$this->db->get()->result();
			        if (count($query[$result[1+$i]['date']])) {
			        	$checked_date[] = date('d-m-Y',strtotime($result[1+$i]['date']));
			        } 
		    	}
		    	if (count($checked_date)!="") {
		    		$msg = 'These ('.implode(", ", $checked_date).') days are already Exist !';
		    	} else {
		    		   $data= array( 
						 'FromDate' 	  => $request['fromDate'],
						 'ToDate' 	      => $request['toDate'],
						 'SeasonName' 	  => $request['SeasonName'],
						 'hotel_id' 	  => $request['hotel_id'],
		 				 'contract_id' 	  => $request['contract_id'],
		    			);
						$this->db->insert('hotel_tbl_season',$data);
					$msg = true;
		    	}
			}
			return $msg;
		}
	}
	public function seasonDetails($request) {
		if (isset($request['Season']) && $request['Season']=="All") {
			return $query = $this->db->query('SELECT Max(ToDate) as ToDate , Min(FromDate) as FromDate FROM hotel_tbl_season WHERE  hotel_id = "'.$request['hotel_id'].'" AND  contract_id = "'.$request['contract_id'].'"')->result();
		} else {
			$this->db->select('*');
	        $this->db->from('hotel_tbl_season');
	        $this->db->where('hotel_id',$request['hotel_id']);
	        $this->db->where('contract_id',$request['contract_id']);
	        $this->db->where_in('id',$request['Season']);
	        return $query=$this->db->get()->result();
		}
		
	}
	public function seasonDelete($request){
        $this->db->where('id',$request['delete_id']);
		$this->db->delete('hotel_tbl_season');
		return true;
	}
	public function BoardSupplementSubmit($request) {
		$price = backend_Aed_convertion(hotel_currency_type($request['hotel_id']),$request['Amount']);

		$refreshCopy = $this->Hotels_Model->linkedRefreshCopyContract($request['contract_id'],'BoardCopy');
		$implode_room_types = "";
    	if (isset($request['room_type'])) {
    		$implode_room_types = implode(",", $request['room_type']);
    	}	
    	$other_season = isset($request['other_season']) ? 'on' : 'off';
    	if (count($refreshCopy)!=0) {
    		foreach ($refreshCopy as $RCkey => $RCvalue) {
	    		if ($request['id']=="") {
		    		if ($other_season=="on") {
							$data= array( 
							 'board' 	      => $request['board'],
							 'roomType' 	  => $implode_room_types,
							 'season' 	      => 'Other',
							 'fromDate' 	  => $request['fromDate'],
							 'toDate' 	      => $request['toDate'],
							 'startAge' 	  => $request['StartAge'],
							 'finalAge' 	  => $request['FinalAge'],
							 'amount' 	      => $price,
							 'hotel_id' 	  => $request['hotel_id'],
							 'contract_id' 	  => $RCvalue->contract_id,
							 'CreatedDate'    => date('Y-m-d H:i:s'),
							 'CreatedBy'	  => $this->session->userdata('id'),
							);
							$this->db->insert('hotel_tbl_boardsupplement',$data);

							// Log entry start
							$id = $this->db->insert_id();

							$dataLOG= array( 
							 'id' 	      => $id,
							 'board' 	      => $request['board'],
							 'roomType' 	  => $implode_room_types,
							 'season' 	      => 'Other',
							 'fromDate' 	  => $request['fromDate'],
							 'toDate' 	      => $request['toDate'],
							 'startAge' 	  => $request['StartAge'],
							 'finalAge' 	  => $request['FinalAge'],
							 'amount' 	      => $price,
							 'hotel_id' 	  => $request['hotel_id'],
							 'contract_id' 	  => $RCvalue->contract_id,
							 'CreatedDate'    => date('Y-m-d H:i:s'),
							 'CreatedBy'	  => $this->session->userdata('id'),
							 'Status'		  => 'inserted'
							);
							$this->db->insert('hotel_tbl_boardsupplement_logs',$dataLOG);
							// Log entry end
			    	} else {
						foreach ($request['season'] as $key => $value) {
							$this->db->select('*');
					    	$this->db->from('hotel_tbl_season');
					    	$this->db->where_in('id',$value);
					    	$query = $this->db->get()->result();
							$data= array( 
							 'board' 	  	  => $request['board'],
							 'roomType' 	  => $implode_room_types,
							 'season' 	  	  => $value,
							 'fromDate' 	  => $query[0]->FromDate,
							 'toDate' 	  	  => $query[0]->ToDate,
							 'startAge' 	  => $request['StartAge'],
							 'finalAge' 	  => $request['FinalAge'],
							 'amount' 	  	  => $price,
							 'hotel_id' 	  => $request['hotel_id'],
					 		 'contract_id' 	  => $RCvalue->contract_id,
					 		 'CreatedDate'    => date('Y-m-d H:i:s'),
							 'CreatedBy'	  => $this->session->userdata('id'),
							);
							$this->db->insert('hotel_tbl_boardsupplement',$data);

							// Log entry start
							$id = $this->db->insert_id();
							$dataLOG= array( 
							 'id' 	      => $id,
							 'board' 	  	  => $request['board'],
							 'roomType' 	  => $implode_room_types,
							 'season' 	  	  => $value,
							 'fromDate' 	  => $query[0]->FromDate,
							 'toDate' 	  	  => $query[0]->ToDate,
							 'startAge' 	  => $request['StartAge'],
							 'finalAge' 	  => $request['FinalAge'],
							 'amount' 	  	  => $price,
							 'hotel_id' 	  => $request['hotel_id'],
					 		 'contract_id' 	  => $RCvalue->contract_id,
					 		 'CreatedDate'    => date('Y-m-d H:i:s'),
							 'CreatedBy'	  => $this->session->userdata('id'),
							 'Status'		  => 'inserted'
							);
							$this->db->insert('hotel_tbl_boardsupplement_logs',$dataLOG);
						}
			    	}
	    		}
			}
    	} 

    	if ($other_season=="on") {
    		if ($request['id']!="") {
	    		$data= array( 
				 'board' 	      => $request['board'],
				 'roomType' 	  => $implode_room_types,
				 'season' 	      => 'Other',
				 'fromDate' 	  => $request['fromDate'],
				 'toDate' 	      => $request['toDate'],
				 'startAge' 	  => $request['StartAge'],
				 'finalAge' 	  => $request['FinalAge'],
				 'amount' 	      => $price,
				 'UpdatedDate'    => date('Y-m-d H:i:s'),
				 'UpdatedBy'	  => $this->session->userdata('id'),
				);
	        	$this->db->where('id',$request['id']);
				$this->db->update('hotel_tbl_boardsupplement',$data);

				// Log entry start
				$id = $request['id'];

				$dataLOG= array( 
				 'id' 	      => $id,
				 'board' 	      => $request['board'],
				 'roomType' 	  => $implode_room_types,
				 'season' 	      => 'Other',
				 'fromDate' 	  => $request['fromDate'],
				 'toDate' 	      => $request['toDate'],
				 'startAge' 	  => $request['StartAge'],
				 'finalAge' 	  => $request['FinalAge'],
				 'amount' 	      => $price,
				 'hotel_id' 	  => $request['hotel_id'],
		 	     'contract_id' 	  => $request['contract_id'],
				 'CreatedDate'    => date('Y-m-d H:i:s'),
				 'CreatedBy'	  => $this->session->userdata('id'),
				 'Status'		  => 'updated'
				);
				$this->db->insert('hotel_tbl_boardsupplement_logs',$dataLOG);
				// Log entry end

	    	} else {
				$data= array( 
				 'board' 	      => $request['board'],
				 'roomType' 	  => $implode_room_types,
				 'season' 	      => 'Other',
				 'fromDate' 	  => $request['fromDate'],
				 'toDate' 	      => $request['toDate'],
				 'startAge' 	  => $request['StartAge'],
				 'finalAge' 	  => $request['FinalAge'],
				 'amount' 	      => $price,
				 'hotel_id' 	  => $request['hotel_id'],
				 'contract_id' 	  => $request['contract_id'],
				 'CreatedDate'    => date('Y-m-d H:i:s'),
				 'CreatedBy'	  => $this->session->userdata('id'),
				);
				$this->db->insert('hotel_tbl_boardsupplement',$data);

				// Log entry start
				$id = $this->db->insert_id();

				$dataLOG= array( 
				 'id' 	      => $id,
				 'board' 	      => $request['board'],
				 'roomType' 	  => $implode_room_types,
				 'season' 	      => 'Other',
				 'fromDate' 	  => $request['fromDate'],
				 'toDate' 	      => $request['toDate'],
				 'startAge' 	  => $request['StartAge'],
				 'finalAge' 	  => $request['FinalAge'],
				 'amount' 	      => $price,
				 'hotel_id' 	  => $request['hotel_id'],
				 'contract_id' 	  => $request['contract_id'],
				 'CreatedDate'    => date('Y-m-d H:i:s'),
				 'CreatedBy'	  => $this->session->userdata('id'),
				 'Status'		  => 'inserted'
				);
				$this->db->insert('hotel_tbl_boardsupplement_logs',$dataLOG);
				// Log entry end

	    	}
    	} else {
			foreach ($request['season'] as $key => $value) {
				$this->db->select('*');
		    	$this->db->from('hotel_tbl_season');
		    	$this->db->where_in('id',$value);
		    	$query = $this->db->get()->result();
		    	if ($request['id']!="") {
		    		$data= array( 
					 'board' 	  	  => $request['board'],
					 'roomType' 	  => $implode_room_types,
					 'season' 	  	  => $value,
					 'fromDate' 	  => $query[0]->FromDate,
					 'toDate' 	  	  => $query[0]->ToDate,
					 'startAge' 	  => $request['StartAge'],
					 'finalAge' 	  => $request['FinalAge'],
					 'amount' 	  	  => $price,
					 'UpdatedDate'    => date('Y-m-d H:i:s'),
				 	 'UpdatedBy'	  => $this->session->userdata('id')
					);
		        	$this->db->where('id',$request['id']);
					$this->db->update('hotel_tbl_boardsupplement',$data);

					// Log entry start
					$id = $request['id'];

					$dataLOG= array( 
					 'id' 	      => $id,
					 'board' 	  	  => $request['board'],
					 'roomType' 	  => $implode_room_types,
					 'season' 	  	  => $value,
					 'fromDate' 	  => $query[0]->FromDate,
					 'toDate' 	  	  => $query[0]->ToDate,
					 'startAge' 	  => $request['StartAge'],
					 'finalAge' 	  => $request['FinalAge'],
					 'amount' 	  	  => $price,
					 'hotel_id' 	  => $request['hotel_id'],
					 'contract_id' 	  => $request['contract_id'],
					 'CreatedDate'    => date('Y-m-d H:i:s'),
					 'CreatedBy'	  => $this->session->userdata('id'),
					 'Status'		  => 'updated'
					);
					$this->db->insert('hotel_tbl_boardsupplement_logs',$dataLOG);
					// Log entry end

		    	} else {
					$data= array( 
					 'board' 	  	  => $request['board'],
					 'roomType' 	  => $implode_room_types,
					 'season' 	  	  => $value,
					 'fromDate' 	  => $query[0]->FromDate,
					 'toDate' 	  	  => $query[0]->ToDate,
					 'startAge' 	  => $request['StartAge'],
					 'finalAge' 	  => $request['FinalAge'],
					 'amount' 	  	  => $price,
					 'hotel_id' 	  => $request['hotel_id'],
					 'contract_id' 	  => $request['contract_id'],
					 'CreatedDate'    => date('Y-m-d H:i:s'),
					 'CreatedBy'	  => $this->session->userdata('id'),
					);
					$this->db->insert('hotel_tbl_boardsupplement',$data);

					// Log entry start
					$id = $this->db->insert_id();

					$dataLOG= array( 
					 'id' 	      => $id,
					 'board' 	  	  => $request['board'],
					 'roomType' 	  => $implode_room_types,
					 'season' 	  	  => $value,
					 'fromDate' 	  => $query[0]->FromDate,
					 'toDate' 	  	  => $query[0]->ToDate,
					 'startAge' 	  => $request['StartAge'],
					 'finalAge' 	  => $request['FinalAge'],
					 'amount' 	  	  => $price,
					 'hotel_id' 	  => $request['hotel_id'],
					 'contract_id' 	  => $request['contract_id'],
					 'CreatedDate'    => date('Y-m-d H:i:s'),
					 'CreatedBy'	  => $this->session->userdata('id'),
					 'Status'		  => 'inserted'
					);
					$this->db->insert('hotel_tbl_boardsupplement_logs',$dataLOG);
					// Log entry end
		    	}

			}
    	}
		return true;
	}
	public function BoardSupplementList($hotel_id,$con_id) {
		$this->db->select('hotel_tbl_boardsupplement.*,hotel_tbl_season.*,hotel_tbl_boardsupplement.id as edit_id');
        $this->db->from('hotel_tbl_boardsupplement');
        $this->db->join('hotel_tbl_season','hotel_tbl_season.id = hotel_tbl_boardsupplement.season','left');
        $this->db->where('hotel_tbl_boardsupplement.hotel_id',$hotel_id);
        $this->db->where('hotel_tbl_boardsupplement.contract_id',$con_id);
        return $query=$this->db->get();
	}
	public function BoardSupplementDetails($id) {
		$this->db->select('*');
        $this->db->from('hotel_tbl_boardsupplement');
        $this->db->where('id',$id);
        return $query=$this->db->get()->result();
	}
	public function BoardSupplement_delete($id) {
		$this->db->select('*');
        $this->db->from('hotel_tbl_boardsupplement');
        $this->db->where('id',$id);
        $details=$this->db->get()->result();
		$this->db->where('id',$id);
		$this->db->delete('hotel_tbl_boardsupplement');
		// Log entry start
		$dataLOG= array( 
		 'id' 	      => $id,
		 'board' 	  	  => $details[0]->board,
		 'roomType' 	  => $details[0]->roomType,
		 'season' 	  	  => $details[0]->season,
		 'fromDate' 	  => $details[0]->fromDate,
		 'toDate' 	  	  => $details[0]->toDate,
		 'startAge' 	  => $details[0]->startAge,
		 'finalAge' 	  => $details[0]->finalAge,
		 'amount' 	  	  => $details[0]->amount,
		 'hotel_id' 	  => $details[0]->hotel_id,
		 'contract_id' 	  => $details[0]->contract_id,
		 'CreatedDate'    => date('Y-m-d H:i:s'),
		 'CreatedBy'	  => $this->session->userdata('id'),
		 'Status'		  => 'deleted'
		);
		$this->db->insert('hotel_tbl_boardsupplement_logs',$dataLOG);
		// Log entry end
		return true;
	}
	public function GeneralSupplementList($hotel_id,$contract_id) {
		$this->db->select('hotel_tbl_generalsupplement.*,hotel_tbl_season.*,hotel_tbl_generalsupplement.id as edit_id');
        $this->db->from('hotel_tbl_generalsupplement');
        $this->db->join('hotel_tbl_season','hotel_tbl_season.id = hotel_tbl_generalsupplement.season','left');
        $this->db->where('hotel_tbl_generalsupplement.hotel_id',$hotel_id);
        $this->db->where('hotel_tbl_generalsupplement.contract_id',$contract_id);
        return $query=$this->db->get();
	}
	public function GeneralSupplementSubmit($request) {
		$adultAmount = backend_Aed_convertion(hotel_currency_type($request['hotel_id']),$request['adultAmount']);
		$childAmount = backend_Aed_convertion(hotel_currency_type($request['hotel_id']),$request['childAmount']);

		$refreshCopyGen = $this->Hotels_Model->linkedRefreshCopyGen($request['contract_id'],'GenCopy');
		$implode_room_types = "";
    	if (isset($request['room_type'])) {
    		$implode_room_types = implode(",", $request['room_type']);
    	}
    	if (isset($request['mandatory'])) {
    		$mandatory= 1;
    	} else {
    		$mandatory= 0;
    	}
    	$other_season = isset($request['other_season']) ? 'on' : 'off';
	   	if (count($refreshCopyGen)!=0) {
	   	  foreach ($refreshCopyGen as $RCkey => $RCvalue) {
	    	if ($request['id']=="") {
				if ($other_season=="on") {
				 		$data= array( 
				     // 'board'     => $request['board'],
				     	'type'     		=> $request['type'],
				     	'roomType'     	=> $implode_room_types,
				     	'season'     	=> 'Other',
				     	'fromDate'     	=> $request['fromDate'],
				     	'toDate'     	=> $request['toDate'],
				     	'adultAmount'   => $adultAmount,
				     	'childAmount'   => $childAmount,
				     	'hotel_id'     	=> $request['hotel_id'],
				     	'contract_id' 	=> $RCvalue->contract_id,
				     	'application'   => $request['application'],
				     	'mandatory' 	=> $mandatory,
				     	'MinChildAge'	=> $request['MinChildAge'],
				     	'CreatedDate'   => date('Y-m-d H:i:s'),
				     	'CreatedBy'     => $this->session->userdata('id'),
				    	);
				    	$this->db->insert('hotel_tbl_generalsupplement',$data);
				    	// Log entry start
				    	$id = $this->db->insert_id();
				    	$dataLOG= array( 
				    		'id' 			=> $id,
					     	'type'     		=> $request['type'],
					     	'roomType'     	=> $implode_room_types,
					     	'season'     	=> 'Other',
					     	'fromDate'     	=> $request['fromDate'],
					     	'toDate'     	=> $request['toDate'],
					     	'adultAmount'   => $adultAmount,
					     	'childAmount'   => $childAmount,
					     	'hotel_id'     	=> $request['hotel_id'],
					     	'contract_id' 	=> $RCvalue->contract_id,
					     	'application'   => $request['application'],
					     	'mandatory' 	=> $mandatory,
					     	'MinChildAge'	=> $request['MinChildAge'],
					     	'CreatedDate'   => date('Y-m-d H:i:s'),
					     	'CreatedBy'     => $this->session->userdata('id'),
					     	'Status'		=> 'inserted'
					    	);
				    	$this->db->insert('hotel_tbl_generalsupplement_log',$dataLOG);

				    	// Log entry end
				} else {
					foreach ($request['season'] as $key => $value) {
						$this->db->select('*');
				        $this->db->from('hotel_tbl_season');
				        $this->db->where_in('id',$value);
				        $query = $this->db->get()->result();
						$data= array( 
				     		// 'board'     => $request['board'],
				     		'type'     		=> $request['type'],
				     		'roomType'  	=> $implode_room_types,
				     		'season'     	=> $value,
				     		'fromDate'     	=> $query[0]->FromDate,
				     		'toDate'     	=> $query[0]->ToDate,
				     		'adultAmount'  	=> $adultAmount,
				     		'childAmount'  	=> $childAmount,
				     		'hotel_id'     	=> $request['hotel_id'],
				     		'contract_id' 	=> $RCvalue->contract_id,
				     		'application'   => $request['application'],
				     		'mandatory' 	=> $mandatory,
				     		'MinChildAge'	=> $request['MinChildAge'],
				     		'CreatedDate'   => date('Y-m-d H:i:s'),
				     		'CreatedBy'     => $this->session->userdata('id'),
				    	);
				      	$this->db->insert('hotel_tbl_generalsupplement',$data);

				      	// Log entry start
				    	$id = $this->db->insert_id();
				    	$dataLOG= array( 
				    		'id' 			=> $id,
					     	'type'     		=> $request['type'],
				     		'roomType'  	=> $implode_room_types,
				     		'season'     	=> $value,
				     		'fromDate'     	=> $query[0]->FromDate,
				     		'toDate'     	=> $query[0]->ToDate,
				     		'adultAmount'  	=> $adultAmount,
				     		'childAmount'  	=> $childAmount,
				     		'hotel_id'     	=> $request['hotel_id'],
				     		'contract_id' 	=> $RCvalue->contract_id,
				     		'application'   => $request['application'],
				     		'mandatory' 	=> $mandatory,
				     		'MinChildAge'	=> $request['MinChildAge'],
				     		'CreatedDate'   => date('Y-m-d H:i:s'),
				     		'CreatedBy'     => $this->session->userdata('id'),
				     		'Status'		=> 'inserted'
					    	);
				    	$this->db->insert('hotel_tbl_generalsupplement_log',$dataLOG);
				    	// Log entry end

				    }
				}
			}
		  }
		}

		if ($other_season=="on") {
		    if ($request['id']!="") {
	    	    $data= array( 
			     // 'board'     => $request['board'],
			     'type'     		=> $request['type'],
			     'roomType'     	=> $implode_room_types,
			     'season'     		=> 'Other',
			     'fromDate'     	=> $request['fromDate'],
			     'toDate'     		=> $request['toDate'],
			     'adultAmount'    	=> $adultAmount,
			     'childAmount'    	=> $childAmount,
			     'application'    	=> $request['application'],
			     'mandatory' 		=> $mandatory,
	     		 'MinChildAge'	=> $request['MinChildAge'],
	     		 'UpdatedDate'   => date('Y-m-d H:i:s'),
			     'UpdatedBy'     => $this->session->userdata('id'),

			    );
			    $this->db->where('id',$request['id']);
			    $this->db->update('hotel_tbl_generalsupplement',$data);

			    // Log entry start
		    	$id = $request['id'];
		    	$dataLOG= array( 
		    		'id' 			=> $id,
			     	'type'     		=> $request['type'],
					'roomType'     	=> $implode_room_types,
					'season'     	=> 'Other',
					'fromDate'     	=> $request['fromDate'],
					'toDate'     	=> $request['toDate'],
					'adultAmount'   => $adultAmount,
					'childAmount'   => $childAmount,
					'application'   => $request['application'],
					'hotel_id'     	=> $request['hotel_id'],
					'contract_id'   => $request['contract_id'],
					'mandatory' 	=> $mandatory,
					'MinChildAge'	=> $request['MinChildAge'],
			     	'CreatedDate'   => date('Y-m-d H:i:s'),
			     	'CreatedBy'     => $this->session->userdata('id'),
			     	'Status' 		=> 'updated'
			    	);
		    	$this->db->insert('hotel_tbl_generalsupplement_log',$dataLOG);
		    	// Log entry end

		    } else {
			    $data= array( 
			     // 'board'     => $request['board'],
			     'type'     		=> $request['type'],
			     'roomType'     	=> $implode_room_types,
			     'season'     		=> 'Other',
			     'fromDate'     	=> $request['fromDate'],
			     'toDate'     		=> $request['toDate'],
			     'adultAmount'    	=> $adultAmount,
			     'childAmount'    	=> $childAmount,
			     'hotel_id'     	=> $request['hotel_id'],
			     'contract_id'    	=> $request['contract_id'],
			     'application'    	=> $request['application'],
			     'mandatory' 		=> $mandatory,
	     		 'MinChildAge'	=> $request['MinChildAge'],
	     		 'CreatedDate'   => date('Y-m-d H:i:s'),
				 'CreatedBy'     => $this->session->userdata('id'),
			    );
			    $this->db->insert('hotel_tbl_generalsupplement',$data);

			    // Log entry start
		    	$id = $this->db->insert_id();
		    	$dataLOG= array( 
		    		'id' 			=> $id,
			     	'type'     		=> $request['type'],
					'roomType'     	=> $implode_room_types,
					'season'     	=> 'Other',
					'fromDate'     	=> $request['fromDate'],
					'toDate'     	=> $request['toDate'],
					'adultAmount'    => $adultAmount,
					'childAmount'    => $childAmount,
					'hotel_id'     	=> $request['hotel_id'],
					'contract_id'    => $request['contract_id'],
					'application'    => $request['application'],
					'mandatory' 	=> $mandatory,
					'MinChildAge'	=> $request['MinChildAge'],
					'CreatedDate'   => date('Y-m-d H:i:s'),
					'CreatedBy'     => $this->session->userdata('id'),
					'Status'		=> 'inserted'
			    	);
		    	$this->db->insert('hotel_tbl_generalsupplement_log',$dataLOG);
		    	// Log entry end

		    }
		  } else {
		      foreach ($request['season'] as $key => $value) {
		        $this->db->select('*');
		        $this->db->from('hotel_tbl_season');
		        $this->db->where_in('id',$value);
		        $query = $this->db->get()->result();

		      if ($request['id']!="") {
			    $data= array( 
			     // 'board'     => $request['board'],
			     'type'     		=> $request['type'],
			     'roomType'     	=> $implode_room_types,
			     'season'     		=> $value,
			     'fromDate'     	=> $query[0]->FromDate,
			     'toDate'     		=> $query[0]->ToDate,
			     'adultAmount'    	=> $adultAmount,
			     'childAmount'    	=> $childAmount,
			     'application'    	=> $request['application'],
			     'mandatory' 		=> $mandatory,
	     		 'MinChildAge'	=> $request['MinChildAge'],
	     		 'UpdatedDate'   => date('Y-m-d H:i:s'),
			     'UpdatedBy'     => $this->session->userdata('id'),
			    );
		      	$this->db->where('id',$request['id']);
		      	$this->db->update('hotel_tbl_generalsupplement',$data);

		      	// Log entry start
		    	$id = $request['id'];
		    	$dataLOG= array( 
		    		'id' 			=> $id,
			     	'type'     		=> $request['type'],
				    'roomType'     	=> $implode_room_types,
				    'season'     	=> $value,
				    'fromDate'     	=> $query[0]->FromDate,
				    'toDate'     	=> $query[0]->ToDate,
				    'adultAmount'   => $adultAmount,
				    'childAmount'   => $childAmount,
				    'application'   => $request['application'],
				    'hotel_id'     	=> $request['hotel_id'],
					'contract_id'   => $request['contract_id'],
				    'mandatory' 	=> $mandatory,
		     		'MinChildAge'	=> $request['MinChildAge'],
			     	'CreatedDate'   => date('Y-m-d H:i:s'),
			     	'CreatedBy'     => $this->session->userdata('id'),
			     	'Status'		=> 'updated'
			    	);
		    	$this->db->insert('hotel_tbl_generalsupplement_log',$dataLOG);
		    	// Log entry end

		    } else {
			    $data= array( 
			     // 'board'     => $request['board'],
			     'type'     	=> $request['type'],
			     'roomType'     => $implode_room_types,
			     'season'     	=> $value,
			     'fromDate'     => $query[0]->FromDate,
			     'toDate'     	=> $query[0]->ToDate,
			     'adultAmount'  => $adultAmount,
			     'childAmount'  => $childAmount,
			     'hotel_id'     => $request['hotel_id'],
			     'contract_id'  => $request['contract_id'],
			     'application'  => $request['application'],
			     'mandatory' 	=> $mandatory,
	     		 'MinChildAge'	=> $request['MinChildAge'],
	     		 'CreatedDate'   => date('Y-m-d H:i:s'),
				 'CreatedBy'     => $this->session->userdata('id'),
			    );
		        $this->db->insert('hotel_tbl_generalsupplement',$data);

		        // Log entry start
		    	$id = $this->db->insert_id();
		    	$dataLOG= array( 
		    		'id' 			=> $id,
			     	'type'     		=> $request['type'],
				    'roomType'     	=> $implode_room_types,
				    'season'     	=> $value,
				    'fromDate'     	=> $query[0]->FromDate,
				    'toDate'     	=> $query[0]->ToDate,
				    'adultAmount'   => $adultAmount,
				    'childAmount'   => $childAmount,
				    'application'   => $request['application'],
				    'hotel_id'     	=> $request['hotel_id'],
					'contract_id'   => $request['contract_id'],
				    'mandatory' 	=> $mandatory,
		     		'MinChildAge'	=> $request['MinChildAge'],
			     	'CreatedDate'   => date('Y-m-d H:i:s'),
			     	'CreatedBy'     => $this->session->userdata('id'),
			     	'Status'		=> 'inserted'
			    	);
		    	$this->db->insert('hotel_tbl_generalsupplement_log',$dataLOG);
		    	// Log entry end
		    }
		  }
		}
		return true;
	}
	public function GeneralSupplementDetails($id) {
		$this->db->select('*');
        $this->db->from('hotel_tbl_generalsupplement');
        $this->db->where('id',$id);
        return $query=$this->db->get()->result();
	}
	public function GeneralSupplement_delete($id) {
		$this->db->select('*');
        $this->db->from('hotel_tbl_generalsupplement');
        $this->db->where('id',$id);
        $details=$this->db->get()->result();
		$this->db->where('id',$id);
		$this->db->delete('hotel_tbl_generalsupplement');
		// Log entry start
		$dataLOG= array( 
	    		'id' 			=> $id,
		     	'type'     		=> $details[0]->type,
			    'roomType'     	=> $details[0]->roomType,
			    'season'     	=> $details[0]->season,
			    'fromDate'     	=> $details[0]->fromDate,
			    'toDate'     	=> $details[0]->toDate,
			    'adultAmount'   => $details[0]->adultAmount,
			    'childAmount'   => $details[0]->childAmount,
			    'application'   => $details[0]->application,
			    'hotel_id'     	=> $details[0]->hotel_id,
				'contract_id'   => $details[0]->contract_id,
			    'mandatory' 	=> $details[0]->mandatory,
	     		'MinChildAge'	=> $details[0]->MinChildAge,
		     	'CreatedDate'   => date('Y-m-d H:i:s'),
		     	'CreatedBy'     => $this->session->userdata('id'),
		     	'Status'		=> 'deleted'
		    );
    	$this->db->insert('hotel_tbl_generalsupplement_log',$dataLOG);
    	// Log entry end
		return true;
	}
	public function CancelationFeeSubmit($request) {
		$refreshCopyCancel = $this->Hotels_Model->linkedRefreshCopyCancel($request['contract_id'],'CancelCopy');
		$implode_room_types = "";
    	if (isset($request['room_type'])) {
    		$implode_room_types = implode(",", $request['room_type']);
    	}

    	if ($request['application']=="FREE OF CHARGE") {
    		$CancellationPercentage = 0;
    	} else {
    	    $CancellationPercentage = $request['CancellationPercentage'];
    	}
    	if (count($refreshCopyCancel)!=0) {
	    	if ($request['id']=="") {
	   	  		foreach ($refreshCopyCancel as $RCkey => $RCvalue) {
	   	  			if (isset($request['other_season'])) {
	   	  				$data= array( 
					 		'roomType' 	         	 => $implode_room_types,
					 		'season' 	             => 'Other',
					 		'fromDate' 	         	 => $request['fromDate'],
					 		'toDate' 	             => $request['toDate'],
					 		// 'daysInAdvance' 	     => $request['daysInAdvance'],
					 		'cancellationPercentage' => $CancellationPercentage,
					 		'hotel_id' 	             => $request['hotel_id'],
					 		'contract_id' 	         => $RCvalue->contract_id,
					 		'application' 	         => $request['application'],
					 		'daysFrom'				 => $request['daysFrom'],
					 		'daysTo'				 => $request['daysTo'],
					 		'CreatedDate'   => date('Y-m-d H:i:s'),
		     				'CreatedBy'     => $this->session->userdata('id'),
						);
						$this->db->insert('hotel_tbl_cancellationfee',$data);
						//log entry start
						$id = $this->db->insert_id();
						$dataLOG= array( 
							'id'					 => $id,
					 		'roomType' 	         	 => $implode_room_types,
					 		'season' 	             => 'Other',
					 		'fromDate' 	         	 => $request['fromDate'],
					 		'toDate' 	             => $request['toDate'],
					 		// 'daysInAdvance' 	     => $request['daysInAdvance'],
					 		'cancellationPercentage' => $CancellationPercentage,
					 		'hotel_id' 	             => $request['hotel_id'],
					 		'contract_id' 	         => $RCvalue->contract_id,
					 		'application' 	         => $request['application'],
					 		'daysFrom'				 => $request['daysFrom'],
					 		'daysTo'				 => $request['daysTo'],
					 		'CreatedDate'   => date('Y-m-d H:i:s'),
		     				'CreatedBy'     => $this->session->userdata('id'),
		     				'Status' 		=> 'inserted'
						);
						$this->db->insert('hotel_tbl_cancellationfee_log',$dataLOG);
						//log entry end
	   	  			} else {
	   	  				foreach ($request['Season'] as $key => $value) {
							$this->db->select('*');
					    	$this->db->from('hotel_tbl_season');
					    	$this->db->where_in('id',$value);
					    	$query = $this->db->get()->result();
					    	$data= array( 
						 		'roomType' 	         	 => $implode_room_types,
						 		'season' 	             => $value,
						 		'fromDate' 	         	 => $query[0]->FromDate,
						 		'toDate' 	             => $query[0]->ToDate,
						 		// 'daysInAdvance' 	     => $request['daysInAdvance'],
						 		'cancellationPercentage' => $CancellationPercentage,
						 		'hotel_id' 	             => $request['hotel_id'],
						 		'contract_id' 	         => $RCvalue->contract_id,
						 		'application' 	         => $request['application'],
						 		'daysFrom'				 => $request['daysFrom'],
						 		'daysTo'				 => $request['daysTo'],
						 		'CreatedDate'   => date('Y-m-d H:i:s'),
		     					'CreatedBy'     => $this->session->userdata('id'),
							);
							$this->db->insert('hotel_tbl_cancellationfee',$data);
							//log entry start
							$id = $this->db->insert_id();
							$dataLOG= array( 
								'id'					 => $id,
						 		'roomType' 	         	 => $implode_room_types,
						 		'season' 	             => $value,
						 		'fromDate' 	         	 => $query[0]->FromDate,
						 		'toDate' 	             => $query[0]->ToDate,
						 		// 'daysInAdvance' 	     => $request['daysInAdvance'],
						 		'cancellationPercentage' => $CancellationPercentage,
						 		'hotel_id' 	             => $request['hotel_id'],
						 		'contract_id' 	         => $RCvalue->contract_id,
						 		'application' 	         => $request['application'],
						 		'daysFrom'				 => $request['daysFrom'],
						 		'daysTo'				 => $request['daysTo'],
						 		'CreatedDate'   => date('Y-m-d H:i:s'),
			     				'CreatedBy'     => $this->session->userdata('id'),
			     				'Status' 		=> 'inserted'
							);
							$this->db->insert('hotel_tbl_cancellationfee_log',$dataLOG);
							//log entry end
				    	}
	   	  			}
	   	  			
				}
			}
		}


    	if ($request['id']!="") {
			$data= array( 
			 'roomType' 	          => $implode_room_types,
			 'season' 	              => $request['Season'],
			 'fromDate' 	          => $request['fromDate'],
			 'toDate' 	              => $request['toDate'],
			 // 'daysInAdvance' 	      => $request['daysInAdvance'],
			 'cancellationPercentage' => $CancellationPercentage,
			 'application' 	          => $request['application'],
			 'daysFrom'				 => $request['daysFrom'],
	 		 'daysTo'				 => $request['daysTo'],
	 		 'UpdatedDate'  		 => date('Y-m-d H:i:s'),
		     'UpdatedBy'    		 => $this->session->userdata('id'),
			);
			$this->db->where('id',$request['id']);
			$this->db->update('hotel_tbl_cancellationfee',$data);
			// log entry start
			$id = $request['id'];
			$dataLOG= array( 
				'id'					 => $id,
		 		'roomType' 	         	 => $implode_room_types,
		 		'season' 	             => $request['Season'],
		 		'fromDate' 	         	 => $request['fromDate'],
		 		'toDate' 	             => $request['toDate'],
		 		// 'daysInAdvance' 	     => $request['daysInAdvance'],
		 		'cancellationPercentage' => $CancellationPercentage,
		 		'hotel_id' 	             => $request['hotel_id'],
		 		'contract_id' 	         => $request['contract_id'],
		 		'application' 	         => $request['application'],
		 		'daysFrom'				 => $request['daysFrom'],
		 		'daysTo'				 => $request['daysTo'],
		 		'CreatedDate'   => date('Y-m-d H:i:s'),
 				'CreatedBy'     => $this->session->userdata('id'),
 				'Status' 		=> 'updated'
			);
			$this->db->insert('hotel_tbl_cancellationfee_log',$dataLOG);
			// log entry end
    	} else {
  			if (isset($request['other_season'])) {
				$data= array( 
				 'roomType' 	         => $implode_room_types,
				 'season' 	             => 'Other',
				 'fromDate' 	         => $request['fromDate'],
				 'toDate' 	             => $request['toDate'],
				 // 'daysInAdvance' 	     => $request['daysInAdvance'],
				 'cancellationPercentage'=> $CancellationPercentage,
				 'hotel_id' 	         => $request['hotel_id'],
				 'contract_id' 	         => $request['contract_id'],
				 'application' 	         => $request['application'],
				 'daysFrom'				 => $request['daysFrom'],
		 		 'daysTo'				 => $request['daysTo'],
		 		 'CreatedDate'   => date('Y-m-d H:i:s'),
		     	 'CreatedBy'     => $this->session->userdata('id'),
				);
				$this->db->insert('hotel_tbl_cancellationfee',$data);
				//log entry start
				$id = $this->db->insert_id();
				$dataLOG= array( 
					'id'					 => $id,
			 		'roomType' 	         	 => $implode_room_types,
			 		'season' 	             => 'Other',
			 		'fromDate' 	         	 => $request['fromDate'],
			 		'toDate' 	             => $request['toDate'],
			 		// 'daysInAdvance' 	     => $request['daysInAdvance'],
			 		'cancellationPercentage' => $CancellationPercentage,
			 		'hotel_id' 	             => $request['hotel_id'],
			 		'contract_id' 	         => $request['contract_id'],
			 		'application' 	         => $request['application'],
			 		'daysFrom'				 => $request['daysFrom'],
			 		'daysTo'				 => $request['daysTo'],
			 		'CreatedDate'   => date('Y-m-d H:i:s'),
     				'CreatedBy'     => $this->session->userdata('id'),
     				'Status' 		=> 'inserted'
				);
				$this->db->insert('hotel_tbl_cancellationfee_log',$dataLOG);
				//log entry end
			} else {
				foreach ($request['Season'] as $key => $value) {
					$this->db->select('*');
			    	$this->db->from('hotel_tbl_season');
			    	$this->db->where_in('id',$value);
			    	$query = $this->db->get()->result();
			    	$data= array( 
						 'roomType' 	         => $implode_room_types,
						 'season' 	             => $value,
				 		 'fromDate' 	         => $query[0]->FromDate,
				 		 'toDate' 	             => $query[0]->ToDate,
						 // 'daysInAdvance' 	     => $request['daysInAdvance'],
						 'cancellationPercentage'=> $CancellationPercentage,
						 'hotel_id' 	         => $request['hotel_id'],
						 'contract_id' 	         => $request['contract_id'],
						 'application' 	         => $request['application'],
						 'daysFrom'				 => $request['daysFrom'],
				 		 'daysTo'				 => $request['daysTo'],
				 		 'CreatedDate'   => date('Y-m-d H:i:s'),
		     			 'CreatedBy'     => $this->session->userdata('id'),
					);
					$this->db->insert('hotel_tbl_cancellationfee',$data);
					//log entry start
					$id = $this->db->insert_id();
					$dataLOG= array( 
						'id'					 => $id,
				 		'roomType' 	         	 => $implode_room_types,
				 		'season' 	             => $value,
				 		'fromDate' 	         	 => $query[0]->FromDate,
				 		'toDate' 	             => $query[0]->ToDate,
				 		// 'daysInAdvance' 	     => $request['daysInAdvance'],
				 		'cancellationPercentage' => $CancellationPercentage,
				 		'hotel_id' 	             => $request['hotel_id'],
				 		'contract_id' 	         => $request['contract_id'],
				 		'application' 	         => $request['application'],
				 		'daysFrom'				 => $request['daysFrom'],
				 		'daysTo'				 => $request['daysTo'],
				 		'CreatedDate'   => date('Y-m-d H:i:s'),
	     				'CreatedBy'     => $this->session->userdata('id'),
	     				'Status' 		=> 'inserted'
					);
					$this->db->insert('hotel_tbl_cancellationfee_log',$dataLOG);
					//log entry end
		    	}
			}
    	}
		return true;
	}
	public function CancelationFeeList($hotel_id,$contract_id) {
		$this->db->select('hotel_tbl_cancellationfee.*,hotel_tbl_season.*,hotel_tbl_cancellationfee.id as edit_id');
        $this->db->from('hotel_tbl_cancellationfee');
        $this->db->join('hotel_tbl_season','hotel_tbl_season.id = hotel_tbl_cancellationfee.season','left');
        $this->db->where('hotel_tbl_cancellationfee.hotel_id',$hotel_id);
        $this->db->where('hotel_tbl_cancellationfee.contract_id',$contract_id);
        return $query=$this->db->get();
	}
	public function CancellationFeeDetails($id) {
		$this->db->select('*');
        $this->db->from('hotel_tbl_cancellationfee');
        $this->db->where('id',$id);
        return $query=$this->db->get()->result();
	}
	public function CancelationFee_delete($id) {
		$this->db->select('*');
		$this->db->from('hotel_tbl_cancellationfee');
		$this->db->where('id',$id);
		$details = $this->db->get()->result();
		$this->db->where('id',$id);
		$this->db->delete('hotel_tbl_cancellationfee');
		//log entry start
		$dataLOG= array( 
			'id'					 => $id,
	 		'roomType' 	         	 => $details[0]->roomType,
	 		'season' 	             => $details[0]->season,
	 		'fromDate' 	         	 => $details[0]->fromDate,
	 		'toDate' 	             => $details[0]->toDate,
	 		// 'daysInAdvance' 	     => $request['daysInAdvance'],
	 		'cancellationPercentage' => $details[0]->cancellationPercentage,
	 		'hotel_id' 	             => $details[0]->hotel_id,
	 		'contract_id' 	         => $details[0]->contract_id,
	 		'application' 	         => $details[0]->application,
	 		'daysFrom'				 => $details[0]->daysFrom,
	 		'daysTo'				 => $details[0]->daysTo,
	 		'CreatedDate'   => date('Y-m-d H:i:s'),
			'CreatedBy'     => $this->session->userdata('id'),
			'Status' 		=> 'deleted'
		);
		$this->db->insert('hotel_tbl_cancellationfee_log',$dataLOG);
		//log entry end
		return true;
	}
	public function extrabed_delete($id) {
		$this->db->select('*');
		$this->db->from('hotel_tbl_extrabed');
		$this->db->where('id',$id);
		$details = $this->db->get()->result();
		$this->db->where('id',$id);
		$this->db->delete('hotel_tbl_extrabed');
		// Log entry start
		$dataLOG= array( 
				'id'			  => $id,
			 	'season' 	      => $details[0]->season,
			 	'from_date' 	  => $details[0]->from_date,
			 	'to_date' 	      => $details[0]->to_date,
			 	'hotel_id' 	  	  => $details[0]->hotel_id,
			 	'contract_id' 	  => $details[0]->contract_id,
			 	'amount' 	      => $details[0]->amount,
			 	'roomType' 	  	  => $details[0]->roomType,
 				'ChildAmount' 	  => $details[0]->ChildAmount,
				'ChildAgeFrom' 	  => $details[0]->ChildAgeFrom,
			 	'ChildAgeTo' 	  => $details[0]->ChildAgeTo,
			 	'CreatedDate'   => date('Y-m-d H:i:s'),
				'CreatedBy'     => $this->session->userdata('id'),
				'Status'		=> 'deleted'
				);
		$this->db->insert('hotel_tbl_extrabed_log',$dataLOG);
		//Log entry end
		return true;
	}
	public function extrabedList($hotel_id,$contract_id) {
		$this->db->select('hotel_tbl_extrabed.*,hotel_tbl_season.SeasonName');
		$this->db->from('hotel_tbl_extrabed');
		$this->db->join('hotel_tbl_season','hotel_tbl_season.id = hotel_tbl_extrabed.season','left');
        $this->db->where('hotel_tbl_extrabed.hotel_id',$hotel_id);
        $this->db->where('hotel_tbl_extrabed.contract_id',$contract_id);
        return $query=$this->db->get()->result();
	}
	public function extrabedsubmit($request) {
		$adultAmount = backend_Aed_convertion(hotel_currency_type($request['hotel_id']),$request['Amount']);
		if ($request['ChildAmount']!='' & $request['ChildAmount']!=0) {
			$childAmount = backend_Aed_convertion(hotel_currency_type($request['hotel_id']),$request['ChildAmount']);
		} else {
			$childAmount = 0;
		}
		

		$refreshCopyExbed = $this->Hotels_Model->linkedRefreshCopyExbed($request['contract_id'],'EXbedCopy');
		$implode_room_types = "";
    	if (isset($request['room_type'])) {
    		$implode_room_types = implode(",", $request['room_type']);
    	}

    	if (count($refreshCopyExbed)!=0) {
	    	if ($request['id']=="") {
	   	  		foreach ($refreshCopyExbed as $RCkey => $RCvalue) {
	   	  			if (isset($request['other_season'])) {
						$data= array( 
					 	'season' 	      => 'Other',
					 	'from_date' 	  => $request['fromDate'],
					 	'to_date' 	      => $request['toDate'],
					 	'hotel_id' 	  	  => $request['hotel_id'],
					 	'contract_id' 	  => $RCvalue->contract_id,
					 	'amount' 	      => $adultAmount,
					 	'roomType' 	  	  => $implode_room_types,
		 				'ChildAmount' 	  => $childAmount,
						'ChildAgeFrom' 	  => $request['ChildAgeFrom'],
					 	'ChildAgeTo' 	  => $request['ChildAgeTo'],
					 	'CreatedDate'   => date('Y-m-d H:i:s'),
		     			'CreatedBy'     => $this->session->userdata('id'),
						);
						$this->db->insert('hotel_tbl_extrabed',$data);

						// Log entry start
						$id = $this->db->insert_id();
						$dataLOG= array( 
						'id'			  => $id,
					 	'season' 	      => 'Other',
					 	'from_date' 	  => $request['fromDate'],
					 	'to_date' 	      => $request['toDate'],
					 	'hotel_id' 	  	  => $request['hotel_id'],
					 	'contract_id' 	  => $RCvalue->contract_id,
					 	'amount' 	      => $adultAmount,
					 	'roomType' 	  	  => $implode_room_types,
		 				'ChildAmount' 	  => $childAmount,
						'ChildAgeFrom' 	  => $request['ChildAgeFrom'],
					 	'ChildAgeTo' 	  => $request['ChildAgeTo'],
					 	'CreatedDate'   => date('Y-m-d H:i:s'),
		     			'CreatedBy'     => $this->session->userdata('id'),
		     			'Status'		=> 'inserted'
						);
						$this->db->insert('hotel_tbl_extrabed_log',$dataLOG);
						// Log entry end
					} else {
						foreach ($request['Season'] as $key => $value) {
							$this->db->select('*');
					    	$this->db->from('hotel_tbl_season');
					    	$this->db->where_in('id',$value);
					    	$query = $this->db->get()->result();
					    	$data= array( 
							 	'season' 	      => $value,
							 	'from_date' 	  => $query[0]->FromDate,
							 	'to_date' 	      => $query[0]->ToDate,
							 	'hotel_id' 	  	  => $request['hotel_id'],
							 	'contract_id' 	  => $RCvalue->contract_id,
							 	'amount' 	      => $adultAmount,
							 	'roomType' 	  	  => $implode_room_types,
				 				'ChildAmount' 	  => $childAmount,
								'ChildAgeFrom' 	  => $request['ChildAgeFrom'],
							 	'ChildAgeTo' 	  => $request['ChildAgeTo'],
							 	'CreatedDate'   => date('Y-m-d H:i:s'),
		     					'CreatedBy'     => $this->session->userdata('id'),
								);
								$this->db->insert('hotel_tbl_extrabed',$data);

								// Log entry start
								$id = $this->db->insert_id();
								$dataLOG= array( 
								'id'			  => $id,
							 	'season' 	      => $value,
							 	'from_date' 	  => $query[0]->FromDate,
							 	'to_date' 	      => $query[0]->ToDate,
							 	'hotel_id' 	  	  => $request['hotel_id'],
							 	'contract_id' 	  => $RCvalue->contract_id,
							 	'amount' 	      => $adultAmount,
							 	'roomType' 	  	  => $implode_room_types,
				 				'ChildAmount' 	  => $childAmount,
								'ChildAgeFrom' 	  => $request['ChildAgeFrom'],
							 	'ChildAgeTo' 	  => $request['ChildAgeTo'],
							 	'CreatedDate'   => date('Y-m-d H:i:s'),
		     					'CreatedBy'     => $this->session->userdata('id'),
		     					'Status'		=> 'inserted'
								);
								$this->db->insert('hotel_tbl_extrabed_log',$dataLOG);
								// Log entry end

					    	}
					}

				}
		  	}
	  	}
	
    	if ($request['id']!="") {
			$data= array( 
			 'season' 	     => $request['Season'],
			 'from_date'     => $request['fromDate'],
			 'to_date' 	     => $request['toDate'],
			 'amount' 	     => $adultAmount,
			 'roomType' 	 => $implode_room_types,
		 	 'ChildAmount' 	  => $childAmount,
			 'ChildAgeFrom' 	  => $request['ChildAgeFrom'],
			 'ChildAgeTo' 	  => $request['ChildAgeTo'],
			 'UpdatedDate'   => date('Y-m-d H:i:s'),
		     'UpdatedBy'     => $this->session->userdata('id'),
			);	
			$this->db->where('id',$request['id']);
			$this->db->update('hotel_tbl_extrabed',$data);

			// Log entry start
			$id = $request['id'];
			$dataLOG= array( 
			 'id'			  => $id,
		 	 'season' 	     => $request['Season'],
			 'from_date'     => $request['fromDate'],
			 'to_date' 	     => $request['toDate'],
			 'hotel_id' 	  => $request['hotel_id'],
			 'contract_id' 	  => $request['contract_id'],
			 'amount' 	     => $adultAmount,
			 'roomType' 	 => $implode_room_types,
		 	 'ChildAmount' 	  => $childAmount,
			 'ChildAgeFrom'   => $request['ChildAgeFrom'],
			 'ChildAgeTo' 	  => $request['ChildAgeTo'],
		 	 'CreatedDate'   => date('Y-m-d H:i:s'),
			 'CreatedBy'     => $this->session->userdata('id'),
			 'Status'		=> 'updated'
			);
			$this->db->insert('hotel_tbl_extrabed_log',$dataLOG);
			// Log entry end

    	} else {
  			if (isset($request['other_season'])) {
				$data= array( 
				 'season' 	      => 'Other',
				 'from_date' 	  => $request['fromDate'],
				 'to_date' 	      => $request['toDate'],
				 'hotel_id' 	  => $request['hotel_id'],
				 'contract_id' 	  => $request['contract_id'],
				 'amount' 	      => $adultAmount,
				 'roomType' 	  => $implode_room_types,
			 	 'ChildAmount' 	  => $childAmount,
				 'ChildAgeFrom' 	  => $request['ChildAgeFrom'],
				 'ChildAgeTo' 	  => $request['ChildAgeTo'],
				 'CreatedDate'   => date('Y-m-d H:i:s'),
		     	 'CreatedBy'     => $this->session->userdata('id'),
				);
				$this->db->insert('hotel_tbl_extrabed',$data);

				// Log entry start
				$id = $this->db->insert_id();
				$dataLOG= array( 
				 'id'			  => $id,
			 	 'season' 	      => 'Other',
				 'from_date' 	  => $request['fromDate'],
				 'to_date' 	      => $request['toDate'],
				 'hotel_id' 	  => $request['hotel_id'],
				 'contract_id' 	  => $request['contract_id'],
				 'amount' 	      => $adultAmount,
				 'roomType' 	  => $implode_room_types,
			 	 'ChildAmount' 	  => $childAmount,
				 'ChildAgeFrom'   => $request['ChildAgeFrom'],
				 'ChildAgeTo' 	  => $request['ChildAgeTo'],
				 'CreatedDate'   => date('Y-m-d H:i:s'),
		     	 'CreatedBy'     => $this->session->userdata('id'),
		     	 'Status'		=> 'inserted'
				);
				$this->db->insert('hotel_tbl_extrabed_log',$dataLOG);
				// Log entry end
			} else {
				foreach ($request['Season'] as $key => $value) {
					$this->db->select('*');
			    	$this->db->from('hotel_tbl_season');
			    	$this->db->where_in('id',$value);
			    	$query = $this->db->get()->result();
			    	$data= array( 
						 'season' 	      => $value,
					 	 'from_date' 	  => $query[0]->FromDate,
					 	 'to_date' 	      => $query[0]->ToDate,
						 'hotel_id' 	  => $request['hotel_id'],
						 'contract_id' 	  => $request['contract_id'],
						 'amount' 	      => $adultAmount,
						 'roomType' 	  => $implode_room_types,
					 	 'ChildAmount' 	  => $childAmount,
						 'ChildAgeFrom' 	  => $request['ChildAgeFrom'],
						 'ChildAgeTo' 	  => $request['ChildAgeTo'],
						 'CreatedDate'   => date('Y-m-d H:i:s'),
		     			 'CreatedBy'     => $this->session->userdata('id'),
						);
						$this->db->insert('hotel_tbl_extrabed',$data);

						// Log entry start
						$id = $this->db->insert_id();
						$dataLOG= array( 
						 'id'			  => $id,
					 	 'season' 	      => $value,
					 	 'from_date' 	  => $query[0]->FromDate,
					 	 'to_date' 	      => $query[0]->ToDate,
						 'hotel_id' 	  => $request['hotel_id'],
						 'contract_id' 	  => $request['contract_id'],
						 'amount' 	      => $adultAmount,
						 'roomType' 	  => $implode_room_types,
					 	 'ChildAmount' 	  => $childAmount,
						 'ChildAgeFrom' 	  => $request['ChildAgeFrom'],
						 'ChildAgeTo' 	  => $request['ChildAgeTo'],
						 'CreatedDate'   => date('Y-m-d H:i:s'),
		     			 'CreatedBy'     => $this->session->userdata('id'),
		     			 'Status'		=> 'inserted'
						);
						$this->db->insert('hotel_tbl_extrabed_log',$dataLOG);
						// Log entry end
			    	}
			}
    	}
		return true;
	}
	public function MinimumStayList($hotel_id,$contract_id) {
		$this->db->select('hotel_tbl_minimumstay.*,hotel_tbl_season.*,hotel_tbl_minimumstay.id as edit_id');
        $this->db->from('hotel_tbl_minimumstay');
        $this->db->join('hotel_tbl_season','hotel_tbl_season.id = hotel_tbl_minimumstay.season','left');
        $this->db->where('hotel_tbl_minimumstay.hotel_id',$hotel_id);
        $this->db->where('hotel_tbl_minimumstay.contract_id',$contract_id);
        return $query=$this->db->get();
	}
	public function MinimumStaySubmit($request) {
		$refreshCopymini = $this->Hotels_Model->linkedRefreshCopymini($request['contract_id'],'MiniCopy');
		if (count($refreshCopymini)!=0) {
    		if ($request['id']=="") {
	   	  		foreach ($refreshCopymini as $RCkey => $RCvalue) {
	   	  			if (isset($request['other_season'])) {
		    			$data= array( 
						 'season' 	     => 'Other',
						 'fromDate' 	 => $request['fromDate'],
						 'toDate' 	     => $request['toDate'],
						 'minDay' 	     => $request['minDay'],
						 'hotel_id' 	 => $request['hotel_id'],
						 'contract_id' 	 => $RCvalue->contract_id,
						 'CreatedDate'   => date('Y-m-d H:i:s'),
		     			 'CreatedBy'     => $this->session->userdata('id'),
						);
						$this->db->insert('hotel_tbl_minimumstay',$data);
						//Log entry start
						$id = $this->db->insert_id();
						$dataLOG= array( 
						 'id'			 => $id,
						 'season' 	     => 'Other',
						 'fromDate' 	 => $request['fromDate'],
						 'toDate' 	     => $request['toDate'],
						 'minDay' 	     => $request['minDay'],
						 'hotel_id' 	 => $request['hotel_id'],
						 'contract_id' 	 => $RCvalue->contract_id,
						 'CreatedDate'   => date('Y-m-d H:i:s'),
		     			 'CreatedBy'     => $this->session->userdata('id'),
		     			 'Status'		 => 'inserted'
						);
						$this->db->insert('hotel_tbl_minimumstay_log',$dataLOG);
						//Log entry end
					} else {
						foreach ($request['Season'] as $key => $value) {
							$this->db->select('*');
					    	$this->db->from('hotel_tbl_season');
					    	$this->db->where_in('id',$value);
					    	$query = $this->db->get()->result();
					    	$data= array( 
							 'season' 	     => $value,
							 'fromDate' 	 => $query[0]->FromDate,
							 'toDate' 	     => $query[0]->ToDate,
							 'minDay' 	     => $request['minDay'],
							 'hotel_id' 	 => $request['hotel_id'],
							 'contract_id' 	 => $RCvalue->contract_id,
							 'CreatedDate'   => date('Y-m-d H:i:s'),
		     				 'CreatedBy'     => $this->session->userdata('id'),
							);
							$this->db->insert('hotel_tbl_minimumstay',$data);
							//Log entry start
							$id = $this->db->insert_id();
							$dataLOG= array( 
							 'id'			 => $id,
							 'season' 	     => $value,
							 'fromDate' 	 => $query[0]->FromDate,
							 'toDate' 	     => $query[0]->ToDate,
							 'minDay' 	     => $request['minDay'],
							 'hotel_id' 	 => $request['hotel_id'],
							 'contract_id' 	 => $RCvalue->contract_id,
							 'CreatedDate'   => date('Y-m-d H:i:s'),
			     			 'CreatedBy'     => $this->session->userdata('id'),
			     			 'Status'		 => 'inserted'
							);
							$this->db->insert('hotel_tbl_minimumstay_log',$dataLOG);
							//Log entry end
				    	}
			    	}
				}
			}
		}


    	if ($request['id']!="") {
			$data= array( 
			 'season' 	  => $request['Season'],
			 'fromDate'   => $request['fromDate'],
			 'toDate' 	  => $request['toDate'],
			 'minDay' 	  => $request['minDay'],
			 'UpdatedDate'   => date('Y-m-d H:i:s'),
		     'UpdatedBy'     => $this->session->userdata('id'),
			);
			$this->db->where('id',$request['id']);
			$this->db->update('hotel_tbl_minimumstay',$data);
			//Log entry start
			$id = $request['id'];
			$dataLOG= array( 
			 'id'			 => $id,
			 'season' 	     => $request['Season'],
			 'fromDate' 	 => $request['fromDate'],
			 'toDate' 	     => $request['toDate'],
			 'minDay' 	     => $request['minDay'],
			 'hotel_id' 	 => $request['hotel_id'],
			 'contract_id' 	 => $request['contract_id'],
			 'CreatedDate'   => date('Y-m-d H:i:s'),
 			 'CreatedBy'     => $this->session->userdata('id'),
 			 'Status'		 => 'updated'
			);
			$this->db->insert('hotel_tbl_minimumstay_log',$dataLOG);
			//Log entry end
    	} else {
    		if (isset($request['other_season'])) {
    			$data= array( 
				 'season' 	     => 'Other',
				 'fromDate' 	 => $request['fromDate'],
				 'toDate' 	     => $request['toDate'],
				 'minDay' 	     => $request['minDay'],
				 'hotel_id' 	 => $request['hotel_id'],
				 'contract_id' 	 => $request['contract_id'],
				 'CreatedDate'   => date('Y-m-d H:i:s'),
		     	 'CreatedBy'     => $this->session->userdata('id'),
				);
				$this->db->insert('hotel_tbl_minimumstay',$data);
				//Log entry start
				$id = $this->db->insert_id();
				$dataLOG= array( 
				 'id'			 => $id,
				 'season' 	     => 'Other',
				 'fromDate' 	 => $request['fromDate'],
				 'toDate' 	     => $request['toDate'],
				 'minDay' 	     => $request['minDay'],
				 'hotel_id' 	 => $request['hotel_id'],
				 'contract_id' 	 => $request['contract_id'],
				 'CreatedDate'   => date('Y-m-d H:i:s'),
	 			 'CreatedBy'     => $this->session->userdata('id'),
	 			 'Status'		 => 'inserted'
				);
				$this->db->insert('hotel_tbl_minimumstay_log',$dataLOG);
				//Log entry end
			} else {
				foreach ($request['Season'] as $key => $value) {
					$this->db->select('*');
			    	$this->db->from('hotel_tbl_season');
			    	$this->db->where_in('id',$value);
			    	$query = $this->db->get()->result();
			    	$data= array( 
					 'season' 	     => $value,
					 'fromDate' 	 => $query[0]->FromDate,
					 'toDate' 	     => $query[0]->ToDate,
					 'minDay' 	     => $request['minDay'],
					 'hotel_id' 	 => $request['hotel_id'],
					 'contract_id' 	 => $request['contract_id'],
					 'CreatedDate'   => date('Y-m-d H:i:s'),
		     		 'CreatedBy'     => $this->session->userdata('id'),
					);
					$this->db->insert('hotel_tbl_minimumstay',$data);
					//Log entry start
					$id = $this->db->insert_id();
					$dataLOG= array( 
					 'id'			 => $id,
					 'season' 	     => $value,
					 'fromDate' 	 => $query[0]->FromDate,
					 'toDate' 	     => $query[0]->ToDate,
					 'minDay' 	     => $request['minDay'],
					 'hotel_id' 	 => $request['hotel_id'],
					 'contract_id' 	 => $request['contract_id'],
					 'CreatedDate'   => date('Y-m-d H:i:s'),
		 			 'CreatedBy'     => $this->session->userdata('id'),
		 			 'Status'		 => 'inserted'
					);
					$this->db->insert('hotel_tbl_minimumstay_log',$dataLOG);
					//Log entry end
		    	}
	    	}
			
    	}
		return true;
	}
	public function MinimumStayDetails($id) {
		$this->db->select('*');
        $this->db->from('hotel_tbl_minimumstay');
        $this->db->where('id',$id);
        return $query=$this->db->get()->result();
	}
	public function closeOutSingleUpdate($closedDate,$hotel_id,$contract_id,$room_id) {
		$this->db->select('*');
    	$this->db->from('hotel_tbl_contract');
    	$this->db->where('contract_id',$contract_id);
    	$contract_type = $this->db->get()->result();

		// if ($contract_type[0]->contract_type=="Main") {
			$this->db->select('*');
			$this->db->from('hotel_tbl_closeout_period');
	        $this->db->where('hotel_id',$hotel_id);
	        $this->db->where('contract_id',$contract_id);
	        $this->db->where('closedDate',$closedDate);
	        $final = $query=$this->db->get()->result();
	        if (count($final)==0) {
	        	$data= array( 
				 'hotel_id' 	  => $hotel_id,
				 'contract_id' 	  => $contract_id,
				 'closedDate' 	  => $closedDate,
				 'roomType' 	  => $room_id,
				 'CreatedDate'   => date('Y-m-d H:i:s'),
		     	 'CreatedBy'     => $this->session->userdata('id'),
				);
				$this->db->insert('hotel_tbl_closeout_period',$data);
				$id = $this->db->insert_id();
				// Log entry start
				$dataLOG= array( 
						'id'		=> $id,
					 	'hotel_id' 	  => $hotel_id,
						'contract_id' 	  => $contract_id,
						'closedDate' 	  => $closedDate,
					    'roomType' 	  => $room_id,
				        'CreatedBy' => $this->session->userdata('id'),
				  		'CreatedDate' => date('Y-m-d H:i:s'),
				  		'Status' 	 => 'close'
				);
				$this->db->insert('hotel_tbl_closeout_period_log',$dataLOG);
				// Log entry end
	        } else {
	        	$exploderoomType = explode(",", $final[0]->roomType);
	        	foreach ($exploderoomType as $key => $value) {
	        		if ($value!=$room_id) {
	        			$implodeData[$key] = $value; 
	        		} else {
	        			$implodeData[$key] = $value; 
	        		}
	        	}
	        	$implodeRoomType = implode(",", $implodeData).",".$room_id;

	        	$data1= array( 
				 'roomType' 	  => $implodeRoomType,
				 'UpdatedDate'   => date('Y-m-d H:i:s'),
		     	 'UpdatedBy'     => $this->session->userdata('id'),
				);

				$this->db->where('hotel_id',$hotel_id);
	        	$this->db->where('contract_id',$contract_id);
	        	$this->db->where('closedDate',$closedDate);
				$this->db->update('hotel_tbl_closeout_period',$data1);
				// Log entry start
				$dataLOG= array( 
					 	'hotel_id' 	  => $hotel_id,
						'contract_id' 	  => $contract_id,
						'closedDate' 	  => $closedDate,
					    'roomType' 	  => $implodeRoomType,
				        'CreatedBy' => $this->session->userdata('id'),
				  		'CreatedDate' => date('Y-m-d H:i:s'),
				  		'Status' 	 => 'close'
				);
				$this->db->insert('hotel_tbl_closeout_period_log',$dataLOG);
				// Log entry end
	        }
    	// }
        return true;
	}
	public function closeOutSingleDelete($closedDate,$hotel_id,$contract_id,$room_id) {
		$this->db->select('*');
    	$this->db->from('hotel_tbl_contract');
    	$this->db->where('hotel_id',$hotel_id);
    	$this->db->where('contract_id',$contract_id);
    	$contract_type = $this->db->get()->result();
		// if ($contract_type[0]->contract_type=="Main") {
			$this->db->select('*');
			$this->db->from('hotel_tbl_closeout_period');
	        $this->db->where('hotel_id',$hotel_id);
	        $this->db->where('contract_id',$contract_id);
	        $this->db->where('closedDate',$closedDate);
	        $query = $this->db->get()->result();

	        if (count($query)!=0) {
	        	if ($query[0]->roomType==$room_id) {
	        		$this->db->from('hotel_tbl_closeout_period');
			        $this->db->where('hotel_id',$hotel_id);
			        $this->db->where('contract_id',$contract_id);
			        $this->db->where('closedDate',$closedDate);
					$this->db->delete('hotel_tbl_closeout_period');
					// Log entry start
					$dataLOG= array( 
						 	'hotel_id' 	  => $hotel_id,
							'contract_id' 	  => $contract_id,
							'closedDate' 	  => $closedDate,
						    'roomType' 	  => $room_id,
					        'CreatedBy' => $this->session->userdata('id'),
					  		'CreatedDate' => date('Y-m-d H:i:s'),
					  		'Status' 	 => 'open'
					);
					$this->db->insert('hotel_tbl_closeout_period_log',$dataLOG);
					// Log entry end

	        	} else {
	        		$exploderoomType = explode(",", $query[0]->roomType);
	        		foreach ($exploderoomType as $key => $value) {
		        		if ($value!=$room_id) {
		        			$implodeData[$key] = $value; 
		        		} 
		        	}
		        	$implodeRoomType = implode(",", $implodeData);
		        	$data1= array( 
					 'roomType' 	  => $implodeRoomType,
					);

					$this->db->where('hotel_id',$hotel_id);
		        	$this->db->where('contract_id',$contract_id);
		        	$this->db->where('closedDate',$closedDate);
					$this->db->update('hotel_tbl_closeout_period',$data1);
					// Log entry start
					$dataLOG= array( 
						 	'hotel_id' 	  => $hotel_id,
							'contract_id' 	  => $contract_id,
							'closedDate' 	  => $closedDate,
						    'roomType' 	  => $implodeRoomType,
					        'CreatedBy' => $this->session->userdata('id'),
					  		'CreatedDate' => date('Y-m-d H:i:s'),
					  		'Status' 	 => 'close'
					);
					$this->db->insert('hotel_tbl_closeout_period_log',$dataLOG);
					// Log entry end
	        	}
	        }
		// }
        return true;
	}
	public function MinimumStay_delete($id) {
		$this->db->select('*');
		$this->db->from('hotel_tbl_minimumstay');
        $this->db->where('id',$id);
		$details=$this->db->get()->result();
		$this->db->where('id',$id);
		$this->db->delete('hotel_tbl_minimumstay');
		// Log entry start
		$dataLOG= array( 
				 'id'			 => $id,
				 'season' 	     => $details[0]->season,
				 'fromDate' 	 => $details[0]->fromDate,
				 'toDate' 	     => $details[0]->toDate,
				 'minDay' 	     => $details[0]->minDay,
				 'hotel_id' 	 => $details[0]->hotel_id,
				 'contract_id' 	 => $details[0]->contract_id,
				 'CreatedDate'   => date('Y-m-d H:i:s'),
	 			 'CreatedBy'     => $this->session->userdata('id'),
	 			 'Status'		 => 'deleted'
				);
		$this->db->insert('hotel_tbl_minimumstay_log',$dataLOG);
		//Log entry end
		return true;
	}
	public function contractPermission($contract_id,$permission) {
		$data= array( 
			 'contract_flg' 	  => $permission,
			);
		$this->db->where('contract_id',$contract_id);
		$this->db->update('hotel_tbl_contract',$data);
		return true;
	}
	public function closedout_check($hotel_id,$con_id){
		$this->db->select('*');
		$this->db->from('hotel_tbl_closeout_period');
        $this->db->where('hotel_id',$hotel_id);
        $this->db->where('contract_id',$con_id);
		$query=$this->db->get();
        return $query->result();
	}
	public function update_contract_policies($hotel_id,$contract_id,$request) {
		$this->db->select('*');
		$this->db->from('hotel_tbl_policies');
		$this->db->where('hotel_id',$hotel_id);
		$this->db->where('contract_id',$contract_id);
		$result = $this->db->get()->result();
		if (count($result)==0) {
			$data= array( 
        	      'hotel_id'        			=>  $hotel_id,
        	      'contract_id'        			=>  $contract_id,
        	      'Important_Remarks_Policies' 	=>  $request['imp_remarks'],
        	      'Important_Notes_Conditions'  =>  $request['imp_notes'],
        	      'cancelation_policy'      	=>  $request['cancel_policy'],
		      	  'Created_Date'  				=> date('Y-m-d'),
		      	  'Created_By'  				=> $this->session->userdata('id'),
		      	);
			$this->db->insert('hotel_tbl_policies',$data);
		} else {
	    	$data= array( 
	        	      'Important_Remarks_Policies' =>  $request['imp_remarks'],
	        	      'Important_Notes_Conditions' =>  $request['imp_notes'],
	        	      'cancelation_policy'         =>  $request['cancel_policy'],
			      	  'Updated_Date'  			   => date('Y-m-d'),
			      	  'Updated_By'  			   => $this->session->userdata('id'),
			      	);
	       	$this->db->where('hotel_id',$hotel_id);
			$this->db->where('contract_id',$contract_id);
			$this->db->update('hotel_tbl_policies',$data);
		}
		return true;
		// print_r($data);
		// exit();
    }
    public function menu_checkbox_modal_on($val,$id){
		$data= array( 
		'edit_profile' => $val,
		//'rates' => $val2,
		);
		$this->db->where('id',$id);
		$result = $this->db->update('hotel_tbl_hotels',$data);
		return true;	
	}
	public function roomAminitiesList() {
		$this->db->select('*');
		$this->db->from('hotel_tbl_roomaminities');
		return $this->db->get();
	}
	public function roomAminitieSubmit($request) {
		if ($request['id']!="") {
			$data= array( 
        	      'Aminities'        			=>  $request['roomAminitie'],
		      	  'updatedDate'  				=> date('Y-m-d'),
		      	  'updatedBy'  				=> $this->session->userdata('name'),
		      	);
			$this->db->where('id',$request['id']);
			$this->db->update('hotel_tbl_roomaminities',$data);
		} else {
			$data= array( 
        	      'Aminities'        			=>  $request['roomAminitie'],
		      	  'createdDate'  				=> date('Y-m-d'),
		      	  'createdBy'  				=> $this->session->userdata('name'),
		      	);
			$this->db->insert('hotel_tbl_roomaminities',$data);
		}
	}
	public function roomAminitiesdeails($id) {
		$this->db->select('*');
		$this->db->from('hotel_tbl_roomaminities');
		$this->db->where('id',$id);
		return $this->db->get()->result();
	}
	public function delete_roomAminities($id) {
		$this->db->where('id',$id);
		$this->db->delete('hotel_tbl_roomaminities');
		return true;
	}
	public function seasonListMax($hotel_id,$contract_id) {
		$query = $this->db->query('SELECT Max(ToDate) as ToDate , Min(FromDate) as FromDate FROM hotel_tbl_season WHERE  hotel_id = "'.$hotel_id.'" AND  contract_id = "'.$contract_id.'"')->result();
		return $query;
	}
	public function maincontractCheck($request) {
		$this->db->select('*');
		$this->db->from('hotel_tbl_contract');
		if ($request['contract_id']!="") {
			$this->db->where('contract_id != ',$request['contract_id']);
		}
		$this->db->where('contract_type','Main');
		$this->db->where('hotel_id',$request['hotel_id']);
		return $this->db->get()->result();
	}
	public function linkedContractGet($contract_id) {

		if ($contract_id!="" && $contract_id!=0) {
			$this->db->select('*');
			$this->db->from('hotel_tbl_contract');
			$this->db->where('id',$contract_id);
			$query =  $this->db->get()->result();
			if (count($query)!=0) {
				return $query[0]->contract_id;
			} else {
				return "";
			}
		} else {
			return "";
		}
	}
	public function hotel_maincontract_list($hotel_id) {
		$this->db->select('*');
        $this->db->from('hotel_tbl_contract');
        $this->db->where('hotel_id',$hotel_id);
        $this->db->where('contract_type','Main');
        $this->db->where('to_date >',date('Y-m-d', strtotime('-1 days')));
        $this->db->group_by('contract_id');
        $query=$this->db->get();
        return $query->result();
	}
	public function SalePermission($val3,$id,$conId){
		$data= array( 
		'sale_availability' => $val3,
		//'rates' => $val2,
		);
		$this->db->where('hotel_id',$id);
		$this->db->where('contract_id',$conId);
		$result = $this->db->update('hotel_tbl_contract',$data);
		return true;	
	}
	public function editPermission($val,$id,$conId) {
		$data= array( 
		'edit_rate' => $val,
		);
		$this->db->where('hotel_id',$id);
		$this->db->where('contract_id',$conId);
		$result = $this->db->update('hotel_tbl_contract',$data);
		return true;	
	}
	public function cancellationPolicySelect($request) {
		$this->db->select('hotel_tbl_cancellationfee.*,IF(hotel_tbl_season.SeasonName IS NULL,hotel_tbl_cancellationfee.season,hotel_tbl_season.SeasonName) as SeasonName');
        $this->db->from('hotel_tbl_cancellationfee');
        $this->db->join('hotel_tbl_season' ,'hotel_tbl_season.id = hotel_tbl_cancellationfee.season','left');
        $this->db->where('hotel_tbl_cancellationfee.hotel_id',$request['hotel_id']);
        $this->db->where('hotel_tbl_cancellationfee.contract_id',$request['contract_id']);
        $query=$this->db->get();
        return $query->result();
	}
	public function CancellationPolicyContentget($request) {
		$this->db->select('*');
        $this->db->from('hotel_tbl_cancellationfee');
        $this->db->where('hotel_id',$request['hotel_id']);
        $this->db->where('contract_id',$request['contract_id']);
        $this->db->where('id',$request['id']);
        $query=$this->db->get()->result();
        return $query[0];
	}


	public function deleteHotelPer($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('hotel_tbl_hotels');
		return true;
	}
	public function GetTitle(){
		$this->db->select('*');
        $this->db->from('hotel_tbl_general_settings');
        $query=$this->db->get()->result();
        return $query;

	}
	public function HotelPanelallotBlkupdate($request) {
    	$start_date=date_create($request['bulk-alt-fromDate']);
        $end_date=date_create($request['bulk-alt-toDate']);
        $no_of_days=date_diff($start_date,$end_date);
        $tot_days = $no_of_days->format("%a");

        if (isset($request['bulk_alt_contract_id'])) {

	        if (isset($request['bulk-alt-room_id'])) {
	        	
		        foreach ($request['bulk-alt-room_id'] as $key => $value) {
		        	for($i = 0; $i <= $tot_days; $i++) {
				       $result[$i]= date('Y-m-d', strtotime($request['bulk-alt-fromDate']. ' + '.$i.'  days'));
				      	$this->db->select('*');
				      	$this->db->from('hotel_tbl_allotement');
				    	$this->db->where('room_id',$value);
				    	$this->db->where('hotel_id',$request['hotel_id']);
				    	$this->db->where('allotement_date',$result[$i]);
				    	$this->db->where('contract_id',$request['bulk_alt_contract_id']);
				    	$query=$this->db->get();
			        	$query_out[$i] = $query->result();
			    		if (count($query_out[$i])!=0) {
			    			
					    	if ($request['bulk-alt-amount']!="") {
					    		$data['amount'] =  $request['bulk-alt-amount'];
					    	}
					    	if (isset($request['bulk-alt-allotment']) && $request['bulk-alt-allotment']!="") {
					    		$data['allotement'] =  $request['bulk-alt-allotment'];
					    	}
					    	if (isset($request['bulk-alt-cut-off']) && $request['bulk-alt-cut-off']!="") {
					    		$data['cut_off'] =  $request['bulk-alt-cut-off'];
					    	}
					    	
					    	if ($request['bulk-alt-amount']!="" || isset($request['bulk-alt-allotment']) ||  isset($request['bulk-alt-cut-off'])) {
					    	
					    		$this->db->where('contract_id',$request['bulk_alt_contract_id']);
					    		$this->db->where('room_id',$value);
					    		$this->db->where('hotel_id',$request['hotel_id']);
					    		$this->db->where('allotement_date',$query_out[$i][0]->allotement_date);
					    		$this->db->update('hotel_tbl_allotement',$data);
			    			}
				    	} else {
				    		$data1 = array(
				    					  'amount'         => $request['bulk-alt-amount'],
				    					  'allotement_date'=> $result[$i],
				    					  'room_id'        => $value,
				    					  'hotel_id'       => $request['hotel_id'],
			    						  'contract_id'    => $request['bulk_alt_contract_id'],
			    						  'allotement'     => $request['bulk-alt-allotment'],
			    						  'cut_off'        => $request['bulk-alt-cut-off'],
			    						  'CreatedDate'    => date('Y-m-d H:i:s'),
			    						  'CreatedBy'      => $this->session->userdata('id')
				    		);
				    		$this->db->insert('hotel_tbl_allotement',$data1);
				    	}

				    }
		        }
	        }
	    }
        $start1_date=date_create($request['bulk-alt-fromDate']);
	        $end1_date=date_create($request['bulk-alt-toDate']);
	        $no_of_days1=date_diff($start_date,$end_date);
	        $tot_days1 = $no_of_days1->format("%a");
        	for($i = 0; $i <= $tot_days1; $i++) {
		       $result1[$i]= date('Y-m-d', strtotime($request['bulk-alt-fromDate']. ' + '.$i.'  days'));
	        }
	    if(isset($request['bulk_alt_contract_id'])){
		    if (isset($request['bulk-alt-closedout'])){
		        foreach ($result1 as $key1 => $value1) {
		        	$implode_room_types = "";
	    			if (isset($request['bulk-alt-room_id'])) {
	    					$implode_room_types = implode(",", $request['bulk-alt-room_id']);
	    			}
		        	$this->db->select('*');
		        	$this->db->from('hotel_tbl_closeout_period');
					$this->db->where('closedDate',$value1);
					$this->db->where('hotel_id',$request['hotel_id']);
					$this->db->where('contract_id',$request['bulk_alt_contract_id']);
	      	  		$query1[$key1]=$this->db->get()->result();
	      	  		if (count($query1[$key1])!=0) {
	  	  				$data= array('reason'     => "",
	  	  							'roomType'	  => $implode_room_types,
	  	  							'UpdatedDate' => date('Y-m-d H:i:s'),
	  	  							'UpdatedBy'   => $this->session->userdata('id')
						        );
						$this->db->where('closedDate',$value1);
						$this->db->where('hotel_id',$request['hotel_id']);
						$this->db->where('contract_id',$request['bulk_alt_contract_id']);
						$this->db->update('hotel_tbl_closeout_period',$data);
	      	  		} else {
	      	  			$data= array( 'hotel_id'   	 => $request['hotel_id'],
							          'contract_id'  => $request['bulk_alt_contract_id'],
							          'closedDate'   => $value1,
							          'reason'       => "",
							          'roomType'	  => $implode_room_types,
							          'delflg'       => 1,
							          'CreatedDate'  => date('Y-m-d H:i:s'),
							          'CreatedBy'    => $this->session->userdata('id')
							        );
						$this->db->insert('hotel_tbl_closeout_period',$data);
	      	  		}
		        }
		    }
	    else {
	    	foreach ($result1 as $key1 => $value1) {
	        	$this->db->select('*');
	        	$this->db->from('hotel_tbl_closeout_period');
				$this->db->where('closedDate',$value1);
				$this->db->where('hotel_id',$request['hotel_id']);
				$this->db->where('contract_id',$request['bulk_alt_contract_id']);
      	  		$query1[$key1]=$this->db->get()->result();
      	  		if (count($query1[$key1])!=0) {
      	  			$explodeCoRR = explode(",", $query1[$key1][0]->roomType);
      	  			$arr_1 = array_diff($explodeCoRR,$request['bulk-alt-room_id']);
      	  			if (count($arr_1)!=0) {
      	  				$implodeCoRR = implode(",", $arr_1);
	      	  				$data= array('roomType'   	 => $implodeCoRR,
							          'reason'     	 => "",
							          'UpdatedDate'	 => date('Y-m-d H:i:s'),
							          'UpdatedBy'    => $this->session->userdata('id')
						        );
						$this->db->where('closedDate',$value1);
						$this->db->where('hotel_id',$request['hotel_id']);
						$this->db->where('contract_id',$request['bulk_alt_contract_id']);
						$this->db->update('hotel_tbl_closeout_period',$data);
      	  			} else {
      	  				$this->db->where('closedDate',$value1);
						$this->db->where('hotel_id',$request['hotel_id']);
						$this->db->where('contract_id',$request['bulk_alt_contract_id']);
						$this->db->delete('hotel_tbl_closeout_period');
      	  			}
      	  		}
	        }
	    }
	}
    return true;
    }
    public function hotelPanelallot_update($alotement_date,$room_id,$hotel_id,$price,$alotement,$cut_off,$contract_id) {

		$this->db->select('*');
		$this->db->from('hotel_tbl_allotement');
		$this->db->where('hotel_id',$hotel_id);
		$this->db->where('room_id',$room_id);
		$this->db->where('contract_id',$contract_id);
		$this->db->where('allotement_date',$alotement_date);
	    $query=$this->db->get();
		$final = $query->result();
		if (count($final)!=0) {
			$data1= array( 
						'amount'     => $price,
					    'allotement' => $alotement,
					    'cut_off'    => $cut_off,
	        );
	       
			$this->db->where('contract_id',$contract_id);
			$this->db->where('hotel_id',$hotel_id);
			$this->db->where('room_id',$room_id);
			$this->db->where('allotement_date',$alotement_date);
			$this->db->update('hotel_tbl_allotement',$data1);
		} else {
			$data= array( 'room_id'  		=> $room_id,
				          'hotel_id'    	=> $hotel_id,
				          'allotement_date' => $alotement_date,
				          'amount'     		=> $price,
				          'allotement'     	=> $alotement,
					      'cut_off' 		=> $cut_off,
				          'contract_id' 	=> $contract_id
	        );
	        // print_r($data);
	        // exit();
			$this->db->insert('hotel_tbl_allotement',$data);
		}
		return true;
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
    public function getExtrabedDetails($book_id){
    $this->db->select('*');
    $this->db->from('bookingextrabed');
    $this->db->where('bookID',$book_id);
    $query = $this->db->get();
    return $query->result();
  	}
	public function ChangeHotelPassword($cpassword,$npassword,$email) {
		$this->db->select('id');
		$this->db->from('hotel_tbl_user');
		$this->db->where('Email',$email);
		$this->db->where('Password',md5($cpassword));
		$query = $this->db->get()->result();
		if (count($query)!=0) {
			$data= array(
			'Password' 		 => md5($npassword),
			'password_reset' => '0',
			'Updated_Date' 	 => date('Y-m-d'),
			);
			$this->db->where('Email',$email);
			$this->db->update('hotel_tbl_user',$data);
			$msg = 'success';
		} else {
			$msg = 'is incorrect';
		}
		return $msg;
	}
    public function ChangeHotelPasswordCancel($email) {
        $data= array(
                  'password_reset' 	=> "0",
                  'Updated_Date' 	=> date('Y-m-d'),
                     );
        $this->db->where('Email',$email);
        $this->db->update('hotel_tbl_user',$data);
        return true;
    }
    public function refreshCopy($contract_id,$refcopy) {
		$data= array( 
			 'refCopy' 	  => $refcopy,
			);
		$this->db->where('contract_id',$contract_id);
		$this->db->update('hotel_tbl_contract',$data);
		return true;
	}
	public function RefreshCopyUpdate($boardCheck,$conid,$generalCheck,$exbedCheck,$cancelCheck,$minimumCheck) {
		$data = array(
					  'BoardCopy'			=> $boardCheck, 
					  'GenCopy' 			=> $generalCheck, 
					  'EXbedCopy'			=> $exbedCheck,
					  'CancelCopy'			=> $cancelCheck,
					  'MiniCopy'			=> $minimumCheck,
					);
		$this->db->where('contract_id',$conid);
		$result = $this->db->update('hotel_tbl_contract',$data);
		return $result; 
	}
	public function linkedRefreshCopyContract($conid,$permission) {
		$contract_id = substr($conid, 4);
		$this->db->select('*');
		$this->db->from('hotel_tbl_contract');
		$this->db->where('linkedContract',$contract_id);
		$this->db->where('contract_type','Sub');
		$this->db->where($permission,1);
		$query = $this->db->get()->result();
		return $query;
	}
	public function linkedRefreshCopyGen($conid,$perGeneral) {
		$contract_id = substr($conid, 4);
		$this->db->select('*');
		$this->db->from('hotel_tbl_contract');
		$this->db->where('linkedContract',$contract_id);
		$this->db->where('contract_type','Sub');
		$this->db->where($perGeneral,1);
		$query = $this->db->get()->result();
		return $query;
	}
	public function linkedRefreshCopyExbed($conid,$perExbed){
		$contract_id = substr($conid, 4);
		$this->db->select('*');
		$this->db->from('hotel_tbl_contract');
		$this->db->where('linkedContract',$contract_id);
		$this->db->where('contract_type','Sub');
		$this->db->where($perExbed,1);
		$query = $this->db->get()->result();
		return $query;

	}
	public function linkedRefreshCopyCancel($conid,$perCancel){
		$contract_id = substr($conid, 4);
		$this->db->select('*');
		$this->db->from('hotel_tbl_contract');
		$this->db->where('linkedContract',$contract_id);
		$this->db->where('contract_type','Sub');
		$this->db->where($perCancel,1);
		$query = $this->db->get()->result();
		return $query;

	}
	public function linkedRefreshCopymini($conid,$permini){
		$contract_id = substr($conid, 4);
		$this->db->select('*');
		$this->db->from('hotel_tbl_contract');
		$this->db->where('linkedContract',$contract_id);
		$this->db->where('contract_type','Sub');
		$this->db->where($permini,1);
		$query = $this->db->get()->result();
		return $query;

	}
	public function hotel_select() {
	    $this->db->select('*');
        $this->db->from('hotel_tbl_hotels');
        $this->db->where('delflg',1);
        $this->db->order_by('id','desc');
        $query=$this->db->get();
        return $query->result();
    }
	public function SelectContract($request){
		$data['contract_id'] = array();
		$hotel = explode(",", $request['hotel']);
		$agreement =  $request['con_agreement'];
    	foreach ($hotel as $key => $hotel_id) {
    		$this->db->select('hotel_tbl_contract.contract_id,hotel_tbl_hotels.hotel_name,hotel_tbl_contract.id,hotel_tbl_contract.board');
        	$this->db->from('hotel_tbl_contract');
        	$this->db->join('hotel_tbl_hotels','hotel_tbl_hotels.id = hotel_tbl_contract.hotel_id','left');
        	$this->db->where('hotel_tbl_contract.hotel_id',$hotel_id);
        	$this->db->where('hotel_tbl_contract.to_date >',date('Y-m-d', strtotime('-1 days')));
        	if ($agreement!="") {
        		$this->db->where('hotel_tbl_contract.contract_agreement',$agreement);
        	}
        	$query=$this->db->get()->result();
        	// echo $this->db->last_query();exit;

        	if (count($query)!=0) {
        		foreach ($query as $CGkey => $Cgvalue) {
        			// $data['hotel_name'][] = $Cgvalue->hotel_name;
        			$data['contract_id'][$Cgvalue->hotel_name][] = $Cgvalue->contract_id;
        			$data['board'][$Cgvalue->hotel_name][] = $Cgvalue->board;
        		}
        	}

    	}
    	$dropdown = '';
    	if (count($data['contract_id'])!=0) {
    		foreach ($data['contract_id'] as $CVGkey => $CVGvalue) {
    			$dropdown .= '<optgroup label="'.$CVGkey.'">';
    				foreach ($CVGvalue as $Conkey => $Convalue) {
    					$dropdown .= '<option value="'.$Convalue.'">'.$Convalue.'-'.$data['board'][$CVGkey][$Conkey].'</option>';
    				}
    			$dropdown .= '</optgroup>';
    		}
    	}
    	return $dropdown;
    }
    public function SelectRoom($request){
    	$dropdown = "";
		$data['room_type'] = array();
		$data['room_id'] = array();
		$hotelid = array();
		$contract = explode(",", $request['contract_id']);
		$ImpContract = array();
    	foreach ($contract as $key => $contract_id) {
    		$ImpContract[$key] = $contract_id; 
    	}

    	$implode_contracts = implode("','", $ImpContract);
    	

    	$contractList  = $this->db->query("SELECT hotel_id FROM hotel_tbl_contract WHERE contract_id IN ('".$implode_contracts."')")->result();
    	
    	if (count($contractList) !=0) {
    		$hotelid = array();
	    	foreach ($contractList as $CLkey => $CLvalue) {
	    		$hotelid[] = $CLvalue->hotel_id;
	    	}
	    	$hotel_id = array_unique($hotelid);
	    	foreach ($hotel_id as $Hotelkey => $Hotelvalue) {
	    		$this->db->select('hotel_tbl_hotel_room_type.room_name,hotel_tbl_room_type.Room_Type,hotel_tbl_hotel_room_type.id,hotel_tbl_hotels.hotel_name');
		        $this->db->from('hotel_tbl_hotel_room_type');
		        $this->db->join('hotel_tbl_hotels','hotel_tbl_hotels.id = hotel_tbl_hotel_room_type.hotel_id','left');
		        $this->db->join('hotel_tbl_room_type','hotel_tbl_room_type.id = hotel_tbl_hotel_room_type.room_type','left');
		        $this->db->where('hotel_tbl_hotel_room_type.hotel_id',$Hotelvalue);
        		$query[$Hotelkey]=$this->db->get()->result();
	    	}
    	}
		if (count($query)!=0) {
			foreach ($query as $RGkey => $Rgvalue) {
				foreach ($Rgvalue as $RGfkey => $RGfvalue) {
					$data['id'][$RGfvalue->hotel_name][] = $RGfvalue->room_name." ".$RGfvalue->Room_Type;
					$data['hotelid'][$RGfvalue->hotel_name][]  = $RGfvalue->id;	
				}
			}
		}
        	
    	$dropdown = '';
    	if (count($data['id'])!=0) {
    		foreach ($data['id'] as $RVGkey => $RVGvalue) {
    			$dropdown .= '<optgroup label="'.$RVGkey.'">';
    				foreach ($RVGvalue as $Roomkey => $Roomvalue) {
    					$dropdown .= '<option value="'.$data['hotelid'][$RVGkey][$Roomkey].'">'.$Roomvalue.'</option>';
    				}
    				
    			$dropdown .= '</optgroup>';
    		}
    	}

    	return $dropdown;
    }
    public function DiscountSubmit($request) {
    	if (isset($request['NonRefundable'])) {
    		$NonRefundable = 1;
    	} else {
    		$NonRefundable = 0;
    	}
    	$BlackDate = "";
    	$Extrabed = 0;
    	$General = 0;
    	$Board = 0;
    	if (isset($request['Extrabed'])) {
    		$Extrabed = 1;
    	}
    	if (isset($request['General'])) {
    		$General = 1;
    	}
    	if (isset($request['Board'])) {
    		$Board = 1;
    	}
    	if (isset($request['BlackDate']) && count($_REQUEST['BlackDate'])!=0) {
    		$BlackDate = implode(",", $_REQUEST['BlackDate']);
    	}
		if ($request['disEdit']=="") {
			$data= array( 
        	      'hotelid'    =>  $request['hoteltext'],
        	      'contract'   =>  $request['context'],
        	      'room' 	   =>  $request['roomtext'],
        	      'BkFrom'     =>  $request['from_date'],
        	      'BkTo'       =>  $request['to_date'],
		      	  'Styfrom'    =>  $request['stay1'],
		      	  'Styto'  	   =>  $request['stay2'],
		      	  'numofnights' => $request['numofnights'],
		      	  'stay_night' => $request['stay_night'],
		      	  'pay_night' =>$request['pay_night'],
		      	  'discount_type' => $request['discount_type'],
		      	  'Bkbefore'   =>  $request['bookBefore'],
        	      'discount'   =>  $request['discount'],
        	      'NonRefundable' => $NonRefundable,
        	      'Extrabed' => $Extrabed,
        	      'General' => $General,
        	      'Board' => $Board,
        	      'BlackOut' => $BlackDate,
        	      'discountCode' => $request['discountCode'],
        	      'discount_type' => $request['discount_type'],
        	      'stay_night' => $request['stay_night'],
        	      'pay_night' => $request['pay_night'],
        	      'Created_Date' => date('Y-m-d H:i:s'),
        	      'Created_By' => $this->session->userdata('id'),
		      	);
			$this->db->insert('hoteldiscount',$data);
			return $this->db->insert_id();
		
		} else {
	    	$data= array( 
        	      'hotelid'    =>  $request['hoteltext'],
        	      'contract'   =>  $request['context'],
        	      'room' 	   =>  $request['roomtext'],
        	      'BkFrom'     =>  $request['from_date'],
        	      'BkTo'       =>  $request['to_date'],
		      	  'Styfrom'    =>  $request['stay1'],
		      	  'Styto'  	   =>  $request['stay2'],
		      	  'numofnights' => $request['numofnights'],
		      	  'stay_night' => $request['stay_night'],
		      	  'pay_night' =>$request['pay_night'],
		      	  'discount_type' => $request['discount_type'],
		      	  'Bkbefore'   =>  $request['bookBefore'],
        	      'discount'   =>  $request['discount'],
        	      'NonRefundable' => $NonRefundable,
        	      'BlackOut' => $BlackDate,
        	      'Extrabed' => $Extrabed,
        	      'General' => $General,
        	      'Board' => $Board,
        	      'discountCode' => $request['discountCode'],
        	      'discount_type' => $request['discount_type'],
        	      'stay_night' => $request['stay_night'],
        	      'pay_night' => $request['pay_night'],
        	      'Updated_Date' => date('Y-m-d H:i:s'),
        	      'Updated_By' => $this->session->userdata('id'),
		      	);
	       	$this->db->where('id',$request['disEdit']);
			$this->db->update('hoteldiscount',$data);
			return true;
		}		
    }
    public function selectDiscount($filter){
    	if ($filter==1) {
    		$this->db->select('*');
        	$this->db->from('hoteldiscount');
        	$this->db->where('Styto >',date('Y-m-d'));
        	$query=$this->db->get();
    	} else {
    		$this->db->select('*');
        	$this->db->from('hoteldiscount');
        	$this->db->where('Styto <',date('Y-m-d'));
        	$query=$this->db->get();
    	}
       	return $query;
    }
    public function gethotelname($hotel){
    	$hotel_name = "";
    	$this->db->select('hotel_tbl_hotels.hotel_name');
        $this->db->from('hotel_tbl_hotels');
       	$this->db->where('id',$hotel);
       	$query=$this->db->get()->result();
       	if (count($query)!=0) {
       		$hotel_name  = $query[0]->hotel_name;
       	}
       	return $hotel_name;
    }
    public function getroomname($room){
    	$room_name = "";
    	$this->db->select('hotel_tbl_hotel_room_type.room_name');
        $this->db->from('hotel_tbl_hotel_room_type');
       	$this->db->where('id',$room);
       	$query=$this->db->get()->result();
       	if (count($query)!=0) {
       		$room_name  = $query[0]->room_name;
       	}
       	return $room_name;
    }
    public function getcontractName($contract_id) {
    	$contractName = "";
    	$this->db->select('hotel_tbl_contract.contract_id,hotel_tbl_contract.board');
        $this->db->from('hotel_tbl_contract');
       	$this->db->where('contract_id',$contract_id);
       	$query=$this->db->get()->result();
       	if (count($query)!=0) {
       		$contractName  = $query[0]->contract_id.'-'.$query[0]->board;
       	}
       	return $contractName;
    }
    public function hoteldiscountEdit($id) {
    	$this->db->select('*');
		$this->db->from('hoteldiscount');
		$this->db->where('id',$id);
	    $query=$this->db->get();
		return $query->result();
	}
	public function discountDelete($id) {
		$this->db->where('id',$id);
		$this->db->delete('hoteldiscount');
		return true;
	}
	public function roomName($id){
		$query = array();
		$roomid = explode(",", $id);
    	foreach ($roomid as $key => $Room) {
    		$this->db->select('hotel_tbl_hotel_room_type.*,hotel_tbl_room_type.Room_Type');
	        $this->db->from('hotel_tbl_hotel_room_type');
			$this->db->join('hotel_tbl_room_type','hotel_tbl_room_type.id = hotel_tbl_hotel_room_type.room_type', 'left');
	        $this->db->where('hotel_tbl_hotel_room_type.delflg',1);
	        $this->db->where('hotel_tbl_hotel_room_type.id',$Room);
	        // $this->db->group_by('hotel_tbl_room_type.room_type');
	        $query[$key]=$this->db->get()->result();
	    }
	    return $query;

	}
	 public function RoomwiseBulkUpdate($request) {
    	$this->db->select('*');
    	$this->db->from('hotel_tbl_contract');
    	$this->db->where('contract_id',$request['bulk_alt_contract_id']);
    	$contract_type = $this->db->get()->result();

    	$data =array();
		if (isset($request['other_season'])) {
			$start_date=date_create($request['bulk-alt-fromDate']);
	        $end_date=date_create($request['bulk-alt-toDate']);
	        $no_of_days=date_diff($start_date,$end_date);
	        $tot_days = $no_of_days->format("%a");
	        if (isset($request['bulk-alt-room_id'])) 
	        {
		        foreach ($request['bulk-alt-room_id'] as $key => $value) 
		        {	
	    			foreach ($_REQUEST['bulk-alt-days'] as $DayCKkey => $DayCKvalue) {
			        	for($i = 0; $i <= $tot_days; $i++) 
			        	{
		        			if ($DayCKvalue==date('D', strtotime($request['bulk-alt-fromDate']. ' + '.$i.'  days'))) {
						       
						       $result[$i]= date('Y-m-d', strtotime($request['bulk-alt-fromDate']. ' + '.$i.'  days'));
						      	$this->db->select('*');
						      	$this->db->from('hotel_tbl_allotement');
						    	$this->db->where('room_id',$value);
						    	$this->db->where('hotel_id',$request['hotel_id']);
						    	$this->db->where('allotement_date',$result[$i]);
						    	$this->db->where('contract_id',$request['bulk_alt_contract_id']);
						    	$query=$this->db->get();
					        	$query_out[$i] = $query->result();
					    		if (count($query_out[$i])!=0) 
					    		{
					    			if ($contract_type[0]->contract_type!="Main") 
					    			{
					    				foreach ($request['RwAmount'] as $AMCKkey => $AMvalue) 
					    				{
						    				if (isset($request['RwAmount'][$AMCKkey])) {
									    		$data['amount'] = backend_Aed_convertion(hotel_currency_type($request['hotel_id']),$AMvalue);
									    		$data['allotement'] =  0;
									    		$data['cut_off'] =  0;
										    	$this->db->where('contract_id',$request['bulk_alt_contract_id']);
									    		$this->db->where('room_id',$value);
									    		$this->db->where('hotel_id',$request['hotel_id']);
									    		$this->db->where('allotement_date',$query_out[$i][0]->allotement_date);
									    		$this->db->update('hotel_tbl_allotement',$data);
									    	    // Log entry start
												    $dataLOG= array( 
												         'id'               => $query_out[$i][0]->id,
												         'room_id'          => $value,
												         'hotel_id'         => $request['hotel_id'],
												         'allotement_date'  => $query_out[$i][0]->allotement_date,
												         'amount'           => $data['amount'],
												         'allotement'       => $data['allotement'],
												         'cut_off'          => $data['cut_off'],
												         'contract_id'      => $request['bulk_alt_contract_id'],
												         'CreatedDate'      => date('Y-m-d H:i:s'),
												         'CreatedBy'        => $this->session->userdata('id'),
												         'Status'           => 'updated'
												        );
												$this->db->insert('hotel_tbl_allotement_log',$dataLOG);
												// Log entry end
									    	}
									    	
								    	}
					    			} 
					    			
					    			else 
					    			{
						    			if (isset($request['RwAmount'][$key])) {

								    		$data['amount'] = backend_Aed_convertion(hotel_currency_type($request['hotel_id']),$request['RwAmount'][$key]);
								    	}
								    	if (isset($request['RwAllotment'][$key])) {
								    		$data['allotement'] =  $request['RwAllotment'][$key];
								    	}
								    	if (isset($request['RwCutoff'][$key])) {
								    		$data['cut_off'] =  $request['RwCutoff'][$key];
								    	}
							    		$data['contract_id'] =  $request['bulk_alt_contract_id'];
							    		
							    		if (isset($request['RwAmount'][$key]) || isset($request['RwAllotment'][$key]) || isset($request['RwCutoff'][$key])) {
								    		$this->db->where('contract_id',$request['bulk_alt_contract_id']);
								    		$this->db->where('room_id',$value);
								    		$this->db->where('hotel_id',$request['hotel_id']);
								    		$this->db->where('allotement_date',$query_out[$i][0]->allotement_date);
								    		$this->db->update('hotel_tbl_allotement',$data);
								    		// Log entry start
										    $dataLOG= array( 
										         'id'               => $query_out[$i][0]->id,
										         'room_id'          => $value,
										         'hotel_id'         => $request['hotel_id'],
										         'allotement_date'  => $query_out[$i][0]->allotement_date,
										         'amount'           => $data['amount'],
										         'allotement'       => $data['allotement'],
										         'cut_off'          => $data['cut_off'],
										         'contract_id'      => $request['bulk_alt_contract_id'],
										         'CreatedDate'      => date('Y-m-d H:i:s'),
										         'CreatedBy'        => $this->session->userdata('id'),
										         'Status'           => 'updated'
										        );
											$this->db->insert('hotel_tbl_allotement_log',$dataLOG);
											// Log entry end
							    		}
					    			}
						    	} 
						    	
						    	else 
						    	{
					    			if ($contract_type[0]->contract_type!="Main") 
					    			{
					    				$data1 = array('amount'			=> backend_Aed_convertion(hotel_currency_type($request['hotel_id']),$request['RwAmount'][$key]),
							    					  'allotement'		=> 0,
							    					  'cut_off'			=> 0,
							    					  'allotement_date'	=> $result[$i],
							    					  'room_id'			=> $value,
							    					  'hotel_id'		=> $request['hotel_id'],
						    						  'contract_id' 	=> $request['bulk_alt_contract_id']
							    		);
							    		$this->db->insert('hotel_tbl_allotement',$data1);
							    		$id = $this->db->insert_id();
										// Log entry start
										    $dataLOG= array( 
										         'id'               => $id,
										         'room_id'          => $value,
										         'hotel_id'         => $request['hotel_id'],
										         'allotement_date'  => $result[$i],
										         'amount'           => $data1['amount'],
										         'allotement'       => 0,
										         'cut_off'          => 0,
										         'contract_id'      => $request['bulk_alt_contract_id'],
										         'CreatedDate'      => date('Y-m-d H:i:s'),
										         'CreatedBy'        => $this->session->userdata('id'),
										         'Status'           => 'inserted'
										        );
										$this->db->insert('hotel_tbl_allotement_log',$dataLOG);
										// Log entry end
				    				} else 
				    				{

				    					if (isset($request['RwAmount'][$key])) {
								    		$data['amount'] = backend_Aed_convertion(hotel_currency_type($request['hotel_id']),$request['RwAmount'][$key]);
								    	} else {
								    		$data['amount'] = 0;
								    	}
								    	if (isset($request['RwAllotment'][$key])) {
								    		$data['allotement'] =  $request['RwAllotment'][$key];
								    	} else {
								    		$data['allotement'] =  0;
								    	}
								    	if (isset($request['RwCutoff'][$key])) {
								    		$data['cut_off'] =  $request['RwCutoff'][$key];
								    	} else {
								    		$data['cut_off'] =  0;
								    	}
								    	if (isset($request['RWAmount'][$key]) || isset($request['RwAllotment'][$key]) || isset($request['RwCutoff'][$key])) {
								    		$data1 = array('amount'		=> backend_Aed_convertion(hotel_currency_type($request['hotel_id']),$request['RwAmount'][$key]),
								    					  'allotement'	=> $request['RwAllotment'][$key],
								    					  'cut_off'		=> $request['RwCutoff'][$key],
								    					  'allotement_date'=> $result[$i],
								    					  'room_id'=> $value,
								    					  'hotel_id'=> $request['hotel_id'],
							    						  'contract_id' => $request['bulk_alt_contract_id']
								    		);
								    		// print_r($data1);
								    		// exit();
								    		$this->db->insert('hotel_tbl_allotement',$data1);
								    		$id = $this->db->insert_id();
											// Log entry start
											    $dataLOG= array( 
											         'id'               => $id,
											         'room_id'          => $value,
											         'hotel_id'         => $request['hotel_id'],
											         'allotement_date'  => $result[$i],
											         'amount'           => $data1['amount'],
											         'allotement'       => $request['RwAllotment'][$key],
											         'cut_off'          => $request['RwCutoff'][$key],
											         'contract_id'      => $request['bulk_alt_contract_id'],
											         'CreatedDate'      => date('Y-m-d H:i:s'),
											         'CreatedBy'        => $this->session->userdata('id'),
											         'Status'           => 'inserted'
											        );
											$this->db->insert('hotel_tbl_allotement_log',$dataLOG);
											// Log entry end
								    	}
						    		}
						    	}

						    }
	        			}
			    	}
		        }
	        }
	        $start1_date=date_create($request['bulk-alt-fromDate']);
	        $end1_date=date_create($request['bulk-alt-toDate']);
	        $no_of_days1=date_diff($start1_date,$end1_date);
	        $tot_days1 = $no_of_days1->format("%a");
	        foreach ($_REQUEST['bulk-alt-days'] as $DayCKkey => $DayCKvalue) {
		    	for($i = 0; $i <= $tot_days1; $i++) 
		    	{
	    			if ($DayCKvalue==date('D', strtotime($request['bulk-alt-fromDate']. ' + '.$i.'  days'))) {
			       		$result1[$i]= date('Y-m-d', strtotime($request['bulk-alt-fromDate']. ' + '.$i.'  days'));
	    			}
		        }
	        }
		  //   if (isset($request['bulk-alt-closedout'])) 
		  //   {
				// // if ($contract_type[0]->contract_type=="Main") 
				// // {
			 //        foreach ($result1 as $key1 => $value1) 
			 //        {	
			 //        	$implode_room_types = "";
				// 		if (isset($request['bulk-alt-room_id'])) {
				// 			$implode_room_types = implode(",", $request['bulk-alt-room_id']);
				// 		}
			 //        	$this->db->select('*');
			 //        	$this->db->from('hotel_tbl_closeout_period');
				// 		$this->db->where('closedDate',$value1);
				// 		$this->db->where('hotel_id',$request['hotel_id']);
				// 		$this->db->where('contract_id',$request['bulk_alt_contract_id']);
		  //     	  		$query1[$key1]=$this->db->get()->result();


		  //     	  		if (count($query1[$key1])!=0) 
		  //     	  		{
		  // 	  				$data= array('roomType'   	 => $implode_room_types,
				// 				          'reason'     	 => "",
				// 			        );
				// 			$this->db->where('closedDate',$value1);
				// 			$this->db->where('hotel_id',$request['hotel_id']);
				// 			$this->db->where('contract_id',$request['bulk_alt_contract_id']);
				// 			$this->db->update('hotel_tbl_closeout_period',$data);
		  //     	  		} else {
		  //     	  			$data= array( 'hotel_id'   	 => $request['hotel_id'],
				// 				          'contract_id'  => $request['bulk_alt_contract_id'],
				// 				          'closedDate'   => $value1,
				// 				          'reason'       => "",
				// 				          'roomType'     => $implode_room_types,
				// 				          'delflg'       => 1,
				// 				        );
				// 			$this->db->insert('hotel_tbl_closeout_period',$data);
		  //     	  		}
			 //        }
		  //       // }
		  //   } 
		  //   else 
		  //   {
				// // if ($contract_type[0]->contract_type=="Main") 
				// // {
			 //    	foreach ($result1 as $key1 => $value1) 
			 //    	{
			 //        	$this->db->select('*');
			 //        	$this->db->from('hotel_tbl_closeout_period');
				// 		$this->db->where('closedDate',$value1);
				// 		$this->db->where('hotel_id',$request['hotel_id']);
				// 		$this->db->where('contract_id',$request['bulk_alt_contract_id']);
		  //     	  		$query1[$key1]=$this->db->get()->result();
		  //     	  		if (count($query1[$key1])!=0) 
		  //     	  		{
		  //     	  			$explodeCoRR = explode(",", $query1[$key1][0]->roomType);
		  //     	  			$arr_1 = array_diff($explodeCoRR,$request['bulk-alt-room_id']);
		  //     	  			if (count($arr_1)!=0) {
		  //     	  				$implodeCoRR = implode(",", $arr_1);
			 //      	  				$data= array('roomType'   	 => $implodeCoRR,
				// 					          	 'reason'     	 => "",
				// 				        );
				// 				$this->db->where('closedDate',$value1);
				// 				$this->db->where('hotel_id',$request['hotel_id']);
				// 				$this->db->where('contract_id',$request['bulk_alt_contract_id']);
				// 				$this->db->update('hotel_tbl_closeout_period',$data);
		  //     	  			} else {
		  //     	  				$this->db->where('closedDate',$value1);
				// 				$this->db->where('hotel_id',$request['hotel_id']);
				// 				$this->db->where('contract_id',$request['bulk_alt_contract_id']);
				// 				$this->db->delete('hotel_tbl_closeout_period');
		  //     	  			}
		  //     	  		} 
			 //        }

		  //       // }
		  //   }
		} 
		// else {

	 //    	foreach ($request['bulk-alt-season'] as $reqkey => $reqvalue) {
	 //    		$this->db->select('*');
	 //    		$this->db->from('hotel_tbl_season');
	 //    		$this->db->where('contract_id',$request['bulk_alt_contract_id']);
	 //    		$this->db->where('hotel_id',$request['hotel_id']);
	 //    		$this->db->where('id',$request['bulk-alt-season'][$reqkey]);
	 //    		$result_data = $this->db->get()->result();
	    		
		//     	$start_date=date_create($result_data[0]->FromDate);
		//         $end_date=date_create($result_data[0]->ToDate);
		//         $no_of_days=date_diff($start_date,$end_date);
		//         $tot_days = $no_of_days->format("%a");
		//         if (isset($request['bulk-alt-room_id'])) {
		// 	        foreach ($request['bulk-alt-room_id'] as $key => $value) {	
		// 	        	foreach ($_REQUEST['bulk-alt-days'] as $DayCKkey => $DayCKvalue) {
		// 		        	for($i = 0; $i <= $tot_days; $i++) {
		// 		        		if ($DayCKvalue==date('D', strtotime($result_data[0]->FromDate. ' + '.$i.'  days'))) {
				        			
		// 					       $result[$i]= date('Y-m-d', strtotime($result_data[0]->FromDate. ' + '.$i.'  days'));
		// 					      	$this->db->select('*');
		// 					      	$this->db->from('hotel_tbl_allotement');
		// 					    	$this->db->where('room_id',$value);
		// 					    	$this->db->where('hotel_id',$request['hotel_id']);
		// 					    	$this->db->where('allotement_date',$result[$i]);
		// 					    	$this->db->where('contract_id',$request['bulk_alt_contract_id']);
		// 					    	$query=$this->db->get();
		// 				        	$query_out[$i] = $query->result();
		// 				    		if (count($query_out[$i])!=0) {
		// 				    			if ($contract_type[0]->contract_type!="Main") {
		// 				    				foreach ($request['RwAmount'] as $AMCKkey => $AMvalue) 
		// 			    					{
		// 					    				if ($request['RwAmount'][$AMCKkey]!="") {
		// 								    		$data['amount'] =backend_Aed_convertion(hotel_currency_type($request['hotel_id']),$request['RwAmount'][$key]);
		// 								    		$data['allotement'] =  0;
		// 								    		$data['cut_off'] =  0;
		// 									    	$this->db->where('contract_id',$request['bulk_alt_contract_id']);
		// 								    		$this->db->where('room_id',$value);
		// 								    		$this->db->where('hotel_id',$request['hotel_id']);
		// 								    		$this->db->where('allotement_date',$query_out[$i][0]->allotement_date);
		// 								    		$this->db->update('hotel_tbl_allotement',$data);
		// 								    	}
										    	

		// 								    }

		// 				    			} else {

		// 					    			if ($request['RwAmount'][$key]!="") {
		// 							    		$data['amount'] = backend_Aed_convertion(hotel_currency_type($request['hotel_id']),$request['RwAmount'][$key]);
		// 							    	}
		// 							    	if ($request['RwAllotment'][$key]!="") {
		// 							    		$data['allotement'] = $request['RwAllotment'][$key];
		// 							    	}
		// 							    	if ($request['RwCutoff'][$key]!="") {
		// 							    		$data['cut_off'] =  $request['RwCutoff'][$key];
		// 							    	}
		// 							    	if ($request['RwAmount'][$key]!="" || $request['RwAllotment'][$key]!="" || $request['RwCutoff'][$key]!="") {
		// 							    		$this->db->where('contract_id',$request['bulk_alt_contract_id']);
		// 							    		$this->db->where('room_id',$value);
		// 							    		$this->db->where('hotel_id',$request['hotel_id']);
		// 							    		$this->db->where('allotement_date',$query_out[$i][0]->allotement_date);
		// 							    		$this->db->update('hotel_tbl_allotement',$data);
		// 							    	}
		// 				    			}
		// 					    	} else {
		// 				    			if ($contract_type[0]->contract_type!="Main") {
		// 				    				$data1 = array('amount'    => backend_Aed_convertion(hotel_currency_type($request['hotel_id']),$request['RwAmount'][$key]),
		// 						    					  'allotement' => 0,
		// 						    					  'cut_off'    => 0,
		// 						    					  'allotement_date'=> $result[$i],
		// 						    					  'room_id'=> $value,
		// 						    					  'hotel_id'=> $request['hotel_id'],
		// 					    						  'contract_id' => $request['bulk_alt_contract_id']
		// 						    		);
		// 						    		$this->db->insert('hotel_tbl_allotement',$data1);
		// 			    				} else {
		// 						    		$data1 = array('amount'=> backend_Aed_convertion(hotel_currency_type($request['hotel_id']),$request['RwAmount'][$key]),
		// 						    					  'allotement'=> $request['RwAllotment'][$key],
		// 						    					  'cut_off'=> $request['RwCutoff'][$key],
		// 						    					  'allotement_date'=> $result[$i],
		// 						    					  'room_id'=> $value,
		// 						    					  'hotel_id'=> $request['hotel_id'],
		// 					    						  'contract_id' => $request['bulk_alt_contract_id']
		// 						    		);
		// 						    		$this->db->insert('hotel_tbl_allotement',$data1);

		// 					    		}
		// 					    	}
		// 					    }
		// 				    }
		// 			    }
		// 	        }
		//         }

		//         $start1_date=date_create($result_data[0]->FromDate);
		//         $end1_date=date_create($result_data[0]->ToDate);
		//         $no_of_days1=date_diff($start1_date,$end1_date);
		//         $tot_days1 = $no_of_days1->format("%a");
		//         foreach ($_REQUEST['bulk-alt-days'] as $DayCKkey => $DayCKvalue) {
		// 	    	for($i = 0; $i <= $tot_days1; $i++) {
		// 	    		if ($DayCKvalue==date('D', strtotime($result_data[0]->FromDate. ' + '.$i.'  days'))) {
		// 		       		$result1[$i]= date('Y-m-d', strtotime($result_data[0]->FromDate. ' + '.$i.'  days'));
		// 	    		}
		// 	        }
		//         }
		//         // print_r($query_out[0]->room_id);
		//         // exit();
		// 	  //   if (isset($request['bulk-alt-closedout'])) {
		// 			// // if ($contract_type[0]->contract_type=="Main") {
		// 		 //        foreach ($result1 as $key1 => $value1) {
				        	
		// 	  //       		$implode_room_types = "";
		// 			// 		if (isset($request['bulk-alt-room_id'])) {
		// 			// 			$implode_room_types = implode(",", $request['bulk-alt-room_id']);
		// 			// 		}
		// 		 //        	$this->db->select('*');
		// 		 //        	$this->db->from('hotel_tbl_closeout_period');
		// 			// 		$this->db->where('closedDate',$value1);
		// 			// 		$this->db->where('hotel_id',$request['hotel_id']);
		// 			// 		$this->db->where('contract_id',$request['bulk_alt_contract_id']);
		// 	  //     	  		$query1[$key1]=$this->db->get()->result();
		// 	  //     	  		if (count($query1[$key1])!=0) {
		// 	  // 	  				$data= array('roomType'      =>$implode_room_types,
		// 			// 				          'reason'       => "",
									          
		// 			// 			        );
		// 			// 			$this->db->where('closedDate',$value1);
		// 			// 			$this->db->where('hotel_id',$request['hotel_id']);
		// 			// 			$this->db->where('contract_id',$request['bulk_alt_contract_id']);
		// 			// 			$this->db->update('hotel_tbl_closeout_period',$data);
		// 	  //     	  		} else {
		// 	  //     	  			$data= array( 'hotel_id'     => $request['hotel_id'],
		// 			// 				          'contract_id'  => $request['bulk_alt_contract_id'],
		// 			// 				          'closedDate'   => $value1,
		// 			// 				          'reason'       => "",
		// 			// 				          'roomType'     => $implode_room_types,
		// 			// 				          'delflg'       => 1,
		// 			// 				        );
		// 			// 			$this->db->insert('hotel_tbl_closeout_period',$data);
		// 	  //     	  		}
		// 		 //        }
		// 	  //       // }
		// 	  //   } else {
		// 			// // if ($contract_type[0]->contract_type=="Main") {
		// 		 //    	foreach ($result1 as $key1 => $value1) {
		// 		 //        	$this->db->select('*');
		// 		 //        	$this->db->from('hotel_tbl_closeout_period');
		// 			// 		$this->db->where('closedDate',$value1);
		// 			// 		$this->db->where('hotel_id',$request['hotel_id']);
		// 			// 		$this->db->where('contract_id',$request['bulk_alt_contract_id']);
		// 	  //     	  		$query1[$key1]=$this->db->get()->result();
		// 	  //     	  		if (count($query1[$key1])!=0) {
		// 			// 			$explodeCoRR = explode(",", $query1[$key1][0]->roomType);
		// 	  //     	  			$arr_1 = array_diff($explodeCoRR,$request['bulk-alt-room_id']);
		// 	  //     	  			if (count($arr_1)!=0) {
		// 	  //     	  				$implodeCoRR = implode(",", $arr_1);
		// 		 //      	  				$data= array('roomType'   	 => $implodeCoRR,
		// 			// 					          	 'reason'     	 => "",
		// 			// 				        );
		// 			// 				$this->db->where('closedDate',$value1);
		// 			// 				$this->db->where('hotel_id',$request['hotel_id']);
		// 			// 				$this->db->where('contract_id',$request['bulk_alt_contract_id']);
		// 			// 				$this->db->update('hotel_tbl_closeout_period',$data);
		// 	  //     	  			} else {
		// 	  //     	  				$this->db->where('closedDate',$value1);
		// 			// 				$this->db->where('hotel_id',$request['hotel_id']);
		// 			// 				$this->db->where('contract_id',$request['bulk_alt_contract_id']);
		// 			// 				$this->db->delete('hotel_tbl_closeout_period');
		// 	  //     	  			}
		// 	  //     	  		} 
		// 		 //        }
		// 	  //       // }
		// 	  //   }
	 //    	}
	 //    }
	    // print_r($request['RWAmount']);
     //    exit();

    return true;
    }
	public function permissionDetails($hotel,$contract){
		$this->db->select('*');
        $this->db->from('hotel_tbl_contract');
        $this->db->where('hotel_id',$hotel);
        $this->db->where('contract_id',$contract);
        $this->db->group_by('contract_id');
        $query=$this->db->get();
        return $query->result();
	}
	public function nationalityList() {
		$this->db->select('id,name,continent');
        $this->db->from('countries');
        $query=$this->db->get();
        return $query->result();
	}
	public function SelectCountry() {
	    $this->db->select('*');
        $this->db->from('countries');
        $this->db->order_by('id','asce');
        $query=$this->db->get();
        return $query->result();
    }
	public function SelectState($Conid){
    	$this->db->select('*');
        $this->db->from('states');
        $this->db->where('country_id',$Conid);
        $this->db->order_by('id','asce');
        $query=$this->db->get();
        return $query->result();
    }
    public function hotel_offline_booking_list($filter) {
    	$this->db->select('*');
        $this->db->from('hotel_tbl_offlinerequest');
        $this->db->where('bookingFlg',$filter);
        $query=$this->db->get();
        return $query;
    }
    public function Offlinebooking_details($id) {
      $this->db->select('hotel_tbl_offlinerequest.id as requestid,hotel_tbl_offlinerequest.*,hotel_tbl_agents.First_Name as AFName,hotel_tbl_agents.Last_Name as ALName,hotel_tbl_agents.Mobile,hotel_tbl_agents.Email');
      $this->db->from('hotel_tbl_offlinerequest');
      $this->db->join('hotel_tbl_agents','hotel_tbl_agents.id = hotel_tbl_offlinerequest.AgentId', 'left');
      $this->db->where('hotel_tbl_offlinerequest.id',$id);
      $query=$this->db->get();
      return $query->result();
    }
    public function OfflineRequestupdate($request) {
    	$room1Cost = isset($request['Cost'][1]) ? implode(",", $request['Cost'][1]) : '';
    	$room1Selling = isset($request['Selling'][1]) ? implode(",", $request['Selling'][1]) : '';
    	$room1Profit = isset($request['Profit'][1]) ? implode(",", $request['Profit'][1]) : '';
    	$room1Margin = isset($request['margin'][1]) ? implode(",", $request['margin'][1]) : '';

    	$room2Cost = isset($request['Cost'][2]) ? implode(",", $request['Cost'][2]) : '';
    	$room2Selling = isset($request['Selling'][2]) ? implode(",", $request['Selling'][2]) : '';
    	$room2Profit = isset($request['Profit'][2]) ? implode(",", $request['Profit'][2]) : '';
    	$room2Margin = isset($request['margin'][2]) ? implode(",", $request['margin'][2]) : '';

    	$room3Cost = isset($request['Cost'][3]) ? implode(",", $request['Cost'][3]) : '';
    	$room3Selling = isset($request['Selling'][3]) ? implode(",", $request['Selling'][3]) : '';
    	$room3Profit = isset($request['Profit'][3]) ? implode(",", $request['Profit'][3]) : '';
    	$room3Margin = isset($request['margin'][3]) ? implode(",", $request['margin'][3]) : '';

    	$room4Cost = isset($request['Cost'][4]) ? implode(",", $request['Cost'][4]) : '';
    	$room4Selling = isset($request['Selling'][4]) ? implode(",", $request['Selling'][4]) : '';
    	$room4Profit = isset($request['Profit'][4]) ? implode(",", $request['Profit'][4]) : '';
    	$room4Margin = isset($request['margin'][4]) ? implode(",", $request['margin'][4]) : '';

    	$room5Cost = isset($request['Cost'][5]) ? implode(",", $request['Cost'][5]) : '';
    	$room5Selling = isset($request['Selling'][5]) ? implode(",", $request['Selling'][5]) : '';
    	$room5Profit = isset($request['Profit'][5]) ? implode(",", $request['Profit'][5]) : '';
    	$room5Margin = isset($request['margin'][5]) ? implode(",", $request['margin'][5]) : '';
    	
    	$room6Cost = isset($request['Cost'][6]) ? implode(",", $request['Cost'][6]) : '';
    	$room6Selling = isset($request['Selling'][6]) ? implode(",", $request['Selling'][6]) : '';
    	$room6Profit = isset($request['Profit'][6]) ? implode(",", $request['Profit'][6]) : '';
    	$room6Margin = isset($request['margin'][6]) ? implode(",", $request['margin'][6]) : '';

    	$room7Cost = isset($request['Cost'][7]) ? implode(",", $request['Cost'][7]) : '';
    	$room7Selling = isset($request['Selling'][7]) ? implode(",", $request['Selling'][7]) : '';
    	$room7Profit = isset($request['Profit'][7]) ? implode(",", $request['Profit'][7]) : '';
    	$room7Margin = isset($request['margin'][7]) ? implode(",", $request['margin'][7]) : '';

    	$room8Cost = isset($request['Cost'][8]) ? implode(",", $request['Cost'][8]) : '';
    	$room8Selling = isset($request['Selling'][8]) ? implode(",", $request['Selling'][8]) : '';
    	$room8Profit = isset($request['Profit'][8]) ? implode(",", $request['Profit'][8]) : '';
    	$room8Margin = isset($request['margin'][8]) ? implode(",", $request['margin'][8]) : '';

    	$room9Cost = isset($request['Cost'][9]) ? implode(",", $request['Cost'][9]) : '';
    	$room9Selling = isset($request['Selling'][9]) ? implode(",", $request['Selling'][9]) : '';
    	$room9Profit = isset($request['Profit'][9]) ? implode(",", $request['Profit'][9]) : '';
    	$room9Margin = isset($request['margin'][9]) ? implode(",", $request['margin'][9]) : '';

    	$room10Cost = isset($request['Cost'][10]) ? implode(",", $request['Cost'][10]) : '';
    	$room10Selling = isset($request['Selling'][10]) ? implode(",", $request['Selling'][10]) : '';
    	$room10Profit = isset($request['Profit'][10]) ? implode(",", $request['Profit'][10]) : '';
    	$room10Margin = isset($request['margin'][10]) ? implode(",", $request['margin'][10]) : '';
    
    	$data= array(
		          'hotel_name' => $request['hotelName'],
		          'room_name' => $request['roomName'],
		          'SupplierName' => $request['SupplierName'],
		          'board' => $request['board'],
		          'hotel_addresss' => $request['HotelAddress'],
		          'SupllierAddress' => $request['SupplierAddress'],
		          'room1Cost' => $room1Cost,
		          'room1Selling' => $room1Selling,
		          'room1Profit' => $room1Profit,
		          'room1Margin' => $room1Margin,
		          'room2Cost' => $room2Cost,
		          'room2Selling' => $room2Selling,
		          'room2Profit' => $room2Profit,
		          'room2Margin' => $room2Margin,
		          'room3Cost' => $room3Cost,
		          'room3Selling' => $room3Selling,
		          'room3Profit' => $room3Profit,
		          'room3Margin' => $room3Margin,
		          'room4Cost' => $room4Cost,
		          'room4Selling' => $room4Selling,
		          'room4Profit' => $room4Profit,
		          'room4Margin' => $room4Margin,
		          'room5Cost' => $room5Cost,
		          'room5Selling' => $room5Selling,
		          'room5Profit' => $room5Profit,
		          'room5Margin' => $room5Margin,
		          'room6Cost' => $room6Cost,
		          'room6Selling' => $room6Selling,
		          'room6Profit' => $room6Profit,
		          'room6Margin' => $room6Margin,
		          'room7Cost' => $room7Cost,
		          'room7Selling' => $room7Selling,
		          'room7Profit' => $room7Profit,
		          'room7Margin' => $room7Margin,
		          'room8Cost' => $room8Cost,
		          'room8Selling' => $room8Selling,
		          'room8Profit' => $room8Profit,
		          'room8Margin' => $room8Margin,
		          'room9Cost' => $room9Cost,
		          'room9Selling' => $room9Selling,
		          'room9Profit' => $room9Profit,
		          'room9Margin' => $room9Margin,
		          'room10Cost' => $room10Cost,
		          'room10Selling' => $room10Selling,
		          'room10Profit' => $room10Profit,
		          'room10Margin' => $room10Margin,
		          'ContactName' => $request['ContactName'],
		          'ContactEmail' => $request['ContactEmail'],
		          'ContactNumber' => $request['ContactNumber'],
		          'UpdatedBy' => $this->session->userdata('id'),
		          'UpdatedDate' => date('Y-m-d'),
		      );
		$this->db->where('id',$request['id']);
		$this->db->update('hotel_tbl_offlinerequest',$data);
		return true;
    }
    public function OfflineActionupdate($request) {
    	if ($request['val']==1) {
    		$data= array(
		          'conFirmNumber' => $request['conNumber'],
		          'ConFirmName' => $request['conName'],
		          'bookingFlg' => 1,
		          'UpdatedBy' => $this->session->userdata('id'),
		          'UpdatedDate' => date('Y-m-d'),
		      );
    	} else {
			$data= array(
		          'bookingFlg' => 0,
		          'UpdatedBy' => $this->session->userdata('id'),
		          'UpdatedDate' => date('Y-m-d'),
		      );
    	}
		$this->db->where('id',$request['id']);
		$this->db->update('hotel_tbl_offlinerequest',$data);
		return true;
    }
    public function getroomnameNew($room){
    	$room_name = array();
    	$roomarr = explode(",", $room);
    	foreach ($roomarr as $key => $value) {
    		$this->db->select('hotel_tbl_hotel_room_type.room_name');
	        $this->db->from('hotel_tbl_hotel_room_type');
	       	$this->db->where('id',$value);
	       	$query=$this->db->get()->result();
	       	if (count($query)!=0) {
	       		$room_name[$key]  = $query[0]->room_name;
	       	}
    	}
    	
       	return implode(",", $room_name);
    }
    public function RevenueList($filter =1)
	{    
		$this->db->select('*');
		$this->db->from('hotel_tbl_revenue');
		if ($filter==0) {
        	$this->db->where('ToDate <',date('Y-m-d'));
        } else {
        	$this->db->where('ToDate >',date('Y-m-d', strtotime('-1 days')));
        }
	    $query=$this->db->get();
		return $query;
	}
	public function agentList() {
		$this->db->select('*');
		$this->db->from('hotel_tbl_agents');
       	$this->db->where('delflg',1);
	    $query=$this->db->get()->result();
		return $query;
	}
	public function RevenueSeasonlist()
	{    
		$this->db->select('*');
		$this->db->from('hotel_tbl_revenueseason');
	    $query=$this->db->get();
		return $query;
	}
	public function RevenueSeasonSubmit($request) {
		if (isset($request['season_id']) && $request['season_id']!="undefined") {
			$data= array( 
			 'SeasonName' 	  => $request['SeasonName'],
			 'FromDate' 	  => $request['fromDate'],
			 'ToDate' 	  => $request['toDate'],
			 'UpdatedDate' 	  => date('Y-m-d'),
			 'UpdatedBy' 	  => $this->session->userdata('id'),
			);
			$this->db->where('id',$request['season_id']);
			$this->db->update('hotel_tbl_revenueseason',$data);
		} else {
		   $data= array( 
			 'SeasonName' 	  => $request['SeasonName'],
			 'FromDate' 	  => $request['fromDate'],
			 'ToDate' 	  => $request['toDate'],
			 'CreatedDate' 	  => date('Y-m-d'),
			 'CreatedBy' 	  => $this->session->userdata('id'),
			);
			$this->db->insert('hotel_tbl_revenueseason',$data);
		}
		return true;
	}
	public function RevenueSeasonDetails($id) {
		$this->db->select('*');
		$this->db->from('hotel_tbl_revenueseason');
		$this->db->where('id',$id);
	    $query=$this->db->get()->result();
		return $query;
	}
	public function RevenueSeasondelete($id) {
		$this->db->where('id',$id);
		$this->db->delete('hotel_tbl_revenueseason');
		return true;
	}
	public function RevenueSubmit($request) {
		$tbo = '';
		if (isset($request['TBO'])) {
			$tbo = 1;
		} 
		if (isset($request['season'])) {
			$season = $request['season'];
		} else {
			$season = 'Other';
		}
		if ($request['id']=="") {
			$data= array( 
			 'hotels' 	  => $request['hoteltext'],
			 'contracts' 	  => $request['context'],
			 'Agents' 	  => $request['Agentstext'],
			 'Markup' 	  => $request['Markup'],
			 'Season' 	  => $season,
			 'FromDate' 	  => $request['fromDate'],
			 'ToDate' 	  => $request['toDate'],
			 'CreatedDate' 	  => date('Y-m-d H:i:s'),
			 'CreatedBy' 	  => $this->session->userdata('id'),
			 'contract_agreement' => $request['contract_agreement'],
			 'Markuptype' => $request['Markuptype'],
			 'ExtrabedMarkuptype' => $request['ExtrabedMarkuptype'],
			 'ExtrabedMarkup' => $request['ExtrabedMarkup'],
			 'GeneralSupMarkuptype' => $request['GeneralSupMarkuptype'],
			 'GeneralSupMarkup' => $request['GeneralSupMarkup'],
			 'BoardSupMarkuptype' => $request['BoardSupMarkuptype'],
			 'BoardSupMarkup' => $request['BoardSupMarkup'],
			 'tbo' => $tbo
			);
			$this->db->insert('hotel_tbl_revenue',$data);
			$id = $this->db->insert_id();
			$description = 'New Hotel Revenue Added [id:'.$id.']';
    		AdminlogActivity($description);
		} else {
			$data= array( 
			 'hotels' 	  => $request['hoteltext'],
			 'contracts' 	  => $request['context'],
			 'Agents' 	  => $request['Agentstext'],
			 'Markup' 	  => $request['Markup'],
			 'Season' 	  => $season,
			 'FromDate' 	  => $request['fromDate'],
			 'ToDate' 	  => $request['toDate'],
			 'UpdatedDate' 	  => date('Y-m-d H:i:s'),
			 'UpdatedBy' 	  => $this->session->userdata('id'),
			 'contract_agreement' => $request['contract_agreement'],
			 'Markuptype' => $request['Markuptype'],
			 'ExtrabedMarkuptype' => $request['ExtrabedMarkuptype'],
			 'ExtrabedMarkup' => $request['ExtrabedMarkup'],
			 'GeneralSupMarkuptype' => $request['GeneralSupMarkuptype'],
			 'GeneralSupMarkup' => $request['GeneralSupMarkup'],
			 'BoardSupMarkuptype' => $request['BoardSupMarkuptype'],
			 'BoardSupMarkup' => $request['BoardSupMarkup'],
			 'tbo' => $tbo
			);
			$this->db->where('id',$request['id']);
			$this->db->update('hotel_tbl_revenue',$data);
			$description = 'Hotel revenue Updated [id:'.$request['id'].']';
    		AdminlogActivity($description);
		}
		return true;
	}
	public function getagentname($id){
		$agent_name = '';
    	$hotel_name = "";
    	$this->db->select('hotel_tbl_agents.First_Name,hotel_tbl_agents.Last_Name');
        $this->db->from('hotel_tbl_agents');
       	$this->db->where('id',$id);
       	$query=$this->db->get()->result();
       	if (count($query)!=0) {
       		$agent_name  = $query[0]->First_Name.' '.$query[0]->Last_Name;
       	}
       	return $agent_name;
    }
    public function RevenueEdit($id) {
    	$this->db->select('*');
		$this->db->from('hotel_tbl_revenue');
       	$this->db->where('id',$id);
	    $query=$this->db->get()->result();
		return $query;
    }
    public function Revenuedelete($id) {
		$this->db->where('id',$id);
		$this->db->delete('hotel_tbl_revenue');
		return true;
	}
	public function BoardContractGet($contract_id) {
		$this->db->select('board');
		$this->db->from('hotel_tbl_contract');
       	$this->db->where('contract_id',$contract_id);
	    $query=$this->db->get()->result();
		return $query[0]->board;
	}
	public function about_us_select() {
		$this->db->select('*');
		$this->db->from('aboutdetails');
       	$this->db->where('id',1);
	    $query=$this->db->get()->result();
		return $query;
	}
	public function events_select() {
		$this->db->select('*');
		$this->db->from('eventdetails');
  	    $query=$this->db->get()->result();
		return $query;
	}
	public function events_single_select($id){
		$this->db->select('*');
		$this->db->from('eventdetails');
		$this->db->where('id',$id);
		$query=$this->db->get()->result();
		return $query;
	}
	public function record_count() {
		return $this->db->count_all("hotel_tbl_hotels");
	}
	public function all_hotels_select($limit, $start) {
		$this->db->limit($limit,$start);
		$query = $this->db->get("hotel_tbl_hotels");
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return false;
	}
	public function hotels_single_select($id){
		$this->db->select('*');
		$this->db->from('hotel_tbl_hotels');
		$this->db->where('id',$id);
		$query=$this->db->get()->result();
		return $query;
	}
	public function GetRow($keyword) {    
		if ($keyword=="") {
		   	$query = array();
	    } else {
        	$query=$this->db->query("select a.id as cityid,CityCode,CityName,name as CountryName,CountryCode,CONCAT(CityName,',',name) as displayName from xml_city_tbl a inner join countries b on b.sortname = a.CountryCode where a.CityName like '%".$keyword."%' limit 20")->result_array();
        	if (count($query)==0) {
        		$query=$this->db->query("select a.id as cityid,CityCode,CityName,name as CountryName,CountryCode,CONCAT(CityName,',',name) as displayName from xml_city_tbl a inner join countries b on b.sortname = a.CountryCode where  b.name like '%".$keyword."%' limit 20")->result_array();
        	}
    	}    
        return $query;
    }
    public function getcontracttype($contract_id) {
		$this->db->select('contract_type');
        $this->db->from('hotel_tbl_contract');
        $this->db->where('contract_id',$contract_id);
        return $query=$this->db->get();
	}
	public function discountStatus($id,$status) {
		$data= array( 
			 'Discount_flag' 	  => $status,
			);
		$this->db->where('id',$id);
		$this->db->update('hoteldiscount',$data);
		return true;
	}
	public function MultipleDateBulkUpdate($bulkroom_id,$hotel_id,$FromDate,$ToDate,$Amount,$allotment,$cutoff,$contract_id) {
		$Amount = backend_Aed_convertion(hotel_currency_type($hotel_id),$Amount);
		$room_id = explode(",", $bulkroom_id);
		$fromDate=date_create($FromDate);
		$todate=date_create($ToDate);
		$no_of_days=date_diff($fromDate,$todate);
		$tot_days = $no_of_days->format("%a");

		foreach ($room_id as $key => $value) {
			for($i = 0; $i <= $tot_days; $i++) {
		        $date = date('Y-m-d', strtotime($FromDate. ' + '.$i.'  days'));
		        if ($allotment!="" && $cutoff!="") {
		        	$data = array(
					  'room_id' => $value,
					  'hotel_id' => $hotel_id,
					  'allotement_date' => $date,
					  'amount' => $Amount,
					  'allotement' => $allotment,
					  'cut_off' => $cutoff,
					  'contract_id' => $contract_id,
					);
		        } else if($allotment!="") {
		        	$data = array(
					  'room_id' => $value,
					  'hotel_id' => $hotel_id,
					  'allotement_date' => $date,
					  'amount' => $Amount,
					  'allotement' => $allotment,
					  'contract_id' => $contract_id,
					);
				 } else if($cutoff!="") {
		        	$data = array(
					  'room_id' => $value,
					  'hotel_id' => $hotel_id,
					  'allotement_date' => $date,
					  'amount' => $Amount,
					  'cut_off' => $cutoff,
					  'contract_id' => $contract_id,
					);
		        } else {
		        	$data = array(
					  'room_id' => $value,
					  'hotel_id' => $hotel_id,
					  'allotement_date' => $date,
					  'amount' => $Amount,
					  'contract_id' => $contract_id,
					);
		        }

		        $query = $this->db->query('select * from hotel_tbl_allotement where room_id = '.$value.' and hotel_id = '.$hotel_id.' and contract_id = "'.$contract_id.'" and allotement_date = "'.$date.'"')->result();
		        if (count($query)!=0) {
		        	$this->db->where('room_id',$value);
		        	$this->db->where('hotel_id',$hotel_id);
		        	$this->db->where('contract_id',$contract_id);
		        	$this->db->where('allotement_date',$date);
	    			$this->db->update('hotel_tbl_allotement',$data);
		        } else {
	    			$this->db->insert('hotel_tbl_allotement',$data);
		        }

		    }
		}
		return true;
	}
	public function SeasonUpdate($SeasonName,$hotel_id,$FromDate,$ToDate,$contract_id) {
		$data = array(
				  'FromDate' => $FromDate,
				  'ToDate' => $ToDate,
				  'SeasonName' => $SeasonName,
				  'hotel_id' => $hotel_id,
				  'contract_id' => $contract_id,
				);
		$this->db->insert('hotel_tbl_season',$data);
		return true;
	}
	public function SelectSeason($request){
		$data = array();
		$Conid = explode(",", $request['Conid']);
    	foreach ($Conid as $key => $contract_id) {
    		$query = $this->db->query("select * from hotel_tbl_season where FromDate in (select FromDate from hotel_tbl_season group by FromDate having count(*) > 1) and ToDate in (select ToDate from hotel_tbl_season group by ToDate having count(*) > 1) and contract_id ='".$contract_id."'")->result();   	
        	if (count($query)!=0) {
        		foreach ($query as $CGkey => $Cgvalue) {
        			// $data['hotel_name'][] = $Cgvalue->hotel_name;
        			$data[] = array('id'=>$Cgvalue->id,
        				'SeasonName' =>$Cgvalue->SeasonName,
        				'fromdate' => date('d/m/Y',strtotime($Cgvalue->FromDate)),
        				'alternate_fromdate' => $Cgvalue->FromDate,
        				'todate' => date('d/m/Y',strtotime($Cgvalue->ToDate)),
        				'alternate_todate' => $Cgvalue->ToDate
        			);
        		}
        	}
    	}
        return $data;
    	
    }
    public function ranking_list($filter) {
    	$this->db->select('a.*,b.name as countryName,c.name as CityName');
    	$this->db->from('hotel_tbl_ranking a');
    	$this->db->join('countries b','b.id = a.countryId','inner');
    	$this->db->join('states c','c.id = a.CityId','inner');
    	if ($filter==1) {
    		$this->db->where('a.ToDate >',date('Y-m-d'));
    	} else {
    		$this->db->where('a.ToDate <',date('Y-m-d'));
    	}
    	$query = $this->db->get();
    	return $query;
    }
    public function hotelsRankingDetails($id) {
    	$this->db->select('*');
    	$this->db->from('hotel_tbl_ranking');
		$this->db->where('id',$id);
    	$query = $this->db->get()->result();
    	return $query;
    }
    public function rankingUpdate($request) {
    	if ($request['id']!="") {
    		$array = array(
				"countryId" => $request['ConSelect'],
				"CityId" => $request['citySelect'],
				"FromDate" => $request['date_picker'],
				"ToDate" => $request['date_picker1'],
				"Hotels" => implode(",", $request['hotel']),
				"UpdatedDate" => date('Y-m-d H:i:s'),
				"UpdatedBy" => $this->session->userdata('name'),

			);
    		$id = $_REQUEST['id'];
    		$this->db->where('id',$id);
    		$this->db->update('hotel_tbl_ranking',$array);
    		$description = 'Hotel ranking Updated [id:'.$id.']';
    		AdminlogActivity($description);
    	} else {
    		$array = array(
				"countryId" => $request['ConSelect'],
				"CityId" => $request['citySelect'],
				"FromDate" => $request['date_picker'],
				"ToDate" => $request['date_picker1'],
				"Hotels" => implode(",", $request['hotel']),
				"CreatedDate" => date('Y-m-d H:i:s'),
				"CreatedBy" => $this->session->userdata('name'),

			);
    		$this->db->insert('hotel_tbl_ranking',$array);
    		$id = $this->db->insert_id();
    		$description = 'New Hotel Ranking Added [id:'.$id.']';
    		AdminlogActivity($description);
    	}
    	return true;
    }
    public function CitySelect($CountryCode) {
	    $this->db->select('*');
        $this->db->from('xml_city_tbl');
        $this->db->where('CountryCode',$CountryCode);
        $query=$this->db->get();
        return $query->result();
    }
    public function getallotement($con_id) {
    	$this->db->select("*");
    	$this->db->from("hotel_tbl_allotement");
    	$this->db->where("contract_id",$con_id);
    	$query = $this->db->get()->result();
    	return count($query);
    }
    public function ranking_delete($id) {
		$this->db->where('id',$id);
		$this->db->delete('hotel_tbl_ranking');
		return true;
	}
	public function add_hotel_contract($request){
    	$id=$request['id'];
		if ($request['contract_id']!="") {
	    	$this->db->select('*');
	    	$this->db->from('hotel_tbl_contract');
	    	$this->db->where('contract_id',$request['contract_id']);
	    	$output = $this->db->get()->result();
	    	$contract_flg = $output[0]->contract_flg;
    	} else {
    		$contract_flg = 0;
    	}
    	if ($request['contract_type']!="Sub") {
			$request['linked_contract'] = "";
    	} else {
			$request['linked_contract'] = $request['linked_contract'];
    	}
    	if (isset($request['nonRefundable'])) {
    		$nonRefundable = 1;
    	} else {
    		$nonRefundable = 0;
    	}
    	$nationality = '';
    	if (isset($request['nationality_to']) && count($request['nationality_to'])!=0) {
    		$nationality = implode(",", $request['nationality_to']);
    	}
    	$array= array(	
			        	'tax_percentage' 	=> $request['tax'],
			        	'max_child_age' 	=> $request['max_age'],
			        	'from_date' 		=> $request['date_picker'],
			        	'to_date' 			=> $request['date_picker1'],
			        	'markup' 			=> $request['markup'],
			        	'contract_type' 	=> $request['contract_type'],
			        	'board' 			=> $request['board'],
			        	'hotel_id' 			=> $id,
			        	'contract_flg' 		=> 0,
			        	'contractName' 		=> $request['contract_name'],
			        	'linkedContract' 	=> $request['linked_contract'],
			        	'nonRefundable' 	=> $nonRefundable,
			        	'nationalityPermission' => $nationality,
        				'BookingCode' => $request['BookingCode'],
			        	'Created_Date' => date("Y-m-d H:i:s"),
        				'Created_By' => '',
        				'contract_agreement' => $request['contract_agreement']
					);
		$this->db->insert('hotel_tbl_contract',$array);
		$con_id = $this->db->insert_id();
		
		if($con_id!=""){
        	$contract_id='CON0'.$con_id;
        }
        else{
        	$contract_id="CON01";
    	}
		$array = array(
    					'contract_id' => $contract_id,
    					'Updated_Date' => date("Y-m-d H:i:s"),
        				'Updated_By' =>  '',
					);
		$this->db->where('id', $con_id);
		$this->db->update('hotel_tbl_contract', $array);
		if ($request['contract_id']!="") {
			/*Alotement copy start*/
			$this->db->query("INSERT INTO hotel_tbl_allotement (room_id, hotel_id, allotement_date,amount,allotement,cut_off,contract_id) SELECT room_id, hotel_id, allotement_date,amount,allotement,cut_off,'".$contract_id."' FROM   hotel_tbl_allotement WHERE  contract_id = '".$request['contract_id']."' AND allotement_date BETWEEN  '".$_REQUEST['date_picker']."' AND '".$_REQUEST['date_picker1']."'");

			/*Alotement copy end*/
			/*Board Supplement copy start*/
			$this->db->query("INSERT INTO hotel_tbl_boardsupplement (board, roomType, season,fromDate,toDate,startAge,finalAge,amount,hotel_id,contract_id) SELECT board, roomType, season,fromDate,toDate,startAge,finalAge,amount,hotel_id,'".$contract_id."' FROM   hotel_tbl_boardsupplement WHERE  contract_id = '".$request['contract_id']."'");
			/*Board Supplement copy end*/
			/*General Supplement copy start*/
			$this->db->query("INSERT INTO hotel_tbl_generalsupplement (type, roomType, season,fromDate,toDate,adultAmount,childAmount,application,mandatory,hotel_id,contract_id) SELECT type, roomType, season,fromDate,toDate,adultAmount,childAmount,application,mandatory,hotel_id,'".$contract_id."' FROM   hotel_tbl_generalsupplement WHERE  contract_id = '".$request['contract_id']."'");
			/*General Supplement copy end*/
			/*Child policy copy start*/
			$this->db->query("INSERT INTO hotel_tbl_childpolicy (ageFrom, ageTo, roomType,discount,discountType,board,hotel_id,contract_id) SELECT ageFrom, ageTo, roomType,discount,discountType,board,hotel_id,'".$contract_id."' FROM   hotel_tbl_childpolicy WHERE  contract_id = '".$request['contract_id']."'");
			/*Child policy copy end*/
			/*Cancellation policy copy start*/
			$this->db->query("INSERT INTO hotel_tbl_cancellationfee (season, fromDate,toDate, roomType,daysInAdvance,cancellationPercentage,application,hotel_id,contract_id,daysFrom,daysTo) SELECT season, fromDate,toDate, roomType,daysInAdvance,cancellationPercentage,application,hotel_id,'".$contract_id."',daysFrom,daysTo FROM   hotel_tbl_cancellationfee WHERE  contract_id = '".$request['contract_id']."'");
			/*Cancellation policy copy end*/
			/*Minimum stay copy start*/
			$this->db->query("INSERT INTO hotel_tbl_minimumstay (season, fromDate,toDate, minDay,hotel_id,contract_id) SELECT season, fromDate,toDate, minDay,hotel_id,'".$contract_id."' FROM   hotel_tbl_minimumstay WHERE  contract_id = '".$request['contract_id']."'");
			/*Minimum stay copy end*/
			/*Closed out copy start*/
			$this->db->query("INSERT INTO hotel_tbl_closeout_period (from_date, to_date,reason, delflg,closedDate,hotel_id,contract_id) SELECT from_date, to_date,reason, delflg,closedDate,hotel_id,'".$contract_id."' FROM   hotel_tbl_closeout_period WHERE  contract_id = '".$request['contract_id']."' AND closedDate BETWEEN  '".$_REQUEST['date_picker']."' AND '".$_REQUEST['date_picker1']."'");
			/*Closed out copy end*/
			/*Policies copy start*/
			$this->db->query("INSERT INTO hotel_tbl_policies (Important_Remarks_Policies, Important_Notes_Conditions,cancelation_policy, Created_Date,Created_By,delflg,hotel_id,contract_id) SELECT Important_Remarks_Policies, Important_Notes_Conditions,cancelation_policy, '".date('d-m-Y')."','".$this->session->userdata('name')."',delflg,hotel_id,'".$contract_id."' FROM   hotel_tbl_policies WHERE  contract_id = '".$request['contract_id']."'");
			/*Policies copy end*/
			/*Season copy start*/
			$this->db->query("INSERT INTO hotel_tbl_season (FromDate, ToDate,SeasonName,hotel_id,contract_id) SELECT FromDate, ToDate,SeasonName,hotel_id,'".$contract_id."' FROM   hotel_tbl_season WHERE  contract_id = '".$request['contract_id']."'");
			/*Season copy end*/

			/*Extrabed copy start*/
			$this->db->query("INSERT INTO hotel_tbl_extrabed (roomType, season,from_date,to_date,ChildAmount,ChildAgeFrom,ChildAgeTo,amount,hotel_id,contract_id) SELECT  roomType, season,from_date,to_date,ChildAmount,ChildAgeFrom,ChildAgeTo,amount,hotel_id,'".$contract_id."' FROM   hotel_tbl_extrabed WHERE  contract_id = '".$request['contract_id']."'");
			/*Extrabed copy end*/
			/*Country permission copy start*/
			$this->db->query("INSERT INTO hotel_country_permission (permission, hotel_id,contract_id) SELECT permission, hotel_id,'".$contract_id."' FROM   hotel_country_permission WHERE  contract_id = '".$request['contract_id']."'");
			/*Country permission copy end*/
			/*agent permission copy start*/
			$this->db->query("INSERT INTO hotel_agent_permission (permission, hotel_id,contract_id) SELECT permission, hotel_id,'".$contract_id."' FROM   hotel_agent_permission WHERE  contract_id = '".$request['contract_id']."'");
			/*agent permission copy end*/
		}
		return $con_id;
    }
    public function hotel_contract_list_stop_sale($hotel_id) {
		$this->db->select('*');
        $this->db->from('hotel_tbl_contract');
        $this->db->where('hotel_id',$hotel_id);
       	$this->db->where('to_date >',date('Y-m-d', strtotime('-1 days')));
        $this->db->group_by('contract_id');
        $query=$this->db->get();
        return $query->result();
	}
	public function DisplaySubmit($request) {
		if ($request['id']=="") {
			$data= array( 
			 'directhotels' => $request['direct'],
			 'Agents' 	  => $request['Agentstext'],
			 'CreatedDate' 	  => date('Y-m-d H:i:s'),
			 'CreatedBy' 	  => $this->session->userdata('id'),
			 'tbohotels' => $request['tbo']
			);
			$this->db->insert('hotel_tbl_displaymanage',$data);
			$id = $this->db->insert_id();
			$description = 'New Display Management Details Added [id:'.$id.']';
    		AdminlogActivity($description);
		} else {
			$data= array( 
			 'directhotels' => $request['direct'],
			 'Agents' 	  => $request['Agentstext'],
			 'UpdatedDate' 	  => date('Y-m-d H:i:s'),
			 'UpdatedBy' 	  => $this->session->userdata('id'),
			  'tbohotels' => $request['tbo']
			);
			$this->db->where('id',$request['id']);
			$this->db->update('hotel_tbl_displaymanage',$data);
			$description = 'Display Management Details Updated [id:'.$request['id'].']';
    		AdminlogActivity($description);
		}
		return true;
	}
	public function DisplayList()
	{    
		$this->db->select('*');
		$this->db->from('hotel_tbl_displaymanage');
	    $query=$this->db->get();
		return $query;
	}
	public function DisplayEdit($id) {
    	$this->db->select('*');
		$this->db->from('hotel_tbl_displaymanage');
       	$this->db->where('id',$id);
	    $query=$this->db->get()->result();
		return $query;
    }
    public function Displaydelete($id) {
		$this->db->where('id',$id);
		$this->db->delete('hotel_tbl_displaymanage');
		return true;
	}
	public function provided_list() {
    	$this->db->select('*');
    	$this->db->from('hotel_tbl_agents');
    	$query = $this->db->get();
    	return $query;
    }
    public function getMarket() {
        $query=$this->db->query('select distinct continent from countries where continent!=""');
        return $query->result();
	}
	public function SelectCon($request){
		$data['country_id'] = array();
		$market = explode(",", $request['market']);
    	foreach ($market as $key => $value) {
    		$this->db->select('*');
        	$this->db->from('countries');
        	$this->db->where('continent',$value);
        	$query=$this->db->get()->result();
        	if (count($query)!=0) {
        		foreach ($query as $CGkey => $Cgvalue) {
        			$data['country_id'][$Cgvalue->continent][] = $Cgvalue->id;
        			$data['country'][$Cgvalue->continent][] = $Cgvalue->name;
        		}
        	}
    	}
    	$dropdown = '';
    	if (count($data['country_id'])!=0) {
    		foreach ($data['country_id'] as $CVGkey => $CVGvalue) {
    				foreach ($CVGvalue as $Conkey => $Convalue) {
    					$dropdown .= '<option value="'.$Convalue.'" continent="'.$Convalue.'">'.$data['country'][$CVGkey][$Conkey].'</option>';
    				}
    		}
    	}
    	return $dropdown;
    }
    public function allotementBlkupdatewizard($request) {
    	$this->db->select('contract_type');
    	$this->db->from('hotel_tbl_contract');
    	$this->db->where('contract_id',$request['bulk_alt_contract_id']);
    	$contract_type = $this->db->get()->result();
    	$data =array();
	    	
		$reqvalue = $request['season'];
		$this->db->select('FromDate,ToDate');
		$this->db->from('hotel_tbl_season');
		$this->db->where('contract_id',$request['bulk_alt_contract_id']);
		$this->db->where('hotel_id',$request['hotel_id']);
		$this->db->where('id',$reqvalue);
		$result_data = $this->db->get()->result();

    	$start_date=date_create($result_data[0]->FromDate);
        $end_date=date_create($result_data[0]->ToDate);
        $no_of_days=date_diff($start_date,$end_date);
        $tot_days = $no_of_days->format("%a");
        

        if (isset($request['bulk-alt-room_id'])) {
	        foreach ($request['bulk-alt-room_id'] as $key => $value) {	
	        	for($i = 0; $i <= $tot_days; $i++) {
        			if (in_array(date('D', strtotime($result_data[0]->FromDate. ' + '.$i.'  days')), $_REQUEST['bulk-alt-days'])) {
				       $result[$i]= date('Y-m-d', strtotime($result_data[0]->FromDate. ' + '.$i.'  days'));
				      	$this->db->select('id,allotement_date');
				      	$this->db->from('hotel_tbl_allotement');
				    	$this->db->where('room_id',$value);
				    	$this->db->where('hotel_id',$request['hotel_id']);
				    	$this->db->where('allotement_date',$result[$i]);
				    	$this->db->where('contract_id',$request['bulk_alt_contract_id']);
				    	$query=$this->db->get();
			        	$query_out[$i] = $query->result();
			    		if (count($query_out[$i])!=0) {
			    			if ($contract_type[0]->contract_type!="Main") {
			    				if ($request['bulk-alt-amount']!="") {
						    		$data['amount'] = backend_Aed_convertion(hotel_currency_type($request['hotel_id']),$request['bulk-alt-amount']);
						    		$data['allotement'] =  0;
						    		$data['cut_off'] =  0;
							    	$this->db->where('contract_id',$request['bulk_alt_contract_id']);
						    		$this->db->where('room_id',$value);
						    		$this->db->where('hotel_id',$request['hotel_id']);
						    		$this->db->where('allotement_date',$query_out[$i][0]->allotement_date);
						    		$this->db->update('hotel_tbl_allotement',$data);
						    		// Log entry start
							    		$dataLOG= array( 
											 'id'				=> $query_out[$i][0]->id,
											 'room_id' 	     	=> $value,
											 'hotel_id' 	 	=> $request['hotel_id'],
											 'allotement_date' 	=> $query_out[$i][0]->allotement_date,
											 'amount'			=> $data['amount'],
											 'allotement'		=> $data['allotement'],
											 'cut_off' 			=> $data['cut_off'],
											 'contract_id'		=> $request['bulk_alt_contract_id'],
											 'CreatedDate'  	=> date('Y-m-d H:i:s'),
							     			 'CreatedBy'     	=> $this->session->userdata('id'),
							     			 'Status'			=> 'updated'
											);
									$this->db->insert('hotel_tbl_allotement_log',$dataLOG);
							    	// Log entry end
						    	}
			    			} else {

				    			if ($request['bulk-alt-amount']!="") {
						    		$data['amount'] = backend_Aed_convertion(hotel_currency_type($request['hotel_id']),$request['bulk-alt-amount']);
						    	}
						    	if ($request['bulk-alt-allotment']!="") {
						    		$data['allotement'] =  $request['bulk-alt-allotment'];
						    	}
						    	if ($request['bulk-alt-cut-off']!="") {
						    		$data['cut_off'] =  $request['bulk-alt-cut-off'];
						    	}
						    	if ($request['bulk-alt-amount']!="" || $request['bulk-alt-allotment']!="" || $request['bulk-alt-cut-off']!="") {
						    		$this->db->where('contract_id',$request['bulk_alt_contract_id']);
						    		$this->db->where('room_id',$value);
						    		$this->db->where('hotel_id',$request['hotel_id']);
						    		$this->db->where('allotement_date',$query_out[$i][0]->allotement_date);
						    		$this->db->update('hotel_tbl_allotement',$data);
						    		// Log entry start
							    		$dataLOG= array( 
											 'id'				=> $query_out[$i][0]->id,
											 'room_id' 	     	=> $value,
											 'hotel_id' 	 	=> $request['hotel_id'],
											 'allotement_date' 	=> $query_out[$i][0]->allotement_date,
											 'amount'			=> $data['amount'],
											 'allotement'		=> $data['allotement'],
											 'cut_off' 			=> $data['cut_off'],
											 'contract_id'		=> $request['bulk_alt_contract_id'],
											 'CreatedDate'  	=> date('Y-m-d H:i:s'),
							     			 'CreatedBy'     	=> $this->session->userdata('id'),
							     			 'Status'			=> 'updated'
											);
									$this->db->insert('hotel_tbl_allotement_log',$dataLOG);
							    	// Log entry end
						    	}
			    			}
				    	} else {
			    			if ($contract_type[0]->contract_type!="Main") {
			    				$data1 = array('amount'    => backend_Aed_convertion(hotel_currency_type($request['hotel_id']),$request['bulk-alt-amount']),
					    					  'allotement' => 0,
					    					  'cut_off'    => 0,
					    					  'allotement_date'=> $result[$i],
					    					  'room_id'=> $value,
					    					  'hotel_id'=> $request['hotel_id'],
				    						  'contract_id' => $request['bulk_alt_contract_id']
					    		);
					    		$this->db->insert('hotel_tbl_allotement',$data1);
					    		$id = $this->db->insert_id();
								// Log entry start
							    $dataLOG= array( 
							         'id'               => $id,
							         'room_id'          => $value,
							         'hotel_id'         => $request['hotel_id'],
							         'allotement_date'  => $result[$i],
							         'amount'           => $data1['amount'],
							         'allotement'       => 0,
							         'cut_off'          => 0,
							         'contract_id'      => $request['bulk_alt_contract_id'],
							         'CreatedDate'      => date('Y-m-d H:i:s'),
							         'CreatedBy'        => $this->session->userdata('id'),
							         'Status'           => 'inserted'
							        );
								$this->db->insert('hotel_tbl_allotement_log',$dataLOG);
								// Log entry end
		    				} else {
					    		$data1 = array('amount'=> backend_Aed_convertion(hotel_currency_type($request['hotel_id']),$request['bulk-alt-amount']),
					    					  'allotement'=> $request['bulk-alt-allotment'],
					    					  'cut_off'=> $request['bulk-alt-cut-off'],
					    					  'allotement_date'=> $result[$i],
					    					  'room_id'=> $value,
					    					  'hotel_id'=> $request['hotel_id'],
				    						  'contract_id' => $request['bulk_alt_contract_id']
					    		);
					    		$this->db->insert('hotel_tbl_allotement',$data1);
					    		$id = $this->db->insert_id();
								// Log entry start
								$dataLOG= array( 
								         'id'               => $id,
								         'room_id'          => $value,
								         'hotel_id'         => $request['hotel_id'],
								         'allotement_date'  => $result[$i],
								         'amount'           => $data1['amount'],
								         'allotement'       => $request['bulk-alt-allotment'],
								         'cut_off'          => $request['bulk-alt-cut-off'],
								         'contract_id'      => $request['bulk_alt_contract_id'],
								         'CreatedDate'      => date('Y-m-d H:i:s'),
								         'CreatedBy'        => $this->session->userdata('id'),
								         'Status'           => 'inserted'
								        );
								$this->db->insert('hotel_tbl_allotement_log',$dataLOG);
								// Log entry end
				    		}
				    	}
				    }
			    }
	        }
        }

        $start1_date=date_create($result_data[0]->FromDate);
        $end1_date=date_create($result_data[0]->ToDate);
        $no_of_days1=date_diff($start1_date,$end1_date);
        $tot_days1 = $no_of_days1->format("%a");
        foreach ($_REQUEST['bulk-alt-days'] as $DayCKkey => $DayCKvalue) {
	    	for($i = 0; $i <= $tot_days1; $i++) {
	    		if ($DayCKvalue==date('D', strtotime($result_data[0]->FromDate. ' + '.$i.'  days'))) {
		       		$result1[$i]= date('Y-m-d', strtotime($result_data[0]->FromDate. ' + '.$i.'  days'));
	    		}
	        }
        }

        /* Closed condtion */
		if (isset($request['Close'])) {
			foreach ($result1 as $key1 => $value1) {
				$this->db->select('roomType');
	        	$this->db->from('hotel_tbl_closeout_period');
				$this->db->where('closedDate',$value1);
				$this->db->where('hotel_id',$request['hotel_id']);
				$this->db->where('contract_id',$request['bulk_alt_contract_id']);
				$query1[$key1]=$this->db->get()->result();
				if (count($query1[$key1])!=0) {
					$explodeCoRR = explode(",", $query1[$key1][0]->roomType);
  	  				$arr_1 = array_merge($explodeCoRR,$request['bulk-alt-room_id']);
  	  				$implode_room_types = implode(",", array_unique($arr_1));
  	  				$data= array('roomType'      =>$implode_room_types,
						          'reason'       => "",
						        );
					$this->db->where('closedDate',$value1);
					$this->db->where('hotel_id',$request['hotel_id']);
					$this->db->where('contract_id',$request['bulk_alt_contract_id']);
					$this->db->update('hotel_tbl_closeout_period',$data);
					// Log entry start
                    $dataLOG= array( 
                            'hotel_id'   => $request['hotel_id'],
                            'contract_id' => $request['bulk_alt_contract_id'],
                            'closedDate'  => $value1,
                            'roomType'   => $implode_room_types,
                            'reason'     => "",
                            'CreatedBy' => $this->session->userdata('id'),
                            'CreatedDate' => date('Y-m-d H:i:s'),
                            'Status'     => 'close'
                    );
                    $this->db->insert('hotel_tbl_closeout_period_log',$dataLOG);
                    // Log entry end
				} else {
					$implode_room_types = implode(",", $request['bulk-alt-room_id']);
      	  			$data= array( 'hotel_id'     => $request['hotel_id'],
						          'contract_id'  => $request['bulk_alt_contract_id'],
						          'closedDate'   => $value1,
						          'reason'       => "",
						          'roomType'     => $implode_room_types,
						          'delflg'       => 1,
						        );
					$this->db->insert('hotel_tbl_closeout_period',$data);
					$id = $this->db->insert_id();
					// Log entry start
                    $dataLOG= array( 
                    		'id'  		=> $id,
                            'hotel_id'   => $request['hotel_id'],
                            'contract_id' => $request['bulk_alt_contract_id'],
                            'closedDate'  => $value1,
                            'roomType'   => $implode_room_types,
                            'reason'     => "",
                            'delflg'	=> 1,
                            'CreatedBy' => $this->session->userdata('id'),
                            'CreatedDate' => date('Y-m-d H:i:s'),
                            'Status'     => 'close'
                    );
                    $this->db->insert('hotel_tbl_closeout_period_log',$dataLOG);
                    // Log entry end
				}
			}
		}

		/* Open condtion */

		if (isset($request['Open'])) {
			foreach ($result1 as $key1 => $value1) {
				$this->db->select('roomType');
	        	$this->db->from('hotel_tbl_closeout_period');
				$this->db->where('closedDate',$value1);
				$this->db->where('hotel_id',$request['hotel_id']);
				$this->db->where('contract_id',$request['bulk_alt_contract_id']);
				$query1[$key1]=$this->db->get()->result();
				if (count($query1[$key1])!=0) {
					$explodeCoRR = explode(",", $query1[$key1][0]->roomType);
  	  				$arr_1 = array_diff($explodeCoRR,$request['bulk-alt-room_id']);
  	  				if (count($arr_1)!=0) {
  	  					$implode_room_types = implode(",", $arr_1);
      	  				$data= array('roomType'   	 => $implode_room_types,
						          'reason'     	 => "",
					        );
						$this->db->where('closedDate',$value1);
						$this->db->where('hotel_id',$request['hotel_id']);
						$this->db->where('contract_id',$request['bulk_alt_contract_id']);
						$this->db->update('hotel_tbl_closeout_period',$data);
						// Log entry start
	                    $dataLOG= array( 
	                            'hotel_id'   => $request['hotel_id'],
	                            'contract_id' => $request['bulk_alt_contract_id'],
	                            'closedDate'  => $value1,
	                            'roomType'   => $implode_room_types,
	                            'reason'     => "",
	                            'CreatedBy' => $this->session->userdata('id'),
	                            'CreatedDate' => date('Y-m-d H:i:s'),
	                            'Status'     => 'open'
	                    );
	                    $this->db->insert('hotel_tbl_closeout_period_log',$dataLOG);
	                    // Log entry end
  	  				} else {
	  	  				$this->db->where('closedDate',$value1);
						$this->db->where('hotel_id',$request['hotel_id']);
						$this->db->where('contract_id',$request['bulk_alt_contract_id']);
						$this->db->delete('hotel_tbl_closeout_period');
						// Log entry start
	                    $dataLOG= array( 
	                            'hotel_id'   => $request['hotel_id'],
	                            'contract_id' => $request['bulk_alt_contract_id'],
	                            'closedDate'  => $value1,
	                            'roomType'   => $implode_room_types,
	                            'reason'     => "",
	                            'delflg'	=> 1,
	                            'CreatedBy' => $this->session->userdata('id'),
	                            'CreatedDate' => date('Y-m-d H:i:s'),
	                            'Status'     => 'open'
	                    );
	                    $this->db->insert('hotel_tbl_closeout_period_log',$dataLOG);
	                    // Log entry end
  	  				}
				}
			}
		}
    	return true;
    }
    public function RoomwiseBulkUpdateWizard($request) {
    	$this->db->select('*');
    	$this->db->from('hotel_tbl_contract');
    	$this->db->where('contract_id',$request['bulk_alt_contract_id']);
    	$contract_type = $this->db->get()->result();
    	$data =array();
		$this->db->select('*');
		$this->db->from('hotel_tbl_season');
		$this->db->where('contract_id',$request['bulk_alt_contract_id']);
		$this->db->where('hotel_id',$request['hotel_id']);
		$this->db->where('id',$request['season']);
		$result_data = $this->db->get()->result();		
    	$start_date=date_create($result_data[0]->FromDate);
        $end_date=date_create($result_data[0]->ToDate);
        $no_of_days=date_diff($start_date,$end_date);
        $tot_days = $no_of_days->format("%a");
        if (isset($request['bulk-alt-room_id'])) {
	        foreach ($request['bulk-alt-room_id'] as $key => $value) {	
	        	foreach ($_REQUEST['bulk-alt-days'] as $DayCKkey => $DayCKvalue) {
		        	for($i = 0; $i <= $tot_days; $i++) {
		        		if ($DayCKvalue==date('D', strtotime($result_data[0]->FromDate. ' + '.$i.'  days'))) {
		        			
					       $result[$i]= date('Y-m-d', strtotime($result_data[0]->FromDate. ' + '.$i.'  days'));
					      	$this->db->select('*');
					      	$this->db->from('hotel_tbl_allotement');
					    	$this->db->where('room_id',$value);
					    	$this->db->where('hotel_id',$request['hotel_id']);
					    	$this->db->where('allotement_date',$result[$i]);
					    	$this->db->where('contract_id',$request['bulk_alt_contract_id']);
					    	$query=$this->db->get();
				        	$query_out[$i] = $query->result();
				    		if (count($query_out[$i])!=0) {
				    			if ($contract_type[0]->contract_type!="Main") {
				    				foreach ($request['RwAmount'] as $AMCKkey => $AMvalue) 
			    					{
					    				if ($request['RwAmount'][$AMCKkey]!="") {
								    		$data['amount'] =backend_Aed_convertion(hotel_currency_type($request['hotel_id']),$request['RwAmount'][$key]);
								    		$data['allotement'] =  0;
								    		$data['cut_off'] =  0;
									    	$this->db->where('contract_id',$request['bulk_alt_contract_id']);
								    		$this->db->where('room_id',$value);
								    		$this->db->where('hotel_id',$request['hotel_id']);
								    		$this->db->where('allotement_date',$query_out[$i][0]->allotement_date);
								    		$this->db->update('hotel_tbl_allotement',$data);
											// Log entry start
											    $dataLOG= array( 
											         'id'               => $query_out[$i][0]->id,
											         'room_id'          => $value,
											         'hotel_id'         => $request['hotel_id'],
											         'allotement_date'  => $query_out[$i][0]->allotement_date,
											         'amount'           => $data['amount'],
											         'allotement'       => $data['allotement'],
											         'cut_off'          => $data['cut_off'],
											         'contract_id'      => $request['bulk_alt_contract_id'],
											         'CreatedDate'      => date('Y-m-d H:i:s'),
											         'CreatedBy'        => $this->session->userdata('id'),
											         'Status'           => 'updated'
											        );
											$this->db->insert('hotel_tbl_allotement_log',$dataLOG);
											// Log entry end
								    	}
								    	

								    }

				    			} else {

					    			if ($request['RwAmount'][$key]!="") {
							    		$data['amount'] = backend_Aed_convertion(hotel_currency_type($request['hotel_id']),$request['RwAmount'][$key]);
							    	}
							    	if ($request['RwAllotment'][$key]!="") {
							    		$data['allotement'] = $request['RwAllotment'][$key];
							    	}
							    	if ($request['RwCutoff'][$key]!="") {
							    		$data['cut_off'] =  $request['RwCutoff'][$key];
							    	}
							    	if ($request['RwAmount'][$key]!="" || $request['RwAllotment'][$key]!="" || $request['RwCutoff'][$key]!="") {
							    		$this->db->where('contract_id',$request['bulk_alt_contract_id']);
							    		$this->db->where('room_id',$value);
							    		$this->db->where('hotel_id',$request['hotel_id']);
							    		$this->db->where('allotement_date',$query_out[$i][0]->allotement_date);
							    		$this->db->update('hotel_tbl_allotement',$data);
		                                // Log entry start
		                                    $dataLOG= array( 
		                                         'id'               => $query_out[$i][0]->id,
		                                         'room_id'          => $value,
		                                         'hotel_id'         => $request['hotel_id'],
		                                         'allotement_date'  => $query_out[$i][0]->allotement_date,
		                                         'amount'           => $data['amount'],
		                                         'allotement'       => $data['allotement'],
		                                         'cut_off'          => $data['cut_off'],
		                                         'contract_id'      => $request['bulk_alt_contract_id'],
		                                         'CreatedDate'      => date('Y-m-d H:i:s'),
		                                         'CreatedBy'        => $this->session->userdata('id'),
		                                         'Status'           => 'updated'
		                                        );
		                                $this->db->insert('hotel_tbl_allotement_log',$dataLOG);
		                                // Log entry end
							    	}
				    			}
					    	} else {
				    			if ($contract_type[0]->contract_type!="Main") {
				    				$data1 = array('amount'    => backend_Aed_convertion(hotel_currency_type($request['hotel_id']),$request['RwAmount'][$key]),
						    					  'allotement' => 0,
						    					  'cut_off'    => 0,
						    					  'allotement_date'=> $result[$i],
						    					  'room_id'=> $value,
						    					  'hotel_id'=> $request['hotel_id'],
					    						  'contract_id' => $request['bulk_alt_contract_id']
						    		);
						    		$this->db->insert('hotel_tbl_allotement',$data1);
						    		$id = $this->db->insert_id();
	                                // Log entry start
	                                    $dataLOG= array( 
	                                         'id'               => $id,
	                                         'room_id'          => $value,
	                                         'hotel_id'         => $request['hotel_id'],
	                                         'allotement_date'  => $result[$i],
	                                         'amount'           => $data1['amount'],
	                                         'allotement'       => 0,
	                                         'cut_off'          => 0,
	                                         'contract_id'      => $request['bulk_alt_contract_id'],
	                                         'CreatedDate'      => date('Y-m-d H:i:s'),
	                                         'CreatedBy'        => $this->session->userdata('id'),
	                                         'Status'           => 'inserted'
	                                        );
	                                $this->db->insert('hotel_tbl_allotement_log',$dataLOG);
	                                // Log entry end
			    				} else {
						    		$data1 = array('amount'=> backend_Aed_convertion(hotel_currency_type($request['hotel_id']),$request['RwAmount'][$key]),
						    					  'allotement'=> $request['RwAllotment'][$key],
						    					  'cut_off'=> $request['RwCutoff'][$key],
						    					  'allotement_date'=> $result[$i],
						    					  'room_id'=> $value,
						    					  'hotel_id'=> $request['hotel_id'],
					    						  'contract_id' => $request['bulk_alt_contract_id']
						    		);
						    		$this->db->insert('hotel_tbl_allotement',$data1);
						    		$id = $this->db->insert_id();
	                                // Log entry start
	                                    $dataLOG= array( 
	                                         'id'               => $id,
	                                         'room_id'          => $value,
	                                         'hotel_id'         => $request['hotel_id'],
	                                         'allotement_date'  => $result[$i],
	                                         'amount'           => $data1['amount'],
	                                         'allotement'       => $request['RwAllotment'][$key],
	                                         'cut_off'          => $request['RwCutoff'][$key],
	                                         'contract_id'      => $request['bulk_alt_contract_id'],
	                                         'CreatedDate'      => date('Y-m-d H:i:s'),
	                                         'CreatedBy'        => $this->session->userdata('id'),
	                                         'Status'           => 'inserted'
	                                        );
	                                $this->db->insert('hotel_tbl_allotement_log',$dataLOG);
	                                // Log entry end

					    		}
					    	}
					    }
				    }
			    }
	        }
        }
    return true;
    }
}		




