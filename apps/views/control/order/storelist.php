<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="zh-Hant">
    <head>
        <?php $this->load->view('control/public/header');?>
    </head>
    <body class="fixed-topbar fixed-sidebar theme-sdtl color-default">
     <section>
<?php $this->load->view('control/public/sidebar');?>
      <div class="main-content">

        <!-- BEGIN PAGE CONTENT -->
        <div class="page-content">
		<?php $this->load->view('control/public/topbar');?>
		<?php $this->load->view('control/public/header_bar');?>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-header">
						<h3><i class="icon-check"></i><strong>選擇您要檢視的店舖</strong>   <small>依照您選取的店舖瀏覽</smail></h3>
					</div>
					<div class="panel-content">
						<form role="form" class="form-horizontal form-validation" action="" method="get">
							<select name="store_id" class="form-control">
								<option value="0" <?php echo $store_id == '所有店鋪'?'selected':'';?>>所有店鋪</option>
								<?php foreach($store_list as $key => $row){?>
								<option value="<?php echo $row->id;?>" <?php echo $store_id == $row->id?'selected':'';?>><?php echo $row->title;?></option>
								<?php }?>
							</select>
							<div class="row">
								<div class="col-md-12">
									<div class="pull-right">
										<button type="submit" href="#" class="btn btn-embossed btn-primary m-r-20 m-t-20">送出</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-header">
						<h3><i class="icon-check"></i><strong>銷貨單匯出</strong>   <small>依照您選取的時間區間列印銷貨單</smail></h3>
					</div>
					<div class="panel-content">
						<form action="/control/sale/get_sale_by_date" role="form" class="form-horizontal form-validation" action="" method="post" autocomplete="off">
							<div class="form-group">
								<label class="col-md-3 control-label">開始日期</label>
								<div class="col-md-9">
									<input type="text" name="start" id="start" class="form-control" placeholder="請選擇日期" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">結束日期</label>
								<div class="col-md-9">
									<input type="text" name="end" id="end" class="form-control" placeholder="請選擇日期" />
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="pull-right">
										<button type="submit" href="#" class="btn btn-embossed btn-primary m-r-20 m-t-20">送出</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- 訂單查詢結果 Start -->
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-header">
						<h3><i class="icon-check"></i><strong>到店取貨清單</strong>   <small>您可以在此進行店鋪取貨操作</smail></h3>
					</div>				
					<div class="panel-content">
						<div class="row">
							<div class="col-md-12 move">
								<table class="table table-hover">
									<thead>
										<th>#</th>
										<th>訂單編號</th>
										<th>訂單狀態</th>
										<th>姓名</th>
										<th>手機</th>
										<th>下單時間</th>
										<th>信件通知</th>
										<th>操作</th>
									</thead>
									<tbody>
										<?php if (isset($order_list) && is_array($order_list) && sizeof($order_list) > 0){?>
										<?php foreach($order_list as $key => $row){?>
										<tr>
											<td><input name="mchecked[]" type="checkbox" class="chkbox form-control" value="<?php echo $row->id;?>" /></td>
											<td><?php echo $row->order_id;?></td>
											<td><?php echo isset($order_active_list[$row->active])?$order_active_list[$row->active]:'';?></td>
											<td><?php echo $row->rec_name;?>(取貨人)<br /><?php echo $row->pay_name;?>(購買人)</td>
											<td><?php echo $row->rec_mobile;?>(取貨人)<br /><?php echo $row->pay_mobile;?>(購買人)</td>
											<td><?php echo $row->create_at;?></td>
											<td><?php echo $row->statue=='1'?'已通知':'';?></td>
											<td>
												<a class="btn btn-default btn-sm" target="_blank" href="<?php echo site_url('control/order/order_detail/' . $row->order_id);?>">明細</a>
												<a class="btn btn-default btn-sm" target="_blank" href="<?php echo site_url('control/sale/get_one/' . $row->order_id);?>">銷貨單</a>
												<?php if ($row->active == 9){?>
												<a class="btn btn-warning store_in  btn-sm"  href="#" data-id="<?php echo $row->id;?>">變更已到貨</a>
												<?php }?>
												<?php if ($row->active == 10){?>
												<a class="btn btn-success store_out  btn-sm" href="#" data-id="<?php echo $row->id;?>">變更已取貨</a>
												<?php }?>
												<a class="btn btn-success  btn-sm" 

												href="/control/order/storemail/?id=<?php echo $row->id;?> & store_id=<?php echo $store_id;?> & mail=<?php echo $row->member_login;?> & ss=<?php echo $row->order_id;?> " >缺貨通知</a>
												<a class="btn btn-danger del btn-sm"  href="#" data-id="<?php echo $row->id;?>" data-title="<?php echo $row->order_id;?>">刪除</a>
											</td>
										</tr>
										<?php }?>
										<?php }?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="3">
												<a href="#" id="all_sel">全選</a>  |  <a href="#" id="del_list">刪除</a>  |  <a href="#" id="change_list_in">變更已到貨</a> | <a href="#" id="change_list_out">變更已取貨</a>
											</td>
											<td colspan="4"></td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
						<?php /*
						<div class="row">
							<div class="col-xs-12">
							
								<div class="row" style="line-height:40px;font-size:18px;font-weight:800;">
									<div class="col-xs-2">訂單編號</div>
									<div class="col-xs-2">訂單狀態</div>
									<div class="col-xs-2">姓名</div>
									<div class="col-xs-2">手機</div>
									<div class="col-xs-2">下單時間</div>
									<div class="col-xs-2">操作</div>
								</div>
								
								<?php if (isset($order_list) && is_array($order_list) && sizeof($order_list) > 0){?>
								<?php foreach($order_list as $key => $row){?>
								<div class="row" style="line-height:40px;font-size:14px;border-bottom:1px solid #ccc;">
									<div class="col-xs-2"><?php echo isset($row->order_id)?$row->order_id:'錯誤';?></div>
									<div class="col-xs-2"><?php echo isset($order_active_list[$row->active])?$order_active_list[$row->active]:'';?></div>
									<div class="col-xs-2"><?php echo $row->rec_name;?>(取貨人)<br /><?php echo $row->pay_name;?>(購買人)</div>
									<div class="col-xs-2"><?php echo $row->rec_mobile;?>(取貨人)<br /><?php echo $row->pay_mobile;?>(購買人)</div>
									<div class="col-xs-2"><?php echo $row->create_at;?></div>
									<div class="col-xs-2" style="padding-top:10px;">
										<a class="btn btn-default btn-sm" target="_blank" href="<?php echo site_url('control/order/order_detail/' . $row->order_id);?>">明細</a>
										<a class="btn btn-default btn-sm" target="_blank" href="<?php echo site_url('control/sale/get_one/' . $row->order_id);?>">銷貨單</a>
										<?php if ($row->active == 9){?>
										<a class="btn btn-warning store_in  btn-sm"  href="#" data-id="<?php echo $row->id;?>">變更已到貨</a>
										<?php }?>
										<?php if ($row->active == 10){?>
										<a class="btn btn-success store_out  btn-sm" href="#" data-id="<?php echo $row->id;?>">變更已取貨</a>
										<?php }?>
										<a class="btn btn-danger del btn-sm"  href="#" data-id="<?php echo $row->id;?>" data-title="<?php echo $row->order_id;?>">刪除</a>
									</div>
								</div>
								<?php }?>
								<?php }?>
							
							</div>
						</div>
						*/?>
					</div>
				</div>
			</div>
		</div>
		<!-- 訂單查詢結果 End -->
		
		<?php $this->load->view('control/public/footer_bar');?>		
        </div>
        <!-- END PAGE CONTENT -->
      </div>
      <!-- END MAIN CONTENT -->
	  
	  
    </section>

	<?php $this->load->view('control/public/footer');?>
	<style type="text/css">
		.move{
				white-space: nowrap; 
				overflow: hidden; 
				overflow-x: scroll; 
				-webkit-backface-visibility: hidden; 
				-webkit-overflow-scrolling: touch;
			}
	</style>

	<!-- BEGIN PAGE SCRIPT -->
	<script src="/assets/global/plugins/datatables/jquery.dataTables.min.js"></script> <!-- Tables Filtering, Sorting & Editing -->
    <script src="/assets/global/js/pages/table_dynamic.js"></script>
	<!-- END PAGE SCRIPT -->
		
	<script src="/assets/admin/layout1/js/layout.js"></script>
	<script>
		$('.store_in').click(function(){
			var order_id = $(this).data('id');
			
			$.post('/control/order/store_in/' + order_id , {} , function(response){
				if (response.status=='T')
				{
					window.location.reload();
				}
				else
				{
					alert(response.msg);
				}
			} , 'json').fail(function(err){
				// console.log(err);
			});
			
			return false;
		});
		$('.store_out').click(function(){
			var order_id = $(this).data('id');
			
			$.post('/control/order/store_out/' + order_id , {} , function(response){
				if (response.status=='T')
				{
					window.location.reload();
				}
				else
				{
					alert(response.msg);
				}
			} , 'json').fail(function(err){
				// console.log(err);
			});
			
			return false;
		});
		$('.del').click(function(){
			var title = $(this).data('title');
			var id = $(this).data('id');
			
			if (confirm("確定要刪除編號" + title + "的訂單嗎？"))
			{
				$.ajax({
					url:'/control/order/del',
					type:'post',
					dataType:'json',
					data:{
						'id':id
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
			}
			
			return false;
		});
		$('#del_list').click(function(){
			var list = $('input:checkbox:checked[name="mchecked[]"]').map(function() { return $(this).val(); }).get();
			
			if (list.length > 0)
			{
				if (confirm('確定要刪除所選取的資料嗎？'))
				{
					$.post('/control/order/storelist_del_list.html' , {'list':list} , function(response){
						if (response.status == 'T')
						{
							location.reload();
						}
						else
						{
							alert(response.msg);
						}
					} , 'json');
				}
			}
			else
			{
				alert('您尚未選取任何資料');
			}
			
			return false;
		});
		$('#change_list_in').click(function(){
			var list = $('input:checkbox:checked[name="mchecked[]"]').map(function() { return $(this).val(); }).get();
			
			if (list.length > 0)
			{
				if (confirm('確定要變更所選取的資料嗎？'))
				{
					$.post('/control/order/storelist_change_list_in.html' , {'list':list} , function(response){
						if (response.status == 'T')
						{
							location.reload();
						}
						else
						{
							alert(response.msg);
							location.reload();
						}
					} , 'json');
				}
			}
			else
			{
				alert('您尚未選取任何資料');
			}
			
			return false;
		});
		$('#change_list_out').click(function(){
			var list = $('input:checkbox:checked[name="mchecked[]"]').map(function() { return $(this).val(); }).get();
			
			if (list.length > 0)
			{
				if (confirm('確定要變更所選取的資料嗎？'))
				{
					$.post('/control/order/storelist_change_list_out.html' , {'list':list} , function(response){
						if (response.status == 'T')
						{
							location.reload();
						}
						else
						{
							alert(response.msg);
							location.reload();
						}
					} , 'json');
				}
			}
			else
			{
				alert('您尚未選取任何資料');
			}
			
			return false;
		});
		$('#all_sel').click(function(){
			var list = $('input:checkbox:checked[name="mchecked[]"]').map(function() { return $(this).val(); }).get();
			
			console.log(list);
			if (list.length > 0)
			{
				$('.chkbox').iCheck('uncheck');
			}
			else
			{
				$('.chkbox').iCheck('check');
			}

			return false;
		});
		$('#start').datepicker({
			dateFormat: "yy-mm-dd"
		});
		$('#end').datepicker({
			dateFormat: "yy-mm-dd"
		});
	</script>
    </body>
</html>
