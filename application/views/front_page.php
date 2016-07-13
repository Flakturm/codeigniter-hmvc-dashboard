<?php echo modules::run("common/header"); ?>

	<!-- hide menu if on login page -->
	<?php echo modules::run("common/menu"); ?>

    <?php $this->load->view($main_content); ?>
    
<?php echo modules::run("common/footer"); ?>