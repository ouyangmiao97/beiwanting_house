<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="zh-Hant">
    <head>
        <?php $this->load->view('control/public/header');?>
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
						<h3><i class="icon-layers"></i> 首頁商品品牌區管理 / 首頁商品品牌區列表</h3>
					</div>
					<div class="panel-content">
					<button type="button" class="btn btn-dark btn-square" data-toggle="modal" data-target="#add_panel">新增</button>
					  <table class="table table-hover table-dynamic">
						<thead>
						  <tr>
							<th width="10%">ID</th>
							<th width="10%">圖片</th>
							<th width="20%">標題</th>
							<th width="20%">開啟狀態</th>
							<th width="20%">網址</th>
							<th width="20%">操作</th>
							
						  </tr>
						</thead>
						<tbody>
						<?php if (isset($data_list) && count($data_list) > 0){?>
						<?php foreach($data_list as $key => $row){?>
							<tr>
								<td><?php echo $row->id;?></td>
								<td><img src="<?php echo img_show($row->img_file->file_name);?>" width="100%" height=""></td>
								<td><?php echo $row->title;?></td>
								<td>
								<label class="switch switch-green">
								<input type="checkbox" class="switch-input changeActiveBtn" <?php echo $row->active==1?'checked':'';?> data-id="<?php echo $row->id;?>">
								<span class="switch-label" data-on="Yes" data-off="No"></span>
								<span class="switch-handle"></span>
								</label>
								</td>
								<td><?php echo $row->href;?></td>
								<td><div class="text-right">
								<a class="edit btn btn-sm btn-default" href="#" data-toggle="modal" data-target="#edit_panel"><i class="icon-note"></i></a>
								<a class="delete btn btn-sm btn-danger" href="#" data-id="<?php echo $row->id;?>" data-title="<?php echo $row->title;?>"><i class="icons-office-52"></i></a>
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
	<?php $this->load->view('control/modal/add_brand');?>
	<?php $this->load->view('control/modal/edit_brand');?>

	<!-- BEGIN PAGE SCRIPT -->
	<script src="/assets/global/plugins/datatables/jquery.dataTables.min.js"></script> <!-- Tables Filtering, Sorting & Editing -->
    <script src="/assets/global/js/pages/table_dynamic.js"></script>
	<!-- END PAGE SCRIPT -->
		
	<script src="/assets/admin/layout1/js/layout.js"></script>
	<script>
	$('.changeActiveBtn').click(function(){
		// console.log($(this).attr('checked'));
		var checkeds = 0;//預設未處理
		var id = $(this).data('id');
		
		if ($(this).attr('checked') == 'checked')
		{
			checkeds = 1;
		}
		else
		{
			checkeds = 0;
		}
				$.ajax({
					url:'/control/brand/change_active.html',
					type:'post',
					dataType:'json',
					data:{
						'id':id,
						'checkeds':checkeds,
					},
					success:function(data){
						// console.log(data);
						if (data.status='T')
						{
							
						}
						else if(data.status='F')
						{
							alert(data.msg);
							// location.reload();
						}
					},
					error:function(e)
					{
						// console.log(e);
						alert('unknow error!');
						// location.reload();
					}
				});
	});
	
	$('.delete').click(function(){
		var id = $(this).data('id');
		var title = $(this).data('title');
		
		if (confirm("確定要刪除" + title + "嗎？"))
		{
			$.ajax({
				url:'/control/brand/del.html',
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
	});
	</script>
    </body>
</html>
