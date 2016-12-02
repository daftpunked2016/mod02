<?php
	$eventattendee = EventAttendees::model()->findByPk($data->event_attendees_id);
	$account = Account::model()->findByPk($eventattendee->account_id);
	$user = User::model()->find('account_id = '.$account->id);
	$payment = Payments::model()->findByPk($data->payment_id);
	$eventpricing = EventPricing::model()->find('event_id ='.$eventattendee->event_id);
?>
<tr>
	<td>
		<?php echo $account->username; ?>
	</td>
	<td>
		<?php echo $user->getCompleteName2($account->id); ?>
	</td>
	<td>
		<?php echo $user->getChapter2($account->id); ?>
	</td>
	<td>
		<?php echo $eventattendee->date_registered; ?>
	</td>
	<td>
		<!-- date approved -->
		<?php echo date('F d, Y', strtotime($data->date_created)); ?>
	</td>
	<td>
		<?php echo $data->total_amount; ?>
	</td>
	<?php if($eventpricing->pricing_type == 1): ?>
	<td>
		FREE
	</td>
	<?php else: ?>
	<td>
		<a href='#myModal<?php echo CHtml::encode($data->event_attendees_id); ?>' data-toggle="modal" data-target="#myModal<?php echo CHtml::encode($data->event_attendees_id); ?>"><span class="btn btn-sm btn-warning">View Slip</span></a>
	</td>
	<?php endif; ?>
</tr>

<div class="modal fade" id="myModal<?php echo $data->event_attendees_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Payment Details</h4>
			</div> 
			<div class="modal-body">
				<form> 
					<div class = "well">
						<div class ="row">
							<div class="col-lg-12 col-md-12">
								<center><img style="border:2px solid black;  height:100%; width:100%;" src="<?php echo Yii::app()->request->baseUrl; ?>/payment_uploads/<?php $fileupload= Fileupload::model()->findByPk($payment->payment_avatar); echo $fileupload->filename; ?>" id="userAvatar" /> </center>
							</div>
						</div>
					</div>
					<div class="row">
						<div class = "col-lg-12">
							<B>Payment No:</B> <?php echo $payment->payment_avatar; ?> </br>
							<B>Bank Branch:</B> <?php echo $payment->bank_branch; ?> </br>
							<B>Amount:</B> <?php echo $payment->amount; ?> </br>
							<B>Date & Time:</B>  <?php echo $payment->date; ?> <?php echo $payment->time; ?> <br> <br>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>