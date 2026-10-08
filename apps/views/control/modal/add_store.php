<div class="modal fade" id="add_panel">
  <div class="modal-dialog">
    <div class="modal-content">
	<form name="add_form" id="add_form" action="/control/words/add.html" method="post" enctype="multipart/form-data">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><strong>新增資料</strong></h4>
      </div>
	  
      <div class="modal-body row">
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">標題</label>
			<div class="col-sm-9">
			<input class="form-control" name="title" id="title" type="text" placeholder="請輸入標題">
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">狀態</label>
			<div class="col-sm-9">
				<select name="active" class="form-control">
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
				<input class="form-control" name="address" id="address" type="text" placeholder="請輸入店鋪地址">
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">電話</label>
			<div class="col-sm-9">
				<input class="form-control" name="phone" id="phone" type="text" placeholder="請輸入店鋪電話">
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">所屬縣市</label>
			<div class="col-sm-9">
				<select name="cid" id="city" class="form-control">
					<option>選擇縣 / 市</option>
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
				<select name="did" id="district" class="form-control">
				  <option selected="">選擇區域</option>
				</select>
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">GoogleMap嵌入程式碼</label>
			<div class="col-sm-9">
				<textarea name="map_data" class="form-control"></textarea>
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

		$(function() {
			$('#create_at').datepicker({
				dateFormat: "yy-mm-dd"
			});
		});
	
		$('form#add_form').submit(function(){

		var formdata = new FormData($(this)[0]);
		
		$.ajax({
			url:'/control/store/add.html',
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
	$('#city').change(function(){
		var cid = $('#city').val();
		console.log(cid);
		$.post('/api/get_district.html' , {'cid':cid} , function(response){
			$('#district').html(response.html);
		} , 'json');
	});
	</script>