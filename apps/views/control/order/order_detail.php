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
						<h3><i class="icon-check"></i><strong>定單明細</strong><small>您可以在此進行改訂單的操作與閱覽明細訊息</smail></h3>
					</div>				
					
					
					<div class="panel-content">
						<div class="row" style="font-size:14px;font-weight:600;">
						
							<div class="col-xs-12" style="text-align:right;">
								<?php if ($order->active == 2){?><a href="<?php echo site_url('/control/order/order_send/' . $order->order_id);?>">出貨</a><?php }?><?php if ($order->active == 3){?><a href="<?php echo site_url('/control/order/order_trade_doc/' . $order->order_id);?>" target="_blank">列印出貨單</a><?php }?>
							</div>
							
							<?php if (isset($order) && is_object($order) && sizeof($order) > 0){?>
							<h2>訂單資訊</h2>
							<table class="table table-bordered" width="100%">
								<thead>
									<th width="20%">訂單系統流水號</th>
									<th width="20%">訂單編號</th>
									<th width="20%">訂單狀態</th>
									<th width="20%">購買人(帳號)</th>
									<th width="20%">建立日期(訂單)</th>
								</thead>
								<tbody>
									<tr>
										<td><?php echo $order->id;?></td>
										<td><?php echo $order->order_id;?></td>
										<td><?php echo isset($order_active_list[$order->active])?$order_active_list[$order->active]:'未知狀態';?></td>
										<td><?php echo $order->member_login;?></td>
										<td><?php echo $order->create_at;?></td>
									</tr>
								</tbody>
								<thead>
									
									<th width="20%">訂單總額(帳號)</th>
									<th width="20%">運費</th>
									<th width="20%">訂單淨額(不含運)</th>
									<th width="20%">商品總數</th>
									<th width="20%">寄送副本給收件人</th>
								</thead>
								<tbody>
									<tr>
										
										<td><?php echo to_money($order->total);?></td>
										<td><?php echo to_money($order->send_cost);?></td>
										<td><?php echo to_money($order->cost);?></td>
										<td><?php echo $order->total_items;?></td>
										<td><?php echo $order->copyies_torec==1?'是':'否';?></td>
									</tr>
								</tbody>
								<thead>
									<th width="20%">配送地區</th>
									<th width="20%">配送時間</th>
									<th width="20%">發票類型</th>
									<th width="20%">統一編號</th>
									<th width="20%">發票抬頭</th>
								</thead>
								<tbody>
									<tr>
										<td><?php echo isset($send_fun_list[$order->send_fun])?$send_fun_list[$order->send_fun]:$order->send_fun;?></td>
										<td><?php echo isset($rec_time_list[$order->rec_time])?$rec_time_list[$order->rec_time]:$order->rec_time;?></td>
										<td><?php echo isset($invoice_type_list[$order->invoice_type])?$invoice_type_list[$order->invoice_type]:$order->invoice_type;?></td>
										<td><?php echo $order->invoice_uniform;?></td>
										<td><?php echo $order->invoice_title;?></td>
									</tr>
								</tbody>
								<thead>
									<th width="20%">訂單備註</th>
								</thead>
								<tbody>
									<tr>
										<td><?php echo $order->rec_memo;?></td>
									</tr>
								</tbody>
							</table>
							
							<?php }?>
						
							<?php if (isset($payment) && is_object($payment) && sizeof($payment) > 0){?>
							<h2>付款資訊</h2>
							<table class="table table-bordered" width="100%">
								<thead>
									<th width="20%">廠商交易編號</th>
									<th width="20%">金流交易編號</th>
									<th width="20%">交易時間(系統)</th>
									<th width="20%">交易時間(金流)</th>
									<th width="20%">交易狀態</th>
									
								</thead>
								<tbody>
									<tr>
										<td><?php echo isset($payment->payment_id)?$payment->payment_id:'查無資料';?></td>
										<td><?php echo isset($payment->trade_no)?$payment->trade_no:'查無資料';?></td>
										<td><?php echo isset($payment->create_at)?$payment->create_at:'查無資料';?></td>
										<td><?php echo isset($payment->trade_date)?$payment->trade_date:'查無資料';?></td>
										<td><?php echo isset($payment_actvie_list[$payment->active])?$payment_active_list[$payment->active]:'未知狀態';?></td>
									</tr>
								</tbody>
								<thead>
									
									<th width="20%">金流手續費</th>
									<th width="20%">API回傳時間</th>
									<th width="20%">繳費銀行代碼</th>
									<th width="20%">繳費虛擬帳號</th>
									<th width="20%">繳費截止日</th>
								</thead>
								<tbody>
									<tr>
										
										<td><?php echo isset($payment->plaform_change_fee)?$payment->plaform_change_fee:'查無資料';?></td>
										<td><?php echo isset($payment->api_response_date)?$payment->api_response_date:'查無資料';?></td>
										<td><?php echo isset($payment->bank_code)?$payment->bank_code:'查無資料';?></td>
										<td><?php echo isset($payment->v_account)?$payment->v_account:'查無資料';?></td>
										<td><?php echo isset($payment->pay_expire_date)?$payment->pay_expire_date:'查無資料';?></td>
									</tr>
								</tbody>
								<thead>
									
									<th width="20%">使用的付款方式</th>
									<th width="20%">裝置</th>
									<th width="20%"></th>
									<th width="20%"></th>
									<th width="20%"></th>
								</thead>
								<tbody>
									<tr>
										
										<td><?php echo isset($payment->choose_payment)?$payment->choose_payment:'查無資料';?></td>
										<td><?php echo isset($payment->device_source)?$payment->device_source:'查無資料';?></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
								</tbody>
							</table>
							
							<h2>物流資訊</h2>
							<table class="table table-bordered" width="100%">
								<thead>
									<th width="20%">物流編號</th>
									<th width="20%">物流狀態碼</th>
									<th width="20%">物流狀態說明</th>
									<th width="20%">物流狀態</th>
									<th width="20%">API回傳時間</th>
								</thead>
								<tbody>
									<tr>
										<td><?php echo isset($payment->send_id)?$payment->send_id:'';?></td>
										<td><?php echo isset($payment->send_status)?$payment->send_status:'';?></td>
										<td><?php echo isset($payment->send_status_msg)?$payment->send_status_msg:'';?></td>
										<td><?php echo isset($send_status_list[$payment->send_status])?$send_status_list[$payment->send_status]['admin']:'';?></td>
										<td><?php echo $payment->api_response_date;?></td>
									</tr>
								</tbody>
								<thead>
									<th width="20%">黑貓專用編號</th>
									<th width="20%"></th>
									<th width="20%"></th>
									<th width="20%"></th>
									<th width="20%"></th>
								</thead>
								<tbody>
									<tr>
										<td><?php echo isset($payment->booking_note)?$payment->booking_note:'';?></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
								</tbody>
							</table>
							
							<?php }?>
							
							
							<h2>訂購人資訊</h2>
							<table class="table table-bordered" width="100%">
								<thead>
									<th width="20%">信箱</th>
									<th width="20%">姓名</th>
									<th width="20%">地址</th>
									<th width="20%">電話</th>
									<th width="20%">手機</th>
								<tbody>
									<tr>
										<td><?php echo $order->pay_email;?></td>
										<td><?php echo $order->pay_name;?></td>
										<td><?php echo $order->pay_address;?></td>
										<td><?php echo $order->pay_phone;?></td>
										<td><?php echo $order->pay_mobile;?></td>
									</tr>
								</tbody>
								<thead>
									<th width="20%">城市</th>
									<th width="20%">國家</th>
									<th width="20%">郵遞區號</th>
									<th width="20%"></th>
									<th width="20%"></th>
								</thead>
								<tbody>
									<tr>
										<td><?php echo $order->pay_city;?></td>
										<td><?php echo $order->pay_country;?></td>
										<td><?php echo $order->pay_post_no;?></td>
										<td></td>
										<td></td>
									</tr>
								</tbody>
							</table>
							
							<h2>收貨人資訊</h2>
							<table class="table table-bordered" width="100%">
								<thead>
									<th width="20%">信箱</th>
									<th width="20%">姓名</th>
									<th width="20%">地址</th>
									<th width="20%">電話</th>
									<th width="20%">手機</th>
								</thead>
								<tbody>
									<tr>
										<td><?php echo $order->rec_email;?></td>
										<td><?php echo $order->rec_name;?></td>
										<td><?php echo $order->rec_address;?></td>
										<td><?php echo $order->rec_phone;?></td>
										<td><?php echo $order->rec_mobile;?></td>
									</tr>
								</tbody>
								<thead>
									<th width="20%">城市</th>
									<th width="20%">國家</th>
									<th width="20%">郵遞區號</th>
									<th width="20%"></th>
									<th width="20%"></th>
								</thead>
								<tbody>
									<tr>
										<td><?php echo $order->rec_city;?></td>
										<td><?php echo $order->rec_country;?></td>
										<td><?php echo $order->rec_post_no;?></td>
										<td></td>
										<td></td>
									</tr>
								</tbody>
							</table>
							
							<h2>交易商品明細</h2>
							<table class="table table-bordered" width="100%">
								<thead>
									<th width="20%">品名</th>
									<th width="20%">顏色</th>
									<th width="20%">度數</th>
									<th width="20%">數量</th>
									<th width="20%">小計</th>
								</thead>
								<tbody>
									<?php if ($order->order_contents != FALSE){?>
									<?php $order_contents = json_decode($order->order_contents , TRUE);?>
									<?php foreach($order_contents as $key => $row){?>
									<tr>
										<td><?php echo $row['options']['name'];?></td>
										<td><?php echo $row['options']['color'];?></td>
										<td><?php echo $row['options']['degree'];?></td>
										<td><?php echo $row['qty'];?></td>
										<td><?php echo to_money($row['price'] * $row['qty']);?></td>
									</tr>
									<?php }}?>
								</tbody>
							</table>
							
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
