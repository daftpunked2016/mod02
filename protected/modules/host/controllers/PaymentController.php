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

		if(isset($_GET['exports'])) {

			foreach ($payments as $res) {
				
				$user = User::model()->find(array('condition'=>'account_id = :id', 'params'=>array(':id'=>$res->account_id)));

				$a[] = array(
					"Full Name" => User::model()->getCompleteName2($user->account_id),
					"Email" => $user->account->username,
					"Chapter" => Chapter::model()->getName($user->chapter_id),
					"Member ID" => $user->member_id,
					"Position" => Position::model()->getName($user->position_id),
					"Picture Filename" => Fileupload::model()->getFileName($user->user_avatar),
				);
			}

			if(count($payments) != 0){
				Account::model()->download_send_headers(str_replace(array('"', "'", ' ', ','), '_', $event->name).date("Y-m-d").".csv");
				echo Account::model()->array2csv($a);
				die();
			}
		}

		if(isset($_GET['profile-pics'])) {

			# define file array
			foreach ($payments as $res) {
				$files[] = Fileupload::model()->getProfilePicture($res->account->user->user_avatar);
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
			header('Content-disposition: attachment; filename='.str_replace(array('"', "'", ' ', ','), '_', $event->name).".zip");
			header('Content-type: application/zip');
			readfile($tmp_file);
			die();
		}

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
