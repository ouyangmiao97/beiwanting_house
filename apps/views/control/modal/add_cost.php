<div class="modal fade" id="add_panel">
  <div class="modal-dialog">
    <div class="modal-content">
	<form name="add_form" id="add_form" action="/control/cost/add_cost.html" method="post" enctype="multipart/form-data">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><strong>新增收入/支出</strong></h4>
      </div>
	  
      <div class="modal-body row">
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">類型</label>
			<div class="col-sm-9">
				<select name="type" id="type" class="form-control">
					<?php foreach($cost_item_type_list as $key => $val){?>
					<option value="<?php echo $key;?>"><?php echo $val;?></option>
					<?php }?>
				</select>
			</div>
		</div>
		</div>
		
		<div class="row" id="item_out">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">支出項目</label>
			<div class="col-sm-9">
				<select name="item_out" class="form-control">
					<?php foreach($cost_item_ary as $key => $row){?>
					<?php if ($row->type==0){?>
					<option value="<?php echo $key;?>"><?php echo $row->title;?></option>
					<?php }}?>
				</select>
			</div>
		</div>
		</div>

		
		<div class="row" id="item_in" style="display:none;">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">收入項目</label>
			<div class="col-sm-9">
				<select name="item_in" class="form-control">
					<?php foreach($cost_item_ary as $key => $row){?>
					<?php if ($row->type==1){?>
					<option value="<?php echo $key;?>"><?php echo $row->title;?></option>
					<?php }}?>
				</select>
			</div>
		</div>
		</div>
		
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">帳務日期</label>
			<div class="col-sm-9">
			<input class="form-control" name="create_at" id="create_at" type="text" value="<?php echo date('Y-m-d');?>" placeholder="請輸入帳務日期" required>
			</div>
		</div>
		</div>
		
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">金額</label>
			<div class="col-sm-9">
			<input class="form-control" name="cost" id="cost" type="number" placeholder="請輸入金額" required>
			</div>
		</div>
		</div>
		
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">備註</label>
			<div class="col-sm-9">
			<input class="form-control" name="memo" id="memo" type="number" placeholder="請輸入備註">
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
	
		$('#type').change(function(){
			if ($(this).val() == 0)
			{
				$('#item_in').hide();
				$('#item_out').show();
			}
			
			if ($(this).val() == 1)
			{
				$('#item_in').show();
				$('#item_out').hide();
			}
		});
	
		$('form#add_form').submit(function(){

		var formdata = new FormData($(this)[0]);
		
		$.ajax({
			url:'/control/cost/add_cost.html',
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