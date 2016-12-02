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

		// $transactions = Transactions::model()->findAll();
		// $transactionsDP = new CArrayDataProvider($transactions, array(
		// 	'pagination' => array(
		// 		'pageSize' => 10
		// 	)
		// ));
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

	public function actionCagayanValley()
	{
		$cagayanvalley = User::model()->isArea1Region1()->isActive()->userAccount()->findAll();
		$cagayanvalleyDP = new CArrayDataProvider($cagayanvalley, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$Inactivecagayanvalley = User::model()->isArea1Region1()->isInactive()->userAccount()->findAll();
		$InactivecagayanvalleyDP = new CArrayDataProvider($Inactivecagayanvalley, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('cagayanvalley', array(
			'cagayanvalleyDP'=>$cagayanvalleyDP,
			'InactivecagayanvalleyDP'=>$InactivecagayanvalleyDP,
		));
	}

	public function actionCentralLuzon()
	{
		$centralluzon = User::model()->isArea1Region2()->isActive()->userAccount()->findAll();
		$centralluzonDP = new CArrayDataProvider($centralluzon, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$Inactivecentralluzon = User::model()->isArea1Region2()->isInactive()->userAccount()->findAll();
		$InactivecentralluzonDP = new CArrayDataProvider($Inactivecentralluzon, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('centralluzon', array(
			'centralluzonDP'=>$centralluzonDP,
			'InactivecentralluzonDP'=>$InactivecentralluzonDP,
		));
	}

	public function actionNorthernLuzon()
	{
		$northernluzon = User::model()->isArea1Region3()->isActive()->userAccount()->findAll();
		$northernluzonDP = new CArrayDataProvider($northernluzon, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$Inactivenorthernluzon = User::model()->isArea1Region3()->isInactive()->userAccount()->findAll();
		$InactivenorthernluzonDP = new CArrayDataProvider($Inactivenorthernluzon, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('northernluzon', array(
			'northernluzonDP'=>$northernluzonDP,
			'InactivenorthernluzonDP'=>$InactivenorthernluzonDP,
		));
	}

	public function actionIlocandiaRegion()
	{
		$ilocandiaregion = User::model()->isArea1Region4()->isActive()->userAccount()->findAll();
		$ilocandiaregionDP = new CArrayDataProvider($ilocandiaregion, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$Inactiveilocandiaregion = User::model()->isArea1Region4()->isInactive()->userAccount()->findAll();
		$InactiveilocandiaregionDP = new CArrayDataProvider($Inactiveilocandiaregion, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('ilocandiaregion', array(
			'ilocandiaregionDP'=>$ilocandiaregionDP,
			'InactiveilocandiaregionDP'=>$InactiveilocandiaregionDP,
		));
	}

	public function actionMetroNorth()
	{
		$metronorth = User::model()->isArea2Region5()->isActive()->userAccount()->findAll();
		$metronorthDP = new CArrayDataProvider($metronorth, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$Inactivemetronorth = User::model()->isArea2Region5()->isInactive()->userAccount()->findAll();
		$InactivemetronorthDP = new CArrayDataProvider($Inactivemetronorth, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('metronorth', array(
			'metronorthDP'=>$metronorthDP,
			'InactivemetronorthDP'=>$InactivemetronorthDP,
		));
	}

	public function actionMetroEast()
	{
		$metroeast = User::model()->isArea2Region6()->isActive()->userAccount()->findAll();
		$metroeastDP = new CArrayDataProvider($metroeast, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$Inactivemetroeast = User::model()->isArea2Region6()->isInactive()->userAccount()->findAll();
		$InactivemetroeastDP = new CArrayDataProvider($Inactivemetroeast, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('metroeast', array(
			'metroeastDP'=>$metroeastDP,
			'InactivemetroeastDP'=>$InactivemetroeastDP,
		));
	}

	public function actionMetroSouth()
	{
		$metrosouth = User::model()->isArea2Region7()->isActive()->userAccount()->findAll();
		$metrosouthDP = new CArrayDataProvider($metrosouth, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$Inactivemetrosouth = User::model()->isArea2Region7()->isInactive()->userAccount()->findAll();
		$InactivemetrosouthDP = new CArrayDataProvider($Inactivemetrosouth, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('metrosouth', array(
			'metrosouthDP'=>$metrosouthDP,
			'InactivemetrosouthDP'=>$InactivemetrosouthDP,
		));
	}

	public function actionRizalRegion()
	{
		$rizalregion = User::model()->isArea2Region8()->isActive()->userAccount()->findAll();
		$rizalregionDP = new CArrayDataProvider($rizalregion, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$Inactiverizalregion = User::model()->isArea2Region8()->isInactive()->userAccount()->findAll();
		$InactiverizalregionDP = new CArrayDataProvider($Inactiverizalregion, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('rizalregion', array(
			'rizalregionDP'=>$rizalregionDP,
			'InactiverizalregionDP'=>$InactiverizalregionDP,
		));
	}

	public function actionSouthernTagalog()
	{
		$southerntagalog = User::model()->isArea3Region9()->isActive()->userAccount()->findAll();
		$southerntagalogDP = new CArrayDataProvider($southerntagalog, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$Inactivesoutherntagalog = User::model()->isArea3Region9()->isInactive()->userAccount()->findAll();
		$InactivesoutherntagalogDP = new CArrayDataProvider($Inactivesoutherntagalog, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('southerntagalog', array(
			'southerntagalogDP'=>$southerntagalogDP,
			'InactivesoutherntagalogDP'=>$InactivesoutherntagalogDP,
		));
	}

	public function actionLagunaRegion()
	{
		$lagunaregion = User::model()->isArea3Region10()->isActive()->userAccount()->findAll();
		$lagunaregionDP = new CArrayDataProvider($lagunaregion, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$Inactivelagunaregion = User::model()->isArea3Region10()->isInactive()->userAccount()->findAll();
		$InactivelagunaregionDP = new CArrayDataProvider($Inactivelagunaregion, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('lagunaregion', array(
			'lagunaregionDP'=>$lagunaregionDP,
			'InactivelagunaregionDP'=>$InactivelagunaregionDP,
		));
	}

	public function actionCaviteSouth()
	{
		$cavitesouth = User::model()->isArea3Region11()->isActive()->userAccount()->findAll();
		$cavitesouthDP = new CArrayDataProvider($cavitesouth, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$Inactivecavitesouth = User::model()->isArea3Region11()->isInactive()->userAccount()->findAll();
		$InactivecavitesouthDP = new CArrayDataProvider($Inactivecavitesouth, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('cavitesouth', array(
			'cavitesouthDP'=>$cavitesouthDP,
			'InactivecavitesouthDP'=>$InactivecavitesouthDP,
		));
	}

	public function actionCaviteNorth()
	{
		$cavitenorth = User::model()->isArea3Region12()->isActive()->userAccount()->findAll();
		$cavitenorthDP = new CArrayDataProvider($cavitenorth, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$Inactivecavitenorth = User::model()->isArea3Region12()->isInactive()->userAccount()->findAll();
		$InactivecavitenorthDP = new CArrayDataProvider($Inactivecavitenorth, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('cavitenorth', array(
			'cavitenorthDP'=>$cavitenorthDP,
			'InactivecavitenorthDP'=>$InactivecavitenorthDP,
		));
	}

	public function actionPalawanRegion()
	{
		$palawanregion = User::model()->isArea3Region13()->isActive()->userAccount()->findAll();
		$palawanregionDP = new CArrayDataProvider($palawanregion, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$Inactivepalawanregion = User::model()->isArea3Region13()->isInactive()->userAccount()->findAll();
		$InactivepalawanregionDP = new CArrayDataProvider($Inactivepalawanregion, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('palawanregion', array(
			'palawanregionDP'=>$palawanregionDP,
			'InactivepalawanregionDP'=>$InactivepalawanregionDP,
		));
	}

	public function actionBicolRegion()
	{
		$bicolregion = User::model()->isArea3Region14()->isActive()->userAccount()->findAll();
		$bicolregionDP = new CArrayDataProvider($bicolregion, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$Inactivebicolregion = User::model()->isArea3Region14()->isInactive()->userAccount()->findAll();
		$InactivebicolregionDP = new CArrayDataProvider($Inactivebicolregion, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('bicolregion', array(
			'bicolregionDP'=>$bicolregionDP,
			'InactivebicolregionDP'=>$InactivebicolregionDP,
		));
	}

	public function actionEasternVisayas()
	{
		$easternvisayas = User::model()->isArea4Region15()->isActive()->userAccount()->findAll();
		$easternvisayasDP = new CArrayDataProvider($easternvisayas, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$Inactiveeasternvisayas = User::model()->isArea4Region15()->isInactive()->userAccount()->findAll();
		$InactiveeasternvisayasDP = new CArrayDataProvider($Inactiveeasternvisayas, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('easternvisayas', array(
			'easternvisayasDP'=>$easternvisayasDP,
			'InactiveeasternvisayasDP'=>$InactiveeasternvisayasDP,
		));
	}

	public function actionCentralVisayas()
	{
		$centralvisayas = User::model()->isArea4Region17()->isActive()->userAccount()->findAll();
		$centralvisayasDP = new CArrayDataProvider($centralvisayas, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$Inactivecentralvisayas = User::model()->isArea4Region17()->isInactive()->userAccount()->findAll();
		$InactivecentralvisayasDP = new CArrayDataProvider($Inactivecentralvisayas, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('centralvisayas', array(
			'centralvisayasDP'=>$centralvisayasDP,
			'InactivecentralvisayasDP'=>$InactivecentralvisayasDP,
		));
	}

	public function actionWesternVisayas()
	{
		$westernvisayas = User::model()->isArea4Region16()->isActive()->userAccount()->findAll();
		$westernvisayasDP = new CArrayDataProvider($westernvisayas, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$Inactivewesternvisayas = User::model()->isArea4Region16()->isInactive()->userAccount()->findAll();
		$InactivewesternvisayasDP = new CArrayDataProvider($Inactivewesternvisayas, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('westernvisayas', array(
			'westernvisayasDP'=>$westernvisayasDP,
			'InactivewesternvisayasDP'=>$InactivewesternvisayasDP,
		));
	}

	public function actionNorthernMindanao()
	{
		$northernmindanao = User::model()->isArea5Region18()->isActive()->userAccount()->findAll();
		$northernmindanaoDP = new CArrayDataProvider($northernmindanao, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$Inactivenorthernmindanao = User::model()->isArea5Region18()->isInactive()->userAccount()->findAll();
		$InactivenorthernmindanaoDP = new CArrayDataProvider($Inactivenorthernmindanao, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('northernmindanao', array(
			'northernmindanaoDP'=>$northernmindanaoDP,
			'InactivenorthernmindanaoDP'=>$InactivenorthernmindanaoDP,
		));
	}

	public function actionDavaoRegion()
	{
		$davaoregion = User::model()->isArea5Region19()->isActive()->userAccount()->findAll();
		$davaoregionDP = new CArrayDataProvider($davaoregion, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$Inactivedavaoregion = User::model()->isArea5Region19()->isInactive()->userAccount()->findAll();
		$InactivedavaoregionDP = new CArrayDataProvider($Inactivedavaoregion, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('davaoregion', array(
			'davaoregionDP'=>$davaoregionDP,
			'InactivedavaoregionDP'=>$InactivedavaoregionDP,
		));
	}

	public function actionSouthernMindanao()
	{
		$southernmindanao = User::model()->isArea5Region20()->isActive()->userAccount()->findAll();
		$southernmindanaoDP = new CArrayDataProvider($southernmindanao, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$Inactivesouthernmindanao = User::model()->isArea5Region20()->isInactive()->userAccount()->findAll();
		$InactivesouthernmindanaoDP = new CArrayDataProvider($Inactivesouthernmindanao, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('southernmindanao', array(
			'southernmindanaoDP'=>$southernmindanaoDP,
			'InactivesouthernmindanaoDP'=>$InactivesouthernmindanaoDP,
		));
	}

	public function actionCentralMindanao()
	{
		$centralmindanao = User::model()->isArea5Region21()->isActive()->userAccount()->findAll();
		$centralmindanaoDP = new CArrayDataProvider($centralmindanao, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$Inactivecentralmindanao = User::model()->isArea5Region21()->isInactive()->userAccount()->findAll();
		$InactivecentralmindanaoDP = new CArrayDataProvider($Inactivecentralmindanao, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('centralmindanao', array(
			'centralmindanaoDP'=>$centralmindanaoDP,
			'InactivecentralmindanaoDP'=>$InactivecentralmindanaoDP,
		));
	}

	public function actionWesternMindanao()
	{
		$westernmindanao = User::model()->isArea5Region22()->isActive()->userAccount()->findAll();
		$westernmindanaoDP = new CArrayDataProvider($westernmindanao, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$Inactivewesternmindanao = User::model()->isArea5Region22()->isInactive()->userAccount()->findAll();
		$InactivewesternmindanaoDP = new CArrayDataProvider($Inactivewesternmindanao, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('westernmindanao', array(
			'westernmindanaoDP'=>$westernmindanaoDP,
			'InactivewesternmindanaoDP'=>$InactivewesternmindanaoDP,
		));
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
}