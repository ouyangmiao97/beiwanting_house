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
					<div class="row">
					<div class="col-md-2">
					<a type="button" class="btn btn-dark btn-square" id="add_product">新增商品</a>

					</div>
					<div class="col-md-2">
					<strong>開啟狀態：</strong>
					<select name="seltoactive" id="seltoactive">
						<option value="0" <?php echo $ac==0?'selected':'';?>>全部顯示</option>
						<option value="1" <?php echo $ac==1?'selected':'';?>>僅顯示開啟</option>
						<option value="2" <?php echo $ac==2?'selected':'';?>>僅顯示關閉</option>
					</select>
					</div>
					</div>
					  <table class="table table-hover table-dynamic">
						<thead>
						  <tr>
							<th width="10%">ID</th>
							<th width="10%">品牌</th>
							<th width="20%">品名</th>
							<th width="10%">SIZE</th>
							<th width="10%">開啟</th>
							<th width="10%">價格</th>
							<th width="30%">操作</th>
						  </tr>
						</thead>
						<tbody>
							<?php if (isset($data_list) && is_array($data_list)){?>
							<?php foreach($data_list as $key => $row){?>
							<tr>	
								<td><?php echo $row->id;?></td>
								<td><?php echo $row->brand;?></td>
								<td><?php echo $row->title;?></td>
								<td><?php echo $row->size;?></td>
								<td>
								<label class="switch switch-green">
								<input type="checkbox" class="switch-input changeActiveBtn" <?php echo $row->active==1?'checked':'';?> data-id="<?php echo $row->id;?>">
								<span class="switch-label" data-on="Yes" data-off="No"></span>
								<span class="switch-handle"></span>
								</label>
								</td>
								<td><?php echo $row->price;?></td>
								
								<td><div class="text-right">
								<?php /*<a class="btn btn-sm btn-default" href="/control/product_type/index/<?php echo $row->id;?>">商品規格</a>*/?>
								<a class="pedit btn btn-sm btn-default" href="<?php echo site_url('control/product/edit_page_html/product_' . $row->id);?>">商品詳情</a>
								<a class="pedit btn btn-sm btn-default" href="<?php echo site_url('control/product_features/index/' . $row->id);?>" target="_blank">Features</a>
								<a class="edit btn btn-sm btn-default" href="#" data-id="<?php echo $row->id;?>">修改</a>
								<?php /*<a class="inventory btn btn-sm btn-default" href="<?php echo site_url('control/inventory/index/' . $row->id);?>">庫存</a>*/?>
								<a class="delete btn btn-sm btn-danger" href="#" data-id="<?php echo $row->id;?>" data-title="<?php echo $row->title;?>">刪除</a>
								</div></td>
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
		table.order([ 0 , "desc"] , [ 2 , "desc"]).page.len(100).draw();
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
				$.ajax({
					url:'/control/product/change_active.html',
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

	$('.changeLengthBtn').click(function(){
		// console.log($(this).attr('checked'));
		var checkeds = 0;//預設未處理
		var id = $(this).data('id');
		
		if ($(this).attr('checked') == 'checked')
		{
			checkeds = 0;
		}
		else
		{
			checkeds = 1;
		}
				$.ajax({
					url:'/control/product/change_length.html',
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



		$('#add_product').click(function(){
			window.location.href = "/control/product/add_product.html";
			return false;
		});
		$('.edit').click(function(){
			var id = $(this).data('id');
			window.location.href = "/control/product/edit_product.html?id=" + id;
			return false;
		});
		$('.delete').click(function(){
			var title = $(this).data('title');
			var id = $(this).data('id');
			
			if (confirm("確定要刪除" + title + "嗎？"))
			{
				$.ajax({
					url:'/control/product/del_product',
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
		
		$('#seltoactive').change(function(){
			var v = $(this).val();
			
			window.location.href = "/control/product/index.html?ac=" + v;
		});
	</script>
    </body>
</html>
