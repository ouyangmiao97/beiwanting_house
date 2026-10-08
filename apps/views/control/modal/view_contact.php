<div class="modal fade" id="view_panel">
  <div class="modal-dialog">
    <div class="modal-content">
	<form name="add_form" id="add_form" action="/control/website/add_banner" method="post" enctype="multipart/form-data">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><strong>客服詳細資料</strong></h4>
      </div>
	  
      <div class="modal-body row">
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">名稱</label>
			<div class="col-sm-9">
			<input class="form-control" name="user_name" id="user_name" type="text" placeholder="" disabled>
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">分類</label>
			<div class="col-sm-9">
			<input class="form-control" name="type" id="type" type="text" placeholder="" disabled>
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">處理狀態</label>
			<div class="col-sm-9">
			<input class="form-control" name="active" id="active" type="text" placeholder="" disabled>
			</div>
		</div>
		</div>
		<!--<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">預約鑑賞日期</label>
			<div class="col-sm-9">
			<input class="form-control" name="reservation_at" id="reservation_at" type="text" placeholder="" disabled>
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">鑑賞商品編號</label>
			<div class="col-sm-9">
			<input class="form-control" name="pid" id="pid" type="text" placeholder="" disabled>
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">鑑賞商品品名</label>
			<div class="col-sm-9">
			<input class="form-control" name="ptitle" id="ptitle" type="text" placeholder="" disabled>
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">銷售據點</label>
			<div class="col-sm-9">
			<input class="form-control" name="service_point" id="service_point" type="text" placeholder="" disabled>
			</div>
		</div>
		</div>-->
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">電話</label>
			<div class="col-sm-9">
			<input class="form-control" name="user_phone" id="user_phone" type="text" placeholder="" disabled>
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">信箱</label>
			<div class="col-sm-9">
			<input class="form-control" name="user_mail" id="user_mail" type="text" placeholder="" disabled>
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">memo</label>
			<div class="col-sm-9">
			<textarea id="memo" name="memo" class="form-control" disabled></textarea>
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">建立時間</label>
			<div class="col-sm-9">
			<input class="form-control" name="create_at" id="create_at" type="text" placeholder="" disabled>
			</div>
		</div>
		</div>
		
			
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
      </div>
	  </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

	<script>
	
	$('#view_panel').on('show.bs.modal' , function(e){
		var id = e.relatedTarget.parentElement.parentElement.parentElement.children[1].textContent;
		
		console.log(id);
		
		$.ajax({
			url:'/control/contact/get_contact',
			type:'post',
			dataType:'json',
			data:{
				'id':id
			},
			success:function(data){
				
				console.log(data);
				
				if (data.status == 'T')
				{
					if (data.contact.type == 0)
					{
						$('#type').val('聯絡我們');
						$('#reservation_at').val('');
						$('#pid').val('');
						$('#ptitle').val('');
						
					}
					
					if (data.contact.type == 1)
					{
						$('#type').val('預約鑑賞');
						$('#reservation_at').val(data.contact.reservation_at);
						$('#pid').val(data.contact.pid);
						$('#ptitle').val(data.contact.ptitle);
						

					}
					
						$('#user_name').val(data.contact.user_name);
						if (data.contact.active == 1)
						{
							$('#active').val('已處理');
						}
						else
						{
							$('#active').val('未處理');
						}
						$('#service_point').val(data.contact.service_point);
						$('#user_phone').val(data.contact.user_phone);
						$('#user_mail').val(data.contact.user_mail);
						$('#memo').val(data.contact.memo);
						$('#create_at').val(data.contact.create_at);
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
	
	</script>