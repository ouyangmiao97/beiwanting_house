<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="zh-tw">
    <head>
        <?php $this->load->view('control/public/header');?>
		<link href="/css/admin_image.css" rel="stylesheet">
    </head>
    <body class="fixed-topbar fixed-sidebar theme-sdtl color-default">
     <section>
<?php $this->load->view('control/public/sidebar');?>
      <div class="main-content">

        <!-- BEGIN PAGE CONTENT -->
        <div class="page-content">
		<?php $this->load->view('control/public/topbar');?>
		<?php $this->load->view('control/public/header_bar');?>
		
		<div class="row">
			<div class="col-md-12">
				<div class="panel">
					<div class="panel-header">
						<h3><i class="icon-layers"></i><?php echo $page_title['title'];?></h3>
					</div>
					<div class="panel-content">
					<a class="btn btn-dark btn-square" href="/control/marquee/add.html">新增跑馬燈</a>
					  <table class="table table-hover">
						<thead>
						  <tr>
							<th width="1%"></th>
							<th width="10%">#</th>
							<th width="30%">名稱</th>
							<th width="10%">建立時間</th>
							<th width="20%">操作</th>
							
						  </tr>
						</thead>
						<tbody>
						<?php
						$num=1; 
						if (isset($data_list) && is_array($data_list) && count($data_list) > 0){?>
						<?php foreach($data_list as $key => $row){?>

							<tr id="tr<?php echo $key;?>" data-rows="<?php echo $key;?>">
								<td style="visibility:hidden"><?php echo $row->id;?></td>
								<td><?php echo $num++;?></td>
								<td><?php echo $row->title;?></td>						
								<td><?php echo $row->create_at;?></td>
								<td><div class="text-right">

								<a class="btn btn-sm btn-default" href="/control/marquee/edit/<?php echo $row->id;?>.html">修改</a>
								<a class="delete btn btn-sm btn-danger" href="#" data-id="<?php echo $row->id;?>" data-title="<?php echo $row->title;?>">刪除</a>
								</div></td>
							</tr>
						<?php }?>
						<?php }?>
						</tbody>
					  </table>


					  </div>
				</div>
			</div>
		</div>
		
		<?php $this->load->view('control/public/footer_bar');?>
		
        </div>
        <!-- END PAGE CONTENT -->
      </div>
      <!-- END MAIN CONTENT -->
	  
	  
    </section>
	<?php $this->load->view('control/public/footer');?>
	<script>
	$('.delete').click(function(){
		var title = $(this).data('title');
		var id = $(this).data('id');
		
		if (confirm("確定要刪除" + title + "嗎？"))
		{
			$.ajax({
				url:'/control/marquee/del',
				type:'post',
				dataType:'json',
				data:{
					'id':id
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
		}
		
		return false;
	});
	</script>
    </body>
</html>
