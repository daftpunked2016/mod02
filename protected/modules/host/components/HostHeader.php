<?php
/* add variables or conditions if need */
	class HostHeader extends CWidget
	{
		
		public function init()
		{
			
		}
		
		public function run()
		{	
			$active = Yii::app()->getController()->id;
			if(Yii::app()->getModule('host')->user->isGuest) {
				$this->render('headerNotAuth');		
			}
			else {	
				$authAccount = Yii::app()->getModule('host')->user->account;

				$user = User::model()->find(array('condition' => 'account_id ='.$authAccount->account_id));

				$this->render("hostHeader", array(
					'user' => $user,
					'active' => $active
				));
			}
		}
	}
?>