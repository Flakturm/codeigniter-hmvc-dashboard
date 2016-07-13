                <!-- START row -->
                <div class="row">
                    <div class="col-md-12">
                        <?php if($flash_message): ?>
                            <div class="alert alert-dismissable alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <?php echo $flash_message; ?>
                            </div>
                        <?php endif; ?>
                        <div class="panel panel-default">

                            <table class="table table-striped" id="part-configuration">
                                <thead>
                                    <tr class="head_font">
                                        <th>訂單編號</th>
                                        <th>報名人</th>
                                        <th>課程</th>
                                        <th>聯絡電話</th>
                                        <th>報名人數</th>
                                        <th>報名日期</th>
                                        <th>訂單狀態</th>
                                        <th>金流狀態</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($participants as $participant): ?>
                                    <tr <?php if( $participant->status == '訂位' AND $participant->fail == FALSE AND $participant->paid == FALSE ): ?>class="warning"<?php endif; ?>>
                                        <td><?php echo $participant->order_id; ?></td>
                                        <td><?php echo $participant->participant_name; ?></td>
                                        <td><?php echo $participant->event_title; ?></td>
                                        <td><?php echo $participant->participant_phone; ?></td>
                                        <td><?php echo $participant->extra_ppl + 1; ?></td>
                                        <td><?php echo $participant->date_added; ?></td>
                                        <?php
                                            $label_code = '';
                                            switch ($participant->status) {
                                                case '訂位':
                                                    $label_code = 'teal';
                                                    break;

                                                case '取消':
                                                    $label_code = 'danger';
                                                    break;
                                                
                                                default:
                                                    $label_code = 'default';
                                                    break;
                                            }
                                            if( $participant->fail == TRUE )$label_code = 'inverse';
                                        ?>
                                        <td>
                                            <span class="label label-<?php echo $label_code; ?>">
                                                <?php echo $participant->status; ?><?php if( $participant->fail == TRUE ): ?>失敗<?php elseif( $participant->paid == TRUE AND $participant->status == "候補" ): ?>付款成功<?php endif; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if( $participant->status == '訂位' OR $participant->status == '候補' ): ?>
                                                <?php if( $participant->status == '訂位' AND $participant->fail == TRUE ): ?>
                                                    <span class="label label-inverse">未請款 (已授權)</span>
                                                <?php elseif( $participant->status == '候補' AND $participant->fail == TRUE ): ?>
                                                    <span class="label label-default">N/A</span>
                                                <?php elseif( $participant->fail == FALSE AND $participant->paid == TRUE ): ?>
                                                    <span class="label label-teal">已請款</span>
                                                <?php else: ?>
                                                    <span class="label label-danger">未付款</span>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="label label-default">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo site_url('admin/' . $root_page . '/edit/' . $participant->participant_id); ?>" class="btn btn-sm btn-success" data-toggle="tooltip" data-original-title="編輯">
                                                <i class="ico-pencil2"></i>
                                            </a>
                                            <?php if( ($participant->status == '訂位' AND $participant->fail == FALSE AND $participant->paid == FALSE )
                                                        OR ($participant->status == '候補' AND $participant->fail == FALSE AND $participant->paid == FALSE) ): ?>
                                                <a href="<?php echo site_url('admin/' . $root_page . '/pay/' . $participant->token); ?>" class="btn btn-sm btn-primary ml5" target="_blank" data-toggle="tooltip" data-original-title="付款">
                                                    <i class="ico-cart6"></i>
                                                </a>
                                                <a href="" class="btn btn-sm btn-primary ladda-button bootbox-confirm ml5" data-style="slide-right" data-id="<?php echo $participant->participant_id; ?>" data-toggle="tooltip" data-original-title="寄通知付款信">
                                                    <i class="ico-envelop"></i>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <p>
                        <span class="label label-inverse mr5">訂位失敗</span><span class="label label-inverse mr5">未請款 (已授權)</span>付款前已沒有位。有付款但未請款。</p>
                        <p><span class="label label-danger mr5">未付款</span>使用者有佔到位子但是沒有付款。需聯絡瞭解狀況。</p>
                    </div>
                </div>
                <!--/ END row -->