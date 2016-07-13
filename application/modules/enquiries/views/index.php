                <!-- START row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <table class="table table-striped" id="zero-configuration">
                                <thead>
                                    <tr class="head_font">
                                        <th>編號</th>
                                        <th>留言時間</th>
                                        <th>姓名</th>
                                        <th>聯絡電話</th>
                                        <th>聯絡信箱</th>
                                        <th>留言</th>
                                        <th>狀態</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($enquiries as $enquiry): ?>
                                    <tr>
                                        <td><?php echo $enquiry->enquiry_id; ?></td>
                                        <td><?php echo $enquiry->date_added; ?></td>
                                        <td><?php echo $enquiry->name; ?></td>
                                        <td><?php echo $enquiry->phone; ?></td>
                                        <td><?php echo $enquiry->email; ?></td>
                                        <td><?php echo sub_str($enquiry->message, 60); ?></td>
                                        <?php
                                            $label_code = '';
                                            switch ($enquiry->enquiry_status) {
                                                case '已回覆':
                                                    $label_code = 'teal';
                                                    break;

                                                case '待處理':
                                                    $label_code = 'danger';
                                                    break;
                                                
                                                default:
                                                    $label_code = 'default';
                                                    break;
                                            }
                                        ?>
                                        <td><span class="label label-<?php echo $label_code; ?>"><?php echo $enquiry->enquiry_status; ?></span></td>
                                        <td>
                                            <a href="<?php echo $root_page . '/edit/' . $enquiry->enquiry_id; ?>">
                                                <button type="button" class="btn btn-sm btn-success mr10" data-toggle="tooltip" data-original-title="編輯">
                                                    <i class="ico-pencil2"></i>
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--/ END row -->