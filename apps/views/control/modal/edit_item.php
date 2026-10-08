<div class="modal fade" id="edit_panel">
  <div class="modal-dialog">
    <div class="modal-content">
	<form name="edit_form" id="edit_form" action="/control/item/edit_item" method="post" enctype="multipart/form-data">
	<input type="hidden" name="id" id="edit_id" value="">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><strong>修改項目</strong></h4>
      </div>
	  
      <div class="modal-body row">
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">項目名稱</label>
			<div class="col-sm-9">
			<input class="form-control" name="title" id="edit_title" type="text" placeholder="請輸入項目名稱">
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">項目類型</label>
			<div class="col-sm-9">
				<select name="type" id="edit_type" class="form-control">
					<?php foreach($type_list as $key => $val){?>
					<option value="<?php echo $key;?>"><?php echo $val;?></option>
					<?php }?>
				</select>
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">開啟狀態</label>
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
			<label class="col-sm-3 control-label">色碼</label>
			<div class="col-sm-9">
			<input class="form-control" name="color" id="edit_color" type="text" placeholder="請輸入色碼，例如：#fffafa">
			</div>
		</div>
		</div>
		<div class="row" id="img-file-div">
		<div class="col-md-12">
		<div class="fileinput fileinput-new" data-provides="fileinput">
		  <p><strong>上傳圖片</strong></p>
		  <div class="fileinput-new thumbnail">
			<img data-src="" src="/assets/global/images/gallery/3.jpg" id="img_pic" class="img-responsive" alt="gallery 3">
		  </div>
		  <div class="fileinput-preview fileinput-exists thumbnail"></div>
		  <div>
			<span class="btn btn-default btn-file"><span class="fileinput-new">Select image...</span><span class="fileinput-exists">Change</span>
			<input type="file" name="img_file">
			</span>
			<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
			<a href="#" class="btn btn-default" id="removeimg">刪除圖片</a>
			<input type="hidden" name="removeimg" id="removeimghidden" value="0"/>
		  </div>
		</div>
		</div>
		</div>
		<div class="row" id="img-alt-div">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">圖片ALT</label>
			<div class="col-sm-9">
			<input class="form-control" id="edit_img_alt" name="img_alt" type="text" placeholder="輸入圖片ALT(若有圖片時填入)">
			</div>
		</div>
		</div>
			
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="submit" id="add_submit" class="btn btn-primary">修改</button>
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
			url:'/control/item/get_item',
			type:'post',
			dataType:'json',
			data:{
				'id':id
			},
			success:function(data){
				if (data.status == 'T')
				{
					$('#edit_title').val(data.item.title);
					$('#edit_type').select2('val' , data.item.type);
					$('#edit_active').select2('val' , data.item.active);
					$('#edit_color').val(data.item.color);
					
					if (typeof data.item.img_file != 'undefined')
					{
						$('#img_pic').attr('src' , '/uploads/images/' + data.item.img_file.file_name);
						$('#edit_img_alt').val(data.item.img_file.alt);
						$('#removeimg').show();
					}
					else
					{
						$('#img_pic').attr('src' , '/assets/global/images/gallery/3.jpg');
						$('#edit_img_alt').val('');
						$('#removeimg').hide();
					}
					
					$('#removeimghidden').val(0);
					
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
			url:'/control/item/edit_item/',
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
	
	$('#removeimg').click(function(){
		$('#img_pic').attr('src' , '/assets/global/images/gallery/3.jpg');
		$('#removeimghidden').val(1);
		$('#removeimg').hide();
		return false;
	});
</script>