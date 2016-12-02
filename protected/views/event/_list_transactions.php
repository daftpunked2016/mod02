<tr>
	<?php 
		$event = Event::model()->findByPk($data->event_id);
		$event_type = EventTypes::model()->findByPk($event->event_type);
		$eventpricing = EventPricing::model()->find("event_id =".$event->id);
		$billing = Billing::model()->find("event_attendees_id = ".$data->id);
	?>
	<td>
		<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/event/view?event_id=<?php echo $event->id; ?>"><?php echo $event->name; ?></a>
		<?php if($data->payment_status == 4) 
			echo '<span class="badge" style="background:red; margin-left:5px;">!</span>';
		?>

	</td>
	<td><?php echo $event_type->name; ?></td>

	<td><?php echo "Php. ".CHtml::encode($billing->price); ?></td>
	<td>
		<?php echo date('F d, Y', strtotime($data->date_registered)); ?>
	</td>
	<td>
		<?php if($data->payment_status == 1)
				echo "<B>PAID</B>";
			  elseif($data->payment_status == 2)
			  	echo "Pending";
			  elseif($data->payment_status == 3)
			  	echo "<font color='red'>UNPAID</font>";
			  elseif($data->payment_status == 4)
			  	echo "<font color='red'><B>REJECTED</B></font>"
		?>
	</td>
	<td>
		<?php
			echo CHtml::link('<span class="btn btn-warning btn-sm" style="margin-right:7px;margin-top:5px;"><i class="fa fa-search" style="margin-right:3px;"></i>View Billing</span>', array('/event/viewbspdf', 'event_id' => $event->id), array('target'=>'_blank'));
			
			if($data->payment_status == 1)
				echo "<a href='#paymentModal".CHtml::encode($data->event_id)."' data-toggle='modal' data-target='#paymentModal".CHtml::encode($data->event_id)."'>
				<span class='btn btn-sm btn-warning' style='margin-right:7px;margin-top:5px;'><i class='fa fa-credit-card' style='margin-right:3px;'></i>View Payment</span>
				</a>";
			elseif($data->payment_status == 2)
				echo CHtml::link('<span class="btn btn-success btn-sm" style="margin-right:7px;margin-top:5px;"><i class="fa fa-edit" style="margin-right:3px;"></i>Update Payment</span>',  array('/event/updatePayment', 'event_attendees_id' => $data->id));
			elseif($data->payment_status == 3)
				echo CHtml::link('<span class="btn btn-primary btn-sm" style="margin-right:7px;margin-top:5px;"><i class="fa fa-upload" style="margin-right:3px;"></i>Upload Payment</span>', array('/event/uploadpayment', 'event_id' => $event->id));
			elseif($data->payment_status == 4)
			{
				echo CHtml::link('<span class="btn btn-success btn-sm" style="margin-right:7px; margin-top:5px;"><i class="fa fa-edit" style="margin-right:3px;"></i>Update & Resend Payment</span>',  array('/event/updatePayment', 'event_attendees_id' => $data->id, 'resend' => 1));
				echo CHtml::link('<span class="btn btn-danger btn-sm" style="margin-right:7px; margin-top:5px;"><i class="fa fa-remove" style="margin-right:3px;"></i>Delete Payment</span>', array('/event/deletePayment', 'event_attendees_id' => $data->id));
			}
		?>
	</td>
</tr>