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
				<div class="panel">
					<div class="panel-header">
						<h3><i class="icon-layers"></i> 管理者 <strong>登入</strong> 紀錄 </h3>
					</div>
					<div class="panel-content">
					  <table class="table table-hover table-dynamic">
						<thead>
						  <tr>
							<th width="25%">ID</th>
							<th width="25%">帳號</th>
							<th width="25%">登入時間</th>
							<th width="25%">登入IP位置</th>
						  </tr>
						</thead>
						<tbody>
						<?php if (isset($data_list) && count($data_list) > 0){?>
						<?php foreach($data_list as $key => $row){?>
							<tr>
								<td><?php echo $row->id;?></td>
								<td><?php echo $row->login;?></td>
								<td><?php echo $row->create_at_time;?></td>
								<td><?php echo $row->ip_address;?></td>
							</tr>
						<?php }?>
						<?php }?>
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

	<!-- BEGIN PAGE SCRIPT -->
	<script src="/assets/global/plugins/datatables/jquery.dataTables.min.js"></script> <!-- Tables Filtering, Sorting & Editing -->
    <script src="/assets/global/js/pages/table_dynamic.js"></script>
	<!-- END PAGE SCRIPT -->
		
	<script src="/assets/admin/layout1/js/layout.js"></script>
	
    </body>
</html>
