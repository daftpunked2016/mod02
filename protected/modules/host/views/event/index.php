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

<section class="content-header">
  <h1>
  	<?php echo "Welcome to ".$event->name; ?>
    <small>preview of event</small>
  </h1>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-3 col-lg-3">
		  <div class="info-box">
			<span class="info-box-icon bg-aqua"><i class="fa fa-group"></i></span>
			<div class="info-box-content">
			  <span class="info-box-text">Total Attendees</span>
			  <span class="info-box-number"><?php echo EventAttendees::model()->count(array('condition' => 'event_id ='.$event->id)); ?></span>
			</div><!-- /.info-box-content -->
		  </div><!-- /.info-box -->
		</div><!-- /.col -->
		
		<div class="col-md-3 col-lg-3">
		  <div class="info-box bg-green">
			<span class="info-box-icon"><i class="fa fa-check"></i></span>
			<div class="info-box-content">
			  <span class="info-box-text">Approved Payments</span>
			  <span class="info-box-number"><?php echo EventAttendees::model()->paidAttendee()->count(array('condition' => 'event_id ='.$event->id)); ?></span>
			  <div class="progress">
				<div class="progress-bar" style="width: 70%"></div>
			  </div>
			  <span class="progress-description">
				Validated Payments.
			  </span>
			</div><!-- /.info-box-content -->
		  </div><!-- /.info-box -->
		</div><!-- /.col -->
		
		<div class="col-md-3 col-lg-3">
		  <div class="info-box bg-red">
			<span class="info-box-icon"><i class="fa fa-close"></i></span>
			<div class="info-box-content">
			  <span class="info-box-text">Rejected Payments</span>
			  <span class="info-box-number"><?php echo EventAttendees::model()->rejectAttendee()->count(array('condition' => 'event_id ='.$event->id)); ?></span>
			  <div class="progress">
				<div class="progress-bar" style="width: 30%"></div>
			  </div>
			  <span class="progress-description">
				Accounts with <b>Rejected</b> Payments.
			  </span>
			</div><!-- /.info-box-content -->
		  </div><!-- /.info-box -->
		</div><!-- /.col -->

		<div class="col-md-3 col-lg-3">
		  <div class="info-box bg-yellow">
			<span class="info-box-icon"><i class="fa fa-question-circle"></i></span>
			<div class="info-box-content">
			  <span class="info-box-text">Pending Payments</span>
			  <span class="info-box-number"><?php echo EventAttendees::model()->pendingAttendee()->count(array('condition' => 'event_id ='.$event->id)); ?></span>
			  <div class="progress">
				<div class="progress-bar" style="width: 50%"></div>
			  </div>
			  <span class="progress-description">
				Accounts with <b>Pending</b> Payments.
			  </span>
			</div><!-- /.info-box-content -->
		  </div><!-- /.info-box -->
		</div><!-- /.col -->
	</div>

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
        </div>

       	<div class="col-md-6">
       		<h4>Event Details <a href="#" style="margin-left:10px;"></a></h4>
          	<div class="well" style="padding:20px;">
      			<table class="table table-striped table-hover">
      				<tbody>
          				<tr>
          					<th>Event Name</th>
          					<td><?php echo $event->name; ?></td>
          				</tr>
          				<tr>
          					<th>Event Type</th>
          					<td>
          						<?php $event_type = EventTypes::model()->find(array('condition' => 'id='.$event->event_type)); 
          							echo $event_type->name; 
          						?>
          					</td>
          				</tr>
          				<tr>
          					<th>Desription</th>
          					<td><?php echo $event->description; ?></td>
          				</tr>
          				<tr>
          					<th>Date & Time</th>
          					<td><?php echo $event->date." - ".$event->time; ?></td>
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


          	<h4>Pricing Details <a href="#" style="margin-left:10px;"></a></h4>
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
	          					<td><?php echo $eventpricing->regular_begin_date."  --  ".$eventpricing->regular_end_date ?></td>
	          				</tr>
	          			<?php endif; ?>

          				<?php if($eventpricing->pricing_type == 2): ?> 
          					<tr>
	          					<th>Price</th>
	          					<td> Php. <a href="#"><?php echo $eventpricing->regular_price; ?></a>  </td>
	          				</tr>
	          				<tr>
	          					<th>Date Range</th>
	          					<td><?php echo $eventpricing->regular_begin_date."  --  ".$eventpricing->regular_end_date ?></td>
	          				</tr>
	          			<?php endif; ?>

          				<?php if($eventpricing->pricing_type == 3): ?> 
          					<tr>
	          					<th>Early Bird Price</th>
	          					<td> Php. <a href="#"><?php echo $eventpricing->early_bird_price; ?></a>  </td>
	          				</tr>
	          				<tr>
	          					<th>Date Range(E.B)</th>
	          					<td><?php echo $eventpricing->eb_begin_date."  --  ".$eventpricing->eb_end_date ?></td>
	          				</tr>
	          				<tr>
	          					<th>Regular Price</th>
	          					<td> Php. <a href="#"><?php echo $eventpricing->regular_price; ?></a>  </td>
	          				</tr>
	          				<tr>
	          					<th>Date Range(R)</th>
	          					<td><?php echo $eventpricing->regular_begin_date."  --  ".$eventpricing->regular_end_date ?></td>
	          				</tr>
	          				<tr>
	          					<th>Onsite Price</th>
	          					<td> Php. <a href="#"><?php echo $eventpricing->onsite_price; ?></a>  </td>
	          				</tr>
	          				<tr>
	          					<th>Date Range(O)</th>
	          					<td><?php echo $eventpricing->onsite_begin_date."  --  ".$eventpricing->onsite_end_date ?></td>
	          				</tr>
	          			<?php endif; ?>

	          			<tr>
	          				<th>Payment Schemes</th>
	          				<td>
	          					<?php 
	          						if($event_ps == null){
	          							echo "FREE";
	          						}else{
	          							foreach($event_ps as $eventps){
		          							$paymentscheme = PaymentScheme::model()->findByPk($eventps->payment_scheme_id);
		          							echo $paymentscheme->bank_details.": ".$paymentscheme->bank_account_no;
		          							echo "<br>";
		          						}
	          						}
	          						
	          					?>
	          				</td>
	          			</tr>
          			</tbody>
          		</table>
          	</div>

          	<div class="row">
          		<center>
          			<!-- <a href="#" class="btn btn-success">Edit Event Details</a> -->
          			<?php echo CHtml::link('<span class="btn btn-success" style="margin-right:5px;">Edit Event Details</span>', array('event/update', 'id' => $event->id)); ?>
          			<!-- <a href="#" class="btn btn-danger">Edit Payment Schemes</a> -->
          			<?php echo CHtml::link('<span class="btn btn-danger" style="margin-right:5px;">Edit Payment Schemes</span>', array('event/configps', 'event_id' => $event->id)); ?>
          		</center>
          		<br>
          	<div>
        </div>		
    </div>
</section>

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
							<form role="form" name="eventavatar" id="eventavatar" method="POST" enctype = "multipart/form-data" action="<?php echo Yii::app()->baseUrl; ?>/index.php/host/event/changePoster?event_id=<?php echo $event->id; ?>">
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