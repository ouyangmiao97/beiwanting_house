<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- BEGIN SIDEBAR -->
<div class="sidebar">
	<div class="logopanel">
		<h1>
			<a href="/control/home/index.html"></a>
		</h1>
	</div>
	<div class="sidebar-inner">

		<ul class="nav nav-sidebar">
		<?php 
			$menu_list = config_item('admin_menu');
			$uri = '/' . $this->uri->uri_string();
			
			foreach($menu_list as $key => $bigitem)
			{
				echo '<div class="menu-title">'.$bigitem['title'].'</div>';
				
				foreach($bigitem['smallitem'] as $kkey => $smallitem)
				{
					if (isset($smallitem['miniitem']) && is_array($smallitem['miniitem']))
					{
						$is_select = FALSE;
						foreach($smallitem['miniitem'] as $xkey => $xval)
						{
							if ($xval['url'] == $uri) $is_select = TRUE;
						}
						
						if ($is_select == TRUE)
						{
							echo '<li class="nav-parent active">';
						}
						else
						{
							echo '<li class="nav-parent">';
						}
						
						echo '<a href="#"><i class="'.$smallitem['iclass'].'"></i><span>'.$smallitem['title'].'</span> <span class="fa arrow active"></span></a>';
						echo '<ul class="children collapse">';
						
						foreach($smallitem['miniitem'] as $kkkey => $miniitem)
						{
							echo '<li';
							echo $miniitem['url']==$uri?' class="active"':'';
							echo '><a href="'.$miniitem['url'].'"> '.$miniitem['title'].'</a></li>';
						}
						
						echo '</ul>';
						echo '</li>';
					}
					else
					{
						echo '<li';
						echo $smallitem['url']==$uri?' class="active"':'';
						echo '><a href="'.$smallitem['url'].'"><i class="'.$smallitem['iclass'].'"></i>'.$smallitem['title'].'</a></li>';
					}
				}
			}
		?>

	</div>
</div>
<!-- END SIDEBAR -->