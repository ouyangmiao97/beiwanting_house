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
		<!-- 訂單查詢結果 Start -->
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-header">
						<h3><i class="icon-check"></i><strong>已收款訂單查詢結果</strong><small>您可以在此進行出貨操作</smail></h3>
					</div>				
					<div class="panel-content">
						<div class="row">
							<div class="col-xs-12">
							
								<div class="row" style="line-height:40px;font-size:18px;font-weight:800;">
									<div class="col-xs-2">訂單編號</div>
									<div class="col-xs-2">付款編號</div>
									<div class="col-xs-2">金流商付款編號</div>
									<div class="col-xs-2">訂單狀態</div>
									<div class="col-xs-2">付款狀態</div>
									<div class="col-xs-2">操作</div>
								</div>
								
								<?php if (isset($order_list) && is_array($order_list) && sizeof($order_list) > 0){?>
								<?php while(list($key , $row) = each($order_list)){?>
								<div class="row" style="line-height:40px;font-size:14px;">
									<div class="col-xs-2"><?php echo isset($row->order_id)?$row->order_id:'錯誤';?></div>
									<div class="col-xs-2"><?php echo isset($row->payment_id)?$row->payment_id:'找不到付款資料';?></div>
									<div class="col-xs-2"><?php echo isset($row->trade_no)?$row->trade_no:'找不到付款資料';?></div>
									<div class="col-xs-2"><?php echo isset($order_active_list[$row->order_active])?$order_active_list[$row->order_active]:'';?></div>
									<div class="col-xs-2"><?php echo isset($payment_active_list[$row->payment_active])?$payment_active_list[$row->payment_active]:'找不到付款資料';?></div>
									<div class="col-xs-2"><a class="btn btn-default" href="<?php echo site_url('control/order/order_detail/' . $row->order_id);?>">明細</a><a class="btn btn-default" href="<?php echo site_url('/control/order/order_send/' . $row->order_id);?>">出貨</a></div>
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

	<!-- BEGIN PAGE SCRIPT -->
	<script src="/assets/global/plugins/datatables/jquery.dataTables.min.js"></script> <!-- Tables Filtering, Sorting & Editing -->
    <script src="/assets/global/js/pages/table_dynamic.js"></script>
	<!-- END PAGE SCRIPT -->
		
	<script src="/assets/admin/layout1/js/layout.js"></script>
    </body>
</html>
