<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
        <!-- BEGIN TOPBAR -->
        <div class="topbar">
          <div class="header-left">
            <div class="topnav">
			<a class="menutoggle" href="#" data-toggle="sidebar-collapsed"><span class="menu__handle"><span>Menu</span></span></a>
              <ul class="nav nav-icons">
              </ul>
            </div>
          </div>
          <div class="header-right">
            <ul class="header-menu nav navbar-nav">
			
			<?php /*
			<li class="dropdown" id="messages-header">
                <a href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                <i class="icon-star"></i>
                <span class="badge badge-primary badge-header" id="order_message_count">
                0
                </span>
                </a>
                <ul class="dropdown-menu">
                  <li class="dropdown-header clearfix">
                    <p class="pull-left" id="order_message_count_word">
                     
                    </p>
                  </li>
                  <li class="dropdown-body">
                    <ul class="dropdown-menu-list withScroll mCustomScrollbar _mCS_9" data-height="220" style="height: 220px;"><div class="mCustomScrollBox mCS-light" id="mCSB_9" style="position:relative; height:100%; overflow:hidden; max-width:100%;"><div id="order_message_list" class="mCSB_container mCS_no_scrollbar" style="position:relative; top:0;">

                    </div><div class="mCSB_scrollTools" style="position: absolute; display: none; opacity: 0;"><div class="mCSB_draggerContainer"><div class="mCSB_dragger" style="position: absolute; height: 159px; top: 0px;" oncontextmenu="return false;"><div class="mCSB_dragger_bar" style="position: relative; line-height: 159px;"></div></div><div class="mCSB_draggerRail"></div></div></div></div></ul>
                  </li>
                  <li class="dropdown-footer clearfix">
                    <a href="/control/signup.html" class="pull-left">查看全部報名資料</a>
                    <a href="/control/signup.html" class="pull-right">
                    <i class="icon-settings"></i>
                    </a>
                  </li>
                </ul>
              </li>
			  */ ?>
			  
			<li class="dropdown" id="messages-header">
                <a href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                <i class="icon-paper-plane"></i>
                <span class="badge badge-primary badge-header" id="contact_message_count">
                0
                </span>
                </a>
                <ul class="dropdown-menu">
                  <li class="dropdown-header clearfix">
                    <p class="pull-left" id="contact_message_count_word">
                     
                    </p>
                  </li>
                  <li class="dropdown-body">
                    <ul class="dropdown-menu-list withScroll mCustomScrollbar _mCS_9" data-height="220" style="height: 220px;"><div class="mCustomScrollBox mCS-light" id="mCSB_9" style="position:relative; height:100%; overflow:hidden; max-width:100%;"><div id="contact_message_list" class="mCSB_container mCS_no_scrollbar" style="position:relative; top:0;">

                    </div><div class="mCSB_scrollTools" style="position: absolute; display: none; opacity: 0;"><div class="mCSB_draggerContainer"><div class="mCSB_dragger" style="position: absolute; height: 159px; top: 0px;" oncontextmenu="return false;"><div class="mCSB_dragger_bar" style="position: relative; line-height: 159px;"></div></div><div class="mCSB_draggerRail"></div></div></div></div></ul>
                  </li>
                  <li class="dropdown-footer clearfix">
                    <a href="/control/contact.html" class="pull-left">查看全部聯絡我們</a>
                    <a href="/control/contact.html" class="pull-right">
                    <i class="icon-settings"></i>
                    </a>
                  </li>
                </ul>
              </li>
			
			
              <li class="dropdown" id="user-header">
                <a href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                <span class="username">Hi, <?php echo $this->session_model->get_session('name');?></span>
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <a href="/"><i class="icon-home"></i><span>前台</span></a>
                    <a href="/control/login/out"><i class="icon-logout"></i><span>登出</span></a>
                  </li>
                </ul>
              </li>

            </ul>
          </div>
          <!-- header-right -->
        </div>
        <!-- END TOPBAR -->