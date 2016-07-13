<!-- Page Content -->
<div class="container">

    <!-- Complete Section -->
    <div class="row mt35">
        <div class="col-lg-12">
            <h3 class="page-header text-green no-padding-b">
                <?php echo $flash_status; ?><?php echo ($flash_fail)? '失敗' : '成功'; ?>！
            </h3>
        </div>
        <div class="col-lg-12 form-group">
            <div class="panel-heading panel-body table-bordered">
                
            </div>
            <div class="panel panel-default text-center">
                <ul class="list-group">
                    <li class="list-group-item"><strong class="text-green padding-text h4">系統已收到您的資料</strong> 
                        <div class="padding-text alert alert-<?php echo ($flash_fail)? 'danger' : 'success'; ?> mt10">
                            <?php if ($flash_fail): ?>
                                <p><?php echo $flash_status; ?>失敗</p>
                            <?php else: ?>
                            <p><b>恭喜你已<?php echo $flash_status; ?>成功此活動</b><p>
                            <p><?php if ($flash_status == '候補'): ?>
                            候補資料填寫完成後，若有名額釋出，將由專人和您聯繫；若無名額釋出，將不會主動和您聯繫，謝謝！
                            <?php else: ?>
                            若欲查詢訂單資料，請至「訂單查詢」輸入您的Email信箱與訂位密碼進行查詢。
                            <?php endif; ?></p>
                            <?php endif; ?>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="text-center">若有任何問題請撥打02-7702-1168#63林小姐(週一至週五09:30-18:30)尋求協助</div>
        </div>   
    </div>
    <!-- /.row -->


    <?php if ($flash_status != '候補'): ?>
    <div class="row">
        <div class="col-lg-12 text-center padding-btn">
        <?php if ($slug): ?>
        <a href="<?php echo site_url('event/' . $slug) ?>" class="btn btn-db">回活動頁</a>
        <?php endif; ?>
        <a href="<?php echo site_url('search') ?>" class="btn btn-db">訂單查詢</a>
        </div> 
    </div>
    <?php endif; ?>

    <!-- Bank Note Section -->
    <?php $this->load->view('front/bank_note'); ?>
    <!-- /.row -->
</div>
<!-- /.container  -->