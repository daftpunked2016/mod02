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
			echo CHtml::link('<span class="btn btn-danger">Delete</span>', array('/admin/account/delete', 'id' => $data->account_id), array('class' => 'btn', 'confirm' => "Are you sure you want to delete this account?", 'title' => 'View'));
			
			echo CHtml::link('<span class="btn btn-warning">View</span>', array('/admin/account/view', 'id' => $data->account_id), array('class' => 'btn', 'title' => 'View'));

			echo CHtml::link('<span class="btn btn-success">Activate</span>', array('/admin/account/activateaccount', 'id' => $data->account_id), array('class' => 'btn', 'confirm' => "Are you sure you want to activate this account?", 'title' => 'Delete'));
		?>
	</td>
</tr>