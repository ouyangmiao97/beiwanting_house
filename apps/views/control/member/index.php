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
						<h2 class="panel-title">查詢</h2>
					</div>
					<div class="panel-body bg-black">
						<p>請輸入會員查詢的條件，可以是會員ID、帳號、姓名、電話、手機、居住地、國家</p>
						<form action="<?php echo site_url('control/member/index');?>" method="get" autocomplete="off">
						<label for="input-key" class="control-label col-md-3">搜尋：</label>
						<div class="col-md-9 prepend-icon">
							<input type="input" id="input-key" name="key" class="form-control"/>
						</div>
						<div class="col-md-12 m-t-10">
							<div class="text-right">
							<input type="submit" class="btn btn-primary" value="查詢" />
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
						<h3><i class="icon-user"></i>  <?php echo !isset($_GET['key'])?'<strong>帳號列表</strong>':'<strong>查詢結果</strong>';?> </h3>
						<a href="/control/member/add" class="btn btn-dark btn-square">新增會員</a>
						<?php echo !isset($_GET['key'])?'<p class="text-danger">※預設顯示最新兩百筆註冊資料，若要查詢舊資料請使用搜尋</p>':'';?>
					</div>
					<div class="panel-content">
					  <table class="table table-hover table-dynamic">
						<thead>
						  <tr>
							<th width="5%">ID</th>
							<th width="20%">帳號</th>
							<th width="5%">FB</th>
							<th width="10%">會員編號</th>
							<th width="10%">名稱</th>
							<th width="10%">狀態</th>
							<th width="10%">電話</th>
							<th width="10%">手機</th>
							<th width="10%">註冊時間</th>
							<th width="15%">操作</th>
						  </tr>
						</thead>
						<tbody>
							<?php if (isset($member_list) && is_array($member_list) && count($member_list) > 0){?>
							<?php foreach($member_list as $key => $row){?>
							<tr>
								<td><?php echo $row->id;?></td>
								<td><?php echo $row->isfb==0?$row->login:$row->login . '(' . $row->fb_mail . ')';?></td>
								<td><?php echo $row->isfb==0?'否':'是';?></td>
								<td><?php echo $row->member_no;?></td>
								<td><?php echo $row->name;?></td>
								<td><?php echo $member_active_list[$row->active];?></td>
								<td><?php echo $row->phone;?></td>
								<td><?php echo $row->mobile;?></td>
								<td><?php echo $row->create_at;?></td>
								<td><div class="text-right">
									<a class="edit btn btn-sm btn-default" href="<?php echo site_url('control/member/detail/' . $row->id);?>" target="_blank">明細</a>
									<a class="edit btn btn-sm btn-default" href="<?php echo site_url('control/member/edit/' . $row->id);?>">修改</i></a>
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
	$(function(){
		var table = $('.table-dynamic').DataTable();
		table.order([ 0 , "desc"]).page.len(100).draw();
	});
	</script>
    </body>
</html>
