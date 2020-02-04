<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Package extends MY_Controller {

  
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
    // $agentmenu = menuPermissionAvailability($this->session->userdata('id'),'Agents',''); 
    // if (count($agentmenu)!=0 && $agentmenu[0]->view==1) {
      $this->load->view('backend/Package/index'); 
    // } else {
    //   redirect(base_url().'backend/dashboard');
    // }
  }
  public function supplier() {
      $this->load->view('backend/Package/supplier'); 

  }
  public function package_list() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }
    $data = array();
    $Package = $this->db->query('select a.*, CONCAT(ps.FirstName," ",ps.LastName) as supplierName ,c.name as countryName,
     s.name as StateName from hotel_tbl_package a 
      inner join hotel_tbl_packagesupplier ps ON ps.id = a.supplier
      inner join countries c ON c.id = a.country inner join states s ON s.id = a.State where a.delflg = '.$_REQUEST['filter'].'')->result();

    // Datatables Variables
    $draw = intval($this->input->get("draw"));
    $start = intval($this->input->get("start"));
    $length = intval($this->input->get("length"));
    foreach($Package as $key => $r) {

        if (($r->MinPax!=0) && ($r->MaxPax!=0)) {
          $pax = "Min(".$r->MinPax.") - Max(".$r->MaxPax.")";
        } else if(($r->MinPax!=0) && ($r->MaxPax==0)) {
          $pax = "Min(".$r->MinPax.")";
        } else if(($r->MaxPax!=0) && ($r->MinPax==0)) {
          $pax = "Max(".$r->MaxPax.")";
        } else {
          $pax = 0;
        }
        $edit='<a href="#" onclick="editpackageModal('.$r->id.')" data-toggle="modal" data-target="#packageModal" class="sb2-2-1-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
        $delete='<a href="#" onclick="packagedeletefun('.$r->id.');" data-toggle="modal" data-target="#myModal" class="sb2-2-1-edit  delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
        $data[] = array(
          $key+1,
          $r->title,
          $r->supplierName,
          date('d/m/Y',strtotime($r->from_date)),
          date('d/m/Y',strtotime($r->to_date)),
          $r->countryName.", ".$r->StateName,
          $pax,
          $r->adultCost,
          $r->childCost,
          $r->adultSelling,
          $r->ChildSelling,
          $edit.$delete,

        );
      //}
    }
    $output = array(
       "draw" => $draw,
       "recordsTotal" => count($Package),
       "recordsFiltered" => count($Package),
       "data" => $data
    );
    echo json_encode($output);
    exit();

  }
  public function packageModal() {
    $data['contry']= $this->Hotels_Model->SelectCountry();
    $data['supplier']= $this->db->query('select CONCAT(FirstName," ",LastName) as Name,id from hotel_tbl_packagesupplier')->result();
    $this->load->view('backend/Package/packageModal',$data);
  }
  public function packagesupplier_list() {
    if ($this->session->userdata('name')=="") {
      redirect("../backend/");
    }

    $Package = $this->db->query('select a.*,CONCAT(a.FirstName," ",a.LastName) as Name,c.name as countryName,
     s.name as StateName from hotel_tbl_packagesupplier a inner join countries c ON c.id = a.country inner join states s ON s.id = a.state  where a.delflg = '.$_REQUEST['filter'].' 
      ')->result();

    $data = array();
    // Datatables Variables
    $draw = intval($this->input->get("draw"));
    $start = intval($this->input->get("start"));
    $length = intval($this->input->get("length"));
    foreach($Package as $key => $r) {
        $edit='<a href="#" onclick="editsupplierModal('.$r->id.')" data-toggle="modal" data-target="#supplierModal" class="sb2-2-1-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
        $delete='<a href="#" onclick="supplierdeletefun('.$r->id.');" data-toggle="modal" data-target="#myModal" class="sb2-2-1-edit  delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
        if ($r->delflg==0) {
          $permission = '<div class="switch">
                <label>
                    <input type="checkbox"   onchange="supplierpermissionfun('.$r->id.',1);" >
                    <span class="lever"></span>
                  </label>
              </div>';
        } else {
          $permission = '<div class="switch">
                <label>
                    <input type="checkbox" checked   onchange="supplierpermissionfun('.$r->id.',0);"  >
                    <span class="lever"></span>
                  </label>
              </div>';
        }

        $data[] = array(
          $key+1,
          $r->Name,
          $r->Mobile,
          $r->email,
          $r->countryName,
          $r->StateName.','.$r->city,
          $permission,
          $edit,

        );
      //}
    }
    $output = array(
       "draw" => $draw,
       "recordsTotal" => count($Package),
       "recordsFiltered" => count($Package),
       "data" => $data
    );
    echo json_encode($output);
    exit();

  }
  public function packagesupplierModal() {
    $data['contry']= $this->Hotels_Model->SelectCountry();
    if (isset($_REQUEST['id'])) {
      $data['view'] =  $this->db->query('select * from hotel_tbl_packagesupplier where id = '.$_REQUEST['id'].'')->result();
    }
    $this->load->view('backend/Package/supplierModal',$data);
  }
  public function supliersubmit() {

    if ($_REQUEST['id']=="") {
      $data = array(
          'FirstName' => $_REQUEST['FirstName'],
          'LastName' => $_REQUEST['LastName'],
          'email' => $_REQUEST['email'],
          'Mobile' => $_REQUEST['Mobile'],
          'sex' => $_REQUEST['sex'],
          'DOB' => $_REQUEST['DOB'],
          'country' => $_REQUEST['ConSelect'],
          'state' => $_REQUEST['stateSelect'],
          'city' => $_REQUEST['city'],
          'Address' => $_REQUEST['Address'],
          'Created_Date' => date('Y-m-d H:i:s'),
          'Created_By'   =>  $this->session->userdata('id'),
      );
      $this->db->insert('hotel_tbl_packagesupplier',$data);
    } else {
      $data = array(
          'FirstName' => $_REQUEST['FirstName'],
          'LastName' => $_REQUEST['LastName'],
          'email' => $_REQUEST['email'],
          'Mobile' => $_REQUEST['Mobile'],
          'sex' => $_REQUEST['sex'],
          'DOB' => $_REQUEST['DOB'],
          'country' => $_REQUEST['ConSelect'],
          'state' => $_REQUEST['stateSelect'],
          'city' => $_REQUEST['city'],
          'Address' => $_REQUEST['Address'],
          'Updated_Date' => date('Y-m-d H:i:s'),
          'Updated_By'   =>  $this->session->userdata('id'),
      );
      $this->db->where('id',$_REQUEST['id']);
      $this->db->update('hotel_tbl_packagesupplier',$data);
    }
    echo json_encode(true);
  }
  public function supplierpermission() {
    $data = array('delflg' => $_REQUEST['flag']);
    $this->db->where('id',$_REQUEST['id']);
    $this->db->update('hotel_tbl_packagesupplier',$data);
    echo json_encode(true);
  }
  public function PackageSubmit() {
    foreach ($_REQUEST['title'] as $key => $value) {
        $data = array(
            'title' => $value,
            'supplier' => $_REQUEST['supplier'][$key],
            'from_date' => $_REQUEST['from_date'][$key], 
            'to_date' => $_REQUEST['to_date'][$key], 
            'type' => $_REQUEST['type'][$key], 
            'MinPax' => $_REQUEST['MinPax'][$key], 
            'MaxPax' => $_REQUEST['MaxPax'][$key], 
            'adultCost' => $_REQUEST['adultCost'][$key], 
            'childCost' => $_REQUEST['childCost'][$key], 
            'adultSelling' => $_REQUEST['adultSelling'][$key], 
            'ChildSelling' => $_REQUEST['ChildSelling'][$key], 
            'country' => $_REQUEST['ConSelect'],
            'State' => $_REQUEST['stateSelect'],
            'Created_Date' => Date('Y-m-d H:i:s'),
            'Created_By' => $this->session->userdata('id'),
            'overview' => $_REQUEST['overview'][$key],
            'address' => $_REQUEST['address'][$key],
            'duration' => $_REQUEST['duration'][$key],
            'inclusion' => $_REQUEST['inclusion'][$key],
            'exclusion' => $_REQUEST['exclusion'][$key],
            'terms' => $_REQUEST['terms'][$key],
            'hours' => $_REQUEST['hours'][$key],
            'cancelPolicy' => $_REQUEST['cancelPolicy'][$key],
            'childPolicy' => $_REQUEST['childPolicy'][$key],
            'images' => ''
        );
      $this->db->insert('hotel_tbl_package',$data);
    }
    echo json_encode(true);
  }
  public function packagedelete() {
    $data = array(
            'delflg' => 0,
            'Updated_Date' => Date('Y-m-d H:i:s'),
            'Updated_By' => $this->session->userdata('id'),
        );
    $this->db->where('id',$_REQUEST['delete_id']); 
    $this->db->update('hotel_tbl_package',$data);

    echo json_encode(true);
  }
  public function newpackage() {
    $data['contry']= $this->Hotels_Model->SelectCountry();
    $data['supplier']= $this->db->query('select CONCAT(FirstName," ",LastName) as Name,id from hotel_tbl_packagesupplier')->result();
    $this->load->view("backend/package/newpackage",$data);  
  }
  public function detailsModal($trid) {
    $data['trid'] = $trid;
    $this->load->view('backend/Package/detailsModal',$data);
  }
}
?>
