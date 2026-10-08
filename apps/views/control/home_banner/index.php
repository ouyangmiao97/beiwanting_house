<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="zh-Hant">
    <head>
        <?php $this->load->view('control/public/header');?>
		<link href="/assets/global/plugins/jstree/src/themes/default/style.min.css" rel="stylesheet">
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
              <div class="panel panel-default">
                <div class="panel-header bg-dark">
                  <h2 class="panel-title">首頁影片設定</h2>
                </div>
                <div class="panel-content bg-white">
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <form role="form" class="form-horizontal form-validation" action="/control/home_banner/edit.html" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                          <label class="col-sm-3 control-label">啟用模式</label>
                          <div class="col-sm-9">
							<select name="mode" class="form-control">
								<option value="0" <?php echo $data_list['mode'] == 0?'selected':'';?>>顯示圖片</option>
								<option value="1" <?php echo $data_list['mode'] == 1?'selected':'';?>>顯示影片</option>
							</select>
                          </div>
                        </div>
						<div class="form-group">
                          <label class="col-sm-3 control-label">圖片路徑大)</label>
                          <div class="col-sm-9">
							<input type="text" class="form-control" name="image_sm" value="<?php echo $data_list['image_sm'];?>" />
                          </div>
                        </div>
						<div class="form-group">
                          <label class="col-sm-3 control-label">圖片路徑(小)</label>
                          <div class="col-sm-9">
							<input type="text" class="form-control" name="image_md" value="<?php echo $data_list['image_md'];?>" />
                          </div>
                        </div>
						<div class="form-group">
                          <label class="col-sm-3 control-label">影片上傳</label>
                          <div class="col-sm-9">
							<input type="file" class="form-control" name="uploadfile" accept="video/mp4" />
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
