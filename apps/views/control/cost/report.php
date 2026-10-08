<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="zh-Hant">
    <head>
        <?php $this->load->view('control/public/header');?>
		<script src="/assets/global/plugins/modernizr/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
    <body class="fixed-topbar fixed-sidebar theme-sdtl color-default">
     <section>
<?php $this->load->view('control/public/sidebar');?>
      <div class="main-content">

		<?php $this->load->view('control/public/topbar');?>
		
        <!-- BEGIN PAGE CONTENT -->
        <div class="page-content">
		<?php $this->load->view('control/public/header_bar');?>
		  <div class="row">
			<form action="<?php echo site_url('control/cost/report');?>" method="post">
				<div class="col-md-12">
				<div class="form-group">
					<label class="col-md-1 control-label">起始日期：</label>
					<div class="col-md-2"><input type="text" name="start_date" id="start_date" value="<?php echo $start_date;?>" class="form-control" /></div>
					<label class="col-md-1 control-label">結束日期：</label>
					<div class="col-md-2"><input type="text" name="end_date" id="end_date" value="<?php echo $end_date;?>" class="form-control" /></div>
					<button type="submit" class="btn btn-success btn-square">查詢</button>
				</div>
				</div>
			</form>
		  </div>
          <div class="row">
            <div class="col-sm-3">
              <h3><strong>支出</strong> </h3>
              <p>財務報表在這段時間內的支出項目</p>
              <canvas id="radar1" class="full" height="150"></canvas>
            </div>
			<div class="col-sm-3">
              <h3><strong>收入</strong> </h3>
              <p>財務報表在這段時間內的收入項目</p>
              <canvas id="radar2" class="full" height="150"></canvas>
            </div>
			
            <div class="col-sm-6">
              <h3><strong>支出與收入</strong> </h3>
              <p>財務報表在這段時間內的支出與收入項目</p>
              <div class="row">
                <div class="col-md-4">
                  <canvas id="pie-chart"></canvas>
                </div>
                <div class="col-md-4">
                  <canvas id="pie-chart2"></canvas>
                </div>
                <div class="col-md-4">
                  <canvas id="pie-chart3"></canvas>
                </div>
              </div>
            </div>
		</div>
			
          <div class="row m-t-40">

			
            <div class="col-sm-6">
              <h3><strong>支出</strong> </h3>
              <p>期間內每日支出的線條圖</p>
              <canvas id="line1"  class="full" height="140"></canvas>
			  
            </div>
            <div class="col-sm-6">
              <h3><strong>收入</strong> </h3>
              <p>期間內每日收入的線條圖</p>
              <canvas id="line2"  class="full" height="140"></canvas>
			  
            </div>
          </div>
		
		<?php $this->load->view('control/public/footer_bar');?>
		
        </div>
        <!-- END PAGE CONTENT -->
      </div>
      <!-- END MAIN CONTENT -->
	  
	  
    </section>

	<?php $this->load->view('control/public/footer');?>
	<?php $this->load->view('control/modal/add_cost');?>
	<?php $this->load->view('control/modal/edit_cost');?>

    <!-- BEGIN PAGE SCRIPT -->
    <script src="/assets/global/plugins/charts-chartjs/Chart.min.js"></script>  <!-- ChartJS Chart -->
    <?php /*<script src="/assets/global/js/pages/charts.js"></script>*/ ?>
    <!-- END PAGE SCRIPT -->	
		
	<script src="/assets/admin/layout1/js/layout.js"></script>
	<script>
	
		$(function() {
			$('#start_date').datepicker({
				dateFormat: "yy-mm-dd"
			});
			$('#end_date').datepicker({
				dateFormat: "yy-mm-dd"
			});
		});
	
      var radar1 = <?php echo json_encode($data_list->radar1);?>;
      var radar2 = <?php echo json_encode($data_list->radar2);?>;
	  var item1 = <?php echo json_encode($data_list->col1);?>;
	  var item2 = <?php echo json_encode($data_list->col2);?>;
	  var item3 = <?php echo json_encode($data_list->col3);?>;
	  var line1 = <?php echo json_encode($data_list->line1);?>;
	  var line2 = <?php echo json_encode($data_list->line2);?>;

      window.myRadar1 = new Chart(document.getElementById("radar1").getContext("2d")).Radar(radar1, {
        responsive: true,
        tooltipCornerRadius: 0
      });
	  
	  window.myRadar2 = new Chart(document.getElementById("radar2").getContext("2d")).Radar(radar2, {
        responsive: true,
        tooltipCornerRadius: 0
      });
	  
	 var ctx = document.getElementById("line1").getContext("2d");
      window.myLine = new Chart(ctx).Line(line1, {
        responsive: true,
        tooltipCornerRadius: 0
      });
	  
	 var ctx2 = document.getElementById("line2").getContext("2d");
      window.myLine = new Chart(ctx2).Line(line2, {
        responsive: true,
        tooltipCornerRadius: 0
      });
	  
      var ctx = document.getElementById("pie-chart").getContext("2d");
      window.myPie = new Chart(ctx).Pie(item1, {
        tooltipCornerRadius: 0
      });

      var ctx2 = document.getElementById("pie-chart2").getContext("2d");
      window.myPie = new Chart(ctx2).Pie(item2, {
        tooltipCornerRadius: 0
      });
      var ctx3 = document.getElementById("pie-chart3").getContext("2d");
      window.myPie = new Chart(ctx3).Pie(item3, {
        tooltipCornerRadius: 0

      });
	  
	</script>
    </body>
</html>
