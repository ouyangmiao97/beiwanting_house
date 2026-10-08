<div class="modal fade" id="edit_panel">
  <div class="modal-dialog">
    <div class="modal-content">
	<form name="edit_form" id="add_form" action="/control/website/add_banner" method="post" enctype="multipart/form-data">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><strong>修改管理者</strong></h4>
      </div>
      <div class="modal-body row">
		<input type="hidden" name="edit_id" id="edit_id" />
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">帳號</label>
			<div class="col-sm-9">
			<input class="form-control" name="edit_login" id="edit_login" type="text" placeholder="" disabled>
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">密碼</label>
			<div class="col-sm-9">
			<input class="form-control" name="edit_passwd" id="edit_passwd" type="password" placeholder="請輸入密碼">
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">名稱</label>
			<div class="col-sm-9">
			<input class="form-control" name="edit_name" id="edit_name" type="text" placeholder="請輸入管理者名稱">
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">信箱</label>
			<div class="col-sm-9">
			<input class="form-control" name="edit_email" id="edit_email" type="text" placeholder="例如：lulu@gmail.com">
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">權限等級</label>
			<div class="col-sm-9">
			<input class="form-control" name="edit_level" id="edit_level" type="number" placeholder="請輸入數字，數字越高權限越大，最大99">
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
		
		$('#edit_id').val(id);
		
		$.ajax({
			url:'/control/admin/get_admin',
			type:'post',
			dataType:'json',
			data:{
				'id':id
			},
			success:function(data){
				if (data.status == 'T')
				{
					$('#edit_login').val(data.admin.login);
					$('#edit_name').val(data.admin.name);
					$('#edit_email').val(data.admin.email);
					$('#edit_level').val(data.admin.level);
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
	$('#edit_submit').click(function(){
		var id = $('#edit_id').val();
		var passwd = $('#edit_passwd').val();
		var name = $('#edit_name').val();
		var email = $('#edit_email').val();
		var level = $('#edit_level').val();

		$.ajax({
			url:'/control/admin/edit_admin',
			type:'post',
			dataType:'json',
			data:{
				'id':id,
				'passwd':passwd,
				'name':name,
				'email':email,
				'level':level,
			},
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
			}
		});
		
		return false;
	});
</script>