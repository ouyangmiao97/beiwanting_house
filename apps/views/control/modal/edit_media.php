<div class="modal fade" id="edit_panel">
  <div class="modal-dialog">
    <div class="modal-content">
	<form name="edit_form" id="edit_form" action="/control/learn/edit_media" method="post" enctype="multipart/form-data">
	<input type="hidden" name="id" id="edit_id">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><strong>修改內容</strong></h4>
      </div>
	  
      <div class="modal-body row">
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">內容名稱</label>
			<div class="col-sm-9">
			<input class="form-control" name="title" id="edit_title" type="text" placeholder="輸入內容名稱">
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">類型</label>
			<div class="col-sm-9">
				<select id="edit_type" name="type" class="form-control">
				<?php if (isset($main_list) && is_array($main_list)){?>
				<?php foreach($main_list as $key => $row){?>
					<option value="<?php echo $row->id;?>"><?php echo $row->title;?></option>
				<?php }}?>
				</select>
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">開啟狀態</label>
			<div class="col-sm-9">
				<select id="edit_active" name="active" class="form-control">
					<option value="0">關閉</option>
					<option value="1">開啟</option>
				</select>
			</div>
		</div>
		</div>
		<div class="row" id="more-div">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">Youtube網址</label>
			<div class="col-sm-9">
			<input class="form-control" id="edit_youtube" name="youtube" type="text" placeholder="輸入Youtube影片網址">
			</div>
		</div>
		</div>
		<div class="row" id="img-file-div">
		<div class="col-md-12">
		<div class="fileinput fileinput-new" data-provides="fileinput">
		  <p><strong>上傳圖片</strong></p>
		  <div class="fileinput-new thumbnail">
			<img id="img_show" data-src="" src="/assets/global/images/gallery/3.jpg" class="img-responsive" alt="gallery 3">
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
			<input class="form-control" id="edit_img_alt" name="img_alt" type="text" placeholder="輸入圖片ALT">
			</div>
		</div>
		</div>
		<div class="row" id="pro-list-div">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">文字說明</label>
			<div class="col-sm-9">
			<textarea id="edit_text" name="text" class="form-control" rows="10" placeholder="請輸入文字說明"></textarea>
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">Description</label>
			<div class="col-sm-9">
			<input class="form-control" name="description" id="edit_description" type="text" placeholder="例如：鑽石彩鑽的專家，來自礦區直營，各式稀有鑽石彩鑽和彩色寶石，專屬設計師提供訂製鑽石手鍊，鑽石耳環，鑽石項鍊，鑽石戒指及其他彩寶客製化服務。擁有全世界最稀有的各式鑽石彩鑽收藏，也與全世界各地的鑽石寶石鑑定中心緊密合作，提供專業的珠寶需求。">
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">Keywords</label>
			<div class="col-sm-9">
			<input class="form-control" name="keywords" id="edit_keywords" type="text" placeholder="例如：彩鑽,鑽石,翡翠,寶石,GIA,鑽戒,侏羅紀寶石,侏羅紀彩色鑽石,結婚鑽戒,婚戒,天然寶石">
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
		url:'/control/learn/edit_media_get_data',
		type:'post',
		dataType:'json',
		data:{
			'id':id
		},
		success:function(data){
			if (data.id != 'underfined')
			{
				console.log(data);
				
				
				$('#edit_title').val(data.title);
				$('#edit_type').select2('val' , data.tid);
				$('#edit_active').select2('val' , data.active);
				$('#edit_youtube').val(data.youtube);
				
				if (data.img_id == 0)
				{
					$('#img_show').attr('src' , '/assets/global/images/gallery/3.jpg');
				}
				else
				{
					$('#img_show').attr('src' , data.file_name);
				}
				
				$('#edit_img_alt').val(data.img_alt);
				$('#edit_text').val(data.text);
				$('#edit_description').val(data.description);
				$('#edit_keywords').val(data.keywords);
				
			}
		},
		error:function(e)
		{
			console.log(e);
			return false;
		}
	});
});

$('form#edit_form').submit(function(){

var formdata = new FormData($(this)[0]);

$.ajax({
	url:'/control/learn/edit_media/',
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