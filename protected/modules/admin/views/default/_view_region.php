<tr>
	<td><?php echo CHtml::link($data->region, array('/admin/default/listchapters', 'id' => $data->id, 'anum' => $data->area_no))?></td>
	<td><?php echo User::model()->activeAreaRegion($data->area_no, $data->id); ?></td>
	<td><?php echo User::model()->InactiveAreaRegion($data->area_no, $data->id); ?></td>
	<td><?php echo User::model()->getTotalUsers($data->area_no, $data->id); ?></td>
</tr>