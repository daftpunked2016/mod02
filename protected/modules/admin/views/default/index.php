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
            ADMINISTRATOR
            <small>Authorized Personnel Only!</small>
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
				  <div class="info-box">
					<span class="info-box-icon bg-aqua"><i class="fa fa-group"></i></span>
					<div class="info-box-content">
					  <span class="info-box-text">Total Accounts Registered</span>
					  <span class="info-box-number"><?php echo Account::model()->userAccount()->count(); ?></span>
					</div><!-- /.info-box-content -->
				  </div><!-- /.info-box -->
				</div><!-- /.col -->
				
				<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
				  <div class="info-box bg-green">
					<span class="info-box-icon"><i class="fa fa-check"></i></span>
					<div class="info-box-content">
					  <span class="info-box-text">Active Accounts</span>
					  <span class="info-box-number"><?php echo Account::model()->isActive()->userAccount()->count(); ?></span>
					  <div class="progress">
						<div class="progress-bar" style="width: 70%"></div>
					  </div>
					  <span class="progress-description">
						Verified and ready-to-use accounts.
					  </span>
					</div><!-- /.info-box-content -->
				  </div><!-- /.info-box -->
				</div><!-- /.col -->
				
				<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
				  <div class="info-box bg-red">
					<span class="info-box-icon"><i class="fa fa-close"></i></span>
					<div class="info-box-content">
					  <span class="info-box-text">Inactive Accounts</span>
					  <span class="info-box-number"><?php echo Account::model()->isInactive()->userAccount()->count(); ?></span>
					  <div class="progress">
						<div class="progress-bar" style="width: 30%"></div>
					  </div>
					  <span class="progress-description">
						Accounts with <b>unverified</b> email.
					  </span>
					</div><!-- /.info-box-content -->
				  </div><!-- /.info-box -->
				</div><!-- /.col -->

				<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
				  <div class="info-box bg-yellow">
					<span class="info-box-icon"><i class="fa fa-unlock"></i></span>
					<div class="info-box-content">
					  <span class="info-box-text">Pending Senator Accounts</span>
					  <span class="info-box-number"><?php echo Account::model()->userAccount()->isInactiveSen()->count(); ?></span>
					  <div class="progress">
						<div class="progress-bar" style="width: 50%"></div>
					  </div>
					  <span class="progress-description">
						<b>Pending</b> senator accounts.
					  </span>
					</div><!-- /.info-box-content -->
				  </div><!-- /.info-box -->
				</div><!-- /.col -->
			</div>

			<div class="row">
				<div class="col-md-12 col-lg-12">
					<div class="box">
		            	<div class="box-header">
		          			<h3 class="box-title">AREA 1</h3>
		          			<h3 class="box-title pull-right">GRAND TOTAL HQ PAID: <?php echo Chapter::model()->getMembershipCount(3, 1, 6); ?></h3>
		                </div><!-- /.box-header -->
	                	<div class="box-body no-padding">
			                <!-- <?php //$this->widget('Area1'); ?> -->
			                <?php  $this->widget('zii.widgets.CListView', array(
								'dataProvider'=>$area1DP,
								'itemView'=>'_view_region',
								'template' => "{sorter}<table id=\"example1\"class=\"table table-bordered table-hover\" >
										<thead>
											<th>Region</th>
											<th>Active/Inactive/Reset</th>
											<th>Regular/Associate (Active)</th>
											<th>Total Account (Database)</th>
											<th>Regular/Associate (HQ-PAID)</th>
											<th>Total HQ PAID</th>
										</thead>
										<tbody>
											{items}
										</tbody>
									</table>
									{pager}",
								'emptyText' => "<tr><td colspan=\"6\">No available entries</td></tr>",
								));
							?>
	               		</div><!-- /.box-body -->
              		</div><!-- /.box -->
            	</div>

	            <div class="col-md-12 col-lg-12">
	            	<div class="box">
		            	<div class="box-header">
		          			<h3 class="box-title">AREA 2</h3>
		          			<h3 class="box-title pull-right">GRAND TOTAL HQ PAID: <?php echo Chapter::model()->getMembershipCount(3, 2, 6); ?></h3>
		                </div><!-- /.box-header -->
	                	<div class="box-body no-padding">
			                <!-- <?php //$this->widget('Area2'); ?> -->
			                <!-- <?php //$this->widget('Area1'); ?> -->
			                <?php  $this->widget('zii.widgets.CListView', array(
								'dataProvider'=>$area2DP,
								'itemView'=>'_view_region',
								'template' => "{sorter}<table id=\"example1\"class=\"table table-bordered table-hover\" >
										<thead>
											<th>Region</th>
											<th>Active/Inactive/Reset</th>
											<th>Regular/Associate (Active)</th>
											<th>Total Account (Database)</th>
											<th>Regular/Associate (HQ-PAID)</th>
											<th>Total HQ PAID</th>
										</thead>
										<tbody>
											{items}
										</tbody>
									</table>
									{pager}",
								'emptyText' => "<tr><td colspan=\"6\">No available entries</td></tr>",
								));
							?>
	                	</div><!-- /.box-body -->
	              	</div><!-- /.box -->
				 </div>

				 <div class="col-md-12 col-lg-12">
	            	<div class="box">
		            	<div class="box-header">
		          			<h3 class="box-title">AREA 3</h3>
		          			<h3 class="box-title pull-right">GRAND TOTAL HQ PAID: <?php echo Chapter::model()->getMembershipCount(3, 3, 6); ?></h3>
		                </div><!-- /.box-header -->
	                	<div class="box-body no-padding">
		                <?php  $this->widget('zii.widgets.CListView', array(
								'dataProvider'=>$area3DP,
								'itemView'=>'_view_region',
								'template' => "{sorter}<table id=\"example1\"class=\"table table-bordered table-hover\" >
										<thead>
											<th>Region</th>
											<th>Active/Inactive/Reset</th>
											<th>Regular/Associate (Active)</th>
											<th>Total Account (Database)</th>
											<th>Regular/Associate (HQ-PAID)</th>
											<th>Total HQ PAID</th>
										</thead>
										<tbody>
											{items}
										</tbody>
									</table>
									{pager}",
								'emptyText' => "<tr><td colspan=\"6\">No available entries</td></tr>",
								));
							?>
	                	</div><!-- /.box-body -->
	              	</div><!-- /.box -->
				 </div>

				 <div class="col-md-12 col-lg-12">
	            	<div class="box">
		            	<div class="box-header">
		          			<h3 class="box-title">AREA 4</h3>
		          			<h3 class="box-title pull-right">GRAND TOTAL HQ PAID: <?php echo Chapter::model()->getMembershipCount(3, 4, 6); ?></h3>
		                </div><!-- /.box-header -->
	                	<div class="box-body no-padding">
		                <?php  $this->widget('zii.widgets.CListView', array(
								'dataProvider'=>$area4DP,
								'itemView'=>'_view_region',
								'template' => "{sorter}<table id=\"example1\"class=\"table table-bordered table-hover\" >
										<thead>
											<th>Region</th>
											<th>Active/Inactive/Reset</th>
											<th>Regular/Associate (Active)</th>
											<th>Total Account (Database)</th>
											<th>Regular/Associate (HQ-PAID)</th>
											<th>Total HQ PAID</th>
										</thead>
										<tbody>
											{items}
										</tbody>
									</table>
									{pager}",
								'emptyText' => "<tr><td colspan=\"6\">No available entries</td></tr>",
								));
							?>
	                	</div><!-- /.box-body -->
	              	</div><!-- /.box -->
				 </div>

				 <div class="col-md-12 col-lg-12">
	            	<div class="box">
		            	<div class="box-header">
		          			<h3 class="box-title">AREA 5</h3>
		          			<h3 class="box-title pull-right">GRAND TOTAL HQ PAID: <?php echo Chapter::model()->getMembershipCount(3, 5, 6); ?></h3>
		                </div><!-- /.box-header -->
	                	<div class="box-body no-padding">
		                <?php  $this->widget('zii.widgets.CListView', array(
								'dataProvider'=>$area5DP,
								'itemView'=>'_view_region',
								'template' => "{sorter}<table id=\"example1\"class=\"table table-bordered table-hover\" >
										<thead>
											<th>Region</th>
											<th>Active/Inactive/Reset</th>
											<th>Regular/Associate (Active)</th>
											<th>Total Account (Database)</th>
											<th>Regular/Associate (HQ-PAID)</th>
											<th>Total HQ PAID</th>
										</thead>
										<tbody>
											{items}
										</tbody>
									</table>
									{pager}",
								'emptyText' => "<tr><td colspan=\"6\">No available entries</td></tr>",
								));
							?>
	                	</div><!-- /.box-body -->
	              	</div><!-- /.box -->
				 </div>
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
    <!-- AdminLTE App -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/dist/js/app.min.js" type="text/javascript"></script>

    <!-- Optionally, you can add Slimscroll and FastClick plugins.
          Both of these plugins are recommended to enhance the
          user experience. Slimscroll is required when using the
          fixed layout. -->
  </body>
</html>