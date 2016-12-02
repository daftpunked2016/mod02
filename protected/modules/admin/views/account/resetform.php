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

        <section id="flashAlert">
            <?php foreach(Yii::app()->user->getFlashes() as $key=>$message) {
              if($key  === 'success')
                    {
                    echo "<div class='alert alert-success alert-dismissible' role='alert' style='margin-bottom:5px'>
                    <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
                    $message.'</div>';
                    }
                  else
                    {
                    echo "<div class='alert alert-danger alert-dismissible' role='alert' style='margin-bottom:5px'>
                    <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
                    $message.'</div>';
                    }
                  
            } 
          ?>
        </section>

        <!-- Content Header (Page header) -->
 		    <section class="content-header">
          <h1 class="text-center">
            ACCOUNT RESET
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-4"></div>

            <div class="col-md-4">
              <div class="well" style="padding:30px;">
                <h4 class="login-box-msg">Select Filter</h4>

                <div class="form">
                  <form method="post">
                      
                      <div class="row" style="margin-bottom:15px;">
                        <div class="form-group">
                          <div class="col-sm-4">
                            <label for="position_id">Position</label>
                          </div>
                          <div class="col-sm-8">
                            <select id="position_id" name="position" class="form-control">
                              <option value ='*'> ALL * </option>
                              <?php 
                                $positions = Position::model()->findAll();
                                
                                foreach($positions as $position)
                                  echo "<option value = ".$position->id.">".$position->position."</option>";
                              ?>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="row" style="margin-bottom:15px;">
                        <div class="form-group">
                          <?php $regions = AreaRegion::model()->findAll(array('select'=>'area_no', 'distinct'=>true)); ?>
                          <div class="col-sm-4">
                            <label for="area_no">Area No. *</label>
                          </div>

                          <div class="col-sm-8">
                            <select id="area_no2" name="area_no" class="form-control">
                              <option value ='*'>ALL *</option>
                              <?php 
                                foreach($regions as $region)
                                  echo "<option value=".$region->area_no.">".$region->area_no."</option>";
                              ?>
                            <select>
                          </div>
                        </div>
                      </div>

                      <div class="row" style="margin-bottom:15px;"> 
                        <div class="form-group">
                          <div class="col-sm-4">
                            <label for="region">Region *</label>
                          </div>
                          <div class="col-sm-8">
                            <select id="region2" name="region" class="form-control">
                              <option value="*"> ALL * <option>
                            <select>
                          </div>
                        </div>
                      </div>

                      <div class="row" style="margin-bottom:15px;">
                        <div class="form-group">
                          <div class="col-sm-4">
                            <label for="region">Chapter *</label>
                          </div>
                          <div class="col-sm-8" >
                            <select id="chapter2" name="chapter" class="form-control">
                              <option value="*"> ALL * <option>
                            <select>
                          </div>
                        </div>
                      </div>

                      <div class="row buttons">
                        <?php echo CHtml::submitButton('R E S E T', array('class'=>'btn btn-danger btn-block pull-right', 'name'=>'submit', 'confirm'=>'You`re trying to reset all account of JCI Phillipines. Click `OK` to proceed. Please take note: This action is Irrevocable. ')); ?>
                      </div>

                  </form>
                </div>
              </div>
            </div>

            <div class="col-md-4"></div>
          </div>
        </section><!-- /.content -->

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

    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/form-scripts.js" type="text/javascript"></script>

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