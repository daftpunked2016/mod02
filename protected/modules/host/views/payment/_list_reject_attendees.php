<?php
  $user = User::model()->find(array('condition'=>'account_id='.$data->account_id));
  $fileupload = Fileupload::model()->findByPk($user->user_avatar);
  $user_avatar = $fileupload->filename;
  $chapter = Chapter::model()->find(array('condition' => 'id ='.$user->chapter_id));
?>
<tr>
  <td><img src="<?php echo Yii::app()->request->baseUrl; ?>/user_avatars/<?php echo $user_avatar; ?>" class="img-circle" alt="User Image" style="height:50px; width:50px;display:block;margin-left:auto;margin-right:auto; margin-top:0px; border: 14px #FFF;" /></td>
  <td><?php echo $user->getCompleteName2($data->account_id); ?></td>
  <td><?php echo $user->contactno; ?></td>
  <td><?php echo $chapter->chapter; ?></td>
  <td><?php echo date('F d, Y h:i:A', strtotime($data->date_registered)); ?></td>
  <td class="text-center">
    <?php echo CHtml::link('<span class="btn btn-sm btn-info">Billing Statement</span>', array('payment/viewBSPDF', 'event_id' => $data->event_id,'account_id' => $data->account_id), array('title' => 'Billing Statement', 'target' => '_blank')); ?>
    <a href='#myModal<?php echo CHtml::encode($data->id); ?>' data-toggle="modal" data-target="#myModal<?php echo CHtml::encode($data->id); ?>"><span class="btn btn-sm btn-warning">View Payment</span></a>
    <?php echo CHtml::link('<span class="btn btn-sm btn-danger">Move to Pending</span>', array('payment/movetopending', 'id' => $data->id, 'status' => 1), array('title' => 'Move to Pending', 'confirm' => 'Are you sure you want to move this record to pending?')); ?>
  </td>
</tr>