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
						<h3><i class="icon-user"></i>  <strong>帳號列表</strong> </h3>
					</div>
					<div class="panel-content">
					<button type="button" class="btn btn-dark btn-square" data-toggle="modal" data-target="#add_panel">新增帳號</button>
					  <table class="table table-hover table-dynamic">
						<thead>
						  <tr>
							<th width="10%">ID</th>
							<th width="15%">帳號</th>
							<th width="15%">名稱</th>
							<th width="20%">信箱</th>
							<th width="10%">權限等級</th>
							<th width="10%">建立時間</th>
							<th width="10%">上次登入</th>
							<th width="10%">操作</th>
						  </tr>
						</thead>
						<tbody>
							<?php if (isset($admin_list) && is_array($admin_list)){?>
							<?php foreach($admin_list as $key => $row){?>
							<tr>
								<td><?php echo $row->id;?></td>
								<td><?php echo $row->login;?></td>
								<td><?php echo $row->name;?></td>
								<td><?php echo $row->email;?></td>
								<td><?php echo $row->level;?></td>
								<td><?php echo $row->create_at;?></td>
								<td><?php echo $row->last_login_at;?></td>
								<td><div class="text-right"><a class="edit btn btn-sm btn-default" href="#" data-toggle="modal" data-target="#edit_panel"><i class="icon-note"></i></a> <a class="delete btn btn-sm btn-danger" href="#" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->name;?>"><i class="icons-office-52"></i></a></div></td>
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
	<?php $this->load->view('control/modal/add_admin');?>
	<?php $this->load->view('control/modal/edit_admin');?>

	<!-- BEGIN PAGE SCRIPT -->
    <script src="/assets/global/plugins/datatables/jquery.dataTables.min.js"></script> <!-- Tables Filtering, Sorting & Editing -->
    <script src="/assets/global/js/pages/table_dynamic.js"></script>
	<!-- END PAGE SCRIPT -->
		
	<script src="/assets/admin/layout1/js/layout.js"></script>
	<script>
	$('.delete').click(function(){
		var name = $(this).data('name');
		var id = $(this).data('id');
		
		if (confirm("確定要刪除" + name + "嗎？"))
		{
			$.ajax({
				url:'/control/admin/del_admin',
				type:'post',
				dataType:'json',
				data:{
					'id':id
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
				}
			});
			
			return false;
		}
		
		return false;
	});
	</script>
    </body>
</html>
