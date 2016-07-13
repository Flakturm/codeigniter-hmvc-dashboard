            <!-- START row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="row mb15">
                       <div class="col-md-11">
                        <?php if($errors): ?>
                            <div class="alert alert-dismissable alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?php foreach ($errors as $error): ?>
                                <p class="nm"><?php echo $error; ?></p>
                            <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        </div>
                        <div class="col-md-1 text-right">
                            <a href="<?php echo site_url('admin/' . $root_page); ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="上一頁"><i class="ico-undo"></i></a>
                        </div>
                    </div>
                    <!-- START Panel -->
                    <div class="panel panel-default">
                        <!-- panel heading/header -->
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="ico-flag mr5"></i> 活動設定</h3>
                        </div>
                        <!--/ panel heading/header -->
                        <!-- START Form Wizard -->
                        <?php echo form_open_multipart('', 'class="form-horizontal form-bordered" id="wizard-validate"'); ?>
                            <!-- Wizard Container 1 -->
                            <div class="wizard-title">活動設定</div>
                            <div class="wizard-container">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">活動主題</label>
                                    <div class="col-sm-8">
                                        <?php
                                        $data = array(
                                                'name'  => 'event_title',
                                                'class' => 'form-control',
                                                'value' => set_value('event_title', (isset($event['event_title']))?$event['event_title']:''),
                                                'placeholder' => '請輸入活動主題',
                                                'data-parsley-group' => 'event-settings',
                                                'data-parsley-required' => ''
                                        );
                                        echo form_input($data);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">活動頁主圖</label>
                                    <div class="col-sm-8 img-upload">
                                            <p>
                                                <a class="popup-link" href="<?php if (isset($event['event_pic']) && $event['event_pic']) {echo base_url() . 'uploads/' . $event['event_pic'];} ?>">
                                                    <?php  if (isset($event['event_pic']) && $event['event_pic']): ?>
                                                    <img src="<?php if (isset($event['event_pic'])) {echo base_url() . 'uploads/' . $event['event_pic'];} ?>" class="img-thumbnail img-responsive pic-img">
                                                    <?php  endif; ?>
                                                </a>
                                            </p>
                                        <div class="image-alert-container"></div>
                                        <div class="input-group image-preview">
                                            <input type="text" class="form-control image-preview-filename" disabled="disabled" value="<?php echo (isset($event['event_pic']) ? $event['event_pic'] : '') ?>"> <!-- don't give a name === doesn't send on POST/GET -->
                                            <span class="input-group-btn">
                                                <!-- image-preview-clear button -->
                                                <button type="button" class="btn btn-danger image-preview-clear <?php echo (isset($event['event_pic']) && $event['event_pic'])?'':'hide' ?>">
                                                    <span class="glyphicon glyphicon-remove"></span> 移除
                                                </button>
                                                <!-- image-preview-input -->
                                                <div class="btn btn-primary image-preview-input">
                                                    <span class="glyphicon glyphicon-folder-open"></span>
                                                    <span class="image-preview-input-title">瀏覽</span>
                                                    <input type="file" accept="image/png, image/jpeg, image/gif" name="event_pic" value="<?php echo (isset($event['event_pic']) ? $event['event_pic'] : '') ?>" /> <!-- rename it -->
                                                </div>
                                            </span>
                                        </div>
                                        <p class="help-block mb0 mt10 img-note">請上傳 <span class="img-fixed-width">1920</span>px x <span class="img-fixed-height">450</span>px，檔案勿超過500KB，副檔限 jpg, jpeg, png</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">活動類別</label>
                                    <div class="col-sm-8">
                                        <?php echo form_dropdown('category_id', $categories, set_value('category_id', (isset($event['category_id']))?$event['category_id']:''), 'class="form-control"'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">活動狀態</label>
                                    <div class="col-sm-8">
                                        <?php echo form_dropdown('status', $statuses, set_value('status', (isset($event['status']))?$event['status']:''), 'class="form-control"'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">活動描述</label>
                                    <div class="col-sm-8">
                                        <?php
                                        $data = array(
                                                'name'  => 'event_description',
                                                'class' => 'form-control',
                                                'value' => set_value('event_description', (isset($event['event_description']))?$event['event_description']:''),
                                                'placeholder' => '請輸入活動內容描述',
                                                'data-parsley-group' => 'event-settings',
                                                'data-parsley-required' => ''
                                        );
                                        echo form_textarea($data);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">菜單圖</label>
                                    <div class="col-sm-8 img-upload">
                                        <p>
                                            <a class="popup-link" href="<?php if (isset($event['menu_pic']) && $event['menu_pic']) {echo base_url() . 'uploads/' . $event['menu_pic'];} ?>">
                                                <?php  if (isset($event['menu_pic']) && $event['menu_pic']): ?>
                                                <img src="<?php if (isset($event['menu_pic']) && $event['menu_pic']) {echo base_url() . 'uploads/' . $event['menu_pic'];} ?>" class="img-thumbnail img-responsive pic-img" width="300">
                                                <?php  endif; ?>
                                            </a>
                                        </p>
                                        <div class="image-alert-container"></div>
                                        <div class="input-group image-preview">
                                            <input type="text" class="form-control image-preview-filename" disabled="disabled" value="<?php echo (isset($event['menu_pic']) ? $event['menu_pic'] : '') ?>"> <!-- don't give a name === doesn't send on POST/GET -->
                                            <span class="input-group-btn">
                                                <!-- image-preview-clear button -->
                                                <button type="button" class="btn btn-danger image-preview-clear <?php echo (isset($event['menu_pic']) && $event['menu_pic'])?'':'hide' ?>">
                                                    <span class="glyphicon glyphicon-remove"></span> 移除
                                                </button>
                                                <!-- image-preview-input -->
                                                <div class="btn btn-primary image-preview-input">
                                                    <span class="glyphicon glyphicon-folder-open"></span>
                                                    <span class="image-preview-input-title">瀏覽</span>
                                                    <input type="file" accept="image/png, image/jpeg, image/gif" name="menu_pic" value="<?php echo (isset($event['menu_pic']) ? $event['menu_pic'] : '') ?>" /> <!-- rename it -->
                                                </div>
                                            </span>
                                        </div>
                                        <p class="help-block mt10 img-note">請上傳 <span class="img-fixed-width">600</span>px x <span class="img-fixed-height">400</span>px，檔案勿超過500KB，副檔限 jpg, jpeg, png</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">YouTube 影片碼</label>
                                    <div class="col-sm-8">
                                        <?php
                                        $data = array(
                                                'name'  => 'youtube_code',
                                                'class' => 'form-control',
                                                'value' => set_value('youtube_code', (isset($event['youtube_code']))?$event['youtube_code']:''),
                                                'placeholder' => '',
                                                'data-parsley-group' => 'event-settings'
                                        );
                                        echo form_input($data);
                                        ?>
                                        <p class="help-block mt10">填入紅色的部分就好<br>https://www.youtube.com/watch?v=<span class="text-danger">EPo5wWmKEaI</span></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">課程名稱</label>
                                    <div class="col-sm-8">
                                        <?php
                                        $data = array(
                                                'name'  => 'room_title',
                                                'class' => 'form-control',
                                                'value' => set_value('room_title', (isset($event['room_title']))?$event['room_title']:''),
                                                'placeholder' => '請輸入課程名稱',
                                                'data-parsley-group' => 'event-settings',
                                                // 'data-parsley-required' => ''
                                        );
                                        echo form_input($data);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">課程時間</label>
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <?php
                                                $data = array(
                                                        'name'  => 'room_open_time',
                                                        'id'    => 'range_room_start',
                                                        'class' => 'form-control',
                                                        'value' => set_value('room_open_time', (isset($event['room_open_time']))?$event['room_open_time']:''),
                                                        'data-parsley-group' => 'event-settings',
                                                        'data-parsley-required' => ''
                                                );
                                                echo form_input($data);
                                                ?>
                                            </div>
                                            <label class="col-sm-1 control-label" style="width:10px;padding:5px 7px 0 0px;">至</label>
                                            <div class="col-md-6">
                                                <?php
                                                $data = array(
                                                        'name'  => 'room_close_time',
                                                        'id'    => 'range_room_end',
                                                        'class' => 'form-control',
                                                        'value' => set_value('room_close_time', (isset($event['room_close_time']))?$event['room_close_time']:''),
                                                        'data-parsley-group' => 'event-settings',
                                                        'data-parsley-required' => ''
                                                );
                                                echo form_input($data);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">報名時間</label>
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <?php
                                                $data = array(
                                                        'name'  => 'enroll_open_time',
                                                        'id'    => 'range_enroll_start',
                                                        'class' => 'form-control',
                                                        'value' => set_value('enroll_open_time', (isset($event['enroll_open_time']))?$event['enroll_open_time']:''),
                                                        'data-parsley-group' => 'event-settings',
                                                        'data-parsley-required' => ''
                                                );
                                                echo form_input($data);
                                                ?>
                                            </div>
                                            <label class="col-sm-1 control-label" style="width:10px;padding:5px 7px 0 0px;">至</label>
                                            <div class="col-md-6">
                                                <?php
                                                $data = array(
                                                        'name'  => 'enroll_close_time',
                                                        'id'    => 'range_enroll_end',
                                                        'class' => 'form-control',
                                                        'value' => set_value('enroll_close_time', (isset($event['enroll_close_time']))?$event['enroll_close_time']:''),
                                                        'data-parsley-group' => 'event-settings',
                                                        'data-parsley-required' => ''
                                                );
                                                echo form_input($data);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">課程費用</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">NTD.</span>
                                            <?php
                                                $data = array(
                                                        'name'  => 'fees',
                                                        'class' => 'form-control',
                                                        'value' => set_value('fees', (isset($event['fees']))?$event['fees']:''),
                                                        'data-parsley-group' => 'event-settings',
                                                        'data-parsley-required' => '',
                                                        'data-parsley-type' => 'number'
                                                );
                                                echo form_input($data);
                                            ?>
                                            <span class="input-group-addon">元</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">課程人數</label>
                                    <div class="col-sm-8">
                                        <?php
                                            $data = array(
                                                    'name'  => 'slots',
                                                    'class' => 'form-control',
                                                    'value' => set_value('slots', (isset($event['slots']))?$event['slots']:''),
                                                    'data-parsley-group' => 'event-settings',
                                                    'data-parsley-required' => '',
                                                    'data-parsley-type' => 'integer'
                                            );
                                            echo form_input($data);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">候補人數</label>
                                    <div class="col-sm-8">
                                        <?php
                                            $data = array(
                                                    'name'  => 'waiting_slots',
                                                    'class' => 'form-control',
                                                    'value' => set_value('waiting_slots', (isset($event['waiting_slots']))?$event['waiting_slots']:''),
                                                    'data-parsley-group' => 'event-settings',
                                                    'data-parsley-required' => '',
                                                    'data-parsley-type' => 'integer'
                                            );
                                            echo form_input($data);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">單次名額限制</label>
                                    <div class="col-sm-8">
                                        <?php
                                            $data = array(
                                                    'name'  => 'pack_size',
                                                    'class' => 'form-control',
                                                    'value' => set_value('pack_size', (isset($event['pack_size']))?$event['pack_size']:''),
                                                    'data-parsley-group' => 'event-settings',
                                                    'data-parsley-required' => '',
                                                    'data-parsley-type' => 'integer'
                                            );
                                            echo form_input($data);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">幕後花絮</label>
                                    <div class="col-sm-8">
                                        <?php
                                            $data = array(
                                                    'name'  => 'expired_url',
                                                    'class' => 'form-control',
                                                    'value' => set_value('expired_url', (isset($event['expired_url']))?$event['expired_url']:''),
                                                    'placeholder' => '活動結束後，請輸入完整網址，例:http://www.foodrends.com',
                                                    'data-parsley-type' => 'url'
                                            );
                                            echo form_input($data);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">菜單網址</label>
                                    <div class="col-sm-8">
                                        <?php
                                            $data = array(
                                                    'name'  => 'menu_url',
                                                    'class' => 'form-control',
                                                    'value' => set_value('menu_url', (isset($event['menu_url']))?$event['menu_url']:''),
                                                    'placeholder' => '請輸入完整網址，例:http://www.foodrends.com',
                                                    'data-parsley-type' => 'url'
                                            );
                                            echo form_input($data);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!--/ Wizard Container 1 -->
                            <!-- Wizard Container 2 -->
                            <div class="wizard-title">店家設定</div>
                            <div class="wizard-container">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">店家圖片</label>
                                    <div class="col-sm-8 img-upload">
                                            <p>
                                                <a class="popup-link" href="<?php if (isset($event['restaurant_pic']) && $event['restaurant_pic']) {echo base_url() . 'uploads/' . $event['restaurant_pic'];} ?>">
                                                    <?php  if (isset($event['restaurant_pic']) && $event['restaurant_pic']): ?>
                                                    <img src="<?php if (isset($event['restaurant_pic'])) {echo base_url() . 'uploads/' . $event['restaurant_pic'];} ?>" class="img-thumbnail img-responsive pic-img" width="300">
                                                    <?php  endif; ?>
                                                </a>
                                            </p>
                                        <div class="image-alert-container"></div>
                                        <div class="input-group image-preview">
                                            <input type="text" class="form-control image-preview-filename" disabled="disabled" value="<?php echo (isset($event['restaurant_pic']) ? $event['restaurant_pic'] : '') ?>"> <!-- don't give a name === doesn't send on POST/GET -->
                                            <span class="input-group-btn">
                                                <!-- image-preview-clear button -->
                                                <button type="button" class="btn btn-danger image-preview-clear <?php echo (isset($event['restaurant_pic']) && $event['restaurant_pic'])?'':'hide' ?>">
                                                    <span class="glyphicon glyphicon-remove"></span> 移除
                                                </button>
                                                <!-- image-preview-input -->
                                                <div class="btn btn-primary image-preview-input">
                                                    <span class="glyphicon glyphicon-folder-open"></span>
                                                    <span class="image-preview-input-title">瀏覽</span>
                                                    <input type="file" accept="image/png, image/jpeg, image/gif" name="restaurant_pic" value="<?php echo (isset($event['restaurant_pic']) ? $event['restaurant_pic'] : '') ?>" /> <!-- rename it -->
                                                </div>
                                            </span>
                                        </div>
                                        <p class="help-block mb0 mt10 img-note">請上傳 <span class="img-fixed-width">600</span>px x <span class="img-fixed-height">400</span>px，檔案勿超過500KB，副檔限 jpg, jpeg, png</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">店家名稱</label>
                                    <div class="col-sm-8">
                                        <?php
                                            $data = array(
                                                    'name'  => 'restaurant_name',
                                                    'class' => 'form-control',
                                                    'value' => set_value('restaurant_name', (isset($event['restaurant_name']))?$event['restaurant_name']:''),
                                                    'data-parsley-group' => 'restaurant-settings',
                                                    'data-parsley-required' => ''
                                            );
                                            echo form_input($data);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">主廚名稱和介紹</label>
                                    <div class="col-sm-8">
                                        <?php
                                            $data = array(
                                                    'name'  => 'restaurant_chef',
                                                    'class' => 'form-control',
                                                    'value' => set_value('restaurant_chef', (isset($event['restaurant_chef']))?$event['restaurant_chef']:''),
                                                    'data-parsley-group' => 'restaurant-settings',
                                                    'data-parsley-required' => ''
                                            );
                                            echo form_input($data);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">店家描述</label>
                                    <div class="col-sm-8">
                                        <?php
                                            $data = array(
                                                    'name'  => 'restaurant_description',
                                                    'class' => 'form-control',
                                                    'value' => set_value('restaurant_description', (isset($event['restaurant_description']))?$event['restaurant_description']:''),
                                                    'data-parsley-group' => 'restaurant-settings',
                                                    'data-parsley-required' => ''
                                            );
                                            echo form_textarea($data);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">店家地址</label>
                                    <div class="col-sm-8">
                                        <div class="input-group input-group mb5">
                                            <span class="input-group-addon"><i class="ico-location5"></i></span>
                                            <?php
                                                $data = array(
                                                        'name'  => 'restaurant_address',
                                                        'class' => 'form-control',
                                                        'value' => set_value('restaurant_address', (isset($event['restaurant_address']))?$event['restaurant_address']:''),
                                                        'data-parsley-group' => 'restaurant-settings',
                                                        'data-parsley-required' => ''
                                                );
                                                echo form_input($data);
                                            ?>
                                        </div>
                                        <!-- <div id="map-canvas"></div> -->
                                    </div>
                                </div>
                                <!--/ Wizard Container 2 -->
                        <?php echo form_close(); ?>
                        <!--/ END Form Wizard -->
                    </div>
                    <!--/ END Panel -->
                </div>
            </div>
            <!--/ END row -->