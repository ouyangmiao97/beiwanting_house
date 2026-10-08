<div class="modal fade" id="edit_panel">
  <div class="modal-dialog">
    <div class="modal-content">
	<form name="edit_form" id="edit_form" action="/control/website/add_banner" method="post" enctype="multipart/form-data">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><strong>修改收入/支出</strong></h4>
      </div>
      <div class="modal-body row">
		<input type="hidden" name="id" id="edit_id" />
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">類型</label>
			<div class="col-sm-9">
				<select name="type" id="edit_type" class="form-control">
					<?php foreach($cost_item_type_list as $key => $val){?>
					<option value="<?php echo $key;?>"><?php echo $val;?></option>
					<?php }?>
				</select>
			</div>
		</div>
		</div>
		
		<div class="row" id="edit_item_out_div">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">支出項目</label>
			<div class="col-sm-9">
				<select name="item_out" id="edit_item_out" class="form-control">
					<?php foreach($cost_item_ary as $key => $row){?>
					<?php if ($row->type==0){?>
					<option value="<?php echo $key;?>"><?php echo $row->title;?></option>
					<?php }}?>
				</select>
			</div>
		</div>
		</div>
		
		<div class="row" id="edit_item_in_div" style="display:none;">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">收入項目</label>
			<div class="col-sm-9">
				<select name="item_in" id="edit_item_in" class="form-control">
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
			<input class="form-control" name="create_at" id="edit_create_at" type="text" value="" placeholder="請輸入帳務日期" required>
			</div>
		</div>
		</div>
		
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">金額</label>
			<div class="col-sm-9">
			<input class="form-control" name="cost" id="edit_cost" type="text" placeholder="請輸入金額" required>
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">備註</label>
			<div class="col-sm-9">
			<input class="form-control" name="memo" id="edit_memo" type="text" placeholder="請輸入備註">
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

		$('#edit_type').change(function(){
			if ($(this).val() == 0)
			{
				$('#edit_item_in_div').hide();
				$('#edit_item_out_div').show();
			}
			
			if ($(this).val() == 1)
			{
				$('#edit_item_in_div').show();
				$('#edit_item_out_div').hide();
			}
		});

	$('#edit_panel').on('show.bs.modal' , function(e){
		var id = e.relatedTarget.parentElement.parentElement.parentElement.children[0].textContent;
		
		$('#edit_id').val(id);
		
		$.ajax({
			url:'/control/cost/get_cost.html',
			type:'post',
			dataType:'json',
			data:{
				'id':id
			},
			success:function(data){
				if (data.status == 'T')
				{
					$('#edit_type').select2('val' , data.cost.type);
					$('#edit_memo').val(data.cost.memo);
					$('#edit_create_at').val(data.cost.create_at);
					
					if (data.cost.type == 0)
					{
						$('#edit_item_out').select2('val' , data.cost.item);
						$('#edit_item_in_div').hide();
						$('#edit_item_out_div').show();
					}
					if (data.cost.type == 1)
					{
						$('#edit_item_in').select2('val' , data.cost.item);
						$('#edit_item_in_div').show();
						$('#edit_item_out_div').hide();
					}
					
					$('#edit_cost').val(data.cost.cost);
					// $('#edit_type').select2('val' , data.item.type);
					
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
			url:'/control/cost/edit_cost.html',
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