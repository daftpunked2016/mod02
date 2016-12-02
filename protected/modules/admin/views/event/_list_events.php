<tr>
	<td>
		<?php //echo CHtml::encode($data->id); 
			$fileupload = Fileupload::model()->findByPk($data->event_avatar);
			$event_avatar = $fileupload->filename;
		?>
		<img style="width:65px; height:65px;" src="<?php echo Yii::app()->request->baseUrl; ?>/event_avatars/<?php echo $event_avatar; ?>">
	</td>
	<td><?php echo CHtml::encode($data->name); ?></td>
	<td>
		<?php $event_type = EventTypes::model()->findByPk($data->event_type); 
				echo $event_type->name; ?>
	</td>
	<td><?php echo date('F d, Y', strtotime($data->date)); ?></td>
	<td><?php echo CHtml::encode($data->venue); ?></td>
	<td>
		<?php
			$event_pricing = EventPricing::model()->find('event_id = '.$data->id);
			
			if($event_pricing->pricing_type == 1)
				echo "FREE";
			else if($event_pricing->pricing_type == 2)
				echo "Fixed Rate";
			else if($event_pricing->pricing_type == 3)
				echo "Packages";
		?>
	</td>
	<td>
		<?php
			echo CHtml::link('<span class="btn btn-primary btn-sm" style="margin-right:5px;">View</span>', array('event/view', 'id' => $data->id)); 
			echo CHtml::link('<span class="btn btn-success btn-sm" style="margin-right:5px;">Edit</span>', array('event/update', 'id' => $data->id));
			echo CHtml::link('<span class="btn btn-danger btn-sm">Deactivate</span>', array('event/deactivateevent', 'id' => $data->id), array('confirm' => "Are you sure you want to deactivate this Event?", 'title' => 'Deactivate Event'));
		?>
	</td>
</tr>