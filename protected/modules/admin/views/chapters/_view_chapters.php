<tr data-id="<?php echo $data->id; ?>">
	<td class="chapter-name" data-value="<?= $data->chapter; ?>"><strong><mark><?php echo $data->chapter; ?></mark></strong></td>
	<td><strong><?php echo $data->area_no; ?></strong></td>
	<td><em><?php echo ($data->region != null) ? $data->region->region : 'N / A'; ?></em></td>
	<td class="category"><?php echo ($data->category == null) ? '-' : $data->category; ?></td>
	<td class="voting-strength"><?php echo ($data->voting_strength == null) ? '-' : $data->voting_strength; ?></td>
	<td class="max-regular"><?php echo $data->max_regular; ?></td>
	<td class="max-associate"><?php echo $data->max_associate; ?></td>
	<td class="text-center actions"><a href="#" class="edit-chapter"><i class="fa fa-pencil"></i></a></td>
</tr>