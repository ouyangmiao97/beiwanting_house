<div class="modal fade" id="edit_panel">
  <div class="modal-dialog">
    <div class="modal-content">
	<form name="edit_form" id="edit_form" action="/control/website/add_banner" method="post" enctype="multipart/form-data">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><strong>修改Banner</strong></h4>
      </div>
      <div class="modal-body row">
		<input type="hidden" name="id" id="edit_id" />
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">標題</label>
			<div class="col-sm-9">
			<input class="form-control" name="title" id="edit_title" type="text" placeholder="請輸入標題">
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">狀態</label>
			<div class="col-sm-9">
				<select name="active" id="edit_active" class="form-control">
					<option value="1">開啟</option>
					<option value="0">關閉</option>
				</select>
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">分類</label>
			<div class="col-sm-9">
				<select name="type" id="edit_type" class="form-control">
					<?php foreach($words_types as $key => $row){?>
						<option value="<?php echo $key;?>"><?php echo $row['title'];?></option>
					<?php }?>
				</select>
			</div>
		</div>
		</div>
		<?php /*
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">Youtube</label>
			<div class="col-sm-9">
			<input class="form-control" name="youtube" id="edit_youtube" type="text" placeholder="請輸入Youtube影片網址或ID">
			</div>
		</div>
		</div> */?>
		<div class="row">
		<div class="col-md-12">
		<div class="fileinput fileinput-new" data-provides="fileinput">
		  <p><strong>上傳圖片(<span id="edit_ic1" class="redmsg" style="color:#f00;font-weight:800;">※圖片建議尺寸：1920x500 px</span>)</strong></p>
		  <div class="fileinput-new thumbnail">
			<img data-src="" src="/assets/global/images/gallery/3.jpg" id="edit_img" class="img-responsive" alt="gallery 3">
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
		<div class="row">
		<div class="col-md-12">
		<div class="fileinput fileinput-new" data-provides="fileinput">
		  <p><strong>上傳圖片(<span id="edit_ic2" class="redmsg" style="color:#f00;font-weight:800;">※圖片建議尺寸：1200x500 px</span>)</strong></p>
		  <div class="fileinput-new thumbnail">
			<img data-src="" src="/assets/global/images/gallery/3.jpg" id="edit_img2" class="img-responsive" alt="gallery 3">
		  </div>
		  <div class="fileinput-preview fileinput-exists thumbnail"></div>
		  <div>
			<span class="btn btn-default btn-file"><span class="fileinput-new">Select image...</span><span class="fileinput-exists">Change</span>
			<input type="file" name="img_file2">
			</span>
			<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
		  </div>
		</div>
		</div>
		</div>
		<div class="row">
		<div class="col-md-12">
		<div class="fileinput fileinput-new" data-provides="fileinput">
		  <p><strong>上傳圖片(<span id="edit_ic3" class="redmsg" style="color:#f00;font-weight:800;">※圖片建議尺寸：768x768 px</span>)</strong></p>
		  <div class="fileinput-new thumbnail">
			<img data-src="" src="/assets/global/images/gallery/3.jpg" id="edit_img3" class="img-responsive" alt="gallery 3">
		  </div>
		  <div class="fileinput-preview fileinput-exists thumbnail"></div>
		  <div>
			<span class="btn btn-default btn-file"><span class="fileinput-new">Select image...</span><span class="fileinput-exists">Change</span>
			<input type="file" name="img_file3">
			</span>
			<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
		  </div>
		</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">ALT</label>
			<div class="col-sm-9">
			<input class="form-control" name="alt" id="edit_alt" type="text" placeholder="輸入圖片ALT(若有圖片時填入)">
			</div>
		</div>
		</div>
		<?php /*
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">內文</label>
			<div class="col-sm-9">
				<textarea name="words" id="edit_words" class="form-control"></textarea>
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">Description</label>
			<div class="col-sm-9">
				<input class="form-control" name="description" id="edit_description" type="text" placeholder="請輸入Description">
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">Keywords</label>
			<div class="col-sm-9">
				<input class="form-control" name="keywords" id="edit_keywords" type="text" placeholder="請輸入Keywords">
			</div>
		</div>
		</div>
		*/?>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">Url</label>
			<div class="col-sm-9">
				<input class="form-control" name="url" id="edit_url" type="text" placeholder="請輸入連結網址">
			</div>
		</div>
		</div>
		
		
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">建立日期</label>
			<div class="col-sm-9">
			<input class="form-control" name="create_at" id="edit_create_at" type="text" value="<?php echo date('Y-m-d');?>" placeholder="請輸入建立日期" required>
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
		$(function() {
			$('#edit_create_at').datepicker({
				dateFormat: "yy-mm-dd"
			});
		});

	$('#edit_panel').on('show.bs.modal' , function(e){
		var id = e.relatedTarget.parentElement.parentElement.parentElement.children[0].textContent;
		
		$('#edit_id').val(id);
		
		$.ajax({
			url:'/control/banner/get.html',
			type:'post',
			dataType:'json',
			data:{
				'id':id
			},
			success:function(data){
				if (data.status == 'T')
				{
					$('#edit_title').val(data.words.title);
					$('#edit_active').select2('val' , data.words.active);
					$('#edit_type').select2('val' , data.words.type);
					$('#edit_banner_type').select2('val' , data.words.banner_type);
					$('#edit_youtube').val(data.words.youtube);
					$('#edit_create_at').val(data.words.create_at);
					
					$('#edit_img').attr('src' , '/assets/global/images/gallery/3.jpg');
					$('#edit_img2').attr('src' , '/assets/global/images/gallery/3.jpg');
					$('#edit_img3').attr('src' , '/assets/global/images/gallery/3.jpg');
					
					if (data.words.img_id != 0) $('#edit_img').attr('src' , '<?php echo img_show('');?>' + data.words.img_file.file_name);
					if (data.words.imgm_id != 0) $('#edit_img2').attr('src' , '<?php echo img_show('');?>' + data.words.img_file2.file_name);
					if (data.words.imgs_id != 0) $('#edit_img3').attr('src' , '<?php echo img_show('');?>' + data.words.img_file3.file_name);
					
					// if (data.words.img_id == 0)
					// {
						// $('#edit_img').attr('src' , '/assets/global/images/gallery/3.jpg');
						// $('#edit_img2').attr('src' , '/assets/global/images/gallery/3.jpg');
						// $('#edit_img3').attr('src' , '/assets/global/images/gallery/3.jpg');
					// }
					// else
					// {
						// $('#edit_img').attr('src' , '<?php echo img_show('');?>' + data.words.img_file.file_name);
						// $('#edit_img2').attr('src' , '<?php echo img_show('');?>' + data.words.img_file2.file_name);
						// $('#edit_img3').attr('src' , '<?php echo img_show('');?>' + data.words.img_file3.file_name);
					// }
					
					$('#edit_alt').val(data.words.img_file.alt);
					$('#edit_words').val(data.words.words);
					$('#edit_description').val(data.words.description);
					$('#edit_keywords').val(data.words.keywords);
					$('#edit_url').val(data.words.url);
					
					$('#edit_type').change();
					
				}
				else
				{
					alert(data.msg);
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
			url:'/control/banner/edit.html',
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
	$('#edit_type').change(function(){
		if ($(this).val() == 1)
		{
			$('#edit_ic1').html('※圖片建議尺寸：400x150 px');
			$('#edit_ic2').html('※圖片建議尺寸：750x200 px');
			$('#edit_ic3').html('※圖片建議尺寸：768x768 px');
		}
		else
		{
			$('#edit_ic1').html('※圖片建議尺寸：1920x500 px');
			$('#edit_ic2').html('※圖片建議尺寸：1200x500 px');
			$('#edit_ic3').html('※圖片建議尺寸：768x768 px');
		}
		
	});
</script>