<tr>
	<td>
		<?php echo CHtml::link($data->region, array('/admin/default/listchapters', 'id' => $data->id, 'anum' => $data->area_no))?>
	</td>
	<td>
		<?php echo User::model()->activeAreaRegion($data->area_no, $data->id).'/'.User::model()->InactiveAreaRegion($data->area_no, $data->id).'/'.User::model()->ResetAreaRegion($data->area_no, $data->id); ?>
	</td>
	<td>
		<?php echo Chapter::model()->getMembershipCount(1, $data->id, 1).'/'.Chapter::model()->getMembershipCount(1, $data->id, 2); ?>
	</td>
	<td>
		<?php echo User::model()->getTotalUsers($data->area_no, $data->id); ?>
	</td>
	<!-- START HQ VALUES -->
	<td>
		<!-- TOTAL REG / TOTAL ASSOC RECORDED -->
		<?php echo Chapter::model()->getMembershipCount(1, $data->id, 4).'/'.Chapter::model()->getMembershipCount(1, $data->id, 5); ?>
	</td>
	<td>
		<!-- TOTAL MEMBERSHIP RECORDED -->
		<?php echo Chapter::model()->getMembershipCount(1, $data->id, 6); ?>
	</td>
	<!-- END HQ VALUES -->
</tr>