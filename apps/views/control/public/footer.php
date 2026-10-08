<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
    <a href="#" class="scrollup"><i class="fa fa-angle-up"></i></a> 
    <script src="/assets/global/plugins/jquery/jquery-1.11.1.min.js"></script>
    <script src="/assets/global/plugins/jquery/jquery-migrate-1.2.1.min.js"></script>
    <script src="/assets/global/plugins/jquery-ui/jquery-ui-1.11.2.min.js"></script>
    <script src="/assets/global/plugins/gsap/main-gsap.min.js"></script>
    <script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="/assets/global/plugins/bootstrap/js/jasny-bootstrap.min.js"></script>
    <script src="/assets/global/plugins/jquery-cookies/jquery.cookies.min.js"></script> <!-- Jquery Cookies, for theme -->
    <script src="/assets/global/plugins/jquery-block-ui/jquery.blockUI.min.js"></script> <!-- simulate synchronous behavior when using AJAX -->
    <script src="/assets/global/plugins/bootbox/bootbox.min.js"></script> <!-- Modal with Validation -->
    <script src="/assets/global/plugins/mcustom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script> <!-- Custom Scrollbar sidebar -->
    <script src="/assets/global/plugins/bootstrap-dropdown/bootstrap-hover-dropdown.min.js"></script> <!-- Show Dropdown on Mouseover -->
    <script src="/assets/global/plugins/charts-sparkline/sparkline.min.js"></script> <!-- Charts Sparkline -->
    <script src="/assets/global/plugins/retina/retina.min.js"></script> <!-- Retina Display -->
    <script src="/assets/global/plugins/select2/select2.min.js"></script> <!-- Select Inputs -->
    <script src="/assets/global/plugins/icheck/icheck.min.js"></script> <!-- Checkbox & Radio Inputs -->
    <script src="/assets/global/plugins/backstretch/backstretch.min.js"></script> <!-- Background Image -->
    <script src="/assets/global/plugins/bootstrap-progressbar/bootstrap-progressbar.min.js"></script> <!-- Animated Progress Bar -->
    <script src="/assets/global/plugins/charts-chartjs/Chart.min.js"></script>
    <script src="/assets/global/js/builder.js"></script> <!-- Theme Builder -->
    <script src="/assets/global/js/sidebar_hover.js"></script> <!-- Sidebar on Hover -->
    <script src="/assets/global/js/application.js"></script> <!-- Main Application Script -->
    <script src="/assets/global/js/plugins.js"></script> <!-- Main Plugin Initialization Script -->
    <script src="/assets/global/js/widgets/notes.js"></script> <!-- Notes Widget -->
    <script src="/assets/global/js/quickview.js"></script> <!-- Chat Script -->
    <script src="/assets/global/js/pages/search.js"></script> <!-- Search Script -->
	<!-- JQuery UI datepicker Lang -->
	<script src="/js/lang/datepicker-zh-TW.js"></script>
	
	
	<script>
	
	function get_contact_message()
	{
			$.ajax({
				url:'/control/contact/get_contact_message.html',
				type:'post',
				dataType:'json',
				success:function(data){
					$('#contact_message_count').html(data.length);
					$('#contact_message_count_word').html(data.length+'筆聯絡我們');
					
					var msg_html = '';
					
					for(var key in data)
					{
						// console.log(data[key]);
						msg_html += '<li class="clearfix"><span class="pull-left p-r-5"><img src="/assets/global/images/avatars/avatar1.png" alt="avatar"></span><div class="clearfix"><div><strong>'+data[key].user_name+'</strong><small class="pull-right text-muted">'+data[key].create_at+'</small></div><p>'+data[key].memo+'</p></div></li>';
					}
					
					$('#contact_message_list').html(msg_html);
				},
				error:function(e)
				{
					console.log(e);
				}
			});
	}
	
	
	function get_message()
	{
		
		get_contact_message();
		
		setTimeout(get_message , 10000);
	}
	
	get_message();
	
	</script>