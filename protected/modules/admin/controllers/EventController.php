<?php

class EventController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='layouts/admin';

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
	// public function accessRules()
	// {
	// 	return array(
	// 		array('allow',  // allow all users to perform 'index' and 'view' actions
	// 			'actions'=>array('index','view', 'create', 'admin'),
	// 			'users'=>array('*'),
	// 		),
	// 		array('allow', // allow authenticated user to perform 'create' and 'update' actions
	// 			'actions'=>array('create','update'),
	// 			'users'=>array('@'),
	// 		),
	// 		array('allow', // allow admin user to perform 'admin' and 'delete' actions
	// 			'actions'=>array('admin','delete'),
	// 			'users'=>array('admin'),
	// 		),
	// 		array('deny',  // deny all users
	// 			'users'=>array('*'),
	// 		),
	// 	);
	// }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$event = Event::model()->findByPk($id);
		$eventpricing = EventPricing::model()->find("event_id = ".$id);
		$eventps = EventPS::model()->findAll("event_id = ".$id);

		$this->render('view',array(
			'event'=>$event,
			'eventpricing'=>$eventpricing,
			'eventps'=>$eventps,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$event = new Event;
		$eventpricing = new EventPricing;
		$fileupload = new Fileupload;
		$filerelation = new Filerelation;
		$paymentscheme = array();
		$ps_count = 0;

		if(isset($_POST['Event']))
		{	
			if(!isset($_POST['payment_scheme'])) {
				Yii::app()->user->setFlash('error', 'Error! You must select a Payment Scheme.');
				$this->redirect(array('event/create'));
			}

			if(!isset($_POST['Event']['host_account_id'])) {
				Yii::app()->user->setFlash('error', 'Error! You must select an Event Host.');
				$this->redirect(array('event/create'));
			}

			$event->attributes = $_POST['Event'];
			$eventpricing->attributes = $_POST['EventPricing'];
			//$eventpricing->setScenario("createPricing");
			$image = $fileupload->filename=CUploadedFile::getInstance($event,'event_avatar');
			$event->event_avatar = $image;
			$event->status_id = 1;

			if($eventpricing->pricing_type == 1) //FREE
			{
				$eventpricing->early_bird_price = 0;
				$eventpricing->regular_price = 0;
				$eventpricing->onsite_price = 0;
			}
			elseif($eventpricing->pricing_type == 2) //FIXED = regular price only
			{
				$eventpricing->early_bird_price = 0;
				$eventpricing->onsite_price = 0;
			}

			//PAYMENT SCHEMES
			if($eventpricing->pricing_type != 1) {
				foreach($_POST['payment_scheme'] as $ps)
				{
					if($ps != null || $ps !== '')
					{
						$paymentscheme[$ps_count] = new EventPS;
						$paymentscheme[$ps_count]->payment_scheme_id = $ps;
						$paymentscheme[$ps_count]->status_id = 1;
						$ps_count++;
					}
				}
			}

			$valid = $event->validate();
			//$valid = $eventpricing->validate() && $valid;

			if ($valid)
			{	
				$connection = Yii::app()->db;
				$transaction = $connection->beginTransaction();
		
				try
				{
					$fileupload->poster_id = Yii::app()->getModule('admin')->user->id;

					//FILE UPLOAD RENAMING
					$name       = $_FILES['Event']['name']['event_avatar'];
					$ext        = pathinfo($name, PATHINFO_EXTENSION);
					$currentDate = date('Ymdhis');
					$newName = 'JCIPH-EA-'.$currentDate.''.Yii::app()->getModule('admin')->user->id.'.'.$ext;

					//FILE TRANSFER TO SERVER
					$fileupload->filename->saveAs('event_avatars/'.$newName);
					$fileupload->filename = $newName;
					
					if ($fileupload->save())
					{
						$event->event_avatar = $fileupload->id;

						if($event->save())
						{
							$eventpricing->event_id = $event->id;
							$eventpricing->status_id = 1;
							
							if ($eventpricing->save())
							{
								$filerelation->fileupload_id = $fileupload->id;
								$filerelation->relationship_id = 3; //3 means for Events
								
								if ($filerelation->save())
								{
									if($eventpricing->pricing_type != 1) {
										foreach($paymentscheme as $ps)
										{
											$ps->event_id = $event->id;
											$ps->save();
										}
									}

									$createhost = Host::model()->createEventHost($event->host_account_id, $event->id);  //create Event Host

									if($createhost)
									{
										$transaction->commit();
										Event::model()->setNewEventNotifProp($event->id); //EMAIL NOTIF FOR USERS
										Yii::app()->user->setFlash('success', 'You have successfully created an event.');
										$this->redirect(array('index'));
									}
								}
							}
						}
					}
				} catch (Exception $e) {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', 'An error occured while trying to create an event! Please try again later.');
				} 
			}
			else
			{
				$errors = $event->getErrors();
				$errors += $eventpricing->getErrors();
				print_r($errors);
				exit;
			}
		}

		$this->render('create',array(
			'event'=>$event,
			'eventpricing'=>$eventpricing,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$ifCreateHost = false;
		$event = Event::model()->findByPk($id);
		$eventpricing = EventPricing::model()->find("event_id = ".$id);
		$currentHost = $event->host_account_id;

		if(isset($_POST['Event']))
		{
			if($_POST['Event']['host_account_id']!=null) //if new Event Host
				$ifCreateHost = true;

			$event->attributes = $_POST['Event'];
			$eventpricing->attributes = $_POST['EventPricing'];

			if($eventpricing->pricing_type == 1) //FREE
			{
				$eventpricing->early_bird_price = 0;
				$eventpricing->regular_price = 0;
				$eventpricing->onsite_price = 0;
			}
			elseif($eventpricing->pricing_type == 2) //FIXED = regular price only
			{
				$eventpricing->early_bird_price = 0;
				$eventpricing->onsite_price = 0;
			}

			$valid = $event->validate();
			//$valid = $eventpricing->validate() && $valid;

			if ($valid)
				{  
					$connection = Yii::app()->db;
					$transaction = $connection->beginTransaction();
					
					try
					{
						if($event->save(false))
							{
								if ($eventpricing->save(false))
									{
										if($ifCreateHost) //if New Event Host
										{
											if($_POST['Event']['host_account_id'] != $currentHost)
											{
												Host::model()->deactivateCurrentHost($event->id); //deactivate current Event Host
												Host::model()->createEventHost($event->host_account_id, $event->id);  //create Event Host
											}
										}

										$transaction->commit();
										Yii::app()->user->setFlash('success','You have successfully updated or configured an event!');
										$this->redirect(array('index'));
									}
							}
					}
					catch (Exception $e)
					{
						$transaction->rollback();
						Yii::app()->user->setFlash('error', 'An error occured while trying to update the event! Please try again later.');
					} 
				}
		}

		$this->render('update',array(
			'event'=>$event,
			'eventpricing'=>$eventpricing,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionChangePoster($event_id)
	{
		$event = Event::model()->findByPk($event_id);
		
		if($event!=null)
		{
			if(isset($_FILES['avatar']))
			{
				$fileupload = new Fileupload;
				$filerelation = new Filerelation;

				//FILE UPLOAD RENAMING
				$name       = $_FILES['avatar']['name'];
				$ext        = pathinfo($name, PATHINFO_EXTENSION);
				$currentDate = date('Ymdhis');
				$newName = 'JCIPH-EA-'.$currentDate.''.Yii::app()->getModule('admin')->user->id.'.'.$ext;

				$fileupload->poster_id= Yii::app()->getModule('admin')->user->id;			
				$avatar =  $newName;
				$fileupload->filename = $avatar;
				$target_path = "event_avatars/";
				$target_path = $target_path . $avatar;
					
				$connection = Yii::app()->db;
				$transaction = $connection->beginTransaction();
							
				try
					{
						if ($fileupload->save())
						{
							
							$event->event_avatar = $fileupload->id;
							move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_path);
							
							if ($event->save())
							{
								$filerelation->fileupload_id = $fileupload->id;
								$filerelation->relationship_id = 3; //3 for events
																	 
								if ($filerelation->save())
								{
									$transaction->commit();
									Yii::app()->user->setFlash('success', 'You have successfully changed the event poster.');
									$this->redirect(array('view', 'id' => $event_id));
								}
								else
									print_r($filerelation->getErrors());exit;	
							}
							else
								print_r($event->getErrors());exit;
						}
						else
							print_r($fileupload->getErrors());exit;
					}
				catch (Exception $e)
					{
						$transaction->rollback();
						Yii::app()->user->setFlash('error', 'An error occured while trying to update the event poster! Please try again later.');
						$this->redirect(array('view', 'id' => $event_id));
					} 
			}
			else
				$this->redirect(array('view', 'id' => $event_id));
		}
		else
			$this->redirect(array('site/login'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$eventsList = array();
		
		$searchOption = 'status_id = 1';

		if(isset($_GET['eventName']) OR isset($_GET['eventType']) OR isset($_GET['eventDate'])) 
		{		

			if($_GET['eventName'] !== '')	
			{
				$searchOption =  $searchOption.' AND name LIKE "%'.$_GET['eventName'].'%"';
			}
			if($_GET['eventType'] !== '')	
			{
				$searchOption =  $searchOption.' AND event_type = '.$_GET['eventType'];
			}
			if($_GET['eventDate'] !== '')	
			{
				$searchOption =  $searchOption.' AND date = "'.$_GET['eventDate'].'"';
			}

			$events = Event::model()->findAll($searchOption);
		}
		else
			$events = Event::model()->findAll(array(
				'condition'=>'status_id = 1',
				));

		
		$listEventsDP = new CArrayDataProvider($events, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('index',array(
			'events' => $events,
			'listEventsDP' => $listEventsDP,
		));	
	}

	public function actionInactiveIndex()
	{

		$eventsList = array();
		
		$searchOption = 'status_id = 2';

		if(isset($_GET['eventName']) OR isset($_GET['eventType']) OR isset($_GET['eventDate'])) 
		{		

			if($_GET['eventName'] !== '')	
			{
				$searchOption =  $searchOption.' AND name LIKE "%'.$_GET['eventName'].'%"';
			}
			if($_GET['eventType'] !== '')	
			{
				$searchOption =  $searchOption.' AND event_type = '.$_GET['eventType'];
			}
			if($_GET['eventDate'] !== '')	
			{
				$searchOption =  $searchOption.' AND date = "'.$_GET['eventDate'].'"';
			}

			$events = Event::model()->findAll($searchOption);
		}
		else
			$events = Event::model()->findAll(array(
				'condition'=>'status_id = 2',
				));

		$inactivelistEventsDP = new CArrayDataProvider($events, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('inactiveindex',array(
			'events' => $events,
			'inactivelistEventsDP' => $inactivelistEventsDP,
		));	
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Event('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Event']))
			$model->attributes=$_GET['Event'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionViewStats($event_id)
	{
		$event = Event::model()->findByPk($event_id);
		$accounts = Account::model()->findAll('status_id = 1 AND account_type_id = 2');

		$this->render('stats',array(
			'event'=>$event,
			'event_attendees'=>$event->event_attendees,
			'sales'=>$event->sales,
			'payments'=>$event->payments,
			'accounts'=>$accounts,
		));
	}
   
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Event the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Event::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function actionCreateHost($eventid)
	{
		$createhost = Host::model()->deactivateCurrentHost($eventid); //create Event Host 

		if($createhost)
			print_r('hello'); 
		else
			print_r('err');

		exit;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Event $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='event-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionDeactivateEvent($id)
	{
		$event = Event::model()->findByPk($id);

		if($event != null){
			$event->status_id = 2;

			if($event->save()){
				Yii::app()->user->setFlash('success','You have successfully deactivated the event!');
				$this->redirect(array('index'));
			}

		}
	}

	public function actionActivateEvent($id)
	{
		$event = Event::model()->findByPk($id);

		if($event != null){
			$event->status_id = 1;

			if($event->save()){
				Yii::app()->user->setFlash('success','You have successfully activated the event!');
				$this->redirect(array('inactiveindex'));
			}

		}
	}

	public function actionConfigPs($event_id)
	{
		$event = Event::model()->findByPk($event_id);
		$event_ps = EventPS::model()->findAll('event_id = '.$event_id.' AND status_id = 1');

		
		$listEventsPSDP = new CArrayDataProvider($event_ps, array(
			'pagination' => array(
				'pageSize' => 15
			)
		));

		$this->render('updateps',array(
			'event_ps' => $event_ps,
			'listEventsPSDP' => $listEventsPSDP,
			'event'=>$event,
		));	
	}


	public function actionDeletePS($id)
	{
		$event_ps = EventPS::model()->findByPk($id);

		if($event_ps != null)
		{
			$connection = Yii::app()->db;
			$transaction = $connection->beginTransaction();

			if($event_ps->delete())
			{
				$transaction->commit();
				Yii::app()->user->setFlash('success','Payment Scheme has been successfully deleted.');
			}
			else
			{
				$transaction->rollback();
				Yii::app()->user->setFlash('error','Error in deleting Payment Scheme record. Please try again later.');
			}
		}
		else
			Yii::app()->user->setFlash('error','Invalid Link!');

		$this->redirect(array('configps', 'event_id' => $event_ps->event_id));
	}

	public function actionAddNewPS($event_id)
	{
		$event = Event::model()->findByPk($event_id);

		if($event != null)
		{
			if(isset($_POST['event_ps']))
			{
				if($_POST['event_ps']!= null || $_POST['event_ps'] != '')
				{
					$ps = PaymentScheme::model()->findByPk($_POST['event_ps']);

					if($ps != null)
					{
						$connection = Yii::app()->db;
						$transaction = $connection->beginTransaction();

						$event_ps = new EventPS;
						$event_ps->event_id = $event_id;
						$event_ps->payment_scheme_id = $ps->id;
						$event_ps->status_id = 1;

						if($event_ps->save())
						{
							$transaction->commit();
							Yii::app()->user->setFlash('success','Payment Scheme has been successfully added.');
						}
						else
						{
							$transaction->rollback();
							Yii::app()->user->setFlash('error','Error in adding Payment Scheme record. Please try again later.');
						}
					}
					else
						Yii::app()->user->setFlash('error','Invalid Input!');
				}
				else
					Yii::app()->user->setFlash('error','Input Value first.');
			}
			else
				Yii::app()->user->setFlash('error','Input Value first.');
		}
		else
			Yii::app()->user->setFlash('error','Invalid Link!');

		$this->redirect(array('configps', 'event_id' => $event_id));
	}


	public function actionUpdatePS($event_id, $id)
	{
		$event = Event::model()->findByPk($event_id);

		if($event != null)
		{
			if(isset($_POST['event_ps']))
			{
				if($_POST['event_ps']!= null || $_POST['event_ps'] != '')
				{
					$ps = PaymentScheme::model()->findByPk($_POST['event_ps']);

					if($ps != null)
					{
						$connection = Yii::app()->db;
						$transaction = $connection->beginTransaction();

						$event_ps = EventPS::model()->findByPk($id);
						$event_ps->payment_scheme_id = $ps->id;

						if($event_ps->save())
						{
							$transaction->commit();
							Yii::app()->user->setFlash('success','Payment Scheme has been successfully updated.');
						}
						else
						{
							$transaction->rollback();
							Yii::app()->user->setFlash('error','Error in updating Payment Scheme record. Please try again later.');
						}
					}
					else
						Yii::app()->user->setFlash('error','Invalid Input!');
				}
				else
					Yii::app()->user->setFlash('error','Input Value first.');
			}
			else
				Yii::app()->user->setFlash('error','Input Value first.');
		}
		else
			Yii::app()->user->setFlash('error','Invalid Link!');

		$this->redirect(array('configps', 'event_id' => $event_id));
	}

	public function actionViewPaid($event_id)
	{
		$event = Event::model()->findByPk($event_id);
		$attendees = EventAttendees::model()->paidAttendee()->findAll('event_id ='.$event_id);

		$attendeesDP = new CArrayDataProvider($attendees, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('1attendee',array(
			'attendeesDP' => $attendeesDP,
			'event' => $event,
		));
	}

	public function actionViewPending($event_id)
	{
		$event = Event::model()->findByPk($event_id);
		$attendees = EventAttendees::model()->pendingAttendee()->findAll('event_id ='.$event_id);

		$attendeesDP = new CArrayDataProvider($attendees, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('2attendee',array(
			'attendeesDP' => $attendeesDP,
			'event' => $event,
		));
	}

	public function actionViewUnpaid($event_id)
	{
		$event = Event::model()->findByPk($event_id);
		$attendees = EventAttendees::model()->unpaidAttendee()->findAll('event_id ='.$event_id);

		$attendeesDP = new CArrayDataProvider($attendees, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('3attendee',array(
			'attendeesDP' => $attendeesDP,
			'event' => $event,
		));
	}

	public function actionGetPS()
	{
		$paymentscheme = PaymentScheme::model()->findAll('status_id = 1');

		foreach($paymentscheme as $ps) {
			echo "<option value ='".$ps->id."'>".$ps->bank_details." (".$ps->bank_account_no.")"."</option>";
		}

	}

}
