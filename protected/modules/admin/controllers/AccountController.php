<?php

class AccountController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	// public $layout='//layouts/column2';
	public $layout='/layouts/admin';

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

		if(isset($_POST['member_id']))
		{
			$user->member_id = $_POST['member_id'];
			if($user->save())
			{
				Yii::app()->user->setFlash('success','You have successfully change the Member ID of this account.');
				$this->redirect(array('view', 'id'=>$id));
			}
		}

		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionProfile($id)
	{
		$id = Yii::app()->admin->id;
		$account = Account::model()->findByPk($id);
		$user = User::model()->findByAttributes(array('account_id'=>$id));
		
		$this->render('profile',array(
			'model'=>$this->loadModel($id),
			'user'=>$user,
		));
	}

	//Account Registration (Full Step)
	public function actionRegister()
	{
		$account = new Account;
		$user = new User;
		$fileupload = new Fileupload;
		$filerelation = new Filerelation;
		$userposition = new UserPositions;
		
		$account->setScenario("createNewAccount");
		$user->setScenario("createNewUser");
		
		if ((isset($_POST['Account'])) AND (isset($_POST['User'])))
		{
			$account->attributes = $_POST['Account'];
			$user->attributes = $_POST['User'];
			$term_year = $_POST['term_year'];
			$image = $fileupload->filename=CUploadedFile::getInstance($user,'user_avatar');
			$account->account_type_id = 2;
			
			$valid = $account->validate();
			$valid = $user->validate() && $valid;
			
			if ($valid)
			{	
				$connection = Yii::app()->db;
				$transaction = $connection->beginTransaction();
		
				try
				{
					if ($account->save())
					{
						$user->account_id = $account->id;
						$fileupload->poster_id = $account->id;
						
						if ($fileupload->save())
						{
							$fileupload->filename->saveAs('user_avatars/'.$image);
							$user->user_avatar = $fileupload->id;
							
							if ($user->save())
							{
								$filerelation->fileupload_id = $fileupload->id;
								$filerelation->relationship_id = 1; //1 means User Accounts
								
								if ($filerelation->save())
								{
									$userposition->account_id = $account->id;
									$userposition->position_id = $user->position_id;
									$userposition->chapter_id = $user->chapter_id;
									$userposition->term_year = $term_year;

									if($userposition->save())
									{
										$transaction->commit();
										Yii::app()->user->setFlash('success','You have successfully registered an account! Please check your email for the account verification or activation link.');
										$this->redirect(array('account/index'));
									}
								}
							}
						}
						else
							print_r($fileupload->getErrors());exit;
					}
				}
				catch (Exception $e)
				{
					$transaction->rollback();
					Yii::app()->user->setFlash('error', 'An error occured while trying to register an account! Please try again later.');
				}
			}

		}

		$this->render('create',array(
			'account' => $account,
			'user' => $user,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdateAccount($id)
	{
		$account = Account::model()->findByPk($id);
		$user = $account->user;
		$chapter = Chapter::model()->find(array('condition' => 'id ='.$user->chapter_id));

		// echo "<pre>";
		// print_r($chapter->attributes);
		// echo "</pre>";
		// exit;

		if($id!=null)
		{
			if((isset($_POST['Account'])) AND (isset($_POST['User'])))
			{
				$account->attributes=$_POST['Account'];
				$user->attributes = $_POST['User'];

				$account->setScenario("updateAccount");
				
				$valid = $account->validate();
				$valid = $user->validate() && $valid;
				
				if ($valid)
				{  
					$connection = Yii::app()->db;
					$transaction = $connection->beginTransaction();
					
					try
					{
						if($account->save(false))
							{
								if ($user->save(false))
									{
										$transaction->commit();
										Yii::app()->user->setFlash('success','You have successfully updated the account!');
										$this->redirect(array('account/update'));
									}
							}
					}
					catch (Exception $e)
					{
						$transaction->rollback();
						Yii::app()->user->setFlash('error', 'An error occured while trying to update the account! Please try again later.');
					} 
				}
			}
	
		$this->render('update',array(
				'account' => $account,
				'user' => $user,
			));	
		}
		else
			throw new CHttpException(404,'The requested page does not exist.');
	}

	
	public function actionChangePassword()
	{
		$account_id = Yii::app()->admin->id;
		
		if($account_id!=null)
		{
			//$account = new Account;
			$account = Account::model()->findByAttributes(array('id'=>$account_id));
			$user = User::model()->findByAttributes(array('account_id'=>$account_id));
			$account->setScenario('changePwd');
			
			if(isset($_POST['Account']))
			{
				$account->attributes = $_POST['Account'];
				$valid = $account->validate();
				
					if($valid)
						{
							$account->salt=Account::model()->generateSalt();
							$account->password=Account::model()->hashPassword($account->new_password,$account->salt);
							$fullName = $user->firstname." ".$user->lastname;
							$title = '';
							
							if($user->gender == 1)
								$title = 'Mr.';
							else
								$title = 'Ms./Mrs.';

							if($account->save(false))
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
					'account' => $account,
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
	public function actionDelete($id)
	{
		//$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		// if(!isset($_GET['ajax']))
		// 	$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		$account = Account::model()->findByPk($id);
		$user = User::model()->find(array('condition' => 'account_id ='.$account->id));

		if($user->delete())
		{
			if($account->delete())
			{
				Yii::app()->user->setFlash('success','You have successfully deleted the account.');
				$this->redirect(array('inactiveindex'));
			}
		}
	}

	public function actionDeactivateAccount($id)
	{
		$account = Account::model()->findByPk($id);
		if (!empty($account))
		{
			$account->status_id = Account::STATUS_INACTIVE;
			if ($account->save(false))
			{
				Yii::app()->user->setFlash('success','You have successfully deactivate the account.');
				$this->redirect(array('index'));
			}
			else
			{
				Yii::app()->user->setFlash('error','An error occured while trying to deactivate the account. Please try again later.');
				$this->redirect(array('index'));
			}
				
		}
		else
			throw new CHttpException(404,'The requested page does not exist.');
	}

	public function actionActivateAccount($id)
	{
		$account = Account::model()->findByPk($id);
		$user = User::model()->find('account_id ='.$id);

		if (!empty($account))
		{
			$account->status_id = Account::STATUS_ACTIVE;
			if ($account->save(false))
			{
				//Email formatting

				if($user->title == 1 && $user->position_id != 11)
					$subject = "JCI Philippines | JCI SEN Account Successfully Verified by the JCI Headquarters";
				elseif($user->title != 1 && $user->position_id == 11)
					$subject = "JCI Philippines | JCI Chapter President Account Successfully Verified by the JCI Headquarters";
				elseif($user->title == 1 && $user->position_id == 11)
					$subject = "JCI Philippines | JCI SEN and Chapter President Account Successfully Verified by the JCI Headquarters";
				elseif($user->title != 1 && $user->position_id != 11)
					$subject = "JCI Philippines | Account Successfully Verified";



				$body = "Your account has been successfully verified and activated by the JCI Headquarters(Administrator) Team. 
				You can now log-in and use your account by clicking this link : <a href='http://jci.org.ph/mod02/index.php/site/login'>JCI Log-in Page</a> <br /><br />
				Please always check your e-mail and keep yourself updated for all of JCI Philippines News & Latest Events. Thank you!<br /><br />
				JCI Philippines";
				$send = Account::model()->populateMsgProperties($account->id, $subject, $body);

				if($send == 1)
					Yii::app()->user->setFlash('success','You have successfully activated an account!');
				else
					Yii::app()->user->setFlash('success','You have successfully activated an account! But have failed sending the e-mail notification.');

				$this->redirect(array('inactiveindex'));
			}
			else
			{
				Yii::app()->user->setFlash('error','An error occured while trying to activate the account. Please try again later.');
				$this->redirect(array('inactiveindex'));
			}
				
		}
		else
			throw new CHttpException(404,'The requested page does not exist.');
	}

	public function actionChangeToSen($id)
	{
		$account = Account::model()->findByPk($id);
		$user = User::model()->find(array('condition' => 'account_id ='.$account->id));

		if (!empty($account))
		{	

			$user->title = 1;
			if ($user->save(false))
			{
				Yii::app()->user->setFlash('success','You have successfully change the account title to Senator.');
				$this->redirect(array('view', 'id'=>$id));
			}
			else
			{
				Yii::app()->user->setFlash('error','An error occured while trying to change the account title. Please try again later.');
				$this->redirect(array('view', 'id'=>$id));
			}
				
		}
		else
			throw new CHttpException(404,'The requested page does not exist.');
	}

	public function actionChangeToMem($id)
	{
		$account = Account::model()->findByPk($id);
		$user = User::model()->find(array('condition' => 'account_id ='.$account->id));

		if (!empty($account))
		{	

			$user->title = 2;
			if ($user->save(false))
			{
				Yii::app()->user->setFlash('success','You have successfully change the account title to Member.');
				$this->redirect(array('view', 'id'=>$id));
			}
			else
			{
				Yii::app()->user->setFlash('error','An error occured while trying to change the account title. Please try again later.');
				$this->redirect(array('view', 'id'=>$id));
			}
				
		}
		else
			throw new CHttpException(404,'The requested page does not exist.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$userAccounts = User::model()->isActive()->userAccount()->findAll(array('order'=>'firstname ASC'));
		$searchOption = "1";

		if(isset($_GET['name']) OR isset($_GET['chapter']) OR isset($_GET['position'])) {

			if($_GET['name'] == "" && $_GET['chapter'] == "" && $_GET['position'] == "") {
				yii::app()->user->setFlash('error', 'Please select at least 1 filter options.');
				$this->redirect(array('account/index'));
			}

			if(!empty($_GET['name'])) {
				$searchOption .= ' AND CONCAT(firstname," ",lastname) LIKE "%'.$_GET['name'].'%"';
			}

			if(!empty($_GET['chapter']))	{
				$searchOption .= ' AND chapter_id = '.$_GET['chapter'];
			}

			if(!empty($_GET['position'])) {
				$searchOption .= ' AND position_id = '.$_GET['position'];
			}

			$userAccounts = User::model()->isActive()->userAccount()->findAll(array('condition'=>$searchOption, 'order'=>'firstname ASC'));
		}

		$userAccountsDP=new CArrayDataProvider($userAccounts, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$chapters = Chapter::model()->findAll(array('order' => 'chapter'));
		$position = Position::model()->findAll(array('order' => 'category'));

		$this->render('index',array(
			'userAccountsDP'=>$userAccountsDP,
			'userAccounts'=>$userAccounts,
			'position'=>$position,
			'chapters'=>$chapters,
		));
	}

	public function actionInactiveIndex()
	{
		$userAccounts = User::model()->isInactive()->userAccount()->findAll(array('order'=>'firstname ASC'));
		$searchOption = "1";

		if(isset($_GET['name']) OR isset($_GET['chapter']) OR isset($_GET['position'])) {

			if($_GET['name'] == "" && $_GET['chapter'] == "" && $_GET['position'] == "") {
				yii::app()->user->setFlash('error', 'Please select at least 1 filter options.');
				$this->redirect(array('account/inactiveindex'));
			}

			if(!empty($_GET['name'])) {
				$searchOption .= ' AND CONCAT(firstname," ",lastname) LIKE "%'.$_GET['name'].'%"';
			}

			if(!empty($_GET['chapter']))	{
				$searchOption .= ' AND chapter_id = '.$_GET['chapter'];
			}

			if(!empty($_GET['position'])) {
				$searchOption .= ' AND position_id = '.$_GET['position'];
			}

			$userAccounts = User::model()->isInactive()->userAccount()->findAll(array('condition'=>$searchOption, 'order'=>'firstname ASC'));
		}

		$userAccountsDP=new CArrayDataProvider($userAccounts, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$position = Position::model()->findAll(array('order' => 'category'));
		$chapters = Chapter::model()->findAll(array('order' => 'chapter'));

		$this->render('inactiveindex',array(
			'userAccountsDP'=>$userAccountsDP,
			'userAccounts'=>$userAccounts,
			'position'=>$position,
			'chapters'=>$chapters,
		));
	}

	public function actionResetIndex()
	{
		$userAccounts = User::model()->isReset()->userAccount()->findAll();
		$searchOption = "1";

		if(isset($_GET['name']) OR isset($_GET['chapter']) OR isset($_GET['position'])) {

			if($_GET['name'] == "" && $_GET['chapter'] == "" && $_GET['position'] == "") {
				yii::app()->user->setFlash('error', 'Please select at least 1 filter options.');
				$this->redirect(array('account/resetindex'));
			}

			if(!empty($_GET['name'])) {
				$searchOption .= ' AND CONCAT(firstname," ",lastname) LIKE "%'.$_GET['name'].'%"';
			}

			if(!empty($_GET['chapter']))	{
				$searchOption .= ' AND chapter_id = '.$_GET['chapter'];
			}

			if(!empty($_GET['position'])) {
				$searchOption .= ' AND position_id = '.$_GET['position'];
			}

			$userAccounts = User::model()->isReset()->userAccount()->findAll(array('condition'=>$searchOption));
		}

		$userAccountsDP=new CArrayDataProvider($userAccounts, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$position = Position::model()->findAll(array('order' => 'category'));
		$chapters = Chapter::model()->findAll(array('order' => 'chapter'));

		$this->render('resetindex',array(
			'userAccountsDP'=>$userAccountsDP,
			'userAccounts'=>$userAccounts,
			'position'=>$position,
			'chapters'=>$chapters,
		));
	}

	public function actionActiveSen()
	{
		$senAccounts = Account::model()->userAccount()->isActiveSen()->findAll(array('order'=>'u.lastname ASC'));

		$senAccountDP = new CArrayDataProvider($senAccounts, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('activesen',array(
			'senAccountDP'=>$senAccountDP,
		));
	}

	public function actionInactiveSen()
	{
		$InactivesenAccounts = Account::model()->userAccount()->isInactiveSen()->findAll(array('order'=>'u.lastname ASC'));

		$InactivesenAccountDP = new CArrayDataProvider($InactivesenAccounts, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('inactivesen',array(
			'InactivesenAccountDP'=>$InactivesenAccountDP,
		));
	}

	public function actionInactiveNatPos()
	{
		$inactiveAccounts = Account::model()
		->userAccount()
		->isInactivePause()
		->with(array(
			'position'=>array(
				'condition'=>'category = "National"',
				),
			'user'=>array(
				'order'=>'lastname ASC',
				)))
		->findAll();

		$inactiveNatPosDP = new CArrayDataProvider($inactiveAccounts, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('inactivenatpos',array(
			'inactiveNatPosDP'=>$inactiveNatPosDP,
		));
	}

	/**
	 * Manages all models.
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
		$model=Account::model()->findByPk($id);
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

	//used for listing regions in every forms (via AJAX Request)
	public function actionListRegions($area_no)
	{
		$chapters = Chapter::model()
					->findAll(
						array(
							'condition'=> 'area_no ='. $area_no,
							'select' => 'region',
							'distinct' => true,
							)
						);

		foreach($chapters as $chapter)
		{
			echo "<option value ='".$chapter->region."'>".$chapter->region."</option>";
		}

	}

	//used for listing chapters in every forms (via AJAX Request)
	public function actionListChapters($region)
	{
		$chapters = Chapter::model()
					->findAll('region= "'.$region.'"');

		foreach($chapters as $chapter)
		{
			echo "<option value ='".$chapter->id."'>".$chapter->chapter."</option>";
		}
	}

	public function actionViewBusiness($id)
	{
		if($id!=null)
		{
			$account = Account::model()->findByAttributes(array('id'=>$id));
			$connection = Yii::app()->db;
			$transaction = $connection->beginTransaction();
			$userbusiness = UserBusiness::model()->findByPk($id);

			$this->render('viewbusiness',array(
				'account' => $account,
				'userbusiness'=>$userbusiness
			));	
		}
		else
			$this->redirect(array('admin/login'));
	}

	public function actionPendingPresident()
	{
		$presAccount = Account::model()->userAccount()->presAccount()->findAll(array('order'=>'u.lastname ASC'));

		$presAccountDP = new CArrayDataProvider($presAccount, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('pendingpres',array(
			'presAccountDP'=>$presAccountDP,
		));
	}

	public function actionListChapterMembers($chapter)
	{
		$users = array();
		$usersearch = User::model()->userAccount()->isActive()
					->findAll(
						array(
							'condition'=>'chapter_id = '.$chapter,
							)
						);

		foreach($usersearch as $user)
		{
			$account = Account::model()->find('id = '.$user->account_id.' AND status_id = 1');
			
			if($account != null)
				$users[] = $user;
		}

		foreach($users as $user)
		{
			echo "<option value ='".$user->account_id."'>".$user->firstname." ".$user->middlename." ".$user->lastname."</option>";
		}
	}

	public function actionAssignPresident($id)
	{
		$user = User::model()->find('account_id = '.$id);
		$account = Account::model()->findByPk($id);
		$currentposition = UserPositions::model()->find('account_id ='.$id.' AND status_id = 1');
		$newposition = new UserPositions;

		if($user != null && $account != null)
		{	

			$connection = Yii::app()->db;
			$transaction = $connection->beginTransaction();

			try
			{
				$account->status_id = 1;

				if($account->save())
				{
					$user->position_id = 11;

					if($user->save())
					{						
						$currentposition->status_id = 2;			

						if($currentposition->save())
						{
							$newposition->account_id = $id;
							$newposition->position_id = $user->position_id;
							$newposition->chapter_id = $user->chapter_id;
							$newposition->term_year = date('Y');
							$newposition->status_id = 1;

							if($newposition->save())
							{
								$transaction->commit();
								Yii::app()->user->setFlash('success', 'You have successfully assign this account as new Chapter President.');
								$this->redirect(array('resetindex'));
							}
						}
					}
				}
			}
			catch(Exception $e)
			{
				$transaction->rollback();
				Yii::app()->user->setFlash('error', 'An error occured while trying to assign as President! Please try again later.');
			} 
			
		}		
	}


	public function actionResetAccounts()
	{
		$success = 0;
		$error = 0;
		$accountreset = array();
		$accountEmails = array();
		$accounts = Account::model()->findAll("account_type_id = 2");
		$accountreset = $accounts;

		if(isset($_POST['submit']))
		{
			if($_POST['position'] !== '*')
			{
				foreach($accountreset as $key=>$account)
				{
					$user = User::model()->find('account_id = '.$account->id.' AND position_id = '.$_POST['position']);
					
					if($user == null)
						unset($accountreset[$key]);
				}

				$accountreset = array_values($accountreset);
			}

			if($_POST['area_no'] !== '*')
			{
				if($_POST['region'] !== '*')
				{
					if($_POST['chapter'] !== '*')
					{
						foreach($accountreset as $key=>$account)
						{
							$user = User::model()->find('account_id = '.$account->id);

							if($user->chapter_id != $_POST['chapter'])
							{
								unset($accountreset[$key]);
							}
						}

						$accountreset = array_values($accountreset);
					}
					else
					{
						foreach($accountreset as $key=>$account)
						{
							$user = User::model()->find('account_id = '.$account->id);
							$chapter = Chapter::model()->findByPk($user->chapter_id);

							if($chapter->region_id != $_POST['region'])
							{
								unset($accountreset[$key]);
							}
						}

						$accountreset = array_values($accountreset);
					}
				}
				else
				{
					foreach($accountreset as $key=>$account)
					{
						$user = User::model()->find('account_id = '.$account->id);
						$chapter = Chapter::model()->findByPk($user->chapter_id);

						if($chapter->area_no != $_POST['area_no'])
						{
							unset($accountreset[$key]);
						}
					}

					$accountreset = array_values($accountreset);
				}
			}


			foreach($accountreset as $account)
			{
				$account->status_id = 4;
				$accountEmails[] = $account->username;
				
				if($account->save())
					$success++;
				else
					$error++;
			} 

			if($success == 0) {
				Yii::app()->user->setFlash('error', 'An error occured while trying to reset accounts! Please try again later.');
			} else {
				$subject = "JCI Philippines | Your Account Has Been Reset";
				$body = "Your MyJCIP account has been been reset, log-in now and update your position.";
				$send = Account::model()->populateMsgPropMultiple($accountEmails, $subject, $body);

				if($send == 1) {
					Yii::app()->user->setFlash('success', 'Accounts have been reset. SUCCESS = '.$success.' ,  FAILED = '.$error);
				} else {
					Yii::app()->user->setFlash('error', 'An error occured while trying to send notifications. Please try to reset the accounts again.');
				}
			} 
		}

		$this->render('resetform');
	}
}
