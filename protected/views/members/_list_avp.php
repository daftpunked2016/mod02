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
	<!-- START HQ VALUES -->
	<td>
		<!-- TOTAL REG RECORDED -->
		<?php echo Chapter::model()->getMembershipCount(1, $data->id, 4); ?>
	</td>
	<td>
		<!-- TOTAL ASSOC RECORDED -->
		<?php echo Chapter::model()->getMembershipCount(1, $data->id, 5); ?>
	</td>
	<td>
		<!-- TOTAL MEMBERSHIP RECORDED -->
		<?php echo Chapter::model()->getMembershipCount(1, $data->id, 6); ?>
	</td>
	<!-- END HQ VALUES -->
</tr>