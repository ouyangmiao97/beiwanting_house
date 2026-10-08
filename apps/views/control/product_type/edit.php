<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="zh-Hant">
    <head>
        <?php $this->load->view('control/public/header');?>
		<link href="/assets/global/plugins/dropzone/dropzone.min.css" rel="stylesheet">
		<link href="/assets/global/plugins/input-text/style.min.css" rel="stylesheet">
		<link href="/assets/admin/layout1/css/layout.css" rel="stylesheet">
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
								<td><?php echo $product->price;?></td>
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
				<div class="panel panel-default">
					<div class="panel-header bg-dark">
						<h3><strong>新增商品商品規格</strong></h3>
					</div>
					<div class="panel-content bg-white">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<form id="edit" role="form" class="form-horizontal form-validation" action="/control/product_type/edit_post/<?php echo $pid;?>" method="post" enctype="multipart/form-data" autocomplete="off">
									<input type="hidden" name="id" value="<?php echo $data_row->id;?>" />
									<input type="hidden" name="pid" value="<?php echo $pid;?>" />
									<div class="form-group">
										<label class="col-md-3 control-label">號數：</label>
										<div class="col-md-9">
											<input type="text" name="no" id="no" class="form-control" value="<?php echo $data_row->no;?>" placeholder="請輸入號數" required/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">開啟狀態</label>
										<div class="col-md-9">
											<select name="active" id="active" class="form-control">
												<option value="1" <?php echo $data_row->active==1?'selected':'';?>>開啟</option>
												<option value="0" <?php echo $data_row->active==0?'selected':'';?>>關閉</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">顏色敘述：</label>
										<div class="col-md-9">
											<input type="text" name="color" id="color" class="form-control" value="<?php echo $data_row->color;?>" placeholder="請輸入顏色敘述"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">容量敘述：</label>
										<div class="col-md-9">
											<input type="text" name="cap" id="cap" class="form-control" value="<?php echo $data_row->cap;?>" placeholder="請輸入容量敘述"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">長度敘述：</label>
										<div class="col-md-9">
											<input type="text" name="length" id="length" class="form-control" value="<?php echo $data_row->length;?>" placeholder="請輸入長度敘述"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">庫存：</label>
										<div class="col-md-9">
											<input type="number" name="inventory" id="inventory" value="<?php echo $data_row->inventory;?>" class="form-control" placeholder="請輸入庫存量"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">價格：</label>
										<div class="col-md-9">
											<input type="number" name="price" id="price" class="form-control" value="<?php echo $data_row->price;?>" placeholder="請輸入該項目價格"/>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-9 col-sm-offset-3">
											<div class="pull-right">
											<button type="submit" class="btn btn-embossed btn-primary m-r-20">儲存</button>
											</div>
										</div>
									</div>
								</form>
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
	
	
	<!-- BEGIN PAGE SCRIPT -->
    <script src="/assets/global/plugins/switchery/switchery.min.js"></script> <!-- IOS Switch -->
    <script src="/assets/global/plugins/bootstrap-tags-input/bootstrap-tagsinput.min.js"></script> <!-- Select Inputs -->
    <script src="/assets/global/plugins/dropzone/dropzone.js"></script>  <!-- Upload Image & File in dropzone -->
    <script src="/assets/global/js/pages/form_icheck.js"></script>  <!-- Change Icheck Color - DEMO PURPOSE - OPTIONAL -->
	<!-- END PAGE SCRIPT -->		
	<script src="/assets/admin/layout1/js/layout.js"></script>
	<script>
		$('#edit').submit(function(){
			var color = $('#color').val();
			var cap = $('#cap').val();
			var length = $('#length').val();
			
			if (color == "" && cap == "" && length == "")
			{
				alert('顏色、容量、長度請擇一填寫');
				return false;
			}
		});
	</script>
    </body>
</html>
