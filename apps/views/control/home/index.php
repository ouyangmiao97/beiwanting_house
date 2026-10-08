<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="zh-Hant">
    <head>
        <?php $this->load->view('control/public/header');?>
	<link href="/assets/global/plugins/metrojs/metrojs.min.css" rel="stylesheet">
	<link href="/assets/global/plugins/maps-amcharts/ammap/ammap.min.css" rel="stylesheet">
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
				<div class="col-md-3">
					<div class="panel" style="padding:20px;">
						<span class="fa fa-child bd-full" style="font-size:50px;background-color:#09f;color:#fff;padding:5px 13px;position:absolute;"></span>
						<p class="text-right">今日瀏覽量</p>
						<p class="text-right"><?php echo end($total);?></p>
					</div>
				</div>
				<div class="col-md-3">
					<div class="panel" style="padding:20px;">
						<span class="fa fa-globe bd-full" style="font-size:50px;background-color:#09f;color:#fff;padding:5px 9px;position:absolute;"></span>
						<p class="text-right">今日桌機瀏覽量</p>
						<p class="text-right"><?php echo end($pc_r) + end($pc_n);?></p>
					</div>
				</div>
				<div class="col-md-3">
					<div class="panel" style="padding:20px;">
						<span class="fa fa-mobile bd-full" style="font-size:50px;background-color:#09f;color:#fff;padding:5px 20px;position:absolute;"></span>
						<p class="text-right">今日手機瀏覽量</p>
						<p class="text-right"><?php echo end($mobile_r) + end($mobile_n);?></p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<h3><strong>一週內瀏覽量  <i rel="popover" data-container="body" data-toggle="popover" data-placement="top" data-content="網站總請求次數為右方四項數字之加總。" data-original-title="" title="" class="glyphicon glyphicon-question-sign"></i></strong></h3>
				</div>
				<div class="col-md-6">
					<h3><strong>一週內裝置瀏覽量  <i rel="popover" data-container="body" data-toggle="popover" data-placement="top" data-content="圖表顏色參照下方圖表顏色及說明" data-original-title="" title="" class="glyphicon glyphicon-question-sign"></i></strong></h3>
				</div>
			</div>
		
			<div class="row">
				<div class="col-md-6">
					<canvas id="line-chart-pc" class="full" height="140"></canvas>
				</div>
				<div class="col-md-6">
					<canvas id="line-chart-mobile" class="full" height="140"></canvas>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-3">
					<h3><strong>PC裝置外部請求次數(90天)  <i rel="popover" data-container="body" data-toggle="popover" data-placement="top" data-content="透過他人網站、搜尋引擎的方式連線到此網站。" data-original-title="" title="" class="glyphicon glyphicon-question-sign"></i></strong></h3>
				</div>
				<div class="col-md-3">
					<h3><strong>PC裝置內部請求次數(90天)  <i rel="popover" data-container="body" data-toggle="popover" data-placement="top" data-content="直接輸入網址進入，或已進入網站，進行操作、不同頁面的切換，所造成的請求量。" data-original-title="" title="" class="glyphicon glyphicon-question-sign"></i></strong></h3>
				</div>
				<div class="col-md-3">
					<h3><strong>行動裝置外部請求次數(90天)  <i rel="popover" data-container="body" data-toggle="popover" data-placement="top" data-content="透過他人網站、搜尋引擎的方式連線到此網站。" data-original-title="" title="" class="glyphicon glyphicon-question-sign"></i></strong></h3>
				</div>
				<div class="col-md-3">
					<h3><strong>行動裝置內部請求次數(90天)  <i rel="popover" data-container="body" data-toggle="popover" data-placement="top" data-content="直接輸入網址進入，或已進入網站，進行操作、不同頁面的切換，所造成的請求量。" data-original-title="" title="" class="glyphicon glyphicon-question-sign"></i></strong></h3>
				</div>
			</div>
			
			<div class="row">
                <div class="col-md-3">
                  <div class="panel">
                    <div class="panel-content widget-small bg-blue">
                      <div class="title">
                        <h1>PC裝置的外部請求次數</h1>
                        <p>透過外站連結的造訪次數，例如使用者透過google搜尋引擎連結至本網站。</p>
                        <span></span>
                      </div>
                      <div class="content">
                        <div id="stock-report2-sm"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="panel">
                    <div class="panel-content widget-small bg-orange">
                      <div class="title">
                        <h1>PC裝置的內部請求次數</h1>
                        <p>透過內站連結的造訪次數，例如使用者透過首頁點選聯絡我們。</p>
                        <span></span>
                      </div>
                      <div class="content">
                        <div id="stock-report1-sm"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="panel">
                    <div class="panel-content widget-small bg-green">
                      <div class="title">
                        <h1>行動裝置的外部請求次數</h1>
                        <p>透過外站連結的造訪次數，例如使用者透過google搜尋引擎連結至本網站。</p>
                        <span></span>
                      </div>
                      <div class="content">
                        <div id="stock-report4-sm"></div>
                      </div>
                    </div>
                  </div>
                </div>	
                <div class="col-md-3">
                  <div class="panel">
                    <div class="panel-content widget-small bg-red">
                      <div class="title">
                        <h1>行動裝置的內部請求次數</h1>
                        <p>透過內站連結的造訪次數，例如使用者透過首頁點選聯絡我們。</p>
                        <span></span>
                      </div>
                      <div class="content">
                        <div id="stock-report3-sm"></div>
                      </div>
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
	
	<!-- BEGIN PAGE SCRIPT -->
    <script src="/assets/global/plugins/charts-highstock/js/highstock.min.js"></script> <!-- financial Charts -->
    <script src="/assets/global/plugins/charts-highstock/js/modules/exporting.min.js"></script> <!-- Financial Charts Export Tool -->
    <script src="/assets/global/plugins/maps-amcharts/ammap/ammap.min.js"></script> <!-- Vector Map -->
    <script src="/assets/global/plugins/maps-amcharts/ammap/maps/js/worldLow.min.js"></script> <!-- Vector World Map  -->
    <script src="/assets/global/plugins/maps-amcharts/ammap/themes/black.min.js"></script> <!-- Vector Map Black Theme -->
	<!-- END PAGE SCRIPT -->
	
	<script src="/assets/admin/layout1/js/layout.js"></script>
	
<script>
	var line_chart_pc = {
		labels : <?php echo json_encode($week_list);?>,
		datasets : [
          {
            label: "總瀏覽量",
            fillColor : "rgba(49, 157, 181,0.2)",
            strokeColor : "#319DB5",
            pointColor : "#319DB5",
            pointStrokeColor : "#fff",
            pointHighlightFill : "#fff",
            pointHighlightStroke : "#319DB5",
            data : <?php echo json_encode($total);?>
          },
		]
	}
	
	var line_chart_mobile = {
		labels : <?php echo json_encode($week_list);?>,
		datasets : [
          {
            label: "PC外來請求",
            fillColor : "rgba(0, 0, 255,0.2)",
            strokeColor : "#0000FF",
            pointColor : "#0000FF",
            pointStrokeColor : "#fff",
            pointHighlightFill : "#fff",
            pointHighlightStroke : "#0000FF",
            data : <?php echo json_encode($pc_r);?>
          },
          {
            label: "PC內部請求",
            fillColor : "rgba(255, 136, 0,0.2)",
            strokeColor : "#FF8800",
            pointColor : "#FF8800",
            pointStrokeColor : "#fff",
            pointHighlightFill : "#fff",
            pointHighlightStroke : "#FF8800",
            data : <?php echo json_encode($pc_n);?>,
          },
          {
            label: "Mobile外來請求",
            fillColor : "rgba( 0, 255, 0 ,0.2)",
            strokeColor : "#00FF00",
            pointColor : "#00FF00",
            pointStrokeColor : "#fff",
            pointHighlightFill : "#fff",
            pointHighlightStroke : "#00FF00",
            data : <?php echo json_encode($mobile_r);?>
          },
          {
            label: "Mobile內部請求",
            fillColor : "rgba(255, 0, 0 ,0.2)",
            strokeColor : "#FF0000",
            pointColor : "#FF0000",
            pointStrokeColor : "#fff",
            pointHighlightFill : "#fff",
            pointHighlightStroke : "#FF0000",
            data : <?php echo json_encode($mobile_n);?>,
          }
		]
	}
	
	var ctpc = document.getElementById("line-chart-pc").getContext("2d");
	var ctmobile = document.getElementById("line-chart-mobile").getContext("2d");
	
	window.myLine = new Chart(ctpc).Line(line_chart_pc, {
		responsive: true,
		tooltipCornerRadius: 0
	});
	window.myLine = new Chart(ctmobile).Line(line_chart_mobile, {
		responsive: true,
		tooltipCornerRadius: 0
	});
</script>

<script>
/**** Small Financial Widget ****/
function setSmallStockCharts(tabName, dataNumber) {
	var items = [<?php echo json_encode($report2);?>,<?php echo json_encode($report1);?>,<?php echo json_encode($report4);?>,<?php echo json_encode($report3);?>];
	var randomData = items[dataNumber];
	// console.log(items[dataNumber]);
	// Create the chart
	$('#stock-' + tabName + '-sm').highcharts('StockChart', {
		chart: {
			height: 149,
			plotBorderColor: '#C21414',
			plotBorderColor: '#C21414',
			backgroundColor: 'transparent',
			spacingRight: 0,
			spacingLeft: 0,
			spacingBottom: 0,
			spacingTop: 0,
			marginBottom: 0
		},
		credits: {
			enabled: false
		},
		colors: ['rgba(0,0,0,0.3)', 'rgba(0,0,0,0.3)'],
		exporting: {
			enabled: false
		},
		rangeSelector: {
			selected: 0,
			enabled: false
		},
		scrollbar: {
			enabled: false
		},
		navigator: {
			enabled: false
		},
		navigation: {
			buttonOptions: {
				enabled: false
			}
		},
		xAxis: {
			gridLineColor: 'transparent',
			gridLineColor: 'transparent',
			lineColor: 'transparent',
			tickColor: 'transparent',
			minorGridLineWidth: 0,
			labels: {
				enabled: false
			}
		},
		yAxis: {
			gridLineColor: 'transparent',
			gridLineColor: 'transparent',
			lineColor: 'transparent',
			labels: {
				enabled: false
			}
		},
		series: [{
			name: tabName,
			data: randomData,
			type: 'spline',
			tooltip: {
				valueDecimals: 2
			}
		}]
	});
}

setSmallStockCharts('report1' , 0);
setSmallStockCharts('report2' , 1);
setSmallStockCharts('report3' , 2);
setSmallStockCharts('report4' , 3);
</script>

    </body>
</html>
