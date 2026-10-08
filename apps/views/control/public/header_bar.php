<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
          <div class="header">
            <h2><strong><?php echo $page_title['title'];?></strong></h2>
            <div class="breadcrumb-wrapper">
              <ol class="breadcrumb">
			  <?php foreach($page_title['bread_crumb'] as $key => $val){?>
				<li><a href="<?php echo $val;?>"><?php echo $key;?></a></li>
			  <?php }?>
              </ol>
            </div>
          </div>