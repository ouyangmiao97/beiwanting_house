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
						<h3><i class="icon-layers"></i>商品篩選子項目</h3>
					</div>
					<div class="panel-content">
					<button type="button" class="btn btn-dark btn-square" data-toggle="modal" data-target="#add_panel">新增</button>
					  <table class="table table-hover">
						<thead>
						  <tr>
							<th width="">ID</th>
							<th width="">主項目</th>
							<th width="">名稱</th>
							<th width="">排序</th>
							<th width="">操作</th>
							
						  </tr>
						</thead>
						<tbody>
						<?php if (isset($data_list) && count($data_list) > 0){?>
						<?php foreach($data_list as $key => $row){?>
							<tr id="tr<?php echo $key;?>" data-rows="<?php echo $key;?>">
								<td><?php echo $row->id;?></td>
								<td><?php echo isset($rule_main_list[$row->main_id])?$rule_main_list[$row->main_id]->title:'';?></td>
								<td><?php echo $row->title;?></td>
								<td>
									<a href="#" class="move_top btn btn-sm btn-default">上移</a>
									<a href="#" class="move_bottom btn btn-sm btn-default">下移</a>
								</td>
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
	<?php $this->load->view('control/modal/add_rule_sub');?>
	<?php $this->load->view('control/modal/edit_rule_sub');?>

	<!-- BEGIN PAGE SCRIPT -->
	<script src="/assets/global/plugins/datatables/jquery.dataTables.min.js"></script> <!-- Tables Filtering, Sorting & Editing -->
    <script src="/assets/global/js/pages/table_dynamic.js"></script>
	<!-- END PAGE SCRIPT -->
		
	<script src="/assets/admin/layout1/js/layout.js"></script>
	<script>
	
	$('.delete').click(function(){
		var id = $(this).data('id');
		var title = $(this).data('title');
		
		if (confirm("確定要刪除" + title + "嗎？"))
		{
			$.ajax({
				url:'/control/rule_sub/del.html',
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
	<script>
		var top_max = 0;
		var bottom_max = <?php echo count($data_list);?>;
		$('.move_top').live('click' , function(){
			var rows = $(this).parent().parent().data('rows');
			var next = rows - 1;
			
			var id1 = $('#tr' + rows + ' td').first().html();
			var id2 = $('#tr' + next + ' td').first().html();
			
			$.post('/control/rule_sub/change_sort_key' , {'id1':id1,'id2':id2} , function(response){
				if (response.status == 'F')
				{
					alert(response.msg);
					return false;
				}
			},'json');
			
			if (rows == top_max)
			{
				return false;
			}
			
			var tr1 = $('#tr' + rows).html();
			var tr2 = $('#tr' + next).html();
			
			$('#tr' + rows).html(tr2);
			$('#tr' + next).html(tr1);
			
			return false;
		});
		
		$('.move_bottom').live('click',function(){
			var rows = $(this).parent().parent().data('rows');
			var next = rows + 1;
			
			var id1 = $('#tr' + rows + ' td').first().html();
			var id2 = $('#tr' + next + ' td').first().html();
			
			$.post('/control/rule_sub/change_sort_key' , {'id1':id1,'id2':id2} , function(response){
				if (response.status == 'F')
				{
					alert(response.msg);
					return false;
				}
			},'json');
			
			if (rows == bottom_max)
			{
				return false;
			}
			
			var tr1 = $('#tr' + rows).html();
			var tr2 = $('#tr' + next).html();
			
			$('#tr' + rows).html(tr2);
			$('#tr' + next).html(tr1);
			
			return false;
		});
	</script>
    </body>
</html>
