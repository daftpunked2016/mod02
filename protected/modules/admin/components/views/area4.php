<table class="table table-striped" >
	<thead>
		<th>Region</th>
		<th>Active</th>
		<th>Inactive</th>
		<th>Total Registrants</th>
	</thead>

	<tr>
		<td><?php echo CHtml::link('<span>Eastern Visayas</span>',array('default/easternvisayas')) ?></td>
		<td><?php echo User::model()->isArea4Region15()->isActive()->count() ?></td>
		<td><?php echo User::model()->isArea4Region15()->isInactive()->count() ?></td>
		<td>
			<?php
				$active = User::model()->isArea4Region15()->isActive()->count();
				$inactive = User::model()->isArea4Region15()->isInactive()->count();

				$total = ($active + $inactive);

				echo $total;

			?>
		</td>
	</tr>

	<tr>
		<td><?php echo CHtml::link('<span>Central Visayas</span>',array('default/centralvisayas')) ?></td>
		<td><?php echo User::model()->isArea4Region17()->isActive()->count() ?></td>
		<td><?php echo User::model()->isArea4Region17()->isInactive()->count() ?></td>
		<td>
			<?php
				$active = User::model()->isArea4Region17()->isActive()->count();
				$inactive = User::model()->isArea4Region17()->isInactive()->count();

				$total = ($active + $inactive);

				echo $total;

			?>
		</td>
	</tr>

	<tr>
		<td><?php echo CHtml::link('<span>Western Visayas</span>',array('default/westernvisayas')) ?></td>
		<td><?php echo User::model()->isArea4Region16()->isActive()->count() ?></td>
		<td><?php echo User::model()->isArea4Region16()->isInactive()->count() ?></td>
		<td>
			<?php
				$active = User::model()->isArea4Region16()->isActive()->count();
				$inactive = User::model()->isArea4Region16()->isInactive()->count();

				$total = ($active + $inactive);

				echo $total;

			?>
		</td>
	</tr>

</table>