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
						<h3><strong>庫存總表</strong></h3>
					</div>
					<div class="panel-content">
					<a type="button" class="btn btn-dark btn-square" href="/control/product/index">產品列表</a>
					  <table class="table table-hover table-dynamic">
						<thead>
						  <tr>
							<th width="10%">#</th>
							<th width="5%">圖片</th>
							<th width="10%">產品編號</th>
							<th width="15%">品名</th>
							<th width="10%">號數</th>
							<th width="10%">品牌</th>
							<th width="10%">價格</th>
							<th width="10%">庫存量</th>
							<th width="20%">操作</th>
						  </tr>
						</thead>
						<tbody>
							<?php if (isset($data_list) && is_array($data_list)){?>
							<?php foreach($data_list as $key => $row){?>
							<tr>	
								<td><?php echo $row->ptid;?></td>
								<td><img src="<?php echo isset($row->img_file)?img_show($row->img_file->file_name):'/images/no-image.jpg';?>" width="100%" height=""></td>
								<td><?php echo $row->pid;?></td>
								<td><?php echo $row->title;?></td>
								<td><?php echo $row->ptno;?></td>
								<td><?php echo $row->brand;?></td>
								<td><?php echo $row->price_max == $row->price_min ? $row->price_max : $row->price_min . '-' . $row->price_max;?></td>
								<td><?php echo $row->inventory;?></td>
								<?php /*<td><div class="text-right"><a type="button" class="edit btn btn-sm btn-default" data-toggle="modal" data-target="#edit_panel">修改</a></div></td>*/?>
								<td>
									<a href="/control/product_type/edit/<?php echo $row->pid;?>/<?php echo $row->ptid;?>" type="button" class="btn btn-sm btn-default">修改</a>
									<a class="delete btn btn-sm btn-danger" href="#" data-id="<?php echo $row->ptid;?>" data-title="<?php echo $row->ptno;?>" data-pid="<?php echo $row->pid;?>">刪除</a>
								</td>
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
		table.order([ 2 , "desc"]).page.len(100).draw();
	});		
	</script>
	<script>
	$('.delete').click(function(){
		var id = $(this).data('id');
		var title = $(this).data('title');
		var pid = $(this).data('pid');
		if (confirm("確定要刪除" + title + "嗎？(此為刪除子項目)"))
		{
			$.post('/control/product_type/del/' + pid , {'id' : id} , function(response){
				if (response.status == 'T')
				{
					alert('處理完成');
					location.reload();
					return false;
				}
				else
				{
					alert(response.msg);
					return false;
				}
			} , 'json');
		}
	});
	</script>
    </body>
</html>
