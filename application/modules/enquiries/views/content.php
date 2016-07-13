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
                            <h3 class="panel-title"><i class="ico-bubble-user mr5"></i>留言訊息</h3>
                        </div>
                        <!--/ panel heading/header -->
                        <div class="panel-body">
                            <form class="form-horizontal form-bordered" action="">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">留言時間</label>
                                    <div class="col-sm-8">
                                       <p class="help-block qa_font"><?php echo $enquiry['date_added']; ?></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">姓名</label>
                                    <div class="col-sm-8">
                                       <p class="help-block qa_font"><?php echo $enquiry['name']; ?></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                   <label class="col-sm-3 control-label">聯絡電話</label>
                                    <div class="col-sm-8">
                                       <p class="help-block qa_font"><?php echo $enquiry['phone']; ?></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                   <label class="col-sm-3 control-label">聯絡信箱</label>
                                    <div class="col-sm-8">
                                        <p class="help-block qa_font"><a href="mailto:<?php echo $enquiry['email']; ?>"><?php echo $enquiry['email']; ?></a></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                   <label class="col-sm-3 control-label">IP 位置</label>
                                    <div class="col-sm-8">
                                       <p class="help-block qa_font"><?php echo $enquiry['client_ip']; ?></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                   <label class="col-sm-3 control-label">意見描述</label>
                                    <div class="col-sm-8">
                                        <p class="help-block qa_font"><?php echo str_replace (PHP_EOL, '<br>', $enquiry['message'] ); ?></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">意見紀錄</label>
                                    <div class="col-sm-8">
                                        <a href="" id="enquiry_response" data-type="textarea" data-pk="<?php echo $enquiry['enquiry_id']; ?>"><?php echo str_replace (PHP_EOL, '<br>', $enquiry['enquiry_response'] ); ?></a>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">回覆狀態</label>
                                    <div class="col-sm-8">
                                        <a href="" id="enquiry_status" data-type="select" data-url="<?php echo site_url('admin/'.$root_page.'/ajaxUpdate');?>" data-value="<?php echo $enquiry['enquiry_status']; ?>" data-pk="<?php echo $enquiry['enquiry_id'];?>" class="editable editable-click"></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <!--/ END form panel -->
                </div>
            </div>
            <!--/ END row -->
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                var source = new Array();
                <?php
                foreach ( $statuses as $value ): 
                echo "source.push({value: '$value', text: '$value'});";
                endforeach; 
                ?>                
                makeSelectEditable($('#enquiry_status'), source);
                var url = '<?php echo site_url('admin/'.$root_page.'/ajaxUpdate');?>';
                makeTextEditable($('#enquiry_response'), url);
            }, false);
            </script>