<div class="modal fade" id="add_panel">
  <div class="modal-dialog">
    <div class="modal-content">
	<form name="add_form" id="add_form" action="/control/cost/add_commission.html" method="post" enctype="multipart/form-data">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><strong>新增委員</strong></h4>
      </div>
	  <div class="modal-body row">
		
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">委員名稱</label>
			<div class="col-sm-9">
			<input class="form-control" name="name" id="name" type="text" placeholder="請輸入委員名稱" required>
			</div>
		</div>
		</div>
		
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">下次繳費期限</label>
			<div class="col-sm-9">
			<input class="form-control" name="next_pay" id="next_pay" type="text" placeholder="請輸入下次繳費期限" required>
			</div>
		</div>
		</div>
		
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">繳費費用</label>
			<div class="col-sm-9">
			<input class="form-control" name="cost" id="cost" type="number" placeholder="請輸入繳費費用" required>
			</div>
		</div>
		</div>
		
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">繳費間距(天數)</label>
			<div class="col-sm-9">
			<input class="form-control" name="pay_range" id="pay_range" type="number" placeholder="請輸入繳費間距(天數) 如果天數為一年請輸入0或保留空值">
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
			$('#next_pay').datepicker({
				dateFormat: "yy-mm-dd"
			});
		});
		$('form#add_form').submit(function(){

		var formdata = new FormData($(this)[0]);
		
		$.ajax({
			url:'/control/cost/add_commission.html',
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