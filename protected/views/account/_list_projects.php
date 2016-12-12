<tr>
	<td><strong> <?php echo $data->project_title; ?></strong></td>
	<td><strong> <?php echo date('M d, Y', strtotime($data->date_completed)); ?></strong></td>
	<td><strong> <?php echo $data->position->position; ?></strong></td>
</tr>