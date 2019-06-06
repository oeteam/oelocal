<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Supplier_Model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
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
	public function SelectCountry() {
	    $this->db->select('*');
        $this->db->from('countries');
        $this->db->order_by('id','asce');
        $query=$this->db->get();
        return $query->result();
    }
    public function currency(){
	    $this->db->select('*');
	    $this->db->from('currency_update');
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
    public function maxgetid() {
		$this->db->select_max('id');
		$this->db->from('hotel_tbl_hotels');
		$query=$this->db->get();
		return $query->result_array();
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
					  'Preferred_currency' 	=> $data['Preferred_currency'],
					  'created_date' => date('Y-m-d'), 
					  'created_by' => $this->session->userdata('agent_id'), 
					  'supplier' =>'1',
					  'supplierid' => $this->session->userdata('agent_id')
				);
		$this->db->insert('hotel_tbl_hotels',$data);
        $hotel_id = $this->db->insert_id();
		return $hotel_id; 
	}
	public function checkHotel($hotel) {
		$result = $this->db->query('select * from hotel_tbl_hotels where hotel_name like "%'.$hotel.'%" ')->result();
		return count($result);
	}
	public function hotel_list_select() {
		$this->db->select('*');
		$this->db->from('hotel_tbl_hotels');
		$this->db->where('supplier','1');
		$this->db->where('supplierid',$this->session->userdata('agent_id'));
		$this->db->order_by('id','desc');
	    $query=$this->db->get();
		return $query;
	}
	public function hotel_detail_get($id) {
        $this->db->select('*');
        $this->db->from('hotel_tbl_hotels');
        $this->db->where('hotel_tbl_hotels.id',$id);
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
					  'Preferred_currency' 	=> $data['Preferred_currency'],
					  'updated_date' 		=> date('Y-m-d'), 
					  'updated_by' 			=> $this->session->userdata('agent_id'), 
				);

		$this->db->where('id',$hotel_id);
		$result = $this->db->update('hotel_tbl_hotels',$data);
		return $result; 
	}
	public function hotel_facilities($id) {
        $this->db->select('hotel_tbl_hotel_facility.* , hotel_tbl_icons.icon_src');
      	$this->db->from('hotel_tbl_hotel_facility');
      	$this->db->join('hotel_tbl_icons','hotel_tbl_icons.id = hotel_tbl_hotel_facility.Icon', 'left');
      	$this->db->where('hotel_tbl_hotel_facility.id',$id);
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
    public function deleteHotelPer($id)	{
		$this->db->where('id',$id);
		$this->db->delete('hotel_tbl_hotels');
		return true;
	}
	public function hotel_search_list($request) {
		$this->db->select('*');
		$this->db->from('hotel_tbl_hotels');
		if($request['hotel']!="") {
			$this->db->where('id',$request['hotel']);
		}
		if($request['con']!="") {
			$this->db->where('country',$request['con']);
		}
		if($request['state']!="") {
			$this->db->where('state',$request['state']);
		}
		if($request['state']!="") {
			$this->db->where('state',$request['state']);
		}
		if($request['city']!="") {
			$this->db->like('city',$request['city']);
		}
		if($request['prov']!="") {
			$this->db->like('property_name',$request['prov']);
		}
		if($request['rating']!="" && $request['rating']!='all') {
			$this->db->where('rating',$request['rating']);
		}
		$this->db->where('supplier','1');
		$this->db->where('supplierid',$this->session->userdata('agent_id'));
		$this->db->order_by('id','desc');
		$query=$this->db->get();
		//echo $this->db->last_query();
		return $query;
  	}
}