<div class="modal fade" id="edit_panel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
		<input type="hidden" id="edit_id" />
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><strong>修改網址</strong></h4>
      </div>
      <div class="modal-body row">
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">選單名稱</label>
			<div class="col-sm-9">
			<input class="form-control" name="title" id="edit_title" type="text" placeholder="選單名稱" disabled>
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-12">
			<label class="col-sm-3 control-label">選單網址</label>
			<div class="col-sm-9">
			<input class="form-control" name="url" id="edit_url" type="text" placeholder="輸入網址">
			</div>
		</div>
		</div>
			
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
		<button type="submit" id="edit_submit" class="btn btn-primary">修改</button>
      </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->