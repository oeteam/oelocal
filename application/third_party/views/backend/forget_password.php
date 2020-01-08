    <script type="text/javascript" src="<?php echo static_url(); ?>assets/js/jquery.min.js"></script>
  <script src="<?php echo static_url(); ?>assets/js/forget_password.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo static_url(); ?>assets/forget_password/forgetcss/style.css" media="screen" />
      <script type="text/javascript">
        var base_url = "<?php  echo base_url();?>"; 
    </script> 
<body>
  <div class="login">
  <h1>Forget Password</h1>
  <h3>If you have forgotten your password you can reset it here.</h3>
    <form method="post" id="admin_forget_password" name="admin_forget_password">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
      <input type="text" name="email" id="email" placeholder="Enter your registerd Email address" required="required" />
      <input type="hidden" id="existing_mail_check" value="2">
      <button type="button" id="admin_forget_password_button"  class="btn btn-primary btn-block btn-large" value="forget_password">Get New Password</button>
    </form>
    <span style="color: red;" class="error"></span>
    <span style="color: green;" class="success"></span>
</div>
