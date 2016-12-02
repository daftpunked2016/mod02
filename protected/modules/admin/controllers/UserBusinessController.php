<?php

class UserBusinessController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin';

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
				'actions'=>array('index','view'),
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
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$userBusiness = UserBusiness::model()->findAll("status_id = 1");
		$searchOption='status_id = 1';

		if(isset($_GET['businessName']) OR isset($_GET['businessCat']) OR isset($_GET['businessSubtype']) OR isset($_GET['businessProvince'])) 
			{		
				if($_GET['businessName'] !== '')
				{
					$searchOption = $searchOption.' AND (business_name LIKE "%'.$_GET['businessName'].'%" OR business_name LIKE "'.$_GET['businessName'].'%" OR business_name LIKE "%'.$_GET['businessName'].'")';
				}
				if($_GET['businessCat'] !== '')	
				{
					$searchOption =  $searchOption.' AND business_cat_id = '.$_GET['businessCat'];
				}
				if($_GET['businessSubtype'] !== '')	
				{
					$searchOption =  $searchOption.' AND business_type_id = '.$_GET['businessSubtype'];
				}
				if($_GET['businessProvince'] !== '')	
				{
					$searchOption =  $searchOption.' AND province_id = '.$_GET['businessProvince'];
				}

				$userBusiness = UserBusiness::model()->findAll($searchOption);	
			}
			
		$userBusinessesDP = new CArrayDataProvider($userBusiness, array(
				'pagination' => array(
					'pageSize' => 10,
				)
		));

		$this->render('index',array(
			'userBusinessesDP'=>$userBusinessesDP,
			'userBusiness'=>$userBusiness,
		));
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


}
