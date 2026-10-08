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
			
				<div class="panel">
                <div class="panel-header header-line">
                  <h3><strong>網站快取機制與更新快取的方式</strong></h3>
                </div>
                <div class="panel-content">
<pre>

		系統為維護搜尋效能與減少資源占用，採用快取的方式進行資料的儲存
		以下幾個部分為快取
		1.首頁左方的選單列表		(當選單進行異動時會自動更新)
		2.學習網上方的選單列表		(當學習網選單進行異動時會自動更新)
		3.首頁區塊資料			(當商品或首頁區塊進行異動時會自動更新)
		4.首頁Banner資料			(當首頁Banner資料異動時會自動更新)
		5.學習網Banner資料		(當學習網Banner資料異動時自動更新)
		6.首頁meta			(首頁meta異動時自動更新)
		7.學習網meta			(學習網meta異動時自動更新)
		8.搜尋(關鍵字)			(當使用者搜尋過關鍵字後，自動記錄上次查詢的結果，當商品、學習網的內容管理更新時，移除所有快取)
		9.搜尋(網址產生器)		(當使用者點選過，該網址執行過後，自動記錄查詢的結果，當商品更新時，移除所有快取)
		10.學習網主項目			(當使用者點選過，該網址執行過後，自動記錄查詢的結果，當學習網的主項目與內容管理更新時，移除所有快取)
		11.學習網列表與內容		(當使用者點選過，該網址執行過後，自動記錄查詢的結果，當學習網的內容管理更新時，移除所有快取)
		
</pre>
                </div>
              </div>

				<div class="panel">
                <div class="panel-header header-line">
                  <h3><strong>Banner管理</strong></h3><h4>主站管理 > Banner管理 , 學習網 > Banner管理</h4>
                </div>
                <div class="panel-content">
<pre>

		後端管理有兩個部分有Banner管理
			1.主站管理 > Banner管理
			2.學習網管理 > Banner管理
		Banner管理的部分可以使用Youtube的影片連結，填寫時填入Youtube網址或者網址後方的ID
		
		※注意：如果圖片跟Youtube網址欄位皆填寫時將以Youtube網址為主，圖片將不會存入資料庫
		
</pre>
                </div>
              </div>
				<div class="panel">
                <div class="panel-header header-line">
                  <h3><strong>選單管理</strong></h3><h4>主站管理 > 選單管理 , 學習網 > 選單管理</h4>
                </div>
                <div class="panel-content">
<pre>

		"主站管理"中的選單管理，即是編輯首頁左方的選單，選單可以新增、重新命名、刪除、修改連結網址
		
		以上面大部分的選項 例如：鑽石 > 鑽石種類 > 兩用款
		此頁面選項是要連結到"搜尋"功能產生的網址
		此部分系統有將規劃時給的資料建立好，若分類有異動，或者抓取的字詞有錯誤時，可以使用"搜尋網址產生器"來產生需要的網址
		
		下面部分的選項 例如：關於侏儸紀彩色鑽石 > 品牌故事
		這些頁面是屬於"獨立頁面"
		請到後台管理中的"獨立頁面"進行管理編輯
		再將網址複製到"選單管理"的連結網址
		
		另外 168珠寶買賣網為外部網頁連結，一樣直接在選單管理中進行網址的設定即可
		
		※注意：修改完時，請選擇儲存變更，否則系統將不會覆蓋快取檔案
		※注意：聯絡我們與首頁的頁面是固定的，而並非是由其他功能產生
		
		
		
		"學習網"中的"選單管理"，則是"寶石學習與投資"中，上方的選單列表，一樣可以新增、重新命名、刪除、修改連結網址
		
		此區塊與上述相同，可以自由的設定網址
		而按照系統規劃，有一部分是以列表頁呈現，列表頁的項目則必須到後台 學習網 > 主項目管理 中建立新的主項目
		建立之後會產生對應的網址，再將網址複製到"選單管理"中貼上
		其他部分皆可使用獨立頁面的方式進行
		
		
		※注意：修改完時，請選擇儲存變更，否則系統將不會覆蓋快取檔案
		※注意：學習網中的圖片區塊，請使用 學習網 > 學習網首頁 進行管理
		
</pre>
                </div>
              </div>
				<div class="panel">
                <div class="panel-header header-line">
                  <h3><strong>主站管理</strong></h3><h4>主站管理 > 主站管理</h4>
                </div>
                <div class="panel-content">
<pre>

		主站管理分為兩個部分
			1.首頁META管理
			2.首頁區塊管理
		
		首頁META管理包含了 Title 、 Title End 、 Author 、 Description 、 Keywords
		
		Title 為首頁的標題
		
		Title End 為網站的標題尾巴
			例如 聯絡我們 - 侏羅紀彩色鑽石 | 彩鑽寶石的專家 ← -號(含)之後為標題尾巴
			※主網全域適用，在不同頁面都會套用
		
		Author 網站meta 表示網站的作者
			※主網全域適用，在不同頁面都會套用
		
		Description 網站描述
			此部分不會套用到主網全域，但若該頁面未設定description(空值時)，則依照此處設定
			
		Keywords 網站關鍵字
			此部分不會套用到主網全域，但若該頁面未設定description(空值時)，則依照此處設定
		
		※注意：當此處未設定時，會以系統config檔為基本設定
		
		首頁區塊管理的部分為網站首頁下方的區塊管理
		除了預設最上方會呈現新品的區塊外，可以手動新增刪除區塊
		
		區塊版型分為三種
		
			1. 4商品+1滑動
				此版型為四樣商品並列2*2的樣式，多餘的資料會以左右滑動區塊呈現，不可以選更多商品
				
			2. 8商品+1圖片
				此版型為右下角小縮圖，而固定呈現8比的資料，可以點選更多商品
				
			3. 1圖片
				大圖呈現，可能是活動Banner或者產品敘述，可以點選更多商品
			
			欄位說明：
				區塊名稱：
					會顯示在板型上面
				類型：
					上述三項版型選擇
				更多商品連結：
					點選更多商品的連結
				圖片：
					圖片
				圖片ALT：
					ALT，供SEO優化
				圖片URL：
					若需要圖片網址則輸入，空值時會以#取代
				商品列表：
					輸入時請用換行符區隔，資料則輸入商品編號(注意！非此網站給的ID，而是建檔時的商品編號，且該商品編號應為唯一)
		
</pre>
                </div>
              </div>
				<div class="panel">
                <div class="panel-header header-line">
                  <h3><strong>學習網首頁</strong></h3><h4>學習網 > 學習網首頁</h4>
                </div>
                <div class="panel-content">
<pre>

		學習網首頁使用後台編輯器編輯，可以增加移除部分物件，若要設定圖片連結，請在SetLink上方的輸入框貼入網址後，點選SetLink
		
		※注意：後台編輯器的插入圖片採用Base64編碼，檔案越大會影響頁面載入的速度，建議圖片上傳前先進行壓縮至需要的比例再上傳
		※注意：編輯後請點選頁面下方的儲存按鈕，系統才會更新至前台
		
</pre>
                </div>
              </div>
				<div class="panel">
                <div class="panel-header header-line">
                  <h3><strong>學習網管理</strong></h3><h4>學習網 > 學習網管理</h4>
                </div>
                <div class="panel-content">
<pre>

		學習網管理包含了 Title 、 Title End 、 Author 、 Description 、 Keywords
		
		Title 為學習網的標題
		
		Title End 為學習網的標題尾巴
			例如 圖書出版 - 侏羅紀彩色鑽石 | 彩鑽寶石的專家 ← -號(含)之後為標題尾巴
			※學習網全域適用，在不同頁面都會套用
		
		Author 網站meta 表示網站的作者
			※學習網全域適用，在不同頁面都會套用
		
		Description 網站描述
			此部分不會套用到學習網全域，但若該頁面未設定description(空值時)，則依照此處設定
			
		Keywords 網站關鍵字
			此部分不會套用到學習網全域，但若該頁面未設定description(空值時)，則依照此處設定
		
		※注意：當此處未設定時，會以主站設定為優先，再以系統config檔為基本設定
		
</pre>
                </div>
              </div>
				<div class="panel">
                <div class="panel-header header-line">
                  <h3><strong>主項目管理</strong></h3><h4>學習網 > 主項目管理</h4>
                </div>
                <div class="panel-content">
<pre>

		主項目管理為學習網的大項目管理，簡單說就是列表頁的分類，例如媒體焦點就是列表頁的一個主項目
		您可以在此處新增與管理列表頁
		
</pre>
                </div>
              </div>
			  <div class="panel">
                <div class="panel-header header-line">
                  <h3><strong>內容管理</strong></h3><h4>學習網 > 內容管理</h4>
                </div>
                <div class="panel-content">
<pre>

		內容管理就是管理學習網內的影音，當您建立過主項目之後，才能在此處新增完內容之後歸納至某個主項目下
		此處可以新增youtube影片，或者以圖文的方式呈現，若您上傳Youtube之後，在上傳圖片，在列表清單會呈現您上傳的圖片
		
		※注意：Youtube影音與圖片至少擇一，若有上傳圖片列表頁顯示以圖片為主，若未上傳圖片則使用youtube縮圖
		
		
</pre>
                </div>
              </div>
			  <div class="panel">
                <div class="panel-header header-line">
                  <h3><strong>獨立頁面</strong></h3><h4>獨立頁面</h4>
                </div>
                <div class="panel-content">
<pre>

		此處可以新增獨立頁面的區塊，此處也可以管理獨立頁面的 Description 與 Keywords
		並且使用後台編輯器編輯頁面
		
		※注意：後台編輯器的插入圖片採用Base64編碼，檔案越大會影響頁面載入的速度，建議圖片上傳前先進行壓縮至需要的比例再上傳
		※注意：編輯後請點選頁面下方的儲存按鈕，系統才會更新至前台
		
</pre>
                </div>
              </div>
			  <div class="panel">
                <div class="panel-header header-line">
                  <h3><strong>寶石管理</strong></h3><h4>寶石管理</h4>
                </div>
                <div class="panel-content">
<pre>

		此處為寶石資料的上架、管理區，其中
			1.寶石名稱
			2.寶石編號(唯一)
			3.主要分類
			4.次要分類
			5.主要圖片
			這五項為必填欄位，而主要圖片也會是網站列表時的縮圖
			次要圖片則要到商品明細頁才看的到
			而敘述圖片，則是要商品在列表排第一位時，才會顯示，若未設定則會用系統預設圖片
			
		※注意：若未設定之欄位，系統會在商品頁自動隱藏該資訊
		
</pre>
                </div>
              </div>
			  <div class="panel">
                <div class="panel-header header-line">
                  <h3><strong>聯絡我們/預約鑑賞</strong></h3><h4>聯絡我們/預約鑑賞</h4>
                </div>
                <div class="panel-content">
<pre>

		此處是當有客人提交聯絡我們、預約鑑賞時，會自動在此區呈現，包含後台的右上角(會呈現未處理的部分)
		當有客人提交時，會自動發信給所有的後台管理者信箱
		而當您處理過，可以在此處將該筆資料勾選已處理，就不會在後台的右上角繼續出現了
		
		※預約鑑賞的店面選單，目前以後台config的方式記錄，若需要新增修改請洽系統管理員
		
</pre>
                </div>
              </div>
			  <div class="panel">
                <div class="panel-header header-line">
                  <h3><strong>搜尋網址產生器</strong></h3><h4>搜尋網址產生器</h4>
                </div>
                <div class="panel-content">
<pre>

		此處可以使用不同的參數來產生寶石的列表頁，在不同條件下，A並且B，兩者都需要滿足
		例如：
			主項目：鑽石
			次項目：戒指
			主石：黃鑽
			表示搜尋出的商品必須符合鑽石、戒指、黃鑽三個條件
		
</pre>
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
	<?php $this->load->view('control/modal/edit_menu');?>
		
	<script src="/assets/admin/layout1/js/layout.js"></script>
	
    </body>
</html>
