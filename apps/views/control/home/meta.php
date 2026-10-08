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
                  <h2 class="panel-title"> 主站 <strong>META</strong> 管理 </h2>
                </div>
                <div class="panel-content bg-white">
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <p>設定您的網站meta資訊，個別頁面若抓不到Title、Description、Keywords時，使用首頁資料</p>
                      <br>
                      <form role="form" class="form-horizontal form-validation" action="/control/home/edit_meta.html" method="post">
                        <div class="form-group">
                          <label class="col-sm-3 control-label">Title(網頁標題)
                          </label>
                          <div class="col-sm-9">
                            <input type="text" name="web_title" class="form-control" placeholder="請輸入網站標題" value="<?php echo isset($web_meta['web_title'])?$web_meta['web_title']:'';?>" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-3 control-label">Title End(標題尾巴) - 全站通用
                          </label>
                          <div class="col-sm-9">
                            <input type="text" name="web_title_end" class="form-control" placeholder="請輸入網站標題結尾" value="<?php echo isset($web_meta['web_title_end'])?$web_meta['web_title_end']:'';?>" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-3 control-label">Author(網站發布者) - 全站通用
                          </label>
                          <div class="col-sm-9">
                            <input type="text" name="web_author" class="form-control" placeholder="請輸入網站作者" value="<?php echo isset($web_meta['web_author'])?$web_meta['web_author']:'';?>" required>
                          </div>
                        </div>
						<div class="form-group">
                          <label class="col-sm-3 control-label">Description(網站描述)
                          </label>
                          <div class="col-sm-9">
                            <input type="text" name="web_description" class="form-control" placeholder="請輸入網站描述" value="<?php echo isset($web_meta['web_description'])?$web_meta['web_description']:'';?>" required>
                          </div>
                        </div>
						<div class="form-group">
                          <label class="col-sm-3 control-label">Keywords(網站關鍵字、相關字詞)
                          </label>
                          <div class="col-sm-9">
                            <input type="text" name="web_keywords" class="form-control" placeholder="請輸入網站關鍵字" value="<?php echo isset($web_meta['web_keywords'])?$web_meta['web_keywords']:'';?>" required>
                          </div>
                        </div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Footer頁尾文字</label>
							<div class="col-sm-9">
							<textarea name="web_footer" class="form-control" placeholder="請輸入頁尾版權宣告文字" required><?php echo isset($web_meta['web_footer'])?$web_meta['web_footer']:'';?></textarea>
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
