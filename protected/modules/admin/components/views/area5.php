<table class="table table-striped" >
	<thead>
		<th>Region</th>
		<th>Active</th>
		<th>Inactive</th>
		<th>Total Registrants</th>
	</thead>

	<tr>
		<td><?php echo CHtml::link('<span>Northern Mindanao</span>',array('default/northernmindanao')) ?></td>
		<td><?php echo User::model()->isArea5Region18()->isActive()->count() ?></td>
		<td><?php echo User::model()->isArea5Region18()->isInactive()->count() ?></td>
		<td>
			<?php
				$active = User::model()->isArea5Region18()->isActive()->count();
				$inactive = User::model()->isArea5Region18()->isInactive()->count();

				$total = ($active + $inactive);

				echo $total;

			?>
		</td>
	</tr>

	<tr>
		<td><?php echo CHtml::link('<span>Davao Region</span>',array('default/davaoregion')) ?></td>
		<td><?php echo User::model()->isArea5Region19()->isActive()->count() ?></td>
		<td><?php echo User::model()->isArea5Region19()->isInactive()->count() ?></td>
		<td>
			<?php
				$active = User::model()->isArea5Region19()->isActive()->count();
				$inactive = User::model()->isArea5Region19()->isInactive()->count();

				$total = ($active + $inactive);

				echo $total;

			?>
		</td>
	</tr>

	<tr>
		<td><?php echo CHtml::link('<span>Southern Mindanao</span>',array('default/southernmindanao')) ?></td>
		<td><?php echo User::model()->isArea5Region20()->isActive()->count() ?></td>
		<td><?php echo User::model()->isArea5Region20()->isInactive()->count() ?></td>
		<td>
			<?php
				$active = User::model()->isArea5Region20()->isActive()->count();
				$inactive = User::model()->isArea5Region20()->isInactive()->count();

				$total = ($active + $inactive);

				echo $total;

			?>
		</td>
	</tr>

	<tr>
		<td><?php echo CHtml::link('<span>Central Mindanao</span>',array('default/centralmindanao')) ?></td>
		<td><?php echo User::model()->isArea5Region21()->isActive()->count() ?></td>
		<td><?php echo User::model()->isArea5Region21()->isInactive()->count() ?></td>
		<td>
			<?php
				$active = User::model()->isArea5Region21()->isActive()->count();
				$inactive = User::model()->isArea5Region21()->isInactive()->count();

				$total = ($active + $inactive);

				echo $total;

			?>
		</td>
	</tr>

	<tr>
		<td><?php echo CHtml::link('<span>Western Mindanao</span>',array('default/westernmindanao')) ?></td>
		<td><?php echo User::model()->isArea5Region22()->isActive()->count() ?></td>
		<td><?php echo User::model()->isArea5Region22()->isInactive()->count() ?></td>
		<td>
			<?php
				$active = User::model()->isArea5Region22()->isActive()->count();
				$inactive = User::model()->isArea5Region22()->isInactive()->count();

				$total = ($active + $inactive);

				echo $total;

			?>
		</td>
	</tr>


</table>