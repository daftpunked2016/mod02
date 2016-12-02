<tr>
	<td>
		<?php //echo CHtml::encode($data->id); 
			$fileupload = Fileupload::model()->findByPk($data->user_avatar);
			$user_avatar = $fileupload->filename;
		?>
		<img style="width:50px; height:50px;" src="<?php echo Yii::app()->request->baseUrl; ?>/user_avatars/<?php echo $user_avatar; ?>">
	</td>
	<td><?php echo CHtml::encode($data->account->username); ?></td>
	<td><?php echo CHtml::encode($data->firstname); ?></td>
	<td><?php echo CHtml::encode($data->lastname); ?></td>
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
	<td>
		<?php
			echo CHtml::link('<span class="btn btn-success">Assign as Chapter President</span>', array('/admin/account/assignpresident', 'id' => $data->account_id), array('class' => 'btn', 'confirm' => "Are you sure you want to assign this account as CHAPTER PRESIDENT?", 'title' => 'Delete'));
		?>
	</td>
</tr>