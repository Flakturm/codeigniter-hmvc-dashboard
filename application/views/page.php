<?php echo modules::run("common/adminHeader"); ?>

	<!-- hide menu if on login page -->
	<?php echo ($main_content != 'signin' ? modules::run("common/adminMenu") : ''); ?>

    <!-- START Template Main -->
    <section id="main" role="main">
    	<!-- START Template Container -->
        <div class="container-fluid">
        	<?php ($main_content == 'signin' ? '' : $this->load->view('admin/page_header')); ?>
			<?php $this->load->view($main_content); ?>
        </div>
        <!--/ END Template Container -->

        <!-- START To Top Scroller -->
        <a href="#" class="totop animation" data-toggle="waypoints totop" data-showanim="bounceIn" data-hideanim="bounceOut" data-offset="50%"><i class="ico-angle-up"></i></a>
        <!--/ END To Top Scroller -->
	</section>
    <!--/ END Template Main -->
<?php echo modules::run("common/adminFooter"); ?>