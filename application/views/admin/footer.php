		<!-- <footer>
		Developed by Andy
		</footer> -->

		<!-- START JAVASCRIPT SECTION (Load javascripts at bottom to reduce load time) -->
        <!-- Application and vendor script : mandatory -->
        <script type="text/javascript" src="<?php echo base_url(); ?>theme/js/vendor.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>theme/js/core.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>theme/js/backend/app.js"></script>
        <!--/ Application and vendor script : mandatory -->

        <!-- Plugins and page level script : optional -->
        <?php if (isset($top_level)): ?>
        <script type="text/javascript" src="<?php echo base_url(); ?>theme/plugins/datatables/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>theme/plugins/datatables/tabletools/js/dataTables.tableTools.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>theme/plugins/datatables/js/datatables-bs3.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>theme/js/backend/tables/datatable.js"></script>
        <?php endif; ?>
        <!--/ Plugins and page level script : optional -->
        <?php if(isset($plugin_js)){queue_js($plugin_js);} ?>
        <?php if(isset($backend_js)){queue_js($backend_js, true);} ?>        
        <script type="text/javascript" src="<?php echo base_url(); ?>theme/js/backend/custom.js"></script>
        <!--/ END JAVASCRIPT SECTION -->
    </body>
    <!--/ END Body -->
</html>