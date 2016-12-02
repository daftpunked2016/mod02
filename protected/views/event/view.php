
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
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/event_avatars/<?php echo $event_avatar; ?>" target="_blank">
						<center>
							<div class="poster-view">
								<div class="poster-max img-responsive">
									<h4><span class="glyphicon glyphicon-resize-full" style="margin-right:5px;"></span>View Full Size</h4>
									<img style="align:middle;width:500px; height:500px; margin:5px auto 5px auto; border: 5px; border-style: solid; border-color: #ffffff;" src="<?php echo Yii::app()->request->baseUrl; ?>/event_avatars/<?php echo $event_avatar; ?>" class="img-responsive" alt="Responsive image">
								</div>
							</div>
						</center>
					</a>
          		</div>
          	</div>
        </div>

       	<div class="col-md-6">
       		<h4>Details</h4>
          	<div class="well" style="padding:20px;">
      			<table class="table table-striped table-hover">
      				<tbody>
          				<tr>
          					<th>Event Type</th>
          					<td><?php $event_type = EventTypes::model()->findByPk($event->event_type); 
							           echo $event_type->name; ?></td>
          				</tr>
          				<tr>
          					<th>Description</th>
          					<td><?php echo $event->description; ?></td>
          				</tr>
          				<tr>
          					<th>Date & Time</th>
          					<td><?php echo date('F d, Y', strtotime($event->date))." - ".$event->time; ?></td>
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
	          			<?php endif; ?>

          				<?php if($eventpricing->pricing_type == 2): ?> 
          					<tr>
	          					<th>Price</th>
	          					<td> Php. <a href="#"><?php echo $eventpricing->regular_price; ?></a>  </td>
	          				</tr>
	          				<tr>
	          					<th>Date Range</th>
	          					<td><?php echo date('F d, Y', strtotime($eventpricing->regular_begin_date))."  --  ". date('F d, Y', strtotime($eventpricing->regular_end_date)); ?></td>
	          				</tr>
	          			<?php endif; ?>

          				<?php if($eventpricing->pricing_type == 3): ?> 
          					<tr <?php if($package_type == 1) echo "style ='font-weight:bold; font-size: medium;'"; ?>>
	          					<th>Early Bird Price</th>
	          					<td> Php. <a href="#"><?php echo $eventpricing->early_bird_price; ?></a>  </td>
	          				</tr>
	          				<tr <?php if($package_type == 1) echo "style ='font-weight:bold; font-size: medium;'"; ?>>
	          					<th>Date Range(E.B)</th>
	          					<td><?php echo date('F d, Y', strtotime($eventpricing->eb_begin_date))."  --  ". date('F d, Y', strtotime($eventpricing->eb_end_date)); ?></td>
	          				</tr>
	          				<tr <?php if($package_type == 2) echo "style ='font-weight:bold; font-size: medium;'"; ?>>
	          					<th>Regular Price</th>
	          					<td> Php. <a href="#"><?php echo $eventpricing->regular_price; ?></a>  </td>
	          				</tr>
	          				<tr <?php if($package_type == 2) echo "style ='font-weight:bold; font-size: medium;'"; ?>>
	          					<th>Date Range(R)</th>
	          					<td><?php echo date('F d, Y', strtotime($eventpricing->regular_begin_date))."  --  ".date('F d, Y', strtotime($eventpricing->regular_end_date)); ?></td>
	          				</tr>
	          				<tr <?php if($package_type == 3) echo "style ='font-weight:bold; font-size: medium;'"; ?>>
	          					<th>Onsite Price</th>
	          					<td> Php. <a href="#"><?php echo $eventpricing->onsite_price; ?></a>  </td>
	          				</tr>
	          				<tr <?php if($package_type == 3) echo "style ='font-weight:bold; font-size: medium;'"; ?>>
	          					<th>Date Range(O)</th>
	          					<td><?php echo date('F d, Y', strtotime($eventpricing->onsite_begin_date))."  --  ".date('F d, Y', strtotime($eventpricing->onsite_end_date)); ?></td>
	          				</tr>
	          			<?php endif; ?>

          			</tbody>
          		</table>
          	</div>

          	<div class="row" style="margin-bottom:20px;">
          		<center>
          			<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/event" class="btn btn-warning"><span class="glyphicon glyphicon-chevron-left" style="margin-right:10px;"></span>Back</a>
          			
          			<?php if($event_attendee == null): ?>
          				<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/event/configeventregister?event_id=<?php echo $event->id; ?>" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-check" style="margin-right:10px; margin-top:5px;"></span> Register to Event</a>
          			<?php else: ?>
          				<a href="" type="button" class="btn btn-danger" disabled> Registered Already </a>
          			<?php endif; ?>
          		</center>
          	</div>

        </div>		
    </div>
</section><!-- /.content -->