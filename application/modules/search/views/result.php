<!-- Page Content -->
<div class="container">
    <!-- Form Section -->
    <div class="row mt35">
        <div class="col-lg-12">
            <h3 class="page-header text-green no-padding-b">
                系統已收到您的資料
            </h3>
        </div>
        <div class="col-lg-12 form-group">
            <?php if( $value['fail'] != TRUE AND $value['paid'] == FALSE ): ?>
                <div class="alert alert-warning">
                <?php if( $value['status'] == '候補' ): ?>
                    <strong class="h4">候補中</strong>
                    <p>若有名額釋出，將由專人和您聯繫；若無名額釋出，將不會主動和您聯繫，謝謝！</p>
                <?php elseif( $value['status'] == '取消' ): ?>
                    <strong class="h4">訂位已取消</strong>
                <?php elseif( $value['status'] == '訂位' AND $value['fail'] == FALSE AND $value['paid'] == FALSE ): ?>
                    <strong class="h4">已訂位尚未付款</strong>
                <?php endif; ?>
                </div>
            <?php elseif( $value['fail'] == TRUE ): ?>
                <div class="alert alert-warning">
                    <strong class="h4"><?php echo $value['status']; ?>失敗</strong>
                </div>
            <?php elseif( $value['status'] == '候補' AND $value['fail'] == FALSE AND $value['paid'] == TRUE ): ?>
                <div class="alert alert-warning">
                    <strong class="h4">候補報名成功 (已付款)</strong>
                </div>
            <?php endif; ?>
            <div class="panel-heading panel-body table-bordered">
                <h4 class="text-gray padding-text">您的聯絡資料</h4>
            </div>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>報名人員</td>
                        <td><strong><?php echo $value['participant_name'] ?> (本人)</strong></td>
                        <td>聯絡電話</td>
                        <td><strong><?php echo $value['participant_phone'] ?></strong></td>

                    </tr>
                    <tr>
                        <td>Email信箱</td>
                        <td><strong><?php echo $value['email'] ?></strong></td>
                        <td>發票類型</td>
                        <td colspan="3"><strong><?php echo $value['invoice_types'] ?></strong></td>
                    </tr>
                    <?php if ($value['invoice_types'] == '三聯式發票'): ?>
                    <tr>
                        <td>發票抬頭</td>
                        <td><strong><?php echo $value['invoice_title'] ? $value['invoice_title'] : '未提供' ?></strong></td>
                        <td>統一編號</td>
                        <td><strong><?php echo $value['invoice_number'] ? $value['invoice_number'] : '未提供' ?></strong></td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if ( count($value['more']) > 0 ): ?>
        <?php foreach ($value['more'] as $key => $val ): ?>
        <div class="col-lg-12 form-group">
            <div class="panel-heading panel-body table-bordered">
                <h4 class="text-gray padding-text">同行人員<?php echo $key + 1; ?></h4>
            </div>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>報名人員</td>
                        <td><strong><?php echo $val['other_participant_name'] ?></strong></td>
                        <td>聯絡電話</td>
                        <td><strong><?php echo $val['other_participant_phone'] ?></strong></td>

                    </tr>
                </tbody>
            </table>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
        <div class="col-lg-12">
            <div class="panel-heading panel-body table-bordered">
                <h4 class="text-gray padding-text">訂單詳細資料</h4>
            </div>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>訂單編號</td>
                        <td colspan="3"><?php echo $value['order_id']; ?></td>
                    </tr>
                    <tr>
                        <td>活動名稱</td>
                        <td colspan="3"><?php echo $value['event_title']; ?></td>
                    </tr>
                    <tr>
                        <td>店名</td>
                        <td colspan="3"><?php echo $value['event']['restaurant_name']; ?></td>
                    </tr>
                    <tr>
                        <td>地址</td>
                        <td colspan="3"><?php echo $value['event']['restaurant_address']; ?></td>
                    </tr>
                    <tr>
                        <td>場次時間</td>
                        <td><strong><?php echo date('Y-m-d H:i', strtotime($value['event']['room_open_time'])); ?> - <?php echo date('Y-m-d H:i', strtotime($value['event']['room_close_time'])); ?></strong></td>
                        <td class="text-right">報名人數</td>
                        <td><strong><?php echo $value['extra_ppl'] + 1; ?></strong> 人</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">報名費</td>
                        <td><strong>$<?php echo number_format($value['event']['fees'], 0, '.', ','); ?></strong> 元</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">報名費總計</td>
                        <td><strong class="h4 text-blue">$<?php echo number_format(($value['extra_ppl'] + 1) * $value['event']['fees'], 0, '.', ','); ?></strong> 元</td>
                    </tr>
                </tbody>
            </table>
        </div> 
    </div>
    <!-- /.row -->

    <!-- Bank Note Section -->
    <?php $this->load->view('front/bank_note'); ?>
    <!-- /.row -->
</div>
<!-- /.container  -->