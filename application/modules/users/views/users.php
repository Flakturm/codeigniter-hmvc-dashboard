                <!-- START row -->
                <div class="row">
                    <div class="col-md-12">
                        <?php if($flash_message): ?>
                            <div class="alert alert-dismissable alert-<?php echo $flash_status; ?>">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <?php echo $flash_message; ?>
                            </div>
                        <?php endif; ?>
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
                        <div class="panel panel-default">
                            
                            <table class="table table-striped" id="zero-configuration">
                                <thead>
                                    <tr class="head_font">
                                        <th>編號</th>
                                        <th>名稱</th>
                                        <th>權限</th>
                                        <th>狀態</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php foreach($users as $key => $user): ?>
                                    <tr>
                                        <td><?php echo $key + 1; ?></td>
                                        <td><?php echo $user->user_nicename; ?></td>
                                        <td><?php echo $user->role_name; ?></td>
                                        <td><span class="label label-<?php echo ($user->user_status ? 'teal' : 'danger'); ?> "><?php echo ($user->user_status ? '啟用' : '停用'); ?></span></td>
                                        <td>
                                        	<a href="<?php echo $root_page . '/edit/' . $user->id; ?>" class="btn btn-sm btn-success mr10" data-toggle="tooltip" data-original-title="編輯">
	                                            <i class="ico-pencil2"></i>
                                            </a>
                                            <?php if ( $user->id != 1): ?>
                                            <a data-href="<?php echo $root_page . '/delete/' . $user->id; ?>" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#confirm-delete" data-tooltip="true" data-original-title="解僱">
                                                <i class="ico-remove2"></i>
                                            </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--/ END row -->
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        $('[data-tooltip="true"]').tooltip();

                        $('#confirm-delete').on('show.bs.modal', function(e) {
                            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
                        });
                    }, false);
                </script>