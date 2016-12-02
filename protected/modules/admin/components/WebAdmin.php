<?php

class WebAdmin extends CWebUser
{
	private $_model;
	
	function getAccount()
	{
		$model = $this->loadAccount(Yii::app()->getModule('admin')->user->id);
		
		if ($model === null && !Yii::app()->getModule('admin')->user->isGuest)
		{
			Yii::app()->getModule('admin')->user->logout();
			Yii::app()->controller->redirect(Yii::app()->getModule('admin')->homeUrl);
			Yii::app()->end();
		}
		
		return $model;
	}
	
	protected function loadAccount($id = null)
	{
		if ($this->_model === null)
		{
			if ($id !== null)
			{
				$this->_model = Account::model()->findByPk($id);
			}
		}
		
		return $this->_model;
	}
	
	public function checkAccess($operation, $params=array())
    {

        if (empty($this->id)) {
            // Not identified => no rights
            return false;
        }

        $role = $this->getState("roles");
		
        if ($role == $operation) {
            return true; // admin role has access to everything
        }
				
        // allow access if the operation request is the current user's role
        return ($operation === $role);
    }
}
?>