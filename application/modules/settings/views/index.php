                <!-- START row -->
                <?php echo form_open_multipart(current_url(), 'class="form-horizontal form-bordered ajax-form"'); ?>
                <div class="row">
                    <div class="col-md-12">
                        <!-- panel heading/header -->
                        <div class="panel-heading">
                            <div class="pull-right">
                                <button id="submit-btn" class="btn btn-success ladda-button" data-style="expand-right" data-toggle="tooltip" data-original-title="保存"><i class="ico-save"></i></button>
                            </div>
                            <h3 class="panel-title"><i class="ico-settings mr5"></i>網站設定</h3>
                        </div>
                        <!--/ panel heading/header -->
                        <!-- START panel -->
                        <div class="panel panel-default">
                            <!-- panel body -->
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">網站標題</label>
                                    <div class="col-sm-8">
                                        <?php
                                        $data = array(
                                                'name'  => 'site_title',
                                                'class' => 'form-control',
                                                'value' => set_value('site_title', (isset($settings['site_title']))?$settings['site_title']:''),
                                                'data-parsley-group' => 'settings',
                                                'data-parsley-maxlength' => '150',
                                                'data-parsley-required' => ''
                                        );
                                        echo form_input($data);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Favicon</label>
                                    <div class="col-sm-8 img-upload">
                                            <p>
                                                <?php  if (isset($settings['site_favicon']) && $settings['site_favicon']): ?>
                                                    <img src="<?php if (isset($settings['site_favicon'])) {echo base_url() . 'theme/img/logo/' . $settings['site_favicon'];} ?>" class="img-thumbnail img-responsive pic-img">
                                                <?php  endif; ?>
                                            </p>
                                        <div class="image-alert-container"></div>
                                        <div class="input-group image-preview">
                                            <input type="text" class="form-control image-preview-filename" disabled="disabled" value="<?php echo (isset($settings['site_favicon']) ? $settings['site_favicon'] : '') ?>"> <!-- don't give a name === doesn't send on POST/GET -->
                                            <span class="input-group-btn">
                                                <!-- image-preview-clear button -->
                                                <button type="button" class="btn btn-danger image-preview-clear <?php echo (isset($settings['site_favicon']) && $settings['site_favicon'])?'':'hide' ?>">
                                                    <span class="glyphicon glyphicon-remove"></span> 移除
                                                </button>
                                                <?php echo (isset($settings['site_favicon']) ? '<input type="hidden" name="empty_icon" id="empty_icon" value="">' : '') ?>
                                                <!-- image-preview-input -->
                                                <div class="btn btn-primary image-preview-input">
                                                    <span class="glyphicon glyphicon-folder-open"></span>
                                                    <span class="image-preview-input-title">瀏覽</span>
                                                    <input type="file" accept="image/ico" id="site_favicon" name="site_favicon" value="<?php echo (isset($settings['site_favicon']) ? $settings['site_favicon'] : '') ?>" /> <!-- rename it -->
                                                </div>
                                            </span>
                                        </div>
                                        <p class="help-block mb0 mt10 img-note">請上傳 <span class="img-fixed-width">16</span>px x <span class="img-fixed-height">16</span>px，檔案勿超過500KB，副檔限 ico</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">後臺 Logo</label>
                                    <div class="col-sm-8 img-upload">
                                            <p>
                                                <?php  if (isset($settings['site_logo']) && $settings['site_logo']): ?>
                                                    <img src="<?php if (isset($settings['site_logo'])) {echo base_url() . 'theme/img/logo/' . $settings['site_logo'];} ?>" class="img-thumbnail img-responsive pic-img">
                                                <?php  endif; ?>
                                            </p>
                                        <div class="image-alert-container"></div>
                                        <div class="input-group image-preview">
                                            <input type="text" class="form-control image-preview-filename" disabled="disabled" value="<?php echo (isset($settings['site_logo']) ? $settings['site_logo'] : '') ?>"> <!-- don't give a name === doesn't send on POST/GET -->
                                            <span class="input-group-btn">
                                                <!-- image-preview-clear button -->
                                                <button type="button" class="btn btn-danger image-preview-clear <?php echo (isset($settings['site_logo']) && $settings['site_logo'])?'':'hide' ?>">
                                                    <span class="glyphicon glyphicon-remove"></span> 移除
                                                </button>
                                                <?php echo (isset($settings['site_logo']) ? '<input type="hidden" name="empty_img" id="empty_img" value="">' : '') ?>
                                                <!-- image-preview-input -->
                                                <div class="btn btn-primary image-preview-input">
                                                    <span class="glyphicon glyphicon-folder-open"></span>
                                                    <span class="image-preview-input-title">瀏覽</span>
                                                    <input type="file" accept="image/png, image/jpeg, image/gif" id="site_logo" name="site_logo" value="<?php echo (isset($settings['site_logo']) ? $settings['site_logo'] : '') ?>" /> <!-- rename it -->
                                                </div>
                                            </span>
                                        </div>
                                        <p class="help-block mb0 mt10 img-note">請上傳 <span class="img-fixed-width">200</span>px x <span class="img-fixed-height">47</span>px，檔案勿超過500KB，副檔限 jpg, jpeg, png</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Google Analytics 追蹤碼</label>
                                    <div class="col-sm-8">
                                        <?php
                                            $data = array(
                                                    'name'  => 'ga_code',
                                                    'class' => 'form-control',
                                                    'value' => set_value('ga_code', (isset($settings['ga_code']))?$settings['ga_code']:''),
                                                    'placeholder' => 'UA-XXXXXXX-Y'
                                            );
                                            echo form_input($data);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!-- panel body -->
                        </div>
                    </div>
                </div>
                <!--/ END row -->
                <!-- START row -->
                <div class="row">
                    <div class="col-md-12">
                        <!-- panel heading/header -->
                        <div class="panel-heading">
                            <div class="pull-right">
                                <button id="send-mail" class="btn btn-primary ladda-button" data-style="expand-right" data-toggle="tooltip" data-original-title="寄測試信"><i class="ico-mail-send"></i></button>
                            </div>
                            <h3 class="panel-title"><i class="ico-envelop mr5"></i>信箱設定</h3>
                        </div>
                        <!--/ panel heading/header -->
                        <!-- START panel -->
                        <div class="panel panel-default">
                            <!-- panel body -->
                            <div class="panel-body">
                                <div class="form-group">
                                   <label class="col-sm-3 control-label">收件信箱</label>
                                    <div class="col-sm-8">
                                        <?php
                                        $data = array(
                                                'name'  => 'email_recipient',
                                                'class' => 'form-control',
                                                'value' => set_value('email_recipient', (isset($settings['email_recipient']))?$settings['email_recipient']:''),
                                                'data-parsley-group' => 'settings',
                                                'data-parsley-type' => 'email',
                                                'data-parsley-required' => ''
                                        );
                                        echo form_input($data);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                   <label class="col-sm-3 control-label">SMTP主機(SMTP Host)</label>
                                    <div class="col-sm-8">
                                        <?php
                                        $data = array(
                                                'name'  => 'smtp_host',
                                                'class' => 'form-control',
                                                'value' => set_value('smtp_host', (isset($settings['smtp_host']))?$settings['smtp_host']:''),
                                                'data-parsley-group' => 'settings',
                                                'data-parsley-required' => ''
                                        );
                                        echo form_input($data);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                   <label class="col-sm-3 control-label">使用者(SMTP Username)</label>
                                    <div class="col-sm-8">
                                        <?php
                                        $data = array(
                                                'name'  => 'smtp_user',
                                                'class' => 'form-control',
                                                'value' => set_value('smtp_user', (isset($settings['smtp_user']))?$settings['smtp_user']:''),
                                                'data-parsley-group' => 'settings',
                                                'data-parsley-required' => ''
                                        );
                                        echo form_input($data);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                   <label class="col-sm-3 control-label">密碼(SMTP Password)</label>
                                    <div class="col-sm-8">
                                        <div class="has-icon pull-left">
                                        <?php
                                        $data = array(
                                                'name'  => 'smtp_pass',
                                                'class' => 'form-control',
                                                'value' => set_value('smtp_pass', (isset($settings['smtp_pass']))?$settings['smtp_pass']:''),
                                                'data-parsley-group' => 'settings',
                                                'data-parsley-required' => ''
                                        );
                                        echo form_password($data);
                                        ?>
                                        <i class="ico-lock2 form-control-icon"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                   <label class="col-sm-3 control-label">通訊埠(SMTP Port)</label>
                                    <div class="col-sm-8">
                                        <?php
                                        $data = array(
                                                'name'  => 'smtp_port',
                                                'class' => 'form-control',
                                                'value' => set_value('smtp_port', (isset($settings['smtp_port']))?$settings['smtp_port']:''),
                                                'data-parsley-group' => 'settings',
                                                'data-parsley-required' => ''
                                        );
                                        echo form_input($data);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!-- panel body -->
                        </div>                        
                        <!--/ END form panel -->
                    </div>
                </div>
                <?php echo form_close(); ?>