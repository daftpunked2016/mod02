<?php

class DefaultController extends Controller
{
	public $layout = 'layouts/admin';

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','register', 'listRegions', 'listChapters'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update', 'changePassword'),
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

	public function actionIndex()
	{
		$authAccount = Yii::app()->getModule("admin")->user->account;

		$area1 = AreaRegion::model()->isArea1()->findAll();
		$area1DP = new CArrayDataProvider($area1, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$area2 = AreaRegion::model()->isArea2()->findAll();
		$area2DP = new CArrayDataProvider($area2, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$area3 = AreaRegion::model()->isArea3()->findAll();
		$area3DP = new CArrayDataProvider($area3, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$area4 = AreaRegion::model()->isArea4()->findAll();
		$area4DP = new CArrayDataProvider($area4, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$area5 = AreaRegion::model()->isArea5()->findAll();
		$area5DP = new CArrayDataProvider($area5, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('index', array(
			// 'transactionsDP'=>$transactionsDP,
			'area1DP'=>$area1DP,
			'area2DP'=>$area2DP,
			'area3DP'=>$area3DP,
			'area4DP'=>$area4DP,
			'area5DP'=>$area5DP,
		));
	}

	public function actionTransaction()
	{
		$authAccount = Yii::app()->getModule("admin")->user->account;

		$transactions = Transactions::model()->findAll();
		$transactionsDP = new CArrayDataProvider($transactions, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));
		$this->render('transaction', array(
			'transactionsDP'=>$transactionsDP,
		));
	}

	public function actionLogin()
	{	
		//$this->layout ='site/login';
		$model = new AdminLoginForm;
		if(isset($_POST['AdminLoginForm']))
		{
			$model->attributes = $_POST['AdminLoginForm'];
			if ($model->validate() && $model->login())
			{
				// $transaction = new Transaction;
				// $transaction->generateLog(Yii::app()->getModule("admin")->user->id, Transaction::TYPE_LOGIN);
				$this->redirect(array('default/index'));
			}
		}

		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		if(isset($_SESSION['token']))
			unset($_SESSION['token']);
			
		Yii::app()->getModule('admin')->user->logout(false);
		Yii::app()->user->setFlash('success', 'Logout Successful.');
		$this->redirect(Yii::app()->getModule('admin')->user->loginUrl);
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

	public function actionListDelegates()
	{
		$authAccount = Yii::app()->getModule("admin")->user->account->user;
		
		$listdelegates = User::model()->isActive()->userAccount()->findAll('chapter_id = '.$authAccount->chapter_id.'');
		$listdelegatesDP = new CArrayDataProvider($listdelegates, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$Inactivelistdelegates = User::model()->isInactive()->userAccount()->findAll('chapter_id = '.$authAccount->chapter_id.'');
		$InactivelistdelegatesDP = new CArrayDataProvider($Inactivelistdelegates, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('listdelegates', array(
			'listdelegatesDP'=>$listdelegatesDP,
			'InactivelistdelegatesDP'=>$InactivelistdelegatesDP,
		));
	}

	public function actionBusiness()
	{
		$this->render('business');
	}

	public function actionListChapters($id, $anum)
	{
		$region = AreaRegion::model()->find(array('condition' => 'area_no ="'.$anum.'" AND id = "'.$id.'"'));
		$chapters = Chapter::model()->findAll(array('condition' => 'area_no ="'.$anum.'" AND region_id = "'.$id.'"'));
		$chaptersDP = new CArrayDataProvider($chapters, array(
			'pagination' => array(
				'pageSize' => 20
			)
		));

		$this->render('chapters', array(
			// 'transactionsDP'=>$transactionsDP,
			'chaptersDP' => $chaptersDP,
			'region' => $region,
		));
	}

	public function actionListMembers($id)
	{
		$chapter = Chapter::model()->findByPk($id);
		$region = AreaRegion::model()->findByPk($chapter->region_id);
		$activemem = User::model()->userAccount()->isActive()->findAll(array('condition' => 'chapter_id ='.$id));
		
		if(isset($_GET['exports'])) {

			foreach ($activemem as $res) {

				$a[] = array(
					"Full Name" => User::model()->getCompleteName2($res->account_id),
					"Email" => $res->account->username,
					"Chapter" => Chapter::model()->getName($res->chapter_id),
					"Member ID" => $res->member_id,
					"Position" => Position::model()->getName($res->position_id),
					"Picture Filename" => Fileupload::model()->getFileName($res->user_avatar),
				);
			}

			if(count($activemem) != 0){
				Account::model()->download_send_headers(str_replace(array('"', "'", ' ', ','), '_', Chapter::model()->getName($chapter->id)).date("Y-m-d").".csv");
				echo Account::model()->array2csv($a);
				die();
			}
		}

		if(isset($_GET['profile-pics'])) {
			
			# define file array
			foreach ($activemem as $res) {

				$files[] = Fileupload::model()->getProfilePicture($res->user_avatar);
			}

			# create new zip opbject
			$zip = new ZipArchive();

			# create a temp file & open it
			$tmp_file = tempnam('temp','');
			$zip->open($tmp_file, ZipArchive::CREATE);

			# loop through each file
			foreach($files as $file){

			    # download file
			    $download_file = file_get_contents($file);

			    #add it to the zip
			    $zip->addFromString(basename($file),$download_file);

			}
			# close zip
			$zip->close();

			# send the file to the browser as a download
			header('Content-disposition: attachment; filename='.str_replace(array('"', "'", ' ', ','), '_', Chapter::model()->getName($chapter->id)).".zip");
			header('Content-type: application/zip');
			readfile($tmp_file);
			die();
		}

		$activeMemDP = new CArrayDataProvider($activemem, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$inactive = User::model()->userAccount()->isInactive()->findAll(array('condition' => 'chapter_id ='.$id));
		$inactiveMemDP = new CArrayDataProvider($inactive, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('members', array(
			// 'transactionsDP'=>$transactionsDP,
			'activeMemDP'=>$activeMemDP,
			'inactiveMemDP'=>$inactiveMemDP,
			'chapter'=>$chapter,
			'region'=>$region,
		));
	}
}