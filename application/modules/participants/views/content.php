            <!-- START row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="row mb15">
                        <div class="col-md-11 message-container"></div>
                        <div class="col-md-1 text-right">
                            <a href="<?php echo site_url('admin/' . $root_page); ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="上一頁"><i class="ico-undo"></i></a>
                        </div>
                    </div>
                    <!-- START panel -->
                    <div class="panel panel-default">
                        <!-- panel heading/header -->
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="ico-bubble-user mr5"></i> 報名者</h3>
                        </div>
                        <!--/ panel heading/header -->
                        <!-- panel body -->
                        <div class="panel-body">
                            <div class="form-horizontal form-bordered">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">報名活動</label>
                                    <div class="col-sm-8">
                                        <p class="form-control-static"><?php echo $participant['event_title']; ?></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">報名時間</label>
                                    <div class="col-sm-8">
                                        <p class="form-control-static"><?php echo $participant['date_added']; ?></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">訂單編號</label>
                                    <div class="col-sm-8">
                                        <p class="form-control-static"><?php echo $participant['order_id']; ?></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">狀態</label>
                                    <div class="col-sm-8">
                                        <?php if($participant['status'] == '取消'): ?>
                                            <span class="label label-danger"><?php echo $participant['status']; ?></span>
                                        <?php else: ?>
                                            <a href="" id="status" data-type="select" data-value="<?php echo $participant['status']; ?>" data-pk="<?php echo $participant['participant_id'];?>" class="editable editable-click"></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">姓名</label>
                                    <div class="col-sm-8">
                                        <a href="" id="participant_name" class="edit-txt" data-type="text" data-pk="<?php echo $participant['participant_id'];?>"><?php echo (isset($participant['participant_name']))?$participant['participant_name']:''; ?></a>
                                    </div>
                                </div>
                                <div class="form-group">
                                   <label class="col-sm-3 control-label">聯絡電話</label>
                                    <div class="col-sm-8">
                                        <a href="" id="participant_phone" class="edit-txt" data-type="text" data-pk="<?php echo $participant['participant_id'];?>"><?php echo (isset($participant['participant_phone']))?$participant['participant_phone']:''; ?></a>
                                    </div>
                                </div>
                                <div class="form-group">
                                   <label class="col-sm-3 control-label">訂位密碼</label>
                                    <div class="col-sm-8">
                                        <a href="" id="password" class="edit-txt" data-type="password" data-pk="<?php echo $participant['participant_id'];?>">更改</a>
                                    </div>
                                </div>
                                 <div class="form-group">
                                   <label class="col-sm-3 control-label">聯絡信箱</label>
                                    <div class="col-sm-8">
                                        <a href="" id="email" class="edit-txt" data-type="email" data-pk="<?php echo $participant['participant_id'];?>"><?php echo (isset($participant['email']))?$participant['email']:''; ?></a>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">是否需要統編</label>
                                     <div class="col-sm-2">
                                        <a href="" id="invoice_status" data-type="select" data-url="<?php echo site_url('admin/'.$root_page.'/ajaxPartUpdate');?>" data-value="<?php echo $participant['invoice_status']; ?>" data-pk="<?php echo $participant['participant_id'];?>" class="editable editable-click"></a>
                                    </div>
                                </div>
                                <div class="form-group invoice-block">
                                    <label class="col-sm-3 control-label">發票類型</label>
                                    <div class="col-sm-8">
                                        <div class="row mb5">
                                            <div class="col-sm-3">
                                                <a href="" id="invoice_types" data-type="select" data-url="<?php echo site_url('admin/'.$root_page.'/ajaxPartUpdate');?>" data-value="<?php echo $participant['invoice_types']; ?>" data-pk="<?php echo $participant['participant_id'];?>" class="editable editable-click"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <label class="col-sm-3 control-label">抬頭</label>
                                    <div class="col-sm-8">
                                        <div class="row mb5">
                                            <div class="col-sm-3">
                                                <a href="" id="invoice_title" class="edit-txt" data-type="text" data-pk="<?php echo $participant['participant_id'];?>"><?php echo (isset($participant['invoice_title']))?$participant['invoice_title']:''; ?></a>
                                            </div>                                            
                                        </div>
                                    </div>
                                    <label class="col-sm-3 control-label">統一編號</label>
                                    <div class="col-sm-8">
                                        <div class="row mb5">
                                            <div class="col-sm-3">
                                                <a href="" id="invoice_number" class="edit-txt" data-type="text" data-pk="<?php echo $participant['participant_id'];?>"><?php echo (isset($participant['invoice_number']))?$participant['invoice_number']:''; ?></a>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if($extraParticipants): ?>
                        <!-- panel body -->
                        <!-- panel heading/header -->
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="ico-bubble-user mr5"></i> 攜帶 <?php echo count($extraParticipants) ?> 人</h3>
                        </div>
                        <!--/ panel heading/header -->
                        <!-- panel body -->
                        <div class="panel-body">
                            <div class="form-horizontal form-bordered">
                                <?php foreach ($extraParticipants as $value): ?>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">姓名</label>
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <a href="" id="other_participant_name" class="other-edit-txt" data-type="text" data-pk="<?php echo $value['extra_participants_id'];?>"><?php echo $value['other_participant_name']; ?></a>
                                            </div>
                                            <label class="col-sm-1 control-label">聯絡電話</label>
                                            <div class="col-sm-3">
                                                <a href="" id="other_participant_phone" class="other-edit-txt" data-type="text" data-pk="<?php echo $value['extra_participants_id'];?>"><?php echo $value['other_participant_phone']; ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <!-- panel body -->
                        <?php endif; ?>

                    </div>
                    <!--/ END form panel -->
                </div>
            </div>
            <!--/ END row -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var url = '<?php echo site_url('admin/'.$root_page.'/ajaxPartUpdate');?>';
                    makeTextEditable($('.edit-txt'), url);
                    var url = '<?php echo site_url('admin/'.$root_page.'/ajaxOtherPartUpdate');?>';
                    makeTextEditable($('.other-edit-txt'), url);

                    var source = new Array();
                    <?php
                    foreach ( $invoice_types as $value ): 
                    echo "source.push({value: '$value', text: '$value'});";
                    endforeach; 
                    ?>
                    makeSelectEditable($('#invoice_types'), source);


                    // hide invoice details
                    if ($('#invoice_status').data('value') == 0) {
                        $('.invoice-block').hide();
                    };
                }, false);    
            </script>