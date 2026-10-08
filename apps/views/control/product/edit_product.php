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
						<h3><i class="fa fa-diamond"></i> 修改 <strong>商品</strong> </h3>
					</div>
					<div class="panel-content bg-white">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<form id="add_product_form" role="form" class="form-horizontal form-validation" action="/control/product/edit_product_post" method="post" enctype="multipart/form-data">
								<input type="hidden" name="id" value="<?php echo $data_row->id;?>">
									<div class="form-group">
										<label class="col-md-3 control-label">商品名稱＊</label>
										<div class="col-md-9">
											<input type="text" name="title" id="title" class="form-control" value="<?php echo $data_row->title;?>" placeholder="請輸入商品名稱" required/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">建立時間(目前的排序依據新→舊)＊</label>
										<div class="col-md-9">
											<input type="text" name="create_at" id="create_at" class="form-control" placeholder="" value="<?php echo $data_row->create_at;?>" required/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">商品編號</label>
										<div class="col-md-9">
											<?php /*<input type="text" name="product_id" id="product_id" class="form-control" value="<?php echo $data_row->product_id;?>" placeholder="請輸入商品編號" required/>*/?>
											<textarea name="product_id" id="product_id" class="form-control" placeholder="請輸入商品編號" rows="5"><?php echo $data_row->product_id;?></textarea>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">商品品牌＊</label>
										<div class="col-md-9">
											<input type="text" name="brand" id="brand" class="form-control" value="<?php echo $data_row->brand;?>" placeholder="請輸入商品品牌" required/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">價格</label>
										<div class="col-md-9">
											<?php /*<input type="text" name="price" id="price" class="form-control" value="<?php echo $data_row->price;?>" placeholder="請輸入價格" required/>*/?>
											<textarea name="price" id="price" class="form-control" placeholder="請輸入價格" rows="5"><?php echo $data_row->price;?></textarea>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">SIZE</label>
										<div class="col-md-9">
											<?php /*<input type="text" name="size" id="size" class="form-control" value="<?php echo $data_row->size;?>" placeholder="請輸入SIZE"/>*/?>
											<textarea name="size" id="size" class="form-control" placeholder="請輸入SIZE" rows="5"><?php echo $data_row->size;?></textarea>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">商品主分類＊</label>
										<div class="col-md-9">
											<select name="type_a" id="type_a" class="form-control" required>
												<option value="">請選擇一項主分類</option>
												<?php foreach($type_a_list as $key => $row){?>
													<option value="<?php echo $row->id;?>" <?php echo $row->id == $data_row->type_a?'selected':'';?>><?php echo $row->title;?></option>
												<?php }?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">商品次分類＊</label>
										<div class="col-md-9">
											<select name="type_b" id="type_b" class="form-control" required>
												<?php foreach($type_b_list as $key => $row){?>
												<option value="<?php echo $row->id;?>" <?php echo $row->id == $data_row->type_b?'selected':'';?>><?php echo $row->title;?></option>
												<?php }?>
											</select>
										</div>
									</div>
									<?php /*
									<div class="form-group">
										<label class="col-md-3 control-label">商品種類＊</label>
										<div class="col-md-9">
											<select name="brand" id="brand" class="form-control">
											<?php foreach($brand_list as $key => $row){?>
											<?php if ($row->id === $data_row->brand_id){?>
												<option value="<?php echo $row->id .'_' . $row->title;?>" selected><?php echo $row->title;?></option>
											<?php }else{?>
												<option value="<?php echo $row->id . '_' . $row->title;?>"><?php echo $row->title;?></option>
											<?php }?>
											<?php }?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">入數＊</label>
										<div class="col-md-9">
											<select name="pick" id="pick" class="form-control" required>
											<?php foreach($pick_list as $key => $row){?>
											<?php if ($row->title === $data_row->pick){?>
												<option value="<?php echo $row->title;?>" selected><?php echo $row->title;?></option>
											<?php }else{?>
												<option value="<?php echo $row->title;?>"><?php echo $row->title;?></option>
											<?php }?>
											<?php }?>
											</select>
										</div>
									</div>*/?>
									<?php /*
									<div class="form-group">
										<label class="col-md-3 control-label">價格＊</label>
										<div class="col-md-9">
											<input type="number" name="price" id="price" class="form-control" placeholder="請輸入價格" value="<?php echo $data_row->price;?>" required />
										</div>
									</div>
									*/?>
									<?php /*
									<div class="form-group">
										<label class="col-md-3 control-label">產地＊</label>
										<div class="col-md-9">
											<select name="origin" id="origin" class="form-control">
											<?php foreach($origin_list as $key => $row){?>
											<?php if ($row->title === $data_row->origin){?>
												<option value="<?php echo $row->title;?>" selected><?php echo $row->title;?></option>
											<?php }else{?>
												<option value="<?php echo $row->title;?>"><?php echo $row->title;?></option>
											<?php }?>
											<?php }?>
											</select>
										</div>
									</div>*/ ?>
									<?php /*
									<div class="form-group">
										<label class="col-md-3 control-label">產品字號</label>
										<div class="col-md-9">
											<input type="text" name="number_product" id="number_product" class="form-control" value="<?php echo $data_row->number_product;?>" placeholder="請輸入產品許可字號"></input>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">廣告字號</label>
										<div class="col-md-9">
											<input type="text" name="number_ad" id="number_ad" class="form-control" value="<?php echo $data_row->number_ad;?>" placeholder="請輸入廣告許可字號"></input>
										</div>
									</div>
									*/?>
									<div class="form-group">
										<label class="col-md-3 control-label">可選擇顏色</label>
										<div class="col-md-9">
										<select name="color" id="color" class="form-control" placeholder="請點選展開顏色列表，並選取該產品提供的顏色(可複選)" multiple>
											<?php foreach($color_list as $key => $row){?>
												<option value="<?php echo $row->id;?>"><?php echo $row->title;?></option>
											<?php }?>
										</select>
										<input type="hidden" name="color_list" id="color_list" value="" />
										</div>
									</div>
									<?php /*
									<div class="form-group">
										<label class="col-md-3 control-label">上架日</label>
										<div class="col-md-9">
											<input type="text" name="start_date" id="start_date" class="form-control" value="<?php echo $data_row->start_date;?>" placeholder="請輸入上架日期" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">下架日</label>
										<div class="col-md-9">
											<input type="text" name="end_date" id="end_date" class="form-control" value="<?php echo $data_row->end_date;?>" placeholder="請輸入下架日期" />
										</div>
									</div>*/?>
									<div class="form-group">
										<label class="col-md-3 control-label">開啟狀態</label>
										<div class="col-md-9">
											<select name="active" id="active" class="form-control">
												<option value="1" <?php echo $data_row->active==1?'selected':'';?>>開啟</option>
												<option value="0" <?php echo $data_row->active==0?'selected':'';?>>關閉</option>
											</select>
										</div>
									</div>
									<?php /*
									<div class="form-group">
										<label class="col-md-3 control-label">特價是否開啟</label>
										<div class="col-md-9">
											<select name="discount_active" id="discount_active" class="form-control">
												<option value="1" <?php echo $data_row->discount_active==1?'selected':'';?>>開啟</option>
												<option value="0" <?php echo $data_row->discount_active==0?'selected':'';?>>關閉</option>
											</select>
										</div>
									</div>
									<div class="form-group" id="discount_end_date_div">
										<label class="col-md-3 control-label bg-primary">特價截止日期</label>
										<div class="col-md-9">
											<input type="text" name="discount_end_date" id="discount_end_date" class="form-control" value="<?php echo $data_row->discount_end_date;?>" placeholder="請輸入特價截止日期" />
										</div>
									</div>
									<div class="form-group" id="discount_price_div">
										<label class="col-md-3 control-label bg-primary">特價價格</label>
										<div class="col-md-9">
											<input type="number" name="discount_price" id="discount_price" class="form-control" value="<?php echo $data_row->discount_price;?>" placeholder="請輸入特價金額" />
										</div>
									</div>
									*/?>
									<div class="form-group">
										<label class="col-md-3 control-label">Specification</label>
										<div class="col-md-9">
											<textarea class="form-control" name="specification" placeholder="請輸入規格訊息" rows="10"><?php echo $data_row->specification;?></textarea>
										</div>
									</div>
									<?php /*
									<div class="form-group">
										<label class="col-md-3 control-label">產品簡述</label>
										<div class="col-md-9">
											<textarea class="form-control" name="memo" placeholder="請輸入產品簡述" rows="5"><?php echo $data_row->memo;?></textarea>
										</div>
									</div>*/?>
									<div class="form-group">
										<label class="col-md-3 control-label">description</label>
										<div class="col-md-9">
											<input type="text" name="description" id="description" class="form-control" value="<?php echo $data_row->description;?>" placeholder="description" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">keywords</label>
										<div class="col-md-9">
											<input type="text" name="keywords" id="keywords" class="form-control" value="<?php echo $data_row->keywords;?>" placeholder="keywords" />
										</div>
									</div>
									<?php /*
									<div class="form-group">
										<label class="col-md-3 control-label">篩選項目</label>
										<div class="col-md-9">
										<select name="rule_sub_list" id="rule_sub_list" class="form-control" placeholder="請點選展開篩選項目列表，並選取該產品篩選的項目(可複選)" multiple>
											<?php foreach($rule_sub_list as $key => $row){?>
												<option value="<?php echo $row->id;?>"><?php echo $row->title;?></option>
											<?php }?>
										</select>
										<input type="hidden" name="rule_sub" id="rule_sub" value="" />
										</div>
									</div>*/?>
									<div class="form-group">
										<label class="col-md-3 control-label">圖片文字(請使用換行分隔)</label>
										<div class="col-md-9">
											<textarea name="img_memo" id="img_memo" class="form-control" placeholder="(請使用換行分隔)" rows="10"><?php echo $data_row->img_memo;?></textarea>
										</div>
									</div>
									<div class="row">			
										<!--
										<div class="col-md-4">
											<div class="fileinput fileinput-new" data-provides="fileinput">
												<p><strong>上傳主要圖片＊</strong></p>
												<div class="fileinput-new thumbnail">
													<img data-src="" src="/assets/global/images/gallery/3.jpg" class="img-responsive" alt="gallery 3">
												</div>
												<div class="fileinput-preview fileinput-exists thumbnail"></div>
												<div>
													<span class="btn btn-default btn-file"><span class="fileinput-new">Select image...</span><span class="fileinput-exists">Change</span>
													<input type="file" name="img_1" required>
													</span>
													<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
												</div>
											</div>
											<div class="form-group col-md-12">
												<label class="col-sm-3 control-label">圖片ALT</label>
												<div class="col-sm-9">
													<input class="form-control" id="alt_1" name="alt_1" type="text" placeholder="輸入圖片ALT">
												</div>
											</div>
										</div>
										-->
										<!--<div class="col-sm-8">-->
										<div class="col-sm-12">
										  <h3><strong>圖片上傳</strong></h3>
										  <span id="add_ic1" class="redmsg" style="color:#f00;font-weight:800;">※圖片建議尺寸：535x535px 或 1:1圖片 535px以下產品詳細頁會模糊</span>
										  <p>請選擇要上傳的商品圖片(第一張圖片將作為主要商品圖片)</p>
										  <div id="mydropzone" class="dropzone">
											<?php foreach($data_row->img_file_list as $key => $row){?>
											<?php if (is_object($row)){?>
											<div class="dz-preview dz-processing dz-image-preview dz-success">
											<div class="dz-details">
											<div class="dz-filename">
											<span data-dz-name=""><?php echo $row->file_name;?></span></div>
											<div class="dz-size" data-dz-size="">
											<strong><?php echo round($row->file_size / 1024 , 2);?></strong> MiB</div>
											<img data-dz-thumbnail="" alt="" src="<?php echo img_show($row->file_name);?>">
											</div>
											<div class="dz-progress">
											<span class="dz-upload" data-dz-uploadprogress="" style="width: 100%;">
											</span></div>
											<div class="dz-success-mark">
											<span>✔</span>
											</div>
											<div class="dz-error-mark">
											<span>✘</span>
											</div>
											<div class="dz-error-message">
											<span data-dz-errormessage="">
											</span>
											</div>
											<a class="dz-remove old-remove" id="old-remove" data-id="<?php echo $row->id;?>" href="#" data-dz-remove="">刪除</a>
											</div>
											<?php }?>
											<?php }?>
										  </div>
										  </div>
										  <!-- DROPZONE IMG UPLOAD ARRAY -->
										  <input type="hidden" name="img_list" id="img_list" value=""/>
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
	<script>
	<?php 
	$tmp_ary = array();
	foreach($data_row->img_file_list as $key => $row)
	{
		if (is_object($row)) array_push($tmp_ary , sprintf('%s_%s_%s' , $row->id , $row->mask , $row->rand));
	}
	?>
	var img_list = <?php echo json_encode($tmp_ary);?>;
	
	<?php /*
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
	*/?>
	
	// $('#color').select2('val' , '<?php $data_row->color;?>');
	$('#color').val(<?php echo json_encode(explode(',',$data_row->color));?>);
	$('#degree').val(<?php echo json_encode(explode(',',$data_row->degree));?>);
	$('#rule_sub_list').val(<?php echo json_encode(explode(',',$data_row->rule_sub));?>);
	$('#shipping_methods').val(<?php echo json_encode(explode(',' , $data_row->shipping_methods));?>);
	
	// dropzone
	$(function() {
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
		
		$('.old-remove').click(function(){
			//取得ID值
			var id = $(this).data('id');
			
			// 移除線上圖片檔案與JS變數
			var delid = 0;
			var delid_bk = 0;
			var delid_t = 0;
			var delid_random = 0;
			
			for(i = 0 ; i < img_list.length ; i++)
			{
				box = img_list[i].split('_');
				
				//使用id值識別
				if (id == box[0])
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
			
			//移除這一個區塊
			$(this).parent('.dz-preview ').hide();
			
			return false;
		});
		
		$('#type_a').change(function(){
			$.post('/control/product/get_type_b_list' , {'type_a' : $(this).val()} , function(response){
				console.log(response);
				if (response.status == 'T')
				{
					$('#type_b').html(response.html);
				}
			} , 'json');
		});
	});
	</script>
</html>
