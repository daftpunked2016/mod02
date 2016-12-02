<?php

class AccountController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/userPanel';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','register', 'listRegions', 'listChapters', 'listChapterMembers', 'listNotTrainers','listPositions', 'findRegion',  'listSubtype', 'getpk'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update', 'changePassword', 'addBusinessWork', 'listCities' , 
					'addPosition', 'updatePosition', 'deletePosition', 'updateBusiness','deleteBusiness', 'updateWork','deleteWork', 'profile', 
					'viewBusiness', 'listInactiveDelegates','listActiveDelegates', 'activateAccount',
					'deactivateAccount','changeposter', 'changeBusinessLogo', 'viewWork', 'sendEmail'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */

	public function actionView($id)
	{
		$account_id = $id;
		$account = Account::model()->findByPk($account_id);
		
		if($account_id!=null)
		{
			$positions = UserPositions::model()->findAll(array('condition'=>'account_id = '.$account_id, 'order'=>'term_year desc'));
			$positionsDP = new CArrayDataProvider($positions, array(
				'pagination' => array(
					'pageSize' => 5
				)
		));
			$user = User::model()->find('account_id ='.$account_id);
			$this->render('view',array(
					'account' => $account,
					'user' => $user,
					'positionsDP' => $positionsDP,
				));	

		}
		else
			$this->redirect(array('account/index'));
	}

	//Account Registration (Full Step)
	public function actionRegister()
	{
		$this->layout='//layouts/login';
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
			$image = $fileupload->filename = CUploadedFile::getInstance($user,'user_avatar');
			$user->user_avatar = $image;
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

						//FILE UPLOAD RENAMING
						$name       = $_FILES['User']['name']['user_avatar'];
						$ext        = pathinfo($name, PATHINFO_EXTENSION);
						$currentDate = date('Ymdhis');
						$newName = 'JCIPH-UA-'.$currentDate.''.$account->id.'.'.$ext;

						//FILE TRANSFER TO SERVER
						$fileupload->filename->saveAs('user_avatars/'.$newName);
						$fileupload->filename = $newName;
						
						if ($fileupload->save())
						{ 
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
									$userposition->status_id = 1;
									$userposition->term_year = date("Y");
									
									if($userposition->position_id === '8')
										$userposition->avp_area = $_POST['area_no'];
									if($userposition->position_id === '9')
										$userposition->rvp_reg = $_POST['region'];
									if($userposition->position_id === '10')
										$userposition->nc_project = $_POST['reg-nc_project'];

									if($userposition->save())
									{
										$transaction->commit();

										if($userposition->position_id === '11')
											Yii::app()->user->setFlash('success','You have successfully registered an account! Please wait for the email of approval by the JCI Headquarters.');
										else
											Yii::app()->user->setFlash('success','You have successfully registered an account! Please wait for the email of approval by your chapter president.');
										
										//EMAIL NOTIFICATIONS
										if($user->position_id == 11) //for president -> send to hq
										{
											$hqAccounts = Account::model()->findAll("account_type_id = 1 AND status_id = 1");

											foreach($hqAccounts as $account)
											{
												$subject = "JCI Philippines HQ | New Chapter President Has Been Registered";
												$body = "A new JCI Chapter President has successfully registered an account. 
												<b>Before activating the account, please verify first if the new account has a valid Senator Number and/or President of JCI Philippines</b>
												You can now log-in and use your HQ account by clicking this link : <a href='http://jci.org.ph/mod02/index.php/admin/'>JCI Admin Log-in Page</a> <br /><br />
												Please always check your e-mail and keep yourself updated. Thank you!<br /><br />
												JCI Philippines";
												$send =  Account::model()->populateMsgProperties($account->id, $subject, $body);
											}
										}
										else //for non-pres->send to chapter pres
										{
											$chapterPres = User::model()->isActive()->find('chapter_id = '.$user->chapter_id.' AND position_id = 11');

											if($chapterPres != null)
											{
												$subject = "JCI Philippines | New Account Has Been Registered";
												$body = "A new JCI member from your chapter had successfully registered an account. 
												<b>Please verify first if the new account has a valid information and/or an active member of your Chapter and the JCI Philippines.</b>
												You can now log-in and use your account by clicking this link : <a href='http://jci.org.ph/mod02/index.php/site/login'>JCI Log-in Page</a> <br /><br />
												Please always check your e-mail and keep yourself updated for all of JCI Philippines News & Latest Events. Thank you!<br /><br />
												JCI Philippines";
												$send =  Account::model()->populateMsgProperties($chapterPres->account_id, $subject, $body); 
											}
										} 

										echo json_encode(1);
										exit;
									}
									else
									{
										$errors = $userposition->getErrors();
										echo json_encode($errors); 
										exit; 
									}
								}
							}
						} else {
							$errors = $fileupload->getErrors();
							echo json_encode($errors); 
							exit; 
						}
					}
				}
				catch (Exception $e)
				{
					print_r($e);exit;
					$transaction->rollback();
					Yii::app()->user->setFlash('error', 'An error occured while trying to register an account! Please try again later.');
				}
			}
			else
			{
				$errors = $account->getErrors();
				$errors += $user->getErrors();
				echo json_encode($errors); 
				exit;
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
	public function actionUpdate()
	{
		$this->verifyAccount(); //verify account status

		$id = Yii::app()->user->id;
		$account=	Account::model()->findByPk($id);
		$user = $account->user;
		
		
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
										Yii::app()->user->setFlash('success','You have successfully updated your account!');
										$this->redirect(array('account/profile'));
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
			$this->redirect(array('site/login'));
			//throw new CHttpException(404,'The requested page does not exist.');
	}

	
	public function actionChangePassword()
	{
		$this->verifyAccount(); //verify account status

		$account_id = Yii::app()->user->id;
		
		if($account_id!=null)
		{
			$account = Account::model()->findByAttributes(array('id'=>$account_id));
			$account->setScenario('changePwd');
			
			if(isset($_POST['Account']))
			{
				$account->attributes = $_POST['Account'];
				$valid = $account->validate();
				
					if($valid)
						{
							$account->salt=Account::model()->generateSalt();
							$account->password=Account::model()->hashPassword($account->new_password,$account->salt);

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
	
			$this->render('changepassword',array(
					'account' => $account,
				));	
		}
		else
			$this->redirect(array('site/login'));
			//throw new CHttpException(404,'The requested page does not exist.');
	} 	

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->verifyAccount(); //verify account status

		$account_id = Yii::app()->user->id;
		$page = "home";
		
		if($account_id!=null)
		{
			$account = Account::model()->findByPk($account_id);
			$user = User::model()->find('account_id ='.$account_id);
			$this->render('index',array(
					'account' => $account,
					'user' => $user,
					'page'=>$page,
				));	
		}
		else
			$this->redirect(array('site/login'));
			//throw new CHttpException(404,'The requested page does not exist.');
	}


	public function actionProfile()
	{
		$this->verifyAccount(); //verify account status

		$account_id = Yii::app()->user->id;
		$page ="profile";
		
		if($account_id!=null)
		{
			$account = Account::model()->findByPk($account_id);
			$positions = UserPositions::model()->findAll(array('condition'=>'account_id = '.$account_id, 'order'=>'term_year desc')); 
			$positionsDP = new CArrayDataProvider($positions, array(
				'pagination' => array(
					'pageSize' => 5
				)
		));
			$user = User::model()->find('account_id ='.$account_id);
			$this->render('profile',array(
					'account' => $account,
					'user' => $user,
					'positionsDP' => $positionsDP,
					'positions' => $positions,
					'page'=>$page,
				));	

		}
		else
			$this->redirect(array('site/login'));
			//throw new CHttpException(404,'The requested page does not exist.');
	}


	public function actionChangePoster()
	{
		$this->verifyAccount(); //verify account status
		
		$account_id = Yii::app()->user->id;
		$user = User::model()->find('account_id ='.$account_id);
		if($account_id!=null)
		{
			if(isset($_FILES['avatar']))
			{
				$fileupload = new Fileupload;
				$filerelation = new Filerelation;

				//FILE UPLOAD RENAMING
				$name       = $_FILES['avatar']['name'];
				$ext        = pathinfo($name, PATHINFO_EXTENSION);
				$currentDate = date('Ymdhis');
				$newName = 'JCIPH-UA-'.$currentDate.''.$account_id.'.'.$ext;

				$fileupload->poster_id= $account_id;			
				$avatar =  $newName;
				$fileupload->filename = $avatar;
				$target_path = "user_avatars/";
				$target_path = $target_path . $avatar;
					
				$connection = Yii::app()->db;
				$transaction = $connection->beginTransaction();
							
				try
					{
						if ($fileupload->save())
						{
							
							$user->user_avatar = $fileupload->id;
							move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_path);
							
							if ($user->save())
							{
								$filerelation->fileupload_id = $fileupload->id;
								$filerelation->relationship_id = 1;
																	 
								if ($filerelation->save())
								{
									$transaction->commit();
									Yii::app()->user->setFlash('success', 'You have successfully changed your profile avatar.');
									$this->redirect('profile');
								}
								else
									print_r($filerelation->getErrors());exit;	
							}
							else
								print_r($user->getErrors());exit;
						}
						else
							print_r($fileupload->getErrors());exit;
					}
				catch (Exception $e)
					{
						$transaction->rollback();
						Yii::app()->user->setFlash('error', 'An error occured while trying to update the account! Please try again later.');
						$this->redirect('profile');
					} 
			}
			else
				$this->redirect(array('site/login'));
		}
		else
			$this->redirect(array('site/login'));
	}

	public function actionChangeBusinessLogo($id)
	{
		$this->verifyAccount(); //verify account status

		$account_id = Yii::app()->user->id;
		$userBusiness = UserBusiness::model()->findByPk($id);
		
		if($userBusiness!=null)
		{
			if(isset($_FILES['avatar']))
			{
				$fileupload = new Fileupload;
				$filerelation = new Filerelation;

				//FILE UPLOAD RENAMING
				$name       = $_FILES['avatar']['name'];
				$ext        = pathinfo($name, PATHINFO_EXTENSION);
				$currentDate = date('Ymdhis');
				$newName = 'JCIPH-BA-'.$currentDate.''.$account_id.'.'.$ext;

				$fileupload->poster_id= $account_id;			
				$avatar =  $newName;
				$fileupload->filename = $avatar;
				$target_path = "business_avatars/";
				$target_path = $target_path . $avatar;
					
				$connection = Yii::app()->db;
				$transaction = $connection->beginTransaction();
							
				try
					{
						if ($fileupload->save())
						{
							
							$userBusiness->business_avatar = $fileupload->id;
							move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_path);
							
							if ($userBusiness->save())
							{
								$filerelation->fileupload_id = $fileupload->id;
								$filerelation->relationship_id = 2; //means business logo
																	 
								if ($filerelation->save())
								{
									$transaction->commit();
									Yii::app()->user->setFlash('success', 'You have successfully updated one of your business profile.');
									$this->redirect(array('account/profile'));
								}
								else
									print_r($filerelation->getErrors());exit;	
							}
							else
								print_r($user->getErrors());exit;
						}
						else
							print_r($fileupload->getErrors());exit;
					}
				catch (Exception $e)
					{
						$transaction->rollback();
						Yii::app()->user->setFlash('error', 'An error occured while trying to update the account! Please try again later.');
						$this->redirect('profile');
					} 
			}
			else
				$this->redirect(array('site/login'));
		}
		else
			$this->redirect(array('site/login'));
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
		header('Access-Control-Allow-Origin: *');  
		$regions = AreaRegion::model()
					->findAll(
						array(
							'condition'=> 'area_no ='. $area_no,
							)
						);

		foreach($regions as $region)
		{
			echo "<option value ='".$region->id."'>".$region->region."</option>";
		}
	}

	//used for listing chapters in every forms (via AJAX Request)
	public function actionListChapters($region)
	{	
		header('Access-Control-Allow-Origin: *'); 
		$chapters = Chapter::model()
					->findAll(array('condition' => 'region_id= "'.$region.'"', 'order'=>'chapter'));

		foreach($chapters as $chapter)
		{
			echo "<option value ='".$chapter->id."'>".$chapter->chapter."</option>";
		}
	}

	public function actionListChapterMembers($chapter)
	{
		header('Access-Control-Allow-Origin: *');
		$users = array();
		$usersearch = User::model()->userAccount()->isActive()
					->findAll(
						array(
							'condition'=>'chapter_id = '.$chapter,
							'order'=>'lastname ASC'
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
			echo "<option value ='".$user->account_id."' data-username='".$user->account->username."' data-fn='".$user->firstname."' data-ln='".$user->lastname."' data-mn='".$user->middlename."' >".strtoupper($user->lastname).", ".strtoupper($user->firstname)." ".strtoupper($user->middlename)."</option>";
		}
	}

	public function actionListNotTrainers($chapter, $type)
	{
		header('Access-Control-Allow-Origin: *');
		$users = array();
		$usersearch = User::model()->userAccount()->isActive()
					->findAll(
						array(
							'condition'=>'chapter_id = :cid AND training_position_id != :type',
							'params'=>array(
								':cid'=>$chapter,
								':type'=>$type,
							))
						);

		foreach($usersearch as $user)
		{
			$account = Account::model()->find('id = '.$user->account_id.' AND status_id = 1');
			
			if($account != null)
				$users[] = $user;
		}

		foreach($users as $user)
		{
			echo "<option value ='".$user->account_id."' data-username='".$user->account->username."' data-fn='".$user->firstname."' data-ln='".$user->lastname."' data-mn='".$user->middlename."' >".$user->firstname." ".$user->middlename." ".$user->lastname."</option>";
		}
	}

	//used for listing business or work subtype in every forms (via AJAX Request)
	public function actionListSubtype($category)
	{
		$subtypes = BusinessSubtype::model()
					->findAll('type= "'.$category.'"');

		foreach($subtypes as $subtype)
		{
			echo "<option value ='".$subtype->id."'>".$subtype->subtype."</option>";
		}
	}

	//used for listing cities in every forms (via AJAX Request)
	public function actionListCities($province)
	{
		$cities = Cities::model()
					->findAll('province_id= "'.$province.'"');

		foreach($cities as $city)
		{
			echo "<option value ='".$city->id."'>".$city->name."</option>";
		}
	}

	//used for listing positions in every forms (via AJAX Request)
	public function actionListPositions($category)
	{
		$positions = Position::model()
					->findAll('category= "'.$category.'"');

		foreach($positions as $position)
		{
			echo "<option value ='".$position->id."'>".$position->position."</option>";
		}
	}



	public function actionAddBusinessWork()
	{
		$this->verifyAccount(); //verify account status

		$account_id = Yii::app()->user->id;
		
		if($account_id!=null)
		{
			$account = Account::model()->findByAttributes(array('id'=>$account_id));
			$connection = Yii::app()->db;
			$transaction = $connection->beginTransaction();
			$logo = '';
			
			if(isset($_POST['business-submit']))
			{
				$userbusiness = new UserBusiness;
				$userbusiness->business_cat_id = $_POST['business-category'];
				$userbusiness->business_type_id = $_POST['business-subtype'];
				$userbusiness->business_name = $_POST['business-name'];
				$userbusiness->description = $_POST['business-description'];
				$userbusiness->address = $_POST['business-address'];
				$userbusiness->street = $_POST['business-street'];
				$userbusiness->province_id = $_POST['business-province'];
				$userbusiness->city_id = $_POST['business-city'];
				$userbusiness->contact_no = $_POST['business-contact'];
				$userbusiness->operating_hours = $_POST['business-hours'];
				$userbusiness->account_id = $account_id;

				$valid = $userbusiness->validate();

				if($valid)
				{
					try
					{
						//if the user uploads a business logo 
						if ($_FILES['business-logo']['name'] != null) {
							$fileupload = new Fileupload;
							$filerelation = new Filerelation;
							

							//FILE UPLOAD RENAMING
							$name       = $_FILES['business-logo']['name'];
							$ext        = pathinfo($name, PATHINFO_EXTENSION);
							$currentDate = date('Ymdhis');
							$newName = 'JCIPH-BA-'.$currentDate.''.$account_id.'.'.$ext;
							$logo =  $newName;
							$fileupload->poster_id = $account_id;
							$fileupload->filename = $logo;
							$target_path = "business_avatars/";
							$target_path = $target_path . $logo;


							if ($fileupload->save())
							{
								move_uploaded_file($_FILES['business-logo']['tmp_name'], $target_path);
								$userbusiness->business_avatar = $fileupload->id;
								
								$filerelation->fileupload_id = $fileupload->id;
								$filerelation->relationship_id = 2; //2 means Business Logo
								
								$filerelation->save();
							}

						}

						if($userbusiness->save(false))
							{
								$transaction->commit();
								Yii::app()->user->setFlash('success','You have successfully added a new Business!');
								$this->redirect(array('account/profile'));
							}


					}
					catch (Exception $e)
					{
						$transaction->rollback();
						Yii::app()->user->setFlash('error', 'An error occured while trying to update the account! Please try again later.');
					} 
				}
				else
					json_encode($userbusiness->getErrors()); 
			}

			else if(isset($_POST['work-submit']))
			{
				$userwork = new UserWork;
				$userwork->work_type_id = $_POST['work-subtype'];
				$userwork->company_name = $_POST['work-company'];
				$userwork->position = $_POST['work-position'];
				$userwork->address = $_POST['work-address'];
				$userwork->street = $_POST['work-street'];
				$userwork->province_id = $_POST['work-province'];
				$userwork->city_id = $_POST['work-city'];
				$userwork->account_id = $account_id;

				$valid = $userwork->validate();

				if($valid)
				{
					try
					{
						if($userwork->save(false))
							{
								$transaction->commit();
								Yii::app()->user->setFlash('success','You have successfully added a new Work!');
								$this->redirect(array('account/profile'));
							}
					}
					catch (Exception $e)
					{
						$transaction->rollback();
						Yii::app()->user->setFlash('error', 'An error occured while trying to update the account! Please try again later.');
					}
				}
				else
					print_r($userwork->getErrors());exit;

			}
	
			$this->render('addbusinesswork',array(
					'account' => $account,
				));	
		}
		else
			$this->redirect(array('site/login'));
			//throw new CHttpException(404,'The requested page does not exist.');

	}


	public function actionUpdateBusiness($id)
	{
		$this->verifyAccount(); //verify account status

		$account_id = Yii::app()->user->id;
		$userbusiness = UserBusiness::model()->find('id = '.$id.' AND account_id ='.$account_id);
		
		if($userbusiness!=null)
		{
			$account = Account::model()->findByAttributes(array('id'=>$account_id));
			$connection = Yii::app()->db;
			$transaction = $connection->beginTransaction();
			
			if(isset($_POST['UserBusiness']))
			{
				$userbusiness->attributes = $_POST['UserBusiness'];
				$valid = $userbusiness->validate();
				
				if ($valid)
				{
					try
					{
						if($userbusiness->save())
							{
								$transaction->commit();
								Yii::app()->user->setFlash('success','You have successfully updated a business in your profile.');
								$this->redirect(array('account/profile'));
							}
					}
					catch (Exception $e)
					{
						$transaction->rollback();
						Yii::app()->user->setFlash('error', 'An error occured while trying to update a business! Please try again later.');
					}
				}
			}

			$this->render('updatebusiness',array(
				'account' => $account,
				'userbusiness'=>$userbusiness
			));	
		}
		else
			$this->redirect(array('site/login'));
	}

	public function actionDeleteBusiness($id)
	{
		$account_id = Yii::app()->user->id;
		$userbusiness = UserBusiness::model()->find('id = '.$id.' AND account_id ='.$account_id);
		
		if($userbusiness!=null)
		{
			$account = Account::model()->findByAttributes(array('id'=>$account_id));
			$connection = Yii::app()->db;
			$transaction = $connection->beginTransaction();
			
			try
			{
				if($userbusiness->delete())
					{
						$transaction->commit();
						Yii::app()->user->setFlash('success','You have successfully deleted a business in your profile.');
					}
			}
			catch (Exception $e)
			{
				$transaction->rollback();
				Yii::app()->user->setFlash('error', 'An error occured while trying to delete a business! Please try again later.');
			}

			$this->redirect(array('account/profile'));
				
		}
		else
			$this->redirect(array('site/login'));
	}

	public function actionViewBusiness($id)
	{
		$this->verifyAccount(); //verify account status

		$account_id = Yii::app()->user->id;
		
		if($account_id!=null)
		{
			$account = Account::model()->findByAttributes(array('id'=>$account_id));
			$connection = Yii::app()->db;
			$transaction = $connection->beginTransaction();
			$userbusiness = UserBusiness::model()->findByPk($id);

			$this->render('viewbusiness',array(
				'account' => $account,
				'userbusiness'=>$userbusiness
			));	
		}
		else
			$this->redirect(array('site/login'));
	}


	public function actionUpdateWork($id)
	{
		$this->verifyAccount(); //verify account status

		$account_id = Yii::app()->user->id;
		$userwork = UserWork::model()->find('id = '.$id.' AND account_id ='.$account_id);
		
		if($userwork!=null)
		{
			$account = Account::model()->findByAttributes(array('id'=>$account_id));
			$connection = Yii::app()->db;
			$transaction = $connection->beginTransaction();
			
			
			if(isset($_POST['UserWork']))
			{
				$userwork->attributes = $_POST['UserWork'];
				$valid = $userwork->validate();
				
				if ($valid)
				{
					try
					{
						if($userwork->save())
							{
								$transaction->commit();
								Yii::app()->user->setFlash('success','You have successfully updated a work information in your profile.');
								$this->redirect(array('account/profile'));
							}
					}
					catch (Exception $e)
					{
						$transaction->rollback();
						Yii::app()->user->setFlash('error', 'An error occured while trying to update a work information! Please try again later.');
					}
				}
				else
				{
					print_r($userwork->getErrors());exit;
				}
			}


			$this->render('updatework',array(
				'account' => $account,
				'userwork'=>$userwork
			));	
		}
		else
			$this->redirect(array('site/login'));
	}

	public function actionDeleteWork($id)
	{
		$account_id = Yii::app()->user->id;
		$userwork = UserWork::model()->find('id = '.$id.' AND account_id ='.$account_id);
		
		if($userwork!=null)
		{
			$account = Account::model()->findByAttributes(array('id'=>$account_id));
			$connection = Yii::app()->db;
			$transaction = $connection->beginTransaction();
			
			try
			{
				if($userwork->delete())
					{
						$transaction->commit();
						Yii::app()->user->setFlash('success','You have successfully deleted a work information in your profile.');
					}
			}
			catch (Exception $e)
			{
				$transaction->rollback();
				Yii::app()->user->setFlash('error', 'An error occured while trying to delete a work information! Please try again later.');
			}

			$this->redirect(array('account/profile'));

		}
		else
			$this->redirect(array('site/login'));
	}

	public function actionViewWork($id)
	{
		$account_id = Yii::app()->user->id;
		
		if($account_id!=null)
		{
			$account = Account::model()->findByAttributes(array('id'=>$account_id));
			$connection = Yii::app()->db;
			$transaction = $connection->beginTransaction();
			$userwork= UserWork::model()->findByPk($id);

			$this->render('viewwork',array(
				'account' => $account,
				'userwork'=>$userwork
			));	
		}
		else
			$this->redirect(array('site/login'));
	}


	public function actionAddPosition()
	{
		$this->verifyAccount(); //verify account status

		$account_id = Yii::app()->user->id;
		
		if($account_id!=null)
		{
			$account = Account::model()->findByAttributes(array('id'=>$account_id));
			$connection = Yii::app()->db;
			$transaction = $connection->beginTransaction();
			$userposition = new UserPositions;
			
			if(isset($_POST['UserPositions']))
			{
				$userposition->attributes = $_POST['UserPositions'];
				$userposition->account_id = $account_id;
				$userposition->status_id = 2;
				
				$valid = $userposition->validate();
				
				if ($valid)
				{
					try
					{
						if($userposition->save())
							{
								$transaction->commit();
								Yii::app()->user->setFlash('success','You have successfully added a new position for your JCI membership history!');
								$this->redirect(array('account/profile'));
							}
					}
					catch (Exception $e)
					{
						$transaction->rollback();
						Yii::app()->user->setFlash('error', 'An error occured while trying to add position! Please try again later.');
					}
				}
			}

			$this->render('addnewposition',array(
				'account' => $account,
				'userposition'=>$userposition
			));	
		}
		else
			$this->redirect(array('site/login'));

	}

	public function actionUpdatePosition($id)
	{
		$this->verifyAccount(); //verify account status

		$account_id = Yii::app()->user->id;
		$userposition = UserPositions::model()->find('id = '.$id.' AND account_id ='.$account_id);

		if($userposition!=null)
		{
			if($userposition->status_id == 1)
			{
				Yii::app()->user->setFlash('error','Updating your current position will need to be verified by the Chapter President or JCI Headquarters first. This will set your account to INACTIVE for the meantime.');
			}

			$account = Account::model()->findByAttributes(array('id'=>$account_id));
			$user = User::model()->find('account_id = '.$account_id);
			$connection = Yii::app()->db;
			$transaction = $connection->beginTransaction();
			
			if(isset($_POST['UserPositions']))
			{
				$userposition->attributes = $_POST['UserPositions'];
				$valid = $userposition->validate();
				
				if ($valid)
				{
					try
					{
						if($userposition->save())
							{
								if($userposition->status_id == 1)
								{
									$user->position_id = $userposition->position_id;
									$account->status_id = 2;
									$user->save();
									$account->save();
								}

								$transaction->commit();

								if($userposition->status_id == 1)
								{
									Yii::app()->user->logout();
									Yii::app()->session->open();
									Yii::app()->user->setFlash('success','You have successfully updated your position. Please wait until your Chapter President or JCI Headquarters verified the update for your position.');
									$this->redirect(array('site/login'));  
								}
								else
								{
									Yii::app()->user->setFlash('success','You have successfully updated a position in your JCI membership history!');
									$this->redirect(array('account/profile'));
								}

							}
					}
					catch (Exception $e)
					{
						$transaction->rollback();
						Yii::app()->user->setFlash('error', 'An error occured while trying to update position! Please try again later.');
					}
				}
			}

			$this->render('updateposition',array(
				'account' => $account,
				'userposition'=>$userposition
			));	
		}
		else
			$this->redirect(array('site/login'));

	}

	public function actionDeletePosition($id)
	{
		$account_id = Yii::app()->user->id;
		$userposition = UserPositions::model()->find('id = '.$id.' AND account_id ='.$account_id.' AND status_id = 2');

		if($userposition != null)
		{
			$account = Account::model()->findByAttributes(array('id'=>$account_id));
			$connection = Yii::app()->db;
			$transaction = $connection->beginTransaction();
			
			try
			{
				if($userposition->delete())
					{
						$transaction->commit();
						Yii::app()->user->setFlash('success','You have successfully deleted a position in your JCI membership history!');
					}
			}
			catch (Exception $e)
			{
				$transaction->rollback();
				Yii::app()->user->setFlash('error', 'An error occured while trying to delete position! Please try again later.');
			}
			
			$this->redirect(array('account/profile'));
		}
		else
			$this->redirect(array('site/login'));

	}

	public function actionListInactiveDelegates()
	{
		$this->verifyAccount(); //verify account status

		$account_id = Yii::app()->user->id;
		
		if($account_id!=null)
		{
			$account = Account::model()->findByAttributes(array('id'=>$account_id));
			$restricted_user = User::model()->findByAttributes(array('account_id'=>$account_id));
			
			if($restricted_user->position_id == 11 || $restricted_user->position_id == 13)
			{
				$inactiveListDelegates = array();
				
				$searchOption = 'chapter_id = '.$restricted_user->chapter_id;

				if(isset($_GET['ageType']) OR isset($_GET['genderPres']) OR isset($_GET['titlePres']) OR isset($_GET['positionPres'])) 
				{		
					/*if($_GET['ageType'] !== '')
					{
						$searchOption = $searchOption.' AND business_name LIKE "%'.$_GET['businessName'].'%"';
					} */ 
					if($_GET['genderPres'] !== '')	 
					{
						$searchOption =  $searchOption.' AND gender = '.$_GET['genderPres'];
					}
					if($_GET['titlePres'] !== '')	
					{
						$searchOption =  $searchOption.' AND title = '.$_GET['titlePres'];
					}
					if($_GET['positionPres'] !== '')	
					{
						$searchOption =  $searchOption.' AND position_id = '.$_GET['positionPres'];
					}
				}

				$accounts = Account::model()->findAll(array(
					'condition'=>'status_id = 2 AND account_type_id= 2',
					'order'=>'id desc',
					));

				
				foreach($accounts as $account)
				{
					if(isset($_GET['search']))
						$user = User::model()->find(array('condition'=>'account_id = '.$account->id.' AND '.$searchOption));
					else
						$user = User::model()->find(array('condition'=>'account_id = '.$account->id.' AND chapter_id = '.$restricted_user->chapter_id));

					if($user!=null)
						$inactiveListDelegates[] = $user;
				}
				
				$inactiveListDelegatesDP = new CArrayDataProvider($inactiveListDelegates, array(
					'pagination' => array(
						'pageSize' => 10,
					)
				));

				$this->render('listinactivedelegates',array(
					'account' => $account,
					'user'=>$restricted_user,
					'inactiveListDelegates' => $inactiveListDelegates,
					'inactiveListDelegatesDP' => $inactiveListDelegatesDP,
				));	
			}
			else
			{
				$this->redirect('index');
			}
		}
		else
			$this->redirect(array('site/login'));

	}

	public function actionListActiveDelegates()
	{
		$this->verifyAccount(); //verify account status

		$account_id = Yii::app()->user->id;
		
		if($account_id!=null)
		{
			$account = Account::model()->findByAttributes(array('id'=>$account_id));
			$restricted_user = User::model()->findByAttributes(array('account_id'=>$account_id));

			if($restricted_user->position_id == 11 || $restricted_user->position_id == 13)
			{
				$searchOption = 'chapter_id = '.$restricted_user->chapter_id;

				if(isset($_GET['ageType']) OR isset($_GET['genderPres']) OR isset($_GET['titlePres']) OR isset($_GET['positionPres'])) 
				{		
					/*if($_GET['ageType'] !== '')
					{
						$searchOption = $searchOption.' AND business_name LIKE "%'.$_GET['businessName'].'%"';
					} */
					if($_GET['genderPres'] !== '')	
					{
						$searchOption =  $searchOption.' AND gender = '.$_GET['genderPres'];
					}
					if($_GET['titlePres'] !== '')	
					{
						$searchOption =  $searchOption.' AND title = '.$_GET['titlePres'];
					}
					if($_GET['positionPres'] !== '')	
					{
						$searchOption =  $searchOption.' AND position_id = '.$_GET['positionPres'];
					}
				}

				$activeListDelegates = array();
				$accounts = Account::model()->findAll(array(
					'condition'=>'status_id = 1 AND account_type_id= 2',
					'order'=>'id desc',
					));

				foreach($accounts as $account)
				{
					if(isset($_GET['search']))
						$user = User::model()->find(array('condition'=>'account_id = '.$account->id.' AND '.$searchOption));
					else
						$user = User::model()->find(array('condition'=>'account_id = '.$account->id.' AND chapter_id = '.$restricted_user->chapter_id));

					if($user!=null && $user->account_id != $account_id)
						$activeListDelegates[] = $user;
				}
				
				$activeListDelegatesDP = new CArrayDataProvider($activeListDelegates, array(
					'pagination' => array(
						'pageSize' => 10
					)
				));

				$this->render('listactivedelegates',array(
					'account' => $account,
					'user'=>$restricted_user,
					'activeListDelegates' => $activeListDelegates,
					'activeListDelegatesDP' => $activeListDelegatesDP,
				));	
			}
			else
			{
				$this->redirect('index');
			}
		}
		else
			$this->redirect(array('site/login'));

	}

	public function actionActivateAccount($id)
	{
		$this->verifyAccount(); //verify account status

		$account_id = Yii::app()->user->id;
		$accountRestricted = Account::model()->findByPk($account_id);
		$userRestricted = User::model()->find('account_id = '.$account_id);
		$account =	Account::model()->findByPk($id);	
		
		if($userRestricted->position_id == 11 || $userRestricted->position_id == 13)
		{
			if($id!=null)
			{
				$user= User::model()->find('account_id = '.$id);
				
				if($user->title == 1 || $user->position->category == "National") //if JCI SEN
					$account->status_id = 3;
				else //if MEMBER
					$account->status_id = 1;

				$connection = Yii::app()->db;
				$transaction = $connection->beginTransaction();
				
				try
				{
					if($account->save(false))
						{
							$transaction->commit();
							$send = 1;
							
							//Email formatting
							$subject = "JCI Philippines | Account Successfully Verified";

							if($user->title == 1 || $user->position->category == "National")
							{
								$body = "Your account has been successfully verified and activated by your JCI Chapter President. 
								However, your account will still be inactive for verification of JCI Headquarters(Administrator) regarding your position and <b>JCI SENATOR NUMBER</b><i>(if JCI Sen)</i>.<br /><br />
								Please always check your e-mail and keep yourself updated for all of JCI Philippines News & Latest Events. Thank you!<br /><br />
								JCI Philippines";
								Account::model()->newSenNotif();
							}
							else
							{
								$body = "Your account has been successfully verified and activated by your JCI Chapter President. 
								You can now log-in and use your account by clicking this link : <a href='http://jci.org.ph/mod02/index.php/site/login'>JCI Log-in Page</a> <br /><br />
								Please always check your e-mail and keep yourself updated for all of JCI Philippines News & Latest Events. Thank you!<br /><br />
								JCI Philippines";
							}

							$send = Account::model()->populateMsgProperties($account->id, $subject, $body);

							if($send == 1)
								Yii::app()->user->setFlash('success','You have successfully activated an account!');
							else
								Yii::app()->user->setFlash('success','You have successfully activated an account! But have failed sending the e-mail notification.');
							
							$this->redirect(array('account/listInactiveDelegates'));
						}
				}
				catch (Exception $e)
				{
					$transaction->rollback();
					Yii::app()->user->setFlash('error', 'An error occured while trying to update the account! Please try again later.');
				} 
			}
			else
			{
				Yii::app()->user->setFlash('error', 'Invalid Account!');
				$this->redirect(array('account/listInactiveDelegates'));
			}
		}
		else
			$this->redirect(array('site/login'));
	}

	public function actionDeactivateAccount($id)
	{
		$this->verifyAccount(); //verify account status

		$account_id = Yii::app()->user->id;
		$accountRestricted = Account::model()->findByPk($account_id);
		$userRestricted = User::model()->find('account_id = '.$account_id);
		$account=	Account::model()->findByPk($id);	

		if($userRestricted->position_id == 11 || $userRestricted->position_id == 13)
		{
			if($id!=null)
			{
				$account->status_id = 2;
				$connection = Yii::app()->db;
				$transaction = $connection->beginTransaction();
				
				try
				{
					if($account->save(false))
						{
							$transaction->commit();
							Yii::app()->user->setFlash('success','You have successfully deactivated an account and return it to inactive accounts list!');
							$this->redirect(array('account/listActiveDelegates'));
						}
				}
				catch (Exception $e)
				{
					$transaction->rollback();
					Yii::app()->user->setFlash('error', 'An error occured while trying to update the account! Please try again later.');
				} 
			}
			else
			{
				Yii::app()->user->setFlash('error', 'Invalid Account!');
				$this->redirect(array('account/listActiveDelegates'));
			}
		}
		else
			$this->redirect(array('site/login'));

	}

	public function actionFindRegion($id)
	{
		$areaRegion =	AreaRegion::model()->findByPk($id);	
		echo $areaRegion->region;
	}

	/**
	* @param $k = hashed username,account_id,salt
	* @param $a = account_id
	* Get current account password
	*/
	public function actionGetPK($k, $a)
	{
		$account = Account::model()->findByPk($a);

		if($account != null) {
			if(md5($account->username.$account->id.$account->salt) === $k) {
				echo $account->password;
				exit;
			}
		} 

		return null;
	}

	public function verifyAccount()
	{
	 	$account_id = Yii::app()->user->id;
	 	$account = Account::model()->findByPk($account_id);

	 	if($account != null)
	 	{
	 		if($account->status_id == 2 || $account->status_id == 3)
	 		{
	 			Yii::app()->user->logout();
				Yii::app()->session->open();
				Yii::app()->user->setFlash('error','Account Inactive!');
				$this->redirect(array('site/login'));  

	 		}
	 		else if($account->status_id == 4)
	 			$this->redirect(array('site/resetposition'));
	 	}
	 	else
	 		$this->redirect(array('site/login'));

	}
}
