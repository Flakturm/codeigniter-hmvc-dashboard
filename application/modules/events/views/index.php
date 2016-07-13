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

                            <table class="table table-striped" id="zero-configuration">
                                <thead>
                                    <tr class="head_font">
                                    	<th>活動編號</th>
                                        <th>類別</th>
                                        <th>名稱</th>
                                        <th>活動日期</th>
                                        <th>餐廳</th>
                                        <th>總共名額</th>
                                        <th>剩下名額</th>
                                        <th>剩下候補名額</th>
                                        <th>狀態</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php foreach($events as $event): ?>
                                    <tr>
                                    	<td><?php echo $event->uid; ?></td>
                                        <td><?php echo $event->category_name; ?></td>
                                        <td><?php echo $event->event_title; ?></td>
                                        <td><?php echo $event->event_date; ?></td>
                                        <td><?php echo $event->restaurant_name; ?></td>
                                        <td><?php echo $event->slots; ?></td>
                                        <?php
                                            $badge = '';
                                            switch (true) {
                                                case $event->remaing_slots < 5:
                                                    $badge = 'danger';
                                                    break;

                                                case $event->remaing_slots < 10 && $event->remaing_slots >= 5:
                                                    $badge = 'warning';
                                                    break;
                                                
                                                default:
                                                    $badge = 'success';
                                                    break;
                                            }
                                        ?>
                                        <td><span class="badge badge-<?php echo $badge; ?>"><?php echo $event->remaing_slots; ?></span></td>
                                        <td><span class="badge badge-info"><?php echo $event->remaing_waiting_slots; ?></span></td>
                                        <?php
                                        	$label_code = '';
                                        	switch ($event->status) {
                                        		case '進行中':
                                        			$label_code = 'warning';
                                        			break;

                                        		case '已結束':
                                        			$label_code = 'danger';
                                        			break;
                                        		
                                        		default:
                                        			$label_code = 'default';
                                        			break;
                                        	}
                                        ?>
                                        <td><span class="label label-<?php echo $label_code; ?>"><?php echo $event->status; ?></span></td>
                                        <td>
                                        	<?php if($event->status != '已結束'): ?>
                                                <a href="<?php echo $root_page . '/edit/' . $event->event_id; ?>">
                                            		<button type="button" class="btn btn-sm btn-success mr5" data-toggle="tooltip" data-original-title="編輯">
    	                                                <i class="ico-pencil2"></i>
    	                                            </button>
                                                </a>
                                        	<?php endif; ?>
                                            <a href="<?php echo $root_page . '/preview/' . $event->token; ?>" target="_blank" class="btn btn-sm btn-info mr5" data-toggle="tooltip" data-original-title="預覽">
                                               	<i class="ico-screen2"></i>
                                            </a>
                                            <?php if ($event->status != '草稿'): ?>
                                            <a href="<?php echo site_url('/event/' . $event->slug); ?>" target="_blank" class="btn btn-sm btn-primary" data-toggle="tooltip" data-original-title="前往">
                                                <i class="ico-arrow-right"></i>
                                            </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--/ END row -->