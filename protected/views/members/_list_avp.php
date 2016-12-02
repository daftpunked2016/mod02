<tr>
	<td><?php echo CHtml::link($data->region, array('members/viewregion', 'rid'=>$data->id)); ?></td>
	<td>
		<!-- REGULAR MEMBERS -->
		<?php echo Chapter::model()->getMembershipCount(1, $data->id, 1); ?>
	</td>
	<td>
		<!-- ASSOCIATE MEBMBERS -->
		<?php echo Chapter::model()->getMembershipCount(1, $data->id, 2); ?>
	</td>
	<td>
		<!-- TOTAL -->
		<?php echo Chapter::model()->getMembershipCount(1, $data->id, 3); ?>
	</td>
</tr>