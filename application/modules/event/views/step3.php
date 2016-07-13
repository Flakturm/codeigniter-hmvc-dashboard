<!-- Page Content -->
<div class="container">
    <!-- Form Section -->
    <?php echo form_open($auth_url, '', $third_party); ?>
    <div class="row mt35">
        <div class="col-lg-12">
            <h3 class="page-header text-green no-padding-b">
                請確認以下資料是否正確無誤
            </h3>
        </div>
        <div class="col-lg-12 form-group">
            <?php if ( ! $has_cockroach ): ?>
                <div class="alert alert-danger">
                請回活動<a href="<?php echo site_url('event/' . $event['slug']) ?>">頁面</a>重新報名
                </div>
            <?php endif; ?>
            <div class="panel-heading panel-body table-bordered">
                <h4 class="text-gray padding-text">您的聯絡資料</h4>
            </div>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>報名人員</td>
                        <td><strong><?php echo $event['participant_name'] ?> (本人)</strong></td>
                        <td>聯絡電話</td>
                        <td><strong><?php echo $event['participant_phone'] ?></strong></td>

                    </tr>
                    <tr>
                        <td>Email信箱</td>
                        <td><strong><?php echo $event['email'] ?></strong></td>
                        <td>發票類型</td>
                        <td colspan="3"><strong><?php echo $event['invoice_types'] ?></strong></td>
                    </tr>
                    <?php if ($event['invoice_types'] == '三聯式發票'): ?>
                    <tr>
                        <td>發票抬頭</td>
                        <td><strong><?php echo $event['invoice_title'] ? $event['invoice_title'] : '未提供' ?></strong></td>
                        <td>統一編號</td>
                        <td><strong><?php echo $event['invoice_number'] ? $event['invoice_number'] : '未提供' ?></strong></td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if ( $event['extra_people'] > 1 ): ?>
        <?php for ( $i = 0; $i < $event['extra_people'] - 1; $i++ ): ?>
        <div class="col-lg-12 form-group">
            <div class="panel-heading panel-body table-bordered">
                <h4 class="text-green padding-text">同行人員<?php echo $i + 1; ?></h4>
            </div>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>報名人員</td>
                        <td><strong><?php echo $event['other_participant_name'][$i]['name'] ?></strong></td>
                        <td>聯絡電話</td>
                        <td><strong><?php echo $event['other_participant_phone'][$i]['phone'] ?></strong></td>

                    </tr>
                </tbody>
            </table>
        </div>
        <?php endfor; ?>
        <?php endif; ?>
        <div class="col-lg-12">
            <div class="panel-heading panel-body table-bordered">
                <h4 class="text-gray padding-text">訂單詳細資料</h4>
            </div>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>訂單編號</td>
                        <td colspan="3"><?php echo $order_id; ?></td>
                    </tr>
                    <tr>
                        <td>活動名稱</td>
                        <td colspan="3"><?php echo $event['event_title']; ?></td>
                    </tr>
                    <tr>
                        <td>店名</td>
                        <td colspan="3"><?php echo $event['restaurant_name']; ?></td>
                    </tr>
                    <tr>
                        <td>地址</td>
                        <td colspan="3"><?php echo $event['restaurant_address']; ?></td>
                    </tr>
                    <tr>
                        <td>場次時間</td>
                        <td><strong><?php echo date('Y/m/d H:i', strtotime($event['room_open_time'])); ?> - <?php echo date('H:i', strtotime($event['room_close_time'])); ?></strong></td>
                        <td class="text-right">報名人數</td>
                        <td><strong><?php echo $event['extra_people']; ?></strong> 人</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">報名費</td>
                        <td><strong>$<?php echo number_format($event['fees'], 0, '.', ','); ?></strong> 元</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">報名費總計</td>
                        <td><strong class="h4 text-blue">$<?php echo number_format($event['extra_people'] * $event['fees'], 0, '.', ','); ?></strong> 元</td>
                    </tr>
                </tbody>
            </table>
        </div> 
    </div>
    <!-- /.row -->

    <?php if ($has_cockroach): ?>
    <div class="row">
        <div class="col-lg-12 text-center padding-btn">
            <button onclick="window.history.back()" class="btn btn-db"><<修改資料</button>
            <button type="submit" class="btn btn-rb">確認送出>></button>
        </div> 
    </div>
    <?php endif; ?>

    <?php echo isset($cockroach)? form_hidden('cockroach', $cockroach) : ''; ?>
    <?php echo form_close(); ?>
    <!-- Bank Note Section -->
    <?php $this->load->view('front/bank_note'); ?>
    <!-- /.row -->
</div>
<!-- /.container  -->