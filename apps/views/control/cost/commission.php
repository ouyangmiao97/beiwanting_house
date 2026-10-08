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
						<h3><i class="icon-layers"></i> 委員列表</h3>
					</div>
					<div class="panel-content">
					<button type="button" class="btn btn-dark btn-square" data-toggle="modal" data-target="#add_panel">新增委員</button>
					  <table class="table table-hover table-dynamic" data-order='[[ 3 , "desc"]]'>
						<thead>
						  <tr>
							<th width="">ID</th>
							<th width="">委員名稱</th>
							<th width="">上次繳費</th>
							<th width="">下次繳費</th>
							<th width="">費用</th>
							<th width="">繳費間距(天)</th>
							<th width="">最後修改人</th>
							<th width="">操作</th>			
						  </tr>
						</thead>
						<tbody>
						<?php if (isset($data_list) && count($data_list) > 0){?>
						<?php foreach($data_list as $key => $row){?>
						<?php 
						$class = '';
						if (time() + (86400 * 10) > strtotime($row->next_pay))
						{
							$class = 'danger';	
						}
						else if (time() + (86400 * 30) > strtotime($row->next_pay))
						{
							$class = 'success';
						}
						?>
							<tr class="<?php echo $class;?>">
								<td><?php echo $row->id;?></td>
								<td><?php echo $row->name;?></td>
								<td><?php echo $row->last_pay;?></td>
								<td><?php echo $row->next_pay;?></td>
								<td><?php echo $row->cost;?></td>
								<td><?php echo $row->pay_range;?></td>
								<td><?php echo $row->account_name;?></td>
								<td><div class="text-right">
								<a class="cost btn btn-sm btn-default" href="#" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->name;?>" data-cost="<?php echo $row->cost;?>"><i class="glyphicon glyphicon-usd"></i></a>
								<a class="edit btn btn-sm btn-default" href="#" data-toggle="modal" data-target="#edit_panel"><i class="icon-note"></i></a>
								<a class="delete btn btn-sm btn-danger" href="#" data-id="<?php echo $row->id;?>" data-title="<?php echo $row->name;?>"><i class="icons-office-52"></i></a>
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
	
	<?php $this->load->view('control/modal/add_commission');?>
	<?php $this->load->view('control/modal/edit_commission');?>

	<!-- BEGIN PAGE SCRIPT -->
	<script src="/assets/global/plugins/datatables/jquery.dataTables.min.js"></script> <!-- Tables Filtering, Sorting & Editing -->
    <script src="/assets/global/js/pages/table_dynamic.js"></script>
	<!-- END PAGE SCRIPT -->
		
	<script src="/assets/admin/layout1/js/layout.js"></script>
	<script>
	
	$(function(){
		var table = $('.table-dynamic').DataTable();
		table.order([ 3 , "asc"]).page.len(100).draw();
	});
	
	$('.cost').click(function(){
		var id = $(this).data('id');
		var cost = $(this).data('cost');
		var name = $(this).data('name');
		
		if (confirm("確定委員 " + name + " 已經繳交委員費嗎？程式會自動將費用記入到財務報表。"))
		{
			$.ajax({
				url:'/control/cost/add_commission_cost.html',
				type:'post',
				dataType:'json',
				data:{
					'commission_id':id,
					'cost':cost,
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
	
	$('.delete').click(function(){
		var id = $(this).data('id');
		var title = $(this).data('title');
		
		if (confirm("確定要刪除" + title + "嗎？"))
		{
			$.ajax({
				url:'/control/cost/del_commission.html',
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
