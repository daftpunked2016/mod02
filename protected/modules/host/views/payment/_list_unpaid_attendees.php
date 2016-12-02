<?php
  $user = User::model()->find(array('condition'=>'account_id='.$data->account_id));
  $account = Account::model()->findByPk($data->account_id);
  $fileupload = Fileupload::model()->findByPk($user->user_avatar);
  $user_avatar = $fileupload->filename;
  $chapter = Chapter::model()->find(array('condition' => 'id ='.$user->chapter_id));
?>
<tr>
  <td><img src="<?php echo Yii::app()->request->baseUrl; ?>/user_avatars/<?php echo $user_avatar; ?>" class="img-circle" alt="User Image" style="height:50px; width:50px;display:block;margin-left:auto;margin-right:auto; margin-top:0px; border: 14px #FFF;" /></td>
  <td><?php echo $account->username; ?></td>
  <td><?php echo $user->getCompleteName2($data->account_id); ?></td>
  <td><?php echo $user->contactno; ?></td>
  <td><?php echo $chapter->chapter; ?></td>
  <td><?php echo date('F d, Y h:i:A', strtotime($data->date_registered)); ?></td>
  <td class="text-center">
    <?php echo CHtml::link('<span class="btn btn-sm btn-info">Billing Statement</span>', array('payment/viewBSPDF', 'event_id' => $data->event_id,'account_id' => $data->account_id), array('title' => 'Billing Statement', 'target' => '_blank')); ?>
  </td>
</tr>