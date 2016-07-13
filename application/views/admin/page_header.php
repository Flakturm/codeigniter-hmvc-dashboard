            <!-- Page Header -->
            <div class="page-header page-header-block">
                <div class="page-header-section">
                    <h4 class="title semibold"><?php echo (isset($top_level) ? $page_name : $child_page_name); ?></h4>
                </div>
                <div class="page-header-section">
                    <!-- Toolbar -->
                    <div class="toolbar">
                        <?php if( ! isset($top_level) ): ?>
                            <ol class="breadcrumb breadcrumb-transparent nm">
                                <li><a href="<?php echo base_url('admin/' . $root_page); ?>"><?php echo $page_name; ?></a></li>
                                <li class="active"><?php echo $child_page_name; ?></li>
                            </ol>
                        <?php elseif ( isset($has_add) ): ?>
                            <a href="<?php echo base_url('admin/' . $current); ?>/add">
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="tooltip" data-original-title="新增"><i class="ico-plus"></i></button>
                            </a>
                        <?php endif; ?>
                    </div>
                    <!--/ Toolbar -->
                </div>
            </div>
            <!-- Page Header -->