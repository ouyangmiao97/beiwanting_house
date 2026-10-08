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
              <div class="panel panel-default">
                <div class="panel-header bg-dark">
                  <h2 class="panel-title"> 首頁 <strong>META</strong> 管理 </h2>
                </div>
                <div class="panel-content bg-dark">
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <p>設定您的首頁meta資訊，個別頁面若抓不到Title、Description、Keywords時，使用首頁資料</p>
                      <br>
                      <form role="form" class="form-horizontal form-validation" action="/control/website/meta" method="post">
                        <div class="form-group">
                          <label class="col-sm-3 control-label">Title(網頁標題)
                          </label>
                          <div class="col-sm-9">
                            <input type="text" name="web_title" class="form-control" placeholder="例如：鑽石首選Jurassic Color Diamond" value="<?php echo isset($web_meta['web_title'])?$web_meta['web_title']:'';?>" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-3 control-label">Title End(標題尾巴) - 全站通用
                          </label>
                          <div class="col-sm-9">
                            <input type="text" name="web_title_end" class="form-control" placeholder="例如： - 侏羅紀彩色鑽石 | 彩鑽寶石的專家" value="<?php echo isset($web_meta['web_title_end'])?$web_meta['web_title_end']:'';?>" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-3 control-label">Author(網站發布者) - 全站通用
                          </label>
                          <div class="col-sm-9">
                            <input type="text" name="web_author" class="form-control" placeholder="例如：侏羅紀彩色鑽石" value="<?php echo isset($web_meta['web_author'])?$web_meta['web_author']:'';?>" required>
                          </div>
                        </div>
						<div class="form-group">
                          <label class="col-sm-3 control-label">Description(網站描述)
                          </label>
                          <div class="col-sm-9">
                            <input type="text" name="web_description" class="form-control" placeholder="例如：鑽石彩鑽的專家，來自礦區直營，各式稀有鑽石彩鑽和彩色寶石，專屬設計師提供訂製鑽石手鍊，鑽石耳環，鑽石項鍊，鑽石戒指及其他彩寶客製化服務。擁有全世界最稀有的各式鑽石彩鑽收藏，也與全世界各地的鑽石寶石鑑定中心緊密合作，提供專業的珠寶需求。" value="<?php echo isset($web_meta['web_description'])?$web_meta['web_description']:'';?>" required>
                          </div>
                        </div>
						<div class="form-group">
                          <label class="col-sm-3 control-label">Keywords(網站關鍵字、相關字詞)
                          </label>
                          <div class="col-sm-9">
                            <input type="text" name="web_keywords" class="form-control" placeholder="例如：彩鑽,鑽石,翡翠,寶石,GIA,鑽戒,侏羅紀寶石,侏羅紀彩色鑽石,結婚鑽戒,婚戒,天然寶石" value="<?php echo isset($web_meta['web_keywords'])?$web_meta['web_keywords']:'';?>" required>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-9 col-sm-offset-3">
                            <div class="pull-right">
                              <button type="submit" class="btn btn-embossed btn-primary m-r-20">儲存</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
				<div class="panel">
					<div class="panel-header">
						<h3><i class="icon-layers"></i> 首頁 <strong>區塊</strong> 管理 </h3>
					</div>
				<div class="panel panel-default">
					<div class="panel-header">
						<h3><i class="icon-user"></i>  <strong>區塊列表</strong> </h3>
					</div>
					<div class="panel-content">
					<button type="button" class="btn btn-dark btn-square" data-toggle="modal" data-target="#add_panel">新增區塊</button>
					  <table class="table table-hover table-dynamic">
						<thead>
						  <tr>
							<th width="10%">ID</th>
							<th width="15%">區塊名稱</th>
							<th width="15%">版型</th>
							<th width="10%">操作</th>
						  </tr>
						</thead>
						<tbody>
							<?php if (isset($data_list) && is_array($data_list)){?>
							<?php foreach($data_list as $key => $row){?>
							<tr>
								<td><?php echo $row->id;?></td>
								<td><?php echo $row->title;?></td>
								<td><?php echo $column_type_list[$row->type];?></td>
								<td><div class="text-right"><a class="edit btn btn-sm btn-default" href="#" data-toggle="modal" data-target="#edit_panel"><i class="icon-note"></i></a> <a class="delete btn btn-sm btn-danger" href="#" data-id="<?php echo $row->id;?>" data-title="<?php echo $row->title;?>"><i class="icons-office-52"></i></a></div></td>
							</tr>
							<?php }}?>
						</tbody>
					  </table>
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
	<?php $this->load->view('control/modal/add_column');?>
	<?php $this->load->view('control/modal/edit_column');?>

	<!-- BEGIN PAGE SCRIPT -->
    <script src="/assets/global/plugins/datatables/jquery.dataTables.min.js"></script> <!-- Tables Filtering, Sorting & Editing -->
    <script src="/assets/global/js/pages/table_dynamic.js"></script>
    <script src="/assets/global/plugins/switchery/switchery.min.js"></script> <!-- IOS Switch -->
    <script src="/assets/global/plugins/bootstrap-tags-input/bootstrap-tagsinput.min.js"></script> <!-- Select Inputs -->
    <script src="/assets/global/plugins/dropzone/dropzone.min.js"></script>  <!-- Upload Image & File in dropzone -->
    <script src="/assets/global/js/pages/form_icheck.js"></script>  <!-- Change Icheck Color - DEMO PURPOSE - OPTIONAL -->
	<!-- END PAGE SCRIPT -->
		
	<script src="/assets/admin/layout1/js/layout.js"></script>
	
    </body>
	<script>
	$('.delete').click(function(){
		var title = $(this).data('title');
		var id = $(this).data('id');
		
		if (confirm("確定要刪除" + title + "嗎？"))
		{
			$.ajax({
				url:'/control/website/del_column',
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
</html>
