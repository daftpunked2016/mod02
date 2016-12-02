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
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/dist/css/skins/skin-black.min.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo Yii::app()->request->baseUrl; ?>/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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

      <?php $this->widget('AdminHeader'); ?>

      <?php $this->widget('AdminLeftside'); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <!-- Main content -->
        <?php
          $fileupload = Fileupload::model()->findByPk($userbusiness->business_avatar);
          $business_avatar = $fileupload->filename;
          $businesstype = BusinessSubtype::model()->findByPk($userbusiness->business_type_id);
          $businesscat = BusinessCategory::model()->findByPk($businesstype->type);
          $city = Cities::model()->findByPk($userbusiness->city_id);
          $province = Provinces::model()->findByPk($userbusiness->province_id);
        ?>
          <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Business Profile
            <small>Preview of Business Information</small>
          </h1>
        </section>
            <!-- Main content -->
        <div class="row">
          <section class="invoice">
              <!-- title row -->
              <div class="row">
                <div class="col-xs-12">
                  <h2 class="page-header">
                    <i class="fa fa-building"></i> <?php echo $userbusiness->business_name; ?> <!-- business name -->
                    <small class="pull-right"><?php echo $userbusiness->operating_hours; ?></small>
                  </h2>
                </div><!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-md-4 invoice-col">
                  <!-- business avatar-->
                  <img src="<?php echo Yii::app()->request->baseUrl; ?>/business_avatars/<?php echo $business_avatar; ?>" class="img-circle" alt="User Image" style="height:235px; width:235px; display:block;margin-left:auto;margin-right:auto; margin-bottom:20px;"/>
                </div><!-- /.col -->

                <div class="col-md-8 invoice-col">
                  
                  <div class="row">
                    <div class="col-md-6 invoice-col">
                        <strong>Business Type</strong><br>
                        <?php echo $businesstype->subtype." - <i>(".$businesscat->category.")</i>"; ?> <br> <!-- business_type_id -->
                    </div>
                    <div class="col-md-6 invoice-col">
                        <strong>Operation Hours</strong><br>
                        <?php echo $userbusiness->operating_hours; ?>
                    </div><!-- /.col -->
                  </div>

                  <div class="row" style="margin-top:30px;">
                    <div class="col-md-6 invoice-col">
                      <strong>Address</strong><br>
                      <?php echo $userbusiness->address; ?><br> <!-- street -->
                      <?php echo $city->name.", ".$province->name; ?><br> <!-- city ID -->
                    </div>
                    
                    <div class="col-md-6 invoice-col">
                        <strong>Contact Info:</strong><br>
                        <?php echo $userbusiness->contact_no; ?>
                    </div><!-- /.col -->
                  </div>

                </div>
              </div>   
              
              <div class="row">
                <div class="col-sm-12 invoice-col">
                <br>
                  <strong>Business Description</strong>
                  <p><?php echo $userbusiness->description; ?></p>
                </div><!-- /.col -->
              </div>
          </section><!-- /.content -->
        </div>
      </div><!-- /.content-wrapper -->

      <?php $this->widget('UserFooter'); ?>
    
    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- DATA TABES SCRIPT -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='<?php echo Yii::app()->request->baseUrl; ?>/plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/dist/js/app.min.js" type="text/javascript"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/dist/js/demo.js" type="text/javascript"></script>

    <!-- Optionally, you can add Slimscroll and FastClick plugins.
          Both of these plugins are recommended to enhance the
          user experience. Slimscroll is required when using the
          fixed layout. -->

  <script type="text/javascript">
      $(function () {
        $("#example1").dataTable();
        $('#example2').dataTable({
          "bPaginate": true,
          "bLengthChange": false,
          "bFilter": false,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false
        });
      });
    </script>
  </body>
</html>
    