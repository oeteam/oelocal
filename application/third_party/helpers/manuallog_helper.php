 <?php 
defined('BASEPATH') OR exit('No direct script access allowed');

$ci =& get_instance();
$cookie =  $ci->input->cookie('keyhash');
if ($cookie==hashvalue()) {
	return true;
} else {
	show_404();
    exit();
}

$sess = array();
$sess_id=$ci->session->userdata('id');
$sess_email=$ci->session->userdata('id');
$last_action = $ci->session->userdata('last_action');
// if (date('YmdHis') > $last_action+40000) {
// 	redirect(base_url()."backend");
// }
if ($sess_id=="" && $sess_email=="") {
	redirect(base_url()."backend");
} else {
	$dd =  $ci->db->query('select id from hotel_tbl_user where id = '.$sess_id.' and Del_Flag=1')->result();
	if (count($dd)==0) {
		redirect(base_url()."backend");
	}
}

