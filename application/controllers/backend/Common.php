<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'third_party/CILogViewer/vendor/autoload.php');

class Common extends MY_Controller {
  private $logViewer;
	public function __construct() {
          parent::__construct();
          $this->load->model('Common_Model');
          $this->load->model('Hotels_Model');
          $this->load->helper('url');
          $this->load->helper('html');
          $this->load->helper('form');
          $this->load->helper('Common');
          $this->load->helper('upload');
          $this->load->library('email');
          $this->load->library('gateways/App_gateway', '', 'App_gateway');
          $this->load->library('gateways/Paypal_gateway', '', 'Paypal_gateway');
          $this->load->library('gateways/Two_checkout_gateway', '', 'Two_checkout_gateway');
          $this->load->library('gateways/Paypal_braintree_gateway', '', 'Paypal_braintree_gateway');
          $this->load->library('gateways/Mollie_gateway', '', 'Mollie_gateway');
          $this->load->library('gateways/Authorize_sim_gateway', '', 'Authorize_sim_gateway');
          $this->load->library('gateways/Stripe_gateway', '', 'Stripe_gateway');
          $this->load->library('gateways/Telr_gateway', '', 'Telr_gateway');
          $this->load->helper('manuallog');
          $this->logViewer = new \CILogViewer\CILogViewer();
  }
  public function index() {
    if ($this->session->userdata('name')=="") {
     redirect("../backend/logout");
    }
    $title = $this->Common_Model->title();
    $this->load->view('backend/components/header',$title);
  }
	public function icons() {
    if ($this->session->userdata('name')=="") {
     redirect("../backend/logout");
    }
    $Iconmenu = menuPermissionAvailability($this->session->userdata('id'),'General','Add Icons'); 
      if (count($Iconmenu)!=0 && $Iconmenu[0]->view==1) {
          $this->load->view('backend/general/icon_view');
      } else {
          redirect(base_url().'backend/dashboard');
      }
  }
  public function icons_add_view() {
    if ($this->session->userdata('name')=="") {
     redirect("../backend/logout");
    }
    $Iconmenu = menuPermissionAvailability($this->session->userdata('id'),'General','Add Icons'); 
    if (isset($_REQUEST['edit_id']) && $_REQUEST['edit_id'] !="") {
      $data['edit'] = $this->Common_Model->edit($_REQUEST['edit_id']);
      if (count($Iconmenu)!=0 && $Iconmenu[0]->view==1 && $Iconmenu[0]->edit==1) {
            $this->load->view('backend/general/icon_add',$data);
      } else {
          redirect(base_url().'backend/dashboard');
      }
    } else {
      $data['edit'] =array();
      if (count($Iconmenu)!=0 && $Iconmenu[0]->view==1 && $Iconmenu[0]->create==1) {
            $this->load->view('backend/general/icon_add',$data);
      } else {
          redirect(base_url().'backend/dashboard');
      }
    }
  }
  public function icons_add() {
    if ($this->session->userdata('name')=="") {
     redirect("../backend/logout");
    } 
    if ($_REQUEST['edit_id']!="") {
      $result = $this->Common_Model->update($_REQUEST,$_REQUEST['edit_id']);
      if ($_FILES['icon_src']['name']!="") {
        handle_ico_image_upload($_REQUEST['edit_id']);
      }
      redirect('../backend/common/icons');
    } else {
      $user_id = $this->Common_Model->insert($_REQUEST);
      if ($user_id!="") {
        handle_ico_image_upload($user_id);
      }
      redirect('../backend/common/icons');
    }
  }
	public function icon_list_table() {
    $data = array();
    // Datatables Variables
    $draw = intval($this->input->get("draw"));
    $start = intval($this->input->get("start"));
    $length = intval($this->input->get("length"));
    $icons = $this->Common_Model->icon_select();
    foreach($icons->result() as $key => $r) {
      $Iconmenu = menuPermissionAvailability($this->session->userdata('id'),'General','Add Icons'); 
        if($Iconmenu[0]->edit!=0){
        $edit='<a href="icons_add_view?edit_id='.$r->id.'" class="sb2-2-1-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
        }else{
            $edit="";
        }
        if ($r->icon_src!="") {
            $icon_src = base_url()."".$r->icon_src."";
             } else {
            $icon_src = base_url()."assets/images/user/1.png";
        }
      $data[] = array(
        $key+1,
        $r->icon_name,
        '<span class="list-img"><img src="'.$icon_src.'" alt=""></span>',
        $r->created_date,
        $edit,
      );
        }
    $output = array(
        "draw" => $draw,
       "recordsTotal" => $icons->num_rows(),
       "recordsFiltered" => $icons->num_rows(),
       "data" => $data
    );
    echo json_encode($output);
    exit();
  }

  public function icon_validation() {   
        if ($_REQUEST['icons']=="") {
          $Return['error'] = 'Icon Name field is required!';
          $Return['color'] = 'orange';
        }
        else {
          if ($_REQUEST['edit_id']!="") {
            $Return['error'] = "Updated Successfully";
            $Return['color'] = 'green';
            $Return['status'] = '1';
            $description = 'Icon details edited [ID: '.$_REQUEST['edit_id'].']';
          } else {
            $Return['error'] = "Inserted Successfully";
            $Return['color'] = 'green';
            $Return['status'] = '1';
            $description = 'New icon details added';
          }
          AdminlogActivity($description);
        }
    
    echo json_encode($Return);
  }
  public function payment() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/logout");
    }
    $data['view'] = $this->Common_Model->general_settings_select();
    $data['currency_list']= $this->Common_Model->currency();
    $Payment = menuPermissionAvailability($this->session->userdata('id'),'General','Currency'); 
      if (count($Payment)!=0 && $Payment[0]->view==1) {
          $this->load->view('backend/general/payment',$data);
      } else {
          redirect(base_url().'backend/dashboard');
      }
  }
  public function payment_settings_update() {
    if ($this->session->userdata('name')=="") {
     redirect("../backend/logout");
    }
    $data = array('currency_type' => $_REQUEST['preferred_currency'],
                );
    $update = $this->Common_Model->general_settings_payment_update($data);
    $description = 'Default currency details updated to '.$_REQUEST['preferred_currency'];
    AdminlogActivity($description); 
    redirect('../backend/common/payment');
  }
  public function mail() {
    if ($this->session->userdata('name')=="") {
     redirect("../backend/logout");
    }
    $data['view'] = $this->Common_Model->mail_settings_select();
    $data['timeout'] = array($data['view'][0]->smtp_timeout => $data['view'][0]->smtp_timeout,'5'=>'5','10'=>'10','15'=>'15','20'=>'20','25'=>'25');
    $data['Charset'] = array($data['view'][0]->smtp_charset => $data['view'][0]->smtp_charset,'UTF-8'=>'UTF-8','iso-8859-1'=>'iso-8859-1');
    $Mail = menuPermissionAvailability($this->session->userdata('id'),'General','Mail'); 
    if (count($Mail)!=0 && $Mail[0]->view==1) {
          $this->load->view('backend/general/mail',$data);  
    } else {
          redirect(base_url().'backend/dashboard');
    }
  }
  public function mail_settings_update() {
    if ($this->session->userdata('name')=="") {
     redirect("../backend/logout");
    }
    $data = array('protocol' => $_REQUEST['protocol'],
                  'smtp_host' => $_REQUEST['smtp_host'],
                  'smtp_password' => $_REQUEST['smtp_password'],
                  'smtp_port' => $_REQUEST['smtp_port'],
                  'smtp_timeout' => $_REQUEST['smtp_timeout'],
                  'smtp_charset' => $_REQUEST['smtp_charset'],
                  'mailtype' => $_REQUEST['mailtype'],
                  'smtp_user' => $_REQUEST['smtp_user'],
                  'company_name' => $_REQUEST['company_name'],
                  'updated_by' => $this->session->userdata('id'),
                  'updated_date' => date('Y-m-d'),
                   );
    $update = $this->Common_Model->mail_settings_update($data);
    $description = 'Mail settings details updated';
    AdminlogActivity($description);
    redirect('../backend/common/mail');
  }
  public function mail_send() {
    if ($this->session->userdata('name')=="") {
     redirect("../backend/logout");
    }
    $this->email->set_mailtype("html");
    $message = 'hai';
    $this->email->from("subinrabin444@gmail.com", "subin");
    $this->email->to("subinrabin444@gmail.com");
    
    $this->email->subject("Test");
    $this->email->message($message);
    
    $this->email->send();
  }
  public function test_mail() {
    if ($this->session->userdata('name')=="") {
     redirect("../backend/logout");
    }
    if (!isset($_REQUEST['test_mail'])) {
     redirect("../backend/common/mail");
    }
    $mail = $this->Common_Model->mail_settings_select();
    $subject = 'Mail Testing';
    $mail_settings = mail_details();
    $message = 'This the test.';
    $this->load->library('email');
    $this->email->from($mail[0]->smtp_user,$mail[0]->company_name);
    $this->email->to($_REQUEST['test_mail']);
    $this->email->subject($subject);
    $this->email->message($message);
    $mail_send = $this->email->send();
 
    if($mail_send==1){
         $data['error']="<div style='color: green;'><b>Mail sent successfully</div>";
    } else {
         $data['error']="<div style='color: red;'>".$this->email->print_debugger()."</div>";
    }
    $data['view'] = $this->Common_Model->mail_settings_select();
    $data['timeout'] = array($data['view'][0]->smtp_timeout => $data['view'][0]->smtp_timeout,'5'=>'5','10'=>'10','15'=>'15','20'=>'20','25'=>'25');
    $data['Charset'] = array($data['view'][0]->smtp_charset => $data['view'][0]->smtp_charset,'UTF-8'=>'UTF-8','iso-8859-1'=>'iso-8859-1');
    $this->load->view('backend/general/mail',$data);
  }
  public function new_currency_update()
  {
    if ($this->session->userdata('name')=="") {
     redirect("../backend/logout");
    }
     $data=array( 'currency_type'     => $_REQUEST['currency_type'],
                  'currency_name'     => $_REQUEST['currency_name'],
                  'Created_Date' => date("Y-m-d H:i:s"),
                  'Created_By' =>  $this->session->userdata('id'),
                );
    $update = $this->Common_Model->added_currency_update($data); 
    $description = 'New Currency details added [ID: '.$update.']';
    AdminlogActivity($description);
    redirect('../backend/common/payment');
  }
  public function currency_type_list(){
   $data = array();
    // Datatables Variables
    $draw = intval($this->input->get("draw"));
    $start = intval($this->input->get("start"));
    $length = intval($this->input->get("length")); 
    $currency_type_list = $this->Common_Model->currency_type_list();
    foreach($currency_type_list->result() as $key => $r) {
       $data[] = array(
        $key+1,
        $r->currency_type,
        $r->currency_name,
        '<input type="hidden" name="id[]" id="id" value="'.$r->id.'"><input type="hidden" name="currency_type[]" id="currency_type" value="'.$r->currency_type.'">'.$r->amount
        );


    }

    $output = array(
            "draw" => $draw,
             "recordsTotal" => $currency_type_list->num_rows(),
             "recordsFiltered"=> $currency_type_list->num_rows(),
             "data" => $data
        );

      echo json_encode($output);
      exit();
  
  }
  public function currency_amount() {
    if ($this->session->userdata('name')=="") {
     redirect("../backend/logout");
    }
      foreach ($_REQUEST['id'] as $key => $value) {
        $data[$key]=currency_type_gc($_REQUEST['currency_type'][$key],"1");
        if($data[$key] != "failed") {
          $update = $this->Common_Model->added_currency_amount_update($data[$key],$value);
        }   
      }
    redirect('../backend/common/payment');
  }
  public function menu_permission(){
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    if (CategoryCheck($this->session->userdata('id'))==1) {
      $this->load->view('backend/permission/menu_permission');
    } else {
      redirect(base_url().'backend/dashboard');
    }

  }
  public function new_role(){
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $data['defaultmenu'] = $this->Common_Model->defaultmenu();
    if (isset($_REQUEST['edit_id']) && $_REQUEST['edit_id'] !="") {
      $data['edit'] = $this->Common_Model->RoleEdit($_REQUEST['edit_id']);
      $data['view'] = $this->Common_Model->menuEditdetails($_REQUEST['edit_id']);
    } else {
      $data['edit'] =array();
    }
    if (CategoryCheck($this->session->userdata('id'))==1) {
      $this->load->view('backend/permission/add_role',$data);
    } else {
      redirect(base_url().'backend/dashboard');
    }
  }
  public function per_tbl_role_name(){

        if ($this->session->userdata('name')=="") {
          redirect("../backend/");
    }
        $data = array();
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $role_name_list = $this->Common_Model->PerRoleName();
        
        foreach($role_name_list->result() as $key => $r) {
          if($r->id!=1){
            $delete='<a href="#" onclick="RoleDel('.$r->id.');" data-toggle="modal" data-target="#myModal" class="sb2-2-1-edit delete"><i class="red accent-4 fa fa-trash-o" aria-hidden="true"></i></a>';
          }
          else{
            $delete='';
          }
          $edit='<a href="new_role?edit_id='.$r->id.'" class="sb2-2-1-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
            
            $data[] = array(
                $key+1,
                $r->role_name,
                $edit.$delete,
            );
        }
        $output = array(
            "draw" => $draw,
             "recordsTotal" => $role_name_list->num_rows(),
             "recordsFiltered" => $role_name_list->num_rows(),
             "data" => $data
        );
      echo json_encode($output);
      //exit();
    }
    public function DeleteRole() {
      if ($this->session->userdata('name')=="") {
       redirect("../backend/");
      }
      $result = $this->Common_Model->DeleteRoleModel($_REQUEST['delete_id']);
      if ($result==true) {
        $Return['error'] = "Deleted Successfully";
        $Return['color'] = 'green';
        $Return['status'] = '1';
        //$Return['table'] = 'menu_per_tbl';
      } else {
        $Return['error'] = "Deleted Unsuccessfully!";
        $Return['color'] = 'red';
        //$Return['table'] = 'menu_per_tbl';
      }
    echo json_encode($Return);
  }
  public function RoleDetails(){
     if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    // print_r($_REQUEST);
    if (isset($_REQUEST['edit_id']) && $_REQUEST['edit_id']!="") {
      $update_id = $this->Common_Model->RoleUpdate($_REQUEST);
            for ($i=1; $i <=count($_REQUEST['menuCheck']) ; $i++) { 
                if (isset($_REQUEST['viewCheck'][$i])) {
                  $viewCheck = 1;
                } else {
                  $viewCheck = 0;
                }
                if (isset($_REQUEST['createCheck'][$i])) {
                  $createCheck = 1;
                } else {
                  $createCheck = 0;
                }
                if (isset($_REQUEST['editCheck'][$i])) {
                  $editCheck = 1;
                } else {
                  $editCheck = 0;
                }
                if (isset($_REQUEST['deleteCheck'][$i])) {
                  $deleteCheck = 1;
                } else {
                  $deleteCheck = 0;
                }
        
        $this->Common_Model->CheckboxValuesupdate($_REQUEST['edit_id'],$i,$viewCheck,$createCheck,$editCheck,$deleteCheck);

        }
        $description = 'Role and menu permissions edited [ID: '.$_REQUEST['edit_id'].']';
    } else {
         $insert_id = $this->Common_Model->roleAdd($_REQUEST);
         for ($i=1; $i <=count($_REQUEST['menuCheck']) ; $i++) { 
                if (isset($_REQUEST['viewCheck'][$i])) {
                  $viewCheck = 1;
                } else {
                  $viewCheck = 0;
                }
                if (isset($_REQUEST['createCheck'][$i])) {
                  $createCheck = 1;
                } else {
                  $createCheck = 0;
                }
                if (isset($_REQUEST['editCheck'][$i])) {
                  $editCheck = 1;
                } else {
                  $editCheck = 0;
                }
                if (isset($_REQUEST['deleteCheck'][$i])) {
                  $deleteCheck = 1;
                } else {
                  $deleteCheck = 0;
                }
        
        $this->Common_Model->CheckboxValuesAdd($insert_id,$i,$viewCheck,$createCheck,$editCheck,$deleteCheck);

        }
        $description = 'New role and menu permissions added';
 echo json_encode($insert_id );
    }
    AdminlogActivity($description);
    if (isset($_REQUEST['edit_id']) && $_REQUEST['edit_id']!="") {
        redirect(base_url()."backend/common/new_role?edit_id=".$_REQUEST['edit_id']);
    } 
    else {

         redirect(base_url()."backend/common/new_role?edit_id=".$insert_id);
    }     
  }

  public function CheckRolenameAvailablity()
  {
    $roleName   = $_REQUEST['roleName'];
    $result     = $this->Common_Model->get_all_RoleName($roleName);  
    echo json_encode($result);
  }
  public function customer_care(){
    $data['view']=$this->Common_Model->customer_care_select();
    $customercareMenu = menuPermissionAvailability($this->session->userdata('id'),'General','Customer Care Details'); 
    if (count($customercareMenu)!=0 && $customercareMenu[0]->view==1) {
      $this->load->view('backend/general/customer_care',$data);
    } else {
      redirect(base_url().'backend/dashboard');
    }
  }
  public function customer_care_update() {
    $data = array('cusNumber' => implode("<br>", $_REQUEST['phone']),
                  'cusEmail' => $_REQUEST['email'],
                  'description' => $_REQUEST['description'],
                  'fb_link' => $_REQUEST['fb_link'],
                  'tw_link' => $_REQUEST['tw_link'],
                  'yt_link' => $_REQUEST['yt_link'],
                  'g_link' => $_REQUEST['g_link'],
                  'userId' => $this->session->userdata('id'),
                  );
    $update = $this->Common_Model->customer_care_update($data);
    $description = 'Customer care details updated';
    AdminlogActivity($description);
    redirect('../backend/common/customer_care');
  }
  public function about(){
    $data['view']=$this->Common_Model->about_select();
    $aboutMenu = menuPermissionAvailability($this->session->userdata('id'),'General','About Us'); 
    if (count($aboutMenu)!=0 && $aboutMenu[0]->view==1) {
      $this->load->view('backend/general/about',$data);
    } else {
      redirect(base_url().'backend/dashboard');
    }
  }
  public function about_update() {
    about_image_upload();
    $data = array('about_title' => $_REQUEST['about_title'],
                  'about_content' => $_REQUEST['content'],
                  'best_hotel' => $_REQUEST['best_hotel'],
                  'best_price_guarantee' => $_REQUEST['best_price'],
                  'super_fast_booking' => $_REQUEST['best_booking'],
                  'userId' => $this->session->userdata('id'),
                  );
    $update = $this->Common_Model->about_update($data);
    redirect('../backend/common/about');
  }  
  public function paymentgateway() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $data['checkout'] = $this->Common_Model->checkoutdetails();
    $data['paypal'] = $this->Common_Model->paypaldetails();
    $data['braintree'] = $this->Common_Model->braintreedetails();
    $data['mollie'] = $this->Common_Model->molliedetails();
    $data['authorizeSIM'] = $this->Common_Model->authorizeSIMdetails();
    $data['authorizeAIM'] = $this->Common_Model->authorizeAIMdetails();
    $data['stripe'] = $this->Common_Model->stripedetails();
    $data['telr'] = $this->Common_Model->telrdetails();
    $gatewaysMenu = menuPermissionAvailability($this->session->userdata('id'),'General','Payment Gateways'); 
    if (count($gatewaysMenu)!=0 && $gatewaysMenu[0]->view==1) {
      $this->load->view("backend/general/paymentgateway",$data);
    } else {
      redirect(base_url().'backend/dashboard');
    }      
  }
  public function checkoutsubmit() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $active=0;
    if($_REQUEST['checkout_active']=='1') {
      if($_REQUEST['checkout_label']=="" || $_REQUEST['checkout_acc_num']=="" || $_REQUEST['checkout_pvt_key']=="" || $_REQUEST['checkout_publish_key']=="" || $_REQUEST['checkout_currency']==""){
        $active=0;
      }
      else {
        $active =1;
      }
    } 
    $data =  array(
                    'label' => $_REQUEST['checkout_label'],
                    'account_number' => $_REQUEST['checkout_acc_num'],
                    'private_key' => $_REQUEST['checkout_pvt_key'],
                    'publishable_key' => $_REQUEST['checkout_publish_key'],
                    'currency' => $_REQUEST['checkout_currency'], 
                    'enable' => $_REQUEST['checkout_accepting'],
                    'on_invoice'=>$_REQUEST['checkout_default'],
                    'active' => $active,
                    'updated_date' => date('Y-m-d'),
                    'updated_by' => $this->session->userdata('id'),
                );
      $result = $this->Common_Model->checkoutsubmit($data);
      $description = '2Checkout payment gateway details updated';
      AdminlogActivity($description);
      redirect(base_url().'backend/common/paymentgateway');
  } 
  public function paypalsubmit() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $active=0;
    if($_REQUEST['paypal_active']=='1') {
      if($_REQUEST['paypal_label']=="" || $_REQUEST['paypal_username']=="" || $_REQUEST['paypal_password']=="" || $_REQUEST['paypal_signature']=="" || $_REQUEST['paypal_currency']==""){
        $active=0;
      }
      else {
        $active =1;
      }
    } 
    $data =  array(
                    'label' => $_REQUEST['paypal_label'],
                    'username' => $_REQUEST['paypal_username'],
                    'password' => $_REQUEST['paypal_password'],
                    'signature' => $_REQUEST['paypal_signature'],
                    'currency' => $_REQUEST['paypal_currency'], 
                    'enable' => $_REQUEST['paypal_accepting'],
                    'on_invoice'=>$_REQUEST['paypal_default'],
                    'active' => $active,
                    'updated_date' => date('Y-m-d'),
                    'updated_by' => $this->session->userdata('id'),
                );
      $result = $this->Common_Model->paypalsubmit($data);
      $description = 'Paypal payment gateway details updated';
      AdminlogActivity($description);
      redirect(base_url().'backend/common/paymentgateway');
  }  
  public function braintreesubmit() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $active=0;
    if($_REQUEST['braintree_active']=='1') {
      if($_REQUEST['braintree_label']=="" || $_REQUEST['braintree_merchantid']=="" || $_REQUEST['braintree_pub_key']=="" || $_REQUEST['braintree_pvt_key']=="" || $_REQUEST['braintree_currency']==""){
        $active=0;
      }
      else {
        $active =1;
      }
    } 
    $data =  array(
                    'label' => $_REQUEST['braintree_label'],
                    'merchantID' => $_REQUEST['braintree_merchantid'],
                    'public_key' => $_REQUEST['braintree_pub_key'],
                    'private_key' => $_REQUEST['braintree_pvt_key'],
                    'currency' => $_REQUEST['braintree_currency'], 
                    'enable' => $_REQUEST['braintree_accepting'],
                    'on_invoice'=>$_REQUEST['braintree_default'],
                    'active' => $active,
                    'updated_date' => date('Y-m-d'),
                    'updated_by' => $this->session->userdata('id'),
                );
      $result = $this->Common_Model->braintreesubmit($data);
      $description = 'Braintree payment gateway details updated';
      AdminlogActivity($description);
      redirect(base_url().'backend/common/paymentgateway');
  }  
  public function molliesubmit() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $active=0;
    if($_REQUEST['mollie_active']=='1') {
      if($_REQUEST['mollie_label']=="" || $_REQUEST['mollie_api_key']=="" || $_REQUEST['mollie_currency']==""){
        $active=0;
      }
      else {
        $active =1;
      }
    } 
    $data =  array(
                    'label' => $_REQUEST['mollie_label'],
                    'api_key' => $_REQUEST['mollie_api_key'],
                    'currency' => $_REQUEST['mollie_currency'], 
                    'enable' => $_REQUEST['mollie_accepting'],
                    'on_invoice'=>$_REQUEST['mollie_default'],
                    'active' => $active,
                    'updated_date' => date('Y-m-d'),
                    'updated_by' => $this->session->userdata('id'),
                );
      $result = $this->Common_Model->molliesubmit($data);
      $description = 'Mollie payment gateway details updated';
      AdminlogActivity($description);
      redirect(base_url().'backend/common/paymentgateway');
  }  
  public function authorizeSIMsubmit() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $active=0;
    if($_REQUEST['authorizeSIM_active']=='1') {
      if($_REQUEST['authorizeSIM_label']=="" || $_REQUEST['authorizeSIM_loginid']=="" || $_REQUEST['authorizeSIM_trans_id']=="" || $_REQUEST['authorizeSIM_secret_key']=="" || $_REQUEST['authorizeSIM_currency']==""){
        $active=0;
      }
      else {
        $active =1;
      }
    } 
    $data =  array(
                    'label' => $_REQUEST['authorizeSIM_label'],
                    'loginid' => $_REQUEST['authorizeSIM_loginid'],
                    'trans_id' => $_REQUEST['authorizeSIM_trans_id'],
                    'secret_key' => $_REQUEST['authorizeSIM_secret_key'],
                    'currency' => $_REQUEST['authorizeSIM_currency'], 
                    'test_enable' => $_REQUEST['authorizeSIM_accepting'],
                    'on_invoice'=>$_REQUEST['authorizeSIM_default'],
                    'active' => $active,
                    'developer_enable' => $_REQUEST['authorizeSIM_developer'],
                    'updated_date' => date('Y-m-d'),
                    'updated_by' => $this->session->userdata('id'),
                );
      $result = $this->Common_Model->authorizeSIMsubmit($data);
      $description = 'AuthorizeSIM payment gateway details updated';
      AdminlogActivity($description);
      redirect(base_url().'backend/common/paymentgateway');
  }  
  public function authorizeAIMsubmit() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $active=0;
    if($_REQUEST['authorizeAIM_active']=='1') {
      if($_REQUEST['authorizeAIM_label']=="" || $_REQUEST['authorizeAIM_loginid']=="" || $_REQUEST['authorizeAIM_trans_id']=="" || $_REQUEST['authorizeAIM_currency']==""){
        $active=0;
      }
      else {
        $active =1;
      }
    } 
    $data =  array(
                    'label' => $_REQUEST['authorizeAIM_label'],
                    'loginid' => $_REQUEST['authorizeAIM_loginid'],
                    'trans_id' => $_REQUEST['authorizeAIM_trans_id'],
                    'currency' => $_REQUEST['authorizeAIM_currency'], 
                    'test_enable' => $_REQUEST['authorizeAIM_accepting'],
                    'on_invoice'=>$_REQUEST['authorizeAIM_default'],
                    'active' => $active,
                    'updated_date' => date('Y-m-d'),
                    'updated_by' => $this->session->userdata('id'),
                );
      $result = $this->Common_Model->authorizeAIMsubmit($data);
      $description = 'AuthorizeAIM payment gateway details updated';
      AdminlogActivity($description);
      redirect(base_url().'backend/common/paymentgateway');
  }
  public function stripesubmit() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $active=0;
    if($_REQUEST['stripe_active']=='1') {
      if($_REQUEST['stripe_label']=="" || $_REQUEST['stripe_secret_key']=="" || $_REQUEST['stripe_pub_key']=="" || $_REQUEST['stripe_currency']==""){
        $active=0;
      }
      else {
        $active =1;
      }
    } 
    $data =  array(
                    'label' => $_REQUEST['stripe_label'],
                    'secret_key' => $_REQUEST['stripe_secret_key'],
                    'public_key' => $_REQUEST['stripe_pub_key'],
                    'currency' => $_REQUEST['stripe_currency'], 
                    'enable' => $_REQUEST['stripe_accepting'],
                    'on_invoice'=>$_REQUEST['stripe_default'],
                    'active' => $active,
                    'updated_date' => date('Y-m-d'),
                    'updated_by' => $this->session->userdata('id'),
                );
      $result = $this->Common_Model->stripesubmit($data);
      $description = 'Stripe payment gateway details updated';
      AdminlogActivity($description);
      redirect(base_url().'backend/common/paymentgateway');
  }
  public function paypal_modal() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $this->session->set_userdata('tabName','Paypal');
    $this->load->view("backend/general/paypal_modal");
  } 
  public function checkout_modal() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $this->session->set_userdata('tabName','2CheckOut');
    $data['checkoutdata'] = $this->Common_Model->checkoutdetails();
    $this->load->view("backend/general/checkout_modal",$data);
  }    
  public function TestPaymentGateway() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $paypaldata = $this->Common_Model->paypaldetails();
    $this->Paypal_gateway->process_payment($_REQUEST,$paypaldata);
  }
  public function braintree_modal() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $this->session->set_userdata('tabName','Braintree');
    $braintreedata = $this->Common_Model->braintreedetails();
    $data['token'] = $this->Paypal_braintree_gateway->generate_token($braintreedata);
    $this->load->view("backend/general/braintree_modal",$data);
  }  
  public function mollie_modal() { 
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $this->session->set_userdata('tabName','Mollie');
    $data['mollie'] = $this->Common_Model->molliedetails();
    $this->load->view("backend/general/mollie_modal",$data);
  }  
  public function TestPaymentGateway_Mollie() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $molliedata = $this->Common_Model->molliedetails();
    $this->Mollie_gateway->process_payment($_REQUEST,$molliedata);
  }  
  public function authorizeAIM_modal() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $this->session->set_userdata('tabName','authorizeAIM');
    $data['aimdata'] = $this->Common_Model->authorizeAIMdetails();
    $this->load->view("backend/general/authorizeAIM_modal",$data);
  }
  public function authorizeSIM_modal() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $this->session->set_userdata('tabName','authorizeSIM');
    $this->load->view("backend/general/authorizeSIM_modal");
  }    
  public function TestPaymentGateway_AuthorizeSim() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $simdata = $this->Common_Model->authorizeSIMdetails();
    $this->Authorize_sim_gateway->process_payment($_REQUEST,$simdata);
  }
  public function stripe_modal() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $this->session->set_userdata('tabName','Stripe');
    $this->load->view("backend/general/stripe_modal");
  }  
  public function TestPaymentGateway_Stripe() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $stripedata = $this->Common_Model->stripedetails();
    $this->Stripe_gateway->process_payment($_REQUEST,$stripedata);
  }
  public function databaseBackup() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $dbMenu = menuPermissionAvailability($this->session->userdata('id'),'General','Database Backup'); 
    if (count($dbMenu)!=0 && $dbMenu[0]->view==1) {
      $this->load->view("backend/general/databaseBackup");
    } else {
      redirect(base_url().'backend/dashboard');
    }   
  }
  public function DatabaseBackupList() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $data = array();
    // Datatables Variables
    $draw = intval($this->input->get("draw"));
    $start = intval($this->input->get("start"));
    $length = intval($this->input->get("length"));
    
    $path = BACKUPS_FOLDER;
    $files =  new FilesystemIterator($path); 
    $i=1;
    foreach($files as $key => $fileInfo){
      $dbMenu = menuPermissionAvailability($this->session->userdata('id'),'General','Database Backup'); 
      if (count($dbMenu)!=0 && $dbMenu[0]->delete==1) {
        $delete = '<a href="#" onclick="deleteBackupDB(\''.$fileInfo->getFileName().'\')" class="btn-sm btn-danger"><i class="fa fa-trash"></i></a>';
      } else {
        $delete = '';
      } 
      if ($fileInfo->getSize() > 0) {
          $precision = 2;
          $size = (int) $fileInfo->getSize();
          $base = log($size) / log(1024);
          $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');
          $size =  round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
      } else {
          $size = $fileInfo->getSize();
      }

       $cTime = new DateTime();
       $cTime->setTimestamp($fileInfo->getCTime());
       $fileInfo->getFileName() . " file Created " . $cTime->format('Y-m-d h:i:s') .  "<br/>\n";
       $data[] = array(
          $i,
          '<a href="'.base_url().'/backups/'.$fileInfo->getFileName().'">'.$fileInfo->getFileName().'</a>',
          $size,
          $cTime->format('Y-m-d h:i:s'),
          $delete
       );
       $i++;
    }
    $output = array(
          "draw" => $draw,
           "recordsTotal" => count($files),
           "recordsFiltered"=> count($files),
           "data" => $data
      );

    echo json_encode($output);
    exit();
  }
  public function make_backup_db()  {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    if (!is_really_writable(BACKUPS_FOLDER)) {
        $return['error'] = '/backups folder is not writable. You need to change the permissions to 755';
        $return['color'] = 'red';
    }
    $success = $this->Common_Model->make_backup_db(true);
    if ($success) {
        $return['error'] = 'Created Successfully';
        $return['color'] = 'green';
        $description = 'Database backup created';
        AdminlogActivity($description);
    }
    echo json_encode($return);
  }
  public function delete_backup($backup) {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    } 
    if (unlink(BACKUPS_FOLDER . $backup)) {
        $return['error'] = 'Deleted Successfully';
        $return['color'] = 'green';
        $description = 'Database backup deleted [Name: '.$backup.']';
        AdminlogActivity($description);
    }
    echo json_encode($return);
  }
  public function activityLog() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $activitylogMenu = menuPermissionAvailability($this->session->userdata('id'),'Activity Logs',''); 
    if (count($activitylogMenu)!=0 && $activitylogMenu[0]->view==1) {
      $this->load->view("backend/general/activityLog");
    } else {
      redirect(base_url().'backend/dashboard');
    }       
  }
  public function ActivityLogList() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $data = array();
    // Datatables Variables
    $draw = intval($this->input->get("draw"));
    $start = intval($this->input->get("start"));
    $length = intval($this->input->get("length")); 
    if (isset($_REQUEST['date'])) {
      $date = $_REQUEST['date'];
    } else {
      $date = '';
    }
    $Activity = $this->Common_Model->ActivityLogList($date);
    foreach($Activity->result() as $key => $r) {
       $data[] = array(
          $key+1,
          $r->description,
          $r->date,
          $r->type,
          $r->Name,
      );
    }

    $output = array(
            "draw" => $draw,
             "recordsTotal" => $Activity->num_rows(),
             "recordsFiltered"=> $Activity->num_rows(),
             "data" => $data
    );
    echo json_encode($output);
    exit();
  }
  public function ClearActivityLog() {
    $this->db->from('tblactivitylog');
    $this->db->truncate(); 
    $return['error'] = 'Deleted Successfully';
    $return['color'] = 'green';
    echo json_encode($return);
  }
  public function telr_test() {
    $this->load->view('backend/general/telr_test');
  }
  public function telrsubmit() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $active=0;
    if($_REQUEST['telr_active']=='1') {
      if($_REQUEST['telr_label']=="" || $_REQUEST['telr_store_id']=="" || $_REQUEST['telr_auth_id']==""){
        $active=0;
      }
      else {
        $active =1;
      }
    } 
    $data =  array(
                    'label' => $_REQUEST['telr_label'],
                    'store_id' => $_REQUEST['telr_store_id'],
                    'auth_id' => $_REQUEST['telr_auth_id'],
                    'test_enable' => $_REQUEST['telr_accepting'],
                    'on_invoice'=>$_REQUEST['telr_default'],
                    'active' => $active,
                    'updated_date' => date('Y-m-d'),
                    'updated_by' => $this->session->userdata('id'),
                );
      $result = $this->Common_Model->telrsubmit($data);
      redirect(base_url().'backend/common/paymentgateway');
  }
  public function telr_modal() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $this->session->set_userdata('tabName','Telr');
    $this->load->view("backend/general/telr_model");
  }   
  public function TestPaymentGateway_Telr() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $telrdata = $this->Common_Model->telrdetails();
    $this->Telr_gateway->process_test_payment($_REQUEST);
  }
  public function onlinepaymentrecords() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $paymentrecordsMenu = menuPermissionAvailability($this->session->userdata('id'),'Online Payments',''); 
    if (count($paymentrecordsMenu)!=0 && $paymentrecordsMenu[0]->view==1) {
        $this->load->view('backend/general/onlinepaymentlist');
    } else {
      redirect(base_url().'backend/dashboard');
    }    
  }
  public function onlinepaymentslist() {
      $data = array();
      // Datatables Variables
      $draw = intval($this->input->get("draw"));
      $start = intval($this->input->get("start"));
      $length = intval($this->input->get("length"));
      $paymentdata = $this->Common_Model->getpaymentrecordsdata();
        foreach($paymentdata->result() as $key => $r) {
            $data[] = array(
              $key+1,
              $r->bookingid,
              date('d/m/Y' ,strtotime($r->date)),
              $r->transactionId,
              $r->orderNumber,
              $r->amount.' '.$r->currency,
              $r->method,
              $r->Fname.' '.$r->Lname,
            );
        }
        $output = array(
          "draw" => $draw,
         "recordsTotal"    => $paymentdata->num_rows(),
         "recordsFiltered" => $paymentdata->num_rows(),
         "data" => $data
        );
        echo json_encode($output);
        exit();
  }
  public function logViewer() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $errorlogMenu = menuPermissionAvailability($this->session->userdata('id'),'Error Logs',''); 
    if (count($errorlogMenu)!=0 && $errorlogMenu[0]->view!=1) {
        redirect(base_url().'backend/dashboard');
    } 
    init_head();
    echo '<div class="sb2-2">';
    echo $this->logViewer->showLogs();
    echo '</div>';
    init_tail();
  }
  public function banner_modal() {
    $data['hotels'] = $this->Hotels_Model->hotel_list_select(1)->result();
    $query = $this->Common_Model->hotelBannerDetails();
    $data['permission'] = $query[0]->htl_banner;
    $data['single'] = $query[0]->single_banner;
    $this->load->view("backend/general/banner_modal",$data);
  }
  public function hotelsBannerUpdate() {
    $this->Common_Model->hotelsBannerUpdate($_REQUEST);
    $description = 'Hotels banner updated for home page [id:1]';
    AdminlogActivity($description);
    redirect(base_url().'backend/login/general_settings');
  }
  public function citylist() {
    $this->load->view("backend/general/citylist");
  }
  public function city_list_data() {
    $data = array();
      // Datatables Variables
      $draw = intval($this->input->get("draw"));
      $start = intval($this->input->get("start"));
      $length = intval($this->input->get("length"));
      $citylist = $this->Common_Model->city_list_data();
        foreach($citylist->result() as $key => $r) {
            $data[] = array(
              $key+1,
              $r->CityName,
              $r->CityCode,
              $r->countryName,
            );
        }
        $output = array(
          "draw" => $draw,
         "recordsTotal"    => $citylist->num_rows(),
         "recordsFiltered" => $citylist->num_rows(),
         "data" => $data
        );
        echo json_encode($output);
        exit();
  }
  public function citylistupload() {
    $file = $_FILES['citylist']['tmp_name'];
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
    foreach($arr_data as $value) {
      $update = $this->Common_Model->cityUpdate($value);
    }
    $description = 'City details updated';
    AdminlogActivity($description); 
    redirect('../backend/common/citylist');  
  }
  public function currencyapi_update() {
    if ($this->session->userdata('name')=="") {
     redirect("../backend/logout");
    }
    $data = array('currency_api' => $_REQUEST['currency_api'],
                );
    $update = $this->Common_Model->general_settings_currencyapi_update($data);
    $description = 'Currency API details updated to '.$_REQUEST['currency_api'];
    AdminlogActivity($description); 
    redirect('../backend/common/payment');
  }
  public function test_currency_api() {
    if ($this->session->userdata('name')=="") {
     redirect("../backend/logout");
    }
    $api = $this->Common_Model->get_currencyapi();
    $arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
      ),
    "http" =>array(
        "ignore_errors" => true,
    ),
  );
    $resultKey = 'AED_INR';
    $get = file_get_contents("http://free.currencyconverterapi.com/api/v6/convert?q=".$resultKey."&&compact=ultra&apiKey=".$api[0]->currency_api, false, stream_context_create($arrContextOptions));
    $get = json_decode($get);
    if(isset($get->error)){
     $return['value'] = $get->error;
    } else {
      $return['value'] =  $get->AED_INR;
    }  
    echo json_encode($return);
  }
  public function boardsupplementLog() {
    $data['view']= $this->Hotels_Model->check_room();
    $this->load->view('backend/general/boardsupplementLog',$data);
  }
  public function BoardSupplementLogList() {
    $data = array();
    // Datatables Variables
    $draw = intval($this->input->get("draw"));
    $start = intval($this->input->get("start"));
    $length = intval($this->input->get("length"));
    $BSL = $this->Common_Model->BoardSupplementLogList($_REQUEST);
      foreach($BSL->result() as $key => $r) {
          $explode_data[$key]= explode(",", $r->roomType);
          foreach ($explode_data[$key] as $key1 => $value1) {
             $room_type_data[$key][$key1] = get_room_name_type($value1);
          }
          $implode_data[$key] = implode(", ", $room_type_data[$key]);
          $data[] = array(
            $key+1,
            $r->id,
            $r->board,
            $implode_data[$key],
            $r->season,
            $r->fromDate,
            $r->toDate,
            $r->startAge,
            $r->finalAge,
            $r->amount,
            $r->hotel_name,
            $r->contract_id,
            $r->Status,
            $r->CreatedDate,
            $r->Name,
          );
      }
      $output = array(
        "draw" => $draw,
       "recordsTotal"    => $BSL->num_rows(),
       "recordsFiltered" => $BSL->num_rows(),
       "data" => $data
      );
      echo json_encode($output);
      exit();
  }
  public function generalsupplementLog() {
    $this->load->view('backend/general/generalsupplementLog');
  }
  public function GeneralSupplementLogList() {
    $data = array();
    // Datatables Variables
    $draw = intval($this->input->get("draw"));
    $start = intval($this->input->get("start"));
    $length = intval($this->input->get("length"));
    $BSL = $this->Common_Model->GeneralSupplementLogList($_REQUEST);
      foreach($BSL->result() as $key => $r) {
        if ($r->mandatory==1) {
          $mandatory = '<span class="bold text-success">Yes</span>';
        } else {
          $mandatory = '<span class="bold text-danger">No</span>';
        }
        $explode_data[$key]= explode(",", $r->roomType);
        foreach ($explode_data[$key] as $key1 => $value1) {
           $room_type_data[$key][$key1] = get_room_name_type($value1);
        }
        $implode_data[$key] = implode(", ", $room_type_data[$key]);
          $data[] = array(
            $key+1,
            $r->id,
            $r->type,
            $implode_data[$key],
            $r->season,
            $r->fromDate,
            $r->toDate,
            $r->MinChildAge,
            $r->adultAmount,
            $r->childAmount,
            $r->application,
            $mandatory,
            $r->hotel_name,
            $r->contract_id,
            $r->Status,
            $r->CreatedDate,
            $r->Name,
          );
      }
      $output = array(
        "draw" => $draw,
       "recordsTotal"    => $BSL->num_rows(),
       "recordsFiltered" => $BSL->num_rows(),
       "data" => $data
      );
      echo json_encode($output);
      exit();
  }
  public function extrabedLog() {
    $this->load->view('backend/general/extrabedLog');
  }
  public function extrabedLogList() {
    $data = array();
    // Datatables Variables
    $draw = intval($this->input->get("draw"));
    $start = intval($this->input->get("start"));
    $length = intval($this->input->get("length"));
    $BSL = $this->Common_Model->extrabedLogList($_REQUEST);
      foreach($BSL->result() as $key => $r) {
        $explode_data[$key]= explode(",", $r->roomType);
        foreach ($explode_data[$key] as $key1 => $value1) {
           $room_type_data[$key][$key1] = get_room_name_type($value1);
        }
        $implode_data[$key] = implode(", ", $room_type_data[$key]);
          $data[] = array(
            $key+1,
            $r->id,
            $implode_data[$key],
            $r->season,
            $r->from_date,
            $r->to_date,
            $r->ChildAgeFrom,
            $r->ChildAgeTo,
            $r->ChildAmount,
            $r->amount,
            $r->hotel_name,
            $r->contract_id,
            $r->Status,
            $r->CreatedDate,
            $r->Name,
          );
      }
      $output = array(
        "draw" => $draw,
       "recordsTotal"    => $BSL->num_rows(),
       "recordsFiltered" => $BSL->num_rows(),
       "data" => $data
      );
      echo json_encode($output);
      exit();
  }
  public function cancellationLog() {
  }
}


