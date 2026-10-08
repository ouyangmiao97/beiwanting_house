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
						<h3><i class="icon-layers"></i> 今日財務報表 </h3>
					</div>
					<div class="panel-content">
					<button type="button" class="btn btn-dark btn-square" data-toggle="modal" data-target="#add_panel">新增收入 / 支出</button>
					  <table class="table table-hover table-dynamic">
						<thead>
						  <tr>
							<th width="10%">ID</th>
							<th width="20%">帳務日期</th>	
							<th width="10%">收入項目</th>
							<th width="10%">金額</th>
							<th width="10%">支出項目</th>
							<th width="10%">金額</th>		
							<th width="10%">備註</th>
							<th width="10%">最後修改人</th>
							<th width="10%">操作</th>			
						  </tr>
						</thead>
						<tbody>
						<?php $cost_in = 0 ; $cost_out = 0;?>
						<?php if (isset($data_list) && count($data_list) > 0){?>
						<?php foreach($data_list as $key => $row){?>
						<?php if ($row->type == 0) $cost_out += $row->cost;?>
						<?php if ($row->type == 1) $cost_in += $row->cost;?>
							<tr class="<?php echo $row->type==1?'success':'danger';?>">
								<td><?php echo $row->id;?></td>
								<td><?php echo $row->create_at;?></td>
								<td><?php echo $row->type==1?$cost_item_ary[$row->item]->title:'';?></td>
								<td><?php echo $row->type==1?to_money($row->cost):'';?></td>
								<td><?php echo $row->type==0?$cost_item_ary[$row->item]->title:'';?></td>
								<td><?php echo $row->type==0?to_money($row->cost):'';?></td>
								<td><?php echo $row->memo;?></td>
								<td><?php echo $row->account_name;?></td>

								<td><div class="text-right">
								<a class="edit btn btn-sm btn-default" href="#" data-toggle="modal" data-target="#edit_panel"><i class="icon-note"></i></a>
								<a class="delete btn btn-sm btn-danger" href="#" data-id="<?php echo $row->id;?>" data-title="<?php echo $row->cost;?>"><i class="icons-office-52"></i></a>
								</div></td>
							</tr>
						<?php }?>
						<?php }?>
						</tbody>
					  </table>
						<div class="row">
						<div class="col-md-3 col-md-offset-6">
							<p>今日　<strong>收入小計：&nbsp;&nbsp;</strong><strong><?php echo to_money($cost_in);?></strong></p>
							<p>今日　<strong>支出小計：&nbsp;&nbsp;</strong><strong><?php echo to_money($cost_out);?></strong></p>
							<p>今日　<strong>淨利小計：&nbsp;&nbsp;</strong><strong><?php echo to_money($cost_in - $cost_out);?></strong></p>
						</div>
						<div class="col-md-3">
							<p><strong>收入總計：&nbsp;&nbsp;</strong><strong><?php echo to_money($total_in);?></strong></p>
							<p><strong>支出總計：&nbsp;&nbsp;</strong><strong><?php echo to_money($total_out);?></strong></p>
							<p><strong>淨利總計：&nbsp;&nbsp;</strong><strong><?php echo to_money($total_in - $total_out);?></strong></p>
						</div>
						</div>
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
	<?php $this->load->view('control/modal/add_cost');?>
	<?php $this->load->view('control/modal/edit_cost');?>

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
				url:'/control/cost/del_cost.html',
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
