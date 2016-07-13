<!-- Footer -->
<div>
    <div class="row footer-color">
        <div class="col-lg-12">
            <p class="padding-text">版權所有，未經許可，不許轉載  © 2016 WinWin Media 定贏傳媒股份有限公司 •</p>
            <P>主辦單位有決定取消、終止、修改或暫停上述一切活動之權利。</P>
        </div>
    </div>

    <script type="text/javascript" src="<?php echo base_url(); ?>theme/js/vendor.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>theme/js/core.js"></script>   

    <?php if(isset($plugin_js)){queue_js($plugin_js);} ?>
    <?php if(isset($js)){queue_js($js, '', TRUE);} ?>

    <script type="text/javascript" src="<?php echo base_url(); ?>theme/js/front/custom.js"></script>

    <?php if (@$ga_code): ?>
    <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
    <script>
        window.ga=function(){ga.q.push(arguments)};ga.q=[];ga.l=+new Date;
        ga('create','<?php echo $ga_code ?>','auto');ga('send','pageview')
    </script>
    <script src="https://www.google-analytics.com/analytics.js" async defer></script>
    <?php endif; ?>

</body>

</html>