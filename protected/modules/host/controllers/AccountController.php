<?php

class AccountController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';
	public $layout='/layouts/main';

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$account = Account::model()->findByPk($id);
		$user = User::model()->findByAttributes(array('account_id'=>$account->id));

		if(isset($_POST['sen_no']))
		{
			$user->sen_no = $_POST['sen_no'];
			if($user->save())
			{
				Yii::app()->user->setFlash('success','You have successfully change the senator number of this account.');
				$this->redirect(array('view', 'id'=>$id));
			}
		}
		
		if(isset($_POST['username']))
		{
			$validator = new CEmailValidator;
	        if($validator->validateValue($_POST['username']))
            {
            	$account->username = $_POST['username'];
            	$valid = $account->validate();

            	if($valid)
            	{
            		if($account->save())
					{
						Yii::app()->user->setFlash('success','You have successfully change the username / email of this account.');
						$this->redirect(array('view', 'id'=>$id));
					}
            	}
            	else
            	{
            		Yii::app()->user->setFlash('danger','Username / Email has already been taken.');
            		$this->redirect(array('view', 'id'=>$id));
            	}
            }
            else
    		{
    			Yii::app()->user->setFlash('danger','You have an invalid username / email address. Please try again.');
    			$this->redirect(array('view', 'id'=>$id));
    		}  
		}



		if(isset($_POST['position_id']))
		{
			$userposition = UserPositions::model()->find(array('condition' => 'account_id ='.$account->id.' AND status_id = 1'));
			$userposition->position_id = $_POST['position_id'];

			if($userposition->save())
			{	
				$user->position_id = $userposition->position_id;

				if($user->save())
				{	
					Yii::app()->user->setFlash('success','You have successfully change Level & Position of this account.');
					$this->redirect(array('view', 'id'=>$id));	
				}
			}
		}


		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionProfile($id)
	{
		$id = Yii::app()->host->id;
		$host = Host::model()->findByPk($id);
		$user = User::model()->findByAttributes(array('account_id'=>$host->account_id));

		$this->render('profile',array(
			'model'=>$this->loadModel($id),
			'user'=>$user,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */

	
	public function actionChangePassword()
	{
		$id = Yii::app()->host->id;
		
		if($id!=null)
		{
			//$account = new Account;
			$host = Host::model()->findByAttributes(array('id'=>$id));

			$user = User::model()->findByAttributes(array('account_id'=>$host->account_id));

			$host->setScenario('changePwd');

			if(isset($_POST['Host']))
			{
				$host->attributes = $_POST['Host'];


				$valid = $host->validate();
				
					if($valid)
						{
							$host->salt = Host::model()->generateSalt();
							$host->password = Host::model()->hashPassword($host->new_password,$host->salt);
							$fullName = $user->firstname." ".$user->lastname;
							$title = '';
							
							if($user->gender == 1)
								$title = 'Mr.';
							else
								$title = 'Ms./Mrs.';

							if($host->save(false))
							{
								Yii::app()->user->setFlash('success','You have successfully changed your password!');
								$this->redirect(array('changePassword','msg'=>'SUCCESS!'));
							}
							else
							{
								 Yii::app()->user->setFlash('error','An error has occurred while trying to change your password. Please try again later.');
								 $this->redirect(array('changePassword','msg'=>'FAIL!'));
							}
						}
			}
	
			$this->render('changepass',array(
					'host' => $host,
				));	
		}
		else
			throw new CHttpException(404,'The requested page does not exist.');
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */

	public function actionAdmin()
	{
		$model=new Account('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Account']))
			$model->attributes=$_GET['Account'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Account the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Host::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Account $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='account-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
