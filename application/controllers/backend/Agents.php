<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Agents extends MY_Controller {

  
  public function __construct()
     {
          parent::__construct();
          $this->load->model('Agents_Model');
          $this->load->model('Hotels_Model');
          $this->load->helper('url');
          $this->load->helper('html');
          $this->load->helper('form');
          $this->load->helper('upload');
          $this->load->helper('common');
          $this->load->library('email');
          $this->load->helper('manuallog');
     }
  
  public function index()
  {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $agentmenu = menuPermissionAvailability($this->session->userdata('id'),'Agents',''); 
    if (count($agentmenu)!=0 && $agentmenu[0]->view==1) {
     $this->load->view('backend/Agents/index'); 
    } else {
      redirect(base_url().'backend/dashboard');
    }
  }
  public function new_agent()
  {
    $data['currency_list']= $this->Agents_Model->currency();
    $data['title'] = title();
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $agentmenu = menuPermissionAvailability($this->session->userdata('id'),'Agents','');
    $data['contry']= $this->Agents_Model->SelectCountry();
    if (isset($_REQUEST['edit_id']) && $_REQUEST['edit_id'] !="") {
      $id=$_REQUEST['edit_id'];
      $data['view'] = $this->Agents_Model->general_settings_select($id);
      $data['edit'] = $this->Agents_Model->edit($_REQUEST['edit_id']);
      $data['edit']['gender'] = [$data['edit'][0]->Sex=>$data['edit'][0]->Sex,'1'=>'Male','2' =>'Female','3'=>'Others'] ;
      if (count($agentmenu)!=0 && $agentmenu[0]->view==1 && $agentmenu[0]->edit==1) {
        $this->load->view('backend/Agents/new_agent',$data); 
      } else {
        redirect(base_url().'backend/dashboard');
      }
    } else {
      $agent_max_id = $this->Agents_Model->agent_max_id();
      $agent_id = $agent_max_id[0]->id+1;
      if (count($agent_max_id)==0) {
        $data['agent_max_id'] = "HA0001";
      } else {
        $data['agent_max_id'] = "HA00".$agent_id;
      } 
      $data['edit'] =array();
      $data['edit']['gender'] = ['1' => 'Male' ,'2' =>'Female' ,'3' =>'Others'];
      if (count($agentmenu)!=0 && $agentmenu[0]->view==1 && $agentmenu[0]->create==1) {
        $this->load->view('backend/Agents/new_agent',$data); 
      } else {
        redirect(base_url().'backend/dashboard');
      }
    }
  }
  public function agent_validation() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    } 
    if ($_REQUEST['email']!="") {
      if ($_REQUEST['edit_id']!="") {
        $mail = "1";
      } else {
        $mail = email_validation($_REQUEST['email']);
      }
    } else {
      $mail = "1";
    }
    if ($_REQUEST['agency_name']=="") {
      $Return['error'] = 'Agency Name field is required!';
      $Return['color'] = 'orange';
    }
    else if ($_REQUEST['email']=="") {
      $Return['error'] = 'Agency Email field is required!';
      $Return['color'] = 'orange';
    }
    else if (!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)) {
          $Return['error'] = "Invalid email format"; 
          $Return['color'] = 'orange'; 
    }
    else if ($_REQUEST['first_name']=="") {
          $Return['error'] = 'First Name field is required!';
          $Return['color'] = 'orange';
    }
    else if ($_REQUEST['last_name']=="") {
      $Return['error'] = 'Last Name field is required!';
      $Return['color'] = 'orange';
    }
    // else if ($_REQUEST['designation']=="") {
    //   $Return['error'] = 'Designation field is required!';
    //   $Return['color'] = 'orange';
    // }
    // else if ($_REQUEST['nature_business']=="") {
    //   $Return['error'] = 'Nature of Business field is required!';
    //   $Return['color'] = 'orange';
    // }
    // else if ($_REQUEST['iata_status']=="Approved" && $_REQUEST['iata_reg']=="") {
    //       $Return['error'] = 'IATA Registration Number field is required!!';
    //       $Return['color'] = 'orange';
    // }
    // else if ($_REQUEST['business_type']=="") {
    //   $Return['error'] = 'Business Type field is required!';
    //   $Return['color'] = 'orange';
    // }
    // else if ($_REQUEST['phone']=="") {
    //   $Return['error'] = 'Mobile field is required!';
    //   $Return['color'] = 'orange';
    // }
    // else if ($_REQUEST['preferred_currency']=="") {
    //   $Return['error'] = 'Preferred Currency field is required!';
    //   $Return['color'] = 'orange';
    // }
    // else if ($_REQUEST['pincode']=="") {
    //   $Return['error'] = 'Pincode field is required!';
    //   $Return['color'] = 'orange';
    // }
    // else if ($_REQUEST['sex']=="") {
    //   $Return['error'] = 'Sex field is required!';
    //   $Return['color'] = 'orange';
    // }
    // else if ($_REQUEST['telephone']=="") {
    //   $Return['error'] = 'Telephone field is required!';
    //   $Return['color'] = 'orange';
    // }
    // else if ($_REQUEST['city']=="") {
    //   $Return['error'] = 'City field is required!';
    //   $Return['color'] = 'orange';
    // }
    // else if ($_REQUEST['country']=="") {
    //   $Return['error'] = 'Country field is required!';
    //   $Return['color'] = 'orange';
    // }
    // else if ($_REQUEST['username']=="") {
    //   $Return['error'] = 'Username field is required!';
    //   $Return['color'] = 'orange';
    // }
    // else if ($_REQUEST['fax']=="") {
    //   $Return['error'] = 'Fax field is required!';
    //   $Return['color'] = 'orange';
    // }
    // else if ($_REQUEST['website']=="") {
    //   $Return['error'] = 'Website field is required!';
    //   $Return['color'] = 'orange';
    // }
    // else if ($_REQUEST['gen_markup']=="") {
    //   $Return['error'] = 'Admin markup field is required!';
    //   $Return['color'] = 'orange';
    // }
    // else if ($_REQUEST['credit']=="") {
    //   $Return['error'] = 'Credit Amount field is required!';
    //   $Return['color'] = 'orange';
    // } 
    // else if ($_REQUEST['address']=="") {
    //   $Return['error'] = 'Address field is required!';
    //   $Return['color'] = 'orange';
    // }
    //  else if ($_REQUEST['first_name_accounts']=="") {
    //   $Return['error'] = 'First Name in Accounts field is required!';
    //   $Return['color'] = 'orange';
    // }
    //  else if ($_REQUEST['first_name_reservation']=="") {
    //   $Return['error'] = 'First Name in Reservation/Operations field is required!';
    //   $Return['color'] = 'orange';
    // }
    //  else if ($_REQUEST['first_name_management']=="") {
    //   $Return['error'] = 'First Name in Management field is required!';
    //   $Return['color'] = 'orange';
    // }  
    // else if ($_REQUEST['email_accounts']=="") {
    //   $Return['error'] = 'Email in Accounts field is required!';
    //   $Return['color'] = 'orange';
    // }
    else if (!filter_var($_REQUEST['email_accounts'], FILTER_VALIDATE_EMAIL)) {
          $Return['error'] = "Invalid email format in Accounts field"; 
          $Return['color'] = 'orange'; 
    }
    else if ($_REQUEST['email_reservation']=="") {
      $Return['error'] = 'Email in Reservation field is required!!';
      $Return['color'] = 'orange';
    }
    else if (!filter_var($_REQUEST['email_reservation'], FILTER_VALIDATE_EMAIL)) {
          $Return['error'] = "Invalid email format in Reservation/Operations field"; 
          $Return['color'] = 'orange'; 
    }
    else if ($_REQUEST['email_management']=="") {
      $Return['error'] = 'Email in Management field is required!!';
      $Return['color'] = 'orange';
    }
    else if (!filter_var($_REQUEST['email_management'], FILTER_VALIDATE_EMAIL)) {
          $Return['error'] = "Invalid email format in Management field"; 
          $Return['color'] = 'orange'; 
    }
    else if ($_REQUEST['password_accounts']=="") {
      $Return['error'] = 'Password in Accounts field is required!!';
      $Return['color'] = 'orange';
    }
    else if ($_REQUEST['password_reservation']=="") {
      $Return['error'] = 'Password in Reservation field is required!!';
      $Return['color'] = 'orange';
    }
    else if ($_REQUEST['password_management']=="") {
      $Return['error'] = 'Password in Management field is required!!';
      $Return['color'] = 'orange';
    }
    else if ($_REQUEST['number_accounts']=="") {
      $Return['error'] = 'Number in Accounts field is required!!';
      $Return['color'] = 'orange';
    }
    else if ($_REQUEST['number_reservation']=="") {
      $Return['error'] = 'Number in Reservation field is required!!';
      $Return['color'] = 'orange';
    }
    else if ($_REQUEST['number_management']=="") {
      $Return['error'] = 'Number in Management field is required!!';
      $Return['color'] = 'orange';
    }
     else if ($mail==0) {
          $Return['error'] = "Mail already exist"; 
          $Return['color'] = 'orange'; 
      }
       else {
          if ($_REQUEST['edit_id']!="") {
            $Return['error'] = "Updated Successfully!";
            $Return['color'] = 'green';
            $Return['status'] = '1';
          } else {
            $Return['error'] = "Inserted Successfully!";
            $Return['color'] = 'green';
            $Return['status'] = '1';
      }
        
  }
    echo json_encode($Return);

}
  public function add_new_agent() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    } 
    // if($agent_id!="")
    // {
    //   $target_dir = "uploads/trade_license";
    //   $target_file = $target_dir . basename($_FILES["tradefile"]["name"]);
    //   $uploadOk = 1;
    //   $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // }

    if ($_REQUEST['edit_id']!="") 
    {
      $result = $this->Agents_Model->update($_REQUEST,$_REQUEST['edit_id']);
      if ($_FILES['profile_image']!="") 
      {
        handle_agent_profile_image_upload($_REQUEST['edit_id']);
        handle_license_upload($_REQUEST['edit_id']);
        $description = 'Existing agent details updated [id:'.$_REQUEST['edit_id'].']';
        AdminlogActivity($description);
        // handle_agent_logo_upload($_REQUEST['edit_id']);
      }
      if ($_FILES['logo']!="") {
        handle_agent_logo_upload($_REQUEST['edit_id']);
          }
      redirect('../backend/Agents');
    } 
    else 
    {
      $agent_max_id = $this->Agents_Model->agent_max_id();
      $agent_id = $agent_max_id[0]->id+1;
      if (count($agent_max_id)==0) 
      {
        $agentid = "HA001";
      } 
      else
      {
        $agentid = "HA00".$agent_id;
      } 
      $agent_id = $this->Agents_Model->insert($_REQUEST,$agentid);
      if ($agent_id!="") {
        handle_agent_profile_image_upload($agent_id);
        handle_license_upload($agent_id);
        $description = 'New agent added [id:'.$agent_id.']';
        AdminlogActivity($description);
      }
      redirect('../backend/Agents');
    }
  }
  public function agent_list() {
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
    $agent = $this->Agents_Model->select($filter);
    // if ($this->session->userdata('role')=="3") {
    //   foreach($agent->result() as $key => $r) {
    //     if ($r->profile_image!="") {
    //          $img_path = base_url()."uploads/agent_profile_pic/".$r->id."/thumb_".$r->profile_image."";
    //     } else {
    //         $img_path = base_url()."assets/images/user/1.png";
    //     }
    //     $data[] = array(
    //       '<a title="view rooms" class="primary" href="agents/agent_credit_view?id='.$r->id.'"><i class="light-blue darken-4 fa fa-arrow-circle-right" aria-hidden="true"></i></a>',
    //       '<span class="list-img"><img src="'.$img_path.'" alt=""></span>',
    //        $r->Agent_Code,
    //       '<a href="#"><span class="list-enq-name">'.$r->First_Name." ".$r->Last_Name.'</span><span class="list-enq-city">'.$r->City.",".$r->Country.'</span></a>',
    //       $r->Mobile,
    //       $r->Email,
    //       $r->Country,
    //     );
    //   }
    // } else {
      foreach($agent->result() as $key => $r) {
        $agentmenu = menuPermissionAvailability($this->session->userdata('id'),'Agents','');
        $country_info = $this->Agents_Model->getCountry($r->Country);
        $country = isset($country_info[0]->name)?$country_info[0]->name:'';
        if($agentmenu[0]->delete!=0) {
            if ($r->delflg==0) {
                  $permission = '<div class="switch">
                        <label>
                            <input type="checkbox"   onchange="agentpermissionfun('.$r->id.',1);" >
                            <span class="lever"></span>
                          </label>
                      </div>';
            } else if ($r->delflg==2) {
                  $permission = '<div class="switch">
                        <label>
                            <input type="checkbox"   onchange="agentpermissionfun('.$r->id.',1);" >
                            <span class="lever"></span>
                          </label>
                      </div>';
            } else {
                  $permission = '<div class="switch">
                        <label>
                            <input type="checkbox" checked   onchange="deletefun('.$r->id.');" data-toggle="modal" data-target="#myModal3" >
                            <span class="lever"></span>
                          </label>
                      </div>';
            }
        }else{
          $permission="";
        }
        if($agentmenu[0]->edit!=0) {
          $edit='<a href="agents/new_agent?edit_id='.$r->id.'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
        }else{
          $edit="";
        }

        if ($r->profile_image!="") {
             $img_path = base_url()."uploads/agent_profile_pic/".$r->id."/thumb_".$r->profile_image."";
        } else {
            $img_path = base_url()."assets/images/user/1.png";
        }
        $data[] = array(
          '<a title="view rooms" class="primary" href="agents/agent_credit_view?id='.$r->id.'"><i class="light-blue darken-4 fa fa-arrow-circle-right" aria-hidden="true"></i></a>',
          '<span class="list-img"><img src="'.$img_path.'" alt=""></span>',
          $r->Agent_Code,
          '<a href="#"><span class="list-enq-name">'.$r->First_Name." ".$r->Last_Name.'</span><span class="list-enq-city">'.$r->City.",".$r->Country.'</span></a>',
          $r->Mobile,
          $r->Email,
          $country,
          $permission,
          $edit,
        );
      //}
    }
    $output = array(
       "draw" => $draw,
       "recordsTotal" => $agent->num_rows(),
       "recordsFiltered" => $agent->num_rows(),
       "data" => $data
    );
    echo json_encode($output);
    exit();
  }
  public function delete_agent() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $mail_settings = mail_details();
    $hotel=$this->Agents_Model->GetTitle();
    $agent_details = $this->Agents_Model->agent_details($_REQUEST['delete_id']);
    $result = $this->Agents_Model->delete_agent($_REQUEST['delete_id']);
    if ($result==true) {
      $Return['error'] = "Deleted Successfully";
          $Return['color'] = 'green';
          $Return['status'] = '1';
          $Return['table'] = 'agent_table';
          $description = 'Existing agent has been deleted [id:'.$_REQUEST['delete_id'].']';
          AdminlogActivity($description);
          $subject = 'Otelseasy Rejected your permission';
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
                    <h2 style="text-align: center;">Sorry You are Blocked!</h2>
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
                    color: #90A4AE;">Sorry! Your request to be an agent for Otelseasy has been rejected.</p>
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
      $this->email->to($agent_details[0]->Email);
      $this->email->bcc($agent_details[0]->Email_Accounts);
      $this->email->cc($agent_details[0]->Email_Reservation);
      $this->email->cc($agent_details[0]->Email_Management);
      
      $this->email->subject($subject);
      $this->email->message($message);
      
      // $this->email->send();
    
    } else {
      $Return['error'] = "Blocked Unsuccessfully!";
          $Return['color'] = 'red';
          $Return['table'] = 'agent_table';
    }
    // print_r($agent_details);
    // exit();
    echo json_encode($Return);
  }
  public function agentspermission() {
    $mail_settings = mail_details();
    $hotel=$this->Agents_Model->GetTitle();
    $agent_details = $this->Agents_Model->agent_details($_REQUEST['id']);
      $subject = 'Hotel easy accepted your permission';
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
                        text-transform: uppercase;" href="'.base_url().'Agentlogin">Click here to login</a></div>
                    <p style="color: cornsilk;
                    text-align: center;
                    color: #90A4AE;">Your agent portal has been activated. Contact your administrator if you have trouble logging in.</p>
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
      $this->email->to($agent_details[0]->Email);
      $this->email->bcc($agent_details[0]->Email_Accounts);
      $this->email->bcc($agent_details[0]->Email_Reservation);
      $this->email->bcc($agent_details[0]->Email_Management);
      
      $this->email->subject($subject);
      $this->email->message($message);
      
      // $this->email->send();
    $result = $this->Agents_Model->agents_permission($_REQUEST);
    $description = 'Updated an existing agent permission [id:'.$_REQUEST['id'].']';
    AdminlogActivity($description);
    echo json_encode("success");
  }
  public function agent_credit_view(){
    $credit['view1'] = $this->Agents_Model->agents_credit_details_view($_REQUEST['id']);
    $this->load->view('backend/Agents/credit_view',$credit);
  }
  public function agent_credit_view_tbl(){
        if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $data = array();
    // Datatables Variables
    $draw = intval($this->input->get("draw"));
    $start = intval($this->input->get("start"));
    $length = intval($this->input->get("length"));
    $credit = $this->Agents_Model->agents_credit_details($_REQUEST['id']);
      foreach($credit->result() as $key => $r) {
        $data[] = array(
                    $key+1,
                    $r->Total_credit,
                    $r->credit_amount,
                    $r->created_date,
                    $r->created_by,

        );
      }
    $output = array(
        "draw" => $draw,
       "recordsTotal" => $credit->num_rows(),
       "recordsFiltered" => $credit->num_rows(),
       "data" => $data
    );
    echo json_encode($output);
    exit();
  }
  public function add_credit() {
    $id=$_REQUEST['agent_id'];
    $amount=$_REQUEST['credit'];
    $add_credit= $this->Agents_Model->add_credit_agent_($_REQUEST,$amount);
    $description = 'Credit amount has been added for an existing user [id:'.$_REQUEST['agent_id'].']';
    AdminlogActivity($description);
    redirect('backend/Agents/agent_credit_view?id='.$id.'');
    // redirect('../backend/hotels/closeout_hotel?id='.$id.'');
  }
  public function banner_modal() {
    $data['hotels'] = $this->Hotels_Model->hotel_list_select(1)->result();
    $query = $this->Agents_Model->edit($_REQUEST['id']);
    $data['permission'] = $query[0]->htl_banner;
    $this->load->view('backend/Agents/banner_modal',$data);
  }
  public function hotelsBannerUpdate() {
    $this->Agents_Model->hotelsBannerUpdate($_REQUEST);
    $description = 'Hotels banner updated [id:'.$_REQUEST['id'].']';
    AdminlogActivity($description);
    redirect(base_url().'backend/Agents/new_agent?edit_id='.$_REQUEST['id'].'');
  }
  public function StateSelect() {
      $data = $this->Agents_Model->SelectState($_REQUEST['Conid']);
      echo json_encode($data);
  }
}
?>
