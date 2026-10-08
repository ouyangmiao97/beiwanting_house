<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="zh-Hant">
    <head>
        <?php $this->load->view('control/public/header');?>
		<link href="/assets/global/plugins/dropzone/dropzone.min.css" rel="stylesheet">
		<link href="/assets/global/plugins/input-text/style.min.css" rel="stylesheet">
		<script src="/assets/global/plugins/modernizr/modernizr-2.6.2-respond-1.1.0.min.js"></script>
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
						<h3><i class="fa fa-diamond"></i> <strong>商品 </strong> 管理 </h3>
					</div>
					<div class="panel-content">
					<a type="button" class="btn btn-dark btn-square" href="<?php echo site_url('/control/product/');?>">回到產品列表</a>
					<a type="button" class="add btn btn-dark btn-square" data-toggle="modal" data-target="#add_panel">新增庫存</a>
					  <table class="table table-hover table-dynamic">
						<thead>
						  <tr>
							<th width="10%">#</th>
							<th width="10%">系統ID</th>
							<th width="15%">產品編號</th>
							<th width="30%">品名</th>
							<th width="15%">庫存量</th>
							<th width="30%">操作</th>
						  </tr>
						</thead>
						<tbody>
							<?php if (isset($data_list) && is_array($data_list)){?>
							<?php foreach($data_list as $key => $row){?>
							<tr>	
								<td><?php echo $row->id;?></td>
								<td><?php echo $row->pid;?></td>
								<td><?php echo $row->product_id;?></td>
								<td><?php echo $row->title;?></td>
								<td><?php echo $row->num;?></td>
								<td><div class="text-right"><a type="button" class="edit btn btn-sm btn-default" data-toggle="modal" data-target="#edit_panel">修改</a><a class="delete btn btn-sm btn-danger" href="#" data-id="<?php echo $row->id;?>">刪除</a></div></td>
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
	<?php $this->load->view('control/modal/add_inventory');?>
	<?php $this->load->view('control/modal/edit_inventory');?>
	
	<!-- BEGIN PAGE SCRIPT -->
    <script src="/assets/global/plugins/datatables/jquery.dataTables.min.js"></script> <!-- Tables Filtering, Sorting & Editing -->
    <script src="/assets/global/js/pages/table_dynamic.js"></script>
    <script src="/assets/global/plugins/switchery/switchery.min.js"></script> <!-- IOS Switch -->
    <script src="/assets/global/plugins/bootstrap-tags-input/bootstrap-tagsinput.min.js"></script> <!-- Select Inputs -->
    <script src="/assets/global/plugins/dropzone/dropzone.min.js"></script>  <!-- Upload Image & File in dropzone -->
    <script src="/assets/global/js/pages/form_icheck.js"></script>  <!-- Change Icheck Color - DEMO PURPOSE - OPTIONAL -->
	<!-- END PAGE SCRIPT -->		
	<script src="/assets/admin/layout1/js/layout.js"></script>
	<script>
	$(function(){
		var table = $('.table-dynamic').DataTable();
		table.order([ 4 , "asc"]).page.len(100).draw();
	});
	
		$('.delete').click(function(){
			var id = $(this).data('id');
			
			if (confirm("確定要刪除編號" + id + "的庫存嗎？"))
			{
				$.ajax({
					url:'/control/inventory/del_inventory',
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
