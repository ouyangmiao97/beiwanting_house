<div class="modal fade" id="edit_panel">
  <div class="modal-dialog">
    <div class="modal-content">
	<form name="edit_form" id="edit_form" action="/control/website/edit_column" method="post" enctype="multipart/form-data">
	<input type="hidden" name="id" id="edit_id">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><strong>修改區塊</strong></h4>
      </div>
	  
      <div class="modal-body row">
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">區塊名稱</label>
			<div class="col-sm-9">
			<input class="form-control" name="title" id="edit_title" type="text" placeholder="輸入區塊名稱">
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">排序依據</label>
			<div class="col-sm-9">
			<input class="form-control" name="orderno" id="orderno" type="text" placeholder="輸入數字，數字越大排序越前面">
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">類型</label>
			<div class="col-sm-9">
				<select id="edit_type" name="type" class="form-control">
					<option value="1">4商品+n滑動(前四筆列表呈現，其餘資料滑動顯示)</option>
					<option value="2">8商品+1圖片(最多八筆，多餘不會顯示)</option>
					<option value="3">1圖片</option>
				</select>
			</div>
		</div>
		</div>
		<div class="row" id="edit-more-div">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">更多商品連結</label>
			<div class="col-sm-9">
			<input class="form-control" id="edit_more" name="more" type="text" placeholder="輸入更多商品超連結">
			</div>
		</div>
		</div>
		<div class="row" id="edit-img-file-div">
		<div class="col-md-12">
		<div class="fileinput fileinput-new" data-provides="fileinput">
		  <p><strong>上傳圖片</strong></p>
		  <div class="fileinput-new thumbnail">
			<img data-src="" id="img_show" src="/assets/global/images/gallery/3.jpg" class="img-responsive" alt="gallery 3">
		  </div>
		  <div class="fileinput-preview fileinput-exists thumbnail"></div>
		  <div>
			<span class="btn btn-default btn-file"><span class="fileinput-new">Select image...</span><span class="fileinput-exists">Change</span>
			<input type="file" name="img_file">
			</span>
			<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
		  </div>
		</div>
		</div>
		</div>
		<div class="row" id="edit-img-alt-div">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">圖片ALT</label>
			<div class="col-sm-9">
			<input class="form-control" id="edit_img_alt" name="img_alt" type="text" placeholder="輸入圖片ALT">
			</div>
		</div>
		</div>
		<div class="row" id="edit-img-url-div">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">圖片URL</label>
			<div class="col-sm-9">
			<input class="form-control" id="edit_img_url" name="img_url" type="text" placeholder="輸入圖片超連結">
			</div>
		</div>
		</div>
		<div class="row" id="edit-pro-list-div">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">商品列表</label>
			<div class="col-sm-9">
			<textarea id="edit_pro_list" name="pro_list" class="form-control" rows="10" placeholder="請輸入產品編號，請使用換行分隔不同編號"></textarea>
			</div>
		</div>
		</div>
			
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="submit" id="edit_submit" class="btn btn-primary">修改</button>
      </div>
	  </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
		$('#edit-pro-list-div').show();
		$('#edit-more-div').hide();
		$('#edit-img-file-div').hide();
		$('#edit-img-url-div').hide();
		$('#edit-img-alt-div').hide();
		
		$('#edit_type').change(function (){
			var type = $(this).val();
			if (type == '1')
			{
				$('#edit-pro-list-div').show();
				
				$('#edit-more-div').hide();
				$('#edit-img-file-div').hide();
				$('#edit-img-url-div').hide();
				$('#edit-img-alt-div').hide();
			}
			if (type == '2')
			{
				$('#edit-pro-list-div').show();
				$('#edit-more-div').show();
				$('#edit-img-file-div').show();
				$('#edit-img-url-div').show();
				$('#edit-img-alt-div').show();
			}
			if (type == '3')
			{
				$('#edit-pro-list-div').hide();
				$('#edit-more-div').show();
				$('#edit-img-file-div').show();
				$('#edit-img-url-div').show();
				$('#edit-img-alt-div').show();
			}
		});
		
		$('#edit_panel').on('show.bs.modal' , function(e){
			var id = e.relatedTarget.parentElement.parentElement.parentElement.children[0].textContent;
			
			$('#edit_id').val(id);
			
			$.ajax({
				url:'/control/website/edit_column_get_data',
				type:'post',
				dataType:'json',
				data:{
					'id':id
				},
				success:function(data){
					if (data.id != 'underfined')
					{
						if (data.type == '1')
						{
							$('#edit-pro-list-div').show();
							$('#edit-more-div').hide();
							$('#edit-img-file-div').hide();
							$('#edit-img-url-div').hide();
							$('#edit-img-alt-div').hide();
							
							$('#edit_id').val(data.id);
							$('#edit_title').val(data.title);
							$('#orderno').val(data.orderno);
							$('#edit_more').val('');
							$('#edit_pro_list').val(data.pro_list);
							$('#edit_img_alt').val('');
							$('#edit_img_url').val('');
							$('#img_show').attr('src' , '/assets/global/images/gallery/3.jpg');
							
							$('#edit_type').val(data.type);
							$('#edit_type').select2('val' , data.type);
						}
						if (data.type == '2')
						{
							$('#edit-pro-list-div').show();
							$('#edit-more-div').show();
							$('#edit-img-file-div').show();
							$('#edit-img-url-div').show();
							$('#edit-img-alt-div').show();
							
							$('#edit_id').val(data.id);
							$('#edit_title').val(data.title);
							$('#orderno').val(data.orderno);
							$('#edit_more').val(data.more);
							$('#edit_pro_list').val(data.pro_list);
							$('#edit_img_alt').val(data.img_alt);
							$('#edit_img_url').val(data.img_url);
							$('#img_show').attr('src' , '/uploads/images/' + data.file_name);
							$('#edit_type').select2('val' , data.type);
							
							$('#edit_type').val(data.type);
						}
						if (data.type == '3')
						{
							$('#edit-pro-list-div').hide();
							$('#edit-more-div').show();
							$('#edit-img-file-div').show();
							$('#edit-img-url-div').show();
							$('#edit-img-alt-div').show();
							
							$('#edit_id').val(data.id);
							$('#edit_title').val(data.title);
							$('#orderno').val(data.orderno);
							$('#edit_more').val(data.more);
							$('#edit_pro_list').val('');
							$('#edit_img_alt').val(data.img_alt);
							$('#edit_img_url').val(data.img_url);
							$('#img_show').attr('src' , '/uploads/images/' + data.file_name);
							
							$('#edit_type').val(data.type);
							$('#edit_type').select2('val' , data.type);
						}
						
						
					}
				},
				error:function(e)
				{
					console.log(e);
					//alert('unknow error!');
					return false;
				}
			});
			
		});

		$('form#edit_form').submit(function(){
		
		var formdata = new FormData($(this)[0]);
		
		$.ajax({
			url:'/control/website/edit_column/',
			type:'post',
			dataType:'json',
			data:formdata,
			async:false,
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
			},
			cache:false,
			contentType:false,
			processData:false
		});
		return false;
	});
</script>