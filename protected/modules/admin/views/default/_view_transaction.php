<tr>
	<td><?php echo CHtml::encode($data->id); ?></td>
	<td><?php echo CHtml::encode($data->account->user->getAdminCompleteName()); ?></td>
	<td><?php echo CHtml::encode($data->ip_address); ?></td>
	<td><?php echo CHtml::encode($data->type); ?></td>
	<td><?php echo CHtml::encode($data->detail); ?></td>
	<td><?php echo CHtml::encode(date("F d, Y h:i:a", strtotime($data->date_created))); ?></td>
</tr>