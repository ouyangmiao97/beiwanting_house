<div class="modal fade" id="edit_panel">
  <div class="modal-dialog">
    <div class="modal-content">
	<form name="edit_form" id="edit_form" action="/control/website/add_banner" method="post" enctype="multipart/form-data">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><strong>修改資料</strong></h4>
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
			<label class="col-sm-3 control-label">地址</label>
			<div class="col-sm-9">
				<input class="form-control" name="address" id="edit_address" type="text" placeholder="請輸入店鋪地址">
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">電話</label>
			<div class="col-sm-9">
				<input class="form-control" name="phone" id="edit_phone" type="text" placeholder="請輸入店鋪電話">
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">所屬縣市</label>
			<div class="col-sm-9">
				<select name="cid" id="edit_city" class="form-control">
					<option value="0">選擇縣 / 市</option>
					<?php if (isset($city_list) && $city_list != FALSE){?>
					<?php foreach($city_list as $key => $row){?>
					<option value="<?php echo $row->id;?>"><?php echo $row->title;?></option>
					<?php }?>
					<?php }?>
				</select>
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">所屬區域</label>
			<div class="col-sm-9">
				<select name="did" id="edit_district" class="form-control">
				  <option selected="">選擇區域</option>
				</select>
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">GoogleMap嵌入程式碼</label>
			<div class="col-sm-9">
				<textarea name="map_data" id="edit_map_data" class="form-control"></textarea>
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
			url:'/control/store/get.html',
			type:'post',
			dataType:'json',
			data:{
				'id':id
			},
			success:function(data){
				if (data.status == 'T')
				{
					// console.log(data);
					
					$('#edit_title').val(data.words.title);
					$('#edit_address').val(data.words.address);
					$('#edit_phone').val(data.words.phone);
					$('#edit_map_data').val(data.words.map_data);
					$('#edit_active').select2('val' , data.words.active);
					$('#edit_city').select2('val' , data.words.cid);
					$('#edit_district').html(data.html);
					$('#edit_district').select2('val' , data.words.did);
					
				}
				else
				{
					alert(data.msg);
				}
			},
			error:function(e)
			{
				// console.log(e);
				return false;
			}
		});
		
	});
		$('form#edit_form').submit(function(){

		var formdata = new FormData($(this)[0]);
		
		$.ajax({
			url:'/control/store/edit.html',
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
				// console.log(e);
				alert('unknow error!');
				return false;
			},
			cache:false,
			contentType:false,
			processData:false
		});
		return false;
	});
	$('#edit_city').change(function(){
		var cid = $('#edit_city').val();
		$.post('/api/get_district.html' , {'cid':cid} , function(response){
			$('#edit_district').html(response.html);
		} , 'json');
	});
</script>