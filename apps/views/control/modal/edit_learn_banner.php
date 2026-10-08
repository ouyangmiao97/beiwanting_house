<div class="modal fade" id="edit_panel">
  <div class="modal-dialog">
    <div class="modal-content">
	<form name="edit_form" id="edit_form" action="/control/website/add_banner" method="post" enctype="multipart/form-data">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><strong>修改Banner</strong></h4>
      </div>
      <div class="modal-body row">
		<input type="hidden" name="edit_id" id="edit_id" />
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">Banner名稱</label>
			<div class="col-sm-9">
			<input class="form-control" name="edit_title" id="edit_title" type="text" placeholder="輸入Banner名稱">
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">youtube網址</label>
			<div class="col-sm-9">
			<input class="form-control" id="edit_youtube" name="edit_youtube" type="text" placeholder="輸入影片ID或者完整網址">
			</div>
		</div>
		</div>
		<div class="row">
		<div class="col-md-12">
		<div class="fileinput fileinput-new" data-provides="fileinput">
		  <p><strong>上傳圖片</strong></p>
		  <div class="fileinput-new thumbnail">
			<img data-src="" id="edit_img" src="/assets/global/images/gallery/3.jpg" class="img-responsive" alt="gallery 3">
		  </div>
		  <div class="fileinput-preview fileinput-exists thumbnail"></div>
		  <div>
			<span class="btn btn-default btn-file"><span class="fileinput-new">Select image...</span><span class="fileinput-exists">Change</span>
			<input type="file" name="edit_banner_file">
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
			<input class="form-control" id="edit_alt" name="edit_alt" type="text" placeholder="輸入圖片ALT">
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
	$('#edit_panel').on('show.bs.modal' , function(e){
		var id = e.relatedTarget.parentElement.parentElement.parentElement.children[0].textContent;
		
		$('#edit_id').val(id);
		
		$.ajax({
			url:'/control/learn/edit_banner_get_data',
			type:'post',
			dataType:'json',
			data:{
				'id':id
			},
			success:function(data){
				// console.log(id);
				// console.log(data);
				$('#edit_title').val(data.title);
				if (data.img != '' && data.youtube == '')
				{
					$('#edit_img').attr('src' , data.img);
				}
				$('#edit_alt').val(data.alt);
				$('#edit_youtube').val(data.youtube);

			},
			error:function(e)
			{
				// console.log(e);
				//alert('unknow error!');
				return false;
			}
		});
		
	});
		$('form#edit_form').submit(function(){
		
		var formdata = new FormData($(this)[0]);
		
		$.ajax({
			url:'/control/learn/edit_banner/',
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