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
						<h3><i class="icon-layers"></i> 財管項目列表</h3>
					</div>
					<div class="panel-content">
					<button type="button" class="btn btn-dark btn-square" data-toggle="modal" data-target="#add_panel">新增項目</button>
					  <table class="table table-hover table-dynamic">
						<thead>
						  <tr>
							<th width="">ID</th>
							<th width="">類型</th>
							<th width="">名稱</th>			
							<th width="">操作</th>			
						  </tr>
						</thead>
						<tbody>
						<?php if (isset($data_list) && count($data_list) > 0){?>
						<?php foreach($data_list as $key => $row){?>
							<tr>
								<td><?php echo $row->id;?></td>
								<td><?php echo $cost_item_type_list[$row->type];?></td>
								<td><?php echo $row->title;?></td>

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
	<?php $this->load->view('control/modal/add_cost_item');?>
	<?php $this->load->view('control/modal/edit_cost_item');?>

	<!-- BEGIN PAGE SCRIPT -->
	<script src="/assets/global/plugins/datatables/jquery.dataTables.min.js"></script> <!-- Tables Filtering, Sorting & Editing -->
    <script src="/assets/global/js/pages/table_dynamic.js"></script>
	<!-- END PAGE SCRIPT -->
		
	<script src="/assets/admin/layout1/js/layout.js"></script>
	<script>
	
	$(function(){
		var table = $('.table-dynamic').DataTable();
		table.order([ 1 , "asc"]).page.len(100).draw();
	});
	
	$('.delete').click(function(){
		var id = $(this).data('id');
		var title = $(this).data('title');
		
		if (confirm("確定要刪除" + title + "嗎？"))
		{
			$.ajax({
				url:'/control/cost/del_item.html',
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
