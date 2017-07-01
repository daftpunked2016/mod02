<tr class="
	<?php 
	switch($data->status) {
		case 2:
			echo "warning";
			break;
		case 3:
			echo "info";
			break;
	} ?>">
	<td><?= CHtml::encode($data->title); ?></td>
	<td><strong><?= CHtml::encode($data->getFullName()); ?></strong></td>
	<td><em><?= CHtml::encode($data->email); ?></em></td>
	<td><?= CHtml::encode($data->category->catname); ?> <small class="text-muted">(<?= CHtml::encode($data->subcategory->catdesc); ?>)</small></td>
	<td><?= CHtml::encode($data->nominator->getFullName()); ?></td>
	<td><?= date('M d, Y', strtotime($data->date_created)); ?></td>
	<td>
		<small>
		<?php 
		switch($data->status) {
			case 1:
				echo "<strong>APPROVED</strong>";
				break;
			case 2:
				echo "Pending to NC/Admin";
				break;
			case 3:
				echo "Pending to AC";
				break;
		}
	 	?>
		</small>
	</td>
	<td>
		<span class="btn-actions btn-flat btn-info btn-xs btn-view-details" title="View Nomination Details" data-loading-text="<i class='fa fa-spinner fa-spin'></i>" style="cursor:pointer;" data-id="<?= $data->id; ?>"><i class="fa fa-search"></i></span>
	</td>
</tr>