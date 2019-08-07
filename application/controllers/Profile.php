<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {
	public function __construct()
     {
          parent::__construct();
          $this->load->model('Profile_Model');
          $this->load->model('Common_Model');
          $this->load->helper('url');
          $this->load->helper('html');
          $this->load->helper('upload');
          $this->load->helper('common');
          $this->load->library('gateways/App_gateway', '', 'App_gateway');
          $this->load->library('gateways/Telr_gateway', '', 'Telr_gateway');
     }
	
	public function index()
	{
		if ($this->session->userdata('agent_name')=="") {
			redirect("index");
		}
		$id=$this->session->userdata('agent_id');
		$data['view']=$this->Profile_Model->profile_get($id);
		// print_r($data);
		// exit();
		$data['currency_list']= $this->Profile_Model->currency();
    $data['contry']= $this->Profile_Model->SelectCountry();
		$this->load->view('frontend/profile',$data);
	}
	public function profile_update()
	{
		// print_r($_REQUEST);
		// exit();
		if ($this->session->userdata('agent_name')=="") {
			redirect("index");
		}
		    $id=$this->session->userdata('agent_id');
        $result = $this->Profile_Model->profile_update($_REQUEST,$id);
        if ($_FILES['profile_image']!="") {
	        handle_agent_profile_image_upload($id);
        }
        if ($_FILES['logo']!="") {
        handle_agent_logo_upload($id);
          }
          if ($_FILES['tradefile']!="") {
        handle_license_upload($id);
          }
        AgentlogActivity('Agent profile details edited [Agent ID: '.$id.']');
        redirect('../profile?msg=success');
	}
	public function password_update()
	{
		if ($this->session->userdata('agent_name')=="") {
			redirect("index");
		}
		$id=$this->session->userdata('agent_id');
		$data['view']=$this->Profile_Model->profile_get($id);
		// print_r($data['view'][0]->profile_image);
		// exit();
		$oldpass=$data['view'][0]->password;
		if ($_REQUEST['old_password']=="") {
			$Return['error'] = "Old Password field is required !";
			$Return['status'] = "0";
		} else if ($_REQUEST['new_password']=="") {
			$Return['error'] = "New Password field is required !";
			$Return['status'] = "0";
		} else if ($oldpass!=md5($_REQUEST['old_password'])) {
			$Return['error'] = " Old password is incorrect!";
			$Return['status'] = "0";
		} else {
      $result = $this->Profile_Model->password_update($_REQUEST,$id);
			$Return['status'] = "1";
      AgentlogActivity('Agent password details updated [Agent ID: '.$id.']');
		}
		echo json_encode($Return);
	}
	public function profile_validation() {
		if ($this->session->userdata('agent_name')=="") {
      redirect("../backend/");
    }
    $id=$this->session->userdata('agent_id');
    $result = $this->Profile_Model->profile_update($_REQUEST,$id);
    if ($result == true) {
        $Return['status'] = '1';
    } else {
        $Return['status'] = '0';
       }
      echo json_encode($Return);
	}
	public function agent_register() {
	  $data['view'] = $this->Profile_Model->general_settings_select();
    $data['currency_list']= $this->Profile_Model->currency();
    $data['contry']= $this->Profile_Model->SelectCountry();
		$this->load->view('agent_reg',$data);
	}
    public function agent_reg_insert() {
      $agent_max_id = $this->Profile_Model->agent_max_id();
      $agent_id = $agent_max_id[0]->id+1;
      if (count($agent_max_id)==0) {
        $data['agent_max_id'] = "HA0001";
      } else {
        $data['agent_max_id'] = "HA00".$agent_id;
      }
	  $result = $this->Profile_Model->agent_reg_insert($_REQUEST,$data['agent_max_id']);
    handle_license_upload($result);
    OtherlogActivity('New agent registered [ID: '.$result.', Agent ID: '.$data['agent_max_id'].']');
	  // RegisteringMail($result,'agent');
    	// $data = $this->Profile_Model->agent_reg_insert($_REQUEST);
    redirect("../profile/agent_registered");

  }
  public function agent_validation() {
  	  if ($_REQUEST['email']!="") {
        $mail = email_validation($_REQUEST['email']);
      } 
      else
      {
        $mail = 2;
      }
      echo json_encode($mail);
  }
  public function agent_registered() {
  	$this->load->view('frontend/agent_registered');
  }
  public function dummmy() {
  	RegisteringMail('77','agent');
  }
  public function StateSelect() {
      $data = $this->Profile_Model->SelectState($_REQUEST['Conid']);
      echo json_encode($data);
  }
  public function creditamount()
  {
    if ($this->session->userdata('agent_name')=="") {
      redirect("index");
    }
    $data['credit'] = $this->db->query("select Credit_amount from hotel_tbl_agents where id='".$this->session->userdata('agent_id')."'")->result();
    $this->load->view('frontend/creditAmount',$data);
  }
  public function loadcreditamount() {
        $pay_currency = agent_currency();
        if($pay_currency!='AED') {
          $amt = currency_type_aed($pay_currency,'AED',$_REQUEST['amount']);
        } else {
          $amt = $_REQUEST['amount'];
        }
        $this->session->set_userdata('credit_currency','AED');
        $this->session->set_userdata('credit_amount',$amt);
        $details   = $this->Common_Model->telrdetails();
        $this->Telr_gateway->process_payment_creditAmount($details);
  }
  public function loadcreditamount_response() {
      if ($_REQUEST['msg']=='success') {
        $credit = $this->db->query("select Credit_amount from hotel_tbl_agents where id='".$this->session->userdata('agent_id')."'")->result();
        $amount=$_REQUEST['amount'];
        $add_credit= $this->Profile_Model->add_credit_agent_($credit[0]->Credit_amount,$amount);
        $data = array('bookingId' => 'AgentCredit-'.$add_credit,
                    'amount' => $amount,
                    'currency' => $_REQUEST['currency'],
                    'transactionId' => $_REQUEST['transid'],
                    'orderNumber' => $_REQUEST['ordernumber'],
                    'method' => $_REQUEST['gateway'],
                    'date' => date('Y-m-d H:i:s'),
                    'agentId' => $this->session->userdata('agent_id'),
                    'provider' => 'Agent Credit');
        $result = $this->Profile_Model->addpaymentrecords($data);
        redirect("../profile/creditamount");
      }
      else if($_REQUEST['msg']=='failed') {
        redirect("../profile/creditamount");
      }
  }
}
