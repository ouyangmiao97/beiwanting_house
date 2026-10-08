<div class="modal fade" id="reply_panel">
  <div class="modal-dialog">
    <div class="modal-content">
	<form name="edit_form" id="edit_form" action="/control/contact/reply" method="post" enctype="multipart/form-data">
	<input type="hidden" name="id" id="edit_id" value="">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><strong>回覆客服問答</strong></h4>
      </div>
      <div class="modal-body">
		<div class="row">
			<div class="col-md-12">
				<p>姓名：<span id="reply_name"></span></p>
				<p style="display:none;">聯絡電話：<span id="reply_phone"></span>
				<p>電子郵件：<span id="reply_mail"></span></p>
				<p style="display:none;">會員帳號：<span id="reply_login"></span></p>
				<p class="product" style="display:none;">產品編號：<span id="reply_product_id"></span></p>
				<p class="product" style="display:none;">產品名稱：<span id="reply_product_name"></span></p>
				<p class="order" style="display:none;">訂單編號：<span id="reply_order_id"></span></p>
				<p>提問時間：<span id="reply_ask_create_at"></span></p>
				<p style="display:none;">發問主旨：<span id="reply_title"></span></p>
				<p>發問問題：<span id="reply_memo"></span></p>
				<p>回覆內容：<span id="reply_msg_show"></span></p>
			</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">回覆訊息</label>
			<div class="col-sm-9">
				<input type="hidden" name="id" id="id" />
				<textarea id="reply_msg" class="form-control" rows="10"></textarea>
			</div>
		</div>
		</div>
		
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="submit" id="add_submit" class="btn btn-primary">回覆訊息</button>
      </div>
	  </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
	$('#reply_panel').on('show.bs.modal' , function(e){
		var id = e.relatedTarget.parentElement.parentElement.parentElement.children[1].textContent;
		
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
					$('#id').val(data.contact.id);
					$('#reply_name').html(data.contact.user_name);
					$('#reply_phone').html(data.contact.user_phone);
					$('#reply_mail').html(data.contact.user_mail);
					$('#reply_login').html(data.contact.login);
					
					
					$('#reply_ask_create_at').html(data.contact.create_at);
					$('#reply_title').html(data.contact.title);
					$('#reply_memo').html(data.contact.memo);
					
					if (data.contact.reply != '')
					{
						$('#reply_msg_show').show();
						$('#reply_msg_show').html(data.contact.reply);
					}
					else
					{
						$('#reply_msg_show').hide();
						$('#reply_msg_show').html('');
					}
					
			
					if (data.contact.type == '0')
					{
						$('.product').hide();
						$('.order').hide();
					}
					else if (data.contact.type == '1')
					{
						$('.product').show();
						$('.order').hide();
						
						$('#reply_product_id').html(data.contact.product_id);
						$('#reply_product_name').html(data.contact.ptitle);
					}
					else if (data.contact.type == '2')
					{
						$('.product').hide();
						$('.order').show();
						
						$('#reply_order_id').html(data.contact.order_id);
					}
				}
				else
				{
					alert(data.msg);
					return false;
				}
			},
			error:function(e)
			{
				console.log(e);
				return false;
			}
		});
	});
	
	$('#edit_form').submit(function(){
		var id = $('#id').val();
		var msg = $('#reply_msg').val();
		
		$.ajax({
			url:'/control/contact/reply',
			type:'post',
			dataType:'json',
			data:{
				'id':id,
				'msg':msg
			},
			success:function(data){
				
				if (data.status == 'T')
				{	
					alert(data.msg);
					location.reload();
				}
				else
				{
					alert(data.msg);
					return false;
				}
			},
			error:function(e)
			{
				console.log(e);
				return false;
			}
		});
		
		return false;
	});
</script>