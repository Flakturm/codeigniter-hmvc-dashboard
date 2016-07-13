<!DOCTYPE html>
<html lang="utf-8">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Andy">

    <title><?php echo $site_title; ?></title>

    <?php if ($site_favicon): ?>
    <link rel="icon shortcut" href="<?php echo base_url(); ?>theme/img/logo/<?php echo $site_favicon; ?>">
    <?php else: ?>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>theme/img/favicon.ico">
    <?php endif; ?>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>theme/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>theme/css/uielement.css">

    <!-- Custom CSS -->
    <?php if(isset($css)){queue_css($css);} ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>theme/css/modern-business.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>theme/css/style.css">

    <!-- Custom Fonts -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>theme/css/font-awesome/css/font-awesome.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>
<body <?php echo ( isset($root_page) )? 'id="' . $root_page . '"' : '' ?>>