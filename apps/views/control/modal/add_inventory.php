<div class="modal fade" id="add_panel">
  <div class="modal-dialog">
    <div class="modal-content">
	<form name="add_form" id="add_form" action="/control/inventory/add_inventory" method="post" enctype="multipart/form-data">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><strong>新增庫存</strong></h4>
      </div>
	  
      <div class="modal-body row">
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">商品ID</label>
			<div class="col-sm-9">
			<input class="form-control" name="pid" id="pid" value="<?php echo $pid;?>" type="text" placeholder="" readonly>
			</div>
		</div>
		</div>
		<?php /*
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">顏色</label>
			<div class="col-sm-9">
				<select name="color" id="color" class="form-control">
					<?php foreach($color_list as $key => $row){?>
					<option value="<?php echo $row->title;?>"><?php echo $row->title;?></option>
					<?php }?>
				</select>
			</div>
		</div>
		</div>
		
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">度數</label>
			<div class="col-sm-9">
				<select name="degree" id="degree" class="form-control">
					<?php foreach($degree_list as $key => $row){?>
					<option value="<?php echo $row->title;?>"><?php echo $row->title;?></option>
					<?php }?>
				</select>
			</div>
		</div>
		</div>
		*/?>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">數量</label>
			<div class="col-sm-9">
			<input class="form-control" name="num" id="num" type="number" placeholder="請輸入庫存數量" required>
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
	$('#add_submit').click(function(){
		var pid = $('#pid').val();
		// var color = $('#color').val();
		// var degree = $('#degree').val();
		var num = $('#num').val();

		$.post('/control/inventory/add_inventory' , 
			{
				'pid':pid,
				// 'color':color,
				// 'degree':degree,
				'num':num
			},
			function(response){
				alert(response.msg);
				location.reload();
			},
			'json'
			).fail(function(err) {
				console.log(err);
				alert("傳送失敗");
			});
		
		return false;
	});
	</script>