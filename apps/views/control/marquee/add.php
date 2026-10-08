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
						<h3><i class="fa fa-diamond"></i> 新增 <strong>跑馬燈</strong> </h3>
					</div>
					<div class="panel-content bg-white">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<form id="add_product_form" role="form" class="form-horizontal form-validation" action="/control/marquee/add_post" method="post" enctype="multipart/form-data" autocomplete="off">
									<div class="form-group">
										<label class="col-md-3 control-label">標題</label>
										<div class="col-md-9">
											<input type="text" name="title" id="title" class="form-control" placeholder="請輸入標題" required/>
										</div>
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
	<script>
	
	var img_list = [];
	
	$('#start_date').datepicker({
		dateFormat: "yy-mm-dd"
	});
	$('#end_date').datepicker({
		dateFormat: "yy-mm-dd"
	});
	$('#discount_end_date').datepicker({
		dateFormat: "yy-mm-dd"
	});
	
	
	
	$('#discount_active').change(function(){
		if ($(this).val() == '1')
		{
			$('#discount_end_date_div').show();
			$('#discount_price_div').show();
		}
		else
		{
			$('#discount_end_date_div').hide();
			$('#discount_price_div').hide();
		}
	});
	
	$('#discount_active').change();
	
	//新增 預設開啟所有度數
	<?php
	$degree = array();
	foreach($degree_list as $key => $row){
		array_push($degree , $row->title);
	}
	?>
	$('#degree').val(<?php echo json_encode($degree);?>);

	
	// dropzone
	$(function() {
		// my dropzonec create
		var MyeyeDropzone = new Dropzone("div#mydropzone", {
			url: "/control/product/dropzone_file" , 
			acceptedFiles:'image/jpeg,image/jpg,image/png,image/gif',
			addRemoveLinks:true,
			dictCancelUpload:"取消"  , 
			dictCancelUploadConfirmation:"確定要取消上傳嗎"  , 
			dictRemoveFile:"刪除"  , 
		});
		
		// when upload success doing
		MyeyeDropzone.on("success", function(file , response) {
			
			if (response != 'undefined' && response != null && response != false)
			{
				// 解析伺服器回傳資訊
				var data = JSON.parse(response);
				
				// 產生圖片的識別資訊
				var lastModified = file.lastModified;
				var rand = Math.floor((Math.random() * 10000) + 1);
				
				// 將新的寫入js變數
				img_list.push(data.img_id + '_' + lastModified + '_' + rand);
				
				//更新線上資料的識別資訊
				$.ajax({
					url:'/control/product/dropzone_update.html',
					type:'post',
					dataType:'json',
					data:{
						'id':data.img_id,
						'mask':lastModified,
						'rand':rand,
					},
					async:false,
					success:function(data){
						console.log('update uploads info success.');
					},
					error:function(e)
					{
						console.log('update uploads errro.');
						console.log(e);
					}
				});
			}
			else
			{
				console.log('dropzone upload error.');
				alert('上傳發生錯誤，請重新執行');
				return false;
			}
		});
		
		MyeyeDropzone.on("removedfile", function(file , response){
			// 移除線上圖片檔案與JS變數
			var delid = 0;
			var delid_bk = 0;
			var delid_t = 0;
			var delid_random = 0;
			
			for(i = 0 ; i < img_list.length ; i++)
			{
				box = img_list[i].split('_');
				
				//使用lastModified值識別
				if (file.lastModified == box[1])
				{
					if (delid == 0)
					{
						delid = i;
						delid_bk = box[0];
						delid_t = box[1];
						delid_random = box[2];
					}
					else
					{
						alert('資料錯誤');
					}
				}
			}

			img_list.splice(delid, 1);
			
			$.ajax({
				url:'/control/product/dropzone_remove.html',
				type:'post',
				dataType:'json',
				data:{
					'id':delid_bk,
				},
				async:false,
				success:function(data){
					console.log('remove the uploads img success. (id:' + delid_bk + ')');
				},
				error:function(e)
				{
					console.log('remove the uploads img error.');
					console.log(e);
				}
			});
		});
			
		$('#add_product_form').submit(function (){
			
			var shipping_methods_list = $('#shipping_methods').val();
			var degree_list = $('#degree').val();
			var color_list = $('#color').val();
			var rule_sub_list = $('#rule_sub_list').val();

			if (shipping_methods_list == 'undefined' || shipping_methods_list == null) shipping_methods_list = [];
			if (degree_list == 'undefined' || degree_list == null) degree_list = [];
			if (color_list == 'undefined' || color_list == null) color_list = [];
			if (rule_sub_list == 'undefined' || rule_sub_list == null) rule_sub_list = [];
		
			$('#shipping_methods_list').val(shipping_methods_list.join());
			$('#degree_list').val(degree_list.join());
			$('#color_list').val(color_list.join());
			$('#rule_sub').val(rule_sub_list.join());
			
			//將JG變數中的圖片陣列讀取到input中隨表單送出至產品上傳
			for (i = 0;i < img_list.length;i++)
			{
				box = img_list[i].split('_');
				//add img list join the input
				$('#img_list').val($('#img_list').val() + box[0] + ',');
			}
		});
	});
	</script>
</html>
