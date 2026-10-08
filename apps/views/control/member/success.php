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
						<h3><i class="icon-user"></i>  <strong>已審會員列表</strong> </h3>
						<p class="text-danger">※顯示最近通過的一百筆，若要查詢更之前的會員，請使用會員查詢功能</p>
					</div>
					<div class="panel-content">
					  <table class="table table-hover table-dynamic">
						<thead>
						  <tr>
							<th width="10%">ID</th>
							<th width="20%">帳號</th>
							<th width="10%">會員編號</th>
							<th width="10%">名稱</th>
							<th width="10%">狀態</th>
							<th width="10%">電話</th>
							<th width="10%">手機</th>
							<th width="20%">操作</th>
						  </tr>
						</thead>
						<tbody>
							<?php if (isset($member_list) && is_array($member_list) && count($member_list) > 0){?>
							<?php foreach($member_list as $key => $row){?>
							<tr>
								<td><?php echo $row->id;?></td>
								<td><?php echo $row->login;?></td>
								<td><?php echo $row->member_no;?></td>
								<td><?php echo $row->name;?></td>
								<td><?php echo $member_active_list[$row->active];?></td>
								<td><?php echo $row->phone;?></td>
								<td><?php echo $row->mobile;?></td>
								<td><div class="text-right">
								<a class="edit btn btn-sm btn-default" href="<?php echo site_url('control/member/detail/' . $row->id);?>"><i class="icon-note"></i></a>
								<a class="verify btn btn-sm btn-default" href="#" data-id="<?php echo $row->id;?>">變更為未審</a>
								<a class="verify-false btn btn-sm btn-default" href="#" data-id="<?php echo $row->id;?>">退回審核</a>
								</div></td>
							</tr>
							<?php }}?>
						</tbody>
					  </table>
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
		$('.verify').click(function(){
			var member_id = $(this).data('id');
			
			$.post('/control/member/verify_post' , {'member_id' : member_id , 'active' : '0'} , function(response){
				if (response.status=='T')
				{
					alert(response.msg);
					location.reload();
				}
				else
				{
					alert(response.msg);
					return false;
				}
			} , 'json');
			
			return false;
		});
		$('.verify-false').click(function(){
			var member_id = $(this).data('id');
			
			$.post('/control/member/verify_post' , {'member_id' : member_id , 'active' : '-1'} , function(response){
				if (response.status=='T')
				{
					alert(response.msg);
					location.reload();
				}
				else
				{
					alert(response.msg);
					return false;
				}
			} , 'json');
			
			return false;
		});
	</script>
    </body>
</html>
