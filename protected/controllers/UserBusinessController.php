<?php

class UserBusinessController extends Controller
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
				'actions'=>array('index','view', 'get', 'test', 'listReferrals'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new UserBusiness;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['UserBusiness']))
		{
			$model->attributes=$_POST['UserBusiness'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['UserBusiness']))
		{
			$model->attributes=$_POST['UserBusiness'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new UserBusiness('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['UserBusiness']))
			$model->attributes=$_GET['UserBusiness'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return UserBusiness the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=UserBusiness::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function actionGet($k, $b, $t)
	{
		if($t == 1) {
			$business = UserBusiness::model()->findByPk($b);
			//$encode .= json_encode($business->attributes);
			//print_r(md5($business->id.$business->business_name.$business->account_id)); exit;

			if($business) {
				if(md5($business->id.$business->business_name.$business->account_id) === $k) {
					$account_details = array(
						'ak'=>$business->account->id,
						'sk'=>$business->account->salt,
						'bk'=>$business->id,
						'username'=>$business->account->username,
						'firstname'=>$business->user->firstname,
						'lastname'=>$business->user->lastname,
						'middlename'=>$business->user->middlename,
						'chapter_id'=>$business->user->chapter_id
					);
					$details = array_merge($account_details,$business->attributes);
					echo json_encode($details);
					exit;
				}
			} 
				
			return null;
		} else {
			$account = Account::model()->findByPk($b);

			if($account) {
				if(md5($account->id.$account->salt.$account->user->lastname.$account->user->id) === $k) {
					$account_details = array(
						'ak'=>$account->id,
						'sk'=>$account->salt,
						'username'=>$account->username,
						'firstname'=>$account->user->firstname,
						'lastname'=>$account->user->lastname,
						'middlename'=>$account->user->middlename,
						'chapter_id'=>$account->user->chapter_id
					);

					echo json_encode($account_details);
					exit;
				} 
			}
			
			return null;
			
		}

		exit;
	}

	public function actionTest()
	{
		$business = UserBusiness::model()->findByPk(6);	
		print_r(md5($business->id.$business->business_name.$business->account_id)); exit;
		/*$account = Account::model()->findByPk(602);
		print_r(md5($account->username.$account->id.$account->salt)); exit;*/
	}

	/**
	 * Performs the AJAX validation.
	 * @param UserBusiness $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-business-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	// list business referrals (chapter level)
	public function actionListReferrals()
	{	
		// $user = User::model()->find(array('condition'=>'account_id = :aid', 'params'=>array(':aid'=>Yii::app()->user->id)));
		$referrals = file_get_contents('http://www.jcipadvantage.com/mod04/index.php/postreqjs/chapterreferrals?cid=209');

		$referralsDP=new CArrayDataProvider($referrals, array(
			'pagination' => array(
		        'pageSize'=>15,
		    ),
		));

		echo "<pre>";
		print_r($referralsDP);
		echo "</pre>";
		exit;
		
		$this->render('list', array(
			'referralsDP'=>$referralsDP,
		));
	}
}
