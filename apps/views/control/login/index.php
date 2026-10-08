<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="zh-Hant">
    <head>
        <?php $this->load->view('control/public/header');?>
    </head>
    <body class="account separate-inputs" data-page="login">
        <!-- BEGIN LOGIN BOX -->
        <div class="container" id="login-block">
            <div class="row">
                <div class="col-sm-6 col-md-4 col-md-offset-4">
                    <div class="account-wall">
                        <i class="user-img icons-faces-users-03"></i>
                        <form action="/control/login/login_post.html" class="form-signin" role="form" method="post">
                            <div class="append-icon">
                                <input type="text" name="zh_tech_login" id="name" class="form-control form-white username" placeholder="Username" autocomplete="off" required>
                                <i class="icon-user"></i>
                            </div>
                            <div class="append-icon m-b-20">
                                <input type="password" name="zh_tech_passwd" class="form-control form-white password" placeholder="Password" autocomplete="off" required>
                                <i class="icon-lock"></i>
                            </div>
                            <div class="append-icon">
                                <input type="text" name="captcha_code" id="name" class="form-control form-white username" placeholder="Captcha" autocomplete="off" required>
                                <i class="icon-star"></i>
                            </div>
                            <div class="append-icon m-b-20">
								<input type="hidden" name="captcha_file" id="captcha_file" />
                                <a href="#" id="changeCaptchaBtn"></a>
                            </div>
                            <button type="submit" id="" class="btn btn-lg btn-danger btn-block ladda-button" data-style="expand-left">Sign In</button>
                        </form>
                    </div>
                </div>
            </div>
            <p class="account-copyright">
                <span>Copyright © <?php echo config_item('copyright_year');?> </span><span><?php echo config_item('copyright_com');?></span>
            </p>
 
        </div>
		<script src="/assets/global/plugins/jquery/jquery-1.11.1.min.js"></script>
		<script src="/assets/global/plugins/jquery/jquery-migrate-1.2.1.min.js"></script>
		<script src="/assets/global/plugins/gsap/main-gsap.min.js"></script>
		<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="/assets/global/plugins/backstretch/backstretch.min.js"></script>
		<script src="/assets/global/plugins/bootstrap-loading/lada.min.js"></script>
		<script src="/assets/global/js/pages/login-v1.js"></script>
    </body>
</html>
<script>
	$('#changeCaptchaBtn').click(function(){
		changeCaptcha();
		return false;
	});
	
	$(document).ready(function(){
		changeCaptcha();
		return false;
	});
	
	function changeCaptcha()
	{
		$.ajax(
			{
			'method':'post',
			'url':'/api/captcha.html',
			'datatype':'json'
			}
			).done(function(data){
				data = jQuery.parseJSON(data);
				console.log(data);
				$('#changeCaptchaBtn').html(data.captcha);
				$('#captcha_file').val(data.captcha_code);
			});
		
		return false;
	}
</script>