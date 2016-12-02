<table class="table table-striped" >
	<thead>
		<th>Region</th>
		<th>Active</th>
		<th>Inactive</th>
		<th>Total Registrants</th>
	</thead>

	<tr>
		<td><?php echo CHtml::link('<span>Southern Tagalog</span>',array('default/southerntagalog')) ?></td>
		<td><?php echo User::model()->isArea3Region9()->isActive()->count() ?></td>
		<td><?php echo User::model()->isArea3Region9()->isInactive()->count() ?></td>
		<td>
			<?php
				$active = User::model()->isArea3Region9()->isActive()->count();
				$inactive = User::model()->isArea3Region9()->isInactive()->count();

				$total = ($active + $inactive);

				echo $total;

			?>
		</td>
	</tr>

	<tr>
		<td><?php echo CHtml::link('<span>Laguna Region</span>',array('default/lagunaregion')) ?></td>
		<td><?php echo User::model()->isArea3Region10()->isActive()->count() ?></td>
		<td><?php echo User::model()->isArea3Region10()->isInactive()->count() ?></td>
		<td>
			<?php
				$active = User::model()->isArea3Region10()->isActive()->count();
				$inactive = User::model()->isArea3Region10()->isInactive()->count();

				$total = ($active + $inactive);

				echo $total;

			?>
		</td>
	</tr>

	<tr>
		<td><?php echo CHtml::link('<span>Cavite South</span>',array('default/cavitesouth')) ?></td>
		<td><?php echo User::model()->isArea3Region11()->isActive()->count() ?></td>
		<td><?php echo User::model()->isArea3Region11()->isInactive()->count() ?></td>
		<td>
			<?php
				$active = User::model()->isArea3Region11()->isActive()->count();
				$inactive = User::model()->isArea3Region11()->isInactive()->count();

				$total = ($active + $inactive);

				echo $total;

			?>
		</td>
	</tr>

	<tr>
		<td><?php echo CHtml::link('<span>Cavite North</span>',array('default/cavitenorth')) ?></td>
		<td><?php echo User::model()->isArea3Region12()->isActive()->count() ?></td>
		<td><?php echo User::model()->isArea3Region12()->isInactive()->count() ?></td>
		<td>
			<?php
				$active = User::model()->isArea3Region12()->isActive()->count();
				$inactive = User::model()->isArea3Region12()->isInactive()->count();

				$total = ($active + $inactive);

				echo $total;

			?>
		</td>
	</tr>

	<tr>
		<td><?php echo CHtml::link('<span>Palawan Region</span>',array('default/palawanregion')) ?></td>
		<td><?php echo User::model()->isArea3Region13()->isActive()->count() ?></td>
		<td><?php echo User::model()->isArea3Region13()->isInactive()->count() ?></td>
		<td>
			<?php
				$active = User::model()->isArea3Region13()->isActive()->count();
				$inactive = User::model()->isArea3Region13()->isInactive()->count();

				$total = ($active + $inactive);

				echo $total;

			?>
		</td>
	</tr>

	<tr>
		<td><?php echo CHtml::link('<span>Bicol Region</span>',array('default/bicolregion')) ?></td>
		<td><?php echo User::model()->isArea3Region14()->isActive()->count() ?></td>
		<td><?php echo User::model()->isArea3Region14()->isInactive()->count() ?></td>
		<td>
			<?php
				$active = User::model()->isArea3Region14()->isActive()->count();
				$inactive = User::model()->isArea3Region14()->isInactive()->count();

				$total = ($active + $inactive);

				echo $total;

			?>
		</td>
	</tr>

</table>