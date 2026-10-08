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
						<h3><i class="icon-check"></i><strong>購物設定</strong><small>您可以在此設定購物相關參數</smail></h3>
					</div>
					<div class="panel-content">
						<div class="row">
						<div class="col-md-12">
							<form role="form" class="form-horizontal form-validation" action="/control/order/shopping_cost_setting_post" method="post">
							<div class="form-group">
								<label class="col-md-3 control-label">設定運費作用範圍</label>
								<div class="col-md-9">
									<select class="form-control" name="shopping_cost_rule">
										<?php while(list($key , $val) = each($shopping_cost_rule)){?>
										<option value="<?php echo $key;?>" <?php echo $order_setting['shopping_cost_rule'] == $key?'selected':'';?>><?php echo $val;?></option>
										<?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">設定本島購物滿多少可以免運</label>
								<div class="col-md-9">
									<input name="free_shopping_cost" type="number" class="form-control" placeholder="請輸入金額" required aria-required="true" value="<?php echo isset($order_setting['free_shopping_cost'])?$order_setting['free_shopping_cost']:0;?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">設定本島運費</label>
								<div class="col-md-9">
									<input name="shooping_cost" type="number" class="form-control" placeholder="請輸入金額" required aria-required="true" value="<?php echo isset($order_setting['shooping_cost'])?$order_setting['shooping_cost']:0;?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">設定外島購物滿多少可以免運</label>
								<div class="col-md-9">
									<input name="free_shopping_cost_i" type="number" class="form-control" placeholder="請輸入金額" required aria-required="true" value="<?php echo isset($order_setting['free_shopping_cost_i'])?$order_setting['free_shopping_cost_i']:0;?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">設定外島運費</label>
								<div class="col-md-9">
									<input name="shooping_cost_i" type="number" class="form-control" placeholder="請輸入金額" required aria-required="true" value="<?php echo isset($order_setting['shooping_cost_i'])?$order_setting['shooping_cost_i']:0;?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">設定跨國購物滿多少可以免運</label>
								<div class="col-md-9">
									<input name="free_shopping_cost_c" type="number" class="form-control" placeholder="請輸入金額" required aria-required="true" value="<?php echo isset($order_setting['free_shopping_cost_c'])?$order_setting['free_shopping_cost_c']:0;?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">設定跨國運費</label>
								<div class="col-md-9">
									<input name="shooping_cost_c" type="number" class="form-control" placeholder="請輸入金額" required aria-required="true" value="<?php echo isset($order_setting['shooping_cost_c'])?$order_setting['shooping_cost_c']:0;?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">發票捐贈選擇</label>
								<div class="col-md-9">
									<select class="form-control" name="invoice_rule">
										<?php if (isset($invoice_rule) && is_array($invoice_rule)){?>
										<?php while(list($key , $val) = each($invoice_rule)){?>
										<option value="<?php echo $key;?>" <?php echo $order_setting['invoice_rule']==$key?'selected':'';?>><?php echo $val;?></option>
										<?php }}?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">發票捐贈單位</label>
								<div class="col-md-9">
									<input name="invoice_group" type="text" class="form-control" placeholder="輸入發票捐贈單位，例如：財團法人創世社會福利基金會" value="<?php echo isset($order_setting['invoice_group'])?$order_setting['invoice_group']:'';?>"></input>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label">物流貨物寄件人</label>
								<div class="col-md-9">
									<input name="send_name" type="text" class="form-control" placeholder="輸入物流寄件者，例如：概念國際貿易有限公司" value="<?php echo isset($order_setting['send_name'])?$order_setting['send_name']:'';?>"></input>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">物流貨物取得郵遞區號(<a href="http://www.post.gov.tw/post/internet/Postal/index.jsp?ID=208" target="_blank">查詢</a>)</label>
								<div class="col-md-9">
									<input name="send_zip" type="text" class="form-control" placeholder="輸入物流寄件地址郵遞區號五碼，例如：54321" value="<?php echo isset($order_setting['send_zip'])?$order_setting['send_zip']:'';?>"></input>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">物流貨物取得地址</label>
								<div class="col-md-9">
									<input name="send_address" type="text" class="form-control" placeholder="輸入物流寄件地址，例如：台北市市民大道1號1樓" value="<?php echo isset($order_setting['send_address'])?$order_setting['send_address']:'';?>"></input>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">寄件連絡電話</label>
								<div class="col-md-9">
									<input name="send_phone" type="text" class="form-control" placeholder="輸入寄件連絡電話，例如：0222001234" value="<?php echo isset($order_setting['send_phone'])?$order_setting['send_phone']:'';?>"></input>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">寄件連絡手機</label>
								<div class="col-md-9">
									<input name="send_mobile" type="text" class="form-control" placeholder="輸入寄件連絡手機，例如：0912123456" value="<?php echo isset($order_setting['send_mobile'])?$order_setting['send_mobile']:'';?>"></input>
								</div>
							</div>
							
							<div class="row">
							<div class="col-md-12">
								<div class="pull-right">
								<button type="submit" href="#" class="btn btn-embossed btn-primary m-r-20 m-t-20">送出</button>
								</div>
							</div>
							</div>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
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
