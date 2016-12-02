<tr>
	<td>
		<?php //echo CHtml::encode($data->id); 
			$fileupload = Fileupload::model()->findByPk($data->user_avatar);
			$user_avatar = $fileupload->filename;
		?>
		<img style="width:50px; height:50px;" src="<?php echo Yii::app()->request->baseUrl; ?>/user_avatars/<?php echo $user_avatar; ?>">
	</td>
	<td><?php echo CHtml::encode($data->account->username); ?></td>
	<td><?php echo CHtml::encode(strtoupper($data->firstname.' '.$data->lastname)); ?></td>
	<td><?php echo CHtml::encode($data->birthdate); ?></td>
	<td>
		<?php
			$file = Chapter::model()->findByPk($data->chapter_id);
			$chapter = $file->chapter;
						
			echo CHtml::encode($chapter); 
		?>
	</td>
	<td>
		<?php
			$file = Position::model()->findByPk($data->position_id);
			$position = $file->position;
			
			echo CHtml::encode($position);
		?>
	</td>
</tr>