<tr>
	<td></td>
	<td><?php echo CHtml::encode($data->business_name); ?></td>
	<td>
		<?php 
			if ($data->status_id == 1) {
				echo "<span class='label label-success'> Approved </span>";
			}elseif ($data->status == 2 ) {
				echo "<span class='label label-info'> Processed </span>";
			}elseif ($data->status_id == 3) {
				echo "<span class='label label-warning'> Pending </span>";
			}elseif ($data->status_id == 4) {
				echo "<span class='label label-danger'> Rejected </span>";
			}elseif ($data->status_id == 5) {
				echo "<span class='label label-info'> Hidden </span>";
			}
		?>
	</td>
	<td>

	</td>
</tr>