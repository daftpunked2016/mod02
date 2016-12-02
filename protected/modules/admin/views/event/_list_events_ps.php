<tr>
	<?php $paymentscheme = PaymentScheme::model()->findByPk($data->payment_scheme_id); ?>
	<td><?php echo $paymentscheme->bank_details; ?></td>
	<td><?php echo $paymentscheme->bank_account_no; ?></td>
	<td>
		<button data-toggle="modal" data-target="#updatePS<?php echo $data->id; ?>"  class="btn btn-success btn-sm" style="margin-right:5px;">Change</button>
		<?php	
			echo CHtml::link('<span class="btn btn-danger btn-sm">Delete</span>', array('event/deleteps', 'id' => $data->id), array('confirm' => "Are you sure you want to delete this Payment Scheme record?", 'title' => 'Delete Payment Scheme'));
		?>
	</td>
</tr>