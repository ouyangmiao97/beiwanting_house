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
				<div class="panel panel-default">
					<div class="panel-header bg-dark">
						<h3><i class="fa fa-diamond"></i> 修改 <strong>會員</strong> </h3>
					</div>
					<div class="panel-content bg-white">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<form id="add_product_form" role="form" class="form-horizontal form-validation" action="/control/member/edit_post/" method="post" autocomplete="off">
									<input type="hidden" name="id" id="id" value="<?php echo $data_row->id;?>" />
									<div class="form-group">
										<label class="col-md-3 control-label">會員帳號(※為使管理者方便管理，不限制帳號的修改，但建議不要隨意修改帳號，避免系統錯誤)</label>
										<div class="col-md-9">
											<input type="text" name="login" id="login" class="form-control" placeholder="會員信箱帳號" value="<?php echo $data_row->login;?>" required/>
										</div>
									</div>
									<?php if ($data_row->isfb == 0){?>
									<div class="form-group">
										<label class="col-md-3 control-label">密碼</label>
										<div class="col-md-9">
											<input type="password" name="passwd" id="passwd" class="form-control" placeholder="" value=""/>
										</div>
									</div>
									<?php }?>
									<div class="form-group">
										<label class="col-md-3 control-label">姓名</label>
										<div class="col-md-9">
											<input type="text" name="name" id="name" class="form-control" placeholder="使用者姓名" value="<?php echo $data_row->name;?>" required/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">狀態</label>
										<div class="col-md-9">
											<select name="active" id="active" class="form-control">
												<option value="0">未驗證</option>
												<option value="1" selected>已驗證</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">電話號碼</label>
										<div class="col-md-9">
											<input type="text" name="phone" id="phone" class="form-control" placeholder="電話號碼" value="<?php echo $data_row->phone;?>"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">手機號碼</label>
										<div class="col-md-9">
											<input type="text" name="mobile" id="mobile" class="form-control" placeholder="手機號碼" value="<?php echo $data_row->mobile;?>"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">居住地址</label>
										<div class="col-md-9">
											<input type="text" name="address" id="address" class="form-control" placeholder="居住地址" value="<?php echo $data_row->address;?>"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">郵遞區號</label>
										<div class="col-md-9">
											<input type="text" name="post_no" id="post_no" class="form-control" placeholder="郵遞區號" value="<?php echo $data_row->post_no;?>"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">縣市</label>
										<div class="col-md-9">
											<input type="text" name="city" id="city" class="form-control" placeholder="縣市" value="<?php echo $data_row->city;?>"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">國家</label>
										<div class="col-md-9">
											<input type="text" name="country" id="country" class="form-control" placeholder="縣市" value="<?php echo $data_row->country;?>"/>
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
    </body>
</html>
