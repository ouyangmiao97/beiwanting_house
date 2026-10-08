<div class="modal fade" id="add_panel">
  <div class="modal-dialog">
    <div class="modal-content">
	<form name="add_form" id="add_form" action="/control/learn/add_media" method="post" enctype="multipart/form-data">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><strong>新增內容</strong></h4>
      </div>
	  
      <div class="modal-body row">
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">內容名稱</label>
			<div class="col-sm-9">
			<input class="form-control" name="title" id="title" type="text" placeholder="輸入內容名稱">
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">類型</label>
			<div class="col-sm-9">
				<select id="type" name="type" class="form-control">
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
				<select id="active" name="active" class="form-control">
					<option value="0">關閉</option>
					<option value="1" selected>開啟</option>
				</select>
			</div>
		</div>
		</div>
		<div class="row" id="more-div">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">Youtube網址</label>
			<div class="col-sm-9">
			<input class="form-control" id="youtube" name="youtube" type="text" placeholder="輸入影片ID或者完整網址(與圖片擇一填寫)">
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
			<input class="form-control" id="img_alt" name="img_alt" type="text" placeholder="輸入圖片ALT(若有圖片時填入)">
			</div>
		</div>
		</div>
		<div class="row" id="pro-list-div">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">文字說明</label>
			<div class="col-sm-9">
			<textarea id="text" name="text" class="form-control" rows="10" placeholder="請輸入文字說明"></textarea>
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">Description</label>
			<div class="col-sm-9">
			<input class="form-control" name="description" id="description" type="text" placeholder="例如：鑽石彩鑽的專家，來自礦區直營，各式稀有鑽石彩鑽和彩色寶石，專屬設計師提供訂製鑽石手鍊，鑽石耳環，鑽石項鍊，鑽石戒指及其他彩寶客製化服務。擁有全世界最稀有的各式鑽石彩鑽收藏，也與全世界各地的鑽石寶石鑑定中心緊密合作，提供專業的珠寶需求。">
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">Keywords</label>
			<div class="col-sm-9">
			<input class="form-control" name="keywords" id="keywords" type="text" placeholder="例如：彩鑽,鑽石,翡翠,寶石,GIA,鑽戒,侏羅紀寶石,侏羅紀彩色鑽石,結婚鑽戒,婚戒,天然寶石">
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
			url:'/control/learn/add_media/',
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