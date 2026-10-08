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
						<h3><strong>商品資訊</strong></h3>
					</div>
					
					<div class="panel-content">
						<table class="table table-hover">
						<thead>
						  <tr>
							<th width="10%">ID</th>
							<th width="10%">圖片</th>
							<th width="40%">品名</th>
							<th width="20%">品牌</th>
							<th width="20%">價格</th>
						  </tr>
						</thead>
						<tbody>
							<?php if (isset($product)){?>
							<tr>	
								<td><?php echo $product->id;?></td>
								<td><img src="<?php echo isset($product->img_file)?img_show($product->img_file->file_name):'/images/no-image.jpg';?>" width="100%" height=""></td>
								<td><?php echo $product->title;?></td>
								<td><?php echo $product->brand;?></td>
								<td><?php echo $product->price_max == $product->price_min ? $product->price_max : $product->price_min . '-' . $product->price_max;?></td>
							</tr>
							<?php }?>
						</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<div class="panel">
					<div class="panel-header">
						<h3><strong>商品規格管理</strong></h3>
					</div>
					<div class="panel-content">
					<a href="/control/product_type/add/<?php echo $pid;?>" type="button" class="btn btn-dark btn-square">新增商品規格</a>
					<a href="/control/inventory/index" type="button" class="btn btn-dark btn-square">庫存總表</a>
					  <table class="table table-hover table-dynamic">
						<thead>
						  <tr>
							<th width="10%">ID</th>
							<th width="10%">號數</th>
							<th width="10%">開啟</th>
							<th width="10%">顏色</th>
							<th width="10%">容量</th>
							<th width="10%">長度</th>
							<th width="10%">價格</th>
							<th width="10%">庫存量</th>
							<th width="20%">操作</th>
						  </tr>
						</thead>
						<tbody>
							<?php if (isset($data_list) && is_array($data_list)){?>
							<?php foreach($data_list as $key => $row){?>
							<tr>	
								<td><?php echo $row->id;?></td>
								<td><?php echo $row->no;?></td>
								<td>
								<label class="switch switch-green">
								<input type="checkbox" class="switch-input changeActiveBtn" <?php echo $row->active==1?'checked':'';?> data-id="<?php echo $row->id;?>">
								<span class="switch-label" data-on="Yes" data-off="No"></span>
								<span class="switch-handle"></span>
								</label>
								</td>
								<td><?php echo $row->color;?></td>
								<td><?php echo $row->cap;?></td>
								<td><?php echo $row->length;?></td>
								<td><?php echo $row->price;?></td>
								<td><?php echo $row->inventory;?></td>
								<td>
									<a class="btn btn-sm btn-default" href="/control/product_type/edit/<?php echo $pid;?>/<?php echo $row->id;?>">修改</a>
									<a class="delete btn btn-sm btn-danger" href="#" data-id="<?php echo $row->id;?>" data-title="<?php echo $row->no;?>">刪除</a>
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
					url:'/control/product_type/change_active.html',
					type:'post',
					dataType:'json',
					data:{
						'id':id,
						'checkeds':checkeds,
					},
					success:function(response){
						console.log(response);
						if (response.status='T')
						{
							
						}
						else if(response.status='F')
						{
							alert(response.msg);
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
			$.post('/control/product_type/del/<?php echo $pid;?>' , {'id' : id} , function(response){
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
