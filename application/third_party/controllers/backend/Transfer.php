<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transfer extends MY_Controller {

     public function __construct() {
          parent::__construct();
          $this->load->model('Transfer_Model');
          $this->load->model('Tour_Model');
          $this->load->model('List_Model');
          $this->load->model('Payment_Model');
          $this->load->helper('url');
          $this->load->helper('html');
          $this->load->helper('upload');
          $this->load->helper('form');
          $this->load->helper('common');
          $this->load->library('email');
          $this->load->helper('manuallog');
     }
     // @Transfer Supplier list page
     public function transferSupplier() {
          if ($this->session->userdata('name')=="") {
           redirect("../backend/");
          }  
          $supplierMenu = menuPermissionAvailability($this->session->userdata('id'),'Transfer','Transfer Supplier'); 
          if (count($supplierMenu)!=0 && $supplierMenu[0]->view==1) {
            $this->load->view('backend/transfer/transferSupplier');        
          } else {
            redirect(base_url().'backend/dashboard');
          }               
     }
     // @Transfer Supplier add and edit page
     public function newsupplier() {
         if ($this->session->userdata('name')=="") {
           redirect("../backend/");
         }
         $supplierMenu = menuPermissionAvailability($this->session->userdata('id'),'Transfer','Transfer Supplier');  
         if (isset($_REQUEST['edit_id']) && $_REQUEST['edit_id'] !="") {
           $id=$_REQUEST['edit_id'];
           $data['edit'] = $this->Transfer_Model->supplier_details($_REQUEST['edit_id']);
           if (count($supplierMenu)!=0 && $supplierMenu[0]->view==1 && $supplierMenu[0]->edit==1) {
            $this->load->view('backend/transfer/newsupplier',$data);         
           } else {
            redirect(base_url().'backend/dashboard');
           }      
         } else {
           $supplier_max_id = $this->Transfer_Model->supplier_max_id();
           $supplier_id = $supplier_max_id[0]->id+1;
           if (count($supplier_max_id)==0) {
             $data['supplier_max_id'] = "TRS001";
           } else {
             $data['supplier_max_id'] = "TRS00".$supplier_id;
           }
           if (count($supplierMenu)!=0 && $supplierMenu[0]->view==1 && $supplierMenu[0]->create==1) {
            $this->load->view('backend/transfer/newsupplier',$data);         
           } else {
            redirect(base_url().'backend/dashboard');
           }   
         }           
     }
     // @Transfer Supplier add and edit validation
     public function supplier_validation() {
         if ($this->session->userdata('name')=="") {
           redirect("../backend/logout");
         }
         if ($_REQUEST['supplier_name']=="") {
           $Return['error'] = 'Supplier Name field is required!';
           $Return['color'] = 'orange';
         }
         else if ($_REQUEST['phone_landline']=="") {
           $Return['error'] = 'Landline number field is required!';
           $Return['color'] = 'orange';
         }
         else if ($_REQUEST['salescontact_person']=="") {
           $Return['error'] = 'Sales contact person field is required!';
           $Return['color'] = 'orange';
         }
         else if ($_REQUEST['salescontact_num']=="") {
           $Return['error'] = 'Sales contact number field is required!';
           $Return['color'] = 'orange';
         }else if (!filter_var($_REQUEST['sales_contact_email'], FILTER_VALIDATE_EMAIL)) {
           $Return['error'] = "Invalid email format"; 
           $Return['color'] = 'orange'; 
         }
         else if ($_REQUEST['credit_limit']=="") {
           $Return['error'] = 'Credit Limit field is required!';
           $Return['color'] = 'orange';
         }
         else if ($_REQUEST['ops_contact_person']=="") {
           $Return['error'] = 'Ops contact person field is required!';
           $Return['color'] = 'orange';
         }
         else if ($_REQUEST['ops_contact_num']=="") {
           $Return['error'] = 'Ops contact number field is required!';
           $Return['color'] = 'orange';
         }
         else if (!filter_var($_REQUEST['ops_contact_email'], FILTER_VALIDATE_EMAIL)) {
           $Return['error'] = "Invalid email format"; 
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
     public function addsupplier() {
          if ($this->session->userdata('name')=="") {
           redirect("../backend/logout");
          } 
          $data=array('supplier_code' => $_REQUEST['supplier_code'],
                'supplier_name' => $_REQUEST['supplier_name'],
                'phone_landline' => $_REQUEST['phone_landline'],
                'salescontact_person' => $_REQUEST['salescontact_person'],
                'salescontact_num' => $_REQUEST['salescontact_num'],
                'sales_contact_email' => $_REQUEST['sales_contact_email'],
                'credit_limit' => $_REQUEST['credit_limit'],
                'ops_contact_person' => $_REQUEST['ops_contact_person'],
                'ops_contact_num' => $_REQUEST['ops_contact_num'],
                'ops_contact_email' => $_REQUEST['ops_contact_email'],
          );
          if ($_REQUEST['edit_id']!="") {
               $result = $this->Transfer_Model->update_supplier($data,$_REQUEST['edit_id']);
               $description = 'Transfer supplier details edited [ID: '.$_REQUEST['edit_id'].']';
          } else {
               $result = $this->Transfer_Model->add_supplier($data);
               $description = 'New transfer supplier details added [ID: '.$result.']';
          }
      AdminlogActivity($description);
      redirect(base_url().'backend/transfer/transferSupplier');
     }
     public function supplier_details_list() {
         if ($this->session->userdata('name')=="") {
           redirect("../backend/logout");
         }
         $data = array();
         // Datatables Variables
         $draw = intval($this->input->get("draw"));
         $start = intval($this->input->get("start"));
         $length = intval($this->input->get("length"));
         $supplier_details = $this->Transfer_Model->details_select();
           foreach($supplier_details->result() as $key => $r) {
             $supplierMenu = menuPermissionAvailability($this->session->userdata('id'),'Transfer','Transfer Supplier');  
             if($supplierMenu[0]->edit!=0) {
              $edit='<a href="newsupplier?edit_id='.$r->id.'" class="sb2-2-1-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
             } else {
              $edit= '';
             }
             if($supplierMenu[0]->delete!=0) {
              $delete='<a href="#" onclick="deletesupplierfun('.$r->id.');" data-toggle="modal" data-target="#myModal" class="sb2-2-1-edit delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
             } else {
              $delete = '';
             }
             $data[] = array(
               $r->supplier_code,
               $r->supplier_name,
               $r->phone_landline,
               $r->salescontact_person,
               $r->salescontact_num,
               $r->sales_contact_email,
               $r->credit_limit,
               $edit.$delete
             );
           
             }
         $output = array(
            "draw" => $draw,
            "recordsTotal" => $supplier_details->num_rows(),
            "recordsFiltered" => $supplier_details->num_rows(),
            "data" => $data
         );
         echo json_encode($output);
         exit();
     }
     public function delete_supplier() {
         if ($this->session->userdata('name')=="") {
           redirect("../backend/logout");
         }
         $this->Transfer_Model->delete_supplier($_REQUEST['delete_id']);
         $Return['error'] = "Deleted Successfully";
         $Return['color'] = 'green';
         $Return['status'] = '1';
         $description = 'Transfer supplier details deleted [ID: '.$_REQUEST['delete_id'].']';
         AdminlogActivity($description);
         echo json_encode($Return);
     }
     public function transfer_vehicle() {
          $vehicleMenu = menuPermissionAvailability($this->session->userdata('id'),'Transfer','Transfer Vehicle'); 
          if (count($vehicleMenu)!=0 && $vehicleMenu[0]->view==1) {
            $this->load->view('backend/transfer/transfer_vehicle');  
          } else {
            redirect(base_url().'backend/dashboard');
          }           
     }
     public function newvehicle() {
          if ($this->session->userdata('name')=="") {
            redirect("../backend/");
          }
          $vehicleMenu = menuPermissionAvailability($this->session->userdata('id'),'Transfer','Transfer Vehicle'); 
          $data['vehicleAirportsID'] = array();
          $data['supplier'] = $this->Transfer_Model->suppliers_select();
          $data['view']= $this->Tour_Model->SelectCountry();
          if (isset($_REQUEST['edit_id']) && $_REQUEST['edit_id'] !="") {
            $id=$_REQUEST['edit_id'];
            $data['edit'] = $this->Transfer_Model->vehicle_details($_REQUEST['edit_id']);
            $data['vehicleAirportsID'] = $this->Transfer_Model->vehicleAirportsID($_REQUEST['edit_id']);
            if (count($vehicleMenu)!=0 && $vehicleMenu[0]->view==1 && $vehicleMenu[0]->edit==1) {
              $this->load->view('backend/transfer/newvehicle',$data);        
            } else {
              redirect(base_url().'backend/dashboard');
            }  
          } else {
               $vehicle_max_id = $this->Transfer_Model->vehicle_max_id();
               $vehicle_id = $vehicle_max_id[0]->id+1;
               if (count($vehicle_max_id)==0) {
                    $data['vehicle_max_id'] = "TUV001";
               } else {
                    $data['vehicle_max_id'] = "TUV00".$vehicle_id;
               } 
               if (count($vehicleMenu)!=0 && $vehicleMenu[0]->view==1 && $vehicleMenu[0]->create==1) {
                  $this->load->view('backend/transfer/newvehicle',$data);        
               } else {
                  redirect(base_url().'backend/dashboard');
               } 
          }        
     }
     public function addvehicle(){
          $id = $this->Transfer_Model->addvehicle($_REQUEST);
          vehicle_image_upload($id);
          if($_REQUEST['edit_id']!="") {
            $description = 'Transfer vehicle details edited [ID: '.$_REQUEST['edit_id'].']';
          } else {
            $description = 'New transfer vehicle details added [ID: '.$id.']';
          }
          AdminlogActivity($description);
          redirect(base_url().'backend/transfer/transfer_vehicle');
     }
     public function vehicle_list() {
          if ($this->session->userdata('name')=="") {
           redirect("../backend/logout");
          }
          $data = array();
          // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));
          $vehicle_list = $this->Transfer_Model->vehicle_list();
          foreach($vehicle_list->result() as $key => $r) {
             $vehicleMenu = menuPermissionAvailability($this->session->userdata('id'),'Transfer','Transfer Vehicle'); 
             if($vehicleMenu[0]->edit!=0) {
              $edit='<a href="newvehicle?edit_id='.$r->id.'" class="sb2-2-1-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
             } else {
              $edit = '';
             }
             if($vehicleMenu[0]->delete!=0) {
              $delete='<a href="#" onclick="deletevehiclefun('.$r->id.');" data-toggle="modal" data-target="#myModal" class="sb2-2-1-edit delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
             } else {
              $delete = '';
             }
             $data[] = array(
               $key+1,
               $r->vehicleCode,
               '<a style="color:#2196f3;font-weight:bold" href="newsupplier?edit_id='.$r->SupplierId.'">'.$r->supplier_code.'</a>',
               $r->VehicleName,
               $r->Passengers,
               $r->Bags,
               $r->CountryName.','.$r->CityName,
               $r->WaitingTime.' '.$r->WaitingTimeType,
               $edit.$delete
             );
           
             }
          $output = array(
            "draw" => $draw,
            "recordsTotal" => $vehicle_list->num_rows(),
            "recordsFiltered" => $vehicle_list->num_rows(),
            "data" => $data
          );
          echo json_encode($output);
          exit();
     }
     public function transfer_contracts() {
          if ($this->session->userdata('name')=="") {
           redirect("../backend/");
          }  
          $contractMenu = menuPermissionAvailability($this->session->userdata('id'),'Transfer','Transfer Contracts'); 
          if (count($contractMenu)!=0 && $contractMenu[0]->view==1) {
            $this->load->view('backend/transfer/transfer_contracts'); 
          } else {
            redirect(base_url().'backend/dashboard');
          }                 
     }
     public function newcontract() {
          if ($this->session->userdata('name')=="") {
               redirect("../backend/");
          }
          $data['contractVehiclesID'] = array();
          $data['locations'] = array();
          $data['vehicles'] = $this->Transfer_Model->vehicle_list()->result();
          $contractMenu = menuPermissionAvailability($this->session->userdata('id'),'Transfer','Transfer Contracts'); 
          if (isset($_REQUEST['edit_id']) && $_REQUEST['edit_id'] !="") {
               $data['edit'] = $this->Transfer_Model->contract_details($_REQUEST['edit_id']);
               $data['contractVehiclesID'] = $this->Transfer_Model->contractVehiclesID($_REQUEST['edit_id']);
               $data['locations'] = $this->Transfer_Model->transferlocations($_REQUEST['edit_id']);
                if (count($contractMenu)!=0 && $contractMenu[0]->view==1 && $contractMenu[0]->edit==1) {
                  $this->load->view("backend/transfer/newcontract",$data);         
                } else {
                  redirect(base_url().'backend/dashboard');
                } 
          } else {
               $contract_max_id = $this->Transfer_Model->contract_max_id();
               $contract_id = $contract_max_id[0]->id+1;
               if (count($contract_max_id)==0) {
                    $data['contract_max_id'] = "TRC0001";
               } else {
                    $data['contract_max_id'] = "TR00".$contract_id;
               } 
               if (count($contractMenu)!=0 && $contractMenu[0]->view==1 && $contractMenu[0]->create==1) {
                  $this->load->view("backend/transfer/newcontract",$data);         
                } else {
                  redirect(base_url().'backend/dashboard');
                } 
          }        
     }
     public function contract_validation() {
          if ($this->session->userdata('name')=="") {
               redirect("../backend/logout");
          }
          if ($_REQUEST['contractName']=="") {
               $Return['error'] = 'Contract Name field is required!';
               $Return['color'] = 'orange';
          }
          else if ($_REQUEST['Passenger_cost']=="") {
               $Return['error'] = 'Passenger cost field is required!';
               $Return['color'] = 'orange';
          }
          else if ($_REQUEST['Passenger_selling']=="") {
               $Return['error'] = 'Passenger selling field is required!';
               $Return['color'] = 'orange';
          }
          else if ($_REQUEST['description']=="") {
               $Return['error'] = 'Description field is required!';
               $Return['color'] = 'orange';
          }
          else if ($_REQUEST['transfer_type']=="") {
               $Return['error'] = 'Transfer type field is required!';
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
     public function addcontract() {
          if ($this->session->userdata('name')=="") {
               redirect("../backend/logout");
          } 
          $result = $this->Transfer_Model->add_contract($_REQUEST);
          redirect(base_url().'backend/transfer/transfer_contracts');
     }
     public function contract_details_list() {
          if ($this->session->userdata('name')=="") {
               redirect("../backend/logout");
          }
          $data = array();
          // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));
          $contract_details = $this->Transfer_Model->contract_details_select();
          foreach($contract_details->result() as $key => $r) {
             $contractMenu = menuPermissionAvailability($this->session->userdata('id'),'Transfer','Transfer Contracts'); 
             if($contractMenu[0]->edit!=0){
               $edit='<a href="newcontract?edit_id='.$r->id.'" class="sb2-2-1-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';            
               $policy='<a href="contractpolicy?id='.$r->id.'" class="sb2-2-1-edit"><i class="fa fa-product-hunt" aria-hidden="true"></i></a>';
               $terms='<a href="contractconditions?id='.$r->id.'" class="sb2-2-1-edit"><i class="fa fa-text-width" aria-hidden="true"></i></a>';
             } else {
              $edit = '';
              $policy = '';
              $terms = '';
             }
             if($contractMenu[0]->delete!=0) {
                $delete='<a href="#" onclick="deletecontractfun('.$r->id.');" data-toggle="modal" data-target="#myModal" class="sb2-2-1-edit delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
             } else {
                $delete = '';
             }
              if ($r->status==0) {
                if($contractMenu[0]->edit!=0){
                    $switch = '<div class="switch">
                           <label>
                               <input type="checkbox"   id="contractStatus'.$r->id.'"  onchange="contractStatus('."'$r->id'".');" >
                               <span class="lever"></span>
                             </label>
                         </div>';
                } else {
                  $switch = 'Disabled';
                }
               } else {
                if($contractMenu[0]->edit!=0){
                    $switch = '<div class="switch">
                           <label>
                               <input type="checkbox"  checked="checked" id="contractStatus'.$r->id.'"  onchange="contractStatus('."'$r->id'".');" >
                               <span class="lever"></span>
                             </label>
                         </div>';
                } else {
                  $switch = 'Enabled';
                }
               }      
               $vehicles = $this->Transfer_Model->vehiclesSelected($r->id);
              $data[] = array(
               $key+1,
               $r->contract_code,
               $r->ContractName,
               $vehicles,
               date("d/m/Y", strtotime($r->valid_from)),
               date("d/m/Y", strtotime($r->valid_to)),
               $r->Passenger_cost,
               $r->Passenger_selling,
               $switch,
               $policy.$terms,
               $edit.$delete
             );
      
          }
         $output = array(
            "draw" => $draw,
            "recordsTotal" => $contract_details->num_rows(),
            "recordsFiltered" => $contract_details->num_rows(),
            "data" => $data
         );
         echo json_encode($output);
         exit();
     }
     public function contractStatus() {
          $this->Transfer_Model->contractStatus($_REQUEST['id'],$_REQUEST['status']);
          $description = 'Transfer contract status updated [ID: '.$_REQUEST['id'].']';
          AdminlogActivity($description);
          echo json_encode(true);
     }
     public function delete_contract() {
          if ($this->session->userdata('name')=="") {
               redirect("../backend/logout");
          }
          $this->Transfer_Model->delete_contract($_REQUEST['delete_id']);
          $Return['error'] = "Deleted Successfully";
          $Return['color'] = 'green';
          $Return['status'] = '1';
          $description = 'Transfer contract details deleted [ID: '.$_REQUEST['delete_id'].']';
          AdminlogActivity($description);
          echo json_encode($Return);
     }
     public function contractpolicy() {
          if ($this->session->userdata('name')=="") {
               redirect("../backend/");
          } 
          $data['contract_id'] = $_REQUEST['id']; 
          $this->load->view('backend/transfer/policy',$data);    
     }
     public function policy_details_list($id) {
          if ($this->session->userdata('name')=="") {
           redirect("../backend/logout");
          }
          $data = array();
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));
          $policy_details = $this->Transfer_Model->policy_details_select($id);
          foreach($policy_details->result() as $key => $r) {
             $edit='<a href="newpolicy/'.$r->contract_id.'?edit_id='.$r->id.'" class="sb2-2-1-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
             $delete='<a href="#" onclick="deletepolicyfun('.$r->id.');" data-toggle="modal" data-target="#myModal" class="sb2-2-1-edit delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';

             $data[] = array(
               $key+1,
               date('d/m/Y',strtotime($r->from_date)),
               date('d/m/Y',strtotime($r->to_date)),
               $r->from_day,
               $r->to_day,
               $r->description,
               $r->cancel_percent,
               $edit.$delete
             );
           
          }
         $output = array(
            "draw" => $draw,
            "recordsTotal" => $policy_details->num_rows(),
            "recordsFiltered" => $policy_details->num_rows(),
            "data" => $data
         );
         echo json_encode($output);
         exit();   
     }
     public function newpolicy($id) {
          if ($this->session->userdata('name')=="") {
               redirect("../backend/");
          }
          $data['contract_id']=$id;
          if (isset($_REQUEST['edit_id']) && $_REQUEST['edit_id'] !="") {
               $data['edit'] = $this->Transfer_Model->policy_details($_REQUEST['edit_id']);
          } else {
               $data['edit'] =array();
          }
          $this->load->view("backend/transfer/newpolicy",$data);      
     }
     public function policy_validation() {
          if ($this->session->userdata('name')=="") {
               redirect("../backend/logout");
          } 
          if ($_REQUEST['from_day']=="") {
               $Return['error'] = 'Day from field is required!';
               $Return['color'] = 'orange';
          }
          else if ($_REQUEST['to_day']=="") {
               $Return['error'] = 'Day to field is required!';
               $Return['color'] = 'orange';
          }
          else if ($_REQUEST['description']=="") {
               $Return['error'] = 'Description field is required!';
               $Return['color'] = 'orange';
          }
          else if ($_REQUEST['cancel_percent']=="") {
               $Return['error'] = 'Cancellation Percentage field is required!';
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
     public function addpolicy() {
          if ($this->session->userdata('name')=="") {
               redirect("../backend/logout");
          } 
          $data=array('from_date' => $_REQUEST['from_date'],
                'to_date' => $_REQUEST['to_date'],
                'from_day' => $_REQUEST['from_day'],
                'to_day' => $_REQUEST['to_day'],
                'description' => $_REQUEST['description'],
                'cancel_percent' => $_REQUEST['cancel_percent'],
                'contract_id' => $_REQUEST['contract_id'],
          );
         $cid=$_REQUEST['contract_id'];
          if ($_REQUEST['edit_id']!="") {
               $result = $this->Transfer_Model->update_policy($data,$_REQUEST['edit_id']);
               $description = 'Transfer contract policy edited [ID: '.$_REQUEST['edit_id'].']';
          } else   {
               $result = $this->Transfer_Model->add_policy($data);
               $description = 'New transfer contract policy added [ID: '.$result.']';
          }
          AdminlogActivity($description);
          redirect(base_url().'backend/transfer/contractpolicy?id='.$cid);
     }
     public function delete_policy() {
          if ($this->session->userdata('name')=="") {
               redirect("../backend/logout");
          }
          $this->Transfer_Model->delete_policy($_REQUEST['delete_id']);
          $Return['error'] = "Deleted Successfully";
          $Return['color'] = 'green';
          $Return['status'] = '1';
          $description = 'Transfer contract policy deleted [ID: '.$_REQUEST['delete_id'].']';
          AdminlogActivity($description);
          echo json_encode($Return);
     }
     public function contractconditions() {
          if ($this->session->userdata('name')=="") {
               redirect("../backend/");
          } 
          $data['contract_id'] = $_REQUEST['id']; 
          $this->load->view('backend/transfer/conditions',$data);    
     }
     public function condition_details_list($id) {
          if ($this->session->userdata('name')=="") {
               redirect("../backend/logout");
          }
         $data = array();
         $draw = intval($this->input->get("draw"));
         $start = intval($this->input->get("start"));
         $length = intval($this->input->get("length"));
         $condition_details = $this->Transfer_Model->condition_details_select($id);
         foreach($condition_details->result() as $key => $r) {
             $edit='<a href="newcondition/'.$r->contract_id.'?edit_id='.$r->id.'" class="sb2-2-1-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
             $delete='<a href="#" onclick="deleteconditionfun('.$r->id.');" data-toggle="modal" data-target="#myModal" class="sb2-2-1-edit delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';

             $data[] = array(
               $key+1,
               $r->conditions,
               $edit.$delete
             );
           
        }
         $output = array(
            "draw" => $draw,
            "recordsTotal" => $condition_details->num_rows(),
            "recordsFiltered" => $condition_details->num_rows(),
            "data" => $data
         );
         echo json_encode($output);
         exit();   
     }
     public function newcondition($id) {
          if ($this->session->userdata('name')=="") {
               redirect("../backend/");
          }
          $data['contract_id']=$id;
          if (isset($_REQUEST['edit_id']) && $_REQUEST['edit_id'] !="") {
               $data['edit'] = $this->Transfer_Model->condition_details($_REQUEST['edit_id']);
          } else {
               $data['edit'] =array();
          }
          $this->load->view("backend/transfer/newcondition",$data);      
     }
     public function condition_validation() {
          if ($this->session->userdata('name')=="") {
               redirect("../backend/logout");
          } 
          if ($_REQUEST['conditions']=="") {
               $Return['error'] = 'Terms and Conditions field is required!';
               $Return['color'] = 'orange';
          } else {
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
     public function addcondition() {
          if ($this->session->userdata('name')=="") {
               redirect("../backend/logout");
          } 
          $data=array('conditions' => $_REQUEST['conditions'],
                     'contract_id' => $_REQUEST['contract_id'],
                   );
          $cid=$_REQUEST['contract_id'];
          if ($_REQUEST['edit_id']!="") {
               $result = $this->Transfer_Model->update_condition($data,$_REQUEST['edit_id']);
               $description = 'Transfer contract condition updated [ID: '.$_REQUEST['edit_id'].']';
          } else {
               $result = $this->Transfer_Model->add_condition($data);
               $description = 'New transfer contract condition added [ID: '.$result.']';
          }
          AdminlogActivity($description);
          redirect(base_url().'backend/transfer/contractconditions?id='.$cid);
     }
     public function delete_condition() {
          if ($this->session->userdata('name')=="") {
               redirect("../backend/logout");
          }
          $this->Transfer_Model->delete_condition($_REQUEST['delete_id']);
          $Return['error'] = "Deleted Successfully";
          $Return['color'] = 'green';
          $Return['status'] = '1';
          $description = 'Transfer contract condition deleted [ID: '.$_REQUEST['delete_id'].']';
          AdminlogActivity($description);
          echo json_encode($Return);
     }
    public function AirportSelect() {
      $data = $this->Transfer_Model->AirportSelect($_REQUEST['Concode']);
      echo json_encode($data);
    }
    public function delete_vehicle() {
          if ($this->session->userdata('name')=="") {
               redirect("../backend/logout");
          }
          $this->Transfer_Model->delete_vehicle($_REQUEST['delete_id']);
          $Return['error'] = "Deleted Successfully";
          $Return['color'] = 'green';
          $Return['status'] = '1';
          $description = 'Transfer vehicle details deleted [ID: '.$_REQUEST['delete_id'].']';
          AdminlogActivity($description);
          echo json_encode($Return);
     }
}
?>
