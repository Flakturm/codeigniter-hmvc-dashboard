		<!-- START Template Header -->
        <header id="header" class="navbar">
            <!-- START navbar header -->
            <div class="navbar-header">
                <!-- Brand -->
                <div class="navbar-brand">
                    <img src="<?php echo base_url() . 'theme/img/logo/' . $site_logo ?>" class="img-responsive center-block">
                </div>
                <!--/ Brand -->
            </div>
            <!--/ END navbar header -->

            <!-- START Toolbar -->
            <div class="navbar-toolbar clearfix">
                <!-- START Right nav -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Profile dropdown -->
                    <li class="dropdown profile">
                        <a href="<?php echo site_url('admin/users/account'); ?>" class="dropdown-toggle dropdown-hover" data-toggle="dropdown">
                            <span class="meta">
                                <span class="text hidden-xs hidden-sm pl5">Hi! <?php echo $currentuser->user_nicename; ?></span>
                                <span class="caret"></span>
                            </span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo site_url('admin/users/account'); ?>"><span class="icon"><i class="ico-cog4"></i></span> Profile Setting</a></li>
                            <li><a href="<?php echo site_url('admin/logout'); ?>"><span class="icon"><i class="ico-exit"></i></span> Sign Out</a></li>
                        </ul>
                    </li>
                    <!-- Profile dropdown -->
                </ul>
                <!--/ END Right nav -->
            </div>
            <!--/ END Toolbar -->
        </header>
        <!--/ END Template Header -->

        <!-- START Template Sidebar (Left) -->
        <aside class="sidebar sidebar-left sidebar-menu">
            <!-- START Sidebar Content -->
            <section class="content slimscroll">
                <!-- START Template Navigation/Menu -->
                <ul class="topmenu topmenu-responsive" data-toggle="menu">
                	<?php foreach($items as $item): ?>
						<li<?php echo ($current == $item->url)? ' class="active open"':''; ?>>
							<a href="<?php echo site_url('admin/' . $item->url); ?>">
							    <span class="figure"><i class="ico-<?php echo $item->icon; ?>"></i></span>
	                            <span class="text"><?php echo $item->name; ?></span>
	                        </a>
						</li>
					<?php endforeach; ?>
                </ul>
                <!--/ END Template Navigation/Menu -->
            </section>
            <!--/ END Sidebar Container -->
        </aside>
        <!--/ END Template Sidebar (Left) -->