<!-- Page Content -->
<div class="container">

    <!-- Marketing Icons Section -->
    <div class="row mt35">
        <div class="col-lg-12">
            <h3 class="page-header text-green no-padding-b">
                查詢報名
            </h3>
        </div>
    </div>
    <!-- /.row -->

    <!-- Content Section -->
    <?php echo form_open('', 'class="ajax-form"'); ?>
    <div class="row">
        <div class="message-container"></div>
        <div class="col-md-12">
            <div class="text-word" style="margin-bottom:20px;">
                <div class="control-group form-group padding-form">
                    <div class="controls">
                        <label class="text-gray h4">報名編號</label>
                        <input type="text" class="form-control" name="order_id" required placeholder="請輸入報名編號">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="control-group form-group padding-form">
                    <div class="controls">
                        <label class="text-gray h4">Email 信箱</label>
                        <input type="tel" class="form-control" name="email" required placeholder="請輸入有效信箱">
                        <p class="help-block"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="text-center padding-btn">
                <button type="submit" data-style="zoom-in" class="btn btn-db ladda-button next-btn">查詢</button>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <?php echo form_close(); ?>
    <input type="hidden" id="ajax-url" value="/search/ajaxSearch" >

    <?php $this->load->view('front/bank_note'); ?>
</div>
<!-- /.container -->