<?php echo modules::run("common/header"); ?>

<!-- Page Content -->
<div class="container">
    <!-- Form Section -->
    <?php echo ( $value['paid'] == FALSE OR @$flash_fail == TRUE )? form_open($auth_url, '', $third_party) : ''; ?>
    <div class="row mt35">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <h3 class="page-header text-green no-padding-b">
                <?php echo ($value['paid'] == FALSE)? '請確認以下資料是否正確無誤' : '訂單已付清款項' ?>
            </h3>
        </div>
        <?php if ( @$flash_fail == TRUE ): ?>
            <div class="col-lg-12 col-sm-12 col-xs-12 alert alert-danger">
                付款失敗
            </div>  
        <?php endif; ?>      
        <?php if ( @$flash_paid == TRUE ): ?>
            <div class="col-lg-12 col-sm-12 col-xs-12 alert alert-success">
                付款成功
            </div>
        <?php endif; ?>
        <div class="col-lg-12 col-sm-12 col-xs-12 form-group">
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
        <?php if ( $value['extra_ppl'] > 1 ): ?>
        <?php for ( $i = 0; $i < $value['extra_ppl'] - 1; $i++ ): ?>
        <div class="col-lg-12 form-group">
            <div class="panel-heading panel-body table-bordered">
                <h4 class="text-gray padding-text">同行人員<?php echo $i + 1; ?></h4>
            </div>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>報名人員</td>
                        <td><strong><?php echo $value['other_participant_name'][$i]['name'] ?></strong></td>
                        <td>聯絡電話</td>
                        <td><strong><?php echo $value['other_participant_phone'][$i]['phone'] ?></strong></td>

                    </tr>
                </tbody>
            </table>
        </div>
        <?php endfor; ?>
        <?php endif; ?>
        <div class="col-lg-12 col-sm-12 col-xs-12">
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
                        <td><strong><?php echo date('Y-m-d H:i', strtotime($event['room_open_time'])); ?> - <?php echo date('Y-m-d H:i', strtotime($event['room_close_time'])); ?></strong></td>
                        <td class="text-right">報名人數</td>
                        <td><strong><?php echo $value['extra_ppl'] + 1; ?></strong> 人</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">報名費</td>
                        <td><strong>$<?php echo number_format($event['fees'], 0, '.', ','); ?></strong> 元</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">報名費總計</td>
                        <td><strong class="h4 text-blue">$<?php echo number_format(($value['extra_ppl'] + 1) * $event['fees'], 0, '.', ','); ?></strong> 元</td>
                    </tr>
                </tbody>
            </table>
        </div> 
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12 text-center padding-btn">
    <?php if ( $value['paid'] == FALSE OR @$flash_fail == TRUE ): ?>
        <button type="submit" class="btn btn-db">確認送出>></button>
    <?php else: ?>
        <a href="<?php echo site_url('event/' . $event['slug']) ?>" class="btn btn-db">回活動頁面</a>
    <?php endif; ?>
        </div> 
    </div>
    
    <?php echo ( $value['paid'] == FALSE OR @$flash_fail == TRUE )? form_close() : ''; ?>
</div>
<!-- /.container  -->

<?php $this->load->view('front/footer'); ?>