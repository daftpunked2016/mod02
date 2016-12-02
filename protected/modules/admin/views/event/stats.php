




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
        
        <section class="content-header" style="margin-bottom: 20px;">
		  <h1>
		    <?php echo $event->name; ?>
		    <small>Event Statistics</small>
		  </h1>
		</section>

		<section class="content">

			<div class="row">
	            <div class="col-md-3 col-sm-6 col-xs-12">
	              <div class="info-box">
	                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-people-outline"></i></span>
	                <div class="info-box-content">
	                  <span class="info-box-text">Registrants</span>
	                  <span class="info-box-number"><?php echo Event::model()->countAttendees($event_attendees);?></span>
	                </div><!-- /.info-box-content -->
	              </div><!-- /.info-box -->
	            </div><!-- /.col -->
	            <div class="col-md-3 col-sm-6 col-xs-12">
	              <div class="info-box">
	                <span class="info-box-icon bg-red"><i class="fa fa-upload"></i></span>
	                <div class="info-box-content">
	                  <span class="info-box-text">Uploaded Payments</span>
	                  <span class="info-box-number"><?php echo Event::model()->countTotalUploadedPayments($payments);?></span>
	                </div><!-- /.info-box-content -->
	              </div><!-- /.info-box -->
	            </div><!-- /.col -->

	            <!-- fix for small devices only -->
	            <div class="clearfix visible-sm-block"></div>

	            <div class="col-md-3 col-sm-6 col-xs-12">
	              <div class="info-box">
	                <span class="info-box-icon bg-green"><i class="fa fa-check-square-o"></i></span>
	                <div class="info-box-content">
	                  <span class="info-box-text">Validated Payments</span>
	                  <span class="info-box-number"><?php echo Event::model()->countTotalValidatedPayments($payments);?></span>
	                </div><!-- /.info-box-content -->
	              </div><!-- /.info-box -->
	            </div><!-- /.col -->
	            <div class="col-md-3 col-sm-6 col-xs-12">
	              <div class="info-box">
	                <span class="info-box-icon bg-yellow"><i class="fa fa-money"></i></span>
	                <div class="info-box-content">
	                  <span class="info-box-text">Sales</span>
	                  <span class="info-box-number"><?php echo "Php. ".number_format(Event::model()->computeTotalSales($sales), 2, '.', ',');?></span>
	                </div><!-- /.info-box-content -->
	              </div><!-- /.info-box -->
	            </div><!-- /.col -->
	        </div><!-- /.row -->

	        <div class="row">
	        	<div class="box">
		        	<div class="box-body">
		        		<div class="col-md-3">
				    	    <div class="box">
				    	    	
				    	    	<div class="box-body">
					              <p class="text-center">
					                <strong>Total Registrants</strong>
					              </p>
					              <div class="progress-group">
					                <span class="progress-text">Area 1</span>
					                <span class="progress-number"><?php echo "<b>".Event::model()->countAreaRegistrants($event_attendees, 1)."</b>/".Event::model()->countAreaMembers($accounts, 1); ?></span>
					                <div class="progress sm">
					                  <div class="progress-bar progress-bar-aqua" style="width: <?php echo Event::model()->getPercentage($event_attendees, $accounts, 1);?>%"></div>
					                </div>
					              </div><!-- /.progress-group -->
					              <div class="progress-group">
					                <span class="progress-text">Area 2</span>
					                <span class="progress-number"><?php echo "<b>".Event::model()->countAreaRegistrants($event_attendees, 2)."</b>/".Event::model()->countAreaMembers($accounts, 2); ?></span>
					                <div class="progress sm">
					                  <div class="progress-bar progress-bar-red" style="width: <?php echo Event::model()->getPercentage($event_attendees, $accounts, 2);?>%"></div>
					                </div>
					              </div><!-- /.progress-group -->
					              <div class="progress-group">
					                <span class="progress-text">Area 3</span>
					                <span class="progress-number"><?php echo "<b>".Event::model()->countAreaRegistrants($event_attendees, 3)."</b>/".Event::model()->countAreaMembers($accounts, 3); ?></span>
					                <div class="progress sm">
					                  <div class="progress-bar progress-bar-green" style="width: <?php echo Event::model()->getPercentage($event_attendees, $accounts, 3);?>%"></div>
					                </div>
					              </div><!-- /.progress-group -->
					              <div class="progress-group">
					                <span class="progress-text">Area 4</span>
					                <span class="progress-number"><?php echo "<b>".Event::model()->countAreaRegistrants($event_attendees, 4)."</b>/".Event::model()->countAreaMembers($accounts, 4); ?></span>
					                <div class="progress sm">
					                  <div class="progress-bar progress-bar-yellow" style="width: <?php echo Event::model()->getPercentage($event_attendees, $accounts, 4);?>%"></div>
					                </div>
					              </div><!-- /.progress-group -->
					              <div class="progress-group">
					                <span class="progress-text">Area 5</span>
					                <span class="progress-number"><?php echo "<b>".Event::model()->countAreaRegistrants($event_attendees, 5)."</b>/".Event::model()->countAreaMembers($accounts, 5); ?></span>
					                <div class="progress sm">
					                  <div class="progress-bar progress-bar-black" style="width: <?php echo Event::model()->getPercentage($event_attendees, $accounts, 5);?>%"></div>
					                </div>
					              </div><!-- /.progress-group -->
					            </div>

				            </div>
			            </div><!-- /.col -->


			    	    <div class="col-md-3">
				    	    <div class="box">
				    	    	
				    	    	<div class="box-body">
					              <p class="text-center">
					                <strong>Unpaid Registrants</strong>
					              </p>
					              <div class="progress-group">
					                <span class="progress-text">Area 1</span>
					                <span class="progress-number"><?php echo "<b>".Event::model()->countAreaRegistrants($event_attendees, 1, 3)."</b>/".Event::model()->countAreaMembers($accounts, 1); ?></span>
					                <div class="progress sm">
					                  <div class="progress-bar progress-bar-aqua" style="width: <?php echo Event::model()->getPercentage($event_attendees, $accounts, 1, 3);?>%"></div>
					                </div>
					              </div><!-- /.progress-group -->
					              <div class="progress-group">
					                <span class="progress-text">Area 2</span>
					                <span class="progress-number"><?php echo "<b>".Event::model()->countAreaRegistrants($event_attendees, 2, 3)."</b>/".Event::model()->countAreaMembers($accounts, 2); ?></span>
					                <div class="progress sm">
					                  <div class="progress-bar progress-bar-red" style="width: <?php echo Event::model()->getPercentage($event_attendees, $accounts, 2, 3);?>%"></div>
					                </div>
					              </div><!-- /.progress-group -->
					              <div class="progress-group">
					                <span class="progress-text">Area 3</span>
					                <span class="progress-number"><?php echo "<b>".Event::model()->countAreaRegistrants($event_attendees, 3, 3)."</b>/".Event::model()->countAreaMembers($accounts, 3); ?></span>
					                <div class="progress sm">
					                  <div class="progress-bar progress-bar-green" style="width: <?php echo Event::model()->getPercentage($event_attendees, $accounts, 3, 3);?>%"></div>
					                </div>
					              </div><!-- /.progress-group -->
					              <div class="progress-group">
					                <span class="progress-text">Area 4</span>
					                <span class="progress-number"><?php echo "<b>".Event::model()->countAreaRegistrants($event_attendees, 4, 3)."</b>/".Event::model()->countAreaMembers($accounts, 4); ?></span>
					                <div class="progress sm">
					                  <div class="progress-bar progress-bar-yellow" style="width: <?php echo Event::model()->getPercentage($event_attendees, $accounts, 4, 3);?>%"></div>
					                </div>
					              </div><!-- /.progress-group -->
					              <div class="progress-group">
					                <span class="progress-text">Area 5</span>
					                <span class="progress-number"><?php echo "<b>".Event::model()->countAreaRegistrants($event_attendees, 5, 3)."</b>/".Event::model()->countAreaMembers($accounts, 5); ?></span>
					                <div class="progress sm">
					                  <div class="progress-bar progress-bar-black" style="width: <?php echo Event::model()->getPercentage($event_attendees, $accounts, 5, 3);?>%"></div>
					                </div>
					              </div><!-- /.progress-group -->
					            </div>

				            </div>
			            </div><!-- /.col -->

			            <div class="col-md-3">
			            	<div class="box">
				    	    	
				    	    	<div class="box-body">
					              <p class="text-center">
					                <strong>Pending Registrants</strong>
					              </p>
					              <div class="progress-group">
					                <span class="progress-text">Area 1</span>
					                <span class="progress-number"><?php echo "<b>".Event::model()->countAreaRegistrants($event_attendees, 1, 2)."</b>/".Event::model()->countAreaMembers($accounts, 1); ?></span>
					                <div class="progress sm">
					                  <div class="progress-bar progress-bar-aqua" style="width: <?php echo Event::model()->getPercentage($event_attendees, $accounts, 1, 2);?>%"></div>
					                </div>
					              </div><!-- /.progress-group -->
					              <div class="progress-group">
					                <span class="progress-text">Area 2</span>
					                <span class="progress-number"><?php echo "<b>".Event::model()->countAreaRegistrants($event_attendees, 2, 2)."</b>/".Event::model()->countAreaMembers($accounts, 2); ?></span>
					                <div class="progress sm">
					                  <div class="progress-bar progress-bar-red" style="width: <?php echo Event::model()->getPercentage($event_attendees, $accounts, 2, 2);?>%"></div>
					                </div>
					              </div><!-- /.progress-group -->
					              <div class="progress-group">
					                <span class="progress-text">Area 3</span>
					                <span class="progress-number"><?php echo "<b>".Event::model()->countAreaRegistrants($event_attendees, 3, 2)."</b>/".Event::model()->countAreaMembers($accounts, 3); ?></span>
					                <div class="progress sm">
					                  <div class="progress-bar progress-bar-green" style="width: <?php echo Event::model()->getPercentage($event_attendees, $accounts, 3, 2);?>%"></div>
					                </div>
					              </div><!-- /.progress-group -->
					              <div class="progress-group">
					                <span class="progress-text">Area 4</span>
					                <span class="progress-number"><?php echo "<b>".Event::model()->countAreaRegistrants($event_attendees, 4, 2)."</b>/".Event::model()->countAreaMembers($accounts, 4); ?></span>
					                <div class="progress sm">
					                  <div class="progress-bar progress-bar-yellow" style="width: <?php echo Event::model()->getPercentage($event_attendees, $accounts, 4, 2);?>%"></div>
					                </div>
					              </div><!-- /.progress-group -->
					              <div class="progress-group">
					                <span class="progress-text">Area 5</span>
					                <span class="progress-number"><?php echo "<b>".Event::model()->countAreaRegistrants($event_attendees, 5, 2)."</b>/".Event::model()->countAreaMembers($accounts, 5); ?></span>
					                <div class="progress sm">
					                  <div class="progress-bar progress-bar-black" style="width: <?php echo Event::model()->getPercentage($event_attendees, $accounts, 5, 2);?>%"></div>
					                </div>
					              </div><!-- /.progress-group -->
					            </div>

				            </div>
			            </div>


			            <div class="col-md-3">
			            	<div class="box">
				    	    	
				    	    	<div class="box-body">
					              <p class="text-center">
					                <strong>Validated Registrants</strong>
					              </p>
					              <div class="progress-group">
					                <span class="progress-text">Area 1</span>
					                <span class="progress-number"><?php echo "<b>".Event::model()->countAreaRegistrants($event_attendees, 1, 1)."</b>/".Event::model()->countAreaMembers($accounts, 1); ?></span>
					                <div class="progress sm">
					                  <div class="progress-bar progress-bar-aqua" style="width: <?php echo Event::model()->getPercentage($event_attendees, $accounts, 1, 1);?>%"></div>
					                </div>
					              </div><!-- /.progress-group -->
					              <div class="progress-group">
					                <span class="progress-text">Area 2</span>
					                <span class="progress-number"><?php echo "<b>".Event::model()->countAreaRegistrants($event_attendees, 2, 1)."</b>/".Event::model()->countAreaMembers($accounts, 2); ?></span>
					                <div class="progress sm">
					                  <div class="progress-bar progress-bar-red" style="width: <?php echo Event::model()->getPercentage($event_attendees, $accounts, 2, 1);?>%"></div>
					                </div>
					              </div><!-- /.progress-group -->
					              <div class="progress-group">
					                <span class="progress-text">Area 3</span>
					                <span class="progress-number"><?php echo "<b>".Event::model()->countAreaRegistrants($event_attendees, 3, 1)."</b>/".Event::model()->countAreaMembers($accounts, 3); ?></span>
					                <div class="progress sm">
					                  <div class="progress-bar progress-bar-green" style="width: <?php echo Event::model()->getPercentage($event_attendees, $accounts, 3, 1);?>%"></div>
					                </div>
					              </div><!-- /.progress-group -->
					              <div class="progress-group">
					                <span class="progress-text">Area 4</span>
					                <span class="progress-number"><?php echo "<b>".Event::model()->countAreaRegistrants($event_attendees, 4, 1)."</b>/".Event::model()->countAreaMembers($accounts, 4); ?></span>
					                <div class="progress sm">
					                  <div class="progress-bar progress-bar-yellow" style="width: <?php echo Event::model()->getPercentage($event_attendees, $accounts, 4, 1);?>%"></div>
					                </div>
					              </div><!-- /.progress-group -->
					              <div class="progress-group">
					                <span class="progress-text">Area 5</span>
					                <span class="progress-number"><?php echo "<b>".Event::model()->countAreaRegistrants($event_attendees, 5, 1)."</b>/".Event::model()->countAreaMembers($accounts, 5); ?></span>
					                <div class="progress sm">
					                  <div class="progress-bar progress-bar-black" style="width: <?php echo Event::model()->getPercentage($event_attendees, $accounts, 5, 1);?>%"></div>
					                </div>
					              </div><!-- /.progress-group -->
					            </div>

				            </div>
			            </div>
			        </div>
				    <div class="box-footer">
	                  <div class="row">
	                    <!-- <div class="col-sm-6">
	                      <div class="description-block border-right">
	                        <h5 class="description-header"><?php //echo "₱ ".number_format(Event::model()->computeExpectedTotalSales($event->id), 2, '.', ',');?></h5>
	                        <span class="description-text">EXPECTED TOTAL SALES</span><br/>
	                        <small>(if all Registrant's were paid & if payments were exact.)</small>
	                      </div>
	                    </div><!-- /.col -->
	                    <div class="col-xs-12">
	                      <div class="description-block">
	                        <h5 class="description-header"><?php echo "₱ ".number_format(Event::model()->computeTotalSales($sales), 2, '.', ',');?></h5>
	                        <span class="description-text">TOTAL SALES</span>
	                      </div><!-- /.description-block -->
	                    </div>
	                  </div><!-- /.row -->
	                </div><!-- /.box-footer -->
		        </div>
	        </div>



	        <div class="row">
	        	<h4 style="margin-left:15px;">Today's Updates</h4>
	        	<div class="col-md-6">
			        <div class="info-box bg-yellow">
		                <span class="info-box-icon"><i class="fa fa-users"></i></span>
		                <div class="info-box-content">
		                  <span class="info-box-text">REGISTRANTS</span>
		                  <span class="info-box-number"><?php echo Event::model()->countTodaysAttendees($event_attendees); ?></span>
		                  <div class="progress">
		                    <div class="progress-bar" style="width: <?php echo Event::model()->getPercentageTA($event_attendees); ?>%"></div>
		                  </div>
		                  <span class="progress-description">
		                    <?php echo Event::model()->getPercentageTA($event_attendees); ?>% Increase
		                  </span>
		                </div><!-- /.info-box-content -->
		            </div><!-- /.info-box -->
		        </div>

		        <div class="col-md-6">
		            <div class="info-box bg-green">
		                <span class="info-box-icon"><i class="fa fa-upload"></i></span>
		                <div class="info-box-content">
		                  <span class="info-box-text">UPLOADED PAYMENTS</span>
		                  <span class="info-box-number"><?php echo Event::model()->countTodaysPayments($payments); ?></span>
		                  <div class="progress">
		                    <div class="progress-bar" style="width: <?php echo Event::model()->getPercentageTP($payments); ?>%"></div>
		                  </div>
		                  <span class="progress-description">
		                    <?php echo Event::model()->getPercentageTP($payments); ?>% Increase
		                  </span>
		                </div><!-- /.info-box-content -->
		            </div><!-- /.info-box -->
		        </div>

	            <!--<div class="col-md-6">
		            <div class="info-box bg-red">
		                <span class="info-box-icon"><i class="ion ion-ios-cloud-download-outline"></i></span>
		                <div class="info-box-content">
		                  <span class="info-box-text">EXPECTED TOTAL SALES</span>
		                  <span class="info-box-number"><?php // echo "₱ ".number_format(Event::model()->computeExpectedTodaysSales($event->id), 2, '.', ',');?></span>
		                  <div class="progress">
		                    <div class="progress-bar" style="width: <?php // echo Event::model()->getPercentageETS($event->id); ?>%"></div>
		                  </div>
		                  <span class="progress-description">
		                    <?php // echo Event::model()->getPercentageETS($event->id); ?>% Increase
		                  </span>
		                </div>
		            </div>
		        </div> -->

	            <div class="col-md-12">
		            <div class="info-box bg-aqua">
		                <span class="info-box-icon"><i class="ion-ios-chatbubble-outline"></i></span>
		                <div class="info-box-content">
		                  <span class="info-box-text">TOTAL SALES</span>
		                  <span class="info-box-number"><?php echo "₱ ".number_format(Event::model()->computeTodaysSales($sales), 2, '.', ',');?></span>
		                  <div class="progress">
		                    <div class="progress-bar" style="width: <?php echo Event::model()->getPercentageTS($sales); ?>%"></div>
		                  </div>
		                  <span class="progress-description">
		                    <?php echo Event::model()->getPercentageTS($sales); ?>% Increase
		                  </span>
		                </div><!-- /.info-box-content -->
		            </div><!-- /.info-box -->
		        </div>

	        </div>



		</section>




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