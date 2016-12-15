<tr data-id="<?php echo $data->id; ?>">
	<td class="chapter-name" data-value="<?= $data->chapter; ?>"><strong><mark><?php echo $data->chapter; ?></mark></strong></td>
	<td><strong><?php echo $data->area_no; ?></strong></td>
	<td><em><?php echo ($data->region != null) ? $data->region->region : 'N / A'; ?></em></td>
	<td class="category"><?php echo ($data->category == null) ? '-' : $data->category; ?></td>
	<td class="voting-strength"><?php echo ($data->voting_strength == null) ? '-' : $data->voting_strength; ?></td>
	<td class="max-regular" data-value="<?php echo $data->max_regular; ?>">
		<?php echo Chapter::model()->getMembershipCount(2, $data->id, 1); ?> / <strong class="max-values"><?php echo $data->max_regular; ?></strong>
	</td>
	<td class="max-associate" data-value="<?php echo $data->max_associate; ?>">
		<?php echo Chapter::model()->getMembershipCount(2, $data->id, 2); ?> / <strong class="max-values"><?php echo $data->max_associate; ?></strong>
	</td>
	<td class="text-center actions"><a href="#" class="edit-chapter"><i class="fa fa-pencil"></i></a></td>
</tr>