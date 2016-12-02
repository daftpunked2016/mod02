<table class="table table-striped" >
	<thead>
		<th>Region</th>
		<th>Active</th>
		<th>Inactive</th>
		<th>Total Registrants</th>
	</thead>

	<tr>
		<td><?php echo CHtml::link('<span>Metro North</span>',array('default/metronorth')) ?></td>
		<td><?php echo User::model()->isArea2Region5()->isActive()->count() ?></td>
		<td><?php echo User::model()->isArea2Region5()->isInactive()->count() ?></td>
		<td>
			<?php
				$active = User::model()->isArea2Region5()->isActive()->count();
				$inactive = User::model()->isArea2Region5()->isInactive()->count();

				$total = ($active + $inactive);

				echo $total;

			?>
		</td>
	</tr>

	<tr>
		<td><?php echo CHtml::link('<span>Metro East</span>',array('default/metroeast')) ?></td>
		<td><?php echo User::model()->isArea2Region6()->isActive()->count() ?></td>
		<td><?php echo User::model()->isArea2Region6()->isInactive()->count() ?></td>
		<td>
			<?php
				$active = User::model()->isArea2Region6()->isActive()->count();
				$inactive = User::model()->isArea2Region6()->isInactive()->count();

				$total = ($active + $inactive);

				echo $total;

			?>
		</td>
	</tr>

	<tr>
		<td><?php echo CHtml::link('<span>Metro South</span>',array('default/metrosouth')) ?></td>
		<td><?php echo User::model()->isArea2Region7()->isActive()->count() ?></td>
		<td><?php echo User::model()->isArea2Region7()->isInactive()->count() ?></td>
		<td>
			<?php
				$active = User::model()->isArea2Region7()->isActive()->count();
				$inactive = User::model()->isArea2Region7()->isInactive()->count();

				$total = ($active + $inactive);

				echo $total;

			?>
		</td>
	</tr>

	<tr>
		<td><?php echo CHtml::link('<span>Rizal Region</span>',array('default/rizalregion')) ?></td>
		<td><?php echo User::model()->isArea2Region8()->isActive()->count() ?></td>
		<td><?php echo User::model()->isArea2Region8()->isInactive()->count() ?></td>
		<td>
			<?php
				$active = User::model()->isArea2Region8()->isActive()->count();
				$inactive = User::model()->isArea2Region8()->isInactive()->count();

				$total = ($active + $inactive);

				echo $total;

			?>
		</td>
	</tr>
</table>