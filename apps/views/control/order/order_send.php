<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="zh-Hant">
    <head>
        <?php $this->load->view('control/public/header');?>
		
		<style>
			.focus_filed{
				color:red;
				font-weight:800;
			}
		</style>
    </head>
    <body class="fixed-topbar fixed-sidebar theme-sdtl color-default">
     <section>
<?php $this->load->view('control/public/sidebar');?>
      <div class="main-content">

        <!-- BEGIN PAGE CONTENT -->
        <div class="page-content">
		<?php $this->load->view('control/public/topbar');?>
		<?php $this->load->view('control/public/header_bar');?>
		
		<!-- 訂單查詢結果 Start -->
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-header">
						<h3><i class="icon-check"></i><strong>出貨</strong><small>您可以在此進行出貨的動作</smail></h3>
					</div>				
					
					<div class="panel-content">
						<div class="row" style="font-size:14px;font-weight:600;">
							<div class="col-md-12">
								<form role="form" class="form-horizontal form-validation" action="/control/order/order_send_post" method="post">
									<div class="form-group">
										<label class="col-md-3 control-label" for="order_id">訂單編號</label>
										<div class="col-md-9">
											<input type="text" name="order_id" id="order_id" class="form-control" value="<?php echo isset($order->order_id)?$order->order_id:'';?>" placeholder="您所要出貨的訂單編號" readonly />
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label" for="payment_id">付款編號</label>
										<div class="col-md-9">
											<input type="text" name="payment_id" id="payment_id" class="form-control" value="<?php echo isset($payment->payment_id)?$payment->payment_id:'';?>" placeholder="您所要出貨的付款編號" readonly />
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label" for="invoice_no">統一發票號碼</label>
										<div class="col-md-9">
											<input type="text" name="invoice_no" id="invoice_no" class="form-control" placeholder="輸入您開立的統一發票號碼" required/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label" for="send_function">運送方式</label>
										<div class="col-md-9">
											<select name="send_function" id="send_function" class="form-control">
												<?php /*<option value="CVS">超商取貨</option>*/ ?>
												<option value="HOME">黑貓宅配</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label" for="distance">距離</label>
										<div class="col-md-9">
											<select name="distance" id="distance" class="form-control">
												<option value="01">同縣市</option>
												<option value="02">外縣市</option>
												<option value="03">離島</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label" for="package_size">規格(長寬高總和)</label>
										<div class="col-md-9">
											<select name="package_size" id="package_size" class="form-control">
												<option value="0001">60公分</option>
												<option value="0002">90公分</option>
												<option value="0003">120公分</option>
												<option value="0004">150公分</option>
											</select>
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
    </body>
</html>
