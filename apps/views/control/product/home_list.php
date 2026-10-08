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
                  <h2 class="panel-title"> 首頁產品設定</h2>
                </div>
                <div class="panel-content bg-white">
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <form role="form" class="form-horizontal form-validation" action="/control/product/edit_home_list.html" method="post">
                        <div class="form-group">
                          <label class="col-sm-3 control-label">產品列表(使用商品ID)
                          </label>
                          <div class="col-sm-9">
							<textarea name="product_list" class="form-control" placeholder="請輸入您要顯示在首頁的商品列表，使用換行隔開" rows="15"><?php echo isset($data_list['product_list'])?$data_list['product_list']:'';?></textarea>
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
