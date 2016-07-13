<!-- Page Content -->
<div class="container">

    <!-- Step 1 Form Section -->
    <?php 
        $url = ( isset($event['order_status']) AND $event['order_status'] == '候補' )? 'store' : 'step3';
        echo form_open('event/' . $url, 'data-parsley-validate', $event); 
    ?>
    <div class="row mt35">
        <div class="col-lg-12">
            <h3 class="page-header text-green no-padding-b">
                報名人員資料填寫 <span class="h4">第1位報名人員資料 (必須為本人，且為聯絡人)</span>
            </h3>
        </div>
        <div class="col-md-12">
            <div class="control-group form-group">
                <div class="controls">
                    <label class="text-gray h4"> 姓名</label>
                    <?php
                    $data = array(
                            'name'  => 'participant_name',
                            'class' => 'form-control',
                            'placeholder' => '請輸入真實姓名',
                            'data-parsley-required' => ''
                    );
                    echo form_input($data);
                    ?>
                </div>
            </div>
            <div class="control-group form-group">
                <div class="controls">
                    <label class="text-gray h4"> 聯絡電話</label>
                    <?php
                    $data = array(
                            'name'  => 'participant_phone',
                            'class' => 'form-control',
                            'placeholder' => '手機或室內電話',
                            'data-parsley-required' => ''
                    );
                    echo form_input($data);
                    ?>
                </div>
            </div>
            <div class="control-group form-group">
                <div class="controls">
                    <label class="text-gray h4"> Email 信箱</label>
                    <input type="email" name="email" class="form-control" data-parsley-required placeholder="請輸入有效信箱">
                </div>
            </div>
            <div class="control-group form-group">
                <div class="controls">
                    <label class="text-gray h4"> 發票類型 <span class="text-gray h5">依統一發票使用辦法規定，個人戶(二聯式)發票一經開立，不得任意更改或改開公司戶(三聯式)發票。</span></label>
                    <?php echo form_dropdown('invoice_types', $invoice_types, '', 'class="form-control" id="invoice-types"'); ?>
                    <div class="invoice-inputs form-group mt15 hide">
                        <?php
                        $data = array(
                                'name'  => 'invoice_title',
                                'class' => 'form-control mb15',
                                'placeholder' => '請輸入抬頭'
                        );
                        echo form_input($data);
                        $data = array(
                                'name'  => 'invoice_number',
                                'class' => 'form-control',
                                'placeholder' => '請輸入統一編號'
                        );
                        echo form_input($data);
                        ?>
                    </div>
                </div>
            </div>
            <div class="control-group form-group">
                <div class="controls">
                    <label class="text-gray h4"> 請務必勾選同意以下內容</label>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="agree[]" data-parsley-mincheck="2" required>
                            我已詳細閱讀「<a href="" class="notice remote-link" data-remote="<?php echo base_url('information/ajaxNotice'); ?>" data-target="#remote-modal" data-toggle="modal">活動注意事項</a>」與
                            「<a href="" class="notice remote-link" data-remote="<?php echo base_url('information/ajaxPrivacy'); ?>" data-target="#remote-modal" data-toggle="modal">個人資料保護說明</a>」並同意。</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="agree[]" required>我了解本活動僅限中國信託銀行卡友報名。</label>
                    </div>
                </div>
            </div>
        </div> 
    </div>
    <!-- /.row -->
    <!-- Extra People Section -->
    <?php if ( $event['extra_people'] > 1 ): ?>
    <?php for ( $i = 1; $i <= $event['extra_people'] - 1; $i++ ): ?>
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header text-gray no-padding-b">
                同行人員 <?php echo $i; ?> 
            </h4>
        </div>
        <div class="col-md-12">
            <div class="control-group form-group col-lg-6 padding-form padding-form-r">
                <div class="controls">
                    <label class="text-gray h4"> 姓名</label>
                    <?php
                    $data = array(
                            'name'  => 'other_participant_name[][name]',
                            'class' => 'form-control',
                            'placeholder' => '請輸入真實姓名',
                            'data-parsley-required' => ''
                    );
                    echo form_input($data);
                    ?>
                </div>
            </div>
            <div class="control-group form-group col-lg-6 padding-form">
                <div class="controls">
                    <label class="text-gray h4"> 聯絡電話</label>
                    <?php
                    $data = array(
                            'name'  => 'other_participant_phone[][phone]',
                            'class' => 'form-control',
                            'placeholder' => '手機或室內電話',
                            'data-parsley-required' => ''
                    );
                    echo form_input($data);
                    ?>
                </div>
            </div>
        </div> 
    </div>
    <?php endfor; ?>
    <?php endif; ?>
    <!-- /.row -->

    <div class="row">
        <div class="col-lg-12 text-center padding-btn">
            <a href="<?php echo $event['slug']; ?>" class="btn btn-db"><<取消</a>
            <button class="btn btn-rb next-btn">確認送出>></button>
        </div> 
    </div>

    <?php echo form_close(); ?>

    <div class="modal fade" id="remote-modal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-body">
                <p>One fine body…</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">關閉</button>
            </div>
        </div>
    </div>

    <!-- Bank Note Section -->
    <?php $this->load->view('front/bank_note'); ?>
    <!-- /.row -->
</div>
<!-- /.container  -->