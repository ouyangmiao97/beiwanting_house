<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="zh-Hant">
    <head>
        <?php $this->load->view('control/public/header');?>
		<link href="/assets/global/plugins/jstree/src/themes/default/style.min.css" rel="stylesheet">
		<style>
		.jstree-default .jstree-clicked {
			background-color:#CCC;
		}
		</style>
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
				<h3><strong>首頁左方選單清單</strong></h3>
				<p>編輯完成後請點選儲存變更，儲存變更後才會正式將選單儲存</p>
				<p>左鍵選擇需要編輯的選項，再點選操作功能，或是左鍵點選不放，進行拖拉排序</p>
				
				<br>
				<div>
					<button class="btn btn-primary btn-square" id="add_node">新增</button>
					<button class="btn btn-primary btn-square" id="edit_node">修改名稱</button>
					<button class="btn btn-primary btn-square" id="edit_node_info" data-toggle="modal" data-target="#edit_panel">修改網址</button>
					<button class="btn btn-danger btn-square" id="del_node">刪除</button>
					<button class="btn btn-success btn-square" id="reload_node">重新整理</button>
					<button class="btn btn-success btn-square" id="save_node" data-saveurl="/control/<?php echo $this->router->class;?>/edit_menu">儲存變更</button>
				</div>
				<div id="tree_menu"></div>
			</div>
		</div>
		<?php $this->load->view('control/public/footer_bar');?>
        </div>
        <!-- END PAGE CONTENT -->
      </div>
      <!-- END MAIN CONTENT -->
	  
	  
    </section>

	<?php $this->load->view('control/public/footer');?>
	<?php $this->load->view('control/modal/edit_menu');?>

	<!-- BEGIN PAGE SCRIPT -->
	<script src="/assets/global/plugins/jstree/jstree.min.js"></script> <!-- interactive trees -->
	<script src="/assets/global/plugins/bootstrap-loading/lada.min.js"></script> <!-- Buttons Loading State -->
	<!-- END PAGE SCRIPT -->
		
	<script>
	    /*  Tree with drag & drop  */
	$(function(){
		$('#tree_menu').jstree({
			"core" : {
			"check_callback" : true , 
			"data" : <?php echo json_encode($menu_list);?>
			},
			"plugins" : [ "dnd" ]
		});
	});
    
	</script>
		
	<script src="/assets/admin/layout1/js/layout.js"></script>
	
	<script src="/js/jstree/jstree.js"></script>
	
    </body>
</html>
