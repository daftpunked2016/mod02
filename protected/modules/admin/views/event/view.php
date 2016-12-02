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
	 			<div class="container">
		          <div class="row" style="margin-top:0px;">
		              <h2>
		              	<?php echo $event->name; ?>
		              </h2>
		          </div>
		        </div>
	        </section>

	        <!-- Main content -->
          	<section class="content">
	          	<div class="row">
	          		<div class="col-md-6">
			          	<div class="well" style="padding:20px;">
			          		<div class="row">
			          			<?php //echo CHtml::encode($data->id); 
									$fileupload = Fileupload::model()->findByPk($event->event_avatar);
									$event_avatar = $fileupload->filename;
								?>
								<center>
									<img style="width:500px; height:500px; margin:5px 10px 5px 10px; border: 5px; border-style: solid; border-color: #ffffff;" src="<?php echo Yii::app()->request->baseUrl; ?>/event_avatars/<?php echo $event_avatar; ?>" class="img-responsive" alt="Responsive image">
								</center>
			          		</div>
			          		<div class="row">
			          			<center>
			          				<button data-toggle="modal" data-target="#avatarModal" class="btn btn-success" style="margin-top:10px"><span class="glyphicon glyphicon-picture" style="margin-right:10px"></span>Change Poster</button>
			          			</center>
			          		</div>
			          	</div>

			          	<div class="row">
			          		<div class="col-xs-6">
			          			<h4>Statistics Summary</h4>
			          		</div>
			          		<div class="col-xs-6">
			          			<h4 class="pull-right"><u><a href="<?php echo Yii::app()->baseUrl; ?>/index.php/admin/event/viewstats?event_id=<?php echo $event->id; ?>">View Statistics</a></u></h4>
			          		</div>
			          	</div>
			          	<div class="well">
				             <div class="info-box bg-yellow">
				                <span class="info-box-icon"><i class="fa fa-users"></i></span>
				                <div class="info-box-content">
				                  <span class="info-box-text">Attendees</span>
				                  <span class="info-box-number"><?php echo Event::model()->countAttendees($event->event_attendees); ?></span>
				                  <span class="progress-description">
				                    Registered attendees
				                  </span>
				                </div><!-- /.info-box-content -->
				            </div><!-- /.info-box -->

				            <a href="<?php echo Yii::app()->baseUrl; ?>/index.php/admin/event/viewunpaid?event_id=<?php echo $event->id; ?>">
					         	<div class="info-box bg-red">
					                <span class="info-box-icon"><i class="fa fa-ban"></i></span>
					                <div class="info-box-content">
					                  <span class="info-box-text">Unpaid Attendees</span>
					                  <span class="info-box-number"><?php echo Event::model()->countAttendees($event->event_attendees, 3); ?></span>
					                  <span class="progress-description">
					                    Attendees who haven't uploaded any payment yet
					                  </span>
					                </div><!-- /.info-box-content -->
					            </div><!-- /.info-box -->
				        	</a>

				            <a href="<?php echo Yii::app()->baseUrl; ?>/index.php/admin/event/viewpending?event_id=<?php echo $event->id; ?>">
					            <div class="info-box bg-green">
					                <span class="info-box-icon"><i class="fa fa-spinner"></i></span>
					                <div class="info-box-content">
					                  <span class="info-box-text">Pending Attendees</span>
					                  <span class="info-box-number"><?php echo Event::model()->countAttendees($event->event_attendees, 2); ?></span>
					                  <span class="progress-description">
					                    Attendees who have uploaded payment but still pending
					                  </span>
					                </div><!-- /.info-box-content -->
					            </div><!-- /.info-box -->
				        	</a>

				            <a href="<?php echo Yii::app()->baseUrl; ?>/index.php/admin/event/viewpaid?event_id=<?php echo $event->id; ?>">
					            <div class="info-box bg-aqua">
					                <span class="info-box-icon"><i class="fa fa-check-circle-o"></i></span>
					                <div class="info-box-content">
					                  <span class="info-box-text">Validated Attendees</span>
					                  <span class="info-box-number"><?php echo Event::model()->countAttendees($event->event_attendees, 1); ?></span>
					                  <span class="progress-description">
					                    Attendees with validated/accepted payments
					                  </span>
					                </div><!-- /.info-box-content -->
					            </div><!-- /.info-box -->
					        </a>

			          	</div>
			        </div>

			       	<div class="col-md-6">
			       		<h4>Event Details</h4>
			          	<div class="well" style="padding:20px;">
		          			<table class="table table-striped table-hover">
		          				<tbody>
		          					<tr>
			          					<th>Event Code</th>
			          					<td><?php echo $event->id; ?></td>
			          				</tr>
			          				<tr>
			          					<th>Event Name</th>
			          					<td><?php echo $event->name; ?></td>
			          				</tr>
			          				<tr>
			          					<th>Event Type</th>
			          					<td><?php $event_type = EventTypes::model()->findByPk($event->event_type); 
							           echo $event_type->name; ?></td>
			          				</tr>
			          				<tr>
			          					<th>Desription</th>
			          					<td><?php echo $event->description; ?></td>
			          				</tr>
			          				<tr>
			          					<th>Date & Time</th>
			          					<td><?php echo date('F d, Y', strtotime($event->date))." - ".$event->time; ?></td>
			          				</tr>
			          				<tr>
			          					<th>End Date</th>
			          					<td><?php echo date('F d, Y', strtotime($event->end_date)); ?></td>
			          				</tr>
			          				<tr>
			          					<th>Venue</th>
			          					<td><?php echo $event->venue; ?></td>
			          				</tr>
			          				<tr>
			          					<th>Host Chapter</th>
			          					<td><?php $chapter = Chapter::model()->findByPk($event->host_chapter_id); echo $chapter->chapter; ?></td>
			          				</tr>
			          				<tr>
			          					<th>Event Host</th>
			          					<td>
			          						<?php $user = User::model()->find("account_id =".$event->host_account_id); 
			          						echo $user->firstname." ".$user->middlename." ".$user->lastname; ?>
			          					</td>
			          				</tr>
			          			</tbody>
			          		</table>
			          	</div>


			          	<h4>Pricing Details</h4>
			          	<div class="well" style="padding:20px;">
		          			<table class="table table-striped table-hover">
		          				<tbody>
			          				<tr>
			          					<th>Pricing Type</th>
			          					<td><?php
												if($eventpricing->pricing_type == 1)
													echo "FREE";
												else if($eventpricing->pricing_type == 2)
													echo "Fixed Rate";
												else if($eventpricing->pricing_type == 3)
													echo "Packages";
											?></td>
			          				</tr>

			          				<?php if($eventpricing->pricing_type == 1): ?> 
			          					<tr>
				          					<th>Price</th>
				          					<td> Php. <a href="#">0.00</a>  </td>
				          				</tr>
				          				<tr>
				          					<th>Date Range</th>
				          					<td><?php echo date('F d, Y', strtotime($eventpricing->regular_begin_date))."  --  ".date('F d, Y', strtotime($eventpricing->regular_end_date)); ?></td>
				          				</tr>
				          			<?php endif; ?>

			          				<?php if($eventpricing->pricing_type == 2): ?> 
			          					<tr>
				          					<th>Price</th>
				          					<td> Php. <a href="#"><?php echo $eventpricing->regular_price; ?></a>  </td>
				          				</tr>
				          				<tr>
				          					<th>Date Range</th>
				          					<td><?php echo date('F d, Y', strtotime($eventpricing->regular_begin_date))."  --  ".date('F d, Y', strtotime($eventpricing->regular_end_date)); ?></td>
				          				</tr>
				          			<?php endif; ?>

			          				<?php if($eventpricing->pricing_type == 3): ?> 
			          					<tr>
				          					<th>Early Bird Price</th>
				          					<td> Php. <a href="#"><?php echo $eventpricing->early_bird_price; ?></a>  </td>
				          				</tr>
				          				<tr>
				          					<th>Date Range(E.B)</th>
				          					<td><?php echo date('F d, Y', strtotime($eventpricing->eb_begin_date))."  --  ".date('F d, Y', strtotime($eventpricing->eb_end_date)); ?></td>
				          				</tr>
				          				<tr>
				          					<th>Regular Price</th>
				          					<td> Php. <a href="#"><?php echo $eventpricing->regular_price; ?></a>  </td>
				          				</tr>
				          				<tr>
				          					<th>Date Range(R)</th>
				          					<td><?php echo date('F d, Y', strtotime($eventpricing->regular_begin_date))."  --  ".date('F d, Y', strtotime($eventpricing->regular_end_date)); ?></td>
				          				</tr>
				          				<tr>
				          					<th>Onsite Price</th>
				          					<td> Php. <a href="#"><?php echo $eventpricing->onsite_price; ?></a>  </td>
				          				</tr>
				          				<tr>
				          					<th>Date Range(O)</th>
				          					<td><?php echo date('F d, Y', strtotime($eventpricing->onsite_begin_date))."  --  ".date('F d, Y', strtotime($eventpricing->onsite_end_date)); ?></td>
				          				</tr>
				          			<?php endif; ?>

				          			<tr>
				          				<th>Payment Schemes</th>
				          				<td>
				          					<?php foreach($eventps as $e)
				          						{
				          							$ps = PaymentScheme::model()->findByPk($e->payment_scheme_id);
				          							echo $ps->bank_details." -- ".$ps->bank_account_no;
				          							echo "<br />";
				          						}
				          					?>
				          				</td>
				          			</tr>
			          			</tbody>
			          		</table>
			          	</div>

			          	<div class="row">
			          		<center>
			          			<a href="<?php echo Yii::app()->baseUrl; ?>/index.php/admin/event/update?id=<?php echo $event->id; ?>" class="btn btn-success">Edit Event Details</a>
			          			<a href="<?php echo Yii::app()->baseUrl; ?>/index.php/admin/event/configps?event_id=<?php echo $event->id; ?>" class="btn btn-danger">Edit Payment Schemes</a>
			          		</center>
			          	<div>
			        </div>		
		        </div>
          	</section><!-- /.content -->


      	  	<div class="modal fade" id="avatarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			    <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				      <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-picture" style="margin-right:10px;"></span>Change Event Poster</h4>
				      </div>
				      <div class="modal-body">
				        <div class = "well">
				          <div class ="row">
				            <div class='col-lg-4 col-md-4'>
				              <center><img style="border:2px solid black;  height:150px; width:150px;" src="<?php echo Yii::app()->request->baseUrl; ?>/event_avatars/<?php echo $event_avatar; ?>" id="avatarRead" /> </center>
				            </div>
				          <div class="visible-sm" >
				            <br /> <br />
				          </div>
				          <div class='col-lg-8 col-md-8'>
				            <form role="form" name="eventavatar" id="eventavatar" method="POST" enctype = "multipart/form-data" action="<?php echo Yii::app()->baseUrl; ?>/index.php/admin/event/changePoster?event_id=<?php echo $event->id; ?>">
				               <div class="form-group">
				                <label for="avatar" class="col-lg-2">Select Picture: </label>
				                <div class="col-lg-10">
				                  <input type="file" id="avatar" name="avatar">
				                </div>
				              </div>
				            
				          </div>
				        </div>
				      </div>  
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				        <button class="btn btn-success" type="submit" value="Change Avatar" id="submit">Save Changes</button> 
				        </form>
				      </div>
				    </div>
			    </div>
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