<div class="modal fade" id="add_panel">
  <div class="modal-dialog">
    <div class="modal-content">
	<form name="add_form" id="add_form" action="/control/<?php echo $zh_path;?>/add_post" method="post" enctype="multipart/form-data">
		<input type="hidden" name="event_id" id="event_id" value="<?php echo $event_id;?>">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><strong>新增<?php echo $zh_name;?></strong></h4>
      </div>
	  
      <div class="modal-body row">
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">名稱</label>
			<div class="col-sm-9">
			<input class="form-control" name="title" id="title" type="text" placeholder="請輸入名稱">
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">Tag</label>
			<div class="col-sm-9">
			<input class="form-control" name="tag" id="tag" type="text" placeholder="請輸入TAG">
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">內容簡介</label>
			<div class="col-sm-9">
			<textarea name="memo" id="memo" class="form-control" placeholder="請輸入簡介內容" rows="5"></textarea>
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">建立日期</label>
			<div class="col-sm-9">
			<input class="form-control" name="create_at" id="create_at" type="text" value="<?php echo date('Y-m-d');?>" placeholder="請輸入建立日期" required>
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">開啟狀態</label>
			<div class="col-sm-9">
				<select name="active" class="form-control">
					<option value="1">開啟</option>
					<option value="0">關閉</option>
				</select>
			</div>
		</div>
		</div>
		<?php /*
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
			<input class="form-control" id="img_alt" name="img_alt" type="text" placeholder="輸入圖片ALT(若有圖片時填入)">
			</div>
		</div>
		</div>
		*/?>
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
		$(function() {
			$('#create_at').datepicker({
				dateFormat: "yy-mm-dd"
			});
		});
		
		$('form#add_form').submit(function(){
		
		var formdata = new FormData($(this)[0]);
		
		$.ajax({
			url:'/control/<?php echo $zh_path;?>/add_post/',
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