<?php

class DefaultController extends Controller
{
	public $layout = '/layouts/main';

	public function actionIndex()
	{
		$this->redirect('event/index');
	}

	public function actionLogin()
	{	
		$this->layout ='default/login';
		$model = new HostLoginForm;
		if(isset($_POST['HostLoginForm']))
		{
			if($_POST['HostLoginForm']['event_id'] != null)
			{
				$model->attributes = $_POST['HostLoginForm'];

				if ($model->validate() && $model->login())
				{
					// $transaction = new Transaction;
					// $transaction->generateLog(Yii::app()->getModule("admin")->user->id, Transaction::TYPE_LOGIN);
					$this->redirect(array('event/index'));
				}
			}
			else
				Yii::app()->user->setFlash('danger', 'Select Event first.');
		}

		$this->render('login',array('model'=>$model));
	}

	public function actionLogout()
	{
		if(isset($_SESSION['token']))
			unset($_SESSION['token']);
			
		Yii::app()->getModule('host')->user->logout(false);
		Yii::app()->user->setFlash('success', 'Logout Successful.');
		$this->redirect(Yii::app()->getModule('host')->user->loginUrl);
	}

	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
}