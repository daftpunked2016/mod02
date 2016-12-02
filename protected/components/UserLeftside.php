<?php
/* add variables or conditions if need */
class UserLeftside extends CWidget
{
	
	public function init()
	{
		
	}
	
	public function run()
	{	
        $user = User::model()->find('account_id = '.Yii::app()->user->id);
        $fileupload = Fileupload::model()->findByPk($user->user_avatar);
        $user_avatar = $fileupload->filename;

		$this->render("userLeftside",array(
			'user' => $user,
			'user_avatar' => $user_avatar
		));
	}
}
?>