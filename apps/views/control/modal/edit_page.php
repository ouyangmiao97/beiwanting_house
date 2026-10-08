<div class="modal fade" id="edit_panel">
  <div class="modal-dialog">
    <div class="modal-content">
	<form name="add_form" id="add_form" action="/control/page/edit_page" method="post" enctype="multipart/form-data">
	<input type="hidden" name="id" id="edit_id">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><strong>新增頁面</strong></h4>
      </div>
	  
      <div class="modal-body row">
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">名稱</label>
			<div class="col-sm-9">
			<input class="form-control" name="title" id="edit_title" type="text" placeholder="請輸入頁面名稱">
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">description</label>
			<div class="col-sm-9">
			<input class="form-control" name="description" id="edit_description" type="text" placeholder="頁面敘述，例如：鑽石彩鑽的專家，來自礦區直營，各式稀有鑽石彩鑽和彩色寶石，專屬設計師提供訂製鑽石手鍊，鑽石耳環，鑽石項鍊，鑽石戒指及其他彩寶客製化服務。擁有全世界最稀有的各式鑽石彩鑽收藏，也與全世界各地的鑽石寶石鑑定中心緊密合作，提供專業的珠寶需求。">
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">keywords</label>
			<div class="col-sm-9">
			<input class="form-control" name="keywords" id="edit_keywords" type="text" placeholder="關鍵字(半形逗號分隔)，例如：彩鑽,鑽石,翡翠,寶石,GIA,鑽戒,侏羅紀寶石,侏羅紀彩色鑽石,結婚鑽戒,婚戒,天然寶石">
			</div>
		</div>
		</div>
			
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="submit" id="edit_submit" class="btn btn-primary">新增</button>
      </div>
	  </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

	<script>
	
	$('#edit_panel').on('show.bs.modal' , function(e){
		$('#edit_id').val(e.relatedTarget.parentElement.parentElement.parentElement.children[0].textContent);
		$('#edit_title').val(e.relatedTarget.parentElement.parentElement.parentElement.children[1].textContent);
		$('#edit_description').val(e.relatedTarget.parentElement.parentElement.parentElement.children[3].textContent);
		$('#edit_keywords').val(e.relatedTarget.parentElement.parentElement.parentElement.children[4].textContent);		
	});
	
	$('#edit_submit').click(function(){
		var id = $('#edit_id').val();
		var title = $('#edit_title').val();
		var description = $('#edit_description').val();
		var keywords = $('#edit_keywords').val();

		$.ajax({
			url:'/control/page/edit_page',
			type:'post',
			dataType:'json',
			data:{
				'id':id,
				'title':title,
				'description':description,
				'keywords':keywords
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