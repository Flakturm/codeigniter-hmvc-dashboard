        <div class="navbar-fixed-top">
            <!-- Navigation -->
            <nav class="navbar header-bg" role="navigation">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header header-fixed-left">
                        <a class="navbar-brand" href="<?php echo OFFICIAL_SITE; ?>" target="_blank"><img src="<?php echo base_url(); ?>theme/img/logo/fooriends-logo.png" alt="中國信託"></a>
                        <!-- Collect the nav links, forms, and other content for toggling -->
                    </div>
                <!-- /.navbar-collapse -->
                </div>
            <!-- /.container -->
            </nav>

            <!-- Navigation -->
            <nav class="navbar navbar-green" role="navigation">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right">
                            <?php foreach ( $menu_items as $value ): ?>                            
                                <li>
                                    <a href="<?php echo site_url('event/' . $value['slug']); ?>"><?php echo $value['category_name']; ?></a>
                                </li>
                                <li class="border-right-f"><span>|</span></li>
                            <?php endforeach; ?>
                            <li>
                                <a href="<?php echo site_url('search') ?>">訂單查詢</a>
                            </li>
                            <li class="border-right-f"><span>|</span></li>
                            <li>
                                <a href="<?php echo site_url('information') ?>">注意事項</a>
                            </li>
                            <li class="border-right-f"><span>|</span></li>
                            <li>
                                <a href="<?php echo site_url('contact') ?>">聯絡我們</a>
                            </li>
                            <li>
                                <a class="navbar-brand ml10" href="<?php echo OFFICIAL_SITE; ?>" target="_blank"><i class="fa fa-home fa-2 color-white" aria-hidden="true"></i></a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                </div>
                <!-- /.container -->
            </nav>
        </div>