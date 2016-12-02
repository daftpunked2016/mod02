<tr>
	<td><?php echo CHtml::link($data->chapter, array('/admin/default/listmembers', 'id' => $data->id))?></td>
	<td><?php echo User::model()->getActiveChapterUsers($data->id); ?></td>
	<td><?php echo User::model()->getInactiveChapterUsers($data->id); ?></td>
	<td><?php echo User::model()->getChapterTotalUsers($data->id); ?></td>
</tr>