<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="zh-Hant">
    <head>
        <?php $this->load->view('control/public/builder_header');?>
    </head>
    <body class="fixed-topbar fixed-sidebar theme-sdtl color-default">
     <section>
<?php $this->load->view('control/public/sidebar');?>
      <div class="main-content">

        <!-- BEGIN PAGE CONTENT -->

		<?php $this->load->view('control/public/topbar');?>
		<?php $this->load->view('control/public/pagebuilder');?>

        <!-- END PAGE CONTENT -->
      </div>
      <!-- END MAIN CONTENT -->
	  
	  
    </section>
	<?php $this->load->view('control/public/builder_footer');?>
	<script>
	$('#save_html_code').click(function(){
		removeEditor($(this));
		
		var htmlcode = $('#edit_index_panel').html();
		
		console.log(htmlcode);
		
		$.ajax({
			url:'/control/page/edit_page_html_post.html',
			type:'post',
			dataType:'json',
			data:{
				'html':htmlcode,
				'page_id':"<?php echo $page_id;?>"
			},
			success:function(data){
				if (data.status='T')
				{
					alert(data.msg);
					location.reload();
				}
				else if(data.status='F')
				{
					alert(data.msg);
					return false;
				}
			},
			error:function(e)
			{
				console.log(e);
				alert('unknow error!');
				return false;
			}
		});
		return false;
	});
</script>
    </body>
</html>
