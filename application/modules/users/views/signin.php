			    <!-- START row -->
                <div class="row">
                    <div class="col-lg-4 col-lg-offset-4">
                        <!-- Brand -->
                        <div class="text-center" style="margin-bottom:20px; margin-top:50px;">
                            <!-- <span class="logo-figure inverse"></span>
                            <span class="logo-text inverse"></span> -->
                            <img src="<?php echo base_url() . 'theme/img/logo/' . $site_logo ?>" class="img-responsive center-block">
                        </div>
                        <!--/ Brand -->
                        <div class="modal fade" id="forget-password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <?php echo form_open(current_url(), 'class="form-horizontal form-bordered ajax-forget-form"'); ?>
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">忘記密碼</h4>
                                    </div>
                                
                                    <div class="modal-body">
                                        <div class="message-container"></div>
                                        <div class="form-dismiss">
                                            <p>密碼將會寄到用戶的信箱</p>
                                            <div class="has-icon pull-left">
                                                <?php
                                                    $data = array(
                                                            'name'  => 'user_email',
                                                            'class' => 'form-control input-lg',
                                                            'placeholder'  => 'Email',
                                                            'value' => set_value('user_email'),
                                                            'data-parsley-type' => 'email',
                                                            'data-parsley-required' => ''
                                                    );
                                                    echo form_input($data);
                                                ?>
                                                <i class="ico-user2 form-control-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="modal-footer form-dismiss">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                        <button type="submit" id="submit-btn" class="btn btn-success ladda-button btn-ok" data-style="expand-right">送出</button>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>

                        <hr><!-- horizontal line -->

                        <?php if(@$error): ?>
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<?php echo $error; ?>
						</div>
						<?php endif; ?>
                        <!-- Login form -->
                        <form class="panel" name="form-login" method="post" action="">
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="form-stack has-icon pull-left">
                                        <input name="user_email" type="text" class="form-control input-lg" placeholder="Email" data-parsley-errors-container="#error-container" data-parsley-error-message="Please fill in your username / email" data-parsley-required <?php echo isset($_POST['user_email']) ? "value=$_POST[user_email]" : ""; ?>>
                                        <i class="ico-user2 form-control-icon"></i>
                                    </div>
                                    <div class="form-stack has-icon pull-left">
                                        <input name="password" type="password" class="form-control input-lg" placeholder="Password" data-parsley-errors-container="#error-container" data-parsley-error-message="Please fill in your password" data-parsley-required>
                                        <i class="ico-lock2 form-control-icon"></i>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="text-right">
                                        <a href="" data-toggle="modal" data-target="#forget-password">忘記密碼</a>
                                    </div>
                                </div>
                                <div class="form-group nm">
                                    <button type="submit" class="btn btn-block btn-success"><span class="semibold">Sign In</span></button>
                                </div>
                            </div>
                        </form>
                        <!-- Login form -->
                    </div>
                </div>
                <!--/ END row -->
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        $('#forget-password').on('hidden.bs.modal', function (e) {
                            $(this)
                            .find("input,textarea,select")
                                .val('')
                                .removeClass('parsley-error')
                                .end()
                            .find('.message-container')
                                .empty()
                                .end()
                            .find('.form-dismiss')
                                .show()
                                .end()
                            .find('.parsley-errors-list')
                               .remove()
                               .end();
                        });
                    }, false);
                </script>