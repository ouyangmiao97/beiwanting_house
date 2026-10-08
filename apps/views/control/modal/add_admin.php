<div class="modal fade" id="add_panel">
  <div class="modal-dialog">
    <div class="modal-content">
	<form name="add_form" id="add_form" action="/control/website/add_banner" method="post" enctype="multipart/form-data">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><strong>新增管理者</strong></h4>
      </div>
	  
      <div class="modal-body row">
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">帳號</label>
			<div class="col-sm-9">
			<input class="form-control" name="login" id="login" type="text" placeholder="請輸入管理者帳號">
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">密碼</label>
			<div class="col-sm-9">
			<input class="form-control" name="passwd" id="passwd" type="password" placeholder="請輸入密碼">
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">名稱</label>
			<div class="col-sm-9">
			<input class="form-control" name="name" id="name" type="text" placeholder="請輸入管理者名稱">
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">信箱</label>
			<div class="col-sm-9">
			<input class="form-control" name="email" id="email" type="text" placeholder="例如：lulu@gmail.com">
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">權限等級</label>
			<div class="col-sm-9">
			<input class="form-control" name="level" id="level" type="number" placeholder="請輸入數字，數字越高權限越大">
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
		var login = $('#login').val();
		var passwd = $('#passwd').val();
		var name = $('#name').val();
		var email = $('#email').val();

		$.ajax({
			url:'/control/admin/add_admin',
			type:'post',
			dataType:'json',
			data:{
				'login':login,
				'passwd':passwd,
				'name':name,
				'email':email
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