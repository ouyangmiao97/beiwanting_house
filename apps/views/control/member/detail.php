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
					<div class="panel-header bg-dark">
						<h2 class="panel-title">會員資料</h2>
					</div>
					<div class="panel-body bg-black">
					<?php if (isset($member) && is_object($member)){?>
						<p>ID：<?php echo $member->id;?></p>
						<p>帳號：<?php echo $member->login;?></p>
						<?php if ($member->isfb == 1){?>
						<p>FB信箱：<?php echo $member->fb_mail;?></p>
						<?php }?>
						<p>會員編號：<?php echo $member->member_no;?></p>
						<p>名稱：<?php echo $member->name;?></p>
						<p>狀態：<?php echo $member_active_list[$member->active];?></p>
						<p>電話：<?php echo $member->phone;?></p>
						<p>手機：<?php echo $member->mobile;?></p>
						<p>居住地址：<?php echo $member->address;?></p>
						<p>都市：<?php echo $member->city;?></p>
						<p>國家：<?php echo $member->country;?></p>
						<p>上次登入時間：<?php echo $member->last_login;?></p>
						<?php /*<p>驗光地點：<?php $member->optometry_place;?></p>
						<p>驗光場所：<?php echo $member->optometry_info;?></p>
						<p>處方簽：<?php echo $member->prescription;?></p>
						<p>驗證碼：<?php echo $member->verify_code;?></p>
						
						<p>忘記密碼：<?php echo $member->forget_hash_code;?></p>
						<p>忘記密碼時間：<?php echo $member->forget_time;?></p>*/?>
						<hr>
						
						<?php /*
						<label>驗光資訊</label>
						<p>驗光地點：<?php echo $member->optometry_place;?></p>
						<p>驗光場所名稱：<?php echo $member->optometry_info;?></p>
						<p>左眼度數：<?php echo $member->degree_left;?></p>
						<p>右眼度數：<?php echo $member->degree_right;?></p>
						<p>處方簽：<?php echo $member->img_file != FALSE ? '<a href="/uploads/prescription/'.$member->img_file->file_name.'" target="_blank">點此</a>' : '處方簽未上傳';?></p>
						<button class="btn btn-primary btn-transparent" id="change_verify" data-id="<?php echo $member->id;?>">已驗證</button>
						<button class="btn btn-primary btn-transparent" id="change_noverify" data-id="<?php echo $member->id;?>">未驗證</button>
						<button class="btn btn-primary btn-transparent" id="change_delete" data-id="<?php echo $member->id;?>">刪除(停用)</button>
						<!--<button class="btn btn-primary btn-transparent" id="forget_passwd">忘記密碼</button>
						<button class="btn btn-primary btn-transparent" id="mail_verify">信箱驗證</button>
						<button class="btn btn-primary btn-transparent" id="send_message">傳送訊息</button>-->
						?*/?>
					<?php }?>
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
	
	<script>
	
		$('#change_verify').click(function(){
			
			var id = $(this).data('id');
			var active = 1;
			
			return change_active(id , active);
		});
		
		$('#change_noverify').click(function(){
			
			var id = $(this).data('id');
			var active = 0;
			
			return change_active(id , active);
		});
		
		$('#change_delete').click(function(){

			var id = $(this).data('id');
			var active = -1;
			
			return change_active(id , active);
		});
		
		function change_active(id , active)
		{
			$.ajax({
				url:'/control/member/change_member_active.html',
				type:'post',
				dataType:'json',
				data:{
					'id':id,
					'active':active
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
				},
				cache:false,
			});
			
			return false;
		}
	</script>
	
    </body>
</html>
