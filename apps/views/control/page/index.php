<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="zh-Hant">
    <head>
        <?php $this->load->view('control/public/header');?>
		<link href="/assets/global/plugins/jstree/src/themes/default/style.min.css" rel="stylesheet">
		<link href="/assets/global/plugins/dropzone/dropzone.min.css" rel="stylesheet">
		<link href="/assets/global/plugins/input-text/style.min.css" rel="stylesheet">
		<script src="/assets/global/plugins/modernizr/modernizr-2.6.2-respond-1.1.0.min.js"></script>
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
						<h3><i class="icon-layers"></i> 獨立 <strong></strong> 頁面 </h3>
					</div>
					<div class="panel-content">
					<button type="button" class="btn btn-dark btn-square" data-toggle="modal" data-target="#add_panel">新增頁面</button>
					  <table class="table table-hover table-dynamic">
						<thead>
						  <tr>
							<th width="10%">ID</th>
							<th width="15%">標題</th>
							<th width="20%">URL</th>
							<th width="20%">description</th>
							<th width="20%">keywords</th>
							<th width="15%">操作</th>
						  </tr>
						</thead>
						<tbody>
						<?php if (isset($data_list) && count($data_list) > 0){?>
						<?php foreach($data_list as $key => $row){?>
							<tr>
							<td><?php echo $row->id;?></td>
							<td><?php echo $row->title;?></td>
							<td><a href="<?php echo site_url();?>" target="_blank"><?php echo site_url();?></a></td>
							<td><?php echo $row->description;?></td>
							<td><?php echo $row->keywords;?></td>
							<td><div class="text-right"><a class="pedit btn btn-sm btn-default" href="<?php echo site_url('control/page/edit_page_html/' . $row->id);?>"><i class="fa fa-file-image-o"></i></a><a class="edit btn btn-sm btn-default" href="#" data-toggle="modal" data-target="#edit_panel"><i class="icon-note"></i></a> <a class="delete btn btn-sm btn-danger" href="#" data-id="<?php echo $row->id;?>" data-title="<?php echo $row->title;?>"><i class="icons-office-52"></i></a></div></td>
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
	<?php $this->load->view('control/modal/add_page');?>
	<?php $this->load->view('control/modal/edit_page');?>
	<!-- BEGIN PAGE SCRIPT -->
    <script src="/assets/global/plugins/datatables/jquery.dataTables.min.js"></script> <!-- Tables Filtering, Sorting & Editing -->
    <script src="/assets/global/js/pages/table_dynamic.js"></script>
    <script src="/assets/global/plugins/switchery/switchery.min.js"></script> <!-- IOS Switch -->
    <script src="/assets/global/plugins/bootstrap-tags-input/bootstrap-tagsinput.min.js"></script> <!-- Select Inputs -->
    <script src="/assets/global/plugins/dropzone/dropzone.min.js"></script>  <!-- Upload Image & File in dropzone -->
    <script src="/assets/global/js/pages/form_icheck.js"></script>  <!-- Change Icheck Color - DEMO PURPOSE - OPTIONAL -->
	<!-- END PAGE SCRIPT -->



		
	<script src="/assets/admin/layout1/js/layout.js"></script>
	<script>
	$('.delete').click(function(){
		var title = $(this).data('title');
		var id = $(this).data('id');
		
		if (confirm("確定要刪除" + title + "嗎？"))
		{
			$.ajax({
				url:'/control/page/del_page',
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
