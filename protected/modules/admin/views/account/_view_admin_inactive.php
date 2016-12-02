<tr>
	<td>
		<?php //echo CHtml::encode($data->id); 
			$fileupload = Fileupload::model()->findByPk($data->user->user_avatar);
			$user_avatar = $fileupload->filename;
		?>
		<img style="width:50px; height:50px;" src="<?php echo Yii::app()->request->baseUrl; ?>/avatars/<?php echo $user_avatar; ?>">
	</td>
	<td><?php echo CHtml::encode($data->username); ?></td>
	<td><?php echo CHtml::encode($data->user->firstname); ?></td>
	<td><?php echo CHtml::encode($data->user->lastname); ?></td>
	<td>
		<?php
			$file = Chapter::model()->findByPk($data->user->chapter_id);
			$chapter = $file->chapter;
						
			echo CHtml::encode($chapter); 
		?>
	</td>
	<td>
		<?php
			$file = Position::model()->findByPk($data->user->position_id);
			$position = $file->position;
			
			echo CHtml::encode($position);
		?>
	</td>
	<td>
		<?php
			echo CHtml::link('<span class="btn btn-warning">View</span>', array('/admin/account/view', 'id' => $data->id), array('class' => 'btn', 'title' => 'View'));

			echo CHtml::link('<span class="btn btn-success">Activate</span>', array('/admin/account/activateaccount', 'id' => $data->id), array('class' => 'btn', 'confirm' => "Are you sure you want to deactivate this account?", 'title' => 'Delete'));
		?>
	</td>
</tr>