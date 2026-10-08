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
						<h3><i class="icon-check"></i><strong>訂單及付款紀錄查詢</strong><small>您可以在此進行訂單的查詢</smail></h3>
					</div>
					
					<div class="panel-content">
						<div class="row">
							<div class="col-md-12">
								<form role="form" class="form-horizontal form-validation" action="" method="post">
									
									<div class="form-group">
										<label class="col-md-3 control-label">訂單狀態</label>
										<div class="col-md-9">
											<select name="order_active" class="form-control">
												<option value="99" <?php echo 99 === $data['order_active']?'selected':'';?>>全部</option>
												<?php if (isset($order_active_list) && is_array($order_active_list) && count($order_active_list) > 0 ){?>
												<?php foreach($order_active_list as $key => $val){?>
												<option value="<?php echo $key;?>" <?php echo $key === $data['order_active']?'selected':'';?>><?php echo $val;?></option>
												<?php }?>
												<?php }?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">付款狀態</label>
										<div class="col-md-9">
											<select name="payment_active" class="form-control">
												<option value="99" <?php echo 99 === $data['payment_active']?'selected':'';?>>全部</option>
												<?php if (isset($payment_active_list) && is_array($payment_active_list) && count($payment_active_list) > 0){?>
												<?php foreach($payment_active_list as $key => $val){?>
												<option value="<?php echo $key;?>" <?php echo $key === $data['payment_active']?'selected':'';?>><?php echo $val;?></option>
												<?php }?>
												<?php }?>
											</select>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-md-3 control-label">訂單編號：</label>
										<div class="col-md-9">
											<input name="order_id" class="form-control" placeholder="填入訂單編號，訂單編號開頭為英文字母e小寫" value="<?php echo isset($data['order_id'])?$data['order_id']:'';?>">
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-md-3 control-label">付款編號：</label>
										<div class="col-md-9">
											<input name="payment_id" class="form-control" placeholder="填入付款編號，訂單編號開頭為英文字母p小寫" value="<?php echo isset($data['payment_id'])?$data['payment_id']:'';?>">
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-md-3 control-label">金流商付款編號：</label>
										<div class="col-md-9">
											<input name="trade_no" class="form-control" placeholder="填入金流產生的付款編號" value="<?php echo isset($data['trade_no'])?$data['trade_no']:'';?>">
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-md-3 control-label">歐付寶物流單號：</label>
										<div class="col-md-9">
											<input name="send_id" class="form-control" placeholder="填入物流產生的編號" value="<?php echo isset($data['send_id'])?$data['send_id']:'';?>">
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-md-3 control-label">黑貓單號：</label>
										<div class="col-md-9">
											<input name="booking_note" class="form-control" placeholder="填入物流產生的編號" value="<?php echo isset($data['booking_note'])?$data['booking_note']:'';?>">
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-md-3 control-label">發票號碼：</label>
										<div class="col-md-9">
											<input name="invoice_no" class="form-control" placeholder="填入出貨時所產生的發票號碼" value="<?php echo isset($data['invoice_no'])?$data['invoice_no']:'';?>">
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-md-3 control-label">會員帳號：</label>
										<div class="col-md-9">
											<input name="member_login" class="form-control" placeholder="填入下單的會員" value="<?php echo isset($data['member_login'])?$data['member_login']:'';?>">
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-md-3 control-label">訂單建立開始時間</label>
										<div class="col-md-3">
											<input name="order_create_date_start" class="form-control" placeholder="點此設定開始時間" value="<?php echo isset($data['order_create_date_start'])?$data['order_create_date_start']:'';?>">
										</div>
										<label class="col-md-3 control-label">訂單建立結束時間</label>
										<div class="col-md-3">
											<input name="order_create_date_end" class="form-control" placeholder="點此設定結束時間" value="<?php echo isset($data['order_create_date_end'])?$data['order_create_date_end']:'';?>">
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-md-3 control-label">付款完成開始時間</label>
										<div class="col-md-3">
											<input name="pay_date_start" class="form-control" placeholder="點此設定開始時間" value="<?php echo isset($data['pay_date_start'])?$data['pay_date_start']:'';?>">
										</div>
										<label class="col-md-3 control-label">付款完成結束時間</label>
										<div class="col-md-3">
											<input name="pay_date_end" class="form-control" placeholder="點此設定結束時間" value="<?php echo isset($data['pay_date_end'])?$data['pay_date_end']:'';?>">
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
			</div>
		</div>
		
		<!-- 訂單查詢結果 Start -->
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-header">
						<h3><i class="icon-check"></i><strong>訂單查詢結果</strong><small>您可以在此進行訂單操作</smail></h3>
					</div>				
					<div class="panel-content">
						<div class="row">
							<div class="col-xs-12">
							
								<div class="row" style="line-height:40px;font-size:26px;">
									<div class="col-xs-2">訂單編號</div>
									<div class="col-xs-2">付款編號</div>
									<div class="col-xs-2">金流商付款編號</div>
									<div class="col-xs-2">訂單狀態</div>
									<div class="col-xs-2">付款狀態</div>
									<div class="col-xs-2">操作</div>
								</div>
								
								<?php if (isset($order_list) && is_array($order_list) && sizeof($order_list) > 0){?>
								<?php while(list($key , $row) = each($order_list)){?>
								<div class="row" style="line-height:40px;font-size:18px;">
									<div class="col-xs-2"><?php echo isset($row->order_id)?$row->order_id:'錯誤';?></div>
									<div class="col-xs-2"><?php echo isset($row->payment_id)?$row->payment_id:'找不到付款資料';?></div>
									<div class="col-xs-2"><?php echo isset($row->trade_no)?$row->trade_no:'找不到付款資料';?></div>
									<div class="col-xs-2"><?php echo isset($order_active_list[$row->order_active])?$order_active_list[$row->order_active]:'';?></div>
									<div class="col-xs-2"><?php echo isset($payment_active_list[$row->payment_active])?$payment_active_list[$row->payment_active]:'找不到付款資料';?></div>
									<div class="col-xs-2"><a href="<?php echo site_url('control/order/order_detail/' . $row->order_id);?>">明細</a></div>
								</div>
								<?php }?>
								<?php }?>
							
							</div>
						</div>
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
	<?php $this->load->view('control/modal/view_contact');?>
	<?php $this->load->view('control/modal/reply_contact');?>

	<!-- BEGIN PAGE SCRIPT -->
	<script src="/assets/global/plugins/datatables/jquery.dataTables.min.js"></script> <!-- Tables Filtering, Sorting & Editing -->
    <script src="/assets/global/js/pages/table_dynamic.js"></script>
	<!-- END PAGE SCRIPT -->
		
	<script src="/assets/admin/layout1/js/layout.js"></script>
	</script>
    </body>
</html>
