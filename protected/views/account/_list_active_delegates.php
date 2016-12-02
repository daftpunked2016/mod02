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
		<?php echo CHtml::link('<i class="fa fa-search"></i> View', array('/account/view', 'id' => $data->account_id), array('class'=>'btn-sm btn-warning')); ?>
		<?php echo CHtml::link('<i class="fa fa-times"></i> Deactivate', array('/account/deactivateAccount', 'id' => $data->account_id), array('class'=>'btn-sm btn-danger', 'confirm' => "Are you sure you want to deactivate this account and return it to inactive accounts list?", 'title' => 'Delete')); ?>
	</td>
</tr>