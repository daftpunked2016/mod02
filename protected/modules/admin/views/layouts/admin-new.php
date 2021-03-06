<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="UTF-8">
    <title>Administrator Dashboard | JCI PH</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/dist/css/skins/skin-black.min.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/acss/screen.css" media="screen, projection" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/acss/print.css" media="print" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/acss/main.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/acss/form.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/acss/fonts.css" />
     
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/ajs/jquery-1.9.1.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/ajs/modernizr.custom.js"></script>

    <!-- Bootstrap -->
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/acss/bootstrap.min.css" rel="stylesheet">
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/ajs/bootstrap.min.js"></script>
        <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/plugins/jQuery/jQuery-2.1.4.min.js"></script>
  </head>
  <!--
  BODY TAG OPTIONS:
  =================
  Apply one or more of the following classes to get the
  desired effect
  |---------------------------------------------------------|
  | SKINS         | skin-blue                               |
  |               | skin-black                              |
  |               | skin-purple                             |
  |               | skin-yellow                             |
  |               | skin-red                                |
  |               | skin-green                              |
  |---------------------------------------------------------|
  |LAYOUT OPTIONS | fixed                                   |
  |               | layout-boxed                            |
  |               | layout-top-nav                          |
  |               | sidebar-collapse                        |
  |               | sidebar-mini                            |
  |---------------------------------------------------------|
  -->
  <body class="skin-black sidebar-mini">
    <div class="wrapper">

      <!-- Main Header -->
      <?php $this->widget('AdminHeader') ?>
      
      <!-- Left side column. contains the logo and sidebar -->
      <?php $this->widget('AdminLeftside'); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
         <?php echo $content; ?>
      </div><!-- /.content-wrapper -->
      
      <footer class="main-footer">
        <?php $this->widget('UserFooter'); ?>
         <!-- Main Footer -->
      </footer>
      

    </div><!-- ./wrapper -->

    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/dist/js/app.min.js" type="text/javascript"></script>

    <!-- Optionally, you can add Slimscroll and FastClick plugins.
          Both of these plugins are recommended to enhance the
          user experience. Slimscroll is required when using the
          fixed layout. -->
  </body>
</html>