<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="zh-Hant">
    <head>
        <?php $this->load->view('control/public/header');?>
		<link href="/assets/global/plugins/jstree/src/themes/default/style.min.css" rel="stylesheet">
		<style>
		.jstree-default .jstree-clicked {
			background-color:#CCC;
		}
		</style>
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
                  <h3 class="panel-title"><strong>搜尋網址產生器</strong></h3>
                </div>
                <div class="panel-content bg-dark">
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
						<h3><strong>說明：</strong></h3>
						<p>1. 產生器產生網址主要適用對象為"選單管理"所呈現之資料，若對於系統管理架構有疑問請查看 <a href="/control/support/index">系統說明</a>。</p>
						<p>2. 產生器產生網址單純產生網址，並不會對系統造成任何設定。</p>
						<p>3. 若不需要的欄位請保持空白。</p>
						<p>4. 自動消除所有空白鍵。</p>
                      <br>
                      <form role="form" class="form-horizontal form-validation" id="support" method="post">
                        <div class="form-group">
                          <label class="col-sm-3 control-label">關鍵字(標題、主石、配石、成色等級、證書、材質、說明、產地、形狀、描述、關鍵字、Youtube影音) 部分吻合
                          </label>
                          <div class="col-sm-9">
                            <input type="text" id="kk" class="form-control" />
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-3 control-label">商品名稱(標題) 部分吻合
                          </label>
                          <div class="col-sm-9">
                            <input type="text" id="title" class="form-control" />
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-3 control-label">主要分類(例如：鑽石、裸石) 部分吻合
                          </label>
                          <div class="col-sm-9">
                            <input type="text" id="type_a" class="form-control" />
                          </div>
                        </div>
						<div class="form-group">
                          <label class="col-sm-3 control-label">次要分類(例如：兩用款、戒指) 部分吻合
                          </label>
                          <div class="col-sm-9">
                            <input type="text" id="type_b" class="form-control" />
                          </div>
                        </div>
						<div class="form-group">
                          <label class="col-sm-3 control-label">主石(例如：黃鑽) 部分吻合
                          </label>
                          <div class="col-sm-9">
                            <input type="text" id="stone" class="form-control" />
                          </div>
                        </div>
						<div class="form-group">
                          <label class="col-sm-3 control-label">配石(例如：白鑽) 部分吻合
                          </label>
                          <div class="col-sm-9">
                            <input type="text" id="sup_stone" class="form-control" />
                          </div>
                        </div>
						<div class="form-group">
                          <label class="col-sm-3 control-label">成色等級 部分吻合
                          </label>
                          <div class="col-sm-9">
                            <input type="text" id="color_level" class="form-control" />
                          </div>
                        </div>
						<div class="form-group">
                          <label class="col-sm-3 control-label">證書 部分吻合
                          </label>
                          <div class="col-sm-9">
                            <input type="text" id="certificate" class="form-control" />
                          </div>
                        </div>
						<div class="form-group">
                          <label class="col-sm-3 control-label">證書編號 部分吻合
                          </label>
                          <div class="col-sm-9">
                            <input type="text" id="certificate_no" class="form-control" />
                          </div>
                        </div>
						<div class="form-group">
                          <label class="col-sm-3 control-label">材質 部分吻合
                          </label>
                          <div class="col-sm-9">
                            <input type="text" id="material" class="form-control" />
                          </div>
                        </div>
						<div class="form-group">
                          <label class="col-sm-3 control-label">重量 完全吻合
                          </label>
                          <div class="col-sm-9">
                            <input type="text" id="weight" class="form-control" />
                          </div>
                        </div>
						<div class="form-group">
                          <label class="col-sm-3 control-label">重量 最大重量
                          </label>
                          <div class="col-sm-9">
                            <input type="text" id="weight_max" class="form-control" />
                          </div>
                        </div>
						<div class="form-group">
                          <label class="col-sm-3 control-label">重量 最小重量
                          </label>
                          <div class="col-sm-9">
                            <input type="text" id="weight_min" class="form-control" />
                          </div>
                        </div>
						<div class="form-group">
                          <label class="col-sm-3 control-label">說明文字 部分吻合
                          </label>
                          <div class="col-sm-9">
                            <input type="text" id="text" class="form-control" />
                          </div>
                        </div>
						<div class="form-group">
                          <label class="col-sm-3 control-label">產地 部分吻合
                          </label>
                          <div class="col-sm-9">
                            <input type="text" id="origin" class="form-control" />
                          </div>
                        </div>
						<div class="form-group">
                          <label class="col-sm-3 control-label">形狀 部分吻合
                          </label>
                          <div class="col-sm-9">
                            <input type="text" id="shape" class="form-control" />
                          </div>
                        </div>
						<div class="form-group">
                          <label class="col-sm-3 control-label">描述(description) 部分吻合
                          </label>
                          <div class="col-sm-9">
                            <input type="text" id="description" class="form-control" />
                          </div>
                        </div>
						<div class="form-group">
                          <label class="col-sm-3 control-label">關鍵字(keywords) 部分吻合
                          </label>
                          <div class="col-sm-9">
                            <input type="text" id="keywords" class="form-control" />
                          </div>
                        </div>
						<div class="form-group">
                          <label class="col-sm-3 control-label">預算 完全吻合
                          </label>
                          <div class="col-sm-9">
                            <input type="text" id="cost" class="form-control" />
                          </div>
                        </div>
						<div class="form-group">
                          <label class="col-sm-3 control-label">預算 最大預算
                          </label>
                          <div class="col-sm-9">
                            <input type="text" id="cost_max" class="form-control" />
                          </div>
                        </div>
						<div class="form-group">
                          <label class="col-sm-3 control-label">預算 最小預算
                          </label>
                          <div class="col-sm-9">
                            <input type="text" id="cost_min" class="form-control" />
                          </div>
                        </div>
						<div class="form-group">
                          <label class="col-sm-3 control-label">Youtube影音 ID 完全吻合
                          </label>
                          <div class="col-sm-9">
                            <input type="text" id="youtube" class="form-control" />
                          </div>
                        </div>
						
                        <div class="row">
                          <div class="col-sm-9 col-sm-offset-3">
                            <div class="pull-right">
								<button type="reset" id="reset_form" class="btn btn-embossed btn-primary m-r-20">清除表單</button>
								<button type="button" id="create_encode_url" class="btn btn-embossed btn-primary m-r-20">產生URL編碼網址</button>
								<button type="button" id="create_url" class="btn btn-embossed btn-primary m-r-20">產生網址</button>
                            </div>
                          </div>
                        </div>
						
						<div class="form-group">
                          <label class="col-sm-3 control-label">產生網址
                          </label>
                          <div class="col-sm-9" id="url">
								
                          </div>
                        </div>
						
                        <div class="row">
                          <div class="col-sm-9 col-sm-offset-3">
                            <div class="pull-right">
								<a type="button" href="#" id="gotourl" target="_blank" class="btn btn-embossed btn-primary m-r-20">前往</a>
								<!--<button type="button" id="copyurl" class="btn btn-embossed btn-primary m-r-20">複製網址</button>-->
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
	<?php $this->load->view('control/modal/edit_menu');?>
		
	<script src="/assets/admin/layout1/js/layout.js"></script>
	
	
	<script>
		var site_search_url = '<?php echo site_url('search/product');?>';
		var btn_ary = ['kk' , 'title' , 'type_a' , 'type_b' , 'stone' , 'sup_stone' , 'color_level' , 'certificate' , 'certificate_no' , 'material' , 'weight' , 'text' , 'origin' , 'shape' , 'description' , 'keywords' , 'cost' , 'youtube' , 'weight_max' , 'weight_min' , 'cost_max' , 'cost_min'];
		var tmp_val = '';
		var get_request_uri = [];
		var create_url = '';
		
		$('#create_url').click(function (){
			createUrl(false);
		});
		$('#create_encode_url').click(function (){
			createUrl(true);
		});
		
		function createUrl(encode)
		{
			
			for(var key in btn_ary)
			{

				tmp_val = $('#' + btn_ary[key]).val();
				
				tmp_val = tmp_val.replace("/\s+/g", "");
				
				if (tmp_val != '')
				{
					get_request_uri.push(btn_ary[key] + '=' + tmp_val);
				}
				
				tmp_val = '';
			}
			
			var counts = 0;
			
			for(var key in get_request_uri) counts++;
			
			console.log(get_request_uri);
			
			if (counts > 0)
			{
				
				create_url = site_search_url + '?' + get_request_uri.join("&");
				
				if (encode == true)
				{
					create_url = encodeURI(create_url);
				}
				
				$('#url').html(create_url);
				$('#gotourl').attr('href' , create_url);
				
				set_defaluts();
			}
			else
			{
				set_defaluts();
				alert('請至少輸入一項搜尋選項');
				return false;
			}
			
			return false;
		}
		
		$('#gotourl').click(function(){
			if ($(this).attr('href') == '#')
			{
				return false;
			}
		});
		
		$('#reset_form').click(function(){
			$('#support')[0].reset();
			
			set_defaluts();
			create_url = '';
			$('#gotourl').attr('href' , '#');
			$('#url').html('');
		});
		
		// $('#gotourl').click(function(){
			// window.open(create_url . '_blank');
		// });
		
		// $('#copyurl').click(function(){

		// });
		
		function set_defaluts()
		{
			get_request_uri = [];
			tmp_val = '';
		}

	</script>
	
    </body>
</html>
