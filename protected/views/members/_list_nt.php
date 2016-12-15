<tr>
	<td><?php echo CHtml::link('AREA - '.$data->area_no, array('members/viewarea', 'ano'=>$data->area_no)); ?></td>
	<td>
		<!-- REGULAR MEMBERS -->
		<?php echo Chapter::model()->getMembershipCount(3, $data->area_no, 1); ?>
	</td>
	<td>
		<!-- ASSOCIATE MEBMBERS -->
		<?php echo Chapter::model()->getMembershipCount(3, $data->area_no, 2); ?>
	</td>
	<td>
		<!-- TOTAL -->
		<?php echo Chapter::model()->getMembershipCount(3, $data->area_no, 3); ?>
	</td>
	<!-- START HQ VALUES -->
	<td>
		<!-- TOTAL REG RECORDED -->
		<?php echo Chapter::model()->getMembershipCount(3, $data->area_no, 4); ?>
	</td>
	<td>
		<!-- TOTAL ASSOC RECORDED -->
		<?php echo Chapter::model()->getMembershipCount(3, $data->area_no, 5); ?>
	</td>
	<td>
		<!-- TOTAL MEMBERSHIP RECORDED -->
		<?php echo Chapter::model()->getMembershipCount(3, $data->area_no, 6); ?>
	</td>
	<!-- END HQ VALUES -->
</tr>