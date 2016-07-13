<!-- Page Content -->
<div class="container">

    <!-- Content Section -->
    <div class="row mt35">
        <div class="col-lg-12">
            <h3 class="page-header text-gray no-padding-b">
                <?php echo $event['event_title']; ?>
            </h3>
        </div>
        <div class="col-md-12">
            <div class="text-word">
                <div class="text-gray padding-text">店名：<span class="h3"><?php echo $event['restaurant_name']; ?></span></div>
                <div class="text-gray padding-text">時間：<strong><?php echo date('Y-m-d H:i', strtotime($event['room_open_time'])); ?> - <?php echo date('Y-m-d H:i', strtotime($event['room_close_time'])); ?></strong></div>
                <div class="text-gray padding-text">地址：<?php echo $event['restaurant_address']; ?></div>
                <div class="text-gray padding-text">報名人數：<span class="h3"><?php echo $event['extra_people']; ?></span> 人</div>
                <div class="text-gray padding-text">報名費：<span class="h3">$<?php echo number_format($event['fees'] * $event['extra_people'], 0, '.', ','); ?></span><span class="text-gray"> 元</span></div>
            </div>
        </div>
    </div>
    <!-- /.row -->

    <!-- Portfolio Section -->
    <?php echo form_open('event/step2', 'class="ajax-form"', $event); ?>
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header text-gray no-padding-b">
                * 請輸入中國信託信用卡卡號前6碼，以確認可進行線上刷卡。若為正確，將可直接進行報名資料填寫
            </h4>
        </div>
        <div class="col-md-8">
            <div class="message-container"></div>
            <div class="input-group">
                <span class="input-group-addon"><i class="ico-vcard"></i></span>
                <?php
                $data = array(
                        'name'  => 'card_digits',
                        'class' => 'form-control',
                        'placeholder' => '信用卡卡號前6碼',
                        'pattern' => '[0-9]+',
                        'minlength' => '6',
                        'maxlength' => '6',
                        'data-parsley-type' => 'digits',
                        'data-parsley-length' => '[6, 6]',
                        'data-parsley-required' => ''
                );
                echo form_input($data);
                ?>
                <!-- <p class="help-block"></p> -->
            </div>
        </div>
        <div class="col-md-4">
            <button data-style="zoom-in" class="btn btn-db ladda-button next-btn">下一步 >></button>
        </div>
    </div>
    <!-- /.row -->
    <?php echo form_close(); ?>
    <input type="hidden" id="ajax-url" value="<?php echo site_url(); ?>event/ajaxStep1" >
    <!-- Bank Note Section -->
    <?php $this->load->view('front/bank_note'); ?>
    <!-- /.row -->
</div>
<!-- /.container -->