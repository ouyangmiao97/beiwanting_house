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
						<h3><i class="icon-layers"></i><?php echo $page_title['title'];?></h3>
					</div>
					<div class="panel-content">
					  <table class="table table-hover table-dynamic">
						<thead>
						  <tr>
							<th width="5%">#</th>
							<th width="5%">ID</th>
							<th width="10%">名稱</th>
							<th width="15%">EMAIL</th>
							<th width="30%">問題內容</th>
							<th width="15%">建立時間</th>
							<th widht="10%">是否已處理</th>
							<th width="10%">操作</th>
							
						  </tr>
						</thead>
						<tbody>
						<?php if (isset($data_list) && count($data_list) > 0){?>
						<?php foreach($data_list as $key => $row){?>
							<tr>
								<td><input name="mchecked[]" type="checkbox" class="chkbox form-control" value="<?php echo $row->id;?>" /></td>
								<td><?php echo $row->id;?></td>
								<td><?php echo $row->user_name;?></td>
								<td><?php echo $row->user_mail;?></td>
								<td><?php echo nl2br($row->memo);?></td>
								<td><?php echo $row->create_at;?></td>
								<td>
								<label class="switch switch-green">
								<input type="checkbox" class="switch-input changeActiveBtn" <?php echo $row->active==1?'checked':'';?> data-id="<?php echo $row->id;?>">
								<span class="switch-label" data-on="Yes" data-off="No"></span>
								<span class="switch-handle"></span>
								</label>
								</td>
								<td><div class="text-right">
								<?php /*<a class="view_contact btn btn-sm btn-default" href="#" data-toggle="modal" data-target="#view_panel"><i class="icon-note"></i></a>*/?>
								<a class="edit btn btn-sm btn-default" href="#" data-toggle="modal" data-target="#reply_panel"><i class="icon-note"></i></a>
								<a class="delete btn btn-sm btn-danger" href="#" data-id="<?php echo $row->id;?>" data-title="<?php echo $row->user_name;?>"><i class="icons-office-52"></i></a>
								</div></td>
							</tr>
						<?php }?>
						<?php }?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="8">
									<a href="#" id="all_sel">全選</a>  |  <a href="#" id="del_list">刪除</a>
								</td>
							</tr>
						</tfoot>
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
	<?php $this->load->view('control/modal/view_contact');?>
	<?php $this->load->view('control/modal/reply_contact');?>

	<!-- BEGIN PAGE SCRIPT -->
	<script src="/assets/global/plugins/datatables/jquery.dataTables.min.js"></script> <!-- Tables Filtering, Sorting & Editing -->
    <script src="/assets/global/js/pages/table_dynamic.js"></script>
	<!-- END PAGE SCRIPT -->
		
	<script src="/assets/admin/layout1/js/layout.js"></script>
	<script>
	$(function(){
		var table = $('.table-dynamic').DataTable();
		table.order([ 5 , "desc"]).page.len(100).draw();
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
					url:'/control/contact/change_contact_active.html',
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
				url:'/control/contact/del_contact.html',
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
	$('#del_list').click(function(){
		var list = $('input:checkbox:checked[name="mchecked[]"]').map(function() { return $(this).val(); }).get();
		
		if (list.length > 0)
		{
			if (confirm('確定要刪除所選取的資料嗎？'))
			{
				$.post('/control/contact/del_list.html' , {'list':list} , function(response){
					if (response.status == 'T')
					{
						location.reload();
					}
					else
					{
						alert(response.msg);
					}
				} , 'json');
			}
		}
		else
		{
			alert('您尚未選取任何資料');
		}
		
		return false;
	});
	$('#all_sel').click(function(){
		var list = $('input:checkbox:checked[name="mchecked[]"]').map(function() { return $(this).val(); }).get();
		
		console.log(list);
		if (list.length > 0)
		{
			$('.chkbox').iCheck('uncheck');
		}
		else
		{
			$('.chkbox').iCheck('check');
		}

		return false;
	});
	</script>
    </body>
</html>
