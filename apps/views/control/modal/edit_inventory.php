<div class="modal fade" id="edit_panel">
  <div class="modal-dialog">
    <div class="modal-content">
	<form name="edit_form" id="edit_form" action="/control/inventory/edit_inventory" method="post" enctype="multipart/form-data">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><strong>修改庫存</strong></h4>
      </div>
	  
      <div class="modal-body row">
		<input type="hidden" name="id" id="edit_id" value="" />
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">商品ID</label>
			<div class="col-sm-9">
			<input class="form-control" name="pid" id="edit_pid" value="" type="text" placeholder="" readonly>
			</div>
		</div>
		</div>
		<?php /*
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">顏色</label>
			<div class="col-sm-9">
				<select name="color" id="edit_color" class="form-control">
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
				<select name="degree" id="edit_degree" class="form-control">
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
			<input class="form-control" name="num" id="edit_num" type="number" placeholder="請輸入庫存數量" required>
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
		
		$.post('/control/inventory/get_inventory' , {'id':id} , function(response){
			
			if (response.status == 'T')
			{
				console.log(response);
				$('#edit_id').val(response.data.id);
				// $('#edit_pid').val(response.data.pid);
				// $('#edit_color').select2('val' , response.data.color);
				// $('#edit_degree').select2('val' , response.data.degree);
				$('#edit_num').val(response.data.inventory);
			}
			else
			{
				alert('載入資料發生錯誤');
			}
			
		},'json').fail(function(){
			alert('載入資料失敗');
		});
	});
	
	$('#edit_submit').click(function(){
		var id = $('#edit_id').val();
		var pid = $('#edit_pid').val();
		// var color = $('#edit_color').val();
		// var degree = $('#edit_degree').val();
		var num = $('#edit_num').val();

		$.post('/control/inventory/edit_inventory' , 
			{
				'id':id,
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
			).fail(function() {
				alert("傳送失敗");
			});
		
		return false;
	});
	</script>