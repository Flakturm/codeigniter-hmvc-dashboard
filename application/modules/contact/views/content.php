<!-- Page Content -->
<div class="container">

    <!-- Page Title Section -->
    <div class="row mt35">
        <div class="col-lg-12">
            <h3 class="page-header text-green no-padding-b">
                聯絡我們
            </h3>
        </div>
    </div>
    <!-- /.row -->

    <!-- Content Start -->
    <?php echo form_open('', 'class="ajax-form"'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="message-container"></div>
            <div class="text-word hide-block" style="margin-bottom:20px;">
                <div class="control-group form-group padding-form padding-form-r">
                    <div class="controls">
                        <label class="text-gray h4">姓名</label>
                        <?php
                        $data = array(
                                'name'  => 'name',
                                'class' => 'form-control',
                                'placeholder' => '請輸入真實姓名',
                                'data-parsley-required' => ''
                        );
                        echo form_input($data);
                        ?>
                    </div>
                </div>
                <div class="control-group form-group padding-form padding-form-r">
                    <div class="controls">
                        <label class="text-gray h4">聯絡電話</label>
                        <?php
                        $data = array(
                                'name'  => 'phone',
                                'class' => 'form-control',
                                'placeholder' => '請輸入聯絡電話',
                                'data-parsley-required' => ''
                        );
                        echo form_input($data);
                        ?>
                    </div>
                </div>
                <div class="control-group form-group padding-form padding-form-r">
                    <div class="controls">
                        <label class="text-gray h4">Email信箱</label>
                        <input type="email" name="email" class="form-control" data-parsley-required placeholder="請輸入有效信箱">
                    </div>
                </div>
                <div class="control-group form-group padding-form padding-form-r">
                    <div class="controls">
                        <label class="text-gray h4">您的意見</label>
                        <?php
                        $data = array(
                            'name'  => 'message',
                            'class' => 'form-control',
                            'data-parsley-required' => ''
                        );
                        echo form_textarea($data);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 hide-block">
            <div class="text-center padding-btn">
                <button type="submit" data-style="zoom-in" class="btn btn-db ladda-button next-btn">送出</button>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <?php echo form_close(); ?>
    <input type="hidden" id="ajax-url" value="/contact/ajaxSend" >

<?php $this->load->view('front/bank_note'); ?>
</div>
<!-- /.container -->