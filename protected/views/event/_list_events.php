<?php
        $fileupload = Fileupload::model()->findByPk($data->event_avatar);
        $event_avatar = $fileupload->filename;
        $event_attendee = EventAttendees::model()->find('event_id = '.$data->id.' AND account_id = '.Yii::app()->user->id);
?>

<div class="col-md-6">
	<div class="well">
		<div class="row">
			<div class="poster img-responsive hidden-sm hidden-xs"> <!-- for desktops/laptop -->
				<div class="poster-img">  
					<div class="event-details">
						<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/event/view?event_id=<?php echo $data->id; ?>" class="btn btn-success" style="margin-top:0px;">View Details</a>

						<?php if($event_attendee == null): ?>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/event/configeventregister?event_id=<?php echo $data->id; ?>" class="btn btn-primary" style="margin-top:0px; position:relative;">Register Now</a>
						<?php else: ?>
							<a href="#" class="btn btn-danger" style="margin-top:0px; position:relative;" disabled>Registered Already</a>
						<?php endif; ?>

					</div>
			 		<img src="<?php echo Yii::app()->request->baseUrl; ?>/event_avatars/<?php echo $event_avatar; ?>" alt="Event Poster" />
			 	</div>
			</div>

			<div class="poster-sm img-responsive visible-sm visible-xs"> <!-- for phones/tablet -->
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/event_avatars/<?php echo $event_avatar; ?>" class="img-responsive" alt="Event Poster" style="height:300px; width:550px;" />
			</div>

		</div>
		<div class="row">
			<h4 style="   overflow: hidden; text-overflow: ellipsis;display: -webkit-box;-webkit-line-clamp: 1; -webkit-box-orient: vertical;"><?php echo $data->name; ?></h4>
			<?php echo date('F d, Y', strtotime($data->date)); ?>

			<div class="visible-sm visible-xs" style="text-align:center">
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/event/view?event_id=<?php echo $data->id; ?>" class="btn btn-success" style="margin-top:10px;">View Details</a>
				<?php if($event_attendee == null): ?>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/event/configeventregister?event_id=<?php echo $data->id; ?>" class="btn btn-primary" style="margin-top:10px; position:relative;">Register Now</a>
				<?php else: ?>
					<a href="#" class="btn btn-danger" style="margin-top:10px; position:relative;" disabled>Registered Already</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>