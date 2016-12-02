<?php
/* add variables or conditions if need */
	class AdminHeader extends CWidget
	{
		
		public function init()
		{
			
		}
		
		public function run()
		{	
			$active = Yii::app()->getController()->id;
			if(Yii::app()->getModule('admin')->user->isGuest) {
				$this->render('headerNotAuth');		
			}
			else {	
				$authAccount = Yii::app()->getModule('admin')->user->account;
				$user = $authAccount->user;

				$this->render("adminHeader", array(
					'user' => $user,
					'active' => $active
				));
			}
		}
	}
?>