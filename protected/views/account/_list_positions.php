<tr <?php if($data->status_id == 1) echo "style='font-weight: bold;'"; ?> >
	<td>
		<a href='#positionModal<?php echo CHtml::encode($data->id); ?>' data-toggle="modal" data-target="#positionModal<?php echo CHtml::encode($data->id); ?>">
		<?php
			$file = Position::model()->findByPk($data->position_id);
			$position = $file->position;
			
			echo CHtml::encode($position);
		?>
		</a>
	</td>
		<td>
		<?php
			$file = Chapter::model()->findByPk($data->chapter_id);
			$chapter = $file->chapter;
						
			echo CHtml::encode($chapter); 
		?>
	</td>
	<td><?php echo CHtml::encode($data->term_year); ?></td>
	<td>
		<a href="<?php echo Yii::app()->baseUrl;?>/index.php/account/updatePosition/<?php echo $data->id; ?>"><span class="glyphicon glyphicon-pencil" style="margin-right: 5px;"></span></a>
		<?php if($data->status_id != 1): ?>
			<?php	
				echo CHtml::link('<span class="glyphicon glyphicon-remove" style="margin-right: 5px;"></span>', array('account/deleteposition', 'id' => $data->id), array('confirm' => "Are you sure you want to delete this position?", 'title' => 'Delete Position'));
			?>
		<?php else: ?>
			<span class="badge" style="background:red;">ACTIVE / CURRENT</span>
		<?php endif; ?>
	</td>
</tr>