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
						<h3><i class="fa fa-diamond"></i> 修改 <strong>跑馬燈</strong> </h3>
					</div>
					<div class="panel-content bg-white">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<form id="add_product_form" role="form" class="form-horizontal form-validation" action="/control/marquee/edit_post" method="post" enctype="multipart/form-data">
									<input type="hidden" name="id" value="<?php echo $data_row->id;?>">
									<div class="form-group">
										<label class="col-md-3 control-label">標題</label>
										<div class="col-md-9">
											<input type="text" name="title" class="form-control" placeholder="標題" value="<?php echo $data_row->title;?>" required></input>
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
    <script src="/assets/global/plugins/dropzone/dropzone.min.js"></script>  <!-- Upload Image & File in dropzone -->
    <script src="/assets/global/js/pages/form_icheck.js"></script>  <!-- Change Icheck Color - DEMO PURPOSE - OPTIONAL -->
	<!-- END PAGE SCRIPT -->		
	<script src="/assets/admin/layout1/js/layout.js"></script>
    </body>

</html>
