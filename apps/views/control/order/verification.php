<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"></meta>
  <title>會員缺貨通知</title>
</head>
<body style="">
  <div class="main" style="margin: 50px auto;width:800px;text-align:left;font-family: '微軟正黑體';font-size: 16px;font-weight: normal;color:#555">
    <div class="container" style="width:100%;height:auto;">
      <div class="header" style="background-color:#333333;height:30px;"></div>
      <div class="logo-bar" style="text-align:center"><img style="height:150px;width:auto;margin-top:15px;margin-bottom:15px" src="<?php echo site_url();?>images/mail_WEFOXlogo.jpg" alt="WEFOX LOGO" /></div>
    
      <div class="header" style="background-color:#333333;height:30px;">
        <div class="btn" style="float:left;position:relative;width:200px;font-size: 14px;color:#fff;text-align:center;"><a style="color:#fff;text-decoration: none;line-height:30px;height:30px;" href="<?php echo site_url();?>" target="_blank">官網首頁</a></div>
        <div class="btn" style="float:left;position:relative;width:200px;font-size: 14px;color:#fff;text-align:center;"><a style="color:#fff;text-decoration: none;line-height:30px;height:30px;" href="<?php echo site_url();?>#contact" target="_blank">客服QA</a></div>
        <div class="btn" style="float:left;position:relative;width:200px;font-size: 14px;color:#fff;text-align:center;"><a style="color:#fff;text-decoration: none;line-height:30px;height:30px;" href="<?php echo site_url();?>#contact" target="_blank">聯絡我們</a></div>
        <div class="btn" style="float:left;position:relative;width:200px;font-size: 14px;color:#fff;text-align:center;"><a style="color:#fff;text-decoration: none;line-height:30px;height:30px;" href="<?php echo site_url();?>#about" target="_blank">關於北灣町</a></div>
      </div>
      
      <div class="body">



        <div class="body-left" style="width:380px;float:left;position:relative;padding:10px;">
          <h4>親愛的用戶您好：</h4>
          <p>因庫存調整中目前該商品缺貨請您耐心等待，可來電或是留言取消該筆訂單，若造成您的不便，深感抱歉。</p>

          <hr>
          <p>訂購人姓名:<?php echo $order->pay_name;?></p>
          <p>訂購人信箱:<?php echo $order->pay_email;?></p>          
          <p>訂單編號:<?php echo $order->order_id;?></p>
          <p>品名:<?php echo $name;?></p>
          <p>商品規格<?php echo $brand;?></p>
          <p>訂單日期:<?php echo $order->create_at;?></p>
          <p>訂單總額:<?php echo $order->total;?></p>

          <hr>
          <p class="text-center" style="text-align:center;">/**** 系統信件請勿直接回覆 ****/</p>
        </div>


        <div class="body-right" style="width:380px;float:left;padding:10px;">
          <img src="<?php echo site_url();?>images/logo2.jpg" width="100%" height="" alt="WEFOX" />
          <p style="margin-top:5px;font-size:10px;line-height:10px;text-align:right;">有問題請洽+886 2-2694-9116 E-mail:<?php $contact_mail = config_item('contact_mail');?><a style="color:#09f;text-decoration: none;" href="mailto:<?php echo isset($contact_mail[0])?$contact_mail[0]['mail']:'#';?>"><?php echo isset($contact_mail[0])?$contact_mail[0]['mail']:'#';?></a></p>
        </div>
      </div>





      <div class="footer text-center" style="text-align:center;padding:10px 0;color:#fff;font-size:14px;line-height:12px; background-color:#333333; width:100%; float:left">
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