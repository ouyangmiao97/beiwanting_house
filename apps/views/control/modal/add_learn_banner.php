<div class="modal fade" id="add_panel">
  <div class="modal-dialog">
    <div class="modal-content">
	<form name="add_form" id="add_form" action="/control/website/add_banner" method="post" enctype="multipart/form-data">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><strong>新增Banner</strong></h4>
      </div>
	  
      <div class="modal-body row">
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">Banner名稱</label>
			<div class="col-sm-9">
			<input class="form-control" name="title" id="title" type="text" placeholder="輸入Banner名稱">
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">youtube網址</label>
			<div class="col-sm-9">
			<input class="form-control" id="youtube" name="youtube" type="text" placeholder="輸入影片ID或者完整網址(與圖片擇一填寫)">
			</div>
		</div>
		</div>
		<div class="row">
		<div class="col-md-12">
		<div class="fileinput fileinput-new" data-provides="fileinput">
		  <p><strong>上傳圖片</strong></p>
		  <div class="fileinput-new thumbnail">
			<img data-src="" src="/assets/global/images/gallery/3.jpg" class="img-responsive" alt="gallery 3">
		  </div>
		  <div class="fileinput-preview fileinput-exists thumbnail"></div>
		  <div>
			<span class="btn btn-default btn-file"><span class="fileinput-new">Select image...</span><span class="fileinput-exists">Change</span>
			<input type="file" name="banner_file">
			</span>
			<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
		  </div>
		</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">圖片ALT</label>
			<div class="col-sm-9">
			<input class="form-control" id="alt" name="alt" type="text" placeholder="輸入圖片ALT(若有圖片時填入)">
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
		$('form#add_form').submit(function(){
		
		var formdata = new FormData($(this)[0]);
		
		$.ajax({
			url:'/control/learn/add_banner/',
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