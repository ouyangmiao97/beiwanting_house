<div class="modal fade" id="edit_panel">
  <div class="modal-dialog">
    <div class="modal-content">
	<form name="edit_form" id="edit_form" action="/control/cost/get_commission.html" method="post" enctype="multipart/form-data">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><strong>修改委員</strong></h4>
      </div>
      <div class="modal-body row">
		<input type="hidden" name="id" id="edit_id" />
		
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">委員名稱</label>
			<div class="col-sm-9">
			<input class="form-control" name="name" id="edit_name" type="text" placeholder="請輸入委員名稱" required>
			</div>
		</div>
		</div>
		
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">下次繳費期限</label>
			<div class="col-sm-9">
			<input class="form-control" name="next_pay" id="edit_next_pay" type="text" placeholder="請輸入下次繳費期限" required>
			</div>
		</div>
		</div>
		
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">繳費費用</label>
			<div class="col-sm-9">
			<input class="form-control" name="cost" id="edit_cost" type="number" placeholder="請輸入繳費費用" required>
			</div>
		</div>
		</div>
		
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">繳費間距(天數)</label>
			<div class="col-sm-9">
			<input class="form-control" name="pay_range" id="edit_pay_range" type="number" placeholder="如果天數為一年請輸入0或保留空值">
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
			$('#edit_next_pay').datepicker({
				dateFormat: "yy-mm-dd"
			});
		});
	$('#edit_panel').on('show.bs.modal' , function(e){
		var id = e.relatedTarget.parentElement.parentElement.parentElement.children[0].textContent;
		
		$('#edit_id').val(id);
		
		$.ajax({
			url:'/control/cost/get_commission.html',
			type:'post',
			dataType:'json',
			data:{
				'id':id
			},
			success:function(data){
				if (data.status == 'T')
				{
					$('#edit_name').val(data.commission.name);
					$('#edit_next_pay').val(data.commission.next_pay);
					$('#edit_cost').val(data.commission.cost);
					$('#edit_pay_range').val(data.commission.pay_range);
					
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
			url:'/control/cost/edit_commission.html',
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