<table class="table table-striped" >
	<thead>
		<th>Region</th>
		<th>Active</th>
		<th>Inactive</th>
		<th>Total Registrants</th>
	</thead>

	<tr>
		<td><?php echo CHtml::link('<span>Cagayan Valley</span>',array('default/cagayanvalley')) ?></td>
		<td><?php echo User::model()->isArea1Region1()->isActive()->userAccount()->count() ?></td>
		<td><?php echo User::model()->isArea1Region1()->isInactive()->userAccount()->count() ?></td>
		<td>
			<?php
				$active = User::model()->isArea1Region1()->isActive()->userAccount()->count();
				$inactive = User::model()->isArea1Region1()->isInactive()->userAccount()->count();

				$total = ($active + $inactive);

				echo $total;

			?>
		</td>
	</tr>

	<tr>
		<td><?php echo CHtml::link('<span>Central Luzon</span>',array('default/centralluzon')) ?></td>
		<td><?php echo User::model()->isArea1Region2()->isActive()->userAccount()->count() ?></td>
		<td><?php echo User::model()->isArea1Region2()->isInactive()->userAccount()->count() ?></td>
		<td>
			<?php
				$active = User::model()->isArea1Region2()->isActive()->userAccount()->count();
				$inactive = User::model()->isArea1Region2()->isInactive()->userAccount()->count();

				$total = ($active + $inactive);

				echo $total;

			?>
		</td>
	</tr>

	<tr>
		<td><?php echo CHtml::link('<span>Northern Luzon</span>',array('default/northernluzon')) ?></td>
		<td><?php echo User::model()->isArea1Region3()->isActive()->userAccount()->count() ?></td>
		<td><?php echo User::model()->isArea1Region3()->isInactive()->userAccount()->count() ?></td>
		<td>
			<?php
				$active = User::model()->isArea1Region3()->isActive()->userAccount()->count();
				$inactive = User::model()->isArea1Region3()->isInactive()->userAccount()->count();

				$total = ($active + $inactive);

				echo $total;

			?>
		</td>
	</tr>

	<tr>
		<td><?php echo CHtml::link('<span>Ilocandia Region</span>',array('default/ilocandiaregion')) ?></td>
		<td><?php echo User::model()->isArea1Region4()->isActive()->userAccount()->count() ?></td>
		<td><?php echo User::model()->isArea1Region4()->isInactive()->userAccount()->count() ?></td>
		<td>
			<?php
				$active = User::model()->isArea1Region4()->isActive()->userAccount()->count();
				$inactive = User::model()->isArea1Region4()->isInactive()->userAccount()->count();

				$total = ($active + $inactive);

				echo $total;

			?>
		</td>
	</tr>

</table>