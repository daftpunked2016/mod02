<?php

class EventController extends Controller
{
	public $layout = '/layouts/main';

	public function actionIndex()
	{
		$id = Yii::app()->host->id;
		$host = Host::model()->findByPk($id);
		$event = Event::model()->findByPk($host->event_id);
		$user = User::model()->find(array('condition' => 'account_id ='.$host->account_id));
		$eventpricing = EventPricing::model()->find(array('condition' => 'event_id ='.$event->id));
		$event_ps = EventPS::model()->findAll(array('condition' => 'event_id ='.$event->id));

		$this->render('index', array(
			'event' => $event,
			'host' => $host,
			'user' => $user,
			'eventpricing' => $eventpricing,
			'event_ps' => $event_ps,
		));
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
					        	$this->redirect(array('index'));
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
					$this->redirect(array('index'));
				} 
			}
		else
			$this->redirect(array('index'));
		}
		else
			$this->redirect(array('index'));
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
}