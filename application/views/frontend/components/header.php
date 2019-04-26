<?php  
 $this->load->helper('common');
 $data = title();
 ?>

<!DOCTYPE html>
<html>
  <head>
  	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	   <title><?php echo $data[0]->Title ?></title>
       <link rel="shortcut icon" href="<?php echo base_url() ?>assets/images/fav.ico">
        <!-- Bootstrap -->
        <link href="<?php echo base_url(); ?>skin/dist/css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="<?php echo base_url(); ?>skin/assets/css/custom.css" rel="stylesheet" media="screen">
        <link href="<?php echo base_url(); ?>skin/examples/carousel/carousel.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>skin/updates/update1/css/style01.css" rel="stylesheet" media="screen">   
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="assets/js/html5shiv.js"></script>
          <script src="assets/js/respond.min.js"></script>
        <![endif]-->
        <!-- Fonts -->  
        <link href='http://fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:700,400,300,300italic' rel='stylesheet' type='text/css'>   
        <!-- Font-Awesome -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>skin/assets/css/font-awesome.min.css" media="screen" />
        <!--[if lt IE 7]><link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>skin/assets/css/font-awesome-ie7.css" media="screen" /><![endif]-->
        <!-- REVOLUTION BANNER CSS SETTINGS -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>skin/css/fullscreen.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>skin/rs-plugin/css/settings.css" media="screen" />
        <!-- Picker --> 
        <link rel="stylesheet" href="<?php echo base_url(); ?>skin/assets/css/jquery-ui.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>skin/assets/css/daterangepicker.min.css">
        <!-- bin/jquery.slider.min.css -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>skin/plugins/jslider/css/jslider.css" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>skin/plugins/jslider/css/jslider.round.css" type="text/css">    
        <!-- jQuery --> 
        <script src="<?php echo base_url(); ?>skin/js/custom.js"></script>
         <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>skin/js/moment.min.js"></script>
        <script src="<?php echo base_url(); ?>skin/assets/js/jquery.v2.0.3.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>skin/assets/js/jquery.daterangepicker.min.js"></script>
        <script src="<?php echo base_url(); ?>skin/assets/js/sweet-alert.js"></script>
        <script src="<?php echo base_url(); ?>skin/js/common.js"></script>
        <!-- Sweet-Alert Custom Style -->
        <style>
            .swal2-popup .swal2-styled {
                padding: 3px 15px !important;
            }
            .swal2-popup .swal2-title {
                color: #d03328 !important;
            }
            .swal2-popup .swal2-styled:focus {
                box-shadow: none !important;
            }
        </style>
        <!-- end -->
        <script type="text/javascript">
        var base_url = "<?php  echo base_url();?>"; 
    </script> 
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>system/currency/script/ajax.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>system/currency/script/validation.min.js"></script> -->
</head>
<!--Start of Tawk.to Script-->
<?php 
    $useragent=$_SERVER['HTTP_USER_AGENT'];
    if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {  } else {?>
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
Tawk_API.visitor = {
name : '<?php echo $this->session->userdata('agent_name'); ?>',
email : '<?php echo $this->session->userdata('agent_email'); ?>',
hash : '<?php echo hash_hmac("sha256",$this->session->userdata('agent_email'),"46148dd63113048bfce0dc7000660245ee7a822d"); ?>'
};
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5be3cfb370ff5a5a3a712774/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<?php } ?>
<!--End of Tawk.to Script-->