<?php 

class PaymentController extends Controller
{
public $layout = '/layouts/main';

	public function actionPaid()
	{	
		$id = Yii::app()->getModule('host')->user->id;
		$host = Host::model()->findByPk($id);
		$event = Event::model()->findByPk($host->event_id);
		$eventattendees = EventAttendees::model()->paidAttendee()->findAll(array('condition' => 'event_id ='.$event->id));
		$payments = Payments::model()->findAll(array('condition' => 'event_id = '.$event->id.' AND status_id = 1'));

		$attendeesDP=new CArrayDataProvider($eventattendees, array(
			'pagination' => array(
				'pageSize' => 20
			)
		));

		$this->render('paid', array(
			'host' => $host,
			'attendeesDP' => $attendeesDP,
			'event' => $event,
			'payments' => $payments,
		));
	}

	public function actionPending()
	{	
		$id = Yii::app()->getModule('host')->user->id;
		$host = Host::model()->findByPk($id);
		$event = Event::model()->findByPk($host->event_id);
		$eventattendees = EventAttendees::model()->pendingAttendee()->findAll(array('condition' => 'event_id ='.$event->id));
		$payments = Payments::model()->findAll(array('condition' => 'event_id = '.$event->id.' AND status_id = 2'));

		$attendeesDP=new CArrayDataProvider($eventattendees, array(
			'pagination' => array(
				'pageSize' => 20
			)
		));

		$this->render('pending', array(
			'host' => $host,
			'attendeesDP' => $attendeesDP,
			'event' => $event,
			'payments' => $payments,
		));
	}

	public function actionUnpaid()
	{	
		$id = Yii::app()->getModule('host')->user->id;
		$host = Host::model()->findByPk($id);
		$event = Event::model()->findByPk($host->event_id);
		$eventattendees = EventAttendees::model()->unpaidAttendee()->findAll(array('condition' => 'event_id ='.$event->id));

		$attendeesDP=new CArrayDataProvider($eventattendees, array(
			'pagination' => array(
				'pageSize' => 20
			)
		));
		
		$this->render('unpaid', array(
			'host' => $host,
			'attendeesDP' => $attendeesDP,
			'event' => $event,
		));
	}

	public function actionReject()
	{	
		$id = Yii::app()->getModule('host')->user->id;
		$host = Host::model()->findByPk($id);
		$event = Event::model()->findByPk($host->event_id);
		$eventattendees = EventAttendees::model()->rejectAttendee()->findAll(array('condition' => 'event_id ='.$event->id));
		$payments = Payments::model()->findAll(array('condition' => 'event_id = '.$event->id.' AND status_id = 4'));

		$attendeesDP=new CArrayDataProvider($eventattendees, array(
			'pagination' => array(
				'pageSize' => 20
			)
		));

		$this->render('reject', array(
			'host' => $host,
			'attendeesDP' => $attendeesDP,
			'event' => $event,
			'payments' => $payments,
		));
	}

	public function actionApprovePayment($id)
	{
		$eventattendees = EventAttendees::model()->findByPk($id);
		$billing = Billing::model()->find(array('condition' => 'event_attendees_id ='.$eventattendees->id));
		$payments = Payments::model()->find(array('condition' => 'event_attendees_id ='.$eventattendees->id));

		$sales = new Sales;

		if(!empty($eventattendees)){

			$eventattendees->payment_status = 1;
			$sales->event_attendees_id = $eventattendees->id;
			$sales->event_id = $eventattendees->event_id;
			$sales->date_created = date('Y-m-d' , time());

			if($payments != null){
				$sales->payment_id = $payments->id;
				$sales->total_amount = $payments->amount;
			}else{
				$sales->payment_id = 0;
				$sales->total_amount = 0.00;
			}

			if($eventattendees->save())
			{
				$payments->status_id = 1;
				
				if($payments->save())
				{
					if($sales->save())
					{
						Event::model()->setEmailProp(5, $eventattendees->account_id, $eventattendees->event_id);  //EMAIL NOTIF
						Yii::app()->user->setFlash('success','You have successfully approve the payment!');
						$this->redirect(array('pending'));
					}
				}
								
			}else{
				Yii::app()->user->setFlash('error','An error occured while trying to approve the payment of this account. Please try again later.');
				$this->redirect(array('pending'));
			}
		}
	}

	public function actionMoveToPending($id, $status) //1 for approved, 2 for rejected
	{
		$eventattendees = EventAttendees::model()->findByPk($id);
		$payments = Payments::model()->find(array('condition' => 'event_attendees_id ='.$eventattendees->id));
		$sales = Sales::model()->find(array('condition' => 'event_attendees_id ='.$eventattendees->id));

		if(!empty($eventattendees))
		{
			$eventattendees->payment_status = 2;

			if($eventattendees->save())
			{
				$payments->status_id = 2;
				if($payments->save())
				{
					if($sales != null)
					{
						$sales->delete();

						if($sales->save()){
							Yii::app()->user->setFlash('success','You have successfully move the payment to pending!');
							if($status == 1){
								$this->redirect(array('paid'));
							}
							else{
								$this->redirect(array('reject'));
							}
						}
					}else
					{
						Yii::app()->user->setFlash('success','You have successfully move the payment to pending!');
						if($status == 1){
							$this->redirect(array('paid'));
						}
						else{
							$this->redirect(array('reject'));
						}
					}
				}
			}
			else
			{
				Yii::app()->user->setFlash('error','An error occured while trying to move the payment of this account to pending. Please try again later.');
				if($status == 1)
					$this->redirect(array('paid'));
				else
					$this->redirect(array('reject'));
			}
		}
	}

	public function actionRejectPayment($id)
	{
		$eventattendees = EventAttendees::model()->findByPk($id);
		$payments = Payments::model()->find(array('condition' => 'event_attendees_id ='.$eventattendees->id));

		if(!empty($eventattendees)){
			$eventattendees->payment_status = 4;
			$payments->status_id = 4;

			if($eventattendees->save())
			{
				if($payments->save())
				{
					Event::model()->setEmailProp(6, $eventattendees->account_id, $eventattendees->event_id);  //EMAIL NOTIF
					Yii::app()->user->setFlash('success','You have successfully reject the payment of this account!');
					$this->redirect(array('pending'));
				}
			}else{
				Yii::app()->user->setFlash('error','An error occured while trying to reject the payment of this account to pending. Please try again later.');
				$this->redirect(array('pending'));
			}
		}
	}

	public function actionViewBSPDF($event_id, $account_id)
	{
		$account = Account::model()->findByPk($account_id);
		$event_attendee = EventAttendees::model()->find("account_id = ".$account_id." AND event_id = ".$event_id);

		if($account != null)
		{
			header("Location: ".Yii::app()->baseUrl."/pdfs/".$event_attendee->id."_Billing_Statement.pdf");
		}
		else
		{
			Yii::app()->user->setFlash('error','There\'s an error in showing your billing statement. Please try again later.');
			$this->redirect(array('site/index')); 
		}
	}
}
