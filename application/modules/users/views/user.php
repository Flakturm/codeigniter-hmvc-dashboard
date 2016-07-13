            <!-- START row -->
            <?php if ( $is_admin ): ?>
            <?php echo form_open(site_url('admin/' . $root_page), 'class="form-horizontal form-bordered ajax-form"'); ?>
            <?php endif; ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="row mb15">
                        <div class="col-md-10 message-container"></div>
                        <div class="col-md-2 text-right">
                            <?php if ( $is_admin ): ?>
                            <a href="<?php echo site_url('admin/' . $root_page); ?>" class="btn btn-default <?php echo (isset($user) AND $user->id == 1) ? '' : 'mr10';?>" data-toggle="tooltip" data-original-title="上一頁"><i class="ico-undo"></i></a>
                            <?php if ( isset($user) ): ?>
                                <?php if ( $user->id > 1): ?>
                                    <a data-href="<?php echo site_url('admin/' . $root_page) . '/delete/' . $user->id; ?>" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#confirm-delete" data-tooltip="true" data-original-title="解僱">
                                        <i class="ico-remove2"></i>
                                    </a>
                                <?php endif; ?>
                            <?php else: ?>
                                <button id="submit-btn" class="btn btn-success ladda-button" data-style="slide-right" data-toggle="tooltip" data-original-title="保存"><i class="ico-save"></i></button>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                            
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel">最後確認</h4>
                                </div>
                            
                                <div class="modal-body">
                                    <p>確定解僱此人員？</p>
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">算了</button>
                                    <a class="btn btn-danger btn-ok">掰掰</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- START panel -->
                    <div class="panel panel-default">
                        <!-- panel heading/header -->
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="ico-bubble-user mr5"></i>人員資料</h3>
                        </div>
                        <!--/ panel heading/header -->
                        <!-- panel body -->
                        <div class="panel-body">
                            <form class="form-horizontal form-bordered" action="">
                                <?php if ( isset($user) ): ?>
                                <div class="form-group">
                                   <label class="col-sm-3 control-label">ID#</label>
                                    <div class="col-sm-8">
                                        <p class="form-control-static"><?php echo $user->id;?></p>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <div class="form-group">
                                   <label class="col-sm-3 control-label">信箱</label>
                                    <div class="col-sm-8">
                                        <?php if ( isset($user) ): ?>
                                            <a href="" id="user_email" class="edit-txt" data-type="email" minlength="6" data-pk="<?php echo $user->id;?>"><?php echo $user->user_email; ?></a>
                                        <?php else : ?>
                                            <?php
                                            $data = array(
                                                    'name'  => 'user_email',
                                                    'class' => 'form-control',
                                                    'value' => set_value('user_email'),
                                                    'data-parsley-type' => 'email',
                                                    'data-parsley-required' => ''
                                            );
                                            echo form_input($data);
                                        ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                   <label class="col-sm-3 control-label">暱稱</label>
                                    <div class="col-sm-8">
                                        <?php if ( isset($user) ): ?>
                                            <a href="" id="user_nicename" class="edit-txt" data-type="text" data-pk="<?php echo $user->id;?>"><?php echo $user->user_nicename; ?></a>
                                        <?php else : ?>
                                            <?php
                                            $data = array(
                                                    'name'  => 'user_nicename',
                                                    'class' => 'form-control',
                                                    'value' => set_value('user_nicename'),
                                                    'data-parsley-required' => ''
                                            );
                                            echo form_input($data);
                                        ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                   <label class="col-sm-3 control-label">密碼</label>
                                    <div class="col-sm-8">
                                        <?php if ( isset($user) ): ?>
                                            <a href="" id="user_pass" class="edit-txt" data-type="password" data-pk="<?php echo $user->id;?>">更改</a>
                                        <?php else : ?>
                                            <div class="has-icon pull-left">
                                            <?php
                                            $data = array(
                                                    'name'  => 'user_pass',
                                                    'class' => 'form-control',
                                                    'value' => set_value('user_pass'),
                                                    'data-parsley-length' => '[6, 10]',
                                                    'data-parsley-required' => ''
                                            );
                                            echo form_password($data);
                                            ?>
                                            <i class="ico-lock2 form-control-icon"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php if ( $is_admin ): ?>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">權限設定</label>
                                    <div class="col-sm-8">
                                        <?php if ( isset($user) ): ?>
                                            <?php if ( $user->id == 1): ?>
                                                <p class="form-control-static"><?php echo $user->role_name;?></p>
                                            <?php else: ?>
                                                <a href="" id="role_id" data-type="select" data-url="<?php echo site_url('admin/'.$root_page.'/ajaxUpdate');?>" data-value="<?php echo $user->role; ?>" data-pk="<?php echo $user->id;?>" class="editable editable-click"><?php echo $user->role_name;?></a>
                                            <?php endif; ?>
                                        <?php else : ?>
                                            <?php echo form_dropdown('role_id', $roles, set_value('role_id'), 'class="form-control"'); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">狀態設定</label>
                                    <div class="col-sm-8">
                                        <?php if ( isset($user) ): ?>
                                            <a href="" id="user_status" data-type="select" data-url="<?php echo site_url('admin/'.$root_page.'/ajaxUpdate');?>" data-value="<?php echo $user->user_status; ?>" data-pk="<?php echo $user->id;?>" class="editable editable-click"><?php echo ($user->user_status) ? '啟用' : '停用';?></a>
                                        <?php else : ?>
                                            <?php echo form_dropdown('user_status', array(0 => '停用', 1 => '啟用'), set_value('user_status'), 'class="form-control"'); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </form>
                        </div>
                        <!-- panel body -->
                    </div>
                </div>
            </div>
            <?php if ( $is_admin ): ?>
            <?php echo form_close(); ?>
            <?php endif; ?>
            <!--/ END row -->
            <?php if ( isset($user) ): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    <?php $uri = ($is_admin)?$root_page:$this->uri->segment(2); ?>
                    var url = '<?php echo site_url('admin/'.$uri.'/ajaxUpdate');?>';
                    makeTextEditable($('.edit-txt'), url);

                    var source = new Array();
                    <?php
                    foreach ( $roles as $key => $value ): 
                    echo "source.push({value: '$key', text: '$value'});";
                    endforeach; 
                    ?>
                    makeSelectEditable($('#role_id'), source);

                    source = [
                          {value: '0', text: '停用'},
                          {value: '1', text: '啟用'}
                    ]
                    makeSelectEditable($('#user_status'), source);

                    $('[data-tooltip="true"]').tooltip();

                    $('#confirm-delete').on('show.bs.modal', function(e) {
                        console.log($(e.relatedTarget).data('href'));
                        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
                    });
                }, false);    
            </script>
            <?php endif; ?>