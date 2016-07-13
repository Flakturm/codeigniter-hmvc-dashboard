<!DOCTYPE html>
<!--AUTHOR : Andy-->
<!-- <html lang="en"> -->
<html class="backend">
    <!-- START Head -->
    <head>
        <!-- START META SECTION -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Dashboard</title>
        <meta name="author" content="Andy">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url(); ?>theme/img/touch/apple-touch-icon-144x144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url(); ?>theme/img/touch/apple-touch-icon-114x114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url(); ?>theme/img/touch/apple-touch-icon-72x72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="<?php echo base_url(); ?>theme/img/touch/apple-touch-icon-57x57-precomposed.png">
        <?php if ($site_favicon): ?>
        <link rel="icon shortcut" href="<?php echo base_url(); ?>theme/img/logo/<?php echo $site_favicon; ?>">
        <?php else: ?>
        <link rel="shortcut icon" href="<?php echo base_url(); ?>theme/img/favicon.ico">
        <?php endif; ?>
        <!--/ END META SECTION -->

        <!-- START STYLESHEETS -->
        <!-- Plugins stylesheet : optional -->
        <?php if (isset($top_level)): ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>theme/plugins/datatables/css/datatables.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>theme/plugins/datatables/css/tabletools.css">
        <?php endif; ?>
        <?php if(isset($css)){queue_css($css);} ?>
        <!--/ Plugins stylesheet : optional -->

        <!-- Application stylesheet : mandatory -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>theme/css/bootstrap.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>theme/css/layout.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>theme/css/uielement.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>theme/css/custom.css">
        <!--/ Application stylesheet -->

        <!-- Theme stylesheet : optional -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>theme/css/themes/theme2.css">
        <!--/ Theme stylesheet : optional -->

        <!-- modernizr script -->
        <script type="text/javascript" src="<?php echo base_url(); ?>theme/plugins/modernizr/js/modernizr.js"></script>
        <!--/ modernizr script -->
        <!-- END STYLESHEETS -->
    </head>
    <!--/ END Head -->
    <!-- START Body -->
    <body>