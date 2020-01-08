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



