<tr>
  <td>
    <?php //echo CHtml::encode($data->id); 
      $fileupload = Fileupload::model()->findByPk($data->user->user_avatar);
      $user_avatar = $fileupload->filename;
    ?>
    <img style="width:50px; height:50px;" src="<?php echo Yii::app()->request->baseUrl; ?>/user_avatars/<?php echo $user_avatar; ?>">
  </td>
  <td><?php echo CHtml::encode($data->user->account->username); ?></td>
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
</tr>