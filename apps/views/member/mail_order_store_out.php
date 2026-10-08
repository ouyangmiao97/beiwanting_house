<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></meta>
	<title>系統信件</title>
</head>
<body>
	<div class="main" style="margin: 50px auto;width:800px;text-align:left;font-family: '微軟正黑體';font-size: 16px;font-weight: normal;color: #555;">
		<div class="container" style="width:100%;height:auto;">
			<div class="header" style="background-color:#333333;height:30px;"></div>
			<div class="logo-bar" style="text-align:center"><img style="height:150px;width:auto;margin-top:15px;margin-bottom:15px" src="<?php echo site_url();?>images/mail_WEFOXlogo.jpg" alt="WEFOX LOGO" /></div>
		
			<div class="header" style="background-color:#333333;height:30px;">
				<div class="btn" style="float:left;position:relative;width:200px;font-size: 14px;color:#fff;text-align:center;"><a style="color:#fff;text-decoration: none;line-height:30px;height:30px;" href="<?php echo site_url();?>" target="_blank">官網首頁</a></div>
				<div class="btn" style="float:left;position:relative;width:200px;font-size: 14px;color:#fff;text-align:center;"><a style="color:#fff;text-decoration: none;line-height:30px;height:30px;" href="<?php echo site_url();?>#contact" target="_blank">訂房聯絡</a></div>
				<div class="btn" style="float:left;position:relative;width:200px;font-size: 14px;color:#fff;text-align:center;"><a style="color:#fff;text-decoration: none;line-height:30px;height:30px;" href="<?php echo site_url();?>#about" target="_blank">關於北灣町</a></div>
			</div>
			
			<div class="body">
				<div class="body-table" style="padding:10px;">
					<h4>親愛的用戶您好：</h4>
					<p>此筆訂單已取貨完成，再次感謝您的購買！</p>
					<hr>
					<p>訂單編號：<?php echo isset($order->order_id)?$order->order_id:'';?></p>
					<p>取貨門市：<?php echo isset($store)?$store->title:'';?></p>
					<p>取貨地址：<?php echo isset($store)?$store->address:'';?></p>
					<table width="100%" style="width:100%;border: 3px solid black;">
						<thead>
							<th width="40%" style="text-align:center;border: 1px solid black;">品名</th>
							<th width="25%" style="text-align:center;border: 1px solid black;">產品編號</th>
							<th width="10%" style="text-align:center;border: 1px solid black;text-align:center;">數量</th>
							<th width="10%" style="text-align:center;border: 1px solid black;text-align:center;">單價</th>
							<th width="15%" style="text-align:center;border: 1px solid black;text-align:center;">小計</th>
						</thead>
						<tbody>
							<?php $order_contents = json_decode($order->order_contents);?>
							<?php if (isset($order_contents) && count($order_contents) > 0){?>
							<?php while(list($key , $row) = each($order_contents)){?>
							<tr>
								<td style="border: 1px solid black;"><?php echo $row->name;?></td>
								<td style="border: 1px solid black;"><?php echo isset($row->product_id)?$row->product_id:'';?></td>
								<td class="text-right" style="border: 1px solid black;text-align:center;"><?php echo $row->qty;?></td>
								<td class="text-right" style="border: 1px solid black;text-align:center;"><?php echo to_money($row->price);?></td>
								<td class="text-right" style="border: 1px solid black;text-align:center;"><?php echo to_money($row->price * $row->qty);?></td>
							</tr>
							<?php }?>
							<?php }?>
							<tr>
								<td colspan="2"></td>
								<td class="text-right" style="text-align:right;">總計</td>
								<td class="text-right" style="text-align:right;"><?php echo isset($order->total)?to_money($order->total):'';?></td>
							</tr>
						</tbody>
					</table>
					<hr>
					<p>需要協助嗎？請透過<a href="<?php echo site_url();?>#contact" target="_blank" style="color:#09f;text-decoration: none;">訂房聯絡方式</a>與我們聯繫</p>
					<p>有任何疑問可以透過<a href="<?php echo site_url();?>#contact" target="_blank" style="color:#09f;text-decoration: none;">訂房聯絡方式</a>向我們詢問</p>
					<p>歡迎透過<a href="<?php echo site_url();?>#contact" style="color:#09f;text-decoration: none;">訂房聯絡</a>與我們聯繫</p>
					<p class="text-center" style="text-align:center;">/**** 系統信件請勿直接回覆 ****/</p>
				</div>
				<div class="body-bottom" style="margin-top:5px;font-size:10px;line-height:10px;text-align:center;">
					<img src="<?php echo site_url();?>images/logo2.jpg" width="100%" height="" style="width:50%;" alt="WEFOX" />
					<p style="margin-top:5px;font-size:10px;line-height:10px;text-align:center;">有問題請洽+886 2-2694-9116 E-mail:<?php $contact_mail = config_item('contact_mail');?><a style="color:#09f;text-decoration: none;" href="mailto:<?php echo isset($contact_mail[0])?$contact_mail[0]['mail']:'#';?>"><?php echo isset($contact_mail[0])?$contact_mail[0]['mail']:'#';?></a></p>
				</div>
			</div>
			<div class="footer text-center" style="text-align:center;background-color:#333333;padding:10px 0;color:#fff;font-size:14px;line-height:12px;;">
				<p>客戶服務專線：<?php $contact_phone = config_item('contact_phone');echo isset($contact_phone[0])?$contact_phone[0]['phone']:'';?> 傳真：<?php $contact_fax = config_item('contact_fax');echo isset($contact_fax[0])?$contact_fax[0]['fax']:'';?></p>
				<p>服務時間：週一週一~六 8:00~18:00</p>
				<p>鉅灣企業有限公司　　地址：台灣省新北市汐止區福德一路433號3樓</p>
				<p>Copyright © since 2018 fishing-wefox All Rights Reserved.</p>
			</div>
		</div>
	</div>
</body>
</html>
<?php //end of file /member/mail_view.php