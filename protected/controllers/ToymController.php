<?php

class ToymController extends Controller
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
				'actions'=>array(),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','nominees'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->redirect(['toym/nominees']);
	}

	public function actionNominees($status = null)
	{
		$criteria = [];
		$condition = '';
		$nominator_condition = ['select' => false];
		$user = User::model()->find(array('condition'=>'account_id = :id', 'params'=>array(':id'=>Yii::app()->user->id)));

		if($status == 1 || $status == 2 || $status == 3) {
			$condition = "status = {$status}";
		} else {
			$condition = "status != 4 AND status != 5";
		}

		if(isset($_GET['credentials']) && $_GET['credentials'] != "") {
			if($condition != "") $condition .= " AND ";
			$condition .= "(CONCAT(t.firstName,' ', t.lastname) LIKE :credentials OR 
				CONCAT(nominator.firstName,' ', nominator.lastname) LIKE :credentials OR 
				t.email LIKE :credentials
			)";
			$criteria['params'] = [':credentials'=>'%'.$_GET['credentials'].'%'];
		}

		$nominator_condition['condition'] = "nominator.endorsing_chapter = :chapter_id";
		$nominator_condition['params'] = [':chapter_id' => $user->chapter_id];

		$criteria['condition'] = $condition;
		$criteria['order'] = 't.date_created DESC'; 

		$nominees = ToymNominee::model()->with(['nominator'=>$nominator_condition])->findAll($criteria);
		$nomineesDP=new CArrayDataProvider($nominees, array(
			'pagination' => array(
				'pageSize' => 15
			)
		));

		$this->render('nominees', [
			'nomineesDP' => $nomineesDP,
			'status'=>$status,
		]);
	}

}
