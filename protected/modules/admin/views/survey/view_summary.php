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
 		    <section class="content-header">
          <h1>
            Summary of Respondents
            <small>Item Name: <strong><?php echo $item; ?></strong></small>

            <div class="pull-right">
               <small><strong>Total Respondents:</strong> <?php echo $res_total; ?></small>
            </div>
          </h1>
        </section>
        <!-- Main content -->
      	<section class="content">
          <div class="row" style="margin-top:10px;">
          	<?php foreach(Yii::app()->user->getFlashes() as $key=>$message) {
        			if($key  === 'success')
        				{
        				echo "<div class='alert alert-success alert-dismissible' role='alert'>
        				<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
        				$message.'</div>';
        				}
        			else
        				{
        				echo "<div class='alert alert-danger alert-dismissible' role='alert'>
        				<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
        				$message.'</div>';
        				}
        			}
        		?>
        	

            <?php foreach($area_regions as $area=>$regions): 
                $area_total = SurveyResAnswers::countAreaRes($grouped_ans_count, $regions)?>
              <div class="col-md-6">
                <div class="box box-info">
                  <div class="box-header with-border">
                    <h3 class="box-title">Area <?php echo $area; ?></h3>
                    <div class="box-tools pull-right">
                      <span data-original-title="<?php echo $area_total; ?> Total Respondents" data-toggle="tooltip" title="" class="badge bg-yellow" style="margin-left:5px;"><?php echo $area_total; ?></span>
                      
                      <span data-original-title="<?php echo SurveyResAnswers::getAnsPercentage($area_total, $res_total); ?>% Percentage of Total Respondents" data-toggle="tooltip" title="" class="badge bg-aqua" style="margin-left:5px;"><?php echo  SurveyResAnswers::getAnsPercentage($area_total, $res_total); ?>%</span>
                    </div>
                  </div><!-- /.box-header -->
                  <div class="box-body" style="font-size:12px;">
                    <div class="table-responsive">
                      <table class="table table-hover no-margin">
                        <thead>
                          <tr>
                            <th width="60%">Region</th>
                            <th width="20%">Total Res.</th>
                            <th width="20%">Percentage</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach($regions as $reg_id=>$reg_name): 
                              $region_total = isset($grouped_ans_count[$reg_id]) ? $grouped_ans_count[$reg_id] : 0; ?>
                            <tr>
                              <td>
                                <a href="<?php echo Yii::app()->createUrl('admin/survey/viewrespondents',  array(
                                'q'=>$questionnaire->id, 'k'=>$k, 'area'=>$area, 'region'=>$reg_id)); ?>">
                                  <?php echo $reg_name; ?>
                                </a>
                              </td>
                              <td><?php echo ($region_total != 0) ? "<strong>{$region_total}</strong>" : "<small>0</small>"; ?></td>
                              <td><i><?php echo SurveyResAnswers::getAnsPercentage($region_total, $area_total).'%'; ?></i></td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div><!-- /.table-responsive -->
                  </div><!-- /.box-body -->
                </div>
              </div>
            <?php endforeach; ?>
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

        $('#search_filters').on("click",function(e){
          e.preventDefault();
          $("#search-well").slideToggle();
        });

      });
    </script>


  </body>
</html>