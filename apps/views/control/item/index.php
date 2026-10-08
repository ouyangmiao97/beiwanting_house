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
				<div class="panel panel-default">
					<div class="panel-header">
						<h3><i class="icon-user"></i>  <strong>項目管理</strong> </h3>
					</div>
					<div class="panel-content">
					<button type="button" class="btn btn-dark btn-square" data-toggle="modal" data-target="#add_panel">新增項目</button>
					  <table class="table table-hover table-dynamic">
						<thead>
						  <tr>
							<th width="10%">ID</th>
							<th width="15%">項目類型</th>
							<th width="20%">標題</th>
							<th width="10%">開啟狀態</th>
							<th width="10%">色碼</th>
							<th width="20%">圖片</th>
							<th width="15%">操作</th>
						  </tr>
						</thead>
						<tbody>
							<?php if (isset($data_list) && is_array($data_list)){?>
							<?php foreach($data_list as $key => $row){?>
							<tr>
								<td><?php echo $row->id;?></td>
								<td><?php echo isset($type_list[$row->type]) ? $type_list[$row->type] : '';?></td>
								<td><?php echo $row->title;?></td>
								<td>
								<label class="switch switch-green">
								<input type="checkbox" class="switch-input changeActiveBtn" <?php echo $row->active==1?'checked':'';?> data-id="<?php echo $row->id;?>">
								<span class="switch-label" data-on="Yes" data-off="No"></span>
								<span class="switch-handle"></span>
								</label>
								</td>
								<td style="background-color:<?php echo $row->color;?>;"><?php echo $row->color;?></td>
								<td><?php if ($row->img_id > 0 && isset($row->img_file)){?><img src="<?php echo img_show($row->img_file->file_name);?>" width="100%" height=""></img><?php }?></td>
								<td><div class="text-right"><a class="edit btn btn-sm btn-default" href="#" data-toggle="modal" data-target="#edit_panel"><i class="icon-note"></i></a> <a class="delete btn btn-sm btn-danger" href="#" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->title;?>"><i class="icons-office-52"></i></a></div></td>
							</tr>
							<?php }}?>
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
	<?php $this->load->view('control/modal/add_item');?>
	<?php $this->load->view('control/modal/edit_item');?>

	<!-- BEGIN PAGE SCRIPT -->
    <script src="/assets/global/plugins/datatables/jquery.dataTables.min.js"></script> <!-- Tables Filtering, Sorting & Editing -->
    <script src="/assets/global/js/pages/table_dynamic.js"></script>
	<!-- END PAGE SCRIPT -->
		
	<script src="/assets/admin/layout1/js/layout.js"></script>
	<script>
	$(function(){
		var table = $('.table-dynamic').DataTable();
		table.order([ 1 , "desc"] , [ 2 , "desc"]).page.len(100).draw();
	});
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
		
		// console.log($(this).attr('checked'));
		// console.log(id , checkeds);
		
				$.ajax({
					url:'/control/item/change_active.html',
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
		var name = $(this).data('name');
		var id = $(this).data('id');
		
		if (confirm("確定要刪除" + name + "嗎？"))
		{
			$.ajax({
				url:'/control/item/del_item',
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
