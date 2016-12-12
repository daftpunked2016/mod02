<?php

class SiteController extends Controller
{
	//public $layout = '/layouts/userPanel';
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->redirect(array('site/login'));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
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

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{	
		$this->layout ='login';
		
		if(Yii::app()->user->id === null)
		{
			$model=new LoginForm;

			// if it is ajax validation request
			if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
			{
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}

			// collect user input data
			if(isset($_POST['LoginForm']))
			{
				$model->attributes=$_POST['LoginForm'];
				// validate user input and redirect to the previous page if valid
				if($model->validate() && $model->login())
					$this->redirect(array('/account/index'));
			}
			// display the login form
			$this->render('login',array('model'=>$model));
		}
		else
			$this->redirect(array('/account/index'));
	}

	public function actionVerifyLogin()
	{
		header('Access-Control-Allow-Origin: *'); 
		$login = new LoginForm;
		$response = array();
		$response['res_type'] = false; //false

		if(isset($_POST['u']))
		{
			$login->username = $_POST['u'];
			$login->password = $_POST['p'];
			$validate = $login->validateOutside();

			switch($validate) {
				case 1:
					$username=strtolower($login->username);
	   				$account = Account::model()->find('LOWER(username) = :username AND (account_type_id = 2 OR account_type_id = 3)', array(':username'=>$username));
					$k = md5($account->id.$account->salt.$account->user->lastname.$account->user->id);
					$b = $account->id; 
					$response['res_type'] = true;
					$response['res_msg'] = 'Account Verified Successfully!';
					$response['ak'] = $b;
					$response['res_redirect_url'] = "http://jci.org.ph/jcipadvantage.com/mod04/index.php/site/signup?k={$k}&b={$b}&t=2";
					break;
				case 2:
				case 3:
					$response['res_msg'] = 'Verification Failed! Account is inactive state, please wait for your account to be verified first.';
					break;
				case 4:
					$response['res_msg'] = 'Verification Failed! Account has been reset, please configure your account first.';
					break;
				case 5:
					$response['res_msg'] = 'Verification Failed! Email or password is invalid.';
					break;
				case 6:
					$response['res_msg'] = 'Verification Failed! Account or data invalid.';
					break;

			}
		}

		echo json_encode($response); exit;
	}	

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		Yii::app()->session->open();
		Yii::app()->user->setFlash('success','You have successfully logged out your account.');
		$this->redirect('login');
	}


	public function actionForgotPassword()
	{
		$this->layout ='login';
		
		if(isset($_POST['reset']))
		{
			$username = $_POST['email'];

			if($username !== '')
			{
				$checkAccount = Account::model()->find('username = "'.$username.'"');
				
				if($checkAccount != null)
				{
					$user = User::model()->find('account_id = '.$checkAccount->id);
					$updateDate = strtotime($checkAccount->date_updated);
					$vlCode = $checkAccount->id.$user->id.$updateDate;
					$hashedVlCode = sha1($vlCode);

					//EMAIL NOTIFICATION
					$subject = "JCI Philippines HQ | Account Password Reset Link";
					$body = "This message contains the link for your Password Reset request. 
					<b>Please contact the JCI Headquarters or Administrator Team if you did not request for a Password Reset.</b>
					Click this link to reset and change your password : <a href='http://jci.org.ph/mod02/index.php/site/rstpwd?vc=".$hashedVlCode."&ai=".$checkAccount->id."'>JCI Account Password Reset</a> <br /><br />
					Please always check your e-mail and keep yourself updated. Thank you!<br /><br />
					JCI Philippines";
					$send =  Account::model()->populateMsgProperties($checkAccount->id, $subject, $body);

					if($send == 1)
						Yii::app()->user->setFlash('success','An email with the link for your Password Reset request, was sent to your Email Address.');
					else
						Yii::app()->user->setFlash('error','There\'s an error in sending the email. Please try again later.');

				}
				else
					Yii::app()->user->setFlash('error','Account doesn\'t exist! The Username/Email Address you inputted was invalid. Please try again.');
			}	
			else
				Yii::app()->user->setFlash('error','Please input your Username/Email Address first!');

		}

		$this->render('forgotpass');
	}

	public function actionRstPwd($vc, $ai)
	{
		$this->layout ='login';

		$account = Account::model()->findByPk($ai);

		if($account != null)
		{
			$user = User::model()->find('account_id = '.$account->id);
			$updateDate = strtotime($account->date_updated);
			$vlCode = $account->id.$user->id.$updateDate;
			$hashedVlCode = sha1($vlCode);

			if($hashedVlCode === $vc)
			{
				if(isset($_POST['newpassword']))
				{
					if($_POST['newpassword'] === $_POST['confirmpassword'])
					{
						$account->setScenario('resetPwd');
						$account->new_password = $_POST['newpassword'];
						$account->confirm_password = $_POST['confirmpassword'];
						$valid = $account->validate();

						if($valid)
						{
							$account->salt = Account::model()->generateSalt();
							$account->password = Account::model()->hashPassword($account->new_password,$account->salt);

							if($account->save(false))
							{
								Yii::app()->user->setFlash('success','You have successfully changed your password!');
								$this->redirect(array('login'));
							}
							else
							{
								 Yii::app()->user->setFlash('error','An error has occurred while trying to change your password. Please try again later.');
							}
						}
						else
							{print_r($account->getErrors());exit;}
					}
					else
						Yii::app()->user->setFlash('error','Passwords doesn\'t match!');


					$this->redirect(array('rstpwd', 'vc'=>$vc, 'ai'=>$ai));
				}

				$this->render('changepassword',array('account'=>$account));
			}
			else
			{
				Yii::app()->user->setFlash('error','INVALID LINK!');
				$this->redirect(array('login'));
			}
		}
		else
		{
			Yii::app()->user->setFlash('error','INVALID LINK!');
			$this->redirect(array('login'));
		}
	}

	public function actionResetPosition()
	{
		$this->layout ='login';
		$id = Yii::app()->user->id;
		$account = Account::model()->findByPk($id);
		$user = User::model()->find('account_id = '.$account->id);
		$position = UserPositions::model()->find('account_id = '.$id.' AND status_id = 1');

		if($account != null)
		{
			if($account->status_id == 4)
			{
				if(isset($_POST['UserPositions']))
				{	
					$currentyear = date('Y');
					$connection = Yii::app()->db;
					$transaction = $connection->beginTransaction();

					if($position->term_year == $currentyear)
					{
						$currentposition = $position;
					}
					else
					{
						$currentposition = new UserPositions;
						$position->status_id = 2;
						$position->save();
					}

					$currentposition->attributes = $_POST['UserPositions'];
					$currentposition->account_id = $account->id;
					$currentposition->status_id = 1;
					$currentposition->term_year = $currentyear;

					$valid = $currentposition->validate();

					if($currentposition->position_id == 11 || $currentposition->position_id == 13) {
						$position_name = ($currentposition->position_id == 11) ? "PRESIDENT" : "SECRETARY";
						$valid_for_position = User::checkIfValidForPosition($currentposition->position_id, $currentposition->chapter_id);
						$valid = $valid_for_position && $valid;

						if(!$valid_for_position) {
							Yii::app()->user->setFlash("error", "Sorry, there's an account already registered as a {$position_name} in the selected chapter.");
						} 
					}

					if ($valid)
					{
						try
						{
							if($currentposition->save())
							{
								$account->status_id = 2;

								if($account->save())
								{
									$user->chapter_id = $currentposition->chapter_id;
									$user->position_id = $currentposition->position_id;
									$user->birthdate = $_POST['birthdate'];

									if($user->save())
									{
										$transaction->commit();
										Yii::app()->user->logout();
										Yii::app()->session->open();
										Yii::app()->user->setFlash('success','You have successfully updated your position. Please wait for the approval of your account from your Chapter President and JCI Headquarters.');
										$this->redirect(array('site/login'));  
									}
									else
									{
										print_r($user->getErrors());exit;
									}
								}
								else
								{
									print_r($account->getErrors());exit;
								}
							}
							else
							{
								print_r($currentposition->getErrors());exit;
							}
						}
						catch (Exception $e)
						{
							$transaction->rollback();
							Yii::app()->user->setFlash('error', 'An error occured while trying to update your position! Please try again later.');
						}
					}

				}

				$this->render('resetposition',array('account'=>$account));
			}
			else
			{
				Yii::app()->user->setFlash('error','INVALID LINK!');
				$this->redirect(array('login'));
			}
		}
		else
		{
			Yii::app()->user->setFlash('error','INVALID LINK!');
			$this->redirect(array('login'));
		}
		
	}
}