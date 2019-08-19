
<br/>
<?php if(!empty($fb_url)){ ?>
    <h2>Connect with Facebook</h2><br/>
    <a href="<?php echo $fb_url; ?>"><img src="<?php echo base_url('assets/images/fb-login-btn.png'); ?>"></a>
<?php }
if(!empty($ga_url)){ ?>
    <h2>Connect with google</h2><br/>
    <a href="<?php echo $ga_url; ?>"><img src="<?php echo base_url('assets/images/google-sign-in-btn.png'); ?>" /></a>
<?php } ?>
