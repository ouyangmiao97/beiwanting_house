<div class="modal fade" id="add_panel">
  <div class="modal-dialog">
    <div class="modal-content">
	<form name="add_form" id="add_form" action="/control/website/add_column" method="post" enctype="multipart/form-data">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><strong>新增區塊</strong></h4>
      </div>
	  
      <div class="modal-body row">
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">區塊名稱</label>
			<div class="col-sm-9">
			<input class="form-control" name="title" id="title" type="text" placeholder="輸入區塊名稱">
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
				<select id="type" name="type" class="form-control">
					<option value="1">4商品+n滑動(前四筆列表呈現，其餘資料滑動顯示)</option>
					<option value="2">8商品+1圖片(最多八筆，多餘不會顯示)</option>
					<option value="3">1圖片</option>
				</select>
			</div>
		</div>
		</div>
		<div class="row" id="more-div">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">更多商品連結</label>
			<div class="col-sm-9">
			<input class="form-control" id="more" name="more" type="text" placeholder="輸入更多商品超連結">
			</div>
		</div>
		</div>
		<div class="row" id="img-file-div">
		<div class="col-md-12">
		<div class="fileinput fileinput-new" data-provides="fileinput">
		  <p><strong>上傳圖片</strong></p>
		  <div class="fileinput-new thumbnail">
			<img data-src="" src="/assets/global/images/gallery/3.jpg" class="img-responsive" alt="gallery 3">
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
		<div class="row" id="img-alt-div">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">圖片ALT</label>
			<div class="col-sm-9">
			<input class="form-control" id="img_alt" name="img_alt" type="text" placeholder="輸入圖片ALT">
			</div>
		</div>
		</div>
		<div class="row" id="img-url-div">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">圖片URL</label>
			<div class="col-sm-9">
			<input class="form-control" id="img_url" name="img_url" type="text" placeholder="輸入圖片超連結">
			</div>
		</div>
		</div>
		<div class="row" id="pro-list-div">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">商品列表</label>
			<div class="col-sm-9">
			<textarea id="pro_list" name="pro_list" class="form-control" rows="10" placeholder="請輸入產品編號，請使用換行分隔不同編號"></textarea>
			</div>
		</div>
		</div>
			
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="submit" id="add_submit" class="btn btn-primary">新增</button>
      </div>
	  </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
		$('#pro-list-div').show();
		$('#more-div').hide();
		$('#img-file-div').hide();
		$('#img-url-div').hide();
		$('#img-alt-div').hide();
		
		$('#type').change(function (){
			var type = $(this).val();
			if (type == '1')
			{
				$('#pro-list-div').show();
				
				$('#more-div').hide();
				$('#img-file-div').hide();
				$('#img-url-div').hide();
				$('#img-alt-div').hide();
			}
			if (type == '2')
			{
				$('#pro-list-div').show();
				$('#more-div').show();
				$('#img-file-div').show();
				$('#img-url-div').show();
				$('#img-alt-div').show();
			}
			if (type == '3')
			{
				$('#pro-list-div').hide();
				$('#more-div').show();
				$('#img-file-div').show();
				$('#img-url-div').show();
				$('#img-alt-div').show();
			}
		});

		$('form#add_form').submit(function(){
		
		var formdata = new FormData($(this)[0]);
		
		$.ajax({
			url:'/control/website/add_column/',
			type:'post',
			dataType:'json',
			data:formdata,
			async:false,
			success:function(data){
				if (data.status='T')
				{
					alert(data.msg);
					location.reload();
					// window.location.href="/control/download";
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